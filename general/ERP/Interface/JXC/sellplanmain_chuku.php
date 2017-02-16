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
		alert("请选择出货仓库！");
 		return false;
 	}
	var sbtn=document.getElementsByName('submit');
	for(i=0;i<sbtn.length;i++)
	{
		sbtn[i].value='提交中';
		sbtn[i].disabled=true;
	}
	return true;
}
</script>
</head>
<body class=bodycolor topMargin=5>
1、核对库存数量（绿：库存&gt;出库需求；红：库存&lt;出库需求）
<table class=TableBlock align=center width=100% >
<tr class=TableHeader>
<td nowrap align=center>产品编号</td>
<td nowrap align=center>名称</td>
<td nowrap align=center>颜色</td>
<td nowrap align=center>规格</td>
<td nowrap align=center>单位</td>
<td nowrap align=center>需求数量</td>
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
		if($ifkucun=="否")
		{
			$kucun="不计";
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
2、选择出库仓库 ：<select name="stock">
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
<input type="submit" class="SmallButton" name='submit' value="确认生成出库">
<input type="button" class="SmallButton" value=" 返回 " onclick="location='sellplanmain_newai.php';">
</p></form>

</body></html>