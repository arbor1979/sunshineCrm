<?php
	ini_set('display_errors', 1);
	ini_set('error_reporting', E_ALL);
	error_reporting(E_WARNING | E_ERROR);
	require_once('lib.inc.php');
	$GLOBAL_SESSION=returnsession();
	
	
	if($_GET['action']=="huizong")		{
		$seldate=$_GET['id'];
		$ifedit=intval($_GET['ifedit']);
		$sql="select * from workreport where createman='".$_SESSION['LOGIN_USER_ID']."' and workdate='".$seldate."'";
		$rs=$db->Execute($sql);
		$rs_a=$rs->GetArray();
		if(sizeof($rs_a)>0 && !$ifedit)
		{
			echo "<font color=red>���������ύ����������,�벻Ҫ�ظ��ύ��</font>";
			exit;
		}
		$seldate=strtotime($seldate);
		$to_sta_date    = date('Y-m-d 0:0:0',$seldate);
		$to_end_date    = date('Y-m-d 23:59:59',$seldate);
		echo "��������:";
		//�����ͻ�
		$today="and createdate>='$to_sta_date' and createdate<'$to_end_date'";
		$sql_today = "select COUNT(*) AS NUM from customer where 1=1 $today";
		$sql_today=getRoleByUser($sql_today,"sysuser");
		$rs = $db->Execute($sql_today);
		$rs_today = $rs->fields['NUM'];
		if($rs_today>0)
			echo "�ͻ���<a href=../JXC/customer_newai.php?action=init_default&desksearch=".urlencode($today)." target=_blank>".number_format($rs_today,0,'',',')."��</a>";
		//��������
		$today="and ����ʱ��>='$to_sta_date' and ����ʱ��<'$to_end_date'";
		$sql_today = "select COUNT(*) AS NUM from crm_chance where 1=1 $today";
		$sql_today=getRoleByUser($sql_today,"������");
		$rs = $db->Execute($sql_today);
		$rs_today = $rs->fields['NUM'];
		if($rs_today>0)
			echo "<br>���ۻ��᣺<a href=../JXC/crm_chance_newai.php?action=init_default&desksearch=".urlencode($today)." target=_blank>".number_format($rs_today,0,'',',')."��</a>";
		//���ټ�¼
		$today="and createtime>='$to_sta_date' and createtime<'$to_end_date'";
		$sql_today = "select COUNT(*) AS NUM from crm_contact where 1=1 $today";
		$sql_today=getRoleByUser($sql_today,"createman");
		$rs = $db->Execute($sql_today);
		$rs_today = $rs->fields['NUM'];
		if($rs_today>0)
			echo "<br>���ټ�¼��<a href=../JXC/crm_contact_newai.php?action=init_default&desksearch=".urlencode($today)." target=_blank>".number_format($rs_today,0,'',',')."��</a>";
		//�ɹ���
		$today="and user_flag>0 and createtime>='$to_sta_date' and createtime<'$to_end_date'";
		$sql_today = "select COUNT(*) AS NUM from buyplanmain where 1=1 $today";
		$sql_today=getRoleByUser($sql_today,"createman");
		$rs = $db->Execute($sql_today);
		$rs_today = $rs->fields['NUM'];
		if($rs_today>0)
			echo "<br>�ɹ�����<a href=../JXC/buyplanmain_newai.php?action=init_default&desksearch=".urlencode($today)." target=_blank>".number_format($rs_today,0,'',',')."��</a>";
		//���۵�
		
		$today="and user_flag>0 and createtime>='$to_sta_date' and createtime<'$to_end_date'";
		$sql_today = "select COUNT(*) AS NUM from v_sellcontract where 1=1 $today";
		$sql_today=getRoleByUser($sql_today,"user_id");
		$rs = $db->Execute($sql_today);
		$rs_today = $rs->fields['NUM'];
		if($rs_today>0)
			echo "<br>��ͬ��<a href=../JXC/sellcontract_newai.php?action=init_default&desksearch=".urlencode($today)." target=_blank>".number_format($rs_today,0,'',',')."��</a>";
		
		$sql_today = "select COUNT(*) AS NUM from sellplanmain where billtype=2 $today";
		$sql_today=getRoleByUser($sql_today,"user_id");
		$rs = $db->Execute($sql_today);
		$rs_today = $rs->fields['NUM'];
		if($rs_today>0)
			echo "<br>������<a href=../JXC/sellplanmain_newai.php?action=init_default&desksearch=".urlencode($today)." target=_blank>".number_format($rs_today,0,'',',')."��</a>";
		
		$sql_today = "select COUNT(*) AS NUM from v_sellone where 1=1 $today";
		$sql_today=getRoleByUser($sql_today,"user_id");
		$rs = $db->Execute($sql_today);
		$rs_today = $rs->fields['NUM'];
		if($rs_today>0)
			echo "<br>�������۵���<a href=../JXC/v_sellone_search_newai.php?action=init_default&desksearch=".urlencode($today)." target=_blank>".number_format($rs_today,0,'',',')."��</a>";
		//Ԥ��Ԥ����
		$today="and createtime>='$to_sta_date' and createtime<'$to_end_date'";
		$sql_today = "select COUNT(*) AS NUM from v_accesspreshou where 1=1 $today";
		$sql_today=getRoleByUser($sql_today,"createman");
		$rs = $db->Execute($sql_today);
		$rs_today = $rs->fields['NUM'];
		if($rs_today>0)
			echo "<br>Ԥ�տ<a href=../JXC/accesspreshou_newai.php?action=init_default&desksearch=".urlencode($today)." target=_blank>".number_format($rs_today,0,'',',')."��</a>";

		$sql_today = "select COUNT(*) AS NUM from v_accessprepay where 1=1 $today";
		$sql_today=getRoleByUser($sql_today,"createman");
		$rs = $db->Execute($sql_today);
		$rs_today = $rs->fields['NUM'];
		if($rs_today>0)
			echo "<br>Ԥ���<a href=../JXC/accessprepay_newai.php?action=init_default&desksearch=".urlencode($today)." target=_blank>".number_format($rs_today,0,'',',')."��</a>";
		//�ؿ��
		$today="and createtime>='$to_sta_date' and createtime<'$to_end_date'";
		$sql_today = "select COUNT(*) AS NUM from huikuanrecord where 1=1 $today";
		$sql_today=getRoleByUser($sql_today,"createman");
		$rs = $db->Execute($sql_today);
		$rs_today = $rs->fields['NUM'];
		if($rs_today>0)
			echo "<br>�ؿ<a href=../JXC/huikuanrecord_newai.php?action=init_default&desksearch=".urlencode($today)." target=_blank>".number_format($rs_today,0,'',',')."��</a>";

		$sql_today = "select COUNT(*) AS NUM from fukuanrecord where 1=1 $today";
		$sql_today=getRoleByUser($sql_today,"createman");
		$rs = $db->Execute($sql_today);
		$rs_today = $rs->fields['NUM'];
		if($rs_today>0)
			echo "<br>���<a href=../JXC/fukuanrecord_newai.php?action=init_default&desksearch=".urlencode($today)." target=_blank>".number_format($rs_today,0,'',',')."��</a>";
		//�ͻ�����
		$today="and ����ʱ��>='$to_sta_date' and ����ʱ��<'$to_end_date'";
		$sql_today = "select COUNT(*) AS NUM from crm_service where 1=1 $today";
		$sql_today=getRoleByUser($sql_today,"������");
		$rs = $db->Execute($sql_today);
		$rs_today = $rs->fields['NUM'];
		if($rs_today>0)
			echo "<br>�ͻ�����<a href=../JXC/crm_service_newai.php?action=init_default&desksearch=".urlencode($today)." target=_blank>".number_format($rs_today,0,'',',')."��</a>";
		//���
		$today="and state='�����' and indate>='$to_sta_date' and indate<'$to_end_date'";
		$sql_today = "select COUNT(*) AS NUM from stockinmain where 1=1 $today";
		$sql_today=getRoleByUser($sql_today,"createman");
		$rs = $db->Execute($sql_today);
		$rs_today = $rs->fields['NUM'];
		if($rs_today>0)
			echo "<br>��ⵥ��<a href=../JXC/stockinmain_newai.php?action=init_default&desksearch=".urlencode($today)." target=_blank>".number_format($rs_today,0,'',',')."��</a>";
		//����
		$today="and state='�ѳ���' and outdate>='$to_sta_date' and outdate<'$to_end_date'";
		$sql_today = "select COUNT(*) AS NUM from stockoutmain where 1=1 $today";
		$sql_today=getRoleByUser($sql_today,"createman");
		$rs = $db->Execute($sql_today);
		$rs_today = $rs->fields['NUM'];
		if($rs_today>0)
			echo "<br>���ⵥ��<a href=../JXC/stockoutmain_newai.php?action=init_default&desksearch=".urlencode($today)." target=_blank>".number_format($rs_today,0,'',',')."��</a>";
		//����
		$today="and state='�ѷ���' and fahuodate>='$to_sta_date' and fahuodate<'$to_end_date'";
		$sql_today = "select COUNT(*) AS NUM from fahuodan where 1=1 $today";
		$sql_today=getRoleByUser($sql_today,"fahuoren");
		$rs = $db->Execute($sql_today);
		$rs_today = $rs->fields['NUM'];
		if($rs_today>0)
			echo "<br>��������<a href=../JXC/fahuodan_newai.php?action=init_default&desksearch=".urlencode($today)." target=_blank>".number_format($rs_today,0,'',',')."��</a>";
				
		
		exit;
	}

	if($_GET['action']=="shenhe")
	{
		print "<script>location='crm_workreport_shenhe.php?id=".$_GET['id']."';</script>";
		exit;
	}
	
	if($_GET['action']=="shenhe_finish")
	{
		page_css();
		$billid = $_GET['id'];
		$sql = "update workreport set state='�����',shenheren='".$_SESSION['LOGIN_USER_ID']."',shenhetime=now(),piyu='".$_POST['piyu']."' where id='$billid'";
		$rs = $db->Execute($sql);
		$billinfo= returntablefield("workreport", "id", $billid, "createman,workdate");
		$touser=explode(",",$_POST["tixingren"]);
		$messagetitle="��������";
		$guanlianid=$billid;
		newMessage($billinfo['createman'],$billinfo['workdate']."�Ĺ��������ѱ����",$messagetitle,'../CRM/workreport_newai.php?'.base64_encode('action=view_default&id='.$guanlianid),$guanlianid);
		$return=FormPageAction("action","init_default");
		print_infor("<b>���ͨ��</b>",'trip',"location='?$return'","?".$return,1);
		exit;
	}
	addShortCutByDate("workdate","��������");
	$filetablename		=	'workreport';
	$parse_filename		=	'workreport';
	$SYSTEM_ADD_SQL=getRoleByUser($SYSTEM_ADD_SQL,"createman");
	require_once('include.inc.php');
	systemhelpcontent( "��������", "100%" );
	?>