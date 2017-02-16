<?php
require_once('lib.inc.php');
$sessionkey=returnSessKey();
$GLOBAL_SESSION=returnsession();
$SUNSHINE_USER_NAME = $_SESSION['SUNSHINE_USER_NAME'];
//$SUNSHINE_USER_NAME = 'admin';

$filetablename='customersell';


//and ( stockoutmain.user_id='admin' )
require_once('include.inc.php');
/*
$NEWAIINIT_VALUE_SYSTEM = "
				select 
					customer.supplyid,
					customer.supplyname ,
					sum(stockoutmain.factpayamt) factpayamt1 ,
					sum(stockoutmain.payamt) payamt1 ,
					sum(stockoutmain.amt) amt1 ,
					sum(stockoutmain.amt) amt2 ,
					sum(stockoutmain.factpayamt) factpayamt2 ,
					sum(stockoutmain.factpayamt) factpayamt3 ,
					sum(stockoutmain.factpayamt) factpayamt4 ,
					sum(stockoutmain.payamt) payamt2 ,
					sum(stockoutmain.payamt) payamt3 ,
					sum(stockoutmain.payamt) payamt4 ,
					sum(stockoutmain.payamt) payamt5 ,
					sum(stockoutmain.payamt) payamt6 ,
					sum(stockoutmain.payamt) payamt7 ,
					sum(stockoutmain.factpayamt)-sum(stockoutmain.payamt) subamt 
				from 
					stockoutmain,
					customer 
				where 
					stockoutmain.supplyid=customer.ROWID 					 
					and stockoutmain.tabledate>='2007-04-01' 
					and stockoutmain.tabledate<='2007-04-15' 

				group by 
					stockoutmain.supplyid 
				order by 
					customer.supplyshortname 
				";
				*/
?>
表之间关联。