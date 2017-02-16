<?php
require_once('lib.inc.php');//

$GLOBAL_SESSION=returnsession();
$SYSTEM_PRIV_STOP = 1;
require_once("systemprivateinc.php");
//CheckSystemPrivate("人力资源-行政考勤-我的考勤");
page_css('请假外出');
$当前学期 = returntablefield("edu_xueqiexec","当前学期",'1',"学期名称");
if($_GET['学期']=="") $_GET['学期'] = $当前学期;
$学期名称 = $当前学期;


	$_GET['人员'] = $_SESSION['LOGIN_USER_NAME'];
	$_GET['人员用户名'] = $_SESSION['LOGIN_USER_ID'];
	//$_GET['部门'] = returntablefield("department","DEPT_ID",$_SESSION['LOGIN_DEPT_ID'],"DEPT_NAME");


if($_GET['action']=='QingJiaDataDeal')				{
//print_R($_GET);exit;
	$部门 = $_GET['部门'];
	$班次 = $_GET['班次'];
	$日期 = $_GET['日期'];
	$周次 = $_GET['周次'];
	$人员 = $_SESSION['LOGIN_USER_NAME'];
	$新上班时间Array = explode(' ',$_POST['新上班时间']);
	$新上班时间 = $新上班时间Array[0];
	$新班次 = $新上班时间Array[1];
	$编号 = $_POST['编号'];
	$query = "insert into edu_xingzheng_qingjia values('','$学期名称','$部门','$人员','$日期','$周次','$班次','','0','$RUN_ID','$审核人','$审核时间','".$_SESSION['LOGIN_USER_ID']."');";
	//print_R($_GET);
	//print $query;exit;
	print "<BR><BR><div align=center><font color=green>你的操作已经处理!</font></div>";
	//exequery($connection,$query);
	$db->Execute($query);
	print  "<META HTTP-EQUIV=REFRESH CONTENT='0;URL=?action=add_default&RUN_ID=$RUN_ID'>\n";
	exit;
}

if($_GET['action']=='QingJiaDelete')				{

	$部门 = $_GET['部门'];
	$班次 = $_GET['班次'];
	$人员 = $_SESSION['LOGIN_USER_NAME'];
	//如果数据存在则进行数据编辑操作
	//$query = "delete from edu_xingzheng_qingjia where 编号='$编号' and 班次='$班次' and 学期='$学期名称' and 调休审核状态='0'";
	$编号 = $_GET['编号'];
	$query = "delete from edu_xingzheng_qingjia where 编号='$编号'  and 审核状态='0'";
	//print $query;
	print "<BR><BR><div align=center><font color=green>你的操作已经处理!</font></div>";
	//exequery($connection,$query);
	$db->Execute($query);
	print  "<META HTTP-EQUIV=REFRESH CONTENT='0;URL=?action=add_default&RUN_ID=$RUN_ID'>\n";
	exit;
}
if($_GET['action2']=='QingJiaDelete')				{

	$部门 = $_GET['部门'];
	$班次 = $_GET['班次'];
	$人员 = $_SESSION['LOGIN_USER_NAME'];
	//如果数据存在则进行数据编辑操作
	//$query = "delete from edu_xingzheng_qingjia where 编号='$编号' and 班次='$班次' and 学期='$学期名称' and 调休审核状态='0'";
	$编号 = $_GET['编号'];
	$query = "delete from edu_xingzheng_qingjia where 编号='$编号'  and 审核状态='0'";
	//print $query;
	print "<BR><BR><div align=center><font color=green>你的操作已经处理!</font></div>";
	//exequery($connection,$query);
	$db->Execute($query);
	print  "<META HTTP-EQUIV=REFRESH CONTENT='0;URL=?RUN_ID=$RUN_ID'>\n";
	exit;
}

