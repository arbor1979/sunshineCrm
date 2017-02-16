<?php
	ini_set('display_errors', 1);
	ini_set('error_reporting', E_ALL);
	error_reporting(E_WARNING | E_ERROR);
	require_once('lib.inc.php');
	$GLOBAL_SESSION=returnsession();
	validateMenuPriv("手机短信");
	addShortCutByDate("nowtime","提交时间");
	$SYSTEM_ADD_SQL =$SYSTEM_ADD_SQL =getRoleByUser($SYSTEM_ADD_SQL,"userid");
	
	//数据表模型文件,对应Model目录下面的sms_sendlist_newai.ini文件
	//如果是需要复制此模块,则需要修改$parse_filename参数的值,然后对应到Model目录 新文件名_newai.ini文件
	$filetablename		=	'sms_sendlist';
	$parse_filename		=	'sms_sendlist';
	require_once('include.inc.php');
	
	if($_GET['action']=="add_default")
	{		
		$sendlist=$_GET['sendlist'];
		$sendlistarray=explode(",", $sendlist);
		$textareaInitValue="";
		for($i=0;$i<count($sendlistarray);$i++)
		{
			if($sendlistarray[$i]=='')
				continue;
			if($_GET['fromsrc']=='user')
			{
				$linkman=returntablefield("user", "UID", $sendlistarray[$i], "MOBIL_NO,USER_NAME");
				if($linkman['MOBIL_NO']!='')
				{
				if($textareaInitValue=='')
					$textareaInitValue=$linkman['MOBIL_NO']." ".$linkman['USER_NAME'];
				else
					$textareaInitValue=$textareaInitValue."\\n".$linkman['MOBIL_NO']." ".$linkman['USER_NAME'];
				}
			}
			else if($_GET['fromsrc']=='supply')
			{
				$linkman=returntablefield("supplylinkman", "rowid", $sendlistarray[$i], "phone,supplyname");
				if($linkman['phone']!='')
				{
				if($textareaInitValue=='')
					$textareaInitValue=$linkman['phone']." ".$linkman['supplyname'];
				else
					$textareaInitValue=$textareaInitValue."\\n".$linkman['phone']." ".$linkman['supplyname'];
				}
			}
			else  if($_GET['fromsrc']=='customer')
			{
				$linkman=returntablefield("linkman", "rowid", $sendlistarray[$i], "mobile,linkmanname");
				if($linkman['mobile']!='')
				{
				if($textareaInitValue=='')
					$textareaInitValue=$linkman['mobile']." ".$linkman['linkmanname'];
				else
					$textareaInitValue=$textareaInitValue."\\n".$linkman['mobile']." ".$linkman['linkmanname'];
				}
			}
			else
			{
				$linkmanname=returntablefield("linkman", "mobile", $sendlistarray[$i], "linkmanname");
				if($linkmanname=='')
					$linkmanname=returntablefield("supplylinkman", "phone", $sendlistarray[$i], "supplyname");	
				if($linkmanname=='')
					$linkmanname=returntablefield("user", "MOBIL_NO", $sendlistarray[$i], "USER_NAME");
				if($textareaInitValue=='')
					$textareaInitValue=$sendlistarray[$i]." ".$linkmanname;
				else
					$textareaInitValue=$textareaInitValue."\\n".$sendlistarray[$i]." ".$linkmanname;
			}
			
		}
		
		print "<script type=\"text/javascript\" language=\"javascript\" src=\"".ROOT_DIR."general/ERP/Enginee/jquery/jquery.js\"></script>";
	
		?>
		<SCRIPT language="javascript">

//向服务器发送操作请求
function loginSms()
{

	$.ajax({ 
		  type:"POST", 
		  url:'../Framework/sms_getContents.php?action=login', 
		  dataType: "xml", 
		  success:function(data) 
		  { 
		
			if($(data).find("Result").text()=="0")
				form1.leftcount.value=$(data).find("Count").text();
			else
				alert('短信服务器：'+$(data).find("Descript").text());
		  },
		  error:function(XmlHttpRequest,textStatus, errorThrown)
	      {
			  var $errorPage = XmlHttpRequest.responseText;  
			  alert("访问短信服务器出错/r/n"+$($errorPage).text());   
	      }
	});
}


function sendSms() {
	
	var destlist=form1.destid.value.split("\n");
	var mobiles="";
	var names="";
	var dest="";
	var dest1="";
	var dest2="";
	var regR = /[\r]/g;
    var regN = /[\n]/g;
	var errN="";
	for(i=0;i<destlist.length;i++)
	{
		dest=Trim(destlist[i]).replace(regR,"");
		dest=dest.replace(regN,"");
		dest1=dest.substring(0,11);
		dest2=dest.substring(11,dest.length);
		
		if(!IsMobile(dest1))
		{
			if(errN!="")
				errN=errN+",";
			errN=errN+dest;
			continue;
		}
		
		if(mobiles!="")
			mobiles=mobiles+",";
		mobiles=mobiles+dest1;
		if(names!="")
			names=names+",";
		names=names+dest2;
		
	}
	if(errN!="")
	{
		if(errN.length>50)
			errN.substring(0,50);
		if(confirm("某些手机号格式不正确，是否自动过滤这些号码？\r\n"+errN))
		{
			var newlist=mobiles.split(",");
			var namelist=names.split(",");
			form1.destid.value="";
			for(i=0;i<newlist.length;i++)
			{
				if(form1.destid.value!="")
					form1.destid.value=form1.destid.value+"\r\n";
				form1.destid.value=form1.destid.value+newlist[i]+namelist[i];
			}
			showMobileLine();
		}
		else
			return false;
	}
	if(mobiles=='')
	{
		alert('接收人不能为空');
		return false;
	}
	var msg=form1.msg.value;
	var attime="";
	if(form1.cb_attime.checked)
		attime=form1.attime.value;
	if(msg=='')
	{
		alert('发送内容不能为空');
		return false;
	}

	$.ajax({ 
		  type:"POST", 
		  url:'../Framework/sms_getContents.php?action=send', 
		  data: "mobiles="+mobiles+"&attime="+attime+"&msg="+encodeURIComponent(msg), 
		  dataType: "xml", 
		  success:function(data) 
		  { 
			if($(data).find("Result").text()=="0")
			{
				form1.leftcount.value=$(data).find("Account").text();
				form1.result.value="成功";
				form1.batchid.value=$(data).find("Batchid").text();;
				var len=form1.destid.value.split('\n');
				form1.destcount.value=len.length;
				form1.submit();
			}
			else
				alert('短信服务器：'+$(data).find("Descript").text());
		  },
		  error:function(XmlHttpRequest,textStatus, errorThrown)
	      {
			  var $errorPage = XmlHttpRequest.responseText;  
			  alert("访问短信服务器出错/r/n"+$($errorPage).text());   
	      }
	});
	
	
    var btn=document.getElementById('sendbtn');
	btn.disabled=true;
}

$(document).ready(function(){
	document.form1.destid.value='<?php echo $textareaInitValue?>';
	showMobileLine();
	loginSms();
});

</SCRIPT>
		<?php
		
		print "<p align=center><input type=button id='sendbtn' class=\"SmallButton\" value=\" 发送 \" onclick=\"sendSms();\">  <input type=button class=\"SmallButton\" value=\" 返回 \" onclick=\"if(history.length==0) window.close();else history.back();\">";
	}
	if($_GET['action']=="view_default")
	{
?>
<SCRIPT language="javascript">
var xmlHttp;    //用于保存XMLHttpRequest对象的全局变量
var tds=document.getElementsByTagName("td");
var batchid=0;
var td;
var htmltext="";
for(i=0;i<tds.length;i++)
{
	if(tds[i].innerText=="返回批号:")
		batchid=tds[i+1].innerText;
	if(tds[i].innerText=="接收人号码:")
		td=tds[i+1];
}
//用于创建XMLHttpRequest对象
function createXmlHttp() {
//根据window.XMLHttpRequest对象是否存在使用不同的创建方式
if (window.XMLHttpRequest) {
   xmlHttp = new XMLHttpRequest();                  //FireFox、Opera等浏览器支持的创建方式
} else {
   xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");//IE浏览器支持的创建方式
}
}
//向服务器发送操作请求
function getSendDetail() {
	createXmlHttp();                        //创建XmlHttpRequest对象
    xmlHttp.onreadystatechange =function() {showloginResult(xmlHttp)};   
    xmlHttp.open("GET", "../Framework/sms_getContents.php?action=detail&batchid="+batchid, true);
    xmlHttp.send(null);
}
function showloginResult(xmlHttp) {
    if (xmlHttp.readyState == 4 ) {
    	if(xmlHttp.status == 200) {
    		if(xmlHttp.responseText.indexOf("Result")==-1)
        	{
				alert("访问短信服务器出错，无法追踪发送状态");
				return false;
        	}
    		var doc = new ActiveXObject("MSxml2.DOMDocument");
   		 	doc.loadXML(xmlHttp.responseText);
            var result = doc.getElementsByTagName("Result")[0].childNodes[0].nodeValue;
			if(result==0)
			{
				var detailnode = doc.getElementsByTagName("明细")[0];
				while(detailnode!=null)
				{
					var mobile=detailnode.childNodes[0].nodeValue;
					while (mobile.length<16)
						mobile=mobile+"　";
					htmltext=htmltext+"<br>"+mobile;
					if(detailnode.getAttribute("trace")=="成功")
						htmltext=htmltext+"<font color=green>"+detailnode.getAttribute("trace")+"</font>";
					else if(detailnode.getAttribute("trace")=="失败")
						htmltext=htmltext+"<font color=red>"+detailnode.getAttribute("trace")+"</font>";
					htmltext=htmltext+"　"+detailnode.getAttribute("tracetime")+"　"+detailnode.getAttribute("replymsg")+"　"+detailnode.getAttribute("replytime");
					detailnode=detailnode.nextSibling;
				}
				if(htmltext!="")
					htmltext="接收人　　　　　　　　结果　　　接收时间　　　　　　回复　　　　　　回复时间"+htmltext;
				
				return htmltext;
			}
			else
			{
				var descript = doc.getElementsByTagName("Descript")[0].childNodes[0].nodeValue;
				alert('短信服务器：'+descript);
				
			}
        
    	}
       
        
            
    }
}
if(batchid>0)
{
	getSendDetail();
	
	function insertText()
	{
		if(htmltext!="")
		{
			td.innerHTML=htmltext;
			htmltext="";
			clearInterval(n);
		}
	}
	var n=setInterval(insertText,1000);
}

</script>
<?php	
	
	}
	?>