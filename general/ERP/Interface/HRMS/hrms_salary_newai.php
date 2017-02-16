<?php
ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL);

// display warnings and errors
error_reporting(E_WARNING | E_ERROR);
require_once('lib.inc.php');//

$GLOBAL_SESSION=returnsession();
$SYSTEM_PRIV_STOP = 1;
	require_once("systemprivateinc.php");
	CheckSystemPrivate("人力资源-薪酬管理-薪酬设置");

global $学期名称;

page_css("薪酬设置");
$用户ID = $_SESSION['LOGIN_USER_ID'];
list($Week_Count,$当前学期,$W_B_L,$W_E_L) = GetWeekCount();



//**********************删除已选中设定的信息***********************//
if($_GET['action']=="计算上个月薪酬"){
   $当前月份 = $_GET['当前月份'];
   $m= $当前月份-1;
   $y=date('Y');
   detail($y,$m);
}
if($_GET['action'] == "Del")
{
	$排班编号 = $_GET['排班编号'];
	$当前月份 = $_GET['当前月份'];
	$费用名称 = $_GET['费用名称'];
	$当前学期 = $_GET['当前学期'];

	$sql = "delete from hrms_salary where 编号='$排班编号'";
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
	$sql = "select 组员名称 from hrms_salary_group where 编号='$班组编号'";
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
		$当前月份 = $_POST['当前月份'];
		print_infor("该组尚未有组员信息!",'',"location='?当前月份=$当前月份'");
		exit;
	}
	else
	{
		$当前学期 = $_POST['当前学期'];
		$当前月份 = $_POST['当前月份'];
		$费用类别 = $_POST['费用类别'];
		$费用名称 = $_POST['费用名称'];
		$年份 = date("Y");
		$创建时间 = Date("Y-m-d H:i:s");

		$排班人员Array = explode(',',$排班人员);
		for($i=0;$i<sizeof($排班人员Array);$i++)		{
			$排班人员X = $排班人员Array[$i];
			$排班人员数据[$排班人员X] = $排班人员X;
		}
		$排班人员数据K = @array_keys($排班人员数据);
		$排班人员 = join(',',$排班人员数据K);
		//print_R($排班人员);
		//exit;

		$sql = "insert into hrms_salary values('','".$当前学期."','$当前月份','$年份','$费用类别','$费用名称','$排班人员','','$用户ID','$创建时间')";
		$db -> Execute($sql);
		print "<meta http-equiv='refresh' content=1;url='?当前月份=".$当前月份."'>";
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
		$排班人员 .= $排班人员信息_arr[1]."";
		if($i!=sizeof($name)-1)
		$排班人员 .= ",";
	}
	if($排班人员 == "")
	{
		$当前月份 = $_POST['当前月份'];
		print_infor("您没有选中任何成员",'',"location='?当前月份=$当前月份'");
		exit;
	}
	else
	{

		$当前学期 = $_POST['当前学期'];
		$当前月份 = $_POST['当前月份'];
		$费用类别 = $_POST['费用类别'];
		$费用名称 = $_POST['费用名称'];
        $年份=date("Y");
		$创建时间 = Date("Y-m-d H:i:s");

		$排班人员Array = explode(',',$排班人员);
		for($i=0;$i<sizeof($排班人员Array);$i++)		{
			$排班人员X = $排班人员Array[$i];
			$排班人员数据[$排班人员X] = $排班人员X;
		}
		$排班人员数据K = @array_keys($排班人员数据);
		$排班人员 = join(',',$排班人员数据K);
		//print_R($排班人员);
		//exit;
		//编号 排班编号 学期名称 学期名称 周次 周次 星期  考勤日期 班次编号 班次名称 班次名称 排班人员 排班人员 备注 备注 创建人 创建人 创建时间
		$sql = "select 编号 from hrms_salary where 学期名称='".$当前学期."' and 月份='".$当前月份."' and 费用名称='".$费用名称."'";
		$rs = $db -> Execute($sql);
		$编号 = $rs->fields['编号'];
		if($编号!="")		{
			$sql = "update hrms_salary set 月份='$当前月份',费用类别='$费用类别',费用名称='$费用名称',费用人员='$排班人员',年份='$年份' where 编号='$编号'";
		}
		else	{
			$sql = "insert into hrms_salary values('','".$当前学期."','".$当前月份."','".$年份."','".$费用类别."','".$费用名称."','".$排班人员."','','".$用户ID."','".$创建时间."')";
		}
		//print $sql;exit;
		$db -> Execute($sql);
		print "<meta http-equiv='refresh' content=1;url='?当前月份=".$当前月份."'>";
		exit;
	}
}


