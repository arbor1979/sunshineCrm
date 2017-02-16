<?php
require_once("lib.inc.php");
require_once("class.dir.php");

$dirlist = "../Interface/";
print "<link rel='stylesheet' type='text/css' href='".ROOT_DIR."theme/9/style.css'>";
?>

<BODY class=bodycolor topMargin=5 >
<?php




//###################################################################################
//菜单组件列表--开始#################################################################
//###################################################################################
$rs_array_menu[0]['MENU_ID'] = "01";
$rs_array_menu[0]['IMAGE'] = "sysstock";
$rs_array_menu[0]['MENU_NAME'] = "组件向导";

$rs_array_menu[1]['MENU_ID'] = "02";
$rs_array_menu[1]['IMAGE'] = "sysstock";
$rs_array_menu[1]['MENU_NAME'] = "业务组件";

$rs_array_menu[2]['MENU_ID'] = "03";
$rs_array_menu[2]['IMAGE'] = "sysstock";
$rs_array_menu[2]['MENU_NAME'] = "系统管理";

$rs_array_menu[3]['MENU_ID'] = "04";
$rs_array_menu[3]['IMAGE'] = "sysstock";
$rs_array_menu[3]['MENU_NAME'] = "系统帮助";


//组件向导部分菜单
$rs_array[201] =  array('FUNC_ID' => '0101','FUNC_NAME' => '构建对象向导',
						'MENU_ID' => '0101','FUNC_CODE' => "sysstock",
						'FUNC_LINK' => "table.php"
						);
$rs_array[202] =  array('FUNC_ID' => '0102','FUNC_NAME' => '对象初始化',
						'MENU_ID' => '0102','FUNC_CODE' => "sysstock",
						'FUNC_LINK' => "php_ide.php"
						);
$rs_array[203] =  array('FUNC_ID' => '0103','FUNC_NAME' => '组件向导',
						'MENU_ID' => '0103','FUNC_CODE' => "sysstock",
						'FUNC_LINK' => "main.php"
						);
$rs_array[204] =  array('FUNC_ID' => '0104','FUNC_NAME' => '组件向导',
						'MENU_ID' => '0104','FUNC_CODE' => "sysstock",
						'FUNC_LINK' => "main.php"
						);
$rs_array[205] =  array('FUNC_ID' => '0105','FUNC_NAME' => '组件向导',
						'MENU_ID' => '0105','FUNC_CODE' => "sysstock",
						'FUNC_LINK' => "main.php"
						);
//系统管理部分菜单
$rs_array[301] =  array('FUNC_ID' => '0301','FUNC_NAME' => '组件向导',
						'MENU_ID' => '0301','FUNC_CODE' => "sysstock",
						'FUNC_LINK' => "main.php"
						);
$rs_array[302] =  array('FUNC_ID' => '0302','FUNC_NAME' => '组件向导',
						'MENU_ID' => '0302','FUNC_CODE' => "sysstock",
						'FUNC_LINK' => "main.php"
						);
$rs_array[303] =  array('FUNC_ID' => '0303','FUNC_NAME' => '组件向导',
						'MENU_ID' => '0303','FUNC_CODE' => "sysstock",
						'FUNC_LINK' => "main.php"
						);
$rs_array[304] =  array('FUNC_ID' => '0304','FUNC_NAME' => '组件向导',
						'MENU_ID' => '0304','FUNC_CODE' => "sysstock",
						'FUNC_LINK' => "main.php"
						);
$rs_array[305] =  array('FUNC_ID' => '0305','FUNC_NAME' => '组件向导',
						'MENU_ID' => '0305','FUNC_CODE' => "sysstock",
						'FUNC_LINK' => "main.php"
						);
//系统帮助部分菜单
$rs_array[401] =  array('FUNC_ID' => '0401','FUNC_NAME' => '向导使用帮助',
						'MENU_ID' => '0401','FUNC_CODE' => "sysstock",
						'FUNC_LINK' => "main.php"
						);
$rs_array[402] =  array('FUNC_ID' => '0402','FUNC_NAME' => '业务组件帮助',
						'MENU_ID' => '0402','FUNC_CODE' => "sysstock",
						'FUNC_LINK' => "main.php"
						);
$rs_array[403] =  array('FUNC_ID' => '0403','FUNC_NAME' => '系统菜单帮助',
						'MENU_ID' => '0403','FUNC_CODE' => "sysstock",
						'FUNC_LINK' => "main.php"
						);
