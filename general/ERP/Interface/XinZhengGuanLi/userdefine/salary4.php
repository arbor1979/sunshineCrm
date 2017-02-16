<?php

$salary4 = "薪酬";
function salary4_Value($fieldvalue,$fields,$i)		{
	global $db;
	global $tablename,$html_etc,$common_html;
	$Text = 0;
	$所属部门=strip_tags($fields['value'][$i]['所属部门']);
	$姓名=strip_tags($fields['value'][$i]['姓名']);
	$年份=strip_tags($fields['value'][$i]['年份']);
	//$一月 = strip_tags($fields['value'][$i]['一月']);
	
	//$二月 = strip_tags($fields['value'][$i]['二月']);
	//$三月 = strip_tags($fields['value'][$i]['三月']);
	$四月  = strip_tags($fields['value'][$i]['四月']);
	//$五月 = strip_tags($fields['value'][$i]['五月']);
	//$六月 = strip_tags($fields['value'][$i]['六月']);
	//$七月 = strip_tags($fields['value'][$i]['七月']);
	//$八月 = strip_tags($fields['value'][$i]['八月']);
	//$九月 = strip_tags($fields['value'][$i]['九月']);
	//$十月 = strip_tags($fields['value'][$i]['十月']);
	//$十一月 = strip_tags($fields['value'][$i]['十一月']);
	//$十二月 = strip_tags($fields['value'][$i]['十二月']);
	
	//if($一月 != 0) $Text='<a href=\"hrms_salary_person.php?bumen=$所属部门&name=$姓名&y=$年份&m=1\">'.$一月.'</a>';
	
	//if($二月 != 0) $Text='<a href=\"hrms_salary_person.php?bumen=$所属部门&name=$姓名&y=$年份&m=2\">'.$二月.'</a>';
	//if($三月 != 0) $Text='<a href=\"hrms_salary_person.php?bumen=$所属部门&name=$姓名&y=$年份&m=3\">'.$三月.'</a>';
	if($四月 != 0) $Text="<a href='hrms_salary_person.php?bumen=".$所属部门."&name=".$姓名."&y=".$年份."&m=4'>".$四月.'</a>';
	//if($五月 != 0) $Text='<a href=\"hrms_salary_person.php?bumen=$所属部门&name=$姓名&y=$年份&m=5\">'.$五月.'</a>';
	//if($六月 != 0) $Text='<a href=\"hrms_salary_person.php?bumen=$所属部门&name=$姓名&y=$年份&m=6\">'.$六月.'</a>';
	//if($七月 != 0) $Text='<a href=\"hrms_salary_person.php?bumen=$所属部门&name=$姓名&y=$年份&m=7\">'.$七月.'</a>';
	//if($八月 != 0) $Text='<a href=\"hrms_salary_person.php?bumen=$所属部门&name=$姓名&y=$年份&m=8\">'.$八月.'</a>';
	//if($九月 != 0) $Text='<a href=\"hrms_salary_person.php?bumen=$所属部门&name=$姓名&y=$年份&m=9\">'.$九月.'</a>';
	//if($十月 != 0) $Text='<a href=\"hrms_salary_person.php?bumen=$所属部门&name=$姓名&y=$年份&m=10\">'.$十月.'</a>';
	//if($十一月 != 0) $Text='<a href=\"hrms_salary_person.php?bumen=$所属部门&name=$姓名&y=$年份&m=11\">'.$十一月.'</a>';
	//if($十二月 != 0) $Text='<a href=\"hrms_salary_person.php?bumen=$所属部门&name=$姓名&y=$年份&m=12\">'.$十二月.'</a>';
	
	




	return $Text;
}
?>