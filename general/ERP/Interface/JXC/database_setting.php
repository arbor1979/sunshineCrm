<?php

//######################教育组件-权限较验部分##########################
SESSION_START();
require_once("lib.inc.php");
$GLOBAL_SESSION=returnsession();
require_once("systemprivateinc.php");
CheckSystemPrivate("系统信息设置-数据库管理");
//######################教育组件-权限较验部分##########################

require_once('lib.inc.php');
require_once('lib.zip.inc.php');

$GLOBAL_SESSION=returnsession();

page_css("单点CRM系统");
$connection = OpenConnection2();


$PrivateTableArray = array("sessions2","systemtable","systemhelp","systemsetting","systemprivate","systemlang","systemprivateinc");
$PrivateTableArray2 = array("wygl","dict","edu","gb","school","asset","dorm","paikao","tiku","keyan","bukao","newedu","officeproduct","fixedasset","hrms","system","remote","tiku");

$PrivateTableArray3 = array("officeproduct","fixedasset");

//$PrivateTableArray3 = array("officeproduct","fixedasset");
$NewTableArray = array();




if($_GET['action']=='')							{
?>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<table border="0" width="70%" align=center cellspacing="0" cellpadding="3" class="TableBlock">
  <tr  class=TableHeader>
    <td colspan="12" height=28>&nbsp;<img src="<?php echo ROOT_DIR?>images/sys_config.gif" align="absmiddle" > 单点CRM系统安装与删除管理(以下操作建议在软件开发商指导下进行)</td>
  </tr>

 <tr class="TableData">
 <td colspan="6" align=center height=32>
    <input type="button"  value="CRM系统数据库备份" class="BigButton" onClick="javascript:if(confirm('你真的要进行此项操作么?'))location='?<?php echo base64_encode("action=Backup");?>'" title="数据库备份">
 </td>
 <td colspan="6" align=left width=80%><font color=green>备份CRM系统相关数据库文件,不含OA相关数据</font></td>
</tr>

 <tr class="TableData">
 <td colspan="6" align=center height=32>
    <input type="button"  value="CRM系统数据库清空" class="BigButton" onClick="javascript:if(confirm('你真的要进行此项操作么?'))location='?<?php echo base64_encode("action=DeleteTdEdu");?>'" title="数据库删除">
 </td>
 <td colspan="6" align=left width=80%><B><font color=red>清空CRM系统中的单据，包括采购、库存、出入库、销售、收款等，保留客户、联系人、产品库等基本资料!</font></B></td>
</tr>



<tr class="TableData">
 <td colspan="6" align=center height=32>
    <input type="button"  value="查看数据库操作日志" class="BigButton" onClick="location='system_log_newai.php'" title="查看数据库操作日志">
 </td>
 <td colspan="6" align=left width=80%>查看数据库操作日志</td>
</tr>

<tr class="TableData">
 <td colspan="6" align=center height=32>
    <input type="button"  value="监控MYSQL运行性能" class="BigButton" onClick="location='system_logall_view.php'" title="监控MYSQL运行性能">
 </td>
 <td colspan="6" align=left width=80%>监控MYSQL运行性能</td>
</tr>

<tr class="TableData">
 <td colspan="6" align=center height=32>
    <input type="button"  value="用户自主配置软件信息" class="BigButton" onClick="location='systemprivateconfig_newai.php'" title="用户自主配置软件信息">
 </td>
 <td colspan="6" align=left width=80%>用户自主配置软件信息</td>
</tr>



<?php
if(!@is_file('is_running.ini')&&$_SESSION['LOGIN_USER_ID']=='admin'&&0)		{
	print "<tr class='TableData'>
		 <td colspan='6' align=center height=32>
			<input type='button'  value='删除当前系统测试数据' class='BigButton' onClick=\"javascript:if(confirm('使用本操作后系统会变成一个干净的系统,但只能使用一次,您是否确定要删除当前系统测试数据?'))location='?".base64_encode("action=DeleteTestData")."'\" title='删除当前系统测试数据'>
		 </td>
		 <td colspan='6' align=left width=80%><font color=red>删除当前系统测试数据(此功能只能用一次,谨慎使用!)</font></td>
		</tr>";
}

//表示TD_OA.USER表存在
$MetaDatabases = $db->MetaDatabases();
if(in_array("TD_OA",$MetaDatabases))				{



	$sql = "ALTER TABLE `td_crm`.`user` ADD PRIMARY KEY ( `UID` ) ;";$db->Execute($sql);
	$sql = "ALTER TABLE `td_crm`.`user` CHANGE `UID` `UID` INT( 11 ) NOT NULL AUTO_INCREMENT ;";$db->Execute($sql);

	$sql = "DROP TABLE IF EXISTS `td_crm`.`user`";$db->Execute($sql);
	$sql = "create table `td_crm`.`user` select * from `TD_OA`.`user`";$db->Execute($sql);

	$sql = "DROP TABLE IF EXISTS `td_crm`.`user_priv`";$db->Execute($sql);
	$sql = "create table `td_crm`.`user_priv` select * from `TD_OA`.`user_priv`";$db->Execute($sql);

	$sql = "DROP TABLE IF EXISTS `td_crm`.`department`";$db->Execute($sql);
	$sql = "create table `td_crm`.`department` select * from `TD_OA`.`department`";$db->Execute($sql);

	$sql = "DROP TABLE IF EXISTS `td_crm`.`unit`";$db->Execute($sql);
	$sql = "create table `td_crm`.`unit` select * from `TD_OA`.`unit`";$db->Execute($sql);

	$sql = "DROP TABLE IF EXISTS `td_crm`.`sys_function`";$db->Execute($sql);
	$sql = "create table `td_crm`.`sys_function` select * from `TD_OA`.`sys_function`";$db->Execute($sql);

	$sql = "DROP TABLE IF EXISTS `td_crm`.`interface`";$db->Execute($sql);
	$sql = "create table `td_crm`.`interface` select * from `TD_OA`.`interface`";$db->Execute($sql);

	$sql = "DROP TABLE IF EXISTS `td_crm`.`sys_menu`";$db->Execute($sql);
	$sql = "create table `td_crm`.`sys_menu` select * from `TD_OA`.`sys_menu`";$db->Execute($sql);
	print "<tr class=\"TableData\">
		<td colspan=\"12\" align=left width=80%>&nbsp;<font color=gray>系统已完成数据同步工作</font></td></tr>";

	//自动清除七天以前的历史记录
	$sql = "delete from system_logall where datediff(now(),当前时间)>7";
	$db->Execute($sql);

	//自动清空上传文件缓存目录
	include_once("ClearFileCache.php");



	$sql = "ALTER TABLE `user_priv` ADD PRIMARY KEY ( `USER_PRIV` ) ";										$db->Execute($sql);
	$sql = "ALTER TABLE `user_priv` CHANGE `USER_PRIV` `USER_PRIV` INT( 11 ) NOT NULL AUTO_INCREMENT ";		$db->Execute($sql);
	$sql = "ALTER TABLE `department` ADD PRIMARY KEY ( `DEPT_ID` ) ";										$db->Execute($sql);
	$sql = "ALTER TABLE `department` CHANGE `DEPT_ID` `DEPT_ID` INT( 11 ) NOT NULL AUTO_INCREMENT ";		$db->Execute($sql);
	$sql = "ALTER TABLE `user` ADD PRIMARY KEY ( `UID` ) ";													$db->Execute($sql);
	$sql = "ALTER TABLE `user` CHANGE `UID` `UID` INT( 11 ) NOT NULL AUTO_INCREMENT ";						$db->Execute($sql);


}

print "</table><BR>";

}


