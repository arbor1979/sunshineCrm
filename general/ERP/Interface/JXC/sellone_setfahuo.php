<?php
	ini_set('display_errors', 1);
	ini_set('error_reporting', E_ALL);
	error_reporting(E_WARNING | E_ERROR);
	$billid=$_GET['billid'];
	require_once('lib.inc.php');
	page_css("设置发货");
	
	$sql="select * from sellplanmain where billid='".$billid."'";
	$rs=$db->Execute($sql);
	$rs_a=$rs->GetArray();
	if(sizeof($rs_a)==0)
	{
		print "<script language=javascript>alert('找不到此单');window.close();</script>";
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
		print_infor("单据已更改为需发货",'trip',"close",'close',3);
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
		print_infor("单据已改为无需发货",'trip',"close",'close',3);
		exit;
	}
?>
<script language="javascript" type="text/javascript" src="<?php echo ROOT_DIR?>general/ERP/Enginee/WdatePicker/WdatePicker.js"></script>
<script Language='JavaScript'>
function FormCheck()
{
	if(form1.address.value=='')
	{
		alert('地址不能为空');
		return false;
	}
	if(form1.mobile.value=='')
	{
		alert('电话不能为空');
		return false;
	}
	return true;
}
</script>
<FORM name="form1" id=form onsubmit="return FormCheck();" 
 action="?action=save&billid=<?php echo $rs_a[0]['billid']?>" method=post>
 
<table class=TableBlock align=center  id='table' width=65% cellspacing=0 cellpadding=0>
<TR class='TableControl'><TD class=TableHeader align=left colSpan=3>&nbsp;设置发货信息</TD></TR><TR>
<TR>
<TD class=TableData noWrap width=20%>单号:</TD>
<TD class=TableData noWrap colspan='2'><?php echo $rs_a[0]['billid']?></TD></TR>
<TR>
<TD class=TableData noWrap width=20%>客户名称:</TD>
<TD class=TableData noWrap colspan='2'><?php echo returntablefield("customer","ROWID", $rs_a[0]['supplyid'], "supplyname")?></TD></TR>
<TR>
<TD class=TableData noWrap width=20%>地址:</TD>
<TD class=TableData noWrap colspan='2'><INPUT type='text' title=''
			onkeydown='if(event.keyCode==13)event.keyCode=9' accesskey='16' class='SmallInput'  maxLength=200 size='30'
			name='address' id='address' value='<?php echo $rs_a[0]['address']?>'  >&nbsp;
必填</TD></TR>
<TR>
<TD class=TableData noWrap width=20%>电话:</TD>
<TD class=TableData noWrap colspan='2'><INPUT type='text' title=''
			onkeydown='if(event.keyCode==13)event.keyCode=9' accesskey='17' class='SmallInput'  maxLength=200 size='30'
			name='mobile' id='mobile' value='<?php echo $rs_a[0]['mobile']?>'  >&nbsp;
必填</TD></TR>
<TR>
<TD class=TableData noWrap width=20%>发货单号:</TD>
<TD class=TableData noWrap colspan=2><INPUT type='text' title=''
			onkeydown='if(event.keyCode==13)event.keyCode=9' accesskey='10' class='SmallInput'  maxLength=200 size='30'
			name='fahuodan' value=''  >&nbsp;
</TD></TR>
<TR>
<TD class=TableData noWrap width=20%>发货运费:</TD>
<TD class=TableData noWrap colspan='2'><INPUT type='text' title=''
			onkeydown='if(event.keyCode==13)event.keyCode=9' accesskey='11' class='SmallInput'  maxLength=200 size='30'
			name='fahuoyunfei' value='' onkeypress="check_input_num('MONEY')" onblur="this.value=Math.round(this.value*100)/100;">&nbsp;
</TD></TR>
<TR>
<TD class=TableData noWrap width=20%>运费结算:</TD><TD class=TableData noWrap colspan='2'>
<?php 
print_select_single_select2('yunfeitype',$fields['value']['yunfeitype'],'yunfeitype', 'id', 'name');
?>
</td></tr>
<TR><TD class=TableData noWrap>发货方式:</TD>
<TD class=TableData noWrap colspan='2'>
<?php 
print_select_single_select2('fahuotype',$fields['value']['fahuotype'],'fahuotype', 'id', 'name');
?>
</TD></TR>

<TR><TD class=TableData noWrap width=20%>最晚发货日期:</TD>
<TD class=TableData colspan='2'><INPUT class=SmallInput maxLength=20 id='zuiwanfahuodate' name='zuiwanfahuodate' value='<?php echo date("Y-m-d")?>' title=''  onClick="WdatePicker({dateFmt:'yyyy-MM-dd',alwaysUseStartDate:true})">
<img src='<?php echo ROOT_DIR?>general/ERP/Framework/images/menu/calendar.gif' width=16 height=16 title='设置日期' align='absMiddle' border='0' align='absMiddle' style='cursor:pointer' onclick='zuiwanfahuodate.click();'></TD></TR>
</table>
<div align="center">
<br>
<input type=submit accesskey="s" name="submit" value=" 保存 " class=SmallButton  title="快捷键:ALT+s">&nbsp;
<input type=button accesskey="c" name="cancel" value=" 关闭 " class=SmallButton onClick="window.close();" title="快捷键:ALT+c">
</div>
</FORM>