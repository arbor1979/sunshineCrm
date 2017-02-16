<?php
ini_set('date.timezone','Asia/Shanghai');
ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL);

// display warnings and errors
error_reporting(E_WARNING | E_ERROR);


//初始化教师考勤表,更新0为7  2010-9-30日放到定时任务管理器里面进行执行
//$sql = "update edu_teacherkaoqinmingxi set 星期='7' where 星期='0'";
//$db->Execute($sql);
//自动处理没有毕业的班级  2010-9-30日放到定时任务管理器里面进行执行
//$sql = "update edu_banji set IsGrad='0' where 毕业时间>='".date('Y-m-d')."'";
//$db->Execute($sql);

function 插入教学考勤信息($学期,$教师,$教师用户名,$考勤日期,$上课时间,$教室,$课程,$班级,$节次)					{
	global $db;
	global $KaoqinTimeBegin1,$KaoqinTimeBegin2,$KaoqinTimeEnd1,$KaoqinTimeEnd2,$KuangGongShiJian;

		$应该填写时间 = $上课时间;
		$上课时间Array = explode('-',$上课时间);
		$最迟填写时间 = date("Y-m-d",mktime(1,1,1,$上课时间Array[1],$上课时间Array[2]+5,$上课时间Array[0]));
		$星期 = date("w",mktime(1,1,1,$上课时间Array[1],$上课时间Array[2],$上课时间Array[0]));
		$节次Array = explode('-',$节次);
		$安排内容 = returnJieCiName($节次Array[0]);
		$有效时间 = returnJieCiTime($安排内容);
		$有效时间Array = explode('-',$有效时间);
		$有效时间0Array = explode(':',$有效时间Array[0]);
		$有效时间1Array = explode(':',$有效时间Array[1]);
		global $SYSTEM_MERGE_CLASSTABLE;
		if($节次Array[1]!=""&&$SYSTEM_MERGE_CLASSTABLE = "1")		{
			$安排内容 = returnJieCiName($节次Array[1]);
			$有效时间 = returnJieCiTime($安排内容);
			$有效时间Array = explode('-',$有效时间);
			$有效时间1Array = explode(':',$有效时间Array[1]);
		}

		$上课刷卡BGN = date("H:i",@mktime($有效时间0Array[0],$有效时间0Array[1]-$KaoqinTimeBegin1,30,12,12,2008));
		$上课刷卡END = date("H:i",@mktime($有效时间0Array[0],$有效时间0Array[1]+$KaoqinTimeBegin2,30,12,12,2008));
		$下课刷卡BGN = date("H:i",@mktime($有效时间1Array[0],$有效时间1Array[1]-$KaoqinTimeEnd1,30,12,12,2008));
		$下课刷卡END = date("H:i",@mktime($有效时间1Array[0],$有效时间1Array[1]+$KaoqinTimeEnd2,30,12,12,2008));

		$Element['教师姓名'] = $教师;
		$Element['教师用户名'] = $教师用户名;
		$Element['考勤日期'] = $考勤日期;
		$Element['周次'] = returnCurWeekIndex($考勤日期);
		$Element['教室'] = $教室;
		$Element['课程'] = $课程;
		$Element['班级'] = $班级;
		$Element['星期'] = $星期;
		$Element['节次'] = $节次;
		$Element['周次'] = returnCurWeekIndex($上课时间);
		$Element['学期'] = $学期;
		$Element['应该填写时间'] = $应该填写时间;
		$Element['最迟填写时间'] = date("Y-m-d",mktime(1,1,1,$上课时间Array[1],$上课时间Array[2]+7,$上课时间Array[0]));
		$Element['上课实际刷卡'] = '';
		$Element['上课考勤状态'] = '';
		$Element['下课实际刷卡'] = '';
		$Element['下课考勤状态'] = '';
		$Element['上课刷卡BGN'] = $上课刷卡BGN;
		$Element['上课刷卡END'] = $上课刷卡END;
		$Element['下课刷卡BGN'] = $下课刷卡BGN;
		$Element['下课刷卡END'] = $下课刷卡END;
		$ElementValue = array_values($Element);
		$sqlValueText = "'".join("','",$ElementValue)."'";
		$ElementName = array_keys($Element);
		$sqlNameText = "`".join("`,`",$ElementName)."`";
		$sql = "insert into edu_teacherkaoqinmingxi($sqlNameText) values($sqlValueText)";
		//print $sql."<BR>";
		$db->Execute($sql);
		//print $sql;exit;
}


function useridtoname($组员名称)			{
	global $db;
	$USER_NAME_TEXT = '';
	$组员名称Array = explode(',',$组员名称);
	for($i=0;$i<sizeof($组员名称Array);$i++)		{
		if($组员名称Array[$i]!="")	{
			$USER_NAME	= returntablefield("user","USER_ID",$组员名称Array[$i],"USER_NAME");
			if($USER_NAME=="") $USER_NAME =	$组员名称Array[$i];
			$USER_NAME_TEXT	.= $USER_NAME.",";
		}


	}
	return $USER_NAME_TEXT;
}

function usernametoid($组员名称)			{
	global $db;
	$USER_NAME_TEXT = '';
	$组员名称Array = explode(',',$组员名称);
	for($i=0;$i<sizeof($组员名称Array);$i++)		{
		if($组员名称Array[$i]!="")	{
			$USER_NAME	= returntablefield("user","USER_NAME",$组员名称Array[$i],"USER_ID");
			if($USER_NAME=="") $USER_NAME =	$组员名称Array[$i];
			$USER_NAME_TEXT	.= $USER_NAME.",";
		}

	}
	return $USER_NAME_TEXT;
}


//修正增加教师用户名带来的空字段信息
function 修正增加教师用户名带来的空字段信息()		{

	/*
	修正增加教师用户名带来的空字段信息_子函数('edu_schedule','教师');
	修正增加教师用户名带来的空字段信息_子函数('edu_schedule2','教师');
	修正增加教师用户名带来的空字段信息_子函数('edu_teacherkaoqinmingxi','教师姓名');
	修正增加教师用户名带来的空字段信息_子函数('edu_teacherkaoqinbudeng','教师');
	修正增加教师用户名带来的空字段信息_子函数('edu_schedulefenduanjiaoxue','教师');
	修正增加教师用户名带来的空字段信息_子函数('edu_scheduletiaoke','教师');
	修正增加教师用户名带来的空字段信息_子函数('edu_scheduletingkefuke','教师');
	修正增加教师用户名带来的空字段信息_子函数('edu_schedulechange','原教师','原教师用户名');
	修正增加教师用户名带来的空字段信息_子函数('edu_schedulechange','新教师','新教师用户名');
	修正增加教师用户名带来的空字段信息_子函数('edu_scheduledaike','原教师','原教师用户名');
	修正增加教师用户名带来的空字段信息_子函数('edu_scheduledaike','新教师','新教师用户名');
	修正增加教师用户名带来的空字段信息_子函数('edu_scheduletiaokexianghu','原教师','原教师用户名');
	修正增加教师用户名带来的空字段信息_子函数('edu_scheduletiaokexianghu','新教师','新教师用户名');
	修正增加教师用户名带来的空字段信息_子函数('edu_jiaoxuerijibudeng','教师');
	修正增加教师用户名带来的空字段信息_子函数('edu_planexec','开课教师');
	//修正增加教师用户名带来的空字段信息_子函数('edu_planexec_middleschool','开课教师');
	修正增加教师用户名带来的空字段信息_子函数('edu_kechoujisuan','教师名称');
	修正增加教师用户名带来的空字段信息_子函数('edu_kechouqita','教师');
	修正增加教师用户名带来的空字段信息_子函数('edu_kechoujiaofu','教师');
	修正增加教师用户名带来的空字段信息_子函数('edu_kechouqita','教师');
	修正增加教师用户名带来的空字段信息_子函数('edu_pingjiamingxi','教师');
	*/

}
function 修正增加教师用户名带来的空字段信息_子函数($tablename,$教师='教师',$教师用户名='教师用户名')		{
	global $db,$CurXueQi;

	$sql = "select COUNT(*) AS NUM from $tablename where $教师用户名=''";
	$rs = $db->Execute($sql);
	$rs_a = $rs->GetArray();
	$NUM = $rs_a[0]['NUM'];;
	if($NUM>0)		{
		$sql = "select distinct $教师 from $tablename where $教师用户名=''";
		$rs = $db->Execute($sql);
		$rs_a = $rs->GetArray();
		for($i=0;$i<sizeof($rs_a);$i++)				{
			$教师姓名X = $rs_a[$i][$教师];
			$教师用户名X = returntablefield('user',"USER_NAME",$教师姓名X,"USER_ID");
			$sql = "update $tablename set $教师用户名='$教师用户名X' where $教师='$教师姓名X'";
			$db->Execute($sql);
			//print $sql."<BR>";
		}//exit;
		$sql = "delete from $tablename where $教师用户名=''";
		$db->Execute($sql);
		//print $sql."<BR>";
	}
}


