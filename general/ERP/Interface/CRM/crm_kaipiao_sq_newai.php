<?php
	ini_set('display_errors', 1);
	ini_set('error_reporting', E_ALL);
	error_reporting(E_WARNING | E_ERROR);
	require_once('lib.inc.php');
	$GLOBAL_SESSION=returnsession();


    addShortCutByDate("��������");
    //CRMϵͳ���˸���Ȩ��();

	$SYSTEM_ADD_SQL = " and ¼��Ա='".$_SESSION['LOGIN_USER_ID']."'";
	//$SYSTEM_PRINT_SQL = 1;

	if($_GET['action']=="edit_default_data")		{

		page_css("��Ʊ����");

		$���� = $_POST['����'];
		$sql = "select * from crm_kaipiao_sq where ����='$����'";
		$rs = $db->Execute($sql);
		$rs_a = $rs->GetArray();

		if($rs_a[0]['�Ƿ����'] == 1 && 0){
			print "
			<div align=\"center\" title=\"��˼�¼����\">
			<table class=\"MessageBox\" align=\"center\" width=\"650\"><tr><td class=\"msg info\">
			<div class=\"content\" style=\"font-size:12pt\">&nbsp;&nbsp;�����¼�Ѿ�ͨ����ˣ�ϵͳ��ֹ�༭����.</div>
			</td></tr></table>
			<br>
			<div align=center>
			";
			  print "<input type=button  value=\"����\" class=\"SmallButton\" onClick=\"history.go(-2);\">
			</div>
			";
		   exit;

		}

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



	$filetablename		=	'crm_kaipiao_sq';
	$parse_filename		=	'crm_kaipiao_sq';
	require_once('include.inc.php');

	if($_GET['action']==''||$_GET['action']=='init_default'||$_GET['action']=='init_customer')		{
			$PrintText .= "<BR><table  class=TableBlock align=center width=100%>";
			$PrintText .= "<TR class=TableContent><td ><font color=green >
			˵����<br>
			&nbsp;&nbsp;&nbsp;1��������Ʊ������û��ͨ�����֮ǰ���Խ����޸Ĳ�����<BR>
			&nbsp;&nbsp;&nbsp;2����˺��˻������ܾ�����в����ģ�ֻ���ܾ�������˺��˻ص�Ȩ�ޡ�<BR>
			&nbsp;&nbsp;&nbsp;3��������˻��˻غ�ϵͳ�������ٶ�����в�����<BR>
			</font></td></table>";
			print $PrintText;
		}

	?>
	<?php
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