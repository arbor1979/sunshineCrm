<?php
	require_once('lib.inc.php');

	$GLOBAL_SESSION=returnsession();
$SYSTEM_PRIV_STOP = 1;
	require_once("systemprivateinc.php");
	CheckSystemPrivate("������Դ-��������-������ϸ");
	$��ǰѧ�� = returntablefield("edu_xueqiexec","��ǰѧ��",'1',"ѧ������");
	if($_GET['ѧ��']=="") $_GET['ѧ��'] = $��ǰѧ��;



	if($_GET['action']=="add_default_data")			{
		$_POST['��Ա�û���'] =  $_POST['��Ա_ID'];
		$DEPT_ID =  returntablefield("user","USER_ID",$_POST['��Ա_ID'],"DEPT_ID");
		$_POST['����'] =  returntablefield("department","DEPT_ID",$DEPT_ID,"DEPT_NAME");
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
			$���״̬ = returntablefield("edu_xingzheng_kaoqinbudeng","���",$$Element,"���״̬");
			if($���״̬!=1){
			$sql = "update edu_xingzheng_kaoqinbudeng set ���״̬='1',�����='$�����',���ʱ��='$���ʱ��' where ���='$Element'";
			$rs = $db->Execute($sql);
			
			$sql = "select * from edu_xingzheng_kaoqinbudeng where ���='$Element' and ���״̬ =1";
			$rs = $db->Execute($sql);
			$rs_a=$rs->GetArray();
			$ʱ�� = $rs_a[0]['ʱ��'];
			$��� = $rs_a[0]['���'];
			$������Ŀ = $rs_a[0]['������Ŀ'];
			$��Ա�û��� = $rs_a[0]['��Ա�û���'];
			//print_R($rs_a);exit;           ���  ѧ��  ����  ��Ա  ����  �ܴ�  ����  ���  �ϰ�ʵ��ˢ��   

			if($������Ŀ == '�ϰ࿼�ڲ���')	
			{
				$query = "update edu_xingzheng_kaoqinmingxi set �ϰ࿼��״̬='���ڲ���' where ����='$ʱ��' and ���='$���' and ��Ա�û���='$��Ա�û���'  ";
			}
			else
			{
			$query = "update edu_xingzheng_kaoqinmingxi set �°࿼��״̬='���ڲ���' where ����='$ʱ��' and ���='$���' and ��Ա�û���='$��Ա�û���'  ";
			}
			

			$db->Execute($query);
			}
		}
	}
	$pageid = $_GET['pageid'];
	page_css("���ڲ�������");
	print_nouploadfile("������ݲ����Ѿ��ɹ�!");
	echo "<META HTTP-EQUIV=REFRESH CONTENT='0;URL=?pageid=$pageid'>\n";
	exit;
}



	$filetablename='edu_xingzheng_kaoqinbudeng';
	require_once('include.inc.php');
	//������˵��ע��
	require_once("../Help/module_xingzhengworkflow.php");
	?>