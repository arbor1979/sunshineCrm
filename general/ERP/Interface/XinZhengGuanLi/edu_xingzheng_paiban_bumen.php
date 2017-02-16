<?php
ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL);

// display warnings and errors
error_reporting(E_WARNING | E_ERROR);
require_once('lib.inc.php');//

$GLOBAL_SESSION=returnsession();
$SYSTEM_PRIV_STOP = 1;
require_once("systemprivateinc.php");
//CheckSystemPrivate("人力资源-行政考勤-部门级管理");
require_once('lib.xiaoli.inc.php');
global $学期名称,$开始时间X,$结束时间X;

page_css("行政排班设置");
$用户ID = $_SESSION['LOGIN_USER_ID'];
list($Week_Count,$当前学期,$W_B_L,$W_E_L) = GetWeekCount();

//班次过滤部分,班次字段必须设为隐藏分组属性--开始
$LOGIN_USER_NAME = $_SESSION['LOGIN_USER_NAME'];
$sql = "select 班次名称 from edu_xingzheng_banci where 班次管理一='$LOGIN_USER_NAME' or 班次管理二='$LOGIN_USER_NAME'";
$rs = $db->Execute($sql);
$rs_a = $rs->GetArray();
$班次名称 = array();
for($i=0;$i<sizeof($rs_a);$i++)						{
	$Element = $rs_a[$i];
	$班次名称[]  = $Element['班次名称'];
}
$班次名称TEXT = "'".join("','",$班次名称)."'";
if($班次名称TEXT=="")	$班次名称TEXT = "没有所管理的班次信息";
$_GET['原班次'] = $班次名称TEXT;
//班次过滤部分,班次字段必须设为隐藏分组属性--结束



//**********************删除已选中设定的信息***********************//
if($_GET['action'] == "Del")
{
	$排班编号 = $_GET['排班编号'];
	$当前周次 = $_GET['当前周次'];
	$班次名称 = $_GET['班次名称'];
	$考勤日期 = $_GET['考勤日期'];
	$当前周次 = $_GET['当前周次'];

	$sql = "delete from edu_xingzheng_paiban where 周次='$当前周次' and 班次名称='$班次名称' and 考勤日期='$考勤日期'";
	$rs = $db -> Execute($sql);
	//print_R($sql);
	//exit;
	if($rs != 0)
	print_infor("删除信息成功",'',"location='?当前周次=$当前周次'");
	else
	print_infor("删除信息失败",'',"location='?当前周次=$当前周次'");
	print "<meta http-equiv='refresh' content=1;url='?当前周次=".$当前周次."'>";
	exit;
}

