<?php
ini_set('display_errors',1);
ini_set('error_reporting',E_ALL);
error_reporting(E_WARNING | E_ERROR);
require_once("lib.inc.php");
$GLOBAL_SESSION=returnsession();
$rowid=$_GET['rowid'];
$buyplaninfo= returntablefield("buyplanmain", "billid", $_GET['rowid'], "supplyid,totalmoney");
$supplyid=$buyplaninfo['supplyid'];
$totalmoney=$buyplaninfo['totalmoney'];
	$customerName= returntablefield( "supply", "rowid", $supplyid, "supplyname");
	$customerName="��Ӧ�̣�".$customerName;
?>
<html>
<head>
<style type="text/css" >

  <!--

  #productSel {
    width:400px;
    position:absolute;
    left:600px;
    top:100px;
    background:#EFEFFF;
    text-align:left;

  }
  #ChatHead {
	text-align:right;
    font-size:14px;
    cursor:move;
  	background:url("<?php echo ROOT_DIR?>theme/3/list_hd_bg.png");
    border:1px #b8d1e2 solid;
    font-weight:bold;
    color:#476074;
    line-height:23px;
    padding:0px;
  }
  #ChatHead a:link,#ChatHead a:visited, {
    font-size:14px;
    font-weight:bold;
    padding:3px;
  }
  #ChatBody {
    border:1px solid #003399;
    border-top:none;
    padding:2px;
  	filter:Alpha(opacity=80)
  }
  #ChatContent {
    height:200px;
    padding:6px;
    overflow-y:scroll;
    word-break: break-all
  }
  #ChatBtn {
    border-top:1px solid #003399;
    padding:2px
  }
  -->
  </style>
<LINK href="<?php echo ROOT_DIR?>theme/3/style.css" type=text/css rel=stylesheet>
<LINK href="<?php echo ROOT_DIR?>general/ERP/Enginee/jquery/jquery.autocomplete.css" type=text/css rel=stylesheet>
<script type="text/javascript" language="javascript" src="<?php echo ROOT_DIR?>general/ERP/Enginee/lib/common.js"></script>
<script type="text/javascript" language="javascript" src="<?php echo ROOT_DIR?>general/ERP/Enginee/jquery/jquery.js"></script>
<script type="text/javascript" language="javascript" src="<?php echo ROOT_DIR?>general/ERP/Enginee/jquery/jquery.autocomplete.js"></script>
<script type="text/javascript">
var oldcode=new Array();
<?php
$sql="select distinct oldproductid from product where oldproductid<>'' and supplyid=$supplyid";
$rs=$db->Execute($sql);
$rs_a=$rs->GetArray();
for($i=0;$i<sizeof($rs_a);$i++)
{
	print "oldcode[$i]='".$rs_a[$i]['oldproductid']."';\r\n";
}
?>
var backurl='buyplanmain_newai.php';

//ˢ���б�
function refreshCart() {
sendRequest('');
}

//����б�
function emptyCart(rowid) {
	if(confirm('�Ƿ�ȷ�������ϸ��'))
	sendRequest("&action=empty");
}

