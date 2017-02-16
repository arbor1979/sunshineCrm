<?php

$返回班次上班及下班打卡时间 = 返回班次上班及下班打卡时间();
//print_R($返回班次上班及下班打卡时间);
//exit;

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

function useridfilter($组员名称)			{
	global $db;
	$USER_NAME_TEXT = '';
	$组员名称Array = explode(',',$组员名称);
	for($i=0;$i<sizeof($组员名称Array);$i++)		{
		if($组员名称Array[$i]!="")	{
			$USER_INFOR	= returntablefield("user","USER_ID",$组员名称Array[$i],"USER_ID,DEPT_ID");
			$USER_ID = $USER_INFOR['USER_ID'];
			$DEPT_ID = $USER_INFOR['DEPT_ID'];
			if($USER_ID!=""&&$DEPT_ID>0)	$USER_NAME_TEXT	.= $USER_ID.",";
		}

	}
	return $USER_NAME_TEXT;
}


function 重新转化班次里面USER_NAME为USER_ID()		{
	global $db;
	$sql = "select 编号,组员名称 from edu_xingzheng_group";
	$rs = $db->Execute($sql);
	$rs_a = $rs->GetArray();
	for($i=0;$i<sizeof($rs_a);$i++)				{
		$编号 = $rs_a[$i]['编号'];
		$组员名称 = $rs_a[$i]['组员名称'];
		$组员名称结果 = usernametoid($组员名称);
		$sql = "update edu_xingzheng_group set 组员名称='$组员名称结果' where 编号='$编号'";
		$db->Execute($sql);
		//print $sql."<BR>";
	}//exit;
}

function 重新转化排班里面USER_NAME为USER_ID()		{
	global $db;
	$sql = "select 编号,排班人员 from edu_xingzheng_paiban";
	$rs = $db->Execute($sql);
	$rs_a = $rs->GetArray();
	for($i=0;$i<sizeof($rs_a);$i++)				{
		$编号 = $rs_a[$i]['编号'];
		$排班人员 = $rs_a[$i]['排班人员'];
		$USER_NAME = returntablefield('user',"USER_ID",$排班人员,"USER_NAME");
		if($USER_NAME=="")		{
			$排班人员结果 = usernametoid($排班人员);
			$sql = "update edu_xingzheng_paiban set 排班人员='$排班人员结果' where 编号='$编号'";
			$db->Execute($sql);
			//print $sql."<BR>";
		}
	}//exit;
}




function 修正增加教师用户名带来的空字段信息X()		{
	/*
	修正增加教师用户名带来的空字段信息_子函数X('edu_xingzheng_tiaoban','人员','人员用户名');
	修正增加教师用户名带来的空字段信息_子函数X('edu_xingzheng_qingjia','人员','人员用户名');
	修正增加教师用户名带来的空字段信息_子函数X('edu_xingzheng_kaoqinmingxi','人员','人员用户名');
	修正增加教师用户名带来的空字段信息_子函数X('edu_xingzheng_tiaobanxianghu','原人员','原人员用户名');
	修正增加教师用户名带来的空字段信息_子函数X('edu_xingzheng_tiaobanxianghu','新人员','新人员用户名');
	修正增加教师用户名带来的空字段信息_子函数X('edu_xingzheng_kaoqinbudeng','人员','人员用户名');
	修正增加教师用户名带来的空字段信息_子函数X('edu_xingzheng_jiabanbuxiu','人员','人员用户名');
	修正增加教师用户名带来的空字段信息_子函数X('edu_xingzheng_tiaoxiububan','人员','人员用户名');
	*/
}
function 修正增加教师用户名带来的空字段信息_子函数X($tablename,$教师='教师',$教师用户名='教师用户名')		{
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
		//$db->Execute($sql);
		print $sql."<BR>";
	}
}

//按节假日进行调班,行政人员需要
function 执行节假日调班函数()		{
	global $db;
	$sql = "select * from edu_schedulejiejiari"; // where 执行状态='0'
	$rs = $db->Execute($sql);
	$rs_a = $rs->GetArray();
	$NewArray = array();
	for($i=0;$i<sizeof($rs_a);$i++)				{
		$原上班时间 = $rs_a[$i]['原上班时间'];
		$调整后上班时间 = $rs_a[$i]['调整后上班时间'];
		$执行状态 = $rs_a[$i]['执行状态'];
		$NewArray['正向'][$调整后上班时间] = $原上班时间;
		$NewArray['反向'][$原上班时间] = $调整后上班时间;
	}
	return $NewArray;
}

//按时间进度对调班计划进行调度-需要进行整理-2010-2-27暂不做处理
function 调班计划执行函数()		{

}