//修正教师停课复课操作信息
function 修正教师停课复课操作信息()  {
	global $db,$CurXueQi;
	global $KaoqinTimeBegin1,$KaoqinTimeBegin2,$KaoqinTimeEnd1,$KaoqinTimeEnd2,$KuangGongShiJian;

	// and 教师='孙跃岗'
	$sql = "select * from edu_scheduletingkefuke where 停课审核状态='1' and 学期='$CurXueQi'";
	$rs = $db->Execute($sql);
	$rsX_a = $rs->GetArray();
	//print_R($rs_a);
	for($XX=0;$XX<sizeof($rsX_a);$XX++)				{
		//print sizeof($rsX_a);
		$编号		= $rsX_a[$XX]['编号'];
		$班级		= $rsX_a[$XX]['班级'];
		$教师		= $rsX_a[$XX]['教师'];
		$教师用户名	= $rsX_a[$XX]['教师用户名'];
		$教室		= $rsX_a[$XX]['教室'];
		$原上课时间 = $rsX_a[$XX]['原上课时间'];
		$原节次		= $rsX_a[$XX]['原节次'];
		$新上课时间 = $rsX_a[$XX]['新上课时间'];
		$新节次		= $rsX_a[$XX]['新节次'];
		$复课审核状态	= $rsX_a[$XX]['复课审核状态'];
		$课程		= $rsX_a[$XX]['课程'];
		//无论状态如何,都要先进行赋0000-00-00操作
		if($编号!=""&&$复课审核状态!='1')			{
			//删除的操作很少见,加入此操作是因为之前初始化时把已经停课的记录重新加入到考勤列表中去,现在重新过滤出去
			//停课复课的操作是通过把日期改为0000-00-00的形式来实现的,而不是删除和新增操作,是一个零和的操作,不会新带来数据或减少数据
			$sql = "update edu_teacherkaoqinmingxi
					set 应该填写时间='0000-00-00',考勤日期='0000-00-00',最迟填写时间='0000-00-00'
					where 班级='$班级' and 教师姓名='$教师' and 教师用户名='$教师用户名' and 考勤日期='$原上课时间' and 节次='$原节次' and 学期='$CurXueQi'";
			$db->Execute($sql);
			global $SHOWTEXT; if($SHOWTEXT)print "<BR>修正教师停课复课操作信息:".$sql."<BR>";
		}
		if($编号!=""&&$复课审核状态=='1')			{
			//同步刷卡时间
			$新节次Array = explode('-',$新节次);
			global $SYSTEM_MERGE_CLASSTABLE;
			if($新节次Array[1]!=""&&$SYSTEM_MERGE_CLASSTABLE = "1")					{
				$returnJieCiName1 = returnJieCiName($新节次Array[0]);
				$returnJieCiName2 = returnJieCiName($新节次Array[1]);
				$sql = "select 时间段 from edu_timesetting where 安排内容='$returnJieCiName1'";
				$rs = $db->Execute($sql);;
				$时间段1Array = explode('-',$rs->fields['时间段']);
				$sql = "select 时间段 from edu_timesetting where 安排内容='$returnJieCiName2'";
				$rs = $db->Execute($sql);;
				$时间段2Array = explode('-',$rs->fields['时间段']);
				$有效时间0Array = explode(':',$时间段1Array[0]);
				$有效时间1Array = explode(':',$时间段2Array[1]);

				$上课刷卡BGN = date("H:i",@mktime($有效时间0Array[0],$有效时间0Array[1]-$KaoqinTimeBegin1,30,12,12,2008));
				$上课刷卡END = date("H:i",@mktime($有效时间0Array[0],$有效时间0Array[1]+$KaoqinTimeBegin2,30,12,12,2008));
				$下课刷卡BGN = date("H:i",@mktime($有效时间1Array[0],$有效时间1Array[1]-$KaoqinTimeEnd1,30,12,12,2008));
				$下课刷卡END = date("H:i",@mktime($有效时间1Array[0],$有效时间1Array[1]+$KaoqinTimeEnd2,30,12,12,2008));
				$TempSQL = ",上课刷卡BGN='$上课刷卡BGN',
							上课刷卡END='$上课刷卡END',
							下课刷卡BGN='$下课刷卡BGN',
							下课刷卡END='$下课刷卡END'";
			}
			else	{
				$returnJieCiName1 = returnJieCiName($新节次Array[0]);
				$sql = "select 时间段 from edu_timesetting where 安排内容='$returnJieCiName1'";
				$rs = $db->Execute($sql);;
				$时间段1Array = explode('-',$rs->fields['时间段']);
				$有效时间0Array = explode(':',$时间段1Array[0]);
				$有效时间1Array = explode(':',$时间段1Array[1]);

				$上课刷卡BGN = date("H:i",@mktime($有效时间0Array[0],$有效时间0Array[1]-$KaoqinTimeBegin1,30,12,12,2008));
				$上课刷卡END = date("H:i",@mktime($有效时间0Array[0],$有效时间0Array[1]+$KaoqinTimeBegin2,30,12,12,2008));
				$下课刷卡BGN = date("H:i",@mktime($有效时间1Array[0],$有效时间1Array[1]-$KaoqinTimeEnd1,30,12,12,2008));
				$下课刷卡END = date("H:i",@mktime($有效时间1Array[0],$有效时间1Array[1]+$KaoqinTimeEnd2,30,12,12,2008));
				$TempSQL = ",上课刷卡BGN='$上课刷卡BGN',
							上课刷卡END='$上课刷卡END',
							下课刷卡BGN='$下课刷卡BGN',
							下课刷卡END='$下课刷卡END'";
			}
			//同步调课信息到教师考勤数据表
			$周次 = returnCurWeekIndex($新上课时间);
			$应该填写时间 = $新上课时间;
			$新上课时间Array = explode('-',$新上课时间);
			$最迟填写时间 = date("Y-m-d",mktime(1,1,1,$新上课时间Array[1],$新上课时间Array[2]+5,$新上课时间Array[0]));
			$星期 = date("w",mktime(1,1,1,$新上课时间Array[1],$新上课时间Array[2],$新上课时间Array[0]));
			$sql = "update edu_teacherkaoqinmingxi set 周次='$周次',星期='$星期',应该填写时间='$新上课时间',考勤日期='$新上课时间',节次='$新节次',最迟填写时间='$最迟填写时间' $TempSQL where 班级='$班级' and 课程='$课程' and 教师姓名='$教师' and 教师用户名='$教师用户名' and 节次='$原节次' and 考勤日期='0000-00-00'";
			//删除的操作很少见,加入此操作是因为之前初始化时把已经停课的记录重新加入到考勤列表中去,现在重新过滤出去
			//停课复课的操作是通过把日期改为0000-00-00的形式来实现的,而不是删除和新增操作,是一个零和的操作,不会新带来数据或减少数据
			$db->Execute($sql);
			global $SHOWTEXT; if($SHOWTEXT)print "<BR>修正教师停课复课操作信息:".$sql."<BR>";

				//2010-5-5 9:24 补充较验,如果不存在,则进行插入操作
				//存在记录,重新较验新的记录是否存在
				$sql = "select * from edu_teacherkaoqinmingxi where 学期='$CurXueQi' and 教师姓名='$教师' and 教师用户名='$教师用户名' and 课程='$课程' and 考勤日期='$新上课时间' and 节次='$新节次'";
				$rs = $db->Execute($sql);
				$rs_a = $rs->GetArray();
				$编号X = $rs_a[0]['编号'];
				global $SHOWTEXT; if($SHOWTEXT)print $sql."<BR>";
				if($编号X=="")		{
					$Element['教师姓名'] = $教师;
					$Element['教师用户名'] = $教师用户名;
					$Element['考勤日期'] = $新上课时间;
					$Element['教室'] = $教室;
					$Element['课程'] = $课程;
					$Element['班级'] = $班级;
					$Element['星期'] = $星期;
					$Element['节次'] = $新节次;
					$Element['周次'] = returnCurWeekIndex($新上课时间);
					$Element['学期'] = $CurXueQi;
					$Element['应该填写时间'] = $新上课时间;
					$Element['最迟填写时间'] = date("Y-m-d",mktime(1,1,1,$新上课时间Array[1],$新上课时间Array[2]+7,$新上课时间Array[0]));
					$Element['上课实际刷卡'] = '';
					$Element['上课考勤状态'] = '';
					$Element['下课实际刷卡'] = '';
					$Element['下课考勤状态'] = '';
					$Element['上课刷卡BGN'] = $上课刷卡BGN;
					$Element['上课刷卡END'] = $上课刷卡END;
					$Element['下课刷卡BGN'] = $下课刷卡BGN;
					$Element['下课刷卡END'] = $下课刷卡END;
					$ElementValue = array_values($Element);
					$sqlValueText = "'".join("','",$ElementValue)."'";
					$ElementName = array_keys($Element);
					$sqlNameText = "`".join("`,`",$ElementName)."`";
					$sql = "insert into edu_teacherkaoqinmingxi($sqlNameText) values($sqlValueText)";
					global $SHOWTEXT; if($SHOWTEXT)print $sql."<BR>";
					$db->Execute($sql);
				}	//存在记录,重新较验新的记录是否存在
				//print $XX;
		}
		//print $XX;
	}
}

//修正教师代课异常操作信息
function 修正教师代课异常操作信息()		{
	global $db,$CurXueQi;
	//编号  学期  班级  教室  课程  原教师  新教师  上课时间  节次  审核状态  工作流ID号  审核人  审核时间
	//第一步:判断代课流程正确且结束
	$sql = "select * from edu_scheduledaike where 审核状态='1' and 原教师用户名!='' order by 编号 desc limit 100";
	$rs = $db->Execute($sql);
	$rs_a = $rs->GetArray();
	for($i=0;$i<sizeof($rs_a);$i++)				{
		$原教师 = $rs_a[$i]['原教师'];
		$新教师 = $rs_a[$i]['新教师'];
		$编号	= $rs_a[$i]['编号'];
		$班级	= $rs_a[$i]['班级'];
		$教师	= $rs_a[$i]['教师'];
		$原教师用户名	= $rs_a[$i]['原教师用户名'];
		$新教师用户名	= $rs_a[$i]['新教师用户名'];
		$上课时间 = $rs_a[$i]['上课时间'];
		$节次	= $rs_a[$i]['节次'];
		$课程	= $rs_a[$i]['课程'];
		global $SHOWTEXT; if($SHOWTEXT)	print "<BR><font color=green><B>$sql</B></font><BR>";
		//第二步:判断代刘后的教师是否有课,即是否成功
		//判断新数据是否插入成功
		$sql = "select * from edu_teacherkaoqinmingxi where 学期='$CurXueQi' and 考勤日期='$上课时间' and 教师用户名='$新教师用户名' and 节次='$节次'";
		$rs = $db->Execute($sql);
		$rsX_a = $rs->GetArray();
		global $SHOWTEXT; if($SHOWTEXT)	print "<BR>查询:".$sql."<BR>";
		if($rsX_a[0]['教师姓名']!="")		{
			//新数据加入成功,可以删除原数据
			$sql = "delete from edu_teacherkaoqinmingxi where 班级='$班级' and 教师用户名='$原教师用户名' and 考勤日期='$上课时间' and 节次='$节次' and 学期='$CurXueQi'";
			$db->Execute($sql);
			global $SHOWTEXT; if($SHOWTEXT)	print "<BR>新数据加入成功,可以删除原数据:".$sql."<BR>";
		}
		else	{
			//新数据不存在,则判断原数据是否存在
			$sql = "select * from edu_teacherkaoqinmingxi where 学期='$CurXueQi' and 考勤日期='$上课时间' and 教师用户名='$原教师用户名' and 节次='$节次'";
			$rs = $db->Execute($sql);
			$rsX_a = $rs->GetArray();
			$编号 = $rsX_a[0]['编号'];
			global $SHOWTEXT; if($SHOWTEXT)	print "<BR>查询:".$sql."<BR>";
			if($编号!="")			{
				$sql = "update edu_teacherkaoqinmingxi set 教师姓名='$新教师',教师用户名='$新教师用户名' where 编号='$编号'";
				$db->Execute($sql);
				global $SHOWTEXT; if($SHOWTEXT)	print "<BR>新数据不存在,原数据存在,进行修改操作:".$sql."<BR>";
			}
			else	{
				global $SHOWTEXT; if($SHOWTEXT)	print "<BR>新数据不存在,原数据也不存在,不进行操作<BR>";
			}
		}
	}

}

//修正教师相互调课异常操作信息
function 修正教师相互调课异常操作信息()		{
	global $db,$CurXueQi;
	//第一步:判断代课流程正确且结束
	$sql = "select * from edu_scheduletiaokexianghu where 审核状态='1' order by 编号 desc limit 30";
	$rs = $db->Execute($sql);
	$rs_a = $rs->GetArray();
	for($i=0;$i<sizeof($rs_a);$i++)				{
		$原教师用户名 = $rs_a[$i]['原教师用户名'];
		$原上课时间	= $rs_a[$i]['原上课时间'];
		$原节次	= $rs_a[$i]['原节次'];
		$原课程	= $rs_a[$i]['原课程'];
		$原教师	= $rs_a[$i]['原教师'];
		$新教师用户名	= $rs_a[$i]['新教师用户名'];
		$新上课时间	= $rs_a[$i]['新上课时间'];
		$新节次	= $rs_a[$i]['新节次'];
		$新课程	= $rs_a[$i]['新课程'];
		$新教师	= $rs_a[$i]['新教师'];

		$上课时间 = $rs_a[$i]['上课时间'];
		$节次	= $rs_a[$i]['节次'];
		$课程	= $rs_a[$i]['课程'];
		global $SHOWTEXT; if($SHOWTEXT)	print "<BR><font color=green><B>$sql</B></font><BR>";
		//原教师编号
		$sql = "select 编号 from edu_teacherkaoqinmingxi where 教师姓名='$原教师' and 教师用户名='$原教师用户名' and 节次='$原节次' and 考勤日期='$原上课时间'";
		print $sql."<BR>";
		$rs = $db->Execute($sql);
		$原编号 = $rs->fields['编号'];
		if($原编号!="")			{
			$sql = "update edu_teacherkaoqinmingxi set 教师姓名='$新教师',教师用户名='$新教师用户名',课程='$新课程' where 编号='$原编号'";
			print $sql."<BR>";
			$db->Execute($sql);
		}
		//新教师编号
		$sql = "select 编号 from edu_teacherkaoqinmingxi where 教师姓名='$新教师' and 教师用户名='$新教师用户名' and 节次='$新节次' and 考勤日期='$新上课时间'";
		print $sql."<BR>";
		$rs = $db->Execute($sql);
		$新编号 = $rs->fields['编号'];
		if($新编号!="")			{
			$sql = "update edu_teacherkaoqinmingxi set 教师姓名='$原教师',教师用户名='$原教师用户名',课程='$原课程' where 编号='$新编号'";
			print $sql."<BR>";
			$db->Execute($sql);
		}
	}

}

