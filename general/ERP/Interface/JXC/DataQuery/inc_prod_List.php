<?php
ini_set('display_errors',1);
ini_set('error_reporting',E_ALL);
error_reporting(E_WARNING | E_ERROR);


require_once("lib.inc.php");
$GLOBAL_SESSION=returnsession();
$deelname=$_GET['deelname'];
$tablename=$_GET['tablename'];

?>
<style type="text/css" media="all" rel="stylesheet">

  <!--
#overlay {
   
    
    display: none;
    position: absolute;
    top: 0px;
    left: 0px;
    width: 100%;
    height: 100%;
    z-index: 100; /* �˴���ͼ��Ҫ����ҳ�� */
}
  -->
  </style>
<LINK href="<?php echo ROOT_DIR?>theme/3/style.css" type=text/css rel=stylesheet>
<script type="text/javascript" language="javascript" src="<?php echo ROOT_DIR?>general/ERP/Enginee/lib/common.js"></script>
<script type="text/javascript" language="javascript" src="<?php echo ROOT_DIR?>general/ERP/Enginee/popup/js/popup.js"></script>
<script type="text/javascript" language="javascript" src="<?php echo ROOT_DIR?>general/ERP/Enginee/popup/js/popupclass.js"></script>
<script type="text/javascript" language="javascript" src="<?php echo ROOT_DIR?>general/ERP/Enginee/jquery/jquery.js"></script>
<script type="text/javascript" language="javascript" src="<?php echo ROOT_DIR?>general/ERP/Enginee/jquery/jquery.imgbox.pack.js"></script>
<LINK href="<?php echo ROOT_DIR?>general/ERP/Enginee/jquery/lanrenzhijia.css" type='text/css' rel='stylesheet'>
<script type="text/javascript">
var backurl="";
<?php
		if($tablename=="customerproduct_detail") //����
			print "backurl='../customerproduct_newai.php';";
		else if($tablename=="sellplanmain_detail") //����
			print "backurl='../sellplanmain_newai.php';";
		else if($tablename=="buyplanmain_detail")  //�ɹ�
			print "backurl='../buyplanmain_newai.php';";
		else if($tablename=="stockchangemain_detail") //ת��
			print "backurl='../stockchangemain_newai.php';";
		else if($tablename=="storecheck_detail") //����
			print "backurl='../storecheck_newai.php';";
		else if($tablename=="productzuzhuang_detail" || $tablename=="productzuzhuang2_detail" )//��װ
			print "backurl='../productzuzhuang_newai.php';";
		else if($tablename=='v_sellonedetail') //��������
			print "backurl='../sellonemain_newai.php';";
		

