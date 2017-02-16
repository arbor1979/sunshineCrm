<?php
	ini_set('display_errors', 1);
	ini_set('error_reporting', E_ALL);
	error_reporting(E_WARNING | E_ERROR);
	require_once('lib.inc.php');
	$GLOBAL_SESSION=returnsession();
validateMenuPriv("商品维护");

	function getIds($parentid)
	{
		global $db;
		global $ids;
		$sql = "select rowid from producttype where parentid='".$parentid."'";
		$rs = $db->Execute($sql);
		$rs_a = $rs->GetArray();
	
		if(sizeof($rs_a)==0)
			return;
		else 
		{
			for($i=0;$i<sizeof($rs_a);$i++)	
			{
				$ids=$ids.",".$rs_a[$i]['rowid'];
				getIds($rs_a[$i]['rowid']);
			}
		}
	}

	if($_GET['action']=="edit_default_data"||$_GET['action']=="add_default_data")		{
		if($_GET['productid']!=$_POST['productid'])
		{
			$productid = returntablefield("product","productid",$_POST['productid'],"productid");
			if($productid!='')
			{
				print "<script language='javascript'>alert('产品编号 $productid 已存在');window.history.back(-1);</script>";
				exit;
			}
			$mainrowid=returntablefield("buyplanmain_detail","prodid",$_GET['productid'],"mainrowid");
			if($mainrowid!="")
			{
				print "<script language='javascript'>alert('产品编号 ".$_GET['productid']." 已存在于采购单 $mainrowid 中，不能修改编号');window.history.back(-1);</script>";
				exit;
			}
			$mainrowid=returntablefield("store","prodid",$_GET['productid'],"id");
			if($mainrowid!="")
			{
				print "<script language='javascript'>alert('产品编号 ".$_GET['productid']." 已存在库存，不能修改编号');window.history.back(-1);</script>";
				exit;
			}
		}
		/*
		if($_POST['oldproductid']!='' && $_POST['supplyid']!='')
		{
			$sql="select productid from product where oldproductid='".$_POST['oldproductid']."' and supplyid=".$_POST['supplyid']." and standard='".$_POST['standard']."' and productid<>'".$_GET['productid']."'";
			$rs=$db->Execute($sql);
			$rs_a=$rs->GetArray();
			if(sizeof($rs_a)>0)
			{
				print "<script language='javascript'>alert('此厂家已存在原厂码为 ".$_POST['oldproductid']." 的产品');window.history.back(-1);</script>";
				exit;
			}
		}
		*/
		$_POST['productcn'] = 汉字转拼音首字母($_POST['productname']);
		if($_POST['fileaddress']!='' && $_POST['oldproductid']!='' && $_POST['supplyid']!='')
		{
			$sql="update product set fileaddress='".$_POST['fileaddress']."' where oldproductid='".$_POST['oldproductid']."' and supplyid='".$_POST['supplyid']."'";
			$db->Execute($sql);
		}
	}
	
	//判断是否已使用
if($_GET['action']=="delete_array")			
{
	$selectid=$_GET['selectid'];
	$selectid=explode(",", $selectid);
	for($i=0;$i<sizeof($selectid);$i++)
	{
		if($selectid[$i]!="")
		{
			
			$mainrowid=returntablefield("stockinmain_detail","prodid",$selectid[$i],"mainrowid");
			
			if($mainrowid!="")
			{
				print "<script language='javascript'>alert('产品编号 $selectid[$i] 已存在于入库单 $mainrowid 中，请先删除入库单');window.history.back(-1);</script>";
				exit;
			}
		}
	}
}
if($_GET['action']=="getbarcode")			
{
	$country=$_GET['country'];
	$supplyid=$_GET['supplyid'];
	$producttype=$_GET['producttype'];
	$oldproductid=iconv('UTF-8','gb2312',$_GET['oldproductid']);
	$standard=$_GET['standard'];
	$sql="select productid from product where supplyid=$supplyid and producttype=$producttype and oldproductid='$oldproductid' and standard=$standard";
	$productid=$db->GetOne($sql);
	if(!empty($productid))
	{
		echo $productid;
	}
	else
	{
		$maxid=1;
		while(strlen($supplyid)<3)
			$supplyid='0'.$supplyid;
		$barcode=$country.$supplyid;
		$sql="select max(substr(productid,5,6)) as maxid from product where left(productid,4)='".$barcode."'";
		$maxid=$db->GetOne($sql);
		if(!empty($maxid))
			$maxid++;
		while(strlen($maxid)<6)
			$maxid='0'.$maxid;
		$barcode.=$maxid;
		while(strlen($standard)<2)
			$standard='0'.$standard;
		$barcode.=$standard;
		echo $barcode;
	}
	exit;
}
if($_GET['action']=="add_default" && $_GET['supplyid']!='')
{
	$sql="select * from product where supplyid='".$_GET['supplyid']."' order by productid desc limit 0,1";
	$rs=$db->Execute($sql);
	$rs_a=$rs->GetArray();
	if(sizeof($rs_a)==1)
	{
		$ADDINIT=array("measureid"=>$rs_a[0]['measureid'],"producttype"=>$rs_a[0]['producttype'],"storemin"=>$rs_a[0]['storemin'],"storemax"=>$rs_a[0]['storemax'],"ifkucun"=>$rs_a[0]['ifkucun']);

	}
}
/*
if($_GET['action']=="add_default")
{
	$sql="select * from product";
	$rs=$db->Execute($sql);
	$rs_a=$rs->GetArray();
	for($i=0;$i<sizeof($rs_a);$i++)
	{
		$productid=$rs_a[$i]['productid'];
		$barcode=substr($productid,0,12);
		$jishu=0;
		$oushu=0;
		for($j=0;$j<6;$j++)
		{
			$jishu=$jishu+intval($barcode{$j*2});
			$oushu=$oushu+intval($barcode{$j*2+1});
		}
		$jiaoyan=10-(($jishu+$oushu*3)%10);
		if($jiaoyan==10)
			$jiaoyan=0;
		$barcode.=$jiaoyan;
		echo $productid."<br>";
		echo $barcode."<br>";
		$sql="update product set productid='$barcode' where productid='$productid'";
		$db->Execute($sql);
	}
}
*/
//$SYSTEM_PRINT_SQL  = 1;
$filetablename = "product";
require_once( "include.inc.php" );
?>
