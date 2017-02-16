<?php
require_once('lib.inc.php');
$sessionkey=returnSessKey();
$GLOBAL_SESSION=returnsession();

$buyman = $_SESSION['SUNSHINE_USER_NAME'];
$tabledate = date("Y-m-d");

?>





<link rel="stylesheet" type="text/css" href="<?php echo ROOT_DIR?>theme/3/style.css">



<div style="position:absolute;width:322;height:14;border:1 #707888 solid;overflow:hidden" id="pinghead">
	<div style="position:absolute;top:-1;left:0" id="pimg">
	</div>
</div>
<center>
<div  style="position:absolute;top:30;left:120;font-size:9pt;color:#f4f4f4" id="abc">
正在从服务器读取数据，请稍等........
</div>
</center>
<script>
s=new Array();
s[0]="#050626";
s[1]="#0a0b44";
s[2]="#0f1165";
s[3]="#1a1d95";
s[4]="#1c1fa7";
s[5]="#1c20c8";
s[6]="#060cff";
s[7]="#2963f8";
function ls(){
		pimg.innerHTML="";
		for(i=0;i<9;i++){
		pimg.innerHTML+="<input style=\"width:15;height:10;border:0;background:"+s[i]+";margin:1\">";
		}
	}

function rs(){
		pimg.innerHTML="";
		for(i=9;i>-1;i--){
		pimg.innerHTML+="<input style=\"width:15;height:10;border:0;background:"+s[i]+";margin:1\">";
		}
	}

ls();
var g=0;sped=0;
function str(){
	if(pimg.style.pixelLeft<350&&g==0){
	if(sped==0){
		ls();
		sped=1;
		}
	pimg.style.pixelLeft+=2;
	setTimeout("str()",1);
	return;
	}
	g=1;
	if(pimg.style.pixelLeft>-200&&g==1){
	if(sped==1){
		rs();
		sped=0;
		}
	pimg.style.pixelLeft-=2;
	setTimeout("str()",1);
	return;
	}
	g=0;
	str();
}

function flashs(){
if(abc.style.color=="#ffffff"){
	abc.style.color="#707888";
	setTimeout('flashs()',500);
	}
else{
	abc.style.color="#ffffff";
	setTimeout('flashs()',500);
	}
}
flashs();
str();
</script>
<script>
var now1 =new Date()
StarTime_S=now1.getTime()
</script>


<script language=javascript>
var amtdot='0';
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
  URL="./order.php?ModuleId="+ModuleId;
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
  URL="./inflow/index/orderprod.php?ModuleId="+idStr;
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
  URL="./inflow/index/orderfield.php?FolderID="+idStr+"&ModuleId="+ModuleId;
  loc_x=150;
  loc_y=100;
  //window.showModalDialog(URL,self,"edge:raised;scroll:0;status:0;help:0;resizable:1;dialogWidth:700px;dialogHeight:450px;dialogTop:"+loc_y+"px;dialogLeft:"+loc_x+"px");
  //window.open(URL,"11","edge:raised;scroll:0;status:0;help:0;resizable:1;dialogWidth:400px;dialogHeight:350px;dialogTop:"+loc_y+"px;dialogLeft:"+loc_x+"px");
  window.open(URL,"qqq","menubar=0,toolbar=0,status=0,scrollbars=1,resizable=1,width=700px,height=450px,Top="+loc_y+"px,Left="+loc_x+"px");

}
function lookquery(ModuleId)
{
  URL="./module/combquery/index.php?ModuleId="+ModuleId;
  loc_x=400;
  loc_y=150;
  //window.showModalDialog(URL,self,"edge:raised;scroll:0;status:0;help:0;resizable:1;dialogWidth:400px;dialogHeight:150px;dialogTop:"+loc_y+"px;dialogLeft:"+loc_x+"px");
  //window.open(URL,"11","edge:raised;scroll:0;status:0;help:0;resizable:1;dialogWidth:400px;dialogHeight:350px;dialogTop:"+loc_y+"px;dialogLeft:"+loc_x+"px");
  window.open(URL,"qqq","menubar=0,toolbar=0,status=0,scrollbars=1,resizable=1,width=500px,height=150px,Top="+loc_y+"px,Left="+loc_x+"px");

}
function lookhelp(ModuleId,ModuleActionId)
{
  URL="./module/helpquery/index.php?ModuleId="+ModuleId+"&ModuleActionId="+ModuleActionId;
  loc_x=400;
  loc_y=150;
  //window.showModalDialog(URL,self,"edge:raised;scroll:0;status:0;help:0;resizable:1;dialogWidth:400px;dialogHeight:150px;dialogTop:"+loc_y+"px;dialogLeft:"+loc_x+"px");
  //window.open(URL,"11","edge:raised;scroll:0;status:0;help:0;resizable:1;dialogWidth:400px;dialogHeight:350px;dialogTop:"+loc_y+"px;dialogLeft:"+loc_x+"px");
  window.open(URL,"qqq","menubar=0,toolbar=0,status=0,scrollbars=1,resizable=1,width=500px,height=550px,Top="+loc_y+"px,Left="+loc_x+"px");

}
function data_out(ModuleId,ModuleName)
{
  URL="./export.php?ModuleId="+ModuleId+"&ModuleName="+ModuleName;
  loc_x=450;
  loc_y=250;
  window.open(URL,"qqq","menubar=0,toolbar=0,status=0,scrollbars=1,resizable=1,width=300px,height=250px,Top="+loc_y+"px,Left="+loc_x+"px");
}
function data_select(ModuleId,ModuleName)
{
  URL="./setSql.php";
  loc_x=450;
  loc_y=250;
  window.showModalDialog(URL,self,"edge:raised;scroll:0;status:0;help:0;resizable:1;dialogWidth:400px;dialogHeight:350px;dialogTop:"+loc_y+"px;dialogLeft:"+loc_x+"px");
  //window.open(URL,"qqq","menubar=0,toolbar=0,status=0,scrollbars=1,resizable=1,width=350px,height=450px,Top="+loc_y+"px,Left="+loc_x+"px");
}
function data_query(ModuleId,ModuleName)
{
  URL="./query.php?ModuleId="+ModuleId+"&ModuleName="+ModuleName;
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
   Qform1.qflag.value="delete";
   Qform1.deletevalue.value=idStr;
   Qform1.submit();
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
   Qform1.qflag.value="refer";
   Qform1.deletevalue.value=idStr;
   Qform1.updateStateId.value="2";
   Qform1.submit();
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
   Qform1.qflag.value="refer";
   Qform1.deletevalue.value=idStr;
   Qform1.updateStateId.value="3";
   Qform1.submit();
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
   Qform1.qflag.value="refer";
   Qform1.deletevalue.value=idStr;
   Qform1.updateStateId.value="5";
   Qform1.submit();
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

   Qform1.qflag.value="deleteandvoucher";
   Qform1.deletevalue.value=idRowid;
   Qform1.submit();
}
function query()
{
   Qform1.qflag.value="query";
   //alert("11111111111");
   Qform1.submit();
}
function addnew()
{
   if(value_empty("FLD_MUST_STR","FLD_NAME_STR"))
      return (false);
   form1.flag.value="addnew";
   form1.submit();
}

function balance()
{
   //if(value_empty("GRP_NO,UNIT_ID,","FLD_NAME_STR"))
     //return (false);

   form1.flag.value="balance";
   form1.submit();
}
function update()
{
   if(value_empty("FLD_MUST_STR","FLD_NAME_STR"))
      return (false);

   form1.flag.value="update";
   form1.submit();
}
function updateDelete()
{

   form1.flag.value="deleteLev";

   form1.submit();
}
function delLeverList()
{
	//alert("测试");
	var idStr=parent.dept_main.form1.ID_STR.value;

	if (idStr==null){
		idStr="";
		}
  if (idStr=="") {
  	alert("请选择要删除的数据！");
  	return;
  	}
   form1.ID_STR.value=idStr;
   form1.flag.value="deleteLevList";
   form1.submit();
}
function updatevou()
{
   if(value_empty("FLD_MUST_STR","FLD_NAME_STR"))
      return (false);
   //alert("123");
   form1.flag.value="updatevoucher";
   form1.submit();
}

function update2()
{

   form1.flag.value="updatevoucher";
   //alert("123");
   form1.submit();
}
function update3()
{
   form1.flag.value="editvoucher";
   //alert("123");
   form1.submit();
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
  URL="./query/index.php?CODE="+code+"&TABLE="+table+"&FIELD="+field+"&INIT_VALUE="+init_value;
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
  URL="./queryuser/index.php?CODE="+code+"&TABLE="+table+"&FIELD="+field+"&INIT_VALUE="+init_value;
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
  URL="./queryuserid/index.php?CODE="+code+"&TABLE="+table+"&FIELD="+field+"&INIT_VALUE="+init_value;
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
  URL="./bathquery/index.php?CODE="+code+"&TABLE="+table+"&FIELD="+field+"&INIT_VALUE="+init_value;
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
  URL="./lever/code/query/index.php?CODE="+code+"&TABLE="+table+"&FIELD="+field+"&INIT_VALUE="+init_value;
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
  URL="./queryacct/index.php?CODE="+code+"&TABLE="+table+"&FIELD="+field+"&INIT_VALUE="+init_value;
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
  URL="./ongrpnoquery/index.php?CODE="+code+"&TABLE="+table+"&FIELD="+field+"&INIT_VALUE="+init_value;
  //URL="./ongrpnoquery/index.php?FIELD="+field;
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
  URL="./ongrpnoqueryexps/index.php?CODE="+code+"&TABLE="+table+"&FIELD="+field+"&INIT_VALUE="+init_value;
  //URL="./ongrpnoquery/index.php?FIELD="+field;
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
  URL="./payquery/index.php?CODE="+code+"&TABLE="+table+"&FIELD="+field+"&INIT_VALUE="+init_value;
  loc_x=document.body.scrollLeft+event.clientX-event.offsetX+350;
  loc_y=document.body.scrollTop+event.clientY-event.offsetY+100;
  window.showModalDialog(URL,self,"edge:raised;scroll:0;status:0;help:0;resizable:1;dialogWidth:300px;dialogHeight:250px;dialogTop:"+loc_y+"px;dialogLeft:"+loc_x+"px");
  //window.open(URL,"","menubar=0,toolbar=0,status=0,scrollbars=1,resizable=1,width=400px,height=300px,Top="+loc_y+"px,Left="+loc_x+"px");
}

