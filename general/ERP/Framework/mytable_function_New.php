<?php
/*
版权归属:郑州单点科技软件有限公司;
联系方式:0371-69663266;
公司地址:河南郑州经济技术开发区第五大街经北三路通信产业园四楼西南;
公司简介:郑州单点科技软件有限公司位于中国中部城市-郑州,成立于2007年1月,致力于把基于先进信息技术（包括通信技术）的最佳管理与业务实践普及到教育行业客户的管理与业务创新活动中，全面提供具有自主知识产权的教育管理软件、服务与解决方案，是中部最优秀的高校教育管理软件及中小学校管理软件提供商。目前己经有多家高职和中职类院校使用通达中部研发中心开发的软件和服务;

软件名称:单点科技软件开发基础性架构平台,以及在其基础之上扩展的任何性软件作品;
发行协议:数字化校园产品为商业软件,发行许可为LICENSE方式;单点CRM系统即SunshineCRM系统为GPLV3协议许可,GPLV3协议许可内容请到百度搜索;
特殊声明:软件所使用的ADODB库,PHPEXCEL库,SMTARY库归原作者所有,余下代码沿用上述声明;
*/

function newai_dataline( $modulename, $functionname = "dataline_view" )
{
				global $SUNSHINE_USER_NAME_VAR;
				global $SUNSHINE_USER_ID_VAR;
				global $_SESSION;
				global $common_html;
				global $db;
				global $file_ini;
				global $array_index;
				global $SUNSHINE_USER_DEPT_VAR;
				$USER_ID = $_SESSION[$SUNSHINE_USER_NAME_VAR];
				$tablename = $file_ini[$modulename]['tablename'];
				$primarykey = $file_ini[$modulename]['primarykey'];
				$primaryname = $file_ini[$modulename]['primaryname'];
				$date = $file_ini[$modulename]['date'];
				$link = $file_ini[$modulename]['link'];
				$width = $file_ini[$modulename]['width'];
				$reader = $file_ini[$modulename]['reader'];
				$format = $file_ini[$modulename]['format'];
				$hidden_field = $file_ini[$modulename]['hidden_field'];
				$columns = returntablecolumn( $tablename );
				$html_etc = returnsystemlang( $tablename );
				$primarykey_index = $columns[$primarykey];
				$primaryname_index = $columns[$primaryname];
				$date_index = $columns[$date];
				$reader_index = $columns[$reader];
				$list['index']['id'] = $primarykey_index;
				$list['index']['name'] = $primaryname_index;
				$list['index']['date'] = $date_index;
				$list['index']['reader'] = $reader_index;
				$list['index']['format'] = $format_index;
				$hidden_field_array = explode( ",", $hidden_field );
				$i = 0;
				for ( ;	$i < sizeof( $hidden_field_array );	++$i	)
				{
								$element = explode( ":", $hidden_field_array[$i] );
								$index_name = $columns[( boolean )$element[1]];
								switch ( $element[2] )
								{
								case "name" :
												$index_id = $USER_ID;
												$index[++$j - 1] = $index_name."='".$index_id."'";
												break;
								case "dept" :
												$index_id = $_SESSION[$SUNSHINE_USER_DEPT_VAR];
												$index[++$j - 1] = $index_name."='".$index_id."' or ".$index_name."='0'";
								}
				}
				is_array( $index ) ? ( $index_sql = join( " ", $index ) ) : ( $index_sql = "" );
				6 < strlen( $index_sql ) ? ( $index_sql = "where ".$index_sql ) : ( $index_sql = "" );
				switch ( $functionname )
				{
				case "url_dataline_view" :
								$functionname = "url_dataline_view";
								$sql = "select {$primarykey_index},{$primaryname_index},{$date_index},{$reader_index},USER from {$tablename} where USER='' or USER='{$USER_ID}' order by {$date_index}";
								$rs = $db->selectlimit( $sql, 60 );
								break;
				case "dataline_view" :
								$functionname = "dataline_view";
								$reader_index == "" ? "" : ( $reader_index = ",".$reader_index );
								$sql = "select {$primarykey_index},{$primaryname_index},{$date_index}".$reader_index." from {$tablename} {$index_sql} order by {$date_index} desc";
								$rs = $db->selectlimit( $sql, 6 );
								break;
				default :
								$functionname = "dataline_view";
								$sql = "select {$primarykey_index},{$primaryname_index},{$date_index},{$reader_index} from {$tablename} {$index_sql} order by {$date_index} desc";
								$rs = $db->selectlimit( $sql, 6 );
								break;
				}
				$rs_a = $rs->getarray( );
				$list['body'] = $rs_a;
				$list['header']['name'] = $common_html['common_html'][$tablename];
				$list['bottom'] = $common_html['common_html']['more'];
				$list['link'] = $link;
				$list['width'] = $width;
				$list['format'] = $format;
				$list['tablename'] = $tablename;
				$functionname( $list );
}

