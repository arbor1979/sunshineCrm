<?php

@ini_set('display_errors', 1);
@ini_set('error_reporting', E_ALL);
@error_reporting(E_WARNING | E_ERROR);
@ini_set("default_charset","gb2312");
if (function_exists( "memory_get_usage"))			{
	ini_set("memory_limit","1024M");
	ini_set("max_execution_time",1200);
}

function OpenConnection( )
{
    global $connection;
    global $MYSQL_SERVER;
    global $MYSQL_USER;
    global $MYSQL_PASS;
    global $MYSQL_DB;
    if ( !$connection )
    {
        $C = @mysql_pconnect( $MYSQL_SERVER, $MYSQL_USER, $MYSQL_PASS, MYSQL_CLIENT_COMPRESS );
    }
    else
    {
        $C = $connection;
    }
    mysql_query( "SET CHARACTER SET GBK", $C );
    if ( !$C )
    {
        printerror( "不能连接到MySQL数据库" );
        exit( );
    }
    $result = mysql_select_db( $MYSQL_DB, $C );
    if ( !$result )
    {
        printerror( "数据库 ".$MYSQL_DB."不存在" );
    }
    return $C;
}

function exequery( $C, $Q )
{
    if ( stristr( $Q, " union select" ) )
    {
        exit( );
    }
    $cursor = mysql_query( $Q, $C );
    if ( !$cursor )
    {
        printerror( "<b>SQL语句:</b> ".$Q );
    }
    return $cursor;
}

function PrintError( $MSG )
{
    echo "<fieldset>  <legend><b>错误</b></legend>";
    echo "<b>#".mysql_errno( ).":</b> ".mysql_error( )."<br>";
    global $SCRIPT_FILENAME;
    echo $MSG."<br>";
    echo "<b>文件:</b> ".$SCRIPT_FILENAME;
    if ( mysql_errno( ) == 1030 )
    {
        echo "<br>数据库错误。";
    }
    echo "</fieldset>";
}
include_once( "../../../config.inc.php" );

$connection = openconnection( );


function Message( $TITLE, $CONTENT, $STYLE = "" )
{
    $WIDTH = strlen( $CONTENT ) * 10 + 140;
    $WIDTH = 500 < $WIDTH ? 500 : $WIDTH;
    if ( $STYLE == "blank" )
    {
        $WIDTH -= 70;
    }
    if ( $STYLE == "" )
    {
        if ( $TITLE == "错误" )
        {
            $STYLE = "error";
        }
        else if ( $TITLE == "警告" )
        {
            $STYLE = "warning";
        }
        else if ( $TITLE == "停止" )
        {
            $STYLE = "stop";
        }
        else if ( $TITLE == "禁止" )
        {
            $STYLE = "forbidden";
        }
        else if ( $TITLE == "帮助" )
        {
            $STYLE = "help";
        }
        else
        {
            $STYLE = "info";
        }
    }
    echo "<table class=\"MessageBox\" align=\"center\" width=\"";
    echo $WIDTH;
    echo "\">\r\n  <tr>\r\n    <td class=\"msg ";
    echo $STYLE;
    echo "\">\r\n";
    if ( $TITLE != "" )
    {
        echo "      <h4 class=\"title\">";
        echo $TITLE;
        echo "</h4>\r\n";
    }
    echo "      <div class=\"content\">";
    echo $CONTENT;
    echo "</div>\r\n    </td>\r\n  </tr>\r\n</table>\r\n";
}


//重新初始化变更,应对REGISTER_GLOBALS为OFF时的情况
$_GETKeyArray = @array_keys($_GET);
for($i=0;$i<sizeof($_GETKeyArray);$i++)			{
	$_GETKey	= $_GETKeyArray[$i];
	$$_GETKey	= $_GET[$_GETKey];
}

$_POSTKeyArray = @array_keys($_POST);
for($i=0;$i<sizeof($_POSTKeyArray);$i++)			{
	$_POSTKey	= $_POSTKeyArray[$i];
	$$_POSTKey	= $_POST[$_POSTKey];
}


$_COOLIESKeyArray = @array_keys($_COOLIES);
for($i=0;$i<sizeof($_COOLIESKeyArray);$i++)			{
	$_COOLIESKey	= $_COOLIESKeyArray[$i];
	$$_COOLIESKey	= $_COOLIES[$_COOLIESKey];
}

$_SESSIONKeyArray = @array_keys($_SESSION);
for($i=0;$i<sizeof($_SESSIONKeyArray);$i++)			{
	$_SESSIONKey	= $_SESSIONKeyArray[$i];
	$$_SESSIONKey	= $_SESSION[$_SESSIONKey];
}


?>
