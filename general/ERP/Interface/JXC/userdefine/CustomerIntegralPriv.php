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

function CustomerIntegralPriv_add($fields, $i )
{
	global $db,$_SESSION,$common_html;
	$notnull=trim($fields['null'][$i]['inputtype']);
	$notnull=='notnull'?$notnulltext=$common_html['common_html']['mustinput']:$notnulltext='';
	$fieldname1=$fields['name'][$i];

	$class = "SmallSelect";

	print "<script language=javascript>
var xmlHttp;   
var subcat = new Array();
function createXmlHttp() {
    if (window.XMLHttpRequest) {
       xmlHttp = new XMLHttpRequest();              
    } else {
       xmlHttp = new ActiveXObject(\"Microsoft.XMLHTTP\");
    }
}
function sendRequest(params) {
    createXmlHttp();                        
    xmlHttp.onreadystatechange =function() {showCartInfo()};   
    xmlHttp.open(\"GET\", \"getIntegralBycustomer.php?customerid=\" + params, true);
    xmlHttp.send(null);
}
function changelocation(locationid)
{
	
	document.getElementById('integral').innerText='';	
 	document.getElementById('sum').innerText='';
	if(locationid!='')
    	sendRequest(locationid);
}
function showCartInfo() {
    if (xmlHttp.readyState == 4) 
    {
        	if(xmlHttp.responseText.indexOf(\"root\")==-1)
        	{
				alert(xmlHttp.responseText);
				return false;
        	}
    		//var doc = new ActiveXObject(\"MSxml2.DOMDocument\");
   		 	//doc.loadXML(xmlHttp.responseText);
			doc=xmlHttp.responseXML;
   		 	var rootnode = doc.getElementsByTagName(\"root\")[0];
   		 	//var integral = rootnode.childNodes[0].nodeValue;
  			//var sum = rootnode.childNodes[1].childNodes[0].nodeValue;
			var integral = doc.getElementsByTagName(\"integral\")[0].childNodes[0].nodeValue;
			var sumnod = doc.getElementsByTagName(\"sumnod\")[0].childNodes[0].nodeValue;
   		 	document.getElementById('integral').innerText=integral+' 分';	
   		  	document.getElementById('sum').innerText=sumnod+' 分';
    }
}
";
	if($fields['value'][$fieldname1]!='')
	{
		print "window.onload=function(){
	sendRequest(".$fields['value'][$fieldname1].");
	}
	";
	}
	print "
</SCRIPT>\n";
	print "<TR><TD class=TableData noWrap>客户:</TD><TD class=TableData noWrap>\n";
	$customername=returntablefield("customer", "rowid", $fields['value'][$fieldname1], "supplyname");
	print "<input type='hidden' name='$fieldname1' value='".$fields['value'][$fieldname1]."' onchange=\"changelocation(this.value)\">";
	print "<input type='text' name='".$fieldname1."_ID' value='".$customername."' readonly class='SmallStatic' size='25' >";
	print "&nbsp;<input type=\"button\" title='' value=\"选择\" class=\"SmallButton\" onClick=\"var oldid=".$fieldname1."_ID.value; SelectAllInforSingle('../../Enginee/Module/kehu_select_single/index.php','','".$fieldname1."_ID', '$fieldname1');\" >&nbsp;";
	print "</SELECT>&nbsp;$notnulltext</TD></TR>\n";
	print "<TR><TD class=TableData noWrap>尚余积分:</TD><TD class=TableData noWrap><div id='integral'></div></TD></TR>\n";
	print "<TR><TD class=TableData noWrap>已兑换积分:</TD><TD class=TableData noWrap><div id='sum'></div></TD></TR>\n";
}

function CustomerChancePriv_value_PRIV( $fieldvalue, $fields, $i )
{

}

?>
