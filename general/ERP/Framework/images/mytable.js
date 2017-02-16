// Input 0
/**
 * get element
 * document.getElementById�ķ�װ
 * ����������֧��getElementById�����򷵻�null
 */
function _getElementById(a)
{
	return document.getElementById?document.getElementById(a):null
}
/**
 * get elements tag name
 * document.getElementsByTagName�ķ�װ
 * ����tagName�������飬*��������tag��
 * ����������֧��getElementsByTagName�������򷵻ؿ�����
 */
function _getElementsByTagName(a)
{
	return document.getElementsByTagName?document.getElementsByTagName(a):new Array()
}

//��־������Ƿ�ΪSafari
var isSafari=navigator.userAgent.indexOf("Safari")>=0;

/**
 * һ����׼��colArrayAX�滻ҳ�����ݵ䷶
 * ����aΪ��ַ��aaΪ�ص�������
 */
function _sendXMLRequest(theURL,aa)
{
	var xmlHttpObj=getXMLHttpObj();
	if(!xmlHttpObj||isSafari&&!aa)
	{//��������������չ�
		(new Image()).src=theURL;
	}
	else
	{//���������������XMLHTTP��ʾ����
		xmlHttpObj.open("GET",theURL,true);
		if(aa)
		{
//			xmlHttpObj.onreadystatechange=function(){if(xmlHttpObj.readyState==4){alert(xmlHttpObj.responseText)}}
		}
		xmlHttpObj.send(null);
	}
}
/**
 * �õ�һ�����õ�XMLHttpRequest����
 */
function getXMLHttpObj()
{
	var a=null;
	if(window.ActiveXObject)
	{
		a=new ActiveXObject("Msxml2.XMLHTTP");
		if(!a)
		{
			a=new ActiveXObject("Microsoft.XMLHTTP");
		}
	}
	else if(window.XMLHttpRequest)
	{
		a=new XMLHttpRequest();
	}
	return a;
}

function _del(a)
{
	msg="ȷ�ϲ�����������ʾ��ģ��ô?\n\n������ͨ���������-�Զ�������ָ���ʾ";
  if(window.confirm(msg))
  {
	  var module=_getElementById("module_"+a);
	  if(module)
	    module.style.display="none";
	  aI();
	}
	return false
}

/**
 * ����CSS����class����Ϊa��aa�Զζ���ֵΪab
 * ����setCSSAttrib("medit","display", "none");
 * �����.media��display����Ϊnone
 *
 */
function setCSSAttrib(clasName,attrName,attrValue)
{
	if(document.styleSheets)
	{//�������styleSheets������CSS�б��޸�
		clasName="."+clasName;
		for(var i=0;i<document.styleSheets.length;i++)
		{
			var classI=document.styleSheets[i];
			var rulesI=classI.rules;
			if(!rulesI)
			{
				rulesI=classI.cssRules;
				if(!rulesI){return}
			}
			for(var j=0;j<rulesI.length;j++)
			{
				if(rulesI[j].selectorText.toLowerCase()==clasName.toLowerCase())
				{
					rulesI[j].style[attrName]=attrValue
				}
			}
		}
	}
	else
	{//�������֧��styleSheets��һ��Ԫ��һ��Ԫ�ص��Ҳ��޸�-_-b
		var elementI=_getElementsByTagName("*");
		for(var i=0;i<elementI.length;i++)
		{
			if(elementI[i].className==clasName)
			{
				elementI[i].style[attrName]=attrValue
			}
		}
	}
}


var aC="";

var _pnlo;
var _mod;
var ay=false;

function _upc()
{
//	setCSSAttrib("medit","display",_pnlo||_uli?"":"none");
//	setCSSAttrib("panelo","display",_pnlo?"":"none");
//	setCSSAttrib("panelc","display",_pnlo?"none":"");
//	setCSSAttrib("mod","display",_mod?"":"none");
//	setCSSAttrib("unmod","display",_mod?"none":"");
	//���_plΪtrue������_uli��_pnlo��һ��Ϊtrue��������mttl CSS�������״Ϊ�ƶ�
	//���ay��Ϊfalse�����idΪc_1��c_2��c_3��������Ԫ�ع���һ�����飬����initHead()����
	//initHead()���������c_1��c_2��c_3������Ԫ���µ�����id��_h��β����Ԫ��������ק�¼�����
	//Ȼ���ay����Ϊtrueȷ��initHead()����ֻ����һ�Ρ�֮���mttl CSS���������״Ϊmove
//	if(_pl&&(_uli||_pnlo))
	{
		if(!ay)
		{
			initHead([_getElementById("col_l"),_getElementById("col_r")]);
			ay=true
		}
		setCSSAttrib("TableHeader","cursor","move")
	}
}

