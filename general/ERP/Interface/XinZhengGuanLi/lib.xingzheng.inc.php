<?php

$���ذ���ϰ༰�°��ʱ�� = ���ذ���ϰ༰�°��ʱ��();
//print_R($���ذ���ϰ༰�°��ʱ��);
//exit;

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

function useridfilter($��Ա����)			{
	global $db;
	$USER_NAME_TEXT = '';
	$��Ա����Array = explode(',',$��Ա����);
	for($i=0;$i<sizeof($��Ա����Array);$i++)		{
		if($��Ա����Array[$i]!="")	{
			$USER_INFOR	= returntablefield("user","USER_ID",$��Ա����Array[$i],"USER_ID,DEPT_ID");
			$USER_ID = $USER_INFOR['USER_ID'];
			$DEPT_ID = $USER_INFOR['DEPT_ID'];
			if($USER_ID!=""&&$DEPT_ID>0)	$USER_NAME_TEXT	.= $USER_ID.",";
		}

	}
	return $USER_NAME_TEXT;
}


function ����ת���������USER_NAMEΪUSER_ID()		{
	global $db;
	$sql = "select ���,��Ա���� from edu_xingzheng_group";
	$rs = $db->Execute($sql);
	$rs_a = $rs->GetArray();
	for($i=0;$i<sizeof($rs_a);$i++)				{
		$��� = $rs_a[$i]['���'];
		$��Ա���� = $rs_a[$i]['��Ա����'];
		$��Ա���ƽ�� = usernametoid($��Ա����);
		$sql = "update edu_xingzheng_group set ��Ա����='$��Ա���ƽ��' where ���='$���'";
		$db->Execute($sql);
		//print $sql."<BR>";
	}//exit;
}

function ����ת���Ű�����USER_NAMEΪUSER_ID()		{
	global $db;
	$sql = "select ���,�Ű���Ա from edu_xingzheng_paiban";
	$rs = $db->Execute($sql);
	$rs_a = $rs->GetArray();
	for($i=0;$i<sizeof($rs_a);$i++)				{
		$��� = $rs_a[$i]['���'];
		$�Ű���Ա = $rs_a[$i]['�Ű���Ա'];
		$USER_NAME = returntablefield('user',"USER_ID",$�Ű���Ա,"USER_NAME");
		if($USER_NAME=="")		{
			$�Ű���Ա��� = usernametoid($�Ű���Ա);
			$sql = "update edu_xingzheng_paiban set �Ű���Ա='$�Ű���Ա���' where ���='$���'";
			$db->Execute($sql);
			//print $sql."<BR>";
		}
	}//exit;
}




function �������ӽ�ʦ�û��������Ŀ��ֶ���ϢX()		{
	/*
	�������ӽ�ʦ�û��������Ŀ��ֶ���Ϣ_�Ӻ���X('edu_xingzheng_tiaoban','��Ա','��Ա�û���');
	�������ӽ�ʦ�û��������Ŀ��ֶ���Ϣ_�Ӻ���X('edu_xingzheng_qingjia','��Ա','��Ա�û���');
	�������ӽ�ʦ�û��������Ŀ��ֶ���Ϣ_�Ӻ���X('edu_xingzheng_kaoqinmingxi','��Ա','��Ա�û���');
	�������ӽ�ʦ�û��������Ŀ��ֶ���Ϣ_�Ӻ���X('edu_xingzheng_tiaobanxianghu','ԭ��Ա','ԭ��Ա�û���');
	�������ӽ�ʦ�û��������Ŀ��ֶ���Ϣ_�Ӻ���X('edu_xingzheng_tiaobanxianghu','����Ա','����Ա�û���');
	�������ӽ�ʦ�û��������Ŀ��ֶ���Ϣ_�Ӻ���X('edu_xingzheng_kaoqinbudeng','��Ա','��Ա�û���');
	�������ӽ�ʦ�û��������Ŀ��ֶ���Ϣ_�Ӻ���X('edu_xingzheng_jiabanbuxiu','��Ա','��Ա�û���');
	�������ӽ�ʦ�û��������Ŀ��ֶ���Ϣ_�Ӻ���X('edu_xingzheng_tiaoxiububan','��Ա','��Ա�û���');
	*/
}
function �������ӽ�ʦ�û��������Ŀ��ֶ���Ϣ_�Ӻ���X($tablename,$��ʦ='��ʦ',$��ʦ�û���='��ʦ�û���')		{
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
		//$db->Execute($sql);
		print $sql."<BR>";
	}
}

//���ڼ��ս��е���,������Ա��Ҫ
function ִ�нڼ��յ��ຯ��()		{
	global $db;
	$sql = "select * from edu_schedulejiejiari"; // where ִ��״̬='0'
	$rs = $db->Execute($sql);
	$rs_a = $rs->GetArray();
	$NewArray = array();
	for($i=0;$i<sizeof($rs_a);$i++)				{
		$ԭ�ϰ�ʱ�� = $rs_a[$i]['ԭ�ϰ�ʱ��'];
		$�������ϰ�ʱ�� = $rs_a[$i]['�������ϰ�ʱ��'];
		$ִ��״̬ = $rs_a[$i]['ִ��״̬'];
		$NewArray['����'][$�������ϰ�ʱ��] = $ԭ�ϰ�ʱ��;
		$NewArray['����'][$ԭ�ϰ�ʱ��] = $�������ϰ�ʱ��;
	}
	return $NewArray;
}

