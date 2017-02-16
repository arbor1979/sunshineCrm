<?php
require_once('lib.inc.php');
$sessionkey=returnSessKey();
$GLOBAL_SESSION=returnsession();
$SUNSHINE_USER_NAME = $_SESSION['SUNSHINE_USER_NAME'];
//$SUNSHINE_USER_NAME = 'admin';

$filetablename='requirerate';



require_once('include.inc.php');

/*
$NEWAIINIT_VALUE_SYSTEM = "
			select
				requireplanmain.tablecode,
				user.NICK_NAME as requireman,
				department.DEPT_NAME,
				product.productname,
				requireplandetail.standard,
				requireplandetail.mode,
				sum(requireplandetail.plannum) AS plannum,
				sum(requireplandetail.plannum) AS plannumrate,
				sum(requireplandetail.stockinfactnum) AS stockinfactnum,
				sum(requireplandetail.stockinfactnum) AS stockinfactnumrate,
				sum(requireplandetail.money) AS money,
				sum(requireplandetail.money) AS moneyrate,
				requireplandetail.ROWID
			from
				requireplanmain,
				department,
				product,
				user,
				requireplandetail
			where
				requireplandetail.mainrowid=requireplanmain.ROWID    and
				requireplanmain.stockid=department.DEPT_ID and
				requireplandetail.productid=product.productid   and
				requireplanmain.requireman=user.USER_NAME
			group by
				product.productid
				order by product.productid
				";
*/
?>