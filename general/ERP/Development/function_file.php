<?php
function pageHeader()				{
	$Tablename = $_GET['Tablename'];
	global $SYSTEM_ALL_MODE_TEXT,$SYSTEM_MODE_DIR;
	//print $SYSTEM_ALL_MODE;
	$SYSTEM_ALL_MODE_ARRAY = explode(',',$SYSTEM_ALL_MODE_TEXT);
	print "<table border=1 cellspacing=0 class=small bordercolor=#000000 cellpadding=3 align=center width=100% style=\"border-collapse:collapse\">
	<tr class=TableContent>
	<td nowrap align=left colspan=1 width=25%><font color=green><B>
	当前模块目录:".$SYSTEM_MODE_DIR."";
	//print " 全部:";
	//for($i=0;$i<sizeof($SYSTEM_ALL_MODE_ARRAY);$i++)							{
		//$SYSTEM_ALL_MODE_NAME = $SYSTEM_ALL_MODE_ARRAY[$i];
		//print "<a href=\"?MakeSystemModel=$SYSTEM_ALL_MODE_NAME&actionAction=phpide\">$SYSTEM_ALL_MODE_NAME</a> ";
	//}
	print "</B></font></td>
	<td nowrap align=left colspan=1 width=25%><a href=\"?actionAction=phpide\">模型初始化表(所有数据表)</a></td>
	<td nowrap align=left colspan=1 width=25%><a href=\"?action=action_init\">已经生成的模型(当前模型:$SYSTEM_MODE_DIR)</a></td>
	<td nowrap align=left colspan=1 width=25%><a href=\"../Framework/systemlang_newai.php\" target=_blank>打开系统界面编辑器</a></td>
	<td nowrap align=left colspan=1 width=25%><a href=\"../../../phpmyadmin/tbl_properties_structure.php?db=TD_OA&table=$Tablename\" target=_blank>在PHPMYADMIN里面打开当前表</a></td>
	</tr></table><BR>
	";//http://localhost/
}


function pageHeaderModelInit($returnDirName,$number=8,$width=800)				{
	print "<table border=1 cellspacing=0 class=small bordercolor=#000000 cellpadding=3 align=center width=$width style=\"border-collapse:collapse\">";
	for($i=0;$i<sizeof($returnDirName);$i++)		{
		if($i%$number==0)
			print "<tr class=TableContent>\n";
		print "<td nowrap align=left colspan=1><font color=green><a href=\"".$returnDirName[$i]['FUNC_LINK']."\">".$returnDirName[$i]['FUNC_NAME']."</a>&nbsp;</font></td>\n";
	}
	print "</table>";
}

function pageHeaderModelInit2($returnDirName,$number=8,$width=800)				{
	print "<table border=1 cellspacing=0 class=small bordercolor=#000000 cellpadding=3 align=center width=$width style=\"border-collapse:collapse\">";
	print "<script>
		function SetUrl(URL)	{
			location = URL;
		}
		</script>";
	for($i=0;$i<sizeof($returnDirName);$i++)		{
		if($i%$number==0)
			print "<tr class=TableContent>\n";
		print "<td nowrap align=left colspan=1>

		<input type=button class=SmallButton value=".$returnDirName[$i]['FUNC_NAME']." onclick=\"location='".$returnDirName[$i]['FUNC_LINK']."'\">
		&nbsp;</font></td>\n";
		//<font color=green><a href=\"javascript:SetUrl('".$returnDirName[$i]['FUNC_LINK']."')\" target=_self>".$returnDirName[$i]['FUNC_NAME']."</a>
	}
	print "</table>";
}

