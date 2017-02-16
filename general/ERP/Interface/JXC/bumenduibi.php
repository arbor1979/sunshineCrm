<?php
ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL);
error_reporting(E_WARNING | E_ERROR);
require_once('lib.inc.php');
$GLOBAL_SESSION=returnsession();
global $db;
validateMenuPriv("���ŶԱ�");
if(empty($_GET['start_time'])) {
	$start_time = date("Y-m-d 00:00:00",strtotime("last year"));
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
$sql="SELECT c.DEPT_NAME as name,SUM(a.totalmoney - a.oddment) as sum FROM sellplanmain a JOIN `user` b on a.qianyueren=b.USER_ID JOIN department c on b.DEPT_ID=c.DEPT_ID WHERE a.user_flag>0  and  a.createtime>='".$start_time."' and a.createtime<='".$end_time."' GROUP BY c.DEPT_ID order by sum desc";

//exit($sql);
$rs=$db->Execute($sql);
$rs_a = $rs->GetArray();
//print_r($rs_a);exit;
$mingci = 20;  // ��ǰ������¼����ͳ��
if(isset($rs_a[$mingci])){
	$sum = 0;
	for ($i=$mingci;$i<count($rs_a);$i++){
		$sum+=$rs_a[$i][sum];
		unset($rs_a[$i]);
	}
	$rs_a[$mingci]['name'] = '����';
	$rs_a[$mingci]['sum'] = $sum; 
}
?>
<html>
<head>
<?php page_css("�������ɳ��ⵥ"); ?>
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
						<td class='nowrap'>ʱ��Σ� <input class="SmallInput" size="19" name="start_time" value="<?php echo $start_time; ?>"onclick="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss'})">
						�� <input class="SmallInput" size="19" name="end_time"value="<?php echo $end_time; ?>"onclick="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss'})">						
						<select class="SmallSelect" name="type">
							��ʾ��ʽ��<option <?php echo ($type=='zhu')?'selected':''; ?> value="zhu">��״ͼ</option>
							<option <?php echo ($type=='bing')?'selected':''; ?> value="bing">��״ͼ</option>
						</select>	
						<input class="SmallButtonA" type="submit" accesskey="f" value="��ѯ" name="button">												
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
chart_index.setDataXML("<graph bgcolor='e1f5ff' caption='���ŶԱ�' subCaption='��ȷ����λ���������룩' numberPrefix='' formatNumberScale='1' decimalPrecision='2' baseFontSize='14' numberSuffix='��Ԫ'><?php foreach ($rs_a as $row){echo "<set name='".$row['name']."' value='".($row['sum']/10000)."'/>";}?></graph>");
chart_index.render("indexDiv");
</script>
<!-- END Script Block for Chart index -->


</body>
</html>










