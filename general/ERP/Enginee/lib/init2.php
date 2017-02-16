<?php
ini_set('date.timezone','Asia/Shanghai');
//########################################################################
//########################################################################
//########################################################################
//判断是否为BASE64编码
$isBase64 = isBase64();
//进行_GET变量转换
$isBase64==1?CheckBase64():'';
//########################################################################
//########################################################################
//########################################################################

//反转函数
function array_combine($array)		{
	$NewArray = array();
	$keys = array_keys($array);
	for($i=0;$i<sizeof($keys);$i++)	{
		$Element = $keys[$i];
		$Value = $array[$Element];
		$NewArray[$Value] = $Element;
	}
	return $NewArray;
}

//得到当前相对路径
function returnpath()	{
	global $_SERVER;
	 $PHP_SELF_ARRAY = explode('/',$_SERVER['PHP_SELF']);
	 if($PHP_SELF_ARRAY[sizeof($PHP_SELF_ARRAY)-2] == "Framework")	{
		 $filename = "../";
	 }
	 else	{
		 $filename = "../../";
	 }
	 return $filename;
}

//判断GET变量是否为BASE64编码，不是很科学，需要进一步改进此函数
function isBase64()		{
	global $_SERVER;
	$QUERY_STRING = $_SERVER['QUERY_STRING'];
	$Code = base64_decode($QUERY_STRING);//print base64_decode($Code);
	$Array = explode('=',$Code);
	if(sizeof($Array)>1)		{
		return 1;
	}
	else
		return 0;
}

//重置_GET变量
function CheckBase64()	{
	global $_GET,$_SERVER;
	$QUERY_STRING = $_SERVER['QUERY_STRING'];
	$QUERY_STRING_ARRAY = explode('&',$QUERY_STRING);
	$QUERY_STRING = $QUERY_STRING_ARRAY[0];
	$QUERY_STRING = base64_decode($QUERY_STRING);
	$Array = explode('&',$QUERY_STRING);
	$_GET = array();
	//形成新的_GET变量信息
	$NewArray = array();
	for($i=0;$i<sizeof($Array);$i++)		{
		if($Array[$i]!="")		{
			$ElementArray = explode('=',$Array[$i]);
			$_GET[(String)$ElementArray[0]] = $ElementArray[1];
			$NewArray[$i] = $ElementArray[0]."=".$ElementArray[1];
		}
	}
	//附加GET变量形成部分
	for($i=1;$i<sizeof($QUERY_STRING_ARRAY);$i++)		{
		if($QUERY_STRING_ARRAY[$i]!="")		{
			$ElementArray = explode('=',$QUERY_STRING_ARRAY[$i]);
			$_GET[(String)$ElementArray[0]] = $ElementArray[1];
			$NewArray[$i] = $ElementArray[0]."=".$ElementArray[1];
		}
	}
	//形成新的_SERVER变量信息
	$_SERVER['QUERY_STRING'] = join('&',$NewArray);
	$_SERVER['REQUEST_URI'] = $_SERVER['PHP_SELF']."?".$_SERVER['QUERY_STRING'];
}

//汉字字符切割，可以防止出现半个汉字的情况
function substr_cut($title,$length=8)
{
if (strlen($title)>$length) {
$temp = 0;
for($i=0; $i<$length; $i++)
if (ord($title[$i]) >128) $temp++;
if ($temp%2 == 0)
$title = substr($title,0,$length)."..";
else
$title = substr($title,0,$length+1)."..";
}
return $title;
}

//形成新的_GET字符变量
function FormPageAction($actionname='',$actionvalue='',$actionname2='',$actionvalue2='',$delete='',$actionname3='',$actionvalue3='',$actionname4='',$actionvalue4='')	{
	global $_GET;
	//变量初始化
	$_GET2 = $_GET;
	//附加新的变量值
	
	if($actionname!=""&&$actionvalue!="")
		$_GET2[$actionname]=$actionvalue;
	if($actionname2!=""&&$actionvalue2!="")
		$_GET2[$actionname2]=$actionvalue2;
	if($actionname3!=""&&$actionvalue3!="")
		$_GET2[$actionname3]=$actionvalue3;
	if($actionname4!=""&&$actionvalue4!="")
		$_GET2[$actionname4]=$actionvalue4;
	//构成KEY表
	$array_keys = array_keys($_GET2);//print_R($_GET2);
	//过滤，形成新的数组
	for($i=0;$i<sizeof($array_keys);$i++)		{
		if($_GET2[(String)$array_keys[$i]]!=""&&$array_keys[$i]!=$delete)	{
			$array_line[$i] = $array_keys[$i]."=".$_GET2[(String)$array_keys[$i]];
		}
		else	{
		}
	}
	
	if(sizeof($array_line)>0)
		$newtext = join("&",$array_line);
	
	
	//return $newtext;
	return base64_encode($newtext);
}


