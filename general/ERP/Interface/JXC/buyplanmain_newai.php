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
validateMenuPriv("采购单");
if($_GET['action']=="edit_default2")			
{
	
	$billid=$_GET['billid'];
	$url="";
	$fangshi1="DataQuery/productFrame.php?tablename=buyplanmain_detail&deelname=采购单明细&rowid=$billid";
	$fangshi2="buyplanmain_mingxi.php?tablename=buyplanmain_mingxi&deelname=采购单明细&rowid=$billid";
	$fangshi3="buyplanmain_Excel.php?tablename=buyplanmain_mingxi&deelname=采购单明细&rowid=$billid";

	if($url=='')
	{
		page_css();
		print "
		<table id=listtable align=center class=TableBlock width=100% border=0>
<TR><TD  class=TableHeader height=30>&nbsp;选择采购单录入方式：</TD></TR>
<tr><td class=TableLine2>
		<style>
body{text-align:center;}
img{display: block;border=2}
#L{position: absolute;
left: 150;
top: 150;
width:200;
}
#M{position: absolute;
left: 450;
top: 150;
width:200;
}
#R{position: absolute;
left: 750;
top: 150;
width:200;
}
.ac{ background:#bbbbbb; border:0px solid #dddddd; }
.bc{ background:#777777; border:0px solid #999; 
  padding:1px; margin:1px; }
.cc { background:#ffffff; border:0px solid #555; 
  padding:5px; }
.dc{ background: #CCCCCC; border: 1px solid #999999;}
A IMG {
 BORDER-RIGHT: #ffffff 2px solid; BORDER-TOP: #ffffff 2px solid; BORDER-LEFT: #ffffff 2px solid; BORDER-BOTTOM: #ffffff 2px solid
}
A:hover IMG {
 BORDER-RIGHT: #FF0000 2px solid; BORDER-TOP: #FF0000 2px solid; BORDER-LEFT: #FF0000 2px solid; BORDER-BOTTOM: #FF0000 2px solid
}
</style>
<div id='L'><div><b>1.</b>商品库中已存在要录入的商品，可直接扫描条码或选择类别录入采购单</div><div class='ac'>
<div class='bc'><div class='cc'>
<div class='dc'><a href=$fangshi1><img src='../../Framework/images/fangshi1.jpg'></a>
</div></div></div></div></div>
<div id='M'><div><b>2.</b>不确定商品库中是否存在，需要通过原厂码查找，可生成新的商品条码</div><div class='ac'>
<div class='bc'><div class='cc'>
<div class='dc'><a href=$fangshi2><img src='../../Framework/images/fangshi2.jpg'></a>
</div></div></div></div></div>
<div id='R'><div><b>3.</b>通过Excel导入采购明细，可自动生成新的商品条码</div><div class='ac'>
<div class='bc'><div class='cc'>
<div class='dc'><a href=$fangshi3><img src='../../Framework/images/fangshi3.jpg'></a>
</div></div></div></div></div>
</td></tr></table>
";
	}
	else 
		print "<script>location='$url';</script>";
	//print "<script>location='DataQuery/productFrame.php?tablename=buyplanmain_detail&deelname=采购单明细&rowid=".$_GET['billid']."'</script>";

	exit;
}
if($_GET['action']=="edit_default3")			
{
print "<script>location='buyplanmain_ruku.php?rowid=".$_GET['billid']."'</script>";
exit;
}

