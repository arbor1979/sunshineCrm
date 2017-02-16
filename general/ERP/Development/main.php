<?php
header("Content-type:text/html;charset=gb2312");
ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL);
// display warnings and errors
error_reporting(E_WARNING | E_ERROR);
	
require_once("lib.inc.php");
require_once("class.dir.php");
page_css("Sunshine Anywhere 企业软件开发平台 集成开发环境");

if($_GET['MakeSystemModel']!="")			{

	$SYSTEM_ALL_MODE = $_GET['MakeSystemModel'];
	$Tablename = $_GET['Tablename'];
	$FileIniname = $_GET['FileIniname'];
	session_register("MakeSystemModelDBName");

	if(is_file('../Interface/'.$_GET['MakeSystemModel'].'/dbname.inc.php'))		{
		require_once('../Interface/'.$_GET['MakeSystemModel'].'/dbname.inc.php');

	}
	
	FormTextFile("config.php","<?php \$SYSTEM_MODE_DIR = \"$SYSTEM_ALL_MODE\" ; ?>");
	//header("Location:?Tablename=".$Tablename."&FileIniname=".$FileIniname);  
	echo "<script>window.location='main.php?Tablename=".$Tablename."&FileIniname=".$FileIniname."'</script>";
	//echo "<html><head><META HTTP-EQUIV=REFRESH CONTENT='0;URL=main.php?Tablename=$Tablename&FileIniname=$FileIniname'></head></html>\n";
	exit;

}
//print_R($_SESSION['MakeSystemModelDBName']);//exit;

$common_html=returnsystemlang('common_html');

pageHeader();
if($_GET['action']=="action_init")		{
	$returnDirName = returnDirName() ;
	pageHeaderModelInit($returnDirName);
	//print_infor("请选择所要操作对象");
	exit;
}
if($_GET['actionAction']=="phpide")		{
	include "php_ide.php";
	exit;
}

//##############################################################################
//系统数据变量初始化区
//##############################################################################

//初始化模块
$sectionName = $_POST['section'];
$actionModelArray = explode('_',$sectionName);
$actionModel = $actionModelArray[0];

$Tablename = $_GET['Tablename'];
$TablenameArray = explode('_',$Tablename);
$TempName = $TablenameArray[sizeof($TablenameArray)-1];
if(sizeof($TablenameArray)>=3&&($TempName=="input"||$TempName=="edit"||$TempName=="read"))	{
	$addTablename = true;
	array_pop($TablenameArray);
	$Tablerealname = join('_',$TablenameArray);
}
else		{
	$addTablename = false;
	$Tablerealname = $Tablename;
}

$html_etc=returnsystemlang($Tablerealname);
$columns=returntablecolumn($Tablerealname);
//print_R($columns);



//系统初始化变量及常量
//$filename = "../Framework/Model/".$_GET['FileIniname']."_newai.ini";
$SystemModelName = "";
if(!is_file($filename))		{
	$filename = "../Interface/$SYSTEM_MODE_DIR/Model/".$_GET['FileIniname']."_newai.ini";
	$SystemModelName = $SYSTEM_MODE_DIR;
}
//print $filename;

//############################################################################
//
//############################################################################

