<?php
	$billid=$_GET["billid"];
	$url=$_GET["url"];
	ini_set('display_errors', 1);
	ini_set('error_reporting', E_ALL);
	error_reporting(E_WARNING | E_ERROR);
	require_once('lib.inc.php');
	$GLOBAL_SESSION=returnsession();
	page_css("ȷ�Ϸ�����");
	global $db;
	$sql="select * from fahuodan_detail where billid=".$billid;
	$rs=$db->Execute($sql);
	$rs_a = $rs->GetArray();	
	
?>
<script language = "JavaScript"> 
function FormCheck() 
{
if (document.form1.shouhuoren.value == "") {
alert("�ջ��˲���Ϊ��");
 return false;}
if (document.form1.address.value == "") {
alert("�ջ���ַ����Ϊ��");
 return false;}
if (document.form1.tel.value == "") {
alert("�绰����Ϊ��");
 return false;}
var sbtn=document.getElementsByName('submit');
for(i=0;i<sbtn.length;i++)
{
	sbtn[i].value='�ύ��';
	sbtn[i].disabled=true;
}
return true;
}
</script>
</head>
<body class=bodycolor topMargin=5>
<FORM name=form1 onsubmit="return FormCheck();" 
 action="fahuodan_newai.php?action=edit_default2_data" method=post encType=multipart/form-data>
<table class=TableBlock align=center width=65% ><TR><TD class=TableHeader align=left colSpan=3>&nbsp;������</TD></TR>
<?php 
$fahuoinfo=returntablefield("fahuodan", "billid", $billid, "outtype,customerid,dingdanbillid");
	$outtype=$fahuoinfo['outtype'];
	$customerid=$fahuoinfo['customerid'];
	$dingdanbillid=$fahuoinfo['dingdanbillid'];
	$supplyname='';
	$title='';
	if($outtype=="���۳���")
	{
		$supplyname=returntablefield("customer", "rowid", $customerid, "supplyname");
		$title=returntablefield("sellplanmain", "billid", $dingdanbillid, "zhuti");
	}
	else if($outtype=='��������')
	{
		$supplyname=returntablefield("supply", "rowid", $customerid, "supplyname");
		$title=returntablefield("buyplanmain","billid",$dingdanbillid,"zhuti");
	}
?>
<TR>
<TD class=TableContent noWrap width=20%>��Ӧ���ⵥ��:</TD>
<TD class=TableData noWrap colspan="2"><?php echo $rs_a[0]['billid']?></TD></TR>

<TR><TD class=TableContent noWrap>�ͻ�/��Ӧ��:</TD>
<TD class=TableData noWrap colspan="2"><?php echo $supplyname?></TD></TR>
<TR><TD class=TableContent noWrap>��Ӧ����:</TD>
<TD class=TableData noWrap colspan="2"><?php echo $title?></TD></TR>
<TR><TD class=TableContent noWrap>��������:</TD>
<TD class=TableData noWrap colspan="2"><INPUT type="text" title=''
			onkeydown="if(event.keyCode==13)event.keyCode=9"  class="SmallInput"  maxLength=30 size="30"
			name='fahuodan' value="<?php echo $rs_a[0]['fahuodan']?>" >&nbsp;
</TD></TR>
<TR><TD class=TableContent noWrap>�ջ���:</TD>
<TD class=TableData noWrap colspan="2"><INPUT type="text" title=''
			onkeydown="if(event.keyCode==13)event.keyCode=9"  class="SmallInput"  maxLength=30 size="30"
			name='shouhuoren' value="<?php echo $rs_a[0]['shouhuoren']?>" >&nbsp;����
</TD></TR>
<TR><TD class=TableContent noWrap>�ջ���ַ:</TD>
<TD class=TableData noWrap colspan="2"><INPUT type="text" title=''
			onkeydown="if(event.keyCode==13)event.keyCode=9"  class="SmallInput"  maxLength=30 size="30"
			name='address' value="<?php echo $rs_a[0]['address']?>" >&nbsp;����
</TD></TR>
<TR><TD class=TableContent noWrap>�绰:</TD>
<TD class=TableData noWrap colspan="2"><INPUT type="text" title=''
			onkeydown="if(event.keyCode==13)event.keyCode=9"  class="SmallInput"  maxLength=30 size="30"
			name='tel' value="<?php echo $rs_a[0]['tel']?>" >&nbsp;����
</TD></TR>
<TR><TD class=TableContent noWrap>�ʱ�:</TD>
<TD class=TableData noWrap colspan="2"><INPUT type="text" title=''
			onkeydown="if(event.keyCode==13)event.keyCode=9"  class="SmallInput"  maxLength=30 size="30"
			name='mailcode' value="<?php echo $rs_a[0]['mailcode']?>" >&nbsp;
</TD></TR>
<TR><TD class=TableContent noWrap>������ʽ:</TD>
<TD class=TableData noWrap colspan="2"><select class="SmallSelect"
			onkeydown="if(event.keyCode==13)event.keyCode=9" name="fahuotype">
			<option value=""></option>
			<?php 
			$sql="select * from fahuotype";
			$rs=$db->Execute($sql);
			$rs_b = $rs->GetArray();
			
			for($i=0;$i<count($rs_b);$i++)
			{
				$check="";
				if($rs_a[0]['fahuotype']==$rs_b[$i]['id'])
					$check="selected";
				print "<option value=".$rs_b[$i]['id']." $check>".$rs_b[$i]['name']."</option>";
			}
			?>
			</select>
