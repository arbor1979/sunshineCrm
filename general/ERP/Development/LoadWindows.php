<?php

require_once("lib.inc.php");
require_once("class.dir.php");
$dirlist = "../Interface/";
//print_R($_GET);
print "<META http-equiv=Content-Type content='text/html; charset=gb2312'>";
print "<link rel='stylesheet' type='text/css' href='".ROOT_DIR."theme/3/style.css'>";
$common_html=returnsystemlang('common_html');

$FUNC_LINK = "?action=Detail&SYSTEM_MODE=".$_GET['SYSTEM_MODE']."&parentName=".$_GET[parentName]."&sectionName=";

$returnDirName = array( array('FUNC_NAME' => 'Input[�����]','FUNC_LINK' => "#\" Onclick=\"SetParentValue_close('input');\" title=\"input",'IsColse'=>1),
						array('FUNC_NAME' => 'TableFilter[�����]','FUNC_LINK' => $FUNC_LINK."tablefilter"),
						array('FUNC_NAME' => 'RadioFilter[�����]','FUNC_LINK' => $FUNC_LINK."radiofilter"),
						//array('FUNC_NAME' => 'SelectInput','FUNC_LINK' => $FUNC_LINK."select_input"),
						//array('FUNC_NAME' => 'SelectTextarea','FUNC_LINK' => $FUNC_LINK."select_text",'IsColse'=>1),
						array('FUNC_NAME' => 'Date[��ǰ����]','FUNC_LINK' => "#\" Onclick=\"SetParentValue_close('date');\" title=\"date",'IsColse'=>1),
						array('FUNC_NAME' => 'Date1[��������]','FUNC_LINK' => "#\" Onclick=\"SetParentValue_close('date1');\" title=\"date1",'IsColse'=>1),
						array('FUNC_NAME' => 'Hidden_User[�����û�]','FUNC_LINK' => "#\" Onclick=\"SetParentValue_close('hidden_field:1:name');\" title=\"hidden_field:1:name",'IsColse'=>1),
						array('FUNC_NAME' => 'Hidden_Dept[���ز���]','FUNC_LINK' => "#\" Onclick=\"SetParentValue_close('hidden_field:1:dept');\" title=\"hidden_field:1:dept",'IsColse'=>1),
						array('FUNC_NAME' => 'System_Date[ϵͳ����]','FUNC_LINK' => "#\" Onclick=\"SetParentValue_close('system_datetime');\" title=\"system_datetime",'IsColse'=>1),
						array('FUNC_NAME' => 'Textarea[�ı���]','FUNC_LINK' => "#\" Onclick=\"SetParentValue_close('textarea');\" title=\"textarea",'IsColse'=>1),
						array('FUNC_NAME' => 'Htmlarea[HTML��]','FUNC_LINK' => "#\" Onclick=\"SetParentValue_close('htmlarea');\" title=\"htmlarea",'IsColse'=>1),
						array('FUNC_NAME' => 'Boolean[01����]','FUNC_LINK' => "#\" Onclick=\"SetParentValue_close('boolean');\" title=\"boolean"),
						array('FUNC_NAME' => 'edu_boolean[�Ƿ�����]','FUNC_LINK' => "#\" Onclick=\"SetParentValue_close('radiofilter:edu_boolean:1:1');\" title=\"radiofilter:edu_boolean:1:1"),
						array('FUNC_NAME' => 'gb_sex[��Ů�Ա�]','FUNC_LINK' => "#\" Onclick=\"SetParentValue_close('radiofilter:gb_sex:1:1');\" title=\"radiofilter:gb_sex:1:1"),
						array('FUNC_NAME' => 'autoincrement[�Զ�����]','FUNC_LINK' => "#\" Onclick=\"SetParentValue_close('autoincrement');\" title=\"autoincrement"),
						array('FUNC_NAME' => 'autoincrementdate[ʱ���Զ�����]','FUNC_LINK' => "#\" Onclick=\"SetParentValue_close('autoincrementdate');\" title=\"autoincrementdate"),
						array('FUNC_NAME' => 'readonly[ֻ������]','FUNC_LINK' => "#\" Onclick=\"SetParentValue_close('readonly');\" title=\"readonly"),
						array('FUNC_NAME' => 'readonlytextarea[�ı�ֻ��]','FUNC_LINK' => "#\" Onclick=\"SetParentValue_close('readonlytextarea');\" title=\"readonlytextarea"),
						array('FUNC_NAME' => 'singlefile[�ļ�����]','FUNC_LINK' => "#\" Onclick=\"SetParentValue_close('singlefile');\" title=\"singlefile"),
						array('FUNC_NAME' => 'picturefile[ͼƬ�ļ�]','FUNC_LINK' => "#\" Onclick=\"SetParentValue_close('picturefile');\" title=\"picturefile"),
						array('FUNC_NAME' => 'nowshow[�ֶ�����]','FUNC_LINK' => "#\" Onclick=\"SetParentValue_close('nowshow');\" title=\"nowshow"),
						array('FUNC_NAME' => 'userdefine[�û��Զ���]','FUNC_LINK' => '?action=Detail&SYSTEM_MODE='.$_GET['SYSTEM_MODE'].'&parentName='.$_GET[parentName].'&sectionName=userdefine')

						);