function query_date(field)
{
  init_value=field;
  URL="../../Framework/sms_index/calendar_begin.php?datetime="+init_value;
  loc_x=document.body.scrollLeft+event.clientX-event.offsetX+350;
  loc_y=document.body.scrollTop+event.clientY-event.offsetY+100;
  window.showModalDialog(URL,self,"edge:raised;scroll:0;status:0;help:0;resizable:1;dialogWidth:280px;dialogHeight:205px;dialogTop:"+loc_y+"px;dialogLeft:"+loc_x+"px");
  //window.open(URL,"","menubar=0,toolbar=0,status=0,scrollbars=1,resizable=1,width=400px,height=300px,Top="+loc_y+"px,Left="+loc_x+"px");
}
function query_user(field)
{
  init_value=document.all(field).value;
  code="1";
  table="TD_OA.user";
  URL="../../Framework/frame_depart_notify.php?title=选择记录&tablename=user&fieldid=USER_NAME&fieldname=NICK_NAME&field="+field+"&field2="+field+"_NAME&INIT_VALUE="+init_value+"";
  loc_x=document.body.scrollLeft+event.clientX-event.offsetX+350;
  loc_y=document.body.scrollTop+event.clientY-event.offsetY+100;
  window.showModalDialog(URL,self,"edge:raised;scroll:0;status:0;help:0;resizable:1;dialogWidth:450px;dialogHeight:250px;dialogTop:"+loc_y+"px;dialogLeft:"+loc_x+"px");
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
  URL="./voucher/index.php?FIELDNAME="+field+"&voucher="+ModuleId+"&INIT_VALUE="+init_value+"&row="+row+"&typeid="+typeid;
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

  URL="./balancequery/index.php?CODE="+code+"&TABLE="+table+"&FIELD="+field+"&INIT_VALUE="+init_value+"&GRP_NO="+grp_no;
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
  openURL="./fileupload/index.php";
  loc_x=300;
  loc_y=200;
  window.open(openurl,"fileupload","menubar=0,toolbar=0,status=0,scrollbars=1,resizable=1,width=400px,height=300px,Top="+loc_y+"px,Left="+loc_x+"px");
}

function detailclick(idRowid,ModuleId)
{
   URL="./detail.php?rowid="+idRowid+"&ModuleId="+ModuleId;
   loc_x=254;
   loc_y=162;
  window.showModalDialog(URL,self,"edge:raised;scroll:1;status:1;help:1;resizable:1;dialogWidth:870px;dialogHeight:300px;dialogTop:"+loc_y+"px;dialogLeft:"+loc_x+"px");
  //window.open(URL,"qq","menubar=0,toolbar=0,status=0,scrollbars=1,resizable=1,width=650px,height=250px,Top="+loc_y+"px,Left="+loc_x+"px");
}
function datadetailclick(idRowid,ModuleId)
{
	 var stockName=document.Qform1("stockName").value;
	 var fromdata=document.Qform1("fromdata").value;
	 var enddata=document.Qform1("enddata").value;

   URL="./datadetail.php?rowid="+idRowid+"&ModuleId="+ModuleId+"&stockName="+stockName+"&fromdata="+fromdata+"&enddata="+enddata;
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
   var stockName=document.Qform1("stockName").value;
	 var fromdata=document.Qform1("fromdata").value;
	 var enddata=document.Qform1("enddata").value;
   URL="./datadetail.php?rowid="+idRowid+"&ModuleId="+ModuleId+"&stockName="+stockName+"&fromdata="+fromdata+"&enddata="+enddata+"&State="+State;
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
	 var fromdata=document.Qform1("fromdata").value;
	 var enddata=document.Qform1("enddata").value;
	 var groupByStr=document.Qform1("groupByStr").value;
	 var flowState=document.Qform1("flowState").value;
	 var dataState=document.Qform1("dataState").value;

   URL="./setSql6.php?rowid="+idRowid+"&ModuleId="+ModuleId+"&groupByStr="+groupByStr+"&fromdata="+fromdata+"&enddata="+enddata+"&flowState="+flowState+"&dataState="+dataState+"&chartState="+chartState;//
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

   URL="./setSqlPrint.php?rowid="+idRowid+"&ModuleId="+ModuleId;//
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
   var stockName=document.Qform1("stockName").value;
	 var fromdata=document.Qform1("fromdata").value;
	 var enddata=document.Qform1("enddata").value;
   URL="./datachart.php?rowid="+idRowid+"&ModuleId="+ModuleId+"&stockName="+stockName+"&fromdata="+fromdata+"&enddata="+enddata;
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
   URL="./detail.php?rowid="+idRowid+"&ModuleId="+ModuleId;
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
   URL="./detailsec.php?rowid="+idRowid+"&ModuleId="+ModuleId;
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
   URL="./flowdetail.php?rowid="+idRowid+"&ModuleId="+ModuleId;
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
   URL="./back.php?rowid="+idRowid+"&ModuleId="+ModuleId;
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

 	  if (document.form1(moneyField).value.indexOf(",")>=0){
 	  	return;
 	  	}

   if(document.form1(moneyField).value=="")
      return;
    if(document.form1(moneyField).value.substring(0,1)=="-")
   {
   	   op_Money="-";
   	   document.form1(moneyField).value=document.form1(moneyField).value.substring(1,document.form1(moneyField).value.length);
   }
   else
       op_Money="";

    val_Money=parseFloat(document.form1(moneyField).value);
    document.form1(moneyField).value=ForDight(val_Money,amtdot);
    var value_array_Money=document.form1(moneyField).value.split(".");

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
   document.form1(moneyField).value=op_Money+value_array_Money[0]+"."+value_array_Money[1];
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
   URL="./detailflow.php?rowid="+idRowid+"&ModuleId="+ModuleId+"&dataState="+dataState;
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
  URL="./querystock/index.php?CODE="+code+"&TABLE="+table+"&FIELD="+field+"&INIT_VALUE="+init_value+"&ModuleId="+ModuleId;
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
   URL="./changestate/index.php?rowid="+idStr+"&ModuleId="+ModuleId+"&StateId="+StateId;
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
  URL="../../Framework/frame_depart_notify.php?title=选择记录&tablename=supply&fieldid=supplyid&fieldname=supplyname&field="+field+"&field2="+field+"_NAME&INIT_VALUE="+init_value+"";
  loc_x=document.body.scrollLeft+event.clientX-event.offsetX+350;
  loc_y=document.body.scrollTop+event.clientY-event.offsetY+100;
  window.showModalDialog(URL,self,"edge:raised;scroll:0;status:0;help:0;resizable:1;dialogWidth:500px;dialogHeight:300px;dialogTop:"+loc_y+"px;dialogLeft:"+loc_x+"px");
  //window.open(URL,"","menubar=0,toolbar=0,status=0,scrollbars=1,resizable=1,width=400px,height=300px,Top="+loc_y+"px,Left="+loc_x+"px");
}


var imgpath = "images/";


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
  URL="./checkvalue/index.php?ModuleId="+ModuleId+"&Add_table="+Add_table+"&INIT_VALUE="+init_value+"&field="+field;
  loc_x=document.body.scrollLeft+event.clientX-event.offsetX+350;
  loc_y=document.body.scrollTop+event.clientY-event.offsetY+100;
  window.showModalDialog(URL,self,"edge:raised;scroll:0;status:0;help:0;resizable:1;dialogWidth:450px;dialogHeight:250px;dialogTop:"+loc_y+"px;dialogLeft:"+loc_x+"px");
  //window.open(URL,"","menubar=0,toolbar=0,status=0,scrollbars=1,resizable=1,width=400px,height=300px,Top="+loc_y+"px,Left="+loc_x+"px");
}
</script>


<script language=javascript>

var amtdot='0';
if  (amtdot==""||amtdot==null){
	amtdot=2;
	}
var numdot='0';
if  (numdot==""||numdot==null){
	numdot=2;
	}
var outType='1';
var numdotValue="";
var amtdotValue="";
//alert("numdot="+numdot);
for (i=0;i<numdot;i++){
	numdotValue=numdotValue+"0";
	}
for (i=0;i<amtdot;i++){
	amtdotValue=amtdotValue+"0";
	}
