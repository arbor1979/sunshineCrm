<?php

$salary4 = "н��";
function salary4_Value($fieldvalue,$fields,$i)		{
	global $db;
	global $tablename,$html_etc,$common_html;
	$Text = 0;
	$��������=strip_tags($fields['value'][$i]['��������']);
	$����=strip_tags($fields['value'][$i]['����']);
	$���=strip_tags($fields['value'][$i]['���']);
	//$һ�� = strip_tags($fields['value'][$i]['һ��']);
	
	//$���� = strip_tags($fields['value'][$i]['����']);
	//$���� = strip_tags($fields['value'][$i]['����']);
	$����  = strip_tags($fields['value'][$i]['����']);
	//$���� = strip_tags($fields['value'][$i]['����']);
	//$���� = strip_tags($fields['value'][$i]['����']);
	//$���� = strip_tags($fields['value'][$i]['����']);
	//$���� = strip_tags($fields['value'][$i]['����']);
	//$���� = strip_tags($fields['value'][$i]['����']);
	//$ʮ�� = strip_tags($fields['value'][$i]['ʮ��']);
	//$ʮһ�� = strip_tags($fields['value'][$i]['ʮһ��']);
	//$ʮ���� = strip_tags($fields['value'][$i]['ʮ����']);
	
	//if($һ�� != 0) $Text='<a href=\"hrms_salary_person.php?bumen=$��������&name=$����&y=$���&m=1\">'.$һ��.'</a>';
	
	//if($���� != 0) $Text='<a href=\"hrms_salary_person.php?bumen=$��������&name=$����&y=$���&m=2\">'.$����.'</a>';
	//if($���� != 0) $Text='<a href=\"hrms_salary_person.php?bumen=$��������&name=$����&y=$���&m=3\">'.$����.'</a>';
	if($���� != 0) $Text="<a href='hrms_salary_person.php?bumen=".$��������."&name=".$����."&y=".$���."&m=4'>".$����.'</a>';
	//if($���� != 0) $Text='<a href=\"hrms_salary_person.php?bumen=$��������&name=$����&y=$���&m=5\">'.$����.'</a>';
	//if($���� != 0) $Text='<a href=\"hrms_salary_person.php?bumen=$��������&name=$����&y=$���&m=6\">'.$����.'</a>';
	//if($���� != 0) $Text='<a href=\"hrms_salary_person.php?bumen=$��������&name=$����&y=$���&m=7\">'.$����.'</a>';
	//if($���� != 0) $Text='<a href=\"hrms_salary_person.php?bumen=$��������&name=$����&y=$���&m=8\">'.$����.'</a>';
	//if($���� != 0) $Text='<a href=\"hrms_salary_person.php?bumen=$��������&name=$����&y=$���&m=9\">'.$����.'</a>';
	//if($ʮ�� != 0) $Text='<a href=\"hrms_salary_person.php?bumen=$��������&name=$����&y=$���&m=10\">'.$ʮ��.'</a>';
	//if($ʮһ�� != 0) $Text='<a href=\"hrms_salary_person.php?bumen=$��������&name=$����&y=$���&m=11\">'.$ʮһ��.'</a>';
	//if($ʮ���� != 0) $Text='<a href=\"hrms_salary_person.php?bumen=$��������&name=$����&y=$���&m=12\">'.$ʮ����.'</a>';
	
	




	return $Text;
}
?>