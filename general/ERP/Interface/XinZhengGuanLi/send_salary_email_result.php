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
<html><head><title>����EMAIL������</title><meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<?php echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"/theme/";
echo $LOGIN_THEME == "" ? "1" : $LOGIN_THEME;
echo "/style.css\">\r\n";   ?>
</head>
<body class="bodycolor" topmargin="5">
<?php
$yue=date("m");
//$yue=$yue-1;
$SUBJECT=$yue.'�¹�����';
$y=date('Y');


$SEND_TIME = date( "Y-m-d H:i:s" );
$rs=$db->Execute("select USER_ID,USER_NAME from user");
$people=$rs->GetArray();
if($rs->RecordCount()<=0) {message( "��ʾ", "û�й���������" );
	button_back( );exit();}
for($i=0;$i<sizeof($people);$i++){
    $USERID=$people[$i][USER_ID];
	$salary=$db->Execute("select ��������,��� from hrms_salary_detail where ������Ա='".$people[$i]['USER_NAME']."' and �·�='".$yue."' and ���='".$y."'");
	$item=$salary->GetArray();
	if($salary->RecordCount()<=0) {message( "��ʾ", "û�й���������" );
	button_back( );exit();}
	$TR = "<br><div align=center>\n<table border=0 cellspacing=1 class=TableBlock cellpadding=3>\n";
	$TR .= "<tr class=TableContent><td nowrap align=center width=120><b>������Ŀ</b></td><td nowrap align=center width=80><b>���</b></td></tr>\n";
	for($j=0;$j<sizeof($item);$j++){
		$TR .="<tr class=TableData>";
		$TR .= "<td nowrap align=center>".$item[$j]['��������']."</td>";
	    $TR .= "<td nowrap align=center>".$item[$j]['���']."</td>";
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
				$SMS_CONTENT = "������ʼ���\n���⣺".$SUBJECT;
				send_sms( "", $LOGIN_USER_ID, $USERID, 2, $SMS_CONTENT, $REMIND_URL );
}


	message( "��ʾ", "�������ѷ���" );
	button_back( );
?>

</body></html>