<?php
ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL);

// display warnings and errors
error_reporting(E_WARNING | E_ERROR);

require_once('lib.inc.php');

$GLOBAL_SESSION=returnsession();
require_once("systemprivateinc.php");

CheckSystemPrivate("后勤管理-固定资产-部门权限管理");


$sql = "select distinct 所属部门 from fixedasset";
$rs = $db->Execute($sql);
$rsX_a = $rs->GetArray();



$TextHeader = "固定资产分部门管理权限设置";
$PHP_SELF = "fixedasset_newai.php";


$PHP_SELF_ARRAY = explode('/',$_SERVER['PHP_SELF']);
$PHP_SELF_SELF = array_pop($PHP_SELF_ARRAY);

page_css($TextHeader);


if($_GET['FileNameSELF']!="")						{
	echo " <html> <head> <title>权限管理</title>
	<meta http-equiv=\"Content-Type\" content=\"text/html; charset=gb2312\">
	</head>  <body class=\"bodycolor\" topmargin=\"5\">  ";
	$sql = "select * from systemprivateinc where `FILE`='".$_GET['FileName']."' and `MODULE`='".$_GET['ModuleName']."'";
	$rs = $db->Execute($sql);
	$rs_a = $rs->GetArray();
	$PRIV_DEPT  = $rs_a[0]['DEPT_ID'];
	$PRIV_ROLE  = $rs_a[0]['ROLE_ID'];
	$PRIV_USER  = $rs_a[0]['USER_ID'];
	$PRIV_DEPT_NAME  = $rs_a[0]['DEPT_NAME'];
	$PRIV_ROLE_NAME  = $rs_a[0]['ROLE_NAME'];
	$PRIV_USER_NAME  = $rs_a[0]['USER_NAME'];
	echo " <table border=\"0\" width=\"100%\" cellspacing=\"0\" cellpadding=\"3\" class=\"small\">
	<tr>
	<td class=\"small\">
	<img src=\"/images/edit.gif\" WIDTH=\"22\" HEIGHT=\"20\" align=\"absmiddle\">
	<span class=\"big3\"> 指定权限</span> ";
	echo "本模块子菜单默认条件下所有用户都可访问,设定可访问人员或范围以后只被允许访问人员可访问";
	echo "
	</td>
	</tr>
	</table>
	<table class=\"TableBlock\" width=\"100%\" align=\"center\">
	<form action=\"?action=DataDeal\"  method=\"post\" name=\"form1\">
	<tr>
	<td nowrap class=\"TableContent\"\" align=\"center\">授权范围：<br>（人员）</td>
	<td class=\"TableData\">
	<input type=\"hidden\" name=\"COPY_TO_ID\" value=\"";
	echo $PRIV_USER;
	echo "\">
	<textarea cols=40 name=\"COPY_TO_NAME\" rows=6 class=\"BigStatic\" wrap=\"yes\" readonly>";
	echo $PRIV_USER_NAME;
	echo "</textarea>
	&nbsp;
	<input type=\"button\" value=\"添 加\" class=\"SmallButton\" onClick=\"SelectUser('','COPY_TO_ID','COPY_TO_NAME')\" title=\"选择人员\" name=\"button\">   &nbsp;
	<input type=\"button\" value=\"清 空\" class=\"SmallButton\" onClick=\"ClearUser('COPY_TO_ID','COPY_TO_NAME')\" title=\"清空人员\" name=\"button\">
	</td>
	</tr>
	<tr>
	<td nowrap  class=\"TableControl\" colspan=\"2\" align=\"center\">
	<input type=\"hidden\" name=\"DISK_ID\" value=\"";
	echo $DISK_ID;
	echo "\">

	<input type=\"hidden\" name=\"ModuleName\" value=\"".$_GET['ModuleName']."\"/>
	<input type=\"hidden\" name=\"FileName\" value=\"".$_GET['FileName']."\"/>
	<input type=\"hidden\" name=\"FileNameSELF\" value=\"".$_GET['FileNameSELF']."\"/>
	<input type=\"hidden\" name=\"FIELD_NAME\" value=\"";
	echo $FIELD_NAME;
	echo "\">
	<input type=\"submit\" value=\"确定\" class=\"BigButton\">&nbsp;&nbsp;
	</td>
	</form>
	</table>
	</body>
	</html> ";
	exit;
}


if($_GET['action']=='DataDeal')					{
	$FILE = $_POST['FileName'];
	$MODULE = $_POST['ModuleName'];
	$DEPT_ID = $_POST['TO_ID'];
	$DEPT_NAME = $_POST['TO_NAME'];
	$USER_ID = $_POST['COPY_TO_ID'];
	$USER_NAME = $_POST['COPY_TO_NAME'];
	$ROLE_ID = $_POST['PRIV_ID'];
	$ROLE_NAME = $_POST['PRIV_NAME'];
	$FileNameSELF = $_POST['FileNameSELF'];

	//print_R($_POST);exit;

	$sql = "select MODULE from systemprivateinc where `FILE`='$FILE' and `MODULE`='$MODULE'";
	$rs = $db->Execute($sql);
	$rs_a = $rs->GetArray();
	//print_R($cursor1);exit;
    $MODULE2 = TRIM($rs_a[0]['MODULE']);
	//print $MODULE2;
	if($MODULE2!="")		{
		$sql = "update systemprivateinc set `DEPT_ID`='$DEPT_ID',`USER_ID`='$USER_ID',`ROLE_ID`='$ROLE_ID',`DEPT_NAME`='$DEPT_NAME',`USER_NAME`='$USER_NAME',`ROLE_NAME`='$ROLE_NAME' where `FILE`='$FILE' and `MODULE`='$MODULE'";
	}
	else	{
		$sql = "insert into systemprivateinc values('','$FILE','$MODULE','$DEPT_ID','$DEPT_NAME','$ROLE_ID','$ROLE_NAME','$USER_ID','$USER_NAME')";
	}
	$db->Execute($sql);

	print_infor("您的配置已经完成",'',"location='?'","?");
	exit;

}


table_begin("100%");
print "<tr class=TableHeader><td colspan=5>&nbsp;".$TextHeader."</td></tr>";
print "<tr class=TableHeader><td>&nbsp;所属部门</td><td>&nbsp;编辑权限</td><td>&nbsp;管理人员</td></tr>";

for($i=0;$i<sizeof($rsX_a);$i++)			{
	$部门名称  = $rsX_a[$i]['所属部门'];
	$sql = "select * from systemprivateinc where MODULE='".$部门名称."' and FILE='$PHP_SELF'";
	$rs = $db->Execute($sql);
	$rs_a = $rs->GetArray();
	if($部门名称!="")			{
		print "<tr class=TableData><td>&nbsp;".$部门名称."</td><td><a href=\"?".base64_encode("FileNameSELF=".$PHP_SELF_SELF."&FileName=".$PHP_SELF."&ModuleName=".$部门名称."")."\">&nbsp;编辑权限</a></td>
			<td>&nbsp;".$rs_a[0]['USER_NAME']."</td>
			</tr>";
	}
}
table_end();
print "<BR>";
table_begin("100%");
print "<tr class=TableHeader><td>事项说明:</td></tr>";
print "<tr class=TableData><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;每个部门指定一个管理员,那么这个管理员可以在'部门级管理'这个菜单中管理对应所属部门的相关信息;这个功能适用于分部门权限管理情形.</td></tr>";
table_end();
?>