//alert("numdotValue="+numdotValue);
 var tmpStr="";
 var temInt=1;
 var standtmpStr="";
 var dataTemStr="";
 var fieldNum2="";
  function refreshClienArea() {
    var tempStr=hiddenDataId.innerHTML.replace("style=\"DISPLAY:","");
    //alert(tempStr);
    var repStr="value="+temInt+" name=dataNo> <B>"+temInt+"</B>";
    tempStr=tempStr.replace("value=1 name=dataNo> <B>1</B>",repStr);
    tempStr=tempStr.replace("none\"","");
    var repStr2="_wxd_"+temInt;//
    tempStr=tempStr.replace("_wxd_1",repStr2);
    var repStr3="_wxdid_"+temInt;//
    tempStr=tempStr.replace("_wxdid_1",repStr3);
    var repStr5="_wxdnum_"+temInt;//
    tempStr=tempStr.replace("_wxdnum_1",repStr5);
    var repStr6="_wxdrate_"+temInt;//
    tempStr=tempStr.replace("_wxdrate_1",repStr6);
    var repStr4="dataClick('"+temInt+"')";//
    tempStr=tempStr.replace("dataClick('1')",repStr4);
    var sStr=/dxw/g;
    tempStr=tempStr.replace(sStr,temInt);
    //alert(tempStr);
    if (tmpStr=="")
    {
    standtmpStr=tempStr;
    tmpStr = tempStr;
    }else{
    tmpStr += tempStr;
    }
    //alert(tmpStr);
    clientArea.innerHTML = tmpStr;
  }
  function deleteClienArea() {
  	var dataCount=document.form1("dataCount").value;
  	//alert("dataCount:"+dataCount);
    if (tmpStr=="")
    {
     temInt=1;
     alert("无法删除！");
     return;
    }else{
    var cuntMon=0;
    for (var i=1;i<=temInt;i++)
    {
    	if (document.form1("money_"+i).value!=""&&document.form1("money_"+i).value!=null){
    	cuntMon=cuntMon+parseFloat(document.form1("money_"+i).value);
        }
    }
    if (cuntMon!=0&&cuntMon!=null){
    document.form1("amt").value=cuntMon;
    }
    tmpStr = tmpStr.substring(0,tmpStr.length-standtmpStr.length);
    document.form1("dataCount").value=parseFloat(dataCount)-1;
    }
    clientArea.innerHTML = tmpStr;
  }
  function deleteUpdateClienArea() {
  	temInt--;

    if (tmpStr=="")
    {
    	if (dataTemStr!="")
    	{

         dataId.innerHTML = dataTemStr.substring(0,dataTemStr.lastIndexOf("<TABLE"));
         var intDel=dataId.innerHTML.substring(dataId.innerHTML.lastIndexOf("money_")+6,dataId.innerHTML.lastIndexOf("money_")+7)
        var cuntMon=0;
    for (var i=1;i<=parseInt(intDel);i++)
    {

    	if (document.form1("money_"+i).value!=""&&document.form1("money_"+i).value!=null){
    	cuntMon=cuntMon+parseFloat(document.form1("money_"+i).value);
        }
    }
    if (cuntMon!=0&&cuntMon!=null){
    document.form1("amt").value=cuntMon;
    }
        }
    }else{


    tmpStr = tmpStr.substring(0,tmpStr.length-standtmpStr.length);
    clientArea.innerHTML = tmpStr;
    var intDel=clientArea.innerHTML.substring(clientArea.innerHTML.lastIndexOf("money_")+6,clientArea.innerHTML.lastIndexOf("money_")+7)
        var cuntMon=0;
    for (var i=1;i<=parseInt(intDel);i++)
    {

    	if (document.form1("money_"+i).value!=""&&document.form1("money_"+i).value!=null){
    	cuntMon=cuntMon+parseFloat(document.form1("money_"+i).value);
        }
    }
    if (cuntMon!=0&&cuntMon!=null){
    document.form1("amt").value=cuntMon;
    }
    }
  }
  function insertRow() {
  if (event.keyCode == 10){
    tmpStr = clientArea.innerHTML;

    temInt++;
    refreshClienArea();
    }
  }
  function dataQuery(fieldname,moduleId,countStr) {
  if (event.keyCode == 10){
    var dataStr=dataId.innerHTML;
    var hasInt1=dataStr.lastIndexOf("name=dataNo")-2;
    var hasInt2=dataStr.lastIndexOf("name=dataNo")-1;
    var hasInt=dataStr.substring(dataStr.lastIndexOf("name=dataNo")-2,dataStr.lastIndexOf("name=dataNo")-1)
    //alert(hasInt);
    if (temInt==1){
       if (hasInt>temInt){
       temInt=hasInt;
       }
    }
    temInt++;
    tmpStr = clientArea.innerHTML;
    refreshClienArea();
  }else if (event.keyCode == 13||event.keyCode == 0){
  var cliNo=document.form1("hidDataNo").value;
  var supplyId="";
  var stockId="";
  var typeId="0";
  if (document.getElementById("supplyid")!=null){
  supplyId=document.form1("supplyid").value;
  if (supplyId==null||supplyId==""){
  	alert("请先确定单位");
  	return;
  	}
  }
  if (document.getElementById("intype")!=null){
  typeId=document.all("intype").value;
  }
  if (document.getElementById("outtype")!=null){
  typeId=document.all("outtype").value;
  }
  if (document.getElementById("stockId")!=null){
  stockId=document.all("stockId").value;
  }
  //var stockId=document.all("stockId").value;

  var fieldValue=document.form1("id_"+fieldname+"_"+countStr+"_wxd_"+cliNo).value;
  var codeValue=document.form1("id_"+fieldname+"_id"+"_"+countStr+"_wxdid_"+cliNo).value;

  URL="./DataQuery/product.php?moduleId="+moduleId+"&fieldname="+fieldname+"&fieldValue="+fieldValue+"&codeValue="+codeValue+"&countStr="+countStr+"&cliNo="+cliNo+"&supplyId="+supplyId+"&stockId="+stockId+"&typeId="+typeId;
   loc_x=0;
   loc_y=0;
   //alert(URL);
  window.showModalDialog(URL,self,"edge:raised;scroll:0;status:0;help:0;resizable:1;dialogWidth:1000px;dialogHeight:500px;dialogTop:"+loc_y+"px;dialogLeft:"+loc_x+"px");
  //window.open(URL,"qqq","menubar=0,toolbar=0,status=0,scrollbars=1,resizable=1,width=900px,height=450px,Top="+loc_y+"px,Left="+loc_x+"px");

  }
  }
  function orderQuery(fieldname,moduleId,countStr) {
  if (event.keyCode == 10){
    var dataStr=dataId.innerHTML;
    var hasInt1=dataStr.lastIndexOf("name=dataNo")-2;
    var hasInt2=dataStr.lastIndexOf("name=dataNo")-1;
    var hasInt=dataStr.substring(dataStr.lastIndexOf("name=dataNo")-2,dataStr.lastIndexOf("name=dataNo")-1)
    //alert(hasInt);
    if (temInt==1){
       if (hasInt>temInt){
       temInt=hasInt;
       }
    }
    temInt++;
    tmpStr = clientArea.innerHTML;
    refreshClienArea();
  }else if (event.keyCode == 13){
  var cliNo=document.form1("hidDataNo").value;
  var fieldValue=document.form1("id_"+fieldname+"_"+countStr+"_wxd_"+cliNo).value;
  var codeValue=document.form1("id_"+fieldname+"_id"+"_"+countStr+"_wxdid_"+cliNo).value;
  var supplyId=document.form1("supplyid").value;
  var tableDate=document.form1("tabledate").value;
  URL="./orderquery/index.php?moduleId="+moduleId+"&fieldname="+fieldname+"&fieldValue="+fieldValue+"&codeValue="+codeValue+"&countStr="+countStr+"&cliNo="+cliNo+"&supplyId="+supplyId+"&tableDate="+tableDate;
   loc_x=354;
   loc_y=262;
  window.showModalDialog(URL,self,"edge:raised;scroll:0;status:0;help:0;resizable:1;dialogWidth:350px;dialogHeight:250px;dialogTop:"+loc_y+"px;dialogLeft:"+loc_x+"px");
  }
  }
  function amtQuery(fieldname,moduleId,countStr) {
  if (event.keyCode == 10){
    var dataStr=dataId.innerHTML;
    var hasInt1=dataStr.lastIndexOf("name=dataNo")-2;
    var hasInt2=dataStr.lastIndexOf("name=dataNo")-1;
    var hasInt=dataStr.substring(dataStr.lastIndexOf("name=dataNo")-2,dataStr.lastIndexOf("name=dataNo")-1)
    if (temInt==1){
       if (hasInt>temInt){
       temInt=hasInt;
       }
    }
    temInt++;
    tmpStr = clientArea.innerHTML;
    refreshClienArea();
  }else if (event.keyCode == 13||event.keyCode == 0){
  var cliNo=document.form1("hidDataNo").value;
  var supplyId=document.form1("supplyid").value;
  var fieldValue=document.form1("id_"+fieldname+"_"+countStr+"_wxd_"+cliNo).value;
  var codeValue=document.form1("id_"+fieldname+"_id"+"_"+countStr+"_wxdid_"+cliNo).value;
  URL="./amtquery/index.php?moduleId="+moduleId+"&fieldname="+fieldname+"&fieldValue="+fieldValue+"&codeValue="+codeValue+"&countStr="+countStr+"&cliNo="+cliNo+"&supplyId="+supplyId;
   loc_x=354;
   loc_y=262;
  window.showModalDialog(URL,self,"edge:raised;scroll:0;status:0;help:0;resizable:1;dialogWidth:700px;dialogHeight:300px;dialogTop:"+loc_y+"px;dialogLeft:"+loc_x+"px");
  }
  }
  function clickInsertRow() {
    var dataStr=dataId.innerHTML;
    var hasInt1=dataStr.lastIndexOf("name=dataNo")-2;
    var hasInt2=dataStr.lastIndexOf("name=dataNo")-1;
    var hasInt=dataStr.substring(dataStr.lastIndexOf("name=dataNo")-2,dataStr.lastIndexOf("name=dataNo")-1)
    //alert("hasInt:"+hasInt);
    //alert("dataStr:"+dataStr);
    if (temInt==1){
       if (hasInt>temInt){
       temInt=hasInt;
       }
    }
    temInt++;

    var dataCount=document.form1("dataCount").value;
    //alert("33dataCount:"+dataCount);
    //alert("dataCount:"+dataCount);
    var addDataCount=parseFloat(dataCount)+1;
    temInt=addDataCount;
    dataCount=addDataCount.toString();
    //document.form1("dataCount").value=addDataCount.toString();
    //dataCount=document.form1("dataCount").value;
    //alert("33dataCount:"+dataCount);
    document.form1("dataCount").value=dataCount;
    tmpStr = clientArea.innerHTML;
    //alert("tmpStr:"+tmpStr);
    refreshClienArea();
  }
  function clickDeleteRow() {
    tmpStr = clientArea.innerHTML;
    temInt--;
    deleteClienArea();
  }
