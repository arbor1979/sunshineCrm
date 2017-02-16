	function set_page(init)
	{
	pageid=PAGE_NUM.value;
	location="?action=" + init + "&pageid="+pageid;
	}

	function delete_element(init,deleteindex)
	{
		delete_str="";
		allElements = document.getElementsByTagName('input');
		for(i=0;i<allElements.length;i++)
		{
			if(allElements[i].name!='selectid')
				continue;
			if(allElements[i].checked)
			{  
				
				val=allElements[i].value;
				delete_str+=val + ",";
				
			}
		}
		
		

		if(delete_str=="")
		{
			alert("请选择你要删除的记录（可以多项）");
			return;
		}
	
		msg="你真的想要删除此项记录吗？";
		var PAGE_NUM=document.getElementsByName('PAGE_NUM');
		pageid=PAGE_NUM[0].value;
		var action_page=document.getElementsByName('action_page');
		action_page_=action_page[0].value;
		var action_page_value=document.getElementsByName('action_page_value');
		action_page_value_=action_page_value[0].value;
		
		if(confirm(msg))
		{
			url="action="+deleteindex+"&returnmodel="+init+"&"+action_page_value_+"&selectid="+ delete_str +"&pageid="+ pageid;//url
			location = "?"+base64encode(utf16to8(url));
			
		}
	}



	function edit_element(mark,returnadd)
	{
	edit_str = "";
	counter=0;
	allElements = document.getElementsByTagName('input');
	for(i=0;i<allElements.length;i++)
	{
		if(allElements[i].name!='selectid')
			continue;
		
		if(allElements[i].checked)
		{  
		 val=allElements[i].value;
         edit_str+=val + ",";
		 counter++;
		}
	}

	if(edit_str=="")
	{
		alert("请选择一项记录进行编辑修改");
		return;
	}

	if(counter!=1)			
	{
		alert("只能选择一项记录进行编辑");
		return;
	}
	var PAGE_NUM=document.getElementsByName('PAGE_NUM');
	
	pageid=PAGE_NUM[0].value;
	
	url = returnadd+"&selectid="+ edit_str +"&pageid="+ pageid;//url
	location = "?"+base64encode(utf16to8(url));
	}

	function operation_element(returnadd,target)
	{
	
	edit_str = "";
	counter=0;
	var selectid=document.getElementsByName('selectid');
	
	for(i=0;i<selectid.length;i++)
	{
		el=selectid[i];
		
		if(el.checked)
		{  
		 val=el.value;
         edit_str+=val + ",";
		 counter++;
		}
	}
	
	
	if(edit_str=="")
	{
		alert("请选择你要进行操作的记录");
		return;
	}
	
	pageid = document.getElementsByName('PAGE_NUM')[0].value;
	
	url = returnadd+"&selectid="+ edit_str +"&pageid="+ pageid;//url
	if(target!='')
		window.open("?"+base64encode(utf16to8(url)),target);
	else
		location = "?"+base64encode(utf16to8(url));
	}

	function reply_element()
	{
	edit_str = "";
	counter=0;
	for(i=0;i<document.all("selectid").length;i++)
		{

		el=document.all("selectid").item(i);
		if(el.checked)
		{  
		 val=el.value;
         edit_str+=val + ",";
		 counter++;
		}
	}

	if(i==0)
	{
		el=document.all("selectid");
		if(el.checked)
		{  
			val=el.value;
			edit_str+=val + ",";
			counter++;
		}
	}
	
	if(edit_str=="")
	{
		alert("请选择一封邮件进行回复");
		return;
	}

	if(counter!=1)			
	{
		alert("请选择一封邮件进行回复");
		return;
	}

	pageid=PAGE_NUM.value;
	url="action=edit_reply&selectid="+ edit_str +"&pageid="+ pageid;//url
	location = "?"+base64encode(utf16to8(url));
	}

	function forward_element()
	{
	edit_str = "";
	counter=0;
	for(i=0;i<document.all("selectid").length;i++)
		{

		el=document.all("selectid").item(i);
		if(el.checked)
		{  
		 val=el.value;
         edit_str+=val + ",";
		 counter++;
		}
	}

	if(i==0)
	{
		el=document.all("selectid");
		if(el.checked)
		{  
			val=el.value;
			edit_str+=val + ",";
			counter++;
		}
	}
	
	if(edit_str=="")
	{
		alert("请至少选择一封你要转发的邮件");
		return;
	}

	if(counter!=1)			
	{
		alert("请至少选择一封你要转发的邮件");
		return;
	}

	pageid=PAGE_NUM.value;
	url="action=edit_forward&selectid="+ edit_str +"&pageid="+ pageid;//url
	location = "?"+base64encode(utf16to8(url));
	}

	function share_element(mark,selfname)
	{
	edit_str = "";
	counter=0;
	for(i=0;i<document.all("selectid").length;i++)
		{

		el=document.all("selectid").item(i);
		if(el.checked)
		{  
		 val=el.value;
         edit_str+=val;
		 counter++;
		}
	}

	if(i==0)
	{
		el=document.all("selectid");
		if(el.checked)
		{  
			val=el.value;
			edit_str+=val;
			counter++;
		}
	}
	
	if(edit_str=="")
	{
		alert("请选择你要进行操作的记录");
		return;
	}

	if(counter!=1)			
	{
		alert("请选择你要进行操作的记录");
		return;
	}

	url="action=edit_"+mark+"&"+selfname+"="+edit_str;
	location = "?"+base64encode(utf16to8(url));
	}

	function move_element(init)
	{
	move_str="";
	for(i=0;i<document.all("selectid").length;i++)
		{

		el=document.all("selectid").item(i);
		if(el.checked)
		{  val=el.value;
         move_str+=val + ",";
		}
	}
  
		if(i==0)
		{
		el=document.all("selectid");
		if(el.checked)
		{  val=el.value;
         move_str+=val + ",";
		}
	}

	if(move_str=="")
	{
		alert("请选择你要进行操作的记录");
		return;
	}

	pageid=PAGE_NUM.value;
	action_page_=action_page.value;
	action_page_value_=action_page_value.value;
	url="action=edit_move&returnmodel="+init+"&"+action_page_value_+"&selectid="+ move_str +"&pageid="+ pageid;//url
	location = "?"+base64encode(utf16to8(url));
	}


	function check_all()
	{
		//alert(document.all("selectid").length);
		var allElements=document.getElementsByTagName('input');	
		var allbox=document.getElementById('allbox');
		for (i=0;i<allElements.length;i++)
		{	
			if(allElements[i].name!='selectid')
				continue;
			if(allbox.checked && allElements[i].disabled == false)		{
				//document.all("selectid").item(i).disabled = true;
				allElements[i].checked=true;
			}
			else if(allElements[i].disabled == false)		{
				//document.all("selectid").item(i).disabled = false;
				allElements[i].checked=false;
			}
		}
	
	

	}

	function changeGroup(url)		{
		location=url;
	}
	
	function GetResult(str)
	{
		var oBao = new ActiveXObject("Microsoft.XMLHTTP");
		oBao.open("GET",str,false);
		oBao.send();
	}