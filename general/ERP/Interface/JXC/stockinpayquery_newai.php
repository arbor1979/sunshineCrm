<?php
require_once('lib.inc.php');
$sessionkey=returnSessKey();
$GLOBAL_SESSION=returnsession();
$SUNSHINE_USER_NAME = $_SESSION['SUNSHINE_USER_NAME'];
//$SUNSHINE_USER_NAME = 'admin';

$filetablename='stockinpayquery';

require_once('include.inc.php');

/*
$NEWAIINIT_VALUE_SYSTEM = "
				select stockinmain.tablecode,
						inflow.name as inflowname,
						stockinmain.tabledate,
						stock.name as stockname,
						supply.supplyshortname,
						intype.name as intypename,
						stockinmain.amt,
						stockinmain.factpayamt,
						stockinmain.payamt,
						stockinmain.factpayamt-stockinmain.payamt as topayamt,
						stockinmain.isfax,
						user.NICK_NAME as buyman,
						stockinmain.stockinsign,
						stockinmain.ROWID
				from	inflow,
						stockinmain,
						stock,
						supply,
						user,
						intype
				where	stockinmain.flowState=inflow.code   and
						stockinmain.stockid=stock.ROWID and
						stockinmain.supplyid=supply.supplyid   and
						stockinmain.intype=intype.ROWID      and
						stockinmain.buyman = user.USER_NAME  and
						stockinmain.tabledate>='$BEGIN_DATE' and
						stockinmain.tabledate<='$END_DATE'
				order by
						stockinmain.ROWID desc
				";
				*/
?>