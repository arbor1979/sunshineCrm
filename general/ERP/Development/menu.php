<?php
require_once('lib.inc.php');
require_once('../Enginee/newai.php');
$GLOBA_SESSION=returnsession();
global $SUNSHINE_USER_ID_VAR,$_SESSION,$SUNSHINE_USER_PRIV_VAR;
$lang=returnsystemlang();
$USER_PRIV=$_SESSION[$SUNSHINE_USER_PRIV_VAR];
$USER_ID=$_SESSION[$SUNSHINE_USER_ID_VAR];
//$USER_PRIV=($USER_PRIV!='')?$USER_PRIV:returntablefield('user','USER_ID',$USER_ID,'PRIV_NO');
$FUNC_ID_STR_SYS=returntablefield('user','USER_ID',$USER_ID,'FUNC_ID_STR');
$FUNC_ID_STR_ARRAY=explode(',',$FUNC_ID_STR_SYS);
//print_R($_SESSION);



?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML><HEAD><TITLE></TITLE>
<META http-equiv=Content-Type content="text/html; charset=gb2312">
<LINK href="<?php echo ROOT_DIR?>theme/<?php echo $LOGIN_THEME?>/style.css" rel=stylesheet>
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
<BODY class=panel ><!-- OA树开始-->
<?php
$ExecTimeBegin=getmicrotime();
global $db;
$sql="select * from sys_function order by MENU_ID";
$rs=$db->CacheExecute(1,$sql);
$rs_array=$rs->GetArray();//print_R($rs_array);exit;
$menu_mark='MENU_';
switch($systemlang)					{
	case 'en':
		$FUNC_NAME_MENU='ENGLISHNAME';
		break;
	case 'zh':
		$FUNC_NAME_MENU='FUNC_NAME';
		break;
	default:
		$FUNC_NAME_MENU='FUNC_NAME';
}
foreach($rs_array as $list)			{
	$FUNC_ID=$list['FUNC_ID'];
	$ischecked=in_array($FUNC_ID,$FUNC_ID_STR_ARRAY);
	if($ischecked)					{
	$strlen=strlen($list['MENU_ID']);
	switch($strlen)		{
		case 2:
			print $list['MENU_ID']."<BR>";
			break;
		case 4:
			$menu['index'][substr($list['MENU_ID'],0,2)][substr($list['MENU_ID'],2,2)]=$list['MENU_ID'];
			$menu['index_name'][$FUNC_NAME_MENU][''.$list['MENU_ID'].'']=$list[$FUNC_NAME_MENU];
			$menu['index_name']['FUNC_CODE'][''.$list['MENU_ID'].'']=$list['FUNC_CODE'];
			$menu['index_name']['FUNC_LINK'][''.$list['MENU_ID'].'']=$list['FUNC_LINK'];
			$menu['index_name']['FUNC_ID'][''.$list['MENU_ID'].'']=$list['FUNC_ID'];
			break;
		case 6:
			$menu['index'][substr($list['MENU_ID'],0,4)][substr($list['MENU_ID'],4,2)]=$list['MENU_ID'];
			$menu['index_name'][$FUNC_NAME_MENU][''.$list['MENU_ID'].'']=$list[$FUNC_NAME_MENU];
			$menu['index_name']['FUNC_CODE'][''.$list['MENU_ID'].'']=$list['FUNC_CODE'];
			$menu['index_name']['FUNC_LINK'][''.$list['MENU_ID'].'']=$list['FUNC_LINK'];
			$menu['index_name']['FUNC_ID'][''.$list['MENU_ID'].'']=$list['FUNC_ID'];
			break;
	}//end switch
	isset($ischecked);
	}
	else	{
	}
}
//print_R($menu);exit;
//asort($menu['index']);print_R($menu['index']);exit;
//print_R($menu['index']['09']);
//print_R($menu_affixation);
$sql="select * from sys_menu order by MENU_ID";
$rs_menu=$db->Execute($sql);
$rs_array_menu=$rs_menu->GetArray();
$i_menu=0;

