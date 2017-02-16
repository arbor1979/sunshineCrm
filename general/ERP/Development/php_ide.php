<?php
require_once('lib.inc.php');
//page_css("PHP IDE ENV");
$tablename=$_GET['tablename'];
if(empty($tablename))	{
	$MetaTables = $db->MetaTables();
	//sort($MetaTables);
	//print_R($MetaTables);
	$JumpTable = array();
	array_push($JumpTable,"address");
	array_push($JumpTable,"address_group");
	array_push($JumpTable,"attend_config");
	array_push($JumpTable,"attend_duty");
	array_push($JumpTable,"attend_evection");
	array_push($JumpTable,"attend_leave");
	array_push($JumpTable,"attend_manager");
	array_push($JumpTable,"attend_out");
	array_push($JumpTable,"calendar");
	array_push($JumpTable,"file_content");
	array_push($JumpTable,"file_sort");
	array_push($JumpTable,"flow_form_type");
	array_push($JumpTable,"flow_process");
	array_push($JumpTable,"flow_run");
	array_push($JumpTable,"flow_run_data");
	array_push($JumpTable,"flow_run_prcs");
	array_push($JumpTable,"flow_type");
	array_push($JumpTable,"ip_rule");
	array_push($JumpTable,"linkman");
	array_push($JumpTable,"mobile_sms");
	array_push($JumpTable,"netdisk");
	array_push($JumpTable,"news");
	array_push($JumpTable,"news_comment");
	array_push($JumpTable,"webmail");
	array_push($JumpTable,"worklog");
	array_push($JumpTable,"sessions");
	array_push($JumpTable,"project_log");
	array_push($JumpTable,"post_tel");
	array_push($JumpTable,"poll_title");
	array_push($JumpTable,"poll_choice");


	table_begin("500");
	print_title("PHP���ɿ�������WEB��(ȫ����ͼ)",40);
	foreach($MetaTables as $list)		{
		//print $SYSTEM_MODE_DIR;
		if(in_array($list,$JumpTable))	{
		}
		else		{
		//�жϱ�����ĳһģ��
		$filename = $list.'_newai.php';
		if(file_exists("../Interface/$SYSTEM_MODE_DIR/$filename"))		{
			$ModuleName = $SYSTEM_MODE_DIR;
			$ModuleColor= "<font color=green>$SYSTEM_MODE_DIR</font> <a href='main.php?Tablename=$list&FileIniname=$list' target=_blank><font color=red>�������</font></a>";
		}
		else if(file_exists("../Framework/$filename"))		{
			$ModuleName = "Framework";
			$ModuleColor= "<font color=orange>Framework</font>";
		}
		else if(file_exists("../Interface/OA/$filename"))		{
			$ModuleName = "OAX";
			$ModuleColor= "<font color=red>OAX</font>";
		}
		else if(file_exists("../Interface/EDU/$filename"))		{
			$ModuleName = "EDU";
			$ModuleColor= "<font color=blank>EDU</font>";
		}
		else	{
			$ModuleName = "δ֪";
			$ModuleColor= "<font color=gray>δ֪</font>";
		}
		print "<tr class=TableData>";
		print "<td nowrap>$list</td>";
		print "<td nowrap>$ModuleColor</td>";
		print "<td nowrap><a href=\"?actionAction=phpide&tablename=$list&action=init&ModuleName=$ModuleName\">��ʼ���ļ�</a></td>";
		print "<td nowrap><a href=\"?actionAction=phpide&tablename=$list&action=tablestruct\"><font color=green>���ݱ�ṹ</font></a></td>";
		print "<td nowrap><a href=\"?actionAction=phpide&tablename=$list&action=tableData\"><font color=green>����������</font></a></td>";
		//print $list."��<a href=\"?tablename=$list&action=init\">��ʼ���ļ�</a> <a href=\"?tablename=$list&action=tablestruct\"><font color=green>���ݱ�ṹ</font></a> <a href=\"?tablename=$list&action=tableData\"><font color=green>����������</font></a><BR>";
		print "</Tr>";
		}//��������֪��
	}
	table_end();
	exit;
}
$mode=isset($_GET['mode'])?$_GET['mode']:0;




