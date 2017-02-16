<?php
/*
版权归属:郑州单点科技软件有限公司;
联系方式:0371-69663266;
公司地址:河南郑州经济技术开发区第五大街经北三路通信产业园四楼西南;
公司简介:郑州单点科技软件有限公司位于中国中部城市-郑州,成立于2007年1月,致力于把基于先进信息技术（包括通信技术）的最佳管理与业务实践普及到教育行业客户的管理与业务创新活动中，全面提供具有自主知识产权的教育管理软件、服务与解决方案，是中部最优秀的高校教育管理软件及中小学校管理软件提供商。目前己经有多家高职和中职类院校使用通达中部研发中心开发的软件和服务;

软件名称:单点科技软件开发基础性架构平台,以及在其基础之上扩展的任何性软件作品;
发行协议:数字化校园产品为商业软件,发行许可为LICENSE方式;单点CRM系统即SunshineCRM系统为GPLV3协议许可,GPLV3协议许可内容请到百度搜索;
特殊声明:软件所使用的ADODB库,PHPEXCEL库,SMTARY库归原作者所有,余下代码沿用上述声明;
*/

function CustomerKaiPiao_add($fields, $i )
{
	
global $db,$_SESSION,$common_html;
$notnull=trim($fields['null'][$i]['inputtype']);
$notnull=='notnull'?$notnulltext=$common_html['common_html']['mustinput']:$notnulltext='';

$fieldname1=$fields['name'][$i];
$fieldname2=$fields['input'][$i][0];

$j = array_search($fieldname2,$fields['name'],true);
$notnull=trim($fields['null'][$j]['inputtype']);
$notnull=='notnull'?$notnulltext1=$common_html['common_html']['mustinput']:$notnulltext1='';

$class = "SmallSelect";
print "<script language=javascript>
var xmlHttp1;   
function createxmlHttp1_buysellbill() {
    if (window.xmlHttp1Request) {
       xmlHttp1 = new xmlHttpRequest();              
    } else {
       xmlHttp1 = new ActiveXObject(\"Microsoft.xmlHttp\");
    }
}
function sendRequest(action,params) {
    createxmlHttp1_buysellbill();    
    xmlHttp1.onreadystatechange =function() {showCartInfo(action)};                        
    xmlHttp1.open(\"GET\", \"getLinkmanBycustomer.php?action=\"+action+\"&\" + params, false);
    xmlHttp1.send(null);
}
function showCartInfo(action) {
    if (xmlHttp1.readyState == 4) {
    	
        if(xmlHttp1.responseText.indexOf(\"root\")==-1)
        	{
				alert(xmlHttp1.responseText);
				return false;
        	}
    		var doc = new ActiveXObject(\"MSxml2.DOMDocument\");
   		 	doc.loadXML(xmlHttp1.responseText);
			
			var rootnode = doc.getElementsByTagName(\"root\")[0];
   		 	
   		  	if(action=='billinfo')
   		  	{
   		  		//alert(xmlHttp1.responseText);
   		  		var detailnode = doc.getElementsByTagName(\"billinfo\")[0];
   		  		var totalmoney=0;
   		  		var huikuanjine=0;
   		  		var kaipiaojine=0;
   		  		var quling=0;
   		  		
   		  		if(detailnode.childNodes[0].childNodes[0]!=null)
				 	totalmoney=detailnode.childNodes[0].childNodes[0].nodeValue;
				if(detailnode.childNodes[1].childNodes[0]!=null) 
				 	huikuanjine=detailnode.childNodes[1].childNodes[0].nodeValue;
				if(detailnode.childNodes[2].childNodes[0]!=null)
				 	kaipiaojine=detailnode.childNodes[2].childNodes[0].nodeValue;
   		  		if(detailnode.childNodes[3].childNodes[0]!=null)
				 	quling=detailnode.childNodes[3].childNodes[0].nodeValue;
				 	   		  		
   		  		document.getElementById('totalmoney').innerText=totalmoney;
   		  		document.getElementById('quling').innerText=quling;
   		  		document.getElementById('huikuanjine').innerText=huikuanjine;
   		  		document.getElementById('kaipiaojine').innerText=kaipiaojine;
   		  		form1.piaojujine.value=delFormat(totalmoney)-delFormat(kaipiaojine);
   		  	}
   		  	if(action=='kaipiao')
   		  	{
   		  		//alert(xmlHttp1.responseText);
   		  		var yuchuzhi=rootnode.childNodes[0].nodeValue;
   		  		document.getElementById('yuchuzhi').innerText=yuchuzhi+' 元';
   		  		var detailnode = doc.getElementsByTagName(\"sellbuy\")[0];
				var subcat = new Array();
				var i=0;
			
				
				while(detailnode!=null && detailnode.nodeName=='sellbuy')
				{
					
						subcat[i]=new Array();
						var rowid=detailnode.childNodes[0].childNodes[0].nodeValue;
						var zhuti=detailnode.childNodes[1].childNodes[0].nodeValue;
						subcat[i][0]=rowid;
						subcat[i][1]=zhuti;
						document.form1.$fieldname2.options[document.form1.$fieldname2.length] = new Option(zhuti, rowid);
						if(rowid=='".$fields['value'][$fieldname2]."')
							document.form1.$fieldname2.options[document.form1.$fieldname2.length-1].selected=true;
						i++;
						detailnode=detailnode.nextSibling;
				}
			}
			
    }
};
function changelocation(locationid)
{
	document.form1.$fieldname2.length = 0;
	if(locationid!='')
	{
    	sendRequest('kaipiao','customerid='+locationid);
    	getPayType(document.form1.$fieldname2.value);
    	
    }
	
}
function getPayType(billid)
{
   	sendRequest('billinfo','billid='+billid);
}

";
if($fields['value'][$fieldname1]!='')
{
	print "window.onload=function(){
	changelocation(".$fields['value'][$fieldname1].");
	}
	";
}
print "
</SCRIPT>\n";
print "<TR><TD class=TableData noWrap>客户:</TD><TD class=TableData noWrap>\n";
$customername=returntablefield("customer", "rowid", $fields['value'][$fieldname1], "supplyname");
print "<input type='hidden' name='$fieldname1' value='".$fields['value'][$fieldname1]."' >";
print "<input type='text' name='".$fieldname1."_ID' value='".$customername."' readonly class='SmallStatic' size='30'>";
print "&nbsp;<input type=\"button\" title='' value=\"选择\" class=\"SmallButton\" onClick=\"var oldid=".$fieldname1."_ID.value; SelectAllInforSingle('../../Enginee/Module/kehu_select_single/index.php','','".$fieldname1."_ID', '$fieldname1');if(oldid!=".$fieldname1."_ID.value){changelocation(".$fieldname1.".value)};\" >&nbsp;";
print "</SELECT>&nbsp;$notnulltext</TD></TR>\n";
print "<TR><TD class=TableData noWrap>预储值:</TD><TD class=TableData noWrap><div id='yuchuzhi'></div></TD></TR>\n";

print "<TR><TD class=TableData noWrap>合同订单:</TD><TD class=TableData noWrap>\n";
print "<SELECT onkeydown=\"if(event.keyCode==13)event.keyCode=9\" class=\"$class\" \n";
print "size=1 name='".$fieldname2."' onchange=\"getPayType(this.value);\"></SELECT>&nbsp;$notnulltext1</TD></TR>\n";


print "<TR><TD class=TableData noWrap>总金额:</TD><TD class=TableData noWrap><div id='totalmoney'></div></TD></TR>\n";
print "<TR><TD class=TableData noWrap>去零:</TD><TD class=TableData noWrap><div id='quling'></div></TD></TR>\n";
print "<TR><TD class=TableData noWrap>已回款金额:</TD><TD class=TableData noWrap><div id='huikuanjine'></div></TD></TR>\n";
print "<TR><TD class=TableData noWrap>已开票金额:</TD><TD class=TableData noWrap><div id='kaipiaojine'></div></TD></TR>\n";
}



?>
