<?php
ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL);

// display warnings and errors
error_reporting(E_WARNING | E_ERROR);
require_once('lib.inc.php');

$GLOBAL_SESSION=returnsession();


$MenuArray[] = array('286','node_user','������Ϣ','my1_wu_maintenancemanagement_newai.php');
$MenuArray[] = array('287','node_user','��������','my2_wu_maintenancemanagement_newai.php');
$MenuArray[] = array('286','node_user','�޸�ȷ��','my3_wu_maintenancemanagement_newai.php');
$MenuArray[] = array('286','node_user','���ϵǼ�','my4_wu_maintenancemanagement_newai.php');
$MenuArray[] = array('286','node_user','���ý���','my5_wu_maintenancemanagement_newai.php');

$MenuArray[] = array('286','node_user','��������','my6_wu_maintenancemanagement_newai.php');

//$MenuArray[] = array('286','node_user','��������1','wu_pingjia_newai.php');
$MenuArray[] = array('286','node_user','�������','wu_pingjialeixing_newai.php');




$DateY = Date("Y");
$DateM = Date("m");
$U = $_GET['PRIV_NO_FLAG'];

$DEPT_PARENT = $_GET['DEPT_PARENT'];



$UNIT_NAME = "ά�޷������";

page_css("ά�޷������");

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
   <span>ά�޷������</span></li>\n
   <div id=module_1 class=moduleContainer style=\"display:;\">\n
	   <table class=\"TableBlock trHover\" width=100% align=center>\n
	   ";

for($i=0;$i<sizeof($MenuArray);$i++){
	$�˵����� = $MenuArray[$i][1];
	$�˵����� = $MenuArray[$i][2];
	$�˵���ַ = $MenuArray[$i][3];
	$returnPrivMenu = returnPrivMenu($�˵�����);
	if($returnPrivMenu) {
		print "
		 <tr class=TableData align=left><td nowrap onclick=\"parent.edu_main.location='".$�˵���ַ."'\" style=\"cursor:pointer;\">&nbsp;&nbsp;$�˵�����</td>
		   </tr>
		   ";
	}
}
print "</table>
       </div>";
print "</ul>";

?>