//ɾ���б��ڵ�����Ʒ
function delProduct(id) {
	if(confirm('�Ƿ�ȷ��ɾ�����У�'))
	sendRequest("&action=del&id=" + id);
}
//���沢����
function saveAndReturn(rowid)
{
	sendRequest("&action=Save");
}
//����
function Returnback(rowid)
{
	parent.location=backurl;

}
//���±�ע
function updateMemo(id, memo)
{
	sendRequest("&action=updateMemo&id="+id+"&beizhu=" + memo);
}
//���½��
function updateMoney(id, money)
{
	//��������У�����ʱ����
	try
	{
		money=eval(money);
	}
	catch(err)
	{
		alert(err.description);
		return false;
	}
	
	if(IsFloat(money)==false)
	{
		alert("�������Ǹ�����");
		return false;
	}
	else
	{
		sendRequest("&action=updateMoney&id="+id+"&jine=" + money);
	}
}
//�����ۿ�
function updateZhekou(id, zhekou)
{
	//��������У�����ʱ����
	try
	{
		zhekou=eval(zhekou);
	}
	catch(err)
	{
		alert(err.description);
		return false;
	}
	
	if(Number(zhekou)<0)
	{
		alert("�ۿ۲���С��0");
		return false;	
	}
	if(IsInteger(zhekou)==false)
	{
		alert("�ۿ۱���������");
		return false;
	}
	else
	{
		sendRequest("&action=updateZhekou&id="+id+"&zhekou=" + zhekou);
	}
}
//��������
function updateAmount(id, newamount)
{
	//��������У�����ʱ����
	try
	{
		newamount=eval(newamount);
	}
	catch(err)
	{
		alert(err.description);
		return false;
	}
	
	if(IsInteger(newamount)==false)
	{
		alert("��������������");
		return false;
	}
	else
	{
		sendRequest("&action=updateAmount&id="+id+"&amount=" + newamount);
	}
}
//���µ���
function updatePrice(id, newprice)
{
	//��������У�����ʱ����
	try
	{
		newprice=eval(newprice);
	}
	catch(err)
	{
		alert(err.description);
		return false;
	}
	if(Number(newprice)<0)
	{
		alert("���۲���С��0");
		return false;	
	}
	if(IsFloat(newprice)==false)
	{
		alert("���۱����Ǹ�����");
		return false;
	}
	else
	{
		sendRequest("&action=updatePrice&id="+id+"&price="+newprice);
	}
	
}
var notfocus=false;
function addnewline()
{
	var oldproductid=form1.oldproductid.value;
	if(oldproductid=='')
	{
		alert("ԭ���벻��Ϊ��");
		return false;
	}
	sendRequest("&action=add&oldproductid="+oldproductid+"&supplyid=<?php echo $supplyid?>");
	form1.oldproductid.value='';
	if(!notfocus)
		form1.oldproductid.focus();
	return false;
}