//保留function returnWeekDayNumber() 内容在lib.xiaoli.inc.php文件里面
//保留function XiaoLiArray() 内容在lib.xiaoli.inc.php文件里面


//执行当前天是否为节假日,如果是节假日,那么则清空行政人员考勤数据表中当天所有考勤数据
$datetime = date("Y-m-d");
$sql = "select * from edu_schoolcalendar where 开始时间<='$datetime' and 结束时间>='$datetime' and 节假日!='开学'";
global $SHOWTEXT; if($SHOWTEXT)		print "<BR>".$sql."<HR>";
$rs = $db->Execute($sql);
$rs_a = $rs->GetArray();
$节假日 = $rs_a[0]['节假日'];
if($节假日!="")		{
	$sql = "delete from edu_xingzheng_kaoqinmingxi where 日期='$datetime'";
	global $SHOWTEXT; if($SHOWTEXT)print "<BR>".$sql."<HR>";
	$db->Execute($sql);
}




function 返回班次上班及下班打卡时间()  {
	global $db;
	$sql = "select * from edu_xingzheng_banci";
	$rs = $db->Execute($sql);
	$rs_a = $rs->GetArray();
	//编号 自动编号 班次名称 行政班次 考勤时间段 考勤时间段 上班提前打卡时间  下班提前打卡时间  上班延后打卡时间  下班延后打卡时间  旷工打卡时间  备注 备注 创建人 创建人ID 创建
	for($i=0;$i<sizeof($rs_a);$i++)		{
		$班次名称 = $rs_a[$i]['班次名称'];
		$考勤时间段 = $rs_a[$i]['考勤时间段'];
		$上班时间是否启用 = $rs_a[$i]['上班时间是否启用'];
		$下班时间是否启用 = $rs_a[$i]['下班时间是否启用'];
		$上班提前打卡时间 = $rs_a[$i]['上班提前打卡时间'];
		$上班延后打卡时间 = $rs_a[$i]['上班延后打卡时间'];
		$下班提前打卡时间 = $rs_a[$i]['下班提前打卡时间'];
		$下班延后打卡时间 = $rs_a[$i]['下班延后打卡时间'];
		$旷工打卡时间 = $rs_a[$i]['旷工打卡时间'];

		$迟到时间 = $rs_a[$i]['迟到时间'];
		$早退时间 = $rs_a[$i]['早退时间'];

		$考勤时间段Array = explode('-',$考勤时间段);
		$上班时间 = $考勤时间段Array[0];
		$下班时间 = $考勤时间段Array[1];
		$有效时间0Array = explode(':',$上班时间);
		$有效时间1Array = explode(':',$下班时间);
		$上班刷卡BGN = date("H:i",@mktime($有效时间0Array[0],$有效时间0Array[1]-$上班提前打卡时间,30,12,12,2008));
		$上班刷卡END = date("H:i",@mktime($有效时间0Array[0],$有效时间0Array[1]+$上班延后打卡时间,30,12,12,2008));

		$下班刷卡BGN = date("H:i",@mktime($有效时间1Array[0],$有效时间1Array[1]-$下班提前打卡时间,30,12,12,2008));
		$下班刷卡END = date("H:i",@mktime($有效时间1Array[0],$有效时间1Array[1]+$下班延后打卡时间,30,12,12,2008));

		$迟到时间 = date("H:i",@mktime($有效时间0Array[0],$有效时间0Array[1]+$上班延后打卡时间+$迟到时间,30,12,12,2008));
		$早退时间 = date("H:i",@mktime($有效时间1Array[0],$有效时间1Array[1]-$下班提前打卡时间-$早退时间,30,12,12,2008));
		//$旷工结束时间 = date("H:i",@mktime($有效时间0Array[0],$有效时间0Array[1]+$上班延后打卡时间+$旷工打卡时间,30,12,12,2008));

		$NewArray[$班次名称]['上班刷卡BGN'] = $上班刷卡BGN;
		$NewArray[$班次名称]['上班刷卡END'] = $上班刷卡END;
		$NewArray[$班次名称]['下班刷卡BGN'] = $下班刷卡BGN;
		$NewArray[$班次名称]['下班刷卡END'] = $下班刷卡END;
		$NewArray[$班次名称]['考勤时间段']  = $考勤时间段;
		$NewArray[$班次名称]['上班时间是否启用']  = $上班时间是否启用;
		$NewArray[$班次名称]['下班时间是否启用']  = $下班时间是否启用;

		$NewArray[$班次名称]['迟到时间']  = $迟到时间;
		$NewArray[$班次名称]['早退时间']  = $早退时间;

		//$NewArray[$班次名称]['旷工结束时间'] = $旷工结束时间;

	}
	return $NewArray;
}