if($tablename=="customerproduct_detail")
{
	$customerid= returntablefield("customerproduct", "rowid", $_GET['rowid'], "�ͻ�");
	$customerInfo= returntablefield( "customer", "rowid", $customerid, "supplyname,state,minzhekou,tuihuorate");
	$customerName=$customerInfo['supplyname'];
	$custState=$customerInfo['state'];
	$minzhekou=$customerInfo['minzhekou'];
	$tuihuorate=$customerInfo['tuihuorate'];
	$custprice=returntablefield("customerlever", "rowid",$custState,"relatePrice");
	if($custprice=='')
		$custprice='sellprice';
	$pricename=returntablefield("systemlang", "tablename","product","chinese","fieldname",$custprice);
	$customerName="�ͻ���".$customerName."�����ü۸�<font color=red>$pricename</font>";
	if($tuihuorate=='')
	{
		$tuihuorate=returntablefield("customerlever", "rowid",$custState,"tuihuorate");
		$tuihuorate=intval($tuihuorate);
	}
	$_SESSION['tuihuoRate']=$tuihuorate;
	$_SESSION['custPrice']=$custprice;
	$_SESSION['minzhekou']=$minzhekou;
}
else if($tablename=="sellplanmain_detail")
{

	$customerid= returntablefield("sellplanmain", "billid", $_GET['rowid'], "supplyid");	
	$customerInfo= returntablefield( "customer", "rowid", $customerid, "supplyname,state,tuihuorate,minzhekou");
	$customerName=$customerInfo['supplyname'];
	$custState=$customerInfo['state'];
	$tuihuorate=$customerInfo['tuihuorate'];
	$minzhekou=$customerInfo['minzhekou'];
	$custprice=returntablefield("customerlever", "rowid",$custState,"relatePrice");
	if($custprice=='')
		$custprice='sellprice';
	$pricename=returntablefield("systemlang", "tablename","product","chinese","fieldname",$custprice);
	$customerName="�ͻ���".$customerName."�����ü۸�<font color=red>$pricename</font>";
	if($tuihuorate=='')
	{
		$tuihuorate=returntablefield("customerlever", "rowid",$custState,"tuihuorate");
		$tuihuorate=intval($tuihuorate);
	}
	$_SESSION['tuihuoRate']=$tuihuorate;
	$_SESSION['custPrice']=$custprice;
	$_SESSION['minzhekou']=$minzhekou;
}
else if($tablename=="buyplanmain_detail")
{
	
	$buyplaninfo= returntablefield("buyplanmain", "billid", $_GET['rowid'], "supplyid,totalmoney");
	$customerid=$buyplaninfo['supplyid'];
	$totalmoney=$buyplaninfo['totalmoney'];
	$customerName= returntablefield( "supply", "rowid", $customerid, "supplyname");
	$customerName="��Ӧ�̣�".$customerName;
}
else if($tablename=="stockchangemain_detail")
{
	$storeid= returntablefield("stockchangemain", "billid", $_GET['rowid'], "outstoreid");	
	$customerName= returntablefield( "stock", "rowid", $storeid, "name");
	$customerName="�����ֿ⣺".$customerName;
	$_SESSION['storeid']=$storeid;
}
else if($tablename=="storecheck_detail")
{
	$storeid= returntablefield("storecheck", "billid", $_GET['rowid'], "storeid");	
	$customerName= returntablefield( "stock", "rowid", $storeid, "name");
	$customerName="�̵�ֿ⣺".$customerName;
	$_SESSION[$_GET['rowid'].'_storeid']=$storeid;
}
else if($tablename=="productzuzhuang_detail")
{
	$storeid= returntablefield("productzuzhuang", "billid", $_GET['rowid'], "outstoreid");	
	$customerName= returntablefield( "stock", "rowid", $storeid, "name");
	$customerName="����ֿ⣺".$customerName;
	$_SESSION['storeid']=$storeid;
}
else if($tablename=="productzuzhuang2_detail")
{
	$storeid= returntablefield("productzuzhuang", "billid", $_GET['rowid'], "instoreid");	
	$customerName= returntablefield( "stock", "rowid", $storeid, "name");
	$totalmoney= returntablefield("productzuzhuang", "billid", $_GET['rowid'], "totalmoney");
	$customerName="���ֿ⣺".$customerName."�������ܽ��Ϊ��<font color=red>".$totalmoney."</font>Ԫ";
	$_SESSION['storeid']=$storeid;
}
else if($tablename=='v_sellonedetail')
{
	$billinfo= returntablefield("sellplanmain", "billid", $_GET['rowid'], "supplyid,user_flag");
	$customerid=$billinfo['supplyid'];
	$user_flag=$billinfo['user_flag'];
	if($user_flag!=0)
	{
		print "alert('���󣺵����Ѳ�������ʱ�������ܱ༭��ϸ');parent.location=backurl;</script>";
		exit;
	}
	$customerInfo= returntablefield( "customer", "rowid", $customerid, "supplyname,state,tuihuorate,minzhekou");
	$customerName=$customerInfo['supplyname'];
	$custState=$customerInfo['state'];
	$tuihuorate=$customerInfo['tuihuorate'];
	$minzhekou=$customerInfo['minzhekou'];
	$storeid= returntablefield("sellplanmain", "billid", $_GET['rowid'], "storeid");	
	$storeName= returntablefield( "stock", "rowid", $storeid, "name");
	$custprice=returntablefield("customerlever", "rowid",$custState,"relatePrice");
	if($custprice=='')
		$custprice='sellprice';
	$pricename=returntablefield("systemlang", "tablename","product","chinese","fieldname",$custprice);
	$customerName="�ͻ���".$customerName."���ֿ⣺".$storeName."�����ü۸�<font color=red>$pricename</font>";
	if($tuihuorate=='')
	{
		$tuihuorate=returntablefield("customerlever", "rowid",$custState,"tuihuorate");
		$tuihuorate=intval($tuihuorate);
	}
	$_SESSION['tuihuoRate']=$tuihuorate;
	$_SESSION['custPrice']=$custprice;
	$_SESSION['minzhekou']=$minzhekou;
	$_SESSION['storeid']=$storeid;
}
$rowid=$_GET['rowid'];
?>		

