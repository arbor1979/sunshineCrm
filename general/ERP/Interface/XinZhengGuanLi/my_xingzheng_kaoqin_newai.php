<?php
ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL);

// display warnings and errors
error_reporting(E_WARNING | E_ERROR);

//header("Content-Type:text/html;charset=gbk");
//######################�������-Ȩ�޽��鲿��##########################
require_once("lib.inc.php");

$GLOBAL_SESSION=returnsession();
$SYSTEM_PRIV_STOP = 1;
require_once("systemprivateinc.php");
//CheckSystemPrivate("������Դ-��������-�ҵĿ���");
//######################�������-Ȩ�޽��鲿��##########################

//print_R($_GET);
$��ǰѧ�� = returntablefield("edu_xueqiexec","��ǰѧ��",'1',"ѧ������");
if($_GET['ѧ��']=="") $_GET['ѧ��'] = $��ǰѧ��;

$_GET['��ʦ����'] = $_SESSION['LOGIN_USER_NAME'];
$_GET['��ʦ�û���'] = $_SESSION['LOGIN_USER_ID'];

$SYSTEM_ADD_SQL = " and ��ʦ�û���='".$_GET['��ʦ�û���']."'";
//$SYSTEM_PRINT_SQL = 1;

$filetablename='edu_teacherkaoqin';
$parse_filename = 'my_xingzheng_kaoqin';

require_once('include.inc.php');



require_once('../Help/module_kaoqinji.php');

?>