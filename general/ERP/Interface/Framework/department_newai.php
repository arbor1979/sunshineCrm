<?php
ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL);

// display warnings and errors
error_reporting(E_WARNING | E_ERROR);
//######################�������-Ȩ�޽��鲿��##########################
SESSION_START();
require_once("lib.inc.php");
$GLOBAL_SESSION=returnsession();
require_once("systemprivateinc.php");
validateMenuPriv("���Ź���");
//CheckSystemPrivate("ϵͳ��Ϣ����-��֯��������");
//######################�������-Ȩ�޽��鲿��##########################


	/*
	if($_GET['action']=="add_default_data")		{
		//print_R($_GET);print_R($_POST);//exit;
		global $db;
		$������� = (int)$_POST['�������'];$�̲ı�� = $_POST['�̲ı��'];
		$sql = "update edu_jiaocai set ���п��=���п��+$������� where �̲ı��='".$�̲ı��."'";
		$rs = $db->Execute($sql);//print $sql;exit;
		$_POST['������'] = returntablefield("edu_jiaocai","�̲ı��",$�̲ı��,"������");
		$_POST['������'] = returntablefield("edu_jiaocai","�̲ı��",$�̲ı��,"������");
		//print  "<META HTTP-EQUIV=REFRESH CONTENT='0;URL=?'>";
	}
	*/
	//�Զ��������ݿ���ʽ
	$Columns = $db->MetaColumns("department");
	if($Columns['DEPT_ID']->primary_key!=1)				{
		//$sql = "ALTER TABLE `department` ADD PRIMARY KEY ( `DEPT_ID` ) ";
		//$db->Execute($sql);
	};
	if($Columns['DEPT_ID']->auto_increment!=1)				{
		//$sql = "ALTER TABLE `department` CHANGE `DEPT_ID` `DEPT_ID` INT( 11 ) NOT NULL AUTO_INCREMENT ";
		//$db->Execute($sql);
	};

	if($_GET['action']=="delete_array")			
	{
		$selectid=$_GET['selectid'];
		$selectid=explode(",", $selectid);
		for($i=0;$i<sizeof($selectid);$i++)
		{
			
			if($selectid[$i]!="")
			{
				$user_id=returntablefield("user", "dept_id", $selectid[$i], "user_id");
				if($user_id!='')
				{
					print "<script language=javascript>alert('�˲����´����û�������ɾ���û�');window.history.back(-1);</script>";
	    			exit;
				}
				$dept_id=returntablefield("department", "dept_parent", $selectid[$i], "dept_id");
				if($dept_id!='')
				{
					print "<script language=javascript>alert('�˲����´����Ӳ��ţ�����ɾ���Ӳ���');window.history.back(-1);</script>";
	    			exit;
				}
			}
		}
	}

	//$SYSTEM_PRINT_SQL  = 1;
	//���ݱ�ģ���ļ�,��ӦModelĿ¼�����department_newai.ini�ļ�
	//�������Ҫ���ƴ�ģ��,����Ҫ�޸�$parse_filename������ֵ,Ȼ���Ӧ��ModelĿ¼ ���ļ���_newai.ini�ļ�
	$filetablename		=	'department';
	$parse_filename		=	'department';
	require_once('include.inc.php');
	?><?php
/*
	��Ȩ����:֣�ݵ���Ƽ�������޹�˾;
	��ϵ��ʽ:0371-69663266;
	��˾��ַ:����֣�ݾ��ü��������������־�����·ͨ�Ų�ҵ԰��¥����;
	��˾���:֣�ݵ���Ƽ�������޹�˾λ���й��в�����-֣��,������2007��1��,�����ڰѻ����Ƚ���Ϣ����������ͨ�ż���������ѹ�����ҵ��ʵ���ռ���������ҵ�ͻ��Ĺ�����ҵ���»�У�ȫ���ṩ��������֪ʶ��Ȩ�Ľ�����������������������������в�������ĸ�У���������������СѧУ��������ṩ�̡�Ŀǰ�����ж�Ҹ�ְ����ְ��ԺУʹ��ͨ���в��з����Ŀ���������ͷ���;

	�������:����Ƽ�������������Լܹ�ƽ̨,�Լ��������֮����չ���κ��������Ʒ;
	����Э��:���ֻ�У԰��ƷΪ��ҵ���,�������ΪLICENSE��ʽ;����CRMϵͳ��SunshineCRMϵͳΪGPLV3Э�����,GPLV3Э����������뵽�ٶ�����;
	��������:�����ʹ�õ�ADODB��,PHPEXCEL��,SMTARY���ԭ��������,���´���������������;
	*/
?>