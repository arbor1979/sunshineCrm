<?php
	require_once('lib.inc.php');//

	$GLOBAL_SESSION=returnsession();
$SYSTEM_PRIV_STOP = 1;
require_once("systemprivateinc.php");
//CheckSystemPrivate("人力资源-行政考勤-我的考勤");
page_css('加班补休');

$当前学期 = returntablefield("edu_xueqiexec","当前学期",'1',"学期名称");
if($_GET['学期']=="") $_GET['学期'] = $当前学期;
$学期名称 = $当前学期;
$人员用户名 = $_SESSION['LOGIN_USER_ID'];


	$_GET['人员'] = $_SESSION['LOGIN_USER_NAME'];
	$_GET['人员用户名'] = $_SESSION['LOGIN_USER_ID'];
	//$_GET['部门'] = returntablefield("department","DEPT_ID",$_SESSION['LOGIN_DEPT_ID'],"DEPT_NAME");
	$filetablename='edu_xingzheng_jiabanbuxiu';
	$parse_filename = 'my_xingzheng_jiabanbuxiu';


//======================================补休=================================================

if($_GET['action']=='BuXiuDelete')				{

	$部门 = $_GET['部门'];
	$班次 = $_GET['班次'];
	$人员 = $_SESSION['LOGIN_USER_NAME'];
	//如果数据存在则进行数据编辑操作
	//$query = "delete from edu_xingzheng_jiabanbuxiu where 编号='$编号' and 班次='$班次' and 学期='$学期名称' and 加班审核状态='0'";
	$编号 = $_GET['编号'];
	$query = "update edu_xingzheng_jiabanbuxiu set 补休时间='0000-00-00' where 编号='$编号'";
	//print_R($_POST);
	//print $query;
	print "<BR><BR><div align=center><font color=green>你的操作已经处理!</font></div>";
	$db->Execute($query);
	//exequery($connection,$query);
	print  "<META HTTP-EQUIV=REFRESH CONTENT='0;URL=?action=buxiuaction&RUN_ID=$RUN_ID'>\n";
	exit;
}

if($_GET['action']=='BuXiu')				{
  $星期XNAME = array('日','一','二','三','四','五','六');
  $开始时间 = date("Y-m-d",mktime(1,1,1,date('m'),date('d')-1,date('Y')));
  $结束时间 = date("Y-m-d",mktime(1,1,1,date('m'),date('d')+14,date('Y')));
  $班次= $_GET["班次"];
  // and 班次='$班次'
  $query = "select 星期,班次,部门,班次,日期,人员,编号 from  edu_xingzheng_kaoqinmingxi  where 人员用户名='$人员用户名' and 日期>='$开始时间' and 日期<='$结束时间' order by 日期,班次,部门";
  //print_R($query);
  	$rs=$db->CaCheExeCute(30,$query);
	$ROW=$rs->GetArray();

  //$cursor = exequery($connection,$query);
  //行计数器
  $LINE_COUNTER = 0;
 for($i=0;$i<sizeof($ROW);$i++) {
	   //while($ROW = mysql_fetch_array($cursor)) {
	$部门= $ROW[$i]["部门"];
	$班次= $ROW[$i]["班次"];
	$星期= $ROW[$i]["星期"];
	$班次= $ROW[$i]["班次"];
	$人员= $ROW[$i]["人员"];
	$日期= $ROW[$i]["日期"];
	$可用时间列表[] = $日期." 周".$星期XNAME[$星期]." ".$班次."";
	$可用时间列表X[] = $日期." ".$班次."";
	$LINE_COUNTER++;
  }

	$NewText .= "<select name=补休时间 class=SmallSelect>";
	for($i=0;$i<sizeof($可用时间列表);$i++)		{
		$Element = $可用时间列表[$i];
		$ElementX = $可用时间列表X[$i];
		$NewText .= "<option value='$ElementX'>$Element</option>";
	}
	$NewText .= "</select>";
	print "<form name=form1 action='?action=BuXiuDataDeal&RUN_ID=$RUN_ID' method=post>
	<table class=\"TableBlock\" width=\"100%\">
      <tr class=\"TableHeader\"><td nowrap align=left colspan=2>人员申请补休(系统会自动显示出该部门在未来十四天内可排班时间段)</td></tr>
	  <tr class=\"TableData\"><td nowrap align=center>部门:</td><td nowrap align=center>".$_GET['部门']."</td></tr>
      <tr class=\"TableData\"><td nowrap align=center>人员:</td><td nowrap align=center>".$_GET['人员']."</td></tr>
	  <tr class=\"TableData\"><td nowrap align=center>加班时间:</td><td nowrap align=center>".$_GET['日期']."&nbsp;&nbsp;".$_GET['班次']."</td></tr>
	  <tr class=\"TableData\"><td nowrap align=center>补休时间:</td><td nowrap align=center>$NewText</td></tr>
	  <tr class=\"TableData\"><td nowrap align=center colspan=2><input type=submit class=SmallButton value='提交'/></td></tr>
	  <input type=hidden name=部门 value='$部门'/>
	  <input type=hidden name=编号 value='".$_GET['编号']."'/>
	  <input type=hidden name=班次 value='".$_GET['班次']."'/>
	  <input type=hidden name=加班时间 value='".$_GET['日期']." ".$_GET['班次']."'/>
	  <input type=hidden name=人员 value='$人员'/>

    ";
	print "</table></form>";
	exit;
}

