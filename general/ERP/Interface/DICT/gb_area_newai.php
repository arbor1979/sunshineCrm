<?php
//######################�������-Ȩ�޽��鲿��##########################
SESSION_START();
require_once("lib.inc.php");
$GLOBAL_SESSION=returnsession();
require_once("systemprivateinc.php");
CheckSystemPrivate("���ֻ�У԰ϵͳ����-�����ֵ�");
//######################�������-Ȩ�޽��鲿��##########################


$GLOBAL_SESSION=returnsession();

$CurXueQi = returntablefield("edu_xueqiexec","��ǰѧ��",'1',"ѧ������");


if($_GET['���ν�ʦ']!="")	$SHOWTEXT = "1";
else		$SHOWTEXT = "0";

$goalfile = "../../Framework/system_config.ini";

if($_GET['action']=="")			{

	$parse_ini_file = parse_ini_file($goalfile);

	page_css("Ԥ��ʡ������");
	print "<SCRIPT>
	function FormCheck()
	{
		//if (document.form1.���ν�ʦ.value == \"\") {
		//alert(\"��ʦ��Ϣû����д\");
		//return false;}
	}
	function td_calendar(fieldname) {
		myleft=document.body.scrollLeft+event.clientX-event.offsetX-80;
		mytop=document.body.scrollTop+event.clientY-event.offsetY+140;
		window.showModalDialog(fieldname,self,\"edge:raised;scroll:0;status:0;help:0;resizable:1;dialogWidth:280px;dialogHeight:200px;dialogTop:\"+mytop+\"px;dialogLeft:\"+myleft+\"px\");
		}
	</SCRIPT>";
	print "<FORM name=form1 onsubmit=\"return FormCheck();\"  action=\"?action=DataDeal&pageid=1\" method=post encType=multipart/form-data>";
	table_begin("80%");
	print "<tr class=TableHeader><td colspan=2>&nbsp;Ԥ��ʡ������[��ĳЩʹ�õ�ʡ�ݵ���������������ʱ,����Ĭ�ϵ�ֵ]</td></tr>";
	print_select_countryCode($parse_ini_file['provinces'],$fields);
	print_submit("�ύ");
	table_end();
	form_end();


	exit;
}






if($_GET['action']=="DataDeal")			{

page_css("Ԥ��ʡ������");


//$file = file($goalfile);
$DataText = "[section]
provinces=".$_POST['areaCode'];
@!$handle = fopen($goalfile, 'w');
fwrite($handle, $DataText);
fclose($handle);

//print_R($_POST);

print_infor("������ݲ����Ѿ��ɹ�,�뷵��","location='?'","location='?'","?");

exit;

}




?>