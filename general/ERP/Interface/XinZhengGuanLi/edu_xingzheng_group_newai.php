<?php
	require_once('lib.inc.php');

	$GLOBAL_SESSION=returnsession();
$SYSTEM_PRIV_STOP = 1;

	require_once("systemprivateinc.php");

	CheckSystemPrivate("������Դ-��������-���");

	if($_GET['action'] == "add_default_data")
	{
		//print_R($_GET);
		//print_R($_POST);

		$���������� = $_POST['����������'];
		$_POST['��Ա����'] = $_POST['COPY_TO_ID'];
		$��ע = $_POST['��ע'];
		$������ = $_POST['������'];
		$����ʱ�� = $_POST['����ʱ��'];
		//$sql = "insert into edu_xingzheng_group values('','".$����������."','".$��Ա����."','".$��ע."','".$������."','".$����ʱ��."')";
		//print $sql;exit;
		//$result = $db -> Execute($sql);
		//print "<meta http-equiv='refresh' content='1;url=?'>";
		//exit;
	}
	if($_GET['action'] == "edit_default_data")
	{
		//print_R($_GET);
		//print_R($_POST);
		//$��¼��� = $_GET['���'];
		$_POST['��Ա����'] = $_POST['COPY_TO_ID'];
		//$sql = "update edu_xingzheng_group set ��Ա����='".$��Ա����."' where ���=".$��¼���;
		//print $sql;//exit;
		//$db -> Execute($sql);
		//print "<meta http-equiv='refresh' content='1;url=?'>";
		//exit;
	}

	$filetablename='edu_xingzheng_group';
	require_once('include.inc.php');


require_once("lib.xingzheng.inc.php");
//��ʱִ�к���($��������='�Զ�����������������ְ��Ա�����Ķ�������',$���ʱ��='30');

require_once('../Help/module_xingzhengkaoqin.php');



?>