print "<script>
		function SetParentValue_close(SectionName)	{
			var parent_window = parent.dialogArguments;\n
			parent_window.form1.".$_GET['parentName'].".value =SectionName;
			window.opener =window.self;
			window.close();
		}
		</script>";


$returnText['autoincrement'] = "
������ʾ<font color=red>�Զ���������</font>��ѡ��<BR>&nbsp;&nbsp;��:100001,100002,100003</font>
";

$returnText['autoincrementdate'] = "
������ʾ<font color=red>����ʱ�����ڵ��Զ���������</font>��ѡ��<BR>&nbsp;&nbsp;��:2009090001,2009090002,2009090003</font>
";

$returnText['readonly'] = "
������ʾ<font color=red>ֻ������</font>��ѡ��<BR>&nbsp;&nbsp;</font>
";

$returnText['readonlytextarea'] = "
������ʾ<font color=red>TEXTAREAֻ������</font>��ѡ��<BR>&nbsp;&nbsp;</font>
";

$returnText['singlefile'] = "
������ʾ<font color=red>�ļ���������</font>��ѡ��<BR>&nbsp;&nbsp;</font>
";

$returnText['picturefile'] = "
������ʾ<font color=red>ͼƬ�ļ�����</font>��ѡ��<BR>&nbsp;&nbsp;</font>
";

$returnText['nowshow'] = "
������ʾ<font color=red>������FORM����INPUT��HIDDEN����</font>��ѡ��<BR>&nbsp;&nbsp;�������Ժ�����Ҫ��ҳ�����ADD_DATA��EDIT_DATA���������ֹ�ָ��NOTSHOW�ֶε�\$_POSTֵ</font>
";


//�û��Զ����б�,���Ŀ¼�������userdefine�ļ�,�ͻ�ȫ���б����,����˵��
$Ŀ��Ŀ¼ = "../Interface/$SYSTEM_MODE_DIR/userdefine/";
$NewArray = array();
if ($dh = @opendir($Ŀ��Ŀ¼)) {
        while (($file = @readdir($dh)) !== false) {
            $ALLPATH = $Ŀ��Ŀ¼ . $file;
           
			if(@is_file($ALLPATH))		{
				require_once($ALLPATH);
				$fileArray = explode('.',$file);
				$fileprew = $fileArray[0];
				 
				$NewArray[] = "<font color=red>".$file."</font>\n<BR>��;:".$$fileprew."<input type=Button class=SmallButton name=inputSelect onclick='SetParentValue_UserDefine(\"$fileprew\");' value='ѡ��'>\n";

			}
        }
        @closedir($dh);
}

//print_R($_GET);
$NewArrayText = join("<BR>",$NewArray);
$returnText['userdefine'] = "
������ʾ<font color=red>�û��Զ�������</font>��ѡ��<BR>&nbsp;&nbsp;ר���ڷ���Ŀ¼�����userdefine�ļ��д��,���ù���μ���ǰ����.����:<BR>
$NewArrayText
</font>
";



$returnText['radiofilter:gb_sex:1:1'] = "
������ʾ<font color=red>boolean��'��'��'Ů'����</font>��ѡ��<BR>&nbsp;&nbsp;������� tablefilter:gb_sex:1:1<BR>&nbsp;&nbsp;0��1�� tablefilter:gb_sex:0:0</font>
";

$returnText['radiofilter:edu_boolean:1:1'] = "
������ʾ<font color=red>boolean��'��'��'��'����</font>��ѡ��<BR>&nbsp;&nbsp;�������edu_boolean:1:1<BR>&nbsp;&nbsp;0��1��edu_boolean:0:0</font>
";

