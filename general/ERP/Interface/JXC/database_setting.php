<?php

//######################�������-Ȩ�޽��鲿��##########################
SESSION_START();
require_once("lib.inc.php");
$GLOBAL_SESSION=returnsession();
require_once("systemprivateinc.php");
CheckSystemPrivate("ϵͳ��Ϣ����-���ݿ����");
//######################�������-Ȩ�޽��鲿��##########################

require_once('lib.inc.php');
require_once('lib.zip.inc.php');

$GLOBAL_SESSION=returnsession();

page_css("����CRMϵͳ");
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
    <td colspan="12" height=28>&nbsp;<img src="<?php echo ROOT_DIR?>images/sys_config.gif" align="absmiddle" > ����CRMϵͳ��װ��ɾ������(���²������������������ָ���½���)</td>
  </tr>

 <tr class="TableData">
 <td colspan="6" align=center height=32>
    <input type="button"  value="CRMϵͳ���ݿⱸ��" class="BigButton" onClick="javascript:if(confirm('�����Ҫ���д������ô?'))location='?<?php echo base64_encode("action=Backup");?>'" title="���ݿⱸ��">
 </td>
 <td colspan="6" align=left width=80%><font color=green>����CRMϵͳ������ݿ��ļ�,����OA�������</font></td>
</tr>

 <tr class="TableData">
 <td colspan="6" align=center height=32>
    <input type="button"  value="CRMϵͳ���ݿ����" class="BigButton" onClick="javascript:if(confirm('�����Ҫ���д������ô?'))location='?<?php echo base64_encode("action=DeleteTdEdu");?>'" title="���ݿ�ɾ��">
 </td>
 <td colspan="6" align=left width=80%><B><font color=red>���CRMϵͳ�еĵ��ݣ������ɹ�����桢����⡢���ۡ��տ�ȣ������ͻ�����ϵ�ˡ���Ʒ��Ȼ�������!</font></B></td>
</tr>



<tr class="TableData">
 <td colspan="6" align=center height=32>
    <input type="button"  value="�鿴���ݿ������־" class="BigButton" onClick="location='system_log_newai.php'" title="�鿴���ݿ������־">
 </td>
 <td colspan="6" align=left width=80%>�鿴���ݿ������־</td>
</tr>

<tr class="TableData">
 <td colspan="6" align=center height=32>
    <input type="button"  value="���MYSQL��������" class="BigButton" onClick="location='system_logall_view.php'" title="���MYSQL��������">
 </td>
 <td colspan="6" align=left width=80%>���MYSQL��������</td>
</tr>

<tr class="TableData">
 <td colspan="6" align=center height=32>
    <input type="button"  value="�û��������������Ϣ" class="BigButton" onClick="location='systemprivateconfig_newai.php'" title="�û��������������Ϣ">
 </td>
 <td colspan="6" align=left width=80%>�û��������������Ϣ</td>
</tr>



<?php
if(!@is_file('is_running.ini')&&$_SESSION['LOGIN_USER_ID']=='admin'&&0)		{
	print "<tr class='TableData'>
		 <td colspan='6' align=center height=32>
			<input type='button'  value='ɾ����ǰϵͳ��������' class='BigButton' onClick=\"javascript:if(confirm('ʹ�ñ�������ϵͳ����һ���ɾ���ϵͳ,��ֻ��ʹ��һ��,���Ƿ�ȷ��Ҫɾ����ǰϵͳ��������?'))location='?".base64_encode("action=DeleteTestData")."'\" title='ɾ����ǰϵͳ��������'>
		 </td>
		 <td colspan='6' align=left width=80%><font color=red>ɾ����ǰϵͳ��������(�˹���ֻ����һ��,����ʹ��!)</font></td>
		</tr>";
}

//��ʾTD_OA.USER�����
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
		<td colspan=\"12\" align=left width=80%>&nbsp;<font color=gray>ϵͳ���������ͬ������</font></td></tr>";

	//�Զ����������ǰ����ʷ��¼
	$sql = "delete from system_logall where datediff(now(),��ǰʱ��)>7";
	$db->Execute($sql);

	//�Զ�����ϴ��ļ�����Ŀ¼
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