//同FormPageAction，不过没有进行BASE64编码
function FormPageAction2($actionname='',$actionvalue='',$actionname2='',$actionvalue2='',$delete='',$actionname3='',$actionvalue3='',$actionname4='',$actionvalue4='')	{
	global $_GET;
	//变量初始化
	$_GET2 = $_GET;
	//附加新的变量值
	if($actionname!=""&&$actionvalue!="")
		$_GET2[$actionname]=$actionvalue;
	if($actionname2!=""&&$actionvalue2!="")
		$_GET2[$actionname2]=$actionvalue2;
	if($actionname3!=""&&$actionvalue3!="")
		$_GET2[$actionname3]=$actionvalue3;
	if($actionname4!=""&&$actionvalue4!="")
		$_GET2[$actionname4]=$actionvalue4;
	//构成KEY表
	$array_keys = array_keys($_GET2);//print_R($_GET2);
	//过滤，形成新的数组
	for($i=0;$i<sizeof($array_keys);$i++)		{
		if($_GET2[(String)$array_keys[$i]]!=""&&$array_keys[$i]!=$delete)	{
			$array_line[$i] = $array_keys[$i]."=".$_GET2[(String)$array_keys[$i]];
		}
		else	{
		}
	}

	if(sizeof($array_line)>0)
		$newtext = join("&",$array_line);
	//print $newtext;exit;
	//return $newtext;
	return $newtext;
}

//返回页面_GET数组，以前用过，后来被FormPageAction函数所取代。
function returnpagearray()					{
	global $_SERVER;
	$init=$_SERVER['QUERY_STRING'];
	$init_array=explode('&',$init);
	for($i=0;$i<sizeof($init_array);$i++)	{
		$init_element_array=explode('=',$init_array[$i]);
		$newarray[(string)$init_element_array[0]]=$init_element_array[1];
	}
	return $newarray;
}//parse_str
//$newarray=returnpagearray();
//$makestring=makestring($newarray);

//由_GET变量得到一个_GET数据转换过来的字符串
function makestring($newarray)						{
	$array_keys=array_keys($newarray);
	$array_values=array_values($newarray);
	for($i=0;$i<sizeof($array_keys);$i++)		{
		$element[$i]=$array_keys[$i]."=".$array_values[$i];
	}
	$string=join('&',$element);
	return $string;
}

