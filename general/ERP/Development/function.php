<?php
function action_submit()											{
	global $sectionArray;
	//ģ�鶯��
	//add_default:new:n,export_default:export:x,import_default:import:i
	//submit:new:n,cancel:cancel:c
	$array = array("����"=>"submit:save:s","��ӡ"=>"print:print:p","����"=>"export:export:e","�޸���־"=>"modifyrecord:modifyrecord:m","����"=>"cancel:cancel:c","ͬ����ϵ��"=>"savelink:savelink:l");
	print "<TR><TD class=TableContent align=left width=25% colSpan=1>&nbsp;ģ�鶯��:</TD><TD class=TableContent align=left colSpan=1>&nbsp;\n";
	checkbox_array($array,"action_submit",$sectionArray['action_submit']);
	print "</TD></TR>";

}

function sectionName1()												{
	global $_GET,$actionModel;
	global $filename;
	global $SYSTEM_MODE_DIR;
	print "<table border=1 cellspacing=0 class=small bordercolor=#000000 cellpadding=3 align=center width=100% style=\"border-collapse:collapse\">\n";
	print "<TR><TD class=TableHeader align=left colSpan=4>&nbsp;ģ����ϸ ģ�����ƣ�".$_GET['sectionName']." �ļ�Դ��$filename</TD></TR>";
	switch($_GET['sectionName'])		{
		case 'init_default':
			$ImportAction = "init";
			break;
		case 'init_customer':
			$ImportAction = "init2";
			break;
		case 'edit_default':
			$ImportAction = "edit";
			break;
		case 'view_default':
			$ImportAction = "view";
			break;
		case 'batchedit_default':
			$ImportAction = "view2";
			break;
		case 'report_default':
			$ImportAction = "report";
			break;
		case 'statistics_default':
			$ImportAction = "statistics";
			break;
		case 'export_default':
			$ImportAction = "export";
			break;
		case 'import_default':
			$ImportAction = "import";
			break;
	}
	if($actionModel!="")			{
		print "
		<TR><TD class=TableControl noWrap align=middle  colspan=2>
		<div align=center>
		<INPUT class=SmallButton title=���� type=submit value=\" �� �� \" name=button>
		<INPUT class=SmallButton onclick=\"location='?Tablename=".$_GET['Tablename']."&FileIniname=".$_GET['FileIniname']."'\" type=button value='�ص��˵�'>
		<INPUT class=SmallButton onclick=\"location='?Tablename=".$_GET['Tablename']."&FileIniname=".$_GET['FileIniname']."&action=".$ImportAction."importfromaddview'\" type=button value='��������ͼ����'>
		<script Language=\"JavaScript\">
		function LoadWindow()
		{
			URL=\"../Interface/".$SYSTEM_MODE_DIR."/perview_system.php?Tablename=".$_GET['Tablename']."&FileIniname=".$_GET['FileIniname']."&action=".$_GET['sectionName']."\";
			loc_x=document.body.scrollLeft+event.clientX-event.offsetX-100;
			loc_y=document.body.scrollTop+event.clientY-event.offsetY+150;
  			window.showModalDialog(URL,self,\"edge:raised;scroll:0;status:0;help:0;resizable:1;dialogWidth:600px;dialogHeight:550px;dialogTop:\"+loc_y+\"px;dialogLeft:\"+loc_x+\"px\");
		}
		</script>
		<INPUT class=SmallButton onclick=\"LoadWindow();\" type=button value='ģ��Ԥ��'>
		</div>
		";
	}


}
function tablename()												{
	global $sectionArray;
	print "<TR><TD class=TableContent align=left width=25% colSpan=1 nowrap>&nbsp;������(����:Ӣ����):</TD><TD class=TableContent align=left width=75% colSpan=1>&nbsp;<input name=tabletitle type=text class=SmallStatic size=55  value=\"".$sectionArray['tablename']."\"></TD></TR>";

}
function tabletitle()												{
	global $sectionArray;
	print "<TR><TD class=TableContent align=left width=25% colSpan=1>&nbsp;������(����˵��):</TD><TD class=TableContent align=left colSpan=1>&nbsp;<input name=tabletitle type=text class=SmallStatic size=55  value=\"".$sectionArray['tabletitle']."\"></TD></TR>";

}
function tablewidth()												{
	global $sectionArray;
	$array = array("100%"=>"100%","85%"=>"85%","80%"=>"80%","65%"=>"65%");
	print "<TR><TD class=TableContent align=left width=25% colSpan=1>&nbsp;�����:</TD><TD class=TableContent align=left colSpan=1>&nbsp;\n";
	radio_array($array,"tablewidth",$sectionArray['tablewidth']);
	print "</TD></TR>";

}
function showfield_radio()											{
	global $sectionArray,$columns;
	$array = array_keys_values($columns);
	print "<TR><TD class=TableContent align=left width=25% colSpan=1>&nbsp;��ѡ����:</TD><TD class=TableContent align=left colSpan=1>";
	//Checkbox_array2($array,"showlistfieldlist",$sectionArray['showlistfieldlist']);
	table_infor();
	print "</TD></TR>";

}
function returnmodel()												{
	global $sectionArray;
	//����·������
	//add_default  init_default,filename.php
	print "<TR><TD class=TableContent align=left width=20% colSpan=1>&nbsp;����·������:</TD><TD class=TableContent align=left colSpan=1>&nbsp;<input name=returnmodel type=text class=SmallInput size=55 value=\"".$sectionArray['returnmodel']."\"><BR>\n";
	print "&nbsp;[Ĭ�Ϸ���·��:init_default ����׷�Ӳ����γ�:init_default,***.php&nbsp;]</TD></TR>";

}
function group_filter()												{
	global $sectionArray;
	//����·������
	//add_default  init_default,filename.php
	print "<TR><TD class=TableContent align=left width=20% colSpan=1>&nbsp;������������:</TD><TD class=TableContent align=left colSpan=1>&nbsp;<input name=group_filter type=text class=SmallInput size=55 value=\"".$sectionArray['group_filter']."\"><BR>\n";
	print "&nbsp;[�����б���ͼGROUP_FILTER������&nbsp;2:user:1:2&nbsp;��Ҫ���ڵ���ʱ���԰��û���������Ȩ��ϸ�� ֧��:hidden����]</TD></TR>";

}

function primary_key($information = "������ѡ��")					{
	global $sectionArray,$columns,$Tablerealname,$_GET,$html_etc;
	for($i=0;$i<sizeof($columns);$i++)		{
		$indexName = $columns[$i];
		$htmlName = $html_etc[$Tablerealname][$indexName];
		$newArray[$htmlName] = $i;
	}
	$newArray['����������'] = 'X';
	//��������

	print "<TR><TD class=TableContent align=left width=20% colSpan=1>&nbsp;������:</TD><TD class=TableContent align=left colSpan=1>&nbsp;<input name=primarykey type=text class=SmallInput size=55 value=\"".$sectionArray['primarykey']."\"><BR>\n";
	print "&nbsp;����ʱʹ��:����������:X ���ֶε���ʾ��: 2,3,4:userid,9:datetime,5:username</TD></TR>";
}
function unique_key($information = "��Ψһ��ѡ��")					{
	global $sectionArray,$columns,$Tablerealname,$_GET,$html_etc;
	for($i=0;$i<sizeof($columns);$i++)		{
		$indexName = $columns[$i];
		$htmlName = $html_etc[$Tablerealname][$indexName];
		$newArray[$htmlName] = $i;
	}
	//Ψһ������
	print "<TR><TD class=TableContent align=left width=25% colSpan=1>&nbsp;$information:</TD>\n";
	print "<TD class=TableContent align=left colSpan=1>&nbsp;<input name=uniquekey type=text class=SmallInput size=55 value=\"".$sectionArray['uniquekey']."\"><BR>\n";
	print "</TD></TR>";

}
function detailTable_key($information = "�ӱ����")					
{
	global $sectionArray;
	print "<script language='JavaScript' src='../Enginee/jquery/jquery.js'></script>
	<script type='text/javascript'>
		var i=".intval($sectionArray['subtablecount']).";

	function popFieldList(obj)
	{
		var sid=obj.id;
		var j=sid.split('_')[2];

		if($('#subtable_name_'+j).val()!='')
		{
			window.showModalDialog('childtable.php?tablename='+$('#subtable_name_'+j).val()+'&showlistfieldlist2='+$('#subtable_showlistfieldlist_'+j).val(),obj,'dialogWidth=300px;dialogHeight=400px');
		}
	}
	function addtable()
	{
		$('#table1').append('<tr id=tr' + i + ' ><td align=center>��<span id=line'+i+'>'+(i+1)+'</span>�������⣺<input name=subtable_title_'+i+' id=subtable_title_'+i+' type=text class=SmallInput size=25 value=\"\">&nbsp;�ӱ�����<input name=subtable_name_'+i+' id=subtable_name_'+i+' type=text class=SmallInput size=25 value=\"\"> �����<input name=subtable_key_'+i+' id=subtable_key_'+i+' type=text class=SmallInput size=15 value=\"\">	�ֶΣ�<input name=subtable_showlistfieldlist_'+i+' id=subtable_showlistfieldlist_'+i+' type=text class=SmallInput size=40 value=\"\" ondblclick=\"popFieldList(this)\"> ��Ӧ������<input name=maintable_key_'+i+' id=maintable_key_'+i+' type=text class=SmallInput size=15 value=\"\"> ������<input name=subtable_where_'+i+' id=subtable_where_'+i+' type=text class=SmallInput size=15 value=\"\"> <input type=button id=delbtn' + i + ' onclick=deleteTR('+i+') value=ɾ��><td></tr>');
		i++;
		$('#subtablecount').val(i);

	}
	function deleteTR(j)
	{
		$('#tr' + j).remove();
		for(m=j+1;m<i;m++)
		{
			$('#line'+m).attr('id','line'+(m-1));
			$('#line'+(m-1)).html(m);
			$('#subtable_title_'+m).attr('id','subtable_title_'+(m-1));
			$('#subtable_title_'+(m-1)).attr('name','subtable_title_'+(m-1));
			$('#subtable_name_'+m).attr('id','subtable_name_'+(m-1));
			$('#subtable_name_'+(m-1)).attr('name','subtable_name_'+(m-1));
			$('#subtable_key_'+m).attr('id','subtable_key_'+(m-1));
			$('#subtable_key_'+(m-1)).attr('name','subtable_key_'+(m-1));
			$('#subtable_showlistfieldlist_'+m).attr('id','subtable_showlistfieldlist_'+(m-1));
			$('#subtable_showlistfieldlist_'+(m-1)).attr('name','subtable_showlistfieldlist_'+(m-1));
			$('#maintable_key_'+m).attr('id','maintable_key_'+(m-1));
			$('#maintable_key_'+(m-1)).attr('name','maintable_key_'+(m-1));
			$('#subtable_where_'+m).attr('id','subtable_where_'+(m-1));
			$('#subtable_where_'+(m-1)).attr('name','subtable_where_'+(m-1));
		}
		i--;
		$('#subtablecount').val(i);
	}
	</script>
	<TR class=TableContent><TD>$information</td><td><input name='subtablecount' id='subtablecount' type='hidden' value='".$sectionArray['subtablecount']."'><input type='button' id='btn1' value='���һ��' onclick='addtable()'/></td></tr>
	<tr class=TableContent><td colspan=2><table id='table1' class=small>";
	for($i=0;$i<$sectionArray['subtablecount'];$i++)
	{
		print "<tr id=tr$i><td align=center>��<span id=line$i>".($i+1)."</span>�������⣺<input name=subtable_title_$i id=subtable_title_$i type=text class=SmallInput size=25 value='".$sectionArray['subtable_title_'.$i]."'>&nbsp;�ӱ�����<input name=subtable_name_$i id=subtable_name_$i type=text class=SmallInput size=25 value='".$sectionArray['subtable_name_'.$i]."'> �����<input name=subtable_key_$i id=subtable_key_$i type=text class=SmallInput size=15 value='".$sectionArray['subtable_key_'.$i]."'>	�ֶΣ�<input name=subtable_showlistfieldlist_$i id=subtable_showlistfieldlist_$i type=text class=SmallInput size=40 value='".$sectionArray['subtable_showlistfieldlist_'.$i]."' ondblclick=\"popFieldList(this)\"> ��Ӧ������<input name=maintable_key_$i id=maintable_key_$i type=text class=SmallInput size=15 value='".$sectionArray['maintable_key_'.$i]."'> ������<input name=subtable_where_$i id=subtable_where_$i type=text class=SmallInput size=15 value=\"".$sectionArray['subtable_where_'.$i]."\"> <input type=button id=delbtn$i onclick=deleteTR($i) value=ɾ��><td></tr>";
	}
	print "</table></td></tr>";


}
function table_infor()					{
	global $sectionArray,$file_ini,$columns,$Tablename,$_GET,$GlobalModel;

	print "<TR><TD class=TableContent align=left width=25% colSpan=2>\n";
	print $GlobalModel;
	print "<table border=1 cellspacing=0 class=small bordercolor=#000000 cellpadding=3 align=center width=100% style=\"border-collapse:collapse\">\n";
	print "<TR><TD class=TableContent align=left colSpan=4>&nbsp;����������ϸ <font color=green>INIT��ͼʱ��KEY�ֶβ���ȡ,�����ڱ���KEY���趨   add,edit,viewҲ����ѡȡ,ֻ���ڱ���KEY���趨</font>
	</TD></TR>";
	//�ֶα�ͷ��Ϣ
	print "<TR>";
	print "<TD class=TableContent align=left colSpan=1>&nbsp;��������</TD>\n";
	print "<TD class=TableContent align=left colSpan=1>&nbsp;�Ƿ�����</TD>\n";
	$GlobalModel=="init" ? print "<TD class=TableContent align=left colSpan=1>&nbsp;����ѡ��</TD>\n" : '';
	$GlobalModel=="init" ? print "<TD class=TableContent align=left colSpan=1>&nbsp;�߼�����</TD>\n" : '';
	$GlobalModel=="init" ? print "<TD class=TableContent align=left colSpan=1>&nbsp;������Ϣ</TD>\n" : '';
	$GlobalModel=="statistics" ? print "<TD class=TableContent align=left colSpan=1>&nbsp;ͼ������</TD>\n" : '';
	$ModelArray = array("add","edit");
	in_array($GlobalModel,$ModelArray) ? print "<TD class=TableContent align=left colSpan=1>&nbsp;�Ƿ��ֵ</TD>\n" : '';
	print "<TD class=TableContent align=left colSpan=1>&nbsp;�ֶ�����/��дȨ��</TD>\n";
	print "<TD class=TableContent align=left colSpan=1>&nbsp;�ֶ�����</TD>\n";
	if($GlobalModel=="init")		{
		$showlistfieldstopedit = $sectionArray['showlistfieldstopedit'];
		$showlistfieldstopeditArray = explode(',',$showlistfieldstopedit);
		$showlistfieldstopdelete = $sectionArray['showlistfieldstopdelete'];
		$showlistfieldstopdeleteArray = explode(',',$showlistfieldstopdelete);
		print "<TD class=TableContent align=left colSpan=1>&nbsp;�߼�����<BR>&nbsp;���ֶε���ʲôֵʱ���ñ༭��ɾ��</TD>\n";
	}
	print "</TR>";
	$showlistfieldlist = $sectionArray['showlistfieldlist'];
	$showlistfieldlistArray = explode(',',$showlistfieldlist);
	$listKeys = array_keys($showlistfieldlistArray);
	$listValues = array_values($showlistfieldlistArray);
	$list_keys_values = array_keys_values($showlistfieldlistArray);
	//$showlistfieldlistArrayReverse = array_reverse($showlistfieldlistArray);
	//print_R($showlistfieldlistArrayReverse);
	//�ֶο�ֵ��
	$showlistnull = $sectionArray['showlistnull'];
	$showlistnullArray = explode(',',$showlistnull);
	//�ֶι��˱�
	$showlistfieldfilter = $sectionArray['showlistfieldfilter'];
	$showlistfieldfilterArray = explode(',',$showlistfieldfilter);
	//�ֶι��˱�
	$showlistfieldtype = $sectionArray['showlistfieldtype'];
	$showlistfieldtypeArray = explode(',',$showlistfieldtype);
	//�ֶο�дȨ��
	$showlistfieldprivate = $sectionArray['showlistfieldprivate'];
	$showlistfieldprivateArray = explode(',',$showlistfieldprivate);

	$Tablename = $_GET['Tablename'];
	//��ֵ��Ϣ�趨
	$radio_array = array("��ֵ"=>"null","�ǿ�"=>"notnull");
	//ͳ��ͼ�������趨
	$radio_statistics = array("��ͼ"=>"pieF","����ͼ"=>"hBarF","����ͼ"=>"vBarF");
	//ͳ����Ϊ��ѡ���������ж�
	$FILTER_ARRAY = array("tablefilter","tablefiltercolor","radiofilter");
	//�ֶ������趨
	$radio_boolean = array("��"=>"1","��"=>"0");
	//������Ϣ�趨
	$action_search = $sectionArray['action_search'];
	$action_searchArray=array();
	if($action_search!="")
		$action_searchArray = explode(',',$action_search);
	$radio_search = array("����"=>"1","����"=>"0");

	//print_R($file_ini);

	//�߼������趨
	$exportadv_default_section = $file_ini['exportadv_default'];
	$showlistfieldlist_section = $exportadv_default_section['showlistfieldlist'];
	$showlistfieldfilter_section = $exportadv_default_section['showlistfieldfilter'];
	$action_search_advArray = explode(',',$showlistfieldlist_section);
	$radio_search_adv = array("�߼�����"=>"1","����"=>"0");

	//������Ϣ�趨
	$group_filter = $sectionArray['group_filter'];
	if($group_filter!="")
		$group_filterArray = explode(',',$group_filter);

	$newGroupArray = array();
	$IsGroupArrayHidden = array();
	for($i=0;$i<sizeof($group_filterArray);$i++)		{
		$tempArray = explode(":",$group_filterArray[$i]);
		$tempArray_INDEX = $tempArray[0];
		if($tempArray_INDEX!="")					{
			if($tempArray[4]=="")		{
				$GroupFilterArrayADD[$tempArray_INDEX] = $tempArray[1].":".$tempArray[2].":".$tempArray[3];
			}
			else	{
				$GroupFilterArrayADD[$tempArray_INDEX] = $tempArray[1].":".$tempArray[2].":".$tempArray[3].":".$tempArray[4];
			}
		}
		//print_R($tempArray);
		if(isset($tempArray[0]))		{
			array_push($newGroupArray,$tempArray[0]);
		}
		if(isset($tempArray[4]))		{
			array_push($IsGroupArrayHidden,$tempArray[0]);
		}
		//print_R($newGroupArray);
	}
	$radio_group = array("����"=>"1","����"=>"0");//print_R($newGroupArray);
	//Ȩ�޲��Ź���
	print "<input type=hidden name=departprivte value=".$sectionArray['departprivte'].">";
	//�ֶ���Ϣ�趨
	global $html_etc;
	for($i=0;$i<sizeof($columns);$i++)			{
		$columnName = $columns[$i];
		$indexName = $html_etc[$Tablename][$columnName];
		$listIndex = $list_keys_values[$i];
		$nullIndex = $showlistnullArray[$listIndex];
		$filterIndex = $showlistfieldfilterArray[$listIndex];
		$StopEditIndex = $showlistfieldstopeditArray[$listIndex];
		$StopDeleteIndex = $showlistfieldstopdeleteArray[$listIndex];
		$typeIndex = $showlistfieldtypeArray[$listIndex];
		$privateIndex = $showlistfieldprivateArray[$listIndex];
		print "<TR><TD class=TableContent align=left colSpan=1 nowrap>";
		print $i.".".$indexName."[".$columnName."]";
		print "</TD><TD class=TableContent align=left colSpan=1 nowrap>\n";
		//select_array($array,$columnName,$columnValue);
		//print "<input type=text name=".$columnName."_list class=SmallInput size=15 value=".$columnName.">";
		if(in_array($i,$showlistfieldlistArray))		{
			$boolean = 1;
			$readonly = "";
			$inputClass = "SmallInput";
		}
		else			{
			$boolean = 0;
			$readonly = "";
			$inputClass = "SmallStatic";
		}
		//print_R($action_search_advArray);
		if(in_array($i,$action_searchArray)&&$boolean==1)
			$boolean_search = 1;
		else
			$boolean_search = 0;

		if(in_array($i,$action_search_advArray)&&$boolean==1)
			$boolean_search_adv = 1;
		else
			$boolean_search_adv = 0;

		//print_R($newGroupArray);
		if(in_array($i,$newGroupArray,false)&&$boolean==1)
			$boolean_group = 1;
		else
			$boolean_group = 0;

		//print_R($IsGroupArrayHidden);
		if(in_array($i,$IsGroupArrayHidden)&&$boolean==1)
			$boolean_hidden = 1;
		else
			$boolean_hidden = 0;


		//ͳ���ֶο������ݳ�ʼ����
		$filterIndexArray = explode(':',$filterIndex);
		if($GlobalModel=="statistics")							{
			if(in_array($filterIndexArray[0],$FILTER_ARRAY))	{
				$boolean = 1;
			}
			else	{
				$boolean = 0;
			}
		}

		//�ֶο�����Ϣ
		//radio_array($radio_boolean,$columnName."_boolean",$boolean,"onclick",$i);

		if($boolean)	{
			$boolean_checked_boolean = "checked";
		}
		else	{
			$boolean_checked_boolean = '';
		}
		print "<input type=checkbox name=".$columnName."_boolean  $boolean_checked_boolean/> <font color=green>����</font>";


		//����Radio����
		print "<script>\n";
		print "function onClickUser_".$i."_1()	{\n";
		if($GlobalModel=="add"||$GlobalModel=="edit")	{
			print "	document.form1.".$columnName."_null.disabled = true;\n";
		}//��ֵ�ж�
		//if($GlobalModel=="add"||$GlobalModel=="edit")	{
			print "	document.form1.".$columnName."_filter.disabled = true;\n";
		//}//�����ж�
		//if($GlobalModel=="add"||$GlobalModel=="edit")	{
			print "	document.form1.".$columnName."_select.disabled = true;\n";
		//}//
		if($GlobalModel=="init")		{
			print "	document.form1.".$columnName."_search.disabled = true;\n";
			print "	document.form1.".$columnName."_group.disabled = true;\n";
		}
		print "}\n";
		print "function onClickUser_".$i."_0()	{\n";
		if($GlobalModel=="add"||$GlobalModel=="edit")	{
			print "	document.form1.".$columnName."_null.disabled = false;\n";
		}
		//if($GlobalModel=="add"||$GlobalModel=="edit")	{
			print "	document.form1.".$columnName."_filter.disabled = false;\n";
		//}
		//if($GlobalModel=="add"||$GlobalModel=="edit")	{
			print "	document.form1.".$columnName."_select.disabled = false;\n";
		//}
		if($GlobalModel=="init")		{
			print "	document.form1.".$columnName."_search.disabled = false;\n";
			print "	document.form1.".$columnName."_group.disabled = false;\n";
		}
		print "}\n";
		print "</script>\n";

		print "</TD>\n";

		//������Ϣ�趨
		if($GlobalModel=="init")		{
			print "<TD class=TableContent align=left colSpan=1 nowrap>\n";
			//radio_array($radio_search,$columnName."_search",$boolean_search);
			if($boolean_search)	{
				$boolean_checked_search = "checked";
			}
			else	{
				$boolean_checked_search = '';
			}
			print "<input type=checkbox name=".$columnName."_search  $boolean_checked_search/> <font color=green>����</font>";
			print "</TD>\n";
		}

		//�߼������趨
		if($GlobalModel=="init")		{
			print "<TD class=TableContent align=left colSpan=1 nowrap>\n";
			//radio_array($radio_search,$columnName."_search",$boolean_search);
			print $boolean_search_adv;
			if($boolean_search_adv&&$i>0)	{
				$boolean_checked_search_adv = "checked";
			}
			else	{
				$boolean_checked_search_adv = '';
			}
			print "<input type=checkbox name=".$columnName."_search_adv  $boolean_checked_search_adv/> <font color=gray>�߼�����</font>";
			print "</TD>\n";
		}

		//������Ϣ�趨
		if($GlobalModel=="init")		{
			//print_R($boolean_group);
			print "<TD class=TableContent align=left colSpan=1 nowrap>\n";
			//radio_array($radio_group,$columnName."_group",$boolean_group);
			if($boolean_group&&$i>0)	{
				$boolean_checked_group = "checked";
			}
			else	{
				$boolean_checked_group = '';
			}
			print "<input type=checkbox name=".$columnName."_group  $boolean_checked_group/> <font color=red>����</font>";
			if($boolean_hidden==1&&$i>0)	{
				$boolean_checked_hidden = "checked";
			}
			else	{
				$boolean_checked_hidden = '';
			}
			//print_R($filterIndexArray);
			if($filterIndexArray[0]=="userdefine"&&$i>0)		{
				$�����Ƿ��ض��� = "";
			}
			else		{
				$�����Ƿ��ض��� = "";
			}
			//print_R($GroupFilterArrayADD);
			if($GroupFilterArrayADD[$i]!=""&&$i>0)			{
				$GROUP_FILTER_TEXT = $GroupFilterArrayADD[$i];
			}
			else	{
				$GROUP_FILTER_TEXT = "";
			}
			print "<input type=checkbox name=".$columnName."_hidden $boolean_checked_hidden/> <font color=green title='$GROUP_FILTER_TEXT'>����$GROUP_FILTER_TEXT</font>";
			print "<input type=hidden name=".$columnName."_hidden_group_filter value='$GROUP_FILTER_TEXT'/>";

			print "</TD>\n";
		}

		//ͳ����Ϣ�趨

		if($GlobalModel=="statistics"&&$i>0)		{
			print "<TD class=TableContent align=left colSpan=1 nowrap>\n";
			//if(in_array($filterIndexArray[0],$FILTER_ARRAY))		{
				radio_array($radio_statistics,$columnName."_type",$typeIndex);
			//}
			print "</TD>\n";
		}


		//��ֵ��Ϣ�趨 �޶�����Ϣ�Ƿ���ʾ��
		if($nullIndex=="notnull")
			$NullValue = 1;
		else
			$NullValue = 0;
		$ModelArray = array("add","edit");
		if($GlobalModel=="add"||$GlobalModel=="edit")	{
			print "<TD class=TableContent align=left colSpan=1 nowrap>\n";
			Checkbox_One("�������ֵ",$columnName."_null",$NullValue,$boolean);
			print "</TD>";
		}

		//�ֶ�����
		print "<TD class=TableContent align=left colSpan=1 nowrap>\n";
		print "<input type=text name=".$columnName."_Order class=$inputClass size=5 value=".$list_keys_values[$i]."> ";
		if($GlobalModel=="add" || $GlobalModel=="edit")	
		{
		//��дȨ��
		print "<input type=text name=".$columnName."_private class=$inputClass size=5 value=".$privateIndex."> ";
		}
		print "</td>";

		//��ֵ��Ϣ������Ϣ����
		print "<TD class=TableContent align=left colSpan=1 nowrap>\n";
		print "<input type=text name=".$columnName."_filter $readonly class=$inputClass size=20 value=".$filterIndex."> ";
		global $SYSTEM_MODE_DIR;
		print "
		<script Language=\"JavaScript\">
		function LoadWindow_$columnName()
		{
			URL=\"LoadWindowsFrame.php?action=Detail&parentName=".$columnName."_filter&sectionName=input&SYSTEM_MODE=".$SYSTEM_MODE_DIR."\";
			loc_x=250;
			loc_y=150;
  			window.showModalDialog(URL,self,\"edge:raised;scroll:0;status:0;help:0;resizable:1;dialogWidth:570px;dialogHeight:550px;dialogTop:\"+loc_y+\"px;dialogLeft:\"+loc_x+\"px\");
		}
		</script>
			";
		print "<input type=button name = ".$columnName."_select onclick='LoadWindow_$columnName();' class=SmallButton value=ѡ��>";
		print "</td>";

		if($GlobalModel=="init")		{
			print "<TD class=TableContent align=left nowrap colSpan=1>
				����<input type=text name=".$columnName."_stop_edit class=SmallInput size=6 value=".$StopEditIndex.">ʱ,���ñ༭
				����<input type=text name=".$columnName."_stop_delete class=SmallInput size=6 value=".$StopDeleteIndex.">ʱ,����ɾ��
				</TD>\n";
		}

		print "</TR>";
	}
	print "</table>";
}

function array_keys_values($array)		{
	$keys = array_keys($array);
	$values = array_values($array);
	$newArray = array();
	for($i=0;$i<sizeof($values);$i++)	{
		$newArray[(String)$values[$i]] = $keys[$i];
	}
	return $newArray;
}

//RADIO FUNCTION
function radio_array($array,$name,$value,$onClick="",$m = "0")			{
	$array_keys = array_keys($array);
	$array_values = array_values($array);
	if(!in_array($value,$array)&&$value!="")		{
		array_push($array_keys,$value);
		array_push($array_values,$value);
	}
	$valueArray = explode(":",$value);
	$value2 = $valueArray[0];
	for($i=0;$i<sizeof($array_keys);$i++)		{
		//��һ�ι���
		//if($array_values[$i]==$value2)		{
		//	$checked = "checked";

		//}
		//else		{
			//$checked = "";
		//}
		//�ڶ��ι���
		if($array_values[$i]==$value)		{
			$checked = "checked";

		}
		else		{
			$checked = "";
		}

		if($onClick!="")		{
			$onClickText = "onclick=\"onClickUser_".$m."_".$i."();\"";
			//$nameText = $name;
		}
		else	{
			//$nameText = $name."_".$i;
		}
		print "<input $onClickText type=radio name=\"$name\" $checked value=\"".$array_values[$i]."\">".$array_keys[$i]."";
	}
}


//Checkbox FUNCTION
function Checkbox_One($Text,$name,$value,$disabled=0)			{

		if($value==1)
			$checked = "checked";
		else
			$checked = "";

		if($disabled==0)
			$disabled = "disabled";
		else
			$disabled = "";
		//print "<script>\n";
		//print "function Checkbox_Input".$name."()	{\n";
		//print "	document.form1.".$name.".disabled = false;\n";
		//print "}\n";
		//print "</script>\n";
		//print "<input type=hidden name=$name>";
		print "<input type=Checkbox name=\"$name\" $checked $disabled >".$Text."";
		//onClick=\"Checkbox_Input".$name."('$name')\"
}

function Checkbox_array2($array,$name,$value)				{
	global $html_etc;//print_R($html_etc);
	global $Tablename;
	//print $Tablename;
	$array_keys = array_keys($array);
	$array_values = array_values($array);
	for($i=0;$i<sizeof($array_keys);$i++)				{
		$valueArray = explode(',',$value);
		//����ָ��Ȩ����Ϣ�����γ�
		switch($name)								{
			case 'action_model':
				$ValueArray2 = explode(':',$valueArray[$i]);
				if(sizeof($ValueArray2)>3)		{
					array_pop($ValueArray2);
					$RealValue = $valueArray[$i];
					$valueArray[$i] = join(':',$ValueArray2);
				}
				else	{
					$RealValue = $array_values[$i];
				}
				break;
			default:
				$RealValue = $array_values[$i];
				break;
		}
		//�ж��Ƿ�ΪCHECKED
		if(in_array($array_values[$i],$valueArray))
			$checked = "checked";
		else
			$checked = "";
		print "&nbsp;$i <input type=Checkbox name=\"".$name."_$i\" $checked value=\"".$RealValue."\">".$html_etc[$Tablename][(string)$array_keys[$i]]."<BR>";
		//if($i%5==0&&$i>1)		print "<BR>";
	}
}

//Checkbox FUNCTION
function Checkbox_array($array,$name,$value)				{
	$array_keys = array_keys($array);
	$array_values = array_values($array);
	for($i=0;$i<sizeof($array_keys);$i++)				{
		$valueArray = explode(',',$value);
		//����ָ��Ȩ����Ϣ�����γ�
		switch($name)								{
			case 'action_model':
				$ValueArray2 = explode(':',$valueArray[$i]);
				if(sizeof($ValueArray2)>3)		{
					array_pop($ValueArray2);
					$RealValue = $valueArray[$i];
					$valueArray[$i] = join(':',$ValueArray2);
				}
				else	{
					$RealValue = $array_values[$i];
				}
				break;
			default:
				$RealValue = $array_values[$i];
				break;
		}
		//�ж��Ƿ�ΪCHECKED
		if(in_array($array_values[$i],$valueArray))
			$checked = "checked";
		else
			$checked = "";
		print "<input type=Checkbox name=\"".$name."_$i\" $checked value=\"".$RealValue."\">".$array_keys[$i]."";
		if($i%5==0&&$i>1)		print "<BR>";
	}
}

//returnCheckboxValue
function returnCheckboxValue($TempAction)			{
global $_POST,$ArrayGroup,$section;
if($_POST[$TempAction."_0"] != ""||$_POST[$TempAction."_1"] != ""||$_POST[$TempAction."_2"] != ""||$_POST[$TempAction."_3"] != ""||$_POST[$TempAction."_4"] != ""||$_POST[$TempAction."_5"] != ""||$_POST[$TempAction."_6"] != ""||$_POST[$TempAction."_7"] != ""||$_POST[$TempAction."_8"] != ""||$_POST[$TempAction."_9"] != ""||$_POST[$TempAction."_10"] != ""||$_POST[$TempAction."_11"] != ""||$_POST[$TempAction."_12"] != ""||$_POST[$TempAction."_13"] != ""||$_POST[$TempAction."_14"] != ""||$_POST[$TempAction."_15"] != ""||$_POST[$TempAction."_16"] != ""||$_POST[$TempAction."_17"] != ""||$_POST[$TempAction."_18"] != ""||$_POST[$TempAction."_19"] != ""||$_POST[$TempAction."_20"] != ""||$_POST[$TempAction."_21"] != "")				{
		$TempArray = array();
		for($i=0;$i<10;$i++)						{
			if($_POST[$TempAction."_".$i]!="")		{
				array_push($TempArray,$_POST[$TempAction."_".$i]);
			}//end if
		}//end for
		sizeof($TempArray)>0?$TempText = join(',',$TempArray):'';
	}//end if
	return $TempText;
}//end function

//SELECT FUNCTION
function select_array($array,$name,$value)			{
	$array_keys = array_keys($array);
	$array_values = array_values($array);
	if(!in_array($value,$array))		{
		array_push($array_keys,$value);
		array_push($array_values,$value);
	}
	print "<select class='SmallSelect' name='$name' onkeydown='if(event.keyCode==13)event.keyCode=9' >
";
	for($i=0;$i<sizeof($array_keys);$i++)		{
		$valueArray = explode(',',$value);
		if(in_array($array_values[$i],$valueArray))
			$selected = "selected";
		else
			$selected = "";
		print "<option value=".$array_values[$i]." $selected>".$array_keys[$i]."</option>";
	}
	print "</select>";
}






?>