//制作增加表步骤 1 在本文件增加要备份的数据表 2 在remote_zip_datadeal文件两个地方分别增加涉及的数据表



if($_GET['action']=="MakeChengXinDangAn")								{
//#################################################################################
	$EXPORT_DATE = Date("Y-m-d-H-i");
	$PureSQLFile = "JIAOYUJU-".$EXPORT_DATE.".sql";
	$filename = "FileCache/".$PureSQLFile;

	if(1)											{

		!$handle = fopen($filename, 'w');
		MakeBackupTableData("unit");
		MakeBackupTableData("edu_schoolbaseinfor");
		MakeBackupTableData("edu_xiaoqu");
		MakeBackupTableData("edu_schoolmainasset");
		MakeBackupTableData("edu_schooldeptteacher");
		MakeBackupTableData("edu_schoolbanxueinfor");
		MakeBackupTableData("edu_xi");
		MakeBackupTableData("edu_zhuanye");
		MakeBackupTableData("edu_banji");
		MakeBackupTableData("edu_student");
		MakeBackupTableData("edu_teacher");

		MakeBackupTableData("edu_course");
		MakeBackupTableData("edu_jiaocai");
		MakeBackupTableData("edu_jiaocaiplan");
		MakeBackupTableData("edu_shixi");
		MakeBackupTableData("edu_jiangxuejin");
		MakeBackupTableData("edu_studentjiuye");
		MakeBackupTableData("edu_studentchange");
		MakeBackupTableData("edu_studentflow");
		MakeBackupTableData("edu_zhengshuguanli");

		fclose($handle);




		//压缩SQL文件为ZIP文件
		$zip = new Zip;
		$zipfile=$filename.".zip";
		$filesize=@filesize($filename);
		$fp=@fopen($filename,rb);
		$zipfiles[]=Array($PureSQLFile,@fread($fp,$filesize));
		@fclose($fp);
		$zip->Add($zipfiles,1);
		if(@fputs(@fopen($zipfile,"wb"), $zip->get_file()))	{
			$filename = $zipfile;
		};


		$filesize = @filesize($zipfile);


		/*
		//读ZIP文件
		$URL = "http://localhost/general/EDU/Interface/EDU/FileCache/JIAOYUJU-2009-08-11-16-44.sql.zip";
		$ZipContent = readFileRemote($URL);//exit;

		//写入远程文件
		$TEMPFILE = file("config_remote_zip.ini");
		$TEMPFILE = $TEMPFILE[0];
		$ZipContent = base64_encode($ZipContent);
		$REMOTE_URL_PARSE = $TEMPFILE."/general/EDU/Interface/EDU/remote_zip.php?文件名称=".$PureSQLFile.".zip&学校名称=$学校名称&文件内容=$ZipContent";
		print $REMOTE_URL_PARSE;
		file($REMOTE_URL_PARSE);
		*/
		$操作人员联系方式 = returntablefield("user","USER_NAME",$_SESSION['LOGIN_USER_NAME'],"MOBIL_NO");

		$TEMPFILE = file("config_remote_zip.ini");
		$TEMPFILE = $TEMPFILE[0];
		$REMOTE_URL_PARSE = $TEMPFILE."/general/EDU/Interface/JIAOYUJU/remote_zip_datadeal.php";

		$filesize = ceil($filesize/1024);
		$SCRIPT_FILENAME_ARRAY = explode('/',$_SERVER['SCRIPT_FILENAME']);
		array_pop($SCRIPT_FILENAME_ARRAY);
		array_push($SCRIPT_FILENAME_ARRAY,"FileCache");
		array_push($SCRIPT_FILENAME_ARRAY,$PureSQLFile.".zip");
		//print_R($SCRIPT_FILENAME_ARRAY);
		$PureSQLFileZIP = $PureSQLFile.".zip";
		$NewZipFileName = join('/',$SCRIPT_FILENAME_ARRAY);
		print "<BR>";
		table_begin('70%');
		print  "
		<tr class=\"TableData\">
		<td colspan=\"12\"  align=center>学校相关数据生成成功,点击上传到教育局服务器<BR>传输过程可能会需要几秒时间,请稍等待(文件大小:".$filesize."K)<BR>&nbsp;&nbsp;
		<a href=\"remote_zip.php?".base64_encode("单个文件名称=$PureSQLFileZIP&文件名称=$NewZipFileName&目标地址=$REMOTE_URL_PARSE&提交学校地址=".$_SERVER['SERVER_ADDR']."&操作人员=".$_SESSION['LOGIN_USER_NAME']."&操作人员联系方式=$操作人员联系方式")."\" ><font color=red title='如果点击完系统没有响应,则可以进行重新点击'>点击上传至教育局服务器</font></a>
		</td></tr>";
		table_end();exit;



	}
//#############################################################################################

exit;
}

