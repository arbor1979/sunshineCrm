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
 
         //���� <script>�ȿ�������������ݻ����ı���ʾ���ֵĴ���,�������Ҫ����flash��,�����Լ���<object>�Ĺ���  
        "/<(\/?)(script|i?frame|style|html|body|title|link|meta|INPUT|A|img|DIV|FONT|SPAN|\?|\%)([^>]*?)>/isU", 
        "/(<[^>]*)on[a-zA-Z]+\s*=([^>]*>)/isU",//����javascript��on�¼�  
   );  
   $tarr = array(  
 
        "",//���Ҫֱ���������ȫ�ı�ǩ�������������  
        "",
   );  
  $str = preg_replace( $farr,$tarr,$str);  
   return $str;  
}
print "<style>body{font-size:9pt;}</style>";
print $msg;
//echo "PDF file is generated successfully!";
?>