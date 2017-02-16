<?php
	ini_set('display_errors', 1);
	ini_set('error_reporting', E_ALL);
	error_reporting(E_WARNING | E_ERROR);
	require_once('lib.inc.php');
	$GLOBAL_SESSION=returnsession();
	validateMenuPriv("销售单查询");
	if($_GET['action']=='')
	{
		print "<script language=\"javascript\" src=\"../LODOP60/LodopFuncs_new.js\"></script><script>LODOP=getLodop();</script>";
	}
	if($_GET['action']=="printXiaoPiao")	
	{
		print "<script>location='sellonemain_newai.php?action=printXiaoPiao&billid=".$_GET['billid']."'</script>";
		exit;
	}
	
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

	//数据表模型文件,对应Model目录下面的v_sellone_search_newai.ini文件
	//如果是需要复制此模块,则需要修改$parse_filename参数的值,然后对应到Model目录 新文件名_newai.ini文件
	$filetablename		=	'v_sellone_search';
	$parse_filename		=	'v_sellone_search';
	$realtablename="sellplanmain";
	$SYSTEM_ADD_SQL =getCustomerRoleByCustID($SYSTEM_ADD_SQL,"supplyid");
	$SYSTEM_ADD_SQL =getRoleByUser($SYSTEM_ADD_SQL,"user_id");
	//if($_SESSION['LOGIN_USER_PRIV']=='3')
	//    $SYSTEM_ADD_SQL=$SYSTEM_ADD_SQL." and totalmoney<1500 and supplyid in (select ROWID from customer where state=16)";
	
	$limitEditDelCust='supplyid';
	

	addShortCutByDate("createtime","制单时间","当天");
	require_once('include.inc.php');
	print "<iframe name='hideframe' width=0 height=0 border=0 src=''/>";
	?>