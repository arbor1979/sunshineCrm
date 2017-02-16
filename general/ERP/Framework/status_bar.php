<?php
require_once('lib.inc.php');
require_once('../Enginee/newai.php');
$sessionkey=returnSessKey();
$GLOBAL_SESSION=returnsession();
$lang=returnsystemlang();
$systemlang=$_SESSION[$SUNSHINE_USER_LANG_VAR];
$common_html=returnsystemlang('common_html');
$LOGIN_THEME=$_SESSION['LOGIN_THEME'];
?>
<META http-equiv=Content-Type content="text/html; charset=gb2312">
<LINK href="../theme/3/style.css" rel=stylesheet>
<body topmargin="0" leftmargin="0" marginwidth="0" marginheight="0">
<SCRIPT language=JavaScript>


function show_mytable()
{
   parent.table_index.table_main.location=parent.table_index.table_main.location;
}


</SCRIPT>

<table width="100%" height="20" border="0" cellpadding="0" cellspacing="0" background="../theme/3/images/sb_bg.gif" class="small">
  <tr>
    <td width="6"><img src="../theme/3/images/sb_bg.gif" width="6" height="20"></td>
    <td width="85" align="left" style="cursor:pointer"></td>
	<td width="38" align="center" style="color:#ffffff;"></td>

	<td align="center" nowrap title="点击这里刷新主操作区" class="sb_center" style="CURSOR: hand" onclick="javascript:show_mytable();">
<?php

$ini_file=parse_ini_file('../Interface/Framework/system_config.ini');
$showtext=$ini_file['status_bar'];

if(file_exists('license.ini'))		{
	$SHOWTEXT = "";
}
else			{
	$SHOWTEXT = "&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"http://www.dandian.net/tdlibservice/reg.php\" target=_blank>您的软件未进行正版验证,请进行免费正版验证</a>";
}
print $showtext;

print $SHOWTEXT;
?>
	</td>
    <td width="25" align="right" > <a href="javascript:history.back()"><img src="../theme/3/images/arrow_back.gif" alt="后退" width="16" height="16" border="0"></a></td>
	<td width="25" align="right" ><a href="javascript:history.forward()"><img src="../theme/3/images/arrow_forward.gif" alt="前进" width="16" height="16" border="0"></a></td>
	<td width="25" align="right" nowrap ><a href="about.php" target="table_main" title="显示软件版权信息" ><img src="../theme/3/images/i_about.gif" alt="显示软件帮助信息" width="16" height="16" border="0"></a></td>
	<td width="6" >&nbsp;</td>

  </tr>
</table>

</body>
</html>