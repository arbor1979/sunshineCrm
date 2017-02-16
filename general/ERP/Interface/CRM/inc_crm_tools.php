<?php

//######################教育组件-权限较验部分##########################
SESSION_START();
require_once("lib.inc.php");
$GLOBAL_SESSION=returnsession();
require_once("systemprivateinc.php");
validateMenuPriv("客户移交");
//######################教育组件-权限较验部分##########################

require_once('lib.inc.php');
require_once('lib.zip.inc.php');

page_css("CRM工具集");
validateMenuPriv("客户移交");
$custlistArray=array();
$custNamelistArray=array();
if($_GET['action']=="add_yijiao")								
{
	$custlist=$_GET['custlist'];
	$custlistArray=explode(",", $custlist);
	
	for($i=0;$i<sizeof($custlistArray);$i++)
	{
		
			array_push($custNamelistArray,returntablefield("customer","rowid", $custlistArray[$i], "supplyname"));
		 
			
	}
	
}

if($_GET['action']=="转移用户A的客户所有相关信息给用户B")								{
	//print_R($_POST);exit;
	$用户A_ID	= $_POST['用户A_ID'];
	$用户B_ID	= $_POST['用户B_ID'];
	$用户A		= $_POST['用户A'];
	$用户B		= $_POST['用户B'];
	if($用户A_ID!=""&&$用户B_ID!="")			
	{
		if($用户A_ID==$用户B_ID)
		{
			print_infor("用户A和用户B不能相同!",'forbidden',"location='?'","?",3);
			exit;	
		}
		if(!ifHasRoleUser($用户A_ID))
		{
			print_infor("您没有操作此用户的权限!",'forbidden',"location='?'","?",3);
			exit;
		}
		
		$sql = "select * from customer where sysuser='".$用户A_ID."'";
		$rsUTF = $db->Execute($sql);
		while(!$rsUTF->EOF)
		{
			$sql = "insert into crm_customer_move (客户ID,上个用户,下个用户,操作员,操作时间) values(".$rsUTF->fields['ROWID'].",'".$用户A_ID."','".$用户B_ID."','".$_SESSION['LOGIN_USER_ID']."',Now())";
			$db->Execute($sql);
			$rsUTF->MoveNext();
		}
		$sql = "update customer set sysuser='$用户B_ID' where sysuser='$用户A_ID'";
		$db->Execute($sql);		
		

		print_infor("您的操作已经完成,请返回!&nbsp;&nbsp;",'',"location='?'","?",3);
		exit;
	}
	else	{
		print_infor("用户A或用户B没有设定,请重新设定!",'forbidden',"location='?'","?",3);
		exit;
	}
}


if($_GET['action']=="处理单一客户转给某用户")								{
	//print_R($_GET);//exit;
	$rowidStr	= $_GET['客户名称_ID'];
	$user_id	= $_GET['用户名_ID'];
	if($rowidStr=='' || $user_id=='')
	{
		print_infor("客户名称或目标用户没有设定,请重新设定!",'forbidden',"location='?'","?",3);
		exit;
	}
	$rowidArray=explode(",",$rowidStr);
	$errlist='';
	$j=0;
	for($i=0;$i<sizeof($rowidArray);$i++)
	{
		$rowid=$rowidArray[$i];
		if($rowid!="")			
		{
			
			$custinfo=returntablefield("customer","rowid",$rowid,"supplyname,sysuser");
			$sysuser=$custinfo['sysuser'];
			if(!ifHasRoleUser($sysuser))
			{
				$errlist.=++$j."、".$custinfo['supplyname']."<br>";
				continue;
			}
			$sql = "update customer set sysuser='$user_id' where rowid='$rowid'";
			$db->Execute($sql);
			//print $sql."<br>";	
			$sql = "insert into crm_customer_move (客户ID,上个用户,下个用户,操作员,操作时间) values(".$rowid.",'".$sysuser."','".$user_id."','".$_SESSION['LOGIN_USER_ID']."',Now())";
			$db->Execute($sql);
			//print $sql."<br>";
			
			
		}
	}
	if($errlist!='')
	{
		print_infor("以下客户您没有权限进行转移操作:<br>$errlist",'warning',"location='?'","?",10);
	}
	else 
	{
		print_infor("您的操作已经完成,请返回!&nbsp;&nbsp;",'',"location='?'","?",3);
	}
	exit;
}

