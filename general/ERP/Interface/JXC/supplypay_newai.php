<?php
$filetablename='supplypay';
$parse_filename = 'supplypay';

require_once('include.inc.php');


/*
此视图己存在
create view supplypay as select	supply.`ROWID`  as ROWID,
									supply.`supplyid` as supplyid ,
									supply.`supplyname` as supplyname,
									SUM( buyplanamt.planamt )  as planamt,
									SUM( stockinmain.amt ) as allrequiremoney,
									SUM( stockinmain.factpayamt ) as factpayamt,
									SUM( stockinmain.payamt )  as payamt,
									SUM( stockinmain.amt ) - SUM( stockinmain.payamt )  as notpayamt,
									supply.`phone` as phone,
									supply.`contactaddress` as contactaddress
									from
									supply, buyplanamt ,stockinmain
									where
									buyplanamt.SupplyId = supply.supplyid
									and
									stockinmain.supplyid = buyplanamt.SupplyId
									and
									stockinmain.supplyid = supply.supplyid
									group by buyplanamt.SupplyId
*/
?>