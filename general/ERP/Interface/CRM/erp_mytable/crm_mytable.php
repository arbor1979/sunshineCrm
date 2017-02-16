<?php
	
	ini_set('display_errors',1);
	ini_set('error_reporting',E_ALL);
	error_reporting(E_WARNING | E_ERROR);
	require_once("lib.inc.php");
	$GLOBAL_SESSION=returnsession();
	page_css('CRM桌面');

?>
<meta http-equiv="refresh" content="60">
<style>
body {margin:0px;padding:0px;font-size:12px;}

.content{width:100%;}
.content .left{
    float:left;
    width:50%;
    border:0px solid #0066CC;
    margin:0px;
}
.content .right{float:left;border:0px solid #0066CC;margin:0px;width:49%;}

.mo{height:auto;border:1px solid #CCC;margin:5px;background:#FFF}
.mo h1{background:#ECF9FF;height:18px;padding:3px;cursor:move}
.closediv{cursor:default;}
.minusspan{cursor:default;}
.mo .nr{height:120px;border:0px solid #F3F3F3;margin:2px}
h1{margin:0px;padding:0px;text-align:left;font-size:12px}
.dragging {
    FILTER: progid:DXImageTransform.Microsoft.Alpha(opacity=60); opacity: 0.6; moz-opacity: 0.6
}
</style>

<script language="javascript">
/*
ikaiser@163.com 2007-1-11 改动
1、添加拖动层时的虚线框
2、添加拖动层时的半透明效果
3、加入层折叠和关闭功能
具体的代码改动我已经在代码中标出
*/
var dragobj={}
window.onerror=function(){return false}
var domid=12
function on_ini(){
    String.prototype.inc=function(s){return this.indexOf(s)>-1?true:false}
    var agent=navigator.userAgent
    window.isOpr=agent.inc("Opera")
    window.isIE=agent.inc("IE") && !isOpr
    window.isMoz=agent.inc("Mozilla") && !isOpr && !isIE
    if(isMoz){
        Event.prototype.__defineGetter__("x",function(){return this.clientX+2})
        Event.prototype.__defineGetter__("y",function(){return this.clientY+2})
    }
    basic_ini()
}
function basic_ini(){
    window.$=function(obj){return typeof(obj)=="string"?document.getElementById(obj):obj}
    window.oDel=function(obj){if($(obj)!=null){$(obj).parentNode.removeChild($(obj))}}
}
window.oDel=function(obj){if($(obj)!=null){$(obj).parentNode.removeChild($(obj))}}
window.onload=function(){
    on_ini()
    var o=document.getElementsByTagName("h1")
    for(var i=0;i<o.length;i++){
        o[i].onmousedown=addevent;
        //添加折叠和关闭按钮
        var tt = document.createElement("div");
        tt.style.cssText = "float:left";
        
        var span = document.createElement("span");
        span.innerHTML = "--"+o[i].innerHTML;
        span.style.cssText = "cursor:default;";
        span.onmousedown = minusDiv;
        tt.appendChild(span);
        
        var close = document.createElement("div");
        close.innerHTML = "";
        close.style.cssText = "cursor:default;float:right";
        close.onmousedown = closeDiv;
        o[i].innerHTML = "";
        o[i].appendChild(tt);
        o[i].appendChild(close);
    }
    
}
//折叠或者显示层
function minusDiv(e)
{
    e=e||event
    var nr = this.parentNode.parentNode.nextSibling;    //取得内容层
    nr.style.display = nr.style.display==""?"none":"";
}
//移出层
function closeDiv(e)
{
    e=e||event
    var mdiv = this.parentNode.parentNode;    //取得目标层
    oDel(mdiv);
}
function addevent(e){
    if(dragobj.o!=null)
        return false
    e=e||event
    dragobj.o=this.parentNode
    dragobj.xy=getxy(dragobj.o)
    dragobj.xx=new Array((e.x-dragobj.xy[1]),(e.y-dragobj.xy[0]))
    //dragobj.o.className = 'dragging';
    dragobj.o.style.width=dragobj.xy[2]+"px"
    dragobj.o.style.height=dragobj.xy[3]+"px"
    dragobj.o.style.left=(e.x-dragobj.xx[0])+"px"
    dragobj.o.style.top=(e.y-dragobj.xx[1])+"px"
    dragobj.o.style.position="absolute"
    dragobj.o.style.filter='alpha(opacity=60)';        //添加拖动透明效果
    var om=document.createElement("div")
    dragobj.otemp=om
    om.style.width=dragobj.xy[2]+"px"
    om.style.height=dragobj.xy[3]+"px"
    om.style.border = "1px dashed red";    //ikaiser添加，实现虚线框
    dragobj.o.parentNode.insertBefore(om,dragobj.o)

    return false
}
document.onselectstart=function(){return false}
window.onfocus=function(){document.onmouseup()}
window.onblur=function(){document.onmouseup()}
document.onmouseup=function(e){
    if(dragobj.o!=null){
        dragobj.o.style.width="auto"
        dragobj.o.style.height="auto"
        dragobj.otemp.parentNode.insertBefore(dragobj.o,dragobj.otemp)
        dragobj.o.style.position=""
        oDel(dragobj.otemp)
        dragobj={}
        updateNewOrder()
    }
}
var xmlhttp=null;
function updateNewOrder()
{
	var o=document.getElementsByTagName("div")
	var sendstr='';
	var leftmenu='';
	var rightmenu='';
    for(var i=0;i<o.length;i++)
    {

        if(o[i].className=='mo')
        {
            if(o[i].parentNode.id=='dom0')
            {
                if(leftmenu!='')
                	leftmenu=leftmenu+",";
            	leftmenu=leftmenu+o[i].id.replace(/m/,"");
            }
            else
            {
            	if(rightmenu!='')
            		rightmenu=rightmenu+",";
            	rightmenu=rightmenu+o[i].id.replace(/m/,"");
            }
            
        	sendstr="leftmenu="+leftmenu+"&rightmenu="+rightmenu;
        }
    }
    //alert(sendstr);
    if(sendstr!='')
    {
    	if (window.XMLHttpRequest)
  	  	{// code for all new browsers
  	 		 xmlhttp=new XMLHttpRequest();
  	  	}
  		else if (window.ActiveXObject)
  	  	{// code for IE5 and IE6
  	  		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  	  	}
    	if (xmlhttp!=null)
  	  	{
  	  		xmlhttp.onreadystatechange=state_Change;
  	  		xmlhttp.open("GET","crm_config_mytable.php?"+sendstr,true);
  	  		xmlhttp.send(null);
  	  
  	  	}
    	else
  	  	{
  	  		alert("你的浏览器不支持 XMLHTTP.");
  	  	}
      	
    }
}
function state_Change()
{
if (xmlhttp.readyState==4)
  {// 4 = "loaded"
  if (xmlhttp.status==200)
    {// 200 = OK
	  //alert(xmlhttp.responseText);
    }
  else
    {
    alert("Problem retrieving XML data");
    }
  }
}
document.onmousemove=function(e){
    e=e||event
    if(dragobj.o!=null){
        dragobj.o.style.left=(e.x-dragobj.xx[0])+"px"
        dragobj.o.style.top=(e.y-dragobj.xx[1])+"px"
        createtmpl(e, dragobj.o)    //传递当前拖动对象
    }
}
function getxy(e){
    var a=new Array()
    var t=e.offsetTop;
    var l=e.offsetLeft;
    var w=e.offsetWidth;
    var h=e.offsetHeight;
    while(e=e.offsetParent){
        t+=e.offsetTop;
        l+=e.offsetLeft;
    }
    a[0]=t;a[1]=l;a[2]=w;a[3]=h
  return a;
}
function inner(o,e){
    var a=getxy(o)
    if(e.x>a[1] && e.x<(a[1]+a[2]) && e.y>a[0] && e.y<(a[0]+a[3])){
        if(e.y<(a[0]+a[3]/2))
            return 1;
        else
            return 2;
    }else
        return 0;
}
//将当前拖动层在拖动时可变化大小，预览效果
function createtmpl(e, elm){
    for(var i=0;i<domid;i++){
        if(document.getElementById("m"+i) == null)    //已经移出的层不再遍历
            continue;
        if($("m"+i)==dragobj.o)
            continue
        var b=inner($("m"+i),e)
        if(b==0)
            continue
        dragobj.otemp.style.width=$("m"+i).offsetWidth
        elm.style.width = $("m"+i).offsetWidth;
        //1为下移，2为上移
        if(b==1){
            $("m"+i).parentNode.insertBefore(dragobj.otemp,$("m"+i))
        }else{
            if($("m"+i).nextSibling==null){
                $("m"+i).parentNode.appendChild(dragobj.otemp)
            }else{
                $("m"+i).parentNode.insertBefore(dragobj.otemp,$("m"+i).nextSibling)
            }
        }
        return
    }
    for(var j=0;j<2;j++){
        if($("dom"+j).innerHTML.inc("div")||$("dom"+j).innerHTML.inc("DIV"))
            continue
        var op=getxy($("dom"+j))
        if(e.x>(op[1]+10) && e.x<(op[1]+op[2]-10)){
            $("dom"+j).appendChild(dragobj.otemp)
            dragobj.otemp.style.width=(op[2]-10)+"px"
        }
    }
}
function add_div()
{
    var o=document.createElement("div")
    o.className="mo"
    o.id="m"+domid
    $('dom0').appendChild(o)
    o.innerHTML="<h1>dom"+domid+"</h1><div class=nr><iframe src='DataQuery/productFrame.php'/></div>"
    o.getElementsByTagName("h1")[0].onmousedown=addevent
    domid++
}
</script>
<?php

$user_id = $_SESSION['LOGIN_USER_ID'];
//加载CRM桌面设置参数

/*
print "<script type=\"text/javascript\">
		var cRows = tblContainer.rows;
		var row;
		for (var i=0; i<cRows.length; i++)
		{
			row = cRows[i];
			row.cells[0].firstChild.height = row.cells[1].offsetHeight;
		}
    </script>";
*/
//得到crm_mytable_newai.php中设置显示数据
$mytable_arr = array();
$CCCCC1 = 0;
$CCCCC2 = 0;
$leftSelArray=explode(",", $_SESSION['LEFT_MENU']);
$rightSelArray=explode(",", $_SESSION['RIGHT_MENU']);
foreach ($leftSelArray as $row)
{
	if($row=='') continue;
	$sql = "select * from crm_mytable where 编号=$row";
	$rs=$db->Execute($sql);
	$rs_a = $rs->GetArray();
	$divname=$rs_a[0]['模块名称'];
	$NewArray1[$CCCCC1] = $divname;
	$CCCCC1++;
	$mytable_arr[$divname]['编号'] = $rs_a[0]['编号'];
    $mytable_arr[$divname]['模块编号'] = $rs_a[0]['模块编号'];
    $mytable_arr[$divname]['模块位置'] = '左侧';
    $mytable_arr[$divname]['模块属性'] = $rs_a[0]['模块属性'];
    $mytable_arr[$divname]['显示行数'] = $rs_a[0]['显示行数'];
    $mytable_arr[$divname]['滚动显示'] = $rs_a[0]['滚动显示'];
    $mytable_arr[$divname]['备注'] = $rs_a[0]['备注'];
    $mytable_arr[$divname]['菜单限制'] = $rs_a[0]['菜单限制'];
}
foreach ($rightSelArray as $row)
{
	
	if($row=='') continue;
	$sql = "select * from crm_mytable where 编号=$row";
	$rs=$db->Execute($sql);
	$rs_a = $rs->GetArray();
	$divname=$rs_a[0]['模块名称'];
	$NewArray2[$CCCCC2] = $divname;
	$CCCCC2++;
	$mytable_arr[$divname]['编号'] = $rs_a[0]['编号'];
    $mytable_arr[$divname]['模块编号'] = $rs_a[0]['模块编号'];
    $mytable_arr[$divname]['模块位置'] = '右侧';
    $mytable_arr[$divname]['模块属性'] = $rs_a[0]['模块属性'];
    $mytable_arr[$divname]['显示行数'] = $rs_a[0]['显示行数'];
    $mytable_arr[$divname]['滚动显示'] = $rs_a[0]['滚动显示'];
    $mytable_arr[$divname]['备注'] = $rs_a[0]['备注'];
    $mytable_arr[$divname]['菜单限制'] = $rs_a[0]['菜单限制'];
}



$m=0;
print "<div class=content>";
print "<div class=left id=dom0>";
for($IXXXX=0;$IXXXX<sizeof($NewArray1);$IXXXX++)				
{
	
	$模块名称= $NewArray1[$IXXXX];
	$valueVVVVVVV= $mytable_arr[$模块名称];
	if($valueVVVVVVV['菜单限制']!='' && !validateSingleMenuPriv($valueVVVVVVV['菜单限制']))
		continue;
	$滚动显示  = $valueVVVVVVV['滚动显示'];
	$max_count = $valueVVVVVVV['显示行数'];
	if($valueVVVVVVV['模块属性']=="用户必选")
	{
		print "<div class=mo id=m".$valueVVVVVVV['编号'].">";
        print "<h1>".$valueVVVVVVV['备注']."</h1>";
        print "<div class=\"nr\">";
		require_once("$模块名称");
		print "</div></div>";
	    $m++;
	}
}
print "</div>";
print "<div class=right id=dom1>";
for($IXXXX=0;$IXXXX<sizeof($NewArray2);$IXXXX++)				
{

	$模块名称= $NewArray2[$IXXXX];
	$valueVVVVVVV= $mytable_arr[$模块名称];
	if($valueVVVVVVV['菜单限制']!='' && !validateSingleMenuPriv($valueVVVVVVV['菜单限制']))
		continue;
	$滚动显示  = $valueVVVVVVV['滚动显示'];
	$max_count = $valueVVVVVVV['显示行数'];
	if($valueVVVVVVV['模块属性']=="用户必选")
	{
		print "<div class=mo id=m".$valueVVVVVVV['编号'].">";
        print "<h1>".$valueVVVVVVV['备注']."</h1>";
        print "<div class=\"nr\">";
		require_once("$模块名称");
		print "</div></div>";
		
	    $m++;
	}
}
print "</div>";
print "</div>";
/*
	版权归属:郑州单点科技软件有限公司;
	联系方式:0371-69663266;
	公司地址:河南郑州经济技术开发区第五大街经北三路通信产业园四楼西南;
	公司简介:郑州单点科技软件有限公司位于中国中部城市-郑州,成立于2007年1月,致力于把基于先进信息技术（包括通信技术）的最佳管理与业务实践普及到教育行业客户的管理与业务创新活动中，全面提供具有自主知识产权的教育管理软件、服务与解决方案，是中部最优秀的高校教育管理软件及中小学校管理软件提供商。目前已经有多家高职和中职类院校使用通达中部研发中心开发的软件和服务;

	软件名称:单点科技软件开发基础性架构平台,以及在其基础之上扩展的任何性软件作品;
	发行协议:数字化校园产品为商业软件,发行许可为LICENSE方式;单点CRM系统即SunshineCRM系统为GPLV3协议许可,GPLV3协议许可内容请到百度搜索;
	特殊声明:软件所使用的ADODB库,PHPEXCEL库,SMTARY库归原作者所有,余下代码沿用上述声明;
*/
?>

