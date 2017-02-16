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

function CustomerFuKuan_add($fields, $i )
{
	
global $db,$_SESSION,$common_html;
$notnull=trim($fields['null'][$i]['inputtype']);
$notnull=='notnull'?$notnulltext=$common_html['common_html']['mustinput']:$notnulltext='';

$fieldname1=$fields['name'][$i];
$fieldname2=$fields['input'][$i][0];

$j = array_search($fieldname2,$fields['name'],true);
$notnull=trim($fields['null'][$j]['inputtype']);
$notnull=='notnull'?$notnulltext1=$common_html['common_html']['mustinput']:$notnulltext1='';

$action=$fields['input'][$i][1];
$class = "SmallSelect";
print "<script type=\"text/javascript\" language=\"javascript\" src=\"".ROOT_DIR."general/ERP/Enginee/jquery/jquery.js\"></script>";
print "<script language=javascript>

$(document).ready(function (){	
	
	";
	if($fields['value'][$fieldname1]!='')
	{
	print "changelocation(".$fields['value'][$fieldname1].");
		   getPayType(".$fields['value'][$fieldname2].");";
	}
	print "});
function changelocation(locationid)
{
	document.form1.$fieldname2.length = 0;
	if(locationid!='')
	{
    	sendRequest('$action','customerid='+locationid);
    	getPayType(document.form1.$fieldname2.value);
    	
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
$.ajax({ 
		  type:'GET', 
		  url:'getLinkmanBycustomer.php?action='+action+'&'+params, 
		  dataType: 'xml', 
		  cache:false,
		  async: false,
		  success:function(data) 
		  { 
		  	if(action=='fukuan' || action=='shoupiao')
   		  	{
   		
		  	";
				
				print "var yuchuzhi=$(data).find('chuzhi').text();
   		  			$('#yuchuzhi').text(yuchuzhi+' 元');

   		  		 $(data).find('sellbuy').each(function(i) {
                   	
						var rowid=$(this).children('rowid').text();
						var zhuti=$(this).children('zhuti').text();
						
						
						
						document.form1.$fieldname2.options[document.form1.$fieldname2.length] = new Option(zhuti, rowid);
						if(rowid=='".$fields['value'][$fieldname2]."')
							document.form1.$fieldname2.options[document.form1.$fieldname2.length-1].selected=true;
						i++;
                    });	
   		  	}
   		  	if(action=='caigouinfo')
   		  	{
   		
				$(data).find('caigouinfo').each(function(i) {
					if($(this).children('totalmoney')!=null)
					 	totalmoney=$(this).children('totalmoney').text();
					if($(this).children('paymoney')!=null) 
					 	huikuanjine=$(this).children('paymoney').text();
					if($(this).children('shoupiaomoney')!=null)
					 	kaipiaojine=$(this).children('shoupiaomoney').text();
	   		  		if($(this).children('oddment')!=null)
					 	quling=$(this).children('oddment').text();  	
					  		
	   		  		$('#totalmoney').text(totalmoney);
	   		  		$('#paymoney').text(huikuanjine);
	   		  		$('#shoupiaomoney').text(kaipiaojine);
	   		  		$('#oddment').text(quling);
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
			  alert('获取采购单出错：'+errorThrown);
	      }
	});

}

</SCRIPT>
";

print "<TR><TD class=TableData noWrap>供应商:</TD><TD class=TableData noWrap>\n";
$supplyname=returntablefield("supply", "rowid", $fields['value'][$fieldname1], "supplyname");
$fieldnameID = $fieldname1."_ID";
print "<input type=\"hidden\"  name=\"$fieldname1\" value=\"".$fields['value'][$fieldname1]."\" onchange='changelocation(this.value);'>";
print "<input name=\"".$fieldnameID."\" value=\"".$supplyname."\" class=\"SmallStatic\" readonly size=30>&nbsp;\n";

print "<input type=\"button\" title='' value=\"选择\" class=\"SmallButton\" onClick=\"SelectAllInforSingle('../../Enginee/Module/supply_select_single/index.php','','$fieldnameID', '$fieldname1');\" >&nbsp;$notnulltext";

print "<TR><TD class=TableData noWrap>预付款:</TD><TD class=TableData noWrap><div id='yuchuzhi'></div></TD></TR>\n";

print "<TR><TD class=TableData noWrap>采购单:</TD><TD class=TableData noWrap>\n";
print "<SELECT onkeydown=\"if(event.keyCode==13)event.keyCode=9\" class=\"$class\" \n";
print "size=1 name='".$fieldname2."' onchange=\"getPayType(this.value);\"></SELECT>&nbsp;$notnulltext1</TD></TR>\n";

print "<TR><TD class=TableData noWrap>总金额:</TD><TD class=TableData noWrap><div id='totalmoney'></div></TD></TR>\n";
print "<TR><TD class=TableData noWrap>已去零:</TD><TD class=TableData noWrap><div id='oddment'></div></TD></TR>\n";
print "<TR><TD class=TableData noWrap>已付款金额:</TD><TD class=TableData noWrap><div id='paymoney'></div></TD></TR>\n";
print "<TR><TD class=TableData noWrap>已收票金额:</TD><TD class=TableData noWrap><div id='shoupiaomoney'></div></TD></TR>\n";
}



?>
