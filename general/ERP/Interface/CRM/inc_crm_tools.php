<?php

//######################�������-Ȩ�޽��鲿��##########################
SESSION_START();
require_once("lib.inc.php");
$GLOBAL_SESSION=returnsession();
require_once("systemprivateinc.php");
validateMenuPriv("�ͻ��ƽ�");
//######################�������-Ȩ�޽��鲿��##########################

require_once('lib.inc.php');
require_once('lib.zip.inc.php');

page_css("CRM���߼�");
validateMenuPriv("�ͻ��ƽ�");
$custlistArray=array();
$custNamelistArray=array();
if($_GET['action']=="add_yijiao")								
{
	$custlist=$_GET['custlist'];
	$custlistArray=explode(",", $custlist);
	
	for($i=0;$i<sizeof($custlistArray);$i++)
	{
		
			array_push($custNamelistArray,returntablefield("customer","rowid", $custlistArray[$i], "supplyname"));
		 
			
	}
	
}

if($_GET['action']=="ת���û�A�Ŀͻ����������Ϣ���û�B")								{
	//print_R($_POST);exit;
	$�û�A_ID	= $_POST['�û�A_ID'];
	$�û�B_ID	= $_POST['�û�B_ID'];
	$�û�A		= $_POST['�û�A'];
	$�û�B		= $_POST['�û�B'];
	if($�û�A_ID!=""&&$�û�B_ID!="")			
	{
		if($�û�A_ID==$�û�B_ID)
		{
			print_infor("�û�A���û�B������ͬ!",'forbidden',"location='?'","?",3);
			exit;	
		}
		if(!ifHasRoleUser($�û�A_ID))
		{
			print_infor("��û�в������û���Ȩ��!",'forbidden',"location='?'","?",3);
			exit;
		}
		
		$sql = "select * from customer where sysuser='".$�û�A_ID."'";
		$rsUTF = $db->Execute($sql);
		while(!$rsUTF->EOF)
		{
			$sql = "insert into crm_customer_move (�ͻ�ID,�ϸ��û�,�¸��û�,����Ա,����ʱ��) values(".$rsUTF->fields['ROWID'].",'".$�û�A_ID."','".$�û�B_ID."','".$_SESSION['LOGIN_USER_ID']."',Now())";
			$db->Execute($sql);
			$rsUTF->MoveNext();
		}
		$sql = "update customer set sysuser='$�û�B_ID' where sysuser='$�û�A_ID'";
		$db->Execute($sql);		
		

		print_infor("���Ĳ����Ѿ����,�뷵��!&nbsp;&nbsp;",'',"location='?'","?",3);
		exit;
	}
	else	{
		print_infor("�û�A���û�Bû���趨,�������趨!",'forbidden',"location='?'","?",3);
		exit;
	}
}


if($_GET['action']=="����һ�ͻ�ת��ĳ�û�")								{
	//print_R($_GET);//exit;
	$rowidStr	= $_GET['�ͻ�����_ID'];
	$user_id	= $_GET['�û���_ID'];
	if($rowidStr=='' || $user_id=='')
	{
		print_infor("�ͻ����ƻ�Ŀ���û�û���趨,�������趨!",'forbidden',"location='?'","?",3);
		exit;
	}
	$rowidArray=explode(",",$rowidStr);
	$errlist='';
	$j=0;
	for($i=0;$i<sizeof($rowidArray);$i++)
	{
		$rowid=$rowidArray[$i];
		if($rowid!="")			
		{
			
			$custinfo=returntablefield("customer","rowid",$rowid,"supplyname,sysuser");
			$sysuser=$custinfo['sysuser'];
			if(!ifHasRoleUser($sysuser))
			{
				$errlist.=++$j."��".$custinfo['supplyname']."<br>";
				continue;
			}
			$sql = "update customer set sysuser='$user_id' where rowid='$rowid'";
			$db->Execute($sql);
			//print $sql."<br>";	
			$sql = "insert into crm_customer_move (�ͻ�ID,�ϸ��û�,�¸��û�,����Ա,����ʱ��) values(".$rowid.",'".$sysuser."','".$user_id."','".$_SESSION['LOGIN_USER_ID']."',Now())";
			$db->Execute($sql);
			//print $sql."<br>";
			
			
		}
	}
	if($errlist!='')
	{
		print_infor("���¿ͻ���û��Ȩ�޽���ת�Ʋ���:<br>$errlist",'warning',"location='?'","?",10);
	}
	else 
	{
		print_infor("���Ĳ����Ѿ����,�뷵��!&nbsp;&nbsp;",'',"location='?'","?",3);
	}
	exit;
}

