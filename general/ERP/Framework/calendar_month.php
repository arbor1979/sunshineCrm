<?php
ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL);

// display warnings and errors
error_reporting(E_WARNING | E_ERROR);

session_start();
require_once('lib.inc.php');
$GLOBAL_SESSION=returnsession();

$LOGIN_USER_ID = $_SESSION['LOGIN_USER_ID'];

$CAL_ID = $_GET['CAL_ID'];
$GOBACK = $_GET['GOBACK'];
$YEAR	= $_GET['YEAR'];
$MONTH	= $_GET['MONTH'];
$DAY	= $_GET['DAY'];

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
$MONTH_BEGIN = strtotime( $YEAR."-".$MONTH."-01" );
$MONTH_END = strtotime( $YEAR."-".$MONTH."-".date( "t", $DATE ) );
?>

<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<script>
function my_affair(AFF_ID)
{
  myleft=(screen.availWidth-250)/2;
  mytop=(screen.availHeight-200)/2;
  window.open("../affair/calendar_note.php?AFF_ID="+AFF_ID,"note_win"+AFF_ID,"height=200,width=250,status=0,toolbar=no,menubar=no,location=no,scrollbars=auto,resizable=no,top="+mytop+",left="+myleft);
}

function my_note(CAL_ID)
{
  myleft=(screen.availWidth-250)/2;
  mytop=(screen.availHeight-200)/2;
  window.open("calendar_note.php?CAL_ID="+CAL_ID,"note_win"+CAL_ID,"height=200,width=250,status=0,toolbar=no,menubar=no,location=no,scrollbars=auto,resizable=no,top="+mytop+",left="+myleft);
}

function My_Submit()
{
  document.form1.submit();
}

function set_year(op)
{
  document.form1.BTN_OP.value=op+" year";
  My_Submit();
}

function set_mon(op)
{
  document.form1.BTN_OP.value=op+" month";
  My_Submit();
}

function set_day(op)
{
  document.form1.BTN_OP.value=op+" day";
  My_Submit();
}

function display_front()
{
   var front=document.getElementById("front");
   if(!front)
      return;
   if(front.style.display=='')
      front.style.display='none';
   else
      front.style.display='';
}

