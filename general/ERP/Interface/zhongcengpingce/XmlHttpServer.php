<?php
ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL);

// display warnings and errors
error_reporting(E_WARNING | E_ERROR);

header("Content-Type:text/html;charset=gbk");
require_once('lib.inc.php');

$GLOBAL_SESSION=returnsession();
$SYSTEM_PRIV_STOP = 1;

//print "���÷,��С��,����,����,����,������,�Ŵ���,����,����,����,����,����,���˻�,������,��Сƽ,����,���,����,����,����,����,����,������,���˱�,������,��ǿ,�ζ���,������,����,����,����,κ����,����÷,����ά,����Ӣ,��ѧ��,�쾲,����,Ѧ��,���,��˷,Ԭ��Ӣ,ԬӢ��,�ž�,����,������,��ʥ��,���,�����,��Ӣ,�޳˵�,������,��̫��,�δ�ϼ,��ѩ÷,����,����;100001,100010,100159,100160,100161,100162,100163,100164,100165,100166,100167,100168,100169,100170,100171,100172,100173,100174,100175,100176,100178,100179,100180,100181,100182,100183,100184,100185,100187,100188,100189,100190,100191,100192,100193,100194,100195,100196,100197,100198,100199,100200,100201,100202,100203,100205,100206,100207,100208,100209,100325,100334,100347,100348,100355,100356,100392û������";exit;
global $db;
//##############################################################################
//�ſΣ��ӿγ̵õ���ʦ����
/*
if($_GET['action']=="showdatas"&&$_GET['selectName']!="")
{
	$tablename = "dict_countrycode";
	$field_value = "countryCode";
	$field_name = "countryName";
	$רҵ���� = $_GET['רҵ����'];
	$���� = $_GET['����'];
	$�γ����� = $_GET['selectName'];

	$sql = "select �̿���ʦ from edu_plan where ����='$����' and רҵ����='$רҵ����' and �γ�����='$�γ�����'";
	$newarray = array();
	$newarray1 = array();
	$newarray2 = array();
	$rs=$db->Execute($sql);
	$rs_a=$rs->GetArray();
	for($i=0;$i<sizeof($rs_a);$i++)		{
		$newarray1[$i]=$rs_a[$i]['�̿���ʦ'];
		$newarray2[$i]=$rs_a[$i]['�̿���ʦ'];
	}
	print join(',',$newarray1);
	print ";";
	print join(',',$newarray2);
	exit;
}
*/
///*����Ϊ�ɰ洦��ʽ,�°汾�ӽ�ѧ�ƻ��л�ȡ��Ӧ��Ϣ
if($_GET['action']=="showdatas"&&$_GET['selectName']!="")
{
	$tablename = "dict_countrycode";
	$field_value = "countryCode";
	$field_name = "countryName";
	//###################################################################################
	//����༶����Ӧ�Ĵ�����ʦ��Ϣ####################################################
	$SCHOOL_MODEL = parse_ini_file("SCHOOL_MODEL.ini");
	$SCHOOL_MODEL_TEXT = $SCHOOL_MODEL['SCHOOL_MODEL'];
	//print $SCHOOL_MODEL_TEXT;exit;
	$�༶���� = $_GET['�༶����'];
	$�γ����� = $_GET['selectName'];
	$newarray1 = array();
	$newarray2 = array();

	if($SCHOOL_MODEL_TEXT=="4")			{
		//����ѧ�ڹ��˽�ʦ�Ͽ���Ϣ
		$NewArray���ν�ʦ = array();
		$NewArray�γ����� = array();
		//$���� = returntablefield("edu_banji","�༶����",$ClassCode,"��ѧ���");
	if($_GET['CurXueQi']!="")
		$����ѧ��	=	$_GET['CurXueQi'];
	else if($_GET['����ѧ��']!="")
		$����ѧ��	=	$_GET['����ѧ��'];
	else
		$����ѧ��	=	returntablefield("edu_xueqiexec","��ǰѧ��",'1',"ѧ������");
		$sql = "select ���ν�ʦ from edu_planexec where �༶����='".$�༶����."' and ����ѧ��='$����ѧ��' and �γ�����='$�γ�����' order by ��ʦ�û���,�༶����";
		$rs = $db->Execute($sql);
		$rs_a = $rs->GetArray();
		for($ii=0;$ii<sizeof($rs_a);$ii++)		{
			//$TeacherUsername = returntablefield('edu_teacher2',"��ʵ����",$rs_a[$ii]['���ν�ʦ'],"�û���");
			$TeacherUsername = returntablefield('user',"USER_NAME",$rs_a[$ii]['���ν�ʦ'],"USER_ID");
			$newarray1[$ii]=$rs_a[$ii]['���ν�ʦ'];
			$newarray2[$ii]=$TeacherUsername;
		}
	}


	if($SCHOOL_MODEL_TEXT=="1"||$SCHOOL_MODEL_TEXT=="2"||$SCHOOL_MODEL_TEXT=="3")			{
	if($_GET['CurXueQi']!="")
		$����ѧ��	=	$_GET['CurXueQi'];
	else if($_GET['����ѧ��']!="")
		$����ѧ��	=	$_GET['����ѧ��'];
	else
		$����ѧ��	=	returntablefield("edu_xueqiexec","��ǰѧ��",'1',"ѧ������");
	//�滻ԭ��ѧ������������,�µķ�������ѧ�����Ƶķ�ʽ,ȥ��ԭ�л���ķ��� 2010-07-21

	$sql = "select distinct ���ν�ʦ from edu_planexec where �༶����='".$_GET['�༶����']."' and ���� = '$NJ' and ����ѧ��='$����ѧ��' and �γ�����='".$_GET['selectName']."'";
	$rs = $db->Execute($sql);
	$rs_a = $rs->GetArray();
	//print_R($rs_a);
	for($ii=0;$ii<sizeof($rs_a);$ii++)		{
		//$TeacherUsername = returntablefield('edu_teacher2',"��ʵ����",$rs_a[$ii]['���ν�ʦ'],"�û���");
		$TeacherUsername = returntablefield('user',"USER_NAME",$rs_a[$ii]['���ν�ʦ'],"USER_ID");
		$newarray2[] = $TeacherUsername;
		$newarray1[$TeacherUsername] = $rs_a[$ii]['���ν�ʦ'];
	}
	//print "<BR>".$CurXueQiIndex;exit;

	}
	print join(',',$newarray1);
	print ";";
	print join(',',$newarray2);
	exit;
}
//*/