if($_GET['sectionName']=="sectionName_data")							{
	//print_R($_GET);
	//print "<HR>";
	//print_R($_POST);exit;
	$section = $_POST['section'];
	if($_POST['Tablename'] != "")
		$ArrayGroup['tablename'] = $_POST['Tablename'];
	if($_POST['tabletitle'] != "")
		$ArrayGroup['tabletitle'] = $_POST['tabletitle'];
	if($_POST['tablewidth'] != "")
		$ArrayGroup['tablewidth'] = $_POST['tablewidth'];
	if($_POST['ondblclick_config'] != "")
		$ArrayGroup['ondblclick_config'] = $_POST['ondblclick_config'];
	if($_POST['nullshow'] != "")
		$ArrayGroup['nullshow'] = $_POST['nullshow'];
	//数组信息-checkbox
	$action_submit = returnCheckboxValue("action_submit");
	$action_submit!=""?$ArrayGroup['action_submit'] = $action_submit:'';

	//2009-12-28 更新自定义列表名称
	if($_POST['tabletitlevalue']!="")		{
		$sql = "select chinese from systemlang where tablename='".$_POST['Tablename']."' and fieldname='".$_POST['tabletitle']."'";
		$rs = $db->Execute($sql);
		$chinese值 = $rs->fields['chinese'];
		if($chinese值!="")		{
			$sql = "update systemlang set  chinese ='".$_POST['tabletitlevalue']."' where tablename='".$_POST['Tablename']."' and fieldname='".$_POST['tabletitle']."'";
		}
		else	{
			$sql = "insert into systemlang values('','".$_POST['tabletitle']."','".$_POST['Tablename']."','".$_POST['tabletitlevalue']."','".$_POST['tabletitlevalue']."','')";
		}
		$db->Execute($sql);
	}
	/*
	$action_model = returnCheckboxValue("action_model");
	$action_model!=""?$ArrayGroup['action_model'] = $action_model:'';
	$row_element = returnCheckboxValue("row_element");
	$row_element!=""?$ArrayGroup['row_element'] = $row_element:'';
	$bottom_element = returnCheckboxValue("bottom_element");
	$bottom_element!=""?$ArrayGroup['bottom_element'] = $bottom_element:'';
	*/

	if($_POST['action_model'] != "")
		$ArrayGroup['action_model'] = $_POST['action_model'];
	if($_POST['row_element'] != "")
		$ArrayGroup['row_element'] = $_POST['row_element'];
	if($_POST['bottom_element'] != "")
		$ArrayGroup['bottom_element'] = $_POST['bottom_element'];

	//returnCheckboxValue("action_model");
	//returnCheckboxValue("row_element");
	//returnCheckboxValue("bottom_element");

	if($_POST['primarykey'] != "")
		$ArrayGroup['primarykey'] = $_POST['primarykey'];
	//获取从表
	$subtablecount=intval($_POST['subtablecount']);
	$ArrayGroup['subtablecount']=$subtablecount;
	for($i=0;$i<$subtablecount;$i++)
	{
	
		$ArrayGroup['subtable_title_'.$i]=$_POST['subtable_title_'.$i];
		$ArrayGroup['subtable_name_'.$i]=$_POST['subtable_name_'.$i];
		$ArrayGroup['subtable_key_'.$i]=$_POST['subtable_key_'.$i];
		$ArrayGroup['subtable_showlistfieldlist_'.$i]=$_POST['subtable_showlistfieldlist_'.$i];
		$ArrayGroup['maintable_key_'.$i]=$_POST['maintable_key_'.$i];
		$ArrayGroup['subtable_where_'.$i]=str_replace("\\","",$_POST['subtable_where_'.$i]);
		
	}	
	
	if($_POST['uniquekey'] != "")
		$ArrayGroup['uniquekey'] = $_POST['uniquekey'];
	if($_POST['returnmodel'] != "")
		$ArrayGroup['returnmodel'] = $_POST['returnmodel'];
	if($_POST['departprivte'] != "")
		$ArrayGroup['departprivte'] = $_POST['departprivte'];
	if($_POST['systemorder'] != "")
		$ArrayGroup['systemorder'] = $_POST['systemorder'];
	if($_POST['pagenums_model'] != "")
		$ArrayGroup['pagenums_model'] = $_POST['pagenums_model'];
	if($_POST['UserSumFunction'] != "")		{
		$ArrayGroup['UserSumFunction'] = $_POST['UserSumFunction'];
		$ArrayGroup['UserUnitFunction'] = "RMB";
	}
	if($_POST['ForeignKeyIndex'] != "")		{
		$ArrayGroup['ForeignKeyIndex'] = $_POST['ForeignKeyIndex'];
	}

	if($_POST['passwordcheck'] != "")
		$ArrayGroup['passwordcheck'] = $_POST['passwordcheck'];


	//构建字段列表信息
	$fieldList = array();
	$searchList = array();
	$searchadvList = array();
	$searchadvListFilter = array();
	$nullList = array();
	$groupList = array();
	$filterList = array();
	$typeList = array();
	$privateList = array();
	$StopEditList = array();
	$StopDeleteList = array();

	$NewArray = array();
	for($i=0;$i<sizeof($columns);$i++)					{
		$indexName = $columns[$i];
		$indexName2 = $_POST[$indexName."_Order"];
		$indexName_boolean = $_POST[$indexName."_boolean"];
		if($indexName_boolean)				{
			$NewArray[$indexName] = $indexName2;
		}
	}
	//print_R($_POST);exit;
	array_multisort($NewArray);
	//$array_keys_values = array_keys_values($NewArray);
	$NewArrayKeys = array_keys($NewArray);
	//print_R($NewArrayKeys);
	//columns-reverse
	$array_keys_values = array_keys_values($columns);
	//print_R($array_keys_values);
	//exit;

	for($i=0;$i<sizeof($NewArrayKeys);$i++)					{
		$indexName = $NewArrayKeys[$i];
		$fieldName_boolean = $_POST[$indexName."_boolean"];
		$fieldName_search = $_POST[$indexName."_search"];
		$fieldName_search_adv = $_POST[$indexName."_search_adv"];
		$fieldName_group = $_POST[$indexName."_group"];
		$fieldName_grouphidden = $_POST[$indexName."_hidden"];
		$fieldName_grouphidden_group_filter = $_POST[$indexName."_hidden_group_filter"];
		$fieldName_null = $_POST[$indexName."_null"];
		
		
		//得到字段索引
		$fieldName_index = $array_keys_values[$indexName];

		if($fieldName_null=='on')
			$fieldName_null = "notnull";
		else
			$fieldName_null = "null";

		$fieldName_filter = $_POST[$indexName."_filter"];
		$fieldName_filter=="" ? $fieldName_filter="input" : '';
		$fieldName_type = $_POST[$indexName."_type"];
		$fieldName_private = $_POST[$indexName."_private"];


		if($fieldName_boolean)			{
			array_push($fieldList,$fieldName_index);
			array_push($nullList,$fieldName_null);
			array_push($filterList,$fieldName_filter);
			array_push($typeList,$fieldName_type);
			array_push($privateList,$fieldName_private);

			array_push($StopEditList,$_POST[$indexName."_stop_edit"]);
			array_push($StopDeleteList,$_POST[$indexName."_stop_delete"]);

			if($fieldName_search)			{
				array_push($searchList,$fieldName_index);
			}
			if($fieldName_search_adv)			{
				array_push($searchadvList,$fieldName_index);
				array_push($searchadvListFilter,$fieldName_filter);
			}
			if($fieldName_group)			{
				$fieldName_filter_array=array();
				$fieldName_filter_array = explode(':',$fieldName_filter);
				$filtertype=$fieldName_filter_array[0];
				
				if($filtertype=='userdefine')
				{
					array_shift($fieldName_filter_array);
					$fieldName_filter_Search = join(':',$fieldName_filter_array);
				}
				else 
				{
					array_shift($fieldName_filter_array);
					$fieldName_filter_Search = join(':',$fieldName_filter_array);
				}
				
				if($fieldName_grouphidden)		{
					$grouphidden  = ":hidden";
				}
				else	{
					$grouphidden  = "";
				}
				
				if($fieldName_grouphidden_group_filter!="")				{
					//结尾不为HIDDEN,同时又要求HIDDEN时进行追加此信息
					if(substr($fieldName_grouphidden_group_filter,-6)!="hidden"&&$fieldName_grouphidden)  {
						$fieldName_grouphidden_group_filter .= $grouphidden;
					}
					//为隐藏时,但没有要求HIDDEN,就需要把HIDDEN去除
					else if(substr($fieldName_grouphidden_group_filter,-6)=="hidden"&&!$fieldName_grouphidden)  {
						$fieldName_grouphidden_group_filter = substr($fieldName_grouphidden_group_filter,0,-7);
					}
					//已经存在基础上面的修改和更新
					array_push($groupList,$fieldName_index.":".$fieldName_grouphidden_group_filter);
				}
				else	{
					//在新增GROUP_FILTER时进行的处理工作
					array_push($groupList,$fieldName_index.":".$fieldName_filter_Search.$grouphidden);
				}
			}
		}
		else								{
			if($_POST["showlistfieldlist_".$fieldName_index]!="")
				array_push($fieldList,$fieldName_index);
		}
	}
	//print_R($groupList);exit;
	
	if($_POST['section']=="export_default"||$_POST['section']=="import_default")				{
		$NewArray1 = array();
		
		for($i=0;$i<sizeof($columns);$i++)					{
			$indexName = $columns[$i];
			$indexName2 = $_POST["showlistfieldlist_".$i];
			if($indexName2!="")		{
				array_push($fieldList,$indexName2);
			}
		}
	}

	//print_R($_POST);exit;
	sizeof($fieldList)>0?$fieldListText = join(',',$fieldList):'';
	sizeof($nullList)>0?$nullListText = join(',',$nullList):'';
	sizeof($filterList)>0?$filterListText = join(',',$filterList):'';
	sizeof($searchList)>0?$searchListText = join(',',$searchList):'';

	sizeof($groupList)>0?$groupListText = join(',',$groupList):'';
	sizeof($typeList)>0?$typeListText = join(',',$typeList):'';
	sizeof($privateList)>0?$privateListText = join(',',$privateList):'';

	$searchListText != "" ?$ArrayGroup['action_search'] = $searchListText:'';
	$groupListText != "" ?$ArrayGroup['group_filter'] = $groupListText:'';
	$fieldListText != "" ?$ArrayGroup['showlistfieldlist'] = $fieldListText:'';
	$nullListText != "" ?$ArrayGroup['showlistnull'] = $nullListText:'';
	$filterListText != "" ?$ArrayGroup['showlistfieldfilter'] = $filterListText:'';

	sizeof($searchadvList)>0?$searchADVListText = join(',',$searchadvList):'';
	sizeof($searchadvListFilter)>0?$searchADVListFilterText = join(',',$searchadvListFilter):'';
	$ADV_SEARCH_ARRAY['tablename'] = $_POST['Tablename'];
	$searchADVListText != "" ?$ADV_SEARCH_ARRAY['showlistfieldlist'] = $searchADVListText:'';
	$searchListText != "" ?$ADV_SEARCH_ARRAY['showlistfieldfilter'] = $searchADVListFilterText:'';


	sizeof($StopEditList)>0?$StopEditListText = join(',',$StopEditList):'';
	sizeof($StopDeleteList)>0?$StopDeleteListText = join(',',$StopDeleteList):'';
	$StopEditList != "" ?$ArrayGroup['showlistfieldstopedit'] = $StopEditListText:'';
	$StopDeleteList != "" ?$ArrayGroup['showlistfieldstopdelete'] = $StopDeleteListText:'';


	if($_POST['section']=="export_default"||$_POST['section']=="import_default")				{
		$ArrayGroup['group_filter'] = $_POST['group_filter'];;
	}
	if($section=="add_default"||$section=="edit_default")		{
		$privateListText != "" ?$ArrayGroup['showlistfieldprivate'] = $privateListText:'';
	}

	if($actionModel=="statistics")		{
		$typeListText != "" ?$ArrayGroup['showlistfieldtype'] = $typeListText:'';
	}
	//if($_POST['tablename'] != "")
		//$ArrayGroup['tablename'] = $_POST['tablename'];
	if($_POST['Tablename'] != "")
		$ArrayGroup['tablename'] = $_POST['Tablename'];



	//##############################################################################
	//数据形成文件区
	//##############################################################################

	$fileIni = parse_ini_file($filename,true);

	//形成高级搜索部分选项
	if($section=="init_default"||$section=="init_customer"||$section=="init_default2")		{
		$fileIni['exportadv_default'] = $ADV_SEARCH_ARRAY;//exit;
		//print_R($ADV_SEARCH_ARRAY);//exit;
		//判断如查有高级搜索内容,那么进行重新设置$ArrayGroup['action_model']的值
		if(sizeof($ADV_SEARCH_ARRAY)>2)			{
			//print_R($ADV_SEARCH_ARRAY);exit;
			$TEMP_SIZE_OF = stristr($ArrayGroup['action_model'],'exportadv_default:exportadv:x');
			if(!$TEMP_SIZE_OF)				{
				$ArrayGroup['action_model'] .= ",exportadv_default:exportadv:x";
			}
		}
		else	{
			$ArrayGroup_ARRAY = explode(',',$ArrayGroup['action_model']);
			//array_pop($ArrayGroup_ARRAY);
			$ArrayGroup['action_model'] = join(',',$ArrayGroup_ARRAY);
			//print_R($ArrayGroup['action_model']);exit;
		}

	}

	$fileIni[$section] = $ArrayGroup;//print_R($fileIni);exit;

	$sectionArray = array_keys($fileIni);
	for($i=0;$i<sizeof($sectionArray);$i++)			{
		$sectionName = $sectionArray[$i];
		$partArray = $fileIni[$sectionName];
		$partSectionArray = array_keys($partArray);
		$filetext .= "[".$sectionName."]\n";//print_R($partSectionArray);
		for($j=0;$j<sizeof($partSectionArray);$j++)	{
			$partsectionName = $partSectionArray[$j];
			$filetext .= $partsectionName." = ".$partArray[$partsectionName]."\n";
		}
		$filetext .= "\n";
	}
	$filetext=str_replace("(", "（",$filetext);
	$filetext=str_replace(")", "）",$filetext);
	//print $filetext;exit;
	if(is_file($goalfile))
		unlink($goalfile);
	$goalfile = $filename;
    @!$handle = fopen($goalfile, 'w');
	if (!fwrite($handle, $filetext)) {
			exit;
	}
	fclose($handle);
	echo "<META HTTP-EQUIV=REFRESH CONTENT='0;URL=?Tablename=".$_GET['Tablename']."&FileIniname=".$_GET['FileIniname']."&sectionName=".$_POST['section']."'>\n";
	exit;
}


