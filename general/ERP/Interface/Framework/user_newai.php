<?php
ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL);

// display warnings and errors
error_reporting(E_WARNING | E_ERROR);
//######################教育组件-权限较验部分##########################
require_once("lib.inc.php");
$GLOBAL_SESSION=returnsession();
$SYSTEM_PRIV_STOP = 1;
require_once("systemprivateinc.php");
validateMenuPriv("用户管理");
//CheckSystemPrivate("系统信息设置-组织机构设置");
//######################教育组件-权限较验部分##########################


if($_GET['action']=='operation_sendsms')
{
	validateMenuPriv("手机短信");
	$selectid=$_GET['selectid'];
	print "<script>location.href='../JXC/sms_sendlist_newai.php?action=add_default&fromsrc=user&sendlist=".$selectid."'</script>";
	exit;
	
}
if($_GET['action']=='operation_menubatch')
{
	$_GET['action']="edit_purview";
}

if($_GET['action']=="delete_array")			
{
	$selectid=$_GET['selectid'];
	$selectid=explode(",", $selectid);
	for($i=0;$i<sizeof($selectid);$i++)
	{
		
		if($selectid[$i]!="")
		{
			$userid=returntablefield("user", "uid", $selectid[$i], "user_id");
			$rowid=returntablefield("customer", "sysuser", $userid, "rowid");
			if($rowid!='')
			{
				print "<script language=javascript>alert('有客户隶属于此用户，请先移交客户资料');window.history.back(-1);</script>";
    			exit;
			}
			
		}
	}
}

	if($_GET['action']=="add_default_data")		{
		global $db;
		$_POST['PASSWORD']	= crypt("");
		$_POST['USER_ID']	=trim($_POST['USER_ID']);
		$_POST['USER_NAME']	=trim($_POST['USER_NAME']);
		$_POST['THEME']		= '3';
	}

	if($_GET['action']=="operation_clearpassword"&&$_GET['selectid']!="")				{
		$PASSWORD	= crypt("");
		$selectidArray = explode(',',$_GET['selectid']);
		$TempValue = sizeof($selectidArray)-2;
		for($i=0;$i<sizeof($selectidArray);$i++)			{
			$selectidValue = $selectidArray[$i];
			if($selectidValue!="")				{
				$sql = "update user set PASSWORD='$PASSWORD' where UID='$selectidValue'";
				$db->Execute($sql);
			}
		}
		page_css("您的操作己成功");
		print_infor("您的操作己成功,请返回....",'',"location='?'","?");
		exit;
	}



	//数据表模型文件,对应Model目录下面的user_newai.ini文件
	//如果是需要复制此模块,则需要修改$parse_filename参数的值,然后对应到Model目录 新文件名_newai.ini文件
	$filetablename		=	'user';
	$parse_filename		=	'user';
	$SYSTEM_ADD_SQL=getRoleByUser($SYSTEM_ADD_SQL,"user_id");
	require_once('include.inc.php');
	systemhelpContent("系统用户管理",'100%');
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