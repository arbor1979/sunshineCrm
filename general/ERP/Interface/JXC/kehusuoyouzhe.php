<?php
ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL);
error_reporting(E_WARNING | E_ERROR);
require_once('lib.inc.php');
$GLOBAL_SESSION=returnsession();
validateMenuPriv("归属人排行");
global $db;
if(empty($_GET['start_time'])) {
	$start_time = date("Y-m-01 00:00:00");
	$end_time = date("Y-m-d 23:59:59");
}else{
	$start_time = $_GET['start_time'];
	$end_time = $_GET['end_time'];
}



$product_type=$_GET['product_type'];
if($product_type!='')
	$product_name=returntablefield("producttype","ROWID", $product_type, "name");
$ordername=$_GET['ordername'];
if($ordername=='')
		$ordername='jine';
$order_img = '<img src="images/arrow_down.gif" border="0">';
$supplyid=$_GET['supplyid'];

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

$sql="SELECT e.USER_ID,e.USER_NAME as name,sum(if(a.num>0,a.jine,0)) as selljine,sum(if(a.num<0,a.jine,0))
 as backjine,sum(a.jine) as jine,sum(a.lirun) as lirun from sellplanmain_detail a 
inner join product b on a.prodid=b.productid inner join sellplanmain c on a.mainrowid=c.billid inner join customer d 
on c.supplyid=d.ROWID inner join user e on d.sysuser=e.USER_ID where c.user_flag>0";

if($start_time!='')
	$sql.=" and a.inputtime>='$start_time'";
if($end_time!='')
	$sql.=" and a.inputtime<='$end_time'";

if($product_type!='')
{
	$subtype=getSubprodtypeByParent($product_type);
	if($subtype!='')
		$subtype.=",".$product_type;
	else 
		$subtype=$product_type;
	$sql.=" and b.producttype in ($subtype)";
}
$sql.= " group by e.USER_ID,e.USER_NAME";
$rs=$db->Execute($sql);
$rs_b = $rs->GetArray();
for($i=0;$i<sizeof($rs_b);$i++)
{
	if(floatval($rs_b[$i]['selljine'])!=0)
		$rs_b[$i]['percent']=round(-floatval($rs_b[$i]['backjine'])/floatval($rs_b[$i]['selljine'])*100)."%";
	if(floatval($rs_b[$i]['jine'])!=0)
		$rs_b[$i]['lirunrate']=round(floatval($rs_b[$i]['lirun'])/floatval($rs_b[$i]['jine'])*100)."%";
	$sql="select count(*) as allnum from customer where sysuser='".$rs_b[$i]['USER_ID']."'";
	$rs=$db->Execute($sql);
	$rs_c=$rs->GetArray();
	$rs_b[$i]['custnum']=$rs_c[0]['allnum'];
}
$rs_all=array_sort($rs_b,$ordername,"dec");

$head=array("name"=>"归属人","custnum"=>"管理客户数","selljine"=>"销售金额","backjine"=>"退货金额","percent"=>"退货率","jine"=>"实际金额");
$headtype=array("name"=>"string","custnum"=>"int","selljine"=>"float","backjine"=>"float","percent"=>"float","jine"=>"float");
$title="归属人排行";
$sumcol=array("selljine"=>"","backjine"=>"","jine"=>"");

if($_SESSION['LOGIN_USER_PRIV']==1)
{
	$head["lirun"]="利润";
	$headtype["lirun"]="float";
	$sumcol["lirun"]="";
	$head["lirunrate"]="利润率";
	$headtype["lirunrate"]="float";
}
if($_GET['out_excel'] == 'true'){
	
	export_XLS($head,$rs_all,$title,$sumcol);
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
			<form name='form1' action='' method="get">
			<table width="100%" class="Small" border="0">
				<thead>
					<tr>
						<td class='nowrap'>时间段： <input class="SmallInput" size="19"
							name="start_time" value="<?php echo $start_time; ?>"
							onclick="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss'})"> — <input
							class="SmallInput" size="19" name="end_time"
							value="<?php echo $end_time; ?>"
							onclick="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss'})"> 
							
							
							类别筛选:
							<select class="SmallSelect" name="product_type"  onclick="SelectAllInforSingle('../../Enginee/Module/prodtype_select_single/index.php','','product_type', 'product_type_ID','3','form1');">
							<option selected value="">-全部-</option>
							<?php if($product_type!=''){?>
							<option selected value="<?php echo $product_type?>" selected><?php echo $product_name?></option>
							<?php }?>
							</select>
							
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
			<td colspan="11" class="TableHeader">&nbsp;<?php echo $title?> </td>
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
			ondblclick="location='?<?php echo $url?>&ordername=<?php echo $key?>'"><?php echo $val?><?php echo ($ordername==$key)?$order_img:''; ?></td><?php 
	}
?></tr>
	<?php
foreach($rs_all as $row)
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
				case "归属人":
					print "<a target='_blank' href='customs_ranking_list_newai.php?".base64_encode("start_time=".$start_time."&end_time=".$end_time."&show_type=table&sysuser=".$row['USER_ID'])."'>".$row[$key]."</a>";
					break;
				
				default: 
					if($headtype[$key]=="float")
					{
						if(stristr($row[$key],"%") || $row[$key]=='')
							echo $row[$key];
						else
							echo number_format($row[$key],2,".",",");
					}
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
			print "<td>合计 <b>".sizeof($rs_all)."</b> 条记录</td>";
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
			if($key=='percent' && intval($sumcol['selljine'])!=0)
				echo round(-$sumcol['backjine']/$sumcol['selljine']*100)."%";
			if($key=='lirunrate' && intval($sumcol['jine'])!=0)
				echo round($sumcol['lirun']/$sumcol['jine']*100)."%";
			print "</b></td>";
		}
		$i++;
	}
	
?>
		
	</tr>
</table>
</div>

<p align="center"><input type="button" class="SmallButton" value=" 打印 "
	onclick="javascript:prn_print();">&nbsp;<input type="button"
	class="SmallButton" value="导出"
	onclick="location='?<?php echo FormPageAction2("ordername",$ordername);?>&out_excel=true';"></p>


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
		LODOP.ADD_PRINT_TABLE("10%","10%","80%","100%",document.getElementById('con').innerHTML);
		document.getElementById("searchbtn").style.display="";
		LODOP.SET_PRINT_MODE("PRINT_PAGE_PERCENT","Auto-Width");
		
	};              
	

</script>

<?php 

}elseif($show_type=='graph'){

	$mingci = 20;  // 对前？条记录进行统计
	if(isset($rs_all[$mingci])){
		$sum = 0;
		$len =  count($rs_all);
		for ($i=$mingci;$i<$len;$i++){
			$sum+=$rs_all[$i]['jine'];
			unset($rs_all[$i]);
		}
		$rs_all[$mingci]['name'] = '其它';
		$rs_all[$mingci]['jine'] = $sum;
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
chart_index.setDataXML("<graph bgcolor='e1f5ff' caption='<?php echo $title?>' subCaption='精确到百位（四舍五入）' numberPrefix='' formatNumberScale='1' decimalPrecision='2' baseFontSize='14' numberSuffix='万元'><?php foreach ($rs_all as $row){echo "<set name='".$row['name']."' value='".($row['jine']/10000)."'/>";}?></graph>");
chart_index.render("indexDiv");
</script>
<!-- END Script Block for Chart index -->
<?php }?>

</body>

</html>










