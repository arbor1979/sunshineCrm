<?php
	ini_set('display_errors', 1);
	ini_set('error_reporting', E_ALL);
	error_reporting(E_WARNING | E_ERROR);
	require_once('lib.inc.php');
	$GLOBAL_SESSION=returnsession();
	validateMenuPriv("�����տ�");
if($_GET['action']=="mingxi")
{
	print "<script>location='v_yingshoukuanhuizong_mingxi.php?supplyid=".$_GET['rowid']."'</script>";
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
				if($jineArray[$i]<0)
				{
					$tmpArray=explode("_", $billidArray[$i]);
					$billid=$tmpArray[1];
					if($billid!='')
					{
						$accesstype="������ȡ";
						$billtype=returntablefield("sellplanmain","billid",$billid,"billtype");
						if($billtype==3)
							$accesstype="Ƿ����ȡ";
						$CaiWu->insertShoukuanReocord($_GET['supplyid'],$billid,$jineArray[$i]-$oddArray[$i],$_GET['accountid'],$_SESSION['LOGIN_USER_ID'],$accesstype,$oddArray[$i],'','');
					}
				}
			}
			for($i=0;$i<sizeof($billidArray);$i++)
			{
				if($jineArray[$i]>=0)
				{
					$tmpArray=explode("_", $billidArray[$i]);
					$billid=$tmpArray[1];
					if($billid!='')
					{
						$accesstype="������ȡ";
						$billtype=returntablefield("sellplanmain","billid",$billid,"billtype");
						if($billtype==3)
							$accesstype="Ƿ����ȡ";
						$CaiWu->insertShoukuanReocord($_GET['supplyid'],$billid,$jineArray[$i]-$oddArray[$i],$_GET['accountid'],$_SESSION['LOGIN_USER_ID'],$accesstype,$oddArray[$i],'','');
					}
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
				print_infor("�����տ�ɹ�",'trip',"location='v_yingshoukuanhuizong_mingxi.php?supplyid=".$_GET['supplyid']."'","v_yingshoukuanhuizong_mingxi.php?supplyid=".$_GET['supplyid'],1);
				
			}
		}
		catch(Exception $e)
		{
			print "<script language=javascript>alert('����".str_replace("'",  "\'", $e->getMessage())."');window.history.back(-1);</script>";
		}
		exit;
	}

	//���ݱ�ģ���ļ�,��ӦModelĿ¼�����v_yingshoukuanhuizong_newai.ini�ļ�
	//�������Ҫ���ƴ�ģ��,����Ҫ�޸�$parse_filename������ֵ,Ȼ���Ӧ��ModelĿ¼ ���ļ���_newai.ini�ļ�
	$filetablename		=	'v_yingshoukuanhuizong';
	$parse_filename		=	'v_yingshoukuanhuizong';
	require_once('include.inc.php');
	?>