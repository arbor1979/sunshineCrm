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

function SupplyLinkmanPriv_add($fields, $i )
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

print "<script type=\"text/javascript\" language=\"javascript\" src=\"".ROOT_DIR."general/ERP/Enginee/jquery/jquery.js\"></script>";
print "<script language=javascript>
function changelocation1(locationid)
{

	document.form1.$fieldname2.length = 0;
    sendRequest_supplylinkman('customerid='+locationid);
}
var $$ = jQuery.noConflict();
function sendRequest_supplylinkman(params) 
{

    $$.ajax({ 
		  type:'GET', 
		  url:'getLinkmanBycustomer.php?action=supply&'+params, 
		  dataType: 'xml', 
		  cache:false,
		  success:function(data) 
		  { 
		  	
		  	var yuchuzhi=$$(data).find('chuzhi').text();
		  	$$('#yuchuzhi').html(yuchuzhi+' 元');";
   		  	
				
				if($notnulltext1=='')
   		  			print "document.form1.$fieldname2.options[document.form1.$fieldname2.length] = new Option('','');";
   		  		print "
   		  		
	   		  	 $$(data).find('supply').each(function() {
      		
						var rowid=$$(this).find('rowid').text();
						var name=$$(this).find('supplyname').text();

						document.form1.$fieldname2.options[document.form1.$fieldname2.length] = new Option(name, rowid);
						if(rowid=='".$fields['value'][$fieldname2]."')
							document.form1.$fieldname2.options[document.form1.$fieldname2.length-1].selected=true;
					
                    });				
		  },
		  error:function(XmlHttpRequest,textStatus, errorThrown)
	      {
			  var errorPage = XmlHttpRequest.responseText;  
			  alert('获取联系人出错：'+errorThrown);
	      }
	});
    
}
";


	
	print "
	function initloadchange()
	{
		";
	if($fields['value'][$fieldname1]!='')
	{
		print "changelocation1(".$fields['value'][$fieldname1].");";
	}
	print "
	}
	if (document.all){

		window.attachEvent('onload',initloadchange)//IE中

		}

	else{

		window.addEventListener('load',initloadchange,false);//firefox

	}
	
	";

print "
</SCRIPT>\n";

$supplyname=returntablefield("supply", "rowid", $fields['value'][$fieldname1], "supplyname");
$fieldnameID = $fieldname1."_ID";
print "<TR><TD class=TableData noWrap>供应商:</TD><TD class=TableData noWrap>\n";
print "<input type=\"hidden\"  name=\"$fieldname1\" value=\"".$fields['value'][$fieldname1]."\" onchange=\"changelocation1(this.value);\">";
print "<input name=\"".$fieldnameID."\" value=\"".$supplyname."\" class=\"SmallStatic\" readonly size=30>&nbsp;\n";
print "<input type=\"button\" title='' value=\"选择\" class=\"SmallButton\" onClick=\"SelectAllInforSingle('../../Enginee/Module/supply_select_single/index.php','','$fieldnameID', '$fieldname1');\" >&nbsp;$notnulltext";
print "</TD></TR>\n";
print "<TR><TD class=TableData noWrap>预储值:</TD><TD class=TableData noWrap><div id='yuchuzhi'></div></TD></TR>\n";
print "<TR><TD class=TableData noWrap>供应商联系人:</TD><TD class=TableData noWrap>\n";
print "<SELECT name=$fieldname2 class=\"$class\"  onkeydown=\"if(event.keyCode==13)event.keyCode=9\">\n";
print "</SELECT>&nbsp;$notnulltext1</TD></TR>\n";

}


function SupplyLinkmanPriv_value_PRIV( $fieldvalue, $fields, $i )
{

}

?>
