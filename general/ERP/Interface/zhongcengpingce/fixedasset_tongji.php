<?php
require_once('lib.inc.php');

$GLOBAL_SESSION=returnsession();
$SYSTEM_PRIV_STOP = 1;

page_css("固定资产信息按购买时间进行分科室分类别统计");
print "<link rel='stylesheet' type='text/css' href='/theme/$LOGIN_THEME/style.css'>\n";
	print "<SCRIPT>\n";
	print "function td_calendar(fieldname) {\n";
	print "myleft=document.body.scrollLeft+event.clientX-event.offsetX-80;\n";
	print "mytop=document.body.scrollTop+event.clientY-event.offsetY+140;\n";
	print "window.showModalDialog(fieldname,self,\"edge:raised;scroll:0;status:0;help:0;resizable:1;dialogWidth:280px;dialogHeight:220px;dialogTop:\"+mytop+\"px;dialogLeft:\"+myleft+\"px\");\n";
	print "}\n";
	print "function SubmitForm() { 
		var 开始时间 = document.form1.开始时间.value;
		var 结束时间 = document.form1.结束时间.value;
		URL = \"?action=Stat&开始时间=\"+开始时间+\"&结束时间=\"+结束时间+\"\";
		location = URL;
		
		}\n";
	print "</SCRIPT>\n";
print "<form name=form1><table border=0 cellspacing=0 class=small bordercolor=#000000 cellpadding=3 width=800 style=\"border-collapse:collapse\"><tr><td nowrap>
";

if($_GET['开始时间']=="") $_GET['开始时间'] = date("Y-m-d",mktime(date("H"),date("i"),date("s"),date("m")-1,date("d"),date("Y")));;
if($_GET['结束时间']=="") $_GET['结束时间'] = date("Y-m-d",mktime(date("H"),date("i"),date("s"),date("m"),date("d"),date("Y")));;



print "开始时间:<INPUT class=SmallInput size=10  name=\"开始时间\" value='".$_GET['开始时间']."'  onclick=\"WdatePicker({dateFmt:'yyyy-MM-dd'})\" readonly>&nbsp;&nbsp;
结束时间：<INPUT class=SmallInput size=10  name=\"结束时间\" value='".$_GET['结束时间']."'  onclick=\"WdatePicker({dateFmt:'yyyy-MM-dd'})\" readonly>&nbsp;&nbsp;&nbsp;<input type='button'  title=''  value='开始查询' class='SmallButton' onclick=\"SubmitForm()\" title='开始查询' name='button'>
<input type=button accesskey=p name=print value=\"打印\" class=SmallButton onClick=\"document.execCommand('Print');\" title=\"快捷键:ALT+p\">
";
//print "&nbsp;&nbsp;&nbsp;<a href=\"?".base64_encode("开始时间=".date("Y-m-d",mktime(0,0,1,date("m"),date("d")-3,date("Y")))."&结束时间=".date("Y-m-d",mktime(0,0,1,date("m"),date("d"),date("Y")))."")."\">最近三天</a>";
print "&nbsp;&nbsp;&nbsp;<a href=\"?".base64_encode("开始时间=".date("Y-m-d",mktime(0,0,1,date("m"),date("d")-7,date("Y")))."&结束时间=".date("Y-m-d",mktime(0,0,1,date("m"),date("d"),date("Y")))."")."\">最近一周</a>";
print "&nbsp;&nbsp;&nbsp;<a href=\"?".base64_encode("开始时间=".date("Y-m-d",mktime(0,0,1,date("m"),date("d")-15,date("Y")))."&结束时间=".date("Y-m-d",mktime(0,0,1,date("m"),date("d"),date("Y")))."")."\">最近半月</a>";
print "&nbsp;&nbsp;&nbsp;<a href=\"?".base64_encode("开始时间=".date("Y-m-d",mktime(0,0,1,date("m"),date("d")-30,date("Y")))."&结束时间=".date("Y-m-d",mktime(0,0,1,date("m"),date("d"),date("Y")))."")."\">最近一个月</a>";
print "&nbsp;&nbsp;&nbsp;<a href=\"?".base64_encode("开始时间=".date("Y-m-d",mktime(0,0,1,date("m"),date("d")-60,date("Y")))."&结束时间=".date("Y-m-d",mktime(0,0,1,date("m"),date("d"),date("Y")))."")."\">最近两个月</a>";
print "&nbsp;&nbsp;&nbsp;<a href=\"?".base64_encode("开始时间=".date("Y-m-d",mktime(0,0,1,date("m"),date("d")-90,date("Y")))."&结束时间=".date("Y-m-d",mktime(0,0,1,date("m"),date("d"),date("Y")))."")."\">最近三个月</a>";
print "&nbsp;&nbsp;&nbsp;<a href=\"?".base64_encode("开始时间=".date("Y-m-d",mktime(0,0,1,date("m")-6,date("d"),date("Y")))."&结束时间=".date("Y-m-d",mktime(0,0,1,date("m"),date("d"),date("Y")))."")."\">最近六个月</a>";
print "</td></tr></table></form>  ";


//开始处理收费(借方)和退费(贷方)的现金日记账表


