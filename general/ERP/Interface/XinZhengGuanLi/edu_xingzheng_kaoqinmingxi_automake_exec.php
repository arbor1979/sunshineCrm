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


$CurXueQi = returntablefield("edu_xueqiexec","��ǰѧ��",'1',"ѧ������");


$_GET['������Ա'] = $_SESSION['LOGIN_USER_NAME'];
$��Ա�û���  = $_SESSION['LOGIN_USER_ID'];
$_REQUEST['��ʼʱ��'] = date("Y-m-d");

if($_GET['������Ա']=='')	{print "û�г�ʼ����Ա��������Ϣ";exit;}

$SHOWTEXT = "1";

page_css("��ʼ������");

require_once("lib.xingzheng.inc.php");
//XiaoLiArray();

//����ʱ�䰴ʱ���������ִ��


//print_R($_REQUEST);
$��ʼʱ�� = $_REQUEST['��ʼʱ��'];
$����ʱ�� = $_REQUEST['����ʱ��'];
$��ʼʱ��Array = explode('-',$��ʼʱ��);
$����ʱ��Array = explode('-',$����ʱ��);
$������Ա = $_GET['������Ա'];


//Ĭ��180��,��ʼ��,�������,���������
for($i=-1;$i<14;$i++)		{

		$Datetime	= date("Y-m-d",mktime(1,1,1,$��ʼʱ��Array[1],$��ʼʱ��Array[2] + $i,$��ʼʱ��Array[0]));
		$�����дʱ�� = date("Y-m-d",mktime(1,1,1,$��ʼʱ��Array[1],$��ʼʱ��Array[2] + $i + 10,$��ʼʱ��Array[0]));
		$����ʱ�� = date("Y-m-d");

		//print "<BR>��ʼ����ǰ��ʦ����:###############<BR>";
		ִ�в���ĳ��ĳ�쿼����Ϣ($CurXueQi,$������Ա,$��Ա�û���,$Datetime);
		ͬ��ĳ��ĳ�쿼�ڻ����ݵ�������ϸ��($������Ա,$��Ա�û���,$Datetime);
		//print "<font color=green>����".$_REQUEST['������Ա']."��ʦ����:".$Datetime."</font><BR>";
		//��ʼ����ѧ�ռ�
		//$sql = "update edu_xingzheng_kaoqinmingxi set �����дʱ�� = '$�����дʱ��' where ��Ա='".$������Ա."' and ��������='$Datetime'";
		//$db->Execute($sql);
		$sql = "update `edu_xingzheng_kaoqinmingxi` set �ϰ�ʵ��ˢ��='�ϰ�ȱ��',�ϰ࿼��״̬  ='�ϰ�ȱ��' where �ϰ�ʵ��ˢ��='' and �ϰ࿼��״̬  ='' and ��Ա�û���='".$��Ա�û���."' and ����<'$����ʱ��'";
		$db->Execute($sql);
		$sql = "update `edu_xingzheng_kaoqinmingxi` set �°�ʵ��ˢ��='�°�ȱ��',�°࿼��״̬  ='�°�ȱ��' where �°�ʵ��ˢ��='' and �°࿼��״̬  ='' and ��Ա�û���='".$��Ա�û���."' and ����<'$����ʱ��'";
		$db->Execute($sql);
		if($SHOWTEXT) print "<BR><font color=red>*******:$sql <BR></font>";
}

����ٵ����˷���������();






?>