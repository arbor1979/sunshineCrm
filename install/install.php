<?php
error_reporting(0);
@set_time_limit(1000);

if(phpversion() < '5.3.0') set_magic_quotes_runtime(0);

if(phpversion() < '5.2.0') exit('����php�汾���ͣ����ܰ�װ���������������5.2.0����߰汾�ٰ�װ��лл��');
if(!defined(ROOT_DIR))
{
	$baseUrl = str_replace('\\','/',dirname($_SERVER['SCRIPT_NAME'])); 
	$baseUrl = empty($baseUrl) ? '/' : '/'.trim($baseUrl,'/').'/';  
	$dirArray=explode("general", $baseUrl);
	$ROOT_DIR=str_replace("\\", "/",$dirArray[0]);
	define("ROOT_DIR",$ROOT_DIR);
	
	if(empty($_SERVER['DOCUMENT_ROOT']) && !empty($_SERVER['SCRIPT_FILENAME'])) { 
	    $_SERVER['DOCUMENT_ROOT'] = str_replace( '\\', '/', substr($_SERVER['SCRIPT_FILENAME'], 0, 0 - strlen($_SERVER['PHP_SELF']))); 
	} 
	if(empty($_SERVER['DOCUMENT_ROOT']) && !empty($_SERVER['PATH_TRANSLATED'])) { 
	    $_SERVER['DOCUMENT_ROOT'] = str_replace( '\\', '/', substr(str_replace('\\\\', '\\', $_SERVER['PATH_TRANSLATED']), 0, 0 - strlen($_SERVER['PHP_SELF']))); 
	}
	$DOCUMENT_ROOT=str_replace("\\", "/",$_SERVER['DOCUMENT_ROOT']);
	if(substr($DOCUMENT_ROOT,-1)=="/")
		$DOCUMENT_ROOT=substr($DOCUMENT_ROOT,0,strlen($DOCUMENT_ROOT)-1);
	
	$DOCUMENT_ROOT=$DOCUMENT_ROOT.$ROOT_DIR;
	define("DOCUMENT_ROOT",$DOCUMENT_ROOT);
}
define("CHARSET","gbk");
require_once 'global.func.php';

$steps=array(
'1'=>'��װ���Э��',
'2'=>'���л������',
'3'=>'�ļ�Ȩ������',
'4'=>'�ʺ�����',
'5'=>'��װ��ϸ����',
'6'=>'��װ���'
);
if(!isset($_REQUEST['step']))
	$_REQUEST['step']=1;
$reg_sso_status='';
$no_writablefile=0;
$selectmod='';
$testdata='';
$install_phpsso='';
$step = trim($_REQUEST['step']) ? trim($_REQUEST['step']) : 1;
$pos = strpos(get_url(),'install/install.php');
$siteurl = substr(get_url(),0,$pos);
if(strrpos(strtolower(PHP_OS),"win") === FALSE) {
	define('ISUNIX', TRUE);
} else {
	define('ISUNIX', FALSE);
}

$mode = 0777;

