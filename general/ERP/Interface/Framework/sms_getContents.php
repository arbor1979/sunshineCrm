<?php
	ini_set('display_errors', 1);
	ini_set('error_reporting', E_ALL);
	error_reporting(E_WARNING | E_ERROR);
	require_once('lib.inc.php');
	$GLOBAL_SESSION=returnsession();
	
@$global_config_ini_file = @parse_ini_file( 'global_config.ini',true);
$SmsServerIP=$global_config_ini_file['section']['SmsServerIP'];
$SmsLoginID=$global_config_ini_file['section']['SmsLoginID'];
$SmsLoginPWD=$global_config_ini_file['section']['SmsLoginPWD'];
if(!stripos($SmsServerIP,"http://"))
	$SmsServerIP="http://".$SmsServerIP;
	
header('Content-Type:text/xml;charset=GB2312'); 
if($_GET['action']=='send')
{
	
	$mobiles = $_POST["mobiles"];
	$msg=$_POST["msg"];
	$attime=$_POST["attime"];
	$msg=iconv('UTF-8','gbk',$msg);
	//echo $msg;
	if($attime!="")
		$data = array("1","userid" =>$SmsLoginID,"pwd" =>$SmsLoginPWD,"mobiles" =>$mobiles,"msg" =>$msg,"attime"=>$attime,"a=>1");
	else 
		$data = array("1","userid" =>$SmsLoginID,"pwd" =>$SmsLoginPWD,"mobiles" =>$mobiles,"msg" =>$msg,"a=>1");
	$data = http_build_query($data,'','&');  
	$opts = array(  
   		'http'=>array(
     	'method'=>"POST",
		'header' => "User-Agent: Mozilla/5.0 (Windows; U; Windows NT 6.0; en-US) \r\n Accept: */*", 
     	'content' =>".$data.",""
   		)  
 	);
 	$cxContext = stream_context_create($opts);  
 	$sFile = file_get_contents($SmsServerIP."/sunshine/send", false, $cxContext);  
 	echo $sFile;
 	
	//$url = $SmsServerIP."/sunshine/login?userid=".$SmsLoginID."&pwd=".$SmsLoginPWD;
	//echo file_get_contents($url);
	//print_r($_POST);
}
else if($_GET['action']=='login')
{

	$url = $SmsServerIP."/sunshine/login?userid=".$SmsLoginID."&pwd=".$SmsLoginPWD;
	echo file_get_contents($url);
}
else if($_GET['action']=='detail')
{

	$batchid=$_GET["batchid"];
	$url = $SmsServerIP."/sunshine/getreceive?param=detail&userid=".$SmsLoginID."&pwd=".$SmsLoginPWD."&batchid=".$batchid;
	echo file_get_contents($url);
}
?>
