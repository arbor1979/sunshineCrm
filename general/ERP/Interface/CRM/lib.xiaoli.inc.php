<?php
ini_set('date.timezone','Asia/Shanghai');
ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL);

// display warnings and errors
error_reporting(E_WARNING | E_ERROR);


//��ʼ����ʦ���ڱ�,����0Ϊ7  2010-9-30�շŵ���ʱ����������������ִ��
//$sql = "update edu_teacherkaoqinmingxi set ����='7' where ����='0'";
//$db->Execute($sql);
//�Զ�����û�б�ҵ�İ༶  2010-9-30�շŵ���ʱ����������������ִ��
//$sql = "update edu_banji set IsGrad='0' where ��ҵʱ��>='".date('Y-m-d')."'";
//$db->Execute($sql);

function �����ѧ������Ϣ($ѧ��,$��ʦ,$��ʦ�û���,$��������,$�Ͽ�ʱ��,$����,$�γ�,$�༶,$�ڴ�)					{
	global $db;
	global $KaoqinTimeBegin1,$KaoqinTimeBegin2,$KaoqinTimeEnd1,$KaoqinTimeEnd2,$KuangGongShiJian;

		$Ӧ����дʱ�� = $�Ͽ�ʱ��;
		$�Ͽ�ʱ��Array = explode('-',$�Ͽ�ʱ��);
		$�����дʱ�� = date("Y-m-d",mktime(1,1,1,$�Ͽ�ʱ��Array[1],$�Ͽ�ʱ��Array[2]+5,$�Ͽ�ʱ��Array[0]));
		$���� = date("w",mktime(1,1,1,$�Ͽ�ʱ��Array[1],$�Ͽ�ʱ��Array[2],$�Ͽ�ʱ��Array[0]));
		$�ڴ�Array = explode('-',$�ڴ�);
		$�������� = returnJieCiName($�ڴ�Array[0]);
		$��Чʱ�� = returnJieCiTime($��������);
		$��Чʱ��Array = explode('-',$��Чʱ��);
		$��Чʱ��0Array = explode(':',$��Чʱ��Array[0]);
		$��Чʱ��1Array = explode(':',$��Чʱ��Array[1]);
		global $SYSTEM_MERGE_CLASSTABLE;
		if($�ڴ�Array[1]!=""&&$SYSTEM_MERGE_CLASSTABLE = "1")		{
			$�������� = returnJieCiName($�ڴ�Array[1]);
			$��Чʱ�� = returnJieCiTime($��������);
			$��Чʱ��Array = explode('-',$��Чʱ��);
			$��Чʱ��1Array = explode(':',$��Чʱ��Array[1]);
		}

		$�Ͽ�ˢ��BGN = date("H:i",@mktime($��Чʱ��0Array[0],$��Чʱ��0Array[1]-$KaoqinTimeBegin1,30,12,12,2008));
		$�Ͽ�ˢ��END = date("H:i",@mktime($��Чʱ��0Array[0],$��Чʱ��0Array[1]+$KaoqinTimeBegin2,30,12,12,2008));
		$�¿�ˢ��BGN = date("H:i",@mktime($��Чʱ��1Array[0],$��Чʱ��1Array[1]-$KaoqinTimeEnd1,30,12,12,2008));
		$�¿�ˢ��END = date("H:i",@mktime($��Чʱ��1Array[0],$��Чʱ��1Array[1]+$KaoqinTimeEnd2,30,12,12,2008));

		$Element['��ʦ����'] = $��ʦ;
		$Element['��ʦ�û���'] = $��ʦ�û���;
		$Element['��������'] = $��������;
		$Element['�ܴ�'] = returnCurWeekIndex($��������);
		$Element['����'] = $����;
		$Element['�γ�'] = $�γ�;
		$Element['�༶'] = $�༶;
		$Element['����'] = $����;
		$Element['�ڴ�'] = $�ڴ�;
		$Element['�ܴ�'] = returnCurWeekIndex($�Ͽ�ʱ��);
		$Element['ѧ��'] = $ѧ��;
		$Element['Ӧ����дʱ��'] = $Ӧ����дʱ��;
		$Element['�����дʱ��'] = date("Y-m-d",mktime(1,1,1,$�Ͽ�ʱ��Array[1],$�Ͽ�ʱ��Array[2]+7,$�Ͽ�ʱ��Array[0]));
		$Element['�Ͽ�ʵ��ˢ��'] = '';
		$Element['�Ͽο���״̬'] = '';
		$Element['�¿�ʵ��ˢ��'] = '';
		$Element['�¿ο���״̬'] = '';
		$Element['�Ͽ�ˢ��BGN'] = $�Ͽ�ˢ��BGN;
		$Element['�Ͽ�ˢ��END'] = $�Ͽ�ˢ��END;
		$Element['�¿�ˢ��BGN'] = $�¿�ˢ��BGN;
		$Element['�¿�ˢ��END'] = $�¿�ˢ��END;
		$ElementValue = array_values($Element);
		$sqlValueText = "'".join("','",$ElementValue)."'";
		$ElementName = array_keys($Element);
		$sqlNameText = "`".join("`,`",$ElementName)."`";
		$sql = "insert into edu_teacherkaoqinmingxi($sqlNameText) values($sqlValueText)";
		//print $sql."<BR>";
		$db->Execute($sql);
		//print $sql;exit;
}


function useridtoname($��Ա����)			{
	global $db;
	$USER_NAME_TEXT = '';
	$��Ա����Array = explode(',',$��Ա����);
	for($i=0;$i<sizeof($��Ա����Array);$i++)		{
		if($��Ա����Array[$i]!="")	{
			$USER_NAME	= returntablefield("user","USER_ID",$��Ա����Array[$i],"USER_NAME");
			if($USER_NAME=="") $USER_NAME =	$��Ա����Array[$i];
			$USER_NAME_TEXT	.= $USER_NAME.",";
		}


	}
	return $USER_NAME_TEXT;
}

function usernametoid($��Ա����)			{
	global $db;
	$USER_NAME_TEXT = '';
	$��Ա����Array = explode(',',$��Ա����);
	for($i=0;$i<sizeof($��Ա����Array);$i++)		{
		if($��Ա����Array[$i]!="")	{
			$USER_NAME	= returntablefield("user","USER_NAME",$��Ա����Array[$i],"USER_ID");
			if($USER_NAME=="") $USER_NAME =	$��Ա����Array[$i];
			$USER_NAME_TEXT	.= $USER_NAME.",";
		}

	}
	return $USER_NAME_TEXT;
}


//�������ӽ�ʦ�û��������Ŀ��ֶ���Ϣ
function �������ӽ�ʦ�û��������Ŀ��ֶ���Ϣ()		{

	/*
	�������ӽ�ʦ�û��������Ŀ��ֶ���Ϣ_�Ӻ���('edu_schedule','��ʦ');
	�������ӽ�ʦ�û��������Ŀ��ֶ���Ϣ_�Ӻ���('edu_schedule2','��ʦ');
	�������ӽ�ʦ�û��������Ŀ��ֶ���Ϣ_�Ӻ���('edu_teacherkaoqinmingxi','��ʦ����');
	�������ӽ�ʦ�û��������Ŀ��ֶ���Ϣ_�Ӻ���('edu_teacherkaoqinbudeng','��ʦ');
	�������ӽ�ʦ�û��������Ŀ��ֶ���Ϣ_�Ӻ���('edu_schedulefenduanjiaoxue','��ʦ');
	�������ӽ�ʦ�û��������Ŀ��ֶ���Ϣ_�Ӻ���('edu_scheduletiaoke','��ʦ');
	�������ӽ�ʦ�û��������Ŀ��ֶ���Ϣ_�Ӻ���('edu_scheduletingkefuke','��ʦ');
	�������ӽ�ʦ�û��������Ŀ��ֶ���Ϣ_�Ӻ���('edu_schedulechange','ԭ��ʦ','ԭ��ʦ�û���');
	�������ӽ�ʦ�û��������Ŀ��ֶ���Ϣ_�Ӻ���('edu_schedulechange','�½�ʦ','�½�ʦ�û���');
	�������ӽ�ʦ�û��������Ŀ��ֶ���Ϣ_�Ӻ���('edu_scheduledaike','ԭ��ʦ','ԭ��ʦ�û���');
	�������ӽ�ʦ�û��������Ŀ��ֶ���Ϣ_�Ӻ���('edu_scheduledaike','�½�ʦ','�½�ʦ�û���');
	�������ӽ�ʦ�û��������Ŀ��ֶ���Ϣ_�Ӻ���('edu_scheduletiaokexianghu','ԭ��ʦ','ԭ��ʦ�û���');
	�������ӽ�ʦ�û��������Ŀ��ֶ���Ϣ_�Ӻ���('edu_scheduletiaokexianghu','�½�ʦ','�½�ʦ�û���');
	�������ӽ�ʦ�û��������Ŀ��ֶ���Ϣ_�Ӻ���('edu_jiaoxuerijibudeng','��ʦ');
	�������ӽ�ʦ�û��������Ŀ��ֶ���Ϣ_�Ӻ���('edu_planexec','���ν�ʦ');
	//�������ӽ�ʦ�û��������Ŀ��ֶ���Ϣ_�Ӻ���('edu_planexec_middleschool','���ν�ʦ');
	�������ӽ�ʦ�û��������Ŀ��ֶ���Ϣ_�Ӻ���('edu_kechoujisuan','��ʦ����');
	�������ӽ�ʦ�û��������Ŀ��ֶ���Ϣ_�Ӻ���('edu_kechouqita','��ʦ');
	�������ӽ�ʦ�û��������Ŀ��ֶ���Ϣ_�Ӻ���('edu_kechoujiaofu','��ʦ');
	�������ӽ�ʦ�û��������Ŀ��ֶ���Ϣ_�Ӻ���('edu_kechouqita','��ʦ');
	�������ӽ�ʦ�û��������Ŀ��ֶ���Ϣ_�Ӻ���('edu_pingjiamingxi','��ʦ');
	*/

}
function �������ӽ�ʦ�û��������Ŀ��ֶ���Ϣ_�Ӻ���($tablename,$��ʦ='��ʦ',$��ʦ�û���='��ʦ�û���')		{
	global $db,$CurXueQi;

	$sql = "select COUNT(*) AS NUM from $tablename where $��ʦ�û���=''";
	$rs = $db->Execute($sql);
	$rs_a = $rs->GetArray();
	$NUM = $rs_a[0]['NUM'];;
	if($NUM>0)		{
		$sql = "select distinct $��ʦ from $tablename where $��ʦ�û���=''";
		$rs = $db->Execute($sql);
		$rs_a = $rs->GetArray();
		for($i=0;$i<sizeof($rs_a);$i++)				{
			$��ʦ����X = $rs_a[$i][$��ʦ];
			$��ʦ�û���X = returntablefield('user',"USER_NAME",$��ʦ����X,"USER_ID");
			$sql = "update $tablename set $��ʦ�û���='$��ʦ�û���X' where $��ʦ='$��ʦ����X'";
			$db->Execute($sql);
			//print $sql."<BR>";
		}//exit;
		$sql = "delete from $tablename where $��ʦ�û���=''";
		$db->Execute($sql);
		//print $sql."<BR>";
	}
}


