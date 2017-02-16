<?php
/*
 版权归属:郑州单点科技软件有限公司;
 联系方式:0371-69663266;
 公司地址:河南郑州经济技术开发区第五大街经北三路通信产业园四楼西南;
 公司简介:郑州单点科技软件有限公司位于中国中部城市-郑州,成立于2007年1月,致力于把基于先进信息技术（包括通信技术）的最佳管理与业务实践普及到教育行业客户的管理与业务创新活动中，全面提供具有自主知识产权的教育管理软件、服务与解决方案，是中部最优秀的高校教育管理软件及中小学校管理软件提供商。目前己经有多家高职和中职类院校使用通达中部研发中心开发的软件和服务;

 软件名称:单点科技软件开发基础性架构平台,以及在其基础之上扩展的任何性软件作品;
 发行协议:数字化校园产品为商业软件,发行许可为LICENSE方式;单点CRM系统即SunshineCRM系统为GPLV3协议许可,GPLV3协议许可内容请到百度搜索;
 特殊声明:软件所使用的ADODB库,PHPEXCEL库,SMTARY库归原作者所有,余下代码沿用上述声明;
 */
ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL);
error_reporting(E_WARNING | E_ERROR);
require_once('lib.inc.php');
$GLOBAL_SESSION=returnsession();

//print_r($_GET);exit;
validateMenuPriv("客户基本信息");
if($_GET['action']=="add_default")
	$ADDINIT=array("sysuser"=>$_SESSION['LOGIN_USER_ID']);
if($_GET['action']=="edit_default_data"||$_GET['action']=="add_default_data")		{
	if($_POST['amtagio']<=0 || $_POST['amtagio']>1)
	{
		$_POST['amtagio']=1;
	}
	$rowid=returntablefield("customer","supplyname", $_POST['supplyname'], "ROWID","phone",$_POST['phone']);
	if($rowid!='' && $rowid!=$_GET['ROWID'])
	{
		print "<script language='javascript'>alert('客户名称和电话已存在');window.history.back(-1);</script>";
		exit;
	}
	if($_POST['membercard']!='')
	{
		$rowid=returntablefield("customer","membercard", $_POST['membercard'], "ROWID");
		if($rowid!='' && $rowid!=$_GET['ROWID'])
		{
			print "<script language='javascript'>alert('会员卡号已存在');window.history.back(-1);</script>";
			exit;
		}
	}

	$_POST['calling'] = 汉字转拼音首字母($_POST['supplyname']);
	if(trim($_POST['tuihuorate'])!='')
	{
		$tuihuorate=intval($_POST['tuihuorate']);
		if($tuihuorate<0 || $_POST['tuihuorate']>100)
		{
			print "<script language='javascript'>alert('退货率必须在0-100之间');window.history.back(-1);</script>";
			exit;
		}
	}
	
}


if($_GET['action']=="operation_yijiao")	{
	validateMenuPriv("客户移交");
	$selectid=explode(",",$_GET['selectid']);
	try 
	{
		for($i=0;$i<count($selectid);$i++)
		{
			if($selectid[$i]!='')
			{
				if(!ifHasRoleCust($selectid[$i]))
				{
					$custname=returntablefield("customer","rowid", $selectid[$i], "supplyname");
					throw new Exception("你没有权限移交客户：$custname");
				}
			
			}
		}
		print "<script>location.href='../CRM/inc_crm_tools.php?action=add_yijiao&custlist=".$_GET['selectid']."';</script>";
		exit;
		
	}
	catch (Exception $e)
	{
		print "<script language='javascript'>alert('发生错误：".$e->getMessage()."');window.history.back(-1);</script>";
		exit;
	}
	
	
	
}
if($_GET['action']=="delete_array")
{
	$selectid=explode(",",$_GET['selectid']);
	
	if($_SESSION['LOGIN_USER_PRIV']=='3')
	{
		for($i=0;$i<count($selectid);$i++)
		{
			if($selectid[$i]!='')
			{
				$sql="update customer set datascope=-1 where rowid=".$selectid[$i];
				$db->Execute($sql);
			}
		}
		$return=FormPageAction("action","init_default");
		print_infor("客户资料已删除",'trip',"location='?$return'","?$return",0);
		exit;
	}
	for($i=0;$i<count($selectid);$i++)
	{
		if($selectid[$i]!='')
		{
			$billid=returntablefield("sellplanmain", "supplyid", $selectid[$i], "billid");
			if($billid!='')
			{
				$customername=returntablefield("customer", "rowid", $selectid[$i], "supplyname");
				print "<script language='javascript'>alert('".$customername." 存在合同或销售单记录，请先删除相关单据');window.history.back(-1);</script>";
				exit;
			}
		

		}
	}

}
if($_GET['action']=="addlinkman")
{
	print "<script>location.href='linkman_newai.php?action=add_default&customerid=".$_GET['ROWID']."';</script>";
	exit;
}
if($_GET['action']=="addcrmvisit")
{
	print "<script>location.href='crm_contact_newai.php?action=add_default&customerid=".$_GET['ROWID']."';</script>";
	exit;
}

$SYSTEM_ADD_SQL=getCustomerRoleByUser($SYSTEM_ADD_SQL,"sysuser");

$limitEditDelUser='sysuser';
addShortCutByDate("createdate","创建时间");
//print_r($_SESSION);
//$SYSTEM_ADD_SQL = " and ((sysuser='".$_SESSION['LOGIN_USER_ID']."' and datascope=0) or datascope=1)";
//$SYSTEM_PRINT_SQL=1;
$filetablename = "customer";
require_once( "include.inc.php" );
systemhelpcontent( "客户管理", "100%" );

?>
