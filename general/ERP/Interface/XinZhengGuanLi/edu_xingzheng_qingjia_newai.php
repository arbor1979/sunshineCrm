<?php
	require_once('lib.inc.php');

	$GLOBAL_SESSION=returnsession();
$SYSTEM_PRIV_STOP = 1;
	require_once("systemprivateinc.php");
	CheckSystemPrivate("������Դ-��������-������ϸ");
	$��ǰѧ�� = returntablefield("edu_xueqiexec","��ǰѧ��",'1',"ѧ������");
	if($_GET['ѧ��']=="") $_GET['ѧ��'] = $��ǰѧ��;

	require_once('lib.xingzheng.inc.php');

	if($_GET['action']=="add_default_data")			{
		$_POST['��Ա�û���'] =  $_POST['��Ա_ID'];
		$DEPT_ID =  returntablefield("user","USER_ID",$_POST['��Ա_ID'],"DEPT_ID");
		$_POST['����'] =  returntablefield("department","DEPT_ID",$DEPT_ID,"DEPT_NAME");
		$ʱ�� = $_POST['ʱ��'];
		$ʱ��Array = explode('-',$ʱ��);
		$_POST['����'] = date("w",mktime(1,1,1,$ʱ��Array[1],$ʱ��Array[2],$ʱ��Array[0]));
		$_POST['ʱ��'] = date("Y-m-d",mktime(1,1,1,$ʱ��Array[1],$ʱ��Array[2],$ʱ��Array[0]));
		$_POST['�ܴ�'] =  returnCurWeekIndex($_POST['ʱ��']);

		//print_R($_POST);exit;
	}


//����ͨ����˲���
if($_GET['action']=="operation_piliangtongguo"&&$_GET['selectid']!="")			{
	//print_R($_GET);exit;
	//print_R($_SESSION);
	$����� = $_SESSION['LOGIN_USER_NAME'];
	$���ʱ��=date('Y-m-d H:i:s');

	$Array = explode(',',$_GET['selectid']);
	//PRINT_r($Array);EXIT;
	for($i=0;$i<sizeof($Array);$i++)	{
		$Element = $Array[$i];
		if($Element!="")		{
			$���״̬ = returntablefield("edu_xingzheng_qingjia","���",$$Element,"���״̬");
			if($���״̬!=1){
			$sql = "update edu_xingzheng_qingjia set ���״̬='1',�����='$�����',���ʱ��='$���ʱ��' where ���='$Element' and ���״̬='0'";
			$rs = $db->Execute($sql);
			$sql."<BR>";
			}
		}
	}
	$pageid = $_GET['pageid'];
	page_css("�໥��������");
	print_nouploadfile("������ݲ����Ѿ��ɹ�!");
	echo "<META HTTP-EQUIV=REFRESH CONTENT='0;URL=?pageid=$pageid'>\n";
	exit;
}



	$filetablename='edu_xingzheng_qingjia';
	require_once('include.inc.php');
	//������˵��ע��
	require_once("../Help/module_xingzhengworkflow.php");
	?>