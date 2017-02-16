<?php
ini_set('display_errors', 1);
	ini_set('error_reporting', E_ALL);
	error_reporting(E_WARNING | E_ERROR);
	require_once('lib.inc.php');
	$GLOBAL_SESSION=returnsession();
	page_css('物业维修服务管理说明');
?>

<html>
<head>
<title>物业维修服务管理说明</title>
</head>
<body>
<table class="TableBlock" width="100%" align="center">
     <tr align="center" class="tableContent">
		<td noWrap colspan="14" align="left">

		<font color="green" size="2">&nbsp;物业维修服务管理说明:</font><br><br>
			&nbsp;&nbsp;&nbsp;&nbsp;1 首先在报修信息里面填写信息.<br>
			&nbsp;&nbsp;&nbsp;&nbsp;2 如果报修被受理，则在报修受理表的对应单元里编辑报修受理为“是”.<br>
			&nbsp;&nbsp;&nbsp;&nbsp;3 如果修复完成，在修复确认表单里面编辑对应的维修状态为“是”，并填写报修人员，若要进行评价则在是否评价列编辑“是”.<br>
			&nbsp;&nbsp;&nbsp;&nbsp;4 有管理人员在对应的用料登记、费用结算表单里面填写.<br>
			&nbsp;&nbsp;&nbsp;&nbsp;5 进行评价时，在服务评价表单里面编辑评价类型和评价级别.
		</td>
	</tr>
</table>
</body>
</html>

