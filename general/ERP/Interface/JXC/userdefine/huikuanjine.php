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

function huikuanjine_add( $fields, $i)
{
	global $db,$_SESSION,$common_html;
$notnull=trim($fields['null'][$i]['inputtype']);
$notnull=='notnull'?$notnulltext=$common_html['common_html']['mustinput']:$notnulltext='';

$fieldname1=$fields['name'][$i];
$fieldname2=$fields['input'][$i][0];
$oper=$fields['input'][$i][1];

$opername="回款";
if($oper=="1")
	$opername="付款";

$class = "SmallSelect";
print "<script language=javascript>	


function shurujine(obj)
{
	var yingshou=parseFloat(delFormat(totalmoney))-parseFloat(delFormat(huikuanjine))-parseFloat(delFormat(quling));
	if(yingshou>0 && parseFloat(form1.$fieldname1.value)+parseFloat(form1.$fieldname2.value)>yingshou)
	{
		obj.focus();
		obj.select();
		alert('本次".$opername."和去零金额合计不得超过'+yingshou);
	}
	if(yingshou<0 && parseFloat(form1.$fieldname1.value)+parseFloat(form1.$fieldname2.value)<yingshou)
	{
		obj.focus();
		obj.select();
		alert('本次".$opername."和去零金额合计不得小于'+yingshou);
	}
	document.getElementById('shangqian').innerText=Math.round((yingshou-parseFloat(form1.$fieldname1.value)-parseFloat(form1.$fieldname2.value))*100)/100;
}

</SCRIPT>\n";


print "<TR><TD class=TableData noWrap>本次".$opername."金额:</TD><TD class=TableData noWrap colspan=2>
<INPUT type='text' title='' onkeydown='if(event.keyCode==13)event.keyCode=9' class='SmallInput'  maxLength=10 
			name='$fieldname1' value='".$fields['value'][$i][$fieldname1]."' onkeypress=\"check_input_num('MONEY')\" onchange='this.value=Math.round(this.value*100)/100;shurujine(this);'>&nbsp;
$notnulltext && 必须为货币格式</TD></TR>\n";

print "<TR><TD class=TableData noWrap>本次去零:</TD><TD class=TableData noWrap colspan=2>
<INPUT type='text' title='' onkeydown='if(event.keyCode==13)event.keyCode=9' class='SmallInput'  maxLength=10 
			name='$fieldname2' value='".$fields['value'][$i][$fieldname2]."' onkeypress=\"check_input_num('MONEY')\" onchange='this.value=Math.round(this.value*100)/100;shurujine(this);'>&nbsp;
			必须为货币格式</TD></TR>\n";

print "<TR><TD class=TableData noWrap>尚欠:</TD><TD class=TableData noWrap colspan=2>
<div id='shangqian'></div></TD></TR>\n";
			
}

?>
