<?php
/*
��Ȩ����:֣�ݵ���Ƽ�������޹�˾;
��ϵ��ʽ:0371-69663266;
��˾��ַ:����֣�ݾ��ü��������������־�����·ͨ�Ų�ҵ԰��¥����;
��˾���:֣�ݵ���Ƽ�������޹�˾λ���й��в�����-֣��,������2007��1��,�����ڰѻ����Ƚ���Ϣ����������ͨ�ż���������ѹ�����ҵ��ʵ���ռ���������ҵ�ͻ��Ĺ�����ҵ���»�У�ȫ���ṩ��������֪ʶ��Ȩ�Ľ�����������������������������в�������ĸ�У���������������СѧУ��������ṩ�̡�Ŀǰ�����ж�Ҹ�ְ����ְ��ԺУʹ��ͨ���в��з����Ŀ���������ͷ���;

�������:����Ƽ�������������Լܹ�ƽ̨,�Լ��������֮����չ���κ��������Ʒ;
����Э��:���ֻ�У԰��ƷΪ��ҵ���,�������ΪLICENSE��ʽ;����CRMϵͳ��SunshineCRMϵͳΪGPLV3Э�����,GPLV3Э����������뵽�ٶ�����;
��������:�����ʹ�õ�ADODB��,PHPEXCEL��,SMTARY���ԭ��������,���´���������������;
*/

