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
			  alert('获取子类出错：'+errorThrown);
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
print "<TR><TD class=TableData noWrap>大类:</TD><TD class=TableData noWrap>\n";
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

print "<TR><TD class=TableData noWrap>子类:</TD><TD class=TableData noWrap>\n";
print "<SELECT name=$fieldname1 class=\"$class\"  onkeydown=\"if(event.keyCode==13)event.keyCode=9\">\n";
print "</SELECT>&nbsp;$notnulltext</TD></TR>\n";
print "<input type='hidden' name='kind' value='$kind'>";
}


?>
