<?php
	ini_set('display_errors', 1);
	ini_set('error_reporting', E_ALL);
	error_reporting(E_WARNING | E_ERROR);
	require_once('lib.inc.php');
	$GLOBAL_SESSION=returnsession();
	validateMenuPriv("批量收款");
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
						$accesstype="货款收取";
						$billtype=returntablefield("sellplanmain","billid",$billid,"billtype");
						if($billtype==3)
							$accesstype="欠款收取";
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
						$accesstype="货款收取";
						$billtype=returntablefield("sellplanmain","billid",$billid,"billtype");
						if($billtype==3)
							$accesstype="欠款收取";
						$CaiWu->insertShoukuanReocord($_GET['supplyid'],$billid,$jineArray[$i]-$oddArray[$i],$_GET['accountid'],$_SESSION['LOGIN_USER_ID'],$accesstype,$oddArray[$i],'','');
					}
				}
			}
			$db->CompleteTrans();
			//是否事务出现错误
			page_css();
			if ($db->HasFailedTrans()) 
				throw new Exception($db->ErrorMsg());
			else 
			{ 
				$return=$_POST['url'];
				$return=$return."?".FormPageAction("action","init_default");
				print_infor("批量收款成功",'trip',"location='v_yingshoukuanhuizong_mingxi.php?supplyid=".$_GET['supplyid']."'","v_yingshoukuanhuizong_mingxi.php?supplyid=".$_GET['supplyid'],1);
				
			}
		}
		catch(Exception $e)
		{
			print "<script language=javascript>alert('错误：".str_replace("'",  "\'", $e->getMessage())."');window.history.back(-1);</script>";
		}
		exit;
	}

	//数据表模型文件,对应Model目录下面的v_yingshoukuanhuizong_newai.ini文件
	//如果是需要复制此模块,则需要修改$parse_filename参数的值,然后对应到Model目录 新文件名_newai.ini文件
	$filetablename		=	'v_yingshoukuanhuizong';
	$parse_filename		=	'v_yingshoukuanhuizong';
	require_once('include.inc.php');
	?>