<?php

//######################教育组件-权限较验部分##########################
require_once("lib.inc.php");
$GLOBAL_SESSION=returnsession();

require_once("conn.php");
//CheckSystemPrivate("系统信息设置-数据库管理");
//######################教育组件-权限较验部分##########################

require_once('lib.zip.inc.php');

page_css("单点CRM系统");
validateMenuPriv("数据库管理");
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
    <td colspan="12" height=28>&nbsp;<img src="<?php echo ROOT_DIR?>images/sys_config.gif" align="absmiddle" > 单点<?php echo $IE_TITLE_NAME?>安装与删除管理(以下操作建议在软件开发商指导下进行)</td>
  </tr>

 <tr class="TableData">
 <td colspan="6" align=center height=32>
    <input type="button"  value="CRM数据库备份" class="BigButton" onClick="javascript:if(confirm('你真的要进行此项操作么?'))location='?<?php echo base64_encode("action=Backup");?>'" title="数据库备份">
 </td>
 <td colspan="6" align=left width=80%><font color=green>备份CRM相关数据库文件,不含OA相关数据</font></td>
</tr>

 <tr class="TableData">
 <td colspan="6" align=center height=32>
    <input type="button"  value="CRM数据库清空" class="BigButton" onClick="javascript:if(confirm('你真的要进行此项操作么?'))location='?<?php echo base64_encode("action=DeleteTdERP");?>'" title="数据库删除">
 </td>
 <td colspan="6" align=left width=80%><B><font color=red>清空CRM系统中的单据，包括采购、库存、出入库、销售、收款等，保留客户、联系人、产品库等基本资料!</font></B></td>
</tr>

<tr class="TableData">
 <td colspan="6" align=center height=32>
    <input type="button"  value="数据库操作日志" class="BigButton" onClick="location='system_log_newai.php'" title="查看数据库操作日志">
 </td>
 <td colspan="6" align=left width=80%>查看数据库操作日志</td>
</tr>

<tr class="TableData">
 <td colspan="6" align=center height=32>
    <input type="button"  value="删除工作报告" class="BigButton" onClick="javascript:
    var beginvalue=document.getElementById('begintime').value;
    var endvalue=document.getElementById('endtime').value;
    var param='action=DeleteGongZuoBaoGao&begintime='+beginvalue+'&endtime='+endvalue;
    if(confirm('你真的要进行此项操作么?'))
    	location='?'+param;" title="废弃工作报告删除">
 </td>
 <td colspan="6" align=left width=80%>删除废弃工作报告。<br>开始时间: <INPUT  class=SmallInput maxLength=20  name=开始时间 value=<?php echo date("Y-m-d",mktime(1,1,1,date('m'),date('d')-21,date('Y')))?>  id="begintime" onClick="WdatePicker({dateFmt:'yyyy-MM-dd',alwaysUseStartDate:true})">
 <img src="/general/ERP/Framework/images/menu/clock.gif" width=16 height=16 title="设置时间" align="absMiddle" border="0" align="absMiddle" style="cursor:pointer" onclick="开始时间.click();">
	结束时间:<INPUT  class=SmallInput maxLength=20  name=结束时间 value=<?php echo date("Y-m-d",mktime(1,1,1,date('m'),date('d'),date('Y')))?>  id="endtime" onClick="WdatePicker({dateFmt:'yyyy-MM-dd',alwaysUseStartDate:true})">
	<img src="/general/ERP/Framework/images/menu/clock.gif" width=16 height=16 title="设置时间" align="absMiddle" border="0" align="absMiddle" style="cursor:pointer" onclick="结束时间.click();">
	</td>
</tr>
<td colspan="6" align=center height=32>
    <input type="button"  value="删除零库存" class="BigButton" onClick="javascript:
    var param='action=DeleteZeroKuCun';
    if(confirm('你真的要进行此项操作么?'))
    	location='?'+param;" >
 </td>
 <td colspan="6" align=left width=80%>删除库存中数量为0的记录。
	</td>
</tr>
<tr class="TableData">
 <td colspan="6" align=center height=32>基础资料删除
 </td>
 <td colspan="6" align=left width=80%>
 <input type="button"  value="删除客户" class="BigButton" onClick="javascript:if(confirm('你真的要进行此项操作么?'))location='?<?php echo base64_encode("action=DeleteAllCust");?>'" >
 <input type="button"  value="删除供应商" class="BigButton" onClick="javascript:if(confirm('你真的要进行此项操作么?'))location='?<?php echo base64_encode("action=DeleteAllSupply");?>'" >
 <input type="button"  value="删除商品库" class="BigButton" onClick="javascript:if(confirm('你真的要进行此项操作么?'))location='?<?php echo base64_encode("action=DeleteAllProduct");?>'" >
 </td>
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