if(!is_file($filename))		{
	print_infor("所选对象不存在");
	exit;
}
$file_ini = parse_ini_file($filename,true);
//print_R($file_ini);
$section_array = array_keys($file_ini);

$section_array1 = array();
array_push($section_array1,"html_etc");
//array_push($section_array1,"onlyinput");
//array_push($section_array1,"onlyedit");
//array_push($section_array1,"onlyread");

$section_array_Name = array(	"init_default"=>"初始管理视图",
								"init_customer"=>"初始只读视图",
								"delete_array"=>"删除视图",
								"export_default"=>"导出视图",
								"import_default"=>"导入视图",
								"add_default"=>"新增视图",
								"edit_default"=>"编辑视图",
								"view_default"=>"查看视图",
								"batchedit_default"=>"批量修改视图",
								"report_default"=>"常规报表视图",
								"reportsearch_default"=>"搜索报表视图",
								"statistics_default"=>"统计分析视图",
								"html_etc"=>"构建对象语言",
								//"onlyinput"=>"构建只输入对象",
								//"onlyedit"=>"构建只修改对象",
								//"onlyread"=>"构建只阅读对象"
							);

//##############################################################################
//INIT视图显示模块
//##############################################################################

if($_GET['sectionName']==""&&($_GET['action']=='init_default'||$_GET['action']==""))								{

print "<table border=1 cellspacing=0 class=small bordercolor=#000000 cellpadding=3 align=center width=100% style=\"border-collapse:collapse\">\n";

//系统默认模块
print "<TR><TD class=TableHeader align=left colSpan=6>&nbsp;系统默认模块 对象名称：".$_GET['FileIniname']."
</TD></TR>";
//<input type='button' value='注销此模块' class='SmallButton' title='注销此模块，不能恢复' onClick=\"location='?action=deleteModule&Tablename=".$_GET[Tablename]."'\"/>
for($i=0;$i<sizeof($section_array);$i++)		{
	if($i%6==0)		print "<TR>\n";
	print "<TD class=TableContent align=left colSpan=1>&nbsp;<a href=\"?Tablename=".$_GET['Tablename']."&FileIniname=".$_GET['FileIniname']."&sectionName=".$section_array[$i]."\">".$section_array_Name[(String)$section_array[$i]]."</a></TD>";
	//print "</TR>";
}
if($i>1&&$i%6!=0)											{
for($i=0;$i<6-sizeof($section_array)%6;$i++)		{
	print "<TD class=TableContent align=left colSpan=1>&nbsp;</TD>";
}
}

//判断是否有相应权限
if($addTablename) exit;

//系统附加模块--接口服务
print "<TR><TD class=TableHeader align=left colSpan=6>&nbsp;系统附加模块--接口服务 对象名称：".$_GET['Tablename']."</TD></TR>";
for($i=0;$i<sizeof($section_array1);$i++)		{
	print "<TR>\n";
	if($i==0)	$add = "";
	else		$add = "&action=doUserInterface";
	print "<TD class=TableContent align=left colSpan=1>&nbsp;<a href=\"?Tablename=".$_GET['Tablename']."&FileIniname=".$_GET['FileIniname']."&sectionName=".$section_array1[$i]."".$add."\">".$section_array_Name[(String)$section_array1[$i]]."</a></TD>";
	print "<TD class=TableContent align=left colSpan=5>&nbsp;".InterfaceService($section_array1[$i],$_GET['Tablename'])."</TD>";
	print "</TR>";
}
print "</table><BR>";


}//end Header

