<?php
require_once('lib.inc.php');
$sessionkey=returnSessKey();
$GLOBAL_SESSION=returnsession();
$SUNSHINE_USER_NAME = $_SESSION['SUNSHINE_USER_NAME'];
//$SUNSHINE_USER_NAME = 'admin';

$filetablename='profit';


//and ( stockoutmain.user_id='$SUNSHINE_USER_NAME' )
require_once('include.inc.php');
/*
$NEWAIINIT_VALUE_SYSTEM = "
			select
				product.productid,
				product.productname,
				measure.name,
				product.standard,
				product.mode,
				sum(stockoutdetail.stockoutfactnum) stockoutfactnum,
				sum(stockoutdetail.costmoney) price,
				sum(stockoutdetail.money) money,
				sum(stockoutdetail.profitmoney) money2
			from
				product,
				stockoutdetail,measure ,
				stockoutmain
			where
				stockoutdetail.productid=product.productid  and
				measure.code=product.measureid  and
				stockoutdetail.state='4' and
				stockoutmain.flowState='1' and
				stockoutdetail.productid=product.productid and
				stockoutmain.ROWID=stockoutdetail.mainrowid
			group by product.productid
				";
$NEWAIINIT_VALUE_SYSTEM_NUM = "
			select
				count(stockinmain.tabledate) as num
			from
				product,
				stockoutdetail,measure ,
				stockoutmain
			where
				stockoutdetail.productid=product.productid  and
				measure.code=product.measureid  and
				stockoutdetail.state='4' and
				stockoutmain.flowState='1' and
				stockoutdetail.productid=product.productid and
				stockoutmain.ROWID=stockoutdetail.mainrowid
			group by product.productid
				";
				*/
?>