switch($systemlang)					{
	case 'en':
		$MENU_NAME_MENU='ENGLISHNAME';
		break;
	case 'zh':
		$MENU_NAME_MENU='MENU_NAME';
		break;
	default:
		$MENU_NAME_MENU='MENU_NAME';
}

foreach($rs_array_menu as $list_menu)	{
	if(++$i_menu == sizeof($rs_array_menu))		{
		$tree_pic2="tree_transp.gif";
		$image='tree_plusl.gif';
	}
	else		{
		$tree_pic2="tree_line.gif";
		$image='tree_plus.gif';
	}
	//purview begin
	if(sizeof($menu['index'][''.$list_menu['MENU_ID'].''])>0)					{
	parent_table_1($list_menu[$MENU_NAME_MENU],$list_menu['IMAGE'].".gif",$list_menu['MENU_ID'],$image);	
	
	part_table_begin($list_menu['MENU_ID']);
	sort($menu['index'][''.$list_menu['MENU_ID'].'']);
	$i=0;
	foreach($menu['index'][''.$list_menu['MENU_ID'].''] as $menu_list)		{
		$menu_2=$menu['index'][$menu_list];		++$i;
		$pic_array=explode('/',$menu['index_name']['FUNC_CODE'][$menu_list]);
		$pic=$pic_array[0].".gif";
		if(is_array($menu_2))	{ 

			if(sizeof($menu['index'][''.$list_menu['MENU_ID'].''])==$i)		{
				$tree_plus='tree_plusl.gif';
				$tree_pic3='tree_transp.gif';
			}
			else	{
				$tree_plus='tree_plus.gif';
				$tree_pic3='tree_line.gif';
			}

			$sysfunctionid=$menu['index_name']['FUNC_ID'][$menu_list];

			$ischecked=in_array($sysfunctionid,$FUNC_ID_STR_ARRAY);
			parent_table_2($menu['index_name'][$FUNC_NAME_MENU][$menu_list],$pic,$menu_list,$tree_plus,$tree_pic2);
			part_table_begin($menu_list);
			foreach($menu_2 as $list)			{
			++$ii;
			if(sizeof($menu_2)==$ii)	{
				$tree_pic="tree_blankl.gif";
				$ii=0;
			}
			else		{
				$tree_pic="tree_blank.gif";
			}
			$ischecked=in_array($menu['index_name']['FUNC_ID'][$list],$FUNC_ID_STR_ARRAY);
			$pic_array=explode('/',$menu['index_name']['FUNC_CODE'][$list]);
			$pic=$pic_array[0].".gif";
			menu_table_3($menu['index_name'][$FUNC_NAME_MENU][$list],$menu['index_name']['FUNC_LINK'][$list],$pic,$tree_pic,$tree_pic2,$tree_pic3);
			isset($ischecked);
			}//end foreach
			part_table_end();
		}
		else	{
			if(sizeof($menu['index'][''.$list_menu['MENU_ID'].''])==$i)		{
				$tree_pic="tree_blankl.gif";
			}
			else	{
				$tree_pic="tree_blank.gif";
			}
			//print $menu['index_name']['FUNC_ID'][$menu_list];
			$ischecked=in_array($menu['index_name']['FUNC_ID'][$menu_list],$FUNC_ID_STR_ARRAY);
			//if($ischecked)		{
			menu_table_2($menu['index_name'][$FUNC_NAME_MENU][$menu_list],$menu['index_name']['FUNC_LINK'][$menu_list],$pic,$tree_pic,$tree_pic2);
			isset($ischecked);
			//}
		}
	}
	}//end if purview
	part_table_end();

}

