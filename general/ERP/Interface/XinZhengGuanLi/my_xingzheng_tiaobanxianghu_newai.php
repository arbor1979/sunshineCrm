<?php
	require_once('lib.inc.php');//

	$GLOBAL_SESSION=returnsession();
$SYSTEM_PRIV_STOP = 1;
require_once("systemprivateinc.php");
//CheckSystemPrivate("人力资源-行政考勤-我的考勤");
page_css('相互调班申请');

$当前学期 = returntablefield("edu_xueqiexec","当前学期",'1',"学期名称");
if($_GET['学期']=="") $_GET['学期'] = $当前学期;

 $学期名称 = $当前学期;
	$_GET['原人员'] = $_SESSION['LOGIN_USER_NAME'];
	$_GET['原人员用户名'] = $_SESSION['LOGIN_USER_ID'];
	//$_GET['原部门'] = returntablefield("department","DEPT_ID",$_SESSION['LOGIN_DEPT_ID'],"DEPT_NAME");




if($_GET['action']=='TiaoKeDataDeal')				{
	//2009-10-19 1-2 庄惠丽 网页特效
	$原班次 = $_POST['班次'];
	$原上班时间 = $_POST['原上班时间'];
	$原上班时间Array = explode(' ',$原上班时间);
	$原上班时间 = $原上班时间Array[0];
	$原班次 = $原上班时间Array[1];
	$新上班时间 = $_POST['新上班时间'];
	$新上班时间Array = explode(' ',$新上班时间);
	$新上班时间 = $新上班时间Array[0];
	$新班次 = $新上班时间Array[1];
	$新人员 = $新上班时间Array[2];
	$新人员用户名 = $新上班时间Array[3];
	$人员 = $_SESSION['LOGIN_USER_NAME'];
	$原人员 = $_SESSION['LOGIN_USER_NAME'];
	//print_R($_POST);exit;
	//如果数据存在则进行数据编辑操作
	$query = "select 编号 from edu_xingzheng_tiaobanxianghu where 学期='$学期名称'  and 原上班时间='$原上班时间' and 原人员='$人员' and 原班次='$原班次' and 工作流ID号='$RUN_ID'";
	$rs = $db->Execute($query);
	$ROW = $rs->GetArray();
    $编号= $ROW[0]["编号"];
	if($编号!="")		{
		$query = "update edu_xingzheng_tiaobanxianghu set 新上班时间='$新上班时间',新班次='$新班次',新人员='$新人员',新班次='$新班次' where 编号='$编号'";
	}
	else	{
		$DEPT_ID = returntablefield("td_edu.user","USER_NAME",$原人员,"DEPT_ID");
		$原部门 = returntablefield("td_edu.department","DEPT_ID",$DEPT_ID,"DEPT_NAME");
		$DEPT_ID = returntablefield("td_edu.user","USER_NAME",$新人员,"DEPT_ID");
		$新部门 = returntablefield("td_edu.department","DEPT_ID",$DEPT_ID,"DEPT_NAME");
		$query = "insert into edu_xingzheng_tiaobanxianghu values('','$学期名称','$原部门','$原人员','$原上班时间','$原班次','$新部门','$新人员','$新上班时间','$新班次','0','$RUN_ID','$审核人','$审核时间','".$_SESSION['LOGIN_USER_ID']."','$新人员用户名');";
	}
	//print_R($_POST);
	//print $query;exit;
	print "<BR><BR><div align=center><font color=green>你的操作已经处理!</font></div>";
	$db->Execute($query);
	//exequery($connection,$query);
	print  "<META HTTP-EQUIV=REFRESH CONTENT='0;URL=?action=add_default&RUN_ID=$RUN_ID'>\n";
	exit;
}

