<?php
ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL);

// display warnings and errors
error_reporting(E_WARNING | E_ERROR);

//header("Content-Type:text/html;charset=gbk");
//######################�������-Ȩ�޽��鲿��##########################
require_once("lib.inc.php");

$GLOBAL_SESSION=returnsession();
$SYSTEM_PRIV_STOP = 1;

	require_once("systemprivateinc.php");
	//CheckSystemPrivate("������Դ-��������-���ż�����");
//######################�������-Ȩ�޽��鲿��##########################

page_css("������Ա�򿨿���ͳ��");
$DateMonth = $_GET['Month'];

//print_R($_GET);
//���ݲ鿴

if($_GET['ѧ������']!="")	$ѧ������ = $_GET['ѧ������'];
	else					$ѧ������ = returntablefield("edu_xueqiexec","��ǰѧ��",'1',"ѧ������");
    $ѧ�ڳ�ʼֵ = $ѧ������;

//��ι��˲���,����ֶα�����Ϊ���ط�������--��ʼ
$LOGIN_USER_NAME = $_SESSION['LOGIN_USER_NAME'];
$sql = "select ������� from edu_xingzheng_banci where ��ι���һ='$LOGIN_USER_NAME' or ��ι����='$LOGIN_USER_NAME'";
$rs = $db->CacheExecute(150,$sql);
$rs_a = $rs->GetArray();
$������� = array();
for($i=0;$i<sizeof($rs_a);$i++)						{
	$Element = $rs_a[$i];
	$�������[]  = $Element['�������'];
}
$�������TEXT = "'".join("','",$�������)."'";
//��ι��˲���,����ֶα�����Ϊ���ط�������--����



