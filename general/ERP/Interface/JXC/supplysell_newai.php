<?php
require_once('lib.inc.php');
$sessionkey=returnSessKey();
$GLOBAL_SESSION=returnsession();
$SUNSHINE_USER_NAME = $_SESSION['SUNSHINE_USER_NAME'];
//$SUNSHINE_USER_NAME = 'admin';

$filetablename='supplysell';

$NEWAIINIT_VALUE_SYSTEM = "
				select 
					supply.supplyid,
					supply.supplyname,
					sum(stockinmain.amt) amt ,
					sum(stockinmain.factpayamt) payamt ,
					sum(stockinmain.payamt) payamt ,
					sum(stockinmain.factpayamt) payamt ,
					sum(stockinmain.factpayamt) expsamt ,
					sum(stockinmain.payamt) factpayamt ,
					sum(stockinmain.payamt) factpayamt ,
					sum(stockinmain.payamt) factpayamt ,
					sum(stockinmain.payamt) factpayamt ,
					sum(stockinmain.payamt) factpayamt ,
					sum(stockinmain.payamt) factpayamt ,
					sum(stockinmain.factpayamt)-sum(stockinmain.payamt) subamt 
				from 
					stockinmain,
					supply 
				where 
					stockinmain.supplyid=supply.ROWID 
					and stockinmain.tabledate>='2007-04-01' 
					and stockinmain.tabledate<='2007-05-15' 
				group by 
					stockinmain.supplyid 
				order by 
					supply.supplyshortname 
				";
$NEWAIINIT_VALUE_SYSTEM_NUM = "
				select  
					count(supply.supplyid) as num
				from 
					stockinmain,
					supply 
				where 
					stockinmain.supplyid=supply.ROWID 
					and stockinmain.tabledate>='2007-04-01' 
					and stockinmain.tabledate<='2007-05-15' 
				group by 
					stockinmain.supplyid 
				order by 
					supply.supplyshortname
				";
//and ( stockinmain.user_id='admin' ) 
require_once('include.inc.php');
?>
多表关联，待定