print "<table  class=TableBlock align=center width=800>
<TR><TD class=TableHeader align=left colSpan=40>&nbsp;固定资产信息按购买时间进行分科室分类别统计 <a href='fixedasset_tongjijianjie.php?开始时间=".$_GET['开始时间']."&结束时间=".$_GET['结束时间']."'>简洁统计</a></TD></TR>
";


$开始时间 = $_GET['开始时间'];
$结束时间 = $_GET['结束时间'];
$开始时间ARRAY  = explode('-',$开始时间);
$结束时间ARRAY  = explode('-',$结束时间);
$开始时间 = date("Y-m-d H:i:s",mktime(0,0,1,$开始时间ARRAY[1],$开始时间ARRAY[2],$开始时间ARRAY[0]));
$结束时间 = date("Y-m-d H:i:s",mktime(0,0,1,$结束时间ARRAY[1],$结束时间ARRAY[2]+1,$结束时间ARRAY[0]));

$NewArray = array();
$SortArray = array();
//处理基本表数据
$sql = "select 资产编号,资产名称,SUM(数量) AS 资产数量,SUM(数量*单价) AS 资产总金额,所属部门,资产名称,资产编号 from fixedasset where 购买日期>='$开始时间' and 购买日期<='$结束时间' and 资产名称!='' group by 所属部门,资产名称";
$rs = $db->Execute($sql);
$rs_a = $rs->GetArray();
for($i=0;$i<sizeof($rs_a);$i++)				{
	$Element = $rs_a[$i];
	$所属部门 = $Element['所属部门'];
	$资产数量 = $Element['资产数量'];
	$资产名称 = $Element['资产名称'];
	$资产编号 = $Element['资产编号'];
	$所属部门列表[$所属部门] += $资产数量;
	$资产信息编号汇总[$资产名称] = $Element['资产编号'];
	$资产信息汇总[$资产名称]['资产总金额'][$所属部门] = $Element['资产总金额'];
	$资产信息汇总[$资产名称]['资产数量'][$所属部门] = $Element['资产数量'];

	$资产信息汇总DEPT['资产总金额'][$所属部门] += $Element['资产总金额'];
	$资产信息汇总DEPT['资产数量'][$所属部门] += $Element['资产数量'];
	
	$总数 += $资产数量;
}

$资产总金额 = @array_sum($资产信息汇总DEPT['资产总金额']);
//处理最终结果表格输出

print "<tr class=TableHeader>
<td nowrap>序号</td>
<td nowrap>资产编号</td>
<td nowrap>资产名称</td>
<td nowrap>合计</td>
";
$部门列表 = @array_keys($所属部门列表);
for($i=0;$i<sizeof($部门列表);$i++)		{
	print "<td nowrap>{$部门列表[$i]}</td>";
}
print "</tr>";

$资产信息汇总Array = @array_keys($资产信息汇总);
for($IX=0;$IX<sizeof($资产信息汇总Array);$IX++)		{
	$资产名称 = $资产信息汇总Array[$IX];
	$资产编号 = $资产信息编号汇总[$资产名称];
	print "<tr class=TableData>
	<td nowrap>&nbsp;".($IX+1)."</td>
	<td nowrap>&nbsp;$资产编号</td>
	<td nowrap>&nbsp;$资产名称</td>
	";
	$单项资产数量合计 = array_sum($资产信息汇总[$资产名称]['资产数量']);
	$单项资产合计ALL += $单项资产数量合计;
	if($单项资产数量合计>0)			{
		$单项资产总金额 = @array_sum($资产信息汇总[$资产名称]['资产总金额']);
		$单项资产合计Text = "数量:$单项资产数量合计 金额:$单项资产总金额";
	}
	else	$单项资产合计Text = "";
	print "<td nowrap>&nbsp;$单项资产合计Text</td>";
	$部门列表 = @array_keys($所属部门列表);
	for($i=0;$i<sizeof($部门列表);$i++)		{
		$部门名称 = $部门列表[$i];
		if($资产信息汇总[$资产名称]['资产数量'][$部门名称]>0) {
			$ShowText = "数量:".$资产信息汇总[$资产名称]['资产数量'][$部门名称]." 金额:".$资产信息汇总[$资产名称]['资产总金额'][$部门名称]."";
		}else	{
			$ShowText = "";
		}
		print "<td nowrap>&nbsp;$ShowText</td>";
	}
	print "</tr>";

}








$现有库存ALL = (int)$现有库存ALL;
$资产总金额 = number_format($资产总金额,2);
print "<tr class=TableContent>
<td nowrap colspan=4>从 ".$_GET['开始时间']." 到 ".$_GET['结束时间']." 数量合计:".$总数."个 金额合计:".$资产总金额."元</td>
";
for($xi=0;$xi<sizeof($部门列表);$xi++)		{
	$部门名称 = $部门列表[$xi];
	$Index = $所属部门列表[$部门名称];
	print "<td nowrap>&nbsp;数量:".$资产信息汇总DEPT['资产数量'][$部门名称]." 金额:".$资产信息汇总DEPT['资产总金额'][$部门名称]."</td>";
	$现有库存ALL += $Index;
}
print "</tr>";
print "</table>";
exit;



 


?>