//初始化模块
$sectionName = $_GET['sectionName'];
$actionModelArray = explode('_',$sectionName);
$actionModel = $actionModelArray[0];
$sectionArray = $file_ini[(String)$_GET['sectionName']];
$GlobalModel = $actionModel;

$INIT_ARRAY = array("init","view","edit","add","delete","report","statistics","import","export","batchedit");
if(in_array($actionModel,$INIT_ARRAY))			{
print "\n<FORM name=form1 action=\"?Tablename=".$_GET['Tablename']."&FileIniname=".$_GET['FileIniname']."&sectionName=sectionName_data\" method=post encType=multipart/form-data>\n";
print "<input type=hidden name=sectionName value=sectionName_data>\n";
print "<input type=hidden name=section value=".$_GET['sectionName'].">\n";
print "<input type=hidden name=Tablename value=".$Tablerealname.">\n";
}

//print_R($sectionArray);
@$array_keys = array_keys($sectionArray);
if($actionModel=="init")			{
	$GlobalModel = $actionModel;
	sectionName1();
	//模块名称
	print "<TR><TD class=TableContent align=left width=20% colSpan=1>&nbsp;模块名称(ACTION值):</TD><TD class=TableContent align=left width=75% colSpan=1>&nbsp;<input name=tabletitle type=text class=SmallStatic size=55 readonly value=\"".$section_array_Name[(String)$_GET['sectionName']]."[".$_GET['sectionName']."]\"></TD></TR>";
	//对象名称
	print "<TR><TD class=TableContent align=left width=20% colSpan=1>&nbsp;对象名(表名:英文名):</TD><TD class=TableContent align=left width=75% colSpan=1>&nbsp;<input name=tabletitle type=text class=SmallInput size=55 value=\"".$sectionArray['tablename']."\"></TD></TR>";
	//对象标题
	if($sectionArray['tabletitle']!="")		{
		$ListTableName = $sectionArray['tabletitle'];
	}
	else	{
		$ListTableName = "list".$sectionArray['tablename'];
	}

	$sql = "select chinese from systemlang where tablename='$Tablerealname' and fieldname='$ListTableName'";
	$rs = $db->Execute($sql);
	$ListTableNameValue = $rs->fields['chinese'];
	print "<TR><TD class=TableContent align=left width=20% colSpan=1>&nbsp;对象列显示:</TD><TD class=TableContent align=left colSpan=1>&nbsp;<input name=tabletitle type=text class=SmallInput size=55 value=\"$ListTableName\">&nbsp;&nbsp;中文显示:<input name=tabletitlevalue type=text class=SmallInput size=30 value=\"$ListTableNameValue\"></TD></TR>";
	//表格宽度
	tablewidth();
	//列表显示
	$array = array("是"=>"1","否"=>"0");
	print "<TR><TD class=TableContent align=left width=20% colSpan=1>&nbsp;列表显示:</TD><TD class=TableContent align=left colSpan=1>&nbsp;\n";
	radio_array($array,"nullshow",$sectionArray['nullshow']);
	print "</TD></TR>";
	//双击反应
	$array = array("查看"=>"init_view","编辑"=>"init_edit");
	print "<TR><TD class=TableContent align=left width=20% colSpan=1>&nbsp;双击反应:</TD><TD class=TableContent align=left colSpan=1>&nbsp;\n";
	radio_array($array,"ondblclick_config",$sectionArray['ondblclick_config']);
	print "</TD></TR>";
	//模块动作
	//add_default:new:n,export_default:export:x,import_default:import:i
	$array = array("新增"=>"add_default:new:n","导出"=>"export_default:export:x","导入"=>"import_default:import:i");
	print "<TR><TD class=TableContent align=left width=20% colSpan=1>&nbsp;模块动作:</TD><TD class=TableContent align=left colSpan=1 nowrap>&nbsp;<input name=action_model type=text class=SmallInput size=110 value=\"".$sectionArray['action_model']."\">\n";
	//checkbox_array($array,"action_model",$sectionArray['action_model']);
	print "<BR>&nbsp;[示例 add_default:new:n,export_default:export:x,import_default:import:i]</TD></TR>";
	//行记录操作
	$array = array("查看"=>"view:view_default","编辑"=>"edit:edit_default","删除"=>"delete:delete_array");
	print "<TR><TD class=TableContent align=left width=20% colSpan=1>&nbsp;行记录操作:</TD><TD class=TableContent align=left nowrap colSpan=1>&nbsp;<input name=row_element type=text class=SmallInput size=55 value=\"".$sectionArray['row_element']."\">\n";
	//checkbox_array($array,"row_element",$sectionArray['row_element']);
	print "[示例 view:view_default,edit:edit_default,delete:delete_array]</TD></TR>";
	//底部记录操作
	//chooseall:chooseall,delete:delete_array,edit:edit,report:report
	$array = array("全选"=>"chooseall:chooseall","编辑"=>"edit:edit_default","删除"=>"delete:delete_array","报表"=>"report:report");
	print "<TR><TD class=TableContent align=left width=20% colSpan=1>&nbsp;底部记录操作:</TD><TD class=TableContent align=left colSpan=1 nowrap>&nbsp;<input name=bottom_element type=text class=SmallInput size=55 value=\"".$sectionArray['bottom_element']."\">\n";
	print "[示例 chooseall:chooseall,edit:edit_default,delete:delete_array]</TD></TR>";

	//排序部分生成
	//chooseall:chooseall,delete:delete_array,edit:edit,report:report
	print "<TR><TD class=TableContent align=left width=20% colSpan=1>&nbsp;排序部分生成:</TD><TD class=TableContent align=left colSpan=1>&nbsp;<input name=systemorder type=text class=SmallInput size=55 value=\"".$sectionArray['systemorder']."\">\n";
	print "[示例 1:asc,2:desc]</TD></TR>";

	//列表每页显示条数
	//chooseall:chooseall,delete:delete_array,edit:edit,report:report
	print "<TR><TD class=TableContent align=left width=20% colSpan=1>&nbsp;列表每页显示条数:</TD><TD class=TableContent align=left colSpan=1>&nbsp;<input name=pagenums_model type=text class=SmallInput size=55 value=\"".$sectionArray['pagenums_model']."\">\n";
	print "[示例 100或25,默认:25]</TD></TR>";

	//定义数量或是金额时使用
	//chooseall:chooseall,delete:delete_array,edit:edit,report:report
	print "<TR><TD class=TableContent align=left width=20% colSpan=1>&nbsp;数量或金额统计:</TD><TD class=TableContent align=left colSpan=1>&nbsp;<input name=UserSumFunction type=text class=SmallInput size=55 value=\"".$sectionArray['UserSumFunction']."\">\n";
	print "[填写(3或5)形成UserSumFunction=3 UserUnitFunction=RMB]</TD></TR>";

	//外键控制
	print "<TR><TD class=TableContent align=left width=20% colSpan=1>&nbsp;外键控制:</TD><TD class=TableContent align=left colSpan=1>&nbsp;<input name=ForeignKeyIndex type=text class=SmallInput size=55 value=\"".$sectionArray['ForeignKeyIndex']."\">\n";
	print "[填写(3:childrentable:1,3:childrentable:1) 如果字段3在childrentable表字段1中存在值,则会提示禁止删除]</TD></TR>";


	//字段主键属性数组
	primary_key();
	//唯一键操作
	unique_key();
	//###############################################################################
	//###############################################################################
	//###############################################################################
	//类型属性明细
	table_infor();
	print "</TD></TR>";

	//系统自动表自动信息
	//for($i=0;$i<sizeof($array_keys);$i++)		{
	//	$tabletitle = $array_keys[$i];
	//	print "<TR><TD class=TableContent align=left width=20% colSpan=1>&nbsp;".$tabletitle.":</TD><TD class=TableContent align=left colSpan=1>&nbsp;<input name=tabletitle type=text class=SmallInput size=55 value=\"".$sectionArray[$tabletitle]."\"></TD></TR>";
	//}
	//print "";
	//print "</table><BR>";

}

