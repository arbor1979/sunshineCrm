<?php
//#############################################################################
//四个下拉菜单联运的实现部分，主要为实现省份，地区，地区代码，邮政编码部分的实现
//#############################################################################
function print_select_four_address($ValueArray,$SYSTEM_TABLE)	{

$showfield="city";
$tablename="dict_cities";
$field_value="City_ID";
$field_name="City";
$where="Province_ID";
$where_value="1";
$where_table="dict_provinces";
$where_table_value="Province_ID";
$where_table_name="Province";

$colspan=1;

//附加字段 - 用于语言显示
$province = "provinces";
$City  = $showfield;
$postcode = "postcode";
$cityCode = "cityCode";

global $db,$html_etc;
$sql="select $field_value,$field_name,$where,Area_Code,ZIP from $tablename order by $field_value";
$rst=$db->Execute($sql);
print "<SCRIPT language=JavaScript>\n";
//-----data
print "var onecount;\n";
print "onecount=0;\n";
print "subcat = new Array();\n";
$i=0;
while(!$rst->EOF)	{
	print "subcat[$i] = new Array(\"".$rst->fields[$field_name]."\",\"".$rst->fields[$where]."\",\"".$rst->fields[$field_value]."\",\"".$rst->fields['Area_Code']."\",\"".$rst->fields['ZIP']."\");\n";
	$i++;
	$rst->MoveNext();
}
print "onecount=$i;\n";
//----deal_data_begin
print "function changelocation(locationid)\n";
print "{\n";
print "    document.form1.$showfield.length = 0; \n";
print "    document.form1.$cityCode.length = 0; \n";
print "    document.form1.$postcode.length = 0; \n";
print "    var locationid=locationid;\n";
print "    var i;\n";
print "    for (i=0;i<onecount;i++)\n";
print "        {\n";
print "          if (subcat[i][1] == locationid)\n";
print "            { \n";
print "             document.form1.$showfield.options[document.form1.$showfield.length] = new Option(subcat[i][0], subcat[i][2]);\n";
//print "             document.form1.$cityCode.options[document.form1.$cityCode.length] = new Option(subcat[i][3], subcat[i][3]);\n";
print "             document.form1.$cityCode.value = subcat[i][3];\n";
//print "             document.form1.$postcode.options[document.form1.$postcode.length] = new Option(subcat[i][4], subcat[i][4]);\n";
print "             document.form1.$postcode.value = subcat[i][4];\n";
print "            }    \n";    
print "        }\n";
print "}    \n";

print "function changelocation_city(locationid)\n";
print "{\n";
print "    document.form1.$cityCode.length = 0; \n";
print "    document.form1.$postcode.length = 0; \n";
print "    var locationid=locationid;\n";
print "    var i;\n";
print "    for (i=0;i<onecount;i++)\n";
print "        {\n";
print "          if (subcat[i][2] == locationid)\n";
print "            { \n";
//print "             document.form1.$cityCode.options[document.form1.$cityCode.length] = new Option(subcat[i][3], subcat[i][3]);\n";
print "             document.form1.$cityCode.value = subcat[i][3];\n";
//print "             document.form1.$postcode.options[document.form1.$postcode.length] = new Option(subcat[i][4], subcat[i][4]);\n";
print "             document.form1.$postcode.value = subcat[i][4];\n";
print "            }    \n";    
print "        }\n";
print "}    \n";

print "</SCRIPT>\n";
//-----deal_data_end

//#############################################################################
print "<TR><TD class=TableData noWrap width=20%>".$html_etc[$SYSTEM_TABLE]['country']." ：</TD><TD class=TableData noWrap>\n";
print "<INPUT class=SmallStatic maxLength=20 name=countryName readonly value=\"中国\"  onkeydown=\"if(event.keyCode==13)event.keyCode=9\">";
print "<INPUT type=hidden maxLength=20 name=country value=1>";
//print "<SELECT name=country class=\"SmallSelect\" onkeydown=\"if(event.keyCode==13)event.keyCode=9\">\n";
//print "<OPTION value=\"1\" >中国</OPTION>\n";
//print "</SELECT>&nbsp;\n";
print "</TD></TR>\n";

print "<TR><TD class=TableData noWrap width=20%>".$html_etc[$SYSTEM_TABLE]['countryCode']." ：</TD><TD class=TableData noWrap>\n";
print "<INPUT class=SmallStatic maxLength=20 name=countryCode readonly value=\"0086\"  onkeydown=\"if(event.keyCode==13)event.keyCode=9\">";
//print "<SELECT name=countryCode class=\"SmallSelect\" onkeydown=\"if(event.keyCode==13)event.keyCode=9\">\n";
//print "<OPTION value=\"0086\" >0086</OPTION>\n";
//print "</SELECT>&nbsp;\n";
print "</TD></TR>\n";
//#############################################################################

$html_etc_where_table=returnsystemlang($where_table);
print "<TR><TD class=TableData noWrap  width=20%>".$html_etc[$SYSTEM_TABLE][$province]." ：</TD><TD class=TableData noWrap>\n";
print "<SELECT id=$province onkeydown=\"if(event.keyCode==13)event.keyCode=9\" class=\"SmallSelect\" onchange=changelocation(document.form1.$province.options[document.form1.$province.selectedIndex].value) \n";
print "size=1 name=$province>\n";

$sql="select $where_table_value,$where_table_name from $where_table order by $where_table_value";
$rse=$db->Execute($sql);
//print $sql;//exit;
while(!$rse->EOF)	{
	$rse->fields[$where_table_value]==$ValueArray[$province]?$selected='selected':$selected='';
	print "<OPTION value=\"".$rse->fields[$where_table_value]."\" $selected>".$rse->fields[$where_table_name]."</OPTION>\n";
	$rse->MoveNext();
}
print "</SELECT> </TD></TR>\n";
print "<TR><TD class=TableData noWrap width=20%>".$html_etc[$SYSTEM_TABLE][$City]." ：</TD><TD class=TableData noWrap>\n";

$ValueArray[$province]!=''?$where_value=$ValueArray[$province]:'';
print "<SELECT name=$showfield class=\"SmallSelect\" onchange=changelocation_city(document.form1.$showfield.options[document.form1.$showfield.selectedIndex].value)  onkeydown=\"if(event.keyCode==13)event.keyCode=9\">\n";
$sql="select $field_value,$field_name from $tablename where $where='$where_value'  order by $field_name";
$rsc=$db->Execute($sql);
while(!$rsc->EOF)	{
	$ValueArray[$City]==$rsc->fields[$field_value]?$selected='selected':$selected='';
	print "<OPTION value=\"".$rsc->fields[$field_value]."\" $selected>".$rsc->fields[$field_name]."</OPTION>\n";
	$rsc->MoveNext();
}
print "</SELECT>&nbsp; </TD></TR>\n";

//地区区号
$ValueArray[$cityCode]==""?$ValueTextField='010':$ValueTextField=$ValueArray[$cityCode];
print "<TR><TD class=TableData noWrap width=20%>".$html_etc[$SYSTEM_TABLE][$cityCode]." ：</TD><TD class=TableData noWrap>\n";
print "<INPUT class=SmallStatic maxLength=20 name=$cityCode readonly value=\"".$ValueTextField."\"  onkeydown=\"if(event.keyCode==13)event.keyCode=9\">";
//print "<SELECT name=$cityCode class=\"SmallSelect\"  onkeydown=\"if(event.keyCode==13)event.keyCode=9\">\n";
//print "<OPTION value=\"".$ValueArray[$postcode]."\" >$ValueTextField</OPTION>\n";
//print "</SELECT>\N";
print "&nbsp; </TD></TR>\n";

//邮政编码
$ValueArray[$postcode]==""?$ValueTextField='100000':$ValueTextField=$ValueArray[$postcode];
print "<TR><TD class=TableData noWrap width=20%>".$html_etc[$SYSTEM_TABLE][$postcode]." ：</TD><TD class=TableData noWrap>\n";
print "<INPUT class=SmallStatic maxLength=20 name=$postcode readonly value=\"".$ValueTextField."\"  onkeydown=\"if(event.keyCode==13)event.keyCode=9\">";
//print "<SELECT name=$postcode class=\"SmallSelect\"  onkeydown=\"if(event.keyCode==13)event.keyCode=9\">\n";
//print "<OPTION value=\"".$ValueArray[$postcode]."\" >$ValueTextField</OPTION>\n";
//print "</SELECT>\N";
print "&nbsp; </TD></TR>\n";
}
?>