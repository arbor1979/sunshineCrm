<?php
ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL);

// display warnings and errors
error_reporting(E_WARNING | E_ERROR);
require_once('lib.inc.php');//

$GLOBAL_SESSION=returnsession();
$SYSTEM_PRIV_STOP = 1;
	require_once("systemprivateinc.php");
	CheckSystemPrivate("������Դ-н�����-н������");

global $ѧ������;

page_css("н������");
$�û�ID = $_SESSION['LOGIN_USER_ID'];
list($Week_Count,$��ǰѧ��,$W_B_L,$W_E_L) = GetWeekCount();



//**********************ɾ����ѡ���趨����Ϣ***********************//
if($_GET['action']=="�����ϸ���н��"){
   $��ǰ�·� = $_GET['��ǰ�·�'];
   $m= $��ǰ�·�-1;
   $y=date('Y');
   detail($y,$m);
}
if($_GET['action'] == "Del")
{
	$�Ű��� = $_GET['�Ű���'];
	$��ǰ�·� = $_GET['��ǰ�·�'];
	$�������� = $_GET['��������'];
	$��ǰѧ�� = $_GET['��ǰѧ��'];

	$sql = "delete from hrms_salary where ���='$�Ű���'";
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
	$sql = "select ��Ա���� from hrms_salary_group where ���='$������'";
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
		$��ǰ�·� = $_POST['��ǰ�·�'];
		print_infor("������δ����Ա��Ϣ!",'',"location='?��ǰ�·�=$��ǰ�·�'");
		exit;
	}
	else
	{
		$��ǰѧ�� = $_POST['��ǰѧ��'];
		$��ǰ�·� = $_POST['��ǰ�·�'];
		$������� = $_POST['�������'];
		$�������� = $_POST['��������'];
		$��� = date("Y");
		$����ʱ�� = Date("Y-m-d H:i:s");

		$�Ű���ԱArray = explode(',',$�Ű���Ա);
		for($i=0;$i<sizeof($�Ű���ԱArray);$i++)		{
			$�Ű���ԱX = $�Ű���ԱArray[$i];
			$�Ű���Ա����[$�Ű���ԱX] = $�Ű���ԱX;
		}
		$�Ű���Ա����K = @array_keys($�Ű���Ա����);
		$�Ű���Ա = join(',',$�Ű���Ա����K);
		//print_R($�Ű���Ա);
		//exit;

		$sql = "insert into hrms_salary values('','".$��ǰѧ��."','$��ǰ�·�','$���','$�������','$��������','$�Ű���Ա','','$�û�ID','$����ʱ��')";
		$db -> Execute($sql);
		print "<meta http-equiv='refresh' content=1;url='?��ǰ�·�=".$��ǰ�·�."'>";
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
		$�Ű���Ա .= $�Ű���Ա��Ϣ_arr[1]."";
		if($i!=sizeof($name)-1)
		$�Ű���Ա .= ",";
	}
	if($�Ű���Ա == "")
	{
		$��ǰ�·� = $_POST['��ǰ�·�'];
		print_infor("��û��ѡ���κγ�Ա",'',"location='?��ǰ�·�=$��ǰ�·�'");
		exit;
	}
	else
	{

		$��ǰѧ�� = $_POST['��ǰѧ��'];
		$��ǰ�·� = $_POST['��ǰ�·�'];
		$������� = $_POST['�������'];
		$�������� = $_POST['��������'];
        $���=date("Y");
		$����ʱ�� = Date("Y-m-d H:i:s");

		$�Ű���ԱArray = explode(',',$�Ű���Ա);
		for($i=0;$i<sizeof($�Ű���ԱArray);$i++)		{
			$�Ű���ԱX = $�Ű���ԱArray[$i];
			$�Ű���Ա����[$�Ű���ԱX] = $�Ű���ԱX;
		}
		$�Ű���Ա����K = @array_keys($�Ű���Ա����);
		$�Ű���Ա = join(',',$�Ű���Ա����K);
		//print_R($�Ű���Ա);
		//exit;
		//��� �Ű��� ѧ������ ѧ������ �ܴ� �ܴ� ����  �������� ��α�� ������� ������� �Ű���Ա �Ű���Ա ��ע ��ע ������ ������ ����ʱ��
		$sql = "select ��� from hrms_salary where ѧ������='".$��ǰѧ��."' and �·�='".$��ǰ�·�."' and ��������='".$��������."'";
		$rs = $db -> Execute($sql);
		$��� = $rs->fields['���'];
		if($���!="")		{
			$sql = "update hrms_salary set �·�='$��ǰ�·�',�������='$�������',��������='$��������',������Ա='$�Ű���Ա',���='$���' where ���='$���'";
		}
		else	{
			$sql = "insert into hrms_salary values('','".$��ǰѧ��."','".$��ǰ�·�."','".$���."','".$�������."','".$��������."','".$�Ű���Ա."','','".$�û�ID."','".$����ʱ��."')";
		}
		//print $sql;exit;
		$db -> Execute($sql);
		print "<meta http-equiv='refresh' content=1;url='?��ǰ�·�=".$��ǰ�·�."'>";
		exit;
	}
}


