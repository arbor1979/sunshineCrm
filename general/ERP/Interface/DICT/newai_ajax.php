<?php
ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL);

// display warnings and errors
error_reporting(E_WARNING | E_ERROR);

?><?php
ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL);

// display warnings and errors
error_reporting(E_WARNING | E_ERROR);
require_once("lib.inc.php");
//
//$GLOBAL_SESSION=returnsession();

print_R($_GET);
//exit;

$tablename = $_GET['tablename'];
$primarykey = $_GET['primarykey'];
$IDValue = $_GET['IDValue'];
$FieldName = $_GET['FieldName'];
$FieldValue = $_GET['FieldValue'];


//########################################################################################
//ѧ�����˽���,�õ�ѧ����ϸ��Ϣ###########################################################
//########################################################################################
$XH = $_GET['XH'];
if($_GET['action']=="GERENSHOUFEIINFOR"&&$XH!="")		{
	// [tablename] => sor_zhuanye [primarykey] => רҵ�� [IDValue] => 09102 [FieldName] => רҵ�� [FieldValue] => )
	$sql = "select �շѱ�׼ AS SFBZ from edu_zhuanyeshoufei where ѧ��='$XN' and רҵ����='$ZYDM' and �꼶='$NJ' and �շ���Ŀ����='$SFXMDM'";
	$rs = $db->Execute($sql);
	$rs_a = $rs->GetArray();
	if($rs_a[0]['SFBZ']!="")		{
		$sql = "update edu_zhuanyeshoufei set �շѱ�׼='$FieldValue' where ѧ��='$XN' and רҵ����='$ZYDM' and �꼶='$NJ' and �շ���Ŀ����='$SFXMDM'";
	}
	else	{
		$XSLB = '';
		$SFDR = 1;
		$SFBZLB = 1;
		$ZYMC = returntablefield("edu_zhuanye","רҵ����",$ZYDM,"רҵ����");
		$sql = "insert into edu_zhuanyeshoufei values('','$XN','$ZYDM','$ZYMC','$NJ','$SFXMDM','$SFXMMC','$FieldValue','$XYMC')";
	}
	print $sql;
	$db->Execute($sql);

}



//#######################################################################################
//רҵ�շ���Ϣ����#####################################################################
//#######################################################################################
$ZYDM = $_GET['ZYDM'];
$NJ = $_GET['NJ'];
$XN = $_GET['XN'];
$SFXMDM = $_GET['SFXMDM'];
$SFXMMC = $_GET['SFXMMC'];
$XYMC = $_GET['XYMC'];
$FieldValue = $_GET['FieldValue'];
//if($FieldValue=='')	$FieldValue = 9600;
if($_GET['action']=="ZYCSB"&&$ZYDM!=""&&$NJ!=""&&$XN!=""&&$SFXMDM!=""&&$SFXMMC!=""&&$FieldValue!="")		{
	// [tablename] => sor_zhuanye [primarykey] => רҵ�� [IDValue] => 09102 [FieldName] => רҵ�� [FieldValue] => )
	$sql = "select �շѱ�׼ AS SFBZ from edu_zhuanyeshoufei where ѧ��='$XN' and רҵ����='$ZYDM' and �꼶='$NJ' and �շ���Ŀ����='$SFXMDM'";
	$rs = $db->Execute($sql);
	$rs_a = $rs->GetArray();
	if($rs_a[0]['SFBZ']!="")		{
		$sql = "update edu_zhuanyeshoufei set �շѱ�׼='$FieldValue' where ѧ��='$XN' and רҵ����='$ZYDM' and �꼶='$NJ' and �շ���Ŀ����='$SFXMDM'";
	}
	else	{
		$XSLB = '';
		$SFDR = 1;
		$SFBZLB = 1;
		$ZYMC = returntablefield("edu_zhuanye","רҵ����",$ZYDM,"רҵ����");
		$sql = "insert into edu_zhuanyeshoufei values('','$XN','$ZYDM','$ZYMC','$NJ','$SFXMDM','$SFXMMC','$FieldValue','$XYMC')";
	}
	print $sql;
	$db->Execute($sql);

}



//########################################################################################
//����һ���ɱ༭�������б������������ֵ���޸������######################################
//########################################################################################

if($_GET['action']=="jiyun512"&&$tablename!=""&&$primarykey!=""&&$IDValue!=""&&$FieldName!="")		{
	$IDValue = $_GET['IDValue'];
	// [tablename] => sor_zhuanye [primarykey] => רҵ�� [IDValue] => 09102 [FieldName] => רҵ�� [FieldValue] => )
	$sql = "update $tablename set $FieldName = '$FieldValue' where $primarykey ='$IDValue'";
	print $sql;
	$db->Execute($sql);

}

