<?php
header("Content-type:text/html;charset=gb2312");
session_start();

include_once( "../user_select/setting.inc.php" );
if ( $TO_ID == "" || $TO_ID == "undefined" )
{
    $TO_ID = "TO_ID";
    $TO_NAME = "TO_NAME";
}
print "<META http-equiv=Content-Type content=\"text/html; charset=gb2312\">";
print "<link rel=\"stylesheet\" type=\"text/css\" href=\"".ROOT_DIR."theme/$LOGIN_THEME/style.css\" />";
echo "\r\n<html>\r\n<head>\r\n<meta http-equiv=\"Content-Type\" content=\"text/html; charset=gb2312\">\r\n<style>\r\n.menulines{}\r\n</style>\r\n</head>
<script type=\"text/javascript\" language=\"javascript\" src=\"".ROOT_DIR."general/ERP/Enginee/lib/common.js\"></script>
<script Language=\"JavaScript\">
function getOpenner()
{
   if(parent.dialogArguments==null)
   {
      return parent.opener.document;
   }
   else
      return parent.dialogArguments.document;
}
var parent_window = getOpenner();

";


echo "function click_user(user_id)\r\n{\r\n  
	TO_VAL=parent_window.";
echo $FORM_NAME;
echo ".";
echo $TO_ID;
echo ".value;\r\n 
	targetelement=document.getElementById(user_id);\r\n  
	user_name=targetelement.title;\r\n\r\n  
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
			borderize_off(targetelement);\r\n    
		}\r\n    
		if(TO_VAL.indexOf(\",\"+user_id+\",\")>0)\r\n    
		{\r\n       
			parent_window.";
echo $FORM_NAME;
echo ".";
echo $TO_ID;
echo ".value=parent_window.";
echo $FORM_NAME;
echo ".";
echo $TO_ID;
echo ".value.replace(\",\"+user_id+\",\",\",\");\r\n       
			parent_window.";
echo $FORM_NAME;
echo ".";
echo $TO_NAME;
echo ".value=parent_window.";
echo $FORM_NAME;
echo ".";
echo $TO_NAME;
echo ".value.replace(\",\"+user_name+\",\",\",\");\r\n       
			borderize_off(targetelement);\r\n    
		}\r\n  
	}\r\n  
	else\r\n  
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
		borderize_on(targetelement);\r\n  
	}\r\n 
}\r\n\r\n
function borderize_on(targetelement)\r\n
{\r\n 
	color=\"#003FBF\";\r\n 
	targetelement.style.borderColor=\"black\";\r\n 
	targetelement.style.backgroundColor=color;\r\n 
	targetelement.style.color=\"white\";\r\n 
	targetelement.style.fontWeight=\"bold\";\r\n
}\r\n\r\n
function borderize_off(targetelement)\r\n
{\r\n  
	targetelement.style.backgroundColor=\"\";\r\n  
	targetelement.style.borderColor=\"\";\r\n  
	targetelement.style.color=\"\";\r\n  
	targetelement.style.fontWeight=\"\";\r\n
}\r\n\r\n
function begin_set()\r\n
{\r\n  

TO_VAL=parent_window.";
echo $FORM_NAME;
echo ".";
echo $TO_ID;
echo ".value;\r\n\r\n  

a = document.getElementsByTagName('td');
for (step_i=0; step_i<a.length; step_i++)\r\n  
{\r\n    
	 
	if(a[step_i].className.indexOf(\"menulines\")>=0)\r\n   
	{\r\n       
		user_id=a[step_i].id;\r\n     
		 
		if(TO_VAL.indexOf(\",\"+user_id+\",\")>0 || TO_VAL.indexOf(user_id+\",\")==0)\r\n          
			borderize_on(a[step_i]);\r\n    
	}\r\n  
}\r\n}\r\n\r\n
function add_all()\r\n{\r\n  
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
			borderize_on(a[step_i]);\r\n       
		}\r\n    
	}\r\n  
}\r\n }\r\n\r\n
function del_all()\r\n
{\r\n  
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
			if(TO_VAL.indexOf(\",\"+user_id+\",\")>0)\r\n       
			{\r\n          
				parent_window.";
echo $FORM_NAME;
echo ".";
echo $TO_ID;
echo ".value=parent_window.";
echo $FORM_NAME;
echo ".";
echo $TO_ID;
echo ".value.replace(\",\"+user_id+\",\",\",\");\r\n          
				parent_window.";
echo $FORM_NAME;
echo ".";
echo $TO_NAME;
echo ".value=parent_window.";
echo $FORM_NAME;
echo ".";
echo $TO_NAME;
echo ".value.replace(\",\"+user_name+\",\",\",\");\r\n          
				borderize_off(a[step_i]);\r\n       
			}\r\n    
		}\r\n  
	}\r\n  
}\r\n</script>\r\n
<body class=\"bodycolor\" topmargin=\"0\" leftmargin=\"0\" onload=\"begin_set()\">\r\n";
if ( $TO_ID_STR == "" || $TO_NAME_STR == "" )
{
    message( "", "暂无选择人员", "blank" );
    exit( );
}
echo "<table class=\"TableBlock\" width=\"100%\">\r\n<tr class=\"TableHeader\">\r\n  <td colspan=\"2\" align=\"center\"><b>已选人员</b></td>\r\n</tr>\r\n<tr class=\"TableControl\">\r\n  <td onclick=\"javascript:add_all();\" style=\"cursor:pointer\" align=\"center\" colspan=\"2\">全部添加</td>\r\n</tr>\r\n<tr class=\"TableControl\">\r\n  <td onclick=\"javascript:del_all();\" style=\"cursor:pointer\" align=\"center\" colspan=\"2\">全部删除</td>\r\n</tr>\r\n";
$USER_ID_ARRAY = explode( ",", $TO_ID_STR );
$USER_NAME_ARRAY = explode( ",", urldecode( $TO_NAME_STR ) );
$I = 0;
for ( ; $I < count( $USER_ID_ARRAY ); ++$I )
{
    if ( !( $USER_ID_ARRAY[$I] == "" ) )
    {
        if ( $USER_NAME_ARRAY[$I] == "" )
        {
            break;
        }
    }
    else
    {
        continue;
    }
    echo "<tr class=\"TableData\" onclick=\"javascript:click_user('";
    echo $USER_ID_ARRAY[$I];
    echo "')\" style=\"cursor:pointer\" align=\"center\">\r\n  <td class=\"menulines\" id=\"";
    echo $USER_ID_ARRAY[$I];
    echo "\" title=\"";
    echo $USER_NAME_ARRAY[$I];
    echo "\">";
    echo htmlspecialchars( $USER_NAME_ARRAY[$I] );
    echo "</td>\r\n</tr>\r\n";
}
echo "</table>\r\n</body>\r\n</html>";
?>
