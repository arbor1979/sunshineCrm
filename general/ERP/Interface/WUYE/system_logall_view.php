<?php
	ini_set('display_errors', 1);
	ini_set('error_reporting', E_ALL);
	error_reporting(E_WARNING | E_ERROR);
	require_once('lib.inc.php');
	$GLOBAL_SESSION=returnsession();

	page_css("MYSQL ���ܼ��");


	//�Զ����������ǰ����ʷ��¼
	$sql = "delete from system_logall where datediff(now(),��ǰʱ��)>=7";
	$db->Execute($sql);


	$sql = "select DATE_FORMAT(��ǰʱ��,'%Y-%m-%d') AS ��ǰʱ��
		from system_logall
		group by DATE_FORMAT(��ǰʱ��,'%Y-%m-%d')
		order by ��ǰʱ�� desc
		";
	$rs = $db->CacheExecute(5,$sql);
	$rs_a = $rs->GetArray();
	for($i=0;$i<sizeof($rs_a);$i++)			{
		$��ǰʱ��TEXT .= "<a href='?".base64_encode("XX=XX&&��ǰʱ��=".$rs_a[$i]['��ǰʱ��']."&&XX=XX")."'>".$rs_a[$i]['��ǰʱ��']."</a> ";
	}

	if($_GET['��ǰʱ��']!='')	$ͳ��ʱ�� = $_GET['��ǰʱ��'];
	else						$ͳ��ʱ�� = $rs_a[0]['��ǰʱ��'];



	table_begin("100%");
	print "<tr class=TableData ><td>MYSQL ���������� ʱ��:".$ͳ��ʱ��." $��ǰʱ��TEXT
	<input type=\"button\" class=\"SmallButton\" value=\"����\" onclick=\"location='database_setting.php'\">
	<input type=\"button\" class=\"SmallButton\" value=\"��ϸ\" onclick=\"location='system_logall_newai.php'\">
	</td></tr>";
	table_end();
	print "<BR>";


	table_begin("780");
	print_title("MYSQL �߳�����������[��СʱΪ��λͳ��] <a href=\"system_logall_mysqlthreads.php?".base64_encode("XX=XX&&ͳ��ʱ��=".$ͳ��ʱ��."&ͳ�Ƶ�λ=��&XX=XX")."\" target=_blank>�鿴����Ϊ��λ��ͳ��ͼ</a>");
	print "<tr class=TableData ><td><img src='system_logall_mysqlthreads.php?".base64_encode("XX=XX&&ͳ��ʱ��=".$ͳ��ʱ��."&&XX=XX")."' width=100% border=0></td></tr>";
	print_title("MYSQL ��ѯ��������������[��СʱΪ��λͳ��] <a href=\"system_logall_querycache.php?".base64_encode("XX=XX&&ͳ��ʱ��=".$ͳ��ʱ��."&ͳ�Ƶ�λ=��&XX=XX")."\" target=_blank>�鿴����Ϊ��λ��ͳ��ͼ</a>");
	print "<tr class=TableData ><td><img src='system_logall_querycache.php?".base64_encode("XX=XX&&ͳ��ʱ��=".$ͳ��ʱ��."&&XX=XX")."' width=100% border=0></td></tr>";
	table_end();

?>