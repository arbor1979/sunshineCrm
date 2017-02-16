<?php
ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL);
// display warnings and errors
error_reporting(E_WARNING | E_ERROR);
require_once('lib.inc.php');
$GLOBAL_SESSION=returnsession();
page_css();
if($_GET['pageAction']!="write")				{
	//header("Content-Type:text/html;charset=gbk");
	//######################教育组件-权限较验部分##########################


$SYSTEM_PRIV_STOP = 1;
	require_once("systemprivateinc.php");
	CheckSystemPrivate("人力资源-行政考勤-考勤统计");
	//######################教育组件-权限较验部分##########################
	//page_css("行政人员打卡考勤统计");
	$DateMonth = $_GET['Month'];

}

if($_GET['pageAction']=="ExportDataToFile")				{


	$PHP_SELF = $_SERVER['PHP_SELF'];
	$PHP_SELF_ARRAY = explode('/',$_SERVER['PHP_SELF']);
	$FILE_NAME = array_pop($PHP_SELF_ARRAY);
	$PHP_SELF = @join('/',$PHP_SELF_ARRAY);
	$filename = "FileCache/".$FILE_NAME."_".date("Y-m-d-H").".xls";


	$hostname = "http://".$_SERVER['SERVER_NAME'].":".$_SERVER['SERVER_PORT']."".$PHP_SELF."/$FILE_NAME?开始周=".$_GET['开始周']."&结束周=".$_GET['结束周']."&action=".$_GET['action']."&Month=".$_GET['Month']."&LOGIN_USER_NAME=".$_GET['LOGIN_USER_NAME']."&pageAction=write";
	//print_R($hostname);;exit;
	$file = file($hostname);
	$FILE_CONTENT = join('',$file);
	@!$handle = fopen($filename, 'w');
	@fwrite($handle, $FILE_CONTENT);
	fclose($handle);

	if($_GET['Month']!="")		{
		$TEXT = '月份:'.$_GET['Month'];
	}
	else	{
		$TEXT = '开始周:'.$开始周.' 结束周:'.$结束周.'';
	}
	header('Content-Encoding: none');
	header('Content-Type: application/octetstream');
	header('Content-Disposition: attachment;filename=行政考勤统计['.$TEXT.']['.date("Y-m-d-H").'].xls');
	header('Content-Length: '.strlen($FILE_CONTENT));
	header('Pragma: no-cache');
	header('Expires: 0');
	echo $FILE_CONTENT;
	exit;
}


if($LOGIN_THEME!="") $LOGIN_THEME_TEXT = $LOGIN_THEME;
else	 $LOGIN_THEME_TEXT = 3;

print "<TITLE>行政人员打卡考勤统计</TITLE>
<META http-equiv=Content-Type content=\"text/html; charset=gb2312\">
<LINK href=\"http://".$_SERVER['SERVER_NAME'].":".$_SERVER['SERVER_PORT']."/theme/$LOGIN_THEME_TEXT/style.css\" type=text/css rel=stylesheet>
<script type=\"text/javascript\" language=\"javascript\" src=\"http://".$_SERVER['SERVER_NAME'].":".$_SERVER['SERVER_PORT']."/general/EDU/Enginee/lib/common.js\"></script><STYLE>@media print{input{display:none}}</STYLE>
<BODY class=bodycolor topMargin=5 >";

