<?php
session_start();
include_once( "../user_select/setting.inc.php" );

//ob_end_clean( );

if ( $TO_ID == "" || $TO_ID == "undefined" )
{
    $TO_ID = "TO_ID";
    $TO_NAME = "TO_NAME";
}

if ( $FORM_NAME == "" || $FORM_NAME == "undefined" )
{
    $FORM_NAME = "form1";
}

echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">\r\n<html xmlns=\"http://www.w3.org/1999/xhtml\">\r\n<head>\r\n<title></title>\r\n<meta http-equiv=\"Content-Type\" content=\"text/html; charset=gb2312\">\r\n<link rel=\"stylesheet\" type=\"text/css\" href=\"".ROOT_DIR."theme/";
echo $LOGIN_THEME;
echo "/style.css\" />\r\n<link rel=\"stylesheet\" type=\"text/css\" href=\"".ROOT_DIR."general/ERP/theme/";
echo $LOGIN_THEME;
echo "/menu_left.css\" />\r\n<script src=\"utility.js\"></script>\r\n<script src=\"hover_tr.js\"></script>\r\n
<script language=\"JavaScript\">\r\n 
var CUR_ID=\"2\";\r\n
function clickMenu(ID)\r\n
{\r\n    
	var el=document.getElementById(\"module_\"+CUR_ID);\r\n    
	var link=document.getElementById(\"link_\"+CUR_ID);\r\n    
	if(ID==CUR_ID)\r\n    
	{\r\n       
		if(el.style.display==\"none\")\r\n       
		{\r\n           
			el.style.display='';\r\n           
			link.className=\"active\";\r\n       
		}\r\n       
		else\r\n       
		{\r\n           
			el.style.display=\"none\";\r\n           
			link.className=\"\";\r\n       
		}\r\n    
	}\r\n    
	else\r\n    
	{\r\n       
		el.style.display=\"none\";\r\n       
		link.className=\"\";\r\n       
		document.getElementById(\"module_\"+ID).style.display=\"\";\r\n       
		document.getElementById(\"link_\"+ID).className=\"active\";\r\n    
	}\r\n\r\n    
	CUR_ID=ID;\r\n
}\r\n
function ShowSelected()\r\n
{\r\n   
	var TO_ID_STR = parent.dialogArguments.";
echo $FORM_NAME;
echo ".";
echo $TO_ID;
echo ".value;\r\n   var TO_NAME_STR = parent.dialogArguments.";
echo $FORM_NAME;
echo ".";
echo $TO_NAME;
echo ".value;\r\n   parent.user.location=\"selected.php?TO_ID=";
echo $TO_ID;
echo "&TO_NAME=";
echo $TO_NAME;
echo "&FORM_NAME=";
echo $FORM_NAME;
echo "&TO_ID_STR=\"+URLSpecialChars(TO_ID_STR)+\"&TO_NAME_STR=\"+URLSpecialChars(TO_NAME_STR);\r\n}\r\nvar interval=null,key=\"\";\r\n
var interval=null;

function CheckSend()\r\n
{\r\n\t
	var KWORD=document.getElementById('kword');
	if(KWORD.value==\"按用户名或姓名搜索...\")\r\n\t  
		 KWORD.value=\"\";\r\n  
	if(KWORD.value==\"\" && document.getElementById('search_icon').src.indexOf(\"../../../Framework/images/quicksearch.gif\")==-1)\r\n\t
	{\r\n\t   
		document.getElementById('search_icon').src=\"../../../Framework/images/quicksearch.gif\";\r\n\t
	}\r\n\t
	if(key!=KWORD.value && KWORD.value!=\"\")\r\n\t
	{\r\n     
		key=KWORD.value;\r\n\t   
		parent.user.location=\"query.php?TO_ID=";
echo $TO_ID;
echo "&TO_NAME=";
echo $TO_NAME;
echo "&FORM_NAME=";
echo $FORM_NAME;
echo "&USER_NAME=\"+KWORD.value;\r\n\t   
		if(document.getElementById('search_icon').src.indexOf(\"../../../Framework/images/quicksearch.gif\")>=0)\r\n\t  
		 {\r\n\t   \t   
		 	document.getElementById('search_icon').src=\"../../../Framework/images/closesearch.gif\";\r\n\t   \t   
		 	document.getElementById('search_icon').title=\"清除关键字\";\r\n\t   \t   
		 	document.getElementById('search_icon').onclick=function(){KWORD.value='按用户名或姓名搜索...';document.getElementById('search_icon').src=\"../../../Framework/images/quicksearch.gif\";document.getElementById('search_icon').title=\"\";document.getElementById('search_icon').onclick=null;};\r\n\t   
	 	}\r\n  
	}\r\n
	interval=setTimeout(CheckSend,100);
	
}\r\n
function click_node(the_id,checked,para_id,para_value)\r\n
{\r\n\t
parent.user.location=\"children.php?DEPT_ID=\"+the_id+\"&CHECKED=\"+checked+\"&FORM_NAME=\"+$FORM_NAME;\r\n
}\r\n
</script>\r\n</head>\r\n\r\n
<body class=\"bodycolor\"  topmargin=\"1\" leftmargin=\"0\">\r\n<div style=\"border:1px solid #000000;margin-left:2px;background:#FFFFFF;\">\r\n  
<input type=\"text\" id=\"kword\" name=\"KWORD\" value=\"按用户名或姓名搜索...\" onfocus=\"interval=setTimeout(CheckSend,100);\" onblur=\"clearTimeout(interval);if(KWORD.value=='')KWORD.value='按用户名或姓名搜索...';\" class=\"SmallInput\" style=\"border:0px; color:#A0A0A0;width:145px;\"><img id=\"search_icon\" src=\"../../../Framework/images/quicksearch.gif\" align=absmiddle style=\"cursor:pointer;\">\r\n</div>\r\n<ul>\r\n<!--============================ 部门 =======================================-->\r\n  <li><a href=\"javascript:ShowSelected();\" id=\"link_1\"><span>已选人员</span></a></li>\r\n  <li><a href=\"javascript:clickMenu('2');\" id=\"link_2\" class=\"active\" title=\"点击伸缩列表\"><span>按部门选择</span></a></li>\r\n  <div id=\"module_2\"  class=\"moduleContainer treeList\" >\r\n";
$PARA_URL = "user.php";
$PARA_TARGET = "user";
$PARA_ID = "TO_ID";
$PARA_VALUE = $TO_ID.".TO_NAME=".$TO_NAME.".FORM_NAME=".$FORM_NAME.".MODULE_ID=".$MODULE_ID;
$PRIV_NO_FLAG = 0;
$xname = "user_select";
$showButton = 1;
include_once( "treelist.php" );
echo "  </div>\r\n<!--============================ 角色 =======================================-->\r\n  <li><a href=\"javascript:clickMenu('3');\" id=\"link_3\" title=\"点击伸缩列表\"><span>按角色选择</span></a></li>\r\n  <div id=\"module_3\" class=\"moduleContainer\" style=\"display:none\">\r\n    <table class=\"TableBlock trHover\" width=\"100%\" align=\"center\">\r\n";
$query = "SELECT * from user_priv order by user_priv ";
$cursor = exequery( $connection, $query );
$PRIV_COUNT = 0;
while ( $ROW = mysql_fetch_array( $cursor ) )
{
    ++$PRIV_COUNT;
    $USER_PRIV = $ROW['USER_PRIV'];
    $PRIV_NAME = $ROW['PRIV_NAME'];
    echo "    <tr class=\"TableData\">\r\n      <td align=\"center\" onclick=\"javascript:parent.user.location='user.php?TO_ID=";
    echo $TO_ID;
    echo "&TO_NAME=";
    echo $TO_NAME;
    echo "&FORM_NAME=";
    echo $FORM_NAME;
    echo "&USER_PRIV=";
    echo $USER_PRIV;
    echo "&POST_PRIV=";
    echo $POST_PRIV;
    echo "&POST_DEPT=";
    echo $POST_DEPT;
    echo "&MANAGE_FLAG=";
    echo $MANAGE_FLAG;
    echo "&MODULE_ID=";
    echo $MODULE_ID;
    echo "';\" style=\"cursor:pointer\">";
    echo $PRIV_NAME;
    echo "</td>\r\n    </tr>\r\n";
}
if ( $PRIV_COUNT == 0 )
{
    message( "", "没有定义角色", "blank" );
}
echo "    </table>\r\n  </div>\r\n\r\n";
exit;
print "<!--============================ 自定义组 =======================================-->\r\n  <li><a href=\"javascript:clickMenu('4');\" id=\"link_4\" title=\"点击伸缩列表\"><span>自定义组</span></a></li>\r\n  <div id=\"module_4\" class=\"moduleContainer\" style=\"display:none\">\r\n    <table class=\"TableBlock trHover\" width=\"100%\" align=\"center\">\r\n";
$query = "SELECT * from user_group where USER_ID='".$LOGIN_USER_ID."' order by ORDER_NO ";
$cursor = exequery( $connection, $query );
$GROUP_COUNT = 0;
while ( $ROW = mysql_fetch_array( $cursor ) )
{
    ++$GROUP_COUNT;
    $GROUP_ID = $ROW['GROUP_ID'];
    $GROUP_NAME = $ROW['GROUP_NAME'];
    if ( $GROUP_COUNT == 1 )
    {
        echo "    <tr class=\"TableControl\">\r\n      <td align=\"center\">个人自定义组</td>\r\n    </tr>\r\n";
    }
    echo "    <tr class=\"TableData\">\r\n      <td align=\"center\" onclick=\"javascript:parent.user.location='user_define.php?TO_ID=";
    echo $TO_ID;
    echo "&TO_NAME=";
    echo $TO_NAME;
    echo "&FORM_NAME=";
    echo $FORM_NAME;
    echo "&GROUP_ID=";
    echo $GROUP_ID;
    echo "';\" style=\"cursor:pointer\">";
    echo $GROUP_NAME;
    echo "</td>\r\n    </tr>\r\n";
}
$query = "SELECT * from user_group where USER_ID='' order by ORDER_NO ";
$cursor = exequery( $connection, $query );
$GROUP_COUNT1 = 0;
while ( $ROW = mysql_fetch_array( $cursor ) )
{
    ++$GROUP_COUNT1;
    $GROUP_ID = $ROW['GROUP_ID'];
    $GROUP_NAME = $ROW['GROUP_NAME'];
    if ( $GROUP_COUNT1 == 1 )
    {
        echo "    <tr class=\"TableControl\">\r\n      <td align=\"center\">公共自定义组</td>\r\n    </tr>\r\n";
    }
    echo "    <tr class=\"TableData\">\r\n      <td align=\"center\" onclick=\"javascript:parent.user.location='user_define.php?TO_ID=";
    echo $TO_ID;
    echo "&TO_NAME=";
    echo $TO_NAME;
    echo "&FORM_NAME=";
    echo $FORM_NAME;
    echo "&GROUP_ID=";
    echo $GROUP_ID;
    echo "';\" style=\"cursor:pointer\">";
    echo $GROUP_NAME;
    echo "</td>\r\n    </tr>\r\n";
}
if ( $GROUP_COUNT == 0 && $GROUP_COUNT1 == 0 )
{
    message( "", "没有自定义组", "blank" );
}
echo "    </table>\r\n  </div>\r\n<!--============================ 在线人员 =======================================-->\r\n  <li><a href=\"user_online.php?TO_ID=";
echo $TO_ID;
echo "&TO_NAME=";
echo $TO_NAME;
echo "&FORM_NAME=";
echo $FORM_NAME;
echo "\" id=\"link_5\" target=\"user\" title=\"点击伸缩列表\"><span>在线人员</span></a></li>\r\n</ul>\r\n</body>\r\n</html>";
?>
