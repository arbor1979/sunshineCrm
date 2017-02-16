<?php
require_once('lib.inc.php');
$sessionkey=returnSessKey();
$GLOBAL_SESSION=returnsession();
$SUNSHINE_USER_NAME = $_SESSION['SUNSHINE_USER_NAME'];
//$SUNSHINE_USER_NAME = 'admin';
//未确认SQL语句有效性
$filetablename='ordersell';


//and ( stockoutmain.user_id='$SUNSHINE_USER_NAME' )
require_once('include.inc.php');

/*

$NEWAIINIT_VALUE_SYSTEM = "
			select

				stockoutmain.tabledate,
				product.productid,
				product.productname,
				measure.name,
				product.standard,
				product.mode,
				sum(stockoutdetail.plannum) stockoutfactnum,
				sum(stockoutdetail.plannum * stockoutdetail.price) money
			from
				product,
				stockoutdetail,
				measure ,
				stockoutmain
			where
				stockoutdetail.productid=product.productid   and
				measure.code=product.measureid  and
				stockoutdetail.state='4'  and
				stockoutmain.ROWID=stockoutdetail.mainrowid  and
				stockoutmain.flowState='1'
			group by
				product.productid ,
				stockoutmain.tabledate
				";
$NEWAIINIT_VALUE_SYSTEM_NUM = "
			select
				count(stockinmain.tabledate) as num
			from
				product,
				stockoutdetail,
				measure ,
				stockoutmain
			where
				stockoutdetail.productid=product.productid   and
				measure.code=product.measureid  and
				stockoutdetail.state='4'  and
				stockoutmain.ROWID=stockoutdetail.mainrowid  and
				stockoutmain.flowState='1'
			group by
				product.productid ,
				stockoutmain.tabledate
				";

				*/

?>