print "</table><BR>";

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








if($_GET['action']=="DeleteTdERP")								{

$sql = "delete from `buyplanmain`";		$db->Execute($sql);//采购单
$sql = "delete from `buyplanmain_detail`";		$db->Execute($sql);
$sql = "delete from `buyplanmain_detail_color`";		$db->Execute($sql);
$sql = "delete from `fahuodan`";		$db->Execute($sql);//发货单
$sql = "delete from `fahuodan_detail`";		$db->Execute($sql);
$sql = "delete from `productzuzhuang`";	$db->Execute($sql);//产品组装单
$sql = "delete from `productzuzhuang_detail`";		$db->Execute($sql);
$sql = "delete from `productzuzhuang2_detail`";		$db->Execute($sql);
$sql = "delete from `sellplanmain`";	$db->Execute($sql);//销售单
$sql = "delete from `sellplanmain_detail`";		$db->Execute($sql);
$sql = "delete from `stockchangemain`";	$db->Execute($sql);//调拨单
$sql = "delete from `stockchangemain_detail`";		$db->Execute($sql);
$sql = "delete from `stockinmain`";		$db->Execute($sql);//入库单
$sql = "delete from `stockinmain_detail`";		$db->Execute($sql);
$sql = "delete from `stockinmain_detail_color`";		$db->Execute($sql);
$sql = "delete from `stockoutmain`";	$db->Execute($sql);//出库单
$sql = "delete from `stockoutmain_detail`";		$db->Execute($sql);
$sql = "delete from `store`";			$db->Execute($sql);//库存
$sql = "delete from `store_init`";		$db->Execute($sql);//库存初始化
$sql = "delete from `storecheck`";		$db->Execute($sql);//盘点单
$sql = "delete from `storecheck_detail`";		$db->Execute($sql);
$sql = "delete from `fukuanplan`";	$db->Execute($sql);//付款计划
$sql = "delete from `fukuanrecord`";	$db->Execute($sql);//付款记录
$sql = "delete from `shoupiaorecord`";	$db->Execute($sql);//收票记录
$sql = "delete from `huikuanplan`";	$db->Execute($sql);//回款计划
$sql = "delete from `huikuanrecord`";	$db->Execute($sql);//回款记录
$sql = "delete from `kaipiaorecord`";	$db->Execute($sql);//开票记录
$sql = "delete from `feiyongrecord`";	$db->Execute($sql);//收入开支
$sql = "delete from `accessprepay`";	$db->Execute($sql);//预付款
$sql = "delete from `accesspreshou`";	$db->Execute($sql);//预收款
$sql = "delete from `accessbank`";	$db->Execute($sql);//账户操作记录
$sql = "delete from `sms_sendlist`";	$db->Execute($sql);//手机短信
$sql = "delete from `commlog`";	$db->Execute($sql);//客户关怀
$sql = "delete from `crm_service`";	$db->Execute($sql);//客户服务
$sql = "delete from `crm_feiyong_sq`";	$db->Execute($sql);//客户费用
$sql = "delete from `bankzhuru`";	$db->Execute($sql);//资本注入
$sql = "delete from `email`";	$db->Execute($sql);//邮件
$sql = "delete from `notify`";	$db->Execute($sql);//公告
$sql = "delete from `crm_shenqingbaobei`";  $db->Execute($sql);//项目报备
$sql = "delete from `workplanmain`";  $db->Execute($sql);//工作计划
$sql = "delete from `workplanmain_detail`";  $db->Execute($sql);//工作计划
$sql = "delete from `crm_chance`";  $db->Execute($sql);//销售机会
$sql = "delete from `crm_contact`";  $db->Execute($sql);//跟踪记录
$sql = "delete from `customer_xuqiu`";  $db->Execute($sql);//详细需求
$sql = "delete from `customer_fangan`";  $db->Execute($sql);//解决方案
$sql = "delete from `competeproduct`";  $db->Execute($sql);//竞争产品
$sql = "delete from `customerproduct`";  $db->Execute($sql);//产品报价
$sql = "delete from `customerproduct_detail`";  $db->Execute($sql);
$sql = "delete from `sellcontract_jiaofu`";  $db->Execute($sql);//交付记录
table_begin("500");
print  "<tr class=\"TableControl\"> <td colspan=\"12\" align=center>相关数据表已经清空!<BR>&nbsp;&nbsp;<input type=button  value=返回 class=BigButton onClick=\"location='?'\" title=返回> </td></tr>";
table_end();
exit;
}
if($_GET['action']=="DeleteAllCust")								{

$sql = "delete from `customer`";		$db->Execute($sql);//客户资料
$sql = "delete from `linkman`";		$db->Execute($sql);
table_begin("500");
print  "<tr class=\"TableControl\"> <td colspan=\"12\" align=center>客户资料及联系人表已经清空!<BR>&nbsp;&nbsp;<input type=button  value=返回 class=BigButton onClick=\"location='?'\" title=返回> </td></tr>";
table_end();
exit;
}
if($_GET['action']=="DeleteAllSupply")								{

$sql = "delete from `supply`";		$db->Execute($sql);//供应商资料
$sql = "delete from `supplylinkman`";		$db->Execute($sql);
table_begin("500");
print  "<tr class=\"TableControl\"> <td colspan=\"12\" align=center>供应商及联系人表已经清空!<BR>&nbsp;&nbsp;<input type=button  value=返回 class=BigButton onClick=\"location='?'\" title=返回> </td></tr>";
table_end();
exit;
}
if($_GET['action']=="DeleteAllProduct")								{

$sql = "delete from `product`";		$db->Execute($sql);//供应商资料
$sql = "delete from `producttype`";		$db->Execute($sql);
table_begin("500");
print  "<tr class=\"TableControl\"> <td colspan=\"12\" align=center>商品库及商品类别表已经清空!<BR>&nbsp;&nbsp;<input type=button  value=返回 class=BigButton onClick=\"location='?'\" title=返回> </td></tr>";
table_end();
exit;
}
if($_GET['action']=="DeleteZeroKuCun")								{

$sql = "delete from `store` where num=0";		$db->Execute($sql);//零库存
table_begin("500");
print  "<tr class=\"TableControl\"> <td colspan=\"12\" align=center>库存中数量为0的记录已删除!<BR>&nbsp;&nbsp;<input type=button  value=返回 class=BigButton onClick=\"location='?'\" title=返回> </td></tr>";
table_end();
exit;
}

