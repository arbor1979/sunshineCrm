<script language=javascript>
function expsadd(openurl)
{

   loc_x=200;
   loc_y=100;

//parent_window.window.showModalDialog(openurl,self,"edge:raised;scroll:1;status:0;help:0;resizable:1;dialogWidth:400px;dialogHeight:300px;dialogTop:"+loc_y+"px;dialogLeft:"+loc_x+"px");
window.open(openurl,"qqq","menubar=0,toolbar=0,status=0,scrollbars=1,resizable=1,width=700px,height=550px,Top="+loc_y+"px,Left="+loc_x+"px");
}
function updateexps()
{
   //alert("1111");
   frm.flag.value="updateexps";
   frm.submit();
}
function check_exps(obj)
{

  if(obj.value=="")
    return;

  val=parseFloat(obj.value);
  if(isNaN(val))
  {
    alert("非法的数字");
    obj.focus();
    return;
  }
  if(val<0)
  {
    alert("数值不能小于0");
    obj.focus();
    return;
  }

  obj.value=ForDight(val,2);

  value_array=obj.value.split(".");
  if(value_array.length==1)
  {
    obj.value=value_array[0]+".00";
    return;
  }
  else if(value_array.length==2)
  {
    if(value_array[1].length==0)
      obj.value=value_array[0]+".00";
    else if(value_array[1].length==1)
      obj.value=value_array[0]+"."+value_array[1]+"0";
    else if(value_array[1].length>=2)
      obj.value=value_array[0]+"."+value_array[1].substr(0,2);
  }
}
function press_key(keyname)
{
  if (event.keyCode==13)
    {
    keyname.focus();
    }
}


function doKeyUp(objID) {
  var strs = objID.split("_");
  if (strs.length != 3) {
  }
  var rowCnt = parseInt(strs[1]);
  var colCnt = parseInt(strs[2]);
  var code = event.keyCode;
  var totalCnt = document.all("detail_count").value;
  var obj = null;
  
  if (colCnt == 2) {
    if (code == 9) {//Tab
      //alert("2" + code);
      //document.all("exps_" + rowCnt + "_" + (colCnt + 1)).focus();
    }else if (code == 37) {//left
    }else if (code == 38) {//up
      if (rowCnt > 1) {        
        obj = document.all("exps_" + (rowCnt - 1) + "_" + colCnt);        
      }
    }else if (code == 39) {//right
      obj = document.all("exps_" + rowCnt + "_" + (colCnt + 1));      
    }else if (code == 40) {//down
      if (rowCnt < totalCnt) {
        obj = document.all("exps_" + (rowCnt + 1) + "_" + colCnt);        
      }
    }else if (code == 13) {
      obj = document.all("exps_" + rowCnt + "_" + (colCnt + 1));      
    }
  }else if (colCnt == 3) {
    if (code == 9) {//Tab
      //alert("3" + code);
      //if (rowCnt < totalCnt - 1) {
        //document.all("exps_" + (rowCnt + 1) + "_" + (colCnt - 1)).focus();
      //}
    }else if (code == 37) {//left
      obj = document.all("exps_" + rowCnt + "_" + (colCnt - 1));      
    }else if (code == 38) {//up
      if (rowCnt > 1) {
        obj = document.all("exps_" + (rowCnt - 1) + "_" + colCnt);        
      }
    }else if (code == 39) {//right
    }else if (code == 40) {//down
      if (rowCnt < totalCnt) {
        obj = document.all("exps_" + (rowCnt + 1) + "_" + colCnt);        
      }
    }else if (code == 13) {
      if (rowCnt < totalCnt) {
        obj = document.all("exps_" + (rowCnt + 1) + "_" + (colCnt - 1));        
      }else {
        obj = document.all("btnsave");
      }
    }
  }else if (colCnt == 0) {
    //alert();
    obj = document.all("exps_" + rowCnt + "_" + 2);
  }
  if (obj != null) {
    obj.focus();
    if (rowCnt >= totalCnt && colCnt == 3) {      
    }else {
      obj.select();
    }
  }
}