function    MakeBackupTableData($TABLE_NAME)						{

   global $handle,$filename,$connection;

   if(1)			{

   //---------------- 获得INSERT语句 -----------------------
   $query = "SELECT * FROM $TABLE_NAME";
   $cursor= exequery2($connection,$query);
   while($ROW = mysql_fetch_row($cursor))
   {
       $COMMA = "";
       $INSERT_STR = "INSERT INTO $TABLE_NAME VALUES(";
       $FIELD_NUM=mysql_num_fields($cursor);
       for($I = 0; $I < $FIELD_NUM; $I++) {
          $INSERT_STR .= $COMMA."'".mysql_escape_string($ROW[$I])."'";
          $COMMA = ",";
       }
       $INSERT_STR .= ");\n";
       $FILE_CONTENT = $INSERT_STR;
	   $FILE_CONTENT = ereg_replace('&nbsp;',' ',$FILE_CONTENT);
	   $FILE_CONTENT = ereg_replace('&amp;','&',$FILE_CONTENT);
	   fwrite($handle, $FILE_CONTENT);
   }
   $FILE_CONTENT = "\n\n";
   fwrite($handle, $FILE_CONTENT);
   }

}




if($_GET['action']=="DeleteSchedule")								{
	$sql = "TRUNCATE TABLE edu_schedule";
	$db->Execute($sql);
	table_begin("500");
	print  "<tr class=\"TableControl\"> <td colspan=\"12\" align=center>排课数据表已经清空&nbsp;&nbsp;<BR><input type=button  value=返回 class=BigButton onClick=\"location='?'\" title=返回> </td></tr>";
	table_end();exit;
}

