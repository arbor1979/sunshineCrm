<?php

	require_once('lib.inc.php');



	$GLOBAL_SESSION=returnsession();
$SYSTEM_PRIV_STOP = 1;
	require_once("systemprivateinc.php");
	CheckSystemPrivate("������Դ-�ɲ�����-����ɲ�����");


	$������Ա = $_SESSION['LOGIN_USER_NAME'];


	$�������� = returntablefield("edu_zhongcengceping","�Ƿ���Ч",1,"��������");
	$����������Ա = returntablefield("edu_zhongcengceping","��������",$��������,"����������Ա");
	$����������ԱArray = explode(',',$����������Ա);

	page_css("�ɲ�����");

	//�����Ƿ���Բ������
	if(!in_array($������Ա,$����������ԱArray))		{
		print_infor("��û���ڿ��Բ����������Ա֮��!",'',"location='?'");
		exit;
	}
	/*
	  ��� int(33) NOT NULL auto_increment,
	  �������� varchar(200) NOT NULL default '',
	  ������Ա varchar(200) NOT NULL default '',
	  ��λ varchar(200) NOT NULL default '',
	  ְ�� varchar(200) NOT NULL default '',
	  Ʒ������ mediumtext NOT NULL default '',
	  Ʒ������ mediumtext NOT NULL default '',
	  �������� mediumtext NOT NULL default '',
	  �������� mediumtext NOT NULL default '',
	  �ڷ����� mediumtext NOT NULL default '',
	  �ڷ����� mediumtext NOT NULL default '',
	  ��Ч���� mediumtext NOT NULL default '',
	  ��Ч���� mediumtext NOT NULL default '',
	  �������� mediumtext NOT NULL default '',
	  �������� mediumtext NOT NULL default '',
	  */
if($_GET['action']=="PingJiaDataDeal")				{
//print_R($_POST);
//Array ( [Ʒ������] => ���� [Ʒ�±�ע] => Ʒ�±�ע [��������] => ����/��ְ [������ע] => ������ע [�ڷ�����] => �е�/������ְ [�ڷܱ�ע] => �ڷܱ�ע [��Ч����] => ��/����ְ [��Ч��ע] => ��Ч��ע [��������] => ���� [������ע] => ������ע [�ύ] => �ύ )
$������Ա = $_GET['������Ա'];
$�������� = $_GET['��������'];
$��λ = $_GET['��λ'];
$ְ�� = $_GET['ְ��'];
$sql = "select * from edu_zhongcengmingxi where ��������='$��������' and ������Ա='".$������Ա."' and ������='".$������Ա."'";
$rs = $db->Execute($sql);
$rs_a = $rs->GetArray();
$��� = $rs_a[0]['���'];
//rint $sql;exit;
if($���!="")		{
	$sql = "update edu_zhongcengmingxi set Ʒ������='".addslashes($_POST['Ʒ������'])."',
											Ʒ�±�ע='".addslashes($_POST['Ʒ�±�ע'])."',
											��������='".addslashes($_POST['��������'])."',
											������ע='".addslashes($_POST['������ע'])."',
											�ڷ�����='".addslashes($_POST['�ڷ�����'])."',
											�ڷܱ�ע='".addslashes($_POST['�ڷܱ�ע'])."',
											��Ч����='".addslashes($_POST['��Ч����'])."',
											��Ч��ע='".addslashes($_POST['��Ч��ע'])."',
											��������='".addslashes($_POST['��������'])."',
											������ע='".addslashes($_POST['������ע'])."'
									where ��������='$��������' and ������Ա='".$������Ա."'";
}
else	{
	$sql = "insert into edu_zhongcengmingxi values(
					'',
					'$��������',
					'$������Ա',
					'$��λ',
					'$ְ��',
					'".addslashes($_POST['Ʒ������'])."',
					'".addslashes($_POST['Ʒ�±�ע'])."',
					'".addslashes($_POST['��������'])."',
					'".addslashes($_POST['������ע'])."',
					'".addslashes($_POST['�ڷ�����'])."',
					'".addslashes($_POST['�ڷܱ�ע'])."',
					'".addslashes($_POST['��Ч����'])."',
					'".addslashes($_POST['��Ч��ע'])."',
					'".addslashes($_POST['��������'])."',
					'".addslashes($_POST['������ע'])."',
					'".$������Ա."',
					'".date('Y-m-d H:i:s')."'
					);";
}
$rs = $db->Execute($sql);
print_infor("���������Ѿ����,�뷵��...");
print  "<META HTTP-EQUIV=REFRESH CONTENT='0;URL=?'>";
//print $sql."<BR>";
exit;
}

