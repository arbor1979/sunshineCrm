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
	$��������TEXT = "'".join("'",$��������)."'";
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


//��Ϣ��������();

function ��Ϣ��������()				{
	global $db,$_SESSION,$SYSTEM_PRINT_SQL;
	$LOGIN_USER_ID = $_SESSION['LOGIN_USER_ID'];
	$sql = "select * from crm_clendar_rule where �Ƿ�����='��'";
	$rs = $db->Execute($sql);
	$rs_a = $rs->GetArray();
	//���ݶ���  �����ֶ�  ��������  ���Ѷ���  ��������ģ��
	for($i=0;$i<sizeof($rs_a);$i++)			{
		$������ = $rs_a[$i]['���'];
		$���ݶ��� = $rs_a[$i]['���ݶ���'];
		$�����ֶ� = $rs_a[$i]['�����ֶ�'];
		$�������� = $rs_a[$i]['��������'];
		$���Ѷ��� = $rs_a[$i]['���Ѷ���'];
		$��������ģ�� = $rs_a[$i]['��������ģ��'];
		��Ϣ��������֮������Ϣ($���ݶ���,$�����ֶ�,$��������,$���Ѷ���,$��������ģ��,$������);
	}
	//$SYSTEM_PRINT_SQL = 1;
}


function ��Ϣ��������֮������Ϣ($���ݶ���,$�����ֶ�,$��������,$���Ѷ���,$��������ģ��,$������)				{
	global $db,$_SESSION,$SYSTEM_PRINT_SQL;
	$LOGIN_USER_ID = $_SESSION['LOGIN_USER_ID'];
	$��������ģ�� = ereg_replace('{','{$',$��������ģ��);
	$sql = "select * from $���ݶ��� where ��� not in (
				select ��¼��� from crm_clendar
				where ���ݶ���='$���ݶ���'
				and �����ֶ�='$�����ֶ�'
				and �����ֶ�='$�����ֶ�'
				and ��������='$��������'
				and ���Ѷ���='$���Ѷ���'
				)
				and $�����ֶ�!=''";
	//print $sql."<BR>";
	$rs = $db->Execute($sql);
	$rs_a = $rs->GetArray();
	//print $��������ģ��."<BR>";
	for($i=0;$i<sizeof($rs_a);$i++)							{
		$Element = $rs_a[$i];
		//print_R($Element);
		$ElementKeys = array_keys($Element);
		for($ix=0;$ix<sizeof($ElementKeys);$ix++)			{
			$ElementName = $ElementKeys[$ix];
			$$ElementName = $Element[$ElementName];
			$��������ģ�� = ereg_replace('\$'.$ElementName,$Element[$ElementName],$��������ģ��);
			//print $ElementName.$$ElementName.$��������ģ��."<BR>";
		}

		$��������ģ�� = ereg_replace('{','',$��������ģ��);
		$��������ģ�� = ereg_replace('}','',$��������ģ��);

		$�û���		= $$���Ѷ���;
		$�û���Ϣ	= returntablefield("user","USER_ID",$�û���,"USER_NAME,DEPT_ID");;
		$�û�����	= $�û���Ϣ['USER_NAME'];
		$DEPT_NAME	= returntablefield("department","DEPT_ID",$�û���Ϣ['DEPT_ID'],"DEPT_NAME");;

		$�����ֶ�_ARRAY = explode('-',$$�����ֶ�);
		//print_R($�����ֶ�_ARRAY);
		$����ʱ��		= date("Y-m-d",mktime(1,1,1,$�����ֶ�_ARRAY[1],$�����ֶ�_ARRAY[2]-$��������,$�����ֶ�_ARRAY[0]));
		$INSERTINTO['�û���'] = $�û���;
		$INSERTINTO['�û�����'] = $�û�����;
		$INSERTINTO['����'] = $DEPT_NAME;
		$INSERTINTO['����'] = $������;
		$INSERTINTO['����'] = "ʱ������";
		$INSERTINTO['����ʱ��'] = $����ʱ��;
		$INSERTINTO['��������'] = $��������ģ��;
		$INSERTINTO['�������'] = '';
		$INSERTINTO['��ע'] = '';
		$INSERTINTO['������'] = $�û���;
		$INSERTINTO['����ʱ��'] = date("Y-m-d H:i:s");
		$INSERTINTO['���ݶ���'] = $���ݶ���;
		$INSERTINTO['�����ֶ�'] = $�����ֶ�;
		$INSERTINTO['��������'] = $��������;
		$INSERTINTO['���Ѷ���'] = $���Ѷ���;
		$INSERTINTO['��¼���'] = $���;

		$INSERTINTOKEYS		= array_keys($INSERTINTO);
		$INSERTINTOVALUES	= array_values($INSERTINTO);
		$INSERTINTOKEYSTEXT = join(',',$INSERTINTOKEYS);
		$INSERTINTOVALUESTEXT = "'".join("','",$INSERTINTOVALUES)."'";
		$sql = "insert into crm_clendar ($INSERTINTOKEYSTEXT) values($INSERTINTOVALUESTEXT) ";
		$db->Execute($sql);
		//print $sql."<BR>";

		//print $��������ģ��."<BR>";
		//exit;
		//$SYSTEM_PRINT_SQL = 1;
	}
}


?>