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
CheckSystemPrivate("通达软件实验室系统设置-系统权限");
//######################教育组件-权限较验部分##########################


require_once('lib.inc.php');

$GLOBAL_SESSION=returnsession();


$MetaDatabases = $db->MetaDatabases();
if(in_array("TD_OA",$MetaDatabases))		{
	$SYSTEM_PRE_TABLE = "TD_OA.";
}
else	{
	$SYSTEM_PRE_TABLE = "";
}

if($_GET['action']=="")						{

page_css("系统权限信息设置");
$sql = "select USER_PRIV,PRIV_NAME,PRIV_NO,FUNC_ID_STR from ".$SYSTEM_PRE_TABLE."user_priv order by PRIV_NO";
$rs = $db->Execute($sql);
$rs_a = $rs->GetArray();

table_begin("80%");
print_title("系统权限信息设置");
print "<tr class=TableContent ><td><B>角色排序号</B></td><td><B>角色名称</B></td><td><B>操作</B></td></tr>";
for($i=0;$i<sizeof($rs_a);$i++)		{
	$USER_PRIV	= $rs_a[$i]['USER_PRIV'];
	$PRIV_NAME	= $rs_a[$i]['PRIV_NAME'];
	$PRIV_NO	= $rs_a[$i]['PRIV_NO'];
	$FUNC_ID_STR = $rs_a[$i]['FUNC_ID_STR'];
	//进行判断,如果是集美则不则权限进行初始化
	DoItPriv($PRIV_NAME,$USER_PRIV);
	$操作 = "<a href=\"?".base64_encode("action=SettingPriv&USER_PRIV=$USER_PRIV&PRIV_NAME=$PRIV_NAME")."\">设置权限</a>";
	print "<tr class=TableData><td>$PRIV_NO</td><td>$PRIV_NAME</td><td>$操作</td></tr>";
}
table_end();
print "<BR>";
table_begin("80%");
print_title("使用前必读:");
print "<tr class=TableContent ><td colspan=3>
&nbsp;&nbsp;1 左边菜单区域的菜单权限在通达OA->系统管理->组织机构设置->角色与权限设置菜单中进行设置。<BR>
&nbsp;&nbsp;2 本系统权限的值设置完成之后,不必重新登录系统,可以立即生效。</td></tr>";
table_end();



}


function DoItPriv($PRIV_NAME,$USER_PRIV)		{
	global $db;
	$sql = "select COUNT(*) AS NUM  from systemprivatetdlib where ID='$USER_PRIV'";
	$rs = $db->Execute($sql);
	$rs_a = $rs->GetArray();
	$NUM = TRIM($rs_a[0]['NUM']);
	if($NUM==0)			{
		//$sql = "select CONTENT from systemprivatetdlib where ID='1'";
		//$rs = $db->Execute($sql);
		//$rs_a = $rs->GetArray();
		//$CONTENT = $rs_a[0]['CONTENT'];
		$sql = "insert into systemprivatetdlib values('$USER_PRIV','$PRIV_NAME','');";
		$db->Execute($sql);
		//print $sql."<BR>";
	}
}


if($_GET['action']=="SettingPriv")						{
//table_begin("80%");
//print_title("系统权限信息设置");
$PRIV_NAME = $_GET['PRIV_NAME'];
$USER_PRIV = $_GET['USER_PRIV'];
$sql = "select CONTENT from systemprivatetdlib where ID='$USER_PRIV'";
$rs = $db->Execute($sql);
$rs_a = $rs->GetArray();
$CONTENT = $rs_a[0]['CONTENT'];
$CONTENT_ARRAY = explode(',',$CONTENT);
//print_R($_GET);
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
?>
<body class="bodycolor" topmargin="5" onload="init_scroll();">
<table border="0" width="100%" cellspacing="0" cellpadding="3" class="small">
  <tr>
    <td class="Big"><img src="images/notify_new.gif" WIDTH="22" HEIGHT="20" align="absmiddle"><span class="big3"> 编辑角色权限 - （<?php echo $_GET['PRIV_NAME']?>）</span>&nbsp;&nbsp;
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
<tr class="TableContent">
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
     <tr class="TableHeader" title="$PARENT_MENU_NAME">
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

page_css("系统权限信息设置");
$USER_PRIV = $_GET['USER_PRIV'];
$PRIV_NAME = $_GET['PRIV_NAME'];
$FUNC_ID_STR = $_POST['FUNC_ID_STR'];
$sql = "select * from systemprivatetdlib where ID='$USER_PRIV'";
$rs = $db->Execute($sql);
$rs_a = $rs->GetArray();
if(count($rs_a)==0)		{
	$sql = "insert into systemprivatetdlib values('$USER_PRIV','$PRIV_NAME','$FUNC_ID_STR')";
	$db->Execute($sql);
}
else {
	$sql = "update systemprivatetdlib set CONTENT='$FUNC_ID_STR' where ID='$USER_PRIV'";
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

print_infor("你的操作己经保存,请返回,系统返回中...","trip","location='?$返回'","$返回");
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

?>