$returnText['input'] = "�������Ҫ����
<font color=red>ADD,EDIT,VIEW</font>ģ�ͣ�
��<font color=red>INIT��VIEW</font>ģ��������
<font color=red>ֱ����ʾ</font>���������κι��ˡ�
�����ǳ��õ�TableFilter��Ϣ����:<BR>
<input  style=\"width:330\" type=Button class=SmallButton name=inputSelect onclick=\"SetParentValue_define('tablefiltercolor:edu_xueqiexec:1:1');\" value='tablefiltercolor:edu_xueqiexec:1:1 ѧ��'><BR>
<input  style=\"width:330\" type=Button class=SmallButton name=inputSelect onclick=\"SetParentValue_define('tablefiltercolor:edu_classroom:1:1');\" value='tablefiltercolor:edu_classroom:1:1 ����'><BR>
<input  style=\"width:330\" type=Button class=SmallButton name=inputSelect onclick=\"SetParentValue_define('tablefiltercolor:edu_course:1:1');\" value='tablefiltercolor:edu_course:1:1 �γ�'><BR>
<input  style=\"width:330\" type=Button class=SmallButton name=inputSelect onclick=\"SetParentValue_define('tablefiltercolor:edu_banji:1:1');\" value='tablefiltercolor:edu_banji:1:1 �༶'><BR>
<input  style=\"width:330\" type=Button class=SmallButton name=inputSelect onclick=\"SetParentValue_define('tablefiltercolor:user:1:2');\" value='tablefiltercolor:user:1:2 �û�1'><BR>
<input  style=\"width:330\" type=Button class=SmallButton name=inputSelect onclick=\"SetParentValue_define('tablefiltercolor:user:2:2');\" value='tablefiltercolor:user:2:2 �û�2'><BR>
<input  style=\"width:330\" type=Button class=SmallButton name=inputSelect onclick=\"SetParentValue_define('tablefiltercolor:department:1:1');\" value='tablefiltercolor:department:1:1 ����'><BR>
<input  style=\"width:330\" type=Button class=SmallButton name=inputSelect onclick=\"SetParentValue_define('tablefiltercolor:edu_xingzheng_banci:1:1');\" value='tablefiltercolor:edu_xingzheng_banci:1:1 �������'><BR>
<input  style=\"width:330\" type=Button class=SmallButton name=inputSelect onclick=\"SetParentValue_define('tablefiltercolor:edu_boolean:1:1');\" value='tablefiltercolor:edu_boolean:1:1 �Ƿ�'><BR>
<input  style=\"width:330\" type=Button class=SmallButton name=inputSelect onclick=\"SetParentValue_define('tablefiltercolor:edu_boolean:0:1');\" value='tablefiltercolor:edu_boolean:0:1 �Ƿ�01'><BR><BR>
<input  style=\"width:330\" type=Button class=SmallButton name=inputSelect onclick=\"SetParentValue_define('tablefiltercolor:edu_banji:1:1');\" value='tablefiltercolor:edu_zhuanye:2:2 רҵ'><BR>
<input  style=\"width:330\" type=Button class=SmallButton name=inputSelect onclick=\"SetParentValue_define('tablefiltercolor:edu_banji:1:1');\" value='tablefiltercolor:edu_jiaocai:1:1 �̲�'><BR>

<input  style=\"width:330\" type=Button class=SmallButton name=inputSelect onclick=\"SetParentValue_define('tdoafile');\" value='tdoafile:ͨ���ϴ�������ʽ'><BR>

<input  style=\"width:330\" type=Button class=SmallButton name=inputSelect onclick=\"SetParentValue_define('usertoname');\" value='usertoname:�����û�ѡ���[USER_NAME]'><BR>
<input  style=\"width:330\" type=Button class=SmallButton name=inputSelect onclick=\"SetParentValue_define('usertoid');\" value='usertoid:�����û�ѡ���[USER_ID]'><BR>
<input  style=\"width:330\" type=Button class=SmallButton name=inputSelect onclick=\"SetParentValue_define('usertonamelist');\" value='usertonamelist:��������û�ѡ���[USER_NAME]'><BR>

