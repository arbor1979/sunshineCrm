<?php
ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL);

// display warnings and errors
error_reporting(E_WARNING | E_ERROR);


//$SYSTEM_MODE = 1 ;

$file_ini = array();
if($parse_filename=='')				{
	$filepath_system="Model/".$filetablename."_newai.ini";
	if(file_exists($filepath_system))
		$file_ini=parse_ini_file($filepath_system,true);
}
else	{
	$filepath_system="Model/".$parse_filename."_newai.ini";
	if(file_exists($filepath_system))
		$file_ini=parse_ini_file($filepath_system,true);
}

require_once('lib.inc.php');
require_once('../../Enginee/newai_control.php');
require_once('../../Enginee/newai.php');



?>