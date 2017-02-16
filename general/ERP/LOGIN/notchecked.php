<?php
header("Content-type:text/html;charset=gb2312");

ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL);

// display warnings and errors
error_reporting(E_WARNING | E_ERROR);

require_once('../config.inc.php');
$LOGIN_THEME=$_SESSION['SUNSHINE_USER_LOGIN_THEME'];
$LOGIN_THEME==""?$LOGIN_THEME=$SYSTEM_THEME:'';
?>
<html>
<head>
<title>系统登录(System Login)</title>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<META HTTP-EQUIV=REFRESH CONTENT='2;URL=index.php'>
<LINK href="<?php echo ROOT_DIR?>theme/3/style.css" rel=stylesheet>
</head>

<body class="bodycolor" topmargin="5">


<div align="center" title="提示信息框">
<span style="BACKGROUND:#EEEEEE;COLOR:#FF6633;margin: 10px;border:1px dotted #FF6633;font-weight:bold;padding:8px;width=300px">
<font color="#FF0000"><img src="../Framework/images/attention.gif" height="20"> <b>提示</b></font><hr>
用户名或密码错误(注意大小写)!</span>
</div>
<br>
<div align="center">
  <input type="button" class="SmallButton" value="重新登录" onclick="location='index.php'">
</div>