switch($step)
{
    case '1': //��װ���Э��
		if(file_exists('install.lock')) exit('���Ѿ���װ������CRM,�����Ҫ���°�װ����ɾ�� /install/install.lock �ļ���');
		$license = file_get_contents("license.txt");
		include "step/step".$step.".tpl.php";

		break;
	
	case '2':  //������� (FTP�ʺ����ã�
        $PHP_GD  = '';
		if(extension_loaded('gd')) {
			if(function_exists('imagepng')) $PHP_GD .= 'png';
			if(function_exists('imagejpeg')) $PHP_GD .= ' jpg';
			if(function_exists('imagegif')) $PHP_GD .= ' gif';
		}
		$PHP_JSON = '0';
		if(extension_loaded('json')) {
			if(function_exists('json_decode') && function_exists('json_encode')) $PHP_JSON = '1';
		}
		//�¼�fsockopen �����ж�,�˺���Ӱ�찲װ���Աע�ἰ��¼������
		if(function_exists('fsockopen')) {
			$PHP_FSOCKOPEN = '1';
		}
        $PHP_DNS = preg_match("/^[0-9.]{7,15}$/", @gethostbyname('www.dandian.net')) ? 1 : 0;
		//�Ƿ�����CRM��װ����
		$is_right = (phpversion() >= '5.2.0' && extension_loaded('mysqli') && $PHP_JSON && $PHP_GD) ? 1 : 0;		
		include "step/step".$step.".tpl.php";
		break;

	
	case '3': //���Ŀ¼����
		
		
		$chmod_file = 'chmod_unsso.txt';
		
		$files = file($chmod_file);		
		foreach($files as $_k => $file) {
			$file = str_replace('*','',$file);
			$file = trim($file);
			if(is_dir($file)) {
				$is_dir = '1';
				$cname = 'Ŀ¼';
				//���������Ŀ¼Ȩ�ޣ��¼Ӻ���
				$write_able = writable_check("../".$file);
			} else {
				$is_dir = '0';
				$cname = '�ļ�';
			}
			//�µ��ж�
			
			if($is_dir =='0' && is_writable("../".$file)) {
				$is_writable = 1;
			} elseif($is_dir =='1' && dir_writeable("../".$file)){
				$is_writable = $write_able;
				if($is_writable=='0'){
					$no_writablefile = 1;
				}
			}else{
				$is_writable = 0;
 				$no_writablefile = 1;
  			}
							
			$filesmod[$_k]['file'] = $file;
			$filesmod[$_k]['is_dir'] = $is_dir;
			$filesmod[$_k]['cname'] = $cname;			
			$filesmod[$_k]['is_writable'] = $is_writable;
		}
		if(dir_writeable("./")) {
			$is_writable = 1;
		} else {
			$is_writable = 0;
		}
		$filesmod[$_k+1]['file'] = '��վ��Ŀ¼';
		$filesmod[$_k+1]['is_dir'] = '1';
		$filesmod[$_k+1]['cname'] = 'Ŀ¼';			
		$filesmod[$_k+1]['is_writable'] = $is_writable;						
		include "step/step".$step.".tpl.php";
		break;

	case '4': //�����ʺ� ��MYSQL�ʺš�����Ա�ʺš���
		
		include "step/step".$step.".tpl.php";
		break;

	case '5': //��װ��ϸ����
		extract($_POST);
		$testdata = $_POST['testdata'];
		include "step/step".$step.".tpl.php";
		break;

	case '6': //��ɰ�װ
		$configfile =  'install.lock';	
		if(!file_exists($configfile)) 
		{
			file_put_contents($configfile,"1");
		}
		include "step/step".$step.".tpl.php";
		//ɾ����װĿ¼
		//delete_install('./');
		break;
	
	case 'installmodule': //ִ��SQL
			extract($_POST);
			$lnk = mysql_connect($dbhost, $dbuser, $dbpw) or die ('Not connected : ' . mysql_error());
			$version = mysql_get_server_info();

			if($version > '4.1') {
				mysql_query("SET NAMES gbk");
			}
			
			if($version > '5.0') {
				mysql_query("SET sql_mode=''");
			}
												
			if(!@mysql_select_db($dbname)){
				@mysql_query("CREATE DATABASE $dbname");
				if(@mysql_error()) {
					echo 1;exit;
				} else {
					mysql_select_db($dbname);
				}
			}
			$dbfile =  'crm_db.sql';	
			if(file_exists("main/".$dbfile)) 
			{
				
		        $file = @file("main/".$dbfile);
				for($index=0;$index<count($file);$index++)
				{
					
					if(substr(trim($file[$index]),0,2)=='--')
						$file[$index]='';
				}
		        $fileText = join('',$file);
				$FileArray = explode(";\r\n",$fileText);
		        for($i=0;$i<sizeof($FileArray);$i++)       
		        {
		            $sql = TRIM($FileArray[$i]);
					$sql=iconv("UTF-8", "GBK", $sql); 
					$sql = preg_replace("/��/",";",$sql);
					mysql_query($sql);
					
				}

				mysql_query("update user set password='".crypt($password)."',email='".$email."' where uid=1");
				
			} else {
				echo '2';//���ݿ��ļ�������
			}							
		
		break;
	//�޸������ļ�
	case 'modifyconfig':
		extract($_GET);
		$configfile =  'config.inc.php';	
		if(file_exists("../general/ERP/".$configfile)) 
		{
			
			$file = @file("../general/ERP/".$configfile);
			for($index=0;$index<count($file);$index++)
			{
				
				if(strstr($file[$index],'$localhost ='))
					$file[$index]='$localhost ="'.$dbhost.'";'."\r\n";
				else if(strstr($file[$index],'$userdb_name ='))
					$file[$index]='$userdb_name ="'.$dbuser.'";'."\r\n";
				else if(strstr($file[$index],'$userdb_pwd ='))
					$file[$index]='$userdb_pwd ="'.$dbpw.'";'."\r\n";
				else if(strstr($file[$index],'$userdb ='))
					$file[$index]='$userdb ="'.$dbname.'";'."\r\n";
			}
			$fileText = join('',$file);
			file_put_contents("../general/ERP/".$configfile,$fileText);
		}	
		$configfile =  'index.html';	
		if(file_exists("../".$configfile)) 
		{
			$fileText="<meta http-equiv=\"REFRESH\" content=\"0;URL=general/ERP/LOGIN/\">";
			file_put_contents("../".$configfile,$fileText);
		}
		
		break;
	
	//��װ��������	
	case 'testdata':
		extract($_GET);
		$lnk = mysql_connect($dbhost, $dbuser, $dbpw) or die ('Not connected : ' . mysql_error());
		
		$version = mysql_get_server_info();			
		if($version > '4.1' && $dbcharset) {
			mysql_query("SET NAMES gbk");
		}			
		if($version > '5.0') {
			mysql_query("SET sql_mode=''");
		}			
		mysql_select_db($dbname);
		if(file_exists("main/testsql.sql"))
		{
			mysql_query("SET NAMES gbk");
			$file = @file("main/testsql.sql");
			for($index=0;$index<count($file);$index++)
			{
				if(str_cut(trim($file[$index]),2,'')=='--')
					$file[$index]='';
			}
	        $fileText = join('',$file);
			$FileArray = explode(';',$fileText);
	        for($i=0;$i<sizeof($FileArray);$i++)       
	        {
	            $sql = TRIM($FileArray[$i]);
				$sql = ereg_replace('��',';',$sql);
				mysql_query($sql);
			}
		}
		break;	
		
	//���ݿ����
	case 'dbtest':
		extract($_GET);
		
		if(!@mysql_connect($dbhost, $dbuser, $dbpw)) {
			exit('2');
		}
		$server_info = mysql_get_server_info();
		if($server_info < '4.0') exit('6');
		if(!mysql_select_db($dbname)) {
			if(!@mysql_query("CREATE DATABASE `$dbname`")) exit('3');
			mysql_select_db($dbname);
		}
		$tables = array();
		$query = mysql_query("SHOW TABLES FROM `$dbname`");
		while($r = mysql_fetch_row($query)) {
			$tables[] = $r[0];
		}
		if($tables && in_array($tablepre.'module', $tables)) {
			exit('0');
		}
		else {
			exit('1');
		}
		break;
	
	
}

