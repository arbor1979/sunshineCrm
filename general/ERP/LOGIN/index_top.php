<?php
header("Content-type:text/html;charset=gb2312");
?>
<html>
<head>
<title>ϵͳ������</title>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<link rel="stylesheet" type="text/css" href="../theme/1/style.css">
<script language="JavaScript">

// ��ʾ�������ĵ�ǰʱ��
var OA_TIME = new Date();
function timeview()
{
  timestr=OA_TIME.toLocaleString();
  timestr=timestr.substr(timestr.indexOf(" "));
  OA_TIME.setSeconds(OA_TIME.getSeconds()+1);
  window.setTimeout( "timeview()", 1000 );
}

// ѯ��ע��ϵͳ
function iflogout()
{
if(window.confirm('ȷ�����µ�¼��'))
 {
  parent.parent.location="../logout.php?USER_NAME=admin";        // ҳ����ת
 }
}

// ѯ���˳�ϵͳ
function ifexit()
{
if(window.confirm('ȷ���˳���'))
 {
  window.open("../logout.php?USER_NAME=admin","�˳�ϵͳ","height=0,width=0,top=0,left=0");   //  �رյ�ǰ����   
  parent.parent.close();                                                // �رյ�ǰ���� 
 }
}

// ��������
function GoTable()
{
  parent.parent.table_index.table_main.location="../Interface/CRM/crm_customer_newai.php";
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
<body topmargin="0" leftmargin="0" rightmargin="0" padding="0" onselectstart="return false" onload="timeview();">
<div id="topWrap">
	<h1>�ͻ���Դ����ϵͳ �������ƽ̨CRM��ҵ�汾</h1>
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
