<?php
	ini_set('display_errors', 1);
	ini_set('error_reporting', E_ALL);
	error_reporting(E_WARNING | E_ERROR);
	require_once('lib.inc.php');
	$GLOBAL_SESSION=returnsession();
	validateMenuPriv("���������");
	if($_GET['action']=="shenhedan")		{

		$CaiWu=new CaiWu($db);
		$db->StartTrans();  
		$billid = $_GET['����'];
		$feiyonginfo=returntablefield("v_feiyong_sq", "����", $billid, "���,��������,������;,��������,�ͻ�����,¼��Ա");
		$jine=$feiyonginfo['���'];
		$fytype=$feiyonginfo['��������'];
		$yongtu=$feiyonginfo['������;'];
		$jingshouren=$feiyonginfo['¼��Ա'];
		$jingshouren=returntablefield("user","USER_ID",$jingshouren,"USER_NAME");
		$sql = "update crm_feiyong_sq set �Ƿ����='4',����Ա='".$_SESSION['LOGIN_USER_ID']."',֧��ʱ��=now() where ����='$billid'";
		$rs = $db->Execute($sql);
		$custName=returntablefield("customer","ROWID", $feiyonginfo['�ͻ�����'], "supplyname");
		$CaiWu->insertFeiYongAccount($fytype,$jine,1,$_SESSION['LOGIN_USER_ID'],-1,$feiyonginfo['��������'],$yongtu."(".$custName.")","",$jingshouren);
		//�Ƿ�������ִ���
		if ($db->HasFailedTrans()) 
		{
		 	print "<script language=javascript>alert('����".str_replace("'",  "\'", $db->ErrorMsg())."');window.history.back(-1);</script>";
		}
		 else 
		{ 
			page_css("���������");
			$return=$return."?".FormPageAction("action","init_default");
			print_infor("�ѱ���",'trip',"location='?$return'","$return",0);
			
		}
    	$db->CompleteTrans();
		exit;
	}
	addShortCutByDate("����ʱ��","����ʱ��");
	$filetablename		=	'v_feiyong_sq';
	$parse_filename		=	'v_feiyong_sq';
	require_once('include.inc.php');
	?>