<input  style=\"width:330\" type=Button class=SmallButton name=inputSelect onclick=\"SetParentValue_define('depttoname');\" value='depttoname:��������ѡ���[DEPT_NAME]'><BR>
<input  style=\"width:330\" type=Button class=SmallButton name=inputSelect onclick=\"SetParentValue_define('depttoid');\" value='depttoid:��������ѡ���[DEPT_ID]'><BR>

<input  style=\"width:330\" type=Button class=SmallButton name=inputSelect onclick=\"SetParentValue_define('jumpkehu');\" value='jumpkehu:�����ͻ���ѡ��'><BR>
<input  style=\"width:330\" type=Button class=SmallButton name=inputSelect onclick=\"SetParentValue_define('jumpkehumulti');\" value='jumpkehumulti:�����ͻ���ѡ��'><BR>
<input  style=\"width:330\" type=Button class=SmallButton name=inputSelect onclick=\"SetParentValue_define('jumplinkmanmulti');\" value='jumplinkmanmulti:�����ͻ���ϵ�˶�ѡ��'><BR>
<input  style=\"width:330\" type=Button class=SmallButton name=inputSelect onclick=\"SetParentValue_define('jumpsupplylinkmanmulti');\" value='jumpsupplylinkmanmulti:������Ӧ����ϵ�˶�ѡ��'><BR>
<input  style=\"width:330\" type=Button class=SmallButton name=inputSelect onclick=\"SetParentValue_define('jumpsupply');\" value='jumpsupply:������Ӧ�̵�ѡ��'><BR>
<input  style=\"width:330\" type=Button class=SmallButton name=inputSelect onclick=\"SetParentValue_define('jumpproducttype');\" value='prodtypetoid:������Ʒ���ѡ���[PROD_ID]'><BR>
<input  style=\"width:330\" type=Button class=SmallButton name=inputSelect onclick=\"SetParentValue_define('jumpproduct');\" value='producttoid:������Ʒѡ���[PROD_ID]'><BR>

<input  style=\"width:330\" type=Button class=SmallButton name=inputSelect onclick=\"SetParentValue_define('jumpcourse');\" value='jumpcourse:�������пγ�ѡ���'><BR>
<input  style=\"width:330\" type=Button class=SmallButton name=inputSelect onclick=\"SetParentValue_define('jumpdorm');\" value='jumpdorm:������������ѡ���'><BR>
<input  style=\"width:330\" type=Button class=SmallButton name=inputSelect onclick=\"SetParentValue_define('jumpclassroom');\" value='jumpclassroom:�������н���ѡ���'><BR>
<input  style=\"width:330\" type=Button class=SmallButton name=inputSelect onclick=\"SetParentValue_define('jumpstudentall');\" value='jumpstudentall:��������ѧ��ѡ���'><BR>
<input  style=\"width:330\" type=Button class=SmallButton name=inputSelect onclick=\"SetParentValue_define('jumpbanji');\" value='jumpbanji:�����༶ѡ���'><BR>
<input  style=\"width:330\" type=Button class=SmallButton name=inputSelect onclick=\"SetParentValue_define('jumpjiaocai');\" value='jumpjiaocai:�����̲�ѡ���'><BR>

<input  style=\"width:330\" type=Button class=SmallButton name=inputSelect onclick=\"SetParentValue_define('select_input:department:1:1');\" value='select_input:department:1:1'><BR>
<input  style=\"width:330\" type=Button class=SmallButton name=inputSelect onclick=\"SetParentValue_define('tablefiltercolor:hrms_zhiwei_status:1:1');\" value='tablefiltercolor:hrms_zhiwei_status:1:1'><BR>
<input  style=\"width:330\" type=Button class=SmallButton name=inputSelect onclick=\"SetParentValue_define('tablefiltercolor:dict_education:1:1');\" value='tablefiltercolor:dict_education:1:1'><BR>
<input  style=\"width:330\" type=Button class=SmallButton name=inputSelect onclick=\"SetParentValue_define('tablefiltercolor:gb_political:1:1');\" value='tablefiltercolor:gb_political:1:1'><BR>
<input  style=\"width:330\" type=Button class=SmallButton name=inputSelect onclick=\"SetParentValue_define('tablefiltercolor:gb_marriage:1:1');\" value='tablefiltercolor:gb_marriage:1:1'><BR>
<input  style=\"width:330\" type=Button class=SmallButton name=inputSelect onclick=\"SetParentValue_define('tablefiltercolor:gb_sex:1:1');\" value='tablefiltercolor:gb_sex:1:1'><BR>
<input  style=\"width:330\" type=Button class=SmallButton name=inputSelect onclick=\"SetParentValue_define('tablefiltercolor:hrms_zhiwei_status:1:1');\" value='tablefiltercolor:hrms_zhiwei_status:1:1'><BR>
<input  style=\"width:330\" type=Button class=SmallButton name=inputSelect onclick=\"SetParentValue_define('tablefiltercolor:hrms_zhiwei_status:1:1');\" value='tablefiltercolor:hrms_zhiwei_status:1:1'><BR>
";

