<?php
//2009-12-27 ���ӶԸ߼�������֧��
function newai_search($fields)			{
	global $common_html,$html_etc;
	global $return_sql_line,$db;
	global $action_add,$action_model;
	global $_POST,$_GET,$ROWS_PAGE;
	global $file_ini,$columns;
	global $SYSTEM_ADD_SQL;
	global $SYSTEM_ADVANCE_SEARCH_TO_DEFINE;

	//$SYSTEM_ADD_SQL = "and  ����='2'";

	$tablename=$fields['table']['name'];

	//�õ��߼�������������ļ���Ϣ
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
			  <b>�߼���ѯ</b>
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
			print "<td nowrap class=\"TableData\">&nbsp;&nbsp;".$listLangName.$listFilter."�� </td><td nowrap class=\"TableData\">\n";
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
				$sql = "select max(".$listIndexName.") AS ���ֵ,min(".$listIndexName.") AS ��Сֵ from $tablename";
				$rsX = $db->Execute($sql);
				$rsX_a = $rsX->GetArray();
				$���ֵ = $rsX_a[0]['���ֵ'];
				$��Сֵ = $rsX_a[0]['��Сֵ'];
				$BEGIN_DATE = $��Сֵ;
				$END_DATE = $���ֵ;
				*/
				$GetValue��ʼʱ�� = $_GET[$listIndexName."_��ʼʱ��"];
				$GetValue����ʱ�� = $_GET[$listIndexName."_����ʱ��"];
				if($GetValue��ʼʱ��!="")		$BEGIN_DATE = $GetValue��ʼʱ��;
				if($GetValue����ʱ��!="")		$END_DATE = $GetValue����ʱ��;
				print "<INPUT class=SmallInput size=19  name=\"".$listIndexName."_��ʼʱ��\" value=\"$BEGIN_DATE\" onclick=\"WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss'})\" readonly> -
				\n";
				print "<INPUT class=SmallInput size=19  name=\"".$listIndexName."_����ʱ��\" value=\"$END_DATE\" onclick=\"WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss'})\" readonly>
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
				$sql = "select max(".$listIndexName.") AS ���ֵ,min(".$listIndexName.") AS ��Сֵ from $tablename";
				$rsX = $db->Execute($sql);
				$rsX_a = $rsX->GetArray();
				$���ֵ = $rsX_a[0]['���ֵ'];
				$��Сֵ = $rsX_a[0]['��Сֵ'];
				$BEGIN_DATE = $��Сֵ;
				$END_DATE = $���ֵ;
				*/
				$GetValue��ʼʱ�� = $_GET[$listIndexName."_��ʼʱ��"];
				$GetValue����ʱ�� = $_GET[$listIndexName."_����ʱ��"];
				if($GetValue��ʼʱ��!="")		$BEGIN_DATE = $GetValue��ʼʱ��;
				if($GetValue����ʱ��!="")		$END_DATE = $GetValue����ʱ��;
				print "<INPUT class=SmallInput size=19  name=\"".$listIndexName."_��ʼʱ��\" value=\"$BEGIN_DATE\" onclick=\"WdatePicker({dateFmt:'yyyy-MM-dd'})\" readonly> -
				\n";
				print "<INPUT class=SmallInput size=19  name=\"".$listIndexName."_����ʱ��\" value=\"$END_DATE\" onclick=\"WdatePicker({dateFmt:'yyyy-MM-dd'})\" readonly>
				\n";
				break;
			case 'number':
			case 'money':
				/*
				$sql = "select max(".$listIndexName.") AS ���ֵ,min(".$listIndexName.") AS ��Сֵ from $tablename";
				$rsX = $db->Execute($sql);
				$rsX_a = $rsX->GetArray();
				$���ֵ = round($rsX_a[0]['���ֵ'],2);
				$��Сֵ = round($rsX_a[0]['��Сֵ'],2);
				*/
				$GetValue��Сֵ = $_GET[$listIndexName."_��Сֵ"];
				$GetValue���ֵ = $_GET[$listIndexName."_���ֵ"];
				if($GetValue��Сֵ!="")		$��Сֵ = $GetValue��Сֵ;
				if($GetValue���ֵ!="")		$���ֵ = $GetValue���ֵ;
				print "<INPUT class=SmallInput size=6  name=\"".$listIndexName."_��Сֵ\" value=\"$��Сֵ\">(��С)
				";
				print "<INPUT class=SmallInput size=6  name=\"".$listIndexName."_���ֵ\" value=\"$���ֵ\">(���)
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
				//������ֵ��ͬʱ,ֻ����һ��SQL�ж�
				if($ChildFieldValue==$ChildFieldName)		{
					$sql="select distinct $listIndexName AS $ChildFieldName from $tablename where $listIndexName!='' order by $ChildFieldName";
				}
				//���������SQL�����в��������ִ��
				else				{
					$sql="select distinct $listIndexName from $tablename where $listIndexName!='' order by $listIndexName";
					$rsX = $db->CacheExecute(150,$sql);
					$rsX_a = $rsX->GetArray();
					$�м�������� = array();
					for($X=0;$X<sizeof($rsX_a);$X++)				{
						$�м��������[] = $rsX_a[$X][$listIndexName];
					}
					$�м��������TEXT = "'".join("','",$�м��������)."'";
					$sql="select $ChildFieldValue,$ChildFieldName from $ChildTablename where $ChildFieldValue in ($�м��������TEXT)";
				}
				//print $sql;

				$rsX = $db->CacheExecute(150,$sql);
				$rsX_a = $rsX->GetArray();
				print "<select class=\"SmallSelect\" name=\"".$listIndexName."\">";
				print "<option value=''>����".$listLangName."</option>\n";
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
				print "<input type=\"text\" title='ģ����ѯ' name=\"".$listIndexName."\" class=\"SmallInput\" size=\"15\" maxlength=\"100\" value=\"".$_GET[$listIndexName]."\">";
				break;

		}
		print "</td>";
		if($i%4==3) print "</TR>";
		if($i==sizeof($showlistfieldlistArray)-1 && $i%4!=3)
			print "<td class=\"TableData\" colspan=".((3-$i%4)*2).">";

	}

	//http://localhost/general/EDU/Interface/EDU/dorm_liusu_huijia_shengguan_newai.php?action=export_default_data&exportfield=0,1,2,3,4,5,6,7,8,9,10,11,12&tablename=dorm_liusu&searchfield=&searchvalue=&˵��=
	//�õ���ʼ��״̬����������ֶε��б�
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
	//edu_renshi_newai.php?action=export_default_data&actionadv=exportadv_default&exportfield=0,1,29,2,3,4,7,22,5,9,10,8,11,12,13,14,15,24,17,16,19,26,27,25,18,20,23,6&tablename=edu_renshi&searchfield=&searchvalue=&��λ=֣��������Ϣ����&��������_��Сֵ=1951.09&��������_���ֵ=1985.12&��ְͬ��ʱ��_��Сֵ=0.00&��ְͬ��ʱ��_���ֵ=0.00

	
	print "<script>function ResultExportXLS(LOCALURL)	{
					url=\"?XX=XX&\"+LOCALURL;
					//alert(url);
					location=url;
					}
			</script>
		 <tr>
			<td nowrap class=\"TableData\"  colspan=\"8\" >
			&nbsp;&nbsp;
			<input class=\"SmallButton\" value=\"��ѯ\" type=\"submit\" title=\"��ѯ\" name=\"���ٲ�ѯ\">&nbsp;
			<input class=\"SmallButton\" value=\"����\" type=\"button\" title=\"����\" name=\"���ٷ���\" onClick=\"location='?'\">&nbsp;
			<input class=\"SmallButton\" value=\"����\" type=\"button\" title=\"����\" name=\"�������\" onClick=\"ResultExportXLS('$return')\">&nbsp;

			<input value=\"exportadv_default\" type=\"hidden\" name=\"actionadv\">
		  </td>
		 </tr>
		
		</table>
		</fieldset><div style='height:3px'></div>
		";
}




