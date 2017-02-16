<?php
//########################################################################
//采购订单数据输入函数处理################################################
//########################################################################

//Array ( [action] => dataDeal ) Array ( [tablecode] => 2007060006 [tabledate] => 2007-06-28 [supplyid_NAME] => 河南省生产力促进中心 [supplyid] => 2007060004 [supplyid_CODE] => 1 [supplyid_TABLE] => supply [user_id] => 512 [paymentid] => xj [bankid] => 1 [checkid] => [checkdate] => [currency] => 1 [paymoney] => 50 [factgetamt] => 43 [checkamt_ROWID] => 2007060004:3,2007060002:4, [checkamt] => 7 [paymainstate] => [a_count] => 12

//########################################################################
/*	企业应收账款核销算法
    1、一次付款从入库单据中得到应该付的款。
	2、可以从单笔款项中得出己付多少，未付多少。
	3、预付款核销：可以核定核销多少，未核销多少，多的则不允许进行核销
	4、第三条为不同单据间的判断：2007060004:3,2007060002:4
	5、同步数据更新到入库单据中，己经付款项，然后得出未付款数据。
	6、以上算法与销售管理中的销售收款一致。
*/
//########################################################################

function dataDeal_add()							{
	global $_SESSION,$_GET,$_POST,$db;

	$tablename = "paymain";
	$childtablename = "paydetail";

	//####################################################################
	//单据核销算法。
	$checkamt_ROWID = $_POST['checkamt_ROWID'];
	$checkamt_ROWID_Array = explode(',',$checkamt_ROWID);
	for($i=0;$i<sizeof($checkamt_ROWID_Array);$i++)			{
		$Element = $checkamt_ROWID_Array[$i];
		$Element_Array = explode(':',$Element);
		$AmtCode = $Element_Array[0];
		$AmtValue = $Element_Array[1];
		//核销预付款单据，从总数中核销多少，余下多少。
		if($AmtCode!="")			{
			$sql = "update buyplanamt set checkamt = checkamt+$AmtValue,lastamt = planamt - checkamt where tablecode='$AmtCode'";
			$db->Execute($sql);
			//print "核销预付款单据:".$sql."<BR>";
		}
		//预付款单据核销完成。
	}

	//更新付款数据到入库单算法。
	//此部分放在单据项
	//####################################################################

	$Columns = returntablecolumn($tablename);
	$ChildColumns = returntablecolumn($childtablename);

    //print_R($ChildColumns);print "<HR>";
	//print_R($Columns);print "<HR>";

	$sql="";

	$FieldArray = array();
	$ValueArray = array();

	for($i=0;$i<sizeof($Columns);$i++)		{
		$Element = $Columns[$i];
		$Value = $_POST[$Element];
		if($Value!="")		{
			array_push($FieldArray,$Element);
			switch($Element)	{
				case 'amt':
				case 'payamt':
				case 'factpayamt':
				case 'noFaxAmt':
					$Value = ereg_replace(',','',$Value);
					$Value = (float)$Value;
					break;
			}
			array_push($ValueArray,$Value);
		}
	}

	//print_R($FieldArray);
	//单据不流转时，采用的方法
	global $SYSTEM_STOP_FLOW;
	if($SYSTEM_STOP_FLOW==1)		{
		array_push($FieldArray,"flowState");
		array_push($ValueArray,1);
	}
	//print_R($FieldArray);

	$FieldText = join(',',$FieldArray);
	$ValueText = join("','",$ValueArray);
	//形成主表SQL插入
	$sql = "insert into $tablename ( $FieldText ) values ( '".$ValueText."' );";
	$rs = $db->Execute($sql);
	$MainID = $db->Insert_ID();

	//print $sql."<BR>";
	//print_R($Columns);

	//#########################################################################
	//从表字段插入SQL语句形成##################################################
	//#########################################################################

	$sql="";

	$MaxValue = 10;
	if($_POST['stockinid_id_'.$MaxValue]!="")		$MaxValue = 20;
	if($_POST['stockinid_id_'.$MaxValue]!="")		$MaxValue = 30;
	if($_POST['stockinid_id_'.$MaxValue]!="")		$MaxValue = 40;
	if($_POST['stockinid_id_'.$MaxValue]!="")		$MaxValue = 50;
	if($_POST['stockinid_id_'.$MaxValue]!="")		$MaxValue = 60;
	if($_POST['stockinid_id_'.$MaxValue]!="")		$MaxValue = 70;
	if($_POST['stockinid_id_'.$MaxValue]!="")		$MaxValue = 80;
	if($_POST['stockinid_id_'.$MaxValue]!="")		$MaxValue = 90;
	if($_POST['stockinid_id_'.$MaxValue]!="")		$MaxValue = 100;

	//明细列表
	//$MainID = 9;//主键值
	for($m=0;$m<$MaxValue;$m++)		{
		$FieldArray = array();
		$ValueArray = array();
		//明细单项判断id_stockinid_1
		if($_POST['stockinid_id_'.$m]!="")		{
			//明细SQL语句形成
			for($i=0;$i<sizeof($ChildColumns);$i++)		{
				$Element = TRIM($ChildColumns[$i]);
				if($Element=="productid")		{
					$Element = "productid_id";
				}
				if($m==0)	{
					$Value = $_POST[$Element];
				}
				else if($Element=="stockinfactnum")		{
					$Value = $_POST["plannum_".$m];
				}
				else	{
					$Value = $_POST[$Element."_".$m];
				}
				$Value = ereg_replace(',','',$Value);
				$Value = (int) $Value;
				if($Value!="")		{
					array_push($FieldArray,$ChildColumns[$i]);
					array_push($ValueArray,$Value);
				}
			}
			$FieldText = join(',',$FieldArray);
			$ValueText = join("','",$ValueArray);
			//形成主表SQL插入
			$stockinfactnum = $plannum;
			$sql = "insert into $childtablename ( ".$FieldText.",mainrowid ) values ( '".$ValueText."','".$MainID."' );";
			//$rs = $db->Execute($sql);
			//print $sql."<BR>";

			//更新付款数据到入库单算法。
			$stockinid = $_POST["stockinid_".$m];

			$thispaymoney = $_POST["thispaymoney_".$m];
			$thispaymoney = ereg_replace(',','',$thispaymoney);
			$thispaymoney = (float)$thispaymoney;

			$sql = "update stockinmain set payamt = payamt + $thispaymoney,factpayamt = amt - payamt where tablecode='$stockinid'";
			//print $sql."<HR>";exit;
			$db->Execute($sql);

		}
		
	}
	//print_R($FieldArray);
	//print_R($_POST);
	//exit;
}



