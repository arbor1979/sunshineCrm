<?php
ini_set('display_errors',1);
ini_set('error_reporting',E_ALL);
error_reporting(E_WARNING | E_ERROR);
require_once("lib.inc.php");
$GLOBAL_SESSION=returnsession();
$tablename=$_GET['tablename'];
$id=$_GET['id'];
$totalnum=$_GET['num'];
page_css();
?>
<script type="text/javascript" language="javascript" src="<?php echo ROOT_DIR?>general/ERP/Enginee/lib/CheckValue.js"></script>
<script type="text/javascript" language="javascript" src="<?php echo ROOT_DIR?>general/ERP/Enginee/jquery/jquery.js"></script>
<script type="text/javascript">

var allnum=0;
function parseInteger(strnum)
{
	
	if(isNaN(parseInt(strnum)))
		return 0;
	else
		return 	parseInt(strnum);	
}
</script>
<?php
if($tablename=='store_color')
{
	
	$sql="select * from store_product where id=$id";
	$rs = $db->Execute($sql);
	$rs_a = $rs->GetArray(); 
	if(sizeof($rs_a)!=1)
	{
		print_infor("不存在此记录","forbidden","close");
		exit;
	}
	$canedit=false;
	$storeid=returntablefield("store","id",$id,"storeid");
	$storeuser=returntablefield("stock","rowid",$storeid,"user_id");
	$storeuserArray=explode(",", $storeuser);
	if(in_array($_SESSION['LOGIN_USER_ID'], $storeuserArray))
		$canedit=true;
	$sql="select * from productcolor";
	$rs = $db->Execute($sql);
	$rs_b = $rs->GetArray(); 
?>
<script type="text/javascript">
var totalnum=<?php echo $rs_a[0]['num']?>;
function countAll()
{
	allnum=0;
	$("input:text", document.forms[0]).each(function()
	{	
		allnum=allnum+parseInteger(this.value);
	}); 
	$("#allnum").html(allnum);
	if(totalnum!=allnum)
		$("#tip").html("&nbsp;<font color=red>合计数 "+allnum+" 不等于库存数 "+totalnum+"</font>");
	else
		$("#tip").html("&nbsp;<font color=green>合计数等于本次入库数 "+totalnum+"</font>");
}
function saveAndClose()
{
	if(totalnum!=allnum)
	{
		alert("合计数 "+allnum+" 不等于库存数 "+totalnum+"，请调整后再保存");
		return false;
	}
	var colorarray=[];
	$("input:text", document.forms[0]).each(function(){colorarray.push(parseInteger(this.value));}); 
	$.ajax({ 
		  type:'GET', 
		  url:'store_product_newai.php?rowid=<?php echo $id?>&action=colorinput&colorarray=' + colorarray.toString(), 
		  dataType: 'text', 
		  cache:false,
		  async: false,
		  success:function(data) 
		  { 
			  if(data=='ok')
			  {
			  	parent.location.reload();
			  }
			  else
				alert(data);
			  	
		  },
		  error:function(XmlHttpRequest,textStatus, errorThrown)
	  	  {
			  alert('出错：'+errorThrown);
	  	  }
	});
}
</script>
<form name="form2">
<table align=center class=TableBlock width=98% border=0 id="table1">
<tr >
	<td align=center class=TableHeader><?php echo $rs_a[0]['productname']?></td>
    
<?php 
	for($i=0;$i<sizeof($rs_b);$i++)
	{
		print "<td align=center class=TableHeader>".$rs_b[$i]["name"]."</td>";
	}
?>
	<td align=center class=TableHeader>合计</td>
</tr>
<tr>
	<td align=center class=TableLine1>当前库存</td>
<?php 
	$total=0;
	for($i=0;$i<sizeof($rs_b);$i++)
	{
		$num=0;
		$sql="select * from store_color where id=$id and color=".$rs_b[$i]["id"];
		$rs = $db->Execute($sql);
		$rs_c = $rs->GetArray(); 
		if(sizeof($rs_c)==1)
			$num=$rs_c[0]['num'];
		if($canedit)	
			print "<td align=center class=TableLine2><input type=text size=6 class='SmallInput' id='input_".$rs_b[$i]["id"]."' value='$num' onkeypress=\"check_input_num('NUMBER');\" onchange=\"countAll()\"></td>";
		else 
			print "<td align=center class=TableLine2>$num</td>";
		$total=$total+$num;
	}
?>
	<td align=center class=TableLine1><div id='allnum'><?php echo $total?></div></td>
</tr>

</table>
<br>
<div id="tip">&nbsp;库存数为：<?php echo $rs_a[0]['num']?></div>
<p align=center>
<p align=center><input type="button" class='SmallButton'  value=" 保存 " onclick="saveAndClose()">&nbsp;&nbsp;<input type="button" class="SmallButton"  value=" 关闭 " onclick="parent.pop.close()"></p>
</form>

<?php 
}
if($tablename=='buyplanmain_detail_color')
{
	$sql="select * from buyplanmain_detail where id=$id";
	$rs = $db->Execute($sql);
	$rs_a = $rs->GetArray(); 
	if(sizeof($rs_a)!=1)
	{
		print_infor("不存在此记录","forbidden","close");
		exit;
	}
	$sql="select * from productcolor";
	$rs = $db->Execute($sql);
	$rs_b = $rs->GetArray(); 
?>
<script type="text/javascript">
var totalnum=<?php echo $rs_a[0]['num']-$rs_a[0]['recnum']?>;
function countAll()
{
	allnum=0;
	$("input:text", document.forms[0]).each(function()
	{	
		allnum=allnum+parseInteger(this.value);
	}); 
	$("#allnum").html(allnum);
	if(totalnum<allnum)
		$("#tip").html("&nbsp;<font color=red>本次入库数 "+allnum+" 不能大于采购数 "+totalnum+"</font>");
	else if(totalnum>allnum)
		$("#tip").html("&nbsp;<font color=blue>本次入库数 "+allnum+" 小于采购数 "+totalnum+"</font>");
	else
		$("#tip").html("&nbsp;<font color=green>本次入库数等于采购数 "+totalnum+"</font>");
}
function saveAndClose()
{
	if(totalnum<allnum)
	{
		alert("本次入库数 "+allnum+" 不能大于采购数 "+totalnum+"，请调整后再保存");
		return false;
	}
	var colorarray=[];
	$("input:text", document.forms[0]).each(function(){colorarray.push(parseInteger(this.value));}); 
	$.ajax({ 
		  type:'GET', 
		  url:'buyplanmain_mingxi_update.php?tablename=buyplanmain_tmp&rowid=<?php echo $id?>&action=colorinput&colorarray=' + colorarray.toString(), 
		  dataType: 'text', 
		  cache:false,
		  async: false,
		  success:function(data) 
		  { 
			  if(data=='ok')
			  {
				  parent.document.getElementById('num_'+<?php echo $id?>).value=allnum;
				  parent.document.getElementById("img_"+<?php echo $id?>).src='<?php echo ROOT_DIR."general/ERP/Framework/images/sepan.gif"?>';
				  parent.CountRecJine(<?php echo $id?>);
				  parent.pop.close();
			  }
			  else
				alert(data);
			  	
		  },
		  error:function(XmlHttpRequest,textStatus, errorThrown)
	  	  {
			  alert('出错：'+errorThrown);
	  	  }
	});
}
</script>
<form name="form2">
<table align=center class=TableBlock width=98% border=0 id="table1">
<tr >
	<td align=center class=TableHeader><?php echo $rs_a[0]['prodname']?></td>
    
<?php 
	for($i=0;$i<sizeof($rs_b);$i++)
	{
		print "<td align=center class=TableHeader>".$rs_b[$i]["name"]."</td>";
	}
?>
	<td align=center class=TableHeader>合计</td>
</tr>
<tr>
	<td align=center class=TableLine1>当前库存</td>
<?php 
	$total=0;
	for($i=0;$i<sizeof($rs_b);$i++)
	{
		$sql="select sum(b.num) as allnum from store a inner join store_color b on a.id=b.id where a.prodid='".$rs_a[0]['prodid']."' and b.color=".$rs_b[$i]["id"];
		$rs = $db->Execute($sql);
		$rs_c = $rs->GetArray(); 
		print "<td align=center class=TableLine1>".$rs_c[0]["allnum"]."</td>";
		$total=$total+$rs_c[0]["allnum"];
	}
?>
	<td align=center class=TableLine1><?php echo $total?></td>
</tr>
<tr>
	<td align=center class=TableLine2>本次入库</td>
	<?php 
	$total=0;
	for($i=0;$i<sizeof($rs_b);$i++)
	{
		$num=0;
		$sql="select * from buyplanmain_tmp_color where id=$id and color=".$rs_b[$i]["id"];
		$rs = $db->Execute($sql);
		$rs_c = $rs->GetArray(); 
		if(sizeof($rs_c)==1)
			$num=$rs_c[0]['num'];
			
		print "<td align=center class=TableLine2><input type=text size=6 class='SmallInput' id='input_".$rs_b[$i]["id"]."' value='$num' onkeypress=\"check_input_num('NUMBER');\" onchange=\"countAll()\"></td>";
		$total=$total+$num;
	}
?>
<td align=center class=TableLine2 ><div id='allnum'><?php echo $total?></div></td>
</tr>
</table>
<br>
<div id="tip">&nbsp;本次入库数为：<?php echo $rs_a[0]['num']-$rs_a[0]['recnum']?></div>
<p align=center><input type="button" class='SmallButton'  value=" 保存 " onclick="saveAndClose()">&nbsp;&nbsp;<input type="button" class="SmallButton"  value=" 关闭 " onclick="parent.pop.close()"></p>
</form>
<script type="text/javascript">
<!--
allnum=<?php echo $total?>;
//-->
</script>
<?php 
}else if($tablename=='sellplanmain_detail_tmp_color' || $tablename=='sellplanmain_detail_color')
{
	$detailtablename=str_replace("_color","", $tablename);
	$sql="select * from $detailtablename where id=$id";
	$rs = $db->Execute($sql);
	$rs_a = $rs->GetArray(); 
	if(sizeof($rs_a)!=1)
	{
		print_infor("不存在此记录","forbidden","close");
		exit;
	}
	$storeid=returntablefield("sellplanmain","billid",$rs_a[0]['mainrowid'],"storeid");
	$sql="select * from productcolor";
	$rs = $db->Execute($sql);
	$rs_b = $rs->GetArray(); 
?>
<script type="text/javascript">
var totalnum=<?php echo $rs_a[0]['num']?>;
function countAll()
{
	allnum=0;
	$("input:text", document.forms[0]).each(function()
	{	
		allnum=allnum+parseInteger(this.value);
	}); 
	$("#allnum").html(allnum);
	
}
function saveAndClose()
{
	if(allnum==0)
	{
		alert("合计数不能为0，请调整后再保存");
		return false;
	}
	var colorarray=[];
	$("input:text", document.forms[0]).each(function(){colorarray.push(parseInteger(this.value));}); 
	$.ajax({ 
		  type:'GET', 
		  url:'buyplanmain_mingxi_update.php?tablename=<?php echo $detailtablename?>&rowid=<?php echo $id?>&action=colorinput&colorarray=' + colorarray.toString(), 
		  dataType: 'text', 
		  cache:false,
		  async: false,
		  success:function(data) 
		  { 
			  if(data=='ok')
			  {
				  parent.document.getElementById('num_'+<?php echo $id?>).value=allnum;
				  parent.document.getElementById("img_"+<?php echo $id?>).src='<?php echo ROOT_DIR."general/ERP/Framework/images/sepan.gif"?>';
				  parent.updateAmount(<?php echo $id?>,allnum);
				  parent.pop.close();
			  }
			  else
				alert(data);
			  	
		  },
		  error:function(XmlHttpRequest,textStatus, errorThrown)
	  	  {
			  alert('出错：'+errorThrown);
	  	  }
	});
}
</script>
<form name="form2">
<table align=center class=TableBlock width=98% border=0 id="table1">
<tr >
	<td align=center class=TableHeader><?php echo $rs_a[0]['prodname']?></td>
    
<?php 
	for($i=0;$i<sizeof($rs_b);$i++)
	{
		print "<td align=center class=TableHeader>".$rs_b[$i]["name"]."</td>";
	}
?>
	<td align=center class=TableHeader>合计</td>
</tr>
<tr>
	<td align=center class=TableLine1>当前库存</td>
<?php 
	$total=0;
	
	for($i=0;$i<sizeof($rs_b);$i++)
	{
		$sql="select sum(b.num) as allnum from store a inner join store_color b on a.id=b.id where a.prodid='".$rs_a[0]['prodid']."'";
		if($storeid!='')
			$sql.=" and a.storeid=$storeid";
		$sql.=" and b.color=".$rs_b[$i]["id"];
		$rs = $db->Execute($sql);
		$rs_c = $rs->GetArray(); 
		
		print "<td align=center class=TableLine1>".$rs_c[0]["allnum"]."</td>";
		$total=$total+$rs_c[0]["allnum"];
	}
?>
	<td align=center class=TableLine1><?php echo $total?></td>
</tr>
<tr>
	<td align=center class=TableLine2>本次销售</td>
	<?php 
	$total=0;
	for($i=0;$i<sizeof($rs_b);$i++)
	{
		$num=0;
		$sql="select * from $tablename where id=$id and color=".$rs_b[$i]["id"];
		$rs = $db->Execute($sql);
		$rs_c = $rs->GetArray(); 
		if(sizeof($rs_c)==1)
			$num=$rs_c[0]['num'];
		
		print "<td align=center class=TableLine2><input type=text size=6 class='SmallInput' id='input_".$rs_b[$i]["id"]."' value='$num' onkeypress=\"check_input_num('NUMBER');\" onchange=\"countAll()\"></td>";
		$total=$total+$num;
	}
?>
<td align=center class=TableLine2 ><div id='allnum'><?php echo $total?></div></td>
</tr>
</table>
<br>
<div id="tip">&nbsp;</div>
<p align=center><input type="button" class='SmallButton'  value=" 保存 " onclick="saveAndClose()">&nbsp;&nbsp;<input type="button" class="SmallButton"  value=" 关闭 " onclick="parent.pop.close()"></p>
</form>
<script type="text/javascript">
<!--
allnum=<?php echo $total?>;
//-->
</script>
<?php 
}else if($tablename=='stockoutmain_detail_color')
{
	$sql="select * from stockoutmain_detail where id=$id";
	$rs = $db->Execute($sql);
	$rs_a = $rs->GetArray(); 
	if(sizeof($rs_a)!=1)
	{
		print_infor("不存在此记录","forbidden","close");
		exit;
	}
	$storeid=returntablefield("stockoutmain","billid",$rs_a[0]['mainrowid'],"storeid");
	$sql="select * from productcolor";
	$rs = $db->Execute($sql);
	$rs_b = $rs->GetArray(); 
?>
<script type="text/javascript">
var totalnum=<?php echo $rs_a[0]['num']?>;
function countAll()
{
	allnum=0;
	$("input:text", document.forms[0]).each(function()
	{	
		allnum=allnum+parseInteger(this.value);
	}); 
	$("#allnum").html(allnum);
	if(totalnum<allnum)
		$("#tip").html("&nbsp;<font color=red>本次出库数 "+allnum+" 不能大于销售数 "+totalnum+"</font>");
	else if(totalnum>allnum)
		$("#tip").html("&nbsp;<font color=blue>本次出库数 "+allnum+" 小于销售数 "+totalnum+"</font>");
	else
		$("#tip").html("&nbsp;<font color=green>本次出库数等于销售数 "+totalnum+"</font>");
}
function saveAndClose()
{
	if(totalnum<allnum)
	{
		alert("本次出库数 "+allnum+" 不能大于销售数 "+totalnum+"，请调整后再保存");
		return false;
	}
	var colorarray=[];
	$("input:text", document.forms[0]).each(function(){colorarray.push(parseInteger(this.value));}); 
	$.ajax({ 
		  type:'GET', 
		  url:'buyplanmain_mingxi_update.php?tablename=stockoutmain_detail&rowid=<?php echo $id?>&action=colorinput&colorarray=' + colorarray.toString(), 
		  dataType: 'text', 
		  cache:false,
		  async: false,
		  success:function(data) 
		  { 
			  if(data=='ok')
			  {
				  parent.document.getElementById('recnum_'+<?php echo $id?>).value=allnum;
				  parent.document.getElementById("img_"+<?php echo $id?>).src='<?php echo ROOT_DIR."general/ERP/Framework/images/sepan.gif"?>';
				  parent.CountAllJine();
				  parent.pop.close();
				  
			  }
			  else
				alert(data);
			  	
		  },
		  error:function(XmlHttpRequest,textStatus, errorThrown)
	  	  {
			  alert('出错：'+errorThrown);
	  	  }
	});
}
</script>
<form name="form2">
<table align=center class=TableBlock width=98% border=0 id="table1">
<tr >
	<td align=center class=TableHeader><?php echo $rs_a[0]['prodname']?></td>
    
<?php 
	for($i=0;$i<sizeof($rs_b);$i++)
	{
		print "<td align=center class=TableHeader>".$rs_b[$i]["name"]."</td>";
	}
?>
	<td align=center class=TableHeader>合计</td>
</tr>
<tr>
	<td align=center class=TableLine1>当前库存</td>
<?php 
	$total=0;
	for($i=0;$i<sizeof($rs_b);$i++)
	{
		$sql="select sum(b.num) as allnum from store a inner join store_color b on a.id=b.id where a.prodid='".$rs_a[0]['prodid']."'";
		if($storeid!='')
			$sql.=" and a.storeid=$storeid";
		$sql.=" and b.color=".$rs_b[$i]["id"];
		$rs = $db->Execute($sql);
		$rs_c = $rs->GetArray(); 
		print "<td align=center class=TableLine1>".$rs_c[0]["allnum"]."</td>";
		$total=$total+$rs_c[0]["allnum"];
	}
?>
	<td align=center class=TableLine1><?php echo $total?></td>
</tr>
<tr>
	<td align=center class=TableLine2>本次出库</td>
	<?php 
	$total=0;
	for($i=0;$i<sizeof($rs_b);$i++)
	{
		$num=0;
		$sql="select * from stockoutmain_detail_color where id=$id and color=".$rs_b[$i]["id"];
		$rs = $db->Execute($sql);
		$rs_c = $rs->GetArray(); 
		if(sizeof($rs_c)==1)
			$num=$rs_c[0]['num'];
			
		print "<td align=center class=TableLine2><input type=text size=6 class='SmallInput' id='input_".$rs_b[$i]["id"]."' value='$num' onkeypress=\"check_input_num('NUMBER');\" onchange=\"countAll()\"></td>";
		$total=$total+$num;
	}
?>
<td align=center class=TableLine2 ><div id='allnum'><?php echo $total?></div></td>
</tr>
</table>
<br>
<div id="tip">&nbsp;销售数为：<?php echo $rs_a[0]['num']?></div>
<p align=center><input type="button" class='SmallButton'  value=" 保存 " onclick="saveAndClose()">&nbsp;&nbsp;<input type="button" class="SmallButton"  value=" 关闭 " onclick="parent.pop.close()"></p>
</form>
<script type="text/javascript">
<!--
allnum=<?php echo $total?>;
//-->
</script>
<?php 
}else if($tablename=='storecheck_detail_color')
{
	$sql="select * from storecheck_detail where id=$id";
	$rs = $db->Execute($sql);
	$rs_a = $rs->GetArray(); 
	if(sizeof($rs_a)!=1)
	{
		print_infor("不存在此记录","forbidden","close");
		exit;
	}
	$storeid=returntablefield("storecheck","billid",$rs_a[0]['mainrowid'],"storeid");
	$sql="select * from productcolor";
	$rs = $db->Execute($sql);
	$rs_b = $rs->GetArray(); 
?>
<script type="text/javascript">
var totalnum=<?php echo $rs_a[0]['num']?>;
function countAll()
{
	allnum=0;
	$("input:text", document.forms[0]).each(function()
	{	
		allnum=allnum+parseInteger(this.value);
	}); 
	$("#allnum").html(allnum);

	
}
function saveAndClose()
{
	if(allnum==0)
	{
		alert("各颜色合计数不能为0，请调整后再保存");
		return false;
	}
	var colorarray=[];
	$("input:text", document.forms[0]).each(function(){colorarray.push(parseInteger(this.value));}); 
	$.ajax({ 
		  type:'GET', 
		  url:'buyplanmain_mingxi_update.php?tablename=storecheck_detail&rowid=<?php echo $id?>&action=colorinput&colorarray=' + colorarray.toString(), 
		  dataType: 'text', 
		  cache:false,
		  async: false,
		  success:function(data) 
		  { 
			  if(data=='ok')
			  {
				  parent.document.getElementById('num_'+<?php echo $id?>).value=allnum;
				  parent.document.getElementById("img_"+<?php echo $id?>).src='<?php echo ROOT_DIR."general/ERP/Framework/images/sepan.gif"?>';
				  parent.updateAmount(<?php echo $id?>,allnum);
				  parent.pop.close();
				  
			  }
			  else
				alert(data);
			  	
		  },
		  error:function(XmlHttpRequest,textStatus, errorThrown)
	  	  {
			  alert('出错：'+errorThrown);
	  	  }
	});
}
</script>
<form name="form2">
<table align=center class=TableBlock width=98% border=0 id="table1">
<tr >
	<td align=center class=TableHeader><?php echo $rs_a[0]['prodname']?></td>
    
<?php 
	for($i=0;$i<sizeof($rs_b);$i++)
	{
		print "<td align=center class=TableHeader>".$rs_b[$i]["name"]."</td>";
	}
?>
	<td align=center class=TableHeader>合计</td>
</tr>
<tr>
	<td align=center class=TableLine1>当前库存</td>
<?php 
	$total=0;
	for($i=0;$i<sizeof($rs_b);$i++)
	{
		$sql="select sum(b.num) as allnum from store a inner join store_color b on a.id=b.id where a.prodid='".$rs_a[0]['prodid']."'";
		if($storeid!='')
			$sql.=" and a.storeid=$storeid";
		$sql.=" and b.color=".$rs_b[$i]["id"];
		$rs = $db->Execute($sql);
		$rs_c = $rs->GetArray(); 
		print "<td align=center class=TableLine1>".$rs_c[0]["allnum"]."</td>";
		$total=$total+$rs_c[0]["allnum"];
	}
?>
	<td align=center class=TableLine1><?php echo $total?></td>
</tr>
<tr>
	<td align=center class=TableLine2>损益</td>
	<?php 
	$total=0;
	for($i=0;$i<sizeof($rs_b);$i++)
	{
		$num=0;
		$sql="select * from storecheck_detail_color where id=$id and color=".$rs_b[$i]["id"];
		$rs = $db->Execute($sql);
		$rs_c = $rs->GetArray(); 
		if(sizeof($rs_c)==1)
			$num=$rs_c[0]['num'];
			
		print "<td align=center class=TableLine2><input type=text size=6 class='SmallInput' id='input_".$rs_b[$i]["id"]."' value='$num' onkeypress=\"check_input_num('NUMBER');\" onchange=\"countAll()\"></td>";
		$total=$total+$num;
	}
?>
<td align=center class=TableLine2 ><div id='allnum'><?php echo $total?></div></td>
</tr>
</table>
<br>
<div id="tip">&nbsp;</div>
<p align=center><input type="button" class='SmallButton'  value=" 保存 " onclick="saveAndClose()">&nbsp;&nbsp;<input type="button" class="SmallButton"  value=" 关闭 " onclick="parent.pop.close()"></p>
</form>
<script type="text/javascript">
<!--
allnum=<?php echo $total?>;
//-->
</script>
<?php 
}else if($tablename=='stockchangemain_detail_color')
{
	$sql="select * from stockchangemain_detail where id=$id";
	$rs = $db->Execute($sql);
	$rs_a = $rs->GetArray(); 
	if(sizeof($rs_a)!=1)
	{
		print_infor("不存在此记录","forbidden","close");
		exit;
	}
	$storeid=returntablefield("stockchangemain","billid",$rs_a[0]['mainrowid'],"outstoreid");
	$sql="select * from productcolor";
	$rs = $db->Execute($sql);
	$rs_b = $rs->GetArray(); 
?>
<script type="text/javascript">
var totalnum=<?php echo $rs_a[0]['num']?>;
function countAll()
{
	allnum=0;
	$("input:text", document.forms[0]).each(function()
	{	
		allnum=allnum+parseInteger(this.value);
	}); 
	$("#allnum").html(allnum);

	
}
function saveAndClose()
{
	if(allnum==0)
	{
		alert("各颜色合计数不能为0，请调整后再保存");
		return false;
	}
	var colorarray=[];
	$("input:text", document.forms[0]).each(function(){colorarray.push(parseInteger(this.value));}); 
	$.ajax({ 
		  type:'GET', 
		  url:'buyplanmain_mingxi_update.php?tablename=stockchangemain_detail&rowid=<?php echo $id?>&action=colorinput&colorarray=' + colorarray.toString(), 
		  dataType: 'text', 
		  cache:false,
		  async: false,
		  success:function(data) 
		  { 
			  if(data=='ok')
			  {
				  parent.document.getElementById('num_'+<?php echo $id?>).value=allnum;
				  parent.document.getElementById("img_"+<?php echo $id?>).src='<?php echo ROOT_DIR."general/ERP/Framework/images/sepan.gif"?>';
				  parent.updateAmount(<?php echo $id?>,allnum);
				  parent.pop.close();
				  
			  }
			  else
				alert(data);
			  	
		  },
		  error:function(XmlHttpRequest,textStatus, errorThrown)
	  	  {
			  alert('出错：'+errorThrown);
	  	  }
	});
}
</script>
<form name="form2">
<table align=center class=TableBlock width=98% border=0 id="table1">
<tr >
	<td align=center class=TableHeader><?php echo $rs_a[0]['prodname']?></td>
    
<?php 
	for($i=0;$i<sizeof($rs_b);$i++)
	{
		print "<td align=center class=TableHeader>".$rs_b[$i]["name"]."</td>";
	}
?>
	<td align=center class=TableHeader>合计</td>
</tr>
<tr>
	<td align=center class=TableLine1>当前库存</td>
<?php 
	$total=0;
	for($i=0;$i<sizeof($rs_b);$i++)
	{
		$sql="select sum(b.num) as allnum from store a inner join store_color b on a.id=b.id where a.prodid='".$rs_a[0]['prodid']."'";
		if($storeid!='')
			$sql.=" and a.storeid=$storeid";
		$sql.=" and b.color=".$rs_b[$i]["id"];
		$rs = $db->Execute($sql);
		$rs_c = $rs->GetArray(); 
		print "<td align=center class=TableLine1>".$rs_c[0]["allnum"]."</td>";
		$total=$total+$rs_c[0]["allnum"];
	}
?>
	<td align=center class=TableLine1><?php echo $total?></td>
</tr>
<tr>
	<td align=center class=TableLine2>调拨</td>
	<?php 
	$total=0;
	for($i=0;$i<sizeof($rs_b);$i++)
	{
		$num=0;
		$sql="select * from stockchangemain_detail_color where id=$id and color=".$rs_b[$i]["id"];
		$rs = $db->Execute($sql);
		$rs_c = $rs->GetArray(); 
		if(sizeof($rs_c)==1)
			$num=$rs_c[0]['num'];
			
		print "<td align=center class=TableLine2><input type=text size=6 class='SmallInput' id='input_".$rs_b[$i]["id"]."' value='$num' onkeypress=\"check_input_num('NUMBER');\" onchange=\"countAll()\"></td>";
		$total=$total+$num;
	}
?>
<td align=center class=TableLine2 ><div id='allnum'><?php echo $total?></div></td>
</tr>
</table>
<br>
<div id="tip">&nbsp;</div>
<p align=center><input type="button" class='SmallButton'  value=" 保存 " onclick="saveAndClose()">&nbsp;&nbsp;<input type="button" class="SmallButton"  value=" 关闭 " onclick="parent.pop.close()"></p>
</form>
<script type="text/javascript">
<!--
allnum=<?php echo $total?>;
//-->
</script>
<?php 
}else if($tablename=='productzuzhuang_detail_color')
{
	$sql="select * from productzuzhuang_detail where id=$id";
	$rs = $db->Execute($sql);
	$rs_a = $rs->GetArray(); 
	if(sizeof($rs_a)!=1)
	{
		print_infor("不存在此记录","forbidden","close");
		exit;
	}
	$storeid=returntablefield("productzuzhuang","billid",$rs_a[0]['mainrowid'],"outstoreid");
	$sql="select * from productcolor";
	$rs = $db->Execute($sql);
	$rs_b = $rs->GetArray(); 
?>
<script type="text/javascript">
var totalnum=<?php echo $rs_a[0]['num']?>;
function countAll()
{
	allnum=0;
	$("input:text", document.forms[0]).each(function()
	{	
		allnum=allnum+parseInteger(this.value);
	}); 
	$("#allnum").html(allnum);

	
}
function saveAndClose()
{
	if(allnum==0)
	{
		alert("各颜色合计数不能为0，请调整后再保存");
		return false;
	}
	var colorarray=[];
	$("input:text", document.forms[0]).each(function(){colorarray.push(parseInteger(this.value));}); 
	$.ajax({ 
		  type:'GET', 
		  url:'buyplanmain_mingxi_update.php?tablename=productzuzhuang_detail&rowid=<?php echo $id?>&action=colorinput&colorarray=' + colorarray.toString(), 
		  dataType: 'text', 
		  cache:false,
		  async: false,
		  success:function(data) 
		  { 
			  if(data=='ok')
			  {
				  parent.document.getElementById('num_'+<?php echo $id?>).value=allnum;
				  parent.document.getElementById("img_"+<?php echo $id?>).src='<?php echo ROOT_DIR."general/ERP/Framework/images/sepan.gif"?>';
				  parent.updateAmount(<?php echo $id?>,allnum);
				  parent.pop.close();
				  
			  }
			  else
				alert(data);
			  	
		  },
		  error:function(XmlHttpRequest,textStatus, errorThrown)
	  	  {
			  alert('出错：'+errorThrown);
	  	  }
	});
}
</script>
<form name="form2">
<table align=center class=TableBlock width=98% border=0 id="table1">
<tr >
	<td align=center class=TableHeader><?php echo $rs_a[0]['prodname']?></td>
    
<?php 
	for($i=0;$i<sizeof($rs_b);$i++)
	{
		print "<td align=center class=TableHeader>".$rs_b[$i]["name"]."</td>";
	}
?>
	<td align=center class=TableHeader>合计</td>
</tr>
<tr>
	<td align=center class=TableLine1>当前库存</td>
<?php 
	$total=0;
	for($i=0;$i<sizeof($rs_b);$i++)
	{
		$sql="select sum(b.num) as allnum from store a inner join store_color b on a.id=b.id where a.prodid='".$rs_a[0]['prodid']."'";
		if($storeid!='')
			$sql.=" and a.storeid=$storeid";
		$sql.=" and b.color=".$rs_b[$i]["id"];
		$rs = $db->Execute($sql);
		$rs_c = $rs->GetArray(); 
		print "<td align=center class=TableLine1>".$rs_c[0]["allnum"]."</td>";
		$total=$total+$rs_c[0]["allnum"];
	}
?>
	<td align=center class=TableLine1><?php echo $total?></td>
</tr>
<tr>
	<td align=center class=TableLine2>组装出库</td>
	<?php 
	$total=0;
	for($i=0;$i<sizeof($rs_b);$i++)
	{
		$num=0;
		$sql="select * from productzuzhuang_detail_color where id=$id and color=".$rs_b[$i]["id"];
		$rs = $db->Execute($sql);
		$rs_c = $rs->GetArray(); 
		if(sizeof($rs_c)==1)
			$num=$rs_c[0]['num'];
			
		print "<td align=center class=TableLine2><input type=text size=6 class='SmallInput' id='input_".$rs_b[$i]["id"]."' value='$num' onkeypress=\"check_input_num('NUMBER');\" onchange=\"countAll()\"></td>";
		$total=$total+$num;
	}
?>
<td align=center class=TableLine2 ><div id='allnum'><?php echo $total?></div></td>
</tr>
</table>
<br>
<div id="tip">&nbsp;</div>
<p align=center><input type="button" class='SmallButton'  value=" 保存 " onclick="saveAndClose()">&nbsp;&nbsp;<input type="button" class="SmallButton"  value=" 关闭 " onclick="parent.pop.close()"></p>
</form>
<script type="text/javascript">
<!--
allnum=<?php echo $total?>;
//-->
</script>
<?php 
}else if($tablename=='productzuzhuang2_detail_color')
{
	$sql="select * from productzuzhuang2_detail where id=$id";
	$rs = $db->Execute($sql);
	$rs_a = $rs->GetArray(); 
	if(sizeof($rs_a)!=1)
	{
		print_infor("不存在此记录","forbidden","close");
		exit;
	}
	$storeid=returntablefield("productzuzhuang","billid",$rs_a[0]['mainrowid'],"instoreid");
	$sql="select * from productcolor";
	$rs = $db->Execute($sql);
	$rs_b = $rs->GetArray(); 
?>
<script type="text/javascript">
var totalnum=<?php echo $rs_a[0]['num']?>;
function countAll()
{
	allnum=0;
	$("input:text", document.forms[0]).each(function()
	{	
		allnum=allnum+parseInteger(this.value);
	}); 
	$("#allnum").html(allnum);

	
}
function saveAndClose()
{
	if(allnum==0)
	{
		alert("各颜色合计数不能为0，请调整后再保存");
		return false;
	}
	var colorarray=[];
	$("input:text", document.forms[0]).each(function(){colorarray.push(parseInteger(this.value));}); 
	$.ajax({ 
		  type:'GET', 
		  url:'buyplanmain_mingxi_update.php?tablename=productzuzhuang2_detail&rowid=<?php echo $id?>&action=colorinput&colorarray=' + colorarray.toString(), 
		  dataType: 'text', 
		  cache:false,
		  async: false,
		  success:function(data) 
		  { 
			  if(data=='ok')
			  {
				  parent.document.getElementById('num_'+<?php echo $id?>).value=allnum;
				  parent.document.getElementById("img_"+<?php echo $id?>).src='<?php echo ROOT_DIR."general/ERP/Framework/images/sepan.gif"?>';
				  parent.updateAmount(<?php echo $id?>,allnum);
				  parent.pop.close();
				  
			  }
			  else
				alert(data);
			  	
		  },
		  error:function(XmlHttpRequest,textStatus, errorThrown)
	  	  {
			  alert('出错：'+errorThrown);
	  	  }
	});
}
</script>
<form name="form2">
<table align=center class=TableBlock width=98% border=0 id="table1">
<tr >
	<td align=center class=TableHeader><?php echo $rs_a[0]['prodname']?></td>
    
<?php 
	for($i=0;$i<sizeof($rs_b);$i++)
	{
		print "<td align=center class=TableHeader>".$rs_b[$i]["name"]."</td>";
	}
?>
	<td align=center class=TableHeader>合计</td>
</tr>
<tr>
	<td align=center class=TableLine1>当前库存</td>
<?php 
	$total=0;
	for($i=0;$i<sizeof($rs_b);$i++)
	{
		$sql="select sum(b.num) as allnum from store a inner join store_color b on a.id=b.id where a.prodid='".$rs_a[0]['prodid']."'";
		if($storeid!='')
			$sql.=" and a.storeid=$storeid";
		$sql.=" and b.color=".$rs_b[$i]["id"];
		$rs = $db->Execute($sql);
		$rs_c = $rs->GetArray(); 
		print "<td align=center class=TableLine1>".$rs_c[0]["allnum"]."</td>";
		$total=$total+$rs_c[0]["allnum"];
	}
?>
	<td align=center class=TableLine1><?php echo $total?></td>
</tr>
<tr>
	<td align=center class=TableLine2>组装入库</td>
	<?php 
	$total=0;
	for($i=0;$i<sizeof($rs_b);$i++)
	{
		$num=0;
		$sql="select * from productzuzhuang2_detail_color where id=$id and color=".$rs_b[$i]["id"];
		$rs = $db->Execute($sql);
		$rs_c = $rs->GetArray(); 
		if(sizeof($rs_c)==1)
			$num=$rs_c[0]['num'];
			
		print "<td align=center class=TableLine2><input type=text size=6 class='SmallInput' id='input_".$rs_b[$i]["id"]."' value='$num' onkeypress=\"check_input_num('NUMBER');\" onchange=\"countAll()\"></td>";
		$total=$total+$num;
	}
?>
<td align=center class=TableLine2 ><div id='allnum'><?php echo $total?></div></td>
</tr>
</table>
<br>
<div id="tip">&nbsp;</div>
<p align=center><input type="button" class='SmallButton'  value=" 保存 " onclick="saveAndClose()">&nbsp;&nbsp;<input type="button" class="SmallButton"  value=" 关闭 " onclick="parent.pop.close()"></p>
</form>
<script type="text/javascript">
<!--
allnum=<?php echo $total?>;
//-->
</script>
<?php 
}?>