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

function ifkucun_add($fields, $i )
{

print "<script type=\"text/javascript\" language=\"javascript\" src=\"".ROOT_DIR."general/ERP/Enginee/jquery/jquery.js\"></script>";
print "<script>
var $$ = jQuery.noConflict();
$$(document).ready(function(){
	 if($$(\"#ifkucun\").attr('checked')==true)
		 $$(\"#kucunarea\").show();
	 else
		 $$(\"#kucunarea\").hide();
	 
	
		
	 $$(\"#ifkucun\").click(function(){
	  	if($$(this).attr('checked')==true)
	  	{
	    	$$(\"#kucunarea\").slideDown();
	    }
	 	else
	 	{
	  		$$(\"#kucunarea\").slideUp();
	  	}
	 });
	  		

	 $$(\"form\").submit(function(){
	 	if($$(\"#ifkucun\").attr('checked')==false)
	    	$$(\"#ifkucunvalue\").val('否');
	    else
	    	$$(\"#ifkucunvalue\").val('是');
	

	    if($$(\"#ifkucun\").attr('checked')==true)
	 	{
	 		if($$(\"#storemax\").val()!='' && $$(\"#storemin\").val()!='' && $$(\"#storemax\").val()<$$(\"#storemin\").val())
	 		{
	 			alert('库存上限不能小于库存下限');
	 			setSubmitBtn(true);
	 			return false;
	 			
	 		}
	 		
	 	}
	 	return true;
	 });
	
	  
});
</script>";
global $html_etc,$tablename;
print "
<TR><TD class=TableContent noWrap>".$html_etc[$tablename]['ifkucun'].":</TD>
<TD class=TableContent colspan=2>
<input type='hidden' name='ifkucun' id='ifkucunvalue' value='".$fields['value']['ifkucun']."'>
<input type='Checkbox' id='ifkucun' ".($fields['value']['ifkucun']!="否"?"checked":"")." value='是'>
</td></TR>
<tr><td colspan=3 class=TableData>
<div id='kucunarea' >
<table class=TableBlock width='100%' >
<TR><TD class=TableData noWrap>".$html_etc[$tablename]['hascolor'].":</TD>
<TD class=TableData colspan='2'>
<p>
<label>
<input type=hidden name='hascolor_原始值' value='否'>
<input type='radio' name='hascolor' value='否' ".($fields['value']['hascolor']!="是"?"checked":"")." >否</label>
<input type='radio' name='hascolor' value='是' ".($fields['value']['hascolor']=="是"?"checked":"").">是</label>
</p>
</TD></TR>
<TR>
<TD class=TableData noWrap width=20%>".$html_etc[$tablename]['storemin'].":</TD>
<input type=hidden name='storemin_原始值' value=''>
<TD class=TableData noWrap colspan='2'><INPUT type='text' title=''
			onkeydown='if(event.keyCode==13)event.keyCode=9' accesskey='13' class='SmallInput'   maxLength=200 size='30'
			name='storemin' id='storemin' value='".$fields['value']['storemin']."' style='ime-mode:disabled' onKeyPress='if (event.keyCode!=46 && event.keyCode!=45 && (event.keyCode<48 || event.keyCode>57)) event.returnValue=false'  onBlur='if (event.keyCode!=46 && event.keyCode!=45 && (event.keyCode<48 || event.keyCode>57)) event.returnValue=false' onpaste='return false' onchange=\"if(this.value!='' && (this.value<-9999999999999 || this.value>9999999999999)){TEXT_storemin.innerHTML='<font color=red>输入的值必须在-9999999999999- </font>';}else TEXT_storemin.innerHTML='';\" >&nbsp;
 <span id='TEXT_storemin'></span></TD></TR>
<TR>
<TD class=TableData noWrap width=20%>".$html_etc[$tablename]['storemax'].":</TD>
<input type=hidden name='storemax_原始值' value=''>
<TD class=TableData noWrap colspan='2'><INPUT type='text' title=''
			onkeydown='if(event.keyCode==13)event.keyCode=9' accesskey='14' class='SmallInput'   maxLength=200 size='30'
			name='storemax' id='storemax' value='".$fields['value']['storemax']."' style='ime-mode:disabled' onKeyPress='if (event.keyCode!=46 && event.keyCode!=45 && (event.keyCode<48 || event.keyCode>57)) event.returnValue=false'  onBlur='if (event.keyCode!=46 && event.keyCode!=45 && (event.keyCode<48 || event.keyCode>57)) event.returnValue=false' onpaste='return false' onchange=\"if(this.value!='' && (this.value<-9999999999999 || this.value>9999999999999)){TEXT_storemax.innerHTML='<font color=red>输入的值必须在-9999999999999- </font>';}else TEXT_storemax.innerHTML='';\" >&nbsp;
 <span id='TEXT_storemax'></span></TD></TR>";
print "</table></div>";
}
?>
