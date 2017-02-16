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
	
		validateMenuPriv("客户联系人");
$customerid=$_GET['customerid'];
if($customerid!='' && $_GET['action']=='add_default')
{
	$ADDINIT=array("customerid"=>$customerid);
}
if($_GET['action']=='add_default_data' || $_GET['action']=='edit_default_data')
{
	
	$_POST['linkmanpy'] = 汉字转拼音首字母($_POST['linkmanname']);


	if($_POST['birthday'] !=""){   //生日不为空，生成客户纪念日
			    global $db;
				$type="客户生日";
				$linkmanid = $_REQUEST['ROWID'];
				$customerid = $_POST['customerid'];
				$date=$_POST['birthday'];
				$createtime=date('Y-m-d H:i:s');
				$createman=$_SESSION['LOGIN_USER_ID'];
				$sql="select count(*) as num from crm_remember where mem_type='客户生日' and linkmanid=".$linkmanid;
				$rs = $db->Execute($sql);
				$rs_a = $rs->GetArray();
				$maxid=returnAutoIncrement("id","crm_remember");
				if($rs_a[0][num]=='0' ) {
					$sql="insert into crm_remember(id,mem_type,linkmanid,customerid,mem_date,createtime,operman) values($maxid,'".$type."','".$linkmanid."','".$customerid."','".$date."','".$createtime."','".$createman."')";
					$db->Execute($sql);
				}
				else{
				    $sql="update crm_remember set mem_date='".$date."',operman='".$createman."' where mem_type='客户生日' and linkmanid=".$linkmanid;
				    $db->Execute($sql);
				}
	}

}
if($_GET['action']=='operation_sendsms')
{
	validateMenuPriv("手机短信");
	$selectid=$_GET['selectid'];
	print "<script>location='sms_sendlist_newai.php?action=add_default&sendlist=".$selectid."&fromsrc=customer';</script>";
	exit;
	
}
if($_GET['action']=='operation_sendemail')
{
	validateMenuPriv("发送邮件");
	$selectid=$_GET['selectid'];
	print "<script>location='../CRM/email_newai.php?action=add_default&sendlist=".$selectid."&fromsrc=customer';</script>";
	exit;
	
}
if($_GET['action']=='operation_printKuaiDi')
{
	
	$selectid=$_GET['selectid'];
	print "<script>
	location.href='../CRM/printKuaiDi.php?CustOrSupply=customer&linkmanlist=$selectid',null,'height=600,width=855,status=1,toolbar=no,menubar=no,location=no,scrollbars=yes,resizable=yes';
	</script>";
	exit;
	
}
$SYSTEM_ADD_SQL =getCustomerRoleByCustID($SYSTEM_ADD_SQL,"customerid");

$limitEditDelCust='customerid';
$filetablename = "linkman";
require_once( "include.inc.php" );
?>
