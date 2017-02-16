<?php
//require_once('../../../../inc/conn.php');
//require_once("../../../../inc/utility.php");
//更新菜单缓存
//cache_menu();

//######################教育组件-权限较验部分##########################
SESSION_START();
require_once("lib.inc.php");
$GLOBAL_SESSION=returnsession();
require_once("systemprivateinc.php");
CheckSystemPrivate("系统信息设置-系统权限");
//######################教育组件-权限较验部分##########################


require_once('lib.inc.php');

$GLOBAL_SESSION=returnsession();

//$_SESSION['SYSTEM_IS_TD_OA'] = 0;

if($_SESSION['SYSTEM_EDU_CRM_WUYE']=="TDLIB")		{
	$systemprivateDirName = "systemprivatetdlib";
}
elseif($_SESSION['SYSTEM_EDU_CRM_WUYE']=="EDU")		{
	$systemprivateDirName = "systemprivate";
}
elseif($_SESSION['SYSTEM_EDU_CRM_WUYE']=="WUYE")		{
	$systemprivateDirName = "systemprivatewuye";
}

$MetaDatabases = $db->MetaDatabases();
if(@in_array("TD_OA",$MetaDatabases))		{
	$SYSTEM_PRE_TABLE = "TD_OA.";//
}
else	{
	$SYSTEM_PRE_TABLE = "";
}