$returnText['tablefilter'] = "
��<font color=red>INIT��VIEW</font>ģ����ͨ�����ݱ�������������ֵ��<BR>
��<font color=red>ADD��EDIT</font>ģ������SELECT�����˵���ʽ��ʾ��<BR>
<font color=red>ʾ����</font><BR>
Tablefilter:Dict_ServicePharse:2:1:New:<BR>satisfaction:Complete:true<BR>
<font color=red>˵����</font><BR>
��������::����::�����ֶ�::�ؼ��ֶ�::��ʼ��ֵ::���ֶ�ΪFalse::������ֵʱ::Ϊ��True<BR>
����True����û��ʹ�õ�,������ֵʱ���Զ���Ϊ��ֵ<BR>
<font color=red>һ�������ֻ�趨��Tablefilter:Dict_ServicePharse:2:1:New���趨��ǰ��������</font>�����ĸ��趨<font color=red>��ʼֵ</font>����������һ�������ʹ�á�<BR>
";

$returnText['radiofilter'] = "
��<font color=red>INIT��VIEW</font>ģ����ͨ�����ݱ�������������ֵ��<BR>
��<font color=red>ADD��EDIT</font>ģ������SELECT�����˵���ʽ��ʾ��<BR>
<font color=red>ʾ����</font><BR>
Radiofilter:Dict_ServicePharse:2:1:New:<BR>satisfaction:Complete:true<BR>
<font color=red>˵����</font><BR>
��������::����::�����ֶ�::�ؼ��ֶ�::��ʼ��ֵ::���ֶ�ΪFalse::������ֵʱ::Ϊ��True<BR>
����True����û��ʹ�õ�,������ֵʱ���Զ���Ϊ��ֵ<BR>
<font color=red>һ�������ֻ�趨��Radiofilter:Dict_ServicePharse:2:1:New���趨��ǰ��������</font>�����ĸ��趨<font color=red>��ʼֵ</font>����������һ�������ʹ�á�<BR>
";

$returnText['select_input'] = "
��<font color=red>INIT��VIEW</font>ģ����ͨ��TableFilter��TableFilterColor������<font color=red>ȡ��Select_Input</font>��<BR>
��<font color=red>ADD��EDIT</font>ģ�����Ե������ڵ���ʽ��ʾ��<BR>
<font color=red>ʾ����</font><BR>
select_input:Dict_ServicePharse:2:1<BR>
<font color=red>˵����</font><BR>
��������::����::�����ֶ�::�ؼ��ֶ�<BR>
";

$returnText['select_text'] = "
��������Ҫ����ѡȡ�û�ʱʹ�ã�����������γ�һ���˵�������ʾ������Ϣ���ұ�����ϸ������ʾ����Ա������Ϣ�����Զ�ѡ��
";

