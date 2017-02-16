<?php
	ini_set('display_errors', 1);
	ini_set('error_reporting', E_ALL);
	error_reporting(E_WARNING | E_ERROR);
	require_once('lib.inc.php');
	$GLOBAL_SESSION=returnsession();

if($_GET['action']=="DataDealDelte")			{
	page_css("删除信息");
	$开始时间 = $_POST['开始时间']." 01:01:01";
	$结束时间 = $_POST['结束时间']." 23:59:59";
	$sql = "delete from system_logall where 当前时间>='$开始时间' and 当前时间<='$结束时间'";
	$db->Execute($sql);
	//print $sql;exit;
	优化数据表("system_logall");
	print_infor("您的操作己经完成,请返回...",'',"location='?'","?");
	exit;
}

	//数据表模型文件,对应Model目录下面的system_logall_newai.ini文件
	//如果是需要复制此模块,则需要修改$parse_filename参数的值,然后对应到Model目录 新文件名_newai.ini文件
	$filetablename		=	'system_logall';
	$parse_filename		=	'system_logall';
	require_once('include.inc.php');



//print_R($_SESSION);
$总角色数组 = explode(',',$_SESSION['LOGIN_USER_PRIV'].",".$_SESSION['LOGIN_USER_PRIV_OTHER']);
if(			$_GET['action']=="init_default"
			&&in_array('1',$总角色数组)
			&&$_GET['actionadv']!="exportadv_default"
			)			{
	print "<SCRIPT>
	function td_calendar(fieldname) {
		myleft=document.body.scrollLeft+event.clientX-event.offsetX-80;
		mytop=document.body.scrollTop+event.clientY-event.offsetY+140;
		window.showModalDialog(fieldname,self,\"edge:raised;scroll:0;status:0;help:0;resizable:1;dialogWidth:280px;dialogHeight:200px;dialogTop:\"+mytop+\"px;dialogLeft:\"+myleft+\"px\");
		}
	</SCRIPT>";
	print "<FORM name=form1 action=\"?action=DataDealDelte&pageid=1\" method=post encType=multipart/form-data>";
	print "<table class=TableBlock width=100%>";
	print "<tr class=TableContent><td>
		&nbsp;<font color=green>按操作时间进行删除记录
	开始时间: <INPUT class=SmallInput maxLength=20  name=开始时间 value=\"".date("Y-m-d",mktime(1,1,1,date('m')-1,date('d'),date('Y')))."\"  >
	<input type=\"button\"  title=''  value=\"选择\" class=\"SmallButton\" onclick=\"td_calendar('../../Framework/sms_index/calendar_begin.php?datetime=开始时间');\" title=\"选择\" name=\"button\">
	结束时间:<INPUT class=SmallInput maxLength=20  name=结束时间 value=\"".date("Y-m-d",mktime(1,1,1,date('m'),date('d'),date('Y')))."\"  >
	<input type=\"button\"  title=''  value=\"选择\" class=\"SmallButton\" onclick=\"td_calendar('../../Framework/sms_index/calendar_begin.php?datetime=结束时间');\" title=\"选择\" name=\"button\">
	<input type=submit class=SmallButton name='提交' value='提交'>
	</font>
		</td></tr>";
	print "</table>";
	print "</FORM>";
}

	?>