//##############################################################################
//Delete视图显示模块
//##############################################################################
if($actionModel=="delete")			{
	//print_R($common_html);
	sectionName1();
	$sectionArray = $file_ini[(String)$_GET['sectionName']];
	//print_R($sectionArray);
	$array_keys = array_keys($sectionArray);
	//对象名称
	tablename();
	primary_key();
	returnmodel();
	print "<TR><TD class=TableContent align=left width=20% colSpan=1>&nbsp;删除时是否强制输入密码:</TD><TD class=TableContent align=left colSpan=1>&nbsp;<input name=passwordcheck type=text class=SmallInput size=55 value=\"".$sectionArray['passwordcheck']."\"><BR>\n";
	print "&nbsp;[默认条件下面直接删除,用0表示,强制删除时输入登录密码较难用1表示]</TD></TR>";

}
//##############################################################################
//export视图显示模块
//##############################################################################
if($actionModel=="export")				{
	sectionName1();
	$sectionArray = $file_ini[(String)$_GET['sectionName']];
	
	$array_keys = array_keys($sectionArray);
	//对象名称
	tablename();
	//对象标题
	tabletitle();
	tablewidth();
	primary_key();
	returnmodel();
	group_filter();
	showfield_radio();


}
//##############################################################################
//import视图显示模块
//##############################################################################
if($actionModel=="import")				{
	sectionName1();
	$sectionArray = $file_ini[(String)$_GET['sectionName']];
	//print_R($sectionArray);
	$array_keys = array_keys($sectionArray);
	//对象名称
	tablename();
	//对象标题
	tabletitle();
	tablewidth();
	primary_key();
	unique_key();
	returnmodel();
	showfield_radio();
}
//##############################################################################
//report视图显示模块
//##############################################################################
if($actionModel=="report")				{
	sectionName1();
	$sectionArray = $file_ini[(String)$_GET['sectionName']];
	//print_R($sectionArray);
	$array_keys = array_keys($sectionArray);
	//对象名称
	tablename();
	//对象标题
	tabletitle();
	tablewidth();
	primary_key();
	table_infor();
	//returnmodel();
	//showfield_radio();
}
//##############################################################################
//statistics视图显示模块
//##############################################################################
if($actionModel=="statistics")				{
	$GlobalModel = $actionModel;
	sectionName1();
	$sectionArray = $file_ini[(String)$_GET['sectionName']];
	//print_R($sectionArray);
	$array_keys = array_keys($sectionArray);
	//对象名称
	tablename();
	//对象标题
	tabletitle();
	tablewidth();
	primary_key();
	table_infor();
}
//##############################################################################
//ADD、EDIT、INIT视图显示模块
//##############################################################################
if($actionModel=="add"||$actionModel=="edit"||$actionModel=="view"||$actionModel=="batchedit")				{
	$GlobalModel = $actionModel;
	sectionName1();
	$sectionArray = $file_ini[(String)$_GET['sectionName']];
	//print_R($sectionArray);
	$array_keys = array_keys($sectionArray);
	//对象名称
	tablename();
	//对象标题
	tabletitle();
	tablewidth();
	action_submit();
	primary_key();
	if($actionModel=="view")
		detailTable_key();
	unique_key();
	returnmodel();
	table_infor();
}

