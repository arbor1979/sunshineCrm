<?php

//######################�������-Ȩ�޽��鲿��##########################
require_once("lib.inc.php");
$GLOBAL_SESSION=returnsession();

require_once("conn.php");
//CheckSystemPrivate("ϵͳ��Ϣ����-���ݿ����");
//######################�������-Ȩ�޽��鲿��##########################

require_once('lib.zip.inc.php');

page_css("����CRMϵͳ");
validateMenuPriv("���ݿ����");
$connection = OpenConnection2();


$PrivateTableArray = array("sessions2","systemtable","systemhelp","systemsetting","systemprivate","systemlang","systemprivateinc");

$NewTableArray = array();

//print_R($_SESSION);
//print $IE_TITLE;

$IE_TITLE_ARRAY =	explode(' ',$IE_TITLE);
$IE_TITLE_NAME	=	$IE_TITLE_ARRAY[0];
if($_GET['action']=='')							{
?>
<script language="javascript" type="text/javascript" src="<?php echo ROOT_DIR?>general/ERP/Enginee/WdatePicker/WdatePicker.js"></script>

<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<table border="0" width="70%" align=center cellspacing="0" cellpadding="3" class="TableBlock">
  <tr  class=TableHeader>
    <td colspan="12" height=28>&nbsp;<img src="<?php echo ROOT_DIR?>images/sys_config.gif" align="absmiddle" > ����<?php echo $IE_TITLE_NAME?>��װ��ɾ������(���²������������������ָ���½���)</td>
  </tr>

 <tr class="TableData">
 <td colspan="6" align=center height=32>
    <input type="button"  value="CRM���ݿⱸ��" class="BigButton" onClick="javascript:if(confirm('�����Ҫ���д������ô?'))location='?<?php echo base64_encode("action=Backup");?>'" title="���ݿⱸ��">
 </td>
 <td colspan="6" align=left width=80%><font color=green>����CRM������ݿ��ļ�,����OA�������</font></td>
</tr>

 <tr class="TableData">
 <td colspan="6" align=center height=32>
    <input type="button"  value="CRM���ݿ����" class="BigButton" onClick="javascript:if(confirm('�����Ҫ���д������ô?'))location='?<?php echo base64_encode("action=DeleteTdERP");?>'" title="���ݿ�ɾ��">
 </td>
 <td colspan="6" align=left width=80%><B><font color=red>���CRMϵͳ�еĵ��ݣ������ɹ�����桢����⡢���ۡ��տ�ȣ������ͻ�����ϵ�ˡ���Ʒ��Ȼ�������!</font></B></td>
</tr>

<tr class="TableData">
 <td colspan="6" align=center height=32>
    <input type="button"  value="���ݿ������־" class="BigButton" onClick="location='system_log_newai.php'" title="�鿴���ݿ������־">
 </td>
 <td colspan="6" align=left width=80%>�鿴���ݿ������־</td>
</tr>

<tr class="TableData">
 <td colspan="6" align=center height=32>
    <input type="button"  value="ɾ����������" class="BigButton" onClick="javascript:
    var beginvalue=document.getElementById('begintime').value;
    var endvalue=document.getElementById('endtime').value;
    var param='action=DeleteGongZuoBaoGao&begintime='+beginvalue+'&endtime='+endvalue;
    if(confirm('�����Ҫ���д������ô?'))
    	location='?'+param;" title="������������ɾ��">
 </td>
 <td colspan="6" align=left width=80%>ɾ�������������档<br>��ʼʱ��: <INPUT  class=SmallInput maxLength=20  name=��ʼʱ�� value=<?php echo date("Y-m-d",mktime(1,1,1,date('m'),date('d')-21,date('Y')))?>  id="begintime" onClick="WdatePicker({dateFmt:'yyyy-MM-dd',alwaysUseStartDate:true})">
 <img src="/general/ERP/Framework/images/menu/clock.gif" width=16 height=16 title="����ʱ��" align="absMiddle" border="0" align="absMiddle" style="cursor:pointer" onclick="��ʼʱ��.click();">
	����ʱ��:<INPUT  class=SmallInput maxLength=20  name=����ʱ�� value=<?php echo date("Y-m-d",mktime(1,1,1,date('m'),date('d'),date('Y')))?>  id="endtime" onClick="WdatePicker({dateFmt:'yyyy-MM-dd',alwaysUseStartDate:true})">
	<img src="/general/ERP/Framework/images/menu/clock.gif" width=16 height=16 title="����ʱ��" align="absMiddle" border="0" align="absMiddle" style="cursor:pointer" onclick="����ʱ��.click();">
	</td>
</tr>
<td colspan="6" align=center height=32>
    <input type="button"  value="ɾ������" class="BigButton" onClick="javascript:
    var param='action=DeleteZeroKuCun';
    if(confirm('�����Ҫ���д������ô?'))
    	location='?'+param;" >
 </td>
 <td colspan="6" align=left width=80%>ɾ�����������Ϊ0�ļ�¼��
	</td>
</tr>
<tr class="TableData">
 <td colspan="6" align=center height=32>��������ɾ��
 </td>
 <td colspan="6" align=left width=80%>
 <input type="button"  value="ɾ���ͻ�" class="BigButton" onClick="javascript:if(confirm('�����Ҫ���д������ô?'))location='?<?php echo base64_encode("action=DeleteAllCust");?>'" >
 <input type="button"  value="ɾ����Ӧ��" class="BigButton" onClick="javascript:if(confirm('�����Ҫ���д������ô?'))location='?<?php echo base64_encode("action=DeleteAllSupply");?>'" >
 <input type="button"  value="ɾ����Ʒ��" class="BigButton" onClick="javascript:if(confirm('�����Ҫ���д������ô?'))location='?<?php echo base64_encode("action=DeleteAllProduct");?>'" >
 </td>
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



print "</table><BR>";

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








if($_GET['action']=="DeleteTdERP")								{

$sql = "delete from `buyplanmain`";		$db->Execute($sql);//�ɹ���
$sql = "delete from `buyplanmain_detail`";		$db->Execute($sql);
$sql = "delete from `buyplanmain_detail_color`";		$db->Execute($sql);
$sql = "delete from `fahuodan`";		$db->Execute($sql);//������
$sql = "delete from `fahuodan_detail`";		$db->Execute($sql);
$sql = "delete from `productzuzhuang`";	$db->Execute($sql);//��Ʒ��װ��
$sql = "delete from `productzuzhuang_detail`";		$db->Execute($sql);
$sql = "delete from `productzuzhuang2_detail`";		$db->Execute($sql);
$sql = "delete from `sellplanmain`";	$db->Execute($sql);//���۵�
$sql = "delete from `sellplanmain_detail`";		$db->Execute($sql);
$sql = "delete from `stockchangemain`";	$db->Execute($sql);//������
$sql = "delete from `stockchangemain_detail`";		$db->Execute($sql);
$sql = "delete from `stockinmain`";		$db->Execute($sql);//��ⵥ
$sql = "delete from `stockinmain_detail`";		$db->Execute($sql);
$sql = "delete from `stockinmain_detail_color`";		$db->Execute($sql);
$sql = "delete from `stockoutmain`";	$db->Execute($sql);//���ⵥ
$sql = "delete from `stockoutmain_detail`";		$db->Execute($sql);
$sql = "delete from `store`";			$db->Execute($sql);//���
$sql = "delete from `store_init`";		$db->Execute($sql);//����ʼ��
$sql = "delete from `storecheck`";		$db->Execute($sql);//�̵㵥
$sql = "delete from `storecheck_detail`";		$db->Execute($sql);
$sql = "delete from `fukuanplan`";	$db->Execute($sql);//����ƻ�
$sql = "delete from `fukuanrecord`";	$db->Execute($sql);//�����¼
$sql = "delete from `shoupiaorecord`";	$db->Execute($sql);//��Ʊ��¼
$sql = "delete from `huikuanplan`";	$db->Execute($sql);//�ؿ�ƻ�
$sql = "delete from `huikuanrecord`";	$db->Execute($sql);//�ؿ��¼
$sql = "delete from `kaipiaorecord`";	$db->Execute($sql);//��Ʊ��¼
$sql = "delete from `feiyongrecord`";	$db->Execute($sql);//���뿪֧
$sql = "delete from `accessprepay`";	$db->Execute($sql);//Ԥ����
$sql = "delete from `accesspreshou`";	$db->Execute($sql);//Ԥ�տ�
$sql = "delete from `accessbank`";	$db->Execute($sql);//�˻�������¼
$sql = "delete from `sms_sendlist`";	$db->Execute($sql);//�ֻ�����
$sql = "delete from `commlog`";	$db->Execute($sql);//�ͻ��ػ�
$sql = "delete from `crm_service`";	$db->Execute($sql);//�ͻ�����
$sql = "delete from `crm_feiyong_sq`";	$db->Execute($sql);//�ͻ�����
$sql = "delete from `bankzhuru`";	$db->Execute($sql);//�ʱ�ע��
$sql = "delete from `email`";	$db->Execute($sql);//�ʼ�
$sql = "delete from `notify`";	$db->Execute($sql);//����
$sql = "delete from `crm_shenqingbaobei`";  $db->Execute($sql);//��Ŀ����
$sql = "delete from `workplanmain`";  $db->Execute($sql);//�����ƻ�
$sql = "delete from `workplanmain_detail`";  $db->Execute($sql);//�����ƻ�
$sql = "delete from `crm_chance`";  $db->Execute($sql);//���ۻ���
$sql = "delete from `crm_contact`";  $db->Execute($sql);//���ټ�¼
$sql = "delete from `customer_xuqiu`";  $db->Execute($sql);//��ϸ����
$sql = "delete from `customer_fangan`";  $db->Execute($sql);//�������
$sql = "delete from `competeproduct`";  $db->Execute($sql);//������Ʒ
$sql = "delete from `customerproduct`";  $db->Execute($sql);//��Ʒ����
$sql = "delete from `customerproduct_detail`";  $db->Execute($sql);
$sql = "delete from `sellcontract_jiaofu`";  $db->Execute($sql);//������¼
table_begin("500");
print  "<tr class=\"TableControl\"> <td colspan=\"12\" align=center>������ݱ��Ѿ����!<BR>&nbsp;&nbsp;<input type=button  value=���� class=BigButton onClick=\"location='?'\" title=����> </td></tr>";
table_end();
exit;
}
if($_GET['action']=="DeleteAllCust")								{

$sql = "delete from `customer`";		$db->Execute($sql);//�ͻ�����
$sql = "delete from `linkman`";		$db->Execute($sql);
table_begin("500");
print  "<tr class=\"TableControl\"> <td colspan=\"12\" align=center>�ͻ����ϼ���ϵ�˱��Ѿ����!<BR>&nbsp;&nbsp;<input type=button  value=���� class=BigButton onClick=\"location='?'\" title=����> </td></tr>";
table_end();
exit;
}
if($_GET['action']=="DeleteAllSupply")								{

$sql = "delete from `supply`";		$db->Execute($sql);//��Ӧ������
$sql = "delete from `supplylinkman`";		$db->Execute($sql);
table_begin("500");
print  "<tr class=\"TableControl\"> <td colspan=\"12\" align=center>��Ӧ�̼���ϵ�˱��Ѿ����!<BR>&nbsp;&nbsp;<input type=button  value=���� class=BigButton onClick=\"location='?'\" title=����> </td></tr>";
table_end();
exit;
}
if($_GET['action']=="DeleteAllProduct")								{

$sql = "delete from `product`";		$db->Execute($sql);//��Ӧ������
$sql = "delete from `producttype`";		$db->Execute($sql);
table_begin("500");
print  "<tr class=\"TableControl\"> <td colspan=\"12\" align=center>��Ʒ�⼰��Ʒ�����Ѿ����!<BR>&nbsp;&nbsp;<input type=button  value=���� class=BigButton onClick=\"location='?'\" title=����> </td></tr>";
table_end();
exit;
}
if($_GET['action']=="DeleteZeroKuCun")								{

$sql = "delete from `store` where num=0";		$db->Execute($sql);//����
table_begin("500");
print  "<tr class=\"TableControl\"> <td colspan=\"12\" align=center>���������Ϊ0�ļ�¼��ɾ��!<BR>&nbsp;&nbsp;<input type=button  value=���� class=BigButton onClick=\"location='?'\" title=����> </td></tr>";
table_end();
exit;
}

if($_GET['action']=="DeleteFeiQiDan")								{
$begintime=$_GET['begintime']." 0:00:00";
$endtime=$_GET['endtime']." 23:59:59";
$sql = "delete from `buyplanmain` where user_flag=-1"; //�ɹ���
if($begintime!='')
	$sql.=" and createtime>='$begintime'";
if($endtime!='')
	$sql.=" and createtime<='$endtime'";
$db->Execute($sql);

$sql = "delete from `sellplanmain` where user_flag=-1";	//���۵�	
if($begintime!='')
	$sql.=" and createtime>='$begintime'";
if($endtime!='')
	$sql.=" and createtime<='$endtime'";
$db->Execute($sql);

table_begin("500");
print  "<tr class=\"TableControl\"> <td colspan=\"12\" align=center>�����ѳ���ɾ��!<BR>&nbsp;&nbsp;<input type=button  value=���� class=BigButton onClick=\"location='?'\" title=����> </td></tr>";
table_end();
exit;
}

if($_GET['action']=="DeleteGongZuoBaoGao")								{
	$begintime=$_GET['begintime']." 0:00:00";
	$endtime=$_GET['endtime']." 23:59:59";
	$sql = "delete from `workreport` where state='�����'"; //��������
	if($begintime!='')
		$sql.=" and createtime>='$begintime'";
	if($endtime!='')
		$sql.=" and createtime<='$endtime'";
	$db->Execute($sql);

	table_begin("500");
	print  "<tr class=\"TableControl\"> <td colspan=\"12\" align=center>����˵Ĺ��������ѳ���ɾ��!<BR>&nbsp;&nbsp;<input type=button  value=���� class=BigButton onClick=\"location='?'\" title=����> </td></tr>";
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

$FILE_CONTENT="";
$File_View="";
fwrite($handle, "SET FOREIGN_KEY_CHECKS=0;\nSET NAMES GBK;\n");
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
   //if(stristr($TABLE_NAME,"post_tel"))
   //   continue;

   
   //---------------- ���CREATE��� -----------------------
   $query = "SHOW CREATE TABLE $TABLE_NAME";
   $cursor= exequery2($connection,$query);
   if($ROW = mysql_fetch_row($cursor))
      $CREATE_STR=$ROW[1];
   if(stristr($CREATE_STR, "CREATE ALGORITHM"))
   {
   		$File_View.= "DROP VIEW IF EXISTS $TABLE_NAME;\n";
   		$File_View.=$CREATE_STR.";\n\n";
   		continue;
   }
   else 
   {
   		$FILE_CONTENT= "DROP TABLE IF EXISTS $TABLE_NAME;\n";
   		$FILE_CONTENT.=$CREATE_STR.";\n\n";;
   		fwrite($handle, $FILE_CONTENT);
   }

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
fwrite($handle, $File_View);
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
	$TEXT = ereg_replace("'","\'",$TEXT);
	$TEXT = ereg_replace('"','\"',$TEXT);
	$TEXT = ereg_replace(';','\;',$TEXT);
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
	����Э��:���ֻ�У԰��ƷΪ��ҵ���,�������ΪLICENSE��ʽ;����<?php echo $IE_TITLE_NAME?>��Sunshine<?php echo $IE_TITLE_NAME?>ΪGPLV3Э�����,GPLV3Э����������뵽�ٶ�����;
	��������:�����ʹ�õ�ADODB��,PHPEXCEL��,SMTARY���ԭ��������,���´���������������;
	*/
?>