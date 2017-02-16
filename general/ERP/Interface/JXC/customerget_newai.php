<?php
require_once('lib.inc.php');
$sessionkey=returnSessKey();
$GLOBAL_SESSION=returnsession();
$SUNSHINE_USER_NAME = $_SESSION['SUNSHINE_USER_NAME'];
$SUNSHINE_USER_NAME = 'admin';

$filetablename='customerget';
$parse_filename='customerget';


require_once('include.inc.php');

/*
$NEWAIINIT_VALUE_SYSTEM = "select
									customer.`supplyid` as supplyid ,
									customer.`supplyname` as supplyname,
									SUM( sellplanamt.planamt )  as planamt,
									SUM( stockoutmain.amt ) as allrequiremoney,
									SUM( stockoutmain.factpayamt ) as factpayamt,
									SUM( stockoutmain.payamt )  as payamt,
									SUM( stockoutmain.amt ) - SUM( stockoutmain.payamt )  as notpayamt,
									customer.`phone` as phone,
									customer.`contactaddress` as contactaddress
									from
									customer, sellplanamt ,stockoutmain
									where
									sellplanamt.CustomerId = customer.supplyid
									and
									stockoutmain.supplyid = sellplanamt.CustomerId

									group by sellplanamt.CustomerId";
$NEWAIINIT_VALUE_SYSTEM_NUM = "select COUNT(*) as num
									from
									customer, sellplanamt ,stockoutmain
									where
									sellplanamt.CustomerId = customer.supplyid
									and
									stockoutmain.supplyid = sellplanamt.CustomerId

									group by sellplanamt.CustomerId";

*/
?>