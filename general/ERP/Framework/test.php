<?
require_once('html2fpdf/html2fpdf.php');

// activate Output-Buffer:
ob_start();
?>
<html>
<head>
<title>HTML 2 (F)PDF Project</title>
<META http-equiv=Content-Type content="text/html; charset=utf-8">
</head>
<body>
<div align="center"><img src="logo.gif" alt="HTML 2 PDF logo" /></div>
<h2 align="center">HTML 2 PDF Project≤‚ ‘</h2>
Below are the descriptions of each MENU button:
<ul>
<li><b><font color="red">HOME</font></b> - Returns to the main page (this one)</li>
<li><b>FEATURES</b> - Explains the script's main features</li>
<li><b>EXAMPLES</b> - A series of examples in which the script works</li>
<li><b>CLASS-DOC</b> - Some documentation about the used classes</li>
<li><b>LICENSE</b> - In case you want to distribute or modify the code</li>
<li><b>CREDITS</b> - (the name says it all)</li>
<li><b>FAQ</b> - Frequently asked questions...and answers!</li>
</ul>
<p>This project is hosted on Source Forge. DOWNLOAD IT <a
href="http://sourceforge.net/projects/html2fpdf" target="_blank">THERE</a>!</p>
This script was written on PHP 4.3.3 (should work on 4.0 and greater)
<br /><br/>
</body>
</html>
<?
// Output-Buffer in variable:
$html=ob_get_contents();
// delete Output-Buffer
ob_end_clean();
$pdf=new HTML2FPDF();
$pdf->AddGBFont('GB','∑¬ÀŒ_GB2312');
$pdf->AddPage();
$pdf->WriteHTML(iconv("UTF-8","GB2312",$html));
$pdf->Output("tmp.pdf",true);
?>
