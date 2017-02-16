<?php

	require_once('lib.inc.php');



	$GLOBAL_SESSION=returnsession();
$SYSTEM_PRIV_STOP = 1;
	require_once("systemprivateinc.php");
	CheckSystemPrivate("人力资源-干部测评-参与干部测评");


	$评测人员 = $_SESSION['LOGIN_USER_NAME'];


	$测评名称 = returntablefield("edu_zhongcengceping","是否有效",1,"测评名称");
	$参与评测人员 = returntablefield("edu_zhongcengceping","测评名称",$测评名称,"参与评测人员");
	$参与评测人员Array = explode(',',$参与评测人员);

	page_css("干部测评");

	//较难是否可以参与测评
	if(!in_array($评测人员,$参与评测人员Array))		{
		print_infor("您没有在可以参与测评的人员之列!",'',"location='?'");
		exit;
	}
	/*
	  编号 int(33) NOT NULL auto_increment,
	  测评名称 varchar(200) NOT NULL default '',
	  被评人员 varchar(200) NOT NULL default '',
	  单位 varchar(200) NOT NULL default '',
	  职务 varchar(200) NOT NULL default '',
	  品德描述 mediumtext NOT NULL default '',
	  品德自述 mediumtext NOT NULL default '',
	  能力描述 mediumtext NOT NULL default '',
	  能力自述 mediumtext NOT NULL default '',
	  勤奋描述 mediumtext NOT NULL default '',
	  勤奋自述 mediumtext NOT NULL default '',
	  绩效描述 mediumtext NOT NULL default '',
	  绩效自述 mediumtext NOT NULL default '',
	  廉政描述 mediumtext NOT NULL default '',
	  廉政自述 mediumtext NOT NULL default '',
	  */
if($_GET['action']=="PingJiaDataDeal")				{
//print_R($_POST);
//Array ( [品德评价] => 优秀 [品德备注] => 品德备注 [能力评价] => 良好/称职 [能力备注] => 能力备注 [勤奋评价] => 中等/基本称职 [勤奋备注] => 勤奋备注 [绩效评价] => 差/不称职 [绩效备注] => 绩效备注 [廉政评价] => 优秀 [廉政备注] => 廉政备注 [提交] => 提交 )
$被评人员 = $_GET['被评人员'];
$测评名称 = $_GET['测评名称'];
$单位 = $_GET['单位'];
$职务 = $_GET['职务'];
$sql = "select * from edu_zhongcengmingxi where 测评名称='$测评名称' and 被评人员='".$被评人员."' and 评价人='".$评测人员."'";
$rs = $db->Execute($sql);
$rs_a = $rs->GetArray();
$编号 = $rs_a[0]['编号'];
//rint $sql;exit;
if($编号!="")		{
	$sql = "update edu_zhongcengmingxi set 品德评价='".addslashes($_POST['品德评价'])."',
											品德备注='".addslashes($_POST['品德备注'])."',
											能力评价='".addslashes($_POST['能力评价'])."',
											能力备注='".addslashes($_POST['能力备注'])."',
											勤奋评价='".addslashes($_POST['勤奋评价'])."',
											勤奋备注='".addslashes($_POST['勤奋备注'])."',
											绩效评价='".addslashes($_POST['绩效评价'])."',
											绩效备注='".addslashes($_POST['绩效备注'])."',
											廉政评价='".addslashes($_POST['廉政评价'])."',
											廉政备注='".addslashes($_POST['廉政备注'])."'
									where 测评名称='$测评名称' and 被评人员='".$被评人员."'";
}
else	{
	$sql = "insert into edu_zhongcengmingxi values(
					'',
					'$测评名称',
					'$被评人员',
					'$单位',
					'$职务',
					'".addslashes($_POST['品德评价'])."',
					'".addslashes($_POST['品德备注'])."',
					'".addslashes($_POST['能力评价'])."',
					'".addslashes($_POST['能力备注'])."',
					'".addslashes($_POST['勤奋评价'])."',
					'".addslashes($_POST['勤奋备注'])."',
					'".addslashes($_POST['绩效评价'])."',
					'".addslashes($_POST['绩效备注'])."',
					'".addslashes($_POST['廉政评价'])."',
					'".addslashes($_POST['廉政备注'])."',
					'".$评测人员."',
					'".date('Y-m-d H:i:s')."'
					);";
}
$rs = $db->Execute($sql);
print_infor("您的评价已经完成,请返回...");
print  "<META HTTP-EQUIV=REFRESH CONTENT='0;URL=?'>";
//print $sql."<BR>";
exit;
}

