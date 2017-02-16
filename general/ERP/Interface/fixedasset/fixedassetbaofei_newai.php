<?php

	require_once('lib.inc.php');



	$GLOBAL_SESSION=returnsession();
	require_once("systemprivateinc.php");

	CheckSystemPrivate("后勤管理-固定资产-操作明细");



if($_GET['action']=="add_default_data")		{
	page_css('报废');
	$资产编号 = $_POST['资产编号'];
	$资产名称 = $_POST['资产名称'];
	$报废申请人 = $_POST['报废申请人'];
	if($_POST['批准人']!=""&&$_POST['报废申请人']!="")	{
		$_POST['单价'] = returntablefield("fixedasset","资产编号",$资产编号,"单价");
		$_POST['数量'] = returntablefield("fixedasset","资产编号",$资产编号,"数量");
		$_POST['金额'] = returntablefield("fixedasset","资产编号",$资产编号,"金额");
		$sql = "update fixedasset set 使用人员='$报废申请人',所属状态='资产已报废' where 资产编号='$资产编号'";
		$db->Execute($sql);
		//print $sql;
	}
	else			{
		$SYSTEM_SECOND = 1;
		print_infor("批准人或借领人为空,您的操作没有执行成功!",$infor='该参数新版本没有被使用',$return="location='fixedasset_newai.php'",$indexto='fixedasset_newai.php');
		exit;
	}
}

	//$_GET['action']=="init_default"||$_GET['action']==""
	if(0)		{
		//$sql = "update fixedasset set 所属状态='购置已分配' where 所属状态='资产已报废'";
		//$db->Execute($sql);
		$sql = "select * from fixedassetbaofei";
		$rs = $db->Execute($sql);
		$rs_a = $rs->GetArray();
		for($i=0;$i<sizeof($rs_a);$i++)		{
			$资产编号 = $rs_a[$i]['资产编号'];
			$编号 = $rs_a[$i]['编号'];
			$单价 = returntablefield("fixedasset","资产编号",$资产编号,"单价");
			$数量 = returntablefield("fixedasset","资产编号",$资产编号,"数量");
			$金额 = $单价*$数量;
			$sql = "update fixedassetbaofei set 金额='$金额',数量='$数量',单价='$单价' where 编号='$编号'";
			$db->Execute($sql);
			//print $sql."<BR>";;
			$sql = "update fixedasset set 所属状态='资产已报废' where 资产编号='$资产编号'";
			$db->Execute($sql);
			//print $sql."<BR>";;
		}
	}



	//exit;

	$filetablename='fixedassetbaofei';

	require_once('include.inc.php');

	if($_GET['action']==''||$_GET['action']=='init_default'||$_GET['action']=='init_customer')		{
		$PrintText .= "<BR><table  class=TableBlock align=center width=100%>";
		$PrintText .= "<TR class=TableContent><td ><font color=green >

	注意：<BR>
	&nbsp;&nbsp;①此部分只是记录资产进行报废时产生的状态信息。<BR>
	&nbsp;&nbsp;②如果您在固定资产导入或直接修改固定资产的状态信息为报废状态时则不会产生此信息。
	</font></td></table>";
		print $PrintText;
	}
	?>