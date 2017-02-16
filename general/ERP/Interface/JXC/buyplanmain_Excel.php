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
	$customerName="供应商：".$customerName;

$gongshi=returntablefield("unit","id",$_SESSION['deptid'],"dingjiagongshi");
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
<script type="text/javascript" language="javascript" src="<?php echo ROOT_DIR?>general/ERP/Enginee/jquery/ajaxfileupload.js"></script>
<script type="text/javascript" language="javascript" src="<?php echo ROOT_DIR?>general/ERP/Enginee/popup/js/popup.js"></script>
<script type="text/javascript" language="javascript" src="<?php echo ROOT_DIR?>general/ERP/Enginee/popup/js/popupclass.js"></script>
<script type="text/javascript">
var gongshi='<?php echo $gongshi?>';
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

//刷新列表
function refreshCart() {
sendRequest('');
}

//清空列表
function emptyCart(rowid) {
	if(confirm('是否确认清空明细？'))
	sendRequest("&action=empty");
}

//删除列表内单件产品
function delProduct(id) {
	if(confirm('是否确认删除本行？'))
	sendRequest("&action=del&id=" + id);
}
//保存并返回
function saveAndReturn(rowid)
{
	sendRequest("&action=SaveExcel");
}
//返回
function Returnback(rowid)
{
	parent.location=backurl;

}
//更新备注
function updateMemo(id, memo)
{
	sendRequest("&action=updateMemo&id="+id+"&beizhu=" + memo);
}
//更新金额
function updateMoney(id, money)
{
	//用于数据校验的临时对象
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
		alert("金额必须是浮点数");
		return false;
	}
	else
	{
		sendRequest("&action=updateMoney&id="+id+"&jine=" + money);
	}
}
//更新折扣
function updateZhekou(id, zhekou)
{
	//用于数据校验的临时对象
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
		alert("折扣不能小于0");
		return false;	
	}
	if(IsInteger(zhekou)==false)
	{
		alert("折扣必须是整数");
		return false;
	}
	else
	{
		sendRequest("&action=updateZhekou&id="+id+"&zhekou=" + zhekou);
	}
}
//更新数量
function updateAmount(id, newamount)
{
	//用于数据校验的临时对象
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
		alert("数量必须是整数");
		return false;
	}
	else
	{
		sendRequest("&action=updateAmount&id="+id+"&amount=" + newamount);
	}
}
//更新单价
function updatePrice(id, newprice)
{
	//用于数据校验的临时对象
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
		alert("单价不能小于0");
		return false;	
	}
	if(IsFloat(newprice)==false)
	{
		alert("单价必须是浮点数");
		return false;
	}
	else
	{
		sendRequest("&action=updatePrice&id="+id+"&price="+newprice);
	}
	
}
//更新单价
function updateSellPrice(id, newprice,fid)
{
	//用于数据校验的临时对象
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
		alert("单价不能小于0");
		return false;	
	}
	if(IsFloat(newprice)==false)
	{
		alert("单价必须是浮点数");
		return false;
	}
	else
	{
		sendRequest("&action=updateSellPrice&id="+id+"&price="+newprice+"&fid="+fid);
	}
	
}
function addnewline()
{
	var oldproductid=form1.oldproductid.value;
	if(oldproductid=='')
	{
		alert("原厂码不能为空");
		return false;
	}
	sendRequest("&action=add&oldproductid="+oldproductid+"&supplyid=<?php echo $supplyid?>");
	form1.oldproductid.value='';
	form1.oldproductid.focus();
	return false;
}

