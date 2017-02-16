<?php
ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL);
error_reporting(E_WARNING | E_ERROR);
require_once('lib.inc.php');
$GLOBAL_SESSION=returnsession();
global $db;
validateMenuPriv("毛利汇总");
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

function printError($errmsg)
{
	print "<script>alert('$errmsg');history.back(-1);</script>";
}
if(strtotime($start_time)>strtotime($end_time))
{
	printError('日期区间错误');
	exit;
}

$show_type = empty($_GET['show_type'])?'table':$_GET['show_type'];
$type1 = empty($_GET['type1'])?'customer':$_GET['type1'];
if($show_type == 'graph'){
	if($type1=='customer'){
		$sql="SELECT c.supplyname as name, sum(b.lirun) as sum FROM sellplanmain a LEFT JOIN sellplanmain_detail b on b.mainrowid=a.billid LEFT JOIN customer c on a.supplyid=c.ROWID WHERE a.user_flag>0 and a.createtime>='".$start_time."' and a.createtime<='".$end_time."' GROUP BY a.supplyid order by sum desc";
	}elseif ($type1=='product'){
		$sql="SELECT b.prodname as name, sum(b.lirun) as sum FROM sellplanmain_detail b LEFT JOIN sellplanmain a on b.mainrowid=a.billid WHERE a.user_flag>0 and a.createtime>='".$start_time."' and a.createtime<='".$end_time."' GROUP BY b.prodid order by sum desc";
	}elseif ($type1=='order'){
		$sql="SELECT a.zhuti as name, sum(b.lirun) as sum FROM sellplanmain a LEFT JOIN sellplanmain_detail b on b.mainrowid=a.billid WHERE a.user_flag>0 and a.createtime>='".$start_time."' and a.createtime<='".$end_time."' GROUP BY a.billid order by sum desc";
	}elseif ($type1=='man'){
		$sql="SELECT c.USER_NAME as name, sum(b.lirun) as sum FROM sellplanmain a LEFT JOIN sellplanmain_detail b on b.mainrowid=a.billid LEFT JOIN `user` c on a.qianyueren=c.USER_ID WHERE a.user_flag>0 and a.createtime>='".$start_time."' and a.createtime<='".$end_time."' GROUP BY c.USER_ID order by sum desc";
	}
	$rs=$db->Execute($sql);
	$rs_a = $rs->GetArray();
	$mingci = 20;  // 对前多少条？记录进行统计
	
	if(isset($rs_a[$mingci])){
		$sum = 0;
		$len = sizeof($rs_a);
		
		for ($i=$mingci;$i<$len;$i++){
			$sum+=$rs_a[$i][sum];
			unset($rs_a[$i]);
		}
		$rs_a[$mingci]['name'] = '其它';
		$rs_a[$mingci]['sum'] = $sum;
	}
}elseif($show_type='table'){
	if($type1=='customer'){
		$sql="SELECT c.supplyname as name, sum(b.lirun) as sum, sum(b.totalmoney) as totalmoney,sum(b.lirun)/sum(a.totalmoney)*100 as lilvu FROM sellplanmain a LEFT JOIN (select mainrowid,sum(lirun) as lirun,sum(num*price*zhekou) as totalmoney from sellplanmain_detail group by mainrowid) b on b.mainrowid=a.billid LEFT JOIN customer c on a.supplyid=c.ROWID WHERE a.user_flag>0 and a.createtime>='".$start_time."' and a.createtime<='".$end_time."' GROUP BY a.supplyid";
	}elseif ($type1=='product'){
		$sql="SELECT prodname as name, sum(lirun) as sum, sum(num*price*zhekou) as totalmoney,sum(lirun)/sum(num*price*zhekou)*100 as lilvu FROM sellplanmain_detail WHERE mainrowid in (select billid from sellplanmain where user_flag>0 and createtime>='".$start_time."' and createtime<='".$end_time."') GROUP BY prodid";
	}elseif ($type1=='order'){
		$sql="SELECT a.zhuti as name, sum(b.lirun) as sum, sum(num*price*zhekou) as totalmoney, sum(b.lirun)/sum(num*price*zhekou)*100 as lilvu FROM sellplanmain a LEFT JOIN sellplanmain_detail b on b.mainrowid=a.billid WHERE a.user_flag>0 and a.createtime>='".$start_time."' and a.createtime<='".$end_time."' GROUP BY a.billid";
	}elseif ($type1=='man'){
		$sql="SELECT c.USER_NAME as name, sum(b.lirun) as sum, sum(num*price*zhekou) as totalmoney, sum(b.lirun)/sum(num*price*zhekou)*100 as lilvu FROM sellplanmain a LEFT JOIN sellplanmain_detail b on b.mainrowid=a.billid LEFT JOIN `user` c on a.qianyueren=c.USER_ID WHERE a.user_flag>0 and a.createtime>='".$start_time."' and a.createtime<='".$end_time."' GROUP BY c.USER_ID";
	}

	if($_GET['doubletime'] == 2){
		$sc = 'asc';
		$order_img = '<img src="images/arrow_up.gif" border="0">';
	}else{
		$sc = 'desc';
		$order_img = '<img src="images/arrow_down.gif" border="0">';
	}
	switch ($_GET['ordername'])
	{
		case 'name':
			$order = 'name';break;
		case 'totalmoney':
			$order = 'totalmoney';break;
		case 'oddment':
			$order = 'oddment';break;
		default:
			$order = 'sum';
	}
	$sql.=" order by ".$order.' '.$sc;

	$rs=$db->Execute($sql);
	$rs_a = $rs->GetArray();

	for($i=0;$i<sizeof($rs_a);$i++)
	{
		$rs_a[$i]['totalmoney']=round($rs_a[$i]['totalmoney'],2);
		$rs_a[$i]['sum']=round($rs_a[$i]['sum'],2);
		$rs_a[$i]['lilvu']=number_format($rs_a[$i]['lilvu'],2,".",",")."%";
	}
	
	$head=array("name"=>"客户名称","totalmoney"=>"总金额","sum"=>"利润","lilvu"=>"利润率");
$headtype=array("name"=>"string","totalmoney"=>"float","sum"=>"float","lilvu"=>"percent");
$title="毛利汇总";
$sumcol=array("totalmoney"=>"","sum"=>"");

	if($_GET['out_excel'] == 'true'){
		
		export_XLS($head,$rs_a,$title,$sumcol);
		exit;
	}
}
?>
<html>
<head>
<?php page_css($title); ?>
<SCRIPT src="../../Enginee/WdatePicker/WdatePicker.js"></SCRIPT>
<script language="javascript" src="../LODOP60/LodopFuncs.js"></script>
<object  id="LODOP_OB" classid="clsid:2105C259-1E0C-4534-8141-A753534CB4CA"
	width=0 height=0> <embed id="LODOP_EM" type="application/x-print-lodop"
		width=0 height=0></embed>
