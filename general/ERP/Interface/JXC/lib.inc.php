<?php
//other dir file

ini_set('date.timezone','Asia/Shanghai');
require_once('../../config.inc.php');
require_once('../../Framework/cache.inc.php');
require_once('../../adodb/adodb.inc.php');

require_once('../../setting.inc.php');
require_once('../../adodb/session/adodb-cryptsession2.php');


require_once('../../Enginee/lib/init.php');
require_once('../../Enginee/lib/html_element.php');
require_once('../../Enginee/lib/function_system.php');
require_once('../../Enginee/lib/select_menu.php');
require_once('../../Enginee/lib/select_menu_two.php');
require_once('../../Enginee/lib/select_menu_six.php');
require_once('../../Enginee/lib/select_menu_select_input.php');
require_once('../../Enginee/lib/getpagedata.php');
require_once('../../Enginee/lib/getpagedata_new.php');
require_once('../../Enginee/lib/other.php');
require_once('../../Enginee/lib/fzhu.php');
require_once('../../Enginee/lib/pinyin.php');
require_once('../../Enginee/lib/select_menu_countryCode.php');
require_once('DAO/CaiWu.php');
require_once('DAO/Store.php');
//root file 
require_once('./cache.inc.php');
require_once('../EDU/lib.function.inc.php');

//返回更新时间
function returnUpdateDate($CurXueQi,$FieldName="班级",$BanJi='')		{
	global $db;
	$sql = "select max(Date) as Date from edu_exam where $FieldName='$BanJi' and `学期`='$CurXueQi'";
	$rs = $db->Execute($sql);
	return $rs->fields['Date'];
}

//返回成绩统计数据字段
function returnStatisticsDomain($Value)		{
	switch($Value)			{
		case $Value<0:
			$return = 1;
			break;
		case $Value>=0&&$Value<=10:
			$return = 1;
			break;
		case $Value>10&&$Value<=20:
			$return = 2;
			break;
		case $Value>20&&$Value<=30:
			$return = 3;
			break;
		case $Value>30&&$Value<=40:
			$return = 4;
			break;
		case $Value>40&&$Value<=50:
			$return = 5;
			break;
		case $Value>50&&$Value<=60:
			$return = 6;
			break;
		case $Value>60&&$Value<=70:
			$return = 7;
			break;
		case $Value>70&&$Value<=80:
			$return = 8;
			break;
		case $Value>80&&$Value<=90:
			$return = 9;
			break;
		case $Value>90&&$Value<=100:
			$return = 10;
			break;
		case $Value>100&&$Value<=110:
			$return = 11;
			break;
		case $Value>110&&$Value<=120:
			$return = 12;
			break;
		case $Value>120&&$Value<=130:
			$return = 13;
			break;
		case $Value>130&&$Value<=140:
			$return = 14;
			break;
		case $Value>140&&$Value<=150:
			$return = 15;
			break;
		case $Value>150:
			$return = 15;
			break;
	}
	return $return;
}

//返回成绩范围
function returnExamScope($Value)		{
	switch($Value)			{
		case 1:
			$return = "0-10";
			break;
		case 2:
			$return = "10-20";
			break;
		case 3:
			$return = "20-30";
			break;
		case 4:
			$return = "30-40";
			break;
		case 5:
			$return = "40-50";
			break;
		case 6:
			$return = "50-60";
			break;
		case 7:
			$return = "60-70";
			break;
		case 8:
			$return = "70-80";
			break;
		case 9:
			$return = "80-90";
			break;
		case 10:
			$return = "90-100";
			break;
		case 11:
			$return = "100-110";
			break;
		case 12:
			$return = "110-120";
			break;
		case 13:
			$return = "120-130";
			break;
		case 14:
			$return = "130-140";
			break;
		case 15:
			$return = "140-150";
			break;
	}
	return $return;
}
?>