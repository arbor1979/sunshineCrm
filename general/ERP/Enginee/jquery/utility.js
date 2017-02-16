this.showTip = function(content){
	jQuery(content).appendTo("body");
  var obj="#"+jQuery(content).attr("id");
	var myleft=(jQuery("body").width()-jQuery(obj).width())/2+jQuery("body").attr("scrollLeft");
  var mytop=(jQuery("body").height()-jQuery(obj).height())/3+jQuery("body").attr("scrollTop");
	jQuery(obj).css("left",myleft).css("top",mytop).fadeIn("slow");
	window.setTimeout(function(){jQuery(obj).fadeOut(1000);},1000);
	window.setTimeout(function(){jQuery(obj).remove();},2000);
};

this.tooltip = function(){			
		xOffset = 10;
		yOffset = 20;		
	jQuery("[title!='']").each(function(){
		jQuery(this).hover(function(e){											  
		this.t = this.title;
		this.title = "";									  
		jQuery("body").append("<div id='tooltip'>"+ this.t +"</div>");
		jQuery("#tooltip")
			.css("top",(e.pageY - xOffset) + "px")
			.css("left",(e.pageX + yOffset) + "px")
			.fadeIn("fast");		
    },
	function(){
		this.title = this.t;		
		jQuery("#tooltip").remove();
    });	
	jQuery(this).mousemove(function(e){
		jQuery("#tooltip")
			.css("top",(e.pageY - xOffset) + "px")
			.css("left",(e.pageX + yOffset) + "px");
	});
 });			
};

this.tooltipForm = function(){			
		xOffset = 10;
		yOffset = 20;
	jQuery("[name^='DATA_']").each(function(){
	  //初始化title信息
	  this.title = "名称:"+this.title+"&nbsp;&nbsp;序号:"+this.name.substr(5);		
		jQuery(this).hover(function(e){											  
		this.t = this.title;
		this.title = "";									  
		jQuery("body").append("<p id='tooltip'>"+ this.t +"</p>");
		jQuery("#tooltip")
			.css("top",(e.pageY - xOffset) + "px")
			.css("left",(e.pageX + yOffset) + "px")
			.fadeIn("fast");		
    },
	function(){
		this.title = this.t;		
		jQuery("#tooltip").remove();
    });
  jQuery(this).mousemove(function(e){
		jQuery("#tooltip")
			.css("top",(e.pageY - xOffset) + "px")
			.css("left",(e.pageX + yOffset) + "px");
	});		
  });		
};