//��ʱ����ȶԵ���ƻ����е���-��Ҫ��������-2010-2-27�ݲ�������
function ����ƻ�ִ�к���()		{

}




//����function returnWeekDayNumber() ������lib.xiaoli.inc.php�ļ�����
//����function XiaoLiArray() ������lib.xiaoli.inc.php�ļ�����


//ִ�е�ǰ���Ƿ�Ϊ�ڼ���,����ǽڼ���,��ô�����������Ա�������ݱ��е������п�������
$datetime = date("Y-m-d");
$sql = "select * from edu_schoolcalendar where ��ʼʱ��<='$datetime' and ����ʱ��>='$datetime' and �ڼ���!='��ѧ'";
global $SHOWTEXT; if($SHOWTEXT)		print "<BR>".$sql."<HR>";
$rs = $db->Execute($sql);
$rs_a = $rs->GetArray();
$�ڼ��� = $rs_a[0]['�ڼ���'];
if($�ڼ���!="")		{
	$sql = "delete from edu_xingzheng_kaoqinmingxi where ����='$datetime'";
	global $SHOWTEXT; if($SHOWTEXT)print "<BR>".$sql."<HR>";
	$db->Execute($sql);
}




function ���ذ���ϰ༰�°��ʱ��()  {
	global $db;
	$sql = "select * from edu_xingzheng_banci";
	$rs = $db->Execute($sql);
	$rs_a = $rs->GetArray();
	//��� �Զ���� ������� ������� ����ʱ��� ����ʱ��� �ϰ���ǰ��ʱ��  �°���ǰ��ʱ��  �ϰ��Ӻ��ʱ��  �°��Ӻ��ʱ��  ������ʱ��  ��ע ��ע ������ ������ID ����
	for($i=0;$i<sizeof($rs_a);$i++)		{
		$������� = $rs_a[$i]['�������'];
		$����ʱ��� = $rs_a[$i]['����ʱ���'];
		$�ϰ�ʱ���Ƿ����� = $rs_a[$i]['�ϰ�ʱ���Ƿ�����'];
		$�°�ʱ���Ƿ����� = $rs_a[$i]['�°�ʱ���Ƿ�����'];
		$�ϰ���ǰ��ʱ�� = $rs_a[$i]['�ϰ���ǰ��ʱ��'];
		$�ϰ��Ӻ��ʱ�� = $rs_a[$i]['�ϰ��Ӻ��ʱ��'];
		$�°���ǰ��ʱ�� = $rs_a[$i]['�°���ǰ��ʱ��'];
		$�°��Ӻ��ʱ�� = $rs_a[$i]['�°��Ӻ��ʱ��'];
		$������ʱ�� = $rs_a[$i]['������ʱ��'];

		$�ٵ�ʱ�� = $rs_a[$i]['�ٵ�ʱ��'];
		$����ʱ�� = $rs_a[$i]['����ʱ��'];

		$����ʱ���Array = explode('-',$����ʱ���);
		$�ϰ�ʱ�� = $����ʱ���Array[0];
		$�°�ʱ�� = $����ʱ���Array[1];
		$��Чʱ��0Array = explode(':',$�ϰ�ʱ��);
		$��Чʱ��1Array = explode(':',$�°�ʱ��);
		$�ϰ�ˢ��BGN = date("H:i",@mktime($��Чʱ��0Array[0],$��Чʱ��0Array[1]-$�ϰ���ǰ��ʱ��,30,12,12,2008));
		$�ϰ�ˢ��END = date("H:i",@mktime($��Чʱ��0Array[0],$��Чʱ��0Array[1]+$�ϰ��Ӻ��ʱ��,30,12,12,2008));

		$�°�ˢ��BGN = date("H:i",@mktime($��Чʱ��1Array[0],$��Чʱ��1Array[1]-$�°���ǰ��ʱ��,30,12,12,2008));
		$�°�ˢ��END = date("H:i",@mktime($��Чʱ��1Array[0],$��Чʱ��1Array[1]+$�°��Ӻ��ʱ��,30,12,12,2008));

		$�ٵ�ʱ�� = date("H:i",@mktime($��Чʱ��0Array[0],$��Чʱ��0Array[1]+$�ϰ��Ӻ��ʱ��+$�ٵ�ʱ��,30,12,12,2008));
		$����ʱ�� = date("H:i",@mktime($��Чʱ��1Array[0],$��Чʱ��1Array[1]-$�°���ǰ��ʱ��-$����ʱ��,30,12,12,2008));
		//$��������ʱ�� = date("H:i",@mktime($��Чʱ��0Array[0],$��Чʱ��0Array[1]+$�ϰ��Ӻ��ʱ��+$������ʱ��,30,12,12,2008));

		$NewArray[$�������]['�ϰ�ˢ��BGN'] = $�ϰ�ˢ��BGN;
		$NewArray[$�������]['�ϰ�ˢ��END'] = $�ϰ�ˢ��END;
		$NewArray[$�������]['�°�ˢ��BGN'] = $�°�ˢ��BGN;
		$NewArray[$�������]['�°�ˢ��END'] = $�°�ˢ��END;
		$NewArray[$�������]['����ʱ���']  = $����ʱ���;
		$NewArray[$�������]['�ϰ�ʱ���Ƿ�����']  = $�ϰ�ʱ���Ƿ�����;
		$NewArray[$�������]['�°�ʱ���Ƿ�����']  = $�°�ʱ���Ƿ�����;

		$NewArray[$�������]['�ٵ�ʱ��']  = $�ٵ�ʱ��;
		$NewArray[$�������]['����ʱ��']  = $����ʱ��;

		//$NewArray[$�������]['��������ʱ��'] = $��������ʱ��;

	}
	return $NewArray;
}

