<?php
error_reporting(0);
@set_time_limit(1000);

if(phpversion() < '5.3.0') set_magic_quotes_runtime(0);

if(phpversion() < '5.2.0') exit('您的php版本过低，不能安装本软件，请升级到5.2.0或更高版本再安装，谢谢！');
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
'1'=>'安装许可协议',
'2'=>'运行环境检测',
'3'=>'文件权限设置',
'4'=>'帐号设置',
'5'=>'安装详细过程',
'6'=>'安装完成'
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
    case '1': //安装许可协议
		if(file_exists('install.lock')) exit('您已经安装过单点CRM,如果需要重新安装，请删除 /install/install.lock 文件！');
		$license = file_get_contents("license.txt");
		include "step/step".$step.".tpl.php";

		break;
	
	case '2':  //环境检测 (FTP帐号设置）
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
		//新加fsockopen 函数判断,此函数影响安装后会员注册及登录操作。
		if(function_exists('fsockopen')) {
			$PHP_FSOCKOPEN = '1';
		}
        $PHP_DNS = preg_match("/^[0-9.]{7,15}$/", @gethostbyname('www.dandian.net')) ? 1 : 0;
		//是否满足CRM安装需求
		$is_right = (phpversion() >= '5.2.0' && extension_loaded('mysqli') && $PHP_JSON && $PHP_GD) ? 1 : 0;		
		include "step/step".$step.".tpl.php";
		break;

	
	case '3': //检测目录属性
		
		
		$chmod_file = 'chmod_unsso.txt';
		
		$files = file($chmod_file);		
		foreach($files as $_k => $file) {
			$file = str_replace('*','',$file);
			$file = trim($file);
			if(is_dir($file)) {
				$is_dir = '1';
				$cname = '目录';
				//继续检查子目录权限，新加函数
				$write_able = writable_check("../".$file);
			} else {
				$is_dir = '0';
				$cname = '文件';
			}
			//新的判断
			
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
		$filesmod[$_k+1]['file'] = '网站根目录';
		$filesmod[$_k+1]['is_dir'] = '1';
		$filesmod[$_k+1]['cname'] = '目录';			
		$filesmod[$_k+1]['is_writable'] = $is_writable;						
		include "step/step".$step.".tpl.php";
		break;

	case '4': //配置帐号 （MYSQL帐号、管理员帐号、）
		
		include "step/step".$step.".tpl.php";
		break;

	case '5': //安装详细过程
		extract($_POST);
		$testdata = $_POST['testdata'];
		include "step/step".$step.".tpl.php";
		break;

	case '6': //完成安装
		$configfile =  'install.lock';	
		if(!file_exists($configfile)) 
		{
			file_put_contents($configfile,"1");
		}
		include "step/step".$step.".tpl.php";
		//删除安装目录
		//delete_install('./');
		break;
	
	case 'installmodule': //执行SQL
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
					$sql = preg_replace("/；/",";",$sql);
					mysql_query($sql);
					
				}

				mysql_query("update user set password='".crypt($password)."',email='".$email."' where uid=1");
				
			} else {
				echo '2';//数据库文件不存在
			}							
		
		break;
	//修改配置文件
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
	
	//安装测试数据	
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
				$sql = ereg_replace('；',';',$sql);
				mysql_query($sql);
			}
		}
		break;	
		
	//数据库测试
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
				//是文件判断是否可写，不可写直接返回0，不向下继续
				if(!is_writable($path.'/'.$file)){
 					return '0';
				}
			}else{
				//目录，循环此函数,先判断此目录是否可写，不可写直接返回0 ，可写再判断子目录是否可写 
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