<?php
function print_select_countryCode($value="410100",$fields)		{
	global $db,$_GET;
	//print $value;
	$showfield0 = "provinces";
	$showfield = "cityCode";
	$showfield2= "areaCode";
	$showfield3= "postcode";
	$tablename = "dict_countrycode";
	$field_value = "countryCode";
	$field_name = "countryName";
	$orderBy = $field_value;
	$postCodeValue	= $fields['value']['�ʱ�'];
	$value			= $fields['value']['����'];
	$����			= $fields['value']['����'];
	//print_R($value);

	//##########################################################//���Ӷ�KEY-VALUE��ʽ��֧��
	if($value!="")			{
		$sql = "select * from dict_countrycode where $field_name='$value'";
		$rs  = $db->CacheExecute(1500,$sql);
		$value = $rs->fields[$field_value];
		$��¼���� = $rs->RecordCount();
		//���ݵ��������жϳ�Ψһ��¼
		if($��¼����>1)			{//����ʱ�Ҳ�������������
			$sql = "select * from dict_countrycode where $field_name='$value' and $showfield3='$postCodeValue'";
			$rs  = $db->CacheExecute(1500,$sql);
			$��¼���� = $rs->RecordCount();
			$value = $rs->fields[$field_value];
			print $��¼����;
		}
		if($��¼����==0)			{//����ʱ�Ҳ�������������
			$sql = "select * from dict_countrycode where $field_name='$����'";
			$rs  = $db->CacheExecute(1500,$sql);
			$��¼���� = $rs->RecordCount();
			$value = $rs->fields[$field_value];
			//print $��¼����;
		}
	}
	//##########################################################


	 //�û�������������##########################��ʼ
	 global $fields;
	 //print_R($fields['USER_PRIVATE'][$showfield0]);
	 if($fields['USER_PRIVATE'][$showfield0]!="")	{
		 $readonly = "disabled";
		 $class = "SmallStatic";
	 }
	 else	{
		 $readonly = "";
		 $class = "SmallSelect";
	 }
	 //�û�������������##########################����


	$sql="select $field_name,$field_value,$showfield3 from $tablename order by $orderBy";
	$rs=$db->CacheExecute(15000000,$sql);
	$rs_a = $rs->GetArray();
//JS�ű����ֿ�ʼ
print "
<form name=form1>
<script language=\"JavaScript\">
<!--
var subval = new Array();\n";
$ProvinceArrayCode = array();
$ProvinceArrayName = array();
$TwoSelect = array();
$ThreeSelect = array();
$j = 0;
for($i=0;$i<sizeof($rs_a);$i++)			{
$Element = $rs_a[$i][$field_value];
$CountryName = $rs_a[$i][$field_name];
$postCode = $rs_a[$i][$showfield3];
$postArray[$Element] = $postCode;
$OneCode = substr($Element,0,2);
$TwoCode = substr($Element,0,4);
$FourCode = substr($Element,2,4);
if(!in_array($OneCode,$ProvinceArrayCode))	{
	array_push($ProvinceArrayCode,$OneCode);
	array_push($ProvinceArrayName,$CountryName);
}

if(substr($Element,4,2)=='00')		{
	$ShiName = $CountryName;
}

//�����˵���ʼ�����鲿��
if(substr($Element,0,2)==substr($value,0,2) && substr($Element,4,2)=='00' && substr($Element,2,4)!= '0000')		{
	$TwoSelect[$Element] = $CountryName;
}
//�����˵���ʼ�����鲿��
if(substr($Element,0,4)==substr($value,0,4))		{
	$ThreeSelect[$Element] = $CountryName;
}


if($FourCode!='0000')	{
	print "subval[$j] = new Array('".$OneCode."','$TwoCode','".$ShiName."','$Element','$CountryName','$postCode');\n";
	$j++;
}

}
print "
SelectValue = new Array();
function changeselect1(locationid)
{
    document.form1.".$showfield.".length = 0;
    document.form1.".$showfield.".options[0] = new Option('==��ѡ��==','');
    document.form1.".$showfield2.".length = 0;
    document.form1.".$showfield2.".options[0] = new Option('==��ѡ��==','');
    for (i=0; i<subval.length; i++)
    {
        if (subval[i][0] == locationid)
        {
			if(subval[i][0] == locationid)		{
				if(i == 0 )			{
					document.form1.".$showfield.".options[document.form1.".$showfield.".length] = new Option(subval[i][2],subval[i][1]);
				}
				else if(i>0 && subval[i][1] != subval[i-1][1] )	{
					document.form1.".$showfield.".options[document.form1.".$showfield.".length] = new Option(subval[i][2],subval[i][1]);
				}
				else	{
					//document.form1.".$showfield.".options[document.form1.".$showfield.".length] = new Option(subval[i][2],subval[i][1]);
				}
			}
		}
    }
}

function changeselect2(locationid)
{
    document.form1.".$showfield2.".length = 0;
    document.form1.".$showfield2.".options[0] = new Option('==��ѡ��==','');
    for (i=0; i<subval.length; i++)
    {
        if (subval[i][1] == locationid)
        {document.form1.".$showfield2.".options[document.form1.".$showfield2.".length] = new Option(subval[i][4],subval[i][3]);}
    }
}

function changeDefaultValue(locationid)		{
	//document.form1.".$showfield3.".value = subval[locationid][5];
	for (i=0; i<subval.length; i++)
    {
        if (subval[i][3] == locationid)      {
			document.form1.".$showfield3.".value = subval[i][5];
		}
    }
}

//-->
</script>
	";
//JS�ű�����

	print "<TR>";
    print "<TD class=TableData noWrap>ʡ��:</TD>\n";
    print "<TD class=TableData noWrap colspan=\"$colspan\">\n";
	print "<select name=\"$showfield0\" class=$class $readonly title='".$fields['USER_PRIVATE_TEXT'][$showfield0]."' onChange=\"changeselect1(this.value)\">\n";
	print "<option value=\"\">==��ѡ��ʡ��==</option>";
	$ValueText = substr($value,0,2);
	for($i=0;$i<sizeof($ProvinceArrayCode);$i++)		{
		if($ValueText==$ProvinceArrayCode[$i])	{
			$SelectText = "selected";
		}
		else	{
			$SelectText = "";
		}
		print "<option value=\"".$ProvinceArrayCode[$i]."\" $SelectText>".$ProvinceArrayName[$i]."</option>";
	}
	print "</select>\n";
	//print "<BR>";
	//print "</TD></TR>\n";
	//�����˵�����
	//print "<TR>";//print_R($TwoSelect);
    //print "<TD class=TableData noWrap>���У�</TD>\n";
    //print "<TD class=TableData noWrap colspan=\"$colspan\">\n";
	print "<select name=\"".$showfield."\" class=$class  $readonly title='".$fields['USER_PRIVATE_TEXT'][$showfield0]."' onChange=\"changeselect2(this.value)\"> \n";
	print "<option>==��ѡ�����==</option>\n";
	$TwoSelectKeys = array_keys($TwoSelect);
	$TwoSelectValues = array_values($TwoSelect);
	for($i=0;$i<sizeof($TwoSelectKeys);$i++)		{
		$TempSelect = substr($TwoSelectKeys[$i],0,4);
		$ValueSelect = substr($value,0,4);
		if($TempSelect==$ValueSelect)	{
			$SelectText = "selected";
		}
		else	{
			$SelectText = "";
		}
		print "<option value=\"".substr($TwoSelectKeys[$i],0,4)."\" $SelectText>".$TwoSelectValues[$i]."</option>\n";
	}
	print "</select>\n";
	//print "</TD></TR>\n";

	//�����˵�����
	//print "<TR>";
    //print "<TD class=TableData noWrap>���أ�</TD>\n";
    //print "<TD class=TableData noWrap colspan=\"$colspan\">\n";
	print "<select name=\"".$showfield2."\" class=$class $readonly title='".$fields['USER_PRIVATE_TEXT'][$showfield0]."' onChange=\"changeDefaultValue(this.value)\"> \n";
	print "<option value=''>==��ѡ������==</option>\n";
	$ThreeSelectKeys = array_keys($ThreeSelect);
	$ThreeSelectValues = array_values($ThreeSelect);
	for($i=0;$i<sizeof($ThreeSelectKeys);$i++)		{
		$TempSelect = $ThreeSelectKeys[$i];
		$ValueSelect = $value;
		if($TempSelect==$ValueSelect)	{
			$SelectText = "selected";
		}
		else	{
			$SelectText = "";
		}
		print "<option value=\"".$ThreeSelectKeys[$i]."\" $SelectText>".$ThreeSelectValues[$i]."</option>\n";
	}
	print "</select>\n";
	//print "<BR>";
	if($postCodeValue=="")	{
			$postCodeValue = $postArray[$value];
	}
	print "�ʱࣺ<input type=text class=SmallInput name = \"$showfield3\" size=7 value=\"".$postCodeValue."\">";
	//print_R($value);
	print "</TD></TR>\n";
	//if($value!="")		{
		//$field_name_value = //returntablefield("scrm_customer",$field_value,$value,$field_name);
	//}
	print "<input type=hidden name = \"$field_name\" value=\"".$ThreeSelect[$value]."\"/>";
	//print "
	//<script language=\"JavaScript\">
	//<!--
	//changeselect1('".substr($value,0,2)."');
	//changeselect2('".substr($value,0,4)."');
	//-->
	//</script>";
}
?>