//########################################################################################
//ʵʱ���½������Ա�ʶ####################################################################
//########################################################################################
$fieldname = $_GET['fieldname'];
$language = $_GET['language'];
if($language=='') $language = 'zh';
$FieldValue = $_GET['FieldValue'];
if($_GET['action']=="systemlang"&&$tablename!=""&&$fieldname!=""&&$language!=""&&$FieldValue!="")		{
	// [tablename] => sor_zhuanye [primarykey] => רҵ�� [IDValue] => 09102 [FieldName] => רҵ�� [FieldValue] => )
	if($language=="zh")		{
		$sql = "update systemlang set chinese = '$FieldValue' where tablename ='$tablename' and fieldname='$fieldname'";
	}
	else	{
		$sql = "update systemlang set english = '$FieldValue' where tablename ='$tablename' and fieldname='$fieldname'";

	}
	print $sql;
	$db->Execute($sql);

}


//########################################################################################
//ʵʱ�����ֶεı�ע��Ϣ##################################################################
//########################################################################################
$fieldname = $_GET['fieldname'];
$language = $_GET['language'];
if($language=='') $language = "zh";
$FieldValue = $_GET['FieldValue'];
if($_GET['action']=="fieldaddtext"&&$tablename!=""&&$fieldname!="")		{
	// [tablename] => sor_zhuanye [primarykey] => רҵ�� [IDValue] => 09102 [FieldName] => רҵ�� [FieldValue] => )
	$sql = "update systemlang set remark = '$FieldValue' where tablename ='$tablename' and fieldname='$fieldname'";
	print $sql;
	$db->Execute($sql);

}

//########################################################################################
//���½�ʦ������Ϣ########################################################################
//########################################################################################
$Year = $_GET['Year'];
$Month = $_GET['Month'];
$TeacherCode = $_GET['TeacherCode'];
$FieldValue = $_GET['FieldValue'];
$FieldName = $_GET['FieldName'];
if($_GET['action']=="teachermoney"&&$Year!=""&&$Month!=""&&$TeacherCode!=""&&$FieldName!=""&&$FieldValue!="")		{
	// [tablename] => sor_zhuanye [primarykey] => רҵ�� [IDValue] => 09102 [FieldName] => רҵ�� [FieldValue] => )
	$sql = "select count(����) as NUM from edu_teachermoney where ����='$TeacherCode' and �����·�='$Month' and �������='$Year'";
	$rs = $db->Execute($sql);
	$rs_a = $rs->GetArray();
	if($rs_a[0]['NUM']>0)		{
		$sql = "update edu_teachermoney set $FieldName='$FieldValue' where ����='$TeacherCode' and �����·�='$Month' and �������='$Year' ";
	}
	else	{
		$sql = "insert into edu_teachermoney (���,����,".$FieldName.",�������,�����·�) values('','$TeacherCode','$FieldValue','$Year','$Month');";
	}
	print $sql;
	$db->Execute($sql);

}


?><?php
/*
	��Ȩ����:֣�ݵ���Ƽ�������޹�˾;
	��ϵ��ʽ:0371-69663266;
	��˾��ַ:����֣�ݾ��ü��������������־�����·ͨ�Ų�ҵ԰��¥����;
	��˾���:֣�ݵ���Ƽ�������޹�˾λ���й��в�����-֣��,������2007��1��,�����ڰѻ����Ƚ���Ϣ����������ͨ�ż���������ѹ�����ҵ��ʵ���ռ���������ҵ�ͻ��Ĺ�����ҵ���»�У�ȫ���ṩ��������֪ʶ��Ȩ�Ľ�����������������������������в�������ĸ�У���������������СѧУ��������ṩ�̡�Ŀǰ�����ж�Ҹ�ְ����ְ��ԺУʹ��ͨ���в��з����Ŀ���������ͷ���;

	�������:����Ƽ�������������Լܹ�ƽ̨,�Լ��������֮����չ���κ��������Ʒ;
	����Э��:���ֻ�У԰��ƷΪ��ҵ���,�������ΪLICENSE��ʽ;����CRMϵͳ��SunshineCRMϵͳΪGPLV3Э�����,GPLV3Э����������뵽�ٶ�����;
	��������:�����ʹ�õ�ADODB��,PHPEXCEL��,SMTARY���ԭ��������,���´���������������;
	*/
?>