<?php 
SESSION_START();
require_once("lib.inc.php");
$GLOBAL_SESSION=returnsession();

	$leftmenu=$_GET['leftmenu'];
	$rightmenu=$_GET['rightmenu'];
	$sql="update user set `leftmenu`='$leftmenu',`rightmenu`='$rightmenu' where `USER_ID`='".$_SESSION['LOGIN_USER_ID']."'";
	$db->Execute($sql);
	$_SESSION['LEFT_MENU']=$leftmenu;
	$_SESSION['RIGHT_MENU']=$rightmenu;
	
?>