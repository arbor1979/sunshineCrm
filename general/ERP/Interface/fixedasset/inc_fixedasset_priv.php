<?php
ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL);

// display warnings and errors
error_reporting(E_WARNING | E_ERROR);

require_once('lib.inc.php');

$GLOBAL_SESSION=returnsession();
require_once("systemprivateinc.php");

CheckSystemPrivate("���ڹ���-�̶��ʲ�-����Ȩ�޹���");


$sql = "select distinct �������� from fixedasset";
$rs = $db->Execute($sql);
$rsX_a = $rs->GetArray();



$TextHeader = "�̶��ʲ��ֲ��Ź���Ȩ������";
$PHP_SELF = "fixedasset_newai.php";


$PHP_SELF_ARRAY = explode('/',$_SERVER['PHP_SELF']);
$PHP_SELF_SELF = array_pop($PHP_SELF_ARRAY);

page_css($TextHeader);


if($_GET['FileNameSELF']!="")						{
	echo " <html> <head> <title>Ȩ�޹���</title>
	<meta http-equiv=\"Content-Type\" content=\"text/html; charset=gb2312\">
	</head>  <body class=\"bodycolor\" topmargin=\"5\">  ";
	$sql = "select * from systemprivateinc where `FILE`='".$_GET['FileName']."' and `MODULE`='".$_GET['ModuleName']."'";
	$rs = $db->Execute($sql);
	$rs_a = $rs->GetArray();
	$PRIV_DEPT  = $rs_a[0]['DEPT_ID'];
	$PRIV_ROLE  = $rs_a[0]['ROLE_ID'];
	$PRIV_USER  = $rs_a[0]['USER_ID'];
	$PRIV_DEPT_NAME  = $rs_a[0]['DEPT_NAME'];
	$PRIV_ROLE_NAME  = $rs_a[0]['ROLE_NAME'];
	$PRIV_USER_NAME  = $rs_a[0]['USER_NAME'];
	echo " <table border=\"0\" width=\"100%\" cellspacing=\"0\" cellpadding=\"3\" class=\"small\">
	<tr>
	<td class=\"small\">
	<img src=\"/images/edit.gif\" WIDTH=\"22\" HEIGHT=\"20\" align=\"absmiddle\">
	<span class=\"big3\"> ָ��Ȩ��</span> ";
	echo "��ģ���Ӳ˵�Ĭ�������������û����ɷ���,�趨�ɷ�����Ա��Χ�Ժ�ֻ�����������Ա�ɷ���";
	echo "
	</td>
	</tr>
	</table>
	<table class=\"TableBlock\" width=\"100%\" align=\"center\">
	<form action=\"?action=DataDeal\"  method=\"post\" name=\"form1\">
	<tr>
	<td nowrap class=\"TableContent\"\" align=\"center\">��Ȩ��Χ��<br>����Ա��</td>
	<td class=\"TableData\">
	<input type=\"hidden\" name=\"COPY_TO_ID\" value=\"";
	echo $PRIV_USER;
	echo "\">
	<textarea cols=40 name=\"COPY_TO_NAME\" rows=6 class=\"BigStatic\" wrap=\"yes\" readonly>";
	echo $PRIV_USER_NAME;
	echo "</textarea>
	&nbsp;
	<input type=\"button\" value=\"�� ��\" class=\"SmallButton\" onClick=\"SelectUser('','COPY_TO_ID','COPY_TO_NAME')\" title=\"ѡ����Ա\" name=\"button\">   &nbsp;
	<input type=\"button\" value=\"�� ��\" class=\"SmallButton\" onClick=\"ClearUser('COPY_TO_ID','COPY_TO_NAME')\" title=\"�����Ա\" name=\"button\">
	</td>
	</tr>
	<tr>
	<td nowrap  class=\"TableControl\" colspan=\"2\" align=\"center\">
	<input type=\"hidden\" name=\"DISK_ID\" value=\"";
	echo $DISK_ID;
	echo "\">

	<input type=\"hidden\" name=\"ModuleName\" value=\"".$_GET['ModuleName']."\"/>
	<input type=\"hidden\" name=\"FileName\" value=\"".$_GET['FileName']."\"/>
	<input type=\"hidden\" name=\"FileNameSELF\" value=\"".$_GET['FileNameSELF']."\"/>
	<input type=\"hidden\" name=\"FIELD_NAME\" value=\"";
	echo $FIELD_NAME;
	echo "\">
	<input type=\"submit\" value=\"ȷ��\" class=\"BigButton\">&nbsp;&nbsp;
	</td>
	</form>
	</table>
	</body>
	</html> ";
	exit;
}


