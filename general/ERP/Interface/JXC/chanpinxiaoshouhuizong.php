<?php
ini_set('display_errors', 1);
error_reporting(E_ERROR);
require_once('lib.inc.php');
$GLOBAL_SESSION=returnsession();
validateMenuPriv("��Ʒ����");
global $db;

if(empty($_GET['start_time'])) {
	$start_time = date("Y-m-01 00:00:00");
	$end_time = date("Y-m-d 23:59:59");
	$daoguoyuan='0';
}else{
	$start_time = $_GET['start_time'];
	$end_time = $_GET['end_time'];
	$daoguoyuan=$_GET['daoguoyuan'];
}

if(strlen($daoguoyuan)==0)
    $daoguoyuan='0';


$show_type=$_GET['show_type'];
if($show_type == 'graph'){
	$type=$_GET['type'];
	if($type=='zhu' || $type == ''){
		$swf = 'Column3D.swf';
	}elseif ($type=='bing'){
		$swf = 'Pie2D.swf';
	}
}
$huizong_type=$_GET['huizong_type'];
$product_type=$_GET['product_type'];


if($product_type!='')
	$product_name=returntablefield("producttype","ROWID", $product_type, "name");
$ordername=$_GET['ordername'];
$order_img = '<img src="images/arrow_down.gif" border="0">';
$supplyid=$_GET['supplyid'];
if($supplyid!='')
	$supplyname=returntablefield("supply", "rowid",$supplyid,"supplyname");
$customerid=$_GET['customerid'];
if($customerid!='')
{
	$custArray=explode(",",$customerid);
	foreach ($custArray as $row)
	{
		if($row !='')
			$customername.=returntablefield("customer","rowid",$row,"supplyname").",";
	}
}

