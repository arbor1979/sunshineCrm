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
<script src="../../../../../inc/js/ccorrect_btn.js"></script>
<?php

echo "\n<script Language=\"JavaScript\">\r\nvar parent_window = parent.dialogArguments;\r\n";
if ( $TO_ID == "" || $TO_ID == "undefined" )
{
	$TO_ID = "TO_ID";
	$TO_NAME = "TO_NAME";
}
if ( $FORM_NAME == "" || $FORM_NAME == "undefined" )
{
	$FORM_NAME = "form1";
}
echo "\r\nfunction clear_user()\r\n{\r\n    parent_window.";
echo $FORM_NAME;
echo ".";
echo $TO_ID;
echo ".value=\"\";\r\n    parent_window.";
echo $FORM_NAME;
echo ".";
echo $TO_NAME;
echo ".value=\"\";\r\n}\r\n\r\n</script>\r\n</head>\r\n\r\n<body class=\"bodycolor\"  topmargin=\"0\" leftmargin=\"0\">\r\n\r\n<table border=\"0\" cellspacing=\"1\" width=\"100%\" class=\"small\"  cellpadding=\"2\" align=\"center\">\r\n   <tr>\r\n     <td nowrap align=\"right\">\r\n     \t<input type=\"button\" class=\"SmallButton\" value=\"�� ��\" onclick=\"clear_user();\">&nbsp;&nbsp;\r\n     \t<input type=\"button\" class=\"SmallButton\" value=\"�� ��\" onclick=\"window.close();\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\r\n     </td>\r\n   </tr>\r\n</table>\r\n\r\n</body>\r\n</html>\r\n";
?>
