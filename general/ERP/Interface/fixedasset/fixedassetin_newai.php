<?php
require_once("lib.inc.php");

$GLOBAL_SESSION=returnsession();
	require_once("systemprivateinc.php");

	CheckSystemPrivate("���ڹ���-�̶��ʲ�-������ϸ");

/*
  ��� int(100)   ��  auto_increment
  �ʲ����� varchar(200) gbk_chinese_ci  ��
  �ʲ���� varchar(200) gbk_chinese_ci  ��
  �ʲ���� varchar(200) gbk_chinese_ci  ��
  �ɹ���ʶ varchar(200) gbk_chinese_ci  ��
  ��Ӧ�� varchar(200) gbk_chinese_ci  ��
  �������� varchar(200) gbk_chinese_ci  ��
  ʹ����Ա varchar(200) gbk_chinese_ci  ��
  �ʲ�ԭֵ varchar(200) gbk_chinese_ci  ��
  �������� date   ��
  �ͺŹ�� varchar(255) gbk_chinese_ci  ��
  ����״̬ varchar(20) gbk_chinese_ci  �� ����δ����
  ��ע varchar(255) gbk_chinese_ci  ��
  ������ varchar(200) gbk_chinese_ci  ��
  ����ʱ��

*/

if($_GET['action']=="add_default_data")		{
	page_css('�ɹ�');
	$�������� = $_POST['��������'];
	$�ɹ���ʶ = $_POST['�ɹ���ʶ'];
	$��׼�� = $_POST['��׼��'];
	$���� = $_POST['����'];
	$������ = $_POST['������'];
	$����ʱ�� = $_POST['����ʱ��'];
	if($��׼��!=""&&$����>0)	{
		//print_R($_POST);exit;
		for($i=1;$i<=$����;$i++)			{

			//�õ��ʲ����
			$sql = "select * from fixedasset where �ʲ�����='$�ɹ���ʶ' and ����״̬!='�ʲ��ѱ���' order by ��� desc limit 1";
			$rs = $db->Execute($sql);
			$�ʲ���� = $rs->fields['�ʲ����'];
			//print $�ʲ����;
			if($�ʲ����!="")			{
				$�ʲ����ǰ׺ = substr($�ʲ����,0,-3);
				$�ʲ���ź�׺ = substr($�ʲ����,-3);
				$�ʲ���ź�׺ = (int)$�ʲ���ź�׺;
				//$�ʲ���ź�׺  = $�ʲ���ź�׺+1;
				if($�ʲ���ź�׺>0)			{
					switch(strlen($�ʲ���ź�׺))		{
						case 3:
							$�ʲ���ź�׺  = $�ʲ���ź�׺+1;
							break;
						case 2:
							$�ʲ���ź�׺  = "0".$�ʲ���ź�׺;
							break;
						case 1:
							$�ʲ���ź�׺  = "00".$�ʲ���ź�׺;
							break;
					}

					$�ʲ����  = $�ʲ����ǰ׺.$�ʲ���ź�׺;
				}
				else	{
					$�ʲ����  = $�ʲ����."001";
				}
				$�ʲ����� = $�ɹ���ʶ;
				//."".date("Ymd")
			}
			else	{
				$�ʲ����1 = substr($�ʲ����,0,10);
				//print $�ʲ����1."<HR>$�ʲ����";
				$�ʲ����2 = substr($�ʲ����,10,4);
				$�ʲ����2 = $�ʲ����2+10001;
				$�ʲ����2 = substr($�ʲ����2,1,strlen($�ʲ����2));
				$�ʲ����  = $�ʲ����1.$�ʲ����2;
				$�ʲ����� = $�ɹ���ʶ;
			}

			$���� = returntablefield("fixedasset","�ʲ�����",$�ʲ�����,"����");
			$��� = $����*$����;
			//����̶��ʲ��������
			$sql = "insert into fixedasset
				(�ʲ�����,�ʲ����,�ʲ����,�ɹ���ʶ,��������,����״̬,������,����ʱ��,����,����,���,����ͺ�,��λ,�ʲ�����)
				values('$�ʲ�����','$�ʲ����','".$rs->fields['�ʲ����']."','$�ɹ���ʶ','$��������','����δ����','$������','$����ʱ��','$����','1','$���','".$rs->fields['����ͺ�']."','".$rs->fields['��λ']."','".$rs->fields['�ʲ�����']."');";

			//print $sql;exit;
			$db->Execute($sql);

			//����̶��ʲ��ɹ��������
			$sql = "insert into fixedassetin
				(�ʲ�����,�ʲ����,��������,��׼��,��ע,������,����ʱ��,����,����,���)
				values('$�ʲ�����','$�ʲ����','$��������','$��׼��','$��ע','$������','$����ʱ��','$����','$����','$���');";
			$db->Execute($sql);
			//print $sql."<BR>";
		}
		//print_R($_POST);exit;
		print_infor("��Ĳ����Ѿ����!",$infor='trip',$return="location='fixedasset_newai.php?'",$indexto='fixedasset_newai.php');


		//Array ( [�ɹ���ʶ] => ̨ʽ���� [����] => 6 [��������] => �������� [��׼��_ID] => admin [��׼��] => ϵͳ����Ա [��ע] => [������] => admin [����ʱ��] => 2009-08-27 16:52:16 [submit] => ���� )
	}

	else			{
		$SYSTEM_SECOND = 1;
		print_infor("��׼��Ϊ�ջ�����С��1,���Ĳ���û��ִ�гɹ�!",$infor='�ò����°汾û�б�ʹ��',$return="location='fixedasset_newai.php'",$indexto='fixedasset_newai.php');
	}

	exit;
}





$filetablename='fixedassetin';
require_once('include.inc.php');
?>