<?php
	ini_set('display_errors', 1);
	ini_set('error_reporting', E_ALL);
	error_reporting(E_WARNING | E_ERROR);
	require_once('lib.inc.php');
	$GLOBAL_SESSION=returnsession();
	
	if($_GET['action']=="add_default_data")		{
	//print_R($_GET);
		//echo "<br>";
		//print_R($_POST);

		$物资编号 = $_POST['物资编号'];
		$所属部门 = $_POST['所属部门'];
		$借领数量 = $_POST['数量'];
		$出入库类型 = "在库";
		$sql = "select * from wu_materialsequipment where 物资编号='$物资编号'and 所属部门='$所属部门' and 出入库类型='$出入库类型'";
		$result = $db->Execute($sql);
		$rs_a = $result->GetArray();

		$数量 = $rs_a[0]['数量'];

		$num = $数量-$借领数量;
		$upd = "update wu_materialsequipment set 数量='$num' where 物资编号='$物资编号'and 所属部门='$所属部门' and 出入库类型='$出入库类型'";

		$db->Execute($upd);
	}

	//数据表模型文件,对应Model目录下面的wu_materialsequipment_newai.ini文件
	//如果是需要复制此模块,则需要修改$parse_filename参数的值,然后对应到Model目录 新文件名_newai.ini文件

    
    if($_GET['出入库类型'] = "借领"){

	$filetablename		=	'wu_materialsequipment';
	$parse_filename		=	'wu_materialsequipmentj';
	require_once('include.inc.php');

	}
	?>