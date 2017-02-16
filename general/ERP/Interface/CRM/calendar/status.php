<?php

ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL);
error_reporting(E_WARNING | E_ERROR);
require_once("lib.inc.php");
include_once( "utility_all.php" );
echo "\r\n<html>\r\n<head>\r\n<title>日程安排</title>\r\n<meta http-equiv=\"Content-Type\" content=\"text/html; charset=gb2312\">\r\n</head>\r\n\r\n<body class=\"bodycolor\" topmargin=\"5\">\r\n\r\n";
$query = "UPDATE calendar SET OVER_STATUS='".$OVER_STATUS."' WHERE USER_ID='{$LOGIN_USER_ID}' and CAL_ID='{$CAL_ID}'";
exequery( $connection, $query );
$REFER_URL = substr( $_SERVER['HTTP_REFERER'], strlen( "http://".$_SERVER['HTTP_HOST'] ) );
if ( strpos( $REFER_URL, "?" ) )
{
    $REFER_URL = substr( $REFER_URL, 0, strpos( $REFER_URL, "?" ) );
}
header( "location: ".$REFER_URL."?YEAR={$YEAR}&MONTH={$MONTH}&DAY={$DAY}" );
echo "\r\n</body>\r\n</html>";
?>
