<?php
ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL);

// display warnings and errors
error_reporting(E_WARNING | E_ERROR);
//######################教育组件-权限较验部分##########################
SESSION_START();
require_once("lib.inc.php");
$GLOBAL_SESSION=returnsession();
require_once("systemprivateinc.php");
validateMenuPriv("部门管理");
//CheckSystemPrivate("系统信息设置-组织机构设置");
//######################教育组件-权限较验部分##########################


	/*
	if($_GET['action']=="add_default_data")		{
		//print_R($_GET);print_R($_POST);//exit;
		global $db;
		$入库数量 = (int)$_POST['入库数量'];$教材编号 = $_POST['教材编号'];
		$sql = "update edu_jiaocai set 现有库存=现有库存+$入库数量 where 教材编号='".$教材编号."'";
		$rs = $db->Execute($sql);//print $sql;exit;
		$_POST['编作者'] = returntablefield("edu_jiaocai","教材编号",$教材编号,"编作者");
		$_POST['出版社'] = returntablefield("edu_jiaocai","教材编号",$教材编号,"出版社");
		//print  "<META HTTP-EQUIV=REFRESH CONTENT='0;URL=?'>";
	}
	*/
	//自动较验数据库表格式
	$Columns = $db->MetaColumns("department");
	if($Columns['DEPT_ID']->primary_key!=1)				{
		//$sql = "ALTER TABLE `department` ADD PRIMARY KEY ( `DEPT_ID` ) ";
		//$db->Execute($sql);
	};
	if($Columns['DEPT_ID']->auto_increment!=1)				{
		//$sql = "ALTER TABLE `department` CHANGE `DEPT_ID` `DEPT_ID` INT( 11 ) NOT NULL AUTO_INCREMENT ";
		//$db->Execute($sql);
	};

	if($_GET['action']=="delete_array")			
	{
		$selectid=$_GET['selectid'];
		$selectid=explode(",", $selectid);
		for($i=0;$i<sizeof($selectid);$i++)
		{
			
			if($selectid[$i]!="")
			{
				$user_id=returntablefield("user", "dept_id", $selectid[$i], "user_id");
				if($user_id!='')
				{
					print "<script language=javascript>alert('此部门下存在用户，请先删除用户');window.history.back(-1);</script>";
	    			exit;
				}
				$dept_id=returntablefield("department", "dept_parent", $selectid[$i], "dept_id");
				if($dept_id!='')
				{
					print "<script language=javascript>alert('此部门下存在子部门，请先删除子部门');window.history.back(-1);</script>";
	    			exit;
				}
			}
		}
	}

	//$SYSTEM_PRINT_SQL  = 1;
	//数据表模型文件,对应Model目录下面的department_newai.ini文件
	//如果是需要复制此模块,则需要修改$parse_filename参数的值,然后对应到Model目录 新文件名_newai.ini文件
	$filetablename		=	'department';
	$parse_filename		=	'department';
	require_once('include.inc.php');
	?><?php
/*
	版权归属:郑州单点科技软件有限公司;
	联系方式:0371-69663266;
	公司地址:河南郑州经济技术开发区第五大街经北三路通信产业园四楼西南;
	公司简介:郑州单点科技软件有限公司位于中国中部城市-郑州,成立于2007年1月,致力于把基于先进信息技术（包括通信技术）的最佳管理与业务实践普及到教育行业客户的管理与业务创新活动中，全面提供具有自主知识产权的教育管理软件、服务与解决方案，是中部最优秀的高校教育管理软件及中小学校管理软件提供商。目前己经有多家高职和中职类院校使用通达中部研发中心开发的软件和服务;

	软件名称:单点科技软件开发基础性架构平台,以及在其基础之上扩展的任何性软件作品;
	发行协议:数字化校园产品为商业软件,发行许可为LICENSE方式;单点CRM系统即SunshineCRM系统为GPLV3协议许可,GPLV3协议许可内容请到百度搜索;
	特殊声明:软件所使用的ADODB库,PHPEXCEL库,SMTARY库归原作者所有,余下代码沿用上述声明;
	*/
?>