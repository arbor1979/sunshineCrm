<?php
//######################�������-Ȩ�޽��鲿��##########################
SESSION_START();
require_once("lib.inc.php");
$GLOBAL_SESSION=returnsession();
require_once("systemprivateinc.php");
////CheckSystemPrivate("���ֻ�У԰ϵͳ����-���ֻ�У԰Ȩ��");
//######################�������-Ȩ�޽��鲿��##########################
//print "<script type=\"text/javascript\" language=\"javascript\" src=\"".ROOT_DIR."general/ERP/Enginee/jquery/jquery.js\"></script>";

if($_GET['action']=="")			{

	page_css("�ҵĸ��˲�������");
	print "<SCRIPT language='javascript'>
	function FormCheck()
	{
		if (document.form1.������.value == \"\") {
			alert(\"������û����д\");
			return false;
		}
		if (document.form1.ȷ��������.value == \"\") {
			alert(\"ȷ��������û����д\");
			return false;
		}
		if (document.form1.ȷ��������.value != document.form1.������.value) {
			alert(\"�����������벻һ��\");
			return false;
		}
	}
	</SCRIPT>
	<style>
.strength0
{
 width:30px;
 background:#cccccc;
}
.strength1
{
 width:60px;
 background:#cc0000;
}
.strength2
{
 width:90px; 
 background:#3399FF;
}
.strength3
{
 width:120px;
 background:#CC33FF;
}
.strength4
{
 background:#4dcd00;
 width:150px;
}
#passwordDescription{ color:#ff0000;}
</style>

<script>
function passwordStrength(password)
{
 var desc = new Array();
 desc[0] = \"�ǳ���\";
 desc[1] = \"��\";
 desc[2] = \"һ��\";
 desc[3] = \"��ǿ\";
 desc[4] = \"�ǳ�ǿ\";

 var score   = 0;
 //if password bigger than 6 give 1 point
 if (password.length > 6) score++;
 //if password has both lower and uppercase characters give 1 point 
 if ( ( password.match(/[a-z]/) ) && ( password.match(/[A-Z]/) ) ) score++;
 //if password has at least one number give 1 point
 if (password.match(/\d+/)) score++;
 //if password has at least one special caracther give 1 point
 if ( password.match(/.[!,@,#,$,%,^,&,*,?,_,~,-,(,)]/) ) score++;
 //if password bigger than 12 give another 1 point
 //if (password.length > 12) score++;
  document.getElementById(\"passwordDescription\").innerHTML = desc[score];
  document.getElementById(\"passwordStrength\").className = \"strength\" + score;
}
</script>
	";
	print "<FORM name=form1 onsubmit=\"return FormCheck();\"  action=\"?action=DataDeal&pageid=1\" method=post encType=multipart/form-data>";
	table_begin("80%");
	print "<tr class=TableHeader><td colspan=2>&nbsp;�ҵ������޸�</td></tr>";
	print "<tr class=TableData><td width=40%>&nbsp;ԭ����:</td><td>&nbsp;<INPUT type=password class=SmallInput maxLength=20  name=ԭ���� value=\"\"  >&nbsp;(�������ԭ����)</td></tr>";
	print "<tr class=TableData><td width=40%>&nbsp;������:</td><td>&nbsp;<INPUT type=password class=SmallInput maxLength=20  name=������ value=\"\"  onKeyUp='passwordStrength(this.value)' >&nbsp;(������λ��ĸ������)</td></tr>";
	print "<tr class=TableData><td width=40% align=right>&nbsp;����ǿ��:</td><td>&nbsp;<span style='width:150px;background:#eee;'><span id='passwordStrength' class='strength0'></span></span>&nbsp;<span id='passwordDescription'></span></td></tr>";
	print "<tr class=TableData><td width=40%>&nbsp;ȷ��������:</td><td>&nbsp;<INPUT type=password class=SmallInput maxLength=20  name=ȷ�������� value=\"\"  >&nbsp;(������λ��ĸ������)</td></tr>";
/*
if (CRYPT_STD_DES == 1) { echo "Standard DES: ".crypt("admin")."\n<br />";
} else { echo "Standard DES ��֧��.\n<br />";
} if (CRYPT_EXT_DES == 1) { echo "Extended DES: ".crypt("admin")."\n<br />";
} else { echo "Extended DES ��֧��.\n<br />";
} if (CRYPT_MD5 == 1) { echo "MD5: ".crypt("admin")."\n<br />";
} else { echo "MD5 not supported.\n<br />";
} if (CRYPT_BLOWFISH == 1) { echo "Blowfish: ".crypt("admin");
} else { echo "Blowfish DES ��֧��.";
}*/
	
	print_submit("�ύ");
	table_end();
	form_end();

	print "<BR>";

	//insert into system_log(loginaction,DATE,REMOTE_ADDR,HTTP_USER_AGENT,QUERY_STRING,SCRIPT_NAME,USERID,SQLTEXT)
	$sql = "select * from system_log where loginaction='�û��޸�����' and USERID='".$_SESSION['LOGIN_USER_ID']."'";
	$rs = $db->Execute($sql);
	$rs_a = $rs->GetArray();
	table_begin("80%");
	print "<tr class=TableHeader><td colspan=3>&nbsp;�����޸���־</td></tr>";
	print "<tr class=TableContent><td>&nbsp;�޸�ʱ��</td><td>&nbsp;Զ��IP</td><td>&nbsp;��������</td></tr>";
	for($i=0;$i<sizeof($rs_a);$i++)		{
		print "<tr class=TableData><td>&nbsp;".$rs_a[$i]['DATE']."</td><td>&nbsp;".$rs_a[$i]['REMOTE_ADDR']."</td><td>&nbsp;".$rs_a[$i]['SQLTEXT']."</td></tr>";

	}
	table_end();

print "<BR>";

	/*page_css("�ҵĸ��˲�������");
	print "<SCRIPT>
	function FormCheck()
	{
		if (document.form1.������.value == \"\") {
			alert(\"������û����д\");
			return false;
		}
		if (document.form1.ȷ��������.value == \"\") {
			alert(\"ȷ��������û����д\");
			return false;
		}
		if (document.form1.ȷ��������.value != document.form1.������.value) {
			alert(\"�����������벻һ��\");
			return false;
		}
	}
	</SCRIPT>";
	print "<FORM name=form1 onsubmit=\"return FormCheck();\"  action=\"?action=DataDeal&pageid=1\" method=post encType=multipart/form-data>";
	table_begin("80%");
	print "<tr class=TableHeader><td colspan=2>&nbsp;�ҵ������޸�</td></tr>";
	print "<tr class=TableData><td width=40%>&nbsp;ԭ����:</td><td>&nbsp;<INPUT type=password class=SmallInput maxLength=20  name=ԭ���� value=\"\"  >&nbsp;(�������ԭ����)</td></tr>";
	print "<tr class=TableData><td width=40%>&nbsp;������:</td><td>&nbsp;<INPUT type=password class=SmallInput maxLength=20  name=������ value=\"\"  >&nbsp;(������λ��ĸ������)</td></tr>";
	print "<tr class=TableData><td width=40%>&nbsp;ȷ��������:</td><td>&nbsp;<INPUT type=password class=SmallInput maxLength=20  name=ȷ�������� value=\"\"  >&nbsp;(������λ��ĸ������)</td></tr>";
	
	print_submit("�ύ");
	table_end();
	form_end();

	print "<BR>";

	//insert into system_log(loginaction,DATE,REMOTE_ADDR,HTTP_USER_AGENT,QUERY_STRING,SCRIPT_NAME,USERID,SQLTEXT)
	$sql = "select * from system_log where loginaction='�û��޸�����' and USERID='".$_SESSION['LOGIN_USER_ID']."'";
	$rs = $db->Execute($sql);
	$rs_a = $rs->GetArray();
	table_begin("80%");
	print "<tr class=TableHeader><td colspan=3>&nbsp;�����޸���־</td></tr>";
	print "<tr class=TableContent><td>&nbsp;�޸�ʱ��</td><td>&nbsp;Զ��IP</td><td>&nbsp;��������</td></tr>";
	for($i=0;$i<sizeof($rs_a);$i++)		{
		print "<tr class=TableData><td>&nbsp;".$rs_a[$i]['DATE']."</td><td>&nbsp;".$rs_a[$i]['REMOTE_ADDR']."</td><td>&nbsp;".$rs_a[$i]['SQLTEXT']."</td></tr>";

	}
	table_end();*/

	exit;
}




if($_GET['action']=="DataDeal"){

	page_css("�ҵ������޸�");

	$ԭ���� = $_POST['ԭ����'];
	$������ = $_POST['������'];
	$ȷ�������� = $_POST['ȷ��������'];

	if(strlen($������)<6)		{
		print_infor("������������볤��̫��!",'',"location='?'");
		exit;
	}

	if($������!=$ȷ��������)		{
		print_infor("��������������벻һ��!",'',"location='?'");
		exit;
	}

	$SQL			= "SELECT PASSWORD FROM user WHERE USER_ID = '".$_SESSION['LOGIN_USER_ID']."'";
	$rs				= $db->Execute($SQL);
	$rs_a			= $rs->GetArray();
	$PASSWORDTEXT = $rs_a[0]['PASSWORD'];
	if(crypt($ԭ����,$PASSWORDTEXT) == $PASSWORDTEXT){
		$���������� = crypt($ȷ��������);
		$sql = "update user set PASSWORD='$����������' WHERE USER_ID = '".$_SESSION['LOGIN_USER_ID']."'";
		$db->Execute($sql);
		��¼�û��޸�������Ϊ($_SESSION['LOGIN_USER_ID'],$sql,"�ɹ��޸�����");
		print_infor("���������޸ĳɹ�!",'',"location='?'");
		exit;
	}else{
		��¼�û��޸�������Ϊ($_SESSION['LOGIN_USER_ID'],$sql,"�޸�����ʱ�����������");
		print_infor("�������ԭ�������!",'',"location='?'");
		exit;
	}
}



function ��¼�û��޸�������Ϊ($userid,$sql,$type="�޸ĳɹ�")	{
	global $db;
	$sql = ereg_replace("'",'&#039;',$sql);
	$sql = "insert into system_log(loginaction,DATE,REMOTE_ADDR,HTTP_USER_AGENT,QUERY_STRING,SCRIPT_NAME,USERID,SQLTEXT)
			values('�û��޸�����'
			,'".date("Y-m-d H:i:s")."'
			,'".$_SERVER['REMOTE_ADDR']."'
			,'".$_SERVER['HTTP_USER_AGENT']."'
			,'".$_SERVER['QUERY_STRING']."'
			,'".$_SERVER['SCRIPT_NAME']."'
			,'$userid'
			,'$type'
			);";
	$db->Execute($sql);
}

?>
