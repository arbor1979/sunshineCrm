<?php
	require_once("lib.inc.php");

	$GLOBAL_SESSION=returnsession();
	require_once("systemprivateinc.php");

	CheckSystemPrivate("后勤管理-固定资产-全权限管理");

	$common_html=returnsystemlang('common_html');

	if($_GET['action']==""||$_GET['action']=="init_default")		{
		$sql = "update fixedasset set 所属状态='购置未分配' where 所属状态=''";
		$db->Execute($sql);
		//$sql = "update fixedasset set 金额=单价*数量";
		//$db->Execute($sql);
	}

	if($_GET['action']=="edit_default_data")						{
		//print_R($_GET);print_R($_POST);exit;
		$_POST['单价'] = number_format($_POST['单价'], 2, '.', '');

		$编号 = $_GET['编号'];
		$新资产编号 = $_POST['资产编号'];
		$原资产编号 = returntablefield("fixedasset","编号",$编号,"资产编号");;
		$sql = "update fixedassetin set 资产编号='$新资产编号' where 资产编号='$原资产编号'";
		$db->Execute($sql);
		$sql = "update fixedassetout set 资产编号='$新资产编号' where 资产编号='$原资产编号'";
		$db->Execute($sql);
		$sql = "update fixedassettui set 资产编号='$新资产编号' where 资产编号='$原资产编号'";
		$db->Execute($sql);
		$sql = "update fixedassetbaofei set 资产编号='$新资产编号' where 资产编号='$原资产编号'";
		$db->Execute($sql);
		$sql = "update fixedassettiaoku set 资产编号='$新资产编号' where 资产编号='$原资产编号'";
		$db->Execute($sql);
		$sql = "update fixedassetweixiu set 资产编号='$新资产编号' where 资产编号='$原资产编号'";
		$db->Execute($sql);

		$sql = "update fixedasset set 所属状态='购置未分配' where 所属状态=''";
		$db->Execute($sql);
		$sql = "update fixedasset set 金额=单价*数量";
		$db->Execute($sql);
	}


	//FJQX
	//&&$SYSTEM_VERSION_CONTENT=="FJQX"
	if($_GET['action']=="import3_default_data")						{
		global $_FILES;
		//print_R($_GET);
		//print_R($_POST);
		//print_R($_FILES);
		//print $_GET['action'];exit;
		if(is_uploaded_file($_FILES['uploadfileXLS']['tmp_name']))			{
			$uploadfile_self=$_FILES['uploadfileXLS']['tmp_name'];
			$uploadfile_name=$_FILES['uploadfileXLS']['name'];
			$checkFileType = substr($uploadfile_name,-3);
			if($checkFileType!="xls")	{
				page_css("你上传的不是EXCEL格式的文件");
				print_nouploadfile("你上传的不是EXCEL格式的文件!");
				exit;
			}
			//print $checkFileType;exit;
			if(!is_dir("FileCache")) mkdir("FileCache");
			$uploadfile_name = "FileCache/".$uploadfile_name;
			copy($_FILES['uploadfileXLS']['tmp_name'],$uploadfile_name);

			require_once "../../Framework/PHPExcelParser4/readExcel.php";

			$a = new ReadExcel($uploadfile_name);
			$tmp = $a->read();

			//按列读取的数据,转换为按行读取的数据
			$MainData = $tmp[0];
			$ColumnNumber = sizeof(array_values($MainData));
			for($i=0;$i<$ColumnNumber;$i++)			{
				$ColumnArray = $MainData[$i];
				//print_R($ColumnArray);
				for($ii=0;$ii<sizeof($ColumnArray);$ii++)			{
					$ContentText[$ii][$i] = $ColumnArray[$ii];
				}
			}
			//重新生成文本
			$ColumnNumber = sizeof(array_keys($ContentText));
			for($i=0;$i<$ColumnNumber;$i++)			{
				$ContentArray = $ContentText[$i];
				$ContentTextArray[] = join(',',$ContentArray);
				//print_R($ContentArray);
			}

			//print_r($ContentTextArray);
			//exit;

			//数据对接区
			$file = $ContentTextArray;

			//##########################################################################
			//以下为CSV格式处理区
			//##########################################################################
			global $db;

			$FileData = $file;


			for($i=1;$i<=sizeof($FileData);$i++)			{ // Output data and prepare SQL instructions
				$row = $FileData[$i];
				$RowArray = explode(',',$row);
				$Element['资产批次'] = $RowArray[0];//分类号
				$Element['资产编号'] = $RowArray[1];//设备编号
				$Element['资产名称'] = $RowArray[2];//设备名称
				$Element['规格型号'] = $RowArray[3];//型号
				$Element['规格型号'] = $RowArray[3].$RowArray[4];//规格
				$Element['数量']		= $RowArray[5];//数量
				$Element['使用部门']	= $RowArray[6];//使用单位
				$Element['单位']		= $RowArray[7];//计量
				$Element['金额']		= $RowArray[8];//金额
				$Element['供应商']		= $RowArray[9];//厂家
				$Element['所属状态'] = $RowArray[10];//现状
				$Element['创建时间'] = $RowArray[11];//登记日期
				$Element['凭证号码'] = $RowArray[12];//凭证号
				$Element['发票号码'] = $RowArray[13];//发票号
				$Element['使用方向'] = $RowArray[14];//使用方向
				$Element['购买日期'] = $RowArray[15];//购置日期
				$Element['使用人员'] = $RowArray[16];//领用人
				$Element['验收部门'] = $RowArray[17];//验收部门
				$Element['责任人']		= $RowArray[18];//责任人
				$Element['存放地点']	= $RowArray[19];//存放地点
				$Element['备注']		= $RowArray[20];//摘要
				$Element['启用日期'] = $RowArray[21];//启用日期
				$Element['所属部门'] = $RowArray[22];//二级单位
				$Element['资产类别'] = $RowArray[23];//资产类别
				if($Element['所属状态']=="在用")					{
					$Element['所属状态'] = "资产已分配";
				}
				else	{
					$Element['所属状态'] = "购置未分配";
				}
				$Element['单价'] = $Element['金额']/$Element['数量'];
				$Element['创建人'] = $_SESSION['LOGIN_USER_ID'];

				$ElementKeys	= array_keys($Element);
				$ElementValues	= array_values($Element);
				$sql	= "select COUNT(*) AS NUM from fixedasset where 资产编号='".$Element['资产编号']."' and 资产批次='".$Element['资产批次']."'";
				$rs		= $db->Execute($sql);
				$NUM	= $rs->fields['NUM'];
				if($NUM>0)												{
					$UpdateSQL = array();
					for($ix=0;$ix<sizeof($ElementKeys);$ix++)			{
						$KEY = $ElementKeys[$ix];
						$Value = $ElementValues[$ix];
						$UpdateSQL[] = "$KEY='$Value'";
					}
					$sql = "update fixedasset set ".join(",",$UpdateSQL)." where 资产编号='".$Element['资产编号']."' and 资产批次='".$Element['资产批次']."'";
				}
				else	{
					$sql = "insert into fixedasset(".join(",",$ElementKeys).") values('".join("','",$ElementValues)."');";
				}
				if($Element['资产编号']!="")		{
					$rs = $db->Execute($sql);
					if($rs->EOF)		{
						$Insert_RIGHT++;
					}
					else	{
						$Insert_ERROR++;
					}
					//print $sql."<BR>";
				}


			}
			//exit;
			//print_R($_POST);
			//delete file
			//unlink($uploadfile_name);
			//?action=classExamChange&sessionkey=&考试名称=2010-2011-第一学期期末考试&ClassCode=电子1002班----军训&CourseCode=
			$返回路径信息 = "";;
			$Insert_Text = "处理数据成功:".(int)$Insert_RIGHT." 条 失败:".(int)$Insert_ERROR." 条";
			page_css("处理数据成功");
			print "<style type='text/css'>.style1 {
								color: #FFFFFF;
								font-weight: bold;
								font-family: Arial, Helvetica, sans-serif;
								font-size: 14px;
								}
								</style>
								<BR><BR>
								<table width='450'  border='0' align='center' cellpadding='0' cellspacing='0' class='small' style='border:1px solid #006699;'>
								<tr><td height='110' align='middle' colspan=2  bgcolor='#E0F2FC'>
								<font color=red >".$common_html['common_html']['importsuccess']."<BR><BR>$Insert_Text<BR><BR><input type=button accesskey='c' name='cancel' value=' 点击返回 ' class=SmallButton onClick=\"location='?$返回路径信息'\" title='快捷键:ALT+c'></font>
								</td></tr><tr></table>";
			//print "<META HTTP-EQUIV=REFRESH CONTENT='2;URL=?$返回路径信息'>\n";
			exit;
		}
		else			{

			//print "ERROR!";
			page_css("处理数据");
			print_nouploadfile();
			exit;
		}
	}




		//&&$SYSTEM_VERSION_CONTENT=="FJQX"
		if($_GET['action']=="import4_default_data")						{
		global $_FILES;
		//print_R($_GET);
		//print_R($_POST);
		//print_R($_FILES);
		//print $_GET['action'];exit;
		if(is_uploaded_file($_FILES['uploadfileXLS']['tmp_name']))			{
			$uploadfile_self=$_FILES['uploadfileXLS']['tmp_name'];
			$uploadfile_name=$_FILES['uploadfileXLS']['name'];
			$checkFileType = substr($uploadfile_name,-3);
			if($checkFileType!="xls")	{
				page_css("你上传的不是EXCEL格式的文件");
				print_nouploadfile("你上传的不是EXCEL格式的文件!");
				exit;
			}
			//print $checkFileType;exit;
			if(!is_dir("FileCache")) mkdir("FileCache");
			$uploadfile_name = "FileCache/".$uploadfile_name;
			copy($_FILES['uploadfileXLS']['tmp_name'],$uploadfile_name);

			require_once "../../Framework/PHPExcelParser4/readExcel.php";

			$a = new ReadExcel($uploadfile_name);
			$tmp = $a->read();

			//按列读取的数据,转换为按行读取的数据
			$MainData = $tmp[0];
			$ColumnNumber = sizeof(array_values($MainData));
			for($i=0;$i<$ColumnNumber;$i++)			{
				$ColumnArray = $MainData[$i];
				//print_R($ColumnArray);
				for($ii=0;$ii<sizeof($ColumnArray);$ii++)			{
					$ContentText[$ii][$i] = $ColumnArray[$ii];
				}
			}
			//重新生成文本
			$ColumnNumber = sizeof(array_keys($ContentText));
			for($i=0;$i<$ColumnNumber;$i++)			{
				$ContentArray = $ContentText[$i];
				$ContentTextArray[] = join(',',$ContentArray);
				//print_R($ContentArray);
			}

			//print_r($ContentTextArray);
			//exit;

			//数据对接区
			$file = $ContentTextArray;

			//##########################################################################
			//以下为CSV格式处理区
			//##########################################################################
			global $db;

			$FileData = $file;


			for($i=1;$i<=sizeof($FileData);$i++)			{ // Output data and prepare SQL instructions
				$row = $FileData[$i];
				$RowArray = explode(',',$row);
				$Element['资产批次'] = $RowArray[0];//分类号
				$Element['资产编号'] = $RowArray[1];//设备编号
				$Element['资产名称'] = $RowArray[2];//设备名称
				$Element['规格型号'] = $RowArray[3];//型号
				$Element['规格型号'] = $RowArray[3].$RowArray[4];//规格
				$Element['数量']		= $RowArray[5];//数量
				$Element['使用部门']	= $RowArray[6];//使用单位
				$Element['单位']		= $RowArray[7];//计量
				$Element['金额']		= $RowArray[8];//金额
				$Element['供应商']		= $RowArray[9];//厂家
				$Element['所属状态'] = $RowArray[10];//现状
				$Element['创建时间'] = $RowArray[11];//登记日期
				$Element['凭证号码'] = $RowArray[12];//凭证号
				$Element['发票号码'] = $RowArray[13];//发票号
				$Element['使用方向'] = $RowArray[14];//使用方向
				$Element['购买日期'] = $RowArray[15];//购置日期
				$Element['使用人员'] = $RowArray[16];//领用人
				$Element['验收部门'] = $RowArray[17];//验收部门
				$Element['责任人']		= $RowArray[18];//责任人
				$Element['存放地点']	= $RowArray[22];//存放地点 二级单位
				$Element['备注']		= $RowArray[19];//摘要 存放地点
				$Element['启用日期'] = $RowArray[20];//启用日期 摘要
				$Element['所属部门'] = $RowArray[21];//二级单位 启用日期
				$Element['资产类别'] = $RowArray[23];//资产类别
				if($Element['所属状态']=="在用")					{
					$Element['所属状态'] = "资产已分配";
				}
				else	{
					$Element['所属状态'] = "购置未分配";
				}
				$Element['单价'] = $Element['金额']/$Element['数量'];
				$Element['创建人'] = $_SESSION['LOGIN_USER_ID'];

				$ElementKeys	= array_keys($Element);
				$ElementValues	= array_values($Element);
				$sql	= "select COUNT(*) AS NUM from fixedasset where 资产编号='".$Element['资产编号']."' and 资产批次='".$Element['资产批次']."'";
				$rs		= $db->Execute($sql);
				$NUM	= $rs->fields['NUM'];
				if($NUM>0)												{
					$UpdateSQL = array();
					for($ix=0;$ix<sizeof($ElementKeys);$ix++)			{
						$KEY = $ElementKeys[$ix];
						$Value = $ElementValues[$ix];
						$UpdateSQL[] = "$KEY='$Value'";
					}
					$sql = "update fixedasset set ".join(",",$UpdateSQL)." where 资产编号='".$Element['资产编号']."' and 资产批次='".$Element['资产批次']."'";
				}
				else	{
					$sql = "insert into fixedasset(".join(",",$ElementKeys).") values('".join("','",$ElementValues)."');";
				}
				if($Element['资产编号']!="")		{
					$rs = $db->Execute($sql);
					if($rs->EOF)		{
						$Insert_RIGHT++;
					}
					else	{
						$Insert_ERROR++;
					}
					//print $sql."<BR>";
				}


			}
			//exit;
			//print_R($_POST);
			//delete file
			//unlink($uploadfile_name);
			//?action=classExamChange&sessionkey=&考试名称=2010-2011-第一学期期末考试&ClassCode=电子1002班----军训&CourseCode=
			$返回路径信息 = "";;
			$Insert_Text = "处理数据成功:".(int)$Insert_RIGHT." 条 失败:".(int)$Insert_ERROR." 条";
			page_css("处理数据成功");
			print "<style type='text/css'>.style1 {
								color: #FFFFFF;
								font-weight: bold;
								font-family: Arial, Helvetica, sans-serif;
								font-size: 14px;
								}
								</style>
								<BR><BR>
								<table width='450'  border='0' align='center' cellpadding='0' cellspacing='0' class='small' style='border:1px solid #006699;'>
								<tr><td height='110' align='middle' colspan=2  bgcolor='#E0F2FC'>
								<font color=red >".$common_html['common_html']['importsuccess']."<BR><BR>$Insert_Text<BR><BR><input type=button accesskey='c' name='cancel' value=' 点击返回 ' class=SmallButton onClick=\"location='?$返回路径信息'\" title='快捷键:ALT+c'></font>
								</td></tr><tr></table>";
			//print "<META HTTP-EQUIV=REFRESH CONTENT='2;URL=?$返回路径信息'>\n";
			exit;
		}
		else			{

			//print "ERROR!";
			page_css("处理数据");
			print_nouploadfile();
			exit;
		}
	}

	if($_GET['action']=="import5_default_data")						{
		global $_FILES;
		//print_R($_GET);
		//print_R($_POST);
		//print_R($_FILES);
		//print $_GET['action'];exit;
		if(is_uploaded_file($_FILES['uploadfileXLS']['tmp_name']))			{
			$uploadfile_self=$_FILES['uploadfileXLS']['tmp_name'];
			$uploadfile_name=$_FILES['uploadfileXLS']['name'];
			$checkFileType = substr($uploadfile_name,-3);
			if($checkFileType!="xls")	{
				page_css("你上传的不是EXCEL格式的文件");
				print_nouploadfile("你上传的不是EXCEL格式的文件!");
				exit;
			}
			//print $checkFileType;exit;
			if(!is_dir("FileCache")) mkdir("FileCache");
			$uploadfile_name = "FileCache/".$uploadfile_name;
			copy($_FILES['uploadfileXLS']['tmp_name'],$uploadfile_name);

			require_once "../../Framework/PHPExcelParser4/readExcel.php";

			$a = new ReadExcel($uploadfile_name);
			$tmp = $a->read();

			//按列读取的数据,转换为按行读取的数据
			$MainData = $tmp[0];
			$ColumnNumber = sizeof(array_values($MainData));
			for($i=0;$i<$ColumnNumber;$i++)			{
				$ColumnArray = $MainData[$i];
				//print_R($ColumnArray);
				for($ii=0;$ii<sizeof($ColumnArray);$ii++)			{
					$ContentText[$ii][$i] = $ColumnArray[$ii];
				}
			}
			//重新生成文本
			$ColumnNumber = sizeof(array_keys($ContentText));
			for($i=0;$i<$ColumnNumber;$i++)			{
				$ContentArray = $ContentText[$i];
				$ContentTextArray[] = join(',',$ContentArray);
				//print_R($ContentArray);
			}

			//print_r($ContentTextArray);
			//exit;

			//数据对接区
			$file = $ContentTextArray;

			//##########################################################################
			//以下为CSV格式处理区
			//##########################################################################
			global $db;

			$FileData = $file;

//dump($FileData);//exit;
			for($i=1;$i<=sizeof($FileData);$i++)			{ // Output data and prepare SQL instructions
				$row = $FileData[$i];
				$RowArray = explode(',',$row);
				$Element['资产批次'] = $RowArray[0];//分类号
				$Element['资产编号'] = $RowArray[1];//设备编号
				$Element['资产名称'] = $RowArray[2];//设备名称
				$Element['规格型号'] = $RowArray[3];//型号
				$Element['规格型号'] = $RowArray[3].$RowArray[4];//规格
				$Element['数量']		= $RowArray[5];//数量
				$Element['使用部门']	= $RowArray[6];//使用单位
				$Element['单位']		= $RowArray[7];//计量
				$Element['金额']		= $RowArray[8];//金额
				$Element['供应商']		= $RowArray[9];//厂家
				$Element['所属状态'] = $RowArray[10];//现状
				$Element['创建时间'] = $RowArray[11];//登记日期
				$Element['凭证号码'] = $RowArray[12];//凭证号
				$Element['发票号码'] = $RowArray[13];//发票号
				$Element['使用方向'] = $RowArray[14];//使用方向
				$Element['购买日期'] = $RowArray[15];//购置日期
				$Element['使用人员'] = $RowArray[16];//领用人
				$Element['验收部门'] = $RowArray[17];//验收部门
				$Element['责任人']		= $RowArray[18];//责任人
				$Element['存放地点']	= $RowArray[22];//存放地点 二级单位
				$Element['备注']		= $RowArray[19];//摘要 存放地点
				$Element['启用日期'] = $RowArray[20];//启用日期 摘要
				$Element['所属部门'] = $RowArray[21];//二级单位 启用日期
				$Element['资产类别'] = $RowArray[23];//资产类别
				if($Element['所属状态']=="在用")					{
					$Element['所属状态'] = "资产已分配";
				}
				else	{
					$Element['所属状态'] = "购置未分配";
				}
				$Element['单价'] = $Element['金额']/$Element['数量'];
				$Element['创建人'] = $_SESSION['LOGIN_USER_ID'];
//dump($Element);exit;
				$ElementKeys	= array_keys($Element);
				$ElementValues	= array_values($Element);
				$sql	= "select COUNT(*) AS NUM from fixedasset where 资产编号='".$Element['资产编号']."' and 资产批次='".$Element['资产批次']."'";
				$rs		= $db->Execute($sql);
				$NUM	= $rs->fields['NUM'];
				if($NUM>0)												{
					$UpdateSQL = array();
					for($ix=0;$ix<sizeof($ElementKeys);$ix++)			{
						$KEY = $ElementKeys[$ix];
						$Value = $ElementValues[$ix];
						$UpdateSQL[] = "$KEY='$Value'";
					}
					$sql = "update fixedasset set ".join(",",$UpdateSQL)." where 资产编号='".$Element['资产编号']."' and 资产批次='".$Element['资产批次']."'";
				}
				else	{
					$sql = "insert into fixedasset(".join(",",$ElementKeys).") values('".join("','",$ElementValues)."');";
				}
				if($Element['资产编号']!="")		{
					$rs = $db->Execute($sql);
					if($rs->EOF)		{
						$Insert_RIGHT++;
					}
					else	{
						$Insert_ERROR++;
					}
					//print $sql."<BR>";
				}


			}
			//exit;
			//print_R($_POST);
			//delete file
			//unlink($uploadfile_name);
			//?action=classExamChange&sessionkey=&考试名称=2010-2011-第一学期期末考试&ClassCode=电子1002班----军训&CourseCode=
			$返回路径信息 = "";;
			$Insert_Text = "处理数据成功:".(int)$Insert_RIGHT." 条 失败:".(int)$Insert_ERROR." 条";
			page_css("处理数据成功");
			print "<style type='text/css'>.style1 {
								color: #FFFFFF;
								font-weight: bold;
								font-family: Arial, Helvetica, sans-serif;
								font-size: 14px;
								}
								</style>
								<BR><BR>
								<table width='450'  border='0' align='center' cellpadding='0' cellspacing='0' class='small' style='border:1px solid #006699;'>
								<tr><td height='110' align='middle' colspan=2  bgcolor='#E0F2FC'>
								<font color=red >".$common_html['common_html']['importsuccess']."<BR><BR>$Insert_Text<BR><BR><input type=button accesskey='c' name='cancel' value=' 点击返回 ' class=SmallButton onClick=\"location='?$返回路径信息'\" title='快捷键:ALT+c'></font>
								</td></tr><tr></table>";
			//print "<META HTTP-EQUIV=REFRESH CONTENT='2;URL=?$返回路径信息'>\n";
			exit;
		}
		else			{

			//print "ERROR!";
			page_css("处理数据");
			print_nouploadfile();
			exit;
		}
	}

	//exit;

