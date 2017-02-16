<?php
//##########################################################
//格式：_add _view _Value		说明性表述方式
//userDefineInforStatus_add		新增与编辑的函数编制，两个参数：前者为数组图，后者为字段索引值
//userDefineInforStatus_view	查阅视图函数说明
//userDefineInforStatus_Value	列表视图说明
//#########################################################
//提供用户自定义类型：用于增加和编辑数据时
$jineinput = "用于产品数量,执行销售价格,与应收金额之间的联动关系,在新建和编辑视图";
function jineinput_add($fields,$i)		{
	global $db;	
	global $tablename,$html_etc,$common_html;
	$fieldname	= $fields['name'][$i];
	$产品数量	= '1';
	$执行销售价格 = $fields['value']['执行销售价格'];
	$应收金额	= $fields['value']['应收金额'];
	$showtext  = $html_etc[$tablename][$fieldname];
	print "
	<script>
	function DoItInforJinEr()		{
		var 产品数量 = document.form1.产品数量.value;
		var 执行销售价格 = document.form1.执行销售价格.value;
		var 应收金额 = 产品数量*执行销售价格;
		var 处理后应收金额 = Math.round(应收金额*100)/100;
		//alert(产品数量);alert(执行销售价格);alert(应收金额);
		document.form1.应收金额.value = 处理后应收金额;

		var 实收金额 = document.form1.实收金额.value;
		var 优惠金额 = document.form1.优惠金额.value;
		var 实收金额 = 处理后应收金额-优惠金额;
		document.form1.实收金额.value = 实收金额;
	}
	</script>
<TR>
<TD class=TableData noWrap width=20%>执行销售价格:</TD>
<TD class=TableData noWrap colspan=\"2\"><INPUT type=\"text\" title='' onkeydown=\"if(event.keyCode==13)event.keyCode=9\" accesskey='7' class=\"SmallInput\"  maxLength=200 size=\"30\" name=\"执行销售价格\" value=\"$执行销售价格\" onkeyup=\"check_input_num('MONEY');DoItInforJinEr();\"
>&nbsp;&nbsp;(如:3.36元)
</TD></TR>
<TR>
<TD class=TableData noWrap width=20%>产品数量:</TD>
<TD class=TableData noWrap colspan=\"2\"><INPUT type=\"text\" title='' onkeydown=\"if(event.keyCode==13)event.keyCode=9\" accesskey='6' class=\"SmallInput\"  maxLength=200 size=\"30\" name=\"产品数量\" value=\"$产品数量\"  onkeyup=\"value=value.replace(/[^\d]/g,'');DoItInforJinEr();\"  onbeforepaste=\"clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''));DoItInforJinEr();\"  >&nbsp;
(注:只能输入数字)</TD></TR>

<TR><TD class=TableData noWrap>应收金额:</TD>
<TD class=TableData noWrap colspan=\"2\">
<input type=\"text\" name=\"应收金额\" value=\"$应收金额\" readonly class=\"SmallStatic\" size=\"20\">(此处由产品数量和执行销售价格自动生成应收金额)
</TD></TR>

<TR><TD class=TableData noWrap>优惠金额:</TD>
<TD class=TableData noWrap colspan=\"2\">
<input type=\"text\" name=\"优惠金额\" value=\"$优惠金额\"  class=\"SmallInput\"
onkeyup=\"value=value.replace(/[^\d]/g,'');DoItInforJinEr();\" 
size=\"20\">
</TD></TR>

<TR><TD class=TableData noWrap>实收金额:</TD>
<TD class=TableData noWrap colspan=\"2\">
<input type=\"text\" name=\"实收金额\" value=\"$实收金额\" readonly class=\"SmallStatic\" size=\"20\">(实收金额=应收金额-优惠金额)
</TD></TR>
	";
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