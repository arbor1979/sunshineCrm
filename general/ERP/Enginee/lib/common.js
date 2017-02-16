//��������BUTTONЧ��JS
var userAgent = navigator.userAgent.toLowerCase();
var is_opera = userAgent.indexOf('opera') != -1 && opera.version();
var is_moz = (navigator.product == 'Gecko') && userAgent.substr(userAgent.indexOf('firefox') + 8, 3);
var is_ie = (userAgent.indexOf('msie') != -1 && !is_opera) && userAgent.substr(userAgent.indexOf('msie') + 5, 3);

function MouseOverBtn(){event.srcElement.className+="Hover";}
function MouseOutBtn() {event.srcElement.className=event.srcElement.className.substr(0,event.srcElement.className.indexOf("Hover"));}
function CorrectButton()
{
   var inputs=document.getElementsByTagName("INPUT");
   for(var i=0; i<inputs.length; i++)
   {
      var el = inputs[i];
      var elType = el.type.toLowerCase();
      var elClass = el.className.toLowerCase();
      var elLength = Math.ceil(el.value.replace(/[^\x00-\xff]/g,"**").length/2);
      if(elType!="button" && elType!="submit" && elType!="reset" || elClass!="bigbutton"&&elClass!="smallbutton")
         continue;
      
      if(elLength<=3)
         el.className+="A";
      else if(elLength==4)
         el.className+="B";
      else if(elLength>=5 && elLength<=7)
         el.className+="C";
      else if(elLength>=8 && elLength<=11)
         el.className+="D";
      else
         el.className+="E";
      
      if(is_ie)
      {
         el.attachEvent("onmouseover", MouseOverBtn);
         el.attachEvent("onmouseout",  MouseOutBtn);
      }
   }
}
if(is_ie)
   window.attachEvent("onload", CorrectButton);
else
   window.addEventListener("load", CorrectButton,false);