if($_GET['action']=="DeleteExam")								{
	$sql = "TRUNCATE TABLE edu_exam";
	$db->Execute($sql);
	table_begin("500");
	print  "<tr class=\"TableControl\"> <td colspan=\"12\" align=center>成绩数据表已经清空&nbsp;&nbsp;<BR><input type=button  value=返回 class=BigButton onClick=\"location='?'\" title=返回> </td></tr>";
	table_end();exit;
}

if($_GET['action']=="DeleteStudentFee")								{
	$sql = "TRUNCATE TABLE edu_shoufeidan";		$db->Execute($sql);
	$sql = "TRUNCATE TABLE edu_shoufeidanprint";		$db->Execute($sql);
	$sql = "TRUNCATE TABLE edu_cunkuandan";		$db->Execute($sql);
	$sql = "TRUNCATE TABLE edu_qukuandan";		$db->Execute($sql);
	$sql = "TRUNCATE TABLE edu_tuifeidan";		$db->Execute($sql);
	$sql = "TRUNCATE TABLE edu_qitashouru";		$db->Execute($sql);
	$sql = "TRUNCATE TABLE edu_qitazhichu";		$db->Execute($sql);
	table_begin("500");
	print  "<tr class=\"TableControl\"> <td colspan=\"12\" align=center>与学生交费相关的财务数据已经清空&nbsp;&nbsp;<BR><input type=button  value=返回 class=BigButton onClick=\"location='?'\" title=返回> </td></tr>";
	table_end();
	exit;
}


