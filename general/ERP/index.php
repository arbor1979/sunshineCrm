<?php

echo "<META HTTP-EQUIV=REFRESH CONTENT='0;URL=LOGIN/'>\n";
exit;
/*
��Ȩ����:֣�ݵ���Ƽ�������޹�˾;
��ϵ��ʽ:0371-69663266;
��˾��ַ:����֣�ݾ��ü��������������־�����·ͨ�Ų�ҵ԰��¥����;
��˾���:֣�ݵ���Ƽ�������޹�˾λ���й��в�����-֣��,������2007��1��,�����ڰѻ����Ƚ���Ϣ����������ͨ�ż���������ѹ�����ҵ��ʵ���ռ���������ҵ�ͻ��Ĺ�����ҵ���»�У�ȫ���ṩ��������֪ʶ��Ȩ�Ľ�����������������������������в�������ĸ�У���������������СѧУ��������ṩ�̡�Ŀǰ�����ж�Ҹ�ְ����ְ��ԺУʹ��ͨ���в��з����Ŀ���������ͷ���;

�������:����Ƽ�������������Լܹ�ƽ̨,�Լ��������֮����չ���κ��������Ʒ;
����Э��:���ֻ�У԰��ƷΪ��ҵ���,�������ΪLICENSE��ʽ;����CRMϵͳ��SunshineCRMϵͳΪGPLV3Э�����,GPLV3Э����������뵽�ٶ�����;
��������:�����ʹ�õ�ADODB��,PHPEXCEL��,SMTARY���ԭ��������,���´���������������;
*/

require_once( "config.inc.php" );
require_once( "lib.inc.php" );
require_once( "VERSION_INFO.php" );
$LOGIN_THEME = $_SESSION['SUNSHINE_USER_LOGIN_THEME'];
				$LOGIN_THEME == "" ? ( $LOGIN_THEME = $SYSTEM_THEME ) : "";
				$SHOW_PASS_IMG = "";
				require_once( "Framework/cache.inc.php" );
				$OA_PRODUCT_NAME = $IE_TITLE;
			
				$sessionKey = md5( "Sunshine Anywhere" )."%".md5( "����Эͬ�칫ϵͳ" );
				

?>
<html>
<head>
<title><?php echo $IE_TITLE?></title>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<meta name="description" content="SNDG����Ƽ���һ�ҳ����������ϴ��µ���ҵ��רע��Ϊ��ҵ�û��ṩרҵ�������Ƶ���ҵ���������Ӧ�ý������.��Ʒ��Sunshine Anywhere ����Эͬ�칫ϵͳ Sunshine Anywhere ��ѧ�����ſ�ϵͳ��" />
<meta name="keywords" content="����Ƽ�,SNDG����Ƽ����翪���Ŷ�,������,Sunshine Anywhere,�칫�Զ���,����Эͬ�칫ϵͳ,�������ܰ칫ϵͳ,����칫ϵͳ,��Ӣ��˫��OAϵͳ,OA���ܶ��ƣ�Sunshine Anywhere ��ѧ�����ſ�ϵͳ����վ��ƣ�רҵ��վ������˾��FLASH���Ƭͷ�������,��ҵVI�Ӿ�ʶ��ϵͳ��ƣ�ƽ������ƣ�OAϵͳ�����������������" />
<meta name="Generator" content="Sndg - Copyright 2002 - 2005 SNDG Inc.  All rights reserved." /><link rel="stylesheet" href="./theme/3/images/style.css">
</head>

<body class="bodycolor" onLoad="javascript:form1.username.focus();" scroll="no" onselectstart="return false">
<script language="JavaScript">
//-------------------- ��ֹ���� ---------------------------
function killErrors()
{
  return true;
}
window.onerror = killErrors;

//------------------- ������� --------------------------
self.moveTo(0,0);                                  <!-- ����ǰ������СΪ -->
self.resizeTo(screen.availWidth,screen.availHeight); <!-- ����ǰ��������Ϊ��Ļ��С -->
self.focus();    

// ״̬����ʾ����
window.defaultStatus="<?php echo $IE_TITLE?>"; 

function Login()
{


lang_str = "zh";


strURL = "logincheck.php?sessionKey=<?php echo $sessionKey?>&username=" + document.form1.username.value + "&password=" + document.form1.password.value + "&language=" + lang_str + "";
nWidth = screen.availWidth;
nHeight = screen.availHeight;
//window.location = strURL;
window.open(strURL, "","toolbar=no,location=no,directories=no,status=no,"+ "menubar=no,copyhistory=no,left=0,top=0,resizable=yes,"+ "width=" + nWidth + ",height=" + nHeight);
//window.showModelessDialog(strURL,'','scroll:0;status:0;help:0;resizable:1;dialogWidth:'+nWidth+'px;dialogHeight:'+nHeight+'px');
//window.opener=null;
//window.close();
}


</script>

<style type="text/css">
<!--
body {
	background-image: url();
}
-->
</style>
<form name="form1" method="post" onSubmit = "Login();">
<table width="100%" height="100%" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td align="center" valign="middle">
	  <table width="542" height="285" border="0" align="center" cellpadding="0" cellspacing="0" class="small">
	 
    <tr>
      <td align="right" valign="top" background="./theme/3/images/login.gif" >
        <div class="login">
        <b><font color=#0077B2>�û���:</font></b> 
        <input name="username" type="text" value=""  class="SmallInput" onkeydown="if(event.keyCode==13)event.keyCode=9" value="<?php echo $USER_NAME_COOKIE?>" size="12" maxlength="30"><br>                      
        <br>
        <b><font color=#0077B2>��&nbsp;&nbsp;&nbsp;��:</font></b>
        <input name="password" type="password"  class="SmallInput" value="" size="12" maxlength="30">
        <br>
        <br>
	<br>
         <input name="Submit" class="SmallButton" type="Submit"  value=" ��¼ ">
         &nbsp;&nbsp;&nbsp;<input type="reset" name="Submit" class="SmallButton" value=" ���� ">
	</div>
<br>
<br>
       </td>
    </tr>

  </table>

 
        <br>
	 
	  
	  
	  
	  </td>
    </tr>
</table>


<table width="100%"  border="0" cellpadding="0" cellspacing="0" class="small">
  <tr>
    <td width="80" nowrap><a href="#" target="_self" style="cursor:hand" onClick="this.style.behavior='url(#default#homepage)';this.setHomePage(self.location);return false;" ><font color=#0077B2>��Ϊ��ҳ</font></a></td>
    <td width="80"><a href="javascript:window.external.AddFavorite(self.location,'<?php echo $OA_PRODUCT_NAME?> - ��¼����')" target="_self"><font color=#0077B2>�ղص�ַ</font></a> </td>
    <td width="80"><a href="http://www.sndg.net/faq_1.htm" target="_blank"><font color=#0077B2>ʹ�ð���</font></a></td>
    <td><div align="right"><font color=#999999>��ӭʹ��<?php echo $OA_PRODUCT_NAME?><FONT color=#0077B2><b><{$VERSION_INFO}></b></FONT>����ϵͳ�Ƽ�������IE6.0�¡�</font></div></td>
  </tr>
</table>

 </form>
</body>
</html>