if($_GET['action']=='init')		{
	$content=config_content($tablename);
	global $SYSTEM_MODE_DIR;
	$filename="../Interface/".$SYSTEM_MODE_DIR."/Model/".$tablename."_newai.ini";

	table_begin("60%");
	print_title("PHP���ɿ�������WEB��--�ļ�д��",40);
	print "<tr class=TableData><td>";
	inputlanguage($tablename);
	write_newaifile($filename,$content,$mode);
	inputsystemtable($tablename);

	//д��tablename_newai.php�ļ�

	if($SYSTEM_MODE_DIR=="Teacher")		{
		$content	 =	"<?php
	ini_set('display_errors', 1);
	ini_set('error_reporting', E_ALL);
	error_reporting(E_WARNING | E_ERROR);

	require_once('lib.inc.php');
	Teacher_Sesssion2();

	if(\$_GET['���']==\"\"&&\$_SESSION['sunshine_teacher_banzhuren_class']!=\"\")		{
		\$_GET['���'] = \$_SESSION['sunshine_teacher_banzhuren_class'];
	}
	else if(\$_GET['���']==\"\")	{
		\$_GET['���'] = \"��������û�а༶��Ϣ\";
	}
	else	{
	}

	\$_GET['ѧ��״̬'] = \"����״̬\";

	";
	}

	else	{
		$content	 =	"<?php
	ini_set('display_errors', 1);
	ini_set('error_reporting', E_ALL);
	error_reporting(E_WARNING | E_ERROR);
	require_once('lib.inc.php');
	\$GLOBAL_SESSION=returnsession();
	";
	}

	$content	.=	"
	/*
	if(\$_GET['action']==\"add_default_data\")		{
		//print_R(\$_GET);print_R(\$_POST);//exit;
		global \$db;
		\$������� = (int)\$_POST['�������'];\$�̲ı�� = \$_POST['�̲ı��'];
		\$sql = \"update edu_jiaocai set ���п��=���п��+\$������� where �̲ı��='\".\$�̲ı��.\"'\";
		\$rs = \$db->Execute(\$sql);//print \$sql;exit;
		\$_POST['������'] = returntablefield(\"edu_jiaocai\",\"�̲ı��\",\$�̲ı��,\"������\");
		\$_POST['������'] = returntablefield(\"edu_jiaocai\",\"�̲ı��\",\$�̲ı��,\"������\");
		//print  \"<META HTTP-EQUIV=REFRESH CONTENT='0;URL=?'>\";
	}
	*/

	//���ݱ�ģ���ļ�,��ӦModelĿ¼�����".$tablename."_newai.ini�ļ�
	//�������Ҫ���ƴ�ģ��,����Ҫ�޸�\$parse_filename������ֵ,Ȼ���Ӧ��ModelĿ¼ ���ļ���_newai.ini�ļ�
	\$filetablename		=	'$tablename';
	\$parse_filename		=	'$tablename';
	require_once('include.inc.php');
	?>";
	$filename="../Interface/".$SYSTEM_MODE_DIR."/".$tablename."_newai.php";
	write_newaifile($filename,$content,$mode);

	/*
	$content="<?php\n\$filetablename='$tablename';\nrequire_once('../../Enginee/lib/init.php');\n\$_GET['action']=checkreadaction('init_customer');\nrequire_once('include.inc.php');\n?>";
	$filename="../Interface/".$SYSTEM_MODE_DIR."/".$tablename."_customer_newai.php";
	write_newaifile($filename,$content,$mode);
	*/

	print "</td></tr>";
	table_end();
	print "<BR><div align=center><input type=button class=SmallButton value=���� OnClick=\"location='?actionAction=phpide'\"></div>";
}

if($_GET['action']=='tablestruct')		{
	$META=$db->MetaColumns($_GET[tablename]);
	$i=1;
	$ColumnNames=array_keys($META);
	print "<table border=\"1\" cellspacing=\"0\" class=\"small\" bordercolor=\"#000000\" cellpadding=\"3\" align=\"center\" style=\"border-collapse:collapse\" width=60%>";
	print "<Tr class=TableHeader><Td nowrap colspan=40>���ݱ�����".$_GET[tablename]."</Td></Tr>\n";
	print "<Tr class=TableHeader>\n";
	print "<Td nowrap>������</Td>\n";
	print "<Td nowrap>������</Td>\n";
	print "<Td nowrap>�д�С</Td>\n";
	print "<Td nowrap>NOTNULL</Td>\n";
	print "<Td nowrap>�Ƿ�Ĭ��</Td>\n";
	print "<Td nowrap>Ĭ��ֵ</Td>\n";
	print "</Tr>\n";
	for($i=0;$i<sizeof($ColumnNames);$i++)		{
		$object=$META[(String)$ColumnNames[$i]];//print_R($object);
		print "<Tr class=TableData>\n";
		print "<Td nowrap>".$object->name."</Td>\n";
		print "<Td nowrap>".$object->type."</Td>\n";
		print "<Td nowrap>".$object->max_length."</Td>\n";
		print "<Td nowrap>".$object->not_null."</Td>\n";
		print "<Td nowrap>".$object->has_default."</Td>\n";
		print "<Td nowrap>".$object->default_value."</Td>\n";
		print "</Tr>\n";
	}
	print "</Table>\n";
	print "<BR><div align=center><input type=button class=SmallButton value=���� OnClick='history.back();'></div>";
}

