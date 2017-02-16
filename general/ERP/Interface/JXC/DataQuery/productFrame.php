<?php
ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL);

// display warnings and errors
error_reporting(E_WARNING | E_ERROR);
//######################教育组件-权限较验部分##########################

$tablename=$_GET['tablename'];
$deelname=$_GET['deelname'];

?>
<frameset rows="*"  cols="220,*" frameborder="0" border="0" framespacing="0" id="frame2">
       <frame name="left" scrolling="yes" resize src="inc_prod_page.php?rowid=<?php echo $_GET['rowid']?>&tablename=<?php echo $tablename?>" frameborder="0">
       <frame name="edu_main" scrolling="auto" src="inc_prod_List.php?rowid=<?php echo $_GET['rowid']?>&tablename=<?php echo $tablename?>&deelname=<?php echo $deelname?>" frameborder="0">
</frameset>
