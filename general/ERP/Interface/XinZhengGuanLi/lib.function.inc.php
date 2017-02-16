<?php

function 根据学期归档算法返回数据表名称($TableName='edu_teacherkaoqinmingxi')		{
	global $db,$学期名称,$_GET;
	if($学期名称==''&&$_GET['CurXueQi']!="")			{
		$学期名称 = $_GET['CurXueQi'];
	}
	if($学期名称!=""&&$_SESSION['学期归档算法需要使用的学期名称']=="")											{
		SESSION_REGISTER("学期归档算法需要使用的学期名称");
		$_SESSION['学期归档算法需要使用的学期名称'] = $学期名称;
	}
	if($学期名称!=""&&$学期名称!=$_SESSION['学期归档算法需要使用的学期名称'])			{
		$_SESSION['学期归档算法需要使用的学期名称'] = $学期名称;
	}
	$学期信息	= returntablefield("edu_xueqiexec","学期名称",$_SESSION['学期归档算法需要使用的学期名称'],"流水号,当前学期");
	$学期流水号 = $学期信息['流水号'];
	$当前学期	= $学期信息['当前学期'];
	if($当前学期==1)							{
		return $TableName;
	}
	elseif($学期流水号!="")  {
		return $TableName."___".$学期流水号;
	}
	else	{
		return $TableName;
	}
}


function 判断招生数据是否完成()											{
	global $db;
	return '';exit;
	if($_GET['action']==''||$_GET['action']=='init_default')					{
		$sql = "select COUNT(*) AS NUM from edu_newstudent where 是否转移学籍 ='1'";
		$rs  = $db->Execute($sql);
		if($rs->fields['NUM']>0)			{
			page_css("在新生系统存在新生数据");
			print_infor("在新生系统存在新生数据,请先处理完新生录取以及报到工作,转完成学籍,结束完新生工作以后,再来操作此模块");
			exit;
		}
	}
}



function 增加对学期归档查询数据的支持($目标判断字段)					{
	global $db,$SYSTEM_ADD_SQL,$SYSTEM_PRINT_SQL;
	global $增加对查询日期快捷方式的支持_是否启用,$_GET,$filetablename_old;
	$增加对查询日期快捷方式的支持_是否启用 = 1;
	session_register("增加对学期归档查询数据的支持");
	session_register("增加对学期归档查询数据的支持_学期");

	$当前学期 = returntablefield("edu_xueqiexec","当前学期",'1',"学期名称");

	if($_GET['CurXueQi']==""&&$_SESSION['增加对学期归档查询数据的支持_学期'] == "")		{
		$_GET['CurXueQi'] = $当前学期;
	}
	if($_GET['CurXueQi']==""&&$_SESSION['增加对学期归档查询数据的支持_学期'] != "")			{
		$_GET['CurXueQi'] = $_SESSION['增加对学期归档查询数据的支持_学期'];
	}
	$_GET['学期']	= $_GET['CurXueQi'];

	if($_SESSION['增加对学期归档查询数据的支持'] == ""||
			substr($_SESSION['增加对学期归档查询数据的支持'],0,strlen($filetablename_old))	!=	$filetablename_old
							)					{
		$_SESSION['增加对学期归档查询数据的支持'] = $filetablename_old;
		$_SESSION['增加对学期归档查询数据的支持_学期']	= $当前学期;
	}
	//print $_SESSION['增加对学期归档查询数据的支持'];

	$sql  = "SHOW TABLES LIKE '".$filetablename_old."%'";
	$rs   = $db->CacheExecute(150,$sql);
	$归档学期表数组 = $rs->GetArray();
	for($i=0;$i<sizeof($归档学期表数组);$i++)			{
		$TEMPARRAY = array_values($归档学期表数组[$i]);
		$TableNameArray[] = $TEMPARRAY[0];
	}
	//print_R($TableNameArray);
	$sql="select 学期名称,流水号,当前学期 from edu_xueqiexec";
	$rs	=$db->CacheExecute(150,$sql);//print_R($rs->GetArray());
	$学期文本 .= "&nbsp;<select class=\"SmallSelect\" name=\"CurXueQi\" onChange=\"var jmpURL='?XX=XX&action=".$_GET['action']."&CurXueQi=' + this.options[this.selectedIndex].value ; if(jmpURL!='') {window.location=jmpURL;} else {this.selectedIndex=0 ;}\"
	>\n";
	while(!$rs->EOF)								{
		$学期名称	= $rs->fields['学期名称'];
		$流水号		= $rs->fields['流水号'];
		$当前学期	= $rs->fields['当前学期'];
		$新表名		= $filetablename_old."___".$流水号;
		if(in_array($新表名,$TableNameArray)||$当前学期==1)			{
			if($_GET['CurXueQi']==$rs->fields['学期名称'])			{
				$temp='selected';
				if($_SESSION['增加对学期归档查询数据的支持']!='')					{
					if($当前学期==1)		{
						$_SESSION['增加对学期归档查询数据的支持']		= $filetablename_old;
						$_SESSION['增加对学期归档查询数据的支持_学期']	= $学期名称;
					}
					else	{
						$_SESSION['增加对学期归档查询数据的支持']		= $新表名;
						$_SESSION['增加对学期归档查询数据的支持_学期']	= $学期名称;
					}
				}
			}
			$学期文本 .= "<option value=\"".$rs->fields['学期名称']."\" $temp>".$rs->fields['学期名称']."</option>\n";
		}
		$temp='';
		$rs->MoveNext();
	}
	$学期文本 .= "</select>\n";


	if(($_GET['action']==""||$_GET['action']=="init_default"))			{
		print "<form name=formadd><table class=TableBlock width=100% ><tr><td nowrap class=TableContent align=left>";
		print "<font color=green>当前查阅的数据来源:</font>";
		print $学期文本;
		print "</font></td></tr></table></form><BR>";

	}

	//$SYSTEM_PRINT_SQL = "1";

}

function addShortCutByDate($目标判断字段)					{
	global $db,$SYSTEM_ADD_SQL,$SYSTEM_PRINT_SQL;
	global $增加对查询日期快捷方式的支持_是否启用;
	$增加对查询日期快捷方式的支持_是否启用 = 1;
	session_register("增加对查询日期快捷方式的支持");
	if($_SESSION['增加对查询日期快捷方式的支持']=='')					{
		$_SESSION['增加对查询日期快捷方式的支持'] = '设置为1';
	}
	if($_GET['增加对查询日期快捷方式的支持GET']=="设置为0")					{
		$_SESSION['增加对查询日期快捷方式的支持'] = '设置为0';
	}
	elseif($_GET['增加对查询日期快捷方式的支持GET']=="设置为1")					{
		$_SESSION['增加对查询日期快捷方式的支持'] = '设置为1';
	}
	//print $_SESSION['增加对查询日期快捷方式的支持'];

	if(($_GET['action']==""||$_GET['action']=="init_default")&&$_SESSION['增加对查询日期快捷方式的支持']=='设置为1')			{
		print "<form name=formadd><table class=TableBlock width=100% ><tr><td nowrap class=TableContent align=left>";
		if($_GET['当前搜索方式']=="当天")	$_GET['当前搜索方式'] = "当天&nbsp;&nbsp;&nbsp;&nbsp;";
		if($_GET['当前搜索方式']=="")		$_GET['当前搜索方式'] = "没有选择";
		print "<font color=green>按".$目标判断字段."搜索:".$_GET['当前搜索方式']."";

		$FormPageAction = FormPageAction("开始时间ADD",date("Y-m-d",mktime(0,0,1,date("m"),date("d"),date("Y"))),
											"结束时间ADD",date("Y-m-d",mktime(0,0,1,date("m"),date("d"),date("Y"))),
											'',
											"当前搜索方式","当天"
										);
		print "&nbsp;&nbsp;<a href=\"?$FormPageAction\">当天</a>";

		$FormPageAction = FormPageAction("开始时间ADD",date("Y-m-d",mktime(0,0,1,date("m"),date("d")-3,date("Y"))),
											"结束时间ADD",date("Y-m-d",mktime(0,0,1,date("m"),date("d"),date("Y"))),
											'',
											"当前搜索方式","最近三天"
										);
		print "&nbsp;&nbsp;<a href=\"?$FormPageAction\">最近三天</a>";

		$FormPageAction = FormPageAction("开始时间ADD",date("Y-m-d",mktime(0,0,1,date("m"),date("d")-7,date("Y"))),
											"结束时间ADD",date("Y-m-d",mktime(0,0,1,date("m"),date("d"),date("Y"))),
											'',
											"当前搜索方式","最近一周"
										);
		print "&nbsp;&nbsp;<a href=\"?$FormPageAction\">最近一周</a>";

		$FormPageAction = FormPageAction("开始时间ADD",date("Y-m-d",mktime(0,0,1,date("m"),date("d")-15,date("Y"))),
											"结束时间ADD",date("Y-m-d",mktime(0,0,1,date("m"),date("d"),date("Y"))),
											'',
											"当前搜索方式","最近半月"
										);
		print "&nbsp;&nbsp;<a href=\"?$FormPageAction\">最近半月</a>";

		$FormPageAction = FormPageAction("开始时间ADD",date("Y-m-d",mktime(0,0,1,date("m")-1,date("d"),date("Y"))),
											"结束时间ADD",date("Y-m-d",mktime(0,0,1,date("m"),date("d"),date("Y"))),
											'',
											"当前搜索方式","最近一月"
										);
		print "&nbsp;&nbsp;<a href=\"?$FormPageAction\">最近一月</a>";

		$FormPageAction = FormPageAction("开始时间ADD",date("Y-m-d",mktime(0,0,1,date("m")-2,date("d"),date("Y"))),
											"结束时间ADD",date("Y-m-d",mktime(0,0,1,date("m"),date("d"),date("Y"))),
											'',
											"当前搜索方式","最近两月"
										);
		print "&nbsp;&nbsp;<a href=\"?$FormPageAction\">最近两月</a>";

		$FormPageAction = FormPageAction("开始时间ADD",date("Y-m-d",mktime(0,0,1,date("m")-3,date("d"),date("Y"))),
											"结束时间ADD",date("Y-m-d",mktime(0,0,1,date("m"),date("d"),date("Y"))),
											'',
											"当前搜索方式","最近三月"
										);
		print "&nbsp;&nbsp;<a href=\"?$FormPageAction\">最近三月</a>";

		$FormPageAction = FormPageAction("开始时间ADD",date("Y-m-d",mktime(0,0,1,date("m")-6,date("d"),date("Y"))),
											"结束时间ADD",date("Y-m-d",mktime(0,0,1,date("m"),date("d"),date("Y"))),
											'',
											"当前搜索方式","最近六月"
										);
		print "&nbsp;&nbsp;<a href=\"?$FormPageAction\">最近六月</a>";

		print "&nbsp;&nbsp;<a href='?".FormPageAction("增加对查询日期快捷方式的支持GET","设置为0")."'><font color=gray>关闭显示</font></a>";

		print "</font></td></tr></table></form><BR>";
		if($_GET['开始时间ADD']!=""&&$_GET['结束时间ADD']!="")				{
			$SYSTEM_ADD_SQL .= "and $目标判断字段>='".$_GET['开始时间ADD']." 00:00:00' and $目标判断字段<='".$_GET['结束时间ADD']." 23:59:59'";
		}

	}

	//$SYSTEM_PRINT_SQL = "1";

}


function 初始化教师考勤里面错误周次信息($当前学期)		{
	global $db;
	$sql = "select 周次,考勤日期 from edu_teacherkaoqinmingxi where 周次<='0' and 学期='$当前学期'";
	$rs = $db->CacheExecute(30,$sql);
	$rs_a = $rs->GetArray();
	for($i=0;$i<sizeof($rs_a);$i++)		{
		$考勤日期 = $rs_a[$i]['考勤日期'];
		$周次 = $rs_a[$i]['周次'];
		$新周次	= returnCurWeekIndex($考勤日期);
		$sql = "update edu_teacherkaoqinmingxi set 周次='$新周次' where 周次='$周次'";
		$db->Execute($sql);
		//print $sql."<BR>";
	}

	$sql = "select 周次,考勤日期 from edu_studentkaoqin where 周次<='0' and 学期名称='$当前学期'";
	$rs = $db->CacheExecute(30,$sql);
	$rs_a = $rs->GetArray();
	for($i=0;$i<sizeof($rs_a);$i++)		{
		$考勤日期 = $rs_a[$i]['考勤日期'];
		$周次 = $rs_a[$i]['周次'];
		$新周次	= returnCurWeekIndex($考勤日期);
		$sql = "update edu_studentkaoqin set 周次='$新周次' where 周次='$周次'";
		$db->Execute($sql);
		//print $sql."<BR>";
	}

}


