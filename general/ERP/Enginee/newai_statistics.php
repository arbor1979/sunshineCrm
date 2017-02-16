<?php
ini_set('date.timezone','Asia/Shanghai');
/******************************************************************************
 *@系统项目：Sunshine Anywhere Application Platform(SAAP)1.2
 *@函数说明：实现了报表的统计部分功能，主要支持一种数据类型：TableFilter
			 支持一种统计方法：分组统计
			 支持两种统计显示：图表显示和数据显示
 *@函数作者：王纪云
 *@建立日期：2005-10-16
 *@更新日期：2005-10-26
 *@状态说明：已经过测试
 */
function newaiStatistics($fields)		{
global $html_etc,$tablename,$common_html,$custom_type;
global $db,$return_sql_line,$columns;
global $_POST,$_GET,$returnmodel,$primarykey_index;
global $action_submit,$merge,$form_attribute;
global $tabletitle;

global $showlistfieldlist,$showlistfieldfilter,$showlistfieldtype;
global $showlistfieldlist1,$showlistfieldlist2,$showlistfieldlist3,$showlistfieldlist4;
global $showlistfieldlist5,$showlistfieldlist6,$showlistfieldlist7,$showlistfieldlist8;
$_GET['Year']=="" ? $_GET['Year']=Date("Y") : '';
$_GET['action_model']=="" ? $_GET['action_model']="1" : '';

$Year = $_GET['Year'];
$action_model = $_GET['action_model'];

$showlistfieldlist1Array=explode(',',$showlistfieldlist1);
$showlistfieldlist2Array=explode(',',$showlistfieldlist2);
$showlistfieldlist3Array=explode(',',$showlistfieldlist3);
$showlistfieldlist4Array=explode(',',$showlistfieldlist4);
$showlistfieldlist5Array=explode(',',$showlistfieldlist5);
$showlistfieldlist6Array=explode(',',$showlistfieldlist6);
$showlistfieldlist7Array=explode(',',$showlistfieldlist7);
$showlistfieldlist8Array=explode(',',$showlistfieldlist8);

table_begin("900");
print "<TR class=TableContent>\n";
print "<TD nowrap title='' coslpan=15>\n";
//系统默认统计一按钮入口
if(sizeof($showlistfieldlist1Array)>=4)		{
	$DATE_Field = $showlistfieldlist1Array[2];
	$Text = $html_etc[$tablename][$DATE_Field."_STS"];
	print "<input type=\"button\" accesskey=\"n\" value=\"报表项:$Text\" class=SmallButton onClick=\"location='?action_model=1&Year=$Year';\" title=\"$Text\">\n";
}
//系统默认统计二按钮入口
if(sizeof($showlistfieldlist2Array)>=4)		{
	$DATE_Field = $showlistfieldlist2Array[2];
	$Text = $html_etc[$tablename][$DATE_Field."_STS"];
	print "<input type=\"button\" accesskey=\"n\" value=\"报表项:$Text\" class=SmallButton onClick=\"location='?action_model=2&Year=$Year';\" title=\"$Text\">\n";
}
//系统默认统计三按钮入口
if(sizeof($showlistfieldlist3Array)>=4)		{
	$DATE_Field = $showlistfieldlist3Array[2];
	$Text = $html_etc[$tablename][$DATE_Field."_STS"];
	print "<input type=\"button\" accesskey=\"n\" value=\"报表项:$Text\" class=SmallButton onClick=\"location='?action_model=3&Year=$Year';\" title=\"$Text\">\n";
}
//系统默认统计四按钮入口
if(sizeof($showlistfieldlist4Array)>=4)		{
	$DATE_Field = $showlistfieldlist4Array[2];
	$Text = $html_etc[$tablename][$DATE_Field."_STS"];
	print "<input type=\"button\" accesskey=\"n\" value=\"报表项:$Text\" class=SmallButton onClick=\"location='?action_model=4&Year=$Year';\" title=\"$Text\">\n";
}
//系统默认统计五按钮入口
if(sizeof($showlistfieldlist5Array)>=4)		{
	$DATE_Field = $showlistfieldlist5Array[2];
	$Text = $html_etc[$tablename][$DATE_Field."_STS"];
	print "<input type=\"button\" accesskey=\"n\" value=\"报表项:$Text\" class=SmallButton onClick=\"location='?action_model=4&Year=$Year';\" title=\"$Text\">\n";
}
//系统默认统计六按钮入口
if(sizeof($showlistfieldlist6Array)>=4)		{
	$DATE_Field = $showlistfieldlist6Array[2];
	$Text = $html_etc[$tablename][$DATE_Field."_STS"];
	print "<input type=\"button\" accesskey=\"n\" value=\"报表项:$Text\" class=SmallButton onClick=\"location='?action_model=4&Year=$Year';\" title=\"$Text\">\n";
}
//系统默认统计七按钮入口
if(sizeof($showlistfieldlist7Array)>=4)		{
	$DATE_Field = $showlistfieldlist7Array[2];
	$Text = $html_etc[$tablename][$DATE_Field."_STS"];
	print "<input type=\"button\" accesskey=\"n\" value=\"报表项:$Text\" class=SmallButton onClick=\"location='?action_model=4&Year=$Year';\" title=\"$Text\">\n";
}
//系统默认统计八按钮入口
if(sizeof($showlistfieldlist8Array)>=4)		{
	$DATE_Field = $showlistfieldlist8Array[2];
	$Text = $html_etc[$tablename][$DATE_Field."_STS"];
	print "<input type=\"button\" accesskey=\"n\" value=\"报表项:$Text\" class=SmallButton onClick=\"location='?action_model=4&Year=$Year';\" title=\"$Text\">\n";
}

print "</TD>\n";
print "</TR>\n";
table_end();
print "<BR>";

//HTML报表输出执行区域
switch($action_model)						{
	case "1":
		BaseStatistics($showlistfieldlist1Array,$action_model);
		break;
	case "2":
		BaseStatistics($showlistfieldlist2Array,$action_model);
		break;
	case "3":
		BaseStatistics($showlistfieldlist3Array,$action_model);
		break;
	case "4":
		BaseStatistics($showlistfieldlist4Array,$action_model);
		break;
	case "5":
		BaseStatistics($showlistfieldlist5Array,$action_model);
		break;
	case "6":
		BaseStatistics($showlistfieldlist6Array,$action_model);
		break;
	case "7":
		BaseStatistics($showlistfieldlist7Array,$action_model);
		break;
	case "8":
		BaseStatistics($showlistfieldlist8Array,$action_model);
		break;
}


}