//$sql="ALTER TABLE [user] MODIFY [DEPT_ID] [DEPT_ID] VARCHAR( 11 ) NOT NULL";
//$rs=$db->Execute($sql);
//print $rs->EOF;

if($_GET['action']=='tableData')		{
	$meta=$db->MetaColumnNames($_GET[tablename]);
	$meta = array_keys($meta);
	//print_R($meta);
	$sql="select * from ".$_GET['tablename']."";
	$rs=$db->selectLimit($sql,30,0);
	$rs_a=$rs->GetArray();
	print "<table border=\"1\" cellspacing=\"0\" class=\"small\" bordercolor=\"#000000\" cellpadding=\"3\" align=\"center\" style=\"border-collapse:collapse\" width=60%>";
	print "<Tr class=TableHeader><Td nowrap colspan=40>���ݱ�����".$_GET[tablename]."</Td></Tr>\n";
	print "<Tr class=TableHeader>\n";
	for($j=0;$j<sizeof($meta);$j++)		{
		print "<Td nowrap>".$meta[$j]."</Td>\n";
	}
	print "</Tr>\n";
	for($i=0;$i<sizeof($rs_a);$i++)		{
		print "<Tr class=TableData>\n";
		for($j=0;$j<sizeof($meta);$j++)		{
			print "<Td nowrap>".$rs_a[$i][(String)$meta[$j]]."</Td>\n";
		}
		print "</Tr>\n";
	}
	print "</Table>\n";
	print "<BR><div align=center><input type=button class=SmallButton value=���� OnClick='history.back();'></div>";
}





function config_content($tablename)		{
global $db;
$sql="select * from $tablename";
global $db;
$rs=$db->MetaColumnNames($tablename);
$rc=sizeof($rs);
for($i=1;$i<$rc;$i++)		{
	$fieldlist[$i]=$i;
	$listnull[$i]='null';
	$fieldfilter[$i]='input';
}
$showlistfieldlist=join(',',$fieldlist);
$showlistnull = join(',',$listnull);
$showlistfieldfilter = join(',',$fieldfilter);

$content="
[init_default]
tablename = $tablename
tabletitle = list$tablename
tablewidth = 100%
nullshow = 1
;ondblclick_config = init_view:edu_shoufeidan:1:1
action_model = add_default:new:n,export_default:export:x,import_default:import:i
row_element = view:view_default,edit:edit_default,delete:delete_array
bottom_element = chooseall:chooseall,delete:delete_array,edit:edit_default
action_search = $showlistfieldlist
;group_filter = 2:specialty:0:1
systemorder = 0:desc
pagenums_model = 25
primarykey = 0
uniquekey = 0
showlistfieldlist = $showlistfieldlist
showlistnull = $showlistnull
showlistfieldfilter = $showlistfieldfilter

[delete_array]
tablename = $tablename
primarykey = 0
returnmodel = init_default
passwordcheck = 0

[export_default]
tablename = $tablename
tabletitle = export$tablename
returnmodel = init_default
primarykey = 0
showlistfieldlist = 0,$showlistfieldlist
showlistfieldfilter = input,$showlistfieldfilter

[import_default]
tablename = $tablename
tabletitle = import$tablename
returnmodel = init_default
primarykey = 0
action_import_key = 0
showlistfieldlist = 0,$showlistfieldlist
showlistfieldfilter = input,$showlistfieldfilter

[add_default]
tablename = $tablename
tabletitle = new$tablename
action_submit = submit:save:s,cancel:cancel:c
primarykey = 0
uniquekey = 0
returnmodel = init_default
showlistfieldlist = $showlistfieldlist
showlistnull = $showlistnull
showlistfieldfilter = $showlistfieldfilter

[edit_default]
tablename = $tablename
tabletitle = edit$tablename
action_submit = submit:save:s,cancel:cancel:c
primarykey = 0
uniquekey = 0
returnmodel = init_default
showlistfieldlist = $showlistfieldlist
showlistnull = $showlistnull
showlistfieldfilter = $showlistfieldfilter

[view_default]
tablename = $tablename
tabletitle = view$tablename
action_submit = cancel:cancel:c,print:print:p,cancel:cancel:c
primarykey = 0
uniquekey = 0
isrechecked = 0
showlistfieldlist = $showlistfieldlist
showlistnull = $showlistnull
showlistfieldfilter = $showlistfieldfilter

";
return $content;
}







