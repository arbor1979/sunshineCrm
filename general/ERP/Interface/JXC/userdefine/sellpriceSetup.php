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

function sellpriceSetup_add($fields, $i )
{

print "<script type=\"text/javascript\" language=\"javascript\" src=\"".ROOT_DIR."general/ERP/Enginee/jquery/jquery.js\"></script>";
print "<script>

var $$ = jQuery.noConflict();
	function s1()
	{
	  	 s2();
	  	 s3();
	  	 s4();
	  	 s5();
	} 
	function s2(){
	  	 if($$(\"#sellprice2\").val()!=0 && $$(\"#sellprice\").val()!=0)
		 	$$(\"#TEXT_sellprice2\").html('(相当于零售价的'+Math.round($$(\"#sellprice2\").val()/$$(\"#sellprice\").val()*100)/10+'折)');
	
	 }
	 function s3(){
	  	 if($$(\"#sellprice3\").val()!=0 && $$(\"#sellprice\").val()!=0)
		 	$$(\"#TEXT_sellprice3\").html('(相当于零售价的'+Math.round($$(\"#sellprice3\").val()/$$(\"#sellprice\").val()*100)/10+'折)');
	
	 }
	 function s4(){
	  	 if($$(\"#sellprice4\").val()!=0 && $$(\"#sellprice\").val()!=0)
		 	$$(\"#TEXT_sellprice4\").html('(相当于零售价的'+Math.round($$(\"#sellprice4\").val()/$$(\"#sellprice\").val()*100)/10+'折)');
	
	 }
	 function s5(){
	  	 if($$(\"#sellprice5\").val()!=0 && $$(\"#sellprice\").val()!=0)
		 	$$(\"#TEXT_sellprice5\").html('(相当于零售价的'+Math.round($$(\"#sellprice5\").val()/$$(\"#sellprice\").val()*100)/10+'折)');
	
	 }
$$(document).ready(function(){

	 $$(\"#sellprice\").change(function(){s1()});
	 $$(\"#sellprice2\").change(function(){s2()});
	 $$(\"#sellprice3\").change(function(){s3()});
	 $$(\"#sellprice4\").change(function(){s4()});
	 $$(\"#sellprice5\").change(function(){s5()});
	 s1();
	 
	 $$(\"form\").submit(function(){
	 	
	 	if($$(\"#sellprice\").val()<0 || $$(\"#sellprice2\").val()<0 || $$(\"#sellprice3\").val()<0 || $$(\"#sellprice4\").val()<0 || $$(\"#sellprice5\").val()<0)
	 	{
	 		alert('销售价格不能小于0');
	 		setSubmitBtn(true);
	 		return false;
	 	}
	 	
	 	return true;
	 });
	  
});
</script>";
global $html_etc,$tablename;
print "
<TR>
<TD class=TableData noWrap width=20%>".$html_etc[$tablename]['sellprice'].":</TD>
<input type=hidden name='sellprice_原始值' value=''>
<TD class=TableData noWrap colspan=\"2\"><INPUT type=\"text\" title=''
			onkeydown=\"if(event.keyCode==13)event.keyCode=9\" accesskey='5' class=\"SmallInput\"   maxLength=200 size=\"30\"
			name='sellprice' id='sellprice' value=\"".$fields['value']['sellprice']."\" onkeypress=\"check_input_num('MONEY')\" onblur=\"this.value=Math.round(this.value*100)/100;if(this.value=='NaN')this.value=0;\" onchange=\"if(this.value!='' && (this.value<-9999999999999 || this.value>9999999999999)){TEXT_sellprice.innerHTML='<font color=red>输入的值必须在 -9999999999999 至 9999999999999 之间 </font>';}else TEXT_sellprice.innerHTML='';\" >&nbsp;
必填 <span id='TEXT_sellprice'></span></TD></TR>
<TR>
<TD class=TableData noWrap width=20%>".$html_etc[$tablename]['sellprice2'].":</TD>
<input type=hidden name='sellprice2_原始值' value=''>
<TD class=TableData noWrap colspan=\"2\"><INPUT type=\"text\" title=''
			onkeydown=\"if(event.keyCode==13)event.keyCode=9\" accesskey='6' class=\"SmallInput\"   maxLength=200 size=\"30\"
			name='sellprice2' id='sellprice2' value=\"".$fields['value']['sellprice2']."\" onkeypress=\"check_input_num('MONEY')\" onblur=\"this.value=Math.round(this.value*100)/100;if(this.value=='NaN')this.value=0;\" onchange=\"if(this.value!='' && (this.value<-9999999999999 || this.value>9999999999999)){TEXT_sellprice2.innerHTML='<font color=red>输入的值必须在 -9999999999999 至 9999999999999 之间 </font>';}else TEXT_sellprice2.innerHTML='';\" >&nbsp;
 <span id='TEXT_sellprice2'></span></TD></TR>
<TR>
<TD class=TableData noWrap width=20%>".$html_etc[$tablename]['sellprice3'].":</TD>
<input type=hidden name='sellprice3_原始值' value=''>
<TD class=TableData noWrap colspan=\"2\"><INPUT type=\"text\" title=''
			onkeydown=\"if(event.keyCode==13)event.keyCode=9\" accesskey='7' class=\"SmallInput\"   maxLength=200 size=\"30\"
			name='sellprice3' id='sellprice3' value=\"".$fields['value']['sellprice3']."\" onkeypress=\"check_input_num('MONEY')\" onblur=\"this.value=Math.round(this.value*100)/100;if(this.value=='NaN')this.value=0;\" onchange=\"if(this.value!='' && (this.value<-9999999999999 || this.value>9999999999999)){TEXT_sellprice3.innerHTML='<font color=red>输入的值必须在 -9999999999999 至 9999999999999 之间 </font>';}else TEXT_sellprice3.innerHTML='';\" >&nbsp;
 <span id='TEXT_sellprice3'></span></TD></TR>
<TR>
<TD class=TableData noWrap width=20%>".$html_etc[$tablename]['sellprice4'].":</TD>
<input type=hidden name='sellprice4_原始值' value=''>
<TD class=TableData noWrap colspan=\"2\"><INPUT type=\"text\" title=''
			onkeydown=\"if(event.keyCode==13)event.keyCode=9\" accesskey='8' class=\"SmallInput\"   maxLength=200 size=\"30\"
			name='sellprice4' id='sellprice4' value=\"".$fields['value']['sellprice4']."\" onkeypress=\"check_input_num('MONEY')\" onblur=\"this.value=Math.round(this.value*100)/100;if(this.value=='NaN')this.value=0;\" onchange=\"if(this.value!='' && (this.value<-9999999999999 || this.value>9999999999999)){TEXT_sellprice4.innerHTML='<font color=red>输入的值必须在 -9999999999999 至 9999999999999 之间 </font>';}else TEXT_sellprice4.innerHTML='';\" >&nbsp;
 <span id='TEXT_sellprice4'></span></TD></TR>
<TR>
<TD class=TableData noWrap width=20%>".$html_etc[$tablename]['sellprice5'].":</TD>
<input type=hidden name='sellprice5_原始值' value=''>
<TD class=TableData noWrap colspan=\"2\"><INPUT type=\"text\" title=''
			onkeydown=\"if(event.keyCode==13)event.keyCode=9\" accesskey='8' class=\"SmallInput\"   maxLength=200 size=\"30\"
			name='sellprice5' id='sellprice5' value=\"".$fields['value']['sellprice5']."\" onkeypress=\"check_input_num('MONEY')\" onblur=\"this.value=Math.round(this.value*100)/100;if(this.value=='NaN')this.value=0;\" onchange=\"if(this.value!='' && (this.value<-9999999999999 || this.value>9999999999999)){TEXT_sellprice5.innerHTML='<font color=red>输入的值必须在 -9999999999999 至 9999999999999 之间 </font>';}else TEXT_sellprice5.innerHTML='';\" >&nbsp;
 <span id='TEXT_sellprice5'></span></TD></TR>";
}
?>