$returnText['date'] = "
����������ѡȡ<font color=red>��������</font>����������������Ϳ���ѡ��һ��Ĭ��Ϊ<font color=red>ϵͳ���������</font>�������޸���ֵ��Ĭ�����ڸ�ʽ<font color=red>2006-06-06</font>
";
$returnText['date1'] = "
����������ѡȡ<font color=red>��������</font>����������������Ϳ���ѡ��һ��Ĭ��Ϊ<font color=red>ϵͳ�¸��µĽ���</font>�������޸���ֵ��Ĭ�����ڸ�ʽ<font color=red>2006-06-06</font>
";
$returnText['hidden_field:1:name'] = "
����������ʵ�ֶ�<font color=red>�û�����������ʾ</font>������<font color=red>ȷ����һ����¼����һλԱ������ʱ�õ�</font>
";
$returnText['hidden_field:1:dept'] = "
����������ʵ�ֶ�<font color=red>���Ŵ����������ʾ</font>������<font color=red>ȷ����һ����¼����һλԱ�����ڲ���ʱ�õ�</font>
";
$returnText['system_datetime'] = "
����������ʵ�ֶ�<font color=red>ϵͳ����ʱ���������ʾ</font>������<font color=red>ȷ����һ����¼��ʲô�½���༭ʱ�õ�</font>
";
$returnText['textarea'] = "
����������ʵ�ֶ�<font color=red>Textarea������������</font>ʵ��
";
$returnText['htmlarea'] = "
����������ʵ�ֶ�<font color=red>HTML�ı��༭������</font>ʵ��
";
$returnText['link:view_default'] = "
Ӧ����INITģ���У���Ҫ�Ե�ǰ���ݽ���<font color=red>��������ʽ</font>���ˣ�ת��View��ͼ��
";
$returnText['link:view_customer'] = "
Ӧ����INITģ���У���Ҫ�Ե�ǰ���ݽ���<font color=red>��������ʽ</font>���ˣ�ת��View��ͼ��
";
$returnText['boolean'] = "
������ʾ<font color=red>boolean����</font>��ѡ��һ�����������ѡ�<font color=red>\"��\"</font>��<font color=red>\"��\"</font>��
";
$returnText['password'] = "
��INIT��VIEW����<font color=red>\"******\"</font>����ʽ��ʾ��
��ADD,EDITģ������<font color=red>��׼���������</font>����ʽ��ʾ��
���ӣ������жϸ�ʽΪ<font color=red>\"����Ϊ������\"</font>

";
$returnText['sex'] = "
��INITģ���У���ʾ<font color=red>�Ա������˵�</font>��������ģ��(��<font color=red>ADD,EDIT,VIEW</font>ģ��)����<font color=red>select_sex</font>�����Դ��ڡ�����<font color=red>Ψһ��INIT��ADDģ�������Ʋ�ͬ��һ��</font>��
";










if($_GET['action']=='')			{
	pageHeaderModelInit2($returnDirName,3,300);
}

