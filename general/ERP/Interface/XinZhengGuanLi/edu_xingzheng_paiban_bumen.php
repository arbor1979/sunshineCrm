<?php
ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL);

// display warnings and errors
error_reporting(E_WARNING | E_ERROR);
require_once('lib.inc.php');//

$GLOBAL_SESSION=returnsession();
$SYSTEM_PRIV_STOP = 1;
require_once("systemprivateinc.php");
//CheckSystemPrivate("������Դ-��������-���ż�����");
require_once('lib.xiaoli.inc.php');
global $ѧ������,$��ʼʱ��X,$����ʱ��X;

page_css("�����Ű�����");
$�û�ID = $_SESSION['LOGIN_USER_ID'];
list($Week_Count,$��ǰѧ��,$W_B_L,$W_E_L) = GetWeekCount();

//��ι��˲���,����ֶα�����Ϊ���ط�������--��ʼ
$LOGIN_USER_NAME = $_SESSION['LOGIN_USER_NAME'];
$sql = "select ������� from edu_xingzheng_banci where ��ι���һ='$LOGIN_USER_NAME' or ��ι����='$LOGIN_USER_NAME'";
$rs = $db->Execute($sql);
$rs_a = $rs->GetArray();
$������� = array();
for($i=0;$i<sizeof($rs_a);$i++)						{
	$Element = $rs_a[$i];
	$�������[]  = $Element['�������'];
}
$�������TEXT = "'".join("','",$�������)."'";
if($�������TEXT=="")	$�������TEXT = "û��������İ����Ϣ";
$_GET['ԭ���'] = $�������TEXT;
//��ι��˲���,����ֶα�����Ϊ���ط�������--����



//**********************ɾ����ѡ���趨����Ϣ***********************//
if($_GET['action'] == "Del")
{
	$�Ű��� = $_GET['�Ű���'];
	$��ǰ�ܴ� = $_GET['��ǰ�ܴ�'];
	$������� = $_GET['�������'];
	$�������� = $_GET['��������'];
	$��ǰ�ܴ� = $_GET['��ǰ�ܴ�'];

	$sql = "delete from edu_xingzheng_paiban where �ܴ�='$��ǰ�ܴ�' and �������='$�������' and ��������='$��������'";
	$rs = $db -> Execute($sql);
	//print_R($sql);
	//exit;
	if($rs != 0)
	print_infor("ɾ����Ϣ�ɹ�",'',"location='?��ǰ�ܴ�=$��ǰ�ܴ�'");
	else
	print_infor("ɾ����Ϣʧ��",'',"location='?��ǰ�ܴ�=$��ǰ�ܴ�'");
	print "<meta http-equiv='refresh' content=1;url='?��ǰ�ܴ�=".$��ǰ�ܴ�."'>";
	exit;
}

