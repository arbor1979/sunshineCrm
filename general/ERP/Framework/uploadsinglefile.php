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
$getvarname = isset( $_GET['varname'] ) ? $_GET['varname'] : "PHOTO";

if ( $getvarname == "PHOTO" )
{
				$fileText = "上传相片";
}
else
{
				$fileText = "上传附件";
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
