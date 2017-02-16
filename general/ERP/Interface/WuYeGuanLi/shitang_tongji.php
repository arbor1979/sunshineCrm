<?php
require_once('lib.inc.php');

if($_GET['pageAction']!="write")	
{
	
	$GLOBAL_SESSION=returnsession();
}
else		{
	
}

//导出数据
if($_GET['pageAction']=="ExportDataToFile")			
{
	if($_GET['导出方式']=="全部")
	{
		$PHP_SELF = $_SERVER['PHP_SELF'];
		$PHP_SELF_ARRAY = explode('/',$_SERVER['PHP_SELF']);
		$FILE_NAME = array_pop($PHP_SELF_ARRAY);
		$PHP_SELF = @join('/',$PHP_SELF_ARRAY);
		$filename = "FileCache/".$FILE_NAME."_".date("Y-m-d-H").".xls";			
		$hostname = "http://".$_SERVER['SERVER_NAME'].":".$_SERVER['SERVER_PORT']."".$PHP_SELF."/$FILE_NAME?action=".$_GET['action']."&检测类型=".$_GET['检测类型']."&检测结果=".$_GET['检测结果']."&是否存在问题=".$_GET['是否存在问题']."&问题是否解决=".$_GET['问题是否解决']."&pageAction=write";
		$file = file($hostname);
		$FILE_CONTENT = join('',$file);
		@$handle = fopen($filename, 'w');
		@fwrite($handle, $FILE_CONTENT);
		fclose($handle);

		header('Content-Encoding: none');
		header('Content-Type: application/octetstream');
		header('Content-Disposition: attachment;filename=食堂管理.xls');
		header('Content-Length: '.strlen($FILE_CONTENT));
		header('Pragma: no-cache');
		header('Expires: 0');
		echo $FILE_CONTENT;
		exit;
	}
	else if($_GET['导出方式']=="特定")
	{
		
		echo a;
		exit;
	}
}

if($LOGIN_THEME!="") $LOGIN_THEME_TEXT = $LOGIN_THEME; 
else	$LOGIN_THEME_TEXT = '3';

print "<TITLE>食堂信息管理</TITLE>
<META http-equiv=Content-Type content=\"text/html; charset=gb2312\">
<LINK href=\"".ROOT_DIR."theme/$LOGIN_THEME_TEXT/style.css\" type=text/css rel=stylesheet>
<script type=\"text/javascript\" language=\"javascript\" src=\"".ROOT_DIR."general/EDU/Enginee/lib/common.js\"></script><STYLE>@media print{input{display:none}}</STYLE>
<BODY class=bodycolor topMargin=5 >";


//按条件要求检索生活补助情况
if($_GET['action']=="StaticAll")
{
	//print_r($_GET);
	$检测类型 = $_GET['检测类型'];
	$检测结果 = $_GET['检测结果'];
	$是否存在问题 = $_GET['是否存在问题'];
    $问题是否解决 = $_GET['问题是否解决'];
	

	$sql = "select * from edu_shitangjiance where 检测类型='".$检测类型."' and 是否存在问题='".$是否存在问题."' and 问题是否解决='".$问题是否解决."' and 检测结果='$检测结果'";
	//print $sql;
	$rs = $db -> Execute($sql);
	$rs_a= $rs -> GetArray();
	
	print "<H2 align=center>".$补助名称."明细</H2>";
	print "<Table border=0 width='100%' class=TableBlock>";
	print "<Tr class=TableHeader>";
	print "<Td align=center>检测类型</Td><Td align=center>检测食堂</Td><Td align=center>是否存在问题</Td><Td align=center>存在问题</Td><Td align=center>问题是否解决</Td><Td align=center>检测结果</Td>";
	print "</Tr>";
 	for($i=0;$i<sizeof($rs_a);$i++)
	{

		print "<Tr class=TableData>";
		print "<Td align=center>".$rs_a[$i]['检测类型']."</Td>";
		print "<Td align=center>".$rs_a[$i]['检测食堂']."</Td>";
		print "<Td align=center>".$rs_a[$i]['是否存在问题']."</Td>";
		print "<Td align=center>".$rs_a[$i]['存在问题']."</Td>";
		print "<Td align=center>".$rs_a[$i]['问题是否解决']."</Td>";
		print "<Td align=center>".$rs_a[$i]['检测结果']."</Td>";
		print "</Tr>";
	}
	print "</Table><BR>";
	print "<div align=center width=200>";
?>
	<Input type="button" name="return" value="返 回" class=SmallButton onClick="location='?';">	
	&nbsp;
	<Input type="button" name="return" value="导 出" class=SmallButton onClick="location='?action=<?php echo $_GET['action']?>&pageAction=ExportDataToFile&导出方式=全部&检测类型=<?php echo $检测类型?>&检测结果=<?php echo $检测结果?>&是否存在问题=<?php echo $是否存在问题?>&问题是否解决=<?php echo $问题是否解决?>';">
	
<?php
	print "</div>";
}

//初始界面 查询条件 和按钮！
if($_GET['action']=="")
{
	//监测类型
	$sql = "select * from edu_shitangjcleixing";
	$rs = $db -> Execute($sql);
	$rs_a = $rs -> GetArray();
	if(!is_array($rs_a))
		$rs_a = array();
	$检测类型Array = $rs_a;

	//监测结果
	$sql = "select * from edu_shitangjcjieguo";
	$rs = $db -> Execute($sql);
	$rs_a = $rs -> GetArray();
	if(!is_array($rs_a))
		$rs_a = array();
	$检测结果Array = $rs_a;

	print "<Table border=0 width='100%' class=TableBlock>
			<Tr class=TableHeader>
				<Td valign=bottom align=left colspan=2>&nbsp;食堂管理查询
				</Td>
			</Tr>";
	print  "<Tr class=TableData>
				<Td align=center>
				<Form name=form1 method=get>
				<BR>";
		print	"<Label>检测类型：&nbsp;</Label>";
		print   "<Select class=SmallSelect name='检测类型'>";
					for($i=0;$i<sizeof($检测类型Array);$i++)
					{
						$检测名称 = $检测类型Array[$i]['检测名称'];
						print "<Option value=".$检测名称." $Selected>".$检测名称."</Option>";
					}
		print	"</Select>&nbsp;&nbsp;";

		//补助分类
		print	"<Label>检测结果：&nbsp;</Label>";
		print	"<Select class=SmallSelect name='检测结果'>";
					for($i=0;$i<sizeof($检测结果Array);$i++)
					{
						$检测结果 = $检测结果Array[$i]['检测结果'];
						print "<Option value=".$检测结果." selected>".$检测结果."</Option>";
					}
		print	"</Select>&nbsp;&nbsp;";
		//补助名称
		print	"<Label>是否存在问题：&nbsp;</Label>";
		print	"<Select class=SmallSelect name='是否存在问题'>";
						print "<Option value='是' selected>是</Option>";
					    print "<Option value='否' selected>否</Option>";
		print	"</Select>&nbsp;&nbsp;";
		print	"<Label>问题是否解决：&nbsp;</Label>";
		print	"<Select class=SmallSelect name='问题是否解决'>";
						print "<Option value='是' selected>是</Option>";
					    print "<Option value='否' selected>否</Option>";
		print	"</Select>
				&nbsp;&nbsp;<input type=submit class=SmallButton value='查 询'>
				<input type=hidden name='action' value='StaticAll'/>
				<BR><BR>";
		print	"</Form>";	
		print	"</Td></Tr>
		</Table>";
}
?>