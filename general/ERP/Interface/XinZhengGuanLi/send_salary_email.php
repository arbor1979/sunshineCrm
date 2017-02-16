<?php
ini_set('display_errors', 1);
	ini_set('error_reporting', E_ALL);
	error_reporting(E_WARNING | E_ERROR);

	require_once('lib.inc.php');
	
	$GLOBAL_SESSION=returnsession();
$SYSTEM_PRIV_STOP = 1;
?>
<html>
	<head>
	<title>EMAIL工资条</title>
	<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
	<script src="/inc/js/module.js"></script>
	<script>
	function func_insert(){
		for (i=0; i<form1.select2.options.length; i++){  if(form1.select2.options[i].selected)  {
			var my_option = document.createElement("OPTION");     my_option.text=form1.select2.options[i].text;     my_option.value=form1.select2.options[i].value;     my_option.style.color=form1.select2.options[i].style.color;    form1.select1.options.add(my_option, form1.select1.options.length);  } }


			 for (i=form1.select2.options.length-1; i>=0; i--) {   if(form1.select2.options[i].selected)     
				 form1.select2.remove(i); 
			 }
			}
			function func_delete(){ 
				for (i=0; i<form1.select1.options.length; i++) {   if(form1.select1.options[i].selected)   {    
					var my_option = document.createElement("OPTION");     my_option.text=form1.select1.options[i].text;     my_option.value=form1.select1.options[i].value;     form1.select2.options.add(my_option, form1.select2.options.length);  } }//for  
					for (i=form1.select1.options.length-1; i>=0; i--) {   if(form1.select1.options[i].selected)     form1.select1.remove(i); }//for
					}
			function func_select_all1(){ 
				for (i=form1.select1.options.length-1; i>=0; i--)   form1.select1.options[i].selected=true;
				}
			function func_select_all2(){ 
				for (i=form1.select2.options.length-1; i>=0; i--)   form1.select2.options[i].selected=true;
				}
			function exreport(){   
				var fld_str="";   
				for (i=0; i< form1.select1.options.length; i++)   {      options_value=form1.select1.options[i].value;      fld_str+=options_value+",";   
				}   
				document.form1.fld_str.value=fld_str;   document.form1.submit();
				}
			function func_up(){  
				sel_count=0;  
				for (i=form1.select1.options.length-1; i>=0; i--)  { 
					if(form1.select1.options[i].selected)       
						sel_count++;  
					}  
					if(sel_count==0)  {    
						alert("调整顺序时，请选择其中一项！");     return; 
						}  
						else if(sel_count>1)  {     
							alert("调整顺序时，只能选择其中一项！");     return; 
							} 
							i=form1.select1.selectedIndex;  if(i!=0)  {    
								var my_option = document.createElement("OPTION");    my_option.text=form1.select1.options[i].text;    my_option.value=form1.select1.options[i].value;    form1.select1.options.add(my_option,i-1);    form1.select1.remove(i+1);    form1.select1.options[i-1].selected=true;  
								}}
			function func_down(){  
				sel_count=0;  
				for (i=form1.select1.options.length-1; i>=0; i--)  {
					if(form1.select1.options[i].selected)      
						sel_count++;  
					}  
					if(sel_count==0)  {     
						alert("调整桌面模块的顺序时，请选择其中一项！");    
						return;  }  
						else if(sel_count>1)  {     
							alert("调整桌面模块的顺序时，只能选择其中一项！");     return; 
							}  
							i=form1.select1.selectedIndex;  if(i!=form1.select1.options.length-1)  {    
								var my_option = document.createElement("OPTION");    my_option.text=form1.select1.options[i].text;    my_option.value=form1.select1.options[i].value;    form1.select1.options.add(my_option,i+2);    form1.select1.remove(i);    form1.select1.options[i+1].selected=true;  }}
								
								</script>
			</head>
			
			<body class="bodycolor" topmargin="5" >
				
				
				<form name="form1" method="post" action="send_salary_email_result.php">
				<table border="0" width="100%" cellspacing="0" cellpadding="3" class="small"> 
				<tr>  
				  <td class="Big"><img src="/images/menu/email.gif" WIDTH="22" HEIGHT="20" align="absmiddle">
				<span class="big3">&nbsp;&nbsp;EMAIL工资条 </span>  
				  </td>  
				</tr>
				</table>
				
				<br>

				<div align="center">
				<table class="TableBlock" align="center" > 
				<tr>
				  <td nowrap class="TableContent">&nbsp;&nbsp;人员： 
				  </td>    
				  <td nowrap class="TableData">       
				<input type="hidden" name="COPY_TO_ID" value="">      
				<textarea cols=40 name="COPY_TO_NAME" rows=3 class="BigStatic" wrap="yes" readonly></textarea>        
				<a href="javascript:;" class="orgAdd" onClick="SelectUser('','COPY_TO_ID', 'COPY_TO_NAME')">选择</a>        <a href="javascript:;" class="orgClear" onClick="ClearUser('COPY_TO_ID', 'COPY_TO_NAME')">清空</a><br />&nbsp;<img src="/images/attention.gif" height="16" title="提示">人员为空时发送全部人员的工资条     
				  </td>  
				</tr> 
				<tr> 
				  <td nowrap class="TableContent">&nbsp;&nbsp;选项： </td>   
				  <td nowrap class="TableData">       
				<input type="checkbox" name="ZERO" id="ZERO">
				<label for="ZERO">不显示数额为零的项目</label>            
				  </td>  
				</tr>  
				<tr>  
				  <td nowrap class="TableContent">&nbsp;&nbsp;输出内容：
				  </td> 
				  <td nowrap class="TableData" align="left">  
				         <table width="150" class="TableBlock">      
				              <tr bgcolor="#CCCCCC">      
							      <td align="center">排序</td>    
				                  <td align="center"><b>显示字段</b></td>    
				                  <td align="center">选择</td>    
				                  <td align="center" valign="top"><b>可选字段</b></td> 
				              </tr>  
				              <tr> 
				                  <td align="center" bgcolor="#999999">      
				                       <input type="button" class="SmallInput" value=" ↑ " onClick="func_up();">      <br><br>     
				                       <input type="button" class="SmallInput" value=" ↓ " onClick="func_down();">    
				                  </td>    
				                  <td valign="top" align="center" bgcolor="#CCCCCC">    
				                       <select name="select1"        ondblclick="func_delete();" MULTIPLE style="width:200;height:280">
									  





				                       </select>
				                      <input type="button" value=" 全 选 " onClick="func_select_all1();" class="SmallInput">
				                   </td>
				                   <td align="center" bgcolor="#999999">     <input type="button" class="SmallInput" value=" ← " onClick="func_insert();">      <br><br>     <input type="button" class="SmallInput" value=" → " onClick="func_delete();">   
				                  </td>

				                  <td align="center" valign="top" bgcolor="#CCCCCC">   
				                      <select  name="select2" ondblclick="func_insert();" MULTIPLE style="width:200;height:280">
						             <!--    <option>发生同样aaa</option>	
										<option>发生同样bbb</option>	
										<option>发生同样ccc</option>	
										<option>发生同样ddd</option>	 -->
										<?php
					GLOBAL $db;
				$sql="select 费用名称 from hrms_salary_type";
				$rs=$db->Execute($sql);
				while(!$rs->EOF){
				                echo "<option value=\"";
								echo $rs->fields['费用名称'];
								echo "\">";
								echo $rs->fields['费用名称'];
								echo "</option>\r\n";
								$rs->MoveNext();
				}
				$rs->Close();
				

					
				                      ?>
                                      </select> 
									  <input type="button" value=" 全 选 " onClick="func_select_all2();" class="SmallInput">
								  </td>
				               </tr>
						   </table>
					</td> </tr>

				  <tfoot align="center" class="TableFooter">   
				      <td nowrap colspan="4" align="center"> <input type="hidden" name="FLOW_ID" value=""> 
				  <input type="hidden" name="fld_str" value="">
				  <input  type="button" value="确定" class="BigButton" onClick="exreport()">&nbsp;&nbsp;      <input type="button" value="返回" class="BigButton"  onClick="javascript:location='index.php'">     </td> 
				  </tfoot>
				  </table></div>
				  </form>
				  
				  
				  
				  </body></html>


