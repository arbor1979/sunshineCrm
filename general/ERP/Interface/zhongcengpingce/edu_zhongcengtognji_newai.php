<?php

require_once('lib.inc.php');



if($_GET['pageAction']!="write")				{

	$GLOBAL_SESSION=returnsession();
$SYSTEM_PRIV_STOP = 1;
	require_once("systemprivateinc.php");
	CheckSystemPrivate("人力资源-干部测评-干部测评统计");
}


	$评测人员 = $_SESSION['LOGIN_USER_NAME'];
	//print_R($_GET);
	if($_GET['测评名称']=="")		{
		$测评名称 = returntablefield("edu_zhongcengceping","是否有效",1,"测评名称");
	}
	else	{
		$测评名称 = $_GET['测评名称'];
	}

	$参与评测人员 = returntablefield("edu_zhongcengceping","测评名称",$测评名称,"参与评测人员");
	$参与评测人员Array = explode(',',$参与评测人员);





if($LOGIN_THEME!="") $LOGIN_THEME_TEXT = $LOGIN_THEME;
else	 $LOGIN_THEME_TEXT = 3;

print "<TITLE>中层测评</TITLE>
<META http-equiv=Content-Type content=\"text/html; charset=gb2312\">
<LINK href=\"http://".$_SERVER['SERVER_NAME'].":".$_SERVER['SERVER_PORT']."/theme/$LOGIN_THEME_TEXT/style.css\" type=text/css rel=stylesheet>
<script type=\"text/javascript\" language=\"javascript\" src=\"http://".$_SERVER['SERVER_NAME'].":".$_SERVER['SERVER_PORT']."/general/EDU/Enginee/lib/common.js\"></script><STYLE>@media print{input{display:none}}</STYLE>
<BODY class=bodycolor topMargin=5 >";

?>
<script language="javascript" src="../LODOP60/LodopFuncs.js"></script>
<object  id="LODOP_OB" classid="clsid:2105C259-1E0C-4534-8141-A753534CB4CA" width=0 height=0>
	<embed id="LODOP_EM" type="application/x-print-lodop" width=0 height=0></embed>
</object>

<script language="javascript" type="text/javascript">
	var LODOP; //声明为全局变量
	LODOP=getLodop(document.getElementById('LODOP_OB'),document.getElementById('LODOP_EM'));

    function PreviewFun(){
	    LODOP.PRINT_INIT("数字化校园打印程序");
		var strStyleCSS="<link href='/theme/3/style.css' type='text/css' rel='stylesheet'>";
		LODOP.ADD_PRINT_TABLE(30,"4%","90%","90%",strStyleCSS+"<body>"+document.getElementById("MainData0").innerHTML+"</body>");
		LODOP.NewPageA();
	};

	function PreviewMytable(){
		
		PreviewFun();
		LODOP.PREVIEW();
	};

	function PrintMytable(){

		PreviewFun();
		if (LODOP.PRINTA())  
			alert("已发出实际打印命令！");
	};
	
	function SaveAsFile(){ 
	   LODOP.PRINT_INIT("数字化校园导出程序");
	   var strStyleCSS="<link href='/theme/3/style.css' type='text/css' rel='stylesheet'>";
	   LODOP.ADD_PRINT_TABLE(100,20,500,80,strStyleCSS+"<body>"+document.getElementById("MainData0").innerHTML+"</body>");
	   //LODOP.SET_SAVE_MODE("QUICK_SAVE",true);//快速生成（无表格样式,数据量较大时或许用到）
	   LODOP.SAVE_TO_FILE("中层评测.xls");
	};
	//js导出程序
	function JsSaveAsFile(){
		c1 = document.getElementById("MainData0").innerHTML;
		ExportExcelFile(c1);
	};
</script>

