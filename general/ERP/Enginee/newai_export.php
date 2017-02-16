<?php

function newai_export($fields,$mode='table')		{
	global $common_html,$html_etc;
	global $return_sql_line,$db;
	global $columns;
	//print_R($_GET);
	global $showlistfieldlist,$group_filter;
	
	$tablename=$fields['table']['name'];
	$SQL=$fields['sql']['SQL'];
	$init=explode('_',$_GET['action']);
	$mark=$init[1];

	global $tablewidth;
	$tablewidth=$tablewidth!=""?$tablewidth:450;

	if($group_filter!="")					{
				$group_filter_Array = explode(':',$group_filter);
				$TableFieldIndex = $group_filter_Array[0];
				$KeyName = $columns[$TableFieldIndex];
				$ChildTableName = $group_filter_Array[1];
				$ChildTableFieldValueIndex = $group_filter_Array[2];
				$ChildTableFieldNameIndex = $group_filter_Array[3];
				$ChildColumns=returntablecolumn($ChildTableName);
				$ChildTableFieldValue = $ChildColumns[$ChildTableFieldValueIndex];
				$ChildTableFieldName = $ChildColumns[$ChildTableFieldNameIndex];
				$Childhtml_etc=returnsystemlang($ChildTableName,$SYTEM_CONFIG_TABLE);
				//print_R($Childhtml_etc);
				$ChildTableFieldHTMLValue = $Childhtml_etc[$ChildTableName][$ChildTableFieldValue];
				$ChildTableFieldHTMLName = $Childhtml_etc[$ChildTableName][$ChildTableFieldName];
	}
	else	{
		$KeyName = "说明";
	}

	print "<script>
	//CSV
	function selectid_str_init_CSV(mark)
	{
	selectid_str = \"\";
	for(i=0;i<document.all(\"selectid\").length-1;i++)
		{

		el = document.all(\"selectid\").item(i);
		if(el.checked)
		{	val = el.value;
			if(val !=\"\")	{
				selectid_str += val + \",\";
			}
		}
	}

	ell = document.all(\"selectid\").item(document.all(\"selectid\").length-1);
	if(ell.checked)
	{	val = ell.value;
		if(val !=\"\")	{
			selectid_str += val ;
		}
	}

	tablename_		=	document.form1.tablename.value;
	searchfield_	=	document.form1.searchfield.value;
	searchvalue_	=	document.form1.searchvalue.value;
	AdvanceSearch_	=	document.form1.AdvanceSearch.value;
	exportfield= selectid_str;


	";
	if($_GET['actionadv']=="exportadv_default")			{
		//不用显示或得到SELECTID的值
		print "	url=\"?action=export_\"+mark+\"_data&method=CSV&actionadv=exportadv_default&exportfield=\"+exportfield+\"&tablename=\"+tablename_+\"&searchfield=\"+searchfield_+\"&searchvalue=\"+searchvalue_+AdvanceSearch_";
	}
	else		{
		print "var grouplist='';\n";
		for($k=0;$k<sizeof($columns);$k++)					
		{
			$KeyElement = $columns[$k];
			if($_GET[$KeyElement]!="")	
					print "grouplist=grouplist+'&".$KeyElement."=".$_GET[$KeyElement]."';\n";
		}
	
		print "	url=\"?action=export_\"+mark+\"_data&method=CSV&exportfield=\"+exportfield+\"&tablename=\"+tablename_+\"&searchfield=\"+searchfield_+\"&searchvalue=\"+searchvalue_+grouplist+AdvanceSearch_";
	}

	print "
	//alert(url);
	location=url;
	}
	//XLS
	function selectid_str_init_XLS(mark)
	{
	selectid_str = \"\";
	for(i=0;i<document.all(\"selectid\").length-1;i++)
		{

		el = document.all(\"selectid\").item(i);
		if(el.checked)
		{	val = el.value;
			if(val !=\"\")	{
				selectid_str += val + \",\";
			}
		}
	}

	ell = document.all(\"selectid\").item(document.all(\"selectid\").length-1);
	if(ell.checked)
	{	val = ell.value;
		if(val !=\"\")	{
			selectid_str += val ;
		}
	}

	tablename_		=	document.form1.tablename.value;
	searchfield_	=	document.form1.searchfield.value;
	searchvalue_	=	document.form1.searchvalue.value;
	AdvanceSearch_	=	document.form1.AdvanceSearch.value;
	exportfield= selectid_str;
	";
	if($_GET['actionadv']=="exportadv_default")			{
		//不用显示或得到SELECTID的值
		print "	url=\"?action=export_\"+mark+\"_data&actionadv=exportadv_default&exportfield=\"+exportfield+\"&tablename=\"+tablename_+\"&searchfield=\"+searchfield_+\"&searchvalue=\"+searchvalue_+AdvanceSearch_";
	}
	else		{
		print "var grouplist='';\n";
		for($k=0;$k<sizeof($columns);$k++)					
		{
			$KeyElement = $columns[$k];
			if($_GET[$KeyElement]!="")	
					print "grouplist=grouplist+'&".$KeyElement."=".$_GET[$KeyElement]."';\n";
		}
		print "	url=\"?action=export_\"+mark+\"_data&exportfield=\"+exportfield+\"&tablename=\"+tablename_+\"&searchfield=\"+searchfield_+\"&searchvalue=\"+searchvalue_+grouplist+AdvanceSearch_;";
		if($_GET['时间字段'])
		{
			if(strlen($_GET['结束时间ADD'])==10)
			{
				$_GET['结束时间ADD']=$_GET['结束时间ADD']." 23:59:59";
			}
			print ";\r\n url+='&".$_GET['时间字段']."_开始时间=".$_GET['开始时间ADD']."&".$_GET['时间字段']."_结束时间=".$_GET['结束时间ADD']."';";
		}
	}
	
	print "
	//url
	//alert(url);
	location=url;
	}
	</script>";
	form_begin("form1");
	table_begin($tablewidth);

	switch($mode)		{
		case 'table':
			print_title($common_html['common_html']['tableexport'],3);
			print "<TR class=TableData>\n";
			print "<TD noWrap align=middle>选择</TD>\n";
			print "<TD width=200>字段描述</TD>\n";
			print "<TD width=200>字段名称</TD>\n";
			print "</TR>\n";
			for($i=0;$i<sizeof($columns);$i++)		{
				$list=$columns[$i];
				print "<TR class=TableData>\n";
				print "<TD noWrap align=middle width=20><input type=\"checkbox\" checked name=\"selectfield\" value=\"$list\"></TD>\n";
				print "<TD>".$html_etc[$tablename][$list]."</TD>\n";
				print "<TD>$list</TD>\n";
				print "</TR>\n";
				$temp_function='selectfield_str';
			}
			break;
		case 'content':
			print_title($common_html['common_html']['contentexport'],3);
			
			print "<TR class=TableData>\n";
			print "<TD noWrap align=center width=30>选择</TD>\n";
			print "<TD width=100>字段描述</TD>\n";
			print "<TD width=150>字段名称</TD>\n";
			print "</TR>\n";
			//附加组数据导出--开始
			//print_R($group_filter_Array);
			if($group_filter!=""&&$_GET['actionadv']!="exportadv_default")					{

				//如果强制GET变量已经进行过预定义,那么沿用预定义内容进行 2010-9-2
				$TableFieldIndex = $group_filter_Array[0];
				$KeyName = $columns[$TableFieldIndex];
				$PHP_SELF_ARRAY = explode('/',$_SERVER['PHP_SELF']);
				$FILE_SELF_NAME = array_pop($PHP_SELF_ARRAY);
				$FileDirName = array_pop($PHP_SELF_ARRAY);
				//用于PGSQL下面不进行数据较验
				//print $_SESSION['LOGIN_USER_ID'];
				//如果强制GET变量已经进行过预定义,那么沿用预定义内容进行 2010-9-2
				//&&$FileDirName=="Teacher" 只有在Teacher目录下面使用 2010-9-25 正常使用
				if($_GET[$KeyName]!=""){
					//$ChildTableName = $group_filter_Array[1];
					//$ChildTableFieldValueIndex = $group_filter_Array[2];
					//$ChildTableFieldNameIndex = $group_filter_Array[3];
					//print $KeyName;
					$附加判断条件Array = explode(',',$_GET[$KeyName]);
					$附加判断条件 = "'".join("','",$附加判断条件Array)."'";
					$sql = "
					select $ChildTableFieldValue,$ChildTableFieldName
					from $ChildTableName
					where ( $ChildTableFieldValue in ($附加判断条件)
							or
							$ChildTableFieldName in ($附加判断条件)
							)
					order by $ChildTableFieldName";
					//
				}
				else	{
					$sql = "select $ChildTableFieldValue,$ChildTableFieldName from $ChildTableName order by $ChildTableFieldName";
				}
				//print $sql;
				//print $index_name;print_R($_GET);
				$rs = $db->CacheExecute(150,$sql);
				$rs_a = $rs->GetArray();


				if($Childhtml_etc[$ChildTableName][$ChildTableFieldName]!="")	 {
					$ShowText = "按".$html_etc[$tablename][$KeyName]."过滤";
					//$ShowText = "按".$Childhtml_etc[$ChildTableName][$ChildTableFieldName]."过滤";
				}
				else	{
					$ShowText = "按".$html_etc[$tablename][$KeyName]."过滤";
				}
				print "<TR class=TableData>\n";
				print "<TD noWrap align=middle><input type=\"checkbox\" checked name=\"selectidtemp\" disabled value=\"$index\"></TD>\n";
				print "<TD  width=120 nowrap>".$ShowText."</TD>\n";
				print "<TD  width=150 nowrap>";
				//print_R($_GET);
				//print $KeyName;
				//如果隐藏的话就显示为只读
				if($group_filter_Array[4]=="hidden")			{
					//如果隐藏的话就显示为只读
					$显示名称 = returntablefield($ChildTableName,$ChildTableFieldValue,$_GET[$KeyName],$ChildTableFieldName);
					print "<select class=\"SmallSelect\" name=\"".$KeyName."\">\n";
					print "<option value=\"".$_GET[$KeyName]."\" >".$显示名称."[".$_GET[$KeyName]."]</option>\n";
					print "</select>\n";
				}
				else						{
					//显示成为列表
					print "<select class=\"SmallSelect\" name=\"".$KeyName."\" >\n";
					//print "<option value=\"\" >".$common_html['common_html']['allrecords']."</option>\n";
					print "<option value=\"\" >".$html_etc[$tablename][$list['index_name']]."[".$common_html['common_html']['allrecords']."]</option>\n";
					//2009-12-24加入对列表组的过滤
					for($i=0;$i<sizeof($rs_a);$i++)	{
						if($_GET[$KeyName]==$rs_a[$i][$ChildTableFieldValue])
							$CheckedX = "selected";
						else
							$CheckedX = "";
						print "<option value=\"".$rs_a[$i][$ChildTableFieldValue]."\" $CheckedX >".$rs_a[$i][$ChildTableFieldName]."[".$rs_a[$i][$ChildTableFieldValue]."]</option>\n";
					}
					print "</select>\n";
				}


				//2009-12-24加入对搜索属性的支持
				print "<input type=hidden name='searchfield' value='".$_GET['searchfield']."'>\n";
				print "<input type=hidden name='searchvalue' value='".$_GET['searchvalue']."'>\n";
				print "<input type=hidden name='tablename' value='$tablename'>\n";
				print "<input type=hidden name='AdvanceSearch' value='$ADD_SEARCH_VALUE'>\n";
				print "</TD></TR>\n";
			}
			else	{
				//高级搜索时出现的隐藏变量
				if($_GET['actionadv']=="exportadv_default")			{
					print "<TR class=TableData>\n";
					print "<TD noWrap align=middle><input type=\"checkbox\" checked name=\"selectidtemp\" disabled value=\"$index\"></TD>\n";
					print "<TD  width=90% colspan=2>高级搜索:\n";

					//print "<select class=\"SmallSelect\" name=\"".$KeyName."\" disabled>\n";
					//print "<option value=\"\" >".$common_html['common_html']['allrecords']."</option>\n";
					//print "<option value=\"\" >".$html_etc[$tablename][$list['index_name']]."[".$common_html['common_html']['allrecords']."]</option>\n";
					//print "</select>\n";
					$showlistfieldlist_array=explode(',',$showlistfieldlist);//print_R($showlistfieldlist_array);
					for($i=0;$i<sizeof($showlistfieldlist_array);$i++)				{
						$index=$showlistfieldlist_array[$i];
						$list=$columns[$index];
						if($_GET[$list]!="")		{
							$ADD_SEARCH_VALUE .= "&$list=".$_GET[$list];
							$ADD_SEARCH_TEXT .= " $list:".$_GET[$list];
						}
						else	if($_GET[$list."_最小值"]!=""&&$_GET[$list."_最大值"]!="")		{
							$ADD_SEARCH_VALUE .= "&".$list."_最小值=".$_GET[$list."_最小值"]."&".$list."_最大值=".$_GET[$list."_最大值"]."";
							$ADD_SEARCH_TEXT .= " ".$list."最小值:".$_GET[$list."_最小值"]." ".$list."最大值:".$_GET[$list."_最大值"]."";
						}
						else	if($_GET[$list."_开始时间"]!=""&&$_GET[$list."_结束时间"]!="")		{
							$ADD_SEARCH_VALUE .= "&".$list."_开始时间=".$_GET[$list."_开始时间"]."&".$list."_结束时间=".$_GET[$list."_结束时间"]."";
							$ADD_SEARCH_TEXT .= " ".$list."开始时间:".$_GET[$list."_开始时间"]." ".$list."结束时间:".$_GET[$list."_结束时间"]."";
						}
					}
					print $ADD_SEARCH_TEXT;
					//print $ADD_SEARCH_VALUE;

					print "<input type=hidden name='$KeyName' value='".$_GET['searchfield']."'>\n";
					print "<input type=hidden name='searchfield' value='".$_GET['searchfield']."'>\n";
					print "<input type=hidden name='searchvalue' value='".$_GET['searchvalue']."'>\n";
					print "<input type=hidden name='tablename' value='$tablename'>\n";
					print "<input type=hidden name='AdvanceSearch' value='$ADD_SEARCH_VALUE'>\n";
					print "</TD></TR>\n";
				}
				else	{
					/*
					print "<TR class=TableData>\n";
					print "<TD noWrap align=middle><input type=\"checkbox\" checked name=\"selectidtemp\" disabled value=\"$index\"></TD>\n";
					print "<TD  width=120 disabled>数据过滤</TD>\n";
					print "<TD  width=150 nowrap>";

					print "<select class=\"SmallSelect\" name=\"".$KeyName."\" disabled>\n";
					//print "<option value=\"\" >".$common_html['common_html']['allrecords']."</option>\n";
					print "<option value=\"\" >".$html_etc[$tablename][$list['index_name']]."[".$common_html['common_html']['allrecords']."]</option>\n";

					print "</select>\n";
					
					
					print "</TD></TR>\n";
					*/
					print "<input type=hidden name='searchfield' value='".$_GET['searchfield']."'>\n";
					print "<input type=hidden name='searchvalue' value='".$_GET['searchvalue']."'>\n";
					print "<input type=hidden name='tablename' value='$tablename'>\n";
					print "<input type=hidden name='AdvanceSearch' value='$ADD_SEARCH_VALUE'>\n";
				}

			}

			//附加组数据导出--结束
			$showlistfieldlist_array=explode(',',$showlistfieldlist);//print_R($showlistfieldlist_array);
			for($i=0;$i<sizeof($showlistfieldlist_array);$i++)				{
				$index=$showlistfieldlist_array[$i];
				$list=$columns[$index];
				print "<TR class=TableData>\n";
				print "<TD noWrap align=middle><input type=\"checkbox\" checked name=\"selectid\" value=\"$index\"></TD>\n";
				print "<TD >".$html_etc[$tablename][$list]."</TD>\n";
				print "<TD >$list</TD>\n";
				print "</TR>\n";
				$temp_function='selectid_str_init';
			}
			break;
	}

	global $returnmodel;
	$returnmodelArray = explode(',',$returnmodel);
	if($returnmodelArray[1]!="")		{
		$returnmodelURL = $returnmodelArray[1];
	}
	else	{
		$returnmodelURL = "?";
	}
	print "<tr align=\"center\" class=\"TableControl\">\n<td colspan=\"3\" nowrap>\n<div align=\"center\">

	<input type=\"button\" value=\"".$common_html['common_html']['export']."CSV\" accesskey='v' title=\"".$common_html['common_html']['accesskey'].":ALT+V\" class=\"SmallButton\" onClick=\"selectid_str_init_CSV('$mark');\">
	<input type=\"button\" value=\" ".$common_html['common_html']['export']."EXCEL \" accesskey='x' title=\"".$common_html['common_html']['accesskey'].":ALT+X\" class=\"SmallButton\" onClick=\"selectid_str_init_XLS('$mark');\">
	<input type=\"button\" accesskey='c' title=\"".$common_html['common_html']['accesskey'].":ALT+C\" value=\"".$common_html['common_html']['cancel']."\"  class=\"SmallButton\" onClick=\"location='$returnmodelURL'\"></div>\n</td></tr>\n";
	table_end();
	form_end();
	print "<BR>";
}

function export_newai_CSV($fields,$memo='')								{
	global $db,$_GET,$_POST,$html_etc,$tablename;
	$content=join("\n",$fields['value']);

	//下载时的文件名		//$fields['tablename']
	$表中文说明 = $html_etc[$tablename][$tablename];
	if($fields['FileNameAttachment']!="")	{
		$FileNameAttachment = "-".$fields['FileNameAttachment'];
	}
	else	{
		$FileNameAttachment = '';
	}//_".date("m_d")."
	if($表中文说明=="") $表中文说明 = $tablename;
	$fname = "".$表中文说明.$FileNameAttachment.$memo.".csv";
	@unlink($fname);//确实文件不存在,如果存在,则提前删除
	header("Pragma: no-cache");
	header("Cache-control: private");
	header("Content-Disposition: attachment; filename=$fname");
	header("Content-Type: text/csv; charset=UTF-8");
	header("Expires: Mon, 26 Jul 1997 05:00:00 GMT" );
	header("Last-Modified: " . date("D, d M Y H:i:s") . " GMT" );
	header("Cache-Control: post-check=0, pre-check=0", false );
	header("Content-Length: ".strlen($content));
	print $content;
	exit;
}


function export_newai_XLS($fields)					{
	global $db,$_GET,$_POST;
	global $tablename,$html_etc;
	//print_R($fields);exit;

	if(is_file("../../Framework/PHPExcelParser4/WriteExcel/class.writeexcel_workbook.inc.php"))	{
		require_once "../../Framework/PHPExcelParser4/WriteExcel/class.writeexcel_workbook.inc.php";
		require_once "../../Framework/PHPExcelParser4/WriteExcel/class.writeexcel_worksheet.inc.php";
	}
	else if(is_file("../DANDIAN/PHPExcelParser4/WriteExcel/class.writeexcel_workbook.inc.php"))	{
		require_once "../DANDIAN/PHPExcelParser4/WriteExcel/class.writeexcel_workbook.inc.php";
		require_once "../DANDIAN/PHPExcelParser4/WriteExcel/class.writeexcel_worksheet.inc.php";
	}
	else {
		require_once "../Framework/PHPExcelParser4/WriteExcel/class.writeexcel_workbook.inc.php";
		require_once "../Framework/PHPExcelParser4/WriteExcel/class.writeexcel_worksheet.inc.php";
	}

	if(!is_dir("FileCache")) mkdir("FileCache");
	//下载时的文件名		//$fields['tablename']
	$表中文说明 = $html_etc[$tablename][$tablename];
	if($fields['FileNameAttachment']!="")	{
		$FileNameAttachment = "-".$fields['FileNameAttachment'];
	}
	else	{
		$FileNameAttachment = '';
	}//_".date("m_d")."
	if($表中文说明=="") $表中文说明 = $tablename;
	$fname = "FileCache/".$表中文说明.$FileNameAttachment.".xls";
	@unlink($fname);//确实文件不存在,如果存在,则提前删除
	//print $fname;exit;
	//$fname = tempnam("/tmp", "panes.xls");
	$workbook = &new writeexcel_workbook($fname);
	
	$worksheet1 =& $workbook->addworksheet('Sheet1');
	# Frozen panes
	//$worksheet1->setInputEncoding('utf-8'); 
	$worksheet1->freeze_panes(1, 0); # 1 row

	$header =& $workbook->addformat();
	$header->set_color('white');
	$header->set_align('center');
	$header->set_align('vcenter');
	$header->set_pattern();
	$header->set_fg_color('green');

	$center =& $workbook->addformat();
	$center->set_align('center');
	$center->set_align('vcenter');
	$header->set_pattern();
	//列出字段的EXCEL列,通过此指定列宽度
	$LitterArray = explode(',','A,B,C,D,E,F,G,H,I,J,K,L,M,N,O,P,Q,R,S,T,U,V,W,X,Y,Z');
	$LeftArray = array();
	$LitterSize = sizeof($LitterArray);
	for($i=0;$i<10;$i++)					{
		if($i==0)	$Little = '';
		else		$Little = $LitterArray[$i-1];

		for($ii=0;$ii<$LitterSize;$ii++)				{
			$PartLitte = $LitterArray[$ii];
			$Left = $Little.$PartLitte;
			array_push($LeftArray,$Left);
		}
	}
	
	$FristLineArray = explode(',',$fields['value'][0]);

	//宽度值形成列表
	$TEMPVALUE = sizeof($FristLineArray);
	$LastValue = $LeftArray[$TEMPVALUE-1];
	if($fields['RowValueLenght']=='')	$fields['RowValueLenght'] = 16;
	$LENGHT_VALUE_ARRAY = $fields['RowValueLenght'];
	//print_R($LENGHT_VALUE_ARRAY);
	//$worksheet1->set_column('A', 16);
	//$worksheet1->set_column('A:A', 16);
	//$worksheet1->set_column('B:B', 20);
	for($i=0;$i<sizeof($FristLineArray);$i++)		{
		//宽度值形成列表
		$LastValue = $LeftArray[$i];
		$LENGHT_VALUE = $LENGHT_VALUE_ARRAY[$i];
		//$LENGHT_VALUE<16?$LENGHT_VALUE=16:'';
		//$LENGHT_VALUE += 2;
		//$LENGHT_VALUE<6?$LENGHT_VALUE=6:'';
		$LENGHT_VALUE>50?$LENGHT_VALUE=50:'';
		$worksheet1->set_column($LastValue.":".$LastValue, $LENGHT_VALUE);
	}
	//$worksheet1->set_row('0', 20);
	$worksheet1->set_selection('C3');
	//写标题
	for($i=0;$i<sizeof($FristLineArray);$i++)		{
		//行列内容
		$Element = $FristLineArray[$i];
		$worksheet1->write_string(0, $i, $Element, $header);
	}
	//写内容
	$总行数 =	sizeof($fields['value']);
	if($总行数>16382)  $总行数 = 16382;
	for($m=1;$m<$总行数;$m++)		{
		$worksheet1->set_row($m, 16);
		$FristLineArray = explode(',',$fields['value'][$m]);
		for($i=0;$i<sizeof($FristLineArray);$i++)		{
			$Element = $FristLineArray[$i];
			$worksheet1->write_string($m, $i, $Element, $center);
		}
	}
	$workbook->close();
	$fnameArray = explode('/',$fname);
	$PureFileName = array_pop($fnameArray);
	header("Content-Type: application/x-msexcel; charset=gb2312; name=\"$PureFileName\"");
	header("Content-Disposition: inline; filename=\"$PureFileName\"");
	
	$fh=fopen($fname, "rb");
	fpassthru($fh);
	fclose($fh);
	unlink($fname);

}


function export_newai_backup()					{
	global $db,$_GET,$_POST;
	$sql=explode(' ',$_GET['exportsql']);
	$fields=explode(',',trim($sql[1]));
	$string=join(',',array_unique($fields));

	$rs=$db->CacheExecute(150,$_GET['exportsql']);
	$array=$rs->GetArray();
		$targetarray=array();
		array_push($targetarray,$string);
	foreach($array as $list)	{
		array_push($targetarray,join(',',$list));
	}
	$content=join("\n",$targetarray);

	///*
	header("Pragma: no-cache");
	header("Cache-control: private");
	header("Content-Disposition: attachment; filename=".$_GET['tablename']."_".gmdate("Y_m_d_H_i").".csv");
	header("Content-Type: text/csv; charset=UTF-8");
	header( "Expires: Mon, 26 Jul 1997 05:00:00 GMT" );
	header( "Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT" );
	header( "Cache-Control: post-check=0, pre-check=0", false );
	header("Content-Length: ".strlen($content));
	print $content;
	exit;
}


?>