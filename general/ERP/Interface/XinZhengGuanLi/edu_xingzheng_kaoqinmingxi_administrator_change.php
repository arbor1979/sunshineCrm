<?php
ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL);

// display warnings and errors
error_reporting(E_WARNING | E_ERROR);

//header("Content-Type:text/html;charset=gbk");
//######################教育组件-权限较验部分##########################
require_once("lib.inc.php");

$GLOBAL_SESSION=returnsession();
$SYSTEM_PRIV_STOP = 1;
require_once("systemprivateinc.php");
CheckSystemPrivate("人力资源-行政考勤-初始化");
//######################教育组件-权限较验部分##########################

//require_once("lib.xiaoli.inc.php");
require_once("lib.xingzheng.inc.php");
$CurXueQi = returntablefield("edu_xueqiexec","当前学期",'1',"学期名称");


//重新转化班次里面USER_NAME为USER_ID();
//修正增加教师用户名带来的空字段信息X();
//重新转化排班里面USER_NAME为USER_ID();


if($_GET['行政人员']!="")	$SHOWTEXT = "1";
else		$SHOWTEXT = "0";

//$SHOWTEXT = "1";

if($_GET['action']=="")			{
	page_css("初始化调整");
	print "<SCRIPT>
	function FormCheck()
	{
		if (document.form1.行政人员.value == \"\") {
		alert(\"教师信息没有填写\");
		return false;}
	}
	function td_calendar(fieldname) {
		myleft=document.body.scrollLeft+event.clientX-event.offsetX-80;
		mytop=document.body.scrollTop+event.clientY-event.offsetY+140;
		window.showModalDialog(fieldname,self,\"edge:raised;scroll:0;status:0;help:0;resizable:1;dialogWidth:280px;dialogHeight:200px;dialogTop:\"+mytop+\"px;dialogLeft:\"+myleft+\"px\");
		}
	</SCRIPT>";
	
	
	
	print "<FORM name=form1 onsubmit=\"return FormCheck();\"  action=\"?action=DataDeal&pageid=1\" method=post encType=multipart/form-data>";
	table_begin("80%");
	print "<tr class=TableHeader><td colspan=2>&nbsp;初始化调整[需处理大量数据,点击后请稍等]</td></tr>";
	print "<tr class=TableData><td width=40%>&nbsp;初始化开始时间:</td><td>&nbsp;&nbsp;&nbsp;<INPUT class=SmallInput size=10  name=\"开始时间\" value=\"".date("Y-m-d",mktime(1,1,1,date('m'),date('d')-27,date('Y')))."\"  onclick=\"WdatePicker({dateFmt:'yyyy-MM-dd'})\" readonly></td></tr>";
	print "<tr class=TableData><td width=40%>&nbsp;初始化结束时间</td><td>&nbsp;&nbsp;&nbsp;<INPUT class=SmallInput size=10  name=\"结束时间\" value=\"".date("Y-m-d",mktime(1,1,1,date('m'),date('d')+3,date('Y')))."\"  onclick=\"WdatePicker({dateFmt:'yyyy-MM-dd'})\" readonly></td></tr>";
	print "<TR><TD class=TableData noWrap>&nbsp;行政人员:</TD>
	<TD class=TableData noWrap colspan=\"\">&nbsp;
	<input type=\"hidden\" name=\"行政人员_ID\" value=\"\">
	<input type=\"text\" name=\"行政人员\" value=\"\" readonly class=\"SmallStatic\" size=\"20\">
	<a href=\"javascript:;\" class=\"orgAdd\" onClick=\"SelectTeacherSingle('','行政人员_ID', '行政人员')\">选择</a>
	</TD></TR>";
	print_submit("提交");
	table_end();
	form_end();

	print "<BR><BR>";
	print "<FORM name=form2 action=\"?action=DataDealALL&pageid=1\" method=post encType=multipart/form-data>";
	table_begin("80%");
	print "<tr class=TableHeader><td colspan=2>&nbsp;初始化调整[全休人员]</td></tr>";
	print "<tr class=TableData><td width=40%>&nbsp;初始化时间:</td><td>&nbsp;&nbsp;&nbsp;<INPUT class=SmallInput size=10  name=开始时间 value=\"".date("Y-m-d",mktime(1,1,1,date('m'),date('d'),date('Y')))."\"  onclick=\"WdatePicker({dateFmt:'yyyy-MM-dd'})\" readonly>
	</td></tr>";
	//<input type=\"button\"  title=''  value=\"选择\" class=\"SmallButton\" onclick=\"td_calendar('../../Framework/sms_index/calendar_begin.php?datetime=开始时间');\" title=\"选择\" name=\"button\">
	print_submit("提交");
	table_end();
	form_end();


	if($_GET['action']==''||$_GET['action']=='init_default')		{
		$PrintText .= "<BR><table  class=TableBlock align=center width=80%>";
		$PrintText .= "<TR class=TableContent><td ><font color=green >
	初始化：<BR>
&nbsp;&nbsp;①如果排班了之后没有发现对应需要考勤的数据，或是发现自己的考勤数据有误，可以在此模块重新初始化自己的考勤数据。<BR>
&nbsp;&nbsp;②分为初始化某一个人某一个时间段内的考勤信息和初始化全体人员某一天的考勤信息两种模式。
	</font></td></table>";
		print $PrintText;
	}


	exit;
}






if($_GET['action']=="DataDeal"&&$_REQUEST['行政人员']!="")			{

page_css("初始化调整");

require_once("lib.xingzheng.inc.php");
//XiaoLiArray();



//print_R($_REQUEST);
$开始时间 = $_REQUEST['开始时间'];
$结束时间 = $_REQUEST['结束时间'];
$开始时间Array = explode('-',$开始时间);
$结束时间Array = explode('-',$结束时间);
$结束时间 = date("Y-m-d",mktime(1,1,1,$结束时间Array[1],$结束时间Array[2],$结束时间Array[0]));
$行政人员 = $_REQUEST['行政人员'];
$人员用户名 = $_REQUEST['行政人员_ID'];

//默认180天,初始化,如果超过,则进行跳出
for($i=0;$i<180;$i++)		{

	$Datetime	= date("Y-m-d",mktime(1,1,1,$开始时间Array[1],$开始时间Array[2] + $i,$开始时间Array[0]));
	$最迟填写时间 = date("Y-m-d",mktime(1,1,1,$开始时间Array[1],$开始时间Array[2] + $i + 10,$开始时间Array[0]));
	$当天时间 = date("Y-m-d");

	if($Datetime>$结束时间)		{
		break;
	}
	else	{


		//print "<BR>开始处理当前教师数据:###############<BR>";
		执行插入某人某天考勤信息($CurXueQi,$行政人员,$人员用户名,$Datetime);
		同步某人某天考勤机数据到考勤明细表($行政人员,$人员用户名,$Datetime);
		//print "<font color=green>处理".$_REQUEST['行政人员']."教师日期:".$Datetime."</font><BR>";
		//初始化教学日记
		//$sql = "update edu_xingzheng_kaoqinmingxi set 最迟填写时间 = '$最迟填写时间' where 人员='".$行政人员."' and 考勤日期='$Datetime'";
		//$db->Execute($sql);
		$sql = "update `edu_xingzheng_kaoqinmingxi` set 上班实际刷卡='上班缺打卡',上班考勤状态  ='上班缺打卡' where 上班实际刷卡='' and 上班考勤状态  ='' and 人员用户名='".$人员用户名."' and 日期<'$当天时间'";
		$db->Execute($sql);
		$sql = "update `edu_xingzheng_kaoqinmingxi` set 下班实际刷卡='下班缺打卡',下班考勤状态  ='下班缺打卡' where 下班实际刷卡='' and 下班考勤状态  ='' and 人员用户名='".$人员用户名."' and 日期<'$当天时间'";
		$db->Execute($sql);
		//if($SHOWTEXT) print "<BR><font color=red>*******:$sql <BR></font>";


	}
}

处理迟到早退分钟数数据();
print_infor("你的数据操作已经成功,请返回<BR><a href='edu_xingzheng_kaoqinmingxi_newai.php?XX=XX&action=init_default&人员用户名=$人员用户名&pageid=1'>点击直接查阅".$行政人员."人员的考勤明细</a>","location='?'","location='?'");;
exit;
}



function 排班人员List($考勤日期)			{
	global $db;
	//$开始时间 = date("Y-m-d",mktime(1,1,1,date('m'),date('d')-1,date('Y')));
	//$结束时间 = date("Y-m-d",mktime(1,1,1,date('m'),date('d')+14,date('Y')));
	$sql = "select 排班人员 from edu_xingzheng_paiban where 考勤日期='$考勤日期'";
	$rs = $db -> Execute($sql);
	$rs_a = $rs -> GetArray();
	$排班人员数据 = array();
	for($i=0;$i<sizeof($rs_a);$i++)		{
		$排班人员 = $rs_a[$i]['排班人员'];
		$排班人员Array = explode(',',$排班人员);
		for($iX=0;$iX<sizeof($排班人员Array);$iX++)		{
			$排班人员X = $排班人员Array[$iX];
			$排班人员数据[$排班人员X] = $排班人员X;
		}
	}
	$排班人员数据K = @array_keys($排班人员数据);
	//$排班人员 = join(',',$排班人员数据K);
	return $排班人员数据K;
}



if($_GET['action']=="DataDealALL")			{

page_css("初始化调整");

require_once("lib.xingzheng.inc.php");
//XiaoLiArray();



//print_R($_REQUEST);
$开始时间 = $_REQUEST['开始时间'];
$结束时间 = $_REQUEST['结束时间'];
$开始时间Array = explode('-',$开始时间);


$Datetime	= date("Y-m-d",mktime(1,1,1,$开始时间Array[1],$开始时间Array[2],$开始时间Array[0]));
//print "<BR>开始处理当前教师数据:###############<BR>";
$排班人员数据K = 排班人员List($Datetime);
for($iX=0;$iX<sizeof($排班人员数据K);$iX++)		{
	$人员用户名 = $排班人员数据K[$iX];
	$行政人员 = returntablefield("user","USER_ID",$人员用户名,"USER_NAME");
	执行插入某人某天考勤信息($CurXueQi,$行政人员,$人员用户名,$Datetime);
	同步某人某天考勤机数据到考勤明细表($行政人员,$人员用户名,$Datetime);
}
global $SHOWTEXT; if($SHOWTEXT)		print "<BR><BR><font color=red><B>处理".$行政人员."教师日期:".$Datetime."</B></font><BR>";


处理迟到早退分钟数数据();
$LOGIN_USER_NAME = $_SESSION['LOGIN_USER_NAME'];
print_infor("你的数据操作已经成功,请返回","location='?'","location='?'");;
exit;
}
?>