if($_GET['action']=="客户转移日志")								
{
	//print_R($_GET);//exit;
	$customerid	= $_GET['客户名称1_ID'];
	$customername=returntablefield( "customer", "rowid",$customerid, "supplyname" );
	$begintime	= $_GET['起始时间'];
	$endtime	= $_GET['截止时间'];
	if($customerid!="" )			
	{
			
		$sql = "select a.*,b.supplyname as 客户名称 from crm_customer_move a inner join customer b on a.客户ID=b.rowid where 客户ID='".$customerid."'";
		if($begintime!="")
			$sql=$sql." and a.操作时间>='".$begintime."'";
		if($endtime!="")
			$sql=$sql." and a.操作时间<='".$endtime."'";
		
		$rsUTF = $db->Execute($sql);
		$rs_a = $rsUTF->GetArray();
		for($i=0;$i<sizeof($rs_a);$i++)
		{
			$rs_a[$i]['上个用户']=returntablefield( "user", "user_id", $rs_a[$i]['上个用户'], "user_name" );
			$rs_a[$i]['下个用户']=returntablefield( "user", "user_id", $rs_a[$i]['下个用户'], "user_name" );
			$rs_a[$i]['操作员']=returntablefield( "user", "user_id", $rs_a[$i]['操作员'], "user_name" );
		}
		
	}
}


?>
<script language = "JavaScript">
function FormCheck()
{
	if (document.form1.用户A_ID.value == "") {
		alert("用户A没有设定人员");
		return false;
	}
	if (document.form1.用户B_ID.value == "") {
		alert("用户B没有设定人员");
		return false;
	}
}
function FormCheck2()
{
	if (document.form1.客户名称_ID.value == "") {
		alert("请先选择一个客户");
		return false;
	}
	if (document.form1.用户_ID.value == "") {
		alert("用户没有设定");
		return false;
	}
	URL = "?action=处理单一客户转给某用户&客户名称_ID="+document.form1.客户名称_ID.value+"&用户名_ID="+document.form1.用户_ID.value;
	window.location = URL;
}
function FormCheck3()
{
	if (document.form1.客户名称1_ID.value == "") {
		alert("客户名称没有设定");
		return false;
	}
	if(form1.起始时间.value!='' && !isDate(form1.起始时间))
		return false;
	if(form1.截止时间.value!='' && !isDate(form1.截止时间))
		return false;
			
	URL = "?action=客户转移日志&客户名称1_ID="+document.form1.客户名称1_ID.value+"&起始时间="+document.form1.起始时间.value+"&截止时间="+document.form1.截止时间.value;
	window.location = URL;
}
</script>

<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<table border="0" width="80%" align=center cellspacing="0" cellpadding="3" class="TableBlock">
  <tr  class=TableHeader>
    <td colspan="6" height=28>&nbsp;<img src="<?php echo ROOT_DIR?>images/sys_config.gif" align="absmiddle" > 某用户下的所有客户移交</td>
  </tr>
 <tr class="TableData">
 <td colspan="6" align=center height=42>
 <FORM name=form1 onsubmit="return FormCheck();" action="?action=转移用户A的客户所有相关信息给用户B&pageid=1" method=post encType=multipart/form-data>
	转移用户A:
	<input type="hidden" name="用户A_ID" value="">
	<input type="text" name="用户A" value="" readonly class="SmallStatic" size="10">
	<a href="javascript:;" class="orgAdd" onClick="SelectTeacherSingle('1','用户A_ID', '用户A')">选择</a>
	的客户所有相关信息给:
	用户B
	<input type="hidden" name="用户B_ID" value="">
	<input type="text" name="用户B" value="" readonly class="SmallStatic" size="10">
	<a href="javascript:;" class="orgAdd" onClick="SelectTeacherSingle('','用户B_ID', '用户B')">选择</a>
    <input type="submit"  value="提交" class="BigButton" title="提交">
 </td>
