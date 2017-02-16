<?php
date_default_timezone_set("Asia/Shanghai");
function newai_import($fields,$mode='table')		{
	global $common_html,$html_etc;
	global $return_sql_line,$db;
	global $columns;//print_R($columns);
	global $showlistfieldlist,$showlistfieldlist_key;
	global $foreignkey,$uniquekey,$primarykey;
	$tablename=$fields['table']['name'];
	$SQL=$fields['sql']['SQL'];
	$init=explode('_',$_GET['action']);
	$mark=$init[1];
	if($uniquekey=='') $uniquekey = $primarykey;
	//print $uniquekey;


	print "<FORM name=form1 action=\"?action=import_".$mark."_data\" method=post encType=multipart/form-data>\n";
	print "<input type=hidden name=hidden_str value=''>\n";
	print "<script >";
	print "
function temp_function()
{

	var selectid_str=\"\";
	/*
	for(i=0;i<document.all(\"selectid\").length;i++)
		{

		el=document.all(\"selectid\").item(i);
		if(el.checked)
		{  val=el.value;
         selectid_str+=val + \",\";
		}
	}*/
	form1.hidden_str.value=selectid_str;
	form1.submit();
	var sbtn=document.getElementsByName('submitbtn');
	for(i=0;i<sbtn.length;i++)
	{
		sbtn[i].value='提交中';
		sbtn[i].disabled=true;
	}
}
";
	print "</script>";
	global $tablewidth,$primarykey,$primarykey_index;
	$tablewidth=$tablewidth!=""?$tablewidth:450;
	table_begin($tablewidth);
	print_title("数据导入操作,唯一索引限制,多个表示不能同时重复",3);
	//print_R($common_html['common_html']['contentimport']);

	if($foreignkey!="")			{
		$foreignkey_array=explode(':',$foreignkey);
		$columns_parent=returntablecolumn($foreignkey_array[1]);
		print_R($columns_parent);
		print_select('选择考试名称',$columns[(string)$foreignkey_array[3]],$value,$foreignkey_array[1],$columns_parent[(string)$foreignkey_array[3]],$columns_parent[(string)$foreignkey_array[2]],$colspan=3,$columns_parent[(string)$foreignkey_array[4]]);
		print_hidden($columns[(string)$foreignkey_array[3]],'foreignkey');
	}

	print "<TR class=TableData>\n";
	print "<TD noWrap align=middle width=50>唯一索引:</TD>\n";
	print "<TD colspan=2>";
	$uniquekey_array=explode(',',$uniquekey);
	$FieldList = array();
	for($i=0;$i<sizeof($uniquekey_array);$i++)		{
		$uniquekey_KEY		=	$uniquekey_array[$i];
		if($uniquekey_KEY!="")						{
			$uniquekey_KEY_ADD	=	explode(':',$uniquekey_KEY);
			if($uniquekey_KEY_ADD[1]=="userid")			{
				$FieldList[]		=	$columns["".$uniquekey_KEY_ADD[0].""]."(自动生成)";
			}
			else if($uniquekey_KEY_ADD[1]=="username")		{
				$FieldList[]		=	$columns["".$uniquekey_KEY_ADD[0].""]."(自动生成)";
			}
			else if($uniquekey_KEY_ADD[1]=="datetime")		{
				$FieldList[]		=	$columns["".$uniquekey_KEY_ADD[0].""]."(自动生成)";
			}
			else	{
				$tablenamelang=returnsystemlang($tablename);
				$FieldList[]		=	$tablenamelang[$tablename][$columns["".$uniquekey_KEY_ADD[0].""]];
			}
		}

	}
	//print_R($uniquekey_array);
	//输出不较验主键时的选择列表
	$唯一字段显示文本		=	join(',',$FieldList);
	print $唯一字段显示文本;
	print "</TD>\n";
	print "</TR>\n";


	global $importgroup;
	if($importgroup!="")				{
		//print $importgroup;
		print_title('选择要导入的组',3);
		$importgroupArray = explode(':',$importgroup);
		$showfieldIndex = $importgroupArray[0];
		$showFieldName = $columns[$showfieldIndex];
		$showfieldTableName = $importgroupArray[1];
		$showfieldColumns = returntablecolumn($showfieldTableName);
		$showfieldIndexValue = $importgroupArray[2];
		$showfieldIndexName = $importgroupArray[3];
		$showfieldIndexValue = $showfieldColumns[$showfieldIndexName];
		$showfieldIndexName = $showfieldColumns[$showfieldIndexName];
		print_select('选择要导入的组：',$showFieldName,$value='',$showfieldTableName,$showfieldIndexValue,$showfieldIndexName,$colspan=2,$setfieldname='',$setfieldvalue='',$setfieldboolean='');
	}
	/*
	if($tablename == 'customer'){
		print_title('请您先<a style="color:red;" href="xls_template/客户信息模板.xls">下载模板</a>,编辑完成再进行导入。',3);
	}elseif($tablename == 'supply'){
		print_title('请您先<a style="color:red;" href="xls_template/供应商信息模板.xls">下载模板</a>,编辑完成再进行导入。',3);
	}elseif($tablename == 'product'){
		print_title('请您先<a style="color:red;" href="xls_template/商品信息模板.xls">下载模板</a>,编辑完成再进行导入。',3);
	}else{
		print_title('导入EXCEL格式数据文件,请您直接从导出功能模块下载导入模板',3);
	}
	*/
	print_title('导入EXCEL格式数据文件,请您直接从导出功能模块下载导入模板',3);
	print "<TR class=TableData height=50>\n";
	print "<TD noWrap align=middle >EXCEL格式文件</TD>\n";
	print "<TD colspan=2><input name='uploadfileXLS' type=file size=25 class=SmallInput></TD>\n";
	print "</TR>\n";

	//print_title('导入CSV格式数据文件',3);
	//print "<TR class=TableData height=50>\n";
	//print "<TD noWrap align=middle >MS CSV文件</TD>\n";
	//print "<TD colspan=2><input name='uploadfile' type=file size=25 class=SmallInput></TD>\n";
	//print "</TR>\n";



	print "<tr align=\"center\" class=\"TableControl\">\n<td colspan=\"3\">\n<div align=\"center\"><input type=\"button\" name='submitbtn' value=\"".$common_html['common_html']['import']."\" class=\"SmallButton\" onClick=\"temp_function();\">　　<input type=\"button\" value=\"".$common_html['common_html']['return']."\" class=\"SmallButton\" onClick=\"history.back();\"></div>\n</td></tr>\n";


	table_end();
	form_end();
	print "<BR>";
	table_begin($tablewidth);
	print_title("EXCEL格式数据正确但导入失败时,请按以下方法进行:");
	print "<TR class=TableData height=50>\n";
	print "<TD colspan=3><font color=green>
	如何过滤EXCEL里面的格式,转化为纯净的EXCEL数据格式文件:<BR>

	&nbsp;&nbsp;1 准备好原始格式数据文件<BR>
	&nbsp;&nbsp;2 新建一个EXCEL文件,即空白文件<BR>
	&nbsp;&nbsp;3 工具栏选择数据->导入外部数据->导入数据,弹出的对话框里面,选择第一步准备好的原始文件<BR>
	&nbsp;&nbsp;4 其它不要动,一切按默认的方法进行操作<BR>
	&nbsp;&nbsp;5 即可得到纯净的EXCEL数据格式文件,把这个文件进行导入即可<BR>
	&nbsp;&nbsp;注意:这种方法只用于解决,数据列数及列名正确,但软件无法识别的情况<BR>
	</font>
	\n";
	print "</TD></TR>\n";
	table_end();
	form_end();
}



