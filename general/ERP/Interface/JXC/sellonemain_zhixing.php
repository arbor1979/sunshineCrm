<?php
ini_set('display_errors',1);
ini_set('error_reporting',E_ALL);
error_reporting(E_WARNING | E_ERROR);
require_once("lib.inc.php");
$GLOBAL_SESSION=returnsession();
$billid=$_GET['rowid'];
$goalfile = "../Framework/global_config.ini";
$ini_file = @parse_ini_file( $goalfile,true);
$maxOdd=intval($ini_file[section][maxOdd]);//最大去零
$jifenBaseNum=intval($ini_file[section][minNum]);//积分基数
$jifenToMoneyRate=doubleval($ini_file[section][changeMoney]);//积分兑换率
?>
<head>
<style>
.attention{
	
	border-top: 1pt none ;
	border-right: 1pt none;
	border-bottom: 1pt solid #000066;
	border-left: 1pt none;
	font-size:12pt;
	font-weight: bold;
	}
</style>
<?php 
print "<script type=\"text/javascript\" language=\"javascript\" src=\"".ROOT_DIR."general/ERP/Enginee/lib/common.js\"></script>";
print "<script type=\"text/javascript\" language=\"javascript\" src=\"".ROOT_DIR."general/ERP/Enginee/jquery/jquery.js\"></script>";


	global $db;
	$billinfo= returntablefield("sellplanmain", "billid", $billid, "supplyid,totalmoney,ifpay");
	$sql="select sum(num) as num,sum(round(price*zhekou,2)*num) as jine from sellplanmain_detail_tmp where mainrowid='".$billid."'";
	$rs=$db->Execute($sql);
	$rs_a=$rs->GetArray();
	$allnum=$rs_a[0]['num'];
	$allmoney=round($rs_a[0]['jine'],2);
	if($billinfo['totalmoney']!=$allmoney)
	{
		print "<script language='javascript'>alert('单据总金额:".$billinfo['totalmoney']." 与明细合计:".$allmoney." 不一致，请编辑明细时保存退出');location='sellonemain_newai.php';</script>";
		exit;
	}
	$customer= returntablefield( "customer", "rowid", $billinfo[supplyid], "supplyname,yuchuzhi,integral");
	$sql="select count(*) as ownnum,sum(totalmoney-oddment-huikuanjine) as ownmoney from sellplanmain where supplyid=".$billinfo[supplyid]." and ifpay<2 and user_flag>0 and fahuostate=-1";
	$rs=$db->Execute($sql);
	$rs_b=$rs->GetArray();
	$ownnum=intval($rs_b[0]['ownnum']);
	$ownmoney=round($rs_b[0]['ownmoney'],2);
?>