//系统权限部分设计，主要思想：先判断用户的USER_PRIV值，然后得到权限字符，根据菜单值到一个权限号，可以根据两个权限值进行判断。
function SYSTEM_PRIV_CONTROL()		{
	global $_SERVER,$db,$GLOBAL_SESSION;
	$PRIV_STATUS = false;
	$USER_PRIV = $GLOBAL_SESSION['SUNSHINE_USER_PRIV'];
	$USER_ID = $GLOBAL_SESSION['SUNSHINE_USER_ID'];
	$SCRIPT_NAME = $_SERVER['SCRIPT_NAME'];
	$SCRIPT_NAME_ARRAY = explode('/',$SCRIPT_NAME);
	$sizeof = sizeof($SCRIPT_NAME_ARRAY);
	//print $USER_PRIV;
	//print_R($SCRIPT_NAME_ARRAY);

	//判断是否要进行身份验证
	$REAL_NAME = $SCRIPT_NAME_ARRAY[$sizeof-1];
	$REAL_NAME == "" ? $REAL_NAME = "REAL_NAME_REAL_NAME":'';
	$sql = "select Count(*) as Number from sys_function where FUNC_LINK like '%$REAL_NAME%'";
	$rs = $db->Execute($sql);
	$Number = $rs->fields['Number'];
	//print $Number;
	if($Number == 0)	{
		$PRIV_STATUS = true;
	}
	else				{
		$MiddleName = @$SCRIPT_NAME_ARRAY[$sizeof-3];
		if($sizeof<2)		{
			$MiddleName = $SCRIPT_NAME_ARRAY[$sizeof-1];
		}
		else if($MiddleName=="Interface")			{
			$MiddleName1 = $SCRIPT_NAME_ARRAY[$sizeof-3];
			$MiddleName2 = $SCRIPT_NAME_ARRAY[$sizeof-2];
			$MiddleName3 = $SCRIPT_NAME_ARRAY[$sizeof-1];
			//文件过滤
			switch($MiddleName3)		{
				case 'worklog_newai.php':
					$MiddleName3 = "worklog_newai.html";
				case 'user_newai.php':
					if($_GET['action']=="listtwo_worklog")	{
						$MiddleName3 = "worklog_newai.html";
					}
					break;
			}
			$MiddleName = "../".$MiddleName1."/".$MiddleName2."/".$MiddleName3;
		}
		else	{
			$MiddleName = $SCRIPT_NAME_ARRAY[$sizeof-1];
		}
		//print $MiddleName;
	//得到已知字符数据
	$sql = "select FUNC_ID from sys_function where FUNC_LINK ='$MiddleName'";
	$rs = $db ->Execute($sql);
	$USER_PRIV_ARRAY_TEXT = $rs->GetArray();
	//判断是否存在于权限表中
	$sql = "select FUNC_ID_STR from user where USER_ID='$USER_ID'";
	$rs = $db->Execute($sql);
	$FUNC_ID_STR = $rs->fields['FUNC_ID_STR'];
	$FUNC_ID_STR_ARRAY = explode(',',$FUNC_ID_STR);
	//验证
	//print_R($FUNC_ID_STR_ARRAY);
	//print_R($USER_PRIV_ARRAY_TEXT);
	for($i=0;$i<sizeof($USER_PRIV_ARRAY_TEXT);$i++)			{
		$USER_PRIV_ID = $USER_PRIV_ARRAY_TEXT[$i]['FUNC_ID'];
		if(in_array($USER_PRIV_ID,$FUNC_ID_STR_ARRAY))		{
			$PRIV_STATUS = true;
		}
	}


	if($PRIV_STATUS)		{
		return true;
	}
	else			{
		print "<div align=center>\n<span style=\"BACKGROUND:#EEEEEE;COLOR:#FF6633;margin: 10px;border:1px dotted #FF6633;font-weight:bold;padding:8px;width=300px\">\n<font color=#FF0000><img src=\"images/attention.gif\" height=20> <b></b></font><hr>权限不足</span></div>\n";
		exit;
	}
	}//end else
}