function createXmlHttp() {
    //����window.XMLHttpRequest�����Ƿ����ʹ�ò�ͬ�Ĵ�����ʽ
    var xmlHttp;
    if (window.XMLHttpRequest) {
       xmlHttp = new XMLHttpRequest();                  //FireFox��Opera�������֧�ֵĴ�����ʽ
    } else {
       xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");//IE�����֧�ֵĴ�����ʽ
    }
    return xmlHttp;
}
//����������Ͳ�������
function sendRequest(params) {
	
	var xmlHttp=createXmlHttp();                        //����XmlHttpRequest����
    xmlHttp.onreadystatechange =function() {showCartInfo(xmlHttp)};   
    xmlHttp.open("GET", "inc_prod_detail_update.php?tablename=<?php echo $tablename?>&rowid=<?php echo $_GET['rowid']?>&timestamp=" + new Date().getTime() + params, true);
    xmlHttp.send(null);
}
//����������Ӧ��Ϣд�빺�ﳵdiv��
function showCartInfo(xmlHttp) {
    if (xmlHttp.readyState == 4) {
        var res=xmlHttp.responseText;
        if(res.indexOf("<table")!=-1)
        {
        	shoppingcart.innerHTML = xmlHttp.responseText;
        	//document.getElementById("savebutton").focus();
        	scrollBy(0,999999);
        	hidePicList();
        }
        else
        {
            alert(xmlHttp.responseText);
            location.reload();
        }
		$(".popBigImage").imgbox({
		'speedIn'		: 0,
		'speedOut'		: 0,
		'alignment'		: 'center',
		'overlayShow'	: true,
		'allowMultiple'	: false
		});
      
    }
}
//ˢ���б�
function refreshCart(rowid) {
    sendRequest("&rowid="+rowid+"&tuihuorate=<?php echo $tuihuorate?>&storeid=<?php echo $storeid?>");
}

//����б�
function emptyCart(rowid) {
	if(confirm('�Ƿ�ȷ�������ϸ��'))
    	sendRequest("&action=empty&rowid"+rowid);
}

