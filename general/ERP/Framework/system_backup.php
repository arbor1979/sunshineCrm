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
echo "<table border=1 cellspacing=0 class=small bordercolor=#000000 cellpadding=3 align=center width=650 style=\"border-collapse:collapse\">\r\n  <tr class=\"TableHeader\">\r\n    <td align=\"center\">���� MySQL ���ݿ�</td>\r\n  </tr>\r\n  <form action=\"?action=sqlbak\" method=\"POST\">\r\n  ";
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
				echo "  <td align=\"center\" class=\"TableHeader\"><b>��û���������ݿ� or ��ǰ���ݿ�û���κ����ݱ�</b></td>\n";
				echo "</tr>\n";
}
else
{
				echo "\t<tr>\r\n\t  <td align=\"center\" class=\"TableData\">\r\n<table border=1 cellspacing=0 class=small bordercolor=#000000 cellpadding=3 align=center width=450 style=\"border-collapse:collapse\">\r\n<tr>\r\n\t  <td valign=\"top\">��ѡ���:</td>\r\n\t  <td>";
				echo "<s";
				echo "elect name=\"table[]\" multiple size=\"15\">\r\n\t";
				if ( is_array( $cachetables ) )
				{
								foreach ( $cachetables as $key => $value )
								{
												echo "<option value=\"{$key}\" selected>{$value}</option>\n";
								}
				}
				echo "\t</select></td>\r\n\t</tr>\r\n\t<tr nowrap>\r\n\t  <td>����������������ļ���:</td>\r\n\t  <td><input type=\"text\" readonly class=\"SmallStatic\" name=\"path\" size=\"45\" maxlength=\"50\" value=\"webroot/databackup/\"></td>\r\n\t</tr>\r\n\t<tr nowrap>\r\n\t  <td>����������������ļ���:</td>\r\n\t  <td><input type=\"text\" class=\"SmallInput\" name=\"path\" size=\"45\" maxlength=\"50\" value=\"";
				echo $_SERVER['SERVER_NAME'];
				echo "_";
				echo $userdb;
				echo "_";
				echo date( "Y-m-d" );
				echo ".sql\"></td>\r\n\t</tr>\r\n\t</table></td>\r\n\t</tr>\r\n\t<tr>\r\n\t  <td align=\"center\" class=\"TableHeader\"><input type=\"submit\" name=\"dobackup\" value=\"��ʼ����\" class=\"SmallButton\"></td>\r\n\t</tr>\r\n\t";
}
echo "  </form>\n";
echo "</table>\n";
@mysql_close( );
if ( $_POST['connect'] )
{
				if ( @mysql_connect( $servername, $dbusername, $dbpassword ) && @mysql_select_db( $dbname ) )
				{
								echo "���ݿ����ӳɹ�!";
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
				print_title( "���ݿⱸ����ʾ" );
				print "<tr class=Tabledata><td align=center><font color=red>";
				if ( empty( $_POST[table] ) )
				{
								print "��ѡ�������ݵ����ݱ�";
				}
				else
				{
								if ( !mysql_connect( $hostname, $userdb_name, $userdb_pwd ) )
								{
												exit( "���ݿ�����ʧ��" );
								}
								if ( !mysql_select_db( $userdb ) )
								{
												exit( "ѡ�����ݿ�ʧ��" );
								}
								$table = array_flip( $_POST['table'] );
								$filehandle = @fopen( $filepath.$_POST['path'], "w" );
								if ( $filehandle )
								{
												$result = mysql_query( "SHOW tables" );
												echo $result ? NULL : "����: ".mysql_error( );
												while ( $currow = mysql_fetch_array( $result ) )
												{
																if ( isset( $table[$currow[0]] ) )
																{
																				sqldumptable( $currow[0], $filehandle );
																				fwrite( $filehandle, "\n\n\n" );
																}
												}
												fclose( $filehandle );
												echo "���ݿ��ѳɹ����ݵ� <a href=\"".$filepath.$_POST['path']."\" target=\"_blank\">".$_POST['path']."</a>";
												mysql_close( );
								}
								else
								{
												echo "����ʧ��,��ȷ��Ŀ���ļ����Ƿ���п�дȨ��.";
								}
				}
				print "</font></td></tr>";
				table_end( );
}
?>