function ���ؿ��ڲ�����Ϣ($ѧ��,$��Ա,$��Ա�û���,$��������,$���='')			{
	global $db,$���ذ���ϰ༰�°��ʱ��;
	$sql = "select ������Ŀ from edu_xingzheng_kaoqinbudeng where ѧ��='$ѧ��' and ��Ա�û���='$��Ա�û���' and ʱ��='$��������' and ���='$���' and ���״̬='1'";
	$rs = $db->Execute($sql);
	$������Ŀ = $rs->fields['������Ŀ'];
	return $������Ŀ;
}

function ������������Ϣ($ѧ��,$��Ա,$��Ա�û���,$��������,$���='')			{
	global $db,$���ذ���ϰ༰�°��ʱ��;
	$sql = "select ��Ա from edu_xingzheng_qingjia where ѧ��='$ѧ��' and ��Ա�û���='$��Ա�û���' and ʱ��='$��������' and ���='$���' and ���״̬='1'";
	$rs = $db->Execute($sql);
	$��Ա = $rs->fields['��Ա'];
	if($��Ա!="") return "������";
	else	return "";
}

//ִ��ɾ��ĳ��ĳ�쿼����Ϣ
function ִ��ɾ��ĳ��ĳ�쿼����Ϣ($ѧ��,$��Ա,$��Ա�û���,$��������,$���='')		{
	global $db,$���ذ���ϰ༰�°��ʱ��;

	$sql = "delete from edu_xingzheng_kaoqinmingxi where ��Ա�û��� ='$��Ա�û���' and ����='$��������' and ѧ��='$ѧ��' and ��Ա�û���='$��Ա�û���'";
	$db->Execute($sql);
}
//ִ�в���ĳ��ĳ�쿼����Ϣ
function ִ�в���ĳ��ĳ�쿼����Ϣ($ѧ��,$��Ա,$��Ա�û���,$��������,$���='')		{
	global $db,$���ذ���ϰ༰�°��ʱ��;

	$sql = "select distinct ������� from edu_xingzheng_paiban
			where (�Ű���Ա like '%,$��Ա�û���,%' or �Ű���Ա like '$��Ա�û���,%') and ��������='$��������' and ѧ������='$ѧ��'";
	$rs = $db->Execute($sql);
	$rs_a = $rs->GetArray();
	global $SHOWTEXT; if($SHOWTEXT)print  $sql."<BR>";;
	//print_R($rs_a);

	if($���!="")	{
		//��ʾ��һ��ָ����ε������,Ҳ�п����ǵ������,���Բ������Ű���Ϣ�й���,����ǿ��ָ����Ϣ
		//����:���¸�RS_A������ֵ
		$rs_a = array();
		$rs_a[0]['�������'] = $���;
	}

	//print_R($ִ�нڼ��յ��ຯ��);
	$ִ�нڼ��յ��ຯ�� = ִ�нڼ��յ��ຯ��();
	$NewDatetime = $ִ�нڼ��յ��ຯ��['����'][$Datetime];
	//NewDatetime��ֵΪԭ�ϰ�ʱ��,����Ϊ��������ϰ�ʱ��
	//ԭ�ϰ�ʱ����ܴκ����ڱ�����,�����ϰ��ʱ���õ������
	if($NewDatetime=='')	{
		$NewDatetime = $��������;
	}
	else	{
		//�����жԻ�ֵ,��ִ��״̬���и���
		$sql = "update edu_schedulejiejiari set ִ��״̬='1' where �������ϰ�ʱ��='$��������'";
		$db->Execute($sql);
		global $SHOWTEXT; if($SHOWTEXT)print  $sql."<BR>";;
	}
	//if($ShowData[$��������]==""&&$ִ�нڼ��յ��ຯ��['����'][$��������]==""&&$ִ��������Ա���ຯ��==''&&$������Ա�໥����״̬=='')			{
	//}

	//�������õ��İ���б�,���й��˴���,�ڴ��Ѿ����뵽�������ݱ���
	for($i=0;$i<sizeof($rs_a);$i++)				{
		$������� = $rs_a[$i]['�������'];

		//print_R($Element);exit;
		//��Ա���ι��� ���Ϊ��ʱ��ʾ���Բ����Ӧ����
		//$����������Ա���� = ����������Ա����($��Ա,$��������,$�������,$ѧ��);
		//��Ա������� ���Ϊ��ʱ��ʾ���Բ����Ӧ����
		$ִ��������Ա���ຯ�� = ִ��������Ա���ຯ��($��Ա,$��Ա�û���,$��������,$�������,$ѧ��);
		//��Ա�໥������� ���Ϊ��ʱ��ʾ���Բ����Ӧ����
		$������Ա�໥����״̬ = ������Ա�໥����״̬($��Ա,$��Ա�û���,$��������,$�������,$ѧ��);
		$������Ա����״̬ = ������Ա����״̬($��Ա,$��Ա�û���,$��������,$�������,$ѧ��);
		global $SHOWTEXT; if($SHOWTEXT&&sizeof($rs_a)>0)print "<BR>���뿼�����ݲ���:".$ShowData[$��������]."-".$ִ�нڼ��յ��ຯ��['����'][$��������]."-".$ִ��������Ա���ຯ��."-".$������Ա�໥����״̬."<BR>";

		//�����µļ�¼�Ƿ����
		$sql = "select COUNT(*) AS NUM from edu_xingzheng_kaoqinmingxi where ѧ��='$ѧ��' and ��Ա�û���='$��Ա�û���' and ����='$��������' and ���='$�������'";
		$rs = $db->Execute($sql);
		$NUM = $rs->fields['NUM'];
		//�����ڼ�¼,ִ�в������
		if(	$NUM==0&&
			$ShowData[$��������]==""&&
			$ִ�нڼ��յ��ຯ��['����'][$��������]==""&&
			$������Ա�໥����״̬==''&&
			$������Ա����״̬==''
			)		{
			//$ִ��������Ա���ຯ��==''&&
			//���  ѧ��  ����  ��Ա  ����  �ܴ�  ����  ���  �ϰ�ʵ��ˢ��  �ϰ࿼��״̬  �°�ʵ��ˢ��  �°࿼��״̬  �ϰ�ˢ��BGN  �ϰ�ˢ��END  �°�ˢ��BGN  �°�ˢ��END  ����ʱ��
			$��������Array = explode('-',$��������);
			$���� = date('w',mktime(1,1,1,$��������Array[1],$��������Array[2],$��������Array[0]));
			$DEPT_ID = returntablefield("user","USER_ID",$��Ա�û���,"DEPT_ID");
			$���� = returntablefield("department","DEPT_ID",$DEPT_ID,"DEPT_NAME");
			$Element['ѧ��'] = $ѧ��;
			$Element['����'] = $����;
			$Element['��Ա'] = $��Ա;
			$Element['��Ա�û���'] = $��Ա�û���;
			//�е�����Ϣ,�����µ�ʱ��Ϊ׼���м���
			if($ִ��������Ա���ຯ��['���ϰ�ʱ��']!="")		{
				$�������� = $ִ��������Ա���ຯ��['���ϰ�ʱ��'];
				$��������Array = explode('-',$��������);
				$���� = date('w',mktime(1,1,1,$��������Array[1],$��������Array[2],$��������Array[0]));
				$Element['����'] = $��������;
				$Element['�ܴ�'] = returnCurWeekIndex($��������);
				$�������		 = $ִ��������Ա���ຯ��['�°��'];
			}
			else	{
				$Element['����'] = $��������;
				$Element['�ܴ�'] = returnCurWeekIndex($��������);

			}
			if($����==0) $����=7;
			$Element['����'] = $����;
			$Element['���'] = $�������;

			$���ؿ��ڲ�����Ϣ = ���ؿ��ڲ�����Ϣ($ѧ��,$��Ա,$��Ա�û���,$��������,$�������);
			$������������Ϣ = ������������Ϣ($ѧ��,$��Ա,$��Ա�û���,$��������,$�������);
			if($���ذ���ϰ༰�°��ʱ��[$�������]['�ϰ�ʱ���Ƿ�����']=="��")		{
				$Element['�ϰ�ʵ��ˢ��'] = '���ÿ���';
				$Element['�ϰ࿼��״̬'] = '���ÿ���';
			}
			else if($���ؿ��ڲ�����Ϣ=="�ϰ࿼�ڲ���")	{
				$Element['�ϰ�ʵ��ˢ��'] = '���ڲ���';
				$Element['�ϰ࿼��״̬'] = '���ڲ���';
			}
			else if($������������Ϣ=="������")	{
				$Element['�ϰ�ʵ��ˢ��'] = '������';
				$Element['�ϰ࿼��״̬'] = '������';
			}
			else	{
				$Element['�ϰ�ʵ��ˢ��'] = '';
				$Element['�ϰ࿼��״̬'] = '';
			}

			if($���ذ���ϰ༰�°��ʱ��[$�������]['�°�ʱ���Ƿ�����']=="��")		{
				$Element['�°�ʵ��ˢ��'] = '���ÿ���';
				$Element['�°࿼��״̬'] = '���ÿ���';
			}
			else if($���ؿ��ڲ�����Ϣ=="�°࿼�ڲ���")	{
				$Element['�°�ʵ��ˢ��'] = '���ڲ���';
				$Element['�°࿼��״̬'] = '���ڲ���';
			}
			else if($������������Ϣ=="������")	{
				$Element['�°�ʵ��ˢ��'] = '������';
				$Element['�°࿼��״̬'] = '������';
			}
			else	{
				$Element['�°�ʵ��ˢ��'] = '';
				$Element['�°࿼��״̬'] = '';
			}

			$Element['�ϰ�ˢ��BGN'] = $���ذ���ϰ༰�°��ʱ��[$�������]['�ϰ�ˢ��BGN'];
			$Element['�ϰ�ˢ��END'] = $���ذ���ϰ༰�°��ʱ��[$�������]['�ϰ�ˢ��END'];
			$Element['�°�ˢ��BGN'] = $���ذ���ϰ༰�°��ʱ��[$�������]['�°�ˢ��BGN'];
			$Element['�°�ˢ��END'] = $���ذ���ϰ༰�°��ʱ��[$�������]['�°�ˢ��END'];

			$Element['�ϰ�ٵ�ʱ��'] = $���ذ���ϰ༰�°��ʱ��[$�������]['�ٵ�ʱ��'];
			$Element['�°�����ʱ��'] = $���ذ���ϰ༰�°��ʱ��[$�������]['����ʱ��'];
			$Element['�ٵ�������']   = '';
			$Element['���˷�����']   = '';
			//$Element['��������ʱ��'] = $���ذ���ϰ༰�°��ʱ��[$�������]['��������ʱ��'];

			$Element['����ʱ��'] = date('Y-m-d H:i:s');

			$ElementValue = array_values($Element);
			$sqlValueText = "'".join("','",$ElementValue)."'";
			$ElementName = array_keys($Element);
			$sqlNameText = "`".join("`,`",$ElementName)."`";
			$sql = "insert into edu_xingzheng_kaoqinmingxi($sqlNameText) values($sqlValueText)";
			if($��Ա�û���!="")		{
				$db->Execute($sql);
				global $SHOWTEXT; if($SHOWTEXT)print "<BR><font color=red>$sql </font><BR>";
			}
		}
	}//end for
	return $NewArray;
	//print_R($rs_a);
}


