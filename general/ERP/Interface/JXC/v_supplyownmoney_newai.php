<?php
	ini_set('display_errors', 1);
	ini_set('error_reporting', E_ALL);
	error_reporting(E_WARNING | E_ERROR);
	require_once('lib.inc.php');
	$GLOBAL_SESSION=returnsession();
	validateMenuPriv("��������");
	if($_GET['action']=="" || $_GET['action']=="init_default")
	{
		
	}
		
	if($_GET['action']=="mingxi")
	{
		print "<script>location='v_supplyownmoney_mingxi.php?supplyid=".$_GET['rowid']."'</script>";
		exit;
	}	
	if($_GET['action']=="paybatch")
	{
		try 
		{
			$db->StartTrans(); 
		
			$CaiWu=new CaiWu($db);
			$billidArray=explode(",", $_POST['billid']);
			$jineArray=explode(",", $_POST['jine']);
			$oddArray=explode(",", $_POST['oddment']);
			for($i=0;$i<sizeof($billidArray);$i++)
			{
				
				$tmpArray=explode("_", $billidArray[$i]);
				$billid=$tmpArray[1];
				if($billid!='')
				{
					$CaiWu->insertFukuanReocord($_GET['supplyid'],$billid,$jineArray[$i]-$oddArray[$i],$_GET['accountid'],$_SESSION['LOGIN_USER_ID'],'����֧��',$oddArray[$i],'','','');
				}
			}
			$db->CompleteTrans();
			//�Ƿ�������ִ���
			page_css();
			if ($db->HasFailedTrans()) 
				throw new Exception($db->ErrorMsg());
			else 
			{ 
				$return=$_POST['url'];
				$return=$return."?".FormPageAction("action","init_default");
				print_infor("��������ɹ�",'trip',"location='v_supplyownmoney_mingxi.php?supplyid=".$_GET['supplyid']."'","v_supplyownmoney_mingxi.php?supplyid=".$_GET['supplyid'],1);
				
			}
		}
		catch(Exception $e)
		{
			print "<script language=javascript>alert('����".str_replace("'",  "\'", $e->getMessage())."');window.history.back(-1);</script>";
		}
		exit;
	}
	$filetablename		=	'v_supplyownmoney';
	$parse_filename		=	'v_supplyownmoney';
	require_once('include.inc.php');
	?>

	