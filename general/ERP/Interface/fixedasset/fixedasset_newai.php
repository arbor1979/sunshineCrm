<?php
	require_once("lib.inc.php");

	$GLOBAL_SESSION=returnsession();
	require_once("systemprivateinc.php");

	CheckSystemPrivate("���ڹ���-�̶��ʲ�-ȫȨ�޹���");

	$common_html=returnsystemlang('common_html');

	if($_GET['action']==""||$_GET['action']=="init_default")		{
		$sql = "update fixedasset set ����״̬='����δ����' where ����״̬=''";
		$db->Execute($sql);
		//$sql = "update fixedasset set ���=����*����";
		//$db->Execute($sql);
	}

	if($_GET['action']=="edit_default_data")						{
		//print_R($_GET);print_R($_POST);exit;
		$_POST['����'] = number_format($_POST['����'], 2, '.', '');

		$��� = $_GET['���'];
		$���ʲ���� = $_POST['�ʲ����'];
		$ԭ�ʲ���� = returntablefield("fixedasset","���",$���,"�ʲ����");;
		$sql = "update fixedassetin set �ʲ����='$���ʲ����' where �ʲ����='$ԭ�ʲ����'";
		$db->Execute($sql);
		$sql = "update fixedassetout set �ʲ����='$���ʲ����' where �ʲ����='$ԭ�ʲ����'";
		$db->Execute($sql);
		$sql = "update fixedassettui set �ʲ����='$���ʲ����' where �ʲ����='$ԭ�ʲ����'";
		$db->Execute($sql);
		$sql = "update fixedassetbaofei set �ʲ����='$���ʲ����' where �ʲ����='$ԭ�ʲ����'";
		$db->Execute($sql);
		$sql = "update fixedassettiaoku set �ʲ����='$���ʲ����' where �ʲ����='$ԭ�ʲ����'";
		$db->Execute($sql);
		$sql = "update fixedassetweixiu set �ʲ����='$���ʲ����' where �ʲ����='$ԭ�ʲ����'";
		$db->Execute($sql);

		$sql = "update fixedasset set ����״̬='����δ����' where ����״̬=''";
		$db->Execute($sql);
		$sql = "update fixedasset set ���=����*����";
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
				page_css("���ϴ��Ĳ���EXCEL��ʽ���ļ�");
				print_nouploadfile("���ϴ��Ĳ���EXCEL��ʽ���ļ�!");
				exit;
			}
			//print $checkFileType;exit;
			if(!is_dir("FileCache")) mkdir("FileCache");
			$uploadfile_name = "FileCache/".$uploadfile_name;
			copy($_FILES['uploadfileXLS']['tmp_name'],$uploadfile_name);

			require_once "../../Framework/PHPExcelParser4/readExcel.php";

			$a = new ReadExcel($uploadfile_name);
			$tmp = $a->read();

			//���ж�ȡ������,ת��Ϊ���ж�ȡ������
			$MainData = $tmp[0];
			$ColumnNumber = sizeof(array_values($MainData));
			for($i=0;$i<$ColumnNumber;$i++)			{
				$ColumnArray = $MainData[$i];
				//print_R($ColumnArray);
				for($ii=0;$ii<sizeof($ColumnArray);$ii++)			{
					$ContentText[$ii][$i] = $ColumnArray[$ii];
				}
			}
			//���������ı�
			$ColumnNumber = sizeof(array_keys($ContentText));
			for($i=0;$i<$ColumnNumber;$i++)			{
				$ContentArray = $ContentText[$i];
				$ContentTextArray[] = join(',',$ContentArray);
				//print_R($ContentArray);
			}

			//print_r($ContentTextArray);
			//exit;

			//���ݶԽ���
			$file = $ContentTextArray;

			//##########################################################################
			//����ΪCSV��ʽ������
			//##########################################################################
			global $db;

			$FileData = $file;


			for($i=1;$i<=sizeof($FileData);$i++)			{ // Output data and prepare SQL instructions
				$row = $FileData[$i];
				$RowArray = explode(',',$row);
				$Element['�ʲ�����'] = $RowArray[0];//�����
				$Element['�ʲ����'] = $RowArray[1];//�豸���
				$Element['�ʲ�����'] = $RowArray[2];//�豸����
				$Element['����ͺ�'] = $RowArray[3];//�ͺ�
				$Element['����ͺ�'] = $RowArray[3].$RowArray[4];//���
				$Element['����']		= $RowArray[5];//����
				$Element['ʹ�ò���']	= $RowArray[6];//ʹ�õ�λ
				$Element['��λ']		= $RowArray[7];//����
				$Element['���']		= $RowArray[8];//���
				$Element['��Ӧ��']		= $RowArray[9];//����
				$Element['����״̬'] = $RowArray[10];//��״
				$Element['����ʱ��'] = $RowArray[11];//�Ǽ�����
				$Element['ƾ֤����'] = $RowArray[12];//ƾ֤��
				$Element['��Ʊ����'] = $RowArray[13];//��Ʊ��
				$Element['ʹ�÷���'] = $RowArray[14];//ʹ�÷���
				$Element['��������'] = $RowArray[15];//��������
				$Element['ʹ����Ա'] = $RowArray[16];//������
				$Element['���ղ���'] = $RowArray[17];//���ղ���
				$Element['������']		= $RowArray[18];//������
				$Element['��ŵص�']	= $RowArray[19];//��ŵص�
				$Element['��ע']		= $RowArray[20];//ժҪ
				$Element['��������'] = $RowArray[21];//��������
				$Element['��������'] = $RowArray[22];//������λ
				$Element['�ʲ����'] = $RowArray[23];//�ʲ����
				if($Element['����״̬']=="����")					{
					$Element['����״̬'] = "�ʲ��ѷ���";
				}
				else	{
					$Element['����״̬'] = "����δ����";
				}
				$Element['����'] = $Element['���']/$Element['����'];
				$Element['������'] = $_SESSION['LOGIN_USER_ID'];

				$ElementKeys	= array_keys($Element);
				$ElementValues	= array_values($Element);
				$sql	= "select COUNT(*) AS NUM from fixedasset where �ʲ����='".$Element['�ʲ����']."' and �ʲ�����='".$Element['�ʲ�����']."'";
				$rs		= $db->Execute($sql);
				$NUM	= $rs->fields['NUM'];
				if($NUM>0)												{
					$UpdateSQL = array();
					for($ix=0;$ix<sizeof($ElementKeys);$ix++)			{
						$KEY = $ElementKeys[$ix];
						$Value = $ElementValues[$ix];
						$UpdateSQL[] = "$KEY='$Value'";
					}
					$sql = "update fixedasset set ".join(",",$UpdateSQL)." where �ʲ����='".$Element['�ʲ����']."' and �ʲ�����='".$Element['�ʲ�����']."'";
				}
				else	{
					$sql = "insert into fixedasset(".join(",",$ElementKeys).") values('".join("','",$ElementValues)."');";
				}
				if($Element['�ʲ����']!="")		{
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
			//?action=classExamChange&sessionkey=&��������=2010-2011-��һѧ����ĩ����&ClassCode=����1002��----��ѵ&CourseCode=
			$����·����Ϣ = "";;
			$Insert_Text = "�������ݳɹ�:".(int)$Insert_RIGHT." �� ʧ��:".(int)$Insert_ERROR." ��";
			page_css("�������ݳɹ�");
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
								<font color=red >".$common_html['common_html']['importsuccess']."<BR><BR>$Insert_Text<BR><BR><input type=button accesskey='c' name='cancel' value=' ������� ' class=SmallButton onClick=\"location='?$����·����Ϣ'\" title='��ݼ�:ALT+c'></font>
								</td></tr><tr></table>";
			//print "<META HTTP-EQUIV=REFRESH CONTENT='2;URL=?$����·����Ϣ'>\n";
			exit;
		}
		else			{

			//print "ERROR!";
			page_css("��������");
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
				page_css("���ϴ��Ĳ���EXCEL��ʽ���ļ�");
				print_nouploadfile("���ϴ��Ĳ���EXCEL��ʽ���ļ�!");
				exit;
			}
			//print $checkFileType;exit;
			if(!is_dir("FileCache")) mkdir("FileCache");
			$uploadfile_name = "FileCache/".$uploadfile_name;
			copy($_FILES['uploadfileXLS']['tmp_name'],$uploadfile_name);

			require_once "../../Framework/PHPExcelParser4/readExcel.php";

			$a = new ReadExcel($uploadfile_name);
			$tmp = $a->read();

			//���ж�ȡ������,ת��Ϊ���ж�ȡ������
			$MainData = $tmp[0];
			$ColumnNumber = sizeof(array_values($MainData));
			for($i=0;$i<$ColumnNumber;$i++)			{
				$ColumnArray = $MainData[$i];
				//print_R($ColumnArray);
				for($ii=0;$ii<sizeof($ColumnArray);$ii++)			{
					$ContentText[$ii][$i] = $ColumnArray[$ii];
				}
			}
			//���������ı�
			$ColumnNumber = sizeof(array_keys($ContentText));
			for($i=0;$i<$ColumnNumber;$i++)			{
				$ContentArray = $ContentText[$i];
				$ContentTextArray[] = join(',',$ContentArray);
				//print_R($ContentArray);
			}

			//print_r($ContentTextArray);
			//exit;

			//���ݶԽ���
			$file = $ContentTextArray;

			//##########################################################################
			//����ΪCSV��ʽ������
			//##########################################################################
			global $db;

			$FileData = $file;


			for($i=1;$i<=sizeof($FileData);$i++)			{ // Output data and prepare SQL instructions
				$row = $FileData[$i];
				$RowArray = explode(',',$row);
				$Element['�ʲ�����'] = $RowArray[0];//�����
				$Element['�ʲ����'] = $RowArray[1];//�豸���
				$Element['�ʲ�����'] = $RowArray[2];//�豸����
				$Element['����ͺ�'] = $RowArray[3];//�ͺ�
				$Element['����ͺ�'] = $RowArray[3].$RowArray[4];//���
				$Element['����']		= $RowArray[5];//����
				$Element['ʹ�ò���']	= $RowArray[6];//ʹ�õ�λ
				$Element['��λ']		= $RowArray[7];//����
				$Element['���']		= $RowArray[8];//���
				$Element['��Ӧ��']		= $RowArray[9];//����
				$Element['����״̬'] = $RowArray[10];//��״
				$Element['����ʱ��'] = $RowArray[11];//�Ǽ�����
				$Element['ƾ֤����'] = $RowArray[12];//ƾ֤��
				$Element['��Ʊ����'] = $RowArray[13];//��Ʊ��
				$Element['ʹ�÷���'] = $RowArray[14];//ʹ�÷���
				$Element['��������'] = $RowArray[15];//��������
				$Element['ʹ����Ա'] = $RowArray[16];//������
				$Element['���ղ���'] = $RowArray[17];//���ղ���
				$Element['������']		= $RowArray[18];//������
				$Element['��ŵص�']	= $RowArray[22];//��ŵص� ������λ
				$Element['��ע']		= $RowArray[19];//ժҪ ��ŵص�
				$Element['��������'] = $RowArray[20];//�������� ժҪ
				$Element['��������'] = $RowArray[21];//������λ ��������
				$Element['�ʲ����'] = $RowArray[23];//�ʲ����
				if($Element['����״̬']=="����")					{
					$Element['����״̬'] = "�ʲ��ѷ���";
				}
				else	{
					$Element['����״̬'] = "����δ����";
				}
				$Element['����'] = $Element['���']/$Element['����'];
				$Element['������'] = $_SESSION['LOGIN_USER_ID'];

				$ElementKeys	= array_keys($Element);
				$ElementValues	= array_values($Element);
				$sql	= "select COUNT(*) AS NUM from fixedasset where �ʲ����='".$Element['�ʲ����']."' and �ʲ�����='".$Element['�ʲ�����']."'";
				$rs		= $db->Execute($sql);
				$NUM	= $rs->fields['NUM'];
				if($NUM>0)												{
					$UpdateSQL = array();
					for($ix=0;$ix<sizeof($ElementKeys);$ix++)			{
						$KEY = $ElementKeys[$ix];
						$Value = $ElementValues[$ix];
						$UpdateSQL[] = "$KEY='$Value'";
					}
					$sql = "update fixedasset set ".join(",",$UpdateSQL)." where �ʲ����='".$Element['�ʲ����']."' and �ʲ�����='".$Element['�ʲ�����']."'";
				}
				else	{
					$sql = "insert into fixedasset(".join(",",$ElementKeys).") values('".join("','",$ElementValues)."');";
				}
				if($Element['�ʲ����']!="")		{
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
			//?action=classExamChange&sessionkey=&��������=2010-2011-��һѧ����ĩ����&ClassCode=����1002��----��ѵ&CourseCode=
			$����·����Ϣ = "";;
			$Insert_Text = "�������ݳɹ�:".(int)$Insert_RIGHT." �� ʧ��:".(int)$Insert_ERROR." ��";
			page_css("�������ݳɹ�");
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
								<font color=red >".$common_html['common_html']['importsuccess']."<BR><BR>$Insert_Text<BR><BR><input type=button accesskey='c' name='cancel' value=' ������� ' class=SmallButton onClick=\"location='?$����·����Ϣ'\" title='��ݼ�:ALT+c'></font>
								</td></tr><tr></table>";
			//print "<META HTTP-EQUIV=REFRESH CONTENT='2;URL=?$����·����Ϣ'>\n";
			exit;
		}
		else			{

			//print "ERROR!";
			page_css("��������");
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
				page_css("���ϴ��Ĳ���EXCEL��ʽ���ļ�");
				print_nouploadfile("���ϴ��Ĳ���EXCEL��ʽ���ļ�!");
				exit;
			}
			//print $checkFileType;exit;
			if(!is_dir("FileCache")) mkdir("FileCache");
			$uploadfile_name = "FileCache/".$uploadfile_name;
			copy($_FILES['uploadfileXLS']['tmp_name'],$uploadfile_name);

			require_once "../../Framework/PHPExcelParser4/readExcel.php";

			$a = new ReadExcel($uploadfile_name);
			$tmp = $a->read();

			//���ж�ȡ������,ת��Ϊ���ж�ȡ������
			$MainData = $tmp[0];
			$ColumnNumber = sizeof(array_values($MainData));
			for($i=0;$i<$ColumnNumber;$i++)			{
				$ColumnArray = $MainData[$i];
				//print_R($ColumnArray);
				for($ii=0;$ii<sizeof($ColumnArray);$ii++)			{
					$ContentText[$ii][$i] = $ColumnArray[$ii];
				}
			}
			//���������ı�
			$ColumnNumber = sizeof(array_keys($ContentText));
			for($i=0;$i<$ColumnNumber;$i++)			{
				$ContentArray = $ContentText[$i];
				$ContentTextArray[] = join(',',$ContentArray);
				//print_R($ContentArray);
			}

			//print_r($ContentTextArray);
			//exit;

			//���ݶԽ���
			$file = $ContentTextArray;

			//##########################################################################
			//����ΪCSV��ʽ������
			//##########################################################################
			global $db;

			$FileData = $file;

//dump($FileData);//exit;
			for($i=1;$i<=sizeof($FileData);$i++)			{ // Output data and prepare SQL instructions
				$row = $FileData[$i];
				$RowArray = explode(',',$row);
				$Element['�ʲ�����'] = $RowArray[0];//�����
				$Element['�ʲ����'] = $RowArray[1];//�豸���
				$Element['�ʲ�����'] = $RowArray[2];//�豸����
				$Element['����ͺ�'] = $RowArray[3];//�ͺ�
				$Element['����ͺ�'] = $RowArray[3].$RowArray[4];//���
				$Element['����']		= $RowArray[5];//����
				$Element['ʹ�ò���']	= $RowArray[6];//ʹ�õ�λ
				$Element['��λ']		= $RowArray[7];//����
				$Element['���']		= $RowArray[8];//���
				$Element['��Ӧ��']		= $RowArray[9];//����
				$Element['����״̬'] = $RowArray[10];//��״
				$Element['����ʱ��'] = $RowArray[11];//�Ǽ�����
				$Element['ƾ֤����'] = $RowArray[12];//ƾ֤��
				$Element['��Ʊ����'] = $RowArray[13];//��Ʊ��
				$Element['ʹ�÷���'] = $RowArray[14];//ʹ�÷���
				$Element['��������'] = $RowArray[15];//��������
				$Element['ʹ����Ա'] = $RowArray[16];//������
				$Element['���ղ���'] = $RowArray[17];//���ղ���
				$Element['������']		= $RowArray[18];//������
				$Element['��ŵص�']	= $RowArray[22];//��ŵص� ������λ
				$Element['��ע']		= $RowArray[19];//ժҪ ��ŵص�
				$Element['��������'] = $RowArray[20];//�������� ժҪ
				$Element['��������'] = $RowArray[21];//������λ ��������
				$Element['�ʲ����'] = $RowArray[23];//�ʲ����
				if($Element['����״̬']=="����")					{
					$Element['����״̬'] = "�ʲ��ѷ���";
				}
				else	{
					$Element['����״̬'] = "����δ����";
				}
				$Element['����'] = $Element['���']/$Element['����'];
				$Element['������'] = $_SESSION['LOGIN_USER_ID'];
//dump($Element);exit;
				$ElementKeys	= array_keys($Element);
				$ElementValues	= array_values($Element);
				$sql	= "select COUNT(*) AS NUM from fixedasset where �ʲ����='".$Element['�ʲ����']."' and �ʲ�����='".$Element['�ʲ�����']."'";
				$rs		= $db->Execute($sql);
				$NUM	= $rs->fields['NUM'];
				if($NUM>0)												{
					$UpdateSQL = array();
					for($ix=0;$ix<sizeof($ElementKeys);$ix++)			{
						$KEY = $ElementKeys[$ix];
						$Value = $ElementValues[$ix];
						$UpdateSQL[] = "$KEY='$Value'";
					}
					$sql = "update fixedasset set ".join(",",$UpdateSQL)." where �ʲ����='".$Element['�ʲ����']."' and �ʲ�����='".$Element['�ʲ�����']."'";
				}
				else	{
					$sql = "insert into fixedasset(".join(",",$ElementKeys).") values('".join("','",$ElementValues)."');";
				}
				if($Element['�ʲ����']!="")		{
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
			//?action=classExamChange&sessionkey=&��������=2010-2011-��һѧ����ĩ����&ClassCode=����1002��----��ѵ&CourseCode=
			$����·����Ϣ = "";;
			$Insert_Text = "�������ݳɹ�:".(int)$Insert_RIGHT." �� ʧ��:".(int)$Insert_ERROR." ��";
			page_css("�������ݳɹ�");
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
								<font color=red >".$common_html['common_html']['importsuccess']."<BR><BR>$Insert_Text<BR><BR><input type=button accesskey='c' name='cancel' value=' ������� ' class=SmallButton onClick=\"location='?$����·����Ϣ'\" title='��ݼ�:ALT+c'></font>
								</td></tr><tr></table>";
			//print "<META HTTP-EQUIV=REFRESH CONTENT='2;URL=?$����·����Ϣ'>\n";
			exit;
		}
		else			{

			//print "ERROR!";
			page_css("��������");
			print_nouploadfile();
			exit;
		}
	}

	//exit;

if($_GET['action']=="add_default_data")		{
	//print_R($_GET);print_R($_POST);exit;
	$_POST['����'] = number_format($_POST['����'], 2, '.', '');
}

$SYSTEM_PRINT_SQL = 0;

$_GET['����״̬'] = "����δ����,�����ѷ���,�ʲ��ѷ���,�ʲ��ѹ黹";

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
<TD noWrap align=left >�豸�ļ����� EXCEL��ʽ�ļ�
<input name='uploadfileXLS' type=file size=25 class=SmallInput>
<input type="button" value="�ύ" class="SmallButton" onClick="temp_function3();">
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
<TD noWrap align=left >�Ҿ��ļ����� EXCEL��ʽ�ļ�
<input name='uploadfileXLS' type=file size=25 class=SmallInput>
<input type="button" value="�ύ" class="SmallButton" onClick="temp_function4();">
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
<TD noWrap align=left >����װ�ߵ��� EXCEL��ʽ�ļ�
<input name='uploadfileXLS' type=file size=25 class=SmallInput>
<input type="button" value="�ύ" class="SmallButton" onClick="temp_function5();">
</td></tr>
</table>
</form>
<?php
}

?>