var aq=0;

var colArray=[];
var ap=0;
var am=null;

/**
 * ���amΪnull����am����Ϊ<div>��ǩ����ʱ�Ȳ���ʾ�������״Ϊmove��
 * ����Ϊ��ɫ���ײ�paddingΪ0px��ֱ�Ӵ�����<body>�¡���󷵻�am
 */
function createDiv()
{
	if(!am)
	{
		am=document.createElement("DIV");
		am.style.display="none";
		am.style.position="absolute";
		am.style.cursor="move";
		am.style.backgroundColor="#ffffff";
		am.style.paddingBottom="0px";
		document.body.appendChild(am)
	}
	return am
}

/**
 * ���Ĵ���
 * al������һ����������һ������obj��Ĭ��Ϊnull����init/start/drag/end/fixE�������
 * init() ---- ���ó�ʼ����
 *	����Ԫ��a��onmousedown�¼���ӦΪal.start������������am���Ǹ�ֱ��������
 * 	<body>������<div>���������ҳ�����Ͻǣ����û�����ù��Ļ�����������a�Ŀ���ק
 * 	�¼�
 * start() --- ��ק��ʼ�¼�
 * 	����ȫ�ֱ���aa��al.objΪ�¼�Դ��ͬһʱ��ֻ����һ��box��drag״̬�����õ�����div
 * 	Ԫ�ص�����͵�ǰ�¼���������꣬�ص�aa������initHead()������ע���onDragStart()��������
 *	����div������ã��ƶ������λ�ã�������ǰ��������¼��aa�����С���������ƶ�
 * 	�¼���Ӧ�����̧���¼���Ӧ��
 * drag() ---- ��ק���¼�
 * 	����ȫ�ֱ���aaΪ�¼�Դ���õ���ǰ���������ƶ��е�div��λ�ã����ϴ�����������
 * 	�����ƫ�������޸��ƶ��е�div�����ꡣ��¼��굱ǰλ�ã��ص�aa��onDrag()����������
 * 	al.objΪnull���ȴ��¸�box���ƶ���
 * end() ----- ��ק�����¼�
 * 	����onmousemove��onmouseup����Ӧ�¼����ص�aa��onDragEnd()������
 * fixE()
 * 	ȷ������������ԣ���֤����aΪevent�¼����������¼���layerX/Y���ƺ�û���ô���
 */
var al = {"obj":null,
	"init":function(a){
		a.onmousedown=al.start;
		if ( isNaN(parseInt(createDiv().style.left)) ) {
			createDiv().style.left="0px";
		}
		if ( isNaN(parseInt(createDiv().style.top)) ) {
			createDiv().style.top="0px";
		}
		a.onDragStart=new Function();
		a.onDragEnd=new Function();
		a.onDrag=new Function()
		},
	"start":function(a){
		var aa=al.obj=this;
		a=al.fixE(a);
		var ab=parseInt(createDiv().style.top);
		var ac=parseInt(createDiv().style.left);
		aa.onDragStart(ac,ab,a.clientX,a.clientY);
		aa.lastMouseX=a.clientX;
		aa.lastMouseY=a.clientY;
		document.onmousemove=al.drag;
		document.onmouseup=al.end;
		return false
		},
	"drag":function(a){
		a=al.fixE(a);
		var aa=al.obj;
		var ab=a.clientY;
		var ac=a.clientX;
		var ad=parseInt(createDiv().style.top);
		var ae=parseInt(createDiv().style.left);
		var af,ag;
		af=ae+ac-aa.lastMouseX;
		ag=ad+ab-aa.lastMouseY;
		createDiv().style.left=af+"px";
		createDiv().style.top=ag+"px";
		aa.lastMouseX=ac;
		aa.lastMouseY=ab;
		aa.onDrag(af,ag,a.clientX,a.clientY);
		return false
		},
	"end":function(){
		document.onmousemove=null;
		document.onmouseup=null;
		al.obj.onDragEnd(parseInt(createDiv().style.left),parseInt(createDiv().style.top));
		al.obj=null
		},
	"fixE":function(a){
		if (typeof a=="undefined") {
			a=window.event;
		}
		if (typeof a.layerX=="undefined") {
			a.layerX=a.offsetX;
		}
		if (typeof a.layerY=="undefined") {
			a.layerY=a.offsetY;
		}
		return a
		}
};

