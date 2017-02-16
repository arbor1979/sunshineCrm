<?php

ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL);
error_reporting(E_WARNING | E_ERROR);
@set_time_limit(120000);


$SERVER_NAME = $_SERVER['SERVER_NAME'];



require_once('../adodb/adodb.inc.php');
require_once('../config.inc.php');
require_once('../setting.inc.php');
require_once('../Enginee/lib/function_system.php');




###############################################################################
//重写菜单文件开始
###############################################################################



$MetaDatabases = $db->MetaDatabases();
if(in_array("TD_OA",$MetaDatabases))		{

	$filename_all = "sys_function_all.php";
	$filename_all_text = "<?php\n\$SYS_FUNCTION = array(\n";

	$filename_sinlge = "sys_function.php";
	$filename_sinlge_text = "<?php\n\$SYS_FUNCTION = array(\n";

	$sql = "select * from TD_OA.sys_menu order by MENU_ID";
	$rs = $db->Execute($sql);
	$rsX_a = $rs->GetArray();
	for($iX=0;$iX<sizeof($rsX_a);$iX++)			{
		$MENU_ID = $rsX_a[$iX]['MENU_ID'];
		$MENU_NAME = $rsX_a[$iX]['MENU_NAME'];
		$IMAGE = $rsX_a[$iX]['IMAGE'];
		$filename_all_text .= "   \"m$MENU_ID\" => array(\"MENU_ID\" => \"$MENU_ID\", \"FUNC_NAME\" => \"$MENU_NAME\", \"IMAGE\" => \"$IMAGE\"),\n";

		$sql = "select * from TD_OA.sys_function where MENU_ID like '$MENU_ID%' order by MENU_ID";
		$rs = $db->Execute($sql);
		$rs_a = $rs->GetArray();
		for($i=0;$i<sizeof($rs_a);$i++)			{
			$FUNC_ID = $rs_a[$i]['FUNC_ID'];
			$MENU_ID = $rs_a[$i]['MENU_ID'];
			$FUNC_NAME = $rs_a[$i]['FUNC_NAME'];
			$FUNC_CODE = $rs_a[$i]['FUNC_CODE'];
			$FUNC_CODE_ARRAY = explode('/',$FUNC_CODE);;
			$IMAGE = $FUNC_CODE_ARRAY[0];
			$filename_all_text .= "   \"$FUNC_ID\" => array(\"FUNC_ID\" => \"$FUNC_ID\", \"MENU_ID\" => \"$MENU_ID\", \"FUNC_NAME\" => \"$FUNC_NAME\", \"FUNC_CODE\" => \"$FUNC_CODE\", \"IMAGE\" => \"$IMAGE\"),\n";
			$filename_sinlge_text .= "   \"$FUNC_ID\" => \"$FUNC_CODE\",\n";

		}

	}

	$filename_all_text .= ");\n?>\n";
	$filename_sinlge_text .= ");\n?>\n";


	writeFile11111(ROOT_DIR."/inc/".$filename_all,$filename_all_text);
	writeFile11111(ROOT_DIR."/inc/".$filename_sinlge,$filename_sinlge_text);


}
###############################################################################
//重写菜单文件结束
###############################################################################
function writeFile11111($filename,$text)        {
	if(strlen($text)==0)    return;
	@!$handle = @fopen($filename, 'w');
	if (!@fwrite($handle, $text)) {
		exit;
		}
	@fclose($handle);
	//highlight_string($text);
}
?>