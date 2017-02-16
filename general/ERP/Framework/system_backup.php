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

function sqldumptable( $table, $fp = 0 )
{
				$tabledump = "DROP TABLE IF EXISTS {$table};\n";
				$tabledump .= "CREATE TABLE {$table} (\n";
				$firstfield = 1;
				$fields = mysql_query( "SHOW FIELDS FROM {$table}" );
				while ( $field = mysql_fetch_array( $fields ) )
				{
								if ( !$firstfield )
								{
												$tabledump .= ",\n";
								}
								else
								{
												$firstfield = 0;
								}
								$tabledump .= "   {$field['Field']} {$field['Type']}";
								if ( !empty( $field['Default'] ) )
								{
												$tabledump .= " DEFAULT '{$field['Default']}'";
								}
								if ( $field['Null'] != "YES" )
								{
												$tabledump .= " NOT NULL";
								}
								if ( $field['Extra'] != "" )
								{
												$tabledump .= " {$field['Extra']}";
								}
				}
				mysql_free_result( $fields );
				$keys = mysql_query( "SHOW KEYS FROM {$table}" );
				while ( $key = mysql_fetch_array( $keys ) )
				{
								$kname = $key['Key_name'];
								if ( $kname != "PRIMARY" && $key['Non_unique'] == 0 )
								{
												$kname = "UNIQUE|{$kname}";
								}
								if ( !is_array( $index[$kname] ) )
								{
												$index[$kname] = array( );
								}
								$index[$kname][] = $key['Column_name'];
				}
				mysql_free_result( $keys );
				while ( list( $kname, $columns ) = each( $index ) )
				{
								$tabledump .= ",\n";
								$colnames = implode( $columns, "," );
								if ( $kname == "PRIMARY" )
								{
												$tabledump .= "   PRIMARY KEY ({$colnames})";
								}
								else
								{
												if ( substr( $kname, 0, 6 ) == "UNIQUE" )
												{
																$kname = substr( $kname, 7 );
												}
												$tabledump .= "   KEY {$kname} ({$colnames})";
								}
				}
				$tabledump .= "\n);\n\n";
				if ( $fp )
				{
								fwrite( $fp, $tabledump );
				}
				else
				{
								echo $tabledump;
				}
				$rows = mysql_query( "SELECT * FROM {$table}" );
				$numfields = mysql_num_fields( $rows );
				while ( $row = mysql_fetch_array( $rows ) )
				{
								$tabledump = "INSERT INTO {$table} VALUES(";
								$fieldcounter = -1;
								$firstfield = 1;
								while ( ++$fieldcounter < $numfields )
								{
												if ( !$firstfield )
												{
																$tabledump .= ", ";
												}
												else
												{
																$firstfield = 0;
												}
												if ( !isset( $row[$fieldcounter] ) )
												{
																$tabledump .= "NULL";
												}
												else
												{
																$tabledump .= "'".mysql_escape_string( $row[$fieldcounter] )."'";
												}
								}
								$tabledump .= ");\n";
								if ( $fp )
								{
												fwrite( $fp, $tabledump );
								}
								else
								{
												echo $tabledump;
								}
				}
				mysql_free_result( $rows );
}

