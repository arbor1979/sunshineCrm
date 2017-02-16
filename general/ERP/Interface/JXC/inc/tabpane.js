
/*****************************
*    ÖØÔØ·½·¨                 *
******************************/
function doTabPaneClick(item){
}

/*****************************
*    tabpane                 *
******************************/
function TabPane(name, width, height){
	this._name = name;
	this._items = new Array();
	this._selectedItem = null;
	this._target = null;
//  this._targetWindow = window;
	this._firstLoadNumber = null;
	if(width != null)
		this._width = width;
	else 
		this._width = "80%";
		
	if(height != null)
		this._height = height;
	else 
		this._height = "40%";	

	this.initTable();
}
_p = TabPane.prototype;
_p.addItem = function (item){
	this._items[this._items.length] = item;
	this._frameCell.appendChild(item._iframe);

	item.setPane(this);
}

_p.appendItem = function (item){
	this.insertItemAt(item, this._items.length);
}

_p.insertItemAt = function (item, n){
	this._items.insertAt(item, n);

	this._frameCell.appendChild(item._iframe);

	item.setPane(this);
	item.load();
	item.unSelect();
}

_p.insertBefore = function (item, refItem){
	this.insertItemAt(item, this._items.indexOf(refItem));
}

_p.remove = function (n){
	var item = this._items[n];

	this._headCell.removeChild(item._object);
	this._frameCell.removeChild(item._iframe);

	var nitem = null;
	if(this._selectedItem == item){
		if(this._items.previousItem(item) != null)
			nitem = this._items.previousItem(item);
		else if(this._items.nextItem(item) != null)
			nitem = this._items.nextItem(item);
		this._selectedItem = null;
	}

	this._items.removeAt(n);
	if(nitem != null)
		this.selectItem(nitem);

	if(this._selectedItem != null && this._selectedItem.getNumber() == 0)
		this._headCell.style.paddingLeft = "0px";
}

_p.removeItem = function (item){
	this.remove(this._items.indexOf(item));
}

_p.setTargetWindow = function(w){
	this._targetWindow = w;
}

_p.setTarget = function(name){
	this._target = name;
}

_p.getTargetWindow = function(){
	return this._targetWindow;
}

_p.setLoadNumber = function(n){
	this._firstLoadNumber = n;
}

_p.loadPane = function(){
	var n = 0;
	for(var i=0; i<this._items.length; i++){
		this._items[i].load();
	}
	
//	this.createDivIframe();
	if(parseInt(this._firstLoadNumber) >= 0)
		n = parseInt(this._firstLoadNumber);
	this.selectItemByNumber(n);

}

_p.initTable = function(){
	var w0 = "1px", w1 = "2px";
	var str = '<table  width="' 
			+ this._width + '" height="' 
			+ this._height + '" border="0" cellspacing="0" cellpadding="0">'
			+ '<tr><td colspan="5"></td></tr>'
			+ '<tr><td colspan="5"><div style="width:100%;height:' + w0 + ';" class="Tabpane-Pane"></div></td></tr>'
			+ '<tr><td rowspan="4"><div style="width:' + w0 + ';height:100%;" class="tabpane-pane"></div></td>'
			+ '<td colspan="3"><div style="width:100%;height:' + w1 + ';" class="tabpane-pane0"></div></td>'
			+ '<td rowspan="4"><div style="width:' + w0 + ';height:100%;" class="tabpane-pane"></div></td></tr>'
			+ '<tr height="100%"><td><div style="width:' + w1 + ';height:100%;" class="tabpane-pane0"></div></td>'
			+ '<td width="100%"></td>'
			+ '<td><div style="width:' + w1 + ';height:100%;" class="tabpane-pane0"></div></td></tr>'
			+ '<tr><td  colspan="3"><div style="width:100%;height:' + w1 + ';" class="tabpane-pane0"></div></td></tr>'
			+ '<tr><td colspan="5"><div style="width:100%;height:' + w0 + ';" class="tabpane-pane"></div></td></tr>';
	var t = tpCreateElementWithHTML(str);
	
	this._table = t;
	this._headCell = t.tBodies[0].rows[0].cells[0];
	this._frameCell = t.tBodies[0].rows[3].cells[1];
	tpAppendObject(t);
}

_p.createDivIframe = function(){
	var str;
//	str = '<div class="tabpane-frame"></div>';
//	var obj = tpCreateElementWithHTML(str);
	str = '<iframe name="' 
		+ this._name + '" src="about:blank" scrolling="auto" width="100%" height="100%" frameborder="0" allowTransparency="true"></iframe>'
	var ifr = tpCreateElementWithHTML(str);
//	obj.appendChild(ifr);
	this._frameCell.appendChild(ifr);
	this._targetWindow = ifr;
}

_p.getSelectedItem = function(){
	return this._selectedItem;
}

_p.selectItem = function(item){
	this.selectItemByNumber(this.items.indexOf(item));
}

_p.selectItemByNumber = function(n){
	var item = this._items[n];
	var pitem = this.getSelectedItem();
	if(item == pitem)
		return;
	if(pitem != null)
		pitem.refresh();
	item.refresh();
	this._selectedItem = item;
}

