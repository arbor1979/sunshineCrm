<?php
require_once('lib.inc.php');
$GLOBA_SESSION=returnsession();
require_once('../EDU/systemprivateinc.php');

$SYSTEM_EDU_CRM_WUYE = $_SESSION['SYSTEM_EDU_CRM_WUYE'];
if($SYSTEM_EDU_CRM_WUYE=="EDU")				{
	$systemprivateTableName = "systemprivate";
	$DefaultDirName = "EDU";
}
elseif($SYSTEM_EDU_CRM_WUYE=="TDLIB")			{
	$systemprivateTableName = "systemprivatetdlib";
	$DefaultDirName = "CRM";
}





$USER_PRIV	=	$_SESSION['LOGIN_USER_PRIV'];
$USER_ID	=	$_SESSION['SUNSHINE_USER_ID'];
$sql		=	"select * from $systemprivateTableName where ID='".$USER_PRIV."'";
$rs			=	$db->CacheExecute(150,$sql);
$NAME		=	$rs->fields['NAME'];
$CONTENT	=	$rs->fields['CONTENT'];
$CONTENTArray = explode(',',$CONTENT);

for($i=0;$i<sizeof($CONTENTArray);$i++)						{
	if(strlen($i)==1)		$iText = "0".$i; else	$iText = $i;
	$ElementArray = explode('-',$CONTENTArray[$i]);
	$һ������ = $ElementArray[0];
	$�������� = $ElementArray[1];
	$�������� = $ElementArray[2];
	//����SYS_MENU //[MENU_ID] => 01 [MENU_NAME] => �ҵİ칫�� [IMAGE] => mytable
	//
	//$һ���˵�KEYVALUE[$һ������]			= $iText;
	if($һ������!="")	$һ���˵�����[$һ������]						= $һ������;
	if($��������!="")	$�����˵�����[$һ������][$��������]				= $��������."sssss";
	if($��������!="")	$�����˵�����[$һ������][$��������][$��������]	= $��������."sssss";
}

$һ���˵����鹹��SYS_MENU		= array();
$�����˵����鹹��SYS_FUNCTION	= array();


$һ���˵�����Array = array_keys($һ���˵�����);
for($i=0;$i<sizeof($һ���˵�����Array);$i++)											{
	if(strlen($i)==1)		$iText1 = "0".$i; else	$iText1 = $i;//print $iText1."<BR>";
	$һ���˵�				= $һ���˵�����Array[$i];
	if($һ���˵�!="")	$һ���˵����鹹��SYS_MENU[$һ���˵�]	= array("MENU_ID"=>$iText1,"MENU_NAME"=>$һ���˵�,"IMAGE"=>"@EDU");
	$�����˵�����Array = array_keys($�����˵�����[$һ���˵�]);
	//print_R($�����˵�����Array);print "<HR>";
	for($ix=0;$ix<sizeof($�����˵�����Array);$ix++)								{
		if(strlen($ix)==1)		$iText2 = $iText1."0".$ix; else	$iText2 = $iText1.$ix;
		$�����˵� = $�����˵�����Array[$ix];
		$�����˵�����Array = @array_keys($�����˵�����[$һ���˵�][$�����˵�]);
		if(sizeof($�����˵�����Array)==0)										{
			$FUNC_CODE = $PRIVATE_SYSTEM[$һ���˵�][$�����˵�][0];
			$FUNC_NAME = $PRIVATE_SYSTEM[$һ���˵�][$�����˵�][1];
			if($FUNC_NAME!='')	$�����˵����鹹��SYS_FUNCTION[]	= array("FUNC_ID"=>$i.$ix,"MENU_ID"=>$iText2,"FUNC_NAME"=>$FUNC_NAME,"FUNC_CODE"=>$FUNC_CODE,"IMAGE"=>"@EDU");
		}
		else									{
			$FUNC_NAME = $PRIVATE_SYSTEM[$һ���˵�][$�����˵�]['PARENT'][1];
			$�����˵����鹹��SYS_FUNCTION[]	= array("FUNC_ID"=>$i.$ix,"MENU_ID"=>$iText2,"FUNC_NAME"=>$FUNC_NAME,"FUNC_CODE"=>$FUNC_CODE,"IMAGE"=>"@EDU");
			for($ixx=0;$ixx<sizeof($�����˵�����Array);$ixx++)						{
				if(strlen($ixx)==1)		$iText3 = $iText2."0".$ixx; else	$iText3 = $iText2.$ixx;
				$�����˵� = $�����˵�����Array[$ixx];
				$FUNC_CODE = $PRIVATE_SYSTEM[$һ���˵�][$�����˵�][$�����˵�][0];
				$FUNC_NAME = $PRIVATE_SYSTEM[$һ���˵�][$�����˵�][$�����˵�][1];
				if($FUNC_NAME!='')	$�����˵����鹹��SYS_FUNCTION[]	= array("FUNC_ID"=>$i.$ix.$ixx,"MENU_ID"=>$iText3,"FUNC_NAME"=>$FUNC_NAME,"FUNC_CODE"=>$FUNC_CODE,"IMAGE"=>"@EDU");
			}
		}
	}
}

