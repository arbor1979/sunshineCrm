<?php

require_once('../EDU/lib.inc.php');
?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Frameset//EN">
<HTML><HEAD><TITLE>�������ڹ���������</TITLE><LINK href="images/style.css" type=text/css
rel=stylesheet>
<SCRIPT src="images/ccorrect_btn.js"></SCRIPT>
<META http-equiv=Content-Type content="text/html; charset=gb2312">
<META content="MSHTML 6.00.6000.16735" name=GENERATOR></HEAD>
<?php

$MenuArray[] = array("edu_xingzheng_kaoqinbudeng_newai.php","���ڲ���","���ڲ���");
$MenuArray[] = array("edu_xingzheng_qingjia_newai.php","������","������");
$MenuArray[] = array("edu_xingzheng_jiabanbuxiu_newai.php","�Ӱಹ��","�Ӱಹ��");
$MenuArray[] = array("edu_xingzheng_tiaoxiububan_newai.php","���ݲ���","���ݲ���");
$MenuArray[] = array("edu_xingzheng_tiaoban_newai.php","�����¼","�����¼");
$MenuArray[] = array("edu_xingzheng_tiaobanxianghu_newai.php","�໥����","�໥����");

$fileName = $MenuArray[0][0];

//print_R($MenuArray);
//��������Ӳ˵�Ҳֻ��һ���˵���,��ôֱ�����������˵����Ǹ��˵���
if(count($MenuArray)==1)	{
	EDU_Indextopage($MenuArray[0][0]);
	exit;
}

?>
<FRAMESET id=frame1 border=0 frameSpacing=0 rows=30,* frameBorder=NO cols=*>
<FRAME name=menu_top src="edu_xingzheng_workflow_menu.php" frameBorder=0 noResize scrolling=no>
<FRAME name=menu_main_frame src="<?php echo $fileName?>" frameBorder=0 noResize></FRAMESET>
</HTML>
