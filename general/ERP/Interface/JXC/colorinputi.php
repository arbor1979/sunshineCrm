<?php
ini_set('display_errors',1);
ini_set('error_reporting',E_ALL);
error_reporting(E_WARNING | E_ERROR);
require_once("lib.inc.php");
$GLOBAL_SESSION=returnsession();
$tablename=$_GET['tablename'];
$id=$_GET['id'];

if($tablename=='buyplanmain_detail_color')
{
	$sql="select * from buyplanmain_detail where id=$id";
	$rs = $db->Execute($sql);
	$rs_a = $rs->GetArray(); 
	if(sizeof($rs_a)!=1)
	{
		print_infor("�����ڴ˼�¼","forbidden","close");
		exit;
	}
	$sql="select * from productcolor";
	$rs = $db->Execute($sql);
	$rs_b = $rs->GetArray(); 
?>
<form name="form2">
<table align=center class=TableBlock width=100% border=0 id="table1">
<tr >
	<td align=center class=TableHeader>ԭ����</td>
	<td align=center class=TableHeader>��ǰ���</td>
    <td align=center class=TableHeader></td>
<?php 
	for($i=0;$i<sizeof($rs_b);$i++)
	{
		print "<td align=center class=TableHeader>".$rs_b[$i]["name"]."</td>";
	}
?>
</tr>
</table>
</form>
<?php 
}?>