//������ʦͣ�θ��β�����Ϣ
function ������ʦͣ�θ��β�����Ϣ()  {
	global $db,$CurXueQi;
	global $KaoqinTimeBegin1,$KaoqinTimeBegin2,$KaoqinTimeEnd1,$KaoqinTimeEnd2,$KuangGongShiJian;

	// and ��ʦ='��Ծ��'
	$sql = "select * from edu_scheduletingkefuke where ͣ�����״̬='1' and ѧ��='$CurXueQi'";
	$rs = $db->Execute($sql);
	$rsX_a = $rs->GetArray();
	//print_R($rs_a);
	for($XX=0;$XX<sizeof($rsX_a);$XX++)				{
		//print sizeof($rsX_a);
		$���		= $rsX_a[$XX]['���'];
		$�༶		= $rsX_a[$XX]['�༶'];
		$��ʦ		= $rsX_a[$XX]['��ʦ'];
		$��ʦ�û���	= $rsX_a[$XX]['��ʦ�û���'];
		$����		= $rsX_a[$XX]['����'];
		$ԭ�Ͽ�ʱ�� = $rsX_a[$XX]['ԭ�Ͽ�ʱ��'];
		$ԭ�ڴ�		= $rsX_a[$XX]['ԭ�ڴ�'];
		$���Ͽ�ʱ�� = $rsX_a[$XX]['���Ͽ�ʱ��'];
		$�½ڴ�		= $rsX_a[$XX]['�½ڴ�'];
		$�������״̬	= $rsX_a[$XX]['�������״̬'];
		$�γ�		= $rsX_a[$XX]['�γ�'];
		//����״̬���,��Ҫ�Ƚ��и�0000-00-00����
		if($���!=""&&$�������״̬!='1')			{
			//ɾ���Ĳ������ټ�,����˲�������Ϊ֮ǰ��ʼ��ʱ���Ѿ�ͣ�εļ�¼���¼��뵽�����б���ȥ,�������¹��˳�ȥ
			//ͣ�θ��εĲ�����ͨ�������ڸ�Ϊ0000-00-00����ʽ��ʵ�ֵ�,������ɾ������������,��һ����͵Ĳ���,�����´������ݻ��������
			$sql = "update edu_teacherkaoqinmingxi
					set Ӧ����дʱ��='0000-00-00',��������='0000-00-00',�����дʱ��='0000-00-00'
					where �༶='$�༶' and ��ʦ����='$��ʦ' and ��ʦ�û���='$��ʦ�û���' and ��������='$ԭ�Ͽ�ʱ��' and �ڴ�='$ԭ�ڴ�' and ѧ��='$CurXueQi'";
			$db->Execute($sql);
			global $SHOWTEXT; if($SHOWTEXT)print "<BR>������ʦͣ�θ��β�����Ϣ:".$sql."<BR>";
		}
		if($���!=""&&$�������״̬=='1')			{
			//ͬ��ˢ��ʱ��
			$�½ڴ�Array = explode('-',$�½ڴ�);
			global $SYSTEM_MERGE_CLASSTABLE;
			if($�½ڴ�Array[1]!=""&&$SYSTEM_MERGE_CLASSTABLE = "1")					{
				$returnJieCiName1 = returnJieCiName($�½ڴ�Array[0]);
				$returnJieCiName2 = returnJieCiName($�½ڴ�Array[1]);
				$sql = "select ʱ��� from edu_timesetting where ��������='$returnJieCiName1'";
				$rs = $db->Execute($sql);;
				$ʱ���1Array = explode('-',$rs->fields['ʱ���']);
				$sql = "select ʱ��� from edu_timesetting where ��������='$returnJieCiName2'";
				$rs = $db->Execute($sql);;
				$ʱ���2Array = explode('-',$rs->fields['ʱ���']);
				$��Чʱ��0Array = explode(':',$ʱ���1Array[0]);
				$��Чʱ��1Array = explode(':',$ʱ���2Array[1]);

				$�Ͽ�ˢ��BGN = date("H:i",@mktime($��Чʱ��0Array[0],$��Чʱ��0Array[1]-$KaoqinTimeBegin1,30,12,12,2008));
				$�Ͽ�ˢ��END = date("H:i",@mktime($��Чʱ��0Array[0],$��Чʱ��0Array[1]+$KaoqinTimeBegin2,30,12,12,2008));
				$�¿�ˢ��BGN = date("H:i",@mktime($��Чʱ��1Array[0],$��Чʱ��1Array[1]-$KaoqinTimeEnd1,30,12,12,2008));
				$�¿�ˢ��END = date("H:i",@mktime($��Чʱ��1Array[0],$��Чʱ��1Array[1]+$KaoqinTimeEnd2,30,12,12,2008));
				$TempSQL = ",�Ͽ�ˢ��BGN='$�Ͽ�ˢ��BGN',
							�Ͽ�ˢ��END='$�Ͽ�ˢ��END',
							�¿�ˢ��BGN='$�¿�ˢ��BGN',
							�¿�ˢ��END='$�¿�ˢ��END'";
			}
			else	{
				$returnJieCiName1 = returnJieCiName($�½ڴ�Array[0]);
				$sql = "select ʱ��� from edu_timesetting where ��������='$returnJieCiName1'";
				$rs = $db->Execute($sql);;
				$ʱ���1Array = explode('-',$rs->fields['ʱ���']);
				$��Чʱ��0Array = explode(':',$ʱ���1Array[0]);
				$��Чʱ��1Array = explode(':',$ʱ���1Array[1]);

				$�Ͽ�ˢ��BGN = date("H:i",@mktime($��Чʱ��0Array[0],$��Чʱ��0Array[1]-$KaoqinTimeBegin1,30,12,12,2008));
				$�Ͽ�ˢ��END = date("H:i",@mktime($��Чʱ��0Array[0],$��Чʱ��0Array[1]+$KaoqinTimeBegin2,30,12,12,2008));
				$�¿�ˢ��BGN = date("H:i",@mktime($��Чʱ��1Array[0],$��Чʱ��1Array[1]-$KaoqinTimeEnd1,30,12,12,2008));
				$�¿�ˢ��END = date("H:i",@mktime($��Чʱ��1Array[0],$��Чʱ��1Array[1]+$KaoqinTimeEnd2,30,12,12,2008));
				$TempSQL = ",�Ͽ�ˢ��BGN='$�Ͽ�ˢ��BGN',
							�Ͽ�ˢ��END='$�Ͽ�ˢ��END',
							�¿�ˢ��BGN='$�¿�ˢ��BGN',
							�¿�ˢ��END='$�¿�ˢ��END'";
			}
			//ͬ��������Ϣ����ʦ�������ݱ�
			$�ܴ� = returnCurWeekIndex($���Ͽ�ʱ��);
			$Ӧ����дʱ�� = $���Ͽ�ʱ��;
			$���Ͽ�ʱ��Array = explode('-',$���Ͽ�ʱ��);
			$�����дʱ�� = date("Y-m-d",mktime(1,1,1,$���Ͽ�ʱ��Array[1],$���Ͽ�ʱ��Array[2]+5,$���Ͽ�ʱ��Array[0]));
			$���� = date("w",mktime(1,1,1,$���Ͽ�ʱ��Array[1],$���Ͽ�ʱ��Array[2],$���Ͽ�ʱ��Array[0]));
			$sql = "update edu_teacherkaoqinmingxi set �ܴ�='$�ܴ�',����='$����',Ӧ����дʱ��='$���Ͽ�ʱ��',��������='$���Ͽ�ʱ��',�ڴ�='$�½ڴ�',�����дʱ��='$�����дʱ��' $TempSQL where �༶='$�༶' and �γ�='$�γ�' and ��ʦ����='$��ʦ' and ��ʦ�û���='$��ʦ�û���' and �ڴ�='$ԭ�ڴ�' and ��������='0000-00-00'";
			//ɾ���Ĳ������ټ�,����˲�������Ϊ֮ǰ��ʼ��ʱ���Ѿ�ͣ�εļ�¼���¼��뵽�����б���ȥ,�������¹��˳�ȥ
			//ͣ�θ��εĲ�����ͨ�������ڸ�Ϊ0000-00-00����ʽ��ʵ�ֵ�,������ɾ������������,��һ����͵Ĳ���,�����´������ݻ��������
			$db->Execute($sql);
			global $SHOWTEXT; if($SHOWTEXT)print "<BR>������ʦͣ�θ��β�����Ϣ:".$sql."<BR>";

				//2010-5-5 9:24 �������,���������,����в������
				//���ڼ�¼,���½����µļ�¼�Ƿ����
				$sql = "select * from edu_teacherkaoqinmingxi where ѧ��='$CurXueQi' and ��ʦ����='$��ʦ' and ��ʦ�û���='$��ʦ�û���' and �γ�='$�γ�' and ��������='$���Ͽ�ʱ��' and �ڴ�='$�½ڴ�'";
				$rs = $db->Execute($sql);
				$rs_a = $rs->GetArray();
				$���X = $rs_a[0]['���'];
				global $SHOWTEXT; if($SHOWTEXT)print $sql."<BR>";
				if($���X=="")		{
					$Element['��ʦ����'] = $��ʦ;
					$Element['��ʦ�û���'] = $��ʦ�û���;
					$Element['��������'] = $���Ͽ�ʱ��;
					$Element['����'] = $����;
					$Element['�γ�'] = $�γ�;
					$Element['�༶'] = $�༶;
					$Element['����'] = $����;
					$Element['�ڴ�'] = $�½ڴ�;
					$Element['�ܴ�'] = returnCurWeekIndex($���Ͽ�ʱ��);
					$Element['ѧ��'] = $CurXueQi;
					$Element['Ӧ����дʱ��'] = $���Ͽ�ʱ��;
					$Element['�����дʱ��'] = date("Y-m-d",mktime(1,1,1,$���Ͽ�ʱ��Array[1],$���Ͽ�ʱ��Array[2]+7,$���Ͽ�ʱ��Array[0]));
					$Element['�Ͽ�ʵ��ˢ��'] = '';
					$Element['�Ͽο���״̬'] = '';
					$Element['�¿�ʵ��ˢ��'] = '';
					$Element['�¿ο���״̬'] = '';
					$Element['�Ͽ�ˢ��BGN'] = $�Ͽ�ˢ��BGN;
					$Element['�Ͽ�ˢ��END'] = $�Ͽ�ˢ��END;
					$Element['�¿�ˢ��BGN'] = $�¿�ˢ��BGN;
					$Element['�¿�ˢ��END'] = $�¿�ˢ��END;
					$ElementValue = array_values($Element);
					$sqlValueText = "'".join("','",$ElementValue)."'";
					$ElementName = array_keys($Element);
					$sqlNameText = "`".join("`,`",$ElementName)."`";
					$sql = "insert into edu_teacherkaoqinmingxi($sqlNameText) values($sqlValueText)";
					global $SHOWTEXT; if($SHOWTEXT)print $sql."<BR>";
					$db->Execute($sql);
				}	//���ڼ�¼,���½����µļ�¼�Ƿ����
				//print $XX;
		}
		//print $XX;
	}
}

//������ʦ�����쳣������Ϣ
function ������ʦ�����쳣������Ϣ()		{
	global $db,$CurXueQi;
	//���  ѧ��  �༶  ����  �γ�  ԭ��ʦ  �½�ʦ  �Ͽ�ʱ��  �ڴ�  ���״̬  ������ID��  �����  ���ʱ��
	//��һ��:�жϴ���������ȷ�ҽ���
	$sql = "select * from edu_scheduledaike where ���״̬='1' and ԭ��ʦ�û���!='' order by ��� desc limit 100";
	$rs = $db->Execute($sql);
	$rs_a = $rs->GetArray();
	for($i=0;$i<sizeof($rs_a);$i++)				{
		$ԭ��ʦ = $rs_a[$i]['ԭ��ʦ'];
		$�½�ʦ = $rs_a[$i]['�½�ʦ'];
		$���	= $rs_a[$i]['���'];
		$�༶	= $rs_a[$i]['�༶'];
		$��ʦ	= $rs_a[$i]['��ʦ'];
		$ԭ��ʦ�û���	= $rs_a[$i]['ԭ��ʦ�û���'];
		$�½�ʦ�û���	= $rs_a[$i]['�½�ʦ�û���'];
		$�Ͽ�ʱ�� = $rs_a[$i]['�Ͽ�ʱ��'];
		$�ڴ�	= $rs_a[$i]['�ڴ�'];
		$�γ�	= $rs_a[$i]['�γ�'];
		global $SHOWTEXT; if($SHOWTEXT)	print "<BR><font color=green><B>$sql</B></font><BR>";
		//�ڶ���:�жϴ�����Ľ�ʦ�Ƿ��п�,���Ƿ�ɹ�
		//�ж��������Ƿ����ɹ�
		$sql = "select * from edu_teacherkaoqinmingxi where ѧ��='$CurXueQi' and ��������='$�Ͽ�ʱ��' and ��ʦ�û���='$�½�ʦ�û���' and �ڴ�='$�ڴ�'";
		$rs = $db->Execute($sql);
		$rsX_a = $rs->GetArray();
		global $SHOWTEXT; if($SHOWTEXT)	print "<BR>��ѯ:".$sql."<BR>";
		if($rsX_a[0]['��ʦ����']!="")		{
			//�����ݼ���ɹ�,����ɾ��ԭ����
			$sql = "delete from edu_teacherkaoqinmingxi where �༶='$�༶' and ��ʦ�û���='$ԭ��ʦ�û���' and ��������='$�Ͽ�ʱ��' and �ڴ�='$�ڴ�' and ѧ��='$CurXueQi'";
			$db->Execute($sql);
			global $SHOWTEXT; if($SHOWTEXT)	print "<BR>�����ݼ���ɹ�,����ɾ��ԭ����:".$sql."<BR>";
		}
		else	{
			//�����ݲ�����,���ж�ԭ�����Ƿ����
			$sql = "select * from edu_teacherkaoqinmingxi where ѧ��='$CurXueQi' and ��������='$�Ͽ�ʱ��' and ��ʦ�û���='$ԭ��ʦ�û���' and �ڴ�='$�ڴ�'";
			$rs = $db->Execute($sql);
			$rsX_a = $rs->GetArray();
			$��� = $rsX_a[0]['���'];
			global $SHOWTEXT; if($SHOWTEXT)	print "<BR>��ѯ:".$sql."<BR>";
			if($���!="")			{
				$sql = "update edu_teacherkaoqinmingxi set ��ʦ����='$�½�ʦ',��ʦ�û���='$�½�ʦ�û���' where ���='$���'";
				$db->Execute($sql);
				global $SHOWTEXT; if($SHOWTEXT)	print "<BR>�����ݲ�����,ԭ���ݴ���,�����޸Ĳ���:".$sql."<BR>";
			}
			else	{
				global $SHOWTEXT; if($SHOWTEXT)	print "<BR>�����ݲ�����,ԭ����Ҳ������,�����в���<BR>";
			}
		}
	}

}

//������ʦ�໥�����쳣������Ϣ
function ������ʦ�໥�����쳣������Ϣ()		{
	global $db,$CurXueQi;
	//��һ��:�жϴ���������ȷ�ҽ���
	$sql = "select * from edu_scheduletiaokexianghu where ���״̬='1' order by ��� desc limit 30";
	$rs = $db->Execute($sql);
	$rs_a = $rs->GetArray();
	for($i=0;$i<sizeof($rs_a);$i++)				{
		$ԭ��ʦ�û��� = $rs_a[$i]['ԭ��ʦ�û���'];
		$ԭ�Ͽ�ʱ��	= $rs_a[$i]['ԭ�Ͽ�ʱ��'];
		$ԭ�ڴ�	= $rs_a[$i]['ԭ�ڴ�'];
		$ԭ�γ�	= $rs_a[$i]['ԭ�γ�'];
		$ԭ��ʦ	= $rs_a[$i]['ԭ��ʦ'];
		$�½�ʦ�û���	= $rs_a[$i]['�½�ʦ�û���'];
		$���Ͽ�ʱ��	= $rs_a[$i]['���Ͽ�ʱ��'];
		$�½ڴ�	= $rs_a[$i]['�½ڴ�'];
		$�¿γ�	= $rs_a[$i]['�¿γ�'];
		$�½�ʦ	= $rs_a[$i]['�½�ʦ'];

		$�Ͽ�ʱ�� = $rs_a[$i]['�Ͽ�ʱ��'];
		$�ڴ�	= $rs_a[$i]['�ڴ�'];
		$�γ�	= $rs_a[$i]['�γ�'];
		global $SHOWTEXT; if($SHOWTEXT)	print "<BR><font color=green><B>$sql</B></font><BR>";
		//ԭ��ʦ���
		$sql = "select ��� from edu_teacherkaoqinmingxi where ��ʦ����='$ԭ��ʦ' and ��ʦ�û���='$ԭ��ʦ�û���' and �ڴ�='$ԭ�ڴ�' and ��������='$ԭ�Ͽ�ʱ��'";
		print $sql."<BR>";
		$rs = $db->Execute($sql);
		$ԭ��� = $rs->fields['���'];
		if($ԭ���!="")			{
			$sql = "update edu_teacherkaoqinmingxi set ��ʦ����='$�½�ʦ',��ʦ�û���='$�½�ʦ�û���',�γ�='$�¿γ�' where ���='$ԭ���'";
			print $sql."<BR>";
			$db->Execute($sql);
		}
		//�½�ʦ���
		$sql = "select ��� from edu_teacherkaoqinmingxi where ��ʦ����='$�½�ʦ' and ��ʦ�û���='$�½�ʦ�û���' and �ڴ�='$�½ڴ�' and ��������='$���Ͽ�ʱ��'";
		print $sql."<BR>";
		$rs = $db->Execute($sql);
		$�±�� = $rs->fields['���'];
		if($�±��!="")			{
			$sql = "update edu_teacherkaoqinmingxi set ��ʦ����='$ԭ��ʦ',��ʦ�û���='$ԭ��ʦ�û���',�γ�='$ԭ�γ�' where ���='$�±��'";
			print $sql."<BR>";
			$db->Execute($sql);
		}
	}

}

