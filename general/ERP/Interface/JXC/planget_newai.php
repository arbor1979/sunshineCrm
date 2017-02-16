<?php
require_once('lib.inc.php');
$sessionkey=returnSessKey();
$GLOBAL_SESSION=returnsession();
$SUNSHINE_USER_NAME = $_SESSION['SUNSHINE_USER_NAME'];
//$SUNSHINE_USER_NAME = 'admin';
//未确认SQL语句有效性
$filetablename='planget';


//and ( stockoutmain.user_id='$SUNSHINE_USER_NAME' ) 
require_once('include.inc.php');
/*

$NEWAIINIT_VALUE_SYSTEM = "
			select 
				customer.supplyid,
				customer.supplyname,
				DATE_add(stockoutmain.tabledate,INTERVAL stockoutmain.datascope DAY) as tabledate,
				stockoutmain.factpayamt-stockoutmain.payamt subamt ,
				stockoutmain.factpayamt expsamt ,
				stockoutmain.payamt factpayamt,
				stockoutmain.tablecode,
				stockoutmain.sellman,
				stockoutmain.ROWID 
			from 
				stockoutmain,
				customer 
			where 
				stockoutmain.supplyid=customer.supplyid 
				and stockoutmain.factpayamt>stockoutmain.payamt 
				 
				";
				*/
?>