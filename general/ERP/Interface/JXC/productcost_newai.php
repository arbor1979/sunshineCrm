<?php
require_once('lib.inc.php');
$sessionkey=returnSessKey();
$GLOBAL_SESSION=returnsession();
$SUNSHINE_USER_NAME = $_SESSION['SUNSHINE_USER_NAME'];


$filetablename='productcost';


require_once('include.inc.php');
/*

				select
					product.productid,
					product.productname,
					measure.name,
					product.standard,
					product.mode,
					sum(storedetail.stockinfactprice*storedetail.storefactnum)/sum(storedetail.storefactnum) stockinfactprice,
					sum(storedetail.storefactnum) storefactnum,
					sum(storedetail.stockinfactprice*storedetail.storefactnum) addnum,
					storedetail.ROWID
				from
					product,
					storedetail,
					measure
				where
					storedetail.productid=product.productid and
					measure.code=product.measureid and
					storedetail.storefactnum>0
				group by product.productid

				*/
?>