<?php
session_start();
header("Content-type:text/html;charset=gb2312");
require_once('../../../adodb/adodb.inc.php');
require_once('../../../config.inc.php');
require_once('../../../setting.inc.php');
require_once('../../lib/select_menu.php');
if ( $TO_ID == "" || $TO_ID == "undefined" )
{
    $TO_ID = "TO_ID";
    $TO_NAME = "TO_NAME";
}
print "<META http-equiv=Content-Type content=\"text/html; charset=gb2312\">";
print "<link rel=\"stylesheet\" type=\"text/css\" href=\"".ROOT_DIR."theme/$LOGIN_THEME/style.css\" />";

echo "\r\n<html>\r\n<head>\r\n<title></title>\r\n<meta http-equiv=\"Content-Type\" content=\"text/html; charset=gb2312\">\r\n\r\n";
include_once( "menu_button.js" );
echo "\r\n
<script type=\"text/javascript\" language=\"javascript\" src=\"".ROOT_DIR."general/ERP/Enginee/lib/common.js\"></script>
<script Language=\"JavaScript\">\r\n
function getOpenner()
{
   if(parent.dialogArguments==null)
   {
      return parent.opener.document;
   }
   else
      return parent.dialogArguments.document;
}
var parent_window = getOpenner();";

echo "function add_user(user_id,user_name)\r\n{\r\n  
TO_VAL=parent_window.";
echo $FORM_NAME;
echo ".";
echo $TO_ID;
echo ".value;\r\n  
if(TO_VAL.indexOf(\",\"+user_id+\",\")<0 && TO_VAL.indexOf(user_id+\",\")!=0)\r\n  
{\r\n    
	parent_window.";
echo $FORM_NAME;
echo ".";
echo $TO_ID;
echo ".value=user_id;\r\n    
	parent_window.";
echo $FORM_NAME;
echo ".";
echo $TO_NAME;
echo ".value=user_name;\r\n  
}\r\n  
parent.close();\r\n
}\r\n</script>\r\n</head>\r\n\r\n
<body class=\"bodycolor\" topmargin=\"1\" leftmargin=\"0\" >\r\n\r\n";

$query="SELECT USER_ID,USER_NAME from user,user_priv where DISABLED=1 and USER.USER_PRIV=USER_PRIV.USER_PRIV";
if ( $DEPT_ID != "" )
	$query.=" and dept_id='".$DEPT_ID."'";
if ( $USER_PRIV != "" )
	$query.=" and user_priv.USER_PRIV='".$USER_PRIV."'";
if ( $MODULE_ID!="1" )
{
	$sql=getRoleByUser($sql,"user_id");
}

	$query.=" and (USER_NAME like'%".$USER_NAME."%' or BYNAME like '%".$USER_NAME."%')";
//print $query;
	$cursor = $db->Execute($query);
    $ROW = $cursor->GetArray();
    $USER_COUNT = 0;
     echo "<table class=\"TableBlock\" width=\"100%\">\r\n<tr class=\"TableHeader\">\r\n  <td align=\"center\"><b>人员查询</b></td>\r\n</tr>\r\n\r\n";
    for ($j=0;$j<sizeof($ROW);$j++)
    {

    $USER_ID = $ROW[$j]['USER_ID'];
    $USER_NAME = $ROW[$j]['USER_NAME'];
    
    echo "\r\n<tr class=\"TableData\">\r\n  <td class=\"menulines\" align=\"center\" onclick=\"javascript:add_user('";
    echo $USER_ID;
    echo "','";
    echo $USER_NAME;
    echo "')\" style=\"cursor:pointer\">";
    echo $USER_NAME;
    echo "</td>\r\n</tr>\r\n";
    ++$USER_COUNT;
}
if ( $USER_COUNT == 0 )
{
   echo "<tr class=\"TableData\">\r\n  <td align=\"center\"><font color=red>未定义用户</a></td>\r\n</tr>\r\n";
}
echo "</table>";
echo "\r\n</body>\r\n</html>\r\n";
?>
