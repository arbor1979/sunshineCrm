<?php
/*
��Ȩ����:֣�ݵ���Ƽ�������޹�˾;
��ϵ��ʽ:0371-69663266;
��˾��ַ:����֣�ݾ��ü��������������־�����·ͨ�Ų�ҵ԰��¥����;
��˾���:֣�ݵ���Ƽ�������޹�˾λ���й��в�����-֣��,������2007��1��,�����ڰѻ����Ƚ���Ϣ����������ͨ�ż���������ѹ�����ҵ��ʵ���ռ���������ҵ�ͻ��Ĺ�����ҵ���»�У�ȫ���ṩ��������֪ʶ��Ȩ�Ľ�����������������������������в�������ĸ�У���������������СѧУ��������ṩ�̡�Ŀǰ�����ж�Ҹ�ְ����ְ��ԺУʹ��ͨ���в��з����Ŀ���������ͷ���;

�������:����Ƽ�������������Լܹ�ƽ̨,�Լ��������֮����չ���κ��������Ʒ;
����Э��:���ֻ�У԰��ƷΪ��ҵ���,�������ΪLICENSE��ʽ;����CRMϵͳ��SunshineCRMϵͳΪGPLV3Э�����,GPLV3Э����������뵽�ٶ�����;
��������:�����ʹ�õ�ADODB��,PHPEXCEL��,SMTARY���ԭ��������,���´���������������;
*/

function print_select_department( $var_text = "", $initvalue = "", $status = 1 )
{
				global $choose_lang;
				global $html_etc;
				print "<TR>";
				print "<TD class=TableData noWrap>{$var_text}</TD>\n";
				print "<TD class=TableData noWrap>\n";
				global $db;
				$sql = "select * from department";
				$rs = $db->execute( $sql );
				print "<select name=\"departmentid\" class=\"BigSelect\" >\n";
				if ( $status == 1 )
				{
								if ( isset( $initvalue ) && $initvalue == 0 )
								{
												print " <option value=\"0\" selected>".$html_etc[$choose_lang]['���в���']."</option>\n";
								}
								else
								{
												print " <option value=\"0\">".$html_etc[$choose_lang]['���в���']."</option>\n";
								}
				}
				while ( !$rs->EOF )
				{
								if ( $choose_lang == "en" )
								{
												$name = $rs->fields[englishname];
								}
								else
								{
												$name = $rs->fields[departmentname];
								}
								$departmentid = $rs->fields[departmentid];
								if ( isset( $initvalue ) && $departmentid == $initvalue )
								{
												print " <option value=\"{$departmentid}\" selected>{$name}</option>\n";
								}
								else
								{
												print " <option value=\"{$departmentid}\" >{$name}</option>\n";
								}
								$rs->movenext( );
				}
				print "</select>\n";
				print "</TD></TR>\n";
}

function print_select_department_new( $var_text = "", $initvalue = "", $identity )
{
				global $choose_lang;
				global $html_etc;
				print "<TR>";
				print "<TD class=TableData noWrap>{$var_text}</TD>\n";
				print "<TD class=TableData noWrap>\n";
				global $db;
				if ( $identity == "teacher" )
				{
								$rs = getdepartmentall_teacherdepart( );
				}
				else if ( $identity == "user" )
				{
								$rs = getdepartmentall_teacherdepart( );
				}
				else if ( $identity == "department" )
				{
								$rs = getdepartmentall( );
				}
				else
				{
								$rs = getdepartmentall( );
				}
				print "<select name=\"departmentid\" class=\"BigSelect\" >\n";
				while ( !$rs->EOF )
				{
								if ( $choose_lang == "en" )
								{
												$name = $rs->fields[englishname];
								}
								else
								{
												$name = $rs->fields[departmentname];
								}
								$departmentid = $rs->fields[departmentid];
								if ( isset( $initvalue ) && $departmentid == $initvalue )
								{
												print " <option value=\"{$departmentid}\" selected>{$name}</option>\n";
								}
								else
								{
												print " <option value=\"{$departmentid}\" >{$name}</option>\n";
								}
								$rs->movenext( );
				}
				print "</select>\n";
				print "</TD></TR>\n";
}

