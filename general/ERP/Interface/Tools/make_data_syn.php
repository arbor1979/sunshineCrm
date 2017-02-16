<?
ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL);

// display warnings and errors
error_reporting(E_WARNING | E_ERROR);



require_once("lib.inc.php");

/*

$MetaTables = $db->MetaTables();
page_css("make_data_syn");
//print_R($MetaTables);
//$MetaTables[0] = "edu_student";
//sizeof($MetaTables) = 20;
for($I = 0; $I < sizeof($MetaTables); $I++) {
	$tablename = $MetaTables[$I];
	$sql = "SHOW FULL COLUMNS FROM $tablename";
	$rs = $db->Execute($sql);
	$rs_a= $rs->GetArray();
	//print_R($rs_a);
	for($IX = 0; $IX < sizeof($rs_a); $IX++)	{
		$列名称 = $rs_a[$IX]['Field'];
		$类型名称 = $rs_a[$IX]['Type'];
		$默认值 = $rs_a[$IX]['Default'];
		if($列名称=="课程名称"||$列名称=="课程")			{
			$课程文本[] = "update $tablename set $列名称='\$新值' where $列名称='\$旧值'";
			//exit;
		}
		if($列名称=="教室名称"||$列名称=="教室")			{
			$教室文本[] = "update $tablename set $列名称='\$新值' where $列名称='\$旧值'";
			//exit;
		}
		if($列名称=="班级名称"||$列名称=="班级"||$列名称=="班号")			{
			$班级文本[] = "update $tablename set $列名称='\$新值' where $列名称='\$旧值'";
			//exit;
		}
		if($列名称=="学期名称"||$列名称=="学期")			{
			$学期文本[] = "update $tablename set $列名称='\$新值' where $列名称='\$旧值'";
			//exit;
		}
		if($列名称=="教材名称"||$列名称=="教材")			{
			$教材文本[] = "update $tablename set $列名称='\$新值' where $列名称='\$旧值'";
			//exit;
		}
		if($列名称=="专业名称"||$列名称=="专业")			{
			$专业文本[] = "update $tablename set $列名称='\$新值' where $列名称='\$旧值'";
			//exit;
		}
		if($列名称=="系名称"||$列名称=="系"||$列名称=="院系"||$列名称=="专业科")			{
			$系文本[] = "update $tablename set $列名称='\$新值' where $列名称='\$旧值'";
			//exit;
		}
		if($列名称=="学号"||$列名称=="学生学号")			{
			$学号文本[] = "update $tablename set $列名称='\$新值' where $列名称='\$旧值'";
			//exit;
		}
		if($列名称=="姓名"||$列名称=="学生姓名")			{
			$姓名文本[] = "update $tablename set $列名称='\$新值' where $列名称='\$旧值'";
			//exit;
		}
	}
}


$INARRAY = array("课程","教室","班级","学期","专业","系","姓名","学号","教材");

for($iX=0;$iX<sizeof($INARRAY);$iX++)				{
	$列名称 = $INARRAY[$iX];
	print "function 修改时同步{$列名称}数据(\$新值,\$旧值)		{<BR>
	&nbsp;&nbsp;global \$_GET,\$_POST,\$db;<BR>
	&nbsp;&nbsp;if(\$新值==\$旧值)		{<BR>&nbsp;&nbsp;&nbsp;&nbsp;return '';<BR>&nbsp;&nbsp;}<BR>";
	$变量值 = $列名称."文本";
	$变量值2 = $$变量值;
	for($i=0;$i<sizeof($变量值2);$i++)				{
		print "&nbsp;&nbsp;\$sql = \"".$变量值2[$i]."\";<BR>
		&nbsp;&nbsp;\$db->Execute(\$sql);<BR>";
	}
	print "}<BR>";
}




exit;
*/

//##############################################################################
require_once("lib.inc.php");
//$MetaTables = $db->MetaTables();
//print_R($MetaTables);
//$MetaTables[0] = "edu_student";
$sql = "show table status";
$rs  = $db->Execute($sql);
$MetaTablesRSA = $rs->GetArray();
for($Ixx = 0; $Ixx < sizeof($MetaTablesRSA); $Ixx++) {
	$tablename = $MetaTablesRSA[$Ixx]['Name'];
	$Collation = $MetaTablesRSA[$Ixx]['Collation'];
	if($Collation!="gbk_chinese_ci")				{
		$sql = "ALTER TABLE `".$tablename."` DEFAULT CHARACTER SET gbk COLLATE gbk_chinese_ci;";
		print $sql."<BR>";
		$db->Execute($sql);
	}
	$sql = "SHOW FULL COLUMNS FROM $tablename";
	$rs = $db->Execute($sql);
	$rs_a= $rs->GetArray();
	//print_R($rs_a);
	//
	for($IX = 0; $IX < sizeof($rs_a); $IX++)					{
		if($rs_a[$IX]['Collation']=="gbk_bin")				{
			$sql = "ALTER TABLE `$tablename` CHANGE `".$rs_a[$IX]['Field']."` `".$rs_a[$IX]['Field']."` ".$rs_a[$IX]['Type']." CHARACTER SET gbk COLLATE gbk_chinese_ci NOT NULL DEFAULT '".$rs_a[$IX]['Default']."';";
			print $sql."<BR>";
			$db->Execute($sql);
		}
	}
	//exit;
}
?>