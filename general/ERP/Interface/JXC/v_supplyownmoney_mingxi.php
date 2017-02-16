<?php
ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL);
error_reporting(E_WARNING | E_ERROR);
$supplyid=$_GET['supplyid'];
require_once('lib.inc.php');
$GLOBAL_SESSION=returnsession();
validateMenuPriv("批量付款");
global $db;
$sql="select `a`.`billid`,`b`.`ROWID` AS `rowid`,`b`.`supplyname` AS `supplyname`,`a`.`caigoudate`,`a`.`daohuodate`,`a`.`createtime`,`a`.`danhao`,`a`.`zhuti`,`a`.`totalmoney`,`a`.`paymoney`,`a`.`oddment`,`b`.`yufukuan` AS `yufukuan`,(`a`.`totalmoney` - `a`.`paymoney` - `a`.`oddment`) AS `own` ,`d`.`USER_NAME` AS `createman` from (`buyplanmain` `a` join `supply` `b` on`a`.`supplyid` = `b`.`ROWID` left join `user` `d` on`a`.`createman` = `d`.`USER_ID`) where (`a`.`ifpay` < 2 and `a`.`user_flag`=1 and `a`.`supplyid`=".$supplyid." )";
$rs=$db->Execute($sql);
$rs_a = $rs->GetArray();
$yufukuan=0;

if(sizeof($rs_a)>0)
	$yufukuan=$rs_a[0]['yufukuan'];
//是否有付款权限
$flag=validateSingleMenuPriv("付款记录");

$head=array("billid"=>"单号","supplyname"=>"供货商","zhuti"=>"采购主题","createman"=>"采购人","caigoudate"=>"采购时间","totalmoney"=>"总金额","paymoney"=>"已支付金额","oddment"=>"去零金额","own"=>"未支付金额");
$headtype=array("billid"=>"string","supplyname"=>"string","zhuti"=>"string","createman"=>"string","caigoudate"=>"string","totalmoney"=>"float","paymoney"=>"float","oddment"=>"float","own"=>"float");
$title="应付款明细";
$sumcol=array("totalmoney"=>"","paymoney"=>"","oddment"=>"","own"=>"");
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
<script language="javascript">
var isNS4 = (navigator.appName=="Netscape")?1:0;