function write_newaifile($filename,$content,$mode=0)					{

if($mode==0)								{
if (!file_exists($filename)) {
    if (!$handle = fopen($filename, 'a+')) {
         print "���ܴ��ļ� $filename";
         exit;
    }
    if (!fwrite($handle, $content)) {
        print "����д�뵽�ļ� $filename";
        exit;
    }
    print "<font color=green>�ɹ��ؽ� $somecontent д�뵽�ļ�$filename</font><BR>";
    fclose($handle);
} else {
    print "<font color=red>�ļ� $filename �Ѿ�����</font><BR>";
}

}
else			{
	if (file_exists($filename))			unlink($filename);
	if (!$handle = fopen($filename, 'a+')) {
         print "���ܴ��ļ� $filename";
         exit;
    }
    if (!fwrite($handle, $content)) {
        print "����д�뵽�ļ� $filename";
        exit;
    }
    print "<font color=green>�ɹ��ؽ� $somecontent д�뵽�ļ�$filename</font><BR>";
    fclose($handle);
}

}




function inputlanguage($tablename)		{
global $db;
$sql="select * from $tablename";
global $db;
$rs=$db->MetaColumnNames($tablename);
$rs_status = $db->CacheExecute(150,"show table status");
$rs_status_a = $rs_status->GetArray();
for($i=0;$i<sizeof($rs_status_a);$i++)			{
	if($rs_status_a[$i]['Name']==$tablename)	{
		$Comment = $rs_status_a[$i]['Comment'];
	}
}

$CommentArray = explode(';',$Comment);
$Comment = $CommentArray[0];

if($Comment!="")		{
	$TableText = $Comment;
}
else	{
	print "��û���趨��:$tablename �ı�ע��,�����趨��ע��,�ٽ��г�ʼ��,<a href='http://192.168.0.1/phpmyadmin/tbl_properties_operations.php?db=TD_OA&table=$tablename&goto=tbl_properties_structure.php&back=tbl_properties_structure.php'>��������趨</a>";exit;
	$TableText = $tablename;
}



array_push($rs,$tablename);
array_push($rs,"list".$tablename);
array_push($rs,"new".$tablename);
array_push($rs,"edit".$tablename);
array_push($rs,"view".$tablename);
array_push($rs,"export".$tablename);
array_push($rs,"import".$tablename);
array_push($rs,"report".$tablename);
array_push($rs,"statistics".$tablename);

$TextArray[$tablename]['zh'] = $TableText;
$TextArray[$tablename]['en'] = $tablename;
$TextArray["list".$tablename]['zh'] = $TableText."�б�";
$TextArray["new".$tablename]['zh']	= "�½�".$TableText;
$TextArray["edit".$tablename]['zh'] = "�༭".$TableText;
$TextArray["view".$tablename]['zh'] = "�鿴".$TableText;
$TextArray["export".$tablename]['zh'] = "����".$TableText;
$TextArray["import".$tablename]['zh'] = "����".$TableText;
$TextArray["report".$tablename]['zh'] = $TableText."����";
$TextArray["statistics".$tablename]['zh'] = $TableText."ͳ��";

$TextArray["list".$tablename]['en'] = $tablename." list";
$TextArray["new".$tablename]['en']	= "New ".$tablename;
$TextArray["edit".$tablename]['en'] = "Edit ".$tablename;
$TextArray["view".$tablename]['en'] = "View ".$tablename;
$TextArray["export".$tablename]['en'] = "Export ".$tablename;
$TextArray["import".$tablename]['en'] = "Improt ".$tablename;
$TextArray["report".$tablename]['en'] = $tablename."Report";
$TextArray["statistics".$tablename]['en'] = $tablename."Statics";


foreach($rs as $list)			{
	if($TextArray[$list]['zh']=="")	{
		$TextArray[$list]['zh'] = $list;
		$TextArray[$list]['en'] = $list;
	}
	$sql_insert="insert into systemlang(fieldname,tablename,chinese,english) values('$list','$tablename','".$TextArray[$list]['zh']."','".$TextArray[$list]['en']."')";
	$sql_select="select count(*) as num from systemlang where fieldname='$list' and tablename='$tablename'";
	//print $sql_insert;
	$rss=$db->Execute($sql_select);
	if(!$rss->fields[num])	{
		$rs=$db->Execute($sql_insert);
		print "<font color=green>�ֶ�:".$TextArray[$list]['zh']."��	��".$tablename."���½��ɹ�</font><BR>";
	}
	else	{
		print "<font color=red>�ֶ�:".$TextArray[$list]['zh']."��	��".$tablename."���Ѿ�����</font><BR>";
	}
}
unset($rss);
unset($sql_insert);
unset($sql_select);
}

function inputsystemtable($tablename)		{
global $db;
$sql_insert="insert into systemtable(systemtablename) values('$tablename')";
$sql_select="select count(*) as num from systemtable where systemtablename='$tablename'";
$rss=$db->Execute($sql_select);
	if(!$rss->fields[num])	{
		$db->Execute($sql_insert);
		print "<font color=green>����ϵͳ���гɹ�</font><BR>";
	}
	else	{
		print "<font color=red>�Ѿ�������ϵͳ����</font><BR>";
	}
unset($rss);
unset($sql_insert);
unset($sql_select);
}

?>