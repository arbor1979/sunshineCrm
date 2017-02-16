<?php
ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL);

// display warnings and errors
error_reporting(E_WARNING | E_ERROR);


require_once('lib.inc.php');
$GLOBAL_SESSION=returnsession();
$common_html=returnsystemlang('common_html');
$html_etc=returnsystemlang('SERVERINFOR');

require_once('about.php');

?>