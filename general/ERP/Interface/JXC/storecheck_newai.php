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

require_once( "lib.inc.php" );
$sessionkey = returnsesskey( );
$GLOBAL_SESSION = returnsession( );
$SUNSHINE_USER_NAME = $_SESSION['SUNSHINE_USER_NAME'];
validateMenuPriv("库存盘点单");
//只有此仓库管理员才能创建盘点单
if($_GET['action']=="add_default_data")			
{
	$_POST['billid']=returnAutoIncrementUnitBillid("storecheckbillid");
}
if($_GET['action']=="edit_default2")			
{
print "<script>location='DataQuery/productFrame.php?tablename=storecheck_detail&deelname=库存盘点差异&rowid=".$_GET['billid']."'</script>";
exit;
}
if($_GET['action']=="generalStock")
{
	//开启事务
    try {
	    	$db->StartTrans();  
		    	//$db->debug=true;
	   		$Store=new Store($db);
	   		$Store->insertStoreCheck($_GET['billid']);
	    		//是否事务出现错误
			if ($db->HasFailedTrans()) 
			 	print "<script language=javascript>alert('错误：".str_replace("'",  "\'", $db->ErrorMsg())."');window.history.back(-1);</script>";
	    	else 
			{ 
				page_css("");
				$return=FormPageAction("action","init_default");
				print_infor("已生成出入库单，等待库管确认",'trip',"location='?$return'","?$return",0);
			}
			$db->CompleteTrans();
	    	exit;
    	}
    	catch (Exception $e)
		{
			print "<script language=javascript>alert('错误：".$e->getMessage()."');window.history.back(-1);</script>";
    		exit;
		} 
}
//撤销盘点单
if($_GET['action']=="delete_array")			
{
	$selectid=$_GET['selectid'];
	$selectid=explode(",", $selectid);
	try 
	{
		//开启事务
		$Store=new Store($db);
	    $db->StartTrans();  
		for($i=0;$i<sizeof($selectid);$i++)
		{
			if($selectid[$i]!="")
				$Store->deleteStoreCheck($selectid[$i]);
		}
		//是否事务出现错误
		if ($db->HasFailedTrans()) 
		 	print "<script language=javascript>alert('错误：".str_replace("'",  "\'", $db->ErrorMsg())."');window.history.back(-1);</script>";
		else 
		{ 
			page_css("盘点单删除");
			$return=FormPageAction("action","init_default");
			print_infor("盘点单已成功删除",'trip',"location='?$return'","?$return",0);
		}
    	$db->CompleteTrans();
		exit;	
	}
	catch(Exception $e)
	{
		print "<script language=javascript>alert('错误：".$e->getMessage()."');window.history.back(-1);</script>";
    	exit;
	}
	
}
addShortCutByDate("createtime","创建时间");
$SYSTEM_ADD_SQL=getKucunByUserid($SYSTEM_ADD_SQL,$_SESSION['LOGIN_USER_ID']);
$filetablename = "storecheck";
require_once( "include.inc.php" );
systemhelpContent("库存盘点单说明",'100%');
?>
