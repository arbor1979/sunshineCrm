<?php
require_once('../../../adodb/adodb.inc.php');
require_once('../../../config.inc.php');
require_once('../../../setting.inc.php');
require_once('../../../adodb/session/adodb-session2.php');
require_once('../../lib/select_menu.php');
$GLOBAL_SESSION=returnsession();
$TO_ID=urldecode($TO_ID);
$TO_NAME=urldecode($TO_NAME);
?>
<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<link rel="stylesheet" type="text/css" href="<?php echo ROOT_DIR?>theme/<?php echo $LOGIN_THEME?>/style.css" />
<script type="text/javascript" language="javascript" src="<?php echo ROOT_DIR?>general/ERP/Enginee/lib/common.js"></script>
<script type="text/javascript">
var allElements=document.getElementsByTagName("td");
function CheckSend()
{
	var kword=$("kword");
	if(kword.value=="按客户名称、拼音码搜索...")
	   kword.value="";
  if(kword.value=="" && $('search_icon').src.indexOf("../../../Framework/images/quicksearch.gif")==-1)
	{
	   $('search_icon').src="../../../Framework/images/quicksearch.gif";
	}
	if(key!=kword.value && kword.value!="")
	{
     key=kword.value;
	   parent.user.location="user.php?action=SEARCH&TO_ID=<?php echo $_GET['TO_ID']?>&TO_NAME=<?php echo $_GET['TO_NAME']?>&FORM_NAME=<?php echo $_GET['FORM_NAME']?>&KEYVALUE="+kword.value;
	   if($('search_icon').src.indexOf("../../../Framework/images/quicksearch.gif")>=0)
	   {
	   	   $('search_icon').src="../../../Framework/images/closesearch.gif";
	   	   $('search_icon').title="清除关键字";
	   	   $('search_icon').onclick=function(){kword.value='按客户名称搜索...';$('search_icon').src="../../../Framework/images/quicksearch.gif";$('search_icon').title="";$('search_icon').onclick=null;};
	   }
  }
  ctroltime=setTimeout(CheckSend,100);
}
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

function borderize_on(id)
{
	targetelement=document.getElementById(id);	
	if(targetelement.className.indexOf("TableRowActive") < 0)
	      targetelement.className = "TableRowActive";
  
}
function borderize_off(id)
{
	targetelement=document.getElementById(id);
   if(targetelement.className.indexOf("TableRowActive") >= 0)
      targetelement.className = 'menulines';
}
function begin_set()
{
  TO_VAL=parent_window.<?php echo $FORM_NAME?>.<?php echo $TO_NAME?>.value;
 
  for (step_i=0; step_i<allElements.length; step_i++)
  {
	  user_id=allElements[step_i].id;
	  if(user_id!='')
	  {

       if(TO_VAL.indexOf(user_id+",")>=0)
         borderize_on(user_id);
	  }
  }
}
function add_user(user_id,user_name)
{
	TO_VAL=parent_window.<?php echo $FORM_NAME?>.<?php echo $TO_ID?>.value;
	TO_NAME_VAL=parent_window.<?php echo $FORM_NAME?>.<?php echo $TO_NAME?>.value;
	
	TO_ID_VAL_Abled = TO_VAL.split(",");
	O_NAME_VAL_Abled = TO_NAME_VAL.split(",");
	
	if(user_id!='' && TO_VAL.indexOf(user_id+",")<0)
	{
		parent_window.<?php echo $FORM_NAME?>.<?php echo $TO_ID?>.value += user_id+',';
		parent_window.<?php echo $FORM_NAME?>.<?php echo $TO_NAME?>.value += user_name+',';
		borderize_on(user_name);
	}	
	else
	{
		parent_window.<?php echo $FORM_NAME?>.<?php echo $TO_ID?>.value = TO_VAL.replace(user_id+',','');
		parent_window.<?php echo $FORM_NAME?>.<?php echo $TO_NAME?>.value =TO_NAME_VAL.replace(user_name+',','');
		borderize_off(user_name);
	}
}
function clear_user()
{
	parent_window.<?php echo $FORM_NAME?>.<?php echo $TO_ID?>.value='';
	parent_window.<?php echo $FORM_NAME?>.<?php echo $TO_NAME?>.value='';
}

</script>
<?php

if ( $TO_ID == "" || $TO_ID == "undefined" )
{
	$TO_ID = "TO_ID";
	$TO_NAME = "TO_NAME";
}

$AddSql=$AddSql." where 1=1";
//添加所属用户条件
if($_GET['所属用户']!="")		{
	$AddSql =$AddSql." and sysuser='".$_GET['所属用户']."'";
}

//添加名称、拼音码搜索条件
if($_GET['action']=="SEARCH")	{
	$KEYVALUE = $_GET['KEYVALUE'];
	$AddSql = $AddSql." and (supplyname like '%$KEYVALUE%' or calling like '%$KEYVALUE%')";
}
//添加权限条件
$AddSql=getCustomerRoleByUser($AddSql,"sysuser");

//print_R($_GET);
//print $AddSql;


//色彩过滤
//style=\"background:#7D95A5;\"
print "<body class=\"bodycolor\" topmargin=\"1\" leftmargin=\"0\" onload=\"begin_set()\">
\r\n\r\n";

echo "<table class=\"TableBlock trHover\" width=\"100%\">\r\n<tr class=\"TableHeader\">\r\n  <td align=\"center\"><b>选择多个客户</b></td>\r\n</tr>\r\n\r\n";

$sql = "select supplyname,rowid from customer $AddSql order by supplyname limit 100";
$rs = $db->CacheExecute(150,$sql);
$rs_a = $rs->GetArray();

if(sizeof($rs_a)>0){
for($i=0;$i<sizeof($rs_a);$i++)			{
$email = $rs_a[$i]['email'];
$supplyname = $rs_a[$i]['supplyname'];
	$rowid=$rs_a[$i]['rowid'];
	echo "\r\n<tr class=\"TableData\">\r\n  <td  id='$rowid' title='$supplyname' align=\"center\" onclick=\"javascript:add_user('";
	echo $supplyname;
	echo "','";
	echo "".$rowid."";
	echo "')\" style=\"cursor:pointer\">";
	echo "".$supplyname."";
	echo "</td>\r\n</tr>\r\n";
}
}else{


	echo "\r\n<tr class=\"TableData\">\r\n  <td class=\"menulines\" align=\"center\" onclick=\"javascript:add_user()\" style=\"cursor:pointer\">";
	echo "<font color=\"red\">没有定义</font>";
	echo "</td>\r\n</tr>\r\n";

	
}

echo "</table>";
echo "\r\n</body>\r\n</html>\r\n";

?>
