<?php
function pageHeader()				{
	$Tablename = $_GET['Tablename'];
	global $SYSTEM_ALL_MODE_TEXT,$SYSTEM_MODE_DIR;
	//print $SYSTEM_ALL_MODE;
	$SYSTEM_ALL_MODE_ARRAY = explode(',',$SYSTEM_ALL_MODE_TEXT);
	print "<table border=1 cellspacing=0 class=small bordercolor=#000000 cellpadding=3 align=center width=100% style=\"border-collapse:collapse\">
	<tr class=TableContent>
	<td nowrap align=left colspan=1 width=25%><font color=green><B>
	��ǰģ��Ŀ¼:".$SYSTEM_MODE_DIR."";
	//print " ȫ��:";
	//for($i=0;$i<sizeof($SYSTEM_ALL_MODE_ARRAY);$i++)							{
		//$SYSTEM_ALL_MODE_NAME = $SYSTEM_ALL_MODE_ARRAY[$i];
		//print "<a href=\"?MakeSystemModel=$SYSTEM_ALL_MODE_NAME&actionAction=phpide\">$SYSTEM_ALL_MODE_NAME</a> ";
	//}
	print "</B></font></td>
	<td nowrap align=left colspan=1 width=25%><a href=\"?actionAction=phpide\">ģ�ͳ�ʼ����(�������ݱ�)</a></td>
	<td nowrap align=left colspan=1 width=25%><a href=\"?action=action_init\">�Ѿ����ɵ�ģ��(��ǰģ��:$SYSTEM_MODE_DIR)</a></td>
	<td nowrap align=left colspan=1 width=25%><a href=\"../Framework/systemlang_newai.php\" target=_blank>��ϵͳ����༭��</a></td>
	<td nowrap align=left colspan=1 width=25%><a href=\"../../../phpmyadmin/tbl_properties_structure.php?db=TD_OA&table=$Tablename\" target=_blank>��PHPMYADMIN����򿪵�ǰ��</a></td>
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
//ҵ���������--��ʼ#################################################################
//###################################################################################
//���������
//����INI�ļ������ж϶����Ƿ���ڡ�
$d=new PHP_Dir();
global $SYSTEM_MODE_DIR;
global $dirlist;
$dirlist .= $SYSTEM_MODE_DIR."/Model/";
$file=$d->list_files($dirlist);
$dir=$d->list_dirs($dirlist);
$j=1;
//��һ�й̶���INI�ļ����б�������,�����̶���
//�����γ���
$Parent_MENUID = "02";
$All = sizeof($file['filename']);
$MENU_ARRAY = array();
for($i=0;$i<sizeof($file['filename']);$i++)			{
	$fileName = $file['filename'][$i];
	$fileNameArray = explode('_',$fileName);
	array_pop($fileNameArray);
	$fileName = join('_',$fileNameArray);
	//�˵�ID�γ�
	strlen($i)==1?$MENU_ID=$Parent_MENUID."0".$i:$MENU_ID=$Parent_MENUID.$i;
	//���������˵��γ�--�������γɲ���
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
//ҵ���������--����#################################################################
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





//�ж��Ƿ��Ѿ���ɽӿڷ���
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
		$infor .= "״̬����ɡ�";
		$infor .= "��������".$ObjectName."��";
		$infor .= "����ʱ�䣺".date("Y-m-d m:i:s",filectime($DirName1))."��";
		$infor .= "<a href='?Tablename=$LinkName'>��������</a>";
	}
	else	{
		$infor .= "״̬��δ���!��";
	}
	if($Name =="html_etc")						{
	}
	else
		return $infor;
}