function newai_import_CSV($Columns)				{
	global $_FILES,$_POST,$_GET,$db;
	global $showlistfieldlist,$showlistfieldfilter;
	global $common_html,$html_etc;
	global $return_sql_line,$db;
	global $columns;//print_R($columns);
	global $showlistfieldlist,$showlistfieldlist_key;
	global $foreignkey,$showFieldName,$tablename;
	if(is_uploaded_file($_FILES['uploadfile']['tmp_name']))			{
		$uploadfile_self=$_FILES['uploadfile']['tmp_name'];
		$uploadfile_name=$_FILES['uploadfile']['name'];
		$checkFileType = substr($uploadfile_name,-3);
		if($checkFileType!="csv")	{
			print_nouploadfile("你上传的不是CSV格式的文件!");
			exit;
		}
		if(!is_dir("FileCache")) mkdir("FileCache");
		$uploadfile_name = "FileCache/".$uploadfile_name;
		$TempFile = $uploadfile_name;
		copy($_FILES['uploadfile']['tmp_name'],$uploadfile_name);
		$file=file($TempFile);

		$first_row=trim($file[0]);
		$first_row_array=explode(',',$first_row);//导入数据中字段列表
		for($iii=0;$iii<sizeof($first_row_array);$iii++)	{
			$first_row_array[$iii] = TRIM($first_row_array[$iii]);
		}
		$first_row_array_keys=array_keys($first_row_array);
		$first_row_array_values=array_values($first_row_array);
		//列行检测
		for($i=0;$i<sizeof($first_row_array_keys);$i++)			{
			$first_row_array_new[$first_row_array_values[$i]]=$first_row_array_keys[$i];
		}
		$primarykey_index_num=$first_row_array_new[$_POST[primarykey]];

		

		//得到字段过滤信息列表
		$newstring=array();
		$showlistfieldlistArray=explode(',',$showlistfieldlist);
		$showlistfieldfilterArray=explode(',',$showlistfieldfilter);
		$ColumnsReverse = array_flip($columns);
		$showlistfieldlist_keyArrayReverse = array_flip($showlistfieldlistArray);
		//可以允许导入的列表
		for($i=0;$i<sizeof($showlistfieldlistArray);$i++)		{
			if($showlistfieldlistArray[$i]!='')		{
				$ElementTableField = $showlistfieldlistArray[$i];
				$ElementFieldName = $Columns[$ElementTableField];
				array_push($newstring,$ElementFieldName);
			}
		}
		//求得共同值
		//print_R($newstring);
		$result = array_intersect ($newstring, $first_row_array);
		//print_R($result);
		$newstring_text=join(',',$newstring);
		//print_R($newstring_text);

		page_css('数据导入');
		//table_begin(500);
		//数据行检测
		$Insert_RIGHT = 0;
		$Insert_ERROR = 0;
		$Update_RIGHT = 0;
		$Update_ERROR = 0;
		$primarykey = $_POST['primarykey'];
		for($i=1;$i<sizeof($file);$i++)			{
			$line_array=explode(',',trim($file[$i]));
			//print_R($line_array);
			$line_array_text=join("','",$line_array);
			$newline_array=array();
			//以前的SIZEOF用的是line_array变量，后变为first_row_array，用于对应一些没有发生的变化
			for($j=0;$j<sizeof($first_row_array);$j++)		{
				$primarykey_values = $line_array[$primarykey_index_num];
				$primarykey_values = addslashes($primarykey_values);
				$ColumnName=$first_row_array[$j];
				$in_array=in_array($ColumnName,$result);
				if($in_array)		{
					//过滤'"'之类的字符 -htmlentitiesUser
					//字段名称
					$Field_Insert_Name = trim($first_row_array[$j]);//字段名称
					//得到字段名称索引
					$getFieldNumberofTable = $ColumnsReverse[$Field_Insert_Name];
					//得到字段名称索引的数据排位置
					$showlistfieldlistArrayFlip = array_flip($showlistfieldlistArray);
					$getImportKeyIndex = $showlistfieldlistArrayFlip[$getFieldNumberofTable];
					//获取该字段类型如TableFilter过滤类型
					$getImportKeyFilter = $showlistfieldfilterArray[$getImportKeyIndex];
					//通过过滤信息文本找到相应的原始字段
					$getImportKeyFilterArray = explode(':',$getImportKeyFilter);
					//print "Field_Insert_Name:$Field_Insert_Name<BR>";
					//print "getFieldNumberofTable:$getFieldNumberofTable<BR>";
					//print "getImportKeyIndex:$getImportKeyIndex<BR>";
					//print "getFieldNumberofTable:$getFieldNumberofTable<BR>";
					//print "getImportKeyFilter:$getImportKeyFilter<BR>";
					//print_R($showlistfieldlistArrayFlip);print "<BR>";
					switch($getImportKeyFilterArray[0])		{
						case 'tablefilter':
							$ImportKeycolumns=returntablecolumn($getImportKeyFilterArray[1]);
							$ImportFieldCode = $ImportKeycolumns[(String)$getImportKeyFilterArray[2]];
							$ImportFieldName = $ImportKeycolumns[(String)$getImportKeyFilterArray[3]];
							$ResultFieldCode = returntablefield($getImportKeyFilterArray[1],$ImportFieldName,$line_array[$j],$ImportFieldCode);
							//print $getImportKeyFilterArray[1]."<BR>";
							//print $ImportFieldName."<BR>";
							//print $line_array[$j]."<BR>";
							//print $ImportFieldCode."<BR>";
							if($ResultFieldCode=="") $ResultFieldCode = $line_array[$j];
							break;
						default:
							$ResultFieldCode = $line_array[$j];
							break;
					}
					//用于过滤组选项的变量
					$choice_index = $first_row_array[$j];
					if($showFieldName==$choice_index)		{
						//print $ResultFieldCode = $_POST[$showFieldName];
					}
					//分析结束
					array_push($newline_array,htmlentitiesUser($ResultFieldCode));
					//当字段与主KEY相同时,不在更新表中出现
					if($first_row_array[$j]!=$primarykey)		{
						//print $primarykey;
						$update_sql[$j] = $first_row_array[$j]."='".htmlentitiesUser($ResultFieldCode)."'";
					}
				}
			}
			//print_R($update_sql);
			$update_sql_text="update $tablename set ".join(',',$update_sql)." where ".$primarykey."='$primarykey_values'";//print "<BR>";

			$insert_sql_text="insert into ".$tablename."(".join(',',$result).") values('".join("','",$newline_array)."')";//print $update_sql_text."<BR>";exit;

			$exists_sql_text="select count($primarykey) as num from $tablename where $primarykey='$primarykey_values'";//print "<BR>";

			//print $exists_sql_text;
			$rs=$db->Execute($exists_sql_text);
			$rs_a = $rs->GetArray();
			//page_css('数据导入');
			//table_begin(500);
			//print "<tr align=\"center\" class=\"TableData\">\n<td colspan=\"3\" noWrap>\n<div align=\"left\">";
			if($rs_a[0]['num']==0)		{
				if($_POST['exists']==1)		{
					$rs = $db->Execute($insert_sql_text);
					$EOF = $rs->EOF;
					if($EOF)		$Insert_RIGHT += 1;
					else			$Insert_ERROR += 1 ;
					//insert_sql_text
					//print "<font color=green>编号1".$insert_sql_text." 的数据：导入成功<BR></font>";
					//print "&nbsp;&nbsp;";
				}
				else	{
					//$Insert_Not
					//print "<font color=green>编号2".$insert_sql_text." 的数据：没有导入<BR></font>";
				}
			}
			else		{
				if($_POST['update']==1)		{
					$db->Execute($update_sql_text);
					$EOF = $rs->EOF;
					if($EOF)		$Update_RIGHT += 1;
					else			$Update_RIGHT += 1 ;
					//print "<font color=blue>编号3".$update_sql_text."<BR></font>";
				}
				else	{
					$Update_NOT += 1 ;
					//print "<font color=blue>编号4".$update_sql_text.". 的数据：没有更新<BR></font>";
				}
			}
			//print "</TD></TR>\n";
			//table_end();
		}
		//table_end();
		//导入数据结果较验
		$Insert_Text = "新增数据成功:{$Insert_RIGHT} 条 失败:{$Insert_ERROR} 条 <BR>更新数据成功:{$Update_RIGHT} 条 失败:{$Update_ERROR} 条";

		print "
				<style type='text/css'>.style1 {
				color: #FFFFFF;
				font-weight: bold;
				font-family: Arial, Helvetica, sans-serif;
				font-size: 14px;
				}
				</style>
				<BR><BR>
				<table width='450'  border='0' align='center' cellpadding='0' cellspacing='0' class='small' style='border:1px solid #006699;'>
				<tr><td height='110' align='middle' colspan=2  bgcolor='#E0F2FC'>
				<font color=red >".$common_html['common_html']['importsuccess']."<BR><BR>$Insert_Text<BR><BR><input type=button accesskey='c' name='cancel' value=' 点击返回 ' class=SmallButton onClick='history.back();' title='快捷键:ALT+c'></font>
				</td></tr><tr></table>";
		//print "<META HTTP-EQUIV=REFRESH CONTENT='$SYSTEM_SECOND;URL=?action=init_default'>\n";
		//print_infor($common_html['common_html']['importsuccess'],'trip',"location='?action=init_default'",'?action=init_default');
		@unlink($TempFile);
		exit;
	}
	else			{

		//print "ERROR!";
		print_nouploadfile();
	}
}