//*******************ѡ���������������Ϣ***************//
if($_GET['action'] == "ChangeTeam")
{
		$������Ϣ = GetBanZuInfor();
		$��ǰѧ�� = $_GET['��ǰѧ��'];
		$��ǰ�·� = $_GET['��ǰ�·�'];
		$�������� = $_GET['��������'];
		$�������� = $_GET['��������'];


?>
<table width="80%" class="TableBlock" align="center">
<form name="ChangeTeam" method="post" action="?action=Change&type=team">
<tr class="TableHeader">
<td>���鰲��н��</td>
</tr>
<tr class="TableData">
<td>
&nbsp;<font color="red">��ǰѧ��:<?php echo $��ǰѧ��;?></font>&nbsp;<BR>


&nbsp;<font color="green">��ǰ�·�:<?php echo $��ǰ�·�;?></font>&nbsp;<BR>
&nbsp;<font color="blue">��ǰн����Ŀ:<?php echo $��������;?>
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

		$������� = $������Ϣ[$i]['�������'];
		if($i == 0)
			$Checked = "checked";
		else
			$Checked = "";
		print "<input type='radio' name='Team' value='".$������."' $Checked>".$�������."</input><BR>";
	}

?>
<input type="hidden" name="��ǰ�·�" value=<?php echo $��ǰ�·�;?> />
<input type="hidden" name="��ǰѧ��" value=<?php echo $��ǰѧ��;?> />
<input type="hidden" name="�������" value=<?php echo $�������;?> />

<input type="hidden" name="��������" value=<?php echo $��������;?> />
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
		$��ǰ�·� = $_GET['��ǰ�·�'];
		$�������� = $_GET['��������'];
		$�������� = $_GET['��������'];



		//�γ��Ѽ�����Ա�б�

		$sql = "select * from hrms_salary where ѧ������='".$��ǰѧ��."' and �·�='".$��ǰ�·�."' and ��������='".$��������."'";
		$rs = $db -> Execute($sql);
		$rs_a = $rs -> GetArray();
		$�Ű���Ա = $rs_a[0]['������Ա'];
		$������Ա = $�Ű���Ա;
		$�Ű���Ա����K = explode(',',$�Ű���Ա);
?>