if($_GET['action']=="StaticAll"&&($_GET['Month']!=""||$_GET['开始周']!=""))			{

if($_GET['Month']!="")			{
	$DateMonth = $_GET['Month'];
	$DateMonthArray = explode('-',$DateMonth);
	$本月天数 = date("t",mktime(1,1,1,$DateMonthArray[1],1,$DateMonthArray[0]));
	$开始时间 = date("Y-m-d",mktime(1,1,1,$DateMonthArray[1],1,$DateMonthArray[0]));
	$结束时间 = date("Y-m-d",mktime(1,1,1,$DateMonthArray[1],$本月天数,$DateMonthArray[0]));
}
else	{
	//print_R($_GET);
	$sql = "select 开始时间,学期名称 from edu_xueqiexec where 当前学期='1' order by 流水号 desc limit 1";
	$rs = $db->CacheExecute(150,$sql);
	$rs_a = $rs->GetArray();
	$开始时间 = $rs_a[0]['开始时间'];
	$学期名称 = $rs_a[0]['学期名称'];
	$开始时间Array = explode('-',$开始时间);
	$w = date('w',mktime(1,1,1,$开始时间Array[1],$开始时间Array[2],$开始时间Array[0]));

	if($_GET['开始周']>$_GET['结束周']) $_GET['结束周'] = $_GET['开始周'];

	$周次 = $_GET['开始周'];
	$周天数 = ($周次-1)*7;
	$开始周开始日 = date('Y-m-d',mktime(1,1,1,$开始时间Array[1],$开始时间Array[2]-$w+1+$周天数,$开始时间Array[0]));
	$开始周结束日 = date('Y-m-d',mktime(1,1,1,$开始时间Array[1],$开始时间Array[2]-$w+1+6+$周天数,$开始时间Array[0]));
	if($开始周开始日<$开始时间) $开始周开始日 = $开始时间;

	$周次 = $_GET['结束周'];
	$周天数 = ($周次-1)*7;
	$结束周开始日 = date('Y-m-d',mktime(1,1,1,$开始时间Array[1],$开始时间Array[2]-$w+1+$周天数,$开始时间Array[0]));
	$结束周结束日 = date('Y-m-d',mktime(1,1,1,$开始时间Array[1],$开始时间Array[2]-$w+1+6+$周天数,$开始时间Array[0]));

	$开始时间 = $开始周开始日;
	$结束时间 = $结束周结束日;
}


//print_R($_GET);
$returnTeacherKaoQin = returnTeacherKaoQin($开始时间,$结束时间);
$returnBanCiList = returnBanCiList();
$Header = @array_keys($returnTeacherKaoQin['状态']);

print "
<table width=100% align=center class=TableBlock>
<tr class=TableHeader>
<td colspan=".(sizeof($Header)+1).">行政人员打卡考勤管理(统计时间:".$开始时间." 至 ".$结束时间.")[上班和下班按两次进行统计]
&nbsp;<INPUT TYPE=\"button\" VALUE=\"导出\" class=SmallButton ONCLICK=\"location='?pageAction=ExportDataToFile&action=".$_GET['action']."&开始周=".$_GET['开始周']."&结束周=".$_GET['结束周']."&Month=".$_GET['Month']."'\">
&nbsp;<input type=\"button\" value=\"返回\" class=\"SmallButton\" onClick=\"history.back();\">
</td>
</tr>

";

//print_R($Header);
print "<tr class=TableHeader><td colspan=1>人员用户名</td>";
for($iX=0;$iX<sizeof($Header);$iX++)						{
	$状态 = $Header[$iX];
	print "<td colspan=1>&nbsp;".$状态."</td>";
}
print "</tr>";


$sql = "select distinct 人员用户名 from edu_xingzheng_kaoqinmingxi order by 人员用户名";
$rs = $db->CacheExecute(150,$sql);
$rs_a = $rs->GetArray();
//print_R($returnTeacherKaoQin);

for($i=0;$i<sizeof($rs_a);$i++)						{
	$Element = $rs_a[$i];
	$人员用户名  = $Element['人员用户名'];
	$Text = $returnTeacherKaoQin['人员用户名'][$人员用户名];
	//print_R($Text);
	//总需考勤次数为0时表示没有该行政人员的课程信息,所以在此不用显示出来
	//if($Text['总需考勤次数']>0)				{
		//print_R($Header);
		$人员   = returntablefield("user","USER_ID",$人员用户名,"USER_NAME");
		print "<tr class=TableData><td colspan=1>".$人员."[{$人员用户名}]</td>";
		for($iX=0;$iX<sizeof($Header);$iX++)						{
			$状态 = $Header[$iX];
			print "<td colspan=1>&nbsp;<a href=\"?action=StaticSingleTeacher&开始时间=$开始时间&结束时间=$结束时间&人员用户名=$人员用户名&TYPE=$状态\" target=_blank>".$Text[$状态]."</a></td>";
		}
		print "</tr>";
	//}
}

exit;
}


