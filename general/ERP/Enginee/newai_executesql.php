<?php
//返回当前用户数目
function returnusernum()			{
	global $db;
	$sql="select count(USER_ID) as num from user";
	$rs=$db->CacheExecute(150,$sql);
	$num=$rs->fields['num'];
	return $num;
}

//###################################################################
//新建记录函数
//###################################################################
function create_record_newai()	{
global $db,$html_etc;
global $tablename;
global $_POST,$_GET;
global $return_sql_line,$uniquekey;
global $systemlang;

DoReferer();

if(0)				{
	$returnusernum = returnusernum();
	$common_html['en']='Not register version, only ten users to permit';
	$common_html['zh']='未注册版，只能有十个试用用户';
	$common_html2['en']='Not register version, only ten users to permit';
	$common_html2['zh']='许可证权限受限，如需要更多用户数量，请与软件商联系!';

	if(file_exists('license.ini'))		{
		$ini_file=parse_ini_file('license.ini');
		$REGISTER_CODE=$ini_file[REGISTER_CODE];
		$result=machinecode_sunshine_512_2000($ini_file[MACHINE_CODE]);
		if($REGISTER_CODE==$result)		{
			//注册码信息验证正确时进行如下操作
			$returnRegisterExpireUserNumber = returnRegisterExpireUserNumber();
			if($returnRegisterExpireUserNumber!="unlimit")					{
				if($returnusernum>$returnRegisterExpireUserNumber)		{
					print_infor($common_html2[$systemlang],'trip',"location='?action=init_default'");
					exit;
				}
			}
		}
		else			{
			//注册码信息验证没有通过时进行如下操作
			@unlink('license.ini');
			if($returnusernum>=10)		{
				print_infor($common_html[$systemlang],'trip',"location='?action=init_default'");
				exit;
			}
		}
	}
	else		{
			if($returnusernum>=10)		{
				print_infor($common_html[$systemlang],'trip',"location='?action=init_default'");
				exit;
			}
	}


}

if($uniquekey)
	exist_record_newai();
$SQL=$return_sql_line['insert_sql'];

//print "$SQL<BR>";exit;
//print_R($_POST);exit;
$result=$db->Execute($SQL);
global $db,$html_etc,$tablename;
system_log_input("新增".$html_etc[$tablename][$tablename],$SQL);
if($result->EOF) return false;
else return true;
}

//###################################################################
//判断是否存在记录函数
//###################################################################

function returnRegisterExpireUserNumber()					{
	if(is_file("Framework/menu.php"))		{
		$LicenseFileName = "Framework/license.ini";
		$goalfile = "cache/registerExpireDate.php";
	}
	else if(is_file("../Framework/license.ini"))	{
		$LicenseFileName = "../Framework/license.ini";
		$goalfile = "../cache/registerExpireDate.php";
	}
	else	{
		$LicenseFileName = "NoFile";
	}
	return "unlimit";
}


//###################################################################
//判断是否存在记录函数
//###################################################################
function exist_record_newai()	{
global $db,$html_etc,$common_html;
global $_POST,$_GET;global $mark;
global $return_sql_line,$uniquekey;

DoReferer();

$SQL=$return_sql_line['uniquekey_sql_num'];//print "$SQL<BR>";print_R($_POST);exit;
$return="init_".$mark;
$result=$db->Execute($SQL);
if($result->fields[num]>=1)		{
	print_infor($common_html['common_html']['already_exist'],'stop',"location='?action=$return'");
	exit;
}
}

//###################################################################
//判断是否存在记录函数
//###################################################################
function exist_group_user()		{
	global $db,$group_user;
	global $_GET,$_POST,$common_html;
	global $fields;
	global $SUNSHINE_USER_NAME_VAR,$SUNSHINE_USER_ID_VAR,$_SESSION;

	DoReferer();

	$group_user_array=explode(':',$group_user);
	$parent_group=return_parent_group();//print_R($parent_group);
	$tablename=$group_user_array[0];

	switch($parent_group['sql_text']['type'])	{
		case 'group':
			$temp_user_value=$_GET[(string)$parent_group['sql_text']['user']];
			break;
		default:
			$temp_user_value=$_SESSION[$SUNSHINE_USER_NAME_VAR];
			break;
	}

	$sql="select count(".$parent_group['sql_text'][parent].") as num from $tablename where ".$parent_group['sql_text'][parent]."='".$_GET[(string)$parent_group['sql_text'][parent]]."' and ".$parent_group['sql_text'][user]."='".$temp_user_value."'";
	$rs=$db->Execute($sql);	//print $sql;exit;
	if($rs->fields[num]>=1)		{
		print_infor($common_html['common_html']['notnullinfolder'],'trip',"history.back();");
		exit;
	}
	else	{
		delete_array_newai($_GET[(string)$parent_group[parent]],$fields);
	}

}



