<?php
	ini_set('display_errors', 1);
	ini_set('error_reporting', E_ALL);
	error_reporting(E_WARNING | E_ERROR);
	require_once('lib.inc.php');
	$GLOBAL_SESSION=returnsession();
	
	
	if($_GET['action']=="add_default_data")		{

	    $停车位      = $_POST['停车位'];
		$车辆编码    = $_POST['车辆编码'];
		$车牌        = $_POST['车牌'];
		$车辆类别    = $_POST['车辆类别'];
		$车辆颜色    = $_POST['车辆颜色'];
		$车型        = $_POST['车型'];
		$房间号码    = $_POST['房间号码'];
		$业主        = $_POST['业主'];
		$月卡编号    = $_POST['月卡编号'];
		$车位状态    = $_POST['车位状态'];
		$联系电话    = $_POST['联系电话'];
		$缴费类型    = $_POST['缴费类型'];
		$所缴费月份  = $_POST['所缴费月份'];
		$使用开始时间= $_POST['使用开始时间'];
		$使用结束时间= $_POST['使用结束时间'];
		$是否缴费    = $_POST['是否缴费'];
		$备注        = $_POST['备注'];
        
		//查询这个月缴费纪录是否存在
		$sle_sql = "select COUNT(*) AS SUM from wuye_wuyetingchechangguanli where 停车位='$停车位' and 所缴费月份='$所缴费月份' and 是否缴费='$是否缴费'";
        $rs = $db->Execute($sle_sql);
		$num = $rs->fields['SUM'];

		if($num == 0){
        
			$guize = "select * from wu_tingchefeiguize where 缴费类型='$缴费类型'";
			$rs = $db->Execute($guize);
			$rs_a = $rs->GetArray();
			$缴费类型 = $rs_a[0]['缴费类型'];
			$费用     = $rs_a[0]['费用'];
			$优惠费用     = $rs_a[0]['优惠'];

			
			
			if($缴费类型=="一年交"){
				$费用a = $费用/12;
				$优惠费用a = $优惠费用/12;

				$单月费用 = number_format($费用a,2,'.','');
				$单月优惠 = number_format($优惠费用a,2,'.','');
				$实缴费用 = $单月费用-$单月优惠;

				for($i=1;$i<12;$i++){

				$缴费月份 = date("Y-m",mktime(1,1,1,date("m")+$i,date("d"),date("Y")));
				$sql = "insert into wuye_wuyetingchechangguanli(停车位,车辆编码,车牌,车辆类别,车辆颜色,车型,房间号码,业主,月卡编号,车位状态,联系电话,缴费类型,所缴费月份,应缴费用,优惠费用,实缴费用,使用开始时间,使用结束时间,是否缴费,备注) values('$停车位','$车辆编码','$车牌','$车辆类别','$车辆颜色','$车型','$房间号码','$业主','$月卡编号','$车位状态','$联系电话','$缴费类型','$缴费月份','$单月费用','$单月优惠','$实缴费用','$使用开始时间','$使用结束时间','$是否缴费','$备注')";

				$db->Execute($sql);
				}

			}else if($缴费类型=="半年交"){
                $费用a = $费用/6;
				$优惠费用a = $优惠费用/6;

				$单月费用 = number_format($费用a,2,'.','');
				$单月优惠 = number_format($优惠费用a,2,'.','');

				
				$实缴费用 = $单月费用-$单月优惠;
				for($i=1;$i<6;$i++){

				$缴费月份 = date("Y-m",mktime(1,1,1,date("m")+$i,date("d"),date("Y")));
				$sql = "insert into wuye_wuyetingchechangguanli(停车位,车辆编码,车牌,车辆类别,车辆颜色,车型,房间号码,业主,月卡编号,车位状态,联系电话,缴费类型,所缴费月份,应缴费用,优惠费用,实缴费用,使用开始时间,使用结束时间,是否缴费,备注) values('$停车位','$车辆编码','$车牌','$车辆类别','$车辆颜色','$车型','$房间号码','$业主','$月卡编号','$车位状态','$联系电话','$缴费类型','$缴费月份','$单月费用','$单月优惠','$实缴费用','$使用开始时间','$使用结束时间','$是否缴费','$备注')";

				$db->Execute($sql);
				}

			
			}else if($缴费类型=="季度交"){
				$费用a = $费用/3;
				$优惠费用a = $优惠费用/3;

				$单月费用 = number_format($费用a,2,'.','');
				$单月优惠 = number_format($优惠费用a,2,'.','');

				//echo $单月费用."<br>";
				//echo $单月优惠;
				//exit;

				$实缴费用 = $单月费用-$单月优惠;
				for($i=1;$i<3;$i++){

				$缴费月份 = date("Y-m",mktime(1,1,1,date("m")+$i,date("d"),date("Y")));
				$sql = "insert into wuye_wuyetingchechangguanli(停车位,车辆编码,车牌,车辆类别,车辆颜色,车型,房间号码,业主,月卡编号,车位状态,联系电话,缴费类型,所缴费月份,应缴费用,优惠费用,实缴费用,使用开始时间,使用结束时间,是否缴费,备注) values('$停车位','$车辆编码','$车牌','$车辆类别','$车辆颜色','$车型','$房间号码','$业主','$月卡编号','$车位状态','$联系电话','$缴费类型','$缴费月份','$单月费用','$单月优惠','$实缴费用','$使用开始时间','$使用结束时间','$是否缴费','$备注')";

				$db->Execute($sql);

				}

				//$upd = "update wuye_wuyetingchechangguanli set 应缴费用='$单月费用',优惠费用='$单月优惠',实缴费用='$实缴费用' where 停车位='$停车位' and 所缴费月份='$所缴费月份'";
				//$db->Execute($upd);
			
			}else if($缴费类型=="月交"){

				$单月费用 = number_format($费用);
				$单月优惠 = number_format($优惠费用);

				$实缴费用 = $单月费用-$单月优惠;
				

				$缴费月份 = date("Y-m",mktime(1,1,1,date("m"),date("d"),date("Y")));
				$sql = "insert into wuye_wuyetingchechangguanli(停车位,车辆编码,车牌,车辆类别,车辆颜色,车型,房间号码,业主,月卡编号,车位状态,联系电话,缴费类型,所缴费月份,应缴费用,优惠费用,实缴费用,使用开始时间,使用结束时间,是否缴费,备注) values('$停车位','$车辆编码','$车牌','$车辆类别','$车辆颜色','$车型','$房间号码','$业主','$月卡编号','$车位状态','$联系电话','$缴费类型','$缴费月份','$单月费用','$单月优惠','$实缴费用','$使用开始时间','$使用结束时间','$是否缴费','$备注')";
				
				$db->Execute($sql);
			}
			
			   $_POST['应缴费用']       = $单月费用;
			   $_POST['优惠费用']       = $单月优惠;
			   $_POST['实缴费用']       = $实缴费用;
			
		}else{
		
		    $PrintText .= "<BR><table  class=TableBlock align=center width=100%>";
			$PrintText .= "<TR class=TableContent><td ><font color=green ><center>
		    对不起，你输入的数据已经存在，请重新输入。 <BR>       
			<p><font color=\"red\" size=4><a href=wu_housingresources_newai.php>点击返回</a></font></p></center>
			</font></td></table>";
			print $PrintText; 
			exit;
		}
	}
	


	if($_GET['车位状态'] = "已租出")

	$filetablename = 'wuye_wuyetingchechangguanli';
	$parse_filename	= 'wuye1_wuyetingchechangguanli';
	require_once('include.inc.php');
?>