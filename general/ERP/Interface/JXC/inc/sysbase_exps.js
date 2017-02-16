<script language=javascript>
function value_empty(fld_must,fld_name)
{
	
   fld_str_obj=document.all(fld_must);
   name_str_obj=document.all(fld_name);
  fld_str_fld_value=fld_str_obj.value;
  name_str_fld_value=name_str_obj.value;
   if(fld_str_obj.value=="")
      return false;
   
   fld_array=fld_str_fld_value.split(",");
   name_array=name_str_fld_value.split(",");
   
   for(i=0;i<=fld_array.length;i++)
   {
   	
   	  if(fld_array[i]=="")
   	     break;
   	   
   	  fld_obj=document.all(fld_array[i]);
   	  
   	  if(fld_obj.value=="")
   	  {
   	    alert("¡¼"+name_array[i]+"¡½²»ÄÜÎª¿Õ£¡");
            fld_obj.focus();
            return (true);
        }
   }
   return (false);
}

function sendForm()
{
	
   if(value_empty("FLD_MUST_STR","FLD_NAME_STR"))
      return (false);
   
   frm.flag.value="addnew";
   frm.submit();
}
</script>
