<?
require('html2fpdf.php');
function uhtml($str)  
{  
    $farr = array(  
        "/\s+/", //���˶���հ�  
         //���� <script>�ȿ�������������ݻ����ı���ʾ���ֵĴ���,�������Ҫ����flash��,�����Լ���<object>�Ĺ���  
        "/<(\/?)(script|i?frame|style|html|body|title|link|meta|INPUT|A|img|\?|\%)([^>]*?)>/isU", 
        "/(<[^>]*)on[a-zA-Z]+\s*=([^>]*>)/isU",//����javascript��on�¼�  
   );  
   $tarr = array(  
        " ",  
        "",//���Ҫֱ���������ȫ�ı�ǩ�������������  
        "",
   );  
  $str = preg_replace( $farr,$tarr,$str);  
   return $str;  
}
$pdf=new HTML2FPDF();
$pdf->AddGBFont('GB','����_GB2312');
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
//$strContent="����";
$pdf->WriteHTML(iconv("UTF-8","GB2312",$strContent));
ob_clean();
$pdf->Output("tmp.pdf",true);
//print $strContent;
//echo "PDF file is generated successfully!";
?>