//修正教学日记里面的班级人数信息
function 修正教学日记里面的班级人数信息()  {
	global $db,$CurXueQi;
	$sql = "select distinct 班级 from edu_teacherkaoqinmingxi where 学期='$CurXueQi'"; // where 执行状态='0'
	$rs = $db->Execute($sql);
	$rs_a = $rs->GetArray();
	$NewArray = array();
	for($i=0;$i<sizeof($rs_a);$i++)				{
		$班级 = $rs_a[$i]['班级'];
		$班级人数 =  returnClassNumber($班级);
		$sql = "update edu_teacherkaoqinmingxi set 班级人数='$班级人数' where 班级='$班级'";
	    $db->Execute($sql);
		$sql = "update edu_teacherkaoqinmingxi set 实到人数='$班级人数' where 班级='$班级' and 实到人数>'$班级人数'";
	    $db->Execute($sql);
		global $SHOWTEXT; if($SHOWTEXT)print "<BR>修正教学日记里面的班级人数信息:".$sql."<BR>";
	}
}



//修正教学日记里面的空周次信息
function 修正教学日记里面的空周次信息()  {
	global $db,$CurXueQi;
	//$sql = "update edu_teacherkaoqinmingxi set 周次='6' where 周次='33'"; // where 执行状态='0'
	//$db->Execute($sql);
	$sql = "select 考勤日期,编号 from edu_teacherkaoqinmingxi where 周次='' and 学期='$CurXueQi'"; // where 执行状态='0'
	$rs = $db->Execute($sql);
	$rs_a = $rs->GetArray();
	for($i=0;$i<sizeof($rs_a);$i++)				{
		$考勤日期 = $rs_a[$i]['考勤日期'];
		$新考勤日期 = returntablefield("edu_schedulejiejiari","调整后上课时间",$考勤日期,"原上课时间");
		if($新考勤日期!="")			{
			$新考勤日期Array = explode('-',$新考勤日期);
			$新考勤日期 = date("Y-m-d",mktime(1,1,1,$新考勤日期Array[1],$新考勤日期Array[2],$新考勤日期Array[0]));
			$考勤日期 = $新考勤日期;
		}
		$编号 = $rs_a[$i]['编号'];
		$周次 =  returnCurWeekIndex($考勤日期);
		$sql = "update edu_teacherkaoqinmingxi set 周次='$周次' where 编号='$编号'"; // where 执行状态='0'
	    $db->Execute($sql);
		global $SHOWTEXT; if($SHOWTEXT)print "<BR>修正教学日记里面的空周次信息:".$sql."<BR>";
	}
}

//修正教学日记里面的空星期信息
function 修正教学日记里面的空星期信息()  {
	global $db,$CurXueQi;
	$sql = "select 考勤日期,编号 from edu_teacherkaoqinmingxi where 星期='' and 学期='$CurXueQi'"; // where 执行状态='0'
	$rs = $db->Execute($sql);
	$rs_a = $rs->GetArray();
	for($i=0;$i<sizeof($rs_a);$i++)				{
		$考勤日期Array = explode('-',$rs_a[$i]['考勤日期']);
		$编号 = $rs_a[$i]['编号'];
		$星期 = date("w",mktime(1,1,1,$考勤日期Array[1],$考勤日期Array[2],$考勤日期Array[0]));
		$sql = "update edu_teacherkaoqinmingxi set 星期='$星期' where 编号='$编号'"; // where 执行状态='0'
	    $db->Execute($sql);
		global $SHOWTEXT; if($SHOWTEXT)print "<BR>修正教学日记里面的空星期信息:".$sql."<BR>";
	}
}

//修正教学日记里面的空周次信息
function 修正学生考勤里面的空座号信息()  {
	global $db,$CurXueQi;
	$sql = "select distinct 学号 from edu_studentkaoqin where 座号='0' and 学期名称='$CurXueQi'"; // where 执行状态='0'
	$rs = $db->Execute($sql);
	$rs_a = $rs->GetArray();
	for($i=0;$i<sizeof($rs_a);$i++)				{
		$学号 = $rs_a[$i]['学号'];
		$座号 = returntablefield("edu_student","学号",$学号,"座号");
		if($座号>0)			{
			$sql = "update edu_studentkaoqin set 座号='$座号' where 学号='$学号' and 学期名称='$CurXueQi'"; // where 执行状态='0'
			$db->Execute($sql);
			global $SHOWTEXT; if($SHOWTEXT)print "<BR>修正学生考勤里面的空座号信息:".$sql."<BR>";
		}
	}
}


//修正教学日记里面的空周次信息
function 修正学生考勤里面的空周次信息()  {
	global $db,$CurXueQi;
	$sql = "select distinct 考勤日期 from edu_studentkaoqin where 周次='0' and 学期名称='$CurXueQi'"; // where 执行状态='0'
	$rs = $db->Execute($sql);
	$rs_a = $rs->GetArray();
	for($i=0;$i<sizeof($rs_a);$i++)				{
		$考勤日期 = $rs_a[$i]['考勤日期'];
		$周次 =  returnCurWeekIndex($考勤日期);
		if($周次>0)			{
			$sql = "update edu_studentkaoqin set 周次='$周次' where 考勤日期='$考勤日期'"; // where 执行状态='0'
			$db->Execute($sql);
			global $SHOWTEXT; if($SHOWTEXT)print "<BR>修正学生考勤里面的空周次信息:".$sql."<BR>";
		}
	}
}

//节假日调课
function 节假日调课()		{
	global $db,$CurXueQi;
	$sql = "select * from edu_schedulejiejiari"; // where 执行状态='0'
	$rs = $db->Execute($sql);
	$rs_a = $rs->GetArray();
	$NewArray = array();
	for($i=0;$i<sizeof($rs_a);$i++)						{
		$原上课时间 = $rs_a[$i]['原上课时间'];
		$调整后上课时间 = $rs_a[$i]['调整后上课时间'];
		$执行状态 = $rs_a[$i]['执行状态'];
		$NewArray['正向'][$调整后上课时间] = $原上课时间;
		$NewArray['反向'][$原上课时间] = $调整后上课时间;
		//处理节假日调课的周次信息2010-4-28日启用按实际周次作法
		$周次 = returnCurWeekIndex($调整后上课时间);
		$调整后上课时间Array = explode('-',$调整后上课时间);
		$星期 = date("w",mktime(1,1,1,$调整后上课时间Array[1],$调整后上课时间Array[2],$调整后上课时间Array[0]));
		$sql = "update edu_teacherkaoqinmingxi set 周次='$周次',星期='$星期' where 考勤日期='$调整后上课时间' and 学期='$CurXueQi'";
		global $SHOWTEXT; if($SHOWTEXT)print $sql."<BR>";
		$db->Execute($sql);
	}
	return $NewArray;
}

//按时间进度对调课计划进行调度(教务科调课)
function 教务科调课()		{
	global $db,$CurXueQi;
	//课表提前一天执行 教师考勤不执行,改变教师考勤初始化天数,不对其按月执行,改为按天执行初始化操作
	$当天时间 = date("Y-m-d",mktime(1,1,1,date('m'),date('d'),date('Y')));
	$sql = "select * from edu_schedulechange where 执行时间<='$当天时间' and 执行状态='0'";
	$rs = $db->Execute($sql);
	$rs_a = $rs->GetArray();
	//流水号  学期  原班级  原教室  原教师  原课程  原星期  原节次  单双周  新班级  新教室  新教师  新课程  新星期  新节次  新单双周  执行时间  执行状态
	for($i=0;$i<sizeof($rs_a);$i++)				{
		$流水号 = $rs_a[$i]['流水号'];
		$学期 = $rs_a[$i]['学期'];
		$执行时间 = $rs_a[$i]['执行时间'];
		$原班级 = $rs_a[$i]['原班级'];
		$原教室 = $rs_a[$i]['原教室'];
		$原教师 = $rs_a[$i]['原教师'];
		$原教师用户名 = $rs_a[$i]['原教师用户名'];
		$原课程 = $rs_a[$i]['原课程'];
		$原星期 = $rs_a[$i]['原星期'];
		$原节次 = $rs_a[$i]['原节次'];
		$原单双周 = $rs_a[$i]['单双周'];

		$新班级 = $rs_a[$i]['新班级'];
		$新教室 = $rs_a[$i]['新教室'];
		$新教师 = $rs_a[$i]['新教师'];
		$新教师用户名 = $rs_a[$i]['新教师用户名'];
		$新课程 = $rs_a[$i]['新课程'];
		$新星期 = $rs_a[$i]['新星期'];
		$新节次 = $rs_a[$i]['新节次'];
		$新单双周 = $rs_a[$i]['新单双周'];



		//执行课表更新
		$sql = "update edu_schedule set 班级='$新班级',课程='$新课程',教室='$新教室',教师='$新教师',教师用户名='$新教师用户名' where 班级='$原班级' and 课程='$原课程' and 教师='$原教师' and 教师用户名='$原教师用户名' and 星期='$原星期' and 节次='$原节次' and 单双周='$原单双周'";
		$db->Execute($sql);
		global $SHOWTEXT; if($SHOWTEXT)print $sql."<BR>";
		//更改当前状态
		$sql = "update edu_schedulechange set 执行状态='1' where 流水号='$流水号'";
		$db->Execute($sql);
		global $SHOWTEXT; if($SHOWTEXT)print $sql."<BR>";
		//去除教师考勤信息里面的已经有的值
		$sql = "delete from edu_teacherkaoqinmingxi where 教师用户名='$原教师用户名' and 教师姓名='$原教师' and 考勤日期>='$执行时间' and 课程='$原课程' and 班级='$原班级'";
		$db->Execute($sql);
	    global $SHOWTEXT; if($SHOWTEXT)print $sql."<BR>";

	}
}