function check_mon(num,price,money,countmenoy,flag)
{

  //单价
  if(price.value=="")
  val_3=1;
  else
  val_3=parseFloat(price.value);

  //数量
  if(num.value=="")
  val_4=1;
  else
  val_4=parseFloat(num.value);

  if(flag=="1")//允许单价和数量相乘
  val_mon=val_3*val_4;
  else if (flag=="2")//单价和数量没有关系
  val_mon=1;


  if (val_mon!=1)
  {
  money.value=val_mon;
  if (countmenoy.value=="")
  countmenoy.value=0;
  countmenoy.value=parseFloat(countmenoy.value)+val_mon;
  }
else
{
if (countmenoy.value=="")
countmenoy.value=0;
if (money.value=="")
money.value=0;
countmenoy.value=parseFloat(countmenoy.value)+parseFloat(money.value);
}
  check_value_bgdt(money);
  check_value_bgdt(countmenoy);

  if(money.value=="")
    return;

  val=parseFloat(money.value);
  if(isNaN(val))
  {
    alert("非法的数字");
    money.focus();
    return;
  }
  if(val<0)
  {
    alert("数值不能小于0");
    money.focus();
    return;
  }

  value_array=money.value.split(".");
  if(value_array.length==1)
  {
    money.value=value_array[0]+".00";
    return;
  }
  else if(value_array.length==2)
  {
    if(value_array[1].length==0)
      money.value=value_array[0]+".00";
    else if(value_array[1].length==1)
      money.value=value_array[0]+"."+value_array[1]+"0";
    else if(value_array[1].length>=2)
      money.value=value_array[0]+"."+value_array[1].substr(0,2);
  }

}

function check_value_exps(money)
{

   if(money.value=="")
      return;

   if(money.value.substring(0,1)=="-")
   {
   	   op="-";
   	   money.value=money.value.substring(1,money.value.length);
   }
   else
       op="";

   val=parseFloat(money.value);
   if(isNaN(val))
   {
      alert("非法的数字");
      money.focus();
      return;
   }

   money.value=ForDight(val,2);

   var value_array=money.value.split(".");

   //格式化整数位
   start=0;
   len=0;
   val_int="";

//   for(i=0;i<=parseInt(value_array[0].length/3);i++)
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
   else if(value_array.length==2)
   {
   	  if(value_array[1].length==0)
   	    value_array[1]="00";
   	  else if(value_array[1].length==1)
   	    value_array[1]=value_array[1]+"0";
   	  else if(value_array[1].length>=2)
   	    value_array[1]=value_array[1].substr(0,2);
   }

   money.value=op+value_array[0]+"."+value_array[1];

}

