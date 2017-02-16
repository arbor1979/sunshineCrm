<?php

echo "<META HTTP-EQUIV=REFRESH CONTENT='0;URL=LOGIN/'>\n";
exit;
/*
版权归属:郑州单点科技软件有限公司;
联系方式:0371-69663266;
公司地址:河南郑州经济技术开发区第五大街经北三路通信产业园四楼西南;
公司简介:郑州单点科技软件有限公司位于中国中部城市-郑州,成立于2007年1月,致力于把基于先进信息技术（包括通信技术）的最佳管理与业务实践普及到教育行业客户的管理与业务创新活动中，全面提供具有自主知识产权的教育管理软件、服务与解决方案，是中部最优秀的高校教育管理软件及中小学校管理软件提供商。目前己经有多家高职和中职类院校使用通达中部研发中心开发的软件和服务;

软件名称:单点科技软件开发基础性架构平台,以及在其基础之上扩展的任何性软件作品;
发行协议:数字化校园产品为商业软件,发行许可为LICENSE方式;单点CRM系统即SunshineCRM系统为GPLV3协议许可,GPLV3协议许可内容请到百度搜索;
特殊声明:软件所使用的ADODB库,PHPEXCEL库,SMTARY库归原作者所有,余下代码沿用上述声明;
*/

require_once( "config.inc.php" );
require_once( "lib.inc.php" );
require_once( "VERSION_INFO.php" );
$LOGIN_THEME = $_SESSION['SUNSHINE_USER_LOGIN_THEME'];
				$LOGIN_THEME == "" ? ( $LOGIN_THEME = $SYSTEM_THEME ) : "";
				$SHOW_PASS_IMG = "";
				require_once( "Framework/cache.inc.php" );
				$OA_PRODUCT_NAME = $IE_TITLE;
			
				$sessionKey = md5( "Sunshine Anywhere" )."%".md5( "网络协同办公系统" );
				

?>
<html>
<head>
<title><?php echo $IE_TITLE?></title>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<meta name="description" content="SNDG单点科技是一家充满活力不断创新的企业，专注于为企业用户提供专业、量身订制的企业管理软件和应用解决方案.产品有Sunshine Anywhere 网络协同办公系统 Sunshine Anywhere 大学智能排课系统。" />
<meta name="keywords" content="单点科技,SNDG单点科技网络开发团队,王纪云,Sunshine Anywhere,办公自动化,网络协同办公系统,网络智能办公系统,网络办公系统,中英文双语OA系统,OA功能定制，Sunshine Anywhere 大学智能排课系统，网站设计，专业网站制作公司，FLASH广告片头设计制作,企业VI视觉识别系统设计，平面广告设计，OA系统开发，管理软件开发" />
<meta name="Generator" content="Sndg - Copyright 2002 - 2005 SNDG Inc.  All rights reserved." /><link rel="stylesheet" href="./theme/3/images/style.css">
</head>

<body class="bodycolor" onLoad="javascript:form1.username.focus();" scroll="no" onselectstart="return false">
<script language="JavaScript">
//-------------------- 防止出错 ---------------------------
function killErrors()
{
  return true;
}
window.onerror = killErrors;

//------------------- 窗口最大化 --------------------------
self.moveTo(0,0);                                  <!-- 将当前窗口缩小为 -->
self.resizeTo(screen.availWidth,screen.availHeight); <!-- 将当前窗口设置为屏幕大小 -->
self.focus();    

// 状态栏显示文字
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
        <b><font color=#0077B2>用户名:</font></b> 
        <input name="username" type="text" value=""  class="SmallInput" onkeydown="if(event.keyCode==13)event.keyCode=9" value="<?php echo $USER_NAME_COOKIE?>" size="12" maxlength="30"><br>                      
        <br>
        <b><font color=#0077B2>密&nbsp;&nbsp;&nbsp;码:</font></b>
        <input name="password" type="password"  class="SmallInput" value="" size="12" maxlength="30">
        <br>
        <br>
	<br>
         <input name="Submit" class="SmallButton" type="Submit"  value=" 登录 ">
         &nbsp;&nbsp;&nbsp;<input type="reset" name="Submit" class="SmallButton" value=" 重填 ">
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
    <td width="80" nowrap><a href="#" target="_self" style="cursor:hand" onClick="this.style.behavior='url(#default#homepage)';this.setHomePage(self.location);return false;" ><font color=#0077B2>设为首页</font></a></td>
    <td width="80"><a href="javascript:window.external.AddFavorite(self.location,'<?php echo $OA_PRODUCT_NAME?> - 登录界面')" target="_self"><font color=#0077B2>收藏地址</font></a> </td>
    <td width="80"><a href="http://www.sndg.net/faq_1.htm" target="_blank"><font color=#0077B2>使用帮助</font></a></td>
    <td><div align="right"><font color=#999999>欢迎使用<?php echo $OA_PRODUCT_NAME?><FONT color=#0077B2><b><{$VERSION_INFO}></b></FONT>，本系统推荐运行在IE6.0下。</font></div></td>
  </tr>
</table>

 </form>
</body>
</html>