//********************提交行政工作组排班信息*********************//
if($_GET['action'] == "Change" && $_GET['type'] == "team")
{
	$班组编号 = $_POST['Team'];
	$sql = "select 组员名称 from edu_xingzheng_group where 编号='$班组编号'";
	$rs = $db -> Execute($sql);
	$rs_a = $rs -> GetArray();
	if(!is_array($rs_a))
	$rs_a = array();
	$组员信息 = $rs_a;
	$排班人员 = "";
	$name = explode(",",$组员信息[0]['组员名称']);
	array_pop($name);
	for($i=0;$i<sizeof($name);$i++)
	{
		$排班人员 .= $name[$i];
		if($i!=sizeof($name)-1)
		$排班人员 .= ",";
	}
	if($排班人员 == "")
	{
		$当前周次 = $_POST['当前周次'];
		print_infor("该组尚未有组员信息!",'',"location='?当前周次=$当前周次'");
		exit;
	}
	else
	{
		$当前学期 = $_POST['当前学期'];
		$当前周次 = $_POST['当前周次'];
		$当前星期 = $_POST['当前星期'];
		$班次名称 = $_POST['班次名称'];
		$考勤日期 = $_POST['考勤日期'];
		$创建时间 = Date("Y-m-d H:i:s");

		$排班人员Array = explode(',',$排班人员);
		for($i=0;$i<sizeof($排班人员Array);$i++)		{
			$排班人员X = $排班人员Array[$i];
			$排班人员数据[$排班人员X] = $排班人员X;
		}
		$排班人员数据K = @array_keys($排班人员数据);
		$排班人员 = join(',',$排班人员数据K).",";
		//print_R($排班人员);
		//exit;

		$sql = "insert into edu_xingzheng_paiban values('','".$当前学期."','$当前周次','$当前星期','$考勤日期','$班次名称','$排班人员','','$用户ID','$创建时间')";
		$db -> Execute($sql);
		//print $sql;exit;
		print "<meta http-equiv='refresh' content=1;url='?当前周次=".$当前周次."'>";
		exit;
	}
}
//********************提交工作人员排班信息*********************//
if($_GET['action'] == "Change" && $_GET['type'] == "worker")
{
	//print_R($_POST);
	$name = $_POST['name'];
	$排班人员 = "";
	for($i=0;$i<sizeof($name);$i++)
	{
		$排班人员信息 = $name[$i];
		$排班人员信息_arr = explode('-',$排班人员信息);
		$排班人员 .= $排班人员信息_arr[2]."";
		if($i!=sizeof($name)-1)
		$排班人员 .= ",";
	}
	if($排班人员 == "")
	{
		$当前周次 = $_POST['当前周次'];
		print_infor("您没有选中任何成员",'',"location='?当前周次=$当前周次'");
		exit;
	}
	else
	{
		$考勤日期 = $_POST['考勤日期'];
		$当前学期 = $_POST['当前学期'];
		$当前周次 = $_POST['当前周次'];
		$当前星期 = $_POST['当前星期'];
		$班次名称 = $_POST['班次名称'];
		$创建时间 = Date("Y-m-d H:i:s");

		$排班人员Array = explode(',',$排班人员);
		for($i=0;$i<sizeof($排班人员Array);$i++)		{
			$排班人员X = $排班人员Array[$i];
			if($排班人员X!="")	$排班人员数据[$排班人员X] = $排班人员X;
		}
		$排班人员数据K = @array_keys($排班人员数据);
		$排班人员 = join(',',$排班人员数据K).",";
		//print_R($排班人员);
		//exit;
		//编号 排班编号 学期名称 学期名称 周次 周次 星期  考勤日期 班次编号 班次名称 班次名称 排班人员 排班人员 备注 备注 创建人 创建人 创建时间
		$sql = "select 编号 from edu_xingzheng_paiban where 学期名称='".$当前学期."' and 周次='".$当前周次."' and 班次名称='".$班次名称."' and 考勤日期='$考勤日期' order by 星期 asc";
		$rs = $db -> Execute($sql);
		$编号 = $rs->fields['编号'];
		if($编号!="")		{
			$sql = "update edu_xingzheng_paiban set 周次='$当前周次',星期='$当前星期',班次名称='$班次名称',排班人员='$排班人员',考勤日期='$考勤日期' where 编号='$编号'";
		}
		else	{
			$sql = "insert into edu_xingzheng_paiban values('','".$当前学期."','".$当前周次."','".$当前星期."','".$考勤日期."','".$班次名称."','".$排班人员."','','".$用户ID."','".$创建时间."')";
		}
		//print $sql;exit;
		$db -> Execute($sql);
		//print $sql;exit;
		print "<meta http-equiv='refresh' content=1;url='?当前周次=".$当前周次."'>";
		exit;
	}
}


