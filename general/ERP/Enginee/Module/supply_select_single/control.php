<?php

require_once('../../../adodb/adodb.inc.php');
require_once('../../../config.inc.php');
require_once('../../../setting.inc.php');
require_once('../../../adodb/session/adodb-session2.php');

$GLOBAL_SESSION=returnsession();

if ( $TO_ID == "" || $TO_ID == "undefined" )
{
	$TO_ID = "TO_ID";
	$TO_NAME = "TO_NAME";
}
if ( $FORM_NAME == "" || $FORM_NAME == "undefined" )
{
	$FORM_NAME = "form1";
}
?>
<html>
<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<link rel="stylesheet" type="text/css" href="<?php echo ROOT_DIR?>theme/<?php echo $LOGIN_THEME?>/style.css" />
<link rel="stylesheet" type="text/css" href="<?php echo ROOT_DIR?>theme/<?php echo $LOGIN_THEME?>/menu_left.css" />
<script src="../../../../../inc/js/ccorrect_btn.js"></script>
<script type="text/javascript" language="javascript" src="<?php echo ROOT_DIR?>general/ERP/Enginee/lib/common.js"></script>
<script Language="JavaScript">
function getOpenner()
{
   if(parent.dialogArguments==null)
   {
      return parent.opener.document;
   }
   else
      return parent.dialogArguments.document;
}
var parent_window = getOpenner();
	var key='';
	function clear_user()
	{
		parent_window.<?php echo $FORM_NAME?>.<?php echo $TO_ID?>.value="";
	   	parent_window.<?php echo $FORM_NAME?>.<?php echo $TO_NAME?>.value="";
	}
	function CheckSend()
	{
		var kword=document.getElementById("kword");
		if(kword.value=="����Ӧ�����ơ�ƴ��������...")
		   kword.value="";
	  if(kword.value=="" && $('search_icon').src.indexOf("../../../Framework/images/quicksearch.gif")==-1)
		{
		   $('search_icon').src="../../../Framework/images/quicksearch.gif";
		}
		if(key!=kword.value )
		{
	     key=kword.value;
		   parent.user.location="user.php?action=SEARCH&TO_ID=<?php echo $_GET['TO_ID']?>&TO_NAME=<?php echo $_GET['TO_NAME']?>&FORM_NAME=<?php echo $_GET['FORM_NAME']?>&KEYVALUE="+kword.value;
		   if($('search_icon').src.indexOf("../../../Framework/images/quicksearch.gif")>=0)
		   {
		   	   $('search_icon').src="../../../Framework/images/closesearch.gif";
		   	   $('search_icon').title="����ؼ���";
		   	   $('search_icon').onclick=function(){kword.value='����Ӧ�����ơ�ƴ��������...';$('search_icon').src="../../../Framework/images/quicksearch.gif";$('search_icon').title="";$('search_icon').onclick=null;};
		   }
	  }
	  ctroltime=setTimeout(CheckSend,100);
	}
</script>
</head>
<body class="bodycolor"  topmargin="0" leftmargin="0">
<table border="0" cellspacing="1" width="100%" class="small"  cellpadding="2" align="center">
 <tr><td nowrap align="center">
 <div style="border:1px solid #000000;margin-left:2px;background:#FFFFFF;width:220px;">
  <input type="text" id="kword" name="kword" value="����Ӧ�����ơ�ƴ��������..." onfocus="ctroltime=setTimeout(CheckSend,100);" onblur="clearTimeout(ctroltime);if(this.value=='')this.value='����Ӧ�����ơ�ƴ��������...';" class="SmallInput" style="border:0px; color:#A0A0A0;width:190px;" ><img id="search_icon" src="../../../Framework/images/quicksearch.gif" align=absmiddle style="cursor:pointer;">
</div>
<td align="left">
 <input type="button" class="SmallButton" value="�� ��" onclick="clear_user();">
 <input type="button" class="SmallButton" value="�� ��" onclick="parent.close();">
 </td></tr></table>
 </body></html>