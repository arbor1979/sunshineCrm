<?php
ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL);
error_reporting(E_WARNING | E_ERROR);
require_once('lib.inc.php');
$GLOBAL_SESSION=returnsession();
global $db;
validateMenuPriv("库存报警");
$type=empty($_GET['type'])?"storemin":$_GET['type'];
$where = '';
if($type == 'storemax'){
	$where = '>';
	$lable1 = '库存上限';
	$title = '库存报警——库存过多商品';
}elseif ($type=='storemin'){
	$where = '<';
	$lable1 = '库存下限';
	$title = '库存报警——库存过少商品';
}else{
	exit('参数错误！');
}

switch ($_GET['ordername'])
{
	case 'productid':
		$order = 'productid';break;
	case 'a.productname':
		$order = 'a.productname';break;
	case 'mode':
		$order = 'mode';break;
	case 'standard':
		$order = 'standard';break;
	case 'name':
		$order = 'name';break;
	case 'fileaddress':
		$order = 'fileaddress';break;
	case 'num':
		$order = 'num';break;
	case 'storemin':
	case 'storemax':
		$order = $type;break;
	default:
		$order = '(abs(num-'.$type.'))'; 
}
if($_GET['doubletime'] == 2){
	$sc = 'asc';
	$order_img = '<img src="images/arrow_up.gif" border="0">';
}else{
	$sc = 'desc';
	$order_img = '<img src="images/arrow_down.gif" border="0">';
}

$sql="SELECT a.productid,a.productname,a.`mode`,a.standard,e.name,a.fileaddress,c.num,a.".$type." FROM product a LEFT JOIN (SELECT b.prodid,SUM(b.num) as num  FROM store b GROUP BY b.prodid) c on a.productid=c.prodid left join producttype e on a.producttype=e.ROWID WHERE c.num".$where."a.".$type." and ".$type.">0 order by ".$order.' '.$sc;
//exit($sql);
$rs=$db->Execute($sql);
$rs_a = $rs->GetArray();

$head=array("productid"=>"产品编号","productname"=>"产品名称","num"=>"库存数量",$type=>$lable1,"standard"=>"颜色","mode"=>"规格","name"=>"产品类型","fileaddress"=>"产品图片");
$headtype=array("productid"=>"string","productname"=>"string","num"=>"int","$type"=>"int","standard"=>"string","mode"=>"string","name"=>"string","fileaddress"=>"img");
$title="库存报警";
$sumcol=array("num"=>"");

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
<script type="text/javascript" language="javascript" src="../../Enginee/jquery/jquery.js"></script>
<script type="text/javascript" language="javascript" src="../../Enginee/jquery/jquery.magnifier.js"></script>
							
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
						<td class='nowrap'>
							筛选条件:
							<select class="SmallSelect" name="type">
							<option <?php echo ($type=='storemax')?'selected':''; ?> value="storemax">库存过多商品</option>
							<option <?php echo ($type=='storemin')?'selected':''; ?> value="storemin">库存过少商品</option>
							</select>	
										
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
			<td colspan="11" class="TableHeader">&nbsp;<?php echo $title; ?></td>
		</tr>
	</thead>

	<tr class=TableHeader>

		<?php 
	foreach ($head as $key=>$val)
	{
?>
		<td nowrap align=center
			ondblclick="location='?start_time=<?php echo $start_time?>&end_time=<?php echo $end_time;?>&doubletime=<?php echo ($_GET['doubletime']==1)?2:1;?>&ordername=<?php echo $key?>'"><?php echo $val?><?php echo ($_GET['ordername']==$key)?$order_img:''; ?></td>
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
			if($headtype[$key]=="float")
				echo number_format($row[$key],2,".",",");
			else if($headtype[$key]=="img" && $row[$key]!='')
				echo "<img src='".$row[$key]."' height=25  class='magnify'  data-magnifyto='500' onmouseover=\"this.style.cursor='pointer';this.style.cursor='hand'\" onmouseout=\"this.style.cursor='default'\">";
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
	onclick="location='?out_excel=true&type=<?php echo $_GET[type];?>';"></p>
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

</body>

</html>