function BaseStatistics($showlistfieldlist1Array,$action_model_2)			{
global $html_etc,$common_html,$tablename,$tabletitle;
global $db,$columns;
global $_POST,$_GET,$primarykey_index;



//获取系统显示的色彩信息
$ColorArray = returnColorArray();

//初始化信息
$USER_Field = $showlistfieldlist1Array[0];
$DEPT_Field = $showlistfieldlist1Array[1];
$DATE_Field = $showlistfieldlist1Array[2];
$FIELD_Field = $showlistfieldlist1Array[3];
$FIELD_LIST = explode(':',$FIELD_Field);
$Action_Model = $FIELD_LIST[0];
switch($Action_Model)		{
	case 'NUM':
		//array_shift($FIELD_LIST);
		$SQL_Text = "Count($FIELD_LIST[1]) AS Number";
		break;
	case 'SUM':
		break;
}


$_GET['Year']=="" ? $_GET['Year']=Date("Y") : '';

$Year = $_GET['Year'];

if($DATE_Field=="BaoBeiDate")		{
	$SQL_ADD1 = "IsFor AS IsFor,";
	$SQL_ADD2 = ",IsFor";
	$SQL_ADD3 = " and IsFor = 'on' ";
	$SQL_ADD4 = "";
}
else	{
	$SQL_ADD1 = "";
	$SQL_ADD2 = "";
	$SQL_ADD3 = "";
	$SQL_ADD4 = "";
}

$sql = "select Date_Format($DATE_Field,'%Y-%c') AS Date,
		Date_Format($DATE_Field,'%Y') AS Year,
			$SQL_ADD1
			$SQL_Text,
			$USER_Field AS USER_Field,
			$DEPT_Field AS DEPT_Field
			from $tablename
			group by $DATE_Field,$USER_Field,$DEPT_Field $SQL_ADD2
			having Year='$Year' $SQL_ADD3
			order by DEPT_Field
			";
// having CommunicationNeeds_SureDate != null
//$SQL = "select Date_Format($fieldName,'%c') AS $fieldName,Sum($sum_index) as sum,Count($fieldName) as num from $tablename group by $fieldName";
//print $sql;
$rs = $db->CacheExecute(150,$sql);
$rs_a = $rs->GetArray();

for($i=0;$i<sizeof($rs_a);$i++)				{
	$list = $rs_a[$i];
	$DateValue = $list['Date'];
	$UserValue = $list['USER_Field'];
	$DeptValue = $list['DEPT_Field'];
	$NewArray['USER'][$UserValue][$DateValue]  += $list['Number'];
	$NewArray['DEPT'][$DeptValue][$DateValue]  += $list['Number'];
	$NewArray['DEPT_YEAR'][$DeptValue][$Year]  += $list['Number'];
	$NewArray['USER_YEAR'][$UserValue][$Year]  += $list['Number'];
	$NewArray['USER_DEPT'][$UserValue] = $DeptValue;
}
//print_R($NewArray['DEPT']);


table_begin("900");

$Title_URL .= "<font color=white title='客户信息统计:".$Year."年'>客户信息统计:".$Year."年</font> ";
$Title_URL .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<a href=\"?Year=".($Year-1)."&action_model=$action_model_2\" title=\"点击此按钮，来确定不同的年份进行统计\"><img src=\"../../Framework/images/arrow_l.gif\" border></a>
				<a href=\"?Year=".($Year+1)."&action_model=$action_model_2\" title=\"点击此按钮，来确定不同的年份进行统计\"><img src=\"../../Framework/images/arrow_r.gif\" border></a>
				";
print_title("<font color=white title='按 \"".$html_etc[$tablename][$DATE_Field."_STS"]."\" 进行信息统计'>[".$html_etc[$tablename][$DATE_Field."_STS"]."]</font>".$Title_URL,15);
//标题栏--用户区域
print "<TR class=TableContent>\n";
print "<TD nowrap title='用户列表'>用户列表</TD>\n";
for($i=1;$i<=12;$i++)				{
	$HeaderName = Date("Y-n",mktime(0,0,0,$i,Date("d"),$Year));
	print "<TD nowrap title='显示".$HeaderName."月份数据统计信息'>$HeaderName</TD>\n";
}
print "<TD nowrap>".$Year."年</TD>\n";
print "</TR>\n";
//数据区域--用户区域
$USER_LIST = @array_keys($NewArray['USER']);
for($i=0;$i<sizeof($USER_LIST);$i++)				{
	$USER_TEXT = $USER_LIST[$i];
	$DEPT_TEXT = $NewArray['USER_DEPT'][$USER_TEXT];
	$USER_TEXT_NAME = returntablefield("user","USER_NAME",$USER_TEXT,"NICK_NAME");
	$DEPT_TEXT_NAME = returntablefield("department","DEPT_ID",$DEPT_TEXT,"DEPT_NAME");
	print "<TR class=TableContent>\n";
	print "<TD nowrap class=TableData><font color=black title=\"".$USER_TEXT_NAME."一年统计数量：".$NewArray['USER_YEAR'][$USER_TEXT][$Year]."\">".$USER_TEXT_NAME."[".$DEPT_TEXT_NAME."]</font>&nbsp;</TD>\n";
	for($k=1;$k<=12;$k++)				{
		$HeaderName = Date("Y-n",mktime(0,0,0,$k,Date("d"),$Year));
		$HeaderName2 = Date("Y-m",mktime(0,0,0,$k,Date("d"),$Year));
		if($NewArray['USER'][$USER_TEXT][$HeaderName]!="")		{
			$base64_string = "action=init_default_search&searchvalue=$HeaderName2&searchfield=$DATE_Field&$USER_Field=$USER_TEXT";
			$base64_url = base64_encode($base64_string);
			$Element = "<a href=\"crm_customer_newai.php?$base64_url\" target=_blank>".$NewArray['USER'][$USER_TEXT][$HeaderName]."</a>";
		}
		else	{
			$Element = "";
		}
		print "<TD nowrap class=TableData>".$Element."&nbsp;</TD>\n";
	}

	if($NewArray['USER_YEAR'][$USER_TEXT][$Year]!="")		{
		$base64_string = "action=init_default_search&searchvalue=$Year&searchfield=$DATE_Field&$USER_Field=$USER_TEXT";
		$base64_url = base64_encode($base64_string);
		$Element = "<a href=\"crm_customer_newai.php?$base64_url\" target=_blank>".$NewArray['USER_YEAR'][$USER_TEXT][$Year]."</a>";
	}
	else	{
		$Element = "";
	}
	print "<TD nowrap class=TableData><font color=black title='".$USER_TEXT_NAME."用户".$Year."年客户数量:".$NewArray['USER_YEAR'][$USER_TEXT][$Year]."'>".$Element."</font>&nbsp;</TD>\n";
	print "</TR>\n";
}

//标题栏--部门区域
print "<TR class=TableContent>\n";
print "<TD nowrap title='部门列表'>部门列表</TD>\n";
for($i=1;$i<=12;$i++)				{
	$HeaderName = Date("Y-n",mktime(0,0,0,$i,Date("d"),$Year));
	print "<TD nowrap title='显示".$HeaderName."月份数据统计信息'>$HeaderName</TD>\n";
}
print "<TD nowrap>".$Year."年</TD>\n";
print "</TR>\n";
//数据区域--部门区域
$DEPT_LIST = @array_keys($NewArray['DEPT']);
for($i=0;$i<sizeof($DEPT_LIST);$i++)				{
	$DEPT_TEXT = $DEPT_LIST[$i];
	$DEPT_TEXT_NAME = returntablefield("department","DEPT_ID",$DEPT_TEXT,"DEPT_NAME");
	print "<TR class=TableContent>\n";
	print "<TD nowrap class=TableData><font color=black title=\"".$DEPT_TEXT_NAME."一年统计数量：".$NewArray['DEPT_YEAR'][$DEPT_TEXT][$Year]."\">".$DEPT_TEXT_NAME."[".$NewArray['DEPT_YEAR'][$DEPT_TEXT][$Year]."]</font>&nbsp;</TD>\n";

	for($k=1;$k<=12;$k++)				{
		$HeaderName = Date("Y-n",mktime(0,0,0,$k,Date("d"),$Year));
		$HeaderName2 = Date("Y-m",mktime(0,0,0,$k,Date("d"),$Year));
		if($NewArray['DEPT'][$DEPT_TEXT][$HeaderName]!="")		{
			$base64_string = "action=init_default_search&searchvalue=$HeaderName2&searchfield=$DATE_Field&$DEPT_Field=$DEPT_TEXT";
			$base64_url = base64_encode($base64_string);
			$Element = "<a href=\"crm_customer_newai.php?$base64_url\" target=_blank>".$NewArray['DEPT'][$DEPT_TEXT][$HeaderName]."</a>";
		}
		else	{
			$Element = "";
		}
		print "<TD nowrap class=TableData>".$Element."&nbsp;</TD>\n";
	}
	if($NewArray['DEPT_YEAR'][$DEPT_TEXT][$Year]!="")		{
		$base64_string = "action=init_default_search&searchvalue=$Year&searchfield=$DATE_Field&$DEPT_Field=$DEPT_TEXT";
		$base64_url = base64_encode($base64_string);
		$Element = "<a href=\"crm_customer_newai.php?$base64_url\" target=_blank>".$NewArray['DEPT_YEAR'][$DEPT_TEXT][$Year]."</a>";
	}
	else	{
		$Element = "";
	}
	print "<TD nowrap class=TableData><font color=black title='".$DEPT_TEXT_NAME.$Year."年客户数量:".$NewArray['DEPT_YEAR'][$DEPT_TEXT][$Year]."'>".$Element."</font>&nbsp;</TD>\n";
	print "</TR>\n";
}

//合并说明

print "<TR class=TableContent>\n";
print "<TD nowrap colspan=15 title='如果使用浏览器打印不是太方便的话，可以复制表格数据区到MS EXCEL，然后进行排版打印' class=TableData>报表说明：点击标题栏两个黑色三角箭头，即可实现年份之间的切换&nbsp;</TD>\n";
print "</TR>\n";


//报表统计主体部分开始
for($k=0;$k<sizeof($showlistfieldlistArray);$k++)		{
	$fieldIndex = $showlistfieldlistArray[$k];
	$fieldName  = $columns[$fieldIndex];
	$fieldText  = $html_etc[$tablename][$fieldName];
	$mode = $showlistfieldfilterArray[$k];
	$modeArray = explode(':',$mode);
	//$rs=$db->CacheExecute(150,$SQL);
	//$rs_array=$rs->GetArray();//print_R($rs_array);
	//父表结构部分
	//本表操作部分--数据处理部分 --形成FLASH要处理的数据类型


	//本表操作部分--FALSH图表显示部分--显示FLASH图表的结果

	//本文信息显示部分
	//print_title($html_etc[$tablename][$tabletitle]."<font color=green>[".$html_etc[$tablename][$fieldName]."]</font>",40);

			print "<TR class=TableData>";
			print "<TD width=30%>名称</TD>";
			print "<TD width=30%>数目</TD>";
			print "<TD width=30%>百分比</TD>";
			print "<TD width=30%>总记录</TD>";
			print "</TR>";
			for($i=0;$i<sizeof($rs_array);$i++)				{
				$ResultNumber = $rs_array[$i][num];
				$ResultSum = $rs_array[$i][sum];
				$ResultFieldCode = $rs_array[$i][$fieldName];
				$ResultFieldName = returntablefield($tablenameIndex,$WhatIndex,$ResultFieldCode,$ReturnIndex);
				if($sum_index!="")			{
					print "<TD noWrap width=15%>统计额度&nbsp;</TD>";
					print "<TD noWrap width=10%><font color=red>".$ResultSum."&nbsp;".$UserUnitFunctionIndex."</font></TD>";
				}
				print "<TR class=TableData>";
				print "<TD >$ResultFieldName</TD>";
				print "<TD >$ResultNumber</TD>";
				//print "<TD >".number_format($ResultNumber/$TotalNumberIndex,2,'.','')."</TD>";
				print "<TD >".$TotalNumberIndex."</TD>";
				print "</TR>";
			}
			print "<TR class=TableData>";
			print "<TD noWrap colspan = 40>\n";
			print "&nbsp;";
			print "</TD>";
			print "</TR>";
			table_end();
			print "<BR>";
			break;
	}

}

