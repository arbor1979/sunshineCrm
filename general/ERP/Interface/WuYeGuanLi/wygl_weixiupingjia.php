<?php
	ini_set('display_errors', 1);
	ini_set('error_reporting', E_ALL);

	// display warnings and errors
	error_reporting(E_WARNING | E_ERROR);

	require_once("lib.inc.php");
	$GLOBAL_SESSION=returnsession();
	page_css("��ҵ����_ά������");


	//*****************��ȡ��ʦ��Ϣ*****************//
	$��ʦID = $_SESSION['LOGIN_USER_ID'];
	$��ʦ���� = $_SESSION['LOGIN_USER_NAME'];

	//*******************������Ϣҳ��*******************//
	if($_GET['action'] == "see")
	{
		$���ޱ�� = $_GET['���ޱ��'];
		$sql = "select ��ǰѧ��,¥������,¥������,¥����ַ,������Ŀ,��������,ά��״̬ from wygl_baoxiuxinxi where ά��״̬ ='��' and ���=".$���ޱ��;
		$rs = $db -> Execute($sql);
		$rs_a = $rs -> GetArray();
		$������Ϣ = $rs_a;
		if(sizeof($������Ϣ)>0)
		{
			$����ѧ�� = $������Ϣ[0]['��ǰѧ��'];
			$¥������ = $������Ϣ[0]['¥������'];
			$¥������ = $������Ϣ[0]['¥������'];
			$¥����ַ = $������Ϣ[0]['¥����ַ'];
			$������Ŀ = $������Ϣ[0]['������Ŀ'];
			$�������� = $������Ϣ[0]['��������'];
			$ά��״̬ = $������Ϣ[0]['ά��״̬'];

			$������Ϣ_var = "<Tr class=TableData><Td width=30% align=center><font color='red'>��ǰ���</font></Td><Td width=70% align=center><font color='red'>".$����ѧ��."</font></Td></Tr>";
			$������Ϣ_var .= "<Tr class=TableData><Td width=30% align=center><font color='green'>¥������</Td><Td width=70% align=center><font color='green'>".$¥������."</font></Td></Tr>";
			$������Ϣ_var .= "<Tr class=TableData><Td width=30% align=center><font color='red'>¥������</Td><Td width=70% align=center><font color='red'>".$¥������."</font></Td></Tr>";
			$������Ϣ_var .= "<Tr class=TableData><Td width=30% align=center><font color='green'>¥����ַ</Td><Td width=70% align=center><font color='green'>".$¥����ַ."</font></Td></Tr>";
			$������Ϣ_var .= "<Tr class=TableData><Td width=30% align=center><font color='red'>������Ŀ</Td><Td width=70% align=center><font color='red'>".$������Ŀ."</font></Td></Tr>";
			$������Ϣ_var .= "<Tr class=TableData><Td width=30% align=center><font color='green'>��������</Td><Td width=70% align=center><font color='green'>".$��������."</font></Td></Tr>";
			$������Ϣ_var .= "<Tr class=TableData><Td width=30% align=center><font color='red'>ά��״̬</Td><Td width=70% align=center><font color='red'>".$ά��״̬."</font></Td></Tr>";

			$sql = "select ��������,���۵ȼ� from wygl_weixiupingjia where ά�ޱ��=".$���ޱ��;
			$rs = $db -> Execute($sql);
			$rs_a = $rs -> GetArray();
			$������Ϣ = $rs_a;

			$������Ϣ_var = "";
			for($i=0;$i<sizeof($������Ϣ);$i++)
			{
				if($i%2 == 0)
					$Color = "red";
				else
					$Color = "green";
				$�������� = $������Ϣ[$i]['��������'];
				$���۵ȼ� = $������Ϣ[$i]['���۵ȼ�'];
				$������Ϣ_var .= "<Tr class=TableData><Td width=30% align=center><font color='".$Color."'>".$��������."</font></Td><Td width=70% align=center><font color='".$Color."'>".$���۵ȼ�."</Td></font></Tr>";
			}

			print "<Center><Table class=TableBlock width=100%>";
			print "<Tr class=TableHeader><Td colspan=4>���ı�����Ϣ</Td></Tr>";
			print $������Ϣ_var;
			print "</Table><Br>";
			print "<Table class=TableBlock width=100%>";
			print "<Tr class=TableHeader><Td colspan=4>����������Ϣ</Td></Tr>";
			print $������Ϣ_var;
			print "</Table><Br>";
			print "<Input type='button' class=SmallButton onClick='window.print();' value='��ӡ'></Input>&nbsp;&nbsp;";
			print "<Input type='button' class=SmallButton onClick='history.back();' value='����'></Input></Center>";
		}
	}
	//*******************���۲���ҳ��*******************//
	if($_GET['action'] == "evaluate")
	{
		$���ޱ�� = $_GET['���ޱ��'];

		$sql = "select distinct �������� from wygl_pingjialeixing";
		$rs = $db -> Execute($sql);
		$rs_a = $rs -> GetArray();
		if(!is_array($rs_a))
		$rs_a = array();
		$�������� = $rs_a;

		$sql = "select distinct ��������,���۵ȼ� from wygl_pingjialeixing";
		$rs = $db -> Execute($sql);
		$rs_a = $rs -> GetArray();
		if(!is_array($rs_a))
		$rs_a = array();
		$���۵ȼ� = $rs_a;

		for($i=0;$i<sizeof($��������);$i++)
		{
			if($i%2 == 0)
				$color = "red";
			else
				$color = "green";

			$��������_var = $��������[$i]['��������'];

			$���۵ȼ�_var = "";
			$Check = "";
			$Flag_var = 0;
			for($j=0;$j<sizeof($���۵ȼ�);$j++)
			{
				if($��������[$i]['��������'] == $���۵ȼ�[$j]['��������'])
				{
					if($Flag_var==0)
						$Check = "checked";
					else
						$Check = "";
					$���۵ȼ�_var .= "<Input Type='radio' name='".$��������_var."' value='".$���۵ȼ�[$j]['���۵ȼ�']."' ".$Check.">".$���۵ȼ�[$j]['���۵ȼ�']."</Input>";
					$Flag_var ++;
				}
				//print $���۵ȼ�_var."&nbsp;".$j."&nbsp;".$Check."<Br>";
			}

			$��������_tr_arr[$i] = "<Tr class=TableData>";
			$��������_tr_arr[$i] .= "<Td width=30% align=center><font color=".$color.">".$��������_var."</font></Td>";
			$��������_tr_arr[$i] .= "<Td width=70% align=center><font color=".$color.">".$���۵ȼ�_var."</font></Td>";
			$��������_tr_arr[$i] .= "</Tr>";
		}

		$�ύ_sub .= "<Input Type='submit' class=SmallButton value='�ύ����'>";
		$����_res .= "<Input Type='reset' class=SmallButton value='������Ϣ'>";

		print "<Center><Form Id='Form1' Name='Form1' method=post action='?action=submit' onSubmit=\"return chkmsg();\">
			   <Table class=TableBlock width=100%>";
		print "<Tr class=TableHeader><Td colspan=2>ά����Ϣ����</Td></Tr>";
		print "<Tr class=TableData><Td align=center>��������</Td><Td align=center>���۵ȼ�</Td></Tr>";
		for($i=0;$i<sizeof($��������_tr_arr);$i++)
		{
			print $��������_tr_arr[$i];
		}
		print "</Table><Br>";
		print "<Input type='hidden' name='���ޱ��' value='".$���ޱ��."'></Input>";
		print $�ύ_sub."&nbsp;&nbsp;".$����_res."</Form></Center>";
	}
		//***********ִ�в���***********//
	if($_GET['action'] == "submit")
	{
		$���ޱ�� = $_POST['���ޱ��'];
		$�������� = @array_keys($_POST);
		$���۵ȼ� = @array_values($_POST);
		for($i=0;$i<sizeof($_POST)-1;$i++)
		{
			$������ = $��ʦID;
			$��ע = "";
			$������ = $��ʦID;
			$����ʱ�� = Date("Y-m-d H:i:s");
			$��������_var = $��������[$i];
			$���۵ȼ�_var = $���۵ȼ�[$i];
			$sql = "insert into wygl_weixiupingjia values('',".$���ޱ��.",'".$��������_var."','".$������."','".$���۵ȼ�_var."','".$��ע."','".$������."','".$����ʱ��."')";
			$db -> Execute($sql);
		}
		$sql = "update wygl_baoxiuxinxi set �Ƿ�����='��' where ���=".$���ޱ��;
		$db -> Execute($sql);
		print_infor("���۳ɹ�!");
		print "<meta http-equiv=\"REFRESH\" content=\"0 URL=?\">";
	}

	//*******************������Ϣҳ��*******************//
	//*****************��ȡ������Ϣ*****************//
	if($_GET['action'] == "")
	{
		$sql = "select * from wygl_baoxiuxinxi where ������='".$��ʦID."' order by ��� desc";
		$rs = $db -> Execute($sql);
		$rs_a = $rs -> GetArray();
		if(!is_array($rs_a))
		$rs_a = array();
		$������Ϣ = $rs_a;

		for($i=0;$i<sizeof($������Ϣ);$i++)
		{
			if($i%2 == 0)
				$color = "red";
			else
				$color = "green";
			$���ޱ�� = $������Ϣ[$i]['���'];
			$����ѧ�� = $������Ϣ[$i]['��ǰѧ��'];
			$¥������ = $������Ϣ[$i]['¥������'];
			$¥������ = $������Ϣ[$i]['¥������'];
			$¥����ַ = $������Ϣ[$i]['¥����ַ'];
			$������Ŀ = $������Ϣ[$i]['������Ŀ'];
			$�������� = $������Ϣ[$i]['��������'];
			$�Ƿ����� = $������Ϣ[$i]['�Ƿ�����'];
			$ά��״̬ = $������Ϣ[$i]['ά��״̬'];
			$��������ϵ��ʽ = $������Ϣ[$i]['��������ϵ��ʽ'];
			$�Ƿ����� = $������Ϣ[$i]['�Ƿ�����'];

			$������Ϣ_tr_arr[$i] = "<Tr class=TableData>";
			$������Ϣ_tr_arr[$i] .= "<Td align=center nowrap><font color=".$color.">".$���ޱ��."</font></Td>";
			$������Ϣ_tr_arr[$i] .= "<Td align=center nowrap><font color=".$color.">".$����ѧ��."</font></Td>";
			$������Ϣ_tr_arr[$i] .= "<Td align=center nowrap><font color=".$color.">".$¥������."</font></Td>";
			$������Ϣ_tr_arr[$i] .= "<Td align=center nowrap><font color=".$color.">".$¥������."</font></Td>";
			$������Ϣ_tr_arr[$i] .= "<Td align=center nowrap><font color=".$color.">".$¥����ַ."</font></Td>";
			$������Ϣ_tr_arr[$i] .= "<Td align=center nowrap><font color=".$color.">".$������Ŀ."</font></Td>";
			$������Ϣ_tr_arr[$i] .= "<Td align=center nowrap><font color=".$color.">".$��������."</font></Td>";
			$������Ϣ_tr_arr[$i] .= "<Td align=center nowrap><font color=".$color.">".$��������ϵ��ʽ."</font></Td>";
			$������Ϣ_tr_arr[$i] .= "<Td align=center nowrap><font color=".$color.">".$�Ƿ�����."</font></Td>";
			$������Ϣ_tr_arr[$i] .= "<Td align=center nowrap><font color=".$color.">".$ά��״̬."</font></Td>";
			if($�Ƿ����� == "��"&&$ά��״̬=="��")
			{
				$������Ϣ_tr_arr[$i] .= "<Td align=center nowrap><a href=\"?action=see&���ޱ��=".$���ޱ��."\"><font color=blue>�鿴����</font></a></Td>";
			}
			else if($�Ƿ����� == "��"&&$ά��״̬=="��")
			{
				$������Ϣ_tr_arr[$i] .= "<Td align=center nowrap><a href=\"?action=evaluate&���ޱ��=".$���ޱ��."\"><font color=orange>��������</font></a></Td>";
			}
			else		{
				$������Ϣ_tr_arr[$i] .= "<Td align=center nowrap>&nbsp;ά����ʱ��������</a></Td>";
			}
			$������Ϣ_tr_arr[$i] .= "</Tr>";
		}

		//*****************��ʾ������Ϣ*****************//
		print "<Center><Table class=TableBlock width=100%>";
		print "<Tr class=TableHeader><Td colspan=11>ά����Ϣ����</Td></Tr>";
		print "<Tr class=TableData>
			   <Td align=center nowrap>���ޱ��</Td><Td align=center nowrap>��ǰ���</Td><Td align=center nowrap nowrap>¥������</Td>
			   <Td align=center nowrap>¥������</Td><Td nowrap align=center>¥����ַ</Td><Td align=center nowrap>������Ŀ</Td>
			   <Td align=center nowrap>��������</Td><Td nowrap align=center>��������ϵ��ʽ</Td>
			   <Td align=center nowrap>�Ƿ�����</Td><Td nowrap align=center>ά��״̬</Td>
			   <Td align=center nowrap>���۲���</Td></Tr>";
		for($i=0;$i<sizeof($������Ϣ_tr_arr);$i++)
		{
			print $������Ϣ_tr_arr[$i];
		}
		print "</Table></br>";
		print "<input type=button class=SmallButton value=���� onClick='history.back();'></Center>";
	}
?>