<script language=javascript>

function allproduct()
{
   URL="/app/storecheck/stock.jsp";
  loc_x=250;
  loc_y=200;
  window.showModalDialog(URL,self,"edge:raised;scroll:0;status:0;help:0;resizable:1;dialogWidth:350px;dialogHeight:250px;dialogTop:"+loc_y+"px;dialogLeft:"+loc_x+"px");
  //window.open(URL,"11","edge:raised;scroll:0;status:0;help:0;resizable:1;dialogWidth:400px;dialogHeight:350px;dialogTop:"+loc_y+"px;dialogLeft:"+loc_x+"px");
  //window.open(URL,"qqq","menubar=0,toolbar=0,status=0,scrollbars=1,resizable=1,width=350px,height=250px,Top="+loc_y+"px,Left="+loc_x+"px");
}
function selectproduct()
{
  URL="/app/storecheck/stock/index.jsp";
  loc_x=250;
  loc_y=200;
  //window.open(URL,"qqq","menubar=0,toolbar=0,status=0,scrollbars=1,resizable=1,width=350px,height=250px,Top="+loc_y+"px,Left="+loc_x+"px");
  window.showModalDialog(URL,self,"edge:raised;scroll:0;status:0;help:0;resizable:1;dialogWidth:350px;dialogHeight:450px;dialogTop:"+loc_y+"px;dialogLeft:"+loc_x+"px");
 }
function deletecheck()
{
  URL="/app/storecheck/stockdelete.jsp";
  loc_x=250;
  loc_y=200;
  //window.showModalDialog(URL,self,"edge:raised;scroll:0;status:0;help:0;resizable:1;dialogWidth:350px;dialogHeight:250px;dialogTop:"+loc_y+"px;dialogLeft:"+loc_x+"px");
  window.open(URL,"qqq","menubar=0,toolbar=0,status=0,scrollbars=1,resizable=1,width=350px,height=250px,Top="+loc_y+"px,Left="+loc_x+"px");
}
function expscheck()
{
  URL="/app/storecheck/stockexps.jsp";
  loc_x=250;
  loc_y=200;
  //window.showModalDialog(URL,self,"edge:raised;scroll:0;status:0;help:0;resizable:1;dialogWidth:350px;dialogHeight:250px;dialogTop:"+loc_y+"px;dialogLeft:"+loc_x+"px");
  window.open(URL,"qqq","menubar=0,toolbar=0,status=0,scrollbars=1,resizable=1,width=350px,height=250px,Top="+loc_y+"px,Left="+loc_x+"px");
}

function creatcheck()
{
   if(!window.confirm("确定保存盘点报告？"))
      return false;
      
   window.parent.frames("data").document.all("flag").value="stockcheck";
   window.parent.frames("data").document.all("checkdate").value= document.Qfrm("checkdate").value;
   alert(window.parent.frames("data").document.all("checkdate").value);
   window.parent.frames("data").frm.submit();
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
         if(idStr!=""&&document.all("TR"+idStr)!=null)
         {
            document.all("TR"+idStr.replace(",","")).style.background=theDefaultColor;
            document.all("TR"+idStr.replace(",","")).style.color="#000000";
         }
         idStr=theId;
         theRow.style.background=theMarkColor;
         theRow.style.color="#FFFFFF";
      }      
      document.all("ID_STR").value=idStr;
   }
}
function find_id(theId,idStr)
{
   if(theId=="" || idStr=="")
      return false;
   if(idStr.search(theId)==-1)
      return false;
   return true;
}
var isNS4 = (navigator.appName=="Netscape")?1:0;

function check_input(StrField)
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
function initValue(StrField)
{
  var postX=StrField.substring(StrField.lastIndexOf("_")+1,StrField.length);
  var postY=StrField.substring(4,StrField.lastIndexOf("_"));
  var keyName="Str_"+postY+"_"+postX;
  var before_price=document.all("Str_"+postY+"_5").value;
  var before_num=document.all("Str_"+postY+"_6").value;
  var after_price=document.all("Str_"+postY+"_8").value;
  var after_num=document.all("Str_"+postY+"_9").value;
  if (before_price==null||before_price==""){
  return;
  }
  if (before_num==null||before_num==""){
  return;
  }
  if (after_price==null||after_price==""){
  return;
  }
  if (after_num==null||after_num==""){
  return;
  }
  var before_amt=parseFloat(before_price)*parseFloat(before_num);
  var after_amt=parseFloat(after_price)*parseFloat(after_num);
  document.all("Str_"+postY+"_7").value=before_amt;
  document.all("Str_"+postY+"_10").value=after_amt;
  document.all("Str_"+postY+"_11").value=parseFloat(after_num)-parseFloat(before_num);
  document.all("Str_"+postY+"_12").value=parseFloat(after_amt)-parseFloat(before_amt);
}
function checkKey(StrField)
{
  
  var postX=StrField.substring(StrField.lastIndexOf("_")+1,StrField.length);
  var postY=StrField.substring(4,StrField.lastIndexOf("_"));
  var keyName="Str_"+postY+"_"+postX;
  var obj=document.all(keyName);
   if(event.keyCode == 13){
    postY=parseInt(postY)+1;
   keyName="Str_"+postY+"_"+postX;
   obj=document.all(keyName);	
   obj.focus();    
   }else if (event.keyCode == 40){//向下
   postY=parseInt(postY)+1;
   keyName="Str_"+postY+"_"+postX;
   obj=document.all(keyName);	
   obj.focus();
   }else if (event.keyCode == 39){//向右
   if (parseInt(postX)<12){
     postX=parseInt(postX)+1;
   }
   keyName="Str_"+postY+"_"+postX;
   obj=document.all(keyName);	
   obj.focus();
   }else if (event.keyCode == 38){//向上
    if (parseInt(postY)>1){
      postY=parseInt(postY)-1;
    }
   keyName="Str_"+postY+"_"+postX;
   obj=document.all(keyName);	
   obj.focus();  

   }else if (event.keyCode == 37){//向左
   if (parseInt(postX)>1){
      postX=parseInt(postX)-1;
    }
   keyName="Str_"+postY+"_"+postX;
   obj=document.all(keyName);	
   obj.focus();
   }
}
function compValue(StrField)
{
   initValue(StrField);   
}

</script>

