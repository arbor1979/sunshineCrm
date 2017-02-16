<?php

ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL);
error_reporting(E_WARNING | E_ERROR);
require_once("lib.inc.php");
include_once( "utility_all.php" );
$GLOBAL_SESSION=returnsession();
page_css('CRM日程');
echo "\r\n<html>\r\n\r\n";
$CAL_ID=$_GET['CAL_ID'];
$query = "select * from calendar where id='".$CAL_ID."'";
$rs=$db->Execute($query);
$rs_a=$rs->GetArray();
if (sizeof($rs_a)==1)
{
    $CAL_TIME = $rs_a[$i]['CAL_TIME'];
    $END_TIME = $rs_a[$i]['END_TIME'];
    $CONTENT = $rs_a[$i]['CONTENT'];
    $url=$rs_a[$i]['url'];
    $OVER_STATUS = $rs_a[$i]['OVER_STATUS'];
    $CONTENT = str_replace( "<", "&lt", $CONTENT );
    $CONTENT = str_replace( ">", "&gt", $CONTENT );
    $CONTENT = stripslashes( $CONTENT );
    $MANAGER_ID = $rs_a[$i]['MANAGER_ID'];
   	
    $MANAGER_NAME = "";
    if ( $MANAGER_ID != "" )
    {
    	$MANAGER_NAME="<br>安排人：".returntablefield("user", "user_id",$MANAGER_ID , "user_name");
        
    }
    if ( $OVER_STATUS == "" || $OVER_STATUS == "1" )
    {
        if ( $MANAGER_NAME == "" )
        {
            $OVER_STATUS1 = "<br><font color='#00AA00'><b>已完成</b></font>";
        }
        else
        {
            $OVER_STATUS1 = "<font color='#00AA00'><b>已完成</b></font>";
        }
    }
    else if ( $OVER_STATUS == "0" )
    {
        if ( $MANAGER_NAME == "" )
        {
            $OVER_STATUS1 = "<br><font color='#FF0000'><b>未完成</b></font>";
        }
        else
        {
            $OVER_STATUS1 = "<font color='#FF0000'><b>未完成</b></font>";
        }
    }
    $TITLE = substr( $CONTENT, 0, 10 );
    $CAL_TIME = substr( $CAL_TIME, 5, -3 );
    $END_TIME = substr( $END_TIME, 5, -3 );
}
echo "\r\n\r\n<head>\r\n<title>";
echo $TITLE;
echo " </title>\r\n<meta http-equiv=\"Content-Type\" content=\"text/html; charset=gb2312\">\r\n</head>\r\n\r\n<body bgcolor=\"#FFFFCC\" topmargin=\"5\">\r\n\r\n<div class=\"small\">\r\n";
echo $CAL_TIME;
echo " 至 ";
echo $END_TIME;
echo " ";
echo $OVER_STATUS1;
echo " ";
echo $MANAGER_NAME;
echo " \r\n<hr>\r\n\r\n";
if($url!="")
	echo "<a href='$url' target='_blank'>".$CONTENT."</a>";
else
	echo $CONTENT;
echo "</div>\r\n</body>\r\n</html>\r\n";
?>