//������ѧ�ռ�����İ༶������Ϣ
function ������ѧ�ռ�����İ༶������Ϣ()  {
	global $db,$CurXueQi;
	$sql = "select distinct �༶ from edu_teacherkaoqinmingxi where ѧ��='$CurXueQi'"; // where ִ��״̬='0'
	$rs = $db->Execute($sql);
	$rs_a = $rs->GetArray();
	$NewArray = array();
	for($i=0;$i<sizeof($rs_a);$i++)				{
		$�༶ = $rs_a[$i]['�༶'];
		$�༶���� =  returnClassNumber($�༶);
		$sql = "update edu_teacherkaoqinmingxi set �༶����='$�༶����' where �༶='$�༶'";
	    $db->Execute($sql);
		$sql = "update edu_teacherkaoqinmingxi set ʵ������='$�༶����' where �༶='$�༶' and ʵ������>'$�༶����'";
	    $db->Execute($sql);
		global $SHOWTEXT; if($SHOWTEXT)print "<BR>������ѧ�ռ�����İ༶������Ϣ:".$sql."<BR>";
	}
}



//������ѧ�ռ�����Ŀ��ܴ���Ϣ
function ������ѧ�ռ�����Ŀ��ܴ���Ϣ()  {
	global $db,$CurXueQi;
	//$sql = "update edu_teacherkaoqinmingxi set �ܴ�='6' where �ܴ�='33'"; // where ִ��״̬='0'
	//$db->Execute($sql);
	$sql = "select ��������,��� from edu_teacherkaoqinmingxi where �ܴ�='' and ѧ��='$CurXueQi'"; // where ִ��״̬='0'
	$rs = $db->Execute($sql);
	$rs_a = $rs->GetArray();
	for($i=0;$i<sizeof($rs_a);$i++)				{
		$�������� = $rs_a[$i]['��������'];
		$�¿������� = returntablefield("edu_schedulejiejiari","�������Ͽ�ʱ��",$��������,"ԭ�Ͽ�ʱ��");
		if($�¿�������!="")			{
			$�¿�������Array = explode('-',$�¿�������);
			$�¿������� = date("Y-m-d",mktime(1,1,1,$�¿�������Array[1],$�¿�������Array[2],$�¿�������Array[0]));
			$�������� = $�¿�������;
		}
		$��� = $rs_a[$i]['���'];
		$�ܴ� =  returnCurWeekIndex($��������);
		$sql = "update edu_teacherkaoqinmingxi set �ܴ�='$�ܴ�' where ���='$���'"; // where ִ��״̬='0'
	    $db->Execute($sql);
		global $SHOWTEXT; if($SHOWTEXT)print "<BR>������ѧ�ռ�����Ŀ��ܴ���Ϣ:".$sql."<BR>";
	}
}

//������ѧ�ռ�����Ŀ�������Ϣ
function ������ѧ�ռ�����Ŀ�������Ϣ()  {
	global $db,$CurXueQi;
	$sql = "select ��������,��� from edu_teacherkaoqinmingxi where ����='' and ѧ��='$CurXueQi'"; // where ִ��״̬='0'
	$rs = $db->Execute($sql);
	$rs_a = $rs->GetArray();
	for($i=0;$i<sizeof($rs_a);$i++)				{
		$��������Array = explode('-',$rs_a[$i]['��������']);
		$��� = $rs_a[$i]['���'];
		$���� = date("w",mktime(1,1,1,$��������Array[1],$��������Array[2],$��������Array[0]));
		$sql = "update edu_teacherkaoqinmingxi set ����='$����' where ���='$���'"; // where ִ��״̬='0'
	    $db->Execute($sql);
		global $SHOWTEXT; if($SHOWTEXT)print "<BR>������ѧ�ռ�����Ŀ�������Ϣ:".$sql."<BR>";
	}
}

//������ѧ�ռ�����Ŀ��ܴ���Ϣ
function ����ѧ����������Ŀ�������Ϣ()  {
	global $db,$CurXueQi;
	$sql = "select distinct ѧ�� from edu_studentkaoqin where ����='0' and ѧ������='$CurXueQi'"; // where ִ��״̬='0'
	$rs = $db->Execute($sql);
	$rs_a = $rs->GetArray();
	for($i=0;$i<sizeof($rs_a);$i++)				{
		$ѧ�� = $rs_a[$i]['ѧ��'];
		$���� = returntablefield("edu_student","ѧ��",$ѧ��,"����");
		if($����>0)			{
			$sql = "update edu_studentkaoqin set ����='$����' where ѧ��='$ѧ��' and ѧ������='$CurXueQi'"; // where ִ��״̬='0'
			$db->Execute($sql);
			global $SHOWTEXT; if($SHOWTEXT)print "<BR>����ѧ����������Ŀ�������Ϣ:".$sql."<BR>";
		}
	}
}


//������ѧ�ռ�����Ŀ��ܴ���Ϣ
function ����ѧ����������Ŀ��ܴ���Ϣ()  {
	global $db,$CurXueQi;
	$sql = "select distinct �������� from edu_studentkaoqin where �ܴ�='0' and ѧ������='$CurXueQi'"; // where ִ��״̬='0'
	$rs = $db->Execute($sql);
	$rs_a = $rs->GetArray();
	for($i=0;$i<sizeof($rs_a);$i++)				{
		$�������� = $rs_a[$i]['��������'];
		$�ܴ� =  returnCurWeekIndex($��������);
		if($�ܴ�>0)			{
			$sql = "update edu_studentkaoqin set �ܴ�='$�ܴ�' where ��������='$��������'"; // where ִ��״̬='0'
			$db->Execute($sql);
			global $SHOWTEXT; if($SHOWTEXT)print "<BR>����ѧ����������Ŀ��ܴ���Ϣ:".$sql."<BR>";
		}
	}
}

//�ڼ��յ���
function �ڼ��յ���()		{
	global $db,$CurXueQi;
	$sql = "select * from edu_schedulejiejiari"; // where ִ��״̬='0'
	$rs = $db->Execute($sql);
	$rs_a = $rs->GetArray();
	$NewArray = array();
	for($i=0;$i<sizeof($rs_a);$i++)						{
		$ԭ�Ͽ�ʱ�� = $rs_a[$i]['ԭ�Ͽ�ʱ��'];
		$�������Ͽ�ʱ�� = $rs_a[$i]['�������Ͽ�ʱ��'];
		$ִ��״̬ = $rs_a[$i]['ִ��״̬'];
		$NewArray['����'][$�������Ͽ�ʱ��] = $ԭ�Ͽ�ʱ��;
		$NewArray['����'][$ԭ�Ͽ�ʱ��] = $�������Ͽ�ʱ��;
		//����ڼ��յ��ε��ܴ���Ϣ2010-4-28�����ð�ʵ���ܴ�����
		$�ܴ� = returnCurWeekIndex($�������Ͽ�ʱ��);
		$�������Ͽ�ʱ��Array = explode('-',$�������Ͽ�ʱ��);
		$���� = date("w",mktime(1,1,1,$�������Ͽ�ʱ��Array[1],$�������Ͽ�ʱ��Array[2],$�������Ͽ�ʱ��Array[0]));
		$sql = "update edu_teacherkaoqinmingxi set �ܴ�='$�ܴ�',����='$����' where ��������='$�������Ͽ�ʱ��' and ѧ��='$CurXueQi'";
		global $SHOWTEXT; if($SHOWTEXT)print $sql."<BR>";
		$db->Execute($sql);
	}
	return $NewArray;
}

//��ʱ����ȶԵ��μƻ����е���(����Ƶ���)
function ����Ƶ���()		{
	global $db,$CurXueQi;
	//�α���ǰһ��ִ�� ��ʦ���ڲ�ִ��,�ı��ʦ���ڳ�ʼ������,�����䰴��ִ��,��Ϊ����ִ�г�ʼ������
	$����ʱ�� = date("Y-m-d",mktime(1,1,1,date('m'),date('d'),date('Y')));
	$sql = "select * from edu_schedulechange where ִ��ʱ��<='$����ʱ��' and ִ��״̬='0'";
	$rs = $db->Execute($sql);
	$rs_a = $rs->GetArray();
	//��ˮ��  ѧ��  ԭ�༶  ԭ����  ԭ��ʦ  ԭ�γ�  ԭ����  ԭ�ڴ�  ��˫��  �°༶  �½���  �½�ʦ  �¿γ�  ������  �½ڴ�  �µ�˫��  ִ��ʱ��  ִ��״̬
	for($i=0;$i<sizeof($rs_a);$i++)				{
		$��ˮ�� = $rs_a[$i]['��ˮ��'];
		$ѧ�� = $rs_a[$i]['ѧ��'];
		$ִ��ʱ�� = $rs_a[$i]['ִ��ʱ��'];
		$ԭ�༶ = $rs_a[$i]['ԭ�༶'];
		$ԭ���� = $rs_a[$i]['ԭ����'];
		$ԭ��ʦ = $rs_a[$i]['ԭ��ʦ'];
		$ԭ��ʦ�û��� = $rs_a[$i]['ԭ��ʦ�û���'];
		$ԭ�γ� = $rs_a[$i]['ԭ�γ�'];
		$ԭ���� = $rs_a[$i]['ԭ����'];
		$ԭ�ڴ� = $rs_a[$i]['ԭ�ڴ�'];
		$ԭ��˫�� = $rs_a[$i]['��˫��'];

		$�°༶ = $rs_a[$i]['�°༶'];
		$�½��� = $rs_a[$i]['�½���'];
		$�½�ʦ = $rs_a[$i]['�½�ʦ'];
		$�½�ʦ�û��� = $rs_a[$i]['�½�ʦ�û���'];
		$�¿γ� = $rs_a[$i]['�¿γ�'];
		$������ = $rs_a[$i]['������'];
		$�½ڴ� = $rs_a[$i]['�½ڴ�'];
		$�µ�˫�� = $rs_a[$i]['�µ�˫��'];



		//ִ�пα����
		$sql = "update edu_schedule set �༶='$�°༶',�γ�='$�¿γ�',����='$�½���',��ʦ='$�½�ʦ',��ʦ�û���='$�½�ʦ�û���' where �༶='$ԭ�༶' and �γ�='$ԭ�γ�' and ��ʦ='$ԭ��ʦ' and ��ʦ�û���='$ԭ��ʦ�û���' and ����='$ԭ����' and �ڴ�='$ԭ�ڴ�' and ��˫��='$ԭ��˫��'";
		$db->Execute($sql);
		global $SHOWTEXT; if($SHOWTEXT)print $sql."<BR>";
		//���ĵ�ǰ״̬
		$sql = "update edu_schedulechange set ִ��״̬='1' where ��ˮ��='$��ˮ��'";
		$db->Execute($sql);
		global $SHOWTEXT; if($SHOWTEXT)print $sql."<BR>";
		//ȥ����ʦ������Ϣ������Ѿ��е�ֵ
		$sql = "delete from edu_teacherkaoqinmingxi where ��ʦ�û���='$ԭ��ʦ�û���' and ��ʦ����='$ԭ��ʦ' and ��������>='$ִ��ʱ��' and �γ�='$ԭ�γ�' and �༶='$ԭ�༶'";
		$db->Execute($sql);
	    global $SHOWTEXT; if($SHOWTEXT)print $sql."<BR>";

	}
}



