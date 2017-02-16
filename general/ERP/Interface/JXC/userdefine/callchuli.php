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

function callchuli_add($fields, $i )
{
	
global $db,$_SESSION,$common_html;
$notnull=trim($fields['null'][$i]['inputtype']);
$notnull=='notnull'?$notnulltext=$common_html['common_html']['mustinput']:$notnulltext='';

$fieldname1=$fields['name'][$i];
$fieldname2=$fields['input'][$i][0];
$fieldname3=$fields['input'][$i][1];
$fieldname4=$fields['input'][$i][2];
$fieldname5=$fields['input'][$i][3];
$fieldname6=$fields['input'][$i][4];

$class = "SmallSelect";
print "<script type=\"text/javascript\" language=\"javascript\" src=\"".ROOT_DIR."general/ERP/Enginee/jquery/jquery.js\"></script>";
print "<script language=javascript>

function sendRequest(action,params) {
$.ajax({ 
		  type:'GET', 
		  url:'getLinkmanBycustomer.php?action='+action+'&'+params, 
		  dataType: 'xml', 
		  cache:false,
		  async: false,
		  success:function(data) 
		  { 
		  	
   		  	if(action=='callchuli')
   		  	{
   		
				$(data).find('callchuli').each(function(i) {
					if($(this).children('customername')!=null)
					 	customername=$(this).children('customername').text();
					if($(this).children('linkmanname')!=null) 
					 	linkmanname=$(this).children('linkmanname').text();
					if($(this).children('calltype')!=null)
					 	calltype=$(this).children('calltype').text();
	   		  		if($(this).children('callid')!=null)
					 	callid=$(this).children('callid').text();  	
					if($(this).children('callmanid')!=null)
					 	callmanid=$(this).children('callmanid').text();  	

					document.form1.$fieldname2.value=customername;
					document.form1.$fieldname3.value=linkmanname;
	   		  		document.form1.$fieldname4.value=calltype;
	   		  		document.form1.$fieldname5.value=callid;
	   		  		document.form1.$fieldname6.value=callmanid;
	   		  		if(calltype=='客户')
	   		  		{
	   		  			document.getElementById('viewcust').innerHTML=\"<a href='customer_newai.php?action=view_default&ROWID=\"+callid+\"' target='_blank'>查看资料</a>\";
	   		  			if(callmanid!='')
	   		  			{
	   		  				document.getElementById('viewlink').innerHTML=\"<a href='linkman_newai.php?action=view_default&ROWID=\"+callmanid+\"' target='_blank'>查看资料</a>\";
	   		  			}
	   		  		}
	   		  		if(calltype=='供应商')
	   		  		{
	   		  			document.getElementById('viewcust').innerHTML=\"<a href='supply_newai.php?action=view_default&ROWID=\"+callid+\"' target='_blank'>查看资料</a>\";
	   		  			if(callmanid!='')
	   		  			{
	   		  				document.getElementById('viewlink').innerHTML=\"<a href='supplylinkman_newai.php?action=view_default&ROWID=\"+callmanid+\"' target='_blank'>查看资料</a>\";
	   		  			}
	   		  		}
	   		  		
   		  		});	
   		  	}
	   		  				
		  },
		  error:function(XmlHttpRequest,textStatus, errorThrown)
	      {
			  var errorPage = XmlHttpRequest.responseText;  
			  alert('出错：'+errorThrown);
	      }
	});

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
   		 	
   		  	if(action=='callchuli')
   		  	{
   		  		//alert(xmlHttp1.responseText);
   		  		var detailnode = doc.getElementsByTagName(\"callchuli\")[0];
   		  		var customername='';
   		  		var linkmanname='';
   		  		var calltype='';
   		  		var callid='';
   		  		var callmanid='';
   		  		
   		  		if(detailnode.childNodes[0].childNodes[0]!=null)
				 	customername=detailnode.childNodes[0].childNodes[0].nodeValue;
				if(detailnode.childNodes[1].childNodes[0]!=null) 
				 	linkmanname=detailnode.childNodes[1].childNodes[0].nodeValue;
				if(detailnode.childNodes[2].childNodes[0]!=null) 
				 	calltype=detailnode.childNodes[2].childNodes[0].nodeValue;
				if(detailnode.childNodes[3].childNodes[0]!=null) 
				 	callid=detailnode.childNodes[3].childNodes[0].nodeValue;
				if(detailnode.childNodes[4].childNodes[0]!=null) 
				 	callmanid=detailnode.childNodes[4].childNodes[0].nodeValue;
				
   		  	}
			
    }
}
function changelocation(locationid)
{

	if(locationid!='')
	{
		
    	sendRequest('callchuli','mobile='+locationid);
    	
    }
	
}
function resetCustomer()
{
	document.form1.$fieldname4.value='其他';
	document.form1.$fieldname5.value='';
	document.getElementById('viewcust').innerHTML='';
}
function resetLinkman()
{
	
}

";

print "
</SCRIPT>\n";
print "<TR><TD class=TableData noWrap>来电号码:</TD><TD class=TableData noWrap>\n";
$customername=returntablefield("customer", "rowid", $fields['value'][$fieldname1], "supplyname");
print "<input type='text' name='$fieldname1' value='".$fields['value'][$fieldname1]."' class='SmallInput' size='30' onkeydown=\"if(event.keyCode==13)event.keyCode=9\" 
onChange=\"changelocation(".$fieldname1.".value);\">";
print "<input type='hidden' name='".$fieldname1."_ID' value='".$fields['value'][$fieldname1]."'>";
print "</SELECT>&nbsp;$notnulltext</TD></TR>\n";
print "<TR><TD class=TableData noWrap>单位名称:</TD><TD class=TableData noWrap>
<input type='text' name='$fieldname2' id='$fieldname2' value='".$fields['value'][$fieldname2]."' class='SmallInput' size='30' onkeydown=\"if(event.keyCode==13)event.keyCode=9\" onchange='resetCustomer();'> <span id='viewcust'></span>
</TD></TR>\n";

print "<TR><TD class=TableData noWrap>联系人:</TD><TD class=TableData noWrap>\n";
print "<input type='text' name='$fieldname3' id='$fieldname3' value='".$fields['value'][$fieldname3]."' class='SmallInput' size='30' onkeydown=\"if(event.keyCode==13)event.keyCode=9\" onchange='resetLinkman();'>  <span id='viewlink'></span>";

}

