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

function feiyongclasstype_add($fields, $i)
{
	global $db,$_SESSION,$common_html;
$notnull=trim($fields['null'][$i]['inputtype']);
$notnull=='notnull'?$notnulltext=$common_html['common_html']['mustinput']:$notnulltext='';
$fieldname1=$fields['name'][$i];
$kind=$fields['input'][$i][0];
$class = "SmallSelect";
$classid=returntablefield("feiyongtype", "id",$fields['value'][$fieldname1],"classid");

print "<script type=\"text/javascript\" language=\"javascript\" src=\"".ROOT_DIR."general/ERP/Enginee/jquery/jquery.js\"></script>";
print "<script language=javascript>
var $$ = jQuery.noConflict();
function sendRequest(action,params) {

    
    $$.ajax({ 
		  type:'GET', 
		  url:'getLinkmanBycustomer.php?action='+action+'&' + params, 
		  dataType: 'xml', 
		  cache:false,
		  success:function(data) 
		  { 
		   		  		
	   		  	 $$(data).find('feiyongtype').each(function() {
      		
						var rowid=$$(this).find('id').text();
						var zhuti=$$(this).find('typename').text();

						document.form1.$fieldname1.options[document.form1.$fieldname1.length] = new Option(zhuti, rowid);
						if(rowid=='".$fields['value'][$fieldname1]."')
							document.form1.$fieldname1.options[document.form1.$fieldname1.length-1].selected=true;
					
                    });				
		  },
		  error:function(XmlHttpRequest,textStatus, errorThrown)
	      {
			  var errorPage = XmlHttpRequest.responseText;  
			  alert('��ȡ�������'+errorThrown);
	      }
	});
}
function showCartInfo(action) {
    if (xmlHttp.readyState == 4) {
    	
        if(xmlHttp.responseText.indexOf(\"root\")==-1)
        	{
				alert(xmlHttp.responseText);
				return false;
        	}
    		var doc = new ActiveXObject(\"MSxml2.DOMDocument\");
   		 	doc.loadXML(xmlHttp.responseText);
   		 	var rootnode = doc.getElementsByTagName(\"root\")[0];
			
			if(action!='')
   		  	{
	   		  	var detailnode = doc.getElementsByTagName(\"feiyongtype\")[0];
				var subcat = new Array();
				var i=0;
				while(detailnode!=null)
				{
						subcat[i]=new Array();
						var id=detailnode.childNodes[0].childNodes[0].nodeValue;
						var typename=detailnode.childNodes[1].childNodes[0].nodeValue;
						
						subcat[i][0]=id;
						subcat[i][1]=typename;
						
						document.form1.$fieldname1.options[document.form1.$fieldname1.length] = new Option(typename, id);
						if(id=='".$fields['value'][$fieldname1]."')
							document.form1.$fieldname1.options[document.form1.$fieldname1.length-1].selected=true;
						i++;
						detailnode=detailnode.nextSibling;
				}
			}
			
    }
}

function changelocation(locationid)
{

	document.form1.$fieldname1.length = 0;	
	if(locationid!='')
	    sendRequest('feiyongtype','classid='+locationid);
}
window.onload=function (){
	changelocation(form1.classid.value);
	}
";

print "
</SCRIPT>\n";
print "<TR><TD class=TableData noWrap>����:</TD><TD class=TableData noWrap>\n";
print "<select name='classid' onkeydown=\"if(event.keyCode==13)event.keyCode=9\" onchange=changelocation(this.value);>";

$sql="select * from feiyongclass where kind=$kind";
$rs=$db->Execute($sql);
$rs_a=$rs->GetArray();
$selected='';
for($i=0;$i<count($rs_a);$i++)
{
	if($rs_a[$i]['id']==$classid) 
		$selected='selected';
	else 
		$selected='';
	print "<option $selected value='".$rs_a[$i]['id']."'>".$rs_a[$i]['classname']."</option>";
}
print "</select></TD></TR>\n";

print "<TR><TD class=TableData noWrap>����:</TD><TD class=TableData noWrap>\n";
print "<SELECT name=$fieldname1 class=\"$class\"  onkeydown=\"if(event.keyCode==13)event.keyCode=9\">\n";
print "</SELECT>&nbsp;$notnulltext</TD></TR>\n";
print "<input type='hidden' name='kind' value='$kind'>";
}


?>
