<?php
require_once('lib.inc.php');

$GLOBAL_SESSION=returnsession();

	require_once("systemprivateinc.php");

	CheckSystemPrivate("后勤管理-办公用品-分项统计");

?>

<script language="javascript" src="../LODOP60/LodopFuncs.js"></script>
<object  id="LODOP_OB" classid="clsid:2105C259-1E0C-4534-8141-A753534CB4CA" width=0 height=0>
	<embed id="LODOP_EM" type="application/x-print-lodop" width=0 height=0></embed>
</object>

<script language="javascript" type="text/javascript">
	var LODOP; //声明为全局变量
	LODOP=getLodop(document.getElementById('LODOP_OB'),document.getElementById('LODOP_EM'));

    function PreviewFun(){
	    LODOP.PRINT_INIT("数字化校园打印程序");
		var strStyleCSS="<link href='<?php echo ROOT_DIR?>theme/3/style.css' type='text/css' rel='stylesheet'><style>input {display: none;}; label {display: none}</style>";
		LODOP.ADD_PRINT_TABLE(30,"4%","90%","90%",strStyleCSS+"<body>"+document.getElementById("MainData0").innerHTML+"</body>");
		LODOP.NewPageA();
	};

	function PreviewMytable(){
		
		PreviewFun();
		LODOP.PREVIEW();
	};

	function PrintMytable(){

		PreviewFun();
		if (LODOP.PRINTA())  
			alert("已发出实际打印命令！");
	};
</script>
<?php

page_css("办公用品信息统计");
print "<link rel='stylesheet' type='text/css' href='".ROOT_DIR."theme/$LOGIN_THEME/style.css'>\n";
	print "<SCRIPT>\n";
	print "function td_calendar(fieldname) {\n";
	print "myleft=document.body.scrollLeft+event.clientX-event.offsetX-80;\n";
	print "mytop=document.body.scrollTop+event.clientY-event.offsetY+140;\n";
	print "window.showModalDialog(fieldname,self,\"edge:raised;scroll:0;status:0;help:0;resizable:1;dialogWidth:280px;dialogHeight:200px;dialogTop:\"+mytop+\"px;dialogLeft:\"+myleft+\"px\");\n";
	print "}\n";
	print "function SubmitForm() {
		var 开始时间 = document.form1.开始时间.value;
		var 结束时间 = document.form1.结束时间.value;
		URL = \"?action=Stat&开始时间=\"+开始时间+\"&结束时间=\"+结束时间+\"\";
		location = URL;

		}\n";
	print "</SCRIPT>\n";
print "<form name=form1><table border=0 cellspacing=0 class=small bordercolor=#000000 cellpadding=3 width=100% style=\"border-collapse:collapse\"><tr><td nowrap>
";

if($_GET['开始时间']=="") $_GET['开始时间'] = date("Y-m-d",mktime(date("H"),date("i"),date("s"),date("m")-1,date("d"),date("Y")));;
if($_GET['结束时间']=="") $_GET['结束时间'] = date("Y-m-d",mktime(date("H"),date("i"),date("s"),date("m"),date("d"),date("Y")));;

