<?php
	require_once('lib.inc.php');//

	$GLOBAL_SESSION=returnsession();
$SYSTEM_PRIV_STOP = 1;
require_once("systemprivateinc.php");
//CheckSystemPrivate("人力资源-行政考勤-我的考勤");
page_css('调班申请');
$当前学期 = returntablefield("edu_xueqiexec","当前学期",'1',"学期名称");
if($_GET['学期']=="") $_GET['学期'] = $当前学期;
 $学期名称 = $当前学期;

	$_GET['人员'] = $_SESSION['LOGIN_USER_NAME'];
	$_GET['人员用户名'] = $_SESSION['LOGIN_USER_ID'];
	//$_GET['部门'] = returntablefield("department","DEPT_ID",$_SESSION['LOGIN_DEPT_ID'],"DEPT_NAME");


if($_GET['action']=='TiaoBanDelete')				{

	$人员 = $_GET['人员'];
	$班次 = $_GET['班次'];
	$人员 = $_SESSION['LOGIN_USER_NAME'];
	//如果数据存在则进行数据编辑操作
	$query = "delete from edu_xingzheng_tiaoban where 编号='$编号' and 原班次='$班次' and 学期='$学期名称' and 审核状态='0'";
	//print_R($_POST);
	//print $query;
	print "<BR><BR><div align=center><font color=green>你的操作已经处理!</font></div>";
	$db->Execute($query);
	//exequery($connection,$query);
	print  "<META HTTP-EQUIV=REFRESH CONTENT='0;URL=?action=add_default&RUN_ID=$RUN_ID'>\n";
	exit;
}
if($_GET['action2']=='TiaoBanDelete')				{

	$人员 = $_GET['人员'];
	$班次 = $_GET['班次'];
	$人员 = $_SESSION['LOGIN_USER_NAME'];
	//如果数据存在则进行数据编辑操作
	$query = "delete from edu_xingzheng_tiaoban where 编号='$编号'  and 审核状态='0'";
	//print_R($_POST);
	//print $query;
	print "<BR><BR><div align=center><font color=green>你的操作已经处理!</font></div>";
	$db->Execute($query);
	//exequery($connection,$query);
	print  "<META HTTP-EQUIV=REFRESH CONTENT='0;URL=?RUN_ID=$RUN_ID'>\n";
	exit;
}


if($_GET['action']=='TiaoBanDataDeal')				{

	$班次 = $_POST['班次'];
	$原上班时间 = $_POST['原上班时间'];
	$原上班时间Array = explode(' ',$原上班时间);
	$原上班时间 = $原上班时间Array[0];
	$原班次 = $原上班时间Array[1];
	$新上班时间 = $_POST['新上班时间'];
	$新上班时间Array = explode(' ',$新上班时间);
	$新上班时间 = $新上班时间Array[0];
	$新班次 = $新上班时间Array[1];
	$人员 = $_SESSION['LOGIN_USER_NAME'];
	//如果数据存在则进行数据编辑操作

	$query = "select 编号 from edu_xingzheng_tiaoban where 学期='$学期名称' and 人员='$人员' and 原上班时间='$原上班时间' and 原班次='$原班次' and 工作流ID号='$RUN_ID'";
	$rs=$db->Execute($query);
	$ROW=$rs->GetArray();
	//$cursor = exequery($connection,$query);
	//$ROW = mysql_fetch_array($cursor);
    $编号= $ROW[0]["编号"];
	if($编号!="")		{
		$query = "update edu_xingzheng_tiaoban set 新上班时间='$新上班时间',新班次='$新班次' where 编号='$编号'";
	}
	else	{
		$DEPT_ID = returntablefield("td_edu.user","USER_NAME",$人员,"DEPT_ID");
		$部门 = returntablefield("td_edu.department","DEPT_ID",$DEPT_ID,"DEPT_NAME");
		$query = "insert into edu_xingzheng_tiaoban values('','$学期名称','$部门','$人员','$原上班时间','$原班次','$新上班时间','$新班次','0','$RUN_ID','$审核人','$审核时间','".$_SESSION['LOGIN_USER_ID']."');";
	}
	//print_R($_POST);
	//print $query;exit;
	print "<BR><BR><div align=center><font color=green>你的操作已经处理!</font></div>";
	$db->Execute($query);
	//exequery($connection,$query);
	print  "<META HTTP-EQUIV=REFRESH CONTENT='0;URL=?action=add_default&RUN_ID=$RUN_ID'>\n";
	exit;
}



