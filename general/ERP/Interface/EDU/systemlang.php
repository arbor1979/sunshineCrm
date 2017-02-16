<?php
require_once('lib.inc.php');
//
//$GLOBAL_SESSION=returnsession();

//$CurXueQi = returntablefield("edu_xueqiexec","当前学期",'1',"学期名称");


$limit = $_GET['limit'];
if($limit=='') $limit = 50000;

$TableName = $_GET['TableName'];
if($TableName!='')		{
	$AddSql = " where tablename='$TableName' ";
}

//$AddSql = " where tablename like 'wu_%' or tablename like 'wuye_%' ";

page_css("数据语言");


$sql = "select * from systemlang $AddSql order by systemlangid desc limit $limit";
$rs = $db->Execute($sql);
$rs_a = $rs->GetArray();

for($iii=0;$iii<sizeof($rs_a);$iii++)						{
	$Line = array_values($rs_a[$iii]);
	$LineText = "'".join("','",$Line)."'";

	$sql = "insert into systemlang values ($LineText);";
	print $sql."<BR>";
	//$db->Execute($sql);

}

//更新学生考勤表信息
exit;








?>