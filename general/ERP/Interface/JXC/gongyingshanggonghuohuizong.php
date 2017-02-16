<?php
ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL);
error_reporting(E_WARNING | E_ERROR);
require_once('lib.inc.php');
$GLOBAL_SESSION=returnsession();
validateMenuPriv("供应商供货汇总");
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

switch ($_GET['ordername'])
{
	case 'supplyname':
		$order = 'supplyname';break;
	case 'count':
		$order = 'count';break;
	case 'sum_paymoney':
		$order = 'sum_paymoney';break;
	case 'sum_qiankuan':
		$order = 'sum_qiankuan';break;
	case 'num':
		$order = 'num';break;
	case 'sum_ruku':
		$order = 'sum_ruku';break;
	default:
		$order = 'sum_totalmoney';
}

$show_type=$_GET['show_type'];
if($show_type == 'graph'){
	$type=$_GET['type'];
	if($type=='zhu' || $type == ''){
		$swf = 'Column3D.swf';
	}elseif ($type=='bing'){
		$swf = 'Pie2D.swf';
	}
}

if($_GET['doubletime'] == 2){
	$sc = 'asc';
	$order_img = '<img src="images/arrow_up.gif" border="0">';
}else{
	$sc = 'desc';
	$order_img = '<img src="images/arrow_down.gif" border="0">';
}


$sql="SELECT * FROM (SELECT a.supplyid,c.supplyname, sum(a.totalmoney) as sum_totalmoney,COUNT(*) as count,sum(a.paymoney) as sum_paymoney,(sum(a.totalmoney)-sum(a.paymoney)-sum(a.oddment)) as sum_qiankuan,sum(rukumoney) as sum_ruku FROM buyplanmain a  left JOIN supply c on (a.supplyid=c.ROWID) WHERE a.user_flag > 0  and  a.caigoudate>='".$start_time."' and a.caigoudate<='".$end_time."' GROUP BY a.supplyid) k join (SELECT e.supplyid as supplyid_1,sum(f.num) as num FROM buyplanmain_detail f JOIN buyplanmain e on (f.mainrowid=e.billid ) where e.user_flag>0  and  e.caigoudate>='".$start_time."' and e.caigoudate<='".$end_time."' GROUP BY e.supplyid)  g on (k.supplyid=g.supplyid_1) GROUP BY ".$order.' '.$sc;
//exit($sql);
$rs=$db->Execute($sql);
$rs_a = $rs->GetArray();

$head=array("supplyname"=>"供应商名称","count"=>"采购次数","sum_totalmoney"=>"采购总金额","num"=>"单品数量","sum_paymoney"=>"已支付金额","sum_qiankuan"=>"尚欠金额","sum_ruku"=>"入库金额");
$headtype=array("supplyname"=>"string","count"=>"char","sum_totalmoney"=>"float","num"=>"int","sum_paymoney"=>"float","sum_qiankuan"=>"float","sum_ruku"=>"float");
$title="供应商供货汇总";
$sumcol=array("count"=>"","sum_totalmoney"=>"","num"=>"","sum_paymoney"=>"","sum_qiankuan"=>"","sum_ruku"=>"");

//print_r($rs_a);exit;
if($_GET['out_excel'] == 'true'){
	
	export_XLS($head,$rs_a,$title,$sumcol);
	exit;
}
?>
<html>
<head>
<?php page_css($title); ?>
<script language="javascript" src="../LODOP60/LodopFuncs.js"></script>
<SCRIPT src="../../Enginee/WdatePicker/WdatePicker.js"></SCRIPT>
<object  id="LODOP_OB" classid="clsid:2105C259-1E0C-4534-8141-A753534CB4CA"
	width=0 height=0> <embed id="LODOP_EM" type="application/x-print-lodop"
		width=0 height=0></embed> </object>
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
						<td class='nowrap'>时间段： <input class="SmallInput" size="19"
							name="start_time" value="<?php echo $start_time; ?>"
							onclick="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss'})"> — <input
							class="SmallInput" size="19" name="end_time"
							value="<?php echo $end_time; ?>"
							onclick="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss'})">
							
							显示方式:
							<select class="SmallSelect" name="show_type">
							<option <?php echo ($show_type=='table')?'selected':''; ?> value="table">表格</option>
							<option <?php echo ($show_type=='graph')?'selected':''; ?> value="graph">图形</option>
							</select>	
						
							<?php if($show_type=='graph'){?>
							图表类型:
							<select class="SmallSelect" name="type">
							<option <?php echo ($type=='zhu')?'selected':''; ?> value="zhu">柱状图</option>
							<option <?php echo ($type=='bing')?'selected':''; ?> value="bing">饼状图</option>
							</select>	
							<?php }?>
																					
							 <input
							class="SmallButtonA" type="submit" accesskey="f" value="查询"
							name="button" id="searchbtn"></td>
					</tr>
				</thead>
			</table>
			</form>
			</td>
		</tr>
		<tr>
			<td colspan="11" class="TableHeader">&nbsp;<?php echo $title?></td>
		</tr>
	</thead>

