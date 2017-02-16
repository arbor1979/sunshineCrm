<?php
ini_set('display_errors',1);
ini_set('error_reporting',E_ALL);
error_reporting(E_WARNING | E_ERROR);
require_once("lib.inc.php");
$GLOBAL_SESSION=returnsession();
$billid=$_GET['id'];
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
<?php 
print "<script type=\"text/javascript\" language=\"javascript\" src=\"".ROOT_DIR."general/ERP/Enginee/lib/common.js\"></script>";

?>

<script type="text/javascript">

</script>
<LINK href="<?php echo ROOT_DIR?>theme/3/style.css" type=text/css rel=stylesheet>
</head>
<?php 
	global $db;
	$billinfo= returntablefield("workreport", "id", $billid, "createman,workdate,content");
	$userinfo= returntablefield("user", "USER_ID", $billinfo['createman'], "UID,USER_NAME");
	
	
?>
<body class=bodycolor topMargin=5>
<table id=listtable align=center class=TableBlock width=65% border=0>
<TR><TD colspan=9 class=TableHeader height=30>&nbsp;工作报告审核</TD></TR>
</table>
<div id="shoppingcart">
<form name="form1" method="post" action="workreport_newai.php?action=shenhe_finish&id=<?php echo $billid?>">
<table align=center class=TableBlock width=65% border=0 id="table1" >
<tr ><td align=right class=TableData>工作日期:</td><td class=TableLine2><?php echo $billinfo['workdate']?></a></td></tr>
<tr ><td align=right class=TableData>提交人:</td><td class=TableLine2><a target='_blank' href='../Framework/user_newai.php?action=view_default&UID=<?php echo $userinfo['UID']?>'><?php echo $userinfo['USER_NAME']?></a></td></tr>
<tr ><td align=right class=TableData>报告内容:</td><td class=TableLine2><?php echo html_entity_decode($billinfo['content'])?></a></td></tr>
<tr ><td align=right class=TableData >批语:</td><td class=TableLine2><TEXTAREA class=BigInput name="piyu"  title='' wrap=yes rows=5 cols=80  ></TEXTAREA>&nbsp;</td>

</tr>
</table>
</div>
<p align=center><input type=submit value=" 审核 " class="SmallButton" >
&nbsp;&nbsp;<input type=button value=" 返回 " class="SmallButton" onclick="location='workreport_newai.php';"></p>
</form>
</body>
</html>
