<?php
	ini_set('display_errors', 1);
	ini_set('error_reporting', E_ALL);
	error_reporting(E_WARNING | E_ERROR);
	require_once('lib.inc.php');
	$GLOBAL_SESSION=returnsession();
	validateMenuPriv("������¼");
	//ɾ��������¼
	if($_GET['action']=="delete_array")			
	{
		$selectid=$_GET['selectid'];
		$selectid=explode(",", $selectid);
		try 
		{
			
			//��������
			$Store=new Store($db);
			//$db->debug=1;
		    $db->StartTrans();  
			for($i=0;$i<sizeof($selectid);$i++)
			{
				if($selectid[$i]!="")
				{
					$Store->deleteHeTongJiaoFu($selectid[$i]);
				}
			}
			//�Ƿ�������ִ���
			if ($db->HasFailedTrans()) 
			{
			 	print "<script language=javascript>alert('����".str_replace("'",  "\'", $db->ErrorMsg())."');window.history.back(-1);</script>";
			}
			else 
			{ 
				page_css("������¼ɾ��");
				$return=FormPageAction("action","init_default");
				print_infor("������¼�ѳɹ�ɾ��",'trip',"location='?$return'","?$return",0);
			}
	    	$db->CompleteTrans();
			exit;	
		}
		catch(Exception $e)
		{
			print "<script language=javascript>alert('����".$e->getMessage()."');window.history.back(-1);</script>";
	    	exit;
		}
	}
	addShortCutByDate("createtime","����ʱ��");
	$SYSTEM_ADD_SQL =getCustomerRoleByCustID($SYSTEM_ADD_SQL,"customerid");
	$limitEditDelCust='customerid';
	//���ݱ�ģ���ļ�,��ӦModelĿ¼�����sellcontract_jiaofu_newai.ini�ļ�
	//�������Ҫ���ƴ�ģ��,����Ҫ�޸�$parse_filename������ֵ,Ȼ���Ӧ��ModelĿ¼ ���ļ���_newai.ini�ļ�
	$filetablename		=	'sellcontract_jiaofu';
	$parse_filename		=	'sellcontract_jiaofu';
	require_once('include.inc.php');
	?>