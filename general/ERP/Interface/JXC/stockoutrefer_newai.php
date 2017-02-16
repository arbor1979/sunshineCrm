<?php
require_once('lib.inc.php');
$sessionkey=returnSessKey();
$GLOBAL_SESSION=returnsession();
$SUNSHINE_USER_NAME = $_SESSION['SUNSHINE_USER_NAME'];
//$SUNSHINE_USER_NAME = 'admin';
$_GET['flowState'] = "1";
if($_GET['action']=="edit_default3")			{
	
	$selectidArray = explode(',',$_GET['selectid']);
	$selectid = $selectidArray[0];
	//print_r($selectid);
	StockOutToRefer($selectid);
	exit;
}

$SYSTEM_ADD_SQL = " and state='4'";
//$SYSTEM_PRINT_SQL = '1';

if($_GET['action']=="edit_default3_data")			{
	//print_R($_POST);//print_R($_GET);
	StockOutToReferData($_GET['ROWID']);
	exit;
}

//默认操作
$filetablename='stockoutmain';
$parse_filename = 'stockoutrefer';
require_once('include.inc.php');
systemhelpContent("出库退货操作说明",'100%');

//功能函数区

//第二：出库退货数据操作部分


function StockOutToReferData($Rowid)			{
	global $db;
	$SystemRowid = $Rowid;
	$tablecode = returntablefield("stockoutmain","ROWID",$Rowid,"tablecode");
	$num = $_POST['num'];
	for($i=1;$i<=$num;$i++)						{
		$productid = $_POST['productid'.$i];
		$productname = $_POST['0'.$i];
		$stockNum = $_POST['1'.$i];
		$productname = $_POST['2'.$i];
		$productname = $_POST['3'.$i];
		$productname = $_POST['4'.$i];
		$backnum = $_POST['backnum'.$i];
		$backprice = $_POST['backprice'.$i];
		$sql = "select count(*) as NUM from store where productid='$productid'";
		$rss = $db->Execute($sql);
		$rss_a = $rss->GetArray();
		//print $rss_a[0]['NUM'];exit;
		//出库退货，库货数量增加
		if($rss_a[0]['NUM']>0)		{
			$sql = "update store set stocknum = stocknum + $backnum , allnum = allnum + $backnum where productid='$productid'";
			//print $sql."<HR>";
			$db->Execute($sql);
		}
	}
	$sql = "update stockoutmain set tableNo='1' where ROWID='$SystemRowid'";
	$db->Execute($sql);
	print "<META HTTP-EQUIV=REFRESH CONTENT='0;URL=?'>\n";
	
}

//第一：出库退货HTML部分

