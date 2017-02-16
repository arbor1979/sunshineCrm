<?php  ini_set('display_errors', 1);
	ini_set('error_reporting', E_ALL);
	error_reporting(E_WARNING | E_ERROR);
    require_once('lib.inc.php');
	
	$GLOBAL_SESSION=returnsession();
$SYSTEM_PRIV_STOP = 1;
//include_once( "inc/auth.php" );
include_once( "inc/utility_all.php" );
include_once( "inc/utility_sms1.php" );
include_once( "inc/utility_sms2.php" );
//include_once( "sms.php" );
$LOGIN_USER_ID = $_SESSION['LOGIN_USER_ID'];
?>
<html><head><title>发送EMAIL工资条</title><meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<?php echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"/theme/";
echo $LOGIN_THEME == "" ? "1" : $LOGIN_THEME;
echo "/style.css\">\r\n";   ?>
</head>
<body class="bodycolor" topmargin="5">
<?php
$yue=date("m");
//$yue=$yue-1;
$SUBJECT=$yue.'月工资条';
$y=date('Y');


$SEND_TIME = date( "Y-m-d H:i:s" );
$rs=$db->Execute("select USER_ID,USER_NAME from user");
$people=$rs->GetArray();
if($rs->RecordCount()<=0) {message( "提示", "没有工资条数据" );
	button_back( );exit();}
for($i=0;$i<sizeof($people);$i++){
    $USERID=$people[$i][USER_ID];
	$salary=$db->Execute("select 费用名称,金额 from hrms_salary_detail where 费用人员='".$people[$i]['USER_NAME']."' and 月份='".$yue."' and 年份='".$y."'");
	$item=$salary->GetArray();
	if($salary->RecordCount()<=0) {message( "提示", "没有工资条数据" );
	button_back( );exit();}
	$TR = "<br><div align=center>\n<table border=0 cellspacing=1 class=TableBlock cellpadding=3>\n";
	$TR .= "<tr class=TableContent><td nowrap align=center width=120><b>工资项目</b></td><td nowrap align=center width=80><b>金额</b></td></tr>\n";
	for($j=0;$j<sizeof($item);$j++){
		$TR .="<tr class=TableData>";
		$TR .= "<td nowrap align=center>".$item[$j]['费用名称']."</td>";
	    $TR .= "<td nowrap align=center>".$item[$j]['金额']."</td>";
		$TR .= "</tr>\n";
	
	}
	$TR .="</table></div>";

   $CONTENT=$TR;
$sql="insert into email_body(FROM_ID,TO_ID2,COPY_TO_ID,SUBJECT,CONTENT,SEND_TIME,ATTACHMENT_ID,ATTACHMENT_NAME,SEND_FLAG,IMPORTANT) select '".$LOGIN_USER_ID."' as FROM_ID,'{$USERID},' as TO_ID2,'' as COPY_TO_ID ,'{$SUBJECT}' as SUBJECT,'{$CONTENT}' as CONTENT,'{$SEND_TIME}' as SEND_TIME,'' as ATTACHMENT_ID,'' as ATTACHMENT_NAME,'1' as SEND_FLAG,'0' as IMPORTANT from user where USER_ID='{$USERID}' and  NOT_LOGIN='0'";
$email1=$db->Execute($sql);
$BODY_ID=$db->Insert_ID();
$query = "INSERT INTO EMAIL(TO_ID,READ_FLAG,DELETE_FLAG,BOX_ID,BODY_ID) values('".$USERID."','0','0','0','{$BODY_ID}')";
$email2=$db->Execute($query);
$ROW_ID = $db->Insert_ID();
$REMIND_URL = "email/inbox/read_email/?BOX_ID=0&EMAIL_ID=".$ROW_ID;
				$SMS_CONTENT = "请查收邮件！\n主题：".$SUBJECT;
				send_sms( "", $LOGIN_USER_ID, $USERID, 2, $SMS_CONTENT, $REMIND_URL );
}


	message( "提示", "工资条已发送" );
	button_back( );
?>

</body></html>