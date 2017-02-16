
<script language=javascript>
var amtdot='<%=amtDotValue%>';
if  (amtdot==""||amtdot==null){
	amtdot=2;
	}
function mult_Select(rowId)
{
  var idStr=document.all("rowId_STR").value;
  
  if (idStr=="")
  {
  idStr=rowId+"|";
  }
  else
  {
  if(idStr.search(rowId)!=-1)
  {
     idStr=idStr.replace(rowId+"|","");
  }
   else
  idStr=idStr+rowId+"|";	
  }
  //alert(idStr);
  document.all("rowId_STR").value=idStr;
  
}

function converUrlStr(urlStr) {  
  var reArray = new Array(
    /[%]{1}/g,
    /[#]{1}/g,    
    /[&]{1}/g,  
    /[+]{1}/g,
    /[\\]{1}/g,
    /[=]{1}/g,
    /[?]{1}/g
  );
  var strArray = new Array(
    "%25",
    "%23",    
    "%26",
    "%2B",
    "%2F",
    "%3D",
    "%3F"
  );
  var newStr = urlStr;
  for (var i = 0; i < reArray.length; i++) {
    var newStr = newStr.replace(reArray[i], strArray[i]);
  }
  return newStr;
}
function mult_Select(rowId)
{
  var idStr=document.all("rowId_STR").value;
  
  if (idStr=="")
  {
  idStr=rowId+"|";
  }
  else
  {
  if(idStr.search(rowId)!=-1)
  {
     idStr=idStr.replace(rowId+"|","");
  }
   else
  idStr=idStr+rowId+"|";	
  }
  //alert(idStr);
  document.all("rowId_STR").value=idStr;
  
}
function value_empty(fld_must,fld_name)
{
   fld_str_obj=document.all(fld_must);
   name_str_obj=document.all(fld_name);
   if(fld_str_obj.value=="")
      return false;

   fld_array=fld_str_obj.value.split(",");
   name_array=name_str_obj.value.split(",");

   for(i=0;i<=fld_array.length;i++)
   {
     if(fld_array[i]=="")
        break;
     fld_obj=document.all(fld_array[i]);
     if(fld_obj.value=="")
     {
       alert("〖"+name_array[i]+"〗不能为空！");
       if(fld_obj.readonly=="")
         fld_obj.focus();
         return (true);
     }
   }
   return (false);
}

function find_id(theId,idStr)
{
	//alert("theId"+theId);
	//alert("idStr"+idStr);
   if(theId=="" || idStr=="")
      return false;
   if(idStr.search(theId)==-1)
      return false;
   return true;
}

function add(openurl)
{
   loc_x=300;
   loc_y=200;
window.open(openurl,"qqq","menubar=0,toolbar=0,status=0,scrollbars=1,resizable=1,width=400px,height=150px,Top="+loc_y+"px,Left="+loc_x+"px");
}
function secadd(openurl)
{
   loc_x=300;
   loc_y=200;
window.open(openurl,"qqq","menubar=0,toolbar=0,status=0,scrollbars=1,resizable=1,width=900px,height=450px,Top="+loc_y+"px,Left="+loc_x+"px");
}
//修改--夏勇
function order()
{
  var ModuleId=document.all("ModuleId").value;
  URL="/app/module/code/order.jsp?ModuleId="+ModuleId;
  loc_x=150;
  loc_y=100;
  //window.showModalDialog(URL,self,"edge:raised;scroll:0;status:0;help:0;resizable:1;dialogWidth:700px;dialogHeight:450px;dialogTop:"+loc_y+"px;dialogLeft:"+loc_x+"px");
  //window.open(URL,"11","edge:raised;scroll:0;status:0;help:0;resizable:1;dialogWidth:400px;dialogHeight:350px;dialogTop:"+loc_y+"px;dialogLeft:"+loc_x+"px");
  window.open(URL,"qqq","menubar=0,toolbar=0,status=0,scrollbars=1,resizable=1,width=700px,height=450px,Top="+loc_y+"px,Left="+loc_x+"px");

}
function selectMan(ModuleId)
{
	 var idStr=document.all("ID_STR").value;
	 
   if(idStr=="")
   {
      alert("请选中一项！");
      return false;
   }
   if(idStr.indexOf(",") < idStr.length-1)
   {
      alert("只能选中一项！");
      return false;
   }
  idStr=idStr.substring(0,idStr.indexOf(","));
  URL="/app/inflow/index/orderprod.jsp?ModuleId="+idStr;
  loc_x=150;
  loc_y=100;
  //window.showModalDialog(URL,self,"edge:raised;scroll:0;status:0;help:0;resizable:1;dialogWidth:700px;dialogHeight:450px;dialogTop:"+loc_y+"px;dialogLeft:"+loc_x+"px");
  //window.open(URL,"11","edge:raised;scroll:0;status:0;help:0;resizable:1;dialogWidth:400px;dialogHeight:350px;dialogTop:"+loc_y+"px;dialogLeft:"+loc_x+"px");
  window.open(URL,"qqq","menubar=0,toolbar=0,status=0,scrollbars=1,resizable=1,width=700px,height=450px,Top="+loc_y+"px,Left="+loc_x+"px");

}
function selectField(ModuleId)
{
	 var idStr=document.all("ID_STR").value;
	 
   if(idStr=="")
   {
      alert("请选中一项！");
      return false;
   }
   if(idStr.indexOf(",") < idStr.length-1)
   {
      alert("只能选中一项！");
      return false;
   }
  idStr=idStr.substring(0,idStr.indexOf(","));
  URL="/app/inflow/index/orderfield.jsp?FolderID="+idStr+"&ModuleId="+ModuleId;
  loc_x=150;
  loc_y=100;
  //window.showModalDialog(URL,self,"edge:raised;scroll:0;status:0;help:0;resizable:1;dialogWidth:700px;dialogHeight:450px;dialogTop:"+loc_y+"px;dialogLeft:"+loc_x+"px");
  //window.open(URL,"11","edge:raised;scroll:0;status:0;help:0;resizable:1;dialogWidth:400px;dialogHeight:350px;dialogTop:"+loc_y+"px;dialogLeft:"+loc_x+"px");
  window.open(URL,"qqq","menubar=0,toolbar=0,status=0,scrollbars=1,resizable=1,width=700px,height=450px,Top="+loc_y+"px,Left="+loc_x+"px");

}
function lookquery(ModuleId)
{
  URL="/app/module/combquery/index.jsp?ModuleId="+ModuleId;
  loc_x=400;
  loc_y=150;
  //window.showModalDialog(URL,self,"edge:raised;scroll:0;status:0;help:0;resizable:1;dialogWidth:400px;dialogHeight:150px;dialogTop:"+loc_y+"px;dialogLeft:"+loc_x+"px");
  //window.open(URL,"11","edge:raised;scroll:0;status:0;help:0;resizable:1;dialogWidth:400px;dialogHeight:350px;dialogTop:"+loc_y+"px;dialogLeft:"+loc_x+"px");
  window.open(URL,"qqq","menubar=0,toolbar=0,status=0,scrollbars=1,resizable=1,width=500px,height=150px,Top="+loc_y+"px,Left="+loc_x+"px");

}
function lookhelp(ModuleId,ModuleActionId)
{
  URL="/app/module/helpquery/index.jsp?ModuleId="+ModuleId+"&ModuleActionId="+ModuleActionId;
  loc_x=400;
  loc_y=150;
  //window.showModalDialog(URL,self,"edge:raised;scroll:0;status:0;help:0;resizable:1;dialogWidth:400px;dialogHeight:150px;dialogTop:"+loc_y+"px;dialogLeft:"+loc_x+"px");
  //window.open(URL,"11","edge:raised;scroll:0;status:0;help:0;resizable:1;dialogWidth:400px;dialogHeight:350px;dialogTop:"+loc_y+"px;dialogLeft:"+loc_x+"px");
  window.open(URL,"qqq","menubar=0,toolbar=0,status=0,scrollbars=1,resizable=1,width=500px,height=550px,Top="+loc_y+"px,Left="+loc_x+"px");

}
function data_out(ModuleId,ModuleName)
{
  URL="/app/module/code/export.jsp?ModuleId="+ModuleId+"&ModuleName="+ModuleName;
  loc_x=450;
  loc_y=250;
  window.open(URL,"qqq","menubar=0,toolbar=0,status=0,scrollbars=1,resizable=1,width=300px,height=250px,Top="+loc_y+"px,Left="+loc_x+"px");
}
function data_select(ModuleId,ModuleName)
{
  URL="/app/module/code/setSql.jsp";
  loc_x=450;
  loc_y=250;
  window.showModalDialog(URL,self,"edge:raised;scroll:0;status:0;help:0;resizable:1;dialogWidth:400px;dialogHeight:350px;dialogTop:"+loc_y+"px;dialogLeft:"+loc_x+"px");
  //window.open(URL,"qqq","menubar=0,toolbar=0,status=0,scrollbars=1,resizable=1,width=350px,height=450px,Top="+loc_y+"px,Left="+loc_x+"px");
}
function data_query(ModuleId,ModuleName)
{
  URL="/app/module/code/query.jsp?ModuleId="+ModuleId+"&ModuleName="+ModuleName;
  loc_x=450;
  loc_y=250;
  window.showModalDialog(URL,self,"edge:raised;scroll:0;status:0;help:0;resizable:1;dialogWidth:400px;dialogHeight:150px;dialogTop:"+loc_y+"px;dialogLeft:"+loc_x+"px");
  //window.open(URL,"qqq","menubar=0,toolbar=0,status=0,scrollbars=1,resizable=1,width=300px,height=250px,Top="+loc_y+"px,Left="+loc_x+"px");
}
function edit(openrul)
{
   var idStr=document.all("ID_STR").value;
   //var idRowid=idStr.substring(0,18)+",";
   var idStr2=idStr.substring(0,idStr.length-1);
   //alert(idStr2);
   if (document.getElementById("NotDel_"+idStr2)!=null){
   var NotDel=document.all("NotDel_"+idStr2).value;
   //alert(NotDel);
   if(NotDel=="1")
   {
      alert("系统设置参数，无法修改！");
      return false;
   }
  }
   
   if(idStr=="")
   {
      alert("请选中一项编辑！");
      return false;
   }
   if(idStr.indexOf(",") < idStr.length-1)
   {
      alert("只能选中一项编辑！");
      return false;
   }
   URL=openrul+"?rowid="+idStr;
   loc_x=300;
   loc_y=200;
window.open(URL,"","menubar=0,toolbar=0,status=0,scrollbars=1,resizable=1,width=400px,height=150px,Top="+loc_y+"px,Left="+loc_x+"px");
}
function secedit(openrul)
{
   var idStr=document.all("ID_STR").value;
   var idRowid=idStr.substring(0,18)+",";
   if(idStr=="")
   {
      alert("请选中一项编辑！");
      return false;
   }
   if(idStr.indexOf(",") < idStr.length-1)
   {
      alert("只能选中一项编辑！");
      return false;
   }
   URL=openrul+"?rowid="+idStr;
   loc_x=100;
   loc_y=200;
window.open(URL,"","menubar=0,toolbar=0,status=0,scrollbars=1,resizable=1,width=800px,height=450px,Top="+loc_y+"px,Left="+loc_x+"px");
}

function bathedit(openrul)
{
   var idStr=document.all("ID_STR").value;
   var idRowid=idStr.substring(0,18)+",";
   if(idStr=="")
   {
      alert("请选中一项编辑！");
      return false;
   }
   
   URL=openrul+"?rowid="+idStr;
   loc_x=300;
   loc_y=200;
window.open(URL,"","menubar=0,toolbar=0,status=0,scrollbars=1,resizable=1,width=400px,height=150px,Top="+loc_y+"px,Left="+loc_x+"px");
}
function voucher(openrul)
{
   var idStr=document.all("rowId_STR").value;
   //  var idStr=document.all("rowId_STR").value;
   //var idRowid=idStr.substring(0,18)+",";
   alert(idStr);
   var tableStr=document.all("A_Table").value;
   if(idStr=="")
   {
      alert("请选中一项生成凭证！");
      return false;
   }
   idStr=converUrlStr(idStr);
   //idStr=idStr.replace("+","%2B");
   //if(idStr.indexOf(",") < idStr.length-1)
   //{
   //   alert("只能选中一项生成凭证！");
   //   return false;
   //}
   alert(idStr);
   URL=openrul+"?rowid="+idStr+"&A_Table="+tableStr;
   alert(URL);
   loc_x=150;
   loc_y=100;

window.open(URL,"","menubar=0,toolbar=0,status=0,scrollbars=1,resizable=1,width=900px,height=550px,Top="+loc_y+"px,Left="+loc_x+"px");
}
function editvoucher(openrul,rowid)
{
   var idRowid=rowid.substring(0,18)+",";
   URL=openrul+"?rowid="+idRowid;

   loc_x=150;
   loc_y=100;

window.open(URL,"","menubar=0,toolbar=0,status=0,scrollbars=1,resizable=1,width=900px,height=470px,Top="+loc_y+"px,Left="+loc_x+"px");
}
function voucheredit(openrul)
{
   var idStr=document.all("ID_STR").value;
   //alert(idStr);
   var idRowid=idStr.substring(0,18)+",";
   var tableStr=document.all("A_Table").value;
   if(idStr=="")
   {
      alert("请选中一项编辑凭证！");
      return false;
   }
   if(idStr.indexOf(",") < idStr.length-1)
   {
      alert("只能选中一项编辑凭证！");
      return false;
   }

   URL=openrul+"?rowid="+idRowid+"&A_Table="+tableStr;
 //  alert(tableStr);
   loc_x=150;
   loc_y=100;

window.open(URL,"","menubar=0,toolbar=0,status=0,scrollbars=1,resizable=1,width=900px,height=470px,Top="+loc_y+"px,Left="+loc_x+"px");
}

function del()
{
   var idStr=document.all("ID_STR").value;
   var ModuleId=document.all("ModuleId").value;
   var userIdStr=document.all("userIdStr").value;
   var idStr2=idStr.substring(0,idStr.length-1);
   //alert(idStr2);
   if (document.getElementById("NotDel_"+idStr2)!=null){
   var NotDel=document.all("NotDel_"+idStr2).value;
   //alert(NotDel);
   if(NotDel=="1")
   {
      alert("系统设置参数，无法删除！");
      return false;
   }
  }
   if(idStr=="")
   {
      alert("请至少选中一项删除！");
      return false;
   }

   if(!window.confirm("确定删除吗？"))
      return false;
   //alert(idStr);
   Qfrm.qflag.value="delete";
   Qfrm.deletevalue.value=idStr;
   Qfrm.submit();
}
function refer()
{
   var idStr=document.all("ID_STR").value;
   if(idStr=="")
   {
      alert("请至少选中一项进行提交！");
      return false;
   }
   if(!window.confirm("确定提交审批吗？"))
      return false;
   Qfrm.qflag.value="refer";
   Qfrm.deletevalue.value=idStr;
   Qfrm.updateStateId.value="2";
   Qfrm.submit();
}
function referPass()
{
   var idStr=document.all("ID_STR").value;
   if(idStr=="")
   {
      alert("请至少选中一项进行审批！");
      return false;
   }
   if(!window.confirm("确定审批通过吗？"))
      return false;
   Qfrm.qflag.value="refer";
   Qfrm.deletevalue.value=idStr;
   Qfrm.updateStateId.value="3";
   Qfrm.submit();
}
function referReject()
{
   var idStr=document.all("ID_STR").value;
   if(idStr=="")
   {
      alert("请至少选中一项进行驳回！");
      return false;
   }
   if(!window.confirm("确定审批驳回吗？"))
      return false;
   Qfrm.qflag.value="refer";
   Qfrm.deletevalue.value=idStr;
   Qfrm.updateStateId.value="5";
   Qfrm.submit();
}
function delvou()
{
   var idStr=document.all("ID_STR").value;
   var idRowid=idStr.substring(0,18)+",";
   if(idStr=="")
   {
      alert("请至少选中一项删除！");
      return false;
   }

   if(!window.confirm("确定删除吗？"))
      return false;

   Qfrm.qflag.value="deleteandvoucher";
   Qfrm.deletevalue.value=idRowid;
   Qfrm.submit();
}
function query()
{
   Qfrm.qflag.value="query";
   //alert("11111111111");
   Qfrm.submit();
}
function addnew()
{
   if(value_empty("FLD_MUST_STR","FLD_NAME_STR"))
      return (false);
   frm.flag.value="addnew";
   frm.submit();
}

function balance()
{
   //if(value_empty("GRP_NO,UNIT_ID,","FLD_NAME_STR"))
     //return (false);

   frm.flag.value="balance";
   frm.submit();
}
function update()
{
   if(value_empty("FLD_MUST_STR","FLD_NAME_STR"))
      return (false);

   frm.flag.value="update";
   frm.submit();
}
function updateDelete()
{
   
   frm.flag.value="deleteLev";
   
   frm.submit();
}
function delLeverList()
{
	//alert("测试");
	var idStr=parent.dept_main.frm.ID_STR.value;

	if (idStr==null){
		idStr="";
		}
  if (idStr=="") {
  	alert("请选择要删除的数据！");
  	return;
  	}
   frm.ID_STR.value=idStr;  
   frm.flag.value="deleteLevList";   
   frm.submit();
}
function updatevou()
{
   if(value_empty("FLD_MUST_STR","FLD_NAME_STR"))
      return (false);
   //alert("123");
   frm.flag.value="updatevoucher";
   frm.submit();
}

function update2()
{

   frm.flag.value="updatevoucher";
   //alert("123");
   frm.submit();
}
function update3()
{
   frm.flag.value="editvoucher";
   //alert("123");
   frm.submit();
}
var theDefaultColor="#FFFFFF";
var thePointerColor="#D9E8FF";
var theMarkColor="#003FBF";
function setKeyId(){
	document.all("keyId").value=event.keyCode;
}
function retKeyId(){
	document.all("keyId").value="";
}

function setPointer(theRow, theId, theAction)
{
	 //var theCells = null;
   var idStr=document.all("ID_STR").value;
   theId+=",";
   
   var keyId=document.all("keyId").value;
   
 
   	if (keyId == 16){//shift键 相邻选择
   	
    }else if (keyId == 17){//ctrl键  单个挑选
    	  if(theAction=="over" && !find_id(theId,idStr)){
      //theRow.style.background=thePointerColor;
    }
   else if(theAction=="out" && !find_id(theId,idStr)){
      theRow.style.background=theDefaultColor;
    }
   else if(theAction=="click")
   {
      if(find_id(theId,idStr))
      {
      	//alert("相等");
         idStr=idStr.replace(theId,"");
         theRow.style.background=thePointerColor;
         theRow.style.color="#000000";
      }
      else
      {
        //alert("不相等");
         if(idStr!=""&&document.all("TR"+idStr.replace(",",""))!=null)
         {
         	//alert("是否选中颜色");
            //document.all("TR"+idStr.replace(",","")).style.background=theDefaultColor;
            //document.all("TR"+idStr.replace(",","")).style.color="#000000";
         }
         idStr+=theId;
         theRow.style.background=theMarkColor;
         theRow.style.color="#FFFFFF";
      }      
      document.all("ID_STR").value=idStr;      
    }
    }
    else{    	
    	
    	  if(theAction=="over" && theId!=idStr && !find_id(theId,idStr) ){
      //theRow.style.background=thePointerColor;
    }
   else if(theAction=="out" && theId!=idStr && !find_id(theId,idStr) ){
      //theRow.style.background=theDefaultColor;
    }
   else if(theAction=="click")
   {
    	if(theId==idStr)
      {
      	
         idStr="";
         
         theRow.style.background=thePointerColor;
         theRow.style.color="#000000";
      }
      else
      {
      	
         if(idStr!=""&&document.all("TR"+idStr.replace(",",""))!=null)
         {
         	
           document.all("TR"+idStr.replace(",","")).style.background=theDefaultColor;
           document.all("TR"+idStr.replace(",","")).style.color="#000000";
         }
         idStr=theId;
         theRow.style.background=theMarkColor;
         theRow.style.color="#FFFFFF";
      } 
	 
	  //清除idStr最后的","号 -- 夏勇
	  /*
	  if (idStr.charAt(idStr.length-1)== ',')  
	  {
		  alert("fda");
		  idStr = idStr.substr(0, idStr.length-1);
	  }*/
      document.all("ID_STR").value=idStr;      
    }
    	}

}

function query_code(field)
{
  //alert(field);
  init_value=document.all(field).value;
  code=document.all(field+"_CODE").value;
  table=document.all(field+"_TABLE").value;
  URL="/app/module/code/query/index.jsp?CODE="+code+"&TABLE="+table+"&FIELD="+field+"&INIT_VALUE="+init_value;
  loc_x=document.body.scrollLeft+event.clientX-event.offsetX+350;
  loc_y=document.body.scrollTop+event.clientY-event.offsetY+100;
  window.showModalDialog(URL,self,"edge:raised;scroll:0;status:0;help:0;resizable:1;dialogWidth:450px;dialogHeight:250px;dialogTop:"+loc_y+"px;dialogLeft:"+loc_x+"px");
  //window.open(URL,"","menubar=0,toolbar=0,status=0,scrollbars=1,resizable=1,width=400px,height=300px,Top="+loc_y+"px,Left="+loc_x+"px");
}

function query_user(field)
{
  init_value=document.all(field).value;
  code="1";
  table="TD_OA.user";
  URL="/app/module/code/queryuser/index.jsp?CODE="+code+"&TABLE="+table+"&FIELD="+field+"&INIT_VALUE="+init_value;
  loc_x=document.body.scrollLeft+event.clientX-event.offsetX+350;
  loc_y=document.body.scrollTop+event.clientY-event.offsetY+100;
  window.showModalDialog(URL,self,"edge:raised;scroll:0;status:0;help:0;resizable:1;dialogWidth:450px;dialogHeight:250px;dialogTop:"+loc_y+"px;dialogLeft:"+loc_x+"px");
  //window.open(URL,"","menubar=0,toolbar=0,status=0,scrollbars=1,resizable=1,width=400px,height=300px,Top="+loc_y+"px,Left="+loc_x+"px");
}
function query_userid(field)
{
  init_value=document.all(field).value;
  code="1";
  table="TD_OA.user";
  URL="/app/module/code/queryuserid/index.jsp?CODE="+code+"&TABLE="+table+"&FIELD="+field+"&INIT_VALUE="+init_value;
  loc_x=document.body.scrollLeft+event.clientX-event.offsetX+350;
  loc_y=document.body.scrollTop+event.clientY-event.offsetY+100;
  window.showModalDialog(URL,self,"edge:raised;scroll:0;status:0;help:0;resizable:1;dialogWidth:450px;dialogHeight:250px;dialogTop:"+loc_y+"px;dialogLeft:"+loc_x+"px");
  //window.open(URL,"","menubar=0,toolbar=0,status=0,scrollbars=1,resizable=1,width=400px,height=300px,Top="+loc_y+"px,Left="+loc_x+"px");
}
function query_bath(field)
{
  //alert(field);
  init_value=document.all(field).value;
  code=document.all(field+"_CODE").value;
  table=document.all(field+"_TABLE").value;
  URL="/app/module/code/bathquery/index.jsp?CODE="+code+"&TABLE="+table+"&FIELD="+field+"&INIT_VALUE="+init_value;
  loc_x=document.body.scrollLeft+event.clientX-event.offsetX+350;
  loc_y=document.body.scrollTop+event.clientY-event.offsetY+100;
  window.showModalDialog(URL,self,"edge:raised;scroll:0;status:0;help:0;resizable:1;dialogWidth:300px;dialogHeight:250px;dialogTop:"+loc_y+"px;dialogLeft:"+loc_x+"px");
  //window.open(URL,"","menubar=0,toolbar=0,status=0,scrollbars=1,resizable=1,width=400px,height=300px,Top="+loc_y+"px,Left="+loc_x+"px");
}
function query_two(field)
{
  //alert(field);
  init_value=document.all(field).value;
  code=document.all(field+"_CODE").value;
  table=document.all(field+"_TABLE").value;
  URL="/app/lever/code/query/index.jsp?CODE="+code+"&TABLE="+table+"&FIELD="+field+"&INIT_VALUE="+init_value;
  loc_x=document.body.scrollLeft+event.clientX-event.offsetX+350;
  loc_y=document.body.scrollTop+event.clientY-event.offsetY+100;
  window.showModalDialog(URL,self,"edge:raised;scroll:0;status:0;help:0;resizable:1;dialogWidth:300px;dialogHeight:250px;dialogTop:"+loc_y+"px;dialogLeft:"+loc_x+"px");
  //window.open(URL,"","menubar=0,toolbar=0,status=0,scrollbars=1,resizable=1,width=400px,height=300px,Top="+loc_y+"px,Left="+loc_x+"px");
}
function query_acct(field)
{
  //alert(field);
  init_value=document.all(field).value;
  code=document.all(field+"_CODE").value;
  table=document.all(field+"_TABLE").value;
  URL="/app/module/code/queryacct/index.jsp?CODE="+code+"&TABLE="+table+"&FIELD="+field+"&INIT_VALUE="+init_value;
  loc_x=document.body.scrollLeft+event.clientX-event.offsetX+350;
  loc_y=document.body.scrollTop+event.clientY-event.offsetY+100;
  window.showModalDialog(URL,self,"edge:raised;scroll:0;status:0;help:0;resizable:1;dialogWidth:300px;dialogHeight:250px;dialogTop:"+loc_y+"px;dialogLeft:"+loc_x+"px");
  //window.open(URL,"","menubar=0,toolbar=0,status=0,scrollbars=1,resizable=1,width=400px,height=300px,Top="+loc_y+"px,Left="+loc_x+"px");
}

function query_ongrpno(field)
{
  init_value=document.all(field).value;
  code=document.all(field+"_CODE").value;
  table=document.all(field+"_TABLE").value;
  URL="/app/module/code/ongrpnoquery/index.jsp?CODE="+code+"&TABLE="+table+"&FIELD="+field+"&INIT_VALUE="+init_value;
  //URL="/app/module/code/ongrpnoquery/index.jsp?FIELD="+field;
  loc_x=document.body.scrollLeft+event.clientX-event.offsetX+350;
  loc_y=document.body.scrollTop+event.clientY-event.offsetY+100;
  window.showModalDialog(URL,self,"edge:raised;scroll:0;status:0;help:0;resizable:1;dialogWidth:350px;dialogHeight:250px;dialogTop:"+loc_y+"px;dialogLeft:"+loc_x+"px");
  //window.open(URL,"","menubar=0,toolbar=0,status=0,scrollbars=1,resizable=1,width=400px,height=300px,Top="+loc_y+"px,Left="+loc_x+"px");
}

function query_ongrpno_exps(field)
{
  init_value=document.all(field).value;
  code=document.all(field+"_CODE").value;
  table=document.all(field+"_TABLE").value;
  URL="/app/module/code/ongrpnoqueryexps/index.jsp?CODE="+code+"&TABLE="+table+"&FIELD="+field+"&INIT_VALUE="+init_value;
  //URL="/app/module/code/ongrpnoquery/index.jsp?FIELD="+field;
  loc_x=document.body.scrollLeft+event.clientX-event.offsetX+350;
  loc_y=document.body.scrollTop+event.clientY-event.offsetY+100;
  window.showModalDialog(URL,self,"edge:raised;scroll:0;status:0;help:0;resizable:1;dialogWidth:350px;dialogHeight:250px;dialogTop:"+loc_y+"px;dialogLeft:"+loc_x+"px");
  //window.open(URL,"","menubar=0,toolbar=0,status=0,scrollbars=1,resizable=1,width=400px,height=300px,Top="+loc_y+"px,Left="+loc_x+"px");
}


function query_pay(field)
{
  init_value=document.all(field).value;
  code=document.all(field+"_CODE").value;
  table=document.all(field+"_TABLE").value;
  URL="/app/module/code/payquery/index.jsp?CODE="+code+"&TABLE="+table+"&FIELD="+field+"&INIT_VALUE="+init_value;
  loc_x=document.body.scrollLeft+event.clientX-event.offsetX+350;
  loc_y=document.body.scrollTop+event.clientY-event.offsetY+100;
  window.showModalDialog(URL,self,"edge:raised;scroll:0;status:0;help:0;resizable:1;dialogWidth:300px;dialogHeight:250px;dialogTop:"+loc_y+"px;dialogLeft:"+loc_x+"px");
  //window.open(URL,"","menubar=0,toolbar=0,status=0,scrollbars=1,resizable=1,width=400px,height=300px,Top="+loc_y+"px,Left="+loc_x+"px");
}

function query_date(field)
{
  init_value=field;
  URL="/app/inc/calendar.jsp?FIELDNAME="+init_value;
  loc_x=document.body.scrollLeft+event.clientX-event.offsetX+350;
  loc_y=document.body.scrollTop+event.clientY-event.offsetY+100;
  window.showModalDialog(URL,self,"edge:raised;scroll:0;status:0;help:0;resizable:1;dialogWidth:280px;dialogHeight:205px;dialogTop:"+loc_y+"px;dialogLeft:"+loc_x+"px");
  //window.open(URL,"","menubar=0,toolbar=0,status=0,scrollbars=1,resizable=1,width=400px,height=300px,Top="+loc_y+"px,Left="+loc_x+"px");
}
var fld_name_display="";
function set_explain(field,BURSAR_ATTR)
{
  document.all(field).style.display="";
  if(fld_name_display!="")
  document.all(fld_name_display).style.display="none";
  fld_name_display=field;
  //alert(BURSAR_ATTR);
  if (BURSAR_ATTR.length>0)
         {
         var cust=BURSAR_ATTR.substring(0,1);//单位
         custfield=field+"1";
         if (cust==1)
         {
         document.all(custfield).style.display="";
         }
         else
         {
         document.all(custfield).style.display="none";
         }

         var dept=BURSAR_ATTR.substring(1,2);//部门
         deptfield=field+"2";
         if (dept==1)
         {
         document.all(deptfield).style.display="";
         }
         else
         {
         document.all(deptfield).style.display="none";
         }

         var empl=BURSAR_ATTR.substring(2,3);//人员
         emplfield=field+"3";
         if (empl==1)
         {
         document.all(emplfield).style.display="";
         }
         else
         {
         document.all(emplfield).style.display="none";
         }

         var class1=BURSAR_ATTR.substring(3,4);//统计
         class1field=field+"4";
         if (class1==1)
         {
         document.all(class1field).style.display="";
         }
         else
         {
         document.all(class1field).style.display="none";
         }
         var class2=BURSAR_ATTR.substring(4,5);//项目
         class2field=field+"5";
         if (class2==1)
         {
         document.all(class2field).style.display="";
         }
         else
         {
         document.all(class2field).style.display="none";
         }
         }

}
function query_voucher(field,ModuleId,row,typeid)
{
  init_value=document.all(field).value;
  URL="/app/module/code/voucher/index.jsp?FIELDNAME="+field+"&voucher="+ModuleId+"&INIT_VALUE="+init_value+"&row="+row+"&typeid="+typeid;
  loc_x=document.body.scrollLeft+event.clientX-event.offsetX+350;
  loc_y=document.body.scrollTop+event.clientY-event.offsetY+100;
  window.showModalDialog(URL,self,"edge:raised;scroll:0;status:0;help:0;resizable:1;dialogWidth:400px;dialogHeight:250px;dialogTop:"+loc_y+"px;dialogLeft:"+loc_x+"px");
  //window.open(URL,"","menubar=0,toolbar=0,status=0,scrollbars=1,resizable=1,width=400px,height=300px,Top="+loc_y+"px,Left="+loc_x+"px");
}
function balance_query_code(field,grp_no)
{
  grp_no=document.all(grp_no).value;
  init_value=document.all(field).value;
  code=document.all(field+"_CODE").value;
  table=document.all(field+"_TABLE").value;

  URL="/app/module/code/balancequery/index.jsp?CODE="+code+"&TABLE="+table+"&FIELD="+field+"&INIT_VALUE="+init_value+"&GRP_NO="+grp_no;
  loc_x=document.body.scrollLeft+event.clientX-event.offsetX+350;
  loc_y=document.body.scrollTop+event.clientY-event.offsetY+100;
  window.showModalDialog(URL,self,"edge:raised;scroll:0;status:0;help:0;resizable:1;dialogWidth:300px;dialogHeight:250px;dialogTop:"+loc_y+"px;dialogLeft:"+loc_x+"px");
  //window.open(URL,"","menubar=0,toolbar=0,status=0,scrollbars=1,resizable=1,width=400px,height=300px,Top="+loc_y+"px,Left="+loc_x+"px");
}

//verify for netscape/mozilla
var isNS4 = (navigator.appName=="Netscape")?1:0;

function check_input_num(num_type)
{
  if(num_type=="NUMBER")
  {
     if(!isNS4)
     {
     	 if((event.keyCode < 48 || event.keyCode > 57)&&event.keyCode != 46)
     	    event.returnValue = false;
     }
     else
     {
     	 if((event.which < 48 || event.which > 57)&&event.keyCode != 46)
     	    return false;
     }
  }
  else if(num_type=="MONEY")
  {
     if(!isNS4)
     {
     	 if((event.keyCode < 45 || event.keyCode > 57)&&event.keyCode != 47)
     	    event.returnValue = false;
     }
     else
     {
     	 if((event.which < 45 || event.which > 57)&&event.which != 47)
     	    return false;
     }
  }
}

function  ForDight(Dight,How)
{
           Dight  =  Math.round  (Dight*Math.pow(10,How))/Math.pow(10,How);
           return  Dight;
}

function check_value(field)
{
   var obj=document.all(field);
   if(obj.value=="")
      return;
      
   addMoneyStr(field);
   
}

function  init_value(field)
{
   var obj=document.all(field);   
   if (obj.value=="")
      return;

   re=/,/g;
   obj.value=obj.value.replace(re,"");
}
function uploadFromFile() {
  openurl="/app/fileupload/index.jsp";
  loc_x=300;
  loc_y=200;
  window.open(openurl,"fileupload","menubar=0,toolbar=0,status=0,scrollbars=1,resizable=1,width=400px,height=300px,Top="+loc_y+"px,Left="+loc_x+"px");
}

function detailclick(idRowid,ModuleId)
{   
   URL="/app/module/code/detail.jsp?rowid="+idRowid+"&ModuleId="+ModuleId;
   loc_x=254;
   loc_y=162;
  window.showModalDialog(URL,self,"edge:raised;scroll:1;status:1;help:1;resizable:1;dialogWidth:870px;dialogHeight:300px;dialogTop:"+loc_y+"px;dialogLeft:"+loc_x+"px");
  //window.open(URL,"qq","menubar=0,toolbar=0,status=0,scrollbars=1,resizable=1,width=650px,height=250px,Top="+loc_y+"px,Left="+loc_x+"px");
}
function datadetailclick(idRowid,ModuleId)
{   
	 var stockName=document.Qfrm("stockName").value;
	 var fromdata=document.Qfrm("fromdata").value;
	 var enddata=document.Qfrm("enddata").value;
	 
   URL="/app/module/code/datadetail.jsp?rowid="+idRowid+"&ModuleId="+ModuleId+"&stockName="+stockName+"&fromdata="+fromdata+"&enddata="+enddata;
   loc_x=254;
   loc_y=162;
  window.open(URL,"qq","menubar=0,toolbar=0,status=0,scrollbars=1,resizable=1,width=650px,height=250px,Top="+loc_y+"px,Left="+loc_x+"px");
}

function datadetail(State)
{   
   var idRowid=document.all("ID_STR").value;	
   if(idRowid=="")
   {
      alert("请至少选中一项查看明细！");
      return false;
   }
   idRowid=idRowid.substring(0,idRowid.length-1);
   
   var ModuleId=document.all("ModuleId").value;
   var stockName=document.Qfrm("stockName").value;
	 var fromdata=document.Qfrm("fromdata").value;
	 var enddata=document.Qfrm("enddata").value;
   URL="/app/module/code/datadetail.jsp?rowid="+idRowid+"&ModuleId="+ModuleId+"&stockName="+stockName+"&fromdata="+fromdata+"&enddata="+enddata+"&State="+State;
   loc_x=100;
   loc_y=100;
  window.open(URL,"qq","menubar=0,toolbar=0,status=0,scrollbars=1,resizable=1,width=900px,height=400px,Top="+loc_y+"px,Left="+loc_x+"px");
}
function datadetailchart(chartState)
{   
   var idRowid=document.all("ID_STR").value;	
   if (chartState=="1"){
      if(idRowid=="")
      {
      alert("请至少选中一项！");
      return false;
      }
   }
   idRowid=idRowid.substring(0,idRowid.length-1);
   var ModuleId=document.all("ModuleId").value;
	 var fromdata=document.Qfrm("fromdata").value;
	 var enddata=document.Qfrm("enddata").value;
	 var groupByStr=document.Qfrm("groupByStr").value;
	 var flowState=document.Qfrm("flowState").value;
	 var dataState=document.Qfrm("dataState").value;
	 
   URL="/app/module/code/setSql6.jsp?rowid="+idRowid+"&ModuleId="+ModuleId+"&groupByStr="+groupByStr+"&fromdata="+fromdata+"&enddata="+enddata+"&flowState="+flowState+"&dataState="+dataState+"&chartState="+chartState;//
   loc_x=254;
   loc_y=162;
   //alert(URL);
   window.showModalDialog(URL,self,"edge:raised;scroll:0;status:0;help:0;resizable:1;dialogWidth:400px;dialogHeight:350px;dialogTop:"+loc_y+"px;dialogLeft:"+loc_x+"px");
   //window.open(URL,"qq","menubar=0,toolbar=0,status=0,scrollbars=1,resizable=1,width=650px,height=250px,Top="+loc_y+"px,Left="+loc_x+"px");
}
function dataPrint()
{   
   var idRowid=document.all("ID_STR").value;	

      if(idRowid=="")
      {
      alert("请至少选中一项！");
      return false;
      }

   idRowid=idRowid.substring(0,idRowid.length-1);
   var ModuleId=document.all("ModuleId").value;
	 
   URL="/app/module/code/setSqlPrint.jsp?rowid="+idRowid+"&ModuleId="+ModuleId;//
   loc_x=254;
   loc_y=162;
   //alert(URL);
   //window.showModalDialog(URL,self,"edge:raised;scroll:0;status:0;help:0;resizable:1;dialogWidth:400px;dialogHeight:350px;dialogTop:"+loc_y+"px;dialogLeft:"+loc_x+"px");
   window.open(URL,"qq","menubar=0,toolbar=0,status=0,scrollbars=1,resizable=1,width=650px,height=250px,Top="+loc_y+"px,Left="+loc_x+"px");
}
function datachart()
{   
   var idRowid=document.all("ID_STR").value;	
   if(idRowid=="")
   {
      alert("请至少选中一项查看明细！");
      return false;
   }
   idRowid=idRowid.substring(0,idRowid.length-1);
   
   var ModuleId=document.all("ModuleId").value;
   var stockName=document.Qfrm("stockName").value;
	 var fromdata=document.Qfrm("fromdata").value;
	 var enddata=document.Qfrm("enddata").value;
   URL="/app/module/code/datachart.jsp?rowid="+idRowid+"&ModuleId="+ModuleId+"&stockName="+stockName+"&fromdata="+fromdata+"&enddata="+enddata;
   loc_x=254;
   loc_y=162;
  window.showModalDialog(URL,self,"edge:raised;scroll:0;status:0;help:0;resizable:1;dialogWidth:770px;dialogHeight:500px;dialogTop:"+loc_y+"px;dialogLeft:"+loc_x+"px");
  //window.open(URL,"qq","menubar=0,toolbar=0,status=0,scrollbars=1,resizable=1,width=750px,height=450px,Top="+loc_y+"px,Left="+loc_x+"px");
}
function detail()
{   
   var idRowid=document.all("ID_STR").value;	
   if(idRowid=="")
   {
      alert("请至少选中一项查看明细！");
      return false;
   }
   idRowid=idRowid.substring(0,idRowid.length-1);
   
   var ModuleId=document.all("ModuleId").value;
   URL="/app/module/code/detail.jsp?rowid="+idRowid+"&ModuleId="+ModuleId;
   loc_x=154;
   loc_y=162;
  window.showModalDialog(URL,self,"edge:raised;scroll:1;status:1;help:1;resizable:1;dialogWidth:870px;dialogHeight:300px;dialogTop:"+loc_y+"px;dialogLeft:"+loc_x+"px");
  //window.open(URL,"qq","menubar=0,toolbar=0,status=0,scrollbars=1,resizable=1,width=850px,height=250px,Top="+loc_y+"px,Left="+loc_x+"px");
}
function detailsec(ModuleId)
{   
   var idRowid=document.all("ID_STR").value;	
   if(idRowid=="")
   {
      alert("请至少选中一项查看明细！");
      return false;
   }
   idRowid=idRowid.substring(0,idRowid.length-1);
   URL="/app/module/code/detailsec.jsp?rowid="+idRowid+"&ModuleId="+ModuleId;
   loc_x=10;
   loc_y=10;
   //alert(URL);
  window.open(URL,"qq","menubar=0,toolbar=0,status=0,scrollbars=1,resizable=1,width=900px,height=550px,Top="+loc_y+"px,Left="+loc_x+"px");
}
function flow()
{   
   var idRowid=document.all("ID_STR").value;	
   if(idRowid=="")
   {
      alert("请至少选中一项查看！");
      return false;
   }
   idRowid=idRowid.substring(0,idRowid.length-1);
   
   var ModuleId=document.all("ModuleId").value;
   URL="/app/module/code/flowdetail.jsp?rowid="+idRowid+"&ModuleId="+ModuleId;
   loc_x=254;
   loc_y=162;
  window.open(URL,"qq","menubar=0,toolbar=0,status=0,scrollbars=1,resizable=1,width=650px,height=250px,Top="+loc_y+"px,Left="+loc_x+"px");
}
function backStock()
{   
   var idRowid=document.all("ID_STR").value;	
   if(idRowid=="")
   {
      alert("请至少选中一项进行退货！");
      return false;
   }
   idRowid=idRowid.substring(0,idRowid.length-1);
   
   var ModuleId=document.all("ModuleId").value;
   URL="/app/module/code/back.jsp?rowid="+idRowid+"&ModuleId="+ModuleId;
   loc_x=254;
   loc_y=162;
  window.open(URL,"qq","menubar=0,toolbar=0,status=0,scrollbars=1,resizable=1,width=750px,height=250px,Top="+loc_y+"px,Left="+loc_x+"px");
}
function printDetail(openrul)
{
   var idStr=document.all("ID_STR").value;
   var idRowid=idStr.substring(0,18)+",";
   if(idStr=="")
   {
      alert("请选中一项进行打印！");
      return false;
   }
   if(idStr.indexOf(",") < idStr.length-1)
   {
      alert("只能选中一项进行打印！");
      return false;
   }
   URL=openrul+"?rowid="+idStr;
   loc_x=300;
   loc_y=200;
   //window.showModalDialog(URL,self,"edge:raised;scroll:1;status:1;help:1;resizable:1;dialogWidth:770px;dialogHeight:500px;dialogTop:"+loc_y+"px;dialogLeft:"+loc_x+"px");
   window.open(URL,"","menubar=1,toolbar=1,status=1,scrollbars=1,resizable=1,width=700px,height=450px,Top="+loc_y+"px,Left="+loc_x+"px");
}
function secorderInput(thisBut){
if (event.keyCode == 13)
{
secorderquery();	
}
thisBut.onfocus();
}
function queryInput(thisBut){
if (event.keyCode == 13)
{
query();	
}
thisBut.onfocus();
}

 function addMoneyStr(moneyField){
 	
 	  if (document.frm(moneyField).value.indexOf(",")>=0){
 	  	return;
 	  	}
 	
   if(document.frm(moneyField).value=="")
      return;
    if(document.frm(moneyField).value.substring(0,1)=="-")
   {
   	   op_Money="-";
   	   document.frm(moneyField).value=document.frm(moneyField).value.substring(1,document.frm(moneyField).value.length);
   }
   else
       op_Money="";
       
    val_Money=parseFloat(document.frm(moneyField).value);   
    document.frm(moneyField).value=ForDight(val_Money,amtdot);
    var value_array_Money=document.frm(moneyField).value.split(".");

   start_Money=0;
   len_Money=0;
   val_int_Money="";

   while(1)
   {
   	  if((value_array_Money[0].length-start_Money)%3==0)
   	     len_Money=3;
   	  else
   	  	 len_Money=value_array_Money[0].length%3;

      if(val_int_Money=="")
         val_int_Money=value_array_Money[0].substring(start_Money,start_Money+len_Money);
      else
         val_int_Money=val_int_Money+","+value_array_Money[0].substring(start_Money,start_Money+len_Money);
   	  start_Money=len_Money+start_Money;

   	  if(start_Money>=value_array_Money[0].length)
   	     break;
   }
   if(val_int_Money!="")
      value_array_Money[0]=val_int_Money;

   if(value_array_Money.length==1)
   	  value_array_Money[1]="00";
   else if(value_array_Money.length==amtdot)
   {
   	  if(value_array_Money[1].length==0)
   	    value_array_Money[1]="00";
   	  else if(value_array_Money[1].length==1)
   	    value_array_Money[1]=value_array_Money[1]+"0";
   	  else if(value_array_Money[1].length>=amtdot)
   	    value_array_Money[1]=value_array_Money[1].substr(0,amtdot);
   }
   document.frm(moneyField).value=op_Money+value_array_Money[0]+"."+value_array_Money[1];
 	}
 	function detailFlow(dataState)
{   
   var idRowid=document.all("ID_STR").value;	
   if(idRowid=="")
   {
      alert("请至少选中一项查看明细！");
      return false;
   }
   idRowid=idRowid.substring(0,idRowid.length-1);
   
   var ModuleId=document.all("ModuleId").value;
   URL="/app/module/code/detailflow.jsp?rowid="+idRowid+"&ModuleId="+ModuleId+"&dataState="+dataState;
   loc_x=100;
   loc_y=100;
  window.showModalDialog(URL,self,"edge:raised;scroll:1;status:1;help:1;resizable:1;dialogWidth:970px;dialogHeight:500px;dialogTop:"+loc_y+"px;dialogLeft:"+loc_x+"px");
  //window.open(URL,"qq","menubar=0,toolbar=0,status=0,scrollbars=1,resizable=1,width=850px,height=250px,Top="+loc_y+"px,Left="+loc_x+"px");
}

function query_stock(field)
{
  init_value=document.all(field).value;
  code=document.all(field+"_CODE").value;
  table=document.all(field+"_TABLE").value;
  ModuleId=document.all("ModuleId").value;
  URL="/app/module/code/querystock/index.jsp?CODE="+code+"&TABLE="+table+"&FIELD="+field+"&INIT_VALUE="+init_value+"&ModuleId="+ModuleId;
  loc_x=document.body.scrollLeft+event.clientX-event.offsetX+350;
  loc_y=document.body.scrollTop+event.clientY-event.offsetY+100;
  window.showModalDialog(URL,self,"edge:raised;scroll:0;status:0;help:0;resizable:1;dialogWidth:750px;dialogHeight:450px;dialogTop:"+loc_y+"px;dialogLeft:"+loc_x+"px");
  //window.open(URL,"","menubar=0,toolbar=0,status=0,scrollbars=1,resizable=1,width=400px,height=300px,Top="+loc_y+"px,Left="+loc_x+"px");
}

	function editSate(StateId)
{
   var idStr=document.all("ID_STR").value;
   var ModuleId=document.all("ModuleId").value;
   
    
   if(idStr=="")
   {
      alert("请选中一项编辑！");
      return false;
   }
   URL="/app/module/code/changestate/index.jsp?rowid="+idStr+"&ModuleId="+ModuleId+"&StateId="+StateId;
      //   engserv\module\code\changestate
   //URL=openrul+"?rowid="+idStr+"&ModuleId="+ModuleId;
   loc_x=300;
   loc_y=200;
  // alert(URL);
   //window.showModalDialog(URL,self,"edge:raised;scroll:0;status:0;help:0;resizable:1;dialogWidth:450px;dialogHeight:250px;dialogTop:"+loc_y+"px;dialogLeft:"+loc_x+"px");
  
window.open(URL,"","menubar=0,toolbar=0,status=0,scrollbars=1,resizable=1,width=400px,height=150px,Top="+loc_y+"px,Left="+loc_x+"px");
}
function query_supply(field)
{
  init_value=document.all(field).value;
  code=document.all(field+"_CODE").value;
  table=document.all(field+"_TABLE").value;
  ModuleId=document.all("ModuleId").value;
  URL="/app/module/code/querycustomer/index.jsp?CODE="+code+"&TABLE="+table+"&FIELD="+field+"&INIT_VALUE="+init_value+"&ModuleId="+ModuleId;
  loc_x=document.body.scrollLeft+event.clientX-event.offsetX+350;
  loc_y=document.body.scrollTop+event.clientY-event.offsetY+100;
  window.showModalDialog(URL,self,"edge:raised;scroll:0;status:0;help:0;resizable:1;dialogWidth:750px;dialogHeight:450px;dialogTop:"+loc_y+"px;dialogLeft:"+loc_x+"px");
  //window.open(URL,"","menubar=0,toolbar=0,status=0,scrollbars=1,resizable=1,width=400px,height=300px,Top="+loc_y+"px,Left="+loc_x+"px");
}


var imgpath = "/images/images/";


function toggleSetting(id) {
	var div = document.all[id];
	var img = document.all[id+"_tgimg"];
	//var stockInitButton = document.all["stockInitButton"];
	if (div.style.display == "none") {
		div.style.display = "block";
		img.src = imgpath + "minus.gif";
		//stockInitButton.style.display = "block";
	}
	else {
		div.style.display = "none";
		//stockInitButton.style.display = "none";
		img.src = imgpath + "plus.gif";
	}
}

function check_value2(field)
{
  //alert(field);
  init_value=document.all(field).value;
  ModuleId=document.all("ModuleId").value;
  Add_table=document.all("Add_table").value;
  if (init_value==null||init_value==""){
  alert("请先输入要验证的内容");
  return false;
  	}
  URL="/app/module/code/checkvalue/index.jsp?ModuleId="+ModuleId+"&Add_table="+Add_table+"&INIT_VALUE="+init_value+"&field="+field;
  loc_x=document.body.scrollLeft+event.clientX-event.offsetX+350;
  loc_y=document.body.scrollTop+event.clientY-event.offsetY+100;
  window.showModalDialog(URL,self,"edge:raised;scroll:0;status:0;help:0;resizable:1;dialogWidth:450px;dialogHeight:250px;dialogTop:"+loc_y+"px;dialogLeft:"+loc_x+"px");
  //window.open(URL,"","menubar=0,toolbar=0,status=0,scrollbars=1,resizable=1,width=400px,height=300px,Top="+loc_y+"px,Left="+loc_x+"px");
}
</script>

