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
//CheckSystemPrivate("�������-�ճ���ѧ����-��ʦ����");
//######################�������-Ȩ�޽��鲿��##########################

//print_R($_GET);

	//��ι��˲���,����ֶα�����Ϊ���ط�������--��ʼ
	$LOGIN_USER_NAME = $_SESSION['LOGIN_USER_NAME'];
	$sql = "select ������� from edu_xingzheng_banci where ��ι���һ='$LOGIN_USER_NAME' or ��ι����='$LOGIN_USER_NAME'";
	$rs = $db->Execute($sql);
	$rs_a = $rs->GetArray();
	$������� = array();
	for($i=0;$i<sizeof($rs_a);$i++)						{
		$Element = $rs_a[$i];
		$�������[]  = $Element['�������'];
	}
	$�������TEXT = join(',',$�������);
	if($�������TEXT=="")	$�������TEXT = "û��������İ����Ϣ";
	$_GET['���'] = $�������TEXT;
	//��ι��˲���,����ֶα�����Ϊ���ط�������--����

$��ǰѧ�� = returntablefield("edu_xueqiexec","��ǰѧ��",'1',"ѧ������");
if($_GET['ѧ��']=="") $_GET['ѧ��'] = $��ǰѧ��;

$filetablename='edu_teacherkaoqin';
$parse_filename = 'my_bumen_xingzheng_kaoqin';

require_once('include.inc.php');



?>