function expsquery(moduleid)
{
   URL="/app/template/code/query/index.jsp?ModuleId="+moduleid;
   loc_x=document.body.scrollLeft+event.clientX-event.offsetX+300;
   loc_y=document.body.scrollTop+event.clientY-event.offsetY+100;
  //window.showModalDialog(openurl,self,"edge:raised;scroll:1;status:0;help:0;resizable:1;dialogWidth:400px;dialogHeight:300px;dialogTop:"+loc_y+"px;dialogLeft:"+loc_x+"px");
  window.open(URL,"","menubar=0,toolbar=0,status=0,scrollbars=1,resizable=1,width=650px,height=450px,Top="+loc_y+"px,Left="+loc_x+"px");
}
function expsdetail()
{
   var idStr=parent.detail.document.all("ID_STR").value;
   var idRowid=idStr.substring(0,18)+",";
   if(idStr=="")
   {
      alert("请选中一项查询！");
      return false;
   }
   idRowid=converUrlStr(idRowid);
   URL="/app/secmodule/code/expsdetail.jsp?rowid="+idRowid;
  
   loc_x=document.body.scrollLeft+event.clientX-event.offsetX-300;
   loc_y=document.body.scrollTop+event.clientY-event.offsetY+100;

  //window.showModalDialog(URL,self,"edge:raised;scroll:1;status:0;help:0;resizable:1;dialogWidth:650px;dialogHeight:450px;dialogTop:"+loc_y+"px;dialogLeft:"+loc_x+"px");
  window.open(URL,"","menubar=0,toolbar=0,status=0,scrollbars=1,resizable=1,width=650px,height=250px,Top="+loc_y+"px,Left="+loc_x+"px");
}
function expsdetailclick(idRowid)
{   
   idRowid=converUrlStr(idRowid);	
   URL="/app/secmodule/code/expsdetail.jsp?rowid="+idRowid;
   loc_x=254;
   loc_y=162;
  //window.showModalDialog(URL,self,"edge:raised;scroll:1;status:0;help:0;resizable:1;dialogWidth:650px;dialogHeight:450px;dialogTop:"+loc_y+"px;dialogLeft:"+loc_x+"px");
  
  window.open(URL,"qq","menubar=0,toolbar=0,status=0,scrollbars=1,resizable=1,width=650px,height=250px,Top="+loc_y+"px,Left="+loc_x+"px");
}
function mainquery()
{
	
	
   form1.flag.value="query";
   //alert("333333333");
   form1.submit();
}
function maindelete()
{
   msg='确认要删除';
   if (window.confirm(msg))
   {
   form1.flag.value="delete";
   form1.submit();
   }
}
function expsdel()
{
   var idStr=parent.detail.document.all("ID_STR").value;
   if (idStr.length>0){   	
   	idStr=idStr.substring(0,idStr.length-1);
   	}
   //var idRowid=idStr.substring(0,18)+",";
   if(idStr=="")
   {
      alert("请至少选中一项删除！");
      return false;
   }
   
   msg='确认要删除';
   if (window.confirm(msg))
   {   	
   Qfrm.qflag.value="delete";
   Qfrm.deletevalue.value=idStr;
   Qfrm.submit();
   }
}
function expsdelVou()
{
   var idStr=parent.detail.document.all("ID_STR").value;
   var idRowid=idStr.substring(0,18)+",";
   if(idStr=="")
   {
      alert("请至少选中一项取消凭证！");
      return false;
   }
   
   msg='确认要取消凭证';
   if (window.confirm(msg))
   {
   Qfrm.qflag.value="deleteVoucher";
   Qfrm.deletevalue.value=idRowid;
   Qfrm.submit();
   }
}
function expsedit(openurl)
{
   var idStr=parent.detail.document.all("ID_STR").value;
   if (idStr=="")
   {
   alert("请选择一项进行编辑！");
   return;
   }
   openurl=openurl+"?rowid="+idStr;
   loc_x=200;
   loc_y=100;
//window.showModalDialog(openurl,self,"edge:raised;scroll:1;status:0;help:0;resizable:1;dialogWidth:400px;dialogHeight:300px;dialogTop:"+loc_y+"px;dialogLeft:"+loc_x+"px");
window.open(openurl,"qqq","menubar=0,toolbar=0,status=0,scrollbars=1,resizable=1,width=700px,height=550px,Top="+loc_y+"px,Left="+loc_x+"px");

}
function check_lend()
{
   var dept_value=document.all("DATA_SORT2_ID").value;
   var empl_value=document.all("DATA_SORT3_ID").value;
   var exps_no=document.all("EXPS_NO").value;
   var main_count=document.all("main_count").value;
   URL="/app/secmodule/code/checklend.jsp?dept_value="+dept_value+"&empl_value="+empl_value+"&exps_no="+exps_no+"&main_count="+main_count;
   loc_x=254;
   loc_y=102;
  //window.showModalDialog(URL,self,"edge:raised;scroll:1;status:0;help:0;resizable:1;dialogWidth:650px;dialogHeight:450px;dialogTop:"+loc_y+"px;dialogLeft:"+loc_x+"px");
  window.open(URL,"qq","menubar=0,toolbar=0,status=0,scrollbars=1,resizable=1,width=750px,height=250px,Top="+loc_y+"px,Left="+loc_x+"px");
}
function mainvoucher(openrul)
{

   var idStr=parent.detail.document.all("rowId_STR").value;
   var ModuleId=document.all("ModuleId").value;
   loc_x=150;
   loc_y=100;
   if (idStr=="")
   {
   
   URL="/app/module/code/date.jsp?toUrl="+openrul+"&ModuleId="+ModuleId;
   //alert("请选择要生成凭证的业务数据2222222222！"+URL);
   window.open(URL,"","menubar=1,toolbar=1,status=1,scrollbars=1,resizable=1,width=420px,height=200px,Top="+loc_y+"px,Left="+loc_x+"px");
   //return;
  }else{
   //alert(idStr);
   //idStr=idStr.replace("+","%2B");
   idStr=converUrlStr(idStr);
   //alert(idStr);
   URL=openrul+"?rowid="+idStr;
  //alert(URL);
  window.open(URL,"","menubar=0,toolbar=0,status=0,scrollbars=1,resizable=1,width=900px,height=550px,Top="+loc_y+"px,Left="+loc_x+"px");
  }
}
function exps_Select(rowId)
{
  var idStr=document.all("rowId_STR").value;
  //var sessionIdStr=Qfrm.document.all("sessionRowId").value;
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
  document.all("rowId_STR").value=idStr;
  //Qfrm.document.all("sessionRowId").value=idStr;
  
}
function find_id(theId,idStr)
{
   if(idStr.search(theId)==-1)
      return false;
   return true;
}
var theDefaultColor="#FFFFFF";
var thePointerColor="#D9E8FF";
var theMarkColor="#003FBF";

