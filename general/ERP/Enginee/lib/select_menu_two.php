<?php
function print_select_two($showtext,$showfield,$showtext2,$fieldname2,$value,$tablename,$field_value,$field_name,$where,$where_value,$where_table,$where_table_value,$where_table_name,$colspan=1,$value2,$notnulltext="")	{
global $db,$_SESSION,$SUNSHINE_USER_DEPT_VAR;


	 //用户类型限制条件##########################开始
	 global $fields;
	 global $fields2;
	 //print $value;
	 //print_R($fields['value']);
	 //print_R($fields['USER_PRIVATE'][$var]);
	 if($fields['USER_PRIVATE'][$showfield]!="")	{
		 $readonly = $fields['USER_PRIVATE'][$showfield];
		 $class = "SmallStatic";
	 }
	 else	{
		 $readonly = "";
		 $class = "SmallSelect";
	 }
	 //用户类型限制条件##########################结束


$sql="select $where_table_value,$where_table_name,$where from $where_table order by $where_table_value";
//print $sql;
$rst=$db->Execute($sql);
print "<SCRIPT language=JavaScript>\n";
//-----data
print "var onecount;\n";
print "onecount=0;\n";
print "subcat = new Array();\n";
$i=0;
while(!$rst->EOF)	{
		//对班级信息进行特殊处理
		if($where_table=="edu_banji")		{ 
			$OneClassStudentNumber = OneClassStudentNumber($rst->fields[$where_table_name]);	
			$OneClassStudentNumber = "(".$OneClassStudentNumber."人)";
		} else	{
			$OneClassStudentNumber = '';
		}

	print "subcat[$i] = new Array(\"".$rst->fields[$where_table_name].$OneClassStudentNumber."\",\"".$rst->fields[$where]."\",\"".$rst->fields[$where_table_value]."\");\n";
	$i++;
	$rst->MoveNext();
}
print "onecount=$i;\n";
//----deal_data_begin
print "  function changelocation(locationid)\n";
print "   {\n";
print "    document.form1.$fieldname2.length = 0; \n";
print "    var locationid=locationid;\n";
print "    var i;\n";
print "    for (i=0;i<onecount;i++)\n";
print "        {\n";
print "          if (subcat[i][1] == locationid)\n";
print "            { \n";
print "             document.form1.$fieldname2.options[document.form1.$fieldname2.length] = new Option(subcat[i][0], subcat[i][2]);\n";
print "            }    \n";    
print "        }\n";
print "    }    \n";
print "</SCRIPT>\n";
//-----deal_data_end
$html_etc_where_table=returnsystemlang($where_table);


$sql="select $field_value,$field_name from $tablename order by $field_value";
$rse=$db->Execute($sql);
//print "<BR>".$sql;//exit;
print "<TR><TD class=TableData noWrap>".$showtext."</TD><TD class=TableData noWrap>\n";

print "<SELECT id=$showfield $readonly  title='".$fields['USER_PRIVATE_TEXT'][$showfield]."' onkeydown=\"if(event.keyCode==13)event.keyCode=9\" class=\"$class\" onchange=changelocation(document.form1.$showfield.options[document.form1.$showfield.selectedIndex].value) \n";
print "size=1 name=$showfield>\n";

$$TestSelect = false;
while(!$rse->EOF)	{
	if($rse->fields[$field_value]==$value)		{
		$selected='selected';
		$TestSelect=true;
	}
	else	{
		$selected='';
	}
	//print "<OPTION value=\"".$rse->fields[$field_value]."\" $selected>".$rse->fields[$field_name]."[".$rse->fields[$field_value]."]</OPTION>\n";
	print "<OPTION value=\"".$rse->fields[$field_value]."\" $selected>".$rse->fields[$field_name]."</OPTION>\n";
	$rse->MoveNext();
}
if(!$TestSelect)	{
	print "<OPTION value=\"\" selected></OPTION>\n";
}
print "</SELECT>&nbsp;$notnulltext</TD></TR>\n";

$where_value==""?$where_value=$value:'';

//print $where_value;
$sql="select $where_table_value,$where_table_name from $where_table  where $where='$where_value' order by $where_table_name";
//print $sql;//exit;
global $html_etc;



print "<TR><TD class=TableData noWrap>".$showtext2."</TD><TD class=TableData noWrap>\n";
print "<SELECT name=$fieldname2 class=\"$class\" $readonly  title='".$fields['USER_PRIVATE_TEXT'][$showfield]."' onkeydown=\"if(event.keyCode==13)event.keyCode=9\">\n";
$rsc=$db->Execute($sql);

while(!$rsc->EOF)	{

	//对班级信息进行特殊处理
	if($where_table=="edu_banji")		{ 
		$OneClassStudentNumber = OneClassStudentNumber($班级名称);	
		$OneClassStudentNumber = "(".$OneClassStudentNumber."人)";
	} else	{
		$OneClassStudentNumber = '';
	}
	
	$value2==$rsc->fields[$where_table_value]?$selected='selected':$selected='';
	//print "<OPTION value=\"".$rsc->fields[$where_table_value]."\" $selected>".$rsc->fields[$where_table_name]."[".$rsc->fields[$where_table_value]."]$OneClassStudentNumber</OPTION>\n";
	print "<OPTION value=\"".$rsc->fields[$where_table_value]."\" $selected>".$rsc->fields[$where_table_name].$OneClassStudentNumber."</OPTION>\n";
	$rsc->MoveNext();
}
if($rsc->RecordCount()==0)	{
	print "<OPTION value=\"\" $selected></OPTION>\n";
}
print "</SELECT>&nbsp; ".$rsc->fields[$where_table_value]."</TD></TR>\n";
}


function OneClassStudentNumber($班级名称)	{
	global $db;
	$sql = "select count(姓名) as NUM from edu_student where 班号='$班级名称'";
	$rs = $db->Execute($sql);
	$rs_a = $rs->GetArray();
	return $rs_a[0]['NUM'];
}
?>