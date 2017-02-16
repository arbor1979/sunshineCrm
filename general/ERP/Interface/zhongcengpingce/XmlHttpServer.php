<?php
ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL);

// display warnings and errors
error_reporting(E_WARNING | E_ERROR);

header("Content-Type:text/html;charset=gbk");
require_once('lib.inc.php');

$GLOBAL_SESSION=returnsession();
$SYSTEM_PRIV_STOP = 1;

//print "徐红梅,邱小方,安喆,陈欣,陈欣,邓亿书,杜春友,傅镜,付娜,龚旭,郭巧,郭杨,郭宜华,何丽娟,何小平,黄炼,黄楠,江燕,蒋红,蒋惠,李新,李媛,刘舸扬,刘仕彬,罗曼林,罗强,任冬敏,申宇莲,唐茜,王丹,王香,魏晓静,温晓梅,吴灵维,熊利英,熊学林,徐静,徐燕,薛亮,杨春萌,杨朔,袁世英,袁英淑,张静,张莉,赵丽娟,周圣川,周瑜,朱继燕,邹英,邹乘德,单本毅,费太春,廖春霞,姜雪梅,刘庆,杨腾;100001,100010,100159,100160,100161,100162,100163,100164,100165,100166,100167,100168,100169,100170,100171,100172,100173,100174,100175,100176,100178,100179,100180,100181,100182,100183,100184,100185,100187,100188,100189,100190,100191,100192,100193,100194,100195,100196,100197,100198,100199,100200,100201,100202,100203,100205,100206,100207,100208,100209,100325,100334,100347,100348,100355,100356,100392没有数据";exit;
global $db;
//##############################################################################
//排课：从课程得到教师名称
/*
if($_GET['action']=="showdatas"&&$_GET['selectName']!="")
{
	$tablename = "dict_countrycode";
	$field_value = "countryCode";
	$field_name = "countryName";
	$专业代码 = $_GET['专业代码'];
	$级别 = $_GET['级别'];
	$课程名称 = $_GET['selectName'];

	$sql = "select 教课老师 from edu_plan where 级别='$级别' and 专业代码='$专业代码' and 课程名称='$课程名称'";
	$newarray = array();
	$newarray1 = array();
	$newarray2 = array();
	$rs=$db->Execute($sql);
	$rs_a=$rs->GetArray();
	for($i=0;$i<sizeof($rs_a);$i++)		{
		$newarray1[$i]=$rs_a[$i]['教课老师'];
		$newarray2[$i]=$rs_a[$i]['教课老师'];
	}
	print join(',',$newarray1);
	print ";";
	print join(',',$newarray2);
	exit;
}
*/
///*以下为旧版处理方式,新版本从教学计划中获取对应信息
if($_GET['action']=="showdatas"&&$_GET['selectName']!="")
{
	$tablename = "dict_countrycode";
	$field_value = "countryCode";
	$field_name = "countryName";
	//###################################################################################
	//处理班级所对应的带课老师信息####################################################
	$SCHOOL_MODEL = parse_ini_file("SCHOOL_MODEL.ini");
	$SCHOOL_MODEL_TEXT = $SCHOOL_MODEL['SCHOOL_MODEL'];
	//print $SCHOOL_MODEL_TEXT;exit;
	$班级名称 = $_GET['班级名称'];
	$课程名称 = $_GET['selectName'];
	$newarray1 = array();
	$newarray2 = array();

	if($SCHOOL_MODEL_TEXT=="4")			{
		//根据学期过滤教师上课信息
		$NewArray开课教师 = array();
		$NewArray课程名称 = array();
		//$级别 = returntablefield("edu_banji","班级名称",$ClassCode,"入学年份");
	if($_GET['CurXueQi']!="")
		$开课学期	=	$_GET['CurXueQi'];
	else if($_GET['开课学期']!="")
		$开课学期	=	$_GET['开课学期'];
	else
		$开课学期	=	returntablefield("edu_xueqiexec","当前学期",'1',"学期名称");
		$sql = "select 开课教师 from edu_planexec where 班级名称='".$班级名称."' and 开课学期='$开课学期' and 课程名称='$课程名称' order by 教师用户名,班级代码";
		$rs = $db->Execute($sql);
		$rs_a = $rs->GetArray();
		for($ii=0;$ii<sizeof($rs_a);$ii++)		{
			//$TeacherUsername = returntablefield('edu_teacher2',"真实姓名",$rs_a[$ii]['开课教师'],"用户名");
			$TeacherUsername = returntablefield('user',"USER_NAME",$rs_a[$ii]['开课教师'],"USER_ID");
			$newarray1[$ii]=$rs_a[$ii]['开课教师'];
			$newarray2[$ii]=$TeacherUsername;
		}
	}


	if($SCHOOL_MODEL_TEXT=="1"||$SCHOOL_MODEL_TEXT=="2"||$SCHOOL_MODEL_TEXT=="3")			{
	if($_GET['CurXueQi']!="")
		$开课学期	=	$_GET['CurXueQi'];
	else if($_GET['开课学期']!="")
		$开课学期	=	$_GET['开课学期'];
	else
		$开课学期	=	returntablefield("edu_xueqiexec","当前学期",'1',"学期名称");
	//替换原有学期索引的作法,新的方案采用学期名称的方式,去除原有换算的方法 2010-07-21

	$sql = "select distinct 开课教师 from edu_planexec where 班级名称='".$_GET['班级名称']."' and 级别 = '$NJ' and 开课学期='$开课学期' and 课程名称='".$_GET['selectName']."'";
	$rs = $db->Execute($sql);
	$rs_a = $rs->GetArray();
	//print_R($rs_a);
	for($ii=0;$ii<sizeof($rs_a);$ii++)		{
		//$TeacherUsername = returntablefield('edu_teacher2',"真实姓名",$rs_a[$ii]['开课教师'],"用户名");
		$TeacherUsername = returntablefield('user',"USER_NAME",$rs_a[$ii]['开课教师'],"USER_ID");
		$newarray2[] = $TeacherUsername;
		$newarray1[$TeacherUsername] = $rs_a[$ii]['开课教师'];
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
//构建排课信息行为返回信息
if($_GET['action']=="Schedule"&&$_GET['selectName']!="")
{
	//;action=Schedule&ClassCode=2002级二班&TeacherName=&fixedClassroom=1002&CourseName=&selectName=4&checkAction=doit
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

	//以下三个条件为全局条件，在插入和删除时都用到，所以放入此处
	if($CurXueQi==""||$CurXueQi=="undefined")		{
		print $returnText .= "<font color=red><B>* 学期信息没有设定，请先设定学期信息！</B></font><BR>";
		exit;
	}
	if($ClassCode=="")		{
		print $returnText .= "<font color=red><B>* 班级信息没有设定，请先选择班级信息！</B></font><BR>";
		exit;
	}
	if($fixedClassroom=="")	{
		print $returnText .= "<font color=red><B>* 固定教室没有设定，请在班级管理里面，为该班级设定其固定教室！</B></font><BR>";
		exit;
	}

	//以下是课时计划统计结果代码样例
	//$returnCourseStatistics = '';
	//$returnCourseStatistics = returnCourseStatistics($CurXueQi,$ClassCode);
	//$returnCourseStatistics!=""?$returnCourseStatistics="::".$returnCourseStatistics:'';



	//课程新建操作
	if($_GET['checkAction']=="doit")		{

		//以下两个条件只在插入课表时间用到，所以加入此处
		if($CourseName=="")		{
			print $returnText .= "<font color=red><B>* 课程信息没有设定，请先设定课程信息！</B></font><BR>";
			exit;
		}
		if($TeacherName=="")	{
			print $returnText .= "<font color=red><B>* 教师名称没有设定，请先设定教师名称！</B></font><BR>";
			exit;
		}

		//判断教室是否冲突
		$sql = "select count(`教室`) as NUM from edu_schedule where `学期`='$CurXueQi' and `班级`='$ClassCode' and `星期`='$Week' and `节次`='$JieCi'";
		$rs = $db->Execute($sql);
		if($rs->fields['NUM']>0)		{
			print $returnText .= "<font color=red><B>* 该教室在该时间已经安按有课程！<BR>明细如下：*******</B></font><BR>";
			//重新获取数据
			$returnCourseStatistics = '';
			$returnCourseStatistics = returnCourseStatistics($CurXueQi,$ClassCode);
			$returnCourseStatistics!=""?$returnCourseStatistics="::".$returnCourseStatistics:'';
			print $returnCourseStatistics;
			exit;
		}
		//判断教师是否冲突 学期－班级－星期－节次
		$sql = "select count(教师) as NUM from edu_schedule where `学期`='$CurXueQi' and `班级`='$ClassCode' and `星期`='$Week' and `节次`='$JieCi'";
		$rs = $db->Execute($sql);
		if($rs->fields['NUM']>0)		{
			print $returnText .= "<font color=red><B>* 该教师在该时间已经安按有课程！<BR>明细如下：*******</B></font><BR>";
			//重新获取数据
			$returnCourseStatistics = '';
			$returnCourseStatistics = returnCourseStatistics($CurXueQi,$ClassCode);
			$returnCourseStatistics!=""?$returnCourseStatistics="::".$returnCourseStatistics:'';
			print $returnCourseStatistics;
			exit;
		}
		//形成已排课程的课时安排计划
		//1.查询“2001级一班”的课表信息时显示星期一上午第二节： 课程：语文 　教师：聂海 　教室：1001
		//2.查询“2001级二班”的课表信息时显示星期一上午第二节： 课程：语文 　教师：聂海 　教室：1111
		//判断一个老师-班级-教室条件,合班上课时教室只能一个,所以教室要=值判断
		$sql = "select `课程`,班级,教室 from edu_schedule where `学期`='$CurXueQi' and `教室`='$fixedClassroom' and `教师`='$TeacherName' and `星期`='$Week' and `节次`='$JieCi'";
		$rs = $db->Execute($sql);
		//print $sql.";<BR>";
		$rs_a = $rs->GetArray();
		//print_R($rs_a);
		//exit;
		//形成已排课程的课时安排计划
		//为了支持合班情况上课,特把判断条件改为:课程,合班时课程为一样的
		if($rs_a[0]['课程']!=$CourseName&&$rs_a[0]['课程']!="")		{
			print $returnText .= "<font color=red><B>* ".$TeacherName."老师已经在".$rs_a[0]['教室']."所带\"".$rs_a[0]['课程']."\"课程,不能再安排\"".$CourseName."\"课程同一老师不能在同一时间和教室上不同的课程！<BR>条件冲突,请新排课</B></font><BR>";
			//重新获取数据
			$returnCourseStatistics = '';
			$returnCourseStatistics = returnCourseStatistics($CurXueQi,$ClassCode);
			$returnCourseStatistics!=""?$returnCourseStatistics="::".$returnCourseStatistics:'';
			print $returnCourseStatistics;
			exit;
		}
		//合班时,可以在已经有的课程里面加入其它班级,判断冲突条件为:课程,所以此处判断条件为最多三个班一起上课
		if($rs_a[3]['班级']!="")		{
			print $returnText .= "<font color=red><B>* ".$TeacherName."老师已经".$rs_a[0]['教室']."所带".$CourseName."课程,上课班级为:".$rs_a[0]['班级'].",".$rs_a[1]['班级'].",".$rs_a[2]['班级']."<BR>条件冲突,请新排课</B></font><BR>";
			//重新获取数据
			$returnCourseStatistics = '';
			$returnCourseStatistics = returnCourseStatistics($CurXueQi,$ClassCode);
			$returnCourseStatistics!=""?$returnCourseStatistics="::".$returnCourseStatistics:'';
			print $returnCourseStatistics;
			exit;
		}
		//正常条件下面判断人数是否超载
		//教室座位数
		$ClassroomNumber = returntablefield("edu_classroom","教室名称",$fixedClassroom,"座位数");
		//新班级人数
		$ClassNumber = returnClassNumber($ClassCode);
		//现有情况只排一个班级时
		if($rs_a[0]['班级']!="")		{
			$OneClassNumber = returnClassNumber($rs_a[0]['班级']);
			$CheckNumber = $OneClassNumber+$ClassNumber;
			if($CheckNumber>$ClassroomNumber)			{
				//将要排进去该班的人数超过该教室最大的容纳数量
				print "<font color=red><B>教室($fixedClassroom)座位数:$ClassroomNumber,已经安装班级人数:$OneClassNumber,将要安排班级人数:$ClassNumber,合起来为:$CheckNumber,超过该教室的最大容纳值:$ClassroomNumber,故排课失败,如果执行本次操作,请在教室管理里面重新调高教室($fixedClassroom)的座位数($ClassroomNumber),以满足排课条件要求.排课中断</B></font>";
				exit;
			}
		}
		//现有情况有两个班级时
		if($rs_a[1]['班级']!="")		{
			$OneClassNumber = returnClassNumber($rs_a[0]['班级']);
			$TwoClassNumber = returnClassNumber($rs_a[1]['班级']);
			$CheckNumber = $OneClassNumber+$TwoClassNumber+$ClassNumber;
			if($CheckNumber>$ClassroomNumber)			{
				//将要排进去该班的人数超过该教室最大的容纳数量
				print "<font color=red><B>教室($fixedClassroom)座位数:$ClassroomNumber,已经安装班级人数:".$OneClassNumber."和$TwoClassNumber,将要安排班级人数:$ClassNumber,合起来为:$CheckNumber,超过该教室的最大容纳值:$ClassroomNumber,故排课失败,如果执行本次操作,请在教室管理里面重新调高教室($fixedClassroom)的座位数($ClassroomNumber),以满足排课条件要求.排课中断</B></font>";
				exit;
			}
		}
		//print $ClassroomNumber;
		//print $ClassNumber;exit;




		//形成已排课程的课时安排计划
		//处理:按班排课中可以将同一个教室安排2门及以上不同的课程
		//判断条件:教室,课程,时间,一个教室在同一时间,只允许上同一门课程
		$sql = "select `课程` as NUM from edu_schedule where `学期`='$CurXueQi' and `教室`='$fixedClassroom' and `课程`!='$CourseName' and `星期`='$Week' and `节次`='$JieCi'";
		$rs = $db->Execute($sql);
		//print $sql.";<BR>";
		$rs_a = $rs->GetArray();
		//print_R($rs_a);
		//exit;
		if(strlen($rs_a[0]['课程'])>0)		{
			print $returnText .= "<font color=red><B>* 教室:".$fixedClassroom." 课程:".$CourseName." 已经安排有班级上课,一个教室在同一时间,只允许上同一门课程！<BR>条件冲突,请新排课</B></font><BR>";
			//重新获取数据
			$returnCourseStatistics = '';
			$returnCourseStatistics = returnCourseStatistics($CurXueQi,$ClassCode);
			$returnCourseStatistics!=""?$returnCourseStatistics="::".$returnCourseStatistics:'';
			print $returnCourseStatistics;
			exit;
		}
		//形成已排课程的课时安排计划

		//安排课程信息
		$sql = "insert into edu_schedule values('','$CurXueQi','$ClassCode','$fixedClassroom','$TeacherName','$CourseName','$Week','$JieCi');";
		$rs = $db->Execute($sql);
		$returnText .= "<font color=green><B>* 该位置安排课程成功！</B></font><BR>";
		//重新获取数据
		$returnCourseStatistics = '';
		$returnCourseStatistics = returnCourseStatistics($CurXueQi,$ClassCode);
		$returnCourseStatistics!=""?$returnCourseStatistics="::".$returnCourseStatistics:'';
		print $returnText;
		print $returnCourseStatistics;
		exit;
	}
	//课程取消操作
	if($_GET['checkAction']=="nodo")		{

		//判断是否该班在该时间段安排有课
		$sql = "select count(`教室`) as NUM from edu_schedule where `学期`='$CurXueQi' and `班级`='$ClassCode' and `星期`='$Week' and `节次`='$JieCi'";
		$rs = $db->Execute($sql);
		if($rs->fields['NUM']>0)		{
			$sql = "delete from edu_schedule where `学期`='$CurXueQi' and `班级`='$ClassCode' and `星期`='$Week' and `节次`='$JieCi'";
			$rs = $db->Execute($sql);
			$returnText = "<font color=green><B>* 该位置课程信息取消成功！</B></font><BR>";
			//重新获取数据
			$returnCourseStatistics = '';
			$returnCourseStatistics = returnCourseStatistics($CurXueQi,$ClassCode);
			$returnCourseStatistics!=""?$returnCourseStatistics="::".$returnCourseStatistics:'';
			print $returnText;
			print $returnCourseStatistics;
			exit;
		}
		else	{
			print $returnText .= "<font color=red><B>* 该位置课程信息不存在！</B></font><BR>";
			//重新获取数据
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
//构建排课信息行为返回信息
else		{
	print "没有数据";
}
/*
   流水号  int(44)   否    auto_increment
   学期  varchar(40)   否
   班级  varchar(40)   否
   教室  varchar(40)   否
   教师  varchar(40)   否
   课程  varchar(40)   否
   星期  varchar(40)   否
   节次  varchar(40)

*/


function returnCourseStatistics($CurXueQi,$ClassCode)		{
	global $db;
	//对已经安排的课程进行初始化操作
	$sql = "select * from edu_schedule where `学期`='$CurXueQi' and `班级`='$ClassCode'";
	$rs = $db->Execute($sql);
	$rs_a = $rs->GetArray();
	$Row = array();
	for($i=0;$i<sizeof($rs_a);$i++)		{
		$Week = $rs_a[$i]['星期'];
		$JieCi = $rs_a[$i]['节次'];
		$CourseName = $rs_a[$i]['课程'];
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
		$Text .= "<font  color=green><B>".$CourseNameText.":".$Row[$CourseNameText]."<B></font>　";
		$Text .= "";
	}
	return $Text;
}
?>
