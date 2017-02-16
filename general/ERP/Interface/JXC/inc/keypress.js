<script language="javascript">
var isNS4 = (navigator.appName=="Netscape")?1:0;

function check_input(keyname)
{
  if(!isNS4)
  {
    if(event.keyCode < 45 || event.keyCode > 57)
    {
      event.returnValue = false;
      alert("请输入有效数值");
    }
  }
  else
  {
    if(event.which < 45 || event.which > 57)
      return false;
  }  
  if (event.keyCode==13)
    keyname.focus();
}

function press_key(keyname)
{
  if (event.keyCode==13)
    keyname.focus();
}

function two_count(first,second,third,nextobj)
{
  if(event.keyCode == 13||event.type=="blur")
  {
    if(check_num(first,first)&&check_num(second,second))
    {
      third.value=first.value*second.value;
      third.value=ForDight(third.value,2);
    
      value_array=third.value.split(".");
      if(value_array.length==1)
      {
        third.value=value_array[0]+".00";
      }
      else if(value_array.length==2)
      {
        if(value_array[1].length==0)
          third.value=value_array[0]+".00";
        else if(value_array[1].length==1)
          third.value=value_array[0]+"."+value_array[1]+"0";
        else if(value_array[1].length>=2)
          third.value=value_array[0]+"."+value_array[1].substr(0,2);
      }
      nextobj.focus();
    }
  }
}

function  ForDight(Dight,How)  
{
  Dight = Math.round (Dight*Math.pow(10,How))/Math.pow(10,How);
  return Dight;
} 

function check_num(obj,nextobj)
{
  if(event.keyCode == 13||event.type=="blur")
  {
    if (isNaN(obj.value))
    {
      window.alert("必须是数值型数据。");
      obj.value = "";
      obj.focus();
    }
    else
    {
      if(obj.value<0)
      {
        alert("数值不能小于0");
        obj.focus();
        return false;
      }
      
      obj.value=ForDight(obj.value,2);
    
      value_array=obj.value.split(".");
      if(value_array.length==1)
      {
        obj.value=value_array[0]+".00";
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
      if (nextobj!=obj)
        nextobj.focus();
      return true;
    }
  }
}

function check_value(obj)
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

function check_input1()
{
  if(!isNS4)
  {
    if(event.keyCode < 45 || event.keyCode > 57)
      event.returnValue = false;
  }
  else
  {
    if(event.which < 45 || event.which > 57)
      return false;
  }  
}

function check_value1(obj)
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

</script>