if($_GET['action']=='DataDeal')					{
	$FILE = $_POST['FileName'];
	$MODULE = $_POST['ModuleName'];
	$DEPT_ID = $_POST['TO_ID'];
	$DEPT_NAME = $_POST['TO_NAME'];
	$USER_ID = $_POST['COPY_TO_ID'];
	$USER_NAME = $_POST['COPY_TO_NAME'];
	$ROLE_ID = $_POST['PRIV_ID'];
	$ROLE_NAME = $_POST['PRIV_NAME'];
	$FileNameSELF = $_POST['FileNameSELF'];

	//print_R($_POST);exit;

	$sql = "select MODULE from systemprivateinc where `FILE`='$FILE' and `MODULE`='$MODULE'";
	$rs = $db->Execute($sql);
	$rs_a = $rs->GetArray();
	//print_R($cursor1);exit;
    $MODULE2 = TRIM($rs_a[0]['MODULE']);
	//print $MODULE2;
	if($MODULE2!="")		{
		$sql = "update systemprivateinc set `DEPT_ID`='$DEPT_ID',`USER_ID`='$USER_ID',`ROLE_ID`='$ROLE_ID',`DEPT_NAME`='$DEPT_NAME',`USER_NAME`='$USER_NAME',`ROLE_NAME`='$ROLE_NAME' where `FILE`='$FILE' and `MODULE`='$MODULE'";
	}
	else	{
		$sql = "insert into systemprivateinc values('','$FILE','$MODULE','$DEPT_ID','$DEPT_NAME','$ROLE_ID','$ROLE_NAME','$USER_ID','$USER_NAME')";
	}
	$db->Execute($sql);

	print_infor("���������Ѿ����",'',"location='?'","?");
	exit;

}


table_begin("100%");
print "<tr class=TableHeader><td colspan=5>&nbsp;".$TextHeader."</td></tr>";
print "<tr class=TableHeader><td>&nbsp;��������</td><td>&nbsp;�༭Ȩ��</td><td>&nbsp;������Ա</td></tr>";

for($i=0;$i<sizeof($rsX_a);$i++)			{
	$��������  = $rsX_a[$i]['��������'];
	$sql = "select * from systemprivateinc where MODULE='".$��������."' and FILE='$PHP_SELF'";
	$rs = $db->Execute($sql);
	$rs_a = $rs->GetArray();
	if($��������!="")			{
		print "<tr class=TableData><td>&nbsp;".$��������."</td><td><a href=\"?".base64_encode("FileNameSELF=".$PHP_SELF_SELF."&FileName=".$PHP_SELF."&ModuleName=".$��������."")."\">&nbsp;�༭Ȩ��</a></td>
			<td>&nbsp;".$rs_a[0]['USER_NAME']."</td>
			</tr>";
	}
}
table_end();
print "<BR>";
table_begin("100%");
print "<tr class=TableHeader><td>����˵��:</td></tr>";
print "<tr class=TableData><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ÿ������ָ��һ������Ա,��ô�������Ա������'���ż�����'����˵��й����Ӧ�������ŵ������Ϣ;������������ڷֲ���Ȩ�޹�������.</td></tr>";
table_end();
?>