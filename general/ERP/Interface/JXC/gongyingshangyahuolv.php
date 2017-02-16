<?php
ini_set('display_errors', 1);
error_reporting(E_ERROR);
require_once('lib.inc.php');
$GLOBAL_SESSION=returnsession();
validateMenuPriv("供应商压货率");
global $db;
if(empty($_GET['start_time'])) {
	$start_time = date("1970-01-01 00:00:00");
	$end_time = date("Y-m-01 23:59:59");
}else{
	$start_time = $_GET['start_time'];
	$end_time = $_GET['end_time'];
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

$product_type=$_GET['product_type'];
if($product_type!='')
	$product_name=returntablefield("producttype","ROWID", $product_type, "name");
$ordername=$_GET['ordername'];
$order_img = '<img src="images/arrow_down.gif" border="0">';
$supplyid=$_GET['supplyid'];
if($supplyid!='')
	$supplyname=returntablefield("supply", "rowid",$supplyid,"supplyname");



function mergArray($prikey)
{
	global $rs_all,$rs_b;
	foreach ($rs_b as $row)
	{
		$flag=false;
		foreach ($rs_all as $key=>$rowall)
		{
			if($rowall[$prikey]==$row[$prikey])
			{
				$rs_all[$key]=$rs_all[$key]+$row;
				$flag=true;
				break;
			}
		}
		if(!$flag)
			$rs_all[]=$row;
	}
}


	if($ordername=='')
		$ordername='jine';
	$rs_all=array();
	//采购
	$sql="SELECT b.supplyid,e.supplyname as name,e.phone,sum(round(price*zhekou,2)*num) as buyjine from buyplanmain_detail a inner join product b on 
	a.prodid=b.productid inner join producttype c on b.producttype=c.ROWID inner join buyplanmain d on a.mainrowid=d.billid inner join supply e on b.supplyid=e.ROWID where d.user_flag>0";
	if($start_time!='')
		$sql.=" and a.inputtime>='$start_time'";
	if($end_time!='')
		$sql.=" and a.inputtime<='$end_time'";
	if($supplyid!='')
		$sql.=" and b.supplyid=$supplyid";
	if($product_type!='')
	{
		$subtype=getSubprodtypeByParent($product_type);
		if($subtype!='')
			$subtype.=",".$product_type;
		else 
			$subtype=$product_type;
		$sql.=" and c.ROWID in ($subtype)";
	}
	$sql.= " group by b.supplyid,e.supplyname,e.phone";
	$rs=$db->Execute($sql);
	$rs_b = $rs->GetArray();
	$rs_all=$rs_b;
	//销售
	$sql="SELECT b.supplyid,e.supplyname as name,e.phone,sum(round(price*zhekou,2)*num) as selljine from sellplanmain_detail a inner join product b on 
	a.prodid=b.productid inner join producttype c on b.producttype=c.ROWID inner join sellplanmain d on a.mainrowid=d.billid inner join supply e on b.supplyid=e.ROWID where d.user_flag>0";
	if($start_time!='')
		$sql.=" and a.inputtime>='$start_time'";
	if($end_time!='')
		$sql.=" and a.inputtime<='$end_time'";
	if($supplyid!='')
		$sql.=" and b.supplyid=$supplyid";
	if($product_type!='')
	{
		$subtype=getSubprodtypeByParent($product_type);
		if($subtype!='')
			$subtype.=",".$product_type;
		else 
			$subtype=$product_type;
		$sql.=" and c.ROWID in ($subtype)";
	}
	$sql.= " group by b.supplyid,e.supplyname,e.phone";
	$rs=$db->Execute($sql);
	$rs_b = $rs->GetArray();
	mergArray('supplyid');	
	
	//盘点
	$sql="SELECT b.supplyid,e.supplyname as name,e.phone,sum(round(price*zhekou,2)*num) as checkjine from storecheck_detail a inner join product b on 
	a.prodid=b.productid inner join producttype c on b.producttype=c.ROWID inner join storecheck d on a.mainrowid=d.billid inner join supply e on b.supplyid=e.ROWID where d.state='盘点结束'";
	if($start_time!='')
		$sql.=" and a.inputtime>='$start_time'";
	if($end_time!='')
		$sql.=" and a.inputtime<='$end_time'";
	if($supplyid!='')
		$sql.=" and b.supplyid=$supplyid";
	if($product_type!='')
	{
		$subtype=getSubprodtypeByParent($product_type);
		if($subtype!='')
			$subtype.=",".$product_type;
		else 
			$subtype=$product_type;
		$sql.=" and c.ROWID in ($subtype)";
	}
	$sql.= " group by b.supplyid,e.supplyname,e.phone";
	$rs=$db->Execute($sql);
	$rs_b = $rs->GetArray();
	mergArray('supplyid');
	
	//库存
	$sql="SELECT b.supplyid,e.supplyname as name,e.phone,sum(price*num) as jine from store a inner join product b on 
	a.prodid=b.productid inner join producttype c on b.producttype=c.ROWID inner join supply e on b.supplyid=e.ROWID where num>0";
	if($supplyid!='')
		$sql.=" and b.supplyid=$supplyid";
	if($product_type!='')
	{
		$subtype=getSubprodtypeByParent($product_type);
		if($subtype!='')
			$subtype.=",".$product_type;
		else 
			$subtype=$product_type;
		$sql.=" and c.ROWID in ($subtype)";
	}
	$sql.= " group by b.supplyid,e.supplyname,e.phone";
	$rs=$db->Execute($sql);
	$rs_b = $rs->GetArray();
	mergArray('supplyid');
	
	for($i=0;$i<sizeof($rs_all);$i++)
	{
		if($rs_all[$i]['buyjine']!=0)
			$rs_all[$i]['yahuorate']=(round($rs_all[$i]['jine']/$rs_all[$i]['buyjine'],2)*100)."%";
	}
				
	$rs_all=array_sort($rs_all,$ordername,"dec");
	$head=array("name"=>"供应商","phone"=>"联系方式","buyjine"=>"采购金额","selljine"=>"销售金额","checkjine"=>"盘点金额","jine"=>"库存金额","yahuorate"=>"压货率");
	$headtype=array("name"=>"string","phone"=>"string","buyjine"=>"float","selljine"=>"float","checkjine"=>"float","jine"=>"float","yahuorate"=>"float");
	$sumcol=array("buyjine"=>"","selljine"=>"","checkjine"=>"","jine"=>"");
	


$title="供应商压货率";
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
							<option selected value="">全部产品</option>
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
							&nbsp;		
							<br><br>供应商：
							<input type="hidden"  name="supplyid" value="<?php echo $supplyid?>"><input name="supplyid_ID" value="<?php echo $supplyname?>" class="SmallStatic" readonly size=30>&nbsp;
<a href="javascript:;" class="orgAdd" onClick="SelectAllInforSingle('../../Enginee/Module/supply_select_single/index.php','','supplyid_ID', 'supplyid');">选择</a>
<a href="#" class="orgClear" onClick="ClearUser('supplyid_ID', 'supplyid')" title="清空">清空</a>			
							<input
							class="SmallButtonA" type="submit" accesskey="f" value="查询"
							name="button" id="searchbtn">
							
							</td>
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
		$url=FormPageAction2("ordername","");
?>
		<td nowrap align=center title='双击列标题可排序'
			ondblclick="location='?<?php echo $url?>&ordername=<?php echo $key?>'"><?php echo $val?><?php echo ($ordername==$key)?$order_img:''; ?></td>
<?php 
	}
?>
		</tr>
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
			if($headtype[$key]=="float")
			{
				if(stristr($row[$key],"%") || $row[$key]=='')
					echo $row[$key];
				else
					echo number_format($row[$key],2,".",",");
			}
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
			
			if($key=='yahuorate' && intval($sumcol['buyjine'])!=0)
				echo round($sumcol['jine']/$sumcol['buyjine']*100)."%";
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
	onclick="location='?<?php echo FormPageAction2("ordername",$ordername);?>&out_excel=true';"></p>
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

<?php 

}elseif($show_type=='graph'){

	$mingci = 20;  // 对前？条记录进行统计
	if(isset($rs_all[$mingci])){
		$sum = 0;
		$len =  count($rs_all);
		for ($i=$mingci;$i<$len;$i++){
			$sum+=$rs_all[$i][jine];
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
<?php
}
?>

</body>

</html>