function returnDirName()			{
//###################################################################################
//业务组件部分--开始#################################################################
//###################################################################################
//构建表对象
//根据INI文件进行判断对象是否存在。
$d=new PHP_Dir();
global $SYSTEM_MODE_DIR;
global $dirlist;
$dirlist .= $SYSTEM_MODE_DIR."/Model/";
$file=$d->list_files($dirlist);
$dir=$d->list_dirs($dirlist);
$j=1;
//第一行固定对INI文件进行表对象操作,方法固定。
//数据形成区
$Parent_MENUID = "02";
$All = sizeof($file['filename']);
$MENU_ARRAY = array();
for($i=0;$i<sizeof($file['filename']);$i++)			{
	$fileName = $file['filename'][$i];
	$fileNameArray = explode('_',$fileName);
	array_pop($fileNameArray);
	$fileName = join('_',$fileNameArray);
	//菜单ID形成
	strlen($i)==1?$MENU_ID=$Parent_MENUID."0".$i:$MENU_ID=$Parent_MENUID.$i;
	//检测第三级菜单形成--对象名形成部分
	$fileNameArray2 = $fileNameArray;
	$ObjectIndex = sizeof($fileNameArray2)-1;
	$ObjectLastName = $fileNameArray2[$ObjectIndex];
	if(($ObjectLastName=="input"||$ObjectLastName=="edit"||$ObjectLastName=="read")&&sizeof($fileNameArray2)>=2)		{
		array_pop($fileNameArray2);
		$ObjectName = join('_',$fileNameArray2);
	}
	else	{
		$ObjectName = join('_',$fileNameArray);
	}
	$ObjectName."<BR>";
	$TempMenuID[$ObjectName] == "" ? $TempMenuID[$ObjectName] = $MENU_ID : $MENU_ID = $TempMenuID[$ObjectName];

	$fileFullName = $dirlist.$fileName."_newai.ini";
	$fileFullName_input = $ObjectName."_input";
	$fileFullName_edit = $ObjectName."_edit";
	$fileFullName_read = $ObjectName."_read";

	$SYSTEM_FILE = parse_ini_file($fileFullName,true);
	$TRUE_TABLENAME = $SYSTEM_FILE['init_default']['tablename'];

	$rs_array[$i]['FUNC_NAME'] = returnFUNC_NAME($fileName,$ObjectName);
	$rs_array[$i]['FUNC_LINK'] = "main.php?Tablename=$TRUE_TABLENAME&FileIniname=$fileName";
}
return $rs_array;
}
//###################################################################################
//业务组件部分--结束#################################################################
//###################################################################################

function returnFUNC_NAME($fieldname,$tablename)			{
	global $db;
	$sql = "select * from systemlang where tablename = '$tablename' and fieldname = '$fieldname'";
	$rs = $db->Execute($sql);
	if($rs->fields['chinese']!="")		{
		$return = $rs->fields['chinese'];
	}
	else		{
		$sql = "select * from systemlang where tablename = 'common_html' and fieldname = '$fieldname'";
		$rs = $db->Execute($sql);
		if($rs->fields['chinese']!="")		{
			$return = $rs->fields['chinese'];
		}
		else
			$return = $fieldname;
	}
	return $return;
}





//判断是否已经完成接口服务
function InterfaceService($Name,$ObjectName)				 {
	global $SystemModelName;
	switch($Name)				{
		case 'onlyinput':
			$FileName = $ObjectName."_input_newai.php";
			$FileIni = $ObjectName."_input_newai.ini";
			$LinkName = $ObjectName."_input";
			break;
		case 'onlyedit':
			$FileName = $ObjectName."_edit_newai.php";
			$FileIni = $ObjectName."_edit_newai.ini";
			$LinkName = $ObjectName."_edit";
			break;
		case 'onlyread':
			$FileName = $ObjectName."_read_newai.php";
			$FileIni = $ObjectName."_read_newai.ini";
			$LinkName = $ObjectName."_read";
			break;
	}
	$DirName1 = "../Interface/$SystemModelName/$FileName";
	$DirName2 = "../Interface/$SystemModelName/Model/$FileIni";
	if(is_file($DirName1)&&is_file($DirName2))	{
		$infor .= "状态：完成　";
		$infor .= "对象名：".$ObjectName."　";
		$infor .= "更新时间：".date("Y-m-d m:i:s",filectime($DirName1))."　";
		$infor .= "<a href='?Tablename=$LinkName'>配置属性</a>";
	}
	else	{
		$infor .= "状态：未完成!　";
	}
	if($Name =="html_etc")						{
	}
	else
		return $infor;
}



