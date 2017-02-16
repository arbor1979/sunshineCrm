<?php
ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL);

// display warnings and errors
error_reporting(E_WARNING | E_ERROR);


require_once('../include.inc.php');
//
$GLOBAL_SESSION=returnsession();
$common_html=returnsystemlang('common_html');
//print_R($_GET);
//print_R($_POST);
print "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=gb2312\">
<LINK href=\"../../../theme/9/style.css\" rel=stylesheet>";
$_POST['MACHINE_CODE']==''?exit:'';
//print $_POST['MACHINE_CODE']."<br>";
$machinecode=machinecode_sunshine_512_2000($_POST['MACHINE_CODE']);
//print $machinecode."<br>";
//print $_POST['REGISTER_CODE'];
if($machinecode==$_POST['REGISTER_CODE'])		{
	$filename='license.ini';
	@unlink($filename);
	$somecontent="[section]\n MACHINE_CODE=".$_POST['MACHINE_CODE']."\n REGISTER_CODE=".$_POST['REGISTER_CODE']."\n SERVER_NAME=".$_POST['SERVER_NAME']."\n SCHOOL_NAME=".$_POST['SCHOOL_NAME']."";
	@!$handle = fopen($filename, 'w');
	if (!fwrite($handle, $somecontent)) {
		exit;
	}
	fclose($handle);
	page_css('Register');
	$common_text['zh']='注册成功!';
	$common_text['en']='Register successful!';
	require_once('../Enginee/newai_executesql.php');
	returnRegisterExpireUserNumber();
	print_infor($common_text[$systemlang],'trip',"location='register.php'");
	//print "<div align=center><input type=button class=SmallButton value='返回' onClick=\"location='register.php'\" /></div>";
}
else		{
	$common_text['zh']='注册失败!';
	$common_text['en']='Register failed!';
	page_css('Register');
	print_infor($common_text[$systemlang],'trip',"location='register.php'");
	//print "<div align=center><input type=button class=SmallButton value='返回' onClick=\"location='register.php'\" /></div>";
}


?>