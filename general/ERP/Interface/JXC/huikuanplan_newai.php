<?php
	ini_set('display_errors', 1);
	ini_set('error_reporting', E_ALL);
	error_reporting(E_WARNING | E_ERROR);
	require_once('lib.inc.php');
	$GLOBAL_SESSION=returnsession();
	validateMenuPriv("�ؿ�ƻ�");
	
	if($_GET['action']=="edit_huikuan")		{

		print "<script>location='huikuanplan_do.php?id=".$_GET['id']."&url=".$_SERVER["PHP_SELF"]."'</script>";
		exit;
		
	}
	
	if($_GET['action']=="add_default_data")
	{
		$sql="select max(id) as maxid from huikuanplan";
		$rs=$db->Execute($sql);
		$rs_a=$rs->GetArray();
		$id=$rs_a[0]['maxid']+1;
		$url='../JXC/huikuanplan_newai.php?'.base64_encode('action=init_default_search&searchfield=id&searchvalue='.$id);
		$plandate=$_POST['plandate']." 08:00:00";
		$EndTime=strtotime("$plandate +10 hour");
		$EndTime=date("Y-m-d H:i:s",$EndTime);
		$custName=returntablefield("customer", "ROWID", $_POST['customerid'], "supplyname");
		$zhuti=returntablefield("sellplanmain", "billid", $_POST['dingdanbillid'], "zhuti");
		newMessage($_SESSION['LOGIN_USER_ID'],$custName."-".$zhuti,'�ؿ�ƻ�',$url,$id,$plandate);
		newCalendar($_SESSION['LOGIN_USER_ID'],$plandate,$EndTime,'�ؿ�ƻ�','1',$custName."-".$zhuti,$url,$id);
				
	}
	if($_GET['action']=="delete_array")
	{
		$selectid=$_GET['selectid'];
		$selectid=explode(",", $selectid);
		for($i=0;$i<sizeof($selectid);$i++)
		{
			if($selectid[$i]!="")
			{
				deleteMessage('�ؿ�ƻ�',$selectid[$i]);
				deleteCalendar('�ؿ�ƻ�',$selectid[$i]);
			}
		}
	}

	//���ݱ�ģ���ļ�,��ӦModelĿ¼�����huikuanplan_newai.ini�ļ�
	//�������Ҫ���ƴ�ģ��,����Ҫ�޸�$parse_filename������ֵ,Ȼ���Ӧ��ModelĿ¼ ���ļ���_newai.ini�ļ�
	addShortCutByDate("createtime","����ʱ��");
	$filetablename		=	'huikuanplan';
	$parse_filename		=	'huikuanplan';
	require_once('include.inc.php');
	
	
	?>