if($_GET['action']=='BuXiuDataDeal')				{

	$补休时间Array = explode(' ',$_POST['补休时间']);
	$补休时间 = $补休时间Array[0];
	$补休班次 = $补休时间Array[1];
	$编号 = $_POST['编号'];

	$query = "update edu_xingzheng_jiabanbuxiu set 补休时间='$补休时间',补休班次='$补休班次',补休工作流ID号='$RUN_ID' where 编号='$编号'";
	//print_R($_POST);
	//print $query;exit;
	print "<BR><BR><div align=center><font color=green>你的操作已经处理!</font></div>";
	$db->Execute($query);
	//exequery($connection,$query);
	print  "<META HTTP-EQUIV=REFRESH CONTENT='0;URL=?RUN_ID=$RUN_ID'>\n";
	exit;
}


if($_GET['action']=='buxiuaction')
{
	?>


<form name=form1>
<table class="TableList" width="100%" style="border:0px">
    <tr class="TableData">
			<td nowrap align=center colspan=8>

			<input type=button accesskey='c' name='cancel' value=' 返回 ' class=SmallButton onClick="location='?'">
			</td>
		</tr>
</table>
<table class="TableList" width="100%">
    <tr class="TableHeader">
      <td nowrap align="center">部门</td>
      <td nowrap align="center">人员</td>
	  <td nowrap align="center">加班时间</td>
      <td nowrap align="center">加班班次</td>
	  <td nowrap align="center">补休时间</td>
      <td nowrap align="center">补休班次</td>
      <td nowrap align="center">操作</td>
    </tr>
<?php
  $人员 = $_SESSION['LOGIN_USER_NAME'];

  //print_R($_SESSION);
  $开始时间 = date("Y-m-d",mktime(1,1,1,date('m'),date('d')-1,date('Y')));
  $结束时间 = date("Y-m-d",mktime(1,1,1,date('m'),date('d')+14,date('Y')));

  //$query = "select 星期,班次,部门,班次,日期,人员 from  edu_xingzheng_kaoqinmingxi  where 人员='$人员' and 日期>='$开始时间' and 日期<='$结束时间' order by 日期,班次,部门";
  //$cursor = exequery($connection,$query);
  //$人员 = $_GET['人员'];
  //如果数据存在则进行数据编辑操作
  $query = "select * from edu_xingzheng_jiabanbuxiu where 学期='$学期名称' and 人员='$人员' and 加班审核状态='1' and 补休审核状态='0'";
  //print $query;
  //$cursor = exequery($connection,$query);
	$rs=$db->ExeCute($query);
	//$rs=$db->CaCheExeCute(30,$query);
	$ROW=$rs->GetArray();
  //行计数器
  $LINE_COUNTER = 0;
  for($i=0;$i<sizeof($ROW);$i++) {
	  //while($ROW = mysql_fetch_array($cursor)) {
    $编号= $ROW[$i]["编号"];
	$部门= $ROW[$i]["部门"];
	$星期= $ROW[$i]["星期"];
	$人员= $ROW[$i]["人员"];
	$加班时间= $ROW[$i]["加班时间"];
	$加班班次= $ROW[$i]["加班班次"];

	$补休时间= $ROW[$i]["补休时间"]; if($补休时间=='0000-00-00') $补休时间='';
	$补休班次= $ROW[$i]["补休班次"];

	$日期 = $加班时间;
	$value = 0;
	//print_R($INITDATA_List);
	print "
	 <tr class=\"TableData\">
   <td nowrap align=\"center\">$部门</td>
   <td nowrap align=\"center\">$人员</td>
   <td nowrap align=\"center\">$加班时间</td>
   <td nowrap align=\"center\">$加班班次</td>
   <td nowrap align=\"center\">$补休时间</td>
   <td nowrap align=\"center\">$补休班次</td>
   <td nowrap align=\"center\">";
   print "<input size=6 type=hidden class=SmallInput name='NAME_".$LINE_COUNTER."_VALUE' value='1'/>";
   if($补休时间!="")	{
	   print "&nbsp;已申请 <a href=\"?action=BuXiuDelete&RUN_ID=$RUN_ID&人员=$人员&部门=$部门&星期=$星期&班次=$加班班次&日期=$加班时间&编号=$编号\" >删除</a>";
	   //$补休时间 = $日期;
   }
   else		{
	   print "<a href=\"?action=BuXiu&RUN_ID=$RUN_ID&人员=$人员&部门=$部门&星期=$星期&班次=$加班班次&日期=$加班时间&编号=$编号\" >申请补休</a>";
	   $补休时间 = '';
   }

   print "
   <input size=6  type=hidden class=SmallInput name='NAME_".$LINE_COUNTER."_ID' value='$编号'/>
   <input size=6  type=hidden class=SmallInput name='NAME_".$LINE_COUNTER."_BANJI' value='$部门'/>
   <input size=6  type=hidden class=SmallInput name='NAME_".$LINE_COUNTER."_KECHENG' value='$人员'/>
   <input size=6  type=hidden class=SmallInput name='NAME_".$LINE_COUNTER."_OLDDATE' value='$加班时间'/>
   <input size=6  type=hidden class=SmallInput name='NAME_".$LINE_COUNTER."_OLDJIECI' value='$加班班次'/>
   <input size=6  type=hidden class=SmallInput name='NAME_".$LINE_COUNTER."_NEWDATE' value='$补休时间'/>
   <input size=6  type=hidden class=SmallInput name='NAME_".$LINE_COUNTER."_NEWJIECI' value='$补休班次'/>
   </td>
	</tr>
	";
	$LINE_COUNTER++;
  }



?>

    <tr class="TableData">
			<td nowrap align=center colspan=8>

			<input type=button accesskey='c' name='cancel' value=' 返回 ' class=SmallButton onClick="location='?'">
			</td>
		</tr>

</table>
<div id=HTMLSHOW></div>
</form>
	<?php
	exit;
}