//*******************选择行政工作组的信息***************//
if($_GET['action'] == "ChangeTeam")
{
		$班组信息 = GetBanZuInfor();
		$当前学期 = $_GET['当前学期'];
		$当前周次 = $_GET['当前周次'];
		$当前星期 = $_GET['Day'];
		$班次名称 = $_GET['班次名称'];
		$考勤时间段 = $_GET['考勤时间段'];
		$星期 = "";
		switch($当前星期)
		{
			case 1: $星期 = "星期一";break;
			case 2:	$星期 = "星期二";break;
			case 3: $星期 = "星期三";break;
			case 4: $星期 = "星期四";break;
			case 5: $星期 = "星期五";break;
			case 6: $星期 = "星期六";break;
			case 7: $星期 = "星期日";break;
		}
?>
<table width="80%" class="TableBlock" align="center">
<form name="ChangeTeam" method="post" action="?action=Change&type=team">
<tr class="TableHeader">
<td>按组安排工作</td>
</tr>
<tr class="TableData">
<td>
&nbsp;<font color="red">当前学期:<?php echo $当前学期;?></font>&nbsp;<BR>
&nbsp;<font color="green">当前日期:<?php echo 返回目标日期($当前周次,$当前星期)?></font>&nbsp;<BR>
&nbsp;<font color="green">当前周次:第<?php echo $当前周次;?>周</font>&nbsp;<BR>
&nbsp;<font color="green">当前星期:<?php echo $星期;?></font>&nbsp;<BR>
&nbsp;<font color="blue">当前班次:<?php echo $班次名称;?>(<?php echo $考勤时间段;?>)
</font></td>
</tr>
<tr class="TableHeader">
<td>
请选择您要安排的工作组
</td>
</tr>
<tr class="TableData">
<td>
<?php
	for($i=0;$i<sizeof($班组信息);$i++)
	{
		$班组编号 = $班组信息[$i]['编号'];
		$部门名称 = $班组信息[$i]['部门名称'];
		$组别名称 = $班组信息[$i]['组别名称'];
		if($i == 0)
			$Checked = "checked";
		else
			$Checked = "";
		print "<input type='radio' name='Team' value='".$班组编号."' $Checked>".$部门名称."-".$组别名称."</input><BR>";
	}
$考勤日期 = 返回目标日期($当前周次,$当前星期);
?>
<input type="hidden" name="考勤日期" value=<?php echo $考勤日期;?> />
<input type="hidden" name="当前学期" value=<?php echo $当前学期;?> />
<input type="hidden" name="当前周次" value=<?php echo $当前周次;?> />
<input type="hidden" name="当前星期" value=<?php echo $当前星期;?> />
<input type="hidden" name="班次名称" value=<?php echo $班次名称;?> />
</td>
</tr>
<tr class="TableData">
<td align="center">
	<input type="submit" class="SmallButton" value="提交" />&nbsp;&nbsp;
	<input type="button" class="SmallButton" value="返回" onclick="history.go(-1);">
</td>
</tr>
</form>
</table>
<?php
		exit;
	}