function 重新初始化教师考勤里面周次信息($当前学期)		{
	global $db;
	$sql = "select 考勤日期 from edu_teacherkaoqinmingxi where 学期='$当前学期' group by 考勤日期";
	$rs = $db->CacheExecute(30,$sql);
	$rs_a = $rs->GetArray();
	for($i=0;$i<sizeof($rs_a);$i++)		{
		$考勤日期 = $rs_a[$i]['考勤日期'];
		$周次 = $rs_a[$i]['周次'];
		$新周次	= returnCurWeekIndex($考勤日期);
		$sql = "update edu_teacherkaoqinmingxi set 周次='$新周次' where 考勤日期='$考勤日期'";
		$db->Execute($sql);
		//print $sql."<BR>";
	}

}

function 初始化学校基本信息($tablename='edu_schoolbaseinfor',$fieldname='学校名称')		{
	global $db;
	//较验用户信息是否存在
	$sql = "select COUNT(*) AS NUM from $tablename";
	$rs = $db->Execute($sql);
	$NUM = $rs->fields['NUM'];
	$sql = "select UNIT_NAME from unit limit 1";
	$rs = $db->Execute($sql);
	$UNIT_NAME = $rs->fields['UNIT_NAME'];
	if($NUM==0)			{
		$sql = "insert into $tablename($fieldname) values('$UNIT_NAME')";
		$db->Execute($sql);
	}
	else	{
		$sql = "update $tablename set $fieldname='$UNIT_NAME'";
		$db->Execute($sql);
	}
}


function 定时执行函数($函数名称='同步教学计划学分信息到成绩数据表之中',$间隔时间='30')			{
	//进行从主数据库中同步数据
	$变量名称 = "定时执行函数_".$函数名称;
	//session_unregister($变量名称);//测试使用的行代码
	if(!session_is_registered($变量名称))		{
		session_register($变量名称);
		$_SESSION[$变量名称] = time();
	}
	$现在时间线 = time();
	$时间差 = $现在时间线 - $_SESSION[$变量名称];
	$时间差CEIL = ceil($时间差/60);
	//print_R($时间差);
	//print $变量名称.":".$时间差." ".date("H:i",$_SESSION[$变量名称])."<BR>";
	//print $PHP_SELF_BEGIN."<BR>";
	//当时间超过某一值,或是头一次访问的时候,需要执行此过程
	if($时间差CEIL>=$间隔时间||$时间差==0)							{
		//执行参数传递过来的参数
		$函数名称();
		//更新标记时间
		$_SESSION[$变量名称] = time();
	}//exit;
}


function 自动清理行政考勤中离职人员产生的多余数据()			{
	global $db,$_SESSION;
	//$MetaDatabases = $db->MetaDatabases();
	if($_SESSION['SYSTEM_IS_TD_OA']=="1")				{
		$tablenamePRE = "TD_OA.user";
	}
	else	{
		$tablenamePRE = "user";
	}
	$sql = "delete from edu_xingzheng_kaoqinmingxi where 人员用户名 not in (select USER_ID from $tablenamePRE where DEPT_ID>'0')";
	$db->Execute($sql);
	//print $sql."<BR>";
	$sql = "delete from edu_xingzheng_jiabanbuxiu where 人员用户名 not in (select USER_ID from $tablenamePRE where DEPT_ID>'0')";
	$db->Execute($sql);
	//print $sql."<BR>";
	$sql = "delete from edu_xingzheng_kaoqinbudeng where 人员用户名 not in (select USER_ID from $tablenamePRE where DEPT_ID>'0')";
	$db->Execute($sql);
	//print $sql."<BR>";
	$sql = "delete from edu_xingzheng_qingjia where 人员用户名 not in (select USER_ID from $tablenamePRE where DEPT_ID>'0')";
	$db->Execute($sql);
	//print $sql."<BR>";
	$sql = "delete from  edu_xingzheng_tiaoban where 人员用户名 not in (select USER_ID from $tablenamePRE where DEPT_ID>'0')";
	$db->Execute($sql);
	//print $sql."<BR>";
	$sql = "delete from  edu_xingzheng_tiaobanxianghu where 原人员用户名 not in (select USER_ID from $tablenamePRE where DEPT_ID>'0')";
	$db->Execute($sql);
	//print $sql."<BR>";
	$sql = "delete from  edu_xingzheng_tiaobanxianghu where 新人员用户名 not in (select USER_ID from $tablenamePRE where DEPT_ID>'0')";
	$db->Execute($sql);
	//print $sql."<BR>";
	$sql = "delete from  edu_xingzheng_tiaoxiububan where 人员用户名 not in (select USER_ID from $tablenamePRE where DEPT_ID>'0')";
	$db->Execute($sql);
	//print $sql."<BR>";

	$sql = "select 编号,排班人员 from edu_xingzheng_paiban";
	$rs = $db->Execute($sql);
	$rs_a = $rs->GetArray();
	for($i=0;$i<sizeof($rs_a);$i++)				{
		$编号 = $rs_a[$i]['编号'];
		$排班人员 = $rs_a[$i]['排班人员'];
		$USER_NAME = returntablefield('user',"USER_ID",$排班人员,"USER_NAME");
		if($USER_NAME=="")		{
			$排班人员结果 = useridfilter($排班人员);
			$sql = "update edu_xingzheng_paiban set 排班人员='$排班人员结果' where 编号='$编号'";
			$db->Execute($sql);
			//print $sql."<BR>";
		}
	}//exit;

}

function 手动导出所有宿舍楼信息()			{
	global $db;
	if($_GET['action']==''||$_GET['action']=='init_default')		{
		$sql = "select 宿舍楼名称 from dorm_building order by 宿舍楼名称";
		$rs = $db->Execute($sql);
		$rs_a = $rs->GetArray();
		$评比日期 = date("Y-m-d");
		$宿舍楼名称_lin = "按宿舍楼导出:";
		for($i=0;$i<sizeof($rs_a);$i++)		{
			$宿舍楼名称 = $rs_a[$i]['宿舍楼名称'];
			$宿舍楼名称_lin .= "&nbsp;<a href='?".base64_encode("XX=XX&XX&宿舍楼=$宿舍楼名称&评比日期_开始时间=$评比日期&评比日期_结束时间=$评比日期&快速查询=快速查询&pageid=1&action=export_default_data&exportfield=1,2,3,4,5,6,7,8,9,10,11,,,14,15,16&tablename=edu_susheweishengday&XX=XX")."'>$宿舍楼名称</a>";
		}
		$PrintText .= "<table  class=TableBlock align=center width=100%>";
		$PrintText .= "<TR class=TableContent><td ><font color=green >$宿舍楼名称_lin
		</font></td></table><BR>";
		print $PrintText;
	}
}


function 同步班级信息到每天纪律卫生评比页面($评比日期='')			{
	global $db;
	if($评比日期=='')		$评比日期 = date("Y-m-d");
	$星期					= 返回给定时间的星期信息($评比日期);
	if($星期>=1&&$星期<=5)							{
		$创建时间 = date("Y-m-d H:i:s");
		$周次	= returnCurWeekIndex($评比日期);
		$当前学期 = returntablefield("edu_xueqiexec","当前学期",'1',"学期名称");
		$sql = "select 班级名称 from edu_banji where 毕业时间>='".date('Y-m-d')."'";
		$rs = $db->CacheExecute(150,$sql);
		$rs_a = $rs->GetArray();
		for($i=0;$i<sizeof($rs_a);$i++)		{
			$班级名称 = $rs_a[$i]['班级名称'];
			$sql = "select COUNT(*) AS NUM from edu_banjiweishengday where 班级='$班级名称' and 日期='$评比日期'";
			$rs = $db->Execute($sql);
			$NUM = $rs->fields['NUM'];
			if($NUM==0)			{
				$sql = "INSERT INTO edu_banjiweishengday  VALUES ('','$当前学期','$班级名称', '$评比日期','$周次','$星期','$评价人','$卫生分数','$卫生扣分原因','$纪律分数','$纪律扣分原因','$创建时间','".$_SESSION['LOGIN_USER_ID']."')";
				$rs = $db->Execute($sql);
				//print $sql."<BR>";
			}
		}
	}//星期==5
}//编号  学期  宿舍楼  房间名称  评比日期  周次  星期  评价人  卫生分数  卫生扣分原因  纪律分数  纪律扣分原因  创建时间


function 同步宿舍房间信息到每天评比页面($评比日期='')			{
	global $db;
	if($评比日期=='')		$评比日期 = date("Y-m-d");
	$星期					= 返回给定时间的星期信息($评比日期);
	if($星期>=1&&$星期<=5)									{
		$创建时间 = date("Y-m-d H:i:s");
		$周次	= returnCurWeekIndex($评比日期);
		$当前学期 = returntablefield("edu_xueqiexec","当前学期",'1',"学期名称");
		$sql = "select 房间名称,宿舍楼 from dorm_room order by 房间名称";
		$rs = $db->CacheExecute(150,$sql);
		$rs_a = $rs->GetArray();
		for($i=0;$i<sizeof($rs_a);$i++)		{
			$房间名称	= $rs_a[$i]['房间名称'];
			$宿舍楼		= $rs_a[$i]['宿舍楼'];
			$sql		= "select COUNT(*) AS NUM from edu_susheweishengday where 房间名称='$房间名称' and 评比日期='$评比日期'";
			$rs			= $db->Execute($sql);
			$NUM		= $rs->fields['NUM'];
			if($NUM==0)			{
				$sql = "INSERT INTO `edu_susheweishengday`  VALUES ('','$当前学期','$宿舍楼', '$房间名称', '$评比日期','$周次','$星期','$评价人','$卫生分数','$卫生扣分原因','$纪律分数','$纪律扣分原因','$创建时间','".$_SESSION['LOGIN_USER_ID']."','','','')";
				$rs = $db->Execute($sql);
				//print $sql."<BR>";
			}
		}
	}//星期==5
}//编号  学期  宿舍楼  房间名称  评比日期  周次  星期  评价人  卫生分数  卫生扣分原因  纪律分数  纪律扣分原因  创建时间


//处理班级名称跟级别的不对应情况
function 处理班级名称跟级别的不对应情况()			{
	global $db,$_GET;
	$sql = "select distinct 班级 from edu_exam,edu_banji where edu_exam.班级=edu_banji.班级名称 and edu_exam.级别!=edu_banji.入学年份";
	$rs = $db->Execute($sql);
	$rs_a = $rs->GetArray();
	for($i=0;$i<sizeof($rs_a);$i++)			{
		$班级 = $rs_a[$i]['班级'];
		$级别 = returntablefield("edu_banji","班级名称",$班级,"入学年份");
		$sql = "update edu_exam set 级别='$级别' where 班级='$班级'";
		$db->Execute($sql);
		print $sql."<BR>";
	}
}

//同步教学计划学分信息到成绩数据表之中
function 同步教学计划学分信息到成绩数据表之中()			{
	global $db,$_GET;
	$sql = "select 班级名称,开课教师,教师用户名,开课学期,课程名称,周学时,学分 from edu_planexec where 开课学期='".$_GET['学期名称']."' and 学分>0";
	//print_R($_GET);
	//print $sql."<BR>";
	$rs = $db->Execute($sql);
	$rs_a = $rs->GetArray();
	for($i=0;$i<sizeof($rs_a);$i++)				{
		$课程名称 = $rs_a[$i]['课程名称'];
		$教师用户名 = $rs_a[$i]['教师用户名'];
		$开课教师 = $rs_a[$i]['开课教师'];
		$班级名称 = $rs_a[$i]['班级名称'];
		$开课学期 = $rs_a[$i]['开课学期'];
		$学分 = $rs_a[$i]['学分'];
		$sql = "";
		if($开课教师!="")		{
			$sql = "update edu_exam set 学分='$学分',教师='$开课教师' where 学期名称='$开课学期' and 班级='$班级名称' and 课程='$课程名称' ";
		}
		else	{
			$sql = "update edu_exam set 学分='$学分' where 学期名称='$开课学期' and 班级='$班级名称' and 课程='$课程名称' ";
		}
		$db->Execute($sql);
		//print $sql."<BR>";
	}
}



//同步OA用户到教师基本信息表
function 同步OA用户到教师基本信息表()			{
	global $db,$_GET;
	$sql = "select * from user";
	//print_R($_GET);
	//print $sql."<BR>";
	$rs = $db->CacheExecute(150,$sql);
	$rs_a = $rs->GetArray();
	//print_R($rs_a);
	for($i=0;$i<sizeof($rs_a);$i++)				{
		$USER_ID	= $rs_a[$i]['USER_ID'];
		$USER_NAME	= $rs_a[$i]['USER_NAME'];
		$BYNAME		= $rs_a[$i]['BYNAME'];
		$TEL_NO_DEPT= $rs_a[$i]['TEL_NO_DEPT'];
		$DEPT_ID= $rs_a[$i]['DEPT_ID'];
		$DEPT_NAME	= returntablefield("department","DEPT_ID",$DEPT_ID,"DEPT_NAME");
		if($BYNAME=="") $BYNAME = $USER_ID;
		$BIRTHDAY	= $rs_a[$i]['BIRTHDAY'];

		$sql		= "select COUNT(*) AS NUM from edu_teachermanage where 用户名='$USER_ID'";
		$rs			= $db->Execute($sql);
		if($rs->fields['NUM']==0)		{
			$sql = "insert into edu_teachermanage (教师编号,姓名,用户名,出生年月,电话号码,所在部门,创建人,创建时间,是否在岗)
					values('$BYNAME','$USER_NAME','$USER_ID','$BIRTHDAY','$TEL_NO_DEPT','$DEPT_NAME','".$_SESSION['LOGIN_USER_ID']."','".date('Y-m-d H:i:s')."','1')";
			$db->Execute($sql);
			//print $sql."<BR>";
		}
	}
}

