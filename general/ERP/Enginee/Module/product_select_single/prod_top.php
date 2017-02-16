<?php 
require_once('../../../config.inc.php');
?>
<SCRIPT language="javascript">
var xmlHttp;    //用于保存XMLHttpRequest对象的全局变量

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
function sendSearch() {
	if(kword.value=='')
	{
		kword.value=='关键字搜索...';
		searchResult.innerHTML='';
		return false;
	}
	createXmlHttp();                        //创建XmlHttpRequest对象
    xmlHttp.onreadystatechange =function() {showSearchResult(xmlHttp)};   
    xmlHttp.open("GET", "inc_prod_detail_update.php?action=search&keyword="+kword.value, true);
    xmlHttp.send(null);
}
//将服务器响应信息写入购物车div中
function showSearchResult(xmlHttp) {
    if (xmlHttp.readyState == 4) {
        var res=xmlHttp.responseText;
        if(res.indexOf("<a href")!=-1)
        	searchResult.innerHTML = xmlHttp.responseText;
        else
        {
            alert(xmlHttp.responseText);
            location.reload();
        }
            
    }
}
</SCRIPT>

<LINK href="<?php echo ROOT_DIR?>theme/3/style.css" type=text/css rel=stylesheet>
<div align=left  style="margin: 10px;">
方法一：<input type="text" id="kword" name="kword" value="关键字搜索..."   class="SmallInput" onFocus="if(value==defaultValue){value='';this.style.color='#000'}" 
onBlur="if(!value){value=defaultValue;this.style.color='#999'}" style="width:100px;color:#999999"  onkeyup="sendSearch()">

<div id="searchResult">
</div>
</div>

