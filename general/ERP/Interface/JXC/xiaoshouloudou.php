<?php
ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL);
error_reporting(E_WARNING | E_ERROR);
require_once('lib.inc.php');
$GLOBAL_SESSION=returnsession();
validateMenuPriv("销售漏斗");
global $db;
if(empty($_GET['start_time'])) {
	$start_time = date("Y-m-d 00:00:00",strtotime("last month"));
}else{
	$start_time = $_GET['start_time'];
}

if(empty($_GET['end_time'])) {
	$end_time = date("Y-m-d 23:59:59");
}else{
	$end_time = $_GET['end_time'];
}

$sql = "SELECT b.`编号`,b.`阶段`,COUNT(*) as chance_num,SUM(a.`预计金额`) as money FROM crm_chance a LEFT JOIN crm_jieduan b on a.`当前阶段`=b.`编号` WHERE a.`创建时间`>='".$start_time."' and a.`创建时间`<='".$end_time."'  GROUP BY a.`当前阶段`";
//exit($sql);
$rs=$db->Execute($sql);
$rs_data = $rs->GetArray();
$data = array();
$sum = 0;$sum_money = 0;
foreach ($rs_data as $row){
	$data[$row['阶段']] = $row;
	$sum  += $row[chance_num];
	$sum_money  += $row[money];
}

$sql = "SELECT * FROM crm_jieduan order by `编号` asc";
//exit($count_sql);
$rs=$db->Execute($sql);
$jieduan = $rs->GetArray();

$rs_a = array();

foreach ($jieduan as $row){
	$rs_a[$row['阶段']] = $data[$row['阶段']];
	
}
//print_r($rs_a);exit;
?>
<html>
<head>
<?php page_css("销售漏斗"); ?>
<script language="javascript" src="../LODOP60/LodopFuncs.js"></script>
<SCRIPT src="../../Enginee/WdatePicker/WdatePicker.js"></SCRIPT>
<object  id="LODOP_OB" classid="clsid:2105C259-1E0C-4534-8141-A753534CB4CA"
	width=0 height=0> <embed id="LODOP_EM" type="application/x-print-lodop"
		width=0 height=0></embed> </object>
</head>
<body class=bodycolor topMargin=5>
<div id='con'>
<table class=TableBlock align=left width=50%>
	<thead>
		<tr>
			<td colspan="13">
			<form action='' method="get">
			<table width="100%" class="Small" border="0">
				<thead>
					<tr>
						<td class='nowrap'>时间段： <input class="SmallInput" size="19"
							name="start_time" value="<?php echo $start_time; ?>"
							onclick="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss'})"> — <input
							class="SmallInput" size="19" name="end_time"
							value="<?php echo $end_time; ?>"
							onclick="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss'})"> 																				
							<input
							class="SmallButtonA" type="submit" accesskey="f" value="查询"
							name="button"></td>
					</tr>
				</thead>
			</table>
			</form>
			</td>
		</tr>
		<tr>
			<td colspan="11" class="TableHeader">&nbsp;销售漏斗统计表</td>
		</tr>
	</thead>

	<tr class=TableHeader>
		<td nowrap align=center >所处阶段</td>
		<td nowrap align=center >机会数</td>
		<td nowrap align=center >所占比例</td>
		<td nowrap align=center >预计成交金额</td>
	</tr>
	
	
	<?php
	foreach($rs_a as $key=>$row)
	{
		echo "<tr class=TableData>";
		echo "<td nowrap>".$key."</td>";
		echo  ("<td align='center' nowrap><a href='crm_chance_newai.php?action=init_default_search&searchfield=当前阶段&searchvalue=".$key."' target='_blank'>".intval($row[chance_num])."</a></td>");
		if($sum==0)
			echo ("<td align='right' nowrap>".number_format(0,2,'.',',')."%</td>");
		else
			echo ("<td align='right' nowrap>".number_format(intval(($row[chance_num])/$sum*100),2,'.',',')."%</td>");
		echo ("<td align='right' nowrap>".number_format($row['money'],2,'.',',')."</td>");
		echo "</tr>";
	}
	?>
<tr class="TableData"><td nowrap="">合计</td><td align="center" nowrap=""><?php echo $sum;?></td><td align="right" nowrap=""></td><td align="right" nowrap=""><?php echo number_format($sum_money,2,'.',',');?></td></tr>
</table>
</div>
<script language="javascript" type="text/javascript">   
    var LODOP; //声明为全局变量 
	function prn_print() {		
		CreateOneFormPage();
		LODOP.PREVIEW();
		//LODOP.PRINT();	
	};

	function CreateOneFormPage(){
	
		LODOP=getLodop(document.getElementById('LODOP_OB'),document.getElementById('LODOP_EM'));  

		LODOP.PRINT_INIT("产品采购汇总");
		
		LODOP.SET_PRINT_STYLE("FontSize",12);

		LODOP.ADD_PRINT_TEXT(40,131,560,39,"产品采购汇总");	

		//LODOP.SET_PRINT_STYLEA(0,"Stretch",2);
		
		LODOP.ADD_PRINT_HTML(88,"2%","50%",500,document.getElementById("con").innerHTML);
		
	};              

</script>


<!-- START Script Block for Chart index -->
<script type="text/javascript"
	src="../../Framework/FusionCharts/FusionCharts.js"></script>
<div id="indexDiv" align="left" style="display:block;float:left;padding-left:20px;">Chart.</div>
<script type="text/javascript"> 
//Instantiate the Chart 
var chart_index = new FusionCharts("../../Framework/FusionCharts/FCF_Funnel.swf", "index");
//chart_index.setTransparent("false");

//Provide entire XML data using dataXML method

<?php
$cont_str = '';
foreach ($rs_a as $key=>$row){
	$cont_str = "<set name='".$key."' value='".intval($row[chance_num])."'/>".$cont_str;
}
?>
chart_index.setDataXML("<graph bgcolor='e1f5ff' caption='销售漏斗' subCaption='' numberPrefix='' formatNumberScale='1' decimalPrecision='0' baseFontSize='14' numberSuffix=''><?php echo $cont_str; ?> </graph>");
chart_index.render("indexDiv");
</script>
<!-- END Script Block for Chart index -->


</body>

</html>










