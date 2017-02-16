<?php
	require_once('lib.inc.php');

	$GLOBAL_SESSION=returnsession();
$SYSTEM_PRIV_STOP = 1;
	require_once("systemprivateinc.php");
	CheckSystemPrivate("人力资源-行政考勤-流程明细");
	$当前学期 = returntablefield("edu_xueqiexec","当前学期",'1',"学期名称");
	if($_GET['学期']=="") $_GET['学期'] = $当前学期;



	if($_GET['action']=="add_default_data")			{
		$_POST['人员用户名'] =  $_POST['人员_ID'];
		$DEPT_ID =  returntablefield("user","USER_ID",$_POST['人员_ID'],"DEPT_ID");
		$_POST['部门'] =  returntablefield("department","DEPT_ID",$DEPT_ID,"DEPT_NAME");
		//print_R($_POST);exit;
	}

//批量通过审核操作
if($_GET['action']=="operation_piliangtongguo"&&$_GET['selectid']!="")			{
	//print_R($_GET);exit;
	//print_R($_SESSION);
	$审核人 = $_SESSION['LOGIN_USER_NAME'];
	$审核时间=date('Y-m-d H:i:s');

	$Array = explode(',',$_GET['selectid']);
	//PRINT_r($Array);EXIT;
	for($i=0;$i<sizeof($Array);$i++)	{
		$Element = $Array[$i];
		if($Element!="")		{
			$审核状态 = returntablefield("edu_xingzheng_kaoqinbudeng","编号",$$Element,"审核状态");
			if($审核状态!=1){
			$sql = "update edu_xingzheng_kaoqinbudeng set 审核状态='1',审核人='$审核人',审核时间='$审核时间' where 编号='$Element'";
			$rs = $db->Execute($sql);
			
			$sql = "select * from edu_xingzheng_kaoqinbudeng where 编号='$Element' and 审核状态 =1";
			$rs = $db->Execute($sql);
			$rs_a=$rs->GetArray();
			$时间 = $rs_a[0]['时间'];
			$班次 = $rs_a[0]['班次'];
			$补登项目 = $rs_a[0]['补登项目'];
			$人员用户名 = $rs_a[0]['人员用户名'];
			//print_R($rs_a);exit;           编号  学期  部门  人员  日期  周次  星期  班次  上班实际刷卡   

			if($补登项目 == '上班考勤补登')	
			{
				$query = "update edu_xingzheng_kaoqinmingxi set 上班考勤状态='考勤补登' where 日期='$时间' and 班次='$班次' and 人员用户名='$人员用户名'  ";
			}
			else
			{
			$query = "update edu_xingzheng_kaoqinmingxi set 下班考勤状态='考勤补登' where 日期='$时间' and 班次='$班次' and 人员用户名='$人员用户名'  ";
			}
			

			$db->Execute($query);
			}
		}
	}
	$pageid = $_GET['pageid'];
	page_css("考勤补登审批");
	print_nouploadfile("你的数据操作已经成功!");
	echo "<META HTTP-EQUIV=REFRESH CONTENT='0;URL=?pageid=$pageid'>\n";
	exit;
}



	$filetablename='edu_xingzheng_kaoqinbudeng';
	require_once('include.inc.php');
	//功能性说明注释
	require_once("../Help/module_xingzhengworkflow.php");
	?>