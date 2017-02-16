<?php
//##########################################################
//格式：_add _view _Value		说明性表述方式
//userDefineInforStatus_add		新增与编辑的函数编制，两个参数：前者为数组图，后者为字段索引值
//userDefineInforStatus_view	查阅视图函数说明
//userDefineInforStatus_Value	列表视图说明
//#########################################################
//提供用户自定义类型：用于增加和编辑数据时
$jineinput = "用于数量,单价,与金额之间的联动关系,在新建和编辑视图,集美需求";
function jineinput_add($fields,$i)		{
	global $db;
	global $tablename,$html_etc,$common_html;
	$fieldname = $fields['name'][$i];
	$数量 = $fields['value']['数量'];
	$单价 = $fields['value']['单价'];
	$金额 = $fields['value']['金额'];
	$showtext  = $html_etc[$tablename][$fieldname];
	if($数量=='') $数量 = 1;
	print "
	<script>
	function DoItInforJinEr()		{
		var 数量 = document.form1.数量.value;
		var 单价 = document.form1.单价.value;
		var 金额 = 数量*单价;
		var 处理后金额 = Math.round(金额*100)/100;
		//alert(数量);alert(单价);alert(金额);
		document.form1.金额.value = 处理后金额;
	}
	</script>
<TR>
<TD class=TableData noWrap width=20%>单价:</TD>
<TD class=TableData noWrap colspan=\"2\"><INPUT type=\"text\" title='' onkeydown=\"if(event.keyCode==13)event.keyCode=9\" accesskey='7' class=\"SmallInput\"  maxLength=200 size=\"30\" name=\"单价\" value=\"$单价\" onkeypress=\"check_input_num('MONEY');\" onkeyup=\"DoItInforJinEr();\"
>&nbsp;
</TD></TR>
<TR>
<TD class=TableData noWrap width=20%>数量:</TD>
<TD class=TableData noWrap colspan=\"2\"><INPUT type=\"text\" title='' onkeydown=\"if(event.keyCode==13)event.keyCode=9\" accesskey='6' class=\"SmallStatic\" readonly  maxLength=200 size=\"30\" name=\"数量\" value=\"$数量\"  onkeyup=\"value=value.replace(/[^\d]/g,'');DoItInforJinEr();\"  onbeforepaste=\"clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''));DoItInforJinEr();\"  >&nbsp;
<BR>新建时数量只能是1,如超过1,请执行采购或入库操作;<BR>一条信息做为一个整体参与针对一个人的借用和归还记录;</TD></TR>

<TR><TD class=TableData noWrap>金额:</TD>
<TD class=TableData noWrap colspan=\"2\">
<input type=\"hidden\" name=\"\" value=\"\">
<input type=\"text\" name=\"金额\" value=\"$金额\" readonly class=\"SmallStatic\" size=\"20\">(此处由数量和单价自动生成金额)
</TD></TR>
	";
}

?>