function format_textarea($string) {
	return nl2br(str_replace(' ', '&nbsp;', htmlspecialchars($string)));
}

function _sql_execute($sql,$r_tablepre = '',$s_tablepre = 'phpcms_') {
    $sqls = _sql_split($sql,$r_tablepre,$s_tablepre);
	if(is_array($sqls))
    {
		foreach($sqls as $sql)
		{
			if(trim($sql) != '')
			{
				mysql_query($sql);
			}
		}
	}
	else
	{
		mysql_query($sqls);
	}
	return true;
}

function _sql_split($sql,$r_tablepre = '',$s_tablepre='phpcms_') {
	global $dbcharset,$tablepre;
	$r_tablepre = $r_tablepre ? $r_tablepre : $tablepre;
	if(mysql_get_server_info > '4.1' && $dbcharset)
	{
		$sql = preg_replace("/TYPE=(InnoDB|MyISAM|MEMORY)( DEFAULT CHARSET=[^; ]+)?/", "ENGINE=\\1 DEFAULT CHARSET=".$dbcharset,$sql);
	}
	
	if($r_tablepre != $s_tablepre) $sql = str_replace($s_tablepre, $r_tablepre, $sql);
	$sql = str_replace("\r", "\n", $sql);
	$ret = array();
	$num = 0;
	$queriesarray = explode(";\n", trim($sql));
	unset($sql);
	foreach($queriesarray as $query)
	{
		$ret[$num] = '';
		$queries = explode("\n", trim($query));
		$queries = array_filter($queries);
		foreach($queries as $query)
		{
			$str1 = substr($query, 0, 1);
			if($str1 != '#' && $str1 != '-') $ret[$num] .= $query;
		}
		$num++;
	}
	return $ret;
}

function dir_writeable($dir) {
	$writeable = 0;
	if(is_dir($dir)) {  
        if($fp = @fopen("$dir/chkdir.test", 'w')) {
            @fclose($fp);      
            @unlink("$dir/chkdir.test"); 
            $writeable = 1;
        } else {
            $writeable = 0; 
        } 
	}
	return $writeable;
}

function writable_check($path){
	$dir = '';
	$is_writable = '1';
	if(!is_dir($path)){return '0';}
	$dir = opendir($path);
 	while (($file = readdir($dir)) !== false){
		if($file!='.' && $file!='..'){
			if(is_file($path.'/'.$file)){
				//���ļ��ж��Ƿ��д������дֱ�ӷ���0�������¼���
				if(!is_writable($path.'/'.$file)){
 					return '0';
				}
			}else{
				//Ŀ¼��ѭ���˺���,���жϴ�Ŀ¼�Ƿ��д������дֱ�ӷ���0 ����д���ж���Ŀ¼�Ƿ��д 
				$dir_wrt = dir_writeable($path.'/'.$file);
				if($dir_wrt=='0'){
					return '0';
				}
   				$is_writable = writable_check($path.'/'.$file);
 			}
		}
 	}
	return $is_writable;
}

function remote_file_exists($url_file){
	$headers = get_headers($url_file);
	if (!preg_match("/200/", $headers[0])){
		return false;
	}
	return true;
}
function delete_install($dir) {
	$dir = dir_path($dir);
	if (!is_dir($dir)) return FALSE;
	$list = glob($dir.'*');
	foreach($list as $v) {
		is_dir($v) ? delete_install($v) : @unlink($v);
	}
    return @rmdir($dir);
}
?>