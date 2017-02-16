<?php

function returnsession()			{
	global $db,$_SERVER,$_SESSION,$_COOKIE,$MYSQL_DB_TD_EDU,$MYSQL_DB,$MYOA_SESS_SAVE_HANDLER;

	if($MYOA_SESS_SAVE_HANDLER!="")		{
		//OA2011
	}
	else	{
		session_start();
		if (!headers_sent())
			header("Content-type:text/html;charset=gb2312");
		
	}


	//$ServerInfo = print_r($db->ServerInfo());
	//判断当前版本是2009还是2010
	//Array ( [PHPSESSID] => 593ca32ab7a3343c6f590904bf26d633 [USER_NAME_COOKIE] => admin [SID_1] => 2e0d5357 [UI_COOKIE] => 0 [SID_10] => a76b05df )
	//exit;
	//判断是组件版本还是独立的系统
	//session_register("SYSTEM_IS_TD_OA");
	//session_register("SYSTEM_OA_VERSION");
	$MetaDatabases = $db->MetaDatabases();
	if(in_array("TD_OA",$MetaDatabases))						{
		$_SESSION['SYSTEM_IS_TD_OA']		=	"1";
		//$sql = "select TABLE_NAME from INFORMATION_SCHEMA.TABLES where TABLE_SCHEMA='TD_OA' and TABLE_NAME='session'";
		$sql = "show tables from TD_OA like 'session'";
		$rs = $db->CacheExecute(36000,$sql);
		$rs_a = $rs->GetArray();
		$KEY_SESSION = @array_values($rs_a[0]);
		//print_R($KEY_SESSION);exit;
		//判断OA版本是2010还是2009
		if($KEY_SESSION[0]=="session")							{
			$SYSTEM_PRE_TABLE = "TD_OA.";
			$_SESSION['SYSTEM_OA_VERSION']		=	"TDOA2010";
			//判断具体的版本
			//$sql = "select VER from TD_OA.version limit 1";
			//$rs = $db->CacheExecute(36000,$sql);
			//$VERINFOR = $rs->fields['VER'];
			//$VERINFOR = substr($VERINFOR,4,2);
			//$_SESSION['SYSTEM_OA_VERSION']		=	"TDOA20".$VERINFOR;
			global $MYOA_SESS_SAVE_HANDLER;
			//print $MYOA_SESS_SAVE_HANDLER;
			if($MYOA_SESS_SAVE_HANDLER!="")		{
				$_SESSION['SYSTEM_OA_VERSION']		=	"TDOA2011";
			}
			else	{
				$_SESSION['SYSTEM_OA_VERSION']		=	"TDOA2010";
			}
		}
		else	{
			$SYSTEM_PRE_TABLE = "";
			$_SESSION['SYSTEM_OA_VERSION']		=	"TDOA2009";
		}
	}
	else	{
		$_SESSION['SYSTEM_IS_TD_OA']		=	"0";
		$_SESSION['SYSTEM_OA_VERSION']		=	"";
		$SYSTEM_PRE_TABLE					= 	"";
	}
	
	//print_R($rs_a);
	//强制初始化OA2010版本SESSION
	//$_SESSION['LOGIN_USER_ID']="";

	//判断是教育组件还是CRM组件以及物业组件
	//session_register("SYSTEM_EDU_CRM_WUYE");
	$PHP_SELF_ARRAY = explode('/',$_SERVER['PHP_SELF']);
	array_pop($PHP_SELF_ARRAY);
	array_shift($PHP_SELF_ARRAY);
	//print_R($PHP_SELF_ARRAY);
	if(in_array("TDLIB",$PHP_SELF_ARRAY))		{
		$_SESSION['SYSTEM_EDU_CRM_WUYE']		=	"TDLIB";
	}
	elseif(in_array("EDU",$PHP_SELF_ARRAY))		{
		$_SESSION['SYSTEM_EDU_CRM_WUYE']		=	"EDU";
	}
	elseif(in_array("ERP",$PHP_SELF_ARRAY))		{
		$_SESSION['SYSTEM_EDU_CRM_WUYE']		=	"ERP";
	}
	elseif(in_array("WUYE",$PHP_SELF_ARRAY))		{
		$_SESSION['SYSTEM_EDU_CRM_WUYE']		=	"WUYE";
	}
	else		{
		$_SESSION['SYSTEM_EDU_CRM_WUYE']		=	"NOSETTING";
	}

	//兼容TDOA2011
	if($_SESSION['SYSTEM_OA_VERSION']=="TDOA2010"&&$_COOKIE[',_OA_USER_ID']!="")		{
		$_COOKIE['OA_USER_ID'] = $_COOKIE[',_OA_USER_ID'];
	}

	if(
		(
			$_SESSION['LOGIN_USER_ID']==""||
			($_SESSION['LOGIN_PHPSESSID']!=$_COOKIE['PHPSESSID'])||
			($_COOKIE['OA_USER_ID']!=$_SESSION['LOGIN_USER_ID'])||
			($_COOKIE['USER_NAME_COOKIE']!=$_SESSION['LOGIN_USER_ID'])

		)
		&&$_COOKIE['PHPSESSID']!=""
		&&$_SESSION['SYSTEM_OA_VERSION']=="TDOA2010"
		)		{
		global $SYSTEM_ADD_STRIP;
		//2010版本,重新注册所需要变量
		//session_register("LOGIN_UID");
		//session_register("LOGIN_USER_ID");
		//session_register("LOGIN_DEPT_ID");
		//session_register("LOGIN_USER_PRIV");
		//session_register("LOGIN_THEME");
		//session_register("LOGIN_USER_NAME");
		//session_register("LOGIN_USER_PRIV_OTHER");
		//session_register("LOGIN_PHPSESSID");

		$SYSTEM_PRE_TABLE = "TD_OA.";
		
		
		if($_SESSION['SYSTEM_OA_VERSION']=="TDOA2010")		{
			$sql = "select SESS_DATA from ".$SYSTEM_PRE_TABLE."session where SESS_ID='".$_COOKIE['PHPSESSID']."'";
			$rs = $db->CacheExecute(150,$sql);
			$rs_a = $rs->GetArray();
			$SESS_DATA = $rs_a[0]['SESS_DATA'];
			$SESS_DATA_ARRAY = explode(';',$SESS_DATA);
			for($i=0;$i<sizeof($SESS_DATA_ARRAY);$i++)						{
				$INDEX_NAME_ARRAY	= explode('|',$SESS_DATA_ARRAY[$i]);
				$KEY_NAME			= $INDEX_NAME_ARRAY[0];
				$VALUES_ARRAY		= array();
				$VALUES_ARRAY		= explode(':',$INDEX_NAME_ARRAY[1]);
				//print_R($VALUES_ARRAY);
				$VALUE_NAME			= array_pop($VALUES_ARRAY);
				if(substr($VALUE_NAME,0,1)=='"')				{
					$VALUE_NAME = substr($VALUE_NAME,1,-1);
				}
				if($KEY_NAME!="")				{
					$_SESSION[$KEY_NAME] = $VALUE_NAME;
				}
			}

			if($_SESSION['LOGIN_USER_ID']!="")					{
				$_COOKIE['OA_USER_ID']			= $_SESSION['LOGIN_USER_ID'];
			}
			if($_COOKIE['USER_NAME_COOKIE']!=""&&$_COOKIE['OA_USER_ID']=="")					{
				$_COOKIE['OA_USER_ID']			= $_COOKIE['USER_NAME_COOKIE'];
			}
			if($_SESSION['LOGIN_PHPSESSID']!="")					{
				$_COOKIE['PHPSESSID']			= $_SESSION['LOGIN_PHPSESSID'];
			}
			//print_R($_SESSION);exit;
			$sql = "select * from ".$SYSTEM_PRE_TABLE."user where USER_ID='".$_COOKIE['OA_USER_ID']."'";
			$rs = $db->CacheExecute(150,$sql);
			$rs_a = $rs->GetArray();
			//print_R($sql);exit;
			$_SESSION['LOGIN_UID']		=	$rs_a[0]['UID'];
			$_SESSION['LOGIN_USER_ID']	=	$rs_a[0]['USER_ID'];
			$_SESSION['LOGIN_DEPT_ID']	=	$rs_a[0]['DEPT_ID'];
			$_SESSION['LOGIN_USER_PRIV']=	$rs_a[0]['USER_PRIV'];
			//通达于2011-02-24再次更改SESSION变量的使用规范,真他娘的气人
			if($_SESSION['LOGIN_THEME']=='')									{
				$_SESSION['LOGIN_THEME']	=	$rs_a[0]['THEME'];
			}
			$_SESSION['LOGIN_USER_NAME']=	$rs_a[0]['USER_NAME'];
			$_SESSION['LOGIN_USER_PRIV_OTHER']=	$rs_a[0]['USER_PRIV_OTHER'];
		}
		//print_R($_SESSION);
	}
	else	{
		//2009版本,兼容执行
	}
	//print_R($_COOKIE);print_R($_SESSION);exit;
	//print_R($_SESSION);
	//print_R($_COOKIE);
	//exit;

	//session_register("SUNSHINE_BANJI_LIST");
	//session_register("SUNSHINE_REGISTER_XI");
	//session_register("SUNSHINE_COPY_TIME");
	//session_register("LOGIN_USER_PRIV_OTHER");
	
	if($_SESSION['SUNSHINE_COPY_TIME']=="")	$_SESSION['SUNSHINE_COPY_TIME']=time();

	//$sql = "select USER_PRIV_OTHER from ".$SYSTEM_PRE_TABLE."user where USER_ID='".TRIM($_SESSION['LOGIN_USER_ID'])."'";
	//$rsXX = $db->CacheExecute(15,$sql);
	//$_SESSION['LOGIN_USER_PRIV_OTHER']	= $rsXX->fields['USER_PRIV_OTHER'];


	//print_R($_COOKIE);print_R($_SESSION);exit;
	//显示专业科与系的设置
	/*
	if(is_file(ROOT_DIR."general/EDU/Interface/EDU/SCHOOL_MODEL.ini"))				{
		$SCHOOL_MODEL = parse_ini_file(ROOT_DIR."general/EDU/Interface/EDU/SCHOOL_MODEL.ini");
		$SCHOOL_MODEL_TEXT = TRIM($SCHOOL_MODEL['SCHOOL_MODEL']);
		if($SCHOOL_MODEL_TEXT=="1")			{
			$_SESSION['SUNSHINE_REGISTER_XI'] = "院系";
		}
		else if($SCHOOL_MODEL_TEXT=="2")	{
			$_SESSION['SUNSHINE_REGISTER_XI'] = "专业科";
		}
		else	{
			$_SESSION['SUNSHINE_REGISTER_XI'] = "";
		}
	}//print_R($SCHOOL_MODEL_TEXT);exit;
	*/
	//MYSQL 4 与 5区别的设置
	//$ServerInfo = $db->ServerInfo();
	//$mysql_version = $ServerInfo['version'];
	//$_SESSION['SUNSHINE_MYSQL_VERSION'] = $mysql_version;
	//是否显示错误的SQL
	//$_SESSION['SUNSHINE_TEST_SYSTEM'] = 1;
	/* 2010-10-18 发现此功能影响高级搜索部分的导出功能,且应用受限制,所以进行取消此功能
	//此部分用于验证分管校长权限和专业科科长权限以及专业科副科长权限
	$LOGIN_USER_NAME = $_SESSION['LOGIN_USER_NAME'];
	$sql = "select COUNT(*) AS XIAOQU_NUM from edu_xiaoqu where (
					校长='$LOGIN_USER_NAME' or
					分管校长一='$LOGIN_USER_NAME' or
					分管校长二='$LOGIN_USER_NAME' or
					分管校长三='$LOGIN_USER_NAME' or
					分管校长四='$LOGIN_USER_NAME'
					)";
	//print $sql;
	$rs = $db->CacheExecute(150,$sql);
	$XIAOQU_NUM = $rs->fields['XIAOQU_NUM'];
	$今天时间 = date("Y-m-d");
	if($XIAOQU_NUM>0)			{
		//存在分管校长权限
		$sql = "select 班级名称 from edu_banji where edu_banji.毕业时间>='$今天时间'";
	}
	else		{
		//进行专业科科长权限判断
		$sql = "select distinct edu_banji.班级名称  AS 班级名称
			from edu_banji,edu_zhuanye,edu_xi
			where
			edu_banji.所属系=edu_xi.系代码 and
			edu_banji.所属专业=edu_zhuanye.专业代码 and
			edu_zhuanye.所属系=edu_xi.系代码 and
			edu_banji.毕业时间>='$今天时间' and
			( edu_xi.专业科科长='$LOGIN_USER_NAME' or edu_xi.专业科副科长='$LOGIN_USER_NAME' )
			";
	}
	//print $sql;
	$rs = $db->Execute($sql);
	$rs_a = $rs->GetArray();

	$班级名称_SHOWTEXT = array();
	for($i=0;$i<sizeof($rs_a);$i++)						{
		$班级名称_SHOWTEXT[] .= $rs_a[$i]['班级名称'];
	}
	$_SESSION['SUNSHINE_BANJI_LIST'] = join(',',$班级名称_SHOWTEXT);
	//print_R($班级名称_SHOWTEXT);
	if($_SESSION['SUNSHINE_BANJI_LIST']!="")		{
		if($_GET['班号']=="")		$_GET['班号'] = $_SESSION['SUNSHINE_BANJI_LIST'];
		if($_GET['班级']=="")		$_GET['班级'] = $_SESSION['SUNSHINE_BANJI_LIST'];
		if($_GET['班级名称']=="")	$_GET['班级名称'] = $_SESSION['SUNSHINE_BANJI_LIST'];
		if($_GET['所属班级']=="")	$_GET['所属班级'] = $_SESSION['SUNSHINE_BANJI_LIST'];
		//$_GET['系统说明'] = " 1 看到此变量,表示GET里面的班号,班级,班级名称,所属班级等几个变量,由专业科科长,以及副科长权限时进行生成,所有系统只能有查看权限; 2 同时在INI文件由系统进行对action_model row_element bottom_element等几个变量进行重新定义";
	}
	//print_R($_SESSION);
	*/
	
	$notloginindexpage=ROOT_DIR;
	
	//进行从主数据库中同步数据
	$现在时间线 = time();
	$时间差 = $现在时间线 - $_SESSION['SUNSHINE_COPY_TIME'];
	$时间差CEIL = ceil($时间差/60);
	//print $PHP_SELF_LEFT."<BR>";
	//print $PHP_SELF_BEGIN."<BR>";
	global $SYSTEM_DB_TYPE;


	if($时间差CEIL>10&&$SYSTEM_DB_TYPE=="MYSQL")													{
		$PHP_SELF_ARRAY = explode('/',$_SERVER['PHP_SELF']);
		$PHP_SELF = array_pop($PHP_SELF_ARRAY);
		$PHP_SELF_LEFT = substr($PHP_SELF,-9);
		$PHP_SELF_BEGIN = substr($PHP_SELF,0,4);
		$MetaDatabases = $db->MetaDatabases();
		if($PHP_SELF_LEFT=='_MENU.php'&&$PHP_SELF_BEGIN=='MAIN'&&in_array("TD_OA",$MetaDatabases))		{
			//2011-10-29已经使用视图进行替换现在表的设计方式
			/*
			$sql = "DROP TABLE IF EXISTS `td_edu`.`user`";$db->Execute($sql);
			$sql = "create table `td_edu`.`user` select * from `TD_OA`.`user`";$db->Execute($sql);

			$sql = "DROP TABLE IF EXISTS `td_edu`.`user_priv`";$db->Execute($sql);
			$sql = "create table `td_edu`.`user_priv` select * from `TD_OA`.`user_priv`";$db->Execute($sql);

			$sql = "DROP TABLE IF EXISTS `td_edu`.`department`";$db->Execute($sql);
			$sql = "create table `td_edu`.`department` select * from `TD_OA`.`department`";$db->Execute($sql);

			$sql = "DROP TABLE IF EXISTS `td_edu`.`unit`";$db->Execute($sql);
			$sql = "create table `td_edu`.`unit` select * from `TD_OA`.`unit`";$db->Execute($sql);

			$sql = "DROP TABLE IF EXISTS `td_edu`.`sys_function`";$db->Execute($sql);
			$sql = "create table `td_edu`.`sys_function` select * from `TD_OA`.`sys_function`";$db->Execute($sql);

			$sql = "DROP TABLE IF EXISTS `td_edu`.`sys_menu`";$db->Execute($sql);
			$sql = "create table `td_edu`.`sys_menu` select * from `TD_OA`.`sys_menu`";$db->Execute($sql);
			*/

			//更新标记时间
			$_SESSION['SUNSHINE_COPY_TIME'] = time();

		}

	}

	//print_R($_SESSION);exit;

	//重新初始化变量,应对REGISTER_GLOBALS为OFF时情况
	global $LOGIN_THEME;
	$LOGIN_THEME = $_SESSION['LOGIN_THEME'];
	global $LOGIN_USER_ID;
	$LOGIN_USER_ID = $_SESSION['LOGIN_USER_ID'];
	global $LOGIN_USER_NAME;
	$LOGIN_USER_NAME = $_SESSION['LOGIN_USER_NAME'];
	
	

	if(TRIM($_SESSION['LOGIN_USER_ID'])=="")	{
		echo "<script>if(parent.parent!=null) {parent.parent.location='$notloginindexpage';}else location='$notloginindexpage'</script>\n";
	}
	else	{
		return $GLOBAL_SESSION;
	}
	exit;
}

function returnsession2($key="")		{

}


function returnSessKey()	{
	/*
	global $_SERVER;
	$HTTP_COOKIE=$_SERVER['HTTP_COOKIE'];
	$array=explode(' ',$HTTP_COOKIE);
	for($i=0;$i<sizeof($array);$i++)		{
		$array_element=explode('=',$array[$i]);
		$PHPSESSID[(String)$array_element[0]] = $array_element[1];
	}
	$SESSKEY=$PHPSESSID['PHPSESSID'];
	if(substr($SESSKEY,strlen($SESSKEY)-1,strlen($SESSKEY))==";")	{
			$SESSKEY=substr($SESSKEY,0,strlen($SESSKEY)-1);
	}
	return $SESSKEY;
	*/
}

?>