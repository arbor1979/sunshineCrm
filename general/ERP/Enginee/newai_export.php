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
		$KeyName = "˵��";
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
		//������ʾ��õ�SELECTID��ֵ
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
		//������ʾ��õ�SELECTID��ֵ
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
		if($_GET['ʱ���ֶ�'])
		{
			if(strlen($_GET['����ʱ��ADD'])==10)
			{
				$_GET['����ʱ��ADD']=$_GET['����ʱ��ADD']." 23:59:59";
			}
			print ";\r\n url+='&".$_GET['ʱ���ֶ�']."_��ʼʱ��=".$_GET['��ʼʱ��ADD']."&".$_GET['ʱ���ֶ�']."_����ʱ��=".$_GET['����ʱ��ADD']."';";
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
			print "<TD noWrap align=middle>ѡ��</TD>\n";
			print "<TD width=200>�ֶ�����</TD>\n";
			print "<TD width=200>�ֶ�����</TD>\n";
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
			print "<TD noWrap align=center width=30>ѡ��</TD>\n";
			print "<TD width=100>�ֶ�����</TD>\n";
			print "<TD width=150>�ֶ�����</TD>\n";
			print "</TR>\n";
			//���������ݵ���--��ʼ
			//print_R($group_filter_Array);
			if($group_filter!=""&&$_GET['actionadv']!="exportadv_default")					{

				//���ǿ��GET�����Ѿ����й�Ԥ����,��ô����Ԥ�������ݽ��� 2010-9-2
				$TableFieldIndex = $group_filter_Array[0];
				$KeyName = $columns[$TableFieldIndex];
				$PHP_SELF_ARRAY = explode('/',$_SERVER['PHP_SELF']);
				$FILE_SELF_NAME = array_pop($PHP_SELF_ARRAY);
				$FileDirName = array_pop($PHP_SELF_ARRAY);
				//����PGSQL���治�������ݽ���
				//print $_SESSION['LOGIN_USER_ID'];
				//���ǿ��GET�����Ѿ����й�Ԥ����,��ô����Ԥ�������ݽ��� 2010-9-2
				//&&$FileDirName=="Teacher" ֻ����TeacherĿ¼����ʹ�� 2010-9-25 ����ʹ��
				if($_GET[$KeyName]!=""){
					//$ChildTableName = $group_filter_Array[1];
					//$ChildTableFieldValueIndex = $group_filter_Array[2];
					//$ChildTableFieldNameIndex = $group_filter_Array[3];
					//print $KeyName;
					$�����ж�����Array = explode(',',$_GET[$KeyName]);
					$�����ж����� = "'".join("','",$�����ж�����Array)."'";
					$sql = "
					select $ChildTableFieldValue,$ChildTableFieldName
					from $ChildTableName
					where ( $ChildTableFieldValue in ($�����ж�����)
							or
							$ChildTableFieldName in ($�����ж�����)
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
					$ShowText = "��".$html_etc[$tablename][$KeyName]."����";
					//$ShowText = "��".$Childhtml_etc[$ChildTableName][$ChildTableFieldName]."����";
				}
				else	{
					$ShowText = "��".$html_etc[$tablename][$KeyName]."����";
				}
				print "<TR class=TableData>\n";
				print "<TD noWrap align=middle><input type=\"checkbox\" checked name=\"selectidtemp\" disabled value=\"$index\"></TD>\n";
				print "<TD  width=120 nowrap>".$ShowText."</TD>\n";
				print "<TD  width=150 nowrap>";
				//print_R($_GET);
				//print $KeyName;
				//������صĻ�����ʾΪֻ��
				if($group_filter_Array[4]=="hidden")			{
					//������صĻ�����ʾΪֻ��
					$��ʾ���� = returntablefield($ChildTableName,$ChildTableFieldValue,$_GET[$KeyName],$ChildTableFieldName);
					print "<select class=\"SmallSelect\" name=\"".$KeyName."\">\n";
					print "<option value=\"".$_GET[$KeyName]."\" >".$��ʾ����."[".$_GET[$KeyName]."]</option>\n";
					print "</select>\n";
				}
				else						{
					//��ʾ��Ϊ�б�
					print "<select class=\"SmallSelect\" name=\"".$KeyName."\" >\n";
					//print "<option value=\"\" >".$common_html['common_html']['allrecords']."</option>\n";
					print "<option value=\"\" >".$html_etc[$tablename][$list['index_name']]."[".$common_html['common_html']['allrecords']."]</option>\n";
					//2009-12-24������б���Ĺ���
					for($i=0;$i<sizeof($rs_a);$i++)	{
						if($_GET[$KeyName]==$rs_a[$i][$ChildTableFieldValue])
							$CheckedX = "selected";
						else
							$CheckedX = "";
						print "<option value=\"".$rs_a[$i][$ChildTableFieldValue]."\" $CheckedX >".$rs_a[$i][$ChildTableFieldName]."[".$rs_a[$i][$ChildTableFieldValue]."]</option>\n";
					}
					print "</select>\n";
				}


				//2009-12-24������������Ե�֧��
				print "<input type=hidden name='searchfield' value='".$_GET['searchfield']."'>\n";
				print "<input type=hidden name='searchvalue' value='".$_GET['searchvalue']."'>\n";
				print "<input type=hidden name='tablename' value='$tablename'>\n";
				print "<input type=hidden name='AdvanceSearch' value='$ADD_SEARCH_VALUE'>\n";
				print "</TD></TR>\n";
			}
			else	{
				//�߼�����ʱ���ֵ����ر���
				if($_GET['actionadv']=="exportadv_default")			{
					print "<TR class=TableData>\n";
					print "<TD noWrap align=middle><input type=\"checkbox\" checked name=\"selectidtemp\" disabled value=\"$index\"></TD>\n";
					print "<TD  width=90% colspan=2>�߼�����:\n";

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
						else	if($_GET[$list."_��Сֵ"]!=""&&$_GET[$list."_���ֵ"]!="")		{
							$ADD_SEARCH_VALUE .= "&".$list."_��Сֵ=".$_GET[$list."_��Сֵ"]."&".$list."_���ֵ=".$_GET[$list."_���ֵ"]."";
							$ADD_SEARCH_TEXT .= " ".$list."��Сֵ:".$_GET[$list."_��Сֵ"]." ".$list."���ֵ:".$_GET[$list."_���ֵ"]."";
						}
						else	if($_GET[$list."_��ʼʱ��"]!=""&&$_GET[$list."_����ʱ��"]!="")		{
							$ADD_SEARCH_VALUE .= "&".$list."_��ʼʱ��=".$_GET[$list."_��ʼʱ��"]."&".$list."_����ʱ��=".$_GET[$list."_����ʱ��"]."";
							$ADD_SEARCH_TEXT .= " ".$list."��ʼʱ��:".$_GET[$list."_��ʼʱ��"]." ".$list."����ʱ��:".$_GET[$list."_����ʱ��"]."";
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
					print "<TD  width=120 disabled>���ݹ���</TD>\n";
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

			//���������ݵ���--����
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

	//����ʱ���ļ���		//$fields['tablename']
	$������˵�� = $html_etc[$tablename][$tablename];
	if($fields['FileNameAttachment']!="")	{
		$FileNameAttachment = "-".$fields['FileNameAttachment'];
	}
	else	{
		$FileNameAttachment = '';
	}//_".date("m_d")."
	if($������˵��=="") $������˵�� = $tablename;
	$fname = "".$������˵��.$FileNameAttachment.$memo.".csv";
	@unlink($fname);//ȷʵ�ļ�������,�������,����ǰɾ��
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
	//����ʱ���ļ���		//$fields['tablename']
	$������˵�� = $html_etc[$tablename][$tablename];
	if($fields['FileNameAttachment']!="")	{
		$FileNameAttachment = "-".$fields['FileNameAttachment'];
	}
	else	{
		$FileNameAttachment = '';
	}//_".date("m_d")."
	if($������˵��=="") $������˵�� = $tablename;
	$fname = "FileCache/".$������˵��.$FileNameAttachment.".xls";
	@unlink($fname);//ȷʵ�ļ�������,�������,����ǰɾ��
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
	//�г��ֶε�EXCEL��,ͨ����ָ���п��
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

	//���ֵ�γ��б�
	$TEMPVALUE = sizeof($FristLineArray);
	$LastValue = $LeftArray[$TEMPVALUE-1];
	if($fields['RowValueLenght']=='')	$fields['RowValueLenght'] = 16;
	$LENGHT_VALUE_ARRAY = $fields['RowValueLenght'];
	//print_R($LENGHT_VALUE_ARRAY);
	//$worksheet1->set_column('A', 16);
	//$worksheet1->set_column('A:A', 16);
	//$worksheet1->set_column('B:B', 20);
	for($i=0;$i<sizeof($FristLineArray);$i++)		{
		//���ֵ�γ��б�
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
	//д����
	for($i=0;$i<sizeof($FristLineArray);$i++)		{
		//��������
		$Element = $FristLineArray[$i];
		$worksheet1->write_string(0, $i, $Element, $header);
	}
	//д����
	$������ =	sizeof($fields['value']);
	if($������>16382)  $������ = 16382;
	for($m=1;$m<$������;$m++)		{
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