require_once( "lib.inc.php" );
$GLOBAL_SESSION = returnsession( );
$common_html = returnsystemlang( "common_html" );
$html_etc = returnsystemlang( "SERVERINFOR" );
page_css( "System Information" );
if ( function_exists( "ini_get" ) )
{
				$onoff = ini_get( "register_globals" );
}
else
{
				$onoff = get_cfg_var( "register_globals" );
}
if ( $onoff != 1 )
{
				@extract( $_POST, EXTR_SKIP );
				@extract( $_GET, EXTR_SKIP );
}
$self = $_SERVER['PHP_SELF'];
$servername = isset( $servername ) ? $servername : "localhost";
$dbusername = isset( $dbusername ) ? $dbusername : "root";
$dbpassword = isset( $dbpassword ) ? $dbpassword : "";
$dbname = isset( $dbname ) ? $dbname : "";
echo "<table border=1 cellspacing=0 class=small bordercolor=#000000 cellpadding=3 align=center width=650 style=\"border-collapse:collapse\">\r\n  <tr class=\"TableHeader\">\r\n    <td align=\"center\">备份 MySQL 数据库</td>\r\n  </tr>\r\n  <form action=\"?action=sqlbak\" method=\"POST\">\r\n  ";
if ( @mysql_connect( $hostname, $userdb_name, $userdb_pwd ) )
{
				mysql_select_db( $userdb );
}
$tables = @mysql_list_tables( $userdb );
$table = $_POST['table'];
while ( $table = @mysql_fetch_row( $tables ) )
{
				$cachetables[$table[0]] = $table[0];
}
@mysql_free_result( $tables );
if ( empty( $cachetables ) )
{
				echo "<tr>\n";
				echo "  <td align=\"center\" class=\"TableHeader\"><b>您没有连接数据库 or 当前数据库没有任何数据表</b></td>\n";
				echo "</tr>\n";
}
else
{
				echo "\t<tr>\r\n\t  <td align=\"center\" class=\"TableData\">\r\n<table border=1 cellspacing=0 class=small bordercolor=#000000 cellpadding=3 align=center width=450 style=\"border-collapse:collapse\">\r\n<tr>\r\n\t  <td valign=\"top\">请选择表:</td>\r\n\t  <td>";
				echo "<s";
				echo "elect name=\"table[]\" multiple size=\"15\">\r\n\t";
				if ( is_array( $cachetables ) )
				{
								foreach ( $cachetables as $key => $value )
								{
												echo "<option value=\"{$key}\" selected>{$value}</option>\n";
								}
				}
				echo "\t</select></td>\r\n\t</tr>\r\n\t<tr nowrap>\r\n\t  <td>备份数据所保存的文件夹:</td>\r\n\t  <td><input type=\"text\" readonly class=\"SmallStatic\" name=\"path\" size=\"45\" maxlength=\"50\" value=\"webroot/databackup/\"></td>\r\n\t</tr>\r\n\t<tr nowrap>\r\n\t  <td>备份数据所保存的文件名:</td>\r\n\t  <td><input type=\"text\" class=\"SmallInput\" name=\"path\" size=\"45\" maxlength=\"50\" value=\"";
				echo $_SERVER['SERVER_NAME'];
				echo "_";
				echo $userdb;
				echo "_";
				echo date( "Y-m-d" );
				echo ".sql\"></td>\r\n\t</tr>\r\n\t</table></td>\r\n\t</tr>\r\n\t<tr>\r\n\t  <td align=\"center\" class=\"TableHeader\"><input type=\"submit\" name=\"dobackup\" value=\"开始备份\" class=\"SmallButton\"></td>\r\n\t</tr>\r\n\t";
}
echo "  </form>\n";
echo "</table>\n";
@mysql_close( );
if ( $_POST['connect'] )
{
				if ( @mysql_connect( $servername, $dbusername, $dbpassword ) && @mysql_select_db( $dbname ) )
				{
								echo "数据库连接成功!";
								mysql_close( );
				}
				else
				{
								echo mysql_error( );
				}
}
else if ( $_POST['dobackup'] )
{
				$filepath = "../databackup/";
				if ( !is_dir( $filepath ) )
				{
								mkdir( $filepath );
				}
				print "<BR>";
				table_begin( 650 );
				print_title( "数据库备份提示" );
				print "<tr class=Tabledata><td align=center><font color=red>";
				if ( empty( $_POST[table] ) )
				{
								print "请选择欲备份的数据表";
				}
				else
				{
								if ( !mysql_connect( $hostname, $userdb_name, $userdb_pwd ) )
								{
												exit( "数据库连接失败" );
								}
								if ( !mysql_select_db( $userdb ) )
								{
												exit( "选择数据库失败" );
								}
								$table = array_flip( $_POST['table'] );
								$filehandle = @fopen( $filepath.$_POST['path'], "w" );
								if ( $filehandle )
								{
												$result = mysql_query( "SHOW tables" );
												echo $result ? NULL : "出错: ".mysql_error( );
												while ( $currow = mysql_fetch_array( $result ) )
												{
																if ( isset( $table[$currow[0]] ) )
																{
																				sqldumptable( $currow[0], $filehandle );
																				fwrite( $filehandle, "\n\n\n" );
																}
												}
												fclose( $filehandle );
												echo "数据库已成功备份到 <a href=\"".$filepath.$_POST['path']."\" target=\"_blank\">".$_POST['path']."</a>";
												mysql_close( );
								}
								else
								{
												echo "备份失败,请确认目标文件夹是否具有可写权限.";
								}
				}
				print "</font></td></tr>";
				table_end( );
}
?>