//��ʱ����ȶԷֶν�ѧ���е���
function FenDuanJiaoXuePlanExec($ѧ��,$�ܴ�)		{
	global $db,$CurXueQi;
	//����ʷ���ݻ������ݽ��д���		//
	$sql = "select * from edu_schedulefenduanjiaoxue
			where (��ʼ��='$�ܴ�' or (��ʼ��<'$�ܴ�' and ִ��״̬='0')) and ѧ��='$CurXueQi'";
	// and ִ��״̬='0'
	$rs = $db->Execute($sql);
	$rs_a = $rs->GetArray();
	//print_R($rs_a);
	global $SHOWTEXT; if($SHOWTEXT)print "<font color=green>�ܴ�:$�ܴ� ".$sql."</font><BR>";
	//ѧ��  �༶  ����  ��ʦ  �γ�  ����  �ڴ�  ��˫��  ��ʼ��  ������
	for($i=0;$i<sizeof($rs_a);$i++)				{
		$���X = $rs_a[$i]['���'];
		$ѧ�� = $rs_a[$i]['ѧ��'];
		$�༶ = $rs_a[$i]['�༶'];
		$���� = $rs_a[$i]['����'];
		$��ʦ = $rs_a[$i]['��ʦ'];
		$��ʦ�û���	= $rs_a[$i]['��ʦ�û���'];
		$�γ� = $rs_a[$i]['�γ�'];
		$���� = $rs_a[$i]['����'];
		$�ڴ� = $rs_a[$i]['�ڴ�'];
		$��ʼ�� = $rs_a[$i]['��ʼ��'];
		$��˫�� = $rs_a[$i]['��˫��'];

		//���¶��ܴβ������и�ֵ
		$�ܴ� = $rs_a[$i]['��ʼ��'];

		//Ϊ��ʱ��ʾΪȫ��,��ʱ����������������ȫ������
		if($��˫��=='0')			{
			$AddSql = "and (��˫��='1' or ��˫��='2' or ��˫��='0')";
		}
		else		{
			$AddSql = "and (��˫��='$��˫��' or ��˫��='0')";
		}
		//#########################################################################################
		//�ó�ԭ�пα���Ϣ���Ͽ���Ϣ
		$sql = "select distinct ��ʦ,�γ�,��ʦ�û��� from edu_schedule where ѧ��='$ѧ��' and �༶='$�༶' and ����='$����' and �ڴ�='$�ڴ�' $AddSql";
		$rs =$db->Execute($sql);
		$��ʦX = $rs->fields['��ʦ'];
		$��ʦ�û���X = $rs->fields['��ʦ�û���'];
		$�γ�X = $rs->fields['�γ�'];
		global $SHOWTEXT; if($SHOWTEXT)print "<font color=green>�ܴ�:$�ܴ� ".$sql."</font><BR>";
		//ȥ����ʦ������Ϣ������Ѿ��е�ֵ
		global $SHOWTEXT; if($SHOWTEXT)print "<font color=red>��ʦ:$��ʦ �γ�:$�γ� �γ�X:$�γ�X ��ʦX:$��ʦX �ܴ�:$�ܴ� </font><BR>";
		if($��ʦX!=""&&$�γ�X!=""&&($��ʦX!=$��ʦ||$�γ�X!=$�γ�))		{
			global $SHOWTEXT; if($SHOWTEXT)print "<font color=red>��ʦ:$��ʦ �γ�:$�γ� �γ�X:$�γ�X ��ʦX:$��ʦX �ܴ�:$�ܴ� </font><BR>";

			//������Ѿ������ڿα������,Ϊ�µ��ܴ���Ϣ���������ռ�
			//Ϊĳһ�༶,��ĳһʱ������Ͽ���Ϣ,��ʦ,�γ�,������Ϣ�����仯
			$sql = "delete from edu_schedule where ��ʦ�û���='$��ʦ�û���X' and ѧ��='$ѧ��' and �༶='$�༶' and ����='$����' and �ڴ�='$�ڴ�' $AddSql";
			$db->Execute($sql);
			global $SHOWTEXT; if($SHOWTEXT)print "<font color=green>�ܴ�:$�ܴ� ".$sql."</font><BR>";

			//��ɾ�����ܻ�ɾ��һЩ�ֹ������Ľ�ʦ���ڼ�¼
			$sql = "delete from edu_teacherkaoqinmingxi where ��ʦ�û���='$��ʦ�û���X' and �ܴ�>='$�ܴ�' and �γ�='$�γ�X' and ѧ��='$CurXueQi'";
			$db->Execute($sql);
			global $SHOWTEXT; if($SHOWTEXT)print "<font color=green>�ܴ�:$�ܴ� ".$sql."</font><BR>";

			//���¿α��м����µĿγ̰���(ѧ��  �༶  ����  ��ʦ  �γ�  ����  �ڴ�  ��˫�� )
			$sql = "insert into edu_schedule values ('','$ѧ��','$�༶','$����','$��ʦ','$�γ�','$����','$�ڴ�','$��˫��','$��ʦ�û���');";
			$db->Execute($sql);
			global $SHOWTEXT; if($SHOWTEXT)print "<font color=green>�ܴ�:$�ܴ� ".$sql."</font><BR>";

			//�Խ�ʦ������Ϣִ�и��²���
			$Ŀ���ܵ�һ��ʱ�� = returnWeekDayNumber($�ܴ�);
			$Ŀ���ܵ�һ��ʱ��Array = explode('-',$Ŀ���ܵ�һ��ʱ��);
			for($iX=0;$iX<14;$iX++)		{
				$Datetime = date("Y-m-d",mktime(1,1,1,$Ŀ���ܵ�һ��ʱ��Array[1],$Ŀ���ܵ�һ��ʱ��Array[2]+$iX,$Ŀ���ܵ�һ��ʱ��Array[0]));
				global $SHOWTEXT; if($SHOWTEXT)print "<BR>��ʼ����ֶν�ѧ-�ָ���ʦ���ݲ���($Datetime):#################<BR>";
				//Init_Teacher_KaoQin_Data($Datetime,$��ʦ,$��ʦ�û���);
				//Init_Teacher_KaoQin_Data($Datetime,$��ʦX,$��ʦ�û���X);
			}
		}
		else	{

		}

		//#########################################################################################
		//�ó�ԭ�пα���Ϣ���Ͽ���Ϣ
		$sql = "select distinct ��ʦ,�γ�,�༶,��ʦ�û��� from edu_schedule where ѧ��='$ѧ��' and ��ʦ�û���='$��ʦ�û���' and ����='$����' and �ڴ�='$�ڴ�' $AddSql";
		$rs =$db->Execute($sql);
		$��ʦ�û���X = $rs->fields['��ʦ�û���'];
		$��ʦX = $rs->fields['��ʦ'];
		$�༶X = $rs->fields['�༶'];
		$�γ�X = $rs->fields['�γ�'];
		global $SHOWTEXT; if($SHOWTEXT)print "<font color=green>�ܴ�:$�ܴ� ".$sql."</font><BR>";
		//ȥ����ʦ������Ϣ������Ѿ��е�ֵ
		global $SHOWTEXT; if($SHOWTEXT)print "<font color=red>�༶:$�༶ �γ�:$�γ� �γ�X:$�γ�X �༶X:$�༶X �ܴ�:$�ܴ� </font><BR>";
		if($�༶X!=""&&$�γ�X!=""&&($�༶X!=$�༶||$�γ�X!=$�γ�))		{
			global $SHOWTEXT; if($SHOWTEXT)print "<font color=red>�༶:$�༶ �γ�:$�γ� �γ�X:$�γ�X �༶X:$�༶X �ܴ�:$�ܴ� </font><BR>";

			//������Ѿ������ڿα������,Ϊ�µ��ܴ���Ϣ���������ռ�
			//Ϊĳһ�༶,��ĳһʱ������Ͽ���Ϣ,�༶,�γ�,������Ϣ�����仯
			$sql = "delete from edu_schedule where ��ʦ�û���='$��ʦ�û���X' and ѧ��='$ѧ��' and �༶='$�༶X' and ����='$����' and �ڴ�='$�ڴ�' $AddSql";
			$db->Execute($sql);
			global $SHOWTEXT; if($SHOWTEXT)print "<font color=green>�ܴ�:$�ܴ� ".$sql."</font><BR>";

			//��ɾ�����ܻ�ɾ��һЩ�ֹ������Ľ�ʦ���ڼ�¼
			$sql = "delete from edu_teacherkaoqinmingxi where ��ʦ�û���='$��ʦ�û���X' and �ܴ�>='$�ܴ�' and �γ�='$�γ�X' and ѧ��='$CurXueQi'";
			$db->Execute($sql);
			global $SHOWTEXT; if($SHOWTEXT)print "<font color=green>�ܴ�:$�ܴ� ".$sql."</font><BR>";

			//���¿α��м����µĿγ̰���(ѧ��  �༶  ����  ��ʦ  �γ�  ����  �ڴ�  ��˫�� )
			$sql = "insert into edu_schedule values ('','$ѧ��','$�༶','$����','$��ʦ','$�γ�','$����','$�ڴ�','$��˫��','$��ʦ�û���');";
			$db->Execute($sql);
			global $SHOWTEXT; if($SHOWTEXT)print "<font color=green>�ܴ�:$�ܴ� ".$sql."</font><BR>";

			//�Խ�ʦ������Ϣִ�и��²���
			$Ŀ���ܵ�һ��ʱ�� = returnWeekDayNumber($�ܴ�);
			$Ŀ���ܵ�һ��ʱ��Array = explode('-',$Ŀ���ܵ�һ��ʱ��);
			for($iX=0;$iX<14;$iX++)		{
				$Datetime = date("Y-m-d",mktime(1,1,1,$Ŀ���ܵ�һ��ʱ��Array[1],$Ŀ���ܵ�һ��ʱ��Array[2]+$iX,$Ŀ���ܵ�һ��ʱ��Array[0]));
				global $SHOWTEXT; if($SHOWTEXT)print "<BR>��ʼ����ֶν�ѧ-�ָ���ʦ���ݲ���($Datetime):#################<BR>";
				//Init_Teacher_KaoQin_Data($Datetime,$��ʦ,$��ʦ�û���);
			}
		}
		else	{

		}
		//#########################################################################################
		//���ĵ�ǰ״̬
		$sql = "update edu_schedulefenduanjiaoxue set ִ��״̬='1' where ���='$���X'";
		//$db->Execute($sql);
		global $SHOWTEXT; if($SHOWTEXT)print "<font color=red>�ܴ�:$�ܴ� $Ŀ���ܵ�һ��ʱ�� ".$sql."</font><BR>";
		//exit;

	}

}

function returnWeekDayNumber($�ܴ�)		{
	global $db,$��ʼʱ��,$����ʱ��,$��ʼʱ��Array,$����ʱ��Array,$ShowData,$ShowDataText;
	$sql = "select max(����ʱ��) as ����ʱ�� ,min(����ʱ��) as ��ʼʱ�� from edu_schoolcalendar";
	$rs = $db->Execute($sql);
	$rs_a = $rs->GetArray();
	$��ʼʱ�� = $rs_a[0]['��ʼʱ��'];
	$����ʱ�� = $rs_a[0]['����ʱ��'];
	$��ʼʱ��Array = explode('-',$rs_a[0]['��ʼʱ��']);
	$Number = ($�ܴ�-1)*7;
	$��ʼ�Ƚ�ʱ��X = date("Y-m-d",mktime(1,1,1,$��ʼʱ��Array[1],$��ʼʱ��Array[2]+$Number,$��ʼʱ��Array[0]));
	$��ʼ�Ƚ�ʱ��t = date("w",mktime(1,1,1,$��ʼʱ��Array[1],$��ʼʱ��Array[2]+$Number,$��ʼʱ��Array[0]));
	$��ʼ�Ƚ�ʱ��X = date("Y-m-d",mktime(1,1,1,$��ʼʱ��Array[1],$��ʼʱ��Array[2]+$Number-$��ʼ�Ƚ�ʱ��t+1,$��ʼʱ��Array[0]));
	return $��ʼ�Ƚ�ʱ��X;
}

function returnWeekDayNumberALL($�ܴ�)		{
	global $db,$��ʼʱ��,$����ʱ��,$��ʼʱ��Array,$����ʱ��Array,$ShowData,$ShowDataText;
	$sql = "select max(����ʱ��) as ����ʱ�� ,min(����ʱ��) as ��ʼʱ�� from edu_schoolcalendar";
	$rs = $db->Execute($sql);
	$rs_a = $rs->GetArray();
	$��ʼʱ�� = $rs_a[0]['��ʼʱ��'];
	$����ʱ�� = $rs_a[0]['����ʱ��'];
	$��ʼʱ��Array = explode('-',$rs_a[0]['��ʼʱ��']);
	$Number = ($�ܴ�-1)*7;
	$��ʼ�Ƚ�ʱ��X = date("Y-m-d",mktime(1,1,1,$��ʼʱ��Array[1],$��ʼʱ��Array[2]+$Number,$��ʼʱ��Array[0]));
	$��ʼ�Ƚ�ʱ��t = date("w",mktime(1,1,1,$��ʼʱ��Array[1],$��ʼʱ��Array[2]+$Number,$��ʼʱ��Array[0]));
	$��ʼ�Ƚ�ʱ��X = date("Y-m-d",mktime(1,1,1,$��ʼʱ��Array[1],$��ʼʱ��Array[2]+$Number-$��ʼ�Ƚ�ʱ��t,$��ʼʱ��Array[0]));
	$�����Ƚ�ʱ��X = date("Y-m-d",mktime(1,1,1,$��ʼʱ��Array[1],$��ʼʱ��Array[2]+$Number-$��ʼ�Ƚ�ʱ��t+7,$��ʼʱ��Array[0]));
	$��ǰ�·� = date("n",mktime(1,1,1,$��ʼʱ��Array[1],$��ʼʱ��Array[2]+$Number-$��ʼ�Ƚ�ʱ��t,$��ʼʱ��Array[0]));
	$NewArray['��ʼʱ��'] = $��ʼ�Ƚ�ʱ��X;
	$NewArray['����ʱ��'] = $�����Ƚ�ʱ��X;
	$NewArray['��ǰ�·�'] = $��ǰ�·�;
	return $NewArray;
}


function XiaoLiArray()		{
	global $db,$��ʼʱ��,$����ʱ��,$��ʼʱ��Array,$����ʱ��Array,$ShowData,$ShowDataText;

	//У��������Դ
	$sql = "select * from edu_schoolcalendar";
	$rs = $db->Execute($sql);
	$rs_a = $rs->GetArray();
	for($i=0;$i<sizeof($rs_a);$i++)				{
		$��ʼʱ��S = $rs_a[$i]['��ʼʱ��'];
		$����ʱ��S = $rs_a[$i]['����ʱ��'];
		$�ڼ��� = $rs_a[$i]['�ڼ���'];
		if($��ʼʱ��S==$����ʱ��S)		{
			$ShowData[$��ʼʱ��S] = $�ڼ���;
			$ShowDataText[$��ʼʱ��S] = "style='BACKGROUND:#FFEBEB'";
		}
		else		{
			$��ʼʱ��XArray = explode('-',$��ʼʱ��S);
			for($iX=0;$iX<70;$iX++)				{
				$��ʼ�Ƚ�ʱ��X = date("Y-m-d",mktime(1,1,1,$��ʼʱ��XArray[1],$��ʼʱ��XArray[2]+$iX,$��ʼʱ��XArray[0]));
				if($��ʼ�Ƚ�ʱ��X>$����ʱ��S) continue;//�����·ݹ���
				//if($��ʼʱ��S=="2010-01-23")print $��ʼʱ��S." ".$��ʼ�Ƚ�ʱ��X." ".$����ʱ��S."<BR>";
				$ShowData[$��ʼ�Ƚ�ʱ��X] = $�ڼ���;
				$ShowDataText[$��ʼ�Ƚ�ʱ��X] = "style='BACKGROUND:#FFEBEB'";
			}
		}

		//#####################################################################
		//ִ�е�ǰ���Ƿ�Ϊ�ڼ���
		$sql = "delete from edu_teacherkaoqinmingxi  where ��������>='$��ʼʱ��S' and ��������<='$����ʱ��S'";
		global $SHOWTEXT; if($SHOWTEXT)print "<BR>У��:".$sql."<HR>";
		$db->Execute($sql);
		//#####################################################################
	}


	//����
}