function 返回考勤补登信息($学期,$人员,$人员用户名,$考勤日期,$班次='')			{
	global $db,$返回班次上班及下班打卡时间;
	$sql = "select 补登项目 from edu_xingzheng_kaoqinbudeng where 学期='$学期' and 人员用户名='$人员用户名' and 时间='$考勤日期' and 班次='$班次' and 审核状态='1'";
	$rs = $db->Execute($sql);
	$补登项目 = $rs->fields['补登项目'];
	return $补登项目;
}

function 返回请假外出信息($学期,$人员,$人员用户名,$考勤日期,$班次='')			{
	global $db,$返回班次上班及下班打卡时间;
	$sql = "select 人员 from edu_xingzheng_qingjia where 学期='$学期' and 人员用户名='$人员用户名' and 时间='$考勤日期' and 班次='$班次' and 审核状态='1'";
	$rs = $db->Execute($sql);
	$人员 = $rs->fields['人员'];
	if($人员!="") return "请假外出";
	else	return "";
}

//执行删除某人某天考勤信息
function 执行删除某人某天考勤信息($学期,$人员,$人员用户名,$考勤日期,$班次='')		{
	global $db,$返回班次上班及下班打卡时间;

	$sql = "delete from edu_xingzheng_kaoqinmingxi where 人员用户名 ='$人员用户名' and 日期='$考勤日期' and 学期='$学期' and 人员用户名='$人员用户名'";
	$db->Execute($sql);
}
//执行插入某人某天考勤信息
function 执行插入某人某天考勤信息($学期,$人员,$人员用户名,$考勤日期,$班次='')		{
	global $db,$返回班次上班及下班打卡时间;

	$sql = "select distinct 班次名称 from edu_xingzheng_paiban
			where (排班人员 like '%,$人员用户名,%' or 排班人员 like '$人员用户名,%') and 考勤日期='$考勤日期' and 学期名称='$学期'";
	$rs = $db->Execute($sql);
	$rs_a = $rs->GetArray();
	global $SHOWTEXT; if($SHOWTEXT)print  $sql."<BR>";;
	//print_R($rs_a);

	if($班次!="")	{
		//表示是一种指定班次的情况下,也有可能是调班情况,所以不能在排班信息中过滤,而是强制指定信息
		//方法:重新给RS_A变量赋值
		$rs_a = array();
		$rs_a[0]['班次名称'] = $班次;
	}

	//print_R($执行节假日调班函数);
	$执行节假日调班函数 = 执行节假日调班函数();
	$NewDatetime = $执行节假日调班函数['正向'][$Datetime];
	//NewDatetime的值为原上班时间,今天为调整后的上班时间
	//原上班时间的周次和星期被沿用,具体上班的时间用调整后的
	if($NewDatetime=='')	{
		$NewDatetime = $考勤日期;
	}
	else	{
		//该天有对换值,对执行状态进行更新
		$sql = "update edu_schedulejiejiari set 执行状态='1' where 调整后上班时间='$考勤日期'";
		$db->Execute($sql);
		global $SHOWTEXT; if($SHOWTEXT)print  $sql."<BR>";;
	}
	//if($ShowData[$考勤日期]==""&&$执行节假日调班函数['反向'][$考勤日期]==""&&$执行行政人员调班函数==''&&$行政人员相互调班状态=='')			{
	//}

	//过滤所得到的班次列表,进行过滤处理,在此已经插入到考勤数据表中
	for($i=0;$i<sizeof($rs_a);$i++)				{
		$班次名称 = $rs_a[$i]['班次名称'];

		//print_R($Element);exit;
		//人员代课过滤 结果为空时表示可以插入对应数据
		//$过滤行政人员代班 = 过滤行政人员代班($人员,$考勤日期,$班次名称,$学期);
		//人员调班过滤 结果为空时表示可以插入对应数据
		$执行行政人员调班函数 = 执行行政人员调班函数($人员,$人员用户名,$考勤日期,$班次名称,$学期);
		//人员相互调班过滤 结果为空时表示可以插入对应数据
		$行政人员相互调班状态 = 行政人员相互调班状态($人员,$人员用户名,$考勤日期,$班次名称,$学期);
		$行政人员补休状态 = 行政人员补休状态($人员,$人员用户名,$考勤日期,$班次名称,$学期);
		global $SHOWTEXT; if($SHOWTEXT&&sizeof($rs_a)>0)print "<BR>插入考勤数据部分:".$ShowData[$考勤日期]."-".$执行节假日调班函数['反向'][$考勤日期]."-".$执行行政人员调班函数."-".$行政人员相互调班状态."<BR>";

		//较验新的记录是否存在
		$sql = "select COUNT(*) AS NUM from edu_xingzheng_kaoqinmingxi where 学期='$学期' and 人员用户名='$人员用户名' and 日期='$考勤日期' and 班次='$班次名称'";
		$rs = $db->Execute($sql);
		$NUM = $rs->fields['NUM'];
		//不存在记录,执行插入操作
		if(	$NUM==0&&
			$ShowData[$考勤日期]==""&&
			$执行节假日调班函数['反向'][$考勤日期]==""&&
			$行政人员相互调班状态==''&&
			$行政人员补休状态==''
			)		{
			//$执行行政人员调班函数==''&&
			//编号  学期  部门  人员  日期  周次  星期  班次  上班实际刷卡  上班考勤状态  下班实际刷卡  下班考勤状态  上班刷卡BGN  上班刷卡END  下班刷卡BGN  下班刷卡END  创建时间
			$考勤日期Array = explode('-',$考勤日期);
			$星期 = date('w',mktime(1,1,1,$考勤日期Array[1],$考勤日期Array[2],$考勤日期Array[0]));
			$DEPT_ID = returntablefield("user","USER_ID",$人员用户名,"DEPT_ID");
			$部门 = returntablefield("department","DEPT_ID",$DEPT_ID,"DEPT_NAME");
			$Element['学期'] = $学期;
			$Element['部门'] = $部门;
			$Element['人员'] = $人员;
			$Element['人员用户名'] = $人员用户名;
			//有调班信息,则以新的时间为准进行计算
			if($执行行政人员调班函数['新上班时间']!="")		{
				$考勤日期 = $执行行政人员调班函数['新上班时间'];
				$考勤日期Array = explode('-',$考勤日期);
				$星期 = date('w',mktime(1,1,1,$考勤日期Array[1],$考勤日期Array[2],$考勤日期Array[0]));
				$Element['日期'] = $考勤日期;
				$Element['周次'] = returnCurWeekIndex($考勤日期);
				$班次名称		 = $执行行政人员调班函数['新班次'];
			}
			else	{
				$Element['日期'] = $考勤日期;
				$Element['周次'] = returnCurWeekIndex($考勤日期);

			}
			if($星期==0) $星期=7;
			$Element['星期'] = $星期;
			$Element['班次'] = $班次名称;

			$返回考勤补登信息 = 返回考勤补登信息($学期,$人员,$人员用户名,$考勤日期,$班次名称);
			$返回请假外出信息 = 返回请假外出信息($学期,$人员,$人员用户名,$考勤日期,$班次名称);
			if($返回班次上班及下班打卡时间[$班次名称]['上班时间是否启用']=="否")		{
				$Element['上班实际刷卡'] = '不用考勤';
				$Element['上班考勤状态'] = '不用考勤';
			}
			else if($返回考勤补登信息=="上班考勤补登")	{
				$Element['上班实际刷卡'] = '考勤补登';
				$Element['上班考勤状态'] = '考勤补登';
			}
			else if($返回请假外出信息=="请假外出")	{
				$Element['上班实际刷卡'] = '请假外出';
				$Element['上班考勤状态'] = '请假外出';
			}
			else	{
				$Element['上班实际刷卡'] = '';
				$Element['上班考勤状态'] = '';
			}

			if($返回班次上班及下班打卡时间[$班次名称]['下班时间是否启用']=="否")		{
				$Element['下班实际刷卡'] = '不用考勤';
				$Element['下班考勤状态'] = '不用考勤';
			}
			else if($返回考勤补登信息=="下班考勤补登")	{
				$Element['下班实际刷卡'] = '考勤补登';
				$Element['下班考勤状态'] = '考勤补登';
			}
			else if($返回请假外出信息=="请假外出")	{
				$Element['下班实际刷卡'] = '请假外出';
				$Element['下班考勤状态'] = '请假外出';
			}
			else	{
				$Element['下班实际刷卡'] = '';
				$Element['下班考勤状态'] = '';
			}

			$Element['上班刷卡BGN'] = $返回班次上班及下班打卡时间[$班次名称]['上班刷卡BGN'];
			$Element['上班刷卡END'] = $返回班次上班及下班打卡时间[$班次名称]['上班刷卡END'];
			$Element['下班刷卡BGN'] = $返回班次上班及下班打卡时间[$班次名称]['下班刷卡BGN'];
			$Element['下班刷卡END'] = $返回班次上班及下班打卡时间[$班次名称]['下班刷卡END'];

			$Element['上班迟到时间'] = $返回班次上班及下班打卡时间[$班次名称]['迟到时间'];
			$Element['下班早退时间'] = $返回班次上班及下班打卡时间[$班次名称]['早退时间'];
			$Element['迟到分钟数']   = '';
			$Element['早退分钟数']   = '';
			//$Element['旷工结束时间'] = $返回班次上班及下班打卡时间[$班次名称]['旷工结束时间'];

			$Element['创建时间'] = date('Y-m-d H:i:s');

			$ElementValue = array_values($Element);
			$sqlValueText = "'".join("','",$ElementValue)."'";
			$ElementName = array_keys($Element);
			$sqlNameText = "`".join("`,`",$ElementName)."`";
			$sql = "insert into edu_xingzheng_kaoqinmingxi($sqlNameText) values($sqlValueText)";
			if($人员用户名!="")		{
				$db->Execute($sql);
				global $SHOWTEXT; if($SHOWTEXT)print "<BR><font color=red>$sql </font><BR>";
			}
		}
	}//end for
	return $NewArray;
	//print_R($rs_a);
}


