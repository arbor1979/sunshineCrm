<?php
require_once("lib.inc.php");
print "<link rel='stylesheet' type='text/css' href='".ROOT_DIR."theme/9/style.css'>";
$common_html=returnsystemlang('common_html');



//输入新构建表名称
if($_GET['Tablename']==""&&$_GET['action']!="mktableField")		{
?>
<form method="post" action="?action=mktableField">
在数据库 sunshine20 中创建一个新表&nbsp;:<br />
名字&nbsp;:&nbsp;
<input type="text" name="Tablename" maxlength="64" class="SmallInput" />
        <br />
        字段数&nbsp;:&nbsp;
        <input type="text" name="num_fields" size="2" class="SmallInput" />
        &nbsp;<input type="submit" class=SmallButton value="执行" />
        </form>

<?php
exit;
}
if($_GET['action']=="mktableField")		{

	print "\n<FORM name=form1 action=\"?Tablename=".$_POST['Tablename']."&action=mktableFieldData\" method=post encType=multipart/form-data>\n";
	print "<table border=1 cellspacing=0 class=small width=550 bordercolor=#000000 cellpadding=3 align=center style=\"border-collapse:collapse\">\n";


	print "<TR>\n";
	print "<TD class=TableHeader nowrap colSpan=6>&nbsp;表名：".$_POST['Tablename']."</TD>";
	print "</TR>\n";
	print "<TR>\n";
	print "<TD class=TableHeader nowrap colSpan=1>属性名称</TD>";
	print "<TD class=TableHeader nowrap colSpan=1>属性类型</TD>";
	print "<TD class=TableHeader nowrap colSpan=1>自动增量</TD>";
	print "<TD class=TableHeader nowrap colSpan=1>主键</TD>";
	print "<TD class=TableHeader nowrap colSpan=1>索引</TD>";
	print "</TR>\n";

	for($i=0;$i<$_POST['num_fields'];$i++)		{
		$Name = $AttributeName[$i];
		print "<TR>\n";
		print "<TD class=TableData nowrap colSpan=1>\n";

		print "<input id=field_0_1 type=text name=field_name[] size=10 maxlength=64 value='' class=\"SmallInput\" />";
		print "</TD>";
		print "<TD class=TableData nowrap colSpan=1>\n";
		print "<select name=\"field_type[]\" id=\"field_0_2\">
				<option value=\"INT:30\">数字(30)</option>
                <option value=\"VARCHAR:100\">字符(100)</option>
				<option value=\"BIGINT:60\">数字(60)</option>
				<option value=\"VARCHAR:250\">字符(250)</option>
				<option value=\"MEDIUMTEXT\">中文本</option>
                <option value=\"TEXT\">文本</option>
                <option value=\"DATE\">日期</option>
				<option value=\"DATETIME\">日期时间</option>
                <option value=\"FLOAT:3.2\">小数</option>
		</select>";
		print "</TD>";
		print "<TD class=TableData nowrap colSpan=1>\n";
		print "<input type=\"radio\" name=\"auto_increment_$i\"/>";
		print "</TD>";
		print "<TD class=TableData nowrap colSpan=1>\n";
		print "<input type=\"radio\" name=\"primary_key_$i\"/>";
		print "</TD>";
		print "<TD class=TableData nowrap colSpan=1>\n";
		print "<input type=\"radio\" name=\"index_key_$i\"/>";
		print "</TD>";
		//print "<TD class=TableData nowrap colSpan=1>\n";
		//print "<input type=\"radio\" name=\"field_key_0\" value=\"primary_0\" />";
		//print "</TD>";
		print "</TR>\n";
	}
	print "<TR>\n";
	print "<TD class=TableContent nowrap colSpan=6><div align=\"center\">
		<input type=submit accesskey=\"s\" value=\" 保存 \" class=SmallButton onClick=\"\" title=\" 保存 \">
		<input type=button accesskey=\"c\" value=\" 返回 \" class=SmallButton onClick=\"history.back();\" title=\" 返回 \">
		</div></TD>";
	print "</TR>\n";
exit;
}

