<?php
function getpagedata($sql,$sql_num,$pageid,$functionname,$tablename,$add,$add_var,$width="450",$pagenum="15",$isshowtableheader='',$action_page='action_page',$action_page_value='action_page_value')	{
global $db;
global $html_etc;
global $common_html;
print_R($common_html['common_html']);
//require_once('lang/getpagedata_html.php');
$rs = &$db->CacheExecute(15,$sql_num);
$rc=$rs->fields['num'];
$ROWS_PAGE=$pagenum;
$pagenums=ceil($rc/$ROWS_PAGE);
if($pageid==""||empty($pageid)){$pageid=1;}
if($pageid>$pagenums){$pageid=$pagenums;}
$from=($pageid-1)*$ROWS_PAGE;
$rsl=$db->CacheSelectLimit(15,$sql,$ROWS_PAGE,$from);
//require_once("./js/choose_all_$choose_lang.js");
table_begin($width);
if($isshowtableheader=='')				{
$function_header="show".$tablename."_header";
$function_header();
}
else if($notshowtableheader=='notshowtableheader')		{
}
else if($isshowtableheader!='notshowtableheader'&&$isshowtableheader!='')	{
$isshowtableheader();
}
else {
}
while(!$rsl->EOF)	{
	$functionname($rsl);
	$rsl->MoveNext();
}
//print "<TABLE class=small cellSpacing=1 cellPadding=3 width=$width align=center border=0>";
print "<tr><td class=TableData noWrap colspan=10>";
if($add!=""&&$add_var!="")	{
if($pageid<=1) {echo "".$common_html['common_html']['firstpage']."　";echo "".$common_html['common_html']['prevpage']."　";}  
else {	
	echo "<a href=\"$PHP_SELF?$add=$add_var&$action_page=$action_page_value&pageid=1\" title=\"".$common_html['common_html']['firstpage']."\">".$common_html['common_html']['firstpage']."</a>　";
	echo "<a href=\"$PHP_SELF?$add=$add_var&$action_page=$action_page_value&pageid=".($pageid-1)."\" title=\"".$common_html['common_html']['prevpage']."\">".$common_html['common_html']['prevpage']."</a>　";
	}//end if
if($pageid==$pagenums) {echo "".$common_html['common_html']['nextpage']."　";echo "".$common_html['common_html']['lastpage']."";}
else {	
	echo "<a href=\"$PHP_SELF?$add=$add_var&$action_page=$action_page_value&pageid=".($pageid+1)."\" title=\"".$common_html['common_html']['nextpage']."\">".$common_html['common_html']['nextpage']."</a>　";
	echo "<a href=\"$PHP_SELF?$add=$add_var&$action_page=$action_page_value&pageid=$pagenums\" title=\"".$common_html['common_html']['lastpage']."\">".$common_html['common_html']['lastpage']."</a>　";
	}//end if
}
else	{
	if($pageid<=1) {echo "".$common_html['common_html']['firstpage']."　";echo "".$common_html['common_html']['prevpage']."　";}  
else {	
	echo "<a href=\"$PHP_SELF?pageid=1&$action_page=$action_page_value\" title=\"".$common_html['common_html']['firstpage']."\">".$common_html['common_html']['firstpage']."</a>　";
	echo "<a href=\"$PHP_SELF?$action_page=$action_page_value&pageid=".($pageid-1)."\" title=\"".$common_html['common_html']['prevpage']."\">".$common_html['common_html']['prevpage']."</a>　";
	}//end if
if($pageid==$pagenums) {echo "".$common_html['common_html']['nextpage']."　";echo "".$common_html['common_html']['lastpage']."　";}
else {	
	echo "<a href=\"$PHP_SELF?$action_page=$action_page_value&pageid=".($pageid+1)."\" title=\"".$common_html['common_html']['nextpage']."\">".$common_html['common_html']['nextpage']."</a>　";
	echo "<a href=\"$PHP_SELF?$action_page=$action_page_value&pageid=$pagenums\" title=\"".$common_html['common_html']['lastpage']."\">".$common_html['common_html']['lastpage']."</a>　";
	}//end if
}
print "( ".$common_html['common_html']['page']." ".$pageid."/".$pagenums."　 ".$rc ." )\n";	
print "<input type=\"hidden\" name=\"ADD_INPUT\" value=\"$add\">\n";
print "<input type=\"hidden\" name=\"ADD_VAR_INPUT\" value=\"$add_var\">\n";
print "<input type=\"hidden\" name=\"action_page\" value=\"$action_page\">\n";
print "<input type=\"hidden\" name=\"action_page_value\" value=\"$action_page_value\">\n";
print "<input type=\"button\" value=\"".$common_html['common_html']['indexto']."\" class=\"SmallButton\" onclick=\"set_page();\" title=\"".$common_html['common_html']['indexto']."\">&nbsp;\n";
print "<input type=\"text\" name=\"PAGE_NUM\" value=\"$pageid\" class=\"SmallInput\" size=\"2\">&nbsp;&nbsp;\n";
print "</td></tr></table>";	
}



//###############################################################################
//
//
//
//###############################################################################