function 同步教师基本信息到OA用户表(){
   global $db,$_GET;
	$sql = "select * from edu_teachermanage";
	//print_R($_GET);
	//print $sql."<BR>";exit;
	$rs = $db->CacheExecute(150,$sql);
	$rs_a = $rs->GetArray();
	//print_R($rs_a);
	for($i=0;$i<sizeof($rs_a);$i++)				{
		$USER_ID	= $rs_a[$i]['用户名'];
		$USER_NAME	= $rs_a[$i]['姓名'];
		//$BYNAME		= $rs_a[$i]['BYNAME'];
		//$TEL_NO_DEPT= $rs_a[$i]['TEL_NO_DEPT'];
		$DEPT_NAME = $rs_a[$i]['所在部门'];
		$MOBIL_NO = $rs_a[$i]['电话号码'];
		$DEPT_ID = returntablefield("department","DEPT_NAME",$DEPT_NAME,"DEPT_ID");
		//if($BYNAME=="") $BYNAME = $USER_ID;
		$BIRTHDAY	= $rs_a[$i]['出生年月'];

		$sql		= "select COUNT(*) AS NUM from user where USER_ID='$USER_ID'";
		$rs			= $db->Execute($sql);
		//echo $rs->fields['NUM'];
		if($rs->fields['NUM']==0)		{
			$sql = "insert into user (UID,USER_ID,USER_NAME,BIRTHDAY,MOBIL_NO,DEPT_ID)
					values('','$USER_ID','$USER_NAME','$BIRTHDAY','$MOBIL_NO','$DEPT_ID')";
			//echo $sql;exit;
			$db->Execute($sql);
			//print $sql."<BR>";
		}
	}
}


//同步教学计划里面的班级人数信息
function 同步教学计划里面的班级人数信息($学期名称)  {
	global $db,$CurXueQi;
	$sql = "select distinct 班级名称 from edu_planexec where 开课学期='$学期名称'";
	//print "<BR>同步教学计划里面的班级人数信息:".$sql."<BR>";
	$rs = $db->Execute($sql);
	$rs_a = $rs->GetArray();
	$NewArray = array();
	for($i=0;$i<sizeof($rs_a);$i++)				{
		$班级 = $rs_a[$i]['班级名称'];
		$班级人数 =  returnClassNumber($班级);
		$sql = "update edu_planexec set 班级人数='$班级人数' where 班级名称='$班级'";
	    $db->Execute($sql);
		global $SHOWTEXT; if($SHOWTEXT)print "<BR>同步教学计划里面的班级人数信息:".$sql."<BR>";
	}
}


function 专业TO数组()		{
	global $db;
	if($_GET['系代码']!="")			{
		$ADDSQL = "where 所属系 in ('".ereg_replace(",","','",$_GET['系代码'])."')";
	}
	else	if($_GET['专业名称']!="")			{
		$ADDSQL = "where 专业名称 in ('".ereg_replace(",","','",$_GET['专业名称'])."')";
	}
	else	{
		$ADDSQL = "";
	}
	$sql = "select 编号,专业名称,专业代码,所属系 from edu_zhuanye $ADDSQL order by 所属系,专业代码";
	//print $sql;
	$rs = $db->CacheExecute(150,$sql);
	$rs_a = $rs->GetArray();
	$NewArray = array();
	for($i=0;$i<sizeof($rs_a);$i++)				{
		$专业代码编号 = $rs_a[$i]['编号'];
		$专业名称 = $rs_a[$i]['专业名称'];
		$专业代码 = $rs_a[$i]['专业代码'];
		$所属系 = $rs_a[$i]['所属系'];
		$NewArray['ALL'][$所属系][$专业代码编号] = $专业名称;
		//$NewArray['DEPT'][$专业代码] = $专业名称;
		//$NewArray['FANXU'][$专业代码] = $所属系;
		$NewArray['DEPT'][$专业代码编号] = $专业名称;
		$NewArray['FANXU'][$专业代码编号] = $所属系;
		//$NewArray['DEPT'][$所属系][$专业代码] = $专业名称;
		//$NewArray['FANXU'][$所属系][$专业代码] = $所属系;
	}
	return $NewArray;
}

function 系TO数组()		{
	global $db;
	if($_GET['系代码']!="")			{
		$ADDSQL = "where 系代码 in ('".ereg_replace(",","','",$_GET['系代码'])."')";
	}
	else	{
		$ADDSQL = "";
	}
	$sql = "select 系名称,系代码 from edu_xi $ADDSQL order by 系代码";
	$rs = $db->CacheExecute(150,$sql);
	$rs_a = $rs->GetArray();
	$NewArray = array();
	for($i=0;$i<sizeof($rs_a);$i++)				{
		$系名称 = $rs_a[$i]['系名称'];
		$系代码 = $rs_a[$i]['系代码'];
		$NewArray[$系代码] = $系名称;
	}
	//print_R($ADDSQL);
	return $NewArray;
}

function 得到当前用户所管理的专业名称信息($专业名称X="专业名称")		{
	global $db,$_GET,$_SESSION,$_GET权限限制变量值;
	$LOGIN_USER_ID = $_SESSION['LOGIN_USER_ID'];
	$sql = "select 系代码,系名称 from edu_xi where 负责人姓名 like '%".$LOGIN_USER_ID.",%'";
	$rs = $db->CacheExecute(15,$sql);
	$rs_a = $rs->GetArray();
	$系代码 = array();
	for($i=0;$i<sizeof($rs_a);$i=$i+1)		{
		$系代码[] = $rs_a[$i]['系代码'];
		$系名称[] = $rs_a[$i]['系名称'];
	}
	$系代码文本 = "'".@join("','",$系代码)."'";
	$系名称文本 = @join(",",$系名称);
	if($系名称文本!="")			{
		$_GET['专业科'] = $系名称文本;
	}

	$sql = "select 专业名称 from edu_zhuanye where 所属系 in ($系代码文本)";
	$rs = $db->CacheExecute(15,$sql);
	$rs_a = $rs->GetArray();
	$专业名称 = array();
	for($i=0;$i<sizeof($rs_a);$i=$i+1)		{
		$专业名称[] = $rs_a[$i]['专业名称'];
	}

	//进行GET赋值,2010-9-25定义
	//如果GET的值只有一个,则沿用GET的值,如果GET的值为两个及以上,则用系统值
	$GET参数值 = explode(',',$_GET[$专业名称X]);
	//print_R($专业名称);
	if($GET参数值[0]!=''&&$GET参数值[1]=='')			{
		//表示GET值只有一个
	}
	else		{
		//GET值为空,或是为多个时,则进行系统权限重定义
		$_GET[$专业名称X] = @join(",",$专业名称);
	}
	$_GET权限限制变量值[$专业名称X] = @join(",",$专业名称);

}

function 修改时同步宿舍楼名称数据($新值,$旧值) {
  global $_GET,$_POST,$db;
  if($新值==$旧值||$新值=='') {
    return '';
  }
  $sql = "update dorm_liusu set 宿舍楼='$新值' where 宿舍楼='$旧值'";
  $db->Execute($sql);
  $sql = "update dorm_room set 宿舍楼='$新值' where 宿舍楼='$旧值'";
  $db->Execute($sql);
  $sql = "update dorm_rooming set 宿舍楼='$新值' where 宿舍楼='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_louzhangguanli set 宿舍楼='$新值' where 宿舍楼='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_susheweisheng set 宿舍楼='$新值' where 宿舍楼='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_susheweishengday set 宿舍楼='$新值' where 宿舍楼='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_wanguixinxi set 宿舍楼='$新值' where 宿舍楼='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_weizhangxinxi set 宿舍楼='$新值' where 宿舍楼='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_wenmingsushe set 宿舍楼='$新值' where 宿舍楼='$旧值'";
  $db->Execute($sql);

}


function 修改时同步房间名称数据($新值,$旧值) {
  global $_GET,$_POST,$db;
  if($新值==$旧值||$新值=='') {
    return '';
  }
  $sql = "update edu_susheweisheng set 房间名称='$新值' where 房间名称='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_susheweishengday set 房间名称='$新值' where 房间名称='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_wanguixinxi set 房间名称='$新值' where 房间名称='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_weizhangxinxi set 房间名称='$新值' where 房间名称='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_wenmingsushe set 房间名称='$新值' where 房间名称='$旧值'";
  $db->Execute($sql);
  $sql = "update dorm_rooming set 房间号='$新值' where 房间号='$旧值'";
  $db->Execute($sql);
  $sql = "update dorm_repeating set 报修房间号='$新值' where 报修房间号='$旧值'";
  $db->Execute($sql);
  $sql = "update dorm_liusu set 房间号='$新值' where 房间号='$旧值'";
  $db->Execute($sql);
  $sql = "update dorm_changelog set 新房间号='$新值' where 新房间号='$旧值'";
  $db->Execute($sql);
  $sql = "update dorm_changelog set 原房间号='$新值' where 原房间号='$旧值'";
  $db->Execute($sql);
}