//按时间进度对分段教学进行调度
function FenDuanJiaoXuePlanExec($学期,$周次)		{
	global $db,$CurXueQi;
	//对历史数据或当期数据进行处理		//
	$sql = "select * from edu_schedulefenduanjiaoxue
			where (开始周='$周次' or (开始周<'$周次' and 执行状态='0')) and 学期='$CurXueQi'";
	// and 执行状态='0'
	$rs = $db->Execute($sql);
	$rs_a = $rs->GetArray();
	//print_R($rs_a);
	global $SHOWTEXT; if($SHOWTEXT)print "<font color=green>周次:$周次 ".$sql."</font><BR>";
	//学期  班级  教室  教师  课程  星期  节次  单双周  开始周  结束周
	for($i=0;$i<sizeof($rs_a);$i++)				{
		$编号X = $rs_a[$i]['编号'];
		$学期 = $rs_a[$i]['学期'];
		$班级 = $rs_a[$i]['班级'];
		$教室 = $rs_a[$i]['教室'];
		$教师 = $rs_a[$i]['教师'];
		$教师用户名	= $rs_a[$i]['教师用户名'];
		$课程 = $rs_a[$i]['课程'];
		$星期 = $rs_a[$i]['星期'];
		$节次 = $rs_a[$i]['节次'];
		$开始周 = $rs_a[$i]['开始周'];
		$单双周 = $rs_a[$i]['单双周'];

		//重新对周次参数进行赋值
		$周次 = $rs_a[$i]['开始周'];

		//为零时表示为全周,该时间内数据所有数据全部清理
		if($单双周=='0')			{
			$AddSql = "and (单双周='1' or 单双周='2' or 单双周='0')";
		}
		else		{
			$AddSql = "and (单双周='$单双周' or 单双周='0')";
		}
		//#########################################################################################
		//得出原有课表信息的上课信息
		$sql = "select distinct 教师,课程,教师用户名 from edu_schedule where 学期='$学期' and 班级='$班级' and 星期='$星期' and 节次='$节次' $AddSql";
		$rs =$db->Execute($sql);
		$教师X = $rs->fields['教师'];
		$教师用户名X = $rs->fields['教师用户名'];
		$课程X = $rs->fields['课程'];
		global $SHOWTEXT; if($SHOWTEXT)print "<font color=green>周次:$周次 ".$sql."</font><BR>";
		//去除教师考勤信息里面的已经有的值
		global $SHOWTEXT; if($SHOWTEXT)print "<font color=red>教师:$教师 课程:$课程 课程X:$课程X 教师X:$教师X 周次:$周次 </font><BR>";
		if($教师X!=""&&$课程X!=""&&($教师X!=$教师||$课程X!=$课程))		{
			global $SHOWTEXT; if($SHOWTEXT)print "<font color=red>教师:$教师 课程:$课程 课程X:$课程X 教师X:$教师X 周次:$周次 </font><BR>";

			//清除掉已经存在于课表的数据,为新的周次信息加入留出空间
			//为某一班级,在某一时间段内上课信息,教师,课程,教室信息有所变化
			$sql = "delete from edu_schedule where 教师用户名='$教师用户名X' and 学期='$学期' and 班级='$班级' and 星期='$星期' and 节次='$节次' $AddSql";
			$db->Execute($sql);
			global $SHOWTEXT; if($SHOWTEXT)print "<font color=green>周次:$周次 ".$sql."</font><BR>";

			//此删除功能会删除一些手工调整的教师考勤记录
			$sql = "delete from edu_teacherkaoqinmingxi where 教师用户名='$教师用户名X' and 周次>='$周次' and 课程='$课程X' and 学期='$CurXueQi'";
			$db->Execute($sql);
			global $SHOWTEXT; if($SHOWTEXT)print "<font color=green>周次:$周次 ".$sql."</font><BR>";

			//在新课表中加入新的课程安排(学期  班级  教室  教师  课程  星期  节次  单双周 )
			$sql = "insert into edu_schedule values ('','$学期','$班级','$教室','$教师','$课程','$星期','$节次','$单双周','$教师用户名');";
			$db->Execute($sql);
			global $SHOWTEXT; if($SHOWTEXT)print "<font color=green>周次:$周次 ".$sql."</font><BR>";

			//对教师考勤信息执行更新操作
			$目标周第一天时间 = returnWeekDayNumber($周次);
			$目标周第一天时间Array = explode('-',$目标周第一天时间);
			for($iX=0;$iX<14;$iX++)		{
				$Datetime = date("Y-m-d",mktime(1,1,1,$目标周第一天时间Array[1],$目标周第一天时间Array[2]+$iX,$目标周第一天时间Array[0]));
				global $SHOWTEXT; if($SHOWTEXT)print "<BR>开始处理分段教学-恢复教师数据部分($Datetime):#################<BR>";
				//Init_Teacher_KaoQin_Data($Datetime,$教师,$教师用户名);
				//Init_Teacher_KaoQin_Data($Datetime,$教师X,$教师用户名X);
			}
		}
		else	{

		}

		//#########################################################################################
		//得出原有课表信息的上课信息
		$sql = "select distinct 教师,课程,班级,教师用户名 from edu_schedule where 学期='$学期' and 教师用户名='$教师用户名' and 星期='$星期' and 节次='$节次' $AddSql";
		$rs =$db->Execute($sql);
		$教师用户名X = $rs->fields['教师用户名'];
		$教师X = $rs->fields['教师'];
		$班级X = $rs->fields['班级'];
		$课程X = $rs->fields['课程'];
		global $SHOWTEXT; if($SHOWTEXT)print "<font color=green>周次:$周次 ".$sql."</font><BR>";
		//去除教师考勤信息里面的已经有的值
		global $SHOWTEXT; if($SHOWTEXT)print "<font color=red>班级:$班级 课程:$课程 课程X:$课程X 班级X:$班级X 周次:$周次 </font><BR>";
		if($班级X!=""&&$课程X!=""&&($班级X!=$班级||$课程X!=$课程))		{
			global $SHOWTEXT; if($SHOWTEXT)print "<font color=red>班级:$班级 课程:$课程 课程X:$课程X 班级X:$班级X 周次:$周次 </font><BR>";

			//清除掉已经存在于课表的数据,为新的周次信息加入留出空间
			//为某一班级,在某一时间段内上课信息,班级,课程,教室信息有所变化
			$sql = "delete from edu_schedule where 教师用户名='$教师用户名X' and 学期='$学期' and 班级='$班级X' and 星期='$星期' and 节次='$节次' $AddSql";
			$db->Execute($sql);
			global $SHOWTEXT; if($SHOWTEXT)print "<font color=green>周次:$周次 ".$sql."</font><BR>";

			//此删除功能会删除一些手工调整的教师考勤记录
			$sql = "delete from edu_teacherkaoqinmingxi where 教师用户名='$教师用户名X' and 周次>='$周次' and 课程='$课程X' and 学期='$CurXueQi'";
			$db->Execute($sql);
			global $SHOWTEXT; if($SHOWTEXT)print "<font color=green>周次:$周次 ".$sql."</font><BR>";

			//在新课表中加入新的课程安排(学期  班级  教室  教师  课程  星期  节次  单双周 )
			$sql = "insert into edu_schedule values ('','$学期','$班级','$教室','$教师','$课程','$星期','$节次','$单双周','$教师用户名');";
			$db->Execute($sql);
			global $SHOWTEXT; if($SHOWTEXT)print "<font color=green>周次:$周次 ".$sql."</font><BR>";

			//对教师考勤信息执行更新操作
			$目标周第一天时间 = returnWeekDayNumber($周次);
			$目标周第一天时间Array = explode('-',$目标周第一天时间);
			for($iX=0;$iX<14;$iX++)		{
				$Datetime = date("Y-m-d",mktime(1,1,1,$目标周第一天时间Array[1],$目标周第一天时间Array[2]+$iX,$目标周第一天时间Array[0]));
				global $SHOWTEXT; if($SHOWTEXT)print "<BR>开始处理分段教学-恢复教师数据部分($Datetime):#################<BR>";
				//Init_Teacher_KaoQin_Data($Datetime,$教师,$教师用户名);
			}
		}
		else	{

		}
		//#########################################################################################
		//更改当前状态
		$sql = "update edu_schedulefenduanjiaoxue set 执行状态='1' where 编号='$编号X'";
		//$db->Execute($sql);
		global $SHOWTEXT; if($SHOWTEXT)print "<font color=red>周次:$周次 $目标周第一天时间 ".$sql."</font><BR>";
		//exit;

	}

}

function returnWeekDayNumber($周次)		{
	global $db,$开始时间,$结束时间,$开始时间Array,$结束时间Array,$ShowData,$ShowDataText;
	$sql = "select max(结束时间) as 结束时间 ,min(结束时间) as 开始时间 from edu_schoolcalendar";
	$rs = $db->Execute($sql);
	$rs_a = $rs->GetArray();
	$开始时间 = $rs_a[0]['开始时间'];
	$结束时间 = $rs_a[0]['结束时间'];
	$开始时间Array = explode('-',$rs_a[0]['开始时间']);
	$Number = ($周次-1)*7;
	$开始比较时间X = date("Y-m-d",mktime(1,1,1,$开始时间Array[1],$开始时间Array[2]+$Number,$开始时间Array[0]));
	$开始比较时间t = date("w",mktime(1,1,1,$开始时间Array[1],$开始时间Array[2]+$Number,$开始时间Array[0]));
	$开始比较时间X = date("Y-m-d",mktime(1,1,1,$开始时间Array[1],$开始时间Array[2]+$Number-$开始比较时间t+1,$开始时间Array[0]));
	return $开始比较时间X;
}

function returnWeekDayNumberALL($周次)		{
	global $db,$开始时间,$结束时间,$开始时间Array,$结束时间Array,$ShowData,$ShowDataText;
	$sql = "select max(结束时间) as 结束时间 ,min(结束时间) as 开始时间 from edu_schoolcalendar";
	$rs = $db->Execute($sql);
	$rs_a = $rs->GetArray();
	$开始时间 = $rs_a[0]['开始时间'];
	$结束时间 = $rs_a[0]['结束时间'];
	$开始时间Array = explode('-',$rs_a[0]['开始时间']);
	$Number = ($周次-1)*7;
	$开始比较时间X = date("Y-m-d",mktime(1,1,1,$开始时间Array[1],$开始时间Array[2]+$Number,$开始时间Array[0]));
	$开始比较时间t = date("w",mktime(1,1,1,$开始时间Array[1],$开始时间Array[2]+$Number,$开始时间Array[0]));
	$开始比较时间X = date("Y-m-d",mktime(1,1,1,$开始时间Array[1],$开始时间Array[2]+$Number-$开始比较时间t,$开始时间Array[0]));
	$结束比较时间X = date("Y-m-d",mktime(1,1,1,$开始时间Array[1],$开始时间Array[2]+$Number-$开始比较时间t+7,$开始时间Array[0]));
	$当前月份 = date("n",mktime(1,1,1,$开始时间Array[1],$开始时间Array[2]+$Number-$开始比较时间t,$开始时间Array[0]));
	$NewArray['开始时间'] = $开始比较时间X;
	$NewArray['结束时间'] = $结束比较时间X;
	$NewArray['当前月份'] = $当前月份;
	return $NewArray;
}


function XiaoLiArray()		{
	global $db,$开始时间,$结束时间,$开始时间Array,$结束时间Array,$ShowData,$ShowDataText;

	//校历数据来源
	$sql = "select * from edu_schoolcalendar";
	$rs = $db->Execute($sql);
	$rs_a = $rs->GetArray();
	for($i=0;$i<sizeof($rs_a);$i++)				{
		$开始时间S = $rs_a[$i]['开始时间'];
		$结束时间S = $rs_a[$i]['结束时间'];
		$节假日 = $rs_a[$i]['节假日'];
		if($开始时间S==$结束时间S)		{
			$ShowData[$开始时间S] = $节假日;
			$ShowDataText[$开始时间S] = "style='BACKGROUND:#FFEBEB'";
		}
		else		{
			$开始时间XArray = explode('-',$开始时间S);
			for($iX=0;$iX<70;$iX++)				{
				$开始比较时间X = date("Y-m-d",mktime(1,1,1,$开始时间XArray[1],$开始时间XArray[2]+$iX,$开始时间XArray[0]));
				if($开始比较时间X>$结束时间S) continue;//跳出月份过滤
				//if($开始时间S=="2010-01-23")print $开始时间S." ".$开始比较时间X." ".$结束时间S."<BR>";
				$ShowData[$开始比较时间X] = $节假日;
				$ShowDataText[$开始比较时间X] = "style='BACKGROUND:#FFEBEB'";
			}
		}

		//#####################################################################
		//执行当前天是否为节假日
		$sql = "delete from edu_teacherkaoqinmingxi  where 考勤日期>='$开始时间S' and 考勤日期<='$结束时间S'";
		global $SHOWTEXT; if($SHOWTEXT)print "<BR>校历:".$sql."<HR>";
		$db->Execute($sql);
		//#####################################################################
	}


	//结束
}





function ReturnTeacherSchedule($学期,$教师用户名,$教师,$周次)  {
	global $db,$CurXueQi;
	$sql = "select 星期,节次,教室,课程,班级,单双周 from edu_schedule where 学期='$学期' and 教师用户名='$教师用户名' order by 星期 asc,单双周 asc,节次 asc";
	$rs = $db->Execute($sql);
	$rs_a = $rs->GetArray();
	//过滤合班上课
	for($i=0;$i<sizeof($rs_a);$i++)		{
		$班级 = $rs_a[$i]['班级'];
		$sql = "select 内容 from edu_schooljingcheng
				where 学期='$学期' and 班级='$班级' and 周次='$周次' and 开始星期='' and 结束星期=''";
		$rsX = $db->Execute($sql);
		$rsX_a = $rsX->GetArray();
		$内容 = TRIM($rsX_a[0]['内容']);
		if($内容=='')					{
			$星期 = TRIM($rs_a[$i]['星期']);
			$节次 = TRIM($rs_a[$i]['节次']);
			$教室 = TRIM($rs_a[$i]['教室']);
			$课程 = TRIM($rs_a[$i]['课程']);
			$班级 = TRIM($rs_a[$i]['班级']);
			$单双周 = TRIM($rs_a[$i]['单双周']);
			$星期 = $星期%7;
			if($单双周=='0')		{
				$NewArray[$星期][$节次]['1']['教室']=TRIM($教室);
				$NewArray[$星期][$节次]['1']['课程']=TRIM($课程);
				$NewArray[$星期][$节次]['1']['班级']=TRIM($班级);
				$NewArray[$星期][$节次]['2']['教室']=TRIM($教室);
				$NewArray[$星期][$节次]['2']['课程']=TRIM($课程);
				$NewArray[$星期][$节次]['2']['班级']=TRIM($班级);
			}
			else	{
				$NewArray[$星期][$节次][$单双周]['教室']=TRIM($教室);
				$NewArray[$星期][$节次][$单双周]['课程']=TRIM($课程);
				$NewArray[$星期][$节次][$单双周]['班级']=TRIM($班级);
			}
		}//$内容==''
		else	{
			global $SHOWTEXT; if($SHOWTEXT)print "<BR><font color=red>-----------分段教学:$班级 $课程 $教室 $教师</font><BR>";
		}

	}//end for
	global $SHOWTEXT; if($SHOWTEXT)print_R($NewArray[4]);//exit;
	return $NewArray;
	//
}



