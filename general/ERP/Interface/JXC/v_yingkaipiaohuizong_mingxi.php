<?php
ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL);
error_reporting(E_WARNING | E_ERROR);
require_once('lib.inc.php');
$GLOBAL_SESSION=returnsession();
global $db;
$sql="select `a`.`billid`,`a`.`zhuti`,`a`.`user_id`,`a`.`chanceid`,`a`.`createtime`,`a`.`qianyueren`,`a`.`fahuostate`,`b`.`ROWID` AS `rowid`,`b`.`supplyname`,`a`.`createtime`,`a`.`totalmoney`,`a`.`kaipiaojine`,`a`.`oddment`,`b`.`yuchuzhi`,(`a`.`totalmoney` - `a`.`kaipiaojine` ) AS `own` ,`d`.`USER_NAME` AS `createman` ,`c`.`name` AS `typename` from (`sellplanmain` `a` join `customer` `b` on`a`.`supplyid` = `b`.`ROWID` left join `sellbilltype` `c` on `a`.`billtype` = `c`.`id` left join `user` `d` on`a`.`user_id` = `d`.`USER_ID`) where ((kaipiaostate='0' or kaipiaostate='3') and `a`.`user_flag` >0 and `a`.`supplyid`=".$_GET['supplyid']." )";
$rs=$db->Execute($sql);
$rs_a = $rs->GetArray();
$yuchuzhi=0;
if(sizeof($rs_a)>0)
	$yuchuzhi=$rs_a[0]['yuchuzhi'];
$head=array("billid"=>"����","supplyname"=>"�ͻ�","typename"=>"��������","zhuti"=>"����","createman"=>"������","createtime"=>"��������","totalmoney"=>"�ܽ��","kaipiaojine"=>"�ѿ�Ʊ���","own"=>"�������");
$headtype=array("billid"=>"string","supplyname"=>"string","typename"=>"string","zhuti"=>"string","qianyueren"=>"string","createtime"=>"string","totalmoney"=>"float","kaipiaojine"=>"float","own"=>"float");
$title="Ӧ��Ʊ��ϸ";
$sumcol=array("totalmoney"=>"","huikuanjine"=>"","own"=>"");
if($_GET['out_excel'] == 'true'){
	export_XLS($head,$rs_a,$title,$sumcol);
	exit;
}
?>
<html>
<head>
<?php page_css($title); ?>
<script language="javascript" src="../LODOP60/LodopFuncs.js"></script>
<object  id="LODOP_OB" classid="clsid:2105C259-1E0C-4534-8141-A753534CB4CA"
	width=0 height=0> <embed id="LODOP_EM" type="application/x-print-lodop"
		width=0 height=0></embed> </object>
</head>
<body class=bodycolor topMargin=5>
<div id='con'>
<table class=TableBlock align=center width=100%>
<tr><td colspan="11" class="TableHeader">&nbsp;<?php echo $title?>����<?php echo $rs_a[0][supplyname];?>(Ԥ�տ�:<font color=red><?php echo number_format($yuchuzhi,0,".",",")?></font>Ԫ)</td></tr>

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
			print "<td>�ϼ� <b>".sizeof($rs_a)."</b> ����¼</td>";
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
<p align="center"><input type="button" class="SmallButton" value=" ��ӡ "
	onclick="javascript:prn_print();"> <input type="button"
	class="SmallButton" value="����"
	onclick="location='v_yingkaipiaohuizong_mingxi.php?supplyid=<?php echo $_GET[supplyid];?>&out_excel=true';">
<input type="button" class="SmallButton" value=" ���� "
	onclick="location='v_yingkaipiaohuizong_newai.php';"></p>
</form>

</body>
<script language="javascript" type="text/javascript">   
    var LODOP; //����Ϊȫ�ֱ��� 
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
