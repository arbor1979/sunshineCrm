<?php 
	ini_set('display_errors', 1);
	ini_set('error_reporting', E_ALL);
	error_reporting(E_WARNING | E_ERROR);

	require_once('lib.inc.php');
	
	$GLOBAL_SESSION=returnsession();
$SYSTEM_PRIV_STOP = 1;
	
global $db;
$sql="select ѧ������,�·�,���,�������,��������,������Ա,��ע,������,����ʱ�� from hrms_salary";

$rs=$db->Execute($sql);
while (!$rs->EOF){

    $name=explode(',',$rs->fields['������Ա']);
   // print_r($name);print $rs->fields['��������'];
    if($rs->fields['��������'] != ''){
        $salary=$db->Execute("select ��� from hrms_salary_type where ��������='".$rs->fields['��������']."'");
        while(!$salary->EOF){$money=$salary->fields['���'];$salary->MoveNext();}$salary->Close();
    }
   
    for($i=0;$i<sizeof($name);$i++){
        $detailsql="insert into hrms_salary_detail(ѧ������,�·�,���,�������,��������,���,������Ա,��ע,������,����ʱ��) values('".$rs->fields['ѧ������']."',".$rs->fields['�·�'].",".$rs->fields['���'].",'".$rs->fields['�������']."','".$rs->fields['��������']."',".$money.",'".$name[$i]."','".$rs->fields['��ע']."','".$rs->fields['������']."','".$rs->fields['����ʱ��']."')";
       $db->Execute($detailsql);
    }
     
     
    $rs->MoveNext();
}
$rs->Close();


?>




