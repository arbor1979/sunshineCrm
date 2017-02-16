<?php
ini_set('display_errors', 1);
error_reporting(E_ERROR);
require_once('lib.inc.php');

$GLOBAL_SESSION=returnsession();
validateMenuPriv("导购排行");
global $db;
if($_GET['sb_button']=='' && $_GET['start_time']=='' && $_GET['out_excel']=='')
{
	$start_time = date("Y-m-01 00:00:00");
	$end_time = date("Y-m-d 23:59:59");
}
else{
	$start_time = $_GET['start_time'];
	$end_time = $_GET['end_time'];
}


$ordername=$_GET['ordername'];
if($ordername=='')
		$ordername='totalmoney';
$order_img = '<img src="images/arrow_down.gif" border="0">';


$show_type=$_GET['show_type'];
if($show_type == 'graph'){
	$type=$_GET['type'];
	if($type=='zhu' || $type == ''){
		$swf = 'Column3D.swf';
	}elseif ($type=='bing'){
		$swf = 'Pie2D.swf';
	}
}

//print_r($_GET);
$sql="select b.UID,`b`.`USER_NAME` AS `name`,sum(if(round(c.zhekou,2)<0.9,`c`.`jine`,0)) AS `zhekou<9`,
sum(if(round(c.zhekou,2)>=0.9 and round(c.zhekou,2)<0.95,`c`.`jine`,0)) AS `9<=zhekou<9.5`,
sum(if(round(c.zhekou,2)>=0.95 and round(c.zhekou,2)<0.98,`c`.`jine`,0)) AS `9.5<=zhekou<9.8`,
sum(if(round(c.zhekou,2)>=0.98 and round(c.zhekou,2)<1,`c`.`jine`,0)) AS `9.8<=zhekou<1`,
sum(if(round(c.zhekou,2)>=1,`c`.`jine`,0)) AS `1<=zhekou`,sum(jine) as totalmoney,sum(c.lirun) as lirun 
from `sellplanmain` `a` left join `user` `b` on a.qianyueren=b.USER_ID inner join sellplanmain_detail c 
on a.billid=c.mainrowid where a.qianyueren<>'' and a.user_flag>0 ";
if($start_time!='')
	$sql.=" and a.createtime>='".$start_time."'";
if($end_time!='')
	$sql.=" and a.createtime<='".$end_time."' ";
$sql.=" group by b.UID,b.USER_NAME";
//exit($sql);
$rs=$db->Execute($sql);
$rs_a = $rs->GetArray();
$rs_a=array_sort($rs_a,$ordername,"dec");
$head=array("name"=>"导购员","zhekou<9"=>"折<0.9","9<=zhekou<9.5"=>"0.9<=折<0.95",
"9.5<=zhekou<9.8"=>"0.95<=折<0.98","9.8<=zhekou<1"=>"0.98<=折<1",
"1<=zhekou"=>"1<=折","totalmoney"=>"合计");
$headtype=array("name"=>"char","zhekou<9"=>"float","9<=zhekou<9.5"=>"float","9.5<=zhekou<9.8"=>"float",
"9.8<=zhekou<1"=>"float","1<=zhekou"=>"float","totalmoney"=>"float");
$title="导购排行";
$sumcol=array("zhekou<9"=>"","9<=zhekou<9.5"=>"","9.5<=zhekou<9.8"=>"","9.8<=zhekou<1"=>"",
"1<=zhekou"=>"","totalmoney"=>"");
if($_SESSION['LOGIN_USER_PRIV']==1)
{
	$head["lirun"]="利润";
	$headtype["lirun"]="float";
	$sumcol["lirun"]="";
}
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
			<td nowrap='' colspan="13">
			<form action='' method="get">
			<table width="100%" class="Small" border="0">
				<thead>
					<tr>
						<td class='nowrap'>时间段： <input class="SmallInput" size="19"
							name="start_time" value="<?php echo $start_time; ?>"
							onclick="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss'})"
							readonly=""> — <input class="SmallInput" size="19"
							name="end_time" value="<?php echo $end_time; ?>"
							onclick="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss'})"
							readonly="">
							
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
							
							 <input class="SmallButtonA" type="submit"
							accesskey="f" value="查询" name="sb_button" id="sb_button"></td>
					</tr>
				</thead>
			</table>
			</form>
			</td>
		</tr>
		<tr>
			<td colspan="13" class="TableHeader">&nbsp;<?php echo $title?></td>
		</tr>
	</thead>

<?php if($show_type=='table' || empty($show_type)){?>
	<tr class=TableHeader>
<?php 
	foreach ($head as $key=>$val)
	{
		$url=FormPageAction2("ordername","");
?>
		<td nowrap align=center title='双击列标题可排序'
			ondblclick="location='?<?php echo $url?>&ordername=<?php echo $key?>'"><?php echo $val?><?php echo ($ordername==$key)?$order_img:''; ?></td>
<?php 
	}
?></tr>
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
				case "导购员":
					print "<a target='_blank' href='../Framework/user_newai.php?action=view_default&UID=".$row['UID']."'>".$row[$key]."</a>";
					break;				
				default:
					if($headtype[$key]=="float")
						echo number_format($row[$key],2);
					else 
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
<form>
<p align="center"><input type="button" class="SmallButton" value=" 打印 "
	onclick="javascript:prn_print();">&nbsp;<input type="button"
	class="SmallButton" value="导出"
	onclick="location='?out_excel=true&start_time=<?php echo $start_time?>&end_time=<?php echo $end_time?>&ordername=<?php echo $ordername?>';"></p>
</form>
<?php 

}elseif($show_type=='graph'){

	$mingci = 20;  // 对前？条记录进行统计
	if(isset($rs_a[$mingci])){
		$sum = 0;
		$len =  count($rs_a);
		for ($i=$mingci;$i<$len;$i++){
			$sum+=$rs_a[$i][totalmoney];
			unset($rs_a[$i]);
		}
		$rs_a[$mingci]['name'] = '其它';
		$rs_a[$mingci]['totalmoney'] = $sum;
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
chart_index.setDataXML("<graph bgcolor='e1f5ff' caption='<?php echo $title?>' subCaption='精确到百位（四舍五入）' numberPrefix='' formatNumberScale='1' decimalPrecision='2' baseFontSize='14' numberSuffix='万元'><?php foreach ($rs_a as $row){echo "<set name='".$row['name']."' value='".($row['totalmoney']/10000)."'/>";}?></graph>");
chart_index.render("indexDiv");
</script>
<!-- END Script Block for Chart index -->
<?php
}
?>

</body>

</html>
