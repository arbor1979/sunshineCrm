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

$isBase64 = isbase64( );
$isBase64 == 1 ? checkbase64( ) : "";
validateMenuPriv("出库单");
if($_GET['action']=="edit_default2")			
{
	$outtype=returntablefield("stockoutmain","billid", $_GET['billid'], "outtype");
	if($outtype=="销售出库")
	{
		print "<script>location='stockoutmain_chuku.php?rowid=".$_GET['billid']."'</script>";
		exit;
	}
	else
	{
		$_GET['action']="savechuku";
		$_GET['rowid']=$_GET['billid'];
	}
}

if($_GET['action']=="savechuku")			
{
	$rowid=$_GET['rowid'];
	try 
	{
		$Store=new Store($db);
		//$db->debug=1;
		 //开启事务
	    $db->StartTrans();  
	    //确认出库
		$Store->confirmChuKu($rowid);
		$outtype=returntablefield("stockoutmain","billid",$rowid,"outtype");
		if($outtype=="销售出库" || $outtype=="返厂出库")
		{
	    	//创建发货单
	    	$Store->insertFaHuo($rowid);
		}
		//是否事务出现错误
		if ($db->HasFailedTrans()) 
		{
		 	print "<script language=javascript>alert('错误：".str_replace("'",  "\'", $db->ErrorMsg())."');window.history.back(-1);</script>";
		}
		else 
		{ 
			page_css("出库单确认");
			$return=FormPageAction("action","init_default");
			print_infor("出库单已确认",'trip',"location='?$return'","?$return",0);			
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
//撤销出库
if($_GET['action']=="delete_array")			
{
	$selectid=$_GET['selectid'];
	$selectid=explode(",", $selectid);
	try 
	{
		$Store=new Store($db);
		//开启事务
		//$db->debug=1;
	    $db->StartTrans();  
	    
		for($i=0;$i<sizeof($selectid);$i++)
		{
			if($selectid[$i]!="")
			{
				$Store->deleteChuKu($selectid[$i]);				
			}
		}
		//是否事务出现错误
		if ($db->HasFailedTrans()) 
		{
		 	print "<script language=javascript>alert('错误：".str_replace("'",  "\'", $db->ErrorMsg())."');window.history.back(-1);</script>";
		}
		else 
		{ 
			page_css("出库单删除");
			$return=FormPageAction("action","init_default");
			print_infor("出库单已成功删除",'trip',"location='?$return'","?$return",0);
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
if($_GET['action']=="edit_default3")		
{
	print "<script>location='fahuodan_queren.php?billid=".$_GET['billid']."&url=".$_SERVER["PHP_SELF"]."'</script>";
	exit;	
}
if($_GET['action']=="getallcolor")		
{
	global $db;
	$sql="select sum(num) as allnum from stockoutmain_detail_color where id=".$_GET['id'];	
	$rs=$db->Execute($sql);
	$rs_a=$rs->GetArray();
	print $rs_a[0]['allnum'];
	return;
}
addShortCutByDate("createtime","创建时间","最近一月");
$SYSTEM_ADD_SQL=getKucunByUserid($SYSTEM_ADD_SQL,$_SESSION['LOGIN_USER_ID']);
$filetablename = "stockoutmain";
require_once( "include.inc.php" );
systemhelpcontent( "出库操作说明", "100%" );
?>