function Asc_Teacher_KaoQin_ToDay_Data($考勤日期,$教师姓名,$教师用户名)			{
	global $db,$CurXueQi;
	global $SHOWTEXT; if($SHOWTEXT)print "<BR>同步教师当天考勤数据====================================================<BR>";
	$sql = "select * from edu_teacherkaoqin where 考勤日期='$考勤日期' and 教师用户名='$教师用户名'";
	global $SHOWTEXT; if($SHOWTEXT)print $sql."<BR>";
	$rs2 = $db->Execute($sql);
	$rs2_a = $rs2->GetArray();
	for($iii=0;$iii<sizeof($rs2_a);$iii++)						{
		$刷卡时间 = $rs2_a[$iii]['刷卡时间'];
		global $SHOWTEXT; if($SHOWTEXT)print "<BR>DealTimeJieCiShangKe DealTimeJieCiXiaKe============<BR>";
		$DealTimeJieCiShangKe	= DealTimeJieCiShangKe($教师姓名,$教师用户名,$考勤日期,$刷卡时间);
		$DealTimeJieCiXiaKe		= DealTimeJieCiXiaKe($教师姓名,$教师用户名,$考勤日期,$刷卡时间);
		global $SHOWTEXT; if($SHOWTEXT)print "<BR>同步教师当天考勤数据 $教师姓名 $教师用户名 $考勤日期 $刷卡时间=========================";
	}
	//global $SHOWTEXT; if($SHOWTEXT)print "<BR>同步教师当天考勤数据 $教师姓名 $教师用户名 $考勤日期 $刷卡时间=========================";
	global $SHOWTEXT; if($SHOWTEXT&&sizeof($rs_a)>0)print_R($rs_a);;
}

//班级教学进程过滤
function Banji_ShiXi_JiaoXueJinCheng($班级,$周次,$学期,$考勤日期)		{
	global $db,$CurXueQi;
	//班级实习周部分调整,如果该班级在当前周是实习或考试周次,那么教师考勤则不进行初始化
	$考勤日期Array = explode('-',$考勤日期);
	$当前星期 = date("w",mktime(1,1,1,$考勤日期Array[1],$考勤日期Array[2],$考勤日期Array[0]));
	$sql = "select * from edu_schooljingcheng where 班级='$班级' and 周次='$周次' and 学期='$学期'
			and ( (开始星期<='$当前星期' and 结束星期>='$当前星期')  or (开始星期='' and 结束星期='') )
			";
	global $SHOWTEXT; if($SHOWTEXT)print "<BR>班级教学进程过滤 $考勤日期 $周次<font color=red><B>$sql</B></font><BR>";
	$rs = $db->Execute($sql);
	$rs_a = $rs->GetArray();
	$内容 = $rs_a[0]['内容'];
	global $SHOWTEXT; if($SHOWTEXT)print "<BR><font color=green><B>$sql</B></font><BR>";
	if($内容!="")		{
		//$sql = "delete from edu_teacherkaoqinmingxi where 班级='$班级' and 学期='$学期' and 周次='$周次' and 考勤日期='$考勤日期'";
		/*
		$sql = "update edu_teacherkaoqinmingxi
				set 上课考勤状态='班级教学进程',下课考勤状态='班级教学进程',上课实际刷卡='班级教学进程',下课实际刷卡='班级教学进程',备注='".$班级."在".$考勤日期."有教学进程安排'
				where 班级='$班级' and 学期='$学期' and 周次='$周次' and 考勤日期='$考勤日期'";
		*/
		$sql = "delete from edu_teacherkaoqinmingxi where 班级='$班级' and 学期='$学期' and 周次='$周次' and 考勤日期='$考勤日期'";
		$db->Execute($sql);
		$db->Execute($sql);
		global $SHOWTEXT; if($SHOWTEXT)print "<BR>班级教学进程过滤 $考勤日期 <font color=red><B>$sql</B></font><BR>";
		global $SHOWTEXT; if($SHOWTEXT&&sizeof($rs_a)>0)print_R($rs_a);;
		//print $sql;exit;
	}
	//if($班级=="数控0801班")	print "<BR><font color=orange><B>$sql</B></font><BR>"; //$内容='内容';
	return $内容;
}


//教师代课过滤
function Teacher_DaiKe_Infor($教师,$教师用户名,$上课时间,$节次,$课程,$学期)		{
	global $db,$CurXueQi;
	//编号  学期  班级  教室  课程  原教师  新教师  上课时间  节次  审核状态  工作流ID号  审核人  审核时间
	//第一步:判断代课流程正确且结束
	$sql = "select 新教师用户名 from edu_scheduledaike where 原教师用户名='$教师用户名' and 上课时间='$上课时间' and 节次='$节次' and 课程='$课程' and 审核状态='1'";
	$rs = $db->Execute($sql);
	$rs_a = $rs->GetArray();
	$新教师用户名 = $rs_a[0]['新教师用户名'];
	global $SHOWTEXT; if($SHOWTEXT)	print "<BR><font color=green><B>$sql</B></font><BR>";
	//第二步:判断代刘后的教师是否有课,即是否成功
	if($新教师用户名!="")			{
		$sql = "select 教师用户名 from edu_teacherkaoqinmingxi where 学期='$学期' and 教师用户名='$新教师用户名' and 课程='$课程' and 考勤日期='$上课时间' and 节次='$节次'";
		$rs = $db->Execute($sql);
		$rs_a = $rs->GetArray();
		$教师用户名 = $rs_a[0]['教师用户名'];
		if($教师用户名!="")		{
			//代课成功,不做任何处理
			return;
		}
		else		{
			//没有代理数据,需要重新增加
			return $新教师用户名;
		}
	}
	else	{
		return;
	}
}

//教师调课过滤
function Teacher_TiaoKe_Infor($教师,$教师用户名,$上课时间,$节次,$课程,$学期)		{
	global $db,$CurXueQi;
	// 编号  学期  班级  教室  教师  课程  原上课时间  原节次  新上课时间  新节次  审核状态  工作流ID号  审核人  审核时间
	$sql = "select * from edu_scheduletiaoke where 教师用户名='$教师用户名' and 原上课时间='$上课时间' and 原节次='$节次' and 课程='$课程' and 审核状态='1'";
	$rs = $db->Execute($sql);
	$rs_a = $rs->GetArray();
	$编号 = $rs_a[0]['编号'];
	$教师 = $rs_a[0]['教师'];
	$教师用户名	= $rs_a[0]['教师用户名'];
	$课程 = $rs_a[0]['课程'];
	$教室 = $rs_a[0]['教室'];
	$班级 = $rs_a[0]['班级'];
	$新上课时间 = $rs_a[0]['新上课时间'];
	$新节次 = $rs_a[0]['新节次'];
	global $SHOWTEXT; if($SHOWTEXT)print "<BR><font color=green><B>$sql</B></font><BR>";
	if($编号!="")		{
		//print $sql."调课表<BR>";
		$sql = "delete from edu_teacherkaoqinmingxi where 学期='$学期' and 教师姓名='$教师' and 教师用户名='$教师用户名' and 课程='$课程' and 考勤日期='$上课时间' and 节次='$节次'";
		$db->Execute($sql);
		global $SHOWTEXT; if($SHOWTEXT)print "教师调课过滤<BR><font color=red><B>$sql</B></font><BR>";
		global $SHOWTEXT; if($SHOWTEXT&&sizeof($rs_a)>0)print_R($rs_a);;
		//存在记录,重新较验新的记录是否存在
		$sql = "select * from edu_teacherkaoqinmingxi where 学期='$学期' and 教师姓名='$教师' and 教师用户名='$教师用户名' and 课程='$课程' and 考勤日期='$新上课时间' and 节次='$新节次'";
		$rs = $db->Execute($sql);
		$rs_a = $rs->GetArray();
		$编号X = $rs_a[0]['编号'];
		if($编号X=="")		{
			$节次Array = explode('-',$新节次);
			$Element = array();
			//$Element['编号'] = '';
			global $KaoqinTime;
			global $KaoqinTimeBegin1,$KaoqinTimeBegin2,$KaoqinTimeEnd1,$KaoqinTimeEnd2,$KuangGongShiJian;


			$考勤日期Array = explode('-',$新上课时间);
			$当前星期数 = date("w",mktime(1,1,1,$考勤日期Array[1],$考勤日期Array[2],$考勤日期Array[0]));
			$X = 7-$当前星期数;
			$安排内容 = returnJieCiName($节次Array[0]);
			$有效时间 = returnJieCiTime($安排内容);
			$有效时间Array = explode('-',$有效时间);
			$有效时间0Array = explode(':',$有效时间Array[0]);
			$有效时间1Array = explode(':',$有效时间Array[1]);
			global $SYSTEM_MERGE_CLASSTABLE;
			if($节次Array[1]!=""&&$SYSTEM_MERGE_CLASSTABLE = "1")		{
				$安排内容1 = returnJieCiName($节次Array[1]);
				$有效时间1 = returnJieCiTime($安排内容1);
				$有效时间1Array = explode('-',$有效时间1);
				$有效时间1Array = explode(':',$有效时间1Array[1]);
			}

			//print_R($有效时间);
			$上课刷卡BGN = date("H:i",@mktime($有效时间0Array[0],$有效时间0Array[1]-$KaoqinTimeBegin1,30,12,12,2008));
			$上课刷卡END = date("H:i",@mktime($有效时间0Array[0],$有效时间0Array[1]+$KaoqinTimeBegin2,30,12,12,2008));
			$下课刷卡BGN = date("H:i",@mktime($有效时间1Array[0],$有效时间1Array[1]-$KaoqinTimeEnd1,30,12,12,2008));
			$下课刷卡END = date("H:i",@mktime($有效时间1Array[0],$有效时间1Array[1]+$KaoqinTimeEnd2,30,12,12,2008));

			$Element['教师姓名'] = $教师;
			$Element['教师用户名'] = $教师用户名;
			$Element['考勤日期'] = $新上课时间;
			$Element['教室'] = $教室;
			$Element['课程'] = $课程;
			$Element['班级'] = $班级;
			$Element['星期'] = $当前星期数;
			$Element['节次'] = $新节次;
			$Element['周次'] = returnCurWeekIndex($新上课时间);
			$Element['学期'] = $学期;
			$Element['应该填写时间'] = $新上课时间;
			$Element['最迟填写时间'] = date("Y-m-d",mktime(1,1,1,$考勤日期Array[1],$考勤日期Array[2]+$X,$考勤日期Array[0]));


			$Element['上课实际刷卡'] = '';
			$Element['上课考勤状态'] = '';
			$Element['下课实际刷卡'] = '';
			$Element['下课考勤状态'] = '';

			$Element['上课刷卡BGN'] = $上课刷卡BGN;
			$Element['上课刷卡END'] = $上课刷卡END;
			$Element['下课刷卡BGN'] = $下课刷卡BGN;
			$Element['下课刷卡END'] = $下课刷卡END;

			$ElementValue = array_values($Element);
			$sqlValueText = "'".join("','",$ElementValue)."'";
			$ElementName = array_keys($Element);
			$sqlNameText = "`".join("`,`",$ElementName)."`";

			$sql = "insert into edu_teacherkaoqinmingxi($sqlNameText) values($sqlValueText)";

			$db->Execute($sql);
			//print $sql."1111<BR>";exit;
		}
		//print $sql."$编号X<BR>";exit;
	}
	return $编号;
}


