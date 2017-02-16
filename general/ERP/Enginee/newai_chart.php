<?php
//不再使用此模块
function newai_chart()	{
	global $common_html;
	global $table,$field,$filter,$mark,$title,$type,$time,$type;
	global $_POST,$_GET;
	$table_array=explode('::',$table);//print_R($table_array);
	$field_array=explode('::',$field);
	$filter_array=explode('::',$filter);
	$mark_array=explode('::',$mark);
	$title_array=explode('::',$title);
	$type_array=explode('::',$type);
	$time_array=explode('::',$time);
	for($i=0;$i<sizeof($table_array);$i++)		{
		$columns=returntablecolumn($table_array[$i]);
		$fieldname=$columns[(string)$field_array[$i]];
		$filter_element_array=explode(':',$filter_array[$i]);

		$columns_filter=returntablecolumn($filter_element_array[1]);
		$showvalue=$columns_filter[(string)$filter_element_array[2]];
		$showfield=$columns_filter[(string)$filter_element_array[3]];

	    $filename=$fieldname."_".$type_array[$i]."_".date(Y_m_d_H).".png";//exit;
		if($_GET['action']=='chart_model'&&$_GET['modelname']!='')	
			$filename=$_GET['modelname']."_".$filename;
		if($_GET['action']=='chart_user'&&$_GET['USER_NAME']!='')	
			$filename=$_GET['USER_NAME']."_".$filename;
		if($_GET['action']=='chart_project'&&$_GET['projectid']!='')	
			$filename=$_GET['projectid']."_".$filename;
		//print $filename;exit;
		$filedirname = "../cache/statics";
		if(!is_dir($filedirname))	
			mkdir($filedirname);
		$filename=$filedirname."/".$filename;
		$showtable=$filter_element_array[1];
		$mode=$filter_element_array[0];//print $filename;exit;
		file_exists($filename)?'':$filename=table_analyze($table_array[$i],$fieldname,$showtable,$showfield,$showvalue,$mode,$type_array[$i],$mark_array[$i],$title_array[$i]);
		file_exists($filename)?print "<div align=center><img src='$filename' border=0/></div><BR>":'';
	}
}
?>