//ͬ��ĳ��ĳ�쿼�ڻ����ݵ�������ϸ��
function ͬ��ĳ��ĳ�쿼�ڻ����ݵ�������ϸ��($��Ա����,$��Ա�û���,$��������)			{
	global $db;
	global $SHOWTEXT; if($SHOWTEXT)print "<BR>ͬ����Ա���쿼������====================================================<BR>";
	$sql = "select * from edu_teacherkaoqin where ��������='$��������' and ��ʦ����='$��Ա����' and ��ʦ�û���='$��Ա�û���'";
	global $SHOWTEXT; if($SHOWTEXT)print $sql."<BR>";
	$rs2 = $db->Execute($sql);
	$rs2_a = $rs2->GetArray();
	for($iii=0;$iii<sizeof($rs2_a);$iii++)						{
		$ˢ��ʱ�� = $rs2_a[$iii]['ˢ��ʱ��'];
		$��ʦ�û��� = $rs2_a[$iii]['��ʦ�û���'];
		//�ж��������û���,��������������ʹ��
		$����ĳ��ĳʱ�ϰ��°�ʱ������ = ����ĳ��ĳʱ�ϰ��°�ʱ������($��Ա����,$��Ա�û���,$��������,$ˢ��ʱ��);
		//$����ĳ��ĳʱ�ϰ��°�ʱ������ = ����ĳ��ĳʱ�ϰ��°�ʱ������($��Ա����,$��Ա�û���,$��������,$ˢ��ʱ��);
	}
	global $SHOWTEXT; if($SHOWTEXT)print "<BR>ͬ����Ա���쿼������====================================================";
	global $SHOWTEXT; if($SHOWTEXT&&sizeof($rs_a)>0)print_R($rs_a);;
}