/******************************************************************************
 *@系统项目：Sunshine Anywhere Application Platform(SAAP)1.2
 *@函数说明：返回FLASH显示函数每项采用的色彩信息数组
 *@函数作者：王纪云
 *@建立日期：2005-10-16
 *@更新日期：2005-10-26
 *@更新日期：2006-04-20
 */
function returnColorArray()			{
	$ColorArray[0]="0xFF0000";
	$ColorArray[1]="0x00FF00";
	$ColorArray[2]="0x0000FF";
	$ColorArray[3]="0xFF6600";
	$ColorArray[4]="0x42FF8E";
	$ColorArray[5]="0x6600FF";
	$ColorArray[6]="0xFFFF00";
	$ColorArray[7]="0x00FFFF";
	$ColorArray[8]="0xFF00FF";
	$ColorArray[9]="0x66FF00";
	$ColorArray[10]="0x0066FF";
	$ColorArray[11]="0xFF0066";
	$ColorArray[12]="0xCC0000";
	$ColorArray[13]="0xFF0000";
	$ColorArray[14]="0x00FF00";
	$ColorArray[15]="0x0000FF";
	$ColorArray[16]="0xFF6600";
	$ColorArray[17]="0x42FF8E";
	$ColorArray[18]="0x6600FF";
	$ColorArray[19]="0xFFFF00";
	$ColorArray[20]="0x00FFFF";
	$ColorArray[21]="0xFF00FF";
	$ColorArray[22]="0x66FF00";
	$ColorArray[23]="0x0066FF";
	$ColorArray[24]="0xFF0066";
	$ColorArray[25]="0xCC0000";
	$ColorArray[26]="0xFF0000";
	$ColorArray[27]="0x00FF00";
	$ColorArray[28]="0x0000FF";
	$ColorArray[29]="0xFF6600";
	$ColorArray[30]="0x42FF8E";
	$ColorArray[31]="0x6600FF";
	$ColorArray[32]="0xFFFF00";
	$ColorArray[33]="0x00FFFF";
	$ColorArray[34]="0xFF00FF";
	$ColorArray[35]="0x66FF00";
	$ColorArray[36]="0x0066FF";
	$ColorArray[37]="0xFF0066";
	$ColorArray[38]="0xCC0000";
	return $ColorArray;
}