function ReturnTeacherSchedule($ѧ��,$��ʦ�û���,$��ʦ,$�ܴ�)  {
	global $db,$CurXueQi;
	$sql = "select ����,�ڴ�,����,�γ�,�༶,��˫�� from edu_schedule where ѧ��='$ѧ��' and ��ʦ�û���='$��ʦ�û���' order by ���� asc,��˫�� asc,�ڴ� asc";
	$rs = $db->Execute($sql);
	$rs_a = $rs->GetArray();
	//���˺ϰ��Ͽ�
	for($i=0;$i<sizeof($rs_a);$i++)		{
		$�༶ = $rs_a[$i]['�༶'];
		$sql = "select ���� from edu_schooljingcheng
				where ѧ��='$ѧ��' and �༶='$�༶' and �ܴ�='$�ܴ�' and ��ʼ����='' and ��������=''";
		$rsX = $db->Execute($sql);
		$rsX_a = $rsX->GetArray();
		$���� = TRIM($rsX_a[0]['����']);
		if($����=='')					{
			$���� = TRIM($rs_a[$i]['����']);
			$�ڴ� = TRIM($rs_a[$i]['�ڴ�']);
			$���� = TRIM($rs_a[$i]['����']);
			$�γ� = TRIM($rs_a[$i]['�γ�']);
			$�༶ = TRIM($rs_a[$i]['�༶']);
			$��˫�� = TRIM($rs_a[$i]['��˫��']);
			$���� = $����%7;
			if($��˫��=='0')		{
				$NewArray[$����][$�ڴ�]['1']['����']=TRIM($����);
				$NewArray[$����][$�ڴ�]['1']['�γ�']=TRIM($�γ�);
				$NewArray[$����][$�ڴ�]['1']['�༶']=TRIM($�༶);
				$NewArray[$����][$�ڴ�]['2']['����']=TRIM($����);
				$NewArray[$����][$�ڴ�]['2']['�γ�']=TRIM($�γ�);
				$NewArray[$����][$�ڴ�]['2']['�༶']=TRIM($�༶);
			}
			else	{
				$NewArray[$����][$�ڴ�][$��˫��]['����']=TRIM($����);
				$NewArray[$����][$�ڴ�][$��˫��]['�γ�']=TRIM($�γ�);
				$NewArray[$����][$�ڴ�][$��˫��]['�༶']=TRIM($�༶);
			}
		}//$����==''
		else	{
			global $SHOWTEXT; if($SHOWTEXT)print "<BR><font color=red>-----------�ֶν�ѧ:$�༶ $�γ� $���� $��ʦ</font><BR>";
		}

	}//end for
	global $SHOWTEXT; if($SHOWTEXT)print_R($NewArray[4]);//exit;
	return $NewArray;
	//
}



function Asc_Teacher_KaoQin_ToDay_Data($��������,$��ʦ����,$��ʦ�û���)			{
	global $db,$CurXueQi;
	global $SHOWTEXT; if($SHOWTEXT)print "<BR>ͬ����ʦ���쿼������====================================================<BR>";
	$sql = "select * from edu_teacherkaoqin where ��������='$��������' and ��ʦ�û���='$��ʦ�û���'";
	global $SHOWTEXT; if($SHOWTEXT)print $sql."<BR>";
	$rs2 = $db->Execute($sql);
	$rs2_a = $rs2->GetArray();
	for($iii=0;$iii<sizeof($rs2_a);$iii++)						{
		$ˢ��ʱ�� = $rs2_a[$iii]['ˢ��ʱ��'];
		global $SHOWTEXT; if($SHOWTEXT)print "<BR>DealTimeJieCiShangKe DealTimeJieCiXiaKe============<BR>";
		$DealTimeJieCiShangKe	= DealTimeJieCiShangKe($��ʦ����,$��ʦ�û���,$��������,$ˢ��ʱ��);
		$DealTimeJieCiXiaKe		= DealTimeJieCiXiaKe($��ʦ����,$��ʦ�û���,$��������,$ˢ��ʱ��);
		global $SHOWTEXT; if($SHOWTEXT)print "<BR>ͬ����ʦ���쿼������ $��ʦ���� $��ʦ�û��� $�������� $ˢ��ʱ��=========================";
	}
	//global $SHOWTEXT; if($SHOWTEXT)print "<BR>ͬ����ʦ���쿼������ $��ʦ���� $��ʦ�û��� $�������� $ˢ��ʱ��=========================";
	global $SHOWTEXT; if($SHOWTEXT&&sizeof($rs_a)>0)print_R($rs_a);;
}

//�༶��ѧ���̹���
function Banji_ShiXi_JiaoXueJinCheng($�༶,$�ܴ�,$ѧ��,$��������)		{
	global $db,$CurXueQi;
	//�༶ʵϰ�ܲ��ֵ���,����ð༶�ڵ�ǰ����ʵϰ�����ܴ�,��ô��ʦ�����򲻽��г�ʼ��
	$��������Array = explode('-',$��������);
	$��ǰ���� = date("w",mktime(1,1,1,$��������Array[1],$��������Array[2],$��������Array[0]));
	$sql = "select * from edu_schooljingcheng where �༶='$�༶' and �ܴ�='$�ܴ�' and ѧ��='$ѧ��'
			and ( (��ʼ����<='$��ǰ����' and ��������>='$��ǰ����')  or (��ʼ����='' and ��������='') )
			";
	global $SHOWTEXT; if($SHOWTEXT)print "<BR>�༶��ѧ���̹��� $�������� $�ܴ�<font color=red><B>$sql</B></font><BR>";
	$rs = $db->Execute($sql);
	$rs_a = $rs->GetArray();
	$���� = $rs_a[0]['����'];
	global $SHOWTEXT; if($SHOWTEXT)print "<BR><font color=green><B>$sql</B></font><BR>";
	if($����!="")		{
		//$sql = "delete from edu_teacherkaoqinmingxi where �༶='$�༶' and ѧ��='$ѧ��' and �ܴ�='$�ܴ�' and ��������='$��������'";
		/*
		$sql = "update edu_teacherkaoqinmingxi
				set �Ͽο���״̬='�༶��ѧ����',�¿ο���״̬='�༶��ѧ����',�Ͽ�ʵ��ˢ��='�༶��ѧ����',�¿�ʵ��ˢ��='�༶��ѧ����',��ע='".$�༶."��".$��������."�н�ѧ���̰���'
				where �༶='$�༶' and ѧ��='$ѧ��' and �ܴ�='$�ܴ�' and ��������='$��������'";
		*/
		$sql = "delete from edu_teacherkaoqinmingxi where �༶='$�༶' and ѧ��='$ѧ��' and �ܴ�='$�ܴ�' and ��������='$��������'";
		$db->Execute($sql);
		$db->Execute($sql);
		global $SHOWTEXT; if($SHOWTEXT)print "<BR>�༶��ѧ���̹��� $�������� <font color=red><B>$sql</B></font><BR>";
		global $SHOWTEXT; if($SHOWTEXT&&sizeof($rs_a)>0)print_R($rs_a);;
		//print $sql;exit;
	}
	//if($�༶=="����0801��")	print "<BR><font color=orange><B>$sql</B></font><BR>"; //$����='����';
	return $����;
}


//��ʦ���ι���
function Teacher_DaiKe_Infor($��ʦ,$��ʦ�û���,$�Ͽ�ʱ��,$�ڴ�,$�γ�,$ѧ��)		{
	global $db,$CurXueQi;
	//���  ѧ��  �༶  ����  �γ�  ԭ��ʦ  �½�ʦ  �Ͽ�ʱ��  �ڴ�  ���״̬  ������ID��  �����  ���ʱ��
	//��һ��:�жϴ���������ȷ�ҽ���
	$sql = "select �½�ʦ�û��� from edu_scheduledaike where ԭ��ʦ�û���='$��ʦ�û���' and �Ͽ�ʱ��='$�Ͽ�ʱ��' and �ڴ�='$�ڴ�' and �γ�='$�γ�' and ���״̬='1'";
	$rs = $db->Execute($sql);
	$rs_a = $rs->GetArray();
	$�½�ʦ�û��� = $rs_a[0]['�½�ʦ�û���'];
	global $SHOWTEXT; if($SHOWTEXT)	print "<BR><font color=green><B>$sql</B></font><BR>";
	//�ڶ���:�жϴ�����Ľ�ʦ�Ƿ��п�,���Ƿ�ɹ�
	if($�½�ʦ�û���!="")			{
		$sql = "select ��ʦ�û��� from edu_teacherkaoqinmingxi where ѧ��='$ѧ��' and ��ʦ�û���='$�½�ʦ�û���' and �γ�='$�γ�' and ��������='$�Ͽ�ʱ��' and �ڴ�='$�ڴ�'";
		$rs = $db->Execute($sql);
		$rs_a = $rs->GetArray();
		$��ʦ�û��� = $rs_a[0]['��ʦ�û���'];
		if($��ʦ�û���!="")		{
			//���γɹ�,�����κδ���
			return;
		}
		else		{
			//û�д�������,��Ҫ��������
			return $�½�ʦ�û���;
		}
	}
	else	{
		return;
	}
}

//��ʦ���ι���
function Teacher_TiaoKe_Infor($��ʦ,$��ʦ�û���,$�Ͽ�ʱ��,$�ڴ�,$�γ�,$ѧ��)		{
	global $db,$CurXueQi;
	// ���  ѧ��  �༶  ����  ��ʦ  �γ�  ԭ�Ͽ�ʱ��  ԭ�ڴ�  ���Ͽ�ʱ��  �½ڴ�  ���״̬  ������ID��  �����  ���ʱ��
	$sql = "select * from edu_scheduletiaoke where ��ʦ�û���='$��ʦ�û���' and ԭ�Ͽ�ʱ��='$�Ͽ�ʱ��' and ԭ�ڴ�='$�ڴ�' and �γ�='$�γ�' and ���״̬='1'";
	$rs = $db->Execute($sql);
	$rs_a = $rs->GetArray();
	$��� = $rs_a[0]['���'];
	$��ʦ = $rs_a[0]['��ʦ'];
	$��ʦ�û���	= $rs_a[0]['��ʦ�û���'];
	$�γ� = $rs_a[0]['�γ�'];
	$���� = $rs_a[0]['����'];
	$�༶ = $rs_a[0]['�༶'];
	$���Ͽ�ʱ�� = $rs_a[0]['���Ͽ�ʱ��'];
	$�½ڴ� = $rs_a[0]['�½ڴ�'];
	global $SHOWTEXT; if($SHOWTEXT)print "<BR><font color=green><B>$sql</B></font><BR>";
	if($���!="")		{
		//print $sql."���α�<BR>";
		$sql = "delete from edu_teacherkaoqinmingxi where ѧ��='$ѧ��' and ��ʦ����='$��ʦ' and ��ʦ�û���='$��ʦ�û���' and �γ�='$�γ�' and ��������='$�Ͽ�ʱ��' and �ڴ�='$�ڴ�'";
		$db->Execute($sql);
		global $SHOWTEXT; if($SHOWTEXT)print "��ʦ���ι���<BR><font color=red><B>$sql</B></font><BR>";
		global $SHOWTEXT; if($SHOWTEXT&&sizeof($rs_a)>0)print_R($rs_a);;
		//���ڼ�¼,���½����µļ�¼�Ƿ����
		$sql = "select * from edu_teacherkaoqinmingxi where ѧ��='$ѧ��' and ��ʦ����='$��ʦ' and ��ʦ�û���='$��ʦ�û���' and �γ�='$�γ�' and ��������='$���Ͽ�ʱ��' and �ڴ�='$�½ڴ�'";
		$rs = $db->Execute($sql);
		$rs_a = $rs->GetArray();
		$���X = $rs_a[0]['���'];
		if($���X=="")		{
			$�ڴ�Array = explode('-',$�½ڴ�);
			$Element = array();
			//$Element['���'] = '';
			global $KaoqinTime;
			global $KaoqinTimeBegin1,$KaoqinTimeBegin2,$KaoqinTimeEnd1,$KaoqinTimeEnd2,$KuangGongShiJian;


			$��������Array = explode('-',$���Ͽ�ʱ��);
			$��ǰ������ = date("w",mktime(1,1,1,$��������Array[1],$��������Array[2],$��������Array[0]));
			$X = 7-$��ǰ������;
			$�������� = returnJieCiName($�ڴ�Array[0]);
			$��Чʱ�� = returnJieCiTime($��������);
			$��Чʱ��Array = explode('-',$��Чʱ��);
			$��Чʱ��0Array = explode(':',$��Чʱ��Array[0]);
			$��Чʱ��1Array = explode(':',$��Чʱ��Array[1]);
			global $SYSTEM_MERGE_CLASSTABLE;
			if($�ڴ�Array[1]!=""&&$SYSTEM_MERGE_CLASSTABLE = "1")		{
				$��������1 = returnJieCiName($�ڴ�Array[1]);
				$��Чʱ��1 = returnJieCiTime($��������1);
				$��Чʱ��1Array = explode('-',$��Чʱ��1);
				$��Чʱ��1Array = explode(':',$��Чʱ��1Array[1]);
			}

			//print_R($��Чʱ��);
			$�Ͽ�ˢ��BGN = date("H:i",@mktime($��Чʱ��0Array[0],$��Чʱ��0Array[1]-$KaoqinTimeBegin1,30,12,12,2008));
			$�Ͽ�ˢ��END = date("H:i",@mktime($��Чʱ��0Array[0],$��Чʱ��0Array[1]+$KaoqinTimeBegin2,30,12,12,2008));
			$�¿�ˢ��BGN = date("H:i",@mktime($��Чʱ��1Array[0],$��Чʱ��1Array[1]-$KaoqinTimeEnd1,30,12,12,2008));
			$�¿�ˢ��END = date("H:i",@mktime($��Чʱ��1Array[0],$��Чʱ��1Array[1]+$KaoqinTimeEnd2,30,12,12,2008));

			$Element['��ʦ����'] = $��ʦ;
			$Element['��ʦ�û���'] = $��ʦ�û���;
			$Element['��������'] = $���Ͽ�ʱ��;
			$Element['����'] = $����;
			$Element['�γ�'] = $�γ�;
			$Element['�༶'] = $�༶;
			$Element['����'] = $��ǰ������;
			$Element['�ڴ�'] = $�½ڴ�;
			$Element['�ܴ�'] = returnCurWeekIndex($���Ͽ�ʱ��);
			$Element['ѧ��'] = $ѧ��;
			$Element['Ӧ����дʱ��'] = $���Ͽ�ʱ��;
			$Element['�����дʱ��'] = date("Y-m-d",mktime(1,1,1,$��������Array[1],$��������Array[2]+$X,$��������Array[0]));


			$Element['�Ͽ�ʵ��ˢ��'] = '';
			$Element['�Ͽο���״̬'] = '';
			$Element['�¿�ʵ��ˢ��'] = '';
			$Element['�¿ο���״̬'] = '';

			$Element['�Ͽ�ˢ��BGN'] = $�Ͽ�ˢ��BGN;
			$Element['�Ͽ�ˢ��END'] = $�Ͽ�ˢ��END;
			$Element['�¿�ˢ��BGN'] = $�¿�ˢ��BGN;
			$Element['�¿�ˢ��END'] = $�¿�ˢ��END;

			$ElementValue = array_values($Element);
			$sqlValueText = "'".join("','",$ElementValue)."'";
			$ElementName = array_keys($Element);
			$sqlNameText = "`".join("`,`",$ElementName)."`";

			$sql = "insert into edu_teacherkaoqinmingxi($sqlNameText) values($sqlValueText)";

			$db->Execute($sql);
			//print $sql."1111<BR>";exit;
		}
		//print $sql."$���X<BR>";exit;
	}
	return $���;
}


