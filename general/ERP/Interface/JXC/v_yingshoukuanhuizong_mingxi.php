<?php
ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL);
error_reporting(E_WARNING | E_ERROR);
$supplyid=$_GET['supplyid'];
require_once('lib.inc.php');
$GLOBAL_SESSION=returnsession();
validateMenuPriv("批量收款");
global $db;
$start_time = $_GET['start_time'];
$end_time = $_GET['end_time'];
$iffahuo = $_GET['iffahuo'];
$iftuihuo = $_GET['iftuihuo'];
if($supplyid=='')
{
	print "<script language=javascript>alert('错误：必须选择一个客户');window.history.back(-1);</script>";
	exit;
}

$custinfo=returntablefield("customer", "ROWID", $supplyid, "supplyname,yuchuzhi");
$custname=$custinfo['supplyname'];
$yuchuzhi=$custinfo['yuchuzhi'];
$sql="select `a`.`billid`,`a`.`user_id`,`a`.`createtime`,`a`.`qianyueren`,`b`.`name` as `fahuostate`,`a`.`beizhu`,`a`.`createtime`,`a`.`totalmoney`,`a`.`huikuanjine`,`a`.`oddment`,(`a`.`totalmoney` - `a`.`huikuanjine` - `a`.`oddment`) AS `own` ,if(round(a.tuihuojine,2)=round(a.totalmoney,2),'是','否') as iftuidan,`d`.`USER_NAME` AS `createman` ,`c`.`name` AS `typename` from (`sellplanmain` `a` left join fahuostate `b` on a.fahuostate=b.id left join `sellbilltype` `c` on `a`.`billtype` = `c`.`id` left join `user` `d` on`a`.`user_id` = `d`.`USER_ID`) where (`a`.`ifpay` < 2 and `a`.`user_flag` = 1 and `a`.`supplyid`=".$supplyid." )";
if($start_time!='')
	$sql.=" and a.createtime>='".$start_time."'";
if($end_time!='')
	$sql.=" and a.createtime<='".$end_time."'";
if($iffahuo==1)
	$sql.=" and a.fahuostate>=0";
else if($iffahuo==-1)
	$sql.=" and a.fahuostate=-1";
if($iftuihuo==1)
	$sql.=" and a.totalmoney=a.tuihuojine";
else if($iftuihuo==-1)
	$sql.=" and a.totalmoney<>a.tuihuojine";
$rs=$db->Execute($sql);
$rs_a = $rs->GetArray();

//是否有付款权限
$flag=validateSingleMenuPriv("回款记录");

$head=array("billid"=>"单号","typename"=>"单据类型","iftuidan"=>"是否退单","createman"=>"创建人","createtime"=>"创建日期","fahuostate"=>"发货状态","totalmoney"=>"总金额","huikuanjine"=>"回款金额","oddment"=>"去零金额","own"=>"应收金额","own"=>"应收金额","beizhu"=>"备注");
$headtype=array("billid"=>"string","typename"=>"string","iftuidan"=>"string","qianyueren"=>"string","createtime"=>"string","createtime"=>"fahuostate","totalmoney"=>"float","huikuanjine"=>"float","oddment"=>"float","own"=>"float","beizhu"=>"string");
$title="应收款明细";
$sumcol=array("totalmoney"=>"","huikuanjine"=>"","oddment"=>"","own"=>"");
if($_GET['out_excel'] == 'true'){
	export_XLS($head,$rs_a,$title,$sumcol);
	exit;
}
?>
<html>
<head>
<?php page_css($title); ?>
<SCRIPT src="../../Enginee/WdatePicker/WdatePicker.js"></SCRIPT>
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
	  needpay.innerHTML=Math.round(result*100)/100;
	  oddall.innerHTML=Math.round(oddment*100)/100;
	  realpay.innerHTML=Math.round((result-oddment)*100)/100;
	  
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
	  needpay.innerHTML=Math.round(result*100)/100;
	  oddall.innerHTML=Math.round(oddment*100)/100;
	  realpay.innerHTML=Math.round((result-oddment)*100)/100;
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
		alert('实际收款金额不能为空');
		return false;
	}
	if(confirm('实际收款金额 '+realpay+' 元，是否确认收款？'))
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
		  form2.action="v_yingshoukuanhuizong_newai.php?action=paybatch&accountid="+accountid+"&supplyid=<?php echo $supplyid?>";
		  form2.billid.value=bill_list;
		  form2.jine.value=jine_list;
		  form2.oddment.value=odd_list;
		  form2.submit();
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
<table id='tablecontent' class=TableBlock align=center width=100%>
<form method='get' name='form1'>
<tr><td colspan="12" class="TableHeader">
<?php echo $title?>
-&nbsp;客户：<input type='hidden'  name='supplyid' value='<?php echo $supplyid?>' ><input type='text' name='supplyid_ID' value='<?php echo $custname?>' readonly class='SmallStatic' size='30' )>&nbsp;							
<a href="javascript:;" class="orgAdd" onClick="SelectAllInforSingle('../../Enginee/Module/kehu_select_single/index.php','','supplyid_ID', 'supplyid');">选择</a>
<a href="#" class="orgClear" onClick="ClearUser('supplyid_ID', 'supplyid')" title="清空">清空</a>
</td></tr>
<tr><td colspan="12" class="TableHeader">
时间段： <input class="SmallInput" size="19"
							name="start_time" value="<?php echo $start_time?>"
							onclick="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss'})"
							readonly=""> — <input class="SmallInput" size="19"
							name="end_time" value="<?php echo $end_time?>"
							onclick="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss'})"
							readonly="">
							

