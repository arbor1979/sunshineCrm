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
$GLOBAL_SESSION = returnsession( );
$SUNSHINE_USER_NAME = $_SESSION['SUNSHINE_USER_NAME'];
validateMenuPriv("库存初始化");
if($_GET['action']=='edit_default2')
{
	$storeid=$_GET['ROWID'];
	$sql="select * from store where num<>0 and storeid=$storeid";
	$rs = $db->Execute($sql);
	$rs_detail = $rs->GetArray();
	if(sizeof($rs_detail)>0)
	{
		print "<script language=javascript>alert('错误：仓库中已存在产品，不能进行初始化');window.history.back(-1);</script>";
    	exit;
	}
	$sql="update store_init set jine=num*price where storeid=$storeid";
	$db->Execute($sql);
	require_once( "stockinit_input.php" );
	exit;
}
if($_GET['action']=='save')
{
	$storeid=$_GET['storeid'];
	try 
	{
		$sql = "select * from store_init where storeid=".$storeid." and flag=0";
		$rs = $db->Execute($sql);
		$rs_detail = $rs->GetArray();
		$allnum=0;
		$allmoney=0;
		for($i=0;$i<sizeof($rs_detail);$i++)
		{
			$allnum=$allnum+$rs_detail[$i]['num'];
			$allmoney=$allmoney+$rs_detail[$i]['jine'];
		}
		if($allnum==0)
			throw new Exception("总数量必须大于0");	
	    
		//开启事务
	    $db->StartTrans();  
	    //获取入库单号	
	    //删除库存为0的记录
	    $sql = "delete from `store` where num=0 and storeid=$storeid";		
	    $db->Execute($sql);//清空零库存
	    
	    $billid = returnAutoIncrement("billid","stockinmain");
	    //插入新入库单
	    $sql = "insert into stockinmain (billid,zhuti,storeid,createman,createtime,caigoubillid,state,totalnum,totalmoney,instoreshenhe,indate,intype) values(".
	    $billid.",'库存初始化',".$storeid.",'".$_SESSION['LOGIN_USER_ID']."','".date("Y-m-d H:i:s")."',0,'已入库',$allnum,$allmoney,'".$_SESSION['LOGIN_USER_ID']."','".date("Y-m-d H:i:s")."','初始化入库')";
		$db->Execute($sql);
	    
	    
	    for($i=0;$i<sizeof($rs_detail);$i++)
		{
			$num=floatvalue($rs_detail[$i]['num']);
			$price=floatvalue($rs_detail[$i]['price']);
			$jine=floatvalue($rs_detail[$i]['jine']);
			$memo=$rs_detail[$i]['memo'];
			//插入库存
			if($num!=0)
			{
				$sql="select max(id) as maxid from stockinmain_detail";
				$rs = $db->Execute($sql);
				$rs_a=$rs->GetArray();
				$maxid=$rs_a[0]['maxid']+1;
	    		$sql = "insert into stockinmain_detail (id,prodid,prodname,prodguige,prodxinghao,proddanwei,price,zhekou,num,mainrowid,jine) values('$maxid','".
	    		$rs_detail[$i]['prodid']."','".$rs_detail[$i]['prodname']."','".$rs_detail[$i]['guige']."','".$rs_detail[$i]['xinghao'].
	    		"','".$rs_detail[$i]['danwei']."',".$price.",1,".$num.",".$billid.",".$jine.")";
	    		$db->Execute($sql);
	    		
	    		$maxid=returnAutoIncrement("id", "store");
	    		$sql="insert into store (id,prodid,num,price,storeid,memo) values($maxid,'".$rs_detail[$i]['prodid']."',$num,$price,$storeid,'$memo')";
	    		$db->Execute($sql);
			}
		}
		$sql = "delete from store_init where storeid=".$storeid." and flag=0 and num=0";
		$db->Execute($sql);
		//更新初始化状态
    	$sql = "update store_init set flag=1 where storeid=".$storeid." and flag=0";
		$db->Execute($sql);
		
		//是否事务出现错误
		if ($db->HasFailedTrans()) 
		 	print "<script language=javascript>alert('错误：".str_replace("'",  "\'", $db->ErrorMsg())."');window.history.back(-1);</script>";
		else 
		{ 
			page_css("库存初始化");
			$return=FormPageAction("action","init_default");
			print_infor("已完成库存初始化",'trip',"location='?$return'","?$return",0);
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
if($_GET['action']=='edit_default3')
{
	$storeid=$_GET['ROWID'];
	require_once( "stockinit_clear.php" );
	exit;
}

$SYSTEM_ADD_SQL=getKucunByUserid($SYSTEM_ADD_SQL,$_SESSION['LOGIN_USER_ID'],"ROWID");

$filetablename = "stock";
$parse_filename = "stockinit";
require_once( "include.inc.php" );
systemhelpcontent( "库存初始化说明", "100%" );
?>