function newai_import_XLS($Columns)				{
	global $_FILES,$_POST,$_GET,$db;
	global $showlistfieldlist,$showlistfieldfilter,$primarykey,$primarykey_index,$uniquekey;
	global $common_html,$html_etc;
	global $return_sql_line;
	global $columns;
	global $showlistfieldlist_key;
	global $foreignkey,$showFieldName,$tablename;
	if(is_uploaded_file($_FILES['uploadfileXLS']['tmp_name'])){
		$uploadfile_self=$_FILES['uploadfileXLS']['tmp_name'];
		$uploadfile_name=$_FILES['uploadfileXLS']['name'];
		$checkFileType = substr($uploadfile_name,-3);
		if($checkFileType!="xls")	{
			print_nouploadfile("你上传的不是EXCEL格式的文件!");
			exit;
		}
		//print $checkFileType;exit;
		if(!is_dir("FileCache")) mkdir("FileCache");
		$uploadfile_name = "FileCache/".$uploadfile_name;
		copy($_FILES['uploadfileXLS']['tmp_name'],$uploadfile_name);

		/*
		if(is_file("../../Framework/PHPExcelParser4/readExcel.php"))	{
			require_once "../../Framework/PHPExcelParser4/readExcel.php";
		}
		else if(is_file("../DANDIAN/PHPExcelParser4/readExcel.php"))	{
			require_once "../DANDIAN/PHPExcelParser4/readExcel.php";
		}
		else {
			require_once "../Framework/PHPExcelParser4/readExcel.php";
		}
		$a = new ReadExcel($uploadfile_name);
		$tmp = $a->read();
		//按列读取的数据,转换为按行读取的数据
		$MainData = $tmp[0];
		*/
		if(is_file("../../Framework/Excel/reader.php"))	{
			require_once "../../Framework/Excel/reader.php";
		}
		else {
			require_once "../Framework/Excel/reader.php";
		}
		$data = new Spreadsheet_Excel_Reader();
		//Set output Encoding.
		$data->setOutputEncoding('CP936');
		$data->read($uploadfile_name);
		
		if(intval($data->sheets[0]['numRows'])==0)
		{
			print "<script language='javascript'>alert('Excel行数为零，请另存为Excel97-2003格式');window.history.back(-1);</script>";
			exit;
		}
		$ContentArray=array();
		for ($i = 1; $i <= $data->sheets[0]['numRows']; $i++) 
		{
  			//$data->sheets[0]['numCols']为Excel列数
  			$rows=$data->sheets[0]['numRows'];
  			for ($j = 1; $j <= $data->sheets[0]['numCols']; $j++) {
   			
   				$ContentArray[$i-1][$j-1]=$data->sheets[0]['cells'][$i][$j];
  			}
		}
		
		/*
		$ColumnNumber = sizeof(array_values($MainData));
		if($MainData[$ColumnNumber-1][0] == '错误信息')--$ColumnNumber;
		for($i=0;$i<$ColumnNumber;$i++)			{
			$ColumnArray = $MainData[$i];
			for($ii=0;$ii<sizeof($ColumnArray);$ii++)			{
				$ContentArray[$ii][$i] = $ColumnArray[$ii];
				
				//$ContentArray[$ii][$i] = str_replace("，",",", $ContentArray[$ii][$i]);
			}
		}
		*/
		$first_row_array=$ContentArray[0];
		$first_row_array_chinese=$first_row_array;
		
		// changchang008@gmail.com at 2012-2-7
		$sql="select fieldname,chinese,english from systemlang where tablename='".$tablename."'";
		$rs=$db->Execute($sql);
		$rs_a = $rs->GetArray();
		$fieldchinesename_to_fieldname = array();
		foreach ($rs_a as $row){
			if(in_array($row[fieldname], $columns)){
				$fieldchinesename_to_fieldname[$row[chinese]] = $row[fieldname];
			}
		}
		
		foreach ($first_row_array as $key=>$vo){
			if(isset($fieldchinesename_to_fieldname[$vo])){
				$first_row_array[$key] = $fieldchinesename_to_fieldname[$vo];
			}
		}
		
		for($iii=0;$iii<sizeof($first_row_array);$iii++)	{
			$first_row_array[$iii] = TRIM($first_row_array[$iii]);
			
			
		}

		//得到字段过滤信息列表
		$newstring=array();
		$newstring1=array();//需关联的字段
		$newstring2=array();//需过滤的字段
		$showlistfieldlistArray=explode(',',$showlistfieldlist);
		$showlistfieldfilterArray=explode(',',$showlistfieldfilter);
		//可以允许导入的列表
		for($i=0;$i<sizeof($showlistfieldlistArray);$i++)		{
			if($showlistfieldlistArray[$i]!='')		{
				$ElementTableField = $showlistfieldlistArray[$i];
				$ElementFieldName = $Columns[$ElementTableField];
				array_push($newstring,$ElementFieldName);
				
					$filterItemArray=explode(":", $showlistfieldfilterArray[$i]);
					
					if($filterItemArray[0]=="tablefilter" || $filterItemArray[0]=="tablefiltercolor" || $filterItemArray[0]=="radiofilter" || $filterItemArray[0]=="zhujima" || $filterItemArray[0]=="system_datetime")
						$newstring1[$ElementFieldName]=$showlistfieldfilterArray[$i];
					if($filterItemArray[0]=="input" && $filterItemArray[1]=="name")
						$newstring2[$ElementFieldName]=$showlistfieldfilterArray[$i];
				
			}
		}
		
		//$result = array_intersect ($newstring, $first_row_array);
		$result = array();
		foreach ($first_row_array as $row){
			if(in_array($row,$newstring)){
				$result[] = $row;
			}
		}
		if(sizeof($result)==0)
		{
			print "<script language='javascript'>alert('没有可导入的列，请检查Excel的列头');window.history.back(-1);</script>";
			exit;
		}
		
		//自动递增的主键
		if(!empty($primarykey_index))
		{
			$sql="select max($primarykey_index) as max from $tablename";
			
			$rs=$db->Execute($sql);
			$rs_a = $rs->GetArray();
			$primarykey_value= intval($rs_a[0][max]);
		}
		

		// 须要检查的唯一key
		$uniquekeyArray = explode( ',',$uniquekey);
		foreach ($uniquekeyArray as $key=>$row){
			$uniquekeyArray[$key] = $columns[$row];
		}
		
		
		//数据行检测
		$Insert_RIGHT = 0;
		$Insert_ERROR = 0;
		$is_error = false;
		$ChildTableCacheArray=array();//缓存关联到的数据
		for($i=1;$i<sizeof($ContentArray);$i++){
			$line_array=$ContentArray[$i];
		
			$line_array_text=join("','",$line_array);
			$newline_array			= array();
			//以前的SIZEOF用的是line_array变量，后变为first_row_array，用于对应一些没有发生的变化
			$uniquekey_error_sig = false;
			$uniquekey_error_info = '';
			$uniquekey_Array=array();
			for($j=0;$j<sizeof($first_row_array);$j++)		{
				
				$convertFirstRow=array_flip($first_row_array);
				//主键不能为空
				$j_prikey=-1;
				$j_prikey=$convertFirstRow[$primarykey_index];
				
				if($j_prikey>-1)
				{
					
					if(TRIM($line_array[$j_prikey])=='')
					{
						$line_array[$j_prikey]=++$primarykey_value;
						//$uniquekey_error_sig = true;
						//$is_error = true;
						//$uniquekey_error_info .= '<'.$ContentArray[0][$j_prikey].">列数据不能为空、";
						//break;
					}
				}
				//主键不能重复
				if(TRIM($line_array[$j_prikey])!='')
				{
					$exists_sql_text="select count(*) as num from $tablename where ".$primarykey_index."='".$line_array[$j_prikey]."'";
					$rs=$db->Execute($exists_sql_text);
					$rs_a = $rs->GetArray();
					if($rs_a[0][num] != 0)
					{
					
						$uniquekey_error_sig = true;
						$is_error = true;
						$uniquekey_error_info .= '<'.$primarykey_index.">主键重复";
						break;
					}
				}
				
				//索引键不能重复
				$sql_where='';
				$uniquekey_realname='';
				foreach ($uniquekeyArray as $key=>$value)
				{
					if($value!='')
					{
						$j_prikey=$convertFirstRow[$value];
						$sql_where.=" and $value ='".$line_array[$j_prikey]."'";
						$uniquekey_realname.=$ContentArray[0][$j_prikey].",";
					}
				}
				if($sql_where!='')
				{
					
					$exists_sql_text="select count(*) as num from $tablename where 1=1".$sql_where;
					$rs=$db->Execute($exists_sql_text);
					$rs_a = $rs->GetArray();
					if($rs_a[0][num] != 0)
					{
					
						$uniquekey_error_sig = true;
						$is_error = true;
						$uniquekey_error_info .= '<'.$uniquekey_realname.">列数据不能和数据库中的数据重复";
						break;
					}
				}
				
				//对每格数据进行处理
				$ColumnName=$first_row_array[$j];
				$in_array=in_array($ColumnName,$result);
				if($in_array){
					
					if(array_key_exists($ColumnName, $newstring1))
					{
						
						$ChildTableArray=explode(":", $newstring1[$ColumnName]);
						if($ChildTableArray[0]=='zhujima')
						{
							 $srcFieldName=$Columns[$ChildTableArray[1]];
							 $key = array_search($srcFieldName,$first_row_array); 
							 $line_array[$j]=汉字转拼音首字母($line_array[$key]);
						}
						else if($ChildTableArray[0]=='system_datetime')
						{
							
							if($line_array[$j]=='')	 
								$line_array[$j]=date("Y-m-d H:i:s");
							else
							{
								if(strtotime($line_array[$j])==-1)
									$line_array[$j]=date("Y-m-d H:i:s");
							}	
						}
						else 
						{
							
							$ChildTableName=$ChildTableArray[1];
							
							if($ChildTableCacheArray[$ChildTableName][$line_array[$j]]=='' && $line_array[$j]!='')
							{
								$ChildColumns=returntablecolumn($ChildTableName);
								$ChildTableFieldValue = $ChildColumns[$ChildTableArray[2]];
								$ChildTableFieldName = $ChildColumns[$ChildTableArray[3]];
								$realvalue=returntablefield($ChildTableName, $ChildTableFieldName, $line_array[$j], $ChildTableFieldValue);
								if($realvalue=='')
								{
									$uniquekey_error_sig = true;
									$is_error = true;
									$uniquekey_error_info .= '<'.$first_row_array_chinese[$j].">列在关联表".$ChildTableName."中找不到对应的数据";
									break;
								}
								$ChildTableCacheArray[$ChildTableName][$line_array[$j]]=$realvalue;
								
								
							}
							else 
							{
								
								$realvalue=$ChildTableCacheArray[$ChildTableName][$line_array[$j]];
								
							}
							$line_array[$j]=$realvalue;
							
						}
					}
					
					if(array_key_exists($ColumnName, $newstring2))
					{
						$line_array[$j]=str_replace("\r","", $line_array[$j]);
						$line_array[$j]=str_replace("\n","",$line_array[$j]);
						$line_array[$j]=str_replace("'","", $line_array[$j]);
						//$line_array[$j]=str_replace("\"","",$line_array[$j]);
						$line_array[$j]=str_replace("\\","", $line_array[$j]);
						$line_array[$j]=str_replace("/","", $line_array[$j]);
						$line_array[$j]=str_replace(",","", $line_array[$j]);
						$line_array[$j]=str_replace("#","", $line_array[$j]);
					}
					
					/*
					if(function_exists('FK_'.$tablename.'_'.$ColumnName)){
						$line_array[$j] = call_user_func('FK_'.$tablename.'_'.$ColumnName,$line_array[$j]);
					}
					*/
					$ResultFieldCode = $line_array[$j];
					
					array_push($newline_array,htmlentitiesUser($ResultFieldCode));
				}
			}
			
			
			//分析结束
			if($uniquekey_error_sig){
				$ContentArray[$i][FK_error_info] = $uniquekey_error_info;
				$Insert_ERROR += 1;
			}else{
				$result_add='';
				if(!empty($primarykey_index) && !in_array($primarykey_index,$result)){
					
					$newline_array[] = ++$primarykey_value;
					$result_add =','.$primarykey_index;
				}
				if($_GET['foreignkey']!='' && $_GET['foreignvalue']!='')
				
				{
					$newline_array[] = $_GET['foreignvalue'];
					$result_add.=','.$_GET['foreignkey'];
				}
				$insert_sql_text="insert into ".$tablename."(".join(',',$result).$result_add.") values('".join("','",$newline_array)."')";
				//exit($insert_sql_text);
				$rs = $db->Execute($insert_sql_text);
				
				if($rs->EOF)
					$Insert_RIGHT += 1;
				else
				{
					$Insert_ERROR += 1;
					$ContentArray[$i][FK_error_info]=$insert_sql_text;
				}
			}
		}

		

		if($is_error){
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
			$fname = "FileCache/导入失败记录.xls";
			@unlink($fname);
			$workbook = &new writeexcel_workbook($fname);
			$worksheet1 =& $workbook->addworksheet('Sheet1');
			# Frozen panes
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

			//宽度值形成列表
			$title_row_array = $ContentArray[0];
			$title_row_array[] = '错误信息';
			$TEMPVALUE = sizeof($title_row_array);
			$LastValue = $LeftArray[$TEMPVALUE-1];
			for($i=0;$i<sizeof($title_row_array);$i++)		{
				//宽度值形成列表
				$LastValue = $LeftArray[$i];
				$LENGHT_VALUE = strlen($title_row_array[$i]);
				$LENGHT_VALUE>50?$LENGHT_VALUE=50:'';
				$worksheet1->set_column($LastValue.":".$LastValue, $LENGHT_VALUE);
			}

			//写标题
			for($i=0;$i<sizeof($title_row_array);$i++)		{
				//行列内容
				$Element = $title_row_array[$i];
				$worksheet1->write_string(0, $i, $Element, $header);
			}
			//写内容
			$m=0;
			foreach($ContentArray as $vo){
				if(!empty($vo['FK_error_info'])){
					$i = 0;
					foreach ($vo as $row){
						$worksheet1->write_string($m+1, $i, $row, $center);
						$i++;
					}
					++$m;
				}
			}
			$workbook->close();
			$down_error_file = "<a href='./FileCache/导入失败记录.xls'>请点击此处下载导入错误的记录，修改正确后重新导入！</a>";
		}

		page_css('数据导入');
		$Insert_Text = "新增数据成功:{$Insert_RIGHT} 条 失败:{$Insert_ERROR} 条";
		//返回值链接判断,如果是回到首页,则直接用链接,否则则直接返回
		global $returnmodel;
		
		if($returnmodel=="import_default")		{
			$returnmodel_TEXT = "history.back();";
		}
		else	{
			$returnmodel_TEXT = "location='?action=$returnmodel'";
		}
  
		print "
				<style type='text/css'>.style1 {
				color: #FFFFFF;
				font-weight: bold;
				font-family: Arial, Helvetica, sans-serif;
				font-size: 14px;
				}
				</style>
				<BR><BR>
				<table width='450'  border='0' align='center' cellpadding='0' cellspacing='0' class='small' style='border:1px solid #006699;'>
				<tr><td height='110' align='middle' colspan=2  bgcolor='#E0F2FC'>
				<font color=red >".$common_html['common_html']['importsuccess']."<BR><BR>$Insert_Text<BR><BR>$down_error_file<BR><BR><input type=button accesskey='c' name='cancel' value=' 点击返回 ' class=SmallButton onClick=\"$returnmodel_TEXT\" title='快捷键:ALT+c'></font>
				</td></tr></table>";
		if(function_exists("recallfunc"))
		{
		    recallfunc($db);
		}
		exit;
        unlink($uploadfile_name);
	}else{
		print_nouploadfile();
	}
}
/*
function FK_supply_calling($value){
	global $db;
	$sql="select ROWID FROM unitprop where name='".$value."'";
	$rs=$db->Execute($sql);
	$rs_a = $rs->GetArray();
	if(empty($rs_a)){
		$sql="select MAX(ROWID) as ROWID_max FROM unitprop";
		$rs=$db->Execute($sql);
		$rs_a = $rs->GetArray();
		$sql="insert into unitprop (ROWID,name,user_id) values('".++$rs_a[0][ROWID_max]."','".$value."','".$_SESSION[LOGIN_USER_ID]."')";
		$rs = $db->Execute($sql);
		return $rs_a[0][ROWID_max];
	}else{
		return $rs_a[0][ROWID];
	}
}

function FK_supply_linkman($value){
	global $db;
	$sql="select ROWID FROM supplylever where name='".$value."'";
	$rs=$db->Execute($sql);
	$rs_a = $rs->GetArray();
	if(empty($rs_a)){
		$sql="select MAX(ROWID) as ROWID_max FROM supplylever";
		$rs=$db->Execute($sql);
		$rs_a = $rs->GetArray();
		$sql="insert into supplylever (ROWID,name,user_id) values('".++$rs_a[0][ROWID_max]."','".$value."','".$_SESSION[LOGIN_USER_ID]."')";
		$rs = $db->Execute($sql);
		return $rs_a[0][ROWID_max];
	}else{
		return $rs_a[0][ROWID];
	}
}

function FK_supply_user_id($value){
	return $_SESSION[LOGIN_USER_ID];
}

function FK_supply_sysuser($value){
	return $_SESSION[LOGIN_USER_ID];
}

function FK_supply_startdate($value){
	return date('Y-m-d H:m:s');
}

//function FK_supply_sysuser($value){
//	global $db;
//	$sql="select USER_ID FROM user where USER_NAME='".$value."'";
//	$rs=$db->Execute($sql);
//	$rs_a = $rs->GetArray();
//	if(empty($rs_a)){
//		return '';
//	}else{
//		return $rs_a[0][USER_ID];
//	}
//}

function FK_supplylinkman_supplyid($value){
	global $db;
	$sql="select ROWID FROM supply where supplyname='".$value."'";
	$rs=$db->Execute($sql);
	$rs_a = $rs->GetArray();
	if(empty($rs_a)){
		return '';
	}else{
		return $rs_a[0][ROWID];
	}
}

function FK_supplylinkman_gender($value){
	return $value=='男'?1:0;
}

function FK_linkman_gender($value){
	return $value=='男'?1:0;
}

//function FK_supplylinkman_user_id($value){
//	global $db;
//	$sql="select USER_ID FROM user where USER_NAME='".$value."'";
//	$rs=$db->Execute($sql);
//	$rs_a = $rs->GetArray();
//	if(empty($rs_a)){
//		return '';
//	}else{
//		return $rs_a[0][USER_ID];
//	}
//}
function FK_supplylinkman_user_id($value){
	return $_SESSION[LOGIN_USER_ID];
}

function FK_customer_enterstype($value){
	global $db;
	$sql="select ROWID FROM unitprop where name='".$value."'";
	$rs=$db->Execute($sql);
	$rs_a = $rs->GetArray();
	if(empty($rs_a)){
		$sql="select MAX(ROWID) as ROWID_max FROM unitprop";
		$rs=$db->Execute($sql);
		$rs_a = $rs->GetArray();
		$sql="insert into unitprop (ROWID,name,user_id) values('".++$rs_a[0][ROWID_max]."','".$value."','".$_SESSION[LOGIN_USER_ID]."')";
		$rs = $db->Execute($sql);
		return $rs_a[0][ROWID_max];
	}else{
		return $rs_a[0][ROWID];
	}
}

function FK_customer_datascope($value){
	return '1';
}

function FK_customer_createdate($value){
	return date('Y-m-d H:m:s');
}

function FK_customer_state($value){
	global $db;
	$sql="select ROWID FROM customerlever where name='".$value."'";
	$rs=$db->Execute($sql);
	$rs_a = $rs->GetArray();
	if(empty($rs_a)){
		$sql="select MAX(ROWID) as ROWID_max FROM customerlever";
		$rs=$db->Execute($sql);
		$rs_a = $rs->GetArray();
		$sql="insert into customerlever (ROWID,name,user_id) values('".++$rs_a[0][ROWID_max]."','".$value."','".$_SESSION[LOGIN_USER_ID]."')";
		$rs = $db->Execute($sql);
		return $rs_a[0][ROWID_max];
	}else{
		return $rs_a[0][ROWID];
	}
}

function FK_customer_style($value){
	global $db;
	$sql="select ROWID FROM customerarea where name='".$value."'";
	$rs=$db->Execute($sql);
	$rs_a = $rs->GetArray();
	if(empty($rs_a)){
		$sql="select MAX(ROWID) as ROWID_max FROM customerarea";
		$rs=$db->Execute($sql);
		$rs_a = $rs->GetArray();
		$sql="insert into customerarea (ROWID,name,user_id) values('".++$rs_a[0][ROWID_max]."','".$value."','".$_SESSION[LOGIN_USER_ID]."')";
		$rs = $db->Execute($sql);
		return $rs_a[0][ROWID_max];
	}else{
		return $rs_a[0][ROWID];
	}
}

function FK_customer_sysuser($value){
	global $db;
	$sql="select USER_ID FROM user where USER_NAME='".$value."'";
	$rs=$db->Execute($sql);
	$rs_a = $rs->GetArray();
	if(empty($rs_a)){
		return $_SESSION[LOGIN_USER_ID];
	}else{
		return $rs_a[0][USER_ID];
	}
}

function FK_customer_origin($value){
	global $db;
	$sql="select ROWID FROM customerorigin where name='".$value."'";
	$rs=$db->Execute($sql);
	$rs_a = $rs->GetArray();
	if(empty($rs_a)){
		$sql="select MAX(ROWID) as ROWID_max FROM customerorigin";
		$rs=$db->Execute($sql);
		$rs_a = $rs->GetArray();
		$sql="insert into customerorigin (ROWID,name,user_id) values('".++$rs_a[0][ROWID_max]."','".$value."','".$_SESSION[LOGIN_USER_ID]."')";
		$rs = $db->Execute($sql);
		return $rs_a[0][ROWID_max];
	}else{
		return $rs_a[0][ROWID];
	}
}


function FK_customer_salemode($value){
	global $db;
	$sql="select ROWID FROM salemode where name='".$value."'";
	$rs=$db->Execute($sql);
	$rs_a = $rs->GetArray();
	if(empty($rs_a)){
		$sql="select MAX(ROWID) as ROWID_max FROM salemode";
		$rs=$db->Execute($sql);
		$rs_a = $rs->GetArray();
		$sql="insert into salemode (ROWID,name,user_id) values('".++$rs_a[0][ROWID_max]."','".$value."','".$_SESSION[LOGIN_USER_ID]."')";
		$rs = $db->Execute($sql);
		return $rs_a[0][ROWID_max];
	}else{
		return $rs_a[0][ROWID];
	}
}


function FK_customer_property($value){
	global $db;
	$sql="select ROWID FROM property where name='".$value."'";
	$rs=$db->Execute($sql);
	$rs_a = $rs->GetArray();
	if(empty($rs_a)){
		$sql="select MAX(ROWID) as ROWID_max FROM property";
		$rs=$db->Execute($sql);
		$rs_a = $rs->GetArray();
		$sql="insert into property (ROWID,name,user_id) values('".++$rs_a[0][ROWID_max]."','".$value."','".$_SESSION[LOGIN_USER_ID]."')";
		$rs = $db->Execute($sql);
		return $rs_a[0][ROWID_max];
	}else{
		return $rs_a[0][ROWID];
	}
}

//function FK_customer_datascope($value){
//	global $db;
//	$sql="select id FROM customerbelong where name='".$value."'";
//	$rs=$db->Execute($sql);
//	$rs_a = $rs->GetArray();
//	if(empty($rs_a)){
//		$sql="select MAX(id) as id_max FROM customerbelong";
//		$rs=$db->Execute($sql);
//		$rs_a = $rs->GetArray();
//		$sql="insert into customerbelong (id,name) values('".++$rs_a[0][id_max]."','".$value."')";
//		$rs = $db->Execute($sql);
//		return $rs_a[0][id_max];
//	}else{
//		return $rs_a[0][id];
//	}
//}

function FK_linkman_customerid($value){
	global $db;
	$sql="select ROWID FROM customer where supplyname='".$value."'";
	$rs=$db->Execute($sql);
	$rs_a = $rs->GetArray();
	if(empty($rs_a)){
		return '';
	}else{
		return $rs_a[0][ROWID];
	}
}

function FK_product_producttype($value){
	global $db;
	$sql="select ROWID FROM producttype where name='".$value."'";
	$rs=$db->Execute($sql);
	$rs_a = $rs->GetArray();
	if(empty($rs_a)){
		$sql="select MAX(ROWID) as ROWID_max FROM producttype";
		$rs=$db->Execute($sql);
		$rs_a = $rs->GetArray();
		$sql="insert into producttype (ROWID,name,user_id) values('".++$rs_a[0][ROWID_max]."','".$value."','".$_SESSION[LOGIN_USER_ID]."')";
		$rs = $db->Execute($sql);
		return $rs_a[0][ROWID_max];
	}else{
		return $rs_a[0][ROWID];
	}
}
*/
function FK_product_productcn($value){
	return 汉字转拼音($value);
}