//SYSTEM_PRIV_CONTROL函数的补充部分
function SYSTEM_PRIV_CONTROL_MYDESKTOP($fileName,$Type="Value")		{
	global $_SERVER,$db,$GLOBAL_SESSION;
	$PRIV_STATUS = false;
	$USER_PRIV = $GLOBAL_SESSION['SUNSHINE_USER_PRIV'];
	$USER_ID = $GLOBAL_SESSION['SUNSHINE_USER_ID'];
	$SCRIPT_NAME = $_SERVER['SCRIPT_NAME'];
	$SCRIPT_NAME_ARRAY = explode('/',$SCRIPT_NAME);
	$sizeof = sizeof($SCRIPT_NAME_ARRAY);
	//print_R($SCRIPT_NAME_ARRAY);

	//判断是否要进行身份验证
	//$REAL_NAME = $SCRIPT_NAME_ARRAY[$sizeof-1];
	//$REAL_NAME == "" ? $REAL_NAME = "REAL_NAME_REAL_NAME":'';
	//$sql = "select Count(*) as Number from sys_function where FUNC_LINK = '$REAL_NAME'";
	//$rs = $db->Execute($sql);
	//$Number = $rs->fields['Number'];print $sql;
	//if($Number > 0)	{
	//	$PRIV_STATUS = true;
	//}
	//else				{
	$MiddleName = $fileName;
	//得到已知字符数据
	$substr = substr($MiddleName,strlen($MiddleName)-1,strlen($MiddleName));
	if($substr == '/')	{
		$MiddleName1 = substr($MiddleName,0,strlen($MiddleName)-1);
		$MiddleName2 = $MiddleName;
	}
	else	{
		$MiddleName1 = $MiddleName;
		$MiddleName2 = $MiddleName."/";
	}

	//判断第一种情况
	$sql = "select FUNC_ID from sys_function where FUNC_LINK ='$MiddleName1'";
	$rs = $db ->Execute($sql);
	$USER_PRIV_ARRAY_TEXT1 = $rs->GetArray();//print_R($USER_PRIV_ARRAY_TEXT);
	//判断第二种情况
	$sql = "select FUNC_ID from sys_function where FUNC_LINK ='$MiddleName2'";
	$rs = $db ->Execute($sql);
	$USER_PRIV_ARRAY_TEXT2 = $rs->GetArray();//print_R($USER_PRIV_ARRAY_TEXT);
	if(sizeof($USER_PRIV_ARRAY_TEXT1)>=1)
		$USER_PRIV_ARRAY_TEXT = $USER_PRIV_ARRAY_TEXT1;
	else
		$USER_PRIV_ARRAY_TEXT = $USER_PRIV_ARRAY_TEXT2;

	//判断是否存在于权限表中
	$sql = "select FUNC_ID_STR from user where USER_ID='$USER_ID'";
	$rs = $db->Execute($sql);
	$FUNC_ID_STR = $rs->fields['FUNC_ID_STR'];
	$FUNC_ID_STR_ARRAY = explode(',',$FUNC_ID_STR);//print_R($sql);
	//验证
	//print_R($FUNC_ID_STR_ARRAY);
	//print_R($USER_PRIV_ARRAY_TEXT);
	for($i=0;$i<sizeof($USER_PRIV_ARRAY_TEXT);$i++)			{
		$USER_PRIV_ID = $USER_PRIV_ARRAY_TEXT[$i]['FUNC_ID'];
		if(in_array($USER_PRIV_ID,$FUNC_ID_STR_ARRAY))		{
			$PRIV_STATUS = true;
		}
	}
	if($Type=="Value")				{
		if($PRIV_STATUS)		{
			return true;
		}
		else			{
			print "<div align=center>\n<span style=\"BACKGROUND:#EEEEEE;COLOR:#FF6633;margin: 10px;border:1px dotted #FF6633;font-weight:bold;padding:8px;width=300px\">\n<font color=#FF0000><img src=\"/Framework/images/attention.gif\" height=20> <b></b></font><hr>权限不足</span></div>\n";
			exit;
		}
	}
	else	{
		return $PRIV_STATUS;
	}
	//}//end else
}

//得到系统界面语言的数组
function returnsystemlang($tablename='department',$addtablename='')	{
	
	global $systemlang,$newtablename;
	global $db,$_SESSION,$SUNSHINE_USER_LANG_VAR;
	
	if($newtablename!='')		{
		$addtablename!=""?$tablename=$newtablename:'';
	}
	else	{
		$addtablename!=""?$tablename=Substr($addtablename,0,strlen($addtablename)-4):'';
	}
	$sql="select * from systemlang where tablename='$tablename'";
	
	$rs=$db->Execute($sql);
	$rsa=$rs->GetArray();
	$addtablename!=""?$tablename=$addtablename:'';
	foreach($rsa as $list)	{
		$index=$list[tablename];
		$fieldname=$list[fieldname];
		$chinese=$list[chinese];
		$english=$list[english];
		$html_temp['zh'][$tablename][$fieldname]=$chinese;
		$html_temp['en'][$tablename][$fieldname]=$english;
	}//print_R($_SESSION);exit;
	if($_SESSION[$SUNSHINE_USER_LANG_VAR]=='')	{
		$systemlang='zh';
	}
	else	{
		$systemlang=$_SESSION[$SUNSHINE_USER_LANG_VAR];
	}
	return $html_temp[$systemlang];
}

//得到表结构数组信息
function returntablecolumn($tablename='department')	{
	global $db;
	$rs=$db->MetaColumnNames($tablename);
	return $rs;
}

//得到一个表里面某一值的个数
function returnrecordnum($tablename='user',$field='DEPT_ID',$value='1')	{
	global $db;
	$sql="select count($field) as nums from $tablename where $field='$value'";
	$rs=$db->Execute($sql);
	$nums=trim($rs->fields['nums']);
	empty($nums)?$nums=0:'';
	return $nums;
}