if($_GET['action']=="StaticAll"&&($_GET['Month']!=""||$_GET['��ʼ��']!=""))			{

if($_GET['Month']!="")			{
	$DateMonth = $_GET['Month'];
	$DateMonthArray = explode('-',$DateMonth);
	$�������� = date("t",mktime(1,1,1,$DateMonthArray[1],1,$DateMonthArray[0]));
	$��ʼʱ�� = date("Y-m-d",mktime(1,1,1,$DateMonthArray[1],1,$DateMonthArray[0]));
	$����ʱ�� = date("Y-m-d",mktime(1,1,1,$DateMonthArray[1],$��������,$DateMonthArray[0]));
}
else							{
	//print_R($_GET);
	$sql = "select ��ʼʱ��,ѧ������ from edu_xueqiexec where ѧ������='$ѧ������' order by ��ˮ�� desc limit 1";
	$rs = $db->CacheExecute(150,$sql);
	$rs_a = $rs->GetArray();
	$��ʼʱ�� = $rs_a[0]['��ʼʱ��'];
	$ѧ������ = $rs_a[0]['ѧ������'];
	$��ʼʱ��Array = explode('-',$��ʼʱ��);
	$w = date('w',mktime(1,1,1,$��ʼʱ��Array[1],$��ʼʱ��Array[2],$��ʼʱ��Array[0]));

	if($_GET['��ʼ��']>$_GET['������']) $_GET['������'] = $_GET['��ʼ��'];

	$�ܴ� = $_GET['��ʼ��'];
	$������ = ($�ܴ�-1)*7;
	$��ʼ�ܿ�ʼ�� = date('Y-m-d',mktime(1,1,1,$��ʼʱ��Array[1],$��ʼʱ��Array[2]-$w+1+$������,$��ʼʱ��Array[0]));
	$��ʼ�ܽ����� = date('Y-m-d',mktime(1,1,1,$��ʼʱ��Array[1],$��ʼʱ��Array[2]-$w+1+6+$������,$��ʼʱ��Array[0]));
	if($��ʼ�ܿ�ʼ��<$��ʼʱ��) $��ʼ�ܿ�ʼ�� = $��ʼʱ��;

	$�ܴ� = $_GET['������'];
	$������ = ($�ܴ�-1)*7;
	$�����ܿ�ʼ�� = date('Y-m-d',mktime(1,1,1,$��ʼʱ��Array[1],$��ʼʱ��Array[2]-$w+1+$������,$��ʼʱ��Array[0]));
	$�����ܽ����� = date('Y-m-d',mktime(1,1,1,$��ʼʱ��Array[1],$��ʼʱ��Array[2]-$w+1+6+$������,$��ʼʱ��Array[0]));

	$��ʼʱ�� = $��ʼ�ܿ�ʼ��;
	$����ʱ�� = $�����ܽ�����;
}
print "
<table width=100% align=center class=TableBlock>
<tr class=TableHeader>
<td colspan=7>������Ա�򿨿��ڹ���(ͳ��ʱ��:".$��ʼʱ��." �� ".$����ʱ��.")<input type=\"button\" value=\"����\" class=\"SmallButton\" onClick=\"history.back();\"></td>
</tr>
<tr class=TableHeader>
<td nowrap>������Ա����</td><td nowrap>���迼�ڴ���</td>
<td nowrap>�ϰ��ѿ���</td><td nowrap>�ϰ࿼��ȱ</td>
<td nowrap>�°��ѿ���</td><td nowrap>�°࿼��ȱ</td>
<td colspan=1>���������ϸ</td>
</tr>
";

//where ��Ա='".$_SESSION['LOGIN_USER_NAME']."'
$sql = "select distinct ��Ա from edu_xingzheng_kaoqinmingxi where ѧ�� ='$ѧ������'  order by ��Ա";
$rs = $db->CacheExecute(150,$sql);
$rs_a = $rs->GetArray();	//print_R($rs_a);

for($i=0;$i<sizeof($rs_a);$i++)						{
	$Element = $rs_a[$i];
	$��ʵ����  = $Element['��Ա'];
	$TextX = returnKaoQinMingXi($��ʵ����,$��ʼʱ��,$����ʱ��);
	print "<tr class=TableData>
	<td colspan=1>$��ʵ����</td>
	<td colspan=1><a href=\"?".base64_encode("action=StaticSingleTeacher&��ʼʱ��=$��ʼʱ��&����ʱ��=$����ʱ��&��ʵ����=$��ʵ����&TYPE=���迼�ڴ���")."\" target=_blank>".$TextX['���迼�ڴ���']."</a></td>
	<td colspan=1><a href=\"?".base64_encode("action=StaticSingleTeacher&��ʼʱ��=$��ʼʱ��&����ʱ��=$����ʱ��&��ʵ����=$��ʵ����&TYPE=�ϰ��ѿ���,���ڲ���")."\" target=_blank><font color=red>".$TextX['�ϰ��ѿ���']."</font></a></td>
	<td colspan=1><a href=\"?".base64_encode("action=StaticSingleTeacher&��ʼʱ��=$��ʼʱ��&����ʱ��=$����ʱ��&��ʵ����=$��ʵ����&TYPE=�ϰ࿼��ȱ")."\" target=_blank>".$TextX['�ϰ࿼��ȱ']."</a></td>
	<td colspan=1><a href=\"?".base64_encode("action=StaticSingleTeacher&��ʼʱ��=$��ʼʱ��&����ʱ��=$����ʱ��&��ʵ����=$��ʵ����&TYPE=�°��ѿ���,���ڲ���")."\" target=_blank><font color=red>".$TextX['�°��ѿ���']."</font></a></td>
	<td colspan=1><a href=\"?".base64_encode("action=StaticSingleTeacher&��ʼʱ��=$��ʼʱ��&����ʱ��=$����ʱ��&��ʵ����=$��ʵ����&TYPE=�°࿼��ȱ")."\" target=_blank>".$TextX['�°࿼��ȱ']."</a></td>
	<td colspan=1><a href=\"?".base64_encode("action=StaticSingleTeacher&��ʼʱ��=$��ʼʱ��&����ʱ��=$����ʱ��&��ʵ����=$��ʵ����&TYPE=���迼�ڴ���")."\" target=_blank>���������ϸ</a></td>
	</tr>";

}

exit;
}