function getpagedata_checkall($sql,$sql_num,$pageid,$functionname,$tablename,$add,$add_var,$width="450",$pagenum="15",$isshowtableheader='',$disabled='',$action_page='action_page',$action_page_value='action_page_value')	{
global $db;
global $html_etc;
global $common_html;

//require_once('lang/getpagedata_html.php');
$rs = &$db->Execute($sql_num);
$rc=$rs->fields['num'];
if($rc==0)		{
	print_infor($common_html['common_html']['norecord'],'trip',"location='?action=init'");
	exit;
}
$ROWS_PAGE=$pagenum;
$pagenums=ceil($rc/$ROWS_PAGE);
if($pageid==""||empty($pageid)){$pageid=1;}
if($pageid>$pagenums){$pageid=$pagenums;}
$from=($pageid-1)*$ROWS_PAGE;
$rsl=$db->CacheSelectLimit(15,$sql,$ROWS_PAGE,$from);
require_once("./lib/choose_all_en.js");
table_begin($width);

if($isshowtableheader=='')				{
$function_header="show".$tablename."_header";
$function_header();
}
else if($notshowtableheader=='notshowtableheader')		{
}
else if($isshowtableheader!='notshowtableheader'&&$isshowtableheader!='')	{
$isshowtableheader();
}
else {
}

while(!$rsl->EOF)	{
	$functionname($rsl,$pageid);
	$rsl->MoveNext();
}

print "<tr><td class=TableData noWrap colspan=20>";

if($rc==0)		{
	print "<input type=\"checkbox\" name=\"allbox\" disabled onClick=\"check_all();\">".$common_html['common_html']['chooseall']." &nbsp;&nbsp;\n";
	print "<input type=\"button\"  value=\"".$common_html['common_html']['delete']."\" class=\"SmallButton\" disabled onClick=\"delete_mail();\" title=\"".$common_html['common_html']['delete']."\"> &nbsp;&nbsp;&nbsp;&nbsp;\n";
}
else	{
	print "<input type=\"checkbox\" name=\"allbox\"  onClick=\"check_all();\">".$common_html['common_html']['chooseall']." &nbsp;&nbsp;\n";
	print "<input type=\"button\"  value=\"".$common_html['common_html']['delete']."\" class=\"SmallButton\" $disabled onClick=\"delete_mail();\" title=\"".$common_html['common_html']['delete']."\"> &nbsp;&nbsp;&nbsp;&nbsp;\n";
}

if($add!=""&&$add_var!="")	{
if($pageid<=1) {echo "".$common_html['common_html']['firstpage']."　";echo "".$common_html['common_html']['prevpage']."　";}  
else {	
	echo "<a href=\"$PHP_SELF?$add=$add_var&pageid=1\" title=\"".$common_html['common_html']['firstpage']."\">".$common_html['common_html']['firstpage']."</a>　";
	echo "<a href=\"$PHP_SELF?$add=$add_var&pageid=".($pageid-1)."\" title=\"".$common_html['common_html']['prevpage']."\">".$common_html['common_html']['prevpage']."</a>　";
	}//end if
if($pageid==$pagenums) {echo "".$common_html['common_html']['nextpage']."　";echo "".$common_html['common_html']['lastpage']."";}
else {	
	echo "<a href=\"$PHP_SELF?$add=$add_var&pageid=".($pageid+1)."\" title=\"".$common_html['common_html']['nextpage']."\">".$common_html['common_html']['nextpage']."</a>　";
	echo "<a href=\"$PHP_SELF?$add=$add_var&pageid=$pagenums\" title=\"".$common_html['common_html']['lastpage']."\">".$common_html['common_html']['lastpage']."</a>　";
	}//end if
}
else	{
	if($pageid<=1) {echo "".$common_html['common_html']['firstpage']."　";echo "".$common_html['common_html']['prevpage']."　";}  
else {	
	echo "<a href=\"$PHP_SELF?pageid=1\" title=\"".$common_html['common_html']['firstpage']."\">".$common_html['common_html']['firstpage']."</a>　";
	echo "<a href=\"$PHP_SELF?pageid=".($pageid-1)."\" title=\"".$common_html['common_html']['prevpage']."\">".$common_html['common_html']['prevpage']."</a>　";
	}//end if
if($pageid==$pagenums) {echo "".$common_html['common_html']['nextpage']."　";echo "".$common_html['common_html']['lastpage']."　";}
else {	
	echo "<a href=\"$PHP_SELF?pageid=".($pageid+1)."\" title=\"".$common_html['common_html']['nextpage']."\">".$common_html['common_html']['nextpage']."</a>　";
	echo "<a href=\"$PHP_SELF?pageid=$pagenums\" title=\"".$common_html['common_html']['lastpage']."\">".$common_html['common_html']['lastpage']."</a>　";
	}//end if
}
print "( ".$common_html['common_html']['page']." ".$pageid."/".$pagenums."　 ".$rc ." )\n";
if($add==''||$add_var=='')	{
	$add='add';
	$add_var='add_var';
}
print "<input type=\"hidden\" name=\"ADD_INPUT\" value=\"$add\">\n";
print "<input type=\"hidden\" name=\"ADD_VAR_INPUT\" value=\"$add_var\">\n";
print "<input type=\"hidden\" name=\"action_page\" value=\"$action_page\">\n";
print "<input type=\"hidden\" name=\"action_page_value\" value=\"$action_page_value\">\n";
print "<input type=\"button\"  value=\"".$common_html['common_html']['indexto']."\" class=\"SmallButton\" onclick=\"set_page();\" title=\"".$common_html['common_html']['indexto']."\">&nbsp;\n";
print "<input type=\"text\" name=\"PAGE_NUM\" value=\"$pageid\" class=\"SmallInput\" size=\"2\">&nbsp;&nbsp;\n";
print "</td></tr>\n";
print "</table>";	
}
?>