function setPointer(theRow, theId, theAction)
{
   var idStr=document.all("ID_STR").value;

   if(theAction=="over" && !find_id(theId,idStr))
      theRow.style.background=thePointerColor;
   else if(theAction=="out" && !find_id(theId,idStr))
      theRow.style.background=theDefaultColor;
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
      document.all("ID_STR").value=idStr;
      //parent.window.opener.document.all("ID_STR_QUERY").value=idStr;
      //parent.window.opener.document.all("qflag").value="query";
      //parent.window.opener.location.reload(true);

   }

}
function setPointerExps(theRow, theId, theAction)
{
   var idStr=document.all("ID_STR").value;
   theId+="|";
   if(theAction=="over" && !find_id(theId,idStr))
      theRow.style.background=thePointerColor;
   else if(theAction=="out" && !find_id(theId,idStr))
      theRow.style.background=theDefaultColor;
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
         if(idStr!=""&&document.all("TR"+idStr.replace("|",""))!=null)
         {
            document.all("TR"+idStr.replace("|","")).style.background=theDefaultColor;
            document.all("TR"+idStr.replace("|","")).style.color="#000000";
         }
         idStr=theId;         
         theRow.style.background=theMarkColor;
         theRow.style.color="#FFFFFF";
      }  
      //alert(idStr);    
      document.all("ID_STR").value=idStr;
   }
}
function check_exps_1(objID)
{

  val=parseFloat(document.all(objID).value);
  if(isNaN(val))
  {
    return;
  }
  if(val<0)
  {
    return;
  }

  document.all(objID).value=ForDight(val,2);

  value_array=document.all(objID).value.split(".");
  if(value_array.length==1)
  {
    document.all(objID).value=value_array[0]+".00";
    return;
  }
  else if(value_array.length==2)
  {
    if(value_array[1].length==0)
      document.all(objID).value=value_array[0]+".00";
    else if(value_array[1].length==1)
      document.all(objID).value=value_array[0]+"."+value_array[1]+"0";
    else if(value_array[1].length>=2)
      document.all(objID).value=value_array[0]+"."+value_array[1].substr(0,2);
  }
}

function existCntrl(cntrlID) {
  var i = 0;
  for (i = 0; i < document.all.length; i++) {
    if (document.all(i).id == cntrlID) {
      return true;
    }
  }
  return false;
}
function reComputeExps() {
  var i = 0;
  var rowCnt = document.all("detailRowCnt").value;
  var totalValue = 0;
  for (i  = 1; i <= rowCnt; i++) {
    var objID1 = "exps_" + i + "_" + 1;
    var objID2 = "exps_" + i + "_" + 2;
    var objID3 = "exps_" + i + "_" + 3;

    var tdValue1 = document.all(objID1).value;
    var tdValue2 = document.all(objID2).value;
    var tdValue3 = document.all(objID3).value;

    //document.all("debugout").value=document.all("debugout").value + tdValue1 + "--" + tdValue2 + "--" + tdValue3 + "\n";

    if (tdValue1 != "") {
      check_exps_1(objID1);
    }
    if (tdValue2 != "") {
      check_exps_1(objID2);
    }
    if (tdValue3 != "") {
      check_exps_1(objID3);
    }

    tdValue1 = document.all(objID1).value;
    tdValue2 = document.all(objID2).value;
    //document.all("debugout").value=document.all("debugout").value + tdValue1 + "--" + tdValue2 + "--" + tdValue3 + "\n";

    //if (tdValue2 == "") {
      //document.all("debugout").value=document.all("debugout").value + "1.00\n\n";
      //tdValue2 = 1.00;
    //}
    //document.all("debugout").value=document.all("debugout").value + tdValue1 + "--" + tdValue2 + "\n\n";
    if (tdValue1 != "" && tdValue2 != "") {
      document.all(objID3).value = parseFloat(tdValue1) * parseFloat(tdValue2);
      document.all(objID3).readOnly = true;
      check_exps_1(objID3);
      totalValue = totalValue + parseFloat(tdValue1) * parseFloat(tdValue2);
    }else if (tdValue1 != "" && tdValue2 == "" && tdValue3 == "") {
      document.all(objID3).value = parseFloat(tdValue1);
      document.all(objID3).readOnly = false;
      check_exps_1(objID3);
      totalValue = totalValue + parseFloat(tdValue1);
    }else if (tdValue1 != "" && tdValue2 == "" && tdValue3 != "") {
      document.all(objID3).readOnly = false;
      check_exps_1(objID3);
      totalValue = totalValue + parseFloat(tdValue3);
    }else if (tdValue3 != "") {
      document.all(objID3).readOnly = false;
      check_exps_1(objID3);
      totalValue = totalValue + parseFloat(tdValue3);
    }else {
      document.all(objID3).readOnly = false;
      check_exps_1(objID3);
      //totalValue = totalValue + parseFloat(tdValue3);
    }
  }
  document.all("DATA_SORT8_ID").value=totalValue;
  check_exps_1("DATA_SORT8_ID");
}

