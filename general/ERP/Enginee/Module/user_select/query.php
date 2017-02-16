<?php
session_start();

include_once( "../user_select/setting.inc.php" );

print "<META http-equiv=Content-Type content=\"text/html; charset=gb2312\">";
print "<link rel=\"stylesheet\" type=\"text/css\" href=\"".ROOT_DIR."theme/$LOGIN_THEME/style.css\" />";
echo "\r\n<html>\r\n<head>\r\n<meta http-equiv=\"Content-Type\" content=\"text/html; charset=gb2312\">\r\n</head>\r\n
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
echo "function click_user(user_id)\r\n
{\r\n  
TO_VAL=parent_window.";
echo $FORM_NAME;
echo ".";
echo $TO_ID;
echo ".value;\r\n  
targetelement=document.getElementById(user_id);\r\n  
user_name=targetelement.title;\r\n  if(TO_VAL.indexOf(\",\"+user_id+\",\")>0 || TO_VAL.indexOf(user_id+\",\")==0)\r\n  {\r\n    if(TO_VAL.indexOf(user_id+\",\")==0)\r\n    {\r\n       parent_window.";
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
for (step_i=0; step_i<a.length; step_i++)\r\n  {\r\n    if(a[step_i].className.indexOf(\"menulines\")>=0)\r\n    {\r\n       user_id=a[step_i].id;\r\n       if(TO_VAL.indexOf(\",\"+user_id+\",\")>0 || TO_VAL.indexOf(user_id+\",\")==0)\r\n          borderize_on(a[step_i]);\r\n    }\r\n  }\r\n}\r\n\r\nfunction add_all()\r\n{\r\n  TO_VAL=parent_window.";
echo $FORM_NAME;
echo ".";
echo $TO_ID;
echo ".value;\r\n  
a = document.getElementsByTagName('td');
for (step_i=0; step_i<a.length; step_i++)\r\n  {\r\n    if(a[step_i].className.indexOf(\"menulines\")>=0)\r\n    {\r\n       user_id=a[step_i].id;\r\n       user_name=a[step_i].title;\r\n\r\n       if(TO_VAL.indexOf(\",\"+user_id+\",\")<0 && TO_VAL.indexOf(user_id+\",\")!=0)\r\n       {\r\n         parent_window.";
echo $FORM_NAME;
echo ".";
echo $TO_ID;
echo ".value+=user_id+\",\";\r\n         parent_window.";
echo $FORM_NAME;
echo ".";
echo $TO_NAME;
echo ".value+=user_name+\",\";\r\n         borderize_on(a[step_i]);\r\n       }\r\n    }\r\n  }\r\n}\r\n\r\nfunction del_all()\r\n{\r\n  
a = document.getElementsByTagName('td');
for (step_i=0; step_i<a.length; step_i++)\r\n  {\r\n    TO_VAL=parent_window.";
echo $FORM_NAME;
echo ".";
echo $TO_ID;
echo ".value;\r\n    if(a[step_i].className.indexOf(\"menulines\")>=0)\r\n    {\r\n       user_id=a[step_i].id;\r\n       user_name=a[step_i].title;\r\n       if(TO_VAL.indexOf(user_id+\",\")==0)\r\n       {\r\n          parent_window.";
echo $FORM_NAME;
echo ".";
echo $TO_ID;
echo ".value=parent_window.";
echo $FORM_NAME;
echo ".";
echo $TO_ID;
echo ".value.replace(user_id+\",\",\"\");\r\n          parent_window.";
echo $FORM_NAME;
echo ".";
echo $TO_NAME;
echo ".value=parent_window.";
echo $FORM_NAME;
echo ".";
echo $TO_NAME;
echo ".value.replace(user_name+\",\",\"\");\r\n          borderize_off(a[step_i]);\r\n       }\r\n       if(TO_VAL.indexOf(\",\"+user_id+\",\")>0)\r\n       {\r\n          parent_window.";
echo $FORM_NAME;
echo ".";
echo $TO_ID;
echo ".value=parent_window.";
echo $FORM_NAME;
echo ".";
echo $TO_ID;
echo ".value.replace(\",\"+user_id+\",\",\",\");\r\n          parent_window.";
echo $FORM_NAME;
echo ".";
echo $TO_NAME;
echo ".value=parent_window.";
echo $FORM_NAME;
echo ".";
echo $TO_NAME;
echo ".value.replace(\",\"+user_name+\",\",\",\");\r\n          borderize_off(a[step_i]);\r\n       }\r\n    }\r\n  }\r\n}\r\n</script>\r\n<body class=\"bodycolor\" topmargin=\"5\" leftmargin=\"2\" onload=\"begin_set();\">\r\n\r\n<table class=\"TableBlock\" width=\"100%\">\r\n<tr class=\"TableHeader\">\r\n  <td align=\"center\">人员查询</td>\r\n</tr>\r\n";
$query = "SELECT USER_ID,USER_NAME from user where DISABLED=1 and (USER_ID like '%".$USER_NAME."%' or USER_NAME like '%{$USER_NAME}%') and DEPT_ID!=0 and NOT_LOGIN!='1' order by USER_NO,USER_NAME";
$cursor = exequery( $connection, $query );
$USER_COUNT = 0;
while ( $ROW = mysql_fetch_array( $cursor ) )
{
    ++$USER_COUNT;
    $USER_ID = $ROW['USER_ID'];
    $USER_NAME = $ROW['USER_NAME'];
    if ( $USER_COUNT == 1 )
    {
        echo "<tr class=\"TableData\">\r\n  <td onclick=\"javascript:add_all();\" style=\"cursor:hand\" align=\"center\">全部添加</td>\r\n</tr>\r\n<tr class=\"TableData\">\r\n  <td onclick=\"javascript:del_all();\" style=\"cursor:hand\" align=\"center\">全部删除</td>\r\n</tr>\r\n";
    }
    echo "<tr class=\"TableData\" onclick=\"javascript:click_user('";
    echo $USER_ID;
    echo "')\" style=\"cursor:pointer\" align=\"center\">\r\n  <td class=\"menulines\" id=\"";
    echo $USER_ID;
    echo "\" title=\"";
    echo $USER_NAME;
    echo "\">\r\n  ";
    echo htmlspecialchars( $USER_NAME );
    echo "  </td>\r\n</tr>\r\n\r\n";
}
if ( $USER_COUNT == 0 )
{
    echo "<tr class=\"TableData\">\r\n  <td align=\"center\">未查询到用户</td>\r\n</tr>\r\n";
}
echo "\r\n</table>\r\n</body>\r\n</html>";
?>
