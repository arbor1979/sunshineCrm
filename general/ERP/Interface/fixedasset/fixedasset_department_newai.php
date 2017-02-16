<?php
	require_once("lib.inc.php");

	$GLOBAL_SESSION=returnsession();
	require_once("systemprivateinc.php");

	//CheckSystemPrivate("后勤管理-固定资产-部门级管理");

	$common_html=returnsystemlang('common_html');

	if($_GET['action']=="")		{
		$sql = "update fixedasset set 所属状态='购置未分配' where 所属状态=''";
		$db->Execute($sql);
		$sql = "update fixedasset set 金额=单价*数量";
		$db->Execute($sql);
	}



	//###########################################
	//较验分部门管理权限部分
	//###########################################
	$SCRIPT_NAME	= "fixedasset_newai.php";
	$LOGIN_USER_ID		= $_SESSION['LOGIN_USER_ID'];
	$sql = "select * from systemprivateinc where `FILE`='$SCRIPT_NAME'  and (USER_ID like '%,".$LOGIN_USER_ID.",%' or USER_ID like '".$LOGIN_USER_ID.",%')";
	$rs = $db->Execute($sql);
	$rs_a = $rs->GetArray();
	$MODULE_ARRAY = array();
	for($i=0;$i<sizeof($rs_a);$i++)		{
		$MODULE_ARRAY[] = $rs_a[$i]['MODULE'];
	}
	$MODULE_TEXT = join(',',$MODULE_ARRAY);
	if($MODULE_TEXT=="")  $MODULE_TEXT = "未指定部门信息";
	//if($_GET['action']==""||$_GET['action']=="init_default")
	$_GET['所属部门'] = $MODULE_TEXT;

	$_GET['所属状态'] = "购置未分配,购置已分配,资产已分配,资产已归还";

	$filetablename='fixedasset';
	$parse_filename = 'fixedasset_department';
	require_once('include.inc.php');


	if($_GET['action']==''||$_GET['action']=='init_default')		{
	$PrintText .= "<BR><table  class=TableBlock align=center width=100%>";
	$PrintText .= "<TR class=TableContent><td ><font color=green >
固定资产部门级管理：<BR>
&nbsp;&nbsp;1、权限说明:你只能管理你所属部门的固定资产信息。<BR>
&nbsp;&nbsp;2、使用分配:管理员可以在固定资产管理中设置资产的所属部门,然后在固定资产部分权限管理菜单中分配哪个用户可以管理哪个部门的资产。<BR>

</font></td></table>";
	print $PrintText;
}

?>