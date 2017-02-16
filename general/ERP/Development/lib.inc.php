<?php
//other dir file

	
require_once('../config.inc.php');
require_once('../adodb/adodb.inc.php');

if(is_file('config.php'))
	require_once('config.php');

require_once('../setting.inc.php');

require_once('../adodb/session/adodb-session2.php');
require_once('../Enginee/lib/init.php');
require_once('../Enginee/lib/html_element.php');
require_once('../Enginee/lib/function_system.php');
require_once('../Enginee/lib/select_menu.php');
require_once('../Enginee/lib/select_menu_two.php');
require_once('../Enginee/lib/select_menu.php');
require_once('../Enginee/lib/getpagedata.php');
require_once('../Enginee/lib/getpagedata_new.php');
require_once('../Enginee/lib/other.php');

require_once('function.php');
require_once('function_file.php');

//root file
require_once('./cache.inc.php');
session_start();

?>