function 修改时同步课程数据($新值,$旧值) {
  global $_GET,$_POST,$db;
  if($新值==$旧值||$新值=='') {
    return '';
  }

  //$sql = "update edu_course set 课程名称='$新值' where 课程名称='$旧值'";
  //$db->Execute($sql);
  $sql = "update edu_exam set 课程='$新值' where 课程='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_jiaoxueriji2 set 课程='$新值' where 课程='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_jiaoxuerijibudeng set 课程='$新值' where 课程='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_kecheng set 课程名称='$新值' where 课程名称='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_kechengshenqing set 课程名称='$新值' where 课程名称='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_kechoujisuan set 课程名称='$新值' where 课程名称='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_kewaifudao set 课程='$新值' where 课程='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_pingjiamingxi set 课程='$新值' where 课程='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_plan set 课程名称='$新值' where 课程名称='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_planexec set 课程名称='$新值' where 课程名称='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_planexec set 课程名称='$新值' where 课程名称='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_schedule set 课程='$新值' where 课程='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_schedule2 set 课程='$新值' where 课程='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_scheduledaike set 课程='$新值' where 课程='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_schedulefenduanjiaoxue set 课程='$新值' where 课程='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_scheduletiaoke set 课程='$新值' where 课程='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_scheduletingkefuke set 课程='$新值' where 课程='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_studentcardkaoqinmingxi set 课程='$新值' where 课程='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_studentkaoqin set 课程='$新值' where 课程='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_teacherkaoqinbudeng set 课程='$新值' where 课程='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_teacherkaoqinmingxi set 课程='$新值' where 课程='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_tingke set 课程='$新值' where 课程='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_tingke_kaoqinbudeng set 课程='$新值' where 课程='$旧值'";
  $db->Execute($sql);
  $sql = "update paikao_automation set 课程='$新值' where 课程='$旧值'";
  $db->Execute($sql);
  $sql = "update paikao_banjikemu set 课程='$新值' where 课程='$旧值'";
  $db->Execute($sql);
  //$sql = "update remote_course set 课程名称='$新值' where 课程名称='$旧值'";
  //$db->Execute($sql);
  //$sql = "update remote_courseapply set 课程名称='$新值' where 课程名称='$旧值'";
  //$db->Execute($sql);
  $sql = "update school_homeworkupload set 课程='$新值' where 课程='$旧值'";
  $db->Execute($sql);
  //$sql = "update tiku_chengji set 课程='$新值' where 课程='$旧值'";
  //$db->Execute($sql);
}
function 修改时同步教室数据($新值,$旧值) {
  global $_GET,$_POST,$db;
  if($新值==$旧值||$新值=='') {
    return '';
  }
  //$sql = "update edu_classroom set 教室名称='$新值' where 教室名称='$旧值'";
  //$db->Execute($sql);
  $sql = "update edu_classroomapply set 教室名称='$新值' where 教室名称='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_jiaoxuerijibudeng set 教室='$新值' where 教室='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_schedule set 教室='$新值' where 教室='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_schedule2 set 教室='$新值' where 教室='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_scheduledaike set 教室='$新值' where 教室='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_schedulefenduanjiaoxue set 教室='$新值' where 教室='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_scheduletiaoke set 教室='$新值' where 教室='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_scheduletiaokexianghu set 教室='$新值' where 教室='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_scheduletingkefuke set 教室='$新值' where 教室='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_studentcardkaoqinmingxi set 教室='$新值' where 教室='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_teacherkaoqinbudeng set 教室='$新值' where 教室='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_teacherkaoqinmingxi set 教室='$新值' where 教室='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_tingke set 教室='$新值' where 教室='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_tingke_kaoqinbudeng set 教室='$新值' where 教室='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_zuoweixinxi set 教室名称='$新值' where 教室名称='$旧值'";
  $db->Execute($sql);
  $sql = "update paikao_jiaoshi set 教室='$新值' where 教室='$旧值'";
  $db->Execute($sql);
}
function 修改时同步班级数据($新值,$旧值) {
  global $_GET,$_POST,$db;
  if($新值==$旧值||$新值=='') {
    return '';
  }

  $sql = "update dorm_changelog set 班级='$新值' where 班级='$旧值'";
  $db->Execute($sql);
  $sql = "update dorm_liusu set 班级='$新值' where 班级='$旧值'";
  $db->Execute($sql);
  $sql = "update dorm_rooming set 班级='$新值' where 班级='$旧值'";
  $db->Execute($sql);
  //$sql = "update edu_banji set 班级名称='$新值' where 班级名称='$旧值'";
  //$db->Execute($sql);
  $sql = "update edu_banjirizhi set 班级='$新值' where 班级='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_banjizhouji set 班级='$新值' where 班级='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_biyejianding set 班级='$新值' where 班级='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_biyezheng set 班级='$新值' where 班级='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_diaochamingxi set 班级='$新值' where 班级='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_dierketangbaoming set 班级名称='$新值' where 班级名称='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_evaluateclass set 班级='$新值' where 班级='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_evaluatepersonal set 班级='$新值' where 班级='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_exam set 班级='$新值' where 班级='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_grad set 班号='$新值' where 班号='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_guanmingbaoban set 班级名称='$新值' where 班级名称='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_jiafang set 班级='$新值' where 班级='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_jiangxuejin set 班级='$新值' where 班级='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_jiaoxueriji2 set 班级='$新值' where 班级='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_jiaoxuerijibudeng set 班级='$新值' where 班级='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_kechoujisuan set 班级名称='$新值' where 班级名称='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_kewaifudao set 班级='$新值' where 班级='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_leaguemember set 班级='$新值' where 班级='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_louzhangguanli set 班级='$新值' where 班级='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_newstudent set 班级='$新值' where 班级='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_partymember set 班级='$新值' where 班级='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_partymember2 set 班级='$新值' where 班级='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_pingbizidingyi set 班级='$新值' where 班级='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_pingjiamingxi set 班级='$新值' where 班级='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_planexec set 班级名称='$新值' where 班级名称='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_planexec set 班级名称='$新值' where 班级名称='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_qimopingyu set 班级='$新值' where 班级='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_schedule set 班级='$新值' where 班级='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_schedule2 set 班级='$新值' where 班级='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_scheduledaike set 班级='$新值' where 班级='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_schedulefenduanjiaoxue set 班级='$新值' where 班级='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_scheduletiaoke set 班级='$新值' where 班级='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_scheduletiaokexianghu set 班级='$新值' where 班级='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_scheduletingkefuke set 班级='$新值' where 班级='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_schooljingcheng set 班级='$新值' where 班级='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_shenghuobuzhu set 班级='$新值' where 班级='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_shixishenqing set 班级='$新值' where 班级='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_shoufeidan set 班级='$新值' where 班级='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_shoufeidanprint set 班级='$新值' where 班级='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_shoufeidanxuanjiaofei set 班级='$新值' where 班级='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_studentfafang set 班级='$新值' where 班级='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_piaojufafang set 班级='$新值' where 班级='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_smsrecord set 班级='$新值' where 班级='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_student set 班号='$新值' where 班号='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_studentcardkaoqinmingxi set 班级名称='$新值' where 班级名称='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_studentchange set 班级='$新值' where 班级='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_studentcourse set 班级名称='$新值' where 班级名称='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_studentjiangcheng set 班级='$新值' where 班级='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_studentjiesong set 班级名称='$新值' where 班级名称='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_studentjiuye set 班号='$新值' where 班号='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_studentkaoqin set 班级名称='$新值' where 班级名称='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_studentpingjiamingxi set 班级='$新值' where 班级='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_teacherkaoqinbudeng set 班级='$新值' where 班级='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_teacherkaoqinmingxi set 班级='$新值' where 班级='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_tingke set 班级='$新值' where 班级='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_tingke_kaoqinbudeng set 班级='$新值' where 班级='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_tuibandengji set 班级名称='$新值' where 班级名称='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_tuifeidan set 班级名称='$新值' where 班级名称='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_tuijianjiuye set 班号='$新值' where 班号='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_uchome set 班级='$新值' where 班级='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_waichuzhufang set 班级='$新值' where 班级='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_wanguixinxi set 班级='$新值' where 班级='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_weijihuizong set 班级名称='$新值' where 班级名称='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_weizhangxinxi set 班级='$新值' where 班级='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_xiaoyou set 班级='$新值' where 班级='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_xiaoyoubanji set 班级名称='$新值' where 班级名称='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_youxiubiyesheng set 班号='$新值' where 班号='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_zhaopinshenqin set 班级='$新值' where 班级='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_zhengshuguanli set 班级='$新值' where 班级='$旧值'";
  $db->Execute($sql);

  $sql = "update paikao_automation set 班级='$新值' where 班级='$旧值'";
  $db->Execute($sql);
  $sql = "update paikao_banjikemu set 班级='$新值' where 班级='$旧值'";
  $db->Execute($sql);
  $sql = "update school_homeworkupload set 班级='$新值' where 班级='$旧值'";
  $db->Execute($sql);
  //$sql = "update tiku_chengji set 班级='$新值' where 班级='$旧值'";
  //$db->Execute($sql);
  //$sql = "update tiku_examdata set 班级='$新值' where 班级='$旧值'";
  //$db->Execute($sql);
}
function 修改时同步学期数据($新值,$旧值) {
  global $_GET,$_POST,$db;
  if($新值==$旧值||$新值=='') {
    return '';
  }
  $sql = "update dorm_liusu set 学期='$新值' where 学期='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_banjirizhi set 学期='$新值' where 学期='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_banjizhouji set 学期='$新值' where 学期='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_banweiguanli set 学期='$新值' where 学期='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_classroomapply set 学期='$新值' where 学期='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_diaochamingcheng set 学期名称='$新值' where 学期名称='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_diaochamingxi set 学期名称='$新值' where 学期名称='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_diaochaneirong set 学期名称='$新值' where 学期名称='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_evaluateclass set 学期='$新值' where 学期='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_evaluatename set 学期='$新值' where 学期='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_evaluatepersonal set 学期='$新值' where 学期='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_exam set 学期名称='$新值' where 学期名称='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_examname set 学期名称='$新值' where 学期名称='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_growfiles set 学期='$新值' where 学期='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_jiangxuejin set 学期='$新值' where 学期='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_jiaoxueriji2 set 学期='$新值' where 学期='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_kechoujiaofu set 学期='$新值' where 学期='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_kechoujisuan set 学期='$新值' where 学期='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_kechouqita set 学期='$新值' where 学期='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_pingbizidingyi set 学期='$新值' where 学期='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_qimopingyu set 学期='$新值' where 学期='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_qingongjianxue set 学期='$新值' where 学期='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_schedule set 学期='$新值' where 学期='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_schedule2 set 学期='$新值' where 学期='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_schedulechange set 学期='$新值' where 学期='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_scheduledaike set 学期='$新值' where 学期='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_schedulefenduanjiaoxue set 学期='$新值' where 学期='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_scheduletiaoke set 学期='$新值' where 学期='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_scheduletiaokexianghu set 学期='$新值' where 学期='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_scheduletingkefuke set 学期='$新值' where 学期='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_schooljingcheng set 学期='$新值' where 学期='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_shenghuobuzhu set 学期名称='$新值' where 学期名称='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_shenghuobuzhutype set 学期名称='$新值' where 学期名称='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_studentjiangcheng set 学期='$新值' where 学期='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_studentkaoqin set 学期名称='$新值' where 学期名称='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_teacher_yearcheck set 学期='$新值' where 学期='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_teacherkaoqinmingxi set 学期='$新值' where 学期='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_tingke set 学期='$新值' where 学期='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_xingzheng_jiabanbuxiu set 学期='$新值' where 学期='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_xingzheng_kaoqinbudeng set 学期='$新值' where 学期='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_xingzheng_kaoqinmingxi set 学期='$新值' where 学期='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_xingzheng_paiban set 学期名称='$新值' where 学期名称='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_xingzheng_qingjia set 学期='$新值' where 学期='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_xingzheng_tiaoban set 学期='$新值' where 学期='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_xingzheng_tiaobanxianghu set 学期='$新值' where 学期='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_xingzheng_tiaoxiububan set 学期='$新值' where 学期='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_xingzheng_yearcheck set 学期='$新值' where 学期='$旧值'";
  $db->Execute($sql);
  //$sql = "update edu_xueqi set 学期名称='$新值' where 学期名称='$旧值'";
  //$db->Execute($sql);
  //$sql = "update edu_xueqiexec set 学期名称='$新值' where 学期名称='$旧值'";
  //$db->Execute($sql);
  $sql = "update edu_zhiban set 学期名称='$新值' where 学期名称='$旧值'";
  $db->Execute($sql);
  //$sql = "update hrms_salary set 学期名称='$新值' where 学期名称='$旧值'";
  //$db->Execute($sql);
  //$sql = "update hrms_salary_detail set 学期名称='$新值' where 学期名称='$旧值'";
  //$db->Execute($sql);
  $sql = "update paikao_automation set 学期='$新值' where 学期='$旧值'";
  $db->Execute($sql);
  $sql = "update paikao_banjikemu set 学期='$新值' where 学期='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_scheduleroles set 学期='$新值' where 学期='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_xuanke_record set 学期='$新值' where 学期='$旧值'";
  $db->Execute($sql);
  $sql = "update ceping_mingcheng set 学期='$新值' where 学期='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_jiaocaistudent set 学期='$新值' where 学期='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_xueshengqingjia set 学期='$新值' where 学期='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_jiafang set 学期='$新值' where 学期='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_banfeiguanli set 学期='$新值' where 学期='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_banjihuodong set 学期='$新值' where 学期='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_susheweishengday set 学期='$新值' where 学期='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_meizhoubeiwang set 学期='$新值' where 学期='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_ketangjilvbanji set 学期='$新值' where 学期='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_xuanke_jiaoxueban set 学期='$新值' where 学期='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_xuanke_rule_allowchoose set 学期='$新值' where 学期='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_xuanke_rule_general set 学期='$新值' where 学期='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_xuanke_rule_notallowchoose set 学期='$新值' where 学期='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_xuanke_rule_notallowcourse set 学期='$新值' where 学期='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_planexec set 开课学期='$新值' where 开课学期='$旧值'";
  $db->Execute($sql);

}
function 修改时同步专业数据($新值,$旧值) {
  global $_GET,$_POST,$db;
  if($新值==$旧值||$新值=='') {
    return '';
  }

  $sql = "update dorm_changelog set 专业='$新值' where 专业='$旧值'";
  $db->Execute($sql);
  $sql = "update dorm_rooming set 专业='$新值' where 专业='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_biyejianding set 专业='$新值' where 专业='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_biyezheng set 专业='$新值' where 专业='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_evaluateclass set 专业='$新值' where 专业='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_evaluatepersonal set 专业='$新值' where 专业='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_jiangxuejin set 专业='$新值' where 专业='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_louzhangguanli set 专业='$新值' where 专业='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_pingjiamingxi set 专业='$新值' where 专业='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_plan set 专业名称='$新值' where 专业名称='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_planexec set 专业名称='$新值' where 专业名称='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_planexec set 专业名称='$新值' where 专业名称='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_shenghuobuzhu set 专业='$新值' where 专业='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_shoufeidan set 专业='$新值' where 专业='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_shoufeidanprint set 专业='$新值' where 专业='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_studentcourse set 专业名称='$新值' where 专业名称='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_studentpingjiamingxi set 专业='$新值' where 专业='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_tanhuajilu set 专业='$新值' where 专业='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_tuifeidan set 专业名称='$新值' where 专业名称='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_waichuzhufang set 专业='$新值' where 专业='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_wanguixinxi set 专业='$新值' where 专业='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_weizhangxinxi set 专业='$新值' where 专业='$旧值'";
  $db->Execute($sql);
  //$sql = "update edu_zhuanye set 专业名称='$新值' where 专业名称='$旧值'";
  //$db->Execute($sql);
  $sql = "update edu_zhuanyeshoufei set 专业名称='$新值' where 专业名称='$旧值'";
  $db->Execute($sql);
  //$sql = "update hrms_educationalexperience set 专业='$新值' where 专业='$旧值'";
  //$db->Execute($sql);
  //$sql = "update hrms_file set 专业='$新值' where 专业='$旧值'";
  //$db->Execute($sql);
  //$sql = "update hrms_file_luyong set 专业='$新值' where 专业='$旧值'";
  //$db->Execute($sql);
  //$sql = "update hrms_zprencaiku set 专业='$新值' where 专业='$旧值'";
  //$db->Execute($sql);

  $sql = "update paikao_automation set 专业='$新值' where 专业='$旧值'";
  $db->Execute($sql);
  $sql = "update paikao_banjikemu set 专业='$新值' where 专业='$旧值'";
  $db->Execute($sql);
}
function 修改时同步系数据($新值,$旧值) {
  global $_GET,$_POST,$db;
  if($新值==$旧值||$新值=='') {
    return '';
  }
  $sql = "update edu_newstudent set 专业科='$新值' where 专业科='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_shoufeidan set 系名称='$新值' where 系名称='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_shoufeidanprint set 系名称='$新值' where 系名称='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_studentpingjiamingxi set 系='$新值' where 系='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_teacher_work_check_register set 专业科='$新值' where 专业科='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_teacher_yearcheck set 专业科='$新值' where 专业科='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_tuifeidan set 系名称='$新值' where 系名称='$旧值'";
  $db->Execute($sql);
  //$sql = "update edu_xi set 系名称='$新值' where 系名称='$旧值'";
  //$db->Execute($sql);
  //$sql = "update newedu_gerenchufen set 系='$新值' where 系='$旧值'";
  //$db->Execute($sql);
}

