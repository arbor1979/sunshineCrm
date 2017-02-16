<?php
session_start();
header("Content-type:text/html;charset=gb2312");
ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL);
require_once( "../../../config.inc.php" );

// display warnings and errors
error_reporting( E_ALL & ~E_NOTICE);
$TO_ID=$_GET["TO_ID"];
$TO_NAME=$_GET["TO_NAME"];
?>

<link rel="stylesheet" href="<?php echo ROOT_DIR?>general/ERP/Framework/inc/demo.css" type="text/css">
<link rel="stylesheet" href="<?php echo ROOT_DIR?>general/ERP/Framework/inc/zTreeStyle.css" type="text/css">
<script type="text/javascript" language="javascript" src="<?php echo ROOT_DIR?>general/ERP/Enginee/jquery/jquery.js"></script>
  <script type="text/javascript" src="<?php echo ROOT_DIR?>general/ERP/Framework/inc/jquery.ztree-2.6.js"></script>
  <SCRIPT LANGUAGE="JavaScript">
  <!--
	var zTree1;
	var setting;

	setting = {
		keepParent: true,
		keepLeaf: true,
		async: true,
//		asyncUrl: "asyncData/node.jsp",
		asyncUrl: "node.php",  
		asyncParam: ["name", "id"],
		callback: {
			click: zTreeOnClick
		}
	};

	$(document).ready(function(){
		
		refreshTree();
	});

	function zTreeOnClick(event, treeId, treeNode)
	{
		if(!treeNode.isParent)
			addProduct(treeNode.id,treeNode.name);
			//parent.edu_main.location="../Interface/Framework/user_newai.php?FF=FF&DEPT_ID="+treeNode.id;
		
	}

	function refreshTree() {
	
		zTree1 = $("#treeDemo").zTree(setting);
	}

  //-->
  </SCRIPT>

<script Language="JavaScript">
var userAgent = navigator.userAgent.toLowerCase();
var is_moz = (navigator.product == 'Gecko') && userAgent.substr(userAgent.indexOf('firefox') + 8, 3);
function getOpenner()
{
   if(parent.dialogArguments==null)
   {
      return parent.opener.document;
   }
   else
      return parent.dialogArguments.document;
}
var parent_window = getOpenner();

function addProduct(pid,pname) {
		parent_window.form1.<?php echo $TO_ID?>.value=pid;
		parent_window.form1.<?php echo $TO_NAME?>.value=pname;
		window.close();

}

</script>
<?php require_once("prod_top.php");?>
<div align=left  style="margin: 10px;">
方法二：通过类别选择:
<div>
			<ul id="treeDemo" class="tree"  style="overflow-x:hidden"></ul>
		</div>	
</div>