<?

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
	global $db;
	$sql = "select distinct 课程名称 from edu_planexec where 开课学期='$returnCurXueQiIndex' and 班级名称='$ClassCode' order by 课程名称";
	$rs = $db->CacheExecute(36,$sql);
	$rs_am = $rs->GetArray();

	if($考试名称!="")					{
		//从现有的成绩数据中复加课程信息
		$sql = "select distinct 课程 from edu_exam  where 考试名称='$考试名称' and 班级='$ClassCode'";
		$rs = $db->CacheExecute(36,$sql);
		$rs_a = $rs->GetArray();//print_R($rs_a);
		for($i=0;$i<count($rs_a);$i++)			{
		if(@!in_array($rs_a[$i]['课程'],$rs_am))
			$rs_am[]['课程名称'] = $rs_a[$i]['课程'];
		}
	}

	return $rs_am;
}


//返回班级所上的课程
function returnBanjiCourseListMiddleSchool($ClassCode,$returnCurXueQiIndex)				{
	global $db;
	$sql = "select distinct 课程名称 from edu_course order by 课程名称";
	$rs = $db->CacheExecute(3600,$sql);
	$rs_am = $rs->GetArray();
	return $rs_am;
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
	$sql = "select max(Date) as Date from edu_exam where $FieldName='$BanJi' and `学期`='$CurXueQi'";
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
	print "<LINK href=\"../../theme/1/style.css\" type=text/css rel=stylesheet>
		<table width=360  border=0 align=center cellpadding=0 cellspacing=0 class=\"small\" style=\"border:1px solid #006699;\">
		<tr>
		<td height=\"50\" align=\"middle\" colspan=2 background=\"../theme/1/images/index_01_backup.gif\" bgcolor=\"#E0F2FC\">
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
	$sql = "select count(班号) as num from edu_student where 班号='$ClassName'";
	$rs = $db->Execute($sql);
	$rs_a = $rs->GetArray();
	return $rs_a[0]['num'];
}

//培训部分需要使用的函数
function CashLeftNumber($当前时间='')		{
	global $db;
	if($当前时间=="")		$当前时间 = date("Y-m-d H:i:s");
	//收费单据金额
	$sql = "select SUM(收费金额) AS NUMBER from  edu_shoufeidan where 收费日期<='$当前时间' and 支付方式='现金'";
	$rs = $db->Execute($sql);
	$rs_a = $rs->GetArray();
	$NUMBER1 = $rs_a[0]['NUMBER'];
	//print $sql;
	//退费单据金额
	$sql = "select SUM(退费金额) AS NUMBER from  edu_tuifeidan where 退费日期<='$当前时间' and 支付方式='现金'";
	$rs = $db->Execute($sql);
	$rs_a = $rs->GetArray();
	$NUMBER2 = $rs_a[0]['NUMBER'];
	$LEFT = $NUMBER1-$NUMBER2;
	return $LEFT;
}
function BankLeftNumber($当前时间='')		{
	global $db;
	if($当前时间=="")		$当前时间 = date("Y-m-d H:i:s");
	//收费单据金额
	$sql = "select SUM(收费金额) AS NUMBER from  edu_shoufeidan where 收费日期<='$当前时间' and 支付方式!='现金'";
	$rs = $db->Execute($sql);
	$rs_a = $rs->GetArray();
	$NUMBER1 = $rs_a[0]['NUMBER'];
	//退费单据金额
	$sql = "select SUM(退费金额) AS NUMBER from  edu_tuifeidan where 退费日期<='$当前时间' and 支付方式!='现金'";
	$rs = $db->Execute($sql);
	$rs_a = $rs->GetArray();
	$NUMBER2 = $rs_a[0]['NUMBER'];
	//其它收入
	$sql = "select SUM(收入金额) AS NUMBER from  edu_qitashouru where 收入日期<='$当前时间' and 支付方式!='现金'";
	$rs = $db->Execute($sql);
	$rs_a = $rs->GetArray();
	$NUMBER3 = $rs_a[0]['NUMBER'];
	//其它支出
	$sql = "select SUM(支出金额) AS NUMBER from  edu_qitazhichu where 支出日期<='$当前时间' and 支付方式!='现金'";
	$rs = $db->Execute($sql);
	$rs_a = $rs->GetArray();
	$NUMBER4 = $rs_a[0]['NUMBER'];
	//存款单
	$sql = "select SUM(存款金额) AS NUMBER from  edu_cunkuandan where 存款日期<='$当前时间'";
	$rs = $db->Execute($sql);
	$rs_a = $rs->GetArray();
	$NUMBER5 = $rs_a[0]['NUMBER'];
	//取款单
	$sql = "select SUM(取款金额) AS NUMBER from  edu_qukuandan where 取款日期<='$当前时间'";
	$rs = $db->Execute($sql);
	$rs_a = $rs->GetArray();
	$NUMBER6 = $rs_a[0]['NUMBER'];
	$LEFT = $NUMBER1-$NUMBER2+$NUMBER3-$NUMBER4+$NUMBER5-$NUMBER6;
	return $LEFT;
}

