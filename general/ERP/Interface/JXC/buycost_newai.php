<?php
require_once('lib.inc.php');
$sessionkey=returnSessKey();
$GLOBAL_SESSION=returnsession();
$SUNSHINE_USER_NAME = $_SESSION['SUNSHINE_USER_NAME'];
//$SUNSHINE_USER_NAME = 'admin';

$filetablename='buycost';


//and  ( stockinmain.user_id='$SUNSHINE_USER_NAME' )  
require_once('include.inc.php');
/*
$NEWAIINIT_VALUE_SYSTEM = "
			select 
				product.productid,
				product.productname,
				measure.name,
				product.standard,
				product.mode, 
				sum(stockindetail.stockinfactnum) stockinfactnum,
				sum(stockindetail.money)/sum(stockindetail.stockinfactnum) price, 
				sum(stockindetail.money) money 
			from 
				stockinmain, 
				product, 
				stockindetail,
				measure  
			where 
				stockindetail.mainrowid=stockinmain.ROWID and 
				stockindetail.productid=product.productid and 
				measure.code=product.measureid  and 
				stockinmain.flowState='1'  
				  
			group by 
				product.productid 
				";
				*/
?>