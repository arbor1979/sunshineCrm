<?php
	ini_set('display_errors', 1);
	ini_set('error_reporting', E_ALL);
	error_reporting(E_WARNING | E_ERROR);
	require_once('lib.inc.php');
	$GLOBAL_SESSION=returnsession();

  if($_GET['go']=="submit"){
    
	$费用年月份 = $_POST['check_year_month'];
	//echo $费用年月份."<br>";
    

	// and 是否缴费='0'
    $select_sql = "select * from wu_wpgfeesdetails where 费用年月份='$费用年月份'";
	$rs = $db -> Execute($select_sql);
	$rs_a = $rs -> GetArray();
	//print_r($rs_a);
	$费用arr=array();

    for($i=0;$i<sizeof($rs_a);$i++)				{
		   $单元编号 = $rs_a[$i]['单元编号'];
		   $费用名称 = $rs_a[$i]['费用名称'];
           $费用arr[$单元编号]['单元编号'] = $rs_a[$i]['单元编号'];
		   $费用arr[$单元编号]['业主姓名'] = $rs_a[$i]['业主姓名'];
		   $费用arr[$单元编号]['联系方式'] = $rs_a[$i]['联系方式'];
		   $费用arr[$单元编号]['费用年月份'] = $rs_a[$i]['费用年月份'];
		   //$费用arr[$单元编号]['费用年份'] = $rs_a[$i]['费用年份'];
		   $费用arr[$单元编号][$费用名称]  = $rs_a[$i]['应缴金额'];
		   $费用arr2[$单元编号][$费用名称] = "$费用名称='".$rs_a[$i]['应缴金额']."'";
	}


	$费用key=array_keys($费用arr);
	//print_r($费用key);
	for($n=0;$n<sizeof($费用key);$n++)	{
			$单元编号	= $费用key[$n];
			$单元array	= $费用arr[$单元编号];
			$单元2array	= $费用arr2[$单元编号];


			$KEYS_INDEX = array_keys($单元array);
			$VALUES_INDEX = array_values($单元array);
			$KEYS_TEXT = join(",",$KEYS_INDEX);
			$VALUES_TEXT = "'".join("','",$VALUES_INDEX)."'";
			$sql = "select COUNT(*) AS NUM from wu_costsummary where 单元编号='$单元编号' and 费用年月份='".$费用年月份."'";
			$rs = $db->Execute($sql);
			if($rs->fields['NUM']==0)		{
				$sql = "insert into wu_costsummary ($KEYS_TEXT) values($VALUES_TEXT)";
			}
			else	{
				$VALUES_INDEX = array_values($单元2array);//返回数组中所有的值
				$UPDATE_TEXT = join(",",$VALUES_INDEX);
				$sql = "update wu_costsummary set $UPDATE_TEXT where 单元编号='$单元编号' and 费用年月份='".$费用年月份."'";

			}

			$db->Execute($sql);
	  }

	  for($m=0;$m<sizeof($费用key);$m++){
	        $单元编号   = $费用key[$m];
			$sql = "select 水费,电费,气费,公摊水费,公摊电费,物业管理费,卫生费,电梯管理费,车位费,装修押金,临时费用,其他费用 from wu_costsummary where 单元编号='$单元编号' and 费用年月份='".$费用年月份."'";
			$rs = $db -> Execute($sql);
			$rs_a = $rs -> GetArray();
			for($s=0;$s<sizeof($rs_a);$s++){
			    $水费 = $rs_a[$s]['水费'];
				$电费 = $rs_a[$s]['电费'];
				$气费 = $rs_a[$s]['气费'];
				$公摊水费 = $rs_a[$s]['公摊水费'];
				$公摊电费 = $rs_a[$s]['公摊电费'];
				$物业管理费 = $rs_a[$s]['物业管理费'];
				$卫生费 = $rs_a[$s]['卫生费'];
				$电梯管理费 = $rs_a[$s]['电梯管理费'];
				$车位费 = $rs_a[$s]['车位费'];
				$装修押金 = $rs_a[$s]['装修押金'];
				$临时费用 = $rs_a[$s]['临时费用'];
				$其他费用 = $rs_a[$s]['其他费用'];
				$本次应收 = $水费+$电费+$气费+$公摊水费+$公摊电费+$物业管理费+$卫生费+$电梯管理费+$车位费+$装修押金+$临时费用+$其他费用;

				//echo $本次应收;
				$update_sql = "update wu_costsummary set 本次应收='$本次应收' where 单元编号='".$单元编号."' and 费用年月份='".$费用年月份."'";

				$db -> Execute($update_sql);
			}
	  }

    }

	if($_GET['action']=="edit_default"){
	   
	   //print_r($_GET);

	   if($_GET['xx'] == "xx"){
	      
		  $编号 = $_GET['编号'];
		  $sel_sql = "select * from wu_costsummary where 编号='$编号'";
		  $rs = $db->Execute($sel_sql);
		  $rs_a = $rs->GetArray();
		      $单元编号   = $rs_a[0]['单元编号'];
			  $业主姓名   = $rs_a[0]['业主姓名'];
			  $联系方式   = $rs_a[0]['联系方式'];
			  $费用年月份 = $rs_a[0]['费用年月份'];
			  $水费       = $rs_a[0]['水费'];
			  $电费       = $rs_a[0]['电费'];
			  $气费       = $rs_a[0]['气费'];
			  $公摊电费   = $rs_a[0]['公摊电费'];
			  $公摊水费   = $rs_a[0]['公摊水费'];
			  $物业管理费 = $rs_a[0]['物业管理费'];
			  $卫生费     = $rs_a[0]['卫生费'];
			  $电梯管理费 = $rs_a[0]['电梯管理费'];
			  $车位费     = $rs_a[0]['车位费'];
			  $装修押金   = $rs_a[0]['装修押金'];
			  $临时费用   = $rs_a[0]['临时费用'];
			  $其他费用   = $rs_a[0]['其他费用'];	  
         
		 
		//定义一个费用数组
			$费用 = array('水费','电费','气费','公摊电费','公摊水费','卫生费','电梯管理费','车位费','装修押金','临时费用','其他费用');
			 foreach($费用 as $val){
			     $sql = "select COUNT(*) AS NUM from wu_wpgfeesdetails where 单元编号='".$单元编号."' and 费用年月份='".$费用年月份."' and 费用名称='$val'";
				 $rs1 = $db->Execute($sql);
                 $num = $rs1->fields['NUM'];
				 if($num != 0){
				   $upd = "update wu_wpgfeesdetails set 是否缴费='1' where 单元编号='$单元编号' and 费用年月份='$费用年月份' and 费用名称='$val'";
				   $db->Execute($upd);
				 }

			 }
	   }
   }
	$filetablename		=	'wu_costsummary';
	$parse_filename		=	'wu_costsummary';
	require_once('include.inc.php');
?>
