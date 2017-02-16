<?php
session_start();
require_once('../../../adodb/adodb.inc.php');
require_once('../../../config.inc.php');
require_once('../../../setting.inc.php');
require_once('../../../adodb/session/adodb-session2.php');
if ( $TO_ID == "" || $TO_ID == "undefined" )
{
    $TO_ID = "TO_ID";
    $TO_NAME = "TO_NAME";
}
if ( $FORM_NAME == "" || $FORM_NAME == "undefined" )
{
    $FORM_NAME = "form1";
}
//
print "<META http-equiv=Content-Type content=\"text/html; charset=gb2312\">";
?>
<link rel="stylesheet" type="text/css" href="<?php echo ROOT_DIR?>theme/<?php echo $LOGIN_THEME?>/style.css" />
<link rel="stylesheet" type="text/css" href="<?php echo ROOT_DIR?>theme/<?php echo $LOGIN_THEME?>/menu_left.css" />
<script src="../../../../../inc/js/ccorrect_btn.js"></script>
<?php 
echo "
<html>
<head>
<title></title>
<meta http-equiv=\"Content-Type\" content=\"text/html; charset=gb2312\">
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

echo " function clear_user() {     parent_window.";
echo $FORM_NAME;
echo ".";
echo $TO_ID;
echo ".value=\"\";     parent_window.";
echo $FORM_NAME;
echo ".";
echo $TO_NAME;
echo ".value=\"\"; }
</script>
</head>
<body class=\"bodycolor\"  topmargin=\"0\" leftmargin=\"0\">
<table border=\"0\" cellspacing=\"1\" width=\"100%\" class=\"small\"  cellpadding=\"2\" align=\"center\">
<tr>
<td nowrap align=\"right\">
<input type=\"button\" class=\"SmallButton\" value=\"清 空\" onclick=\"clear_user();\">
&nbsp;&nbsp;
<input type=\"button\" class=\"SmallButton\" value=\"关 闭\" onclick=\"parent.close();\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</td>
</tr>
</table>
</body> </html> ";
?>
