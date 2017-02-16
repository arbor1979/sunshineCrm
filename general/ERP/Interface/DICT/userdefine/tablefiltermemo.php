<?php
//##########################################################
//格式：_add _view _Value		说明性表述方式
//userDefineInforStatus_add		新增与编辑的函数编制，两个参数：前者为数组图，后者为字段索引值
//userDefineInforStatus_view	查阅视图函数说明
//userDefineInforStatus_Value	列表视图说明
//#########################################################
//提供用户自定义类型：用于增加和编辑数据时
$tablefiltermemo = "消息规则引擎提醒字段显示列表";
function tablefiltermemo_add($fields,$i)		{
	global $db;
	global $tablename,$html_etc,$common_html;
	$fieldname = $fields['name'][$i];
	$数量 = $fields['value']['数量'];
	$单价 = $fields['value']['单价'];
	$金额 = $fields['value']['金额'];
	$showtext  = $html_etc[$tablename][$fieldname];

?>
	<script>
	//设定客户端信息
	function GetResultClass(str)
	{
		var oBao = new ActiveXObject("Microsoft.XMLHTTP");
		oBao.open("GET","XmlHttpServerTableField.php?action=showdatas&TableName="+str,false);
		oBao.send();
		//服务器端处理返回的是经过escape编码的字符串.
		//通过XMLHTTP返回数据,开始构建Select.
		//alert(unescape(oBao.responseText));
		var stringValue = unescape(oBao.responseText);
		Arraystr = stringValue.split(";");
		FieldDetail.innerHTML = "<font color=green>"+Arraystr[0]+"</font>";
		document.form1.提醒内容模板.value	= Arraystr[1];
	}
	</script>
<TR>
<TD class=TableData noWrap width=20%>提醒对象数据源:</TD>
<TD class=TableData noWrap colspan="2">
<?php
$sql = "select 表名,名称 from crm_clendar_object";
$rs = $db->Execute($sql);
$rs_a = $rs->GetArray();
print "<select class=\"SmallSelect\" onChange=\"GetResultClass(this.value);\" name=\"数据对象\" >";
print "<option value=\"\" >请选择数据源</option>";
for($i=0;$i<sizeof($rs_a);$i++)				{
	print "<option value=\"".$rs_a[$i]['表名']."\" >".$rs_a[$i]['名称']."[".$rs_a[$i]['表名']."]</option>";
}
print "</select>";
print "
</TD></TR>
<TR>
<TD class=TableData noWrap width=20%>该对象字段明细:</TD>
<TD class=TableData colspan=\"2\"><span id='FieldDetail'><font color=green>还没有选择数据源</font></span></TD></TR>

	";
}

?><?php
/*
	版权归属:郑州单点科技软件有限公司;
	联系方式:0371-69663266;
	公司地址:河南郑州经济技术开发区第五大街经北三路通信产业园四楼西南;
	公司简介:郑州单点科技软件有限公司位于中国中部城市-郑州,成立于2007年1月,致力于把基于先进信息技术（包括通信技术）的最佳管理与业务实践普及到教育行业客户的管理与业务创新活动中，全面提供具有自主知识产权的教育管理软件、服务与解决方案，是中部最优秀的高校教育管理软件及中小学校管理软件提供商。目前己经有多家高职和中职类院校使用通达中部研发中心开发的软件和服务;

	软件名称:单点科技软件开发基础性架构平台,以及在其基础之上扩展的任何性软件作品;
	发行协议:数字化校园产品为商业软件,发行许可为LICENSE方式;单点CRM系统即SunshineCRM系统为GPLV3协议许可,GPLV3协议许可内容请到百度搜索;
	特殊声明:软件所使用的ADODB库,PHPEXCEL库,SMTARY库归原作者所有,余下代码沿用上述声明;
	*/
?>