//###################################################################
//编辑记录函数
//###################################################################
function edit_record_newai()	{
global $db,$html_etc,$tablename;
global $_POST,$_GET;
global $return_sql_line,$isrechecked;
DoReferer();
$SQL=$return_sql_line['update_sql'];
//print $SQL;exit;
//print_R($_POST);exit;
$result=$db->Execute($SQL);
global $db,$html_etc,$tablename,$primarykey,$columns,$showlistfieldlist,$showlistfieldfilter;
system_log_input("更新".$html_etc[$tablename][$tablename],$SQL);
$primarykey_index=$columns[$primarykey];
$sql="select * from $tablename where $primarykey_index=".$_GET[$primarykey_index];
$showlistfieldlistArray=explode(",", $showlistfieldlist);
$showlistfieldfilterArray=explode(",", $showlistfieldfilter);
$modifycontent="";
for($i=0;$i<sizeof($showlistfieldlistArray);$i++)
{
	$fieldname=$columns[$showlistfieldlistArray[$i]];
	if($_POST[$fieldname]!=$_POST[$fieldname."_原始值"] && array_key_exists($fieldname."_原始值",$_POST))
	{
		
		$filterArray=explode(":",$showlistfieldfilterArray[$i]);
		
		if($filterArray[0]=='radiofilter' || $filterArray[0]=='tablefiltercolor' || $filterArray[0]=='tablefilter')
		{
			$columns1=returntablecolumn($filterArray[1]);
			$oldvalue=returntablefield($filterArray[1], $columns1[$filterArray[2]], $_POST[$fieldname."_原始值"], $columns1[$filterArray[3]]);
			$newvalue=returntablefield($filterArray[1], $columns1[$filterArray[2]], $_POST[$fieldname], $columns1[$filterArray[3]]);
		}
		else 
		{
			$oldvalue=$_POST[$fieldname."_原始值"];
			$newvalue=$_POST[$fieldname];
		}
		$modifycontent.= $html_etc[$tablename][$fieldname].":".$oldvalue." 改为 ".$newvalue." ";
	}
}
if($modifycontent!='')
	modify_log_input($modifycontent,$tablename,$primarykey_index,$_GET[$primarykey_index]);
if($result->EOF) return false;
else return true;
}


//###################################################################
//删除记录函数
//###################################################################
function delete_array_newai($element,$fields)	{
global $right_etc,$html_etc,$common_html;
global $_POST,$_GET,$db;
global $primarykey_index;
global $delete_attribute,$delete_attribute;
global $columns,$tablename;
DoReferer();
$_GET[$primarykey_index]=$element;
$return_sql_line=return_sql_line($fields);
if(isset($delete_attribute)&&$delete_attribute!='')		{
	//$delete_attribute_array=explode(':',$delete_attribute);
	//$index_temp=$delete_attribute_array[0];print $index_temp;
	//$fieldvalue=gettablefield($tablename,$primarykey_index,$columns[$index_temp],$element);print $fieldvalue;
	//if($fieldvalue)
	//	$SQL=$return_sql_line['delete_sql'];
	//else
	$SQL=$return_sql_line['update_fixed_field_sql'];
}
else
	$SQL=$return_sql_line['delete_sql'];
//print $SQL;exit;
//如果有附件，删除附件
for($i=0;$i<sizeof($fields['null']);$i++)
{
	if($fields['null'][$i]['inputfilter']=='tdoafile')
	{
			
			$fujianValue=returntablefield($tablename, $primarykey_index, $element,  $fields['name'][$i]);
			$fujianValueArray = explode('||',$fujianValue);
			require_once('lib/utility_file.php');
			delete_attach($fujianValueArray[1],$fujianValueArray[0]);
		
	}
	if($fields['null'][$i]['inputfilter']=='picturefile')
	{
			 
			$fujianValue=returntablefield($tablename, $primarykey_index, $element,  $fields['name'][$i]);
			require_once('lib/utility_file.php');
			delete_single_attach($fujianValue);
		
	}
}
	
//得到要删除的表的记录的值;
$sql = "select * from $tablename where $primarykey_index='$element'";
$rs = $db->Execute($sql);
$rs_a = $rs->GetArray();
$KEYS = @array_keys($rs_a[0]);
$SQLTEXT = '';

for($i=0;$i<sizeof($KEYS);$i++)						{
	$KEY = $KEYS[$i];
	$SQLTEXT .= "$KEY:".$rs_a[0][$KEY]." ";

}
//print_R();
global $db,$html_etc,$tablename;
$排除记录日志的页面 = array(	"/general/EDU/Interface/EDU/system_log_newai.php",
										"/general/EDU/Interface/CRM/system_log_newai.php",
										"/general/EDU/Interface/JIAOYUJU/system_log_newai.php"
										);
if(	!in_array($_SERVER['SCRIPT_NAME'],$排除记录日志的页面)	)			{
	system_log_input("删除".$html_etc[$tablename][$tablename],$SQLTEXT."  <BR>".$SQL);
}

$result=$db->Execute($SQL);

if($result->EOF) return false;
else return true;
}


//###################################################################
//判断是否为外来连接，如果是，则系统禁止执行
//###################################################################
function DoReferer()				{
global $_SERVER;
$HTTP_REFERER = parse_url($_SERVER['HTTP_REFERER']);
$HOSTNAME = $HTTP_REFERER['host'];
//print_r($HTTP_REFERER);
//print_r($HOSTNAME);
//print $_SERVER['SERVER_NAME'];
//exit;
//if($HOSTNAME==$_SERVER['SERVER_NAME']||$HOSTNAME==$_SERVER['SERVER_ADDR'])	{
	//系统连接，可以执行程序
	//print 1;
	//exit;
//}
///else	{
	//外部连接，程序执行中止
	//print_infor("非法操作，请注意使用方法！",'trip',"location='?action=init_default'");
	//exit;
//}
}
?>