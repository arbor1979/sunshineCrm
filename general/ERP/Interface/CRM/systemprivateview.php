<?php
//require_once('../../../../inc/conn.php');
//require_once("../../../../inc/utility.php");
//���²˵�����
//cache_menu();

//######################�������-Ȩ�޽��鲿��##########################
SESSION_START();
require_once("lib.inc.php");
$GLOBAL_SESSION=returnsession();
require_once("systemprivateinc.php");
CheckSystemPrivate("ϵͳ��Ϣ����-ϵͳȨ��");
//######################�������-Ȩ�޽��鲿��##########################


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


	//�ж����ݱ�ĵ�һ���ֶ��Ƿ�������
	$MetaColumns	= $db->MetaColumns('user');
	$array_shift	= @array_shift($MetaColumns);
	if($array_shift->primary_key!=1)			{
		$sql = "ALTER TABLE `user` ADD PRIMARY KEY ( `UID` ) ";										$db->Execute($sql);
		$sql = "ALTER TABLE `user` CHANGE `UID` `UID` INT( 11 ) NOT NULL AUTO_INCREMENT ";			$db->Execute($sql);
	}

	//�ж����ݱ�ĵ�һ���ֶ��Ƿ�������
	//$MetaColumns	= $db->MetaColumns($SYSTEM_PRE_TABLE."user_priv");
	//$array_shift	= @array_shift($MetaColumns);
	//if($array_shift->primary_key!=1)			{
	//	$sql = "ALTER TABLE `user_priv` ADD PRIMARY KEY ( `USER_PRIV` ) ";										$db->Execute($sql);
	//	$sql = "ALTER TABLE `user_priv` CHANGE `USER_PRIV` `USER_PRIV` INT( 11 ) NOT NULL AUTO_INCREMENT ";		$db->Execute($sql);
	//}

	//�ж����ݱ�ĵ�һ���ֶ��Ƿ�������
	$MetaColumns	= $db->MetaColumns('department');
	$array_shift	= @array_shift($MetaColumns);
	if($array_shift->primary_key!=1)			{
		$sql = "ALTER TABLE `department` ADD PRIMARY KEY ( `DEPT_ID` ) ";										$db->Execute($sql);
		$sql = "ALTER TABLE `department` CHANGE `DEPT_ID` `DEPT_ID` INT( 11 ) NOT NULL AUTO_INCREMENT ";		$db->Execute($sql);
	}

	page_css("ϵͳ��ɫȨ����Ϣ����");
	$sql = "select USER_PRIV,PRIV_NAME,PRIV_NO,FUNC_ID_STR from ".$SYSTEM_PRE_TABLE."user_priv order by PRIV_NO";
	$rs = $db->Execute($sql);
	$rs_a = $rs->GetArray();

	table_begin("80%");
	print_title("ϵͳ��ɫȨ����Ϣ����");
	print "<tr class=TableContent ><td><B>��ɫ�����</B></td><td><B>��ɫ����</B></td><td><B>����</B></td></tr>";
	for($i=0;$i<sizeof($rs_a);$i++)		{
		$USER_PRIV	= $rs_a[$i]['USER_PRIV'];
		$PRIV_NAME	= $rs_a[$i]['PRIV_NAME'];
		$PRIV_NO	= $rs_a[$i]['PRIV_NO'];
		$FUNC_ID_STR = $rs_a[$i]['FUNC_ID_STR'];
		//�����ж�,����Ǽ�������Ȩ�޽��г�ʼ��
		DoItPriv($PRIV_NAME,$USER_PRIV);
		$���� = "<a href=\"?".base64_encode("FFFF=XXXX&action=SettingPriv&USER_PRIV=$USER_PRIV&PRIV_NAME=$PRIV_NAME&FFFF=XXXX")."\">������ϸȨ��</a>&nbsp;&nbsp;";
		if($_SESSION['SYSTEM_IS_TD_OA']==0)					{
			$���� .= "<a href=\"?".base64_encode("FFFF=XXXX&action=EditPrivName&USER_PRIV=$USER_PRIV&PRIV_NAME=$PRIV_NAME&PRIV_NO=$PRIV_NO&FFFF=XXXX")."\">�޸�����</a>&nbsp;&nbsp;";
			$���� .= "<a href=\"javascript:if(confirm('�������Ҫɾ�������¼��'))location='?".base64_encode("FFFF=XXXX&action=DeletePrivName&USER_PRIV=$USER_PRIV&PRIV_NAME=$PRIV_NAME&FFFF=XXXX")."'\">ɾ��</a>&nbsp;&nbsp;";
		}
		print "<tr class=TableData><td>$PRIV_NO</td><td>$PRIV_NAME</td><td>$����</td></tr>";
	}
	table_end();
	print "<BR>";
	//print_R($_SESSION);



	if($_SESSION['SYSTEM_IS_TD_OA']==1)					{
		table_begin("80%");
		print_title("ʹ��ǰ�ض�:");
		print "<tr class=TableContent ><td colspan=3>
		&nbsp;&nbsp;1 ��߲˵�����Ĳ˵�Ȩ����ͨ��OA->ϵͳ����->��֯��������->��ɫ��Ȩ�����ò˵��н������á�<BR>
		&nbsp;&nbsp;2 ͨ�����ֻ�У԰Ȩ�޵�ֵ�������֮��,�������µ�¼ϵͳ,����������Ч��</td></tr>";
		table_end();
	}
	else					{
		print "
			<script language = \"JavaScript\">
			function FormCheck()
			{
				if (document.form1.��ɫ����.value == \"\") {
					alert(\"��ɫ���Ʋ���Ϊ��\");
					return false;
				}
			}
			</script>
			";
		print "<FORM name=form1 onsubmit=\"return FormCheck();\" action=\"?action=add_default_data&pageid=1\" method=post encType=multipart/form-data>";
		table_begin("80%");
		print_title("�½���ɫȨ����Ϣ:");
		print "<tr class=TableContent ><td colspan=3>
		&nbsp;&nbsp;��ɫ����:<INPUT type=\"text\" class=\"SmallInput\"  maxLength=200 size=\"15\" name='��ɫ����' value=\"\"  >
		&nbsp;&nbsp;�����:<INPUT type=\"text\" class=\"SmallInput\"  maxLength=200 size=\"6\" name='�����' value=\"10\"  >
		&nbsp;&nbsp;<input type=submit name=\"submit\" value=\"�ύ\" class=SmallButton>

		</td></tr>";
		table_end();

		//$sql = "ALTER TABLE `user_priv` ADD PRIMARY KEY ( `USER_PRIV` ) ;";
		//$db->Execute($sql);
		//$sql = "ALTER TABLE `user_priv` CHANGE `USER_PRIV` `USER_PRIV` INT( 11 ) NOT NULL AUTO_INCREMENT ;";
		//$db->Execute($sql);


	}



}


