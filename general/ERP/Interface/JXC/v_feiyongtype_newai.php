<?php
	ini_set('display_errors', 1);
	ini_set('error_reporting', E_ALL);
	error_reporting(E_WARNING | E_ERROR);
	require_once('lib.inc.php');
	$GLOBAL_SESSION=returnsession();
	validateMenuPriv("����֧������");
	if($_GET['action']=="add_default_data")		{

		$id=returntablefield("v_feiyongtype","typename",$_POST['typename'],"id");
		if($id!='')
		{
			print "<script language=javascript>alert('�������Ѵ���');window.history.back(-1);</script>";
    		exit;
		}
		
	}
	if($_GET['action']=="edit_default_data")		{

		$oldid=$_GET['id'];
		$id=returntablefield("v_feiyongtype","typename",$_POST['typename'],"id");
		if($id!='' && $id!=$oldid)
		{
			print "<script language=javascript>alert('�������Ѵ���');window.history.back(-1);</script>";
    		exit;
		}
		
	}
	if($_GET['action']=="delete_array")			
	{
		$selectid=$_GET['selectid'];
		$selectid=explode(",", $selectid);
		for($i=0;$i<sizeof($selectid);$i++)
		{
			if($selectid[$i]!="")
			{
				$id=returntablefield("feiyongrecord","typeid",$selectid[$i],"billid");
				if($id!='')
				{
					print "<script language=javascript>alert('���ڷ���֧����������ɾ��');window.history.back(-1);</script>";
		    		exit;
				}
				$sql="delete from feiyongtype where id=$selectid[$i]";
				$db->execute($sql);
			}
			
		}
		page_css("");
		$return=FormPageAction("action","init_default");
		print_infor("�����ѳɹ�ɾ��",'trip',"location='?$return'","?$return",0);
		exit;
	}
	//���ݱ�ģ���ļ�,��ӦModelĿ¼�����v_feiyongtype_newai.ini�ļ�
	//�������Ҫ���ƴ�ģ��,����Ҫ�޸�$parse_filename������ֵ,Ȼ���Ӧ��ModelĿ¼ ���ļ���_newai.ini�ļ�
	$filetablename		=	'v_feiyongtype';
	$parse_filename		=	'v_feiyongtype';
	require_once('include.inc.php');
	?>