//#########################################################################
//编辑信息，多则添加，少则删除#############################################
//#########################################################################

function dataDeal_edit()			{
	global $_SESSION,$_GET,$_POST,$db;

	$tablename = "paymain";
	$childtablename = "paydetail";
	$Columns = returntablecolumn($tablename);
	$ChildColumns = returntablecolumn($childtablename);
	$sql="";
	$FieldArray = array();
	$ValueArray = array();
	$updateSQL = array();
	for($i=0;$i<sizeof($Columns);$i++)		{
		$Element = $Columns[$i];
		$Value = $_POST[$Element];
		if($Value!="")		{
			//array_push($FieldArray,$Element);
			switch($Element)	{
				case 'amt':
				case 'payamt':
				case 'factpayamt':
				case 'money':
					$Value = ereg_replace(',','',$Value);
					$Value = (float)$Value;
					break;
			}
			//array_push($ValueArray,$Value);
			$updateText = "$Element = '".$Value."'";
			array_push($updateSQL,$updateText);
		}
	}
	$BodyText = join(',',$updateSQL);
	//形成主表SQL插入
	$sql = "update $tablename set $BodyText where ROWID='".$_POST['updateRowid']."';";
	$rs = $db->Execute($sql);
	$MainID = $_POST['updateRowid'];

	//print $sql."<BR>";
	print_R($Columns);

	//#########################################################################
	//从表字段插入SQL语句形成##################################################
	//#########################################################################

	$sql="";

	$MaxValue = 10;
	if($_POST['stockinid_id_'.$MaxValue]!="")		$MaxValue = 20;
	if($_POST['stockinid_id_'.$MaxValue]!="")		$MaxValue = 30;
	if($_POST['stockinid_id_'.$MaxValue]!="")		$MaxValue = 40;
	if($_POST['stockinid_id_'.$MaxValue]!="")		$MaxValue = 50;
	if($_POST['stockinid_id_'.$MaxValue]!="")		$MaxValue = 60;
	if($_POST['stockinid_id_'.$MaxValue]!="")		$MaxValue = 70;
	if($_POST['stockinid_id_'.$MaxValue]!="")		$MaxValue = 80;
	if($_POST['stockinid_id_'.$MaxValue]!="")		$MaxValue = 90;
	if($_POST['stockinid_id_'.$MaxValue]!="")		$MaxValue = 100;
	//更新部分
	//明细列表
	//$MainID = 9;//主键值
	$sql = "delete from $childtablename where mainrowid='$MainID'";
	$rs = $db->Execute($sql);
	//print $sql;
	for($m=0;$m<$MaxValue;$m++)		{
		$FieldArray = array();
		$ValueArray = array();
		//明细单项判断
		if($_POST['stockinid_id_'.$m]!="")		{
			//明细SQL语句形成
			for($i=0;$i<sizeof($ChildColumns);$i++)		{
				$Element = $ChildColumns[$i];
				

				switch($Element)	{
					case 'productid':
						$Element = "productid_id";
						break;
				}

				if($m==0)	{
					$Value = $_POST[$Element];
				}
				else	{
					$Value = $_POST[$Element."_".$m];
				}

				switch($Element)	{
					case 'amt':
					case 'payamt':
					case 'money':
					case 'factpayamt':
					case 'noFaxAmt':
						$Value = ereg_replace(',','',$Value);
						$Value = (float)$Value;
						break;
					case 'productid':
						$Element = "productid_id";
						break;
				}

				//if($Value=="1,332") exit;

				

				if($Value!="")		{
					array_push($FieldArray,$ChildColumns[$i]);
					array_push($ValueArray,$Value);
				}
			}
			$FieldText = join(',',$FieldArray);
			$ValueText = join("','",$ValueArray);
			//形成主表SQL插入
			$sql = "insert into $childtablename ( ".$FieldText.",mainrowid ) values ( '".$ValueText."','".$MainID."' );";
			$rs = $db->Execute($sql);
			//print $sql."<BR>";
		}
		
	}

	print_R($FieldArray);
}



?>