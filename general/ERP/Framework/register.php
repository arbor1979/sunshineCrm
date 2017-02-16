<?php
ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL);

// display warnings and errors
error_reporting(E_WARNING | E_ERROR);

session_start();
header("Content-type:text/html;charset=gb2312");
require_once('lib.inc.php');

//$GLOBA_SESSION=returnsession();
//

$systemlang=$_SESSION['SUNSHINE_USER_LANG'];
if($systemlang=='')		$systemlang = 'zh';
if($systemlang=='zh')		{
	$register="注册";
	$returnText="返回";
	$registercodenotnull="注册码不能为空！";
	$paste="粘贴";
	$copy="复制";
	$machinecode_text="机器码";
	$registercode_text="注册码";
	$inputregistercode = "软件注册码输入";
}
else	{
	$register="Register";
	$returnText = "Cancel";
	$registercodenotnull="Register code not null";
	$paste="Paste";
	$copy="Copy";
	$machinecode_text="Machine code";
	$registercode_text="Register code";
	$inputregistercode = "Input software register code";
}
$LOGIN_THEME=$_SESSION['LOGIN_THEME'];
$LOGIN_THEME==""?$LOGIN_THEME=3:'';

?>
<html>
<head>
<title>注册页面</title>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<?php print "<LINK href=\"".ROOT_DIR."theme/$LOGIN_THEME/style.css\" type=text/css rel=stylesheet>";?>
<script Language="JavaScript">
function CheckForm()
{
   if(document.form2.REGISTER_CODE.value=="")
   { alert("<?php echo $registercodenotnull?>");
     return (false);
   }
   if(document.form2.SERVER_NAME.value=="")
   { alert("注册域名不能为空!请填写您所在使用服务器的域名!");
     return (false);
   }
   if(document.form2.SCHOOL_NAME.value=="")
   { alert("单位名称不能为空,请填写您所在单位的全称!");
     return (false);
   }
   return (true);
}

function copy_code()
{
  textRange = document.form2.MACHINE_CODE.createTextRange();
  textRange.execCommand("Copy");
}

function paste_code()
{
  textRange = document.form2.REGISTER_CODE.createTextRange();
  textRange.execCommand("paste");
}

</script>
</head>
<script type="text/javascript" language="javascript" src="../Enginee/lib/common.js"></script>
<body class="bodycolor" topmargin="5" onload="document.form2.REGISTER_CODE.focus();">

<table border="0" width="100%" cellspacing="0" cellpadding="3" class="small">
  <tr>
    <td class="Small"><span class="Small3"><font color=black><B>注册页面</B></font></span><br>
    </td>
  </tr>
</table>

<hr width="95%" height="1" align="left" class="Small1">

<div align="center" class="Small1">
<b>

<?php
$code=returnmachinecode();
//print $code;
$ini_file=@parse_ini_file('license.ini');
?>

<form action="register_submit.php" method="post" name="form2" onsubmit="return CheckForm();">
<table class="TableBlock" align="center" width="500">
<tr class="TableHeader">
<td colspan=2><?php echo $inputregistercode?></td>
</tr>
<tr class="TableData">
<td ><?php echo $machinecode_text?>：</td>
<td ><input type="text" name="MACHINE_CODE" size="20" class="SmallStatic" value="<?php echo $code?>" readonly>
 <input type="button" value="<?php echo $copy?>" class="SmallButton" onclick="copy_code()"></td>
</tr>
<tr class="TableData">
<td width=35%><?php echo $registercode_text?>：</td>
<td ><input type="text" name="REGISTER_CODE" size="20" class="SmallInput" value="<?php echo $ini_file['REGISTER_CODE']?>">
 <input type="button" value="<?php echo $paste?>" class="SmallButton" onclick="paste_code()">
 <BR>(注册码需要联系软件开发商获取,<a href='http://edu.tongda2000.com' target=_blank>访问开发商网站</a>)
 </td>
</tr>

<tr class="TableData">
<td width=35%>注册域名：</td>
<td ><input type="text" name="SERVER_NAME" size="38" class="SmallInput" value="<?php echo $ini_file['SERVER_NAME']?>"><BR>(正在使用的OA的域名,如:edu.tongda2000.com)
 </td>
</tr>


<tr class="TableData">
<td width=35%>单位名称：</td>
<td ><input type="text" name="SCHOOL_NAME" size="38" class="SmallInput" value="<?php echo $ini_file['SCHOOL_NAME']?>">
<BR>(单位名称的全称,如郑州单点科技软件有限公司)
 </td>
</tr>


<TR align=middle><TD class=TableControl noWrap align=middle  colspan="32">
<div align="middle">
<input type="submit" value=" <?php echo $register?> " class="SmallButton">
<input type=button accesskey="c" value=" <?php echo $returnText?> " class=SmallButton onClick="history.back();" title="<?php echo $returnText?>">
 </div>
</TD></TR>
</table>
 </form>
 </font>
</b>
</div>

<br><br>

</body>
</html>
