<?php
ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL);

// display warnings and errors
error_reporting(E_WARNING | E_ERROR);

//header("Content-Type:text/html;charset=gbk");
//######################教育组件-权限较验部分##########################
require_once("lib.inc.php");

$GLOBAL_SESSION=returnsession();
$SYSTEM_PRIV_STOP = 1;

	require_once("systemprivateinc.php");
	//CheckSystemPrivate("人力资源-行政考勤-部门级管理");
//######################教育组件-权限较验部分##########################

page_css("行政人员打卡考勤统计");
$DateMonth = $_GET['Month'];

//print_R($_GET);
//数据查看

if($_GET['学期名称']!="")	$学期名称 = $_GET['学期名称'];
	else					$学期名称 = returntablefield("edu_xueqiexec","当前学期",'1',"学期名称");
    $学期初始值 = $学期名称;

//班次过滤部分,班次字段必须设为隐藏分组属性--开始
$LOGIN_USER_NAME = $_SESSION['LOGIN_USER_NAME'];
$sql = "select 班次名称 from edu_xingzheng_banci where 班次管理一='$LOGIN_USER_NAME' or 班次管理二='$LOGIN_USER_NAME'";
$rs = $db->CacheExecute(150,$sql);
$rs_a = $rs->GetArray();
$班次名称 = array();
for($i=0;$i<sizeof($rs_a);$i++)						{
	$Element = $rs_a[$i];
	$班次名称[]  = $Element['班次名称'];
}
$班次名称TEXT = "'".join("','",$班次名称)."'";
//班次过滤部分,班次字段必须设为隐藏分组属性--结束