//********************�ύ�����������Ű���Ϣ*********************//
if($_GET['action'] == "Change" && $_GET['type'] == "team")
{
	$������ = $_POST['Team'];
	$sql = "select ��Ա���� from edu_xingzheng_group where ���='$������'";
	$rs = $db -> Execute($sql);
	$rs_a = $rs -> GetArray();
	if(!is_array($rs_a))
	$rs_a = array();
	$��Ա��Ϣ = $rs_a;
	$�Ű���Ա = "";
	$name = explode(",",$��Ա��Ϣ[0]['��Ա����']);
	array_pop($name);
	for($i=0;$i<sizeof($name);$i++)
	{
		$�Ű���Ա .= $name[$i];
		if($i!=sizeof($name)-1)
		$�Ű���Ա .= ",";
	}
	if($�Ű���Ա == "")
	{
		$��ǰ�ܴ� = $_POST['��ǰ�ܴ�'];
		print_infor("������δ����Ա��Ϣ!",'',"location='?��ǰ�ܴ�=$��ǰ�ܴ�'");
		exit;
	}
	else
	{
		$��ǰѧ�� = $_POST['��ǰѧ��'];
		$��ǰ�ܴ� = $_POST['��ǰ�ܴ�'];
		$��ǰ���� = $_POST['��ǰ����'];
		$������� = $_POST['�������'];
		$�������� = $_POST['��������'];
		$����ʱ�� = Date("Y-m-d H:i:s");

		$�Ű���ԱArray = explode(',',$�Ű���Ա);
		for($i=0;$i<sizeof($�Ű���ԱArray);$i++)		{
			$�Ű���ԱX = $�Ű���ԱArray[$i];
			$�Ű���Ա����[$�Ű���ԱX] = $�Ű���ԱX;
		}
		$�Ű���Ա����K = @array_keys($�Ű���Ա����);
		$�Ű���Ա = join(',',$�Ű���Ա����K).",";
		//print_R($�Ű���Ա);
		//exit;

		$sql = "insert into edu_xingzheng_paiban values('','".$��ǰѧ��."','$��ǰ�ܴ�','$��ǰ����','$��������','$�������','$�Ű���Ա','','$�û�ID','$����ʱ��')";
		$db -> Execute($sql);
		//print $sql;exit;
		print "<meta http-equiv='refresh' content=1;url='?��ǰ�ܴ�=".$��ǰ�ܴ�."'>";
		exit;
	}
}
//********************�ύ������Ա�Ű���Ϣ*********************//
if($_GET['action'] == "Change" && $_GET['type'] == "worker")
{
	//print_R($_POST);
	$name = $_POST['name'];
	$�Ű���Ա = "";
	for($i=0;$i<sizeof($name);$i++)
	{
		$�Ű���Ա��Ϣ = $name[$i];
		$�Ű���Ա��Ϣ_arr = explode('-',$�Ű���Ա��Ϣ);
		$�Ű���Ա .= $�Ű���Ա��Ϣ_arr[2]."";
		if($i!=sizeof($name)-1)
		$�Ű���Ա .= ",";
	}
	if($�Ű���Ա == "")
	{
		$��ǰ�ܴ� = $_POST['��ǰ�ܴ�'];
		print_infor("��û��ѡ���κγ�Ա",'',"location='?��ǰ�ܴ�=$��ǰ�ܴ�'");
		exit;
	}
	else
	{
		$�������� = $_POST['��������'];
		$��ǰѧ�� = $_POST['��ǰѧ��'];
		$��ǰ�ܴ� = $_POST['��ǰ�ܴ�'];
		$��ǰ���� = $_POST['��ǰ����'];
		$������� = $_POST['�������'];
		$����ʱ�� = Date("Y-m-d H:i:s");

		$�Ű���ԱArray = explode(',',$�Ű���Ա);
		for($i=0;$i<sizeof($�Ű���ԱArray);$i++)		{
			$�Ű���ԱX = $�Ű���ԱArray[$i];
			if($�Ű���ԱX!="")	$�Ű���Ա����[$�Ű���ԱX] = $�Ű���ԱX;
		}
		$�Ű���Ա����K = @array_keys($�Ű���Ա����);
		$�Ű���Ա = join(',',$�Ű���Ա����K).",";
		//print_R($�Ű���Ա);
		//exit;
		//��� �Ű��� ѧ������ ѧ������ �ܴ� �ܴ� ����  �������� ��α�� ������� ������� �Ű���Ա �Ű���Ա ��ע ��ע ������ ������ ����ʱ��
		$sql = "select ��� from edu_xingzheng_paiban where ѧ������='".$��ǰѧ��."' and �ܴ�='".$��ǰ�ܴ�."' and �������='".$�������."' and ��������='$��������' order by ���� asc";
		$rs = $db -> Execute($sql);
		$��� = $rs->fields['���'];
		if($���!="")		{
			$sql = "update edu_xingzheng_paiban set �ܴ�='$��ǰ�ܴ�',����='$��ǰ����',�������='$�������',�Ű���Ա='$�Ű���Ա',��������='$��������' where ���='$���'";
		}
		else	{
			$sql = "insert into edu_xingzheng_paiban values('','".$��ǰѧ��."','".$��ǰ�ܴ�."','".$��ǰ����."','".$��������."','".$�������."','".$�Ű���Ա."','','".$�û�ID."','".$����ʱ��."')";
		}
		//print $sql;exit;
		$db -> Execute($sql);
		//print $sql;exit;
		print "<meta http-equiv='refresh' content=1;url='?��ǰ�ܴ�=".$��ǰ�ܴ�."'>";
		exit;
	}
}


