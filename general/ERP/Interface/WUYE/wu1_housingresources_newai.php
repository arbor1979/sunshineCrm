<?php
	ini_set('display_errors', 1);
	ini_set('error_reporting', E_ALL);
	error_reporting(E_WARNING | E_ERROR);
	require_once('lib.inc.php');
	$GLOBAL_SESSION=returnsession();

	$_GET['��Ԫ״̬'] = "��";

	$filetablename		=	'wu_housingresources';
	$parse_filename		=	'wu1_housingresources';
	require_once('include.inc.php');

	if($_GET['action']==''||$_GET['action']=='init_default'||$_GET['action']=='init_customer')		{
		$PrintText .= "<BR><table  class=TableBlock align=center width=100%>";
		$PrintText .= "<TR class=TableContent><td ><font color=green >
		˵����<BR>
		&nbsp;&nbsp;&nbsp;&nbsp;1 ����˷������۳������������ƿͻ����ϡ����������������µ������ͻ�����ͻ�����ҳ�棬Ȼ���������ϱ��档<BR>
		&nbsp;&nbsp;&nbsp;&nbsp;2 ��������������µ������ͻ�����ͻ�����ҳ�棬Ȼ���������ϱ��档<BR>
		&nbsp;&nbsp;&nbsp;&nbsp;3 �ͻ��������ƺ󣬵�������������µ������������ť�����Ʒ���������ϡ�<BR>
		&nbsp;&nbsp;&nbsp;&nbsp;4 <font color=\"red\">ע�⣺</font>�ڵ�������������ҳ���ｫ����״̬��Ϊ���ǿա���<BR>
		</font></td></table>";
		print $PrintText;
	}
	?>
