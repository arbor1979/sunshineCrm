<?php
	$id=$_GET["id"];
	ini_set('display_errors', 1);
	ini_set('error_reporting', E_ALL);
	error_reporting(E_WARNING | E_ERROR);
	require_once('lib.inc.php');
	$GLOBAL_SESSION=returnsession();
	page_css("ȷ�ϸ���");
	global $db;
	$sql="select * from fukuanplan where id=".$id;
	$rs=$db->Execute($sql);
	$rs_a = $rs->GetArray();
	if(count($rs_a)==0)
	{
		print "<script language=javascript>alert('�����Ҳ����˸���ƻ�');window.history.back(-1);</script>";
    	exit;
	}
	$customerid=$rs_a[0]['supplyid'];
	$qici=$rs_a[0]['qici'];
	$customername=returntablefield("supply","rowid",$customerid,"supplyname");
	$dingdanbillid=$rs_a[0]['caigoubillid'];
	$dingdanbillname=returntablefield("buyplanmain","billid",$dingdanbillid,"zhuti");
	$jine=$rs_a[0]['jine'];
?>
<script language = "JavaScript"> 
function FormCheck() 
{
if (document.form1.supplyid.value == "") {
alert("��Ӧ�̲���Ϊ��");
 return false;}
if (document.form1.caigoubillid.value == "") {
alert("�ɹ�����Ų���Ϊ��");
 return false;}
if (document.form1.paydate.value == "") {
alert("����ʱ�䲻��Ϊ��");
 return false;}
if (document.form1.jine.value == "") {
alert("����Ϊ��");
 return false;}
}
</script>
<FORM name=form1 onsubmit="return FormCheck();" 
 action="fukuanrecord_newai.php?action=add_default_data&pageid=1" method=post encType=multipart/form-data>
<table class=TableBlock align=center width=450 ><TR><TD class=TableHeader align=left colSpan=3>&nbsp;ȷ�ϸ���</TD></TR>
<TR><TD class=TableControl noWrap align=middle  colspan="3">
<div align="left">
<input type=submit accesskey="s" name="submit" value=" ���� " class=SmallButton onClick="" title="��ݼ�:ALT+s">
<input type=button accesskey="c" name="cancel" value=" ���� " class=SmallButton onClick="location='fukuanplan_newai.php';" title="��ݼ�:ALT+c">
</div>
</TD></TR>
<script type="text/javascript" language="javascript" src="<?php echo ROOT_DIR?>general/ERP/Enginee/jquery/jquery.js"></script>
<script language=javascript>
var $$ = jQuery.noConflict();
$$(document).ready(function ()
{	
	
	changelocation(<?php echo $customerid?>);
	getPayType(<?php echo $dingdanbillid?>);
})
	
function changelocation(locationid)
{
	document.form1.caigoubillid.length = 0;
	if(locationid!='')
	{
    	sendRequest('fukuan','customerid='+locationid);
    	
    }
	
}


function getPayType(billid)
{
   	sendRequest('caigouinfo','billid='+billid);
}

	

	var totalmoney=0;
	var huikuanjine=0;
	var kaipiaojine=0;
	var quling=0; 
	function sendRequest(action,params) {
		$$.ajax({ 
			  type:'GET', 
			  url:'getLinkmanBycustomer.php?action='+action+'&'+params, 
			  dataType: 'xml', 
			  cache:false,
			  async: false,
			  success:function(data) 
			  { 
			  	if(action=='fukuan' || action=='shoupiao')
	   		  	{
	   		
					var yuchuzhi=$$(data).find('chuzhi').text();
	   		  		$$('#yuchuzhi').text(yuchuzhi+' Ԫ');

	   		  	
	   		  	}
	   		  	if(action=='caigouinfo')
	   		  	{
	   		
					$$(data).find('caigouinfo').each(function(i) {
						if($$(this).children('totalmoney')!=null)
						 	totalmoney=$$(this).children('totalmoney').text();
						if($$(this).children('paymoney')!=null) 
						 	huikuanjine=$$(this).children('paymoney').text();
						if($$(this).children('shoupiaomoney')!=null)
						 	kaipiaojine=$$(this).children('shoupiaomoney').text();
		   		  		if($$(this).children('oddment')!=null)
						 	quling=$$(this).children('oddment').text();  	
						  		
		   		  		$$('#totalmoney').text(totalmoney);
		   		  		$$('#paymoney').text(huikuanjine);
		   		  		$$('#shoupiaomoney').text(kaipiaojine);
		   		  		$$('#oddment').text(quling);
		   		  		if(form1.jine!=null)
		   		  			form1.jine.value=delFormat(totalmoney)-delFormat(huikuanjine)-delFormat(quling);
		   		  		if(form1.piaojujine!=null)
		   		  			form1.piaojujine.value=delFormat(totalmoney)-delFormat(kaipiaojine);
		   		  		if(form1.oddment!=null)
		   		  			form1.oddment.value=0;
	   		  		});	
	   		  	}
		   		  				
			  },
			  error:function(XmlHttpRequest,textStatus, errorThrown)
		      {
				  var errorPage = XmlHttpRequest.responseText;  
				  alert('��ȡ�ɹ�������'+errorThrown);
		      }
		});

	}

