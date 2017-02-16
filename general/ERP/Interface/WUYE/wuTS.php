<?php
ini_set('display_errors', 1);
	ini_set('error_reporting', E_ALL);
	error_reporting(E_WARNING | E_ERROR);
	require_once('lib.inc.php');
	$GLOBAL_SESSION=returnsession();
	page_css('物业投诉管理说明');
?>

<html>
<head>
<title>物业投诉管理说明</title>
</head>
<body>
<table class="TableBlock" width="100%" align="center">
     <tr align="center" class="tableContent">
		<td noWrap colspan="14" align="left">

		<font color="green" size="2">&nbsp;物业投诉管理说明:</font><br><br>
			  &nbsp;&nbsp;&nbsp;&nbsp;1 管理员得到投诉信息后，点击投诉受理按钮，进入受理新增模块.<br>
			  &nbsp;&nbsp;&nbsp;&nbsp;2 选择受理后，点击投诉受理模块.<br>
			  &nbsp;&nbsp;&nbsp;&nbsp;3 如果投诉处理完成，填写投诉处理结果.<br>
			  &nbsp;&nbsp;&nbsp;&nbsp;4 点击处理结果操作，进入投诉结果新增页面.<br>
			  &nbsp;&nbsp;&nbsp;&nbsp;3 将’是否受理‘选项改为’是‘，填写处理结果和处理人.<br>
			
		</td>
	</tr>
</table>
</body>
</html>

