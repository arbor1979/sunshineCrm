<?php
/*
版权归属:郑州单点科技软件有限公司;
联系方式:0371-69663266;
公司地址:河南郑州经济技术开发区第五大街经北三路通信产业园四楼西南;
公司简介:郑州单点科技软件有限公司位于中国中部城市-郑州,成立于2007年1月,致力于把基于先进信息技术（包括通信技术）的最佳管理与业务实践普及到教育行业客户的管理与业务创新活动中，全面提供具有自主知识产权的教育管理软件、服务与解决方案，是中部最优秀的高校教育管理软件及中小学校管理软件提供商。目前己经有多家高职和中职类院校使用通达中部研发中心开发的软件和服务;

软件名称:单点科技软件开发基础性架构平台,以及在其基础之上扩展的任何性软件作品;
发行协议:数字化校园产品为商业软件,发行许可为LICENSE方式;单点CRM系统即SunshineCRM系统为GPLV3协议许可,GPLV3协议许可内容请到百度搜索;
特殊声明:软件所使用的ADODB库,PHPEXCEL库,SMTARY库归原作者所有,余下代码沿用上述声明;
*/

function system_user_number_2( )
{
				global $db;
				$sql = "select Count(*) as NUM from user";
				$rs = $db->execute( $sql );
				$Number = $rs->fields['NUM'];
				return $Number;
}



require_once( "lib.inc.php" );
$sessionkey = returnsesskey( );
$GLOBAL_SESSION = returnsession( );
	$LOGIN_THEME = $_SESSION['LOGIN_THEME'];
				$DEPT_NAME = $_SESSION['SUNSHINE_USER_DEPT_NAME'];
				$USER_NAME = $_SESSION['SUNSHINE_USER_NICK_NAME'];
				$USER_PRIV = $_SESSION['SUNSHINE_USER_NICK_NAME'];
				$LOGIN_AVATAR = $_SESSION['SUNSHINE_USER_AVATAR'];
				$HELLO_STR = $common_html['common_html']['welcome'];
				$INFO_REF_SEC = 300000;
				$SERVER_PORT = $_SERVER['SERVER_PORT'];

				$MACHINE_CODE = returnmachinecode( );
				$USER_COUNT = system_user_number_2( );
				$SERVER_NAME = $_SERVER['SERVER_NAME'];
				$SERVER_ADDR = $_SERVER['SERVER_ADDR'];
				$URL = "http://www.sndg.net/tryout/SunshineOACRM/access.php?version=SunshineJXC".$version."_".$SERVER_PORT."&SERVER_ADDR={$SERVER_ADDR}&SERVER_NAME={$SERVER_NAME}&MACHINE_CODE={$MACHINE_CODE}&USER_COUNT={$USER_COUNT}";
		
?>
<html>
<head>
<title>登录信息框</title>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<link rel="stylesheet" type="text/css" href="../theme/3/images/style.css"> 
<script type="text/javascript" language="javascript" src="../Enginee/jquery/jquery.js"></script>
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
.style1 {font-family: "宋体"}


-->
</style>
<script Language=JavaScript>

// ------ 定时刷新页面 -------

window.setInterval('getmessage()',<?php echo $INFO_REF_SEC?>);  <!-- 定时刷新  -->

function getmessage()
{
	$.post('../Interface/CRM/notify_newai.php', {
	    action: 'getmessage'
	}, function(data) {
		if(data>0)
		{
			if(data>99)
				data=99;
			$("#menu_3").html('<font color=red>'+data+'</font>新消息');	
			if(data>0 && $("#miaov_float_layer", window.parent.parent.frames["table_index"].document).is(":hidden"))
				popMessage();
		}
		else
			$("#menu_3").html('无新消息');
		
	});
	

}
// <!--屏蔽鼠标右键开始-->
/*
if (window.Event)
  document.captureEvents(Event.MOUSEUP);

function nocontextmenu()
{
 event.cancelBubble = true;
 event.returnValue = false;

 return false;
}

function norightclick(e)
{
 if (window.Event)
 {
  if (e.which == 2 || e.which == 3)
   return false;
 }
 else
  if (event.button == 2 || event.button == 3)
  {
   event.cancelBubble = true
   event.returnValue = false;
   return false;
  }

}
document.oncontextmenu = nocontextmenu;  // for IE5+
document.onmousedown = norightclick;     // for all others
*/
// <!--屏蔽鼠标右键结束-->

function popMessage()
{
	$.post('../Interface/CRM/notify_newai.php', {
	    action: 'getmessageshow'
	}, function(data) {
		if(data!='')
		{
			$("#content", window.parent.parent.frames["table_index"].document).html(data);
			//$("#miaov_float_layer", window.parent.parent.frames["table_index"].document).slideDown("normal",function (){setTimeout("HideMessage()",5000)});
			$("#miaov_float_layer", window.parent.parent.frames["table_index"].document).slideDown();
		}
			
		
	});
	
	
}
$(function()
{ 

	getmessage();
});



</script>
</head>


<body onselectstart="return false" style="margin:0;padding:0;" >

<div style="background:url(../theme/3/images/pannel-top.gif);border-bottom:1px solid #778FAF;height:47px;">
<div class="obutton type1" id="menu_1" onclick="parent.view_menu(1)">功能菜单</div>
<div class="obutton type2" id="menu_2" onclick="parent.view_menu(2)" >帮助问答</div>
<div class="obutton type3" id="menu_3" onclick="parent.view_menu(3)" >消息提示</div>
</div>

</body>
</html>