function showCartInfo(action) {
    if (xmlHttp1.readyState == 4) {
    	
        if(xmlHttp1.responseText.indexOf("root")==-1)
        	{
				alert(xmlHttp1.responseText);
				return false;
        	}
    		var doc = new ActiveXObject("MSxml2.DOMDocument");
   		 	doc.loadXML(xmlHttp1.responseText);
			
			var rootnode = doc.getElementsByTagName("root")[0];
			alert(xmlHttp1.responseText);
   		  	if(action=='caigouinfo')
   		  	{
   		  		
   		  		var detailnode = doc.getElementsByTagName("caigouinfo")[0];
   		  		var oddment=0;
   		  		var totalmoney=0;
   		  		var paymoney=0;
   		  		var shoupiaomoney=0;
   		  		if(detailnode.childNodes[0].childNodes[0]!=null)
   	   		  		totalmoney=detailnode.childNodes[0].childNodes[0].nodeValue;
   		  		if(detailnode.childNodes[1].childNodes[0]!=null)
   	   		  		paymoney=detailnode.childNodes[1].childNodes[0].nodeValue;
				if(detailnode.childNodes[2].childNodes[0]!=null) 
					shoupiaomoney=detailnode.childNodes[2].childNodes[0].nodeValue;
				if(detailnode.childNodes[3].childNodes[0]!=null)
					oddment=detailnode.childNodes[3].childNodes[0].nodeValue;
   		  		   		  		
   		  		
   		  		document.getElementById('totalmoney').innerText=totalmoney;
   		  		document.getElementById('paymoney').innerText=paymoney;
   		  		document.getElementById('shoupiaomoney').innerText=shoupiaomoney;
   	   		  	document.getElementById('oddment').innerText=oddment;
   		  		
   		  	}
   		  	if(action=='fukuan')
   		  	{
   		  		var yuchuzhi=rootnode.childNodes[0].childNodes[0].nodeValue;
   		  		document.getElementById('yuchuzhi').innerText=yuchuzhi+' Ԫ';
   		  		var detailnode = doc.getElementsByTagName("sellbuy")[0];
				
				var rowid=detailnode.childNodes[0].childNodes[0].nodeValue;
				var zhuti=detailnode.childNodes[1].childNodes[0].nodeValue;

				
				
			}
			
    }
}
</SCRIPT>
<TR><TD class=TableData noWrap>��Ӧ��:</TD><TD class=TableData noWrap>
<input type='hidden' name='supplyid' value='<?php echo $customerid?>' >
<input type='text' name='customerid_ID' value='<?php echo $customername?>' readonly class='SmallStatic' size='25'>&nbsp;����</TD></TR>
<TR><TD class=TableData noWrap>Ԥ����:</TD><TD class=TableData noWrap><div id='yuchuzhi'></div></TD></TR>
<TR><TD class=TableData noWrap>�ɹ���:</TD><TD class=TableData noWrap>
<input type='hidden' name='caigoubillid' value='<?php echo $dingdanbillid?>' >
<input type='text' name='dingdanbillname' value='<?php echo $dingdanbillname?>' readonly class='SmallStatic'>&nbsp;����</TD></TR>
<TR><TD class=TableData noWrap>�ܽ��:</TD><TD class=TableData noWrap><div id='totalmoney'></div></TD></TR>
<TR><TD class=TableData noWrap>�Ѹ�����:</TD><TD class=TableData noWrap><div id='paymoney'></div></TD></TR>
<TR><TD class=TableData noWrap>����Ʊ���:</TD><TD class=TableData noWrap><div id='shoupiaomoney'></div></TD></TR>
<TR><TD class=TableData noWrap>ȥ��:</TD><TD class=TableData noWrap><div id='oddment'></div></TD></TR>
<TR>
<TD class=TableData noWrap width=20%>�ڴ�:</TD>
<TD class=TableData noWrap colspan="2"><INPUT type="text" title=''
			maxLength=200 size="25" name='qici' value="<?php echo $qici?>"  readonly class='SmallStatic'>&nbsp;
</TD></TR>
<script Language="JavaScript">
function clear_paydate()
{
  document.form1.paydate.value="";
}
</script><TR><TD class=TableContent noWrap width=20%>����ʱ��:</TD>
<TD class=TableData colspan="2"><INPUT class=SmallInput maxLength=20  name=paydate value="2011-11-07" title='' onkeydown="if(event.keyCode==13)event.keyCode=9" >
<input type="button"  title=''  value="ѡ��" class="SmallButton" onclick="td_calendar('../../Framework/sms_index/calendar_begin.php?datetime=paydate');" title="ѡ��" name="button">&nbsp;&nbsp;<input type="button"  title=''  value="���" class="SmallButton" onClick="clear_paydate()" title="���" name="button">����</TD></TR>
<TR>
<TD class=TableData noWrap width=20%>���:</TD>
<input type=hidden name='jine_ԭʼֵ' value=''>
<TD class=TableData noWrap colspan="2"><INPUT type="text" title=''
			class='SmallStatic'  name='jine' value="<?php echo $jine?>"  readonly>&nbsp;
<BR>���� </TD></TR>
<?php 
print_account("�����˻�:","accountid","",0,1);
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
<input type=button accesskey="c" name="cancel" value=" ���� " class=SmallButton onClick="location='fukuanplan_newai.php';" title="��ݼ�:ALT+c">
</div>
</TD></TR>
</table>
</form>