是否发货：<select name='iffahuo'>
<option value=0>-全部-</option>
<option value=1 <?php if($iffahuo==1)echo "selected";?>>是</option>
<option value=-1 <?php if($iffahuo==-1)echo "selected";?>>否</option>
</select>
&nbsp;
退货单：<select name='iftuihuo'>
<option value=0>-全部-</option>
<option value=1 <?php if($iftuihuo==1)echo "selected";?>>是</option>
<option value=-1 <?php if($iftuihuo==-1)echo "selected";?>>否</option>
</select>
&nbsp;<input type="submit" class="SmallButton" value="查询">
</td></tr>
</form>

		<tr class=TableHeader>
		<?php 
	if($flag)
		echo "<td nowrap>选择/抹零</td>";
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
			if($key=="billid")
			{
				if($row['typename']=='订单')
					$url='sellplanmain';
				else if($row['typename']=='合同')
					$url='sellcontract';
				else
					$url='v_sellone_search';
				if($row['iftuidan']=='是')
					$tuidan="style='color:red'";
				else 
					$tuidan='';
				if($url=="v_sellone_search")
					$printXiaoPiao="<a href='sellonemain_newai.php?action=printXiaoPiao&billid=".$row[$key]."' target='_blank'><img title='打印小票' src='../../Framework/images/printer.gif'></a>";
				$row[$key]=$printXiaoPiao." <a href='".$url."_newai.php?".base64_encode("action=view_default&billid=".$row[$key])."' target='_blank'>".$row[$key]."</a>";
			}
			if($headtype[$key]=="int" || $headtype[$key]=="float")
				$align="right";
			else if($headtype[$key]=="char")
				$align="center";
			else
				$align="left";
			
			if($key=="beizhu")
				echo "<td $tuidan align='".$align."'>";
			else 
				echo "<td $tuidan nowrap align='".$align."'>";
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
	if($flag) echo "<td nowrap><input type=checkbox id='checkall' onclick='SelectAllCheck()'>全选</td>";
	$i=0;
	foreach ($head as $key=>$val)
	{
		if($i==0)
			print "<td nowrap>合计 <b>".sizeof($rs_a)."</b> 条记录</td>";
		else
		{
			print "<td nowrap align=right><b>";
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
应收总额：<?php echo doubleval($sumcol['own'])?> - 预收款：<?php echo doubleval($yuchuzhi)?> = 实际应收：<font color=red><?php echo number_format($sumcol['own']-$yuchuzhi,2)?></font>
</td></tr>
<?php if($flag){?>
<tr class=TableData><td colspan=12>
应收总额：<span id='needpay' style='color: red;font-size:18'></span> 元&nbsp;&nbsp;
去零总额：<span id='oddall' style='color: red;font-size:18'></span> 元&nbsp;&nbsp;
实收总额：<span id='realpay' style='color: red;font-size:18'></span> 元&nbsp;&nbsp;
收款账户：<span style='vertical-align: bottom'><?php print_account_select("accountid","",1,1);?></span>&nbsp;&nbsp;
<input type="button" value='批量收款' class="SmallButton" onclick='confirmPay()'>

</td>
</tr>
<?php }?>
</table>
</div>
<form name=form2 method="post">
<input type='hidden' name='billid'>
<input type='hidden' name='jine'>
<input type='hidden' name='oddment'>
<p align="center"><input type="button" class="SmallButton" value=" 打印 "
	onclick="javascript:prn_print();"> <input type="button"
	class="SmallButton" value="导出"
	onclick="location='v_yingshoukuanhuizong_mingxi.php?supplyid=<?php echo $supplyid;?>&out_excel=true';">
<input type="button" class="SmallButton" value=" 返回 "
	onclick="location='v_yingshoukuanhuizong_newai.php';"></p>
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
