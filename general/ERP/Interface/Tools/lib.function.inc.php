<?

//���ݰ༶��Ϣ�õ����а༶�ļ�����Ϣ�б�
function returnBanjiJiBieList()				{
	global $db;
	$sql = "select distinct ��ѧ��� from edu_banji order by ��ѧ��� desc";
	$rs = $db->CacheExecute(36,$sql);
	$rs_a = $rs->GetArray();
	for($i=0;$i<sizeof($rs_a);$i++)									{
		$NewArray[] = $rs_a[$i]['��ѧ���'];
	}
	return $NewArray;
}


//���ݰ༶���ƺ͵�ǰѧ���ڽ�ѧ�ƻ��еõ��γ������б�
function returnBanjiCourseList($ClassCode,$returnCurXueQiIndex,$��������='')				{
	global $db;
	$sql = "select distinct �γ����� from edu_planexec where ����ѧ��='$returnCurXueQiIndex' and �༶����='$ClassCode' order by �γ�����";
	$rs = $db->CacheExecute(36,$sql);
	$rs_am = $rs->GetArray();

	if($��������!="")					{
		//�����еĳɼ������и��ӿγ���Ϣ
		$sql = "select distinct �γ� from edu_exam  where ��������='$��������' and �༶='$ClassCode'";
		$rs = $db->CacheExecute(36,$sql);
		$rs_a = $rs->GetArray();//print_R($rs_a);
		for($i=0;$i<count($rs_a);$i++)			{
		if(@!in_array($rs_a[$i]['�γ�'],$rs_am))
			$rs_am[]['�γ�����'] = $rs_a[$i]['�γ�'];
		}
	}

	return $rs_am;
}


//���ذ༶���ϵĿγ�
function returnBanjiCourseListMiddleSchool($ClassCode,$returnCurXueQiIndex)				{
	global $db;
	$sql = "select distinct �γ����� from edu_course order by �γ�����";
	$rs = $db->CacheExecute(3600,$sql);
	$rs_am = $rs->GetArray();
	return $rs_am;
}

//�����꼶���ص�ǰ�Ŀ���ѧ������
function returnCurXueQiIndex($NJ,$ѧ������='')				{
	global $db;
	//�滻ԭ��ѧ������������,�µķ�������ѧ�����Ƶķ�ʽ,ȥ��ԭ�л���ķ��� 2010-07-21
	if($ѧ������=="")
		$ѧ������ = returntablefield("edu_xueqiexec","��ǰѧ��",'1',"ѧ������");
	return $ѧ������;
}

//�Ӳ˵�Ȩ�޹�����,ͬʱ��FRAMEWORK��EDU������ж���
function returnPrivMenuEDU($ModuleName)		{
	global $db,$_SERVER,$_SESSION;
	$PHP_SELF_ARRAY = explode('/',$_SERVER['PHP_SELF']);
	$PHP_SELF = array_pop($PHP_SELF_ARRAY);
	$sql = "select * from systemprivateinc where `FILE`='$PHP_SELF' and `MODULE`='$ModuleName'";
	$rs = $db->Execute($sql);
	$rs_a = $rs->GetArray(); //print_R($rs_a);
	$DEPT_NAME = $rs_a[0]['DEPT_ID'];
	$USER_NAME = $rs_a[0]['USER_ID'];
	$ROLE_NAME = $rs_a[0]['ROLE_ID'];
	$return = 0;
	//������Ϊ��ʱ������ж�
	if($DEPT_NAME==""&&$USER_NAME==""&&$ROLE_NAME=="")		{
		$return = 1;
	}
	//ȫ�岿��
	if($DEPT_NAME=="ALL_DEPT")			{
		$return = 1.5;
	}
	//�û��ж�
	$LOGIN_USER_ID = $_SESSION['LOGIN_USER_ID'];
	$LOGIN_USER_ID_ARRAY = explode(',',$USER_NAME);
	if(in_array($LOGIN_USER_ID,$LOGIN_USER_ID_ARRAY))		{
		$return = 2;
	}
	//�����ж�
	$LOGIN_DEPT_ID = $_SESSION['LOGIN_DEPT_ID'];
	$LOGIN_DEPT_ID_ARRAY = explode(',',$DEPT_NAME);
	if(in_array($LOGIN_DEPT_ID,$LOGIN_DEPT_ID_ARRAY))		{
		$return = 3;
	}
	//��ɫ�ж�
	$LOGIN_USER_PRIV = $_SESSION['LOGIN_USER_PRIV'];
	$LOGIN_USER_PRIV_ARRAY = explode(',',$ROLE_NAME);
	if(in_array($LOGIN_USER_PRIV,$LOGIN_USER_PRIV_ARRAY))		{
		$return = 4;
	}
	//print_R($_SESSION);
	return $return;
}