function returnrecordsum($tablename='user',$field='DEPT_ID',$value='1',$sumname)	{
	global $db;
	$sql="select sum($sumname) as sums from $tablename where $field='$value'";
	$rs=$db->Execute($sql);
	$nums=trim($rs->fields['sums']);
	empty($nums)?$nums=0:'';
	return $nums;
}
//系统允许出现的ACTION值。
function checkreadaction($arg='init_customer')	{
	global $_GET,$_POST;
	switch($_GET['action'])		{
		case 'init_customer':
		case 'view_customer':
		case 'view_default':
		case 'view_inforcard':
		case 'set_default':
		case 'set_system_config':
		case 'export_default':
		case 'set_default_data':
		case 'export_default_data':
		case 'init_customer_data':
		case 'init_customer_search':
		case 'report_default':
			$action=$_GET['action'];
			break;
		default:
			$action='init_customer';
	}
	return $action;
}
//自动加入对HTTP://支持
function checkurl($url)				{
	global $_GET,$_POST;
	$array=explode('://',$url);
	sizeof($array)==2?$index=$url:$index="http://".$url;
	return $index;
}

//支持文件下载URL值
function returnfileurl($id,$name)				{
	global $sessionkey;
	global $_SERVER;
	//判断文件所在路径
	$PHP_SELF_ARRAY = explode('/',$_SERVER['PHP_SELF']);
	$IndexNumber = (String)(sizeof($PHP_SELF_ARRAY)-2);
	$DirNameSelf = $PHP_SELF_ARRAY[$IndexNumber];
	if($DirNameSelf!="Framework")		{
		$DirFilePath="../../Framework/";
	}
	else			{
		$DirFilePath="./";
	}
	//判断结束
	$id_array=explode(',',$id);
	$name_array=explode('*',$name);
		for($i=0;$i<sizeof($id_array);$i++)		{
			if($id_array[$i]!=''&&$name_array[$i]!='')
				$array[$i]="<img src=images/email_atta.gif border=0><a href='".$DirFilePath."download.php?action=download&sessionkey=$sessionkey&attachmentid=".$id_array[$i]."&attachmentname=".urlencode($name_array[$i])."' target=_blank>".$name_array[$i]."</a>";
		}
	if(is_array($array))
		$index=join('<BR>',$array);
	else
		$index=$array[0];
	return $index;
}

function email_read_status($value)				{
	global $common_html;
	switch($value)				{
		case '0':
			$index="<img src=\"images/email_close.gif\" alt=\"收件人未读\">";
			break;
		case '1':
			$index="<img src=\"images/email_close.gif\" alt=\"收件人未读\">";
			break;
	}
}

function returncalendar_dateline($mode='day')	{
global $_GET,$_POST;
if($_GET['dateline']=='')	$_GET['dateline']=time();
switch($mode)	{
	case 'day':
		$dateline_array['begin']=mktime(0,0,0,date('m',$_GET['dateline']),date('d',$_GET['dateline']),date('Y',$_GET['dateline']));
		$dateline_array['end']=mktime(24,0,0,date('m',$_GET['dateline']),date('d',$_GET['dateline']),date('Y',$_GET['dateline']));
		break;
	case 'week':
		$dateline_array['begin']=mktime(0,0,0,date('m',$_GET['dateline']),date('d',$_GET['dateline'])-date('w',$_GET['dateline']),date('Y',$_GET['dateline']));
		$dateline_array['end']=mktime(0,0,0,date('m',$_GET['dateline']),date('d',$_GET['dateline'])-date('w',$_GET['dateline'])+7,date('Y',$_GET['dateline']));
		break;
	case 'month':
		$dateline_array['begin']=mktime(0,0,0,date('m',$_GET['dateline']),1,date('Y',$_GET['dateline']));
		$dateline_array['end']=mktime(24,0,0,date('m',$_GET['dateline']),date('t',$_GET['dateline']),date('Y',$_GET['dateline']));
		break;
	case 'year':
		break;
}
return $dateline_array;
}

