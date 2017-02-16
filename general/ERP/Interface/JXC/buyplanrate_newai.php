<?php
require_once('lib.inc.php');
$sessionkey=returnSessKey();
$GLOBAL_SESSION=returnsession();
$SUNSHINE_USER_NAME = $_SESSION['SUNSHINE_USER_NAME'];
//$SUNSHINE_USER_NAME = 'admin';

$filetablename='buyplanrate';


require_once('include.inc.php');
/*
$NEWAIINIT_VALUE_SYSTEM = "
			select 			
				buyplanmain.tablecode, 
				user.NICK_NAME as buyman, 
				supply.supplyname,   
				department.DEPT_NAME, 
				product.productname, 
				buyplandetail.standard,     
				buyplandetail.mode, 
				sum(buyplandetail.plannum) as plannum, 
				sum(buyplandetail.plannum) as plannumrate,   
				sum(buyplandetail.stockinfactnum) as stockinfactnum, 
				sum(buyplandetail.stockinfactnum) as stockinfactnumrate,   
				sum(buyplandetail.money) as money, 
				sum(buyplandetail.money) as moneyrate, 
				buyplandetail.ROWID 
			from   
				buyplanmain, 
				buyplandetail ,
				supply, 
				department, 
				product, 
				user
				
			where    
				buyplandetail.mainrowid=buyplanmain.ROWID and 
				buyplanmain.supplyid=supply.supplyid   and 
				buyplanmain.stockid=department.DEPT_ID and    
				buyplandetail.productid=product.productid and 
				buyplanmain.buyman  = user.USER_NAME
			group by 
				product.productid   
			order by 
				product.productid 
				";
				*/
?>