/* 2010-2-27�պ������
function ����������Ա����($��Ա,$�ϰ�ʱ��,$���,$ѧ��)		{
	global $db;
	//���  ѧ��  �༶  ����  �γ�  ԭ��Ա  ����Ա  �ϰ�ʱ��  ���  ���״̬  ������ID��  �����  ���ʱ��
	$sql = "select ��� from edu_scheduledaike where ԭ��Ա='$��Ա' and �ϰ�ʱ��='$�ϰ�ʱ��' and ���='$���' and �γ�='$�γ�' and ���״̬='1'";
	$rs = $db->Execute($sql);
	$rs_a = $rs->GetArray();
	$��� = $rs_a[0]['���'];
	global $SHOWTEXT; if($SHOWTEXT)print "<BR><font color=green><B>$sql</B></font><BR>";
	if($���!="")		{
		$sql = "delete from edu_xingzheng_kaoqinmingxi where ѧ��='$ѧ��' and ��Ա='$��Ա' and �γ�='$�γ�' and ����='$�ϰ�ʱ��' and ���='$���'";
		$db->Execute($sql);
		global $SHOWTEXT; if($SHOWTEXT)print "��Ա���ι���<BR><font color=red><B>$sql</B></font><BR>";
		global $SHOWTEXT; if($SHOWTEXT&&sizeof($rs_a)>0)print_R($rs_a);;
	}
	return $���;
}
*/