//同步某人某天考勤机数据到考勤明细表
function 同步某人某天考勤机数据到考勤明细表($人员姓名,$人员用户名,$考勤日期)			{
	global $db;
	global $SHOWTEXT; if($SHOWTEXT)print "<BR>同步人员当天考勤数据====================================================<BR>";
	$sql = "select * from edu_teacherkaoqin where 考勤日期='$考勤日期' and 教师姓名='$人员姓名' and 教师用户名='$人员用户名'";
	global $SHOWTEXT; if($SHOWTEXT)print $sql."<BR>";
	$rs2 = $db->Execute($sql);
	$rs2_a = $rs2->GetArray();
	for($iii=0;$iii<sizeof($rs2_a);$iii++)						{
		$刷卡时间 = $rs2_a[$iii]['刷卡时间'];
		$教师用户名 = $rs2_a[$iii]['教师用户名'];
		//判断重名的用户名,不在行政考勤中使用
		$处理某人某时上班下班时间数据 = 处理某人某时上班下班时间数据($人员姓名,$人员用户名,$考勤日期,$刷卡时间);
		//$处理某人某时上班下班时间数据 = 处理某人某时上班下班时间数据($人员姓名,$人员用户名,$考勤日期,$刷卡时间);
	}
	global $SHOWTEXT; if($SHOWTEXT)print "<BR>同步人员当天考勤数据====================================================";
	global $SHOWTEXT; if($SHOWTEXT&&sizeof($rs_a)>0)print_R($rs_a);;
}


