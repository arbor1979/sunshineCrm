<?php



function SQL����������_Ӧ������Ϣ����($sql,$������¼���)				{
	global $db,$MetaTables;
	//�ж��Զ�����Ƿ����,���������ֱ�ӷ���

	//�ж��Ƿ�������ȫ����,�Ƿ����Ӳ�ѯ,�Ƿ���left
	//�����,���ʾΪ��дSQL����,����ϵͳ����,��ֱ�ӷ���,�����й���
	$sql		= trim($sql);
	//ת��Сд
	$sqllower	= strtolower($sqllower);
	//�����ո�
	$sql = eregi_replace("  "," ",$sql);
	$sql = eregi_replace("  "," ",$sql);
	if(substr($sqllower,0,strlen("insert into"))=="insert into")		{
		$sqlArray = explode('insert into',$sql);
		$sqlArray = explode('values',$sqlArray[1]);
		$sqlArray = explode('(',$sqlArray[0]);
		$Tablename = ($sqlArray[0]);
		��ʼ������Ϣ����('INSERT',$Tablename,$�����ֶ�,$������¼���);
	}
	if(substr($sqllower,0,strlen("update"))=="update")			{
		$sqlArray = explode('update',$sql);
		$sqlArray = explode('set',$sqlArray[1]);
		$Tablename = TRIM($sqlArray[0]);
	}
	if(substr($sqllower,0,strlen("delete from"))=="delete from")		{
		$sqlArray = explode('delete from',$sql);
		$sqlArray = explode(' ',$sqlArray[1]);
		$Tablename = TRIM($sqlArray[0]);
		��ʼ������Ϣ����('DELETE',$Tablename,$�����ֶ�,$������¼���);
	}


}



function ��ʼ������Ϣ����($����,$���ݶ���,$�����ֶ�,$������¼���)				{
	global $db;

	if($����=="UPDATE")					{
		$sql	= "select * from crm_clendar_rule where ����='$����' and ���ݶ���='$���ݶ���' and �����ֶ�='$�����ֶ�'";
	}
	elseif($����=="INSERT")					{
		$sql	= "select * from crm_clendar_rule where ����='$����' and ���ݶ���='$���ݶ���'";
	}
	elseif($����=="DELETE")					{
		$sql	= "select * from crm_clendar_rule where ����='$����' and ���ݶ���='$���ݶ���'";
	}
	else	{
		return '';
	}

	//�õ���ṹ��Ϣ
	$MetaColumnNames	= $db->MetaColumnNames($����);
	$MetaColumnNames	= array_keys($MetaColumnNames);
	$����				= $MetaColumnNames[0];

	$rs		= $db->CacheExecute(360,$sql);
	$rs_a	= $rs->GetArray();
	for($i=0;$i<sizeof($rs_a);$i++)				{
		$�����ֶ�	= $rs_a[0]['�����ֶ�'];
		$��������	= $rs_a[0]['��������'];
		$���Ѷ���	= $rs_a[0]['���Ѷ���'];
		$������Ա	= $rs_a[0]['������Ա'];
		$��������ģ�� = $rs_a[0]['��������ģ��'];
		$�Ƿ�����	= $rs_a[0]['�Ƿ�����'];
		$�ж�����	= $rs_a[0]['�ж�����'];
		$�ж�ֵ		= $rs_a[0]['�ж�ֵ'];
		$��ת·��	= $rs_a[0]['��ת·��'];

		//���Ŀ��������Ա
		$sql	= "select * from $���ݶ��� where $����='$������¼���'";
		$rs2	= $db->CacheExecute(15,$sql);
		$rs2_a	= $rs2->GetArray();
		//�ж����Ѷ����Ƿ��Ǳ����ֶ�
		if(in_array($���Ѷ���,$MetaColumnNames))		{
			//�ж����Ѷ����Ƿ�������û�����
			$USER_NAME = returntablefield("user","USER_ID",$rs2_a[0][$���Ѷ���],"USER_NAME");;
			if($USER_NAME!="")				{
				$���Ŀ��������Ա = $rs2_a[0][$���Ѷ���];
			}
		}

		//��ģ������滻����
		for($ix=0;$ix<sizeof($MetaColumnNames);$ix++)				{
			$FIELD_NAME		= $MetaColumnNames[$ix];
			$��������ģ��	= ereg_replace("{$FIELD_NAME}",$rs_a[0][$FIELD_NAME],$��������ģ��);
		}


		if($������Ա!="")					{
			$���Ŀ��������Ա = $������Ա.",".$���Ŀ��������Ա;
		}

		������Ϣ_TDOASMS('admin',$���Ŀ��������Ա,$SMS_TYPE=0,$��������ģ��,$��ת·��);
	}
}

//������Ϣ_TDOASMS('admin','admin,admin,��Ա',0,'���,��������','EDU/Interface/URLID=?');

function ������Ϣ_TDOASMS($FROM_ID,$TO_ID,$SMS_TYPE,$CONTENT,$REMIND_URL)			{
	global $db;
	$SEND_TIME = date("Y-m-d H:i:s");
	$sql = "insert into TD_OA.sms_body values('','$FROM_ID','$SMS_TYPE','$CONTENT','$SEND_TIME','$REMIND_URL');";
	print $sql."<BR>";
	$rs  = $db->Execute($sql);
	$BODY_ID = $db->Insert_ID();
	//SMS_ID  TO_ID  REMIND_FLAG  DELETE_FLAG  BODY_ID  REMIND_TIME
	$TO_ID_ARRAY = explode(',',$TO_ID);
	for($i=0;$i<sizeof($TO_ID_ARRAY);$i++)				{
		$TD_ID_NAME = $TO_ID_ARRAY[$i];
		if($TD_ID_NAME!="")				{
			$REMIND_TIME = time();
			$sql = "insert into TD_OA.sms values('','$TD_ID_NAME','0','0','$BODY_ID','$REMIND_TIME')";
			print $sql."<BR>";
			$db->Execute($sql);
		}
	}

}




?>