if($huizong_type=='' || $huizong_type==1)
{
	if($ordername=='')
		$ordername='jine';
	$rs_all=array();
	$sql="select * from producttype where parentid=0";
	if($product_type!='')
	{
		$subtype=getSubprodtypeByParent($product_type);
		if($subtype!='')
			$subtype.=",".$product_type;
		else 
			$subtype=$product_type;
		$sql.=" and ROWID in ($subtype)";
	}
	$rs=$db->Execute($sql);
	$rs_a = $rs->GetArray();
	
	for($i=0;$i<sizeof($rs_a);$i++)
	{
		$subtype=getSubprodtypeByParent($rs_a[$i]['ROWID']);
		if($subtype=='')
			$subtype=$rs_a[$i]['ROWID'];
		if($subtype!='')
		{
			$sql="SELECT '".$rs_a[$i]['name']."' as name,sum(if(num>0,num,0)) as sellnum,sum(if(num<0,num,0)) as backnum,
			sum(num) as realnum,sum(round(price*zhekou,2)*num) as jine,sum(if(num>0,lirun,0)) as lirun from sellplanmain_detail a inner join product b on 
			a.prodid=b.productid inner join producttype c on b.producttype=c.ROWID inner join sellplanmain d on a.mainrowid=d.billid where d.user_flag>0 and c.ROWID in ($subtype)";
			if($start_time!='')
				$sql.=" and a.inputtime>='$start_time'";
			if($end_time!='')
				$sql.=" and a.inputtime<='$end_time'";
			if($supplyid!='')
				$sql.=" and b.supplyid=$supplyid";
			if($customerid!='')
				$sql.=" and d.supplyid in (".rtrim($customerid,",").")";
			if($daoguoyuan!='0')
			    $sql.=" and d.qianyueren='$daoguoyuan'";
			//echo $sql."<br>";
			$rs=$db->Execute($sql);
			$rs_b = $rs->GetArray();
			
			if(intval($rs_b[0]['sellnum'])!=0)
				$rs_b[0]['percent']=round(-intval($rs_b[0]['backnum'])/intval($rs_b[0]['sellnum'])*100)."%";
			if(floatval($rs_b[0]['jine'])!=0)
				$rs_b[0]['lirunrate']=round(floatval($rs_b[0]['lirun'])/floatval($rs_b[0]['jine'])*100)."%";
			$rs_all[$i]=$rs_b[0];
		}
		else
		{
			$rs_all[$i]['name']=$rs_a[$i]['name'];
			$rs_all[$i]['sellnum']='';
			$rs_all[$i]['backnum']='';
			$rs_all[$i]['percent']='';
			$rs_all[$i]['realnum']='';
			$rs_all[$i]['jine']='';
			$rs_all[$i]['lirun']='';
		}
			
	}
	
	$rs_all=array_sort($rs_all,$ordername,"dec");
	$head=array("name"=>"����","sellnum"=>"������","backnum"=>"�˻���","percent"=>"�˻���","realnum"=>"ʵ������","jine"=>"���۽��");
	$headtype=array("name"=>"string","sellnum"=>"int","backnum"=>"int","percent"=>"int","realnum"=>"int","jine"=>"float");
	$sumcol=array("sellnum"=>"","backnum"=>"","realnum"=>"","jine"=>"");

}
if($huizong_type==2)
{
	if($ordername=='')
		$ordername='jine';
	$rs_all=array();
	
	$sql="SELECT c.name as name,sum(if(num>0,num,0)) as sellnum,sum(if(num<0,num,0)) as backnum,
	sum(num) as realnum,sum(round(price*zhekou,2)*num) as jine,sum(if(num>0,lirun,0)) as lirun from sellplanmain_detail a inner join product b on 
	a.prodid=b.productid inner join producttype c on b.producttype=c.ROWID inner join sellplanmain d on a.mainrowid=d.billid where d.user_flag>0";
	if($start_time!='')
		$sql.=" and a.inputtime>='$start_time'";
	if($end_time!='')
		$sql.=" and a.inputtime<='$end_time'";
	if($supplyid!='')
		$sql.=" and b.supplyid=$supplyid";
	if($customerid!='')
		$sql.=" and d.supplyid in ($customerid)";
	if($daoguoyuan!='0')
	    $sql.=" and d.qianyueren='$daoguoyuan'";
	if($product_type!='')
	{
		$subtype=getSubprodtypeByParent($product_type);
		if($subtype!='')
			$subtype.=",".$product_type;
		else 
			$subtype=$product_type;
		$sql.=" and c.ROWID in ($subtype)";
	}
	$sql.= " group by b.producttype,c.name";
	$rs=$db->Execute($sql);
	$rs_b = $rs->GetArray();
	for($i=0;$i<sizeof($rs_b);$i++)
	{
		if(intval($rs_b[$i]['sellnum'])!=0)
			$rs_b[$i]['percent']=round(-intval($rs_b[$i]['backnum'])/intval($rs_b[$i]['sellnum'])*100)."%";
		if(floatval($rs_b[$i]['jine'])!=0)
			$rs_b[$i]['lirunrate']=round(floatval($rs_b[$i]['lirun'])/floatval($rs_b[$i]['jine'])*100)."%";
	}
	$rs_all=$rs_b;
	$rs_all=array_sort($rs_all,$ordername,"dec");
	$head=array("name"=>"����","sellnum"=>"������","backnum"=>"�˻���","percent"=>"�˻���","realnum"=>"ʵ������","jine"=>"���۽��");
	$headtype=array("name"=>"string","sellnum"=>"int","backnum"=>"int","percent"=>"int","realnum"=>"int","jine"=>"float");
	$sumcol=array("sellnum"=>"","backnum"=>"","realnum"=>"","jine"=>"");
	
}
if($huizong_type==3)
{
	if($ordername=='')
		$ordername='jine';
	$rs_all=array();
	
	$sql="SELECT b.productid,b.productname as name,b.oldproductid,sum(if(num>0,num,0)) as sellnum,sum(if(num<0,num,0)) as backnum,
	sum(num) as realnum,sum(round(price*zhekou,2)*num) as jine,sum(if(num>0,lirun,0)) as lirun from sellplanmain_detail a inner join product b on 
	a.prodid=b.productid inner join producttype c on b.producttype=c.ROWID inner join sellplanmain d on a.mainrowid=d.billid where d.user_flag>0";
	if($start_time!='')
		$sql.=" and a.inputtime>='$start_time'";
	if($end_time!='')
		$sql.=" and a.inputtime<='$end_time'";
	if($supplyid!='')
		$sql.=" and b.supplyid=$supplyid";
	if($customerid!='')
		$sql.=" and d.supplyid in ($customerid)";
	if($daoguoyuan!='0')
	    $sql.=" and d.qianyueren='$daoguoyuan'";
	if($product_type!='')
	{
		$subtype=getSubprodtypeByParent($product_type);
		if($subtype!='')
			$subtype.=",".$product_type;
		else 
			$subtype=$product_type;
		$sql.=" and c.ROWID in ($subtype)";
	}
	$sql.= " group by b.productid,b.productname,b.oldproductid";
	$rs=$db->Execute($sql);
	$rs_b = $rs->GetArray();
	for($i=0;$i<sizeof($rs_b);$i++)
	{
		if(intval($rs_b[$i]['sellnum'])!=0)
			$rs_b[$i]['percent']=round(-intval($rs_b[$i]['backnum'])/intval($rs_b[$i]['sellnum'])*100)."%";
		if(floatval($rs_b[$i]['jine'])!=0)
			$rs_b[$i]['lirunrate']=round(floatval($rs_b[$i]['lirun'])/floatval($rs_b[$i]['jine'])*100)."%";
		$rs_b[$i]['productid']="<a href='product_newai.php?action=view_default&productid=".$rs_b[$i]['productid']."' target='_blank'>".$rs_b[$i]['productid']."</a>";
	}
	$rs_all=$rs_b;
	$rs_all=array_sort($rs_all,$ordername,"dec");
	$head=array("productid"=>"��Ʒ���","name"=>"��Ʒ����","oldproductid"=>"ԭ����","sellnum"=>"������","backnum"=>"�˻���","percent"=>"�˻���","realnum"=>"ʵ������","jine"=>"���۽��");
	$headtype=array("productid"=>"string","name"=>"string","oldproductid"=>"string","sellnum"=>"int","backnum"=>"int","percent"=>"int","realnum"=>"int","jine"=>"float");
	$sumcol=array("sellnum"=>"","backnum"=>"","realnum"=>"","jine"=>"");
	
}
if($_SESSION['LOGIN_USER_PRIV']==1)
{
	$head["lirun"]="����";
	$headtype["lirun"]="float";
	$sumcol["lirun"]="";
	$head["lirunrate"]="������";
	$headtype["lirunrate"]="float";
}
$title="��Ʒ����";
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
						<td class='nowrap'>ʱ��Σ� <input class="SmallInput" size="19"
							name="start_time" value="<?php echo $start_time; ?>"
							onclick="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss'})"> �� <input
							class="SmallInput" size="19" name="end_time"
							value="<?php echo $end_time; ?>"
							onclick="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss'})"> 
							
							
							
							���ܷ�ʽ:
							<select class="SmallSelect" name="huizong_type">
							<option <?php echo ($huizong_type=='1')?'selected':''; ?> value="1">����</option>
							<option <?php echo ($huizong_type=='2')?'selected':''; ?> value="2">����</option>
							<option <?php echo ($huizong_type=='3')?'selected':''; ?> value="3">��Ʒ���</option>
							</select>
							
							���ɸѡ:
							<select class="SmallSelect" name="product_type"  onclick="SelectAllInforSingle('../../Enginee/Module/prodtype_select_single/index.php','','product_type', 'product_type_ID','3','form1');">
							<option selected value="">ȫ����Ʒ</option>
							<?php if($product_type!=''){?>
							<option selected value="<?php echo $product_type?>" selected><?php echo $product_name?></option>
							<?php }?>
							</select>	
							&nbsp;����Ա��<select name='daoguoyuan'>