//*******************ѡ���������������Ϣ***************//
if($_GET['action'] == "ChangeTeam")
{
		$������Ϣ = GetBanZuInfor();
		$��ǰѧ�� = $_GET['��ǰѧ��'];
		$��ǰ�ܴ� = $_GET['��ǰ�ܴ�'];
		$��ǰ���� = $_GET['Day'];
		$������� = $_GET['�������'];
		$����ʱ��� = $_GET['����ʱ���'];
		$���� = "";
		switch($��ǰ����)
		{
			case 1: $���� = "����һ";break;
			case 2:	$���� = "���ڶ�";break;
			case 3: $���� = "������";break;
			case 4: $���� = "������";break;
			case 5: $���� = "������";break;
			case 6: $���� = "������";break;
			case 7: $���� = "������";break;
		}
?>
<table width="80%" class="TableBlock" align="center">
<form name="ChangeTeam" method="post" action="?action=Change&type=team">
<tr class="TableHeader">
<td>���鰲�Ź���</td>
</tr>
<tr class="TableData">
<td>
&nbsp;<font color="red">��ǰѧ��:<?php echo $��ǰѧ��;?></font>&nbsp;<BR>
&nbsp;<font color="green">��ǰ����:<?php echo ����Ŀ������($��ǰ�ܴ�,$��ǰ����)?></font>&nbsp;<BR>
&nbsp;<font color="green">��ǰ�ܴ�:��<?php echo $��ǰ�ܴ�;?>��</font>&nbsp;<BR>
&nbsp;<font color="green">��ǰ����:<?php echo $����;?></font>&nbsp;<BR>
&nbsp;<font color="blue">��ǰ���:<?php echo $�������;?>(<?php echo $����ʱ���;?>)
</font></td>
</tr>
<tr class="TableHeader">
<td>
��ѡ����Ҫ���ŵĹ�����
</td>
</tr>
<tr class="TableData">
<td>
<?php
	for($i=0;$i<sizeof($������Ϣ);$i++)
	{
		$������ = $������Ϣ[$i]['���'];
		$�������� = $������Ϣ[$i]['��������'];
		$������� = $������Ϣ[$i]['�������'];
		if($i == 0)
			$Checked = "checked";
		else
			$Checked = "";
		print "<input type='radio' name='Team' value='".$������."' $Checked>".$��������."-".$�������."</input><BR>";
	}
$�������� = ����Ŀ������($��ǰ�ܴ�,$��ǰ����);
?>
<input type="hidden" name="��������" value=<?php echo $��������;?> />
<input type="hidden" name="��ǰѧ��" value=<?php echo $��ǰѧ��;?> />
<input type="hidden" name="��ǰ�ܴ�" value=<?php echo $��ǰ�ܴ�;?> />
<input type="hidden" name="��ǰ����" value=<?php echo $��ǰ����;?> />
<input type="hidden" name="�������" value=<?php echo $�������;?> />
</td>
</tr>
<tr class="TableData">
<td align="center">
	<input type="submit" class="SmallButton" value="�ύ" />&nbsp;&nbsp;
	<input type="button" class="SmallButton" value="����" onclick="history.go(-1);">
</td>
</tr>
</form>
</table>
<?php
		exit;
	}