if($_GET['action']=="StaticAllFenLei"&&($_GET['Month']!=""||$_GET['��ʼ��']!=""))			{

if($_GET['Month']!="")			{
	$DateMonth = $_GET['Month'];
	$DateMonthArray = explode('-',$DateMonth);
	$�������� = date("t",mktime(1,1,1,$DateMonthArray[1],1,$DateMonthArray[0]));
	$��ʼʱ�� = date("Y-m-d",mktime(1,1,1,$DateMonthArray[1],1,$DateMonthArray[0]));
	$����ʱ�� = date("Y-m-d",mktime(1,1,1,$DateMonthArray[1],$��������,$DateMonthArray[0]));
}
else	{
	//print_R($_GET);
	$sql = "select ��ʼʱ��,ѧ������ from edu_xueqiexec where ѧ������='$ѧ������' order by ��ˮ�� desc limit 1";
	$rs = $db->CacheExecute(150,$sql);
	$rs_a = $rs->GetArray();
	$��ʼʱ�� = $rs_a[0]['��ʼʱ��'];
	$ѧ������ = $rs_a[0]['ѧ������'];
	$��ʼʱ��Array = explode('-',$��ʼʱ��);
	$w = date('w',mktime(1,1,1,$��ʼʱ��Array[1],$��ʼʱ��Array[2],$��ʼʱ��Array[0]));

	if($_GET['��ʼ��']>$_GET['������']) $_GET['������'] = $_GET['��ʼ��'];

	$�ܴ� = $_GET['��ʼ��'];
	$������ = ($�ܴ�-1)*7;
	$��ʼ�ܿ�ʼ�� = date('Y-m-d',mktime(1,1,1,$��ʼʱ��Array[1],$��ʼʱ��Array[2]-$w+1+$������,$��ʼʱ��Array[0]));
	$��ʼ�ܽ����� = date('Y-m-d',mktime(1,1,1,$��ʼʱ��Array[1],$��ʼʱ��Array[2]-$w+1+6+$������,$��ʼʱ��Array[0]));
	if($��ʼ�ܿ�ʼ��<$��ʼʱ��) $��ʼ�ܿ�ʼ�� = $��ʼʱ��;

	$�ܴ� = $_GET['������'];
	$������ = ($�ܴ�-1)*7;
	$�����ܿ�ʼ�� = date('Y-m-d',mktime(1,1,1,$��ʼʱ��Array[1],$��ʼʱ��Array[2]-$w+1+$������,$��ʼʱ��Array[0]));
	$�����ܽ����� = date('Y-m-d',mktime(1,1,1,$��ʼʱ��Array[1],$��ʼʱ��Array[2]-$w+1+6+$������,$��ʼʱ��Array[0]));

	$��ʼʱ�� = $��ʼ�ܿ�ʼ��;
	$����ʱ�� = $�����ܽ�����;
}
print "
<table width=100% align=center class=TableBlock>
<tr class=TableHeader>
<td colspan=11>������Ա���ڹ���(ͳ��ʱ��:".$��ʼʱ��." �� ".$����ʱ��.")<input type=\"button\" value=\"����\" class=\"SmallButton\" onClick=\"history.back();\"></td>
</tr>
<tr class=TableHeader>
<td nowrap>������Ա����</td>
<td nowrap>������</td>
<td nowrap>�Ӱ��¼</td>
<td nowrap>���ݼ�¼</td>
<td nowrap>���ݼ�¼</td>
<td nowrap>�����¼</td>
<td nowrap>��������</td>
<td nowrap>������ʵ</td>
<td nowrap>�໥��������</td>
<td nowrap>�໥������ʵ</td>
<td nowrap>���ڲ���</td>
</tr>
";
$sql = "select distinct ��Ա from edu_xingzheng_kaoqinmingxi  where ��Ա='".$_SESSION['LOGIN_USER_NAME']."' and ѧ�� ='$ѧ������' order by ��Ա";
$rs = $db->CacheExecute(150,$sql);
$rs_a = $rs->GetArray();	//print_R($rs_a);
$Text = returnXingZhengKaoQin($��ʼʱ��,$����ʱ��);
//print_R($Text);
for($i=0;$i<sizeof($rs_a);$i++)						{
	$Element = $rs_a[$i];
	$��ʵ����  = $Element['��Ա'];
	$TextX = $Text[$��ʵ����];

	print "<tr class=TableData>
		<td colspan=1>$��ʵ����</td>
		<td colspan=1>
		<a href=\"edu_xingzheng_qingjia_newai.php?action=init_customer&��ʼʱ��=$��ʼʱ��&����ʱ��=$����ʱ��&��Ա=$��ʵ����&���״̬=1\" target=_blank>".$TextX['������']."</a></td>
		<td colspan=1>
		<a href=\"edu_xingzheng_jiabanbuxiu_newai.php?action=init_customer&�Ӱ࿪ʼʱ��=$��ʼʱ��&�Ӱ����ʱ��=$����ʱ��&��Ա=$��ʵ����&�Ӱ����״̬=1\" target=_blank><font color=red>".$TextX['�Ӱ��¼']."</font></a></td>
		<td colspan=1>
		<a href=\"edu_xingzheng_jiabanbuxiu_newai.php?action=init_customer&���ݿ�ʼʱ��=$��ʼʱ��&���ݽ���ʱ��=$����ʱ��&��Ա=$��ʵ����&�������״̬=1\" target=_blank>".$TextX['���ݼ�¼']."</a></td>
		<td colspan=1>
		<a href=\"edu_xingzheng_tiaoxiububan_newai.php?action=init_customer&���ݿ�ʼʱ��=$��ʼʱ��&���ݽ���ʱ��=$����ʱ��&��Ա=$��ʵ����&�������״̬=1\" target=_blank><font color=red>".$TextX['���ݼ�¼']."</font></a></td>
		<td colspan=1>
		<a href=\"edu_xingzheng_tiaoxiububan_newai.php?action=init_customer&���࿪ʼʱ��=$��ʼʱ��&�������ʱ��=$����ʱ��&��Ա=$��ʵ����&�������״̬=1\" target=_blank>".$TextX['�����¼']."</a></td>
		<td colspan=1>
		<a href=\"edu_xingzheng_tiaoban_newai.php?action=init_customer&ԭ�ϰ࿪ʼʱ��=$��ʼʱ��&ԭ�ϰ����ʱ��=$����ʱ��&��Ա=$��ʵ����&���״̬=1\" target=_blank>".$TextX['��������']."</a></td>
		<td colspan=1>
		<a href=\"edu_xingzheng_tiaoban_newai.php?action=init_customer&���ϰ࿪ʼʱ��=$��ʼʱ��&���ϰ����ʱ��=$����ʱ��&��Ա=$��ʵ����&���״̬=1\" target=_blank>".$TextX['������ʵ']."</a></td>
		<td colspan=1>
		<a href=\"edu_xingzheng_tiaobanxianghu_newai.php?action=init_customer&ԭ�ϰ࿪ʼʱ��=$��ʼʱ��&ԭ�ϰ����ʱ��=$����ʱ��&ԭ��Ա=$��ʵ����&���״̬=1\" target=_blank>".$TextX['�໥��������']."</a></td>
		<td colspan=1>
		<a href=\"edu_xingzheng_tiaobanxianghu_newai.php?action=init_customer&���ϰ࿪ʼʱ��=$��ʼʱ��&���ϰ����ʱ��=$����ʱ��&����Ա=$��ʵ����&���״̬=1\" target=_blank>".$TextX['�໥������ʵ']."</a></td>
		<td colspan=1>
		<a href=\"edu_xingzheng_kaoqinbudeng_newai.php?action=init_customer&��ʼʱ��=$��ʼʱ��&����ʱ��=$����ʱ��&��Ա=$��ʵ����&���״̬=1\" target=_blank>".$TextX['���ڲ���']."</a></td>
		</tr>";
}

exit;
}