//��Ա�������,������˷���:��ɾ���Ѿ����ڵ�����,Ȼ��õ��µ��ϰ�ʱ��Ͱ����Ϣ,���¸�ֵ�ϰ�ʱ��Ͱ��
function ִ��������Ա���ຯ��($��Ա,$��Ա�û���,$�ϰ�ʱ��,$���,$ѧ��)		{
	global $db,$���ذ���ϰ༰�°��ʱ��;
	//���  ѧ��  ����  ��Ա  ԭ�ϰ�ʱ��  ԭ���  ���ϰ�ʱ��  �°��  ���״̬  ������ID��  �����  ���ʱ��
	$sql = "select * from edu_xingzheng_tiaoban where ��Ա�û���='$��Ա�û���' and ԭ�ϰ�ʱ��='$�ϰ�ʱ��' and ԭ���='$���' and ���״̬='1'";
	$rs = $db->Execute($sql);
	$rs_a = $rs->GetArray();
	$��� = $rs_a[0]['���'];
	$��Ա = $rs_a[0]['��Ա'];
	$���ϰ�ʱ�� = $rs_a[0]['���ϰ�ʱ��'];
	$�°�� = $rs_a[0]['�°��'];
	$NewArray = array();
	//print "<BR>".$sql;exit;
	global $SHOWTEXT; if($SHOWTEXT)	print "<BR><font color=green><B>$sql</B></font><BR>";
	if($���!="")		{
		//print $sql."�����<BR>";
		//ɾ���ɿ�������
		$sql = "delete from edu_xingzheng_kaoqinmingxi where ѧ��='$ѧ��' and ��Ա�û���='$��Ա�û���' and ����='$�ϰ�ʱ��' and ���='$���'";
		$db->Execute($sql);
		//print "<BR>".$sql;exit;
		//ɾ���¿�������
		$sql = "delete from edu_xingzheng_kaoqinmingxi where ѧ��='$ѧ��' and ��Ա�û���='$��Ա�û���' and ����='$���ϰ�ʱ��' and ���='$�°��'";
		$db->Execute($sql);
		//print "<BR>".$sql;exit;
		global $SHOWTEXT; if($SHOWTEXT)print "��Ա�������<BR><font color=red><B>$sql</B></font><BR>";
		global $SHOWTEXT; if($SHOWTEXT&&sizeof($rs_a)>0)print_R($rs_a);;
		$NewArray['���ϰ�ʱ��'] = $���ϰ�ʱ��;
		$NewArray['�°��'] = $�°��;
		//print $sql."$���X<BR>";exit;
	}

	return $NewArray;
}


//��Ա�໥�������
function ������Ա�໥����״̬($��Ա,$��Ա�û���,$�ϰ�ʱ��,$���,$ѧ��)		{
	global $db;
	// ���  ѧ��  �༶  ����  ��Ա  �γ�  ԭ�ϰ�ʱ��  ԭ���  ���ϰ�ʱ��  �°��  ���״̬  ������ID��  �����  ���ʱ��
	$sql = "select ��� from edu_xingzheng_tiaobanxianghu where ((ԭ��Ա�û���='$��Ա�û���' and ԭ�ϰ�ʱ��='$�ϰ�ʱ��' and ԭ���='$���') or (����Ա�û���='$��Ա�û���' and ���ϰ�ʱ��='$�ϰ�ʱ��' and �°��='$���') ) and ���״̬='1'";
	global $SHOWTEXT; if($SHOWTEXT)print "<BR><font color=green><B>$sql</B></font><BR>";
	$rs = $db->Execute($sql);
	$rs_a = $rs->GetArray();
	$��� = $rs_a[0]['���'];
	global $SHOWTEXT; if($SHOWTEXT&&sizeof($rs_a)>0)print_R($rs_a);;
	return $���;
}

//���  ѧ��  ����  ��Ա  �Ӱ�ʱ��  �Ӱ���  ����ʱ��  ���ݰ��  �Ӱ����״̬  �Ӱ๤����ID��  �Ӱ������  �Ӱ����ʱ��  �������״̬  ���ݹ�����ID��  ���������  �������ʱ��
//��Ա���ݹ���
function ������Ա����״̬($��Ա,$��Ա�û���,$�ϰ�ʱ��,$���,$ѧ��)		{
	global $db;
	// ���  ѧ��  �༶  ����  ��Ա  �γ�  ԭ�ϰ�ʱ��  ԭ���  ���ϰ�ʱ��  �°��  ���״̬  ������ID��  �����  ���ʱ��
	$sql = "select ��� from edu_xingzheng_jiabanbuxiu where ��Ա�û���='$��Ա�û���' and ����ʱ��='$�ϰ�ʱ��' and ���ݰ��='$���' and �������״̬='1'";
	global $SHOWTEXT; if($SHOWTEXT)print "<BR><font color=green><B>$sql</B></font><BR>";
	$rs = $db->Execute($sql);
	$rs_a = $rs->GetArray();
	$��� = $rs_a[0]['���'];
	global $SHOWTEXT; if($SHOWTEXT&&sizeof($rs_a)>0)print_R($rs_a);;
	return $���;
}



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