//*******************选择工作人员信息**********************//
	else if($_GET['action'] == "ChangeWorker")
	{
		$组员信息 = GetWorkerInfor();
		//print_R($组员信息);
		$当前学期 = $_GET['当前学期'];
		$当前周次 = $_GET['当前周次'];
		$当前星期 = $_GET['Day'];
		$班次名称 = $_GET['班次名称'];
		$考勤时间段 = $_GET['考勤时间段'];
		$星期 = "";
		switch($当前星期)
		{
			case 1: $星期 = "星期一";break;
			case 2:	$星期 = "星期二";break;
			case 3: $星期 = "星期三";break;
			case 4: $星期 = "星期四";break;
			case 5: $星期 = "星期五";break;
			case 6: $星期 = "星期六";break;
			case 7: $星期 = "星期日";break;
		}

		//形成已加入人员列表
		$考勤日期 = 返回目标日期($当前周次,$当前星期);
		$sql = "select * from edu_xingzheng_paiban where 学期名称='".$当前学期."' and 周次='".$当前周次."' and 班次名称='".$班次名称."' and 考勤日期='$考勤日期' order by 星期 asc";
		$rs = $db -> Execute($sql);
		$rs_a = $rs -> GetArray();
		$排班人员 = $rs_a[0]['排班人员'];
		$已有人员 = $排班人员;
		$排班人员数据K = explode(',',$排班人员);
?>

<table width="80%" class="TableBlock" align="center">
<form name="ChangeTeam" method="post" action="?action=Change&type=worker">
<tr class="TableHeader">
<td>按人员安排工作</td>
</tr>
<tr class="TableData">
<td><font color="red">&nbsp;当前学期:<?php echo $当前学期;?></font>&nbsp;<BR>&nbsp;<font color="green">当前周次:第<?php echo $当前周次;?>周</font>&nbsp;<BR>&nbsp;<font color="green">当前星期:<?php echo $星期;?></font>&nbsp;<BR>&nbsp;<font color="blue">当前班次:<?php echo $班次名称;?>(<?php echo $考勤时间段;?>)</font>
<BR>&nbsp;<font color="blue">已有人员:<?php echo useridtoname($已有人员);?></font>
</td>
</tr>
<tr class="TableHeader">
<td>
请选择您要安排的工作人员
</td>
</tr>

<?php
    $Counter1 = 0;
	$Counter2 = 0;
	for($i=0;$i<sizeof($组员信息);$i++)
	{
		$班组编号 = $组员信息[$i]['编号'];
		$部门名称 = $组员信息[$i]['部门名称'];
		$组别名称 = $组员信息[$i]['组别名称'];
		$组员名称 = $组员信息[$i]['组员名称'];
		if($组员名称 == "")
			continue;
		else
		{

			$组员名称_arr = explode(',',$组员名称);

			for($j=0;$j<sizeof($组员名称_arr);$j++)
			{
				$排班人员 = $组员名称_arr[$j];
				$排班人员姓名 = returntablefield("user","USER_ID",$排班人员,"USER_NAME");
				if(in_array($排班人员,$排班人员数据K))		{
					if($j!=sizeof($组员名称_arr)-1)
					{
						$SHOWTEXT .= "<input type='checkbox' name='name[]' checked value='".$部门名称."-".$组别名称."-".$排班人员."' $Checked title='用户名:$排班人员 姓名:$排班人员姓名'><font color=green title='用户名:$排班人员 姓名:$排班人员姓名'>".$排班人员姓名."-".$组别名称."</font>&nbsp;";
						$jj = $Counter1+1;
						$Counter1 ++;
						if($Counter1>0 && $Counter1%4==0)
						{
							$SHOWTEXT .=  "<br>";
						}
					}

				}
				else	{
					if($j!=sizeof($组员名称_arr)-1)
					{
						$SHOWTEXT2 .= "<input type='checkbox' name='name[]' value='".$部门名称."-".$组别名称."-".$排班人员."' $Checked title='用户名:$排班人员 姓名:$排班人员姓名' ><font color=green title='用户名:$排班人员 姓名:$排班人员姓名'>".$排班人员姓名."-".$组别名称."</font>&nbsp;";
						$jj = $Counter2+1;
						$Counter2 ++;
						if($Counter2>0 && $Counter2%4==0)
						{
							$SHOWTEXT2 .=  "<br>";
						}
					}

				}

			}

		}
	}

	print "<tr class=TableData><td>";
	print "已选人员:<BR>".$SHOWTEXT;
	print "</td></tr>";
	print "<tr class=TableData><td>";
	print "未选人员:<BR>".$SHOWTEXT2;
	print "</td></tr>";
	$考勤日期 = 返回目标日期($当前周次,$当前星期);
	?>
<input type="hidden" name="考勤日期" value=<?php echo $考勤日期;?> >
<input type="hidden" name="当前学期" value=<?php echo $当前学期;?> />
<input type="hidden" name="当前周次" value=<?php echo $当前周次;?> />
<input type="hidden" name="当前星期" value=<?php echo $当前星期;?> />
<input type="hidden" name="班次名称" value=<?php echo $班次名称;?> />
	<tr class="TableData">
<td align="center">
	<input type="submit" class="SmallButton" value="提交" />&nbsp;&nbsp;
	<input type="button" class="SmallButton" value="返回" onclick="history.go(-1);">
</td>
</tr>
</table>
<?php
	exit;
}

?>
<table width="100%" class="TableBlock" align="center">
<tr class="TableHeader">
<td>选择排班周次</td>
</tr>
<tr class="TableData">
<td nowrap>第&nbsp;
<?php
	$_GET['当前周次'] != "" ? '' : $_GET['当前周次'] = returnCurWeekIndex($datetime=date("Y-m-d"));
	$当前周次 = $_GET['当前周次'];


	for($i=0;$i<$Week_Count;$i++)
	{
		if($i+1 == $当前周次)
		print "<a href='?当前周次=".($i+1)."' target='_self'><font color=red>".($i+1)."</font></a>&nbsp;&nbsp;";
		else
		print "<a href='?当前周次=".($i+1)."' target='_self'>".($i+1)."</a>&nbsp;&nbsp;";
	}
