<script language=javascript>

var amtdot='<%=amtDotValue%>';
if  (amtdot==""||amtdot==null){
	amtdot=2;
	}
var numdot='<%=numDotValue%>';
if  (numdot==""||numdot==null){
	numdot=2;
	}
var outType='<%=session.getAttribute("P17")%>';
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
  	var dataCount=document.frm("dataCount").value;
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
    	if (document.frm("money_"+i).value!=""&&document.frm("money_"+i).value!=null){
    	cuntMon=cuntMon+parseFloat(document.frm("money_"+i).value);
        }
    }
    if (cuntMon!=0&&cuntMon!=null){
    document.frm("amt").value=cuntMon;
    }
    tmpStr = tmpStr.substring(0,tmpStr.length-standtmpStr.length);
    document.frm("dataCount").value=parseFloat(dataCount)-1;
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

    	if (document.frm("money_"+i).value!=""&&document.frm("money_"+i).value!=null){
    	cuntMon=cuntMon+parseFloat(document.frm("money_"+i).value);
        }
    }
    if (cuntMon!=0&&cuntMon!=null){
    document.frm("amt").value=cuntMon;
    }
        }
    }else{
    
    
    tmpStr = tmpStr.substring(0,tmpStr.length-standtmpStr.length);
    clientArea.innerHTML = tmpStr;
    var intDel=clientArea.innerHTML.substring(clientArea.innerHTML.lastIndexOf("money_")+6,clientArea.innerHTML.lastIndexOf("money_")+7)
        var cuntMon=0;
    for (var i=1;i<=parseInt(intDel);i++)
    {

    	if (document.frm("money_"+i).value!=""&&document.frm("money_"+i).value!=null){
    	cuntMon=cuntMon+parseFloat(document.frm("money_"+i).value);
        }
    }
    if (cuntMon!=0&&cuntMon!=null){
    document.frm("amt").value=cuntMon;
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
  var cliNo=document.frm("hidDataNo").value;
  var supplyId="";
  var stockId="";
  var typeId="0";
  if (document.getElementById("supplyid")!=null){
  supplyId=document.frm("supplyid").value;
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
  
  var fieldValue=document.frm("id_"+fieldname+"_"+countStr+"_wxd_"+cliNo).value;
  var codeValue=document.frm("id_"+fieldname+"_id"+"_"+countStr+"_wxdid_"+cliNo).value;  
  
  URL="/app/module/code/dataquery/index.jsp?moduleId="+moduleId+"&fieldname="+fieldname+"&fieldValue="+fieldValue+"&codeValue="+codeValue+"&countStr="+countStr+"&cliNo="+cliNo+"&supplyId="+supplyId+"&stockId="+stockId+"&typeId="+typeId;
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
  var cliNo=document.frm("hidDataNo").value;
  var fieldValue=document.frm("id_"+fieldname+"_"+countStr+"_wxd_"+cliNo).value;
  var codeValue=document.frm("id_"+fieldname+"_id"+"_"+countStr+"_wxdid_"+cliNo).value;
  var supplyId=document.frm("supplyid").value;
  var tableDate=document.frm("tabledate").value;
  URL="/app/module/code/orderquery/index.jsp?moduleId="+moduleId+"&fieldname="+fieldname+"&fieldValue="+fieldValue+"&codeValue="+codeValue+"&countStr="+countStr+"&cliNo="+cliNo+"&supplyId="+supplyId+"&tableDate="+tableDate;
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
  var cliNo=document.frm("hidDataNo").value;
  var supplyId=document.frm("supplyid").value;
  var fieldValue=document.frm("id_"+fieldname+"_"+countStr+"_wxd_"+cliNo).value;
  var codeValue=document.frm("id_"+fieldname+"_id"+"_"+countStr+"_wxdid_"+cliNo).value;
  URL="/app/module/code/amtquery/index.jsp?moduleId="+moduleId+"&fieldname="+fieldname+"&fieldValue="+fieldValue+"&codeValue="+codeValue+"&countStr="+countStr+"&cliNo="+cliNo+"&supplyId="+supplyId;
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
    
    var dataCount=document.frm("dataCount").value;
    //alert("33dataCount:"+dataCount);
    //alert("dataCount:"+dataCount);
    var addDataCount=parseFloat(dataCount)+1;
    temInt=addDataCount;
    dataCount=addDataCount.toString();
    //document.frm("dataCount").value=addDataCount.toString();
    //dataCount=document.frm("dataCount").value;
    //alert("33dataCount:"+dataCount);
    document.frm("dataCount").value=dataCount;
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
   frm.flag.value="secaddnew";
   frm.submit();
}
function secupdate()
{
   if(value_empty("FLD_MUST_STR","FLD_NAME_STR"))
      return (false);
   frm.flag.value="secupdate";
   frm.submit();
}
function secamtaddnew()
{
   var i=0;   
   var tableName=document.all.frm.Add_table.value
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
   value1=document.all.frm.id_stockoutid_id_1_wxdid_1.value;
   }else{
   value1=document.all.frm.id_stockinid_id_1_wxdid_1.value;
   }
   }else{
   value1=document.all(idValue).value;
   }
   if (i==1){
   value2=document.all.frm.thispaymoney_1.value;
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
   
   
   
   document.all.frm.paymoney.value=value3;
   frm.flag.value="secorderaddnew";
   if(value_empty("FLD_MUST_STR","FLD_NAME_STR"))
      return (false);
   frm.submit();
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
   value1=document.all.frm.id_stockoutid_id_1_wxdid_1.value;
   }else{
   value1=document.all.frm.id_stockinid_id_1_wxdid_1.value;
   }
   }else{
   value1=document.all(idValue).value;
   }
   //alert("value1"+value1);
   if (i==1){
   value2=document.all.frm.thispaymoney_1.value;
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
   
   
   
   document.all.frm.paymoney.value=value3;
	
	
   if(value_empty("FLD_MUST_STR","FLD_NAME_STR"))
      return (false);
      
   frm.flag.value="secorderupdate";
   frm.submit();
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
   frm.flag.value="secorderaddnew";
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
   var dataCount=document.frm("dataCount").value;
   var ModuleId=document.frm("ModuleId").value;
   //alert("dataCount:"+dataCount);
   if (dataCount!=null&&dataCount!=""){
   	int1=dataCount;
   	}
   for (i=1;i<=int1;i++){
   idValue=idValue.substring(0,24)+i;  
   idValue2=idValue2.substring(0,8)+i;
   if (i==1){
   value1=document.all.frm.id_productid_id_1_wxdid_1.value;
   }else{
   value1=document.all(idValue).value;
   }
   if (i==1){
   value2=document.all.frm.plannum_1.value;
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
   	
   var planNum=document.frm("plannum_"+i).value;
   
      if (document.getElementById("storenum_"+i)!=null){
   var storenumNum=document.frm("storenum_"+i).value;
   var storenumNumFlo=parseFloat(storenumNum);
   if (isNaN(storenumNumFlo)){
   	storenumNum="0";
   	document.frm("storenum_"+i).value="0";
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
   			document.frm("plannum_"+i).value="0";
   		}
      return false;
    }else{
    	document.frm("plannum_"+i).value=storenumNum;
    	}

   		}
  }
   
   
  if (document.getElementById("freenum_"+i)!=null){
   var freeNum=document.frm("freenum_"+i).value;
   var freeNumFlo=parseFloat(freeNum);
   if (isNaN(freeNumFlo)){
   	freeNum="0";
   	document.frm("freenum_"+i).value="0";
  }
   
   	document.frm("allnum_"+i).value=parseFloat(freeNum)+parseFloat(planNum);
  }
   
   
   
   if (document.getElementById("price_"+i)!=null){
   var planPrice=document.frm("price_"+i).value;
   if (planPrice!=null){
   	planPrice=planPrice.replace(",","");
   	}
   
   if (isNaN(planPrice)){
   	document.frm("price_"+i).value="0";
   	}
   init_value_order("plannum_"+i);   
   init_value_order("price_"+i);
   init_value_order("money_"+i);	
   
   nextMoney=parseFloat(document.frm("plannum_"+i).value)*parseFloat(document.frm("price_"+i).value);
   if (isNaN(nextMoney)){
   	nextMoney="0";
   	}
   	document.frm("money_"+i).value=nextMoney;
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
   	sendAmt=document.frm("sendAmt").value;
   	if (sendAmt==null||sendAmt==""){
   		sendAmt="0";
   		}
   		if (sendAmt.indexOf(",")>0){
  	   sendAmt=sendAmt.replace(/,/g,"");
       }	
   		addMoneyStr("sendAmt");
   	}

   	document.frm("factpayamt").value=countMoney-parseFloat(sendAmt);
   document.frm("amt").value=countMoney;
   //针对付款和实际付款的处理
   var planAmt=document.frm("amt").value;
   
   if (planAmt==null){
   	planAmt="";
   	}
   	if (document.getElementById("rebate")!=null){
      	var rebate=document.frm("rebate").value;
      	planAmt=countMoney*(parseFloat(rebate)/10);
      	}
   if (planAmt!=""){
   	
     document.frm("factpayamt").value=planAmt-parseFloat(sendAmt);
     
     //针对税金的处理
     if (document.getElementById("isfax")!=null&&document.getElementById("noFaxAmt")!=null){
      	var faxRate=document.frm("isfax").value;
      	if (faxRate==""||faxRate==null){
      		faxRate="0";
      		}
      	var noFaxAmt=countMoney/(1+parseFloat(faxRate));
      	document.frm("noFaxAmt").value=noFaxAmt;
      	addMoneyStr("noFaxAmt");
      	}     
     
     
   	}
   
   var xiaoxieAmt=frm.amt.value;
	 var daxieAmt=atoc(xiaoxieAmt);
	 frm.chinaAmt.value=daxieAmt;   
	 
	 addMoneyStr("amt");
   addMoneyStr("factpayamt");	
	}
   frm.submit();
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
      	rebate=document.frm("rebate").value;
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
   frm.flag.value="secorderupdate";
   
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
   var dataCount=document.frm("dataCount").value;
   var ModuleId=document.frm("ModuleId").value;
   //alert("dataCount:"+dataCount);
   if (dataCount!=null&&dataCount!=""){
   	int1=dataCount;
   	}
   	
   for (i=1;i<=int1;i++){
   idValue=idValue.substring(0,24)+i;  
   idValue2=idValue2.substring(0,8)+i;
   if (i==1){
   value1=document.all.frm.id_productid_id_1_wxdid_1.value;
   }else{
   value1=document.all(idValue).value;
   }
   if (i==1){
   value2=document.all.frm.plannum_1.value;
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
   	
   var planNum=document.frm("plannum_"+i).value;
 
   //alert(planNum);
   if (document.getElementById("freenum_"+i)!=null){
   var freeNum=document.frm("freenum_"+i).value;
   //var allNum=document.frm("allnum_"+i).value;
   //if (freeNum=null||freeNum="")
   //{
   //	freeNum="0";
   //	}
   	//alert(freeNum);
   	//alert(planNum);
   	document.frm("allnum_"+i).value=parseFloat(freeNum)+parseFloat(planNum);
   	
  }
  
   if (document.getElementById("price_"+i)!=null){
   var planPrice=document.frm("price_"+i).value;
   if (planPrice!=null){
   	planPrice=planPrice.replace(/,/g,"");
   	}
   if (planPrice==null||planPrice==""){
   	document.frm("price_"+i).value="0";
   }
   
   if (isNaN(planPrice)){
   	document.frm("price_"+i).value="0";
   	//alert("planPrice"+planPrice);
   	}
   //	alert("c2ountMoney"+document.frm("money_"+i).value);
   init_value_order("plannum_"+i);   
   init_value_order("price_"+i);
   init_value_order("money_"+i);	
   //alert("icountMoney"+i);
   nextMoney=parseFloat(document.frm("plannum_"+i).value)*parseFloat(document.frm("price_"+i).value);
   //alert("countMoney"+countMoney);
   //alert("c1ountMoney"+document.frm("money_"+i).value);
   if (isNaN(nextMoney)){
   	nextMoney="0";
   	}
   	document.frm("money_"+i).value=nextMoney;
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
   	sendAmt=document.frm("sendAmt").value;
   	if (sendAmt==null||sendAmt==""){
   		sendAmt="0";
   		}
   	if (sendAmt.indexOf(",")>0){
  	   sendAmt=sendAmt.replace(/,/g,"");
       }		
   	addMoneyStr("sendAmt");	
   	}
   	document.frm("amt").value=countMoney;
   	document.frm("factpayamt").value=countMoney-parseFloat(sendAmt);
   //针对付款和实际付款的处理
   var planAmt=document.frm("amt").value;
   if (planAmt==null){
   	planAmt="";
   	}
   	if (planAmt.indexOf(",")>0){
  	   planAmt=planAmt.replace(/,/g,"");
       }	
   	if (document.getElementById("rebate")!=null){
      	var rebate=document.frm("rebate").value;
      	planAmt=countMoney*(parseFloat(rebate)/10)
      	}
   if (planAmt!=""){
     document.frm("factpayamt").value=planAmt-parseFloat(sendAmt);
     
      //针对税金的处理
     if (document.getElementById("isfax")!=null&&document.getElementById("noFaxAmt")!=null){
      	var faxRate=document.frm("isfax").value;
      	if (faxRate==""||faxRate==null){
      		faxRate="0";
      		}
      	var noFaxAmt=countMoney/(1+parseFloat(faxRate));
      	document.frm("noFaxAmt").value=noFaxAmt;
      	addMoneyStr("noFaxAmt");
      	}   
     
   	}
   	
  
   
   var xiaoxieAmt=frm.amt.value;
	 var daxieAmt=atoc(xiaoxieAmt);
	 
	 frm.chinaAmt.value=daxieAmt;   
	 
	  addMoneyStr("amt");
   addMoneyStr("factpayamt");	
	}

   frm.submit();
}
function secorderquery()
{
   Qfrm.qflag.value="secorderquery";  
   Qfrm.submit();
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
   URL="/app/module/code/doStock.jsp?mainrowid="+idRowid+"&ModuleId="+ModuleId+"&doState='0'";
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
   URL="/app/module/code/outStock.jsp?mainrowid="+idRowid+"&ModuleId="+ModuleId+"&doState='1'";
   loc_x=254;
   loc_y=162;
  window.open(URL,"qq","menubar=0,toolbar=0,status=0,scrollbars=1,resizable=1,width=650px,height=250px,Top="+loc_y+"px,Left="+loc_x+"px");
}
function stockin()
{
   frm.flag.value="stockin";
   frm.submit();
}
function stockout()
{
   frm.flag.value="stockout";
   frm.submit();
}
function dataClick(dataNo){
frm.hidDataNo.value=dataNo
}
function check_value_order(field)
{
  
   if (field.indexOf("money")>=0){
   return;
   }
   
   var moduleId=document.frm("ModuleId").value;
   
   var sStr=/freenum/g;
   if (field.indexOf("freenum")>=0){
   	var thissStr=/freenum/g;
   	var thisPlanNum=document.frm(field.replace(thissStr,"plannum")).value;
   	var thisFreeNum=document.frm(field).value;   	
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
   	document.frm(field.replace(thissStr,"allnum")).value=parseFloat(thisPlanNum)+parseFloat(thisFreeNum);
   	
   		var fieldNo=field.substring(field.lastIndexOf("_")+1,field.length);
   	
   	var stockStr="num_productid_id_1_wxdnum_"+fieldNo;
    var stocknum=document.frm(stockStr).value;
    //alert(stockStr+"该商品的出库数量大与库存数量"+stocknum);
    
    var thisNum=document.frm(field.replace(sStr,"allnum")).value;  //ModuleId
    if (stocknum==null||stocknum==""){
    	stocknum=thisNum;
    	}
    	//alert(field.replace(sStr,"plannum")+"=="+stocknum+"==="+thisNum);
    if (parseFloat(stocknum)<parseFloat(thisNum)&&document.frm("ModuleId").value=="S04")
    {
    	//alert(document.frm("StockIsNeg").value);
    	if (document.frm("StockIsNeg").value=="1"){
     var subnum=parseFloat(thisNum)-parseFloat(stocknum);
     
    alert("该商品的出库数量大与库存数量"+subnum);
    document.frm(field.replace(sStr,"plannum")).value="0";
    document.frm(field.replace(sStr,"allnum")).value="0";
    document.frm(field.replace(sStr,"freenum")).value="0";
    }
    //return;
    }
    
   	}
   
   var obj=document.frm(field);
   sStr=/price/g;
   var fieldInt=field.indexOf("price");
   if (fieldInt>=0){
   var fieldNum2="";
   var fieldNum=field.substring(6,field.length);
   var dataCount=document.frm("dataCount").value;
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
   var thisPlanNum=document.frm(field.replace(sStr,"plannum")).value;
   if (thisPlanNum==null||thisPlanNum==""){
   	thisPlanNum="0";
   	}
      if (isNaN(parseFloat(thisPlanNum))){
           alert("请输入正确的数据");
          document.frm(field.replace(sStr,"plannum")).value="";
        return;
        }
   	var freenum=0;
   	var allnum=0;
   	//alert("rateStr"+rateStr);
    var rateNum=document.frm(rateStr).value;
 
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
    	if (document.frm(field.replace(sStr,"freenum")).value==null||document.frm(field.replace(sStr,"freenum")).value==""){
       document.frm(field.replace(sStr,"freenum")).value=freenumstr;
   	   document.frm(field.replace(sStr,"allnum")).value=allnumstr;
      }else{
      	
      	document.frm(field.replace(sStr,"allnum")).value=parseFloat(thisPlanNum)+parseFloat(document.frm(field.replace(sStr,"freenum")).value);
      	}
   }
   
   
   //赠品处理结束
   
   //alert("业务数据的fieldNum"+fieldNum+"dataCount"+dataCount);   
   
   var moneyField=field;
    moneyField=moneyField.replace(sStr,"money");
    if(obj.value==""||obj.value==null){
   	document.frm(moneyField).value="";
      return;
    }
    
   var perMoney=document.frm(moneyField).value;
   document.frm(moneyField).value="";
   //alert(document.frm(field.replace(sStr,"plannum")).value);   
   
   if (document.frm(field.replace(sStr,"plannum")).value==""){
   document.frm(field.replace(sStr,"plannum")).value="0";
   document.frm(moneyField).value=parseFloat(document.frm(field.replace(sStr,"plannum")).value)*parseFloat(obj.value);//parseFloat(obj.value)	
   }else{ //num_productid_id_1_wxdnum_1
   	//alert("该商品的出库数量大与库存数量");
   	//alert("1该商品的出库数量大与库存数量"+field.length);
   	//alert("2该商品的出库数量大与库存数量"+field.lastIndexOf("_"));
   	var fieldNo=field.substring(field.lastIndexOf("_")+1,field.length);
   	
   	var stockStr="num_productid_id_1_wxdnum_"+fieldNo;
    var stocknum=document.frm(stockStr).value;
    //alert(stockStr+"该商品的出库数量大与库存数量"+stocknum);
    
    if (document.getElementById(field.replace(sStr,"allnum"))!=null){
    var thisNum=document.frm(field.replace(sStr,"allnum")).value;  //ModuleId
    
    
    if (stocknum==null||stocknum==""){
    	stocknum=thisNum;
    	}
    }
    	//alert(field.replace(sStr,"plannum")+"=="+stocknum+"==="+thisNum);
    if (parseFloat(stocknum)<parseFloat(thisNum)&&document.frm("ModuleId").value=="S04")
    {
    	//alert(document.frm("StockIsNeg").value);
    	if (document.frm("StockIsNeg").value=="1"){
     var subnum=parseFloat(thisNum)-parseFloat(stocknum);
     
    alert("该商品的出库数量大与库存数量"+subnum);
    document.frm(field.replace(sStr,"plannum")).value="0";
    document.frm(field.replace(sStr,"allnum")).value="0";
    document.frm(field.replace(sStr,"freenum")).value="0";
    }
    //return;
    }
   //alert("该商品的出库数量大与库存数量2"+document.frm(field.replace(sStr,"plannum")).value);
   //alert("该商品的出库数量大与库存数量3"+obj.value);
   document.frm(moneyField).value=parseFloat(document.frm(field.replace(sStr,"plannum")).value)*parseFloat(obj.value);//parseFloat(obj.value)	
   }
   
   
   if (document.frm("amt").value==""){
   document.frm("amt").value=document.frm(moneyField).value;
   }else{
   var i=0;
   var nextMoney;
   var countMoney=0;
   for (i=1;i<=fieldNum;i++)
   {
   init_value_order("money_"+i);   	
   nextMoney=document.frm("money_"+i).value;
   if (nextMoney!=null&&nextMoney!=""){
   countMoney=countMoney+parseFloat(nextMoney);
   }
   }   
   document.frm("amt").value=countMoney
   //alert("前"+document.frm(moneyField).value);
   addMoneyStr(moneyField);
   
   //alert("后"+document.frm(moneyField).value);
   
   }
   
   //alert(document.frm(moneyField).value);
   //针对付款和实际付款的处理
   planAmt=document.frm("amt").value;
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
   	var sendAmt=document.frm("sendAmt").value;
   	if (sendAmt==null||sendAmt==""){
   		sendAmt="0";
   		}
   	var sendAmtDou=parseFloat(sendAmt);
   	document.frm("factpayamt").value=parseFloat(planAmt)-parseFloat(sendAmt);
   	planAmt=document.frm("amt").value;
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
      	var rebate=document.frm("rebate").value;
      	if (rebate==null||rebate==""){
      		rebate="0";
      		}
      	planAmt=parseFloat(planAmt)*(parseFloat(rebate)/10)-parseFloat(sendAmt);
      	}
    
   	if (planAmt!=""){
     document.frm("factpayamt").value=planAmt;
     	planAmt=document.frm("amt").value;
   	if (planAmt==null){
   	planAmt="";
    }else{
  	   if (planAmt.indexOf(",")>0){
  	   planAmt=planAmt.replace(/,/g,"");
       }
  	}
 
     //针对税金的处理
     if (document.getElementById("isfax")!=null&&document.getElementById("noFaxAmt")!=null){
      	var faxRate=document.frm("isfax").value;
      	if (faxRate==""||faxRate==null){
      		faxRate="0";
      		}
      	var noFaxAmt=parseFloat(planAmt)/(1+parseFloat(faxRate))
      	document.frm("noFaxAmt").value=noFaxAmt;
      	addMoneyStr("noFaxAmt");
      	}     
   	}
   //	alert("前"+document.frm(field.replace("price","plannum")).value);
   addMoneyStr("amt");
   addMoneyStr("factpayamt");
   addNumberStr(field.replace("price","plannum"));
  //alert("后"+document.frm(moneyField).value);
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
   var obj=document.frm(field);

   if (obj.value==""||obj.value==null)
      return;
   re=/,/g;
   obj.value=obj.value.replace(re,"");
}