function secaddnew()
{
   if(value_empty("FLD_MUST_STR","FLD_NAME_STR"))
      return (false);
   form1.flag.value="secaddnew";
   form1.submit();
}
function secupdate()
{
   if(value_empty("FLD_MUST_STR","FLD_NAME_STR"))
      return (false);
   form1.flag.value="secupdate";
   form1.submit();
}
function secamtaddnew()
{
   var i=0;
   var tableName=document.all.form1.Add_table.value
   var idValue="id_stockinid_id_1_wxdid_";
   if (tableName=="getmain")
   {
   idValue="id_stockoutid_id_1_wxdid_";
   }
   var idValue2="thispaymoney_";

   var dataArea=dataId.innerHTML;
   var dataClient=clientArea.innerHTML;
   var dataLast="";
   if (tableName=="getmain")
   {
   dataLast=dataClient.lastIndexOf("id_stockoutid_id_1_wxdid");
   }else{
   dataLast=dataClient.lastIndexOf("id_stockinid_id_1_wxdid");
   }
   var dataLast2=dataClient.indexOf("thispaymoney_");

   var int1=-1;
   if (tableName=="getmain")
   {
   int1=dataClient.substring(dataLast+25,dataLast+26);
   }else{
   int1=dataClient.substring(dataLast+24,dataLast+25);
   }
   var int2=dataClient.substring(dataLast2+13,dataLast2+14);
   if(dataLast==-1){
   	int1=1;
   	}
   var value1;
   var value2;
   var value3=0;
   for (i=1;i<=int1;i++){
   if (tableName=="getmain")
   {
   idValue=idValue.substring(0,25)+i;
   }else{
   idValue=idValue.substring(0,24)+i;
   }
   idValue2=idValue2.substring(0,13)+i;
   if (i==1){
   if (tableName=="getmain")
   {
   value1=document.all.form1.id_stockoutid_id_1_wxdid_1.value;
   }else{
   value1=document.all.form1.id_stockinid_id_1_wxdid_1.value;
   }
   }else{
   value1=document.all(idValue).value;
   }
   if (i==1){
   value2=document.all.form1.thispaymoney_1.value;
   }else{
   value2=document.all(idValue2).value;
   }
       if (value1==null||value1==""){
   	alert("请在第"+i+"行第1列通过双击选择商品信息");
   	return;
   	}
      if (value2==null||value2==""){
   	alert("请在第"+i+"行第4列输入商品数量");
   	return;
   	}
   	var sStr=/,/g;
         value2=value2.replace(sStr,"");
     value3=value3+parseFloat(value2);
   }
   if (document.getElementById("factgetamt")!=null||document.getElementById("checkamt")!=null){
   	var checkamt=document.all("checkamt").value;
   	if (checkamt==null||checkamt==""){
   		checkamt="0";
   		}
   	if (parseFloat(value3)-parseFloat(checkamt)<0){
   		alert("核销金额大于总金额，请重新核销！");
   		return;
   		}
   	document.all("factgetamt").value=parseFloat(value3)-parseFloat(checkamt);

  }



   document.all.form1.paymoney.value=value3;
   form1.flag.value="secorderaddnew";
   if(value_empty("FLD_MUST_STR","FLD_NAME_STR"))
      return (false);
   form1.submit();
}
function secamtupdate()
{
	 var i=0;
   var tableName=document.all("Update_table").value;
   var dataCount=document.all("dataCount").value;
   //alert(dataCount);
   var idValue="id_stockinid_id_1_wxdid_";
   if (tableName=="getmain")
   {
   idValue="id_stockoutid_id_1_wxdid_";
   }
   var idValue2="thispaymoney_";

   var dataArea=dataId.innerHTML;
   var dataClient=clientArea.innerHTML;
   var dataLast="";
   if (tableName=="getmain")
   {
   dataLast=dataClient.lastIndexOf("id_stockoutid_id_1_wxdid");
   }else{
   dataLast=dataClient.lastIndexOf("id_stockinid_id_1_wxdid");
   }
   var dataLast2=dataClient.indexOf("thispaymoney_");


   var int2=dataClient.substring(dataLast2+13,dataLast2+14);

   var value1;
   var value2;
   var value3=0;

   for (i=1;i<=dataCount;i++){
   if (tableName=="getmain")
   {
   idValue=idValue.substring(0,25)+i;
   }else{
   idValue=idValue.substring(0,24)+i;
   }
   //alert("idValue"+idValue);
   idValue2=idValue2.substring(0,13)+i;
   if (i==1){
   if (tableName=="getmain")
   {
   value1=document.all.form1.id_stockoutid_id_1_wxdid_1.value;
   }else{
   value1=document.all.form1.id_stockinid_id_1_wxdid_1.value;
   }
   }else{
   value1=document.all(idValue).value;
   }
   //alert("value1"+value1);
   if (i==1){
   value2=document.all.form1.thispaymoney_1.value;
   }else{
   value2=document.all(idValue2).value;
   }
   //alert("value2"+value2);
       if (value1==null||value1==""){
   	alert("请在第"+i+"行第1列通过双击选择商品信息");
   	return;
   	}
      if (value2==null||value2==""){
   	alert("请在第"+i+"行第4列输入金额");
   	return;
   	}
   	var sStr=/,/g;
         value2=value2.replace(sStr,"");
     value3=value3+parseFloat(value2);
   }
   if (document.getElementById("factgetamt")!=null||document.getElementById("checkamt")!=null){
   	var checkamt=document.all("checkamt").value;
   	if (checkamt==null||checkamt==""){
   		checkamt="0";
   		}
   	if (parseFloat(value3)-parseFloat(checkamt)<0){
   		alert("核销金额大于总金额，请重新核销！");
   		return;
   		}
   	document.all("factgetamt").value=parseFloat(value3)-parseFloat(checkamt);

  }



   document.all.form1.paymoney.value=value3;


   if(value_empty("FLD_MUST_STR","FLD_NAME_STR"))
      return (false);

   form1.flag.value="secorderupdate";
   form1.submit();
}
function clickDeleteUpdateRow() {
    tmpStr = clientArea.innerHTML;
    dataTemStr = dataId.innerHTML;

    deleteUpdateClienArea();
  }
function secorderaddnew()
{
   if(value_empty("FLD_MUST_STR","FLD_NAME_STR"))
      return (false);
   form1.flag.value="secorderaddnew";
   var i=0;
   var idValue="id_productid_id_1_wxdid_";
   var idValue2="plannum_";
   var dataArea=dataId.innerHTML;
   var dataClient=clientArea.innerHTML;
   var dataLastf=dataClient.lastIndexOf("name=dataNo");
   var dataLastl=dataClient.lastIndexOf("><INPUT type=hidden value=");
   var dataLast=dataClient.lastIndexOf("id_productid_id_1_wxdid");
   var dataLast2=dataClient.indexOf("plannum_");
   var subLast=dataClient.substring(dataLastl+26,dataLastf);
   var int1=dataClient.substring(dataLast+24,dataLast+25);
   var int2=dataClient.substring(dataLast2+8,dataLast2+9);
   //alert("dataLast"+dataLast);
   //alert("int1"+int1);
   int1=subLast;
   if(dataLast==-1){
   	int1=1;
   	}
   var value1
   var value2
   var nextMoney;
   var countMoney=0;
   var dataCount=document.form1("dataCount").value;
   var ModuleId=document.form1("ModuleId").value;
   //alert("dataCount:"+dataCount);
   if (dataCount!=null&&dataCount!=""){
   	int1=dataCount;
   	}
   for (i=1;i<=int1;i++){
   idValue=idValue.substring(0,24)+i;
   idValue2=idValue2.substring(0,8)+i;
   if (i==1){
   value1=document.all.form1.id_productid_id_1_wxdid_1.value;
   }else{
   value1=document.all(idValue).value;
   }
   if (i==1){
   value2=document.all.form1.plannum_1.value;
   }else{
   value2=document.all(idValue2).value;
   }
       if (value1==null||value1==""){
   	alert("请在第"+i+"行第1列通过双击选择商品信息");
   	return;
   	}


      if (value2==null||value2==""){
   	alert("请在第"+i+"行第4列输入商品数量");

   	return;
  }else{
  	planNum=parseFloat(value2);
  	//alert("planNum"+planNum);

  	if (isNaN(planNum)){
  	alert("请输入正确的数量");
  	return;
  }

  	}

   var planNum=document.form1("plannum_"+i).value;

      if (document.getElementById("storenum_"+i)!=null){
   var storenumNum=document.form1("storenum_"+i).value;
   var storenumNumFlo=parseFloat(storenumNum);
   if (isNaN(storenumNumFlo)){
   	storenumNum="0";
   	document.form1("storenum_"+i).value="0";
  }

   	if (parseFloat(planNum)>parseFloat(storenumNum)&&(ModuleId=="S04"||ModuleId=="S17")){
   		var alertName="";
   		if (ModuleId=="S04"){
   			alertName="出库";
   		}else if (ModuleId=="S17"){
   			alertName="需求";
   		}
   		if(!window.confirm("商品  "+value1+"  "+alertName+"数量大于库存数量,把"+alertName+"数量修改为库存数量吗？")){
   			if (outType=="1"){
   			document.form1("plannum_"+i).value="0";
   		}
      return false;
    }else{
    	document.form1("plannum_"+i).value=storenumNum;
    	}

   		}
  }


  if (document.getElementById("freenum_"+i)!=null){
   var freeNum=document.form1("freenum_"+i).value;
   var freeNumFlo=parseFloat(freeNum);
   if (isNaN(freeNumFlo)){
   	freeNum="0";
   	document.form1("freenum_"+i).value="0";
  }

   	document.form1("allnum_"+i).value=parseFloat(freeNum)+parseFloat(planNum);
  }



   if (document.getElementById("price_"+i)!=null){
   var planPrice=document.form1("price_"+i).value;
   if (planPrice!=null){
   	planPrice=planPrice.replace(",","");
   	}

   if (isNaN(planPrice)){
   	document.form1("price_"+i).value="0";
   	}
   init_value_order("plannum_"+i);
   init_value_order("price_"+i);
   init_value_order("money_"+i);

   nextMoney=parseFloat(document.form1("plannum_"+i).value)*parseFloat(document.form1("price_"+i).value);
   if (isNaN(nextMoney)){
   	nextMoney="0";
   	}
   	document.form1("money_"+i).value=nextMoney;
   	addMoneyStr("money_"+i);
   if (nextMoney!=null&&nextMoney!=""){
     //if (nextMoney.indexOf(",")>0){
  	 //  nextMoney=nextMoney.replace(",","");
    // }
   countMoney=countMoney+parseFloat(nextMoney);
   }
   //alert("countMoney"+countMoney);
  }
   }
   if (document.getElementById("amt")!=null){
     var sendAmt="0";
   if (document.getElementById("sendAmt")!=null){
   	sendAmt=document.form1("sendAmt").value;
   	if (sendAmt==null||sendAmt==""){
   		sendAmt="0";
   		}
   		if (sendAmt.indexOf(",")>0){
  	   sendAmt=sendAmt.replace(/,/g,"");
       }
   		addMoneyStr("sendAmt");
   	}

   	document.form1("factpayamt").value=countMoney-parseFloat(sendAmt);
   document.form1("amt").value=countMoney;
   //针对付款和实际付款的处理
   var planAmt=document.form1("amt").value;

   if (planAmt==null){
   	planAmt="";
   	}
   	if (document.getElementById("rebate")!=null){
      	var rebate=document.form1("rebate").value;
      	planAmt=countMoney*(parseFloat(rebate)/10);
      	}
   if (planAmt!=""){

     document.form1("factpayamt").value=planAmt-parseFloat(sendAmt);

     //针对税金的处理
     if (document.getElementById("isfax")!=null&&document.getElementById("noFaxAmt")!=null){
      	var faxRate=document.form1("isfax").value;
      	if (faxRate==""||faxRate==null){
      		faxRate="0";
      		}
      	var noFaxAmt=countMoney/(1+parseFloat(faxRate));
      	document.form1("noFaxAmt").value=noFaxAmt;
      	addMoneyStr("noFaxAmt");
      	}


   	}

   var xiaoxieAmt=form1.amt.value;
	 var daxieAmt=atoc(xiaoxieAmt);
	 form1.chinaAmt.value=daxieAmt;

	 addMoneyStr("amt");
   addMoneyStr("factpayamt");
	}
   form1.submit();
}

