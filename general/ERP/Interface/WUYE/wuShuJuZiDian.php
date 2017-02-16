<?php
    ini_set('display_errors', 1);
	ini_set('error_reporting', E_ALL);
	error_reporting(E_WARNING | E_ERROR);
	require_once('lib.inc.php');
	$GLOBAL_SESSION=returnsession();
	page_css('数据字典管理说明');
?>

<html>
<head>
<title>数据字典管理说明</title>
</head>
<body>
<table class="TableBlock" width="100%" align="center">
     <tr align="center" class="TableContent">
		<td noWrap colspan="14" align="left">

		<font color="green" size="2">&nbsp;数据字典管理说明:</font><br><br>
			&nbsp;&nbsp;&nbsp;&nbsp;1 只有具有权限的时候才可以操作数据字典.<br>
			&nbsp;&nbsp;&nbsp;&nbsp;2 可以进行物业数据字典的更新、添加、删除等操作.<br>
		</td>
	</tr>
</table>
</body>
</html>

