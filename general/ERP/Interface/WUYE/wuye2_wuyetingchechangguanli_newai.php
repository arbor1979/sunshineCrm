<?php
	ini_set('display_errors', 1);
	ini_set('error_reporting', E_ALL);
	error_reporting(E_WARNING | E_ERROR);
	require_once('lib.inc.php');
	$GLOBAL_SESSION=returnsession();



	

	if($_GET['action']=="add_default_data")		
	{
		//�������ӵĳ�λ�ǹ��Ѿ�����ʹ��
		$ͣ��λ = $_POST['ͣ��λ'];
		if($ͣ��λ==""){
		   echo "<a class=OrgAdd href=\"#\" onClick=\"return confirm('ͣ��λ����Ϊ��!')\"></a> ";
		   //echo "�����˴�<a href=javascript:history.go(-1);>����</a><br>";
		   exit;
		}

		$sql = "select COUNT(*) AS num from wuye_wuyetingchechangguanli where ͣ��λ='$ͣ��λ'";
		$�������� = returntablefield("wuye_wuyetingchechangguanli","ͣ��λ",$ͣ��λ,"��������");

		//echo $rs_a;
		if($��������!=""){
		   //echo "<a class=OrgAdd href=\"#\" onClick=\"return confirm('�˳�λ�Ѿ����û�ʹ��!')\">��ʾ</a> "; 
		   // Message("2","�˳�λ�Ѿ����û�ʹ��");

		   echo "<font size=6><center><b>�˳�λ�Ѿ����û�ʹ��,�����˴�<a href=javascript:history.go(-1);>����</a></b></center></font><br>";
		   exit;
		}
    }
		

	$_GET['��λ״̬'] ="��";

	$filetablename = 'wuye_wuyetingchechangguanli';
	$parse_filename	= 'wuye2_wuyetingchechangguanli';
	require_once('include.inc.php');

	if($_GET['action']==''||$_GET['action']=='init_default'||$_GET['action']=='init_customer')		{
		$PrintText .= "<BR><table  class=TableBlock align=center width=100%>";
		$PrintText .= "<TR class=TableContent><td ><font color=green >
		˵����<BR>
		&nbsp;&nbsp;1 �����ڴ�ҳ����г�λ�ĳ�ʼ���������г�λ��ʼ����<BR>
		&nbsp;&nbsp;2 �����ҳ��ֻ�轫��Ӧ�ĳ��⳵λ�ŵĳ�λ״̬����Ϊ�ѳ��ۻ��Գ��⡣<BR>
		&nbsp;&nbsp;3 Ȼ����Ӧ���ѳ��ۻ��Գ���ҳ����д��Ӧ����Ϣ��
		</font></td></table>";
		print $PrintText;
	}
?>