//function FK_product_user_flag($value){
//	global $db;
//	$sql="select id FROM edu_boolean where name='".$value."'";
//	$rs=$db->Execute($sql);
//	$rs_a = $rs->GetArray();
//	if(empty($rs_a)){
//		$sql="select MAX(id) as id_max FROM customerbelong";
//		$rs=$db->Execute($sql);
//		$rs_a = $rs->GetArray();
//		$sql="insert into customerbelong (id,name) values('".++$rs_a[0][id_max]."','".$value."')";
//		$rs = $db->Execute($sql);
//		return $rs_a[0][id_max];
//	}else{
//		return $rs_a[0][id];
//	}
//}


//EXCEL数据过滤区
function newai_import_FilterXLS()				{
	global $_FILES,$_POST,$_GET,$db;
	global $showlistfieldlist,$showlistfieldfilter;
	global $common_html,$html_etc;
	global $return_sql_line,$db;
	global $columns;//print_R($columns);
	global $showlistfieldlist,$showlistfieldlist_key;
	global $foreignkey,$showFieldName,$tablename;
	if(is_uploaded_file($_FILES['uploadfileXLS']['tmp_name']))			{
		$uploadfile_self=$_FILES['uploadfileXLS']['tmp_name'];
		$uploadfile_name=$_FILES['uploadfileXLS']['name'];
		$checkFileType = substr($uploadfile_name,-3);
		if($checkFileType!="xls")	{
			print_nouploadfile("你上传的不是EXCEL格式的文件!");
			exit;
		}
		//print $checkFileType;exit;
		if(!is_dir("FileCache")) mkdir("FileCache");
		$uploadfile_name = "FileCache/".$uploadfile_name;
		copy($_FILES['uploadfileXLS']['tmp_name'],$uploadfile_name);

		if(is_file("../../Framework/PHPExcelParser4/readExcel.php"))	{
			require_once "../../Framework/PHPExcelParser4/readExcel.php";
		}
		else	{
			require_once "../Framework/PHPExcelParser4/readExcel.php";
			require_once "../Framework/PHPExcelParser4/readExcel.php";
		}
		$a = new ReadExcel($uploadfile_name);
		$tmp = $a->read();

		//按列读取的数据,转换为按行读取的数据
		$MainData = $tmp[0];
		$ColumnNumber = sizeof(array_values($MainData));
		for($i=0;$i<$ColumnNumber;$i++)			{
			$ColumnArray = $MainData[$i];
			//print_R($ColumnArray);
			for($ii=0;$ii<sizeof($ColumnArray);$ii++)			{
				$ContentText[$ii][$i] = $ColumnArray[$ii];
			}
		}
		//重新生成文本
		$ColumnNumber = sizeof(array_keys($ContentText));
		for($i=0;$i<$ColumnNumber;$i++)			{
			$ContentArray = $ContentText[$i];
			$ContentTextArray[] = join(',',$ContentArray);
			//print_R($ContentArray);
		}

		//print_r($ContentTextArray);
		//exit;

		//数据对接区
		$file = $ContentTextArray;

	}
	return $file;
}


