<?php
ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL);
// display warnings and errors
error_reporting(E_WARNING | E_ERROR);
require_once('lib.inc.php');
$GLOBAL_SESSION=returnsession();
page_css();
if($_GET['pageAction']!="write")				{
	//header("Content-Type:text/html;charset=gbk");
	//######################�������-Ȩ�޽��鲿��##########################


$SYSTEM_PRIV_STOP = 1;
	require_once("systemprivateinc.php");
	CheckSystemPrivate("������Դ-��������-����ͳ��");
	//######################�������-Ȩ�޽��鲿��##########################
	//page_css("������Ա�򿨿���ͳ��");
	$DateMonth = $_GET['Month'];

}

if($_GET['pageAction']=="ExportDataToFile")				{


	$PHP_SELF = $_SERVER['PHP_SELF'];
	$PHP_SELF_ARRAY = explode('/',$_SERVER['PHP_SELF']);
	$FILE_NAME = array_pop($PHP_SELF_ARRAY);
	$PHP_SELF = @join('/',$PHP_SELF_ARRAY);
	$filename = "FileCache/".$FILE_NAME."_".date("Y-m-d-H").".xls";


	$hostname = "http://".$_SERVER['SERVER_NAME'].":".$_SERVER['SERVER_PORT']."".$PHP_SELF."/$FILE_NAME?��ʼ��=".$_GET['��ʼ��']."&������=".$_GET['������']."&action=".$_GET['action']."&Month=".$_GET['Month']."&LOGIN_USER_NAME=".$_GET['LOGIN_USER_NAME']."&pageAction=write";
	//print_R($hostname);;exit;
	$file = file($hostname);
	$FILE_CONTENT = join('',$file);
	@!$handle = fopen($filename, 'w');
	@fwrite($handle, $FILE_CONTENT);
	fclose($handle);

	if($_GET['Month']!="")		{
		$TEXT = '�·�:'.$_GET['Month'];
	}
	else	{
		$TEXT = '��ʼ��:'.$��ʼ��.' ������:'.$������.'';
	}
	header('Content-Encoding: none');
	header('Content-Type: application/octetstream');
	header('Content-Disposition: attachment;filename=��������ͳ��['.$TEXT.']['.date("Y-m-d-H").'].xls');
	header('Content-Length: '.strlen($FILE_CONTENT));
	header('Pragma: no-cache');
	header('Expires: 0');
	echo $FILE_CONTENT;
	exit;
}


if($LOGIN_THEME!="") $LOGIN_THEME_TEXT = $LOGIN_THEME;
else	 $LOGIN_THEME_TEXT = 3;

print "<TITLE>������Ա�򿨿���ͳ��</TITLE>
<META http-equiv=Content-Type content=\"text/html; charset=gb2312\">
<LINK href=\"http://".$_SERVER['SERVER_NAME'].":".$_SERVER['SERVER_PORT']."/theme/$LOGIN_THEME_TEXT/style.css\" type=text/css rel=stylesheet>
<script type=\"text/javascript\" language=\"javascript\" src=\"http://".$_SERVER['SERVER_NAME'].":".$_SERVER['SERVER_PORT']."/general/EDU/Enginee/lib/common.js\"></script><STYLE>@media print{input{display:none}}</STYLE>
<BODY class=bodycolor topMargin=5 >";

