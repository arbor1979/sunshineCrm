<?php
	require_once('lib.inc.php');//

	$GLOBAL_SESSION=returnsession();
$SYSTEM_PRIV_STOP = 1;


$当前学期 = returntablefield("edu_xueqiexec","当前学期",'1',"学期名称");
if($_GET['学期']=="") $_GET['学期'] = $当前学期;

$学期名称 = $当前学期;
page_css('考勤补登');

	$_GET['人员'] = $_SESSION['LOGIN_USER_NAME'];
	$_GET['人员用户名'] = $_SESSION['LOGIN_USER_ID'];
	$人员用户名 = $_SESSION['LOGIN_USER_ID'];
	//$_GET['部门'] = returntablefield("department","DEPT_ID",$_SESSION['LOGIN_DEPT_ID'],"DEPT_NAME");



if($_GET['action']=='KaoQinBudeng')
{
	//print_R($_POST);exit;
 // [CHECK_2_0_VALUE] => on [0_VALUE] => 1 [0_ID] => 14 [0_BANJI] => 信息中心 [0_KECHENG] => 会议 [0_OLDDATE] => 2011-02-21 [0_OLDJIECI] => 会议 [0_OLDTEACHER] => 系统管理员 [CHECK_2_1_VALUE] => on 
		$考勤补登明细=$_POST;
		 $条=$_POST['COUNT'];
		$日记补登=array();
		for($i=0;$i<$条;$i++)
		{

			 $教室key=$i."_JIAOSHI";
			 $部门key=$i."_BANJI";
			 $班次key=$i."_KECHENG";			 
			 $上班时间key=$i."_OLDDATE";
			 $人员key=$i."_OLDTEACHER";
			 $上班补登状态key="CHECK_1_".$i."_VALUE";
			 $下班补登状态key="CHECK_2_".$i."_VALUE";
			
			  $部门 = $考勤补登明细[$部门key];
			  $班次 = $考勤补登明细[$班次key];
			  $上班时间 = $考勤补登明细[$上班时间key];
			  $星期= date('w',strtotime($上班时间));
			  //print strtotime($上班时间);

//exit;

			  $人员 = $考勤补登明细[$人员key];
			  $上班补登状态 = $考勤补登明细[$上班补登状态key];
			  $下班补登状态 = $考勤补登明细[$下班补登状态key];
 //exit;
			  // 编号  学期  部门  人员  时间  星期  班次  补登项目  审核状态  工作流ID号  审核人  审核时间  人员用户名 
				if($上班补登状态=='on')
				{
					$sql = "INSERT INTO edu_xingzheng_kaoqinbudeng ( `编号` , `学期` , `部门` , `人员` , `时间` , `星期` , `班次` , `补登项目` , `审核状态`, `工作流ID号` , `审核人`, `审核时间` , `人员用户名`   )VALUES ( '', '$学期名称', '$部门', '$人员', '$上班时间', '$星期', '$班次',  '上班考勤补登', '0', '', '', '', '$人员用户名')" ;

					 $rs = $db->Execute($sql);
					 //print $sql;exit;
					 
				}
				 if($下班补登状态=='on')
				{
				 $sql = "INSERT INTO edu_xingzheng_kaoqinbudeng ( `编号` , `学期` , `部门` , `人员` , `时间` , `星期` , `班次` , `补登项目` , `审核状态`, `工作流ID号` , `审核人`, `审核时间` , `人员用户名`   )VALUES ( '', '$学期名称', '$部门', '$人员', '$上班时间', '$星期', '$班次',  '下班考勤补登', '0', '', '', '', '$人员用户名')" ;
				  $rs = $db->Execute($sql);
				}
			
		}
		print_infor("提交成功,请返回...");
		print "<meta http-equiv=\"REFRESH\" content=\"0 URL=?\">";
		exit;
}



if($_GET['action']=='DataDeal')
	{
	$query = "delete from edu_xingzheng_kaoqinbudeng where 编号='$编号'  and 审核状态=0 ";
	//print_R($_POST);
	//print $query;exit;
	print "<BR><BR><div align=center><font color=green>你的操作已经处理!</font></div>";
	$db->Execute($query);
	//dandian_sql_log($connection,$query);
	print  "<META HTTP-EQUIV=REFRESH CONTENT='0;URL=?'>\n";
	exit;
	}


if($_GET['action2']=='DataDeal')
	{
	$query = "delete from edu_xingzheng_kaoqinbudeng where 编号='$编号'  and 审核状态=0 ";
	//print_R($_POST);
	//print $query;exit;
	print "<BR><BR><div align=center><font color=green>你的操作已经处理!</font></div>";
	$db->Execute($query);
	//dandian_sql_log($connection,$query);
	print  "<META HTTP-EQUIV=REFRESH CONTENT='0;URL=?'>\n";
	exit;
	}





