<?php
//########################################################################
//�ɹ������������뺯������################################################
//########################################################################
function dataDeal_add()			{
	global $_SESSION,$_GET,$_POST,$db;

	$tablename = "stockoutmain";
	$childtablename = "stockoutdetail";

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
	//���ݲ���תʱ�����õķ���
	global $SYSTEM_STOP_FLOW;
	if($SYSTEM_STOP_FLOW==1)		{
		array_push($FieldArray,"flowState");
		array_push($ValueArray,1);
	}
	//print_R($FieldArray);

	$FieldText = join(',',$FieldArray);
	$ValueText = join("','",$ValueArray);
	//�γ�����SQL����
	$sql = "insert into $tablename ( $FieldText ) values ( '".$ValueText."' );";
	$rs = $db->Execute($sql);
	$MainID = $db->Insert_ID();

	////print $sql."<BR>";
	//print_R($Columns);

	//#########################################################################
	//�ӱ��ֶβ���SQL����γ�##################################################
	//#########################################################################

	$sql="";

	$MaxValue = 10;
	if($_POST['productid_id_'.$MaxValue]!="")		$MaxValue = 20;
	if($_POST['productid_id_'.$MaxValue]!="")		$MaxValue = 30;
	if($_POST['productid_id_'.$MaxValue]!="")		$MaxValue = 40;
	if($_POST['productid_id_'.$MaxValue]!="")		$MaxValue = 50;
	if($_POST['productid_id_'.$MaxValue]!="")		$MaxValue = 60;
	if($_POST['productid_id_'.$MaxValue]!="")		$MaxValue = 70;
	if($_POST['productid_id_'.$MaxValue]!="")		$MaxValue = 80;
	if($_POST['productid_id_'.$MaxValue]!="")		$MaxValue = 90;
	if($_POST['productid_id_'.$MaxValue]!="")		$MaxValue = 100;

	//��ϸ�б�
	//$MainID = 9;//����ֵ
	for($m=0;$m<$MaxValue;$m++)		{
		$FieldArray = array();
		$ValueArray = array();
		//��ϸ�����ж�
		if($_POST['productid_id_'.$m]!="")		{
			//��ϸSQL����γ�
			for($i=0;$i<sizeof($ChildColumns);$i++)		{
				$Element = TRIM($ChildColumns[$i]);

				if($Element=="productid")		{
					$Element = "productid_id";
				}

				if($m==0)	{
					$Value = $_POST[$Element];
				}
				else if($Element=="stockoutfactnum")		{
					$Value = $_POST["plannum_".$m];
				}
				else	{
					$Value = $_POST[$Element."_".$m];
				}

				if($Value!="")		{
					array_push($FieldArray,$ChildColumns[$i]);
					array_push($ValueArray,$Value);
				}
			}
			$FieldText = join(',',$FieldArray);
			$ValueText = join("','",$ValueArray);
			//�γ�����SQL����
			$sql = "insert into $childtablename ( ".$FieldText.",mainrowid ) values ( '".$ValueText."','".$MainID."' );";
			$rs = $db->Execute($sql);
			////print $sql."<BR>";
		}
		
	}
	//print_R($FieldArray);


	//��ת�����Զ���
	global $SYSTEM_STOP_FLOW;
	if($SYSTEM_STOP_FLOW==1&&$MainID!="")			{
		StockOutToStore($MainID,1);
	}
}


//#########################################################################
//�༭��Ϣ��������ӣ�����ɾ��#############################################
//#########################################################################

function dataDeal_edit()			{
	global $_SESSION,$_GET,$_POST,$db;

	$tablename = "stockoutmain";
	$childtablename = "stockoutdetail";
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
	//�γ�����SQL����
	$sql = "update $tablename set $BodyText where ROWID='".$_POST['updateRowid']."';";
	$rs = $db->Execute($sql);
	$MainID = $_POST['updateRowid'];

	//print $sql."<BR>";
	//print_R($Columns);

	//#########################################################################
	//�ӱ��ֶβ���SQL����γ�##################################################
	//#########################################################################

	$sql="";

	$MaxValue = 10;
	if($_POST['productid_id_'.$MaxValue]!="")		$MaxValue = 20;
	if($_POST['productid_id_'.$MaxValue]!="")		$MaxValue = 30;
	if($_POST['productid_id_'.$MaxValue]!="")		$MaxValue = 40;
	if($_POST['productid_id_'.$MaxValue]!="")		$MaxValue = 50;
	if($_POST['productid_id_'.$MaxValue]!="")		$MaxValue = 60;
	if($_POST['productid_id_'.$MaxValue]!="")		$MaxValue = 70;
	if($_POST['productid_id_'.$MaxValue]!="")		$MaxValue = 80;
	if($_POST['productid_id_'.$MaxValue]!="")		$MaxValue = 90;
	if($_POST['productid_id_'.$MaxValue]!="")		$MaxValue = 100;
	//���²���
	//��ϸ�б�
	//$MainID = 9;//����ֵ
	$sql = "delete from $childtablename where mainrowid='$MainID'";
	$rs = $db->Execute($sql);
	//print $sql;
	for($m=0;$m<$MaxValue;$m++)		{
		$FieldArray = array();
		$ValueArray = array();
		//��ϸ�����ж�
		if($_POST['productid_id_'.$m]!="")		{
			//��ϸSQL����γ�
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
			//�γ�����SQL����
			$sql = "insert into $childtablename ( ".$FieldText.",mainrowid ) values ( '".$ValueText."','".$MainID."' );";
			$rs = $db->Execute($sql);
			//print $sql."<BR>";
		}
		
	}

	//print_R($FieldArray);
}