//定义区
function menu_table_3($showtext,$url,$pic,$tree_pic="tree_blank.gif",$tree_pic2="tree_line.gif",$tree_pic3='tree_line.gif')	{
	print "<TABLE class=small cellSpacing=0 cellPadding=0 border=0>\n";
    print "<TBODY>\n";
    print "<TR>\n";
    print "<TD><IMG src=\"images/menu/$tree_pic2\"></TD>\n";
    print "<TD><IMG src=\"images/menu/$tree_pic3\" border=0></TD>\n";
    print "<TD><IMG src=\"images/menu/$tree_pic\"></TD>\n";
    print "<TD><IMG height=17 alt=$showtext src=\"images/menu/$pic\" \n";
    print "width=17 border=0></TD>\n";
    print "<TD colSpan=2><A onclick=\"openURL('$url')\" href=\"./menu.php#A\">&nbsp;$showtext</A>\n";
	print "</TD></TR></TBODY></TABLE>\n";
}
function menu_table_2($showtext,$url,$pic,$tree_pic="tree_blank.gif",$tree_pic2="tree_line.gif")	{
	print "<TABLE class=small cellSpacing=0 cellPadding=0 border=0>\n";
    print "<TBODY>\n";
    print "<TR>\n";
    print "<TD><IMG src=\"images/menu/$tree_pic2\"></TD>\n";
    print "<TD><IMG src=\"images/menu/$tree_pic\"></TD>\n";
    print "<TD><IMG height=17 alt=$showtext src=\"images/menu/$pic\" \n";
    print "width=17 border=0></TD>\n";
    print "<TD colSpan=2><A onclick=\"openURL('$url')\" href=\"./menu.php#A\">&nbsp;$showtext</A>\n";
	print "</TD></TR></TBODY></TABLE>\n";
}
function parent_table_1($showtext="我的办公桌",$pic="mytable.gif",$id="01",$image='tree_plus.gif')	{
	global $menu_mark;
	print "<TABLE class=small cellSpacing=0 cellPadding=0 border=0>\n";
    print "<TBODY>\n";
    print "<TR>\n";
    print "<TD><IMG class=outline id=".$menu_mark.$id." style=\"CURSOR: hand\" src=\"images/menu/$image\"></TD>\n";
    print "<TD><IMG height=17 alt=$showtext src=\"images/menu/$pic\" width=17 border=0></TD>\n";
    print "<TD colSpan=3><A onclick=".$menu_mark.$id.".click(); href=\"./menu.php#A\">&nbsp;$showtext</A>\n";
	print "</TD></TR></TBODY></TABLE>\n";
}
function parent_table_2($showtext="电子邮件",$pic="@mail.gif",$id="01",$tree_plus='tree_plus.gif',$tree_pic2='tree_line.gif')	{
	global $menu_mark;
	print "<TABLE class=small cellSpacing=0 cellPadding=0 border=0>\n";
    print "<TBODY>\n";
    print "<TR>\n";
    print "<TD><IMG src=\"images/menu/$tree_pic2\" border=0></TD>\n";
    print "<TD><IMG class=outline id=".$menu_mark.$id." style=\"CURSOR: hand\" src=\"images/menu/$tree_plus\"></TD>\n";
    print "<TD><IMG height=17 alt=$showtext src=\"images/menu/$pic\" width=17 border=0></TD>\n";
    print "<TD colSpan=2><A onclick=".$menu_mark.$id.".click(); href=\"./menu.php#A\">&nbsp;$showtext</A>\n";
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
		targetelement=document.all(targetid);
		if (targetelement.style.display=="none")
		{
			targetelement.style.display='';
			strbuf=srcelement.src;
			if(strbuf.indexOf("plus.gif")>-1)
				srcelement.src="./images/menu/tree_minus.gif";
			else
				srcelement.src="./images/menu/tree_minusl.gif";
		}
		else
		{
			targetelement.style.display="none";
			strbuf=srcelement.src;
			if(strbuf.indexOf("minus.gif")>-1)
				srcelement.src="./images/menu/tree_plus.gif";
			else
				srcelement.src="./images/menu/tree_plusl.gif";
		}
	}
}

document.onclick = clickHandler;

function openURL(URL)
{
    parent.parent.table_index.table_main.location=URL;
}

</SCRIPT>
</TR></TBODY></TABLE></BODY></HTML>