</tr>
</table>

<BR>
<table border="0" width="80%" align=center cellspacing="0" cellpadding="3" class="TableBlock">
  <tr  class=TableHeader>
    <td colspan="6" height=28>&nbsp;<img src="<?php echo ROOT_DIR?>images/sys_config.gif" align="absmiddle" > 选择客户移交</td>
  </tr>
 <tr class="TableData">
 <td colspan="6" align=center height=42>
	转移客户名称:
	<input type="hidden" name="客户名称_ID" value="<?php echo implode(",", $custlistArray)?>">
	<textarea name="客户名称"  readonly class="SmallStatic" wrap=yes rows=5 cols=40><?php echo implode(",", $custNamelistArray)?></TEXTAREA>
	<a href="javascript:;" class="orgAdd" onClick="SelectAllInforSingle('../../Enginee/Module/kehu_select_multi/index.php','','客户名称', '客户名称_ID');">选择</a>
	的客户所有相关信息给:
	用户
	<input type="hidden" name="用户_ID" value="">
	<input type="text" name="用户" value="" readonly class="SmallStatic" size="10">
	<a href="javascript:;" class="orgAdd" onClick="SelectTeacherSingle('','用户_ID', '用户')">选择</a>
    <input type="Button"  value="提交" class="BigButton" OnClick='FormCheck2();' title="提交">

 </td>
</tr>
</table>

<BR>
<table border="0" width="80%" align=center cellspacing="0" cellpadding="3" class="TableBlock">
  <tr  class=TableHeader>
    <td colspan="6" height=28>&nbsp;<img src="<?php echo ROOT_DIR?>images/sys_config.gif" align="absmiddle" > 客户转移日志</td>
  </tr>
 <tr class="TableData">
 <td colspan="6" align=center height=42 class=TableData>
	客户名称:
	<input type="hidden" name="客户名称1_ID" value="<?php echo $customerid?>">
	<input type="text" name="客户名称1" value="<?php echo $customername?>" readonly class="SmallStatic" size="25">
	<a href="javascript:;" class="orgAdd" onClick="SelectAllInforSingle('../../Enginee/Module/kehu_select_single/index.php','','客户名称1', '客户名称1_ID');">选择</a>
	起始时间：
	<INPUT class=SmallInput maxLength=20 size=15 name="起始时间" value="<?php echo $begintime?>" title='' onkeydown="if(event.keyCode==13)event.keyCode=9" >
<input type="button"  title=''  value="选择" class="SmallButton" onclick="td_calendar('../../Framework/sms_index/calendar_begin.php?datetime=起始时间');" title="选择" name="button">
	截止时间：
	<INPUT class=SmallInput maxLength=20 size=15 name="截止时间" value="<?php echo $endtime?>" title='' onkeydown="if(event.keyCode==13)event.keyCode=9" >
<input type="button"  title=''  value="选择" class="SmallButton" onclick="td_calendar('../../Framework/sms_index/calendar_begin.php?datetime=截止时间');" title="选择" name="button">
&nbsp;<input type="Button"  value="搜索" class="BigButton" OnClick='FormCheck3();' title="搜索">
	</FORM>
 </td>
</tr>
</table>
<?php 
if($customerid!="")
{
?>
	<table border="0" width="80%" align=center cellspacing="0" cellpadding="3" class="TableBlock">
	<tr  class=TableHeader>
    <td align=center>客户名称</td>
    <td align=center>原所有者</td>
    <td align=center>新所有者</td>
    <td align=center>操作人</td>
    <td align=center>操作时间</td>
    </tr>
<?php
	for($i=0;$i<sizeof($rs_a);$i++)
	{
		print "<tr class=TableData>";
		print "<td align=center>".$rs_a[$i]['客户名称']."</td>";
		print "<td align=center>".$rs_a[$i]['上个用户']."</td>";
		print "<td align=center>".$rs_a[$i]['下个用户']."</td>";
		print "<td align=center>".$rs_a[$i]['操作员']."</td>";
		print "<td align=center>".$rs_a[$i]['操作时间']."</td></tr>";
	}
?>
	</table>
<?php
}
?>