?>
周</td>
</tr>
</table>
<br />
<?php

	$当前周次 = $_GET['当前周次'];
	$上周周次 = $当前周次-1;
	$sql = "select * from edu_xingzheng_paiban where 周次='$上周周次' and 学期名称='$当前学期' and 班次名称 in ($班次名称TEXT)";
	$rs = $db -> Execute($sql);
	$rs_a = $rs -> GetArray();
	//本周
	$sql = "select * from edu_xingzheng_paiban where 周次='$当前周次' and 学期名称='$当前学期' and 班次名称 in ($班次名称TEXT)";
	$rs = $db -> Execute($sql);
	$rs_a本周 = $rs -> GetArray();

	if($_GET['action']=="从上周获取数据"&&$_GET['当前周次']!="")								{
		//print_R($rs_a);exit;
		for($i=0;$i<sizeof($rs_a);$i++)
		{
			$星期 = $rs_a[$i]['星期'];
			$考勤日期 = 返回目标日期($当前周次,$星期);
			$班次名称 = $rs_a[$i]['班次名称'];
			$排班人员 = $rs_a[$i]['排班人员'];
			$备注 = $rs_a[$i]['备注'];
			$创建人 = $rs_a[$i]['创建人'];
			$创建时间 = date("Y-m-d H:i:s");;

			$排班人员数据 = array();
			$排班人员Array = explode(',',$排班人员);
			for($iX=0;$iX<sizeof($排班人员Array);$iX++)		{
				$排班人员X = $排班人员Array[$iX];
				$排班人员数据[$排班人员X] = $排班人员X;
			}
			$排班人员数据K = @array_keys($排班人员数据);
			$排班人员 = join(',',$排班人员数据K).",";

			//if($NUM==0)	{
			$sql = "insert into edu_xingzheng_paiban values('','$当前学期','$当前周次','$星期','$考勤日期','$班次名称','$排班人员','$备注','$创建人','$创建时间')";
			$db -> Execute($sql);
			//print $sql;exit;
			//}

		}
		print_infor("你的数据已经初始化完成.",'',"location='?当前周次=".$当前周次."'");
		print "<meta http-equiv='refresh' content=0;url='?当前周次=".$当前周次."'>";
		exit;
	}

	//exit;
	//print_R($rs_a);
	//本周有数据,或上周无数据,都会停止导入动作
	if(sizeof($rs_a)==0||sizeof($rs_a本周)>0)		{
		//没有记录,不能获取数据
		$disabled_上周 = "disabled readonly title='本周已经有排班数据或上周无排班数据,不能从上周获取信息'";
	}


	$前周周次 = $当前周次-2;
	$sql = "select * from edu_xingzheng_paiban where 周次='$前周周次' and 学期名称='$当前学期' and 班次名称 in ($班次名称TEXT)";
	$rs = $db -> Execute($sql);
	$rs_a = $rs -> GetArray();
	if($_GET['action']=="从前周获取数据"&&$_GET['当前周次']!="")								{
		//print_R($rs_a);exit;
		for($i=0;$i<sizeof($rs_a);$i++)
		{
			$星期 = $rs_a[$i]['星期'];
			$考勤日期 = 返回目标日期($当前周次,$星期);
			$班次名称 = $rs_a[$i]['班次名称'];
			$排班人员 = $rs_a[$i]['排班人员'];
			$备注 = $rs_a[$i]['备注'];
			$创建人 = $rs_a[$i]['创建人'];
			$创建时间 = date("Y-m-d H:i:s");;

			$排班人员数据 = array();
			$排班人员Array = explode(',',$排班人员);
			for($iX=0;$iX<sizeof($排班人员Array);$iX++)		{
				$排班人员X = $排班人员Array[$iX];
				$排班人员数据[$排班人员X] = $排班人员X;
			}
			$排班人员数据K = @array_keys($排班人员数据);
			$排班人员 = join(',',$排班人员数据K).",";

			//if($NUM==0)	{
			$sql = "insert into edu_xingzheng_paiban values('','$当前学期','$当前周次','$星期','$考勤日期','$班次名称','$排班人员','$备注','$创建人','$创建时间')";
			$db -> Execute($sql);
			//print $sql."<BR>";
			//}


		}
		print_infor("你的数据已经初始化完成.",'',"location='?当前周次=".$当前周次."'");
		print "<meta http-equiv='refresh' content=0;url='?当前周次=".$当前周次."'>";
		exit;
	}

	//exit;
	//print_R($rs_a);
	//本周有数据,或上周无数据,都会停止导入动作
	if(sizeof($rs_a)==0||sizeof($rs_a本周)>0)		{
		//没有记录,不能获取数据
		$disabled_前周 = "disabled readonly title='本周已经有排班数据或上周无排班数据,不能从上周获取信息'";
	}