function check_send(field)
{
   var obj=document.all(field);
   if(obj.value=="")
      return;
   var allamt=document.all("amt").value;
   var thisamt=obj.value;

   if (allamt==""||allamt==null){
   	allamt="0";
   	}else{
   		if (allamt.indexOf(",")>0){
  	   allamt=allamt.replace(/,/g,"");
       }
     }
    if (thisamt.indexOf(",")>0){
  	   thisamt=thisamt.replace(/,/g,"");
       }
   	var rebate="0";
   if (document.getElementById("rebate")!=null){
      	rebate=document.form1("rebate").value;
    }
   // document.all("amt").value=parseFloat(allamt)*(1-parseFloat(rebate))-parseFloat(thisamt);
   // planAmt=countMoney*(1-parseFloat(rebate));
   document.all("factpayamt").value=parseFloat(allamt)*(parseFloat(rebate)/10)-parseFloat(thisamt);

   addMoneyStr(field);
   addNumberStr(field.replace("price","plannum"));
   addMoneyStr("factpayamt");
}

function checkRate(field)
{
   var obj=document.all(field);
   if(obj.value=="")
      return;
      //alert("allamt"+field);
   var allamt=document.all("amt").value;
   var thisRate=obj.value;
   if (allamt==""||allamt==null){
   	allamt="0";
   	}else{
   		if (allamt.indexOf(",")>0){
  	   allamt=allamt.replace(/,/g,"");
       }
     }

   	alert("allamt"+allamt);
   	if (field=="rebate"){
   document.all("factpayamt").value=parseFloat(allamt)*(parseFloat(thisRate)/10);
   addMoneyStr("factpayamt");
   }
   if (field=="isfax"){
   	if (thisRate==""||thisRate==null){
      		thisRate="0";
      		}
   document.all("noFaxAmt").value=parseFloat(allamt)/(1+parseFloat(thisRate));
   addMoneyStr("noFaxAmt");
   }
}
function secorderupdate()
{
   if(value_empty("FLD_MUST_STR","FLD_NAME_STR"))
      return (false);
   form1.flag.value="secorderupdate";

   var i=0;
   var idValue="id_productid_id_1_wxdid_";
   var idValue2="plannum_";
   var dataArea=dataId.innerHTML;
   var dataClient=clientArea.innerHTML;
   //alert("dataClient"+dataClient);
   var dataLast=dataClient.lastIndexOf("id_productid_id_1_wxdid");
   var dataLast2=dataClient.indexOf("plannum_");

   var int1=dataClient.substring(dataLast+24,dataLast+25);
   var int2=dataClient.substring(dataLast2+8,dataLast2+9);
   if(dataLast==-1){
   	int1=1;
   	}
   var value1
   var value2
   var nextMoney;
   var countMoney=0;
   var dataCount=document.form1("dataCount").value;
   var ModuleId=document.form1("ModuleId").value;
   //alert("dataCount:"+dataCount);
   if (dataCount!=null&&dataCount!=""){
   	int1=dataCount;
   	}

   for (i=1;i<=int1;i++){
   idValue=idValue.substring(0,24)+i;
   idValue2=idValue2.substring(0,8)+i;
   if (i==1){
   value1=document.all.form1.id_productid_id_1_wxdid_1.value;
   }else{
   value1=document.all(idValue).value;
   }
   if (i==1){
   value2=document.all.form1.plannum_1.value;
   }else{
   value2=document.all(idValue2).value;
   }
       if (value1==null||value1==""){
   	alert("请在第"+i+"行第1列输入商品信息");
   	return;
   	}
      if (value2==null||value2==""){
   	alert("请在第"+i+"行第4列输入商品数量");
   	return;
   	}

   var planNum=document.form1("plannum_"+i).value;

   //alert(planNum);
   if (document.getElementById("freenum_"+i)!=null){
   var freeNum=document.form1("freenum_"+i).value;
   //var allNum=document.form1("allnum_"+i).value;
   //if (freeNum=null||freeNum="")
   //{
   //	freeNum="0";
   //	}
   	//alert(freeNum);
   	//alert(planNum);
   	document.form1("allnum_"+i).value=parseFloat(freeNum)+parseFloat(planNum);

  }

   if (document.getElementById("price_"+i)!=null){
   var planPrice=document.form1("price_"+i).value;
   if (planPrice!=null){
   	planPrice=planPrice.replace(/,/g,"");
   	}
   if (planPrice==null||planPrice==""){
   	document.form1("price_"+i).value="0";
   }

   if (isNaN(planPrice)){
   	document.form1("price_"+i).value="0";
   	//alert("planPrice"+planPrice);
   	}
   //	alert("c2ountMoney"+document.form1("money_"+i).value);
   init_value_order("plannum_"+i);
   init_value_order("price_"+i);
   init_value_order("money_"+i);
   //alert("icountMoney"+i);
   nextMoney=parseFloat(document.form1("plannum_"+i).value)*parseFloat(document.form1("price_"+i).value);
   //alert("countMoney"+countMoney);
   //alert("c1ountMoney"+document.form1("money_"+i).value);
   if (isNaN(nextMoney)){
   	nextMoney="0";
   	}
   	document.form1("money_"+i).value=nextMoney;
   	addMoneyStr("money_"+i);
   if (nextMoney!=null&&nextMoney!=""){
   countMoney=countMoney+parseFloat(nextMoney);
   }
   //alert("countMoney"+countMoney);
  }
   }
   //alert("countMoney"+countMoney);
   if (document.getElementById("amt")!=null){
   var sendAmt="0";
   if (document.getElementById("sendAmt")!=null){
   	sendAmt=document.form1("sendAmt").value;
   	if (sendAmt==null||sendAmt==""){
   		sendAmt="0";
   		}
   	if (sendAmt.indexOf(",")>0){
  	   sendAmt=sendAmt.replace(/,/g,"");
       }
   	addMoneyStr("sendAmt");
   	}
   	document.form1("amt").value=countMoney;
   	document.form1("factpayamt").value=countMoney-parseFloat(sendAmt);
   //针对付款和实际付款的处理
   var planAmt=document.form1("amt").value;
   if (planAmt==null){
   	planAmt="";
   	}
   	if (planAmt.indexOf(",")>0){
  	   planAmt=planAmt.replace(/,/g,"");
       }
   	if (document.getElementById("rebate")!=null){
      	var rebate=document.form1("rebate").value;
      	planAmt=countMoney*(parseFloat(rebate)/10)
      	}
   if (planAmt!=""){
     document.form1("factpayamt").value=planAmt-parseFloat(sendAmt);

      //针对税金的处理
     if (document.getElementById("isfax")!=null&&document.getElementById("noFaxAmt")!=null){
      	var faxRate=document.form1("isfax").value;
      	if (faxRate==""||faxRate==null){
      		faxRate="0";
      		}
      	var noFaxAmt=countMoney/(1+parseFloat(faxRate));
      	document.form1("noFaxAmt").value=noFaxAmt;
      	addMoneyStr("noFaxAmt");
      	}

   	}



   var xiaoxieAmt=form1.amt.value;
	 var daxieAmt=atoc(xiaoxieAmt);

	 form1.chinaAmt.value=daxieAmt;

	  addMoneyStr("amt");
   addMoneyStr("factpayamt");
	}

   form1.submit();
}
function secorderquery()
{
   Qform1.qflag.value="secorderquery";
   Qform1.submit();
}
function doIn()
{
   var idRowid=document.all("ID_STR").value;
   if(idRowid=="")
   {
      alert("请至少选中一项进行入库！");
      return false;
   }
   idRowid=idRowid.substring(0,idRowid.length-1);
   var ModuleId=document.all("ModuleId").value;
   URL="./doStock.php?mainrowid="+idRowid+"&ModuleId="+ModuleId+"&doState='0'";
   loc_x=254;
   loc_y=162;
  window.open(URL,"qq","menubar=0,toolbar=0,status=0,scrollbars=1,resizable=1,width=650px,height=250px,Top="+loc_y+"px,Left="+loc_x+"px");
}
function doOut()
{
   var idRowid=document.all("ID_STR").value;
   if(idRowid=="")
   {
      alert("请至少选中一项进行出库！");
      return false;
   }
   idRowid=idRowid.substring(0,idRowid.length-1);
   var ModuleId=document.all("ModuleId").value;
   URL="./outStock.php?mainrowid="+idRowid+"&ModuleId="+ModuleId+"&doState='1'";
   loc_x=254;
   loc_y=162;
  window.open(URL,"qq","menubar=0,toolbar=0,status=0,scrollbars=1,resizable=1,width=650px,height=250px,Top="+loc_y+"px,Left="+loc_x+"px");
}
function stockin()
{
   form1.flag.value="stockin";
   form1.submit();
}
function stockout()
{
   form1.flag.value="stockout";
   form1.submit();
}
function dataClick(dataNo){
form1.hidDataNo.value=dataNo
}
function check_value_order(field)
{

   if (field.indexOf("money")>=0){
   return;
   }

   var moduleId=document.form1("ModuleId").value;

   var sStr=/freenum/g;
   if (field.indexOf("freenum")>=0){
   	var thissStr=/freenum/g;
   	var thisPlanNum=document.form1(field.replace(thissStr,"plannum")).value;
   	var thisFreeNum=document.form1(field).value;
   	if (thisPlanNum==null||thisPlanNum==""){
   	thisPlanNum="0";
   	}
   	if (thisFreeNum==null||thisFreeNum==""){
   	thisFreeNum="0";
   	}
        if (isNaN(parseFloat(thisPlanNum))){
           alert("请输入正确的数据");
        return;
        }
        if (isNaN(parseFloat(thisFreeNum))){
           alert("请输入正确的数据");
        return;
        }
   	document.form1(field.replace(thissStr,"allnum")).value=parseFloat(thisPlanNum)+parseFloat(thisFreeNum);

   		var fieldNo=field.substring(field.lastIndexOf("_")+1,field.length);

   	var stockStr="num_productid_id_1_wxdnum_"+fieldNo;
    var stocknum=document.form1(stockStr).value;
    //alert(stockStr+"该商品的出库数量大与库存数量"+stocknum);

    var thisNum=document.form1(field.replace(sStr,"allnum")).value;  //ModuleId
    if (stocknum==null||stocknum==""){
    	stocknum=thisNum;
    	}
    	//alert(field.replace(sStr,"plannum")+"=="+stocknum+"==="+thisNum);
    if (parseFloat(stocknum)<parseFloat(thisNum)&&document.form1("ModuleId").value=="S04")
    {
    	//alert(document.form1("StockIsNeg").value);
    	if (document.form1("StockIsNeg").value=="1"){
     var subnum=parseFloat(thisNum)-parseFloat(stocknum);

    alert("该商品的出库数量大与库存数量"+subnum);
    document.form1(field.replace(sStr,"plannum")).value="0";
    document.form1(field.replace(sStr,"allnum")).value="0";
    document.form1(field.replace(sStr,"freenum")).value="0";
    }
    //return;
    }

   	}

   var obj=document.form1(field);
   sStr=/price/g;
   var fieldInt=field.indexOf("price");
   if (fieldInt>=0){
   var fieldNum2="";
   var fieldNum=field.substring(6,field.length);
   var dataCount=document.form1("dataCount").value;
   //alert("dataCount"+dataCount);
   if (dataCount!=null&&dataCount!=""){
   	fieldNum=dataCount;
   	}


   if (fieldNum2==""){
   fieldNum2=fieldNum;
   }else if (fieldNum2>fieldNum){
   fieldNum=fieldNum2;
   }else if (fieldNum>fieldNum2){
   fieldNum2=fieldNum;
   }
   //alert("业务数据的fieldNum2"+fieldNum2);
   //针对赠品出库的处理

   var rateStr="num_productid_id_1_wxdrate_"+fieldNum2;
   if (field.indexOf("price")>=0&&(moduleId=="S02"||moduleId=="S04")){
   var thisPlanNum=document.form1(field.replace(sStr,"plannum")).value;
   if (thisPlanNum==null||thisPlanNum==""){
   	thisPlanNum="0";
   	}
      if (isNaN(parseFloat(thisPlanNum))){
           alert("请输入正确的数据");
          document.form1(field.replace(sStr,"plannum")).value="";
        return;
        }
   	var freenum=0;
   	var allnum=0;
   	//alert("rateStr"+rateStr);
    var rateNum=document.form1(rateStr).value;

    if (rateNum==null||rateNum==""){
   	rateNum="0";
   	}
   if (isNaN(parseFloat(rateNum))){
           alert("商品的赠品率设置不正确");
   return;
        }

    //alert("rateNum"+rateNum);
   	freenum=parseFloat(thisPlanNum)*parseFloat(rateNum);
   	allnum=parseFloat(thisPlanNum)*(parseFloat(rateNum)+1);
    //alert("freenum"+freenum);
    //alert("allnum"+allnum);
    var freenumstr=freenum.toString();
    if (freenumstr.indexOf(".")>=0){
    	freenumstr=freenumstr.substring(0,freenumstr.indexOf("."));
    	}
    var allnumstr=allnum.toString();
    if (allnumstr.indexOf(".")>=0){
    	allnumstr=allnumstr.substring(0,allnumstr.indexOf("."));
    	}
    	if (document.form1(field.replace(sStr,"freenum")).value==null||document.form1(field.replace(sStr,"freenum")).value==""){
       document.form1(field.replace(sStr,"freenum")).value=freenumstr;
   	   document.form1(field.replace(sStr,"allnum")).value=allnumstr;
      }else{

      	document.form1(field.replace(sStr,"allnum")).value=parseFloat(thisPlanNum)+parseFloat(document.form1(field.replace(sStr,"freenum")).value);
      	}
   }


   //赠品处理结束

   //alert("业务数据的fieldNum"+fieldNum+"dataCount"+dataCount);

   var moneyField=field;
    moneyField=moneyField.replace(sStr,"money");
    if(obj.value==""||obj.value==null){
   	document.form1(moneyField).value="";
      return;
    }

   var perMoney=document.form1(moneyField).value;
   document.form1(moneyField).value="";
   //alert(document.form1(field.replace(sStr,"plannum")).value);

   if (document.form1(field.replace(sStr,"plannum")).value==""){
   document.form1(field.replace(sStr,"plannum")).value="0";
   document.form1(moneyField).value=parseFloat(document.form1(field.replace(sStr,"plannum")).value)*parseFloat(obj.value);//parseFloat(obj.value)
   }else{ //num_productid_id_1_wxdnum_1
   	//alert("该商品的出库数量大与库存数量");
   	//alert("1该商品的出库数量大与库存数量"+field.length);
   	//alert("2该商品的出库数量大与库存数量"+field.lastIndexOf("_"));
   	var fieldNo=field.substring(field.lastIndexOf("_")+1,field.length);

   	var stockStr="num_productid_id_1_wxdnum_"+fieldNo;
    var stocknum=document.form1(stockStr).value;
    //alert(stockStr+"该商品的出库数量大与库存数量"+stocknum);

    if (document.getElementById(field.replace(sStr,"allnum"))!=null){
    var thisNum=document.form1(field.replace(sStr,"allnum")).value;  //ModuleId


    if (stocknum==null||stocknum==""){
    	stocknum=thisNum;
    	}
    }
    	//alert(field.replace(sStr,"plannum")+"=="+stocknum+"==="+thisNum);
    if (parseFloat(stocknum)<parseFloat(thisNum)&&document.form1("ModuleId").value=="S04")
    {
    	//alert(document.form1("StockIsNeg").value);
    	if (document.form1("StockIsNeg").value=="1"){
     var subnum=parseFloat(thisNum)-parseFloat(stocknum);

    alert("该商品的出库数量大与库存数量"+subnum);
    document.form1(field.replace(sStr,"plannum")).value="0";
    document.form1(field.replace(sStr,"allnum")).value="0";
    document.form1(field.replace(sStr,"freenum")).value="0";
    }
    //return;
    }
   //alert("该商品的出库数量大与库存数量2"+document.form1(field.replace(sStr,"plannum")).value);
   //alert("该商品的出库数量大与库存数量3"+obj.value);
   document.form1(moneyField).value=parseFloat(document.form1(field.replace(sStr,"plannum")).value)*parseFloat(obj.value);//parseFloat(obj.value)
   }


   if (document.form1("amt").value==""){
   document.form1("amt").value=document.form1(moneyField).value;
   }else{
   var i=0;
   var nextMoney;
   var countMoney=0;
   for (i=1;i<=fieldNum;i++)
   {
   init_value_order("money_"+i);
   nextMoney=document.form1("money_"+i).value;
   if (nextMoney!=null&&nextMoney!=""){
   countMoney=countMoney+parseFloat(nextMoney);
   }
   }
   document.form1("amt").value=countMoney
   //alert("前"+document.form1(moneyField).value);
   addMoneyStr(moneyField);

   //alert("后"+document.form1(moneyField).value);

   }

   //alert(document.form1(moneyField).value);
   //针对付款和实际付款的处理
   planAmt=document.form1("amt").value;
   if (planAmt==null){
   	planAmt="";
  }else{
  	   if (planAmt.indexOf(",")>0){
  	   planAmt=planAmt.replace(/,/g,"");
       }
  	}
    sendAmt="0";
   //针对运费的处理
   if (document.getElementById("sendAmt")!=null){
   	var sendAmt=document.form1("sendAmt").value;
   	if (sendAmt==null||sendAmt==""){
   		sendAmt="0";
   		}
   	var sendAmtDou=parseFloat(sendAmt);
   	document.form1("factpayamt").value=parseFloat(planAmt)-parseFloat(sendAmt);
   	planAmt=document.form1("amt").value;
   	if (planAmt==null){
   	planAmt="";
    }else{
    	//alert("planAmt"+planAmt+"indexOf"+planAmt.indexOf(","));
  	   if (planAmt.indexOf(",")>0){
  	   planAmt=planAmt.replace(/,/g,"");
       }
  	}
   	addMoneyStr("sendAmt");

   	}
   	if (document.getElementById("rebate")!=null){
      	var rebate=document.form1("rebate").value;
      	if (rebate==null||rebate==""){
      		rebate="0";
      		}
      	planAmt=parseFloat(planAmt)*(parseFloat(rebate)/10)-parseFloat(sendAmt);
      	}

   	if (planAmt!=""){
     document.form1("factpayamt").value=planAmt;
     	planAmt=document.form1("amt").value;
   	if (planAmt==null){
   	planAmt="";
    }else{
  	   if (planAmt.indexOf(",")>0){
  	   planAmt=planAmt.replace(/,/g,"");
       }
  	}

     //针对税金的处理
     if (document.getElementById("isfax")!=null&&document.getElementById("noFaxAmt")!=null){
      	var faxRate=document.form1("isfax").value;
      	if (faxRate==""||faxRate==null){
      		faxRate="0";
      		}
      	var noFaxAmt=parseFloat(planAmt)/(1+parseFloat(faxRate))
      	document.form1("noFaxAmt").value=noFaxAmt;
      	addMoneyStr("noFaxAmt");
      	}
   	}
   //	alert("前"+document.form1(field.replace("price","plannum")).value);
   addMoneyStr("amt");
   addMoneyStr("factpayamt");
   addNumberStr(field.replace("price","plannum"));
  //alert("后"+document.form1(moneyField).value);
  // 	alert(planAmt);
   if(obj.value.substring(0,1)=="-")
   {
   	   op="-";
   	   obj.value=obj.value.substring(1,obj.value.length);
   }
   else
       op="";
   val=parseFloat(obj.value);

   if(isNaN(val))
   {
      alert("非法的数字");
      obj.focus();
      return;
   }
   obj.value=ForDight(val,amtdot);
   var value_array=obj.value.split(".");
   //格式化整数位
   start=0;
   len=0;
   val_int="";
   while(1)
   {
   	  if((value_array[0].length-start)%3==0)
   	     len=3;
   	  else
   	  	 len=value_array[0].length%3;

      if(val_int=="")
         val_int=value_array[0].substring(start,start+len);
      else
         val_int=val_int+","+value_array[0].substring(start,start+len);
   	  start=len+start;

   	  if(start>=value_array[0].length)
   	     break;
   }
   if(val_int!="")
      value_array[0]=val_int;
   if(value_array.length==1)
   	  value_array[1]="00";
   else if(value_array.length==amtdot)
   {
   	  if(value_array[1].length==0)
   	    value_array[1]="00";
   	  else if(value_array[1].length==1)
   	    value_array[1]=value_array[1]+"0";
   	  else if(value_array[1].length>=amtdot)
   	    value_array[1]=value_array[1].substr(0,amtdot);
   }
   obj.value=op+value_array[0]+"."+value_array[1];

}
}
function  init_value_order(field)
{
   var obj=document.form1(field);

   if (obj.value==""||obj.value==null)
      return;
   re=/,/g;
   obj.value=obj.value.replace(re,"");
}


