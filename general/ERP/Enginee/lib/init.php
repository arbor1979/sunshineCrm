<?php
ini_set('date.timezone','Asia/Shanghai');
//########################################################################
//########################################################################
//########################################################################
//判断是否为BASE64编码

$isBase64 = isBase64();		
//print $isBase64;
//进行_GET变量转换
$isBase64==1?CheckBase64():'';

$_GET['pageid']==''?$_GET['pageid']=1:'';

//$MetaTables = $db->MetaTables();
//########################################################################
//########################################################################
//########################################################################

function 是否是汉字($chinese)					{
	$number=ord($chinese);//得到字符的ASCII码
	if($number>=45217&&$number<=55359)		{
		return 0;
	}
	else	{
		return 1;
	}
}

function 优化数据表($tablename)		{
	global $db;
	//$db->OptimizeTable($tablename);
	$sql  = "OPTIMIZE TABLE $tablename";
	$db->Execute($sql);
}

//header("Content-Type:text/html;charset=gbk");
//重新定义窗口大小
function windowsResize($width,$height)	{
	print "<script language=\"JavaScript\">\n";
	print "<!--  将当前窗口缩小为0  -->\n";
	print "self.moveTo(20,20);\n";
	print "<!--  将当前窗口设置为屏幕大小  -->\n";
	print "self.resizeTo($width,$height);\n";
	print "<!--   -->\n";
	print "self.focus();\n";
	print "</script>\n";
}