//���ظ���ʱ��
function returnUpdateDate($CurXueQi,$FieldName="�༶",$BanJi='')		{
	global $db;
	$sql = "select max(Date) as Date from edu_exam where $FieldName='$BanJi' and `ѧ��`='$CurXueQi'";
	$rs = $db->Execute($sql);
	return $rs->fields['Date'];
}

//���سɼ�ͳ�������ֶ�
function returnStatisticsDomain($Value)		{
	switch($Value)			{
		case $Value<0:
			$return = 1;
			break;
		case $Value>=0&&$Value<=10:
			$return = 1;
			break;
		case $Value>10&&$Value<=20:
			$return = 2;
			break;
		case $Value>20&&$Value<=30:
			$return = 3;
			break;
		case $Value>30&&$Value<=40:
			$return = 4;
			break;
		case $Value>40&&$Value<=50:
			$return = 5;
			break;
		case $Value>50&&$Value<=60:
			$return = 6;
			break;
		case $Value>60&&$Value<=70:
			$return = 7;
			break;
		case $Value>70&&$Value<=80:
			$return = 8;
			break;
		case $Value>80&&$Value<=90:
			$return = 9;
			break;
		case $Value>90&&$Value<=100:
			$return = 10;
			break;
		case $Value>100&&$Value<=110:
			$return = 11;
			break;
		case $Value>110&&$Value<=120:
			$return = 12;
			break;
		case $Value>120&&$Value<=130:
			$return = 13;
			break;
		case $Value>130&&$Value<=140:
			$return = 14;
			break;
		case $Value>140&&$Value<=150:
			$return = 15;
			break;
		case $Value>150:
			$return = 15;
			break;
	}
	return $return;
}

//���سɼ���Χ
function returnExamScope($Value)		{
	switch($Value)			{
		case 1:
			$return = "0-10";
			break;
		case 2:
			$return = "10-20";
			break;
		case 3:
			$return = "20-30";
			break;
		case 4:
			$return = "30-40";
			break;
		case 5:
			$return = "40-50";
			break;
		case 6:
			$return = "50-60";
			break;
		case 7:
			$return = "60-70";
			break;
		case 8:
			$return = "70-80";
			break;
		case 9:
			$return = "80-90";
			break;
		case 10:
			$return = "90-100";
			break;
		case 11:
			$return = "100-110";
			break;
		case 12:
			$return = "110-120";
			break;
		case 13:
			$return = "120-130";
			break;
		case 14:
			$return = "130-140";
			break;
		case 15:
			$return = "140-150";
			break;
	}
	return $return;
}

//��ʾ��ʾ��Ϣ
function EDU_TripInfor($CONTENT = "��ʦû�е�¼�������µ�¼!")		{
	print "<LINK href=\"../../theme/1/style.css\" type=text/css rel=stylesheet>
		<table width=360  border=0 align=center cellpadding=0 cellspacing=0 class=\"small\" style=\"border:1px solid #006699;\">
		<tr>
		<td height=\"50\" align=\"middle\" colspan=2 background=\"../theme/1/images/index_01_backup.gif\" bgcolor=\"#E0F2FC\">
		<font color=red>$CONTENT</font>
		</td>
		</table>";
}

//����ҳ��
function EDU_Indextopage($page,$nums='0')		{
	print  "<META HTTP-EQUIV=REFRESH CONTENT='".$nums.";URL=".$page."'>\n";
}

