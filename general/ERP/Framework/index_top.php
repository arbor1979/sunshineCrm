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

function index_top( )
{
				global $smarty;
				global $LOGIN_THEME;
				global $IE_TITLE;
				global $_SESSION;
				global $db;
				global $_SESSION;
				global $SUNSHINE_USER_UNIT_ID;


}

require_once( "lib.inc.php" );
$sessionkey = returnsesskey( );
$GLOBAL_SESSION = returnsession( );
$ExecTimeBegin = getmicrotime( );
$lang = returnsystemlang( );
$common_html = returnsystemlang( "common_html" );
$SUNSHINE_USER_UNIT_ID = $_SESSION['SUNSHINE_USER_UNIT_ID'];
$LOGIN_THEME = $_SESSION['LOGIN_THEME'];
$LOGIN_THEME == "" ? ( $LOGIN_THEME = $SYSTEM_THEME ) : "";
$sql = "select * from sys_menu order by MENU_ID";
$rs_menu = $db->execute( $sql );
$MENU_LIST = $rs_menu->getarray( );
$USER_NAME = $_SESSION['SUNSHINE_USER_NAME'];

$TIME_STR=date("Y-m-d H:i:s");
?>
<html>
<head>
<title>ϵͳ������</title>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<link rel="stylesheet" type="text/css" href="../theme/3/images/style.css">
<script language="JavaScript">



// ѯ��ע��ϵͳ
function iflogout()
{
if(window.confirm('ȷ�����µ�¼��'))
 {
  parent.parent.location="../logout.php?USER_NAME=<?php echo $USER_NAME?>";        // ҳ����ת
 }
}

// ѯ���˳�ϵͳ
function ifexit()
{
if(window.confirm('ȷ���˳���'))
 {
	parent.parent.location="../logout.php?USER_NAME=<?php echo $USER_NAME?>";
	parent.parent.close();
 // window.open("../logout.php?USER_NAME=<{$USER_NAME}>","�˳�ϵͳ","height=0,width=0,top=0,left=0");   //  �رյ�ǰ����
                                               // �رյ�ǰ����
 }
}

// ��������
function GoTable()
{
  parent.parent.table_index.table_main.location="../Interface/CRM/erp_mytable/crm_mytable.php";
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
*/
// <!--��������Ҽ�����-->

</script>

</head>
<body topmargin="0" leftmargin="0" rightmargin="0" padding="0" onselectstart="return false" >
<div id="topWrap">
	<h1><?php if(MAIN_TITLE!="") echo MAIN_TITLE;else echo "����Ƽ�CRMϵͳ";?></h1>
	<div id="topInner">
		<div class="topButton" onClick="javascript:ifexit();">
			<div class="topButton-inner">
			<span class="logout">�˳�</span>
			</div>
		</div>
		<div class="topButton" onClick="javascript:iflogout();">
			<div class="topButton-inner">
			<span class="relogin">ע��</span>
			</div>
		</div>
		<div class="topButton" onClick="javascript:GoTable();">
			<div class="topButton-inner">
			<span class="desktop">����</span>
			</div>
		</div>
	</div>
</div>



</body>
</html>