function returnsystemsetting($table_name,$table_action,$mode,$value)			{
global $_GET,$_POST,$db;
global $SUNSHINE_USER_NAME_VAR,$SUNSHINE_USER_ID_VAR,$_SESSION;
$USER_ID=$_SESSION[$SUNSHINE_USER_NAME_VAR];
$select_sql="select * from systemsetting where TABLE_NAME='$table_name' and TABLE_ACTION='$table_action'";
//print $select_sql;exit;

$rs_select=$db->Execute($select_sql);//print_R($rs_select);
$rs_a=$rs_select->GetArray();
$temp=$rs_a[0][$mode];
if($temp=='')		return $value;
else	return $temp;
}

//日志记录情况
function logbegin()		{
$tablename='system_log';
global $_SERVER,$_SESSION,$db,$_GET;
global $SUNSHINE_USER_NAME_VAR;
$date=date("Y-m-d H:i:s");
$page_array=explode('/',$_SERVER['SCRIPT_NAME']);
$pagename=array_pop($page_array);
$action_array=explode('_',$_GET[action]);
$_GET['action']=$action_array[0]."_".$action_array[1];
if(($action_array[0]=="add"||$action_array[0]=="edit")&&$action_array[2]=="data")	{
	$doIt = true;
}
else if($action_array[0]=="delete")		{
	$doIt = true;
}
else
	$doIt = false;
if($doIt)	{
		$insert_sql="insert into $tablename values('','$_GET[action]','$date','$_SERVER[REMOTE_ADDR]','$_SERVER[HTTP_USER_AGENT]','$_SERVER[QUERY_STRING]','$pagename','$_SESSION[$SUNSHINE_USER_NAME_VAR]')";
		$rs=$db->Execute($insert_sql);
		$EOF=$rs->EOF;
}
}
//用户权限情况表-编辑
function user_priv_purview()		{
	$purview_string='project:projectid:project_creator:project_controller:project_participator';
	global $_GET,$_SESSION,$SUNSHINE_USER_NAME_VAR;
	global $db;
	$USER_ID=$_SESSION[$SUNSHINE_USER_NAME_VAR];
	$purview_array=explode(':',$purview_string);
	$purview_array_new=$purview_array;
	$tablename_text=array_shift($purview_array_new);
	$newstring=join(',',$purview_array_new);//print $newstring;
	$sql="select $newstring from $tablename_text where ".$purview_array_new[0]."='".$_GET[(string)$purview_array_new[0]]."'";
	$rs=$db->Execute($sql);
	$rsa=$rs->GetArray();//print_R($rsa);//print $USER_ID;exit;
	$creator_array=explode(',',$rsa[0][(string)$purview_array[2]]);
	$controller_array=explode(',',$rsa[0][(string)$purview_array[3]]);
	$participator_array=explode(',',$rsa[0][(string)$purview_array[4]]);
	in_array($USER_ID,$creator_array)?$return='c':$return='n';
	if($return=='c')	return $return;
	in_array($USER_ID,$controller_array)?$return='c':$return='n';
	if($return=='c')	return $return;
	in_array($USER_ID,$participator_array)?$return='p':$return='n';
	if($return=='c')	return $return;
}
function datetimetotimeline($datetime)		{
	$dateline_array=explode(' ',$datetime);
	$date_array=explode('-',$dateline_array[0]);
	$time_array=explode(':',$dateline_array[1]);
	$timeline=mktime($time_array[0],$time_array[1],$time_array[2],$date_array[1],$date_array[2],$date_array[0]);
	return $timeline;
}
//得到机器码
function returnmachinecode()			{

//补充说明
@exec("ipconfig /all",$array);

for($Tmpa;$Tmpa<count($array);$Tmpa++){
    if(eregi("Physical",$array[$Tmpa])){
        $getstr = explode(":",$array[$Tmpa]);
        $mac = trim($getstr[1]);
    }
}

$element=explode('-',$mac);

if(sizeof($element)!=6)			{
	$mac_array=explode(':',$array[13]);
	$mac=trim($mac_array[1]);
	$element=explode('-',$mac);
}
if(sizeof($element)!=6)			{
	$mac_array=explode(':',$array[14]);
	$mac=trim($mac_array[1]);
	$element=explode('-',$mac);
}
if(sizeof($element)!=6)		{
	$element=explode('-',"00-00-00-00-00-00");
}


for($i=0;$i<sizeof($element);$i++)		{
	$temp=$element[$i];
	$temp1=strtolower(substr($temp,0,1));
	$temp1=ord($temp1);
	$temp_num=$temp1+3;
	if($temp_num<=122&&$temp_num>=97)	{
		$temp1=$temp_num;
	}
	else if($temp_num<=57&&$temp_num>=48){
		$temp1=$temp_num;
	}
	else		{
		$temp1=$temp_num-3;
	}
	$temp1=chr($temp1);//print $temp1;

	$temp2=strtolower(substr($temp,1,2));
	$temp2=ord($temp2);
	$temp_num=$temp2+3;
	if($temp_num<=122&&$temp_num>=97)	{
		$temp2=$temp_num;
	}
	else if($temp_num<=57&&$temp_num>=48){
		$temp2=$temp_num;
	}
	else		{
		$temp2=$temp_num-3;
	}

	$temp2=chr($temp2);

	$newarray1[$i]=$temp1;
	$newarray2[$i]=$temp2;
}
//print_R($newarray1);
$string=$newarray1[0].$newarray1[4].$newarray1[3].$newarray1[5].$newarray1[1].$newarray1[2].$newarray2[1].$newarray2[2].$newarray2[5].$newarray2[4].$newarray2[3].$newarray2[0];
return $string;
}
//得到注册码
function machinecode_sunshine_512_20($code)		{
	$temp1=substr($code,0,1);
	$temp2=substr($code,1,2);
	$temp3=substr($code,2,3);
	$temp4=substr($code,3,4);
	$temp5=substr($code,4,5);
	$temp6=substr($code,5,6);
	$temp7=substr($code,6,7);
	$temp8=substr($code,7,8);
	$newstring1=md5($temp8.$temp1.$temp7.$temp3);
	$newstring2=md5($temp5.$temp2.$temp4.$temp6);
	$string=substr($newstring1,0,6);//print $string;print "<BR>";
	$string=$string.substr($newstring2,0,6);//print substr($newstring2,4,8);print "<BR>";
	return $string;
}
function readfile_sndg()		{

}