//*******************选择行政工作组的信息***************//
if($_GET['action'] == "ChangeTeam")
{
		$班组信息 = GetBanZuInfor();
		$当前学期 = $_GET['当前学期'];
		$当前月份 = $_GET['当前月份'];
		$费用类型 = $_GET['费用类型'];
		$费用名称 = $_GET['费用名称'];


?>
<table width="80%" class="TableBlock" align="center">
<form name="ChangeTeam" method="post" action="?action=Change&type=team">
<tr class="TableHeader">
<td>按组安排薪酬</td>
</tr>
<tr class="TableData">
<td>
&nbsp;<font color="red">当前学期:<?php echo $当前学期;?></font>&nbsp;<BR>


&nbsp;<font color="green">当前月份:<?php echo $当前月份;?></font>&nbsp;<BR>
&nbsp;<font color="blue">当前薪酬项目:<?php echo $费用名称;?>
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

		$组别名称 = $班组信息[$i]['组别名称'];
		if($i == 0)
			$Checked = "checked";
		else
			$Checked = "";
		print "<input type='radio' name='Team' value='".$班组编号."' $Checked>".$组别名称."</input><BR>";
	}

?>
<input type="hidden" name="当前月份" value=<?php echo $当前月份;?> />
<input type="hidden" name="当前学期" value=<?php echo $当前学期;?> />
<input type="hidden" name="费用类别" value=<?php echo $费用类别;?> />

<input type="hidden" name="费用名称" value=<?php echo $费用名称;?> />
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
		$当前月份 = $_GET['当前月份'];
		$费用类型 = $_GET['费用类型'];
		$费用名称 = $_GET['费用名称'];



		//形成已加入人员列表

		$sql = "select * from hrms_salary where 学期名称='".$当前学期."' and 月份='".$当前月份."' and 费用名称='".$费用名称."'";
		$rs = $db -> Execute($sql);
		$rs_a = $rs -> GetArray();
		$排班人员 = $rs_a[0]['费用人员'];
		$已有人员 = $排班人员;
		$排班人员数据K = explode(',',$排班人员);
?>

