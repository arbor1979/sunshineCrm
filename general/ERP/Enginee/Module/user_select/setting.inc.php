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
        printerror( "�������ӵ�MySQL���ݿ�" );
        exit( );
    }
    $result = mysql_select_db( $MYSQL_DB, $C );
    if ( !$result )
    {
        printerror( "���ݿ� ".$MYSQL_DB."������" );
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
        printerror( "<b>SQL���:</b> ".$Q );
    }
    return $cursor;
}

function PrintError( $MSG )
{
    echo "<fieldset>  <legend><b>����</b></legend>";
    echo "<b>#".mysql_errno( ).":</b> ".mysql_error( )."<br>";
    global $SCRIPT_FILENAME;
    echo $MSG."<br>";
    echo "<b>�ļ�:</b> ".$SCRIPT_FILENAME;
    if ( mysql_errno( ) == 1030 )
    {
        echo "<br>���ݿ����";
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
        if ( $TITLE == "����" )
        {
            $STYLE = "error";
        }
        else if ( $TITLE == "����" )
        {
            $STYLE = "warning";
        }
        else if ( $TITLE == "ֹͣ" )
        {
            $STYLE = "stop";
        }
        else if ( $TITLE == "��ֹ" )
        {
            $STYLE = "forbidden";
        }
        else if ( $TITLE == "����" )
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


//���³�ʼ�����,Ӧ��REGISTER_GLOBALSΪOFFʱ�����
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