function computeExps(obj) {
  document.all("curSelectCntrl").value = obj.id;
  var tdValue = obj.value;
  var cnt = obj.id.substr(7, 1);
  //alert(cnt);
  var numValue = parseFloat(tdValue);
  if (cnt == "3") {
    if (isNaN(numValue)) {
      obj.value = document.all("tdArignValue").value;
      alert("非法数字");
      return;
    }
  }else if (cnt == "2") {
    if (tdValue != "" && isNaN(numValue)) {
      obj.value = document.all("tdArignValue").value;
      alert("非法数字");
      return;
    }
  }

  reComputeExps();
  //checkExpsFact();
}
function refreshEmployee(obj) {
  //document.all("frmRefreshEmployee").departmentID.value = document.all("DATA_SORT2_ID").value;
  //document.all("frmRefreshEmployee").submit();
  var selectObj = document.all("DATA_SORT3_ID");
  var departId = obj.value;
  alert("departId:"+departId);
  //alert("empSelectData:"+empSelectData.[1]);
  var empArray = getEmpList(departId, empSelectData);
  //alert("empArray:"+empArray);
  //reLoadSelect(selectObj, empArray, "");
}

function reLoadSelect(selectObj, dataArray, selectedValue) {  
  clearSelect(selectObj);
  //selectObj.onchange=onchangeStr;
  alert(selectObj.name);
  alert(dataArray.length);
  for (var i = 0; i < dataArray.length; i++) {
    var row = dataArray[i];
    var myOption = document.createElement("OPTION");
    alert("row[0]:"+row[0]);
    alert("row[1]:"+row[1]);
    myOption.value = row[0];
    myOption.text = row[1];      
    selectObj.add(myOption, selectObj.options.length);
    alert("myOption:"+myOption.value);
    if (selectedValue == myOption.value) {        
      myOption.selected = true;
    }
  }
}

function clearSelect(selectObj) {
  for (i = selectObj.options.length - 1; i >= 0; i--) {
    selectObj.remove(i);
  }
  //selectObj.onchange="";
}

function getEmpList(departId, empArray) {
  alert("测试"+departId);
  var rtEmpList = new Array(new Array("", ""));
  if (departId == "") {
    return rtEmpList;
  }
  alert("empArray.length:"+empArray.length);
  for (var i = 0; i < empArray.length; i++) {
    var row = empArray[i];
     alert(row);
     alert(departId);
    if (row[2] == departId) {
      rtEmpList[rtEmpList.length] = row;
    }
  }
  return rtEmpList;
}

function checkExpsFactSelect(obj) {
  document.all("curSelectCntrl").value = obj.name;
  //checkExpsFact();
}

function checkExpsFact() {  
  //updateexps
  var userId=frm.DATA_SORT3_ID.value;
  if (userId==null||userId==""){
  	alert("请选择人员");
  	return;
  	}
  frm.flag.value="updateexps";
  document.all("frm").submit();
  //parent.expsfactCheck.rows="50,50";
}

function setCheckExpsFactState(passFlag) {
  if (passFlag == "pass") {
    document.all("btnsave").disabled = false;
  }else {
    document.all("btnsave").disabled = true;
    var curCntrl = document.all("curSelectCntrl").value;
    document.all(curCntrl).focus();
    document.all(curCntrl).select();
  }
}

function copyOrignValue(obj) {
  document.all("tdArignValue").value = obj.value;
}

function expscheck()
{
//alert("33333333333333");
 var idStr=document.all("ID_STR").value;
   //alert(idStr);
   var tableStr=document.all("A_Table").value;
   if(idStr=="")
   {
      alert("请选中一项进行核销！");
      return false;
   }
   if(idStr.indexOf(",") < idStr.length-1)
   {
      alert("只能选中一项进行核销！");
      return false;
   }

   URL="/app/template/code/bgdtcheck/index.jsp?rowid="+idStr+"&A_Table="+tableStr;
   //alert(URL);
   loc_x=150;
   loc_y=100;
 /*
window.open(URL,"","menubar=0,toolbar=0,status=0,scrollbars=1,resizable=1,width=900px,height=470px,Top="+loc_y+"px,Left="+loc_x+"px");
*/
}

</script>