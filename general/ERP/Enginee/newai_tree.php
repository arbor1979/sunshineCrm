<?php
/******************************************************************************
 *@系统项目：Sunshine Anywhere Application Platform(SAAP)1.2
 *@函数说明：主要实现树形菜单的实现
 *@函数作者：王纪云
 *@建立日期：2005-4-09 
 *@更新日期：2005-10-26 
 *@状态说明：注释未完成
 */ 
function newai_tree()			{

global $db,$common_html,$tablename_one,$tablename_two,$link,$tablename_three;
global $html_etc_one,$html_etc_two,$columns_one,$columns_two;
global $tablename;
require_once('lib/function_menu.php');
system_menu_css();
global $db;

$tablename_one_array = explode(":",$tablename_one);
$tablename_two_array = explode(":",$tablename_two);
$tablename_three_array = explode(":",$tablename_three);

$columns_one = returntablecolumn($tablename_one_array[0]);
$columns_two = returntablecolumn($tablename_two_array[0]);
$columns_three = returntablecolumn($tablename_three_array[0]);

$sql="select ".$columns_one[$tablename_one_array[1]].",".$columns_one[$tablename_one_array[2]]." from ".$tablename_one_array[0]."";
$rs_dept=$db->Execute($sql);
$rs_dept_array=$rs_dept->GetArray();
for($i=0;$i<sizeof($rs_dept_array);$i++)	{
	$newarray_dept[(string)$rs_dept_array[$i][(String)$columns_one[$tablename_one_array[1]]]]=$rs_dept_array[$i][(String)$columns_one[$tablename_one_array[2]]];
	$newarray_dept_list['DEPT_NO'][$i]=$rs_dept_array[$i][(String)$columns_one[$tablename_one_array[1]]];
	$newarray_dept_list['DEPT_NAME'][$i]=$rs_dept_array[$i][(String)$columns_one[$tablename_one_array[2]]];
}

$sql_major="select ".$columns_two[$tablename_two_array[1]].",".$columns_two[$tablename_two_array[2]].",".$columns_two[$tablename_two_array[3]]." from ".$tablename_two_array[0]."";
$rs_major=$db->Execute($sql_major);
$rs_major_array=$rs_major->GetArray();
for($i=0;$i<sizeof($rs_major_array);$i++)	{
	$newarray_major[(string)$rs_major_array[$i][(String)$columns_two[$tablename_two_array[3]]]][(string)$rs_major_array[$i][(String)$columns_two[$tablename_two_array[1]]]]=$rs_major_array[$i][(String)$columns_two[$tablename_two_array[2]]];
	$newarray_major_list[(string)$rs_major_array[$i][(String)$columns_two[$tablename_two_array[1]]]]=$rs_major_array[$i][(String)$columns_two[$tablename_two_array[2]]];
	$newarray_major_list[(string)$rs_major_array[$i][(String)$columns_two[$tablename_two_array[3]]]][$i]=$rs_major_array[$i][(String)$columns_two[$tablename_two_array[1]]];
}

$sql_class="select ".$columns_three[$tablename_three_array[1]].",".$columns_three[$tablename_three_array[2]].",".$columns_three[$tablename_three_array[3]]." from ".$tablename_three_array[0]."";
$rs_class=$db->Execute($sql_class);
$rs_class_array=$rs_class->GetArray();
for($i=0;$i<sizeof($rs_class_array);$i++)	{
	$newarray_class[(string)$rs_class_array[$i][(String)$columns_three[$tablename_three_array[3]]]][(string)$rs_class_array[$i][(String)$columns_three[$tablename_three_array[1]]]]=$rs_class_array[$i][(String)$columns_three[$tablename_three_array[2]]];
	$newarray_class_list[(string)$rs_class_array[$i][(String)$columns_three[$tablename_three_array[1]]]]=$rs_class_array[$i][(String)$columns_three[$tablename_three_array[2]]];
	$newarray_class_list[(string)$rs_class_array[$i][(String)$columns_three[$tablename_three_array[3]]]][$i]=$rs_class_array[$i][(String)$columns_three[$tablename_three_array[1]]];

}

foreach($newarray_dept_list['DEPT_NO'] as $DEPT_NO_LIST)	{
parent_table_1($newarray_dept[(String)$DEPT_NO_LIST],"system.gif","MENU_".$DEPT_NO_LIST,$image='tree_plus.gif',$addfile='A_Ban_newai.php?action=tree_student');
part_table_begin($id="MENU_".$DEPT_NO_LIST);

if(!is_array($newarray_major_list[(string)$DEPT_NO_LIST]))	{
	$newarray_major_list[(string)$DEPT_NO_LIST]=array();
}
foreach($newarray_major_list[(string)$DEPT_NO_LIST] as $MAJOR_LIST)	{
parent_table_2($newarray_major_list[$MAJOR_LIST],$pic='system.gif',"MENU_".$MAJOR_LIST,'tree_plus.gif','tree_line.gif',$addfile='A_Ban_newai.php?action=tree_student');
part_table_begin("MENU_".$MAJOR_LIST);

if(!is_array($newarray_class_list[(string)$MAJOR_LIST]))	{
	$newarray_class_list[(string)$MAJOR_LIST]=array();
}
foreach($newarray_class_list[(string)$MAJOR_LIST] as $CLASS_LIST)	{
menu_table_3($newarray_class_list[$CLASS_LIST],$linkurl="A_Stu_newai.php?action=init_default&所属班号=$CLASS_LIST",$pic='system.gif',$tree_pic="tree_blank.gif",$tree_pic2="tree_line.gif",$tree_pic3='tree_line.gif',$addfile='A_Ban_newai.php?action=tree_student');
}
part_table_end();
}//end rs_major_array

part_table_end();
}//end rs_dept_array

system_menu_js($location='parent.main_body');


}
?>