//print_R($�����˵����鹹��SYS_FUNCTION);//exit;

$LOGIN_THEME = $_SESSION['LOGIN_THEME'];

//print_R($_GET);

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML><HEAD><TITLE></TITLE>
<META http-equiv=Content-Type content="text/html; charset=gb2312">
<LINK href="<?php echo ROOT_DIR?>theme/<?php echo $LOGIN_THEME?>/style.css" rel=stylesheet>
<STYLE type=text/css>
A:link {
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

<BODY class=panel><!-- OA����ʼ-->
<?php
$ExecTimeBegin=getmicrotime();
global $db;
$rs_array	=	$�����˵����鹹��SYS_FUNCTION;//print_R($rs_array);exit;
$menu_mark	='MENU_';
$FUNC_NAME_MENU='FUNC_NAME';
foreach($rs_array as $list)			{
	$FUNC_ID = $list['FUNC_ID'];
	$list['FUNC_LINK'] = $list['FUNC_CODE'];
	$MEMO = $list['MEMO'];
	if(1)					{
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
			$menu['index_name']['MEMO'][''.$list['MENU_ID'].'']=$list['MEMO'];
			$menu['index_name']['IMAGE'][''.$list['MENU_ID'].'']=$list['IMAGE'];
			break;
		case 6:
			$menu['index'][substr($list['MENU_ID'],0,4)][substr($list['MENU_ID'],4,2)]=$list['MENU_ID'];
			$menu['index_name'][$FUNC_NAME_MENU][''.$list['MENU_ID'].'']=$list[$FUNC_NAME_MENU];
			$menu['index_name']['FUNC_CODE'][''.$list['MENU_ID'].'']=$list['FUNC_CODE'];
			$menu['index_name']['FUNC_LINK'][''.$list['MENU_ID'].'']=$list['FUNC_LINK'];
			$menu['index_name']['FUNC_ID'][''.$list['MENU_ID'].'']=$list['FUNC_ID'];
			$menu['index_name']['MEMO'][''.$list['MENU_ID'].'']=$list['MEMO'];
			$menu['index_name']['IMAGE'][''.$list['MENU_ID'].'']=$list['IMAGE'];
			break;
	}//end switch
	}
	else	{
	}
}
//print_R($menu);exit;
//asort($menu['index']);print_R($menu['index']);exit;
//print_R($menu['index']['09']);
//print_R($menu_affixation);һ���˵����鹹��SYS_MENU
$rs_array_menu	=	array_values($һ���˵����鹹��SYS_MENU);;
$i_menu=0;
//print_R($rs_array_menu);



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
	//����ʱͼƬѡ��
	if($_GET['MENU_ID']!=""&&$_GET['MENU_ID']!="00")		{
		$image='tree_minusl.gif';
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
		$pic=$menu['index_name']['IMAGE'][$menu_list].".gif";
		if(is_array($menu_2))	{

			if(sizeof($menu['index'][''.$list_menu['MENU_ID'].''])==$i )		{
				$tree_plus='tree_plusl.gif';
				$tree_pic3='tree_transp.gif';
			}
			else	{
				$tree_plus='tree_plus.gif';
				$tree_pic3='tree_line.gif';
			}

			$sysfunctionid=$menu['index_name']['FUNC_ID'][$menu_list];

			parent_table_2($menu['index_name'][$FUNC_NAME_MENU][$menu_list],$menu['index_name']['MEMO'][$menu_list],$pic,$menu_list,$tree_plus,$tree_pic2);
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
			$pic_array	=	explode('/',$menu['index_name']['FUNC_CODE'][$list]);
			$pic		=	$menu['index_name']['IMAGE'][$list].".gif";
			menu_table_3($menu['index_name'][$FUNC_NAME_MENU][$list],$menu['index_name']['FUNC_LINK'][$list],$menu['index_name']['MEMO'][$list],$pic,$tree_pic,$tree_pic2,$tree_pic3);

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
			menu_table_2($menu['index_name'][$FUNC_NAME_MENU][$menu_list],$menu['index_name']['FUNC_LINK'][$menu_list],$menu['index_name']['MEMO'][$menu_list],$pic,$tree_pic,$tree_pic2);
		}
	}
	}//end if purview
	part_table_end();

}




