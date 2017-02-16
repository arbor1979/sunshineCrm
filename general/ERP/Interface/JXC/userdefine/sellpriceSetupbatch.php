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

function sellpriceSetupbatch_add($fields, $i )
{
$fieldname=$fields['name'][$i];
print "<script type=\"text/javascript\" language=\"javascript\" src=\"".ROOT_DIR."general/ERP/Enginee/jquery/jquery.js\"></script>";
print "<script>

var $$ = jQuery.noConflict();
	
$$(document).ready(function(){
	 

});
function addvalue()
{
	 
	if($$(\"#newvalue1\").val()<=0 || $$(\"#newvalue1\").val()>1)
	{
	 		alert('值必须为大于0，小于等于1的浮点数');
	 		$$(\"#newvalue1\").val('');
	 		$$(\"#newvalue1\").focus();
	 }
	 else
	 	$$(\"#newvalue\").val('round(sellprice*'+$$(\"#newvalue1\").val()+',2)');
}
</script>";
global $html_etc,$tablename;
print "
<TR>
<TD class=TableData noWrap width=20%>".$html_etc[$tablename][$fieldname].":</TD>
<input type=hidden name='newvalue' id='newvalue' value=''>
<TD class=TableData noWrap colspan=\"2\">零售价 * <INPUT type=\"text\" title=''
			onkeydown=\"if(event.keyCode==13)event.keyCode=9\" accesskey='5' class=\"SmallInput\"   maxLength=200 size=\"30\"
			name='newvalue1' id='newvalue1' value=\"\" onkeypress=\"check_input_num('MONEY')\" onblur=\"this.value=Math.round(this.value*100)/100;if(this.value=='NaN')this.value=0;\" onchange=\"addvalue();if(this.value!='' && (this.value<=0 || this.value>1)){TEXT_sellprice.innerHTML='<font color=red>输入的值必须是大于0，小于等于1的浮点数 </font>';}else {TEXT_sellprice.innerHTML='';}\" >&nbsp(相对于零售价的折扣，输入大于0，小于等于1的浮点数）;
<br><span id='TEXT_sellprice'></span></TD></TR>";
}
?>
