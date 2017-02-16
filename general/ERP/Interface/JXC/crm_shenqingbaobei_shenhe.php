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
	$billinfo= returntablefield("crm_shenqingbaobei", "id", $billid, "customerid,linkmanid,chanceid,zhuti");
	$custname= returntablefield("customer", "rowid", $billinfo['customerid'], "supplyname");
	$linkname= returntablefield("linkman", "rowid", $billinfo['linkmanid'], "linkmanname");
	$chancename= returntablefield("crm_chance", "编号", $billinfo['chanceid'], "机会主题");
	
?>
<body class=bodycolor topMargin=5>
<table id=listtable align=center class=TableBlock width=65% border=0>
<TR><TD colspan=9 class=TableHeader height=30>&nbsp;项目报备审核</TD></TR>
</table>
<div id="shoppingcart">
<form name="form1" method="post" action="crm_shenqingbaobei_newai.php?id=<?php echo $billid?>">
<table align=center class=TableBlock width=65% border=0 id="table1" >
<tr ><td align=right class=TableData>主题:</td><td class=TableLine2><?php echo $billinfo['zhuti']?></a></td></tr>
<tr ><td align=right class=TableData>客户:</td><td class=TableLine2><a target='_blank' href='../JXC/customer_newai.php?action=view_default&ROWID=<?php echo $billinfo['customerid']?>'><?php echo $custname?></a></td></tr>
<tr ><td align=right class=TableData>联系人:</td><td class=TableLine2><a target='_blank' href='../JXC/linkman_newai.php?action=view_default&ROWID=<?php echo $billinfo['linkmanid']?>'><?php echo $linkname?></a></td></tr>
<tr ><td align=right class=TableData>机会:</td><td class=TableLine2><a target='_blank' href='../JXC/crm_chance_newai.php?action=view_default&编号=<?php echo $billinfo['chanceid']?>'><?php echo $chancename?></a></td></tr>
<tr ><td align=right class=TableData >批语:</td><td class=TableLine2><TEXTAREA class=BigInput name="piyu"  title='' wrap=yes rows=5 cols=80  ></TEXTAREA>&nbsp;</td>
</tr>
<TR><TD class=TableData noWrap>提醒人:</TD>
<TD class=TableData noWrap colspan="2">
<input type="hidden" name="tixingren" value="">
<textarea style="width:380px;" name="tixingren_ID" id="tixingren_ID" rows="3" style="overflow-y:auto;" class="BigStatic" wrap="yes" readonly></textarea><a href="javascript:;" class="orgAdd" onClick="SelectUser('1','tixingren', 'tixingren_ID');">选择</a>
<a href="#" class="orgClear" onClick="ClearUser('tixingren', 'tixingren_ID')" title="清空">清空</a></TD></TR>
<input type="hidden" name="action">
<input type="hidden" name="zhuti" value="<?php echo $billinfo['zhuti']?>">
</table>
</div>
<p align=center><input type=button value=" 同意 " class="SmallButton"  onclick="form1.action.value='TongYi';form1.submit();">
&nbsp;&nbsp;<input type=button value=" 否决 " class="SmallButton" onclick="form1.action.value='FouJue';form1.submit();">
&nbsp;&nbsp;<input type=button value=" 返回 " class="SmallButton" onclick="location='crm_shenqingbaobei_newai.php';"></p>
</form>
</body>
</html>
