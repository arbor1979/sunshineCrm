<?php
ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL);
error_reporting(E_WARNING | E_ERROR);
require_once('lib.inc.php');
$GLOBAL_SESSION=returnsession();
global $db;
validateMenuPriv("退货汇总");
if(empty($_GET['start_time'])) {
	$start_time = date("Y-m-d",strtotime("last year"));
}else{
	$start_time = $_GET['start_time'];
}

if(empty($_GET['end_time'])) {
	$end_time = date("Y-m-d 23:59:59");
}else{
	$end_time = $_GET['end_time'];
}
$type=$_GET['type'];
if($type=='zhu' || $type == ''){
	$swf = 'Column3D.swf';
}elseif ($type=='bing'){
	$swf = 'Pie2D.swf';
}

$type1=$_GET['type1'];
if($type1=='customer' || empty($type1)){
	$sql="SELECT name,ABS(tuei)/(mai)*100 as tueihuobi FROM (SELECT c.supplyname as name,sum(if(a.num<0,a.jine,0)) as tuei,sum(if(a.num>0,a.jine,0)) as mai FROM sellplanmain_detail a left JOIN sellplanmain b on b.billid=a.mainrowid left JOIN customer c on c.ROWID=b.supplyid WHERE b.user_flag>0 and b.createtime>='".$start_time."' and b.createtime<='".$end_time."' GROUP BY b.supplyid ORDER BY tuei asc) as d WHERE ABS(tuei)/(mai)>0 ORDER BY tueihuobi DESC";	
}elseif ($type1=='product'){
	$sql="SELECT name,ABS(tuei)/(mai)*100 as tueihuobi FROM (SELECT a.prodname as name,sum(if(a.num<0,a.jine,0)) as tuei,sum(if(a.num>0,a.jine,0)) as mai FROM sellplanmain_detail a left JOIN sellplanmain b on b.billid=a.mainrowid WHERE b.user_flag>0 and b.createtime>='".$start_time."' and b.createtime<='".$end_time."' GROUP BY a.prodid ORDER BY tuei asc) as d WHERE ABS(tuei)/(mai)>0 ORDER BY tueihuobi DESC";
}

//exit($sql);
$rs=$db->Execute($sql);
$rs_a = $rs->GetArray();
//print_r($rs_a);exit;
$mingci = 20;  // 对前？条记录进行统计
if(isset($rs_a[$mingci])){
	$sum = 0;
	for ($i=$mingci;$i<count($rs_a);$i++){
		$sum+=$rs_a[$i][sum];
		unset($rs_a[$i]);
	}
	$rs_a[$mingci]['name'] = '其它';
	$rs_a[$mingci]['sum'] = $sum; 
}
?>
<html>
<head>
<?php page_css("退货率汇总"); ?>
<SCRIPT src="../../Enginee/WdatePicker/WdatePicker.js"></SCRIPT>
</head>
<body class=bodycolor topMargin=5>

<table class=TableBlock align=center width=100%>
	<thead>
		<tr>
			<td colspan="13">
			<form action='' method="get">
			<table width="100%" class="Small" border="0">
				<thead>
					<tr>
						<td class='nowrap'>时间段： <input class="SmallInput" size="19" name="start_time" value="<?php echo $start_time; ?>"onclick="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss'})">
						— <input class="SmallInput" size="19" name="end_time"value="<?php echo $end_time; ?>"onclick="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss'})">						
						显示方式：<select class="SmallSelect" name="type">
							<option <?php echo ($type=='zhu')?'selected':''; ?> value="zhu">柱状图</option>
							<option <?php echo ($type=='bing')?'selected':''; ?> value="bing">饼状图</option>
						</select>	
						汇总方式：<select class="SmallSelect" name="type1">
							<option <?php echo ($type1=='customer')?'selected':''; ?> value="customer">按客户汇总</option>
							<option <?php echo ($type1=='product')?'selected':''; ?> value="product">按产品汇总</option>
						</select>							
						<input class="SmallButtonA" type="submit" accesskey="f" value="查询" name="button">												
						</td>
					</tr>
				</thead>
			</table>
			</form>
			</td>
		</tr>
	</thead>

</table>
<br/>

<!-- START Script Block for Chart index -->
<script type="text/javascript"
	src="../../Framework/FusionCharts/FusionCharts.js"></script>
<div id="indexDiv" align="center">Chart.</div>
<script type="text/javascript"> 
//Instantiate the Chart 
var chart_index = new FusionCharts("../../Framework/FusionCharts/<?php echo $swf; ?>", "index", "100%", "550", "0", "0");
//chart_index.setTransparent("false");

//Provide entire XML data using dataXML method
chart_index.setDataXML("<graph bgcolor='e1f5ff' caption=' 退货率汇总' subCaption='精确到百分位（四舍五入）' numberPrefix='' formatNumberScale='1' decimalPrecision='2' baseFontSize='14' numberSuffix='%'><?php foreach ($rs_a as $row){echo "<set name='".$row['name']."' value='".($row['tueihuobi'])."'/>";}?></graph>");
chart_index.render("indexDiv");
</script>
<!-- END Script Block for Chart index -->


</body>
</html>










