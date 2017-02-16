<?php
session_start();

include_once( "../user_select/setting.inc.php" );

print "<META http-equiv=Content-Type content=\"text/html; charset=gb2312\">";
print "<link rel=\"stylesheet\" type=\"text/css\" href=\"".ROOT_DIR."theme/$LOGIN_THEME/style.css\" />";
echo "\r\n<html>\r\n<head>\r\n<meta http-equiv=\"Content-Type\" content=\"text/html; charset=gb2312\">\r\n<style>\r\n.menulines{}\r\n</style>\r\n</head>\r\n<script Language=\"JavaScript\">\r\nvar parent_window = parent.dialogArguments;\r\n";
if ( $TO_ID == "" || $TO_ID == "undefined" )
{
    $TO_ID = "TO_ID";
    $TO_NAME = "TO_NAME";
}
echo "function click_user(user_id)\r\n{\r\n  TO_VAL=parent_window.";
echo $FORM_NAME;
echo ".";
echo $TO_ID;
echo ".value;\r\n  targetelement=document.all(user_id);\r\n  user_name=targetelement.name;\r\n\r\n  if(TO_VAL.indexOf(\",\"+user_id+\",\")>0 || TO_VAL.indexOf(user_id+\",\")==0)\r\n  {\r\n    if(TO_VAL.indexOf(user_id+\",\")==0)\r\n    {\r\n       parent_window.";
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
echo ".value+=user_name+\",\";\r\n    borderize_on(targetelement);\r\n  }\r\n}\r\n\r\nfunction borderize_on(targetelement)\r\n{\r\n color=\"#003FBF\";\r\n targetelement.style.borderColor=\"black\";\r\n targetelement.style.backgroundColor=color;\r\n targetelement.style.color=\"white\";\r\n targetelement.style.fontWeight=\"bold\";\r\n}\r\n\r\nfunction borderize_off(targetelement)\r\n{\r\n  targetelement.style.backgroundColor=\"\";\r\n  targetelement.style.borderColor=\"\";\r\n  targetelement.style.color=\"\";\r\n  targetelement.style.fontWeight=\"\";\r\n}\r\n\r\nfunction begin_set()\r\n{\r\n  TO_VAL=parent_window.";
echo $FORM_NAME;
echo ".";
echo $TO_ID;
echo ".value;\r\n\r\n  for (step_i=0; step_i<document.all.length; step_i++)\r\n  {\r\n    if(document.all(step_i).className.indexOf(\"menulines\")>=0)\r\n    {\r\n       user_id=document.all(step_i).id;\r\n       if(TO_VAL.indexOf(\",\"+user_id+\",\")>0 || TO_VAL.indexOf(user_id+\",\")==0)\r\n          borderize_on(document.all(step_i));\r\n    }\r\n  }\r\n}\r\n\r\nfunction add_all()\r\n{\r\n  TO_VAL=parent_window.";
echo $FORM_NAME;
echo ".";
echo $TO_ID;
echo ".value;\r\n  for (step_i=0; step_i<document.all.length; step_i++)\r\n  {\r\n    if(document.all(step_i).className.indexOf(\"menulines\")>=0)\r\n    {\r\n       user_id=document.all(step_i).id;\r\n       user_name=document.all(step_i).name;\r\n\r\n       if(TO_VAL.indexOf(\",\"+user_id+\",\")<0 && TO_VAL.indexOf(user_id+\",\")!=0)\r\n       {\r\n         parent_window.";
echo $FORM_NAME;
echo ".";
echo $TO_ID;
echo ".value+=user_id+\",\";\r\n         parent_window.";
echo $FORM_NAME;
echo ".";
echo $TO_NAME;
echo ".value+=user_name+\",\";\r\n         borderize_on(document.all(step_i));\r\n       }\r\n    }\r\n  }\r\n}\r\n\r\nfunction del_all()\r\n{\r\n  for (step_i=0; step_i<document.all.length; step_i++)\r\n  {\r\n    TO_VAL=parent_window.";
echo $FORM_NAME;
echo ".";
echo $TO_ID;
echo ".value;\r\n    if(document.all(step_i).className.indexOf(\"menulines\")>=0)\r\n    {\r\n       user_id=document.all(step_i).id;\r\n       user_name=document.all(step_i).name;\r\n       if(TO_VAL.indexOf(user_id+\",\")==0)\r\n       {\r\n          parent_window.";
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
echo ".value.replace(user_name+\",\",\"\");\r\n          borderize_off(document.all(step_i));\r\n       }\r\n       if(TO_VAL.indexOf(\",\"+user_id+\",\")>0)\r\n       {\r\n          parent_window.";
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
echo ".value.replace(\",\"+user_name+\",\",\",\");\r\n          borderize_off(document.all(step_i));\r\n       }\r\n    }\r\n  }\r\n}\r\n</script>\r\n<body class=\"bodycolor\" topmargin=\"0\" leftmargin=\"0\" onload=\"begin_set()\">\r\n\r\n";
$PATH = $ATTACH_PATH2."user_online";
$files = scandir( $PATH );
$files_count = count( $files );
$USER_COUNT = 0;
$I = 0;
for ( ; $I < $files_count; ++$I )
{
    $array = explode( ".", $files[$I] );
    if ( !( $array[2] == "usr" ) && !( time( ) - $array[1] <= $ONLINE_REF_SEC + 5 ) )
    {
        $UID_STR .= $array[0].",";
    }
}
$DEPT_COUNT = 0;
$USER_COUNT = 0;
$DEPT_ID_PREV = "";
$USER_ID_STR = "";
$USER_NAME_STR = "";
$DEPT_NAME_STR = "";
$query = "SELECT USER_ID,USER_NAME,USER.DEPT_ID,DEPT_NAME from user,department,user_priv where find_in_set(UID,'".$UID_STR."') and user.USER_PRIV=user_priv.USER_PRIV and user.DEPT_ID=department.DEPT_ID order by DEPT_NO,department.DEPT_ID,PRIV_NO,USER_NO,USER_NAME";
$cursor = exequery( $connection, $query );
while ( $ROW = mysql_fetch_array( $cursor ) )
{
    $USER_ID = $ROW['USER_ID'];
    $USER_NAME = $ROW['USER_NAME'];
    $DEPT_ID = $ROW['DEPT_ID'];
    if ( $DEPT_ID_PREV != $DEPT_ID )
    {
        $DEPT_NAME = $ROW['DEPT_NAME'];
        ++$DEPT_COUNT;
    }
    $DEPT_NAME_STR .= $DEPT_NAME.",";
    $DEPT_ID_PREV = $DEPT_ID;
    $USER_ID_STR .= $USER_ID.",";
    $USER_NAME_STR .= $USER_NAME.",";
    ++$USER_COUNT;
}
if ( 0 < $USER_COUNT )
{
    if ( $USER_ID_STR != "" )
    {
        $USER_ID_STR = substr( $USER_ID_STR, 0, strlen( $USER_ID_STR ) - 1 );
    }
    if ( $USER_NAME_STR != "" )
    {
        $USER_NAME_STR = substr( $USER_NAME_STR, 0, strlen( $USER_NAME_STR ) - 1 );
    }
    if ( $DEPT_NAME_STR != "" )
    {
        $DEPT_NAME_STR = substr( $DEPT_NAME_STR, 0, strlen( $DEPT_NAME_STR ) - 1 );
    }
    $DEPT_NAME_STR = str_replace( " ", "", $DEPT_NAME_STR );
}
if ( $USER_COUNT == 0 )
{
    message( "", "无在线人员!", "blank" );
    exit( );
}
echo "<table class=\"TableBlock\" width=\"100%\">\r\n<tr class=\"TableHeader\">\r\n  <td colspan=\"2\" align=\"center\"><b>全部在线人员</b></td>\r\n</tr>\r\n<tr class=\"TableControl\">\r\n  <td onclick=\"javascript:add_all();\" style=\"cursor:pointer\" align=\"center\" colspan=\"2\">全部添加</td>\r\n</tr>\r\n<tr class=\"TableControl\">\r\n  <td onclick=\"javascript:del_all();\" style=\"cursor:pointer\" align=\"center\" colspan=\"2\">全部删除</td>\r\n</tr>\r\n";
$USER_ID_ARRAY = explode( ",", $USER_ID_STR );
$USER_NAME_ARRAY = explode( ",", $USER_NAME_STR );
$DEPT_NAME_ARRAY = explode( ",", $DEPT_NAME_STR );
$I = 0;
for ( ; $I < $USER_COUNT; ++$I )
{
    echo "<tr class=\"TableData\" onclick=\"javascript:click_user('";
    echo $USER_ID_ARRAY[$I];
    echo "')\" style=\"cursor:pointer\" align=\"center\">\r\n  <td class=\"menulines\" id=\"";
    echo $USER_ID_ARRAY[$I];
    echo "\" name=\"";
    echo $USER_NAME_ARRAY[$I];
    echo "\">";
    echo htmlspecialchars( $USER_NAME_ARRAY[$I] );
    echo "</td><td>";
    echo htmlspecialchars( $DEPT_NAME_ARRAY[$I] );
    echo "</td>\r\n</tr>\r\n";
}
echo "</table>\r\n</body>\r\n</html>";
?>
