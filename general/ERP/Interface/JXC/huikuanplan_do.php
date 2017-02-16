<?php
	$id=$_GET["id"];
	$url=$_GET["url"];
	ini_set('display_errors', 1);
	ini_set('error_reporting', E_ALL);
	error_reporting(E_WARNING | E_ERROR);
	require_once('lib.inc.php');
	$GLOBAL_SESSION=returnsession();
	page_css("确认回款");
	global $db;
	$sql="select * from huikuanplan where id=".$id;
	$rs=$db->Execute($sql);
	$rs_a = $rs->GetArray();
	if(count($rs_a)==0)
	{
		print "<script language=javascript>alert('错误：找不到此回款计划');window.history.back(-1);</script>";
    	exit;
	}
	$customerid=$rs_a[0]['customerid'];
	$qici=$rs_a[0]['qici'];
	$customername=returntablefield("customer","rowid",$customerid,"supplyname");
	$dingdanbillid=$rs_a[0]['dingdanbillid'];
	$dingdanbillname=returntablefield("sellplanmain","billid",$dingdanbillid,"zhuti");
	$jine=$rs_a[0]['jine'];
	print "<script type=\"text/javascript\" language=\"javascript\" src=\"".ROOT_DIR."general/ERP/Enginee/jquery/jquery.js\"></script>";

?>
<script language = "JavaScript"> 
function FormCheck() 
{
if (document.form1.customerid.value == "") {
alert("客户不能为空");
 return false;}
if (document.form1.dingdanbillid.value == "") {
alert("合同/订单编号不能为空");
 return false;}
if (document.form1.paydate.value == "") {
alert("回款时间不能为空");
 return false;}
if (document.form1.jine.value == "") {
alert("金额不能为空");
 return false;}
}

</script>
<FORM name=form1 onsubmit="return FormCheck();" 
 action="huikuanrecord_newai.php?action=add_default_data&pageid=1" method=post encType=multipart/form-data>
<table class=TableBlock align=center width=450 ><TR><TD class=TableHeader align=left colSpan=3>&nbsp;确认回款</TD></TR>
<TR><TD class=TableControl noWrap align=middle  colspan="3">
<div align="left">
<input type=submit accesskey="s" name="submit" value=" 保存 " class=SmallButton onClick="" title="快捷键:ALT+s">
<input type=button accesskey="c" name="cancel" value=" 返回 " class=SmallButton onClick="location='huikuanplan_newai.php';" title="快捷键:ALT+c">
</div>
</TD></TR>
<script language=javascript>
var quling=0;
var totalmoney=0;
var huikuanjine=0;
var kaipiaojine=0;

function changelocation(locationid)
{
	document.form1.dingdanbillid.length = 0;
	if(locationid!='')
	{
		
    	sendRequest('huikuan','customerid='+locationid);
    	getPayType(document.form1.dingdanbillid.value);
    	
    }
	
}
function getPayType(billid)
{
   	sendRequest('billinfo','billid='+billid);
}
window.onload=function()
{
	changelocation(<?php echo $customerid?>);
}
function sendRequest(action,params) 
{
	$.ajax({ 
			  type:'GET', 
			  url:'getLinkmanBycustomer.php?action='+action+'&'+params, 
			  dataType: 'xml', 
			  cache:false,
			  async: false,
			  success:function(data) 
			  { 
				  
			  	if(action=='huikuan' || action=='kaipiao')
	   		  	{
						var yuchuzhi=$(data).find('chuzhi').text();
	   		  			$('#yuchuzhi').text(yuchuzhi+' 元');

	   		  		 	$(data).find('sellbuy').each(function(i) {
	                   	
							var rowid=$(this).children('rowid').text();
							var zhuti=$(this).children('zhuti').text();
							
						i++;
	                    });	
	   		  	}
	   		  	if(action=='billinfo')
	   		  	{
	   		
					$(data).find('billinfo').each(function(i) {
						if($(this).children('totalmoney')!=null)
						 	totalmoney=$(this).children('totalmoney').text();
						if($(this).children('huikuanjine')!=null) 
						 	huikuanjine=$(this).children('huikuanjine').text();
						if($(this).children('kaipiaojine')!=null)
						 	kaipiaojine=$(this).children('kaipiaojine').text();
		   		  		if($(this).children('quling')!=null)
						 	quling=$(this).children('quling').text();  	
						  		
		   		  		$('#totalmoney').text(totalmoney);
		   		  		$('#huikuanjine').text(huikuanjine);
		   		  		$('#kaipiaojine').text(kaipiaojine);
		   		  		$('#quling').text(quling);
		   		  
	   		  		});	
	   		  	}
		   		  				
			  },
			  error:function(XmlHttpRequest,textStatus, errorThrown)
		      {
				  var errorPage = XmlHttpRequest.responseText;  
				  alert('获取销售单出错：'+errorThrown);
		      }
		});

	}
