<?php
function newai_list_two()			{
	global $db,$common_html,$tablename_one,$tablename_two,$link;
	global $html_etc_one,$html_etc_two,$columns_one,$columns_two;
	global $tablename,$SYTEM_CONFIG_TABLE;
	print "<SCRIPT language=JavaScript>
	function clickMenu(ID){ 
	 targetelement=document.all(ID);
	if (targetelement.style.display=='none')
			targetelement.style.display='';
	else
	   targetelement.style.display='none';
	 }
	</SCRIPT>
	";
	$one_array=explode(':',$tablename_one);
	$two_array=explode(':',$tablename_two);
	$link_array=explode(':',$link);
	$columns=returntablecolumn($tablename);
	$columns_one=returntablecolumn($one_array[0]);
	$html_etc_one=returnsystemlang($one_array[0],$SYTEM_CONFIG_TABLE);
	$columns_two=returntablecolumn($two_array[0]);
	$html_etc_two=returnsystemlang($two_array[0],$SYTEM_CONFIG_TABLE);
	$sql_one="select ".$columns_one[(string)$one_array[1]].",".$columns_one[(string)$one_array[2]]." from ".$one_array[0]."";
	$rs_one=$db->Execute($sql_one);
	$Number = $rs_one->RecordCount();
	if($Number==0)			{
		print_infor($common_html['common_html']['norecord'],'trip');
		exit;
	}

	while(!$rs_one->EOF)		{
	print "
	<TABLE class=small cellSpacing=1 cellPadding=0 width='100%' align=center bgColor=#000000 border=0>
	<TBODY>
	<TR bgColor='#d3e5fa' title='' style='CURSOR: hand'	 onclick=clickMenu('".$rs_one->fields[(string)$columns_one[(string)$one_array[1]]]."')>
	<TD noWrap align=middle><table class=small cellPadding=3 align=center width=100% border=0 onmouseover=bgColor='#ffffff' onmouseout=bgColor='#d3e5fa'>
	<Tr><td align=middle><B>".$rs_one->fields[(string)$columns_one[(string)$one_array[2]]]."</B></TD></TR>
	</table></TD></TR>
	</TBODY></TABLE>\n";
	
	$one_id=$rs_one->fields[(string)$columns_one[(string)$one_array[1]]];
	$sql_two="select ".$columns_two[(string)$two_array[1]].",".$columns_two[(string)$two_array[2]]." from ".$two_array[0]." where ".$columns_two[(string)$two_array[3]]."='$one_id'";
	$rs_two=$db->Execute($sql_two);//print $sql_two;//exit;
	print "
	<TABLE class=small id=$one_id style='DISPLAY: none'
	cellSpacing=1 cellPadding=0 width='100%' bgColor=#000000 border=0>
	<TBODY>\n";
	while(!$rs_two->EOF)		{
	$two_id=$rs_two->fields[(string)$columns_two[(string)$two_array[1]]];
	$two_name=$rs_two->fields[(string)$columns_two[(string)$two_array[2]]];
	print "<TR class=TableData align=middle height=20>
	<TD noWrap><A href='".$link_array[0]."?".$link_array[1]."=".$link_array[2]."&".$columns[(string)$link_array[3]]."=$two_id&".$columns_one[(string)$one_array[1]]."=$one_id' target=\"main_body\">".$two_name."</A>
	</TD></TR>\n";
	$rs_two->MoveNext();
	}
	print "</TBODY></TABLE>\n";
	
	$rs_one->MoveNext();
	}

}
?>