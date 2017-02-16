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
//学生个人交费,得到学生详细信息###########################################################
//########################################################################################
$XH = $_GET['XH'];
if($_GET['action']=="GERENSHOUFEIINFOR"&&$XH!="")		{
	// [tablename] => sor_zhuanye [primarykey] => 专业号 [IDValue] => 09102 [FieldName] => 专业名 [FieldValue] => )
	$sql = "select 收费标准 AS SFBZ from edu_zhuanyeshoufei where 学年='$XN' and 专业代码='$ZYDM' and 年级='$NJ' and 收费项目代码='$SFXMDM'";
	$rs = $db->Execute($sql);
	$rs_a = $rs->GetArray();
	if($rs_a[0]['SFBZ']!="")		{
		$sql = "update edu_zhuanyeshoufei set 收费标准='$FieldValue' where 学年='$XN' and 专业代码='$ZYDM' and 年级='$NJ' and 收费项目代码='$SFXMDM'";
	}
	else	{
		$XSLB = '';
		$SFDR = 1;
		$SFBZLB = 1;
		$ZYMC = returntablefield("edu_zhuanye","专业代码",$ZYDM,"专业名称");
		$sql = "insert into edu_zhuanyeshoufei values('','$XN','$ZYDM','$ZYMC','$NJ','$SFXMDM','$SFXMMC','$FieldValue','$XYMC')";
	}
	print $sql;
	$db->Execute($sql);

}



//#######################################################################################
//专业收费信息设置#####################################################################
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
	// [tablename] => sor_zhuanye [primarykey] => 专业号 [IDValue] => 09102 [FieldName] => 专业名 [FieldValue] => )
	$sql = "select 收费标准 AS SFBZ from edu_zhuanyeshoufei where 学年='$XN' and 专业代码='$ZYDM' and 年级='$NJ' and 收费项目代码='$SFXMDM'";
	$rs = $db->Execute($sql);
	$rs_a = $rs->GetArray();
	if($rs_a[0]['SFBZ']!="")		{
		$sql = "update edu_zhuanyeshoufei set 收费标准='$FieldValue' where 学年='$XN' and 专业代码='$ZYDM' and 年级='$NJ' and 收费项目代码='$SFXMDM'";
	}
	else	{
		$XSLB = '';
		$SFDR = 1;
		$SFBZLB = 1;
		$ZYMC = returntablefield("edu_zhuanye","专业代码",$ZYDM,"专业名称");
		$sql = "insert into edu_zhuanyeshoufei values('','$XN','$ZYDM','$ZYMC','$NJ','$SFXMDM','$SFXMMC','$FieldValue','$XYMC')";
	}
	print $sql;
	$db->Execute($sql);

}



//########################################################################################
//创建一个可编辑区，在列表区域进行数据值的修改与调整######################################
//########################################################################################

if($_GET['action']=="jiyun512"&&$tablename!=""&&$primarykey!=""&&$IDValue!=""&&$FieldName!="")		{
	$IDValue = $_GET['IDValue'];
	// [tablename] => sor_zhuanye [primarykey] => 专业号 [IDValue] => 09102 [FieldName] => 专业名 [FieldValue] => )
	$sql = "update $tablename set $FieldName = '$FieldValue' where $primarykey ='$IDValue'";
	print $sql;
	$db->Execute($sql);

}

//########################################################################################
//实时更新界面语言标识####################################################################
//########################################################################################
$fieldname = $_GET['fieldname'];
$language = $_GET['language'];
if($language=='') $language = 'zh';
$FieldValue = $_GET['FieldValue'];
if($_GET['action']=="systemlang"&&$tablename!=""&&$fieldname!=""&&$language!=""&&$FieldValue!="")		{
	// [tablename] => sor_zhuanye [primarykey] => 专业号 [IDValue] => 09102 [FieldName] => 专业名 [FieldValue] => )
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
//实时更新字段的备注信息##################################################################
//########################################################################################
$fieldname = $_GET['fieldname'];
$language = $_GET['language'];
if($language=='') $language = "zh";
$FieldValue = $_GET['FieldValue'];
if($_GET['action']=="fieldaddtext"&&$tablename!=""&&$fieldname!="")		{
	// [tablename] => sor_zhuanye [primarykey] => 专业号 [IDValue] => 09102 [FieldName] => 专业名 [FieldValue] => )
	$sql = "update systemlang set remark = '$FieldValue' where tablename ='$tablename' and fieldname='$fieldname'";
	print $sql;
	$db->Execute($sql);

}

//########################################################################################
//更新教师工资信息########################################################################
//########################################################################################
$Year = $_GET['Year'];
$Month = $_GET['Month'];
$TeacherCode = $_GET['TeacherCode'];
$FieldValue = $_GET['FieldValue'];
$FieldName = $_GET['FieldName'];
if($_GET['action']=="teachermoney"&&$Year!=""&&$Month!=""&&$TeacherCode!=""&&$FieldName!=""&&$FieldValue!="")		{
	// [tablename] => sor_zhuanye [primarykey] => 专业号 [IDValue] => 09102 [FieldName] => 专业名 [FieldValue] => )
	$sql = "select count(姓名) as NUM from edu_teachermoney where 姓名='$TeacherCode' and 工资月份='$Month' and 工资年份='$Year'";
	$rs = $db->Execute($sql);
	$rs_a = $rs->GetArray();
	if($rs_a[0]['NUM']>0)		{
		$sql = "update edu_teachermoney set $FieldName='$FieldValue' where 姓名='$TeacherCode' and 工资月份='$Month' and 工资年份='$Year' ";
	}
	else	{
		$sql = "insert into edu_teachermoney (序号,姓名,".$FieldName.",工资年份,工资月份) values('','$TeacherCode','$FieldValue','$Year','$Month');";
	}
	print $sql;
	$db->Execute($sql);

}


?><?php
/*
	版权归属:郑州单点科技软件有限公司;
	联系方式:0371-69663266;
	公司地址:河南郑州经济技术开发区第五大街经北三路通信产业园四楼西南;
	公司简介:郑州单点科技软件有限公司位于中国中部城市-郑州,成立于2007年1月,致力于把基于先进信息技术（包括通信技术）的最佳管理与业务实践普及到教育行业客户的管理与业务创新活动中，全面提供具有自主知识产权的教育管理软件、服务与解决方案，是中部最优秀的高校教育管理软件及中小学校管理软件提供商。目前己经有多家高职和中职类院校使用通达中部研发中心开发的软件和服务;

	软件名称:单点科技软件开发基础性架构平台,以及在其基础之上扩展的任何性软件作品;
	发行协议:数字化校园产品为商业软件,发行许可为LICENSE方式;单点CRM系统即SunshineCRM系统为GPLV3协议许可,GPLV3协议许可内容请到百度搜索;
	特殊声明:软件所使用的ADODB库,PHPEXCEL库,SMTARY库归原作者所有,余下代码沿用上述声明;
	*/
?>