<?php
ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL);

// display warnings and errors
error_reporting(E_WARNING | E_ERROR);
//######################�������-Ȩ�޽��鲿��##########################
SESSION_START();
require_once("lib.inc.php");
$GLOBAL_SESSION=returnsession();
require_once("systemprivateinc.php");
//CheckSystemPrivate("ϵͳ��Ϣ����-��֯��������");
//######################�������-Ȩ�޽��鲿��##########################

//�ж�ѧ����Ϣ�Ƿ�Ϊ��
//$��ǰѧ�� = returntablefield("edu_xueqiexec","��ǰѧ��",'1',"ѧ������");
//if($��ǰѧ��=="")		{
//	page_css("����ѧ����Ϣû������");
//	print_infor("����ѧ����Ϣû������,���ڽ������->��ѧ������Ϣ->ѧ��������");
//	exit;
//}


$GLOBAL_SESSION=returnsession();
$IsWin = IsWin();
$fileName = "../../Framework/inc_dorm_page.php";
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Frameset//EN">
<HEAD><TITLE>��֯��������</TITLE>
<LINK href="<?php echo ROOT_DIR?>theme/<?php echo $LOGIN_THEME?>/style.css" type=text/css rel=stylesheet>
<frameset rows="30,*"  cols="*" frameborder="0" border="0" framespacing="0" id="frame1">
    <frame name="file_title" scrolling="no" noresize src="MAIN_UNIT_MENU.php" frameborder="0">
     <frame name="menu_main_frame" scrolling="auto" src="unit_newai.php" frameborder="0">

</frameset><?php
/*
	��Ȩ����:֣�ݵ���Ƽ�������޹�˾;
	��ϵ��ʽ:0371-69663266;
	��˾��ַ:����֣�ݾ��ü��������������־�����·ͨ�Ų�ҵ԰��¥����;
	��˾���:֣�ݵ���Ƽ�������޹�˾λ���й��в�����-֣��,������2007��1��,�����ڰѻ����Ƚ���Ϣ����������ͨ�ż���������ѹ�����ҵ��ʵ���ռ���������ҵ�ͻ��Ĺ�����ҵ���»�У�ȫ���ṩ��������֪ʶ��Ȩ�Ľ�����������������������������в�������ĸ�У���������������СѧУ��������ṩ�̡�Ŀǰ�����ж�Ҹ�ְ����ְ��ԺУʹ��ͨ���в��з����Ŀ���������ͷ���;

	�������:����Ƽ�������������Լܹ�ƽ̨,�Լ��������֮����չ���κ��������Ʒ;
	����Э��:���ֻ�У԰��ƷΪ��ҵ���,�������ΪLICENSE��ʽ;����CRMϵͳ��SunshineCRMϵͳΪGPLV3Э�����,GPLV3Э����������뵽�ٶ�����;
	��������:�����ʹ�õ�ADODB��,PHPEXCEL��,SMTARY���ԭ��������,���´���������������;
	*/
?>