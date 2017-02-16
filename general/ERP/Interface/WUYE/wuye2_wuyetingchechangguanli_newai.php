<?php
	ini_set('display_errors', 1);
	ini_set('error_reporting', E_ALL);
	error_reporting(E_WARNING | E_ERROR);
	require_once('lib.inc.php');
	$GLOBAL_SESSION=returnsession();



	

	if($_GET['action']=="add_default_data")		
	{
		//检查所添加的车位是够已经有人使用
		$停车位 = $_POST['停车位'];
		if($停车位==""){
		   echo "<a class=OrgAdd href=\"#\" onClick=\"return confirm('停车位不能为空!')\"></a> ";
		   //echo "请点击此处<a href=javascript:history.go(-1);>返回</a><br>";
		   exit;
		}

		$sql = "select COUNT(*) AS num from wuye_wuyetingchechangguanli where 停车位='$停车位'";
		$车辆编码 = returntablefield("wuye_wuyetingchechangguanli","停车位",$停车位,"车辆编码");

		//echo $rs_a;
		if($车辆编码!=""){
		   //echo "<a class=OrgAdd href=\"#\" onClick=\"return confirm('此车位已经有用户使用!')\">提示</a> "; 
		   // Message("2","此车位已经有用户使用");

		   echo "<font size=6><center><b>此车位已经有用户使用,请点击此处<a href=javascript:history.go(-1);>返回</a></b></center></font><br>";
		   exit;
		}
    }
		

	$_GET['车位状态'] ="空";

	$filetablename = 'wuye_wuyetingchechangguanli';
	$parse_filename	= 'wuye2_wuyetingchechangguanli';
	require_once('include.inc.php');

	if($_GET['action']==''||$_GET['action']=='init_default'||$_GET['action']=='init_customer')		{
		$PrintText .= "<BR><table  class=TableBlock align=center width=100%>";
		$PrintText .= "<TR class=TableContent><td ><font color=green >
		说明：<BR>
		&nbsp;&nbsp;1 首先在此页面进行车位的初始化，将所有车位初始化。<BR>
		&nbsp;&nbsp;2 进入此页面只需将对应的车库车位号的车位状态更改为已出售或以出租。<BR>
		&nbsp;&nbsp;3 然后到相应的已出售或以出租页面填写对应的信息。
		</font></td></table>";
		print $PrintText;
	}
?>