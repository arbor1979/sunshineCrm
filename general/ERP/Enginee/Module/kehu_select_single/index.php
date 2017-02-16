<?php


	
require_once('../../../adodb/adodb.inc.php');
require_once('../../../config.inc.php');
require_once('../../../setting.inc.php');
require_once('../../../adodb/session/adodb-session2.php');

$GLOBAL_SESSION=returnsession();

$TO_ID=iconv('UTF-8','gbk',$TO_ID);
$TO_NAME=iconv('UTF-8','gbk',$TO_NAME);

if ( $TO_ID == "" || $TO_ID == "undefined" )
{
	$TO_ID = "TO_ID";
	$TO_NAME = "TO_NAME";
}
if ( $MANAGE_FLAG == "undefined" )
{
	$MANAGE_FLAG = "";
}
if ( $FORM_NAME == "" || $FORM_NAME == "undefined" )
{
	$FORM_NAME = "form1";
}
?>
<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<meta http-equiv="x-ua-compatible" content="IE=7"> 
<link rel="stylesheet" type="text/css" href="<?php echo ROOT_DIR?>theme/<?php echo $LOGIN_THEME?>/style.css" />
<link rel="stylesheet" type="text/css" href="<?php echo ROOT_DIR?>theme/<?php echo $LOGIN_THEME?>/menu_left.css" />
<?php
echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=gb2312\">\r\n\r\n</head>\r\n<frameset rows=\"*,30\"  rows=\"*\" frameborder=\"NO\" border=\"0\" framespacing=\"0\" id=\"bottom\">\r\n  <frameset cols=\"200,*\"  rows=\"*\" frameborder=\"AUTO\" border=\"0\" framespacing=\"0\">\r\n     <frame name=\"dept\" src=\"dept.php?TO_ID=";
echo urlencode($TO_ID);
echo "&TO_NAME=";
echo urlencode($TO_NAME);
echo "&MANAGE_FLAG=";
echo $MANAGE_FLAG;
echo "&FORM_NAME=";
echo $FORM_NAME;
echo "\">\r\n     <frame name=\"user\" src=\"user.php?TO_ID=";
echo urlencode($TO_ID);
echo "&TO_NAME=";
echo urlencode($TO_NAME);
echo "&MANAGE_FLAG=";
echo $MANAGE_FLAG;
echo "&FORM_NAME=";
echo $FORM_NAME;
echo "\">\r\n  </frameset>\r\n   <frame name=\"control\" scrolling=\"no\" src=\"control.php?TO_ID=";
echo urlencode($TO_ID);
echo "&TO_NAME=";
echo urlencode($TO_NAME);
echo "&MANAGE_FLAG=";
echo $MANAGE_FLAG;
echo "&FORM_NAME=";
echo $FORM_NAME;
echo "\">\r\n</frameset>\r\n";
?>