if($_GET['action']=='TiaoBan')				{
	$班次 = $_GET['班次'];
	$星期 = $_GET['星期'];
	$班次 = $_GET['班次'];
	$日期 = $_GET['日期'];
	$人员用户名 = $_SESSION['LOGIN_USER_ID'];

	$星期XNAME = array('日','一','二','三','四','五','六');

	$NewText = "";
	$日期Array = explode("-",$日期);
	//$开始时间 = date("Y-m-d",mktime(1,1,1,$日期Array[1],$日期Array[2]-1,$日期Array[0]));
	//$结束时间 = date("Y-m-d",mktime(1,1,1,$日期Array[1],$日期Array[2]+14,$日期Array[0]));
	$开始时间 = date("Y-m-d",mktime(1,1,1,date('m'),date('d')-1,date('Y')));
	$结束时间 = date("Y-m-d",mktime(1,1,1,date('m'),date('d')+14,date('Y')));
	$sql = "select 班次名称 from edu_xingzheng_banci";
	//$cursor = exequery($connection,$sql);
	//while($ROW = mysql_fetch_array($cursor))			{
	$rs = $db->CacheExecute(30,$sql);
	$ROW= $rs->GetArray();
	for($i=0;$i<sizeof($ROW);$i++)			{
		$班次数组[]= $ROW[$i]["班次名称"];
	}
	//对未来十四天之内可以使用的时间段进行统计和分析
	for($i=-1;$i<14;$i++)		{
		$星期X = date("w",mktime(1,1,1,date('m'),date('d')+$i,date('Y')));
		$当天X = date("Y-m-d",mktime(1,1,1,date('m'),date('d')+$i,date('Y')));
		$returnCurWeekIndex = returnCurWeekIndex($当天X);
		$query = "select 班次名称 AS 班次,排班人员 AS 人员 from edu_xingzheng_paiban where (排班人员 like '%,$人员用户名,%' or 排班人员 like '$人员用户名,%') and 学期名称='$学期名称' and 考勤日期='$当天X'";
		//$cursor = exequery($connection,$query);
		$rs=$db->Execute($query);
		$ROW=$rs->GetArray();
		$班次Array = array();
		for($n=0;$n<sizeof($ROW);$n++) {
			$班次X= $ROW[$n]["班次"];
			$人员= $ROW[$n]["人员"];
			$班次Array[$班次X] = $ROW[$n]["班次"];
		}
		//print_R($班次Array);
		for($X=0;$X<sizeof($班次数组);$X=$X+1)		{
			$班次TEMP = $班次数组[$X];;
			if($班次Array[$班次TEMP]=="")		{
				$可用时间列表[] = $当天X." 周".$星期XNAME[$星期X]." ".$班次TEMP."";
				$可用时间列表X[] = $当天X." ".$班次TEMP."";
			}
		}
	}

	//print_R($班次数组);

	$NewText .= "<select name=新上班时间 class=SmallSelect>";
	for($i=0;$i<sizeof($可用时间列表);$i++)		{
		$Element = $可用时间列表[$i];
		$ElementX = $可用时间列表X[$i];
		$NewText .= "<option value='$ElementX'>$Element</option>";
	}
	$NewText .= "</select>";
	print "<form name=form1 action='?action=TiaoBanDataDeal&RUN_ID=$RUN_ID' method=post >
	<table class=\"TableBlock\" width=\"100%\">
      <tr class=\"TableHeader\"><td nowrap align=left colspan=2>人员申请调班(系统会自动显示出该人员在未来十四天内可排班时间段)</td></tr>
	  <tr class=\"TableData\"><td nowrap align=center>人员:</td><td nowrap align=center>".$_GET['人员']."</td></tr>
      <tr class=\"TableData\"><td nowrap align=center>班次:</td><td nowrap align=center>".$_GET['班次']."</td></tr>
	  <tr class=\"TableData\"><td nowrap align=center>原上班时间:</td><td nowrap align=center>".$_GET['日期']."&nbsp;&nbsp;".$_GET['班次']."节</td></tr>
	  <tr class=\"TableData\"><td nowrap align=center>新上班时间:</td><td nowrap align=center>$NewText</td></tr>
	  <tr class=\"TableData\"><td nowrap align=center colspan=2><input type=submit class=SmallButton value='提交'/>&nbsp;<input type=\"button\" class=\"SmallButton\" onclick= \"location='?'\" value=\"返回\"></td></tr>
	  <input type=hidden name=人员 value='$人员'/>
	  <input type=hidden name=班次 value='".$_GET['班次']."'/>
	  <input type=hidden name=原上班时间 value='".$_GET['日期']." ".$_GET['班次']."'/>
	  <input type=hidden name=人员 value='$人员'/>

    ";
	print "</table></form>";
	exit;
}


