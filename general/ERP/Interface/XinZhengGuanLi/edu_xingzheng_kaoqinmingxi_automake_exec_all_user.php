<?php
ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL);

// display warnings and errors
error_reporting(E_WARNING | E_ERROR);

//header("Content-Type:text/html;charset=gbk");
//######################�������-Ȩ�޽��鲿��##########################
require_once("lib.inc.php");
require_once("../../Enginee/lib/version.php");
require_once("lib.xingzheng.inc.php");
//require_once("lib.xiaoli.inc.php");
//
//$GLOBAL_SESSION=returnsession();
$SYSTEM_PRIV_STOP = 1;
//require_once("systemprivateinc.php");
//CheckSystemPrivate("�������-�ճ���ѧ����-��ʦ����");
//######################�������-Ȩ�޽��鲿��##########################

//$SHOWTEXT = '1';

$CurXueQi = returntablefield("edu_xueqiexec","��ǰѧ��",'1',"ѧ������");

//��ͬ�����ڻ���������ݵ�MYSQL���ݿ�
//�õ�����MYSQL�������һ�ο��ڼ�¼ID��ֵ
$sql = "select max(���ڻ�IDֵ) AS ��� from edu_teacherkaoqin";
$rs = $db->Execute($sql);
$���һ�ο��ڼ�¼ID��ֵ = $rs->fields['���'];
if($���һ�ο��ڼ�¼ID��ֵ>0)		 $AddSqlKaoQinJiText = "where $���ڱ�_��EKY>'$���һ�ο��ڼ�¼ID��ֵ'";
else	$AddSqlKaoQinJiText = "";

//#######################################################################################
//ʹ��MSSQL�������Ӳ��ִ���-��ʼ
//#######################################################################################


$_GET['action'] = "DataDeal";

require_once("../EDU/KAOQINJI_ALL.php");


function �Ű���ԱList($��������)			{
	global $db;
	//$��ʼʱ�� = date("Y-m-d",mktime(1,1,1,date('m'),date('d')-1,date('Y')));
	//$����ʱ�� = date("Y-m-d",mktime(1,1,1,date('m'),date('d')+14,date('Y')));
	$sql = "select �Ű���Ա from edu_xingzheng_paiban where ��������='$��������'";
	$rs = $db -> Execute($sql);
	$rs_a = $rs -> GetArray();
	$�Ű���Ա���� = array();
	for($i=0;$i<sizeof($rs_a);$i++)		{
		$�Ű���Ա = $rs_a[$i]['�Ű���Ա'];
		$�Ű���ԱArray = explode(',',$�Ű���Ա);
		for($iX=0;$iX<sizeof($�Ű���ԱArray);$iX++)		{
			$�Ű���ԱX = $�Ű���ԱArray[$iX];
			$�Ű���Ա����[$�Ű���ԱX] = $�Ű���ԱX;
		}
	}
	$�Ű���Ա����K = @array_keys($�Ű���Ա����);
	//$�Ű���Ա = join(',',$�Ű���Ա����K);
	return $�Ű���Ա����K;
}


$��ʼʱ��Array = explode('-',date("Y-m-d"));


//Ĭ��180��,��ʼ��,�������,���������
for($i=-1;$i<5;$i++)		{

		$Datetime	= date("Y-m-d",mktime(1,1,1,$��ʼʱ��Array[1],$��ʼʱ��Array[2] + $i,$��ʼʱ��Array[0]));
		//print "<BR>��ʼ����ǰ��ʦ����:###############<BR>";
		$�Ű���Ա����K = �Ű���ԱList($Datetime);
		for($iX=0;$iX<sizeof($�Ű���Ա����K);$iX++)		{
			$��Ա�û��� = $�Ű���Ա����K[$iX];
			$������Ա = returntablefield("user","USER_ID",$��Ա�û���,"USER_NAME");
			ִ�в���ĳ��ĳ�쿼����Ϣ($CurXueQi,$������Ա,$��Ա�û���,$Datetime);
			ͬ��ĳ��ĳ�쿼�ڻ����ݵ�������ϸ��($������Ա,$��Ա�û���,$Datetime);
		}
		global $SHOWTEXT; if($SHOWTEXT)		print "<BR><BR><font color=red><B>����".$������Ա."��ʦ����:".$Datetime."</B></font><BR>";
}

$����ʱ�� = date("Y-m-d");
$sql = "update `edu_xingzheng_kaoqinmingxi` set �ϰ�ʵ��ˢ��='�ϰ�ȱ��',�ϰ࿼��״̬  ='�ϰ�ȱ��' where �ϰ�ʵ��ˢ��='' and �ϰ࿼��״̬  ='' and ����<'$����ʱ��'";
$db->Execute($sql);
$sql = "update `edu_xingzheng_kaoqinmingxi` set �°�ʵ��ˢ��='�°�ȱ��',�°࿼��״̬  ='�°�ȱ��' where �°�ʵ��ˢ��='' and �°࿼��״̬  ='' and ����<'$����ʱ��'";
$db->Execute($sql);
global $SHOWTEXT; if($SHOWTEXT)		print "<BR><font color=red>*******:$sql <BR></font>";

����ٵ����˷���������();

//print_R($_GET);
$sql = "update TD_OA.office_task set LAST_EXEC='".date( "Y-m-d" )."' where TASK_CODE = 'XINGZHENG_KAOQIN'";
$db->Execute($sql);
$sql = "update TD_OA.office_task set LAST_EXEC='".date( "Y-m-d" )."' where TASK_CODE = 'XINGZHENG_KAOQIN2'";
$db->Execute($sql);


print "+OK";




?>