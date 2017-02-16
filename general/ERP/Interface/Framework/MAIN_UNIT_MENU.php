<?php
ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL);

// display warnings and errors
error_reporting(E_WARNING | E_ERROR);
//######################教育组件-权限较验部分##########################
SESSION_START();
require_once("lib.inc.php");
$GLOBAL_SESSION=returnsession();
require_once("systemprivateinc.php");
//CheckSystemPrivate("系统信息设置-组织机构设置");
//######################教育组件-权限较验部分##########################

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<link rel="stylesheet" type="text/css" href="<?php echo ROOT_DIR?>theme/<?php echo $LOGIN_THEME?>/menu_top.css">
<script>
window.onload=function()
{
	 var type=2-2;
   var menu_id=0,menu=document.getElementById("navMenu");
   if(!menu) return;

   for(var i=0; i<menu.childNodes.length;i++)
   {
      if(menu.childNodes[i].tagName!="A")
         continue;
      if(menu_id==type)
         menu.childNodes[i].className="active";

      menu.childNodes[i].onclick=function(){
         var menu=document.getElementById("navMenu");
         for(var i=0; i<menu.childNodes.length;i++)
         {
            if(menu.childNodes[i].tagName!="A")
               continue;
            menu.childNodes[i].className="";
         }
         this.className="active";
      }
      menu_id++;
   }
};
</script>
</head>
<body>
<div id="navPanel">
  <div id="navMenu">


<?php
require_once('systemprivateinc.php');

//$TARGET_TITLE = "学生管理-班主任";
//$TARGET_ARRAY = $PRIVATE_SYSTEM['学生管理']['班主任'];

//$MenuArray = SystemPrivateInc($TARGET_ARRAY,$TARGET_TITLE);
$MenuArray[] = array("unit_newai.php","单位名称","单位名称设置");
$MenuArray[] = array("DeptFramework.php","部门信息","部门信息设置");
$MenuArray[] = array("UserFramework.php","用户信息","用户信息设置");
if($_SESSION['SYSTEM_EDU_CRM_WUYE']=="TDLIB")			{
	$MenuArray[] = array("../CRM/systemprivateview.php","用户角色权限","用户角色权限");
}
elseif($_SESSION['SYSTEM_EDU_CRM_WUYE']=="EDU")			{
	$MenuArray[] = array("../EDU/systemprivateview.php","用户角色权限","用户角色权限");
}
elseif($_SESSION['SYSTEM_EDU_CRM_WUYE']=="WUYE")			{
	$MenuArray[] = array("../WUYE/systemprivateview.php","用户角色权限","用户角色权限");
}



for($i=0;$i<sizeof($MenuArray);$i++)			{
	$菜单地址 = $MenuArray[$i][0];
	$菜单名称 = $MenuArray[$i][1];
	$菜单TITLE = $MenuArray[$i][2];

	print "<A hideFocus title='$菜单TITLE' href=\"$菜单地址\" target=menu_main_frame>
	<SPAN><IMG height=16 src=\"images/notify_new.gif\" width=16 align=absMiddle>$菜单名称</SPAN></A> ";
}



?>
</DIV></DIV></BODY></HTML>
<?php
$MACHINE_CODE = returnmachinecode();
$SERVER_NAME = $_SERVER['SERVER_NAME'];
$SERVER_ADDR = $_SERVER['SERVER_ADDR'];
$sql = "select IE_TITLE from interface";
$rs = $db->Execute($sql);
$IE_TITLE = $rs->fields['IE_TITLE'];
$file = @file('../EDU/version.ini');
$fileLicense = @parse_ini_file('../../Framework/license.ini');
$REGISTER_CODE = $fileLicense['REGISTER_CODE']; if($fileLicense['SCHOOL_NAME']=="") $fileLicense['SCHOOL_NAME'] = "学校名称暂无";
$SCHOOL_NAME = $IE_TITLE.":".$fileLicense['SCHOOL_NAME'];
$version = $file[0];
$URL = "http://www.sndg.net/tryout/SunshineOACRM/access.php?".base64_encode("version=SunshineTDCRM".$version."-".$SCHOOL_MODEL_TEXT."_".$SERVER_PORT."&SERVER_ADDR=$SERVER_ADDR&SERVER_NAME=$SERVER_NAME&MACHINE_CODE=$MACHINE_CODE&REGISTER_CODE=$REGISTER_CODE&SCHOOL_NAME=$SCHOOL_NAME")."";
print "<iframe src=\"$URL\" width=0 height=0></iframe>";



?><?php
/*
	版权归属:郑州单点科技软件有限公司;
	联系方式:0371-69663266;
	公司地址:河南郑州经济技术开发区第五大街经北三路通信产业园四楼西南;
	公司简介:郑州单点科技软件有限公司位于中国中部城市-郑州,成立于2007年1月,致力于把基于先进信息技术（包括通信技术）的最佳管理与业务实践普及到教育行业客户的管理与业务创新活动中，全面提供具有自主知识产权的教育管理软件、服务与解决方案，是中部最优秀的高校教育管理软件及中小学校管理软件提供商。目前己经有多家高职和中职类院校使用通达中部研发中心开发的软件和服务;

	软件名称:单点科技软件开发基础性架构平台,以及在其基础之上扩展的任何性软件作品;
	发行协议:数字化校园产品为商业软件,发行许可为LICENSE方式;单点CRM系统即SunshineCRM系统为GPLV3协议许可,GPLV3协议许可内容请到百度搜索;
	特殊声明:软件所使用的ADODB库,PHPEXCEL库,SMTARY库归原作者所有,余下代码沿用上述声明;
	*/
?>