function ����ٵ����˷���������()		{
	global $db;
	//����ٵ��ķ�����	��Ա='$��Ա����' and ����='$��������' and
	$sql = "select * from edu_xingzheng_kaoqinmingxi where
			�ϰ�ʵ��ˢ��<�ϰ�ٵ�ʱ��
			and �ϰ�ʵ��ˢ��>�ϰ�ˢ��END
			and LENGTH(�ϰ�ʵ��ˢ��)=5
			and �ϰ�ٵ�ʱ��!=''
			and �ϰ�ʵ��ˢ��!=''
			and �ϰ�ˢ��END!=''
			and �ٵ�������=''
			";
	global $SHOWTEXT; if($SHOWTEXT) print "<BR><font color=orange>����ٵ�������:".$sql."</font>";
	//print $sql."<BR>";exit;
	$rs = $db->Execute($sql);
	$rs_a = $rs->GetArray();
	for($iii=0;$iii<sizeof($rs_a);$iii++)						{
		$��� = $rs_a[$iii]['���'];
		$�ϰ�ʵ��ˢ�� = $rs_a[$iii]['�ϰ�ʵ��ˢ��'];
		$�ϰ�ˢ��END = $rs_a[$iii]['�ϰ�ˢ��END'];
		$�ϰ�ʵ��ˢ��Array = explode(':',$�ϰ�ʵ��ˢ��);
		$�ϰ�ˢ��ENDArray = explode(':',$�ϰ�ˢ��END);
		$�ϰ�ʵ��ˢ��ʱ���� = mktime($�ϰ�ʵ��ˢ��Array[0],$�ϰ�ʵ��ˢ��Array[1],1,12,12,2009);
		$�ϰ�ˢ��ENDʱ���� = mktime($�ϰ�ˢ��ENDArray[0],$�ϰ�ˢ��ENDArray[1],1,12,12,2009);
		//print $�ϰ�ʵ��ˢ��ʱ����."<BR>";
		//print $�ϰ�ٵ�ʱ��ʱ����."<BR>";
		$�ٵ������� = ($�ϰ�ʵ��ˢ��ʱ����-$�ϰ�ˢ��ENDʱ����)/60;
		$�ٵ������� = floor($�ٵ�������);
		$sql = "update edu_xingzheng_kaoqinmingxi set �ٵ������� = '$�ٵ�������' where ���='$���'";
		$db->Execute($sql);
		global $SHOWTEXT; if($SHOWTEXT) print "<BR><font color=orange>����ٵ�������:".$sql."</font>";//exit;
	}


	//�������˵ķ�����
	$sql = "select * from edu_xingzheng_kaoqinmingxi where
			�°�ʵ��ˢ��>�°�����ʱ��
			and �°�ʵ��ˢ��<�°�ˢ��BGN
			and LENGTH(�°�ʵ��ˢ��)=5
			and �°�����ʱ��!=''
			and �°�ʵ��ˢ��!=''
			and �°�ˢ��BGN!=''
			and ���˷�����=''
			";//
	//print $sql."<BR>";exit;
	global $SHOWTEXT; if($SHOWTEXT) print "<BR><font color=orange>�������˷�����:".$sql."</font>";
	$rs = $db->Execute($sql);
	$rs_a = $rs->GetArray();
	for($iii=0;$iii<sizeof($rs_a);$iii++)						{
		$��� = $rs_a[$iii]['���'];
		$�°�ʵ��ˢ�� = $rs_a[$iii]['�°�ʵ��ˢ��'];
		$�°�ˢ��BGN = $rs_a[$iii]['�°�ˢ��BGN'];
		$�°�ʵ��ˢ��Array = explode(':',$�°�ʵ��ˢ��);
		$�°�ˢ��BGNArray = explode(':',$�°�ˢ��BGN);
		$�°�ʵ��ˢ��ʱ���� = mktime($�°�ʵ��ˢ��Array[0],$�°�ʵ��ˢ��Array[1],1,12,12,2009);
		$�°�ˢ��BGNʱ���� = mktime($�°�ˢ��BGNArray[0],$�°�ˢ��BGNArray[1],1,12,12,2009);
		//print $�°�ʵ��ˢ��ʱ����."<BR>";
		//print $�°�����ʱ��ʱ����."<BR>";
		$���˷����� = ($�°�ˢ��BGNʱ����-$�°�ʵ��ˢ��ʱ����)/60;
		$���˷����� = floor($���˷�����);
		$sql = "update edu_xingzheng_kaoqinmingxi set ���˷����� = '$���˷�����' where ���='$���'";
		$db->Execute($sql);
		global $SHOWTEXT; if($SHOWTEXT) print "<BR><font color=orange>�������˷�����:".$sql."</font>";//exit;
	}
}
function ����ĳ��ĳʱ�ϰ��°�ʱ������($��Ա����,$��Ա�û���,$��������,$ʱ��)		{
	global $db,$InsertData;
	//print $KuangGongShiJian;exit;
	//����ٵ���
	$ʱ��Array = explode(':',$ʱ��);
	$�ٵ�ʱ�� = date("H:i",mktime($ʱ��Array[0],$ʱ��Array[1],1,12,12,2009));
	//2010-2-26�������´���

	//�ٵ�������,���ȼ���� �ϰ�״̬
	$sql = "update edu_xingzheng_kaoqinmingxi
			set �ϰ�ʵ��ˢ�� = '$ʱ��' ,�ϰ࿼��״̬='�ٵ�������'
			where
			��Ա�û���='$��Ա�û���'
			and ����='$��������'
			and �ϰ�ٵ�ʱ��<='$ʱ��'
			and �°�����ʱ��>='$ʱ��'
			and �ϰ࿼��״̬!='����ˢ��'
			and �ϰ࿼��״̬!='�ϰ�ٵ�'
			and �ϰ࿼��״̬!='�°�����'
			";
	$db->Execute($sql);

	//�ٵ�������,���ȼ���� �°�״̬
	$sql = "update edu_xingzheng_kaoqinmingxi
			set �°�ʵ��ˢ�� = '$ʱ��' ,�°࿼��״̬='�ٵ�������'
			where
			��Ա�û���='$��Ա�û���'
			and ����='$��������'
			and �ϰ�ٵ�ʱ��<='$ʱ��'
			and �°�����ʱ��>='$ʱ��'
			and �°࿼��״̬!='����ˢ��'
			and �°࿼��״̬!='�ϰ�ٵ�'
			and �°࿼��״̬!='�°�����'
			";
	$db->Execute($sql);

	//�ϰ�ٵ�,ͬʱ����ٵ�������,��Ҫ�ж��Ƿ�������״̬
	$sql = "update edu_xingzheng_kaoqinmingxi
			set �ϰ�ʵ��ˢ�� = '$ʱ��' ,�ϰ࿼��״̬='�ϰ�ٵ�'
			where
			��Ա�û���='$��Ա�û���'
			and ����='$��������'
			and �ϰ�ˢ��END<='$ʱ��'
			and �ϰ�ٵ�ʱ��>='$ʱ��'
			and �ϰ࿼��״̬!='����ˢ��'
			";
	$db->Execute($sql);

	//�°�����,ͬʱ�������˷�����,��Ҫ�ж��Ƿ�������״̬
	$sql = "update edu_xingzheng_kaoqinmingxi
			set �°�ʵ��ˢ�� = '$ʱ��' ,�°࿼��״̬='�°�����'
			where
			��Ա�û���='$��Ա�û���'
			and ����='$��������'
			and �°�����ʱ��<='$ʱ��'
			and �°�ˢ��BGN>='$ʱ��'
			and �°࿼��״̬!='����ˢ��'
			";
	$db->Execute($sql);

	//�ϰ�����
	$sql = "update edu_xingzheng_kaoqinmingxi
			set �ϰ�ʵ��ˢ�� = '$ʱ��' ,�ϰ࿼��״̬='����ˢ��'
			where
			��Ա�û���='$��Ա�û���'
			and ����='$��������'
			and �ϰ�ˢ��BGN<='$ʱ��'
			and �ϰ�ˢ��END>='$ʱ��'
			";
	$db->Execute($sql);

	//�°�����
	$sql = "update edu_xingzheng_kaoqinmingxi
			set �°�ʵ��ˢ�� = '$ʱ��' ,�°࿼��״̬='����ˢ��'
			where
			��Ա�û���='$��Ա�û���'
			and ����='$��������'
			and �°�ˢ��BGN<='$ʱ��'
			and �°�ˢ��END>='$ʱ��'
			";
	$db->Execute($sql);


	/*2010-2-26�մ�����,ת���´���
	$sql = "select * from edu_xingzheng_kaoqinmingxi where ��Ա='$��Ա����' and ����='$��������' and �ϰ�ˢ��BGN<='$�ٵ�ʱ��' and �ϰ�ˢ��END>='$�ٵ�ʱ��'";
	$rs2 = $db->Execute($sql);
	$rs2_a = $rs2->GetArray();
	//print_R($rs2_a);
	for($iii=0;$iii<sizeof($rs2_a);$iii++)						{
		$��� = $rs2_a[$iii]['���'];
		$sql = "update edu_xingzheng_kaoqinmingxi set �ϰ�ʵ��ˢ�� = '$ʱ��' ,�ϰ࿼��״̬='�ϰ�ٵ�' where ���='$���'";
		$db->Execute($sql);
		$InsertData++;
		$returnText .= "$��Ա���� �ϰ�ٵ� $�������� $ʱ��<BR>";
		//print $sql."<BR>";
	}
	//����������
	$sql = "select * from edu_xingzheng_kaoqinmingxi where ��Ա='$��Ա����' and ����='$��������' and �ϰ�ˢ��BGN<='$ʱ��' and �ϰ�ˢ��END>='$ʱ��'";
	$rs2 = $db->Execute($sql);
	$rs2_a = $rs2->GetArray();
	//print_R($rs2_a);
	for($iii=0;$iii<sizeof($rs2_a);$iii++)						{
		$��� = $rs2_a[$iii]['���'];
		$sql = "update edu_xingzheng_kaoqinmingxi set �ϰ�ʵ��ˢ�� = '$ʱ��' ,�ϰ࿼��״̬='����ˢ��' where ���='$���'";
		$db->Execute($sql);
		$InsertData++;
		$returnText .= "$��Ա���� �ϰ����� $�������� $ʱ��<BR>";
		//print $sql."<BR>";
	}*/
	return $returnText;
}