</object>
</head>
<body class=bodycolor topMargin=5>
<div id='con'>
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
							
							显示方式:
							<select class="SmallSelect" name="show_type">
							<option <?php echo ($show_type=='table')?'selected':''; ?> value="table">表格</option>
							<option <?php echo ($show_type=='graph')?'selected':''; ?> value="graph">图形</option>
							</select>	
						

						汇总方式：<select class="SmallSelect" name="type1">
							<option <?php echo ($type1=='customer')?'selected':''; ?> value="customer">按客户汇总</option>
							<option <?php echo ($type1=='product')?'selected':''; ?> value="product">按产品汇总</option>
							<option <?php echo ($type1=='order')?'selected':''; ?> value="order">按订单汇总</option>
							<option <?php echo ($type1=='man')?'selected':''; ?> value="man">按业务员汇总</option>
						</select>							

						<input class="SmallButtonA" type="submit" accesskey="f" value="查询" name="button" id="searchbtn">												
						</td>
					</tr>
				</thead>
			</table>
			</form>
			</td>
		</tr>
	</thead>


<?php if($show_type == 'graph'){

?>
</table>
</div>
<!-- START Script Block for Chart index -->
<script type="text/javascript"
	src="../../Framework/FusionCharts/FusionCharts.js"></script>
<div id="indexDiv" align="center">Chart.</div>
<script type="text/javascript"> 
//Instantiate the Chart 
var chart_index = new FusionCharts("../../Framework/FusionCharts/Column3D.swf", "index", "100%", "550", "0", "0");

//chart_index.setTransparent("false");
//Provide entire XML data using dataXML method
chart_index.setDataXML("<graph bgcolor='e1f5ff' caption='毛利汇总' subCaption='精确到百位（四舍五入）' numberPrefix='' formatNumberScale='1' decimalPrecision='2' baseFontSize='14' numberSuffix='万'><?php foreach ($rs_a as $key=>$vo){echo "<set name='".$vo[name]."' value='".($vo[sum]/10000)."'/>";}?></graph>");
chart_index.render("indexDiv");
</script>
<!-- END Script Block for Chart index -->

<?php }elseif($show_type == 'table'){?>

		<tr >
			<td colspan="11" class="TableHeader">&nbsp;毛利汇总</td>
		</tr>

		<tr class=TableHeader>

		<?php 
	foreach ($head as $key=>$val)
	{
?>
		<td nowrap align=center><?php echo $val?></td>
<?php 
	}
?></tr>
	<?php
	foreach($rs_a as $row)
	{
		echo "<tr class=TableData>";
		foreach ($head as $key=>$val)
		{

			if($headtype[$key]=="int" || $headtype[$key]=="float" || $headtype[$key]=="percent")
				$align="right";
			else if($headtype[$key]=="char")
				$align="center";
			else
				$align="left";
			echo "<td nowrap align='".$align."'>";
			if($headtype[$key]=="float")
				echo number_format($row[$key],2,".",",");
			else
				echo $row[$key];
			echo "</td>";
			foreach ($sumcol as $sumkey=>$sumval)
			{
				if($sumkey==$key)
					$sumcol[$sumkey]+=$row[$key];
			}
		}
		echo "</tr>";
	}
	?>

	<tr class="TableHeader">
<?php 
	$i=0;
	foreach ($head as $key=>$val)
	{
		if($i==0)
			print "<td>合计 <b>".sizeof($rs_a)."</b> 条记录</td>";
		else
		{
			print "<td align=right><b>";
			foreach ($sumcol as $sumkey=>$sumval)
			{
				if($sumkey==$key)
				{
					if(is_float($sumval))
						echo number_format($sumval,2,".",",");
					else 
						echo $sumval;
				}
			}
			print "</b></td>";
		}
		$i++;
	}
?>	</tr>

</table>
</div>
<form>
<p align="center"><input type="button" class="SmallButton" value=" 打印 "
	onclick="javascript:prn_print();">&nbsp;<input type="button"
	class="SmallButton" value="导出"
	onclick="location='?out_excel=true&start_time=<?php echo $_GET[start_time];?>&end_time=<?php echo $_GET[end_time];?>&type1=<?php echo $type1?>';"></p>
</form>
<script language="javascript" type="text/javascript">   
    var LODOP; //声明为全局变量 
	function prn_print() {		
		CreateOneFormPage();
		LODOP.PREVIEW();
		//LODOP.PRINT();	
	};

	function CreateOneFormPage(){
	
		LODOP=getLodop(document.getElementById('LODOP_OB'),document.getElementById('LODOP_EM'));  

		LODOP.PRINT_INIT("<?php echo $title?>");
		LODOP.SET_PRINT_PAGESIZE(2,0,0,"");
		document.getElementById("searchbtn").style.display="none";
		LODOP.ADD_PRINT_TABLE("10%","10%","80%","80%",document.documentElement.innerHTML);
		document.getElementById("searchbtn").style.display="";
		LODOP.SET_PRINT_MODE("PRINT_PAGE_PERCENT","Auto-Width");
		
	};              
	

</script>



<?php }?>
</body>
</html>