/* 2010-2-27日函数封存
function 过滤行政人员代班($人员,$上班时间,$班次,$学期)		{
	global $db;
	//编号  学期  班级  教室  课程  原人员  新人员  上班时间  班次  审核状态  工作流ID号  审核人  审核时间
	$sql = "select 编号 from edu_scheduledaike where 原人员='$人员' and 上班时间='$上班时间' and 班次='$班次' and 课程='$课程' and 审核状态='1'";
	$rs = $db->Execute($sql);
	$rs_a = $rs->GetArray();
	$编号 = $rs_a[0]['编号'];
	global $SHOWTEXT; if($SHOWTEXT)print "<BR><font color=green><B>$sql</B></font><BR>";
	if($编号!="")		{
		$sql = "delete from edu_xingzheng_kaoqinmingxi where 学期='$学期' and 人员='$人员' and 课程='$课程' and 日期='$上班时间' and 班次='$班次'";
		$db->Execute($sql);
		global $SHOWTEXT; if($SHOWTEXT)print "人员代课过滤<BR><font color=red><B>$sql</B></font><BR>";
		global $SHOWTEXT; if($SHOWTEXT&&sizeof($rs_a)>0)print_R($rs_a);;
	}
	return $编号;
}
*/

//人员调班过滤,调班过滤方法:先删除已经存在的数据,然后得到新的上班时间和班次信息,重新赋值上班时间和班次
function 执行行政人员调班函数($人员,$人员用户名,$上班时间,$班次,$学期)		{
	global $db,$返回班次上班及下班打卡时间;
	//编号  学期  部门  人员  原上班时间  原班次  新上班时间  新班次  审核状态  工作流ID号  审核人  审核时间
	$sql = "select * from edu_xingzheng_tiaoban where 人员用户名='$人员用户名' and 原上班时间='$上班时间' and 原班次='$班次' and 审核状态='1'";
	$rs = $db->Execute($sql);
	$rs_a = $rs->GetArray();
	$编号 = $rs_a[0]['编号'];
	$人员 = $rs_a[0]['人员'];
	$新上班时间 = $rs_a[0]['新上班时间'];
	$新班次 = $rs_a[0]['新班次'];
	$NewArray = array();
	//print "<BR>".$sql;exit;
	global $SHOWTEXT; if($SHOWTEXT)	print "<BR><font color=green><B>$sql</B></font><BR>";
	if($编号!="")		{
		//print $sql."调班表<BR>";
		//删除旧考勤数据
		$sql = "delete from edu_xingzheng_kaoqinmingxi where 学期='$学期' and 人员用户名='$人员用户名' and 日期='$上班时间' and 班次='$班次'";
		$db->Execute($sql);
		//print "<BR>".$sql;exit;
		//删除新考勤数据
		$sql = "delete from edu_xingzheng_kaoqinmingxi where 学期='$学期' and 人员用户名='$人员用户名' and 日期='$新上班时间' and 班次='$新班次'";
		$db->Execute($sql);
		//print "<BR>".$sql;exit;
		global $SHOWTEXT; if($SHOWTEXT)print "人员调班过滤<BR><font color=red><B>$sql</B></font><BR>";
		global $SHOWTEXT; if($SHOWTEXT&&sizeof($rs_a)>0)print_R($rs_a);;
		$NewArray['新上班时间'] = $新上班时间;
		$NewArray['新班次'] = $新班次;
		//print $sql."$编号X<BR>";exit;
	}

	return $NewArray;
}


