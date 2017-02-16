
	function selectid_str()
	{
	selectid_str="";
	for(i=0;i<document.all("selectid").length-1;i++)
		{

		el=document.all("selectid").item(i);
		if(el.checked)
		{  val=el.value;
         selectid_str+=val + ",";
		}
	}
	selectid_str+=document.all("selectid").item(document.all("selectid").length-1).value;
	tablename_=tablename.value;
	exportsql="select "+ selectid_str + " from " + tablename_ + "";
	url="export.php?action=exportdata&method=get&exportsql="+exportsql+"&tablename="+tablename_;//url
	location=url;
	}

	function selectfield_str()
	{
	selectfield_str="";
	for(i=0;i<document.all("selectfield").length-1;i++)
		{

		el=document.all("selectfield").item(i);
		if(el.checked)
		{  val=el.value;
         selectfield_str+=val + ",";
		}
	}
	selectfield_str+=document.all("selectfield").item(document.all("selectfield").length-1).value;
	tablename_=tablename.value;
	exportsql="select "+ selectfield_str + " from " + tablename_ + "";
	url="export.php?action=exportdata&method=get&exportsql="+exportsql+"&tablename="+tablename_;//url
	location=url;
	}

	function selectid_str_init(mark)
	{
	selectid_str = "";
	for(i=0;i<document.all("selectid").length-1;i++)
		{

		el = document.all("selectid").item(i);
		if(el.checked)
		{	val = el.value;
			if(val !="")	{
				selectid_str += val + ",";
			}
		}
	}

	ell = document.all("selectid").item(document.all("selectid").length-1);
	if(ell.checked)
	{	val = ell.value;
		if(val !="")	{
			selectid_str += val ;
		}
	}

	tablename_=tablename.value;
	exportfield= selectid_str;
	url="?action=export_"+mark+"_data&method=get&exportfield="+exportfield+"&tablename="+tablename_;//url
	location=url;
	}

	function selectfield_str_init(mark)
	{
	selectfield_str="";
	for(i=0;i<document.all("selectfield").length-1;i++)
		{

		el=document.all("selectfield").item(i);
		if(el.checked)
		{  val=el.value;
         selectfield_str+=val + ",";
		}
	}
	selectfield_str+=document.all("selectfield").item(document.all("selectfield").length-1).value;
	tablename_=tablename.value;
	exportfield= selectfield_str;
	url="?action=export_"+mark+"_data&method=get&exportfield="+exportfield+"&tablename="+tablename_;//url
	location=url;
	}