//����ʦ���Ͷ���֪ͨ
function send_sms_teacher($MobileText,$Content,$Header="�����µĹ���֪ͨ:")				{
	global $db,$_GET,$_POST;
	$Content = $Header.$Content;
	$SERVER_NAME = $_SERVER['SERVER_NAME'];
	//$SERVER_NAME = "sz070811.dipns.com";
	if($_POST['SendSmsTime']!="")	$DateTime = $_POST['SendSmsTime'];
	else			$DateTime = date("Y-m-d");

	$Count = 0;
	//��ʼ������ͳ��
	preg_match_all("/[\x80-\xff]?./",$Content,$CH_Array);
	//�õ�����������
	$MaxLen = count($CH_Array[0]);
	$array_slice = array_slice($CH_Array[0], $from=0, $length=138);
	$Content = join('',$array_slice);

	global $SYSTEM_SMS_INFOR;
	require_once('../Teacher/configsms.inc.php');
	//WebService
	////http://221.236.8.245/admin/sms3.aspx?phone=13540087220;02889615587;13681234567&code=940318&msg=��ɫУ԰
	//WEB GET
	$URL = "http://".$SYSTEM_SMS_INFOR."/admin/sms3.aspx?cityname=&schooldns=$SERVER_NAME&phone=$MobileText&time1=$DateTime&code=940318&msg=$Content";
	$URL = ereg_replace(' ','%20',$URL);
	//print strlen($Content);
	//print $URL."<BR>";exit;
	$file = @file($URL);
	//print $URL."<BR>";exit;
	$Text = @join('',$file);

}

//���ذ༶��ѧ������
function returnClassNumber($ClassName)		{
	global $db;
	$sql = "select count(���) as num from edu_student where ���='$ClassName'";
	$rs = $db->Execute($sql);
	$rs_a = $rs->GetArray();
	return $rs_a[0]['num'];
}

//��ѵ������Ҫʹ�õĺ���
function CashLeftNumber($��ǰʱ��='')		{
	global $db;
	if($��ǰʱ��=="")		$��ǰʱ�� = date("Y-m-d H:i:s");
	//�շѵ��ݽ��
	$sql = "select SUM(�շѽ��) AS NUMBER from  edu_shoufeidan where �շ�����<='$��ǰʱ��' and ֧����ʽ='�ֽ�'";
	$rs = $db->Execute($sql);
	$rs_a = $rs->GetArray();
	$NUMBER1 = $rs_a[0]['NUMBER'];
	//print $sql;
	//�˷ѵ��ݽ��
	$sql = "select SUM(�˷ѽ��) AS NUMBER from  edu_tuifeidan where �˷�����<='$��ǰʱ��' and ֧����ʽ='�ֽ�'";
	$rs = $db->Execute($sql);
	$rs_a = $rs->GetArray();
	$NUMBER2 = $rs_a[0]['NUMBER'];
	$LEFT = $NUMBER1-$NUMBER2;
	return $LEFT;
}
function BankLeftNumber($��ǰʱ��='')		{
	global $db;
	if($��ǰʱ��=="")		$��ǰʱ�� = date("Y-m-d H:i:s");
	//�շѵ��ݽ��
	$sql = "select SUM(�շѽ��) AS NUMBER from  edu_shoufeidan where �շ�����<='$��ǰʱ��' and ֧����ʽ!='�ֽ�'";
	$rs = $db->Execute($sql);
	$rs_a = $rs->GetArray();
	$NUMBER1 = $rs_a[0]['NUMBER'];
	//�˷ѵ��ݽ��
	$sql = "select SUM(�˷ѽ��) AS NUMBER from  edu_tuifeidan where �˷�����<='$��ǰʱ��' and ֧����ʽ!='�ֽ�'";
	$rs = $db->Execute($sql);
	$rs_a = $rs->GetArray();
	$NUMBER2 = $rs_a[0]['NUMBER'];
	//��������
	$sql = "select SUM(������) AS NUMBER from  edu_qitashouru where ��������<='$��ǰʱ��' and ֧����ʽ!='�ֽ�'";
	$rs = $db->Execute($sql);
	$rs_a = $rs->GetArray();
	$NUMBER3 = $rs_a[0]['NUMBER'];
	//����֧��
	$sql = "select SUM(֧�����) AS NUMBER from  edu_qitazhichu where ֧������<='$��ǰʱ��' and ֧����ʽ!='�ֽ�'";
	$rs = $db->Execute($sql);
	$rs_a = $rs->GetArray();
	$NUMBER4 = $rs_a[0]['NUMBER'];
	//��
	$sql = "select SUM(�����) AS NUMBER from  edu_cunkuandan where �������<='$��ǰʱ��'";
	$rs = $db->Execute($sql);
	$rs_a = $rs->GetArray();
	$NUMBER5 = $rs_a[0]['NUMBER'];
	//ȡ�
	$sql = "select SUM(ȡ����) AS NUMBER from  edu_qukuandan where ȡ������<='$��ǰʱ��'";
	$rs = $db->Execute($sql);
	$rs_a = $rs->GetArray();
	$NUMBER6 = $rs_a[0]['NUMBER'];
	$LEFT = $NUMBER1-$NUMBER2+$NUMBER3-$NUMBER4+$NUMBER5-$NUMBER6;
	return $LEFT;
}

