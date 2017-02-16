<?php
ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL);
error_reporting(E_WARNING | E_ERROR);
require_once('lib.inc.php');
$GLOBAL_SESSION=returnsession();
validateMenuPriv("应付款汇总");
global $db;
$start_time = $_GET['start_time'];
$end_time = $_GET['end_time'];
if($_GET['sb_button']=='' && $start_time=='')
{
	$start_time = date("Y-m-01 00:00:00");
	$end_time = date("Y-m-d 23:59:59");
}
$supplyname=$_GET['supplyname'];

$title="应付款汇总";

if($_GET['out_excel'] == 'true'){

	//$title = mb_convert_encoding($title,"GB2312","UTF-8"); 
    header("Content-type: application/vnd.ms-excel; charset=utf-8");
	header("Content-Disposition: attachment; filename=".$title.".xls");
?>
<html>
<head>
<meta content="text/html; charset=gb2312" http-equiv="Content-Type">
</head>
	<body class=bodycolor topMargin=5>
<div id='con'>
<table class=TableBlock border=1 align=center width=100%>
	<thead>
		<tr>
			<td colspan="7">
			
			时间段：<?php echo $start_time; ?> — <?php echo $end_time; ?>
			&nbsp;供应商：<?php echo $supplyname;?>
			
			</td>
		</tr>
		<tr>
			<td colspan="7" class="TableHeader">&nbsp;<?php echo $title?></td>
		</tr>
	</thead>
<?php 	
}
else 
{
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
							
							
												
							&nbsp;供应商：<INPUT type="text" class="SmallInput" maxLength=200 size="25" name="supplyname" value="<?php echo $supplyname?>">				<input
							class="SmallButtonA" type="submit" accesskey="f" name="sb_button" value="查询"
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
<?php }?>

	<tr class=TableHeader>
<?php
$sql="select `b`.`ROWID` AS `rowid`,`b`.`supplyname` AS `supplyname`,b.phone,sum(`a`.`totalmoney`) AS `totalmoney`,`b`.`yufukuan` AS `yufukuan`,sum(`a`.`paymoney`) AS `paymoney`,(sum(`a`.`totalmoney` - `a`.`paymoney` - `a`.`oddment`) - `b`.`yufukuan`) AS `pay_own`,count(0) AS `num` from (`buyplanmain` `a` join `supply` `b` on((`a`.`supplyid` = `b`.`ROWID`))) where ((`a`.`ifpay` < 2) and (`a`.`user_flag` = 1))";
if($start_time!='')
		$sql.=" and a.caigoudate>='$start_time'";
if($end_time!='')
		$sql.=" and a.caigoudate<='$end_time'";
if($supplyname!='')
		$sql.=" and b.supplyname like '%".$supplyname."%'";
$sql.=" group by `b`.`supplyname`,`b`.`ROWID`,b.phone order by sum(totalmoney) desc";		
$rs=$db->Execute($sql);
$rs_a = $rs->GetArray();

$head=array("supplyname"=>"供应商名称","num"=>"采购单数","phone"=>"电话","totalmoney"=>"总金额","yufukuan"=>"预付款","paymoney"=>"已付款","pay_own"=>"尚欠");
$headtype=array("num"=>"int","supplyname"=>"string","phone"=>"string","totalmoney"=>"float","yufukuan"=>"float","paymoney"=>"float","pay_own"=>"float");
$sumcol=array("totalmoney"=>"","yufukuan"=>"","paymoney"=>"","pay_own"=>"");


foreach ($head as $key=>$val)
	{		
?>
		<td nowrap align=center ><?php echo $val?></td>
<?php 
	}
?>
		</tr>
	<?php
	foreach($rs_a as $row)
	{
		echo "<tr class=TableLine1>";
		foreach ($head as $key=>$val)
		{
			if($key=='supplyname' && $row[$key]!='')
				$row[$key]="<a href='../JXC/supply_newai.php?".base64_encode("action=view_default&ROWID=".$row['rowid'])."' target='_blank'>".$row[$key]."</a>";
			if($headtype[$key]=="int" || $headtype[$key]=="float")
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
		$sql="select a.*,b.USER_NAME from buyplanmain a inner join user b on a.createman=b.USER_ID where a.ifpay < 2 and a.user_flag = 1 and a.supplyid=".$row['rowid'];
		if($start_time!='')
			$sql.=" and a.caigoudate>='$start_time'";
		if($end_time!='')
			$sql.=" and a.caigoudate<='$end_time'";
		$sql.=" order by caigoudate";
		$rs=$db->Execute($sql);
		$rs_b = $rs->GetArray();
		for($i=0;$i<sizeof($rs_b);$i++)
		{
			echo "<tr class=TableLine2><td></td>";
			echo "<td nowrap >".($i==0?"<span>单号：</span>":"")."<span style='float:right'><a href='../JXC/buyplanmain_newai.php?".base64_encode("action=view_default&billid=".$rs_b[$i]['billid'])."' target='_blank'>".$rs_b[$i]['billid']."</a></span></td>";
			echo "<td nowrap >".($i==0?"<span>主题：</span>":"")."<span style='float:right'>".$rs_b[$i]['zhuti']."</span></td>";
			echo "<td nowrap >".($i==0?"<span>金额：</span>":"")."<span style='float:right'>".$rs_b[$i]['totalmoney']."</span></td>";
			echo "<td nowrap >".($i==0?"<span>创建人：</span>":"")."<span style='float:right'>".$rs_b[$i]['USER_NAME']."</span></td>";
			echo "<td nowrap >".($i==0?"<span>采购日期：</span>":"")."<span style='float:right'>".$rs_b[$i]['caigoudate']."</span></td>";
			echo "<td nowrap >".($i==0?"<span>备注：</span>":"")."<span style='float:right'>".$rs_b[$i]['beizhu']."</span></td></tr>";
		}		
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
</table>
</div>

<!-- START Script Block for Chart index -->

<!-- END Script Block for Chart index -->
</body>

</html>










