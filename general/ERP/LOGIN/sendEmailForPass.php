<?php
header("Content-type:text/html;charset=gb2312");

ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL);

// display warnings and errors
error_reporting(E_WARNING | E_ERROR);
session_start();
require_once('../include.inc.php');
page_css("密码重置");

if($_POST['email']!="")
{
	
	if($_SESSION["code"]!=strtoupper($_POST["validt"]))
	{
		print "<script language=javascript>alert('验证码不正确');history.back(-1);</script>";
		exit;
	}
	$sql="select * from user where email='".$_POST['email']."'";
	$rs=$db->Execute($sql);
	$rs_a=$rs->GetArray();
	if(sizeof($rs_a)==0)
	{
		print "<script language=javascript>alert('没有找到此邮箱的用户');history.back(-1);</script>";
		exit;
	}
	$URL="http://".$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF']."?".base64_encode("act=reset&USER_ID=".$rs_a[0]['USER_ID']."&PASSWORD=".$rs_a[0]['PASSWORD']);
	
	$EmailServerIP="http://edu.tongda2000.com/crm/SendValidMail.php";
	$dest=$_POST['email'];
	$destname="CRM用户";
	$zhuti="重置密码验证短信";
	$content="您好！您收到的是一封验证邮件，请点击下面链接进入密码重置页面：<br>".$URL;
	

	$data = array("1","dest" =>$dest,"destname" =>$destname,"zhuti" =>$zhuti,"content" =>$content,"a=>1");
	$data = http_build_query($data,'','&');  
	$opts = array(  
   		'http'=>array(
     	'method'=>"POST",
		'header' => "User-Agent: Mozilla/5.0 (Windows; U; Windows NT 6.0; en-US) \r\n Accept: */*", 
     	'content' =>".$data.",""
   		)  
 	);
 	$cxContext = stream_context_create($opts);  
 	$sFile = file_get_contents($EmailServerIP, false, $cxContext);  
 	print_infor($sFile,"trip","close");
	exit;
}
if($_GET['act']=="validt")
{
	if($_SESSION["code"]==strtoupper($_GET["validt"]))
		echo "验证码正确!";
	else
		echo "验证码错误!".$_SESSION["code"]."=".strtoupper($_GET["validt"]);
	exit;
}
if($_GET['act']=="reset")
{
	$USER_ID=$_GET["USER_ID"];
	$PASSWORD=$_GET["PASSWORD"];
	$sql="select * from user where user_id='".$USER_ID."' and password='".$PASSWORD."'";
	$rs=$db->Execute($sql);
	$rs_a=$rs->GetArray();
	if(sizeof($rs_a)==0)	
	{
		print_infor("旧的用户名密码不匹配","trip","close");
		exit;
	}
}
if($_POST['password']!="")
{
	$USER_ID=$_POST["USER_ID"];
	$oldpassword=$_POST["oldpassword"];
	$sql="select * from user where user_id='".$USER_ID."' and password='".$oldpassword."'";
	$rs=$db->Execute($sql);

	$rs_a=$rs->GetArray();
	if(sizeof($rs_a)==0)	
	{
		print_infor("旧的用户名密码不匹配","trip","close");
		exit;
	}
	$password=$_POST["password"];
	$newpassword = crypt($password);
	$sql = "update user set PASSWORD='$newpassword' WHERE USER_ID = '".$USER_ID."'";
	$db->Execute($sql);
	print_infor("您的密码修改成功!",'trip',"close");
	exit;
}
?>
<html>
<head>
<script language="JavaScript" src="../Enginee/jquery/jquery-1.4.4.min.js"></script>
<link type="text/css" rel="stylesheet" href="../Enginee/jquery/validator.css"></link>
<script language="javascript" type="text/javascript" src="../Enginee/jquery/formvalidator.js" charset="UTF-8"></script>
<script language="javascript" type="text/javascript" src="../Enginee/jquery/formvalidatorregex.js" charset="UTF-8"></script>
<script type="text/javascript">
  $(document).ready(function() {
	//$.formValidator.initConfig({autotip:true,formid:"form1",onerror:function(msg){}});
	$.formValidator.initConfig({formid:"form1",debug:false,submitonce:true,

		onerror:function(msg,obj,errorlist){
			alert(msg);

		}

	});
	$("#password").formValidator({onshow:"请输入新密码",onfocus:"密码长度至少为1",oncorrect:"密码合法"}).inputValidator({min:1,empty:{leftempty:false,rightempty:false,emptyerror:"密码两边不能有空符号"},onerror:"密码不能为空,请确认"});
	$("#pwdconfirm").formValidator({onshow:"",onfocus:"请输入确认密码",oncorrect:"两次密码相同"}).compareValidator({desid:"password",operateor:"=",onerror:"两次密码输入不同"});
	$("#email").formValidator({onshow:"",onfocus:"邮箱6-100个字符",oncorrect:"恭喜你,格式正确",defaultvalue:"@"}).inputValidator({min:6,max:100,onerror:"你输入的邮箱长度非法,请确认"}).regexValidator({regexp:"^([\\w-.]+)@(([[0-9]{1,3}.[0-9]{1,3}.[0-9]{1,3}.)|(([\\w-]+.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(]?)$",onerror:"你输入的邮箱格式不正确"});
	$("#validt").formValidator({onshow:"",onfocus:"请输入图片中的四位字符",oncorrect:"输入正确"}).inputValidator({min:4,max:4,onerror:"请输入四个字符"}).ajaxValidator({
		datatype : "html",
		async : true,
		cache:false,
		url : "?act=validt",
		success : function(data){

            if( data.indexOf("验证码正确!") > 0 ) 
                return true;
            else
            	return false;

		},
		buttons: $("#sendmail"),
		error: function(XMLHttpRequest, textStatus, errorThrown){alert("服务器没有返回数据，可能服务器忙，请重试"+errorThrown);},
		onerror : "验证码输入错误",
		onwait : "正在校验验证码，请稍候..."

	});
})
</script>
</head>
<body>

