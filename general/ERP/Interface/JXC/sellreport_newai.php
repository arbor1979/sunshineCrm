<?php
require_once('lib.inc.php');
$sessionkey=returnSessKey();
$GLOBAL_SESSION=returnsession();
$SUNSHINE_USER_NAME = $_SESSION['SUNSHINE_USER_NAME'];
//$SUNSHINE_USER_NAME = 'admin';

$filetablename='sellreport';

$NEWAIINIT_VALUE_SYSTEM = "
				select 
					product.productid,
					product.productname,
					sum(stockoutdetail.stockoutfactnum) factnum ,
					sum(stockoutdetail.money) payamt1 ,
					sum(stockoutdetail.money) payamt2 ,
					sum(stockoutdetail.money) payamt3 
				from 
					stockoutmain,
					product,
					stockoutdetail 
				where 
					stockoutmain.ROWID=stockoutdetail.mainrowid and 
					stockoutdetail.productid=product.productid 
					and stockoutmain.tabledate>='2007-06-01' 
					and stockoutmain.tabledate<='2007-06-17' 
				group by 
					product.productid 
				order by 
					product.productid 
				";
//and ( stockoutmain.user_id='admin' ) 
$NEWAIINIT_VALUE_SYSTEM_NUM = "
				select 
					count(product.productid) as num
				from 
					stockoutmain,
					product,
					stockoutdetail 
				where 
					stockoutmain.ROWID=stockoutdetail.mainrowid and 
					stockoutdetail.productid=product.productid 
					and stockoutmain.tabledate>='2007-06-01' 
					and stockoutmain.tabledate<='2007-06-17' 
				group by 
					product.productid 
				order by 
					product.productid  
				";
//stockoutmain.user_id='admin' ) and 
require_once('include.inc.php');
?>