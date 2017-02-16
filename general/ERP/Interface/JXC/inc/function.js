
/*****************************************************
*                                                    *
*                     日期处理函数                   *
*                                                    *
*****************************************************/
Date.prototype.toString = function(){
	return getDateString(this);
}
	
function getDateArray(datestr){
	var arr = datestr.split("-");
	arr[1] = arr[1].replace(/^0(\d)/, "$1");
	arr[2] = arr[2].replace(/^0(\d)/, "$1");
	return [parseInt(arr[0]),parseInt(arr[1])-1,parseInt(arr[2])];
}

function getDateByStr(dstr){
	var arr = getDateArray(dstr);
	return new Date(arr[0],arr[1],arr[2]);
}

function getDateString(d){
	var dstr = d.getYear() + "-";
	if( (d.getMonth()+1) < 10 )
		dstr += "0";
	dstr += d.getMonth()+1;
	dstr += "-";
	if( d.getDate() < 10)
		dstr += "0";
	dstr += d.getDate();
	return dstr;
}

function getPreviousDate(dstr){
	var arr = getDateArray(dstr);
	var d = new Date(arr[0],arr[1],arr[2]-1);
	return d.getYear()+"-"+(d.getMonth()+1)+"-"+d.getDate();
}

function getNextDate(dstr){
	var arr = getDateArray(dstr);
	var d = new Date(arr[0],arr[1],arr[2]+1);
	return d.getYear()+"-"+(d.getMonth()+1)+"-"+d.getDate();
}

function getCurrentDate(){
	return getDateString(new Date());
}

function getCurrentTime(){
	var d = new Date();
	var s = "";
	s += d.getHours();
	s += ":";
	if( d.getMinutes() < 10 )
		s += "0" + d.getMinutes();
	else
		s += d.getMinutes();	
	s += ":";
	if( d.getSeconds() < 10 )
		s += "0" + d.getSeconds();
	else
		s += d.getSeconds();	

	return s;
}
/*****************************************************
*                                                    *
*                     DOM functions                  *
*                                                    *
*****************************************************/
function findParentNodeByTagName(obj, tagname){
	var p = obj;
	while(p != null && p.tagName != "BODY"){
		if(p.tagName == tagname)
			return p;
		p = p.parentNode;
	}
	return null;
}

function findChildNodesByTagName(obj, name){
	return obj.getElementsByTagName(name);
}

function findChildNodeByTagName(obj, name){
	return findChildNodesByTagName(obj, name)[0];
}

function setSelectObjectByIndex(selObj, index){
	selObj.options[index].selected = true;
}

function setSelectObjectByText(selObj, text){
	var v = null;
	for(var i=0; i<selObj.options.length; i++){
		selObj.options[i].selected = false;
		if(selObj.options[i].text == text){
			selObj.options[i].selected = true;
			v = selObj.options[i].value;
		}
	}
	return v;
}

function getSelectObjectText(selObj){
	return selObj.options[selObj.selectedIndex].text;
}
function getSelectObjectValue(selObj){
	return selObj.options[selObj.selectedIndex].value;
}
/*****************************************************
*                                                    *
*                     金额处理函数                   *
*                                                    *
*****************************************************/
function getFloatValue(v){
	var ret = parseFloat((v+"").trim());
	if(ret == null || isNaN(ret) == true)
		return 0;
	return ret;
}

/* 转换String到Float,保存两位精度 */		
function getMoneyValue(str){
	return getFloatValue(str.replace(/,/g, ''));
}

/* 转换参数(可以是字符串或者数字)到逗号分隔的金额格式 */		
function formatMoneyValue(value){
	var a = String(parseFloat(String(value)).toFixed(2));
	
	var rn = /^\d{1,3}(,\d{3})*\.\d\d$/;
	if(rn.test(a))
		return a;

	var r1 = /\d{4}\./;
	if(r1.test(a))
		a = a.replace(/(\d)(\d{3}\.)/,"$1,$2");
	else
		a = a.replace(/(\d)(\d{3})$/, "$1,$2");
	var r2 = /\d{4},/;
	while(r2.test(a))
		a = a.replace(/(\d)(\d{3},)/, "$1,$2");
	return a;
}
/*****************************************************
*                                                    *
*                     form处理函数                   *
*                                                    *
*****************************************************/

function disableForm(form){
	for(var i=0; i<form.elements.length; i++)
		form.elements[i].disabled = true;
}

function enableForm(form){
	for(var i=0; i<form.elements.length; i++)
		form.elements[i].disabled = false;
}

function disableElement(obj){
	if(obj.disabled == true)
		return;
	obj.disabled = true;
	obj._do1 = true;
}

function enableElement(obj){
	if(obj._do1 != true)
		return;
	obj.disabled = false;
	obj._do1 = null;
}

function disableDocument(){
	var ret;

	ret = document.getElementsByTagName("INPUT");
	for(var i=0; i<ret.length; i++)
		disableElement(ret[i]);
	ret = document.getElementsByTagName("SELECT");
	for(var i=0; i<ret.length; i++)
		disableElement(ret[i]);
	ret = document.getElementsByTagName("BUTTON");
	for(var i=0; i<ret.length; i++)
		disableElement(ret[i]);
}

function enableDocument(){
	var ret;

	ret = document.getElementsByTagName("INPUT");
	for(var i=0; i<ret.length; i++)
		enableElement(ret[i]);
	ret = document.getElementsByTagName("SELECT");
	for(var i=0; i<ret.length; i++)
		enableElement(ret[i]);
	ret = document.getElementsByTagName("BUTTON");
	for(var i=0; i<ret.length; i++)
		enableElement(ret[i]);
}
/*****************************************************
*                                                    *
*                     杂类函数                       *
*                                                    *
*****************************************************/
function getExceptionInfo(exception){
	var ret = new Object();
	var re = /^([^:]*):\s(.*)$/;
	
	var arr = exception.match(re);
	ret.type = arr[1];
	ret.msg = arr[2];
	return ret;
}

/*****************************************************
*                                                    *
*                     扩展Array方法                      *
*                                                    *
*****************************************************/
Array.prototype.indexOf=function(o){
	for(var i=0;i<this.length;i++){
		if(this[i]==o)
			return i;
	}
	return-1;
};
Array.prototype.lastIndexOf=function(o){
	for(var i=this.length-1;i>=0;i--){
		if(this[i]==o)
			return i;
	}
	return-1;
};
Array.prototype.contains=function(o){
	return this.indexOf(o)!= -1;
};
Array.prototype.copy=function(o){
	return this.concat();
};
Array.prototype.insertAt=function(o,i){
	this.splice(i,0,o);
};
Array.prototype.insertBefore=function(o,o2){
	var i=this.indexOf(o2);
	if(i== -1)
		this.push(o);
	else 
		this.splice(i,0,o);
};
Array.prototype.removeAt=function(i){
	this.splice(i,1);
};
Array.prototype.remove=function(o){
	var i=this.indexOf(o);if(i!= -1)
		this.splice(i,1);
};
Array.prototype.previousItem = function(o){
	var i = this.indexOf(o);
	if(i > 0)
		return this[i-1];
	return null;
}
Array.prototype.nextItem = function(o){
	var i = this.indexOf(o);
	if((i+1) < this.length)
		return this[i+1];
	return null;
}