//======================================加班===================================================

if($_GET['action']=='JiaBanDataDeal')				{
	//print_R($_GET);
	$部门 = $_GET['部门'];
	$班次 = $_GET['班次'];
	$加班时间 = $_GET['日期'];
	$加班班次 = $_GET['班次'];
	$人员 = $_GET['人员'];
	$补休班次 = $加班班次;
	//$query = "select 编号 from edu_xingzheng_jiabanbuxiu where 学期='$学期名称' and 人员='$人员' and 加班时间='$加班时间' and 加班班次='$加班班次' and 加班工作流ID号='$RUN_ID'";
	//$cursor = exequery($connection,$query);
	//$ROW = mysql_fetch_array($cursor);
    //$编号= $ROW["编号"];
	$DEPT_ID = returntablefield("td_edu.user","USER_NAME",$人员,"DEPT_ID");
	$部门 = returntablefield("td_edu.department","DEPT_ID",$DEPT_ID,"DEPT_NAME");
	$query = "insert into edu_xingzheng_jiabanbuxiu values('','$学期名称','$部门','$人员','$加班时间','$加班班次','$补休时间','$补休班次','0','$RUN_ID','$审核人','$审核时间','0','','','','".$_SESSION['LOGIN_USER_ID']."');";
	//print_R($_POST);
	//print $query;exit;
	print "<BR><BR><div align=center><font color=green>你的操作已经处理!</font></div>";
	//exequery($connection,$query);
	$db->Execute($query);
	print  "<META HTTP-EQUIV=REFRESH CONTENT='0;URL=?action=add_default&RUN_ID=$RUN_ID'>\n";
	exit;
}

