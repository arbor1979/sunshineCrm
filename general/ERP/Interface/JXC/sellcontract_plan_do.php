<?php
ini_set('display_errors', 1);
	ini_set('error_reporting', E_ALL);
	error_reporting(E_WARNING | E_ERROR);
	require_once('lib.inc.php');
	$GLOBAL_SESSION=returnsession();
	page_css("合同计划交付");
	global $db;
	$sql="select * from v_sellcontract_plan where id=".$_GET["id"];
	$sql=getCustomerRoleByCustID($sql,"supplyid");
	$rs=$db->Execute($sql);
	$rs_a = $rs->GetArray();
	
	$productname=$rs_a[0]['prodname'];
	$customername=returntablefield( "customer", "rowid", $rs_a[0]['supplyid'], "supplyname" );
	$hetongzhuti=$rs_a[0]['zhuti'];
	$num=$rs_a[0]['num']-$rs_a[0]['chukunum'];
	$price=$rs_a[0]['price'];
?>
<script language = "JavaScript"> 
function clear_jiaofudate()
{
  document.form1.jiaofudate.value="";
}
function FormCheck() 
{
if (document.form1.productid.value == "") {
alert("产品不能为空");
 return false;}
if (document.form1.customerid.value == "") {
alert("客户不能为空");
 return false;}
if (document.form1.hetongid.value == "") {
alert("合同不能为空");
 return false;}
if (document.form1.price.value == "") {
alert("价格不能为空");
 return false;}
if (document.form1.num.value == "") {
alert("数量不能为空");
 return false;}
if (document.form1.jiaofudate.value == "") {
alert("计划交付日期不能为空");
 return false;}
}
</script>
</head>
<body class=bodycolor topMargin=5>
<FORM name=form1 onsubmit="return FormCheck();" 
 action="sellcontract_plan_newai.php?action=action_jiaofu_data" method=post encType=multipart/form-data>
 <input type="hidden" name="id" value="<?php echo $_GET["id"]?>">
<table class=TableBlock align=center width=450 ><TR><TD class=TableHeader align=left colSpan=3>&nbsp;合同计划交付</TD></TR>
<TR><TD class=TableControl noWrap align=middle  colspan="3">
<div align="left">
<input type=submit accesskey="s" name="submit" value=" 保存 " class=SmallButton onClick="" title="快捷键:ALT+s">
<input type=button accesskey="c" name="cancel" value=" 返回 " class=SmallButton onClick="history.back();" title="快捷键:ALT+c">
</div>
</TD></TR>
<TR><TD class=TableData noWrap>客户:</TD><TD class=TableData noWrap>
<input type="hidden" name="customerid" value="<?php echo $rs_a[0]['supplyid']?>"><?php echo $customername?></TD></TR>
<TR><TD class=TableData noWrap>合同:</TD><TD class=TableData noWrap>
<input type="hidden" name="hetongid" value="<?php echo $rs_a[0]['mainrowid']?>"><?php echo $hetongzhuti?></TD></TR>
<TR><TD class=TableData noWrap>产品:</TD><TD class=TableData noWrap >
<input type="hidden" name="productid" value="<?php echo $rs_a[0]['prodid']?>"><?php echo $productname?></TD></TR>

<TR><TD class=TableData noWrap>交付数量:</TD>
<TD class=TableData noWrap><INPUT type="text" title=''
			onkeydown="if(event.keyCode==13)event.keyCode=9" accesskey='5' class="SmallInput"  maxLength=200 size="30"
			name='num' value="<?php echo $num?>" > 必填 </TD></TR>
<TR><TD class=TableData noWrap width=20%>单价:</TD>
<TD class=TableData noWrap colspan="2"><INPUT type="text" title=''
			onkeydown="if(event.keyCode==13)event.keyCode=9" accesskey='4'  maxLength=200 size="30"
			name='price' value="<?php echo $price?>" class="SmallStatic" readonly>
</TD></TR>
<TR><TD class=TableContent noWrap width=20%>交付日期:</TD>
<TD class=TableData colspan="2"><INPUT class=SmallInput maxLength=20  name=jiaofudate value="<?php echo date("Y-m-d")?>" title='' onkeydown="if(event.keyCode==13)event.keyCode=9" >
<input type="button"  title=''  value="选择" class="SmallButton" onclick="td_calendar('../../Framework/sms_index/calendar_begin.php?datetime=jiaofudate');" title="选择" name="button">&nbsp;&nbsp;<input type="button"  title=''  value="清除" class="SmallButton" onClick="clear_jiaofudate()" title="清除" name="button">必填</TD></TR>
<TR>
<TD class=TableData noWrap width=20%>对方接收人:</TD>
<TD class=TableData noWrap colspan="2"><INPUT type="text" title=''
			onkeydown="if(event.keyCode==13)event.keyCode=9" accesskey='7' class="SmallInput"  maxLength=200 size="30"
			name='jieshouren' value=""  >&nbsp;
</TD></TR>
<TR>
<TD class=TableData noWrap width=20%>备注:</TD>
<TD class=TableData noWrap colspan="2"><TEXTAREA class=BigInput name=beizhu  title='' wrap=yes rows=5 cols=40  ></TEXTAREA>&nbsp;
</TD></TR>
<TR><TD class=TableControl noWrap align=middle  colspan="2">
<div align="left">
<input type=submit accesskey="s" name="submit" value=" 保存 " class=SmallButton onClick="" title="快捷键:ALT+s">
<input type=button accesskey="c" name="cancel" value=" 返回 " class=SmallButton onClick="history.back();" title="快捷键:ALT+c">
</div>
</TD></TR>
</table>
</form>
</body></html>