if($_GET['Tablename']!=""&&$_GET['action']=="mktableFieldData")		{
	//print_R($_POST);
	//print_R($_GET);
	$tablename = strtolower($_GET['Tablename']);

	//判断已有表是否存在
	$Tables = $db->MetaTables();
	if(in_array($tablename,$Tables))	{
		print "<div align=center>表 $tablename 已经存在，请换用其它名称！<BR>
			<input type=button accesskey='r' value=\"返回\" class=\"SmallButton\" onclick=\"location='?'\">
		</div>";
		exit;
	}

	//构建创建表信息
	$sql = "Create table $tablename (";
	$field_name_array = $_POST['field_name'];
	$field_type_array = $_POST['field_type'];
	$field_name_array = $_POST['field_name'];
	$field_sql = $sql;
	for($i=0;$i<sizeof($field_name_array);$i++)			{
		$field_name = $field_name_array[$i];
		$field_sql .= $field_name;

		$field_type = $field_type_array[$i];
		$field_type2 = explode(':',$field_type);
		switch($field_type2[0])		{
			case 'INT':
			case 'BIGINT':
				$field_sql .= " ".$field_type2[0]."(".$field_type2[1].") not null";
				if($_POST["auto_increment_".$i]=='on')		{
					$field_sql .= " auto_increment ";
				}
				$field_sql .= ",";
				break;
			case 'VARCHAR':
				$field_sql .= " ".$field_type2[0]."(".$field_type2[1].") not null,";
				break;
			case 'MEDIUMTEXT':
				$field_sql .= " ".$field_type2[0]." not null,";
				break;
			case 'TEXT':
				$field_sql .= " ".$field_type2[0]." not null,";
				break;
			case 'DATE':
				$field_sql .= " ".$field_type2[0]." not null,";
				break;
			case 'DATETIME':
				$field_sql .= " ".$field_type2[0]." not null,";
				break;
			case 'FLOAT':
				$field_sql .= " ".$field_type2[0]." not null,";
				break;
		}
		if($_POST["primary_key_".$i]=='on')		{
			$primary_key_text = "primary key ($field_name)";
		}
		//if($_POST["primary_key_".$i]=='on')		{
		//	$primary_key_text = "primary key ($field_name)";
		//}

	}
	$field_sql .= $primary_key_text ;
	$field_sql .=");";
	$rs = $db->Execute($field_sql);
	print "<div align=center><span style=\"BACKGROUND:#EEEEEE;COLOR:#FF6633;margin: 10px;border:1px dotted #FF6633;font-weight:bold;padding:8px;width=300px\">
		<font color=#FF0000><img src=\"images/attention.gif\" height=20> <b>提示</b></font><hr>
		对象构建完成，对象名称为 ".$_GET['Tablename']."</span></div>
		<br>
		<div align=center>
			<input type=button accesskey='r' value=\"初始化对象:".$_GET['Tablename']."\" class=\"SmallButton\" onclick=\"location='php_ide.php?tablename=".$_GET['Tablename']."&action=init'\">
		</div>";
		exit;

}























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

$sql = "select * from $Tablerealname";
$MetaColumns = $db->MetaColumns($Tablerealname);
//MetaDatabases MetaTables MetaColumns MetaColumnNames MetaPrimaryKeys ServerInfo
//print_R($MetaColumns);
//$Attribute = array("name","max_length","type","not_null","default_value","primary_key","auto_increment","binary");
//$AttributeName = array("字段名称","最大长度","类型","非空","默认值","主键","自动增量","二进制");
$Attribute = array("name","max_length","type","not_null","default_value",'other');
$AttributeName = array("字段名称","最大长度","类型","非空","默认值","操作");