//�������ӱ��� 1 �ڱ��ļ�����Ҫ���ݵ����ݱ� 2 ��remote_zip_datadeal�ļ������ط��ֱ������漰�����ݱ�



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




		//ѹ��SQL�ļ�ΪZIP�ļ�
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
		//��ZIP�ļ�
		$URL = "http://localhost/general/EDU/Interface/EDU/FileCache/JIAOYUJU-2009-08-11-16-44.sql.zip";
		$ZipContent = readFileRemote($URL);//exit;

		//д��Զ���ļ�
		$TEMPFILE = file("config_remote_zip.ini");
		$TEMPFILE = $TEMPFILE[0];
		$ZipContent = base64_encode($ZipContent);
		$REMOTE_URL_PARSE = $TEMPFILE."/general/EDU/Interface/EDU/remote_zip.php?�ļ�����=".$PureSQLFile.".zip&ѧУ����=$ѧУ����&�ļ�����=$ZipContent";
		print $REMOTE_URL_PARSE;
		file($REMOTE_URL_PARSE);
		*/
		$������Ա��ϵ��ʽ = returntablefield("user","USER_NAME",$_SESSION['LOGIN_USER_NAME'],"MOBIL_NO");

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
		<td colspan=\"12\"  align=center>ѧУ����������ɳɹ�,����ϴ��������ַ�����<BR>������̿��ܻ���Ҫ����ʱ��,���Եȴ�(�ļ���С:".$filesize."K)<BR>&nbsp;&nbsp;
		<a href=\"remote_zip.php?".base64_encode("�����ļ�����=$PureSQLFileZIP&�ļ�����=$NewZipFileName&Ŀ���ַ=$REMOTE_URL_PARSE&�ύѧУ��ַ=".$_SERVER['SERVER_ADDR']."&������Ա=".$_SESSION['LOGIN_USER_NAME']."&������Ա��ϵ��ʽ=$������Ա��ϵ��ʽ")."\" ><font color=red title='��������ϵͳû����Ӧ,����Խ������µ��'>����ϴ��������ַ�����</font></a>
		</td></tr>";
		table_end();exit;



	}
//#############################################################################################

exit;
}

function    MakeBackupTableData($TABLE_NAME)						{

   global $handle,$filename,$connection;

   if(1)			{

   //---------------- ���INSERT��� -----------------------
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
	print  "<tr class=\"TableControl\"> <td colspan=\"12\" align=center>�ſ����ݱ��Ѿ����&nbsp;&nbsp;<BR><input type=button  value=���� class=BigButton onClick=\"location='?'\" title=����> </td></tr>";
	table_end();exit;
}

if($_GET['action']=="DeleteExam")								{
	$sql = "TRUNCATE TABLE edu_exam";
	$db->Execute($sql);
	table_begin("500");
	print  "<tr class=\"TableControl\"> <td colspan=\"12\" align=center>�ɼ����ݱ��Ѿ����&nbsp;&nbsp;<BR><input type=button  value=���� class=BigButton onClick=\"location='?'\" title=����> </td></tr>";
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
	print  "<tr class=\"TableControl\"> <td colspan=\"12\" align=center>��ѧ��������صĲ��������Ѿ����&nbsp;&nbsp;<BR><input type=button  value=���� class=BigButton onClick=\"location='?'\" title=����> </td></tr>";
	table_end();
	exit;
}


if($_GET['action']=="DeleteTestData"&&$_SESSION['LOGIN_USER_ID']=='admin')								{
	$sql = "show tables";
	$rs = $db->Execute($sql);
	$rs_a = $rs->GetArray();
	$���б����� = array("user","user_priv","department","sys_function","sys_menu","edu_xi","edu_zhuanye","edu_banji","edu_student","systemprivate","systemlang");
	for($i=0;$i<sizeof($rs_a);$i++)		{
		$TableName = trim($rs_a[$i]['Tables_in_td_crm']);
		$�ֶ��б�  = $db->MetaColumnNames($TableName);
		$�ֶ��б�  = @array_keys($�ֶ��б�);
		if(sizeof($�ֶ��б�)>3&&!in_array($TableName,$���б�����))			{
			$sql = "TRUNCATE TABLE $TableName";
			//print $sql."<BR>";
			$db->Execute($sql);
		}
	}

	$handle = fopen ("is_running.ini", "w+");
	fwrite($handle,"�������������");
	fclose($handle);

	table_begin("500");
	print  "<tr class=\"TableControl\"> <td colspan=\"12\" align=center>ϵͳ֮�еĲ��������Ѿ����,���������¿�ʼʹ�ñ�ϵͳ��.&nbsp;&nbsp;<BR><input type=button  value=���� class=BigButton onClick=\"location='?'\" title=����> </td></tr>";
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
	print  "<tr class=\"TableControl\"> <td colspan=\"12\" align=center>�Ѿ�������ʦ��ѧ������ѧ������������&nbsp;&nbsp;<BR><input type=button  value=���� class=BigButton onClick=\"location='?'\" title=����> </td></tr>";
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
		//print "�Ѿ�ɾ�����ݱ�".$Tablename."<BR>";
	}
}

