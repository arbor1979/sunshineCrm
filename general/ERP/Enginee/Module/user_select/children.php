<?php
header("Content-type:text/html;charset=gb2312");
session_start();
$seldeptid="";
if(!empty($_GET['seldeptid']))
	$seldeptid=$_GET['seldeptid'];

$seldeptidArray=explode(",", $seldeptid);

function user_tree_list( $DEPT_ID )
{
	
    global $connection;
    global $DEEP_COUNT;
    global $USER_COUNT;
    global $MANAGE_FLAG;
    global $MODULE_ID;
	global $db;
	global $seldeptidArray;
    $query = "SELECT DEPT_ID,DEPT_NAME from department where DEPT_PARENT='".$DEPT_ID."' order by DEPT_NO";
    $cursor1 = $db->Execute($query);
    $ROW = $cursor1->GetArray();
    $OPTION_TEXT = "";
    $DEEP_COUNT1 = $DEEP_COUNT;
    $DEEP_COUNT .= "　";
    for ($i=0;$i<sizeof($ROW);$i++)
    {
        $DEPT_ID = $ROW[$i]['DEPT_ID'];
        if(!in_array($DEPT_ID, $seldeptidArray))
        	continue;
        $DEPT_NAME = $ROW[$i]['DEPT_NAME'];
        $DEPT_NAME = htmlspecialchars( $DEPT_NAME );
        $OPTION_TEXT .= "<tr class='TableHeader'><td><b>".$DEEP_COUNT1."├".$DEPT_NAME."</b></td></tr>";
        if ( $MANAGE_FLAG )
        {
            $query = "SELECT USER_ID,USER_NAME from user where DISABLED=1 and DEPT_ID=".$DEPT_ID;
        }
        else
        {
            $query = "SELECT USER_ID,USER_NAME from user where DISABLED=1 and DEPT_ID=".$DEPT_ID." and  NOT_LOGIN!='1'";
        }
    	if($MODULE_ID==1)
			$query=getRoleByUser($query,"user_id");
		
		$query=$query." order by USER_NO,USER_NAME";
        $cursor = $db->Execute($query);
    	$ROW1 = $cursor->GetArray();
        for ($j=0;$j<sizeof($ROW1);$j++)
        {
        	
            ++$USER_COUNT;
            $USER_ID = $ROW1[$j]['USER_ID'];
            $USER_NAME = $ROW1[$j]['USER_NAME'];
            $OPTION_TEXT .= "<tr class='TableData' onclick=javascript:click_user('".$USER_ID."') style='cursor:pointer' align='center'>\r\n           <td class='menulines' id='".$USER_ID."' title='".$USER_NAME."' flag='1'>\r\n           ".htmlspecialchars( $USER_NAME )."</td></tr>";
            
        }
        $OPTION_TEXT .= user_tree_list( $DEPT_ID );
    }
    $DEEP_COUNT = $DEEP_COUNT1;
    return $OPTION_TEXT;
}

	
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
echo "function click_user(user_id)\r\n{\r\n  
	TO_VAL=parent_window.";
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
	}\r\n\r\n
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
}\r\n
}\r\n\r\n
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
				borderize_on(a[step_i]);\r\n       
			}\r\n    
		}\r\n  
	}\r\n
}\r\n\r\n
function del_all(flag)\r\n
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
}\r\n}\r\n</script>\r\n</head>\r\n\r\n
<body class=\"bodycolor\" topmargin=\"1\" leftmargin=\"0\" onload=\"begin_set();";

echo "\">\r\n\r\n";

echo "<table class=\"TableBlock\" width=\"100%\">\r\n<tr class=\"TableControl\">\r\n  <td onclick=\"javascript:add_all('1');\" style=\"cursor:pointer\" align=\"center\">全部添加</td>\r\n</tr>\r\n<tr class=\"TableControl\">\r\n  <td onclick=\"javascript:del_all('1');\" style=\"cursor:pointer\" align=\"center\">全部删除</td>\r\n</tr>\r\n";
echo user_tree_list(0);


if ( $USER_COUNT == 0 )
{
    echo "<tr class=\"TableData\">\r\n  <td align=\"center\"><font color=red>未定义用户</a></td>\r\n</tr>\r\n";
}
echo "\r\n</table>\r\n</body>\r\n</html>";
?>
