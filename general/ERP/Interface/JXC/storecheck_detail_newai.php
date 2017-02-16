<?php
	ini_set('display_errors', 1);
	ini_set('error_reporting', E_ALL);
	error_reporting(E_WARNING | E_ERROR);
	require_once('lib.inc.php');
	$GLOBAL_SESSION=returnsession();
	
	/*
	if($_GET['action']=="add_default_data")		{
		//print_R($_GET);print_R($_POST);//exit;
		global $db;
		$入库数量 = (int)$_POST['入库数量'];$教材编号 = $_POST['教材编号'];
		$sql = "update edu_jiaocai set 现有库存=现有库存+$入库数量 where 教材编号='".$教材编号."'";
		$rs = $db->Execute($sql);//print $sql;exit;
		$_POST['编作者'] = returntablefield("edu_jiaocai","教材编号",$教材编号,"编作者");
		$_POST['出版社'] = returntablefield("edu_jiaocai","教材编号",$教材编号,"出版社");
		//print  "<META HTTP-EQUIV=REFRESH CONTENT='0;URL=?'>";
	}
	*/
	function recallfunc($db)
	{
	    $storeid=returntablefield("storecheck","billid",$_GET['foreignvalue'],"storeid");
	    $sql="select * from storecheck_detail where mainrowid='".$_GET['foreignvalue']."'";
	    $rs=$db->Execute($sql);
	    $rs_a=$rs->GetArray();
	    for($i=0;$i<sizeof($rs_a);$i++)
	    {
	        $prodid=$rs_a[$i]['prodid'];
	        if($rs_a[$i]['num']==0)
	        {
	            $sql="delete from storecheck_detail where id='".$rs_a[$i]['id']."'";
	            $db->Execute($sql);
	            continue;
	        }
	        $prodinfo=returntablefield("product", "productid", $prodid, "productname,measureid,mode,standard,sellprice,oldproductid");
	        $avgprice=returntablefield("store", "prodid", $prodid, "price");
	        if($prodinfo['sellprice']>0)
	           $zhekou=round($avgprice/$prodinfo['sellprice'],4);
	        $opertype=1;
	        if($rs_a[$i]['num']<0)
	            $opertype=-1;
	        $sql="update storecheck_detail set prodname='".$prodinfo['productname']."',prodguige='".$prodinfo['standard'].
	        "',prodxinghao='".$prodinfo['mode']."',proddanwei='".$prodinfo['measureid']."',price=".$prodinfo['sellprice'].
	        ",zhekou=$zhekou,jine=round($avgprice*num,2),oldprodid='".$prodinfo['oldproductid']."',opertype=$opertype,orderid=$i,inputtime=now() where id='".$rs_a[$i]['id']."'";
	        $db->Execute($sql);
	    }
	       
	        echo "导入数据成功";
	        exit;
	    
	}
	
	//数据表模型文件,对应Model目录下面的storecheck_detail_newai.ini文件
	//如果是需要复制此模块,则需要修改$parse_filename参数的值,然后对应到Model目录 新文件名_newai.ini文件
	$filetablename		=	'storecheck_detail';
	$parse_filename		=	'storecheck_detail';
	require_once('include.inc.php');
	
	
	?>