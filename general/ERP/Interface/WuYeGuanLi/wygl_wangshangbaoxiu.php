<?php
	ini_set('display_errors', 1);
	ini_set('error_reporting', E_ALL);

	// display warnings and errors
	error_reporting(E_WARNING | E_ERROR);

	require_once("lib.inc.php");
	$GLOBAL_SESSION=returnsession();
	page_css("��ҵ����_���ϱ���");

?>
<script>
	function chkmsg()
	{
		if(document.getElementById('address').value=="")
		{
			alert('����д�����¥�������ַ');
			return false;
		}
		else if(document.getElementById('content').value=="")
		{
			alert('����д��������');
			return false;
		}
		else return true;
	}
</script>
<?php
	//*****************��ȡ��ʦ��Ϣ*****************//
	$��ʦID = $_SESSION['LOGIN_USER_ID'];
	$��ʦ���� = $_SESSION['LOGIN_USER_NAME'];

	//*****************��ǰѧ����Ϣ*****************//
	$sql = "select ѧ������ from edu_xueqiexec where ��ǰѧ��='1'";
	$rs = $db -> Execute($sql);
	$��ǰѧ�� = $rs -> fields['ѧ������'];

	//***********��ȡGET����URL�Ĳ�����Ϣ***********//
	$¥������_get = $_GET['¥������'];

	if($_GET['¥������']=="")
	{
		$_GET['¥������'] = "����";
		$¥������_get = $_GET['¥������'];
	}

	//*******************��Ϣ�ύ*******************//
	if($_GET['action'] == "submit")
	{
		$������ = $��ʦID;
		$������ = $��ʦID;
				//********��������********//
		$����ʱ�� = Date("Y-m-d");

				//********����ʱ��********//
		$����ʱ�� = Date("Y-m-d H:i:s");

			    //**POST����URL�Ĳ�����Ϣ*//
		$¥������_post = $_POST['¥������'];
		$¥������_post = $_POST['¥������'];
		$¥����ַ_post = $_POST['¥����ַ'];
		$������Ŀ_post = $_POST['������Ŀ'];
		$��������_post = $_POST['��������'];
		$��������ϵ��ʽ = $_POST['��������ϵ��ʽ'];

				//********ִ�в���********//
		$sql = "insert into wygl_baoxiuxinxi(��ǰѧ��,¥������,¥������,¥����ַ,������Ŀ,��������,������,
			    ����ʱ��,�Ƿ�����,ά��״̬,�Ƿ�����,��ע,������,����ʱ��,��������ϵ��ʽ) values('".$��ǰѧ��."','".$¥������_post."','".$¥������_post."','".$¥����ַ_post."','".$������Ŀ_post."','".$��������_post."','".$������."',
				'".$����ʱ��."','��','��','��','','".$������."','".$����ʱ��."','$��������ϵ��ʽ')";
		$db -> Execute($sql);

		$_GET = array();
		$_POST = array();
		print_infor("����ά����Ϣ�ɹ�");
		print "<meta http-equiv=\"REFRESH\" content=\"0 URL=?\">";
	}

	//*****************����ѡ����ʾ*****************//
	else if($_GET['action']=="")
	{
				//********¥������********//
		$¥������ = array();
		$¥������[0]['¥������'] = "����";
		$¥������[1]['¥������'] = "��ѧ�칫";

		$¥������_sel = "<Select name='¥������' class=SmallSelect  onChange=\"var jmpURL='?flag=jump&¥������=' + this.options[this.selectedIndex].value; if(jmpURL!='') {window.location=jmpURL;} else {this.selectedIndex=0;}\">";
		for($i=0;$i<sizeof($¥������);$i++)
		{
			if($¥������_get == $¥������[$i]['¥������'])
				$Selected = "selected";
			else
				$Selected = "";
			$¥������_sel .= "<Option ".$Selected." value='".$¥������[$i]['¥������']."'>".$¥������[$i]['¥������']."</Option>";
		}
		$¥������_sel .= "</Select>";

					//********¥������********//
		if($¥������_get == "����")
		$sql = "select ����¥���� as ¥������ from dorm_building";
		else if($¥������_get == "��ѧ�칫")
		$sql = "select ��ѧ¥���� as ¥������ from edu_building";
		$rs = $db -> Execute($sql);
		$rs_a = $rs -> GetArray();
		if(!is_array($rs_a))
		$rs_a = array();
		$¥������ = $rs_a;
		$¥������_sel = "<Select class=SmallSelect name='¥������' >";
		for($i=0;$i<sizeof($¥������);$i++)
		{
			$¥������_sel .= "<Option value='".$¥������[$i]['¥������']."'>".$¥������[$i]['¥������']."</Option>";
		}
		$¥������_sel .= "</Select>";

					//********¥����ַ********//
		$¥����ַ_inp = "<Input class=SmallInput id='address' name='¥����ַ' ></Input>";

					//********������Ŀ********//
		$������Ŀ = array();
		//$������Ŀ[0]['������Ŀ'] = "ˮ";
		//$������Ŀ[1]['������Ŀ'] = "��";
		//$������Ŀ[2]['������Ŀ'] = "�豸";
		//$������Ŀ[3]['������Ŀ'] = "����";
		$sql = "select ���� AS ������Ŀ from wygl_biaoxiuxiangmu";
		$rs = $db -> Execute($sql);
		$������Ŀ = $rs -> GetArray();
		$������Ŀ_sel = "<Select name='������Ŀ' class=SmallSelect >";
		for($i=0;$i<sizeof($������Ŀ);$i++)
		{
			$������Ŀ_sel .= "<Option value='".$������Ŀ[$i]['������Ŀ']."'>".$������Ŀ[$i]['������Ŀ']."</Option>";
		}
		$������Ŀ_sel .= "</Select>";

					//********��������********//
		$��������_tex .= "<TextArea id='content' Name='��������' Rows=5 Cols=45 style='width:84%;'></Textarea>";

					//******�ύ���ذ�ť******//
		$�ύ_sub .= "<Input Type='submit' class=SmallButton value='�ύ����'>";
		$����_res .= "<Input Type='reset' class=SmallButton value='������Ϣ'>";
		$����_but .="<input type='button' class='SmallButton' value='����' onclick='history.back()'>";
		$��������ϵ��ʽ = returntablefield("user","USER_ID",$��ʦID,"MOBIL_NO");
		//*******************��д��*******************//
		print "<Center>
			  <Form Id='Form1' Name='Form1' method=post action='?action=submit' onSubmit=\"return chkmsg();\">
			  <Table class=TableBlock width=80%>";
		print "<Tr class=TableHeader><Td colspan=4>���ϱ�����Ϣ��д</Td></Tr>";
		print "<Tr class=TableData><Td width=25% align=left>¥������:</Td><Td width=25% align=left>".$¥������_sel."</Td><Td width=25% align=left>¥������:</Td><Td width=25% align=left>".$¥������_sel."</Td></Tr>";
		print "<Tr class=TableData><Td width=25% align=left>¥����ַ:</Td><Td width=25% align=left>".$¥����ַ_inp."</Td><Td width=25% align=left>������Ŀ:</Td><Td width=25% align=left>".$������Ŀ_sel."</Td></Tr>";
		print "<Tr class=TableData><Td width=25% align=left>��������ϵ��ʽ:</Td><Td  colspan=3 align=left><input size=25 type=input class=SmallInput name=��������ϵ��ʽ value='$��������ϵ��ʽ'>(Ĭ��Ϊ�û����ֻ���)</Td></Tr>";
		print "<Tr class=TableData><Td align=left>��������</Td><Td colspan=3 align=left>".$��������_tex."</Td></Tr>";
		print "</Table><Br>";
		print $�ύ_sub."&nbsp;&nbsp;".$����_res."&nbsp;&nbsp;".$����_but."</Form></Center>";
	}



if($_GET['action']==''||$_GET['action']=='init_default'||$_GET['action']=='init_customer')		{
	$PrintText .= "<BR><table  class=TableBlock align=left width=100%>";
	$PrintText .= "<TR class=TableContent><td ><font color=green >

ʹ��˵����<BR>
&nbsp;&nbsp;�ٴ˲�����д������Ϣ,������Ϣ�Ľ��մ���ģ�����ں��ڹ���->����ά��->������Ϣ�н��й���<BR>
&nbsp;&nbsp;�����ά��֮��,����Զ�ά�޵���Ϣ�������ۡ�



</font></td></table>";
	print $PrintText;
}

?>