function 修改时同步姓名数据($学号,$姓名) {
  global $_GET,$_POST,$db;

  $sql = "update dorm_changelog set 姓名='$姓名' where 学号='$学号'";
  $db->Execute($sql);
  $sql = "update dorm_liusu set 姓名='$姓名' where 学号='$学号'";
  $db->Execute($sql);
  $sql = "update dorm_rooming set 姓名='$姓名' where 学号='$学号'";
  $db->Execute($sql);
  $sql = "update edu_banfeiguanli set 姓名='$姓名' where 学号='$学号'";
  $db->Execute($sql);
  $sql = "update edu_banweiguanli set 姓名='$姓名' where 学号='$学号'";
  $db->Execute($sql);
  $sql = "update edu_biyejianding set 姓名='$姓名' where 学号='$学号'";
  $db->Execute($sql);
  $sql = "update edu_biyezheng set 姓名='$姓名' where 学号='$学号'";
  $db->Execute($sql);
  $sql = "update edu_diaochamingxi set 姓名='$姓名' where 学号='$学号'";
  $db->Execute($sql);
  $sql = "update edu_dierketangbaoming set 学生姓名='$姓名' where 学生学号='$学号'";
  $db->Execute($sql);
  $sql = "update edu_dierketangpingfen set 学生姓名='$姓名' where 学生学号='$学号'";
  $db->Execute($sql);
  $sql = "update edu_evaluatepersonal set 姓名='$姓名' where 学号='$学号'";
  $db->Execute($sql);
  $sql = "update edu_exam set 姓名='$姓名' where 学号='$学号'";
  $db->Execute($sql);
  $sql = "update edu_grad set 姓名='$姓名' where 学号='$学号'";
  $db->Execute($sql);
  $sql = "update edu_jiafang set 姓名='$姓名' where 学号='$学号'";
  $db->Execute($sql);
  $sql = "update edu_jiangxuejin set 姓名='$姓名' where 学号='$学号'";
  $db->Execute($sql);
  $sql = "update edu_kechengshenqing set 姓名='$姓名' where 学号='$学号'";
  $db->Execute($sql);
  $sql = "update edu_kewaifudao set 姓名='$姓名' where 学号='$学号'";
  $db->Execute($sql);
  //$sql = "update edu_leaguefee set 姓名='$姓名' where 学号='$学号'";
  //$db->Execute($sql);
  $sql = "update edu_leaguemember set 姓名='$姓名' where 学号='$学号'";
  $db->Execute($sql);
  $sql = "update edu_louzhangguanli set 姓名='$姓名' where 学号='$学号'";
  $db->Execute($sql);
  //$sql = "update edu_partyfee set 姓名='$姓名' where 学号='$学号'";
  //$db->Execute($sql);
  $sql = "update edu_partymember set 姓名='$姓名' where 学号='$学号'";
  $db->Execute($sql);
  $sql = "update edu_partymember2 set 姓名='$姓名' where 学号='$学号'";
  $db->Execute($sql);
  $sql = "update edu_passwordlog set 姓名='$姓名' where 编号='$学号'";
  $db->Execute($sql);
  $sql = "update edu_passwordlog2 set 姓名='$姓名' where 编号='$学号'";
  $db->Execute($sql);
  $sql = "update edu_pingjiamingxi set 姓名='$姓名' where 学号='$学号'";
  $db->Execute($sql);
  $sql = "update edu_qimopingyu set 姓名='$姓名' where 学号='$学号'";
  $db->Execute($sql);
  $sql = "update edu_qingongjianxue set 学生姓名='$姓名' where 学生学号='$学号'";
  $db->Execute($sql);
  $sql = "update edu_shenghuobuzhu set 姓名='$姓名' where 学号='$学号'";
  $db->Execute($sql);
  $sql = "update edu_shixishenqing set 姓名='$姓名' where 学号='$学号'";
  $db->Execute($sql);
  $sql = "update edu_shoufeidan set 姓名='$姓名' where 学号='$学号'";
  $db->Execute($sql);
  $sql = "update edu_shoufeidanprint set 姓名='$姓名' where 学号='$学号'";
  $db->Execute($sql);
  $sql = "update edu_shoufeidanxuanjiaofei set 姓名='$姓名' where 学号='$学号'";
  $db->Execute($sql);
  $sql = "update edu_studentfafang set 姓名='$姓名' where 学号='$学号'";
  $db->Execute($sql);
  $sql = "update edu_piaojufafang set 姓名='$姓名' where 学号='$学号'";
  $db->Execute($sql);
  //$sql = "update edu_smsfetion set 姓名='$姓名' where 学号='$学号'";
  //$db->Execute($sql);
  $sql = "update edu_smsrecord set 姓名='$姓名' where 学号='$学号'";
  $db->Execute($sql);
  $sql = "update edu_stubad set 姓名='$姓名' where 学号='$学号'";
  $db->Execute($sql);
  //$sql = "update edu_student set 姓名='$姓名' where 学号='$学号'";
  //$db->Execute($sql);
  $sql = "update edu_studentcardkaoqin set 姓名='$姓名' where 学号='$学号'";
  $db->Execute($sql);
  $sql = "update edu_studentcardkaoqinmingxi set 姓名='$姓名' where 学号='$学号'";
  $db->Execute($sql);
  $sql = "update edu_studentchange set 姓名='$姓名' where 学号='$学号'";
  $db->Execute($sql);
  $sql = "update edu_studentcourse set 姓名='$姓名' where 学号='$学号'";
  $db->Execute($sql);
  $sql = "update edu_studentflow set 姓名='$姓名' where 学号='$学号'";
  $db->Execute($sql);
  $sql = "update edu_studentjiangcheng set 学生姓名='$姓名' where 学生学号='$学号'";
  $db->Execute($sql);
  $sql = "update edu_studentjiesong set 姓名='$姓名' where 学号='$学号'";
  $db->Execute($sql);
  $sql = "update edu_studentjiuye set 姓名='$姓名' where 学号='$学号'";
  $db->Execute($sql);
  $sql = "update edu_studentkaoqin set 姓名='$姓名' where 学号='$学号'";
  $db->Execute($sql);
  $sql = "update edu_studentpingjiamingxi set 姓名='$姓名' where 学号='$学号'";
  $db->Execute($sql);
  $sql = "update edu_tanhuajilu set 姓名='$姓名' where 学号='$学号'";
  $db->Execute($sql);
  //$sql = "update edu_teacher set 姓名='$姓名' where 学号='$学号'";
  //$db->Execute($sql);
  //$sql = "update edu_teacher_partyfee set 姓名='$姓名' where 学号='$学号'";
  //$db->Execute($sql);
  //$sql = "update edu_teacher_partymember set 姓名='$姓名' where 学号='$学号'";
  //$db->Execute($sql);
  //$sql = "update edu_teacher_partymember2 set 姓名='$姓名' where 学号='$学号'";
  //$db->Execute($sql);
  //$sql = "update edu_teacher_work_check_register set 姓名='$姓名' where 学号='$学号'";
  //$db->Execute($sql);
  //$sql = "update edu_teacherjingli set 姓名='$姓名' where 学号='$学号'";
  //$db->Execute($sql);
  //$sql = "update edu_teachermanage set 姓名='$姓名' where 学号='$学号'";
  //$db->Execute($sql);
  //$sql = "update edu_teacherxuexijingli set 姓名='$姓名' where 学号='$学号'";
  //$db->Execute($sql);
  $sql = "update edu_tuibandengji set 姓名='$姓名' where 学号='$学号'";
  $db->Execute($sql);
  $sql = "update edu_tuifeidan set 姓名='$姓名' where 学号='$学号'";
  $db->Execute($sql);
  $sql = "update edu_tuijianjiuye set 姓名='$姓名' where 学号='$学号'";
  $db->Execute($sql);
  $sql = "update edu_uchome set 姓名='$姓名' where 学号='$学号'";
  $db->Execute($sql);
  $sql = "update edu_waichuzhufang set 姓名='$姓名' where 学号='$学号'";
  $db->Execute($sql);
  $sql = "update edu_wanguixinxi set 姓名='$姓名' where 学号='$学号'";
  $db->Execute($sql);
  $sql = "update edu_weijihuizong set 学生姓名='$姓名' where 学生学号='$学号'";
  $db->Execute($sql);
  $sql = "update edu_weizhangxinxi set 姓名='$姓名' where 学号='$学号'";
  $db->Execute($sql);
  $sql = "update edu_xiaoyou set 姓名='$姓名' where 学号='$学号'";
  $db->Execute($sql);
  //$sql = "update edu_xingzheng_work_check_register set 姓名='$姓名' where 学号='$学号'";
  //$db->Execute($sql);
  //$sql = "update edu_xingzheng_yearcheck set 姓名='$姓名' where 学号='$学号'";
  //$db->Execute($sql);
  $sql = "update edu_youxiubiyesheng set 姓名='$姓名' where 学号='$学号'";
  $db->Execute($sql);
  $sql = "update edu_zhaopinshenqin set 姓名='$姓名' where 学号='$学号'";
  $db->Execute($sql);
  $sql = "update edu_zhengshuguanli set 姓名='$姓名' where 学号='$学号'";
  $db->Execute($sql);
  $sql = "update edu_zuoweixinxi set 学生姓名='$姓名' where 学生学号='$学号'";
  $db->Execute($sql);
  //$sql = "update hrms_educationalexperience set 姓名='$姓名' where 学号='$学号'";
  //$db->Execute($sql);
  //$sql = "update hrms_expense set 姓名='$姓名' where 学号='$学号'";
  //$db->Execute($sql);
  //$sql = "update hrms_file set 姓名='$姓名' where 学号='$学号'";
  //$db->Execute($sql);
  //$sql = "update hrms_file_fuzhi set 姓名='$姓名' where 学号='$学号'";
  //$db->Execute($sql);
  //$sql = "update hrms_file_lizhi set 姓名='$姓名' where 学号='$学号'";
  //$db->Execute($sql);
  //$sql = "update hrms_file_luyong set 姓名='$姓名' where 学号='$学号'";
  //$db->Execute($sql);
  //$sql = "update hrms_laboringskill set 姓名='$姓名' where 学号='$学号'";
  //$db->Execute($sql);
  //$sql = "update hrms_reward_punishment set 姓名='$姓名' where 学号='$学号'";
  //$db->Execute($sql);
  //$sql = "update hrms_salary_tongji set 姓名='$姓名' where 学号='$学号'";
  //$db->Execute($sql);
  //$sql = "update hrms_socialrelation set 姓名='$姓名' where 学号='$学号'";
  //$db->Execute($sql);
  //$sql = "update hrms_transfer set 姓名='$姓名' where 学号='$学号'";
  //$db->Execute($sql);
  //$sql = "update hrms_worker_hetong set 姓名='$姓名' where 学号='$学号'";
  //$db->Execute($sql);
  //$sql = "update hrms_worker_zhengzhao set 姓名='$姓名' where 学号='$学号'";
  //$db->Execute($sql);
  //$sql = "update hrms_worker_zhicheng set 姓名='$姓名' where 学号='$学号'";
  //$db->Execute($sql);
  //$sql = "update hrms_workexperience set 姓名='$姓名' where 学号='$学号'";
  //$db->Execute($sql);
  //$sql = "update hrms_zprencaiku set 姓名='$姓名' where 学号='$学号'";
  //$db->Execute($sql);
  //$sql = "update remote_courseapply set 姓名='$姓名' where 学号='$学号'";
  //$db->Execute($sql);
  $sql = "update school_homeworkupload set 姓名='$姓名' where 学号='$学号'";
  $db->Execute($sql);
  //$sql = "update tiku_chengji set 姓名='$姓名' where 学号='$学号'";
  //$db->Execute($sql);
  //$sql = "update tiku_examdata set 姓名='$姓名' where 学号='$学号'";
  //$db->Execute($sql);
  //exit;
}