if($_GET['action']=='JiaBanDelete')				{

	$部门 = $_GET['部门'];
	$班次 = $_GET['班次'];
	$人员 = $_SESSION['LOGIN_USER_NAME'];
	//如果数据存在则进行数据编辑操作
	$query = "delete from edu_xingzheng_jiabanbuxiu where 编号='$编号' and 加班班次='$班次' and 学期='$学期名称' and 人员='$人员' and 加班审核状态='0' and 加班工作流ID号='$RUN_ID' ";
	//print_R($_POST);
	//print $query;
	print "<BR><BR><div align=center><font color=green>你的操作已经处理!</font></div>";
	$db->Execute($query);
	//exequery($connection,$query);
	print  "<META HTTP-EQUIV=REFRESH CONTENT='0;URL=?action=add_default&RUN_ID=$RUN_ID'>\n";
	exit;
}
if($_GET['action2']=='JiaBanDelete')				{

	$部门 = $_GET['部门'];
	$班次 = $_GET['班次'];
	$人员 = $_SESSION['LOGIN_USER_NAME'];
	//如果数据存在则进行数据编辑操作
	$query = "delete from edu_xingzheng_jiabanbuxiu where 编号='$编号'  ";
	//print_R($_POST);
	//print $query;exit;
	print "<BR><BR><div align=center><font color=green>你的操作已经处理!</font></div>";
	$db->Execute($query);
	//exequery($connection,$query);
	print  "<META HTTP-EQUIV=REFRESH CONTENT='0;URL=?RUN_ID=$RUN_ID'>\n";
	exit;
}





