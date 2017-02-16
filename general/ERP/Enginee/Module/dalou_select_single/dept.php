<?php

require_once('../../../adodb/adodb.inc.php');
require_once('../../../config.inc.php');
require_once('../../../setting.inc.php');
require_once('../../../adodb/session/adodb-session2.php');

$GLOBAL_SESSION=returnsession();
//print_R($db);exit;

?>

<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<link rel="stylesheet" type="text/css" href="<?php echo ROOT_DIR?>theme/<?php echo $LOGIN_THEME?>/style.css" />
<link rel="stylesheet" type="text/css" href="<?php echo ROOT_DIR?>theme/<?php echo $LOGIN_THEME?>/menu_left.css" />

<script src="/inc/js/hover_tr.js"></script>
<script type="text/javascript">
var $ = function(id) {return document.getElementById(id);};
var CUR_ID="2";
function clickMenu(ID)
{
    var el=$("module_"+CUR_ID);
    var link=$("link_"+CUR_ID);
    if(ID==CUR_ID)
    {
       if(el.style.display=="none")
       {
           el.style.display='';
           link.className="active";
       }
       else
       {
           el.style.display="none";
           link.className="";
       }
    }
    else
    {
       el.style.display="none";
       link.className="";
       $("module_"+ID).style.display="";
       $("link_"+ID).className="active";
    }

    CUR_ID=ID;
}
function ShowSelected()
{
   parent.user.location="user.php?TO_ID=TO_ID&TO_NAME=TO_NAME&FORM_NAME=form1";
}
var ctroltime=null,key="";
function CheckSend()
{
	var kword=$("kword");
	if(kword.value=="按房间名称搜索...")
	   kword.value="";
  if(kword.value=="" && $('search_icon').src.indexOf("/images/quicksearch.gif")==-1)
	{
	   $('search_icon').src="../../../Framework/images/quicksearch.gif";
	}
	if(key!=kword.value )
	{
     key=kword.value;
	   parent.user.location="user.php?action=SEARCH&TO_ID=<?php echo $_GET['TO_ID']?>&TO_NAME=<?php echo $_GET['TO_NAME']?>&FORM_NAME=<?php echo $_GET['FORM_NAME']?>&KEYVALUE="+kword.value;
	   if($('search_icon').src.indexOf("/images/quicksearch.gif")>=0)
	   {
	   	   $('search_icon').src="../../../Framework/images/quicksearch.gif";
	   	   $('search_icon').title="清除关键字";
	   	   $('search_icon').onclick=function(){kword.value='按房间名称搜索...';$('search_icon').src="../../../Framework/images/quicksearch.gif";$('search_icon').title="";$('search_icon').onclick=null;};
	   }
  }
  ctroltime=setTimeout(CheckSend,100);
}
function click_node(the_id,checked,para_id,para_value)
{
	parent.user.location="children.php?MODULE_ID=&DEPT_ID="+the_id+"&CHECKED="+checked+"&"+para_id+"="+para_value;
}
</script>
</head>

<body class="bodycolor"  topmargin="1" leftmargin="0">
<div style="border:1px solid #000000;margin-left:2px;background:#FFFFFF;">
  <input type="text" id="kword" name="kword" value="按房间名称搜索..." onfocus="ctroltime=setTimeout(CheckSend,100);" onblur="clearTimeout(ctroltime);if(this.value=='')this.value='按房间名称搜索...';" class="SmallInput" style="border:0px; color:#A0A0A0;width:145px;"><img id="search_icon" src="../../../Framework/images/quicksearch.gif" align=absmiddle style="cursor:pointer;">
</div>

<table class="TableBlock trHover" width="100%" align="center">

<?php
print "
	<tr class=TableHeader>
	<td align=center >大楼名称列表</td>
	</tr>
	";

$sql = "select * from wu_buildinginformation order by 大楼名称";
$rs = $db->CacheExecute(150,$sql);
$rs_a = $rs->GetArray();
for($i=0;$i<sizeof($rs_a);$i++)			{
	$大楼名称 = $rs_a[$i]['大楼名称'];
	print "
	<tr class=TableData>
	<td align=center onclick=\"javascript:parent.user.location='user.php?大楼名称=$大楼名称&TO_ID=".$_GET['TO_ID']."&TO_NAME=".$_GET['TO_NAME']."&FORM_NAME=".$_GET['FORM_NAME']."';\" style=\"cursor:pointer\">".$大楼名称."</td>
	</tr>
	";
}
?>

</table>

</body>
</html>
