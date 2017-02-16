<?php
    ini_set('display_errors', 1);
	ini_set('error_reporting', E_ALL);
	error_reporting(E_WARNING | E_ERROR);
	require_once('lib.inc.php');
	$GLOBAL_SESSION=returnsession();


//计算出公摊水电的费用

 function  gongtan_value($大楼名称,$单元号,$单价,$表倍率,$上月读数,$本月读数){

		global $db;

		if($大楼名称 != "" and $单元号 == ""){//此时按大楼公摊
		   
			   
			   //得到大楼信息
			   $dalou_sql = "select COUNT(*) AS NUM from wu_housingresources where 大楼名称='$大楼名称' and 单元状态='已经入住'";//此处可能有问题.............
			   $rs_lou = $db->Execute($dalou_sql);
			   $num = $rs_lou->fields['NUM'];//得到符合条件的单元数
			   $读数 = $本月读数-$上月读数;

			   $平均数1 = $读数/$num;//计算出每户的公摊量
			   $平均数 = round($平均数1,2);

			   $公摊费用1 = ($读数*$单价*$表倍率)/$num;
			   $公摊费用 = round($公摊费用1,2);//公摊费用进行四舍五入

		}
		else if($大楼名称 !="" and $单元号 !="")//此时按单元公摊
		{
			   
			   $danyuan_sql = "select COUNT(*) AS NUM from wu_housingresources where 大楼名称='$大楼名称' and 单元号='$单元号' and 单元状态='已经入住'";//此处可能有问题.............
			   $rs_dan = $db->Execute($danyuan_sql);
			   $num = $rs_dan->fields['NUM'];//得到符合条件的单元数
			   $读数 = $本月读数-$上月读数;

			   $平均数1 = $读数/$num;//计算出每户的公摊量
			   $平均数 = round($平均数1,2);

			   $公摊费用1 = ($读数*$单价*$表倍率)/$num;
			   $公摊费用 = round($公摊费用1,2);//公摊费用进行四舍五入
		} 
		else if($大楼名称 == "" and $单元号 == "") //此时按整个小区公摊
		{
			  
			   $quyu_sql = "select COUNT(*) AS NUM from wu_housingresources where 单元状态='已经入住'";//此处可能有问题.............
			   $rs_quyu = $db->Execute($quyu_sql);
			   $num = $rs_quyu->fields['NUM'];//得到符合条件的单元数
			   $读数 = $本月读数-$上月读数;

			   $平均数1 = $读数/$num;//计算出每户的公摊量
			   $平均数 = round($平均数1,2);

			   $公摊费用1 = ($读数*$单价*$表倍率)/$num;
			   $公摊费用 = round($公摊费用1,2);//公摊费用进行四舍五入

		}
			   return $公摊费用.",".$平均数;


  }



?>