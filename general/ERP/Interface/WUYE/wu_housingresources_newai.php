<?php
	ini_set('display_errors', 1);
	ini_set('error_reporting', E_ALL);
	error_reporting(E_WARNING | E_ERROR);
	require_once('lib.inc.php');
	$GLOBAL_SESSION=returnsession();

    /*
	if($_GET['action']=="add_default_data")		{
		
		//print_r($_POST);
		//echo "<br>";
        
		$房间号码 = $_POST['房间代码'];
	    $业主姓名 = $_POST['业主姓名'];

		$sel_sql = "select * from wu_housingowner where 房间代码='$房间号码' and 业主姓名='$业主姓名'";
		$result = $db->Execute($sel_sql);
		$rows = $result->GetArray();

		$手机号码 = $rows[0]['手机'];
		$电话号码 = $rows[0]['电话'];
		$业主电话 = $手机号码."或".$电话号码;

        $up_sql = "update wu_housingresources set 业主电话='$业主电话' where 房间代码='$房间号码' and 业主姓名='$业主姓名'";
        $db->Execute($up_sql);
	  
	}
    */


     /*
	if($_GET['action']=="edit_default_data")		{
		
		//print_r($_POST);
		//echo "<br>";
		
        $房间代码 = $_POST['房间代码'];
		$区域名称 = $_POST['区域名称'];
		$大楼名称 = $_POST['大楼名称'];
        $单元号   = $_POST['单元号'];
		$楼层号   = $_POST['楼层号'];
		$房间号   = $_POST['房间号'];

	    $房间号码 = $房间号码 = $大楼名称."-".$单元号."-".$楼层号.$房间号;

        $sel_sql = "select * from wu_housingowner where 房间代码='$房间代码' and 单元编号='$房间号码'";
		$result = $db->Execute($sel_sql);
		$rows = $result->GetArray();
        
		$业主姓名 = $rows[0]['业主姓名'];
		$手机号码 = $rows[0]['手机'];
		$电话号码 = $rows[0]['电话'];
		$业主电话 = $手机号码."或".$电话号码;
        
		
        echo $房间代码."<br>";
		echo $区域名称."<br>";
		echo $大楼名称."<br>";
	    echo $业主姓名."<br>";
        echo $业主电话."<br>";
      
        
		//$selet_sql = "select * from ";
        


		$sql = "update wu_housingresources set 房间号码='$房间号码',业主姓名='$业主姓名',业主电话='$业主电话' where 房间代码='$房间代码' and 区域名称='$区域名称' and 大楼名称='$大楼名称' and 单元状态='已经入住'";
        
		//echo $sql;
		$db->Execute($sql);

		//exit;


	}
    */

	$_GET['单元状态'] = "已经入住,已购未入住,办公自用";
    
	$filetablename		=	'wu_housingresources';
	$parse_filename		=	'wu_housingresources';
	require_once('include.inc.php');

	if($_GET['action']==''||$_GET['action']=='init_default'||$_GET['action']=='init_customer')		{
		$PrintText .= "<BR><table  class=TableBlock align=center width=100%>";
		$PrintText .= "<TR class=TableContent><td ><font color=green >
		说明：<BR>
		&nbsp;&nbsp;&nbsp;&nbsp;1 从空房管理页面完善房屋资料后，此时房间号码、业主姓名、电话号码是空。<BR>
        &nbsp;&nbsp;&nbsp;&nbsp;2 点击对应项的编辑按钮，然后保存，系统会自动将对应的客户资料给保存进来。<br>
		&nbsp;&nbsp;&nbsp;&nbsp;3 最后可以在对应项操作缴费、报修、投诉、车位管理等业务。
		</font></td></table>";
		print $PrintText;
	}

	?>