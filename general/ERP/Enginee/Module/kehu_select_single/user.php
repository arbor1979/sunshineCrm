<?php
require_once('../../../adodb/adodb.inc.php');
require_once('../../../config.inc.php');
require_once('../../../setting.inc.php');
require_once('../../../adodb/session/adodb-session2.php');
require_once('../../lib/select_menu.php');
$GLOBAL_SESSION=returnsession();
$TO_ID=urldecode($TO_ID);
$TO_NAME=urldecode($TO_NAME);
if ( $TO_ID == "" || $TO_ID == "undefined" )
{
	$TO_ID = "TO_ID";
	$TO_NAME = "TO_NAME";
}

?>
<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<link rel="stylesheet" type="text/css" href="<?php echo ROOT_DIR?>theme/<?php echo $LOGIN_THEME?>/style.css" />
<link rel="stylesheet" type="text/css" href="<?php echo ROOT_DIR?>theme/<?php echo $LOGIN_THEME?>/menu_left.css" />
<script src="hover_tr.js"></script>
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
function click_node(the_id,checked,para_id,para_value)
{
	parent.user.location="children.php?MODULE_ID=&DEPT_ID="+the_id+"&CHECKED="+checked+"&"+para_id+"="+para_value;
}
</script>
<body>


<?php
echo "\r\n<script Language=\"JavaScript\">\r\n
var to_id=parent_window.";
echo $FORM_NAME;
echo ".";
echo $TO_ID;
echo ";
var to_name=parent_window.";
echo $FORM_NAME;
echo ".";
echo $TO_NAME;
echo ";
function add_user(user_id,user_name)\r\n{\r\n  
TO_VAL=to_id.value;\r\n  

if(TO_VAL.indexOf(\",\"+user_id+\",\")<0 && TO_VAL.indexOf(user_id+\",\")!=0)\r\n  
{\r\n    
	to_id.value=user_id;\r\n

	to_name.value=user_name;\r\n
	if(to_name.onchange!=null)
		to_name.onchange();
}\r\n  parent.close();\r\n}\r\n</script>\r\n</head>\r\n\r\n
<body class=\"bodycolor\" topmargin=\"1\" leftmargin=\"0\" >\r\n\r\n";
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

echo "<table class=\"TableBlock trHover\" width=\"100%\">\r\n<tr class=\"TableHeader\">\r\n  <td align=\"center\"><b>选择客户</b></td>\r\n</tr>\r\n\r\n";

$sql = "select supplyname,rowid,membercard from customer $AddSql order by supplyname limit 100";
$rs = $db->CacheExecute(150,$sql);
$rs_a = $rs->GetArray();

if(sizeof($rs_a)>0){
for($i=0;$i<sizeof($rs_a);$i++)			{
	$supplyname = $rs_a[$i]['supplyname'];
	$rowid=$rs_a[$i]['rowid'];
	echo "\r\n<tr class=\"TableData\">\r\n  <td class=\"menulines\" title=\"".$rs_a[$i]['membercard']."\" align=\"center\" onclick=\"javascript:;add_user('";
	echo $content=preg_replace("/\s+/", " ", $supplyname);
	echo "','";
	echo "".$rowid."";
	echo "')\" style=\"cursor:pointer\">";
	echo "".($supplyname)."";
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