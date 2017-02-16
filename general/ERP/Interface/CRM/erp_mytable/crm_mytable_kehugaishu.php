<?php
ini_set('date.timezone','Asia/Shanghai');
ini_set('display_errors',1);
ini_set('error_reporting',E_ALL);
error_reporting(E_WARNING | E_ERROR);



$user_id = $_SESSION["LOGIN_USER_ID"];
$module_desc = "客户概述";
$module_body = "";
function week_firstday()
{
	return date('Y-m-d', time()-86400*date('w')+(date('w')>0?86400:-6*86400));
}
function month_firstday()
{
	return date('Y-m-d', mktime(0,0,0,date('n'),1,date('Y')));
}
//定义时间变量
$to_sta_date    = date('Y-m-d 0:0:0');
$to_end_date    = date('Y-m-d 23:59:59');
//$week_sta_date  = date('Y-m-d 0:0:0',mktime(0,0,0,date('m'),date('d')-7,date('Y')));
$week_sta_date=week_firstday();
//$month_sta_date = date('Y-m-d 0:0:0',mktime(0,0,0,date('m')-1,date('d'),date('Y')));
$month_sta_date=month_firstday();
$year_sta_date  = date('Y')."-01-01";

//客户总数
$sql_con = "select COUNT(*) AS NUM from customer where 1=1";
$sql_con=getCustomerRoleByUser($sql_con,"sysuser");
$rs = $db->CacheExecute(150,$sql_con);
$rs_con = $rs->fields['NUM'];
//今日新增
$today="and createdate>='$to_sta_date' and createdate<'$to_end_date'";
$sql_today = "select COUNT(*) AS NUM from customer where 1=1 $today";
$sql_today=getCustomerRoleByUser($sql_today,"sysuser");
//echo $sql_today."<br>";
$rs = $db->CacheExecute(150,$sql_today);
$rs_today = $rs->fields['NUM'];
//本周新增
$thisweek="and createdate>='$week_sta_date'";
$sql_week = "select COUNT(*) AS NUM from customer where 1=1 $thisweek";
$sql_week=getCustomerRoleByUser($sql_week,"sysuser");
$rs = $db->CacheExecute(150,$sql_week);
$rs_week = $rs->fields['NUM'];
//本月新增
$thismonth="and createdate>='$month_sta_date'";
$sql_mon = "select COUNT(*) AS NUM from customer where 1=1 $thismonth";
$sql_mon=getCustomerRoleByUser($sql_mon,"sysuser");
$rs = $db->CacheExecute(150,$sql_mon);
$rs_mon = $rs->fields['NUM'];
//本年新增
$thisyear="and createdate>='$year_sta_date'";
$sql_year = "select COUNT(*) AS NUM from customer where 1=1  $thisyear";
$sql_year=getCustomerRoleByUser($sql_year,"sysuser");
$rs = $db->CacheExecute(150,$sql_year);
$rs_year = $rs->fields['NUM'];


$module_body .= "<table border=0 width=100% height=100%>";
$module_body .= "<tr class=TableBlock>
				<td valign=bottom align=left nowrap colspan=2>
				<img src=\"../images/node_user.gif\" align=\"absmiddle\">&nbsp;<a href=../../JXC/customer_newai.php?action=init_default target=_blank>客户总量 (&nbsp;".number_format($rs_con,0,'',',')."&nbsp;)&nbsp;个
				</td>
				</tr>
				<tr class=TableBlock>
				<td valign=bottom align=left nowrap>
				<img src=\"../images/node_user.gif\" align=\"absmiddle\">&nbsp;<a href=../../JXC/customer_newai.php?action=init_default&desksearch=".urlencode($today)." target=_blank>今日新增 (&nbsp;".number_format($rs_today,0,'',',')."&nbsp;)&nbsp;个</a>
				</td>
				<td valign=bottom align=left nowrap>
				<img src=\"../images/node_user.gif\" align=\"absmiddle\">&nbsp;<a href=../../JXC/customer_newai.php?action=init_default&desksearch=".urlencode($thisweek)." target=_blank>本周新增 (&nbsp;".number_format($rs_week,0,'',',')."&nbsp;)&nbsp;个</a>
				</td>
				</tr>
				<tr class=TableBlock>
				<td valign=bottom align=left nowrap>
				<img src=\"../images/node_user.gif\" align=\"absmiddle\">&nbsp;<a href=../../JXC/customer_newai.php?".base64_encode("action=init_default&desksearch=".urlencode($thismonth))." target=_blank>本月新增 (&nbsp;".number_format($rs_mon,0,'',',')."&nbsp;)&nbsp;个</a>
				</td>
				<td valign=bottom align=left nowrap>
				<img src=\"../images/node_user.gif\" align=\"absmiddle\">&nbsp;<a href=../../JXC/customer_newai.php?action=init_default&desksearch=".urlencode($thisyear)." target=_blank>本年新增 (&nbsp;".number_format($rs_year,0,'',',')."&nbsp;)&nbsp;个</a>
				</td>
				
				</tr>";

				$module_body .= "<form action=\"../../JXC/customer_newai.php\" name=\"form1\" method=\"get\">";
				$module_body .= "<tr class=TableBlock>
						<td valign=Middle align=left nowrap colspan=2>&nbsp;客户名称：<input type=\"text\" name=\"searchvalue\" class=\"SmallInput\" size=\"20\" maxlength=\"25\">
						<input type=hidden name='action' value='init_default_search'>
							<input type=hidden name='searchfield' value='supplyname'>
							&nbsp;<input type=\"submit\" value=\"查询\" class=\"SmallButton\" title=\"模糊查询\" name=\"button\">
						        </td></tr></form>";
				$module_body .= "</table>";

echo $module_body;

?>