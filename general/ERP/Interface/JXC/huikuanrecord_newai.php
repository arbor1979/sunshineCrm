<?php
	ini_set('display_errors', 1);
	ini_set('error_reporting', E_ALL);
	error_reporting(E_WARNING | E_ERROR);
	require_once('lib.inc.php');
	$GLOBAL_SESSION=returnsession();
	validateMenuPriv("�ؿ��¼");
	
	$customerid=$_GET['customerid'];
	if($customerid!='' && $_GET['action']=='add_default')
	{
		
		$dingdanbillid=$_GET['billid'];
		$ADDINIT=array("customerid"=>$customerid,"dingdanbillid"=>$dingdanbillid);
	}
	if($_GET['action']=="add_default_data")		{
		global $db;
		$oddment=floatvalue($_POST['oddment']);
		$accountid=$_POST['accountid'];
		$shoukuan=floatvalue($_POST['jine']);
		
		$billinfo=returntablefield("sellplanmain", "billid", $_POST['dingdanbillid'], "billtype,totalmoney,huikuanjine,oddment");
		$maxjine=$billinfo['totalmoney']-$billinfo['huikuanjine']-$billinfo['oddment'];
		if($shoukuan==0 && $oddment==0)
		{
			print "<script language=javascript>alert('�ؿ����ȥ����ܶ�Ϊ0');window.history.back(-1);</script>";
			exit;
		}
		if($maxjine>0 && $shoukuan+$oddment>$maxjine)
		{
			print "<script language=javascript>alert('���󣺱��λؿ��ȥ��ϼƲ��ܴ���".$maxjine."');window.history.back(-1);</script>";
			exit;
		}
		if($maxjine<0 && $shoukuan+$oddment<$maxjine)
		{
			print "<script language=javascript>alert('���󣺱��λؿ��ȥ��ϼƲ���С��".$maxjine."');window.history.back(-1);</script>";
			exit;
		}
		/*
		if($shoukuan+$oddment==0)
		{
			print "<script language=javascript>alert('���󣺱��λؿ�+ȥ��ϼƲ���Ϊ0');window.history.back(-1);</script>";
			exit;
		}
		*/
		try {
			//��������
			//$db->debug=1;
			$CaiWu=new CaiWu($db);
		    $db->StartTrans();  
	
			//����ؿ��¼
			
			$accesstype="������ȡ";
			//if($billinfo['billtype']==3)
			//	$accesstype="Ƿ����ȡ";
				
			$CaiWu->insertShoukuanReocord($_POST['customerid'],$_POST['dingdanbillid'],$shoukuan,$accountid,$_SESSION['LOGIN_USER_ID'],$accesstype,$oddment,$_POST['qici'],$_POST['guanlianplanid']);
			
			//$CaiWu->updatesellplanmainhuikuan($_POST['dingdanbillid']);
			
			//�ؿ�ƻ�
			if($_POST['guanlianplanid']!='')
			{
				$sql="update huikuanplan set ifpay='�ѻؿ�' where id=".$_POST['guanlianplanid'];
				$n=$db->Execute($sql);
				
			}
			
			//�Ƿ�������ִ���
			if ($db->HasFailedTrans()) 
			{
			 	print "<script language=javascript>alert('����".str_replace("'",  "\'", $db->ErrorMsg())."');window.history.back(-1);</script>";
			}
			 else 
			{ 
				page_css("�ؿ��¼");
				$return=$_POST['url'];
				$return=$return."?".FormPageAction("action","init_default");
				print_infor("�ؿ��¼������",'trip',"location='?$return'","$return",0);
				
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
	//�����ؿ�
	if($_GET['action']=="delete_array")			
	{
		$selectid=$_GET['selectid'];
		$selectid=explode(",", $selectid);
		try 
		{
			//��������
			$CaiWu=new CaiWu($db);
			//$db->debug=1;
		    $db->StartTrans();  
			for($i=0;$i<sizeof($selectid);$i++)
			{
				if($selectid[$i]!="")
				{
					$huikuaninfo=returntablefield("huikuanrecord", "id", $selectid[$i], "id,customerid,dingdanbillid,jine,oddment,accountid,guanlianplanid,jifenchongdimoney");	
					$dingdanbillid=$huikuaninfo['dingdanbillid'];
					$shoukuan=$huikuaninfo['jine'];
					$oddment=$huikuaninfo['oddment'];
					$accountid=$huikuaninfo['accountid'];
					$planid=$huikuaninfo['guanlianplanid'];
					$customerid=$huikuaninfo['customerid'];
					$jifenchongdimoney=$huikuaninfo['jifenchongdimoney'];
					
					//ɾ���ؿ��¼
					if($shoukuan!=0 || $oddment!=0 || $jifenchongdimoney!=0)
					{
						$CaiWu->deleteShoukuanReocord($selectid[$i]);
					}
					
					//�ؿ�ƻ�
					if($planid!='')
					{
						$sql="update huikuanplan set ifpay='δ�ؿ�' where id=".$planid;
						$db->Execute($sql);
					}
				}

			}
			//�Ƿ�������ִ���
			if ($db->HasFailedTrans()) 
			{
			 	print "<script language=javascript>alert('����".str_replace("'",  "\'", $db->ErrorMsg())."');window.history.back(-1);</script>";
				//echo $db->ErrorMsg();
			}
			else 
			{ 
				page_css("�ؿ��¼");
				$return=FormPageAction("action","init_default");
				print_infor("�ؿ��¼�ѳɹ�ɾ��",'trip',"location='?$return'","?$return",0);
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
	//���ݱ�ģ���ļ�,��ӦModelĿ¼�����huikuanrecord_newai.ini�ļ�
	//�������Ҫ���ƴ�ģ��,����Ҫ�޸�$parse_filename������ֵ,Ȼ���Ӧ��ModelĿ¼ ���ļ���_newai.ini�ļ�
	$SYSTEM_ADD_SQL =getRoleByUser($SYSTEM_ADD_SQL,"createman");
	addShortCutByDate("createtime","����ʱ��");
	$filetablename		=	'huikuanrecord';
	$parse_filename		=	'huikuanrecord';
	require_once('include.inc.php');
	?>