if($_GET['action']=="StaticAll"&&($_GET['Month']!=""||$_GET['��ʼ��']!=""))			{

if($_GET['Month']!="")			{
	$DateMonth = $_GET['Month'];
	$DateMonthArray = explode('-',$DateMonth);
	$�������� = date("t",mktime(1,1,1,$DateMonthArray[1],1,$DateMonthArray[0]));
	$��ʼʱ�� = date("Y-m-d",mktime(1,1,1,$DateMonthArray[1],1,$DateMonthArray[0]));
	$����ʱ�� = date("Y-m-d",mktime(1,1,1,$DateMonthArray[1],$��������,$DateMonthArray[0]));
}
else	{
	//print_R($_GET);
	$sql = "select ��ʼʱ��,ѧ������ from edu_xueqiexec where ��ǰѧ��='1' order by ��ˮ�� desc limit 1";
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


//print_R($_GET);
$returnTeacherKaoQin = returnTeacherKaoQin($��ʼʱ��,$����ʱ��);
$returnBanCiList = returnBanCiList();
$Header = @array_keys($returnTeacherKaoQin['״̬']);

print "
<table width=100% align=center class=TableBlock>
<tr class=TableHeader>
<td colspan=".(sizeof($Header)+1).">������Ա�򿨿��ڹ���(ͳ��ʱ��:".$��ʼʱ��." �� ".$����ʱ��.")[�ϰ���°ఴ���ν���ͳ��]
&nbsp;<INPUT TYPE=\"button\" VALUE=\"����\" class=SmallButton ONCLICK=\"location='?pageAction=ExportDataToFile&action=".$_GET['action']."&��ʼ��=".$_GET['��ʼ��']."&������=".$_GET['������']."&Month=".$_GET['Month']."'\">
&nbsp;<input type=\"button\" value=\"����\" class=\"SmallButton\" onClick=\"history.back();\">
</td>
</tr>

";

//print_R($Header);
print "<tr class=TableHeader><td colspan=1>��Ա�û���</td>";
for($iX=0;$iX<sizeof($Header);$iX++)						{
	$״̬ = $Header[$iX];
	print "<td colspan=1>&nbsp;".$״̬."</td>";
}
print "</tr>";


$sql = "select distinct ��Ա�û��� from edu_xingzheng_kaoqinmingxi order by ��Ա�û���";
$rs = $db->CacheExecute(150,$sql);
$rs_a = $rs->GetArray();
//print_R($returnTeacherKaoQin);

for($i=0;$i<sizeof($rs_a);$i++)						{
	$Element = $rs_a[$i];
	$��Ա�û���  = $Element['��Ա�û���'];
	$Text = $returnTeacherKaoQin['��Ա�û���'][$��Ա�û���];
	//print_R($Text);
	//���迼�ڴ���Ϊ0ʱ��ʾû�и�������Ա�Ŀγ���Ϣ,�����ڴ˲�����ʾ����
	//if($Text['���迼�ڴ���']>0)				{
		//print_R($Header);
		$��Ա   = returntablefield("user","USER_ID",$��Ա�û���,"USER_NAME");
		print "<tr class=TableData><td colspan=1>".$��Ա."[{$��Ա�û���}]</td>";
		for($iX=0;$iX<sizeof($Header);$iX++)						{
			$״̬ = $Header[$iX];
			print "<td colspan=1>&nbsp;<a href=\"?action=StaticSingleTeacher&��ʼʱ��=$��ʼʱ��&����ʱ��=$����ʱ��&��Ա�û���=$��Ա�û���&TYPE=$״̬\" target=_blank>".$Text[$״̬]."</a></td>";
		}
		print "</tr>";
	//}
}

exit;
}


//������ϸ
if($_GET['action']=="StaticSingleTeacher"&&$_GET['��ʼʱ��']!=""&&$_GET['����ʱ��']!=""&&$_GET['��Ա�û���']!="")			{
$DateMonth = $_GET['Month'];
$��Ա�û��� = $_GET['��Ա�û���'];
$TYPE = $_GET['TYPE'];
$Column = returntablecolumn("edu_xingzheng_kaoqinmingxi");

//$DateMonthArray = explode('-',$DateMonth);
//$�������� = date("t",mktime(1,1,1,$DateMonthArray[1],1,$DateMonthArray[0]));
//$��ʼʱ�� = date("Y-m-d",mktime(1,1,1,$DateMonthArray[1],1,$DateMonthArray[0]));
//$����ʱ�� = date("Y-m-d",mktime(1,1,1,$DateMonthArray[1],$��������,$DateMonthArray[0]));


print "
<table width=100% align=center class=TableBlock>
<tr class=TableHeader>
<td colspan=".sizeof($Column)."+3>������Ա�򿨿��ڹ���(ͳ��ʱ��:".$��ʼʱ��." �� ".$����ʱ��." ������Ա����:$��Ա�û��� ͳ����:$TYPE)[�ϰ���°ఴ���ν���ͳ��]&nbsp;<input type=button value=\"�� ��\" class=\"SmallButton\" onclick=\"window.close();\"></td>
</tr>
<tr class=TableHeader>";

//array_shift($Column);
for($i=0;$i<sizeof($Column);$i++)						{
	print "<td nowrap>".$Column[$i]."</td>";
}
print "</tr>";

//print_R($_GET);
switch($TYPE)		{
	case '���迼�ڴ���':
		$AddSql = "";
		break;
	case '�ϰ�ȱ��':
		$AddSql = " and (�ϰ࿼��״̬ = '�ϰ�ȱ��')";
		break;
	case '�°�ȱ��':
		$AddSql = " and (�°࿼��״̬ = '�°�ȱ��')";
		break;
	case '������':
		$AddSql = " and (�ϰ࿼��״̬ = '������' or �°࿼��״̬ = '������' )";
		break;
	case '���ÿ���':
		$AddSql = " and (�ϰ࿼��״̬ = '���ÿ���' or �°࿼��״̬ = '���ÿ���' )";
		break;
	default:
		$AddSql = " and (�ϰ࿼��״̬ = '$TYPE' or �°࿼��״̬ = '$TYPE' )";
		break;
}

$sql = "select * from edu_xingzheng_kaoqinmingxi where ��Ա�û���='$��Ա�û���' and ���� >='$��ʼʱ��' and ����<='$����ʱ��' $AddSql order by ����,���";
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

	page_css("������Ա�������ڰ��·ݲ�ѯ");

	//�˶δ�����ǰΪ�ܴ�ͳ��֮ǰ,�·�ͳ��֮��,����Ҫ�õ�ѧ������,������ǰ����
	if($_GET['ѧ������']!="")	$ѧ������ = $_GET['ѧ������'];
	else						$ѧ������ = returntablefield("edu_xueqiexec","��ǰѧ��",'1',"ѧ������");
	$ѧ�ڳ�ʼֵ = $ѧ������;

	$sql = "select ��ʼʱ��,ѧ������ from edu_xueqiexec where ��ǰѧ��='1'  order by ��ˮ�� desc limit 1";
	$rs = $db->CacheExecute(150,$sql);
	$rs_a = $rs->GetArray();
	$��ʼʱ�� = $rs_a[0]['��ʼʱ��'];
	//$ѧ������ = $rs_a[0]['ѧ������'];
	$��ʼʱ��Array = explode('-',$��ʼʱ��);

	print "
		<table border=0 class=TableBlock width=100% >
		<tr class=TableHeader><td valign=bottom align=left>������Ա�������ڹ��� ".$html_etc['edu_xingzheng_kaoqinmingxi']['ѧ��'].":";
		//$ѧ������
		//print_select_single_select("CurXueQi",$ѧ������,"edu_xueqiexec","ѧ������","ѧ������");

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
		$sql = "SELECT  distinct date_format( ����, '%Y-%m' ) AS DateMonth FROM `edu_xingzheng_kaoqinmingxi` where ѧ�� ='$ѧ������' ";
		$rs = $db->CacheExecute(150,$sql);
		$rs_a = $rs->GetArray();
		for($i=0;$i<sizeof($rs_a);$i++)		{
			$DateMonth = $rs_a[$i]['DateMonth'];
			$DateMonthArray = explode('-',$DateMonth);
			$�������� = date("t",mktime(1,1,1,$DateMonthArray[1],1,$DateMonthArray[0]));
			$��ʼʱ�� = date("Y-m-d",mktime(1,1,1,$DateMonthArray[1],1,$DateMonthArray[0]));
			$����ʱ�� = date("Y-m-d",mktime(1,1,1,$DateMonthArray[1],$��������,$DateMonthArray[0]));


			$sql = "select count(*) as NUM from edu_xingzheng_kaoqinmingxi where ���� >='$��ʼʱ��' and ����<='$����ʱ��'";
			$rs = $db->CacheExecute(150,$sql);
			$rsX_a = $rs->GetArray();
			$Number = $rsX_a[0]['NUM'];

			$sql = "select count(*) as NUM from edu_xingzheng_kaoqinmingxi where ���� >='$��ʼʱ��' and ����<='$����ʱ��' and (�ϰ࿼��״̬!='�ϰ�ȱ��' or �°࿼��״̬!='�°�ȱ��')";
			$rs = $db->CacheExecute(150,$sql);
			$rsX_a = $rs->GetArray();
			$Number2 = $rsX_a[0]['NUM'];

			print "".$DateMonth." &nbsp;
			[<a href=\"?".base64_encode("action=StaticAll&Month=$DateMonth")."\" >���ĸ��¿�������</a>]
			&nbsp;&nbsp;
			[��Ҫ����".$Number."��,�����".$Number2."��]";
			print "<BR>";

		}
		print "</td></tr></table><BR>";



		if($Target=="") $Target = date("Y-m-d");
		$TargetArray = explode('-',$Target);
		$W1 = date('W',mktime(1,1,1,$��ʼʱ��Array[1],$��ʼʱ��Array[2],$��ʼʱ��Array[0]));
		$W2 = date('W',mktime(1,1,1,$TargetArray[1],$TargetArray[2],$TargetArray[0]));
		$W = $W2-$W1+1;

		$sql = "select MAX(�ܴ�) as ����ܴ� from edu_xingzheng_kaoqinmingxi where ѧ�� ='$ѧ������'";
		$rs = $db->CacheExecute(150,$sql);
		$rsX_a = $rs->GetArray();
		$����ܴ� = $rsX_a[0]['����ܴ�'];

		print "
		<table border=0 class=TableBlock width=100% >
		<tr class=TableHeader><td valign=bottom align=left>������Ա�������ڰ��ܴβ�ѯ ".$html_etc['edu_xingzheng_kaoqinmingxi']['ѧ��'].":";
		$sql="select ѧ������ from edu_xueqiexec";
		$rs=$db->Execute($sql);//print_R($rs->GetArray());
		$ѧ���ı�XX .= "&nbsp;&nbsp;<select class=\"SmallSelect\" name=\"CurXueQi\" onChange=\"var jmpURL='?XX=XX&ѧ������=' + this.options[this.selectedIndex].value ; if(jmpURL!='') {window.location=jmpURL;} else {this.selectedIndex=0 ;}\"
		>\n";
		while(!$rs->EOF)			{
		if($ѧ�ڳ�ʼֵ==$rs->fields['ѧ������'])		$temp='selected';
		$ѧ���ı�XX .= "<option value=\"".$rs->fields['ѧ������']."\" $temp>".$rs->fields['ѧ������']."</option>\n";
		$temp='';
		$rs->MoveNext();
		}
		$ѧ���ı�XX .= "</select>\n";
		print $ѧ���ı�XX;
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

function returnBanCiList()		{
	global $db;
	$sql = "select * from edu_xingzheng_banci";
	$rs = $db->CacheExecute(150,$sql);
	$rs_a = $rs->GetArray();
	$������� = array();
	for($i=0;$i<sizeof($rs_a);$i++)						{
		$Element = $rs_a[$i];
		$�������[]  = $Element['�������'];
	}
	return $�������;
}

function returnTeacherKaoQin($��ʼʱ��='',$����ʱ��='')		{
	global $db,$returnBanCiList;

	$sql = "select COUNT(*) AS NUM,�ϰ࿼��״̬,��Ա�û��� from edu_xingzheng_kaoqinmingxi where ���� >='$��ʼʱ��' and ����<='$����ʱ��'  group by �ϰ࿼��״̬,��Ա�û���";
	//print $sql;exit;
	$rs = $db->CacheExecute(150,$sql);
	$rs_a = $rs->GetArray();
	//print_R($rs_a);
	$NewArray = array();
	for($i=0;$i<sizeof($rs_a);$i++)						{
		$Element = $rs_a[$i];
		$NUM	= $Element['NUM'];
		$��Ա�û���	= $Element['��Ա�û���'];
		$�ϰ࿼��״̬  = $Element['�ϰ࿼��״̬'];
		if($�ϰ࿼��״̬!="")		{
			$NewArray['��Ա�û���'][$��Ա�û���][$�ϰ࿼��״̬] += $NUM;
			$NewArray['״̬'][$�ϰ࿼��״̬] += $NUM;
		}
	}

	$sql = "select COUNT(*) AS NUM,�°࿼��״̬,��Ա�û��� from edu_xingzheng_kaoqinmingxi where ���� >='$��ʼʱ��' and ����<='$����ʱ��' group by �°࿼��״̬,��Ա�û���";
	//print $sql;exit;
	$rs = $db->CacheExecute(150,$sql);
	$rs_a = $rs->GetArray();
	//print_R($rs_a);
	for($i=0;$i<sizeof($rs_a);$i++)						{
		$Element = $rs_a[$i];
		$NUM  = $Element['NUM'];
		$��Ա�û���  = $Element['��Ա�û���'];
		$�°࿼��״̬  = $Element['�°࿼��״̬'];
		if($�°࿼��״̬!="")		{
			$NewArray['��Ա�û���'][$��Ա�û���][$�°࿼��״̬] += $NUM;
			$NewArray['״̬'][$�°࿼��״̬] += $NUM;
		}
	}

	//print_R($NewArray);

	return $NewArray;

}
?>
