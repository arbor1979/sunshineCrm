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
			  alert('获取当日工作汇总出错：'+errorThrown);
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

		window.attachEvent('onload',initloadchange)//IE中
		
		}

	else{

		window.addEventListener('load',initloadchange,false);//firefox
		
		
		
	}
	
	";
print "
</SCRIPT>\n";

print "<TR><TD class=TableContent noWrap width=20%>工作日期:</TD>
<TD class=TableData colspan='2'><INPUT class=SmallInput maxLength=20 id='workdate' name=workdate value='".$fields['value'][$fieldname1]."' title=''  onpropertychange='changelocation1(this.value);' onClick=\"WdatePicker({dateFmt:'yyyy-MM-dd',alwaysUseStartDate:true})\">
<img src='".ROOT_DIR."general/ERP/Framework/images/menu/calendar.gif' width=16 height=16 title='设置日期' align='absMiddle' border='0' align='absMiddle' style='cursor:pointer' onclick='workdate.click();'></TD></TR>";

print "<TR><TD class=TableData noWrap>当日数据参考:</TD><TD class=TableData noWrap><div id='huizong'></div></TD></TR>\n";


}


?>
