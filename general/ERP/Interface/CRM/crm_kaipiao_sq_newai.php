<?php
	ini_set('display_errors', 1);
	ini_set('error_reporting', E_ALL);
	error_reporting(E_WARNING | E_ERROR);
	require_once('lib.inc.php');
	$GLOBAL_SESSION=returnsession();


    addShortCutByDate("申请日期");
    //CRM系统过滤个人权限();

	$SYSTEM_ADD_SQL = " and 录单员='".$_SESSION['LOGIN_USER_ID']."'";
	//$SYSTEM_PRINT_SQL = 1;

	if($_GET['action']=="edit_default_data")		{

		page_css("开票申请");

		$单号 = $_POST['单号'];
		$sql = "select * from crm_kaipiao_sq where 单号='$单号'";
		$rs = $db->Execute($sql);
		$rs_a = $rs->GetArray();

		if($rs_a[0]['是否审核'] == 1 && 0){
			print "
			<div align=\"center\" title=\"审核记录管理\">
			<table class=\"MessageBox\" align=\"center\" width=\"650\"><tr><td class=\"msg info\">
			<div class=\"content\" style=\"font-size:12pt\">&nbsp;&nbsp;此项记录已经通过审核，系统禁止编辑操作.</div>
			</td></tr></table>
			<br>
			<div align=center>
			";
			  print "<input type=button  value=\"返回\" class=\"SmallButton\" onClick=\"history.go(-2);\">
			</div>
			";
		   exit;

		}

		if($rs_a[0]['是否作废'] == 1){
		   print "
			<div align=\"center\" title=\"作废记录管理\">
			<table class=\"MessageBox\" align=\"center\" width=\"650\"><tr><td class=\"msg info\">
			<div class=\"content\" style=\"font-size:12pt\">&nbsp;&nbsp;此项记录已经作废，系统禁止操作.</div>
			</td></tr></table>
			<br>
			<div align=center>
			";
			  print "<input type=button  value=\"返回\" class=\"SmallButton\" onClick=\"history.go(-2);\">
			</div>
			";
		   exit;
		}
	}



	$filetablename		=	'crm_kaipiao_sq';
	$parse_filename		=	'crm_kaipiao_sq';
	require_once('include.inc.php');

	if($_GET['action']==''||$_GET['action']=='init_default'||$_GET['action']=='init_customer')		{
			$PrintText .= "<BR><table  class=TableBlock align=center width=100%>";
			$PrintText .= "<TR class=TableContent><td ><font color=green >
			说明：<br>
			&nbsp;&nbsp;&nbsp;1、新增开票单后，在没有通过审核之前可以进行修改操作。<BR>
			&nbsp;&nbsp;&nbsp;2、审核和退回是由总经理进行操作的，只有总经理有审核和退回的权限。<BR>
			&nbsp;&nbsp;&nbsp;3、单子审核或退回后，系统不允许再对其进行操作。<BR>
			</font></td></table>";
			print $PrintText;
		}

	?>
	<?php
/*
	版权归属:郑州单点科技软件有限公司;
	联系方式:0371-69663266;
	公司地址:河南郑州经济技术开发区第五大街经北三路通信产业园四楼西南;
	公司简介:郑州单点科技软件有限公司位于中国中部城市-郑州,成立于2007年1月,致力于把基于先进信息技术（包括通信技术）的最佳管理与业务实践普及到教育行业客户的管理与业务创新活动中，全面提供具有自主知识产权的教育管理软件、服务与解决方案，是中部最优秀的高校教育管理软件及中小学校管理软件提供商。目前已经有多家高职和中职类院校使用通达中部研发中心开发的软件和服务;

	软件名称:单点科技软件开发基础性架构平台,以及在其基础之上扩展的任何性软件作品;
	发行协议:数字化校园产品为商业软件,发行许可为LICENSE方式;单点CRM系统即SunshineCRM系统为GPLV3协议许可,GPLV3协议许可内容请到百度搜索;
	特殊声明:软件所使用的ADODB库,PHPEXCEL库,SMTARY库归原作者所有,余下代码沿用上述声明;
	*/
?>