<?php
	ini_set('display_errors', 1);
	ini_set('error_reporting', E_ALL);
	error_reporting(E_WARNING | E_ERROR);
	require_once('lib.inc.php');
	$GLOBAL_SESSION=returnsession();
	validateMenuPriv("����֧������");
	if($_GET['action']=="add_default_data")		{

		$_POST['kind']=-1;
		$id=returntablefield("v_feiyongclass","classname",$_POST['classname'],"id");
		if($id!='')
		{
			print "<script language=javascript>alert('�������Ѵ���');window.history.back(-1);</script>";
    		exit;
		}
		
	}
	if($_GET['action']=="edit_default_data")		{

		$oldid=$_GET['id'];
		$id=returntablefield("v_feiyongclass","classname",$_POST['classname'],"id");
		if($id!=$oldid)
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
			$id=returntablefield("v_feiyongtype","classid",$selectid[$i],"id");
			if($id!='')
			{
				print "<script language=javascript>alert('�������࣬����ɾ��');window.history.back(-1);</script>";
	    		exit;
			}
		}
	}
}
	//���ݱ�ģ���ļ�,��ӦModelĿ¼�����v_feiyongclass_newai.ini�ļ�
	//�������Ҫ���ƴ�ģ��,����Ҫ�޸�$parse_filename������ֵ,Ȼ���Ӧ��ModelĿ¼ ���ļ���_newai.ini�ļ�
	$filetablename		=	'v_feiyongclass';
	$parse_filename		=	'v_feiyongclass';
	require_once('include.inc.php');
	?>