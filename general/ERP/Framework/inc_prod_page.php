<?php
header("Content-type:text/html;charset=gb2312");
ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL);

// display warnings and errors
error_reporting(E_WARNING | E_ERROR);
require_once('lib.inc.php');
$url=$_GET['url'];
?>
<html >
<head>
<META http-equiv=Content-Type content="text/html; charset=gb2312">

<link rel="stylesheet" href="inc/demo.css" type="text/css">
<link rel="stylesheet" href="inc/zTreeStyle.css" type="text/css">
<script type="text/javascript" language="javascript" src="../Enginee/jquery/jquery.js"></script>
  <script type="text/javascript" src="inc/jquery.ztree-2.6.js"></script>
  <script type="text/javascript" src="inc/demoTools.js"></script>
 <SCRIPT LANGUAGE="JavaScript">

 <!--
	var zTree1;
var zNodes=new Array();
zNodes[0]={id:0,pId:-1,name:'全部产品',open:true};
<?php 


function getProdTypeList($DEPT_PARENT)
{
	global $db;
	$sql = "select rowid,name,parentid from producttype where parentid='$DEPT_PARENT' order by parentid asc ,id asc";
	$rs = $db->Execute($sql);
	$rs_a = $rs->GetArray();
	for($i=0;$i<sizeof($rs_a);$i++)			
	{
		$DEPT_ID = $rs_a[$i]['rowid'];
		$DEPT_NAME = $rs_a[$i]['name'];
		$DEPT_PARENT = $rs_a[$i]['parentid'];
		$open="false";
	
		print "zNodes[zNodes.length]={id:$DEPT_ID, pId:$DEPT_PARENT, name:'$DEPT_NAME', ename:'$DEPT_NAME', open:$open};";
		getProdTypeList($DEPT_ID);
	}
	
}

getProdTypeList(0);



?>    
var setting = {
		expandSpeed: "",
		showLine: true,
		isSimpleData: true,
		treeNodeKey: "id",
		treeNodeParentKey:"pId",
		callback:{click: zTreeOnClick}
	};

$(document).ready(function(){
	reloadTree("1");
});

var curType = '0';
var curLi;
function reloadTree(type) {
	if (curLi) curLi.removeClass("focus");
	$("#sim").attr("disabled", true);
	$("#flag").attr("disabled", true);

	var setting1 = clone(setting);
	var zNodes1 = clone(zNodes);


	if (!type) type = (curType=='0') ? '1' : curType;
	
	if (type=="1") {
		setting1.showLine = true;
		curLi = $("#defaultStyle");
		
	} else if (type=="2") {
		setting1.showLine = false;
		curLi = $("#noLineStyle");
		
	} else if (type=="3") {
		setting1.showLine = true;
		zNodes1[0].iconOpen = "demoStyle/img/phone.gif";
		zNodes1[0].iconClose = "demoStyle/img/people.gif";
		zNodes1[2].icon = "demoStyle/img/home.gif";
		zNodes1[1].nodes[0].icon = "demoStyle/img/hardware.gif";
		zNodes1[1].nodes[2].icon = "demoStyle/img/people.gif";
	
		curLi = $("#diyIconStyle");
	} else if (type=="5") {
		setting1.showIcon = false;
		curLi = $("#noIconStyle");}

	curLi.addClass("focus");
	curType = type;
	zTree1 = $("#treeDemo").zTree(setting1, zNodes1);
	
}

function zTreeOnClick(event, treeId, treeNode)
{
	if(treeNode.id==0)
		parent.edu_main.location="../Interface/JXC/<?php echo $url?>.php";
	else
		parent.edu_main.location="../Interface/JXC/<?php echo $url?>.php?FF=FF&producttype="+treeNode.id;
	
}
//-->
  </SCRIPT>
  
 </HEAD>
<BODY>

<TABLE border=0 width="100%" >
	<TR>
		<TD width=100% align=center valign=top>
		<div>
			<ul id="treeDemo" class="tree"></ul>
		</div>		
		</TD>
		
	</TR>
</TABLE>

 </BODY>
</html>