if($_GET['action']=="�ͻ�ת����־")								
{
	//print_R($_GET);//exit;
	$customerid	= $_GET['�ͻ�����1_ID'];
	$customername=returntablefield( "customer", "rowid",$customerid, "supplyname" );
	$begintime	= $_GET['��ʼʱ��'];
	$endtime	= $_GET['��ֹʱ��'];
	if($customerid!="" )			
	{
			
		$sql = "select a.*,b.supplyname as �ͻ����� from crm_customer_move a inner join customer b on a.�ͻ�ID=b.rowid where �ͻ�ID='".$customerid."'";
		if($begintime!="")
			$sql=$sql." and a.����ʱ��>='".$begintime."'";
		if($endtime!="")
			$sql=$sql." and a.����ʱ��<='".$endtime."'";
		
		$rsUTF = $db->Execute($sql);
		$rs_a = $rsUTF->GetArray();
		for($i=0;$i<sizeof($rs_a);$i++)
		{
			$rs_a[$i]['�ϸ��û�']=returntablefield( "user", "user_id", $rs_a[$i]['�ϸ��û�'], "user_name" );
			$rs_a[$i]['�¸��û�']=returntablefield( "user", "user_id", $rs_a[$i]['�¸��û�'], "user_name" );
			$rs_a[$i]['����Ա']=returntablefield( "user", "user_id", $rs_a[$i]['����Ա'], "user_name" );
		}
		
	}
}


?>
<script language = "JavaScript">
function FormCheck()
{
	if (document.form1.�û�A_ID.value == "") {
		alert("�û�Aû���趨��Ա");
		return false;
	}
	if (document.form1.�û�B_ID.value == "") {
		alert("�û�Bû���趨��Ա");
		return false;
	}
}
function FormCheck2()
{
	if (document.form1.�ͻ�����_ID.value == "") {
		alert("����ѡ��һ���ͻ�");
		return false;
	}
	if (document.form1.�û�_ID.value == "") {
		alert("�û�û���趨");
		return false;
	}
	URL = "?action=����һ�ͻ�ת��ĳ�û�&�ͻ�����_ID="+document.form1.�ͻ�����_ID.value+"&�û���_ID="+document.form1.�û�_ID.value;
	window.location = URL;
}
function FormCheck3()
{
	if (document.form1.�ͻ�����1_ID.value == "") {
		alert("�ͻ�����û���趨");
		return false;
	}
	if(form1.��ʼʱ��.value!='' && !isDate(form1.��ʼʱ��))
		return false;
	if(form1.��ֹʱ��.value!='' && !isDate(form1.��ֹʱ��))
		return false;
			
	URL = "?action=�ͻ�ת����־&�ͻ�����1_ID="+document.form1.�ͻ�����1_ID.value+"&��ʼʱ��="+document.form1.��ʼʱ��.value+"&��ֹʱ��="+document.form1.��ֹʱ��.value;
	window.location = URL;
}
</script>

<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<table border="0" width="80%" align=center cellspacing="0" cellpadding="3" class="TableBlock">
  <tr  class=TableHeader>
    <td colspan="6" height=28>&nbsp;<img src="<?php echo ROOT_DIR?>images/sys_config.gif" align="absmiddle" > ĳ�û��µ����пͻ��ƽ�</td>
  </tr>
 <tr class="TableData">
 <td colspan="6" align=center height=42>
 <FORM name=form1 onsubmit="return FormCheck();" action="?action=ת���û�A�Ŀͻ����������Ϣ���û�B&pageid=1" method=post encType=multipart/form-data>
	ת���û�A:
	<input type="hidden" name="�û�A_ID" value="">
	<input type="text" name="�û�A" value="" readonly class="SmallStatic" size="10">
	<a href="javascript:;" class="orgAdd" onClick="SelectTeacherSingle('1','�û�A_ID', '�û�A')">ѡ��</a>
	�Ŀͻ����������Ϣ��:
	�û�B
	<input type="hidden" name="�û�B_ID" value="">
	<input type="text" name="�û�B" value="" readonly class="SmallStatic" size="10">
	<a href="javascript:;" class="orgAdd" onClick="SelectTeacherSingle('','�û�B_ID', '�û�B')">ѡ��</a>
    <input type="submit"  value="�ύ" class="BigButton" title="�ύ">
 </td>
