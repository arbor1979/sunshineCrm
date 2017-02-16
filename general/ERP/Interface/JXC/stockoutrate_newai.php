<?php
require_once('lib.inc.php');
$sessionkey=returnSessKey();
$GLOBAL_SESSION=returnsession();
$SUNSHINE_USER_NAME = $_SESSION['SUNSHINE_USER_NAME'];
//$SUNSHINE_USER_NAME = 'admin';

$filetablename='stockoutrate';



require_once('include.inc.php');

/*

$NEWAIINIT_VALUE_SYSTEM = "
		select
			stockoutmain.tablecode,
			user.NICK_NAME as sellman,
			customer.supplyname,
			stock.name,
			product.productname,
			product.standard,
			product.mode,
			sum(stockoutdetail.plannum) AS plannum,
			sum(stockoutdetail.plannum) AS plannumrate,
			sum(stockoutdetail.stockoutfactnum) AS stockoutfactnum,
			sum(stockoutdetail.stockoutfactnum) AS stockoutfactnumrate,
			sum(stockoutdetail.money) AS money,
			sum(stockoutdetail.money) AS moneyrate,
			stockoutdetail.ROWID
		from
			stockoutmain,
			customer,
			stock,
			product,
			stockoutdetail,
			user
		where
			stockoutdetail.mainrowid=stockoutmain.ROWID and
			stockoutmain.supplyid=customer.supplyid   and
			stockoutmain.stockid=stock.ROWID and
			stockoutdetail.productid=product.productid  and
			stockoutmain.sellman = user.USER_NAME
		group by
			product.productid
		order by
			product.productid
				";
$NEWAIINIT_VALUE_SYSTEM_NUM = "
		select
			count(stockinmain.tabledate) as num
		from
			stockoutmain,
			customer,
			stock,
			product,
			stockoutdetail,
			user
		where
			stockoutdetail.mainrowid=stockoutmain.ROWID and
			stockoutmain.supplyid=customer.supplyid   and
			stockoutmain.stockid=stock.ROWID and
			stockoutdetail.productid=product.productid  and
			stockoutmain.sellman = user.USER_NAME
		group by
			product.productid
		order by
			product.productid
				";
				*/
?>