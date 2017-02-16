<?php
//######################教育组件-权限较验部分##########################
SESSION_START();
require_once("lib.inc.php");
$GLOBAL_SESSION=returnsession();
require_once("systemprivateinc.php");
////CheckSystemPrivate("数字化校园系统设置-数字化校园权限");
//######################教育组件-权限较验部分##########################
if($_GET['action']=="")			{
	page_css("我的个人参数设置");
	print "<FORM name=form1  action=\"?action=DataDeal&pageid=1\" method=post encType=multipart/form-data>";
	table_begin("80%");
	print "<tr class=TableHeader><td colspan=2>&nbsp;我的邮箱设置</td></tr>";
	print "<tr class=TableData><td width=40%>&nbsp;SMTP服务器:</td><td>&nbsp;<INPUT type=text class=SmallInput maxLength=50  name=SMTPServerIP value='".$_SESSION[SMTPServerIP]."'  ></td></tr>";
	print "<tr class=TableData><td width=40%>&nbsp;邮件地址:</td><td>&nbsp;<INPUT type=text class=SmallInput maxLength=50  name=EmailAddress value='".$_SESSION[EmailAddress]."'  ></td></tr>";
	print "<tr class=TableData><td width=40%>&nbsp;密码:</td><td>&nbsp;<INPUT type=password class=SmallInput maxLength=50  name=EmailPassword value='".$_SESSION[EmailPassword]."'  ></td></tr>";	
	print "<tr class=TableHeader><td colspan=2>&nbsp;我的桌面设置</td></tr>";
	print "<tr class=TableData><td width=40%>左侧:<ul>";
	$sql = "select * from crm_mytable where 模块位置='左边'  order by 模块编号 ASC";
	$rs = $db->Execute($sql);
	$rs_a = $rs->GetArray();
	$leftSelArray=explode(",", $_SESSION['LEFT_MENU']);
	$rightSelArray=explode(",", $_SESSION['RIGHT_MENU']);
	foreach ($rs_a as $row)
	{
		$check="";
		if(in_array($row['编号'], $leftSelArray))
			$check="checked";
		if(in_array($row['编号'], $rightSelArray))
			$check="checked";
		print "<li style='list-style:none;'><input type=checkbox id='".$row['编号']."' name='leftmenu[]' value='".$row['编号']."' $check><label for='".$row['编号']."'>".$row['备注']."</label></li>";
	}
	print "</ul></td><td>右侧:<ul>";
	$sql = "select * from crm_mytable where 模块位置='右边'  order by 模块编号 ASC";
	$rs = $db->Execute($sql);
	$rs_a = $rs->GetArray();
	foreach ($rs_a as $row)
	{
		$check="";
		if(in_array($row['编号'], $leftSelArray))
			$check="checked";
		if(in_array($row['编号'], $rightSelArray))
			$check="checked";
		print "<li style='list-style:none;'><input type=checkbox id='".$row['编号']."' name='rightmenu[]' value='".$row['编号']."' $check><label for='".$row['编号']."'>".$row['备注']."</label></li>";
	}
	print "</ul></td></tr>";
	print_submit("提交");
	table_end();
	
	form_end();
	print "<BR>";
	table_end();
	exit;
}

if($_GET['action']=="DataDeal"){
	global $db;
	$leftmenu=join(",", $_POST['leftmenu']);
	$rightmenu=join(",", $_POST['rightmenu']);
	$sql = "update user set SMTPServerIP='".$_POST[SMTPServerIP]."',EmailAddress='".$_POST[EmailAddress]."',EmailPassword='".$_POST[EmailPassword]."',leftmenu='$leftmenu',rightmenu='$rightmenu' where UID=".$_SESSION[LOGIN_UID];
	$db->Execute($sql);

	$_SESSION[SMTPServerIP]= $_POST[SMTPServerIP];
	$_SESSION[EmailAddress]= $_POST[EmailAddress];
	$_SESSION[EmailPassword]= $_POST[EmailPassword];
	$_SESSION['LEFT_MENU']=$leftmenu;
	$_SESSION['RIGHT_MENU']=$rightmenu;
	page_css("我的个人参数设置");
	print_infor("修改成功!",'trip',"?",'my_config.php',1);
	exit;
}
?>
<?php
/*
	版权归属:郑州单点科技软件有限公司;
	联系方式:0371-69663266;
	公司地址:河南郑州经济技术开发区第五大街经北三路通信产业园四楼西南;
	公司简介:郑州单点科技软件有限公司位于中国中部城市-郑州,成立于2007年1月,致力于把基于先进信息技术（包括通信技术）的最佳管理与业务实践普及到教育行业客户的管理与业务创新活动中，全面提供具有自主知识产权的教育管理软件、服务与解决方案，是中部最优秀的高校教育管理软件及中小学校管理软件提供商。目前己经有多家高职和中职类院校使用通达中部研发中心开发的软件和服务;

	软件名称:单点科技软件开发基础性架构平台,以及在其基础之上扩展的任何性软件作品;
	发行协议:数字化校园产品为商业软件,发行许可为LICENSE方式;单点CRM系统即SunshineCRM系统为GPLV3协议许可,GPLV3协议许可内容请到百度搜索;
	特殊声明:软件所使用的ADODB库,PHPEXCEL库,SMTARY库归原作者所有,余下代码沿用上述声明;
	*/
?>