<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<link rel="stylesheet" type="text/css" href="<?php echo ROOT_DIR?>theme/3/style.css">
</head>

<body class="logout" topmargin="5">
<br>
<form name="form1" id="form1" action="" method="post">
<?php 
if($USER_ID!="")
{
?>
<input type="hidden" name="USER_ID" value="<?php echo $USER_ID?>">
<input type="hidden" name="oldpassword" value="<?php echo $PASSWORD?>">
<table border="0" width="600" cellspacing="0" cellpadding="3" class="small" align="center">
  <tr>
    <td class="Small" colspan=2><b><font color="#000000">重新设置登录密码：</font></b><br>
    </td>
  </tr>
  <tr>
    <td class="Small" colspan=2><hr width="100%" height="1" align="center" color="#000000">
    </td>
  </tr>
   <tr>
    <td class="Small" width=100>登录用户名： </td>
	<td class="Small"><?php echo $USER_ID?></td>
  </tr>
  <tr>
    <td class="Small">设置新密码： </td>
    <td class="Small"><input type="password" name="password" id="password"  size="10" maxlength="25"/>
    &nbsp;<span id="passwordTip" style="width:250px"></span>
    </td>
  </tr>
  <tr>
    <td class="Small">再次输入新密码： </td>
    <td class="Small"><input type="password" name="pwdconfirm" id="pwdconfirm"  size="10" maxlength="25"/>
    &nbsp;<span id="pwdconfirmTip" style="width:250px"></span></td>
  </tr>
  <tr>
    <td class="Small" colspan=2><input type="submit" value="确认修改" class="SmallButton">
    </td>
  </tr>
</table>
<?php 
}else{ 
?>
<table border="0" width="600" cellspacing="0" cellpadding="3" class="small" align="center">
  <tr>
    <td class="Small" colspan=2><b><font color="#000000">通过绑定的邮箱重置您的密码：</font></b><br>
    </td>
  </tr>
  <tr>
    <td class="Small" colspan=2><hr width="100%" height="1" align="center" color="#000000">
    </td>
  </tr>
   <tr>
    <td class="Small" width=80>绑定邮箱： </td>
	<td class="Small"><input type="text" name="email" id="email" size=25>&nbsp;<span id="emailTip" style="width:250px"></span></td>
  </tr>
  <tr>
    <td class="Small">验证码： </td>
    <td class="Small"><input name="validt" id="validt" type="text" size="10" maxlength="4"/> <img src="../Framework/validitPicture.php" name="validitpic" align="absmiddle"  />
    &nbsp;<span id="validtTip" style="width:250px"></span></td>
  </tr>
  <tr>
    <td class="Small" colspan=2><input type="submit" name="sendmail" id="sendmail" value="发送验证邮件" class="SmallButton">
    </td>
  </tr>
</table>
<?php }?>
</form>
</body>
</html>
