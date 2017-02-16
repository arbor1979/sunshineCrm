<?php
header("Content-type:text/html;charset=gb2312");

ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL);

// display warnings and errors
error_reporting(E_WARNING | E_ERROR);
session_start();
//print_R($_SESSION);
require_once('../include.inc.php');
$common_html=returnsystemlang('common_html');
$_SESSION = Array();
?>
<html>
<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<link rel="stylesheet" type="text/css" href="<?php echo ROOT_DIR?>theme/3/style.css">
</head>

<body class="logout" topmargin="5">

<table border="0" width="100%" cellspacing="0" cellpadding="3" class="small">
  <tr>
    <td class="Small"><b><font color="#000000"> <?php echo $common_html['common_html']['exit']?></font></b><br>
    </td>
  </tr>
</table>

<hr width="95%" height="1" align="left" color="#000000">

<br>
<div align="center">
<b>
<font color="#000000">
<?php echo $common_html['common_html']['closebrowserinfor']?>
</font></b>
</div>

<br>
<div align="center">
  <input type="button" value="<?php echo $common_html['common_html']['relogin']?>" class="SmallButton" onclick="location='./'">&nbsp;&nbsp;&nbsp;&nbsp;

</div>
</body>
</html>