<script type="text/javascript">
var maxOdd=<?php echo $maxOdd?>;
var jifenBaseNum=<?php echo $jifenBaseNum?>;
var jifenToMoneyRate=<?php echo $jifenToMoneyRate?>;
var allmoney=<?php echo $allmoney?>;
var chongdi=0;
$(document).ready(function(){
	showorhide();
	$('#usejifen').val('');
	$('#chongdimoney').html('');

	$("input[name='ifpay']").click(function(){
		showorhide();
	});
	$("#quling").focus();
});
function showorhide()
{

if(GetRadioValue('ifpay')==1)
{
	
	 $("#divshoukuan").html('收款');
	 $("#divzhaoling").html('找零');
}
 else
 {

	 $("#divshoukuan").html('押金');
	 $("#divzhaoling").html('尚欠');
 }
$("#quling").val('');
$("#shoukuan").val('');
$("#yingshou").html('');
$("#zhaoling").html('');
}
function inputFloat(event)
{
	if (event.keyCode!=46 && event.keyCode!=45 && (event.keyCode<48 || event.keyCode>57)) 
		event.returnValue=false
}
function focusNext(event)
{
	if(event.keyCode==13)
		event.keyCode=9;
}
function funUseJifen(jifen)
{
	try
	{
		if(jifen%jifenBaseNum!=0)
		{
			throw new Error('使用积分数量必须是'+jifenBaseNum+'的倍数');
		}
		chongdi=jifen*jifenToMoneyRate;
		if(chongdi>0)
			$('#chongdimoney').html('，可冲抵金额:'+chongdi+'元');
		else
			$('#chongdimoney').html('');
		if(allmoney-chongdi<0)
		{
			throw new Error('积分冲抵额不能大于单据金额');
		}
		$("#billmoney").html(''+allmoney+'-'+chongdi+'='+(allmoney-chongdi));
	}
	catch (err)
	{
		alert(err.message);
		$('#usejifen').val('');
		$('#chongdimoney').html('');
		$("#billmoney").html(allmoney);
		chongdi=0;
		return false;
	}
	
}
function funquling(allmoney,ql)
{
	if(allmoney>0 && ql>allmoney-chongdi)
	{
		alert('去零金额不能大于总金额');
		form1.quling.focus();
		form1.quling.select();
		return false;
	}
	if(maxOdd>0 && ql>maxOdd)
	{
		alert('去零金额不能大于'+maxOdd);
		form1.quling.focus();
		form1.quling.select();
		return false;
	}
	$("#yingshou").html('<font size=+2 color=red>'+(allmoney-ql-chongdi)+'</font>');
	if(GetRadioValue('ifpay')==1)
	{
		form1.shoukuan.value=allmoney-ql-chongdi;
		$("#zhaoling").html('');
	}
}
function funshoukuan(allmoney,sk)
{
	var ql=form1.quling.value;
	var yingshou=allmoney-ql-chongdi;
	if(GetRadioValue('ifpay')==1)
	{
		if(sk>=yingshou)
		{
			$("#zhaoling").html('<font size=+2 color=red>'+Math.round((sk-yingshou)*100)/100+'</font>');
		}
		else
		{
			$("#zhaoling").html('');
			
		}
	}
	else
	{
		if(yingshou>0 && sk>yingshou)
		{
			alert('押金不能大于'+yingshou);
			form1.shoukuan.focus();
			form1.shoukuan.select();
			return false;
		}
		else
		{
			$("#zhaoling").html('<font size=+2 color=red>'+(yingshou-sk)+'</font>');
		}
	}
}
function GetRadioValue(RadioName)
{
    var obj;    
    obj=document.getElementsByName(RadioName);
    if(obj!=null){
        var i;
        for(i=0;i<obj.length;i++){
            if(obj[i].checked){
                return obj[i].value;            
            }
        }
    }
}
function submitFormCheck(allmoney)
{
	var ql=parseFloatValue(form1.quling.value);
	var sk=parseFloatValue(form1.shoukuan.value);


	if(parseFloat(form1.quling.value)>0 && parseFloat(form1.quling.value)>allmoney/10)
	{
		if(!confirm('去零金额大于总金额的十分之一，是否确认执行？'))
			return false;
	}
	
	if(GetRadioValue('ifpay')==1 && (ql+sk)<allmoney-chongdi)
	{
		alert('去零和收款之和必须等于'+(allmoney-chongdi));
		return false;
	}
	if(GetRadioValue('ifpay')==0 && (ql+sk)<allmoney-chongdi)
	{
		if(!confirm('尚欠'+parseFloatValue(allmoney-chongdi-(ql+sk))+' ,是否确认保存？'))
			return false;
	}
	var sbtn=document.getElementsByName('submit');
	for(i=0;i<sbtn.length;i++)
	{
		sbtn[i].value='提交中';
		sbtn[i].disabled=true;
	}
	return true;
}

</script>
<LINK href="<?php echo ROOT_DIR?>theme/3/style.css" type=text/css rel=stylesheet>
</head>

