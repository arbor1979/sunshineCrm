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
   frm.P1_IN.value = frm.P1_IN_PRE.value + "-" + frm.P1_IN_RULE.value + "-" + frm.P1_IN_LEN.value;
   frm.P1_OUT.value = frm.P1_OUT_PRE.value + "-" + frm.P1_OUT_RULE.value;
   frm.P2_IN.value = frm.P2_IN_PRE.value + "-" + frm.P2_IN_RULE.value + "-" + frm.P2_IN_LEN.value;
   frm.P2_OUT.value = frm.P2_OUT_PRE.value + "-" + frm.P2_OUT_RULE.value;
   frm.L_IN.value = frm.L_IN_PRE.value + "-" + frm.L_IN_RULE.value + "-" + frm.L_IN_LEN.value;
   frm.L_OUT.value = frm.L_OUT_PRE.value + "-" + frm.L_OUT_RULE.value;
   frm.Q_IN.value = frm.Q_IN_PRE.value + "-" + frm.Q_IN_RULE.value + "-" + frm.Q_IN_LEN.value;
   frm.Q_OUT.value = frm.Q_OUT_PRE.value + "-" + frm.Q_OUT_RULE.value;
   
   frm.flag.value="addnew";
   frm.submit();
}
</script>