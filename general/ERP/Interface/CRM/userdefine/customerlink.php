<?php
//##########################################################
//格式：_add _view _Value		说明性表述方式
//userDefineInforStatus_add		新增与编辑的函数编制，两个参数：前者为数组图，后者为字段索引值
//userDefineInforStatus_view	查阅视图函数说明
//userDefineInforStatus_Value	列表视图说明
//#########################################################
//提供资产管理部分中资产状态的部分信息设定。
//#########################################################
$customerlink = "客户关系管理中连接到其它操作";
function customerlink_Value($fieldvalue,$fields,$i)		{
	global $db;
	global $tablename,$html_etc,$common_html;
	$Text = "";
	$客户名称 = strip_tags($fields['value'][$i]['客户名称']);
	$客户简称 = strip_tags($fields['value'][$i]['客户简称']);

	$Text .= $客户简称."(";

	$Text .= "<a class=OrgAdd href=\"crm_expense_newai.php?".base64_encode("action=add_default&客户名称=$客户名称&客户名称_NAME=客户名称&客户名称_disabled=disabled")."\">费用</a> ";
	$Text .= "<a class=OrgAdd href=\"crm_service_newai.php?".base64_encode("action=add_default&客户名称=$客户名称&客户名称_NAME=客户名称&客户名称_disabled=disabled")."\">服务</a> ";
	$Text .= "<a class=OrgAdd href=\"crm_order_newai.php?".base64_encode("action=add_default&客户名称=$客户名称&客户名称_NAME=客户名称&客户名称_disabled=disabled")."\">订单</a> ";
	$Text .= "<a class=OrgAdd href=\"crm_contract_newai.php?".base64_encode("action=add_default&客户名称=$客户名称&客户名称_NAME=客户名称&客户名称_disabled=disabled")."\">合同</a> ";



	$Text .= ")";


	return $Text;
}
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