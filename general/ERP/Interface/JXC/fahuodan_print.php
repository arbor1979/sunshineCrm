<?php
	$billid=$_GET["billid"];
	$url=$_GET["url"];
	ini_set('display_errors', 1);
	ini_set('error_reporting', E_ALL);
	error_reporting(E_WARNING | E_ERROR);
	require_once('lib.inc.php');
	$GLOBAL_SESSION=returnsession();
	page_css("确认发货单");
	global $db;
	$sql="select * from fahuodan_detail where billid=".$billid;
	$rs=$db->Execute($sql);
	$rs_a = $rs->GetArray();	
	
?>
<script language = "JavaScript"> 
function FormCheck() 
{
if (document.form1.shouhuoren.value == "") {
alert("收货人不能为空");
 return false;}
if (document.form1.address.value == "") {
alert("收货地址不能为空");
 return false;}
if (document.form1.tel.value == "") {
alert("电话不能为空");
 return false;}
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
<FORM name=form1 onsubmit="return FormCheck();" 
 action="fahuodan_newai.php?action=edit_default2_data" method=post encType=multipart/form-data>
<table class=TableBlock align=center width=65% ><TR><TD class=TableHeader align=left colSpan=3>&nbsp;发货单</TD></TR>
<?php 
$fahuoinfo=returntablefield("fahuodan", "billid", $billid, "outtype,customerid,dingdanbillid");
	$outtype=$fahuoinfo['outtype'];
	$customerid=$fahuoinfo['customerid'];
	$dingdanbillid=$fahuoinfo['dingdanbillid'];
	$supplyname='';
	$title='';
	if($outtype=="销售出库")
	{
		$supplyname=returntablefield("customer", "rowid", $customerid, "supplyname");
		$title=returntablefield("sellplanmain", "billid", $dingdanbillid, "zhuti");
	}
	else if($outtype=='返厂出库')
	{
		$supplyname=returntablefield("supply", "rowid", $customerid, "supplyname");
		$title=returntablefield("buyplanmain","billid",$dingdanbillid,"zhuti");
	}
?>
<TR>
<TD class=TableContent noWrap width=20%>对应出库单号:</TD>
<TD class=TableData noWrap colspan="2"><?php echo $rs_a[0]['billid']?></TD></TR>

<TR><TD class=TableContent noWrap>客户/供应商:</TD>
<TD class=TableData noWrap colspan="2"><?php echo $supplyname?></TD></TR>
<TR><TD class=TableContent noWrap>对应单据:</TD>
<TD class=TableData noWrap colspan="2"><?php echo $title?></TD></TR>
<TR><TD class=TableContent noWrap>发货单号:</TD>
<TD class=TableData noWrap colspan="2"><INPUT type="text" title=''
			onkeydown="if(event.keyCode==13)event.keyCode=9"  class="SmallInput"  maxLength=30 size="30"
			name='fahuodan' value="<?php echo $rs_a[0]['fahuodan']?>" >&nbsp;
</TD></TR>
<TR><TD class=TableContent noWrap>收货人:</TD>
<TD class=TableData noWrap colspan="2"><INPUT type="text" title=''
			onkeydown="if(event.keyCode==13)event.keyCode=9"  class="SmallInput"  maxLength=30 size="30"
			name='shouhuoren' value="<?php echo $rs_a[0]['shouhuoren']?>" >&nbsp;必填
</TD></TR>
<TR><TD class=TableContent noWrap>收货地址:</TD>
<TD class=TableData noWrap colspan="2"><INPUT type="text" title=''
			onkeydown="if(event.keyCode==13)event.keyCode=9"  class="SmallInput"  maxLength=30 size="30"
			name='address' value="<?php echo $rs_a[0]['address']?>" >&nbsp;必填
</TD></TR>
<TR><TD class=TableContent noWrap>电话:</TD>
<TD class=TableData noWrap colspan="2"><INPUT type="text" title=''
			onkeydown="if(event.keyCode==13)event.keyCode=9"  class="SmallInput"  maxLength=30 size="30"
			name='tel' value="<?php echo $rs_a[0]['tel']?>" >&nbsp;必填
</TD></TR>
<TR><TD class=TableContent noWrap>邮编:</TD>
<TD class=TableData noWrap colspan="2"><INPUT type="text" title=''
			onkeydown="if(event.keyCode==13)event.keyCode=9"  class="SmallInput"  maxLength=30 size="30"
			name='mailcode' value="<?php echo $rs_a[0]['mailcode']?>" >&nbsp;
</TD></TR>
<TR><TD class=TableContent noWrap>发货方式:</TD>
<TD class=TableData noWrap colspan="2"><select class="SmallSelect"
			onkeydown="if(event.keyCode==13)event.keyCode=9" name="fahuotype">
			<option value=""></option>
			<?php 
			$sql="select * from fahuotype";
			$rs=$db->Execute($sql);
			$rs_b = $rs->GetArray();
			
			for($i=0;$i<count($rs_b);$i++)
			{
				$check="";
				if($rs_a[0]['fahuotype']==$rs_b[$i]['id'])
					$check="selected";
				print "<option value=".$rs_b[$i]['id']." $check>".$rs_b[$i]['name']."</option>";
			}
			?>
			</select>
</TD></TR>
<TR><TD class=TableContent noWrap>打包件数:</TD>
<TD class=TableData noWrap colspan="2"><INPUT type="text" title=''
			onkeydown="if(event.keyCode==13)event.keyCode=9"  class="SmallInput"  maxLength=30 size="30"
			name='package' value="<?php echo $rs_a[0]['package']?>" >&nbsp;
</TD></TR>
<TR><TD class=TableContent noWrap>重量(Kg):</TD>
<TD class=TableData noWrap colspan="2"><INPUT type="text" title=''
			onkeydown="if(event.keyCode==13)event.keyCode=9"  class="SmallInput" onKeyPress="return inputFloat(event);"  maxLength=30 size="30"
			name='weight' value="<?php echo $rs_a[0]['weight']?>" >&nbsp;
</TD></TR>
<TR><TD class=TableContent noWrap>运费:</TD>
<TD class=TableData noWrap colspan="2"><INPUT type="text" title=''
			onkeydown="if(event.keyCode==13)event.keyCode=9"  class="SmallInput" onKeyPress="return inputFloat(event);"  maxLength=30 size="30"
			name='yunfei' value="<?php echo $rs_a[0]['yunfei']?>" >&nbsp;
</TD></TR>
<TR><TD class=TableContent noWrap>运费结算:</TD>
<TD class=TableData noWrap colspan="2"><select class="SmallSelect"
			onkeydown="if(event.keyCode==13)event.keyCode=9" name="jiesuantype">
			<?php 
			$sql="select * from yunfeitype";
			$rs=$db->Execute($sql);
			$rs_b = $rs->GetArray();
			for($i=0;$i<count($rs_b);$i++)
			{
				$check="";
				if($rs_a[0]['jiesuantype']==$rs_b[$i]['id'])
					$check="selected";
				print "<option value=".$rs_b[$i]['id']." $check>".$rs_b[$i]['name']."</option>";
			}
			?>
			</select>
</TD></TR>

<TR><TD class=TableContent noWrap>是否短信通知:</TD>
<TD class=TableData noWrap colspan="2"><input type="checkbox" name="duanxintongzhi" value ="yes" ></TD></TR>

<TR>
<TD class=TableContent noWrap width=20%>备注:</TD>
<TD class=TableData noWrap colspan="2"><TEXTAREA class=BigInput name=beizhu  title='' wrap=yes rows=5 cols=40  ></TEXTAREA>&nbsp;
</TD></TR>

<tr class=TableData><td colspan=3 nowrap width=100%>
<table class=TableBlock align=center width=100% ><tr class=TableContent>
<td nowrap>产品编号</td><td nowrap>名称</td><td nowrap>颜色</td><td nowrap>规格</td><td nowrap>单位</td><td nowrap>单价</td><td nowrap>折扣</td><td nowrap>数量</td><td nowrap>金额</td><td nowrap>备注</td></tr>
<?php 
	$sql="select * from fahuodan_detail where mainrowid=".$billid;
	$rs=$db->Execute($sql);
	$rs_detail = $rs->GetArray();
	for($i=0;$i<count($rs_detail);$i++)
	{
		$allnum=$allnum+$rs_detail[$i]['num'];
		$allmoney=$allmoney+$rs_detail[$i]['jine']
		?>
		<tr class=TableData>
		<td ><?php echo $rs_detail[$i]['prodid']?></td>
		<td ><?php echo $rs_detail[$i]['prodname']?></td>
		<td ><?php echo $rs_detail[$i]['prodguige']?></td>
		<td ><?php echo $rs_detail[$i]['prodxinghao']?></td>
		<td ><?php echo $rs_detail[$i]['proddanwei']?></td>
		<td ><?php echo $rs_detail[$i]['price']?></td>
		<td ><?php echo $rs_detail[$i]['zhekou']*100?>%</td>
		<td ><?php echo $rs_detail[$i]['num']?></td>
		<td ><?php echo $rs_detail[$i]['jine']?></td>
		<td ><?php echo $rs_detail[$i]['beizhu']?></td>
		</tr>
	<?php 
	}
?>
<tr class=TableData><td align=center><b>合计</b></td><td colspan=6></td>
<td><?php echo $allnum?></td><td><?php echo $allmoney?></td><td></td></tr>
</table></td></tr>

<TR><TD class=TableControl noWrap align=middle  colspan="3">
<div align="center">
<input type=button accesskey="p" name="print" value="按供应商汇总小票" class=SmallButton onClick="" title="快捷键:ALT+p">
<input type=submit accesskey="s" name="submit" value=" 保存 " class=SmallButton onClick="" title="快捷键:ALT+s">
<input type=button accesskey="c" name="cancel" value=" 返回 " class=SmallButton onClick="location='<?php echo $url?>';" title="快捷键:ALT+c">
</div>
</TD></TR>
</table>
<input type="hidden" name="billid" value=<?php echo $billid?>> 
<input type="hidden" name="url" value=<?php echo $url?>>
</form>
</body>
</html>