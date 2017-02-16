<?php
/******************************************************************************
 *@系统项目：Sunshine Anywhere Application Platform(SAAP)1.2
 *@函数说明：实现了报表的单元显示部分，初期实现了单个单元显示，
			 后加入模糊搜索显示部分，接受外部SQL语句调用。
 *@函数作者：王纪云
 *@建立日期：2005-10-16
 *@更新日期：2005-10-26
 *@状态说明：已经过测试
 */
function newaiReport($fields,$list,$mode)		{
global $html_etc,$tablename,$common_html,$custom_type;
global $db,$return_sql_line,$columns;
global $_POST,$_GET,$returnmodel,$primarykey_index;
global $action_submit,$merge,$form_attribute;

//列表及数组转化区
global $showlistfieldlist,$showlistfieldfilter;
$showlistfieldlistArray=explode(',',$showlistfieldlist);
$showlistfieldfilterArray=explode(',',$showlistfieldfilter);

//SQL语句初始化区
$fields['other']['title']=$common_html['common_html'][$mode];
$_GET[$primarykey_index]=$list;
$return_sql_line=return_sql_line($fields);
$SQL=$return_sql_line['select_sql'];
//print $SQL;
//多项数据搜索部分　如果定义了外部SQL语句，即结果集为多数据时采用外部SQL语句
global $NEWAI_REPORT_SEARCH_SYSTEM;
if(strlen($NEWAI_REPORT_SEARCH_SYSTEM)>10&&$mode=="Multiple")			{
	$SQL=$NEWAI_REPORT_SEARCH_SYSTEM;
}

//定义要显示的结果集，默认为30个结果集
global $totalnumber;
$totalnumber==""?$totalnumber=30:'';

//执行SQL语言部分
$result=$db->CacheSelectLimit(15,$SQL,$totalnumber,0);
$rs_array=$result->GetArray();

//数据显示区，其含数据过滤部分
for($h=0;$h<sizeof($rs_array);$h++)				{
$ReportData=$rs_array[$h];
//数据过滤区 - Begin #################################################
for($f=0;$f<sizeof($showlistfieldlistArray);$f++)		{
	$filterIndex = $showlistfieldlistArray[$f];//索引列表值
	$filterType = $showlistfieldfilterArray[$f];//过滤列表值
	$filterName = $columns[$filterIndex];//列表名称
	$TypeNameFilterArray = explode(':',$filterType);//对应的过滤数组
	switch($TypeNameFilterArray[0])		{
		case 'input':
			break;
		case 'boolean':
			$ReportData[$filterName] = returnboolean($ReportData[$filterName]);
			break;
		case 'tablefilter':
			$filterTableName = $TypeNameFilterArray[1];
			$filterTableColumns = returntablecolumn($filterTableName);
			$filterTableFieldID = $filterTableColumns[(String)$TypeNameFilterArray[2]];
			$filterTableFieldName = $filterTableColumns[(String)$TypeNameFilterArray[3]];
			$filterResultText = returntablefield($filterTableName,$filterTableFieldID,$ReportData[$filterName],$filterTableFieldName);
			$ReportData[$filterName] = $filterResultText;
			break;
		case 'userdefine':
			    $filtervalue=$fields['value'][$counter][$list_index];
				$functionName = $TypeNameFilterArray[1];
				$fileName = $functionName.".php";
				$fileName0 = "userdefine/$fileName";
				$fileName = "../../Enginee/userdefine/$fileName";
				if(file_exists($fileName0))		{
					require_once($fileName0);
					$functionName = $functionName."_Value";
					if(function_exists($functionName))	{
						$ReportData[$filterName] = $functionName($fields['value'][$counter][$list_index],$fields,$counter);
					}
				}
				else if(file_exists($fileName))		{
					require_once($fileName);
					$functionName = $functionName."_Value";
					if(function_exists($functionName))	{
						$ReportData[$filterName] = $functionName($fields['value'][$counter][$list_index],$fields,$counter);
					}
					else	{
						print "函数名称[$functionName]不存在！";
					}
				}
				else	{
					print "没有相应文件,文件名：$fileName";
				}
				break;
	}
}
//数据过滤区 - End ##################################################
print "<BR>";
table_begin("80%");
print "<TR class=TableHeader>";
print "<TD noWrap colspan=4>".$html_etc[$tablename][$tablename].$common_html['common_html']['report']."&nbsp;</TD>";
print "</TR>";
$Counter = 0;
for($i=0;$i<sizeof($showlistfieldlistArray);$i+=2)		{
		$fieldName1=(string)$columns[(String)$showlistfieldlistArray[$i]];	$k=$i+1;
		$fieldName2=(string)$columns[(String)$showlistfieldlistArray[$k]];
		print "<TR class=TableData>";
		print "<TD noWrap width=15%>".$html_etc[$tablename][$fieldName1]."&nbsp;</TD>";
		print "<TD width=35%>".$ReportData[$fieldName1]."&nbsp;</TD>";
		print "<TD noWrap width=15%>".$html_etc[$tablename][$fieldName2]."&nbsp;</TD>";
		print "<TD width=35%>".$ReportData[$fieldName2]."&nbsp;</TD>";
		print "</TR>";
}
table_end();
}//end of rs_array
//##############################################################################
//实现子目录列表
global $child_tablename,$child_showlistfieldlist;
global $child_partent,$child_showlistfieldfilter;
//子目录列表开始
if($child_tablename!=""&&$child_showlistfieldlist!="")				{
$child_columns = returntablecolumn($child_tablename);
$child_html_etc=returnsystemlang($child_tablename);
table_begin("80%");
print "<TR class=TableHeader>";
print "<TD noWrap width=100% colspan=32>".$child_html_etc[$child_tablename]["list".$child_tablename]."&nbsp;</td>";
print "</TR>";
print "<TR class=TableHeader>";
$child_showlistfieldlist_Array = explode(",",$child_showlistfieldlist);
$child_showlistfieldfilter_Array = explode(",",$child_showlistfieldfilter);
for($i=0;$i<sizeof($child_showlistfieldlist_Array);$i++)		{
	$child_index = $child_showlistfieldlist_Array[$i];
	$indexName = $child_columns[$child_index];
	print "<TD noWrap>".$child_html_etc[$child_tablename][$indexName]."&nbsp;</td>";
}
print "</TR>";

//子表与父表关联部分
$child_partent_Array = explode(":",$child_partent);
$sql = "select * from $child_tablename where ".$child_columns[(String)$child_partent_Array[0]]."='".$list."'";
$rs = $db->CacheExecute(150,$sql);
$rs_a = $rs->GetArray();
for($i=0;$i<sizeof($rs_a);$i++)		{
print "<TR class=TableData>";
	for($j=0;$j<sizeof($child_showlistfieldlist_Array);$j++)		{
		$child_index = $child_showlistfieldlist_Array[$j];
		$indexName = $child_columns[$child_index];
		$ChildValue = $rs_a[$i][$indexName];
		$filterType = $child_showlistfieldfilter_Array[$j];
		$TypeNameFilterArray = explode(":",$filterType);
		switch($TypeNameFilterArray[0])		{
		case 'input':
			break;
		case 'boolean':
			$ChildValue = returnboolean($ChildValue);
			break;
		case 'tablefilter':
			$filterTableName = $TypeNameFilterArray[1];
			$filterTableColumns = returntablecolumn($filterTableName);
			$filterTableFieldID = $filterTableColumns[(String)$TypeNameFilterArray[2]];
			$filterTableFieldName = $filterTableColumns[(String)$TypeNameFilterArray[3]];
			$filterResultText = returntablefield($filterTableName,$filterTableFieldID,$ChildValue,$filterTableFieldName);
			$ChildValue = $filterResultText;
			break;
		}
		print "<TD noWrap>".$ChildValue."&nbsp;</td>";
	}
print "</TR>";
}
UserDefineFunction($list);
table_end();
print "<BR>";
print "<hr width=\"80%\" height=\"1\" align=\"$align\" color=\"white\">";
print "<BR>";
}//子目录列表结束
//##############################################################################
}