//教师相互调课过滤
function Teacher_TiaoKeXiangHu_Infor($教师,$教师用户名,$上课时间,$节次,$课程,$学期)		{
	global $db,$CurXueQi;
	// 编号  学期  班级  教室  教师  课程  原上课时间  原节次  新上课时间  新节次  审核状态  工作流ID号  审核人  审核时间
	$sql = "select 编号 from edu_scheduletiaokexianghu where ((原教师用户名='$教师用户名' and 原上课时间='$上课时间' and 原节次='$节次' and 原课程='$课程') or (新教师用户名='$教师用户名' and 新上课时间='$上课时间' and 新节次='$节次' and 新课程='$课程') ) and 审核状态='1'";
	global $SHOWTEXT; if($SHOWTEXT)print "<BR><font color=green><B>$sql</B></font><BR>";
	$rs = $db->Execute($sql);
	$rs_a = $rs->GetArray();
	$编号 = $rs_a[0]['编号'];
	global $SHOWTEXT; if($SHOWTEXT&&sizeof($rs_a)>0)print_R($rs_a);;
	return $编号;
}


//教师停课-复课过滤
function Teacher_TingKe_Infor($教师,$教师用户名,$上课时间,$节次,$课程,$学期)		{
	global $db,$CurXueQi;
	$sql = "select * from edu_scheduletingkefuke where 教师用户名='$教师用户名' and 原上课时间='$上课时间' and 原节次='$节次' and 课程='$课程' and 停课审核状态='1'";
	$rs = $db->Execute($sql);
	$rs_a = $rs->GetArray();
	$编号 = $rs_a[0]['编号'];
	$教师 = $rs_a[0]['教师'];
	$教师用户名	= $rs_a[0]['教师用户名'];
	$课程 = $rs_a[0]['课程'];
	$教室 = $rs_a[0]['教室'];
	$班级 = $rs_a[0]['班级'];
	$新上课时间 = $rs_a[0]['新上课时间'];
	$新节次 = $rs_a[0]['新节次'];
	global $SHOWTEXT; if($SHOWTEXT)print "<BR><font color=green><B>$sql</B></font><BR>";
	if($编号!="")		{
		//print $sql."调课表<BR>";
		$sql = "delete from edu_teacherkaoqinmingxi where 学期='$学期' and 教师姓名='$教师' and 教师用户名='$教师用户名' and 课程='$课程' and 考勤日期='$上课时间' and 节次='$节次'";
		$db->Execute($sql);
		global $SHOWTEXT; if($SHOWTEXT)print "教师停课-复课过滤<BR><font color=red><B>$sql</B></font><BR>";
		global $SHOWTEXT; if($SHOWTEXT&&sizeof($rs_a)>0)print_R($rs_a);;
		//存在记录,重新较验新的记录是否存在
		$sql = "select * from edu_teacherkaoqinmingxi where 学期='$学期' and 教师姓名='$教师' and 教师用户名='$教师用户名' and 课程='$课程' and 考勤日期='$新上课时间' and 节次='$新节次'";
		$rs = $db->Execute($sql);
		$rs_a = $rs->GetArray();
		$编号X = $rs_a[0]['编号'];
		if($编号X=="")		{
			$节次Array = explode('-',$新节次);
			$Element = array();
			//$Element['编号'] = '';
			global $KaoqinTime;
			global $KaoqinTimeBegin1,$KaoqinTimeBegin2,$KaoqinTimeEnd1,$KaoqinTimeEnd2,$KuangGongShiJian;

			$考勤日期Array = explode('-',$新上课时间);
			$当前星期数 = date("w",mktime(1,1,1,$考勤日期Array[1],$考勤日期Array[2],$考勤日期Array[0]));
			$X = 7-$当前星期数;
			$安排内容 = returnJieCiName($节次Array[0]);
			$有效时间 = returnJieCiTime($安排内容);
			$有效时间Array = explode('-',$有效时间);
			$有效时间0Array = explode(':',$有效时间Array[0]);
			$有效时间1Array = explode(':',$有效时间Array[1]);
			global $SYSTEM_MERGE_CLASSTABLE;
			if($节次Array[1]!=""&&$SYSTEM_MERGE_CLASSTABLE = "1")		{
				$安排内容1 = returnJieCiName($节次Array[1]);
				$有效时间1 = returnJieCiTime($安排内容1);
				$有效时间1Array = explode('-',$有效时间1);
				$有效时间1Array = explode(':',$有效时间1Array[1]);
			}
			//print_R($有效时间);
			$上课刷卡BGN = date("H:i",@mktime($有效时间0Array[0],$有效时间0Array[1]-$KaoqinTimeBegin1,30,12,12,2008));
			$上课刷卡END = date("H:i",@mktime($有效时间0Array[0],$有效时间0Array[1]+$KaoqinTimeBegin2,30,12,12,2008));
			$下课刷卡BGN = date("H:i",@mktime($有效时间1Array[0],$有效时间1Array[1]-$KaoqinTimeEnd1,30,12,12,2008));
			$下课刷卡END = date("H:i",@mktime($有效时间1Array[0],$有效时间1Array[1]+$KaoqinTimeEnd2,30,12,12,2008));

			$Element['教师姓名'] = $教师;
			$Element['教师用户名'] = $教师用户名;
			$Element['考勤日期'] = $新上课时间;
			$Element['教室'] = $教室;
			$Element['课程'] = $课程;
			$Element['班级'] = $班级;
			$Element['星期'] = $当前星期数;
			$Element['节次'] = $新节次;
			$Element['周次'] = returnCurWeekIndex($新上课时间);
			$Element['学期'] = $学期;
			$Element['应该填写时间'] = $新上课时间;
			$Element['最迟填写时间'] = date("Y-m-d",mktime(1,1,1,$考勤日期Array[1],$考勤日期Array[2]+$X,$考勤日期Array[0]));

			$Element['上课实际刷卡'] = '';
			$Element['上课考勤状态'] = '';
			$Element['下课实际刷卡'] = '';
			$Element['下课考勤状态'] = '';

			$Element['上课刷卡BGN'] = $上课刷卡BGN;
			$Element['上课刷卡END'] = $上课刷卡END;
			$Element['下课刷卡BGN'] = $下课刷卡BGN;
			$Element['下课刷卡END'] = $下课刷卡END;

			$ElementValue = array_values($Element);
			$sqlValueText = "'".join("','",$ElementValue)."'";
			$ElementName = array_keys($Element);
			$sqlNameText = "`".join("`,`",$ElementName)."`";

			$sql = "insert into edu_teacherkaoqinmingxi($sqlNameText) values($sqlValueText)";

			$db->Execute($sql);
			//print $sql."1111<BR>";exit;
		}
		//print $sql."$编号X<BR>";exit;
	}
	return $编号;
}


/*
//教师复课过滤
function Teacher_FuKe_Infor($教师,$上课时间,$节次,$课程,$学期)		{
	global $db,$CurXueQi;
	$sql = "select 编号 from edu_scheduletingkefuke where 教师='$教师' and 新上课时间='$上课时间' and 新节次='$节次' and 课程='$课程' and 复课审核状态='1'";
	global $SHOWTEXT; if($SHOWTEXT)print "<BR><font color=green><B>教师复课:$sql</B></font><BR>";
	$rs = $db->Execute($sql);
	$rs_a = $rs->GetArray();
	$编号 = $rs_a[0]['编号'];
	global $SHOWTEXT; if($SHOWTEXT&&sizeof($rs_a)>0)print_R($rs_a);;
	return $编号;
}
*/