function CountAllOwn()
{
	  var result=0;
	  var oddment=0
	  var needpay=document.getElementById("needpay");
	  var oddall=document.getElementById("oddall");
	  var realpay=document.getElementById("realpay");
	  var check_array=document.getElementsByName("check");
	  for(var i=0;i<check_array.length;i++)
	  {
		  var inputid=check_array[i].id.replace(/billid/,'odd');
		  inputodd=document.getElementById(inputid);
		 
		  if(check_array[i].checked==true)
		  {
			 
			  inputodd.style.display='';
			  result=parseFloat(result)+parseFloat(check_array[i].value);
			  oddment=parseFloat(oddment)+parseFloat(inputodd.value);
		  }
		  else
		  {
			  inputodd.value=0;
			  inputodd.style.display='none';
		  }
	  }
	  needpay.innerHTML=result;
	  oddall.innerHTML=oddment;
	  realpay.innerHTML=result-oddment;
	  
}
function SelectAllCheck()
{
	  var result=0;
	  var oddment=0
	  var needpay=document.getElementById("needpay");
	  var check_array=document.getElementsByName("check");
	  var check_all=document.getElementById("checkall");
	  for(var i=0;i<check_array.length;i++)
	  {
		  var inputid=check_array[i].id.replace(/billid/,'odd');
		  inputodd=document.getElementById(inputid);
		  if(check_all.checked)
		  {
			  check_array[i].checked=true;
			  inputodd.style.display='';
			  result=parseFloat(result)+parseFloat(check_array[i].value);
			  oddment=parseFloat(oddment)+parseFloat(inputodd.value);
		  }
		  else
		  {
			  inputodd.value=0;
			  inputodd.style.display='none';
			  check_array[i].checked=false; 
		  }
	  }
	  needpay.innerHTML=result;
	  oddall.innerHTML=oddment;
	  realpay.innerHTML=result-oddment;
}
function confirmPay()
{
	var realpay=document.getElementById("realpay").innerHTML;
	var check_array=document.getElementsByName("check");
	var accountid=document.getElementById("accountid").value;
	var jine_list='';
	var bill_list='';
	var odd_list='';
	if(realpay=='')
	{
		alert('实际支付金额不能为空');
		return false;
	}
	if(confirm('实际支付金额 '+realpay+' 元，是否确认支付已选择的单据？'))
	{
		  for(var i=0;i<check_array.length;i++)
		  {
			  if(check_array[i].checked)
			  {
				  if(jine_list.length>0)
					  jine_list=jine_list+','; 
				  jine_list=jine_list+check_array[i].value;
				  if(bill_list.length>0)
					  bill_list=bill_list+','; 
				  bill_list=bill_list+check_array[i].id;
				  var inputid=check_array[i].id.replace(/billid/,'odd');
				  inputodd=document.getElementById(inputid);
				  if(odd_list.length>0)
					  odd_list=odd_list+','; 
				  odd_list=odd_list+inputodd.value;
			  }
		
		  }
		  form1.action="v_supplyownmoney_newai.php?action=paybatch&accountid="+accountid+"&supplyid=<?php echo $supplyid?>";
		  form1.billid.value=bill_list;
		  form1.jine.value=jine_list;
		  form1.oddment.value=odd_list;
		  form1.submit();
	}
	
}
function check_input_num(num_type)
{
	
  if(num_type=="NUMBER")
  {
	  
     if(!isNS4)
     {
     	 if((event.keyCode < 48 || event.keyCode > 57)&&event.keyCode != 46 &&event.keyCode != 45)
     	    event.returnValue = false;
     }
     else
     {
     	 if((event.which < 48 || event.which > 57)&&event.keyCode != 46 &&event.keyCode != 45)
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
<body class=bodycolor topMargin=5>
<div id='con'>
<table class=TableBlock align=center width=100%>
<tr><td colspan="11" class="TableHeader">&nbsp;<?php echo $title?>——<?php echo $rs_a[0][supplyname];?>(预付款：<font color=red><?php echo number_format($yufukuan,0,".",",")?></font>元)</td></tr>
	<tr class=TableHeader>
		<?php 
	if($flag)
		echo "<td >选择/抹零</td>";
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
		if($flag)
			echo "<td><input type='checkbox' id='billid_".$row['billid']."' name='check' value=".$row['own']." onclick='CountAllOwn();'><input class='SmallInput' size=8 style='display:none' value=0 type=text name=oddment id='odd_".$row['billid']."' onkeypress=\"check_input_num('MONEY')\" onblur=\"this.value=Math.round(this.value*100)/100;if(this.value=='NaN')this.value=0;CountAllOwn();\">";
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
	if($flag) echo "<td><input type=checkbox id='checkall' onclick='SelectAllCheck()'>全选</td>";
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
<tr><td colspan=<?php echo sizeof($head)?>>
应付总额：<?php echo doubleval($sumcol['own'])?> - 预付款：<?php echo doubleval($yufukuan)?> = 尚欠：<font color=red><?php echo number_format($sumcol['own']-$yufukuan,2)?></font>
</td></tr>
<?php if($flag){?>
<tr class=TableData><td colspan=10>
应付总额：<span id='needpay' style='color: red;font-size:18'></span> 元&nbsp;&nbsp;
去零总额：<span id='oddall' style='color: red;font-size:18'></span> 元&nbsp;&nbsp;
实付总额：<span id='realpay' style='color: red;font-size:18'></span> 元&nbsp;&nbsp;
付款账户：<span style='vertical-align: bottom'><?php print_account_select("accountid","",0,1);?></span>&nbsp;&nbsp;
<input type="button" value='批量付款' class="SmallButton" onclick='confirmPay()'>

</td>
</tr>
<?php }?>
</table>
</div>
<form name=form1 method="post">
<input type='hidden' name='billid'>
<input type='hidden' name='jine'>
<input type='hidden' name='oddment'>
<p align="center"><input type="button" class="SmallButton" value=" 打印 "
	onclick="javascript:prn_print();"> <input type="button"
	class="SmallButton" value="导出"
	onclick="location='v_supplyownmoney_mingxi.php?supplyid=<?php echo $_GET[supplyid];?>&out_excel=true';">
<input type="button" class="SmallButton" value=" 返回 "
	onclick="location='v_supplyownmoney_newai.php';"></p>
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

		LODOP.PRINT_INIT("打印应付款明细");
		
		LODOP.SET_PRINT_PAGESIZE(2,0,0,"");
		LODOP.ADD_PRINT_TABLE("10%","10%","80%","80%",document.documentElement.innerHTML);
		LODOP.SET_PRINT_MODE("PRINT_PAGE_PERCENT","Auto-Width");
	};              
	

</script>

</html>