function write_newaifile_2($filename,$content,$mode=0)					{

if($mode==0)								{
if (!file_exists($filename)) {
    if (!$handle = fopen($filename, 'a+')) {
         print "不能打开文件 $filename";
         exit;
    }
    if (!fwrite($handle, $content)) {
        print "不能写入到文件 $filename";
        exit;
    }
    //print "<font color=green>成功地将 $somecontent 写入到文件$filename</font><BR>";
    fclose($handle);
} else {
    //print "<font color=red>文件 $filename 已经存在</font><BR>";
}

}
else			{
	if (file_exists($filename))			unlink($filename);
	if (!$handle = fopen($filename, 'a+')) {
         print "不能打开文件 $filename";
         exit;
    }
    if (!fwrite($handle, $content)) {
        print "不能写入到文件 $filename";
        exit;
    }
    //print "<font color=green>成功地将 $somecontent 写入到文件$filename</font><BR>";
    fclose($handle);
}

}



function create_chart($chartName,$xmlFile,$width="800",$height="400") {
	$html ='<OBJECT classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000"
		codebase="https://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,0,0"
		WIDTH="'.$width.'" HEIGHT="'.$height.'" id="'.$chartName.'" ALIGN="CENTER">';
	$html .='<PARAM NAME=movie VALUE="../../Enginee/charts/'.$chartName.'.swf?filename='.$xmlFile.'">';
	$html .='<PARAM NAME=bgcolor VALUE=#FFFFFF>';
	$html .='<PARAM NAME=wmode VALUE=transparent>';
	$html .= '<PARAM NAME=quality VALUE=high>';
	$html .='<EMBED src="../../Enginee/charts/'.$chartName.'.swf?filename='.$xmlFile.'" wmode="transparent" quality=high bgcolor=#FFFFFF  WIDTH="'.$width.'" HEIGHT="'.$height.'" NAME="'.$chartName.'" ALIGN=""
		TYPE="application/x-shockwave-flash" PLUGINSPAGE="https://www.macromedia.com/go/getflashplayer">';
	$html .='</EMBED>';
	$html .='</OBJECT>';
return $html;
}


?>