function ReturnAlreadyFee($XH='20051082150',$XN='2006-2007')		{
global $db;
$sql = "select * from edu_shoufeidan where 学号='$XH' and 学年='$XN'";
$rs = $db->Execute($sql);
$rs_a = $rs->GetArray();
$NewArray = array();
//$ZYMC = returntablefield("XSJBXXB","XH",$XH,"ZYMC");
//$XMC = returntablefield("XSJBXXB","XH",$XH,"XI");
//$XYMC = returntablefield("XSJBXXB","XH",$XH,"XY");
for($i=0;$i<sizeof($rs_a);$i++)									{
		$XN = $rs_a[$i]['XN'];
		$学号 = $rs_a[$i]['学号'];
		$XM = $rs_a[$i]['XM'];
		$NJ = $rs_a[$i]['NJ'];
		$BJMC = $rs_a[$i]['BJMC'];
		$BZ = $rs_a[$i]['BZ'];
		$CZRQ = $rs_a[$i]['CZRQ'];
		$SFLX = $rs_a[$i]['SFLX'];
		$SSHJ = $rs_a[$i]['SSHJ'];
		$收费项目名称 = $rs_a[$i]['收费项目名称'];
		$NewArray['明细'][$收费项目名称] += $rs_a[$i]['收费金额'];
		$NewArray['合计'] += $rs_a[$i]['收费金额'];
}
//print_R($NewArray);
return $NewArray;
}
//返回应交学费数组-高校部分
function ReturnOfficeFee($ZYDM='1211',$XN='2006-2007',$NJ='2006')		{
	global $db;
	$sql = "select * from edu_zhuanyeshoufei where 专业代码='$ZYDM' and 年级='$NJ' and 学年='$XN'";
	$rs = $db->Execute($sql);
    $rs_a = $rs->GetArray();
	$NewArray = array();
	for($i=0;$i<sizeof($rs_a);$i++)		{
		$收费标准 = $rs_a[$i]['收费标准'];
		$收费项目名称 = $rs_a[$i]['收费项目名称'];
		$NewArray['明细'][$收费项目名称] = $收费标准;
		$NewArray['合计'] += $收费标准;
	}
	return $NewArray;
}


//返回应交学费数组-中小学部分
function ReturnOfficeFeeMiddleSchool($XN='2006-2007',$NJ='2006')		{
	global $db;
	$sql = "select * from edu_zhuanyeshoufei where 年级='$NJ' and 学年='$XN'";
	$rs = $db->Execute($sql);
    $rs_a = $rs->GetArray();
	$NewArray = array();
	for($i=0;$i<sizeof($rs_a);$i++)		{
		$收费标准 = $rs_a[$i]['收费标准'];
		$收费项目名称 = $rs_a[$i]['收费项目名称'];
		$NewArray['明细'][$收费项目名称] = $收费标准;
		$NewArray['合计'] += $收费标准;
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