<body class=bodycolor topMargin=5 >
<table id=listtable align=center class=TableBlock width=80% border=0>
<TR><TD colspan=9 class=TableHeader height=30>&nbsp;店面销售单执行</TD></TR>
</table>
<div id="shoppingcart">
<form name="form1" method="post" action="sellonemain_newai.php?action=finish&billid=<?php echo $billid?>" onsubmit="return submitFormCheck(<?php echo $allmoney?>);">
<table align=center class=TableBlock width=80% border=0 id="table1" >
<tr ><td  class=TableHeader width=130>单号</td><td class=TableLine2><?php echo $billid?>
&nbsp;<a href='sellonemain_newai.php?<?php echo base64_encode("action=edit_default&billid=".$billid)?>' target='_blank'><img src="../Framework/images/edit1.gif" title='修改单据'></a>
</td></tr>
<tr ><td  class=TableHeader>客户</td><td class=TableLine2><?php echo $customer['supplyname']?></td></tr>
<tr ><td  class=TableHeader>预储值</td><td class=TableLine2><?php echo $customer['yuchuzhi']?> 元</td></tr>
<tr ><td  class=TableHeader>积分</td><td class=TableLine2><?php echo $customer['integral']?>
<?php
	if(intval($customer['integral'])>$jifenBaseNum)
		echo " (当前积分可冲抵：".intval($customer['integral']/$jifenBaseNum)*$jifenBaseNum*$jifenToMoneyRate." 元)";
?>
</td></tr>
<?php
if(intval($customer['integral'])>$jifenBaseNum && $allmoney>0)
{
	echo " <tr ><td  class=TableHeader>本次使用积分</td><td class=TableLine2>
<input type=\"text\" id=\"usejifen\" name=\"usejifen\" class=\"attention\"  size=2 onkeydown=\"focusNext(event)\" onKeyPress=\"return inputFloat(event)\" onblur=\"this.value=parseFloatValue(this.value);return funUseJifen(this.value);\">个<span id='chongdimoney'></span></td></tr>";
}
if($ownnum!=0)
	echo "<tr ><td  class=TableHeader>往日欠款</td><td class=TableLine2><a href='v_yingshoukuanhuizong_mingxi.php?iffahuo=-1&supplyid=".$billinfo[supplyid]."' target='_blank'>".$ownmoney."元（".$ownnum."笔）</a></td></tr>";
?>
<tr ><td  class=TableHeader>本单数量</td><td class=TableLine2><?php echo $allnum?></td></tr>
<tr ><td  class=TableHeader>本单金额</td><td class=TableLine2><font size=+2 color=red><span id='billmoney'><?php echo number_format($allmoney, 2, '.', ',');?></span></font>元</td></tr>
<tr ><td  class=TableHeader>是否付款</td><td class=TableLine2>
<input type="radio"  name="ifpay" value='1' checked>是
<input type="radio"  name="ifpay" value='0' >否
</td></tr>
<tr ><td  class=TableHeader>收款账户</td><td class=TableLine2><?php 
print_account_select("accountid", "", 1, 1);
?></td></tr>
<tr ><td  class=TableHeader>去零</td><td class=TableLine2>
<input type="text" id="quling" name="quling" class="attention"  onkeydown="focusNext(event)" onKeyPress="return inputFloat(event)" onblur="if(this.value=='') return false;this.value=parseFloatValue(this.value);funquling(<?php echo $allmoney?>,this.value);">
（<span id="divyingshou">应收</span>：<span id="yingshou"></span>元）</td></tr>
<tr ><td  class=TableHeader><div id="divshoukuan">收款</div></td><td class=TableLine2>
<input type="text" id="shoukuan" name="shoukuan" class="attention"  onkeydown="focusNext(event)" onKeyPress="return inputFloat(event)" onblur="this.value=parseFloatValue(this.value);funshoukuan(<?php echo $allmoney?>,this.value);" onfocus="this.select();">
（<span id="divzhaoling">找零</span>：<span id="zhaoling"></span>元）</td></tr>
</tr>

</table>
</div>
<p align=center><input type=submit name='submit' value=" 保存 " class="SmallButton" >
&nbsp;&nbsp;<input type=button value=" 返回 " class="SmallButton" onclick="location='sellonemain_newai.php';"></p>
</form>
</body>
</html>