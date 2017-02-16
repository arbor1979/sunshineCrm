<?php
function print_select_menu_product($showtext,$showFieldName,$showFieldID,$showtext2,$showFieldName2,$showFieldValue,$tableName,$SelectFieldName,$SelectFieldname2,$colspan=1)	{
global $db;
$sql="select $showFieldName,$showFieldID,$showFieldName2 from $tableName order by $showFieldName";//print $sql;//exit;
$rst=$db->Execute($sql);
print "<SCRIPT language=JavaScript>\n";
//-----data
print "var onecount;\n";
print "onecount=0;\n";
print "subcat = new Array();\n";
$i=0;
while(!$rst->EOF)	{
	print "subcat[$i] = new Array(\"".$rst->fields[$showFieldName]."\",\"".$rst->fields[$showFieldID]."\",\"".$rst->fields[$showFieldName2]."\");\n";
	$i++;
	$rst->MoveNext();
}
print "onecount=$i;\n";
//----deal_data_begin
print "  function changelocation(locationid)\n";
print "   {\n";
print "    document.form1.".$SelectFieldname2.".length = 0; \n";
print "    var locationid=locationid;\n";
print "    var i;\n";
print "    for (i=0;i<onecount;i++)\n";
print "        {\n";
print "          if (subcat[i][1] == locationid)\n";
print "            { \n";
print "             document.form1.".$SelectFieldname2.".value = subcat[i][2];\n";
print "            }    \n";    
print "        }\n";
print "    }    \n";
print "</SCRIPT>\n";
//-----deal_data_end
$html_etc_where_table=returnsystemlang($where_table);


$sql="select $showFieldName,$showFieldID,$showFieldName2 from $tableName order by $showFieldName";
$rse=$db->Execute($sql);
print "<TR><TD class=TableData noWrap>".$showtext."</TD><TD class=TableData noWrap>\n";
print "<SELECT id=$showFieldName onkeydown=\"if(event.keyCode==13)event.keyCode=9\" class=\"SmallSelect\" onchange=changelocation(document.form1.$showFieldName.options[document.form1.$showFieldName.selectedIndex].value) \n";
print "size=1 name=$SelectFieldName>\n";

$TestSelect = false;
while(!$rse->EOF)	{
	if($rse->fields[$showFieldID]==$showFieldValue)		{
		$selected='selected';
		$TestSelect=true;
		$ValueTextField = $rse->fields[$showFieldName2]; 
	}
	else	{
		$selected='';
	}
	print "<OPTION value=\"".$rse->fields[$showFieldID]."\" $selected>".$rse->fields[$showFieldName]."</OPTION>\n";
	$rse->MoveNext();
}
if(!$TestSelect)	{
	print "<OPTION value=\"\" selected>=========</OPTION>\n";
}
print "</SELECT> </TD></TR>\n";
print "<TR><TD class=TableData noWrap width=20%>".$showtext2."</TD><TD class=TableData noWrap>\n";
$ValueTextField!=""?'':$ValueTextField='=========';
print "<INPUT class=SmallStatic maxLength=20 name=".$SelectFieldname2." readonly value=\"".$ValueTextField."\"  onkeydown=\"if(event.keyCode==13)event.keyCode=9\">";
print "&nbsp; </TD></TR>\n";
}
?>