//print_R($_GET);
//������ϸ
if($_GET['action']=="StaticSingleTeacher"&&$_GET['��ʼʱ��']!=""&&$_GET['����ʱ��']!=""&&$_GET['��ʵ����']!="")			{
$DateMonth = $_GET['Month'];
$��ʵ���� = $_GET['��ʵ����'];
$��ʼʱ�� = $_GET['��ʼʱ��'];
$����ʱ�� = $_GET['����ʱ��'];
$TYPE = $_GET['TYPE'];
$Column = returntablecolumn("edu_xingzheng_kaoqinmingxi");

//$DateMonthArray = explode('-',$DateMonth);
//$�������� = date("t",mktime(1,1,1,$DateMonthArray[1],1,$DateMonthArray[0]));
//$��ʼʱ�� = date("Y-m-d",mktime(1,1,1,$DateMonthArray[1],1,$DateMonthArray[0]));
//$����ʱ�� = date("Y-m-d",mktime(1,1,1,$DateMonthArray[1],$��������,$DateMonthArray[0]));


print "
<table width=100% align=center class=TableBlock>
<tr class=TableHeader>
<td colspan=".sizeof($Column).">������Ա�򿨿��ڹ���(ͳ��ʱ��:".$��ʼʱ��." �� ".$����ʱ��." ������Ա����:$��ʵ���� ͳ����:$TYPE)&nbsp;<input type=button value=\"�� ��\" class=\"SmallButton\" onclick=\"window.close();\"></td>
</tr>
<tr class=TableHeader>";

//array_shift($Column);
for($i=0;$i<sizeof($Column);$i++)						{
	print "<td nowrap>".$Column[$i]."</td>";
}
print "</tr>";

//print_R($Column);
switch($TYPE)		{
	case '���迼�ڴ���':
		$AddSql = "";
		break;
	case '�ϰ��ѿ���':
		$AddSql = " and (�ϰ࿼��״̬ = '����ˢ��' or �ϰ࿼��״̬ = '�ϰ�ٵ�')";
		break;
	case '�ϰ࿼��ȱ':
		$AddSql = " and (�ϰ࿼��״̬ = '' or �ϰ࿼��״̬ = '�ϰ�ȱ��' or �ϰ࿼��״̬ = '����')";
		break;
	case '�°��ѿ���':
		$AddSql = " and (�°࿼��״̬ = '����ˢ��' or �°࿼��״̬ = '�°�����' )";
		break;
	case '�°࿼��ȱ':
		$AddSql = " and (�°࿼��״̬ = '' or �°࿼��״̬ = '�°�ȱ��' or �°࿼��״̬ = '����')";
		break;
}
$sql = "select * from edu_xingzheng_kaoqinmingxi where ��Ա='$��ʵ����' and ���� >='$��ʼʱ��' and ����<='$����ʱ��' $AddSql and ��� in ($�������TEXT) order by ����,���";
$rs = $db->CacheExecute(150,$sql);
$rs_a = $rs->GetArray();
//print_R($sql);
for($i=0;$i<sizeof($rs_a);$i++)						{
	print "<tr class=TableData>";
	for($ii=0;$ii<sizeof($Column);$ii++)		{
		$ColumnName = $Column[$ii];
		if($ColumnName=="���") $ColumnValue = $i+1;
		//else if($ColumnName=="�ϰ࿼��״̬")	$rs_a[$i][$ColumnName]=="1"?$ColumnValue='��':'';
		//else if($ColumnName=="�°࿼��״̬")	$rs_a[$i][$ColumnName]=="1"?$ColumnValue='��':'';
		else					$ColumnValue = $rs_a[$i][$ColumnName];
		print "<td nowrap>".$ColumnValue."</td>";
	}
	print "</tr>";
}
print "</table>";

exit;
}