//##############################################################################
//语言表信息显示模块
//##############################################################################

if($_GET['sectionName']=="html_etc")			{
	$sql = "select * from systemlang where tablename = '".strtolower($Tablename)."'";
	$rs = $db->Execute($sql);
	$rs_a = $rs->GetArray();
	//print_R($rs_a);
	for($i=0;$i<sizeof($rs_a);$i++)			{
		$TempArray = $rs_a[$i];
		$fieldName = $TempArray['fieldname'];
		$NewArray[$fieldName] = $TempArray;
	}
	print "<FORM name=form1 action=\"?Tablename=".$_GET['Tablename']."&FileIniname=".$_GET['FileIniname']."&sectionName=html_etc_data\" method=post encType=multipart/form-data>";
	print "<table border=1 cellspacing=0 class=small bordercolor=#000000 cellpadding=3 align=center width=600 style='border-collapse:collapse'>\n";
	print "<TR><TD class=TableHeader align=left colSpan=10>&nbsp;语言信息编辑</TD></TR>\n";
	print "<TR><TD class=TableContent align=left colSpan=1>&nbsp;字段名称</TD><TD class=TableContent align=left colSpan=1>&nbsp;索引信息</TD><TD class=TableContent align=left colSpan=1>&nbsp;中文信息</TD><TD class=TableContent align=left colSpan=1>&nbsp;英文信息</TD></TR>\n";
	$columnsList = $columns;
	array_push($columnsList,strtolower($Tablename));
	array_push($columnsList,"list".strtolower($Tablename));
	array_push($columnsList,"new".strtolower($Tablename));
	array_push($columnsList,"edit".strtolower($Tablename));
	array_push($columnsList,"view".strtolower($Tablename));
	array_push($columnsList,"import".strtolower($Tablename));
	array_push($columnsList,"export".strtolower($Tablename));
	array_push($columnsList,"report".strtolower($Tablename));
	array_push($columnsList,"statistics".strtolower($Tablename));

	$sql	= "SHOW TABLE STATUS FROM $userdb LIKE '".strtolower($Tablename)."%'";
	$rs		= $db->CacheExecute(150,$sql);
	$Comment = $rs->fields['Comment'];
	$CommentArray = explode(';',$Comment);
	$Comment = $CommentArray[0];
	//print $Comment;

	$NewArray2[strtolower($Tablename)]['chinese']			= $Comment;
	$NewArray2["list".strtolower($Tablename)]['chinese']	= $Comment."列表";
	$NewArray2["new".strtolower($Tablename)]['chinese']		= "新增".$Comment;
	$NewArray2["edit".strtolower($Tablename)]['chinese']	= "编辑".$Comment;
	$NewArray2["view".strtolower($Tablename)]['chinese']	= "查阅".$Comment;
	$NewArray2["import".strtolower($Tablename)]['chinese']	= $Comment."导入";
	$NewArray2["export".strtolower($Tablename)]['chinese']	= $Comment."导出";
	$NewArray2["report".strtolower($Tablename)]['chinese']	= $Comment."报表";
	$NewArray2["statistics".strtolower($Tablename)]['chinese'] = $Comment."统计";

	//$MetaColumns = $db->MetaColumns(strtolower($Tablename));
	//print_R($NewArray);

	for($i=0;$i<sizeof($columnsList);$i++)		{
		$indexName = $columnsList[$i];
		if($NewArray[$indexName]['chinese']=="")	{

			if($NewArray2[$indexName]['chinese']!="") {
				$indexName2 = $NewArray2[$indexName]['chinese'];
			}
			else	{
				$indexName2 = $indexName;
			}
			$NewArray[$indexName]['chinese'] = $indexName2;
			//默认插入数据库部分
			$sql = "insert into systemlang values('','$indexName','$Tablename','$indexName2','$indexName2','');";
			$db->Execute($sql);
			//print $sql;
		}
		if($NewArray[$indexName]['english']=="")	{
			$NewArray[$indexName]['english'] = $indexName;
		}
		print "<TR>\n";
		print "<TD class=TableContent align=left colSpan=1 nowrap>&nbsp;字段[ $indexName ]:</TD>\n";
		print "<TD class=TableContent align=left colSpan=1 width=20%><input type=text size=15 class=SmallStatic name=".$indexName."_fieldname readonly value=".$NewArray[$indexName]['fieldname']."></TD>\n";
		print "<TD class=TableContent align=left colSpan=1 width=20%><input type=text size=15 class=SmallInput name=".$indexName."_chinese value=".$NewArray[$indexName]['chinese']."></TD>\n";
		print "<TD class=TableContent align=left colSpan=1 width=20%><input type=text size=15 class=SmallInput name=".$indexName."_english value=".$NewArray[$indexName]['english']."></TD>\n";
		print "</TR>\n";
	}
	print "<TR><TD class=TableContent align=center colSpan=10>&nbsp;<INPUT class=SmallButton title=语言信息编辑 type=submit value='语言信息编辑' size = 8 name=button>　<INPUT class=SmallButton onclick=\"location='?Tablename=$Tablename&FileIniname=".$_GET['FileIniname']."'\" type=button value='回到目录'></TD></TR>\n";
}