function print_select_userpriv( $initvalue = "", $identity )
{
				global $choose_lang;
				global $html_etc;
				print "<TR>";
				print "<TD class=TableData noWrap>".$html_etc[$choose_lang]['��ɫ']."��</TD>\n";
				print "<TD class=TableData noWrap>\n";
				global $db;
				if ( $identity == "teacher" )
				{
								$rs = getuserpriv( 4 );
				}
				else if ( $identity == "user" )
				{
								$rs = getuserpriv( 5 );
				}
				else
				{
								$rs = getuserprivall( );
				}
				print "<select name=\"userprivid\" class=\"BigSelect\" >\n";
				while ( !$rs->EOF )
				{
								if ( $choose_lang == "en" )
								{
												$privname = $rs->fields[englishname];
								}
								else
								{
												$privname = $rs->fields[privname];
								}
								$userprivid = $rs->fields[userprivid];
								if ( isset( $initvalue ) && $userprivid == $initvalue )
								{
												print " <option value=\"{$userprivid}\" selected>{$privname}</option>\n";
								}
								else
								{
												print " <option value=\"{$userprivid}\" >{$privname}</option>\n";
								}
								$rs->movenext( );
				}
				print "</select>\n";
				print "</TD></TR>\n";
}

function print_select_student( $classid, $initvalue )
{
				global $choose_lang;
				global $html_etc;
				print "<TR>";
				print "<TD class=TableData noWrap>".$html_etc[$choose_lang]['ѡ�����Ա']."��</TD>\n";
				print "<TD class=TableData noWrap>\n";
				global $db;
				$sql = "select userid,nickname from user where departmentid={$classid} and userprivid=5 order by nickname";
				$rs = $db->execute( $sql );
				print "<select name=\"studentid\" class=\"BigSelect\" >\n";
				while ( !$rs->EOF )
				{
								if ( $choose_lang == "en" )
								{
												$nickname = $rs->fields[nickname];
								}
								else
								{
												$nickname = $rs->fields[nickname];
								}
								$studentid = $rs->fields[userid];
								if ( isset( $initvalue ) && $studentid == $initvalue )
								{
												print " <option value=\"{$studentid}\" selected>{$nickname}</option>\n";
								}
								else
								{
												print " <option value=\"{$studentid}\" >{$nickname}</option>\n";
								}
								$rs->movenext( );
				}
				print "</select>\n";
				print "</TD></TR>\n";
}

function print_select_department_sure( $departmentid )
{
				global $choose_lang;
				global $html_etc;
				$departmentname = getdepartmentname( $departmentid );
				print "<TR>";
				print "<TD class=TableData noWrap>".$html_etc[$choose_lang]['����']."��</TD>\n";
				print "<TD class=TableData noWrap>\n";
				print "<select name=\"departmentid\" class=\"BigSelect\" >\n";
				print " <option value=\"0\">{$departmentname}</option>\n";
				print "</select>\n";
				print "</TD></TR>\n";
}

function print_select_marry( $init = "", $colspan = 1 )
{
				global $choose_lang;
				global $html_etc;
				global $array_marry;
				print "<TR>";
				print "<TD class=TableData noWrap>".$html_etc[$choose_lang]['����״��']."�� </TD>\n";
				print "<TD class=TableData noWrap colspan=\"{$colspan}\">\n";
				print "<select class=\"BigSelect\" name=\"marry\" >\n";
				$sizeof = sizeof( $array_marry[$choose_lang] );
				$i = 0;
				for ( ;	$i < $sizeof;	++$i	)
				{
								if ( $init == $i )
								{
												print "<option value=\"{$i}\" selected>".$array_marry[$choose_lang][$i]."</option>\n";
								}
								else
								{
												print "<option value=\"{$i}\">".$array_marry[$choose_lang][$i]."</option>\n";
								}
				}
				print "</select>\n";
				print "</TD></TR>\n";
}