print "\n<FORM name=form1 action=\"?Tablename=".$Tablerealname."&sectionName=sectionName_data\" method=post encType=multipart/form-data>\n";
print "<table border=1 cellspacing=0 class=small bordercolor=#000000 cellpadding=3 align=center style=\"border-collapse:collapse\">\n";


print "<TR>\n";
print "<TD class=TableHeader nowrap colSpan=6>&nbsp;表名：".$Tablerealname."</TD>";
print "</TR>\n";
print "<TR>\n";
for($i=0;$i<sizeof($Attribute);$i++)		{
	$Name = $AttributeName[$i];
	print "<TD class=TableHeader nowrap colSpan=1>&nbsp;$Name</TD>";
}




$DataArray = array_keys($MetaColumns);
for($i=0;$i<sizeof($DataArray);$i++)		{
	$FieldName = $DataArray[$i];
	$RowArray = $MetaColumns[$FieldName];
	//Name
	$IndexName = $RowArray->name;
	print "<TR>\n";
	print "<TD class=TableData align=left colSpan=1>\n";
	print "<input type=text name=\"$IndexName\" value=\"$IndexName\" class=SmallInput size=20>";
	print "</TD>";
	//max_length
	$IndexName = $RowArray->max_length;
	print "<TD class=TableData align=left colSpan=1>\n";
	print "<input type=text name=\"".$IndexName."_maxlength\" value=\"$IndexName\" class=SmallInput size=5>";
	print "</TD>";
	//type
	$IndexName = $RowArray->type;
	print "<TD class=TableData align=left colSpan=1>&nbsp;\n";
	FieldTypeSelect($IndexName,$IndexName);
	print "</TD>";
	//not_null
	$IndexName = $RowArray->not_null;
	print "<TD class=TableData align=left colSpan=1>&nbsp;\n";
	if($IndexName==1)
		print "<input checked type=checkbox name=\"".$IndexName."_notnull\" value=\"$IndexName\" class=SmallInput>";
	else
		print "<input type=checkbox name=\"".$IndexName."_notnull\" value=\"$IndexName\" class=SmallInput>";
	print "</TD>";
	//has_default
	$IndexName = $RowArray->has_default;
	print "<TD class=TableData align=left colSpan=1>&nbsp;\n";
	print "<input type=text name=\"".$IndexName."_default\" value=\"".$RowArray->default_value."\" class=SmallInput size=10>";
	/*
	if($IndexName==1)		{
		print "<input type=text name=\"".$IndexName."_default\" value=\"".$RowArray->default_value."\" class=SmallInput size=10>";
	}
	else					{
		print "<input disabled type=text name=\"".$IndexName."_default\" class=SmallStatic size=10>";
	}
	*/
	print "</TD>";
	/*
	//primary_key
	$IndexName = $RowArray->primary_key;
	print "<TD class=TableData align=left colSpan=1>&nbsp;\n";
	print $IndexName."</TD>";
	//auto_increment
	$IndexName = $RowArray->auto_increment;
	print "<TD class=TableData align=left colSpan=1>&nbsp;\n";
	print $IndexName."</TD>";
	//binary
	$IndexName = $RowArray->binary;
	print "<TD class=TableData align=left colSpan=1>&nbsp;\n";
	print $IndexName."</TD>";
	*/
	print "<TD class=TableContent align=center colSpan=10>&nbsp;<INPUT class=SmallButton title=修改 type=submit value='修改' size = 8 name=button></TD>\n";
	print "</TR>\n";

}
//print "<TR></TR>\n";
print "</Table></form>\n";


function FieldTypeSelect($showfield,$value)		{
	global $db,$_GET;
	$Array = array("int","varchar","date","float","datetime");
	print "<select class=\"SmallSelect\" name=\"".$showfield."_type\">\n";
	for($i=0;$i<sizeof($Array);$i++)		{
		$indexName = $Array[$i];
		if($value==$indexName)		$temp='selected';
		print "<option value=".$indexName." $temp>".$indexName."</option>\n";
		$temp='';
	}
	print "</select>\n";
}
?>