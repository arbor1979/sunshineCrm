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
	<title>EMAIL������</title>
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
						alert("����˳��ʱ����ѡ������һ�");     return; 
						}  
						else if(sel_count>1)  {     
							alert("����˳��ʱ��ֻ��ѡ������һ�");     return; 
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
						alert("��������ģ���˳��ʱ����ѡ������һ�");    
						return;  }  
						else if(sel_count>1)  {     
							alert("��������ģ���˳��ʱ��ֻ��ѡ������һ�");     return; 
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
				<span class="big3">&nbsp;&nbsp;EMAIL������ </span>  
				  </td>  
				</tr>
				</table>
				
				<br>

				<div align="center">
				<table class="TableBlock" align="center" > 
				<tr>
				  <td nowrap class="TableContent">&nbsp;&nbsp;��Ա�� 
				  </td>    
				  <td nowrap class="TableData">       
				<input type="hidden" name="COPY_TO_ID" value="">      
				<textarea cols=40 name="COPY_TO_NAME" rows=3 class="BigStatic" wrap="yes" readonly></textarea>        
				<a href="javascript:;" class="orgAdd" onClick="SelectUser('','COPY_TO_ID', 'COPY_TO_NAME')">ѡ��</a>        <a href="javascript:;" class="orgClear" onClick="ClearUser('COPY_TO_ID', 'COPY_TO_NAME')">���</a><br />&nbsp;<img src="/images/attention.gif" height="16" title="��ʾ">��ԱΪ��ʱ����ȫ����Ա�Ĺ�����     
				  </td>  
				</tr> 
				<tr> 
				  <td nowrap class="TableContent">&nbsp;&nbsp;ѡ� </td>   
				  <td nowrap class="TableData">       
				<input type="checkbox" name="ZERO" id="ZERO">
				<label for="ZERO">����ʾ����Ϊ�����Ŀ</label>            
				  </td>  
				</tr>  
				<tr>  
				  <td nowrap class="TableContent">&nbsp;&nbsp;������ݣ�
				  </td> 
				  <td nowrap class="TableData" align="left">  
				         <table width="150" class="TableBlock">      
				              <tr bgcolor="#CCCCCC">      
							      <td align="center">����</td>    
				                  <td align="center"><b>��ʾ�ֶ�</b></td>    
				                  <td align="center">ѡ��</td>    
				                  <td align="center" valign="top"><b>��ѡ�ֶ�</b></td> 
				              </tr>  
				              <tr> 
				                  <td align="center" bgcolor="#999999">      
				                       <input type="button" class="SmallInput" value=" �� " onClick="func_up();">      <br><br>     
				                       <input type="button" class="SmallInput" value=" �� " onClick="func_down();">    
				                  </td>    
				                  <td valign="top" align="center" bgcolor="#CCCCCC">    
				                       <select name="select1"        ondblclick="func_delete();" MULTIPLE style="width:200;height:280">
									  





				                       </select>
				                      <input type="button" value=" ȫ ѡ " onClick="func_select_all1();" class="SmallInput">
				                   </td>
				                   <td align="center" bgcolor="#999999">     <input type="button" class="SmallInput" value=" �� " onClick="func_insert();">      <br><br>     <input type="button" class="SmallInput" value=" �� " onClick="func_delete();">   
				                  </td>

				                  <td align="center" valign="top" bgcolor="#CCCCCC">   
				                      <select  name="select2" ondblclick="func_insert();" MULTIPLE style="width:200;height:280">
						             <!--    <option>����ͬ��aaa</option>	
										<option>����ͬ��bbb</option>	
										<option>����ͬ��ccc</option>	
										<option>����ͬ��ddd</option>	 -->
										<?php
					GLOBAL $db;
				$sql="select �������� from hrms_salary_type";
				$rs=$db->Execute($sql);
				while(!$rs->EOF){
				                echo "<option value=\"";
								echo $rs->fields['��������'];
								echo "\">";
								echo $rs->fields['��������'];
								echo "</option>\r\n";
								$rs->MoveNext();
				}
				$rs->Close();
				

					
				                      ?>
                                      </select> 
									  <input type="button" value=" ȫ ѡ " onClick="func_select_all2();" class="SmallInput">
								  </td>
				               </tr>
						   </table>
					</td> </tr>

				  <tfoot align="center" class="TableFooter">   
				      <td nowrap colspan="4" align="center"> <input type="hidden" name="FLOW_ID" value=""> 
				  <input type="hidden" name="fld_str" value="">
				  <input  type="button" value="ȷ��" class="BigButton" onClick="exreport()">&nbsp;&nbsp;      <input type="button" value="����" class="BigButton"  onClick="javascript:location='index.php'">     </td> 
				  </tfoot>
				  </table></div>
				  </form>
				  
				  
				  
				  </body></html>


