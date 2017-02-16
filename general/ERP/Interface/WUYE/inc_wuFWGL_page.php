<?php
ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL);

// display warnings and errors
error_reporting(E_WARNING | E_ERROR);
require_once('lib.inc.php');

$GLOBAL_SESSION=returnsession();


$MenuArray[] = array('286','node_user','报修信息','my1_wu_maintenancemanagement_newai.php');
$MenuArray[] = array('287','node_user','报修受理','my2_wu_maintenancemanagement_newai.php');
$MenuArray[] = array('286','node_user','修复确认','my3_wu_maintenancemanagement_newai.php');
$MenuArray[] = array('286','node_user','用料登记','my4_wu_maintenancemanagement_newai.php');
$MenuArray[] = array('286','node_user','费用结算','my5_wu_maintenancemanagement_newai.php');

$MenuArray[] = array('286','node_user','服务评价','my6_wu_maintenancemanagement_newai.php');

//$MenuArray[] = array('286','node_user','服务评价1','wu_pingjia_newai.php');
$MenuArray[] = array('286','node_user','类型设计','wu_pingjialeixing_newai.php');




$DateY = Date("Y");
$DateM = Date("m");
$U = $_GET['PRIV_NO_FLAG'];

$DEPT_PARENT = $_GET['DEPT_PARENT'];



$UNIT_NAME = "维修服务管理";

page_css("维修服务管理");

print "
<link rel=\"stylesheet\" type=\"text/css\" href=\"".ROOT_DIR."theme/$LOGIN_THEME/menu_left.css\" />\n
<script language=\"JavaScript\" src=\"".ROOT_DIR."inc/js/menu_left.js\"></script>\n
<script language=\"JavaScript\" src=\"".ROOT_DIR."inc/js/hover_tr.js\"></script>\n
";

print "\n<style>\nli span{\n
  background: url(\"".ROOT_DIR."theme/$LOGIN_THEME/arrow_d.gif\") no-repeat left;\n
  display:block;\n
  padding-top:3px;\n
  padding-left:16px;\n
}</style>\n";
print "
<ul>\n
   <li>\n
   <span>维修服务管理</span></li>\n
   <div id=module_1 class=moduleContainer style=\"display:;\">\n
	   <table class=\"TableBlock trHover\" width=100% align=center>\n
	   ";

for($i=0;$i<sizeof($MenuArray);$i++){
	$菜单代码 = $MenuArray[$i][1];
	$菜单名称 = $MenuArray[$i][2];
	$菜单地址 = $MenuArray[$i][3];
	$returnPrivMenu = returnPrivMenu($菜单名称);
	if($returnPrivMenu) {
		print "
		 <tr class=TableData align=left><td nowrap onclick=\"parent.edu_main.location='".$菜单地址."'\" style=\"cursor:pointer;\">&nbsp;&nbsp;$菜单名称</td>
		   </tr>
		   ";
	}
}
print "</table>
       </div>";
print "</ul>";

?>