//向服务器发送操作请求
var $$ = jQuery.noConflict();
function sendRequest(params) {
	
$$.ajax({ 
	  type:'GET', 
	  url:'buyplanmain_mingxi_update.php?tablename=buyplanmain_mingxi&rowid=<?php echo $_GET['rowid']?>' + params, 
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
			   			allmoney.innerHTML=res[6]+" 元";
			   			if(res[7]!='')
			   			{
				   			if(res[7]==1)
			   					warning.innerHTML="<img src='../../Framework/images/warning.gif' title='折后价高于成本价'>";
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
		    		else if(res[0]=='updateMemo' || res[0]=='updateSellPrice')
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
		    			if(confirm('不存在此产品，是否新建？'))
		    				OpenNewProductWindow(oldprodid,supplyid);
		    		}
		    		else
		    		{
		        		alert('错误:'+data);
		        		window.location.reload();
		        	}
		    		
	  	        }
			
	  },
	  error:function(XmlHttpRequest,textStatus, errorThrown)
  	  {
		  alert('出错：'+errorThrown);
  	  }
});

}
$$().ready(function() {
	
	refreshCart();
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
  window.open(URL,'新增产品','height=350,width=500,top=loc_y,left=loc_x,toolbar=no,menubar=no,scrollbars=auto,resizable=no,location=no, status=no');
}

function ajaxFileUpload()
{
	
   loading("#btnimport","执行中","导入");
   $$.ajaxFileUpload({
             url:'buyplanmain_mingxi_newai.php?action=import_default_data&foreignkey=mainrowid&foreignvalue=<?php echo $rowid?>', 
             secureuri:false,
             fileElementId:'uploadfileXLS',
        	 async:false,
        	 dataType:'text', 
             success: function (data)
             {
                if(data.indexOf('error')!=-1)
                {
					alert(data);
				}
            	if(data.indexOf('导入失败记录')!=-1)
                { 
					if(confirm('有失败记录，是否下载查看?'))
						DownLoad('FileCache/导入失败记录.xls');

            	 } 
            	 refreshCart();

             },	
   			error: function (data, status, e){ 
	   			alert(e); 
	   		} 
    });
   
} 
function DownLoad(strUrl) { 
            var form = $$("<form>");   //定义一个form表单
            form.attr('style', 'display:none');   //在form表单中添加查询参数
            form.attr('target', '');
            form.attr('method', 'get');
            form.attr('action', strUrl);
            $$('body').append(form);  //将表单放置在web中 
            form.submit();

         }
function loading(id,beforetitle,endtitle){ 
	$$(id).ajaxStart(function(){ 
		$$(this).val(beforetitle);
		$$(this).attr('disabled',true);
	}).ajaxComplete(function(){ 
		$$(this).val(endtitle);
		$$(this).attr('disabled',false);
	}); 
} 
function CountTest()
{
	gongshi=$$('#gongnshi').val();
	var gongshival=gongshi.replace(/a1/g,$$('#it_caigou').val());
	var m=Math.round(eval(gongshival)*100)/100;
	$$('#example').html('<font color=red>'+m+'</font>');
}
function AutoDingJia()
{
	//Math.ceil(a1/0.7*2-0.2)/2
	loading("#btndingjia"," 确定 ","执行中");
	sendRequest("&action=autodingjia&gongshi="+$$('#gongnshi').val());
	pop.close();
}
function PopDingJia()
{
	if(gongshi=='')
		gongshi='a1/0.7';
	
	var htmlstr="<br><blockquote>请输入定价公式：<input type='text' id='gongnshi' size=30 class='SmallInput' value='"+gongshi+"' onchange='CountTest()'>"+
	"<br>(说明：用a1代表采购价，确定后系统会用采购价替换a1，算出对应的零售价)<br>例如：a1=<input type='text' id='it_caigou' size='5' value='5' onchange='CountTest()'>,零售价为：<span id='example'>___</span><blockquote>"+
	"<p align=center><input class='SmallButton' id='btndingjia' type='button' value=' 确定 ' onclick='AutoDingJia()'></p>";
	ShowHtmlString('自动定价',htmlstr,400,200);
}
function AutoCreateNewProduct()
{
	sendRequest("&action=autocreateproduct");
}

</script>
</head>

<body class=bodycolor topMargin=5 >
<table id=listtable align=center class=TableBlock width=100% border=0>
<TR><TD  class=TableHeader height=30>&nbsp;采购单明细录入&nbsp;（<?php echo $customerName?>）</TD></TR>
</table>
<div id="shoppingcart">
</div>
<div id="inputarea">
<form name=form1 action="buyplanmain_mingxi_newai.php?action=import_default_data" encType=multipart/form-data method=post>
<table id=listtable align=center class=TableBlock width=100% >
<TR class=TableData>
<?php 
$filepath_system="Model/buyplanmain_mingxi_newai.ini";
if(file_exists($filepath_system))	
	$file_ini=parse_ini_file($filepath_system,true);
$showlistfieldlist=$file_ini['export_default']['showlistfieldlist'];
?>
<TD noWrap align=middle width=50%>批量导入(Excel):<input name='uploadfileXLS' id='uploadfileXLS' type=file size=25 class=SmallInput>
<input type='button' id='btnimport' value='导入' class='SmallButton' onclick='ajaxFileUpload()'>&nbsp;<a href="buyplanmain_mingxi_newai.php?action=export_default_data&exportfield=<?php echo $showlistfieldlist?>&tablename=buyplanmain_mingxi&searchfield=1&searchvalue=0">下载模版</a></TD>

</table>
</form>
</div>
<p align=center>
<input type=button value="返回" class="SmallButton" onclick="location=backurl;">
&nbsp;&nbsp;<input type=button value="清空列表" class="SmallButton" onclick="emptyCart(<?php echo $rowid?>)">
&nbsp;&nbsp;<input type=button id="btncreateprod" value="自动创建新品" class="SmallButton" onclick="AutoCreateNewProduct()">
&nbsp;&nbsp;<input type=button value=" 保 存 " id="savebutton" title="快捷键:ALT+s" accesskey="s" class="SmallButton" onclick="saveAndReturn(<?php echo $rowid?>)">

</body>
</html>