function check_value_amt(field)
{
   var obj=document.form1(field);
   if(obj.value==""||obj.value==null)
      return;

   if (field.indexOf("allpaymoney_")>=0){
   	 return;
   	}
   	if (field.indexOf("haspaymoney_")>=0){
   	 return;
   	}
   	//alert(field);
   var oldAmt=document.form1("tempAmt").value;
   var allAmt=document.form1("paymoney").value;
   var newAmt=obj.value;
   //alert("测试点："+fieldNum);
   //alert("就金额"+oldAmt+"新金额"+obj.value+"总金额"+allAmt);
   var fieldNo=field.substring(field.lastIndexOf("_")+1,field.length);
   //alert("测试点："+fieldNo);
   var allAmtName="allpaymoney_"+fieldNo;
   var hasAmtName="haspaymoney_"+fieldNo;

   var thisAllAmt=document.form1(allAmtName).value;
   var thishasAmt=document.form1(hasAmtName).value;
   var moduelId=document.form1(moduelId).value;
   thisAllAmt=subsymb(thisAllAmt);
   thishasAmt=subsymb(thishasAmt);
   var toPayAmt=parseFloat(thisAllAmt)-parseFloat(thishasAmt);
   var thisSubAmt=parseFloat(newAmt)-toPayAmt;
   if (thisSubAmt>0)
   {
    if(!window.confirm("本次付款金额大于应付款金额:"+thisSubAmt+",继续进行吗？"))
      {
      document.form1(field).value=addsymb(parseFloat(oldAmt));
      return false;
      }
   }

   allAmt=subsymb(allAmt);
   oldAmt=subsymb(oldAmt);

   var tempAmt=parseFloat(allAmt)-parseFloat(oldAmt)+parseFloat(newAmt);
   allAmt=addsymb(tempAmt);
   document.form1("paymoney").value=allAmt;
   document.form1(field).value=addsymb(parseFloat(newAmt));
}

