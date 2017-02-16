<?php
require_once('../../../adodb/adodb.inc.php');
require_once('../../../config.inc.php');
require_once('../dbname.inc.php');
require_once('../../../setting.inc.php');
require_once('../../../adodb/session/adodb-session2.php');

$GLOBAL_SESSION=returnsession();


?>
<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<link rel="stylesheet" type="text/css" href="<?php echo ROOT_DIR?>theme/<?php echo $LOGIN_THEME?>/style.css" />
<link rel="stylesheet" type="text/css" href="<?php echo ROOT_DIR?>theme/<?php echo $LOGIN_THEME?>/menu_left.css" />
<script type="text/javascript" language="javascript" src="<?php echo ROOT_DIR?>general/ERP/Enginee/lib/common.js"></script>
<?php
echo "\r\n<script Language=\"JavaScript\">\r\n
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
\r\n";

if ( $TO_ID == "" || $TO_ID == "undefined" )
{
	$TO_ID = "TO_ID";
	$TO_NAME = "TO_NAME";
}
echo "function add_user(user_id,user_name)\r\n{\r\n  TO_VAL=parent_window.";
echo $FORM_NAME;
echo ".";
echo $TO_ID;
echo ".value;\r\n  if(TO_VAL.indexOf(\",\"+user_id+\",\")<0 && TO_VAL.indexOf(user_id+\",\")!=0)\r\n  {\r\n    parent_window.";
echo $FORM_NAME;
echo ".";
echo $TO_ID;
echo ".value=user_id;\r\n    parent_window.";
echo $FORM_NAME;
echo ".";
echo $TO_NAME;
echo ".value=user_name;\r\n  }\r\n  parent.close();\r\n}\r\n</script>\r\n</head>\r\n\r\n<body class=\"bodycolor\" topmargin=\"1\" leftmargin=\"0\" >\r\n\r\n";

if($_GET['办公用品类别']!="")		{
	$AddSql = " where 上级分类='".$_GET['办公用品类别']."'  and 上级分类!=''";

}



echo "<table class=\"TableBlock\" width=\"100%\">\r\n<tr class=\"TableHeader\">\r\n  <td align=\"center\"><b>选择办公用品</b></td>\r\n</tr>\r\n\r\n";


if($_GET['action']=="SEARCH")	{
	$KEYVALUE = $_GET['KEYVALUE'];
	$AddSql = " where 上级分类 like '%$KEYVALUE%' and 上级分类!=''";
}//print_R($_GET);


if($AddSql=="")	{
	$AddSql = " where 上级分类!=''";
}
//print $AddSql;

$sql = "select * from officeproductgroup $AddSql order by 名称";
$rs = $db->Execute($sql);
$rs_a = $rs->GetArray();
for($i=0;$i<sizeof($rs_a);$i++)			{
	$课程类别 = $rs_a[$i]['上级分类'];
	$课程名称 = $rs_a[$i]['名称'];
	$课程代码 = $rs_a[$i]['编号'];

	echo "\r\n<tr class=\"TableData\">\r\n  <td class=\"menulines\" align=\"center\" onclick=\"javascript:add_user('";
	echo $课程代码;
	echo "','";
	echo "".$课程名称."";
	echo "')\" style=\"cursor:pointer\">";
	echo "".$课程名称."";
	echo "</td>\r\n</tr>\r\n";
}

echo "</table>";
echo "\r\n</body>\r\n</html>\r\n";
?>
