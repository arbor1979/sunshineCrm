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
$isBase64 = isbase64( );
$isBase64 == 1 ? checkbase64( ) : "";
$GLOBAL_SESSION=returnsession();
$SYSTEM_PRIV_STOP = "1";
validateMenuPriv("产品报价");

$customerid=$_GET['customerid'];
if($customerid!='' && $_GET['action']=='add_default')
{
	$ADDINIT=array("客户"=>$customerid);
}

if($_GET['action']=="edit_default3")			
{
print "<script>location='DataQuery/productFrame.php?tablename=customerproduct_detail&deelname=报价单明细&rowid=".$_GET['ROWID']."'</script>";
exit;
}
if($_GET['action']=="tongyi")			
{
	page_css();
	$sql="update customerproduct set `是否审核`=2,`审核时间`='".date("Y-m-d H:i:s")."',审核人='".$_SESSION['LOGIN_USER_ID']."' where ROWID=".$_GET['ROWID'];
	$db->Execute($sql);
	$billinfo=returntablefield("customerproduct","ROWID",$_GET['ROWID'],"主题,创建人");
	newMessage($billinfo['创建人'],$billinfo['主题'].'--已通过！','报价单审核','../JXC/customerproduct_newai.php?'.base64_encode('action=view_default&ROWID='.$_GET['ROWID']),$_GET['ROWID']);
	$return=FormPageAction("action","init_default");
	print_infor("已同意！",'trip',"location='?$return'","?$return",0);
	exit;
}
if($_GET['action']=="foujue")			
{
	page_css();
	$sql="update customerproduct set `是否审核`=3,`审核时间`='".date("Y-m-d H:i:s")."',审核人='".$_SESSION['LOGIN_USER_ID']."' where ROWID=".$_GET['ROWID'];
	$db->Execute($sql);
	$billinfo=returntablefield("customerproduct","ROWID",$_GET['ROWID'],"主题,创建人");
	newMessage($billinfo['创建人'],$billinfo['主题'].'--被否决！','报价单审核','../JXC/customerproduct_newai.php?'.base64_encode('action=view_default&ROWID='.$_GET['ROWID']),$_GET['ROWID']);
	$return=FormPageAction("action","init_default");
	print_infor("已否决！",'trip',"location='?$return'","?$return",0);
	exit;
}
if($_GET['action']=="edit_default2")			
{
		$rowid=$_GET['ROWID'];
		//开启事务
	    $db->StartTrans();  
	    //获取订单号	
	    $billid = returnAutoIncrement("billid","sellplanmain");
	    $sql = "select * from customerproduct where ROWID=".$rowid;
		$rs = $db->Execute($sql);
		$rs_a= $rs->GetArray();
		if(count($rs_a)==0)
			throw new Exception("找不到此报价单");
		$zhuti=$rs_a[0]['主题'];
		$customerid=$rs_a[0]['客户'];
		$jieshouren=$rs_a[0]['接收人'];
		
		$address=returntablefield("linkman", "rowid", $jieshouren, "address");
		$tel=returntablefield("linkman", "rowid", $jieshouren, "phone");
		
		$jine=$rs_a[0]['金额'];
		$chance=$rs_a[0]['销售机会'];
		$totalnum=intval($rs_a[0]['总数量']);
		$beizhu="交付说明:".$rs_a[0]['交付说明']." 付款说明:".$rs_a[0]['付款说明']." 包装运输说明:".$rs_a[0]['包装运输说明']." 备注：".$rs_a[0]['备注'];
	    //插入新订单
	    $sql = "insert into sellplanmain (billid,zhuti,user_id,supplyid,chanceid,totalmoney,plandate,zuiwanfahuodate,beizhu,linkman,address,mobile,createtime,billtype,totalnum) values(".
	    $billid.",'".$zhuti."','".$_SESSION['LOGIN_USER_ID']."',".$customerid.",'".$chance."',".$jine.",'".date("Y-m-d")."','".date("Y-m-d",strtotime(date("Y-m-d")." +30 days")).
	    "','".$beizhu."','".$jieshouren."','".$address."','".$tel."','".date("Y-m-d H:i:s")."',2,$totalnum)";
	    
		$db->Execute($sql);
		
		$sql = "select * from customerproduct_detail where mainrowid=".$rowid;
		$rs = $db->Execute($sql);
		$rs_detail = $rs->GetArray();
		for($i=0;$i<sizeof($rs_detail);$i++)
		{
			$sql="select max(id) as maxid from sellplanmain_detail";
			$rs = $db->Execute($sql);
			$rs_a = $rs->GetArray();
			$maxid=$rs_a[0]['maxid']+1;
			$sql = "insert into sellplanmain_detail (id,prodid,prodname,prodguige,prodxinghao,proddanwei,price,zhekou,num,mainrowid,jine,inputtime) values(".$maxid.",'".
    		$rs_detail[$i]['prodid']."','".$rs_detail[$i]['prodname']."','".$rs_detail[$i]['prodguige']."','".$rs_detail[$i]['prodxinghao'].
    		"','".$rs_detail[$i]['proddanwei']."',".$rs_detail[$i]['price'].",".$rs_detail[$i]['zhekou'].",".$rs_detail[$i]['num'].",".$billid.",".$rs_detail[$i]['price']*$rs_detail[$i]['zhekou']*$rs_detail[$i]['num'].",'".$rs_detail[$i]['inputtime']."')";
    		$db->Execute($sql);
    			    
	    		
		}
			
		//是否事务出现错误
		if ($db->HasFailedTrans()) 
		 	print "<script language=javascript>alert('错误：".str_replace("'",  "\'", $db->ErrorMsg())."');window.history.back(-1);</script>";
		else 
		{ 
			page_css("生成订单");
			$return=FormPageAction("action","init_default");
			print_infor("订单已生成成功",'trip',"location='?$return'","?$return",0);
			
		}
    	$db->CompleteTrans();
		exit;	
}
addShortCutByDate("创建时间","创建时间");
$SYSTEM_ADD_SQL =getCustomerRoleByCustID($SYSTEM_ADD_SQL,"客户");
$limitEditDelCust='客户';
$filetablename = "customerproduct";
require_once( "include.inc.php" );
systemhelpContent("产品报价说明",'100%');
?>