if($_GET['action']=='add_default')
{

?>
<form   name=form1 action='?action=KaoQinBudeng&RUN_ID=$RUN_ID' method=post >
<table class="TableList" width="100%" style="border:0px">
    <tr class="TableData" align="right">
      <td nowrap colspan=7 align=center>
	  <input type=submit class=SmallButton value='提交'/>
	<input type="button" class="SmallButton" onclick=location='?'  value="返回">
	</td>
    </tr>
</table>
<table class="TableList" width="100%">
    <tr class="TableHeader">
      <td nowrap align="center">部门</td>
      <td nowrap align="center">班次</td>
	  <td nowrap align="center">上班时间</td>
      <td nowrap align="center">班次</td>
	  <td nowrap align="center">人员</td>
	  <td nowrap align="center">上班考勤状态</td>
      <td nowrap align="center">下班考勤状态</td>
    </tr>
<?php
  $人员 = $_SESSION['LOGIN_USER_NAME'];
  $人员用户名 = $_SESSION['LOGIN_USER_ID'];

  $开始时间 = date("Y-m-d",mktime(1,1,1,date('m'),date('d')-1,date('Y')));
  $结束时间 = date("Y-m-d",mktime(1,1,1,date('m'),date('d')+14,date('Y')));

  $query = "select 编号,星期,班次,部门,班次,日期,人员,人员用户名,上班考勤状态,下班考勤状态 from  edu_xingzheng_kaoqinmingxi  where 学期='$学期名称' and 人员用户名='$人员用户名' and 日期<='$开始时间' and (上班考勤状态='上班缺打卡' or 下班考勤状态='下班缺打卡') order by 日期,班次,部门";
  $rs=$db->CacheExecute(30,$query);
  $ROW=$rs->GetArray();
  $COUNT=sizeof($ROW);
  //$cursor = exequery($connection,$query);
  //print $query;
  //行计数器
  $LINE_COUNTER = 0;
  for($i=0;$i<sizeof($ROW);$i++) {
    $编号= $ROW[$i]["编号"];
	$部门= $ROW[$i]["部门"];
	$班次= $ROW[$i]["班次"];
	$星期= $ROW[$i]["星期"];
	$班次= $ROW[$i]["班次"];
	$人员= $ROW[$i]["人员"];
	$人员用户名= $ROW[$i]["人员用户名"];
	$上班考勤状态= $ROW[$i]["上班考勤状态"];
	$下班考勤状态= $ROW[$i]["下班考勤状态"];
	$日期= $ROW[$i]["日期"];

	//如果数据存在则进行数据编辑操作
	//$query		= "select 新人员,编号 from edu_xingzheng_paibandaike where 学期='$学期名称' and 原人员='$人员' and 上班时间='$日期' and 班次='$班次'  and 工作流ID号='$RUN_ID'";
	//$cursorX	= exequery($connection,$query);
	//$ROWX		= mysql_fetch_array($cursorX);
    //$新人员		= $ROWX["新人员"];
	//$编号		= $ROWX["编号"];

	$value = 0;
	//print_R($INITDATA_List);
	if($上班考勤状态=="上班缺打卡")	$上班补登 = "<input type=checkbox name='CHECK_1_".$LINE_COUNTER."_VALUE' checked />申请补登";
	else	$上班补登 = "<input type=checkbox name='CHECK_1_".$LINE_COUNTER."_VALUE' disabled /><font color=gray>申请补登</font>";;
	if($下班考勤状态=="下班缺打卡")	$下班补登 = "<input type=checkbox name='CHECK_2_".$LINE_COUNTER."_VALUE' checked />申请补登";
	else	$下班补登 = "<input type=checkbox name='CHECK_2_".$LINE_COUNTER."_VALUE' disabled />申请补登";
	print "
	 <tr class=\"TableData\">
   <td nowrap align=\"center\">$部门</td>
   <td nowrap align=\"center\">$班次</td>
   <td nowrap align=\"center\">$日期</td>
   <td nowrap align=\"center\">$班次</td>
   <td nowrap align=\"center\">$人员</td>
   <td nowrap align=\"center\">$上班补登</td>
   <td nowrap align=\"center\">$下班补登";

   print "<input size=6 type=hidden class=SmallInput name='".$LINE_COUNTER."_VALUE' value='1'/>";


   print "
   <input size=6  type=hidden class=SmallInput name='".$LINE_COUNTER."_ID' value='$编号'/>
   <input size=6  type=hidden class=SmallInput name='".$LINE_COUNTER."_BANJI' value='$部门'/>
   <input size=6  type=hidden class=SmallInput name='".$LINE_COUNTER."_KECHENG' value='$班次'/>
   <input size=6  type=hidden class=SmallInput name='".$LINE_COUNTER."_OLDDATE' value='$日期'/>
   <input  type=hidden   name='COUNT' value='$COUNT'/>
   <input size=6  type=hidden class=SmallInput name='".$LINE_COUNTER."_OLDTEACHER' value='$人员'/>
   </td>
	</tr>
	";
	$LINE_COUNTER++;
  }

if($LINE_COUNTER==0)	{
	$Disabled = " Disabled ";
	$Values = "提交";
}
else	{
	$Disabled = "";
	$Values = "提交";
}
?>

    <tr class="TableData" align="right">
      <td nowrap colspan=7 align=center>
	  <input type=submit class=SmallButton value='提交'/>
	<input type="button" class="SmallButton" onclick=location='?'  value="返回">
	</td>
    </tr>

</table>
<div id=HTMLSHOW></div>
</form>

<?php

exit;
}





	$filetablename='edu_xingzheng_kaoqinbudeng';
	$parse_filename = 'my_xingzheng_kaoqinbudeng';

	require_once('include.inc.php');
	require_once('../Help/module_xingzhengworkflow.php');

?>