function dataline_view( $list )
{
				global $SUNSHINE_USER_NAME_VAR;
				global $SUNSHINE_USER_ID_VAR;
				global $_SESSION;
				global $common_html;
				global $db;
				global $file_ini;
				global $array_index;
				$USER_ID = $_SESSION[$SUNSHINE_USER_NAME_VAR];
				global $sessionkey;
				print "\r\n<TABLE class=small cellSpacing=1 cellPadding=3 width=".$list['width']." bgColor=#000000 \r\nborder=0>\r\n<TBODY>\r\n<TR class=TableHeader>\r\n<TD noWrap  onclick=showFilter(this);><IMG src=\"images/box_on_right_up.gif\"> ".$list['header']['name']."&nbsp;</TD>\r\n</TD>\r\n</TR>\r\n<TR  class=TableControl>\r\n<TD noWrap colspan=2>";
				print "<TABLE class=small cellSpacing=0 cellPadding=0 width=100% border=0>";
				if ( sizeof( $list['body'] ) == 0 )
				{
								$text = "norecord".$list['tablename'];
								print $common_html['common_html'][$text];
				}
				foreach ( $list['body'] as $infor )
				{
								$reader = $infor[( boolean )$list['index']['reader']];
								$al_reader = explode( ",", $reader );
								$in_array = in_array( $USER_ID, $al_reader );
								empty( $in_array ) && $list['index']['reader'] != "" ? ( $new = "<img src='images/new.gif' border=0>" ) : ( $new = "" );
								$link_array = explode( ":", $list['link'] );
								$format_array = explode( ":", $list['format'] );
								$i = 0;
								for ( ;	$i < sizeof( $format_array );	++$i	)
								{
												switch ( $format_array[$i] )
												{
												case "date" :
																$row_line = "[".$infor[( boolean )$list['index']['date']]."]";
																break;
												case "calendar" :
																$row_line = "[".$infor[( boolean )$list['index']['date']]."]";
																break;
												case "new" :
																$row_line = $row_line.$new;
																break;
												case "counter" :
																$row_line = $row_line."[".$reader."]";
												}
								}
								$url = $link_array[0]."?action=".$link_array[2]."&".$list['index']['id']."=".$infor[( boolean )$list['index']['id']];
								switch ( $format_array[0] )
								{
								case "calendar" :
												print "<script>\r\n\t\tmy_top=70;\r\n\t\tmy_left=70;\r\n\t\t\r\n\t\tfunction my_note(CAL_ID)\r\n\t\t{\r\n\t\t  my_top+=50;\r\n\t\t  my_left+=50;\r\n\r\n\t\t  window.open(\"calendar_read.php?CAL_ID=\"+CAL_ID+\"&sessionkey={$sessionkey}\",\"note_win\"+CAL_ID,\"height=270,width=270,status=0,toolbar=no,menubar=no,location=no,scrollbars=auto,top=\"+ my_top +\",left=\"+ my_left +\",resizable=Yes\");\r\n\t\t}\r\n\t\t</script>\n";
												$CAL_ID = $infor[( boolean )$list['index']['id']];
												print "<a href=\"javascript:my_note({$CAL_ID});\">".$infor[( boolean )$list['index']['name']]."</a>{$row_line}<BR>";
												break;
								default :
												print "<a href=\"".$url."&sessionkey=".$sessionkey."\" {$format}>".$infor[( boolean )$list['index']['name']]."</a>{$row_line}<BR>";
												break;
								}
				}
				if ( sizeof( $list['body'] ) != 0 )
				{
								$list['bottom'] = "<a href=\"".$link_array[0]."\">".$list['bottom']."</a>";
				}
				else
				{
								$list['bottom'] = $list['bottom'];
				}
				print "\r\n<TR class=TableControl>\r\n<TD align=right colspan=2>".$list[bottom]."..&nbsp;</TD>\r\n</TR>\r\n\r\n</TBODY></TABLE>\r\n</TD></TR>\r\n</TBODY></TABLE>\r\n<BR>";
}

function url_dataline_view( $infor )
{
				global $common_html;
				global $SUNSHINE_USER_NAME_VAR;
				global $SUNSHINE_USER_ID_VAR;
				global $_SESSION;
				$USER_ID = $_SESSION[$SUNSHINE_USER_NAME_VAR];
				print "\r\n<BR><TABLE class=small cellSpacing=1 cellPadding=3 width=".$infor['width']." bgColor=#000000 \r\nborder=0>\r\n<TBODY>\r\n<TR class=TableHeader>\r\n<TD noWrap>".$infor['header']['name']."&nbsp;</TD>\r\n</TR>\r\n<TR class=TableData>\r\n<TD>\n";
				print $common_html['common_html']['personalurl']."<BR>";
				foreach ( $infor['body'] as $list )
				{
								if ( $list['USER'] == $USER_ID )
								{
												print "<a href=\"".$list['URL']."\" target=_blank>".$list['URL_DESC']."</a>　&nbsp;&nbsp;";
								}
				}
				print "<BR><BR>".$common_html['common_html']['publicurl']."<BR>";
				foreach ( $infor['body'] as $list )
				{
								if ( $list['USER'] == "" )
								{
												print "<a href=\"".$list['URL']."\" target=_blank>".$list['URL_DESC']."</a>　&nbsp;&nbsp;";
								}
				}
				print "</table><BR>\n";
}

?>
