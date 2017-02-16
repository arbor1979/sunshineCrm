<?php

$PHP_SELF_ARRAY = explode('/',$_SERVER['PHP_SELF']);
$PHP_SELF_FILE = @array_pop($PHP_SELF_ARRAY);
if($PHP_SELF_FILE=="1.php")		{
	//非法执行
	print "非法执行";exit;
}

$EXPORT_DATE = Date("Y-m-d-H-i");

if(is_file("../include.inc.php"))        {
    require_once('../include.inc.php');
    $file = parse_ini_file('../Interface/EDU/SCHOOL_MODEL.ini');
    $SCHOOL_MODEL = $file['SCHOOL_MODEL'];
    if($SCHOOL_MODEL==4)    {
        $sql = "../databackup/sunshine20edu-MS.sql";
    }
    else if($SCHOOL_MODEL==3)    {
        $sql = "../databackup/sunshine20edu-PX.sql";
    }
    else    {
        $sql = "../databackup/sunshine20edu-HS.sql";
    }
}
else if(is_file("general/EDU/include.inc.php"))        {
    require_once('general/EDU/include.inc.php');
    $file = parse_ini_file('general/EDU/Interface/EDU/SCHOOL_MODEL.ini');
    $SCHOOL_MODEL = $file['SCHOOL_MODEL'];
    if($SCHOOL_MODEL==4)    {
        $sql = "general/EDU/databackup/sunshine20edu-MS.sql";
    }
    else if($SCHOOL_MODEL==3)    {
        $sql = "general/EDU/databackup/sunshine20edu-PX.sql";
    }
    else    {
        $sql = "general/EDU/databackup/sunshine20edu-HS.sql";
    }
}
//print_R($_SESSION);
//print_R($sql);exit;
//


//exit;


if(is_file($sql))    {
		global $_SESSION,$db;
		$SUNSHINE_MYSQL_VERSION = $_SESSION['SUNSHINE_MYSQL_VERSION'];
		if($SUNSHINE_MYSQL_VERSION=="")				{
			$ServerInfo = $db->ServerInfo();
			$_SESSION['SUNSHINE_MYSQL_VERSION'] = $ServerInfo['version'];
			$SUNSHINE_MYSQL_VERSION = $_SESSION['SUNSHINE_MYSQL_VERSION'];
		}//得到MYSQL VERSION的值
		if($SUNSHINE_MYSQL_VERSION>='5.0.0')				{
			//MYSQL 4版本,不能执行SET NAMES GBK等操作
			$db->Execute("set names gbk");
		}
        $file = file($sql);
        $fileText = join('',$file);
        $FileArray = explode(';',$fileText);
        //print "<BR>正在执行数据库操作，请稍候...";
        for($i=0;$i<sizeof($FileArray);$i++)        {
			$sql = TRIM($FileArray[$i]);
			if($sql=="SET USER PRIV ALL")		{
				$sql = "select FUNC_ID from TD_OA.sys_function";
				$rs = $db->Execute($sql);
				$rs_a = $rs->GetArray();
				$NewText = '';
				for($iX=0;$iX<sizeof($rs_a);$iX++)		{
					$FUNC_ID = $rs_a[$iX]['FUNC_ID'];
					$NewText .= "$FUNC_ID,";
				}
				$sql = "update TD_OA.user set FUNC_ID_STR='$NewText' where USER_ID='admin'";
				$rs = $db->Execute($sql);
				//print $sql;exit;
			}
			else	{
				//print "<BR>".$sql;
				//print "\n".$i;
				$rs = $db->Execute($FileArray[$i]);
				//print $rs->EOF;
			}
        }
		//exit;

}
else    {
    print $sql."不存在";
}
//exit;

include_once( "inc/utility.php" );
include_once( "inc/conn.php" );
include_once( "inc/update.php" );
include_once( "inc/td_core.php" );
?>