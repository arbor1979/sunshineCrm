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

CheckSystemPrivate("������Դ-��������-ԭʼ��");
//######################�������-Ȩ�޽��鲿��##########################

//$��ǰѧ�� = returntablefield("edu_xueqiexec","��ǰѧ��",'1',"ѧ������");
//if($_GET['ѧ��']=="") $_GET['ѧ��'] = $��ǰѧ��;



	//###########################################
	//����ֲ��Ź���Ȩ�޲���-��ʼ
	//###########################################
	$SCRIPT_NAME	= "edu_xingzhengkaoqin_newai.php";
	$LOGIN_USER_ID		= $_SESSION['LOGIN_USER_ID'];
	$sql = "select * from systemprivateinc where `FILE`='$SCRIPT_NAME' and (USER_ID like '%,".$LOGIN_USER_ID.",%' or USER_ID like '".$LOGIN_USER_ID.",%')";
	//print $sql;
	$rs = $db->Execute($sql);
	$rs_a = $rs->GetArray();
	$MODULE_ARRAY = array();
	for($i=0;$i<sizeof($rs_a);$i++)		{
		$MODULE_ARRAY[] = $rs_a[$i]['MODULE'];
	}
	$MODULE_TEXT = join("','",$MODULE_ARRAY);
	//if($MODULE_TEXT=="")  $MODULE_TEXT = "δָ��������Ϣ";
	//if($_GET['action']==""||$_GET['action']=="init_default")
	$sql = "select USER_ID from user,department where user.DEPT_ID=department.DEPT_ID and department.DEPT_NAME in ('$MODULE_TEXT')";
	//print $sql;
	$rs = $db->Execute($sql);
	$rs_a = $rs->GetArray();
	$USER_ARRAY = array();
	for($i=0;$i<sizeof($rs_a);$i++)		{
		$USER_ARRAY[] = $rs_a[$i]['USER_ID'];
	}
	$USER_TEXT = join("','",$USER_ARRAY);

	if($USER_TEXT=="")		{
		$�û�TEXT = "û����������û���Ϣ";
		$_GET['�û���'] = $�û�TEXT;
	}
	else	{
		$_GET['�û���'] = $USER_TEXT;
	}
	//$SYSTEM_PRINT_SQL = 1;
	//###########################################
	//����ֲ��Ź���Ȩ�޲���-����
	//###########################################


addShortCutByDate("��������");

if($_GET['action']=="init_default"||$_GET['action']=="")					{
	//print "		<table border=0 class=TableBlock width=100% height=20>		<tr class=TableData><td valign=bottom align=left>�ò������ݴӿ��ڻ�������ȡ,���ݸ�ʽ��:��ʦ�û���,��ʦ����,��������,ˢ��ʱ��.���ݵ���ǰ,����<input type=button accesskey=c name=cancel value=\"ɾ�����¿�������\" class=SmallButton onClick=\"location='?".base64_encode("action=DeleteCurMonth")."'\" > <BR></td></tr>		</table><BR>		";
}

if($_GET['action']=="DeleteCurMonth")					{
	page_css("��������������...");
	$LikeMonth = date("Y-m-",mktime(1,1,1,date("m")-1,date("d"),date("Y")));
	$sql = "delete from edu_teacherkaoqin where �������� like '$LikeMonth%'";
	$db->Execute($sql);
	//exit;
	print "
		<table border=0 class=TableBlock width=100% height=20>
		<tr class=TableHeader><td valign=bottom align=left>���¿�����Ϣ�Ѿ���ɾ��,��������µ�����¿�������,ϵͳ������...<BR></td></tr>
		</table><BR>
		";
	EDU_Indextopage('?',$nums='0');
	exit;
}


$filetablename='edu_teacherkaoqin';
require_once('include.inc.php');


require_once('../Help/module_xingzhengkaoqin_yuanshidaka.php');

?>