function check_value_amt(field)
{
   var obj=document.frm(field);
   if(obj.value==""||obj.value==null)
      return;
   
   if (field.indexOf("allpaymoney_")>=0){
   	 return;
   	}
   	if (field.indexOf("haspaymoney_")>=0){
   	 return;
   	}
   	//alert(field);
   var oldAmt=document.frm("tempAmt").value;
   var allAmt=document.frm("paymoney").value;   
   var newAmt=obj.value;
   //alert("测试点："+fieldNum);
   //alert("就金额"+oldAmt+"新金额"+obj.value+"总金额"+allAmt);
   var fieldNo=field.substring(field.lastIndexOf("_")+1,field.length);
   //alert("测试点："+fieldNo);
   var allAmtName="allpaymoney_"+fieldNo;
   var hasAmtName="haspaymoney_"+fieldNo;
   
   var thisAllAmt=document.frm(allAmtName).value; 
   var thishasAmt=document.frm(hasAmtName).value; 
   var moduelId=document.frm(moduelId).value;
   thisAllAmt=subsymb(thisAllAmt);
   thishasAmt=subsymb(thishasAmt);
   var toPayAmt=parseFloat(thisAllAmt)-parseFloat(thishasAmt);
   var thisSubAmt=parseFloat(newAmt)-toPayAmt;
   if (thisSubAmt>0)
   {
    if(!window.confirm("本次付款金额大于应付款金额:"+thisSubAmt+",继续进行吗？"))
      {
      document.frm(field).value=addsymb(parseFloat(oldAmt));
      return false;
      }
   }
   
   allAmt=subsymb(allAmt);
   oldAmt=subsymb(oldAmt);
   
   var tempAmt=parseFloat(allAmt)-parseFloat(oldAmt)+parseFloat(newAmt);
   allAmt=addsymb(tempAmt);
   document.frm("paymoney").value=allAmt;
   document.frm(field).value=addsymb(parseFloat(newAmt));
}

function  init_value_amt(field)
{
   var obj=document.frm(field);

   if (obj.value==""||obj.value==null)
      return;
   re=/,/g;
   obj.value=obj.value.replace(re,"");
   
   document.frm("tempAmt").value=obj.value;//临时金额
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
   document.frm(moneyField).value=op_Money+value_array_Money[0];
   }else {
   document.frm(moneyField).value=op_Money+value_array_Money[0]+"."+value_array_Money[1];	
  }
  
 	}
  
 function addNumberStr(moneyField){
 	
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
    document.frm(moneyField).value=ForDight(val_Money,numdot);
    
    
  	var value_array_Money=document.frm(moneyField).value.split(".");

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
   document.frm(moneyField).value=op_Money+value_array_Money[0];
   }else {
   document.frm(moneyField).value=op_Money+value_array_Money[0]+"."+value_array_Money[1];	
  }
  
 	}
</script>

