<?php
	require_once("lib.inc.php");
	
	$GLOBAL_SESSION=returnsession();

	$common_html=returnsystemlang('common_html');



	$_GET['��������'] = returntablefield("department","DEPT_ID",$_SESSION['LOGIN_DEPT_ID'],"DEPT_NAME");

	$_GET['����״̬'] = "����δ����,�����ѷ���,�ʲ��ѷ���,�ʲ��ѹ黹";

	$_GET['action']=checkreadaction('init_customer');

	$filetablename='fixedasset';
	$parse_filename = 'fixedasset_department';

	print "<script>name = \"win\";</script><div align=left >&nbsp;<a href=\"#\" onClick=\"history.goback();\" target=win>����鿴���������ʲ��б�</a></div>";
	require_once('include.inc.php');

 ?>