?>
<table width="100%" class="TableBlock" align="center">
<tr class="TableHeader">
<td colspan=8>设置排班情况&nbsp;当前周次:<?php echo $当前周次?>
&nbsp;时间范围: <?php echo substr($返回目标日期=返回目标日期($当前周次,1),6,11)?> 至 <?php echo substr($返回目标日期=返回目标日期($当前周次,7),6,11)?>
<input name='从上周获取数据' value='从第<?php echo ($当前周次-1)?>周获取排班数据' class=SmallButton type=Button OnClick="location='?当前周次=<?php echo $当前周次?>&action=从上周获取数据'" <?php echo $disabled_上周?>>
<input name='从前周获取数据' value='从第<?php echo ($当前周次-2)?>周获取排班数据' class=SmallButton type=Button OnClick="location='?当前周次=<?php echo $当前周次?>&action=从前周获取数据'" <?php echo $disabled_前周?>>
</td>
</tr>
<tr class="TableData" align="center">
	<td width="16%">班次\星期</td>
	<td width="12%">星期一<BR><?php echo 返回目标日期($当前周次,1)?></td>
	<td width="12%">星期二<BR><?php echo 返回目标日期($当前周次,2)?></td>
	<td width="12%">星期三<BR><?php echo 返回目标日期($当前周次,3)?></td>
	<td width="12%">星期四<BR><?php echo 返回目标日期($当前周次,4)?></td>
	<td width="12%">星期五<BR><?php echo 返回目标日期($当前周次,5)?></td>
	<td width="12%">星期六<BR><?php echo 返回目标日期($当前周次,6)?></td>
	<td width="12%">星期日<BR><?php echo 返回目标日期($当前周次,7)?></td>
</tr>
<?php
	$班次信息 = GetBanCiInfor();

	for($i=0;$i<sizeof($班次信息);$i++)
	{
		$班次名称 = $班次信息[$i]['班次名称'];
		$考勤时间段 = $班次信息[$i]['考勤时间段'];
		$排班信息 = GetPaiBanInfor($当前学期,$当前周次,$班次名称);

		print "<tr class=TableData align=center>";
		print "<td>".$班次名称."(".$考勤时间段.")</td>";
		for($j=1;$j<=7;$j++)
		{
			$返回目标日期 = 返回目标日期($当前周次,$j);
			$排班数据 = explode("-",$排班信息[$班次名称][$当前周次][$j]);
			$排班编号 = $排班数据[0];
			$排班人员 = $排班数据[1];
			print "<td>";
			if($返回目标日期>=$开始时间X&&$返回目标日期<=$结束时间X)		{
				if($排班人员=="")
				{
					print "<a href='?action=ChangeTeam&班次名称=".$班次名称."&当前学期=".$当前学期."&当前周次=".$当前周次."&Day=".$j."&考勤时间段=".$考勤时间段."'>选择工作组</a><br />
										   <a href='?action=ChangeWorker&班次名称=".$班次名称."&当前学期=".$当前学期."&当前周次=".$当前周次."&Day=".$j."&考勤时间段=".$考勤时间段."'>选择工作人员</a>$考勤日期";
				}
				else
				{
					$排班人员 = useridtoname($排班人员);
					$排班人员TEXT = substr_cut($排班人员,120);
					print "".$排班人员TEXT."<br /><a href='?action=Del&班次名称=".$班次名称."&考勤时间段=".$考勤时间段."&考勤日期=".$返回目标日期."&当前周次=".$当前周次."'><font color=red>删除</font><BR><a href='?action=ChangeWorker&班次名称=".$班次名称."&当前学期=".$当前学期."&当前周次=".$当前周次."&Day=".$j."&考勤时间段=".$考勤时间段."'>选择工作人员</a>";
				}
			}
			else	{
				print "<font color=gray>非工作时间</font>";
			}
			print "</td>";
		}
		print "</tr>";
	}