print "<INPUT class=SmallInput size=10  name=开始时间 value='".$_GET['开始时间']."' title='' onkeydown='if(event.keyCode==13)event.keyCode=9' >
<input type='button'  title=''  value='选择' class='SmallButton' onclick=\"td_calendar('../../Framework/sms_index/calendar_begin.php?datetime=开始时间');\" title='选择' name='button'>&nbsp;&nbsp;
<INPUT class=SmallInput size=10  name=结束时间 value='".$_GET['结束时间']."' title='' onkeydown='if(event.keyCode==13)event.keyCode=9' >
<input type='button'  title=''  value='选择' class='SmallButton' onclick=\"td_calendar('../../Framework/sms_index/calendar_begin.php?datetime=结束时间');\" title='选择' name='button'>&nbsp;&nbsp;&nbsp;<input type='button'  title=''  value='开始查询' class='SmallButton' onclick=\"SubmitForm()\" title='开始查询' name='button'>&nbsp;&nbsp;
";
print "&nbsp;&nbsp;&nbsp;<a href=\"?".base64_encode("开始时间=".date("Y-m-d",mktime(0,0,1,date("m"),date("d")-3,date("Y")))."&结束时间=".date("Y-m-d",mktime(0,0,1,date("m"),date("d"),date("Y")))."")."\">最近三天</a>";
print "&nbsp;&nbsp;&nbsp;<a href=\"?".base64_encode("开始时间=".date("Y-m-d",mktime(0,0,1,date("m"),date("d")-7,date("Y")))."&结束时间=".date("Y-m-d",mktime(0,0,1,date("m"),date("d"),date("Y")))."")."\">最近一周</a>";
print "&nbsp;&nbsp;&nbsp;<a href=\"?".base64_encode("开始时间=".date("Y-m-d",mktime(0,0,1,date("m"),date("d")-15,date("Y")))."&结束时间=".date("Y-m-d",mktime(0,0,1,date("m"),date("d"),date("Y")))."")."\">最近半月</a>";
print "&nbsp;&nbsp;&nbsp;<a href=\"?".base64_encode("开始时间=".date("Y-m-d",mktime(0,0,1,date("m"),date("d")-30,date("Y")))."&结束时间=".date("Y-m-d",mktime(0,0,1,date("m"),date("d"),date("Y")))."")."\">最近一个月</a>";
print "&nbsp;&nbsp;&nbsp;<a href=\"?".base64_encode("开始时间=".date("Y-m-d",mktime(0,0,1,date("m"),date("d")-60,date("Y")))."&结束时间=".date("Y-m-d",mktime(0,0,1,date("m"),date("d"),date("Y")))."")."\">最近两个月</a>";
print "&nbsp;&nbsp;&nbsp;<a href=\"?".base64_encode("开始时间=".date("Y-m-d",mktime(0,0,1,date("m"),date("d")-90,date("Y")))."&结束时间=".date("Y-m-d",mktime(0,0,1,date("m"),date("d"),date("Y")))."")."\">最近三个月</a>";
print "&nbsp;&nbsp;&nbsp;<a href=\"?".base64_encode("开始时间=".date("Y-m-d",mktime(0,0,1,date("m")-6,date("d"),date("Y")))."&结束时间=".date("Y-m-d",mktime(0,0,1,date("m"),date("d"),date("Y")))."")."\">最近六个月</a>";
print "</td></tr></table></form>  ";


//开始处理收费(借方)和退费(贷方)的现金日记账表


print "<div id=MainData0><table  class=TableBlock align=center width=100%><thead>
<TR><TD class=TableHeader align=left colSpan=8>&nbsp;办公用品信息统计</TD></TR>
";


$开始时间 = $_GET['开始时间'];
$结束时间 = $_GET['结束时间'];
$开始时间ARRAY  = explode('-',$开始时间);
$结束时间ARRAY  = explode('-',$结束时间);
$开始时间 = date("Y-m-d H:i:s",mktime(0,0,1,$开始时间ARRAY[1],$开始时间ARRAY[2],$开始时间ARRAY[0]));
$结束时间 = date("Y-m-d H:i:s",mktime(0,0,1,$结束时间ARRAY[1],$结束时间ARRAY[2]+1,$结束时间ARRAY[0]));

$NewArray = array();
$SortArray = array();
//处理出库表数据
$sql = "select 办公用品编号,办公用品名称,SUM(出库数量) AS 出库总数 from officeproductout where 创建时间>='$开始时间' and 创建时间<='$结束时间' group by 办公用品编号";
$rs = $db->Execute($sql);
$rs_a = $rs->GetArray();
for($i=0;$i<sizeof($rs_a);$i++)				{
	$Element = $rs_a[$i];
	$办公用品编号 = $Element['办公用品编号'];
	$办公用品名称 = $Element['办公用品名称'];
	$出库总数 = $Element['出库总数'];
	$出库表数据[$办公用品编号]['办公用品名称'] = $办公用品名称;
	$出库表数据[$办公用品编号]['出库总数'] = $出库总数;
}

//处理入库表数据
$sql = "select 办公用品编号,办公用品名称,SUM(入库数量) AS 入库总数 from officeproductin where 创建时间>='$开始时间' and 创建时间<='$结束时间' group by 办公用品编号";
$rs = $db->Execute($sql);
$rs_a = $rs->GetArray();
for($i=0;$i<sizeof($rs_a);$i++)				{
	$Element = $rs_a[$i];
	$办公用品编号 = $Element['办公用品编号'];
	$办公用品名称 = $Element['办公用品名称'];
	$入库总数 = $Element['入库总数'];
	$入库表数据[$办公用品编号]['办公用品名称'] = $办公用品名称;
	$入库表数据[$办公用品编号]['入库总数'] = $入库总数;
}