if($_GET['action']=='Detail')			{

$_GET['sectionName']==""?$_GET['sectionName']="input":'';

print "<form name=form1><table border=1 cellspacing=0 class=small bordercolor=#000000 cellpadding=3 align=left width=450 valign=top style=\"border-collapse:collapse\">";
print "<tr class=TableContent valign=top>\n";
print "<td nowrap align=left valign=top colspan=1 width=25%>\n";

pageHeaderModelInit($returnDirName,1,50);

print "&nbsp;</td>\n";
print "<td align=left valign=top colspan=1 width=75%>\n";


switch($_GET['sectionName'])		{
	case 'input':
	case 'date':
	case 'date1':
	case 'password':
	case 'boolean':
	case 'select_text':
	case 'textarea':
	case 'htmlarea':
	case 'sex':
	case 'select_sex':
	case 'system_datetime':
	case 'hidden_field:1:name':
	case 'hidden_field:1:dept':
	case 'link:view_default':
	case 'link:view_customer':
		default:
		print "<script>
		function SetParentValue()	{
			var parent_window = parent.dialogArguments;\n
			parent_window.form1.".$_GET['parentName'].".value ='".$_GET['sectionName']."';
			//parent.window.form1.".$_GET['parentName'].".value = ".$_GET['sectionName'].";
		}
		function SetParentValue2()	{
			var parent_window = parent.dialogArguments;\n
			parent_window.form1.".$_GET['parentName'].".value ='".$_GET['sectionName']."';
			window.opener =window.self;
			window.close();
		}
		function SetParentValue_UserDefine(ParaUserDefine)	{
			var parent_window = parent.dialogArguments;\n
			parent_window.form1.".$_GET['parentName'].".value = 'userdefine:'+ParaUserDefine;
			window.opener =window.self;
			window.close();
		}
		function SetParentValue_define(ReturnText)	{
			var parent_window = parent.dialogArguments;\n
			parent_window.form1.".$_GET['parentName'].".value = ReturnText;
			window.opener =window.self;
			window.close();
		}
		</script>";
		print "<BR><BR><div align=center><input type=Button class=SmallButton name=inputSelect onclick='SetParentValue();' value='���ȷ��'>&nbsp;<input type=Button class=SmallButton name=inputSelect onclick='SetParentValue2();' value='ȷ�����ر�'></div>";
		break;
	case 'userdefine':
		print "<script>
		function SetParentValue_UserDefine(ParaUserDefine)	{
			var parent_window = parent.dialogArguments;\n
			parent_window.form1.".$_GET['parentName'].".value = 'userdefine:'+ParaUserDefine;
			window.opener =window.self;
			window.close();
		}
		</script>";
		break;
	case 'select_input':
		$filter = 'select_input';
	case 'radiofilter':
		$filter = 'radiofilter';
	case 'tablefilter':
		$filter==""?$filter="tablefilter":"";
		print "<script>
		function LoadSection()	{
			var InputSelectName = \"\";
			InputSelectName = document.form1.inputName.value;
			URL=\"?action=".$_GET['action']."&sectionName=".$_GET['sectionName']."&parentName=".$_GET['parentName']."&Tablename=\"+InputSelectName+\"\";
			location = URL;
		}
		function SetParentValue()	{
			var SelectName = document.form1.SelectName.options[document.form1.SelectName.selectedIndex].value;
			var SelectValue = document.form1.SelectValue.options[document.form1.SelectValue.selectedIndex].value;
			var ReturnText = \"$filter:".$_GET['Tablename'].":\"+SelectValue+\":\"+SelectName;
			//Text.innerHTML = ReturnText;
			var parent_window = parent.dialogArguments;\n
			parent_window.form1.".$_GET['parentName'].".value = ReturnText;
		}
		function SetParentValue2()	{
			var parent_window = parent.dialogArguments;\n
			var SelectName = document.form1.SelectName.options[document.form1.SelectName.selectedIndex].value;
			var SelectValue = document.form1.SelectValue.options[document.form1.SelectValue.selectedIndex].value;
			var ReturnText = \"$filter:".$_GET['Tablename'].":\"+SelectValue+\":\"+SelectName;
			//Text.innerHTML = ReturnText;

			parent_window.form1.".$_GET['parentName'].".value = ReturnText;
			window.opener =window.self;
			window.close();
		}

		</script>";
		print "������Ҫ�����ı�����<input type=text class=SmallInput name=inputName size=15
		onkeydown=\"if(event.keyCode==13) event.keyCode=9\" value='".$_GET['Tablename']."'> <input type=Button class=SmallButton name=inputSelect  onclick='LoadSection();'
		value='ѡ��'>";
		if($_GET['Tablename']!="")			{
			$columns = returntablecolumn($_GET['Tablename']);
			$html_etc=returnsystemlang($_GET['Tablename']);

			print "<BR><BR>�˵���ʾ����";
			print "<select class=\"SmallSelect\" name=\"SelectName\" onkeydown=\"if(event.keyCode==13)event.keyCode=9\" >\n";
			for($i=0;$i<sizeof($columns);$i++)		{
				print "<option value=\"$i\" $temp>".$html_etc[(string)$_GET['Tablename']][(string)$columns[$i]]."[".$columns[$i]."]</option>\n";
				$temp='';
			}
			print "</select>\n";

			print "<BR><BR>�˵���ʾֵ��";
			print "<select class=\"SmallSelect\" name=\"SelectValue\" onkeydown=\"if(event.keyCode==13)event.keyCode=9\" >\n";
			for($i=0;$i<sizeof($columns);$i++)		{
				print "<option value=\"$i\" $temp>".$html_etc[(string)$_GET['Tablename']][(string)$columns[$i]]."[".$columns[$i]."]</option>\n";
				$temp='';
			}
			print "</select>\n";

			print "<BR><BR><div align=center><input type=Button class=SmallButton name=inputSelect onclick='SetParentValue();' value='���ȷ��'>&nbsp;<input type=Button class=SmallButton name=inputSelect onclick='SetParentValue2();' value='ȷ�����ر�'></div>";

		}
		break;
}
print "<div id=Text></div>";
print "<font color=green>˵����".$returnText[$_GET['sectionName']]."\n";
switch($_GET['sectionName'])	{
	case 'link:view_default':
		$imagesname = "LinkViewCustomer";
		break;
	case 'link:view_customer':
		$imagesname = "LinkViewDefault";
		break;
	default:
		$imagesname = $_GET['sectionName'];
		break;
}

$images = "images_frame/".$imagesname.".jpg";
if(is_file($images))		{
	print "<BR><font color=green>����Ϊʾ��˵����</font><BR><img src=\"$images\" border=0></font><BR>";
}
else	{
}
print "&nbsp;</td>\n";
print "</tr>";
print "</table></form>";


}


?>