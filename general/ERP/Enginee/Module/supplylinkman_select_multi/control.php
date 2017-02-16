<?php

require_once('../../../adodb/adodb.inc.php');
require_once('../../../config.inc.php');
require_once('../../../setting.inc.php');
require_once('../../../adodb/session/adodb-session2.php');

$GLOBAL_SESSION=returnsession();
$showfield=$_GET['showfield'];
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
		var allElements=parent.user.document.getElementsByTagName("tr");
		var to_name=parent_window.<?php echo $FORM_NAME?>.<?php echo $TO_NAME?>;
		var to_id=parent_window.<?php echo $FORM_NAME?>.<?php echo $TO_ID?>;
		to_id.value='';
		to_name.value='';
		for (step_i=0; step_i<allElements.length; step_i++)
		{
		    if(allElements[step_i].id!='') 
		    {

		    	borderize_off(allElements[step_i].id);
		    }
		}
	}
	function CheckSend()
	{
		var kword=$("kword");
		if(kword.value=="按供应商、联系人名称、拼音码搜索...")
		   kword.value="";
	  if(kword.value=="" && $('search_icon').src.indexOf("../../../Framework/images/quicksearch.gif")==-1)
		{
		   $('search_icon').src="../../../Framework/images/quicksearch.gif";
		}
		if(key!=kword.value)
		{
	     key=kword.value;
		   parent.user.location="user.php?action=SEARCH&TO_ID=<?php echo $_GET['TO_ID']?>&TO_NAME=<?php echo $_GET['TO_NAME']?>&FORM_NAME=<?php echo $_GET['FORM_NAME']?>&KEYVALUE="+kword.value+"&showfield=<?php echo $showfield?>";
		   if($('search_icon').src.indexOf("../../../Framework/images/quicksearch.gif")>=0)
		   {
		   	   $('search_icon').src="../../../Framework/images/closesearch.gif";
		   	   $('search_icon').title="清除关键字";
		   	   $('search_icon').onclick=function(){kword.value='按供应商、联系人名称、拼音码搜索...';$('search_icon').src="../../../Framework/images/quicksearch.gif";$('search_icon').title="";$('search_icon').onclick=null;};
		   }
	  }
	  ctroltime=setTimeout(CheckSend,100);
	}
	function add_all_user()
	{
		var allElements=parent.user.document.getElementsByTagName("tr");
		var TO_NAME_VAL=parent_window.<?php echo $FORM_NAME?>.<?php echo $TO_NAME?>.value;
	  for (step_i=0; step_i<allElements.length; step_i++)
	  {
	    if(allElements[step_i].id!='' && allElements[step_i].title!='' && TO_NAME_VAL.indexOf(allElements[step_i].id+",")<0) 
	    {
	    	parent_window.<?php echo $FORM_NAME?>.<?php echo $TO_ID?>.value += allElements[step_i].title+',';
			parent_window.<?php echo $FORM_NAME?>.<?php echo $TO_NAME?>.value += allElements[step_i].id+',';
	        borderize_on(allElements[step_i].id);
	    }
	  }
	}
	 function borderize_on(id)
	 {
	 	targetelement=parent.user.document.getElementById(id);	
	 	if(targetelement.className.indexOf("TableRowActive") < 0)
	 	      targetelement.className = "TableRowActive";
	   
	 }
	 function borderize_off(id)
	 {
	 	targetelement=parent.user.document.getElementById(id);
	    if(targetelement.className.indexOf("TableRowActive") >= 0)
	       targetelement.className = '';
	 }
</script>
</head>
<body class="bodycolor"  topmargin="0" leftmargin="0">
<table border="0" cellspacing="1" width="100%" class="small"  cellpadding="2" align="center">
 <tr><td nowrap align="center">
 <div style="border:1px solid #000000;margin-left:2px;background:#FFFFFF;width:220px;">
  <input type="text" id="kword" name="kword" value="按供应商、联系人名称、拼音码搜索..." onfocus="ctroltime=setTimeout(CheckSend,100);" onblur="clearTimeout(ctroltime);if(this.value=='')this.value='按供应商、联系人名称、拼音码搜索...';" class="SmallInput" style="border:0px; color:#A0A0A0;width:190px;" ><img id="search_icon" src="../../../Framework/images/quicksearch.gif" align=absmiddle style="cursor:pointer;">
</div>
<td align="left">
 <input type="button" class="SmallButton" value="全选" onclick="add_all_user();">
 <input type="button" class="SmallButton" value="清 空" onclick="clear_user();">
 <input type="button" class="SmallButton" value="关 闭" onclick="parent.close();">
 </td></tr></table>
 </body></html>