<?php
//######################�������-Ȩ�޽��鲿��##########################
SESSION_START();
require_once("lib.inc.php");
$GLOBAL_SESSION=returnsession();
require_once("systemprivateinc.php");
////CheckSystemPrivate("���ֻ�У԰ϵͳ����-���ֻ�У԰Ȩ��");
//######################�������-Ȩ�޽��鲿��##########################
if($_GET['action']=="")			{
	page_css("�ҵĸ��˲�������");
	print "<FORM name=form1  action=\"?action=DataDeal&pageid=1\" method=post encType=multipart/form-data>";
	table_begin("80%");
	print "<tr class=TableHeader><td colspan=2>&nbsp;�ҵ���������</td></tr>";
	print "<tr class=TableData><td width=40%>&nbsp;SMTP������:</td><td>&nbsp;<INPUT type=text class=SmallInput maxLength=50  name=SMTPServerIP value='".$_SESSION[SMTPServerIP]."'  ></td></tr>";
	print "<tr class=TableData><td width=40%>&nbsp;�ʼ���ַ:</td><td>&nbsp;<INPUT type=text class=SmallInput maxLength=50  name=EmailAddress value='".$_SESSION[EmailAddress]."'  ></td></tr>";
	print "<tr class=TableData><td width=40%>&nbsp;����:</td><td>&nbsp;<INPUT type=password class=SmallInput maxLength=50  name=EmailPassword value='".$_SESSION[EmailPassword]."'  ></td></tr>";	
	print "<tr class=TableHeader><td colspan=2>&nbsp;�ҵ���������</td></tr>";
	print "<tr class=TableData><td width=40%>���:<ul>";
	$sql = "select * from crm_mytable where ģ��λ��='���'  order by ģ���� ASC";
	$rs = $db->Execute($sql);
	$rs_a = $rs->GetArray();
	$leftSelArray=explode(",", $_SESSION['LEFT_MENU']);
	$rightSelArray=explode(",", $_SESSION['RIGHT_MENU']);
	foreach ($rs_a as $row)
	{
		$check="";
		if(in_array($row['���'], $leftSelArray))
			$check="checked";
		if(in_array($row['���'], $rightSelArray))
			$check="checked";
		print "<li style='list-style:none;'><input type=checkbox id='".$row['���']."' name='leftmenu[]' value='".$row['���']."' $check><label for='".$row['���']."'>".$row['��ע']."</label></li>";
	}
	print "</ul></td><td>�Ҳ�:<ul>";
	$sql = "select * from crm_mytable where ģ��λ��='�ұ�'  order by ģ���� ASC";
	$rs = $db->Execute($sql);
	$rs_a = $rs->GetArray();
	foreach ($rs_a as $row)
	{
		$check="";
		if(in_array($row['���'], $leftSelArray))
			$check="checked";
		if(in_array($row['���'], $rightSelArray))
			$check="checked";
		print "<li style='list-style:none;'><input type=checkbox id='".$row['���']."' name='rightmenu[]' value='".$row['���']."' $check><label for='".$row['���']."'>".$row['��ע']."</label></li>";
	}
	print "</ul></td></tr>";
	print_submit("�ύ");
	table_end();
	
	form_end();
	print "<BR>";
	table_end();
	exit;
}

if($_GET['action']=="DataDeal"){
	global $db;
	$leftmenu=join(",", $_POST['leftmenu']);
	$rightmenu=join(",", $_POST['rightmenu']);
	$sql = "update user set SMTPServerIP='".$_POST[SMTPServerIP]."',EmailAddress='".$_POST[EmailAddress]."',EmailPassword='".$_POST[EmailPassword]."',leftmenu='$leftmenu',rightmenu='$rightmenu' where UID=".$_SESSION[LOGIN_UID];
	$db->Execute($sql);

	$_SESSION[SMTPServerIP]= $_POST[SMTPServerIP];
	$_SESSION[EmailAddress]= $_POST[EmailAddress];
	$_SESSION[EmailPassword]= $_POST[EmailPassword];
	$_SESSION['LEFT_MENU']=$leftmenu;
	$_SESSION['RIGHT_MENU']=$rightmenu;
	page_css("�ҵĸ��˲�������");
	print_infor("�޸ĳɹ�!",'trip',"?",'my_config.php',1);
	exit;
}
?>
<?php
/*
	��Ȩ����:֣�ݵ���Ƽ�������޹�˾;
	��ϵ��ʽ:0371-69663266;
	��˾��ַ:����֣�ݾ��ü��������������־�����·ͨ�Ų�ҵ԰��¥����;
	��˾���:֣�ݵ���Ƽ�������޹�˾λ���й��в�����-֣��,������2007��1��,�����ڰѻ����Ƚ���Ϣ����������ͨ�ż���������ѹ�����ҵ��ʵ���ռ���������ҵ�ͻ��Ĺ�����ҵ���»�У�ȫ���ṩ��������֪ʶ��Ȩ�Ľ�����������������������������в�������ĸ�У���������������СѧУ��������ṩ�̡�Ŀǰ�����ж�Ҹ�ְ����ְ��ԺУʹ��ͨ���в��з����Ŀ���������ͷ���;

	�������:����Ƽ�������������Լܹ�ƽ̨,�Լ��������֮����չ���κ��������Ʒ;
	����Э��:���ֻ�У԰��ƷΪ��ҵ���,�������ΪLICENSE��ʽ;����CRMϵͳ��SunshineCRMϵͳΪGPLV3Э�����,GPLV3Э����������뵽�ٶ�����;
	��������:�����ʹ�õ�ADODB��,PHPEXCEL��,SMTARY���ԭ��������,���´���������������;
	*/
?>