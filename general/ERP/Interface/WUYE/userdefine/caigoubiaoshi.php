<?php
//##########################################################
//格式：_add _view _Value		说明性表述方式
//userDefineInforStatus_add		新增与编辑的函数编制，两个参数：前者为数组图，后者为字段索引值
//userDefineInforStatus_view	查阅视图函数说明
//userDefineInforStatus_Value	列表视图说明
//#########################################################
//提供用户自定义类型：用于增加和编辑数据时
$caigoubiaoshi = "采购标识,初期用于采购资产数量超过1时使用,后没有采用,直接采用输入资产名称的方式";
function caigoubiaoshi_add($fields,$i)		{
	global $db;	
	global $tablename,$html_etc,$common_html;
	$fieldname = $fields['name'][$i];
	$fieldValue = $fields['value'][$fieldname];
	$采购标识 = $_GET['资产名称'];
	print "<TR>";
	print "<TD class=TableData noWrap>采购标识:</TD>\n";
	print "<TD class=TableData noWrap colspan=\"$colspan\">\n";
	print "<input type=\"hidden\" name=\"资产类别\" value=\"".$_GET['资产类别']."\">\n";
    print "<input type=\"text\" name=\"采购标识\" value=\"$采购标识\" readonly class=\"SmallStatic\" size=\"25\">&nbsp;&nbsp;\n";
	print "数量:<input type=\"text\" name=\"数量\" value=\"1\" class=\"SmallInput\" size=\"6\" onkeyup=\"value=value.replace(/[^\d]/g,'');if(this.value>9999){alert('最大数字不能超过9999');value=9999;}if(this.value<1){alert('最小数字不能小于1');value=1;}\"  onbeforepaste=\"clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''))\"  >\n<BR>(根据采购标识进行采购,名称和编号由标识生成)";

	print $addtext = FilterFieldAddText($addtext,$fieldname);
	print "</TD></TR>\n";
}

?>