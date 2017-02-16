<?php
//######################教育组件-权限较验部分##########################
SESSION_START();
require_once("lib.inc.php");
$GLOBAL_SESSION=returnsession();
require_once("systemprivateinc.php");
CheckSystemPrivate("数字化校园系统设置-数据字典");
//######################教育组件-权限较验部分##########################


$GLOBAL_SESSION=returnsession();

$CurXueQi = returntablefield("edu_xueqiexec","当前学期",'1',"学期名称");


if($_GET['开课教师']!="")	$SHOWTEXT = "1";
else		$SHOWTEXT = "0";

$goalfile = "../../Framework/system_config.ini";

if($_GET['action']=="")			{

	$parse_ini_file = parse_ini_file($goalfile);

	page_css("预设省份区域");
	print "<SCRIPT>
	function FormCheck()
	{
		//if (document.form1.开课教师.value == \"\") {
		//alert(\"教师信息没有填写\");
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
	print "<tr class=TableHeader><td colspan=2>&nbsp;预设省份区域[在某些使用到省份地市区县三级联动时,进行默认的值]</td></tr>";
	print_select_countryCode($parse_ini_file['provinces'],$fields);
	print_submit("提交");
	table_end();
	form_end();


	exit;
}






if($_GET['action']=="DataDeal")			{

page_css("预设省份区域");


//$file = file($goalfile);
$DataText = "[section]
provinces=".$_POST['areaCode'];
@!$handle = fopen($goalfile, 'w');
fwrite($handle, $DataText);
fclose($handle);

//print_R($_POST);

print_infor("你的数据操作已经成功,请返回","location='?'","location='?'","?");

exit;

}




?>