//��ʦ�໥���ι���
function Teacher_TiaoKeXiangHu_Infor($��ʦ,$��ʦ�û���,$�Ͽ�ʱ��,$�ڴ�,$�γ�,$ѧ��)		{
	global $db,$CurXueQi;
	// ���  ѧ��  �༶  ����  ��ʦ  �γ�  ԭ�Ͽ�ʱ��  ԭ�ڴ�  ���Ͽ�ʱ��  �½ڴ�  ���״̬  ������ID��  �����  ���ʱ��
	$sql = "select ��� from edu_scheduletiaokexianghu where ((ԭ��ʦ�û���='$��ʦ�û���' and ԭ�Ͽ�ʱ��='$�Ͽ�ʱ��' and ԭ�ڴ�='$�ڴ�' and ԭ�γ�='$�γ�') or (�½�ʦ�û���='$��ʦ�û���' and ���Ͽ�ʱ��='$�Ͽ�ʱ��' and �½ڴ�='$�ڴ�' and �¿γ�='$�γ�') ) and ���״̬='1'";
	global $SHOWTEXT; if($SHOWTEXT)print "<BR><font color=green><B>$sql</B></font><BR>";
	$rs = $db->Execute($sql);
	$rs_a = $rs->GetArray();
	$��� = $rs_a[0]['���'];
	global $SHOWTEXT; if($SHOWTEXT&&sizeof($rs_a)>0)print_R($rs_a);;
	return $���;
}


//��ʦͣ��-���ι���
function Teacher_TingKe_Infor($��ʦ,$��ʦ�û���,$�Ͽ�ʱ��,$�ڴ�,$�γ�,$ѧ��)		{
	global $db,$CurXueQi;
	$sql = "select * from edu_scheduletingkefuke where ��ʦ�û���='$��ʦ�û���' and ԭ�Ͽ�ʱ��='$�Ͽ�ʱ��' and ԭ�ڴ�='$�ڴ�' and �γ�='$�γ�' and ͣ�����״̬='1'";
	$rs = $db->Execute($sql);
	$rs_a = $rs->GetArray();
	$��� = $rs_a[0]['���'];
	$��ʦ = $rs_a[0]['��ʦ'];
	$��ʦ�û���	= $rs_a[0]['��ʦ�û���'];
	$�γ� = $rs_a[0]['�γ�'];
	$���� = $rs_a[0]['����'];
	$�༶ = $rs_a[0]['�༶'];
	$���Ͽ�ʱ�� = $rs_a[0]['���Ͽ�ʱ��'];
	$�½ڴ� = $rs_a[0]['�½ڴ�'];
	global $SHOWTEXT; if($SHOWTEXT)print "<BR><font color=green><B>$sql</B></font><BR>";
	if($���!="")		{
		//print $sql."���α�<BR>";
		$sql = "delete from edu_teacherkaoqinmingxi where ѧ��='$ѧ��' and ��ʦ����='$��ʦ' and ��ʦ�û���='$��ʦ�û���' and �γ�='$�γ�' and ��������='$�Ͽ�ʱ��' and �ڴ�='$�ڴ�'";
		$db->Execute($sql);
		global $SHOWTEXT; if($SHOWTEXT)print "��ʦͣ��-���ι���<BR><font color=red><B>$sql</B></font><BR>";
		global $SHOWTEXT; if($SHOWTEXT&&sizeof($rs_a)>0)print_R($rs_a);;
		//���ڼ�¼,���½����µļ�¼�Ƿ����
		$sql = "select * from edu_teacherkaoqinmingxi where ѧ��='$ѧ��' and ��ʦ����='$��ʦ' and ��ʦ�û���='$��ʦ�û���' and �γ�='$�γ�' and ��������='$���Ͽ�ʱ��' and �ڴ�='$�½ڴ�'";
		$rs = $db->Execute($sql);
		$rs_a = $rs->GetArray();
		$���X = $rs_a[0]['���'];
		if($���X=="")		{
			$�ڴ�Array = explode('-',$�½ڴ�);
			$Element = array();
			//$Element['���'] = '';
			global $KaoqinTime;
			global $KaoqinTimeBegin1,$KaoqinTimeBegin2,$KaoqinTimeEnd1,$KaoqinTimeEnd2,$KuangGongShiJian;

			$��������Array = explode('-',$���Ͽ�ʱ��);
			$��ǰ������ = date("w",mktime(1,1,1,$��������Array[1],$��������Array[2],$��������Array[0]));
			$X = 7-$��ǰ������;
			$�������� = returnJieCiName($�ڴ�Array[0]);
			$��Чʱ�� = returnJieCiTime($��������);
			$��Чʱ��Array = explode('-',$��Чʱ��);
			$��Чʱ��0Array = explode(':',$��Чʱ��Array[0]);
			$��Чʱ��1Array = explode(':',$��Чʱ��Array[1]);
			global $SYSTEM_MERGE_CLASSTABLE;
			if($�ڴ�Array[1]!=""&&$SYSTEM_MERGE_CLASSTABLE = "1")		{
				$��������1 = returnJieCiName($�ڴ�Array[1]);
				$��Чʱ��1 = returnJieCiTime($��������1);
				$��Чʱ��1Array = explode('-',$��Чʱ��1);
				$��Чʱ��1Array = explode(':',$��Чʱ��1Array[1]);
			}
			//print_R($��Чʱ��);
			$�Ͽ�ˢ��BGN = date("H:i",@mktime($��Чʱ��0Array[0],$��Чʱ��0Array[1]-$KaoqinTimeBegin1,30,12,12,2008));
			$�Ͽ�ˢ��END = date("H:i",@mktime($��Чʱ��0Array[0],$��Чʱ��0Array[1]+$KaoqinTimeBegin2,30,12,12,2008));
			$�¿�ˢ��BGN = date("H:i",@mktime($��Чʱ��1Array[0],$��Чʱ��1Array[1]-$KaoqinTimeEnd1,30,12,12,2008));
			$�¿�ˢ��END = date("H:i",@mktime($��Чʱ��1Array[0],$��Чʱ��1Array[1]+$KaoqinTimeEnd2,30,12,12,2008));

			$Element['��ʦ����'] = $��ʦ;
			$Element['��ʦ�û���'] = $��ʦ�û���;
			$Element['��������'] = $���Ͽ�ʱ��;
			$Element['����'] = $����;
			$Element['�γ�'] = $�γ�;
			$Element['�༶'] = $�༶;
			$Element['����'] = $��ǰ������;
			$Element['�ڴ�'] = $�½ڴ�;
			$Element['�ܴ�'] = returnCurWeekIndex($���Ͽ�ʱ��);
			$Element['ѧ��'] = $ѧ��;
			$Element['Ӧ����дʱ��'] = $���Ͽ�ʱ��;
			$Element['�����дʱ��'] = date("Y-m-d",mktime(1,1,1,$��������Array[1],$��������Array[2]+$X,$��������Array[0]));

			$Element['�Ͽ�ʵ��ˢ��'] = '';
			$Element['�Ͽο���״̬'] = '';
			$Element['�¿�ʵ��ˢ��'] = '';
			$Element['�¿ο���״̬'] = '';

			$Element['�Ͽ�ˢ��BGN'] = $�Ͽ�ˢ��BGN;
			$Element['�Ͽ�ˢ��END'] = $�Ͽ�ˢ��END;
			$Element['�¿�ˢ��BGN'] = $�¿�ˢ��BGN;
			$Element['�¿�ˢ��END'] = $�¿�ˢ��END;

			$ElementValue = array_values($Element);
			$sqlValueText = "'".join("','",$ElementValue)."'";
			$ElementName = array_keys($Element);
			$sqlNameText = "`".join("`,`",$ElementName)."`";

			$sql = "insert into edu_teacherkaoqinmingxi($sqlNameText) values($sqlValueText)";

			$db->Execute($sql);
			//print $sql."1111<BR>";exit;
		}
		//print $sql."$���X<BR>";exit;
	}
	return $���;
}


/*
//��ʦ���ι���
function Teacher_FuKe_Infor($��ʦ,$�Ͽ�ʱ��,$�ڴ�,$�γ�,$ѧ��)		{
	global $db,$CurXueQi;
	$sql = "select ��� from edu_scheduletingkefuke where ��ʦ='$��ʦ' and ���Ͽ�ʱ��='$�Ͽ�ʱ��' and �½ڴ�='$�ڴ�' and �γ�='$�γ�' and �������״̬='1'";
	global $SHOWTEXT; if($SHOWTEXT)print "<BR><font color=green><B>��ʦ����:$sql</B></font><BR>";
	$rs = $db->Execute($sql);
	$rs_a = $rs->GetArray();
	$��� = $rs_a[0]['���'];
	global $SHOWTEXT; if($SHOWTEXT&&sizeof($rs_a)>0)print_R($rs_a);;
	return $���;
}
*/