function menu_table_3($showtext,$url,$MEMO,$pic,$tree_pic="tree_blank.gif",$tree_pic2="tree_line.gif",$tree_pic3='tree_line.gif')	{
	//if(!is_file("/images/menu/$pic"))		$pic = "2042.gif";
	$MEMO==""?$MEMO = $showtext : '';
	print "<TABLE class=small cellSpacing=0 cellPadding=0 border=0>\n";
    print "<TBODY>\n";
    print "<TR>\n";
    print "<TD><IMG src=\"/images/menu/$tree_pic2\"></TD>\n";
    print "<TD><IMG src=\"/images/menu/$tree_pic3\" border=0></TD>\n";
    print "<TD><IMG src=\"/images/menu/$tree_pic\"></TD>\n";
    print "<TD nowrap><A title = '$MEMO' href=\"javascript:openURL('$url')\"><IMG height=17 alt=$showtext src=\"/images/menu/$pic\" \n";
    print "width=17 border=0></a></TD>\n";
    print "<TD nowrap colSpan=2 title = '$MEMO'>&nbsp;<A title = '$MEMO'  href=\"javascript:openURL('$url')\">$showtext</A>\n";
	print "</TD></TR></TBODY></TABLE>\n";
}
function menu_table_2($showtext,$url,$MEMO,$pic,$tree_pic="tree_blank.gif",$tree_pic2="tree_line.gif")	{
	$MEMO==""?$MEMO = $showtext : '';
	//if(!is_file("/images/menu/$pic"))		$pic = "2042.gif";
	print "<TABLE class=small cellSpacing=0 cellPadding=0 border=0>\n";
    print "<TBODY>\n";
    print "<TR>\n";
    print "<TD><IMG src=\"/images/menu/$tree_pic2\"></TD>\n";
    print "<TD><IMG src=\"/images/menu/$tree_pic\"></TD>\n";
    print "<TD nowrap><A title = '$MEMO'  href=\"javascript:openURL('$url')\"><IMG height=17 alt=$showtext src=\"/images/menu/$pic\" \n";
    print "width=17 border=0></a></TD>\n";
    print "<TD nowrap colSpan=2 title = '$MEMO'>&nbsp;<A title = '$MEMO' href=\"javascript:openURL('$url')\">$showtext</A>\n";
	print "</TD></TR></TBODY></TABLE>\n";
}
function parent_table_1($showtext="�ҵİ칫��",$pic="mytable.gif",$id="01",$image='tree_plus.gif')	{
	global $menu_mark;
	//if(!is_file("/images/menu/$pic"))		$pic = "2041.gif";
	print "<TABLE class=small cellSpacing=0 cellPadding=0 border=0>\n";
    print "<TBODY>\n";
    print "<TR>\n";
    print "<TD nowrap><A href=\"javascript:myclick(".$menu_mark.$id.")\"><IMG class=outline id=".$menu_mark.$id." style=\"CURSOR: hand\" src=\"/images/menu/$image\" border=0></a></TD>\n";
    print "<TD nowrap><A href=\"javascript:myclick(".$menu_mark.$id.")\"><IMG height=17 alt=$showtext src=\"/images/menu/$pic\" width=17 border=0></a></TD>\n";
    print "<TD colSpan=3 nowrap>&nbsp;<A href=\"javascript:myclick(".$menu_mark.$id.")\">$showtext</A>\n";
	print "</TD></TR></TBODY></TABLE>\n";
}
function parent_table_2($showtext="�����ʼ�",$MEMO,$pic="@mail.gif",$id="01",$tree_plus='tree_plus.gif',$tree_pic2='tree_line.gif')	{
	global $menu_mark;
	global $_GET;
	$MEMO==""?$MEMO = $showtext : '';
	//����ʱͼƬѡ��
	if($_GET['MENU_ID']!=""&&$_GET['MENU_ID']!="00")		{
		$tree_plus='tree_minusl.gif';
	}
	print "<TABLE class=small cellSpacing=0 cellPadding=0 border=0>\n";
    print "<TBODY>\n";
    print "<TR>\n";
    print "<TD><IMG src=\"/images/menu/$tree_pic2\" border=0></TD>\n";
    print "<TD><A title = '$MEMO'  href=\"javascript:myclick(".$menu_mark.$id.")\"><IMG class=outline id=".$menu_mark.$id." style=\"CURSOR: hand\" src=\"/images/menu/$tree_plus\" border=0></a></TD>\n";
    print "<TD><A title = '$MEMO'  href=\"javascript:myclick(".$menu_mark.$id.")\"><IMG height=17 alt=$showtext src=\"/images/menu/$pic\" width=17 border=0></a></TD>\n";
    print "<TD colSpan=2 title = '$MEMO'>&nbsp;<A title = '$MEMO'  href=\"javascript:myclick(".$menu_mark.$id.")\">$showtext</A>\n";
	print "</TD></TR></TBODY></TABLE>\n";
}
function part_table_begin($id="0104")	{
	global $menu_mark;
	global $_GET;
	if($_GET['MENU_ID']!=""&&$_GET['MENU_ID']!="00")	{
		$hand = "hand";
	}
	else	{
		$hand = "none";
	}
	print "<TABLE class=small id=".$menu_mark.$id."d style=\"DISPLAY: ".$hand."\" cellSpacing=0 cellPadding=0 border=0>\n";
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

//-------- �˵�����¼� -------
function myclick(srcelement)
{
  var targetid,srcelement,targetelement;
  var strbuf;

  //-------- ��������չ����������ť---------
  if(srcelement.className=="outline")
  {
     //if(srcelement.title!="" && srcelement.src.indexOf("plus")>-1)
       // menu_shrink();

     targetid=srcelement.id+"d";
     targetelement=document.all(targetid);

     if (targetelement.style.display=="none")
     {
        targetelement.style.display='';
        strbuf=srcelement.src;
        if(strbuf.indexOf("plus.gif")>-1)
                srcelement.src=".ROOT_DIR."images/menu/tree_minus.gif";
        else
                srcelement.src=".ROOT_DIR."images/menu/tree_minusl.gif";
     }
     else
     {
        targetelement.style.display="none";
        strbuf=srcelement.src;
        if(strbuf.indexOf("minus.gif")>-1)
                srcelement.src=".ROOT_DIR."images/menu/tree_plus.gif";
        else
                srcelement.src=".ROOT_DIR."images/menu/tree_plusl.gif";
     }
  }
}
<?php
if(is_dir(ROOT_DIR."/module/word_model"))		{
	print "function openURL(URL){parent.parent.table_index.table_main.location=URL;}";
}
else	{
	print "function openURL(URL){parent.parent.table_index.table_main.location=\"../$DefaultDirName/\"+URL;}";
}

?>


</SCRIPT>
</TR></TBODY></TABLE></BODY></HTML><?php
/*
	��Ȩ����:֣�ݵ���Ƽ�������޹�˾;
	��ϵ��ʽ:0371-69663266;
	��˾��ַ:����֣�ݾ��ü��������������־�����·ͨ�Ų�ҵ԰��¥����;
	��˾���:֣�ݵ���Ƽ�������޹�˾λ���й��в�����-֣��,������2007��1��,�����ڰѻ����Ƚ���Ϣ����������ͨ�ż���������ѹ�����ҵ��ʵ���ռ���������ҵ�ͻ��Ĺ�����ҵ���»�У�ȫ���ṩ��������֪ʶ��Ȩ�Ľ�����������������������������в�������ĸ�У���������������СѧУ��������ṩ�̡�Ŀǰ�����ж�Ҹ�ְ����ְ��ԺУʹ��ͨ���в��з����Ŀ���������ͷ���;

	�������:����Ƽ�������������Լܹ�ƽ̨,�Լ��������֮����չ���κ��������Ʒ;
	����Э��:���ֻ�У԰��ƷΪ��ҵ���,�������ΪLICENSE��ʽ;����CRMϵͳ��SunshineCRMϵͳΪGPLV3Э�����,GPLV3Э����������뵽�ٶ�����;
	��������:�����ʹ�õ�ADODB��,PHPEXCEL��,SMTARY���ԭ��������,���´���������������;
	*/
?>