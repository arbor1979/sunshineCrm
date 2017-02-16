<?php
ini_set('display_errors',1);
ini_set('error_reporting',E_ALL);
error_reporting(E_WARNING | E_ERROR);
require_once("lib.inc.php");
$GLOBAL_SESSION=returnsession();
$billid=$_GET['billid'];
page_css();
?>
<head>
<style>
.attention{
	
	border-top: 1pt none ;
	border-right: 1pt none;
	border-bottom: 1pt solid #000066;
	border-left: 1pt none;
	font-size:12pt;
	font-weight: bold;
	}
</style>


<LINK href="<?php echo ROOT_DIR?>theme/3/style.css" type=text/css rel=stylesheet>
</head>
<?php 

	$id=$_GET['id'];
	$zhuti=returntablefield("workplanmain", "id", $id, "zhuti");
?>
<body class=bodycolor topMargin=5>
<table id=listtable align=center class=TableBlock width=100% border=0>
<TR><TD colspan=9 class=TableHeader height=30>&nbsp;任务安排审核</TD></TR>
</table>
<div id="shoppingcart">
<form name="form1" method="post" action="workplanmain_newai.php?action=shenhe&id=<?php echo $id?>">
<table align=center class=TableBlock width=100% border=0 id="table1" >
<tr ><td align=center class=TableContent>编号</td><td class=TableLine2><?php echo $id?></td></tr>
<tr ><td align=center class=TableContent>主题</td><td class=TableLine2><?php echo $zhuti?> </td></tr>
<tr ><td align=center class=TableContent>审核结果</td><td class=TableLine2><?php 
print_select_single_select2('shenchastate','','workplanshenhe', 'id', 'name');
?></td></tr>
<tr ><td align=center class=TableContent>审核批示</td><td class=TableLine2>
<TEXTAREA class=BigInput name=shenhepishi  title='' wrap=yes rows=5 cols=40  ></TEXTAREA>
</td></tr>

</table>
</div>
<p align=center><input type=submit value=" 保存 " class="SmallButton" >
&nbsp;&nbsp;<input type=button value=" 返回 " class="SmallButton" onclick="location='workplanmain_newai.php';"></p>
</form>
</body>
</html>