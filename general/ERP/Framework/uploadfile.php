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
$sessionkeyName = $_POST['sessionkey'];
$var1 = isset( $_GET['var1'] ) ? $_GET['var1'] : "ATTACHMENT_ID";
$var2 = isset( $_GET['var2'] ) ? $_GET['var2'] : "ATTACHMENT_NAME";
if ( $_GET['action'] == "uploadfile" && $error == 0 )
{
				$path = "../attachment";
				$timeline = time( );
				$dirpath = $path."/".$timeline;
				is_dir( $path ) ? "" : mkdir( $path );
				is_dir( $dirpath ) ? "" : mkdir( $dirpath );
				$filepath = $dirpath."/".$name;
				copy( $tmp_name, $filepath );
				print "<SCRIPT language=JavaScript>\n \r\n\t\t\tvar parent_window = parent.dialogArguments;\n\n\r\n\t\t\tfunction add_value(user_id,user_name)\t{\n\n\r\n\t\t\t\tTO_VAL=parent.window.form1.{$var1}.value;\n\n\r\n\t\t\t\tif(TO_VAL.indexOf(\",\"+user_id+\",\")<0 && TO_VAL.indexOf(user_id+\",\")!=0)  {\n\r\n\t\t\t\t\tparent.ID_Array.push(user_id);\r\n\t\t\t\t\tparent.NAME_Array.push(user_name);\r\n\t\t\t\t\t//\r\n\t\t\t\t\tparent.form1.{$var1}.value = parent.ID_Array.toString();\n\r\n\t\t\t\t\t//\r\n\t\t\t\t\t//�ֶ����Ƹ�ֵ\r\n\t\t\t\t\tvar TextName = '';\r\n\t\t\t\t\tfor(i=0;i<parent.NAME_Array.length-1;i++)\t\t{\r\n\t\t\t\t\t\tvar TempIndex = parent.NAME_Array[i];\r\n\t\t\t\t\t\tTextName += TempIndex+\"*\";\r\n\t\t\t\t\t}\r\n\t\t\t\t\tTextName += parent.NAME_Array[i];\r\n\t\t\t\t\tparent.form1.{$var2}.value = TextName;\r\n\t\t\t\t}\n\r\n\t\t\t\t}\n\r\n\t\t\tadd_value('{$timeline}','{$name}');\n";
				print "</SCRIPT>\n";
				$text = $name;
				print "<script>\n";
				print "\r\n\t    var br = '';\r\n\t    if(parent.uploadArray.length % 2 == 0 && parent.uploadArray.length >1) \r\n\t\t\tbr = '<BR>';\r\n\t\telse\r\n\t\t\tbr = '';\r\n\r\n\t\tvar TempValueIndex = parent.uploadArray.length;\r\n\t\tparent.uploadArray.push(\"{$text}<input class=SmallButton onClick=DeleteFileArray(\"+TempValueIndex+\") type=button name=11 value=".$common_html['common_html']['delete'].">\"+br);\r\n\t\tparent.new_file.innerHTML = parent.uploadArray.toString();\r\n\t\t\n";
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

echo "<META http-equiv=Content-Type content=\"text/html; charset=gb2312\">\r\n<LINK href=\"../theme/";
echo $LOGIN_THEME;
echo "/style.css\" rel=stylesheet>\r\n<BODY class=bodycolor2 topMargin=5 >\r\n<table cellSpacing=0 cellPadding=3 width=\"100%\" border=0 valign=absmiddle height=100%  class=small>\r\n<tbody>\r\n\r\n";
echo "<s";
echo "cript language = \"JavaScript\"> \r\nfunction FormCheck() \r\n{\r\n\r\nif (document.form1.filename.value == \"\") \r\n{\r\nalert(\"filename:notnull\");\r\nreturn false;\r\n}\r\n\r\n}\r\n</script>\r\n\r\n<form name=form1 method=POST onsubmit=\"return FormCheck();\"  action=uploadfile.php?action=uploadfile  enctype=multipart/form-data>\r\n<tr width=\"100%\" class=TableData>\r\n<td valign=top width=\"100%\" align=left class=TableData>\r\n<input typ";
echo "e=file name=filename class=Smallinput>\r\n<input type=\"hidden\" name=sessionkey value=";
echo $sessionkey;
echo ">\r\n<input type=submit value=\"";
echo $common_html['common_html']['uploadfile'];
echo "\" name=send class=SmallButton>\r\n</td>\r\n</tr>\r\n</form>\r\n</table>";
?>
