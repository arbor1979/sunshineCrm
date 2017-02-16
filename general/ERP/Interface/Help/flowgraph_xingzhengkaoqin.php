<?php
require_once("lib.inc.php");
$GLOBAL_SESSION=returnsession();
page_css("行政考勤-帮助说明");
?>
<link rel="stylesheet" type="text/css" href="/theme/<?=$_SESSION['LOGIN_THEME']?>/style.css">
<html>
<head>
<title>帮助说明</title>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
</head>

<body class="bodycolor">


<?php

$PrintText  = "<table  class=TableBlock align=center width=100%>";
$PrintText .= "<TR class=TableHeader><td ><font color=green >
行政考勤部分实施必读手册(流程图以及概念性说明)
</font></td></tr>";
$PrintText .= "<TR class=TableData><td >
<img src=\"flowgraph_xingzhengkaoqin.png\" border=0>
</td></tr></table>";
	print $PrintText;

require_once('../Help/module_xingzhengkaoqin.php');

require_once('../Help/module_xingzhengkaoqin_banci.php');

require_once('../Help/module_xingzhengkaoqin_paiban.php');

require_once('../Help/module_xingzhengkaoqin_yuanshidaka.php');

require_once('../Help/module_xingzhengkaoqin_datalist.php');

require_once("../Help/module_xingzhengworkflow.php");

//功能性说明注释
require_once("../Help/module_xingzhengdepartment.php");

?>
