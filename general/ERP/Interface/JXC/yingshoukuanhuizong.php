<?php
ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL);
error_reporting(E_WARNING | E_ERROR);
require_once('lib.inc.php');
$GLOBAL_SESSION=returnsession();
validateMenuPriv("应收款汇总");
global $db;
$start_time = $_GET['start_time'];
$end_time = $_GET['end_time'];
$daoguoyuan=$_GET['daoguoyuan'];
if($_GET['sb_button']=='' && $start_time=='')
{
	$start_time = date("Y-m-01 00:00:00");
	$end_time = date("Y-m-d 23:59:59");
	$daoguoyuan='0';
}
$supplyname=$_GET['supplyname'];
$iffahuo=$_GET['iffahuo'];

$title="应收款汇总";

if($_GET['out_excel'] == 'true'){

    header("Content-type: application/vnd.ms-excel; charset=gb2312");
	header("Content-Disposition: attachment; filename=".$title.".xls");
?>	
<html>
<head>
<TITLE>应收款汇总</TITLE>
<meta content="text/html; charset=gb2312" http-equiv="Content-Type">
	<meta http-equiv="x-ua-compatible" content="IE=6">
	
	<STYLE>
	@media print {
	input{display:none}
	}
	xmp{page-break-before: always}
	.highlight {BACKGROUND:#d0ecfa;}
	</STYLE>
</head>
	<body class=bodycolor topMargin=5>
<div id='con'>
<table class=TableBlock border=1 align=center width=100%>
	<thead>
		<tr>
			<td colspan="7">
			
			时间段：<?php echo $start_time; ?> — <?php echo $end_time; ?>
			&nbsp;客户：<?php echo $supplyname;?>
			&nbsp;是否发货：<?php if($iffahuo==0) echo '全部';else if($iffahuo==1) echo '是';else if($iffahuo==-1) echo '否';?>
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
							&nbsp;客户(会员卡)：<INPUT type="text" class="SmallInput" maxLength=200 size="25" name="supplyname" value="<?php echo $supplyname?>">		
							&nbsp;是否发货：<select name='iffahuo'>
<option value=0>-全部-</option>
<option value=1 <?php if($iffahuo==1)echo "selected";?>>是</option>
<option value=-1 <?php if($iffahuo==-1)echo "selected";?>>否</option>
</select>
&nbsp;导购员：<select name='daoguoyuan'>
<option value=0>-全部-</option>
<?php 
$sql="select a.qianyueren,c.USER_NAME from `sellplanmain` `a` join `customer` `b` on `a`.`supplyid` = `b`.`ROWID` left join user c 
		on a.qianyueren=c.USER_ID where ((`a`.`ifpay` < 2) and (`a`.`user_flag` = 1))";
if($start_time!='')
	$sql.=" and a.createtime>='$start_time'";
if($end_time!='')
	$sql.=" and a.createtime<='$end_time'";
$sql.=" group by a.qianyueren order by c.USER_NAME";
$rs=$db->Execute($sql);
$rs_a = $rs->GetArray();
foreach($rs_a as $row)
{
	echo "<option value='".$row['qianyueren']."'";
	if($daoguoyuan==$row['qianyueren'])
		echo "selected";
	echo ">".$row['USER_NAME']."</option>";
}
?>
</select>
							<input class="SmallButtonA" type="submit" name="sb_button" accesskey="f" value="查询"
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
$sql="select `b`.`ROWID` AS `rowid`,`b`.`supplyname` AS `supplyname`,b.membercard,c.USER_NAME,sum(`a`.`totalmoney`) AS `totalmoney`,
`b`.`yuchuzhi` AS `yufukuan`,sum(`a`.`huikuanjine`) AS `paymoney`,(sum(`a`.`totalmoney` - `a`.`huikuanjine` - `a`.`oddment`) - `b`.`yuchuzhi`) AS `pay_own`,count(0) AS `num` from (`sellplanmain` `a` join `customer` `b` on `a`.`supplyid` = `b`.`ROWID` left join user c on a.qianyueren=c.USER_ID) where ((`a`.`ifpay` < 2) and (`a`.`user_flag` = 1))";
if($start_time!='')
		$sql.=" and a.createtime>='$start_time'";
if($end_time!='')
		$sql.=" and a.createtime<='$end_time'";
if($supplyname!='')
		$sql.=" and (b.supplyname like '%".$supplyname."%' or b.membercard='".$supplyname."')";
if($iffahuo==1)
		$sql.=" and a.fahuostate>=0";
else if($iffahuo==-1)
		$sql.=" and a.fahuostate=-1";
if($daoguoyuan!='0')
	$sql.=" and a.qianyueren='$daoguoyuan'";		
$sql.=" group by `b`.`supplyname`,`b`.`ROWID`,b.membercard order by sum(totalmoney) desc";		
$rs=$db->Execute($sql);
$rs_a = $rs->GetArray();

$head=array("supplyname"=>"客户名称","USER_NAME"=>"导购员","membercard"=>"会员卡","num"=>"销售单数","totalmoney"=>"总金额","yufukuan"=>"预收款","paymoney"=>"已收款","pay_own"=>"尚欠");
$headtype=array("num"=>"int","supplyname"=>"string","membercard"=>"string","totalmoney"=>"float","yufukuan"=>"float","paymoney"=>"float","pay_own"=>"float");
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
				$row[$key]="<a href='../JXC/customer_newai.php?".base64_encode("action=view_default&ROWID=".$row['rowid'])."' target='_blank'>".$row[$key]."</a>";
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
		$sql="select a.*,b.USER_NAME,c.name as fahuo from sellplanmain a inner join user b on a.user_id=b.USER_ID inner join fahuostate c on a.fahuostate=c.id where a.ifpay < 2 and a.user_flag = 1 and a.supplyid=".$row['rowid'];
		if($start_time!='')
			$sql.=" and a.createtime>='$start_time'";
		if($end_time!='')
			$sql.=" and a.createtime<='$end_time'";
		if($iffahuo==1)
			$sql.=" and a.fahuostate>=0";
		else if($iffahuo==-1)
			$sql.=" and a.fahuostate=-1";
			
		$sql.=" order by createtime";
		$rs=$db->Execute($sql);
		$rs_b = $rs->GetArray();
		for($i=0;$i<sizeof($rs_b);$i++)
		{
			echo "<tr class=TableLine2><td></td><td></td>";
			echo "<td nowrap >".($i==0?"<span>单号：</span>":"")."<span style='float:right'><a href='../JXC/sellplanmain_newai.php?".base64_encode("action=view_default&billid=".$rs_b[$i]['billid'])."' target='_blank'>".$rs_b[$i]['billid']."</a></span></td>";
			echo "<td nowrap >".($i==0?"<span>是否发货：</span>":"")."<span style='float:right'>".$rs_b[$i]['fahuo']."</span></td>";
			echo "<td nowrap >".($i==0?"<span>金额：</span>":"")."<span style='float:right'>".$rs_b[$i]['totalmoney']."</span></td>";
			echo "<td nowrap >".($i==0?"<span>创建人：</span>":"")."<span style='float:right'>".$rs_b[$i]['USER_NAME']."</span></td>";
			echo "<td nowrap >".($i==0?"<span>制单日期：</span>":"")."<span style='float:right'>".$rs_b[$i]['createtime']."</span></td>";
			echo "<td  >".($i==0?"<span>备注：</span>":"")."<span style='float:right'>".$rs_b[$i]['beizhu']."</span></td></tr>";
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