//处理退库表数据
$sql = "select 办公用品编号,办公用品名称,SUM(退库数量) AS 退库总数 from officeproducttui where 创建时间>='$开始时间' and 创建时间<='$结束时间' group by 办公用品编号";
$rs = $db->Execute($sql);
$rs_a = $rs->GetArray();
for($i=0;$i<sizeof($rs_a);$i++)				{
	$Element = $rs_a[$i];
	$办公用品编号 = $Element['办公用品编号'];
	$办公用品名称 = $Element['办公用品名称'];
	$退库总数 = $Element['退库总数'];
	$退库表数据[$办公用品编号]['办公用品名称'] = $办公用品名称;
	$退库表数据[$办公用品编号]['退库总数'] = $退库总数;
}



//处理报废表数据
$sql = "select 办公用品编号,办公用品名称,SUM(报废数量) AS 报废总数,所属仓库 AS 报废仓库 from officeproductbaofei where 创建时间>='$开始时间' and 创建时间<='$结束时间' group by 办公用品编号,报废仓库";
$rs = $db->Execute($sql);
$rs_a = $rs->GetArray();
for($i=0;$i<sizeof($rs_a);$i++)				{
	$Element = $rs_a[$i];
	$办公用品编号 = $Element['办公用品编号'];
	$办公用品名称 = $Element['办公用品名称'];
	$报废总数 = $Element['报废总数'];
	$报废仓库 = $Element['报废仓库'];
	$仓库总列表[$报废仓库] = $报废仓库;
	$报废表数据[$办公用品编号]['办公用品名称'] = $办公用品名称;
	$报废表数据[$办公用品编号]['报废总数'] = $报废总数;
}

//处理合并数组
//print_R($出库表数据);

$sql = "select * from officeproduct";
$rs = $db->Execute($sql);
$rs_a = $rs->GetArray();


//处理最终结果表格输出
print "<tr class=TableHeader>
<td nowrap>序号</td>
<td nowrap>办公用品编号</td>
<td nowrap>办公用品名称</td>
<td nowrap>现有库存</td>
<td nowrap>采购总数</td>
<td nowrap>借领总数</td>
<td nowrap>归还总数</td>
<td nowrap>报废总数</td>

</tr></thead>";
for($i=0;$i<sizeof($rs_a);$i++)				{
	$Key = $rs_a[$i];
	$办公用品编号 = $Key['办公用品编号'];
	$办公用品名称 = $Key['办公用品名称'];
	$入库总数 = $入库表数据[$办公用品编号]['入库总数'];
	$出库总数 = $出库表数据[$办公用品编号]['出库总数'];
	$退库总数 = $退库表数据[$办公用品编号]['退库总数'];
	$报废总数 = $报废表数据[$办公用品编号]['报废总数'];
	$现有库存 = $入库表数据[$办公用品编号]['入库总数'] + $退库表数据[$办公用品编号]['退库总数']-$出库表数据[$办公用品编号]['出库总数'] - $报废表数据[$办公用品编号]['报废总数'];

print "<tr class=TableData>
<td nowrap><font color=black>".($i+1)."</font></td>
<td nowrap>$办公用品编号</td>
<td nowrap>$办公用品名称</td>
<td nowrap>$现有库存</td>
<td nowrap>$入库总数</td>
<td nowrap>$出库总数</td>
<td nowrap>$退库总数</td>
<td nowrap>$报废总数</td>

</tr>
";
$现有库存ALL += $现有库存;
$入库总数ALL += $入库总数;
$出库总数ALL += $出库总数;
$退库总数ALL += $退库总数;
$报废总数ALL += $报废总数;

}

print "<tr class=TableContent>
<td nowrap colspan=3>从 ".$_GET['开始时间']." 到 ".$_GET['结束时间']." 合计:</td>
<td nowrap>$现有库存ALL</td>
<td nowrap>$入库总数ALL</td>
<td nowrap>$出库总数ALL</td>
<td nowrap>$退库总数ALL</td>
<td nowrap>$报废总数ALL</td>

</tr>
";
print "</table></div>";

print "<p align=center><input type=button class=SmallButton onClick=\"PreviewMytable();\" value='预览'>&nbsp;&nbsp;
       <input type=button accesskey=p name=print value=\"打印\" class=SmallButton onClick=\"PrintMytable();\" title=\"快捷键:ALT+p\"></p>";
exit;
?>