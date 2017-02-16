<?php
ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL);

// display warnings and errors
error_reporting(E_WARNING | E_ERROR);
require_once('lib.inc.php');

$GLOBAL_SESSION=returnsession();

$MenuArray[] = array('286','node_user','区域名称','wu_quyumingcheng_newai.php');
$MenuArray[] = array('286','node_user','大楼名称','wu_daloumingcheng_newai.php');
$MenuArray[] = array('286','node_user','建筑结构资料','wu_buildingstructure_newai.php');
$MenuArray[] = array('287','node_user','物业费计算方式','wu_calculated_newai.php');
$MenuArray[] = array('286','node_user','房型信息','wu_chamber_newai.php');
$MenuArray[] = array('286','node_user','物业费收费方式','wu_chargestype_newai.php');
$MenuArray[] = array('286','node_user','汇总收款方式','wu_collectiontype_newai.php');
$MenuArray[] = array('286','node_user','投诉类别信息','wu_complaintstype_newai.php');
$MenuArray[] = array('286','node_user','物业费用类型','wu_costtype_newai.php');
$MenuArray[] = array('286','node_user','安保事件级别','wu_eventlevelsecurity_newai.php');
$MenuArray[] = array('286','node_user','单元状态信息','wu_housingstatus_newai.php');
$MenuArray[] = array('286','node_user','房屋结构信息','wu_housingstructure_newai.php');
$MenuArray[] = array('286','node_user','大楼类型信息','wu_housingtype_newai.php');
$MenuArray[] = array('286','node_user','大楼用途信息','wu_housinguse_newai.php');
$MenuArray[] = array('286','node_user','物业收费计量单位','wu_measurementunit_newai.php');
$MenuArray[] = array('286','node_user','朝向信息','wu_morningway_newai.php');
$MenuArray[] = array('286','node_user','出入库类型信息','wu_outofstoragetype_newai.php');
$MenuArray[] = array('286','node_user','表型分类','wu_phenotypic_newai.php');
$MenuArray[] = array('286','node_user','公摊方式信息','wu_poolapproach_newai.php');
$MenuArray[] = array('286','node_user','物业费用名称','wu_propertycostsname_newai.php');
$MenuArray[] = array('286','node_user','安保项目类别','wu_securitytype_newai.php');
$MenuArray[] = array('286','node_user','服务内容信息','wu_servicetype_newai.php');
$MenuArray[] = array('286','node_user','单元用途信息','wu_unituses_newai.php');
$MenuArray[] = array('286','node_user','客户性别信息','wu_usersex_newai.php');
$MenuArray[] = array('286','node_user','房屋使用类型','wu_usetype_newai.php');
$MenuArray[] = array('286','node_user','是否类型','wu_boolean_newai.php');
$MenuArray[] = array('286','node_user','分页条数设置','wu_eachpage_newai.php');
$MenuArray[] = array('286','node_user','工种信息','wu_gongzhong_newai.php');
$MenuArray[] = array('286','node_user','工作职位信息','wu_gongzuozhiwei_newai.php');
$MenuArray[] = array('286','node_user','婚姻状况信息','wu_hunyinzhuangkuang_newai.php');
$MenuArray[] = array('286','node_user','文化程度信息','wu_wenhuachengdu_newai.php');
$MenuArray[] = array('286','node_user','用工性质信息','wu_yonggongxingzhi_newai.php');
$MenuArray[] = array('286','node_user','在职状态信息','wu_zaizhizhuangtai_newai.php');
$MenuArray[] = array('286','node_user','投诉受理信息','wu_tousushouli_newai.php');
$MenuArray[] = array('286','node_user','管理区名称','wu_xiaoqumingcheng_newai.php');




$DateY = Date("Y");
$DateM = Date("m");
$U = $_GET['PRIV_NO_FLAG'];

$DEPT_PARENT = $_GET['DEPT_PARENT'];



$UNIT_NAME = "数据字典管理";

page_css("数据字典管理");

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
   <span>数据字典管理</span></li>\n
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