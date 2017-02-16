<?php
/*
版权归属:郑州单点科技软件有限公司;
联系方式:0371-69663266;
公司地址:河南郑州经济技术开发区第五大街经北三路通信产业园四楼西南;
公司简介:郑州单点科技软件有限公司位于中国中部城市-郑州,成立于2007年1月,致力于把基于先进信息技术（包括通信技术）的最佳管理与业务实践普及到教育行业客户的管理与业务创新活动中，全面提供具有自主知识产权的教育管理软件、服务与解决方案，是中部最优秀的高校教育管理软件及中小学校管理软件提供商。目前己经有多家高职和中职类院校使用通达中部研发中心开发的软件和服务;

软件名称:单点科技软件开发基础性架构平台,以及在其基础之上扩展的任何性软件作品;
发行协议:数字化校园产品为商业软件,发行许可为LICENSE方式;单点CRM系统即SunshineCRM系统为GPLV3协议许可,GPLV3协议许可内容请到百度搜索;
特殊声明:软件所使用的ADODB库,PHPEXCEL库,SMTARY库归原作者所有,余下代码沿用上述声明;
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
				print "<SCRIPT language=JavaScript>\n \r\n\t\t\tvar parent_window = parent.dialogArguments;\n\n\r\n\t\t\tfunction add_value(user_id,user_name)\t{\n\n\r\n\t\t\t\tTO_VAL=parent.window.form1.{$var1}.value;\n\n\r\n\t\t\t\tif(TO_VAL.indexOf(\",\"+user_id+\",\")<0 && TO_VAL.indexOf(user_id+\",\")!=0)  {\n\r\n\t\t\t\t\tparent.ID_Array.push(user_id);\r\n\t\t\t\t\tparent.NAME_Array.push(user_name);\r\n\t\t\t\t\t//\r\n\t\t\t\t\tparent.form1.{$var1}.value = parent.ID_Array.toString();\n\r\n\t\t\t\t\t//\r\n\t\t\t\t\t//字段名称赋值\r\n\t\t\t\t\tvar TextName = '';\r\n\t\t\t\t\tfor(i=0;i<parent.NAME_Array.length-1;i++)\t\t{\r\n\t\t\t\t\t\tvar TempIndex = parent.NAME_Array[i];\r\n\t\t\t\t\t\tTextName += TempIndex+\"*\";\r\n\t\t\t\t\t}\r\n\t\t\t\t\tTextName += parent.NAME_Array[i];\r\n\t\t\t\t\tparent.form1.{$var2}.value = TextName;\r\n\t\t\t\t}\n\r\n\t\t\t\t}\n\r\n\t\t\tadd_value('{$timeline}','{$name}');\n";
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
