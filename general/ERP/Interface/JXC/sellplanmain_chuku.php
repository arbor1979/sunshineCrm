<?php
ini_set('display_errors',1);
ini_set('error_reporting',E_ALL);
error_reporting(E_WARNING | E_ERROR);
require_once("lib.inc.php");
$GLOBAL_SESSION=returnsession();
//print_r($_GET);
page_css();
	
	global $db;
	$sql="select * from sellplanmain_detail where chukunum<>num and mainrowid=".$_GET["billid"];
	$rs=$db->Execute($sql);
	$rs_a = $rs->GetArray();
	$sql="select * from stock";
	$rs=$db->Execute($sql);
	$rs_b = $rs->GetArray();
?>
<script language = "JavaScript"> 

function FormCheck() 
{
	if (document.form1.stock.value == "") {
		alert("��ѡ������ֿ⣡");
 		return false;
 	}
	var sbtn=document.getElementsByName('submit');
	for(i=0;i<sbtn.length;i++)
	{
		sbtn[i].value='�ύ��';
		sbtn[i].disabled=true;
	}
	return true;
}
</script>
</head>
<body class=bodycolor topMargin=5>
1���˶Կ���������̣����&gt;�������󣻺죺���&lt;��������
<table class=TableBlock align=center width=100% >
<tr class=TableHeader>
<td nowrap align=center>��Ʒ���</td>
<td nowrap align=center>����</td>
<td nowrap align=center>��ɫ</td>
<td nowrap align=center>���</td>
<td nowrap align=center>��λ</td>
<td nowrap align=center>��������</td>
<?php
for($i=0;$i<sizeof($rs_b);$i++)
{
	print "<td nowrap align=center>".$rs_b[$i]['name']."</td>";
}
print "</tr>";
$allnum=0;
$allmoney=0;
for($i=0;$i<sizeof($rs_a);$i++)
{
	$ifkucun = returntablefield( "product", "productid", $rs_a[$i]['prodid'], "ifkucun" );
	
	$allnum=$allnum+($rs_a[$i]['num']-$rs_a[$i]['chukunum']);
	$allmoney=$allmoney+($rs_a[$i]['num']-$rs_a[$i]['chukunum'])*$rs_a[$i]['price']*$rs_a[$i]['zhekou'];
	print "<tr class=TableData><td nowrap>".$rs_a[$i]['prodid']."</td>";
	print "<td nowrap>".$rs_a[$i]['prodname']."</td>";
	print "<td nowrap>".$rs_a[$i]['prodguige']."</td>";
	print "<td nowrap>".$rs_a[$i]['prodxinghao']."</td>";
	print "<td nowrap>".$rs_a[$i]['proddanwei']."</td>";
	print "<td nowrap align=right>".($rs_a[$i]['num']-$rs_a[$i]['chukunum'])."</td>";
	for($j=0;$j<sizeof($rs_b);$j++)
	{
		$kucun=0;
		$color="green";
		$sql="select * from store where storeid=".$rs_b[$j]['ROWID']." and prodid='".$rs_a[$i]['prodid']."'";
		$rs=$db->Execute($sql);
		$rs_c = $rs->GetArray();
		if(sizeof($rs_c)>0)
			$kucun=$rs_c[0]['num'];
		if($kucun<$rs_a[$i]['num'])
			$color="red";
		if($ifkucun=="��")
		{
			$kucun="����";
			$color="black";
		}
		print "<td nowrap align=center><font color=$color>".$kucun."</font></td>";
	}
	print "</tr>";
} 
?>
</table>
<br>


<FORM name=form1 onsubmit="return FormCheck();" 
 action="sellplanmain_newai.php?action=edit_default2_data" method=post encType=multipart/form-data>
2��ѡ�����ֿ� ��<select name="stock">
 <?php
 for($i=0;$i<sizeof($rs_b);$i++)
{
	print "<option value=".$rs_b[$i]['ROWID'].">".$rs_b[$i]['name']."</option>";
}
 ?>
 </select>
 <p align=center>
 <input type="hidden" name="billid" value="<?php echo $_GET["billid"]?>">
 <input type="hidden" name="allnum" value="<?php echo $allnum?>">
 <input type="hidden" name="allmoney" value="<?php echo $allmoney?>">
<input type="submit" class="SmallButton" name='submit' value="ȷ�����ɳ���">
<input type="button" class="SmallButton" value=" ���� " onclick="location='sellplanmain_newai.php';">
</p></form>

</body></html>