//*******************ѡ������Ա��Ϣ**********************//
	else if($_GET['action'] == "ChangeWorker")
	{
		$��Ա��Ϣ = GetWorkerInfor();
		//print_R($��Ա��Ϣ);
		$��ǰѧ�� = $_GET['��ǰѧ��'];
		$��ǰ�ܴ� = $_GET['��ǰ�ܴ�'];
		$��ǰ���� = $_GET['Day'];
		$������� = $_GET['�������'];
		$����ʱ��� = $_GET['����ʱ���'];
		$���� = "";
		switch($��ǰ����)
		{
			case 1: $���� = "����һ";break;
			case 2:	$���� = "���ڶ�";break;
			case 3: $���� = "������";break;
			case 4: $���� = "������";break;
			case 5: $���� = "������";break;
			case 6: $���� = "������";break;
			case 7: $���� = "������";break;
		}

		//�γ��Ѽ�����Ա�б�
		$�������� = ����Ŀ������($��ǰ�ܴ�,$��ǰ����);
		$sql = "select * from edu_xingzheng_paiban where ѧ������='".$��ǰѧ��."' and �ܴ�='".$��ǰ�ܴ�."' and �������='".$�������."' and ��������='$��������' order by ���� asc";
		$rs = $db -> Execute($sql);
		$rs_a = $rs -> GetArray();
		$�Ű���Ա = $rs_a[0]['�Ű���Ա'];
		$������Ա = $�Ű���Ա;
		$�Ű���Ա����K = explode(',',$�Ű���Ա);
?>

<table width="80%" class="TableBlock" align="center">
<form name="ChangeTeam" method="post" action="?action=Change&type=worker">
<tr class="TableHeader">
<td>����Ա���Ź���</td>
</tr>
<tr class="TableData">
<td><font color="red">&nbsp;��ǰѧ��:<?php echo $��ǰѧ��;?></font>&nbsp;<BR>&nbsp;<font color="green">��ǰ�ܴ�:��<?php echo $��ǰ�ܴ�;?>��</font>&nbsp;<BR>&nbsp;<font color="green">��ǰ����:<?php echo $����;?></font>&nbsp;<BR>&nbsp;<font color="blue">��ǰ���:<?php echo $�������;?>(<?php echo $����ʱ���;?>)</font>
<BR>&nbsp;<font color="blue">������Ա:<?php echo useridtoname($������Ա);?></font>
</td>
</tr>
<tr class="TableHeader">
<td>
��ѡ����Ҫ���ŵĹ�����Ա
</td>
</tr>

<?php
    $Counter1 = 0;
	$Counter2 = 0;
	for($i=0;$i<sizeof($��Ա��Ϣ);$i++)
	{
		$������ = $��Ա��Ϣ[$i]['���'];
		$�������� = $��Ա��Ϣ[$i]['��������'];
		$������� = $��Ա��Ϣ[$i]['�������'];
		$��Ա���� = $��Ա��Ϣ[$i]['��Ա����'];
		if($��Ա���� == "")
			continue;
		else
		{

			$��Ա����_arr = explode(',',$��Ա����);

			for($j=0;$j<sizeof($��Ա����_arr);$j++)
			{
				$�Ű���Ա = $��Ա����_arr[$j];
				$�Ű���Ա���� = returntablefield("user","USER_ID",$�Ű���Ա,"USER_NAME");
				if(in_array($�Ű���Ա,$�Ű���Ա����K))		{
					if($j!=sizeof($��Ա����_arr)-1)
					{
						$SHOWTEXT .= "<input type='checkbox' name='name[]' checked value='".$��������."-".$�������."-".$�Ű���Ա."' $Checked title='�û���:$�Ű���Ա ����:$�Ű���Ա����'><font color=green title='�û���:$�Ű���Ա ����:$�Ű���Ա����'>".$�Ű���Ա����."-".$�������."</font>&nbsp;";
						$jj = $Counter1+1;
						$Counter1 ++;
						if($Counter1>0 && $Counter1%4==0)
						{
							$SHOWTEXT .=  "<br>";
						}
					}

				}
				else	{
					if($j!=sizeof($��Ա����_arr)-1)
					{
						$SHOWTEXT2 .= "<input type='checkbox' name='name[]' value='".$��������."-".$�������."-".$�Ű���Ա."' $Checked title='�û���:$�Ű���Ա ����:$�Ű���Ա����' ><font color=green title='�û���:$�Ű���Ա ����:$�Ű���Ա����'>".$�Ű���Ա����."-".$�������."</font>&nbsp;";
						$jj = $Counter2+1;
						$Counter2 ++;
						if($Counter2>0 && $Counter2%4==0)
						{
							$SHOWTEXT2 .=  "<br>";
						}
					}

				}

			}

		}
	}

	print "<tr class=TableData><td>";
	print "��ѡ��Ա:<BR>".$SHOWTEXT;
	print "</td></tr>";
	print "<tr class=TableData><td>";
	print "δѡ��Ա:<BR>".$SHOWTEXT2;
	print "</td></tr>";
	$�������� = ����Ŀ������($��ǰ�ܴ�,$��ǰ����);
	?>
<input type="hidden" name="��������" value=<?php echo $��������;?> >
<input type="hidden" name="��ǰѧ��" value=<?php echo $��ǰѧ��;?> />
<input type="hidden" name="��ǰ�ܴ�" value=<?php echo $��ǰ�ܴ�;?> />
<input type="hidden" name="��ǰ����" value=<?php echo $��ǰ����;?> />
<input type="hidden" name="�������" value=<?php echo $�������;?> />
	<tr class="TableData">
<td align="center">
	<input type="submit" class="SmallButton" value="�ύ" />&nbsp;&nbsp;
	<input type="button" class="SmallButton" value="����" onclick="history.go(-1);">
</td>
</tr>
</table>
<?php
	exit;
}

?>
<table width="100%" class="TableBlock" align="center">
<tr class="TableHeader">
<td>ѡ���Ű��ܴ�</td>
</tr>
<tr class="TableData">
<td nowrap>��&nbsp;
<?php
	$_GET['��ǰ�ܴ�'] != "" ? '' : $_GET['��ǰ�ܴ�'] = returnCurWeekIndex($datetime=date("Y-m-d"));
	$��ǰ�ܴ� = $_GET['��ǰ�ܴ�'];


	for($i=0;$i<$Week_Count;$i++)
	{
		if($i+1 == $��ǰ�ܴ�)
		print "<a href='?��ǰ�ܴ�=".($i+1)."' target='_self'><font color=red>".($i+1)."</font></a>&nbsp;&nbsp;";
		else
		print "<a href='?��ǰ�ܴ�=".($i+1)."' target='_self'>".($i+1)."</a>&nbsp;&nbsp;";
	}