$sql = "delete from `sys_menu` where MENU_ID='cc'";	$db->Execute($sql);
$sql = "delete from `sys_menu` where MENU_ID='cd'";	$db->Execute($sql);
$sql = "delete from `sys_menu` where MENU_ID='ce'";	$db->Execute($sql);
$sql = "delete from sys_function where FUNC_ID>='372' and FUNC_ID<='385'";	$db->Execute($sql);
table_begin("500");
print  "<tr class=\"TableControl\"> <td colspan=\"12\" align=center>���ݿ��Ѿ����,�ܼ����������ݱ�".count($NewTableArray)."��<BR>&nbsp;&nbsp;<input type=button  value=���� class=BigButton onClick=\"location='?'\" title=����> </td></tr>";
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
	//print "�Ѿ��������ݱ�".$Tablename."<BR>";
	array_push($NewTableArray,$Tablename);
   //---------------- ���DROP TABLE��� -----------------------
   $TABLE_NAME=$TABLE[0];

   //--- �ų�post_tel�� ---
   if(stristr($TABLE_NAME,"post_tel"))
      continue;

   $FILE_CONTENT = "DROP TABLE IF EXISTS $TABLE_NAME;\n";
   fwrite($handle, $FILE_CONTENT);
   //---------------- ���CREATE��� -----------------------
   $query = "SHOW CREATE TABLE $TABLE_NAME";
   $cursor= exequery2($connection,$query);
   if($ROW = mysql_fetch_row($cursor))
      $CREATE_STR=$ROW[1];
   $FILE_CONTENT = $CREATE_STR." CHARSET=gbk;\n\n";
   fwrite($handle, $FILE_CONTENT);

   //---------------- ���INSERT��� -----------------------
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


//ѹ��SQL�ļ�ΪZIP�ļ�
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
print  "<tr class=\"TableControl\"> <td colspan=\"12\" align=center> <a href=\"$filename\" title='����Ҽ�,ѡ��Ŀ�����Ϊ'>���ݿ��Ѿ��������,�ܱ���".count($NewTableArray)."�����ݱ�,����Ҽ�ѡ��Ŀ�����Ϊ�������ݿ�SQL�ļ�</a><BR>&nbsp;&nbsp;<input type=button  value=���� class=BigButton onClick=\"location='?'\" title=����> </td></tr>";
table_end();

}


exit;

}

function mysql_escape_string_userdefine($TEXT)		{
	$TEXT = html_entity_decode($TEXT);
	$TEXT = htmlspecialchars_decode($TEXT);
	$TEXT = ereg_replace("'",'��',$TEXT);
	$TEXT = ereg_replace('"','��',$TEXT);
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
												echo "PHP�������󣬲��ܵ���Mysql�����⣬�����й�����";
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
								PrintError2( "�������ӵ�MySQL���ݿ⣬���飺1��MySQL�����Ƿ�������2��MySQL������ǽ��ֹ��3������MySQL���û����������Ƿ���ȷ��" );
								exit( );
				}
				$result = mysql_select_db( $MYSQL_DB, $C );
				if ( !$result )
				{
								PrintError2( "���ݿ� ".$MYSQL_DB."������" );
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
								PrintError2( "<b>SQL���:</b> ".$Q );
				}
				return $cursor;
}

function PrintError2( $MSG )
{
				echo "<fieldset>  <legend><b>����</b></legend>";
				echo "<b>#".mysql_errno( ).":</b> ".mysql_error( )."<br>";
				global $SCRIPT_FILENAME;
				echo $MSG."<br>";
				echo "<b>�ļ�:</b> ".$SCRIPT_FILENAME;
				if ( mysql_errno( ) == 1030 )
				{
								echo "<br>����ϵ����Ա�� ϵͳ����-���ݿ���� ���޸����ݿ�����";
				}
				echo "</fieldset>";
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