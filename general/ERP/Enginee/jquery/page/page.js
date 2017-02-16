jQuery.fn.jpage = function(config){
	init("#"+this.attr("id"),config);
}

function init(t,config){
	//公有变量
	var totalRecord = config.totalRecord > 0 ? config.totalRecord : 0; //总记录数																
	var perPage = config.perPage;				                               //每页显示记录数
	var ajaxUrl = config.ajaxUrl ;	                                   //数据代理地址
	var ajaxParam = config.ajaxParam;                                  //ajax的请求参数
    var dataBody = config.dataBody;                                    //数据承载容器
    var callback = config.callback;   
    var cookieName = config.cookieName;                                 //ajax成功后回调函数
    var debug;
    if(typeof config.debug == "undefined")
        debug = false;
    else
        debug = config.debug==false ? false : true;
    //alert(config.callback.constructor);
	//私有变量
	var totalPage = Math.ceil(totalRecord/perPage);	                   //总页数
	var currentPage = 1;				                                       //当前页码
	var startRecord;																									 //每页起始记录
	var endRecord;	 																									 //每页结束记录

	var toolbar = '';
	toolbar += '<div class="pgPanel">';
	toolbar += '<div>每页 <input type="text" title="输入后按回车确认" class="SmallInput pgPerPage" size="5" value="' + perPage +'"> 条</div>';
	toolbar += '<div class="separator"></div>';
	toolbar += '<div class="pgBtn pgFirst" title="首页"></div>';
	toolbar += '<div class="pgBtn pgPrev" title="上页"></div>';
	toolbar += '<div class="separator"></div>';
	toolbar += '<div>第 <input class="SmallInput pgCurrentPage" size="5" type="text" value="' + currentPage + '" title="页码" /> 页 / 共 <span class="pgTotalPage">' + totalPage + '</span> 页</div>';
	toolbar += '<div class="separator"></div>';
	toolbar += '<div class="pgBtn pgNext" title="下页"></div>';
	toolbar += '<div class="pgBtn pgLast" title="尾页"></div>';
	toolbar += '<div class="separator"></div>';
	toolbar += '<div class="pgBtn pgRefresh" title="刷新"></div>';
	toolbar += '<div class="separator"></div>';
	toolbar += '<div class="pgSearchInfo">检索到&nbsp;' + totalRecord + '&nbsp;条记录，显示第&nbsp;<span class="pgStartRecord">' + startRecord + '</span>&nbsp;条&nbsp;-&nbsp;第&nbsp;<span class="pgEndRecord">' + endRecord + '</span>&nbsp;条记录</div>';
	toolbar += '</div>';
	//alert(toolbar);
  jQuery(t).html(toolbar);

  var dataContainer =jQuery("#"+dataBody);
  
	var btnRefresh = jQuery(t+" .pgRefresh");														//刷新按钮
	var btnNext =jQuery(t+" .pgNext");																	 //下一页按钮
	var btnPrev = jQuery(t+" .pgPrev");																	//上一页按钮
	var btnFirst = jQuery(t+" .pgFirst");																//首页按钮
	var btnLast = jQuery(t+" .pgLast");																	//末页按钮
	var btnGo = jQuery(t+" .pgNext,"+t+" .pgLast");
	var btnBack = jQuery(t+" .pgPrev,"+t+" .pgFirst");
	var btn = jQuery(t+" .pgFirst,"+t+" .pgPrev,"+t+" .pgNext,"+t+" .pgLast");

	var valCurrentPage = jQuery(t+" .pgCurrentPage");
	var valStartRecord = jQuery(t+" .pgStartRecord");
	var valEndRecord =jQuery(t+" .pgEndRecord");	
	var valPerPage = jQuery(t+" .pgPerPage");
	var valTotalPage = jQuery(t+" .pgTotalPage");

	jQuery(t+" .pgPerPage").attr("value",perPage);
	getStartEnd();
	getRemoteData();


	//刷新按钮监听
	btnRefresh.bind("mousedown",pressHandler).bind("mouseup",unpressHandler).bind("mouseout",unpressHandler);

	//刷新工具栏
	refresh();
	
	//按钮监听
	btnNext.click(
		function(){
			if(currentPage < totalPage){
					currentPage += 1;
					getStartEnd();
					getRemoteData();
					refresh();
			}
		}
	);	
	btnPrev.click(
		function(){
			if(currentPage > 1){
					currentPage -= 1;
					getStartEnd();
					getRemoteData();
					refresh();
			}
		}
	);
	btnFirst.click(
		function(){
			if(currentPage > 1){
					currentPage = 1;
					getStartEnd();
					getRemoteData();
					refresh();
				}
		}
	);
	btnLast.click(
		function(){
			if(currentPage < totalPage){
					currentPage = totalPage;
					getStartEnd();
					getRemoteData();
					refresh();
			   }
		  }
	);
	btnRefresh.click(
		function(){
      perPage = parseInt(valPerPage.val());
      currentPage = 1;	
			totalPage = Math.ceil(totalRecord/perPage);
			getStartEnd();
			getRemoteData();
			refresh();
		}
	);
	
	//页码输入框监听
	valCurrentPage.keydown(
		function(){
			var targetPage = parseInt(jQuery(this).val());
			if(event.keyCode==13 && targetPage>=1 && targetPage<=totalPage){
					currentPage = targetPage;
					getStartEnd();
					getRemoteData();
					refresh();
			}
	  }
	);
	
	valPerPage.keydown(
		function(){
			if(event.keyCode==13)
			{
  			perPage = parseInt(jQuery(this).val());
  			if(perPage>99)
  			{
  				 msg='此操作会导致比较缓慢,确定要执行吗?';
           if(!window.confirm(msg))
           	 return;
        }
        else if(perPage==0 || perPage%1!=0)
        {
        	alert("请输入有效数字!");
        	return;
        }
        //存入cookie
        var exp = new Date();
        exp.setTime(exp.getTime() + 24*60*60*1000);
        document.cookie = cookieName+"="+ perPage + ";expires=" + exp.toGMTString()+";path=/";
  			currentPage = 1; //设定每页显示数量
  			totalPage = Math.ceil(totalRecord/perPage);  
  			getStartEnd();
  			getRemoteData();
  			refresh();
		  }		
		}
	);
	
	/*********************************init私有函数***************************************************/
	/**
	   * 置为正在检索状态
	   */
	function startLoad(){
		jQuery(t+" .pgRefresh").addClass("pgLoad");
		jQuery(t+" .pgSearchInfo").html("读取数据中，请稍候...");
	}
	
	/**
	   * 置为结束检索状态
	   */
	function overLoad(){
		jQuery(t+" .pgRefresh").removeClass("pgLoad");
		jQuery(t+" .pgSearchInfo").html('共&nbsp;' + totalRecord + '&nbsp;条记录，显示第&nbsp;<span class="pgStartRecord">' + startRecord + '</span>&nbsp;条&nbsp;-&nbsp;第&nbsp;<span class="pgEndRecord">' + endRecord + '</span>&nbsp;条记录');
	}

	/**
	   * 获得远程数据
	   */
	function getRemoteData(){
		if(ajaxUrl.indexOf("?")>0)
		   ajaxUrl += "&";
		else
		   ajaxUrl += "?";
		jQuery.ajax(
			{
				type: "POST",
				url: ajaxUrl + "startrecord="+startRecord+"&endrecord="+endRecord ,
				data: ajaxParam,
				cache: false,
				timeout: 30000,
				beforeSend: function(){
					startLoad();
				},
				success: function(data,msg){
					//eval(msg);
					//document.write(data);
				    if(debug)
				        alert(data);
				    dataContainer.html(data);
					refresh();
					overLoad();
					if(typeof callback=="function")
					  (callback)();
				},
				error: function(){
					alert("请求失败或超时，请稍后再试！");
					overLoad();
					return;
				}
			}
		);
	}
	
	/**
	   * 获得当前页开始结束记录
	   */
	function getStartEnd(){
			startRecord = (currentPage-1)*perPage+1;
			endRecord = Math.min(currentPage*perPage,totalRecord);
	}

	/**
	   * 刷新工具栏状态
	   */
	function refresh(){
		valCurrentPage.val(currentPage);
		valStartRecord.html(startRecord);
		valEndRecord.html(endRecord);
		valTotalPage.html(totalPage);
		
		btn.unbind("mousedown",pressHandler);
		btn.bind("mouseup",unpressHandler);
		btn.bind("mouseout",unpressHandler);
		if(totalPage==1){
			btnNext.addClass("pgNextDisabled");
			btnLast.addClass("pgLastDisabled");
			btnPrev.addClass("pgPrevDisabled");
			btnFirst.addClass("pgFirstDisabled");
		}
		else if(currentPage == totalPage){
			enabled();
			btnBack.bind("mousedown",pressHandler);
			btnNext.addClass("pgNextDisabled");
			btnLast.addClass("pgLastDisabled");
		}else	if(currentPage == 1){
			enabled();
			btnGo.bind("mousedown",pressHandler);
			btnPrev.addClass("pgPrevDisabled");
			btnFirst.addClass("pgFirstDisabled");
		}else{
			enabled();
			btnBack.bind("mousedown",pressHandler);
			btnGo.bind("mousedown",pressHandler);
			btnNext.addClass("pgNext");
			btnPrev.addClass("pgPrev");
			btnFirst.addClass("pgFirst");
			btnLast.addClass("pgLast");
		}
	}
	
	/**
	   * 移除按钮disabled状态样式
	   */
	function enabled(){
			btnNext.removeClass("pgNextDisabled");
			btnPrev.removeClass("pgPrevDisabled");
			btnFirst.removeClass("pgFirstDisabled");
			btnLast.removeClass("pgLastDisabled");
	}

	/**
	   * 添加按钮按下状态样式
	   */
	function pressHandler(){
		jQuery(this).addClass("pgPress");
	}

	/**
	   * 移除按钮按下状态样式
	   */
	function unpressHandler(){
		jQuery(this).removeClass("pgPress");
	}

}