if($_GET['action']=='add_default')
{
?>

<form name=form1>
<table class="TableList" width="100%" style="border:0px">
		<tr class="TableData">
			<td nowrap align=center colspan=8>

			<input type=button accesskey='c' name='cancel' value=' 返回 ' class=SmallButton onClick="location='?'">
			</td>
		</tr>
</table>
<table class="TableList" width="100%">
    <tr class="TableHeader">
      <td nowrap align="center">人员</td>
	  <td nowrap align="center">加班时间</td>
      <td nowrap align="center">加班班次</td>
      <td nowrap align="center">操作</td>
    </tr>
<?php
  $人员 = $_SESSION['LOGIN_USER_NAME'];
  $人员用户名 = $_SESSION['LOGIN_USER_ID'];

  $开始时间 = date("Y-m-d",mktime(1,1,1,date('m'),date('d')-1,date('Y')));
  $结束时间 = date("Y-m-d",mktime(1,1,1,date('m'),date('d')+14,date('Y')));


  $开始时间 = date("Y-m-d",mktime(1,1,1,date('m'),date('d')-1,date('Y')));
	$结束时间 = date("Y-m-d",mktime(1,1,1,date('m'),date('d')+14,date('Y')));
	$sql = "select 班次名称 from edu_xingzheng_banci";
	//$cursor = exequery($connection,$sql);
	$rs=$db->CaCheExecute(30,$sql);
    $ROW=$rs->GetArray();
    $COUNT=sizeof($ROW);

	  for($i=0;$i<sizeof($ROW);$i++) {
		//while($ROW = mysql_fetch_array($cursor))			{
		$班次数组[]= $ROW[$i]["班次名称"];
	}

	//对未来十四天之内可以使用的时间段进行统计和分析
	for($i=-1;$i<14;$i++)		{
		$星期X = date("w",mktime(1,1,1,date('m'),date('d')+$i,date('Y')));
		$当天X = date("Y-m-d",mktime(1,1,1,date('m'),date('d')+$i,date('Y')));
		$query = "select 班次名称 AS 班次,排班人员 AS 人员 from edu_xingzheng_paiban where (排班人员 like '%,$人员用户名,%' or 排班人员 like '$人员用户名,%') and 学期名称='$学期名称' and 考勤日期='$当天X'";
		//$cursor = exequery($connection,$query);
		$rs=$db->CaCheExecute(30,$query);
		$ROW=$rs->GetArray();

		$班次Array = array();
		for($n=0;$n<sizeof($ROW);$n++) {
			//while($ROW = mysql_fetch_array($cursor)) {
			$班次X= $ROW[$n]["班次"];
			$班次Array[$班次X] = $ROW[$n]["班次"];
		}

		//print_R($班次Array);
		for($X=0;$X<sizeof($班次数组);$X=$X+1)		{
			$班次TEMP = $班次数组[$X];;
			if($班次Array[$班次TEMP]=="")		{
				//print_R($班次Array);
				$可用时间列表[] = $当天X." 周".$星期XNAME[$星期X]." ".$班次TEMP."";
				$可用时间列表X[] = $当天X." ".$班次TEMP." ".$星期X;
				//print $当天X." ".$班次TEMP." ".$人员." {$班次Array[$班次TEMP]}<BR>";;
			}
		}
	}
	//print_R($_SESSION);
	for($i=0;$i<sizeof($可用时间列表);$i++)		{
			$LINE_COUNTER = $i;
			$Element = $可用时间列表[$i];
			$ElementX = $可用时间列表X[$i];
			$ElementXArray = explode(' ',$ElementX);
			$人员 = $_SESSION['LOGIN_USER_NAME'];
			$星期 = $ElementXArray[2];
			$班次 = $ElementXArray[1];
			$日期 = $ElementXArray[0];
			print "
				 <tr class=\"TableData\">
			   <td nowrap align=\"center\">$人员</td>
			   <td nowrap align=\"center\">$日期</td>
			   <td nowrap align=\"center\">$班次</td>
			   <td nowrap align=\"center\">";
			   print "<input size=6 type=hidden class=SmallInput name='NAME_".$LINE_COUNTER."_VALUE' value='1'/>";
			   $query = "select 编号 from edu_xingzheng_jiabanbuxiu where 学期='$学期名称' and 人员='$人员' and 加班时间='$日期' and 加班班次='$班次'  and 加班工作流ID号='$RUN_ID'";
				//$cursor = exequery($connection,$query);
				//$ROW = mysql_fetch_array($cursor);
				$rs=$db->Execute($query);
				$ROW=$rs->GetArray();
				$编号= $ROW[0]["编号"];


			   $query = "select 编号 from edu_xingzheng_jiabanbuxiu where 学期='$学期名称' and 人员='$人员' and 加班时间='$日期' and 加班班次='$班次'  and 加班工作流ID号='$RUN_ID' and 加班审核状态 = 1";
				//$cursor = exequery($connection,$query);
				//$ROW = mysql_fetch_array($cursor);
				$rs=$db->Execute($query);
				$ROW=$rs->GetArray();
				$通过编号= $ROW[0]["编号"];


			   if($通过编号!="")	{
				   print "<a><font color=red>已申请通过<font></a>";
				   $补休时间 = $日期;
			   }
			   else
			   {
			   	   if($编号!="")	{
					   print "&nbsp;已申请 <a href=\"?action=JiaBanDelete&RUN_ID=$RUN_ID&人员=$人员&班次=$班次&星期=$星期&部门=$部门&日期=$日期&编号=$编号\" >删除</a>";
					   $补休时间 = $日期;
				   }
				   else		{
					   print "<a href=\"?action=JiaBanDataDeal&RUN_ID=$RUN_ID&人员=$人员&班次=$班次&星期=$星期&部门=$部门&日期=$日期\" >申请加班</a>";
					   $补休时间 = '';
				   }
				}
			   print "
			   <input size=6  type=hidden class=SmallInput name='NAME_".$LINE_COUNTER."_ID' value='$编号'/>
			   <input size=6  type=hidden class=SmallInput name='NAME_".$LINE_COUNTER."_BANJI' value='$部门'/>
			   <input size=6  type=hidden class=SmallInput name='NAME_".$LINE_COUNTER."_KECHENG' value='$人员'/>
			   <input size=6  type=hidden class=SmallInput name='NAME_".$LINE_COUNTER."_OLDDATE' value='$日期'/>
			   <input size=6  type=hidden class=SmallInput name='NAME_".$LINE_COUNTER."_OLDJIECI' value='$班次'/>
			   <input size=6  type=hidden class=SmallInput name='NAME_".$LINE_COUNTER."_NEWDATE' value='$补休时间'/>
			   <input size=6  type=hidden class=SmallInput name='NAME_".$LINE_COUNTER."_NEWJIECI' value='$补休班次'/>
			   </td>
				</tr>
				";
	}



?>

		<tr class="TableData">
			<td nowrap align=center colspan=8>

			<input type=button accesskey='c' name='cancel' value=' 返回 ' class=SmallButton onClick="location='?'">
			</td>
		</tr>

</table>
<div id=HTMLSHOW></div>
</form>

<?php
exit;
}

	require_once('include.inc.php');
	require_once('../Help/module_xingzhengworkflow.php');

?>