<option value=0>-ȫ��-</option>
<?php 
$sql="select a.qianyueren,c.USER_NAME from `sellplanmain` `a` join `customer` `b` on `a`.`supplyid` = `b`.`ROWID` left join user c 
		on a.qianyueren=c.USER_ID where (`a`.`user_flag` >0)";
if($start_time!='')
	$sql.=" and a.createtime>='$start_time'";
if($end_time!='')
	$sql.=" and a.createtime<='$end_time'";
$sql.=" group by a.qianyueren order by sum(totalmoney) desc";
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

							��ʾ��ʽ:
							<select class="SmallSelect" name="show_type">
							<option <?php echo ($show_type=='table')?'selected':''; ?> value="table">���</option>
							<option <?php echo ($show_type=='graph')?'selected':''; ?> value="graph">ͼ��</option>
							</select>	
						
							<?php if($show_type=='graph'){?>
							ͼ������:
							<select class="SmallSelect" name="type">
							<option <?php echo ($type=='zhu')?'selected':''; ?> value="zhu">��״ͼ</option>
							<option <?php echo ($type=='bing')?'selected':''; ?> value="bing">��״ͼ</option>
							</select>	
							<?php }?>
							&nbsp;		
							<br><br>��Ӧ�̣�
							<input type="hidden"  name="supplyid" value="<?php echo $supplyid?>"><input name="supplyid_ID" value="<?php echo $supplyname?>" class="SmallStatic" readonly size=30>&nbsp;