function ReturnAlreadyFee($XH='20051082150',$XN='2006-2007')		{
global $db;
$sql = "select * from edu_shoufeidan where ѧ��='$XH' and ѧ��='$XN'";
$rs = $db->Execute($sql);
$rs_a = $rs->GetArray();
$NewArray = array();
//$ZYMC = returntablefield("XSJBXXB","XH",$XH,"ZYMC");
//$XMC = returntablefield("XSJBXXB","XH",$XH,"XI");
//$XYMC = returntablefield("XSJBXXB","XH",$XH,"XY");
for($i=0;$i<sizeof($rs_a);$i++)									{
		$XN = $rs_a[$i]['XN'];
		$ѧ�� = $rs_a[$i]['ѧ��'];
		$XM = $rs_a[$i]['XM'];
		$NJ = $rs_a[$i]['NJ'];
		$BJMC = $rs_a[$i]['BJMC'];
		$BZ = $rs_a[$i]['BZ'];
		$CZRQ = $rs_a[$i]['CZRQ'];
		$SFLX = $rs_a[$i]['SFLX'];
		$SSHJ = $rs_a[$i]['SSHJ'];
		$�շ���Ŀ���� = $rs_a[$i]['�շ���Ŀ����'];
		$NewArray['��ϸ'][$�շ���Ŀ����] += $rs_a[$i]['�շѽ��'];
		$NewArray['�ϼ�'] += $rs_a[$i]['�շѽ��'];
}
//print_R($NewArray);
return $NewArray;
}
//����Ӧ��ѧ������-��У����
function ReturnOfficeFee($ZYDM='1211',$XN='2006-2007',$NJ='2006')		{
	global $db;
	$sql = "select * from edu_zhuanyeshoufei where רҵ����='$ZYDM' and �꼶='$NJ' and ѧ��='$XN'";
	$rs = $db->Execute($sql);
    $rs_a = $rs->GetArray();
	$NewArray = array();
	for($i=0;$i<sizeof($rs_a);$i++)		{
		$�շѱ�׼ = $rs_a[$i]['�շѱ�׼'];
		$�շ���Ŀ���� = $rs_a[$i]['�շ���Ŀ����'];
		$NewArray['��ϸ'][$�շ���Ŀ����] = $�շѱ�׼;
		$NewArray['�ϼ�'] += $�շѱ�׼;
	}
	return $NewArray;
}


//����Ӧ��ѧ������-��Сѧ����
function ReturnOfficeFeeMiddleSchool($XN='2006-2007',$NJ='2006')		{
	global $db;
	$sql = "select * from edu_zhuanyeshoufei where �꼶='$NJ' and ѧ��='$XN'";
	$rs = $db->Execute($sql);
    $rs_a = $rs->GetArray();
	$NewArray = array();
	for($i=0;$i<sizeof($rs_a);$i++)		{
		$�շѱ�׼ = $rs_a[$i]['�շѱ�׼'];
		$�շ���Ŀ���� = $rs_a[$i]['�շ���Ŀ����'];
		$NewArray['��ϸ'][$�շ���Ŀ����] = $�շѱ�׼;
		$NewArray['�ϼ�'] += $�շѱ�׼;
	}
	return $NewArray;
}



function aksort(&$array,$valrev=false,$keyrev=false) {
  if ($valrev) { arsort($array); } else { asort($array); }
    $vals = array_count_values($array);
    $i = 0;
    foreach ($vals AS $val=>$num) {
        $first = array_splice($array,0,$i);
        $tmp = array_splice($array,0,$num);
        if ($keyrev) { krsort($tmp); } else { ksort($tmp); }
        $array = array_merge($first,$tmp,$array);
        unset($tmp);
        $i = $num;
    }
}


?>