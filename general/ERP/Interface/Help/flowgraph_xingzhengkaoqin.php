<?php
require_once("lib.inc.php");
$GLOBAL_SESSION=returnsession();
page_css("��������-����˵��");
?>
<link rel="stylesheet" type="text/css" href="/theme/<?=$_SESSION['LOGIN_THEME']?>/style.css">
<html>
<head>
<title>����˵��</title>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
</head>

<body class="bodycolor">


<?php

$PrintText  = "<table  class=TableBlock align=center width=100%>";
$PrintText .= "<TR class=TableHeader><td ><font color=green >
�������ڲ���ʵʩ�ض��ֲ�(����ͼ�Լ�������˵��)
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

//������˵��ע��
require_once("../Help/module_xingzhengdepartment.php");

?>
