<?php
ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL);

// display warnings and errors
error_reporting(E_WARNING | E_ERROR);

//$SYSTEM_MODE = 1 ;

//other dir file
require_once('../../config.inc.php');
require_once('../../adodb/adodb.inc.php');

require_once('dbname.inc.php');
require_once('../../setting.inc.php');
require_once('../../adodb/session/adodb-session2.php');


require_once('../../Enginee/lib/init.php');
require_once('../../Enginee/lib/html_element.php');
require_once('../../Enginee/lib/function_system.php');
require_once('../../Enginee/lib/select_menu.php');
require_once('../../Enginee/lib/select_menu_two.php');
require_once('../../Enginee/lib/select_menu_six.php');
require_once('../../Enginee/lib/select_menu_select_input.php');
require_once('../../Enginee/lib/getpagedata.php');
require_once('../../Enginee/lib/getpagedata_new.php');
require_once('../../Enginee/lib/other.php');
require_once('../../Enginee/lib/fzhu.php');
require_once('../../Enginee/lib/select_menu_countryCode.php');
//root file
require_once('./cache.inc.php');
require_once('lib.function.inc.php');

?>