function CustomerLinkmanChancePriv_add($fields, $i )
{
	
global $db,$_SESSION,$common_html;
$notnull=trim($fields['null'][$i]['inputtype']);
$notnull=='notnull'?$notnulltext=$common_html['common_html']['mustinput']:$notnulltext='';
$fieldname1=$fields['name'][$i];
$fieldname2=$fields['input'][$i][0];
$fieldname3=$fields['input'][$i][1];

$j = array_search($fieldname2,$fields['name'],true);
$notnull=trim($fields['null'][$j]['inputtype']);
$notnull=='notnull'?$notnulltext1=$common_html['common_html']['mustinput']:$notnulltext1='';


$n = array_search($fieldname3,$fields['name'],true);
$notnull=trim($fields['null'][$n]['inputtype']);
$notnull=='notnull'?$notnulltext2=$common_html['common_html']['mustinput']:$notnulltext2='';

$class = "SmallSelect";


print "<script type=\"text/javascript\" language=\"javascript\" src=\"".ROOT_DIR."general/ERP/Enginee/jquery/jquery.js\"></script>";
print "<script language=javascript>
var $$ = jQuery.noConflict();
var subcat=new Array();
function sendRequest(action,params) {

    $$.ajax({ 
		  type:'GET', 
		  url:'getLinkmanBycustomer.php?action='+action+'&' + params, 
		  dataType: 'xml', 
		  cache:false,
		  success:function(data) 
		  { 
				var membercard=$$(data).find('membercard').text();
		  		$$('#membercard').val(membercard);
		  		var yuchuzhi=$$(data).find('chuzhi').text();
		  		var own='';
		  		var customerid=document.form1.".$fieldname1.".value;
				if($$(data).find('ownnum').text()!=null && $$(data).find('ownnum').text()!='')
				{
					var ownnum=$$(data).find('ownnum').text();
					var ownmoney=$$(data).find('ownmoney').text()
					own=\"   ����Ƿ�<a href='../JXC/v_yingshoukuanhuizong_mingxi.php?iffahuo=-1&supplyid=\"+customerid+\"' target='_blank'>\"+ownmoney+\" Ԫ(\"+ownnum+\"��)</a>\";
				}
				$$('#yuchuzhi').html(\"<a href='../JXC/accesspreshou_newai.php?customerid=\"+customerid+\"' target=_blank>\"+yuchuzhi+\"</a> Ԫ\"+own);
				";
				if($notnulltext1=='')
   		  			print "document.form1.$fieldname2.options[document.form1.$fieldname2.length] = new Option('','');";
   		  		print "
   		  		var i=0;
				subcat=new Array();
	   		  	$$(data).find('linkman').each(function() {
                   
						var rowid=$$(this).find('ROWID').text();
						var name=$$(this).find('linkmanname').text();
						var mobile='';
						if($$(this).find('mobile').text()!=null)
							mobile=$$(this).find('mobile').text();
						 
						var address='';
						var birthday='';
						if($$(this).find('address').text()!=null)
							address=$$(this).find('address').text();
						if($$(this).find('birthday').text()!=null)
							birthday=$$(this).find('birthday').text();
						subcat[i]=new Array();
						subcat[i][0]=rowid;
						subcat[i][1]=name;
						subcat[i][2]=mobile;
						subcat[i][3]=address;
						subcat[i][4]=birthday;

						document.form1.$fieldname2.options[document.form1.$fieldname2.length] = new Option(name, rowid);
						if(rowid=='".$fields['value'][$fieldname2]."')
							document.form1.$fieldname2.options[document.form1.$fieldname2.length-1].selected=true;
						i++;
                    });	";
   		  		if($notnulltext2=='')
   		  			print "document.form1.$fieldname3.options[document.form1.$fieldname3.length] = new Option('','');";
   		  		print "		
   		  		$$(data).find('chance').each(function() {
                   
						var rowid=$$(this).find('id').text();
						var zhuti=$$(this).find('zhuti').text();
						
						document.form1.$fieldname3.options[document.form1.$fieldname3.length] = new Option(zhuti, rowid);
						if(rowid=='".$fields['value'][$fieldname3]."')
							document.form1.$fieldname3.options[document.form1.$fieldname3.length-1].selected=true;
                    });	
					if('".$fields['value'][$fieldname2]."'!='')
						setAddressMobile(".$fields['value'][$fieldname2].");
		  },
		  error:function(XmlHttpRequest,textStatus, errorThrown)
	      {
			  var errorPage = XmlHttpRequest.responseText;  
			  alert('��ȡ��ϵ�˳���'+errorThrown);
	      }
	});
}
function sendRequestByMembercard(action,params) {

    $$.ajax({ 
		  type:'GET', 
		  url:'getLinkmanBycustomer.php?action='+action+'&' + params, 
		  dataType: 'xml', 
		  cache:false,
		  success:function(data) 
		  { 
			
		  		var rowid=$$(data).find('ROWID').text();
		  		document.form1.".$fieldname1.".value=rowid;
		  		var supplyname=$$(data).find('supplyname').text();
		  		document.form1.".$fieldname1."_ID.value=supplyname;
		  		document.form1.".$fieldname1.".onchange();	
		  },
		  error:function(XmlHttpRequest,textStatus, errorThrown)
	      {
			  var errorPage = XmlHttpRequest.responseText;  
			  alert('����'+errorThrown);
	      }
	});
}
function changelocation(locationid)
{
	
	document.form1.$fieldname2.length = 0;
	document.form1.$fieldname3.length = 0;
	document.getElementById('birthday_text').innerHTML='';
	if(locationid!='')
    	sendRequest('linkmanchance','customerid='+locationid);
}
function setAddressMobile(linkmanid)
{
	var address=document.getElementsByName('address')[0];
	var mobile=document.getElementsByName('mobile')[0];
	var birthday=document.getElementById('birthday_text');
	birthday.innerHTML='';
	var i;
	
	for(i=0;i<subcat.length;i++)
	{
		if(subcat[i][0]!=null && subcat[i][0]==linkmanid)
			break;
	}
	if(subcat[i]!=null)
	{

		if(address!=null)
		{
			address.value=subcat[i][3];
		}
		if(mobile!=null)
		{
			mobile.value=subcat[i][2];
		}
		if(subcat[i][4]!='')
		{
			birthday.innerHTML='����:'+subcat[i][4];
		}
	}
	
}
function inputTipText(){ 
$$('input[class*=grayTips]') //������ʽ���к���grayTips��input
.each(function(){
   var oldVal=$$(this).val();     //Ĭ�ϵ���ʾ���ı�
   $$(this)
   .css({'color':'#888'})     //��ɫ
   .focus(function()
    {
	    if($$(this).val()!=oldVal)
	    {
	    	$$(this).css({'color':'#000'})
		}
		else
	   	{
	   		$$(this).val('').css({'color':'#888'})
		}
   	})
   .blur(function(){
    if($$(this).val()=='')
    {
    	$$(this).val(oldVal).css({'color':'#888'})
	}
	else 
	{
		
		if($$(this).attr('id')=='membercard')
		{
			sendRequestByMembercard('customer','membercard='+$$(this).val());
		}
	}
   })
   .keydown(function()
   	{
   		$$(this).css({'color':'#000'})
	})
})
}
window.onload=function(){
	inputTipText();
";
if($fields['value'][$fieldname1]!='')
{
	print "changelocation(".$fields['value'][$fieldname1].");";
}

print "}
</SCRIPT>\n";
print "<TR><TD class=TableData noWrap>�ͻ�:</TD><TD class=TableData noWrap>\n";
$customername=returntablefield("customer", "rowid", $fields['value'][$fieldname1], "supplyname");
print "<INPUT type='text'  class='SmallInput grayTips' onkeydown='if(event.keyCode==13)event.keyCode=9' maxLength=25 size=15
 id='membercard' name='membercard' value='�����Ա����ѯ'><input type='hidden' name='$fieldname1' value='".$fields['value'][$fieldname1]."' onchange=\"changelocation(this.value)\">";
print "<input type='text' name='".$fieldname1."_ID' value='".$customername."' readonly class='SmallStatic' size='25'>";
print "&nbsp;<input type=\"button\" title='' value=\"ѡ��\" class=\"SmallButton\" onClick=\"SelectAllInforSingle('../../Enginee/Module/kehu_select_single/index.php','','".$fieldname1."_ID', '$fieldname1');\" >&nbsp;";
print "</SELECT>&nbsp;$notnulltext</TD></TR>\n";
print "<TR><TD class=TableData noWrap>��ǰԤ��ֵ:</TD><TD class=TableData noWrap><div id='yuchuzhi'></div></TD></TR>\n";


print "<TR><TD class=TableData noWrap>�ͻ���ϵ��:</TD><TD class=TableData noWrap>\n";
print "<SELECT name='$fieldname2' class=\"$class\"  onkeydown=\"if(event.keyCode==13)event.keyCode=9\" onchange=setAddressMobile(this.value);>\n";

print "</SELECT>&nbsp;$notnulltext1<span id='birthday_text'></span></TD></TR>\n";


print "<TR><TD class=TableData noWrap>���ۻ���:</TD><TD class=TableData noWrap>\n";

print "<SELECT id='$fieldname3' name='$fieldname3' onkeydown=\"if(event.keyCode==13)event.keyCode=9\" class=\"$class\"> \n";
print "</SELECT>&nbsp;$notnulltext2</TD></TR>\n";

}


function CustomerLinkmanChancePriv_value_PRIV( $fieldvalue, $fields, $i )
{

}

?>
