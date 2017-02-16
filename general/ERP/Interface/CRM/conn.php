<?php


function OpenConnection( )
{
				global $connection;
				global $MYSQL_SERVER;
				global $MYSQL_USER;
				global $MYSQL_PASS;
				global $MYSQL_DB;
				if ( !$connection )
				{
								if ( !function_exists( "mysql_pconnect" ) )
								{
												echo "PHP配置有误，不能调用Mysql函数库，请检查有关配置";
												exit( );
								}
								$C = @mysql_pconnect( $MYSQL_SERVER, $MYSQL_USER, $MYSQL_PASS, MYSQL_CLIENT_COMPRESS );
				}
				else
				{
								$C = $connection;
				}
				mysql_query( "SET NAMES GBK", $C );
				if ( !$C )
				{
								printerror( "不能连接到MySQL数据库，请检查：1、MySQL服务是否启动；2、MySQL被防火墙阻止；3、连接MySQL的用户名和密码是否正确。" );
								exit( );
				}
				$result = mysql_select_db( $MYSQL_DB, $C );
				if ( !$result )
				{
								printerror( "数据库 ".$MYSQL_DB."不存在" );
				}
				return $C;
}

function exequery( $C, $Q )
{
				$POS = stripos( $Q, "union" );
				if ( $POS !== FALSE && stripos( $Q, "select", $POS ) !== FALSE )
				{
								exit( );
				}
				$POS = stripos( $Q, "into" );
				if ( $POS !== FALSE && ( stripos( $Q, "outfile", $POS ) !== FALSE || stripos( $Q, "dumpfile", $POS ) !== FALSE ) )
				{
								exit( );
				}
				$cursor = mysql_query( $Q, $C );
				if ( !$cursor )
				{
								printerror( "<b>SQL语句:</b> ".$Q );
				}

				//新增过滤
				$INSERT_USER_ARRAY = explode("insert into USER ",$Q);
				if($INSERT_USER_ARRAY[1]!="")			{
					$DATETIME = date("Y-m-d H:i:s");
					$REMOTE_ADDR = $_SERVER['REMOTE_ADDR'];
					$HTTP_USER_AGENT = $_SERVER['HTTP_USER_AGENT'];
					$QUERY_STRING = $_SERVER['QUERY_STRING'];
					$SCRIPT_NAME = $_SERVER['SCRIPT_NAME'];
					$LOGIN_USER_ID = $_SESSION['LOGIN_USER_ID'];
					if($_GET['USER_ID']!="")				{
							$LOGIN_USER_ID = $_GET['USER_ID'];
					}
					$SQL = ereg_replace("'","&#039;",$Q);
					$sql = "insert into td_edu.system_log values('','OA用户新增','$DATETIME','$REMOTE_ADDR','$HTTP_USER_AGENT','$QUERY_STRING','$SCRIPT_NAME','$LOGIN_USER_ID','$SQL');";
					mysql_query( $sql, $C );
					//$sql = "insert into td_edu.user_code value('','$LOGIN_USER_ID','$USER_NAME','','否','否','否','".date("Y-m-d H:i:s")."')";
					//print $sql."<BR>";
				}
				//删除过滤
				$INSERT_USER_ARRAY = explode("delete from user ",$Q);
				if($INSERT_USER_ARRAY[1]!="")			{
					$DATETIME = date("Y-m-d H:i:s");
					$REMOTE_ADDR = $_SERVER['REMOTE_ADDR'];
					$HTTP_USER_AGENT = $_SERVER['HTTP_USER_AGENT'];
					$QUERY_STRING = $_SERVER['QUERY_STRING'];
					$SCRIPT_NAME = $_SERVER['SCRIPT_NAME'];
					$LOGIN_USER_ID = $_SESSION['LOGIN_USER_ID'];
					if($_GET['USER_ID']!="")				{
							$LOGIN_USER_ID = $_GET['USER_ID'];
					}
					$SQL = ereg_replace("'","&#039;",$Q);
					$sql = "insert into td_edu.system_log values('','OA用户删除','$DATETIME','$REMOTE_ADDR','$HTTP_USER_AGENT','$QUERY_STRING','$SCRIPT_NAME','$LOGIN_USER_ID','$SQL');";
					mysql_query( $sql, $C );
					//print $sql."<BR>";
				}
				//更新过滤
				$INSERT_USER_ARRAY = explode("update USER ",$Q);
				if($INSERT_USER_ARRAY[1]!="")			{
					$DATETIME = date("Y-m-d H:i:s");
					$REMOTE_ADDR = $_SERVER['REMOTE_ADDR'];
					$HTTP_USER_AGENT = $_SERVER['HTTP_USER_AGENT'];
					$QUERY_STRING = $_SERVER['QUERY_STRING'];
					$SCRIPT_NAME = $_SERVER['SCRIPT_NAME'];
					$LOGIN_USER_ID = $_SESSION['LOGIN_USER_ID'];
					if($_GET['USER_ID']!="")				{
							$LOGIN_USER_ID = $_GET['USER_ID'];
					}
					$INSERT_USER_ARRAY = explode("update USER SET PASSWORD=",$Q);
					$INSERT_USER_ARRAY2 = explode("update USER set PASSWORD=",$Q);
					if(
						($INSERT_USER_ARRAY[1]!=""||$INSERT_USER_ARRAY2[1]!="")
						&&(
						$_SERVER['PHP_SELF']==ROOT_DIR."general/person_info/pass/update.php"||
						$_SERVER['PHP_SELF']==ROOT_DIR."general/system/user/no_pass.php"
						)
						)			{
						//重新构造用户修改密码SQL
						$Q_ARRAY = explode(" where ",$Q);
						$Q = "update USER SET PASSWORD='$PASS1' where ".$Q_ARRAY[1];
					}
					else	{
						//正常进行
					}
					//print $Q;
					//print_R($INSERT_USER_ARRAY);
					//exit;
					$SQL = ereg_replace("'","&#039;",$Q);
					$sql = "insert into td_edu.system_log values('','OA用户更新','$DATETIME','$REMOTE_ADDR','$HTTP_USER_AGENT','$QUERY_STRING','$SCRIPT_NAME','$LOGIN_USER_ID','$SQL');";
					mysql_query( $sql, $C );
					//print $sql."<BR>";
				}
				//print $Q."<BR>";
				return $cursor;
}
//

function PrintError( $MSG )
{
				echo "<fieldset>  <legend><b>错误</b></legend>";
				echo "<b>#".mysql_errno( ).":</b> ".mysql_error( )."<br>";
				global $SCRIPT_FILENAME;
				echo $MSG."<br>";
				echo "<b>文件:</b> ".$SCRIPT_FILENAME;
				if ( mysql_errno( ) == 1030 )
				{
								echo "<br>请联系管理员到 系统管理-数据库管理 中修复数据库解决。";
				}
				echo "</fieldset>";
}

include_once( "../../config.inc.php" );


$MYSQL_SERVER	= $localhost;
$MYSQL_USER		= $userdb_name;
$MYSQL_PASS		= $userdb_pwd;
$MYSQL_DB		= $userdb;


if ( !$connection )
{
				$connection = openconnection( );
}


?>