if($_GET['action']=="PingJia")				{

		$sql = "select * from edu_zhongcengrenyuan where 测评名称='$测评名称' and 被评人员='".$_GET['被评人员']."' order by 单位,被评人员";
		$rs = $db->Execute($sql);
		$rs_a = $rs->GetArray();
		$i = 0;
		$编号 = $rs_a[$i]['编号'];
		$测评名称 = $rs_a[$i]['测评名称'];
		$被评人员 = $rs_a[$i]['被评人员'];
		$单位 = $rs_a[$i]['单位'];
		$职务 = $rs_a[$i]['职务'];
		$品德描述 = nl2br($rs_a[$i]['品德描述']);
		$品德自述 = nl2br($rs_a[$i]['品德自述']);
		$能力描述 = nl2br($rs_a[$i]['能力描述']);
		$能力自述 = nl2br($rs_a[$i]['能力自述']);
		$勤奋描述 = nl2br($rs_a[$i]['勤奋描述']);
		$勤奋自述 = nl2br($rs_a[$i]['勤奋自述']);
		$绩效描述 = nl2br($rs_a[$i]['绩效描述']);
		$绩效自述 = nl2br($rs_a[$i]['绩效自述']);
		$廉政描述 = nl2br($rs_a[$i]['廉政描述']);
		$廉政自述 = nl2br($rs_a[$i]['廉政自述']);



print "<script language = \"JavaScript\">
	function FormCheck()
	{

		if(!confirm(\"您只有一个测评的机会,请确认填写内容,点击确定进行提交，点击取消进行修正\"))		{
			return false;
		}

	}
	</script>
	";

print "<FORM name=form1 onsubmit=\"return FormCheck();\" action=\"?action=PingJiaDataDeal&测评名称=$测评名称&被评人员=$被评人员&单位=$单位&职务=$职务\" method=post encType=multipart/form-data>";

table_begin("100%");



$sql = "select * from edu_zhongcengmingxi where 测评名称='$测评名称' and 被评人员='".$被评人员."' and 评价人='".$评测人员."' order by 单位,被评人员";
$rs = $db->Execute($sql);
$rs_a = $rs->GetArray();

$品德评价 = DoItProject('品德评价',$rs_a[0]['品德评价']);
$品德备注 = DoItProject2('品德备注',$rs_a[0]['品德备注']);

$能力评价 = DoItProject('能力评价',$rs_a[0]['能力评价']);
$能力备注 = DoItProject2('能力备注',$rs_a[0]['能力备注']);

$勤奋评价 = DoItProject('勤奋评价',$rs_a[0]['勤奋评价']);
$勤奋备注 = DoItProject2('勤奋备注',$rs_a[0]['勤奋备注']);

$绩效评价 = DoItProject('绩效评价',$rs_a[0]['绩效评价']);
$绩效备注 = DoItProject2('绩效备注',$rs_a[0]['绩效备注']);

$廉政评价 = DoItProject('廉政评价',$rs_a[0]['廉政评价']);
$廉政备注 = DoItProject2('廉政备注',$rs_a[0]['廉政备注']);

//print_R($rs_a);
$sql = "select 附件 from edu_zhongcengrenyuan where 测评名称='$测评名称' and 被评人员='".$被评人员."'";
$rsX = $db->Execute($sql);
$rsX_a = $rsX->GetArray();
$附件 = $rsX_a[0]['附件'];

if($附件!="")	 $附件 = "<a href=\"$附件\">下载自评文件</a>";
else	$附件 = "<font color=gray>没有上传自评文件</font>";


print "<tr class=TableHeader ><td colspan=5 align=left>开始对中层人员测评 (仔细审议，慎重评价，尊重他人，尊重自己)</td></tr>";
print "<tr class=TableContent >
<td  align=left nowrap  colspan=2>&nbsp;被评人员:".$_GET['被评人员']." $附件 </td>
<td  align=left nowrap  colspan=2>&nbsp;科室:".$单位."</td>
<td  align=left nowrap>&nbsp;职务:".$职务."</td>
</tr>";

print "<tr class=TableContent >
<td  align=left nowrap width=10%>&nbsp;项目</td>
<td  align=left nowrap width=40%>&nbsp;描述</td>
<td  align=left nowrap width=15%>&nbsp;自述</td>
<td  align=left nowrap width=20%>&nbsp;评价</td>
<td  align=left nowrap width=20%>&nbsp;备注</td>
</tr>";

print "<tr class=TableData >
<td  align=left nowrap>&nbsp;品德</td>
<td  align=left >&nbsp;".$品德描述."</td>
<td  align=left >&nbsp;".$品德自述."</td>
<td  align=left valign=top ><BR>&nbsp;".$品德评价."</td>
<td  align=left valign=top ><BR>&nbsp;".$品德备注."</td>
</tr>";

print "<tr class=TableData >
<td  align=left nowrap>&nbsp;能力</td>
<td  align=left >&nbsp;".$能力描述."</td>
<td  align=left >&nbsp;".$能力自述."</td>
<td  align=left valign=top ><BR>&nbsp;".$能力评价."</td>
<td  align=left valign=top ><BR>&nbsp;".$能力备注."</td>
</tr>";

print "<tr class=TableData >
<td  align=left nowrap>&nbsp;勤奋</td>
<td  align=left >&nbsp;".$勤奋描述."</td>
<td  align=left >&nbsp;".$勤奋自述."</td>
<td  align=left valign=top ><BR>&nbsp;".$勤奋评价."</td>
<td  align=left valign=top ><BR>&nbsp;".$勤奋备注."</td>
</tr>";

print "<tr class=TableData >
<td  align=left nowrap>&nbsp;绩效</td>
<td  align=left >&nbsp;".$绩效描述."</td>
<td  align=left >&nbsp;".$绩效自述."</td>
<td  align=left valign=top ><BR>&nbsp;".$绩效评价."</td>
<td  align=left valign=top ><BR>&nbsp;".$绩效备注."</td>
</tr>";

print "<tr class=TableData >
<td  align=left nowrap>&nbsp;廉政</td>
<td  align=left >&nbsp;".$廉政描述."</td>
<td  align=left >&nbsp;".$廉政自述."</td>
<td  align=left valign=top ><BR>&nbsp;".$廉政评价."</td>
<td  align=left valign=top ><BR>&nbsp;".$廉政备注."</td>
</tr>";


print "<TR><TD class=TableControl noWrap align=middle  colspan=\"5\">
<div align=\"center\">
<INPUT class=SmallButton name=提交 title=提交 type=submit value=\"提交\" name=button>
　<INPUT class=SmallButton onclick=\"history.back();\" type=button value='返回'>
</div>
</TD></TR>";
table_end();
form_end();
exit;
}



function DoItProject2($SelectName,$SelectValue)		{

global $db;

$Text = "<TEXTAREA class=BigInput name=$SelectName  title='' wrap=yes rows=3 cols=25 >$SelectValue</TEXTAREA>";
return $Text;
}

	table_begin("100%");
	print "<tr class=TableHeader ><td colspan=14 align=left>开始对干部人员测评[每个被评人只能评价一次,评价完成以后不能再进行修改]</td></tr>";
	print "<tr class=TableHeader >
				<td  align=center>被评人员</td>
				<td  align=center>科室</td>
				<td  align=center>职务</td>
				<td  align=center>总评</td>
				<td  align=center>操作</td>
				</tr>";
	$sql = "select * from edu_zhongcengrenyuan where 测评名称='$测评名称' order by 单位,被评人员";
	$rs = $db->Execute($sql);
	$rs_a = $rs->GetArray();
	for($i=0;$i<sizeof($rs_a);$i++)		{
		$编号 = $rs_a[$i]['编号'];
		$测评名称 = $rs_a[$i]['测评名称'];
		$被评人员 = $rs_a[$i]['被评人员'];
		$单位 = $rs_a[$i]['单位'];
		$职务 = $rs_a[$i]['职务'];
		$品德描述 = $rs_a[$i]['品德描述'];
		$品德自述 = $rs_a[$i]['品德自述'];
		$能力描述 = $rs_a[$i]['能力描述'];
		$能力自述 = $rs_a[$i]['能力自述'];
		$勤奋描述 = $rs_a[$i]['勤奋描述'];
		$勤奋自述 = $rs_a[$i]['勤奋自述'];
		$绩效描述 = $rs_a[$i]['绩效描述'];
		$绩效自述 = $rs_a[$i]['绩效自述'];
		$廉政描述 = $rs_a[$i]['廉政描述'];
		$廉政自述 = $rs_a[$i]['廉政自述'];
		$总评ALL = ViewItProject($测评名称,$被评人员,$评测人员);
		$总评 = $总评ALL['总评'];
		$数量 = $总评ALL['数量'];
		if($数量>0)		{
			$平均分 = $总评/($数量*5);
			$平均分 = number_format($平均分,2,'.','');
			$总评Text = "总分:$总评 平均分:".$平均分;
			$点击进行评价 = "<font color=green>你已经参与评价</font>";
		}
		else	{
			$总评Text = '';
			$点击进行评价 = "<a href=\"?action=PingJia&测评名称=$测评名称&被评人员=$被评人员&单位=$单位&职务=$职务\">点击进行评价</a><font color=gray>(评价完以后不能修改)</font>";
		}

		print "<tr class=TableData >
				<td  align=left>&nbsp;$被评人员</td>
				<td  align=left>&nbsp;$单位</td>
				<td  align=left>&nbsp;$职务</td>
				<td  align=left>&nbsp;$总评Text</td>
				<td  align=left>&nbsp;$点击进行评价</td>
				</tr>";
	}



function DoItProject($SelectName,$SelectValue)		{

global $db;
$sql = "select 项目,分值 from edu_zhongcengxingmu";
$rs = $db->Execute($sql);
$rs_a = $rs->GetArray();
$Text = "<select name=$SelectName>";
for($i=0;$i<sizeof($rs_a);$i++)		{
	$项目 = $rs_a[$i]['项目'];
	$分值 = $rs_a[$i]['分值'];
	if($项目==$SelectValue) $selected = "selected";
	else	$selected = "";
	$Text .= "<option value='$分值' $selected>".$项目."(".$分值."分)</option>";
}
$Text .= "</select>";

return $Text;
}


function ViewItProject($测评名称,$被评人员,$评价人)		{

global $db;

$sql = "select SUM(品德评价)+SUM(能力评价)+SUM(勤奋评价)+SUM(绩效评价)+SUM(廉政评价) AS 总评,COUNT(*) AS NUM from edu_zhongcengmingxi where 测评名称='$测评名称' and 被评人员='".$被评人员."' and 评价人='$评价人'";
$rs = $db->Execute($sql);
$rs_a = $rs->GetArray();
$Newarray['总评'] = $rs_a[0]['总评'];
$Newarray['数量'] = $rs_a[0]['NUM'];
//print $sql."<BR>";
return $Newarray;
}





	?>