<?php
header("Content-type:text/html;charset=gb2312");
ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL);
// display warnings and errors
error_reporting(E_WARNING | E_ERROR);
	
require_once("lib.inc.php");
require_once("class.dir.php");
page_css("Sunshine Anywhere ��ҵ�������ƽ̨ ���ɿ�������");

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
	//print_infor("��ѡ����Ҫ��������");
	exit;
}
if($_GET['actionAction']=="phpide")		{
	include "php_ide.php";
	exit;
}

//##############################################################################
//ϵͳ���ݱ�����ʼ����
//##############################################################################

//��ʼ��ģ��
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



//ϵͳ��ʼ������������
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
	//������Ϣ-checkbox
	$action_submit = returnCheckboxValue("action_submit");
	$action_submit!=""?$ArrayGroup['action_submit'] = $action_submit:'';

	//2009-12-28 �����Զ����б�����
	if($_POST['tabletitlevalue']!="")		{
		$sql = "select chinese from systemlang where tablename='".$_POST['Tablename']."' and fieldname='".$_POST['tabletitle']."'";
		$rs = $db->Execute($sql);
		$chineseֵ = $rs->fields['chinese'];
		if($chineseֵ!="")		{
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
	//��ȡ�ӱ�
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


	//�����ֶ��б���Ϣ
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
		
		
		//�õ��ֶ�����
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
					//��β��ΪHIDDEN,ͬʱ��Ҫ��HIDDENʱ����׷�Ӵ���Ϣ
					if(substr($fieldName_grouphidden_group_filter,-6)!="hidden"&&$fieldName_grouphidden)  {
						$fieldName_grouphidden_group_filter .= $grouphidden;
					}
					//Ϊ����ʱ,��û��Ҫ��HIDDEN,����Ҫ��HIDDENȥ��
					else if(substr($fieldName_grouphidden_group_filter,-6)=="hidden"&&!$fieldName_grouphidden)  {
						$fieldName_grouphidden_group_filter = substr($fieldName_grouphidden_group_filter,0,-7);
					}
					//�Ѿ����ڻ���������޸ĺ͸���
					array_push($groupList,$fieldName_index.":".$fieldName_grouphidden_group_filter);
				}
				else	{
					//������GROUP_FILTERʱ���еĴ�����
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
	//�����γ��ļ���
	//##############################################################################

	$fileIni = parse_ini_file($filename,true);

	//�γɸ߼���������ѡ��
	if($section=="init_default"||$section=="init_customer"||$section=="init_default2")		{
		$fileIni['exportadv_default'] = $ADV_SEARCH_ARRAY;//exit;
		//print_R($ADV_SEARCH_ARRAY);//exit;
		//�ж�����и߼���������,��ô������������$ArrayGroup['action_model']��ֵ
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
	$filetext=str_replace("(", "��",$filetext);
	$filetext=str_replace(")", "��",$filetext);
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
	print_infor("��ѡ���󲻴���");
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

$section_array_Name = array(	"init_default"=>"��ʼ������ͼ",
								"init_customer"=>"��ʼֻ����ͼ",
								"delete_array"=>"ɾ����ͼ",
								"export_default"=>"������ͼ",
								"import_default"=>"������ͼ",
								"add_default"=>"������ͼ",
								"edit_default"=>"�༭��ͼ",
								"view_default"=>"�鿴��ͼ",
								"batchedit_default"=>"�����޸���ͼ",
								"report_default"=>"���汨����ͼ",
								"reportsearch_default"=>"����������ͼ",
								"statistics_default"=>"ͳ�Ʒ�����ͼ",
								"html_etc"=>"������������",
								//"onlyinput"=>"����ֻ�������",
								//"onlyedit"=>"����ֻ�޸Ķ���",
								//"onlyread"=>"����ֻ�Ķ�����"
							);

//##############################################################################
//INIT��ͼ��ʾģ��
//##############################################################################

if($_GET['sectionName']==""&&($_GET['action']=='init_default'||$_GET['action']==""))								{

print "<table border=1 cellspacing=0 class=small bordercolor=#000000 cellpadding=3 align=center width=100% style=\"border-collapse:collapse\">\n";

//ϵͳĬ��ģ��
print "<TR><TD class=TableHeader align=left colSpan=6>&nbsp;ϵͳĬ��ģ�� �������ƣ�".$_GET['FileIniname']."
</TD></TR>";
//<input type='button' value='ע����ģ��' class='SmallButton' title='ע����ģ�飬���ָܻ�' onClick=\"location='?action=deleteModule&Tablename=".$_GET[Tablename]."'\"/>
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

//�ж��Ƿ�����ӦȨ��
if($addTablename) exit;

//ϵͳ����ģ��--�ӿڷ���
print "<TR><TD class=TableHeader align=left colSpan=6>&nbsp;ϵͳ����ģ��--�ӿڷ��� �������ƣ�".$_GET['Tablename']."</TD></TR>";
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

//��ʼ��ģ��
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
	//ģ������
	print "<TR><TD class=TableContent align=left width=20% colSpan=1>&nbsp;ģ������(ACTIONֵ):</TD><TD class=TableContent align=left width=75% colSpan=1>&nbsp;<input name=tabletitle type=text class=SmallStatic size=55 readonly value=\"".$section_array_Name[(String)$_GET['sectionName']]."[".$_GET['sectionName']."]\"></TD></TR>";
	//��������
	print "<TR><TD class=TableContent align=left width=20% colSpan=1>&nbsp;������(����:Ӣ����):</TD><TD class=TableContent align=left width=75% colSpan=1>&nbsp;<input name=tabletitle type=text class=SmallInput size=55 value=\"".$sectionArray['tablename']."\"></TD></TR>";
	//�������
	if($sectionArray['tabletitle']!="")		{
		$ListTableName = $sectionArray['tabletitle'];
	}
	else	{
		$ListTableName = "list".$sectionArray['tablename'];
	}

	$sql = "select chinese from systemlang where tablename='$Tablerealname' and fieldname='$ListTableName'";
	$rs = $db->Execute($sql);
	$ListTableNameValue = $rs->fields['chinese'];
	print "<TR><TD class=TableContent align=left width=20% colSpan=1>&nbsp;��������ʾ:</TD><TD class=TableContent align=left colSpan=1>&nbsp;<input name=tabletitle type=text class=SmallInput size=55 value=\"$ListTableName\">&nbsp;&nbsp;������ʾ:<input name=tabletitlevalue type=text class=SmallInput size=30 value=\"$ListTableNameValue\"></TD></TR>";
	//�����
	tablewidth();
	//�б���ʾ
	$array = array("��"=>"1","��"=>"0");
	print "<TR><TD class=TableContent align=left width=20% colSpan=1>&nbsp;�б���ʾ:</TD><TD class=TableContent align=left colSpan=1>&nbsp;\n";
	radio_array($array,"nullshow",$sectionArray['nullshow']);
	print "</TD></TR>";
	//˫����Ӧ
	$array = array("�鿴"=>"init_view","�༭"=>"init_edit");
	print "<TR><TD class=TableContent align=left width=20% colSpan=1>&nbsp;˫����Ӧ:</TD><TD class=TableContent align=left colSpan=1>&nbsp;\n";
	radio_array($array,"ondblclick_config",$sectionArray['ondblclick_config']);
	print "</TD></TR>";
	//ģ�鶯��
	//add_default:new:n,export_default:export:x,import_default:import:i
	$array = array("����"=>"add_default:new:n","����"=>"export_default:export:x","����"=>"import_default:import:i");
	print "<TR><TD class=TableContent align=left width=20% colSpan=1>&nbsp;ģ�鶯��:</TD><TD class=TableContent align=left colSpan=1 nowrap>&nbsp;<input name=action_model type=text class=SmallInput size=110 value=\"".$sectionArray['action_model']."\">\n";
	//checkbox_array($array,"action_model",$sectionArray['action_model']);
	print "<BR>&nbsp;[ʾ�� add_default:new:n,export_default:export:x,import_default:import:i]</TD></TR>";
	//�м�¼����
	$array = array("�鿴"=>"view:view_default","�༭"=>"edit:edit_default","ɾ��"=>"delete:delete_array");
	print "<TR><TD class=TableContent align=left width=20% colSpan=1>&nbsp;�м�¼����:</TD><TD class=TableContent align=left nowrap colSpan=1>&nbsp;<input name=row_element type=text class=SmallInput size=55 value=\"".$sectionArray['row_element']."\">\n";
	//checkbox_array($array,"row_element",$sectionArray['row_element']);
	print "[ʾ�� view:view_default,edit:edit_default,delete:delete_array]</TD></TR>";
	//�ײ���¼����
	//chooseall:chooseall,delete:delete_array,edit:edit,report:report
	$array = array("ȫѡ"=>"chooseall:chooseall","�༭"=>"edit:edit_default","ɾ��"=>"delete:delete_array","����"=>"report:report");
	print "<TR><TD class=TableContent align=left width=20% colSpan=1>&nbsp;�ײ���¼����:</TD><TD class=TableContent align=left colSpan=1 nowrap>&nbsp;<input name=bottom_element type=text class=SmallInput size=55 value=\"".$sectionArray['bottom_element']."\">\n";
	print "[ʾ�� chooseall:chooseall,edit:edit_default,delete:delete_array]</TD></TR>";

	//���򲿷�����
	//chooseall:chooseall,delete:delete_array,edit:edit,report:report
	print "<TR><TD class=TableContent align=left width=20% colSpan=1>&nbsp;���򲿷�����:</TD><TD class=TableContent align=left colSpan=1>&nbsp;<input name=systemorder type=text class=SmallInput size=55 value=\"".$sectionArray['systemorder']."\">\n";
	print "[ʾ�� 1:asc,2:desc]</TD></TR>";

	//�б�ÿҳ��ʾ����
	//chooseall:chooseall,delete:delete_array,edit:edit,report:report
	print "<TR><TD class=TableContent align=left width=20% colSpan=1>&nbsp;�б�ÿҳ��ʾ����:</TD><TD class=TableContent align=left colSpan=1>&nbsp;<input name=pagenums_model type=text class=SmallInput size=55 value=\"".$sectionArray['pagenums_model']."\">\n";
	print "[ʾ�� 100��25,Ĭ��:25]</TD></TR>";

	//�����������ǽ��ʱʹ��
	//chooseall:chooseall,delete:delete_array,edit:edit,report:report
	print "<TR><TD class=TableContent align=left width=20% colSpan=1>&nbsp;��������ͳ��:</TD><TD class=TableContent align=left colSpan=1>&nbsp;<input name=UserSumFunction type=text class=SmallInput size=55 value=\"".$sectionArray['UserSumFunction']."\">\n";
	print "[��д(3��5)�γ�UserSumFunction=3 UserUnitFunction=RMB]</TD></TR>";

	//�������
	print "<TR><TD class=TableContent align=left width=20% colSpan=1>&nbsp;�������:</TD><TD class=TableContent align=left colSpan=1>&nbsp;<input name=ForeignKeyIndex type=text class=SmallInput size=55 value=\"".$sectionArray['ForeignKeyIndex']."\">\n";
	print "[��д(3:childrentable:1,3:childrentable:1) ����ֶ�3��childrentable���ֶ�1�д���ֵ,�����ʾ��ֹɾ��]</TD></TR>";


	//�ֶ�������������
	primary_key();
	//Ψһ������
	unique_key();
	//###############################################################################
	//###############################################################################
	//###############################################################################
	//����������ϸ
	table_infor();
	print "</TD></TR>";

	//ϵͳ�Զ����Զ���Ϣ
	//for($i=0;$i<sizeof($array_keys);$i++)		{
	//	$tabletitle = $array_keys[$i];
	//	print "<TR><TD class=TableContent align=left width=20% colSpan=1>&nbsp;".$tabletitle.":</TD><TD class=TableContent align=left colSpan=1>&nbsp;<input name=tabletitle type=text class=SmallInput size=55 value=\"".$sectionArray[$tabletitle]."\"></TD></TR>";
	//}
	//print "";
	//print "</table><BR>";

}

//##############################################################################
//Delete��ͼ��ʾģ��
//##############################################################################
if($actionModel=="delete")			{
	//print_R($common_html);
	sectionName1();
	$sectionArray = $file_ini[(String)$_GET['sectionName']];
	//print_R($sectionArray);
	$array_keys = array_keys($sectionArray);
	//��������
	tablename();
	primary_key();
	returnmodel();
	print "<TR><TD class=TableContent align=left width=20% colSpan=1>&nbsp;ɾ��ʱ�Ƿ�ǿ����������:</TD><TD class=TableContent align=left colSpan=1>&nbsp;<input name=passwordcheck type=text class=SmallInput size=55 value=\"".$sectionArray['passwordcheck']."\"><BR>\n";
	print "&nbsp;[Ĭ����������ֱ��ɾ��,��0��ʾ,ǿ��ɾ��ʱ�����¼���������1��ʾ]</TD></TR>";

}
//##############################################################################
//export��ͼ��ʾģ��
//##############################################################################
if($actionModel=="export")				{
	sectionName1();
	$sectionArray = $file_ini[(String)$_GET['sectionName']];
	
	$array_keys = array_keys($sectionArray);
	//��������
	tablename();
	//�������
	tabletitle();
	tablewidth();
	primary_key();
	returnmodel();
	group_filter();
	showfield_radio();


}
//##############################################################################
//import��ͼ��ʾģ��
//##############################################################################
if($actionModel=="import")				{
	sectionName1();
	$sectionArray = $file_ini[(String)$_GET['sectionName']];
	//print_R($sectionArray);
	$array_keys = array_keys($sectionArray);
	//��������
	tablename();
	//�������
	tabletitle();
	tablewidth();
	primary_key();
	unique_key();
	returnmodel();
	showfield_radio();
}
//##############################################################################
//report��ͼ��ʾģ��
//##############################################################################
if($actionModel=="report")				{
	sectionName1();
	$sectionArray = $file_ini[(String)$_GET['sectionName']];
	//print_R($sectionArray);
	$array_keys = array_keys($sectionArray);
	//��������
	tablename();
	//�������
	tabletitle();
	tablewidth();
	primary_key();
	table_infor();
	//returnmodel();
	//showfield_radio();
}
//##############################################################################
//statistics��ͼ��ʾģ��
//##############################################################################
if($actionModel=="statistics")				{
	$GlobalModel = $actionModel;
	sectionName1();
	$sectionArray = $file_ini[(String)$_GET['sectionName']];
	//print_R($sectionArray);
	$array_keys = array_keys($sectionArray);
	//��������
	tablename();
	//�������
	tabletitle();
	tablewidth();
	primary_key();
	table_infor();
}
//##############################################################################
//ADD��EDIT��INIT��ͼ��ʾģ��
//##############################################################################
if($actionModel=="add"||$actionModel=="edit"||$actionModel=="view"||$actionModel=="batchedit")				{
	$GlobalModel = $actionModel;
	sectionName1();
	$sectionArray = $file_ini[(String)$_GET['sectionName']];
	//print_R($sectionArray);
	$array_keys = array_keys($sectionArray);
	//��������
	tablename();
	//�������
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
//���Ա���Ϣ��ʾģ��
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
	print "<TR><TD class=TableHeader align=left colSpan=10>&nbsp;������Ϣ�༭</TD></TR>\n";
	print "<TR><TD class=TableContent align=left colSpan=1>&nbsp;�ֶ�����</TD><TD class=TableContent align=left colSpan=1>&nbsp;������Ϣ</TD><TD class=TableContent align=left colSpan=1>&nbsp;������Ϣ</TD><TD class=TableContent align=left colSpan=1>&nbsp;Ӣ����Ϣ</TD></TR>\n";
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
	$NewArray2["list".strtolower($Tablename)]['chinese']	= $Comment."�б�";
	$NewArray2["new".strtolower($Tablename)]['chinese']		= "����".$Comment;
	$NewArray2["edit".strtolower($Tablename)]['chinese']	= "�༭".$Comment;
	$NewArray2["view".strtolower($Tablename)]['chinese']	= "����".$Comment;
	$NewArray2["import".strtolower($Tablename)]['chinese']	= $Comment."����";
	$NewArray2["export".strtolower($Tablename)]['chinese']	= $Comment."����";
	$NewArray2["report".strtolower($Tablename)]['chinese']	= $Comment."����";
	$NewArray2["statistics".strtolower($Tablename)]['chinese'] = $Comment."ͳ��";

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
			//Ĭ�ϲ������ݿⲿ��
			$sql = "insert into systemlang values('','$indexName','$Tablename','$indexName2','$indexName2','');";
			$db->Execute($sql);
			//print $sql;
		}
		if($NewArray[$indexName]['english']=="")	{
			$NewArray[$indexName]['english'] = $indexName;
		}
		print "<TR>\n";
		print "<TD class=TableContent align=left colSpan=1 nowrap>&nbsp;�ֶ�[ $indexName ]:</TD>\n";
		print "<TD class=TableContent align=left colSpan=1 width=20%><input type=text size=15 class=SmallStatic name=".$indexName."_fieldname readonly value=".$NewArray[$indexName]['fieldname']."></TD>\n";
		print "<TD class=TableContent align=left colSpan=1 width=20%><input type=text size=15 class=SmallInput name=".$indexName."_chinese value=".$NewArray[$indexName]['chinese']."></TD>\n";
		print "<TD class=TableContent align=left colSpan=1 width=20%><input type=text size=15 class=SmallInput name=".$indexName."_english value=".$NewArray[$indexName]['english']."></TD>\n";
		print "</TR>\n";
	}
	print "<TR><TD class=TableContent align=center colSpan=10>&nbsp;<INPUT class=SmallButton title=������Ϣ�༭ type=submit value='������Ϣ�༭' size = 8 name=button>��<INPUT class=SmallButton onclick=\"location='?Tablename=$Tablename&FileIniname=".$_GET['FileIniname']."'\" type=button value='�ص�Ŀ¼'></TD></TR>\n";
}

if($_GET['action']!="doUserInterface")
	print "</table></form>";
//##############################################################################
//���Ա���Ϣ����ģ��
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
//�û��ӿڲ��ִ���ģ��
//##############################################################################
if($_GET['action']=="doUserInterface"&&$_GET['Tablename']!=""&&$_GET['sectionName']!="")	{
	FormString($_GET['sectionName'],$_GET['Tablename']);
}
if($_GET['action']=="doUserInterfaceData"&&$_GET['Tablename']!=""&&$_GET['sectionName']!="")	{
	$sql = "select FUNC_ID from sys_function where FUNC_LINK ='".$_POST['FUNC_LINK']."'";
	$rs = $db->Execute($sql);
	if($rs->fields['FUNC_ID']!="")		{
		//�������Ա�
		$sql = "update systemlang set chinese = '".$_POST['FUNC_NAME']."' , english = '".$_POST['ENGLISHNAME']."' , remark = '".$_POST['FUNC_NAME']."' where fieldname ='".$_POST['fieldname']."' and tablename ='".$_POST['tablename']."'";
		$db->Execute($sql);
		//���²˵���
		$sql = "update sys_function set MENU_ID = '".$_POST['MENU_ID']."' , FUNC_NAME = '".$_POST['FUNC_NAME']."' , FUNC_CODE = '".$_POST['FUNC_CODE']."' , FUNC_LINK = '".$_POST['FUNC_LINK']."' , ENGLISHNAME = '".$_POST['ENGLISHNAME']."' where FUNC_ID ='".$rs->fields['FUNC_ID']."'";
		$db->Execute($sql);
	}
	else		{
		//�������Ա�
		$sql = "insert into systemlang (fieldname,tablename,chinese,english,remark) values('".$_POST['fieldname']."','".$_POST['tablename']."','".$_POST['FUNC_NAME']."','".$_POST['ENGLISHNAME']."','".$_POST['FUNC_NAME']."');";
		$db->Execute($sql);
		//����˵���
		$sql = "insert into sys_function (FUNC_ID,MENU_ID,FUNC_NAME,FUNC_CODE,FUNC_LINK,ENGLISHNAME) values('".$_POST['FUNC_ID']."','".$_POST['MENU_ID']."','".$_POST['FUNC_NAME']."','".$_POST['FUNC_CODE']."','".$_POST['FUNC_LINK']."','".$_POST['ENGLISHNAME']."');";
		$db->Execute($sql);
		$Insert_ID = $db->Insert_ID();
	}
	//print $sql;exit;Insert_ID


	//&action=doUserInterface&sectionName=".$_GET['sectionName']."



	//���ص���ʼ����
	echo "<META HTTP-EQUIV=REFRESH CONTENT='0;URL=?Tablename=".$_GET['Tablename']."&FileIniname=".$_GET['FileIniname']."'> \n";
}


//##############################################################################
//ע��ģ��
//##############################################################################
if($_GET['action']=="deleteModule"&&$Tablerealname!="")	{
	if(file_exists($filename))
		unlink($filename);
	print_infor("���Ѿ�ע���˶���!");
	echo "<META HTTP-EQUIV=REFRESH CONTENT='1;URL=?'> \n";
}



//##############################################################################
//��������ͼ����ģ��
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