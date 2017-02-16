<?php
header("Content-type:text/html;charset=gb2312");
require_once('../../../adodb/adodb.inc.php');
require_once('../../../config.inc.php');
require_once('../../../setting.inc.php');
require_once('../../../adodb/session/adodb-session2.php');

$GLOBAL_SESSION=returnsession();


if ( $TO_ID == "" || $TO_ID == "undefined" )
{
    $TO_ID = "TO_ID";
    $TO_NAME = "TO_NAME";
}
if ( $PRIV_OP == "undefined" )
{
    $PRIV_OP = "";
}
if($FORM_NAME=="" || $FORM_NAME=="undefined")
	$FORM_NAME="form1";
?>
<html>
<head>
<title>选择产品类别</title>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<link rel="stylesheet" href="<?php echo ROOT_DIR?>general/ERP/Framework/inc/demo.css" type="text/css">
<link rel="stylesheet" href="<?php echo ROOT_DIR?>general/ERP/Framework/inc/zTreeStyle.css" type="text/css">
<script type="text/javascript" language="javascript" src="<?php echo ROOT_DIR?>general/ERP/Enginee/jquery/jquery.js"></script>
<script type="text/javascript" language="javascript" src="<?php echo ROOT_DIR?>general/ERP/Enginee/lib/common.js"></script>
  <script type="text/javascript" src="<?php echo ROOT_DIR?>general/ERP/Framework/inc/jquery.ztree-2.6.js"></script>
  <script type="text/javascript" src="<?php echo ROOT_DIR?>general/ERP/Framework/inc/demoTools.js"></script>

<script Language="JavaScript">
var $$ = jQuery.noConflict();
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

var curvalue='';
if(parent_window.<?php echo $FORM_NAME?>.<?php echo $TO_ID?>.value!='')
	curvalue=parent_window.<?php echo $FORM_NAME?>.<?php echo $TO_ID?>.value;

var zTree1;
var zNodes=new Array();
zNodes[0]={id:0,pId:-1,name:'全部产品',open:true};

<?php
		function getProdTypeList($DEPT_PARENT)
		{
			global $db;
			$sql = "select rowid,name,parentid from producttype where parentid='$DEPT_PARENT'";
			//只能选择目录
			if ($_GET['MANAGE_FLAG']=="1")
		    	$sql.=" and rowid not in (select distinct producttype from product)";
			$sql.=" order by parentid asc ,id asc";
		    
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

$$(document).ready(function(){
	reloadTree("1");
});

var curType = '0';
var curLi;
function reloadTree(type) {
	if (curLi) curLi.removeClass("focus");
	$$("#sim").attr("disabled", true);
	$$("#flag").attr("disabled", true);

	var setting1 = clone(setting);
	var zNodes1 = clone(zNodes);


	if (!type) type = (curType=='0') ? '1' : curType;
	
	if (type=="1") {
		setting1.showLine = true;
		curLi = $$("#defaultStyle");
		
	} else if (type=="2") {
		setting1.showLine = false;
		curLi = $$("#noLineStyle");
		
	} else if (type=="3") {
		setting1.showLine = true;
		zNodes1[0].iconOpen = "demoStyle/img/phone.gif";
		zNodes1[0].iconClose = "demoStyle/img/people.gif";
		zNodes1[2].icon = "demoStyle/img/home.gif";
		zNodes1[1].nodes[0].icon = "demoStyle/img/hardware.gif";
		zNodes1[1].nodes[2].icon = "demoStyle/img/people.gif";
	
		curLi = $$("#diyIconStyle");
	} else if (type=="5") {
		setting1.showIcon = false;
		curLi = $$("#noIconStyle");}

	curLi.addClass("focus");
	curType = type;
	zTree1 = $$("#treeDemo").zTree(setting1, zNodes1);
	<?php 
	if($_GET['MODULE_ID']!='')
		print "var selNode=zTree1.getNodeByParam('id',".$_GET['MODULE_ID'].",null);zTree1.selectNode(selNode,false);";
	?>
}

function zTreeOnClick(event, treeId, treeNode)
{
	
	//if(treeNode.id==0)
	//	parent.edu_main.location="../Interface/JXC/<?php echo $url?>.php";
	//else
	//	parent.edu_main.location="../Interface/JXC/<?php echo $url?>.php?FF=FF&producttype="+treeNode.id;

<?php 
	if ($_GET['MANAGE_FLAG']=="2")//只能选择终端节点
		echo "if(treeNode.isParent) return;\n";

	if ($_GET['MANAGE_FLAG']=="3")//下拉框弹出类列筛选窗口
	{
?>
	
	var catlist=parent_window.<?php echo $FORM_NAME?>.<?php echo $TO_ID?>;
	
	if(treeNode.id>0)
	{
		var op =parent_window.createElement('OPTION');
		catlist.options.add(op);
		op.innerText = treeNode.name;
		op.value=treeNode.id;
		op.selected=true;
	}
	else
	{
		catlist.selectedIndex=0;
	}
	if(document.all) 
	{
	    //IE
		catlist.fireEvent("onchange");  
	  } else { 
	    //FireFox
	       var   evt=document.createEvent('HTMLEvents');  
	       evt.initEvent('change',true,true);  
	       catlist.dispatchEvent(evt);  
	  }
	  window.close();
	  return;
<?php 
	}?>
	if(treeNode.id>0)
	{

		parent_window.<?php echo $FORM_NAME?>.<?php echo $TO_ID?>.value=treeNode.id;
		parent_window.<?php echo $FORM_NAME?>.<?php echo $TO_NAME?>.value=treeNode.name;
		window.close();
	}
}
</script>
</head>
<body topmargin="1" leftmargin="0" class="bodycolor">
<TABLE border=0 width="100%" >
	<TR>
		<TD width=80% align=left valign=top>
		<div>
			<ul id="treeDemo" class="tree"></ul>
		</div>		
		</TD>
		
	</TR>
</TABLE>
</body>
</html>
