<?php
	ini_set('display_errors', 1);
	ini_set('error_reporting', E_ALL);
	error_reporting(E_WARNING | E_ERROR);
	require_once('lib.inc.php');
	$GLOBAL_SESSION=returnsession();
	validateMenuPriv("��������");
	//���ɳ���ⵥ
	if($_GET['action']=="edit_default4")
	{
	
		//��������
    	try {
	    	$db->StartTrans();  
		    	//$db->debug=true;
	   		$Store=new Store($db);
	   		$Store->newDiaoBoRuKu($_GET['billid']);
	    		//�Ƿ�������ִ���
			if ($db->HasFailedTrans()) 
			 	print "<script language=javascript>alert('����".str_replace("'",  "\'", $db->ErrorMsg())."');window.history.back(-1);</script>";
	    	else 
			{ 
				page_css("");
				$return=FormPageAction("action","init_default");
				print_infor("�����ɳ���ⵥ���ȴ����ȷ��",'trip',"location='?$return'","?$return",0);
			}
			$db->CompleteTrans();
	    	exit;
    	}
    	catch (Exception $e)
		{
			print "<script language=javascript>alert('����".$e->getMessage()."');window.history.back(-1);</script>";
    		exit;
		} 
		
	}
	//ɾ��������
	if($_GET['action']=="delete_array")			
	{
		$selectid=$_GET['selectid'];
		$selectid=explode(",", $selectid);
		try 
		{
			//��������
			$Store=new Store($db);
		    $db->StartTrans();  
			for($i=0;$i<sizeof($selectid);$i++)
			{
				if($selectid[$i]!="")
					$Store->deleteDiaoBo($selectid[$i]);
			}
			//�Ƿ�������ִ���
			if ($db->HasFailedTrans()) 
			 	print "<script language=javascript>alert('����".str_replace("'",  "\'", $db->ErrorMsg())."');window.history.back(-1);</script>";
			else 
			{ 
				page_css("������ɾ��");
				$return=FormPageAction("action","init_default");
				print_infor("�������ѳɹ�ɾ��",'trip',"location='?$return'","?$return",0);
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
	
	if($_GET['action']=="add_default_data" || $_GET['action']=="edit_default_data")
	{
		if($_POST['instoreid']==$_POST['outstoreid'])
		{
			print "<script language=javascript>alert('���󣺵����ֿ�͵���ֿⲻ��Ϊͬһ�ֿ�');window.history.back(-1);</script>";
    		exit;
		}
	}	
	if($_GET['action']=="edit_default2")			
	{
		$storeid=returntablefield("stockchangemain","billid",$_GET['billid'],"outstoreid");
		print "<script>location='DataQuery/productFrame.php?tablename=stockchangemain_detail&deelname=��������ϸ&rowid=".$_GET['billid']."&storeid=".$storeid."'</script>";
		exit;
	}
	//���ݱ�ģ���ļ�,��ӦModelĿ¼�����stockchangemain_newai.ini�ļ�
	//�������Ҫ���ƴ�ģ��,����Ҫ�޸�$parse_filename������ֵ,Ȼ���Ӧ��ModelĿ¼ ���ļ���_newai.ini�ļ�
	addShortCutByDate("createtime","����������ʱ��");
	$filetablename		=	'stockchangemain';
	$parse_filename		=	'stockchangemain';
	require_once('include.inc.php');
	systemhelpContent("������˵��",'100%');
?>