//##############################################################################
//�����ſ���Ϣ��Ϊ������Ϣ
if($_GET['action']=="Schedule"&&$_GET['selectName']!="")
{
	//;action=Schedule&ClassCode=2002������&TeacherName=&fixedClassroom=1002&CourseName=&selectName=4&checkAction=doit
	$ClassCode = $_GET['ClassCode'];
	$TeacherName = $_GET['TeacherName'];
	$fixedClassroom = $_GET['fixedClassroom'];
	$selectName = $_GET['selectName'];
	$checkAction = $_GET['checkAction'];
	$CourseName = $_GET['CourseName'];
	$ClassCode = $_GET['ClassCode'];
	$CurXueQi = $_GET['CurXueQi'];
	$selectName_array = explode('_',$selectName);
	$Week = $selectName_array[0];
	$JieCi = $selectName_array[1];

	//������������Ϊȫ���������ڲ����ɾ��ʱ���õ������Է���˴�
	if($CurXueQi==""||$CurXueQi=="undefined")		{
		print $returnText .= "<font color=red><B>* ѧ����Ϣû���趨�������趨ѧ����Ϣ��</B></font><BR>";
		exit;
	}
	if($ClassCode=="")		{
		print $returnText .= "<font color=red><B>* �༶��Ϣû���趨������ѡ��༶��Ϣ��</B></font><BR>";
		exit;
	}
	if($fixedClassroom=="")	{
		print $returnText .= "<font color=red><B>* �̶�����û���趨�����ڰ༶�������棬Ϊ�ð༶�趨��̶����ң�</B></font><BR>";
		exit;
	}

	//�����ǿ�ʱ�ƻ�ͳ�ƽ����������
	//$returnCourseStatistics = '';
	//$returnCourseStatistics = returnCourseStatistics($CurXueQi,$ClassCode);
	//$returnCourseStatistics!=""?$returnCourseStatistics="::".$returnCourseStatistics:'';



	//�γ��½�����
	if($_GET['checkAction']=="doit")		{

		//������������ֻ�ڲ���α�ʱ���õ������Լ���˴�
		if($CourseName=="")		{
			print $returnText .= "<font color=red><B>* �γ���Ϣû���趨�������趨�γ���Ϣ��</B></font><BR>";
			exit;
		}
		if($TeacherName=="")	{
			print $returnText .= "<font color=red><B>* ��ʦ����û���趨�������趨��ʦ���ƣ�</B></font><BR>";
			exit;
		}

		//�жϽ����Ƿ��ͻ
		$sql = "select count(`����`) as NUM from edu_schedule where `ѧ��`='$CurXueQi' and `�༶`='$ClassCode' and `����`='$Week' and `�ڴ�`='$JieCi'";
		$rs = $db->Execute($sql);
		if($rs->fields['NUM']>0)		{
			print $returnText .= "<font color=red><B>* �ý����ڸ�ʱ���Ѿ������пγ̣�<BR>��ϸ���£�*******</B></font><BR>";
			//���»�ȡ����
			$returnCourseStatistics = '';
			$returnCourseStatistics = returnCourseStatistics($CurXueQi,$ClassCode);
			$returnCourseStatistics!=""?$returnCourseStatistics="::".$returnCourseStatistics:'';
			print $returnCourseStatistics;
			exit;
		}
		//�жϽ�ʦ�Ƿ��ͻ ѧ�ڣ��༶�����ڣ��ڴ�
		$sql = "select count(��ʦ) as NUM from edu_schedule where `ѧ��`='$CurXueQi' and `�༶`='$ClassCode' and `����`='$Week' and `�ڴ�`='$JieCi'";
		$rs = $db->Execute($sql);
		if($rs->fields['NUM']>0)		{
			print $returnText .= "<font color=red><B>* �ý�ʦ�ڸ�ʱ���Ѿ������пγ̣�<BR>��ϸ���£�*******</B></font><BR>";
			//���»�ȡ����
			$returnCourseStatistics = '';
			$returnCourseStatistics = returnCourseStatistics($CurXueQi,$ClassCode);
			$returnCourseStatistics!=""?$returnCourseStatistics="::".$returnCourseStatistics:'';
			print $returnCourseStatistics;
			exit;
		}
		//�γ����ſγ̵Ŀ�ʱ���żƻ�
		//1.��ѯ��2001��һ�ࡱ�Ŀα���Ϣʱ��ʾ����һ����ڶ��ڣ� �γ̣����� ����ʦ������ �����ң�1001
		//2.��ѯ��2001�����ࡱ�Ŀα���Ϣʱ��ʾ����һ����ڶ��ڣ� �γ̣����� ����ʦ������ �����ң�1111
		//�ж�һ����ʦ-�༶-��������,�ϰ��Ͽ�ʱ����ֻ��һ��,���Խ���Ҫ=ֵ�ж�
		$sql = "select `�γ�`,�༶,���� from edu_schedule where `ѧ��`='$CurXueQi' and `����`='$fixedClassroom' and `��ʦ`='$TeacherName' and `����`='$Week' and `�ڴ�`='$JieCi'";
		$rs = $db->Execute($sql);
		//print $sql.";<BR>";
		$rs_a = $rs->GetArray();
		//print_R($rs_a);
		//exit;
		//�γ����ſγ̵Ŀ�ʱ���żƻ�
		//Ϊ��֧�ֺϰ�����Ͽ�,�ذ��ж�������Ϊ:�γ�,�ϰ�ʱ�γ�Ϊһ����
		if($rs_a[0]['�γ�']!=$CourseName&&$rs_a[0]['�γ�']!="")		{
			print $returnText .= "<font color=red><B>* ".$TeacherName."��ʦ�Ѿ���".$rs_a[0]['����']."����\"".$rs_a[0]['�γ�']."\"�γ�,�����ٰ���\"".$CourseName."\"�γ�ͬһ��ʦ������ͬһʱ��ͽ����ϲ�ͬ�Ŀγ̣�<BR>������ͻ,�����ſ�</B></font><BR>";
			//���»�ȡ����
			$returnCourseStatistics = '';
			$returnCourseStatistics = returnCourseStatistics($CurXueQi,$ClassCode);
			$returnCourseStatistics!=""?$returnCourseStatistics="::".$returnCourseStatistics:'';
			print $returnCourseStatistics;
			exit;
		}
		//�ϰ�ʱ,�������Ѿ��еĿγ�������������༶,�жϳ�ͻ����Ϊ:�γ�,���Դ˴��ж�����Ϊ���������һ���Ͽ�
		if($rs_a[3]['�༶']!="")		{
			print $returnText .= "<font color=red><B>* ".$TeacherName."��ʦ�Ѿ�".$rs_a[0]['����']."����".$CourseName."�γ�,�Ͽΰ༶Ϊ:".$rs_a[0]['�༶'].",".$rs_a[1]['�༶'].",".$rs_a[2]['�༶']."<BR>������ͻ,�����ſ�</B></font><BR>";
			//���»�ȡ����
			$returnCourseStatistics = '';
			$returnCourseStatistics = returnCourseStatistics($CurXueQi,$ClassCode);
			$returnCourseStatistics!=""?$returnCourseStatistics="::".$returnCourseStatistics:'';
			print $returnCourseStatistics;
			exit;
		}
		//�������������ж������Ƿ���
		//������λ��
		$ClassroomNumber = returntablefield("edu_classroom","��������",$fixedClassroom,"��λ��");
		//�°༶����
		$ClassNumber = returnClassNumber($ClassCode);
		//�������ֻ��һ���༶ʱ
		if($rs_a[0]['�༶']!="")		{
			$OneClassNumber = returnClassNumber($rs_a[0]['�༶']);
			$CheckNumber = $OneClassNumber+$ClassNumber;
			if($CheckNumber>$ClassroomNumber)			{
				//��Ҫ�Ž�ȥ�ð�����������ý���������������
				print "<font color=red><B>����($fixedClassroom)��λ��:$ClassroomNumber,�Ѿ���װ�༶����:$OneClassNumber,��Ҫ���Ű༶����:$ClassNumber,������Ϊ:$CheckNumber,�����ý��ҵ��������ֵ:$ClassroomNumber,���ſ�ʧ��,���ִ�б��β���,���ڽ��ҹ����������µ��߽���($fixedClassroom)����λ��($ClassroomNumber),�������ſ�����Ҫ��.�ſ��ж�</B></font>";
				exit;
			}
		}
		//��������������༶ʱ
		if($rs_a[1]['�༶']!="")		{
			$OneClassNumber = returnClassNumber($rs_a[0]['�༶']);
			$TwoClassNumber = returnClassNumber($rs_a[1]['�༶']);
			$CheckNumber = $OneClassNumber+$TwoClassNumber+$ClassNumber;
			if($CheckNumber>$ClassroomNumber)			{
				//��Ҫ�Ž�ȥ�ð�����������ý���������������
				print "<font color=red><B>����($fixedClassroom)��λ��:$ClassroomNumber,�Ѿ���װ�༶����:".$OneClassNumber."��$TwoClassNumber,��Ҫ���Ű༶����:$ClassNumber,������Ϊ:$CheckNumber,�����ý��ҵ��������ֵ:$ClassroomNumber,���ſ�ʧ��,���ִ�б��β���,���ڽ��ҹ����������µ��߽���($fixedClassroom)����λ��($ClassroomNumber),�������ſ�����Ҫ��.�ſ��ж�</B></font>";
				exit;
			}
		}
		//print $ClassroomNumber;
		//print $ClassNumber;exit;




		//�γ����ſγ̵Ŀ�ʱ���żƻ�
		//����:�����ſ��п��Խ�ͬһ�����Ұ���2�ż����ϲ�ͬ�Ŀγ�
		//�ж�����:����,�γ�,ʱ��,һ��������ͬһʱ��,ֻ������ͬһ�ſγ�
		$sql = "select `�γ�` as NUM from edu_schedule where `ѧ��`='$CurXueQi' and `����`='$fixedClassroom' and `�γ�`!='$CourseName' and `����`='$Week' and `�ڴ�`='$JieCi'";
		$rs = $db->Execute($sql);
		//print $sql.";<BR>";
		$rs_a = $rs->GetArray();
		//print_R($rs_a);
		//exit;
		if(strlen($rs_a[0]['�γ�'])>0)		{
			print $returnText .= "<font color=red><B>* ����:".$fixedClassroom." �γ�:".$CourseName." �Ѿ������а༶�Ͽ�,һ��������ͬһʱ��,ֻ������ͬһ�ſγ̣�<BR>������ͻ,�����ſ�</B></font><BR>";
			//���»�ȡ����
			$returnCourseStatistics = '';
			$returnCourseStatistics = returnCourseStatistics($CurXueQi,$ClassCode);
			$returnCourseStatistics!=""?$returnCourseStatistics="::".$returnCourseStatistics:'';
			print $returnCourseStatistics;
			exit;
		}
		//�γ����ſγ̵Ŀ�ʱ���żƻ�

		//���ſγ���Ϣ
		$sql = "insert into edu_schedule values('','$CurXueQi','$ClassCode','$fixedClassroom','$TeacherName','$CourseName','$Week','$JieCi');";
		$rs = $db->Execute($sql);
		$returnText .= "<font color=green><B>* ��λ�ð��ſγ̳ɹ���</B></font><BR>";
		//���»�ȡ����
		$returnCourseStatistics = '';
		$returnCourseStatistics = returnCourseStatistics($CurXueQi,$ClassCode);
		$returnCourseStatistics!=""?$returnCourseStatistics="::".$returnCourseStatistics:'';
		print $returnText;
		print $returnCourseStatistics;
		exit;
	}
	//�γ�ȡ������
	if($_GET['checkAction']=="nodo")		{

		//�ж��Ƿ�ð��ڸ�ʱ��ΰ����п�
		$sql = "select count(`����`) as NUM from edu_schedule where `ѧ��`='$CurXueQi' and `�༶`='$ClassCode' and `����`='$Week' and `�ڴ�`='$JieCi'";
		$rs = $db->Execute($sql);
		if($rs->fields['NUM']>0)		{
			$sql = "delete from edu_schedule where `ѧ��`='$CurXueQi' and `�༶`='$ClassCode' and `����`='$Week' and `�ڴ�`='$JieCi'";
			$rs = $db->Execute($sql);
			$returnText = "<font color=green><B>* ��λ�ÿγ���Ϣȡ���ɹ���</B></font><BR>";
			//���»�ȡ����
			$returnCourseStatistics = '';
			$returnCourseStatistics = returnCourseStatistics($CurXueQi,$ClassCode);
			$returnCourseStatistics!=""?$returnCourseStatistics="::".$returnCourseStatistics:'';
			print $returnText;
			print $returnCourseStatistics;
			exit;
		}
		else	{
			print $returnText .= "<font color=red><B>* ��λ�ÿγ���Ϣ�����ڣ�</B></font><BR>";
			//���»�ȡ����
			$returnCourseStatistics = '';
			$returnCourseStatistics = returnCourseStatistics($CurXueQi,$ClassCode);
			$returnCourseStatistics!=""?$returnCourseStatistics="::".$returnCourseStatistics:'';
			print $returnCourseStatistics;
			exit;
		}

	}
	$returnCourseStatistics = '';
	$returnCourseStatistics = returnCourseStatistics($CurXueQi,$ClassCode);
	$returnCourseStatistics!=""?$returnCourseStatistics="::".$returnCourseStatistics:'';
	print $returnCourseStatistics;
	//print $_SERVER['QUERY_STRING'];

}