if($_GET['action']!="doUserInterface")
	print "</table></form>";
//##############################################################################
//语言表信息处理模块
//##############################################################################

if($_GET['sectionName']=="html_etc_data")				{
	$Tablename = $_GET['Tablename'];
	$columnsList = $columns;
	array_push($columnsList,strtolower($Tablename));
	array_push($columnsList,"list".strtolower($Tablename));
	array_push($columnsList,"new".strtolower($Tablename));
	array_push($columnsList,"edit".strtolower($Tablename));
	array_push($columnsList,"view".strtolower($Tablename));
	array_push($columnsList,"import".strtolower($Tablename));
	array_push($columnsList,"export".strtolower($Tablename));
	array_push($columnsList,"report".strtolower($Tablename));
	array_push($columnsList,"statistics".strtolower($Tablename));
	for($i=0;$i<sizeof($columnsList);$i++)		{
		$fieldname = $columnsList[$i];
		$chinese = $_POST[$fieldname."_chinese"];
		$english = $_POST[$fieldname."_english"];
		$selectSql = "select Count(*) as Num from systemlang where tablename = '$Tablename' and fieldname = '$fieldname'";
		$rs = $db->Execute($selectSql);
		$Num = $rs->fields['Num'];
		if($Num>0)			{
			$sql = "update systemlang set chinese = '$chinese',english = '$english' where tablename = '$Tablename' and fieldname = '$fieldname'";
		}
		else			{
			$sql = "insert into systemlang values('','".$fieldname."','".strtolower($Tablename)."','$chinese','$english','$chinese');";
		}
		if($chinese!="")		{
			//print $sql."<BR>";
			$db->Execute($sql);
			echo "<META HTTP-EQUIV=REFRESH CONTENT='0;URL=?Tablename=".$_GET['Tablename']."&FileIniname=".$_GET['FileIniname']."'> \n";
			//&sectionName=html_etc
		}
	}


}
//##############################################################################
//用户接口部分处理模块
//##############################################################################
if($_GET['action']=="doUserInterface"&&$_GET['Tablename']!=""&&$_GET['sectionName']!="")	{
	FormString($_GET['sectionName'],$_GET['Tablename']);
}
if($_GET['action']=="doUserInterfaceData"&&$_GET['Tablename']!=""&&$_GET['sectionName']!="")	{
	$sql = "select FUNC_ID from sys_function where FUNC_LINK ='".$_POST['FUNC_LINK']."'";
	$rs = $db->Execute($sql);
	if($rs->fields['FUNC_ID']!="")		{
		//更新语言表
		$sql = "update systemlang set chinese = '".$_POST['FUNC_NAME']."' , english = '".$_POST['ENGLISHNAME']."' , remark = '".$_POST['FUNC_NAME']."' where fieldname ='".$_POST['fieldname']."' and tablename ='".$_POST['tablename']."'";
		$db->Execute($sql);
		//更新菜单表
		$sql = "update sys_function set MENU_ID = '".$_POST['MENU_ID']."' , FUNC_NAME = '".$_POST['FUNC_NAME']."' , FUNC_CODE = '".$_POST['FUNC_CODE']."' , FUNC_LINK = '".$_POST['FUNC_LINK']."' , ENGLISHNAME = '".$_POST['ENGLISHNAME']."' where FUNC_ID ='".$rs->fields['FUNC_ID']."'";
		$db->Execute($sql);
	}
	else		{
		//插入语言表
		$sql = "insert into systemlang (fieldname,tablename,chinese,english,remark) values('".$_POST['fieldname']."','".$_POST['tablename']."','".$_POST['FUNC_NAME']."','".$_POST['ENGLISHNAME']."','".$_POST['FUNC_NAME']."');";
		$db->Execute($sql);
		//插入菜单表
		$sql = "insert into sys_function (FUNC_ID,MENU_ID,FUNC_NAME,FUNC_CODE,FUNC_LINK,ENGLISHNAME) values('".$_POST['FUNC_ID']."','".$_POST['MENU_ID']."','".$_POST['FUNC_NAME']."','".$_POST['FUNC_CODE']."','".$_POST['FUNC_LINK']."','".$_POST['ENGLISHNAME']."');";
		$db->Execute($sql);
		$Insert_ID = $db->Insert_ID();
	}
	//print $sql;exit;Insert_ID


	//&action=doUserInterface&sectionName=".$_GET['sectionName']."



	//返回到初始面面
	echo "<META HTTP-EQUIV=REFRESH CONTENT='0;URL=?Tablename=".$_GET['Tablename']."&FileIniname=".$_GET['FileIniname']."'> \n";
}