//ɾ���б��ڵ�����Ʒ
function delProduct(id) {
	if(confirm('�Ƿ�ȷ��ɾ�����У�'))
    	sendRequest("&action=del&id=" + id);
}
//���沢����
function saveAndReturn(rowid)
{
	var boolflag=true;
	$("img", document.forms[0]).each(function()
	{	
		var imgsrc=this.src;
		if(imgsrc.indexOf('sepangray.gif')>-1)
		{
			alert('���в�Ʒδ������ɫ����');
			boolflag=false;
			return boolflag;
		}
		
	}); 
	if(boolflag)
	{
		var sbtn=document.getElementsByName('submit');
		for(i=0;i<sbtn.length;i++)
		{
			sbtn[i].value='�ύ��';
			sbtn[i].disabled=true;
		}
	
		var xmlHttp=createXmlHttp();    
		xmlHttp.onreadystatechange = function() {submitPostCallBack(xmlHttp)};   
		var url="inc_prod_detail_update.php?tablename=<?php echo $tablename?>&action=Save"+
						 "&rowid="+rowid;
		
		xmlHttp.open("GET", url, true);   
		xmlHttp.send();
	}

}
//����
function Returnback(rowid)
{
	parent.location=backurl;

}
//���±�ע
function updateMemo(id, memo)
{
	var xmlHttp=createXmlHttp();    
	xmlHttp.onreadystatechange = function() {submitPostCallBack(xmlHttp)};   
	var url="inc_prod_detail_update.php?tablename=<?php echo $tablename?>&action=updateMemo"+
					 "&id="+id+
	                 "&beizhu=" + memo;
	xmlHttp.open("GET", url, true);   
	xmlHttp.send();
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
		var xmlHttp=createXmlHttp();    
    	xmlHttp.onreadystatechange = function() {submitPostCallBack(xmlHttp)};   
		var url="inc_prod_detail_update.php?tablename=<?php echo $tablename?>&action=updateMoney"+
    					 "&id="+id+
    	                 "&jine=" + money;
		xmlHttp.open("GET", url, true);   
		xmlHttp.send();
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
	if(IsFloat(zhekou)==false)
	{
		alert("�ۿ۱����Ǹ�����");
		return false;
	}
	else
	{
		var xmlHttp=createXmlHttp();    
    	xmlHttp.onreadystatechange = function() {submitPostCallBack(xmlHttp)};   
		var url="inc_prod_detail_update.php?tablename=<?php echo $tablename?>&action=updateZhekou"+
    					 "&id="+id+
    	                 "&zhekou=" + zhekou;
		xmlHttp.open("GET", url, true);   
		xmlHttp.send();
	}
}
//���������ۿ�
function updateZhekouAll(billid,zhekou)
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
	if(IsFloat(zhekou)==false)
	{
		alert("�ۿ۱����Ǹ�����");
		return false;
	}
	else
	{
		sendRequest("&action=updateZhekouAll&billid=" + billid+"&zhekou="+zhekou);
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
		var xmlHttp=createXmlHttp();    
    	xmlHttp.onreadystatechange = function() {submitPostCallBack(xmlHttp)};   
		var url="inc_prod_detail_update.php?tablename=<?php echo $tablename?>&action=updateAmount"+
    					 "&id="+id+
    	                 "&amount=" + newamount;
		xmlHttp.open("GET", url, true);   
		xmlHttp.send();
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
		var xmlHttp=createXmlHttp();    
    	xmlHttp.onreadystatechange = function() {submitPostCallBack(xmlHttp)};   
		var url="inc_prod_detail_update.php?tablename=<?php echo $tablename?>&action=updatePrice"+
    					 "&id="+id+
    	                 "&price=" + newprice;
		xmlHttp.open("GET", url, true);   
		xmlHttp.send();
	}
}
//ajax���ؽ��
function submitPostCallBack(xmlHttp) 
{
	
    if (xmlHttp.readyState == 4) {
        if (xmlHttp.status == 200) 
    	{
        	
    		var res=xmlHttp.responseText.split("|");
    		if(res[0]=='updateAmount' || res[0]=='updatePrice' || res[0]=='updateMoney' || res[0]=='updateZhekou')
    		{
	   			var amount=document.getElementById('num_'+res[1]);
	   			var price=document.getElementById('price_'+res[1]);
	   			var money=document.getElementById('jine_'+res[1]);
	   			var zhekou=document.getElementById('zhekou_'+res[1]);
	   			var warning=document.getElementById('warning_'+res[1]);
	   			var sellmoney=document.getElementById('sellmoney');
	   			var backmoney=document.getElementById('backmoney');
	   			var tuihuolim=document.getElementById('tuihuolim');
	   			var tuihuowarn=document.getElementById('tuihuowarn');
	   			var zengmoney=document.getElementById('zengmoney');
	   			var sellnum=document.getElementById('sellnum');
	   			var backnum=document.getElementById('backnum');
	   			var zengnum=document.getElementById('zengnum');
	   			amount.value=res[2];
	   			price.value=res[3];
	   			zhekou.value=Math.round(eval(res[4])*100*100)/100;
	   			money.value=Math.round(Math.round(eval(res[3]*res[4])*100)/100*eval(res[2])*100)/100;
	   			var allamount=document.getElementById('allamount');
	   			var allmoney=document.getElementById('allmoney');
	   			allamount.innerHTML=res[5];
	   			allmoney.innerHTML=res[6]+" Ԫ";
	   			if(sellmoney)
	   			{
	   				sellmoney.innerHTML=res[8];
	   				backmoney.innerHTML=res[9];
	   				zengmoney.innerHTML=res[10];
	   				sellnum.innerHTML=res[11];
	   				backnum.innerHTML=res[12];
	   				zengnum.innerHTML=res[13];
	   				<?php if($tuihuorate!='' && $tuihuorate>=0)
	   					echo "
	   					var tuihuojine=Math.round(parseFloat(res[8])*".$tuihuorate.")/100;
	   					tuihuolim.innerHTML=tuihuojine;
	   					if(tuihuojine<-parseFloat(res[9]))
	   						tuihuowarn.innerHTML='�˻����ܳ���'+tuihuojine+'Ԫ';
	   					else
	   						tuihuowarn.innerHTML='';";
	   				?>
	   				
	   				
	   			}
	   			if(res[7]!='')
	   			{
		   			var tablename='<?php echo $tablename?>';
		   			
		   			if(res[7]>0 && (tablename=="sellplanmain_detail" || tablename=="v_sellonedetail"))
	   					warning.innerHTML="<img src='../../../Framework/images/warning.gif' title='�ۺ�۱ȳɱ��۵�"+res[7]+"Ԫ'>";
		   			else if(res[7]<0 && (tablename=="buyplanmain_detail"))
	   					warning.innerHTML="<img src='../../../Framework/images/warning.gif' title='�ۺ�۱ȳɱ��۸�"+(-res[7])+"Ԫ'>";
		   			else
		   				warning.innerHTML="";
	   			}
	   			else
	   				warning.innerHTML="";
	   			if(res[0]=='updateAmount')
	   			{	
	   				//autoFocusNextInput(amount,"form2");
	   				focusCodeInput();
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
        		<?php 
        		if($tablename=='v_sellonedetail') 
        			echo "parent.location='../sellonemain_newai.php?action=edit_finish&billid=".$_GET['rowid']."';";
        		else
        			echo "parent.location=backurl;";
        		?>
        		hideShowLeftMenu('show');
    		}
    		else
    		{
        		
        		alert(xmlHttp.responseText);
        		window.location.reload();
        		
        	}
        }
    }
}
function PopColorInput(id,tablename)
{
	
	ShowIframe('��ɫ����','../colorinput.php?tablename='+tablename+'&id='+id,600,200);
	document.getElementById('dialogBoxClose').src="../../../Enginee/popup/js/closewin.gif";
}
function hideShowLeftMenu(val)
{
	if(val=='hide')
		parent.parent.parent.controlmenu.MENU_SWITCH=1;
	else
		parent.parent.parent.controlmenu.MENU_SWITCH=0;
	parent.parent.parent.controlmenu.panel_menu_ctrl();
}

function popPicList(treeId)
{
	$("#overlay").css({ display: "block", top:$(document).scrollTop(),height:document.body.clientHeight,width:document.body.clientWidth});
	document.body.style.overflow='hidden';
	//$("#iframe_picList").src="inc_prod_picList.php?tablename=<?php echo $tablename?>&rowid=<?php echo $_GET['rowid']?>&prodtype="+treeId;
	document.getElementById('iframe_picList').src="inc_prod_picList.php?tablename=<?php echo $tablename?>&rowid=<?php echo $_GET['rowid']?>&prodtype="+treeId;
}
function hidePicList()
{
	$("#overlay").css({ display: "none"});
	document.body.style.overflow='';
}
function showPicList()
{
	$("#overlay").css({ display: "block", top:$(document).scrollTop(),height:document.body.clientHeight,width:document.body.clientWidth});
	document.body.style.overflow='hidden';
	var src=document.getElementById('iframe_picList').src;
	if(src.indexOf('inc_prod_picList.php')==-1)
		document.getElementById('iframe_picList').src="inc_prod_picList.php?tablename=<?php echo $tablename?>&rowid=<?php echo $_GET['rowid']?>";
}
function focusLastNum()
{
	var lastInput=$("input[id^='num_']:last");
	if(lastInput!=null && lastInput!='undefinded')
		lastInput.select();
	
}
function focusCodeInput()
{
	var leftframe=window.parent.window.frames['left'].document;
	if(leftframe!=null)
	{
		if(leftframe.getElementById('btn').value=='�ر���������')
		{
			leftframe.getElementById('inputcode').select();
		}
	}
	
}
function ajaxFileUpload()
{
   if($("#uploadfileXLS").val()=='')
   {
	    alert('��ѡ��Ҫ�ϴ����ļ�');
	    return;
   }
   $("#showerror").html('');
   loading("#btnimport","ִ����","����");
   $.ajaxFileUpload({
       url:'../storecheck_detail_newai.php?action=import_default_data&foreignkey=mainrowid&foreignvalue=<?php echo $_GET['rowid']?>&rand='+Math.random(), 
       secureuri:false,
       fileElementId:'uploadfileXLS',
  	 async:false,
  	 dataType:'text', 
       success: function (data)
       {
           if(data.indexOf('�������ݳɹ�')==-1)
           {
               $("#showerror").html(data);
           }
           refreshCart(<?php echo $rowid?>);

       },	
			error: function (data, status, e){ 
				$("#showerror").html(data);
 		} 
});
   
} 
function loading(id,beforetitle,endtitle){ 
	$(id).ajaxStart(function(){ 
		$(this).val(beforetitle);
		$(this).attr('disabled',true);
	}).ajaxComplete(function(){ 
		$(this).val(endtitle);
		$(this).attr('disabled',false);
	}); 
} 
</script>
<script type="text/javascript" language="javascript" src="<?php echo ROOT_DIR?>general/ERP/Enginee/jquery/ajaxfileupload.js"></script>
</head>

<body class=bodycolor topMargin=5 onload="refreshCart(<?php echo $rowid?>);" >
<table id=listtable align=center class=TableBlock width=100% border=0>
<TR><TD colspan=9 class=TableHeader height=30>&nbsp;<?php echo $deelname?>&nbsp;��<?php echo $customerName;?>��</TD></TR>
</table>
<div id="shoppingcart">
</div>
<p align=center>
<input type=button value="ͼƬѡ���� " class="SmallButton" onclick="showPicList();">
&nbsp;&nbsp;<input type=button value=" �� �� " class="SmallButton" onclick="parent.location=backurl;hideShowLeftMenu('show');">
&nbsp;&nbsp;<input type=button value="����б�" class="SmallButton" onclick="emptyCart(<?php echo $rowid?>)">
&nbsp;&nbsp;<input type=button name='submit' value=" �� �� " id="savebutton" title="��ݼ�:ALT+s" accesskey="s" class="SmallButton" onclick="saveAndReturn(<?php echo $rowid?>)">

<?php 
if($tablename=="storecheck_detail")
{
$filepath_system="../Model/storecheck_detail_newai.ini";
if(file_exists($filepath_system))	
	$file_ini=parse_ini_file($filepath_system,true);
$showlistfieldlist=$file_ini['export_default']['showlistfieldlist'];
?>
<div id="inputarea" align="center">
��������(Excel):<input name='uploadfileXLS' id='uploadfileXLS' type=file size=25 class=SmallInput>
<input type='button' id='btnimport' value='����' class='SmallButton' onclick='ajaxFileUpload()'>&nbsp;<a href="../storecheck_detail_newai.php?action=export_default_data&exportfield=<?php echo $showlistfieldlist?>&tablename=storecheck_detail&searchfield=1&searchvalue=0">����ģ��</a>
</div>
<?php 
}
?>
<div id="showerror"></div>
<div id="overlay"><iframe id='iframe_picList' src='' width=100% height=100% frameborder="no" width=100% marginwidth="0" marginheight="0" scrolling="auto"></iframe>
</div>
</body>
</html>