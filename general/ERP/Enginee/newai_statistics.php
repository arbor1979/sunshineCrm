<?php
ini_set('date.timezone','Asia/Shanghai');
/******************************************************************************
 *@ϵͳ��Ŀ��Sunshine Anywhere Application Platform(SAAP)1.2
 *@����˵����ʵ���˱����ͳ�Ʋ��ֹ��ܣ���Ҫ֧��һ���������ͣ�TableFilter
			 ֧��һ��ͳ�Ʒ���������ͳ��
			 ֧������ͳ����ʾ��ͼ����ʾ��������ʾ
 *@�������ߣ�������
 *@�������ڣ�2005-10-16
 *@�������ڣ�2005-10-26
 *@״̬˵�����Ѿ�������
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
//ϵͳĬ��ͳ��һ��ť���
if(sizeof($showlistfieldlist1Array)>=4)		{
	$DATE_Field = $showlistfieldlist1Array[2];
	$Text = $html_etc[$tablename][$DATE_Field."_STS"];
	print "<input type=\"button\" accesskey=\"n\" value=\"������:$Text\" class=SmallButton onClick=\"location='?action_model=1&Year=$Year';\" title=\"$Text\">\n";
}
//ϵͳĬ��ͳ�ƶ���ť���
if(sizeof($showlistfieldlist2Array)>=4)		{
	$DATE_Field = $showlistfieldlist2Array[2];
	$Text = $html_etc[$tablename][$DATE_Field."_STS"];
	print "<input type=\"button\" accesskey=\"n\" value=\"������:$Text\" class=SmallButton onClick=\"location='?action_model=2&Year=$Year';\" title=\"$Text\">\n";
}
//ϵͳĬ��ͳ������ť���
if(sizeof($showlistfieldlist3Array)>=4)		{
	$DATE_Field = $showlistfieldlist3Array[2];
	$Text = $html_etc[$tablename][$DATE_Field."_STS"];
	print "<input type=\"button\" accesskey=\"n\" value=\"������:$Text\" class=SmallButton onClick=\"location='?action_model=3&Year=$Year';\" title=\"$Text\">\n";
}
//ϵͳĬ��ͳ���İ�ť���
if(sizeof($showlistfieldlist4Array)>=4)		{
	$DATE_Field = $showlistfieldlist4Array[2];
	$Text = $html_etc[$tablename][$DATE_Field."_STS"];
	print "<input type=\"button\" accesskey=\"n\" value=\"������:$Text\" class=SmallButton onClick=\"location='?action_model=4&Year=$Year';\" title=\"$Text\">\n";
}
//ϵͳĬ��ͳ���尴ť���
if(sizeof($showlistfieldlist5Array)>=4)		{
	$DATE_Field = $showlistfieldlist5Array[2];
	$Text = $html_etc[$tablename][$DATE_Field."_STS"];
	print "<input type=\"button\" accesskey=\"n\" value=\"������:$Text\" class=SmallButton onClick=\"location='?action_model=4&Year=$Year';\" title=\"$Text\">\n";
}
//ϵͳĬ��ͳ������ť���
if(sizeof($showlistfieldlist6Array)>=4)		{
	$DATE_Field = $showlistfieldlist6Array[2];
	$Text = $html_etc[$tablename][$DATE_Field."_STS"];
	print "<input type=\"button\" accesskey=\"n\" value=\"������:$Text\" class=SmallButton onClick=\"location='?action_model=4&Year=$Year';\" title=\"$Text\">\n";
}
//ϵͳĬ��ͳ���߰�ť���
if(sizeof($showlistfieldlist7Array)>=4)		{
	$DATE_Field = $showlistfieldlist7Array[2];
	$Text = $html_etc[$tablename][$DATE_Field."_STS"];
	print "<input type=\"button\" accesskey=\"n\" value=\"������:$Text\" class=SmallButton onClick=\"location='?action_model=4&Year=$Year';\" title=\"$Text\">\n";
}
//ϵͳĬ��ͳ�ư˰�ť���
if(sizeof($showlistfieldlist8Array)>=4)		{
	$DATE_Field = $showlistfieldlist8Array[2];
	$Text = $html_etc[$tablename][$DATE_Field."_STS"];
	print "<input type=\"button\" accesskey=\"n\" value=\"������:$Text\" class=SmallButton onClick=\"location='?action_model=4&Year=$Year';\" title=\"$Text\">\n";
}

print "</TD>\n";
print "</TR>\n";
table_end();
print "<BR>";

//HTML�������ִ������
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



//��ȡϵͳ��ʾ��ɫ����Ϣ
$ColorArray = returnColorArray();

//��ʼ����Ϣ
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

$Title_URL .= "<font color=white title='�ͻ���Ϣͳ��:".$Year."��'>�ͻ���Ϣͳ��:".$Year."��</font> ";
$Title_URL .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<a href=\"?Year=".($Year-1)."&action_model=$action_model_2\" title=\"����˰�ť����ȷ����ͬ����ݽ���ͳ��\"><img src=\"../../Framework/images/arrow_l.gif\" border></a>
				<a href=\"?Year=".($Year+1)."&action_model=$action_model_2\" title=\"����˰�ť����ȷ����ͬ����ݽ���ͳ��\"><img src=\"../../Framework/images/arrow_r.gif\" border></a>
				";
print_title("<font color=white title='�� \"".$html_etc[$tablename][$DATE_Field."_STS"]."\" ������Ϣͳ��'>[".$html_etc[$tablename][$DATE_Field."_STS"]."]</font>".$Title_URL,15);
//������--�û�����
print "<TR class=TableContent>\n";
print "<TD nowrap title='�û��б�'>�û��б�</TD>\n";
for($i=1;$i<=12;$i++)				{
	$HeaderName = Date("Y-n",mktime(0,0,0,$i,Date("d"),$Year));
	print "<TD nowrap title='��ʾ".$HeaderName."�·�����ͳ����Ϣ'>$HeaderName</TD>\n";
}
print "<TD nowrap>".$Year."��</TD>\n";
print "</TR>\n";
//��������--�û�����
$USER_LIST = @array_keys($NewArray['USER']);
for($i=0;$i<sizeof($USER_LIST);$i++)				{
	$USER_TEXT = $USER_LIST[$i];
	$DEPT_TEXT = $NewArray['USER_DEPT'][$USER_TEXT];
	$USER_TEXT_NAME = returntablefield("user","USER_NAME",$USER_TEXT,"NICK_NAME");
	$DEPT_TEXT_NAME = returntablefield("department","DEPT_ID",$DEPT_TEXT,"DEPT_NAME");
	print "<TR class=TableContent>\n";
	print "<TD nowrap class=TableData><font color=black title=\"".$USER_TEXT_NAME."һ��ͳ��������".$NewArray['USER_YEAR'][$USER_TEXT][$Year]."\">".$USER_TEXT_NAME."[".$DEPT_TEXT_NAME."]</font>&nbsp;</TD>\n";
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
	print "<TD nowrap class=TableData><font color=black title='".$USER_TEXT_NAME."�û�".$Year."��ͻ�����:".$NewArray['USER_YEAR'][$USER_TEXT][$Year]."'>".$Element."</font>&nbsp;</TD>\n";
	print "</TR>\n";
}

//������--��������
print "<TR class=TableContent>\n";
print "<TD nowrap title='�����б�'>�����б�</TD>\n";
for($i=1;$i<=12;$i++)				{
	$HeaderName = Date("Y-n",mktime(0,0,0,$i,Date("d"),$Year));
	print "<TD nowrap title='��ʾ".$HeaderName."�·�����ͳ����Ϣ'>$HeaderName</TD>\n";
}
print "<TD nowrap>".$Year."��</TD>\n";
print "</TR>\n";
//��������--��������
$DEPT_LIST = @array_keys($NewArray['DEPT']);
for($i=0;$i<sizeof($DEPT_LIST);$i++)				{
	$DEPT_TEXT = $DEPT_LIST[$i];
	$DEPT_TEXT_NAME = returntablefield("department","DEPT_ID",$DEPT_TEXT,"DEPT_NAME");
	print "<TR class=TableContent>\n";
	print "<TD nowrap class=TableData><font color=black title=\"".$DEPT_TEXT_NAME."һ��ͳ��������".$NewArray['DEPT_YEAR'][$DEPT_TEXT][$Year]."\">".$DEPT_TEXT_NAME."[".$NewArray['DEPT_YEAR'][$DEPT_TEXT][$Year]."]</font>&nbsp;</TD>\n";

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
	print "<TD nowrap class=TableData><font color=black title='".$DEPT_TEXT_NAME.$Year."��ͻ�����:".$NewArray['DEPT_YEAR'][$DEPT_TEXT][$Year]."'>".$Element."</font>&nbsp;</TD>\n";
	print "</TR>\n";
}

//�ϲ�˵��

print "<TR class=TableContent>\n";
print "<TD nowrap colspan=15 title='���ʹ���������ӡ����̫����Ļ������Ը��Ʊ����������MS EXCEL��Ȼ������Ű��ӡ' class=TableData>����˵�������������������ɫ���Ǽ�ͷ������ʵ�����֮����л�&nbsp;</TD>\n";
print "</TR>\n";


//����ͳ�����岿�ֿ�ʼ
for($k=0;$k<sizeof($showlistfieldlistArray);$k++)		{
	$fieldIndex = $showlistfieldlistArray[$k];
	$fieldName  = $columns[$fieldIndex];
	$fieldText  = $html_etc[$tablename][$fieldName];
	$mode = $showlistfieldfilterArray[$k];
	$modeArray = explode(':',$mode);
	//$rs=$db->CacheExecute(150,$SQL);
	//$rs_array=$rs->GetArray();//print_R($rs_array);
	//����ṹ����
	//�����������--���ݴ����� --�γ�FLASHҪ�������������


	//�����������--FALSHͼ����ʾ����--��ʾFLASHͼ��Ľ��

	//������Ϣ��ʾ����
	//print_title($html_etc[$tablename][$tabletitle]."<font color=green>[".$html_etc[$tablename][$fieldName]."]</font>",40);

			print "<TR class=TableData>";
			print "<TD width=30%>����</TD>";
			print "<TD width=30%>��Ŀ</TD>";
			print "<TD width=30%>�ٷֱ�</TD>";
			print "<TD width=30%>�ܼ�¼</TD>";
			print "</TR>";
			for($i=0;$i<sizeof($rs_array);$i++)				{
				$ResultNumber = $rs_array[$i][num];
				$ResultSum = $rs_array[$i][sum];
				$ResultFieldCode = $rs_array[$i][$fieldName];
				$ResultFieldName = returntablefield($tablenameIndex,$WhatIndex,$ResultFieldCode,$ReturnIndex);
				if($sum_index!="")			{
					print "<TD noWrap width=15%>ͳ�ƶ��&nbsp;</TD>";
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
 *@ϵͳ��Ŀ��Sunshine Anywhere Application Platform(SAAP)1.2
 *@����˵��������FLASH��ʾ����ÿ����õ�ɫ����Ϣ����
 *@�������ߣ�������
 *@�������ڣ�2005-10-16
 *@�������ڣ�2005-10-26
 *@�������ڣ�2006-04-20
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
 *@ϵͳ��Ŀ��Sunshine Anywhere Application Platform(SAAP)1.2
 *@����˵����FLASHͼ��XML��������
			 VBarF����
 *@�������ߣ�������
 *@�������ڣ�2005-10-16
 *@�������ڣ�2005-10-26
 *@״̬˵�����Ѿ�������
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
 *@ϵͳ��Ŀ��Sunshine Anywhere Application Platform(SAAP)1.2
 *@����˵����FLASHͼ��XML��������
			 HBarF����
 *@�������ߣ�������
 *@�������ڣ�2005-10-16
 *@�������ڣ�2005-10-26
 *@״̬˵�����Ѿ�������
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
 *@ϵͳ��Ŀ��Sunshine Anywhere Application Platform(SAAP)1.2
 *@����˵����FLASHͼ��XML��������
			 PieF����
 *@�������ߣ�������
 *@�������ڣ�2005-10-16
 *@�������ڣ�2005-10-26
 *@״̬˵�����Ѿ�������
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