if($_GET['action']=="DeleteTestData"&&$_SESSION['LOGIN_USER_ID']=='admin')								{
	$sql = "show tables";
	$rs = $db->Execute($sql);
	$rs_a = $rs->GetArray();
	$放行表名单 = array("user","user_priv","department","sys_function","sys_menu","edu_xi","edu_zhuanye","edu_banji","edu_student","systemprivate","systemlang");
	for($i=0;$i<sizeof($rs_a);$i++)		{
		$TableName = trim($rs_a[$i]['Tables_in_td_crm']);
		$字段列表  = $db->MetaColumnNames($TableName);
		$字段列表  = @array_keys($字段列表);
		if(sizeof($字段列表)>3&&!in_array($TableName,$放行表名单))			{
			$sql = "TRUNCATE TABLE $TableName";
			//print $sql."<BR>";
			$db->Execute($sql);
		}
	}

	$handle = fopen ("is_running.ini", "w+");
	fwrite($handle,"测试数据已清空");
	fclose($handle);

	table_begin("500");
	print  "<tr class=\"TableControl\"> <td colspan=\"12\" align=center>系统之中的测试数据已经完成,您可以重新开始使用本系统了.&nbsp;&nbsp;<BR><input type=button  value=返回 class=BigButton onClick=\"location='?'\" title=返回> </td></tr>";
	table_end();
	exit;
}








if($_GET['action']=="DeleteTeacherTeaching")								{
	$sql = "TRUNCATE TABLE school_download";		$db->Execute($sql);
	$sql = "TRUNCATE TABLE school_gb";				$db->Execute($sql);
	$sql = "TRUNCATE TABLE school_homework";		$db->Execute($sql);
	$sql = "TRUNCATE TABLE school_homework2";		$db->Execute($sql);
	$sql = "TRUNCATE TABLE school_homeworkupload";	$db->Execute($sql);
	$sql = "TRUNCATE TABLE school_mastergb";		$db->Execute($sql);
	$sql = "TRUNCATE TABLE school_notify";			$db->Execute($sql);
	$sql = "TRUNCATE TABLE school_protice";			$db->Execute($sql);
	$sql = "TRUNCATE TABLE school_teachinglog";		$db->Execute($sql);
	$sql = "TRUNCATE TABLE edu_addkeyan";			$db->Execute($sql);
	$sql = "TRUNCATE TABLE edu_jiaoan";				$db->Execute($sql);

	table_begin("500");
	print  "<tr class=\"TableControl\"> <td colspan=\"12\" align=center>已经清空与教师教学及管理学生产生的数据&nbsp;&nbsp;<BR><input type=button  value=返回 class=BigButton onClick=\"location='?'\" title=返回> </td></tr>";
	table_end();
	exit;
}


if($_GET['action']=="DeleteTdEdu")								{

$TABLE_ARRAY=mysql_list_tables($MYSQL_DB);
while($TABLE=mysql_fetch_row($TABLE_ARRAY))
{
	$Tablename = $TABLE[0];
	$TablenameArray = explode('_',$Tablename);
	//
	if(1)
	{
		array_push($NewTableArray,$Tablename);
		$TABLE_NAME=$TABLE[0];
		$sql = "DROP TABLE IF EXISTS $TABLE_NAME;\n";
		$db->Execute($sql);
		//print "已经删除数据表：".$Tablename."<BR>";
	}
}

$sql = "delete from `sys_menu` where MENU_ID='cc'";	$db->Execute($sql);
$sql = "delete from `sys_menu` where MENU_ID='cd'";	$db->Execute($sql);
$sql = "delete from `sys_menu` where MENU_ID='ce'";	$db->Execute($sql);
$sql = "delete from sys_function where FUNC_ID>='372' and FUNC_ID<='385'";	$db->Execute($sql);
table_begin("500");
print  "<tr class=\"TableControl\"> <td colspan=\"12\" align=center>数据库已经清空,总计清空相关数据表".count($NewTableArray)."个<BR>&nbsp;&nbsp;<input type=button  value=返回 class=BigButton onClick=\"location='?'\" title=返回> </td></tr>";
table_end();
exit;
}


