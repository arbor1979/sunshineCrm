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
validateMenuPriv("销售合同");
	if($_GET['action']=="add_default_data")
	{
		$_POST['billtype']=1;
	}
	
	if($_GET['action']=="begindo")
	{
		$billid=$_GET['billid'];
		$sql="update sellplanmain set user_flag=1 where billid=$billid";
		$db->Execute($sql);
	}
	if($_GET['action']=="jiaofuplan")
	{
		$billid=$_GET['billid'];
		print "<script>location.href='sellcontract_plan_newai.php?action=add_default&billid=$billid';</script>";
		exit;
	}
	//删除合同
if($_GET['action']=="delete_array")			
{
	$selectid=$_GET['selectid'];
	$selectid=explode(",", $selectid);
	try 
	{
		//开启事务
	    $db->StartTrans();  
		for($i=0;$i<sizeof($selectid);$i++)
		{
			if($selectid[$i]!="")
			{
					
				$billid=$selectid[$i];
				$sql="delete from sellplanmain where billid=$billid and user_flag=0";
				$db->Execute($sql);
		
			}

		}
		$db->CompleteTrans();
		//是否事务出现错误
		page_css("");
		if ($db->HasFailedTrans()) 
			throw new Exception($db->ErrorMsg());
		else 
		{ 
			$return=FormPageAction("action","init_default");
			print_infor("合同已撤销",'trip',"location='?$return'","?$return",0);
		}
    	
	}
	catch(Exception $e)
	{
		print "<script language=javascript>alert('错误：".$e->getMessage()."');window.history.back(-1);</script>";
	}
	exit;	
}
	$realtablename="sellplanmain";
	
addShortCutByDate("plandate","有效期起始","最近三月");
$SYSTEM_ADD_SQL =getCustomerRoleByCustID($SYSTEM_ADD_SQL,"supplyid");
$limitEditDelCust='supplyid';
$filetablename = "v_sellcontract";
$parse_filename	="sellcontract";
require_once( "include.inc.php" );
systemhelpcontent( "销售合同", "100%" );

?>
