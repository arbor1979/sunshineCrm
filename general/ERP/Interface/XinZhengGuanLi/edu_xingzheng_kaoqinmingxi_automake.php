<?php
ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL);

// display warnings and errors
error_reporting(E_WARNING | E_ERROR);

//######################�������-Ȩ�޽��鲿��##########################
require_once("lib.inc.php");
require_once("../../Enginee/lib/version.php");
//require_once("lib.xingzheng.inc.php");
require_once("lib.xiaoli.inc.php");
$GLOBAL_SESSION=returnsession();
$SYSTEM_PRIV_STOP = 1;
page_css();

require_once("systemprivateinc.php");
//CheckSystemPrivate("�������-�ճ���ѧ����-��ʦ����");
//######################�������-Ȩ�޽��鲿��##########################


//����:ֻ����ͬ�����ڻ����ݵ�edu_teacherkaoqin��,ע:�Ѿ��ڽ�ʦ������ʵ��,�˴����ڱ���ʹ��
//2010-2-26�޸�

$CurXueQi = returntablefield("edu_xueqiexec","��ǰѧ��",'1',"ѧ������");






/*

TRUNCATE TABLE `edu_xingzheng_kaoqinmingxi` ;
TRUNCATE TABLE `edu_teacherkaoqin` ;

*/

//�õ�����MYSQL�������һ�ο��ڼ�¼ID��ֵ
$sql = "select max(���ڻ�IDֵ) AS ��� from edu_teacherkaoqin";
$rs = $db->Execute($sql);
$���һ�ο��ڼ�¼ID��ֵ = $rs->fields['���'];
if($���һ�ο��ڼ�¼ID��ֵ>0)		 $AddSqlKaoQinJiText = "where $���ڱ�_��EKY>'$���һ�ο��ڼ�¼ID��ֵ'";
else	$AddSqlKaoQinJiText = "";





//#######################################################################################
//ʹ��MSSQL�������Ӳ��ִ���-��ʼ
//#######################################################################################
if($SYSTEM_VERSION_CONTENT=="TONGDA")					{
	page_css("�Զ�����Ƿ�װMSSQL���ݿ���Ϣ");
	print_infor("���ķ�����û�м�⵽���ڻ�SQL SERVER���ݿ���Ϣ,��ȷ��װ��ָ���ͺŵĿ��ڻ����ͺ����ݿ���ٽ��ж�ȡ������Ϣ����,VERSION INFOR IS ERROR",'stop',"location='?'");
	exit;
}

if($SYSTEM_VERSION_CONTENT=="JMQX")					{
	include "../EDU/KAOQINJI_JMQX.php";
	exit;
}

if($SYSTEM_VERSION_CONTENT=="HCVT")					{
	include "../EDU/KAOQINJI_HCVT.php";
	exit;
}

if($SYSTEM_VERSION_CONTENT=="FJHG")					{
	include "../EDU/KAOQINJI_FJHG.php";
	exit;
}


?>