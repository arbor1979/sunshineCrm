<?php
	ini_set('display_errors', 1);
	ini_set('error_reporting', E_ALL);
	error_reporting(E_WARNING | E_ERROR);
	require_once('lib.inc.php');
	$GLOBAL_SESSION=returnsession();
	addShortCutByDate("��������");


	if($_GET['action']=="edit_default_data")		{
		page_css("�ӳٸ���");

		if($_POST['�Ƿ����'] == 2 || $_POST['�Ƿ����']==3){
		   $_POST['�������'] = date("Y-m-d");
		   $_POST['�����'] = $_SESSION['LOGIN_USER_ID'];
		   $��ע   = $_POST['��ע'];
		   //����ַ���
           $bz = substr($��ע,0,7);
		   if($bz != "<�����"){
		      //$_POST['��ע'] = "<�����:".$�����.">".$_POST['��ע'];
		   }
		}

		if($_POST['�Ƿ�����'] == '1'){
		   $_POST['��������'] = date("Y-m-d H:i:s");
		   $������ = $_SESSION['LOGIN_USER_ID'];
		   $_POST['��ע'] = "<�����ˣ�".$������.">".$_POST['��ע'];
		}


		$���� = $_POST['����'];
		$sql = "select �Ƿ����� from crm_yanchifukuan_sq where ����='$����'";
		$rs = $db->Execute($sql);
		$rs_a = $rs->GetArray();
		if($rs_a[0]['�Ƿ�����'] == 1){
		   print "
			<div align=\"center\" title=\"���ϼ�¼����\">
			<table class=\"MessageBox\" align=\"center\" width=\"650\"><tr><td class=\"msg info\">
			<div class=\"content\" style=\"font-size:12pt\">&nbsp;&nbsp;�����¼�Ѿ����ϣ�ϵͳ��ֹ����.</div>
			</td></tr></table>
			<br>
			<div align=center>
			";
			  print "<input type=button  value=\"����\" class=\"SmallButton\" onClick=\"history.go(-2);\">
			</div>
			";
		   exit;
		}
	}



	$filetablename		=	'crm_yanchifukuan_sq';
	$parse_filename		=	'crm_yanchifukuan_jlsq';
	require_once('include.inc.php');


	if($_GET['action']==''||$_GET['action']=='init_default'||$_GET['action']=='init_customer')		{
			$PrintText .= "<BR><table  class=TableBlock align=center width=100%>";
			$PrintText .= "<TR class=TableContent><td ><font color=green >
			˵����<BR>
			&nbsp;&nbsp;&nbsp;&nbsp;1���ܾ�����Զ�����Ĳ������ݽ����޸ģ����������޸Ľ�����˺��˻ز���.<BR>
			&nbsp;&nbsp;&nbsp;&nbsp;2�������Ӧ��¼�Ѿ���˻��˻أ�ϵͳ����ֹ������в���.<BR>
			</font></td></table>";
			print $PrintText;
		}

	/*
	��Ȩ����:֣�ݵ���Ƽ�������޹�˾;
	��ϵ��ʽ:0371-69663266;
	��˾��ַ:����֣�ݾ��ü��������������־�����·ͨ�Ų�ҵ԰��¥����;
	��˾���:֣�ݵ���Ƽ�������޹�˾λ���й��в�����-֣��,������2007��1��,�����ڰѻ����Ƚ���Ϣ����������ͨ�ż���������ѹ�����ҵ��ʵ���ռ���������ҵ�ͻ��Ĺ�����ҵ���»�У�ȫ���ṩ��������֪ʶ��Ȩ�Ľ�����������������������������в�������ĸ�У���������������СѧУ��������ṩ�̡�Ŀǰ�Ѿ��ж�Ҹ�ְ����ְ��ԺУʹ��ͨ���в��з����Ŀ���������ͷ���;

	�������:����Ƽ�������������Լܹ�ƽ̨,�Լ��������֮����չ���κ��������Ʒ;
	����Э��:���ֻ�У԰��ƷΪ��ҵ���,�������ΪLICENSE��ʽ;����CRMϵͳ��SunshineCRMϵͳΪGPLV3Э�����,GPLV3Э����������뵽�ٶ�����;
	��������:�����ʹ�õ�ADODB��,PHPEXCEL��,SMTARY���ԭ��������,���´���������������;
	*/
?>