<?php
$filename=iconv('UTF-8','gb2312',$_GET['filename']);
header("Content-Type: application/vnd.ms-word;charset=gb2312");
header("Content-Disposition:filename=$filename.doc");
header("Pragma: public");  
header("Expires: 0");  
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");  
header("Content-Type: application/force-download");  
header("Content-Type: application/octet-stream");  
header("Content-Type: application/download");  
header("Content-Transfer-Encoding: binary ");  
$msg=$_POST['userdefine'];
$msg=urldecode($msg);
$msg=uhtml($msg);
$msg=iconv('UTF-8','gb2312',$msg);
$msg=str_replace("class=TableBlock", "border=1", $msg);
$msg=str_replace("class=TableHeader", "bgcolor=#DDDDDD", $msg);
$msg=str_replace("class=TableContent", "bgcolor=#EEEEEE", $msg);
$msg=str_replace("class=TableData", "bgcolor=#FFFFFF", $msg);
$msg=str_replace("class=TableControl", "bgcolor=#FFFFFF", $msg);
$msg=str_replace("class=\"TableBlock\"", "border=1", $msg);
$msg=str_replace("class=\"TableHeader\"", "bgcolor=#DDDDDD", $msg);
$msg=str_replace("class=\"TableContent\"", "bgcolor=#EEEEEE", $msg);
$msg=str_replace("class=\"TableData\"", "bgcolor=#FFFFFF", $msg);
$msg=str_replace("noWrap", "", $msg);
$msg=str_replace("></TD>", ">&nbsp;</TD>", $msg);
$msg=str_replace("TABLE>&nbsp;</TD>", "TABLE></TD>", $msg);
$msg=str_replace("width=\"65%\"", "width=\"100%\"", $msg);
$msg=str_replace("width=\"80%\"", "width=\"100%\"", $msg);
$msg=str_replace("width=\"85%\"", "width=\"100%\"", $msg);
function uhtml($str)  
{  
    $farr = array(  
 
         //过滤 <script>等可能引入恶意内容或恶意改变显示布局的代码,如果不需要插入flash等,还可以加入<object>的过滤  
        "/<(\/?)(script|i?frame|style|html|body|title|link|meta|INPUT|A|img|DIV|FONT|SPAN|\?|\%)([^>]*?)>/isU", 
        "/(<[^>]*)on[a-zA-Z]+\s*=([^>]*>)/isU",//过滤javascript的on事件  
   );  
   $tarr = array(  
 
        "",//如果要直接清除不安全的标签，这里可以留空  
        "",
   );  
  $str = preg_replace( $farr,$tarr,$str);  
   return $str;  
}
print "<style>body{font-size:9pt;}</style>";
print $msg;
//echo "PDF file is generated successfully!";
?>