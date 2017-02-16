<?php
require_once('lib.inc.php');
$sessionkey=returnSessKey();
$GLOBAL_SESSION=returnsession();
$SUNSHINE_USER_NAME = $_SESSION['SUNSHINE_USER_NAME'];
//$SUNSHINE_USER_NAME = 'admin';

$filetablename='paymentanalysis';


//and ( stockoutmain.user_id='admin' ) 
require_once('include.inc.php');

/*

$NEWAIINIT_VALUE_SYSTEM = "
				select 
					sum(stockoutdetail.stockoutfactnum*stockoutdetail.price) 
				from 
					stockoutdetail,
					stockoutmain 
				where 
					stockoutdetail.productid='2EHDR-3P' and 
					stockoutdetail.state='4' and 
					stockoutmain.rowid=stockoutdetail.mainrowid and 
					stockoutmain.flowState='1' and 
					stockoutmain.tabledate>='2007-12-01' and 
					stockoutmain.tabledate<'2008-01-01' and 
					stockoutmain.supplyid='134' 					
				group by 
					stockoutdetail.productid
				";
				*/
?>
重新寻找合格的SQL语句。