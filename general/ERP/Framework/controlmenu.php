<?php
/*
版权归属:郑州单点科技软件有限公司;
联系方式:0371-69663266;
公司地址:河南郑州经济技术开发区第五大街经北三路通信产业园四楼西南;
公司简介:郑州单点科技软件有限公司位于中国中部城市-郑州,成立于2007年1月,致力于把基于先进信息技术（包括通信技术）的最佳管理与业务实践普及到教育行业客户的管理与业务创新活动中，全面提供具有自主知识产权的教育管理软件、服务与解决方案，是中部最优秀的高校教育管理软件及中小学校管理软件提供商。目前己经有多家高职和中职类院校使用通达中部研发中心开发的软件和服务;

软件名称:单点科技软件开发基础性架构平台,以及在其基础之上扩展的任何性软件作品;
发行协议:数字化校园产品为商业软件,发行许可为LICENSE方式;单点CRM系统即SunshineCRM系统为GPLV3协议许可,GPLV3协议许可内容请到百度搜索;
特殊声明:软件所使用的ADODB库,PHPEXCEL库,SMTARY库归原作者所有,余下代码沿用上述声明;
*/



require_once( "lib.inc.php" );
$sessionkey = returnsesskey( );
$GLOBAL_SESSION = returnsession( );

$LOGIN_THEME = $_SESSION['LOGIN_THEME'];
$LOGIN_THEME == "" ? ( $LOGIN_THEME = $SYSTEM_THEME ) : "";
$MENU_HIDE = $_SESSION[$SUNSHINE_USER_MENU_HIDE_VAR];
?>
<html>
<head>
<title>菜单显隐控制条</title>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">

<script language="JavaScript">
<?php 
if($MENU_HIDE=="1")
	print "var AUTO_HIDE_MENU=1;";
else
	print "var AUTO_HIDE_MENU=0;";
?>


var arrowpic1="../theme/3/images/control-button.gif";
var arrowpic2="../theme/3/images/control-button.gif"

//--------------------- 状态初始 ----------------------
var MENU_SWITCH;
function panel_menu_open()
{
 MENU_SWITCH=AUTO_HIDE_MENU;
 panel_menu_ctrl();
}


//------------------ 面板状态切换 ---------------------
function panel_menu_ctrl()
{
   if(MENU_SWITCH==0)
   {
      parent.document.getElementById("frame2").cols="7,190,5,9,*,0";
      MENU_SWITCH=1;
      arrow.src=arrowpic1;
   }
   else
   {
      parent.document.getElementById("frame2").cols="0,0,0,9,*,0";
      MENU_SWITCH=0;
      arrow.src=arrowpic2;
   }
}


//------------------ 面板状态切换 ---------------------
function enter_menu_ctrl()
{
   if(AUTO_HIDE_MENU==1)    // 判断面板是否允许自动隐藏
   {
     if(MENU_SWITCH==0)
     {
        parent.frame2.cols="7,190,5,9,*,0";
        MENU_SWITCH=1;
        arrow.src=arrowpic1;
     }
     else
     {
        parent.frame2.cols="0,0,0,9,*,0";
        MENU_SWITCH=0;
        arrow.src=arrowpic2;
     }
   }
}


//--------------- 上下框架页显示控制 -----------------
var DB_VIEW=0;                          // 状态值初始
var DB_rows=parent.parent.document.getElementById("frame1").rows;  // 保存原始值
function DB_Display() 
{
   if (DB_VIEW==0)     // 未隐藏
   {
    parent.parent.document.getElementById("frame1").rows="0,0,*,0";
	DB_VIEW=1;
   }
   else                // 已隐藏
   {
    parent.parent.document.getElementById("frame1").rows=DB_rows;   
    DB_VIEW=0;
   }
}




</script>


</head>

<body topmargin="0" leftmargin="0" onselectstart="return false" onload="panel_menu_open()" onContextMenu="DB_Display();return false;">

<table style="background:url(../theme/3/images/table-bg.jpg) top repeat-x;" width="9" height="100%" border="0" cellpadding="0" cellspacing="0"  onMouseMove="enter_menu_ctrl()" >
<tr style="cursor:pointer" onclick="panel_menu_ctrl()"> 
    <td style="background:url(../theme/3/images/control-bg.gif) repeat-y;">
	<img id="arrow" src="../theme/3/images/control-button.gif" width="9" height="47" GALLERYIMG="no"  alt="左键点击控制菜单栏面板，右键点击控制上下状态栏。"/>
	</td>
  </tr>
</table>


</body>
</html>