function ����ĳ��ĳʱ�°�ʱ������($��Ա����,$��Ա�û���,$��������,$ʱ��)		{
	global $db,$InsertData;
	//2010-2-26�������´���
	//$sql = "update edu_xingzheng_kaoqinmingxi set �°�ʵ��ˢ�� = '$ʱ��' ,�°࿼��״̬='����ˢ��' where 			��Ա='$��Ա����' and ����='$��������' and �°�ˢ��BGN<='$ʱ��' and �°�ˢ��END>='$ʱ��'";
	//$db->Execute($sql);
	/*2010-2-26�մ�����,ת���´���
	$sql = "select * from edu_xingzheng_kaoqinmingxi where ��Ա='$��Ա����' and ����='$��������' and �°�ˢ��BGN<='$ʱ��' and �°�ˢ��END>='$ʱ��'";
	$rs2 = $db->Execute($sql);
	$rs2_a = $rs2->GetArray();
	$returnText = "";
	for($iii=0;$iii<sizeof($rs2_a);$iii++)						{
		$��� = $rs2_a[$iii]['���'];
		$sql = "update edu_xingzheng_kaoqinmingxi set �°�ʵ��ˢ�� = '$ʱ��' ,�°࿼��״̬='����ˢ��' where ���='$���'";
		$db->Execute($sql);
		$InsertData++;
		$returnText .= "$��Ա���� �°����� $�������� $ʱ��<BR>";
		//print $sql."<BR>";
	}*/
	return $returnText;
}



?>