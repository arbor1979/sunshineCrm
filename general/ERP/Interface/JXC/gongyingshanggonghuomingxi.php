<?php
ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL);
error_reporting(E_WARNING | E_ERROR);
require_once('lib.inc.php');
$GLOBAL_SESSION=returnsession();
validateMenuPriv("供应商供货汇总");
require_once('./userdefine/buyplanstate.php');
require_once('./userdefine/paystate.php');
require_once('./userdefine/kaipiaostate.php');
require_once('./userdefine/sellonePriv.php');
global $db;
if(!empty($_GET['start_time'])) {
	$start_time = $_GET['start_time'];
}else{
	exit('缺少参数');
}

if(!empty($_GET['end_time'])) {
	$end_time = $_GET['end_time'];
}else{
	exit('缺少参数');
}

$where='';
if($_GET['where'] == 'sum_paymoney'){
	$where = "`a`.`paymoney`>0 and";
	$title = '已支付金额明细';
}elseif($_GET['where'] == 'sum_ruku'){
	$where = "`a`.`rukumoney`>0 and";
	$title = '已入库金额明细';
}elseif($_GET['where'] == 'sum_qiankuan'){
	$where = "(`a`.`ifpay`<2) and";
	$title = '采购欠款明细';
}else{
	$title = '采购明细';
}

if(!empty($_GET['supplyid'])) {
	$supplyid = $_GET['supplyid'];
}else{
	exit('缺少参数');
}

$sql="SELECT a.daohuodate,a.caigoudate,a.createman,a.supplyid,a.ifpay,a.oddment,a.billid,c.supplyname,a.zhuti,a.totalmoney,a.paymoney,a.rukumoney,a.shoupiaostate,a.shoupiaomoney,b.USER_NAME,a.user_flag,a.state FROM buyplanmain a left JOIN `user` b on a.createman=b.USER_ID left JOIN supply c on a.supplyid=c.ROWID  where a.user_flag>0 and ".$where." a.supplyid='".$supplyid."' AND a.caigoudate>='".$start_time."' AND a.caigoudate<='".$end_time."'";
//exit($sql);
$rs=$db->Execute($sql);
$rs_a = $rs->GetArray();

$i=0;
foreach($rs_a as $row)
{
	$rs_a[$i]['user_flag']=sellonePriv_value($row['user_flag'],'','');
	$rs_a[$i]['ifpay']=paystate_value($row['ifpay'],'','');
	$rs_a[$i]['state']=buyplanstate_value($row['state'],'','');
	$rs_a[$i]['shoupiaostate']=kaipiaostate_value($row['shoupiaostate'],'','');
	$i++;
}

$head=array("supplyname"=>"供应商","billid"=>"单号","zhuti"=>"主题","caigoudate"=>"采购日期","daohuodate"=>"预计到货日期","USER_NAME"=>"创建人","totalmoney"=>"总金额","oddment"=>"去零金额","paymoney"=>"已付金额","rukumoney"=>"已入库金额","shoupiaomoney"=>"已收票金额","user_flag"=>"单据状态","ifpay"=>"付款状态","state"=>"收货状态","shoupiaostate"=>"收票状态");
$headtype=array("supplyname"=>"string","billid"=>"char","zhuti"=>"string","caigoudate"=>"string","daohuodate"=>"string","USER_NAME"=>"char","totalmoney"=>"float","oddment"=>"float","paymoney"=>"float","rukumoney"=>"float","shoupiaomoney"=>"float","user_flag"=>"char","ifpay"=>"char","state"=>"char","shoupiaostate"=>"char");
$title="供应商供货明细";
$sumcol=array("totalmoney"=>"","oddment"=>"","paymoney"=>"","rukumoney"=>"","shoupiaomoney"=>"");


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

	<head class="TableHeader">
	
	
	<tr>
		<td colspan="17" class="TableHeader">&nbsp;<?php echo $title.'—— '.$start_time.' 至 '.$end_time; ?></td>
	</tr>
	</thead>
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
	onclick="javascript:prn_print();"> <input type="button"
	class="SmallButton" value="导出"
	onclick="location='?out_excel=true&start_time=<?php echo $_GET[start_time];?>&end_time=<?php echo $_GET[end_time];?>&supplyid=<?php echo $_GET['supplyid']?>&where=<?php  echo $_GET['where'] ?>';">
</p>
</form>

</body>
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
		LODOP.ADD_PRINT_TABLE("10%","10%","80%","80%",document.documentElement.innerHTML);
		LODOP.SET_PRINT_MODE("PRINT_PAGE_PERCENT","Auto-Width");
	};              
	

</script>

</html>