function print_select_sex( $init = "", $colspan = 1 )
{
				global $choose_lang;
				global $html_etc;
				global $array_sex;
				print "<TR>";
				print "<TD class=TableData noWrap>".$html_etc[$choose_lang]['�Ա�']."�� </TD>\n";
				print "<TD class=TableData noWrap colspan=\"{$colspan}\">\n";
				print "<select class=\"BigSelect\" name=\"sex\" >\n";
				$sizeof = sizeof( $array_sex[$choose_lang] );
				$i = 0;
				for ( ;	$i < $sizeof;	++$i	)
				{
								if ( $init == $i )
								{
												print "<option value=\"{$i}\" selected>".$array_sex[$choose_lang][$i]."</option>\n";
								}
								else
								{
												print "<option value=\"{$i}\">".$array_sex[$choose_lang][$i]."</option>\n";
								}
				}
				print "</select>\n";
				print "</TD></TR>\n";
}

function print_select_politic( $init = "", $colspan = 1 )
{
				global $choose_lang;
				global $html_etc;
				global $array_politic;
				print "<TR>";
				print "<TD class=TableData noWrap>".$html_etc[$choose_lang]['������ò']."�� </TD>\n";
				print "<TD class=TableData noWrap colspan=\"{$colspan}\">\n";
				print "<select class=\"BigSelect\" name=\"politic\" >\n";
				$sizeof = sizeof( $array_politic[$choose_lang] );
				$i = 0;
				for ( ;	$i < $sizeof;	++$i	)
				{
								if ( $init == $i )
								{
												print "<option value=\"{$i}\" selected>".$array_politic[$choose_lang][$i]."</option>\n";
								}
								else
								{
												print "<option value=\"{$i}\">".$array_politic[$choose_lang][$i]."</option>\n";
								}
				}
				print "</select>\n";
				print "</TD></TR>\n";
}

function print_select_education( $init = "", $colspan = 1 )
{
				global $choose_lang;
				global $html_etc;
				print "<TR>";
				print "<TD class=TableData noWrap>".$html_etc[$choose_lang]['ѧ��']."�� </TD>\n";
				print "<TD class=TableData noWrap colspan=\"{$colspan}\">\n";
				print "<select class=\"BigSelect\" name=\"education\" >\n";
				$array = array( "Сѧ", "����", "����", "��ר", "ר��", "��", "˶ʿ", "��ʿ", "��ʿ��" );
				$sizeof = sizeof( $array );
				$i = 0;
				for ( ;	$i < $sizeof;	++$i	)
				{
								if ( $init != "" && isset( $init ) && $init == $array[$i] )
								{
												print "<option value=\"{$array[$i]}\" selected>{$array[$i]}</option>\n";
								}
								else
								{
												print "<option value=\"{$array[$i]}\">{$array[$i]}</option>\n";
								}
				}
				print "</select>\n";
				print "</TD></TR>\n";
}

function print_select_changeusergroup( $init1 = 1 )
{
				global $db;
				global $choose_lang;
				global $html_etc;
				$rst = getdepartmentall( );
				print "<TR><TD class=TableData noWrap>".$html_etc[$choose_lang]['�޸��û�������']."��</TD><TD class=TableData noWrap>\n";
				print "<SELECT name=departmentid_add>\n";
				while ( !$rst->EOF )
				{
								$departmentid = $rst->fields[departmentid];
								if ( $choose_lang == "en" )
								{
												$name = $rs->fields[englishname];
								}
								else
								{
												$name = $rs->fields[departmentname];
								}
								if ( $init1 == $departmentid )
								{
												print "<OPTION value={$departmentid} selected>{$name}</OPTION>\n";
								}
								else
								{
												print "<OPTION value={$departmentid}>{$name}</OPTION>\n";
								}
								++$i;
								$rst->movenext( );
				}
				print "</SELECT>&nbsp; </TD></TR>\n";
}

function print_select_year( $init = "", $colspan = 1 )
{
				global $choose_lang;
				global $html_etc;
				print "<TR>";
				print "<TD class=TableData noWrap width=25%>".$html_etc[$choose_lang]['���']."�� </TD>\n";
				print "<TD class=TableData noWrap colspan=\"{$colspan}\">\n";
				print "<select class=\"BigSelect\" name=\"select_year\" >\n";
				$array = array( "2004", "2005", "2006", "2007", "2008", "2009", "2010", "2011", "2012" );
				$sizeof = sizeof( $array );
				if ( $init == "" )
				{
								$init = date( "Y" );
				}
				$i = 0;
				for ( ;	$i < $sizeof;	++$i	)
				{
								if ( $init != "" && isset( $init ) && $init == $array[$i] )
								{
												print "<option value=\"{$array[$i]}\" selected>{$array[$i]}</option>\n";
								}
								else
								{
												print "<option value=\"{$array[$i]}\">{$array[$i]}</option>\n";
								}
				}
				print "</select>\n";
				print "</TD></TR>\n";
}

