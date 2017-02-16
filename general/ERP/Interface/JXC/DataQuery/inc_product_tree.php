
<link rel="stylesheet" href="<?php echo ROOT_DIR?>general/ERP/Framework/inc/demo.css" type="text/css">
<link rel="stylesheet" href="<?php echo ROOT_DIR?>general/ERP/Framework/inc/zTreeStyle.css" type="text/css">
<script type="text/javascript" language="javascript" src="<?php echo ROOT_DIR?>general/ERP/Enginee/jquery/jquery.js"></script>
  <script type="text/javascript" src="<?php echo ROOT_DIR?>general/ERP/Framework/inc/jquery.ztree-2.6.js"></script>
  <SCRIPT LANGUAGE="JavaScript">
  <!--
	var zTree1;
	var setting;
	var zNodes=new Array();
	zNodes[0]={id:0,pId:-1,name:'全部产品',open:true};

	<?php
			function getProdTypeList($DEPT_PARENT)
			{
				global $db;
				$sql = "select rowid,name,parentid from producttype where parentid='$DEPT_PARENT'";
				$sql.=" order by parentid asc ,id asc";
			    //print $sql;exit;
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
/*
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
*/
	setting = {
			expandSpeed: "",
			showLine: true,
			isSimpleData: true,
			treeNodeKey: "id",
			treeNodeParentKey:"pId",
			callback:{click: zTreeOnClick}
		};

	$(document).ready(function(){
		refreshTree();
	});

	function zTreeOnClick(event, treeId, treeNode)
	{
		//if(!treeNode.isParent)
		//	addProduct(treeNode.id,'add',3,1);
		//	parent.edu_main.location="inc_prod_picList.php?rowid=prodtype="+treeNode.id;
		//window.parent.window.frames['edu_main'].popPicList();
		parent.edu_main.popPicList(treeNode.id);
	}

	function refreshTree() {
		zTree1 = $("#treeDemo").zTree(setting,zNodes);
		
	}

  //-->
  </SCRIPT>
<div align=left  style="margin: 10px;">
方法三：通过类别选择
		<div>
			<ul id="treeDemo" class="tree"  style="overflow-x:hidden"></ul>
		</div>	
</div>		