$rs_array[404] =  array('FUNC_ID' => '0404','FUNC_NAME' => '用户权限说明',
						'MENU_ID' => '0404','FUNC_CODE' => "sysstock",
						'FUNC_LINK' => "main.php"
						);
$rs_array[405] =  array('FUNC_ID' => '0405','FUNC_NAME' => '常见问题说明',
						'MENU_ID' => '0405','FUNC_CODE' => "sysstock",
						'FUNC_LINK' => "main.php"
						);

//###################################################################################
//业务组件部分--开始#################################################################
//###################################################################################
//构建表对象
//根据INI文件进行判断对象是否存在。
$d=new PHP_Dir();
global $SYSTEM_MODE_DIR;
$dirlist .= $SYSTEM_MODE_DIR."/Model/";
$file=$d->list_files($dirlist);
$dir=$d->list_dirs($dirlist);
$j=1;
//第一行固定对INI文件进行表对象操作,方法固定。
//数据形成区
$Parent_MENUID = "02";
$All = sizeof($file['filename']);
$MENU_ARRAY = array();
for($i=0;$i<sizeof($file['filename']);$i++)			{
	$fileName = $file['filename'][$i];
	$fileNameArray = explode('_',$fileName);
	array_pop($fileNameArray);
	$fileName = join('_',$fileNameArray);
	//菜单ID形成
	strlen($i)==1?$MENU_ID=$Parent_MENUID."0".$i:$MENU_ID=$Parent_MENUID.$i;
	//检测第三级菜单形成--对象名形成部分
	$fileNameArray2 = $fileNameArray;
	$ObjectIndex = sizeof($fileNameArray2)-1;
	$ObjectLastName = $fileNameArray2[$ObjectIndex];
	if(($ObjectLastName=="input"||$ObjectLastName=="edit"||$ObjectLastName=="read")&&sizeof($fileNameArray2)>=2)		{
		array_pop($fileNameArray2);
		$ObjectName = join('_',$fileNameArray2);
	}
	else	{
		$ObjectName = join('_',$fileNameArray);
	}
	$ObjectName."<BR>";
	$TempMenuID[$ObjectName] == "" ? $TempMenuID[$ObjectName] = $MENU_ID : $MENU_ID = $TempMenuID[$ObjectName];
	//检测第三级菜单形成--判断对象是否存在部分
	$fileFullName = $dirlist.$fileName."_newai.ini";
	$fileFullName_input = $ObjectName."_input";
	$fileFullName_edit = $ObjectName."_edit";
	$fileFullName_read = $ObjectName."_read";

	$SYSTEM_FILE = parse_ini_file($fileFullName,true);
	$TRUE_TABLENAME = $SYSTEM_FILE['init_default']['tablename'];
	//print_R($SYSTEM_FILE);

	if($fileName==$fileFullName_input||$fileName==$fileFullName_edit||$fileName==$fileFullName_read)	{
		strlen($i)==1?$TEMP_ID="0".$i:$TEMP_ID=$i;
		$MENU_ID = $TempMenuID[$ObjectName].$TEMP_ID;
		if(!in_array($TempMenuID[$ObjectName],$MENU_ARRAY))	{
			$All ++ ;
			$rs_array[$All]['FUNC_ID'] = $TempMenuID[$ObjectName]."99";
			$rs_array[$All]['FUNC_NAME'] = returnFUNC_NAME($ObjectName,$ObjectName);
			$rs_array[$All]['MENU_ID'] = $TempMenuID[$ObjectName]."99";
			$rs_array[$All]['FUNC_CODE'] = "sysstock";
			$rs_array[$All]['FUNC_LINK'] = "main.php?Tablename=$TRUE_TABLENAME&FileIniname=$ObjectName";
		}
	}
	else		{
		array_push($MENU_ARRAY,$MENU_ID);
	}
		$rs_array[$i]['FUNC_ID'] = $MENU_ID;
		$rs_array[$i]['FUNC_NAME'] = returnFUNC_NAME($fileName,$ObjectName);
		$rs_array[$i]['MENU_ID'] = $MENU_ID;
		$rs_array[$i]['FUNC_CODE'] = "sysstock";
		$rs_array[$i]['FUNC_LINK'] = "main.php?Tablename=$TRUE_TABLENAME&FileIniname=$fileName";
}

//###################################################################################
//业务组件部分--结束#################################################################
//###################################################################################