?>
��</td>
</tr>
</table>
<br />
<?php

	$��ǰ�ܴ� = $_GET['��ǰ�ܴ�'];
	$�����ܴ� = $��ǰ�ܴ�-1;
	$sql = "select * from edu_xingzheng_paiban where �ܴ�='$�����ܴ�' and ѧ������='$��ǰѧ��' and ������� in ($�������TEXT)";
	$rs = $db -> Execute($sql);
	$rs_a = $rs -> GetArray();
	//����
	$sql = "select * from edu_xingzheng_paiban where �ܴ�='$��ǰ�ܴ�' and ѧ������='$��ǰѧ��' and ������� in ($�������TEXT)";
	$rs = $db -> Execute($sql);
	$rs_a���� = $rs -> GetArray();

	if($_GET['action']=="�����ܻ�ȡ����"&&$_GET['��ǰ�ܴ�']!="")								{
		//print_R($rs_a);exit;
		for($i=0;$i<sizeof($rs_a);$i++)
		{
			$���� = $rs_a[$i]['����'];
			$�������� = ����Ŀ������($��ǰ�ܴ�,$����);
			$������� = $rs_a[$i]['�������'];
			$�Ű���Ա = $rs_a[$i]['�Ű���Ա'];
			$��ע = $rs_a[$i]['��ע'];
			$������ = $rs_a[$i]['������'];
			$����ʱ�� = date("Y-m-d H:i:s");;

			$�Ű���Ա���� = array();
			$�Ű���ԱArray = explode(',',$�Ű���Ա);
			for($iX=0;$iX<sizeof($�Ű���ԱArray);$iX++)		{
				$�Ű���ԱX = $�Ű���ԱArray[$iX];
				$�Ű���Ա����[$�Ű���ԱX] = $�Ű���ԱX;
			}
			$�Ű���Ա����K = @array_keys($�Ű���Ա����);
			$�Ű���Ա = join(',',$�Ű���Ա����K).",";

			//if($NUM==0)	{
			$sql = "insert into edu_xingzheng_paiban values('','$��ǰѧ��','$��ǰ�ܴ�','$����','$��������','$�������','$�Ű���Ա','$��ע','$������','$����ʱ��')";
			$db -> Execute($sql);
			//print $sql;exit;
			//}

		}
		print_infor("��������Ѿ���ʼ�����.",'',"location='?��ǰ�ܴ�=".$��ǰ�ܴ�."'");
		print "<meta http-equiv='refresh' content=0;url='?��ǰ�ܴ�=".$��ǰ�ܴ�."'>";
		exit;
	}

	//exit;
	//print_R($rs_a);
	//����������,������������,����ֹͣ���붯��
	if(sizeof($rs_a)==0||sizeof($rs_a����)>0)		{
		//û�м�¼,���ܻ�ȡ����
		$disabled_���� = "disabled readonly title='�����Ѿ����Ű����ݻ��������Ű�����,���ܴ����ܻ�ȡ��Ϣ'";
	}


	$ǰ���ܴ� = $��ǰ�ܴ�-2;
	$sql = "select * from edu_xingzheng_paiban where �ܴ�='$ǰ���ܴ�' and ѧ������='$��ǰѧ��' and ������� in ($�������TEXT)";
	$rs = $db -> Execute($sql);
	$rs_a = $rs -> GetArray();
	if($_GET['action']=="��ǰ�ܻ�ȡ����"&&$_GET['��ǰ�ܴ�']!="")								{
		//print_R($rs_a);exit;
		for($i=0;$i<sizeof($rs_a);$i++)
		{
			$���� = $rs_a[$i]['����'];
			$�������� = ����Ŀ������($��ǰ�ܴ�,$����);
			$������� = $rs_a[$i]['�������'];
			$�Ű���Ա = $rs_a[$i]['�Ű���Ա'];
			$��ע = $rs_a[$i]['��ע'];
			$������ = $rs_a[$i]['������'];
			$����ʱ�� = date("Y-m-d H:i:s");;

			$�Ű���Ա���� = array();
			$�Ű���ԱArray = explode(',',$�Ű���Ա);
			for($iX=0;$iX<sizeof($�Ű���ԱArray);$iX++)		{
				$�Ű���ԱX = $�Ű���ԱArray[$iX];
				$�Ű���Ա����[$�Ű���ԱX] = $�Ű���ԱX;
			}
			$�Ű���Ա����K = @array_keys($�Ű���Ա����);
			$�Ű���Ա = join(',',$�Ű���Ա����K).",";

			//if($NUM==0)	{
			$sql = "insert into edu_xingzheng_paiban values('','$��ǰѧ��','$��ǰ�ܴ�','$����','$��������','$�������','$�Ű���Ա','$��ע','$������','$����ʱ��')";
			$db -> Execute($sql);
			//print $sql."<BR>";
			//}


		}
		print_infor("��������Ѿ���ʼ�����.",'',"location='?��ǰ�ܴ�=".$��ǰ�ܴ�."'");
		print "<meta http-equiv='refresh' content=0;url='?��ǰ�ܴ�=".$��ǰ�ܴ�."'>";
		exit;
	}

	//exit;
	//print_R($rs_a);
	//����������,������������,����ֹͣ���붯��
	if(sizeof($rs_a)==0||sizeof($rs_a����)>0)		{
		//û�м�¼,���ܻ�ȡ����
		$disabled_ǰ�� = "disabled readonly title='�����Ѿ����Ű����ݻ��������Ű�����,���ܴ����ܻ�ȡ��Ϣ'";
	}



