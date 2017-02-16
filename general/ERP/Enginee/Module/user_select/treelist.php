<?php 
include_once( "../user_select/setting.inc.php" );
?>

<link rel="stylesheet" href="<?php echo ROOT_DIR?>general/ERP/Framework/inc/demo.css" type="text/css">
<link rel="stylesheet" href="<?php echo ROOT_DIR?>general/ERP/Framework/inc/zTreeStyle.css" type="text/css">
<script type="text/javascript" language="javascript" src="<?php echo ROOT_DIR?>general/ERP/Enginee/jquery/jquery.js"></script>
  <script type="text/javascript" src="<?php echo ROOT_DIR?>general/ERP/Framework/inc/jquery.ztree-2.6.js"></script>
  <script type="text/javascript" src="<?php echo ROOT_DIR?>general/ERP/Framework/inc/demoTools.js"></script>
 <SCRIPT LANGUAGE="JavaScript">

 <!--
	var zTree1;
var zNodes=new Array();
<?php
print "zNodes[0]={id:0,pId:-1,name:'".$_SESSION['UNIT_NAME']."',open:true};";

function getProdTypeList($DEPT_PARENT)
{
	global $connection;
	$sql = "select DEPT_ID,DEPT_NAME,DEPT_PARENT from department where DEPT_PARENT='$DEPT_PARENT' order by DEPT_PARENT asc ,DEPT_NO asc";
	$cursor = exequery( $connection, $sql );
	while ( $ROW = mysql_fetch_array( $cursor ) )
	{
	
		$DEPT_ID =$ROW['DEPT_ID'];
		$DEPT_NAME =$ROW['DEPT_NAME'];
		$DEPT_PARENT = $ROW['DEPT_PARENT'];
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
		checkable: true,
		treeNodeKey: "id",
		treeNodeParentKey:"pId",
		callback:{change:zTreeOnChange}
	};

$(document).ready(function(){
	reloadTree("1");
	
});

var curType = '0';
var curLi;
function reloadTree(type) {

	var setting1 = clone(setting);
	var zNodes1 = clone(zNodes);
	var checkType = { "Y":"ps", "N":"ps"};
	setting1.checkType = checkType;
	setting1.showLine = true;

	zTree1 = $("#treeDemo").zTree(setting1, zNodes1);
	
}
function zTreeOnChange(event, treeId, treeNode) {
	var tmp = zTree1.getCheckedNodes();
	var ids='';
	for (var i=0; i<tmp.length; i++) {
		if(ids!='')
			ids=ids+',';
		ids=ids+tmp[i].id;
	}
		parent.user.location="children.php?seldeptid="+ids+"&FORM_NAME=<?php echo $FORM_NAME?>&TO_ID=<?php echo $TO_ID?>&TO_NAME=<?php echo $TO_NAME?>&MODULE_ID=<?php echo $MODULE_ID?>";
}

//-->
  </SCRIPT>



<TABLE border=0 width="100%" >
	<TR>
		<TD width=100% align=center valign=top>
		<div>
			<ul id="treeDemo" class="tree" ></ul>
		</div>		
		</TD>
		
	</TR>
</TABLE>