/******************************************************************************
 *@系统项目：Sunshine Anywhere Application Platform(SAAP)1.2
 *@函数说明：实现了报表搜索部分的HTML显示，主要支持两种数据类型INPUT和REPORTDATE。
 *@函数作者：王纪云
 *@建立日期：2005-10-16
 *@更新日期：2005-10-26
 *@状态说明：已经过测试
 */
function newaiReportSearch($fields,$list)		{
global $html_etc,$tablename,$common_html;
global $db,$return_sql_line,$columns;
global $_POST,$_GET,$returnmodel,$primarykey_index;
global $action_submit,$merge,$form_attribute;
global $showlistfieldlistSearch,$showlistfieldfilterSearch,$showlistfieldfilter2Search;
global $totalnumber;
$totalnumber==""?$totalnumber=30:'';
$showlistfieldlistArray=explode(',',$showlistfieldlistSearch);
$showlistfieldfilterArray=explode(',',$showlistfieldfilterSearch);
print_date_js();
form_begin($fields['form']['name'],"action",'GET');
table_begin("450");
global $tabletitle;
print_hidden($_GET['action']."_data","action");
print_title($html_etc[$tablename][$tabletitle]);
//print_title("<font color=green>".$common_html['common_html']['totalNumber'].":".$totalnumber."</font>");
print_title($common_html['common_html']['totalNumber'].":".$totalnumber);
for($i=0;$i<sizeof($showlistfieldlistArray);$i++)		{
	$fieldIndex = $showlistfieldlistArray[$i];
	$fieldName  = $columns[$fieldIndex];
	$fieldText  = $html_etc[$tablename][$fieldName];
	$mode = $showlistfieldfilterArray[$i];
	switch($mode)		{
		case '':
			break;
		case 'input':
			print_tr($fieldText.":",$fieldName,'',$fields['other']['inputsize'],$fields['other']['inputcols'],$fields['other']['class'],$notnulltext,'text','',$i+1);
			break;
		case 'date':
			print_report_date($fieldText.":",$fieldName,'',$fields['other']['inputsize'],$fields['other']['inputcols'],$fields['other']['class'],$notnulltext,'text','',$i+1);
			break;
	}
}
print_submit($common_html['common_html']['reportsearch'],3,"");
print "<TR><TD class=TableControl noWrap align=middle  colspan=\"3\">\n";
print "<div align=\"center\">\n<INPUT class=SmallButton title=".$common_html['common_html']['reportsearch']." type=submit value=\"".$common_html['common_html']['reportsearch']."\" name=button>\n　";
print "</TD></TR>\n";
table_end();
form_end();
}
?>