//人员相互调班过滤
function 行政人员相互调班状态($人员,$人员用户名,$上班时间,$班次,$学期)		{
	global $db;
	// 编号  学期  班级  教室  人员  课程  原上班时间  原班次  新上班时间  新班次  审核状态  工作流ID号  审核人  审核时间
	$sql = "select 编号 from edu_xingzheng_tiaobanxianghu where ((原人员用户名='$人员用户名' and 原上班时间='$上班时间' and 原班次='$班次') or (新人员用户名='$人员用户名' and 新上班时间='$上班时间' and 新班次='$班次') ) and 审核状态='1'";
	global $SHOWTEXT; if($SHOWTEXT)print "<BR><font color=green><B>$sql</B></font><BR>";
	$rs = $db->Execute($sql);
	$rs_a = $rs->GetArray();
	$编号 = $rs_a[0]['编号'];
	global $SHOWTEXT; if($SHOWTEXT&&sizeof($rs_a)>0)print_R($rs_a);;
	return $编号;
}

//编号  学期  部门  人员  加班时间  加班班次  补休时间  补休班次  加班审核状态  加班工作流ID号  加班审核人  加班审核时间  补休审核状态  补休工作流ID号  补休审核人  补休审核时间
//人员补休过滤
function 行政人员补休状态($人员,$人员用户名,$上班时间,$班次,$学期)		{
	global $db;
	// 编号  学期  班级  教室  人员  课程  原上班时间  原班次  新上班时间  新班次  审核状态  工作流ID号  审核人  审核时间
	$sql = "select 编号 from edu_xingzheng_jiabanbuxiu where 人员用户名='$人员用户名' and 补休时间='$上班时间' and 补休班次='$班次' and 补休审核状态='1'";
	global $SHOWTEXT; if($SHOWTEXT)print "<BR><font color=green><B>$sql</B></font><BR>";
	$rs = $db->Execute($sql);
	$rs_a = $rs->GetArray();
	$编号 = $rs_a[0]['编号'];
	global $SHOWTEXT; if($SHOWTEXT&&sizeof($rs_a)>0)print_R($rs_a);;
	return $编号;
}



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