if($_GET['action']=="PingJia")				{

		$sql = "select * from edu_zhongcengrenyuan where ��������='$��������' and ������Ա='".$_GET['������Ա']."' order by ��λ,������Ա";
		$rs = $db->Execute($sql);
		$rs_a = $rs->GetArray();
		$i = 0;
		$��� = $rs_a[$i]['���'];
		$�������� = $rs_a[$i]['��������'];
		$������Ա = $rs_a[$i]['������Ա'];
		$��λ = $rs_a[$i]['��λ'];
		$ְ�� = $rs_a[$i]['ְ��'];
		$Ʒ������ = nl2br($rs_a[$i]['Ʒ������']);
		$Ʒ������ = nl2br($rs_a[$i]['Ʒ������']);
		$�������� = nl2br($rs_a[$i]['��������']);
		$�������� = nl2br($rs_a[$i]['��������']);
		$�ڷ����� = nl2br($rs_a[$i]['�ڷ�����']);
		$�ڷ����� = nl2br($rs_a[$i]['�ڷ�����']);
		$��Ч���� = nl2br($rs_a[$i]['��Ч����']);
		$��Ч���� = nl2br($rs_a[$i]['��Ч����']);
		$�������� = nl2br($rs_a[$i]['��������']);
		$�������� = nl2br($rs_a[$i]['��������']);



print "<script language = \"JavaScript\">
	function FormCheck()
	{

		if(!confirm(\"��ֻ��һ�������Ļ���,��ȷ����д����,���ȷ�������ύ�����ȡ����������\"))		{
			return false;
		}

	}
	</script>
	";

print "<FORM name=form1 onsubmit=\"return FormCheck();\" action=\"?action=PingJiaDataDeal&��������=$��������&������Ա=$������Ա&��λ=$��λ&ְ��=$ְ��\" method=post encType=multipart/form-data>";

table_begin("100%");



$sql = "select * from edu_zhongcengmingxi where ��������='$��������' and ������Ա='".$������Ա."' and ������='".$������Ա."' order by ��λ,������Ա";
$rs = $db->Execute($sql);
$rs_a = $rs->GetArray();

$Ʒ������ = DoItProject('Ʒ������',$rs_a[0]['Ʒ������']);
$Ʒ�±�ע = DoItProject2('Ʒ�±�ע',$rs_a[0]['Ʒ�±�ע']);

$�������� = DoItProject('��������',$rs_a[0]['��������']);
$������ע = DoItProject2('������ע',$rs_a[0]['������ע']);

$�ڷ����� = DoItProject('�ڷ�����',$rs_a[0]['�ڷ�����']);
$�ڷܱ�ע = DoItProject2('�ڷܱ�ע',$rs_a[0]['�ڷܱ�ע']);

$��Ч���� = DoItProject('��Ч����',$rs_a[0]['��Ч����']);
$��Ч��ע = DoItProject2('��Ч��ע',$rs_a[0]['��Ч��ע']);

$�������� = DoItProject('��������',$rs_a[0]['��������']);
$������ע = DoItProject2('������ע',$rs_a[0]['������ע']);

//print_R($rs_a);
$sql = "select ���� from edu_zhongcengrenyuan where ��������='$��������' and ������Ա='".$������Ա."'";
$rsX = $db->Execute($sql);
$rsX_a = $rsX->GetArray();
$���� = $rsX_a[0]['����'];

if($����!="")	 $���� = "<a href=\"$����\">���������ļ�</a>";
else	$���� = "<font color=gray>û���ϴ������ļ�</font>";


print "<tr class=TableHeader ><td colspan=5 align=left>��ʼ���в���Ա���� (��ϸ���飬�������ۣ��������ˣ������Լ�)</td></tr>";
print "<tr class=TableContent >
<td  align=left nowrap  colspan=2>&nbsp;������Ա:".$_GET['������Ա']." $���� </td>
<td  align=left nowrap  colspan=2>&nbsp;����:".$��λ."</td>
<td  align=left nowrap>&nbsp;ְ��:".$ְ��."</td>
</tr>";

print "<tr class=TableContent >
<td  align=left nowrap width=10%>&nbsp;��Ŀ</td>
<td  align=left nowrap width=40%>&nbsp;����</td>
<td  align=left nowrap width=15%>&nbsp;����</td>
<td  align=left nowrap width=20%>&nbsp;����</td>
<td  align=left nowrap width=20%>&nbsp;��ע</td>
</tr>";

print "<tr class=TableData >
<td  align=left nowrap>&nbsp;Ʒ��</td>
<td  align=left >&nbsp;".$Ʒ������."</td>
<td  align=left >&nbsp;".$Ʒ������."</td>
<td  align=left valign=top ><BR>&nbsp;".$Ʒ������."</td>
<td  align=left valign=top ><BR>&nbsp;".$Ʒ�±�ע."</td>
</tr>";

print "<tr class=TableData >
<td  align=left nowrap>&nbsp;����</td>
<td  align=left >&nbsp;".$��������."</td>
<td  align=left >&nbsp;".$��������."</td>
<td  align=left valign=top ><BR>&nbsp;".$��������."</td>
<td  align=left valign=top ><BR>&nbsp;".$������ע."</td>
</tr>";

print "<tr class=TableData >
<td  align=left nowrap>&nbsp;�ڷ�</td>
<td  align=left >&nbsp;".$�ڷ�����."</td>
<td  align=left >&nbsp;".$�ڷ�����."</td>
<td  align=left valign=top ><BR>&nbsp;".$�ڷ�����."</td>
<td  align=left valign=top ><BR>&nbsp;".$�ڷܱ�ע."</td>
</tr>";

print "<tr class=TableData >
<td  align=left nowrap>&nbsp;��Ч</td>
<td  align=left >&nbsp;".$��Ч����."</td>
<td  align=left >&nbsp;".$��Ч����."</td>
<td  align=left valign=top ><BR>&nbsp;".$��Ч����."</td>
<td  align=left valign=top ><BR>&nbsp;".$��Ч��ע."</td>
</tr>";

print "<tr class=TableData >
<td  align=left nowrap>&nbsp;����</td>
<td  align=left >&nbsp;".$��������."</td>
<td  align=left >&nbsp;".$��������."</td>
<td  align=left valign=top ><BR>&nbsp;".$��������."</td>
<td  align=left valign=top ><BR>&nbsp;".$������ע."</td>
</tr>";


print "<TR><TD class=TableControl noWrap align=middle  colspan=\"5\">
<div align=\"center\">
<INPUT class=SmallButton name=�ύ title=�ύ type=submit value=\"�ύ\" name=button>
��<INPUT class=SmallButton onclick=\"history.back();\" type=button value='����'>
</div>
</TD></TR>";
table_end();
form_end();
exit;
}



function DoItProject2($SelectName,$SelectValue)		{

global $db;

$Text = "<TEXTAREA class=BigInput name=$SelectName  title='' wrap=yes rows=3 cols=25 >$SelectValue</TEXTAREA>";
return $Text;
}

	table_begin("100%");
	print "<tr class=TableHeader ><td colspan=14 align=left>��ʼ�Ըɲ���Ա����[ÿ��������ֻ������һ��,��������Ժ����ٽ����޸�]</td></tr>";
	print "<tr class=TableHeader >
				<td  align=center>������Ա</td>
				<td  align=center>����</td>
				<td  align=center>ְ��</td>
				<td  align=center>����</td>
				<td  align=center>����</td>
				</tr>";
	$sql = "select * from edu_zhongcengrenyuan where ��������='$��������' order by ��λ,������Ա";
	$rs = $db->Execute($sql);
	$rs_a = $rs->GetArray();
	for($i=0;$i<sizeof($rs_a);$i++)		{
		$��� = $rs_a[$i]['���'];
		$�������� = $rs_a[$i]['��������'];
		$������Ա = $rs_a[$i]['������Ա'];
		$��λ = $rs_a[$i]['��λ'];
		$ְ�� = $rs_a[$i]['ְ��'];
		$Ʒ������ = $rs_a[$i]['Ʒ������'];
		$Ʒ������ = $rs_a[$i]['Ʒ������'];
		$�������� = $rs_a[$i]['��������'];
		$�������� = $rs_a[$i]['��������'];
		$�ڷ����� = $rs_a[$i]['�ڷ�����'];
		$�ڷ����� = $rs_a[$i]['�ڷ�����'];
		$��Ч���� = $rs_a[$i]['��Ч����'];
		$��Ч���� = $rs_a[$i]['��Ч����'];
		$�������� = $rs_a[$i]['��������'];
		$�������� = $rs_a[$i]['��������'];
		$����ALL = ViewItProject($��������,$������Ա,$������Ա);
		$���� = $����ALL['����'];
		$���� = $����ALL['����'];
		if($����>0)		{
			$ƽ���� = $����/($����*5);
			$ƽ���� = number_format($ƽ����,2,'.','');
			$����Text = "�ܷ�:$���� ƽ����:".$ƽ����;
			$����������� = "<font color=green>���Ѿ���������</font>";
		}
		else	{
			$����Text = '';
			$����������� = "<a href=\"?action=PingJia&��������=$��������&������Ա=$������Ա&��λ=$��λ&ְ��=$ְ��\">�����������</a><font color=gray>(�������Ժ����޸�)</font>";
		}

		print "<tr class=TableData >
				<td  align=left>&nbsp;$������Ա</td>
				<td  align=left>&nbsp;$��λ</td>
				<td  align=left>&nbsp;$ְ��</td>
				<td  align=left>&nbsp;$����Text</td>
				<td  align=left>&nbsp;$�����������</td>
				</tr>";
	}



function DoItProject($SelectName,$SelectValue)		{

global $db;
$sql = "select ��Ŀ,��ֵ from edu_zhongcengxingmu";
$rs = $db->Execute($sql);
$rs_a = $rs->GetArray();
$Text = "<select name=$SelectName>";
for($i=0;$i<sizeof($rs_a);$i++)		{
	$��Ŀ = $rs_a[$i]['��Ŀ'];
	$��ֵ = $rs_a[$i]['��ֵ'];
	if($��Ŀ==$SelectValue) $selected = "selected";
	else	$selected = "";
	$Text .= "<option value='$��ֵ' $selected>".$��Ŀ."(".$��ֵ."��)</option>";
}
$Text .= "</select>";

return $Text;
}


function ViewItProject($��������,$������Ա,$������)		{

global $db;

$sql = "select SUM(Ʒ������)+SUM(��������)+SUM(�ڷ�����)+SUM(��Ч����)+SUM(��������) AS ����,COUNT(*) AS NUM from edu_zhongcengmingxi where ��������='$��������' and ������Ա='".$������Ա."' and ������='$������'";
$rs = $db->Execute($sql);
$rs_a = $rs->GetArray();
$Newarray['����'] = $rs_a[0]['����'];
$Newarray['����'] = $rs_a[0]['NUM'];
//print $sql."<BR>";
return $Newarray;
}





	?>