<?php


	table_begin("100%");
	$sql="select 测评名称 from edu_zhongcengceping";
	$rs = $db->Execute($sql);
	$rs_a = $rs->GetArray();
	print "<tr class=TableData ><td colspan=6 align=left>";
	print "&nbsp;请先选择你所要统计的测评项目: <select class=\"SmallSelect\" name=\"测评名称\" onChange=\"var jmpURL='?action=ViewProject&测评名称=' + this.options[this.selectedIndex].value ; if(jmpURL!='') {window.location=jmpURL;} else {this.selectedIndex=0 ;}\">";
	for($i=0;$i<sizeof($rs_a);$i++)		{
		$测评名称X = $rs_a[$i]['测评名称'];
		if($测评名称==$测评名称X) $temp = "selected";else $temp = "";
		print "<option value=\"".$测评名称X."\" $temp>".$测评名称X."</option>\n";
	}
	print "</select>\n";
	print "</td></tr>";
	table_end();
	print "<BR>";


    print "<div id=MainData0>";
	table_begin("100%");
	print "<thead><tr class=TableHeader ><td colspan=6 align=left>中层干部测评统计[$测评名称]";
	print "</td></tr>";

	print "<tr class=TableHeader >
				<td  align=center>干部名称</td>
				<td  align=center>单位</td>
				<td  align=center>职务</td>
				<td  align=center>测评人数</td>
				<td  align=center>综合结果</td>
				<td  align=center>排名</td>
				</tr></thead>";
	$sql = "select 被评人员,单位,职务,SUM(品德评价)+SUM(能力评价)+SUM(勤奋评价)+SUM(绩效评价)+SUM(廉政评价) AS 总评,评价人 from edu_zhongcengmingxi where 测评名称='$测评名称' group by 被评人员,评价人 order by 被评人员";
	$rs = $db->Execute($sql);
	$rs_a = $rs->GetArray();
	for($i=0;$i<sizeof($rs_a);$i++)		{
		$编号 = $rs_a[$i]['编号'];
		$被评人员 = $rs_a[$i]['被评人员'];
		$评价人 = $rs_a[$i]['评价人'];
		$Infor[$被评人员]['单位'] = $rs_a[$i]['单位'];
		$Infor[$被评人员]['职务'] = $rs_a[$i]['职务'];
		$Infor[$被评人员]['总评'] = $rs_a[$i]['总评'];
		$NewArray[$被评人员][$评价人] = $rs_a[$i]['总评'];

	}

	//print_R($NewArray);

	$被评人员数组 = @array_keys($NewArray);
	for($i=0;$i<sizeof($被评人员数组);$i++)		{
		$被评人员 = $被评人员数组[$i];
		$评价人数组 = array();
		$评价人数组 = $NewArray[$被评人员];
		$评价人数量 = sizeof($评价人数组);

		$ResultNum[$被评人员] = $评价人数量;


		$评价人数组Values = array_values($评价人数组);
		@sort($评价人数组Values);
		//print_R($评价人数组Values);
		//三个人以上评价人时
		if($评价人数量>2)						{
			$P10 = ceil($评价人数量*0.1);
			if($P10==0) $P10 = 1;				//至少去除一个最高分和一个最低分
			//print $P10;
			for($iX=0;$iX<$P10;$iX++)				{
				$扣除最低分[$被评人员] .= array_shift($评价人数组Values)." ";
				//print_R($评价人数组Values);
				$扣除最高分[$被评人员] .= array_pop($评价人数组Values)." ";
				//print_R($评价人数组Values);
				//exit;
			}
		}
		else		{
			//一个或两个人时直接计算平均值
			$扣除最高分[$被评人员] = '';
			$扣除最低分[$被评人员] = '';
		}


		$评价人数量 = count($评价人数组Values);
		$评价人总数量 = array_sum($评价人数组Values);
		//print_R($P10);
		if($评价人数量>0)	$平均值 = number_format($评价人总数量/($评价人数量*5),2,'.','');
		else	$平均值 = 0;

		$Result[$被评人员] = $平均值;
		$评价人数量被评人员[$被评人员] = $评价人数量;
		$评价人总数量被评人员[$被评人员] = $评价人总数量;

	}


	@arsort($Result);

	$被评人员数组 = @array_keys($Result);
	$被评人员分值 = @array_values($Result);
	//$被评人员分值[2] = '8.80';
	//print_R($被评人员分值);
	//$Result['人员'] = '8.80';

	//排名信息
	$ArrayValues = @array_values($Result);
	$NewSortArrayValues = array();
	for($i=0;$i<sizeof($ArrayValues);$i++)		{
		$Values = $ArrayValues[$i];
		if(!in_array($Values,$NewSortArrayValues))	{
			$NewSortArray[$Values] = $i+1;
			array_push($NewSortArrayValues,$Values);
		}
	}
	//print_R($NewSortArray);


	for($i=0;$i<sizeof($被评人员数组);$i++)		{
		$被评人员 = $被评人员数组[$i];
		$数量 = $ResultNum[$被评人员];
		$综合结果 = $被评人员分值[$i];
		$SHOWTEXT = "扣除最高分:".$扣除最高分[$被评人员]." 扣除最低分:".$扣除最低分[$被评人员]." 实际评价人数量:".$评价人数量被评人员[$被评人员]." 实际评价人总分:".$评价人总数量被评人员[$被评人员]."";
		print "<tr class=TableData >
				<td  align=left title='$SHOWTEXT'>&nbsp;$被评人员</td>
				<td  align=left title='$SHOWTEXT'>&nbsp;".$Infor[$被评人员]['单位']."</td>
				<td  align=left title='$SHOWTEXT'>&nbsp;".$Infor[$被评人员]['职务']."</td>
				<td  align=left title='$SHOWTEXT'>&nbsp;".$数量."</td>
				<td  align=left title='$SHOWTEXT'>&nbsp;$综合结果</td>
				<td  align=left title='$SHOWTEXT'>&nbsp;".$NewSortArray[$综合结果]."</td>
				</tr>";
	}

print "</table></div><BR>";
?>
<p align=center>
		<input type='button' class='SmallButton' onClick="PreviewMytable();" value='预览'>&nbsp;&nbsp;
		<input type='button' class='SmallButton' onClick="PrintMytable();" value='打印'  title="快捷键:ALT+p">&nbsp;&nbsp;
		<input type="button" value="导出" class='SmallButton' ONCLICK="JsSaveAsFile();">
</P>