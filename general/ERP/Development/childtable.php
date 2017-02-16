<LINK href="<?php echo ROOT_DIR?>theme/3/style.css" type=text/css rel=stylesheet>
<script>
function check_all()
{
	
	var allElements=document.getElementsByTagName('input');	
for (i=0;i<allElements.length;i++)
{	
	
	if(allElements[i].name=="allbox") continue;
	if(allbox.checked && allElements[i].disabled == false)		
	{
		allElements[i].checked=true;
	}
	else if(allElements[i].disabled == false)		
		{
		allElements[i].checked=false;
	}
}
}
function saveSelect()
{
	var result="";
	var allElements=document.getElementsByTagName('input');	
	
	for (i=0;i<allElements.length;i++)
	{
		if(allElements[i].name=="allbox") continue;
		if(allElements[i].checked)
		{
			if(result!='')
				result=result+",";
			result=result+allElements[i].value;
		}
	}
	var obj = window.dialogArguments
	obj.value=result;
	window.close();
}
</script>
<?php
require_once('config.php');
require_once('../adodb/adodb.inc.php');
if($SYSTEM_MODE_DIR=="WUYE")	require_once('../Interface/WUYE/config.inc.php');
else						require_once('../config.inc.php');
require_once('../setting.inc.php');
require_once('../adodb/session/adodb-session2.php');

require_once('../Enginee/lib/init.php');
$tablename=$_GET['tablename'];
$columns=returntablecolumn($tablename);
$html_etc2=returnsystemlang($tablename);
$showlistfieldlist2=$_GET['showlistfieldlist2'];
$arrayfield=explode(",", $showlistfieldlist2);

print "<table border=1 cellspacing=0 class=small bordercolor=#000000 cellpadding=3 align=center width=100% style=\"border-collapse:collapse\">\n";
print "<tr><td class=TableHeader><input type=\"checkbox\" name=\"allbox\" onclick=\"check_all();\"></td><td class=TableHeader>编号</td><td class=TableHeader>字段</td><td class=TableHeader>名称</td></tr>";
for($i=0;$i<sizeof($columns);$i++)
{
	$selected="";
	for($j=0;$j<sizeof($arrayfield);$j++)
	{
		if($arrayfield[$j]==$i)
		{
			$selected="checked";
			break;
		}
	}
?>
	<tr><td><input type="checkbox" value=<?php echo $i?> name=selectid <?php echo $selected?>></td><td><?php echo $i?></td><td><?php echo $columns[$i]?></td><td><?php echo $html_etc2[$tablename][$columns[$i]]?></td></tr>
<?php
}
print "</table>";
?>
<p align=center><input type="button" value="确定" onclick="saveSelect();">&nbsp;<input type="button" value="关闭" onclick="window.close();"></p>