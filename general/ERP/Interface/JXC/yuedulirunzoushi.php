<?php
ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL);
error_reporting(E_WARNING | E_ERROR);
require_once('lib.inc.php');
$GLOBAL_SESSION=returnsession();
global $db;
validateMenuPriv("月度利润走势图");
if(empty($_GET['start_time'])) {
	$start_time = date("Y-m",strtotime("last year"));
}else{
	$start_time = $_GET['start_time'];
}

if(empty($_GET['end_time'])) {
	$end_time = date("Y-m");
}else{
	$end_time = $_GET['end_time'];
}

if(strtotime($start_time)>strtotime($end_time))exit('日期区间错误');

$start_time_year = date('Y',strtotime($start_time));
$start_time_month = date('m',strtotime($start_time));
//$start_time_day = date('d',strtotime($start_time));

$end_time_year = date('Y',strtotime($end_time));
$end_time_month = date('m',strtotime($end_time));
//$end_time_day = date('d',strtotime($end_time));


$type=$_GET['type'];
$list = array();
if(empty($type) ||  $type == 'month' ) {
	$type = 'month';
	$date_format = "DATE_FORMAT(a.createtime,'%Y-%m')";

	for ($y=$start_time_year;$y<=$end_time_year;$y++){
		$start = ($y==$start_time_year)?$start_time_month:1;
		$end = ($y==$end_time_year)?$end_time_month:12;
		for(;$start<=$end;$start++){
			$key = date('Y-m',strtotime($y.'-'.$start));
			$list[$key]=0;
		}
	}
}elseif($type == 'year'){
	$date_format = "DATE_FORMAT(a.createtime,'%Y')";
	for ($y=$start_time_year;$y<=$end_time_year;$y++){
		$list[$y]=0;
	}
}elseif($type == 'quarter'){
	$date_format = "CONCAT(YEAR(a.createtime),'-',QUARTER(a.createtime))";

	for ($y=$start_time_year;$y<=$end_time_year;$y++){
		$start = ($y==$start_time_year)?ceil($start_time_month/3):1;
		$end = ($y==$end_time_year)?ceil($end_time_month/3):4;
		for(;$start<=$end;$start++){
			$list[$y.'-'.$start]=0;
		}
	}
	
}
$sql="SELECT ".$date_format." as name,sum(b.lirun) as sum FROM sellplanmain a  LEFT JOIN sellplanmain_detail b on b.mainrowid=a.billid  WHERE a.user_flag>0 and a.createtime>='".$start_time."' and a.createtime<='".$end_time."' GROUP BY name";
//exit($sql);
$rs=$db->Execute($sql);
$rs_a = $rs->GetArray();
foreach ($rs_a as $row){
	$list[$row['name']] = $row['sum'];
}
//print_r($list);exit;
?>
<html>
<head>
<?php page_css("月度利润走势图"); ?>
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
						<td class='nowrap'>时间段： <input class="SmallInput" size="19" name="start_time" value="<?php echo $start_time; ?>"onclick="WdatePicker({dateFmt:'yyyy-MM'})">
						— <input class="SmallInput" size="19" name="end_time"value="<?php echo $end_time; ?>"onclick="WdatePicker({dateFmt:'yyyy-MM'})">
						<select class="SmallSelect" name="type">
							<option <?php echo ($type=='year')?'selected':''; ?> value="year">按年统计</option>
							<option <?php echo ($type=='quarter')?'selected':''; ?> value="quarter">按季度统计</option>
							<option <?php echo ($type=='month')?'selected':''; ?> value="month">按月统计</option>
							<!--<option <?php echo ($type=='day')?'selected':''; ?> value="day">按日统计</option>-->
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
var chart_index = new FusionCharts("../../Framework/FusionCharts/Column3D.swf", "index", "100%", "500", "0", "0");
//chart_index.setTransparent("false");

//Provide entire XML data using dataXML method
chart_index.setDataXML("<graph bgcolor='e1f5ff' caption='利润走势图' subCaption='精确到百位（四舍五入）' numberPrefix='' formatNumberScale='1' decimalPrecision='2' baseFontSize='14' numberSuffix='万'><?php foreach ($list as $key=>$vo){echo "<set name='".$key."' value='".($vo/10000)."'/>";}?></graph>");
chart_index.render("indexDiv");
</script>
<!-- END Script Block for Chart index -->


</body>
</html>