//数据明细
if($_GET['action']=="StaticSingleTeacher"&&$_GET['开始时间']!=""&&$_GET['结束时间']!=""&&$_GET['人员用户名']!="")			{
$DateMonth = $_GET['Month'];
$人员用户名 = $_GET['人员用户名'];
$TYPE = $_GET['TYPE'];
$Column = returntablecolumn("edu_xingzheng_kaoqinmingxi");

//$DateMonthArray = explode('-',$DateMonth);
//$本月天数 = date("t",mktime(1,1,1,$DateMonthArray[1],1,$DateMonthArray[0]));
//$开始时间 = date("Y-m-d",mktime(1,1,1,$DateMonthArray[1],1,$DateMonthArray[0]));
//$结束时间 = date("Y-m-d",mktime(1,1,1,$DateMonthArray[1],$本月天数,$DateMonthArray[0]));


print "
<table width=100% align=center class=TableBlock>
<tr class=TableHeader>
<td colspan=".sizeof($Column)."+3>行政人员打卡考勤管理(统计时间:".$开始时间." 至 ".$结束时间." 行政人员姓名:$人员用户名 统计项:$TYPE)[上班和下班按两次进行统计]&nbsp;<input type=button value=\"关 闭\" class=\"SmallButton\" onclick=\"window.close();\"></td>
</tr>
<tr class=TableHeader>";

//array_shift($Column);
for($i=0;$i<sizeof($Column);$i++)						{
	print "<td nowrap>".$Column[$i]."</td>";
}
print "</tr>";

//print_R($_GET);
switch($TYPE)		{
	case '总需考勤次数':
		$AddSql = "";
		break;
	case '上班缺打卡':
		$AddSql = " and (上班考勤状态 = '上班缺打卡')";
		break;
	case '下班缺打卡':
		$AddSql = " and (下班考勤状态 = '下班缺打卡')";
		break;
	case '请假外出':
		$AddSql = " and (上班考勤状态 = '请假外出' or 下班考勤状态 = '请假外出' )";
		break;
	case '不用考勤':
		$AddSql = " and (上班考勤状态 = '不用考勤' or 下班考勤状态 = '不用考勤' )";
		break;
	default:
		$AddSql = " and (上班考勤状态 = '$TYPE' or 下班考勤状态 = '$TYPE' )";
		break;
}

$sql = "select * from edu_xingzheng_kaoqinmingxi where 人员用户名='$人员用户名' and 日期 >='$开始时间' and 日期<='$结束时间' $AddSql order by 日期,班次";
$rs = $db->CacheExecute(150,$sql);
$rs_a = $rs->GetArray();
//print_R($sql);
for($i=0;$i<sizeof($rs_a);$i++)						{
	print "<tr class=TableData>";
	for($ii=0;$ii<sizeof($Column);$ii++)		{
		$ColumnName = $Column[$ii];
		if($ColumnName=="编号") $ColumnValue = $i+1;
		//else if($ColumnName=="上班考勤状态")	$rs_a[$i][$ColumnName]=="1"?$ColumnValue='是':'';
		//else if($ColumnName=="下班考勤状态")	$rs_a[$i][$ColumnName]=="1"?$ColumnValue='是':'';
		else					$ColumnValue = $rs_a[$i][$ColumnName];
		print "<td nowrap>".$ColumnValue."</td>";
	}
	print "</tr>";
}
print "</table>";

exit;
}