function 处理迟到早退分钟数数据()		{
	global $db;
	//处理迟到的分钟数	人员='$人员姓名' and 日期='$考勤日期' and
	$sql = "select * from edu_xingzheng_kaoqinmingxi where
			上班实际刷卡<上班迟到时间
			and 上班实际刷卡>上班刷卡END
			and LENGTH(上班实际刷卡)=5
			and 上班迟到时间!=''
			and 上班实际刷卡!=''
			and 上班刷卡END!=''
			and 迟到分钟数=''
			";
	global $SHOWTEXT; if($SHOWTEXT) print "<BR><font color=orange>处理迟到分钟数:".$sql."</font>";
	//print $sql."<BR>";exit;
	$rs = $db->Execute($sql);
	$rs_a = $rs->GetArray();
	for($iii=0;$iii<sizeof($rs_a);$iii++)						{
		$编号 = $rs_a[$iii]['编号'];
		$上班实际刷卡 = $rs_a[$iii]['上班实际刷卡'];
		$上班刷卡END = $rs_a[$iii]['上班刷卡END'];
		$上班实际刷卡Array = explode(':',$上班实际刷卡);
		$上班刷卡ENDArray = explode(':',$上班刷卡END);
		$上班实际刷卡时间线 = mktime($上班实际刷卡Array[0],$上班实际刷卡Array[1],1,12,12,2009);
		$上班刷卡END时间线 = mktime($上班刷卡ENDArray[0],$上班刷卡ENDArray[1],1,12,12,2009);
		//print $上班实际刷卡时间线."<BR>";
		//print $上班迟到时间时间线."<BR>";
		$迟到分钟数 = ($上班实际刷卡时间线-$上班刷卡END时间线)/60;
		$迟到分钟数 = floor($迟到分钟数);
		$sql = "update edu_xingzheng_kaoqinmingxi set 迟到分钟数 = '$迟到分钟数' where 编号='$编号'";
		$db->Execute($sql);
		global $SHOWTEXT; if($SHOWTEXT) print "<BR><font color=orange>处理迟到分钟数:".$sql."</font>";//exit;
	}


	//处理早退的分钟数
	$sql = "select * from edu_xingzheng_kaoqinmingxi where
			下班实际刷卡>下班早退时间
			and 下班实际刷卡<下班刷卡BGN
			and LENGTH(下班实际刷卡)=5
			and 下班早退时间!=''
			and 下班实际刷卡!=''
			and 下班刷卡BGN!=''
			and 早退分钟数=''
			";//
	//print $sql."<BR>";exit;
	global $SHOWTEXT; if($SHOWTEXT) print "<BR><font color=orange>处理早退分钟数:".$sql."</font>";
	$rs = $db->Execute($sql);
	$rs_a = $rs->GetArray();
	for($iii=0;$iii<sizeof($rs_a);$iii++)						{
		$编号 = $rs_a[$iii]['编号'];
		$下班实际刷卡 = $rs_a[$iii]['下班实际刷卡'];
		$下班刷卡BGN = $rs_a[$iii]['下班刷卡BGN'];
		$下班实际刷卡Array = explode(':',$下班实际刷卡);
		$下班刷卡BGNArray = explode(':',$下班刷卡BGN);
		$下班实际刷卡时间线 = mktime($下班实际刷卡Array[0],$下班实际刷卡Array[1],1,12,12,2009);
		$下班刷卡BGN时间线 = mktime($下班刷卡BGNArray[0],$下班刷卡BGNArray[1],1,12,12,2009);
		//print $下班实际刷卡时间线."<BR>";
		//print $下班早退时间时间线."<BR>";
		$早退分钟数 = ($下班刷卡BGN时间线-$下班实际刷卡时间线)/60;
		$早退分钟数 = floor($早退分钟数);
		$sql = "update edu_xingzheng_kaoqinmingxi set 早退分钟数 = '$早退分钟数' where 编号='$编号'";
		$db->Execute($sql);
		global $SHOWTEXT; if($SHOWTEXT) print "<BR><font color=orange>处理早退分钟数:".$sql."</font>";//exit;
	}
}
function 处理某人某时上班下班时间数据($人员姓名,$人员用户名,$考勤日期,$时间)		{
	global $db,$InsertData;
	//print $KuangGongShiJian;exit;
	//定义迟到打卡
	$时间Array = explode(':',$时间);
	$迟到时间 = date("H:i",mktime($时间Array[0],$时间Array[1],1,12,12,2009));
	//2010-2-26日启用新代码

	//迟到且早退,优先级最低 上班状态
	$sql = "update edu_xingzheng_kaoqinmingxi
			set 上班实际刷卡 = '$时间' ,上班考勤状态='迟到且早退'
			where
			人员用户名='$人员用户名'
			and 日期='$考勤日期'
			and 上班迟到时间<='$时间'
			and 下班早退时间>='$时间'
			and 上班考勤状态!='正常刷卡'
			and 上班考勤状态!='上班迟到'
			and 上班考勤状态!='下班早退'
			";
	$db->Execute($sql);

	//迟到且早退,优先级最低 下班状态
	$sql = "update edu_xingzheng_kaoqinmingxi
			set 下班实际刷卡 = '$时间' ,下班考勤状态='迟到且早退'
			where
			人员用户名='$人员用户名'
			and 日期='$考勤日期'
			and 上班迟到时间<='$时间'
			and 下班早退时间>='$时间'
			and 下班考勤状态!='正常刷卡'
			and 下班考勤状态!='上班迟到'
			and 下班考勤状态!='下班早退'
			";
	$db->Execute($sql);

	//上班迟到,同时计算迟到分钟数,先要判断是否是正常状态
	$sql = "update edu_xingzheng_kaoqinmingxi
			set 上班实际刷卡 = '$时间' ,上班考勤状态='上班迟到'
			where
			人员用户名='$人员用户名'
			and 日期='$考勤日期'
			and 上班刷卡END<='$时间'
			and 上班迟到时间>='$时间'
			and 上班考勤状态!='正常刷卡'
			";
	$db->Execute($sql);

	//下班早退,同时计算早退分钟数,先要判断是否是正常状态
	$sql = "update edu_xingzheng_kaoqinmingxi
			set 下班实际刷卡 = '$时间' ,下班考勤状态='下班早退'
			where
			人员用户名='$人员用户名'
			and 日期='$考勤日期'
			and 下班早退时间<='$时间'
			and 下班刷卡BGN>='$时间'
			and 下班考勤状态!='正常刷卡'
			";
	$db->Execute($sql);

	//上班正常
	$sql = "update edu_xingzheng_kaoqinmingxi
			set 上班实际刷卡 = '$时间' ,上班考勤状态='正常刷卡'
			where
			人员用户名='$人员用户名'
			and 日期='$考勤日期'
			and 上班刷卡BGN<='$时间'
			and 上班刷卡END>='$时间'
			";
	$db->Execute($sql);

	//下班正常
	$sql = "update edu_xingzheng_kaoqinmingxi
			set 下班实际刷卡 = '$时间' ,下班考勤状态='正常刷卡'
			where
			人员用户名='$人员用户名'
			and 日期='$考勤日期'
			and 下班刷卡BGN<='$时间'
			and 下班刷卡END>='$时间'
			";
	$db->Execute($sql);


	/*2010-2-26日代码封存,转用新代码
	$sql = "select * from edu_xingzheng_kaoqinmingxi where 人员='$人员姓名' and 日期='$考勤日期' and 上班刷卡BGN<='$迟到时间' and 上班刷卡END>='$迟到时间'";
	$rs2 = $db->Execute($sql);
	$rs2_a = $rs2->GetArray();
	//print_R($rs2_a);
	for($iii=0;$iii<sizeof($rs2_a);$iii++)						{
		$编号 = $rs2_a[$iii]['编号'];
		$sql = "update edu_xingzheng_kaoqinmingxi set 上班实际刷卡 = '$时间' ,上班考勤状态='上班迟到' where 编号='$编号'";
		$db->Execute($sql);
		$InsertData++;
		$returnText .= "$人员姓名 上班迟到 $考勤日期 $时间<BR>";
		//print $sql."<BR>";
	}
	//定义正常打卡
	$sql = "select * from edu_xingzheng_kaoqinmingxi where 人员='$人员姓名' and 日期='$考勤日期' and 上班刷卡BGN<='$时间' and 上班刷卡END>='$时间'";
	$rs2 = $db->Execute($sql);
	$rs2_a = $rs2->GetArray();
	//print_R($rs2_a);
	for($iii=0;$iii<sizeof($rs2_a);$iii++)						{
		$编号 = $rs2_a[$iii]['编号'];
		$sql = "update edu_xingzheng_kaoqinmingxi set 上班实际刷卡 = '$时间' ,上班考勤状态='正常刷卡' where 编号='$编号'";
		$db->Execute($sql);
		$InsertData++;
		$returnText .= "$人员姓名 上班正常 $考勤日期 $时间<BR>";
		//print $sql."<BR>";
	}*/
	return $returnText;
}