function   Init_Teacher_KaoQin_Data($�ڼ��յ���_������ʱ��,$Ĭ�Ͻ�ʦ����,$��ʦ�û���)							{
	global $db,$CurXueQi,$ShowData;


	if($Ĭ�Ͻ�ʦ����!="")  $AddSQL = " and ��ʦ����='$Ĭ�Ͻ�ʦ����'";
	else			$AddSQL = "";

	//��У������й���
	$sql = "select �ڼ��� from edu_schoolcalendar where ��ʼʱ��<='$�ڼ��յ���_������ʱ��' and ����ʱ��>='$�ڼ��յ���_������ʱ��'";
	$rs = $db->Execute($sql);
	$�ڼ��� = $rs->fields['�ڼ���'];
	if($�ڼ���!="")				{
		//��ǰʱ��Ϊ�ż�ʱ��,ϵͳ�����ӿ�����Ϣ
		return '';
	}

	//�ж�ѧ���Ƿ��ڽ��ս���
	$sql = "select * from edu_xueqiexec where ѧ������ ='$CurXueQi'";
	$rs = $db->Execute($sql);
	$ѧ�ڿ�ʼʱ�� = $rs->fields['��ʼʱ��'];
	$ѧ�ڽ���ʱ�� = $rs->fields['����ʱ��'];
	if($�ڼ��յ���_������ʱ��>$ѧ�ڽ���ʱ��&&$CurXueQi!="")			{
		//��ʾ��ѧ���Ѿ�����,������Чѧ��ʱ��֮��,�����г�ʼ������
		//print "$�ڼ��յ���_������ʱ�� ��ʾ��ѧ���Ѿ�����,������Чѧ��ʱ��֮��,�����г�ʼ������";
		//������������
		$sql = "delete from edu_teacherkaoqinmingxi where ѧ��='$CurXueQi' and ��������>'$ѧ�ڽ���ʱ��'";
		$db->Execute($sql);
		return '';
	}
	if($�ڼ��յ���_������ʱ��<$ѧ�ڿ�ʼʱ��&&$CurXueQi!="")			{
		//��ʾ��ѧ�ڻ�û�п�ʼ,������Чѧ��ʱ��֮��,�����г�ʼ������
		//print "$�ڼ��յ���_������ʱ�� ��ʾ��ѧ�ڻ�û�п�ʼ,������Чѧ��ʱ��֮��,�����г�ʼ������";
		$sql = "delete from edu_teacherkaoqinmingxi where ѧ��='$CurXueQi' and ��������<'$ѧ�ڿ�ʼʱ��'";
		$db->Execute($sql);
		return '';
	}

	//print $CurXueQi;exit;

	global $TiaoKeJieJiaRiExec;//2010-4-28����ȫ�ֱ���
	$�ڼ��յ���_ԭ�Ͽ�ʱ�� = $TiaoKeJieJiaRiExec['����'][$�ڼ��յ���_������ʱ��];
	//print_R($TiaoKeJieJiaRiExec);exit;
	//����Ϊ��������Ͽ�ʱ�� �ڼ��յ���_ԭ�Ͽ�ʱ���ֵΪԭ�Ͽ�ʱ��
	//����ʾ�ܴ���ϢӦ��Ϊԭ�Ͽ�ʱ����ܴ�,���ڼ��յ���_ԭ�Ͽ�ʱ����ܴ�
	if($�ڼ��յ���_ԭ�Ͽ�ʱ��=='')	{
		$�ڼ��յ���_ԭ�Ͽ�ʱ�� = $�ڼ��յ���_������ʱ��;//û��ֵʱ����Ŀ��ֵ
		$Element['��ע'] = '';
	}
	else		{
		//$�ڼ��յ���_ԭ�Ͽ�ʱ�� = $�ڼ��յ���_������ʱ��;//2010-4-28�ոĳɽڼ��յ���,��ʵ���Ͽ�������ʾ
		$Element['��ע'] = '�ڼ��յ���,ԭ�Ͽ�ʱ��Ϊ:$�ڼ��յ���_ԭ�Ͽ�ʱ��';
	}

	if($�ڼ��յ���_ԭ�Ͽ�ʱ��!='')	{
		//�����жԻ�ֵ,��ִ��״̬���и���
		$sql = "update edu_schedulejiejiari set ִ��״̬='1' where �������Ͽ�ʱ��='$�ڼ��յ���_������ʱ��'";
		$db->Execute($sql);
		global $SHOWTEXT; if($SHOWTEXT)print "<font color=green>".$sql."</font><BR>";
	}



	$YearMonth = explode('-',$�ڼ��յ���_ԭ�Ͽ�ʱ��);
	$Year = $YearMonth[0];
	$Month = $YearMonth[1];
	$Day = $YearMonth[2];

	//$DayIndexMonth = date('t',mktime(1,1,1,$Month,$Day,$Year));

	global $KaoqinTime;
	global $KaoqinTimeBegin1,$KaoqinTimeBegin2,$KaoqinTimeEnd1,$KaoqinTimeEnd2,$KuangGongShiJian;

	if($Ĭ�Ͻ�ʦ����!="")  $AddSQL = " where USER_NAME='$Ĭ�Ͻ�ʦ����'";
	else			$AddSQL = "";

	//$sql = "select USER_NAME AS ��ʵ���� from user $AddSQL order by USER_NAME";
	//$rs = $db->Execute($sql);
	//$rs_a = $rs->GetArray();
	//global $SHOWTEXT; if($SHOWTEXT)print $sql."<BR>";
	$rs_a[0]['��ʵ����'] = '��ʵ����';
	$�ܴ� = returnCurWeekIndex($�ڼ��յ���_������ʱ��);
	$��˫�� = $�ܴ�%2;
	if($��˫��==0) $��˫�� = 2;
	for($i=0;$i<sizeof($rs_a);$i++)						{
		$��ʵ���� = $Ĭ�Ͻ�ʦ����;
		//print $��ʵ����;
		//������ԭ������
		//$sql = "delete from edu_teacherkaoqinmingxi where �������� = '$�ڼ��յ���_������ʱ��' and ��ʦ����='$��ʵ����'";
		//$db->Execute($sql);
		$ReturnTeacherSchedule = ReturnTeacherSchedule($CurXueQi,$��ʦ�û���,$��ʵ����,$�ܴ�);
		//print_R($ReturnTeacherSchedule);exit;
		//print "<BR>��ǰ��ʦ�α�������Ϣ<BR>";
		//for($ii=1;$ii<=$DayIndexMonth;$ii++)			{
			//����Ŀ���Ͽ�ʱ�����ܼ�?
			$TargetWeekDay = date('w',mktime(1,1,1,$Month,$Day,$Year));
			//�õ���ǰ���ǵ��ܻ���˫�� ����Ϊ:ԭ�Ͽ�ʱ�� ��˫�ܽ��ҲΪԭ�Ͽ�ʱ��ĵ�˫��ֵ
			$��˫�� = returnCurWeekIndex($�ڼ��յ���_ԭ�Ͽ�ʱ��);$��˫�� = $��˫��%2;if($��˫��==0) $��˫�� = 2;
			//�õ�������ĳһ��Ŀγ��б�
			//$TargetWeekDay = 1;
			$WeekDaySchedule = array();
			$WeekDaySchedule = $ReturnTeacherSchedule[$TargetWeekDay];
			//print_R($TargetWeekDay);print_R($WeekDaySchedule);exit;
			global $SHOWTEXT; if($SHOWTEXT)print "<BR>����:$TargetWeekDay [�ڼ���]����α�������Ϣ $�ڼ��յ���_������ʱ�� $�ڼ��յ���_ԭ�Ͽ�ʱ�� ��ʡ����ʾ<BR>";
			//global $SHOWTEXT; if($SHOWTEXT)print_R($WeekDaySchedule);
			global $SHOWTEXT; if($SHOWTEXT)print "<BR>����ʱ��:$�ڼ��յ���_������ʱ�� �Ͽ�����:$�ڼ��յ���_ԭ�Ͽ�ʱ�� ";
			//����һ��Ľڴ���Ϣ
			$JieCiArray = array();
			$JieCiArray = @array_keys($WeekDaySchedule);
			//sort($JieCiArray);
			//if($WeekDaySchedule!="")	{print_R($JieCiArray);print "<BR>";}
			for($iii=0;$iii<sizeof($JieCiArray);$iii++)		{
				$�ڴ� = TRIM($JieCiArray[$iii]);
				$���� = TRIM($WeekDaySchedule[$�ڴ�][$��˫��]['����']);
				$�γ� = TRIM($WeekDaySchedule[$�ڴ�][$��˫��]['�γ�']);
				$�༶ = TRIM($WeekDaySchedule[$�ڴ�][$��˫��]['�༶']);
				$Element = array();
				//$Element['���'] = '';
				$Element['��ʦ����'] = TRIM($��ʵ����);
				$Element['��ʦ�û���'] = TRIM($��ʦ�û���);
				$Element['��������'] = TRIM($�ڼ��յ���_������ʱ��);
				$Element['����'] = TRIM($����);
				$Element['�γ�'] = TRIM($�γ�);
				$Element['�༶'] = TRIM($�༶);
				$Element['����'] = TRIM($TargetWeekDay);
				$Element['�ڴ�'] = TRIM($�ڴ�);
				$Element['�ܴ�'] = returnCurWeekIndex($�ڼ��յ���_ԭ�Ͽ�ʱ��);
				$Element['ѧ��'] = TRIM($CurXueQi);
				$Element['Ӧ����дʱ��'] = TRIM($�ڼ��յ���_������ʱ��);

				$��������Array = explode('-',$�ڼ��յ���_������ʱ��);
				$��ǰ������ = date("w",mktime(1,1,1,$��������Array[1],$��������Array[2],$��������Array[0]));
				$X = 7-$��ǰ������;
				$Element['�����дʱ��'] = date("Y-m-d",mktime(1,1,1,$��������Array[1],$��������Array[2]+$X,$��������Array[0]));

				$�������� = returnJieCiName($�ڴ�);
				$��Чʱ�� = returnJieCiTime($��������);
				$��Чʱ��Array = explode('-',$��Чʱ��);
				$��Чʱ��0Array = explode(':',$��Чʱ��Array[0]);
				$��Чʱ��1Array = explode(':',$��Чʱ��Array[1]);
				global $SYSTEM_MERGE_CLASSTABLE;
				if($�ڴ�Array[1]!=""&&$SYSTEM_MERGE_CLASSTABLE = "1")		{
					$��������1 = returnJieCiName($�ڴ�Array[1]);
					$��Чʱ��1 = returnJieCiTime($��������1);
					$��Чʱ��1Array = explode('-',$��Чʱ��1);
					$��Чʱ��1Array = explode(':',$��Чʱ��1Array[1]);
				}
				//�жϸÿ��Ƿ�Ϊ��������
				$�ڶ��ڴ� = $�ڴ�+1;
				$������ = $�ڶ��ڴ�%2;
				global $SYSTEM_MERGE_CLASSTABLE;
				if($WeekDaySchedule[$�ڶ��ڴ�][$��˫��]['�γ�']==$WeekDaySchedule[$�ڴ�][$��˫��]['�γ�']
					&&$WeekDaySchedule[$�ڶ��ڴ�][$��˫��]['��ʦ']==$WeekDaySchedule[$�ڴ�][$��˫��]['��ʦ']
					&&$WeekDaySchedule[$�ڶ��ڴ�][$��˫��]['�༶']==$WeekDaySchedule[$�ڴ�][$��˫��]['�༶']
					&&($������==0)
					&&$SYSTEM_MERGE_CLASSTABLE=="1"
					)				{
					//SYSTEM_MERGE_CLASSTABLEΪ1ʱ��ʾϵͳ���õ���ǿ�ƺϲ��Ĳ���,��֧�ֲ�ͬ�Ŀγ̽��в��
					$�������� = returnJieCiName($�ڶ��ڴ�);
					$��Чʱ��22 = returnJieCiTime($��������);
					$��Чʱ��22Array = explode('-',$��Чʱ��22);
					//���¶�����Чʱ��1Array����
					$��Чʱ��1Array = explode(':',$��Чʱ��22Array[1]);
					//�����ڶ��ڴμ�¼
					$Element['�ڴ�'] = $�ڴ�."-".$�ڶ��ڴ�;
					$iii ++;
					//print_R($��Чʱ��22Array);print "<BR>";//exit;
				}
				//print_R($WeekDaySchedule);exit;


				$�Ͽ�ˢ��BGN = date("H:i",@mktime($��Чʱ��0Array[0],$��Чʱ��0Array[1]-$KaoqinTimeBegin1,30,12,12,2008));
				$�Ͽ�ˢ��END = date("H:i",@mktime($��Чʱ��0Array[0],$��Чʱ��0Array[1]+$KaoqinTimeBegin2,30,12,12,2008));
				$�¿�ˢ��BGN = date("H:i",@mktime($��Чʱ��1Array[0],$��Чʱ��1Array[1]-$KaoqinTimeEnd1,30,12,12,2008));
				$�¿�ˢ��END = date("H:i",@mktime($��Чʱ��1Array[0],$��Чʱ��1Array[1]+$KaoqinTimeEnd2,30,12,12,2008));
				$Element['�Ͽ�ʵ��ˢ��'] = '';
				$Element['�Ͽο���״̬'] = '';
				$Element['�¿�ʵ��ˢ��'] = '';
				$Element['�¿ο���״̬'] = '';

				$Element['�Ͽ�ˢ��BGN'] = $�Ͽ�ˢ��BGN;
				$Element['�Ͽ�ˢ��END'] = $�Ͽ�ˢ��END;
				$Element['�¿�ˢ��BGN'] = $�¿�ˢ��BGN;
				$Element['�¿�ˢ��END'] = $�¿�ˢ��END;

				//print_R($Element);exit;
				//�༶ʵϰ�ܲ��ֵ���,����ð༶�ڵ�ǰ����ʵϰ�����ܴ�,��ô��ʦ�����򲻽��г�ʼ��
				$Banji_ShiXi_JiaoXueJinCheng = Banji_ShiXi_JiaoXueJinCheng($�༶,$Element['�ܴ�'],$CurXueQi,$�ڼ��յ���_������ʱ��);
				//��ʦ���ι��� ���������ʱ��ʾ,��ʦ������ϢҪ��������
				$Teacher_DaiKe_Infor = Teacher_DaiKe_Infor($��ʵ����,$��ʦ�û���,$�ڼ��յ���_������ʱ��,$Element['�ڴ�'],$�γ�,$CurXueQi);
				//��ʦͣ�ι��� ���������ʱ��ʾ,��ʦͣ��,���ܽ����½�����
				$Teacher_TingKe_Infor = Teacher_TingKe_Infor($��ʵ����,$��ʦ�û���,$�ڼ��յ���_������ʱ��,$Element['�ڴ�'],$�γ�,$CurXueQi);
				//��ʦ���ι��� ���������ʱ��ʾ,��ʦ����,���˱�ӿγ̱�����,һ���������,�����Ͽ�ʱ�䲻����ָ���ʱ���ظ�����
				//$Teacher_FuKe_Infor = Teacher_FuKe_Infor($��ʵ����,$�ڼ��յ���_������ʱ��,$Element['�ڴ�'],$�γ�,$CurXueQi);
				if($Teacher_DaiKe_Infor!="")		{
					$Element['��ʦ�û���']	= $Teacher_DaiKe_Infor;
					$Element['��ʦ����']	= returntablefield('user',"USER_ID",$Teacher_DaiKe_Infor,"USER_NAME");
				}
				//��ʦ���ι��� ���Ϊ��ʱ��ʾ���Բ����Ӧ����
				$Teacher_TiaoKe_Infor = Teacher_TiaoKe_Infor($��ʵ����,$��ʦ�û���,$�ڼ��յ���_������ʱ��,$Element['�ڴ�'],$�γ�,$CurXueQi);
				//��ʦ�໥���ι��� ���Ϊ��ʱ��ʾ���Բ����Ӧ����
				$Teacher_TiaoKeXiangHu_Infor = Teacher_TiaoKeXiangHu_Infor($��ʵ����,$��ʦ�û���,$�ڼ��յ���_������ʱ��,$Element['�ڴ�'],$�γ�,$CurXueQi);
				global $SHOWTEXT; if($SHOWTEXT&&sizeof($rs_a)>0)print_R($ShowData);
				global $SHOWTEXT; if($SHOWTEXT&&sizeof($rs_a)>0)print "<BR>�γ�:$�γ� �༶:$�༶ ".$ShowData[$�ڼ��յ���_������ʱ��]."-".$ShowData[$�ڼ��յ���_������ʱ��]."-".$TiaoKeJieJiaRiExec['����'][$�ڼ��յ���_������ʱ��]."-".$Banji_ShiXi_JiaoXueJinCheng."-".$Teacher_TiaoKe_Infor."-".$Teacher_TiaoKeXiangHu_Infor."<BR>";
				//��ʾ��ע��Ϣ
				if($Teacher_TiaoKe_Infor!=''&&$SHOWTEXT==1)		{
					print "<BR><font color=green>::::::��ע���β��ܿ�: $Teacher_TiaoKe_Infor </font><BR>";
				}
				if($Teacher_TingKe_Infor!=''&&$SHOWTEXT==1)	{
					print "<BR><font color=green>::::::��עͣ�β��ܿ�: $Teacher_TingKe_Infor </font><BR>";
				}
				if($Teacher_TiaoKeXiangHu_Infor!=''&&$SHOWTEXT==1)	{
					print "<BR><font color=green>::::::��ע�໥���β��ܿ�: $Teacher_TiaoKeXiangHu_Infor </font><BR>";
				}
				if($TiaoKeJieJiaRiExec['����'][$�ڼ��յ���_������ʱ��]!=''&&$SHOWTEXT==1)	{
					print "<BR><font color=green>::::::���� $�ڼ��յ���_������ʱ��: {$TiaoKeJieJiaRiExec['����'][$�ڼ��յ���_������ʱ��]} </font><BR>";
				}
				if($ShowData[$�ڼ��յ���_������ʱ��]!=''&&$SHOWTEXT==1)	{
					print "<BR><font color=green>::::::�ڼ��յ���_������ʱ��: {$ShowData[$�ڼ��յ���_������ʱ��]} </font><BR>";
				}
				if($�γ�==''&&$SHOWTEXT==1)	{
					print "<BR><font color=green>::::::�γ�Ϊ��: $Teacher_TiaoKeXiangHu_Infor </font><BR>";
				}
				if($�༶==''&&$SHOWTEXT==1)	{
					print "<BR><font color=green>::::::�༶Ϊ��: $Teacher_TiaoKeXiangHu_Infor </font><BR>";
				}

				if($�γ�!=""&&
					$�༶!=""&&
					$ShowData[$�ڼ��յ���_������ʱ��]==""&&
					$TiaoKeJieJiaRiExec['����'][$�ڼ��յ���_������ʱ��]==""&&
					$Banji_ShiXi_JiaoXueJinCheng==""&&
					$Teacher_TiaoKe_Infor==''&&
					$Teacher_TingKe_Infor==''&&
					$Teacher_TiaoKeXiangHu_Infor==''
					)			{
					$ElementValue = array_values($Element);
					$sqlValueText = "'".join("','",$ElementValue)."'";
					$ElementName = array_keys($Element);
					$sqlNameText = "`".join("`,`",$ElementName)."`";
					//�жϼ�¼�Ƿ����,��������򲻽��в������
					$sql = "select COUNT(*) AS NUM from edu_teacherkaoqinmingxi where ��ʦ���� ='$��ʵ����' and ��ʦ�û��� ='$��ʦ�û���' and ��������='$�ڼ��յ���_������ʱ��' and �ڴ�='".$Element['�ڴ�']."' and �γ�='$�γ�' and �༶='$�༶' ";
					$rs = $db->Execute($sql);
					global $SHOWTEXT; if($SHOWTEXT)print "<BR><font color=green>$sql </font><BR>";
					$NUM = $rs->fields['NUM'];
					if($NUM==0)		{
						$sql = "insert into edu_teacherkaoqinmingxi($sqlNameText) values($sqlValueText)";
						$db->Execute($sql);
					}
					else	{
						$sql = "�����Ѿ����� ".$sql;
					}
					global $SHOWTEXT; if($SHOWTEXT)print "<BR><font color=red>-----------$sql </font><BR>";
					//print_R($Element['�ڴ�']);print "��ʦ:".$��ʵ����.",�༶:".$�༶.",�γ�:".$�γ�.",����:".$TargetWeekDay.",�ڴ�:$�ڴ�<BR>";
				}
				//if($WeekDaySchedule!=""&&$SHOWTEXT=="1")	{print_R($WeekDaySchedule);}
			}
			//if($WeekDaySchedule!="")	{exit;}

			//print $TargetWeekDay."<BR>";
		//}//exit;
	}//end for
	//print_infor();
	//EDU_Indextopage('?',$nums='0');

	//��ʼ��ʱ��û����д�Ľ�ѧ�ռ�,���Ϊ������д
	$�����дʱ��	=	date("Y-m-d",mktime(1,1,1,date('m'),date('d')+5,date('Y')));
	$��ǰ����		=	date("Y-m-d",mktime(1,1,1,date('m'),date('d'),date('Y')));
	//$sql = "update edu_teacherkaoqinmingxi set �����дʱ�� ='$�����дʱ��' where ��ʦ����='$Ĭ�Ͻ�ʦ����' and ��ʦ�û���='$��ʦ�û���' and �ڿ�����='' and ѧ��='$CurXueQi' and �����дʱ��<='$��ǰ����'";
	//$db->Execute($sql);
	//if($SHOWTEXT) print $sql;
}

