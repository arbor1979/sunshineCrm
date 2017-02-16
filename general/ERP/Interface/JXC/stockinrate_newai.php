<?php
require_once('lib.inc.php');
$sessionkey=returnSessKey();
$GLOBAL_SESSION=returnsession();
$SUNSHINE_USER_NAME = $_SESSION['SUNSHINE_USER_NAME'];
//$SUNSHINE_USER_NAME = 'admin';

$filetablename='stockinrate';

$NEWAIINIT_VALUE_SYSTEM = "
			select 
				stockinmain.tablecode, 
				user.NICK_NAME as buyman, 
				supply.supplyname,   
				stock.name, 
				product.productname, 
				stockindetail.standard,     
				stockindetail.mode, 
				sum(stockindetail.plannum) AS plannum, 
				sum(stockindetail.plannum) AS plannumrate, 
				sum(stockindetail.stockinfactnum) AS stockinfactnum, 
				sum(stockindetail.stockinfactnum) AS stockinfactnumrate, 
				sum(stockindetail.money) AS money, 
				sum(stockindetail.money) AS moneyrate, 
				stockindetail.ROWID 
			from   
				stockinmain, 
				supply, 
				stock, 
				product, 
				stockindetail,
				user
			where    
				stockindetail.mainrowid=stockinmain.ROWID and 
				stockinmain.supplyid=supply.supplyid   and 
				stockinmain.stockid=stock.ROWID and    
				stockindetail.productid=product.productid and 
				stockinmain.buyman = user.USER_NAME
			group by 
				product.productid   
			order by 
				product.productid 
				";
$NEWAIINIT_VALUE_SYSTEM_NUM = "
			select  
				count(stockinmain.tabledate) as num
			from   
				stockinmain, 
				supply, 
				stock, 
				product, 
				stockindetail 
			where    
				stockindetail.mainrowid=stockinmain.ROWID and 
				stockinmain.supplyid=supply.ROWID   and 
				stockinmain.stockid=stock.ROWID and    
				stockindetail.productid=product.productid  
			group by 
				product.productid   
			order by 
				product.productid 
				";

require_once('include.inc.php');
?>