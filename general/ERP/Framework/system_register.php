<?php
ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL);

// display warnings and errors
error_reporting(E_WARNING | E_ERROR);

?><?php
require_once('lib.inc.php');
$GLOBAL_SESSION=returnsession();
$common_html=returnsystemlang('common_html');
$html_etc=returnsystemlang('SERVERINFOR');
//SYSTEM_PRIV_CONTROL_MYDESKTOP("system_register.php","Value");

page_css('System Register');
//系统注册说明
print "<BR>";
$MACHINE_CODE = returnmachinecode();
table_begin();
print "<tr><td nowrap class=\"TableHeader\" colspan=2 width=20%>系统注册信息(System register information)</td></tr>";
table_end();
?>