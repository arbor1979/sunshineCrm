<?php
ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL);

// display warnings and errors
error_reporting(E_WARNING | E_ERROR);
session_start();

require_once('lib.inc.php');

$����汾��FILE = @file("../databackup/update.txt");
$����汾�� = $����汾��FILE[0];


?>
<HTML>
<?php
page_css("�����Ȩ��Ϣ");
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
			<font color=red>ͨ���в��з�����(����Ƽ�)�����Ȩ��Ϣ˵��</font>
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
					$ini_file['REGISTER_CODE']	= "���δע��-���ð汾";
					$ini_file['USER_NUMBER']	= "���δע��-���ð汾";
					$ini_file['SERVER_NAME']	= "���δע��-���ð汾";
					$ini_file['SCHOOL_NAME']	= "���δע��-���ð汾";
					$ini_file['SOFTWARE_TYPE']	= "���δע��-���ð汾";
					$ini_file['SOFTWARE_DATE']	= "���δע��-���ð汾";
					@unlink('license.ini');
				}
				else	{
					$ini_file['USER_NUMBER']	= "������";
					$ini_file['SOFTWARE_DATE']	= date("Y-m-d", filectime('license.ini'));
					$ini_file['SOFTWARE_TYPE']	= "��ԴCRM������";
				}
				?>
				<tr>
                <td height="50" colspan="2" valign="top">
				<p class="td">
				�������汾��<b></b><font color=red><?php echo $_SERVER['SERVER_SOFTWARE']?></font><br>
				����汾�ţ�<b></b><font color=red><?php echo $����汾��?></font><br>
				��������룺<b></b><font color=red><?php echo $returnmachinecode?></font><br>

				���ע���룺<b></b><font color=red><?php echo $ini_file['REGISTER_CODE']?></font><br>

				����û�����<b></b><font color=red><?php echo $ini_file['USER_NUMBER']?></font><br>
				���ע��������<b></b><font color=red><?php echo $ini_file['SERVER_NAME']?></font><br>
				���ע�ᵥλ��<b></b><font color=red><?php echo $ini_file['SCHOOL_NAME']?></font><br>
				���ע�����ͣ�<b></b><font color=red><?php echo $ini_file['SOFTWARE_TYPE']?></font><br>
				�����Ȩʱ�䣺<b></b><font color=red><?php echo $ini_file['SOFTWARE_DATE']?></font><br>
				</td>
                </tr>
				<tr>
                  <td colspan="2" valign="top"><p class="td"><font color=red>�����ݲ�������ݼ�ʹ�õ�˵��(ʹ��ALT��)��</font>
				  </td>
                </tr>
                <tr>
                  <td width="50%" valign="top"><font color=green>ALT+N</font>���½�(<U>N</U>ew)</td>
                  <td width="50%" valign="top"><font color=green>ALT+F</font>������(<U>F</U>ind)</td>
                </tr>
                <tr>
                  <td width="50%" valign="top"><font color=green>ALT+X</font>������(E<U>x</U>port)</td>
                  <td width="50%" valign="top"><font color=green>ALT+I</font>������(<U>I</U>mport)</td>
                </tr>
                <tr>
                  <td width="50%" valign="top"><font color=green>ALT+1</font>����1�м�¼(<U>1</U>)</td>
				  <td width="50%" valign="top"><font color=green>ALT+2</font>����2�м�¼(<U>2</U>)</td>

                </tr>
                <tr>
				  <td width="50%" valign="top"><font color=green>ALT+E</font>����ѡ�м�¼�༭(<U>E</U>dit)</td>
                  <td width="50%" valign="top"><font color=green>ALT+D</font>���Լ�¼ɾ��(<U>D</U>elete)</td>
                </tr>
                <tr>
				  <td width="50%" valign="top"><font color=green>ALT+S</font>������(<U>S</U>ave)</td>
                  <td width="50%" valign="top"><font color=green>ALT+C</font>������(<U>C</U>ancel)</td>
                </tr>
				<tr>
				  <td width="50%" valign="top"><font color=green>ALT+P</font>����ӡ(<U>P</U>rint)</td>
                  <td width="50%" valign="top"><font color=green>ALT+R</font>������(<U>R</U>eport)</td>
                </tr>

                <tr>
                  <td height="50" colspan="2" valign="top"><p class="td">���棺�����������������Ȩ���͹��ʹ�Լ�ı�����δ����Ȩ���Ը��ƻ�ɢ��������Ĳ��ֻ�ȫ�������������������º����´���������֪��Υ���߽����跨�ɷ�Χ�ڵ�ȫ���Ʋá� </p></td>
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