function 修改时同步学号数据($新值,$旧值) {
  global $_GET,$_POST,$db;
  if($新值==$旧值||$新值=='') {
    return '';
  }

  $sql = "update dorm_changelog set 学号='$新值' where 学号='$旧值'";
  $db->Execute($sql);
  $sql = "update dorm_liusu set 学号='$新值' where 学号='$旧值'";
  $db->Execute($sql);
  $sql = "update dorm_rooming set 学号='$新值' where 学号='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_banfeiguanli set 学号='$新值' where 学号='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_banweiguanli set 学号='$新值' where 学号='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_biyejianding set 学号='$新值' where 学号='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_biyezheng set 学号='$新值' where 学号='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_diaochamingxi set 学号='$新值' where 学号='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_dierketangbaoming set 学生学号='$新值' where 学生学号='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_dierketangpingfen set 学生学号='$新值' where 学生学号='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_evaluatepersonal set 学号='$新值' where 学号='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_exam set 学号='$新值' where 学号='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_grad set 学号='$新值' where 学号='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_growfiles set 学号='$新值' where 学号='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_jiafang set 学号='$新值' where 学号='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_jiangxuejin set 学号='$新值' where 学号='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_kechengshenqing set 学号='$新值' where 学号='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_kewaifudao set 学号='$新值' where 学号='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_leaguemember set 学号='$新值' where 学号='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_louzhangguanli set 学号='$新值' where 学号='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_newstudent set 学号='$新值' where 学号='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_partymember set 学号='$新值' where 学号='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_partymember2 set 学号='$新值' where 学号='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_pingjiamingxi set 学号='$新值' where 学号='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_qimopingyu set 学号='$新值' where 学号='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_qingongjianxue set 学生学号='$新值' where 学生学号='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_shenghuobuzhu set 学号='$新值' where 学号='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_shixishenqing set 学号='$新值' where 学号='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_shoufeidan set 学号='$新值' where 学号='$旧值'";
  $db->Execute($sql);
  //print $sql;
  $sql = "update edu_shoufeidanprint set 学号='$新值' where 学号='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_shoufeidanxuanjiaofei set 学号='$新值' where 学号='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_studentfafang set 学号='$新值' where 学号='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_piaojufafang set 学号='$新值' where 学号='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_smsrecord set 学号='$新值' where 学号='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_stubad set 学号='$新值' where 学号='$旧值'";
  $db->Execute($sql);
  //$sql = "update edu_student set 学号='$新值' where 学号='$旧值'";
  //$db->Execute($sql);
  $sql = "update edu_studentcardkaoqin set 学号='$新值' where 学号='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_studentcardkaoqinmingxi set 学号='$新值' where 学号='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_studentchange set 学号='$新值' where 学号='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_studentcourse set 学号='$新值' where 学号='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_studentflow set 学号='$新值' where 学号='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_studentjiangcheng set 学生学号='$新值' where 学生学号='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_studentjiesong set 学号='$新值' where 学号='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_studentjiuye set 学号='$新值' where 学号='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_studentkaoqin set 学号='$新值' where 学号='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_studentpingjiamingxi set 学号='$新值' where 学号='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_stulog set 学号='$新值' where 学号='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_tanhuajilu set 学号='$新值' where 学号='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_tuibandengji set 学号='$新值' where 学号='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_tuifeidan set 学号='$新值' where 学号='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_tuijianjiuye set 学号='$新值' where 学号='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_uchome set 学号='$新值' where 学号='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_waichuzhufang set 学号='$新值' where 学号='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_wanguixinxi set 学号='$新值' where 学号='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_weijihuizong set 学生学号='$新值' where 学生学号='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_weizhangxinxi set 学号='$新值' where 学号='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_xiaoyou set 学号='$新值' where 学号='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_youxiubiyesheng set 学号='$新值' where 学号='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_zhaopinshenqin set 学号='$新值' where 学号='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_zhengshuguanli set 学号='$新值' where 学号='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_zuoweixinxi set 学生学号='$新值' where 学生学号='$旧值'";
  $db->Execute($sql);

  $sql = "update school_homeworkupload set 学号='$新值' where 学号='$旧值'";
  $db->Execute($sql);

  //$sql = "update tiku_chengji set 学号='$新值' where 学号='$旧值'";
  //$db->Execute($sql);
  //$sql = "update tiku_examdata set 学号='$新值' where 学号='$旧值'";
  //$db->Execute($sql);
  //$sql = "update wygl_baoxiuxinxi set 学生学号='$新值' where 学生学号='$旧值'";
  //$db->Execute($sql);
  //print $sql;exit;
  //print "<font color=green>".$sql."</font><BR>";
}


//使用"同步学生转班而带来的班级信息变化"函数
/*
function 修改时同步学生的班级名称数据($学号,$班级名称)								{
  global $_GET,$_POST,$db;
  if($新值==$旧值||$新值=='') {
    return '';
  }

  $sql = "update dorm_changelog set 班级='$班级名称' where 学号='$学号'";
  $db->Execute($sql);
  $sql = "update dorm_liusu set 班级='$班级名称' where 学号='$学号'";
  $db->Execute($sql);
  $sql = "update dorm_rooming set 班级='$班级名称' where 学号='$学号'";
  $db->Execute($sql);
  $sql = "update edu_banfeiguanli set 所属班级='$班级名称' where 学号='$学号'";
  $db->Execute($sql);
  $sql = "update edu_banweiguanli set 所属班级='$班级名称' where 学号='$学号'";
  $db->Execute($sql);
  $sql = "update edu_biyejianding set 班级='$班级名称' where 学号='$学号'";
  $db->Execute($sql);
  $sql = "update edu_biyezheng set 班级='$班级名称' where 学号='$学号'";
  $db->Execute($sql);
  $sql = "update edu_diaochamingxi set 班级='$班级名称' where 学号='$学号'";
  $db->Execute($sql);
  $sql = "update edu_dierketangbaoming set 班级名称='$班级名称' where 学生学号='$学号'";
  $db->Execute($sql);
  //$sql = "update edu_dierketangpingfen set 班级名称='$班级名称' where 学生学号='$学号'";
  //$db->Execute($sql);
  $sql = "update edu_evaluatepersonal set 班级='$班级名称' where 学号='$学号'";
  $db->Execute($sql);
  $sql = "update edu_exam set 班级='$班级名称' where 学号='$学号'";
  $db->Execute($sql);
  $sql = "update edu_grad set 班号='$班级名称' where 学号='$学号'";
  $db->Execute($sql);
  $sql = "update edu_growfiles set 班级='$班级名称' where 学号='$学号'";
  $db->Execute($sql);
  $sql = "update edu_jiafang set 班级='$班级名称' where 学号='$学号'";
  $db->Execute($sql);
  $sql = "update edu_jiangxuejin set 班级='$班级名称' where 学号='$学号'";
  $db->Execute($sql);
  //$sql = "update edu_kechengshenqing set 班级='$班级名称' where 学号='$学号'";
  //$db->Execute($sql);
  $sql = "update edu_kewaifudao set 班级='$班级名称' where 学号='$学号'";
  $db->Execute($sql);
  $sql = "update edu_leaguemember set 班级='$班级名称' where 学号='$学号'";
  $db->Execute($sql);
  $sql = "update edu_louzhangguanli set 班级='$班级名称' where 学号='$学号'";
  $db->Execute($sql);
  //$sql = "update edu_newstudent set 班级='$班级名称' where 学号='$学号'";
  //$db->Execute($sql);
  $sql = "update edu_partymember set 班级='$班级名称' where 学号='$学号'";
  $db->Execute($sql);
  $sql = "update edu_partymember2 set 班级='$班级名称' where 学号='$学号'";
  $db->Execute($sql);
  $sql = "update edu_pingjiamingxi set 班级='$班级名称' where 学号='$学号'";
  $db->Execute($sql);
  $sql = "update edu_qimopingyu set 班级='$班级名称' where 学号='$学号'";
  $db->Execute($sql);
  $sql = "update edu_qingongjianxue set 学生班级='$班级名称' where 学生学号='$学号'";
  $db->Execute($sql);
  $sql = "update edu_shenghuobuzhu set 班级='$班级名称' where 学号='$学号'";
  $db->Execute($sql);
  $sql = "update edu_shixishenqing set 班级='$班级名称' where 学号='$学号'";
  $db->Execute($sql);
  $sql = "update edu_shoufeidan set 班级='$班级名称' where 学号='$学号'";
  $db->Execute($sql);
  $sql = "update edu_shoufeidanprint set 班级='$班级名称' where 学号='$学号'";
  $db->Execute($sql);
  $sql = "update edu_smsrecord set 班级='$班级名称' where 学号='$学号'";
  $db->Execute($sql);
  $sql = "update edu_stubad set 原班号='$班级名称' where 学号='$学号'";
  $db->Execute($sql);
  $sql = "update edu_student set 班号='$班级名称' where 学号='$学号'";
  $db->Execute($sql);
  //$sql = "update edu_studentcardkaoqin set 班级='$班级名称' where 学号='$学号'";
  //$db->Execute($sql);
  $sql = "update edu_studentcardkaoqinmingxi set 班级名称='$班级名称' where 学号='$学号'";
  $db->Execute($sql);
  $sql = "update edu_studentchange set 班级='$班级名称' where 学号='$学号'";
  $db->Execute($sql);
  $sql = "update edu_studentcourse set 班级名称='$班级名称' where 学号='$学号'";
  $db->Execute($sql);
  //$sql = "update edu_studentflow set 班级='$班级名称' where 学号='$学号'";
  //$db->Execute($sql);
  $sql = "update edu_studentjiangcheng set 班级='$班级名称' where 学生学号='$学号'";
  $db->Execute($sql);
  $sql = "update edu_studentjiesong set 班级='$班级名称' where 学号='$学号'";
  $db->Execute($sql);
  $sql = "update edu_studentjiuye set 班号='$班级名称' where 学号='$学号'";
  $db->Execute($sql);
  $sql = "update edu_studentkaoqin set 班级名称='$班级名称' where 学号='$学号'";
  $db->Execute($sql);
  $sql = "update edu_studentpingjiamingxi set 班级='$班级名称' where 学号='$学号'";
  $db->Execute($sql);
  //$sql = "update edu_stulog set 班级='$班级名称' where 学号='$学号'";
  //$db->Execute($sql);
  $sql = "update edu_tanhuajilu set 所属班级='$班级名称' where 学号='$学号'";
  $db->Execute($sql);
  $sql = "update edu_tuibandengji set 班级名称='$班级名称' where 学号='$学号'";
  $db->Execute($sql);
  $sql = "update edu_tuifeidan set 班级名称='$班级名称' where 学号='$学号'";
  $db->Execute($sql);
  $sql = "update edu_tuijianjiuye set 班号='$班级名称' where 学号='$学号'";
  $db->Execute($sql);
  $sql = "update edu_uchome set 班级='$班级名称' where 学号='$学号'";
  $db->Execute($sql);
  $sql = "update edu_waichuzhufang set 班级='$班级名称' where 学号='$学号'";
  $db->Execute($sql);
  $sql = "update edu_wanguixinxi set 班级='$班级名称' where 学号='$学号'";
  $db->Execute($sql);
  $sql = "update edu_weijihuizong set 班级名称='$班级名称' where 学生学号='$学号'";
  $db->Execute($sql);
  $sql = "update edu_weizhangxinxi set 班级='$班级名称' where 学号='$学号'";
  $db->Execute($sql);
  $sql = "update edu_xiaoyou set 班级='$班级名称' where 学号='$学号'";
  $db->Execute($sql);
  $sql = "update edu_youxiubiyesheng set 班号='$班级名称' where 学号='$学号'";
  $db->Execute($sql);
  $sql = "update edu_zhaopinshenqin set 班级='$班级名称' where 学号='$学号'";
  $db->Execute($sql);
  $sql = "update edu_zhengshuguanli set 班级='$班级名称' where 学号='$学号'";
  $db->Execute($sql);
  $sql = "update edu_zuoweixinxi set 所属班级='$班级名称' where 学生学号='$学号'";
  $db->Execute($sql);

  $sql = "update school_homeworkupload set 班级='$班级名称' where 学号='$学号'";
  $db->Execute($sql);
  $sql = "update tiku_chengji set 班级='$班级名称' where 学号='$学号'";
  $db->Execute($sql);
  $sql = "update tiku_examdata set 班级='$班级名称' where 学号='$学号'";
  $db->Execute($sql);
  //$sql = "update wygl_baoxiuxinxi set 学生班级='$班级名称' where 学生学号='$学号'";
  //$db->Execute($sql);
}
*/

