<?php
ini_set('display_errors', 1);
	ini_set('error_reporting', E_ALL);
	error_reporting(E_WARNING | E_ERROR);
	require_once('lib.inc.php');
	$GLOBAL_SESSION=returnsession();
	page_css("��ͬ�ƻ�����");
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
alert("��Ʒ����Ϊ��");
 return false;}
if (document.form1.customerid.value == "") {
alert("�ͻ�����Ϊ��");
 return false;}
if (document.form1.hetongid.value == "") {
alert("��ͬ����Ϊ��");
 return false;}
if (document.form1.price.value == "") {
alert("�۸���Ϊ��");
 return false;}
if (document.form1.num.value == "") {
alert("��������Ϊ��");
 return false;}
if (document.form1.jiaofudate.value == "") {
alert("�ƻ��������ڲ���Ϊ��");
 return false;}
}
</script>
</head>
<body class=bodycolor topMargin=5>
<FORM name=form1 onsubmit="return FormCheck();" 
 action="sellcontract_plan_newai.php?action=action_jiaofu_data" method=post encType=multipart/form-data>
 <input type="hidden" name="id" value="<?php echo $_GET["id"]?>">
<table class=TableBlock align=center width=450 ><TR><TD class=TableHeader align=left colSpan=3>&nbsp;��ͬ�ƻ�����</TD></TR>
<TR><TD class=TableControl noWrap align=middle  colspan="3">
<div align="left">
<input type=submit accesskey="s" name="submit" value=" ���� " class=SmallButton onClick="" title="��ݼ�:ALT+s">
<input type=button accesskey="c" name="cancel" value=" ���� " class=SmallButton onClick="history.back();" title="��ݼ�:ALT+c">
</div>
</TD></TR>
<TR><TD class=TableData noWrap>�ͻ�:</TD><TD class=TableData noWrap>
<input type="hidden" name="customerid" value="<?php echo $rs_a[0]['supplyid']?>"><?php echo $customername?></TD></TR>
<TR><TD class=TableData noWrap>��ͬ:</TD><TD class=TableData noWrap>
<input type="hidden" name="hetongid" value="<?php echo $rs_a[0]['mainrowid']?>"><?php echo $hetongzhuti?></TD></TR>
<TR><TD class=TableData noWrap>��Ʒ:</TD><TD class=TableData noWrap >
<input type="hidden" name="productid" value="<?php echo $rs_a[0]['prodid']?>"><?php echo $productname?></TD></TR>

<TR><TD class=TableData noWrap>��������:</TD>
<TD class=TableData noWrap><INPUT type="text" title=''
			onkeydown="if(event.keyCode==13)event.keyCode=9" accesskey='5' class="SmallInput"  maxLength=200 size="30"
			name='num' value="<?php echo $num?>" > ���� </TD></TR>
<TR><TD class=TableData noWrap width=20%>����:</TD>
<TD class=TableData noWrap colspan="2"><INPUT type="text" title=''
			onkeydown="if(event.keyCode==13)event.keyCode=9" accesskey='4'  maxLength=200 size="30"
			name='price' value="<?php echo $price?>" class="SmallStatic" readonly>
</TD></TR>
<TR><TD class=TableContent noWrap width=20%>��������:</TD>
<TD class=TableData colspan="2"><INPUT class=SmallInput maxLength=20  name=jiaofudate value="<?php echo date("Y-m-d")?>" title='' onkeydown="if(event.keyCode==13)event.keyCode=9" >
<input type="button"  title=''  value="ѡ��" class="SmallButton" onclick="td_calendar('../../Framework/sms_index/calendar_begin.php?datetime=jiaofudate');" title="ѡ��" name="button">&nbsp;&nbsp;<input type="button"  title=''  value="���" class="SmallButton" onClick="clear_jiaofudate()" title="���" name="button">����</TD></TR>
<TR>
<TD class=TableData noWrap width=20%>�Է�������:</TD>
<TD class=TableData noWrap colspan="2"><INPUT type="text" title=''
			onkeydown="if(event.keyCode==13)event.keyCode=9" accesskey='7' class="SmallInput"  maxLength=200 size="30"
			name='jieshouren' value=""  >&nbsp;
</TD></TR>
<TR>
<TD class=TableData noWrap width=20%>��ע:</TD>
<TD class=TableData noWrap colspan="2"><TEXTAREA class=BigInput name=beizhu  title='' wrap=yes rows=5 cols=40  ></TEXTAREA>&nbsp;
</TD></TR>
<TR><TD class=TableControl noWrap align=middle  colspan="2">
<div align="left">
<input type=submit accesskey="s" name="submit" value=" ���� " class=SmallButton onClick="" title="��ݼ�:ALT+s">
<input type=button accesskey="c" name="cancel" value=" ���� " class=SmallButton onClick="history.back();" title="��ݼ�:ALT+c">
</div>
</TD></TR>
</table>
</form>
</body></html>