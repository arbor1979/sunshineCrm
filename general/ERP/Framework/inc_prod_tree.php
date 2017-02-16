<?php
ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL);

// display warnings and errors
error_reporting(E_WARNING | E_ERROR);


header("Content-Type: text/xml");
require_once('lib.inc.php');

$GLOBAL_SESSION=returnsession();

$DEPT_PARENT = $_GET['DEPT_ID'];
$DEPT_PARENT == "" ? $DEPT_PARENT =0 : "" ;
$PARA_URL1 = $_GET['PARA_URL1'];
$PARA_URL2 = $_GET['PARA_URL2'];
$PARA_TARGET = $_GET['PARA_TARGET'];
$DEPT_PARENT = $_GET['DEPT_ID'];
print "<?phpxml version=\"1.0\" encoding=\"gb2312\"?>\r\n";
print "<TreeNode>\r\n";
//公司名称
if($DEPT_PARENT==0)				{
	
	print "<TreeNode id=\"0\" text=\"所有类型\" Xml=\"\" img_src=\"images/endnode.gif\"
		href=\"../Interface/JXC/product_newai.php\"
		target=\"edu_main\"
		>\r\n";
}


//商品类别下面的用户数
$sql = "select producttype,COUNT(*) AS NUM  from product group by producttype";
$rs = $db->Execute($sql);
$rs_a = $rs->GetArray();
for($i=0;$i<sizeof($rs_a);$i++)			{
	$DEPT_ID	= $rs_a[$i]['producttype'];
	$NUM		= $rs_a[$i]['NUM'];
	$用户数量数组[$DEPT_ID] = "[".$NUM."个]";
}

//得到下面有以及没有有分组的部门信息
$sql = "select rowid,name,parentid from producttype where parentid='$DEPT_PARENT' order by parentid asc ,id asc";
$rs = $db->Execute($sql);
$rs_a = $rs->GetArray();
for($i=0;$i<sizeof($rs_a);$i++)			{
	$DEPT_ID = $rs_a[$i]['rowid'];
	$DEPT_NAME = $rs_a[$i]['name'];
	$DEPT_PARENT = $rs_a[$i]['parentid'];
	$sql = "select rowid,name,parentid  from producttype where parentid='$DEPT_ID' order by parentid asc ,id asc";
	$rs2 = $db->Execute($sql);
	$rs2_a = $rs2->GetArray();
	if($rs2_a[0]['rowid']!='')				{//下面有子部门
		print "<TreeNode id=\"$DEPT_ID\"
		text=\"".$DEPT_NAME."".$用户数量数组[$DEPT_ID]."\"
		img_src=\"./images/endnode.gif\"
		title=\"$DEPT_NAME\"
		Xml=\"./inc_prod_tree.php?DEPT_ID=$DEPT_ID&amp;PARA_URL1=&amp;PARA_URL2=$PARA_URL2&amp;PARA_TARGET=$PARA_TARGET&amp;PRIV_NO_FLAG=0&amp;PARA_ID=&amp;PARA_VALUE=&amp;MANAGE_FLAG=\"
		href=\"../Interface/JXC/product_newai.php?FF=FF&amp;producttype=$DEPT_ID&amp;\"
		target=\"edu_main\"
		/>\r\n";
	}
	else	
	{//下面没有子部门
		$sql = "select *  from product where producttype='$DEPT_ID'";
		$rs2 = $db->Execute($sql);
		$rs2_a = $rs2->GetArray();
		
		if(sizeof($rs2_a)>=1)				//下面有产品
			print "<TreeNode id=\"$USER_ID\" text=\"".$DEPT_NAME."".$用户数量数组[$DEPT_ID]."\" href=\"../Interface/JXC/product_newai.php?FF=FF&amp;producttype=$DEPT_ID&amp;\" target=\"edu_main\" img_src=\"images/ts.gif\" title=\"$DEPT_NAME\"/>\r\n";
		else 
			print "<TreeNode id=\"$USER_ID\" text=\"".$DEPT_NAME."".$用户数量数组[$DEPT_ID]."\" href=\"../Interface/JXC/product_newai.php?FF=FF&amp;producttype=$DEPT_ID&amp;\" target=\"edu_main\" img_src=\"images/endnode.gif\" title=\"$DEPT_NAME\"/>\r\n";
	}

}

print "</TreeNode>\r\n";
if($DEPT_PARENT==0)				{
print "</TreeNode>\r\n";
}
?>