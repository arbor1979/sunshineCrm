<?php 
	ini_set('display_errors', 1);
	ini_set('error_reporting', E_ALL);
	error_reporting(E_WARNING | E_ERROR);

	require_once('lib.inc.php');
	
	$GLOBAL_SESSION=returnsession();
$SYSTEM_PRIV_STOP = 1;
	
global $db;
$sql="select 学期名称,月份,年份,费用类别,费用名称,费用人员,备注,创建人,创建时间 from hrms_salary";

$rs=$db->Execute($sql);
while (!$rs->EOF){

    $name=explode(',',$rs->fields['费用人员']);
   // print_r($name);print $rs->fields['费用名称'];
    if($rs->fields['费用名称'] != ''){
        $salary=$db->Execute("select 金额 from hrms_salary_type where 费用名称='".$rs->fields['费用名称']."'");
        while(!$salary->EOF){$money=$salary->fields['金额'];$salary->MoveNext();}$salary->Close();
    }
   
    for($i=0;$i<sizeof($name);$i++){
        $detailsql="insert into hrms_salary_detail(学期名称,月份,年份,费用类别,费用名称,金额,费用人员,备注,创建人,创建时间) values('".$rs->fields['学期名称']."',".$rs->fields['月份'].",".$rs->fields['年份'].",'".$rs->fields['费用类别']."','".$rs->fields['费用名称']."',".$money.",'".$name[$i]."','".$rs->fields['备注']."','".$rs->fields['创建人']."','".$rs->fields['创建时间']."')";
       $db->Execute($detailsql);
    }
     
     
    $rs->MoveNext();
}
$rs->Close();


?>