if($_GET['action']=='KaoQinBudeng')				{
//print_R($_POST);
//print_R($_GET);
	$人员 = $_SESSION['LOGIN_USER_NAME'];
//Array ( [0qingjialeixing] => [CHECK_1_0_VALUE] => on [NAME_0_VALUE] => 1 [NAME_0_ID] => [NAME_0_BANJI] => 系统管理员 [NAME_0_KECHENG] => 升旗 [NAME_0_OLDDATE] => 2011-04-27 [NAME_0_OLDJIECI] => 升旗 [NAME_0_NEWDATE] => [1qingjialeixing] => [CHECK_1_1_VALUE] => on [NAME_1_VALUE] => 1 [NAME_1_ID] => [NAME_1_BANJI] => 系统管理员 [NAME_1_KECHENG] => 升旗 [NAME_1_OLDDATE] => 2011-04-28 [NAME_1_OLDJIECI] => 升旗 [NAME_1_NEWDATE] => )  insert into edu_xingzheng_qingjia values('','2010-2011-第二学期','','系统管理员','','','','','0','','','','admin');

		$请假外出array=$_POST;
		$条=$_POST['COUNT'];
		//$日记补登=array();
		for($i=0;$i<10;$i++)
		{


			 //$教室key=$i."_JIAOSHI";
			 $部门key=$i."_BANJI";
			 $班次key=$i."_KECHENG";
			 $日期key=$i."_OLDDATE";
			 //$人员key=$i."_OLDTEACHER";
			 $请假类型key=$i."qingjialeixing";
			 $请假状态key="CHECK_1_".$i."_VALUE";



			   $部门 = $请假外出array[$部门key];
			   $班次 = $请假外出array[$班次key];
			   $日期 = $请假外出array[$日期key];
			   $周次= date('w',strtotime($上班时间));
			   $请假状态 = $请假外出array[$请假状态key];
			   $请假类型 = $请假外出array[$请假类型key];

			//print   $人员 = $请假外出array[$人员key];

				if($请假状态=='on')
				{


					$query = "insert into edu_xingzheng_qingjia values('','$学期名称','$部门','$人员','$日期','$周次','$班次','$请假类型','0','$RUN_ID','$审核人','$审核时间','".$_SESSION['LOGIN_USER_ID']."');";
					  $db->Execute($query);
					// print $sql;exit;

				}

		}

//exit;
	//$部门 = $_POST['部门'];
	//$班次 = $_POST['班次'];
	//$日期 = $_POST['日期'];
	//$周次 = $_POST['周次'];
/*
	$新上班时间Array = explode(' ',$_POST['新上班时间']);
	$新上班时间 = $新上班时间Array[0];
	$新班次 = $新上班时间Array[1];
	$编号 = $_POST['编号'];
	$query = "insert into edu_xingzheng_qingjia values('','$学期名称','$部门','$人员','$日期','$周次','$班次','','0','$RUN_ID','$审核人','$审核时间','".$_SESSION['LOGIN_USER_ID']."');";
	//print_R($_GET);
	print $query;exit;
	*/
	print "<BR><BR><div align=center><font color=green>你的操作已经处理!</font></div>";
	//exequery($connection,$query);
	//$db->Execute($query);
	print  "<META HTTP-EQUIV=REFRESH CONTENT='0;URL=?action=add_default&RUN_ID=$RUN_ID'>\n";
	exit;
}



