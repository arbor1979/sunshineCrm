<?php
ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL);
// display warnings and errors
error_reporting(E_WARNING | E_ERROR);


require_once("lib.inc.php");

$GLOBAL_SESSION=returnsession();
$IsWin = IsWin();
$fileName = "../../Framework/inc_shixun_page.php?FILENAME=edu_shixunguanli_newai.php&DIR=HOUQIN";
 ?>
<HEAD><TITLE>สตัตนÜภํ</TITLE>

<frameset rows="*"  cols="220,*" frameborder="0" border="0" framespacing="0" id="frame2">
       <frame name="left" scrolling="auto" resize src="<?php echo $fileName?>" frameborder="0">
       <frame name="edu_main" scrolling="auto" src="edu_shixunguanli_newai.php" frameborder="0">
</frameset>