<?php

	ini_set('display_errors', 1);
	ini_set('error_reporting', E_ALL);
	error_reporting(E_WARNING | E_ERROR);
	require_once('lib.inc.php');
	$GLOBAL_SESSION=returnsession();
	
	if($_GET['action']=="add_default_data")		{
        
			   $单元编号   = $_POST['单元编号'];
			   $业主姓名   = $_POST['业主姓名'];
			   $联系方式   = $_POST['联系方式'];
			   $单元用途   = $_POST['单元用途'];
			   $备注       = $_POST['备注'];
			   $建筑面积   = $_POST['建筑面积'];
			   $使用面积   = $_POST['使用面积'];
			   $公摊面积   = $_POST['公摊面积'];
			   $单元人口   = $_POST['单元人口'];
			   $费用名称   = $_POST['费用名称'];
			   $费用年月份1 = $_POST['费用年月份'];
			   //$起始时间   = $_POST['起始时间'];
			   //$终止时间   = $_POST['终止时间'];
		
			   $开始年月份 = date("Y-m",mktime(1,1,1,date("m")-1,date("d"),date("Y")));
			   $计费方式   = $_POST['计费方式'];

		//查询数据是否存在
		$sel_sql = "select COUNT(*) AS NUM from wu_wpgfeesdetails where 单元编号='$单元编号' and 费用名称='$费用名称' and 费用年月份='$费用年月份1'";
		$sel_rs = $db->Execute($sel_sql);
		$num = $sel_rs->fields['NUM'];
        

		if($num == 0){
           
			   

		      //得到物业管理费的收费标准
			  $sql = "select * from wu_propertycostsset where 费用名称='$费用名称'";
			  $rs = $db->Execute($sql);
			  $rs_a = $rs->GetArray();
			  $计算方式 = $rs_a[0]['计算方式'];
			  $收费方式 = $rs_a[0]['收费方式'];
			  $单价     = $rs_a[0]['单价'];
			  $收费周期 = $rs_a[0]['收费周期'];

		   if($费用名称 == "物业管理费"){

				   //判断计费方式
				   if($计费方式 == "按月收费" or $计费方式 == "次数"){
					   //按月收费计算
					   $总面积   = $建筑面积+$公摊面积;
					   $应缴金额 = $单价*$总面积;
					   $数量 = "1个月";
					  
				   }
				   else if($计费方式 == "半年收费")
				   {
						//按半年收费进行计算,循环五次生成六条记录
                       //对起始时间跟终止时间进行字符串处理

						$总面积   = $建筑面积+$公摊面积;
						$应缴金额 = $单价*$总面积;
						$数量 = "1个月";

						for($i=1;$i<6;$i++){
                            


							/*
							//对读取到的起始和终止时间进行字符串处理
                            $arr1 = explode("-",$起始时间); 
							$起始年1 = $arr1[0];
							$起始月1 = $arr1[1];
							$起始月11 = $起始月1+$i;
                     echo $起始月11."<br>";
							$起始日1 = $arr1[2];
							if($起始月1>12){
                               $起始月 = $起始月1%12;
                               $起始年 = $起始年1+1;
                    echo "aaa<br>";

                               
							   $起始时间 = $起始年."-".$起始月."-".$起始日1;
					   
					        }else{

					echo "aaa<br>";
							   $起始时间 = $起始年1."-".$起始月11."-".$起始日1;

					echo $起始时间."<br>";
							
							}
                            
							$arr2 = explode("-",$终止时间);
							$终止年2 = $arr2[0];
							$终止月2 = $arr2[1];
                            $终止月22 = $终止月2+$i;
                    // echo $终止月2."<br>";
							$终止日2 = $arr2[2];
							if($终止月22>12){
                               $终止月 = $终止月22%12;
                               $终止年 = $终止年2+1;
                               
							   $终止时间 = $终止年."-".$终止月."-".$终止日2;
					   
					        }else{
							   $终止时间 = $终止年2."-".$终止月22."-".$终止日2;

					//echo $终止时间."<br>";
							
							}
                            */


							$起始时间 = date("Y-m-d",mktime(1,1,1,date("m")-1+$i,date("d"),date("Y")));
							$终止时间 = date("Y-m-d",mktime(1,1,1,date("m")+$i,date("d"),date("Y")));


							$费用年月份 = date("Y-m",mktime(1,1,1,date("m")-1+$i,date("d"),date("Y")));

							$sql = "insert into wu_wpgfeesdetails(单元编号,业主姓名,联系方式,建筑面积,使用面积,公摊面积,单元用途,单元人口,费用名称,费用年月份,计费方式,起始时间,终止时间,单价,数量,应缴金额,备注) values('$单元编号','$业主姓名','$联系方式','$建筑面积','$使用面积','$公摊面积','$单元用途','$单元人口','$费用名称','$费用年月份','$计费方式','$起始时间','$终止时间','$单价','$数量','$应缴金额','$备注')";
							$db->Execute($sql);
						
						}
						
	
				  // exit;


				   }
				   else if($计费方式 == "一年收费")
				   {
						//按一年收费进行计算
						$总面积   = $建筑面积+$公摊面积;
						$应缴金额 = $单价*$总面积;
							$数量 = "1个月";
							for($i=1;$i<12;$i++){

                            $起始时间 = date("Y-m-d",mktime(1,1,1,date("m")-1+$i,date("d"),date("Y")));
							$终止时间 = date("Y-m-d",mktime(1,1,1,date("m")+$i,date("d"),date("Y")));
                            
							$费用年月份 = date("Y-m",mktime(1,1,1,date("m")-1+$i,date("d"),date("Y")));

							$sql = "insert into wu_wpgfeesdetails(单元编号,业主姓名,联系方式,建筑面积,使用面积,公摊面积,单元用途,单元人口,费用名称,费用年月份,计费方式,起始时间,终止时间,单价,数量,应缴金额,备注) values('$单元编号','$业主姓名','$联系方式','$建筑面积','$使用面积','$公摊面积','$单元用途','$单元人口','$费用名称','$费用年月份','$计费方式','$起始时间','$终止时间','$单价','$数量','$应缴金额','$备注')";
							$db->Execute($sql);
						}
						
				   
				   }
              
		   
		   }
		   else if($费用名称 == "卫生费")
		   {
					//判断计费方式
				   if($计费方式 == "按月收费" or $计费方式 == "次数"){
					   //按月收费计算
					   $应缴金额 = $单价*$公摊面积;
					   $数量 = "1个月";
					  
				   }
				   else if($计费方式 == "半年收费")
				   {
						//按半年收费进行计算
							$应缴金额 = $单价*$公摊面积;
							$数量 = "1个月";
							for($i=1;$i<6;$i++){

							$起始时间 = date("Y-m-d",mktime(1,1,1,date("m")-1+$i,date("d"),date("Y")));
							$终止时间 = date("Y-m-d",mktime(1,1,1,date("m")+$i,date("d"),date("Y")));
                            
							$费用年月份 = date("Y-m",mktime(1,1,1,date("m")-1+$i,date("d"),date("Y")));

							$sql = "insert into wu_wpgfeesdetails(单元编号,业主姓名,联系方式,建筑面积,使用面积,公摊面积,单元用途,单元人口,费用名称,费用年月份,计费方式,起始时间,终止时间,单价,数量,应缴金额,备注) values('$单元编号','$业主姓名','$联系方式','$建筑面积','$使用面积','$公摊面积','$单元用途','$单元人口','$费用名称','$费用年月份','$计费方式','$起始时间','$终止时间','$单价','$数量','$应缴金额','$备注')";
							$db->Execute($sql);
						
						}
				   
				   }
				   else if($计费方式 == "一年收费")
				   {
						//按一年收费进行计算
							$应缴金额 = $单价*$公摊面积;
						//对费用年月份进行处理
							$数量 = "1个月";

							for($i=1;$i<12;$i++){

                                $起始时间 = date("Y-m-d",mktime(1,1,1,date("m")-1+$i,date("d"),date("Y")));
							    $终止时间 = date("Y-m-d",mktime(1,1,1,date("m")+$i,date("d"),date("Y")));
                            
								$费用年月份 = date("Y-m",mktime(1,1,1,date("m")-1+$i,date("d"),date("Y")));

								$sql = "insert into wu_wpgfeesdetails(单元编号,业主姓名,联系方式,建筑面积,使用面积,公摊面积,单元用途,单元人口,费用名称,费用年月份,计费方式,起始时间,终止时间,单价,数量,应缴金额,备注) values('$单元编号','$业主姓名','$联系方式','$建筑面积','$使用面积','$公摊面积','$单元用途','$单元人口','$费用名称','$费用年月份','$计费方式','$起始时间','$终止时间','$单价','$数量','$应缴金额','$备注')";
								$db->Execute($sql);						
							}
				   
				   }
			   
		   
		   }
		   else if($费用名称 == "电梯管理费")
		   {
			           //判断计费方式
				   if($计费方式 == "按月收费" or $计费方式 == "次数"){
					   //按月收费计算
					   $应缴金额 = $单价*$单元人口;
					   $数量 = "1个月";
					  
				   }
				   else if($计费方式 == "半年收费")
				   {
						//按半年收费进行计算
						$应缴金额 = $单价*$单元人口;
						$数量 = "1个月";
						for($i=1;$i<6;$i++){

							$起始时间 = date("Y-m-d",mktime(1,1,1,date("m")-1+$i,date("d"),date("Y")));
							$终止时间 = date("Y-m-d",mktime(1,1,1,date("m")+$i,date("d"),date("Y")));
                            
							$费用年月份 = date("Y-m",mktime(1,1,1,date("m")-1+$i,date("d"),date("Y")));

							$sql = "insert into wu_wpgfeesdetails(单元编号,业主姓名,联系方式,建筑面积,使用面积,公摊面积,单元用途,单元人口,费用名称,费用年月份,计费方式,起始时间,终止时间,单价,数量,应缴金额,备注) values('$单元编号','$业主姓名','$联系方式','$建筑面积','$使用面积','$公摊面积','$单元用途','$单元人口','$费用名称','$费用年月份','$计费方式','$起始时间','$终止时间','$单价','$数量','$应缴金额','$备注')";
							$db->Execute($sql);						
						}
				   
				   }
				   else if($计费方式 == "一年收费")
				   {
						//按一年收费进行计算
						$应缴金额 = $单价*$单元人口;
						$数量 = "1个月";
						for($i=1;$i<12;$i++){

							$起始时间 = date("Y-m-d",mktime(1,1,1,date("m")-1+$i,date("d"),date("Y")));
							$终止时间 = date("Y-m-d",mktime(1,1,1,date("m")+$i,date("d"),date("Y")));
                            
							$费用年月份 = date("Y-m",mktime(1,1,1,date("m")-1+$i,date("d"),date("Y")));

							$sql = "insert into wu_wpgfeesdetails(单元编号,业主姓名,联系方式,建筑面积,使用面积,公摊面积,单元用途,单元人口,费用名称,费用年月份,计费方式,起始时间,终止时间,单价,数量,应缴金额,备注) values('$单元编号','$业主姓名','$联系方式','$建筑面积','$使用面积','$公摊面积','$单元用途','$单元人口','$费用名称','$费用年月份','$计费方式','$起始时间','$终止时间','$单价','$数量','$应缴金额','$备注')";
							$db->Execute($sql);						
						}
				   
				   }
			   
		   
		   }
		   else if($费用名称 == "装修押金")
		   {
				   //装修押金单价就等于应缴金额

				   $应缴金额 = $单价;
				   $数量 = "1次";
				   
		   
		   }
		   else if($费用名称 == "临时性费用")
		   {
				   //临时性费用就等于应缴金额
				   $应缴金额 = $单价;
				   $数量 = "1次";
		   
		   }
		   else if($费用名称 == "其他费用")
		   {
				   //其他费用就等于应缴金额
				   $应缴金额 = $单价;
				   $数量 = "1次";
		   
		   }

		   $_POST['费用年月份'] = $费用年月份1;
		   $_POST['单价']       = $单价;
		   $_POST['数量']       = $数量;
		   $_POST['应缴金额']   = $应缴金额;


		}else{
		
		    $PrintText .= "<BR><table  class=TableBlock align=center width=100%>";
			$PrintText .= "<TR class=TableContent><td ><font color=green >
			&nbsp;说明：<BR>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;对不起，你输入的数据已经存在，请重新输入。 <BR>       
			<center><p><font color=\"red\" size=4><a href=wu1_wpgfeesdetails_newai.php>点击返回</a></font></p></center>
			</font></td></table>";
			print $PrintText; 
			exit;
	
		}
//exit;
		
	}


		$_GET['费用名称'] = "物业管理费,卫生费,电梯管理费,车位费,装修押金,临时性费用,其他费用";


		$filetablename		=	'wu_wpgfeesdetails';
		$parse_filename		=	'wu1_wpgfeesdetails';
		require_once('include.inc.php');

		if($_GET['action']==''||$_GET['action']=='init_default'||$_GET['action']=='init_customer')		{
			$PrintText .= "<BR><table  class=TableBlock align=center width=100%>";
			$PrintText .= "<TR class=TableContent><td ><font color=green >
			说明：<BR>
			&nbsp;&nbsp;&nbsp;&nbsp;1 本页面显示物业管理费、卫生费、电梯管理费、装修押金、临时性费用以及其他费用的收费明细。<BR>
			&nbsp;&nbsp;&nbsp;&nbsp;2 此明细数据不能重复建立，根据唯一的单元编号、费用名称以及费用年月份进行设置。<BR>
			&nbsp;&nbsp;&nbsp;&nbsp;3 需要改动的数据在对应的行点击修改，进行改动。<BR>
			&nbsp;&nbsp;&nbsp;&nbsp;4 物业管理费是根据对应的单价乘以所在单元的建筑面积加上公摊面积按月计算的。<BR>
			&nbsp;&nbsp;&nbsp;&nbsp;5 卫生费是根据对应单价乘以单元公摊的面积按月计算，电梯管理费根据对应的单价乘以单元的常住人口按月计算的。<BR>
			</font></td></table>";
			print $PrintText;
		}
	
	?>