function init()
{
   var elementI=document.getElementsByTagName("DIV");

   for(i=0;i<elementI.length;i++)
   {
      if(elementI[i].id.substr(0,4)!="cal_")
         continue;

      elementI[i].onmouseover=function() {var op_i=document.getElementById(this.id+"_op");if(op_i) op_i.style.display="";}
      elementI[i].onmouseout =function() {var op_i=document.getElementById(this.id+"_op");if(op_i) op_i.style.display="none";}
   }
}
function set_view()
{
    var view=document.form1.VIEW.value;
    if(!view) return;
    var exp = new Date();
    exp.setTime(exp.getTime() + 24*60*60*1000);
    document.cookie = "cal_view="+ escape (view) + ";expires=" + exp.toGMTString()+";path=/";


<?php
echo "location= 'calendar_'+view+'.php?YEAR=";
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
echo "','diary_sub_window','height=560,width=650,status=0,toolbar=no,menubar=no,location=no,left=180,top=50,scrollbars=yes,resizable=yes');\r\n}\r\nfunction del_cal(CAL_ID)\r\n{\r\n   if(window.confirm(\"删除后将不可恢复，确定删除吗？\"))\r\n      location=\"calendar_delete.php?CAL_ID=\"+CAL_ID+\"&GOBACK=calendar_month&OVER_STATUS=1&YEAR=";
echo $YEAR;
echo "&MONTH=";
echo $MONTH;
echo "&DAY=";
echo $DAY;
echo "\";\r\n}\r\n";
?>
	</script>
<?php

echo "</head><body class=\"bodycolor\" topmargin=\"5\" onload=\"init();\">  ";
echo "<table width=\"100%\" border=\"0\" cellspacing=\"0\" class=\"big1\" cellpadding=\"3\" align=\"center\">\r\n ";
echo "<form name=\"form1\" action=\"";
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
echo "        </select><input type=\"button\" value=\" > \" class=\"ArrowButton\" style=\"font-weight:bold\" title=\"下一年\" onclick=\"set_year(1);\"><!-------------- 月 ------------>\r\n        <input type=\"button\" value=\" < \" class=\"ArrowButton\" style=\"font-weight:bold\" title=\"上一月\" onclick=\"set_mon(-1);\"><select name=\"MONTH\" class=\"SmallSelect\" style=\"font-weight:bold\" onchange=\"My_Submit();\">\r\n";
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
echo "</select>
<input type=\"button\" value=\" > \" class=\"ArrowButton\" style=\"font-weight:bold\" title=\"下一天\" onclick=\"set_day(1);\">\r\n
</td>\r\n
<td align=\"right\">\r\n
<select name=\"VIEW\" class=\"SmallSelect\" onchange=\"set_view();\">\r\n
	<option value=\"day\">&nbsp;日列表</option>\r\n
	<option value=\"week\">&nbsp;周列表</option>\r\n
	<option value=\"month\" selected>&nbsp;月列表</option>\r\n
</select>\r\n
</td>\r\n
</tr>\r\n
</form>\r\n
</table>";
$CUR_TIME = date( "Y-m-d H:i:s", time( ) );
$query = "SELECT * from calendar where USER_ID='".$LOGIN_USER_ID."' and year(CAL_TIME)={$YEAR} and month(CAL_TIME)={$MONTH} order by CAL_TIME";
$rs		= $db->Execute($query);

while (!$rs->EOF)
{
    $CAL_ID		= $rs->fields['CAL_ID'];
    $CAL_TIME	= $rs->fields['CAL_TIME'];
    $END_TIME	= $rs->fields['END_TIME'];
    $CAL_TYPE	= $rs->fields['CAL_TYPE'];
    $CONTENT	= $rs->fields['CONTENT'];
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
    $CONTENT = "<div id=\"cal_".$CAL_ID."\" title='".$CAL_TITLE."'>".substr( $CAL_TIME, 11, 5 )."-".substr( $END_TIME, 11, 5 ).( "<br><a href='javascript:my_note(".$CAL_ID.");' style='color:" ).$STATUS_COLOR.";'>".$CONTENT."</a>";
    $CONTENT .= "<br><span id=\"cal_".$CAL_ID."_op\" style=\"display:none;\">";
    if ( $OVER_STATUS == "0" )
    {
        $CONTENT .= " <a href=\"calendar_status.php?CAL_ID=".$CAL_ID."&OVER_STATUS=1&YEAR={$YEAR}&MONTH={$MONTH}&DAY={$DAY}&GOBACK=calendar_month\">完成</a>";
    }
    else if ( $OVER_STATUS == "" || $OVER_STATUS == "1" )
    {
        $CONTENT .= " <a href=\"calendar_status.php?CAL_ID=".$CAL_ID."&OVER_STATUS=0&YEAR={$YEAR}&MONTH={$MONTH}&DAY={$DAY}&GOBACK=calendar_month\">未完成</a>";
    }
    if ( $MANAGER_ID == "" || $MANAGER_ID == $LOGIN_USER_ID )
    {
        //$CONTENT .= "<a href=\"modify.php?CAL_ID=".$CAL_ID."&OVER_STATUS=1&YEAR={$YEAR}&MONTH={$MONTH}&DAY={$DAY}\"> 修改</a>";
        $CONTENT .= " <a href=\"javascript:del_cal(".$CAL_ID.");\">删除</a>";
    }
    $CONTENT .= "</span></div>";
    $CAL_ARRAY[date( "j", strtotime( $CAL_TIME ) )] .= $CONTENT;
	$rs->MoveNext();
}
$I = 1;
for ( ; $I <= date( "t", $DATE ); ++$I )
{
    $DAY_I = strtotime( $YEAR."-".$MONTH."-".$I );
    $query = "SELECT * from affair where USER_ID='".$LOGIN_USER_ID."' and BEGIN_TIME<='".date( "Y-m-d", $DAY_I )." 23:59:59' and (TYPE='2' or TYPE='3' and REMIND_DATE='".date( "w", $DAY_I )."' or TYPE='4' and REMIND_DATE='".date( "j", $DAY_I )."' or TYPE='5' and REMIND_DATE='".date( "n-j", $DAY_I )."') order by BEGIN_TIME desc";
    $rs		= $db->Execute($query);
    while (!$rs->EOF)
    {
        $AFF_ID = $rs->fields['AFF_ID'];
        $BEGIN_TIME = $rs->fields['BEGIN_TIME'];
        $REMIND_DATE = $rs->fields['REMIND_DATE'];
        $REMIND_TIME = $rs->fields['REMIND_TIME'];
        $CONTENT = $rs->fields['CONTENT'];
        $TYPE = $rs->fields['TYPE'];
        $LAST_REMIND = $rs->fields['LAST_REMIND'];
        $CONTENT = htmlspecialchars( $CONTENT );
        if ( $LAST_REMIND == "0000-00-00" )
        {
            $LAST_REMIND = "";
        }
        switch ( $TYPE )
        {
        case "2" :
            $TYPE_DESC = "每日";
            break;
        case "3" :
            $TYPE_DESC = "每周";
            if ( $REMIND_DATE == "1" )
            {
                $REMIND_DATE = "一";
            }
            else if ( $REMIND_DATE == "2" )
            {
                $REMIND_DATE = "二";
            }
            else if ( $REMIND_DATE == "3" )
            {
                $REMIND_DATE = "三";
            }
            else if ( $REMIND_DATE == "4" )
            {
                $REMIND_DATE = "四";
            }
            else if ( $REMIND_DATE == "5" )
            {
                $REMIND_DATE = "五";
            }
            else
            {
                if ( $REMIND_DATE == "6" )
                {
                    $REMIND_DATE = "六";
                }
                else
                {
                    if ( !( $REMIND_DATE == "0" ) )
                    {
                        break;
                    }
                    $REMIND_DATE = "日";
                }
            }
            break;
        case "4" :
            $TYPE_DESC = "每月";
            $REMIND_DATE .= "日";
            break;
        case "5" :
            $TYPE_DESC = "每年";
            $REMIND_DATE = str_replace( "-", "月", $REMIND_DATE )."日";
        }
        $AFF_TITLE = "提醒时间：".$TYPE_DESC.$REMIND_DATE." ".substr( $REMIND_TIME, 0, -3 )."\n上次提醒：".$LAST_REMIND."\n起始时间：".$BEGIN_TIME;
        $CONTENT = substr( $REMIND_TIME, 0, -3 ).( "<br><a href='javascript:my_affair(".$AFF_ID.");' title='" ).$AFF_TITLE."'>".$CONTENT."</a><br>";
        if ( $BEGIN_TIME <= date( "Y-m-d", $DAY_I )." ".$REMIND_TIME )
        {
            $CAL_ARRAY[$I] .= $CONTENT;
        }
		$rs->MoveNext();
    }
}
echo "  <table class=\"TableBlock\" width=\"100%\" align=\"center\">\r\n    <tr align=\"center\" class=\"TableHeader\">\r\n      <td width=\"14%\"><b>周日</b></td>\r\n      <td width=\"15%\"><b>周一</b></td>\r\n      <td width=\"15%\"><b>周二</b></td>\r\n      <td width=\"14%\"><b>周三</b></td>\r\n      <td width=\"14%\"><b>周四</b></td>\r\n      <td width=\"14%\"><b>周五</b></td>\r\n      <td width=\"14%\"><b>周六</b></td>\r\n    </tr>\r\n";
$I = 1;
for ( ; $I <= date( "t", $DATE ); ++$I )
{
    $WEEK = date( "w", strtotime( $YEAR."-".$MONTH."-".$I ) );
    if ( $WEEK == 0 || $I == 1 )
    {
        echo "<tr height=\"80\" class=\"TableData\">";
    }
    $J = 0;
    for ( ; $J < $WEEK && $I == 1; ++$J )
    {
        echo "     <td class=\"TableData\" valign=\"top\">&nbsp</td>\r\n";
    }
    echo "     <td class=\"";
    if ( $I == $DAY )
    {
        echo "TableContent";
    }
    echo "\" valign=\"top\">\r\n       <div align=\"right\" class=\"TableContent\" title=\"转到该日查看\" style=\"cursor:pointer;width: 100%;\" onclick='location=\"calendar_day.php?YEAR=";
    echo $YEAR;
    echo "&MONTH=";
    echo $MONTH;
    echo "&DAY=";
    echo $I;
    echo "\"'>\r\n         <font color=\"blue\"><b>";
    echo $I;
    echo "</b></font>\r\n       </div>\r\n       <div>\r\n         ";
    echo $CAL_ARRAY[$I];
    echo "       </div>\r\n     </td>\r\n";
    if ( $WEEK == 6 )
    {
        echo "</tr>";
    }
}
if ( $WEEK != 6 )
{
    $I = $WEEK;
    for ( ; $I < 6; ++$I )
    {
        echo "     <td class=\"TableData\">&nbsp</td>\r\n";
    }
    echo "   </tr>\r\n";
}
$CUR_MONTH = $MONTH;
$query = "SELECT USER_NAME,BIRTHDAY from user where NOT_LOGIN!='1' and DEPT_ID!=0 order by SUBSTRING(BIRTHDAY,6,5),USER_NAME ASC";
$rs		= $db->Execute($query);
$PERSON_COUNT = 0;
while (!$rs->EOF)
{
    $USER_NAME = $rs->fields['USER_NAME'];
    $BIRTHDAY = $rs->fields['BIRTHDAY'];
    $MON = substr( $BIRTHDAY, 5, 2 );
    $DATA = substr( $BIRTHDAY, 5, 5 );
    if ( !( $MON != $CUR_MONTH ) || !( $BIRTHDAY == "1900-01-01 00:00:00" ) )
    {
        if ( $BIRTHDAY == "0000-00-00 00:00:00" )
        {
            break;
        }
    }
    else
    {
        continue;
    }
    $PERSON_STR .= $USER_NAME."(".$DATA.")&nbsp&nbsp&nbsp&nbsp";
    ++$PERSON_COUNT;
	$rs->MoveNext();
}
if ( 0 < $PERSON_COUNT )
{
    echo "\r\n      <tr class=\"TableData\">\r\n      <td style=\"color:#46A718\" align=\"center\"><b>本月生日：</b></td>\r\n      <td colspan=\"20\">\r\n      ";
    echo $PERSON_STR;
    echo "      </td>\r\n      </tr>\r\n";
}
echo "      </table></body>\r\n</html>";
?>