<?php
	ini_set('display_errors', 1);
	ini_set('error_reporting', E_ALL);
	error_reporting(E_WARNING | E_ERROR);
	require_once('lib.inc.php');
	$GLOBAL_SESSION=returnsession();

    
    

	if($_GET['action']=="add_default_data")		{
	
		//print_r($_POST);
		$投诉序号 = $_POST['投诉序号'];
		$单元编号 = $_POST['单元编号'];
		$投诉人   = $_POST['投诉人'];
        

        $sql = "delete from wu_usercomplaints where 投诉序号='$投诉序号' and 单元编号='$单元编号' and 投诉人='$投诉人' and 是否受理='未受理'";

		$db->Execute($sql);

	} 
    
    
	$_GET['是否受理'] = "已受理";
	$_GET['是否处理'] = "否";
	
	

	$filetablename		=	'wu_usercomplaints';
	$parse_filename		=	'wu1_usercomplaints';
	require_once('include.inc.php');

	?>