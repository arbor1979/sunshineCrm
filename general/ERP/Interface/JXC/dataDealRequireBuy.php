<?php
//########################################################################
//�ɹ��ƻ��������뺯������################################################
//########################################################################
function dataDeal_add()			{
	global $_SESSION,$_GET,$_POST,$db;

	$tablename = "requireplanmain";
	$childtablename = "requireplandetail";

	$Columns = returntablecolumn($tablename);
	$ChildColumns = returntablecolumn($childtablename);

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
				$Element = $ChildColumns[$i];
				if($Element=="productid")		{
					$Element = "productid_id";
				}
				if($m==0)	{
					$Value = $_POST[$Element];
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
			//print $sql."<BR>";
		}
		
	}
	//print_R($FieldArray);
}

//#########################################################################
//�༭��Ϣ��������ӣ�����ɾ��#############################################
//#########################################################################

function dataDeal_edit()			{
	global $_SESSION,$_GET,$_POST,$db;

	$tablename = "requireplanmain";
	$childtablename = "requireplandetail";
	$Columns = returntablecolumn($tablename);
	$ChildColumns = returntablecolumn($childtablename);
	$sql="";
	$FieldArray = array();
	$ValueArray = array();
	$updateSQL = array();
	for($i=0;$i<sizeof($Columns);$i++)		{
		$Element = $Columns[$i];
		if($Element=="productid")		{
			$Element = "productid_id";
		}
		$Value = $_POST[$Element];
		if($Value!="")		{
			//array_push($FieldArray,$Element);
			switch($Element)	{
				case 'amt':
				case 'payamt':
				case 'factpayamt':
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
				if($Element=="productid")		{
					$Element = "productid_id";
				}
				if($m==0)	{
					$Value = $_POST[$Element];
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
			//print $sql."<BR>";
		}
		
	}

	//print_R($FieldArray);

	

	
}



?>