function newai_import_FilterCSV()				{
	global $_FILES,$_POST,$_GET,$db;
	global $showlistfieldlist,$showlistfieldfilter;
	global $common_html,$html_etc;
	global $return_sql_line,$db;
	global $columns;//print_R($columns);
	global $showlistfieldlist,$showlistfieldlist_key;
	global $foreignkey,$showFieldName,$tablename;
	if(is_uploaded_file($_FILES['uploadfile']['tmp_name']))			{
		$uploadfile_self=$_FILES['uploadfile']['tmp_name'];
		$uploadfile_name=$_FILES['uploadfile']['name'];
		$checkFileType = substr($uploadfile_name,-3);
		if($checkFileType!="csv")	{
			print_nouploadfile("你上传的不是CSV格式的文件!");
			exit;
		}
		if(!is_dir("FileCache")) mkdir("FileCache");
		$uploadfile_name = "FileCache/".$uploadfile_name;
		$TempFile = $uploadfile_name;
		copy($_FILES['uploadfile']['tmp_name'],$uploadfile_name);
		$file=file($TempFile);
	}
	return $file;
}









function system_CheckIdNum($body,$ShortDate='')		{
	$Length = strlen($body);
	//print $NewID;

	//411324830719425
	switch($Length)	{
		case '15':
			$ShortDateBody = substr($body,6,6);
			if($ShortDate=="")					{
				$Year = substr($ShortDate,0,2);
				if($Year<50)	{	$Year = "20".$Year; $ShortDate = "20".$ShortDate;	}
				else			{	$Year = "19".$Year; $ShortDate = "19".$ShortDate;	}

				$returnText = "时间格式不正确<BR>";

			}
			else	{
				$ShortDate = system_checkBirthday($ShortDate);
				$returnText = "身份证号出生日期和输入的出生日期格式不对应<BR>";
			}
			$Year = substr($ShortDateBody,0,4);
			$Month = substr($ShortDateBody,4,2);
			$Day = substr($ShortDateBody,6,2);

			$Datetime = date("Ymd",mktime(1,1,1,$Month,$Day,$Year));
			//print $Month;
			//print $Year;
			if($ShortDate!=$Datetime)	{
				return $returnText;
			}
			break;
		case '18':
			$ShortDateBody = substr($body,6,8);
			if($ShortDate=="")					{
				$returnText = "时间格式不正确<BR>";
			}
			else	{
				$ShortDate = system_checkBirthday($ShortDate);
				$returnText = "身份证号出生日期和输入的出生日期格式不对应<BR>";
			}
			$Year = substr($ShortDateBody,0,4);
			$Month = substr($ShortDateBody,4,2);
			$Day = substr($ShortDateBody,6,2);
			$Datetime = date("Ymd",mktime(1,1,1,$Month,$Day,$Year));
			//print $ShortDate."<BR>";
			//print $Datetime."<BR>";
			if($ShortDate!=$Datetime)	{
				return $returnText;
			}
			break;
		default:
			return "身份证号格式不正确";
			break;
	}
	return '格式正确';
};


function system_checkBirthday($Day)		{
	$DayArray = explode('-',$Day);
	$Year = $DayArray[0];
	$Month = $DayArray[1];
	$Day = $DayArray[2];
	$Datetime = date("Ymd",mktime(1,1,1,$Month,$Day,$Year));
	return $Datetime;
}

?>