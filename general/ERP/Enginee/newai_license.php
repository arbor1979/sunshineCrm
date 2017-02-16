<?php
//#########################################################################
$companyName = "郑州单点科技软件有限公司";
$LicenseCode = "DD001";
$LicenseDate = "2006-06-27";
//#########################################################################


function return_sql_line($fields)	{
	global $db;
	switch($db->databaseType)		{
		case 'mysql':
			$return_sql_line=return_sql_line_mysql($fields);
			break;
		case 'mssql':
			$return_sql_line=return_sql_line_mssql($fields);
			break;
		case 'oracle':
			$return_sql_line=return_sql_line_oracle($fields);
			break;
		default:
			$return_sql_line=return_sql_line_mysql($fields);
			break;
	}
	return $return_sql_line;
}

//得到机器码　本函数为附函数，不为第一次函数
//第一次函数在Lib/init.php 函数名称：returnmachinecode();
function returnmachinecode_2()			{

//补充说明
@exec("ipconfig /all",$array);

for($Tmpa;$Tmpa<count($array);$Tmpa++){
    if(eregi("Physical",$array[$Tmpa])){
        $getstr = explode(":",$array[$Tmpa]);
        $mac = trim($getstr[1]);
    }
}

$element=explode('-',$mac);

for($i=0;$i<sizeof($element);$i++)		{
	$temp=$element[$i];
	$temp1=strtolower(substr($temp,0,1));
	$temp1=ord($temp1);
	$temp_num=$temp1+3;
	if($temp_num<=122&&$temp_num>=97)	{
		$temp1=$temp_num;
	}
	else if($temp_num<=57&&$temp_num>=48){
		$temp1=$temp_num;
	}
	else		{
		$temp1=$temp_num-3;
	}
	$temp1=chr($temp1);//print $temp1;

	$temp2=strtolower(substr($temp,1,2));
	$temp2=ord($temp2);
	$temp_num=$temp2+3;
	if($temp_num<=122&&$temp_num>=97)	{
		$temp2=$temp_num;
	}
	else if($temp_num<=57&&$temp_num>=48){
		$temp2=$temp_num;
	}
	else		{
		$temp2=$temp_num-3;
	}

	$temp2=chr($temp2);

	$newarray1[$i]=$temp1;
	$newarray2[$i]=$temp2;
}
$string=$newarray1[0].$newarray1[4].$newarray1[3].$newarray1[5].$newarray1[1].$newarray1[2].$newarray2[1].$newarray2[2].$newarray2[5].$newarray2[4].$newarray2[3].$newarray2[0];
return $string;
}

//得到本系统用户数量

function System_user_Number()		{
	global $db;
	$sql = "select Count(*) as NUM from user";
	$rs = $db->CacheExecute(150,$sql);
	$Number = $rs->fields['NUM'];
	return $Number;
}

$SERVER_NAME = $_SERVER['SERVER_NAME'];
$SERVER_PORT = $_SERVER['SERVER_PORT'];
$SERVER_ADDR = $_SERVER['SERVER_ADDR'];
$DOCUMENT_ROOT = ROOT_DIR;
$SERVER_NAME = $_SERVER['SERVER_NAME'];


/*
if(date("H")=="11")		{
	$MACHINE_CODE = returnmachinecode_2();
	$SYSETM_USER = System_user_Number();
	$ServerInforString = "&SERVER_NAME=$SERVER_NAME&SERVER_PORT=$SERVER_PORT&SERVER_ADDR=$SERVER_ADDR&DOCUMENT_ROOT=$DOCUMENT_ROOT";
	$LicenseURL = "companyName=$companyName&LicenseCode=$LicenseCode&LicenseDate=$LicenseDate";
	$LicenseURL = $LicenseURL.$ServerInforString."&MACHINE_CODE=$MACHINE_CODE&SYSETM_USER=$SYSETM_USER";
	$LicenseURL = base64_encode($LicenseURL);
	//print $LicenseURL;
	$OpenURL = "http://www.dandian.net/tryout/licenseAccess.php";
	$OpenURL = $OpenURL."?".$LicenseURL;
	$PHP_SELF_ARRAY = explode('/',$_SERVER['PHP_SELF']);
	$IndexName = sizeof($PHP_SELF_ARRAY)-1;
	$IndexArray = array("menu.php","status_bar.php","user_online.php","user_all.php","","");
	if(in_array($PHP_SELF_ARRAY[$IndexName],$IndexArray))	{
	}
	else	{
		if($_GET['action']=='init_default')	{
			print "<IFRAME src=\"$OpenURL\" width=0 height=0></IFRAME>";
		}
	}
}

*/

?>