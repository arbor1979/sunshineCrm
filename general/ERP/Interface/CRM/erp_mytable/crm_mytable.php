<?php
	
	ini_set('display_errors',1);
	ini_set('error_reporting',E_ALL);
	error_reporting(E_WARNING | E_ERROR);
	require_once("lib.inc.php");
	$GLOBAL_SESSION=returnsession();
	page_css('CRM����');

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
ikaiser@163.com 2007-1-11 �Ķ�
1������϶���ʱ�����߿�
2������϶���ʱ�İ�͸��Ч��
3��������۵��͹رչ���
����Ĵ���Ķ����Ѿ��ڴ����б��
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
        //����۵��͹رհ�ť
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
//�۵�������ʾ��
function minusDiv(e)
{
    e=e||event
    var nr = this.parentNode.parentNode.nextSibling;    //ȡ�����ݲ�
    nr.style.display = nr.style.display==""?"none":"";
}
//�Ƴ���
function closeDiv(e)
{
    e=e||event
    var mdiv = this.parentNode.parentNode;    //ȡ��Ŀ���
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
    dragobj.o.style.filter='alpha(opacity=60)';        //����϶�͸��Ч��
    var om=document.createElement("div")
    dragobj.otemp=om
    om.style.width=dragobj.xy[2]+"px"
    om.style.height=dragobj.xy[3]+"px"
    om.style.border = "1px dashed red";    //ikaiser��ӣ�ʵ�����߿�
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
  	  		alert("����������֧�� XMLHTTP.");
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
        createtmpl(e, dragobj.o)    //���ݵ�ǰ�϶�����
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
//����ǰ�϶������϶�ʱ�ɱ仯��С��Ԥ��Ч��
function createtmpl(e, elm){
    for(var i=0;i<domid;i++){
        if(document.getElementById("m"+i) == null)    //�Ѿ��Ƴ��Ĳ㲻�ٱ���
            continue;
        if($("m"+i)==dragobj.o)
            continue
        var b=inner($("m"+i),e)
        if(b==0)
            continue
        dragobj.otemp.style.width=$("m"+i).offsetWidth
        elm.style.width = $("m"+i).offsetWidth;
        //1Ϊ���ƣ�2Ϊ����
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
//����CRM�������ò���

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
//�õ�crm_mytable_newai.php��������ʾ����
$mytable_arr = array();
$CCCCC1 = 0;
$CCCCC2 = 0;
$leftSelArray=explode(",", $_SESSION['LEFT_MENU']);
$rightSelArray=explode(",", $_SESSION['RIGHT_MENU']);
foreach ($leftSelArray as $row)
{
	if($row=='') continue;
	$sql = "select * from crm_mytable where ���=$row";
	$rs=$db->Execute($sql);
	$rs_a = $rs->GetArray();
	$divname=$rs_a[0]['ģ������'];
	$NewArray1[$CCCCC1] = $divname;
	$CCCCC1++;
	$mytable_arr[$divname]['���'] = $rs_a[0]['���'];
    $mytable_arr[$divname]['ģ����'] = $rs_a[0]['ģ����'];
    $mytable_arr[$divname]['ģ��λ��'] = '���';
    $mytable_arr[$divname]['ģ������'] = $rs_a[0]['ģ������'];
    $mytable_arr[$divname]['��ʾ����'] = $rs_a[0]['��ʾ����'];
    $mytable_arr[$divname]['������ʾ'] = $rs_a[0]['������ʾ'];
    $mytable_arr[$divname]['��ע'] = $rs_a[0]['��ע'];
    $mytable_arr[$divname]['�˵�����'] = $rs_a[0]['�˵�����'];
}
foreach ($rightSelArray as $row)
{
	
	if($row=='') continue;
	$sql = "select * from crm_mytable where ���=$row";
	$rs=$db->Execute($sql);
	$rs_a = $rs->GetArray();
	$divname=$rs_a[0]['ģ������'];
	$NewArray2[$CCCCC2] = $divname;
	$CCCCC2++;
	$mytable_arr[$divname]['���'] = $rs_a[0]['���'];
    $mytable_arr[$divname]['ģ����'] = $rs_a[0]['ģ����'];
    $mytable_arr[$divname]['ģ��λ��'] = '�Ҳ�';
    $mytable_arr[$divname]['ģ������'] = $rs_a[0]['ģ������'];
    $mytable_arr[$divname]['��ʾ����'] = $rs_a[0]['��ʾ����'];
    $mytable_arr[$divname]['������ʾ'] = $rs_a[0]['������ʾ'];
    $mytable_arr[$divname]['��ע'] = $rs_a[0]['��ע'];
    $mytable_arr[$divname]['�˵�����'] = $rs_a[0]['�˵�����'];
}



$m=0;
print "<div class=content>";
print "<div class=left id=dom0>";
for($IXXXX=0;$IXXXX<sizeof($NewArray1);$IXXXX++)				
{
	
	$ģ������= $NewArray1[$IXXXX];
	$valueVVVVVVV= $mytable_arr[$ģ������];
	if($valueVVVVVVV['�˵�����']!='' && !validateSingleMenuPriv($valueVVVVVVV['�˵�����']))
		continue;
	$������ʾ  = $valueVVVVVVV['������ʾ'];
	$max_count = $valueVVVVVVV['��ʾ����'];
	if($valueVVVVVVV['ģ������']=="�û���ѡ")
	{
		print "<div class=mo id=m".$valueVVVVVVV['���'].">";
        print "<h1>".$valueVVVVVVV['��ע']."</h1>";
        print "<div class=\"nr\">";
		require_once("$ģ������");
		print "</div></div>";
	    $m++;
	}
}
print "</div>";
print "<div class=right id=dom1>";
for($IXXXX=0;$IXXXX<sizeof($NewArray2);$IXXXX++)				
{

	$ģ������= $NewArray2[$IXXXX];
	$valueVVVVVVV= $mytable_arr[$ģ������];
	if($valueVVVVVVV['�˵�����']!='' && !validateSingleMenuPriv($valueVVVVVVV['�˵�����']))
		continue;
	$������ʾ  = $valueVVVVVVV['������ʾ'];
	$max_count = $valueVVVVVVV['��ʾ����'];
	if($valueVVVVVVV['ģ������']=="�û���ѡ")
	{
		print "<div class=mo id=m".$valueVVVVVVV['���'].">";
        print "<h1>".$valueVVVVVVV['��ע']."</h1>";
        print "<div class=\"nr\">";
		require_once("$ģ������");
		print "</div></div>";
		
	    $m++;
	}
}
print "</div>";
print "</div>";
/*
	��Ȩ����:֣�ݵ���Ƽ�������޹�˾;
	��ϵ��ʽ:0371-69663266;
	��˾��ַ:����֣�ݾ��ü��������������־�����·ͨ�Ų�ҵ԰��¥����;
	��˾���:֣�ݵ���Ƽ�������޹�˾λ���й��в�����-֣��,������2007��1��,�����ڰѻ����Ƚ���Ϣ����������ͨ�ż���������ѹ�����ҵ��ʵ���ռ���������ҵ�ͻ��Ĺ�����ҵ���»�У�ȫ���ṩ��������֪ʶ��Ȩ�Ľ�����������������������������в�������ĸ�У���������������СѧУ��������ṩ�̡�Ŀǰ�Ѿ��ж�Ҹ�ְ����ְ��ԺУʹ��ͨ���в��з����Ŀ���������ͷ���;

	�������:����Ƽ�������������Լܹ�ƽ̨,�Լ��������֮����չ���κ��������Ʒ;
	����Э��:���ֻ�У԰��ƷΪ��ҵ���,�������ΪLICENSE��ʽ;����CRMϵͳ��SunshineCRMϵͳΪGPLV3Э�����,GPLV3Э����������뵽�ٶ�����;
	��������:�����ʹ�õ�ADODB��,PHPEXCEL��,SMTARY���ԭ��������,���´���������������;
*/
?>

