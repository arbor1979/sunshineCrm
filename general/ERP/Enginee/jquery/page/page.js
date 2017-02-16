jQuery.fn.jpage = function(config){
	init("#"+this.attr("id"),config);
}

function init(t,config){
	//���б���
	var totalRecord = config.totalRecord > 0 ? config.totalRecord : 0; //�ܼ�¼��																
	var perPage = config.perPage;				                               //ÿҳ��ʾ��¼��
	var ajaxUrl = config.ajaxUrl ;	                                   //���ݴ����ַ
	var ajaxParam = config.ajaxParam;                                  //ajax���������
    var dataBody = config.dataBody;                                    //���ݳ�������
    var callback = config.callback;   
    var cookieName = config.cookieName;                                 //ajax�ɹ���ص�����
    var debug;
    if(typeof config.debug == "undefined")
        debug = false;
    else
        debug = config.debug==false ? false : true;
    //alert(config.callback.constructor);
	//˽�б���
	var totalPage = Math.ceil(totalRecord/perPage);	                   //��ҳ��
	var currentPage = 1;				                                       //��ǰҳ��
	var startRecord;																									 //ÿҳ��ʼ��¼
	var endRecord;	 																									 //ÿҳ������¼

	var toolbar = '';
	toolbar += '<div class="pgPanel">';
	toolbar += '<div>ÿҳ <input type="text" title="����󰴻س�ȷ��" class="SmallInput pgPerPage" size="5" value="' + perPage +'"> ��</div>';
	toolbar += '<div class="separator"></div>';
	toolbar += '<div class="pgBtn pgFirst" title="��ҳ"></div>';
	toolbar += '<div class="pgBtn pgPrev" title="��ҳ"></div>';
	toolbar += '<div class="separator"></div>';
	toolbar += '<div>�� <input class="SmallInput pgCurrentPage" size="5" type="text" value="' + currentPage + '" title="ҳ��" /> ҳ / �� <span class="pgTotalPage">' + totalPage + '</span> ҳ</div>';
	toolbar += '<div class="separator"></div>';
	toolbar += '<div class="pgBtn pgNext" title="��ҳ"></div>';
	toolbar += '<div class="pgBtn pgLast" title="βҳ"></div>';
	toolbar += '<div class="separator"></div>';
	toolbar += '<div class="pgBtn pgRefresh" title="ˢ��"></div>';
	toolbar += '<div class="separator"></div>';
	toolbar += '<div class="pgSearchInfo">������&nbsp;' + totalRecord + '&nbsp;����¼����ʾ��&nbsp;<span class="pgStartRecord">' + startRecord + '</span>&nbsp;��&nbsp;-&nbsp;��&nbsp;<span class="pgEndRecord">' + endRecord + '</span>&nbsp;����¼</div>';
	toolbar += '</div>';
	//alert(toolbar);
  jQuery(t).html(toolbar);

  var dataContainer =jQuery("#"+dataBody);
  
	var btnRefresh = jQuery(t+" .pgRefresh");														//ˢ�°�ť
	var btnNext =jQuery(t+" .pgNext");																	 //��һҳ��ť
	var btnPrev = jQuery(t+" .pgPrev");																	//��һҳ��ť
	var btnFirst = jQuery(t+" .pgFirst");																//��ҳ��ť
	var btnLast = jQuery(t+" .pgLast");																	//ĩҳ��ť
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


	//ˢ�°�ť����
	btnRefresh.bind("mousedown",pressHandler).bind("mouseup",unpressHandler).bind("mouseout",unpressHandler);

	//ˢ�¹�����
	refresh();
	
	//��ť����
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
	
	//ҳ����������
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
  				 msg='�˲����ᵼ�±Ƚϻ���,ȷ��Ҫִ����?';
           if(!window.confirm(msg))
           	 return;
        }
        else if(perPage==0 || perPage%1!=0)
        {
        	alert("��������Ч����!");
        	return;
        }
        //����cookie
        var exp = new Date();
        exp.setTime(exp.getTime() + 24*60*60*1000);
        document.cookie = cookieName+"="+ perPage + ";expires=" + exp.toGMTString()+";path=/";
  			currentPage = 1; //�趨ÿҳ��ʾ����
  			totalPage = Math.ceil(totalRecord/perPage);  
  			getStartEnd();
  			getRemoteData();
  			refresh();
		  }		
		}
	);
	
	/*********************************init˽�к���***************************************************/
	/**
	   * ��Ϊ���ڼ���״̬
	   */
	function startLoad(){
		jQuery(t+" .pgRefresh").addClass("pgLoad");
		jQuery(t+" .pgSearchInfo").html("��ȡ�����У����Ժ�...");
	}
	
	/**
	   * ��Ϊ��������״̬
	   */
	function overLoad(){
		jQuery(t+" .pgRefresh").removeClass("pgLoad");
		jQuery(t+" .pgSearchInfo").html('��&nbsp;' + totalRecord + '&nbsp;����¼����ʾ��&nbsp;<span class="pgStartRecord">' + startRecord + '</span>&nbsp;��&nbsp;-&nbsp;��&nbsp;<span class="pgEndRecord">' + endRecord + '</span>&nbsp;����¼');
	}

	/**
	   * ���Զ������
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
					alert("����ʧ�ܻ�ʱ�����Ժ����ԣ�");
					overLoad();
					return;
				}
			}
		);
	}
	
	/**
	   * ��õ�ǰҳ��ʼ������¼
	   */
	function getStartEnd(){
			startRecord = (currentPage-1)*perPage+1;
			endRecord = Math.min(currentPage*perPage,totalRecord);
	}

	/**
	   * ˢ�¹�����״̬
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
	   * �Ƴ���ťdisabled״̬��ʽ
	   */
	function enabled(){
			btnNext.removeClass("pgNextDisabled");
			btnPrev.removeClass("pgPrevDisabled");
			btnFirst.removeClass("pgFirstDisabled");
			btnLast.removeClass("pgLastDisabled");
	}

	/**
	   * ��Ӱ�ť����״̬��ʽ
	   */
	function pressHandler(){
		jQuery(this).addClass("pgPress");
	}

	/**
	   * �Ƴ���ť����״̬��ʽ
	   */
	function unpressHandler(){
		jQuery(this).removeClass("pgPress");
	}

}