?>
</table>
<?php
	if($_GET['action']==''||$_GET['action']=='init_default')		{
		$PrintText .= "<BR><table class=TableBlock align=center width=100%>";
		$PrintText .= "<TR class=TableContent><td ><font color=green >
		排班：<BR>
&nbsp;&nbsp;①就是针对人员和组别信息，按照一天内班次信息的设置进行排班。<BR>
&nbsp;&nbsp;②里面会记录某一天，某一班次下面所上班的人员的信息（按组别排班会把该组别下面所有人员加入排班，按人员选取则可以实现按某一人单一排班的条件）。
		</font></td></table>";
		print $PrintText;
	}

	//******************获取所有的人员信息********************//
	function GetWorkerInfor()
	{
		global $db;
		$sql = "select 编号,部门名称,组别名称,组员名称 from edu_xingzheng_group order by 编号 asc,部门名称 asc";
		$rs = $db -> Execute($sql);
		$rs_a = $rs -> GetArray();
		if(!is_array($rs_a))
		$rs_a = array();
		$组员信息 = $rs_a;
		return $组员信息;
	}
	//******************获取所有的班组信息********************//
	function GetBanZuInfor()
	{
		global $db;
		$sql = "select 编号,部门名称,组别名称,组员名称 from edu_xingzheng_group";
		$rs = $db -> Execute($sql);
		$rs_a = $rs -> GetArray();
		if(!is_array($rs_a))
		$rs_a = array();
		$班组信息 = $rs_a;
		return $班组信息;
	}
	//******************获得所有的班次信息********************//
	function GetBanCiInfor()
	{
		global $db,$班次名称TEXT;
		$sql = "select 班次名称,考勤时间段 from edu_xingzheng_banci where 班次名称 in ($班次名称TEXT)";
		$rs = $db -> Execute($sql);
		$rs_a = $rs -> GetArray();
		if(!is_array($rs_a))
		$rs_a = array();
		$班次信息 = $rs_a;
		return $班次信息;
	}
	//******************获得指定的排班信息********************//
	function GetPaiBanInfor($当前学期,$当前周次,$班次名称)
	{
		global $db;
		$sql = "select * from edu_xingzheng_paiban where 学期名称='".$当前学期."' and 周次='".$当前周次."' and 班次名称='".$班次名称."' order by 星期 asc";
		$rs = $db -> Execute($sql);
		$rs_a = $rs -> GetArray();
		if(!is_array($rs_a))
		$rs_a = array();
		$排班信息 = $rs_a;
		for($i=0;$i<sizeof($排班信息);$i++)
		{
			$排班编号 = $排班信息[$i]['编号'];
			$考勤日期 = $排班信息[$i]['考勤日期'];
			$班次名称 = $排班信息[$i]['班次名称'];
			$周次 = $排班信息[$i]['周次'];
			$星期 = $排班信息[$i]['星期'];
			$排班人员 = $排班信息[$i]['排班人员'];
			$排班信息_ret[$班次名称][$周次][$星期] = $排班编号."-".$排班人员;
		}
		return $排班信息_ret;
	}
	//******************获取周的总数********************//
	function GetWeekCount()
	{
		global $db;
		global $学期名称,$开始时间X,$结束时间X;
		$sql = "select 学期名称,开始时间,结束时间 from edu_xueqiexec where 当前学期=1";
		$rs = $db -> Execute($sql);
		$rs_a = $rs -> GetArray();
		if(!is_array($rs_a))
		$rs_a = array();
		$学期信息 = $rs_a;
		$学期名称 = $学期信息[0]['学期名称'];
		$开始日期 = $学期信息[0]['开始时间'];
		$结束日期 = $学期信息[0]['结束时间'];
		$开始时间X = $学期信息[0]['开始时间'];
		$结束时间X = $学期信息[0]['结束时间'];
		$开始信息 = explode('-',$开始日期);
		$结束信息 = explode('-',$结束日期);
		$开始年份 = $开始信息[0];
		$开始月份 = $开始信息[1];
		$开始日   = $开始信息[2];
		$结束年份 = $结束信息[0];
		$结束月份 = $结束信息[1];
		$结束日   = $结束信息[2];
		$W_B_L = date("l",mktime(0,0,0,$开始月份,$开始日,$开始年份));
		$W_E_L = date("l",mktime(0,0,0,$结束月份,$结束日,$结束年份));
		$SecondWeekDate = GetFirstWeek($开始年份,$开始月份,$开始日,$W_B_L);
		$DescSecondWeekDate = GetLastWeek($结束年份,$结束月份,$结束日,$W_E_L);
		$Days = abs(strtotime($DescSecondWeekDate) - strtotime($SecondWeekDate))/86400+1;
		$Week_Count = $Days/7 + 2;
		$Return[] = $Week_Count;
		$Return[] = $学期名称;
		$Return[] = $W_B_L;
		$Return[] = $W_E_L;
		return $Return;
	}

	function 返回目标日期($周次,$星期)
	{
		global $db;
		global $学期名称,$开始时间X,$结束时间X;
		$开始日期Array = explode('-',$开始时间X);
		$开学时间星期数 = date("w",mktime(0,0,0,$开始日期Array[1],$开始日期Array[2],$开始日期Array[0]));
		$时间差 = ($周次-1)*7+$星期-$开学时间星期数;
		$目标时间 = date("Y-m-d",mktime(0,0,0,$开始日期Array[1],$开始日期Array[2]+$时间差,$开始日期Array[0]));
		return $目标时间;
	}
	//***************获得第一周的日期*****************//
	function GetFirstWeek($开始年份,$开始月份,$开始日,$W_B_L)
	{
		$SecondWeekDate = "";
		switch($W_B_L)
		{
		  case 'Monday':$SecondWeekDate = date("Y-m-d",mktime(0,0,0,$开始月份,$开始日+7,$开始年份));break;
		  case 'Tuesday':$SecondWeekDate = date("Y-m-d",mktime(0,0,0,$开始月份,$开始日+6,$开始年份));break;
		  case 'Wednesday':$SecondWeekDate = date("Y-m-d",mktime(0,0,0,$开始月份,$开始日+5,$开始年份));break;
		  case 'Thursday':$SecondWeekDate = date("Y-m-d",mktime(0,0,0,$开始月份,$开始日+4,$开始年份));break;
		  case 'Friday':$SecondWeekDate = date("Y-m-d",mktime(0,0,0,$开始月份,$开始日+3,$开始年份));break;
		  case 'Saturday':$SecondWeekDate = date("Y-m-d",mktime(0,0,0,$开始月份,$开始日+2,$开始年份));break;
		  case 'Sunday':$SecondWeekDate = date("Y-m-d",mktime(0,0,0,$开始月份,$开始日+1,$开始年份));break;
		}
		return $SecondWeekDate;
	}
	//****************获得最后一周的日期******************//
	function GetLastWeek($结束年份,$结束月份,$结束日,$W_E_L)
	{
		$DescSecondWeekDate = "";
		switch($W_E_L)
		{
		  case 'Monday':$DescSecondWeekDate = date("Y-m-d",mktime(0,0,0,$结束月份,$结束日-1,$结束年份));break;
		  case 'Tuesday':$DescSecondWeekDate = date("Y-m-d",mktime(0,0,0,$结束月份,$结束日-2,$结束年份));break;
		  case 'Wednesday':$DescSecondWeekDate = date("Y-m-d",mktime(0,0,0,$结束月份,$结束日-3,$结束年份));break;
		  case 'Thursday':$DescSecondWeekDate = date("Y-m-d",mktime(0,0,0,$结束月份,$结束日-4,$结束年份));break;
		  case 'Friday':$DescSecondWeekDate = date("Y-m-d",mktime(0,0,0,$结束月份,$结束日-5,$结束年份));break;
		  case 'Saturday':$DescSecondWeekDate = date("Y-m-d",mktime(0,0,0,$结束月份,$结束日-6,$结束年份));break;
		  case 'Sunday':$DescSecondWeekDate = date("Y-m-d",mktime(0,0,0,$结束月份,$结束日-7,$结束年份));break;
		}
		return $DescSecondWeekDate;
	}
?>
