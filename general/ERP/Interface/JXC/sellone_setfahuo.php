<?php
	ini_set('display_errors', 1);
	ini_set('error_reporting', E_ALL);
	error_reporting(E_WARNING | E_ERROR);
	$billid=$_GET['billid'];
	require_once('lib.inc.php');
	page_css("���÷���");
	
	$sql="select * from sellplanmain where billid='".$billid."'";
	$rs=$db->Execute($sql);
	$rs_a=$rs->GetArray();
	if(sizeof($rs_a)==0)
	{
		print "<script language=javascript>alert('�Ҳ����˵�');window.close();</script>";
		exit;
	}
	if($_GET['action']=='save')
	{
		$sql="update sellplanmain set fahuostate=2,address='".$_POST['address']."',mobile='".$_POST['mobile'].
		"',fahuodan='".$_POST['fahuodan']."',fahuoyunfei='".floatval($_POST['fahuoyunfei'])."',yunfeitype='".
		$_POST['yunfeitype']."',fahuotype='".$_POST['fahuotype']."',zuiwanfahuodate='".$_POST['zuiwanfahuodate'].
		"' where billid='".$billid."'";
		$db->Execute($sql);
		$Store=new Store($db);
		$chukubillid=returntablefield("stockoutmain", "dingdanbillid", $billid, "billid");
		if($chukubillid!='')
		{
			$db->StartTrans();  
			$Store->insertFaHuo($chukubillid);
			$db->CompleteTrans();
		}
		print_infor("�����Ѹ���Ϊ�跢��",'trip',"close",'close',3);
		exit;
	}
	if($_GET['action']=='cancel')
	{
		$sql="update sellplanmain set fahuostate=-1 where billid='".$billid."'";
		$rs=$db->Execute($sql);
		$chukubillid=returntablefield("stockoutmain", "dingdanbillid", $billid, "billid");
		if($chukubillid!='')
		{
			$sql="delete from fahuodan where billid='".$chukubillid."'";
			$rs=$db->Execute($sql);
		}
		print_infor("�����Ѹ�Ϊ���跢��",'trip',"close",'close',3);
		exit;
	}
?>
<script language="javascript" type="text/javascript" src="<?php echo ROOT_DIR?>general/ERP/Enginee/WdatePicker/WdatePicker.js"></script>
<script Language='JavaScript'>
function FormCheck()
{
	if(form1.address.value=='')
	{
		alert('��ַ����Ϊ��');
		return false;
	}
	if(form1.mobile.value=='')
	{
		alert('�绰����Ϊ��');
		return false;
	}
	return true;
}
</script>
<FORM name="form1" id=form onsubmit="return FormCheck();" 
 action="?action=save&billid=<?php echo $rs_a[0]['billid']?>" method=post>
 
<table class=TableBlock align=center  id='table' width=65% cellspacing=0 cellpadding=0>
<TR class='TableControl'><TD class=TableHeader align=left colSpan=3>&nbsp;���÷�����Ϣ</TD></TR><TR>
<TR>
<TD class=TableData noWrap width=20%>����:</TD>
<TD class=TableData noWrap colspan='2'><?php echo $rs_a[0]['billid']?></TD></TR>
<TR>
<TD class=TableData noWrap width=20%>�ͻ�����:</TD>
<TD class=TableData noWrap colspan='2'><?php echo returntablefield("customer","ROWID", $rs_a[0]['supplyid'], "supplyname")?></TD></TR>
<TR>
<TD class=TableData noWrap width=20%>��ַ:</TD>
<TD class=TableData noWrap colspan='2'><INPUT type='text' title=''
			onkeydown='if(event.keyCode==13)event.keyCode=9' accesskey='16' class='SmallInput'  maxLength=200 size='30'
			name='address' id='address' value='<?php echo $rs_a[0]['address']?>'  >&nbsp;
����</TD></TR>
<TR>
<TD class=TableData noWrap width=20%>�绰:</TD>
<TD class=TableData noWrap colspan='2'><INPUT type='text' title=''
			onkeydown='if(event.keyCode==13)event.keyCode=9' accesskey='17' class='SmallInput'  maxLength=200 size='30'
			name='mobile' id='mobile' value='<?php echo $rs_a[0]['mobile']?>'  >&nbsp;
����</TD></TR>
<TR>
<TD class=TableData noWrap width=20%>��������:</TD>
<TD class=TableData noWrap colspan=2><INPUT type='text' title=''
			onkeydown='if(event.keyCode==13)event.keyCode=9' accesskey='10' class='SmallInput'  maxLength=200 size='30'
			name='fahuodan' value=''  >&nbsp;
</TD></TR>
<TR>
<TD class=TableData noWrap width=20%>�����˷�:</TD>
<TD class=TableData noWrap colspan='2'><INPUT type='text' title=''
			onkeydown='if(event.keyCode==13)event.keyCode=9' accesskey='11' class='SmallInput'  maxLength=200 size='30'
			name='fahuoyunfei' value='' onkeypress="check_input_num('MONEY')" onblur="this.value=Math.round(this.value*100)/100;">&nbsp;
</TD></TR>
<TR>
<TD class=TableData noWrap width=20%>�˷ѽ���:</TD><TD class=TableData noWrap colspan='2'>
<?php 
print_select_single_select2('yunfeitype',$fields['value']['yunfeitype'],'yunfeitype', 'id', 'name');
?>
</td></tr>
<TR><TD class=TableData noWrap>������ʽ:</TD>
<TD class=TableData noWrap colspan='2'>
<?php 
print_select_single_select2('fahuotype',$fields['value']['fahuotype'],'fahuotype', 'id', 'name');
?>
</TD></TR>

<TR><TD class=TableData noWrap width=20%>����������:</TD>
<TD class=TableData colspan='2'><INPUT class=SmallInput maxLength=20 id='zuiwanfahuodate' name='zuiwanfahuodate' value='<?php echo date("Y-m-d")?>' title=''  onClick="WdatePicker({dateFmt:'yyyy-MM-dd',alwaysUseStartDate:true})">
<img src='<?php echo ROOT_DIR?>general/ERP/Framework/images/menu/calendar.gif' width=16 height=16 title='��������' align='absMiddle' border='0' align='absMiddle' style='cursor:pointer' onclick='zuiwanfahuodate.click();'></TD></TR>
</table>
<div align="center">
<br>
<input type=submit accesskey="s" name="submit" value=" ���� " class=SmallButton  title="��ݼ�:ALT+s">&nbsp;
<input type=button accesskey="c" name="cancel" value=" �ر� " class=SmallButton onClick="window.close();" title="��ݼ�:ALT+c">
</div>
</FORM>