if($_GET['action']=='TiaoKeDelete')				{

	$部门 = $_GET['部门'];
	$班次 = $_GET['班次'];
	$人员 = $_SESSION['LOGIN_USER_NAME'];
	//如果数据存在则进行数据编辑操作
	$query = "delete from edu_xingzheng_tiaobanxianghu where 编号='$编号' and 原班次='$班次' and 学期='$学期名称' and 审核状态='0'";
	//print_R($_POST);
	//print $query;
	print "<BR><BR><div align=center><font color=green>你的操作已经处理!</font></div>";
	$db->Execute($query);
	//exequery($connection,$query);
	print  "<META HTTP-EQUIV=REFRESH CONTENT='0;URL=?action=add_default&RUN_ID=$RUN_ID'>\n";
	exit;
}
if($_GET['action2']=='TiaoKeDelete')				{

	$部门 = $_GET['部门'];
	$班次 = $_GET['班次'];
	$人员 = $_SESSION['LOGIN_USER_NAME'];
	//如果数据存在则进行数据编辑操作
	$query = "delete from edu_xingzheng_tiaobanxianghu where 编号='$编号'  and 审核状态='0'";
	//print_R($_POST);
	//print $query;
	print "<BR><BR><div align=center><font color=green>你的操作已经处理!</font></div>";
	$db->Execute($query);
	//exequery($connection,$query);
	print  "<META HTTP-EQUIV=REFRESH CONTENT='0;URL=?RUN_ID=$RUN_ID'>\n";
	exit;
}



