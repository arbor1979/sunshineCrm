<?php
/*
��Ȩ����:֣�ݵ���Ƽ�������޹�˾;
��ϵ��ʽ:0371-69663266;
��˾��ַ:����֣�ݾ��ü��������������־�����·ͨ�Ų�ҵ԰��¥����;
��˾���:֣�ݵ���Ƽ�������޹�˾λ���й��в�����-֣��,������2007��1��,�����ڰѻ����Ƚ���Ϣ����������ͨ�ż���������ѹ�����ҵ��ʵ���ռ���������ҵ�ͻ��Ĺ�����ҵ���»�У�ȫ���ṩ��������֪ʶ��Ȩ�Ľ�����������������������������в�������ĸ�У���������������СѧУ��������ṩ�̡�Ŀǰ�����ж�Ҹ�ְ����ְ��ԺУʹ��ͨ���в��з����Ŀ���������ͷ���;

�������:����Ƽ�������������Լܹ�ƽ̨,�Լ��������֮����չ���κ��������Ʒ;
����Э��:���ֻ�У԰��ƷΪ��ҵ���,�������ΪLICENSE��ʽ;����CRMϵͳ��SunshineCRMϵͳΪGPLV3Э�����,GPLV3Э����������뵽�ٶ�����;
��������:�����ʹ�õ�ADODB��,PHPEXCEL��,SMTARY���ԭ��������,���´���������������;
*/

require_once( "lib.inc.php" );
$GLOBAL_SESSION = returnsession( );
$sessionkey = returnsesskey( );
$common_html = returnsystemlang( "common_html" );
$name = $_FILES['filename']['name'];
$type = $_FILES['filename']['type'];
$tmp_name = $_FILES['filename']['tmp_name'];
$error = $_FILES['filename']['error'];
$getvarname = isset( $_GET['varname'] ) ? $_GET['varname'] : "PHOTO";

if ( $getvarname == "PHOTO" )
{
				$fileText = "�ϴ���Ƭ";
}
else
{
				$fileText = "�ϴ�����";
}

if ( $_GET['action'] == "uploadfile" && $error == 0 )
{
				$path = "attachment";
				$timeline = time( );
				$dirpath = $path."/".$timeline;
				is_dir( $path ) ? "" : mkdir( $path );
				is_dir( $dirpath ) ? "" : mkdir( $dirpath );
				$filepath = $dirpath."/".$name;
				copy( $tmp_name, $filepath );
				$PHP_SELF_ARRAY = explode( "/", $_SERVER['PHP_SELF'] );
				$IndexNumber = sizeof( $PHP_SELF_ARRAY ) - 2;
				$DirNameSelf = $PHP_SELF_ARRAY[$IndexNubmer];
				$url='http://'.$_SERVER['HTTP_HOST'];
				$varname=$url."/general/ERP/Framework/download.php?action=picturefile&sessionkey={$sessionkey}&attachmentid={$timeline}&attachmentname={$name}";
				/*
				if ( $DirNameSelf != "Framework" )
				{
								$varname = "../../Framework/download.php?action=picturefile&sessionkey={$sessionkey}&attachmentid={$timeline}&attachmentname={$name}";
				}
				else
				{
								$varname = "download.php?action=picturefile&sessionkey={$sessionkey}&attachmentid={$timeline}&attachmentname={$name}";
				}
				*/
				//print $varname;
				print "<SCRIPT language=JavaScript>\n\n";
				print "parent.form1.{$getvarname}.value=\"{$varname}\";\n";
				print "</SCRIPT>\n";
				$text = "<a href='$varname'><img src='{$varname}' border=0 width=100></a>";
				print "<script>\n";
				print "parent.new_file_".$getvarname.".innerHTML=\"{$text}\";\n";
				print "</script>\n";
}
else
{
				if ( $_GET['action'] == "uploadfile" && $error != 0 )
				{
								print "upload file failed !ERROR CODE:{$error}";
								exit( );
				}
}
$LOGIN_THEME = $_SESSION['LOGIN_THEME'];

echo "\r\n<META http-equiv=Content-Type content=\"text/html; charset=gb2312\">\r\n<LINK href=\"../theme/";
echo $LOGIN_THEME;
echo "/style.css\" rel=stylesheet>\r\n<BODY class=bodycolor2 topMargin=5 >\r\n<table cellSpacing=0 cellPadding=3 width=\"100%\" border=0 valign=absmiddle height=100%  class=small>\r\n<tbody>\r\n\r\n";
echo "<s";
echo "cript language = \"JavaScript\"> \r\nfunction FormCheck() \r\n{\r\n\r\nif (document.form1.filename.value == \"\") \r\n{\r\nalert(\"filename:notnull\");\r\nreturn false;\r\n}\r\n\r\n}\r\n</script>\r\n\r\n<form name=form1 method=POST onsubmit=\"return FormCheck();\"  action=\"?action=uploadfile&varname=$getvarname\"  enctype=multipart/form-data>\r\n<tr width=\"100%\" class=TableData>\r\n<td valign=top width=\"100%\" align=left class=TableData>\r\n<input type=file name=";
echo "filename class=Smallinput>\r\n<input type=submit value=";
echo $fileText;
echo " name=send class=SmallButton>\r\n</td>\r\n</tr>\r\n</form>\r\n</table>";
?>
