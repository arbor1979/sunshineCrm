<?php
ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL);

// display warnings and errors
error_reporting(E_WARNING | E_ERROR);


require_once("lib.inc.php");

$GLOBAL_SESSION=returnsession();
$SYSTEM_PRIV_STOP = 1;

require_once('systemprivateinc.php');

//�ж�ѧ����Ϣ�Ƿ�Ϊ��
$��ǰѧ�� = returntablefield("edu_xueqiexec","��ǰѧ��",'1',"ѧ������");
if($��ǰѧ��=="")		{
	page_css("����ѧ����Ϣû������");
	print_infor("����ѧ����Ϣû������,���ڽ������->��ѧ������Ϣ->ѧ��������");
	exit;
}

$TARGET_TITLE = "������Դ-��������";

$TARGET_ARRAY = $PRIVATE_SYSTEM['������Դ']['��������'];

$MenuArray = SystemPrivateInc($TARGET_ARRAY,$TARGET_TITLE);

$fileName = $MenuArray[0][0];

//print_R($MenuArray);
//�����Ӳ˵������
$GROUP_ONE_MENU_NAME = $MenuArray[0][1];
$TARGET_TITLE = $TARGET_TITLE."-".$GROUP_ONE_MENU_NAME;
$TARGET_ARRAY = $TARGET_ARRAY[$GROUP_ONE_MENU_NAME];
$MenuArray = SystemPrivateInc($TARGET_ARRAY,$TARGET_TITLE);
//print_R($MenuArray);
//��������Ӳ˵�Ҳֻ��һ���˵���,��ôֱ�����������˵����Ǹ��˵���
if(count($MenuArray)==1)	{
	$fileName = $MenuArray[0][0];
}

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Frameset//EN">
<HEAD><TITLE>��������</TITLE>
<LINK href="/theme/<?php echo $LOGIN_THEME?>/style.css" type=text/css rel=stylesheet>
<frameset rows="30,*"  cols="*" frameborder="0" border="0" framespacing="0" id="frame1">
    <frame name="file_title" scrolling="no" noresize src="MAIN_XINGZHENGKAOQIN_MENU.php" frameborder="0">
    <frame name="MAIN" scrolling="auto" src="../Help/flowgraph_xingzhengkaoqin.php" frameborder="0">
</frameset>
