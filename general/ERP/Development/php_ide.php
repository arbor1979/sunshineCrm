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
	print_title("PHP集成开发环境WEB版(全局视图)",40);
	foreach($MetaTables as $list)		{
		//print $SYSTEM_MODE_DIR;
		if(in_array($list,$JumpTable))	{
		}
		else		{
		//判断表属于某一模块
		$filename = $list.'_newai.php';
		if(file_exists("../Interface/$SYSTEM_MODE_DIR/$filename"))		{
			$ModuleName = $SYSTEM_MODE_DIR;
			$ModuleColor= "<font color=green>$SYSTEM_MODE_DIR</font> <a href='main.php?Tablename=$list&FileIniname=$list' target=_blank><font color=red>点击配置</font></a>";
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
			$ModuleName = "未知";
			$ModuleColor= "<font color=gray>未知</font>";
		}
		print "<tr class=TableData>";
		print "<td nowrap>$list</td>";
		print "<td nowrap>$ModuleColor</td>";
		print "<td nowrap><a href=\"?actionAction=phpide&tablename=$list&action=init&ModuleName=$ModuleName\">初始化文件</a></td>";
		print "<td nowrap><a href=\"?actionAction=phpide&tablename=$list&action=tablestruct\"><font color=green>数据表结构</font></a></td>";
		print "<td nowrap><a href=\"?actionAction=phpide&tablename=$list&action=tableData\"><font color=green>返回数据行</font></a></td>";
		//print $list."　<a href=\"?tablename=$list&action=init\">初始化文件</a> <a href=\"?tablename=$list&action=tablestruct\"><font color=green>数据表结构</font></a> <a href=\"?tablename=$list&action=tableData\"><font color=green>返回数据行</font></a><BR>";
		print "</Tr>";
		}//结束－已知表
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
	print_title("PHP集成开发环境WEB版--文件写入",40);
	print "<tr class=TableData><td>";
	inputlanguage($tablename);
	write_newaifile($filename,$content,$mode);
	inputsystemtable($tablename);

	//写入tablename_newai.php文件

	if($SYSTEM_MODE_DIR=="Teacher")		{
		$content	 =	"<?php
	ini_set('display_errors', 1);
	ini_set('error_reporting', E_ALL);
	error_reporting(E_WARNING | E_ERROR);

	require_once('lib.inc.php');
	Teacher_Sesssion2();

	if(\$_GET['班号']==\"\"&&\$_SESSION['sunshine_teacher_banzhuren_class']!=\"\")		{
		\$_GET['班号'] = \$_SESSION['sunshine_teacher_banzhuren_class'];
	}
	else if(\$_GET['班号']==\"\")	{
		\$_GET['班号'] = \"所属下面没有班级信息\";
	}
	else	{
	}

	\$_GET['学生状态'] = \"正常状态\";

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
		\$入库数量 = (int)\$_POST['入库数量'];\$教材编号 = \$_POST['教材编号'];
		\$sql = \"update edu_jiaocai set 现有库存=现有库存+\$入库数量 where 教材编号='\".\$教材编号.\"'\";
		\$rs = \$db->Execute(\$sql);//print \$sql;exit;
		\$_POST['编作者'] = returntablefield(\"edu_jiaocai\",\"教材编号\",\$教材编号,\"编作者\");
		\$_POST['出版社'] = returntablefield(\"edu_jiaocai\",\"教材编号\",\$教材编号,\"出版社\");
		//print  \"<META HTTP-EQUIV=REFRESH CONTENT='0;URL=?'>\";
	}
	*/

	//数据表模型文件,对应Model目录下面的".$tablename."_newai.ini文件
	//如果是需要复制此模块,则需要修改\$parse_filename参数的值,然后对应到Model目录 新文件名_newai.ini文件
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
	print "<BR><div align=center><input type=button class=SmallButton value=返回 OnClick=\"location='?actionAction=phpide'\"></div>";
}

if($_GET['action']=='tablestruct')		{
	$META=$db->MetaColumns($_GET[tablename]);
	$i=1;
	$ColumnNames=array_keys($META);
	print "<table border=\"1\" cellspacing=\"0\" class=\"small\" bordercolor=\"#000000\" cellpadding=\"3\" align=\"center\" style=\"border-collapse:collapse\" width=60%>";
	print "<Tr class=TableHeader><Td nowrap colspan=40>数据表名：".$_GET[tablename]."</Td></Tr>\n";
	print "<Tr class=TableHeader>\n";
	print "<Td nowrap>列名称</Td>\n";
	print "<Td nowrap>列类型</Td>\n";
	print "<Td nowrap>列大小</Td>\n";
	print "<Td nowrap>NOTNULL</Td>\n";
	print "<Td nowrap>是否默认</Td>\n";
	print "<Td nowrap>默认值</Td>\n";
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
	print "<BR><div align=center><input type=button class=SmallButton value=返回 OnClick='history.back();'></div>";
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
	print "<Tr class=TableHeader><Td nowrap colspan=40>数据表名：".$_GET[tablename]."</Td></Tr>\n";
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
	print "<BR><div align=center><input type=button class=SmallButton value=返回 OnClick='history.back();'></div>";
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
         print "不能打开文件 $filename";
         exit;
    }
    if (!fwrite($handle, $content)) {
        print "不能写入到文件 $filename";
        exit;
    }
    print "<font color=green>成功地将 $somecontent 写入到文件$filename</font><BR>";
    fclose($handle);
} else {
    print "<font color=red>文件 $filename 已经存在</font><BR>";
}

}
else			{
	if (file_exists($filename))			unlink($filename);
	if (!$handle = fopen($filename, 'a+')) {
         print "不能打开文件 $filename";
         exit;
    }
    if (!fwrite($handle, $content)) {
        print "不能写入到文件 $filename";
        exit;
    }
    print "<font color=green>成功地将 $somecontent 写入到文件$filename</font><BR>";
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
	print "你没有设定表:$tablename 的表注释,请先设定表注释,再进行初始化,<a href='http://192.168.0.1/phpmyadmin/tbl_properties_operations.php?db=TD_OA&table=$tablename&goto=tbl_properties_structure.php&back=tbl_properties_structure.php'>点击进入设定</a>";exit;
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
$TextArray["list".$tablename]['zh'] = $TableText."列表";
$TextArray["new".$tablename]['zh']	= "新建".$TableText;
$TextArray["edit".$tablename]['zh'] = "编辑".$TableText;
$TextArray["view".$tablename]['zh'] = "查看".$TableText;
$TextArray["export".$tablename]['zh'] = "导出".$TableText;
$TextArray["import".$tablename]['zh'] = "导入".$TableText;
$TextArray["report".$tablename]['zh'] = $TableText."报表";
$TextArray["statistics".$tablename]['zh'] = $TableText."统计";

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
		print "<font color=green>字段:".$TextArray[$list]['zh']."　	在".$tablename."中新建成功</font><BR>";
	}
	else	{
		print "<font color=red>字段:".$TextArray[$list]['zh']."　	在".$tablename."中已经存在</font><BR>";
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
		print "<font color=green>插入系统表中成功</font><BR>";
	}
	else	{
		print "<font color=red>已经存在于系统表中</font><BR>";
	}
unset($rss);
unset($sql_insert);
unset($sql_select);
}

?>