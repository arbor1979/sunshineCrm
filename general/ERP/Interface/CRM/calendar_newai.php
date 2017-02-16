<?php
	ini_set('display_errors', 1);
	ini_set('error_reporting', E_ALL);
	error_reporting(E_WARNING | E_ERROR);
	require_once('lib.inc.php');
	$GLOBAL_SESSION=returnsession();
	$SYSTEM_PRIV_STOP = "1";
	date_default_timezone_set('PRC');
	
	if($_GET['action']=="init_default" || $_GET['action']=="")		
	{
		
	if ( $_COOKIE['cal_view'] == "day" || $_COOKIE['cal_view'] == "month" )
	{
    	header( "location:calendar/".$_COOKIE['cal_view'].".php" );
    	exit;
	}
	else 
	{
		header( "location:calendar/week.php" );
    	exit;
	}
	}
	if($_GET['action']=="add_default")
	{
		$CAL_TIME=intval($_GET['CAL_TIME']);
		if($CAL_TIME<10)
			$CAL_TIME="0".$CAL_TIME;
		$CAL_TIME.=":00:00";
		$CAL_TIME=$_GET['CAL_DATE']." ".$CAL_TIME;
		$EndTime=strtotime("$CAL_TIME +1 hour");
		$EndTime=date("Y-m-d H:i:s",$EndTime);
		$ADDINIT=array("CAL_TIME"=>$CAL_TIME,"END_TIME"=>$EndTime,"tixingtime"=>$CAL_TIME);
		
	}
	if($_GET['action']=="add_default_data" || $_GET['action']=="edit_default_data")		
	{
		
		$id=$_POST['id'];
		if($id=='')
			$id=$_GET['id'];
		if($_GET['action']=="edit_default_data")
			deleteMessage("日程提醒",$_GET['id']);	
		//弹出消息
		newMessage($_SESSION['LOGIN_USER_ID'],cutStr($_POST['CONTENT'],12),'日程提醒','../CRM/calendar_newai.php?'.base64_encode('action=view_default&id='.$id),$id,$_POST['tixingtime']);
		//短信通知
		if($_POST['ifsms']=='1')	
		{
			$mobiles=returntablefield("user", "user_id", $_SESSION['LOGIN_USER_ID'], "MOBIL_NO");
		
			print "\n<script type=\"text/javascript\" language=\"javascript\" src=\"".ROOT_DIR."general/ERP/Enginee/jquery/jquery.js\"></script>\n";
			print "<script type=\"text/javascript\" language=\"javascript\">
			$.post('../Framework/sms_getContents.php?action=send', {
			    mobiles:'".$mobiles."',
			    msg:'".cutStr("【日程提醒】".$_POST['CONTENT'],70)."',
			    attime:'".$_POST['tixingtime']."'
			}, function(data) {	
			});
		</script>";	
		}
	}
	if($_GET['action']=="delete_array")
	{
		deleteMessage("日程提醒",$_GET['selectid']);	
		
	}
	if($_GET['action']=="finish")
	{
		$sql="update calendar set over_status='".$_GET['OVER_STATUS']."' where id=".$_GET['id']; 	
		$db->Execute($sql);
		updateMessage("日程提醒",$_GET['id'],$_GET['OVER_STATUS']);	
		header("location:calendar_newai.php");
		exit;
	}
	$filetablename		=	'calendar';
	$parse_filename		=	'calendar';
	require_once('include.inc.php');
	?>