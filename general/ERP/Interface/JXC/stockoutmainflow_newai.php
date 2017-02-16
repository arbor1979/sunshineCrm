<?php
require_once('lib.inc.php');
$sessionkey=returnSessKey();
$GLOBAL_SESSION=returnsession();
$SUNSHINE_USER_NAME = $_SESSION['SUNSHINE_USER_NAME'];
$SUNSHINE_USER_NAME = 'admin';

if($_GET['action']=="edit_default2")			{
	//print_R($_GET);
	//StockOutToStore($_GET['ROWID'],$_POST['flowState']);
}



if($_GET['action']=="edit_default2_data")			{
	//print_R($_POST);print_R($_GET);
	StockOutToStore($_GET['ROWID'],$_POST['flowState']);
	//exit;
}



//默认操作
$filetablename='stockoutmain';
$parse_filename = 'stockoutmainflow';
require_once('include.inc.php');
systemhelpContent("出库操作管理说明",'100%');

//功能函数区

//第一：把入库单据转换为库存
function StockOutToStore($Rowid,$flowState)		{
	global $db;
	if($Rowid=="")	exit;
	$MainTable = "stockoutmain";
	$DetailTable = "stockoutdetail";
	$sql = "select * from $MainTable where ROWID='$Rowid'";
	$rs = $db->Execute($sql);
	$rs_a = $rs->GetArray();
	//print_R($rs_a);	
	$tabledate = $rs_a[0]['tabledate'];
	$stockid = $rs_a[0]['stockid'];
	$stockiplaceid = $rs_a[0]['stockiplaceid'];
	$supplyid = $rs_a[0]['supplyid'];
	$tablecode = $rs_a[0]['tablecode'];

	$sql = "select * from $DetailTable where mainrowid='$Rowid'";
	$rs = $db->Execute($sql);
	$rs_a = $rs->GetArray();
	//print_R($rs_a);

	$stockinpersion = $SUNSHINE_USER_NAME;
	$Columns = returntablecolumn($DetailTable);
	for($i=0;$i<sizeof($rs_a);$i++)		{
		for($j=0;$j<sizeof($Columns);$j++)		{
			$Element = $Columns[$j];
			$$Element = $rs_a[$i][$Element];
		}
		$plannum==""?$plannum=0:'';
		

		//第一：把入库单据转换为库存
		//INSERT INTO `store` ( `productid` , `stocknum` , `storemaxnum` , `storeminnum` , `storesign` , `signtype` , `ROWID` , `mobilesign` , `stock` , `standard` , `mode` , `freenum` , `allnum` , `price` , `amt` ) 
		//VALUES (
		//'', '0', '', '', '', '0', '', '0', '', '', '', '0', '0', '0', '0'
		//);
		$sql = "select stocknum,ROWID from store where productid='$productid'";
		$rss = $db->Execute($sql);
		$rss_a = $rss->GetArray();
		//print $rss_a[0]['NUM'];exit;
		$allnum = $rss_a[0]['stocknum'];
		if($rss_a[0]['ROWID']!="")		{
			$sql = "update store set stocknum = stocknum - $plannum , allnum = allnum - $plannum, standard='$standard' , mode='$mode' ,price='$price' where productid='$productid'";
		}

		//else	{
			//$sql = "INSERT INTO `store` ( `productid` , `stocknum` , `storemaxnum` , `storeminnum` , `storesign` , `signtype` , `ROWID` , `mobilesign` , `stock` , `standard` , `mode` , `freenum` , `allnum` , `price` , `amt` ) 
			//VALUES ( '$productid' , '$plannum' , '$storemaxnum' , '$storeminnum' , '$storesign' , '$stockintype' , '' , '$mobilesign' , '$stockid' , '$standard' , '$mode' , '$freenum' , '$allnum' , '$price' , '$storeamt' );
			//";
		//}
		if($flowState=="1")				{
			$db->Execute($sql);
			////print $sql."<HR>";
		}
		else if($flowState=="-1")				{
			$sql = "update store set stocknum = stocknum + $plannum , allnum = allnum + $plannum , standard='$standard' , mode='$mode' ,price='$price' where productid='$productid'";
			$db->Execute($sql);
			////print $sql."<HR>";
		}

		//完成库存数量更新部分


		
		//stockoutmain : tablecode tabledate stockoutpersion stockoutsign stockouttype userexplian stockpersion stockid stockiplaceid stockstate ROWID fillindate state exampersion supplyid user_id amt sellmess sellmobile outmess outmobile outtype flowState payamt factpayamt isfax issend sellman payment chinaAmt sendAmt rebate noFaxAmt fromRowId fromModuleId datascope invoice customerPO fromModuleId2 fromRowId2 tableNo 
		//stockoutdetail : stockoutcode receivecode ordercode productid plannum stockoutfactnum price money profitmoney costmoney stockoutdetailsign ROWID state stockouttype toreturn user_id mainrowid standard mode freenum allnum storenum 


		//第二：把入库单据转换为库存明细
		$storeamt = $plannum*$price;
		$sql = "INSERT INTO `storedetail` ( 
			`productid` , `stockinfactnum` , `storefactnum` , `stockoutfactnum` ,
			`stockincode` , `stockoutcode` , `storedetailsign` , `signtype` ,
			`ROWID` , `storecode` , `stockinfactprice` , `stockinpersion` ,
			`stockinmaincode` , `stockindate` , `user_id` , `stock` , 
			`stockplace` , `standard` , `mode` , `exchrowid` , 
			`freenum` , `allnum` , `storeamt` ) 
			VALUES (
			'$productid' , '$plannum' , '$allnum' , '$stockoutfactnum' ,
			'$stockincode' , '$tablecode' , '$stockoutdetailsign' , '$stockouttype' ,
			'' , '$storecode' , '$price' , '$stockinpersion' ,
			'$Rowid' , '$tabledate' , '$user_id' , '$stockid' , 
			'$stockiplaceid' , '$standard' , '$mode' , '$exchrowid' , 
			'$freenum' , '$allnum' , '$storeamt' 
		);
		";
		if($flowState=="1")				{
			$db->Execute($sql);
			////print $sql."<HR>";
		}


		
		
		
	}

	$sql = "delete from storedetail where stockoutcode='$tablecode'";
	if($flowState=="-1")				{
		$db->Execute($sql);
		////print $sql."<HR>";
	}

}
//第二：把入库单据转换为库存明细

//第三：记录库存流转状态

?>