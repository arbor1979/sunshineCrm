<?php
/*
��Ȩ����:֣�ݵ���Ƽ�������޹�˾;
��ϵ��ʽ:0371-69663266;
��˾��ַ:����֣�ݾ��ü��������������־�����·ͨ�Ų�ҵ԰��¥����;
��˾���:֣�ݵ���Ƽ�������޹�˾λ���й��в�����-֣��,������2007��1��,�����ڰѻ����Ƚ���Ϣ����������ͨ�ż���������ѹ�����ҵ��ʵ���ռ���������ҵ�ͻ��Ĺ�����ҵ���»�У�ȫ���ṩ��������֪ʶ��Ȩ�Ľ�����������������������������в�������ĸ�У���������������СѧУ��������ṩ�̡�Ŀǰ�����ж�Ҹ�ְ����ְ��ԺУʹ��ͨ���в��з����Ŀ���������ͷ���;

�������:����Ƽ�������������Լܹ�ƽ̨,�Լ��������֮����չ���κ��������Ʒ;
����Э��:���ֻ�У԰��ƷΪ��ҵ���,�������ΪLICENSE��ʽ;����CRMϵͳ��SunshineCRMϵͳΪGPLV3Э�����,GPLV3Э����������뵽�ٶ�����;
��������:�����ʹ�õ�ADODB��,PHPEXCEL��,SMTARY���ԭ��������,���´���������������;
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
<title>��¼��Ϣ��</title>
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
.style1 {font-family: "����"}


-->
</style>
<script Language=JavaScript>

// ------ ��ʱˢ��ҳ�� -------

window.setInterval('getmessage()',<?php echo $INFO_REF_SEC?>);  <!-- ��ʱˢ��  -->

function getmessage()
{
	$.post('../Interface/CRM/notify_newai.php', {
	    action: 'getmessage'
	}, function(data) {
		if(data>0)
		{
			if(data>99)
				data=99;
			$("#menu_3").html('<font color=red>'+data+'</font>����Ϣ');	
			if(data>0 && $("#miaov_float_layer", window.parent.parent.frames["table_index"].document).is(":hidden"))
				popMessage();
		}
		else
			$("#menu_3").html('������Ϣ');
		
	});
	

}
// <!--��������Ҽ���ʼ-->
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
// <!--��������Ҽ�����-->

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
<div class="obutton type1" id="menu_1" onclick="parent.view_menu(1)">���ܲ˵�</div>
<div class="obutton type2" id="menu_2" onclick="parent.view_menu(2)" >�����ʴ�</div>
<div class="obutton type3" id="menu_3" onclick="parent.view_menu(3)" >��Ϣ��ʾ</div>
</div>

</body>
</html>