if($_GET['action']=='add_default')
{
// print_R($_GET);exit;
 ?>


<form    name=form1 action='?action=KaoQinBudeng' method=post >
<table class="TableList" width="100%">
    <tr class="TableHeader">
      <td nowrap align="center">部门</td>
      <td nowrap align="center">班次</td>
	  <td nowrap align="center">上班时间</td>
      <td nowrap align="center">班次</td>
      <td nowrap align="center">请假类型</td>

	  <td nowrap align="center">请假外出</td>
    </tr>
<?php
  $人员 = $_SESSION['LOGIN_USER_NAME'];

  $开始时间 = date("Y-m-d",mktime(1,1,1,date('m'),date('d')-1,date('Y')));
  $结束时间 = date("Y-m-d",mktime(1,1,1,date('m'),date('d')+14,date('Y')));

  $开始时间 = date("Y-m-d",mktime(1,1,1,date('m'),date('d')-1,date('Y')));
  $结束时间 = date("Y-m-d",mktime(1,1,1,date('m'),date('d')+14,date('Y')));

  $query = "select 星期,班次,人员,班次,日期,部门,编号,周次 from  edu_xingzheng_kaoqinmingxi  where 人员='$人员' and 日期>='$开始时间' and 日期<='$结束时间' and 下班考勤状态!='请假外出' order by 日期,班次,人员";
  //print $query;
 // $cursor = exequery($connection,$query);
	$rs=$db->CaCheExecute(30,$query);
	$ROW=$rs->GetArray();
  // print_R($_GET);exit;
  //行计数器
  $LINE_COUNTER = 0;
  for($i=0;$i<sizeof($ROW);$i++) {
	 // while($ROW = mysql_fetch_array($cursor)) {
    $编号= $ROW[$i]["编号"];
	$人员= $ROW[$i]["人员"];
	$周次= $ROW[$i]["周次"];
	$星期= $ROW[$i]["星期"];
	$班次= $ROW[$i]["班次"];
	$部门= $ROW[$i]["部门"];
	$日期= $ROW[$i]["日期"];


	//如果数据存在则进行数据编辑操作
	$query = "select 编号 from edu_xingzheng_qingjia where 学期='$学期名称' and 人员='$人员' and 时间='$日期' and 班次='$班次' and  工作流ID号='$RUN_ID'";
	//$cursorX = exequery($connection,$query);
	//$ROWX	 = mysql_fetch_array($cursorX);
	$rs=$db->Execute($query);
	$ROWX=$rs->GetArray();
	$请假编号		= $ROWX[0]["编号"];

	$query = "select 编号 from edu_xingzheng_qingjia where 学期='$学期名称' and 人员='$人员' and 时间='$日期' and 班次='$班次' and  工作流ID号='$RUN_ID' and  审核状态=1";
	$rs=$db->Execute($query);
	$ROWXX=$rs->GetArray();
	$通过编号		= $ROWXX[0]["编号"];

$请假外出 = "<input type=checkbox name='CHECK_1_".$LINE_COUNTER."_VALUE' checked />请假外出";
$已申请 = "<input type=checkbox name='CHECK_2_".$LINE_COUNTER."_VALUE' disabled />已申请";

	print "
		 <tr class=\"TableData\">
	   <td nowrap align=\"center\">$部门</td>
	   <td nowrap align=\"center\">$班次</td>
	   <td nowrap align=\"center\">$日期</td>
	   <td nowrap align=\"center\">$班次</td>
	   <td nowrap align=\"center\" width='100'%>
	   <input class=SmallInput  name= ".$LINE_COUNTER."qingjialeixing  value=''></td>

";
   print "<input size=6 type=hidden class=SmallInput name='NAME_".$LINE_COUNTER."_VALUE' value='1'/>";

   if($通过编号!="")	{
	   print " <a><font color=red>已申请通过</font></a>";
	   //$新上班时间 = $日期;
   }
   else
	{
	   if($请假编号!="")	{
		   print "<td nowrap align=\"center\">
		   <a href=\"?action=QingJiaDelete&RUN_ID=$RUN_ID&人员=$人员&班次=$班次&星期=$星期&班次=$班次&日期=$日期&编号=$请假编号&部门=$部门&周次=$周次\">
		   取消</a>
		   $已申请</td>";
		   //$新上班时间 = $日期;
	   }
	   else		{
		   print "<td nowrap align=\"center\">$请假外出</td>";
		   $新上班时间 = '';
	   }

   }

   print "
   <input size=6  type=hidden class=SmallInput name='".$LINE_COUNTER."_ID' value='$请假编号'/>

   <input size=6  type=hidden class=SmallInput name='".$LINE_COUNTER."_BANJI' value='$部门'/>
   <input size=6  type=hidden class=SmallInput name='".$LINE_COUNTER."_KECHENG' value='$班次'/>
   <input size=6  type=hidden class=SmallInput name='".$LINE_COUNTER."_OLDDATE' value='$日期'/>
   <input size=6  type=hidden class=SmallInput name='".$LINE_COUNTER."_OLDJIECI' value='$班次'/>
   <input size=6  type=hidden class=SmallInput name='".$LINE_COUNTER."_NEWDATE' value='$请假编号'/>
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
		  <td nowrap colspan=11 align=center>
		  <input type=submit class=SmallButton value='提交'/>
		    <input type=button accesskey='c' name='cancel' value=' 返回 ' class=SmallButton onClick="location='?'" title='快捷键:ALT+c'>
		</td>
		</tr>

</table>
<div id=HTMLSHOW></div>
</form>

 <?php
	 exit;
}



	$filetablename='edu_xingzheng_qingjia';
	$parse_filename = 'my_xingzheng_qingjia';

	require_once('include.inc.php');
		require_once('../Help/module_xingzhengworkflow.php');

?>