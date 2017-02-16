
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
<script type="text/javascript">
 var prox;
 var proy;
 var proxc;
 var proyc;
 function show(id){/*--打开--*/
  clearInterval(prox);
  clearInterval(proy);
  clearInterval(proxc);
  clearInterval(proyc);
  var o = document.getElementById(id);
  o.style.display = "block";
  o.style.width = "200px";
  o.style.height = "50px"; 
  btn.value="关闭条码输入";
  inputcode.focus();
  //prox = setInterval(function(){openx(o,200)},10);
 } 
 function openx(o,x){/*--打开x--*/
  var cx = parseInt(o.style.width);
  if(cx < x)
  {
   o.style.width = (cx + Math.ceil((x-cx)/5)) +"px";
  }
  else
  {
   clearInterval(prox);
   proy = setInterval(function(){openy(o,50)},10);
  }
 } 
 function openy(o,y){/*--打开y--*/ 
  var cy = parseInt(o.style.height);
  if(cy < y)
  {
   o.style.height = (cy + Math.ceil((y-cy)/5)) +"px";
  }
  else
  {
   clearInterval(proy);   
  }
 } 
 function closeed(id){/*--关闭--*/
  clearInterval(prox);
  clearInterval(proy);
  clearInterval(proxc);
  clearInterval(proyc);  
  var o = document.getElementById(id);
  btn.value="开启条码输入";
  if(o.style.display == "block")
  {
   //proyc = setInterval(function(){closey(o)},10);
	  
	  o.style.display = "none";   
  }  
 } 
 function closey(o){/*--打开y--*/ 
  var cy = parseInt(o.style.height);
  if(cy > 0)
  {
   o.style.height = (cy - Math.ceil(cy/5)) +"px";
  }
  else
  {
   clearInterval(proyc);    
   proxc = setInterval(function(){closex(o)},10);
  }
 } 
 function closex(o){/*--打开x--*/
  var cx = parseInt(o.style.width);
  if(cx > 0)
  {
   o.style.width = (cx - Math.ceil(cx/5)) +"px";
  }
  else
  {
   clearInterval(proxc);
   o.style.display = "none";
  }
 } 
 function inputInteger(event)
 {
 	if (event.keyCode>=48 && event.keyCode<=57)
 		event.returnValue=true;
 	else
 	{
 		event.returnValue=false;
 	} 	
 }


</script>
<div align=left style="margin: 10px;">
方法一：<input type="text" id="kword" name="kword" value="关键字搜索..."   class="SmallInput" onFocus="if(value==defaultValue){value='';this.style.color='#000'}" 
onBlur="if(!value){value=defaultValue;this.style.color='#999'}" style="width:100px;color:#999999"  onkeyup="sendSearch()">

<div id="searchResult" align=left>
</div></div>
<div align=left  style="margin: 10px;">
方法二：<input type="button" id="btn" value="关闭条码输入" onclick = "if(this.value=='开启条码输入')show('fd');else closeed('fd');">

<div id="fd" style="display:block;filter:alpha(opacity=100);opacity:1;">
 <div class="content">
产品数量：<input type="text" id="inputnum" name="inputnum" value="1"  class="SmallInput" style="width:60px" onkeydown="if(event.keyCode==13){event.keyCode=9;}" onkeypress="inputInteger(event)"><br>
<input type="text" id="inputcode" name="inputcode" value=""  class="SmallInput" style="FONT-SIZE: 20px;width:180px" onkeydown="if(event.keyCode==13){addProduct(this.value,'add',2,inputnum.value);this.value='';}" onkeyup="if(event.keyCode==107 || event.keyCode==187){this.value='';window.parent.window.frames['edu_main'].focusLastNum()}"><br>

 </div> 
</div>
</div>

