<?php
require_once('lib.inc.php');
$sessionkey=returnSessKey();
$GLOBAL_SESSION=returnsession();
$SUNSHINE_USER_NAME = $_SESSION['SUNSHINE_USER_NAME'];
//$SUNSHINE_USER_NAME = 'admin';

$filetablename='sellplanrate';



require_once('include.inc.php');
/*
$NEWAIINIT_VALUE_SYSTEM = "
			select
				sellplanmain.tablecode,
				user.NICK_NAME as buyman,
				customer.supplyname,
				department.DEPT_NAME,
				product.productname,
				sellplandetail.standard,
				sellplandetail.mode,
				sum(sellplandetail.plannum) AS plannum,
				sum(sellplandetail.plannum) AS plannumrate,
				sum(sellplandetail.stockinfactnum) AS stockinfactnum,
				sum(sellplandetail.stockinfactnum) AS stockinfactnumrate,
				sum(sellplandetail.money) AS money,
				sum(sellplandetail.money) AS moneyrate,
				sellplandetail.ROWID
			from
				sellplanmain,
				customer,
				department,
				product,
				sellplandetail,
				user
			where
				sellplandetail.mainrowid=sellplanmain.ROWID and
				sellplanmain.supplyid=customer.supplyid   and
				sellplanmain.stockid=department.DEPT_ID and
				sellplandetail.productid=product.productid  and
				sellplanmain.buyman = user.USER_NAME
			group by
				product.productid
			order by
				product.productid
				";
$NEWAIINIT_VALUE_SYSTEM_NUM = "
			select
				count(stockinmain.tabledate) as num
			from
				sellplanmain,
				customer,
				department,
				product,
				sellplandetail,
				user
			where
				sellplandetail.mainrowid=sellplanmain.ROWID and
				sellplanmain.supplyid=customer.supplyid   and
				sellplanmain.stockid=department.DEPT_ID and
				sellplandetail.productid=product.productid  and
				sellplanmain.buyman = user.USER_NAME
			group by
				product.productid
			order by
				product.productid
				";
				*/
?>