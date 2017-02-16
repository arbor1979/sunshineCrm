<?php
    require_once('lib.inc.php');
    $GLOBAL_SESSION=returnsession();
	ini_set('display_errors', 1);
	ini_set('error_reporting', E_ALL);
	error_reporting(E_WARNING | E_ERROR);
	
	


    //加载gongtan_value（）函数
	require_once('gongtanshuidianfei.php');

	
	if($_GET['action']=="add_default_data")		{
            //print_r($_POST);

			//echo "<br>";

		  $单元编号   = $_POST['单元编号'];
		//得到本房间的单元号
		  $sql_danyuan = "select * from wu_housingresources where 房间号码='$单元编号'";
		  $rs_qy = $db->Execute($sql_danyuan);
		  $rs_a_qy = $rs_qy->GetArray();
		  $单元号 = $rs_a_qy[0]['单元号'];
		//得到大楼名称
		  $arr = explode('-',$单元编号);
		  $大楼名称 = $arr[0];


		  $费用年月份 = $_POST['费用年月份'];
		  $费用名称   = $_POST['费用名称'];
		  $本月读数   = $_POST['本月读数'];
		  $公摊方式   = $_POST['公摊方式'];

//echo $公摊方式."<br>";

      //得到上次缴费的月份
		  $arr = explode('-',$费用年月份);
		  $年份 = $arr[0];
		  $月份 = $arr[1];
		  $终止月份 = $月份-1;
		  $终止时间 = $年份."-0".$终止月份; 
      
	  //取得收费设置里面各种费用的单价标准
		  $sel_sql = "select * from wu_wpgsetmanagement where 表名称='$费用名称'";
		  $rs = $db->Execute($sel_sql);
		  $rs_a = $rs->GetArray();

//echo "aaaaaaaaaaaaaaaaaaaaaaaaaa<br>";
		  $单价 = $rs_a[0]['单价'];
		  $表倍率 = $rs_a[0]['表倍率'];
	  //$公摊或损耗 = $rs_a[0]['公摊或损耗'];
	  //$公摊方式 = $rs_a[0]['公摊方式'];

//echo $单价."<br>";

	  //得到对应单元的上月读数和起始时间
		  $d_sql = "select * from wu_wpgfeesdetails where 单元编号='$单元编号' and 费用年月份='$终止时间' and 费用名称='$费用名称'";
		  $result = $db->Execute($d_sql);
		  $rs_a1 = $result->GetArray();

		  $上月读数 = $rs_a1[0]['本月读数'];

//echo $上月读数."<br>";

	      $起始时间 = $rs_a1[0]['终止时间'];
			  //对起始时间进行处理，得到本月的终止时间
		  $arr = explode('-',$起始时间);
	   	  $年份 = $arr[0];
	   	  $月份 = $arr[1];
	      $日期 = $arr[2];
	      $终止月份 = $月份+1;
		  $终止时间 = $年份."-".$终止月份."-".$日期; 

      

//判断是否已经缴过费用
		  $pan_sql = "select COUNT(*) AS NUM from wu_wpgfeesdetails where 单元编号='$单元编号' and 费用年月份='$费用年月份' and 费用名称='$费用名称'";
		  $pan_rs = $db->Execute($pan_sql);
		  $pan_rs_a = $pan_rs->fields['NUM'];

      if($pan_rs_a == 0){


		  //判断缴费项目
		  if($费用名称 == "水费"){
				  //计算使用水量
				  
				  $本月水量1 = $本月读数-$上月读数;
				  $本月水量  = $本月水量1."(吨)";
				  $应缴金额 = $本月水量1*$单价*$表倍率;


			//echo $本月水量."<br>";
			//echo $应缴金额."<br>";

				  $_POST['上月读数'] = $上月读数;
			//$_POST['起始时间'] = $起始时间;

			//$_POST['终止时间'] = $终止时间;
				  
				  $_POST['单价']     = $单价."(元)";
				  $_POST['数量']     = $本月水量;
				  $_POST['应缴金额'] = $应缴金额;
		  }
		  else if($费用名称 == "电费")
		  {
				  //计算使用电量

				  $本月电量1 = $本月读数-$上月读数;
				  $本月电量  = $本月电量1."(度)";
				  $应缴金额 = $本月电量*$单价*$表倍率;

				  $_POST['上月读数'] = $上月读数;
			//$_POST['起始时间'] = $起始时间;

			//$_POST['终止时间'] = $终止时间;
				  
				  $_POST['单价']     = $单价;
				  $_POST['数量']     = $本月电量;
				  $_POST['应缴金额'] = $应缴金额;

				  
		  }
		  else if($费用名称 == "气费")
		  {
				  //计算使用气的费用
				  $本月气量1 = $本月读数-$上月读数;
				  $本月气量  = $本月气量1."(立方米)";
				  $应缴金额 = $本月气量*$单价*$表倍率;

				  $_POST['上月读数'] = $上月读数;
			//$_POST['起始时间'] = $起始时间;

			//$_POST['终止时间'] = $终止时间;
				  
				  $_POST['单价']     = $单价;
				  $_POST['数量']     = $本月气量;
				  $_POST['应缴金额'] = $应缴金额;
		  
		  }
		  else if($费用名称 == "公摊电费")
		  {
				 
				 if($公摊方式 == "单元公摊"){
					$数量 = $本月读数-$上月读数;
					$结果 = gongtan_value($大楼名称,$单元号,$单价,$表倍率,$上月读数,$本月读数);

					 
					$arr = explode(',',$结果);
					$公摊费用 = $arr[0];
					$单元公摊量 = $arr[1];
					
					$_POST['单价']     = $单价."(元)";
					$_POST['数量']     = $单元公摊量."(度)";
					$_POST['应缴金额'] = $公摊费用;
				 
				 }else if($公摊方式 == "大楼公摊"){
					$数量 = $本月读数-$上月读数;
					$结果 = gongtan_value($大楼名称,"",$单价,$表倍率,$上月读数,$本月读数);

					$arr = explode(',',$结果);
					$公摊费用 = $arr[0];
					$单元公摊量 = $arr[1];
					
					$_POST['单价']     = $单价."(元)";
					$_POST['数量']     = $单元公摊量."(度)";
					$_POST['应缴金额'] = $公摊费用;
				 
				 }else if($公摊方式 == "区域公摊"){
					$数量 = $本月读数-$上月读数;
					$结果 = gongtan_value("","",$单价,$表倍率,$上月读数,$本月读数);

					$arr = explode(',',$结果);
					$公摊费用 = $arr[0];
					$单元公摊量 = $arr[1];
					
					$_POST['单价']     = $单价."(元)";
					$_POST['数量']     = $单元公摊量."(度)";
					$_POST['应缴金额'] = $公摊费用;
				 }
		  
		  
		  }
		  else if($费用名称 == "公摊水费")
		  {



				  if($公摊方式 == "单元公摊"){


					$数量 = $本月读数-$上月读数;
					$结果 = gongtan_value($大楼名称,$单元号,$单价,$表倍率,$上月读数,$本月读数);
					
					$arr = explode(',',$结果);
					$公摊费用 = $arr[0];
					$单元公摊量 = $arr[1];

					
					$_POST['单价']     = $单价."(元)";
					$_POST['数量']     = $单元公摊量."(吨)";
					$_POST['应缴金额'] = $公摊费用;
				 
				 }else if($公摊方式 == "大楼公摊"){
					$数量 = $本月读数-$上月读数;
					$结果 = gongtan_value($大楼名称,"",$单价,$表倍率,$上月读数,$本月读数);

					
					$arr = explode(',',$结果);
					$公摊费用 = $arr[0];
					$单元公摊量 = $arr[1];
					
					$_POST['单价']     = $单价."(元)";
					$_POST['数量']     = $单元公摊量."(吨)";
					$_POST['应缴金额'] = $公摊费用;
				 
				 }else if($公摊方式 == "区域公摊"){
					$数量 = $本月读数-$上月读数;
					$结果 = gongtan_value("","",$单价,$表倍率,$上月读数,$本月读数);

					
					$arr = explode(',',$结果);
					$公摊费用 = $arr[0];
					$单元公摊量 = $arr[1];
					
					$_POST['单价']     = $单价."(元)";
					$_POST['数量']     = $单元公摊量."(吨)";
					$_POST['应缴金额'] = $公摊费用;
				 }
		  
		  
		  }


		}else{

			$PrintText .= "<BR><table  class=TableBlock align=center width=100%>";
			$PrintText .= "<TR class=TableContent><td ><font color=green >
			&nbsp;说明：<BR>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;此房间本月此费用已经缴过! <BR>       
			<center><p><font color=\"red\" size=4><a href=wu_housingresources_newai.php>点击返回</a></font></p></center>
			</font></td></table>";
			print $PrintText; 
			exit;
	
	   }

    }
	$_GET['费用名称'] = "水费,电费,气费,公摊水费,公摊电费";
	$filetablename		=	'wu_wpgfeesdetails';
	$parse_filename		=	'wu_wpgfeesdetails';
	require_once('include.inc.php');

		if($_GET['action']==''||$_GET['action']=='init_default'||$_GET['action']=='init_customer')		{
			$PrintText .= "<BR><table  class=TableBlock align=center width=100%>";
			$PrintText .= "<TR class=TableContent><td ><font color=green >
			说明：<BR>
			&nbsp;&nbsp;&nbsp;&nbsp;1 本页面显示水费、电费、气费、公摊电费、公摊水费的收费明细。<BR>
			&nbsp;&nbsp;&nbsp;&nbsp;2 此明细数据不能重复建立，根据唯一的单元编号、费用名称以及费用年月份进行设置。<BR>
			&nbsp;&nbsp;&nbsp;&nbsp;3 需要改动的数据在对应的行点击修改，进行改动。<BR>
			&nbsp;&nbsp;&nbsp;&nbsp;4 公摊的水电费用根据公摊水电费的单价进行单元公摊、大楼公摊、区域公摊进行计算公摊。<BR>
			&nbsp;&nbsp;&nbsp;&nbsp;5 ..............................................................................。<BR>
			</font></td></table>";
			print $PrintText;
		}
	
   ?>