/******************************************************************************
 *@系统项目：Sunshine Anywhere Application Platform(SAAP)1.2
 *@函数说明：FLASH图表XML数据文体
			 VBarF部分
 *@函数作者：王纪云
 *@建立日期：2005-10-16
 *@更新日期：2005-10-26
 *@状态说明：已经过测试
 */
function WriteXmlFileVBarF($Array,$fieldName)							{
	$filename = "../../cache/xml/".Date("Y-m-d-H")."-".$fieldName."-vBarF.xml";
	if(!is_dir("../../cache"))	mkdir("../../cache");
	if(!is_dir("../../cache/xml"))	mkdir("../../cache/xml");
	//$Array['title']=
	$Content = '
	<graphData title="'.$Array['title'].'">
     <xData length="20">';
	for($i=0;$i<sizeof($Array['XData']);$i++)		{
	$Content .= '
          <dataRow title="'.$Array['XData'][$i][Name].'" endLabel="'.$Array['XData'][$i][Value].'">
               <bar id="'.$Array['XData'][$i][Dir].'" totalSize="'.$Array['XData'][$i][Value].'" altText="'.$Array['XData'][$i][AltText].'" url="'.$Array['XData'][$i][Url].'"/>
          </dataRow>
			  ';
	}
	$Content .= '
     </xData>
     <yData min="0" max="'.$Array['YData']['Value'].'" length="10" prefix="" suffix="" defaultAltText="'.$Array['YData']['AltText'].'"/>
     <colorLegend>';
	 for($i=0;$i<sizeof($Array['Dir']);$i++)		{
		$Content .= '
          <mapping id="'.$Array[Dir][$i][Name].'" name="'.$Array[Dir][$i][Name].'" color="'.$Array[Dir][$i][Color].'"/>
			';
	 }
	 $Content .= '
     </colorLegend>
     <graphInfo>
          <![CDATA['.$Array[graphInfo].']]>
     </graphInfo>
     <chartColors  docBorder="0x777777"  docBg1="0xfefefe"  docBg2="0xe1e1e1"  xText="0x666666"  yText="0x666666"  title="0x555555"  misc="0x666666"  altBorder="0x666666"  altBg="0xFFF9B7"  altText="0x666666"  graphBorder="0x444444"  graphBg1="0xCCCCCC"  graphBg2="0xefefef"  graphLines="0xEEEEEE"  graphText="0x222222"  graphTextShadow="0xFFFFFF"  barBorder="0x666666"  barBorderHilite="0xFFFFFF"  legendBorder="0x777777"  legendBg1="0xCCDFFF"  legendBg2="0xE0ECFF"  legendText="0x444444"  legendColorKeyBorder="0x777777"  scrollBar="0x999999"  scrollBarBorder="0x777777"  scrollBarTrack="0xeeeeee"  scrollBarTrackBorder="0x777777"  />
	 </graphData>

	';
	write_newaifile_2($filename,$Content,1);
	return $filename;
}