?>
<table width="100%" class="TableBlock" align="center">
<tr class="TableHeader">
<td colspan=8>�����Ű����&nbsp;��ǰ�ܴ�:<?php echo $��ǰ�ܴ�?>
&nbsp;ʱ�䷶Χ: <?php echo substr($����Ŀ������=����Ŀ������($��ǰ�ܴ�,1),6,11)?> �� <?php echo substr($����Ŀ������=����Ŀ������($��ǰ�ܴ�,7),6,11)?>
<input name='�����ܻ�ȡ����' value='�ӵ�<?php echo ($��ǰ�ܴ�-1)?>�ܻ�ȡ�Ű�����' class=SmallButton type=Button OnClick="location='?��ǰ�ܴ�=<?php echo $��ǰ�ܴ�?>&action=�����ܻ�ȡ����'" <?php echo $disabled_����?>>
<input name='��ǰ�ܻ�ȡ����' value='�ӵ�<?php echo ($��ǰ�ܴ�-2)?>�ܻ�ȡ�Ű�����' class=SmallButton type=Button OnClick="location='?��ǰ�ܴ�=<?php echo $��ǰ�ܴ�?>&action=��ǰ�ܻ�ȡ����'" <?php echo $disabled_ǰ��?>>
</td>
</tr>
<tr class="TableData" align="center">
	<td width="16%">���\����</td>
	<td width="12%">����һ<BR><?php echo ����Ŀ������($��ǰ�ܴ�,1)?></td>
	<td width="12%">���ڶ�<BR><?php echo ����Ŀ������($��ǰ�ܴ�,2)?></td>
	<td width="12%">������<BR><?php echo ����Ŀ������($��ǰ�ܴ�,3)?></td>
	<td width="12%">������<BR><?php echo ����Ŀ������($��ǰ�ܴ�,4)?></td>
	<td width="12%">������<BR><?php echo ����Ŀ������($��ǰ�ܴ�,5)?></td>
	<td width="12%">������<BR><?php echo ����Ŀ������($��ǰ�ܴ�,6)?></td>
	<td width="12%">������<BR><?php echo ����Ŀ������($��ǰ�ܴ�,7)?></td>
</tr>
<?php
	$�����Ϣ = GetBanCiInfor();

	for($i=0;$i<sizeof($�����Ϣ);$i++)
	{
		$������� = $�����Ϣ[$i]['�������'];
		$����ʱ��� = $�����Ϣ[$i]['����ʱ���'];
		$�Ű���Ϣ = GetPaiBanInfor($��ǰѧ��,$��ǰ�ܴ�,$�������);

		print "<tr class=TableData align=center>";
		print "<td>".$�������."(".$����ʱ���.")</td>";
		for($j=1;$j<=7;$j++)
		{
			$����Ŀ������ = ����Ŀ������($��ǰ�ܴ�,$j);
			$�Ű����� = explode("-",$�Ű���Ϣ[$�������][$��ǰ�ܴ�][$j]);
			$�Ű��� = $�Ű�����[0];
			$�Ű���Ա = $�Ű�����[1];
			print "<td>";
			if($����Ŀ������>=$��ʼʱ��X&&$����Ŀ������<=$����ʱ��X)		{
				if($�Ű���Ա=="")
				{
					print "<a href='?action=ChangeTeam&�������=".$�������."&��ǰѧ��=".$��ǰѧ��."&��ǰ�ܴ�=".$��ǰ�ܴ�."&Day=".$j."&����ʱ���=".$����ʱ���."'>ѡ������</a><br />
										   <a href='?action=ChangeWorker&�������=".$�������."&��ǰѧ��=".$��ǰѧ��."&��ǰ�ܴ�=".$��ǰ�ܴ�."&Day=".$j."&����ʱ���=".$����ʱ���."'>ѡ������Ա</a>$��������";
				}
				else
				{
					$�Ű���Ա = useridtoname($�Ű���Ա);
					$�Ű���ԱTEXT = substr_cut($�Ű���Ա,120);
					print "".$�Ű���ԱTEXT."<br /><a href='?action=Del&�������=".$�������."&����ʱ���=".$����ʱ���."&��������=".$����Ŀ������."&��ǰ�ܴ�=".$��ǰ�ܴ�."'><font color=red>ɾ��</font><BR><a href='?action=ChangeWorker&�������=".$�������."&��ǰѧ��=".$��ǰѧ��."&��ǰ�ܴ�=".$��ǰ�ܴ�."&Day=".$j."&����ʱ���=".$����ʱ���."'>ѡ������Ա</a>";
				}
			}
			else	{
				print "<font color=gray>�ǹ���ʱ��</font>";
			}
			print "</td>";
		}
		print "</tr>";
	}