<table width="80%" class="TableBlock" align="center">
<form name="ChangeTeam" method="post" action="?action=Change&type=worker">
<tr class="TableHeader">
<td>����Ա����н��</td>
</tr>
<tr class="TableData">
<td><font color="red">&nbsp;��ǰѧ��:<?php echo $��ǰѧ��;?></font>&nbsp;<BR>&nbsp;<font color="green">��ǰ�·�:��<?php echo $��ǰ�·�;?>��</font>&nbsp;<BR>
&nbsp;<font color="blue">��������:<?php echo $��������;?>(<?php echo $�������;?>)</font>
<BR>&nbsp;<font color="blue">������Ա:<?php echo $������Ա;?></font>
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
				if(in_array($�Ű���Ա,$�Ű���Ա����K))		{
					if($j!=sizeof($��Ա����_arr)-1)
					{
						$SHOWTEXT .= "<input type='checkbox' name='name[]' checked value='".$�������."-".$��Ա����_arr[$j]."' $Checked>".$��Ա����_arr[$j]."-".$�������."</input>&nbsp;";
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
						$SHOWTEXT2 .= "<input type='checkbox' name='name[]' value='".$�������."-".$��Ա����_arr[$j]."' $Checked>".$��Ա����_arr[$j]."-".$�������."</input>&nbsp;";
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

	?>

<input type="hidden" name="��ǰѧ��" value=<?php echo $��ǰѧ��;?> />
<input type="hidden" name="��ǰ�·�" value=<?php echo $��ǰ�·�;?> />
<input type="hidden" name="�������" value=<?php echo $�������;?> />
<input type="hidden" name="��������" value=<?php echo $��������;?> />
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
<td>ѡ��н���·�</td>
</tr>
<tr class="TableData">
<td>��&nbsp;
<?php
	$_GET['��ǰ�·�'] != "" ? '' : $_GET['��ǰ�·�'] = returncurmonthindex($datetime=date("Y-m-d"));
	$��ǰ�·� = $_GET['��ǰ�·�'];


	for($i=0;$i<12;$i++)
	{
		if($i+1 == $��ǰ�·�)
		print "<a href='?��ǰ�·�=".($i+1)."' target='_self'><font color=red>".($i+1)."</font></a>&nbsp;&nbsp;";
		else
		print "<a href='?��ǰ�·�=".($i+1)."' target='_self'>".($i+1)."</a>&nbsp;&nbsp;";
	}
?>
    ��<!--<a href="hrms_salary_.php">hello</a>--></td>
</tr>
</table>
<br />
<?php

	$��ǰ�·� = $_GET['��ǰ�·�'];
	$�����·� = $��ǰ�·�-1;
	$sql = "select * from hrms_salary where �·�='$�����·�' and ѧ������='$��ǰѧ��'";
	$rs = $db -> Execute($sql);
	$rs_a = $rs -> GetArray();
	//����
	$sql = "select * from hrms_salary where �·�='$��ǰ�·�' and ѧ������='$��ǰѧ��'";
	$rs = $db -> Execute($sql);
	$rs_a���� = $rs -> GetArray();

	if($_GET['action']=="�����»�ȡ����"&&$_GET['��ǰ�·�']!="")								{
		//print_R($rs_a);exit;
		for($i=0;$i<sizeof($rs_a);$i++)
		{
			$���= $rs_a[$i]['���'];
			$�������� = $rs_a[$i]['��������'];
            $������� = $rs_a[$i]['�������'];

			$������Ա = $rs_a[$i]['������Ա'];
			$��ע = $rs_a[$i]['��ע'];
			$������ = $rs_a[$i]['������'];
			$����ʱ�� = date("Y-m-d H:i:s");;

			$������Ա���� = array();
			$������ԱArray = explode(',',$������Ա);
			for($iX=0;$iX<sizeof($������ԱArray);$iX++)		{
				$�Ű���ԱX = $������ԱArray[$iX];
				$������Ա����[$�Ű���ԱX] = $�Ű���ԱX;
			}
			$�Ű���Ա����K = @array_keys($������Ա����);
			$������Ա = join(',',$�Ű���Ա����K);
			//print_R($�Ű���Ա);
			//exit;
			//$sql = "select COUNT(*) AS NUM from edu_xingzheng_paiban where ѧ������='$��ǰѧ��' and ����='$����' and ��������='$��������' and �ܴ�='$��ǰ�ܴ�'";

			//$rs = $db -> Execute($sql);
			//$NUM = $rs->fields['NUM'];
			//if($NUM==0)	{
			$sql = "insert into hrms_salary values('','$��ǰѧ��','$��ǰ�·�','$���','$�������','$��������','$������Ա','$��ע','$������','$����ʱ��')";
			$db -> Execute($sql);
			//print $sql."<BR>";
			//}

		}
		print_infor("��������Ѿ���ʼ�����.",'',"location='?��ǰ�·�=".$��ǰ�·�."'");
		print "<meta http-equiv='refresh' content=0;url='?��ǰ�·�=".$��ǰ�·�."'>";
		exit;
	}
	//exit;
	//print_R($rs_a);
	//����������,������������,����ֹͣ���붯��
	$m=date("m");
	if(sizeof($rs_a)==0||sizeof($rs_a����)>0||$��ǰ�·�!=$m)		{
		//û�м�¼,���ܻ�ȡ����
		$disabled = "disabled readonly title='�����Ѿ������ݻ�����������,���ܴ����»�ȡ��Ϣ'";
	}
$qq="select * from hrms_salary_detail where ѧ������='$��ǰѧ��' and �·�='".$�����·�."'";
$qqrs = $db -> Execute($qq);
	$qqdata = $qqrs -> GetArray();
        if(sizeof($qqdata)==0&&sizeof($rs_a)>0)
            $able='';
            else
            $able = "disabled readonly title=''";
?>
<table width="100%" class="TableBlock" align="center">
<tr class="TableHeader">
<td colspan=2>
����н�����
��ǰ�·�: <?php echo $��ǰ�·�?>

<input name='�����»�ȡ����' value='�ӵ�<?php echo ($��ǰ�·�-1)?>�»�ȡн������' class=SmallButton type=Button OnClick="location='?��ǰ�·�=<?php echo $��ǰ�·�?>&action=�����»�ȡ����'" <?php echo $disabled?>>
<input name='�����ϸ���н��' value='����<?php echo ($��ǰ�·�-1)?>��н������' class=SmallButton type=Button OnClick="location='?��ǰ�·�=<?php echo $��ǰ�·�?>&action=�����ϸ���н��'" <?php echo $able?>>
</td>
</tr>
<tr class="TableData" align="center">
	<td width="20%">н������\�·�</td>
	<td width="80%"><?php echo $��ǰ�·�?></td>

</tr>
<?php
	$н����Ŀ��Ϣ = GetBanCiInfor();
   // print_r($н����Ŀ��Ϣ);
   //print sizeof($н����Ŀ��Ϣ);
	for($i=0;$i<sizeof($н����Ŀ��Ϣ);$i++)
	{
		$������� = $н����Ŀ��Ϣ[$i]['�������'];
        $�������� = $н����Ŀ��Ϣ[$i]['��������'];

       // print_r($$н����Ŀ��Ϣ[0]['��������']);
		$ָ������������Ϣ = GetPaiBanInfor($��ǰѧ��,$��ǰ�·�,$��������);
       // print_r($ָ������������Ϣ);
		print "<tr class=TableData align=center>";
		print "<td>".$��������."(".$�������.")</td>";


			$�Ű����� = explode("-",$ָ������������Ϣ);

			$�Ű��� = $�Ű�����[0];
			$�Ű���Ա = $�Ű�����[1];
          //  print $�Ű���Ա;
			print "<td>";
			if($��ǰ�·�==date("m"))		{
				if($�Ű���Ա=="")
				{
					print "<a href='?action=ChangeTeam&��������=".$��������."&�������=".$�������."&��ǰѧ��=".$��ǰѧ��."&��ǰ�·�=".$��ǰ�·�."'>ѡ������</a><br />
										   <a href='?action=ChangeWorker&��������=".$��������."&�������=".$�������."&��ǰѧ��=".$��ǰѧ��."&��ǰ�·�=".$��ǰ�·�."'>ѡ������Ա</a>";
				}
				else
				{
					$�Ű���ԱTEXT = substr_cut($�Ű���Ա,120);
					print "".$�Ű���ԱTEXT."<br /><a href='?action=Del&��������=".$��������."&�Ű���=".$�Ű���."&��ǰ�·�=".$��ǰ�·�."'><font color=red>ɾ��</font><BR><a href='?action=ChangeWorker&��������=".$��������."&�������=".$�������."&��ǰѧ��=".$��ǰѧ��."&��ǰ�·�=".$��ǰ�·�."'>ѡ������Ա</a>";
				}
			}
			else	{
				print "<font color=gray>�ǹ���ʱ��</font>";
			}
			print "</td>";

		print "</tr>";
	}

?>
</table>
<?php

	//******************��ȡ���е���Ա��Ϣ********************//
	function GetWorkerInfor()
	{
		global $db;
		$sql = "select ���,�������,��Ա���� from hrms_salary_group order by ���";
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
		$sql = "select ���,�������,��Ա���� from hrms_salary_group";
		$rs = $db -> Execute($sql);
		$rs_a = $rs -> GetArray();
		if(!is_array($rs_a))
		$rs_a = array();
		$������Ϣ = $rs_a;
		return $������Ϣ;
	}
	//******************������е�н����Ŀ��Ϣ********************//
	function GetBanCiInfor()
	{
		global $db;
		$sql = "select �������,�������� from hrms_salary_type";
		$rs = $db -> Execute($sql);
		$rs_a = $rs -> GetArray();
		if(!is_array($rs_a))
		$rs_a = array();
		$н����Ŀ��Ϣ = $rs_a;
		return $н����Ŀ��Ϣ;
	}
	//******************���ָ���������Ƶ�н����Ŀ��Ϣ********************//
	function GetPaiBanInfor($��ǰѧ��,$��ǰ�·�,$��������)
	{
		global $db;
		$sql = "select * from hrms_salary where ѧ������='".$��ǰѧ��."' and �·�=".$��ǰ�·�." and ��������='".$��������."'";
		$rs = $db -> Execute($sql);
		$rs_a = $rs -> GetArray();
		if(!is_array($rs_a))
		$rs_a = array();
		$�Ű���Ϣ = $rs_a;
		for($i=0;$i<sizeof($�Ű���Ϣ);$i++)
		{
			$���ñ�� = $�Ű���Ϣ[$i]['���'];

			$�������� = $�Ű���Ϣ[$i]['��������'];
			$�·� = $�Ű���Ϣ[$i]['�·�'];
			$������� = $�Ű���Ϣ[$i]['�������'];
			$������Ա = $�Ű���Ϣ[$i]['������Ա'];
			//$ָ������������Ϣ_ret[$�������][$��������][$�·�] = $���ñ��."-".$������Ա;
            $ָ������������Ϣ_ret= $���ñ��."-".$������Ա;
		}
		return $ָ������������Ϣ_ret;
	}
		//���ص�ǰ�·�
function returncurmonthindex(){
    $date=date("Y-m-d");
	$date=explode("-",$date);
	$month=$date[1];
	return $month;}


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




        function detail($y,$m){
global $db;
$sql="select ѧ������,�·�,���,�������,��������,������Ա,��ע,������,����ʱ�� from hrms_salary where �·�='".$m."'and ���='".$y."'";
$rs=$db->Execute($sql);
while (!$rs->EOF){
    $name=explode(',',$rs->fields['������Ա']);
   // print_r($name);print $rs->fields['��������'];
    if($rs->fields['��������'] != ''){
        $salary=$db->Execute("select ��� from hrms_salary_type where ��������='".$rs->fields['��������']."'");
        while(!$salary->EOF){$money=$salary->fields['���'];$salary->MoveNext();}$salary->Close();
    }

    for($i=0;$i<sizeof($name);$i++){
        $detailsql="insert into hrms_salary_detail(ѧ������,�·�,���,�������,��������,���,������Ա,��ע,������,����ʱ��) values('".$rs->fields['ѧ������']."',".$rs->fields['�·�'].",".$rs->fields['���'].",'".$rs->fields['�������']."','".$rs->fields['��������']."',".$money.",'".$name[$i]."','".$rs->fields['��ע']."','".$rs->fields['������']."','".$rs->fields['����ʱ��']."')";
      // $db->Execute($detailsql);
	   if($db->Execute($detailsql)) {
		  // echo '<script>alert("success")</script>';
       $bmsql="select DEPT_NAME from department where DEPT_ID=(select DEPT_ID from user where USER_NAME='".$name[$i]."')";
      $bmrs=$db->Execute($bmsql);
        while(!$bmrs->EOF){$bm=$bmrs->fields['DEPT_NAME'];$bmrs->MoveNext();}$bmrs->Close();
        $num=$db->Execute("select * from hrms_salary_tongji where ����='".$name[$i]."' and ���='".$y."'");
        $num=$num->RecordCount();
                 if($num==0){
				 if($m==1)
       $sql="insert into hrms_salary_tongji(��������,����,���,һ��) values('".$bm."','".$name[$i]."','".$y."','".$money."')";
        if($m==2)
       $sql="insert into hrms_salary_tongji(��������,����,���,����) values('".$bm."','".$name[$i]."','".$y."','".$money."')";
         if($m==3)
       $sql="insert into hrms_salary_tongji(��������,����,���,����) values('".$bm."','".$name[$i]."','".$y."','".$money."')";
          if($m==4)
       $sql="insert into hrms_salary_tongji(��������,����,���,����) values('".$bm."','".$name[$i]."','".$y."','".$money."')";
 if($m==5)
       $sql="insert into hrms_salary_tongji(��������,����,���,����) values('".$bm."','".$name[$i]."','".$y."','".$money."')";
 if($m==6)
       $sql="insert into hrms_salary_tongji(��������,����,���,����) values('".$bm."','".$name[$i]."','".$y."','".$money."')";
 if($m==7)
       $sql="insert into hrms_salary_tongji(��������,����,���,����) values('".$bm."','".$name[$i]."','".$y."','".$money."')";
 if($m==8)
       $sql="insert into hrms_salary_tongji(��������,����,���,����) values('".$bm."','".$name[$i]."','".$y."','".$money."')";
 if($m==9)
       $sql="insert into hrms_salary_tongji(��������,����,���,����) values('".$bm."','".$name[$i]."','".$y."','".$money."')";
 if($m==10)
       $sql="insert into hrms_salary_tongji(��������,����,���,ʮ��) values('".$bm."','".$name[$i]."','".$y."','".$money."')";
 if($m==11)
       $sql="insert into hrms_salary_tongji(��������,����,���,ʮһ��) values('".$bm."','".$name[$i]."','".$y."','".$money."')";
 if($m==12)
       $sql="insert into hrms_salary_tongji(��������,����,���,ʮ����) values('".$bm."','".$name[$i]."','".$y."','".$money."')";


				 }
				 else{
				  if($m==1)
        $sql="update hrms_salary_tongji set һ��=һ��+'".$money."' where ����='".$name[$i]."' and ���='".$y."'";
           if($m==2)
        $sql="update hrms_salary_tongji set ����=����+'".$money."' where ����='".$name[$i]."' and ���='".$y."'";

           if($m==3)
        $sql="update hrms_salary_tongji set ����=����+'".$money."' where ����='".$name[$i]."' and ���='".$y."'";
            if($m==4)
        $sql="update hrms_salary_tongji set ����=����+'".$money."' where ����='".$name[$i]."' and ���='".$y."'";
            if($m==5)
        $sql="update hrms_salary_tongji set ����=����+'".$money."' where ����='".$name[$i]."' and ���='".$y."'";
           if($m==6)
        $sql="update hrms_salary_tongji set ����=����+'".$money."' where ����='".$name[$i]."' and ���='".$y."'";
           if($m==7)
        $sql="update hrms_salary_tongji set ����=����+'".$money."' where ����='".$name[$i]."' and ���='".$y."'";
           if($m==8)
        $sql="update hrms_salary_tongji set ����=����+'".$money."' where ����='".$name[$i]."' and ���='".$y."'";
           if($m==9)
        $sql="update hrms_salary_tongji set ����=����+'".$money."' where ����='".$name[$i]."' and ���='".$y."'";
           if($m==10)
        $sql="update hrms_salary_tongji set ʮ��=ʮ��+'".$money."' where ����='".$name[$i]."' and ���='".$y."'";
           if($m==11)
        $sql="update hrms_salary_tongji set ʮһ��=ʮһ��+'".$money."' where ����='".$name[$i]."' and ���='".$y."'";
           if($m==12)
        $sql="update hrms_salary_tongji set ʮ����=ʮ����+'".$money."' where ����='".$name[$i]."' and ���='".$y."'";

				 }
				 $db->Execute($sql);
	   } //if

    }//forѭ������


    $rs->MoveNext();
}//whileѭ������
$rs->Close();

 echo '<script>alert("������ɣ�")</script>';
}//function����

?>
