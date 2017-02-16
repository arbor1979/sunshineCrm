<?php
//2009-12-27 增加对高级搜索的支持
function newai_search($fields)			{
	global $common_html,$html_etc;
	global $return_sql_line,$db;
	global $action_add,$action_model;
	global $_POST,$_GET,$ROWS_PAGE;
	global $file_ini,$columns;
	global $SYSTEM_ADD_SQL;
	global $SYSTEM_ADVANCE_SEARCH_TO_DEFINE;

	//$SYSTEM_ADD_SQL = "and  星期='2'";

	$tablename=$fields['table']['name'];

	//得到高级搜索相关配置文件信息
	$EXPORT_ADV = $file_ini['exportadv_default'];
	//print_R($EXPORT_ADV);
	$showlistfieldlist = $EXPORT_ADV['showlistfieldlist'];
	$showlistfieldfilter = $EXPORT_ADV['showlistfieldfilter'];
	$showlistfieldlistArray = explode(",",$showlistfieldlist);
	$showlistfieldfilterArray = explode(",",$showlistfieldfilter);
	print "
		<fieldset style=\"
		padding-left:5px;
		padding-right:5px;
		padding-top:5px;
		padding-bottom:5px;\">
			 <legend class=\"small\" align=left>
			  <b>高级查询</b>
		  </legend>\n";
	print "
		<table  class=\"TableList\" align=\"left\" width='100%'>
		  <input type=hidden name='pageid' value='1'>";
	
		
	//print_R($columns);
	for($i=0;$i<sizeof($showlistfieldlistArray);$i++)				{
		$listIndex = $showlistfieldlistArray[$i];
		$listIndexName = $columns[$listIndex];
		$fieldfilter = $showlistfieldfilterArray[$i];
		$listLangName = $html_etc[$tablename][$listIndexName];
		$fieldfilter_array=explode(':',$fieldfilter);
		$fieldfilter=trim($fieldfilter_array[0]);
		if($i%4==0) print "<TR>";
		if($fieldfilter!="notshow")  {
			print "<td nowrap class=\"TableData\">&nbsp;&nbsp;".$listLangName.$listFilter."： </td><td nowrap class=\"TableData\">\n";
		}
		else	{
			print "<td nowrap class=\"TableData\">&nbsp;&nbsp;</td><td nowrap class=\"TableData\">\n";
		}
		switch($fieldfilter)		{

			case 'datetime':
				print "<SCRIPT src=\"../../Enginee/WdatePicker/WdatePicker.js\"></SCRIPT>\n";
				print "<SCRIPT>
						function td_calendar(fieldname) {
						myleft=document.body.scrollLeft+event.clientX-event.offsetX-80;
						mytop=document.body.scrollTop+event.clientY-event.offsetY+140;
						window.showModalDialog(fieldname,self,\"edge:raised;scroll:0;status:0;help:0;resizable:1;dialogWidth:280px;dialogHeight:200px;dialogTop:\"+mytop+\"px;dialogLeft:\"+myleft+\"px\");
						}
						</SCRIPT>\n";
				/*
				$sql = "select max(".$listIndexName.") AS 最大值,min(".$listIndexName.") AS 最小值 from $tablename";
				$rsX = $db->Execute($sql);
				$rsX_a = $rsX->GetArray();
				$最大值 = $rsX_a[0]['最大值'];
				$最小值 = $rsX_a[0]['最小值'];
				$BEGIN_DATE = $最小值;
				$END_DATE = $最大值;
				*/
				$GetValue开始时间 = $_GET[$listIndexName."_开始时间"];
				$GetValue结束时间 = $_GET[$listIndexName."_结束时间"];
				if($GetValue开始时间!="")		$BEGIN_DATE = $GetValue开始时间;
				if($GetValue结束时间!="")		$END_DATE = $GetValue结束时间;
				print "<INPUT class=SmallInput size=19  name=\"".$listIndexName."_开始时间\" value=\"$BEGIN_DATE\" onclick=\"WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss'})\" readonly> -
				\n";
				print "<INPUT class=SmallInput size=19  name=\"".$listIndexName."_结束时间\" value=\"$END_DATE\" onclick=\"WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss'})\" readonly>
				\n";
				break;
			case 'date':
				print "<SCRIPT src=\"../../Enginee/WdatePicker/WdatePicker.js\"></SCRIPT>\n";
				print "<SCRIPT>
						function td_calendar(fieldname) {
						myleft=document.body.scrollLeft+event.clientX-event.offsetX-80;
						mytop=document.body.scrollTop+event.clientY-event.offsetY+140;
						window.showModalDialog(fieldname,self,\"edge:raised;scroll:0;status:0;help:0;resizable:1;dialogWidth:280px;dialogHeight:200px;dialogTop:\"+mytop+\"px;dialogLeft:\"+myleft+\"px\");
						}
						</SCRIPT>";
				/*
				$sql = "select max(".$listIndexName.") AS 最大值,min(".$listIndexName.") AS 最小值 from $tablename";
				$rsX = $db->Execute($sql);
				$rsX_a = $rsX->GetArray();
				$最大值 = $rsX_a[0]['最大值'];
				$最小值 = $rsX_a[0]['最小值'];
				$BEGIN_DATE = $最小值;
				$END_DATE = $最大值;
				*/
				$GetValue开始时间 = $_GET[$listIndexName."_开始时间"];
				$GetValue结束时间 = $_GET[$listIndexName."_结束时间"];
				if($GetValue开始时间!="")		$BEGIN_DATE = $GetValue开始时间;
				if($GetValue结束时间!="")		$END_DATE = $GetValue结束时间;
				print "<INPUT class=SmallInput size=19  name=\"".$listIndexName."_开始时间\" value=\"$BEGIN_DATE\" onclick=\"WdatePicker({dateFmt:'yyyy-MM-dd'})\" readonly> -
				\n";
				print "<INPUT class=SmallInput size=19  name=\"".$listIndexName."_结束时间\" value=\"$END_DATE\" onclick=\"WdatePicker({dateFmt:'yyyy-MM-dd'})\" readonly>
				\n";
				break;
			case 'number':
			case 'money':
				/*
				$sql = "select max(".$listIndexName.") AS 最大值,min(".$listIndexName.") AS 最小值 from $tablename";
				$rsX = $db->Execute($sql);
				$rsX_a = $rsX->GetArray();
				$最大值 = round($rsX_a[0]['最大值'],2);
				$最小值 = round($rsX_a[0]['最小值'],2);
				*/
				$GetValue最小值 = $_GET[$listIndexName."_最小值"];
				$GetValue最大值 = $_GET[$listIndexName."_最大值"];
				if($GetValue最小值!="")		$最小值 = $GetValue最小值;
				if($GetValue最大值!="")		$最大值 = $GetValue最大值;
				print "<INPUT class=SmallInput size=6  name=\"".$listIndexName."_最小值\" value=\"$最小值\">(最小)
				";
				print "<INPUT class=SmallInput size=6  name=\"".$listIndexName."_最大值\" value=\"$最大值\">(最大)
				";
				break;
			case 'tablefilter':
			case 'tablefiltercolor':
			case 'radiofilter':
			case 'radiofiltercolor':
				/*
				$ChildTablename = $fieldfilter_array[1];
				$ChildColumns=returntablecolumn($ChildTablename);
				$ChildFieldValueIndex = $fieldfilter_array[2];
				$ChildFieldNameIndex = $fieldfilter_array[3];
				$ChildFieldValue = $ChildColumns[$ChildFieldValueIndex];
				$ChildFieldName = $ChildColumns[$ChildFieldNameIndex];
				
				//print_R($columns);
				//当两个值相同时,只进行一条SQL判断
				if($ChildFieldValue==$ChildFieldName)		{
					$sql="select distinct $listIndexName AS $ChildFieldName from $tablename where $listIndexName!='' order by $ChildFieldName";
				}
				//否则把两条SQL语句进行拆分来进行执行
				else				{
					$sql="select distinct $listIndexName from $tablename where $listIndexName!='' order by $listIndexName";
					$rsX = $db->CacheExecute(150,$sql);
					$rsX_a = $rsX->GetArray();
					$中间过滤数组 = array();
					for($X=0;$X<sizeof($rsX_a);$X++)				{
						$中间过滤数组[] = $rsX_a[$X][$listIndexName];
					}
					$中间过滤数组TEXT = "'".join("','",$中间过滤数组)."'";
					$sql="select $ChildFieldValue,$ChildFieldName from $ChildTablename where $ChildFieldValue in ($中间过滤数组TEXT)";
				}
				//print $sql;

				$rsX = $db->CacheExecute(150,$sql);
				$rsX_a = $rsX->GetArray();
				print "<select class=\"SmallSelect\" name=\"".$listIndexName."\">";
				print "<option value=''>所有".$listLangName."</option>\n";
				for($X=0;$X<sizeof($rsX_a);$X++)				{
					if($_GET[$listIndexName]==$rsX_a[$X][$ChildFieldValue])
						$temp = 'selected';
					else
						$temp = '';
					print "<option value=\"".$rsX_a[$X][$ChildFieldValue]."\" $temp>".$rsX_a[$X][$ChildFieldName]."</option>\n";

				}
				print "</select>\n";
				break;
				*/
			case '':
			case 'input':
			default:
				print "<input type=\"text\" title='模糊查询' name=\"".$listIndexName."\" class=\"SmallInput\" size=\"15\" maxlength=\"100\" value=\"".$_GET[$listIndexName]."\">";
				break;

		}
		print "</td>";
		if($i%4==3) print "</TR>";
		if($i==sizeof($showlistfieldlistArray)-1 && $i%4!=3)
			print "<td class=\"TableData\" colspan=".((3-$i%4)*2).">";

	}

	//http://localhost/general/EDU/Interface/EDU/dorm_liusu_huijia_shengguan_newai.php?action=export_default_data&exportfield=0,1,2,3,4,5,6,7,8,9,10,11,12&tablename=dorm_liusu&searchfield=&searchvalue=&说明=
	//得到初始经状态下面的所有字段的列表
	$showlistfieldlist_init = $file_ini['export_default']['showlistfieldlist'];

	//
	if($SYSTEM_ADVANCE_SEARCH_TO_DEFINE=="1")		{
		$return=FormPageAction2("action","export_default",
									"actionadv","exportadv_default",
									"$delete",
									"exportfield",$showlistfieldlist_init,
									"tablename",$tablename
									);
	}
	else	{
		$return=FormPageAction2("action","export_default_data",
									"actionadv","exportadv_default",
									"$delete",
									"exportfield",$showlistfieldlist_init,
									"tablename",$tablename
									);
	}

	//print $return;
	//edu_renshi_newai.php?action=export_default_data&actionadv=exportadv_default&exportfield=0,1,29,2,3,4,7,22,5,9,10,8,11,12,13,14,15,24,17,16,19,26,27,25,18,20,23,6&tablename=edu_renshi&searchfield=&searchvalue=&单位=郑东新区信息中心&出生年月_最小值=1951.09&出生年月_最大值=1985.12&任同职级时间_最小值=0.00&任同职级时间_最大值=0.00

	
	print "<script>function ResultExportXLS(LOCALURL)	{
					url=\"?XX=XX&\"+LOCALURL;
					//alert(url);
					location=url;
					}
			</script>
		 <tr>
			<td nowrap class=\"TableData\"  colspan=\"8\" >
			&nbsp;&nbsp;
			<input class=\"SmallButton\" value=\"查询\" type=\"submit\" title=\"查询\" name=\"快速查询\">&nbsp;
			<input class=\"SmallButton\" value=\"返回\" type=\"button\" title=\"返回\" name=\"快速返回\" onClick=\"location='?'\">&nbsp;
			<input class=\"SmallButton\" value=\"导出\" type=\"button\" title=\"导出\" name=\"结果导出\" onClick=\"ResultExportXLS('$return')\">&nbsp;

			<input value=\"exportadv_default\" type=\"hidden\" name=\"actionadv\">
		  </td>
		 </tr>
		
		</table>
		</fieldset><div style='height:3px'></div>
		";
}




//2009-12-27 处理对高级搜索部分SQL支持的部分,主要在SYSTEM_ADD_SQL特性的基础上面进行修改
function newai_search_sql($fields)			{
	global $common_html,$html_etc;
	global $return_sql_line,$db;
	global $action_add,$action_model;
	global $_POST,$_GET,$ROWS_PAGE;
	global $file_ini,$columns;
	global $SYSTEM_ADD_SQL;

	$AddSql = '';

	//$SYSTEM_ADD_SQL = "and  星期='2'";

	$tablename=$fields['table']['name'];

	//得到高级搜索相关配置文件信息
	$EXPORT_ADV = $file_ini['exportadv_default'];
	//print_R($EXPORT_ADV);
	$showlistfieldlist = $EXPORT_ADV['showlistfieldlist'];
	$showlistfieldfilter = $EXPORT_ADV['showlistfieldfilter'];
	$showlistfieldlistArray = explode(",",$showlistfieldlist);
	$showlistfieldfilterArray = explode(",",$showlistfieldfilter);

	//print_R($columns);
	for($i=0;$i<sizeof($showlistfieldlistArray);$i++)				{
		$listIndex = $showlistfieldlistArray[$i];
		$listIndexName = $columns[$listIndex];
		$fieldfilter = $showlistfieldfilterArray[$i];
		$listLangName = $html_etc[$tablename][$listIndexName];
		$fieldfilter_array=explode(':',$fieldfilter);
		$fieldfilter=trim($fieldfilter_array[0]);

		switch($fieldfilter)		{
			case '':
			default:
			case 'input':
				$GetValue = $_GET[$listIndexName];
				if($GetValue!="")	{
					$AddSql .= "and ".$listIndexName." like '%$GetValue%'";
					$FileName .= "[".$listIndexName."(".$GetValue.")]";
				}
				break;
			case 'date':
			case 'datetime':
				$GetValue开始时间 = $_GET[$listIndexName."_开始时间"];
				$GetValue结束时间 = $_GET[$listIndexName."_结束时间"];
				if($GetValue开始时间!=""&&$GetValue结束时间!="")	{
					$AddSql .= "and
							".$listIndexName." >= '$GetValue开始时间' and
							".$listIndexName." <= '$GetValue结束时间'
							";
					$FileName .= "[".$listIndexName."(".$GetValue开始时间."-".$GetValue结束时间.")]";
				}
				break;
			case 'number':
				$GetValue最小值 = $_GET[$listIndexName."_最小值"];
				$GetValue最大值 = $_GET[$listIndexName."_最大值"];
				if($GetValue最小值!=""&&$GetValue最大值!="")	{
					$GetValue最小值 = $GetValue最小值 - 0.001;
					$GetValue最大值 = $GetValue最大值 + 0.001;
					$AddSql .= "and
							".$listIndexName." >= '$GetValue最小值' and
							".$listIndexName." <= '$GetValue最大值'
							";
					$FileName .= "[".$listIndexName."(".$GetValue最小值."-".$GetValue最大值.")]";
				}
				break;
			case 'tablefilter':
			case 'tablefiltercolor':
			case 'radiofilter':
			case 'radiofiltercolor':
				$GetValue = $_GET[$listIndexName];
				if($GetValue!=""&&$listIndexName!="教室")		{
					
					$foreigncolumns=returntablecolumn($fieldfilter_array[1]);
					$insql="select ".$foreigncolumns[$fieldfilter_array[2]]." from ".$fieldfilter_array[1]." where ".$foreigncolumns[$fieldfilter_array[3]]." like '%".trim($GetValue)."%'";
					$AddSql .= "and ".$listIndexName." in ($insql)";
					
					$FileName .= "[".$GetValue."]";
				}
				break;
			case 'city':
				$GetValue = trim($_GET[$listIndexName]);
				$sql="select ROWID from customerarea where name like '%".$GetValue."%'";
				$rs=$db->Execute($sql);
				$rs_a=$rs->GetArray();
				$insqlArray=array();
				foreach ($rs_a as $row)
				{
					$areacode=$row['ROWID'];
					if(substr($areacode,2,4)=='0000')
						$insqlArray[]="left(".$listIndexName.",2)='".substr($areacode,0,2)."'";
					else if((substr($areacode,4,2)=='00'))
						$insqlArray[]="left(".$listIndexName.",4)='".substr($areacode,0,4)."'";
					else 
						$insqlArray[]=$listIndexName."='".$areacode."'";	
				}
				$insql=implode(" or ",$insqlArray);
				if($insql!='')
				{
					$insql="(".$insql.")";
					$AddSql .= "and ".$insql;
				}
				break;

		}//end switch
	}//end for
	
	if($_GET['action']=='export_default_data')		{
		$SYSTEM_ADD_SQL .= $AddSql;
		//print $SYSTEM_ADD_SQL;exit;
	}
	if($_GET['actionadv']=='exportadv_default')		{
		$SYSTEM_ADD_SQL .= $AddSql;
		//print $SYSTEM_ADD_SQL;exit;
	}
	$FileName = addslashes($FileName);
	$FileName = ereg_replace('/','',$FileName);
	//$FileName = substr($FileName,0,220);
	//return $FileName;
	//print_R($_GET);
	

}
?>