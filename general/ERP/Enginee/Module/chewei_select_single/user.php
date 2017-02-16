<?php
require_once('../../../adodb/adodb.inc.php');
require_once('../../../config.inc.php');
require_once('../../../setting.inc.php');
require_once('../../../adodb/session/adodb-session2.php');

$GLOBAL_SESSION=returnsession();


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
	if(kword.value=="按停车位名称搜索...")
	   kword.value="";
  if(kword.value=="" && $('search_icon').src.indexOf("/images/quicksearch.gif")==-1)
	{
	   $('search_icon').src="<?php echo ROOT_DIR?>images/quicksearch.gif";
	}
	if(key!=kword.value && kword.value!="")
	{
     key=kword.value;
	   parent.user.location="user.php?action=SEARCH&TO_ID=<?php echo $_GET['TO_ID']?>&TO_NAME=<?php echo $_GET['TO_NAME']?>&FORM_NAME=<?php echo $_GET['FORM_NAME']?>&KEYVALUE="+kword.value;
	   if($('search_icon').src.indexOf("/images/quicksearch.gif")>=0)
	   {
	   	   $('search_icon').src="<?php echo ROOT_DIR?>images/closesearch.gif";
	   	   $('search_icon').title="清除关键字";
	   	   $('search_icon').onclick=function(){kword.value='按停车位名称搜索...';$('search_icon').src="<?php echo ROOT_DIR?>images/quicksearch.gif";$('search_icon').title="";$('search_icon').onclick=null;};
	   }
  }
  ctroltime=setTimeout(CheckSend,100);
}
function click_node(the_id,checked,para_id,para_value)
{
	parent.user.location="children.php?MODULE_ID=&DEPT_ID="+the_id+"&CHECKED="+checked+"&"+para_id+"="+para_value;
}
</script><?php
echo "\r\n<script Language=\"JavaScript\">\r\nvar parent_window = parent.dialogArguments;\r\n";
if ( $TO_ID == "" || $TO_ID == "undefined" )
{
	$TO_ID = "TO_ID";
	$TO_NAME = "TO_NAME";
}
echo "function add_user(user_id,user_name)\r\n{\r\n  TO_VAL=parent_window.";
echo $FORM_NAME;
echo ".";
echo $TO_ID;
echo ".value;\r\n  if(TO_VAL.indexOf(\",\"+user_id+\",\")<0 && TO_VAL.indexOf(user_id+\",\")!=0)\r\n  {\r\n    parent_window.";
echo $FORM_NAME;
echo ".";
echo $TO_ID;
echo ".value=user_id;\r\n    parent_window.";
echo $FORM_NAME;
echo ".";
echo $TO_NAME;
echo ".value=user_name;\r\n  }\r\n  parent.close();\r\n}\r\n</script>\r\n</head>\r\n\r\n<body class=\"bodycolor\" topmargin=\"1\" leftmargin=\"0\" >\r\n\r\n";

if($_GET['停车场名称']!="")		{

	$AddSql = " where 停车场名称='".$_GET['停车场名称']."'";

}

//得到区域名称


if($_GET['action']=="SEARCH")	{
	$KEYVALUE = $_GET['KEYVALUE'];
	$AddSql = " where 停车位名称 like '%$KEYVALUE%'";
}//print_R($_GET);

//print $AddSql;

echo "<table class=\"TableBlock trHover\" width=\"100%\">\r\n<tr class=\"TableHeader\">\r\n  <td align=\"center\"><b>选择停车位</b></td>\r\n</tr>\r\n\r\n";

$sql = "select 停车位名称 from wu_tingchewei $AddSql order by 停车位名称 ";
$rs = $db->CacheExecute(150,$sql);
$rs_a = $rs->GetArray();

if(sizeof($rs_a)>0){
for($i=0;$i<sizeof($rs_a);$i++)			{
	$停车位名称 = $rs_a[$i]['停车位名称'];
   
    
	$a = $停车位名称;

	echo "\r\n<tr class=\"TableData\">\r\n  <td class=\"menulines\" align=\"center\" onclick=\"javascript:add_user('";
	echo $停车位名称;
	echo "','";
	echo "".$停车位名称."";
	echo "')\" style=\"cursor:pointer\">";
	echo "".$停车位名称."";
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
