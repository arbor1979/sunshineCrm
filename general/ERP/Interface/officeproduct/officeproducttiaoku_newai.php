<?php
require_once("lib.inc.php");

$GLOBAL_SESSION=returnsession();
if($_GET['action']=="add_default_data" || $_GET['action']=="add_default")
	validateMenuPriv("办公用品清单");
else
	validateMenuPriv("调拨记录");


//Array ( [action] => add_default2_data [pageid] => 1 ) Array ( [办公用品名称] => 法律基础与思想道德修养 [办公用品编号] => 100002 [调出仓库] => 一号仓库 [调入仓库] => 一号仓库 [调拨数量] => 1 [经手人] => 王纪云 [备注] => [创建人] => admin [创建时间] => 2009-06-14 11:19:11 [submit] => 保存 )
if($_GET['action']=="kuguanren")	
{
	$userid = returntablefield( "officeproductcangku", "编号", $_GET['tostore'], "仓库负责人" );
	$useridArray=explode(",", $userid);	
	header('Content-Type:text/xml;charset=GBK'); 
	$doc=new DOMDocument("1.0","GBK"); #声明文档类型
	$doc->formatOutput=true;               #设置可以输出操作
	#声明根节点，最好一个XML文件有个跟节点
	$root=$doc->createElement("root");    #创建节点对象实体 
	$root=$doc->appendChild($root);      #把节点添加进来
	foreach ($useridArray as $row)
	{
		if($row=='') continue;
		$linkman=$doc->createElement("kuguanren"); 
        $linkman=$root->appendChild($linkman);
        		 
		$rowid=$doc->createElement("id");
        $rowid=$linkman->appendChild($rowid);    

        $name=$doc->createElement("name");
        $name=$linkman->appendChild($name); 
        
        $rowid->appendChild($doc->createTextNode(iconv("GBK","UTF-8",$row)));
        $username=returntablefield("user", "user_id", $row, "user_name");
        $name->appendChild($doc->createTextNode(iconv("GBK","UTF-8",$username)));#注意要转码对于中文，因为XML默认为UTF-8格式
        		
	}
	echo $doc->saveXML();
	exit;
}

if($_GET['action']=="add_default_data")		{
	page_css();
	if($_POST['批准人']=='')
	{
		print "<script language=javascript>alert('审核人不能为空');window.history.back(-1);</script>";
		exit;	
	}
	$username=returntablefield("user","user_id", $_POST['创建人'],"user_name");
	$title="来自 $username 的调拨,调拨给你 ".$_POST['办公用品名称']." 数量：".$_POST['调拨数量'];
	$messagetitle="调拨入库";
	$guanlianid=$_POST['编号'];
	$url="../officeproduct/officeproducttiaoku_newai.php?".base64_encode("action=init_default_search&searchfield=编号&searchvalue=$guanlianid");
	newMessage($_POST['批准人'],$title,$messagetitle,$url,$guanlianid);
}

if($_GET['action']=="yes")		{
	global $db;
	$billinfo=returntablefield("officeproducttiaoku", "编号", $_GET['编号'], "办公用品编号,调拨数量,调出仓库,调入仓库");
	$num=$billinfo['调拨数量'];
	$prodid=$billinfo['办公用品编号'];
	$fromstore=$billinfo['调出仓库'];
	$tostore=$billinfo['调入仓库'];
	$kucun=returntablefield("officeproduct", "办公用品编号", $prodid, "数量","存放地点",$fromstore);
	if($kucun<$num)
	{
		print "<script language=javascript>alert('此编号的办公用品库存不足');window.history.back(-1);</script>";
		exit;	
	}
	$db->StartTrans();  
	$sql="update officeproduct set 数量=数量-$num,合计金额=round(数量*单价,2) where 办公用品编号='$prodid' and 存放地点='$fromstore'";
	$db->Execute($sql);
	$kucun=returntablefield("officeproduct", "办公用品编号", $prodid, "数量","存放地点",$tostore);
	if($kucun!='')
		$sql="update officeproduct set 数量=数量+$num,合计金额=round(数量*单价,2) where 办公用品编号='$prodid' and 存放地点='$tostore'";
	else 
	{
		$sql="select * from officeproduct where 办公用品编号='$prodid' and 存放地点='$fromstore'";
		$rs=$db->Execute($sql);
		$rs_a=$rs->GetArray();
		$sql="insert into officeproduct (办公用品编号,办公用品名称,办公用品类别,型号规格,计量单位,数量,单价,合计金额,品牌,存放地点,创建人,创建时间) 
		values('$prodid','".$rs_a[0]['办公用品名称']."','".$rs_a[0]['办公用品类别']."','".$rs_a[0]['型号规格']."','".$rs_a[0]['计量单位']."',$num,".
		$rs_a[0]['单价'].",".$rs_a[0]['单价']*$num.",'".$rs_a[0]['品牌']."',$tostore,'".$_SESSION['LOGIN_USER_ID']."','".date('Y-m-d H:m:s')."')";
	}
	$db->Execute($sql);
	$sql="update officeproducttiaoku set `是否审核`=2,`审核时间`='".date('Y-m-d H:m:s')."' where `编号`='".$_GET['编号']."'";
	$db->Execute($sql);
	$db->CompleteTrans();
	//是否事务出现错误
	if ($db->HasFailedTrans()) 
		print "<script language=javascript>alert('错误：".$e->getMessage()."');window.history.back(-1);</script>";
	else 
	{ 
		page_css();
		$return=FormPageAction("action","init_default");
		print_infor("调拨已审核",'trip',"location='?$return'","?$return",0);
	}
	exit;
	
}
if($_GET['action']=="no")		{
	global $db;
	$billinfo=returntablefield("officeproducttiaoku", "编号", $_GET['编号'], "办公用品编号,调拨数量,调出仓库,调入仓库");
	$num=$billinfo['调拨数量'];
	$prodid=$billinfo['办公用品编号'];
	$fromstore=$billinfo['调出仓库'];
	$tostore=$billinfo['调入仓库'];

	$sql="update officeproducttiaoku set `是否审核`=3,`审核时间`='".date('Y-m-d H:m:s')."' where `编号`='".$_GET['编号']."'";
	$db->Execute($sql);
	page_css();
	$return=FormPageAction("action","init_default");
	print_infor("调拨已否决",'trip',"location='?$return'","?$return",0);
	exit;
	
}
$filetablename='officeproducttiaoku';
require_once('include.inc.php');
?>