<?php

	require_once('lib.inc.php');



	$GLOBAL_SESSION=returnsession();
$SYSTEM_PRIV_STOP = 1;
	require_once("systemprivateinc.php");
	CheckSystemPrivate("人力资源-干部测评-测评项目管理");


	if($_GET['action']=="add_default_data"||$_GET['action']=="edit_default_data")				{

		//print_R($_GET);print_R($_POST);//exit;
		//初始化人员信息
		$被测评人员
 = $_POST['被测评人员'];
		$测评名称 = $_POST['测评名称'];
		$被测评人员Array = explode(',',$被测评人员);
		/*
		DROP TABLE IF EXISTS `edu_zhongcengrenyuan`;
		CREATE TABLE IF NOT EXISTS `edu_zhongcengrenyuan` (
		  `编号` int(33) NOT NULL auto_increment,
		  `测评名称` varchar(200) NOT NULL default '',
		  `被评人员` varchar(200) NOT NULL default '',
		  `单位` varchar(200) NOT NULL default '',
		  `职务` varchar(200) NOT NULL default '',
		  `品德描述` mediumtext NOT NULL default '',
		  `品德自述` mediumtext NOT NULL default '',
		  `能力描述` mediumtext NOT NULL default '',
		  `能力自述` mediumtext NOT NULL default '',
		  `勤奋描述` mediumtext NOT NULL default '',
		  `勤奋自述` mediumtext NOT NULL default '',
		  `绩效描述` mediumtext NOT NULL default '',
		  `绩效自述` mediumtext NOT NULL default '',
		  `廉政描述` mediumtext NOT NULL default '',
		  `廉政自述` mediumtext NOT NULL default '',
		  PRIMARY KEY  (`编号`)
		) ENGINE=MyISAM DEFAULT CHARSET=gbk COMMENT='中层干部被评人员明细' AUTO_INCREMENT=1 ;

		*/		//已经有教师名单
		$sql = "select * from edu_zhongcengrenyuan where 测评名称='$测评名称'";
		$rs = $db->Execute($sql);
		$rs_a = $rs->GetArray();
		$已经有教师名单 = array();
		for($i=0;$i<sizeof($rs_a);$i++)		{
			$已经有教师名单[] = $rs_a[$i]['被评人员'];
		}
		//新增加的名单
		$新增加的人员名单 = $被测评人员Array;
		for($i=0;$i<sizeof($新增加的人员名单);$i++)		{
			$单个被测评人员 = $新增加的人员名单[$i];
		}
		$原有数组中不存在部分 = @array_diff($已经有教师名单,$新增加的人员名单);
		$原有数组中不存在部分 = @array_values($原有数组中不存在部分);
		//print_R($已经有教师名单);
		//print_R($新增加的人员名单);
		//print_R($原有数组中不存在部分);

		//删除本次去除的人员
		for($i=0;$i<sizeof($原有数组中不存在部分);$i++)		{
			$被去除人员 = $原有数组中不存在部分[$i];
			$sql = "delete from edu_zhongcengrenyuan where  测评名称='$测评名称' and 被评人员='$被去除人员'";
			$rs = $db->Execute($sql);;
			//print $sql;
		}

		//增加新增加的人员
		for($i=0;$i<sizeof($新增加的人员名单);$i++)		{
			$被评人员 = $新增加的人员名单[$i];
			$sql = "select * from edu_zhongcengrenyuan where  测评名称='$测评名称' and 被评人员='$被评人员'";
			$rs = $db->Execute($sql);;
			if($rs->RecordCount()==0&&$被评人员!='')		{
				$DEPT_ID = returntablefield("user","USER_NAME",$被评人员,"DEPT_ID");
				$USER_PRIV = returntablefield("user","USER_NAME",$被评人员,"USER_PRIV");
				$单位 = returntablefield("department","DEPT_ID",$DEPT_ID,"DEPT_NAME");
				$职务 = returntablefield("user_priv","USER_PRIV",$USER_PRIV,"PRIV_NAME");
				$sql = "insert into edu_zhongcengrenyuan(测评名称,被评人员,单位,职务) values('$测评名称','$被评人员','$单位','$职务');";
				$db->Execute($sql);
				//print $sql."<BR>";
			}
		}
		//exit;
		//global $db;

		$是否有效 = $_POST['是否有效'];
		if($是否有效==1)		{
			$sql = "update edu_zhongcengceping set 是否有效='0'";
			$db->Execute($sql);
		}

		//$教材编号 = $_POST['教材编号'];

		//$sql = "update edu_jiaocai set 现有库存=现有库存+$入库数量 where 教材编号='".$教材编号."'";

		//$rs = $db->Execute($sql);

		//print $sql;exit;

		//$_POST['编作者'] = returntablefield("edu_jiaocai","教材编号",$教材编号,"编作者");

		//$_POST['出版社'] = returntablefield("edu_jiaocai","教材编号",$教材编号,"出版社");

	}

	if($_GET["action"]=="edit_default_data"){
		//print_R($_POST);exit;
		if($_POST['测评名称_原始值']!=$_POST['测评名称']){
			$sql = "update edu_zhongcengrenyuan set 测评名称='".$_POST['测评名称']."' where 测评名称='".$_POST['测评名称_原始值']."'";
			$db->Execute($sql);

			$sql = "update edu_zhongcengmingxi set 测评名称='".$_POST['测评名称']."' where 测评名称='".$_POST['测评名称_原始值']."'";
			$db->Execute($sql);
		}
	}






	$filetablename='edu_zhongcengceping';

	require_once('include.inc.php');


	?>