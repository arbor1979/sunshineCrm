<?php
require_once('lib.inc.php');
$sessionkey=returnSessKey();
$GLOBAL_SESSION=returnsession();
$SUNSHINE_USER_NAME = $_SESSION['SUNSHINE_USER_NAME'];
//$SUNSHINE_USER_NAME = 'admin';
//未确认SQL语句有效性
$filetablename='stockoutdetail2';


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
				sum(stockoutdetail.plannum) stockoutfactnum,
				sum(stockoutdetail.price)/sum(product.groupfield) price,
				sum(stockoutdetail.plannum*stockoutdetail.price) money
			from
				product,
				measure,
				stockoutdetail,
				stockoutmain
			where
				stockoutdetail.productid=product.productid and
				product.measureid=measure.code   and
				stockoutdetail.state='4'  and
				stockoutmain.ROWID=stockoutdetail.mainrowid and stockoutmain.flowState='1'
			group by
				product.productid
				";
$NEWAIINIT_VALUE_SYSTEM_NUM = "
			select
				count(stockinmain.tabledate) as num
			from
				product,
				measure,
				stockoutdetail,
				stockoutmain
			where
				stockoutdetail.productid=product.productid and
				product.measureid=measure.code   and
				stockoutdetail.state='4'  and
				stockoutmain.ROWID=stockoutdetail.mainrowid and stockoutmain.flowState='1'
			group by
				product.productid
				";
*/

?>