if($_GET['action']=="StaticAll"&&($_GET['Month']!=""||$_GET['开始周']!=""))			{

if($_GET['Month']!="")			{
	$DateMonth = $_GET['Month'];
	$DateMonthArray = explode('-',$DateMonth);
	$本月天数 = date("t",mktime(1,1,1,$DateMonthArray[1],1,$DateMonthArray[0]));
	$开始时间 = date("Y-m-d",mktime(1,1,1,$DateMonthArray[1],1,$DateMonthArray[0]));
	$结束时间 = date("Y-m-d",mktime(1,1,1,$DateMonthArray[1],$本月天数,$DateMonthArray[0]));
}
else							{
	//print_R($_GET);
	$sql = "select 开始时间,学期名称 from edu_xueqiexec where 学期名称='$学期名称' order by 流水号 desc limit 1";
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
print "
<table width=100% align=center class=TableBlock>
<tr class=TableHeader>
<td colspan=7>行政人员打卡考勤管理(统计时间:".$开始时间." 至 ".$结束时间.")<input type=\"button\" value=\"返回\" class=\"SmallButton\" onClick=\"history.back();\"></td>
</tr>
<tr class=TableHeader>
<td nowrap>行政人员姓名</td><td nowrap>总需考勤次数</td>
<td nowrap>上班已考勤</td><td nowrap>上班考勤缺</td>
<td nowrap>下班已考勤</td><td nowrap>下班考勤缺</td>
<td colspan=1>点击查阅明细</td>
</tr>
";

//where 人员='".$_SESSION['LOGIN_USER_NAME']."'
$sql = "select distinct 人员 from edu_xingzheng_kaoqinmingxi where 学期 ='$学期名称'  order by 人员";
$rs = $db->CacheExecute(150,$sql);
$rs_a = $rs->GetArray();	//print_R($rs_a);

for($i=0;$i<sizeof($rs_a);$i++)						{
	$Element = $rs_a[$i];
	$真实姓名  = $Element['人员'];
	$TextX = returnKaoQinMingXi($真实姓名,$开始时间,$结束时间);
	print "<tr class=TableData>
	<td colspan=1>$真实姓名</td>
	<td colspan=1><a href=\"?".base64_encode("action=StaticSingleTeacher&开始时间=$开始时间&结束时间=$结束时间&真实姓名=$真实姓名&TYPE=总需考勤次数")."\" target=_blank>".$TextX['总需考勤次数']."</a></td>
	<td colspan=1><a href=\"?".base64_encode("action=StaticSingleTeacher&开始时间=$开始时间&结束时间=$结束时间&真实姓名=$真实姓名&TYPE=上班已考勤,考勤补登")."\" target=_blank><font color=red>".$TextX['上班已考勤']."</font></a></td>
	<td colspan=1><a href=\"?".base64_encode("action=StaticSingleTeacher&开始时间=$开始时间&结束时间=$结束时间&真实姓名=$真实姓名&TYPE=上班考勤缺")."\" target=_blank>".$TextX['上班考勤缺']."</a></td>
	<td colspan=1><a href=\"?".base64_encode("action=StaticSingleTeacher&开始时间=$开始时间&结束时间=$结束时间&真实姓名=$真实姓名&TYPE=下班已考勤,考勤补登")."\" target=_blank><font color=red>".$TextX['下班已考勤']."</font></a></td>
	<td colspan=1><a href=\"?".base64_encode("action=StaticSingleTeacher&开始时间=$开始时间&结束时间=$结束时间&真实姓名=$真实姓名&TYPE=下班考勤缺")."\" target=_blank>".$TextX['下班考勤缺']."</a></td>
	<td colspan=1><a href=\"?".base64_encode("action=StaticSingleTeacher&开始时间=$开始时间&结束时间=$结束时间&真实姓名=$真实姓名&TYPE=总需考勤次数")."\" target=_blank>点击查阅明细</a></td>
	</tr>";

}

exit;
}

if($_GET['action']=="StaticAllFenLei"&&($_GET['Month']!=""||$_GET['开始周']!=""))			{

if($_GET['Month']!="")			{
	$DateMonth = $_GET['Month'];
	$DateMonthArray = explode('-',$DateMonth);
	$本月天数 = date("t",mktime(1,1,1,$DateMonthArray[1],1,$DateMonthArray[0]));
	$开始时间 = date("Y-m-d",mktime(1,1,1,$DateMonthArray[1],1,$DateMonthArray[0]));
	$结束时间 = date("Y-m-d",mktime(1,1,1,$DateMonthArray[1],$本月天数,$DateMonthArray[0]));
}
else	{
	//print_R($_GET);
	$sql = "select 开始时间,学期名称 from edu_xueqiexec where 学期名称='$学期名称' order by 流水号 desc limit 1";
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
print "
<table width=100% align=center class=TableBlock>
<tr class=TableHeader>
<td colspan=11>行政人员考勤管理(统计时间:".$开始时间." 至 ".$结束时间.")<input type=\"button\" value=\"返回\" class=\"SmallButton\" onClick=\"history.back();\"></td>
</tr>
<tr class=TableHeader>
<td nowrap>行政人员姓名</td>
<td nowrap>请假外出</td>
<td nowrap>加班记录</td>
<td nowrap>补休记录</td>
<td nowrap>调休记录</td>
<td nowrap>补班记录</td>
<td nowrap>调班申请</td>
<td nowrap>调班落实</td>
<td nowrap>相互调班申请</td>
<td nowrap>相互调班落实</td>
<td nowrap>考勤补登</td>
</tr>
";
$sql = "select distinct 人员 from edu_xingzheng_kaoqinmingxi  where 人员='".$_SESSION['LOGIN_USER_NAME']."' and 学期 ='$学期名称' order by 人员";
$rs = $db->CacheExecute(150,$sql);
$rs_a = $rs->GetArray();	//print_R($rs_a);
$Text = returnXingZhengKaoQin($开始时间,$结束时间);
//print_R($Text);
for($i=0;$i<sizeof($rs_a);$i++)						{
	$Element = $rs_a[$i];
	$真实姓名  = $Element['人员'];
	$TextX = $Text[$真实姓名];

	print "<tr class=TableData>
		<td colspan=1>$真实姓名</td>
		<td colspan=1>
		<a href=\"edu_xingzheng_qingjia_newai.php?action=init_customer&开始时间=$开始时间&结束时间=$结束时间&人员=$真实姓名&审核状态=1\" target=_blank>".$TextX['请假外出']."</a></td>
		<td colspan=1>
		<a href=\"edu_xingzheng_jiabanbuxiu_newai.php?action=init_customer&加班开始时间=$开始时间&加班结束时间=$结束时间&人员=$真实姓名&加班审核状态=1\" target=_blank><font color=red>".$TextX['加班记录']."</font></a></td>
		<td colspan=1>
		<a href=\"edu_xingzheng_jiabanbuxiu_newai.php?action=init_customer&补休开始时间=$开始时间&补休结束时间=$结束时间&人员=$真实姓名&补休审核状态=1\" target=_blank>".$TextX['补休记录']."</a></td>
		<td colspan=1>
		<a href=\"edu_xingzheng_tiaoxiububan_newai.php?action=init_customer&调休开始时间=$开始时间&调休结束时间=$结束时间&人员=$真实姓名&调休审核状态=1\" target=_blank><font color=red>".$TextX['调休记录']."</font></a></td>
		<td colspan=1>
		<a href=\"edu_xingzheng_tiaoxiububan_newai.php?action=init_customer&补班开始时间=$开始时间&补班结束时间=$结束时间&人员=$真实姓名&补班审核状态=1\" target=_blank>".$TextX['补班记录']."</a></td>
		<td colspan=1>
		<a href=\"edu_xingzheng_tiaoban_newai.php?action=init_customer&原上班开始时间=$开始时间&原上班结束时间=$结束时间&人员=$真实姓名&审核状态=1\" target=_blank>".$TextX['调班申请']."</a></td>
		<td colspan=1>
		<a href=\"edu_xingzheng_tiaoban_newai.php?action=init_customer&新上班开始时间=$开始时间&新上班结束时间=$结束时间&人员=$真实姓名&审核状态=1\" target=_blank>".$TextX['调班落实']."</a></td>
		<td colspan=1>
		<a href=\"edu_xingzheng_tiaobanxianghu_newai.php?action=init_customer&原上班开始时间=$开始时间&原上班结束时间=$结束时间&原人员=$真实姓名&审核状态=1\" target=_blank>".$TextX['相互调班申请']."</a></td>
		<td colspan=1>
		<a href=\"edu_xingzheng_tiaobanxianghu_newai.php?action=init_customer&新上班开始时间=$开始时间&新上班结束时间=$结束时间&新人员=$真实姓名&审核状态=1\" target=_blank>".$TextX['相互调班落实']."</a></td>
		<td colspan=1>
		<a href=\"edu_xingzheng_kaoqinbudeng_newai.php?action=init_customer&开始时间=$开始时间&结束时间=$结束时间&人员=$真实姓名&审核状态=1\" target=_blank>".$TextX['考勤补登']."</a></td>
		</tr>";
}

exit;
}

//print_R($_GET);
//数据明细
if($_GET['action']=="StaticSingleTeacher"&&$_GET['开始时间']!=""&&$_GET['结束时间']!=""&&$_GET['真实姓名']!="")			{
$DateMonth = $_GET['Month'];
$真实姓名 = $_GET['真实姓名'];
$开始时间 = $_GET['开始时间'];
$结束时间 = $_GET['结束时间'];
$TYPE = $_GET['TYPE'];
$Column = returntablecolumn("edu_xingzheng_kaoqinmingxi");

//$DateMonthArray = explode('-',$DateMonth);
//$本月天数 = date("t",mktime(1,1,1,$DateMonthArray[1],1,$DateMonthArray[0]));
//$开始时间 = date("Y-m-d",mktime(1,1,1,$DateMonthArray[1],1,$DateMonthArray[0]));
//$结束时间 = date("Y-m-d",mktime(1,1,1,$DateMonthArray[1],$本月天数,$DateMonthArray[0]));


print "
<table width=100% align=center class=TableBlock>
<tr class=TableHeader>
<td colspan=".sizeof($Column).">行政人员打卡考勤管理(统计时间:".$开始时间." 至 ".$结束时间." 行政人员姓名:$真实姓名 统计项:$TYPE)&nbsp;<input type=button value=\"关 闭\" class=\"SmallButton\" onclick=\"window.close();\"></td>
</tr>
<tr class=TableHeader>";

//array_shift($Column);
for($i=0;$i<sizeof($Column);$i++)						{
	print "<td nowrap>".$Column[$i]."</td>";
}
print "</tr>";

//print_R($Column);
switch($TYPE)		{
	case '总需考勤次数':
		$AddSql = "";
		break;
	case '上班已考勤':
		$AddSql = " and (上班考勤状态 = '正常刷卡' or 上班考勤状态 = '上班迟到')";
		break;
	case '上班考勤缺':
		$AddSql = " and (上班考勤状态 = '' or 上班考勤状态 = '上班缺打卡' or 上班考勤状态 = '旷工')";
		break;
	case '下班已考勤':
		$AddSql = " and (下班考勤状态 = '正常刷卡' or 下班考勤状态 = '下班早退' )";
		break;
	case '下班考勤缺':
		$AddSql = " and (下班考勤状态 = '' or 下班考勤状态 = '下班缺打卡' or 下班考勤状态 = '旷工')";
		break;
}
$sql = "select * from edu_xingzheng_kaoqinmingxi where 人员='$真实姓名' and 日期 >='$开始时间' and 日期<='$结束时间' $AddSql and 班次 in ($班次名称TEXT) order by 日期,班次";
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

	page_css("行政人员考勤按月份查询");

	//此段代码以前为周次统计之前,月份统计之下,后需要用到学期名称,所以提前至此
	$sql = "select 开始时间,学期名称 from edu_xueqiexec where 学期名称='$学期名称'  order by 流水号 desc limit 1";
	$rs = $db->CacheExecute(150,$sql);
	$rs_a = $rs->GetArray();
	$开始时间 = $rs_a[0]['开始时间'];
	$学期名称 = $rs_a[0]['学期名称'];
	$开始时间Array = explode('-',$开始时间);

	//当前学期:$学期名称
	print "
		<table border=0 class=TableBlock width=100% >
		<tr class=TableHeader><td valign=bottom align=left>行政人员考勤管理 ".$html_etc['edu_xingzheng_kaoqinmingxi']['学期'].":";

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
		//删除无用数据
		//$sql = "delete FROM `edu_xingzheng_kaoqinmingxi` where 日期='0000-00-00'";
		//$db->CacheExecute(150,$sql);
		$sql = "SELECT  distinct date_format( 日期, '%Y-%m' ) AS DateMonth FROM `edu_xingzheng_kaoqinmingxi` where 班次 in ($班次名称TEXT) and 学期 ='$学期名称' ";
		$rs = $db->CacheExecute(150,$sql);
		$rs_a = $rs->GetArray();
		for($i=0;$i<sizeof($rs_a);$i++)		{
			$DateMonth = $rs_a[$i]['DateMonth'];
			$DateMonthArray = explode('-',$DateMonth);
			$本月天数 = date("t",mktime(1,1,1,$DateMonthArray[1],1,$DateMonthArray[0]));
			$开始时间 = date("Y-m-d",mktime(1,1,1,$DateMonthArray[1],1,$DateMonthArray[0]));
			$结束时间 = date("Y-m-d",mktime(1,1,1,$DateMonthArray[1],$本月天数,$DateMonthArray[0]));

			$人员 = $_SESSION['LOGIN_USER_NAME'];
			$sql = "select count(*) as NUM from edu_xingzheng_kaoqinmingxi where 日期 >='$开始时间' and 日期<='$结束时间' and 人员='$人员' and 班次 in ($班次名称TEXT) ";
			$rs = $db->CacheExecute(150,$sql);
			$rsX_a = $rs->GetArray();
			$Number = $rsX_a[0]['NUM'];

			$sql = "select count(*) as NUM from edu_xingzheng_kaoqinmingxi where 日期 >='$开始时间' and 日期<='$结束时间' and (上班考勤状态!='上班缺打卡' or 下班考勤状态!='下班缺打卡') and 人员='$人员' and 班次 in ($班次名称TEXT) ";
			$rs = $db->CacheExecute(150,$sql);
			$rsX_a = $rs->GetArray();
			$Number2 = $rsX_a[0]['NUM'];

			print "".$DateMonth." &nbsp;
			[<a href=\"?".base64_encode("action=StaticAll&Month=$DateMonth")."\" >该月考勤明细数据</a>]

			[<a href=\"?".base64_encode("action=StaticAllFenLei&Month=$DateMonth")."\" >该月考勤统计数据</a>]

			[需要考勤".$Number."条,已完成".$Number2."条]";
			print "<BR>";

		}
		print "</td></tr></table><BR>";

		if($Target=="") $Target = date("Y-m-d");
		$TargetArray = explode('-',$Target);
		$W1 = date('W',mktime(1,1,1,$开始时间Array[1],$开始时间Array[2],$开始时间Array[0]));
		$W2 = date('W',mktime(1,1,1,$TargetArray[1],$TargetArray[2],$TargetArray[0]));
		$W = $W2-$W1+1;

		$sql = "select MAX(周次) as 最大周次 from edu_xingzheng_kaoqinmingxi where 学期 ='$学期名称' and 班次 in ($班次名称TEXT) ";
		$rs = $db->CacheExecute(150,$sql);
		$rsX_a = $rs->GetArray();
		$最大周次 = $rsX_a[0]['最大周次'];

		//当前学期:$学期名称
		print "
		<table border=0 class=TableBlock width=100% >
		<tr class=TableHeader><td valign=bottom align=left>行政人员考勤按周次查询 ".$html_etc['edu_xingzheng_kaoqinmingxi']['学期'].":";
		
		$sql="select 学期名称 from edu_xueqiexec";
		$rs=$db->Execute($sql);//print_R($rs->GetArray());
		$学期文本xx .= "&nbsp;&nbsp;<select class=\"SmallSelect\" name=\"CurXueQi\" onChange=\"var jmpURL='?XX=XX&学期名称=' + this.options[this.selectedIndex].value ; if(jmpURL!='') {window.location=jmpURL;} else {this.selectedIndex=0 ;}\"
		>\n";
		while(!$rs->EOF)			{
		if($学期初始值==$rs->fields['学期名称'])		$temp='selected';
		$学期文本xx .= "<option value=\"".$rs->fields['学期名称']."\" $temp>".$rs->fields['学期名称']."</option>\n";
		$temp='';
		$rs->MoveNext();
		}
		$学期文本xx .= "</select>\n";
		print $学期文本xx;

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



function returnXingZhengKaoQin($开始时间='',$结束时间='')		{
	global $db,$班次名称TEXT;

	//请假外出
	$sql = "select COUNT(*) AS 请假外出,人员 from edu_xingzheng_qingjia where 时间 >='$开始时间' and 时间<='$结束时间'  and 审核状态='1' group by 人员";
	$rs = $db->CacheExecute(150,$sql);
	$rs_a = $rs->GetArray();
	$人员 = $rs_a[0]['人员'];
	$Text[$人员]['请假外出'] = $rs_a[0]['请假外出'];

	//加班记录
	$sql = "select COUNT(*) AS 加班记录,人员 from edu_xingzheng_jiabanbuxiu where 加班时间 >='$开始时间' and 加班时间<='$结束时间'  and 加班审核状态 = '1' group by 人员";
	$rs = $db->CacheExecute(150,$sql);
	$rs_a = $rs->GetArray();
	$人员 = $rs_a[0]['人员'];
	$Text[$人员]['加班记录'] = $rs_a[0]['加班记录'];

	//调休记录
	$sql = "select COUNT(*) AS 调休记录,人员 from edu_xingzheng_tiaoxiububan where 调休时间 >='$开始时间' and 调休时间<='$结束时间'  and (调休审核状态 = '1') group by 人员";
	$rs = $db->CacheExecute(150,$sql);
	$rs_a = $rs->GetArray();
	$人员 = $rs_a[0]['人员'];
	$Text[$人员]['调休记录'] = $rs_a[0]['调休记录'];

	//补班记录
	$sql = "select COUNT(*) AS 补班记录,人员 from edu_xingzheng_tiaoxiububan where 补班时间 >='$开始时间' and 补班时间<='$结束时间'  and 补班审核状态 = '1' group by 人员";
	$rs = $db->CacheExecute(150,$sql);
	$rs_a = $rs->GetArray();
	$人员 = $rs_a[0]['人员'];
	$Text[$人员]['补班记录'] = $rs_a[0]['补班记录'];

	//补休记录
	$sql = "select COUNT(*) AS 补休记录,人员 from edu_xingzheng_jiabanbuxiu where 补休时间 >='$开始时间' and 补休时间<='$结束时间'  and (补休审核状态 = '1') group by 人员";
	$rs = $db->CacheExecute(150,$sql);
	$rs_a = $rs->GetArray();
	$人员 = $rs_a[0]['人员'];
	$Text[$人员]['补休记录'] = $rs_a[0]['补休记录'];

	//考勤补登
	$sql = "select COUNT(*) AS 考勤补登,人员 from edu_xingzheng_kaoqinbudeng where 时间 >='$开始时间' and 时间<='$结束时间'  and (审核状态 = '1') group by 人员";
	$rs = $db->CacheExecute(150,$sql);
	$rs_a = $rs->GetArray();
	$人员 = $rs_a[0]['人员'];
	$Text[$人员]['考勤补登'] = $rs_a[0]['考勤补登'];

	//调班申请
	$sql = "select COUNT(*) AS 调班申请,人员 from edu_xingzheng_tiaoban where 原上班时间 >='$开始时间' and 原上班时间<='$结束时间'  and (审核状态 = '1') group by 人员";
	$rs = $db->CacheExecute(150,$sql);
	$rs_a = $rs->GetArray();
	$人员 = $rs_a[0]['人员'];
	$Text[$人员]['调班申请'] = $rs_a[0]['调班申请'];

	//调班落实
	$sql = "select COUNT(*) AS 调班落实,人员 from edu_xingzheng_tiaoban where 新上班时间 >='$开始时间' and 新上班时间<='$结束时间'  and (审核状态 = '1') group by 人员";
	$rs = $db->CacheExecute(150,$sql);
	$rs_a = $rs->GetArray();
	$人员 = $rs_a[0]['人员'];
	$Text[$人员]['调班落实'] = $rs_a[0]['调班落实'];

	//相互调班申请
	$sql = "select COUNT(*) AS 相互调班申请,原人员 from edu_xingzheng_tiaobanxianghu where 原上班时间 >='$开始时间' and 原上班时间<='$结束时间'  and (审核状态 = '1') group by 原人员";
	$rs = $db->CacheExecute(150,$sql);
	$rs_a = $rs->GetArray();
	$人员 = $rs_a[0]['原人员'];
	$Text[$人员]['相互调班申请'] = $rs_a[0]['相互调班申请'];

	//相互调班落实
	$sql = "select COUNT(*) AS 相互调班落实,新人员 from edu_xingzheng_tiaobanxianghu where 新上班时间 >='$开始时间' and 新上班时间<='$结束时间'  and (审核状态 = '1') group by 新人员";
	$rs = $db->CacheExecute(150,$sql);
	$rs_a = $rs->GetArray();
	$人员 = $rs_a[0]['新人员'];
	$Text[$人员]['相互调班落实'] = $rs_a[0]['相互调班落实'];

	return $Text;

}



function returnKaoQinMingXi($人员,$开始时间='',$结束时间='')		{
	global $db,$班次名称TEXT;

	$sql = "select COUNT(*) AS NUM from edu_xingzheng_kaoqinmingxi where 日期 >='$开始时间' and 日期<='$结束时间' and 人员='$人员' and 班次 in ($班次名称TEXT) ";
	$rs = $db->CacheExecute(150,$sql);
	$rs_a = $rs->GetArray();
	$Number1 = $rs_a[0]['NUM'];
	//上班考勤记录
	$sql = "select COUNT(*) AS NUM from edu_xingzheng_kaoqinmingxi where 日期 >='$开始时间' and 日期<='$结束时间' and 人员='$人员' and (上班考勤状态 = '正常刷卡' or 上班考勤状态 = '上班迟到' or 下班考勤状态 = '考勤补登') and 班次 in ($班次名称TEXT) ";
	$rs = $db->CacheExecute(150,$sql);
	$rs_a = $rs->GetArray();
	$Number2 = $rs_a[0]['NUM'];
	//下班考勤记录
	$sql = "select COUNT(*) AS NUM from edu_xingzheng_kaoqinmingxi where 日期 >='$开始时间' and 日期<='$结束时间' and 人员='$人员' and (下班考勤状态 = '正常刷卡' or 下班考勤状态 = '下班早退' or 下班考勤状态 = '考勤补登' ) and 班次 in ($班次名称TEXT) ";
	$rs = $db->CacheExecute(150,$sql);
	$rs_a = $rs->GetArray();
	$Number3 = $rs_a[0]['NUM'];
	//$Text = "总需考勤次数:".$Number1." 上班已考勤:".$Number2." 缺".($Number1-$Number2)." 下班已考勤:".$Number3." 缺".($Number1-$Number3)."";
	$Text['总需考勤次数'] = $Number1;
	$Text['上班已考勤'] = $Number2;
	$Text['上班考勤缺'] = $Number1-$Number2;
	$Text['下班已考勤'] = $Number3;
	$Text['下班考勤缺'] = $Number1-$Number3;
	return $Text;

}

?>