//##############################################################################
//注销模块
//##############################################################################
if($_GET['action']=="deleteModule"&&$Tablerealname!="")	{
	if(file_exists($filename))
		unlink($filename);
	print_infor("你已经注销此对象!");
	echo "<META HTTP-EQUIV=REFRESH CONTENT='1;URL=?'> \n";
}



//##############################################################################
//从新增视图导入模块
//##############################################################################
$ACTION_ARRAY = array("initimportfromaddview","init2importfromaddview","view2importfromaddview","viewimportfromaddview","editimportfromaddview","reportimportfromaddview","statisticsimportfromaddview","exportimportfromaddview","importimportfromaddview");

if(in_array($_GET['action'],$ACTION_ARRAY)&&$_GET['Tablename']!="")	{
	
	$fileIni = parse_ini_file($filename,true);
	switch($_GET['action'])			{
		case 'initimportfromaddview':
			$section = "init_default";
			$ImportSection = "add_default";
			break;
		case 'init2importfromaddview':
			$section = "init_customer";
			$ImportSection = "add_default";
			break;
		case 'editimportfromaddview':
			$section = "edit_default";
			$ImportSection = "add_default";
			break;
		case 'viewimportfromaddview':
			$section = "view_default";
			$ImportSection = "add_default";
			break;
		case 'exportimportfromaddview':
			$section = "export_default";
			$ImportSection = "add_default";
			break;
		case 'importimportfromaddview':
			$section = "import_default";
			$ImportSection = "add_default";
			break;
		case 'view2importfromaddview':
			$section = "batchedit_default";
			$ImportSection = "add_default";
			break;
		case 'reportimportfromaddview':
			$section = "report_default";
			$ImportSection = "view_default";
			break;
		case 'statisticsimportfromaddview':
			$section = "statistics_default";
			$ImportSection = "view_default";
			break;
	}

	$fileIni[$section]['showlistfieldlist'] = $fileIni[$ImportSection]['showlistfieldlist'];
	$fileIni[$section]['showlistnull'] = $fileIni[$ImportSection]['showlistnull'];
	$fileIni[$section]['showlistfieldfilter'] = $fileIni[$ImportSection]['showlistfieldfilter'];

	//print_R($fileIni);exit;
	$sectionArray = array_keys($fileIni);
	for($i=0;$i<sizeof($sectionArray);$i++)			{
		$sectionName = $sectionArray[$i];
		$partArray = $fileIni[$sectionName];
		$partSectionArray = array_keys($partArray);
		$filetext .= "[".$sectionName."]\n";//print_R($partSectionArray);
		for($j=0;$j<sizeof($partSectionArray);$j++)	{
			$partsectionName = $partSectionArray[$j];
			$filetext .= $partsectionName." = ".$partArray[$partsectionName]."\n";
		}
		$filetext .= "\n";
	}
	//print $filetext;exit;
	if(is_file($goalfile))
		unlink($goalfile);
	$goalfile = $filename;
	@!$handle = fopen($goalfile, 'w');
	if (!fwrite($handle, $filetext)) {
	exit;
	}
	fclose($handle);
	print "";
	echo "<META HTTP-EQUIV=REFRESH CONTENT='0;URL=?Tablename=".$_GET['Tablename']."&FileIniname=".$_GET['FileIniname']."&sectionName=".$section."'>\n";
	exit;

}
?>