/*****************************
*    tab       item          *
******************************/
function TabItem(name, text, url){
	if(TabItem.arguments.length <= 2){
		this._text = name;
		this._url = text;
	}else{
		this._name = name;
		this._text = text;
		this._url = url;
	}

	this._status = TabItem.UNSELECTED;
	this._pane = null;
	
	this._object = null;
	this._initIframe();
	this._clicked = false;
}
_p = TabItem.prototype;

_p._initIframe = function(){
	var str;
	str = '<iframe allowTransparency="true" style="visibility:hidden;position:absolute;z-index:-10;" name="' 
		+ this._name + '" src="" scrolling="auto" width="100%" height="100%" frameborder="0"></iframe>'
	var ifr = tpCreateElementWithHTML(str);
//	this._frameCell.appendChild(ifr);
	this._iframe = ifr;
//	this._iframe.style.display = "none";
	return ifr;
}

_p.getNumber = function(){
	return this._pane._items.indexOf(this);
}

_p.setPane = function(p){
	this._pane = p;
}

_p.getPane = function(){
	return this._pane;
}

_p.getSelectedHtml = function(){
	var str = "";
	str += '<label unselectable="on" class="tabpane-selected">' + this._text + '</label>';
	return str;
}

_p.getSelectedObject = function(){
	var obj = tpCreateElementWithHTML(this.getSelectedHtml());
	obj.attachEvent("ondblclick", _tiDblClickEvent);
	obj.TabItem = this;
	return obj;
}

_p.getUnSelectedHtml = function(){
	var str = "";
	str += '<label unselectable="on" class="tabpane-unselected">' + this._text + '</label>';
	return str;
}

_p.getUnSelectedObject = function(){
	var obj = tpCreateElementWithHTML(this.getUnSelectedHtml());
	obj.TabItem = this;
	obj.attachEvent("onclick", _tiClickEvent);
	return obj;
}

_p.load = function(){
	this._object = this.getUnSelectedObject();
	var refItem = this._pane._items[this._pane._items.indexOf(this)+1];
	var refObj = null;
	if(refItem != null)
		refObj = refItem._object;
	this._pane._headCell.insertBefore(this._object, refObj);
}

_p.reload = function(){
	this._execUrl(this._url);
}

_p.select = function(){
	var obj = this.getSelectedObject();
	var pobj = this._object;
	pobj.parentNode.replaceChild(obj, pobj);
	this._object = obj;
	/*
	if(this._url != null)
		this._pane.getTargetWindow().src = this._url;
		*/
	if(this._clicked == false){
		this._execUrl(this._url);
		this._clicked = true;
	}
	this._iframe.style.visibility = 'visible';
	this._iframe.style.zIndex = 10;

	if(this.getNumber() == 0)
		this._pane._headCell.style.paddingLeft = "0px";
		
	doTabPaneClick(this);
}

_p._execUrl = function(url){
	if(typeof url == "string"){
		//var info_url =url+ "&idcard=" + document.form1.idcard.value;
		//
		//var info_url =url+ "&" + document.form1.param_name.value + "=" + document.form1.param_value.value;
		var info_url = url;
		//alert(info_url);
		this._iframe.src = info_url;
	}else if(typeof url == "function"){
		url(this._iframe);
	}
}

_p.unSelect = function(){
	var obj = this.getUnSelectedObject();
	var pobj = this._object;
	pobj.parentNode.replaceChild(obj, pobj);

	this._iframe.style.visibility = 'hidden';
	this._iframe.style.zIndex = -10;

	if(this.getNumber() == 0)
		this._pane._headCell.style.paddingLeft = "3px";	
	this._object = obj;	
}

_p.refresh = function(){
	if(this._status == TabItem.UNSELECTED)
		this.select();
	else
		this.unSelect();
	this._status = 1 - this._status;
}

TabItem._findTabItem = function(o){
	var p = o;
	if(p != null && p.tagName != "BODY"){
		if(p.TabItem != null)
			return p.TabItem;
		p = p.parentNode;
	}
	
	return null;
}

TabItem.UNSELECTED = 0;
TabItem.SELECTED = 1;

/*****************************
*    tabitem event handler   *
******************************/
function _tiClickEvent(e){
	var item = TabItem._findTabItem(e.srcElement);
	var pane = item.getPane();
	pane.selectItemByNumber(item.getNumber());
	
	if (tp._items.indexOf(item)!=0){
		item.reload();
	}
}

function _tiDblClickEvent(e){
	var item = TabItem._findTabItem(e.srcElement);
	item.reload();
}

/*****************************
*    functions               *
******************************/
function tpAppendObject(obj){
	var magicnumber = "append-78242-231231";
	document.writeln('<div id="' + magicnumber + '"></div>');
	var a = document.getElementById(magicnumber);
	
	a.parentNode.replaceChild(obj, a);
}

function tpCreateElementWithHTML(str){
	var d = document.createElement("DIV");
	d.innerHTML = str;
	
	return d.childNodes[0];
}
