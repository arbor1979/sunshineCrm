<?php
//##########################################################
//格式：_add _view _Value		说明性表述方式
//userDefineInforStatus_add		新增与编辑的函数编制，两个参数：前者为数组图，后者为字段索引值
//userDefineInforStatus_view	查阅视图函数说明
//userDefineInforStatus_Value	列表视图说明
//#########################################################
//提供用户自定义类型：用于增加和编辑数据时

function diaorucangku_add($fields,$i)		{
global $db,$_SESSION,$common_html;
$notnull=trim($fields['null'][$i]['inputtype']);
$notnull=='notnull'?$notnulltext=$common_html['common_html']['mustinput']:$notnulltext='';
$fieldname1=$fields['name'][$i];
$fieldname2=$fields['input'][$i][0];
$j = array_search($fieldname2,$fields['name'],true);
$notnull=trim($fields['null'][$j]['inputtype']);
$notnull=='notnull'?$notnulltext1=$common_html['common_html']['mustinput']:$notnulltext1='';
$class = "SmallSelect";
print "<script type=\"text/javascript\" language=\"javascript\" src=\"".ROOT_DIR."general/ERP/Enginee/jquery/jquery.js\"></script>";
print "<script language=javascript>
var $$ = jQuery.noConflict();
function sendRequest(action,params) {
$$.ajax({ 
		  type:'GET', 
		  url:'officeproducttiaoku_newai.php?action='+action+'&'+params, 
		  dataType: 'xml', 
		  cache:false,
		  success:function(data) 
		  { 
		  	
		  	";
		  		print "

	   		  	 $$(data).find('kuguanren').each(function(i) {
                   	
						var rowid=$$(this).children('id').text();
						var name=$$(this).children('name').text();

						document.form1.$fieldname2.options[document.form1.$fieldname2.length] = new Option(name, rowid);
						if(rowid=='".$fields['value'][$fieldname2]."')
							document.form1.$fieldname2.options[document.form1.$fieldname2.length-1].selected=true;
						i++;
                    });				
		  },
		  error:function(XmlHttpRequest,textStatus, errorThrown)
	      {
			  var errorPage = XmlHttpRequest.responseText;  
			  alert('获取出错：'+errorThrown);
	      }
	});

}

function changelocation(locationid)
{
	document.form1.$fieldname2.length = 0;	
	if(locationid!='')
	{
		
	    sendRequest('kuguanren','tostore='+locationid);
	}
}
";

	print "window.onload=function(){
		document.form1.$fieldname1.onchange();
	}
	";
print "
</SCRIPT>\n";
print "<TR><TD class=TableData noWrap>调入仓库:</TD><TD class=TableData noWrap>\n";
$fromstore=$_GET['调出仓库'];
$sql="select * from officeproductcangku where 编号<>'$fromstore'";
$rs=$db->Execute($sql);
$rs_a=$rs->GetArray();
print "<select id='$fieldname1' name='$fieldname1' value='".$fields['value'][$fieldname1]."' onchange=\"changelocation(this.value)\">";
foreach ($rs_a as $row)
{
	print "<option value='".$row['编号']."'>".$row['仓库名称']."</option>";
}
print "</SELECT>&nbsp;$notnulltext</TD></TR>\n";

print "<TR><TD class=TableData noWrap>审核人:</TD><TD class=TableData noWrap>\n";
print "<SELECT name=$fieldname2 class=\"$class\"  onkeydown=\"if(event.keyCode==13)event.keyCode=9\">\n";
print "</SELECT>&nbsp;将提交此人审核方能生效</TD></TR>\n";
}

?>