</SCRIPT>
<TR><TD class=TableData noWrap>客户:</TD><TD class=TableData noWrap>
<input type='hidden' name='customerid' value='<?php echo $customerid?>' >
<input type='text' name='customerid_ID' value='<?php echo $customername?>' readonly class='SmallStatic' size='25'>&nbsp;必填</TD></TR>
<TR><TD class=TableData noWrap>预储值:</TD><TD class=TableData noWrap><div id='yuchuzhi'></div></TD></TR>
<TR><TD class=TableData noWrap>合同订单:</TD><TD class=TableData noWrap>
<input type='hidden' name='dingdanbillid' value='<?php echo $dingdanbillid?>' >
<input type='text' name='dingdanbillname' value='<?php echo $dingdanbillname?>' readonly class='SmallStatic'>&nbsp;必填</TD></TR>
<TR><TD class=TableData noWrap>总金额:</TD><TD class=TableData noWrap><div id='totalmoney'></div></TD></TR>
<TR><TD class=TableData noWrap>已回款金额:</TD><TD class=TableData noWrap><div id='huikuanjine'></div></TD></TR>
<TR><TD class=TableData noWrap>已开票金额:</TD><TD class=TableData noWrap><div id='kaipiaojine'></div></TD></TR>
<TR><TD class=TableData noWrap>去零:</TD><TD class=TableData noWrap><div id='quling'></div></TD></TR>
<TR>
<TD class=TableData noWrap width=20%>期次:</TD>
<TD class=TableData noWrap colspan="2"><INPUT type="text" title=''
			  maxLength=200 size="25"
			name='qici' value="<?php echo $qici?>"  readonly class='SmallStatic'>&nbsp;
</TD></TR>
<script Language="JavaScript">
function clear_paydate()
{
  document.form1.paydate.value="";
}
</script><TR><TD class=TableContent noWrap width=20%>回款时间:</TD>
<TD class=TableData colspan="2"><INPUT class=SmallInput maxLength=20  name=paydate value="2011-11-07" title='' onkeydown="if(event.keyCode==13)event.keyCode=9" >
<input type="button"  title=''  value="选择" class="SmallButton" onclick="td_calendar('../../Framework/sms_index/calendar_begin.php?datetime=paydate');" title="选择" name="button">&nbsp;&nbsp;<input type="button"  title=''  value="清除" class="SmallButton" onClick="clear_paydate()" title="清除" name="button">必填</TD></TR>
<TR>
<TD class=TableData noWrap width=20%>金额:</TD>
<input type=hidden name='jine_原始值' value=''>
<TD class=TableData noWrap colspan="2"><INPUT type="text" title=''
			class='SmallStatic'  name='jine' value="<?php echo $jine?>"  readonly>&nbsp;
<BR>必填 </TD></TR>
<?php 
print_account("收款账户:","accountid","",1,1);
?>
<TR>
<TD class=TableData noWrap width=20%>备注:</TD>
<TD class=TableData noWrap colspan="2"><TEXTAREA class=BigInput name=beizhu  title='' wrap=yes rows=5 cols=40  ></TEXTAREA>&nbsp;
</TD></TR>
<input type=hidden class=SmallInput name=createman value="<?php echo $_SESSION['LOGIN_USER_ID']?>">
<input type=hidden class=SmallInput name=createtime value="<?php echo date("Y-m-d H:i:s")?>">
<input type=hidden class=SmallInput name=guanlianplanid value="<?php echo $id?>">
<input type=hidden class=SmallInput name=url value="<?php echo $_GET["url"]?>">
<TR><TD class=TableControl noWrap align=middle  colspan="3">
<div align="left">
<input type=submit accesskey="s" name="submit" value=" 保存 " class=SmallButton onClick="" title="快捷键:ALT+s">
<input type=button accesskey="c" name="cancel" value=" 返回 " class=SmallButton onClick="location='huikuanplan_newai.php';" title="快捷键:ALT+c">
</div>
</TD></TR>
</table>
</form>