function  init_value_amt(field)
{
   var obj=document.form1(field);

   if (obj.value==""||obj.value==null)
      return;
   re=/,/g;
   obj.value=obj.value.replace(re,"");

   document.form1("tempAmt").value=obj.value;//临时金额
}

function addsymb(fieldValue)
{
	fieldValue=fieldValue.toString();
   if(fieldValue=="")
      return;

   if(fieldValue.substring(0,1)=="-")
   {
   	   op="-";
   	   fieldValue=fieldValue.substring(1,fieldValue.length);
   }
   else
       op="";

   val=parseFloat(fieldValue);
   if(isNaN(val))
   {
      alert("非法的数字");
      return;
   }

  if(fieldValue.indexOf(".")<0){
  	fieldValue=fieldValue+".00";
  	}

   var value_array=fieldValue.split(".");


   start=0;
   len=0;
   val_int="";


   while(1)
   {
   	  if((value_array[0].length-start)%3==0)
   	     len=3;
   	  else
   	  	 len=value_array[0].length%3;

      if(val_int=="")
         val_int=value_array[0].substring(start,start+len);
      else
         val_int=val_int+","+value_array[0].substring(start,start+len);
   	  start=len+start;

   	  if(start>=value_array[0].length)
   	     break;
   }
   if(val_int!="")
      value_array[0]=val_int;

   //格式化小数位
   if(value_array.length==1)
   	  value_array[1]="00";
   else if(value_array.length==amtdot)
   {
   	  if(value_array[1].length==0)
   	    value_array[1]="00";
   	  else if(value_array[1].length==1)
   	    value_array[1]=value_array[1]+"0";
   	  else if(value_array[1].length>=amtdot)
   	    value_array[1]=value_array[1].substr(0,amtdot);
   }

   fieldValue=op+value_array[0]+"."+value_array[1];

    return fieldValue;
}

function  subsymb(fieldValue)
{
   if (fieldValue=="")
      return;

   re=/,/g;
   fieldValue=fieldValue.replace(re,"");

   return fieldValue;
}
function atoc(numberValue){
  var numberValue=new String(Math.round(numberValue*100)); // 数字金额
  var chineseValue="";          // 转换后的汉字金额
  var String1 = "零壹贰叁肆伍陆柒捌玖";       // 汉字数字
  var String2 = "万仟佰拾亿仟佰拾万仟佰拾元角分";     // 对应单位
  var len=numberValue.length;         // numberValue 的字符串长度
  var Ch1;             // 数字的汉语读法
  var Ch2;             // 数字位的汉字读法
  var nZero=0;            // 用来计算连续的零值的个数
  var String3;            // 指定位置的数值
  if(len>15){
   alert("超出计算范围");
   return "";
  }
  if (numberValue==0){
   chineseValue = "零元整";
   return chineseValue;
  }
  String2 = String2.substr(String2.length-len, len);   // 取出对应位数的STRING2的值

  for(var i=0; i<len; i++){

   String3 = parseInt(numberValue.substr(i, 1),10);   // 取出需转换的某一位的值
   //alert(String3);
   if ( i != (len - 3) && i != (len - 7) && i != (len - 11) && i !=(len - 15) ){

    if ( String3 == 0 ){

     Ch1 = "";
     Ch2 = "";
     nZero = nZero + 1;

    }else if ( String3 != 0 && nZero != 0 ){

     Ch1 = "零" + String1.substr(String3, 1);
     Ch2 = String2.substr(i, 1);
     nZero = 0;

    }else{

     Ch1 = String1.substr(String3, 1);
     Ch2 = String2.substr(i, 1);
     nZero = 0;
    }
   }else{              // 该位是万亿，亿，万，元位等关键位
    if( String3 != 0 && nZero != 0 ){

     Ch1 = "零" + String1.substr(String3, 1);
     Ch2 = String2.substr(i, 1);
     nZero = 0;

    }else if ( String3 != 0 && nZero == 0 ){

     Ch1 = String1.substr(String3, 1);
     Ch2 = String2.substr(i, 1);
     nZero = 0;

    }else if( String3 == 0 && nZero >= 3 ){

     Ch1 = "";
     Ch2 = "";
     nZero = nZero + 1;

    }else{

     Ch1 = "";
     Ch2 = String2.substr(i, 1);
     nZero = nZero + 1;

    }

    if( i == (len - 11) || i == (len - 3)) {    // 如果该位是亿位或元位，则必须写上
     Ch2 = String2.substr(i, 1);
    }

   }
   chineseValue = chineseValue + Ch1 + Ch2;

  }

  if ( String3 == 0 ){           // 最后一位（分）为0时，加上“整”
   chineseValue = chineseValue + "整";
  }

  return chineseValue;
 }

 function addMoneyStr(moneyField){

 	  if (document.form1(moneyField).value.indexOf(",")>=0){
 	  	return;
 	  	}

   if(document.form1(moneyField).value=="")
      return;
    if(document.form1(moneyField).value.substring(0,1)=="-")
   {
   	   op_Money="-";
   	   document.form1(moneyField).value=document.form1(moneyField).value.substring(1,document.form1(moneyField).value.length);
   }
   else
       op_Money="";

    val_Money=parseFloat(document.form1(moneyField).value);
    document.form1(moneyField).value=ForDight(val_Money,amtdot);
    var value_array_Money=document.form1(moneyField).value.split(".");

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
   	  value_array_Money[1]=amtdotValue;
   else if(value_array_Money.length==amtdot)
   {
   	  if(value_array_Money[1].length==0)
   	    value_array_Money[1]=amtdotValue;
   	  else if(value_array_Money[1].length==1)
   	    value_array_Money[1]=value_array_Money[1]+"0";
   	  else if(value_array_Money[1].length>=amtdot)
   	    value_array_Money[1]=value_array_Money[1].substr(0,amtdot);
   }

   if (amtdot==0){
   document.form1(moneyField).value=op_Money+value_array_Money[0];
   }else {
   document.form1(moneyField).value=op_Money+value_array_Money[0]+"."+value_array_Money[1];
  }

 	}

 function addNumberStr(moneyField){

 	  if (document.form1(moneyField).value.indexOf(",")>=0){
 	  	return;
 	  	}

   if(document.form1(moneyField).value=="")
      return;
    if(document.form1(moneyField).value.substring(0,1)=="-")
   {
   	   op_Money="-";
   	   document.form1(moneyField).value=document.form1(moneyField).value.substring(1,document.form1(moneyField).value.length);
   }
   else
       op_Money="";

    val_Money=parseFloat(document.form1(moneyField).value);
    document.form1(moneyField).value=ForDight(val_Money,numdot);


  	var value_array_Money=document.form1(moneyField).value.split(".");

   start_Money=0;
   len_Money=0;
   val_int_Money="";


   if(val_int_Money!="")
      value_array_Money[0]=val_int_Money;

   if(value_array_Money.length==1)
   	  value_array_Money[1]=numdotValue;
   else if(value_array_Money.length==numdot)
   {
   	  if(value_array_Money[1].length==0)
   	    value_array_Money[1]=numdotValue;
   	  else if(value_array_Money[1].length==1)
   	    value_array_Money[1]=value_array_Money[1]+"0";
   	  else if(value_array_Money[1].length>=numdot)
   	    value_array_Money[1]=value_array_Money[1].substr(0,numdot);
   }
   if (numdot==0){
   document.form1(moneyField).value=op_Money+value_array_Money[0];
   }else {
   document.form1(moneyField).value=op_Money+value_array_Money[0]+"."+value_array_Money[1];
  }

 	}
