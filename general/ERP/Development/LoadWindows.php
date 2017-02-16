<?php

require_once("lib.inc.php");
require_once("class.dir.php");
$dirlist = "../Interface/";
//print_R($_GET);
print "<META http-equiv=Content-Type content='text/html; charset=gb2312'>";
print "<link rel='stylesheet' type='text/css' href='".ROOT_DIR."theme/3/style.css'>";
$common_html=returnsystemlang('common_html');

$FUNC_LINK = "?action=Detail&SYSTEM_MODE=".$_GET['SYSTEM_MODE']."&parentName=".$_GET[parentName]."&sectionName=";

$returnDirName = array( array('FUNC_NAME' => 'Input[输入框]','FUNC_LINK' => "#\" Onclick=\"SetParentValue_close('input');\" title=\"input",'IsColse'=>1),
						array('FUNC_NAME' => 'TableFilter[表过滤]','FUNC_LINK' => $FUNC_LINK."tablefilter"),
						array('FUNC_NAME' => 'RadioFilter[表过滤]','FUNC_LINK' => $FUNC_LINK."radiofilter"),
						//array('FUNC_NAME' => 'SelectInput','FUNC_LINK' => $FUNC_LINK."select_input"),
						//array('FUNC_NAME' => 'SelectTextarea','FUNC_LINK' => $FUNC_LINK."select_text",'IsColse'=>1),
						array('FUNC_NAME' => 'Date[当前日期]','FUNC_LINK' => "#\" Onclick=\"SetParentValue_close('date');\" title=\"date",'IsColse'=>1),
						array('FUNC_NAME' => 'Date1[下月日期]','FUNC_LINK' => "#\" Onclick=\"SetParentValue_close('date1');\" title=\"date1",'IsColse'=>1),
						array('FUNC_NAME' => 'Hidden_User[隐藏用户]','FUNC_LINK' => "#\" Onclick=\"SetParentValue_close('hidden_field:1:name');\" title=\"hidden_field:1:name",'IsColse'=>1),
						array('FUNC_NAME' => 'Hidden_Dept[隐藏部门]','FUNC_LINK' => "#\" Onclick=\"SetParentValue_close('hidden_field:1:dept');\" title=\"hidden_field:1:dept",'IsColse'=>1),
						array('FUNC_NAME' => 'System_Date[系统日期]','FUNC_LINK' => "#\" Onclick=\"SetParentValue_close('system_datetime');\" title=\"system_datetime",'IsColse'=>1),
						array('FUNC_NAME' => 'Textarea[文本框]','FUNC_LINK' => "#\" Onclick=\"SetParentValue_close('textarea');\" title=\"textarea",'IsColse'=>1),
						array('FUNC_NAME' => 'Htmlarea[HTML框]','FUNC_LINK' => "#\" Onclick=\"SetParentValue_close('htmlarea');\" title=\"htmlarea",'IsColse'=>1),
						array('FUNC_NAME' => 'Boolean[01类型]','FUNC_LINK' => "#\" Onclick=\"SetParentValue_close('boolean');\" title=\"boolean"),
						array('FUNC_NAME' => 'edu_boolean[是否类型]','FUNC_LINK' => "#\" Onclick=\"SetParentValue_close('radiofilter:edu_boolean:1:1');\" title=\"radiofilter:edu_boolean:1:1"),
						array('FUNC_NAME' => 'gb_sex[男女性别]','FUNC_LINK' => "#\" Onclick=\"SetParentValue_close('radiofilter:gb_sex:1:1');\" title=\"radiofilter:gb_sex:1:1"),
						array('FUNC_NAME' => 'autoincrement[自动增量]','FUNC_LINK' => "#\" Onclick=\"SetParentValue_close('autoincrement');\" title=\"autoincrement"),
						array('FUNC_NAME' => 'autoincrementdate[时间自动增量]','FUNC_LINK' => "#\" Onclick=\"SetParentValue_close('autoincrementdate');\" title=\"autoincrementdate"),
						array('FUNC_NAME' => 'readonly[只读类型]','FUNC_LINK' => "#\" Onclick=\"SetParentValue_close('readonly');\" title=\"readonly"),
						array('FUNC_NAME' => 'readonlytextarea[文本只读]','FUNC_LINK' => "#\" Onclick=\"SetParentValue_close('readonlytextarea');\" title=\"readonlytextarea"),
						array('FUNC_NAME' => 'singlefile[文件下载]','FUNC_LINK' => "#\" Onclick=\"SetParentValue_close('singlefile');\" title=\"singlefile"),
						array('FUNC_NAME' => 'picturefile[图片文件]','FUNC_LINK' => "#\" Onclick=\"SetParentValue_close('picturefile');\" title=\"picturefile"),
						array('FUNC_NAME' => 'nowshow[字段隐藏]','FUNC_LINK' => "#\" Onclick=\"SetParentValue_close('nowshow');\" title=\"nowshow"),
						array('FUNC_NAME' => 'userdefine[用户自定义]','FUNC_LINK' => '?action=Detail&SYSTEM_MODE='.$_GET['SYSTEM_MODE'].'&parentName='.$_GET[parentName].'&sectionName=userdefine')

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
用以显示<font color=red>自动增量类型</font>的选择<BR>&nbsp;&nbsp;如:100001,100002,100003</font>
";

$returnText['autoincrementdate'] = "
用以显示<font color=red>加入时间日期的自动增量类型</font>的选择<BR>&nbsp;&nbsp;如:2009090001,2009090002,2009090003</font>
";

$returnText['readonly'] = "
用以显示<font color=red>只读类型</font>的选择<BR>&nbsp;&nbsp;</font>
";

$returnText['readonlytextarea'] = "
用以显示<font color=red>TEXTAREA只读类型</font>的选择<BR>&nbsp;&nbsp;</font>
";

$returnText['singlefile'] = "
用以显示<font color=red>文件下载类型</font>的选择<BR>&nbsp;&nbsp;</font>
";

$returnText['picturefile'] = "
用以显示<font color=red>图片文件类型</font>的选择<BR>&nbsp;&nbsp;</font>
";

$returnText['nowshow'] = "
用以显示<font color=red>类似于FORM里面INPUT的HIDDEN属性</font>的选择<BR>&nbsp;&nbsp;设置完以后在需要在页面里的ADD_DATA和EDIT_DATA流程里面手工指定NOTSHOW字段的\$_POST值</font>
";


//用户自定义列表,如果目录下面存在userdefine文件,就会全部列表出来,用于说明
$目标目录 = "../Interface/$SYSTEM_MODE_DIR/userdefine/";
$NewArray = array();
if ($dh = @opendir($目标目录)) {
        while (($file = @readdir($dh)) !== false) {
            $ALLPATH = $目标目录 . $file;
           
			if(@is_file($ALLPATH))		{
				require_once($ALLPATH);
				$fileArray = explode('.',$file);
				$fileprew = $fileArray[0];
				 
				$NewArray[] = "<font color=red>".$file."</font>\n<BR>用途:".$$fileprew."<input type=Button class=SmallButton name=inputSelect onclick='SetParentValue_UserDefine(\"$fileprew\");' value='选择'>\n";

			}
        }
        @closedir($dh);
}

//print_R($_GET);
$NewArrayText = join("<BR>",$NewArray);
$returnText['userdefine'] = "
用以显示<font color=red>用户自定义类型</font>的选择<BR>&nbsp;&nbsp;专门在分类目录下面的userdefine文件夹存放,设置规则参见以前用例.如下:<BR>
$NewArrayText
</font>
";



$returnText['radiofilter:gb_sex:1:1'] = "
用以显示<font color=red>boolean的'男'与'女'类型</font>的选择<BR>&nbsp;&nbsp;是与否用 tablefilter:gb_sex:1:1<BR>&nbsp;&nbsp;0和1用 tablefilter:gb_sex:0:0</font>
";

$returnText['radiofilter:edu_boolean:1:1'] = "
用以显示<font color=red>boolean的'是'与'否'类型</font>的选择<BR>&nbsp;&nbsp;是与否用edu_boolean:1:1<BR>&nbsp;&nbsp;0和1用edu_boolean:0:0</font>
";

$returnText['input'] = "输入框，主要用于
<font color=red>ADD,EDIT,VIEW</font>模型，
在<font color=red>INIT，VIEW</font>模型中数据
<font color=red>直接显示</font>，而不做任何过滤。
以下是常用的TableFilter信息类型:<BR>
<input  style=\"width:330\" type=Button class=SmallButton name=inputSelect onclick=\"SetParentValue_define('tablefiltercolor:edu_xueqiexec:1:1');\" value='tablefiltercolor:edu_xueqiexec:1:1 学期'><BR>
<input  style=\"width:330\" type=Button class=SmallButton name=inputSelect onclick=\"SetParentValue_define('tablefiltercolor:edu_classroom:1:1');\" value='tablefiltercolor:edu_classroom:1:1 教室'><BR>
<input  style=\"width:330\" type=Button class=SmallButton name=inputSelect onclick=\"SetParentValue_define('tablefiltercolor:edu_course:1:1');\" value='tablefiltercolor:edu_course:1:1 课程'><BR>
<input  style=\"width:330\" type=Button class=SmallButton name=inputSelect onclick=\"SetParentValue_define('tablefiltercolor:edu_banji:1:1');\" value='tablefiltercolor:edu_banji:1:1 班级'><BR>
<input  style=\"width:330\" type=Button class=SmallButton name=inputSelect onclick=\"SetParentValue_define('tablefiltercolor:user:1:2');\" value='tablefiltercolor:user:1:2 用户1'><BR>
<input  style=\"width:330\" type=Button class=SmallButton name=inputSelect onclick=\"SetParentValue_define('tablefiltercolor:user:2:2');\" value='tablefiltercolor:user:2:2 用户2'><BR>
<input  style=\"width:330\" type=Button class=SmallButton name=inputSelect onclick=\"SetParentValue_define('tablefiltercolor:department:1:1');\" value='tablefiltercolor:department:1:1 部门'><BR>
<input  style=\"width:330\" type=Button class=SmallButton name=inputSelect onclick=\"SetParentValue_define('tablefiltercolor:edu_xingzheng_banci:1:1');\" value='tablefiltercolor:edu_xingzheng_banci:1:1 行政班次'><BR>
<input  style=\"width:330\" type=Button class=SmallButton name=inputSelect onclick=\"SetParentValue_define('tablefiltercolor:edu_boolean:1:1');\" value='tablefiltercolor:edu_boolean:1:1 是否'><BR>
<input  style=\"width:330\" type=Button class=SmallButton name=inputSelect onclick=\"SetParentValue_define('tablefiltercolor:edu_boolean:0:1');\" value='tablefiltercolor:edu_boolean:0:1 是否01'><BR><BR>
<input  style=\"width:330\" type=Button class=SmallButton name=inputSelect onclick=\"SetParentValue_define('tablefiltercolor:edu_banji:1:1');\" value='tablefiltercolor:edu_zhuanye:2:2 专业'><BR>
<input  style=\"width:330\" type=Button class=SmallButton name=inputSelect onclick=\"SetParentValue_define('tablefiltercolor:edu_banji:1:1');\" value='tablefiltercolor:edu_jiaocai:1:1 教材'><BR>

<input  style=\"width:330\" type=Button class=SmallButton name=inputSelect onclick=\"SetParentValue_define('tdoafile');\" value='tdoafile:通达上传附件格式'><BR>

<input  style=\"width:330\" type=Button class=SmallButton name=inputSelect onclick=\"SetParentValue_define('usertoname');\" value='usertoname:弹出用户选择框[USER_NAME]'><BR>
<input  style=\"width:330\" type=Button class=SmallButton name=inputSelect onclick=\"SetParentValue_define('usertoid');\" value='usertoid:弹出用户选择框[USER_ID]'><BR>
<input  style=\"width:330\" type=Button class=SmallButton name=inputSelect onclick=\"SetParentValue_define('usertonamelist');\" value='usertonamelist:弹出多个用户选择框[USER_NAME]'><BR>

<input  style=\"width:330\" type=Button class=SmallButton name=inputSelect onclick=\"SetParentValue_define('depttoname');\" value='depttoname:弹出部门选择框[DEPT_NAME]'><BR>
<input  style=\"width:330\" type=Button class=SmallButton name=inputSelect onclick=\"SetParentValue_define('depttoid');\" value='depttoid:弹出部门选择框[DEPT_ID]'><BR>

<input  style=\"width:330\" type=Button class=SmallButton name=inputSelect onclick=\"SetParentValue_define('jumpkehu');\" value='jumpkehu:弹出客户单选框'><BR>
<input  style=\"width:330\" type=Button class=SmallButton name=inputSelect onclick=\"SetParentValue_define('jumpkehumulti');\" value='jumpkehumulti:弹出客户多选框'><BR>
<input  style=\"width:330\" type=Button class=SmallButton name=inputSelect onclick=\"SetParentValue_define('jumplinkmanmulti');\" value='jumplinkmanmulti:弹出客户联系人多选框'><BR>
<input  style=\"width:330\" type=Button class=SmallButton name=inputSelect onclick=\"SetParentValue_define('jumpsupplylinkmanmulti');\" value='jumpsupplylinkmanmulti:弹出供应商联系人多选框'><BR>
<input  style=\"width:330\" type=Button class=SmallButton name=inputSelect onclick=\"SetParentValue_define('jumpsupply');\" value='jumpsupply:弹出供应商单选框'><BR>
<input  style=\"width:330\" type=Button class=SmallButton name=inputSelect onclick=\"SetParentValue_define('jumpproducttype');\" value='prodtypetoid:弹出产品类别选择框[PROD_ID]'><BR>
<input  style=\"width:330\" type=Button class=SmallButton name=inputSelect onclick=\"SetParentValue_define('jumpproduct');\" value='producttoid:弹出产品选择框[PROD_ID]'><BR>

<input  style=\"width:330\" type=Button class=SmallButton name=inputSelect onclick=\"SetParentValue_define('jumpcourse');\" value='jumpcourse:弹出所有课程选择框'><BR>
<input  style=\"width:330\" type=Button class=SmallButton name=inputSelect onclick=\"SetParentValue_define('jumpdorm');\" value='jumpdorm:弹出所有宿舍选择框'><BR>
<input  style=\"width:330\" type=Button class=SmallButton name=inputSelect onclick=\"SetParentValue_define('jumpclassroom');\" value='jumpclassroom:弹出所有教室选择框'><BR>
<input  style=\"width:330\" type=Button class=SmallButton name=inputSelect onclick=\"SetParentValue_define('jumpstudentall');\" value='jumpstudentall:弹出所有学生选择框'><BR>
<input  style=\"width:330\" type=Button class=SmallButton name=inputSelect onclick=\"SetParentValue_define('jumpbanji');\" value='jumpbanji:弹出班级选择框'><BR>
<input  style=\"width:330\" type=Button class=SmallButton name=inputSelect onclick=\"SetParentValue_define('jumpjiaocai');\" value='jumpjiaocai:弹出教材选择框'><BR>

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
在<font color=red>INIT，VIEW</font>模型中通过数据表关联，过滤外键值；<BR>
在<font color=red>ADD，EDIT</font>模型中以SELECT下拉菜单形式显示。<BR>
<font color=red>示例：</font><BR>
Tablefilter:Dict_ServicePharse:2:1:New:<BR>satisfaction:Complete:true<BR>
<font color=red>说明：</font><BR>
属性类型::表名::名称字段::关键字段::初始化值::设字段为False::等于其值时::为真True<BR>
其中True属性没有使用到,等于其值时：自动设为真值<BR>
<font color=red>一般情况下只设定：Tablefilter:Dict_ServicePharse:2:1:New，设定到前三个参数</font>，第四个设定<font color=red>初始值</font>，后面三个一般情况不使用。<BR>
";

$returnText['radiofilter'] = "
在<font color=red>INIT，VIEW</font>模型中通过数据表关联，过滤外键值；<BR>
在<font color=red>ADD，EDIT</font>模型中以SELECT下拉菜单形式显示。<BR>
<font color=red>示例：</font><BR>
Radiofilter:Dict_ServicePharse:2:1:New:<BR>satisfaction:Complete:true<BR>
<font color=red>说明：</font><BR>
属性类型::表名::名称字段::关键字段::初始化值::设字段为False::等于其值时::为真True<BR>
其中True属性没有使用到,等于其值时：自动设为真值<BR>
<font color=red>一般情况下只设定：Radiofilter:Dict_ServicePharse:2:1:New，设定到前三个参数</font>，第四个设定<font color=red>初始值</font>，后面三个一般情况不使用。<BR>
";

$returnText['select_input'] = "
在<font color=red>INIT，VIEW</font>模型中通过TableFilter或TableFilterColor属性来<font color=red>取代Select_Input</font>；<BR>
在<font color=red>ADD，EDIT</font>模型中以弹出窗口的形式显示。<BR>
<font color=red>示例：</font><BR>
select_input:Dict_ServicePharse:2:1<BR>
<font color=red>说明：</font><BR>
属性类型::表名::名称字段::关键字段<BR>
";

$returnText['select_text'] = "
此属性主要用来选取用户时使用，它会在左边形成一个菜单栏，显示部门信息，右边是明细栏，显示部门员工的信息，可以多选。
";

$returnText['date'] = "
此属性用来选取<font color=red>日期类型</font>的输入框，有日期类型可以选择，一般默认为<font color=red>系统今天的日期</font>，可以修改其值，默认日期格式<font color=red>2006-06-06</font>
";
$returnText['date1'] = "
此属性用来选取<font color=red>日期类型</font>的输入框，有日期类型可以选择，一般默认为<font color=red>系统下个月的今天</font>，可以修改其值，默认日期格式<font color=red>2006-06-06</font>
";
$returnText['hidden_field:1:name'] = "
此属性用来实现对<font color=red>用户名的隐藏显示</font>，用于<font color=red>确认哪一条记录是哪一位员工建立时用到</font>
";
$returnText['hidden_field:1:dept'] = "
此属性用来实现对<font color=red>部门代码的隐藏显示</font>，用于<font color=red>确认哪一条记录是哪一位员工所在部门时用到</font>
";
$returnText['system_datetime'] = "
此属性用来实现对<font color=red>系统现在时间的隐藏显示</font>，用于<font color=red>确认哪一条记录是什么新建或编辑时用到</font>
";
$returnText['textarea'] = "
此属性用来实现对<font color=red>Textarea输入区域类型</font>实现
";
$returnText['htmlarea'] = "
此属性用来实现对<font color=red>HTML文本编辑器类型</font>实现
";
$returnText['link:view_default'] = "
应用于INIT模型中，主要对当前数据进行<font color=red>超联接形式</font>过滤，转到View视图。
";
$returnText['link:view_customer'] = "
应用于INIT模型中，主要对当前数据进行<font color=red>超联接形式</font>过滤，转到View视图。
";
$returnText['boolean'] = "
用以显示<font color=red>boolean类型</font>的选择，一般情况有两个选项：<font color=red>\"是\"</font>和<font color=red>\"否\"</font>。
";
$returnText['password'] = "
在INIT，VIEW中以<font color=red>\"******\"</font>的形式显示；
在ADD,EDIT模型中以<font color=red>标准密码输入框</font>的形式显示。
附加：密码判断格式为<font color=red>\"不能为纯数字\"</font>

";
$returnText['sex'] = "
在INIT模型中，显示<font color=red>性别下拉菜单</font>，在其它模型(如<font color=red>ADD,EDIT,VIEW</font>模型)中以<font color=red>select_sex</font>的属性存在。这是<font color=red>唯一在INIT和ADD模型中名称不同的一个</font>。
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
		print "<BR><BR><div align=center><input type=Button class=SmallButton name=inputSelect onclick='SetParentValue();' value='点击确定'>&nbsp;<input type=Button class=SmallButton name=inputSelect onclick='SetParentValue2();' value='确定并关闭'></div>";
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
		print "输入需要关连的表名：<input type=text class=SmallInput name=inputName size=15
		onkeydown=\"if(event.keyCode==13) event.keyCode=9\" value='".$_GET['Tablename']."'> <input type=Button class=SmallButton name=inputSelect  onclick='LoadSection();'
		value='选择'>";
		if($_GET['Tablename']!="")			{
			$columns = returntablecolumn($_GET['Tablename']);
			$html_etc=returnsystemlang($_GET['Tablename']);

			print "<BR><BR>菜单显示名：";
			print "<select class=\"SmallSelect\" name=\"SelectName\" onkeydown=\"if(event.keyCode==13)event.keyCode=9\" >\n";
			for($i=0;$i<sizeof($columns);$i++)		{
				print "<option value=\"$i\" $temp>".$html_etc[(string)$_GET['Tablename']][(string)$columns[$i]]."[".$columns[$i]."]</option>\n";
				$temp='';
			}
			print "</select>\n";

			print "<BR><BR>菜单显示值：";
			print "<select class=\"SmallSelect\" name=\"SelectValue\" onkeydown=\"if(event.keyCode==13)event.keyCode=9\" >\n";
			for($i=0;$i<sizeof($columns);$i++)		{
				print "<option value=\"$i\" $temp>".$html_etc[(string)$_GET['Tablename']][(string)$columns[$i]]."[".$columns[$i]."]</option>\n";
				$temp='';
			}
			print "</select>\n";

			print "<BR><BR><div align=center><input type=Button class=SmallButton name=inputSelect onclick='SetParentValue();' value='点击确定'>&nbsp;<input type=Button class=SmallButton name=inputSelect onclick='SetParentValue2();' value='确定并关闭'></div>";

		}
		break;
}
print "<div id=Text></div>";
print "<font color=green>说明：".$returnText[$_GET['sectionName']]."\n";
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
	print "<BR><font color=green>下面为示例说明：</font><BR><img src=\"$images\" border=0></font><BR>";
}
else	{
}
print "&nbsp;</td>\n";
print "</tr>";
print "</table></form>";


}


?>