function returnFUNC_NAME($fieldname,$tablename)			{
	global $db;
	$sql = "select * from systemlang where tablename = '$tablename' and fieldname = '$fieldname'";
	$rs = $db->Execute($sql);
	if($rs->fields['chinese']!="")		{
		$return = $rs->fields['chinese'];
	}
	else		{
		$sql = "select * from systemlang where tablename = 'common_html' and fieldname = '$fieldname'";
		$rs = $db->Execute($sql);
		if($rs->fields['chinese']!="")		{
			$return = $rs->fields['chinese'];
		}
		else
			$return = $fieldname;
	}
	return $return;
}






//###################################################################################
//菜单常量部分--开始#################################################################
//###################################################################################

$ExecTimeBegin=getmicrotime();
global $db;
//$sql="select * from sys_function order by MENU_ID";
//$rs=$db->CacheExecute(1,$sql);
//$rs_array=$rs->GetArray();//print_R($rs_array);exit;
$menu_mark='MENU_';
$FUNC_NAME_MENU='FUNC_NAME';
foreach($rs_array as $list)			{
	$FUNC_ID=$list['FUNC_ID'];//print_R($FUNC_ID);exit;
	//$ischecked=in_array($FUNC_ID,$FUNC_ID_STR_ARRAY);
	$ischecked = 1;
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

//父目录形成过程
//$sql="select * from sys_menu order by MENU_ID";
//$rs_menu=$db->Execute($sql);
//$rs_array_menu=$rs_menu->GetArray();
$i_menu=0;
$MENU_NAME_MENU='MENU_NAME';
//变量组建完成。
//菜单形成过程。
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

			//$ischecked=in_array($sysfunctionid,$FUNC_ID_STR_ARRAY);
			$ischecked = 1;
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
			//$ischecked=in_array($menu['index_name']['FUNC_ID'][$list],$FUNC_ID_STR_ARRAY);
			$ischecked = 1;
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
			//$ischecked=in_array($menu['index_name']['FUNC_ID'][$menu_list],$FUNC_ID_STR_ARRAY);
			$ischecked = 1;
			//if($ischecked)		{
			menu_table_2($menu['index_name'][$FUNC_NAME_MENU][$menu_list],$menu['index_name']['FUNC_LINK'][$menu_list],$pic,$tree_pic,$tree_pic2);
			isset($ischecked);
			//}
		}
	}
	}//end if purview
	part_table_end();

}




function menu_table_3($showtext,$url,$pic,$tree_pic="tree_blank.gif",$tree_pic2="tree_line.gif",$tree_pic3='tree_line.gif')	{
	print "<TABLE class=small cellSpacing=0 cellPadding=0 border=0>\n";
    print "<TBODY>\n";
    print "<TR>\n";
    print "<TD><IMG src=\"images/menu/$tree_pic2\"></TD>\n";
    print "<TD><IMG src=\"images/menu/$tree_pic3\" border=0></TD>\n";
    print "<TD><IMG src=\"images/menu/$tree_pic\"></TD>\n";
    print "<TD><IMG height=17 alt=$showtext src=\"images/menu/$pic\" \n";
    print "width=17 border=0></TD>\n";
    print "<TD colSpan=2><A onclick=\"openURL('$url')\" href=\"./left.php#A\">&nbsp;$showtext</A>\n";
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
    print "<TD colSpan=2><A onclick=\"openURL('$url')\" href=\"./left.php#A\">&nbsp;$showtext</A>\n";
	print "</TD></TR></TBODY></TABLE>\n";
}
function parent_table_1($showtext="我的办公桌",$pic="mytable.gif",$id="01",$image='tree_plus.gif')	{
	global $menu_mark;
	print "<TABLE class=small cellSpacing=0 cellPadding=0 border=0>\n";
    print "<TBODY>\n";
    print "<TR>\n";
    print "<TD><IMG class=outline id=".$menu_mark.$id." style=\"CURSOR: hand\" src=\"images/menu/$image\"></TD>\n";
    print "<TD><IMG height=17 alt=$showtext src=\"images/menu/$pic\" width=17 border=0></TD>\n";
    print "<TD colSpan=3><A onclick=".$menu_mark.$id.".click(); href=\"./left.php#A\">&nbsp;$showtext</A>\n";
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
    print "<TD colSpan=2><A onclick=".$menu_mark.$id.".click(); href=\"./left.php#A\">&nbsp;$showtext</A>\n";
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
    parent.main.location=URL;
}

</SCRIPT>
</TR></TBODY></TABLE></BODY></HTML>

<?php
//###################################################################################
//菜单常量部分--开始#################################################################
//###################################################################################
?>