<table width="80%" class="TableBlock" align="center">
<form name="ChangeTeam" method="post" action="?action=Change&type=worker">
<tr class="TableHeader">
<td>按人员安排薪酬</td>
</tr>
<tr class="TableData">
<td><font color="red">&nbsp;当前学期:<?php echo $当前学期;?></font>&nbsp;<BR>&nbsp;<font color="green">当前月份:第<?php echo $当前月份;?>月</font>&nbsp;<BR>
&nbsp;<font color="blue">费用名称:<?php echo $费用名称;?>(<?php echo $费用类别;?>)</font>
<BR>&nbsp;<font color="blue">已有人员:<?php echo $已有人员;?></font>
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
				if(in_array($排班人员,$排班人员数据K))		{
					if($j!=sizeof($组员名称_arr)-1)
					{
						$SHOWTEXT .= "<input type='checkbox' name='name[]' checked value='".$组别名称."-".$组员名称_arr[$j]."' $Checked>".$组员名称_arr[$j]."-".$组别名称."</input>&nbsp;";
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
						$SHOWTEXT2 .= "<input type='checkbox' name='name[]' value='".$组别名称."-".$组员名称_arr[$j]."' $Checked>".$组员名称_arr[$j]."-".$组别名称."</input>&nbsp;";
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

	?>

<input type="hidden" name="当前学期" value=<?php echo $当前学期;?> />
<input type="hidden" name="当前月份" value=<?php echo $当前月份;?> />
<input type="hidden" name="费用类别" value=<?php echo $费用类别;?> />
<input type="hidden" name="费用名称" value=<?php echo $费用名称;?> />
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
<td>选择薪酬月份</td>
</tr>
<tr class="TableData">
<td>第&nbsp;
<?php
	$_GET['当前月份'] != "" ? '' : $_GET['当前月份'] = returncurmonthindex($datetime=date("Y-m-d"));
	$当前月份 = $_GET['当前月份'];


	for($i=0;$i<12;$i++)
	{
		if($i+1 == $当前月份)
		print "<a href='?当前月份=".($i+1)."' target='_self'><font color=red>".($i+1)."</font></a>&nbsp;&nbsp;";
		else
		print "<a href='?当前月份=".($i+1)."' target='_self'>".($i+1)."</a>&nbsp;&nbsp;";
	}
?>
    月<!--<a href="hrms_salary_.php">hello</a>--></td>
</tr>
</table>
<br />
<?php

	$当前月份 = $_GET['当前月份'];
	$上月月份 = $当前月份-1;
	$sql = "select * from hrms_salary where 月份='$上月月份' and 学期名称='$当前学期'";
	$rs = $db -> Execute($sql);
	$rs_a = $rs -> GetArray();
	//本周
	$sql = "select * from hrms_salary where 月份='$当前月份' and 学期名称='$当前学期'";
	$rs = $db -> Execute($sql);
	$rs_a本月 = $rs -> GetArray();

	if($_GET['action']=="从上月获取数据"&&$_GET['当前月份']!="")								{
		//print_R($rs_a);exit;
		for($i=0;$i<sizeof($rs_a);$i++)
		{
			$年份= $rs_a[$i]['年份'];
			$费用名称 = $rs_a[$i]['费用名称'];
            $费用类别 = $rs_a[$i]['费用类别'];

			$费用人员 = $rs_a[$i]['费用人员'];
			$备注 = $rs_a[$i]['备注'];
			$创建人 = $rs_a[$i]['创建人'];
			$创建时间 = date("Y-m-d H:i:s");;

			$费用人员数据 = array();
			$费用人员Array = explode(',',$费用人员);
			for($iX=0;$iX<sizeof($费用人员Array);$iX++)		{
				$排班人员X = $费用人员Array[$iX];
				$费用人员数据[$排班人员X] = $排班人员X;
			}
			$排班人员数据K = @array_keys($费用人员数据);
			$费用人员 = join(',',$排班人员数据K);
			//print_R($排班人员);
			//exit;
			//$sql = "select COUNT(*) AS NUM from edu_xingzheng_paiban where 学期名称='$当前学期' and 星期='$星期' and 考勤日期='$考勤日期' and 周次='$当前周次'";

			//$rs = $db -> Execute($sql);
			//$NUM = $rs->fields['NUM'];
			//if($NUM==0)	{
			$sql = "insert into hrms_salary values('','$当前学期','$当前月份','$年份','$费用类别','$费用名称','$费用人员','$备注','$创建人','$创建时间')";
			$db -> Execute($sql);
			//print $sql."<BR>";
			//}

		}
		print_infor("你的数据已经初始化完成.",'',"location='?当前月份=".$当前月份."'");
		print "<meta http-equiv='refresh' content=0;url='?当前月份=".$当前月份."'>";
		exit;
	}
	//exit;
	//print_R($rs_a);
	//本周有数据,或上周无数据,都会停止导入动作
	$m=date("m");
	if(sizeof($rs_a)==0||sizeof($rs_a本月)>0||$当前月份!=$m)		{
		//没有记录,不能获取数据
		$disabled = "disabled readonly title='本月已经有数据或上月无数据,不能从上月获取信息'";
	}
$qq="select * from hrms_salary_detail where 学期名称='$当前学期' and 月份='".$上月月份."'";
$qqrs = $db -> Execute($qq);
	$qqdata = $qqrs -> GetArray();
        if(sizeof($qqdata)==0&&sizeof($rs_a)>0)
            $able='';
            else
            $able = "disabled readonly title=''";
?>
<table width="100%" class="TableBlock" align="center">
<tr class="TableHeader">
<td colspan=2>
设置薪酬情况
当前月份: <?php echo $当前月份?>

<input name='从上月获取数据' value='从第<?php echo ($当前月份-1)?>月获取薪酬数据' class=SmallButton type=Button OnClick="location='?当前月份=<?php echo $当前月份?>&action=从上月获取数据'" <?php echo $disabled?>>
<input name='计算上个月薪酬' value='计算<?php echo ($当前月份-1)?>月薪酬数据' class=SmallButton type=Button OnClick="location='?当前月份=<?php echo $当前月份?>&action=计算上个月薪酬'" <?php echo $able?>>
</td>
</tr>
<tr class="TableData" align="center">
	<td width="20%">薪酬名称\月份</td>
	<td width="80%"><?php echo $当前月份?></td>

</tr>
<?php
	$薪酬项目信息 = GetBanCiInfor();
   // print_r($薪酬项目信息);
   //print sizeof($薪酬项目信息);
	for($i=0;$i<sizeof($薪酬项目信息);$i++)
	{
		$费用类别 = $薪酬项目信息[$i]['费用类别'];
        $费用名称 = $薪酬项目信息[$i]['费用名称'];

       // print_r($$薪酬项目信息[0]['费用类型']);
		$指定费用名称信息 = GetPaiBanInfor($当前学期,$当前月份,$费用名称);
       // print_r($指定费用名称信息);
		print "<tr class=TableData align=center>";
		print "<td>".$费用名称."(".$费用类别.")</td>";


			$排班数据 = explode("-",$指定费用名称信息);

			$排班编号 = $排班数据[0];
			$排班人员 = $排班数据[1];
          //  print $排班人员;
			print "<td>";
			if($当前月份==date("m"))		{
				if($排班人员=="")
				{
					print "<a href='?action=ChangeTeam&费用名称=".$费用名称."&费用类别=".$费用类别."&当前学期=".$当前学期."&当前月份=".$当前月份."'>选择工作组</a><br />
										   <a href='?action=ChangeWorker&费用名称=".$费用名称."&费用类别=".$费用类别."&当前学期=".$当前学期."&当前月份=".$当前月份."'>选择工作人员</a>";
				}
				else
				{
					$排班人员TEXT = substr_cut($排班人员,120);
					print "".$排班人员TEXT."<br /><a href='?action=Del&费用名称=".$费用名称."&排班编号=".$排班编号."&当前月份=".$当前月份."'><font color=red>删除</font><BR><a href='?action=ChangeWorker&费用名称=".$费用名称."&费用类别=".$费用类别."&当前学期=".$当前学期."&当前月份=".$当前月份."'>选择工作人员</a>";
				}
			}
			else	{
				print "<font color=gray>非工作时间</font>";
			}
			print "</td>";

		print "</tr>";
	}

?>
</table>
<?php

	//******************获取所有的人员信息********************//
	function GetWorkerInfor()
	{
		global $db;
		$sql = "select 编号,组别名称,组员名称 from hrms_salary_group order by 编号";
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
		$sql = "select 编号,组别名称,组员名称 from hrms_salary_group";
		$rs = $db -> Execute($sql);
		$rs_a = $rs -> GetArray();
		if(!is_array($rs_a))
		$rs_a = array();
		$班组信息 = $rs_a;
		return $班组信息;
	}
	//******************获得所有的薪酬项目信息********************//
	function GetBanCiInfor()
	{
		global $db;
		$sql = "select 费用类别,费用名称 from hrms_salary_type";
		$rs = $db -> Execute($sql);
		$rs_a = $rs -> GetArray();
		if(!is_array($rs_a))
		$rs_a = array();
		$薪酬项目信息 = $rs_a;
		return $薪酬项目信息;
	}
	//******************获得指定费用名称的薪酬项目信息********************//
	function GetPaiBanInfor($当前学期,$当前月份,$费用名称)
	{
		global $db;
		$sql = "select * from hrms_salary where 学期名称='".$当前学期."' and 月份=".$当前月份." and 费用名称='".$费用名称."'";
		$rs = $db -> Execute($sql);
		$rs_a = $rs -> GetArray();
		if(!is_array($rs_a))
		$rs_a = array();
		$排班信息 = $rs_a;
		for($i=0;$i<sizeof($排班信息);$i++)
		{
			$费用编号 = $排班信息[$i]['编号'];

			$费用名称 = $排班信息[$i]['费用名称'];
			$月份 = $排班信息[$i]['月份'];
			$费用类别 = $排班信息[$i]['费用类别'];
			$费用人员 = $排班信息[$i]['费用人员'];
			//$指定费用名称信息_ret[$费用类别][$费用名称][$月份] = $费用编号."-".$费用人员;
            $指定费用名称信息_ret= $费用编号."-".$费用人员;
		}
		return $指定费用名称信息_ret;
	}
		//返回当前月份
function returncurmonthindex(){
    $date=date("Y-m-d");
	$date=explode("-",$date);
	$month=$date[1];
	return $month;}


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




        function detail($y,$m){
global $db;
$sql="select 学期名称,月份,年份,费用类别,费用名称,费用人员,备注,创建人,创建时间 from hrms_salary where 月份='".$m."'and 年份='".$y."'";
$rs=$db->Execute($sql);
while (!$rs->EOF){
    $name=explode(',',$rs->fields['费用人员']);
   // print_r($name);print $rs->fields['费用名称'];
    if($rs->fields['费用名称'] != ''){
        $salary=$db->Execute("select 金额 from hrms_salary_type where 费用名称='".$rs->fields['费用名称']."'");
        while(!$salary->EOF){$money=$salary->fields['金额'];$salary->MoveNext();}$salary->Close();
    }

    for($i=0;$i<sizeof($name);$i++){
        $detailsql="insert into hrms_salary_detail(学期名称,月份,年份,费用类别,费用名称,金额,费用人员,备注,创建人,创建时间) values('".$rs->fields['学期名称']."',".$rs->fields['月份'].",".$rs->fields['年份'].",'".$rs->fields['费用类别']."','".$rs->fields['费用名称']."',".$money.",'".$name[$i]."','".$rs->fields['备注']."','".$rs->fields['创建人']."','".$rs->fields['创建时间']."')";
      // $db->Execute($detailsql);
	   if($db->Execute($detailsql)) {
		  // echo '<script>alert("success")</script>';
       $bmsql="select DEPT_NAME from department where DEPT_ID=(select DEPT_ID from user where USER_NAME='".$name[$i]."')";
      $bmrs=$db->Execute($bmsql);
        while(!$bmrs->EOF){$bm=$bmrs->fields['DEPT_NAME'];$bmrs->MoveNext();}$bmrs->Close();
        $num=$db->Execute("select * from hrms_salary_tongji where 姓名='".$name[$i]."' and 年份='".$y."'");
        $num=$num->RecordCount();
                 if($num==0){
				 if($m==1)
       $sql="insert into hrms_salary_tongji(所属部门,姓名,年份,一月) values('".$bm."','".$name[$i]."','".$y."','".$money."')";
        if($m==2)
       $sql="insert into hrms_salary_tongji(所属部门,姓名,年份,二月) values('".$bm."','".$name[$i]."','".$y."','".$money."')";
         if($m==3)
       $sql="insert into hrms_salary_tongji(所属部门,姓名,年份,三月) values('".$bm."','".$name[$i]."','".$y."','".$money."')";
          if($m==4)
       $sql="insert into hrms_salary_tongji(所属部门,姓名,年份,四月) values('".$bm."','".$name[$i]."','".$y."','".$money."')";
 if($m==5)
       $sql="insert into hrms_salary_tongji(所属部门,姓名,年份,五月) values('".$bm."','".$name[$i]."','".$y."','".$money."')";
 if($m==6)
       $sql="insert into hrms_salary_tongji(所属部门,姓名,年份,六月) values('".$bm."','".$name[$i]."','".$y."','".$money."')";
 if($m==7)
       $sql="insert into hrms_salary_tongji(所属部门,姓名,年份,七月) values('".$bm."','".$name[$i]."','".$y."','".$money."')";
 if($m==8)
       $sql="insert into hrms_salary_tongji(所属部门,姓名,年份,八月) values('".$bm."','".$name[$i]."','".$y."','".$money."')";
 if($m==9)
       $sql="insert into hrms_salary_tongji(所属部门,姓名,年份,九月) values('".$bm."','".$name[$i]."','".$y."','".$money."')";
 if($m==10)
       $sql="insert into hrms_salary_tongji(所属部门,姓名,年份,十月) values('".$bm."','".$name[$i]."','".$y."','".$money."')";
 if($m==11)
       $sql="insert into hrms_salary_tongji(所属部门,姓名,年份,十一月) values('".$bm."','".$name[$i]."','".$y."','".$money."')";
 if($m==12)
       $sql="insert into hrms_salary_tongji(所属部门,姓名,年份,十二月) values('".$bm."','".$name[$i]."','".$y."','".$money."')";


				 }
				 else{
				  if($m==1)
        $sql="update hrms_salary_tongji set 一月=一月+'".$money."' where 姓名='".$name[$i]."' and 年份='".$y."'";
           if($m==2)
        $sql="update hrms_salary_tongji set 二月=二月+'".$money."' where 姓名='".$name[$i]."' and 年份='".$y."'";

           if($m==3)
        $sql="update hrms_salary_tongji set 三月=三月+'".$money."' where 姓名='".$name[$i]."' and 年份='".$y."'";
            if($m==4)
        $sql="update hrms_salary_tongji set 四月=四月+'".$money."' where 姓名='".$name[$i]."' and 年份='".$y."'";
            if($m==5)
        $sql="update hrms_salary_tongji set 五月=五月+'".$money."' where 姓名='".$name[$i]."' and 年份='".$y."'";
           if($m==6)
        $sql="update hrms_salary_tongji set 六月=六月+'".$money."' where 姓名='".$name[$i]."' and 年份='".$y."'";
           if($m==7)
        $sql="update hrms_salary_tongji set 七月=七月+'".$money."' where 姓名='".$name[$i]."' and 年份='".$y."'";
           if($m==8)
        $sql="update hrms_salary_tongji set 八月=八月+'".$money."' where 姓名='".$name[$i]."' and 年份='".$y."'";
           if($m==9)
        $sql="update hrms_salary_tongji set 九月=九月+'".$money."' where 姓名='".$name[$i]."' and 年份='".$y."'";
           if($m==10)
        $sql="update hrms_salary_tongji set 十月=十月+'".$money."' where 姓名='".$name[$i]."' and 年份='".$y."'";
           if($m==11)
        $sql="update hrms_salary_tongji set 十一月=十一月+'".$money."' where 姓名='".$name[$i]."' and 年份='".$y."'";
           if($m==12)
        $sql="update hrms_salary_tongji set 十二月=十二月+'".$money."' where 姓名='".$name[$i]."' and 年份='".$y."'";

				 }
				 $db->Execute($sql);
	   } //if

    }//for循环结束


    $rs->MoveNext();
}//while循环结束
$rs->Close();

 echo '<script>alert("计算完成！")</script>';
}//function结束

?>
