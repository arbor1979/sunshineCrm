<?php
require_once('lib.inc.php');//

$GLOBAL_SESSION=returnsession();
$SYSTEM_PRIV_STOP = 1;
require_once("systemprivateinc.php");
//CheckSystemPrivate("������Դ-��������-�ҵĿ���");
//print_R($_SESSION);
$_GET['��Ա'] = $_SESSION['LOGIN_USER_NAME'];
$_GET['��Ա�û���'] = $_SESSION['LOGIN_USER_ID'];

$��ǰѧ�� = returntablefield("edu_xueqiexec","��ǰѧ��",'1',"ѧ������");
if($_GET['ѧ��']=="") $_GET['ѧ��'] = $��ǰѧ��;

$SYSTEM_ADD_SQL = " and ��Ա�û���='".$_GET['��Ա�û���']."'";
//$SYSTEM_PRINT_SQL = 1;

addShortCutByDate("����");

$filetablename='edu_xingzheng_kaoqinmingxi';
$parse_filename = 'my_xingzheng_kaoqinmingxi';



require_once('include.inc.php');



require_once('../Help/module_xingzhengkaoqin.php');


if($_GET['action']==''||$_GET['action']=='init_default')		{
	$PrintText = "<BR><table  class=TableBlock align=center width=100%>";
	$PrintText .= "<TR class=TableContent><td ><font color=green >
ע�⣺�˴���Ϊ���˵��������������Ϣ,��Ϊ��ѯ��ʾ����,�����Ű๦�������ֻ�У԰->������Դ->�������ڲ˵��н��з�����Űࡣ
</font></td></table>";
	print $PrintText;
}

?>