function 修改时同步教材数据($新值,$旧值) {
  global $_GET,$_POST,$db;
  if($新值==$旧值||$新值=='') {
    return '';
  }
  //$sql = "update edu_jiaocai set 教材名称='$新值' where 教材名称='$旧值'";
  //$db->Execute($sql);
  $sql = "update edu_jiaocaiin set 教材名称='$新值' where 教材名称='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_jiaocaiout set 教材名称='$新值' where 教材名称='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_jiaocaitiaoku set 教材名称='$新值' where 教材名称='$旧值'";
  $db->Execute($sql);
  $sql = "update edu_jiaocaitui set 教材名称='$新值' where 教材名称='$旧值'";
  $db->Execute($sql);
}

function 同步学生转班而带来的班级信息变化($学号,$新班级)					{
	global $db;

	$原班级 = returntablefield("edu_student","学号",$学号,"班号");
	if($原班级==$新班级)		{
		//print $原班级.$新班级;exit;
		return true;
	}
	else	{
		//继续执行
	}

	$处理表[] = array("dorm_changelog","班级","学号");
	$处理表[] = array("dorm_liusu","班级","学号");
	$处理表[] = array("dorm_rooming","班级","学号");
	$处理表[] = array("edu_banfeiguanli","所属班级","学号");
	$处理表[] = array("edu_banweiguanli","所属班级","学号");
	$处理表[] = array("edu_biyejianding","班级","学号");
	$处理表[] = array("edu_biyezheng","班级","学号");
	$处理表[] = array("edu_diaochamingxi","班级","学号");
	$处理表[] = array("edu_dierketangbaoming","班级名称","学生学号");
	$处理表[] = array("edu_evaluatepersonal","班级","学号");
	$处理表[] = array("edu_exam","班级","学号");
	$处理表[] = array("edu_grad","班号","学号");
	$处理表[] = array("edu_jiafang","班级","学号");
	$处理表[] = array("edu_jiangxuejin","班级","学号");
	$处理表[] = array("edu_kewaifudao","班级","学号");
	$处理表[] = array("edu_leaguemember","班级","学号");
	$处理表[] = array("edu_louzhangguanli","班级","学号");
	$处理表[] = array("edu_partymember","班级","学号");
	$处理表[] = array("edu_partymember2","班级","学号");
	$处理表[] = array("edu_pingjiamingxi","班级","学号");
	$处理表[] = array("edu_qimopingyu","班级","学号");
	$处理表[] = array("edu_qingongjianxue","学生班级","学生学号");
	$处理表[] = array("edu_shenghuobuzhu","班级","学号");
	$处理表[] = array("edu_shixishenqing","班级","学号");
	$处理表[] = array("edu_shoufeidan","班级","学号");
	$处理表[] = array("edu_shoufeidanprint","班级","学号");
	$处理表[] = array("edu_smsrecord","班级","学号");
	$处理表[] = array("edu_studentcardkaoqinmingxi","班级名称","学号");
	$处理表[] = array("edu_studentcourse","班级名称","学号");
	$处理表[] = array("edu_studentjiangcheng","班级","学生学号");
	$处理表[] = array("edu_studentjiesong","班级名称","学号");
	$处理表[] = array("edu_studentjiuye","班号","学号");
	$处理表[] = array("edu_studentkaoqin","班级名称","学号");
	$处理表[] = array("edu_shoufeidan","班级","学号");
	$处理表[] = array("edu_studentpingjiamingxi","班级","学号");
	$处理表[] = array("edu_tanhuajilu","所属班级","学号");
	$处理表[] = array("edu_tuibandengji","班级名称","学号");
	$处理表[] = array("edu_tuifeidan","班级名称","学号");
	$处理表[] = array("edu_tuijianjiuye","班号","学号");
	$处理表[] = array("edu_uchome","班级","学号");
	$处理表[] = array("edu_waichuzhufang","班级","学号");
	$处理表[] = array("edu_wanguixinxi","班级","学号");
	$处理表[] = array("edu_weijihuizong","班级名称","学生学号");
	$处理表[] = array("edu_weizhangxinxi","班级","学号");
	$处理表[] = array("edu_xiaoyou","班级","学号");
	$处理表[] = array("edu_youxiubiyesheng","班号","学号");
	$处理表[] = array("edu_zhaopinshenqin","班级","学号");
	$处理表[] = array("edu_zhengshuguanli","班级","学号");
	$处理表[] = array("edu_zuoweixinxi","所属班级","学生学号");
	$处理表[] = array("edu_piaojufafang","班级","学号");
	$处理表[] = array("edu_studentfafang","班级","学号");

	for($i=0;$i<sizeof($处理表);$i=$i+1)		{
		$Element = $处理表[$i];
		$sql = "update ".$Element[0]." set ".$Element[1]."='$新班级' where ".$Element[2]."='$学号'";
		$db->Execute($sql);
		//print $sql."<BR>";
	}

	//附带更新下专业及系信息

	$sql = "update edu_shoufeidan set 系名称='$系名称',专业='$专业' where 学号='$学号'";
	$db->Execute($sql);
	$sql = "update edu_shoufeidanprint set 系名称='$系名称',专业='$专业' where 学号='$学号'";
	$db->Execute($sql);
	$sql = "update edu_studentpingjiamingxi set 系='$系名称',专业='$专业' where 学号='$学号'";
	$db->Execute($sql);
	$sql = "update edu_tuifeidan set 系名称='$系名称',专业名称='$专业' where 学号='$学号'";
	$db->Execute($sql);

	//exit;
}

function 根据班级生成学号($班号)			{
	global $db;

	//自动生成学号
	//$sql = "select max(学号) as 最大学号 from edu_student where 班号='".$班号."'";
	//$rss = $db->Execute($sql);
	//$最大学号1 = $rss->fields['最大学号'];

	//$sql = "select max(学号) as 最大学号 from edu_newstudent where 班级='".$班号."'";
	//$rss = $db->Execute($sql);
	//$最大学号2 = $rss->fields['最大学号'];

	$sql = "SELECT length(学号) AS NUM,学号 FROM edu_student WHERE 班号='".$班号."' ORDER BY NUM DESC,学号 DESC LIMIT 0,1";
	$rs  = $db->Execute($sql);
	$最大学号1 = $rs->fields['学号'];


	$sql = "SELECT length(学号) AS NUM,学号 FROM edu_newstudent WHERE 班级='".$班号."' ORDER BY NUM DESC,学号 DESC LIMIT 0,1";
	$rs  = $db->Execute($sql);
	$最大学号2 = $rs->fields['学号'];

	if($最大学号1>$最大学号2)		{
		$最大学号 = $最大学号1;
	}
	else		{
		$最大学号 = $最大学号2;
	}
	//print $最大学号."<BR>";
	if($最大学号=="")							{
		$学号 = returntablefield("edu_banji","班级名称",$班号,"班级代码")."01";
	}
	else		{
		$学号 = 学号格式化($最大学号);
	}
	//循环100次,如果当前学号存在,则执行学号格式化操作(自动+1),然后再执行,如果不存在,则跳出FOR循环.
	for($i=0;$i<100;$i++)			{
		$中间学号 = returntablefield("edu_student","学号",$学号,"学号","","",0);
		//print $学号."||$中间学号<BR>";
		if($中间学号!="")		{
			//执行+1
			$学号	=		学号格式化($中间学号);
			continue;
		}
	}
	//print $学号;exit;
	return $学号;
}


function 根据班级生成学生序号($班号='')			{
	global $db;
	//返回一个固定的值,然后再在edu_student里面用编号来替换这个固定的值
	//$sql = "update edu_student set 学号=编号 where 学号='XH'";
	//$db->Execute($sql);
	return 'XH';
}


function 学号格式化($最大学号)				{
	$学号后缀	= (int)substr($最大学号,-3);
	$学号后缀  += 1;
	if(strlen($学号后缀)=="1")			{
		$学号后缀 = "00".$学号后缀;
	}
	elseif(strlen($学号后缀)=="2")		{
		$学号后缀 = "0".$学号后缀;
	}
	elseif(strlen($学号后缀)=="3")		{
		$学号后缀 = $学号后缀;
	}
	$最大学号 = substr($最大学号,0,-3).$学号后缀;
	//print $最大学号;
	return $最大学号;
}


//处理成绩表中,默认教师为空情况下面的教师对应关系
function DoDealExamTeacherDataInfor()				{
	global $db,$SCHOOL_MODEL_TEXT;
	$当前学期 = returntablefield("edu_xueqiexec","当前学期",'1',"学期名称");
	$sql = "select * from edu_exam where 教师=''";
	$rs = $db->Execute($sql);
	$rs_a = $rs->GetArray();

	for($i=0;$i<sizeof($rs_a);$i++)		{
		$课程 = $rs_a[$i]['课程'];
		$班级 = $rs_a[$i]['班级'];
		$编号 = $rs_a[$i]['编号'];
		$课程 = $rs_a[$i]['课程'];
		$入学年份 = returntablefield("edu_banji","班级名称",$班级,"入学年份");
		$returnCurXueQiIndex = returnCurXueQiIndex($入学年份);
		if($SCHOOL_MODEL_TEXT=="4")			{
			$sql = "select 开课教师 from edu_planexec where 班级名称='$班级' and 开课学期='$returnCurXueQiIndex' and 课程名称='$课程'";
		}
		else		{
			$sql = "select 开课教师 from edu_planexec where 班级名称='$班级' and 开课学期='$returnCurXueQiIndex' and 课程名称='$课程'";
		}
		//print $sql."<BR>";
		$rsX = $db->Execute($sql);
		$开课教师 = $rsX->fields['开课教师'];
		if($开课教师!="")				{
			$sql = "update edu_exam set 教师='$开课教师' where 编号='$编号' ";
			$db->Execute($sql);
			//print $sql."<BR>";
		}
	}


}

//返回数组的名次信息
function returnArrayMingCi($Result='')				{
	//排名信息
	$ArrayValues = @array_values($Result);
	$NewSortArrayValues = array();
	for($i=0;$i<sizeof($ArrayValues);$i++)		{
		$Values = $ArrayValues[$i];
		if(!in_array($Values,$NewSortArrayValues))	{
			$NewSortArray[$Values] = $i+1;
			array_push($NewSortArrayValues,$Values);
		}
	}
	//print_R($NewSortArray);
	return $NewSortArray;
}

//返回给定时间的星期信息
function 返回给定时间的星期信息($Target='')							{
	global $db;
	if($Target=="") $Target = date("Y-m-d");
	$TargetArray = explode('-',$Target);
	$w = date('w',mktime(2,1,1,$TargetArray[1],$TargetArray[2],$TargetArray[0]));
	return $w;
}
//返回给定时间的周次信息
function returnCurWeekIndex($Target='',$学期名称='')				{
	global $db;

	if($学期名称=='')		{
		$sql = "select 结束时间,开始时间 from edu_xueqiexec where 当前学期='1'";
	}
	else	{
		$sql = "select 结束时间,开始时间 from edu_xueqiexec where 学期名称='$学期名称'";
	}
	$rs = $db->Execute($sql);
	$rs_a = $rs->GetArray();
	$开始时间 = $rs_a[0]['开始时间'];
	$开始时间Array = explode('-',$开始时间);
	if($Target=="0000-00-00")	return '1';
	if($Target=="") $Target = date("Y-m-d");


	$TargetArray = explode('-',$Target);
	/*
	$M1 = mktime(1,1,1,$开始时间Array[1],$开始时间Array[2],$开始时间Array[0]);
	$M2 = mktime(1,1,1,$TargetArray[1],$TargetArray[2],$TargetArray[0]);
	$时间线差值 = $M2-$M1;
	$周数 = $时间线差值/(3600*24*7);
	$周数 = ceil($周数);
	return $周数;
	*/

	$W1 = date('W',mktime(2,1,1,$开始时间Array[1],$开始时间Array[2],$开始时间Array[0]));
	$W2 = date('W',mktime(2,1,1,$TargetArray[1],$TargetArray[2],$TargetArray[0]));
	$W = $W2-$W1+1;
	$年度数 = $TargetArray[0];
		//print_R($TargetArray);
		//print $年度数;
		//print_R($开始时间Array);
		//print "上年度周数-".$上年度周数."<BR>";
		//print "W-".$W."<BR>";
		//print "W1-".$W1."<BR>";
		//print "W2-".$W2."".date('W',mktime(2,1,1,1,1,2010))."<BR>";
	$上年度周数 = date('W',mktime(1,1,1,12,31,$年度数-1));
	//print "W-".$W."<BR>";
	if($W<0)					{
		//print $Target;
		$W = $上年度周数-$W1+$W2+1;
		//上年度总周次 - 开学时间周次 + 当前时间周次 +1
		//print "W2-".$W2."".date('W',mktime(2,1,1,1,1,2010))."<BR>";
		//print "W-".$W."<BR>";
		//exit;
	}
	return $W;
}