if($_GET['action']=="add_default_data")		{
	//print_R($_GET);print_R($_POST);exit;
	$_POST['单价'] = number_format($_POST['单价'], 2, '.', '');
}

$SYSTEM_PRINT_SQL = 0;

$_GET['所属状态'] = "购置未分配,购置已分配,资产已分配,资产已归还";

$filetablename='fixedasset';
require_once('include.inc.php');

//
if(			$_GET['action']=="init_default"&&$SYSTEM_VERSION_CONTENT=="FJQX"
			)			{
?>
<FORM name=form3 action="?action=import3_default_data" method=post encType=multipart/form-data>
<input type=hidden name=hidden_str value=''>
<script >
function temp_function3()
{
	selectid_str="";
	form3.hidden_str.value=selectid_str;
	form3.submit();
}
</script>
<table class=TableBlock align=left width=100% >
<TR class=TableContent>
<TD noWrap align=left >设备文件导入 EXCEL格式文件
<input name='uploadfileXLS' type=file size=25 class=SmallInput>
<input type="button" value="提交" class="SmallButton" onClick="temp_function3();">
</td></tr>
</table>
</form>
<BR><BR><BR>
<FORM name=form4 action="?action=import4_default_data" method=post encType=multipart/form-data>
<input type=hidden name=hidden_str value=''>
<script >
function temp_function4()
{
	selectid_str="";
	form4.hidden_str.value=selectid_str;
	form4.submit();
}
</script>
<table class=TableBlock align=left width=100% >
<TR class=TableContent>
<TD noWrap align=left >家具文件导入 EXCEL格式文件
<input name='uploadfileXLS' type=file size=25 class=SmallInput>
<input type="button" value="提交" class="SmallButton" onClick="temp_function4();">
</td></tr>
</table>
</form>
<BR><BR><BR>

<FORM name=form5 action="?action=import5_default_data" method=post encType=multipart/form-data>
<input type=hidden name=hidden_str value=''>
<script >
function temp_function5()
{
	selectid_str="";
	form5.hidden_str.value=selectid_str;
	form5.submit();
}
</script>
<table class=TableBlock align=left width=100% >
<TR class=TableContent>
<TD noWrap align=left >被服装具导入 EXCEL格式文件
<input name='uploadfileXLS' type=file size=25 class=SmallInput>
<input type="button" value="提交" class="SmallButton" onClick="temp_function5();">
</td></tr>
</table>
</form>
<?php
}

?>