if($_GET['action']=="")						{


	//判断数据表的第一个字段是否是主键
	$MetaColumns	= $db->MetaColumns('user');
	$array_shift	= @array_shift($MetaColumns);
	if($array_shift->primary_key!=1)			{
		$sql = "ALTER TABLE `user` ADD PRIMARY KEY ( `UID` ) ";										$db->Execute($sql);
		$sql = "ALTER TABLE `user` CHANGE `UID` `UID` INT( 11 ) NOT NULL AUTO_INCREMENT ";			$db->Execute($sql);
	}

	//判断数据表的第一个字段是否是主键
	//$MetaColumns	= $db->MetaColumns($SYSTEM_PRE_TABLE."user_priv");
	//$array_shift	= @array_shift($MetaColumns);
	//if($array_shift->primary_key!=1)			{
	//	$sql = "ALTER TABLE `user_priv` ADD PRIMARY KEY ( `USER_PRIV` ) ";										$db->Execute($sql);
	//	$sql = "ALTER TABLE `user_priv` CHANGE `USER_PRIV` `USER_PRIV` INT( 11 ) NOT NULL AUTO_INCREMENT ";		$db->Execute($sql);
	//}

	//判断数据表的第一个字段是否是主键
	$MetaColumns	= $db->MetaColumns('department');
	$array_shift	= @array_shift($MetaColumns);
	if($array_shift->primary_key!=1)			{
		$sql = "ALTER TABLE `department` ADD PRIMARY KEY ( `DEPT_ID` ) ";										$db->Execute($sql);
		$sql = "ALTER TABLE `department` CHANGE `DEPT_ID` `DEPT_ID` INT( 11 ) NOT NULL AUTO_INCREMENT ";		$db->Execute($sql);
	}

	page_css("系统角色权限信息管理");
	$sql = "select USER_PRIV,PRIV_NAME,PRIV_NO,FUNC_ID_STR from ".$SYSTEM_PRE_TABLE."user_priv order by PRIV_NO";
	$rs = $db->Execute($sql);
	$rs_a = $rs->GetArray();

	table_begin("80%");
	print_title("系统角色权限信息管理");
	print "<tr class=TableContent ><td><B>角色排序号</B></td><td><B>角色名称</B></td><td><B>操作</B></td></tr>";
	for($i=0;$i<sizeof($rs_a);$i++)		{
		$USER_PRIV	= $rs_a[$i]['USER_PRIV'];
		$PRIV_NAME	= $rs_a[$i]['PRIV_NAME'];
		$PRIV_NO	= $rs_a[$i]['PRIV_NO'];
		$FUNC_ID_STR = $rs_a[$i]['FUNC_ID_STR'];
		//进行判断,如果是集美则不则权限进行初始化
		DoItPriv($PRIV_NAME,$USER_PRIV);
		$操作 = "<a href=\"?".base64_encode("FFFF=XXXX&action=SettingPriv&USER_PRIV=$USER_PRIV&PRIV_NAME=$PRIV_NAME&FFFF=XXXX")."\">设置详细权限</a>&nbsp;&nbsp;";
		if($_SESSION['SYSTEM_IS_TD_OA']==0)					{
			$操作 .= "<a href=\"?".base64_encode("FFFF=XXXX&action=EditPrivName&USER_PRIV=$USER_PRIV&PRIV_NAME=$PRIV_NAME&PRIV_NO=$PRIV_NO&FFFF=XXXX")."\">修改名称</a>&nbsp;&nbsp;";
			$操作 .= "<a href=\"javascript:if(confirm('你真的想要删除此项记录吗？'))location='?".base64_encode("FFFF=XXXX&action=DeletePrivName&USER_PRIV=$USER_PRIV&PRIV_NAME=$PRIV_NAME&FFFF=XXXX")."'\">删除</a>&nbsp;&nbsp;";
		}
		print "<tr class=TableData><td>$PRIV_NO</td><td>$PRIV_NAME</td><td>$操作</td></tr>";
	}
	table_end();
	print "<BR>";
	//print_R($_SESSION);



	if($_SESSION['SYSTEM_IS_TD_OA']==1)					{
		table_begin("80%");
		print_title("使用前必读:");
		print "<tr class=TableContent ><td colspan=3>
		&nbsp;&nbsp;1 左边菜单区域的菜单权限在通达OA->系统管理->组织机构设置->角色与权限设置菜单中进行设置。<BR>
		&nbsp;&nbsp;2 通达数字化校园权限的值设置完成之后,不必重新登录系统,可以立即生效。</td></tr>";
		table_end();
	}
	else					{
		print "
			<script language = \"JavaScript\">
			function FormCheck()
			{
				if (document.form1.角色名称.value == \"\") {
					alert(\"角色名称不能为空\");
					return false;
				}
			}
			</script>
			";
		print "<FORM name=form1 onsubmit=\"return FormCheck();\" action=\"?action=add_default_data&pageid=1\" method=post encType=multipart/form-data>";
		table_begin("80%");
		print_title("新建角色权限信息:");
		print "<tr class=TableContent ><td colspan=3>
		&nbsp;&nbsp;角色名称:<INPUT type=\"text\" class=\"SmallInput\"  maxLength=200 size=\"15\" name='角色名称' value=\"\"  >
		&nbsp;&nbsp;排序号:<INPUT type=\"text\" class=\"SmallInput\"  maxLength=200 size=\"6\" name='排序号' value=\"10\"  >
		&nbsp;&nbsp;<input type=submit name=\"submit\" value=\"提交\" class=SmallButton>

		</td></tr>";
		table_end();

		//$sql = "ALTER TABLE `user_priv` ADD PRIMARY KEY ( `USER_PRIV` ) ;";
		//$db->Execute($sql);
		//$sql = "ALTER TABLE `user_priv` CHANGE `USER_PRIV` `USER_PRIV` INT( 11 ) NOT NULL AUTO_INCREMENT ;";
		//$db->Execute($sql);


	}



}


if($_GET['action']=="EditPrivName")						{
		page_css("角色权限修改名称");
		print "
			<script language = \"JavaScript\">
			function FormCheck()
			{
				if (document.form1.角色名称.value == \"\") {
					alert(\"角色名称不能为空\");
					return false;
				}
			}
			</script>
			";
		$USER_PRIV		= $_GET['USER_PRIV'];
		$PRIV_NAME		= $_GET['PRIV_NAME'];
		$PRIV_NO		= $_GET['PRIV_NO'];
		print "<FORM name=form1 onsubmit=\"return FormCheck();\" action=\"?action=edit_default_data&pageid=1\" method=post encType=multipart/form-data>";
		table_begin("60%");
		print_title("修改角色权限名称及排序号:");
		print "<tr class=TableContent ><td colspan=3>
		&nbsp;&nbsp;角色名称:<INPUT type=\"text\" class=\"SmallInput\"  maxLength=200 size=\"15\" name='角色名称' value=\"$PRIV_NAME\"  >
		&nbsp;&nbsp;排序号:<INPUT type=\"text\" class=\"SmallInput\"  maxLength=200 size=\"6\" name='排序号' value=\"$PRIV_NO\"  >
		&nbsp;&nbsp;<INPUT type=\"hidden\" class=\"SmallInput\"  maxLength=200 size=\"6\" name='USER_PRIV' value=\"$USER_PRIV\"  >
		&nbsp;&nbsp;<input type=submit name=\"submit\" value=\"提交\" class=SmallButton>

		</td></tr>";
		table_end();
	exit;
}

if($_GET['action']=="edit_default_data")						{
	page_css("角色权限新增管理");
	//table_begin("80%");
	//print_title("系统角色权限信息管理");
	//print_R($_POST);
	$角色名称	= $_POST['角色名称'];
	$排序号		= $_POST['排序号'];
	$USER_PRIV	= $_POST['USER_PRIV'];
	$sql		= "update ".$SYSTEM_PRE_TABLE."user_priv set PRIV_NAME='$角色名称',PRIV_NO='$排序号' where USER_PRIV='$USER_PRIV'";
	if($角色名称!="")	$db->Execute($sql);
	print_infor("角色名称修改成功,系统返回中!",'',"location='?'",'?');
	exit;
}


if($_GET['action']=="add_default_data")						{
	page_css("角色权限新增管理");
	//table_begin("80%");
	//print_title("系统角色权限信息管理");
	//print_R($_POST);
	$角色名称	= $_POST['角色名称'];
	$排序号		= $_POST['排序号'];
	$sql		= "select COUNT(*) AS NUM from ".$SYSTEM_PRE_TABLE."user_priv where PRIV_NAME='$角色名称'";
	$rs			= $db->Execute($sql);
	$rs_a		= $rs->GetArray();
	$NUM		= $rs_a[0]['NUM'];
	if($NUM==0&&$角色名称!='')					{
		$sql = "insert into ".$SYSTEM_PRE_TABLE."user_priv(USER_PRIV,PRIV_NAME,PRIV_NO,FUNC_ID_STR) value('','$角色名称','$排序号','');";
		$db->Execute($sql);
		//$USER_PRIV = $db->InsertID();
		//print $角色名称;
		print_infor("角色名称增加成功,系统返回中!",'',"location='?'",'?',1);
		exit;
	}
	else	{
		print_infor("您输入的角色名称已经存在,请换用其它名称!",'',"location='?'",'?',1);
		exit;
	}

}



if($_GET['action']=="DeletePrivName")						{
	page_css("角色权限删除");
	//table_begin("80%");
	//print_title("系统角色权限信息管理");
	//print_R($_POST);
	$USER_PRIV		= $_GET['USER_PRIV'];
	$PRIV_NAME		= $_GET['PRIV_NAME'];
	$sql		= "delete from ".$SYSTEM_PRE_TABLE."user_priv where PRIV_NAME='$PRIV_NAME' and USER_PRIV='$USER_PRIV' ";
	$db->Execute($sql);
	print_infor("角色名称删除成功,系统返回中!",'',"location='?'",'?');
	exit;
}


function DoItPriv($PRIV_NAME,$USER_PRIV)		{
	global $db,$systemprivateDirName;
	$sql = "select COUNT(*) AS NUM  from $systemprivateDirName where ID='$USER_PRIV'";
	$rs = $db->Execute($sql);
	$rs_a = $rs->GetArray();
	$NUM = TRIM($rs_a[0]['NUM']);
	if($NUM==0)			{
		//$sql = "select CONTENT from $systemprivateDirName where ID='1'";
		//$rs = $db->Execute($sql);
		//$rs_a = $rs->GetArray();
		//$CONTENT = $rs_a[0]['CONTENT'];
		$sql = "insert into $systemprivateDirName values('$USER_PRIV','$PRIV_NAME','');";
		$db->Execute($sql);
		//print $sql."<BR>";
	}
}


if($_GET['action']=="SettingPriv")						{
//table_begin("80%");
//print_title("系统角色权限信息管理");
$PRIV_NAME = $_GET['PRIV_NAME'];
$USER_PRIV = $_GET['USER_PRIV'];
$sql = "select CONTENT from $systemprivateDirName where ID='$USER_PRIV'";
$rs = $db->Execute($sql);
$rs_a = $rs->GetArray();
$CONTENT = $rs_a[0]['CONTENT'];
$CONTENT_ARRAY = explode(',',$CONTENT);
//print_R($CONTENT);
page_css("编辑角色权限");
?>


<script src="<?php echo ROOT_DIR?>inc/js/ccorrect_btn.js"></script>

<html>
<head>
<title>编辑角色权限</title>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">

<script>

var MENU_ID_ARRAY = new Array();

    MENU_ID_ARRAY[0]="01";
    MENU_ID_ARRAY[1]="09";
    MENU_ID_ARRAY[2]="05";
    MENU_ID_ARRAY[3]="13";
    MENU_ID_ARRAY[4]="20";
    MENU_ID_ARRAY[5]="30";
    MENU_ID_ARRAY[6]="10";
    MENU_ID_ARRAY[7]="03";
    MENU_ID_ARRAY[8]="90";
    MENU_ID_ARRAY[9]="07";
    MENU_ID_ARRAY[10]="b0";
    MENU_ID_ARRAY[11]="60";
    MENU_ID_ARRAY[12]="c4";

function check_all(menu_all,MENU_ID)
{
 var cb = document.getElementsByName(MENU_ID);
 if(!cb || cb.length==0)
  	 return;

 for (i=0;i<cb.length;i++)
 {
   if(menu_all.checked)
      cb[i].checked=true;
   else
      cb[i].checked=false;
 }
}

function mysubmit()
{
  func_id_str="";

  for(j=1;j<=20;j++)
  {
    var cb = document.getElementsByName(j-1);
  	 if(!cb || cb.length==0)
  	   continue;

    for(i=0;i<cb.length;i++)
    {
        if(cb[i].checked)
        {
           func_id_str+=cb[i].value + ",";
        }
    }
  }

  form1.FUNC_ID_STR.value=func_id_str;
  form1.submit();
}
var op_btn,btn_left=window.screen.availWidth-360;
function init_scroll()
{
   op_btn=document.getElementById("OP_BTN");
   if(!op_btn) return false;
   btn_left=op_btn.offsetLeft;
}
window.onscroll=function()
{
   if(!op_btn) return false;

   op_btn.style.left=btn_left+document.body.scrollLeft;
   op_btn.style.top =document.body.scrollTop +5;
};
</script>
</head>
<?php
if($_GET['action2']=="")		{
	$返回 = "systemprivateview.php";
}
else	{
	$返回 =".ROOT_DIR."general/system/user_priv/".$_GET['action2'];
}


if(is_file('../../Framework/license.ini'))			{
	$ini_file=@parse_ini_file('../../Framework/license.ini');
	$显示文本 = "(授权单位:".$ini_file['SCHOOL_NAME']." 软件版本:".$ini_file['SOFTWARE_TYPE'].")";
}
else	{
	$显示文本 = "(此软件为试用版本,如需购买请联系软件开发商!)";
}
?>
<body class="bodycolor" topmargin="5" onload="init_scroll();">
<table border="0" width="100%" cellspacing="0" cellpadding="3" class="small">
  <tr>
    <td class="Big"><img src="images/notify_new.gif" WIDTH="22" HEIGHT="20" align="absmiddle"><span class="big3"> <?php echo $_GET['PRIV_NAME']?>权限 - <?php echo $显示文本?> </span>&nbsp;&nbsp;
    <div id="OP_BTN" style="width:150px;top:5px;right:20px;position:absolute;">
     <form name="form1" method="post" action="?<?php echo base64_encode("action=SettingPrivData&USER_PRIV=$USER_PRIV&PRIV_NAME=$PRIV_NAME&action2=".$_GET['action2']."&FF=FF")?>">
      <input type="hidden" value="" name="FUNC_ID_STR">
      <input type="hidden" value="4" name="USER_PRIV">
      <input type="button" value="确定" class="BigButton" onclick="mysubmit();">&nbsp;&nbsp;
      <input type="button" value="返回" class="BigButton" onclick="location='<?php echo $返回?>'">
     </form>
    </div>
    </td>
  </tr>
</table>

<table border="0" cellspacing="2" class="small" cellpadding="3" align="center">
<tr class="TableData">
<?php
require_once("systemprivateinc.php");
$PARENT_MENU_ARRAY = array_keys($PRIVATE_SYSTEM);
//print_R($PARENT_MENU_ARRAY);

for($i=0;$i<count($PARENT_MENU_ARRAY);$i++)			{
	$PARENT_MENU_NAME = $PARENT_MENU_ARRAY[$i];
	$PARENT_MENU_CODE = $i;
echo <<<EOF
	<td valign="top">
	<table class="TableBlock" align="center">
     <tr class="TableContent" title="$PARENT_MENU_NAME">
      <td nowrap>
        <input type="checkbox" name="MENU_{$PARENT_MENU_CODE}" onClick="check_all(this,'{$PARENT_MENU_CODE}');">
        <img src=".ROOT_DIR."images/menu/@EDU.gif" width=19 height=17> <b>$PARENT_MENU_NAME</b>
      </td>
     </tr>
EOF;

//处理一级分类下面的子菜单
$GROUP_ONE_ARRAY = array_keys($PRIVATE_SYSTEM[$PARENT_MENU_NAME]);
//print_R($GROUP_ONE_ARRAY);
for($ii=0;$ii<count($GROUP_ONE_ARRAY);$ii++)			{
	$GROUP_ONE_NAME = $GROUP_ONE_ARRAY[$ii];
	$GROUP_ONE_CODE = $ii;
	$GROUP_TWO_ARRAY = array_keys($PRIVATE_SYSTEM[$PARENT_MENU_NAME][$GROUP_ONE_NAME]);
	//print_R($GROUP_TWO_ARRAY);
//确定二级菜单的存在性
if(count($GROUP_TWO_ARRAY)>2)		{
	array_shift($GROUP_TWO_ARRAY);
	$ValueTemp = $PARENT_MENU_NAME."-".$GROUP_ONE_NAME;
	if(in_array($ValueTemp,$CONTENT_ARRAY))	$CheckedText = "checked"; else	$CheckedText ="";
	//$CheckedText
echo <<<EOF
		<tr title="$GROUP_ONE_NAME">
          <td class="TableData" nowrap>
          <input type="checkbox" name="{$PARENT_MENU_CODE}" value="$ValueTemp" $CheckedText ><img src=".ROOT_DIR."images/menu/EDU.gif" width=19 height=17> $GROUP_ONE_NAME
          </td>
        </tr>
EOF;
	for($iii=0;$iii<count($GROUP_TWO_ARRAY);$iii++)			{
		$GROUP_TWO_NAME = $GROUP_TWO_ARRAY[$iii];
		$ValueTemp = $PARENT_MENU_NAME."-".$GROUP_ONE_NAME."-".$GROUP_TWO_NAME;
		if(in_array($ValueTemp,$CONTENT_ARRAY))	$CheckedText = "checked"; else	$CheckedText ="";
echo <<<EOF
		<tr title="$GROUP_ONE_NAME">
          <td class="TableData" nowrap>&nbsp;&nbsp;
          <input type="checkbox" name="{$PARENT_MENU_CODE}" value="$ValueTemp" $CheckedText>
          <img src=".ROOT_DIR."images/menu/EDU.gif" width=19 height=17> $GROUP_TWO_NAME
          </td>
        </tr>
EOF;
	}
}
else			{
	$ValueTemp = $PARENT_MENU_NAME."-".$GROUP_ONE_NAME;
	if(in_array($ValueTemp,$CONTENT_ARRAY))	$CheckedText = "checked"; else	$CheckedText ="";
echo <<<EOF
		<tr title="$GROUP_ONE_NAME">
          <td class="TableData" nowrap>
          <input type="checkbox" name="{$PARENT_MENU_CODE}" value="$ValueTemp"  $CheckedText>
          <img src=".ROOT_DIR."images/menu/EDU.gif" width=19 height=17> $GROUP_ONE_NAME
          </td>
        </tr>
EOF;
}
}//end GROUP_ONE

print "</table></td>";
}//end PARENT_MENU

?>





 </tr>
</table>
<input type="hidden" value="4" name="USER_PRIV">


<?php
//table_end();
}
/*
$STR = "1,2,3,4";
$FUNC_ID_STR_ARRAY = explode(',',$STR);
$PRIV_ID_INDEX = '1';
$FUNC_ID_STR_ARRAY1 = array_slice($FUNC_ID_STR_ARRAY,0,$PRIV_ID_INDEX);
print_R($FUNC_ID_STR_ARRAY1);
$FUNC_ID_STR_ARRAY2 = array_slice($FUNC_ID_STR_ARRAY,$PRIV_ID_INDEX+1,count($FUNC_ID_STR_ARRAY));
print_R($FUNC_ID_STR_ARRAY2);
$FUNC_ID_STR_ARRAY = array_merge($FUNC_ID_STR_ARRAY1,$FUNC_ID_STR_ARRAY2);
print_R($FUNC_ID_STR_ARRAY);
*/

if($_GET['action']=="SettingPrivData")						{

//print_R($_POST);	exit;

page_css("系统角色权限信息管理");
$USER_PRIV = $_GET['USER_PRIV'];
$PRIV_NAME = $_GET['PRIV_NAME'];
$FUNC_ID_STR = $_POST['FUNC_ID_STR'];
$sql = "select * from $systemprivateDirName where ID='$USER_PRIV'";
$rs = $db->Execute($sql);
$rs_a = $rs->GetArray();
if(count($rs_a)==0)		{
	$sql = "insert into $systemprivateDirName values('$USER_PRIV','$PRIV_NAME','$FUNC_ID_STR')";
	$db->Execute($sql);
}
else {
	$sql = "update $systemprivateDirName set CONTENT='$FUNC_ID_STR' where ID='$USER_PRIV'";
	$db->Execute($sql);
}
$CONTENT = $FUNC_ID_STR;
$CONTENT_ARRAY = explode(',',$FUNC_ID_STR);
$TARGETARRAY = array();
for($i=0;$i<count($CONTENT_ARRAY);$i++)			{
	$POSTARRAY = explode('-',$CONTENT_ARRAY[$i]);
	if(!in_array($POSTARRAY[0],$TARGETARRAY)&&$POSTARRAY[0]!="")
		array_push($TARGETARRAY,$POSTARRAY[0]);
}

//print_R($TARGETARRAY);exit;
//处理原有系统权限信息
require_once("systemprivateinc.php");
$sql = "select * from ".$SYSTEM_PRE_TABLE."user_priv where PRIV_NAME='$PRIV_NAME'";
$rs = $db->Execute($sql);
$rs_a = $rs->GetArray();
$FUNC_ID_STR = $rs_a[0]['FUNC_ID_STR'];
$FUNC_ID_STR_ARRAY = explode(',',$FUNC_ID_STR);
//sort($FUNC_ID_STR_ARRAY);
$FUNC_ID_STR_ARRAY_FLIP = array_flip($FUNC_ID_STR_ARRAY);
$FUNC_ID_STR_ARRAY = array_flip($FUNC_ID_STR_ARRAY_FLIP);
//print $FUNC_ID_STR;
//print count($FUNC_ID_STR_ARRAY)."<BR>";

for($i=262;$i<400;$i++)			{
	$FUNC_ID_STR_ARRAY = DeleteArray($FUNC_ID_STR_ARRAY,$i);
}

$PARENT_MENU_ARRAY = array_keys($PRIVATE_SYSTEM);
for($i=0;$i<count($PARENT_MENU_ARRAY);$i++)			{
	$PARENT_MENU_NAME = $PARENT_MENU_ARRAY[$i];
	$PRIV_ID = returntablefield("sys_function","FUNC_NAME",$PARENT_MENU_NAME,"FUNC_ID");
	$PRIV_ID_INDEX = $FUNC_ID_STR_ARRAY_FLIP[$PRIV_ID];
	//print "<font color=red>$PRIV_ID_INDEX</font>";
	//print in_array($PRIV_ID,$FUNC_ID_STR_ARRAY)."<HR>";
	//如果存在先去除
	//2009-5-29进行集中去除
	//if(in_array($PRIV_ID,$FUNC_ID_STR_ARRAY))		{
		//print_R($FUNC_ID_STR_ARRAY);
		//$LEFT = "<font color=orange>$PRIV_ID-{$FUNC_ID_STR_ARRAY[$PRIV_ID_INDEX]}</font>";
		//$FUNC_ID_STR_ARRAY1 = array_slice($FUNC_ID_STR_ARRAY,0,$PRIV_ID_INDEX);
		//print_R($FUNC_ID_STR_ARRAY1);
		//$FUNC_ID_STR_ARRAY2 = array_slice($FUNC_ID_STR_ARRAY,$PRIV_ID_INDEX+1,count($FUNC_ID_STR_ARRAY));
		//print_R($FUNC_ID_STR_ARRAY2);
		//$FUNC_ID_STR_ARRAY = array_merge($FUNC_ID_STR_ARRAY1,$FUNC_ID_STR_ARRAY2);
		//print_R($FUNC_ID_STR_ARRAY);
		//$FUNC_ID_STR_ARRAY = DeleteArray($FUNC_ID_STR_ARRAY,$PRIV_ID);
		//print $PRIV_ID;print_R($FUNC_ID_STR_ARRAY);exit;
	//}
	//如果合法,则加入
	if(in_array($PARENT_MENU_NAME,$TARGETARRAY))				{
		$LEFT = "<font color=red>{$FUNC_ID_STR_ARRAY[$PRIV_ID_INDEX]}</font>";
		$FUNC_ID_STR_ARRAY[] = $PRIV_ID;
		//print_R($FUNC_ID_STR_ARRAY);
	}
	//$FUNC_ID_STR_ARRAY_FLIP = array_flip($FUNC_ID_STR_ARRAY);
	//$FUNC_ID_STR_ARRAY = array_flip($FUNC_ID_STR_ARRAY_FLIP);
	$FUNC_ID_STR = join(',',$FUNC_ID_STR_ARRAY);
	//print "<font color=green>$PARENT_MENU_NAME ".in_array($PARENT_MENU_NAME,$TARGETARRAY)." {$FUNC_ID_STR_ARRAY[$PRIV_ID_INDEX]}菜单ID:$PRIV_ID</font>$LEFT";
	//print $FUNC_ID_STR."";
	//print "<BR>";
}

//array_shift($FUNC_ID_STR_ARRAY);
//array_shift($FUNC_ID_STR_ARRAY);
$FUNC_ID_STR = join(',',$FUNC_ID_STR_ARRAY).",";
//print $FUNC_ID_STR."";print "<BR>";
//$sql = "update user_priv set FUNC_ID_STR='$FUNC_ID_STR' where PRIV_NAME='$PRIV_NAME'";
//$db->Execute($sql);
//print $sql;
//exit;
//$_SESSION['LOGIN_FUNC_STR'] = $FUNC_ID_STR;
//$LOGIN_FUNC_STR = $FUNC_ID_STR;


if($_GET['action2']=="")		{
	$返回 = "systemprivateview.php";
}
else	{
	$返回 =".ROOT_DIR."general/system/user_priv/".$_GET['action2'];
}

//print $返回;exit;

print_infor("你的操作已经保存,请返回,系统返回中...","trip","location='?$返回'","$返回");
exit;

}




function DeleteArray($Array,$KeyValue)			{
	$NewArray = array();
	for($i=0;$i<count($Array);$i++)		{
		if($KeyValue!=$Array[$i]&&$Array[$i]!="")		{
			$NewArray[] = $Array[$i];
		}
	}
	return $NewArray;
}

?><?php
/*
	版权归属:郑州单点科技软件有限公司;
	联系方式:0371-69663266;
	公司地址:河南郑州经济技术开发区第五大街经北三路通信产业园四楼西南;
	公司简介:郑州单点科技软件有限公司位于中国中部城市-郑州,成立于2007年1月,致力于把基于先进信息技术（包括通信技术）的最佳管理与业务实践普及到教育行业客户的管理与业务创新活动中，全面提供具有自主知识产权的教育管理软件、服务与解决方案，是中部最优秀的高校教育管理软件及中小学校管理软件提供商。目前已经有多家高职和中职类院校使用通达中部研发中心开发的软件和服务;

	软件名称:单点科技软件开发基础性架构平台,以及在其基础之上扩展的任何性软件作品;
	发行协议:数字化校园产品为商业软件,发行许可为LICENSE方式;单点CRM系统即SunshineCRM系统为GPLV3协议许可,GPLV3协议许可内容请到百度搜索;
	特殊声明:软件所使用的ADODB库,PHPEXCEL库,SMTARY库归原作者所有,余下代码沿用上述声明;
	*/
?>