function   Init_Teacher_KaoQin_Data($节假日调课_调整后时间,$默认教师名称,$教师用户名)							{
	global $db,$CurXueQi,$ShowData;


	if($默认教师名称!="")  $AddSQL = " and 教师姓名='$默认教师名称'";
	else			$AddSQL = "";

	//对校历表进行过滤
	$sql = "select 节假日 from edu_schoolcalendar where 开始时间<='$节假日调课_调整后时间' and 结束时间>='$节假日调课_调整后时间'";
	$rs = $db->Execute($sql);
	$节假日 = $rs->fields['节假日'];
	if($节假日!="")				{
		//当前时间为放假时间,系统不增加考勤信息
		return '';
	}

	//判断学期是否在今日结束
	$sql = "select * from edu_xueqiexec where 学期名称 ='$CurXueQi'";
	$rs = $db->Execute($sql);
	$学期开始时间 = $rs->fields['开始时间'];
	$学期结束时间 = $rs->fields['结束时间'];
	if($节假日调课_调整后时间>$学期结束时间&&$CurXueQi!="")			{
		//表示此学期已经结束,不在有效学期时间之内,不进行初始化操作
		//print "$节假日调课_调整后时间 表示此学期已经结束,不在有效学期时间之内,不进行初始化操作";
		//清除多余的数据
		$sql = "delete from edu_teacherkaoqinmingxi where 学期='$CurXueQi' and 考勤日期>'$学期结束时间'";
		$db->Execute($sql);
		return '';
	}
	if($节假日调课_调整后时间<$学期开始时间&&$CurXueQi!="")			{
		//表示此学期还没有开始,不在有效学期时间之内,不进行初始化操作
		//print "$节假日调课_调整后时间 表示此学期还没有开始,不在有效学期时间之内,不进行初始化操作";
		$sql = "delete from edu_teacherkaoqinmingxi where 学期='$CurXueQi' and 考勤日期<'$学期开始时间'";
		$db->Execute($sql);
		return '';
	}

	//print $CurXueQi;exit;

	global $TiaoKeJieJiaRiExec;//2010-4-28增加全局变量
	$节假日调课_原上课时间 = $TiaoKeJieJiaRiExec['正向'][$节假日调课_调整后时间];
	//print_R($TiaoKeJieJiaRiExec);exit;
	//今天为调整后的上课时间 节假日调课_原上课时间的值为原上课时间
	//所显示周次信息应该为原上课时间的周次,即节假日调课_原上课时间的周次
	if($节假日调课_原上课时间=='')	{
		$节假日调课_原上课时间 = $节假日调课_调整后时间;//没有值时沿用目标值
		$Element['备注'] = '';
	}
	else		{
		//$节假日调课_原上课时间 = $节假日调课_调整后时间;//2010-4-28日改成节假日调课,按实际上课日期显示
		$Element['备注'] = '节假日调课,原上课时间为:$节假日调课_原上课时间';
	}

	if($节假日调课_原上课时间!='')	{
		//该天有对换值,对执行状态进行更新
		$sql = "update edu_schedulejiejiari set 执行状态='1' where 调整后上课时间='$节假日调课_调整后时间'";
		$db->Execute($sql);
		global $SHOWTEXT; if($SHOWTEXT)print "<font color=green>".$sql."</font><BR>";
	}



	$YearMonth = explode('-',$节假日调课_原上课时间);
	$Year = $YearMonth[0];
	$Month = $YearMonth[1];
	$Day = $YearMonth[2];

	//$DayIndexMonth = date('t',mktime(1,1,1,$Month,$Day,$Year));

	global $KaoqinTime;
	global $KaoqinTimeBegin1,$KaoqinTimeBegin2,$KaoqinTimeEnd1,$KaoqinTimeEnd2,$KuangGongShiJian;

	if($默认教师名称!="")  $AddSQL = " where USER_NAME='$默认教师名称'";
	else			$AddSQL = "";

	//$sql = "select USER_NAME AS 真实姓名 from user $AddSQL order by USER_NAME";
	//$rs = $db->Execute($sql);
	//$rs_a = $rs->GetArray();
	//global $SHOWTEXT; if($SHOWTEXT)print $sql."<BR>";
	$rs_a[0]['真实姓名'] = '真实姓名';
	$周次 = returnCurWeekIndex($节假日调课_调整后时间);
	$单双周 = $周次%2;
	if($单双周==0) $单双周 = 2;
	for($i=0;$i<sizeof($rs_a);$i++)						{
		$真实姓名 = $默认教师名称;
		//print $真实姓名;
		//清理当月原有数据
		//$sql = "delete from edu_teacherkaoqinmingxi where 考勤日期 = '$节假日调课_调整后时间' and 教师姓名='$真实姓名'";
		//$db->Execute($sql);
		$ReturnTeacherSchedule = ReturnTeacherSchedule($CurXueQi,$教师用户名,$真实姓名,$周次);
		//print_R($ReturnTeacherSchedule);exit;
		//print "<BR>当前教师课表数组信息<BR>";
		//for($ii=1;$ii<=$DayIndexMonth;$ii++)			{
			//得以目标上课时间是周几?
			$TargetWeekDay = date('w',mktime(1,1,1,$Month,$Day,$Year));
			//得到当前天是单周还是双周 参数为:原上课时间 单双周结果也为原上课时间的单双周值
			$单双周 = returnCurWeekIndex($节假日调课_原上课时间);$单双周 = $单双周%2;if($单双周==0) $单双周 = 2;
			//得到星期中某一天的课程列表
			//$TargetWeekDay = 1;
			$WeekDaySchedule = array();
			$WeekDaySchedule = $ReturnTeacherSchedule[$TargetWeekDay];
			//print_R($TargetWeekDay);print_R($WeekDaySchedule);exit;
			global $SHOWTEXT; if($SHOWTEXT)print "<BR>星期:$TargetWeekDay [节假日]当天课表数组信息 $节假日调课_调整后时间 $节假日调课_原上课时间 已省不显示<BR>";
			//global $SHOWTEXT; if($SHOWTEXT)print_R($WeekDaySchedule);
			global $SHOWTEXT; if($SHOWTEXT)print "<BR>当天时间:$节假日调课_调整后时间 上课日期:$节假日调课_原上课时间 ";
			//昨到这一天的节次信息
			$JieCiArray = array();
			$JieCiArray = @array_keys($WeekDaySchedule);
			//sort($JieCiArray);
			//if($WeekDaySchedule!="")	{print_R($JieCiArray);print "<BR>";}
			for($iii=0;$iii<sizeof($JieCiArray);$iii++)		{
				$节次 = TRIM($JieCiArray[$iii]);
				$教室 = TRIM($WeekDaySchedule[$节次][$单双周]['教室']);
				$课程 = TRIM($WeekDaySchedule[$节次][$单双周]['课程']);
				$班级 = TRIM($WeekDaySchedule[$节次][$单双周]['班级']);
				$Element = array();
				//$Element['编号'] = '';
				$Element['教师姓名'] = TRIM($真实姓名);
				$Element['教师用户名'] = TRIM($教师用户名);
				$Element['考勤日期'] = TRIM($节假日调课_调整后时间);
				$Element['教室'] = TRIM($教室);
				$Element['课程'] = TRIM($课程);
				$Element['班级'] = TRIM($班级);
				$Element['星期'] = TRIM($TargetWeekDay);
				$Element['节次'] = TRIM($节次);
				$Element['周次'] = returnCurWeekIndex($节假日调课_原上课时间);
				$Element['学期'] = TRIM($CurXueQi);
				$Element['应该填写时间'] = TRIM($节假日调课_调整后时间);

				$考勤日期Array = explode('-',$节假日调课_调整后时间);
				$当前星期数 = date("w",mktime(1,1,1,$考勤日期Array[1],$考勤日期Array[2],$考勤日期Array[0]));
				$X = 7-$当前星期数;
				$Element['最迟填写时间'] = date("Y-m-d",mktime(1,1,1,$考勤日期Array[1],$考勤日期Array[2]+$X,$考勤日期Array[0]));

				$安排内容 = returnJieCiName($节次);
				$有效时间 = returnJieCiTime($安排内容);
				$有效时间Array = explode('-',$有效时间);
				$有效时间0Array = explode(':',$有效时间Array[0]);
				$有效时间1Array = explode(':',$有效时间Array[1]);
				global $SYSTEM_MERGE_CLASSTABLE;
				if($节次Array[1]!=""&&$SYSTEM_MERGE_CLASSTABLE = "1")		{
					$安排内容1 = returnJieCiName($节次Array[1]);
					$有效时间1 = returnJieCiTime($安排内容1);
					$有效时间1Array = explode('-',$有效时间1);
					$有效时间1Array = explode(':',$有效时间1Array[1]);
				}
				//判断该课是否为两节连上
				$第二节次 = $节次+1;
				$节余数 = $第二节次%2;
				global $SYSTEM_MERGE_CLASSTABLE;
				if($WeekDaySchedule[$第二节次][$单双周]['课程']==$WeekDaySchedule[$节次][$单双周]['课程']
					&&$WeekDaySchedule[$第二节次][$单双周]['教师']==$WeekDaySchedule[$节次][$单双周]['教师']
					&&$WeekDaySchedule[$第二节次][$单双周]['班级']==$WeekDaySchedule[$节次][$单双周]['班级']
					&&($节余数==0)
					&&$SYSTEM_MERGE_CLASSTABLE=="1"
					)				{
					//SYSTEM_MERGE_CLASSTABLE为1时表示系统采用的是强制合并的策略,但支持不同的课程进行拆分
					$安排内容 = returnJieCiName($第二节次);
					$有效时间22 = returnJieCiTime($安排内容);
					$有效时间22Array = explode('-',$有效时间22);
					//重新定义有效时间1Array数组
					$有效时间1Array = explode(':',$有效时间22Array[1]);
					//跳过第二节次记录
					$Element['节次'] = $节次."-".$第二节次;
					$iii ++;
					//print_R($有效时间22Array);print "<BR>";//exit;
				}
				//print_R($WeekDaySchedule);exit;


				$上课刷卡BGN = date("H:i",@mktime($有效时间0Array[0],$有效时间0Array[1]-$KaoqinTimeBegin1,30,12,12,2008));
				$上课刷卡END = date("H:i",@mktime($有效时间0Array[0],$有效时间0Array[1]+$KaoqinTimeBegin2,30,12,12,2008));
				$下课刷卡BGN = date("H:i",@mktime($有效时间1Array[0],$有效时间1Array[1]-$KaoqinTimeEnd1,30,12,12,2008));
				$下课刷卡END = date("H:i",@mktime($有效时间1Array[0],$有效时间1Array[1]+$KaoqinTimeEnd2,30,12,12,2008));
				$Element['上课实际刷卡'] = '';
				$Element['上课考勤状态'] = '';
				$Element['下课实际刷卡'] = '';
				$Element['下课考勤状态'] = '';

				$Element['上课刷卡BGN'] = $上课刷卡BGN;
				$Element['上课刷卡END'] = $上课刷卡END;
				$Element['下课刷卡BGN'] = $下课刷卡BGN;
				$Element['下课刷卡END'] = $下课刷卡END;

				//print_R($Element);exit;
				//班级实习周部分调整,如果该班级在当前周是实习或考试周次,那么教师考勤则不进行初始化
				$Banji_ShiXi_JiaoXueJinCheng = Banji_ShiXi_JiaoXueJinCheng($班级,$Element['周次'],$CurXueQi,$节假日调课_调整后时间);
				//教师代课过滤 结果有数据时表示,教师代课信息要进行重置
				$Teacher_DaiKe_Infor = Teacher_DaiKe_Infor($真实姓名,$教师用户名,$节假日调课_调整后时间,$Element['节次'],$课程,$CurXueQi);
				//教师停课过滤 结果有数据时表示,教师停课,不能进行新建操作
				$Teacher_TingKe_Infor = Teacher_TingKe_Infor($真实姓名,$教师用户名,$节假日调课_调整后时间,$Element['节次'],$课程,$CurXueQi);
				//教师复课过滤 结果有数据时表示,教师复课,但此表从课程表所来,一般情况下来,理论上课时间不会出现复课时间重复现象
				//$Teacher_FuKe_Infor = Teacher_FuKe_Infor($真实姓名,$节假日调课_调整后时间,$Element['节次'],$课程,$CurXueQi);
				if($Teacher_DaiKe_Infor!="")		{
					$Element['教师用户名']	= $Teacher_DaiKe_Infor;
					$Element['教师姓名']	= returntablefield('user',"USER_ID",$Teacher_DaiKe_Infor,"USER_NAME");
				}
				//教师调课过滤 结果为空时表示可以插入对应数据
				$Teacher_TiaoKe_Infor = Teacher_TiaoKe_Infor($真实姓名,$教师用户名,$节假日调课_调整后时间,$Element['节次'],$课程,$CurXueQi);
				//教师相互调课过滤 结果为空时表示可以插入对应数据
				$Teacher_TiaoKeXiangHu_Infor = Teacher_TiaoKeXiangHu_Infor($真实姓名,$教师用户名,$节假日调课_调整后时间,$Element['节次'],$课程,$CurXueQi);
				global $SHOWTEXT; if($SHOWTEXT&&sizeof($rs_a)>0)print_R($ShowData);
				global $SHOWTEXT; if($SHOWTEXT&&sizeof($rs_a)>0)print "<BR>课程:$课程 班级:$班级 ".$ShowData[$节假日调课_调整后时间]."-".$ShowData[$节假日调课_调整后时间]."-".$TiaoKeJieJiaRiExec['反向'][$节假日调课_调整后时间]."-".$Banji_ShiXi_JiaoXueJinCheng."-".$Teacher_TiaoKe_Infor."-".$Teacher_TiaoKeXiangHu_Infor."<BR>";
				//显示备注信息
				if($Teacher_TiaoKe_Infor!=''&&$SHOWTEXT==1)		{
					print "<BR><font color=green>::::::备注调课不能空: $Teacher_TiaoKe_Infor </font><BR>";
				}
				if($Teacher_TingKe_Infor!=''&&$SHOWTEXT==1)	{
					print "<BR><font color=green>::::::备注停课不能空: $Teacher_TingKe_Infor </font><BR>";
				}
				if($Teacher_TiaoKeXiangHu_Infor!=''&&$SHOWTEXT==1)	{
					print "<BR><font color=green>::::::备注相互调课不能空: $Teacher_TiaoKeXiangHu_Infor </font><BR>";
				}
				if($TiaoKeJieJiaRiExec['反向'][$节假日调课_调整后时间]!=''&&$SHOWTEXT==1)	{
					print "<BR><font color=green>::::::反向 $节假日调课_调整后时间: {$TiaoKeJieJiaRiExec['反向'][$节假日调课_调整后时间]} </font><BR>";
				}
				if($ShowData[$节假日调课_调整后时间]!=''&&$SHOWTEXT==1)	{
					print "<BR><font color=green>::::::节假日调课_调整后时间: {$ShowData[$节假日调课_调整后时间]} </font><BR>";
				}
				if($课程==''&&$SHOWTEXT==1)	{
					print "<BR><font color=green>::::::课程为空: $Teacher_TiaoKeXiangHu_Infor </font><BR>";
				}
				if($班级==''&&$SHOWTEXT==1)	{
					print "<BR><font color=green>::::::班级为空: $Teacher_TiaoKeXiangHu_Infor </font><BR>";
				}

				if($课程!=""&&
					$班级!=""&&
					$ShowData[$节假日调课_调整后时间]==""&&
					$TiaoKeJieJiaRiExec['反向'][$节假日调课_调整后时间]==""&&
					$Banji_ShiXi_JiaoXueJinCheng==""&&
					$Teacher_TiaoKe_Infor==''&&
					$Teacher_TingKe_Infor==''&&
					$Teacher_TiaoKeXiangHu_Infor==''
					)			{
					$ElementValue = array_values($Element);
					$sqlValueText = "'".join("','",$ElementValue)."'";
					$ElementName = array_keys($Element);
					$sqlNameText = "`".join("`,`",$ElementName)."`";
					//判断记录是否存在,如果存在则不进行插入操作
					$sql = "select COUNT(*) AS NUM from edu_teacherkaoqinmingxi where 教师姓名 ='$真实姓名' and 教师用户名 ='$教师用户名' and 考勤日期='$节假日调课_调整后时间' and 节次='".$Element['节次']."' and 课程='$课程' and 班级='$班级' ";
					$rs = $db->Execute($sql);
					global $SHOWTEXT; if($SHOWTEXT)print "<BR><font color=green>$sql </font><BR>";
					$NUM = $rs->fields['NUM'];
					if($NUM==0)		{
						$sql = "insert into edu_teacherkaoqinmingxi($sqlNameText) values($sqlValueText)";
						$db->Execute($sql);
					}
					else	{
						$sql = "数据已经存在 ".$sql;
					}
					global $SHOWTEXT; if($SHOWTEXT)print "<BR><font color=red>-----------$sql </font><BR>";
					//print_R($Element['节次']);print "教师:".$真实姓名.",班级:".$班级.",课程:".$课程.",星期:".$TargetWeekDay.",节次:$节次<BR>";
				}
				//if($WeekDaySchedule!=""&&$SHOWTEXT=="1")	{print_R($WeekDaySchedule);}
			}
			//if($WeekDaySchedule!="")	{exit;}

			//print $TargetWeekDay."<BR>";
		//}//exit;
	}//end for
	//print_infor();
	//EDU_Indextopage('?',$nums='0');

	//初始化时把没有填写的教学日记,标记为可以填写
	$最迟填写时间	=	date("Y-m-d",mktime(1,1,1,date('m'),date('d')+5,date('Y')));
	$当前日期		=	date("Y-m-d",mktime(1,1,1,date('m'),date('d'),date('Y')));
	//$sql = "update edu_teacherkaoqinmingxi set 最迟填写时间 ='$最迟填写时间' where 教师姓名='$默认教师名称' and 教师用户名='$教师用户名' and 授课内容='' and 学期='$CurXueQi' and 最迟填写时间<='$当前日期'";
	//$db->Execute($sql);
	//if($SHOWTEXT) print $sql;
}