//�γɽӿڷ���
function FormString($Name,$ObjectName)				 {
	global $SystemModelName;
	switch($Name)				{
		case 'onlyinput':
			$FileName = $ObjectName."_input_newai.php";
			$FileIni = $ObjectName."_input_newai.ini";
			$IniModelName = "add_default";
			$Language = "ֻ����";
			break;
		case 'onlyedit':
			$FileName = $ObjectName."_edit_newai.php";
			$FileIni = $ObjectName."_edit_newai.ini";
			$IniModelName = "init_default";
			$Language = "ֻ�޸�";
			break;
		case 'onlyread':
			$FileName = $ObjectName."_read_newai.php";
			$FileIni = $ObjectName."_read_newai.ini";
			$IniModelName = "init_default";
			$Language = "ֻ�鿴";
			break;
	}
	$DirName1 = "../Interface/$SystemModelName/$FileName";
	$DirName2 = "../Interface/$SystemModelName/Model/$FileIni";
	$SourceFile = "../Interface/$SystemModelName/Model/".$ObjectName."_newai.ini";
	$File_Ini = parse_ini_file($SourceFile,true);
	$ModelArray = $File_Ini[$IniModelName];


	//����INI�ļ���ʼ
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
	//����INI�ļ�����

	//����INI�ļ��ı�
	$ModelText = "[".$IniModelName."]\n";
	$array_keys = array_keys($ModelArray);
	for($i=0;$i<sizeof($array_keys);$i++)			{
		$IndexName = $array_keys[$i];
		$ModelText .= $IndexName." = ".$ModelArray[$IndexName]."\n";
	}
	//print $ModelText;
	//����INTERFACE�ı�
	$FileText = FormInterfaceFile($Name,$ObjectName);
	//print $FileText;
	//д��INI�ļ�
	FormTextFile($DirName2,$ModelText);
	//д��INTERFACE�ļ�
	FormTextFile($DirName1,$FileText);


	//�ڶ����˵���Ȩ�޹���ģ�鲿��
	//���ݳ�ʼ��
	global $db;
	//�õ�MENU_IDֵ
	$sql = "select Min(MENU_ID) as Number from sys_function where FUNC_LINK like '%$ObjectName%'";
	$rs = $db->Execute($sql);
	$MENU_ID = $rs->fields['Number'];
	$MENU_ID = substr($MENU_ID,0,2);
	$sql = "select Max(MENU_ID) as Number from sys_function where MENU_ID like '$MENU_ID%'";
	$rs = $db->Execute($sql);
	$MENU_ID = $rs->fields['Number']+1;
	//�õ�����ֵ
	$sql = "select * from sys_function where FUNC_LINK like '%".$ObjectName."_newai.php%' order by MENU_ID asc";
	$rs = $db->Execute($sql);//print_R($rs->GetArray());
	//����
	//print $DirName1;
	//�жϸ����¼�Ƿ���ڣ�������ڣ�������޸ģ�������в��롣
	$sqls = "select *  from sys_function where FUNC_LINK ='".$DirName1."'";
	$rss = $db->Execute($sqls);//print $sqls;
	$rss->fields['FUNC_ID'];//print_R($rss->fields['FUNC_ID']);
	if($rss->fields['FUNC_ID']!="")		{
		$SubmitText = "�� ��";
		$MENU_ID = $rss->fields['MENU_ID'];
		$FUNC_LINK = $rss->fields['FUNC_LINK'];
		$FUNC_CODE = $rss->fields['FUNC_CODE'];
		$FUNC_NAME = $rss->fields['FUNC_NAME'];
		$ENGLISHNAME = $rss->fields['ENGLISHNAME'];
	}
	else			{
		$SubmitText = "�� ��";
		$FUNC_LINK = $DirName1;
		$FUNC_CODE = $rs->fields['FUNC_CODE'];
		$FUNC_NAME = $Language."".$rs->fields['FUNC_NAME'];
		$ENGLISHNAME = $Name." ".$rs->fields['ENGLISHNAME'];
	}//print $FUNC_LINK;

	print "<table border=1 cellspacing=0 class=small bordercolor=#000000 cellpadding=3 align=center width=100% style='border-collapse:collapse'>\n";
	print "<TR><TD class=TableHeader align=left colSpan=10>&nbsp;��ʾ��</TD></TR>\n";
	print "<TR><TD class=TableContent align=left colSpan=10>&nbsp;��һ�����ӿڲ����Ѿ����!</TD></TR>\n";
	print "</table><br>";

	print "<FORM name=form1 action=\"?Tablename=".$_GET['Tablename']."&action=doUserInterfaceData&sectionName=".$_GET['sectionName']."\" method=post encType=multipart/form-data>";
	print "<table border=1 cellspacing=0 class=small bordercolor=#000000 cellpadding=3 align=center width=100% style='border-collapse:collapse'>\n";
	print "<TR><TD class=TableHeader align=left colSpan=10>&nbsp;��ʾ���ڶ��������в˵����ֲ���</TD></TR>\n";
	print "<TR>
	<TD class=TableContent align=left colSpan=2>�˵���ţ�<input name=MENU_ID class=SmallInput size=20 value='".$MENU_ID."'></TD>
	<TD class=TableContent align=left colSpan=2>���ӵ�ַ��<input name=FUNC_LINK class=SmallInput size=45 value='".$FUNC_LINK."'></TD></TR>\n";
	print "<TD class=TableContent align=left colSpan=2>ͼ�����<input name=FUNC_CODE class=SmallInput size=20 value='".$FUNC_CODE."'></TD>
	<TD class=TableContent align=left colSpan=2>������Ϣ��<input name=FUNC_NAME class=SmallInput size=30 value='".$FUNC_NAME."'></TD></TR>\n";
	print "<TD class=TableContent align=left colSpan=2>Ӣ����Ϣ��<input name=ENGLISHNAME class=SmallInput size=30 value='".$ENGLISHNAME."'></TD>
	<TD class=TableContent align=left colSpan=2><INPUT class=SmallButton title=$SubmitText type=submit value='$SubmitText' size = 8 name=button></TD></TR>\n";
	print "<input name=fieldname type=hidden value='".$fieldname."'>\n";
	print "<input name=tablename type=hidden value='".$ObjectName."'>\n";
	//print "<TR><TD class=TableContent align=left colSpan=1>&nbsp;Ȩ�޹���</TD>
	//<TD class=TableContent align=left colSpan=6><input type=button onclick='' class=SmallButton size=10 value='��Ȩ�޵�����Ա'></TD></TR>\n";

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