</tr>
</table>

<BR>
<table border="0" width="80%" align=center cellspacing="0" cellpadding="3" class="TableBlock">
  <tr  class=TableHeader>
    <td colspan="6" height=28>&nbsp;<img src="<?php echo ROOT_DIR?>images/sys_config.gif" align="absmiddle" > ѡ��ͻ��ƽ�</td>
  </tr>
 <tr class="TableData">
 <td colspan="6" align=center height=42>
	ת�ƿͻ�����:
	<input type="hidden" name="�ͻ�����_ID" value="<?php echo implode(",", $custlistArray)?>">
	<textarea name="�ͻ�����"  readonly class="SmallStatic" wrap=yes rows=5 cols=40><?php echo implode(",", $custNamelistArray)?></TEXTAREA>
	<a href="javascript:;" class="orgAdd" onClick="SelectAllInforSingle('../../Enginee/Module/kehu_select_multi/index.php','','�ͻ�����', '�ͻ�����_ID');">ѡ��</a>
	�Ŀͻ����������Ϣ��:
	�û�
	<input type="hidden" name="�û�_ID" value="">
	<input type="text" name="�û�" value="" readonly class="SmallStatic" size="10">
	<a href="javascript:;" class="orgAdd" onClick="SelectTeacherSingle('','�û�_ID', '�û�')">ѡ��</a>
    <input type="Button"  value="�ύ" class="BigButton" OnClick='FormCheck2();' title="�ύ">

 </td>
</tr>
</table>

<BR>
<table border="0" width="80%" align=center cellspacing="0" cellpadding="3" class="TableBlock">
  <tr  class=TableHeader>
    <td colspan="6" height=28>&nbsp;<img src="<?php echo ROOT_DIR?>images/sys_config.gif" align="absmiddle" > �ͻ�ת����־</td>
  </tr>
 <tr class="TableData">
 <td colspan="6" align=center height=42 class=TableData>
	�ͻ�����:
	<input type="hidden" name="�ͻ�����1_ID" value="<?php echo $customerid?>">
	<input type="text" name="�ͻ�����1" value="<?php echo $customername?>" readonly class="SmallStatic" size="25">
	<a href="javascript:;" class="orgAdd" onClick="SelectAllInforSingle('../../Enginee/Module/kehu_select_single/index.php','','�ͻ�����1', '�ͻ�����1_ID');">ѡ��</a>
	��ʼʱ�䣺
	<INPUT class=SmallInput maxLength=20 size=15 name="��ʼʱ��" value="<?php echo $begintime?>" title='' onkeydown="if(event.keyCode==13)event.keyCode=9" >
<input type="button"  title=''  value="ѡ��" class="SmallButton" onclick="td_calendar('../../Framework/sms_index/calendar_begin.php?datetime=��ʼʱ��');" title="ѡ��" name="button">
	��ֹʱ�䣺
	<INPUT class=SmallInput maxLength=20 size=15 name="��ֹʱ��" value="<?php echo $endtime?>" title='' onkeydown="if(event.keyCode==13)event.keyCode=9" >
<input type="button"  title=''  value="ѡ��" class="SmallButton" onclick="td_calendar('../../Framework/sms_index/calendar_begin.php?datetime=��ֹʱ��');" title="ѡ��" name="button">
&nbsp;<input type="Button"  value="����" class="BigButton" OnClick='FormCheck3();' title="����">
	</FORM>
 </td>
</tr>
</table>
<?php 
if($customerid!="")
{
?>
	<table border="0" width="80%" align=center cellspacing="0" cellpadding="3" class="TableBlock">
	<tr  class=TableHeader>
    <td align=center>�ͻ�����</td>
    <td align=center>ԭ������</td>
    <td align=center>��������</td>
    <td align=center>������</td>
    <td align=center>����ʱ��</td>
    </tr>
<?php
	for($i=0;$i<sizeof($rs_a);$i++)
	{
		print "<tr class=TableData>";
		print "<td align=center>".$rs_a[$i]['�ͻ�����']."</td>";
		print "<td align=center>".$rs_a[$i]['�ϸ��û�']."</td>";
		print "<td align=center>".$rs_a[$i]['�¸��û�']."</td>";
		print "<td align=center>".$rs_a[$i]['����Ա']."</td>";
		print "<td align=center>".$rs_a[$i]['����ʱ��']."</td></tr>";
	}
?>
	</table>
<?php
}
?>
