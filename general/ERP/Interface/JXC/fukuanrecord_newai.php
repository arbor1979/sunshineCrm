<?php
	ini_set('display_errors', 1);
	ini_set('error_reporting', E_ALL);
	error_reporting(E_WARNING | E_ERROR);
	require_once('lib.inc.php');
	$GLOBAL_SESSION=returnsession();
	validateMenuPriv("�����¼");
	if($_GET['action']=="add_default_data")		{
		try 
		{

			global $db;
			$oddment=floatvalue($_POST['oddment']);
			$accountid=$_POST['accountid'];
			$shoukuan=floatvalue($_POST['jine']);
			
			$billinfo=returntablefield("buyplanmain", "billid", $_POST['caigoubillid'], "totalmoney,paymoney,oddment");
			$maxjine=$billinfo['totalmoney']-$billinfo['paymoney']-$billinfo['oddment'];
			
			if($maxjine>0 && $shoukuan+$oddment>$maxjine)
				throw new Exception("���θ����ȥ��ϼƲ��ܴ���$maxjine");
			if($maxjine<0 && $shoukuan+$oddment<$maxjine)
				throw new Exception("���θ����ȥ��ϼƲ���С��$maxjine");
			if($shoukuan+$oddment==0)
				throw new Exception("���θ���+ȥ��ϼƲ���Ϊ0");
	
			//��������
			//$db->debug=1;
			$CaiWu=new CaiWu($db);
		    $db->StartTrans();  
	
			//���븶���¼
			
			$accesstype="����֧��";
			$CaiWu->insertFukuanReocord($_POST['supplyid'],$_POST['caigoubillid'],$shoukuan,$accountid,$_SESSION['LOGIN_USER_ID'],$accesstype,$oddment,$_POST['qici'],$_POST['beizhu'],$_POST['guanlianplanid']);

			//����ƻ�
			if($_POST['guanlianplanid']!='')
			{
				$sql="update fukuanplan set ifpay='�Ѹ���' where id=".$_POST['guanlianplanid'];
				$db->Execute($sql);
			}
			
	    	$db->CompleteTrans();
			//�Ƿ�������ִ���
			page_css("�����¼");
			if ($db->HasFailedTrans()) 
				throw new Exception($db->ErrorMsg());
			else 
			{ 
				$return=$_POST['url'];
				$return=$return."?".FormPageAction("action","init_default");
				print_infor("�����¼������",'trip',"location='?$return'","$return",0);
				
			}
		}
		catch(Exception $e)
		{
			print "<script language=javascript>alert('����".str_replace("'",  "\'", $e->getMessage())."');window.history.back(-1);</script>";
		}
		exit;
	}
	//��������
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
					$fukuaninfo=returntablefield("fukuanrecord", "id", $selectid[$i], "id,supplyid,caigoubillid,jine,oddment,accountid,guanlianplanid");	
					$caigoubillid=$fukuaninfo['caigoubillid'];
					$fukuan=$fukuaninfo['jine'];
					$oddment=$fukuaninfo['oddment'];
					$planid=$fukuaninfo['guanlianplanid'];
					
					//ɾ���ؿ��¼
					$CaiWu->deleteFukuanReocord($selectid[$i]);
					
					
					//�ؿ�ƻ�
					if($planid!='')
					{
						$sql="update fukuanplan set ifpay='δ����' where id=".$planid;
						$db->Execute($sql);
					}
				}

			}
			$db->CompleteTrans();
			//�Ƿ�������ִ���
			page_css("�����¼");
			if ($db->HasFailedTrans()) 
				throw new Exception($db->ErrorMsg());
			else 
			{ 
				$return=FormPageAction("action","init_default");
				print_infor("�����¼�ѳɹ�ɾ��",'trip',"location='?$return'","?$return",0);
			}
	    	
			
		}
		catch(Exception $e)
		{
			print "<script language=javascript>alert('����".$e->getMessage()."');window.history.back(-1);</script>";
	    	exit;
		}
		exit;	
	}
	addShortCutByDate("createtime","����ʱ��");
	$filetablename		=	'fukuanrecord';
	$parse_filename		=	'fukuanrecord';
	require_once('include.inc.php');
	?>