//����������Ͳ�������
var $$ = jQuery.noConflict();
function sendRequest(params) {
notfocus=false;	
$$.ajax({ 
	  type:'GET', 
	  url:'buyplanmain_mingxi_update.php?tablename=buyplanmain_detail&rowid=<?php echo $_GET['rowid']?>' + params, 
	  dataType: 'text', 
	  cache:false,
	  async: false,
	  success:function(data) 
	  { 

	  	        if(data.indexOf("<table")!=-1)
	  	        {
	  	        	shoppingcart.innerHTML = data;
	  	        	//document.getElementById("savebutton").focus();
	  	        	scrollBy(0,999999);
	  	        }
	  	        else
	  	        {
		  	        var res=data.split("|");
		    		if(res[0]=='updateAmount' || res[0]=='updatePrice' || res[0]=='updateMoney' || res[0]=='updateZhekou')
		    		{
			   			var amount=document.getElementById('num_'+res[1]);
			   			var price=document.getElementById('price_'+res[1]);
			   			var money=document.getElementById('jine_'+res[1]);
			   			var zhekou=document.getElementById('zhekou_'+res[1]);
			   			var warning=document.getElementById('warning_'+res[1]);
			   			amount.value=res[2];
			   			price.value=res[3];
			   			zhekou.value=eval(res[4])*100;
			   			money.value=Math.round(eval(res[2]*res[3]*res[4])*100)/100;
			   			var allamount=document.getElementById('allamount');
			   			var allmoney=document.getElementById('allmoney');
			   			allamount.innerHTML=res[5];
			   			allmoney.innerHTML=res[6]+" Ԫ";
			   			if(res[7]!='')
			   			{
				   			if(res[7]==1)
			   					warning.innerHTML="<img src='../../Framework/images/warning.gif' title='�ۺ�۸��ڳɱ���'>";
			   				else
			   					warning.innerHTML="";
			   			}
			   			if(res[0]=='updateAmount')
			   			{	
			   				autoFocusNextInput(amount,"form2");
			   			}
			   			else if (res[0]=='updatePrice')
			   			{
			   				autoFocusNextInput(price,"form2");
			   			}
			   			else if (res[0]=='updateZhekou')
			   			{
			   				autoFocusNextInput(zhekou,"form2");
			   			}
			   			else if (res[0]=='updateMoney')
			   			{
			   				autoFocusNextInput(money,"form2");
			   			}
			   			
			   		}	
		    		else if(res[0]=='updateMemo')
		    		{
		    			//var amount=document.getElementById('beizhu_'+res[1]);
		    			//autoFocusNextInput(amount,"form2");
		    		}
		    		else if(res[0]=='Save')
		    		{
		    			location=backurl;
		    		}
		    		else if(res[0]=='add')
		    		{
		    			var oldprodid=res[1];
		    			var supplyid=res[2];
		    			if(confirm('��Ʒ����û���ҵ��󶨴˹�Ӧ�̣�����ԭ����Ϊ'+oldprodid+'�Ĳ�Ʒ���Ƿ��½���'))
		    				OpenNewProductWindow(oldprodid,supplyid);
		    		}
		    		else
		    		{
		        		alert(data);
		        		window.location.reload();
		        	}
	  	        }
			
	  },
	  error:function(XmlHttpRequest,textStatus, errorThrown)
  	  {
		  alert('����'+errorThrown);
  	  }
});

}
$$().ready(function() {
	
	refreshCart();
	$$("#oldproductid").focus().autocomplete(oldcode);
})
function OpenNewProductWindow(oldprodid,supplyid)
{

  URL = "product_newai.php?action=add_default&oldproductid="+encodeURIComponent(oldprodid)+"&supplyid="+encodeURIComponent(supplyid);
  loc_y=loc_x=200;
  if(is_ie)
  {
     loc_x=document.body.scrollLeft+event.clientX-150;
     loc_y=document.body.scrollTop+event.clientY+50;
  }
  //LoadDialogWindow_edu(URL,self, loc_x, loc_y,500,350);
  window.open(URL,'������Ʒ','height=350,width=500,top=loc_y,left=loc_x,toolbar=no,menubar=no,scrollbars=yes,resizable=yes,location=no, status=no');
  notfocus=true;
}

</script>
</head>

<body class=bodycolor topMargin=5 >
<table id=listtable align=center class=TableBlock width=100% border=0>
<TR><TD colspan=9 class=TableHeader height=30>&nbsp;�ɹ�����ϸ¼��&nbsp;��<?php echo $customerName?>���ɹ��ܶ� <font color=red><?php echo $totalmoney?></font> Ԫ��</TD></TR>
</table>
<div id="shoppingcart">
</div>
<div id="inputarea">
<form name=form1 autocomplete="off" onsubmit="return addnewline();" encType=multipart/form-data method=post>
<table id=listtable align=center class=TableBlock width=100% >
<TR class=TableData>
<?php 


					print "<TD class=TableData noWrap align=center>�ֹ�¼��(ԭ����)��<input type=\"text\" id='oldproductid' name=\"oldproductid\" value=\"\" class='SmallInput'>\n";
					print "&nbsp;&nbsp;<input type='submit' value='���' class='SmallButton'>";
					print "</TD></TR>\n";
?>
</table>
</form>
</div>
<p align=center>
<input type=button value="����" class="SmallButton" onclick="location=backurl;">
&nbsp;&nbsp;<input type=button value="����б�" class="SmallButton" onclick="emptyCart(<?php echo $rowid?>)">
&nbsp;&nbsp;<input type=button value=" �� �� " id="savebutton" title="��ݼ�:ALT+s" accesskey="s" class="SmallButton" onclick="saveAndReturn(<?php echo $rowid?>)">

</body>
</html>
