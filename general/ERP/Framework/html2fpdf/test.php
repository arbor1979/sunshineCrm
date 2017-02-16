<?
require('html2fpdf.php');
function uhtml($str)  
{  
    $farr = array(  
        "/\s+/", //过滤多余空白  
         //过滤 <script>等可能引入恶意内容或恶意改变显示布局的代码,如果不需要插入flash等,还可以加入<object>的过滤  
        "/<(\/?)(script|i?frame|style|html|body|title|link|meta|INPUT|A|img|\?|\%)([^>]*?)>/isU", 
        "/(<[^>]*)on[a-zA-Z]+\s*=([^>]*>)/isU",//过滤javascript的on事件  
   );  
   $tarr = array(  
        " ",  
        "",//如果要直接清除不安全的标签，这里可以留空  
        "",
   );  
  $str = preg_replace( $farr,$tarr,$str);  
   return $str;  
}
$pdf=new HTML2FPDF();
$pdf->AddGBFont('GB','仿宋_GB2312');
$pdf->SetFontSize('8');
$pdf->AddPage();
$fp = fopen("sample.html","r");
$strContent = fread($fp, filesize("sample.html"));
fclose($fp);
$msg=urldecode($_POST['userdefine']);
$msg=str_replace("class=TableBlock", "border=1", $msg);
$msg=str_replace("class=TableHeader", "bgcolor=#DDDDDD", $msg);
$msg=str_replace("class=TableContent", "bgcolor=#EEEEEE", $msg);
$msg=str_replace("class=TableDatat", "bgcolor=#FFFFFF", $msg);
$msg=str_replace("<tr>", "<TR>", $msg);
$msg=str_replace("</tr>", "</TR>", $msg);
$msg=str_replace("<td", "<TD", $msg);
$msg=str_replace("</td>", "</TD>", $msg);
$msg=str_replace("nowrap", " ", $msg);
$strContent.=uhtml($msg);
//$strContent="测试";
$pdf->WriteHTML(iconv("UTF-8","GB2312",$strContent));
ob_clean();
$pdf->Output("tmp.pdf",true);
//print $strContent;
//echo "PDF file is generated successfully!";
?>