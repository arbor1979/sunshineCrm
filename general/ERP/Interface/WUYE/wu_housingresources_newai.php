<?php
	ini_set('display_errors', 1);
	ini_set('error_reporting', E_ALL);
	error_reporting(E_WARNING | E_ERROR);
	require_once('lib.inc.php');
	$GLOBAL_SESSION=returnsession();

    /*
	if($_GET['action']=="add_default_data")		{
		
		//print_r($_POST);
		//echo "<br>";
        
		$������� = $_POST['�������'];
	    $ҵ������ = $_POST['ҵ������'];

		$sel_sql = "select * from wu_housingowner where �������='$�������' and ҵ������='$ҵ������'";
		$result = $db->Execute($sel_sql);
		$rows = $result->GetArray();

		$�ֻ����� = $rows[0]['�ֻ�'];
		$�绰���� = $rows[0]['�绰'];
		$ҵ���绰 = $�ֻ�����."��".$�绰����;

        $up_sql = "update wu_housingresources set ҵ���绰='$ҵ���绰' where �������='$�������' and ҵ������='$ҵ������'";
        $db->Execute($up_sql);
	  
	}
    */


     /*
	if($_GET['action']=="edit_default_data")		{
		
		//print_r($_POST);
		//echo "<br>";
		
        $������� = $_POST['�������'];
		$�������� = $_POST['��������'];
		$��¥���� = $_POST['��¥����'];
        $��Ԫ��   = $_POST['��Ԫ��'];
		$¥���   = $_POST['¥���'];
		$�����   = $_POST['�����'];

	    $������� = $������� = $��¥����."-".$��Ԫ��."-".$¥���.$�����;

        $sel_sql = "select * from wu_housingowner where �������='$�������' and ��Ԫ���='$�������'";
		$result = $db->Execute($sel_sql);
		$rows = $result->GetArray();
        
		$ҵ������ = $rows[0]['ҵ������'];
		$�ֻ����� = $rows[0]['�ֻ�'];
		$�绰���� = $rows[0]['�绰'];
		$ҵ���绰 = $�ֻ�����."��".$�绰����;
        
		
        echo $�������."<br>";
		echo $��������."<br>";
		echo $��¥����."<br>";
	    echo $ҵ������."<br>";
        echo $ҵ���绰."<br>";
      
        
		//$selet_sql = "select * from ";
        


		$sql = "update wu_housingresources set �������='$�������',ҵ������='$ҵ������',ҵ���绰='$ҵ���绰' where �������='$�������' and ��������='$��������' and ��¥����='$��¥����' and ��Ԫ״̬='�Ѿ���ס'";
        
		//echo $sql;
		$db->Execute($sql);

		//exit;


	}
    */

	$_GET['��Ԫ״̬'] = "�Ѿ���ס,�ѹ�δ��ס,�칫����";
    
	$filetablename		=	'wu_housingresources';
	$parse_filename		=	'wu_housingresources';
	require_once('include.inc.php');

	if($_GET['action']==''||$_GET['action']=='init_default'||$_GET['action']=='init_customer')		{
		$PrintText .= "<BR><table  class=TableBlock align=center width=100%>";
		$PrintText .= "<TR class=TableContent><td ><font color=green >
		˵����<BR>
		&nbsp;&nbsp;&nbsp;&nbsp;1 �ӿշ�����ҳ�����Ʒ������Ϻ󣬴�ʱ������롢ҵ���������绰�����ǿա�<BR>
        &nbsp;&nbsp;&nbsp;&nbsp;2 �����Ӧ��ı༭��ť��Ȼ�󱣴棬ϵͳ���Զ�����Ӧ�Ŀͻ����ϸ����������<br>
		&nbsp;&nbsp;&nbsp;&nbsp;3 �������ڶ�Ӧ������ɷѡ����ޡ�Ͷ�ߡ���λ�����ҵ��
		</font></td></table>";
		print $PrintText;
	}

	?>