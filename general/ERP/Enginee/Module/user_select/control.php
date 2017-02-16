<?php
session_start();

include_once( "../user_select/setting.inc.php" );
print "<META http-equiv=Content-Type content=\"text/html; charset=gb2312\">";
print "<link rel=\"stylesheet\" type=\"text/css\" href=\"".ROOT_DIR."theme/$LOGIN_THEME/style.css\" />";
echo "
<html>
<head>
<title></title>
<meta http-equiv=\"Content-Type\" content=\"text/html; charset=gb2312\">
<script type=\"text/javascript\" language=\"javascript\" src=\"../../lib/common.js\"></script>
</head>
<body class=\"bodycolor\"  topmargin=\"0\" leftmargin=\"0\">
<table border=\"0\" cellspacing=\"1\" width=\"100%\" class=\"small\"  cellpadding=\"2\" align=\"center\">
<tr>
<td nowrap align=\"right\">
<input type=\"button\" class=\"SmallButton\" value=\"关 闭\" onclick=\"parent.close();\">
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</td>
</tr>
</table>
</body>
</html> ";
?>
