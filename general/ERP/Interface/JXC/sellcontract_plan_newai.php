<?php
	ini_set('display_errors', 1);
	ini_set('error_reporting', E_ALL);
	error_reporting(E_WARNING | E_ERROR);
	require_once('lib.inc.php');
	$GLOBAL_SESSION=returnsession();
	validateMenuPriv("�����ƻ�");
	if($_GET['action']=="action_jiaofu")
	{
		require_once("sellcontract_plan_do.php");
		exit;
	}
	if($_GET['action']=="add_default")
	{
		$billid=$_GET['billid'];
		$customerid=returntablefield("sellplanmain", "billid", $billid, "supplyid");
		$ADDINIT=array("supplyid"=>$customerid,"mainrowid"=>$billid);
	}
	if($_GET['action']=="workplan")		{
		$hetongid=returntablefield("v_sellcontract_plan", "id", $_GET['id'], "mainrowid");
		$hetongzhuti=returntablefield("v_sellcontract", "billid", $hetongid, "zhuti");
		$guanlianurl=urlencode("../JXC/sellcontract_plan_newai.php?action=view_default&id=".$_GET['id']);
		$guanlianshiwu="��ͬ����-".$hetongid;
		$zhuti="ִ�к�ͬ��".$hetongzhuti."��";
		print "<script>location='../CRM/workplanmain_newai.php?action=add_default&zhuti=$zhuti&guanlianshiwu=$guanlianshiwu&guanlianurl=$guanlianurl'</script>";
		exit;
	}
	if($_GET['action']=="add_default_data" || $_GET['action']=="edit_default_data")
	{
		page_css("��ͬ�ƻ�����");
		$jine=round($_POST['num']*$_POST['price'],2);
		$ifkucun=returntablefield("product","productid",$_POST['prodid'],"ifkucun");
	
		if($ifkucun=="��")
		{
			print "<script language=javascript>alert('���󣺽�����Ҫ������Ĳ�Ʒ��ʹ�ö���');window.history.back(-1);</script>";
			exit;
		}
		
		
		$id=$_GET['id'];
		$mainrowid=$_POST['mainrowid'];
		$prodid=$_POST['prodid'];
		$prodname=returntablefield("product", "productid", $prodid, "productname");
		$price=$_POST['price'];
		$num=$_POST['num'];
		$beizhu=$_POST['beizhu'];
		$plandate=$_POST['plandate'];
		$qici=$_POST['qici'];
		$yaoqiu=$_POST['yaoqiu'];
		$iftixing=$_POST['iftixing'];
		$createtime=date("Y-m-d H:i:s");
		
		$totaljine=returntablefield("sellplanmain","billid",$mainrowid,"totalmoney");
		$sql="select sum(jine) as alljine from sellplanmain_detail where  mainrowid=".$mainrowid;
		$rs=$db->Execute($sql);
		$rs_a=$rs->GetArray();
		$maxjine=$totaljine-$rs_a[0]['alljine'];
		
		if($jine>$maxjine)
		{
			print "<script language=javascript>alert('���ν����ƻ����ܴ��� ".$maxjine."');window.history.back(-1);</script>";
			exit;
		}
			
		function validate($prodid,$mainrowid)
		{
			global $prodname;
			global $db;
			$sql="select * from sellplanmain_detail where prodid='".$prodid."' and mainrowid=".$mainrowid;
			$rs=$db->Execute($sql);
			$rs_a=$rs->GetArray();
			if(count($rs_a)>0)
			{
				print "<script language=javascript>alert('���󣺺�ͬ $mainrowid �Ѵ��ڲ�Ʒ $prodname �Ľ����ƻ�');window.history.back(-1);</script>";
				exit;
			}
		}
		$opertype="";
		if($_GET['action']=="add_default_data")
		{
			validate($prodid,$mainrowid);
			$sql="select max(id) as maxid from sellplanmain_detail";
			$rs=$db->Execute($sql);
			$rs_a=$rs->GetArray();
			$maxid=$rs_a[0]['maxid']+1;
			$sql="insert into sellplanmain_detail (id,mainrowid,prodid,prodname,price,num,jine,zhekou,beizhu,plandate,qici,yaoqiu,iftixing,createtime,inputtime) values(".$maxid.",".$mainrowid.",'".
			$prodid."','".$prodname."',".$price.",".$num.",".$jine.",1,'".$beizhu."','".$plandate."','".$qici."','".$yaoqiu."','".$iftixing."','".$createtime."','".$createtime."')";
			$opertype="����";
		}
		else 
		{
			$oldmainrowid=returntablefield("sellplanmain_detail","id",$id,"mainrowid");
			$oldprodid=returntablefield("sellplanmain_detail","id",$id,"prodid");
			if($oldmainrowid!=$mainrowid || $oldprodid!=$prodid)
				validate($prodid,$mainrowid);
			$sql="update sellplanmain_detail set mainrowid=".$mainrowid.",prodid='".$prodid."',prodname='".$prodname."',price=".$price.",num=".$num.",jine=".$jine.",beizhu='".$beizhu.
			"',plandate='".$plandate."',qici='".$qici."',yaoqiu='".$yaoqiu."',iftixing='".$iftixing."' where id=".$id;
			$opertype="�޸�";
			deleteMessage('��ͬ�����ƻ�',$id);
			deleteCalendar('��ͬ�����ƻ�',$id);
		}
		
		$db->Execute($sql);
		
		
		if($id=='')
			$id=$maxid;
		$hetongInfo=returntablefield("v_sellcontract", "billid", $mainrowid, "supplyid,zhuti");
		$custName=returntablefield("customer", "ROWID", $hetongInfo['supplyid'], "supplyname");
		$url='../../JXC/sellcontract_plan_newai.php?'.base64_encode('action=init_default_search&searchfield=id&searchvalue='.$id);
		$plandate=$plandate." 08:00:00";
		$EndTime=strtotime("$plandate +10 hour");
		$EndTime=date("Y-m-d H:i:s",$EndTime);
		newMessage($_SESSION['LOGIN_USER_ID'],$custName."-".$hetongInfo['zhuti'],'��ͬ�����ƻ�',$url,$id,$plandate);
		newCalendar($_SESSION['LOGIN_USER_ID'],$plandate,$EndTime,'��ͬ�����ƻ�','1',$custName."-".$hetongInfo['zhuti'],$url,$id);
		$return=FormPageAction("action","init_default");
		print_infor("�����ƻ�".$opertype."�ɹ�",'trip',"location='?$return'","?$return",0);
		exit;
			
	}
	if($_GET['action']=="action_jiaofu_data")
	{
		page_css("��ͬ����");
		$productid=$_POST['productid'];
		$customerid=$_POST['customerid'];
		$hetongid=$_POST['hetongid'];
		$id=$_POST['id'];
		$num=$_POST['num'];
		$price=$_POST['price'];
		$jieshouren=$_POST['jieshouren'];
		$jiaofudate=$_POST['jiaofudate'];
		$beizhu=$_POST['beizhu'];
		$jine=round($num*$price,2);
		
		global $db;
		try {
			$Store=new Store($db);
			//��������
		    $db->StartTrans();  
			
		    $Store->HeTongJiaoFu($customerid,$hetongid,$productid,$id,$num,$price,$jieshouren,$jiaofudate,$beizhu,$jine);
		    
			//�Ƿ�������ִ���
			if ($db->HasFailedTrans()) 
			 	throw new Exception("����".str_replace("'",  "\'", $db->ErrorMsg()));
			else 
			{ 
				$return=FormPageAction("action","init_default");
				print_infor("������¼�ѱ���ɹ�",'trip',"location='?$return'","?$return",0);
			}
	    	$db->CompleteTrans();
		}
		catch (Exception $e)
		{
			print "<script language=javascript>alert('����".$e->getMessage()."');window.history.back(-1);</script>";
		}
		exit;
		
	}
	//ɾ�������ƻ�
	if($_GET['action']=="delete_array")			
	{
		$selectid=$_GET['selectid'];
		$selectid=explode(",", $selectid);
		$db->StartTrans();  
		for($i=0;$i<sizeof($selectid);$i++)
		{
			if($selectid[$i]!="")
			{
				$chukunum=returntablefield("sellplanmain_detail", "id", $selectid[$i], "chukunum");
				if($chukunum>0)
				{
					print "<script language=javascript>alert('�����ѽ�������Ϊ�㣬����ɾ��������¼');window.history.back(-1);</script>";
					exit;
				}
				$sql="delete from sellplanmain_detail where id=".$selectid[$i];
				$db->Execute($sql);
				deleteMessage('��ͬ�����ƻ�',$selectid[$i]);
				deleteCalendar('��ͬ�����ƻ�',$selectid[$i]);
				
			}
		}
		page_css();
		if ($db->HasFailedTrans()) 
		 	print "<script language=javascript>alert('����".str_replace("'",  "\'", $db->ErrorMsg())."');window.history.back(-1);</script>";
		else 
		{ 
			$return=FormPageAction("action","init_default");
			print_infor("������¼��ɾ��",'trip',"location='?$return'","?$return",0);
		}
		$db->CompleteTrans();
		exit;
	}
	//���ݱ�ģ���ļ�,��ӦModelĿ¼�����sellcontract_plan_newai.ini�ļ�
	//�������Ҫ���ƴ�ģ��,����Ҫ�޸�$parse_filename������ֵ,Ȼ���Ӧ��ModelĿ¼ ���ļ���_newai.ini�ļ�
	addShortCutByDate("createtime","����ʱ��");
	$SYSTEM_ADD_SQL =getCustomerRoleByCustID($SYSTEM_ADD_SQL,"supplyid");
	$limitEditDelCust='supplyid';
	$filetablename		=	'v_sellcontract_plan';
	$parse_filename		=	'v_sellcontract_plan';
	require_once('include.inc.php');
	?>