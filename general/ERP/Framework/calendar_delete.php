<?php
ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL);

// display warnings and errors
error_reporting(E_WARNING | E_ERROR);


require_once('lib.inc.php');
$GLOBAL_SESSION=returnsession();

$LOGIN_USER_ID = $_SESSION['LOGIN_USER_ID'];

$CAL_ID = $_GET['CAL_ID'];
$GOBACK = $_GET['GOBACK'];
$YEAR	= $_GET['YEAR'];
$MONTH	= $_GET['MONTH'];
$DAY	= $_GET['DAY'];

$query = "delete from calendar where USER_ID='".$LOGIN_USER_ID."' and CAL_ID='{$CAL_ID}'";
$db->Execute($query);


print "<META HTTP-EQUIV=REFRESH CONTENT='0;URL={$GOBACK}.php?YEAR={$YEAR}&MONTH={$MONTH}&DAY={$DAY}'>\n";
?>
