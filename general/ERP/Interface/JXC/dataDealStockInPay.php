<?php
//########################################################################
//�ɹ������������뺯������################################################
//########################################################################

//Array ( [action] => dataDeal ) Array ( [tablecode] => 2007060006 [tabledate] => 2007-06-28 [supplyid_NAME] => ����ʡ�������ٽ����� [supplyid] => 2007060004 [supplyid_CODE] => 1 [supplyid_TABLE] => supply [user_id] => 512 [paymentid] => xj [bankid] => 1 [checkid] => [checkdate] => [currency] => 1 [paymoney] => 50 [factgetamt] => 43 [checkamt_ROWID] => 2007060004:3,2007060002:4, [checkamt] => 7 [paymainstate] => [a_count] => 12

//########################################################################
/*	��ҵӦ���˿�����㷨
    1��һ�θ������ⵥ���еõ�Ӧ�ø��Ŀ
	2�����Դӵ��ʿ����еó��������٣�δ�����١�
	3��Ԥ������������Ժ˶��������٣�δ�������٣������������к���
	4��������Ϊ��ͬ���ݼ���жϣ�2007060004:3,2007060002:4
	5��ͬ�����ݸ��µ���ⵥ���У����������Ȼ��ó�δ�������ݡ�
	6�������㷨�����۹����е������տ�һ�¡�
*/
//########################################################################

function dataDeal_add()							{
	global $_SESSION,$_GET,$_POST,$db;

	$tablename = "paymain";
	$childtablename = "paydetail";

	//####################################################################
	//���ݺ����㷨��
	$checkamt_ROWID = $_POST['checkamt_ROWID'];
	$checkamt_ROWID_Array = explode(',',$checkamt_ROWID);
	for($i=0;$i<sizeof($checkamt_ROWID_Array);$i++)			{
		$Element = $checkamt_ROWID_Array[$i];
		$Element_Array = explode(':',$Element);
		$AmtCode = $Element_Array[0];
		$AmtValue = $Element_Array[1];
		//����Ԥ����ݣ��������к������٣����¶��١�
		if($AmtCode!="")			{
			$sql = "update buyplanamt set checkamt = checkamt+$AmtValue,lastamt = planamt - checkamt where tablecode='$AmtCode'";
			$db->Execute($sql);
			//print "����Ԥ�����:".$sql."<BR>";
		}
		//Ԥ����ݺ�����ɡ�
	}

	//���¸������ݵ���ⵥ�㷨��
	//�˲��ַ��ڵ�����
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

	//print $sql."<BR>";
	//print_R($Columns);

	//#########################################################################
	//�ӱ��ֶβ���SQL����γ�##################################################
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

	//��ϸ�б�
	//$MainID = 9;//����ֵ
	for($m=0;$m<$MaxValue;$m++)		{
		$FieldArray = array();
		$ValueArray = array();
		//��ϸ�����ж�id_stockinid_1
		if($_POST['stockinid_id_'.$m]!="")		{
			//��ϸSQL����γ�
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
			//�γ�����SQL����
			$stockinfactnum = $plannum;
			$sql = "insert into $childtablename ( ".$FieldText.",mainrowid ) values ( '".$ValueText."','".$MainID."' );";
			//$rs = $db->Execute($sql);
			//print $sql."<BR>";

			//���¸������ݵ���ⵥ�㷨��
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
//�༭��Ϣ��������ӣ�����ɾ��#############################################
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
	//�γ�����SQL����
	$sql = "update $tablename set $BodyText where ROWID='".$_POST['updateRowid']."';";
	$rs = $db->Execute($sql);
	$MainID = $_POST['updateRowid'];

	//print $sql."<BR>";
	print_R($Columns);

	//#########################################################################
	//�ӱ��ֶβ���SQL����γ�##################################################
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
		if($_POST['stockinid_id_'.$m]!="")		{
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

	print_R($FieldArray);
}



?>