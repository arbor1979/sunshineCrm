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

function sellonefahuo_add($fields, $i )
{

print "<script type=\"text/javascript\" language=\"javascript\" src=\"".ROOT_DIR."general/ERP/Enginee/jquery/jquery.js\"></script>";
print "<script>
$(document).ready(function(){
	 if($(\"#fahuostate\").attr('checked')==true)
		 $(\"#fahuoarea\").show();
	 else
		 $(\"#fahuoarea\").hide();
	 
	 if($(\"#kaipiaostate\").attr('checked')==true)
		 $(\"#kaipiaoarea\").show();
	 else
		 $(\"#kaipiaoarea\").hide();
		
	 $(\"#fahuostate\").click(function(){
	  	if($(this).attr('checked')==true)
	    	$(\"#fahuoarea\").slideDown('slow');
	 	else
	  		$(\"#fahuoarea\").slideUp('slow');
	 });
	  		
	  $(\"#kaipiaostate\").click(function(){
	  	if($(this).attr('checked')==true)
	    	$(\"#kaipiaoarea\").slideDown('slow');
	 	else
	  		$(\"#kaipiaoarea\").slideUp('slow');
	 });
	 
	 $(\"form\").submit(function(){
	
	    //setSubmitBtn(true);
	 	if($(\"#fahuostate\").attr('checked')==true)
	 	{
	 		if($(\"#address\").val()=='')
	 		{
	 			alert('地址不能为空');
	 			return false;
	 		}
	 		if($(\"#mobile\").val()=='')
	 		{
	 			alert('电话不能为空');
	 			return false;
	 		}
	 	}
	 	if($(\"#kaipiaostate\").attr('checked')==true)
	 	{
	 		if($(\"#fapiaoneirong\").val()=='')
	 		{
	 			alert('发票内容不能为空');
	 			return false;
	 		}
	 	}
	 	//setSubmitBtn(false);
	 	return true;
	 });
	
	  
});
</script>";
print "
<TR><TD class=TableContent noWrap>发货:</TD>
<TD class=TableContent colspan=2>
<input type='Checkbox' name='fahuostate' id='fahuostate' ".($fields['value']['fahuostate']==0?"checked":"")." value='0'>
</td></TR>
<tr><td colspan=3 class=TableData>
<div id='fahuoarea' >
<table class=TableBlock width='100%' >

<TR>
<TD class=TableData noWrap width=20%>地址:</TD>
<TD class=TableData noWrap colspan='2'><INPUT type='text' title=''
			onkeydown='if(event.keyCode==13)event.keyCode=9' accesskey='16' class='SmallInput'  maxLength=200 size='30'
			name='address' id='address' value='".$fields['value']['address']."'  >&nbsp;
必填</TD></TR>
<TR>
<TD class=TableData noWrap width=20%>电话:</TD>
<TD class=TableData noWrap colspan='2'><INPUT type='text' title=''
			onkeydown='if(event.keyCode==13)event.keyCode=9' accesskey='17' class='SmallInput'  maxLength=200 size='30'
			name='mobile' id='mobile' value='".$fields['value']['mobile']."'  >&nbsp;
必填</TD></TR>
<TR>
<TD class=TableData noWrap width=20%>发货单号:</TD>
<TD class=TableData noWrap colspan=2><INPUT type='text' title=''
			onkeydown='if(event.keyCode==13)event.keyCode=9' accesskey='10' class='SmallInput'  maxLength=200 size='30'
			name='fahuodan' value=''  >&nbsp;
</TD></TR>
<TR>
<TD class=TableData noWrap width=20%>发货运费:</TD>
<TD class=TableData noWrap colspan='2'><INPUT type='text' title=''
			onkeydown='if(event.keyCode==13)event.keyCode=9' accesskey='11' class='SmallInput'  maxLength=200 size='30'
			name='fahuoyunfei' value='' onkeypress=\"check_input_num('MONEY')\" onblur=\"this.value=Math.round(this.value*100)/100;\">&nbsp;
必须为货币格式</TD></TR>
<TR>
<TD class=TableData noWrap width=20%>运费结算:</TD><TD class=TableData noWrap colspan='2'>
";
print_select_single_select2('yunfeitype',$fields['value']['yunfeitype'],'yunfeitype', 'id', 'name');
print "</td></tr>
<TR><TD class=TableData noWrap>发货方式:</TD>
<TD class=TableData noWrap colspan='2'>";
print_select_single_select2('fahuotype',$fields['value']['fahuotype'],'fahuotype', 'id', 'name');
print "</TD></TR>

<script Language='JavaScript'>
function clear_zuiwanfahuodate()
{
  document.form1.zuiwanfahuodate.value='';
}
</script><TR><TD class=TableData noWrap width=20%>最晚发货日期:</TD>
<TD class=TableData colspan='2'><INPUT class=SmallInput maxLength=20  name=zuiwanfahuodate value='".date("Y-m-d")."' title='' onkeydown='if(event.keyCode==13)event.keyCode=9' >
<input type='button'  title=''  value='选择' class='SmallButton' onclick=\"td_calendar('../../Framework/sms_index/calendar_begin.php?datetime=zuiwanfahuodate');\" title='选择' name='button'>&nbsp;&nbsp;<input type='button'  title=''  value='清除' class='SmallButton' onClick='clear_zuiwanfahuodate()' title='清除' name='button'></TD></TR>
</table></div></td></tr>";

print "
<TR><TD class=TableContent noWrap>开票:</TD>
<TD class=TableContent colspan=2>
<input type='Checkbox' name='kaipiaostate' id='kaipiaostate' ".($fields['value']['kaipiaostate']==0?"checked":"")." value='0'>
</td></TR>
<tr><td colspan=3 class=TableData>
<div id='kaipiaoarea' >
<table class=TableBlock width='100%' >
<TR>
<TD class=TableData noWrap width=20%>发票内容:</TD>
<TD class=TableData noWrap colspan=2><INPUT type='text' title=''
			onkeydown=\"if(event.keyCode==13)event.keyCode=9\" accesskey='6' class=\"SmallInput\"  maxLength=200 size=30
			name='fapiaoneirong' id='fapiaoneirong' value='".$fields['value']['fapiaoneirong']."'  >&nbsp;
必填</TD></TR>
<TR>
<TD class=TableData noWrap width=20%>发票号:</TD>
<TD class=TableData noWrap colspan=2><INPUT type='text' title=''
			onkeydown=\"if(event.keyCode==13)event.keyCode=9\" accesskey='7' class='SmallInput'  maxLength=200 size=30
			name='fapiaono' value='".$fields['value']['fapiaono']."'  >&nbsp;
</TD></TR>
<TR><TD class=TableData noWrap>发票类型:</TD>
<TD class=TableData noWrap colspan=2>";
print_select_single_select2('fapiaotype',$fields['value']['fapiaotype'],'crm_piaoju_type', '编号', '票据类型');
print "</TD></TR></table></div></td></tr>";
}

function sellonefahuo_view($fields, $i )
{

	$Text="<TD class=TableContent noWrap>发货状态:</TD><td class=TableData colspan=2 noWrap>".returntablefield("fahuostate", "id", $fields['value']['fahuostate'], "name")."</td>";
	if($fields['value']['fahuostate']>-1)
	{
		
		$Text.="<TD class=TableContent noWrap>电话:</TD><td class=TableData colspan=2 noWrap>".$fields['value']['mobile']."</td>";
		$Text.="</tr><tr>";
		$Text.="<TD class=TableContent noWrap>地址:</TD><td class=TableData colspan=2 noWrap>".$fields['value']['address']."</td>";
		$Text.="<TD class=TableContent noWrap>发货方式:</TD><td class=TableData colspan=2 noWrap>".returntablefield("fahuotype", "id", $fields['value']['fahuotype'], "name")."</td>";
		$Text.="</tr><tr>";
		$Text.="<TD class=TableContent noWrap>发货单号:</TD><td class=TableData colspan=2 noWrap>".$fields['value']['fahuodan']."</td>";
		$Text.="<TD class=TableContent noWrap>发货运费:</TD><td class=TableData colspan=2 noWrap>".$fields['value']['fahuoyunfei']."</td>";
		$Text.="</tr><tr>";
		$Text.="<TD class=TableContent noWrap>运费结算:</TD><td class=TableData colspan=2 noWrap>".returntablefield("yunfeitype", "id", $fields['value']['yunfeitype'], "name")."</td>";
		
	}

	if($fields['value']['kaipiaostate']>-1)
	{
		$Text.="<TD class=TableContent noWrap>开票状态:</TD><td class=TableData colspan=2 noWrap>".returntablefield("kaipiaostate", "id", $fields['value']['kaipiaostate'], "name")."</td>";
		$Text.="</tr><tr>";
		$Text.="<TD class=TableContent noWrap>发票类型:</TD><td class=TableData colspan=2 noWrap>".returntablefield("crm_piaoju_type", "编号", $fields['value']['fapiaotype'], "票据类型")."</td>";
		$Text.="<TD class=TableContent noWrap>发票号:</TD><td class=TableData colspan=2 noWrap>".$fields['value']['fapiaono']."</td>";
		$Text.="</tr><tr>";
		$Text.="<TD class=TableContent noWrap>发票内容:</TD><td class=TableData colspan=5 noWrap>".$fields['value']['fapiaoneirong']."</td>";
		
	}
	else
		$Text.="<TD class=TableContent noWrap>开票状态:</TD><td class=TableData colspan=5 noWrap>".returntablefield("kaipiaostate", "id", $fields['value']['kaipiaostate'], "name")."</td>";
	return $Text;
}

function sellonefahuo_value_PRIV( $fieldvalue, $fields, $i )
{
	
}

?>