var aw=false;
/**
 * �������������������б�����϶�����Ԫ�ؼ�����ק�¼���Ӧ���롣
 * ������ִֻ��һ�Σ�awΪtrueʱ����ֱ�ӷ��ء�
 * �Ե�һ��c_1���ڶ���c_2��������c_3����ʼ���á�ÿһ���¾�������idΪm_x��<div>��ǩ
 * ÿһ��<div>��ǩ���ݾ�Ϊһ��<table>����table����һ��<td>����Ϊm_x_h������ǿɿ���ק��
 * ���⡣�õ����<td>Ԫ�أ�������ק�¼����룬���Ǳ����������á�
 */
function initHead(a)
{
	if(aw)return;
	aw=true;
	//����ȫ�ֱ���colArrayΪ��ǰҪ����������飬Ҳ������idΪc_1��c_2��c_3��<td>Ԫ��
	colArray=a;
	//����colArray�е�ÿ��Ԫ�ض�Ҫִ�С���ʵ����colArrayֻ������Ԫ�أ�c_1��c_2��c_3��Ҳ����һ/��/����
	for(var i=0;i<colArray.length;i++)
	{//������c_x���ӽ���������ʵҲ��������Ϊm_x��div��ǩ�����һ��div��ǩ�������ô���
		//�ʴ˴�length-1
		for(var j=0;j<colArray[i].childNodes.length-1;j++)
		{
			var module_i=colArray[i].childNodes[j];
			var head_i=_getElementById(module_i.id+"_head");
			if(!head_i)
				continue;

			//�˿̣��Ѿ��õ���idΪm_x_h��<td>Ԫ�أ���box�ı���td
			//��������<div>��¼��ad�����module�����У����module�����ǣ�������
			head_i.module=module_i;
			//��al�����init������ʼ������ק����td��
			al.init(head_i);

			//�õ�m_x_h��<a>Ԫ�أ���idΪm_x_url��<a>
			var url_i=_getElementById(module_i.id+"_url");
			if(url_i)
			{//����<a>��h����Ϊad�����ϲ�����<td>Ԫ�أ�,���h�����ǣ�������
				url_i.h=head_i;
				//���������ӱ����У������ϲ����<td>��href��target����
				//Ϊ��ǰ�������ӵ�href��target���ԡ������û�Ҳ�����ϳ�������
				url_i.onmousedown=function() {
					this.h.href=this.href;
					this.h.target=this.target;
				}
			}

			var more_i=_getElementById(module_i.id+"_more");
			if(more_i)
			{
			   more_i.module=module_i;
			   more_i.onmouseover=function() {var op_i=_getElementById(this.module.id+"_op");if(op_i) op_i.style.display="";}
			   more_i.onmouseout =function() {var op_i=_getElementById(this.module.id+"_op");if(op_i) op_i.style.display="none";}
			}

			//���Ĵ��룺��ק��ʼ�ص�����
			//�رն�ʱ����ͨ��֮ǰ��¼��module���Եõ�������<div>Ԫ�أ�����aA()
			//������������box��ƫ��ֵ����¼
			head_i.onDragStart=function(af,ag) {
					//�رն�ʱ��
					clearInterval(ap);
					//ͨ��֮ǰ��¼��module���Եõ�������box��<div>Ԫ��
					var module_i=this.module;
					//����ҳ������������box��ƫ��ֵ
					aA(module_i);
					//����һ��box��<div>Ԫ�ؼ�¼����
					module_i.origNextSibling=module_i.nextSibling;
					//�õ��ƶ���<div>��ָ�������λ�ã�������״̬��ʾ����
					//ʹ��alpha filter��͸��������Ϊ80,�������ݺ�CSS

					//createDiv()����һ��DIV
					var module_i_copy=createDiv();
					module_i_copy.style.left=getOffset(module_i,true);
					module_i_copy.style.top=getOffset(module_i,false);
					module_i_copy.style.height=module_i.offsetHeight;
					module_i_copy.style.width=module_i.offsetWidth;
					module_i_copy.style.display="block";
					module_i_copy.style.opacity=0.8;
					module_i_copy.style.filter="alpha(opacity=80)";
					module_i_copy.innerHTML=module_i.innerHTML;
					module_i_copy.className=module_i.className;
					//����draggedΪfalse
					this.dragged=false
				};

			//���Ĵ��룺��ק�лص�����
			//ȫ����aG����ʵ����ק�����е��ƶ��͡���λ��
			head_i.onDrag=function(af,ag) {
				setModulePos(this.module,af,ag);
				//����draggedΪtrue
				this.dragged=true
				};

			//���Ĵ��룺��ק��������
			head_i.onDragEnd=function(af,ag) {
					if (this.dragged) {
						//����ק߷�����ö�̬��λЧ������box��������
						ap=aD(this.module,150,15)
					} else {
						//box����������߷һ�³������ӣ���Ҫ�ṩ����
						//�ĳ������ӱ����Ч��
						ax();
						if (this.href) {
							if (this.target){
								window.open(this.href,this.target)
							} else {
								document.location=this.href
							}
						}
					}
					this.target=null;
					this.href=null;
					//��ק�������һ����ȡ��box�ڵ�����
					if (this.module.nextSibling!=this.module.origNextSibling) {
						aI()
					}
				}
		}//second for end
	}//first for end
}
/**
 * ���ظ�������ק�ƶ���<div>Ԫ��
 */
