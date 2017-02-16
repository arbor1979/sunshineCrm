function miaovAddEvent(oEle, sEventName, fnHandler)
{
	if(oEle.attachEvent)
	{
		oEle.attachEvent('on'+sEventName, fnHandler);
	}
	else
	{
		oEle.addEventListener(sEventName, fnHandler, false);
	}
}
var oDiv;
var main;
window.onload = function()
{
	main=window.parent.parent.frames["table_index"];
	while(main.document.all.miaov_float_layer=="undefine")
		sleep(100);
	oDiv=main.document.getElementById('miaov_float_layer');
	//var oBtnMin=document.getElementById('btn_min');
	var oBtnClose=main.document.getElementById('btn_close');
	var oDivContent=oDiv.getElementsByTagName('div')[0];
	
	var iMaxHeight=0;
	
	var isIE6=window.navigator.userAgent.match(/MSIE 6/ig) && !window.navigator.userAgent.match(/MSIE 7|8/ig);
	
	oDiv.style.display='block';
	iMaxHeight=oDivContent.offsetHeight;

	if(isIE6)
	{
		oDiv.style.position='absolute';
		repositionAbsolute();
		miaovAddEvent(window, 'scroll', repositionAbsolute);
		miaovAddEvent(window, 'resize', repositionAbsolute);
	}
	else
	{
		oDiv.style.position='fixed';
		repositionFixed();
		miaovAddEvent(window, 'resize', repositionFixed);
	}
	
	oBtnClose.onclick=function ()
	{
		oDiv.style.display='none';
	};
};

function startMove(obj, iTarget)
{
	if(obj.timer)
	{
		clearInterval(obj.timer);
	}
	obj.timer=setInterval
	(
		function ()
		{
			doMove(obj, iTarget);
		},30
	);
}

function doMove(obj, iTarget)
{
	var iSpeed=(iTarget-obj.offsetHeight)/8;
	
	if(obj.offsetHeight==iTarget)
	{
		clearInterval(obj.timer);
		obj.timer=null;
		
	}
	else
	{
		iSpeed=iSpeed>0?Math.ceil(iSpeed):Math.floor(iSpeed);
		obj.style.height=obj.offsetHeight+iSpeed+'px';
		
		((window.navigator.userAgent.match(/MSIE 6/ig) && window.navigator.userAgent.match(/MSIE 6/ig).length==2)?repositionAbsolute:repositionFixed)()
	}
}

function repositionAbsolute()
{

	var left=main.document.body.scrollLeft||document.documentElement.scrollLeft;
	var top=main.document.body.scrollTop||document.documentElement.scrollTop;
	var width=main.document.documentElement.clientWidth;
	var height=main.document.documentElement.clientHeight;
	
	oDiv.style.left=left+width-oDiv.offsetWidth+'px';
	oDiv.style.top=top+height-oDiv.offsetHeight+'px';
}

function repositionFixed()
{

	var width=main.document.documentElement.clientWidth;
	var height=main.document.documentElement.clientHeight;
	
	oDiv.style.left=width-oDiv.offsetWidth+'px';
	oDiv.style.top=height-25+'px';

}