/******************************************************************************
 *@系统项目：Sunshine Anywhere Application Platform(SAAP)1.2
 *@函数说明：FLASH图表XML数据文体
			 HBarF部分
 *@函数作者：王纪云
 *@建立日期：2005-10-16
 *@更新日期：2005-10-26
 *@状态说明：已经过测试
 */
function WriteXmlFileHBarF($Array,$fieldName)					{
	$filename = "../../cache/xml/".Date("Y-m-d-H")."-".$fieldName."-hBarF.xml";
	if(!is_dir("../../cache"))	mkdir("../../cache");
	if(!is_dir("../../cache/xml"))	mkdir("../../cache/xml");
	$Content = '
	<graphData title="'.$Array['title'].'">
	<yData defaultAltText="'.$Array['YData']['AltText'].'">
		';
	for($i=0;$i<sizeof($Array['XData']);$i++)		{
	$Content .= '
          <dataRow title="'.$Array['XData'][$i][Name].'" endLabel="'.$Array['XData'][$i][Value].'">
               <bar id="'.$Array['XData'][$i][Dir].'" totalSize="'.$Array['XData'][$i][Value].'" altText="'.$Array['XData'][$i][AltText].'" url="'.$Array['XData'][$i][Url].'"/>
          </dataRow>
			  ';
	}
    $Content .= '
	</yData>
     <xData min="0" max="'.$Array['YData']['Value'].'" length="10" prefix="" suffix=""/>
     <colorLegend>
		';
	for($i=0;$i<sizeof($Array['Dir']);$i++)		{
		$Content .= '
          <mapping id="'.$Array[Dir][$i][Name].'" name="'.$Array[Dir][$i][Name].'" color="'.$Array[Dir][$i][Color].'"/>
		  ';
	 }
     $Content .= '
	 </colorLegend>
     <graphInfo>
          <![CDATA['.$Array[graphInfo].']]>
     </graphInfo>
     <chartColors  docBorder="0x777777"  docBg1="0xfefefe"  docBg2="0xe1e1e1"  xText="0x666666"  yText="0x666666"  title="0x555555"  misc="0x666666"  altBorder="0x666666"  altBg="0xFFF9B7"  altText="0x666666"  graphBorder="0x444444"  graphBg1="0xCCCCCC"  graphBg2="0xefefef"  graphLines="0xEEEEEE"  graphText="0x222222"  graphTextShadow="0xFFFFFF"  barBorder="0x666666"  barBorderHilite="0xFFFFFF"  legendBorder="0x777777"  legendBg1="0xCCDFFF"  legendBg2="0xE0ECFF"  legendText="0x444444"  legendColorKeyBorder="0x777777"  scrollBar="0x999999"  scrollBarBorder="0x777777"  scrollBarTrack="0xeeeeee"  scrollBarTrackBorder="0x777777"  />
</graphData>
		 ';
	 write_newaifile_2($filename,$Content,1);
	 return $filename;

}