function 处理某人某时下班时间数据($人员姓名,$人员用户名,$考勤日期,$时间)		{
	global $db,$InsertData;
	//2010-2-26日启用新代码
	//$sql = "update edu_xingzheng_kaoqinmingxi set 下班实际刷卡 = '$时间' ,下班考勤状态='正常刷卡' where 			人员='$人员姓名' and 日期='$考勤日期' and 下班刷卡BGN<='$时间' and 下班刷卡END>='$时间'";
	//$db->Execute($sql);
	/*2010-2-26日代码封存,转用新代码
	$sql = "select * from edu_xingzheng_kaoqinmingxi where 人员='$人员姓名' and 日期='$考勤日期' and 下班刷卡BGN<='$时间' and 下班刷卡END>='$时间'";
	$rs2 = $db->Execute($sql);
	$rs2_a = $rs2->GetArray();
	$returnText = "";
	for($iii=0;$iii<sizeof($rs2_a);$iii++)						{
		$编号 = $rs2_a[$iii]['编号'];
		$sql = "update edu_xingzheng_kaoqinmingxi set 下班实际刷卡 = '$时间' ,下班考勤状态='正常刷卡' where 编号='$编号'";
		$db->Execute($sql);
		$InsertData++;
		$returnText .= "$人员姓名 下班正常 $考勤日期 $时间<BR>";
		//print $sql."<BR>";
	}*/
	return $returnText;
}



?>