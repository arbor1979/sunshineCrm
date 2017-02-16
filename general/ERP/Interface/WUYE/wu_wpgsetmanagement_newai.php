<?php
	ini_set('display_errors', 1);
	ini_set('error_reporting', E_ALL);
	error_reporting(E_WARNING | E_ERROR);
	require_once('lib.inc.php');
	$GLOBAL_SESSION=returnsession();
	
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

	//数据表模型文件,对应Model目录下面的wu_wpgsetmanagement_newai.ini文件
	//如果是需要复制此模块,则需要修改$parse_filename参数的值,然后对应到Model目录 新文件名_newai.ini文件
	$filetablename		=	'wu_wpgsetmanagement';
	$parse_filename		=	'wu_wpgsetmanagement';
	require_once('include.inc.php');


	

	if($_GET['action']==''||$_GET['action']=='init_default'||$_GET['action']=='init_customer')		{
			$PrintText .= "<BR><table  class=TableBlock align=center width=100%>";
			$PrintText .= "<TR class=TableContent><td ><font color=green >
			说明：<BR>
			&nbsp;&nbsp;&nbsp;&nbsp;1 本页面设置水、电、气、公摊水、公摊电费的缴费规则以及费用价格。<BR>
			&nbsp;&nbsp;&nbsp;&nbsp;2 设置费用名称和其对应的单价，收费规则，以及说明。<BR>
			&nbsp;&nbsp;&nbsp;&nbsp;3 本页面的规则数据将在水电费收费明细页面进行应用以及计算。<BR>
			</font></td></table>";
			print $PrintText;
		}
	?>