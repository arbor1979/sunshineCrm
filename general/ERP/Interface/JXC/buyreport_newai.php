<?php
require_once('lib.inc.php');
$sessionkey=returnSessKey();
$GLOBAL_SESSION=returnsession();
$SUNSHINE_USER_NAME = $_SESSION['SUNSHINE_USER_NAME'];
//$SUNSHINE_USER_NAME = 'admin';

$filetablename='buyreport';


//and ( stockinmain.user_id='admin' )
require_once('include.inc.php');
/*
$NEWAIINIT_VALUE_SYSTEM = "
				select 
					product.productid,
					product.productname,
					sum(stockindetail.stockinfactnum) stockinfactnum ,
					sum(stockindetail.money) payamt1 ,
					sum(stockindetail.money) payamt2 ,
					sum(stockindetail.money) payamt3 
				from 
					stockinmain,
					product,
					stockindetail 
				where 
					stockinmain.ROWID=stockindetail.mainrowid 
					and stockindetail.productid=product.productid 
					and stockinmain.tabledate>='2006-05-09' 
					and stockinmain.tabledate<='2007-05-29' 
				group by 
					product.productid 
				order by 
					product.productid
				";
				*/
?>
少明细列表部分