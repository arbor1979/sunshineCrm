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
if ( $MANAGE_FLAG == "undefined" )
{
	$MANAGE_FLAG = "";
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

var allElements=document.getElementsByTagName("*");
function add_user(user_id,user_name)
{
	TO_VAL=parent_window.<?php echo $FORM_NAME?>.<?php echo $TO_ID?>.value;
	TO_NAME_VAL=parent_window.<?php echo $FORM_NAME?>.<?php echo $TO_NAME?>.value;
	TO_ID_VAL_Abled = TO_VAL.split(",");
	O_NAME_VAL_Abled = TO_NAME_VAL.split(",");
	
	if(user_id!='' && user_name!='')
	{
		if(TO_NAME_VAL.indexOf(user_id+",")<0)
		{
		
		parent_window.<?php echo $FORM_NAME?>.<?php echo $TO_ID?>.value += user_name+',';
		parent_window.<?php echo $FORM_NAME?>.<?php echo $TO_NAME?>.value += user_id+',';
		borderize_on(user_id);
		}	
		else
		{
		parent_window.<?php echo $FORM_NAME?>.<?php echo $TO_ID?>.value = TO_VAL.replace(user_name+',','');
		parent_window.<?php echo $FORM_NAME?>.<?php echo $TO_NAME?>.value =TO_NAME_VAL.replace(user_id+',','');
		borderize_off(user_id);
		}
	}
}
var oldClassName='';
 //��̬��js���class����
 function addClass(element, value) 
 {	
	 var cells = element.getElementsByTagName("td"); 
	 for(var i=0;i<cells.length;i++)
	 {
		  oldClassName = cells[i].className; //���ȱ���֮ǰ��classֵ
 		 if(!cells[i].className) {
  			cells[i].className = value; //���element��������class,��ֱ�����classΪvalue��ֵ
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
  			cells[i].className = oldClassName; //���element��������class,��ֱ�����classΪvalue��ֵ
	 }	 
 
 }
 
 //��꾭��ʱ������ʾ
 function highlightRows() {
  var rows = document.getElementsByTagName("tr");
  for(var i=0; i<rows.length; i++) {
	  if(rows[i].id=='')
		  continue;
	
   rows[i].onmouseover = function() {
    addClass(this, "TableRowHover"); //��꾭��ʱ���classΪhighlight��ֵ
    
   }
   rows[i].onmouseout = function() 
   {
	   removeClass(this);//����뿪ʱ��ԭ֮ǰ��classֵ
   }
  }
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
 
 window.onload = function() {
  highlightRows();
  begin_set();
 }

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
</script>
</head>
<body class="bodycolor" topmargin="1" leftmargin="0" >
<?php
$showfield=$_GET['showfield'];
$AddSql=$AddSql." where 1=1";


//������ơ�ƴ������������
if($_GET['action']=="SEARCH")	{
	$KEYVALUE = $_GET['KEYVALUE'];
	$AddSql = $AddSql." and (a.supplyname like '%$KEYVALUE%' or a.supplycn like '%$KEYVALUE%'  or b.supplyname like '%$KEYVALUE%' or b.supplyid like '%$KEYVALUE%')";
}

echo "<table class=\"TableBlock\" width=\"100%\"><tr class=TableHeader>  <td align=\"center\"><b>��Ӧ��</b></td><td align=center><b>��ϵ��</b></td><td align=center>$showfield</td>\r\n</tr>\r\n\r\n";

$sql = "select a.supplyname,b.supplyname as linkmanname,b.$showfield,b.rowid from supply a inner join supplylinkman b on a.rowid=b.supplyid $AddSql order by a.supplyname,b.supplyname";
$rs = $db->CacheExecute(150,$sql);
$rs_a = $rs->GetArray();

if(sizeof($rs_a)>0){
for($i=0;$i<sizeof($rs_a);$i++)			{
	$supplyname = $rs_a[$i]['supplyname'];
	$linkman=$rs_a[$i]['linkmanname'];
	$sf=$rs_a[$i][$showfield];
	$rowid=$rs_a[$i]['rowid'];
	echo "\r\n<tr id='".$rowid."' title='$sf' onclick=\"javascript:;add_user('";
	echo $rowid;
	echo "','";
	echo "".$sf."";
	echo "')\" style=\"cursor:pointer\">\r\n  <td  class=TableData align=\"left\" >";
	echo "".$supplyname."";
	echo "</td><td class=TableData>$linkman</td><td class=TableData>$sf</td>\r\n</tr>\r\n";
}
}else{


	echo "\r\n<tr class=\"TableData\">\r\n  <td class=\"menulines\" align=\"center\" colspan=3>";
	echo "<font color=\"red\">û�ж���</font>";
	echo "</td>\r\n</tr>\r\n";


}
echo "</table>";
echo "\r\n</body>\r\n</html>\r\n";
?>