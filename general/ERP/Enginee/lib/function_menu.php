<?php
function menu_table_3($showtext,$url,$pic,$tree_pic="tree_blank.gif",$tree_pic2="tree_line.gif",$tree_pic3='tree_line.gif',$addfile='menu.php')	{
	print "<TABLE class=small cellSpacing=0 cellPadding=0 border=0>\n";
    print "<TBODY>\n";
    print "<TR>\n";
    print "<TD><IMG src=\"images/$tree_pic2\"></TD>\n";
    print "<TD><IMG src=\"images/$tree_pic3\" border=0></TD>\n";
    print "<TD><IMG src=\"images/$tree_pic\"></TD>\n";
    print "<TD><IMG height=18 alt=\"$showtext\" src=\"images/$pic\" \n";
    print "width=18 border=0></TD>\n";
    print "<TD colSpan=2><A onclick=\"openURL('$url')\" href=\"$addfile#A\">&nbsp;$showtext</A>\n";
	print "</TD></TR></TBODY></TABLE>\n";
}
function menu_table_2($showtext,$url,$pic,$tree_pic="tree_blank.gif",$tree_pic2="tree_line.gif",$addfile='menu.php')	{
	print "<TABLE class=small cellSpacing=0 cellPadding=0 border=0>\n";
    print "<TBODY>\n";
    print "<TR>\n";
    print "<TD><IMG src=\"images/$tree_pic2\"></TD>\n";
    print "<TD><IMG src=\"images/$tree_pic\"></TD>\n";
    print "<TD><IMG height=18 alt=\"$showtext\" src=\"images/$pic\" \n";
    print "width=18 border=0></TD>\n";
    print "<TD colSpan=2><A onclick=\"openURL('$url')\" href=\"$addfile#A\">&nbsp;$showtext</A>\n";
	print "</TD></TR></TBODY></TABLE>\n";
}
function parent_table_1($showtext="我的办公桌",$pic="mytable.gif",$id="01",$image='tree_plus.gif',$addfile='menu.php')	{
	global $menu_mark;
	print "<TABLE class=small cellSpacing=0 cellPadding=0 border=0>\n";
    print "<TBODY>\n";
    print "<TR>\n";
    print "<TD><IMG class=outline id=".$menu_mark.$id." style=\"CURSOR: hand\" src=\"images/$image\"></TD>\n";
    print "<TD><IMG height=18 alt=\"$showtext\" src=\"images/$pic\" width=18 border=0></TD>\n";
    print "<TD colSpan=3><A onclick=".$menu_mark.$id.".click(); href=\"$addfile#A\">&nbsp;$showtext</A>\n";
	print "</TD></TR></TBODY></TABLE>\n";
}
function parent_table_2($showtext="电子邮件",$pic="@mail.gif",$id="01",$tree_plus='tree_plus.gif',$tree_pic2='tree_line.gif',$addfile='menu.php')	{
	global $menu_mark;
	print "<TABLE class=small cellSpacing=0 cellPadding=0 border=0>\n";
    print "<TBODY>\n";
    print "<TR>\n";
    print "<TD><IMG src=\"images/$tree_pic2\" border=0></TD>\n";
    print "<TD><IMG class=outline id=".$menu_mark.$id." style=\"CURSOR: hand\" src=\"images/$tree_plus\"></TD>\n";
    print "<TD><IMG height=18 alt=\"$showtext\" src=\"images/$pic\" width=18 border=0></TD>\n";
    print "<TD colSpan=2><A onclick=".$menu_mark.$id.".click(); href=\"$addfile#A\">&nbsp;$showtext</A>\n";
	print "</TD></TR></TBODY></TABLE>\n";
}
function part_table_begin($id="0104")	{
	global $menu_mark;
	print "<TABLE class=small id=".$menu_mark.$id."d style=\"DISPLAY: none\" cellSpacing=0 cellPadding=0 border=0>\n";
    print "<TBODY>\n";
    print "<TR>\n";
    print "<TD>\n";
}
function part_table_end()	{
	print "</TD></TR></TBODY></TABLE>\n";
}


function system_menu_js($location='parent.parent.main')	{

?>

<SCRIPT language=JavaScript>
var openedid;
var openedid_ft;
var flag=0,sflag=0;

function clickHandler()
{
	var targetid,srcelement,targetelement;
	var strbuf;
	srcelement=window.event.srcElement;

	//-------- 如果点击了展开或收缩按钮---------
	if(srcelement.className=="outline")
	{
		targetid=srcelement.id+"d";
		targetelement=document.getElementById(targetid);
		if (targetelement.style.display=="none")
		{
			targetelement.style.display='';
			strbuf=srcelement.src;
			if(strbuf.indexOf("plus.gif")>-1)
				srcelement.src="./images/tree_minus.gif";
			else
				srcelement.src="./images/tree_minusl.gif";
		}
		else
		{
			targetelement.style.display="none";
			strbuf=srcelement.src;
			if(strbuf.indexOf("minus.gif")>-1)
				srcelement.src="./images/tree_plus.gif";
			else
				srcelement.src="./images/tree_plusl.gif";
		}
	}
}

document.onclick = clickHandler;

function openURL(URL)
{
    <?php echo $location?>.location=URL;
}

</SCRIPT>
<?php
}
function system_menu_css()		{
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML><HEAD><TITLE></TITLE>
<META http-equiv=Content-Type content="text/html; charset=gb2312"><LINK
href="images/style_menu.css" rel=stylesheet>
<STYLE type=text/css>A:link {
	COLOR: #000000; TEXT-DECORATION: none
}
A:visited {
	COLOR: #000000; TEXT-DECORATION: none
}
A:active {
	COLOR: #3333ff; TEXT-DECORATION: none
}
A:hover {
	COLOR: #ff0000; TEXT-DECORATION: none
}
</STYLE>

<META content="MSHTML 6.00.2800.1106" name=GENERATOR></HEAD>
<BODY bgColor=#d9e8ff leftMargin=0 topMargin=3 rightMargin=0 marginheight="0"
marginwidth="0"><!-- OA树开始-->
<?php
}
?>