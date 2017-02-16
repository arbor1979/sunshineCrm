<?php
ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL);

// display warnings and errors
error_reporting(E_WARNING | E_ERROR);

session_start();
require_once('lib.inc.php');
$GLOBAL_SESSION=returnsession();
//print_R($_GET);

if ( $_GET['cal_view'] == "day" || $_GET['cal_view'] == "month" )
{
    header( "location:calendar_".$_GET['cal_view'].".php" );
}
elseif ( $_COOKIE['cal_view'] == "day" || $_COOKIE['cal_view'] == "month" )
{
    header( "location:calendar_".$_COOKIE['cal_view'].".php" );
}


page_css("个人日程安排");


$CUR_YEAR = date( "Y" );
$CUR_MON = date( "m" );
$CUR_DAY = date( "d" );
if ( $BTN_OP != "" )
{
    $DATE = strtotime( $BTN_OP, strtotime( $YEAR."-".$MONTH."-".$DAY ) );
    $YEAR = date( "Y", $DATE );
    $MONTH = date( "m", $DATE );
    $DAY = date( "d", $DATE );
}
if ( !$YEAR )
{
    $YEAR = $CUR_YEAR;
}
if ( !$MONTH )
{
    $MONTH = $CUR_MON;
}
if ( !$DAY )
{
    $DAY = $CUR_DAY;
}
if ( !checkdate( $MONTH, $DAY, $YEAR ) )
{
    message( "错误", "日期不正确" );
    exit( );
}
$DATE = strtotime( $YEAR."-".$MONTH."-".$DAY );
$WEEK_BEGIN = strtotime( "-".date( "w", $DATE )."days", $DATE );
$WEEK_END = strtotime( "+6 days", $WEEK_BEGIN );
echo "<html>\r\n<head>\r\n<title>日程安排</title>\r\n<meta http-equiv=\"Content-Type\" content=\"text/html; charset=gb2312\">\r\n<script>\r\nfunction my_affair(AFF_ID)\r\n{\r\n  myleft=(screen.availWidth-250)/2;\r\n  mytop=(screen.availHeight-200)/2;\r\n  window.open(\"../affair/calendar_note.php?AFF_ID=\"+AFF_ID,\"note_win\"+AFF_ID,\"height=200,width=250,status=0,toolbar=no,menubar=no,location=no,scrollbars=auto,resizable=no,top=\"+mytop+\",left=\"+myleft);\r\n}function my_note(CAL_ID)\r\n{\r\n  myleft=(screen.availWidth-250)/2;\r\n  mytop=(screen.availHeight-200)/2;\r\n  window.open(\"calendar_note.php?CAL_ID=\"+CAL_ID,\"note_win\"+CAL_ID,\"height=200,width=250,status=0,toolbar=no,menubar=no,location=no,scrollbars=auto,resizable=no,top=\"+mytop+\",left=\"+myleft);\r\n}function My_Submit()\r\n{\r\n  document.form1.submit();\r\n}function set_year(op)\r\n{\r\n  document.form1.BTN_OP.value=op+\" year\";\r\n  My_Submit();\r\n}function set_mon(op)\r\n{\r\n  document.form1.BTN_OP.value=op+\" month\";\r\n  My_Submit();\r\n}function set_day(op)\r\n{\r\n  document.form1.BTN_OP.value=op+\" day\";\r\n  My_Submit();\r\n}function display_front()\r\n{\r\n   var front=document.getElementById(\"front\");\r\n   if(!front)\r\n      return;\r\n   if(front.style.display=='')\r\n      front.style.display='none';\r\n   else\r\n      front.style.display='';\r\n}function init()\r\n{\r\n   var elementI=document.getElementsByTagName(\"DIV\");   for(i=0;i<elementI.length;i++)\r\n   {\r\n      if(elementI[i].id.substr(0,4)!=\"cal_\")\r\n         continue;      elementI[i].onmouseover=function() {var op_i=document.getElementById(this.id+\"_op\");if(op_i) op_i.style.display=\"\";}\r\n      elementI[i].onmouseout =function() {var op_i=document.getElementById(this.id+\"_op\");if(op_i) op_i.style.display=\"none\";}\r\n   }\r\n}\r\nfunction set_view()\r\n{\r\n    var view=document.form1.VIEW.value;\r\n    if(!view) return;\r\n    var exp = new Date();\r\n    exp.setTime(exp.getTime() + 24*60*60*1000);\r\n    document.cookie = \"cal_view=\"+ escape (view) + \";expires=\" + exp.toGMTString()+\";path=/\";\r\n    \r\n    location='calendar_'+view+'.php?YEAR=";
echo $YEAR;
echo "&MONTH=";
echo $MONTH;
echo "&DAY=";
echo $DAY;
echo "';\r\n}\r\nfunction new_cal(CAL_TIME)\r\n{\r\n   window.open('new?CAL_DATE=";
echo $YEAR;
echo "-";
echo $MONTH;
echo "-";
echo $DAY;
echo "&CAL_TIME='+CAL_TIME,'oa_sub_window','height=350,width=500,status=0,toolbar=no,menubar=no,location=no,left=300,top=200,scrollbars=yes,resizable=yes');\r\n}\r\nfunction new_diary()\r\n{\r\n   window.open('../../diary/new/?CUR_DATE=";
echo $YEAR;
echo "-";
echo $MONTH;
echo "-";
echo $DAY;
echo "','diary_sub_window','height=560,width=650,status=0,toolbar=no,menubar=no,location=no,left=180,top=50,scrollbars=yes,resizable=yes');\r\n}\r\nfunction del_cal(CAL_ID)\r\n{\r\n   if(window.confirm(\"删除后将不可恢复，确定删除吗？\"))\r\n      location=\"calendar_delete.php?CAL_ID=\"+CAL_ID+\"&GOBACK=calendar_week&OVER_STATUS=1&YEAR=";
echo $YEAR;
echo "&MONTH=";
echo $MONTH;
echo "&DAY=";
echo $DAY;
echo "\";\r\n}\r\n</script>\r\n</head><body class=\"bodycolor\" topmargin=\"5\" onload=\"init();\">  <table width=\"100%\" border=\"0\" cellspacing=\"0\" class=\"big1\" cellpadding=\"3\" align=\"center\">\r\n   <form name=\"form1\" action=\"";
echo $_SERVER['SCRIPT_NAME'];
echo "\">\r\n    <tr>\r\n      <td>\r\n       <input type=\"button\" value=\"今天\" class=\"SmallButton\" title=\"今天\" onclick=\"location='";
echo $_SERVER['SCRIPT_NAME'];
echo "?YEAR=";
echo $CUR_YEAR;
echo "&MONTH=";
echo $CUR_MON;
echo "&DAY=";
echo $CUR_DAY;
echo "'\">\r\n       <input type=\"hidden\" value=\"\" name=\"BTN_OP\">\r\n<!-------------- 年 ------------>\r\n        <input type=\"button\" value=\" < \" class=\"ArrowButton\" style=\"font-weight:bold\" title=\"上一年\" onclick=\"set_year(-1);\"><select name=\"YEAR\" class=\"SmallSelect\" style=\"font-weight:bold\" onchange=\"My_Submit();\">\r\n";
$I = 2000;
for ( ; $I <= 2015; ++$I )
{
    echo "          <option value=\"";
    echo $I;
    echo "\" ";
    if ( $I == $YEAR )
    {
        echo "selected";
    }
    echo ">";
    echo $I;
    echo "年</option>\r\n";
}
echo "
</select>
<input type=\"button\" value=\" > \" class=\"ArrowButton\" style=\"font-weight:bold\" title=\"下一年\" onclick=\"set_year(1);\">
<!-------------- 月 ------------>\r\n
<input type=\"button\" value=\" < \" class=\"ArrowButton\" style=\"font-weight:bold\" title=\"上一月\" onclick=\"set_mon(-1);\">
<select name=\"MONTH\" class=\"SmallSelect\" style=\"font-weight:bold\" onchange=\"My_Submit();\">\r\n";
$I = 1;
for ( ; $I <= 12; ++$I )
{
    if ( $I < 10 )
    {
        $I = "0".$I;
    }
    echo "          <option value=\"";
    echo $I;
    echo "\" ";
    if ( $I == $MONTH )
    {
        echo "selected";
    }
    echo ">";
    echo $I;
    echo "月</option>\r\n";
}
echo "        </select><input type=\"button\" value=\" > \" class=\"ArrowButton\" style=\"font-weight:bold\" title=\"下一月\" onclick=\"set_mon(1);\">\r\n<!-------------- 日 ------------>\r\n        <input type=\"button\" value=\" < \" class=\"ArrowButton\" style=\"font-weight:bold\" title=\"上一天\" onclick=\"set_day(-1);\"><select name=\"DAY\" class=\"SmallSelect\" style=\"font-weight:bold\" onchange=\"My_Submit();\">\r\n";
$I = 1;
for ( ; $I <= date( "t", strtotime( $YEAR."-".$MONTH."-".$DAY ) ); ++$I )
{
    if ( $I < 10 )
    {
        $I = "0".$I;
    }
    echo "          <option value=\"";
    echo $I;
    echo "\" ";
    if ( $I == $DAY )
    {
        echo "selected";
    }
    echo ">";
    echo $I;
    echo "日</option>\r\n";
}
echo "        </select><input type=\"button\" value=\" > \" class=\"ArrowButton\" style=\"font-weight:bold\" title=\"下一天\" onclick=\"set_day(1);\">\r\n      </td>\r\n      <td align=\"right\">\r\n        <select name=\"VIEW\" class=\"SmallSelect\" onchange=\"set_view();\">\r\n          <option value=\"day\">&nbsp;日列表</option>\r\n          <option value=\"index\" selected>&nbsp;周列表</option>\r\n          <option value=\"month\">&nbsp;月列表</option>\r\n        </select>\r\n      </td>\r\n    </tr>\r\n   </form>\r\n  </table>\r\n";
$CUR_TIME = date( "Y-m-d H:i:s", time( ) );
$query = "SELECT * from calendar where USER_ID='".$LOGIN_USER_ID."' and CAL_TIME>='".date( "Y-m-d", $WEEK_BEGIN )." 00:00:00' and CAL_TIME<='".date( "Y-m-d", $WEEK_END )." 23:59:59' order by CAL_TIME";
$rs		= $db->Execute($query);
while (!$rs->EOF)
{
    $CAL_ID = $rs->fields['CAL_ID'];
    $CAL_TIME = $rs->fields['CAL_TIME'];
    $END_TIME = $rs->fields['END_TIME'];
    $CAL_TYPE = $rs->fields['CAL_TYPE'];
    $CONTENT = $rs->fields['CONTENT'];
    $MANAGER_ID = $rs->fields['MANAGER_ID'];
    $OVER_STATUS = $rs->fields['OVER_STATUS'];
    $CAL_TITLE = "类型：".get_code_name( $CAL_TYPE, "CAL_TYPE" )."\n";
    if ( $OVER_STATUS == "0" )
    {
        if ( 0 < compare_time( $CUR_TIME, $END_TIME ) )
        {
            $STATUS_COLOR = "#FF0000";
            $CAL_TITLE .= "状态：已过期";
        }
        else if ( compare_time( $CUR_TIME, $CAL_TIME ) < 0 )
        {
            $STATUS_COLOR = "#0000FF";
            $CAL_TITLE .= "状态：未至";
        }
        else
        {
            $STATUS_COLOR = "#0000FF";
            $CAL_TITLE .= "状态：进行中";
        }
    }
    else
    {
        $STATUS_COLOR = "#00AA00";
        $CAL_TITLE .= "状态：已完成";
    }
    if ( $MANAGER_ID != "" )
    {
        $query = "SELECT USER_NAME from user where USER_ID='".$MANAGER_ID."'";
        $cursor1 = exequery( $connection, $query );
        if ( $ROW1 = mysql_fetch_array( $cursor1 ) )
        {
            $CAL_TITLE .= "\n安排人：".$ROW1['USER_NAME'];
        }
    }
    $CONTENT = htmlspecialchars( $CONTENT );
    $CONTENT = "<div id=\"cal_".$CAL_ID."\" title='".$CAL_TITLE."' style='width:100%;'>".substr( $CAL_TIME, 11, 5 )."-".substr( $END_TIME, 11, 5 ).( "<br><a href='javascript:my_note(".$CAL_ID.");' style='color:" ).$STATUS_COLOR.";'>".$CONTENT."</a>";
    $CONTENT .= "<br><span id=\"cal_".$CAL_ID."_op\" style=\"display:none;\">";
    if ( $OVER_STATUS == "0" )
    {
        $CONTENT .= " <a href=\"calendar_status.php?CAL_ID=".$CAL_ID."&OVER_STATUS=1&YEAR={$YEAR}&MONTH={$MONTH}&DAY={$DAY}&GOBACK=calendar_week\">完成</a>";
    }
    else if ( $OVER_STATUS == "" || $OVER_STATUS == "1" )
    {
        $CONTENT .= " <a href=\"calendar_status.php?CAL_ID=".$CAL_ID."&OVER_STATUS=0&YEAR={$YEAR}&MONTH={$MONTH}&DAY={$DAY}&GOBACK=calendar_week\">未完成</a>";
    }
    if ( $MANAGER_ID == "" || $MANAGER_ID == $LOGIN_USER_ID )
    {
        //$CONTENT .= "<a href=\"modify.php?CAL_ID=".$CAL_ID."&OVER_STATUS=1&YEAR={$YEAR}&MONTH={$MONTH}&DAY={$DAY}\"> 修改</a>";
        $CONTENT .= " <a href=\"javascript:del_cal(".$CAL_ID.");\">删除</a>";
    }
    $CONTENT .= "</span></div>";
    $CAL_ARRAY[date( "w", strtotime( $CAL_TIME ) )][date( "G", strtotime( $CAL_TIME ) )] .= $CONTENT;
	$rs->MoveNext();
}
$query = "SELECT * from affair where USER_ID='".$LOGIN_USER_ID."' and BEGIN_TIME<='".date( "Y-m-d", $WEEK_END )." 23:59:59' and TYPE='2' order by BEGIN_TIME desc";
$rs		= $db->Execute($query);
while (!$rs->EOF)
{
    $AFF_ID = $rs->fields['AFF_ID'];
    $BEGIN_TIME = $rs->fields['BEGIN_TIME'];
    $REMIND_DATE = $rs->fields['REMIND_DATE'];
    $REMIND_TIME = $rs->fields['REMIND_TIME'];
    $CONTENT = $rs->fields['CONTENT'];
    $LAST_REMIND = $rs->fields['LAST_REMIND'];
    $CONTENT = htmlspecialchars( $CONTENT );
    if ( $LAST_REMIND == "0000-00-00" )
    {
        $LAST_REMIND = "";
    }
    $AFF_TITLE = "提醒时间：每日 ".substr( $REMIND_TIME, 0, -3 )."\n上次提醒：".$LAST_REMIND."\n起始时间：".$BEGIN_TIME;
    $CONTENT = substr( $REMIND_TIME, 0, -3 ).( "<br><a href='javascript:my_affair(".$AFF_ID.");' title='" ).$AFF_TITLE."'>".$CONTENT."</a><br>";
    $REMIND_HOUR = intval( substr( $REMIND_TIME, 0, strpos( $REMIND_TIME, ":" ) ) );
    $I = 0;
    for ( ; $I < 7; ++$I )
    {
        if ( $BEGIN_TIME <= date( "Y-m-d", $WEEK_BEGIN + $I * 86400 )." ".$REMIND_TIME )
        {
            $CAL_ARRAY[$I][$REMIND_HOUR] .= $CONTENT;
        }
    }
	$rs->MoveNext();
}
$query = "SELECT * from affair where USER_ID='".$LOGIN_USER_ID."' and BEGIN_TIME<='".date( "Y-m-d", $WEEK_END )." 23:59:59' and TYPE='3' order by BEGIN_TIME desc";
$rs		= $db->Execute($query);
while (!$rs->EOF)
{
    $AFF_ID = $rs->fields['AFF_ID'];
    $BEGIN_TIME = $rs->fields['BEGIN_TIME'];
    $REMIND_DATE = $rs->fields['REMIND_DATE'];
    $REMIND_TIME = $rs->fields['REMIND_TIME'];
    $CONTENT = $rs->fields['CONTENT'];
    $LAST_REMIND = $rs->fields['LAST_REMIND'];
    $CONTENT = htmlspecialchars( $CONTENT );
    if ( $LAST_REMIND == "0000-00-00" )
    {
        $LAST_REMIND = "";
    }
    if ( $REMIND_DATE == 0 )
    {
        $REMIND_DATE_DESC = "日";
    }
    else if ( $REMIND_DATE == 1 )
    {
        $REMIND_DATE_DESC = "一";
    }
    else if ( $REMIND_DATE == 2 )
    {
        $REMIND_DATE_DESC = "二";
    }
    else if ( $REMIND_DATE == 3 )
    {
        $REMIND_DATE_DESC = "三";
    }
    else if ( $REMIND_DATE == 4 )
    {
        $REMIND_DATE_DESC = "四";
    }
    else if ( $REMIND_DATE == 5 )
    {
        $REMIND_DATE_DESC = "五";
    }
    else if ( $REMIND_DATE == 6 )
    {
        $REMIND_DATE_DESC = "六";
    }
    $AFF_TITLE = "提醒时间：每周".$REMIND_DATE_DESC." ".substr( $REMIND_TIME, 0, -3 )."\n上次提醒：".$LAST_REMIND."\n起始时间：".$BEGIN_TIME;
    $CONTENT = substr( $REMIND_TIME, 0, -3 ).( "<br><a href='javascript:my_affair(".$AFF_ID.");' title='" ).$AFF_TITLE."'>".$CONTENT."</a><br>";
    $REMIND_HOUR = intval( substr( $REMIND_TIME, 0, strpos( $REMIND_TIME, ":" ) ) );
    if ( $BEGIN_TIME <= date( "Y-m-d", $WEEK_BEGIN + $REMIND_DATE * 86400 )." ".$REMIND_TIME )
    {
        $CAL_ARRAY[$REMIND_DATE][$REMIND_HOUR] .= $CONTENT;
    }
	$rs->MoveNext();
}
$query = "SELECT * from affair where USER_ID='".$LOGIN_USER_ID."' and BEGIN_TIME<='".date( "Y-m-d", $WEEK_END )." 23:59:59' and TYPE='4' and REMIND_DATE>='".date( "j", $WEEK_BEGIN )."' and REMIND_DATE<='".date( "j", $WEEK_END )."' order by BEGIN_TIME desc";
$rs		= $db->Execute($query);
while (!$rs->EOF)
{
    $AFF_ID = $rs->fields['AFF_ID'];
    $BEGIN_TIME = $rs->fields['BEGIN_TIME'];
    $REMIND_DATE = $rs->fields['REMIND_DATE'];
    $REMIND_TIME = $rs->fields['REMIND_TIME'];
    $CONTENT = $rs->fields['CONTENT'];
    $LAST_REMIND = $rs->fields['LAST_REMIND'];
    $CONTENT = htmlspecialchars( $CONTENT );
    if ( $LAST_REMIND == "0000-00-00" )
    {
        $LAST_REMIND = "";
    }
    $AFF_TITLE = "提醒时间：每月".$REMIND_DATE."日 ".substr( $REMIND_TIME, 0, -3 )."\n上次提醒：".$LAST_REMIND."\n起始时间：".$BEGIN_TIME;
    $CONTENT = substr( $REMIND_TIME, 0, -3 ).( "<br><a href='javascript:my_affair(".$AFF_ID.");' title='" ).$AFF_TITLE."'>".$CONTENT."</a><br>";
    $REMIND_WEEK = date( "w", strtotime( date( "Y-m-", $WEEK_BEGIN ).$REMIND_DATE ) );
    $REMIND_HOUR = intval( substr( $REMIND_TIME, 0, strpos( $REMIND_TIME, ":" ) ) );
    if ( $BEGIN_TIME <= date( "Y-m-", $WEEK_BEGIN ).$REMIND_DATE." ".$REMIND_TIME )
    {
        $CAL_ARRAY[$REMIND_WEEK][$REMIND_HOUR] .= $CONTENT;
    }
	$rs->MoveNext();
}
$query = "SELECT * from affair where USER_ID='".$LOGIN_USER_ID."' and BEGIN_TIME<='".date( "Y-m-d", $WEEK_END )." 23:59:59' and TYPE='5' and REMIND_DATE>='".date( "n-j", $WEEK_BEGIN )."' and REMIND_DATE<='".date( "n-j", $WEEK_END )."' order by BEGIN_TIME desc";
$rs		= $db->Execute($query);
while (!$rs->EOF)
{
    $AFF_ID = $rs->fields['AFF_ID'];
    $BEGIN_TIME = $rs->fields['BEGIN_TIME'];
    $REMIND_DATE = $rs->fields['REMIND_DATE'];
    $REMIND_TIME = $rs->fields['REMIND_TIME'];
    $CONTENT = $rs->fields['CONTENT'];
    $LAST_REMIND = $rs->fields['LAST_REMIND'];
    $CONTENT = htmlspecialchars( $CONTENT );
    if ( $LAST_REMIND == "0000-00-00" )
    {
        $LAST_REMIND = "";
    }
    $AFF_TITLE = "提醒时间：每年".str_replace( "-", "月", $REMIND_DATE )."日 ".substr( $REMIND_TIME, 0, -3 )."\n上次提醒：".$LAST_REMIND."\n起始时间：".$BEGIN_TIME;
    $CONTENT = substr( $REMIND_TIME, 0, -3 ).( "<br><a href='javascript:my_affair(".$AFF_ID.");' title='" ).$AFF_TITLE."'>".$CONTENT."</a><br>";
    $REMIND_WEEK = date( "w", strtotime( date( "Y-", $WEEK_BEGIN ).$REMIND_DATE ) );
    $REMIND_HOUR = intval( substr( $REMIND_TIME, 0, strpos( $REMIND_TIME, ":" ) ) );
    if ( $BEGIN_TIME <= date( "Y-", $WEEK_BEGIN ).$REMIND_DATE." ".$REMIND_TIME )
    {
        $CAL_ARRAY[$REMIND_WEEK][$REMIND_HOUR] .= $CONTENT;
    }
	$rs->MoveNext();
}
echo "\r\n  <table class=\"TableBlock\" width=\"100%\" align=\"center\">\r\n    <tr align=\"center\" class=\"TableHeader\">\r\n      <td class=\"TableControl\" width=\"9%\"><a href=\"javascript:display_front();\"><font color=green>0-6点</font></a></td>\r\n      <td width=\"13%\"><b><a href=\"calendar_day.php?YEAR=";
echo date( "Y", $WEEK_BEGIN );
echo "&MONTH=";
echo date( "m", $WEEK_BEGIN );
echo "&DAY=";
echo date( "d", $WEEK_BEGIN );
echo "\">";
echo date( "m/d", $WEEK_BEGIN );
echo "(周日)</a></b></td>\r\n      <td width=\"13%\"><b><a href=\"calendar_day.php?YEAR=";
echo date( "Y", $WEEK_BEGIN + 86400 );
echo "&MONTH=";
echo date( "m", $WEEK_BEGIN + 86400 );
echo "&DAY=";
echo date( "d", $WEEK_BEGIN + 86400 );
echo "\">";
echo date( "m/d", $WEEK_BEGIN + 86400 );
echo "(周一)</a></b></td>\r\n      <td width=\"13%\"><b><a href=\"calendar_day.php?YEAR=";
echo date( "Y", $WEEK_BEGIN + 172800 );
echo "&MONTH=";
echo date( "m", $WEEK_BEGIN + 172800 );
echo "&DAY=";
echo date( "d", $WEEK_BEGIN + 172800 );
echo "\">";
echo date( "m/d", $WEEK_BEGIN + 172800 );
echo "(周二)</a></b></td>\r\n      <td width=\"13%\"><b><a href=\"calendar_day.php?YEAR=";
echo date( "Y", $WEEK_BEGIN + 259200 );
echo "&MONTH=";
echo date( "m", $WEEK_BEGIN + 259200 );
echo "&DAY=";
echo date( "d", $WEEK_BEGIN + 259200 );
echo "\">";
echo date( "m/d", $WEEK_BEGIN + 259200 );
echo "(周三)</a></b></td>\r\n      <td width=\"13%\"><b><a href=\"calendar_day.php?YEAR=";
echo date( "Y", $WEEK_BEGIN + 345600 );
echo "&MONTH=";
echo date( "m", $WEEK_BEGIN + 345600 );
echo "&DAY=";
echo date( "d", $WEEK_BEGIN + 345600 );
echo "\">";
echo date( "m/d", $WEEK_BEGIN + 345600 );
echo "(周四)</a></b></td>\r\n      <td width=\"13%\"><b><a href=\"calendar_day.php?YEAR=";
echo date( "Y", $WEEK_BEGIN + 432000 );
echo "&MONTH=";
echo date( "m", $WEEK_BEGIN + 432000 );
echo "&DAY=";
echo date( "d", $WEEK_BEGIN + 432000 );
echo "\">";
echo date( "m/d", $WEEK_BEGIN + 432000 );
echo "(周五)</a></b></td>\r\n      <td width=\"13%\"><b><a href=\"calendar_day.php?YEAR=";
echo date( "Y", $WEEK_BEGIN + 518400 );
echo "&MONTH=";
echo date( "m", $WEEK_BEGIN + 518400 );
echo "&DAY=";
echo date( "d", $WEEK_BEGIN + 518400 );
echo "\">";
echo date( "m/d", $WEEK_BEGIN + 518400 );
echo "(周六)</a></b></td>\r\n    </tr>\r\n    <tbody id=\"front\" style=\"display:none;\">\r\n";
$I = 0;
for ( ; $I < 7; ++$I )
{
    echo "    <tr class=\"TableData\" valign=\"top\" height=\"40\">\r\n      <td align=\"center\" class=\"TableControl\" width=\"9%\"><font color=green>";
    if ( $I < 10 )
    {
        echo "0";
    }
    echo $I;
    echo ":00</font></td>\r\n      <td width=\"13%\"";
    if ( $DATE == $WEEK_BEGIN )
    {
        echo " class=\"TableContent\"";
    }
    echo ">";
    echo $CAL_ARRAY[0][$I];
    echo "</td>\r\n      <td width=\"13%\"";
    if ( $DATE == $WEEK_BEGIN + 86400 )
    {
        echo " class=\"TableContent\"";
    }
    echo ">";
    echo $CAL_ARRAY[1][$I];
    echo "</td>\r\n      <td width=\"13%\"";
    if ( $DATE == $WEEK_BEGIN + 172800 )
    {
        echo " class=\"TableContent\"";
    }
    echo ">";
    echo $CAL_ARRAY[2][$I];
    echo "</td>\r\n      <td width=\"13%\"";
    if ( $DATE == $WEEK_BEGIN + 259200 )
    {
        echo " class=\"TableContent\"";
    }
    echo ">";
    echo $CAL_ARRAY[3][$I];
    echo "</td>\r\n      <td width=\"13%\"";
    if ( $DATE == $WEEK_BEGIN + 345600 )
    {
        echo " class=\"TableContent\"";
    }
    echo ">";
    echo $CAL_ARRAY[4][$I];
    echo "</td>\r\n      <td width=\"13%\"";
    if ( $DATE == $WEEK_BEGIN + 432000 )
    {
        echo " class=\"TableContent\"";
    }
    echo ">";
    echo $CAL_ARRAY[5][$I];
    echo "</td>\r\n      <td width=\"13%\"";
    if ( $DATE == $WEEK_BEGIN + 518400 )
    {
        echo " class=\"TableContent\"";
    }
    echo ">";
    echo $CAL_ARRAY[6][$I];
    echo "</td>\r\n    </tr>\r\n";
}
echo "    </tbody>\r\n";
$I = 7;
for ( ; $I < 24; ++$I )
{
    echo "    <tr class=\"TableData\" valign=\"top\" height=\"40\">\r\n      <td align=\"center\" class=\"TableControl\" width=\"9%\"><font color=green>";
    if ( $I < 10 )
    {
        echo "0";
    }
    echo $I;
    echo ":00</font></td>\r\n      <td width=\"13%\"";
    if ( $DATE == $WEEK_BEGIN )
    {
        echo " class=\"TableContent\"";
    }
    echo ">";
    echo $CAL_ARRAY[0][$I];
    echo "</td>\r\n      <td width=\"13%\"";
    if ( $DATE == $WEEK_BEGIN + 86400 )
    {
        echo " class=\"TableContent\"";
    }
    echo ">";
    echo $CAL_ARRAY[1][$I];
    echo "</td>\r\n      <td width=\"13%\"";
    if ( $DATE == $WEEK_BEGIN + 172800 )
    {
        echo " class=\"TableContent\"";
    }
    echo ">";
    echo $CAL_ARRAY[2][$I];
    echo "</td>\r\n      <td width=\"13%\"";
    if ( $DATE == $WEEK_BEGIN + 259200 )
    {
        echo " class=\"TableContent\"";
    }
    echo ">";
    echo $CAL_ARRAY[3][$I];
    echo "</td>\r\n      <td width=\"13%\"";
    if ( $DATE == $WEEK_BEGIN + 345600 )
    {
        echo " class=\"TableContent\"";
    }
    echo ">";
    echo $CAL_ARRAY[4][$I];
    echo "</td>\r\n      <td width=\"13%\"";
    if ( $DATE == $WEEK_BEGIN + 432000 )
    {
        echo " class=\"TableContent\"";
    }
    echo ">";
    echo $CAL_ARRAY[5][$I];
    echo "</td>\r\n      <td width=\"13%\"";
    if ( $DATE == $WEEK_BEGIN + 518400 )
    {
        echo " class=\"TableContent\"";
    }
    echo ">";
    echo $CAL_ARRAY[6][$I];
    echo "</td>\r\n    </tr>\r\n";
}
echo "  </table>\r\n</body>\r\n</html>";
?><?php
/*
	版权归属:郑州单点科技软件有限公司;
	联系方式:0371-69663266;
	公司地址:河南郑州经济技术开发区第五大街经北三路通信产业园四楼西南;
	公司简介:郑州单点科技软件有限公司位于中国中部城市-郑州,成立于2007年1月,致力于把基于先进信息技术（包括通信技术）的最佳管理与业务实践普及到教育行业客户的管理与业务创新活动中，全面提供具有自主知识产权的教育管理软件、服务与解决方案，是中部最优秀的高校教育管理软件及中小学校管理软件提供商。目前已经有多家高职和中职类院校使用通达中部研发中心开发的软件和服务;

	软件名称:单点科技软件开发基础性架构平台,以及在其基础之上扩展的任何性软件作品;
	发行协议:数字化校园产品为商业软件,发行许可为LICENSE方式;单点CRM系统即SunshineCRM系统为GPLV3协议许可,GPLV3协议许可内容请到百度搜索;
	特殊声明:软件所使用的ADODB库,PHPEXCEL库,SMTARY库归原作者所有,余下代码沿用上述声明;
	*/
?>