function print_select_lang( $init = "", $colspan = 1 )
{
				global $choose_lang;
				global $html_etc;
				print "<TR>";
				print "<TD class=TableData noWrap width=25%>".$html_etc[$choose_lang]['����']."�� </TD>\n";
				print "<TD class=TableData noWrap colspan=\"{$colspan}\">\n";
				print "<select class=\"BigSelect\" name=\"select_lang\" >\n";
				$array = array( "chinese", "English" );
				$array_var = array( "zh", "en" );
				$sizeof = sizeof( $array );
				if ( $init == "" )
				{
								$init = date( "Y" );
				}
				$i = 0;
				for ( ;	$i < $sizeof;	++$i	)
				{
								if ( $init != "" && isset( $init ) && $init == $array_var[$i] )
								{
												print "<option value=\"{$array_var[$i]}\" selected>".$array[$i]."</option>\n";
								}
								else
								{
												print "<option value=\"{$array_var[$i]}\">".$array[$i]."</option>\n";
								}
				}
				print "</select>\n";
				print "</TD></TR>\n";
}

function print_select_countmethod( $init = "", $colspan = 1 )
{
				global $choose_lang;
				global $html_etc;
				global $array_countmethod;
				print "<TR>";
				print "<TD class=TableData noWrap width=25%>".$html_etc[$choose_lang]['�Ʒַ�ʽ']."�� </TD>\n";
				print "<TD class=TableData noWrap colspan=\"{$colspan}\">\n";
				print "<select class=\"BigSelect\" name=\"countmethod\" >\n";
				$sizeof = sizeof( $array_countmethod[$choose_lang] );
				if ( $init == "" )
				{
								$init = date( "Y" );
				}
				$i = 0;
				for ( ;	$i < $sizeof;	++$i	)
				{
								if ( $init != "" && isset( $init ) && $init == $array_countmethod[$choose_lang][$i] )
								{
												print "<option value=\"{$i}\" selected>".$array_countmethod[$choose_lang][$i]."</option>\n";
								}
								else
								{
												print "<option value=\"{$i}\">".$array_countmethod[$choose_lang][$i]."</option>\n";
								}
				}
				print "</select>\n";
				print "</TD></TR>\n";
}

function print_select_coursetype( $init = "", $colspan = 1 )
{
				global $choose_lang;
				global $html_etc;
				global $array_coursetype;
				print "<TR>";
				print "<TD class=TableData noWrap width=25%>".$html_etc[$choose_lang]['�γ����']."�� </TD>\n";
				print "<TD class=TableData noWrap colspan=\"{$colspan}\">\n";
				print "<select class=\"BigSelect\" name=\"coursetype\" >\n";
				$sizeof = sizeof( $array_coursetype[$choose_lang] );
				if ( $init == "" )
				{
								$init = date( "Y" );
				}
				$i = 0;
				for ( ;	$i < $sizeof;	++$i	)
				{
								if ( $init != "" && isset( $init ) && $init == $array_coursetype[$choose_lang][$i] )
								{
												print "<option value=\"{$i}\" selected>".$array_coursetype[$choose_lang][$i]."</option>\n";
								}
								else
								{
												print "<option value=\"{$i}\">".$array_coursetype[$choose_lang][$i]."</option>\n";
								}
				}
				print "</select>\n";
				print "</TD></TR>\n";
}

function print_select_coursepro( $init = "", $colspan = 1 )
{
				global $choose_lang;
				global $html_etc;
				global $array_coursepro;
				print "<TR>";
				print "<TD class=TableData noWrap width=25%>".$html_etc[$choose_lang]['���������']."�� </TD>\n";
				print "<TD class=TableData noWrap colspan=\"{$colspan}\">\n";
				print "<select class=\"BigSelect\" name=\"coursepro\" >\n";
				$sizeof = sizeof( $array_coursepro[$choose_lang] );
				if ( $init == "" )
				{
								$init = date( "Y" );
				}
				$i = 0;
				for ( ;	$i < $sizeof;	++$i	)
				{
								if ( $init != "" && isset( $init ) && $init == $array_coursepro[$choose_lang][$i] )
								{
												print "<option value=\"{$i}\" selected>".$array_coursepro[$choose_lang][$i]."</option>\n";
								}
								else
								{
												print "<option value=\"{$i}\">".$array_coursepro[$choose_lang][$i]."</option>\n";
								}
				}
				print "</select>\n";
				print "</TD></TR>\n";
}