/******************************************************************************
 *@系统项目：Sunshine Anywhere Application Platform(SAAP)1.2
 *@函数说明：FLASH图表XML数据文体
			 PieF部分
 *@函数作者：王纪云
 *@建立日期：2005-10-16
 *@更新日期：2005-10-26
 *@状态说明：已经过测试
 */
function WriteXmlFilePieF($Array,$fieldName)						{
	$filename = "../../cache/xml/".Date("Y-m-d-H")."-".$fieldName."-pieF.xml";
	if(!is_dir("../../cache"))	mkdir("../../cache");
	if(!is_dir("../../cache/xml"))	mkdir("../../cache/xml");
	$Content = '
	<graphData title="'.$Array['title'].'" subtitle="'.$Array['title'].'">
     <pie defaultAltText="'.$Array['YData']['AltText'].'">
		';
	for($i=0;$i<sizeof($Array['XData']);$i++)		{
	$Content .= '
          <wedge title="'.$Array['XData'][$i][Name].'" value="'.$Array['XData'][$i][Value].'" color="'.$Array['XData'][$i][Color].'" labelText="'.$Array['XData'][$i][Value].'" url="'.$Array['XData'][$i][Url].'" altText="'.$Array['XData'][$i][AltText].'"/>
			  ';
	}
	 $Content .= '
     </pie>
     <graphInfo>
          <![CDATA[]]>
     </graphInfo>
     <chartColors  docBorder="0x777777"  docBg1="0xfefefe"  docBg2="0xe1e1e1"  title="0x555555"  subtitle="0x666666"  misc="0x666666"  altBorder="0x666666"  altBg="0xFFF9B7"  altText="0x666666"  graphText="0x444444"  graphTextShadow="0xFFFFFF"  pieBorder="0x666666"  pieBorderHilite="0xFFFFFF"  legendBorder="0x777777"  legendBg1="0xCCDFFF"  legendBg2="0xE0ECFF"  legendText="0x444444"  legendColorKeyBorder="0x777777"  scrollBar="0x999999"  scrollBarBorder="0x777777"  scrollBarTrack="0xeeeeee"  scrollBarTrackBorder="0x777777"  />
</graphData>
	';
	 write_newaifile_2($filename,$Content,1);
	 return $filename;
}

?>