<?php
	ini_set('display_errors', 1);
	ini_set('error_reporting', E_ALL);
	error_reporting(E_WARNING | E_ERROR);
	require_once('lib.inc.php');
	$GLOBAL_SESSION=returnsession();
	$SYSTEM_PRIV_STOP = "1";
	validateMenuPriv("客户服务");
	
	$customerid=$_GET['customerid'];
	if($customerid!='' && $_GET['action']=='add_default')
	{
		$ADDINIT=array("客户名称"=>$customerid);
	}
	if($_GET['action']=="workplan")		{
		$crm_servInfo=returntablefield("crm_service", "编号", $_GET['编号'], "服务编号,客户名称,解决人员");
		$servertype=returntablefield("crm_dict_servicetypes", "编号", $crm_servInfo['服务编号'], "名称");
		$custName=returntablefield("customer", "rowid", $crm_servInfo['客户名称'], "supplyname");
		$content=urlencode($crm_servInfo['解决人员']);
		$guanlianurl=urlencode("../JXC/crm_service_newai.php?action=view_default&编号=".$_GET['编号']);
		$guanlianshiwu="客户服务";
		$guanlianid=$_GET['编号'];
		$zhuti="处理$servertype-$custName";
		print "<script>location.href='../CRM/workplanmain_newai.php?action=add_default&zhuti=$zhuti&content=".$content."&guanlianshiwu=$guanlianshiwu&guanlianurl=$guanlianurl&guanlianid=$guanlianid';</script>";
		exit;
	}
	$SYSTEM_ADD_SQL =getCustomerRoleByCustID($SYSTEM_ADD_SQL,"客户名称");
	$limitEditDelCust='客户名称';
	addShortCutByDate("创建时间","创建时间");
	//数据表模型文件,对应Model目录下面的crm_service_newai.ini文件
	//如果是需要复制此模块,则需要修改$parse_filename参数的值,然后对应到Model目录 新文件名_newai.ini文件
	$filetablename		=	'crm_service';
	$parse_filename		=	'crm_service';
	require_once('include.inc.php');
	?><?php
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