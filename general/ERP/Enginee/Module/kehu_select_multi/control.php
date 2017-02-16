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
<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<link rel="stylesheet" type="text/css" href="<?php echo ROOT_DIR?>theme/<?php echo $LOGIN_THEME?>/style.css" />
<script src="../../../../../inc/js/ccorrect_btn.js"></script>
<script type="text/javascript" language="javascript" src="<?php echo ROOT_DIR?>general/ERP/Enginee/lib/common.js"></script>
<script language="javascript">
var allElements=parent.user.document.getElementsByTagName("*");
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
function clear_user()
{
	var allElements=parent.user.document.getElementsByTagName("*");
	for (step_i=0; step_i<allElements.length; step_i++)
	{
	    if(allElements[step_i].id!='') 
	    {
	    	parent_window.<?php echo $FORM_NAME?>.<?php echo $TO_ID?>.value = parent_window.<?php echo $FORM_NAME?>.<?php echo $TO_ID?>.value.replace(allElements[step_i].title+',','');
			parent_window.<?php echo $FORM_NAME?>.<?php echo $TO_NAME?>.value =parent_window.<?php echo $FORM_NAME?>.<?php echo $TO_NAME?>.value.replace(allElements[step_i].id+',','');
	    	borderize_off(allElements[step_i].id);
	    }
	}
}
function add_all_user()
{
	var allElements=parent.user.document.getElementsByTagName("*");
	var TO_NAME_VAL=parent_window.<?php echo $FORM_NAME?>.<?php echo $TO_NAME?>.value;
  for (step_i=0; step_i<allElements.length; step_i++)
  {
    if(allElements[step_i].id!='' && TO_NAME_VAL.indexOf(allElements[step_i].id+",")<0) 
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
	if(targetelement.className.indexOf("TableRowActive")< 0)
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
<?php

echo "<body class=\"bodycolor\"  topmargin=\"0\" leftmargin=\"0\">\r\n\r\n<table border=\"0\" cellspacing=\"1\" width=\"100%\" class=\"small\"  cellpadding=\"2\" align=\"center\">\r\n   <tr>\r\n     <td nowrap align=\"right\">\r\n <input type=\"button\" class=\"SmallButton\" value=\"全选\" onclick=\"add_all_user();\">&nbsp;&nbsp;<input type=\"button\" class=\"SmallButton\" value=\"清 空\" onclick=\"clear_user();\">&nbsp;&nbsp;<input type=\"button\" class=\"SmallButton\" value=\"关 闭\" onclick=\"parent.window.close();\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\r\n     </td>\r\n   </tr>\r\n</table>\r\n\r\n</body>\r\n</html>\r\n";
?>
