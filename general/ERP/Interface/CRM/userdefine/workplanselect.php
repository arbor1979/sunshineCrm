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

function workplanselect_add($fields, $i )
{
	global $db,$_SESSION,$common_html;
$notnull=trim($fields['null'][$i]['inputtype']);
$notnull=='notnull'?$notnulltext=$common_html['common_html']['mustinput']:$notnulltext='';

$fieldname1=$fields['name'][$i];

$class = "SmallSelect";

print "<script type=\"text/javascript\" language=\"javascript\" src=\"".ROOT_DIR."general/ERP/Enginee/jquery/jquery.js\"></script>";
print "<script language=javascript>
var $$ = jQuery.noConflict();
function sendRequest(action,params) {	
     $$.ajax({ 
		  type:'GET', 
		  url:'workplanmain_detail_newai.php?action='+action+'&' + params, 
		  dataType: 'xml', 
		  cache:false,
		  success:function(data) 
		  { 
		
	   		  	 $$(data).find('workplanmaindetail').each(function() {
      		
						var begintime=$$(this).find('begintime').text();
						var endtime=$$(this).find('endtime').text();
						var content=$$(this).find('content').text();
						var result=$$(this).find('result').text();
						document.getElementById('yuchuzhi').innerHTML=document.getElementById('yuchuzhi').innerHTML+'<br>'+begintime+' - '+endtime+'  '+content+' ';
                    });				
		  },
		  error:function(XmlHttpRequest,textStatus, errorThrown)
	      {
			  var errorPage = XmlHttpRequest.responseText;  
			  alert('��ȡִ�м�¼����'+errorThrown);
	      }
	});
}


function changelocation1(locationid)
{

	if(locationid!='')
	{
	document.getElementById('yuchuzhi').innerHTML='';
    sendRequest('workplandetail','id='+locationid);
    }
}

function LoadSupplyWindow(URL,fieldnameID,fieldname)
{

	//window.showModalDialog(URL,self,'edge:raised;scroll:0;status:0;help:0;resizable:1;dialogWidth:320px;dialogHeight:285px;dialogTop:'+loc_y+'px;dialogLeft:'+loc_x+'px');
	SelectAllInforSingle(URL,'',fieldnameID, fieldname);
	//var newid=form1.".$fieldname1.".value;
	//changelocation1(newid);
}
";

if($fields['value'][$fieldname1]!='')
{
	
	print "
	function initloadchange()
	{
		changelocation1(".$fields['value'][$fieldname1].");
	}
	if (document.all){

		window.attachEvent('onload',initloadchange)//IE��

		}

	else{

		window.addEventListener('load',initloadchange,false);//firefox

	}
	
	";
}
print "
</SCRIPT>\n";

$supplyname=returntablefield("workplanmain", "id", $fields['value'][$fieldname1], "zhuti");
$fieldnameID = $fieldname1."_ID";
print "<TR><TD class=TableData noWrap>������:</TD><TD class=TableData noWrap>\n";
print "<input type=\"hidden\"  name=\"$fieldname1\" value=\"".$fields['value'][$fieldname1]."\" onchange='changelocation1(this.value);'>";
print "<input name=\"".$fieldnameID."\" value=\"".$supplyname."\" class=\"SmallStatic\" readonly size=30>&nbsp;\n";
print "<input type=\"button\" title='' value=\"ѡ��\" class=\"SmallButton\" onClick=\"LoadSupplyWindow('../../Enginee/Module/workplan_select_single/index.php','$fieldnameID', '$fieldname1');\" >&nbsp;$notnulltext";
print "</TD></TR>\n";
print "<TR><TD class=TableData noWrap>ִ�м�¼:</TD><TD class=TableData noWrap><div id='yuchuzhi'></div></TD></TR>\n";


}


function SupplyLinkmanPriv_value_PRIV( $fieldvalue, $fields, $i )
{

}

?>
