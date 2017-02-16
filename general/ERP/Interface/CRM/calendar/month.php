<?php
ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL);
error_reporting(E_WARNING | E_ERROR);
require_once("lib.inc.php");
require_once("utility_all.php");
$GLOBAL_SESSION=returnsession();
page_css('CRM日程');
date_default_timezone_set('PRC');
$CUR_YEAR = date( "Y" );
$CUR_MON = date( "m" );
$CUR_DAY = date( "d" );
if ( $BTN_OP != "" )
{
	if($BTN_OP!='0')
	{
    	$DATE = strtotime( $BTN_OP, strtotime( $YEAR."-".$MONTH."-".$DAY ) );
    	$YEAR = date( "Y", $DATE );
    	$MONTH = date( "m", $DATE );
    	$DAY = date( "d", $DATE );
	}
}
else  
{
	if($_SESSION['SEL_YEAR']!='')
		$YEAR=$_SESSION['SEL_YEAR'];
	if($_SESSION['SEL_MONTH']!='')
		$MONTH=$_SESSION['SEL_MONTH'];
	if($_SESSION['SEL_DAY']!='')
		$DAY=$_SESSION['SEL_DAY'];
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
if($user_id=='')
	$user_id=$_SESSION['LOGIN_USER_ID'];
$_SESSION['SEL_YEAR']=$YEAR;
$_SESSION['SEL_MONTH']=$MONTH;
$_SESSION['SEL_DAY']=$DAY;
if ( !checkdate( $MONTH, $DAY, $YEAR ) )
{
    message( "错误", "日期不正确" );
    exit( );
}
$DATE = strtotime( $YEAR."-".$MONTH."-".$DAY );
$MONTH_BEGIN = strtotime( $YEAR."-".$MONTH."-01" );
$MONTH_END = strtotime( $YEAR."-".$MONTH."-".date( "t", $DATE ) );
echo "<html>\r\n<head>\r\n<title>日程安排</title>\r\n<meta http-equiv=\"Content-Type\" content=\"text/html; charset=gb2312\">\r\n<script>\r\nfunction my_affair(AFF_ID)\r\n{\r\n  myleft=(screen.availWidth-250)/2;\r\n  mytop=(screen.availHeight-200)/2;\r\n  window.showModelessDialog(\"../affair/note.php?AFF_ID=\"+AFF_ID,null,\"dialogheight=200;dialogwidth=250;status=no;\");\r\n}\r\n\r\nfunction my_note(CAL_ID)\r\n{\r\n  myleft=(screen.availWidth-250)/2;\r\n  mytop=(screen.availHeight-200)/2;\r\n  window.showModelessDialog(\"note.php?CAL_ID=\"+CAL_ID,null,\"dialogheight=200px;dialogwidth=250px;status=no\");\r\n}\r\n\r\nfunction My_Submit()\r\n{\r\n  document.form1.submit();\r\n}\r\n\r\nfunction set_year(op)\r\n{\r\n  document.form1.BTN_OP.value=op+\" year\";\r\n  My_Submit();\r\n}\r\n\r\nfunction set_mon(op)\r\n{\r\n  document.form1.BTN_OP.value=op+\" month\";\r\n  My_Submit();\r\n}\r\n\r\nfunction set_day(op)\r\n{\r\n  document.form1.BTN_OP.value=op+\" day\";\r\n  My_Submit();\r\n}\r\n\r\nfunction display_front()\r\n{\r\n   var front=document.getElementById(\"front\");\r\n   if(!front)\r\n      return;\r\n   if(front.style.display=='')\r\n      front.style.display='none';\r\n   else\r\n      front.style.display='';\r\n}\r\n\r\nfunction init()\r\n{\r\n   var elementI=document.getElementsByTagName(\"DIV\");\r\n\r\n   for(i=0;i<elementI.length;i++)\r\n   {\r\n      if(elementI[i].id.substr(0,4)!=\"cal_\")\r\n         continue;\r\n\r\n      elementI[i].onmouseover=function() {var op_i=document.getElementById(this.id+\"_op\");if(op_i) op_i.style.display=\"\";}\r\n      elementI[i].onmouseout =function() {var op_i=document.getElementById(this.id+\"_op\");if(op_i) op_i.style.display=\"none\";}\r\n   }\r\n}\r\nfunction set_view()\r\n{\r\n    var view=document.form1.VIEW.value;\r\n    if(!view) return;\r\n    var exp = new Date();\r\n    exp.setTime(exp.getTime() + 24*60*60*1000);\r\n    document.cookie = \"cal_view=\"+ escape (view) + \";expires=\" + exp.toGMTString()+\";path=/\";\r\n    \r\n    location=view+'.php?YEAR=";
echo $YEAR;
echo "&MONTH=";
echo $MONTH;
echo "&DAY=";
echo $DAY;
echo "';\r\n}\r\nfunction new_cal(CAL_TIME)\r\n{\r\n   location='../calendar_newai.php?action=add_default&CAL_DATE=";
echo $YEAR;
echo "-";
echo $MONTH;
echo "-";
echo $DAY;
echo "&CAL_TIME='+CAL_TIME;\r\n}\r\nfunction new_diary()\r\n{\r\n   window.open('../../diary/new/?CUR_DATE=";
echo $YEAR;
echo "-";
echo $MONTH;
echo "-";
echo $DAY;
echo "','diary_sub_window','height=560,width=650,status=0,toolbar=no,menubar=no,location=no,left=180,top=50,scrollbars=yes,resizable=yes');\r\n}\r\nfunction del_cal(CAL_ID)\r\n{\r\n   if(window.confirm(\"删除后将不可恢复，确定删除吗？\"))\r\n      location=\"../calendar_newai.php?action=delete_array&selectid=\"+CAL_ID+\"&OVER_STATUS=1&YEAR=";
echo $YEAR;
echo "&MONTH=";
echo $MONTH;
echo "&DAY=";
echo $DAY;
echo "\";\r\n}\r\n</script>\r\n</head>\r\n\r\n<body class=\"bodycolor\" topmargin=\"5\" onload=\"init();\">\r\n\r\n  <table width=\"100%\" border=\"0\" cellspacing=\"0\" class=\"big1\" cellpadding=\"3\" align=\"center\">\r\n   <form name=\"form1\" action=\"";
echo $_SERVER['SCRIPT_NAME'];
echo "\">\r\n    <tr>\r\n      <td>\r\n       <input type=\"button\" value=\"今天\" class=\"SmallButton\" title=\"今天\" onclick=\"location='";
echo $_SERVER['SCRIPT_NAME'];
echo "?BTN_OP=a&YEAR=";
echo $CUR_YEAR;
echo "&MONTH=";
echo $CUR_MON;
echo "&DAY=";
echo $CUR_DAY;
echo "'\">\r\n       <input type=\"hidden\" value=\"\" name=\"BTN_OP\">\r\n<!-------------- 年 ------------>\r\n        <input type=\"button\" value=\" < \" class=\"ArrowButton\" style=\"font-weight:bold\" title=\"上一年\" onclick=\"set_year(-1);\"><select name=\"YEAR\" class=\"SmallSelect\" style=\"font-weight:bold\" onchange=\"document.form1.BTN_OP.value='0';My_Submit();\">\r\n";
$I = $CUR_YEAR-3;
for ( ; $I <= $CUR_YEAR+1; ++$I )
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
echo "        </select><input type=\"button\" value=\" > \" class=\"ArrowButton\" style=\"font-weight:bold\" title=\"下一年\" onclick=\"set_year(1);\">\r\n\r\n<!-------------- 月 ------------>\r\n        <input type=\"button\" value=\" < \" class=\"ArrowButton\" style=\"font-weight:bold\" title=\"上一月\" onclick=\"set_mon(-1);\"><select name=\"MONTH\" class=\"SmallSelect\" style=\"font-weight:bold\" onchange=\"document.form1.BTN_OP.value='0';My_Submit();\">\r\n";
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
echo "        </select><input type=\"button\" value=\" > \" class=\"ArrowButton\" style=\"font-weight:bold\" title=\"下一月\" onclick=\"set_mon(1);\">\r\n<!-------------- 日 ------------>\r\n        <input type=\"button\" value=\" < \" class=\"ArrowButton\" style=\"font-weight:bold\" title=\"上一天\" onclick=\"set_day(-1);\"><select name=\"DAY\" class=\"SmallSelect\" style=\"font-weight:bold\" onchange=\"document.form1.BTN_OP.value='0';My_Submit();\">\r\n";
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
echo "        </select><input type=\"button\" value=\" > \" class=\"ArrowButton\" style=\"font-weight:bold\" title=\"下一天\" onclick=\"set_day(1);\">\r\n ";
$sql="select * from user where 1=1";
$sql=getRoleByUser($sql,"USER_ID");
$sql.=" order by USER_NAME";
$rs=$db->Execute($sql);
$rs_a=$rs->GetArray();
echo "<select name='user_id' class=\"SmallSelect\" style=\"font-weight:bold\" onchange=\"document.form1.BTN_OP.value='0';My_Submit();\">";
foreach ($rs_a as $row)
{
	$check="";
	if($user_id==$row['USER_ID'])
		$check="selected";
	echo "<option value='".$row['USER_ID']."' $check>".$row['USER_NAME']."</option>";
}
echo "</select>     </td>\r\n      <td align=\"right\">\r\n        <input type=\"button\"  value=\"新建日程\" class=\"SmallButton\" onClick=\"new_cal('".date("H")."');\" title=\"创建新的日程，以便提醒自己\">\r\n        <select name=\"VIEW\" class=\"SmallSelect\" onchange=\"set_view();\">\r\n          <option value=\"day\">&nbsp;日列表</option>\r\n          <option value=\"week\">&nbsp;周列表</option>\r\n          <option value=\"month\" selected>&nbsp;月列表</option>\r\n        </select>\r\n      </td>\r\n    </tr>\r\n   </form>\r\n  </table>\r\n\r\n";
$CUR_TIME = date( "Y-m-d H:i:s", time( ) );
$query = "SELECT * from calendar where USER_ID='".$user_id."' and ((CAL_TIME>='".date( "Y-m-d", $MONTH_BEGIN )." 00:00:00' and CAL_TIME<='".date( "Y-m-d", $MONTH_END )." 23:59:59') or (END_TIME>='".date( "Y-m-d", $MONTH_BEGIN )." 00:00:00' and END_TIME<='".date( "Y-m-d", $MONTH_END )." 23:59:59') or (CAL_TIME<'".date( "Y-m-d", $MONTH_BEGIN )." 00:00:00' and END_TIME>'".date( "Y-m-d", $MONTH_END )." 23:59:59')) order by CAL_TIME";
$rs=$db->Execute($query);
$rs_a=$rs->GetArray();
for ($i=0;$i<sizeof($rs_a);$i++)
{
    $CAL_ID = $rs_a[$i]['id'];
    $CAL_TIME = $rs_a[$i]['CAL_TIME'];
    $END_TIME = $rs_a[$i]['END_TIME'];
   
    $CAL_TYPE = $rs_a[$i]['CAL_TYPE'];
    $CONTENT = $rs_a[$i]['CONTENT'];
    $CONTENT = cutStr($rs_a[$i]['CONTENT'],12);
    if($rs_a[$i]['CONTENT']!=$CONTENT)
    	$CONTENT.="..";
    $MANAGER_ID = $rs_a[$i]['MANAGER_ID'];
    $OVER_STATUS = $rs_a[$i]['OVER_STATUS'];
    $CAL_TITLE = "类型：".$CAL_TYPE."\n";
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
        $rs=$db->Execute($query);
		$rs_b=$rs->GetArray();
        if ( sizeof($rs_b)>0)
        {
            $CAL_TITLE .= "\n安排人：".$rs_b[0]['USER_NAME'];
        }
    }
    $CONTENT = htmlspecialchars( $CONTENT );
    $days=DateDiff_day( $CAL_TIME, $END_TIME);
	$showBeginDate=substr( $CAL_TIME, 11, 5 );
    $showEndDate=substr( $END_TIME, 11, 5 );
    if($days>0)
    {
    	$showBeginDate=date("d日H:i",strtotime($CAL_TIME));
    	$showEndDate=date("d日H:i",strtotime($END_TIME));	
    }	
    $CONTENT = "<div id=\"cal_".$CAL_ID."\" title='".$CAL_TITLE."'>".$showBeginDate."-".$showEndDate.( "<br><a href='javascript:my_note(".$CAL_ID.");' style='color:" ).$STATUS_COLOR.";'>".$CONTENT."</a>";
    $CONTENT .= "<br><span id=\"cal_".$CAL_ID."_op\" style=\"display:none;\">";
    if($user_id==$_SESSION['LOGIN_USER_ID'])
    {
	    if ( $OVER_STATUS == "0" )
	    {
	        $CONTENT .= "<a href=\"../calendar_newai.php?action=finish&id=".$CAL_ID."&OVER_STATUS=1&YEAR={$YEAR}&MONTH={$MONTH}&DAY={$DAY}\"> 完成</a>";
	    }
	    else if ( $OVER_STATUS == "" || $OVER_STATUS == "1" )
	    {
	        $CONTENT .= "<a href=\"../calendar_newai.php?action=finish&id=".$CAL_ID."&OVER_STATUS=0&YEAR={$YEAR}&MONTH={$MONTH}&DAY={$DAY}\"> 未完成</a>";
	    }
	    if ( $MANAGER_ID == "" || $MANAGER_ID == $LOGIN_USER_ID )
	    {
	        $CONTENT .= "<a href=\"../calendar_newai.php?action=edit_default&id=".$CAL_ID."&OVER_STATUS=1&YEAR={$YEAR}&MONTH={$MONTH}&DAY={$DAY}\"> 修改</a>";
	        $CONTENT .= "<a href=\"javascript:del_cal(".$CAL_ID.");\"> 删除</a>";
	    }
    }
    $CONTENT .= "</span></div>";
    $CAL_ARRAY[date( "j", strtotime( $CAL_TIME ) )] .= $CONTENT;
	for($j=0;$j<$days;$j++)
    {
    	$nextDay=DateAdd("d",($j+1),$CAL_TIME);
    	if(compare_time($nextDay,date("Y-m-d",$MONTH_BEGIN))>0 && compare_time($nextDay,date("Y-m-d 23:59:59",$MONTH_END))<0)
    		$CAL_ARRAY[date( "j", strtotime( $nextDay ) )] .= $CONTENT;
    }
}
/*
$I = 1;
for ( ; $I <= date( "t", $DATE ); ++$I )
{
    $DAY_I = strtotime( $YEAR."-".$MONTH."-".$I );
    $query = "SELECT * from affair where USER_ID='".$_SESSION['LOGIN_USER_ID']."' and BEGIN_TIME<='".date( "Y-m-d", $DAY_I )." 23:59:59' and (TYPE='2' or TYPE='3' and REMIND_DATE='".date( "w", $DAY_I )."' or TYPE='4' and REMIND_DATE='".date( "j", $DAY_I )."' or TYPE='5' and REMIND_DATE='".date( "n-j", $DAY_I )."') order by BEGIN_TIME desc";
    $rs=$db->Execute($query);
	$rs_b=$rs->GetArray();
	for ($j=0;$j<sizeof($rs_b);$j++)
	{
        $AFF_ID = $rs_b[$j]['AFF_ID'];
        $BEGIN_TIME = $rs_b[$j]['BEGIN_TIME'];
        $REMIND_DATE = $rs_b[$j]['REMIND_DATE'];
        $REMIND_TIME = $rs_b[$j]['REMIND_TIME'];
        $CONTENT = $rs_b[$j]['CONTENT'];
        $TYPE = $rs_b[$j]['TYPE'];
        $LAST_REMIND = $rs_b[$j]['LAST_REMIND'];
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
    }
}
*/
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
    echo "\" valign=\"top\">\r\n       <div align=\"right\" class=\"TableContent\" title=\"转到该日查看\" style=\"cursor:pointer;width: 100%;\" onclick='location=\"day.php?BTN_OP=a&YEAR=";
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
$PERSON_COUNT = 0;
$query = "SELECT USER_NAME,BIRTHDAY from user  order by SUBSTRING(BIRTHDAY,6,5),USER_NAME ASC";
$rs=$db->Execute($query);
$rs_b=$rs->GetArray();
for ($j=0;$j<sizeof($rs_b);$j++)
{
    $USER_NAME = $rs_b[$j]['USER_NAME'];
    $BIRTHDAY = $rs_b[$j]['BIRTHDAY'];
    $MON = substr( $BIRTHDAY, 5, 2 );
    $DATA = substr( $BIRTHDAY, 5, 5 );
    
    if ($BIRTHDAY == "0000-00-00" ||  $BIRTHDAY == "1900-01-01" )
    {
    
            continue;
 
    }
    else if( $MON == $CUR_MONTH )
    {
       $PERSON_STR .= $USER_NAME."(".$DATA.")&nbsp&nbsp&nbsp&nbsp";
    ++$PERSON_COUNT;
    }
    
}
if ( 0 < $PERSON_COUNT )
{
    echo "\r\n      <tr class=\"TableData\">\r\n      <td style=\"color:#46A718\" align=\"center\"><b>本月生日：</b></td>\r\n      <td colspan=\"20\">\r\n      ";
    echo $PERSON_STR;
    echo "      </td>\r\n      </tr>\r\n";
}
echo "      </table>\r\n\r\n</body>\r\n</html>\r\n\r\n";
?>
