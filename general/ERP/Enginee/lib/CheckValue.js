var isNS4 = (navigator.appName=="Netscape")?1:0;

function check_input_num(num_type)
{
	
  if(num_type=="NUMBER")
  {
	  
     if(!isNS4)
     {
     	 if((event.keyCode < 48 || event.keyCode > 57)&&event.keyCode != 46 &&event.keyCode != 45)
     	    event.returnValue = false;
     }
     else
     {
     	 if((event.which < 48 || event.which > 57)&&event.keyCode != 46 &&event.keyCode != 45)
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

   obj.value=ForDight(val,2);

   var value_array=obj.value.split(".");

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

   obj.value=op+value_array[0]+"."+value_array[1];
}

function  init_value(field)
{
   var obj=document.all(field);   
   if (obj.value=="")
      return;

   re=/,/g;
   obj.value=obj.value.replace(re,"");
}