//ͳ����
if($_GET['action']=="init_default"||$_GET['action']=="")					{

	$html_etc = returnsystemlang('edu_xingzheng_kaoqinmingxi');

	page_css("������Ա���ڰ��·ݲ�ѯ");

	//�˶δ�����ǰΪ�ܴ�ͳ��֮ǰ,�·�ͳ��֮��,����Ҫ�õ�ѧ������,������ǰ����
	$sql = "select ��ʼʱ��,ѧ������ from edu_xueqiexec where ѧ������='$ѧ������'  order by ��ˮ�� desc limit 1";
	$rs = $db->CacheExecute(150,$sql);
	$rs_a = $rs->GetArray();
	$��ʼʱ�� = $rs_a[0]['��ʼʱ��'];
	$ѧ������ = $rs_a[0]['ѧ������'];
	$��ʼʱ��Array = explode('-',$��ʼʱ��);

	//��ǰѧ��:$ѧ������
	print "
		<table border=0 class=TableBlock width=100% >
		<tr class=TableHeader><td valign=bottom align=left>������Ա���ڹ��� ".$html_etc['edu_xingzheng_kaoqinmingxi']['ѧ��'].":";

		$sql="select ѧ������ from edu_xueqiexec";
		$rs=$db->Execute($sql);//print_R($rs->GetArray());
		$ѧ���ı� .= "&nbsp;&nbsp;<select class=\"SmallSelect\" name=\"CurXueQi\" onChange=\"var jmpURL='?XX=XX&ѧ������=' + this.options[this.selectedIndex].value ; if(jmpURL!='') {window.location=jmpURL;} else {this.selectedIndex=0 ;}\"
		>\n";
		while(!$rs->EOF)			{
		if($ѧ�ڳ�ʼֵ==$rs->fields['ѧ������'])		$temp='selected';
		$ѧ���ı� .= "<option value=\"".$rs->fields['ѧ������']."\" $temp>".$rs->fields['ѧ������']."</option>\n";
		$temp='';
		$rs->MoveNext();
		}
		$ѧ���ı� .= "</select>\n";
		print $ѧ���ı�;

		print "</td></tr>
		<tr class=TableData><td valign=bottom align=left>
		����Ϊÿ���µ����ݻ���<BR>";
		//ɾ����������
		//$sql = "delete FROM `edu_xingzheng_kaoqinmingxi` where ����='0000-00-00'";
		//$db->CacheExecute(150,$sql);
		$sql = "SELECT  distinct date_format( ����, '%Y-%m' ) AS DateMonth FROM `edu_xingzheng_kaoqinmingxi` where ��� in ($�������TEXT) and ѧ�� ='$ѧ������' ";
		$rs = $db->CacheExecute(150,$sql);
		$rs_a = $rs->GetArray();
		for($i=0;$i<sizeof($rs_a);$i++)		{
			$DateMonth = $rs_a[$i]['DateMonth'];
			$DateMonthArray = explode('-',$DateMonth);
			$�������� = date("t",mktime(1,1,1,$DateMonthArray[1],1,$DateMonthArray[0]));
			$��ʼʱ�� = date("Y-m-d",mktime(1,1,1,$DateMonthArray[1],1,$DateMonthArray[0]));
			$����ʱ�� = date("Y-m-d",mktime(1,1,1,$DateMonthArray[1],$��������,$DateMonthArray[0]));

			$��Ա = $_SESSION['LOGIN_USER_NAME'];
			$sql = "select count(*) as NUM from edu_xingzheng_kaoqinmingxi where ���� >='$��ʼʱ��' and ����<='$����ʱ��' and ��Ա='$��Ա' and ��� in ($�������TEXT) ";
			$rs = $db->CacheExecute(150,$sql);
			$rsX_a = $rs->GetArray();
			$Number = $rsX_a[0]['NUM'];

			$sql = "select count(*) as NUM from edu_xingzheng_kaoqinmingxi where ���� >='$��ʼʱ��' and ����<='$����ʱ��' and (�ϰ࿼��״̬!='�ϰ�ȱ��' or �°࿼��״̬!='�°�ȱ��') and ��Ա='$��Ա' and ��� in ($�������TEXT) ";
			$rs = $db->CacheExecute(150,$sql);
			$rsX_a = $rs->GetArray();
			$Number2 = $rsX_a[0]['NUM'];

			print "".$DateMonth." &nbsp;
			[<a href=\"?".base64_encode("action=StaticAll&Month=$DateMonth")."\" >���¿�����ϸ����</a>]

			[<a href=\"?".base64_encode("action=StaticAllFenLei&Month=$DateMonth")."\" >���¿���ͳ������</a>]

			[��Ҫ����".$Number."��,�����".$Number2."��]";
			print "<BR>";

		}
		print "</td></tr></table><BR>";

		if($Target=="") $Target = date("Y-m-d");
		$TargetArray = explode('-',$Target);
		$W1 = date('W',mktime(1,1,1,$��ʼʱ��Array[1],$��ʼʱ��Array[2],$��ʼʱ��Array[0]));
		$W2 = date('W',mktime(1,1,1,$TargetArray[1],$TargetArray[2],$TargetArray[0]));
		$W = $W2-$W1+1;

		$sql = "select MAX(�ܴ�) as ����ܴ� from edu_xingzheng_kaoqinmingxi where ѧ�� ='$ѧ������' and ��� in ($�������TEXT) ";
		$rs = $db->CacheExecute(150,$sql);
		$rsX_a = $rs->GetArray();
		$����ܴ� = $rsX_a[0]['����ܴ�'];

		//��ǰѧ��:$ѧ������
		print "
		<table border=0 class=TableBlock width=100% >
		<tr class=TableHeader><td valign=bottom align=left>������Ա���ڰ��ܴβ�ѯ ".$html_etc['edu_xingzheng_kaoqinmingxi']['ѧ��'].":";
		
		$sql="select ѧ������ from edu_xueqiexec";
		$rs=$db->Execute($sql);//print_R($rs->GetArray());
		$ѧ���ı�xx .= "&nbsp;&nbsp;<select class=\"SmallSelect\" name=\"CurXueQi\" onChange=\"var jmpURL='?XX=XX&ѧ������=' + this.options[this.selectedIndex].value ; if(jmpURL!='') {window.location=jmpURL;} else {this.selectedIndex=0 ;}\"
		>\n";
		while(!$rs->EOF)			{
		if($ѧ�ڳ�ʼֵ==$rs->fields['ѧ������'])		$temp='selected';
		$ѧ���ı�xx .= "<option value=\"".$rs->fields['ѧ������']."\" $temp>".$rs->fields['ѧ������']."</option>\n";
		$temp='';
		$rs->MoveNext();
		}
		$ѧ���ı�xx .= "</select>\n";
		print $ѧ���ı�xx;

		print "</td></tr>
		<tr class=TableData><td valign=bottom align=left>
		<BR>";
		print "<form name=form1 method=get>";
		print "&nbsp;&nbsp;��ʼ��:&nbsp;&nbsp;<select name=��ʼ�� >";
		for($i=1;$i<=$����ܴ�;$i++)		{
			print "<option value='$i'>$i</option>";
		}
		print "</select>";
		print "&nbsp;&nbsp;������:&nbsp;&nbsp;<select name=������ >";
		for($i=1;$i<=$����ܴ�;$i++)		{
			print "<option value='$i'>$i</option>";
		}
		print "</select>";
		print "<input type=hidden name='action' value='StaticAll'/>";
		print "&nbsp;&nbsp;<input type=submit class=SmallButton name=�ύ value='��ѯ'/><BR><BR>";
		print "</form>";
		print "</td></tr></table><BR>";


}



function returnXingZhengKaoQin($��ʼʱ��='',$����ʱ��='')		{
	global $db,$�������TEXT;

	//������
	$sql = "select COUNT(*) AS ������,��Ա from edu_xingzheng_qingjia where ʱ�� >='$��ʼʱ��' and ʱ��<='$����ʱ��'  and ���״̬='1' group by ��Ա";
	$rs = $db->CacheExecute(150,$sql);
	$rs_a = $rs->GetArray();
	$��Ա = $rs_a[0]['��Ա'];
	$Text[$��Ա]['������'] = $rs_a[0]['������'];

	//�Ӱ��¼
	$sql = "select COUNT(*) AS �Ӱ��¼,��Ա from edu_xingzheng_jiabanbuxiu where �Ӱ�ʱ�� >='$��ʼʱ��' and �Ӱ�ʱ��<='$����ʱ��'  and �Ӱ����״̬ = '1' group by ��Ա";
	$rs = $db->CacheExecute(150,$sql);
	$rs_a = $rs->GetArray();
	$��Ա = $rs_a[0]['��Ա'];
	$Text[$��Ա]['�Ӱ��¼'] = $rs_a[0]['�Ӱ��¼'];

	//���ݼ�¼
	$sql = "select COUNT(*) AS ���ݼ�¼,��Ա from edu_xingzheng_tiaoxiububan where ����ʱ�� >='$��ʼʱ��' and ����ʱ��<='$����ʱ��'  and (�������״̬ = '1') group by ��Ա";
	$rs = $db->CacheExecute(150,$sql);
	$rs_a = $rs->GetArray();
	$��Ա = $rs_a[0]['��Ա'];
	$Text[$��Ա]['���ݼ�¼'] = $rs_a[0]['���ݼ�¼'];

	//�����¼
	$sql = "select COUNT(*) AS �����¼,��Ա from edu_xingzheng_tiaoxiububan where ����ʱ�� >='$��ʼʱ��' and ����ʱ��<='$����ʱ��'  and �������״̬ = '1' group by ��Ա";
	$rs = $db->CacheExecute(150,$sql);
	$rs_a = $rs->GetArray();
	$��Ա = $rs_a[0]['��Ա'];
	$Text[$��Ա]['�����¼'] = $rs_a[0]['�����¼'];

	//���ݼ�¼
	$sql = "select COUNT(*) AS ���ݼ�¼,��Ա from edu_xingzheng_jiabanbuxiu where ����ʱ�� >='$��ʼʱ��' and ����ʱ��<='$����ʱ��'  and (�������״̬ = '1') group by ��Ա";
	$rs = $db->CacheExecute(150,$sql);
	$rs_a = $rs->GetArray();
	$��Ա = $rs_a[0]['��Ա'];
	$Text[$��Ա]['���ݼ�¼'] = $rs_a[0]['���ݼ�¼'];

	//���ڲ���
	$sql = "select COUNT(*) AS ���ڲ���,��Ա from edu_xingzheng_kaoqinbudeng where ʱ�� >='$��ʼʱ��' and ʱ��<='$����ʱ��'  and (���״̬ = '1') group by ��Ա";
	$rs = $db->CacheExecute(150,$sql);
	$rs_a = $rs->GetArray();
	$��Ա = $rs_a[0]['��Ա'];
	$Text[$��Ա]['���ڲ���'] = $rs_a[0]['���ڲ���'];

	//��������
	$sql = "select COUNT(*) AS ��������,��Ա from edu_xingzheng_tiaoban where ԭ�ϰ�ʱ�� >='$��ʼʱ��' and ԭ�ϰ�ʱ��<='$����ʱ��'  and (���״̬ = '1') group by ��Ա";
	$rs = $db->CacheExecute(150,$sql);
	$rs_a = $rs->GetArray();
	$��Ա = $rs_a[0]['��Ա'];
	$Text[$��Ա]['��������'] = $rs_a[0]['��������'];

	//������ʵ
	$sql = "select COUNT(*) AS ������ʵ,��Ա from edu_xingzheng_tiaoban where ���ϰ�ʱ�� >='$��ʼʱ��' and ���ϰ�ʱ��<='$����ʱ��'  and (���״̬ = '1') group by ��Ա";
	$rs = $db->CacheExecute(150,$sql);
	$rs_a = $rs->GetArray();
	$��Ա = $rs_a[0]['��Ա'];
	$Text[$��Ա]['������ʵ'] = $rs_a[0]['������ʵ'];

	//�໥��������
	$sql = "select COUNT(*) AS �໥��������,ԭ��Ա from edu_xingzheng_tiaobanxianghu where ԭ�ϰ�ʱ�� >='$��ʼʱ��' and ԭ�ϰ�ʱ��<='$����ʱ��'  and (���״̬ = '1') group by ԭ��Ա";
	$rs = $db->CacheExecute(150,$sql);
	$rs_a = $rs->GetArray();
	$��Ա = $rs_a[0]['ԭ��Ա'];
	$Text[$��Ա]['�໥��������'] = $rs_a[0]['�໥��������'];

	//�໥������ʵ
	$sql = "select COUNT(*) AS �໥������ʵ,����Ա from edu_xingzheng_tiaobanxianghu where ���ϰ�ʱ�� >='$��ʼʱ��' and ���ϰ�ʱ��<='$����ʱ��'  and (���״̬ = '1') group by ����Ա";
	$rs = $db->CacheExecute(150,$sql);
	$rs_a = $rs->GetArray();
	$��Ա = $rs_a[0]['����Ա'];
	$Text[$��Ա]['�໥������ʵ'] = $rs_a[0]['�໥������ʵ'];

	return $Text;

}



function returnKaoQinMingXi($��Ա,$��ʼʱ��='',$����ʱ��='')		{
	global $db,$�������TEXT;

	$sql = "select COUNT(*) AS NUM from edu_xingzheng_kaoqinmingxi where ���� >='$��ʼʱ��' and ����<='$����ʱ��' and ��Ա='$��Ա' and ��� in ($�������TEXT) ";
	$rs = $db->CacheExecute(150,$sql);
	$rs_a = $rs->GetArray();
	$Number1 = $rs_a[0]['NUM'];
	//�ϰ࿼�ڼ�¼
	$sql = "select COUNT(*) AS NUM from edu_xingzheng_kaoqinmingxi where ���� >='$��ʼʱ��' and ����<='$����ʱ��' and ��Ա='$��Ա' and (�ϰ࿼��״̬ = '����ˢ��' or �ϰ࿼��״̬ = '�ϰ�ٵ�' or �°࿼��״̬ = '���ڲ���') and ��� in ($�������TEXT) ";
	$rs = $db->CacheExecute(150,$sql);
	$rs_a = $rs->GetArray();
	$Number2 = $rs_a[0]['NUM'];
	//�°࿼�ڼ�¼
	$sql = "select COUNT(*) AS NUM from edu_xingzheng_kaoqinmingxi where ���� >='$��ʼʱ��' and ����<='$����ʱ��' and ��Ա='$��Ա' and (�°࿼��״̬ = '����ˢ��' or �°࿼��״̬ = '�°�����' or �°࿼��״̬ = '���ڲ���' ) and ��� in ($�������TEXT) ";
	$rs = $db->CacheExecute(150,$sql);
	$rs_a = $rs->GetArray();
	$Number3 = $rs_a[0]['NUM'];
	//$Text = "���迼�ڴ���:".$Number1." �ϰ��ѿ���:".$Number2." ȱ".($Number1-$Number2)." �°��ѿ���:".$Number3." ȱ".($Number1-$Number3)."";
	$Text['���迼�ڴ���'] = $Number1;
	$Text['�ϰ��ѿ���'] = $Number2;
	$Text['�ϰ࿼��ȱ'] = $Number1-$Number2;
	$Text['�°��ѿ���'] = $Number3;
	$Text['�°࿼��ȱ'] = $Number1-$Number3;
	return $Text;

}

?>