//�����ֶ��еĿո�
//update edu_teacherkaoqinmingxi set �༶=TRIM(�༶)




//#######################################################################################
function returnJieCiTime($��������)  {
	return returntablefield("edu_timesetting","��������",$��������,"ʱ���");
}

function returnJieCiName($JieCi)   {
	switch($JieCi)		{
		case '1':
			$Text = "��һ�ڿ�";
			break;
		case '2':
			$Text = "�ڶ��ڿ�";
			break;
		case '3':
			$Text = "�����ڿ�";
			break;
		case '4':
			$Text = "���Ľڿ�";
			break;
		case '5':
			$Text = "����ڿ�";
			break;
		case '6':
			$Text = "�����ڿ�";
			break;
		case '7':
			$Text = "���߽ڿ�";
			break;
		case '8':
			$Text = "�ڰ˽ڿ�";
			break;
		case '9':
			$Text = "�ھŽڿ�";
			break;
		case '10':
			$Text = "��ʮ�ڿ�";
			break;
		case '11':
			$Text = "��ʮһ�ڿ�";
			break;
		case '12':
			$Text = "��ʮ���ڿ�";
			break;

	}
	return $Text;
}


function DealTimeJieCiShangKe($��ʦ����,$��ʦ�û���,$��������,$ʱ��)		{
	global $db,$InsertData;
	global $KaoqinTimeBegin1,$KaoqinTimeBegin2,$KaoqinTimeEnd1,$KaoqinTimeEnd2,$KuangGongShiJian;
	//print $KuangGongShiJian;exit;
	//����ٵ���
	$ʱ��Array = explode(':',$ʱ��);
	$�ٵ�ʱ�� = date("H:i",mktime($ʱ��Array[0],$ʱ��Array[1]-$KuangGongShiJian,1,12,12,2009));
	$sql = "select * from edu_teacherkaoqinmingxi where ��ʦ�û���='$��ʦ�û���' and ��������='$��������' and �Ͽ�ˢ��BGN<='$�ٵ�ʱ��' and �Ͽ�ˢ��END>='$�ٵ�ʱ��'";
	$rs2 = $db->Execute($sql);
	$rs2_a = $rs2->GetArray();
	//print_R($rs2_a);
	for($iii=0;$iii<sizeof($rs2_a);$iii++)						{
		$��� = $rs2_a[$iii]['���'];
		$sql = "update edu_teacherkaoqinmingxi set �Ͽ�ʵ��ˢ�� = '$ʱ��' ,�Ͽο���״̬='�Ͽγٵ�' where ���='$���'";
		$db->Execute($sql);
		$InsertData++;
		$returnText .= "$��ʦ���� �Ͽγٵ� $�������� $ʱ��<BR>";
		global $SHOWTEXT; if($SHOWTEXT)print $sql."<BR>";
	}

	//����������
	$sql = "select * from edu_teacherkaoqinmingxi where ��ʦ�û���='$��ʦ�û���' and ��������='$��������' and �Ͽ�ˢ��BGN<='$ʱ��' and �Ͽ�ˢ��END>='$ʱ��'";
	$rs2 = $db->Execute($sql);
	$rs2_a = $rs2->GetArray();
	//print_R($rs2_a);
	for($iii=0;$iii<sizeof($rs2_a);$iii++)						{
		$��� = $rs2_a[$iii]['���'];
		$sql = "update edu_teacherkaoqinmingxi set �Ͽ�ʵ��ˢ�� = '$ʱ��' ,�Ͽο���״̬='����ˢ��' where ���='$���'";
		$db->Execute($sql);
		$InsertData++;
		$returnText .= "$��ʦ���� �Ͽ����� $�������� $ʱ��<BR>";
		global $SHOWTEXT; if($SHOWTEXT)print "�����������Ͽ�:".$sql."<BR>";
	}
	//###########################################################################
	//ͬ����ʦ���ο������ݿ�ʼ���ϿΣ�
	$sql = "select * from edu_tingke where ���ν�ʦ����='$��ʦ����' and ��������='$��������' and �Ͽ�ˢ��BGN<='$�ٵ�ʱ��' and �Ͽ�ˢ��END>='$�ٵ�ʱ��'";
	$rs2 = $db->Execute($sql);
	$rs2_a = $rs2->GetArray();
	global $SHOWTEXT; if($SHOWTEXT)print "ͬ����ʦ���ο������ݿ�ʼ���ϿΣ�:".$sql."<BR>";
	//print_R($rs2_a);
	for($iii=0;$iii<sizeof($rs2_a);$iii++)						{
		$��� = $rs2_a[$iii]['���'];
		$lll=date("Y-m-d",strtotime($rs2_a[$iii]['��������'])+3*24*3600);
		$sql = "update edu_tingke set �Ͽδ�ʱ�� = '$ʱ��' ,�Ͽο���״̬='�Ͽγٵ�',�����дʱ�� = '$lll' where ���='$���'";
		$db->Execute($sql);
		$InsertData++;
		//$returnText .= "$��ʦ���� �Ͽγٵ� $�������� $ʱ��<BR>";
		global $SHOWTEXT; if($SHOWTEXT)print "�Ͽγٵ�:".$sql."<BR>";
	}
	$sql = "select * from edu_tingke where ���ν�ʦ����='$��ʦ����' and ��������='$��������' and �Ͽ�ˢ��BGN<='$ʱ��' and �Ͽ�ˢ��END>='$ʱ��'";
	$rs2 = $db->Execute($sql);
	$rs2_a = $rs2->GetArray();
	global $SHOWTEXT; if($SHOWTEXT)print "�Ͽγٵ�:".$sql."<BR>";
	//print_R($rs2_a);
	for($iii=0;$iii<sizeof($rs2_a);$iii++)						{
		$��� = $rs2_a[$iii]['���'];
		$lll=date("Y-m-d",strtotime($rs2_a[$iii]['��������'])+3*24*3600);
		$sql = "update edu_tingke set �Ͽδ�ʱ�� = '$ʱ��' ,�Ͽο���״̬='����ˢ��',�����дʱ�� = '$lll' where ���='$���'";
		$db->Execute($sql);
		$InsertData++;
		//$returnText .= "$��ʦ���� �Ͽ����� $�������� $ʱ��<BR>";
		global $SHOWTEXT; if($SHOWTEXT)print "����ˢ���Ͽ�:".$sql."<BR>";
	}
	//���嵱�����ο������,���û��ֵ,��ֱ�Ӷ���Ϊȱ��
	$dateTEMP = date("Y-m-d");
	$sql = "update edu_tingke set �Ͽδ�ʱ��='�Ͽ�ȱ��',�Ͽο���״̬='�Ͽ�ȱ��' where ��������='$��������' and (�Ͽδ�ʱ��='' or �Ͽδ�ʱ��='�Ͽ�ȱ��')";
	$db->Execute($sql);
	//ͬ����ʦ���ο������ݽ������ϿΣ�
	//###########################################################################
	return $returnText;
}

function DealTimeJieCiXiaKe($��ʦ����,$��ʦ�û���,$��������,$ʱ��)		{
	global $db,$InsertData;
	$sql = "select * from edu_teacherkaoqinmingxi where ��ʦ�û���='$��ʦ�û���' and ��������='$��������' and �¿�ˢ��BGN<='$ʱ��' and �¿�ˢ��END>='$ʱ��'";
	$rs2 = $db->Execute($sql);
	$rs2_a = $rs2->GetArray();
	$returnText = "";
	for($iii=0;$iii<sizeof($rs2_a);$iii++)						{
		$��� = $rs2_a[$iii]['���'];
		$sql = "update edu_teacherkaoqinmingxi set �¿�ʵ��ˢ�� = '$ʱ��' ,�¿ο���״̬='����ˢ��' where ���='$���'";
		$db->Execute($sql);
		$InsertData++;
		$returnText .= "$��ʦ���� �¿����� $�������� $ʱ��<BR>";
		global $SHOWTEXT; if($SHOWTEXT)print "�����������¿�:".$sql."<BR>";
	}

	//###########################################################################
	//ͬ����ʦ���ο������ݿ�ʼ���¿Σ�
	$sql = "select * from edu_tingke where ���ν�ʦ����='$��ʦ����' and ��������='$��������' and �¿�ˢ��BGN<='$ʱ��' and �¿�ˢ��END>='$ʱ��'";
	$rs2 = $db->Execute($sql);
	$rs2_a = $rs2->GetArray();
	$returnText = "";
	for($iii=0;$iii<sizeof($rs2_a);$iii++)						{
		$��� = $rs2_a[$iii]['���'];
		$lll=date("Y-m-d",strtotime($rs2_a[$iii]['��������'])+3*24*3600);
		$sql = "update edu_tingke set �¿δ�ʱ�� = '$ʱ��' ,�¿ο���״̬='����ˢ��',�����дʱ�� = '$lll' where ���='$���'";
		$db->Execute($sql);
		$InsertData++;
		//$returnText .= "$��ʦ���� �¿����� $�������� $ʱ��<BR>";
		global $SHOWTEXT; if($SHOWTEXT)print "�����������¿�:".$sql."<BR>";
	}

	$dateTEMP = date("Y-m-d");
	$sql = "update edu_tingke set �¿δ�ʱ��='�¿�ȱ��',�¿ο���״̬='�¿�ȱ��' where ��������<'$dateTEMP' and (�¿δ�ʱ��='' or �¿δ�ʱ��='�¿�ȱ��')";
	$db->Execute($sql);
	//ͬ����ʦ���ο������ݽ������¿Σ�
	//###########################################################################
	return $returnText;
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