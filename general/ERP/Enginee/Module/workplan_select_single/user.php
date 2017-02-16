<?php
require_once('../../../adodb/adodb.inc.php');
require_once('../../../config.inc.php');
require_once('../../../setting.inc.php');
require_once('../../../adodb/session/adodb-session2.php');

$GLOBAL_SESSION=returnsession();



?>
<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<link rel="stylesheet" type="text/css" href="<?php echo ROOT_DIR?>theme/<?php echo $LOGIN_THEME?>/style.css" />
<link rel="stylesheet" type="text/css" href="<?php echo ROOT_DIR?>theme/<?php echo $LOGIN_THEME?>/menu_left.css" />
<script src="hover_tr.js"></script>
<script type="text/javascript">
var $ = function(id) {return document.getElementById(id);};
var CUR_ID="2";
function clickMenu(ID)
{
    var el=$("module_"+CUR_ID);
    var link=$("link_"+CUR_ID);
    if(ID==CUR_ID)
    {
       if(el.style.display=="none")
       {
           el.style.display='';
           link.className="active";
       }
       else
       {
           el.style.display="none";
           link.className="";
       }
    }
    else
    {
       el.style.display="none";
       link.className="";
       $("module_"+ID).style.display="";
       $("link_"+ID).className="active";
    }

    CUR_ID=ID;
}
function ShowSelected()
{
   parent.user.location="user.php?TO_ID=TO_ID&TO_NAME=TO_NAME&FORM_NAME=form1";
}

</script>
<?php
echo "<script type=\"text/javascript\" language=\"javascript\" src=\"".ROOT_DIR."general/ERP/Enginee/lib/common.js\"></script>";
echo "<script Language=\"JavaScript\">\r\n
function getOpenner()
{
   if(parent.dialogArguments==null)
   {
      return parent.opener.document;
   }
   else
      return parent.dialogArguments.document;
}\r\n
var parent_window = getOpenner();\r\n";
if ( $TO_ID == "" || $TO_ID == "undefined" )
{
	$TO_ID = "TO_ID";
	$TO_NAME = "TO_NAME";
}

echo "function add_user(user_id,user_name)\r\n{\r\n  TO_NAME=parent_window.";
echo $FORM_NAME;
echo ".";
echo $TO_NAME;
echo ";\r\n 
if(TO_NAME.value!=user_name)\r\n  {\r\n    parent_window.";
echo $FORM_NAME;
echo ".";
echo $TO_ID;
echo ".value=user_id;\r\n    parent_window.";
echo $FORM_NAME;
echo ".";
echo $TO_NAME;
echo ".value=user_name;\r\n 

if(TO_NAME.onchange!=null)
	TO_NAME.onchange(); 
}\r\n  parent.close();\r\n}\r\n</script>\r\n</head>\r\n\r\n<body class=\"bodycolor\" topmargin=\"1\" leftmargin=\"0\" >\r\n\r\n";



echo "<table class=\"TableBlock trHover\" width=\"100%\">\r\n<tr class=\"TableHeader\">\r\n  <td align=\"center\"><b>选择计划</b></td>\r\n</tr>\r\n\r\n";

$sql = "select * from workplanmain where state<>2 and zhixingren like '%".$_SESSION['LOGIN_USER_ID'].",%'";

if($_GET['action']=="SEARCH")	{
	$KEYVALUE = $_GET['KEYVALUE'];
	$sql = $sql." and (zhuti like '%$KEYVALUE%')";
}
$sql.=" order by createtime desc";
$rs = $db->CacheExecute(150,$sql);
$rs_a = $rs->GetArray();

if(sizeof($rs_a)>0){
for($i=0;$i<sizeof($rs_a);$i++)			{
	$sql="select user_name from user where user_id='".$rs_a[$i]['createman']."'";
	$rs = $db->CacheExecute(150,$sql);
	$rs_b = $rs->GetArray();
	
	$supplyname = $rs_a[$i]['zhuti']." (".$rs_b[0]['user_name'].")";
	$rowid=$rs_a[$i]['id'];
	echo "\r\n<tr class=\"TableData\">\r\n  <td class=\"menulines\" align=\"center\" onclick=\"javascript:;add_user('";
	echo $supplyname;
	echo "','";
	echo "".$rowid."";
	echo "')\" style=\"cursor:pointer\">";
	echo "".$supplyname."";
	echo "</td>\r\n</tr>\r\n";
}
}else{


	echo "\r\n<tr class=\"TableData\">\r\n  <td class=\"menulines\" align=\"center\" onclick=\"javascript:add_user()\" style=\"cursor:pointer\">";
	echo "<font color=\"red\">没有定义</font>";
	echo "</td>\r\n</tr>\r\n";


}
echo "</table>";
echo "\r\n</body>\r\n</html>\r\n";
?>