//过滤字段中的空格
//update edu_teacherkaoqinmingxi set 班级=TRIM(班级)




//#######################################################################################
function returnJieCiTime($安排内容)  {
	return returntablefield("edu_timesetting","安排内容",$安排内容,"时间段");
}

function returnJieCiName($JieCi)   {
	switch($JieCi)		{
		case '1':
			$Text = "第一节课";
			break;
		case '2':
			$Text = "第二节课";
			break;
		case '3':
			$Text = "第三节课";
			break;
		case '4':
			$Text = "第四节课";
			break;
		case '5':
			$Text = "第五节课";
			break;
		case '6':
			$Text = "第六节课";
			break;
		case '7':
			$Text = "第七节课";
			break;
		case '8':
			$Text = "第八节课";
			break;
		case '9':
			$Text = "第九节课";
			break;
		case '10':
			$Text = "第十节课";
			break;
		case '11':
			$Text = "第十一节课";
			break;
		case '12':
			$Text = "第十二节课";
			break;

	}
	return $Text;
}


function DealTimeJieCiShangKe($教师姓名,$教师用户名,$考勤日期,$时间)		{
	global $db,$InsertData;
	global $KaoqinTimeBegin1,$KaoqinTimeBegin2,$KaoqinTimeEnd1,$KaoqinTimeEnd2,$KuangGongShiJian;
	//print $KuangGongShiJian;exit;
	//定义迟到打卡
	$时间Array = explode(':',$时间);
	$迟到时间 = date("H:i",mktime($时间Array[0],$时间Array[1]-$KuangGongShiJian,1,12,12,2009));
	$sql = "select * from edu_teacherkaoqinmingxi where 教师用户名='$教师用户名' and 考勤日期='$考勤日期' and 上课刷卡BGN<='$迟到时间' and 上课刷卡END>='$迟到时间'";
	$rs2 = $db->Execute($sql);
	$rs2_a = $rs2->GetArray();
	//print_R($rs2_a);
	for($iii=0;$iii<sizeof($rs2_a);$iii++)						{
		$编号 = $rs2_a[$iii]['编号'];
		$sql = "update edu_teacherkaoqinmingxi set 上课实际刷卡 = '$时间' ,上课考勤状态='上课迟到' where 编号='$编号'";
		$db->Execute($sql);
		$InsertData++;
		$returnText .= "$教师姓名 上课迟到 $考勤日期 $时间<BR>";
		global $SHOWTEXT; if($SHOWTEXT)print $sql."<BR>";
	}

	//定义正常打卡
	$sql = "select * from edu_teacherkaoqinmingxi where 教师用户名='$教师用户名' and 考勤日期='$考勤日期' and 上课刷卡BGN<='$时间' and 上课刷卡END>='$时间'";
	$rs2 = $db->Execute($sql);
	$rs2_a = $rs2->GetArray();
	//print_R($rs2_a);
	for($iii=0;$iii<sizeof($rs2_a);$iii++)						{
		$编号 = $rs2_a[$iii]['编号'];
		$sql = "update edu_teacherkaoqinmingxi set 上课实际刷卡 = '$时间' ,上课考勤状态='正常刷卡' where 编号='$编号'";
		$db->Execute($sql);
		$InsertData++;
		$returnText .= "$教师姓名 上课正常 $考勤日期 $时间<BR>";
		global $SHOWTEXT; if($SHOWTEXT)print "定义正常打卡上课:".$sql."<BR>";
	}
	//###########################################################################
	//同步教师听课考勤数据开始（上课）
	$sql = "select * from edu_tingke where 听课教师姓名='$教师姓名' and 听课日期='$考勤日期' and 上课刷卡BGN<='$迟到时间' and 上课刷卡END>='$迟到时间'";
	$rs2 = $db->Execute($sql);
	$rs2_a = $rs2->GetArray();
	global $SHOWTEXT; if($SHOWTEXT)print "同步教师听课考勤数据开始（上课）:".$sql."<BR>";
	//print_R($rs2_a);
	for($iii=0;$iii<sizeof($rs2_a);$iii++)						{
		$编号 = $rs2_a[$iii]['编号'];
		$lll=date("Y-m-d",strtotime($rs2_a[$iii]['听课日期'])+3*24*3600);
		$sql = "update edu_tingke set 上课打卡时间 = '$时间' ,上课考勤状态='上课迟到',最迟填写时间 = '$lll' where 编号='$编号'";
		$db->Execute($sql);
		$InsertData++;
		//$returnText .= "$教师姓名 上课迟到 $考勤日期 $时间<BR>";
		global $SHOWTEXT; if($SHOWTEXT)print "上课迟到:".$sql."<BR>";
	}
	$sql = "select * from edu_tingke where 听课教师姓名='$教师姓名' and 听课日期='$考勤日期' and 上课刷卡BGN<='$时间' and 上课刷卡END>='$时间'";
	$rs2 = $db->Execute($sql);
	$rs2_a = $rs2->GetArray();
	global $SHOWTEXT; if($SHOWTEXT)print "上课迟到:".$sql."<BR>";
	//print_R($rs2_a);
	for($iii=0;$iii<sizeof($rs2_a);$iii++)						{
		$编号 = $rs2_a[$iii]['编号'];
		$lll=date("Y-m-d",strtotime($rs2_a[$iii]['听课日期'])+3*24*3600);
		$sql = "update edu_tingke set 上课打卡时间 = '$时间' ,上课考勤状态='正常刷卡',最迟填写时间 = '$lll' where 编号='$编号'";
		$db->Execute($sql);
		$InsertData++;
		//$returnText .= "$教师姓名 上课正常 $考勤日期 $时间<BR>";
		global $SHOWTEXT; if($SHOWTEXT)print "正常刷卡上课:".$sql."<BR>";
	}
	//定义当天听课考勤情况,如果没有值,则直接定义为缺打卡
	$dateTEMP = date("Y-m-d");
	$sql = "update edu_tingke set 上课打卡时间='上课缺打卡',上课考勤状态='上课缺打卡' where 听课日期='$考勤日期' and (上课打卡时间='' or 上课打卡时间='上课缺勤')";
	$db->Execute($sql);
	//同步教师听课考勤数据结束（上课）
	//###########################################################################
	return $returnText;
}

function DealTimeJieCiXiaKe($教师姓名,$教师用户名,$考勤日期,$时间)		{
	global $db,$InsertData;
	$sql = "select * from edu_teacherkaoqinmingxi where 教师用户名='$教师用户名' and 考勤日期='$考勤日期' and 下课刷卡BGN<='$时间' and 下课刷卡END>='$时间'";
	$rs2 = $db->Execute($sql);
	$rs2_a = $rs2->GetArray();
	$returnText = "";
	for($iii=0;$iii<sizeof($rs2_a);$iii++)						{
		$编号 = $rs2_a[$iii]['编号'];
		$sql = "update edu_teacherkaoqinmingxi set 下课实际刷卡 = '$时间' ,下课考勤状态='正常刷卡' where 编号='$编号'";
		$db->Execute($sql);
		$InsertData++;
		$returnText .= "$教师姓名 下课正常 $考勤日期 $时间<BR>";
		global $SHOWTEXT; if($SHOWTEXT)print "定义正常打卡下课:".$sql."<BR>";
	}

	//###########################################################################
	//同步教师听课考勤数据开始（下课）
	$sql = "select * from edu_tingke where 听课教师姓名='$教师姓名' and 听课日期='$考勤日期' and 下课刷卡BGN<='$时间' and 下课刷卡END>='$时间'";
	$rs2 = $db->Execute($sql);
	$rs2_a = $rs2->GetArray();
	$returnText = "";
	for($iii=0;$iii<sizeof($rs2_a);$iii++)						{
		$编号 = $rs2_a[$iii]['编号'];
		$lll=date("Y-m-d",strtotime($rs2_a[$iii]['听课日期'])+3*24*3600);
		$sql = "update edu_tingke set 下课打卡时间 = '$时间' ,下课考勤状态='正常刷卡',最迟填写时间 = '$lll' where 编号='$编号'";
		$db->Execute($sql);
		$InsertData++;
		//$returnText .= "$教师姓名 下课正常 $考勤日期 $时间<BR>";
		global $SHOWTEXT; if($SHOWTEXT)print "定义正常打卡下课:".$sql."<BR>";
	}

	$dateTEMP = date("Y-m-d");
	$sql = "update edu_tingke set 下课打卡时间='下课缺打卡',下课考勤状态='下课缺打卡' where 听课日期<'$dateTEMP' and (下课打卡时间='' or 下课打卡时间='下课缺勤')";
	$db->Execute($sql);
	//同步教师听课考勤数据结束（下课）
	//###########################################################################
	return $returnText;
}



?><?php
/*
	版权归属:郑州单点科技软件有限公司;
	联系方式:0371-69663266;
	公司地址:河南郑州经济技术开发区第五大街经北三路通信产业园四楼西南;
	公司简介:郑州单点科技软件有限公司位于中国中部城市-郑州,成立于2007年1月,致力于把基于先进信息技术（包括通信技术）的最佳管理与业务实践普及到教育行业客户的管理与业务创新活动中，全面提供具有自主知识产权的教育管理软件、服务与解决方案，是中部最优秀的高校教育管理软件及中小学校管理软件提供商。目前已经有多家高职和中职类院校使用通达中部研发中心开发的软件和服务;

	软件名称:单点科技软件开发基础性架构平台,以及在其基础之上扩展的任何性软件作品;
	发行协议:数字化校园产品为商业软件,发行许可为LICENSE方式;单点CRM系统即SunshineCRM系统为GPLV3协议许可,GPLV3协议许可内容请到百度搜索;
	特殊声明:软件所使用的ADODB库,PHPEXCEL库,SMTARY库归原作者所有,余下代码沿用上述声明;
	*/
?>