<?php
	$id=$_GET["id"];
	$url=$_GET["url"];
	ini_set('display_errors', 1);
	ini_set('error_reporting', E_ALL);
	error_reporting(E_WARNING | E_ERROR);
	require_once('lib.inc.php');
	$GLOBAL_SESSION=returnsession();
	page_css("ȷ�ϻؿ�");
	global $db;
	$sql="select * from huikuanplan where id=".$id;
	$rs=$db->Execute($sql);
	$rs_a = $rs->GetArray();
	if(count($rs_a)==0)
	{
		print "<script language=javascript>alert('�����Ҳ����˻ؿ�ƻ�');window.history.back(-1);</script>";
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
alert("�ͻ�����Ϊ��");
 return false;}
if (document.form1.dingdanbillid.value == "") {
alert("��ͬ/������Ų���Ϊ��");
 return false;}
if (document.form1.paydate.value == "") {
alert("�ؿ�ʱ�䲻��Ϊ��");
 return false;}
if (document.form1.jine.value == "") {
alert("����Ϊ��");
 return false;}
}

</script>
<FORM name=form1 onsubmit="return FormCheck();" 
 action="huikuanrecord_newai.php?action=add_default_data&pageid=1" method=post encType=multipart/form-data>
<table class=TableBlock align=center width=450 ><TR><TD class=TableHeader align=left colSpan=3>&nbsp;ȷ�ϻؿ�</TD></TR>
<TR><TD class=TableControl noWrap align=middle  colspan="3">
<div align="left">
<input type=submit accesskey="s" name="submit" value=" ���� " class=SmallButton onClick="" title="��ݼ�:ALT+s">
<input type=button accesskey="c" name="cancel" value=" ���� " class=SmallButton onClick="location='huikuanplan_newai.php';" title="��ݼ�:ALT+c">
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
	   		  			$('#yuchuzhi').text(yuchuzhi+' Ԫ');

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
				  alert('��ȡ���۵�����'+errorThrown);
		      }
		});

	}
</SCRIPT>
<TR><TD class=TableData noWrap>�ͻ�:</TD><TD class=TableData noWrap>
<input type='hidden' name='customerid' value='<?php echo $customerid?>' >
<input type='text' name='customerid_ID' value='<?php echo $customername?>' readonly class='SmallStatic' size='25'>&nbsp;����</TD></TR>
<TR><TD class=TableData noWrap>Ԥ��ֵ:</TD><TD class=TableData noWrap><div id='yuchuzhi'></div></TD></TR>
<TR><TD class=TableData noWrap>��ͬ����:</TD><TD class=TableData noWrap>
<input type='hidden' name='dingdanbillid' value='<?php echo $dingdanbillid?>' >
<input type='text' name='dingdanbillname' value='<?php echo $dingdanbillname?>' readonly class='SmallStatic'>&nbsp;����</TD></TR>
<TR><TD class=TableData noWrap>�ܽ��:</TD><TD class=TableData noWrap><div id='totalmoney'></div></TD></TR>
<TR><TD class=TableData noWrap>�ѻؿ���:</TD><TD class=TableData noWrap><div id='huikuanjine'></div></TD></TR>
<TR><TD class=TableData noWrap>�ѿ�Ʊ���:</TD><TD class=TableData noWrap><div id='kaipiaojine'></div></TD></TR>
<TR><TD class=TableData noWrap>ȥ��:</TD><TD class=TableData noWrap><div id='quling'></div></TD></TR>
<TR>
<TD class=TableData noWrap width=20%>�ڴ�:</TD>
<TD class=TableData noWrap colspan="2"><INPUT type="text" title=''
			  maxLength=200 size="25"
			name='qici' value="<?php echo $qici?>"  readonly class='SmallStatic'>&nbsp;
</TD></TR>
<script Language="JavaScript">
function clear_paydate()
{
  document.form1.paydate.value="";
}
</script><TR><TD class=TableContent noWrap width=20%>�ؿ�ʱ��:</TD>
<TD class=TableData colspan="2"><INPUT class=SmallInput maxLength=20  name=paydate value="2011-11-07" title='' onkeydown="if(event.keyCode==13)event.keyCode=9" >
<input type="button"  title=''  value="ѡ��" class="SmallButton" onclick="td_calendar('../../Framework/sms_index/calendar_begin.php?datetime=paydate');" title="ѡ��" name="button">&nbsp;&nbsp;<input type="button"  title=''  value="���" class="SmallButton" onClick="clear_paydate()" title="���" name="button">����</TD></TR>
<TR>
<TD class=TableData noWrap width=20%>���:</TD>
<input type=hidden name='jine_ԭʼֵ' value=''>
<TD class=TableData noWrap colspan="2"><INPUT type="text" title=''
			class='SmallStatic'  name='jine' value="<?php echo $jine?>"  readonly>&nbsp;
<BR>���� </TD></TR>
<?php 
print_account("�տ��˻�:","accountid","",1,1);
?>
<TR>
<TD class=TableData noWrap width=20%>��ע:</TD>
<TD class=TableData noWrap colspan="2"><TEXTAREA class=BigInput name=beizhu  title='' wrap=yes rows=5 cols=40  ></TEXTAREA>&nbsp;
</TD></TR>
<input type=hidden class=SmallInput name=createman value="<?php echo $_SESSION['LOGIN_USER_ID']?>">
<input type=hidden class=SmallInput name=createtime value="<?php echo date("Y-m-d H:i:s")?>">
<input type=hidden class=SmallInput name=guanlianplanid value="<?php echo $id?>">
<input type=hidden class=SmallInput name=url value="<?php echo $_GET["url"]?>">
<TR><TD class=TableControl noWrap align=middle  colspan="3">
<div align="left">
<input type=submit accesskey="s" name="submit" value=" ���� " class=SmallButton onClick="" title="��ݼ�:ALT+s">
<input type=button accesskey="c" name="cancel" value=" ���� " class=SmallButton onClick="location='huikuanplan_newai.php';" title="��ݼ�:ALT+c">
</div>
</TD></TR>
</table>
</form>