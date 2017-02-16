<?php
ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL);

// display warnings and errors
error_reporting(E_WARNING | E_ERROR);

session_start();
require_once('lib.inc.php');



?>
<HTML>
<HEAD>
<title>关于软件</title>
<meta http-equiv="Content-Language" content="zh-cn">
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<?php
$is_win = IsWin();
if($LOGIN_THEME=="")$LOGIN_THEME = 3;
print "<LINK href=\"".ROOT_DIR."theme/$LOGIN_THEME/style.css\" rel=stylesheet>";
if(!is_file('license.ini'))		{
	print  "<META HTTP-EQUIV=REFRESH CONTENT='0;URL=register.php'>";
	exit;
}
//如果是LINUX服务器,直接指向其它页面
if($is_win==0)					{
	print  "<META HTTP-EQUIV=REFRESH CONTENT='0;URL=about2.php'>";
	exit;
}
?>

</HEAD>


<table width="715" height="1011"  border="0" cellpadding="0" align=center background='shouquanshu.php'>
<tr>
	<td colspan="2" valign="top">&nbsp;</td>
</tr>
</table>
