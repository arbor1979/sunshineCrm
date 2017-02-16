<?php
function newai_list_one()			{
	global $db,$common_html,$tablename_one,$tablename_two,$link;
	global $html_etc_one,$html_etc_two,$columns_one,$columns_two;
	global $tablename,$SYTEM_CONFIG_TABLE;
	global $SUNSHINE_USER_NAME_VAR,$SUNSHINE_USER_ID_VAR,$_SESSION;
	$USER_NAME=$_SESSION[$SUNSHINE_USER_NAME_VAR];
	print "<SCRIPT language=JavaScript>
	function clickMenu(url){
	parent.main_body.location=url;
	}
	</SCRIPT>
	";
	$one_array=explode(':',$tablename_one);//print_R($one_array);
	$link_array=explode(':',$link);//print_R($link_array);
	$columns=returntablecolumn($tablename);
	$columns_one=returntablecolumn($one_array[0]);
	$html_etc_one=returnsystemlang($one_array[0],$SYTEM_CONFIG_TABLE);
	switch($db->databaseType)				{
		case 'mysql':
			switch($one_array[3])			{
				case 'name':
					$sql_one="select ".$columns_one[(string)$one_array[1]].",".$columns_one[(string)$one_array[2]]." from ".$one_array[0]." where ".$columns_one[(string)$one_array[4]]."='".$USER_NAME."'";
					break;
				case 'id':
					$sql_one="select ".$columns_one[(string)$one_array[1]].",".$columns_one[(string)$one_array[2]]." from ".$one_array[0]."";
					break;
				default:
					$sql_one="select ".$columns_one[(string)$one_array[1]].",".$columns_one[(string)$one_array[2]]." from ".$one_array[0]."";
					break;
			}
			break;
		case 'mssql':
			switch($one_array[3])			{
				case 'name':
					$sql_one="select [".$columns_one[(string)$one_array[1]]."],[".$columns_one[(string)$one_array[2]]."] from [".$one_array[0]."] where [".$columns_one[(string)$one_array[4]]."]='".$USER_NAME."'";
					break;
				case 'id':
					$sql_one="select [".$columns_one[(string)$one_array[1]]."],[".$columns_one[(string)$one_array[2]]."] from [".$one_array[0]."]";
					break;
				default:
					$sql_one="select [".$columns_one[(string)$one_array[1]]."],[".$columns_one[(string)$one_array[2]]."] from [".$one_array[0]."]";
					break;
			}
			break;
	}

	//print $sql_one;
	$rs_one=$db->CacheExecute(150,$sql_one);
	if($rs_one->RecordCount()==0)			{
		print_infor($common_html['common_html']['norecord'],'trip');
		exit;
	}
	while(!$rs_one->EOF)		{
	if(StrLen($link_array[3])>2)	$LinkIndexName = (string)$link_array[3];
	else		$LinkIndexName = $columns[(string)$link_array[3]];
	$url=$link_array[0]."?".$link_array[1]."=".$link_array[2]."&".$LinkIndexName."=".$rs_one->fields[(string)$columns_one[(string)$one_array[1]]];
	print "
	<TABLE class=small cellSpacing=1 cellPadding=0 width='100%' align=center bgColor=#000000 border=0>
	<TBODY>
	<TR class=TableContent title='' style='CURSOR: hand'	 onclick=clickMenu('$url')>
	<TD noWrap align=middle><table class=small cellPadding=3 align=center width=100% border=0 onmouseover=bgColor='#ffffff' onmouseout=bgColor='#d3e5fa'>
	<Tr><td align=middle><B>".$rs_one->fields[(string)$columns_one[(string)$one_array[2]]]."</B></TD></TR>
	</table></TD></TR>
	</TBODY></TABLE>\n";
	$rs_one->MoveNext();
	}

}

?>