<a href="javascript:;" class="orgAdd" onClick="SelectAllInforSingle('../../Enginee/Module/supply_select_single/index.php','','supplyid_ID', 'supplyid');">ѡ��</a>
<a href="#" class="orgClear" onClick="ClearUser('supplyid_ID', 'supplyid')" title="���">���</a>			
&nbsp;�ͻ���
<input type='hidden'  name='customerid' value='<?php echo $customerid?>' ><input type='text' name='customerid_ID' value='<?php echo $customername?>' readonly class='SmallStatic' size='30' )>&nbsp;							
<a href="javascript:;" class="orgAdd" onClick="SelectAllInforSingle('../../Enginee/Module/kehu_select_multi/index.php','','customerid_ID', 'customerid');">ѡ��</a>
<a href="#" class="orgClear" onClick="ClearUser('customerid_ID', 'customerid')" title="���">���</a>							
							<input
							class="SmallButtonA" type="submit" accesskey="f" value="��ѯ"
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
		<td nowrap align=center title='˫���б��������'
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
			print "<td>�ϼ� <b>".sizeof($rs_all)."</b> ����¼</td>";
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
			
			if($key=='percent' && intval($sumcol['sellnum'])!=0)
				echo round(-$sumcol['backnum']/$sumcol['sellnum']*100)."%";
			if($key=='lirunrate' && intval($sumcol['jine'])!=0)
				echo round($sumcol['lirun']/$sumcol['jine']*100)."%";
			print "</b></td>";
		}
		$i++;
	}
?>	</tr>

</table>
</div>
<form>
<p align="center"><input type="button" class="SmallButton" value=" ��ӡ "
	onclick="javascript:prn_print();">&nbsp;<input type="button"
	class="SmallButton" value="����"
	onclick="location='?<?php echo FormPageAction2("ordername",$ordername);?>&out_excel=true';"></p>
</form>
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
		document.getElementById("searchbtn").style.display="none";
		LODOP.ADD_PRINT_TABLE("10%","10%","80%","80%",document.documentElement.innerHTML);
		document.getElementById("searchbtn").style.display="";
		LODOP.SET_PRINT_MODE("PRINT_PAGE_PERCENT","Auto-Width");
		
	};              
	

</script>

<?php 

}elseif($show_type=='graph'){

	$mingci = 20;  // ��ǰ������¼����ͳ��
	if(isset($rs_all[$mingci])){
		$sum = 0;
		$len =  count($rs_all);
		for ($i=$mingci;$i<$len;$i++){
			$sum+=$rs_all[$i][jine];
			unset($rs_all[$i]);
		}
		$rs_all[$mingci]['name'] = '����';
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
chart_index.setDataXML("<graph bgcolor='e1f5ff' caption='<?php echo $title?>' subCaption='��ȷ����λ���������룩' numberPrefix='' formatNumberScale='1' decimalPrecision='2' baseFontSize='14' numberSuffix='��Ԫ'><?php foreach ($rs_all as $row){echo "<set name='".$row['name']."' value='".($row['jine']/10000)."'/>";}?></graph>");
chart_index.render("indexDiv");
</script>
<!-- END Script Block for Chart index -->
<?php
}
?>

</body>

</html>