//##############################################################################
//�����ſ���Ϣ��Ϊ������Ϣ
else		{
	print "û������";
}
/*
   ��ˮ��  int(44)   ��    auto_increment
   ѧ��  varchar(40)   ��
   �༶  varchar(40)   ��
   ����  varchar(40)   ��
   ��ʦ  varchar(40)   ��
   �γ�  varchar(40)   ��
   ����  varchar(40)   ��
   �ڴ�  varchar(40)

*/


function returnCourseStatistics($CurXueQi,$ClassCode)		{
	global $db;
	//���Ѿ����ŵĿγ̽��г�ʼ������
	$sql = "select * from edu_schedule where `ѧ��`='$CurXueQi' and `�༶`='$ClassCode'";
	$rs = $db->Execute($sql);
	$rs_a = $rs->GetArray();
	$Row = array();
	for($i=0;$i<sizeof($rs_a);$i++)		{
		$Week = $rs_a[$i]['����'];
		$JieCi = $rs_a[$i]['�ڴ�'];
		$CourseName = $rs_a[$i]['�γ�'];
		if($JieCi!=0&&$JieCi!=5)	{
			$Row[$CourseName] += 1;
		}
		else	{
			$Row[$CourseName] += 1;
		}
	}
	$Text = "";
	$CourseNameArray = @array_keys($Row);
	sort($CourseNameArray);
	for($i=0;$i<sizeof($CourseNameArray);$i++)		{
		$CourseNameText = $CourseNameArray[$i];
		$Text .= "";
		$Text .= "<font  color=green><B>".$CourseNameText.":".$Row[$CourseNameText]."<B></font>��";
		$Text .= "";
	}
	return $Text;
}
?>
