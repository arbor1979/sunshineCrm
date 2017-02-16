<?php
ini_set('display_errors',1);
ini_set('error_reporting',E_ALL);
error_reporting(E_WARNING | E_ERROR);
require_once("lib.inc.php");
$GLOBAL_SESSION=returnsession();
$rowid=$_GET['rowid'];

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

var backurl='sellplanmain_newai.php';

//刷新列表
function refreshCart() {
sendRequest('');
}

//清空列表
function emptyCart(rowid) {
	if(confirm('是否确认清空明细？'))
	sendRequest("&action=empty");
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

//向服务器发送操作请求
var $$ = jQuery.noConflict();
function sendRequest(params) {
	
$$.ajax({ 
	  type:'GET', 
	  url:'sellplanmain_mingxi_update.php?tablename=sellplanmain_mingxi&rowid=<?php echo $_GET['rowid']?>' + params, 
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
		    		else if(res[0]=='Save')
		    		{
		    			location=backurl;
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
                 
            	if(data.substring(0,5)== 'error')
                { 
            		 alert(data.substring(5)); 
            	 } 
            	 refreshCart();

             },	
   			error: function (data, status, e){ 
	   			alert(e); 
	   		} 
    });
   
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
<TR><TD  class=TableHeader height=30>&nbsp;订单明细录入</TD></TR>
</table>
<div id="shoppingcart">
</div>
<div id="inputarea">
<form name=form1 action="sellplanmain_mingxi_newai.php?action=import_default_data" encType=multipart/form-data method=post>
<table id=listtable align=center class=TableBlock width=100% >
<TR class=TableData>
<?php 
$filepath_system="Model/sellplanmain_mingxi_newai.ini";
if(file_exists($filepath_system))	
	$file_ini=parse_ini_file($filepath_system,true);
$showlistfieldlist=$file_ini['export_default']['showlistfieldlist'];
?>
<TD noWrap align=middle width=50%>批量导入(Excel):<input name='uploadfileXLS' id='uploadfileXLS' type=file size=25 class=SmallInput>
<input type='button' id='btnimport' value='导入' class='SmallButton' onclick='ajaxFileUpload()'>&nbsp;<a href="sellplanmain_mingxi_newai.php?action=export_default_data&exportfield=<?php echo $showlistfieldlist?>&tablename=sellplanmain_mingxi&searchfield=1&searchvalue=0">下载模版</a></TD>

</table>
</form>
</div>
<p align=center>
<input type=button value="返回" class="SmallButton" onclick="location=backurl;">
&nbsp;&nbsp;<input type=button value="清空列表" class="SmallButton" onclick="emptyCart(<?php echo $rowid?>)">
&nbsp;&nbsp;<input type=button value=" 保 存 " id="savebutton" title="快捷键:ALT+s" accesskey="s" class="SmallButton" onclick="saveAndReturn(<?php echo $rowid?>)">

</body>
</html>
