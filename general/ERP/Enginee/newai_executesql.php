<?php
//���ص�ǰ�û���Ŀ
function returnusernum()			{
	global $db;
	$sql="select count(USER_ID) as num from user";
	$rs=$db->CacheExecute(150,$sql);
	$num=$rs->fields['num'];
	return $num;
}

//###################################################################
//�½���¼����
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
	$common_html['zh']='δע��棬ֻ����ʮ�������û�';
	$common_html2['en']='Not register version, only ten users to permit';
	$common_html2['zh']='���֤Ȩ�����ޣ�����Ҫ�����û������������������ϵ!';

	if(file_exists('license.ini'))		{
		$ini_file=parse_ini_file('license.ini');
		$REGISTER_CODE=$ini_file[REGISTER_CODE];
		$result=machinecode_sunshine_512_2000($ini_file[MACHINE_CODE]);
		if($REGISTER_CODE==$result)		{
			//ע������Ϣ��֤��ȷʱ�������²���
			$returnRegisterExpireUserNumber = returnRegisterExpireUserNumber();
			if($returnRegisterExpireUserNumber!="unlimit")					{
				if($returnusernum>$returnRegisterExpireUserNumber)		{
					print_infor($common_html2[$systemlang],'trip',"location='?action=init_default'");
					exit;
				}
			}
		}
		else			{
			//ע������Ϣ��֤û��ͨ��ʱ�������²���
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
system_log_input("����".$html_etc[$tablename][$tablename],$SQL);
if($result->EOF) return false;
else return true;
}

//###################################################################
//�ж��Ƿ���ڼ�¼����
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
//�ж��Ƿ���ڼ�¼����
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
//�ж��Ƿ���ڼ�¼����
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
//�༭��¼����
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
system_log_input("����".$html_etc[$tablename][$tablename],$SQL);
$primarykey_index=$columns[$primarykey];
$sql="select * from $tablename where $primarykey_index=".$_GET[$primarykey_index];
$showlistfieldlistArray=explode(",", $showlistfieldlist);
$showlistfieldfilterArray=explode(",", $showlistfieldfilter);
$modifycontent="";
for($i=0;$i<sizeof($showlistfieldlistArray);$i++)
{
	$fieldname=$columns[$showlistfieldlistArray[$i]];
	if($_POST[$fieldname]!=$_POST[$fieldname."_ԭʼֵ"] && array_key_exists($fieldname."_ԭʼֵ",$_POST))
	{
		
		$filterArray=explode(":",$showlistfieldfilterArray[$i]);
		
		if($filterArray[0]=='radiofilter' || $filterArray[0]=='tablefiltercolor' || $filterArray[0]=='tablefilter')
		{
			$columns1=returntablecolumn($filterArray[1]);
			$oldvalue=returntablefield($filterArray[1], $columns1[$filterArray[2]], $_POST[$fieldname."_ԭʼֵ"], $columns1[$filterArray[3]]);
			$newvalue=returntablefield($filterArray[1], $columns1[$filterArray[2]], $_POST[$fieldname], $columns1[$filterArray[3]]);
		}
		else 
		{
			$oldvalue=$_POST[$fieldname."_ԭʼֵ"];
			$newvalue=$_POST[$fieldname];
		}
		$modifycontent.= $html_etc[$tablename][$fieldname].":".$oldvalue." ��Ϊ ".$newvalue." ";
	}
}
if($modifycontent!='')
	modify_log_input($modifycontent,$tablename,$primarykey_index,$_GET[$primarykey_index]);
if($result->EOF) return false;
else return true;
}


//###################################################################
//ɾ����¼����
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
//����и�����ɾ������
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
	
//�õ�Ҫɾ���ı�ļ�¼��ֵ;
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
$�ų���¼��־��ҳ�� = array(	"/general/EDU/Interface/EDU/system_log_newai.php",
										"/general/EDU/Interface/CRM/system_log_newai.php",
										"/general/EDU/Interface/JIAOYUJU/system_log_newai.php"
										);
if(	!in_array($_SERVER['SCRIPT_NAME'],$�ų���¼��־��ҳ��)	)			{
	system_log_input("ɾ��".$html_etc[$tablename][$tablename],$SQLTEXT."  <BR>".$SQL);
}

$result=$db->Execute($SQL);

if($result->EOF) return false;
else return true;
}


//###################################################################
//�ж��Ƿ�Ϊ�������ӣ�����ǣ���ϵͳ��ִֹ��
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
	//ϵͳ���ӣ�����ִ�г���
	//print 1;
	//exit;
//}
///else	{
	//�ⲿ���ӣ�����ִ����ֹ
	//print_infor("�Ƿ���������ע��ʹ�÷�����",'trip',"location='?action=init_default'");
	//exit;
//}
}
?>