//2009-12-27 ����Ը߼���������SQL֧�ֵĲ���,��Ҫ��SYSTEM_ADD_SQL���ԵĻ�����������޸�
function newai_search_sql($fields)			{
	global $common_html,$html_etc;
	global $return_sql_line,$db;
	global $action_add,$action_model;
	global $_POST,$_GET,$ROWS_PAGE;
	global $file_ini,$columns;
	global $SYSTEM_ADD_SQL;

	$AddSql = '';

	//$SYSTEM_ADD_SQL = "and  ����='2'";

	$tablename=$fields['table']['name'];

	//�õ��߼�������������ļ���Ϣ
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
				$GetValue��ʼʱ�� = $_GET[$listIndexName."_��ʼʱ��"];
				$GetValue����ʱ�� = $_GET[$listIndexName."_����ʱ��"];
				if($GetValue��ʼʱ��!=""&&$GetValue����ʱ��!="")	{
					$AddSql .= "and
							".$listIndexName." >= '$GetValue��ʼʱ��' and
							".$listIndexName." <= '$GetValue����ʱ��'
							";
					$FileName .= "[".$listIndexName."(".$GetValue��ʼʱ��."-".$GetValue����ʱ��.")]";
				}
				break;
			case 'number':
				$GetValue��Сֵ = $_GET[$listIndexName."_��Сֵ"];
				$GetValue���ֵ = $_GET[$listIndexName."_���ֵ"];
				if($GetValue��Сֵ!=""&&$GetValue���ֵ!="")	{
					$GetValue��Сֵ = $GetValue��Сֵ - 0.001;
					$GetValue���ֵ = $GetValue���ֵ + 0.001;
					$AddSql .= "and
							".$listIndexName." >= '$GetValue��Сֵ' and
							".$listIndexName." <= '$GetValue���ֵ'
							";
					$FileName .= "[".$listIndexName."(".$GetValue��Сֵ."-".$GetValue���ֵ.")]";
				}
				break;
			case 'tablefilter':
			case 'tablefiltercolor':
			case 'radiofilter':
			case 'radiofiltercolor':
				$GetValue = $_GET[$listIndexName];
				if($GetValue!=""&&$listIndexName!="����")		{
					
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