if($_GET['action']=='add_default')
{
	?>

<form name=form1>
<table class="TableList" width="100%" style="border:0px">
<tr class="TableData" align="right">
      <td nowrap colspan=7 align=center>
	  	  <input type="button" class="SmallButton" onclick= "location='?'" value="返回">
	</td>
    </tr>
</table>
<table class="TableList" width="100%">
    <tr class="TableHeader">
      <td nowrap align="center">人员</td>
      <td nowrap align="center">班次</td>
	  <td nowrap align="center">原上班时间</td>
      <td nowrap align="center">原班次</td>
	  <td nowrap align="center">新上班时间</td>
	  <td nowrap align="center">新班次</td>
      <td nowrap align="center">操作</td>
    </tr>
<?php
  $人员 = $_SESSION['LOGIN_USER_NAME'];

  $开始时间 = date("Y-m-d",mktime(1,1,1,date('m'),date('d')-1,date('Y')));
  $结束时间 = date("Y-m-d",mktime(1,1,1,date('m'),date('d')+14,date('Y')));

  $query = "select 星期,班次,人员,班次,日期 from  edu_xingzheng_kaoqinmingxi  where 人员='$人员' and 日期>='$开始时间' and 日期<='$结束时间' order by 日期,班次,人员";
    //$cursor = exequery($connection,$query);
 // while($ROW = mysql_fetch_array($cursor)) {
  $rs = $db->CaCheExecute(30,$query);
  $ROW=$rs->GetArray();
  //行计数器
  $LINE_COUNTER = 0;
  for($i=0;$i<sizeof($ROW);$i++) {
    $编号= $ROW[$i]["编号"];
	$人员= $ROW[$i]["人员"];
	$班次= $ROW[$i]["班次"];
	$星期= $ROW[$i]["星期"];
	$班次= $ROW[$i]["班次"];
	$日期= $ROW[$i]["日期"];


	//如果数据存在则进行数据编辑操作
	$query = "select 新上班时间,新班次,编号 from edu_xingzheng_tiaoban where 学期='$学期名称' and 人员='$人员' and 原上班时间='$日期' and 原班次='$班次'  and 工作流ID号='$RUN_ID'";
	$rs = $db->Execute($query);
	$ROWX = $rs->GetArray();
	//	$cursorX = exequery($connection,$query);
	//$ROWX	 = mysql_fetch_array($cursorX);
    $新上班时间	= $ROWX[0]["新上班时间"];
	$新班次		= $ROWX[0]["新班次"];
	$编号		= $ROWX[0]["编号"];

	$value = 0;
	//print_R($INITDATA_List);
	print "
	 <tr class=\"TableData\">
   <td nowrap align=\"center\">$人员</td>
   <td nowrap align=\"center\">$班次</td>
   <td nowrap align=\"center\">$日期</td>
   <td nowrap align=\"center\">$班次</td>
   <td nowrap align=\"center\"><font color=red>$新上班时间</font></td>
   <td nowrap align=\"center\"><font color=red>$新班次</font></td>
   <td nowrap align=\"center\">";
   print "<input size=6 type=hidden class=SmallInput name='NAME_".$LINE_COUNTER."_VALUE' value='1'/>";
   print "<a href=\"?action=TiaoBan&RUN_ID=$RUN_ID&人员=$人员&星期=$星期&班次=$班次&日期=$日期\" >进行调班</a>";

   if($新上班时间!="")		print "&nbsp;<a href=\"?action=TiaoBanDelete&RUN_ID=$RUN_ID&人员=$人员&星期=$星期&班次=$班次&日期=$日期&编号=$编号\" >删除</a>";
   print "
   <input size=6  type=hidden class=SmallInput name='NAME_".$LINE_COUNTER."_ID' value='$编号'/>
   <input size=6  type=hidden class=SmallInput name='NAME_".$LINE_COUNTER."_BANJI' value='$人员'/>
   <input size=6  type=hidden class=SmallInput name='NAME_".$LINE_COUNTER."_KECHENG' value='$班次'/>
   <input size=6  type=hidden class=SmallInput name='NAME_".$LINE_COUNTER."_OLDDATE' value='$日期'/>
   <input size=6  type=hidden class=SmallInput name='NAME_".$LINE_COUNTER."_OLDJIECI' value='$班次'/>
   <input size=6  type=hidden class=SmallInput name='NAME_".$LINE_COUNTER."_NEWDATE' value='$新上班时间'/>
   <input size=6  type=hidden class=SmallInput name='NAME_".$LINE_COUNTER."_NEWJIECI' value='$新班次'/>
   </td>
	</tr>
	";
	$LINE_COUNTER++;
  }


if($LINE_COUNTER==0)	{
	$Disabled = " Disabled ";
}
else	{
	$Disabled = "";
}
?>

    <tr class="TableData" align="right">
      <td nowrap colspan=7 align=center>
	  	  <input type="button" class="SmallButton" onclick= "location='?'" value="返回">
	</td>
    </tr>

</table>
<div id=HTMLSHOW></div>
</form>

	<?php
exit;
}








	$filetablename='edu_xingzheng_tiaoban';
	$parse_filename = 'my_xingzheng_tiaoban';

	require_once('include.inc.php');
	require_once('../Help/module_xingzhengworkflow.php');

?>