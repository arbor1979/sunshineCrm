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

function workreport_add($fields, $i )
{
	global $db,$_SESSION,$common_html;
$notnull=trim($fields['null'][$i]['inputtype']);
$notnull=='notnull'?$notnulltext=$common_html['common_html']['mustinput']:$notnulltext='';

$fieldname1=$fields['name'][$i];

$class = "SmallSelect";
print "<script language=\"javascript\" type=\"text/javascript\" src=\"".ROOT_DIR."general/ERP/Enginee/WdatePicker/WdatePicker.js\"></script>";
print "<script type=\"text/javascript\" language=\"javascript\" src=\"".ROOT_DIR."general/ERP/Enginee/jquery/jquery.js\"></script>";
print "<script language=javascript>";
if($_GET['action']=='edit_default')
	print "var ifedit=1;";
else 
	print "var ifedit=0;";
print "
var $$ = jQuery.noConflict();
function sendRequest(action,params) {	
     $$.ajax({ 
		  type:'GET', 
		  url:'workreport_newai.php?action='+action+'&' + params, 
		  dataType: 'text', 
		  cache:false,
		  success:function(data) 
		  { 
			document.getElementById('huizong').innerHTML=data;
		  },
		  error:function(XmlHttpRequest,textStatus, errorThrown)
	      {
			  var errorPage = XmlHttpRequest.responseText;  
			  alert('��ȡ���չ������ܳ���'+errorThrown);
	      }
	});
}

function changelocation1()
{
	document.getElementById('huizong').innerHTML='';
    sendRequest('huizong','id='+document.getElementById('workdate').value+'&ifedit='+ifedit);
}

";


	if($fields['value'][$fieldname1]=='')
		$fields['value'][$fieldname1]=date("Y-m-d");
	print "
	function initloadchange()
	{
		if (!$$.browser.msie)
		{
			document.getElementById('workdate').addEventListener('focus',changelocation1,false);
			
		}
		changelocation1();
	}
	
	if ($$.browser.msie){

		window.attachEvent('onload',initloadchange)//IE��
		
		}

	else{

		window.addEventListener('load',initloadchange,false);//firefox
		
		
		
	}
	
	";
print "
</SCRIPT>\n";

print "<TR><TD class=TableContent noWrap width=20%>��������:</TD>
<TD class=TableData colspan='2'><INPUT class=SmallInput maxLength=20 id='workdate' name=workdate value='".$fields['value'][$fieldname1]."' title=''  onpropertychange='changelocation1(this.value);' onClick=\"WdatePicker({dateFmt:'yyyy-MM-dd',alwaysUseStartDate:true})\">
<img src='".ROOT_DIR."general/ERP/Framework/images/menu/calendar.gif' width=16 height=16 title='��������' align='absMiddle' border='0' align='absMiddle' style='cursor:pointer' onclick='workdate.click();'></TD></TR>";

print "<TR><TD class=TableData noWrap>�������ݲο�:</TD><TD class=TableData noWrap><div id='huizong'></div></TD></TR>\n";


}


?>
