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
	$sql = "select UNIT_NAME from unit";
	$rs = $db->Execute($sql);
	$rs_a = $rs->GetArray();
	$UNIT_NAME = $rs_a[0]['UNIT_NAME'];
	print "<TreeNode id=\"0\" text=\"$UNIT_NAME\" Xml=\"\" img_src=\"images/endnode.gif\"
		href=\"../Interface/Framework/user_newai.php\"
		target=\"edu_main\"
		>\r\n";
}


//得到部门下面的用户数
$sql = "select DEPT_ID,COUNT(*) AS NUM  from user group by DEPT_ID";
$rs = $db->Execute($sql);
$rs_a = $rs->GetArray();
for($i=0;$i<sizeof($rs_a);$i++)			{
	$DEPT_ID	= $rs_a[$i]['DEPT_ID'];
	$NUM		= $rs_a[$i]['NUM'];
	$用户数量数组[$DEPT_ID] = "[".$NUM."人]";
}

//得到下面有以及没有有分组的部门信息
$sql = "select DEPT_ID,DEPT_NAME,DEPT_PARENT from department where DEPT_PARENT='$DEPT_PARENT' order by DEPT_PARENT asc ,DEPT_NO asc";
$rs = $db->Execute($sql);
$rs_a = $rs->GetArray();
for($i=0;$i<sizeof($rs_a);$i++)			{
	$DEPT_ID = $rs_a[$i]['DEPT_ID'];
	$DEPT_NAME = $rs_a[$i]['DEPT_NAME'];
	$DEPT_PARENT = $rs_a[$i]['DEPT_PARENT'];
	$sql = "select DEPT_ID,DEPT_NAME,DEPT_PARENT from department where DEPT_PARENT='$DEPT_ID' order by DEPT_PARENT asc ,DEPT_NO asc";
	$rs2 = $db->Execute($sql);
	$rs2_a = $rs2->GetArray();
	if($rs2_a[0]['DEPT_ID']!='')				{//下面有子部门
		print "<TreeNode id=\"$DEPT_ID\"
		text=\"".$DEPT_NAME."".$用户数量数组[$DEPT_ID]."\"
		img_src=\"./images/endnode.gif\"
		title=\"$DEPT_NAME\"
		Xml=\"./inc_user_tree.php?DEPT_ID=$DEPT_ID&amp;PARA_URL1=&amp;PARA_URL2=$PARA_URL2&amp;PARA_TARGET=$PARA_TARGET&amp;PRIV_NO_FLAG=0&amp;PARA_ID=&amp;PARA_VALUE=&amp;MANAGE_FLAG=\"
		href=\"../Interface/Framework/user_newai.php?FF=FF&amp;DEPT_ID=$DEPT_ID&amp;\"
		target=\"edu_main\"
		/>\r\n";
	}
	else	{//下面没有子部门
		print "<TreeNode id=\"$USER_ID\" text=\"".$DEPT_NAME."".$用户数量数组[$DEPT_ID]."\" href=\"../Interface/Framework/user_newai.php?FF=FF&amp;DEPT_ID=$DEPT_ID&amp;\" target=\"edu_main\" img_src=\"images/endnode.gif\" title=\"$DEPT_NAME\"/>\r\n";
	}

}

//得到下面用户信息
$sql = "select USER_ID,USER_NAME,NICK_NAME from user where DEPT_ID='$DEPT_PARENT'";
$rs = $db->Execute($sql);
$rs_a = $rs->GetArray();
for($i=0;$i<sizeof($rs_a);$i++)			{
	$USER_ID	= $rs_a[$i]['USER_ID'];
	$USER_NAME	= $rs_a[$i]['USER_NAME'];
	$NICK_NAME	= $rs_a[$i]['NICK_NAME'];
	//print "<TreeNode id=\"$USER_ID\" text=\"[$NICK_NAME]\" href=\"".$PARA_URL2."?action=view_default&amp;USER_ID=$USER_ID\" target=\"$PARA_TARGET\" img_src=\"./images/node_user.gif\" title=\"$NICK_NAME\" Xml=\"../Interface/Framework/user_newai.php?FF=FF&amp;DEPT_ID=$DEPT_ID&amp;PARA_URL1=&amp;PARA_URL2=$PARA_URL2&amp;PARA_TARGET=$PARA_TARGET&amp;PRIV_NO_FLAG=0&amp;PARA_ID=&amp;PARA_VALUE=&amp;MANAGE_FLAG=\"	/>\r\n";
	//print "<TreeNode id=\"$USER_ID\" text=\"[$NICK_NAME]\" href=\"../Interface/Framework/user_newai.php?FF=FF&amp;DEPT_ID=$DEPT_PARENT&amp;\" target=\"edu_main\" img_src=\"images/node_user.gif\" title=\"$NICK_NAME\"/>\r\n";
}

print "</TreeNode>\r\n";
if($DEPT_PARENT==0)				{
print "</TreeNode>\r\n";
}
?>