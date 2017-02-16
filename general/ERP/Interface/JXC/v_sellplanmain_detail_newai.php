<?php
	ini_set('display_errors', 1);
	ini_set('error_reporting', E_ALL);
	error_reporting(E_WARNING | E_ERROR);
	require_once('lib.inc.php');
	$GLOBAL_SESSION=returnsession();
	validateMenuPriv("销售单明细");

	/*
	if($_GET['action']=="add_default_data")		{
		//print_R($_GET);print_R($_POST);//exit;
		global $db;
		$入库数量 = (int)$_POST['入库数量'];$教材编号 = $_POST['教材编号'];
		$sql = "update edu_jiaocai set 现有库存=现有库存+$入库数量 where 教材编号='".$教材编号."'";
		$rs = $db->Execute($sql);//print $sql;exit;
		$_POST['编作者'] = returntablefield("edu_jiaocai","教材编号",$教材编号,"编作者");
		$_POST['出版社'] = returntablefield("edu_jiaocai","教材编号",$教材编号,"出版社");
		//print  "<META HTTP-EQUIV=REFRESH CONTENT='0;URL=?'>";
	}
	*/

	//数据表模型文件,对应Model目录下面的v_sellplanmain_detail_newai.ini文件
	//如果是需要复制此模块,则需要修改$parse_filename参数的值,然后对应到Model目录 新文件名_newai.ini文件
	$SYSTEM_ADD_SQL =getCustomerRoleByCustID($SYSTEM_ADD_SQL,"supplyid");
	if($_GET['当前搜索方式']=='')
	{
		$_GET['当前搜索方式']='当天';
		$_GET['开始时间ADD']=date("Y-m-d",mktime(0,0,1,date("m"),date("d"),date("Y")));
		$_GET['结束时间ADD']=date("Y-m-d",mktime(0,0,1,date("m"),date("d"),date("Y")));
	}
	$SYSTEM_ADD_SQL =getRoleByUser($SYSTEM_ADD_SQL,"user_id");
	if($_SESSION['LOGIN_USER_PRIV']=='3')
	    $SYSTEM_ADD_SQL=$SYSTEM_ADD_SQL." and jine<100 ";
	addShortCutByDate("selltime","创建时间");
	$filetablename		=	'v_sellplanmain_detail';
	$parse_filename		=	'v_sellplanmain_detail';
	require_once('include.inc.php');
	?>