if($_GET['action']=="Backup")								{


//array_push($PrivateTableArray,"sys_function");
//array_push($PrivateTableArray,"sys_menu");
$EXPORT_DATE = Date("Y-m-d-H-i");
$PureSQLFile = $EXPORT_DATE.".sql";
$filename = "../../databackup/".$EXPORT_DATE.".sql";

//print_R($db);

if(1)											{
//if(!is_file($filename))						{

!$handle = fopen($filename, 'w');


//$FILE_CONTENT = "set names gbk;\n";
//fwrite($handle, $FILE_CONTENT);

$TABLE_ARRAY=mysql_list_tables($MYSQL_DB);



while($TABLE=mysql_fetch_row($TABLE_ARRAY))
{
	$Tablename = $TABLE[0];
	$TablenameArray = explode('_',$Tablename);
	if(1)
	{
	//print "已经备份数据表：".$Tablename."<BR>";
	array_push($NewTableArray,$Tablename);
   //---------------- 获得DROP TABLE语句 -----------------------
   $TABLE_NAME=$TABLE[0];

   //--- 排除post_tel表 ---
   if(stristr($TABLE_NAME,"post_tel"))
      continue;

   $FILE_CONTENT = "DROP TABLE IF EXISTS $TABLE_NAME;\n";
   fwrite($handle, $FILE_CONTENT);
   //---------------- 获得CREATE语句 -----------------------
   $query = "SHOW CREATE TABLE $TABLE_NAME";
   $cursor= exequery2($connection,$query);
   if($ROW = mysql_fetch_row($cursor))
      $CREATE_STR=$ROW[1];
   $FILE_CONTENT = $CREATE_STR." CHARSET=gbk;\n\n";
   fwrite($handle, $FILE_CONTENT);

   //---------------- 获得INSERT语句 -----------------------
   $query = "SELECT * FROM $TABLE_NAME";
   $cursor= exequery2($connection,$query);
   while($ROW = mysql_fetch_row($cursor))
   {
       $COMMA = "";
       $INSERT_STR = "INSERT INTO $TABLE_NAME VALUES(";
       $FIELD_NUM=mysql_num_fields($cursor);
       for($I = 0; $I < $FIELD_NUM; $I++) {
          $INSERT_STR .= $COMMA."'".mysql_escape_string_userdefine($ROW[$I])."'";
          $COMMA = ",";
       }
       $INSERT_STR .= ");\n";
       $FILE_CONTENT = $INSERT_STR;
	   $FILE_CONTENT = ereg_replace('&nbsp;',' ',$FILE_CONTENT);
	   $FILE_CONTENT = ereg_replace('&amp;','&',$FILE_CONTENT);
	   fwrite($handle, $FILE_CONTENT);
   }
   $FILE_CONTENT = "\n\n";
   fwrite($handle, $FILE_CONTENT);
   }
}

//print $FILE_CONTENT;

mysql_free_result($TABLE_ARRAY);

//if (!fwrite($handle, $FILE_CONTENT)) {
//	break;
//}
fclose($handle);


//压缩SQL文件为ZIP文件
$key = $PureSQLFile.".zip";
$zip = new Zip;
$zipfile=$filename;
$filesize=@filesize($zipfile);
$fp=@fopen($zipfile,rb);
$zipfiles[]=Array($PureSQLFile,@fread($fp,$filesize));
@fclose($fp);
$zip->Add($zipfiles,1);
if(@fputs(@fopen("../../databackup/".$key,"wb"), $zip->get_file()))	{
	$filename = "../../databackup/".$key;
};


table_begin("500");
print  "<tr class=\"TableControl\"> <td colspan=\"12\" align=center> <a href=\"$filename\" title='点击右键,选择目标另存为'>数据库已经备份完成,总备份".count($NewTableArray)."个数据表,点击右键选择目标另存为下载数据库SQL文件</a><BR>&nbsp;&nbsp;<input type=button  value=返回 class=BigButton onClick=\"location='?'\" title=返回> </td></tr>";
table_end();

}


exit;

}