</script>













<script>
function outProduct(countStr){
	//alert("选择出库数outProduct"+countStr);
	var fieldname="productid";
  var cliNo=document.form1("hidDataNo").value;
  //alert(cliNo);
  countStr="1";
  var supplyId=document.form1("supplyid").value;
  var stockId=document.all("stockId").value;
  //var fieldValue=document.form1("id_productid_"+countStr+"_wxd_"+cliNo).value;
  var codeValue=document.form1("id_productid_id"+"_"+countStr+"_wxdid_"+cliNo).value;
 //
  URL="./getstock.php?codeValue="+codeValue+"&countStr="+countStr+"&cliNo="+cliNo+"&supplyId="+supplyId+"&stockId="+stockId;
   loc_x=354;
   loc_y=262;
  //alert(URL);
  window.showModalDialog(URL,self,"edge:raised;scroll:0;status:0;help:0;resizable:1;dialogWidth:700px;dialogHeight:300px;dialogTop:"+loc_y+"px;dialogLeft:"+loc_x+"px");
 	//window.open(URL,"qq","menubar=0,toolbar=0,status=0,scrollbars=1,resizable=1,width=650px,height=250px,Top="+loc_y+"px,Left="+loc_x+"px");
}

function  getStock(field)
{
	//alert("选择出库数field"+field);
   var obj=document.form1(field);
   if (obj.value==""||obj.value==null){
    //  return;
   } else{
   re=/,/g;
   obj.value=obj.value.replace(re,"");
  }
   var outNum=field.substring(field.indexOf("_"),field.length);
	 var outNum=outNum.substring(1,outNum.length);
	 //alert("选择出库数"+outNum);
   outProduct(outNum);

}

function  onblurStock(field)
{
  var outNum=field.substring(field.indexOf("_"),field.length);
	var outstr="outRowIdplannum"+outNum;
	 //alert("选择出库数"+outstr);
   var obj=document.form1(outstr).value;
   //alert("选择出库数"+outstr+":"+obj);
   if (obj==""||obj==null){
   alert("选择出库数");
   //document.form1(outstr).value
   return;
  }else{
   check_value_order(field);
  }
}

function  getBuyPlan()
{
	//alert("选择出库数field"+field);
	if(value_empty("FLD_MUST_STR","FLD_NAME_STR"))
      return (false);
   var supplyId=document.form1("supplyid").value;
   var ModuleId=document.form1("ModuleId").value;
   var tablecode=document.form1("tablecode").value;
   var tabledate=document.form1("tabledate").value;
   var stockid=document.form1("stockid").value;
   var intype=document.form1("intype").value;
   var isfax=document.form1("isfax").value;
   var buyman=document.form1("buyman").value;

  URL="getbuyplanin_index.php?supplyId="+supplyId+"&ModuleId="+ModuleId+"&tablecode="+tablecode+"&tabledate="+tabledate+"&stockid="+stockid+"&intype="+intype+"&isfax="+isfax+"&buyman="+buyman;
   loc_x=60;
   loc_y=100;
  //alert(URL);
  //window.showModalDialog(URL,self,"edge:raised;scroll:0;status:0;help:0;resizable:1;dialogWidth:700px;dialogHeight:300px;dialogTop:"+loc_y+"px;dialogLeft:"+loc_x+"px");
 	window.open(URL,"qq","menubar=0,toolbar=0,status=0,scrollbars=1,resizable=1,width=950px,height=550px,Top="+loc_y+"px,Left="+loc_x+"px");

}



</script>

<html>
<head>
<title>采购订单生成入库单据管理</title>

</head>

<body class="bodycolor">
<div align="center">
<table border="0" width="100%" cellspacing="0" cellpadding="3" class="small">
  <tr>

    </td>
  </tr>
</table>



<form name="form1" action="?action=dataDeal" method="post">

<table width="95%" class="TableBlock">
  <tr>
    <td nowrap align="left" class="TableHeader" colspan="2">&nbsp;&nbsp;<b>采购入库生成管理      ：以下项目带*号的为必填项目</b></td>
    <td nowrap align="left" class="TableHeader" colspan="2">&nbsp</td>
  </tr>

   <tr>
       <td nowrap width="100" align="right" class="TableContent"><b>入库单编号&nbsp;</b></td>
       <td nowrap align="left" class="TableData">

           <input  readonly type="text" name="tablecode" value="<?php echo $_GET['tablecode']?>" size="15"  maxlength="50"   class="SmallInput">
       </td>

       <td nowrap width="100" align="right" class="TableContent"><b>入库日期&nbsp;</b></td>
       <td nowrap align="left" class="TableData">

          <input type="text" name="tabledate" value="<?php echo date("Y-m-d")?>" readonly  class="SmallStatic">
          <input type="button" name="b1" value="浏览" class="SmallButton" onclick="query_date('tabledate');">
<b>*</b>
       </td>

   </tr>

   <tr>
       <td nowrap width="100" align="right" class="TableContent"><b>供应商&nbsp;</b></td>
       <td nowrap align="left" class="TableData">

           <input type="text" name="supplyid_NAME" readonly  class="SmallStatic">
           <input type="hidden" name="supplyid" value="">
           <input type="hidden" name="supplyid_CODE" value="1">
           <input type="hidden" name="supplyid_TABLE" value="supply">
           <input type="button" name="b1" value="查询" class="SmallButton" onclick="query_supply('supplyid');">
<b>*</b>
       </td>

       <td nowrap width="100" align="right" class="TableContent"><b>仓库名称&nbsp;</b></td>
       <td nowrap align="left" class="TableData">

	<?php
		print_select_single_select2("stockid",'',"stock","ROWID","name",$intype);
	?>
<b>*</b>
       </td>

   </tr>
 <input   type="hidden" name="amt" value="<?php echo $amt?>" >
 <input   type="hidden" name="factpayamt" value="<?php echo $factpayamt?>">
   <tr>
       <td nowrap width="100" align="right" class="TableContent"><b>入库类型&nbsp;</b></td>
       <td nowrap align="left" class="TableData">

      <?php
		print_select_single_select2("intype",'03',"intype","id","name",$intype);
	?>

       </td>

    <td nowrap width="100" align="right" class="TableContent"><b>采购业务员&nbsp;</b></td>
       <td nowrap align="left" class="TableData">

           <input   type="text" name="buyman_NAME" value="<?php echo returntablefield("user","USER_NAME",$buyman,"NICK_NAME");?>" size="15"  maxlength="50"   onclick="query_user('buyman');"  class="SmallInput">
		   <input   type="hidden" name="buyman" value="<?php echo $buyman?>"size="15"  maxlength="50">

       </td>

   </tr>
<input   type="hidden" name="payamt" value="<?php echo $payamt?>">
 <input type="hidden" name="sendAmt" value="<?php echo $sendAmt?>" size="15">
   <tr>
       <td nowrap width="100" align="right" class="TableContent"><b>税率&nbsp;</b></td>
       <td nowrap align="left" class="TableData">

           <input   type="text" name="isfax" value="<?php echo $isfax?>" size="10"  maxlength="50" onkeypress="check_input_num('NUMBER')"  class="SmallInput">

       </td>

       <td nowrap width="100" align="right" class="TableContent"><b>扣税金额&nbsp;</b></td>
       <td nowrap align="left" class="TableData">

           <input  readonly type="text" name="noFaxAmt" value="<?php echo $noFaxAmt?>" size="15"  maxlength="50" onkeypress="check_input_num('MONEY')" onfocus="init_value('noFaxAmt')" onblur="check_value('noFaxAmt')" class="SmallInput">

       </td>

   </tr>

      <input type="hidden" name="a_count" value="15">
      <input type="hidden" name="Add_fieldName" value="tablecode,tabledate,supplyid,amt,stockid,factpayamt,intype,payamt,isfax,noFaxAmt,buyman">
      <input type="hidden" name="Add_fieldType" value="CHAR,DATE,CHAR,MONEY,CHAR,MONEY,CHAR,MONEY,CHAR,MONEY,NUMBER,MONEY,DATE,CHAR,CHAR">
      <input type="hidden" name="Add_table" value="stockinmain">
      <input type="hidden" name="Add_url" value="plantoin/add.php">
      <input type="hidden" name="Back_url" value="plantoin/index.php">
      <input type="hidden" name="FLD_MUST_STR" value="tabledate,supplyid,stockid,">
      <input type="hidden" name="FLD_NAME_STR" value="入库日期,供应商,仓库名称,">
      <input type="hidden" name="ModuleId" value="S02">
       <input type="hidden" name="ExchRate" value="8.17">
</table>


<div id="clientArea">
</div>
<div id="hiddenId">
      <input type="hidden" name="flag">
      <input type="hidden" name="actionStateId">
      <input type="hidden" name="s_count" value="0">
      <input type="hidden" name="StockOutType" value="4">
      <input type="hidden" name="secAdd_fieldName" value="">
      <input type="hidden" name="secAdd_fieldType" value="">
      <input type="hidden" name="secAdd_table" value="">
      <input type="hidden" name="secFLD_MUST_STR" value="">
      <input type="hidden" name="secFLD_NAME_STR" value="">
      <input type="hidden" name="hidDataNo" >
      <input type="hidden" name="chinaAmt" >
</div>
</form>
<input type="button" name="btnsave" id="btnsave" class="SmallButton" value="选择采购订单" onClick="javascript:getBuyPlan();">&nbsp;&nbsp;&nbsp;


</div>

</body>
</html>
<script>
document.all("pimg").style.display="none";
 document.all("abc").style.display="none";
  document.all("pinghead").style.display="none";
</script>

<?php
$_GET['action']="init_default";
systemhelpContent("采购订单入库生成管理",'100%');
?>