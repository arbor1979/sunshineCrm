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

?>
<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<link rel="stylesheet" type="text/css" href="<?php echo ROOT_DIR?>theme/<?php echo $LOGIN_THEME?>/style.css" />

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
var oldClassName='';
//��̬��js����class����
function addClass(element, value) 
{	
	 var cells = element.getElementsByTagName("td"); 
	 for(var i=0;i<cells.length;i++)
	 {
		  oldClassName = cells[i].className; //���ȱ���֮ǰ��classֵ
		 if(!cells[i].className) {
			cells[i].className = value; //���element����������class,��ֱ������classΪvalue��ֵ
		 } else {
			cells[i].className += cells[i].className+" "+value; //���element֮ǰ��һ��classֵ��ע���м�Ҫ��һ���ո�,Ȼ���ټ���value��ֵ
		 }
	 }
}
function removeClass(element) 
{
	 var cells = element.getElementsByTagName("td"); 
	 for(var i=0;i<cells.length;i++)
	 {
		
		 if(cells[i].className)
			cells[i].className = oldClassName; //���element����������class,��ֱ������classΪvalue��ֵ
	 }	 

}

//��꾭��ʱ������ʾ
function highlightRows() {
var rows = document.getElementsByTagName("tr");
for(var i=0; i<rows.length; i++) {

	  if(rows[i].id=='')
		  continue;
	
rows[i].onmouseover = function() {
 addClass(this, "TableRowHover"); //��꾭��ʱ����classΪhighlight��ֵ
 
}
rows[i].onmouseout = function() 
{
	   removeClass(this);//����뿪ʱ��ԭ֮ǰ��classֵ
}
}
}
var allElements=document.getElementsByTagName("*");
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
window.onload = function() {
	  highlightRows();
	  begin_set();
	 }
<?php 

echo "
var to_id=parent_window.";
echo $FORM_NAME;
echo ".";
echo $TO_ID.";
var to_name=parent_window.";
echo $FORM_NAME;
echo ".";
echo $TO_NAME.";
function add_user(user_id,user_name)\r\n{\r\n  
TO_VAL=to_id.value;\r\n  
if(TO_VAL.indexOf(\",\"+user_id+\",\")<0 && TO_VAL.indexOf(user_id+\",\")!=0)\r\n  
{\r\n    
	to_id.value=user_id;\r\n    
	to_name.value=user_name;\r\n  
	if(to_name.onchange!=null)
		to_name.onchange();
}\r\n  
parent.close();\r\n}\r\n</script>\r\n</head>\r\n\r\n
<body class=\"bodycolor\" topmargin=\"1\" leftmargin=\"0\" >\r\n\r\n";
$AddSql=$AddSql." where 1=1";


//�������ơ�ƴ������������
if($_GET['action']=="SEARCH")	{
	$KEYVALUE = $_GET['KEYVALUE'];
	$AddSql = $AddSql." and (ROWID='$KEYVALUE' or supplyname like '%$KEYVALUE%' or supplycn like '%$KEYVALUE%')";
}

//print_R($_GET);
//print $AddSql;

echo "<table class=\"TableBlock trHover\" width=\"100%\">\r\n<tr class=\"TableHeader\">\r\n  <td align=\"center\"><b>ѡ��ͻ�</b></td>\r\n</tr>\r\n\r\n";

$sql = "select supplyname,rowid from supply $AddSql order by supplyname ";
$rs = $db->CacheExecute(150,$sql);
$rs_a = $rs->GetArray();

if(sizeof($rs_a)>0){
for($i=0;$i<sizeof($rs_a);$i++)			{
	$supplyname = $rs_a[$i]['supplyname'];
	$rowid=$rs_a[$i]['rowid'];
	echo "\r\n<tr class=\"TableData\" id='rowline'>\r\n  <td class=\"menulines\" align=\"center\" onclick=\"javascript:;add_user('";
	echo $supplyname;
	echo "','";
	echo "".$rowid."";
	echo "')\" style=\"cursor:pointer\">";
	echo "".$supplyname."";
	echo "</td>\r\n</tr>\r\n";
}
}else{


	echo "\r\n<tr class=\"TableData\">\r\n  <td class=\"menulines\" align=\"center\" onclick=\"javascript:add_user()\" style=\"cursor:pointer\">";
	echo "<font color=\"red\">û�ж���</font>";
	echo "</td>\r\n</tr>\r\n";


}
echo "</table>";
echo "\r\n</body>\r\n</html>\r\n";
?>