if($_GET['action']=="saveruku")			
{
	$rowid=$_GET['rowid'];
	$totalnum=$_POST['allamount1'];
	$totalmoney=$_POST['allmoney1'];
	$storeid=$_POST['stock'];
	$yundanhao=$_POST['yundanhao'];
	$huoyungongsi=$_POST['huoyungongsi'];
	try 
	{
		
		$Store=new Store($db);
	    //开启事务
	    $db->StartTrans();  
	    //$db->debug=1;
	    $Store->insertCaiGouRuKu($rowid,$totalnum,$totalmoney,$storeid,$yundanhao,$huoyungongsi);
		
	    page_css("生成入库单");
	    $db->CompleteTrans();
		//是否事务出现错误
		if ($db->HasFailedTrans()) 
			throw new Exception($db->ErrorMsg());
		else 
		{ 
			
			$return=FormPageAction("action","init_default");
			print_infor("入库单已生成，等待库管确认",'trip',"location='?$return'","?$return",1);
			
		}

	}
	catch (Exception $e)
	{
		print "<script language=javascript>alert('错误：".$e->getMessage()."');window.history.back(-1);</script>";
	}   
	exit;	
	
}
//终止采购单
if($_GET['action']=="terminate")			
{
	page_css("");
	$rowid=$_GET['billid'];
	$confirm=$_GET['confirm'];
		
	if($confirm=='')
	{
		$buybillinfo=returntablefield("buyplanmain","billid",$rowid,"paymoney,rukumoney");
		$paymoney=$buybillinfo['paymoney'];
		$rukumoney=$buybillinfo['rukumoney'];
		$tip='';
		if($paymoney>$rukumoney)
			$tip="已付金额大于已入库金额，多付的金额将会转入预付款账户";
		
		print "<script language=javascript>if(confirm('是否确认终止采购单？\\r\\n".$tip."')){location='?billid=$rowid&action=terminate&rowid=$rowid&confirm=1'}else{window.history.back(-1)}</script>";
		exit;
	}
	try 
	{
		
		$Store=new Store($db);
	    //开启事务
	    $db->StartTrans();  
	    //$db->debug=1;
	    $Store->terminateCaiGou($rowid);
		
	    
	    $db->CompleteTrans();
		//是否事务出现错误
		if ($db->HasFailedTrans()) 
			throw new Exception($db->ErrorMsg());
		else 
		{ 
			$_GET['confirm']='';
			$return=FormPageAction("action","init_default");
			print_infor("采购单已终止",'trip',"location='?$return'","?$return",0);
			
		}

	}
	catch (Exception $e)
	{
		print "<script language=javascript>alert('错误：".$e->getMessage()."');window.history.back(-1);</script>";
	}   
	exit;	
	
}
if($_GET['action']=="add_default")		
{
	$CUR_HOUR = date('Y-m-d',strtotime("+3 days"));
	$ADDINIT=array("daohuodate"=>$CUR_HOUR);
	
}

//撤销采购订单
if($_GET['action']=="delete_array")			
{
	$selectid=$_GET['selectid'];
	$selectid=explode(",", $selectid);
	try 
	{
		//开启事务
		$CaiWu=new CaiWu($db);
	    $db->StartTrans();  
		for($i=0;$i<sizeof($selectid);$i++)
		{
			if($selectid[$i]!="")
			{
					
				$billid=$selectid[$i];
				$sql="delete from buyplanmain where billid=$billid and user_flag>-1";
				$rs=$db->Execute($sql);
				if ($rs === false)
					throw new Exception("不存在此记录");	
				$CaiWu->deleteFukuanReocordByBillid($billid);
				$CaiWu->deleteshoupiaoByBillid($billid);
			}

		}
		$db->CompleteTrans();
		page_css("");
		//是否事务出现错误
		if ($db->HasFailedTrans()) 
			throw new Exception($db->ErrorMsg());
		else 
		{ 
			$return=FormPageAction("action","init_default");
			print_infor("采购单已删除",'trip',"location='?$return'","?$return",0);
		}
	}
	catch(Exception $e)
	{
		print "<script language=javascript>alert('错误：".$e->getMessage()."');window.history.back(-1);</script>";
	}
	exit;
}

$SYSTEM_ADD_SQL =getRoleByUser($SYSTEM_ADD_SQL,"createman");
addShortCutByDate("caigoudate","采购日期","最近一月");
$filetablename = "buyplanmain";
require_once( "include.inc.php" );
systemhelpcontent( "采购订单管理", "100%" );

?>