function ax()
{
	createDiv().style.display="none"
}
/** ������ק�������box��̬��λЧ��
 */
function aD(a,aa,ab)
{
	var ac=parseInt(createDiv().style.left);
	var ad=parseInt(createDiv().style.top);
	var ae=(ac-getOffset(a,true))/ab;
	var af=(ad-getOffset(a,false))/ab;
	return setInterval(function(){if(ab<1){clearInterval(ap);ax();return}ab--;ac-=ae;ad-=af;createDiv().style.left=parseInt(ac)+"px";createDiv().style.top=parseInt(ad)+"px"},aa/ab)
}
/**
 * ȫ�ֱ���colArrayΪ��c_1��c_2��c_3���飨Ҳ������<td>Ԫ�أ�
 * �������п��ƶ��Ĵ�box����<div>������ҳ����ߵ�ƫ������
 * ����ҳ���Ϸ���ƫ���������ڵ�ǰ��ק��box�������������У�
 * �������������<div>��pagePosTopֵ��Ҫ��ȥ��ǰ��קbox�ĸ߶�
 */
function aA(a)
{
	for(var aa=0;aa<colArray.length;aa++)
	{
		var ab=0;
		for(var ac=0;ac<colArray[aa].childNodes.length;ac++)
		{
			var ad=colArray[aa].childNodes[ac];
			if(ad==a)
				ab=ad.offsetHeight;
			ad.pagePosLeft=getOffset(ad,true);
			ad.pagePosTop=getOffset(ad,false)-ab
		}
	}
}
/**
 * �õ�ĳһԪ�ؾ���ҳ����߻��ϱߵ�ƫ����
 */
function getOffset(obj,isLeftOffset)
{
	var offsetValue=0;
	while(obj!=null)
	{
		offsetValue+=obj["offset"+(isLeftOffset?"Left":"Top")];
		obj=obj.offsetParent
	}
	return offsetValue
}
/**
 * ���Ĵ��룬��ק�д�����������aΪbox����<div>Ԫ�أ���aa��abΪƫ����
 */
function setModulePos(obj,posLeft,posTop)
{
	var module=null;
	var ad=100000000;

	//��ÿһ�б���
	for(var i=0;i<colArray.length;i++)
	{//��ÿһ��<div>box����
		for(var j=0;j<colArray[i].childNodes.length;j++)
		{
			var module_i=colArray[i].childNodes[j];
			//���������ƶ��е�box������������
			if(module_i==obj)
				continue;
			//����ĳЩƫ����
			var ai=Math.sqrt(Math.pow(posLeft-module_i.pagePosLeft,2)+Math.pow(posTop-module_i.pagePosTop,2));
			if(isNaN(ai))
				continue;
			if(ai<ad)
			{
				ad=ai;module=module_i
			}
		}
	}

	//���ʵ���λ������ӵ�ǰ�ƶ��е�box
	if(module!=null&&obj.nextSibling!=module)
	{
		module.parentNode.insertBefore(obj,module);
		//TODO: ���д��������ʲô����
		DisplayModule(obj)
	}
}
/**
 * ��ҳ������ʾ����a�ĸ��ڵ�
 * TODO: ��һ�д�����ʲô�ã�
 */
function DisplayModule(obj)
{
	obj.parentNode.style.display="none";
	obj.parentNode.style.display=""
}
/**
 * ����Ҫȡ�����ݵ�URL
 */
function aI()
{
	var a="";
	for(var i=0;i<colArray.length;i++)
	{
		a+=a!=""?":":"";
		for(var j=0;j<colArray[i].childNodes.length-1;j++)
		{
			var module=colArray[i].childNodes[j];
			if(module.id=="" || module.style.display=="none")
			   continue;
			a+=module.id.substring(7)+",";
		}
	}
	_sendXMLRequest("/general/person_info/mytable/dragconfig.php?MYTABLE="+escape(a),null)
}
