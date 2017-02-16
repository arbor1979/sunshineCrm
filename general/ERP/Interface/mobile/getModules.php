<?php

function getModules($params)
{
	global $db;
	
	$result=array();
	$UID=intval($params['用户较验码']['0']);
	$UTYPE=intval($params['用户较验码']['2']);

	$url=getCurPath()."/icons/";
	if($UTYPE>0)//员工的功能
	{
		$result[] = array("图标"=>$url."公告通知.png","文字"=>"活动公告","接口地址"=>"module_notice.php","模板名称"=>"通知");
		$result[] = array("图标"=>$url."临时单.png","文字"=>"临时单","接口地址"=>"module_tempBill.php","模板名称"=>"单据");
		$result[] = array("图标"=>$url."正式单.png","文字"=>"正式单","接口地址"=>"module_formalBill.php","模板名称"=>"单据");
		$result[] = array("图标"=>$url."产品维护.png","文字"=>"产品维护","接口地址"=>"module_product.php","模板名称"=>"单据");
		/*
		$result[] = array("图标"=>$url."出库单.png","文字"=>"出库单","接口地址"=>"module_stockOut.php","模板名称"=>"单据");
		$result[] = array("图标"=>$url."发货单.png","文字"=>"发货单","接口地址"=>"module_delivery.php","模板名称"=>"单据");
		$result[] = array("图标"=>$url."盘点单.png","文字"=>"盘点单","接口地址"=>"module_stockCheck.php","模板名称"=>"单据");
		//$result[] = array("图标"=>$url."收款单.png","文字"=>"收款单","接口地址"=>"module_collection.php","模板名称"=>"单据");

		$result[] = array("图标"=>$url."库存查询.png","文字"=>"库存查询","接口地址"=>"module_inventory.php","模板名称"=>"浏览器");
		$result[] = array("图标"=>$url."销售日报.png","文字"=>"销售日报","接口地址"=>"module_dailyPaper.php","模板名称"=>"浏览器");
		$result[] = array("图标"=>$url."客户排行.png","文字"=>"客户排行","接口地址"=>"module_customerRanking.php","模板名称"=>"浏览器");
		$result[] = array("图标"=>$url."导购排行.png","文字"=>"导购排行","接口地址"=>"module_shopperRanking.php","模板名称"=>"浏览器");
		$result[] = array("图标"=>$url."产品排行.png","文字"=>"产品排行","接口地址"=>"module_productRanking.php","模板名称"=>"浏览器");
		*/
		
	}
	else//客户的功能
	{

	}
	return $result;
}
?>