if($_GET['action']=="EditPrivName")						{
		page_css("��ɫȨ���޸�����");
		print "
			<script language = \"JavaScript\">
			function FormCheck()
			{
				if (document.form1.��ɫ����.value == \"\") {
					alert(\"��ɫ���Ʋ���Ϊ��\");
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
		print_title("�޸Ľ�ɫȨ�����Ƽ������:");
		print "<tr class=TableContent ><td colspan=3>
		&nbsp;&nbsp;��ɫ����:<INPUT type=\"text\" class=\"SmallInput\"  maxLength=200 size=\"15\" name='��ɫ����' value=\"$PRIV_NAME\"  >
		&nbsp;&nbsp;�����:<INPUT type=\"text\" class=\"SmallInput\"  maxLength=200 size=\"6\" name='�����' value=\"$PRIV_NO\"  >
		&nbsp;&nbsp;<INPUT type=\"hidden\" class=\"SmallInput\"  maxLength=200 size=\"6\" name='USER_PRIV' value=\"$USER_PRIV\"  >
		&nbsp;&nbsp;<input type=submit name=\"submit\" value=\"�ύ\" class=SmallButton>

		</td></tr>";
		table_end();
	exit;
}

if($_GET['action']=="edit_default_data")						{
	page_css("��ɫȨ����������");
	//table_begin("80%");
	//print_title("ϵͳ��ɫȨ����Ϣ����");
	//print_R($_POST);
	$��ɫ����	= $_POST['��ɫ����'];
	$�����		= $_POST['�����'];
	$USER_PRIV	= $_POST['USER_PRIV'];
	$sql		= "update ".$SYSTEM_PRE_TABLE."user_priv set PRIV_NAME='$��ɫ����',PRIV_NO='$�����' where USER_PRIV='$USER_PRIV'";
	if($��ɫ����!="")	$db->Execute($sql);
	print_infor("��ɫ�����޸ĳɹ�,ϵͳ������!",'',"location='?'",'?');
	exit;
}


if($_GET['action']=="add_default_data")						{
	page_css("��ɫȨ����������");
	//table_begin("80%");
	//print_title("ϵͳ��ɫȨ����Ϣ����");
	//print_R($_POST);
	$��ɫ����	= $_POST['��ɫ����'];
	$�����		= $_POST['�����'];
	$sql		= "select COUNT(*) AS NUM from ".$SYSTEM_PRE_TABLE."user_priv where PRIV_NAME='$��ɫ����'";
	$rs			= $db->Execute($sql);
	$rs_a		= $rs->GetArray();
	$NUM		= $rs_a[0]['NUM'];
	if($NUM==0&&$��ɫ����!='')					{
		$sql = "insert into ".$SYSTEM_PRE_TABLE."user_priv(USER_PRIV,PRIV_NAME,PRIV_NO,FUNC_ID_STR) value('','$��ɫ����','$�����','');";
		$db->Execute($sql);
		//$USER_PRIV = $db->InsertID();
		//print $��ɫ����;
		print_infor("��ɫ�������ӳɹ�,ϵͳ������!",'',"location='?'",'?',1);
		exit;
	}
	else	{
		print_infor("������Ľ�ɫ�����Ѿ�����,�뻻����������!",'',"location='?'",'?',1);
		exit;
	}

}



if($_GET['action']=="DeletePrivName")						{
	page_css("��ɫȨ��ɾ��");
	//table_begin("80%");
	//print_title("ϵͳ��ɫȨ����Ϣ����");
	//print_R($_POST);
	$USER_PRIV		= $_GET['USER_PRIV'];
	$PRIV_NAME		= $_GET['PRIV_NAME'];
	$sql		= "delete from ".$SYSTEM_PRE_TABLE."user_priv where PRIV_NAME='$PRIV_NAME' and USER_PRIV='$USER_PRIV' ";
	$db->Execute($sql);
	print_infor("��ɫ����ɾ���ɹ�,ϵͳ������!",'',"location='?'",'?');
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
//print_title("ϵͳ��ɫȨ����Ϣ����");
$PRIV_NAME = $_GET['PRIV_NAME'];
$USER_PRIV = $_GET['USER_PRIV'];
$sql = "select CONTENT from $systemprivateDirName where ID='$USER_PRIV'";
$rs = $db->Execute($sql);
$rs_a = $rs->GetArray();
$CONTENT = $rs_a[0]['CONTENT'];
$CONTENT_ARRAY = explode(',',$CONTENT);
//print_R($CONTENT);
page_css("�༭��ɫȨ��");
?>


<script src="<?php echo ROOT_DIR?>inc/js/ccorrect_btn.js"></script>

<html>
<head>
<title>�༭��ɫȨ��</title>
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
	$���� = "systemprivateview.php";
}
else	{
	$���� =".ROOT_DIR."general/system/user_priv/".$_GET['action2'];
}


if(is_file('../../Framework/license.ini'))			{
	$ini_file=@parse_ini_file('../../Framework/license.ini');
	$��ʾ�ı� = "(��Ȩ��λ:".$ini_file['SCHOOL_NAME']." ����汾:".$ini_file['SOFTWARE_TYPE'].")";
}
else	{
	$��ʾ�ı� = "(�����Ϊ���ð汾,���蹺������ϵ���������!)";
}
?>
<body class="bodycolor" topmargin="5" onload="init_scroll();">
<table border="0" width="100%" cellspacing="0" cellpadding="3" class="small">
  <tr>
    <td class="Big"><img src="images/notify_new.gif" WIDTH="22" HEIGHT="20" align="absmiddle"><span class="big3"> <?php echo $_GET['PRIV_NAME']?>Ȩ�� - <?php echo $��ʾ�ı�?> </span>&nbsp;&nbsp;
    <div id="OP_BTN" style="width:150px;top:5px;right:20px;position:absolute;">
     <form name="form1" method="post" action="?<?php echo base64_encode("action=SettingPrivData&USER_PRIV=$USER_PRIV&PRIV_NAME=$PRIV_NAME&action2=".$_GET['action2']."&FF=FF")?>">
      <input type="hidden" value="" name="FUNC_ID_STR">
      <input type="hidden" value="4" name="USER_PRIV">
      <input type="button" value="ȷ��" class="BigButton" onclick="mysubmit();">&nbsp;&nbsp;
      <input type="button" value="����" class="BigButton" onclick="location='<?php echo $����?>'">
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

//����һ������������Ӳ˵�
$GROUP_ONE_ARRAY = array_keys($PRIVATE_SYSTEM[$PARENT_MENU_NAME]);
//print_R($GROUP_ONE_ARRAY);
for($ii=0;$ii<count($GROUP_ONE_ARRAY);$ii++)			{
	$GROUP_ONE_NAME = $GROUP_ONE_ARRAY[$ii];
	$GROUP_ONE_CODE = $ii;
	$GROUP_TWO_ARRAY = array_keys($PRIVATE_SYSTEM[$PARENT_MENU_NAME][$GROUP_ONE_NAME]);
	//print_R($GROUP_TWO_ARRAY);
//ȷ�������˵��Ĵ�����
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

page_css("ϵͳ��ɫȨ����Ϣ����");
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
//����ԭ��ϵͳȨ����Ϣ
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
	//���������ȥ��
	//2009-5-29���м���ȥ��
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
	//����Ϸ�,�����
	if(in_array($PARENT_MENU_NAME,$TARGETARRAY))				{
		$LEFT = "<font color=red>{$FUNC_ID_STR_ARRAY[$PRIV_ID_INDEX]}</font>";
		$FUNC_ID_STR_ARRAY[] = $PRIV_ID;
		//print_R($FUNC_ID_STR_ARRAY);
	}
	//$FUNC_ID_STR_ARRAY_FLIP = array_flip($FUNC_ID_STR_ARRAY);
	//$FUNC_ID_STR_ARRAY = array_flip($FUNC_ID_STR_ARRAY_FLIP);
	$FUNC_ID_STR = join(',',$FUNC_ID_STR_ARRAY);
	//print "<font color=green>$PARENT_MENU_NAME ".in_array($PARENT_MENU_NAME,$TARGETARRAY)." {$FUNC_ID_STR_ARRAY[$PRIV_ID_INDEX]}�˵�ID:$PRIV_ID</font>$LEFT";
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
	$���� = "systemprivateview.php";
}
else	{
	$���� =".ROOT_DIR."general/system/user_priv/".$_GET['action2'];
}

//print $����;exit;

print_infor("��Ĳ����Ѿ�����,�뷵��,ϵͳ������...","trip","location='?$����'","$����");
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
	��Ȩ����:֣�ݵ���Ƽ�������޹�˾;
	��ϵ��ʽ:0371-69663266;
	��˾��ַ:����֣�ݾ��ü��������������־�����·ͨ�Ų�ҵ԰��¥����;
	��˾���:֣�ݵ���Ƽ�������޹�˾λ���й��в�����-֣��,������2007��1��,�����ڰѻ����Ƚ���Ϣ����������ͨ�ż���������ѹ�����ҵ��ʵ���ռ���������ҵ�ͻ��Ĺ�����ҵ���»�У�ȫ���ṩ��������֪ʶ��Ȩ�Ľ�����������������������������в�������ĸ�У���������������СѧУ��������ṩ�̡�Ŀǰ�Ѿ��ж�Ҹ�ְ����ְ��ԺУʹ��ͨ���в��з����Ŀ���������ͷ���;

	�������:����Ƽ�������������Լܹ�ƽ̨,�Լ��������֮����չ���κ��������Ʒ;
	����Э��:���ֻ�У԰��ƷΪ��ҵ���,�������ΪLICENSE��ʽ;����CRMϵͳ��SunshineCRMϵͳΪGPLV3Э�����,GPLV3Э����������뵽�ٶ�����;
	��������:�����ʹ�õ�ADODB��,PHPEXCEL��,SMTARY���ԭ��������,���´���������������;
	*/
?>