//返回原值
function returnvalue($value)		{
	return $value;
}
//返回原值BASE64_CODE
function base64_code($value)		{
	return $value;
}
//判断是否为WIN主机
function IsWin()			{
	$WINDIR = $_SERVER['WINDIR'];
	if(strlen($WINDIR)>3)	return 1;
	else	return 0;
}
//删除子表信息数据
function dealDataChildTable($tablename,$fieldname)		{
	global $db,$_GET;
	if($_GET['action']=="delete_array"&&$_GET['selectid']!="")		{
		$selectid = $_GET['selectid'];
		$sql = "delete from $tablename where $fieldname='$selectid'";
		$rs = $db->Execute($sql);
		//exit;
	}
}
//反转函数
if(!function_exists("array_combine"))	{
	function array_combine($array)		{
		$NewArray = array();
		$keys = array_keys($array);
		for($i=0;$i<sizeof($keys);$i++)	{
			$Element	= $keys[$i];
			$Value		= $array[$Element];
			$NewArray[$Value] = $Element;
		}
		return $NewArray;
	}
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
function isBase64($参数='')		{
	
	global $_SERVER;
	//print_R($参数);
	if($参数=='')				{
		$参数 = $_SERVER['QUERY_STRING'];
	}
	
	$QUERY_STRING = $参数;
	$QUERY_STRINGArray = explode('=',$QUERY_STRING);
	
	if(sizeof($QUERY_STRINGArray)>2&&$QUERY_STRINGArray[1]!=""&&$QUERY_STRINGArray[2]!="")		{
			//判断漏加
			$Code = base64_decode($QUERY_STRINGArray[0]);	//print base64_decode($Code);
			$Array = explode('=',$Code);			//print_R($Array);exit;
			if(sizeof($Array)>1)		{
				return 1;
			}
			else
				return 0;
	}
	else	{
			$Code = base64_decode($QUERY_STRING);	//print base64_decode($Code);

			$Array = explode('=',$Code);			//print_R($Array);exit;
			if(sizeof($Array)>1 && $Array[1]!='')		{
				return 1;
			}
			else	{
				return 0;
			}
	}
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
	//print_R($Array);
	//形成新的_GET变量信息
	$NewArray = array();
	for($i=0;$i<sizeof($Array);$i++)		{
		if(isBase64($Array[$i])==1&&$i==0)			{
			$QUERY_STRING2 = base64_decode($Array[$i]);
			//print $QUERY_STRING2;
			$Array2 = explode('&',$QUERY_STRING2);
			//print_R($Array2);
			for($i2=0;$i2<sizeof($Array2);$i2++)		{
				if($Array2[$i2]!="")		{
					$ElementArray = explode('=',$Array2[$i2]);
					$_GET[(String)$ElementArray[0]] = $ElementArray[1];
					$_REQUEST[(String)$ElementArray[0]] = $ElementArray[1];
					$NewArray[(String)$ElementArray[0]] = $ElementArray[0]."=".$ElementArray[1];
				}
			}
		}
		elseif($Array[$i]!="")		{
			$ElementArray = explode('=',$Array[$i]);
			$_GET[(String)$ElementArray[0]] = $ElementArray[1];
			$_REQUEST[(String)$ElementArray[0]] = $ElementArray[1];
			$NewArray[(String)$ElementArray[0]] = $ElementArray[0]."=".$ElementArray[1];
		}
	}
	
	//附加GET变量形成部分
	for($i=1;$i<sizeof($QUERY_STRING_ARRAY);$i++)		{
		if($QUERY_STRING_ARRAY[$i]!="")		{
			$ElementArray = explode('=',$QUERY_STRING_ARRAY[$i]);
			$_GET[(String)$ElementArray[0]] = $ElementArray[1];
			$_REQUEST[(String)$ElementArray[0]] = $ElementArray[1];
			$NewArray[(String)$ElementArray[0]] = $ElementArray[0]."=".$ElementArray[1];
		}
	}
	
	//print_R($NewArray);
	//形成新的_SERVER变量信息
	$_SERVER['QUERY_STRING'] = join('&',@array_values($NewArray));
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
	//print_R($_REQUEST);
	//##################################################################
	//2009-3-23增加在搜索情况下面对分页条件的支持 旧版:$_GET2 = $_GET;
	//##################################################################
	//变量初始化
	$_GET['action'] = $_GET['action'];
	$_GET2 = $_GET;
	
	//附加新的变量值
	if($actionname!="")
		$_GET2[$actionname]=$actionvalue;
	if($actionname2!="")
		$_GET2[$actionname2]=$actionvalue2;
	if($actionname3!="")
		$_GET2[$actionname3]=$actionvalue3;
	if($actionname4!="")
		$_GET2[$actionname4]=$actionvalue4;
	//构成KEY表
	$array_keys = array_keys($_GET2);//print_R($_GET2);
	//过滤，形成新的数组
	for($i=0;$i<sizeof($array_keys);$i++)		{
		if($_GET2[(String)$array_keys[$i]]!=""&&$array_keys[$i]!=$delete)	{
			$urlitem=$_GET2[(String)$array_keys[$i]];
			$urlitem=str_replace("\'","'",$urlitem);
			if(stripos($urlitem,"'")!==false)
				$urlitem=urlencode($urlitem);
			//if($urlitem!='')
				$array_line[$i] = $array_keys[$i]."=".$urlitem;
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
	//print_R($_GET);
	//##################################################################
	//2009-3-23增加在搜索情况下面对分页条件的支持 旧版:$_GET2 = $_GET;
	//##################################################################
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
	//print_R($array_line);
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
	$USER_ID= $GLOBAL_SESSION['SUNSHINE_USER_ID'];
	$SCRIPT_NAME = $_SERVER['SCRIPT_NAME'];
	$SCRIPT_NAME_ARRAY = explode('/',$SCRIPT_NAME);
	$sizeof = sizeof($SCRIPT_NAME_ARRAY);
	//print $USER_PRIV;
	//print_R($SCRIPT_NAME_ARRAY);

	//判断是否要进行身份验证
	$REAL_NAME = $SCRIPT_NAME_ARRAY[$sizeof-1];
	$REAL_NAME == "" ? $REAL_NAME = "REAL_NAME_REAL_NAME":'';
	$sql = "select Count(*) as Number from sys_function where FUNC_LINK like '%$REAL_NAME%'";
	$rs = $db->CacheExecute(150,$sql);
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
	$rs = $db ->CacheExecute(150,$sql);
	$USER_PRIV_ARRAY_TEXT = $rs->GetArray();
	//判断是否存在于权限表中
	$sql = "select FUNC_ID_STR from user where USER_ID='$USER_ID'";
	$rs = $db->CacheExecute(150,$sql);
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
	$USER_PRIV = $_SESSION['SUNSHINE_USER_PRIV'];
	$USER_ID = $_SESSION['SUNSHINE_USER_ID'];
	$SCRIPT_NAME = $_SERVER['SCRIPT_NAME'];
	$SCRIPT_NAME_ARRAY = explode('/',$SCRIPT_NAME);
	$sizeof = sizeof($SCRIPT_NAME_ARRAY);
	//print_R($SCRIPT_NAME_ARRAY);

	//判断是否要进行身份验证
	//$REAL_NAME = $SCRIPT_NAME_ARRAY[$sizeof-1];
	//$REAL_NAME == "" ? $REAL_NAME = "REAL_NAME_REAL_NAME":'';
	//$sql = "select Count(*) as Number from sys_function where FUNC_LINK = '$REAL_NAME'";
	//$rs = $db->CacheExecute(150,$sql);
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
	$rs = $db ->CacheExecute(150,$sql);
	$USER_PRIV_ARRAY_TEXT1 = $rs->GetArray();//print_R($USER_PRIV_ARRAY_TEXT);
	//判断第二种情况
	$sql = "select FUNC_ID from sys_function where FUNC_LINK ='$MiddleName2'";
	$rs = $db ->CacheExecute(150,$sql);
	$USER_PRIV_ARRAY_TEXT2 = $rs->GetArray();//print_R($USER_PRIV_ARRAY_TEXT);
	if(sizeof($USER_PRIV_ARRAY_TEXT1)>=1)
		$USER_PRIV_ARRAY_TEXT = $USER_PRIV_ARRAY_TEXT1;
	else
		$USER_PRIV_ARRAY_TEXT = $USER_PRIV_ARRAY_TEXT2;

	//判断是否存在于权限表中
	$sql = "select FUNC_ID_STR from user where USER_ID='$USER_ID'";
	$rs = $db->CacheExecute(150,$sql);
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
	global $_SESSION,$SUNSHINE_USER_LANG_VAR;
	global $db,$SYSTEM_MODE;
	$databaseType = $db->databaseType;
	//$db_mysql = $db;
	//强制使用MYSQL数据库得到界面语言信息--结束
	//print_R($db);
	if($newtablename!='')		{
		$addtablename!=""?$tablename=$newtablename:'';
	}
	else	{
		$addtablename!=""?$tablename=Substr($addtablename,0,strlen($addtablename)-4):'';
	}
	$addtablename!=""?$tablename=$addtablename:'';//当附加参数存在时使用附加参数
	if($tablename=="") return array();//参数不存时返回一个数组

	//处理系统语言表没有包含的数据表,也用于不愿意初使化时所直接访问数据表-开始
	//global $MetaTables;
	//$MetaTablesArray = array();
	//for($i=0;$i<sizeof($MetaTables);$i++)			{
	//	$MetaTablesArray[] = $MetaTables[$i];
	//}
	global $SYSTEM_TABLE_VISION_MODE;
	//print $SYSTEM_TABLE_VISION_MODE;
	if($SYSTEM_TABLE_VISION_MODE=="1"&&$tablename!="common_html")		{
		$MetaColumns = $db->MetaColumnNames($tablename);
		$MetaColumns = @array_values($MetaColumns);
		for($i=0;$i<sizeof($MetaColumns);$i++)			{
			$fieldname = $MetaColumns[$i];
			$html_temp[$tablename][$fieldname] = $fieldname;
		}
		$html_temp[$tablename]["list".$tablename] = "List ".$tablename;
		$html_temp[$tablename]["view".$tablename] = "View ".$tablename;
		$html_temp[$tablename]["edit".$tablename] = "Edit ".$tablename;
		$html_temp[$tablename]["add".$tablename] = "New ".$tablename;
		$html_temp[$tablename]["search".$tablename] = "Search ".$tablename;
		//print_R($html_temp);
		return $html_temp;
		//exit;
	}
	else	if($SYSTEM_TABLE_VISION_MODE=="1"&&$tablename=="common_html")		{

		$html_temp['common_html']['choose'] = "Choose";
		$html_temp['common_html']['chooseall'] = "Choose All";
		$html_temp['common_html']['add'] = "New";
		$html_temp['common_html']['edit'] = "Edit";
		$html_temp['common_html']['view'] = "View";
		$html_temp['common_html']['delete'] = "Delete";
		$html_temp['common_html']['operation'] = "Operation";
		$html_temp['common_html']['already_exist'] = "Your input information already exists";
		$html_temp['common_html']['return'] = "Return";
		$html_temp['common_html']['submit'] = "Submit";
		$html_temp['common_html']['addsuccess'] = "Add Success";
		$html_temp['common_html']['editsuccess'] = "Edit Success";
		$html_temp['common_html']['deletesuccess'] = "Delete Success";
		$html_temp['common_html']['warning'] = "Warning";
		$html_temp['common_html']['trip'] = "Trip";
		$html_temp['common_html']['totalrecords'] = "Total Records";
		$html_temp['common_html']['indexto'] = "Jump to";
		$html_temp['common_html']['search'] = "Search";
		$html_temp['common_html']['editnull'] = "Edit information cann‘t null";
		$html_temp['common_html']['newnull'] = "New record can‘t null";
		$html_temp['common_html']['browser'] = "Browser";
		$html_temp['common_html']['import'] = "Import";
		$html_temp['common_html']['export'] = "Export";
		$html_temp['common_html']['tableexport'] = "Table Data Export";
		$html_temp['common_html']['contentexport'] = "Content Data Export";
		$html_temp['common_html']['goback'] = "Goback";
		$html_temp['common_html']['yes'] = "Yes";
		$html_temp['common_html']['no'] = "No";
		$html_temp['common_html']['clear'] = "Clear";
		$html_temp['common_html']['close'] = "Close";
		$html_temp['common_html']['shutdown'] = "Shutdown";
		$html_temp['common_html']['female'] = "Female";
		$html_temp['common_html']['male'] = "Female";
		$html_temp['common_html']['print'] = "Print";
		$html_temp['common_html']['selectall'] = "Select ALL";
		$html_temp['common_html']['totalrecords'] = "Total Records";
		$html_temp['common_html']['allrecords'] = "All Records";
		$html_temp['common_html']['cancel'] = "Cancel";
		$html_temp['common_html']['submit'] = "Submit";
		$html_temp['common_html']['save'] = "Save";
		$html_temp['common_html']['new'] = "New";

		//print_R($html_temp);
		return $html_temp;
		//exit;
	}
	//处理系统语言表没有包含的数据表,也用于不愿意初使化时所直接访问数据表-结束

	$sql="select * from systemlang where tablename='$tablename'";
	if($SYSTEM_MODE=="1")		{
		//等于1时,表示系统处于调试阶段,使用间断较小的缓存
		$rs=$db->Execute($sql);
	}
	else	{
		//不等于1时,表示系统处于正常运行阶段,使用间断较大的缓存
		$rs=$db->CacheExecute(150,$sql);
	}

	$rsa=$rs->GetArray();//print_R($rsa);
	foreach($rsa as $list)	{
		$index=$list['tablename'];
		if($databaseType=="oracle"&&$tablename!="common_html")	{
			//ORACLE时所有字段调整为大写
			$fieldname = strtoupper($list['fieldname']);
		}
		else	{
			$fieldname = $list['fieldname'];
		}
		$chinese = $list['chinese'];
		$english = $list['english'];
		$remark  = $list['remark'];
		$html_temp['zh'][$tablename][$fieldname]=$chinese;
		$html_temp['en'][$tablename][$fieldname]=$english;
		$html_temp['zh'][$tablename][$fieldname."_remark"]=$remark;
	}//print_R($_SESSION);exit;
	if($_SESSION[$SUNSHINE_USER_LANG_VAR]=='')	{
		$systemlang='zh';
	}
	else	{
		$systemlang=$_SESSION[$SUNSHINE_USER_LANG_VAR];
	}//print_R($html_temp);
	return $html_temp[$systemlang];
}

//得到表结构数组信息
function returntablecolumn($tablename='department')	{
	global $db;
	//print_R($tablename);
	if($tablename==''||$tablename=='hidden') return array();
	switch($db->databaseType)		{
		case 'mysql':
			$rs=$db->MetaColumnNames($tablename);
			$rs = @array_values($rs);
			break;
		case 'mssql':
			$rs=$db->MetaColumnNames($tablename);
			$rs = @array_values($rs);
			break;
		case 'oracle':
			$rs=$db->MetaColumnNames($tablename);
			$rs = @array_values($rs);
			break;
		default:
			$rs=$db->MetaColumnNames($tablename);
			$rs = @array_values($rs);
			break;
	}
	//print_R($rs);
	return $rs;
}

//得到表结构数组信息-含字段类型信息
function returntablecolumnInfor($tablename='department')	{
	global $db;
	if($tablename==''||$tablename=='hidden') return array();
	$rs=$db->MetaColumns($tablename);
	return $rs;
}

//得到一个表里面某一值的个数
function returnrecordnum($tablename='user',$field='DEPT_ID',$value='1')	{
	global $db;
	$sql="select count($field) as nums from $tablename where $field='$value'";
	$rs=$db->CacheExecute(150,$sql);
	$nums=trim($rs->fields['nums']);
	empty($nums)?$nums=0:'';
	return $nums;
}

function returnrecordsum($tablename='user',$field='DEPT_ID',$value='1',$sumname)	{
	global $db;
	$sql="select sum($sumname) as sums from $tablename where $field='$value'";
	$rs=$db->CacheExecute(150,$sql);
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

function returnsystemprivateconfig($LIST,$FILTER,$NULL,$action_model='',$row_element='',$bottom_element='',$systemorder='',$action_search='')			{
global $_GET,$_POST,$db,$_SESSION;
global $parse_filename,$tablename;
if($parse_filename=="")		$parse_filename = $tablename;
$PHP_SELF_ARRAY = explode('/',$_SERVER['PHP_SELF']);
$FILE_SELF_NAME = array_pop($PHP_SELF_ARRAY);
$FileDirName = array_pop($PHP_SELF_ARRAY);
$是否是接口目录 = array_pop($PHP_SELF_ARRAY);
$action_array = explode('_',$_GET['action']);
if(sizeof($action_array)>=3)	{
	$action = $action_array[0]."_".$action_array[1];
}else	{
	$action = $_GET['action'];
}

$PHP_SELF_ARRAY = explode('/',$_SERVER['PHP_SELF']);
$FILE_SELF_NAME = array_pop($PHP_SELF_ARRAY);
$FileDirName = array_pop($PHP_SELF_ARRAY);
//用于PGSQL下面不进行数据较验
//print $_SESSION['LOGIN_USER_ID'];
if($FileDirName!="PGSQL")				{
	$sql	= "select 字段,其它 from systemprivateconfig
				where 目录='$FileDirName' and 表='$tablename' and 对象='$parse_filename' and 视图='$action'";
	if($_SESSION['LOGIN_USER_ID']!="admin")
		$rs		= $db->CacheExecute(150,$sql);//print_R($rs_select);
	else
		$rs		= $db->Execute($sql);//print_R($rs_select);
	$rs_a	= $rs->GetArray();
	$字段Array	= explode(',',$rs_a[0]['字段']);
}
else	{
	//支持PGSQL
}

//$其它信息 = unserialize($rs_a[0]['其它']);
//print_R($其它信息);

if($rs_a[0]['其它']!="")			{
	$其它信息 = unserialize($rs_a[0]['其它']);
	//print_R($其它信息);
	$NewArrayTEXT['action_model']	= $其它信息['action_model'];
	$NewArrayTEXT['row_element']	= $其它信息['row_element'];
	$NewArrayTEXT['bottom_element']	= $其它信息['bottom_element'];
	$NewArrayTEXT['pagenums_model']	= $其它信息['每页显示记录条数'];
	$NewArrayTEXT['systemorder']	= $其它信息['systemorder'];
	$NewArrayTEXT['action_search']	= $其它信息['action_search'];
	if($其它信息['systemorder']=="")	$NewArrayTEXT['systemorder']	= $systemorder;
	if($其它信息['action_search']=="")	$NewArrayTEXT['action_search']	= $action_search;
}
else		{
	global $pagenums_model;
	if($pagenums_model=='')			$pagenums_model = 25;
	$NewArrayTEXT['pagenums_model']	= $pagenums_model;
	$NewArrayTEXT['action_model']	= $action_model;
	$NewArrayTEXT['row_element']	= $row_element;
	$NewArrayTEXT['bottom_element']	= $bottom_element;
	$NewArrayTEXT['systemorder']	= $systemorder;
	$NewArrayTEXT['action_search']	= $action_search;
}

if($rs_a[0]['字段']!="")			{
	//print $字段;exit;
	//用户自定义序列
	$原装序列Array = explode(',',$LIST);
	$原装序列Array反序 = array_flip($原装序列Array);

	$LISTArray = explode(',',$rs_a[0]['字段']);
	$FILTERArray = explode(',',$FILTER);
	$NULLArray = explode(',',$NULL);
	$NewArray = array();
	for($i=0;$i<sizeof($LISTArray);$i++)			{
		//得到用户自定义序列的值
		$FieldIndex  = $LISTArray[$i];
		//本次判断是重复且绝对判断
		if(in_array($FieldIndex,$字段Array))	{
			//用户自定义类型,得到
			$本次字段在原装序列中的索引位置 = $原装序列Array反序[$FieldIndex];
			$FieldFilter = $FILTERArray[$本次字段在原装序列中的索引位置];
			$NewArray['LIST'][]		= $FieldIndex;
			$NewArray['FILTER'][]	= $FieldFilter;
			$NewArray['NULL'][]		= $NULLArray[$本次字段在原装序列中的索引位置];
		}

	}
	$NewArrayTEXT['LIST']	= join(',',$NewArray['LIST']);;
	$NewArrayTEXT['FILTER'] = join(',',$NewArray['FILTER']);;
	$NewArrayTEXT['NULL']	= join(',',$NewArray['NULL']);;
	$NewArrayTEXT['已配置信息'] = "[本页面已有自定义信息]";
}
else	{
	$NewArrayTEXT['LIST']	= $LIST;
	$NewArrayTEXT['FILTER'] = $FILTER;
	$NewArrayTEXT['NULL']	= $NULL;
}

return $NewArrayTEXT;
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

//普通日志分析//system_log_input();
function system_log_input($LOGINACTION,$SQL)		{
	global $db;
	global $_SESSION;
	global $_GET;
	//print_R($_SERVER);
	//$LOGINACTION
	$DATETIME = date("Y-m-d H:i:s");
	$REMOTE_ADDR = $_SERVER['REMOTE_ADDR'];
	$HTTP_USER_AGENT = $_SERVER['HTTP_USER_AGENT'];
	$QUERY_STRING = $_SERVER['QUERY_STRING'];
	$SCRIPT_NAME = $_SERVER['SCRIPT_NAME'];
	$LOGIN_USER_ID = $_SESSION['LOGIN_USER_ID'];
	if($_GET['USER_ID']!="")				{
			$LOGIN_USER_ID = $_GET['USER_ID'];
	}
	$SQL = ereg_replace("'","&#039;",$SQL);;
	$sql = "insert into system_log(loginaction,DATE,REMOTE_ADDR,HTTP_USER_AGENT,QUERY_STRING,SCRIPT_NAME,USERID,SQLTEXT)
			values('$LOGINACTION','$DATETIME','$REMOTE_ADDR','$HTTP_USER_AGENT','$QUERY_STRING','$SCRIPT_NAME','$LOGIN_USER_ID','$SQL');";
	$db->Execute($sql);
	//print $sql;exit;


}
//修改日志
function modify_log_input($modifycontent,$tablename,$primarykey,$primarykeyvalue)		{
	global $db;
	global $_SESSION;
	global $_GET;
	//print_R($_SERVER);
	//$LOGINACTION
	$DATETIME = date("Y-m-d H:i:s");
	$REMOTE_ADDR = $_SERVER['REMOTE_ADDR'];
	$LOGIN_USER_ID = $_SESSION['LOGIN_USER_ID'];

	$SQL = ereg_replace("'","&#039;",$SQL);;
	$sql = "insert into modifyrecord(tablename,keyfield,keyvalue,createman,modifycontent,createtime,ip)
			values('$tablename','$primarykey','$primarykeyvalue','$LOGIN_USER_ID','$modifycontent','$DATETIME','$REMOTE_ADDR');";
	$db->Execute($sql);

	//print $sql;exit;


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
	$rs=$db->CacheExecute(15,$sql);
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
	if(is_dir("../Interface/EDU")&&!is_dir("../Interface/Teacher")&&!is_dir("../../schooloa"))		{
		$Text = "EDU";
	}
	else if(is_dir("../../Interface/EDU")&&!is_dir("../../Interface/Teacher")&&!is_dir("../../../schooloa"))		{
		$Text = "EDU";
	}
	else if(is_dir("../Interface/EDU")&&is_dir("../Interface/Teacher"))		{
		$Text = "";
	}
	else if(is_dir("../../Interface/EDU")&&is_dir("../../Interface/Teacher"))		{
		$Text = "";
	}
	else if(is_dir("../Interface/CRM"))		{
		$Text = "OACRM";
	}
	else if(is_dir("../Interface/Member"))		{
		$Text = "Member";
	}
	else if(is_dir("../Interface/JXC"))		{
		$Text = "JXC";
	}
	else	{
		$Text = "Text";
	}



	$MACHINE_CODE = $_ENV['PROCESSOR_REVISION'];
	$UNIQUE_ID = $_SERVER['UNIQUE_ID'];
	$disk_total_space = @disk_total_space ('/');

	//加权WIN主机里面虚拟主机的权重
	$IsWin = IsWin();
	if($IsWin)		{
		$DOCUMENT_ROOT = ROOT_DIR;
	}
	else	{
		$DOCUMENT_ROOT = '';
		@exec("ifconfig eth0",$array);
		$UNIQUE_ID = $array[0];
	}

	global $SYSTEM_TYPE;

	//形成机器码最初的变量
    $MACHINE_CODE = $MACHINE_CODE.$disk_total_space.$MACHINE_CODE.$UNIQUE_ID.$Text.$DOCUMENT_ROOT.$SYSTEM_TYPE;
	//如果是金色校园则用另外一套计算方法，即域名绑定
	/*
	if(is_dir("../Teacher")&&is_dir("../Student"))		{
		$BEGIN_WWW = substr($_SERVER['SERVER_NAME'],0,3);
		switch($BEGIN_WWW)			{
			case 'sz0':
			case 'www':
				$MACHINE_CODE = $_SERVER['SERVER_NAME'];
				break;
			default:
				$MACHINE_CODE = "www.".$_SERVER['SERVER_NAME'];
				break;
		}
	}

	if(is_dir("../../Teacher")&&is_dir("../../Student"))		{
		$BEGIN_WWW = substr($_SERVER['SERVER_NAME'],0,3);
		switch($BEGIN_WWW)			{
			case 'sz0':
			case 'www':
				$MACHINE_CODE = $_SERVER['SERVER_NAME'];
				break;
			default:
				$MACHINE_CODE = "www.".$_SERVER['SERVER_NAME'];
				break;
		}
	}
	*/
	//print $MACHINE_CODE;

    $MACHINE_CODE = substr (md5 ($MACHINE_CODE), 1, 12);
    return $MACHINE_CODE;
}
//得到注册码
function machinecode_sunshine_512_2000($code)		{
	global $_SERVER;
	$PHP_SELF_ARRAY = explode('/',$_SERVER['PHP_SELF']);
	array_pop($PHP_SELF_ARRAY);
	array_shift($PHP_SELF_ARRAY);
	//print_R($PHP_SELF_ARRAY);
	if(in_array("TDLIB",$PHP_SELF_ARRAY))		{
		$temp1=substr($code,0,1);
		$temp2=substr($code,1,2);
		$temp3=substr($code,2,3);
		$temp4=substr($code,3,4);
		$temp5=substr($code,4,5);
		$temp6=substr($code,5,6);
		$temp7=substr($code,6,7);
		$temp8=substr($code,7,8);
		$newstring1=md5($temp4.$temp1.$temp2.$temp3);
		$newstring2=md5($temp8.$temp7.$temp5.$temp6);
		$string=substr($newstring1,5,6);//print $string;print "<BR>";
		$string=$string.substr($newstring2,12,6);//print substr($newstring2,4,8);print "<BR>";
	}
	elseif(in_array("ERP",$PHP_SELF_ARRAY))		{
		$temp1=substr($code,0,1);
		$temp2=substr($code,1,2);
		$temp3=substr($code,2,3);
		$temp4=substr($code,3,4);
		$temp5=substr($code,4,5);
		$temp6=substr($code,5,6);
		$temp7=substr($code,6,7);
		$temp8=substr($code,7,8);
		$newstring1=md5($temp4.$temp1.$temp2.$temp3);
		$newstring2=md5($temp8.$temp7.$temp5.$temp6);
		$string=substr($newstring1,16,6);//print $string;print "<BR>";
		$string=$string.substr($newstring2,24,6);//print substr($newstring2,4,8);print "<BR>";
	}
	else	{
		$temp1=substr($code,0,1);
		$temp2=substr($code,1,2);
		$temp3=substr($code,2,3);
		$temp4=substr($code,3,4);
		$temp5=substr($code,4,5);
		$temp6=substr($code,5,6);
		$temp7=substr($code,6,7);
		$temp8=substr($code,7,8);
		$newstring1=md5($temp5.$temp1.$temp2.$temp3);
		$newstring2=md5($temp8.$temp7.$temp4.$temp6);
		$string=substr($newstring1,5,4);//print $string;print "<BR>";
		$string=$string.substr($newstring2,9,4);//print substr($newstring2,4,8);print "<BR>";
	}
	return $string;
}
function readfile_sndg()		{

}

//重新形成注册文件
function MakeResiterFile($MACHINE_CODE,$REGISTER_CODE,$SERVER_NAME,$SCHOOL_NAME,$SOFTWARE_TYPE='',$SOFTWARE_DATE='')		{
	if(is_file("about2.php"))	$filename='license.ini';
	if(is_file("../Framework/about2.php"))	$filename='../Framework/license.ini';
	//print $filename;
	@unlink($filename);
	$somecontent="[section]\nMACHINE_CODE=".$MACHINE_CODE."\nREGISTER_CODE=".$REGISTER_CODE."\nSERVER_NAME=".$SERVER_NAME."\nSCHOOL_NAME=".$SCHOOL_NAME."\nSOFTWARE_TYPE=".$SOFTWARE_TYPE."\nSOFTWARE_DATE=".$SOFTWARE_DATE."\n授权单位=郑州单点科技软件有限公司";
	$handle = fopen($filename, 'w');
	if (!fwrite($handle, $somecontent)) {
	exit;
	}
	fclose($handle);
}

function CheckResiterFile()			{
	if(is_file("inc_banji_page.php"))	$filename='license.ini';
	if(is_file("../Framework/inc_banji_page.php"))	$filename='../Framework/license.ini';
	$returnmachinecode = returnmachinecode();
	$machinecode_sunshine_512_20=machinecode_sunshine_512_20($returnmachinecode);
	@$ini_file=parse_ini_file($filename);
	if($ini_file['REGISTER_CODE']=="")	{
		$ini_file['REGISTER_CODE'] = "试用版本";
		$ini_file['USER_NUMBER'] = "10用户";
		@unlink('license.ini');
	}
	else  if($ini_file['REGISTER_CODE']!=""&&$ini_file['REGISTER_CODE']!=$machinecode_sunshine_512_20)		{
		$ini_file['REGISTER_CODE'] = "试用版本";
		$ini_file['USER_NUMBER'] = "10用户";
		@unlink('license.ini');
	}
	else	{
		$ini_file['USER_NUMBER'] = "无限制";
	}
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



function MakeVisionMode($filetablename)				{
	global $db;
	$MetaColumnNames = $db->MetaColumnNames($filetablename);
	$MetaColumnNames = @array_values($MetaColumnNames);
	for($i=0;$i<sizeof($MetaColumnNames);$i++)			{
		$fieldname = $MetaColumnNames[$i];
		$showlistfieldlistArray[]	= $i;
		$showlistnullArray[]		= "null";
		$showlistfieldfilterArray[] = "input";
	}
	$showlistfieldlist		= join(',',$showlistfieldlistArray);
	$showlistnull			= join(',',$showlistnullArray);
	$showlistfieldfilter	= join(',',$showlistfieldfilterArray);

	$NEWFILE['init_default']['tablename']	=	$filetablename;
	$NEWFILE['init_default']['tabletitle']	=	"list".$filetablename;
	$NEWFILE['init_default']['tablewidth']	=	"100%";
	$NEWFILE['init_default']['nullshow']	=	1;
	$NEWFILE['init_default']['action_model']	=	"add_default:new:n,export_default:export:x,import_default:import:i";;
	$NEWFILE['init_default']['row_element']		=	"view:view_default,edit:edit_default,delete:delete_array";
	$NEWFILE['init_default']['bottom_element']	=	"chooseall:chooseall,delete:delete_array,edit:edit_default";
	$NEWFILE['init_default']['primarykey']	=	0;
	$NEWFILE['init_default']['uniquekey']	=	0;
	$NEWFILE['init_default']['action_search']		=	$showlistfieldlist;
	$NEWFILE['init_default']['showlistfieldlist']	=	$showlistfieldlist;
	$NEWFILE['init_default']['showlistnull']		=	$showlistnull;
	$NEWFILE['init_default']['showlistfieldfilter']	=	$showlistfieldfilter;

	//定义READONLY下面情况
	global $SYSTEM_TABLE_READONLY;
	if($SYSTEM_TABLE_READONLY=="1")				{
		$NEWFILE['init_default']['action_model']	=	"export_default:export:x";;
		$NEWFILE['init_default']['row_element']		=	"view:view_default";
		$NEWFILE['init_default']['bottom_element']	=	"";

	}
	$NEWFILE['add_default']['tablename']	=	$filetablename;
	$NEWFILE['add_default']['tabletitle']	=	"add".$filetablename;
	$NEWFILE['add_default']['action_submit']	=	"submit:save:s,cancel:cancel:c";
	$NEWFILE['add_default']['primarykey']	=	0;
	$NEWFILE['add_default']['uniquekey']	=	0;
	$NEWFILE['add_default']['returnmodel']	=	"init_default";
	$NEWFILE['add_default']['showlistfieldlist']	=	$showlistfieldlist;
	$NEWFILE['add_default']['showlistnull']		=	$showlistnull;
	$NEWFILE['add_default']['showlistfieldfilter']	=	$showlistfieldfilter;


	$NEWFILE['edit_default']['tablename']	=	$filetablename;
	$NEWFILE['edit_default']['tabletitle']	=	"edit".$filetablename;
	$NEWFILE['edit_default']['action_submit']	=	"submit:save:s,cancel:cancel:c";
	$NEWFILE['edit_default']['primarykey']	=	0;
	$NEWFILE['edit_default']['uniquekey']	=	0;
	$NEWFILE['edit_default']['returnmodel']	=	"init_default";
	$NEWFILE['edit_default']['showlistfieldlist']	=	$showlistfieldlist;
	$NEWFILE['edit_default']['showlistnull']		=	$showlistnull;
	$NEWFILE['edit_default']['showlistfieldfilter']	=	$showlistfieldfilter;


	$NEWFILE['view_default']['tablename']	=	$filetablename;
	$NEWFILE['view_default']['tabletitle']	=	"view".$filetablename;
	$NEWFILE['view_default']['action_submit']	=	"cancel:cancel:c,print:print:p,cancel:cancel:c";
	$NEWFILE['view_default']['primarykey']	=	0;
	$NEWFILE['view_default']['uniquekey']	=	0;
	$NEWFILE['view_default']['returnmodel']	=	"init_default";
	$NEWFILE['view_default']['showlistfieldlist']	=	$showlistfieldlist;
	$NEWFILE['view_default']['showlistnull']		=	$showlistnull;
	$NEWFILE['view_default']['showlistfieldfilter']	=	$showlistfieldfilter;


	$NEWFILE['export_default']['tablename']	=	$filetablename;
	$NEWFILE['export_default']['tabletitle']	=	"export".$filetablename;
	$NEWFILE['export_default']['returnmodel']	=	"init_default";
	$NEWFILE['export_default']['primarykey']	=	0;
	$NEWFILE['export_default']['showlistfieldlist']	=	$showlistfieldlist;
	$NEWFILE['export_default']['showlistfieldfilter']	=	$showlistfieldfilter;

	$NEWFILE['import_default']['tablename']	=	$filetablename;
	$NEWFILE['import_default']['tabletitle']	=	"import".$filetablename;
	$NEWFILE['import_default']['returnmodel']	=	"init_default";
	$NEWFILE['import_default']['primarykey']	=	0;
	$NEWFILE['import_default']['showlistfieldlist']	=	$showlistfieldlist;
	$NEWFILE['import_default']['showlistfieldfilter']	=	$showlistfieldfilter;

	$NEWFILE['delete_array']['tablename']	=	$filetablename;
	$NEWFILE['delete_array']['returnmodel']	=	"init_default";
	$NEWFILE['delete_array']['primarykey']	=	0;



	//print_R($MetaColumnNames);exit;
	return $NEWFILE;
}



//软件类型
$PHP_SELF_ARRAY = explode('/',$_SERVER['PHP_SELF']);
array_pop($PHP_SELF_ARRAY);
array_shift($PHP_SELF_ARRAY);
if(in_array("TDLIB",$PHP_SELF_ARRAY))		{
	$SYSTEM_SOFTWARE_NAME = "单点开源CRM";
}
elseif(in_array("ERP",$PHP_SELF_ARRAY))		{
	$SYSTEM_SOFTWARE_NAME = "单点开源CRM";
}
else	{
	$SYSTEM_SOFTWARE_NAME = "通达数字化校园";
}


function 设置变量($MODULE,$CONTENT)			{
	global $db;
	$sql	= "SELECT UNIT_NAME FROM unit limit 0,1";
	$rs   	= $db->CacheExecute(150,$sql);
	$UNIT_NAME = $rs->fields['UNIT_NAME'];

	$sql = "select COUNT(*) AS NUM FROM systemconfig where MODULE='$MODULE'";
	$rs = $db->Execute($sql);
	if($rs->fields['NUM']==0)		{
		$sql = "insert into systemconfig(MODULE,CONTENT,UNIT) values('$MODULE','$CONTENT','$UNIT_NAME');";
	}
	else	{
		$sql = "update systemconfig set CONTENT='$CONTENT',UNIT='$UNIT_NAME' where MODULE='$MODULE'";
	}
	$db->Execute($sql);
}

function 得到变量($MODULE,$FIELDNAME='CONTENT',$Cache=0)					{
	global $db;
	$sql = "select $FIELDNAME FROM systemconfig where MODULE='$MODULE'";
	if($Cache==0)		{
		$rs = $db->Execute($sql);
	}
	else	{
		$rs = $db->CacheExecute($Cache,$sql);
	}
	return $rs->fields[$FIELDNAME];
}

?>