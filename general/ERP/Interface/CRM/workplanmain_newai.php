<?php
	ini_set('display_errors', 1);
	ini_set('error_reporting', E_ALL);
	error_reporting(E_WARNING | E_ERROR);
	require_once('lib.inc.php');
	$GLOBAL_SESSION=returnsession();
	$SYSTEM_PRIV_STOP = "1";
	validateMenuPriv("������");
	//print_r($_POST);exit;
	if($_GET['action']=="add_default")
	{
		if($_GET['zhuti']!='')
			$ADDINIT=array("zhuti"=>$_GET['zhuti']);
		if($_GET['content']!='')
			$ADDINIT[content]=urldecode($_GET['content']);
		if($_GET['guanlianshiwu']!='')
			$ADDINIT["guanlianshiwu"]=$_GET['guanlianshiwu'];
		if($_GET['guanlianurl']!='')
			$ADDINIT["guanlianurl"]=urldecode($_GET['guanlianurl']);
		if($_GET['guanlianid']!='')
			$ADDINIT["guanlianid"]=$_GET['guanlianid'];
		//print_r($ADDINIT);exit;
	}
	
	if($_GET['action']=="add_default_data" || $_GET['action']=="edit_default_data")		
	{
		//������Ϣ֪ͨ
		$touser=explode(",",$_POST["zhixingren"]);
		$messagetitle="��������";
		$guanlianid=$_POST["id"];
		if($_GET['action']=="edit_default_data")
		{
			$guanlianid=$_GET["id"];
			deleteMessage($messagetitle,$guanlianid);
		}
		$db->StartTrans();
		for($i=0;$i<sizeof($touser);$i++)
		{
			if($touser[$i]!="")
			{
				newMessage($touser[$i],$_POST['zhuti'],$messagetitle,'../CRM/workplanmain_newai.php?'.base64_encode('action=view_default&id='.$guanlianid),$guanlianid);
				
			}	
		
			$userInfo=returntablefield("user", "user_id", $touser[$i], "user_name,email,MOBIL_NO");
			$destlist[$i]['email']=$userInfo['email'];
			$destlist[$i]['mobile']=$userInfo['MOBIL_NO'];
			$destlist[$i]['name']=$userInfo['user_name'];
			
		}
		if($_GET['action']=="add_default_data" && $_POST['guanlianshiwu']=="�ͻ�����")
		{
			$sql="update crm_service set ���س̶�='3' where ���='".$_POST['guanlianid']."' and ���س̶�='2'";
			$db->Execute($sql);
		}
    	$db->CompleteTrans();
	
    	//�����ʼ�֪ͨ
		if($_POST['ifemail']=='1')		
		{
			sendEmail($destlist,$_POST['zhuti'],$_POST['content']);
		}
		//��������֪ͨ
		if($_POST['ifsms']=='1')		
		{
			$mobiles='';
			for($i=0;$i<sizeof($destlist);$i++)
			{
				if($destlist[$i]['mobile']!='')
					$mobiles.=$destlist[$i]['mobile'].",";
			}
			print "\n<script type=\"text/javascript\" language=\"javascript\" src=\"".ROOT_DIR."general/ERP/Enginee/jquery/jquery.js\"></script>\n";
			print "<script type=\"text/javascript\" language=\"javascript\">
			$.post('../Framework/sms_getContents.php?action=send', {
			    mobiles:'".$mobiles."',
			    msg:'".cutStr("��".$messagetitle."��".$_POST['zhuti'],70)."'
			}, function(data) {	
			});
		</script>";	
		}
			
		
	}
	if($_GET['action']=="delete_array"){
		$selectid=$_GET['selectid'];
		$selectid=explode(",", $selectid);
		for($i=0;$i<sizeof($selectid);$i++)
		{
			if($selectid[$i]!="")
			{
				deleteMessage('��������',$selectid[$i]);
				
			}
	
		}
	}
	
	if($_GET['action']=="edit_shenhe")
	{
		print "<script>location.href='workplanmain_shenhe.php?id=".$_GET['id']."&url=".$_SERVER["PHP_SELF"]."'</script>";
		exit;
	}
	if($_GET['action']=="shenhe")
	{
		$id=$_GET['id'];
		$shenchastate=$_POST['shenchastate'];
		$shenhepishi=$_POST['shenhepishi'];
		$sql="update workplanmain set shenchastate=$shenchastate,shenhepishi='$shenhepishi',shenhetime=now(),shenheren='".$_SESSION['LOGIN_USER_ID']."' where id=$id";
		$db->Execute($sql);
		page_css("������");
		$return=FormPageAction("action","init_default");
		print_infor("��¼�����",'trip',"location='?$return'","?$return",0);
		exit;
	}
	
	addShortCutByDate("createtime","����ʱ��");
	$SYSTEM_ADD_SQL=$SYSTEM_ADD_SQL." and (createman='".$_SESSION['LOGIN_USER_ID']."')";
	$filetablename		=	'workplanmain';
	$parse_filename		=	'workplanmain';
	//$SYSTEM_PRINT_SQL=1;
	require_once('include.inc.php');
	?>