?>
</table>
<?php
	if($_GET['action']==''||$_GET['action']=='init_default')		{
		$PrintText .= "<BR><table class=TableBlock align=center width=100%>";
		$PrintText .= "<TR class=TableContent><td ><font color=green >
		�Űࣺ<BR>
&nbsp;&nbsp;�پ��������Ա�������Ϣ������һ���ڰ����Ϣ�����ý����Űࡣ<BR>
&nbsp;&nbsp;��������¼ĳһ�죬ĳһ����������ϰ����Ա����Ϣ��������Ű��Ѹ��������������Ա�����Ű࣬����Աѡȡ�����ʵ�ְ�ĳһ�˵�һ�Ű����������
		</font></td></table>";
		print $PrintText;
	}

	//******************��ȡ���е���Ա��Ϣ********************//
	function GetWorkerInfor()
	{
		global $db;
		$sql = "select ���,��������,�������,��Ա���� from edu_xingzheng_group order by ��� asc,�������� asc";
		$rs = $db -> Execute($sql);
		$rs_a = $rs -> GetArray();
		if(!is_array($rs_a))
		$rs_a = array();
		$��Ա��Ϣ = $rs_a;
		return $��Ա��Ϣ;
	}
	//******************��ȡ���еİ�����Ϣ********************//
	function GetBanZuInfor()
	{
		global $db;
		$sql = "select ���,��������,�������,��Ա���� from edu_xingzheng_group";
		$rs = $db -> Execute($sql);
		$rs_a = $rs -> GetArray();
		if(!is_array($rs_a))
		$rs_a = array();
		$������Ϣ = $rs_a;
		return $������Ϣ;
	}
	//******************������еİ����Ϣ********************//
	function GetBanCiInfor()
	{
		global $db,$�������TEXT;
		$sql = "select �������,����ʱ��� from edu_xingzheng_banci where ������� in ($�������TEXT)";
		$rs = $db -> Execute($sql);
		$rs_a = $rs -> GetArray();
		if(!is_array($rs_a))
		$rs_a = array();
		$�����Ϣ = $rs_a;
		return $�����Ϣ;
	}
	//******************���ָ�����Ű���Ϣ********************//
	function GetPaiBanInfor($��ǰѧ��,$��ǰ�ܴ�,$�������)
	{
		global $db;
		$sql = "select * from edu_xingzheng_paiban where ѧ������='".$��ǰѧ��."' and �ܴ�='".$��ǰ�ܴ�."' and �������='".$�������."' order by ���� asc";
		$rs = $db -> Execute($sql);
		$rs_a = $rs -> GetArray();
		if(!is_array($rs_a))
		$rs_a = array();
		$�Ű���Ϣ = $rs_a;
		for($i=0;$i<sizeof($�Ű���Ϣ);$i++)
		{
			$�Ű��� = $�Ű���Ϣ[$i]['���'];
			$�������� = $�Ű���Ϣ[$i]['��������'];
			$������� = $�Ű���Ϣ[$i]['�������'];
			$�ܴ� = $�Ű���Ϣ[$i]['�ܴ�'];
			$���� = $�Ű���Ϣ[$i]['����'];
			$�Ű���Ա = $�Ű���Ϣ[$i]['�Ű���Ա'];
			$�Ű���Ϣ_ret[$�������][$�ܴ�][$����] = $�Ű���."-".$�Ű���Ա;
		}
		return $�Ű���Ϣ_ret;
	}
	//******************��ȡ�ܵ�����********************//
	function GetWeekCount()
	{
		global $db;
		global $ѧ������,$��ʼʱ��X,$����ʱ��X;
		$sql = "select ѧ������,��ʼʱ��,����ʱ�� from edu_xueqiexec where ��ǰѧ��=1";
		$rs = $db -> Execute($sql);
		$rs_a = $rs -> GetArray();
		if(!is_array($rs_a))
		$rs_a = array();
		$ѧ����Ϣ = $rs_a;
		$ѧ������ = $ѧ����Ϣ[0]['ѧ������'];
		$��ʼ���� = $ѧ����Ϣ[0]['��ʼʱ��'];
		$�������� = $ѧ����Ϣ[0]['����ʱ��'];
		$��ʼʱ��X = $ѧ����Ϣ[0]['��ʼʱ��'];
		$����ʱ��X = $ѧ����Ϣ[0]['����ʱ��'];
		$��ʼ��Ϣ = explode('-',$��ʼ����);
		$������Ϣ = explode('-',$��������);
		$��ʼ��� = $��ʼ��Ϣ[0];
		$��ʼ�·� = $��ʼ��Ϣ[1];
		$��ʼ��   = $��ʼ��Ϣ[2];
		$������� = $������Ϣ[0];
		$�����·� = $������Ϣ[1];
		$������   = $������Ϣ[2];
		$W_B_L = date("l",mktime(0,0,0,$��ʼ�·�,$��ʼ��,$��ʼ���));
		$W_E_L = date("l",mktime(0,0,0,$�����·�,$������,$�������));
		$SecondWeekDate = GetFirstWeek($��ʼ���,$��ʼ�·�,$��ʼ��,$W_B_L);
		$DescSecondWeekDate = GetLastWeek($�������,$�����·�,$������,$W_E_L);
		$Days = abs(strtotime($DescSecondWeekDate) - strtotime($SecondWeekDate))/86400+1;
		$Week_Count = $Days/7 + 2;
		$Return[] = $Week_Count;
		$Return[] = $ѧ������;
		$Return[] = $W_B_L;
		$Return[] = $W_E_L;
		return $Return;
	}

	function ����Ŀ������($�ܴ�,$����)
	{
		global $db;
		global $ѧ������,$��ʼʱ��X,$����ʱ��X;
		$��ʼ����Array = explode('-',$��ʼʱ��X);
		$��ѧʱ�������� = date("w",mktime(0,0,0,$��ʼ����Array[1],$��ʼ����Array[2],$��ʼ����Array[0]));
		$ʱ��� = ($�ܴ�-1)*7+$����-$��ѧʱ��������;
		$Ŀ��ʱ�� = date("Y-m-d",mktime(0,0,0,$��ʼ����Array[1],$��ʼ����Array[2]+$ʱ���,$��ʼ����Array[0]));
		return $Ŀ��ʱ��;
	}
	//***************��õ�һ�ܵ�����*****************//
	function GetFirstWeek($��ʼ���,$��ʼ�·�,$��ʼ��,$W_B_L)
	{
		$SecondWeekDate = "";
		switch($W_B_L)
		{
		  case 'Monday':$SecondWeekDate = date("Y-m-d",mktime(0,0,0,$��ʼ�·�,$��ʼ��+7,$��ʼ���));break;
		  case 'Tuesday':$SecondWeekDate = date("Y-m-d",mktime(0,0,0,$��ʼ�·�,$��ʼ��+6,$��ʼ���));break;
		  case 'Wednesday':$SecondWeekDate = date("Y-m-d",mktime(0,0,0,$��ʼ�·�,$��ʼ��+5,$��ʼ���));break;
		  case 'Thursday':$SecondWeekDate = date("Y-m-d",mktime(0,0,0,$��ʼ�·�,$��ʼ��+4,$��ʼ���));break;
		  case 'Friday':$SecondWeekDate = date("Y-m-d",mktime(0,0,0,$��ʼ�·�,$��ʼ��+3,$��ʼ���));break;
		  case 'Saturday':$SecondWeekDate = date("Y-m-d",mktime(0,0,0,$��ʼ�·�,$��ʼ��+2,$��ʼ���));break;
		  case 'Sunday':$SecondWeekDate = date("Y-m-d",mktime(0,0,0,$��ʼ�·�,$��ʼ��+1,$��ʼ���));break;
		}
		return $SecondWeekDate;
	}
	//****************������һ�ܵ�����******************//
	function GetLastWeek($�������,$�����·�,$������,$W_E_L)
	{
		$DescSecondWeekDate = "";
		switch($W_E_L)
		{
		  case 'Monday':$DescSecondWeekDate = date("Y-m-d",mktime(0,0,0,$�����·�,$������-1,$�������));break;
		  case 'Tuesday':$DescSecondWeekDate = date("Y-m-d",mktime(0,0,0,$�����·�,$������-2,$�������));break;
		  case 'Wednesday':$DescSecondWeekDate = date("Y-m-d",mktime(0,0,0,$�����·�,$������-3,$�������));break;
		  case 'Thursday':$DescSecondWeekDate = date("Y-m-d",mktime(0,0,0,$�����·�,$������-4,$�������));break;
		  case 'Friday':$DescSecondWeekDate = date("Y-m-d",mktime(0,0,0,$�����·�,$������-5,$�������));break;
		  case 'Saturday':$DescSecondWeekDate = date("Y-m-d",mktime(0,0,0,$�����·�,$������-6,$�������));break;
		  case 'Sunday':$DescSecondWeekDate = date("Y-m-d",mktime(0,0,0,$�����·�,$������-7,$�������));break;
		}
		return $DescSecondWeekDate;
	}
?>