//形成接口服务
function FormString($Name,$ObjectName)				 {
	global $SystemModelName;
	switch($Name)				{
		case 'onlyinput':
			$FileName = $ObjectName."_input_newai.php";
			$FileIni = $ObjectName."_input_newai.ini";
			$IniModelName = "add_default";
			$Language = "只输入";
			break;
		case 'onlyedit':
			$FileName = $ObjectName."_edit_newai.php";
			$FileIni = $ObjectName."_edit_newai.ini";
			$IniModelName = "init_default";
			$Language = "只修改";
			break;
		case 'onlyread':
			$FileName = $ObjectName."_read_newai.php";
			$FileIni = $ObjectName."_read_newai.ini";
			$IniModelName = "init_default";
			$Language = "只查看";
			break;
	}
	$DirName1 = "../Interface/$SystemModelName/$FileName";
	$DirName2 = "../Interface/$SystemModelName/Model/$FileIni";
	$SourceFile = "../Interface/$SystemModelName/Model/".$ObjectName."_newai.ini";
	$File_Ini = parse_ini_file($SourceFile,true);
	$ModelArray = $File_Ini[$IniModelName];


	//构建INI文件开始
	switch($Name)				{
		case 'onlyinput':
			$ModelArray['returnmodel'] = "add_default";
			$fieldname = $ObjectName."_input";
			break;
		case 'onlyedit':
			$ModelArray['action_model'] = '';
			$ModelArray['row_element'] = 'view:view_default,edit:edit_default';
			$ModelArray['bottom_element'] = 'chooseall:chooseall,edit:edit_default';
			$fieldname = $ObjectName."_edit";
			break;
		case 'onlyread':
			$ModelArray['action_model'] = '';
			$ModelArray['row_element'] = 'view:view_default';
			$ModelArray['bottom_element'] = '';
			$fieldname = $ObjectName."_read";
			break;
	}
	//print_R($ModelArray);

	//print "<BR>".$DirName1;
	//print "<BR>".$DirName2;
	//构建INI文件结束

	//构建INI文件文本
	$ModelText = "[".$IniModelName."]\n";
	$array_keys = array_keys($ModelArray);
	for($i=0;$i<sizeof($array_keys);$i++)			{
		$IndexName = $array_keys[$i];
		$ModelText .= $IndexName." = ".$ModelArray[$IndexName]."\n";
	}
	//print $ModelText;
	//构建INTERFACE文本
	$FileText = FormInterfaceFile($Name,$ObjectName);
	//print $FileText;
	//写入INI文件
	FormTextFile($DirName2,$ModelText);
	//写入INTERFACE文件
	FormTextFile($DirName1,$FileText);


	//第二步菜单与权限管理模块部分
	//数据初始化
	global $db;
	//得到MENU_ID值
	$sql = "select Min(MENU_ID) as Number from sys_function where FUNC_LINK like '%$ObjectName%'";
	$rs = $db->Execute($sql);
	$MENU_ID = $rs->fields['Number'];
	$MENU_ID = substr($MENU_ID,0,2);
	$sql = "select Max(MENU_ID) as Number from sys_function where MENU_ID like '$MENU_ID%'";
	$rs = $db->Execute($sql);
	$MENU_ID = $rs->fields['Number']+1;
	//得到语言值
	$sql = "select * from sys_function where FUNC_LINK like '%".$ObjectName."_newai.php%' order by MENU_ID asc";
	$rs = $db->Execute($sql);//print_R($rs->GetArray());
	//结束
	//print $DirName1;
	//判断该项记录是否存在，如果存在，则进行修改，否则进行插入。
	$sqls = "select *  from sys_function where FUNC_LINK ='".$DirName1."'";
	$rss = $db->Execute($sqls);//print $sqls;
	$rss->fields['FUNC_ID'];//print_R($rss->fields['FUNC_ID']);
	if($rss->fields['FUNC_ID']!="")		{
		$SubmitText = "修 改";
		$MENU_ID = $rss->fields['MENU_ID'];
		$FUNC_LINK = $rss->fields['FUNC_LINK'];
		$FUNC_CODE = $rss->fields['FUNC_CODE'];
		$FUNC_NAME = $rss->fields['FUNC_NAME'];
		$ENGLISHNAME = $rss->fields['ENGLISHNAME'];
	}
	else			{
		$SubmitText = "添 加";
		$FUNC_LINK = $DirName1;
		$FUNC_CODE = $rs->fields['FUNC_CODE'];
		$FUNC_NAME = $Language."".$rs->fields['FUNC_NAME'];
		$ENGLISHNAME = $Name." ".$rs->fields['ENGLISHNAME'];
	}//print $FUNC_LINK;

	print "<table border=1 cellspacing=0 class=small bordercolor=#000000 cellpadding=3 align=center width=100% style='border-collapse:collapse'>\n";
	print "<TR><TD class=TableHeader align=left colSpan=10>&nbsp;提示：</TD></TR>\n";
	print "<TR><TD class=TableContent align=left colSpan=10>&nbsp;第一步：接口部分已经完成!</TD></TR>\n";
	print "</table><br>";

	print "<FORM name=form1 action=\"?Tablename=".$_GET['Tablename']."&action=doUserInterfaceData&sectionName=".$_GET['sectionName']."\" method=post encType=multipart/form-data>";
	print "<table border=1 cellspacing=0 class=small bordercolor=#000000 cellpadding=3 align=center width=100% style='border-collapse:collapse'>\n";
	print "<TR><TD class=TableHeader align=left colSpan=10>&nbsp;提示：第二步：进行菜单部分操作</TD></TR>\n";
	print "<TR>
	<TD class=TableContent align=left colSpan=2>菜单编号：<input name=MENU_ID class=SmallInput size=20 value='".$MENU_ID."'></TD>
	<TD class=TableContent align=left colSpan=2>链接地址：<input name=FUNC_LINK class=SmallInput size=45 value='".$FUNC_LINK."'></TD></TR>\n";
	print "<TD class=TableContent align=left colSpan=2>图标对象：<input name=FUNC_CODE class=SmallInput size=20 value='".$FUNC_CODE."'></TD>
	<TD class=TableContent align=left colSpan=2>中文信息：<input name=FUNC_NAME class=SmallInput size=30 value='".$FUNC_NAME."'></TD></TR>\n";
	print "<TD class=TableContent align=left colSpan=2>英文信息：<input name=ENGLISHNAME class=SmallInput size=30 value='".$ENGLISHNAME."'></TD>
	<TD class=TableContent align=left colSpan=2><INPUT class=SmallButton title=$SubmitText type=submit value='$SubmitText' size = 8 name=button></TD></TR>\n";
	print "<input name=fieldname type=hidden value='".$fieldname."'>\n";
	print "<input name=tablename type=hidden value='".$ObjectName."'>\n";
	//print "<TR><TD class=TableContent align=left colSpan=1>&nbsp;权限管理</TD>
	//<TD class=TableContent align=left colSpan=6><input type=button onclick='' class=SmallButton size=10 value='加权限到管理员'></TD></TR>\n";

	print "</Table></form>";
}

function FormInterfaceFile($Name,$ObjectName)			{

	$Text = "<?php\n";
	$Text .= "\$filetablename='$ObjectName';\n";

	switch($Name)				{
		case 'onlyinput':
			$DepartName = "input";
			$Text .= "switch(\$_GET['action'])			{\n";
			$Text .= "	case 'add_default_data':\n";
			$Text .= "		break;\n";
			$Text .= "	default:\n";
			$Text .= "		\$_GET['action'] = \"add_default\";\n";
			$Text .= "}\n";
			break;
		case 'onlyedit':
			$DepartName = "edit";

			break;
		case 'onlyread':
			$DepartName = "read";

			break;
	}

	$Text .= "\$parse_filename = \"".$ObjectName."_".$DepartName."\";\n";
	$Text .= "require_once('include.inc.php');\n";
	$Text .= "?>\n";
	return $Text;
}

function FormTextFile($goalfile,$filetext)					{
	if(is_file($goalfile))
		unlink($goalfile);
	@!$handle = fopen($goalfile, 'w');
	if (!fwrite($handle, $filetext)) {
		exit;
	}
	fclose($handle);
}
?>