function callchuli_value( $fieldvalue, $fields, $i )
{

	$uniturl='';
	
	$colorValue = setColorByName($fieldvalue);
	
	if($fields['value'][$i]['callertype']=='客户')
	{
		
		$uniturl="<a href='customer_newai.php?".base64_encode("action=view_default&ROWID=".$fields['value'][$i]['customerid'])."' target='_blank'><font color=$colorValue>$fieldvalue</font></a>";
	}	
	else if($fields['value'][$i]['callertype']=='供应商')
	{
		$uniturl="<a href='supply_newai.php?".base64_encode("action=view_default&ROWID=".$fields['value'][$i]['customerid'])."' target='_blank'><font color=$colorValue>$fieldvalue</font></a>";
	}
	else 
	{
		
		$customerid=returntablefield("customer", "supplyname", $fieldvalue, "rowid");
		if($customerid!='')
			$uniturl="<a href='customer_newai.php?".base64_encode("action=view_default&ROWID=".$customerid)."' target='_blank'><font color=$colorValue>$fieldvalue</font></a>";
	}
	if($uniturl!='')
		$fieldvalue=$uniturl;
	else
	{
		$tel=returntablefield("callchuli", "id", $fields['value'][$i]['id'], "tel");
		$fieldvalue.=" <a href='customer_newai.php?".base64_encode("action=add_default&supplyname=".$fieldvalue."&phone=".$tel)."' target='_blank'><img src='../Framework/images/notify_new.gif' title='创建客户'></a>";
	}
	return $fieldvalue;
}
function callchuli_view( $fields, $i )
{
	$uniturl='';
	$fieldvalue=$fields['value']['customer'];
	if($fields['value']['callertype']=='客户')
	{
		$uniturl="<a href='customer_newai.php?".base64_encode("action=view_default&ROWID=".$fields['value']['customerid'])."' target='_blank'>".$fieldvalue."</a>";
	}	
	else if($fields['value']['callertype']=='供应商')
		$uniturl="<a href='supply_newai.php?".base64_encode("action=view_default&ROWID=".$fields['value']['customerid'])."' target='_blank'>".$fieldvalue."</a>";
	else 
	{
		$customerid=returntablefield("customer", "supplyname", $fieldvalue, "rowid");
		if($customerid!='')
			$uniturl="<a href='customer_newai.php?".base64_encode("action=view_default&ROWID=".$customerid)."' target='_blank'>".$fieldvalue."</a>";
	}
	if($uniturl!='')
		$fieldvalue=$uniturl;
	else
	{
		$tel=returntablefield("callchuli", "id", $fields['value']['id'], "tel");
		$fieldvalue.=" <a href='customer_newai.php?".base64_encode("action=add_default&supplyname=".$fieldvalue."&phone=".$tel)."' target='_blank'><img src='../Framework/images/notify_new.gif' title='创建客户'></a>";
	}
	$Text="<TR><TD class=TableContent noWrap>".$fields['null'][$i]['inputtext'].":</TD><td class=TableData noWrap>$fieldvalue</td></tr>";
	return $Text;
}
function callchuli_value_PRIV( $fieldvalue, $fields, $i )
{
		
				$SYSTEM_STOP_ROW['edit_priv'] = 0;
				$SYSTEM_STOP_ROW['delete_priv'] = 0;
				$SYSTEM_STOP_ROW['flow_priv'] = 1;								
				if($fields['value'][$i]['createman']!=$_SESSION['LOGIN_USER_ID'])
				{
					$SYSTEM_STOP_ROW['edit_priv'] = 1;
					$SYSTEM_STOP_ROW['delete_priv'] = 1;
				}
				if($fields['value'][$i]['callertype']=='客户' && $fields['value'][$i]['calltype']=='1')
					$SYSTEM_STOP_ROW['flow_priv'] = 0;
				return $SYSTEM_STOP_ROW;
}

?>