//统计项
if($_GET['action']=="init_default"||$_GET['action']=="")					{

	$html_etc = returnsystemlang('edu_xingzheng_kaoqinmingxi');

	page_css("行政人员卡机考勤按月份查询");

	//此段代码以前为周次统计之前,月份统计之下,后需要用到学期名称,所以提前至此
	if($_GET['学期名称']!="")	$学期名称 = $_GET['学期名称'];
	else						$学期名称 = returntablefield("edu_xueqiexec","当前学期",'1',"学期名称");
	$学期初始值 = $学期名称;

	$sql = "select 开始时间,学期名称 from edu_xueqiexec where 当前学期='1'  order by 流水号 desc limit 1";
	$rs = $db->CacheExecute(150,$sql);
	$rs_a = $rs->GetArray();
	$开始时间 = $rs_a[0]['开始时间'];
	//$学期名称 = $rs_a[0]['学期名称'];
	$开始时间Array = explode('-',$开始时间);

	print "
		<table border=0 class=TableBlock width=100% >
		<tr class=TableHeader><td valign=bottom align=left>行政人员卡机考勤管理 ".$html_etc['edu_xingzheng_kaoqinmingxi']['学期'].":";
		//$学期名称
		//print_select_single_select("CurXueQi",$学期名称,"edu_xueqiexec","学期名称","学期名称");

		$sql="select 学期名称 from edu_xueqiexec";
		$rs=$db->Execute($sql);//print_R($rs->GetArray());
		$学期文本 .= "&nbsp;&nbsp;<select class=\"SmallSelect\" name=\"CurXueQi\" onChange=\"var jmpURL='?XX=XX&学期名称=' + this.options[this.selectedIndex].value ; if(jmpURL!='') {window.location=jmpURL;} else {this.selectedIndex=0 ;}\"
		>\n";
		while(!$rs->EOF)			{
		if($学期初始值==$rs->fields['学期名称'])		$temp='selected';
		$学期文本 .= "<option value=\"".$rs->fields['学期名称']."\" $temp>".$rs->fields['学期名称']."</option>\n";
		$temp='';
		$rs->MoveNext();
		}
		$学期文本 .= "</select>\n";
		print $学期文本;

		print "</td></tr>
		<tr class=TableData><td valign=bottom align=left>
		以下为每个月的数据汇总<BR>";
		$sql = "SELECT  distinct date_format( 日期, '%Y-%m' ) AS DateMonth FROM `edu_xingzheng_kaoqinmingxi` where 学期 ='$学期名称' ";
		$rs = $db->CacheExecute(150,$sql);
		$rs_a = $rs->GetArray();
		for($i=0;$i<sizeof($rs_a);$i++)		{
			$DateMonth = $rs_a[$i]['DateMonth'];
			$DateMonthArray = explode('-',$DateMonth);
			$本月天数 = date("t",mktime(1,1,1,$DateMonthArray[1],1,$DateMonthArray[0]));
			$开始时间 = date("Y-m-d",mktime(1,1,1,$DateMonthArray[1],1,$DateMonthArray[0]));
			$结束时间 = date("Y-m-d",mktime(1,1,1,$DateMonthArray[1],$本月天数,$DateMonthArray[0]));


			$sql = "select count(*) as NUM from edu_xingzheng_kaoqinmingxi where 日期 >='$开始时间' and 日期<='$结束时间'";
			$rs = $db->CacheExecute(150,$sql);
			$rsX_a = $rs->GetArray();
			$Number = $rsX_a[0]['NUM'];

			$sql = "select count(*) as NUM from edu_xingzheng_kaoqinmingxi where 日期 >='$开始时间' and 日期<='$结束时间' and (上班考勤状态!='上班缺打卡' or 下班考勤状态!='下班缺打卡')";
			$rs = $db->CacheExecute(150,$sql);
			$rsX_a = $rs->GetArray();
			$Number2 = $rsX_a[0]['NUM'];

			print "".$DateMonth." &nbsp;
			[<a href=\"?".base64_encode("action=StaticAll&Month=$DateMonth")."\" >查阅该月考勤数据</a>]
			&nbsp;&nbsp;
			[需要考勤".$Number."条,已完成".$Number2."条]";
			print "<BR>";

		}
		print "</td></tr></table><BR>";



		if($Target=="") $Target = date("Y-m-d");
		$TargetArray = explode('-',$Target);
		$W1 = date('W',mktime(1,1,1,$开始时间Array[1],$开始时间Array[2],$开始时间Array[0]));
		$W2 = date('W',mktime(1,1,1,$TargetArray[1],$TargetArray[2],$TargetArray[0]));
		$W = $W2-$W1+1;

		$sql = "select MAX(周次) as 最大周次 from edu_xingzheng_kaoqinmingxi where 学期 ='$学期名称'";
		$rs = $db->CacheExecute(150,$sql);
		$rsX_a = $rs->GetArray();
		$最大周次 = $rsX_a[0]['最大周次'];

		print "
		<table border=0 class=TableBlock width=100% >
		<tr class=TableHeader><td valign=bottom align=left>行政人员卡机考勤按周次查询 ".$html_etc['edu_xingzheng_kaoqinmingxi']['学期'].":";
		$sql="select 学期名称 from edu_xueqiexec";
		$rs=$db->Execute($sql);//print_R($rs->GetArray());
		$学期文本XX .= "&nbsp;&nbsp;<select class=\"SmallSelect\" name=\"CurXueQi\" onChange=\"var jmpURL='?XX=XX&学期名称=' + this.options[this.selectedIndex].value ; if(jmpURL!='') {window.location=jmpURL;} else {this.selectedIndex=0 ;}\"
		>\n";
		while(!$rs->EOF)			{
		if($学期初始值==$rs->fields['学期名称'])		$temp='selected';
		$学期文本XX .= "<option value=\"".$rs->fields['学期名称']."\" $temp>".$rs->fields['学期名称']."</option>\n";
		$temp='';
		$rs->MoveNext();
		}
		$学期文本XX .= "</select>\n";
		print $学期文本XX;
		print "</td></tr>
		<tr class=TableData><td valign=bottom align=left>
		<BR>";
		print "<form name=form1 method=get>";
		print "&nbsp;&nbsp;开始周:&nbsp;&nbsp;<select name=开始周 >";
		for($i=1;$i<=$最大周次;$i++)		{
			print "<option value='$i'>$i</option>";
		}
		print "</select>";
		print "&nbsp;&nbsp;结束周:&nbsp;&nbsp;<select name=结束周 >";
		for($i=1;$i<=$最大周次;$i++)		{
			print "<option value='$i'>$i</option>";
		}
		print "</select>";
		print "<input type=hidden name='action' value='StaticAll'/>";
		print "&nbsp;&nbsp;<input type=submit class=SmallButton name=提交 value='查询'/><BR><BR>";
		print "</form>";
		print "</td></tr></table><BR>";
}

function returnBanCiList()		{
	global $db;
	$sql = "select * from edu_xingzheng_banci";
	$rs = $db->CacheExecute(150,$sql);
	$rs_a = $rs->GetArray();
	$班次名称 = array();
	for($i=0;$i<sizeof($rs_a);$i++)						{
		$Element = $rs_a[$i];
		$班次名称[]  = $Element['班次名称'];
	}
	return $班次名称;
}

function returnTeacherKaoQin($开始时间='',$结束时间='')		{
	global $db,$returnBanCiList;

	$sql = "select COUNT(*) AS NUM,上班考勤状态,人员用户名 from edu_xingzheng_kaoqinmingxi where 日期 >='$开始时间' and 日期<='$结束时间'  group by 上班考勤状态,人员用户名";
	//print $sql;exit;
	$rs = $db->CacheExecute(150,$sql);
	$rs_a = $rs->GetArray();
	//print_R($rs_a);
	$NewArray = array();
	for($i=0;$i<sizeof($rs_a);$i++)						{
		$Element = $rs_a[$i];
		$NUM	= $Element['NUM'];
		$人员用户名	= $Element['人员用户名'];
		$上班考勤状态  = $Element['上班考勤状态'];
		if($上班考勤状态!="")		{
			$NewArray['人员用户名'][$人员用户名][$上班考勤状态] += $NUM;
			$NewArray['状态'][$上班考勤状态] += $NUM;
		}
	}

	$sql = "select COUNT(*) AS NUM,下班考勤状态,人员用户名 from edu_xingzheng_kaoqinmingxi where 日期 >='$开始时间' and 日期<='$结束时间' group by 下班考勤状态,人员用户名";
	//print $sql;exit;
	$rs = $db->CacheExecute(150,$sql);
	$rs_a = $rs->GetArray();
	//print_R($rs_a);
	for($i=0;$i<sizeof($rs_a);$i++)						{
		$Element = $rs_a[$i];
		$NUM  = $Element['NUM'];
		$人员用户名  = $Element['人员用户名'];
		$下班考勤状态  = $Element['下班考勤状态'];
		if($下班考勤状态!="")		{
			$NewArray['人员用户名'][$人员用户名][$下班考勤状态] += $NUM;
			$NewArray['状态'][$下班考勤状态] += $NUM;
		}
	}

	//print_R($NewArray);

	return $NewArray;

}
?>