function StockOutToRefer($Rowid)				{
	global $db;
	$tablecode = returntablefield("stockoutmain","ROWID",$Rowid,"tablecode");
?>

<link rel="stylesheet" type="text/css" href="<?php echo ROOT_DIR?>theme/3/style.css">

<html>
<head>
<title>出库退货管理窗口</title>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
 <script>
 function stockBack(num)
	{
    var backNum;
    var backNumStr="backnum";
    var backAmtStr="backamt";
    var countNum=0;
    var countAmt=0;
	
    for (i=1;i<=num;i++){
    backNumStr="backnum"+i;    
	//alert(backNumStr);
    backNum=document.all(backNumStr).value;
    //document.all(backNumStr).value
    if (backNum!=""&&backNum!=null){
		countNum=countNum+parseFloat(backNum);
    }
    }
    if (countNum==0){
    alert("请确定退货数量!");
    return (false);
    }
    
   frm.flag.value="stockBack";
   frm.submit();
}
function checkNum(numNo)
{

    var num1=document.frm("1"+numNo).value; 
    var num2=document.frm("2"+numNo).value; 
    var numIn=document.frm("backnum"+numNo).value;
    var numPrice=document.frm("backprice"+numNo).value;
    //alert("numPrice"+numPrice);
   // if (isNaN(backprice)){
    	//backprice=num2;
    	//document.frm("backprice"+numNo).value=num2;
    	//}
    	
    var moduleId=document.frm("ModuleId").value; 
    //alert("moduleId"+moduleId);
    if (moduleId=="S03"){
    var stockNum=document.frm("stock_"+numNo).value;
    //alert("stockNum"+stockNum);

    if (stockNum<parseFloat(numIn)){
    alert("退货数量大于该批次商品的库存数量");
    document.frm("backamt"+numNo).value="";
    document.frm("backnum"+numNo).value="";
    return (false);
   }	
    }
    //alert("numIn"+numIn);
    if (numIn!=""&&numIn!=null){
    if (parseFloat(num1)<parseFloat(numIn)){
    alert("退货数量大于提货数量");
    document.frm("backamt"+numNo).value="";
    document.frm("backnum"+numNo).value="";
    return (false);
    }else{
    var numIn=document.frm("backamt"+numNo).value=parseFloat(numIn)*parseFloat(numPrice); 
    }
}

}

var isNS4 = (navigator.appName=="Netscape")?1:0;
function check_input_num(num_type)
{
  
  if(num_type=="NUMBER")
  {
     if(!isNS4)
     {
     	 if((event.keyCode < 48 || event.keyCode > 57)&&event.keyCode != 46)
     	    event.returnValue = false;
     }
     else
     {
     	 if((event.which < 48 || event.which > 57)&&event.keyCode != 46)
     	    return false;
     }
  }
  else if(num_type=="MONEY")
  {
     if(!isNS4)
     {
     	 if((event.keyCode < 45 || event.keyCode > 57)&&event.keyCode != 47)
     	    event.returnValue = false;
     }
     else
     {
     	 if((event.which < 45 || event.which > 57)&&event.which != 47)
     	    return false;
     }
  }
}
 </script>
</head>

<body class="bodycolor">
<div align="center">
<table border="0" width="100%" cellspacing="0" cellpadding="3" class="small">
  <tr>
    
    </td>
  </tr>
</table>
<form name="frm" action="?action=edit_default3_data&ROWID=<?php echo $Rowid?>" method="post">
	
<table border="0" cellspacing="1" width="95%" class="small" bgcolor="#000000" cellpadding="3">
<tr align="left" >
<td nowrap  class="TableContent" colspan=8>出库单据号码：<?php echo $tablecode?></td>
</tr>
<tr align="center" >

      <td nowrap  class="TableHeader" >商品名称</td>

      <td nowrap  class="TableHeader" >出库数量</td>

      <td nowrap  class="TableHeader" >单价</td>

      <td nowrap  class="TableHeader" >金额</td>

      <td nowrap  class="TableHeader" >备注</td>

<td nowrap  class="TableHeader" >退货数量</td>
<td nowrap  class="TableHeader" >退货单价</td>
<td nowrap  class="TableHeader" >退货金额</td>
</tr>


<?php
$sql = "select * from stockoutdetail where mainrowid='$Rowid'";
$rs = $db->Execute($sql);
$rs_a = $rs->GetArray();
$Columns = returntablecolumn("stockoutdetail");
for($i=0;$i<sizeof($rs_a);$i++)		{
	for($j=0;$j<sizeof($Columns);$j++)		{
		$Element = $Columns[$j];
		$$Element = $rs_a[$i][$Element];
	}
	$productname = returntablefield("product","productid",$productid,"productname");
	$ii = $i+1;
	$plannum_ALL += $plannum;
	$money_ALL += $money;

?>
<tr class="TableLine1" id="TR<?php echo $ii?>" >

<input type="hidden"   name="productid<?php echo $ii?>" value="<?php echo $productid?>">

<td   align="left" ><input readonly  type="text"   name="0<?php echo $ii?>" value="<?php echo $productname?>" size="10" maxlength="54"  class="SmallInput2"></td>

<td   align="left" ><input readonly  type="text"   name="1<?php echo $ii?>" value="<?php echo $plannum?>" size="10" maxlength="54"  class="SmallInput2"></td>

<td   align="right" ><input readonly  type="text"   name="2<?php echo $ii?>" value="<?php echo $price?>" size="10" maxlength="54"  class="SmallInput2"></td>

<td   align="right" ><input readonly  type="text"   name="3<?php echo $ii?>" value="<?php echo $money?>" size="10" maxlength="54"  class="SmallInput2"></td>

<td   align="left" ><input readonly  type="text"   name="4<?php echo $ii?>" value="<?php echo $stockoutdetailsign?>" size="10" maxlength="54"  class="SmallInput2"></td>

<td  ><input   type="text"   name="backnum<?php echo $ii?>" size="10" maxlength="54"  onblur="checkNum('<?php echo $ii?>')" onkeypress="check_input_num('NUMBER')" class="SmallInput2"></td>
<td  ><input   type="text"   name="backprice<?php echo $ii?>" size="10" maxlength="54" onblur="checkNum('<?php echo $ii?>')" onkeypress="check_input_num('NUMBER')" value="0"  class="SmallInput2"></td>
<td  ><input   type="text" readonly  name="backamt<?php echo $ii?>" size="10" maxlength="54"   class="SmallInput2"></td>
</tr>
<input type="hidden" name="ROWID_<?php echo $ii?>" value="<?php echo $ROWID?>">
<input type="hidden" name="stock_<?php echo $ii?>" value="<?php echo $plannum?>">
<?php
}
?>
<tr class="TableLine1" id="TR" style="cursor:pointer;">
<td  class="TableHeader">合计</td>

<td class="TableHeader" align="right"><?php echo $plannum_ALL?></td>

<td  class="TableHeader" align="right"></td>

<td  class="TableHeader" align="right"><?php echo $money_ALL?></td>

<td class="TableHeader" align="left">&nbsp</td>
<td class="TableHeader" align="left" >&nbsp</td>
<td  class="TableHeader" align="left">&nbsp</td>
<td class="TableHeader" align="left" >&nbsp</td>

</tr>
</table>
<input type="hidden" name="rowid" value="<?php echo $Rowid?>">
<input type="hidden" name="num" value="<?php echo sizeof($rs_a);?>">
<input type="hidden" name="ModuleId" value="S03">
<input type="hidden" name="flag">
 </form>
<br>
<input type="button" name="close" id="close" class="SmallButton" value="保存" onClick="javascript:stockBack('<?php echo sizeof($rs_a);?>');">
<INPUT class=SmallButton id=close onclick=javascript:history.back(); type=button value=返回 name=close> 
</body>
</html>



<?php
}
?>