//ԭ��JS��ʼ

	var PP_MIN_LEN=2;
	var PP_MAX_LEN=50;
	var PWD_MIN_LEN=2;
	var PWD_MAX_LEN=16;
	var PWDA_MIN_LEN=5;
	var PWDA_MAX_LEN=16;
	
	//ȫ�ֱ�����֧�ֵ�Ӣ��������׺
	var $Suffix= new Array('com','net','org','biz','info','us','cn','ac','io','cc','travel','name','ws','sh','ac','io','tv','tw','com.tw','org.tw','idv.tw','hk','com.hk','edu','edu.cn','com.cn','net.cn','gov.cn','org.cn','bj.cn','sh.cn','tj.cn','cq.cn','he.cn','sx.cn','nm.cn','ln.cn','hk.cn','jl.cn','sd.cn','js.cn','zj.cn','ah.cn','fj.cn','hl.cn','jx.cn','mo.cn','ha.cn','hb.cn','hn.cn','gd.cn','gx.cn','hi.cn','sc.xn','gz.cn','tw.cn','yn.cn','xz.cn','sn.cn','gs.cn','qh.cn','nx.cn','xj.cn');
	
	//ȫ�ֱ�����֧�ֵ�����������׺
	var $cnSuffix = new Array('com', 'net', 'cn', '�й�', '����', '��˾');

	// �����ļ� �÷���
	function $import(path,type,title){
		var s,i;
		if(type=="js")
		{
			var ss=document.getElementsByTagName("script");
			for(i=0;i<ss.length;i++){
				if(ss[i].src && ss[i].src.indexOf(path)!=-1)return;
			}
			s=document.createElement("script");
			s.type="text/javascript";
			s.src=path;
		}else if(type=="css")
		{
			var ls=document.getElementsByTagName("link");
			for(i=0;i<ls.length;i++){
				if(ls[i].href && ls[i].href.indexOf(path)!=-1)return;
			}
			s=document.createElement("link");
			s.rel="alternate stylesheet";
			s.type="text/css";
			s.href=path;
			s.title=title;
			s.disabled=false;
		}
		else return;
		var head=document.getElementsByTagName("head")[0];
		head.appendChild(s);
	} 
	
	//�趨��ʱ֮��ִ��ʲô����
	function DoTimeout(DoType,Action,Times)
	{
		if (Times=="") Times = 1;
		if (typeof(Times)!="number") Times = 1;
		
		switch(DoType.toLowerCase())
		{
			case "go":
				window.setTimeout("window.location='"+ Action +"'",Times);
				break;
			case "alert":
				window.setTimeout("alert('"+ Action +"')",Times);
				break;

			case "js":
				window.setTimeout("'"+ Action.toString() +"'",Times);
				break;

			default:
				alert("Nothing will do!");
				break
		}
		
	}
	
	function $(emid) {
		var elements = new Array();
		
		for (var i = 0; i < arguments.length; i++) 
		{
			var element = arguments[i];
			if (typeof element == 'string')
				element = document.getElementById(element);
			if (arguments.length == 1) 
				return element;
			elements.push(element);
		}
		return elements;
	}
	
	//��ȡ����ֵ 
	function $F(emid) {
	  return $(emid).value;
	}
	
	//���ö���Ŀɼ����ɲ�������
	function setElement(emid,status)
	{
		status = status.toLowerCase();
		var E = $(emid);
		
		if((typeof(E)!='object')||(E==null)) return false;
		switch(status)
		{
			case 'yes':
				E.disabled=false;
				break;
			case 'no':
				E.disabled=true;
				break;
			case 'show':
				E.style.display='block';
				break;
			case 'hide':
				E.style.display='none';
				break;
			case 'display':
				E.style.display='inline';
				break;
		}
	}

	//���ö���Ŀɼ����ɲ�������
	function setElementByName(emname,status)
	{
		status = status.toLowerCase();

		var E = document.getElementsByName(emname);
		
		if(!E.length) E = [E]
		
		for (var i = 0; i < E.length; i++) {
			if((typeof(E[i])!='object')||(E[i]==null)) return false;
			switch(status){
				case 'yes':
					E[i].disabled=false;
					break;
				case 'no':
					E[i].disabled=true;
					break;
				case 'show':
					E[i].style.display='block';
					break;
				case 'hide':
					E[i].style.display='none';
					break;
			}
		}
	}
	
	//�½�һ��HTML����
	function $new(tag){
		return document.createElement(tag);
	}
	
	//
	function setForm(FormID,Status)
	{
		var form = eval(document.FormID);
		for(var i=0;i<form.elements.length; i++)
		{
			if(Status=="ok")
				form.elements[i].disabled = false;
			else
				form.elements[i].disabled = true;
		}
	}

	//�Ƿ���������ַ�
	//��ĸ���ֿ�ͷ������3-16�ֽڣ�������ĸ�����»�������
	//��Ϊ�ɵĻ��տ�����2-3���ֽ�
	function IsAccountChar(str)
	{
		var reg = /^[a-zA-Z0-9][a-zA-Z0-9_-]{0,15}$/;
		if (!reg.test(str))
			return false;
		else
			return true;
	}

	//�������ļӺ�ȥ��
	function escape2(str){
		return escape(str).replace(/\+/g,"%2b");
	}
	
	function LimitLen(theValue,Min,Max)
	{
		theValue=Trim(theValue);
		if(theValue=="") return false;
		if((theValue.length<Min)||(theValue.length>Max))
			return false;
		else
			return true;
	}
	
	//��ʾ��ʾ���֣����񽹵�
	function Focus(FormName, FormInfoName, MSG, Width)
	{
		var obj = $(FormName);
		var Info = $(FormInfoName);

		if(obj!=null)
			obj.focus();
		if(Info!=null)
		{
			Info.innerHTML = MSG;				
			Info.className = "InputError Focus";
				
			if(IsNum(Width)&&(Width!=0))
			{
				Info.style.width = Width + 'px';
			}
		}
		return (false);
	}

	//��ʾ��ʾ����
	function Warning(emid,MSG,Width)
	{
		var obj = $(emid);
		
		if(obj!=null)
		{
			obj.innerHTML = MSG;
			obj.className = "Warning";
			if(IsNum(Width)&&(Width!=0))
			{
				obj.style.width = Width + 'px';
			}
		}
	}
	

	
	//���CSS,����IsClearContent��ʾ�Ƿ��������
	function ClearCss(FormName,IsClearContent)
	{
		if(FormName=='') return;
		var obj = $(FormName);
		if(obj!=null)
			obj.className = "";
			
		if(IsClearContent=="1"){
			obj.innerHTML="";
		}
	}
	

	//��ֹһЩ��
	function DisableKeyDown(){ 
		if ((window.event.altKey)&&((window.event.keyCode==37)|| (window.event.keyCode==39))){ 
			event.returnValue=false; 
		} 
		if (event.keyCode==116){ //F5  
			event.keyCode=0; 
			event.returnValue=false; 
		} 
		if (event.keyCode==122){ //F11
			event.keyCode=0; 
			event.returnValue=false; 
		} 
		if ((event.ctrlKey)&&(event.keyCode==7)){ //Ctrl+n 
			event.returnValue=false; 
		} 
		if ((event.shiftKey)&&(event.keyCode==121)){ //shift+F10 
			event.returnValue=false; 
		} 
	} 
	
	//ȥ���ո�
	function Trim(str)
	{
		var StrLen=str.length;
		if(str.charAt(0) == " ")
		{
			str = str.slice(1);
			str = Trim(str); 
		}
		if(str.charAt(StrLen) == " ")
		{
			str = str.slice(0,StrLen-1);
			str = Trim(str); 
		}
		return str;
	}
	
	//�ж��Ƿ���ȷEMAIL
	function IsEmail(val)
	{
		var mail=/^[_\.0-9a-z-]+@([0-9a-z][0-9a-z-]+\.){1,4}[a-z]{2,3}$/i; 
		if(!mail.test(val)){ 
			return (false);
		} else	{
			return (true);
		}
	}
	
	//ƥ����ַ,���� xxx://
	//δ���
	function IsURL(val)
	{
		var reg = /[a-zA-z]+[://][^\s]*/;
		if(!reg.test(val)){ 
			return (false);
		} else	{
			return (true);
		}
	}
	
	//ƥ��urlת����ַ
	function IsRefererURL(val)
	{
		var reg = /^(http|ftp|mailto|news|mms|rtsp)\:\/\/[0-9a-zA-Z]*([0-9a-zA-Z\-]+\.)+[a-zA-Z]{2,5}?/
		var reg1 = /^[0-9a-zA-Z]*([0-9a-zA-Z\-]+\.)+[a-zA-Z]{2,5}?/
		if(reg.test(val) || reg1.test(val)){ 
			return (true);
		} else	{
			return (false);
		}
	}
	

	//�ж��Ƿ�����
	function IsNum(val)
	{
	  var intStr=/^\d+$/; 
	  if(!intStr.test(val))
		  return (false);
	  else
	  {
			return (true);
	  }
	}
	
	//�Ƿ�IP��ַ
	//��������ȷ�жϵ�һ��Ϊ0
	function IsIP(str)
	{
		var re = /^([01]?\d{1,2}|2[0-4]\d|25[0-5])(\.([01]?\d{1,2}|2[0-4]\d|25[0-5])){3}$/;
		
		if(re.test(str))
			return true;
		else
			return false;
	}

	//�¿�����
	function NewWindow(theURL,theWidth,theHeight,IsScroll)
	{
		var xposition=0; yposition=0;
		if ((parseInt(navigator.appVersion) >= 4 ))
		{
			xposition = (screen.width - theWidth) / 2;
			yposition = (screen.height - theHeight) / 2;
		}		
		window.open(theURL,'NewWindow','width='+theWidth+',height='+theHeight+',left='+xposition+',top='+yposition +',scrollbars='+IsScroll);
	}
	
	//���´���
	function OpenWindow(theURL)
	{
		var WinName = window.open(theURL);
	}
	
	function CloseWindow()
	{
		window.opener = null;
		window.close();		
	}
	
	//�Ƿ�����
	function IsCnChar(str)
	{
		var reg = /^[\u4E00-\u9FA5]+$/;
		if (!reg.test(str))
		{
			return false;
		}
		return true;
	}
	
	//�Ƿ�Ӣ��
	function IsEnChar(str)
	{
		var reg = /^[a-zA-Z]+$/;
		if (!reg.test(str))
		{
			return false;
		}
		return true;
	}
	
	//�Ƿ�˫�ֽڣ��������ģ�
	function IsDoubleChar(str)
	{
		var reg = /^[^\x00-\xff]+$/;
		if (!reg.test(str))
		{
			return false;
		}
		return true;
	}
	
	//�Ƿ��������
	function IsHasCnChar(str)
	{
		var reg = /[^\x00-\xff]/;
		if (reg.test(str))
		{
			return true;
		}
		return false;
	}
	
	//�Ƿ���������
	function IsPwdQuestion(str)
	{
		var reg = /^([\u4E00-\u9FA5]|[0-9a-zA-Z ])+$/;
		if (!reg.test(str))
		{
			return false;
		}
		return true;
	}
	
	//�ж��Ƿ���Ч�ֻ�����
	function IsMobile(str)
	{
		if(str.length==12 && str.substring(0,1)=="0")
			return true;
		var reg = /^((\(\d{2,3}\))|(\d{3}\-))?1[3,8,5]{1}\d{9}$/;
		
		if (reg.test(str))
		{
			return true;
		}
		return false;				
	}
	
	//�Ƿ�Ϊ��
	function IsNullOrEmpty(str)
	{
		var bCheck = true;
		str = Trim(str);
		if(str=='')
			bCheck = false;
		
		return bCheck;
	}
	
	
	
	//��ʾ����״̬
	function ShowStatus(Mode,MSG)
	{
		
		if(document.getElementById("Status")==null)
		{
			var S = $new("div");
			S.id="Status";
			S.className = "Status";
			S.innerHTML = "";
			document.body.appendChild(S);
		}
		
		if($("Status")!=null)
		{
			if(Mode=="hide")
				$("Status").style.visibility = "hidden";
			
			else if(Mode == "show")
			{
				var xPos=50; yPos=50;
				if ((parseInt(navigator.appVersion) >= 4 ))
				{
					xPos = (document.body.clientWidth) / 2;
					yPos = (document.body.clientHeight) / 2 - 50;
				}	
				
				$("Status").innerHTML = MSG;
				$("Status").style.index = "1000";
				$("Status").style.fontSize = "14px";
				$("Status").style.top = yPos + "px";
				$("Status").style.left = xPos + "px";
				$("Status").style.visibility = "visible";
			}
		}	
	}
	
	//����ajax
	function SetUrl(Url)
	{
		if(Url.substr(0,1)!='#')
			window.location.href = '#'+Url;
		else
			window.location.href = Url;
	}
	
	//�س�ִ��ĳһ������
	function EnterSubmit(evt,btnName)
	{
		evt = evt ? evt : (window.event ? window.event : null);
		
		if (evt.keyCode==13)
		{
			if($(btnName)!=null)
			{
				$(btnName).click();
			}
		}
	}
	
	//======���������б��ѡ��
	function AddSelect(emid, Pos, strText, strValue)
	{
		var selObj = $(emid).options;
		if(selObj!=null)
		{
			var objOption = new Option(strText,strValue);
			selObj.add(objOption,Pos);
		}
	}
	
	//======��ȡ�����б�ѡ�е�ֵ 
	function getSelectValue(emid)
	{
		var selValue='';
		var selObj	= $(emid).options;
		var len		= selObj.length;
		for(var i=0;i<len;i++)
		{
			if(selObj[i].selected)
				selValue += selObj[i].value + ',';
		}
		if(selValue.substr(selValue.length-1,1)==',') selValue = selValue.substr(0,selValue.length-1)
		return selValue;
	}
	
	function RemoveSelect(emid)
	{
		var selObj	= $(emid).options;
		
		for(var i=selObj.length;i>0;i--)
		{
			if(selObj[i-1].selected)
				selObj.remove(i-1);
		}
	}
	

	//����������״̬��true or false
	function setInput(emid, emid2, status)
	{
		Element.removeClassName(emid,"InputNO");
		Element.removeClassName(emid,"InputYES");
		
		if(status.toLowerCase()=="ok")
		{
			Element.addClassName(emid,"InputYES");
			$(emid2).className = 'InputTextOK';
			$(emid2).innerHTML = '��д��ȷ';
			return true;
		}else{
			Element.addClassName(emid,"InputNO");
			Element.addClassName(emid2,"InputTextOK");
			return false;
		}
	}
	//��ԭ<form>
	//��Ϊ</form>��ajax���޷���FF��ʾ
	function RestoreTagForm(str)
	{
		//str = str.replace(/(&lt;form)/g,'<form');
		//str = str.replace(/(&lt;/form&gt;)/g,'</form>');
		RestoreTagForm = str;
	}








var listTable = new Object;
var Browser = new Object();

Browser.isMozilla = (typeof document.implementation != 'undefined') && (typeof document.implementation.createDocument != 'undefined') && (typeof HTMLDocument != 'undefined');
Browser.isIE = window.ActiveXObject ? true : false;
Browser.isFirefox = (navigator.userAgent.toLowerCase().indexOf("firefox") != - 1);
Browser.isSafari = (navigator.userAgent.toLowerCase().indexOf("safari") != - 1);
Browser.isOpera = (navigator.userAgent.toLowerCase().indexOf("opera") != - 1);


/**
 * �л�״̬�����б������޸�BOOLEAN���͵�ֵ���л�
 * urlstring = FilePath+"&FieldValue="+txt.value;;
	  AjaxInputHidden(urlstring);
 */
listTable_boolean = function(obj, act, id,sessionkey,tablename,primarykey,IDValue,FieldName,FilePath)
{
  var val = (obj.src.match(/right.gif/i)) ? 0 : 1;
  urlstring = FilePath+"&FieldValue="+val;
  AjaxInputHidden(urlstring);
  //alert(urlstring);
  obj.src = (val > 0) ? '../../Framework/images/right.gif' : '../../Framework/images/error.gif';
  
}

/**
 * ����һ���ɱ༭�������б������������ֵ���޸������
 */

listTable_edit = function(obj, act, id,sessionkey,tablename,primarykey,IDValue,FieldName,FilePath)
{
  var tag = obj.firstChild.tagName;

  if (typeof(tag) != "undefined" && tag.toLowerCase() == "input")
  {
    return;
  }

  /* ����ԭʼ������ */
  var org = obj.innerHTML;
  var val = Browser.isIE ? obj.innerText : obj.textContent;

  /* ����һ������� */
  var txt = document.createElement("INPUT");
  txt.value = (val == 'N/A') ? '' : val;
  txt.style.width = (obj.offsetWidth + 20) + "px" ;
  //input.SmallInput { COLOR: #000066; BACKGROUND: #F8F8F8; border:1 solid black; FONT-SIZE: 9pt; FONT-STYLE: normal; FONT-VARIANT: normal; FONT-WEIGHT: normal; HEIGHT: 18px; LINE-HEIGHT: normal}
  txt.style.COLOR = "#000066" ;
  txt.style.BACKGROUND = "#F8F8F8" ;
  txt.style.border = "1 solid black";

  /* ���ض����е����ݣ������������뵽������ */
  obj.innerHTML = "";
  obj.appendChild(txt);
  txt.focus();


  /* �༭�������¼������� */
  txt.onkeypress = function(e)
  {
    var evt = Utils.fixEvent(e);
    var obj = Utils.srcElement(e);
	var urlstring = "";

    if (evt.keyCode == 13)
    {
      obj.blur();

      return false;
    }

    if (evt.keyCode == 27)
    {
      obj.parentNode.innerHTML = org;
    }
  }

  /* �༭��ʧȥ����Ĵ����� */
  txt.onblur = function(e)
  {
      urlstring = FilePath+"&FieldValue="+txt.value;;
	  AjaxInputHidden(urlstring);
	  //alert(listTable.url);
      //res = Ajax.call(listTable.url, "act="+act+"&val=" + encodeURIComponent(Utils.trim(txt.value)) + "&id=" +id, null, "POST", "JSON", false);
	  //alert(urlstring);
	  //document.getElementById('del'+res.id).innerHTML = "<a href=\""+ thisfile +"?goods_id="+ res.id +"&act=del\" onclick=\"return confirm('"+deleteck+"');\">"+deleteid+"</a>";
      obj.innerHTML = txt.value+"&nbsp;&nbsp;&nbsp;";
  }

}


//########################################################################################
//ʵʱ���½������Ա�ʶ####################################################################
//########################################################################################

listTable_editfieldlang = function(obj,FilePath)
{
  var tag = obj.firstChild.tagName;

  if (typeof(tag) != "undefined" && tag.toLowerCase() == "input")
  {
    return;
  }

  /* ����ԭʼ������ */
  var org = obj.innerHTML;
  var val = Browser.isIE ? obj.innerText : obj.textContent;

  /* ����һ������� */
  var txt = document.createElement("INPUT");
  txt.value = (val == 'N/A') ? '' : val;
  txt.style.width = (obj.offsetWidth + 20) + "px" ;
  //input.SmallInput { COLOR: #000066; BACKGROUND: #F8F8F8; border:1 solid black; FONT-SIZE: 9pt; FONT-STYLE: normal; FONT-VARIANT: normal; FONT-WEIGHT: normal; HEIGHT: 18px; LINE-HEIGHT: normal}
  txt.style.COLOR = "#000066" ;
  txt.style.BACKGROUND = "#F8F8F8" ;
  txt.style.border = "1 solid black";

  /* ���ض����е����ݣ������������뵽������ */
  obj.innerHTML = "";
  obj.appendChild(txt);
  txt.focus();


  /* �༭�������¼������� */
  txt.onkeypress = function(e)
  {
    var evt = Utils.fixEvent(e);
    var obj = Utils.srcElement(e);
	var urlstring = "";

    if (evt.keyCode == 13)
    {
      obj.blur();

      return false;
    }

    if (evt.keyCode == 27)
    {
      obj.parentNode.innerHTML = org;
    }
  }

  /* �༭��ʧȥ����Ĵ����� */
  txt.onblur = function(e)
  {
      urlstring = FilePath+"&FieldValue="+txt.value;;
	  AjaxInputHidden(urlstring);
	  //alert(listTable.url);
      //res = Ajax.call(listTable.url, "act="+act+"&val=" + encodeURIComponent(Utils.trim(txt.value)) + "&id=" +id, null, "POST", "JSON", false);
	  //alert(urlstring);
	  //document.getElementById('del'+res.id).innerHTML = "<a href=\""+ thisfile +"?goods_id="+ res.id +"&act=del\" onclick=\"return confirm('"+deleteck+"');\">"+deleteid+"</a>";
      obj.innerHTML = txt.value+"&nbsp;&nbsp;&nbsp;";
  }

}

//########################################################################################
//########################################################################################
//########################################################################################

var Utils = new Object();

Utils.htmlEncode = function(text)
{
  return text.replace(/&/g, '&amp;').replace(/"/g, '&quot;').replace(/</g, '&lt;').replace(/>/g, '&gt;');
}

Utils.trim = function( text )
{
  if (typeof(text) == "string")
  {
    return text.replace(/^\s*|\s*$/g, "");
  }
  else
  {
    return text;
  }
}

Utils.isEmpty = function( val )
{
  switch (typeof(val))
  {
    case 'string':
      return Utils.trim(val).length == 0 ? true : false;
      break;
    case 'number':
      return val == 0;
      break;
    case 'object':
      return val == null;
      break;
    case 'array':
      return val.length == 0;
      break;
    default:
      return true;
  }
}

Utils.isNumber = function(val)
{
  var reg = /^[\d|\.|,]+$/;
  return reg.test(val);
}

Utils.isInt = function(val)
{
  if (val == "")
  {
    return false;
  }
  var reg = /\D+/;
  return !reg.test(val);
}

Utils.isEmail = function( email )
{
  var reg1 = /([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)/;

  return reg1.test( email );
}

Utils.fixEvent = function(e)
{
  var evt = (typeof e == "undefined") ? window.event : e;
  return evt;
}

Utils.srcElement = function(e)
{
  if (typeof e == "undefined") e = window.event;
  var src = document.all ? e.srcElement : e.target;

  return src;
}

Utils.isTime = function(val)
{
  var reg = /^\d{4}-\d{2}-\d{2}\s\d{2}:\d{2}$/;

  return reg.test(val);
}


function AjaxInputHidden(str)
{
		var oBao = new ActiveXObject("Microsoft.XMLHTTP");
		oBao.open("GET",str,false);
		oBao.send();
}


function LoadDialogWindow_edu(URL, parent, loc_x, loc_y, width, height)
{
  if(is_ie)//window.open(URL);
     window.showModalDialog(URL,parent,"edge:raised;scroll:1;status:0;help:0;resizable:1;dialogWidth:"+width+"px;dialogHeight:"+height+"px;dialogTop:"+loc_y+"px;dialogLeft:"+loc_x+"px",true);
  else
     window.open(URL,parent,"height="+height+",width="+width+",status=0,toolbar=no,menubar=no,location=no,scrollbars=yes,top="+loc_y+",left="+loc_x+",resizable=yes,modal=yes,dependent=yes,dialog=yes,minimizable=no",true);
}


function SelectClassroomSingle(MODULE_ID,TO_ID, TO_NAME, MANAGE_FLAG, FORM_NAME)
{
  URL="../../Enginee/Module/classroom_select_single/index.php?MODULE_ID="+MODULE_ID+"&TO_ID="+TO_ID+"&TO_NAME="+TO_NAME+"&MANAGE_FLAG="+MANAGE_FLAG+"&FORM_NAME="+FORM_NAME;
  loc_y=loc_x=200;
  if(is_ie)
  {
     loc_x=document.body.scrollLeft+event.clientX-100;
     loc_y=document.body.scrollTop+event.clientY+170;
  }
  LoadDialogWindow_edu(URL,self,loc_x, loc_y, 400, 350);
}

function SelectCourseSingle(MODULE_ID,TO_ID, TO_NAME, MANAGE_FLAG, FORM_NAME)
{
  URL="../../Enginee/Module/course_select_single/index.php?MODULE_ID="+MODULE_ID+"&TO_ID="+TO_ID+"&TO_NAME="+TO_NAME+"&MANAGE_FLAG="+MANAGE_FLAG+"&FORM_NAME="+FORM_NAME;
  loc_y=loc_x=200;
  if(is_ie)
  {
     loc_x=document.body.scrollLeft+event.clientX-100;
     loc_y=document.body.scrollTop+event.clientY+170;
  }
  LoadDialogWindow_edu(URL,self,loc_x, loc_y, 400, 350);
}

function SelectBanJiSingle(MODULE_ID,TO_ID, TO_NAME, MANAGE_FLAG, FORM_NAME)
{
  URL="../../Enginee/Module/banji_select_single/index.php?MODULE_ID="+MODULE_ID+"&TO_ID="+TO_ID+"&TO_NAME="+TO_NAME+"&MANAGE_FLAG="+MANAGE_FLAG+"&FORM_NAME="+FORM_NAME;
  loc_y=loc_x=200;
  if(is_ie)
  {
     loc_x=document.body.scrollLeft+event.clientX-100;
     loc_y=document.body.scrollTop+event.clientY+170;
  }
  LoadDialogWindow_edu(URL,self,loc_x, loc_y, 400, 350);
}

//���Թܷ���
function SelectCeShi(MODULE_ID,TO_ID, TO_NAME, MANAGE_FLAG, FORM_NAME)
{
  URL="../../Enginee/Module/ceping_select_renyuan/index.php?MODULE_ID="+MODULE_ID+"&TO_ID="+TO_ID+"&TO_NAME="+TO_NAME+"&MANAGE_FLAG="+MANAGE_FLAG+"&FORM_NAME="+FORM_NAME;
  loc_y=loc_x=200;
  if(is_ie)
  {
     loc_x=document.body.scrollLeft+event.clientX-100;
     loc_y=document.body.scrollTop+event.clientY+170;
  }
  LoadDialogWindow_edu(URL,self,loc_x, loc_y, 400, 350);
}
function SelectCePing(MODULE_ID,TO_ID, TO_NAME, MANAGE_FLAG, FORM_NAME)
{
  URL="../../Enginee/Module/cepingrenyuan_select_renyuan/index.php?MODULE_ID="+MODULE_ID+"&TO_ID="+TO_ID+"&TO_NAME="+TO_NAME+"&MANAGE_FLAG="+MANAGE_FLAG+"&FORM_NAME="+FORM_NAME;
  loc_y=loc_x=200;
  if(is_ie)
  {
     loc_x=document.body.scrollLeft+event.clientX-100;
     loc_y=document.body.scrollTop+event.clientY+170;
  }
  LoadDialogWindow_edu(URL,self,loc_x, loc_y, 500, 400);
}


function SelectStudentSingle(MODULE_ID,TO_ID, TO_NAME, MANAGE_FLAG, FORM_NAME)
{
  URL="../../Enginee/Module/student_select_single/index.php?MODULE_ID="+MODULE_ID+"&TO_ID="+TO_ID+"&TO_NAME="+TO_NAME+"&MANAGE_FLAG="+MANAGE_FLAG+"&FORM_NAME="+FORM_NAME;
  loc_y=loc_x=200;
  if(is_ie)
  {
     loc_x=document.body.scrollLeft+event.clientX-100;
     loc_y=document.body.scrollTop+event.clientY+170;
  }
  LoadDialogWindow_edu(URL,self,loc_x, loc_y, 400, 350);
}

function SelectStudentMulti(MODULE_ID,TO_ID, TO_NAME, MANAGE_FLAG, FORM_NAME)
{
  URL="../../Enginee/Module/student_select_multi/index.php?MODULE_ID="+MODULE_ID+"&TO_ID="+TO_ID+"&TO_NAME="+TO_NAME+"&MANAGE_FLAG="+MANAGE_FLAG+"&FORM_NAME="+FORM_NAME;
  loc_y=loc_x=200;
  if(is_ie)
  {
     loc_x=document.body.scrollLeft+event.clientX-100;
     loc_y=document.body.scrollTop+event.clientY+170;
  }
  LoadDialogWindow_edu(URL,self,loc_x, loc_y, 400, 350);
}

function SelectAllStudentSingle(MODULE_ID,TO_ID, TO_NAME, MANAGE_FLAG, FORM_NAME)
{
  URL="../../Enginee/Module/all_student_select_single/index.php?MODULE_ID="+MODULE_ID+"&TO_ID="+TO_ID+"&TO_NAME="+TO_NAME+"&MANAGE_FLAG="+MANAGE_FLAG+"&FORM_NAME="+FORM_NAME;
  loc_y=loc_x=200;
  if(is_ie)
  {
     loc_x=document.body.scrollLeft+event.clientX-100;
     loc_y=document.body.scrollTop+event.clientY+170;
  }
  LoadDialogWindow_edu(URL,self,loc_x, loc_y, 400, 350);
}


function SelectDormRoomSingle(MODULE_ID,TO_ID, TO_NAME, MANAGE_FLAG, FORM_NAME)
{
  URL="../../Enginee/Module/dorm_room_select_single/index.php?MODULE_ID="+MODULE_ID+"&TO_ID="+TO_ID+"&TO_NAME="+TO_NAME+"&MANAGE_FLAG="+MANAGE_FLAG+"&FORM_NAME="+FORM_NAME;
  loc_y=loc_x=200;
  if(is_ie)
  {
     loc_x=document.body.scrollLeft+event.clientX-100;
     loc_y=document.body.scrollTop+event.clientY+170;
  }
  LoadDialogWindow_edu(URL,self,loc_x, loc_y, 400, 350);
}


function SelectUser(MODULE_ID,TO_ID, TO_NAME, MANAGE_FLAG,FORM_NAME)
{

  URL="../../Enginee/Module/user_select/index.php?MODULE_ID="+MODULE_ID+"&TO_ID="+TO_ID+"&TO_NAME="+TO_NAME+"&MANAGE_FLAG="+MANAGE_FLAG+"&FORM_NAME="+FORM_NAME;
  loc_y=loc_x=200;
  if(is_ie)
  {
     loc_x=document.body.scrollLeft+event.clientX-100;
     loc_y=document.body.scrollTop+event.clientY+170;
  }
  LoadDialogWindow_edu(URL,self,loc_x, loc_y, 400, 350);//����������ѡ�˴��ڵĿ�Ⱥ͸߶�
}
function ClearUser(TO_ID, TO_NAME)
{
  if(TO_ID=="" || TO_ID=="undefined" || TO_ID== null)
  {
     TO_ID="TO_ID";
     TO_NAME="TO_NAME";
  }
  document.getElementsByName(TO_ID)[0].value="";
  document.getElementsByName(TO_NAME)[0].value="";
}

function SelectUserSingle(MODULE_ID,TO_ID, TO_NAME, MANAGE_FLAG, FORM_NAME)
{
  URL="../../Enginee/Module/user_select_single/index.php?MODULE_ID="+MODULE_ID+"&TO_ID="+TO_ID+"&TO_NAME="+TO_NAME+"&MANAGE_FLAG="+MANAGE_FLAG+"&FORM_NAME="+FORM_NAME;
  loc_y=loc_x=200;
  if(is_ie)
  {
     loc_x=document.body.scrollLeft+event.clientX-100;
     loc_y=document.body.scrollTop+event.clientY+170;
  }
  LoadDialogWindow_edu(URL,self,loc_x, loc_y, 400, 350);
}

function SelectTeacherSingle(MODULE_ID,TO_ID, TO_NAME, MANAGE_FLAG, FORM_NAME)
{
  URL="../../Enginee/Module/user_select_single/index.php?MODULE_ID="+MODULE_ID+"&TO_ID="+TO_ID+"&TO_NAME="+TO_NAME+"&MANAGE_FLAG="+MANAGE_FLAG+"&FORM_NAME="+FORM_NAME;
  loc_y=loc_x=200;
  if(is_ie)
  {
     loc_x=document.body.scrollLeft+event.clientX-100;
     loc_y=document.body.scrollTop+event.clientY+170;
  }
  
  LoadDialogWindow_edu(URL,self,loc_x, loc_y, 400, 350);
}


//ѡ�޿�
function SelectXuanKe(MODULE_ID,TO_ID, TO_NAME, MANAGE_FLAG, FORM_NAME)
{
  URL="../../Enginee/Module/xuanke_select_single/index.php?MODULE_ID="+MODULE_ID+"&TO_ID="+TO_ID+"&TO_NAME="+TO_NAME+"&MANAGE_FLAG="+MANAGE_FLAG+"&FORM_NAME="+FORM_NAME;
  loc_y=loc_x=200;
  if(is_ie)
  {
     loc_x=document.body.scrollLeft+event.clientX-100;
     loc_y=document.body.scrollTop+event.clientY+170;
  }
  LoadDialogWindow_edu(URL,self,loc_x, loc_y, 400, 350);
}

function SelectAllInforSingle(MODULE_URL,MODULE_ID,TO_ID, TO_NAME, MANAGE_FLAG, FORM_NAME)
{

  URL = MODULE_URL+"?MODULE_ID="+MODULE_ID+"&TO_ID="+encodeURIComponent(TO_ID)+"&TO_NAME="+encodeURIComponent(TO_NAME)+"&MANAGE_FLAG="+MANAGE_FLAG+"&FORM_NAME="+FORM_NAME;
  loc_y=loc_x=200;
  if(is_ie)
  {
     loc_x=document.body.scrollLeft+event.clientX-100;
     loc_y=document.body.scrollTop+event.clientY;
  }

  LoadDialogWindow_edu(URL,self,loc_x, loc_y, 400, 350);
}

function SelectDept(MODULE_ID,TO_ID, TO_NAME, PRIV_OP)
{
  URL="../../Enginee/Module/dept_select/index.php?MODULE_ID="+MODULE_ID+"&TO_ID="+TO_ID+"&TO_NAME="+TO_NAME+"&PRIV_OP="+PRIV_OP;
  loc_y=loc_x=200;
  if(is_ie)
  {
     loc_x=document.body.scrollLeft+event.clientX-100;
     loc_y=document.body.scrollTop+event.clientY+170;
  }
  LoadDialogWindow_edu(URL,self,loc_x, loc_y, 400, 350);
}
function SelectDeptSingle(MODULE_ID,TO_ID, TO_NAME, PRIV_OP)
{
  URL="../../Enginee/Module/dept_select_single/index.php?MODULE_ID="+MODULE_ID+"&TO_ID="+TO_ID+"&TO_NAME="+TO_NAME+"&PRIV_OP="+PRIV_OP;
  loc_y=loc_x=200;
  if(is_ie)
  {
     loc_x=document.body.scrollLeft+event.clientX-100;
     loc_y=document.body.scrollTop+event.clientY+170;
  }
  LoadDialogWindow_edu(URL,self,loc_x, loc_y, 200, 350);
}

function td_calendar(fieldname)
{
	var URL = fieldname;
	loc_y=loc_x=200;
	if(is_ie)
  {
    loc_x=document.body.scrollLeft+event.clientX-event.offsetX-80;
    loc_y=document.body.scrollTop+event.clientY-event.offsetY+140;
  }
  LoadDialogWindow_edu(URL,self,loc_x, loc_y, 300, 230);
}

function td_clock(fieldname)
{
	var URL = fieldname;
	loc_y=loc_x=200;
	if(is_ie)
  {
    loc_x=document.body.scrollLeft+event.clientX-event.offsetX-80;
    loc_y=document.body.scrollTop+event.clientY-event.offsetY+140;
  }
  LoadDialogWindow_edu(URL,self,loc_x, loc_y, 280, 120);
}
//���븡����
function inputFloat(event)
{
	if (event.keyCode!=46 && event.keyCode!=45 && (event.keyCode<48 || event.keyCode>57)) 
		event.returnValue=false
}
//��������
function inputInteger(event)
{
	if (event.keyCode!=45 && (event.keyCode<48 || event.keyCode>57)) 
		event.returnValue=false
}
//�Ƿ�����
function IsInteger( str )
{
	var regu = /^[-]{0,1}[0-9]{1,}$/;
	return regu.test(str);
} 

//�Ƿ񸡵���
function IsFloat(string) 
{  
	var number; 
	number = new Number(string); 
	if (isNaN(number)) 
	{ 
		return false; 
	} 
	else 
		return true;  
} 
//���㶨λ����һ���ؼ�
function focusNext(event)
{
	if(event.keyCode==13)
		event.keyCode=9
}
//�Զ���λ����һ���ؼ�
function autoFocusNextInput(x,myform)
{
	var form=document.getElementById(myform);
	if(form!=null)
	{
 	for (var i=0;i<form.length;i++)
  	{
  		var n=form.elements[i];
  		if(n.id==x.id && i+1<form.length)
  		{
  			//form.elements[i+1].focus();
  			form.elements[i+1].select();
  			break;	
  		}
  		
  	}
	}
}
//�Ƿ�����
function isLeapYear(year) 
{ 
	if((Number(year)%4==0&&Number(year)%100!=0)||(Number(year)%400==0)) 
	{ 
		return true; 
	}  
	return false; 
}

//�ж����ڸ�ʽ�Ƿ���ȷ
function isDate(checktext){

	var datetime;
	var year,month,day;
	var gone,gtwo;
	var msg="���ڸ�ʽ����ȷ��ӦΪ��yyyy-mm-dd";
	if(Trim(checktext.value)!=""){
		datetime = Trim(checktext.value);
		if(datetime.length==10){
			year=datetime.substring(0,4);
			if(isNaN(year)==true){
				alert(msg);
				checktext.focus();
				return false;
			}
			gone=datetime.substring(4,5);
			month=datetime.substring(5,7);
			if(isNaN(month)==true){
				alert(msg);
				checktext.focus();
				return false;
			}
			gtwo=datetime.substring(7,8);
			day=datetime.substring(8,10);
			if(isNaN(day)==true){
				alert(msg);
				checktext.focus();
				return false;
			}
			
			if((gone=="-")&&(gtwo=="-")){
				if( Number(month)<1 || Number(month)>12 ) { 
					alert("�·ݱ�����01��12֮��!"); 
					checktext.focus();
					return false; 
				} 
				if(Number(day)<1 || Number(day)>31){ 
					alert("���ڱ�����01��31֮��!");
					checktext.focus(); 
					return false; 
				}else{
					if(Number(month)==2){  
					
						if(isLeapYear(year)&& Number(day)>29){ 
							alert("2�µ�������01֮29֮��"); 
							checktext.focus();
							return false; 
						}       
						if(!isLeapYear(year)&& Number(day)>28){ 
							alert("2�µ�������01��28֮��");
							checktext.focus(); 
							return false; 
						} 
					} 
					if((Number(month)==4||Number(month)==6||Number(month)==9||Number(month)==11)&&(Number(day)>30)){ 
						alert("���ڱ�����01��30֮��");
						checktext.focus(); 
						return false; 
					} 
				}
			}else{
				alert(msg);
				checktext.focus();
				return false;
			}
		}else{
			alert(msg);
			checktext.focus();
			return false;
		}
	}else{
		return true;
	}
	return true;
}

//�ж����ں�ʱ���ʽ�Ƿ���ȷ
function isDateTime(checktext){

	var datetime;
	var year,month,day;
	var gone,gtwo;
	var msg="����ʱ���ʽ����ȷ��ӦΪ��yyyy-mm-dd hh:mm:ss";
	if(Trim(checktext.value)!=""){
		datetime = Trim(checktext.value);
		if(datetime.length==19){
			year=datetime.substring(0,4);
			if(isNaN(year)==true){
				alert(msg);
				checktext.focus();
				return false;
			}
			gone=datetime.substring(4,5);
			month=datetime.substring(5,7);
			if(isNaN(month)==true){
				alert(msg);
				checktext.focus();
				return false;
			}
			gtwo=datetime.substring(7,8);
			day=datetime.substring(8,10);
			if(isNaN(day)==true){
				alert(msg);
				checktext.focus();
				return false;
			}
			gthree=datetime.substring(10,11);
			hour=datetime.substring(11,13);
			if(isNaN(hour)==true){
				alert(msg);
				checktext.focus();
				return false;
			}
			gfour=datetime.substring(13,14);
			minute=datetime.substring(14,16);
			if(isNaN(minute)==true){
				alert(msg);
				checktext.focus();
				return false;
			}
			gfive=datetime.substring(16,17);
			second=datetime.substring(17,19);
			if(isNaN(second)==true){
				alert(msg);
				checktext.focus();
				return false;
			}
			if((gone=="-")&&(gtwo=="-")){
				if( Number(month)<1 || Number(month)>12 ) { 
					alert("�·ݱ�����01��12֮��!"); 
					checktext.focus();
					return false; 
				} 
				if(Number(day)<1 || Number(day)>31){ 
					alert("���ڱ�����01��31֮��!");
					checktext.focus(); 
					return false; 
				}else{
					if(Number(month)==2){  
					
						if(isLeapYear(year)&& Number(day)>29){ 
							alert("2�µ�������01֮29֮��"); 
							checktext.focus();
							return false; 
						}       
						if(!isLeapYear(year)&& Number(day)>28){ 
							alert("2�µ�������01��28֮��");
							checktext.focus(); 
							return false; 
						} 
					} 
					if((Number(month)==4||Number(month)==6||Number(month)==9||Number(month)==11)&&(Number(day)>30)){ 
						alert("���ڱ�����01��30֮��");
						checktext.focus(); 
						return false; 
					} 
				}
			}else{
				alert(msg);
				checktext.focus();
				return false;
			}
			if((gthree==" ")&&(gfour==":")&&(gfive==":")){
				if( Number(hour)<0 || Number(hour)>23 ) { 
					alert("Сʱ������0��23֮��!"); 
					checktext.focus();
					return false; 
				} 
				if(Number(minute)<0 || Number(minute)>59){ 
					alert("���ӱ�����0��59֮��!");
					checktext.focus(); 
					return false; 
				}
				if(Number(second)<0 || Number(second)>59){ 
					alert("�������0��59֮��!");
					checktext.focus(); 
					return false; 
				}
			}else{
				alert(msg);
				checktext.focus();
				return false;
			}
		}else{
			alert(msg);
			checktext.focus();
			return false;
		}
	}else{
		return true;
	}
	return true;
}
//ȥ������
function delFormat(str){
	  return str.replace(/,/g,"");
	} 
//ֻ�������������ַ���Ӣ����ĸ������
function   checkName(str) 
{ 
var   pattern   =   /^[a-z\d\u4E00-\u9FA5]+$/i; 
if   (pattern.test(str)) 
	return true;
else 
	return false;
} 
function CheckSpecialCode(str){
	var myReg = /^[^@\/\'\\\"#$%&\^\*,]+$/;
    if(myReg.test(str)) return true; 
    return false; 

}
function compareTime(startDate, endDate) 
{    
	 if (startDate.length > 0 && endDate.length > 0) 
	 {    
	    var startDateTemp = startDate.split(" ");    
	    var endDateTemp = endDate.split(" ");    
	                    
	    var arrStartDate = startDateTemp[0].split("-");    
	    var arrEndDate = endDateTemp[0].split("-");    
	   
	    var arrStartTime = startDateTemp[1].split(":");    
	    var arrEndTime = endDateTemp[1].split(":");    
	   
	    var allStartDate = new Date(arrStartDate[0], arrStartDate[1], arrStartDate[2], arrStartTime[0], arrStartTime[1], arrStartTime[2]);    
	    var allEndDate = new Date(arrEndDate[0], arrEndDate[1], arrEndDate[2], arrEndTime[0], arrEndTime[1], arrEndTime[2]);    
	                    
	    if (allStartDate.getTime() > allEndDate.getTime()) 
	    {    
	        alert("��ʼʱ�䲻�ܴ��ڽ���ʱ��");    
	        return false;    
	    } else
	    {    
	    	return true;    
	    }    
	} else 
	{    
	    alert("ʱ�䲻��Ϊ��");    
	    return false;    
	 }    
} 
function parseInteger(strnum)
{
	
	if(isNaN(parseInt(strnum)))
		return 0;
	else
		return 	parseInt(strnum);	
}
function parseFloatValue(strnum)
{
	
	if(isNaN(parseFloat(strnum)))
		return 0;
	else
		return 	parseFloat(strnum);	
}