if($_GET['action']=="DeleteFeiQiDan")								{
$begintime=$_GET['begintime']." 0:00:00";
$endtime=$_GET['endtime']." 23:59:59";
$sql = "delete from `buyplanmain` where user_flag=-1"; //采购单
if($begintime!='')
	$sql.=" and createtime>='$begintime'";
if($endtime!='')
	$sql.=" and createtime<='$endtime'";
$db->Execute($sql);

$sql = "delete from `sellplanmain` where user_flag=-1";	//销售单	
if($begintime!='')
	$sql.=" and createtime>='$begintime'";
if($endtime!='')
	$sql.=" and createtime<='$endtime'";
$db->Execute($sql);

table_begin("500");
print  "<tr class=\"TableControl\"> <td colspan=\"12\" align=center>单据已彻底删除!<BR>&nbsp;&nbsp;<input type=button  value=返回 class=BigButton onClick=\"location='?'\" title=返回> </td></tr>";
table_end();
exit;
}

if($_GET['action']=="DeleteGongZuoBaoGao")								{
	$begintime=$_GET['begintime']." 0:00:00";
	$endtime=$_GET['endtime']." 23:59:59";
	$sql = "delete from `workreport` where state='已审核'"; //工作报告
	if($begintime!='')
		$sql.=" and createtime>='$begintime'";
	if($endtime!='')
		$sql.=" and createtime<='$endtime'";
	$db->Execute($sql);

	table_begin("500");
	print  "<tr class=\"TableControl\"> <td colspan=\"12\" align=center>已审核的工作报告已彻底删除!<BR>&nbsp;&nbsp;<input type=button  value=返回 class=BigButton onClick=\"location='?'\" title=返回> </td></tr>";
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
	//print "已经备份数据表：".$Tablename."<BR>";
	array_push($NewTableArray,$Tablename);
   //---------------- 获得DROP TABLE语句 -----------------------
   $TABLE_NAME=$TABLE[0];

   //--- 排除post_tel表 ---
   //if(stristr($TABLE_NAME,"post_tel"))
   //   continue;

   
   //---------------- 获得CREATE语句 -----------------------
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
fwrite($handle, $File_View);
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
	发行协议:数字化校园产品为商业软件,发行许可为LICENSE方式;单点<?php echo $IE_TITLE_NAME?>即Sunshine<?php echo $IE_TITLE_NAME?>为GPLV3协议许可,GPLV3协议许可内容请到百度搜索;
	特殊声明:软件所使用的ADODB库,PHPEXCEL库,SMTARY库归原作者所有,余下代码沿用上述声明;
	*/
?>