function print_select_month( $init = "", $colspan = 1 )
{
				global $choose_lang;
				global $html_etc;
				print "<TR>";
				print "<TD class=TableData noWrap>".$html_etc[$choose_lang]['�·�']."�� </TD>\n";
				print "<TD class=TableData noWrap colspan=\"{$colspan}\">\n";
				print "<select class=\"BigSelect\" name=\"select_month\" >\n";
				$array = array( "01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12" );
				$sizeof = sizeof( $array );
				if ( $init == "" )
				{
								$init = date( "m" );
				}
				$i = 0;
				for ( ;	$i < $sizeof;	++$i	)
				{
								if ( $init != "" && isset( $init ) && $init == $array[$i] )
								{
												print "<option value=\"{$array[$i]}\" selected>{$array[$i]}</option>\n";
								}
								else
								{
												print "<option value=\"{$array[$i]}\">{$array[$i]}</option>\n";
								}
				}
				print "</select>\n";
				print "</TD></TR>\n";
}

function print_select_simordou( $init, $colspan = 1 )
{
				print "<TR>";
				print "<TD class=TableData noWrap>��˫�ܣ� </TD>\n";
				print "<TD class=TableData noWrap colspan=\"{$colspan}\">\n";
				print "<select class=\"BigSelect\" name=\"simordou\" >\n";
				global $simordou_array;
				$sizeof = sizeof( $simordou_array );
				$i = 0;
				for ( ;	$i < $sizeof;	++$i	)
				{
								if ( $init == $i )
								{
												print "<option value=\"{$i}\" selected>{$simordou_array[$i]}</option>\n";
								}
								else
								{
												print "<option value=\"{$i}\">{$simordou_array[$i]}</option>\n";
								}
				}
				print "</select>\n";
				print "</TD></TR>\n";
}

function print_select_class( $var_text = "�༶", $professid, $initvalue, $add = "" )
{
				if ( $add != "index" )
				{
								print "<TR>";
								print "<TD class=TableData noWrap>{$var_text}</TD>\n";
								print "<TD class=TableData noWrap>\n";
				}
				global $db;
				$rs = getclassall( $professid );
				print "<select name=\"classid\" class=\"BigSelect\" >\n";
				while ( !$rs->EOF )
				{
								$classid = $rs->fields[classid];
								$classname = $rs->fields[classname];
								$userschoolyear = $rs->fields[userschoolyear];
								$classname = $userschoolyear.$classname;
								if ( isset( $initvalue ) && $classid == $initvalue )
								{
												print " <option value=\"{$classid}\" selected>{$classname}</option>\n";
								}
								else
								{
												print " <option value=\"{$classid}\" >{$classname}</option>\n";
								}
								$rs->movenext( );
				}
				print "</select>\n";
				if ( $add != "index" )
				{
								print "</TD></TR>\n";
				}
}

function print_select_userclassduan( $var_text = "ʱ���", $initvalue, $add = "" )
{
				global $userclassduan_array;
				global $choose_lang;
				if ( $add != "index" )
				{
								print "<TR>";
								print "<TD class=TableData noWrap>{$var_text}</TD>\n";
								print "<TD class=TableData noWrap>\n";
				}
				print "<select name=\"timeduan\" class=\"BigSelect\" >\n";
				$i = 1;
				for ( ;	$i <= 5;	++$i	)
				{
								if ( isset( $initvalue ) && $i == $initvalue )
								{
												print " <option value=\"{$i}\" selected>".$userclassduan_array[$choose_lang][$i]."</option>\n";
								}
								else
								{
												print " <option value=\"{$i}\" >".$userclassduan_array[$choose_lang][$i]."</option>\n";
								}
				}
				print "</select>\n";
				if ( $add != "index" )
				{
								print "</TD></TR>\n";
				}
}

?>
