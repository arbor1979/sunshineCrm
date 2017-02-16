<?php
ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL);

// display warnings and errors
error_reporting(E_WARNING | E_ERROR);
session_start();

require_once('lib.inc.php');

$软件版本号FILE = @file("../databackup/update.txt");
$软件版本号 = $软件版本号FILE[0];


?>
<HTML>
<?php
page_css("软件授权信息");
?>

</HEAD>
<style type="text/css">
<!--
.style1 {
	color: #FFFFFF;
	font-weight: bold;
	font-family: Arial, Helvetica, sans-serif;
	font-size: 14px;
}
-->
</style>

<body class="bodycolor">

<table id="about" width="100%" height="100%"  border="0" cellpadding="0" cellspacing="0" >
  <tr>
    <td align="center" valign="middle">

		<table width="410"  border="0" align="center" cellpadding="0" cellspacing="0" class="small" style="border:1px solid #006699;">
          <tr>
		    <td height="30" align="middle" colspan=2  bgcolor="#E0F2FC">
			<font color=red>通达中部研发中心(单点科技)软件授权信息说明</font>
			</td>
          </tr>
          <tr>
            <td bgcolor="#E9F6FD" colspan=2>
			<table width="100%" height="100"  border="0" cellpadding="0" cellspacing="12" bordercolor="#333333" class="small">
				<?php
				//print_R($_SERVER['SERVER_NAME']);
				$returnmachinecode = returnmachinecode();
				$ini_file=@parse_ini_file('license.ini');
				if($ini_file['REGISTER_CODE']=="")	{
					$ini_file['REGISTER_CODE']	= "软件未注册-试用版本";
					$ini_file['USER_NUMBER']	= "软件未注册-试用版本";
					$ini_file['SERVER_NAME']	= "软件未注册-试用版本";
					$ini_file['SCHOOL_NAME']	= "软件未注册-试用版本";
					$ini_file['SOFTWARE_TYPE']	= "软件未注册-试用版本";
					$ini_file['SOFTWARE_DATE']	= "软件未注册-试用版本";
					@unlink('license.ini');
				}
				else	{
					$ini_file['USER_NUMBER']	= "不限制";
					$ini_file['SOFTWARE_DATE']	= date("Y-m-d", filectime('license.ini'));
					$ini_file['SOFTWARE_TYPE']	= "开源CRM社区版";
				}
				?>
				<tr>
                <td height="50" colspan="2" valign="top">
				<p class="td">
				服务器版本：<b></b><font color=red><?php echo $_SERVER['SERVER_SOFTWARE']?></font><br>
				软件版本号：<b></b><font color=red><?php echo $软件版本号?></font><br>
				软件机器码：<b></b><font color=red><?php echo $returnmachinecode?></font><br>

				软件注册码：<b></b><font color=red><?php echo $ini_file['REGISTER_CODE']?></font><br>

				软件用户数：<b></b><font color=red><?php echo $ini_file['USER_NUMBER']?></font><br>
				软件注册域名：<b></b><font color=red><?php echo $ini_file['SERVER_NAME']?></font><br>
				软件注册单位：<b></b><font color=red><?php echo $ini_file['SCHOOL_NAME']?></font><br>
				软件注册类型：<b></b><font color=red><?php echo $ini_file['SOFTWARE_TYPE']?></font><br>
				软件授权时间：<b></b><font color=red><?php echo $ini_file['SOFTWARE_DATE']?></font><br>
				</td>
                </tr>
				<tr>
                  <td colspan="2" valign="top"><p class="td"><font color=red>对数据操作区快捷键使用的说明(使用ALT键)：</font>
				  </td>
                </tr>
                <tr>
                  <td width="50%" valign="top"><font color=green>ALT+N</font>：新建(<U>N</U>ew)</td>
                  <td width="50%" valign="top"><font color=green>ALT+F</font>：查找(<U>F</U>ind)</td>
                </tr>
                <tr>
                  <td width="50%" valign="top"><font color=green>ALT+X</font>：导出(E<U>x</U>port)</td>
                  <td width="50%" valign="top"><font color=green>ALT+I</font>：导入(<U>I</U>mport)</td>
                </tr>
                <tr>
                  <td width="50%" valign="top"><font color=green>ALT+1</font>：第1行记录(<U>1</U>)</td>
				  <td width="50%" valign="top"><font color=green>ALT+2</font>：第2行记录(<U>2</U>)</td>

                </tr>
                <tr>
				  <td width="50%" valign="top"><font color=green>ALT+E</font>：对选中记录编辑(<U>E</U>dit)</td>
                  <td width="50%" valign="top"><font color=green>ALT+D</font>：对记录删除(<U>D</U>elete)</td>
                </tr>
                <tr>
				  <td width="50%" valign="top"><font color=green>ALT+S</font>：保存(<U>S</U>ave)</td>
                  <td width="50%" valign="top"><font color=green>ALT+C</font>：返回(<U>C</U>ancel)</td>
                </tr>
				<tr>
				  <td width="50%" valign="top"><font color=green>ALT+P</font>：打印(<U>P</U>rint)</td>
                  <td width="50%" valign="top"><font color=green>ALT+R</font>：报表(<U>R</U>eport)</td>
                </tr>

                <tr>
                  <td height="50" colspan="2" valign="top"><p class="td">警告：本计算机程序受著作权法和国际公约的保护，未经授权擅自复制或散布本程序的部分或全部，将承受严厉的民事和刑事处罚，对已知的违反者将给予法律范围内的全面制裁。 </p></td>
                </tr>
            </table>
			</td>
          </tr>
        </table>

	</td>
  </tr>
</table>

</body>
</HTML>