<?php if($show_type=='table' || empty($show_type)){?>
		<tr class=TableHeader>
<?php 
	foreach ($head as $key=>$val)
	{
?>
		<td nowrap align=center
			ondblclick="location='?start_time=<?php echo $start_time?>&end_time=<?php echo $end_time;?>&doubletime=<?php echo ($_GET['doubletime']==1)?2:1;?>&ordername=<?php echo $key?>'"><?php echo $val?><?php echo ($_GET['ordername']==$key)?$order_img:''; ?></td>
<?php 
	}
?>
		</tr>
		<?php
	foreach($rs_a as $row)
	{
		echo "<tr class=TableData>";
		foreach ($head as $key=>$val)
		{
			if($headtype[$key]=="int" || $headtype[$key]=="float")
				$align="right";
			else if($headtype[$key]=="char")
				$align="center";
			else
				$align="left";
			echo "<td nowrap align='".$align."'>";
			switch($val){
				case "供应商名称":
					print "<a target='_blank' href='supply_newai.php?action=view_default&ROWID=".$row['supplyid']."'>".$row['supplyname']."</a>";
					break;

				case "采购总金额":	
					print "<a target='_blank' href='gongyingshanggonghuomingxi.php?supplyid=".$row['supplyid']."&start_time=".$start_time."&end_time=".$end_time."&where=sum_totalmoney'>".number_format($row['sum_totalmoney'],2,'.',',')."</a>";
					break;	
				case "交易次数":	
					print "<a target='_blank' href='gongyingshanggonghuomingxi.php?supplyid=".$row['supplyid']."&start_time=".$start_time."&end_time=".$end_time."'>".$row['count']."</a>";
					break;
				case "已支付金额":
					print "<a target='_blank' href='gongyingshanggonghuomingxi.php?supplyid=".$row['supplyid']."&start_time=".$start_time."&end_time=".$end_time."&where=sum_paymoney'>".number_format($row['sum_paymoney'],2,'.',',')."</a>";
					break;
				case "尚欠金额":
					print "<a target='_blank' href='gongyingshanggonghuomingxi.php?supplyid=".$row['supplyid']."&start_time=".$start_time."&end_time=".$end_time."&where=sum_qiankuan'>".number_format($row['sum_qiankuan'],2,'.',',')."</a>";
					break;
				case "入库金额":
					print "<a target='_blank' href='gongyingshanggonghuomingxi.php?supplyid=".$row['supplyid']."&start_time=".$start_time."&end_time=".$end_time."&where=sum_ruku'>".number_format($row['sum_ruku'],2,'.',',')."</a>";
					break;
				
				default: 
					echo $row[$key];
				
			}
			
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
	onclick="location='?out_excel=true&start_time=<?php echo $_GET[start_time];?>&end_time=<?php echo $_GET[end_time];?>&ordername=<?php echo $_GET['ordername']?>&doubletime=<?php  echo $_GET['doubletime'] ?>';"></p>
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
		LODOP.ADD_PRINT_TABLE("10%","10%","80%","100%",document.documentElement.innerHTML);
		document.getElementById("searchbtn").style.display="";
		LODOP.SET_PRINT_MODE("PRINT_PAGE_PERCENT","Auto-Width");
		
	};              
	

</script>


<?php 

}elseif($show_type=='graph'){
	$mingci = 20;  // 对前？条记录进行统计
	if(isset($rs_a[$mingci])){
		$sum = 0;
		$len =  count($rs_a);
		for ($i=$mingci;$i<$len;$i++){
			$sum+=$rs_a[$i][sum_totalmoney];
			unset($rs_a[$i]);
		}
		$rs_a[$mingci]['supplyname'] = '其它';
		$rs_a[$mingci]['sum_totalmoney'] = $sum;
	}
?>
</table>
</div>

<!-- START Script Block for Chart index -->
<script type="text/javascript"
	src="../../Framework/FusionCharts/FusionCharts.js"></script>
<div id="indexDiv" align="center">Chart.</div>
<script type="text/javascript"> 
//Instantiate the Chart 
var chart_index = new FusionCharts("../../Framework/FusionCharts/<?php echo $swf; ?>", "index", "100%", "550", "0", "0");
//chart_index.setTransparent("false");

//Provide entire XML data using dataXML method
chart_index.setDataXML("<graph bgcolor='e1f5ff' caption='供应商供货汇总' subCaption='精确到百位（四舍五入）' numberPrefix='' formatNumberScale='1' decimalPrecision='2' baseFontSize='14' numberSuffix='万元'><?php foreach ($rs_a as $row){echo "<set name='".$row['supplyname']."' value='".($row['sum_totalmoney']/10000)."'/>";}?></graph>");
chart_index.render("indexDiv");
</script>
<!-- END Script Block for Chart index -->
<?php
}
?>

</body>

</html>