//�û�ȥ����ת
//���ܺ�����
//��һ������ⵥ��ת��Ϊ���
function StockOutToStore($Rowid,$flowState)		{
	global $db;
	if($Rowid=="")	exit;
	$MainTable = "stockoutmain";
	$DetailTable = "stockoutdetail";
	$sql = "select * from $MainTable where ROWID='$Rowid'";
	$rs = $db->Execute($sql);
	$rs_a = $rs->GetArray();
	//print_R($rs_a);	
	$tabledate = $rs_a[0]['tabledate'];
	$stockid = $rs_a[0]['stockid'];
	$stockiplaceid = $rs_a[0]['stockiplaceid'];
	$supplyid = $rs_a[0]['supplyid'];
	$tablecode = $rs_a[0]['tablecode'];

	$sql = "select * from $DetailTable where mainrowid='$Rowid'";
	$rs = $db->Execute($sql);
	$rs_a = $rs->GetArray();
	//print_R($rs_a);

	$stockinpersion = $SUNSHINE_USER_NAME;
	$Columns = returntablecolumn($DetailTable);
	for($i=0;$i<sizeof($rs_a);$i++)		{
		for($j=0;$j<sizeof($Columns);$j++)		{
			$Element = $Columns[$j];
			$$Element = $rs_a[$i][$Element];
		}
		$plannum==""?$plannum=0:'';
		

		//��һ������ⵥ��ת��Ϊ���
		//INSERT INTO `store` ( `productid` , `stocknum` , `storemaxnum` , `storeminnum` , `storesign` , `signtype` , `ROWID` , `mobilesign` , `stock` , `standard` , `mode` , `freenum` , `allnum` , `price` , `amt` ) 
		//VALUES (
		//'', '0', '', '', '', '0', '', '0', '', '', '', '0', '0', '0', '0'
		//);
		$sql = "select stocknum,ROWID from store where productid='$productid'";
		$rss = $db->Execute($sql);
		$rss_a = $rss->GetArray();
		//print $rss_a[0]['NUM'];exit;
		$allnum = $rss_a[0]['stocknum'];
		if($rss_a[0]['ROWID']!="")		{
			$sql = "update store set stocknum = stocknum - $plannum , allnum = allnum - $plannum, standard='$standard' , mode='$mode' ,price='$price' where productid='$productid'";
		}

		//else	{
			//$sql = "INSERT INTO `store` ( `productid` , `stocknum` , `storemaxnum` , `storeminnum` , `storesign` , `signtype` , `ROWID` , `mobilesign` , `stock` , `standard` , `mode` , `freenum` , `allnum` , `price` , `amt` ) 
			//VALUES ( '$productid' , '$plannum' , '$storemaxnum' , '$storeminnum' , '$storesign' , '$stockintype' , '' , '$mobilesign' , '$stockid' , '$standard' , '$mode' , '$freenum' , '$allnum' , '$price' , '$storeamt' );
			//";
		//}
		if($flowState=="1")				{
			$db->Execute($sql);
			////print $sql."<HR>";
		}
		else if($flowState=="-1")				{
			$sql = "update store set stocknum = stocknum + $plannum , allnum = allnum + $plannum , standard='$standard' , mode='$mode' ,price='$price' where productid='$productid'";
			$db->Execute($sql);
			////print $sql."<HR>";
		}

		//��ɿ���������²���


		
		//stockoutmain : tablecode tabledate stockoutpersion stockoutsign stockouttype userexplian stockpersion stockid stockiplaceid stockstate ROWID fillindate state exampersion supplyid user_id amt sellmess sellmobile outmess outmobile outtype flowState payamt factpayamt isfax issend sellman payment chinaAmt sendAmt rebate noFaxAmt fromRowId fromModuleId datascope invoice customerPO fromModuleId2 fromRowId2 tableNo 
		//stockoutdetail : stockoutcode receivecode ordercode productid plannum stockoutfactnum price money profitmoney costmoney stockoutdetailsign ROWID state stockouttype toreturn user_id mainrowid standard mode freenum allnum storenum 


		//�ڶ�������ⵥ��ת��Ϊ�����ϸ
		$storeamt = $plannum*$price;
		$sql = "INSERT INTO `storedetail` ( 
			`productid` , `stockinfactnum` , `storefactnum` , `stockoutfactnum` ,
			`stockincode` , `stockoutcode` , `storedetailsign` , `signtype` ,
			`ROWID` , `storecode` , `stockinfactprice` , `stockinpersion` ,
			`stockinmaincode` , `stockindate` , `user_id` , `stock` , 
			`stockplace` , `standard` , `mode` , `exchrowid` , 
			`freenum` , `allnum` , `storeamt` ) 
			VALUES (
			'$productid' , '$plannum' , '$allnum' , '$stockoutfactnum' ,
			'$stockincode' , '$tablecode' , '$stockoutdetailsign' , '$stockouttype' ,
			'' , '$storecode' , '$price' , '$stockinpersion' ,
			'$Rowid' , '$tabledate' , '$user_id' , '$stockid' , 
			'$stockiplaceid' , '$standard' , '$mode' , '$exchrowid' , 
			'$freenum' , '$allnum' , '$storeamt' 
		);
		";
		if($flowState=="1")				{
			$db->Execute($sql);
			////print $sql."<HR>";
		}


		
		
		
	}

	$sql = "delete from storedetail where stockoutcode='$tablecode'";
	if($flowState=="-1")				{
		$db->Execute($sql);
		////print $sql."<HR>";
	}

}

?>