function mysql_escape_string_userdefine($TEXT)		{
	$TEXT = html_entity_decode($TEXT);
	$TEXT = htmlspecialchars_decode($TEXT);
	$TEXT = ereg_replace("'",'‘',$TEXT);
	$TEXT = ereg_replace('"','”',$TEXT);
	return $TEXT;
}



function OpenConnection2( )
{
				global $connection;
				global $MYSQL_SERVER;
				global $MYSQL_USER;
				global $MYSQL_PASS;
				global $MYSQL_DB;
				if ( !$connection )
				{
								if ( !function_exists( "mysql_pconnect" ) )
								{
												echo "PHP配置有误，不能调用Mysql函数库，请检查有关配置";
												exit( );
								}
								$C = @mysql_pconnect( $MYSQL_SERVER, $MYSQL_USER, $MYSQL_PASS, MYSQL_CLIENT_COMPRESS );
				}
				else
				{
								$C = $connection;
				}
				mysql_query( "SET NAMES GBK", $C );
				if ( !$C )
				{
								PrintError2( "不能连接到MySQL数据库，请检查：1、MySQL服务是否启动；2、MySQL被防火墙阻止；3、连接MySQL的用户名和密码是否正确。" );
								exit( );
				}
				$result = mysql_select_db( $MYSQL_DB, $C );
				if ( !$result )
				{
								PrintError2( "数据库 ".$MYSQL_DB."不存在" );
				}
				return $C;
}

function exequery2( $C, $Q )
{
				if ( preg_match( "/\\bunion[\\s]+select\\b/i", $Q ) || preg_match( "/\\bunion[\\s]+all[\\s]+select\\b/i", $Q ) )
				{
								exit( );
				}
				$cursor = mysql_query( $Q, $C );
				if ( !$cursor )
				{
								PrintError2( "<b>SQL语句:</b> ".$Q );
				}
				return $cursor;
}

function PrintError2( $MSG )
{
				echo "<fieldset>  <legend><b>错误</b></legend>";
				echo "<b>#".mysql_errno( ).":</b> ".mysql_error( )."<br>";
				global $SCRIPT_FILENAME;
				echo $MSG."<br>";
				echo "<b>文件:</b> ".$SCRIPT_FILENAME;
				if ( mysql_errno( ) == 1030 )
				{
								echo "<br>请联系管理员到 系统管理-数据库管理 中修复数据库解决。";
				}
				echo "</fieldset>";
}

?><?php
/*
	版权归属:郑州单点科技软件有限公司;
	联系方式:0371-69663266;
	公司地址:河南郑州经济技术开发区第五大街经北三路通信产业园四楼西南;
	公司简介:郑州单点科技软件有限公司位于中国中部城市-郑州,成立于2007年1月,致力于把基于先进信息技术（包括通信技术）的最佳管理与业务实践普及到教育行业客户的管理与业务创新活动中，全面提供具有自主知识产权的教育管理软件、服务与解决方案，是中部最优秀的高校教育管理软件及中小学校管理软件提供商。目前已经有多家高职和中职类院校使用通达中部研发中心开发的软件和服务;

	软件名称:单点科技软件开发基础性架构平台,以及在其基础之上扩展的任何性软件作品;
	发行协议:数字化校园产品为商业软件,发行许可为LICENSE方式;单点CRM系统即SunshineCRM系统为GPLV3协议许可,GPLV3协议许可内容请到百度搜索;
	特殊声明:软件所使用的ADODB库,PHPEXCEL库,SMTARY库归原作者所有,余下代码沿用上述声明;
	*/
?>