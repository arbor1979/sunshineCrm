<?php
require_once('lib.inc.php');

if($_GET['pageAction']!="write")	
{
	
	$GLOBAL_SESSION=returnsession();
}
else		{
	
}

//��������
if($_GET['pageAction']=="ExportDataToFile")			
{
	if($_GET['������ʽ']=="ȫ��")
	{
		$PHP_SELF = $_SERVER['PHP_SELF'];
		$PHP_SELF_ARRAY = explode('/',$_SERVER['PHP_SELF']);
		$FILE_NAME = array_pop($PHP_SELF_ARRAY);
		$PHP_SELF = @join('/',$PHP_SELF_ARRAY);
		$filename = "FileCache/".$FILE_NAME."_".date("Y-m-d-H").".xls";			
		$hostname = "http://".$_SERVER['SERVER_NAME'].":".$_SERVER['SERVER_PORT']."".$PHP_SELF."/$FILE_NAME?action=".$_GET['action']."&�������=".$_GET['�������']."&�����=".$_GET['�����']."&�Ƿ��������=".$_GET['�Ƿ��������']."&�����Ƿ���=".$_GET['�����Ƿ���']."&pageAction=write";
		$file = file($hostname);
		$FILE_CONTENT = join('',$file);
		@$handle = fopen($filename, 'w');
		@fwrite($handle, $FILE_CONTENT);
		fclose($handle);

		header('Content-Encoding: none');
		header('Content-Type: application/octetstream');
		header('Content-Disposition: attachment;filename=ʳ�ù���.xls');
		header('Content-Length: '.strlen($FILE_CONTENT));
		header('Pragma: no-cache');
		header('Expires: 0');
		echo $FILE_CONTENT;
		exit;
	}
	else if($_GET['������ʽ']=="�ض�")
	{
		
		echo a;
		exit;
	}
}

if($LOGIN_THEME!="") $LOGIN_THEME_TEXT = $LOGIN_THEME; 
else	$LOGIN_THEME_TEXT = '3';

print "<TITLE>ʳ����Ϣ����</TITLE>
<META http-equiv=Content-Type content=\"text/html; charset=gb2312\">
<LINK href=\"".ROOT_DIR."theme/$LOGIN_THEME_TEXT/style.css\" type=text/css rel=stylesheet>
<script type=\"text/javascript\" language=\"javascript\" src=\"".ROOT_DIR."general/EDU/Enginee/lib/common.js\"></script><STYLE>@media print{input{display:none}}</STYLE>
<BODY class=bodycolor topMargin=5 >";


//������Ҫ�������������
if($_GET['action']=="StaticAll")
{
	//print_r($_GET);
	$������� = $_GET['�������'];
	$����� = $_GET['�����'];
	$�Ƿ�������� = $_GET['�Ƿ��������'];
    $�����Ƿ��� = $_GET['�����Ƿ���'];
	

	$sql = "select * from edu_shitangjiance where �������='".$�������."' and �Ƿ��������='".$�Ƿ��������."' and �����Ƿ���='".$�����Ƿ���."' and �����='$�����'";
	//print $sql;
	$rs = $db -> Execute($sql);
	$rs_a= $rs -> GetArray();
	
	print "<H2 align=center>".$��������."��ϸ</H2>";
	print "<Table border=0 width='100%' class=TableBlock>";
	print "<Tr class=TableHeader>";
	print "<Td align=center>�������</Td><Td align=center>���ʳ��</Td><Td align=center>�Ƿ��������</Td><Td align=center>��������</Td><Td align=center>�����Ƿ���</Td><Td align=center>�����</Td>";
	print "</Tr>";
 	for($i=0;$i<sizeof($rs_a);$i++)
	{

		print "<Tr class=TableData>";
		print "<Td align=center>".$rs_a[$i]['�������']."</Td>";
		print "<Td align=center>".$rs_a[$i]['���ʳ��']."</Td>";
		print "<Td align=center>".$rs_a[$i]['�Ƿ��������']."</Td>";
		print "<Td align=center>".$rs_a[$i]['��������']."</Td>";
		print "<Td align=center>".$rs_a[$i]['�����Ƿ���']."</Td>";
		print "<Td align=center>".$rs_a[$i]['�����']."</Td>";
		print "</Tr>";
	}
	print "</Table><BR>";
	print "<div align=center width=200>";
?>
	<Input type="button" name="return" value="�� ��" class=SmallButton onClick="location='?';">	
	&nbsp;
	<Input type="button" name="return" value="�� ��" class=SmallButton onClick="location='?action=<?php echo $_GET['action']?>&pageAction=ExportDataToFile&������ʽ=ȫ��&�������=<?php echo $�������?>&�����=<?php echo $�����?>&�Ƿ��������=<?php echo $�Ƿ��������?>&�����Ƿ���=<?php echo $�����Ƿ���?>';">
	
<?php
	print "</div>";
}

//��ʼ���� ��ѯ���� �Ͱ�ť��
if($_GET['action']=="")
{
	//�������
	$sql = "select * from edu_shitangjcleixing";
	$rs = $db -> Execute($sql);
	$rs_a = $rs -> GetArray();
	if(!is_array($rs_a))
		$rs_a = array();
	$�������Array = $rs_a;

	//�����
	$sql = "select * from edu_shitangjcjieguo";
	$rs = $db -> Execute($sql);
	$rs_a = $rs -> GetArray();
	if(!is_array($rs_a))
		$rs_a = array();
	$�����Array = $rs_a;

	print "<Table border=0 width='100%' class=TableBlock>
			<Tr class=TableHeader>
				<Td valign=bottom align=left colspan=2>&nbsp;ʳ�ù����ѯ
				</Td>
			</Tr>";
	print  "<Tr class=TableData>
				<Td align=center>
				<Form name=form1 method=get>
				<BR>";
		print	"<Label>������ͣ�&nbsp;</Label>";
		print   "<Select class=SmallSelect name='�������'>";
					for($i=0;$i<sizeof($�������Array);$i++)
					{
						$������� = $�������Array[$i]['�������'];
						print "<Option value=".$�������." $Selected>".$�������."</Option>";
					}
		print	"</Select>&nbsp;&nbsp;";

		//��������
		print	"<Label>�������&nbsp;</Label>";
		print	"<Select class=SmallSelect name='�����'>";
					for($i=0;$i<sizeof($�����Array);$i++)
					{
						$����� = $�����Array[$i]['�����'];
						print "<Option value=".$�����." selected>".$�����."</Option>";
					}
		print	"</Select>&nbsp;&nbsp;";
		//��������
		print	"<Label>�Ƿ�������⣺&nbsp;</Label>";
		print	"<Select class=SmallSelect name='�Ƿ��������'>";
						print "<Option value='��' selected>��</Option>";
					    print "<Option value='��' selected>��</Option>";
		print	"</Select>&nbsp;&nbsp;";
		print	"<Label>�����Ƿ�����&nbsp;</Label>";
		print	"<Select class=SmallSelect name='�����Ƿ���'>";
						print "<Option value='��' selected>��</Option>";
					    print "<Option value='��' selected>��</Option>";
		print	"</Select>
				&nbsp;&nbsp;<input type=submit class=SmallButton value='�� ѯ'>
				<input type=hidden name='action' value='StaticAll'/>
				<BR><BR>";
		print	"</Form>";	
		print	"</Td></Tr>
		</Table>";
}
?>