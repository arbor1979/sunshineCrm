<?php
function detail($y,$m){
global $db;
$sql="select ѧ������,�·�,���,�������,��������,������Ա,��ע,������,����ʱ�� from hrms_salary where �·�='".$m."'and ���='".$y."'";
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
 echo '<script>alert("������ɣ�")</script>';
}

?>