<?php
ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL);

// display warnings and errors
error_reporting(E_WARNING | E_ERROR);
require_once('lib.inc.php');

$GLOBAL_SESSION=returnsession();

$MenuArray[] = array('286','node_user','��������','wu_quyumingcheng_newai.php');
$MenuArray[] = array('286','node_user','��¥����','wu_daloumingcheng_newai.php');
$MenuArray[] = array('286','node_user','�����ṹ����','wu_buildingstructure_newai.php');
$MenuArray[] = array('287','node_user','��ҵ�Ѽ��㷽ʽ','wu_calculated_newai.php');
$MenuArray[] = array('286','node_user','������Ϣ','wu_chamber_newai.php');
$MenuArray[] = array('286','node_user','��ҵ���շѷ�ʽ','wu_chargestype_newai.php');
$MenuArray[] = array('286','node_user','�����տʽ','wu_collectiontype_newai.php');
$MenuArray[] = array('286','node_user','Ͷ�������Ϣ','wu_complaintstype_newai.php');
$MenuArray[] = array('286','node_user','��ҵ��������','wu_costtype_newai.php');
$MenuArray[] = array('286','node_user','�����¼�����','wu_eventlevelsecurity_newai.php');
$MenuArray[] = array('286','node_user','��Ԫ״̬��Ϣ','wu_housingstatus_newai.php');
$MenuArray[] = array('286','node_user','���ݽṹ��Ϣ','wu_housingstructure_newai.php');
$MenuArray[] = array('286','node_user','��¥������Ϣ','wu_housingtype_newai.php');
$MenuArray[] = array('286','node_user','��¥��;��Ϣ','wu_housinguse_newai.php');
$MenuArray[] = array('286','node_user','��ҵ�շѼ�����λ','wu_measurementunit_newai.php');
$MenuArray[] = array('286','node_user','������Ϣ','wu_morningway_newai.php');
$MenuArray[] = array('286','node_user','�����������Ϣ','wu_outofstoragetype_newai.php');
$MenuArray[] = array('286','node_user','���ͷ���','wu_phenotypic_newai.php');
$MenuArray[] = array('286','node_user','��̯��ʽ��Ϣ','wu_poolapproach_newai.php');
$MenuArray[] = array('286','node_user','��ҵ��������','wu_propertycostsname_newai.php');
$MenuArray[] = array('286','node_user','������Ŀ���','wu_securitytype_newai.php');
$MenuArray[] = array('286','node_user','����������Ϣ','wu_servicetype_newai.php');
$MenuArray[] = array('286','node_user','��Ԫ��;��Ϣ','wu_unituses_newai.php');
$MenuArray[] = array('286','node_user','�ͻ��Ա���Ϣ','wu_usersex_newai.php');
$MenuArray[] = array('286','node_user','����ʹ������','wu_usetype_newai.php');
$MenuArray[] = array('286','node_user','�Ƿ�����','wu_boolean_newai.php');
$MenuArray[] = array('286','node_user','��ҳ��������','wu_eachpage_newai.php');
$MenuArray[] = array('286','node_user','������Ϣ','wu_gongzhong_newai.php');
$MenuArray[] = array('286','node_user','����ְλ��Ϣ','wu_gongzuozhiwei_newai.php');
$MenuArray[] = array('286','node_user','����״����Ϣ','wu_hunyinzhuangkuang_newai.php');
$MenuArray[] = array('286','node_user','�Ļ��̶���Ϣ','wu_wenhuachengdu_newai.php');
$MenuArray[] = array('286','node_user','�ù�������Ϣ','wu_yonggongxingzhi_newai.php');
$MenuArray[] = array('286','node_user','��ְ״̬��Ϣ','wu_zaizhizhuangtai_newai.php');
$MenuArray[] = array('286','node_user','Ͷ��������Ϣ','wu_tousushouli_newai.php');
$MenuArray[] = array('286','node_user','����������','wu_xiaoqumingcheng_newai.php');




$DateY = Date("Y");
$DateM = Date("m");
$U = $_GET['PRIV_NO_FLAG'];

$DEPT_PARENT = $_GET['DEPT_PARENT'];



$UNIT_NAME = "�����ֵ����";

page_css("�����ֵ����");

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
   <span>�����ֵ����</span></li>\n
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