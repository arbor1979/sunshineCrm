<?php
ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL);

// display warnings and errors
error_reporting(E_WARNING | E_ERROR);
require_once('lib.inc.php');

$GLOBAL_SESSION=returnsession();


$MenuArray[] = array('286','node_user','Ͷ����Ϣ','wu_usercomplaints_newai.php');
$MenuArray[] = array('287','node_user','Ͷ������','wu1_usercomplaints_newai.php');
$MenuArray[] = array('286','node_user','������','wu2_usercomplaints_newai.php');
$MenuArray[] = array('286','node_user','Ͷ�߻���','wu3_usercomplaints_newai.php');





$DateY = Date("Y");
$DateM = Date("m");
$U = $_GET['PRIV_NO_FLAG'];

$DEPT_PARENT = $_GET['DEPT_PARENT'];



$UNIT_NAME = "Ͷ�߹���";

page_css("Ͷ�߹���");

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
   <span>Ͷ�߹���</span></li>\n
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