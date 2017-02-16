<?php
/******************************************************************************
 *@ϵͳ��Ŀ��Sunshine Anywhere Application Platform(SAAP)1.2
 *@����˵����ʵ���˱����ͳ�Ʋ��ֹ��ܣ���Ҫ֧��һ���������ͣ�TableFilterϵ��,����:tablefiltercolor/radiofilter/radiofiltercolor
			 ֧��һ��ͳ�Ʒ���������ͳ��
			 ֧������ͳ����ʾ��ͼ����ʾ��������ʾ
 *@�������ߣ�������
 *@�������ڣ�2005-10-16
 *@�������ڣ�2005-10-26
 *@״̬˵�����Ѿ�������
 */
function newaiCharts()		{
global $html_etc,$tablename,$common_html,$custom_type;
global $db,$return_sql_line,$columns;
global $_POST,$_GET,$returnmodel,$primarykey_index;
global $action_submit,$merge,$form_attribute;
global $tabletitle;

global $showlistfieldlist,$showlistfieldfilter,$showlistfieldtype;
$showlistfieldlistArray=explode(',',$showlistfieldlist);
$showlistfieldfilterArray=explode(',',$showlistfieldfilter);
$showlistfieldtypeArray=explode(',',$showlistfieldtype);
//��ȡϵͳ��ʾ��ɫ����Ϣ
$ColorArray = returnColorArray();
//��ȡϵͳ����ֶ���Ϣ
global $sum_index,$UserUnitFunctionIndex;
if($sum_index!="")			{
	$sum_sql_index = " ,sum($sum_index) as sum ";
}
else	{
	$sum_sql_index = "";
}
//����ͳ�����岿�ֿ�ʼ
for($k=0;$k<sizeof($showlistfieldlistArray);$k++)		{
	$fieldIndex = $showlistfieldlistArray[$k];
	$fieldName  = $columns[$fieldIndex];
	$fieldText  = $html_etc[$tablename][$fieldName];
	$mode = $showlistfieldfilterArray[$k];
	$modeArray = explode(':',$mode);
	//print_R($modeArray);
	$modeIndex = $modeArray[0];
	$Mode = "";
	switch($modeIndex)				{
		case '':
			break;
		case 'tablefilter':
		case 'tablefiltercolor':
		case 'radiofilter':
		case 'radiofiltercolor':
			if($modeArray[1]=="month"&&$modeArray[2]=="")		{
				$Mode = "Month";
				$SQL = "select Date_Format($fieldName,'%c') AS $fieldName,Sum($sum_index) as sum,Count($fieldName) as num from $tablename group by $fieldName";
			}
			else if($modeArray[1]=="year"&&$modeArray[2]=="")		{
				$Mode = "Year";
				$SQL = "select Date_Format($fieldName,'%Y') AS $fieldName,Sum($sum_index) as sum,Count($fieldName) as num from $tablename group by $fieldName";
			}
			else	{
				$Mode = "";
				$SQL = "select $fieldName,Count($fieldName) as num $sum_sql_index from $tablename group by $fieldName";
			}
			$rs=$db->CacheExecute(150,$SQL);
			$rs_array=$rs->GetArray();//print_R($rs_array);
			//����ṹ����
			$tablenameIndex = $modeArray[1];
			$ColumnsIndex = returntablecolumn($tablenameIndex);
			$html_etcIndex = returnsystemlang($tablenameIndex,$tablenameIndex);
			$WhatIndex = $ColumnsIndex[(String)$modeArray[2]];
			$ReturnIndex = $ColumnsIndex[(String)$modeArray[3]];
			//�����������--���ݴ����� --�γ�FLASHҪ�������������
			$TotalNumberIndex = 0;
			$TotalSumIndex = 0;
			$Array = array();
			for($i=0;$i<sizeof($rs_array);$i++)		{
				$ResultNumber = $rs_array[$i]['num'];
				$ResultSum = $rs_array[$i]['sum'];
				$ResultFieldCode = $rs_array[$i][$fieldName];
				switch($Mode)	{
					case 'Month':
						$ResultFieldName = $ResultFieldCode."".$common_html['common_html']['month'];
						break;
					case 'Year':
						$ResultFieldName = $ResultFieldCode."".$common_html['common_html']['year'];
						break;
					default:
						$ResultFieldName = returntablefield($tablenameIndex,$WhatIndex,$ResultFieldCode,$ReturnIndex);
						if($ResultFieldName=="") $ResultFieldName = $ResultFieldCode;
						break;
				}
				$TotalNumberIndex += $ResultNumber;
				$TotalSumIndex += $ResultSum;
				$Array_Statistic_Value = $sum_index!=""?$ResultSum:$ResultNumber;
				$Array['XData'][$i]['Name'] = $ResultFieldName;
				$Array['XData'][$i]['Value'] = $Array_Statistic_Value;
				$Array['XData'][$i]['Dir'] = $ResultFieldName;
				$Array['XData'][$i]['AltText'] = $ResultFieldName;
				//$Array['XData'][$i]['Url'] = "?action=init_customer&$fieldName=$ResultFieldCode";
				$ColorArray[$i]==""?$ColorArray[$i]="0xCC0000":'';
				$Array['XData'][$i]['Color'] = $ColorArray[$i];

				$Array['Dir'][$i]['Name'] = $ResultFieldName;
				$Array['Dir'][$i]['Color'] = $ColorArray[$i];

				$Array['YData']['AltText'] = "�ƶ��鿴��ϸ��Ϣ";
				$Array['YData']['Value'] < $Array_Statistic_Value ? $Array['YData']['Value'] = $Array_Statistic_Value : '' ;

			}

			$Array['title'] = $html_etc[$tablename][$tabletitle]."[".$html_etc[$tablename][$fieldName]."]";
			$array_graphInfo = $Array['title']."[".date("Y-m-d H:i:s")."] ".$common_html['common_html']['totalrecords'].": ".$TotalNumberIndex;
			if($sum_index!="")			{
				$array_graphInfo .= "��".$common_html['common_html']['allnumbers'].": ".$TotalSumIndex." &nbsp;".$UserUnitFunctionIndex."\n";
			}
			$Array['graphInfo'] = $array_graphInfo;
			//print_R($FlashFileName);
			//�����������--FALSHͼ����ʾ����--��ʾFLASHͼ��Ľ��
			table_begin("650");
			$ChartMode = $showlistfieldtypeArray[$k];
			//���õ�ͼ������ѡ��
			//print $tablename;
			switch($ChartMode)		{
				case 'vBarF':
					$FlashFileName = WriteXmlFilevBarF($Array,$tablename,$k);//Flash XML ����д���ļ���
					$create_chart=create_chart("vBarF",$FlashFileName);//FLASH ͼ�����XML���ݴ����Ժ����ʾ��
					break;
				case 'hBarF':
					$FlashFileName = WriteXmlFilehBarF($Array,$tablename,$k);//Flash XML ����д���ļ���
					$create_chart=create_chart("hBarF",$FlashFileName);//FLASH ͼ�����XML���ݴ����Ժ����ʾ��
					break;
				case 'pieF':
					$FlashFileName = WriteXmlFilePieF($Array,$tablename,$k);//Flash XML ����д���ļ���
					$create_chart=create_chart("pieF",$FlashFileName);//FLASH ͼ�����XML���ݴ����Ժ����ʾ��
					break;
				default :
					$FlashFileName = WriteXmlFilevBarF($Array,$tablename,$k);//Flash XML ����д���ļ���
					$create_chart=create_chart("vBarF",$FlashFileName);//FLASH ͼ�����XML���ݴ����Ժ����ʾ��
					break;
			}
			//HTML������ʾ����
			print "<TR class=TableData>";
			print "<TD noWrap width=100% align=center colspan=40>";
			print "$create_chart &nbsp;</TD>";
			print "</TR>";
			//������Ϣ��ʾ����
			//print_title($html_etc[$tablename][$tabletitle]."<font color=green>[".$html_etc[$tablename][$fieldName]."]</font>",40);
			print_title($html_etc[$tablename][$tabletitle]."[".$html_etc[$tablename][$fieldName]."]",6);
			for($i=0;$i<sizeof($rs_array);$i++)		{
				$ResultNumber = $rs_array[$i][num];
				$ResultSum = $rs_array[$i][sum];
				$ResultFieldCode = $rs_array[$i][$fieldName];
				$ResultFieldName = returntablefield($tablenameIndex,$WhatIndex,$ResultFieldCode,$ReturnIndex);
				if($ResultFieldName=="") $ResultFieldName = $ResultFieldCode;
				print "<TR class=TableData>";
				print "<TD noWrap width=15%>ͳ���������&nbsp;</TD>";
				print "<TD width=35%>".$ResultFieldName."&nbsp;</TD>";
				if($sum_index!="")			{
					print "<TD noWrap width=15%>ͳ�ƶ��&nbsp;</TD>";
					print "<TD noWrap width=10%><font color=red>".$ResultSum."&nbsp;".$UserUnitFunctionIndex."</font></TD>";
				}
				else	{
					//print "<TD noWrap width=15%>ͳ��������&nbsp;</TD>";
					//print "<TD noWrap width=10%>".$ResultFieldCode."&nbsp;</TD>";
				}
				print "<TD  width=15%>ͳ�Ƽ�¼��&nbsp;</TD>";
				print "<TD noWrap width=10%><font color=red>".$ResultNumber."&nbsp;��</font></TD>";
				print "</TR>";
			}
			print "<TR class=TableData>";
			print "<TD noWrap colspan = 40>\n";
			print $common_html['common_html']['totalrecords'].": <font color=red>$TotalNumberIndex &nbsp;��</font>\n";
			if($sum_index!="")			{
				print $common_html['common_html']['allnumbers'].": <font color=red>$TotalSumIndex &nbsp;".$UserUnitFunctionIndex."</font>\n";
			}
			print "</TD>";
			print "</TR>";
			table_end();
			print "<BR>";
			break;
	}
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
function WriteXmlFileVBarF($Array,$fieldName,$ModuleName)							{
	$filename = "../../cache/xml/".Date("Y-m-d-H")."-".$fieldName."-".$ModuleName."-vBarF.xml";
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
function WriteXmlFileHBarF($Array,$fieldName,$ModuleName)					{
	$filename = "../../cache/xml/".Date("Y-m-d-H")."-".$fieldName."-".$ModuleName."-hBarF.xml";
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
function WriteXmlFilePieF($Array,$fieldName,$ModuleName)						{
	$filename = "../../cache/xml/".Date("Y-m-d-H")."-".$fieldName."-".$ModuleName."-pieF.xml";
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