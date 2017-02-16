<?php
//######################教育组件-权限较验部分##########################
SESSION_START();
require_once("lib.inc.php");
$GLOBAL_SESSION=returnsession();
require_once("systemprivateinc.php");
////CheckSystemPrivate("数字化校园系统设置-数字化校园权限");
//######################教育组件-权限较验部分##########################
//print "<script type=\"text/javascript\" language=\"javascript\" src=\"".ROOT_DIR."general/ERP/Enginee/jquery/jquery.js\"></script>";

if($_GET['action']=="")			{

	page_css("我的个人参数设置");
	print "<SCRIPT language='javascript'>
	function FormCheck()
	{
		if (document.form1.新密码.value == \"\") {
			alert(\"新密码没有填写\");
			return false;
		}
		if (document.form1.确认新密码.value == \"\") {
			alert(\"确认新密码没有填写\");
			return false;
		}
		if (document.form1.确认新密码.value != document.form1.新密码.value) {
			alert(\"两次输入密码不一致\");
			return false;
		}
	}
	</SCRIPT>
	<style>
.strength0
{
 width:30px;
 background:#cccccc;
}
.strength1
{
 width:60px;
 background:#cc0000;
}
.strength2
{
 width:90px; 
 background:#3399FF;
}
.strength3
{
 width:120px;
 background:#CC33FF;
}
.strength4
{
 background:#4dcd00;
 width:150px;
}
#passwordDescription{ color:#ff0000;}
</style>

<script>
function passwordStrength(password)
{
 var desc = new Array();
 desc[0] = \"非常弱\";
 desc[1] = \"弱\";
 desc[2] = \"一般\";
 desc[3] = \"较强\";
 desc[4] = \"非常强\";

 var score   = 0;
 //if password bigger than 6 give 1 point
 if (password.length > 6) score++;
 //if password has both lower and uppercase characters give 1 point 
 if ( ( password.match(/[a-z]/) ) && ( password.match(/[A-Z]/) ) ) score++;
 //if password has at least one number give 1 point
 if (password.match(/\d+/)) score++;
 //if password has at least one special caracther give 1 point
 if ( password.match(/.[!,@,#,$,%,^,&,*,?,_,~,-,(,)]/) ) score++;
 //if password bigger than 12 give another 1 point
 //if (password.length > 12) score++;
  document.getElementById(\"passwordDescription\").innerHTML = desc[score];
  document.getElementById(\"passwordStrength\").className = \"strength\" + score;
}
</script>
	";
	print "<FORM name=form1 onsubmit=\"return FormCheck();\"  action=\"?action=DataDeal&pageid=1\" method=post encType=multipart/form-data>";
	table_begin("80%");
	print "<tr class=TableHeader><td colspan=2>&nbsp;我的密码修改</td></tr>";
	print "<tr class=TableData><td width=40%>&nbsp;原密码:</td><td>&nbsp;<INPUT type=password class=SmallInput maxLength=20  name=原密码 value=\"\"  >&nbsp;(输入你的原密码)</td></tr>";
	print "<tr class=TableData><td width=40%>&nbsp;新密码:</td><td>&nbsp;<INPUT type=password class=SmallInput maxLength=20  name=新密码 value=\"\"  onKeyUp='passwordStrength(this.value)' >&nbsp;(至少六位字母或数字)</td></tr>";
	print "<tr class=TableData><td width=40% align=right>&nbsp;密码强度:</td><td>&nbsp;<span style='width:150px;background:#eee;'><span id='passwordStrength' class='strength0'></span></span>&nbsp;<span id='passwordDescription'></span></td></tr>";
	print "<tr class=TableData><td width=40%>&nbsp;确认新密码:</td><td>&nbsp;<INPUT type=password class=SmallInput maxLength=20  name=确认新密码 value=\"\"  >&nbsp;(至少六位字母或数字)</td></tr>";
/*
if (CRYPT_STD_DES == 1) { echo "Standard DES: ".crypt("admin")."\n<br />";
} else { echo "Standard DES 不支持.\n<br />";
} if (CRYPT_EXT_DES == 1) { echo "Extended DES: ".crypt("admin")."\n<br />";
} else { echo "Extended DES 不支持.\n<br />";
} if (CRYPT_MD5 == 1) { echo "MD5: ".crypt("admin")."\n<br />";
} else { echo "MD5 not supported.\n<br />";
} if (CRYPT_BLOWFISH == 1) { echo "Blowfish: ".crypt("admin");
} else { echo "Blowfish DES 不支持.";
}*/
	
	print_submit("提交");
	table_end();
	form_end();

	print "<BR>";

	//insert into system_log(loginaction,DATE,REMOTE_ADDR,HTTP_USER_AGENT,QUERY_STRING,SCRIPT_NAME,USERID,SQLTEXT)
	$sql = "select * from system_log where loginaction='用户修改密码' and USERID='".$_SESSION['LOGIN_USER_ID']."'";
	$rs = $db->Execute($sql);
	$rs_a = $rs->GetArray();
	table_begin("80%");
	print "<tr class=TableHeader><td colspan=3>&nbsp;密码修改日志</td></tr>";
	print "<tr class=TableContent><td>&nbsp;修改时间</td><td>&nbsp;远程IP</td><td>&nbsp;操作类型</td></tr>";
	for($i=0;$i<sizeof($rs_a);$i++)		{
		print "<tr class=TableData><td>&nbsp;".$rs_a[$i]['DATE']."</td><td>&nbsp;".$rs_a[$i]['REMOTE_ADDR']."</td><td>&nbsp;".$rs_a[$i]['SQLTEXT']."</td></tr>";

	}
	table_end();

print "<BR>";

	/*page_css("我的个人参数设置");
	print "<SCRIPT>
	function FormCheck()
	{
		if (document.form1.新密码.value == \"\") {
			alert(\"新密码没有填写\");
			return false;
		}
		if (document.form1.确认新密码.value == \"\") {
			alert(\"确认新密码没有填写\");
			return false;
		}
		if (document.form1.确认新密码.value != document.form1.新密码.value) {
			alert(\"两次输入密码不一致\");
			return false;
		}
	}
	</SCRIPT>";
	print "<FORM name=form1 onsubmit=\"return FormCheck();\"  action=\"?action=DataDeal&pageid=1\" method=post encType=multipart/form-data>";
	table_begin("80%");
	print "<tr class=TableHeader><td colspan=2>&nbsp;我的密码修改</td></tr>";
	print "<tr class=TableData><td width=40%>&nbsp;原密码:</td><td>&nbsp;<INPUT type=password class=SmallInput maxLength=20  name=原密码 value=\"\"  >&nbsp;(输入你的原密码)</td></tr>";
	print "<tr class=TableData><td width=40%>&nbsp;新密码:</td><td>&nbsp;<INPUT type=password class=SmallInput maxLength=20  name=新密码 value=\"\"  >&nbsp;(至少六位字母或数字)</td></tr>";
	print "<tr class=TableData><td width=40%>&nbsp;确认新密码:</td><td>&nbsp;<INPUT type=password class=SmallInput maxLength=20  name=确认新密码 value=\"\"  >&nbsp;(至少六位字母或数字)</td></tr>";
	
	print_submit("提交");
	table_end();
	form_end();

	print "<BR>";

	//insert into system_log(loginaction,DATE,REMOTE_ADDR,HTTP_USER_AGENT,QUERY_STRING,SCRIPT_NAME,USERID,SQLTEXT)
	$sql = "select * from system_log where loginaction='用户修改密码' and USERID='".$_SESSION['LOGIN_USER_ID']."'";
	$rs = $db->Execute($sql);
	$rs_a = $rs->GetArray();
	table_begin("80%");
	print "<tr class=TableHeader><td colspan=3>&nbsp;密码修改日志</td></tr>";
	print "<tr class=TableContent><td>&nbsp;修改时间</td><td>&nbsp;远程IP</td><td>&nbsp;操作类型</td></tr>";
	for($i=0;$i<sizeof($rs_a);$i++)		{
		print "<tr class=TableData><td>&nbsp;".$rs_a[$i]['DATE']."</td><td>&nbsp;".$rs_a[$i]['REMOTE_ADDR']."</td><td>&nbsp;".$rs_a[$i]['SQLTEXT']."</td></tr>";

	}
	table_end();*/

	exit;
}




if($_GET['action']=="DataDeal"){

	page_css("我的密码修改");

	$原密码 = $_POST['原密码'];
	$新密码 = $_POST['新密码'];
	$确认新密码 = $_POST['确认新密码'];

	if(strlen($新密码)<6)		{
		print_infor("您输入的新密码长度太短!",'',"location='?'");
		exit;
	}

	if($新密码!=$确认新密码)		{
		print_infor("您两次输入的密码不一致!",'',"location='?'");
		exit;
	}

	$SQL			= "SELECT PASSWORD FROM user WHERE USER_ID = '".$_SESSION['LOGIN_USER_ID']."'";
	$rs				= $db->Execute($SQL);
	$rs_a			= $rs->GetArray();
	$PASSWORDTEXT = $rs_a[0]['PASSWORD'];
	if(crypt($原密码,$PASSWORDTEXT) == $PASSWORDTEXT){
		$新密码密文 = crypt($确认新密码);
		$sql = "update user set PASSWORD='$新密码密文' WHERE USER_ID = '".$_SESSION['LOGIN_USER_ID']."'";
		$db->Execute($sql);
		记录用户修改密码行为($_SESSION['LOGIN_USER_ID'],$sql,"成功修改密码");
		print_infor("您的密码修改成功!",'',"location='?'");
		exit;
	}else{
		记录用户修改密码行为($_SESSION['LOGIN_USER_ID'],$sql,"修改密码时密码输入错误");
		print_infor("您输入的原密码错误!",'',"location='?'");
		exit;
	}
}



function 记录用户修改密码行为($userid,$sql,$type="修改成功")	{
	global $db;
	$sql = ereg_replace("'",'&#039;',$sql);
	$sql = "insert into system_log(loginaction,DATE,REMOTE_ADDR,HTTP_USER_AGENT,QUERY_STRING,SCRIPT_NAME,USERID,SQLTEXT)
			values('用户修改密码'
			,'".date("Y-m-d H:i:s")."'
			,'".$_SERVER['REMOTE_ADDR']."'
			,'".$_SERVER['HTTP_USER_AGENT']."'
			,'".$_SERVER['QUERY_STRING']."'
			,'".$_SERVER['SCRIPT_NAME']."'
			,'$userid'
			,'$type'
			);";
	$db->Execute($sql);
}

?>