</TD></TR>
<TR><TD class=TableContent noWrap>�������:</TD>
<TD class=TableData noWrap colspan="2"><INPUT type="text" title=''
			onkeydown="if(event.keyCode==13)event.keyCode=9"  class="SmallInput"  maxLength=30 size="30"
			name='package' value="<?php echo $rs_a[0]['package']?>" >&nbsp;
</TD></TR>
<TR><TD class=TableContent noWrap>����(Kg):</TD>
<TD class=TableData noWrap colspan="2"><INPUT type="text" title=''
			onkeydown="if(event.keyCode==13)event.keyCode=9"  class="SmallInput" onKeyPress="return inputFloat(event);"  maxLength=30 size="30"
			name='weight' value="<?php echo $rs_a[0]['weight']?>" >&nbsp;
</TD></TR>
<TR><TD class=TableContent noWrap>�˷�:</TD>
<TD class=TableData noWrap colspan="2"><INPUT type="text" title=''
			onkeydown="if(event.keyCode==13)event.keyCode=9"  class="SmallInput" onKeyPress="return inputFloat(event);"  maxLength=30 size="30"
			name='yunfei' value="<?php echo $rs_a[0]['yunfei']?>" >&nbsp;
</TD></TR>
<TR><TD class=TableContent noWrap>�˷ѽ���:</TD>
<TD class=TableData noWrap colspan="2"><select class="SmallSelect"
			onkeydown="if(event.keyCode==13)event.keyCode=9" name="jiesuantype">
			<?php 
			$sql="select * from yunfeitype";
			$rs=$db->Execute($sql);
			$rs_b = $rs->GetArray();
			for($i=0;$i<count($rs_b);$i++)
			{
				$check="";
				if($rs_a[0]['jiesuantype']==$rs_b[$i]['id'])
					$check="selected";
				print "<option value=".$rs_b[$i]['id']." $check>".$rs_b[$i]['name']."</option>";
			}
			?>
			</select>
</TD></TR>

<TR><TD class=TableContent noWrap>�Ƿ����֪ͨ:</TD>
<TD class=TableData noWrap colspan="2"><input type="checkbox" name="duanxintongzhi" value ="yes" ></TD></TR>

<TR>
<TD class=TableContent noWrap width=20%>��ע:</TD>
<TD class=TableData noWrap colspan="2"><TEXTAREA class=BigInput name=beizhu  title='' wrap=yes rows=5 cols=40  ></TEXTAREA>&nbsp;
</TD></TR>

<tr class=TableData><td colspan=3 nowrap width=100%>
<table class=TableBlock align=center width=100% ><tr class=TableContent>
<td nowrap>��Ʒ���</td><td nowrap>����</td><td nowrap>��ɫ</td><td nowrap>���</td><td nowrap>��λ</td><td nowrap>����</td><td nowrap>�ۿ�</td><td nowrap>����</td><td nowrap>���</td><td nowrap>��ע</td></tr>
<?php 
	$sql="select * from fahuodan_detail where mainrowid=".$billid;
	$rs=$db->Execute($sql);
	$rs_detail = $rs->GetArray();
	for($i=0;$i<count($rs_detail);$i++)
	{
		$allnum=$allnum+$rs_detail[$i]['num'];
		$allmoney=$allmoney+$rs_detail[$i]['jine']
		?>
		<tr class=TableData>
		<td ><?php echo $rs_detail[$i]['prodid']?></td>
		<td ><?php echo $rs_detail[$i]['prodname']?></td>
		<td ><?php echo $rs_detail[$i]['prodguige']?></td>
		<td ><?php echo $rs_detail[$i]['prodxinghao']?></td>
		<td ><?php echo $rs_detail[$i]['proddanwei']?></td>
		<td ><?php echo $rs_detail[$i]['price']?></td>
		<td ><?php echo $rs_detail[$i]['zhekou']*100?>%</td>
		<td ><?php echo $rs_detail[$i]['num']?></td>
		<td ><?php echo $rs_detail[$i]['jine']?></td>
		<td ><?php echo $rs_detail[$i]['beizhu']?></td>
		</tr>
	<?php 
	}
?>
<tr class=TableData><td align=center><b>�ϼ�</b></td><td colspan=6></td>
<td><?php echo $allnum?></td><td><?php echo $allmoney?></td><td></td></tr>
</table></td></tr>

<TR><TD class=TableControl noWrap align=middle  colspan="3">
<div align="center">
<input type=button accesskey="p" name="print" value="����Ӧ�̻���СƱ" class=SmallButton onClick="" title="��ݼ�:ALT+p">
<input type=submit accesskey="s" name="submit" value=" ���� " class=SmallButton onClick="" title="��ݼ�:ALT+s">
<input type=button accesskey="c" name="cancel" value=" ���� " class=SmallButton onClick="location='<?php echo $url?>';" title="��ݼ�:ALT+c">
</div>
</TD></TR>
</table>
<input type="hidden" name="billid" value=<?php echo $billid?>> 
<input type="hidden" name="url" value=<?php echo $url?>>
</form>
</body>
</html>