if($_GET['action']=='TiaoKe')				{
	$人员 = $_GET['人员'];
	$班次 = $_GET['班次'];
	$星期 = $_GET['星期'];
	$班次 = $_GET['班次'];
	$日期 = $_GET['日期'];

	$星期XNAME = array('日','一','二','三','四','五','六');

	$NewText = "";
	$日期Array = explode("-",$日期);
	//$开始时间 = date("Y-m-d",mktime(1,1,1,$日期Array[1],$日期Array[2]-1,$日期Array[0]));
	//$结束时间 = date("Y-m-d",mktime(1,1,1,$日期Array[1],$日期Array[2]+14,$日期Array[0]));
	$开始时间 = date("Y-m-d",mktime(1,1,1,date('m'),date('d')-1,date('Y')));
	$结束时间 = date("Y-m-d",mktime(1,1,1,date('m'),date('d')+14,date('Y')));

      $人员 = $_SESSION['LOGIN_USER_NAME'];
	  $开始时间 = date("Y-m-d",mktime(1,1,1,date('m'),date('d')-1,date('Y')));
	  $结束时间 = date("Y-m-d",mktime(1,1,1,date('m'),date('d')+14,date('Y')));

	  $query = "select 星期,班次,日期,人员,部门,人员用户名 from  edu_xingzheng_kaoqinmingxi  where 人员用户名!='$人员用户名' and 日期>='$开始时间' and 日期<='$结束时间' order by 日期,班次,人员用户名";
	  $rs = $db->Execute($query);
	  $ROW = $rs->GetArray();
	  //行计数器
	  $LINE_COUNTER = 0;
	  for($i=0;$i<sizeof($ROW);$i++) {
		$编号X2= $ROW[$i]["编号"];
		$部门= $ROW[$i]["部门"];
		$班次= $ROW[$i]["班次"];
		$星期= $ROW[$i]["星期"];
		$班次= $ROW[$i]["班次"];
		$人员= $ROW[$i]["人员"];
		$人员用户名= $ROW[$i]["人员用户名"];
		$日期= $ROW[$i]["日期"];
		$可用时间列表[] = $日期." 周".$星期." ".$班次." ".$人员." ".$班次;
		$可用时间列表X[] = $日期." ".$班次." ".$人员." ".$人员用户名;

	  }
	  //print_R($query);

	$QUERY_STRING = $_SERVER['QUERY_STRING'];
	$QUERY_STRING_array = explode('XXX=XXX',$QUERY_STRING);
	$QUERY_STRING = $QUERY_STRING_array[0];
	$可用人员列表 = @array_keys($人员列表);
	@sort($可用人员列表);
	//onChange=\"var jmpURL='?$QUERY_STRING&XXX=XXX&新人员=' + this.options[this.selectedIndex].value ; if(jmpURL!='') {window.location=jmpURL;} else {this.selectedIndex=0 ;}\"

	$NewText .= "<select name=新上班时间 class=SmallSelect>\n";
	for($i=0;$i<sizeof($可用时间列表);$i++)		{
		$Element = $可用时间列表[$i];
		$ElementX = $可用时间列表X[$i];
		$NewText .= "<option value='$ElementX'>$Element</option>\n";
	}
	$NewText .= "</select>\n";
	print "<form name=form1 action='?action=TiaoKeDataDeal&RUN_ID=$RUN_ID' method=post>
	<table class=\"TableBlock\" width=\"100%\">
      <tr class=\"TableHeader\"><td nowrap align=left colspan=2>人员申请相互调班(系统会自动显示当前部门在未来十四天内可排班时间段)</td></tr>
	  <tr class=\"TableData\"><td nowrap align=center>部门:</td><td nowrap align=center>".$_GET['部门']."</td></tr>
      <tr class=\"TableData\"><td nowrap align=center>人员:</td><td nowrap align=center>".$人员."</td></tr>
	  <tr class=\"TableData\"><td nowrap align=center>原上班时间:</td><td nowrap align=center>".$_GET['日期']."&nbsp;&nbsp;".$_GET['班次']."节</td></tr>
	  <tr class=\"TableData\"><td nowrap align=center>相互调班信息:</td><td nowrap align=center>$NewText</td></tr>
	  <tr class=\"TableData\"><td nowrap align=center colspan=2><input type=submit class=SmallButton value='提交'/> <input type=button class=SmallButton onclick=location='?action=add_default' value='返回'/></td></tr>
	  <input type=hidden name=部门 value='".$_GET['部门']."'/>
	  <input type=hidden name=班次 value='".$_GET['班次']."'/>
	  <input type=hidden name=原上班时间 value='".$_GET['日期']." ".$_GET['班次']." $人员'/>
	  <input type=hidden name=人员 value='$人员'/>

    ";
	print "</table></form>";
	exit;
}






	if($_GET['action']=="add_default")
	{
	 //print_R($_GET);
	 ?>



<form name=form1>
<table class="TableList" width="100%" style="border:0px">
    <tr class="TableData" align="right">
     <td nowrap colspan=7 align=center>
	  <input type="button" class="SmallButton" onclick=location='?'  value="返回">
	</td>
    </tr>
</table>
<table class="TableList" width="100%">
    <tr class="TableHeader">
      <td nowrap align="center">原人员</td>
	  <td nowrap align="center">原上班时间</td>
      <td nowrap align="center">原班次</td>
	  <td nowrap align="center">新人员</td>
	  <td nowrap align="center">新上班时间</td>
	  <td nowrap align="center">新班次</td>
      <td nowrap align="center">操作</td>
    </tr>
<?php
  $人员 = $_SESSION['LOGIN_USER_NAME'];
  $人员用户名 = $_SESSION['LOGIN_USER_ID'];

  $开始时间 = date("Y-m-d",mktime(1,1,1,date('m'),date('d')-1,date('Y')));
  $结束时间 = date("Y-m-d",mktime(1,1,1,date('m'),date('d')+14,date('Y')));

  $query = "select 星期,班次,部门,班次,日期,编号 from  edu_xingzheng_kaoqinmingxi  where 人员用户名='$人员用户名' and 日期>='$开始时间' and 日期<='$结束时间' order by 日期,班次,部门";

   // $cursor = exequery($connection,$query);
  //行计数器
  //$LINE_COUNTER = 0;
  //while($ROW = mysql_fetch_array($cursor)) {
  $rs = $db->CacheExecute(30,$query);
  $ROW=$rs->GetArray();
  //行计数器
  $LINE_COUNTER = 0;
  //print_R(sizeof($ROW));
  for($i=0;$i<sizeof($ROW);$i++) {
	//  print $i;
    $编号X= $ROW[$i]["编号"];
	$部门= $ROW[$i]["部门"];
	$班次= $ROW[$i]["班次"];
	$星期= $ROW[$i]["星期"];
	$班次= $ROW[$i]["班次"];
	$日期= $ROW[$i]["日期"];


	//如果数据存在则进行数据编辑操作
	$query = "select * from edu_xingzheng_tiaobanxianghu where 学期='$学期名称' and 原人员用户名='$人员用户名' and 原上班时间='$日期' and 原班次='$班次'  and 审核状态='0'  and 工作流ID号='$RUN_ID'";
	$rs=$db->Execute($query);
	$ROWX=$rs->GetArray();
	//cursorX = exequery($connection,$query);
	//$ROWX	 = mysql_fetch_array($cursorX);
	//print_R($query);
    $新上班时间	= $ROWX[0]["新上班时间"];
	$新人员		= $ROWX[0]["新人员"];
	$新人员用户名		= $ROWX[0]["新人员用户名"];
	$新班次		= $ROWX[0]["新班次"];
	$原上班时间	= $ROWX[0]["原上班时间"];
	$原人员		= $ROWX[0]["原人员"];
	$原人员用户名		= $ROWX[0]["原人员用户名"];
	$原班次		= $ROWX[0]["原班次"];
	$编号		= $ROWX[0]["编号"];

	//得到替换后人员考勤的ID值
	if($新人员!="")			{
		$query = "select 编号 from  edu_xingzheng_kaoqinmingxi  where 学期='$学期名称' and 人员用户名='$新人员用户名' and 日期='$新上班时间' and 班次='$新班次' and 班次='$新班次'";
		$cursorXX = $db->Execute($query);
		$ROWXX	 = $rs->GetArray();
		$编号X2	= $ROWXX[0]["编号"];
		//print $编号X2;
		//print $query;//exit;
	}else	{
		$编号X2 = "";
	}
	$value = 0;
	//print_R($INITDATA_List);
	print "
	 <tr class=\"TableData\">
   <td nowrap align=\"center\">$人员</td>
   <td nowrap align=\"center\">$日期</td>
   <td nowrap align=\"center\">$班次</td>
   <td nowrap align=\"center\"><font color=red>$新人员</font></td>
   <td nowrap align=\"center\"><font color=red>$新上班时间</font></td>
   <td nowrap align=\"center\"><font color=red>$新班次</font></td>
   <td nowrap align=\"center\">";
   print "<input size=6 type=hidden class=SmallInput name='NAME_".$LINE_COUNTER."_VALUE' value='1'/>";
   print "<a href=\"?action=TiaoKe&RUN_ID=$RUN_ID&班次=$班次&星期=$星期&班次=$班次&日期=$日期&部门=$部门\" >进行相互调班</a>";


   if($新上班时间!="")		print "&nbsp;<a href=\"?action=TiaoKeDelete&RUN_ID=$RUN_ID&班次=$班次&星期=$星期&班次=$班次&日期=$日期&编号=$编号\" >删除</a>";
   print "
   <input size=6  type=hidden class=SmallInput name='NAME_".$LINE_COUNTER."_ID' value='$编号'/>
   <input size=6  type=hidden class=SmallInput name='NAME_".$LINE_COUNTER."_BANJI' value='$部门'/>
   <input size=6  type=hidden class=SmallInput name='NAME_".$LINE_COUNTER."_KECHENG' value='$班次'/>
   <input size=6  type=hidden class=SmallInput name='NAME_".$LINE_COUNTER."_OLDTEACHER' value='$原人员'/>
   <input size=6  type=hidden class=SmallInput name='NAME_".$LINE_COUNTER."_OLDCOURSE' value='$原班次'/>
   <input size=6  type=hidden class=SmallInput name='NAME_".$LINE_COUNTER."_NEWTEACHER' value='$新人员'/>
   <input size=6  type=hidden class=SmallInput name='NAME_".$LINE_COUNTER."_NEWCOURSE' value='$新班次'/>
   <input size=6  type=hidden class=SmallInput name='NAME_".$LINE_COUNTER."_OLDDATE' value='$日期'/>
   <input size=6  type=hidden class=SmallInput name='NAME_".$LINE_COUNTER."_OLDJIECI' value='$班次'/>
   <input size=6  type=hidden class=SmallInput name='NAME_".$LINE_COUNTER."_NEWDATE' value='$新上班时间'/>
   <input size=6  type=hidden class=SmallInput name='NAME_".$LINE_COUNTER."_NEWJIECI' value='$新班次'/>
   <input size=6  type=hidden class=SmallInput name='NAME_".$LINE_COUNTER."_KQOQINID' value='$编号X'/>
   <input size=6  type=hidden class=SmallInput name='NAME_".$LINE_COUNTER."_KQOQINID2' value='$编号X2'/>
   </td>
	</tr>
	";
	$LINE_COUNTER++;
  }

?>

    <tr class="TableData" align="right">
      <td nowrap colspan=7 align=center>
	  <input type="button" class="SmallButton" onclick=location='?'  value="返回">
	</td>
    </tr>

</table>
<div id=HTMLSHOW></div>
</form>


	 <?php
	 exit;
	}

	$filetablename='edu_xingzheng_tiaobanxianghu';
	$parse_filename = 'my_xingzheng_tiaobanxianghu';

	require_once('include.inc.php');
	require_once('../Help/module_xingzhengworkflow.php');

?>