//根据班级信息得到所有班级的级别信息列表
function returnBanjiJiBieList()				{
	global $db;
	$sql = "select distinct 入学年份 from edu_banji order by 入学年份 desc";
	$rs = $db->CacheExecute(36,$sql);
	$rs_a = $rs->GetArray();
	for($i=0;$i<sizeof($rs_a);$i++)									{
		$NewArray[] = $rs_a[$i]['入学年份'];
	}
	return $NewArray;
}


//根据班级名称和当前学期在教学计划中得到课程名称列表
function returnBanjiCourseList($ClassCode,$returnCurXueQiIndex,$考试名称='')				{
	global $db,$SCHOOL_MODEL_TEXT;
	//print $SCHOOL_MODEL_TEXT;
	if($考试名称=="")			{
		if($returnCurXueQiIndex=="")		{
			$开课学期	= $returnCurXueQiIndex;
		}
		else	{
			$开课学期	= returntablefield("edu_xueqiexec","当前学期",'1',"学期名称");
		}
		$sql		= "select distinct 课程名称 from edu_planexec where 班级名称='$ClassCode' and 开课学期='$开课学期' and 课程名称!=''";
	}
	else		{
		//从考试成绩表里面得到学期名称
		$sql	= "select 学期名称 from edu_examname where 考试名称='$考试名称'";
		$rs		= $db->CacheExecute(150,$sql);
		$rs_a	= $rs->GetArray();
		$学期名称 = $rs_a[0]['学期名称'];
		$级别	= returntablefield("edu_banji","班级名称",$ClassCode,"入学年份");
		//$returnCurXueQiIndex = returnCurXueQiIndex($级别,$学期名称);
		$sql = "select distinct 课程名称 from edu_planexec where 开课学期='$学期名称' and 班级名称='$ClassCode' and 课程名称!='' order by 课程名称";
	}
	//print $sql;//exit;

	$rs		= $db->CacheExecute(150,$sql);
	$rs_am	= $rs->GetArray();
	/*
	$课程名称Array1 = array();
	for($i=0;$i<count($rs_am);$i++)			{
		$课程名称			= $rs_am[$i]['课程名称'];
		$课程名称Array1[]	= $课程名称;
		$课程名称Array2[$课程名称] = $课程名称;
	}
	*/
	/*
	if($考试名称!="")									{
		//从现有的成绩数据中复加课程信息
		$sql = "select distinct 课程 from edu_exam  where 考试名称='$考试名称' and 班级='$ClassCode' and 学期名称='$学期名称' and 课程!=''";
		$rs = $db->CacheExecute(150,$sql);
		$rs_a = $rs->GetArray();//print_R($rs_a);
		for($i=0;$i<count($rs_a);$i++)					{
			$课程 = $rs_a[$i]['课程'];
			if(@!in_array($课程,$课程名称Array1)&&$课程!='')		{
				$课程名称Array1[]		= $课程;
				$课程名称Array2[$课程]	= $课程;
			}
		}
	}
	$课程名称Array = @array_keys($课程名称Array2);
	for($i=0;$i<count($课程名称Array);$i++)				{
		$课程名称 = $课程名称Array[$i];
		if($课程名称!="")	$rs_amX[$i]['课程名称'] = $课程名称;
	}
	*/
	return $rs_am;
}


function 按班级初始化学生成绩数据已经存在的不做处理($班号,$考试名称)			{
	global $db;

	$sql	= "select 学期名称 from edu_examname where 考试名称='$考试名称'";
	$rs		= $db->CacheExecute(150,$sql);
	$rs_a	= $rs->GetArray();
	$学期名称 = $rs_a[0]['学期名称'];

	$sql = "select distinct 课程名称,开课教师,学分 from edu_planexec where 开课学期='$学期名称' and 班级名称='$班号' and 课程名称!='' order by 课程名称";
	$rs = $db->CacheExecute(150,$sql);
	$课程列表数组 = $rs->GetArray();

	$sql = "delete from edu_exam where 考试名称='$考试名称' and 班级='$班号' and 课程 not in
					(select distinct 课程名称 from edu_planexec where 开课学期='$学期名称' and 班级='$班号')
					";
	$db->Execute($sql);
	//print $sql."<BR>";


	$入学年份 = returntablefield("edu_banji","班级名称",$班号,"入学年份");
	$sql = "select 学号,姓名,班号 from edu_student where 班号='$班号' and 学生状态='正常状态'";
	$rs = $db->CacheExecute(150,$sql);
	$rs_am = $rs->GetArray();
	for($i=0;$i<sizeof($rs_am);$i++)								{
		$学号 = $rs_am[$i]['学号'];
		$姓名 = $rs_am[$i]['姓名'];
		$班号 = $rs_am[$i]['班号'];
		for($iX=0;$iX<sizeof($课程列表数组);$iX++)				{
			$课程 = $课程列表数组[$iX]['课程名称'];
			$教师 = $课程列表数组[$iX]['开课教师'];
			$学分 = $课程列表数组[$iX]['学分'];
			$sql = "select COUNT(*) AS NUM from edu_exam where 课程='$课程' and 学号='$学号' and 考试名称='$考试名称' and 学期名称='$学期名称'";
			$rsD = $db->Execute($sql);
			$NUM = $rsD->fields['NUM'];
			//print $sql;
			if($NUM==0)				{
				$教师节= '';
				$sql = "insert into edu_exam (考试名称,班级,学号,姓名,课程,级别,Date,类型,教师,学期名称,备注,学分)
							values('$考试名称','$班号','$学号','$姓名','$课程','$入学年份','".date("Y-m-d")."','正常','$教师','$学期名称','$班号','$学分');
							";
				$db->Execute($sql);
				$COUNTER++;
				//print $sql."<BR>";//exit;
			}

		}
	}
	//print_R($课程列表数组);exit;
	return $COUNTER;
}

//返回班级所上的课程
function returnBanjiCourseListMiddleSchool($ClassCode,$returnCurXueQiIndex)				{
	global $db;
	$sql = "select distinct 课程名称 from edu_course order by 课程名称";
	$rs = $db->Execute($sql);
	$rs_am = $rs->GetArray();
	return $rs_am;
}

//给出年级和学期索引_返回学期名称
function 给出年级和学期索引_返回学期名称($年级,$学期索引)							{
	global $db;
	$学期年度		= floor($学期索引%2);
	$上学期下学期	= $学期索引%2;
	if($上学期下学期==0)		$学期名称 = "".($年级+$学期年度-1)."-".($年级+$学期年度)."-第二学期";
	if($上学期下学期==1)		$学期名称 = "".($年级+$学期年度)."-".($年级+$学期年度+1)."-第一学期";
	return $学期名称;
}

//根据年级返回当前的开课学期索引
function returnCurXueQiIndex($NJ,$学期名称='')				{
	global $db;
	//替换原有学期索引的作法,新的方案采用学期名称的方式,去除原有换算的方法 2010-07-21
	if($学期名称=="")
		$学期名称 = returntablefield("edu_xueqiexec","当前学期",'1',"学期名称");
	return $学期名称;
}

//子菜单权限管理部分,同时在FRAMEWORK和EDU下面进行定义
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
	//三个都为空时的情况判断
	if($DEPT_NAME==""&&$USER_NAME==""&&$ROLE_NAME=="")		{
		$return = 1;
	}
	//全体部门
	if($DEPT_NAME=="ALL_DEPT")			{
		$return = 1.5;
	}
	//用户判断
	$LOGIN_USER_ID = $_SESSION['LOGIN_USER_ID'];
	$LOGIN_USER_ID_ARRAY = explode(',',$USER_NAME);
	if(in_array($LOGIN_USER_ID,$LOGIN_USER_ID_ARRAY))		{
		$return = 2;
	}
	//部门判断
	$LOGIN_DEPT_ID = $_SESSION['LOGIN_DEPT_ID'];
	$LOGIN_DEPT_ID_ARRAY = explode(',',$DEPT_NAME);
	if(in_array($LOGIN_DEPT_ID,$LOGIN_DEPT_ID_ARRAY))		{
		$return = 3;
	}
	//角色判断
	$LOGIN_USER_PRIV = $_SESSION['LOGIN_USER_PRIV'];
	$LOGIN_USER_PRIV_ARRAY = explode(',',$ROLE_NAME);
	if(in_array($LOGIN_USER_PRIV,$LOGIN_USER_PRIV_ARRAY))		{
		$return = 4;
	}
	//print_R($_SESSION);
	return $return;
}

//返回更新时间
function returnUpdateDate($CurXueQi,$FieldName="班级",$BanJi='')		{
	global $db;
	$sql = "select max(Date) as Date from edu_exam where $FieldName='$BanJi' and 考试名称='$CurXueQi'";
	$rs = $db->Execute($sql);
	return $rs->fields['Date'];
}

//返回成绩统计数据字段
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

//返回成绩范围
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

//显示提示信息
function EDU_TripInfor($CONTENT = "教师没有登录，请重新登录!")		{
	global $LOGIN_THEME;
	print "<LINK href=\"/theme/$LOGIN_THEME/style.css\" type=text/css rel=stylesheet>
		<table width=360  border=0 align=center cellpadding=0 cellspacing=0 class=\"small\" style=\"border:1px solid #006699;\">
		<tr>
		<td height=\"50\" align=\"middle\" colspan=2 background=\"/theme/$LOGIN_THEME/images/index_01_backup.gif\" bgcolor=\"#E0F2FC\">
		<font color=red>$CONTENT</font>
		</td>
		</table>";
}

//返回页面
function EDU_Indextopage($page,$nums='0')		{
	print  "<META HTTP-EQUIV=REFRESH CONTENT='".$nums.";URL=".$page."'>\n";
}

//给教师发送短信通知
function send_sms_teacher($MobileText,$Content,$Header="您有新的公告通知:")				{
	global $db,$_GET,$_POST;
	$Content = $Header.$Content;
	$SERVER_NAME = $_SERVER['SERVER_NAME'];
	//$SERVER_NAME = "sz070811.dipns.com";
	if($_POST['SendSmsTime']!="")	$DateTime = $_POST['SendSmsTime'];
	else			$DateTime = date("Y-m-d");

	$Count = 0;
	//初始化汉字统计
	preg_match_all("/[\x80-\xff]?./",$Content,$CH_Array);
	//得到汉字总数量
	$MaxLen = count($CH_Array[0]);
	$array_slice = array_slice($CH_Array[0], $from=0, $length=138);
	$Content = join('',$array_slice);

	global $SYSTEM_SMS_INFOR;
	require_once('../Teacher/configsms.inc.php');
	//WebService
	////http://221.236.8.245/admin/sms3.aspx?phone=13540087220;02889615587;13681234567&code=940318&msg=金色校园
	//WEB GET
	$URL = "http://".$SYSTEM_SMS_INFOR."/admin/sms3.aspx?cityname=&schooldns=$SERVER_NAME&phone=$MobileText&time1=$DateTime&code=940318&msg=$Content";
	$URL = ereg_replace(' ','%20',$URL);
	//print strlen($Content);
	//print $URL."<BR>";exit;
	$file = @file($URL);
	//print $URL."<BR>";exit;
	$Text = @join('',$file);

}

//返回班级的学生人数
function returnClassNumber($ClassName)		{
	global $db;
	$sql = "select count(班号) as num from edu_student where 班号='$ClassName' and 学生状态='正常状态'";
	$rs = $db->CacheExecute(5,$sql);
	$rs_a = $rs->GetArray();
	return $rs_a[0]['num'];
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


//子菜单权限管理部分,同时在FRAMEWORK和EDU下面进行定义
function returnPrivMenu($ModuleName)		{
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
	//三个都为空时的情况判断
	if($DEPT_NAME==""&&$USER_NAME==""&&$ROLE_NAME=="")		{
		$return = 1;
	}
	//全体部门
	if($DEPT_NAME=="ALL_DEPT")			{
		$return = 1.5;
	}
	//用户判断
	$LOGIN_USER_ID = $_SESSION['LOGIN_USER_ID'];
	$LOGIN_USER_ID_ARRAY = explode(',',$USER_NAME);
	if(in_array($LOGIN_USER_ID,$LOGIN_USER_ID_ARRAY))		{
		$return = 2;
	}
	//部门判断
	$LOGIN_DEPT_ID = $_SESSION['LOGIN_DEPT_ID'];
	$LOGIN_DEPT_ID_ARRAY = explode(',',$DEPT_NAME);
	if(in_array($LOGIN_DEPT_ID,$LOGIN_DEPT_ID_ARRAY))		{
		$return = 3;
	}
	//角色判断
	$LOGIN_USER_PRIV = $_SESSION['LOGIN_USER_PRIV'];
	$LOGIN_USER_PRIV_ARRAY = explode(',',$ROLE_NAME);
	if(in_array($LOGIN_USER_PRIV,$LOGIN_USER_PRIV_ARRAY))		{
		$return = 4;
	}
	//print_R($_SESSION);
	return $return;
}

function base64_encode2($value)		{
	return $value;
}







?>