<?php
function CRMϵͳ���˸���Ȩ��()				{
	global $db,$_SESSION,$SYSTEM_PRINT_SQL;
	$LOGIN_USER_ID = $_SESSION['LOGIN_USER_ID'];
	$_GET['������'] = $LOGIN_USER_ID;
	//$SYSTEM_PRINT_SQL = 1;
}

function CRMϵͳ���˲���Ȩ��()				{
	global $db,$_SESSION,$SYSTEM_PRINT_SQL;
	$LOGIN_USER_ID = $_SESSION['LOGIN_USER_ID'];
	//$SYSTEM_PRINT_SQL = 1;
	$sql = "select MODULE from systemprivateinc where FILE='crm_customer_newai.php' and USER_ID like '%".$LOGIN_USER_ID.",%'";
	//print $sql;
	$rs = $db->CacheExecute(150,$sql);
	$rs_a = $rs->GetArray();
	$�������� = array();
	for($i=0;$i<sizeof($rs_a);$i++)			{
		$��������[] = $rs_a[$i]['MODULE'];
	}
	$��������TEXT = "'".join("','",$��������)."'";
	$sql = "	select USER_ID from user,department
				where
				user.DEPT_ID=department.DEPT_ID
				and department.DEPT_NAME in ($��������TEXT)
				";
	//print $sql;
	$rs = $db->CacheExecute(150,$sql);
	$rs_a = $rs->GetArray();
	$USER_ID_ARRAY = array();
	for($i=0;$i<sizeof($rs_a);$i++)			{
		$USER_ID_ARRAY[] = $rs_a[$i]['USER_ID'];
	}
	$USER_ID_TEXT = join(',',$USER_ID_ARRAY);
	$_GET['������'] = $USER_ID_TEXT;
}




?><?php
/*
	��Ȩ����:֣�ݵ���Ƽ�������޹�˾;
	��ϵ��ʽ:0371-69663266;
	��˾��ַ:����֣�ݾ��ü��������������־�����·ͨ�Ų�ҵ԰��¥����;
	��˾���:֣�ݵ���Ƽ�������޹�˾λ���й��в�����-֣��,������2007��1��,�����ڰѻ����Ƚ���Ϣ����������ͨ�ż���������ѹ�����ҵ��ʵ���ռ���������ҵ�ͻ��Ĺ�����ҵ���»�У�ȫ���ṩ��������֪ʶ��Ȩ�Ľ�����������������������������в�������ĸ�У���������������СѧУ��������ṩ�̡�Ŀǰ�Ѿ��ж�Ҹ�ְ����ְ��ԺУʹ��ͨ���в��з����Ŀ���������ͷ���;

	�������:����Ƽ�������������Լܹ�ƽ̨,�Լ��������֮����չ���κ��������Ʒ;
	����Э��:���ֻ�У԰��ƷΪ��ҵ���,�������ΪLICENSE��ʽ;����CRMϵͳ��SunshineCRMϵͳΪGPLV3Э�����,GPLV3Э����������뵽�ٶ�����;
	��������:�����ʹ�õ�ADODB��,PHPEXCEL��,SMTARY���ԭ��������,���´���������������;
	*/
?>