<?php
session_start();
header("Content-type:text/html;charset=gb2312");

require_once('../../../adodb/adodb.inc.php');
require_once('../../../config.inc.php');
require_once('../../../setting.inc.php');
require_once('../../../adodb/session/adodb-session2.php');
include_once( "../../lib/select_menu.php" );
print "<META http-equiv=Content-Type content=\"text/html; charset=gb2312\">";
print "<link rel=\"stylesheet\" type=\"text/css\" href=\"".ROOT_DIR."theme/$LOGIN_THEME/style.css\" />";
echo "\r\n<html>\r\n<head>\r\n<title></title>\r\n<meta http-equiv=\"Content-Type\" content=\"text/html; charset=gb2312\">\r\n<style>\r\n.menulines{}\r\n</style>\r\n\r\n
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
if ( $TO_ID == "" || $TO_ID == "undefined" )
{
    $TO_ID = "TO_ID";
    $TO_NAME = "TO_NAME";
}

echo "function click_user(user_id)\r\n{\r\n  TO_VAL=parent_window.";
echo $FORM_NAME;
echo ".";
echo $TO_ID;
echo ".value;\r\n  
targetelement=document.getElementById(user_id);\r\n  
user_name=targetelement.title;\r\n  
if(TO_VAL.indexOf(\",\"+user_id+\",\")>0 || TO_VAL.indexOf(user_id+\",\")==0)\r\n  
{\r\n    
	if(TO_VAL.indexOf(user_id+\",\")==0)\r\n    
	{\r\n      
		 parent_window.";
echo $FORM_NAME;
echo ".";
echo $TO_ID;
echo ".value=parent_window.";
echo $FORM_NAME;
echo ".";
echo $TO_ID;
echo ".value.replace(user_id+\",\",\"\");\r\n       parent_window.";
echo $FORM_NAME;
echo ".";
echo $TO_NAME;
echo ".value=parent_window.";
echo $FORM_NAME;
echo ".";
echo $TO_NAME;
echo ".value.replace(user_name+\",\",\"\");\r\n       borderize_off(targetelement);\r\n    }\r\n    if(TO_VAL.indexOf(\",\"+user_id+\",\")>0)\r\n    {\r\n       parent_window.";
echo $FORM_NAME;
echo ".";
echo $TO_ID;
echo ".value=parent_window.";
echo $FORM_NAME;
echo ".";
echo $TO_ID;
echo ".value.replace(\",\"+user_id+\",\",\",\");\r\n       parent_window.";
echo $FORM_NAME;
echo ".";
echo $TO_NAME;
echo ".value=parent_window.";
echo $FORM_NAME;
echo ".";
echo $TO_NAME;
echo ".value.replace(\",\"+user_name+\",\",\",\");\r\n       borderize_off(targetelement);\r\n    }\r\n  }\r\n  else\r\n  {\r\n    parent_window.";
echo $FORM_NAME;
echo ".";
echo $TO_ID;
echo ".value+=user_id+\",\";\r\n    parent_window.";
echo $FORM_NAME;
echo ".";
echo $TO_NAME;
echo ".value+=user_name+\",\";\r\n    borderize_on(targetelement);\r\n  }\r\n\r\n}\r\n\r\nfunction borderize_on(targetelement)\r\n{\r\n color=\"#003FBF\";\r\n targetelement.style.borderColor=\"black\";\r\n targetelement.style.backgroundColor=color;\r\n targetelement.style.color=\"white\";\r\n targetelement.style.fontWeight=\"bold\";\r\n}\r\n\r\nfunction borderize_off(targetelement)\r\n{\r\n  targetelement.style.backgroundColor=\"\";\r\n  targetelement.style.borderColor=\"\";\r\n  targetelement.style.color=\"\";\r\n  targetelement.style.fontWeight=\"\";\r\n}\r\n\r\nfunction begin_set()\r\n{\r\n  TO_VAL=parent_window.";
echo $FORM_NAME;
echo ".";
echo $TO_ID;
echo ".value;\r\n\r\n  
a = document.getElementsByTagName('td');
for (step_i=0; step_i<a.length; step_i++)\r\n  {\r\n    if(a[step_i].className.indexOf(\"menulines\")>=0)\r\n    {\r\n       user_id=a[step_i].id;\r\n       if(TO_VAL.indexOf(\",\"+user_id+\",\")>0 || TO_VAL.indexOf(user_id+\",\")==0)\r\n          borderize_on(a[step_i]);\r\n    }\r\n  }\r\n}\r\n\r\n

function add_all(flag)\r\n
{\r\n  
	TO_VAL=parent_window.";
echo $FORM_NAME;
echo ".";
echo $TO_ID;
echo ".value;\r\n  
a = document.getElementsByTagName('td');
for (step_i=0; step_i<a.length; step_i++)\r\n  
{\r\n    
	if(a[step_i].className.indexOf(\"menulines\")>=0)\r\n    
	{\r\n       
      user_id=a[step_i].id;\r\n       
      user_name=a[step_i].title;\r\n\r\n       
      if(TO_VAL.indexOf(\",\"+user_id+\",\")<0 && TO_VAL.indexOf(user_id+\",\")!=0)\r\n      
       {\r\n         
       		parent_window.";
echo $FORM_NAME;
echo ".";
echo $TO_ID;
echo ".value+=user_id+\",\";\r\n         
			parent_window.";
echo $FORM_NAME;
echo ".";
echo $TO_NAME;
echo ".value+=user_name+\",\";\r\n         
			borderize_on(a[step_i]);\r\n       }\r\n    }\r\n  }\r\n}\r\n\r\n
function del_all(flag)\r\n{\r\n  
a = document.getElementsByTagName('td');
for (step_i=0; step_i<a.length; step_i++)\r\n  
{\r\n    
	TO_VAL=parent_window.";
echo $FORM_NAME;
echo ".";
echo $TO_ID;
echo ".value;\r\n    
	if(a[step_i].className.indexOf(\"menulines\")>=0)\r\n    
	{\r\n           
		user_id=a[step_i].id;\r\n       
		user_name=a[step_i].title;\r\n       
		if(TO_VAL.indexOf(user_id+\",\")==0)\r\n      
		 {\r\n          
		 	parent_window.";
echo $FORM_NAME;
echo ".";
echo $TO_ID;
echo ".value=parent_window.";
echo $FORM_NAME;
echo ".";
echo $TO_ID;
echo ".value.replace(user_id+\",\",\"\");\r\n          
			parent_window.";
echo $FORM_NAME;
echo ".";
echo $TO_NAME;
echo ".value=parent_window.";
echo $FORM_NAME;
echo ".";
echo $TO_NAME;
echo ".value.replace(user_name+\",\",\"\");\r\n          
			borderize_off(a[step_i]);\r\n       
		}\r\n       
		if(TO_VAL.indexOf(\",\"+user_id+\",\")>0)\r\n       {\r\n          parent_window.";
echo $FORM_NAME;
echo ".";
echo $TO_ID;
echo ".value=parent_window.";
echo $FORM_NAME;
echo ".";
echo $TO_ID;
echo ".value.replace(\",\"+user_id+\",\",\"\");\r\n          parent_window.";
echo $FORM_NAME;
echo ".";
echo $TO_NAME;
echo ".value=parent_window.";
echo $FORM_NAME;
echo ".";
echo $TO_NAME;
echo ".value.replace(\",\"+user_name+\",\",\"\");\r\n          borderize_off(a[step_i]);\r\n       }\r\n    }\r\n  }\r\n}\r\n</script>\r\n</head>\r\n\r\n<body class=\"bodycolor\" topmargin=\"1\" leftmargin=\"0\" onload=\"begin_set()\">\r\n\r\n";
if ( $DEPT_ID == "" )
{
    $DEPT_ID = $LOGIN_DEPT_ID;
}

if ( $USER_PRIV == "" )
{
    if ( $MANAGE_FLAG )
    {
        $query = "SELECT USER_ID,USER_NAME from user where DISABLED=1 and DEPT_ID=".$DEPT_ID;
    }
    else
    {
        $query = "SELECT USER_ID,USER_NAME from user where DISABLED=1 and DEPT_ID=".$DEPT_ID."  and NOT_LOGIN!='1'";
    }
    if($MODULE_ID==1)
    	$query=getRoleByUser($query,"USER_ID");
    $query=$query."  order by UID,USER_NAME";
    $query1 = "select DEPT_NAME from department where DEPT_ID='".$DEPT_ID."'";
    $cursor1 = $db->Execute($query1);
    $ROW = $cursor1->GetArray();
    if (sizeof($ROW)==1)
    {
        $TITLE = $ROW[0]['DEPT_NAME'];
    }
}
else
{
    if ( $MANAGE_FLAG )
    {
        $query = "SELECT USER_ID,USER_NAME from user where DISABLED=1 and USER_PRIV='".$USER_PRIV."' and DEPT_ID!=0";
    }
    else
    {
        $query = "SELECT USER_ID,USER_NAME from user where DISABLED=1 and USER_PRIV='".$USER_PRIV."' and DEPT_ID!=0 and NOT_LOGIN!='1'";
    }
     if($MODULE_ID==1)
    	$query=getRoleByUser($query,"USER_ID");
    $query=$query."  order by UID,USER_NAME";	
    $query1 = "select PRIV_NAME from user_priv where USER_PRIV='".$USER_PRIV."'";
    $cursor1 = $db->Execute($query1);
    $ROW = $cursor1->GetArray();
    if (sizeof($ROW)==1)
    {
        $TITLE = $ROW[0]['PRIV_NAME'];
    }
}
echo "\r\n<table class=\"TableBlock\" width=\"100%\">\r\n<tr class=\"TableHeader\">\r\n  <td colspan=\"2\" align=\"center\"><b>";
echo $TITLE;
echo "</b></td>\r\n</tr>\r\n\r\n";
$cursor = $db->Execute($query);
$ROW = $cursor->GetArray();
$USER_COUNT = 0;
for ($i=0;$i<sizeof($ROW);$i++)
{
    ++$USER_COUNT;
    $USER_ID = $ROW[$i]['USER_ID'];
    $USER_NAME = $ROW[$i]['USER_NAME'];
    if ( $USER_COUNT == 1 )
    {
        echo "<tr class=\"TableControl\">\r\n  <td onclick=\"javascript:add_all('1');\" style=\"cursor:pointer\" align=\"center\">全部添加</td>\r\n</tr>\r\n<tr class=\"TableControl\">\r\n  <td onclick=\"javascript:del_all('1');\" style=\"cursor:pointer\" align=\"center\">全部删除</td>\r\n</tr>\r\n";
    }
    echo "\r\n<tr class=\"TableData\">\r\n  <td class=\"menulines\" id=\"";
    echo $USER_ID;
    echo "\" title=\"";
    echo $USER_NAME;
    echo "\" flag=\"1\" align=\"center\" onclick=\"javascript:click_user('";
    echo $USER_ID;
    echo "')\" style=\"cursor:pointer\">\r\n  ";
    echo htmlspecialchars( $USER_NAME );
    echo "  </td>\r\n</tr>\r\n\r\n";
}
if ( $USER_PRIV != "" )
{
    $query = "SELECT USER_ID,USER_NAME from user where DISABLED=1 and (USER_PRIV_OTHER like '".$USER_PRIV.",%' or USER_PRIV_OTHER like '%,{$USER_PRIV},%') and USER_PRIV!='{$USER_PRIV}' and DEPT_ID!=0 ";
    if ( !$MANAGE_FLAG )
    {
        $query .= " and NOT_LOGIN!='1'";
    }
    if($MODULE_ID==1)
    	$query=getRoleByUser($query,"USER_ID");
    $query .= " order by USER_NO,USER_NAME";
    $cursor = $db->Execute($query);
	$ROW = $cursor->GetArray();
    $USER_COUNT1 = 0;
    for ($i=0;$i<sizeof($ROW);$i++)
    {
        ++$USER_COUNT;
        ++$USER_COUNT1;
        $USER_ID = $ROW[$i]['USER_ID'];
        $USER_NAME = $ROW[$i]['USER_NAME'];
       
        if ( $USER_COUNT1 == 1 )
        {
            echo "<tr class=\"TableHeader\">\r\n  <td colspan=\"2\" align=\"center\"><b>辅助角色</b></td>\r\n</tr>\r\n<tr class=\"TableControl\">\r\n  <td onclick=\"javascript:add_all('2');\" style=\"cursor:pointer\" align=\"center\">全部添加</td>\r\n</tr>\r\n<tr class=\"TableControl\">\r\n  <td onclick=\"javascript:del_all('2');\" style=\"cursor:pointer\" align=\"center\">全部删除</td>\r\n</tr>\r\n";
        }
        echo "\r\n<tr class=\"TableData\" onclick=\"javascript:click_user('";
        echo $USER_ID;
        echo "')\" style=\"cursor:pointer\" align=\"center\">\r\n  <td class=\"menulines\" id=\"";
        echo $USER_ID;
        echo "\" title=\"";
        echo $USER_NAME;
        echo "\" flag=\"2\">\r\n  ";
        echo htmlspecialchars( $USER_NAME );
        echo "  </td>\r\n</tr>\r\n\r\n";
    }
}
if ( $USER_COUNT == 0 )
{
    echo "<tr class=\"TableData\">\r\n  <td align=\"center\">未定义用户</td>\r\n</tr>\r\n";
}
echo "\r\n</table>\r\n</body>\r\n</html>\r\n";
?>
