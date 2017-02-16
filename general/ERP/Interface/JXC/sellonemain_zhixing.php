<?php
ini_set('display_errors',1);
ini_set('error_reporting',E_ALL);
error_reporting(E_WARNING | E_ERROR);
require_once("lib.inc.php");
$GLOBAL_SESSION=returnsession();
$billid=$_GET['rowid'];
$goalfile = "../Framework/global_config.ini";
$ini_file = @parse_ini_file( $goalfile,true);
$maxOdd=intval($ini_file[section][maxOdd]);//���ȥ��
$jifenBaseNum=intval($ini_file[section][minNum]);//���ֻ���
$jifenToMoneyRate=doubleval($ini_file[section][changeMoney]);//���ֶһ���
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
		print "<script language='javascript'>alert('�����ܽ��:".$billinfo['totalmoney']." ����ϸ�ϼ�:".$allmoney." ��һ�£���༭��ϸʱ�����˳�');location='sellonemain_newai.php';</script>";
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
	
	 $("#divshoukuan").html('�տ�');
	 $("#divzhaoling").html('����');
}
 else
 {

	 $("#divshoukuan").html('Ѻ��');
	 $("#divzhaoling").html('��Ƿ');
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
			throw new Error('ʹ�û�������������'+jifenBaseNum+'�ı���');
		}
		chongdi=jifen*jifenToMoneyRate;
		if(chongdi>0)
			$('#chongdimoney').html('���ɳ�ֽ��:'+chongdi+'Ԫ');
		else
			$('#chongdimoney').html('');
		if(allmoney-chongdi<0)
		{
			throw new Error('���ֳ�ֶ�ܴ��ڵ��ݽ��');
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
		alert('ȥ����ܴ����ܽ��');
		form1.quling.focus();
		form1.quling.select();
		return false;
	}
	if(maxOdd>0 && ql>maxOdd)
	{
		alert('ȥ����ܴ���'+maxOdd);
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
			alert('Ѻ���ܴ���'+yingshou);
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
		if(!confirm('ȥ��������ܽ���ʮ��֮һ���Ƿ�ȷ��ִ�У�'))
			return false;
	}
	
	if(GetRadioValue('ifpay')==1 && (ql+sk)<allmoney-chongdi)
	{
		alert('ȥ����տ�֮�ͱ������'+(allmoney-chongdi));
		return false;
	}
	if(GetRadioValue('ifpay')==0 && (ql+sk)<allmoney-chongdi)
	{
		if(!confirm('��Ƿ'+parseFloatValue(allmoney-chongdi-(ql+sk))+' ,�Ƿ�ȷ�ϱ��棿'))
			return false;
	}
	var sbtn=document.getElementsByName('submit');
	for(i=0;i<sbtn.length;i++)
	{
		sbtn[i].value='�ύ��';
		sbtn[i].disabled=true;
	}
	return true;
}

</script>
<LINK href="<?php echo ROOT_DIR?>theme/3/style.css" type=text/css rel=stylesheet>
</head>

<body class=bodycolor topMargin=5 >
<table id=listtable align=center class=TableBlock width=80% border=0>
<TR><TD colspan=9 class=TableHeader height=30>&nbsp;�������۵�ִ��</TD></TR>
</table>
<div id="shoppingcart">
<form name="form1" method="post" action="sellonemain_newai.php?action=finish&billid=<?php echo $billid?>" onsubmit="return submitFormCheck(<?php echo $allmoney?>);">
<table align=center class=TableBlock width=80% border=0 id="table1" >
<tr ><td  class=TableHeader width=130>����</td><td class=TableLine2><?php echo $billid?>
&nbsp;<a href='sellonemain_newai.php?<?php echo base64_encode("action=edit_default&billid=".$billid)?>' target='_blank'><img src="../Framework/images/edit1.gif" title='�޸ĵ���'></a>
</td></tr>
<tr ><td  class=TableHeader>�ͻ�</td><td class=TableLine2><?php echo $customer['supplyname']?></td></tr>
<tr ><td  class=TableHeader>Ԥ��ֵ</td><td class=TableLine2><?php echo $customer['yuchuzhi']?> Ԫ</td></tr>
<tr ><td  class=TableHeader>����</td><td class=TableLine2><?php echo $customer['integral']?>
<?php
	if(intval($customer['integral'])>$jifenBaseNum)
		echo " (��ǰ���ֿɳ�֣�".intval($customer['integral']/$jifenBaseNum)*$jifenBaseNum*$jifenToMoneyRate." Ԫ)";
?>
</td></tr>
<?php
if(intval($customer['integral'])>$jifenBaseNum && $allmoney>0)
{
	echo " <tr ><td  class=TableHeader>����ʹ�û���</td><td class=TableLine2>
<input type=\"text\" id=\"usejifen\" name=\"usejifen\" class=\"attention\"  size=2 onkeydown=\"focusNext(event)\" onKeyPress=\"return inputFloat(event)\" onblur=\"this.value=parseFloatValue(this.value);return funUseJifen(this.value);\">��<span id='chongdimoney'></span></td></tr>";
}
if($ownnum!=0)
	echo "<tr ><td  class=TableHeader>����Ƿ��</td><td class=TableLine2><a href='v_yingshoukuanhuizong_mingxi.php?iffahuo=-1&supplyid=".$billinfo[supplyid]."' target='_blank'>".$ownmoney."Ԫ��".$ownnum."�ʣ�</a></td></tr>";
?>
<tr ><td  class=TableHeader>��������</td><td class=TableLine2><?php echo $allnum?></td></tr>
<tr ><td  class=TableHeader>�������</td><td class=TableLine2><font size=+2 color=red><span id='billmoney'><?php echo number_format($allmoney, 2, '.', ',');?></span></font>Ԫ</td></tr>
<tr ><td  class=TableHeader>�Ƿ񸶿�</td><td class=TableLine2>
<input type="radio"  name="ifpay" value='1' checked>��
<input type="radio"  name="ifpay" value='0' >��
</td></tr>
<tr ><td  class=TableHeader>�տ��˻�</td><td class=TableLine2><?php 
print_account_select("accountid", "", 1, 1);
?></td></tr>
<tr ><td  class=TableHeader>ȥ��</td><td class=TableLine2>
<input type="text" id="quling" name="quling" class="attention"  onkeydown="focusNext(event)" onKeyPress="return inputFloat(event)" onblur="if(this.value=='') return false;this.value=parseFloatValue(this.value);funquling(<?php echo $allmoney?>,this.value);">
��<span id="divyingshou">Ӧ��</span>��<span id="yingshou"></span>Ԫ��</td></tr>
<tr ><td  class=TableHeader><div id="divshoukuan">�տ�</div></td><td class=TableLine2>
<input type="text" id="shoukuan" name="shoukuan" class="attention"  onkeydown="focusNext(event)" onKeyPress="return inputFloat(event)" onblur="this.value=parseFloatValue(this.value);funshoukuan(<?php echo $allmoney?>,this.value);" onfocus="this.select();">
��<span id="divzhaoling">����</span>��<span id="zhaoling"></span>Ԫ��</td></tr>
</tr>

</table>
</div>
<p align=center><input type=submit name='submit' value=" ���� " class="SmallButton" >
&nbsp;&nbsp;<input type=button value=" ���� " class="SmallButton" onclick="location='sellonemain_newai.php';"></p>
</form>
</body>
</html>