<?php
ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL);
ini_set('allow_call_time_pass_reference',0);
error_reporting(E_WARNING | E_ERROR);

	
	
//ͨ��OA2009���ļ�,2010-3-6���ڽ������ ,ͬʱ����find_id�������ڼ�����������
session_start();
global $ATTACH_PATH2;
if($_SESSION['SYSTEM_IS_TD_OA']!='1')			{
	$ATTACH_PATH2	=	DOCUMENT_ROOT."attach/";
	
	//��������Ŀ¼
	if(!@is_dir($ATTACH_PATH2))					@mkdir($ATTACH_PATH2);
}

function attach_size( $ATTACHMENT_ID, $ATTACHMENT_NAME, $MODULE = "" )
{
				global $ATTACH_PATH;
				global $ATTACH_PATH2;
			
				$ATTACH_SIZE = 0;
				if ( $MODULE == "" )
				{
								$MODULE = attach_sub_dir( );
				}
				if ( strstr( $ATTACHMENT_ID, "." ) )
				{
								$ATTACHMENT_ID = substr( $ATTACHMENT_ID, 0, strpos( $ATTACHMENT_ID, "." ) );
				}
				if ( strstr( $ATTACHMENT_ID, "_" ) )
				{
								$PATH = $ATTACH_PATH2.$MODULE."/attachment/".str_replace( "_", "/", $ATTACHMENT_ID );
								$FILENAME = $PATH.".".$ATTACHMENT_NAME;
				}
				else
				{
								$PATH = $ATTACH_PATH.$ATTACHMENT_ID;
								$FILENAME = $PATH."/".$ATTACHMENT_NAME;
				}
				//print $FILENAME;
				if ( file_exists( $FILENAME ) )
				{
								$ATTACH_SIZE = @filesize( $FILENAME );
				}
				return $ATTACH_SIZE;
}
function Button_Back( )
{
echo "<br><center><input type=\"button\" class=\"BigButton\" value=\"����\" onclick=\"history.back();\"></center>";
}

function attach_sub_dir( )
{
		$scriptArray=explode("general/",$_SERVER['SCRIPT_NAME']);
		$scriptArray=explode("/",$scriptArray[1]);
		$dir2=$scriptArray[0];
		return $dir2;
				
}

function attach_real_path( $ATTACHMENT_ID, $ATTACHMENT_NAME, $MODULE = "" )
{
				global $ATTACH_PATH;
				global $ATTACH_PATH2;
				if ( $MODULE == "" )
				{
								$MODULE = attach_sub_dir( );
				}
				if ( strstr( $ATTACHMENT_ID, "." ) )
				{
								$ATTACHMENT_ID = substr( $ATTACHMENT_ID, 0, strpos( $ATTACHMENT_ID, "." ) );
				}
				if ( strstr( $ATTACHMENT_ID, "_" ) )
				{
								$PATH = $ATTACH_PATH2.$MODULE."/".str_replace( "_", "/", $ATTACHMENT_ID );
								$FILENAME = $PATH.".".$ATTACHMENT_NAME;
								return $FILENAME;
				}
				$PATH = $ATTACH_PATH.$ATTACHMENT_ID;
				$FILENAME = $PATH."/".$ATTACHMENT_NAME;
				return $FILENAME;
}

function attach_id_encode( $ATTACHMENT_ID, $ATTACHMENT_NAME )
{
				if ( strstr( $ATTACHMENT_ID, "_" ) )
				{
								$ATTACHMENT_ID = substr( $ATTACHMENT_ID, strpos( $ATTACHMENT_ID, "_" ) + 1 );
				}
				if ( strstr( $ATTACHMENT_ID, "." ) )
				{
								$ATTACHMENT_ID = substr( $ATTACHMENT_ID, 0, strpos( $ATTACHMENT_ID, "." ) );
				}
				return $ATTACHMENT_ID ^ crc32( $ATTACHMENT_NAME );
}

function attach_id_decode( $ATTACHMENT_ID, $ATTACHMENT_NAME )
{
				if ( strstr( $ATTACHMENT_ID, "_" ) )
				{
								$ATTACHMENT_ID = substr( $ATTACHMENT_ID, strpos( $ATTACHMENT_ID, "_" ) + 1 );
				}
				if ( strstr( $ATTACHMENT_ID, "." ) )
				{
								$ATTACHMENT_ID = substr( $ATTACHMENT_ID, 0, strpos( $ATTACHMENT_ID, "." ) );
				}
				return $ATTACHMENT_ID ^ crc32( $ATTACHMENT_NAME );
}

function attach_link( $ATTACHMENT_ID, $ATTACHMENT_NAME, $SHOW_SIZE = 0, $DOWN_PRIV = 1, $DOWN_PRIV_OFFICE = 1, $EDIT_PRIV = 0, $DELETE_PRIV = 0, $NEW_LINE = 1, $SAVE_FILE = 1, $CREATE_IMAGE = 0, $MODULE = "" )
{
				global $FORMAT;
				global $ATTACH_OFFICE_OPEN_IN_IE;
				if ( $ATTACHMENT_ID == "" )
				{
								return "";
				}
				if ( $MODULE == "" )
				{
								$MODULE = attach_sub_dir( );
				}
				$ATTACHMENT_ID_ARRAY = explode( ",", $ATTACHMENT_ID );
				$ATTACHMENT_NAME_ARRAY = explode( "*", $ATTACHMENT_NAME );
				$I = 0;
				for ( ;	$I < count( $ATTACHMENT_ID_ARRAY );	++$I	)
				{
								if ( !( $ATTACHMENT_ID_ARRAY[$I] == "" ) )
								{
												if ( $ATTACHMENT_NAME_ARRAY[$I] == "" )
												{
																break;
												}
								}
								else
								{
												continue;
								}
								$ATTACH_IMAGE = image_mimetype( $ATTACHMENT_NAME_ARRAY[$I] );
								$ATTACHMENT_ID = $ATTACHMENT_ID_ARRAY[$I];
								$YM = substr( $ATTACHMENT_ID, 0, strpos( $ATTACHMENT_ID, "_" ) );
								if ( $YM )
								{
												$ATTACHMENT_ID = substr( $ATTACHMENT_ID, strpos( $ATTACHMENT_ID, "_" ) + 1 );
								}
								$SIGN_KEY = "";
								if ( strstr( $ATTACHMENT_ID, "." ) )
								{
												$SIGN_KEY = substr( $ATTACHMENT_ID, strpos( $ATTACHMENT_ID, "." ) + 1 );
												$ATTACHMENT_ID = substr( $ATTACHMENT_ID, 0, strpos( $ATTACHMENT_ID, "." ) );
								}
								$ATTACHMENT_ID_ENCODED = attach_id_encode( $ATTACHMENT_ID, $ATTACHMENT_NAME_ARRAY[$I] );
								$HEX_ID = dechex( $ATTACHMENT_ID_ENCODED );
								$ATTACH_LINK .= "<span onmouseover=\"showMenu(this.id);\" id=\"attach_".$HEX_ID."\"><img src=\"../../Framework/images/attach/".$ATTACH_IMAGE."\" align=\"absmiddle\"> ";
								if ( $SHOW_SIZE )
								{
												$ATTACH_SIZE = attach_size( $ATTACHMENT_ID_ARRAY[$I], $ATTACHMENT_NAME_ARRAY[$I], $MODULE );
												if ( 0 < floor( $ATTACH_SIZE / 1024 / 1024 ) )
												{
																$ATTACH_SIZE = round( $ATTACH_SIZE / 1024 / 1024, 2 )."MB";
												}
												else if ( 0 < floor( $ATTACH_SIZE / 1024 ) )
												{
																$ATTACH_SIZE = round( $ATTACH_SIZE / 1024, 2 )."KB";
												}
												else
												{
																$ATTACH_SIZE .= "�ֽ�";
												}
								}
								$PRINT_PRIV_OFFICE = substr( $DOWN_PRIV_OFFICE, 1, 1 ) == "1" ? 1 : 0;
								$DOWN_PRIV_OFFICE_I = substr( $DOWN_PRIV_OFFICE, 0, 1 ) == "1" ? 1 : 0;
								$PRINT_PRIV_OFFICE = $PRINT_PRIV_OFFICE || $DOWN_PRIV_OFFICE_I;
								if ( $DOWN_PRIV )
								{
												if ( $DOWN_PRIV_OFFICE_I || !is_office( $ATTACHMENT_NAME_ARRAY[$I] ) && $MODULE == "workflow" && is_ppt_xls( $ATTACHMENT_NAME_ARRAY[$I] ) )
												{
																$ATTACH_LINK .= "<a class=\"attach_name\" href=\"../../Enginee/lib/attach.php?MODULE=".$MODULE."&YM=".$YM."&ATTACHMENT_ID=".$ATTACHMENT_ID_ENCODED."&ATTACHMENT_NAME=".urlencode( $ATTACHMENT_NAME_ARRAY[$I] )."\"".( $ATTACH_OFFICE_OPEN_IN_IE ? " target=\"_blank\"" : "" ).">".htmlspecialchars( $ATTACHMENT_NAME_ARRAY[$I] )."</a></span>&nbsp;\n";
																if ( $SHOW_SIZE )
																{
																				$ATTACH_LINK .= "(".$ATTACH_SIZE.")&nbsp;";
																}
																$ATTACH_LINK .= "<div id=\"attach_".$HEX_ID."_menu\" class=\"attach_div\" title=\"".$ATTACHMENT_NAME_ARRAY[$I]."\">";
																$ATTACH_LINK .= "<a href=\"../../Enginee/lib/attach.php?MODULE=".$MODULE."&YM=".$YM."&ATTACHMENT_ID=".$ATTACHMENT_ID_ENCODED."&ATTACHMENT_NAME=".urlencode( $ATTACHMENT_NAME_ARRAY[$I] )."\"".( $ATTACH_OFFICE_OPEN_IN_IE ? " target=\"_blank\"" : "" ).">����</a>\n";
												}
												else
												{
																$ATTACH_LINK .= htmlspecialchars( $ATTACHMENT_NAME_ARRAY[$I] )."</span>";
																if ( $SHOW_SIZE )
																{
																				$ATTACH_LINK .= "(".$ATTACH_SIZE.")&nbsp;";
																}
																$ATTACH_LINK .= "<div id=\"attach_".$HEX_ID."_menu\" class=\"attach_div\" title=\"".$ATTACHMENT_NAME_ARRAY[$I]."\">";
												}

												if ( $DELETE_PRIV )
												{
																$ATTACH_LINK .= "<a href=\"javascript:delete_attach('".$ATTACHMENT_ID_ARRAY[$I]."','".$ATTACHMENT_NAME_ARRAY[$I]."');\">ɾ��</a>\n";
												}
												if ( $CREATE_IMAGE && is_image( $ATTACHMENT_NAME_ARRAY[$I] ) )
												{
																//$ATTACH_LINK .= "<a id=\"insert_image_link_".$HEX_ID."\" href=\"javascript:InsertImage('".urlencode( "../../Enginee/lib/attach.php?MODULE=".$MODULE."&YM=".$YM."&ATTACHMENT_ID=".$ATTACHMENT_ID_ENCODED."&ATTACHMENT_NAME=".urlencode( $ATTACHMENT_NAME_ARRAY[$I] ) )."');\" title=\"".$ATTACHMENT_NAME_ARRAY[$I]."\">��������</a>\n";
												}
												$EXT_NAME = strtolower( substr( strrchr( $ATTACHMENT_NAME_ARRAY[$I], "." ), 1 ) );
												if ( $FORMAT && ( $EXT_NAME == "mht" || $EXT_NAME == "htm" || $EXT_NAME == "html" ) && !$DELETE_PRIV )
												{
																$ATTACH_LINK .= "<a href=\"javascript:;\" onClick=\"mhtFrame.location='../../Enginee/lib/attach.php?MODULE=".$MODULE."&YM=".$YM."&ATTACHMENT_ID=".$ATTACHMENT_ID_ENCODED."&ATTACHMENT_NAME=".urlencode( $ATTACHMENT_NAME_ARRAY[$I] )."&DIRECT_VIEW=1';\">�鿴</a>\n";
												}
												$ATTACH_LINK .= "</div>";
								}
								else
								{
												$ATTACH_LINK .= htmlspecialchars( $ATTACHMENT_NAME_ARRAY[$I] )."</span>";
												if ( $SHOW_SIZE )
												{
																$ATTACH_LINK .= "(".$ATTACH_SIZE.")&nbsp;";
												}
								}
								if ( $NEW_LINE )
								{
												$ATTACH_LINK .= "<br>\n";
								}
				}
				return $ATTACH_LINK;
}

function attach_link_pda( $ATTACHMENT_ID, $ATTACHMENT_NAME, $P, $MODULE = "", $SHOW_SIZE = 1, $DOWN_PRIV = 1, $NEW_LINE = 0 )
{
				if ( $ATTACHMENT_ID == "" )
				{
								return "��";
				}
				if ( $MODULE == "" )
				{
								$MODULE = attach_sub_dir( );
				}
				$ATTACHMENT_ID_ARRAY = explode( ",", $ATTACHMENT_ID );
				$ATTACHMENT_NAME_ARRAY = explode( "*", $ATTACHMENT_NAME );
				$I = 0;
				for ( ;	$I < count( $ATTACHMENT_ID_ARRAY );	++$I	)
				{
								if ( !( $ATTACHMENT_ID_ARRAY[$I] == "" ) )
								{
												if ( $ATTACHMENT_NAME_ARRAY[$I] == "" )
												{
																break;
												}
								}
								else
								{
												continue;
								}
								$ATTACHMENT_ID = $ATTACHMENT_ID_ARRAY[$I];
								$YM = substr( $ATTACHMENT_ID, 0, strpos( $ATTACHMENT_ID, "_" ) );
								if ( $YM )
								{
												$ATTACHMENT_ID = substr( $ATTACHMENT_ID, strpos( $ATTACHMENT_ID, "_" ) + 1 );
								}
								$ATTACHMENT_ID_ENCODED = attach_id_encode( $ATTACHMENT_ID, $ATTACHMENT_NAME_ARRAY[$I] );
								if ( $SHOW_SIZE )
								{
												$ATTACH_SIZE = attach_size( $ATTACHMENT_ID_ARRAY[$I], $ATTACHMENT_NAME_ARRAY[$I], $MODULE );
												if ( 0 < floor( $ATTACH_SIZE / 1024 / 1024 ) )
												{
																$ATTACH_SIZE = round( $ATTACH_SIZE / 1024 / 1024, 2 )."MB";
												}
												else if ( 0 < floor( $ATTACH_SIZE / 1024 ) )
												{
																$ATTACH_SIZE = round( $ATTACH_SIZE / 1024, 2 )."KB";
												}
												else
												{
																$ATTACH_SIZE .= "�ֽ�";
												}
								}
								if ( $DOWN_PRIV )
								{
												$ATTACH_LINK .= "<a href=\"/pda/attach.php?P=".$P."&MODULE=".$MODULE."&YM=".$YM."&ATTACHMENT_ID=".$ATTACHMENT_ID_ENCODED."&ATTACHMENT_NAME=".urlencode( $ATTACHMENT_NAME_ARRAY[$I] )."\">".htmlspecialchars( $ATTACHMENT_NAME_ARRAY[$I] )."</a>&nbsp;\n";
								}
								else
								{
												$ATTACH_LINK .= htmlspecialchars( $ATTACHMENT_NAME_ARRAY[$I] );
								}
								if ( $SHOW_SIZE )
								{
												$ATTACH_LINK .= "(".$ATTACH_SIZE.")&nbsp;";
								}
								if ( $NEW_LINE )
								{
												$ATTACH_LINK .= "<br>\n";
								}
				}
				return $ATTACH_LINK;
}

function upload_old( $ATTACHMENT, $ATTACHMENT_NAME )
{
				$FB_STR1 = urldecode( $ATTACHMENT_NAME );
				if ( strstr( $FB_STR1, "/" ) || strstr( $FB_STR1, "\\" ) )
				{
								message( "����", "��ֹ�ϴ����ļ����͡�" );
								button_back( );
								exit( );
				}
				$UPLOAD_MAX_FILESIZE = get_cfg_var( "upload_max_filesize" );
				if ( !file_exists( $ATTACHMENT ) )
				{
								message( "�����ϴ�ʧ��", "ԭ�򣺸����ļ�Ϊ�ջ��ļ���̫�����򸽼����� ".$UPLOAD_MAX_FILESIZE." �ֽڣ����ļ�·�������ڣ�" );
								button_back( );
								exit( );
				}
				if ( $_FILES['ATTACHMENT']['size'] == 0 && $_FILES['ATTACHMENT1']['size'] == 0 )
				{
								message( "����", "�����ϴ����ļ������������ť��ѡ��һ����ȷ���ļ���" );
								button_back( );
								exit( );
				}
				$EXT_NAME = substr( $ATTACHMENT_NAME, -4 );
				if ( stristr( $EXT_NAME, ".php" ) )
				{
								message( "����", "PHP�ļ�����ֹ�ϴ���" );
								button_back( );
								exit( );
				}
				if ( strstr( $ATTACHMENT_NAME, "'" ) )
				{
								message( "�����ϴ�ʧ��", "ԭ�򣺸����ļ������ܺ���'�ţ�" );
								button_back( );
								exit( );
				}
				mt_srand( ( double )microtime( ) * 1000000 );
				$ATTACHMENT_ID = mt_rand( );
				global $ATTACH_PATH;
				$PATH = $ATTACH_PATH.$ATTACHMENT_ID;
				if ( !file_exists( $PATH ) )
				{
								mkdir( $PATH, 448 );
				}
				else
				{
								mt_srand( ( double )microtime( ) * 1000000 );
								$ATTACHMENT_ID = mt_rand( );
								$PATH = $ATTACH_PATH.$ATTACHMENT_ID;
								if ( !file_exists( $PATH ) )
								{
												mkdir( $PATH, 448 );
								}
				}
				$FILENAME = $PATH."/".$ATTACHMENT_NAME;
				@copy( $ATTACHMENT, $FILENAME );
				@unlink( $ATTACHMENT );
				if ( !file_exists( $FILENAME ) )
				{
								message( "�����ϴ�ʧ��", "ԭ�򣺸����ļ�Ϊ�ջ��ļ���̫�����򸽼����� ".$UPLOAD_MAX_FILESIZE." �ֽڣ����ļ�·�������ڣ�" );
								button_back( );
								exit( );
				}
				return $ATTACHMENT_ID;
}

function delete_attach_old( $ATTACHMENT_ID, $ATTACHMENT_NAME )
{
				global $ATTACH_PATH;
				global $connection;
				$ATTACHMENT_ID_ARRAY = explode( ",", $ATTACHMENT_ID );
				$ATTACHMENT_NAME_ARRAY = explode( "*", $ATTACHMENT_NAME );
				$I = 0;
				for ( ;	$I < count( $ATTACHMENT_ID_ARRAY );	++$I	)
				{
								if ( !( $ATTACHMENT_ID_ARRAY[$I] == "" ) )
								{
												$ATTACHMENT_ID = $ATTACHMENT_ID_ARRAY[$I];
												$PATH = $ATTACH_PATH.$ATTACHMENT_ID;
												$FILENAME = $PATH."/".$ATTACHMENT_NAME_ARRAY[$I];
												if ( !file_exists( $FILENAME ) )
												{
																$ATTACHMENT_ID = ( $ATTACHMENT_ID_ARRAY[$I] - 2 ) / 3;
																$PATH = $ATTACH_PATH.$ATTACHMENT_ID;
																$FILENAME = $PATH."/".$ATTACHMENT_NAME_ARRAY[$I];
												}
												if ( file_exists( $FILENAME ) )
												{
																@unlink( $FILENAME );
																@rmdir( $PATH );
												}
												$ATTACHMENT_ID = $ATTACHMENT_ID * 3 + 2;
												$query = "delete from ATTACHMENT_EDIT where ATTACHMENT_ID='".$ATTACHMENT_ID."'";
												exequery( $connection, $query );
								}
				}
}

function upload( $PREFIX = "ATTACHMENT", $MODULE = "" )
{
				global $_FILES;
				global $UPLOAD_LIMIT;
				global $UPLOAD_LIMIT_TYPE;
				
				if ( strstr( $MODULE, "/" ) || strstr( $MODULE, "\\" ) )
				{
								message( "����", "�������зǷ��ַ���" );
								exit( );
				}
				$ATTACHMENTS = array( "ID" => "", "NAME" => "" );
				foreach ( $GLOBALS['_FILES'] as $KEY => $ATTACHMENT )
				{
								if ( !( $ATTACHMENT['error'] == 4 ) )
								{
									if ( $KEY != $PREFIX && substr( $KEY, 0, strlen( $PREFIX ) + 1 ) != $PREFIX."_" )
									{
										break;
									}
								}
								else
								{
									continue;
								}
								$ATTACH_NAME = $ATTACHMENT['name'];
								$ATTACH_SIZE = $ATTACHMENT['size'];
								$ATTACH_FILE = $ATTACHMENT['tmp_name'];
								
								if ( strstr( $ATTACH_NAME, "/" ) || strstr( $ATTACH_NAME, "\\" ) )
								{
									message( "����", "��ֹ�ϴ����ļ�����(".$ATTACH_NAME.")��" );
								}
								else
								{
									$EXT_NAME = strtolower( substr( $ATTACH_NAME, strrpos( $ATTACH_NAME, "." ) + 1 ) );
									if ( $EXT_NAME == "" || $EXT_NAME == $ATTACH_NAME )
									{
										$EXT_NAME = "*";
									}
									if ( !( $UPLOAD_LIMIT == 1 ) && find_id( $UPLOAD_LIMIT_TYPE, $EXT_NAME ) || $UPLOAD_LIMIT == 2 && !find_id( $UPLOAD_LIMIT_TYPE, $EXT_NAME ) )
									{
										message( "����", "��ֹ�ϴ����ļ�����(".$EXT_NAME.")��" );
									}
									else
									{
										$UPLOAD_MAX_FILESIZE = get_cfg_var( "upload_max_filesize" );
										if ( !file_exists( $ATTACH_FILE ) )
										{
											message( $ATTACH_NAME."�ϴ�ʧ��", "ԭ�򣺸����ļ�Ϊ�ջ��ļ���̫�����򸽼����� ".$UPLOAD_MAX_FILESIZE." �ֽڣ����ļ�·�������ڣ�" );
										}
										else if ( $ATTACH_SIZE == 0 )
										{
											message( "����", "�����ϴ����ļ������������ť��ѡ��һ����ȷ���ļ���" );
										}
										else if ( strstr( $ATTACH_NAME, "'" ) )
										{
											message( $ATTACH_NAME."�ϴ�ʧ��", "ԭ�򣺸����ļ������ܺ���'�ţ�" );
										}
										else
										{
											$ATTACH_ID = mt_rand( );
											global $ATTACH_PATH2;
											
											$YM = date( "ym", time( ) );
											if ( $MODULE == "" )
											{
															$MODULE = attach_sub_dir( );
											}
											
												
											$PATH = $ATTACH_PATH2.$MODULE."/attachment/";
											
										
											if ( !file_exists( $PATH ) )
											{
															mkdir( $PATH, 448 );
											}
											$PATH = $PATH.$YM;
											
											if ( !file_exists( $PATH ) )
											{
															mkdir( $PATH, 448 );
											}
											$FILENAME = $PATH."/".$ATTACH_ID.".".$ATTACH_NAME;
											
											if ( file_exists( $FILENAME ) )
											{
															$ATTACH_ID = mt_rand( );
															$FILENAME = $PATH."/".$ATTACH_ID.".".$ATTACH_NAME;
											}
											@copy( $ATTACH_FILE, $FILENAME );
											@unlink( $ATTACH_FILE );
											if ( !file_exists( $FILENAME ) )
											{
															message( $ATTACH_NAME."�ϴ�ʧ��", "ԭ�򣺸����ļ�Ϊ�ջ��ļ���̫�����򸽼����� ".$UPLOAD_MAX_FILESIZE." �ֽڣ����ļ�·�������ڣ�" );
											}
											else
											{
															$ATTACHMENTS['ID'] .= $YM."_".$ATTACH_ID.",";
															$ATTACHMENTS['NAME'] .= $ATTACH_NAME."*";
											}
										}
									}
								}
				}
				return $ATTACHMENTS;
}

function delete_attach( $ATTACHMENT_ID, $ATTACHMENT_NAME, $MODULE = "" )
{
				global $ATTACH_PATH;
				global $ATTACH_PATH2;
				global $connection;
				
				if ( $MODULE == "" )
				{
								$MODULE = attach_sub_dir( );
				}
				
				$ATTACHMENT_ID_ARRAY = explode( ",", $ATTACHMENT_ID );
				$ATTACHMENT_NAME_ARRAY = explode( "*", $ATTACHMENT_NAME );
				
				$I = 0;
				for ( ;	$I < count( $ATTACHMENT_ID_ARRAY );	++$I	)
				{
								if ( !( $ATTACHMENT_ID_ARRAY[$I] == "" ) )
								{
												if ( strstr( $ATTACHMENT_ID_ARRAY[$I], "." ) )
												{
																$ATTACHMENT_ID_ARRAY[$I] = substr( $ATTACHMENT_ID_ARRAY[$I], 0, strpos( $ATTACHMENT_ID_ARRAY[$I], "." ) );
												}
												if ( strstr( $ATTACHMENT_ID_ARRAY[$I], "_" ) )
												{
																$YM = substr( $ATTACHMENT_ID_ARRAY[$I], 0, strpos( $ATTACHMENT_ID_ARRAY[$I], "_" ) );
																$PATH = $ATTACH_PATH2.$MODULE."/attachment/".$YM;
																$ATTACHMENT_ID = substr( $ATTACHMENT_ID_ARRAY[$I], strpos( $ATTACHMENT_ID_ARRAY[$I], "_" ) + 1 );
																$FILENAME = $PATH."/".$ATTACHMENT_ID.".".$ATTACHMENT_NAME_ARRAY[$I];
																
																if ( !file_exists( $FILENAME ) )
																{
																				$ATTACHMENT_ID = attach_id_decode( $ATTACHMENT_ID, $ATTACHMENT_NAME_ARRAY[$I] );
																				$FILENAME = $PATH."/".$ATTACHMENT_ID.".".$ATTACHMENT_NAME_ARRAY[$I];
																}
																
												}
												else
												{
																$ATTACHMENT_ID = $ATTACHMENT_ID_ARRAY[$I];
																$PATH = $ATTACH_PATH.$ATTACHMENT_ID;
																$FILENAME = $PATH."/".$ATTACHMENT_NAME_ARRAY[$I];
																if ( !file_exists( $FILENAME ) )
																{
																				$ATTACHMENT_ID = attach_id_decode( $ATTACHMENT_ID_ARRAY[$I], $ATTACHMENT_NAME_ARRAY[$I] );
																				$PATH = $ATTACH_PATH.$ATTACHMENT_ID;
																				$FILENAME = $PATH."/".$ATTACHMENT_NAME_ARRAY[$I];
																}
												}
												if ( file_exists( $FILENAME ) )
												{
																@unlink( $FILENAME );
																if ( !strstr( $ATTACHMENT_ID_ARRAY[$I], "_" ) )
																{
																				@rmdir( $PATH );
																}
												}
												$ATTACHMENT_ID = attach_id_encode( $ATTACHMENT_ID, $ATTACHMENT_NAME_ARRAY[$I] );
												//$query = "delete from ATTACHMENT_EDIT where ATTACHMENT_ID='".$ATTACHMENT_ID."'";
												//exequery( $connection, $query );
								}
				}
}
function delete_single_attach( $filevalue)
{
	$filevalueArray=explode("&", $filevalue);
	$attachmentidArray=explode("=", $filevalueArray[2]);
	$attachmentid=$attachmentidArray[1];
	$attachmentNameArray=explode("=", $filevalueArray[3]);
	$attachmentName=$attachmentNameArray[1];
	$filepath=DOCUMENT_ROOT.'general/ERP/Framework/attachment/'.$attachmentid.'/'.$attachmentName;
	$dirpath=DOCUMENT_ROOT.'general/ERP/Framework/attachment/'.$attachmentid;
	if ( file_exists( $filepath ) )
	{

		@unlink( $filepath );
													
	}
	if(is_dir($dirpath))
		@rmdir($dirpath);
				
				
}


function copy_attach( $ATTACHMENT_ID, $ATTACHMENT_NAME, $MODULE_SRC = "", $MODULE_DESC = "" )
{
				global $ATTACH_PATH;
				global $ATTACH_PATH2;
				
				if ( stristr( $ATTACHMENT_ID, "/" ) || stristr( $ATTACHMENT_ID, "\\" ) || stristr( $ATTACHMENT_NAME, "/" ) || stristr( $ATTACHMENT_NAME, "\\" ) )
				{
								message( "����", "�������зǷ��ַ���" );
								exit( );
				}
				if ( $MODULE_SRC == "" )
				{
								$MODULE_SRC = attach_sub_dir( );
				}
				if ( $MODULE_DESC == "" )
				{
								$MODULE_DESC = attach_sub_dir( );
				}
				$YM_NEW = date( "ym", time( ) );
				$PATH_NEW = $ATTACH_PATH2.$MODULE_DESC;
				if ( !file_exists( $PATH_NEW ) )
				{
								mkdir( $PATH_NEW, 448 );
				}
				$PATH_NEW = $PATH_NEW."/".$YM_NEW;
				if ( !file_exists( $PATH_NEW ) )
				{
								mkdir( $PATH_NEW, 448 );
				}
				$ATTACHMENT_ID_ARRAY = explode( ",", $ATTACHMENT_ID );
				$ATTACHMENT_NAME_ARRAY = explode( "*", $ATTACHMENT_NAME );
				$I = 0;
				for ( ;	$I < count( $ATTACHMENT_ID_ARRAY );	++$I	)
				{
								if ( !( $ATTACHMENT_ID_ARRAY[$I] == "" ) )
								{
												if ( strstr( $ATTACHMENT_ID_ARRAY[$I], "_" ) )
												{
																$YM = substr( $ATTACHMENT_ID_ARRAY[$I], 0, strpos( $ATTACHMENT_ID_ARRAY[$I], "_" ) );
																$PATH = $ATTACH_PATH2.$MODULE_SRC."/".$YM;
																$ATTACHMENT_ID = substr( $ATTACHMENT_ID_ARRAY[$I], strpos( $ATTACHMENT_ID_ARRAY[$I], "_" ) + 1 );
																if ( strstr( $ATTACHMENT_ID, "." ) )
																{
																				$ATTACHMENT_ID = substr( $ATTACHMENT_ID, 0, strpos( $ATTACHMENT_ID, "." ) );
																}
																$FILENAME = $PATH."/".$ATTACHMENT_ID.".".$ATTACHMENT_NAME_ARRAY[$I];
																if ( !file_exists( $FILENAME ) )
																{
																				$ATTACHMENT_ID = attach_id_decode( $ATTACHMENT_ID, $ATTACHMENT_NAME_ARRAY[$I] );
																				$FILENAME = $PATH."/".$ATTACHMENT_ID.".".$ATTACHMENT_NAME_ARRAY[$I];
																}
																$SIGN_KEY = attach_id_encode( $ATTACHMENT_ID, $ATTACHMENT_NAME_ARRAY[$I] );
												}
												else
												{
																$ATTACHMENT_ID = $ATTACHMENT_ID_ARRAY[$I];
																$PATH = $ATTACH_PATH.$ATTACHMENT_ID;
																$FILENAME = $PATH."/".$ATTACHMENT_NAME_ARRAY[$I];
																if ( !file_exists( $FILENAME ) )
																{
																				$ATTACHMENT_ID = attach_id_decode( $ATTACHMENT_ID_ARRAY[$I], $ATTACHMENT_NAME_ARRAY[$I] );
																				$PATH = $ATTACH_PATH.$ATTACHMENT_ID;
																				$FILENAME = $PATH."/".$ATTACHMENT_NAME_ARRAY[$I];
																}
																$SIGN_KEY = $ATTACHMENT_ID * 3 + 2;
												}
												if ( strstr( $ATTACHMENT_ID_ARRAY[$I], "." ) )
												{
																$SIGN_KEY = substr( $ATTACHMENT_ID_ARRAY[$I], strpos( $ATTACHMENT_ID_ARRAY[$I], "." ) + 1 );
												}
												$ATTACHMENT_ID_NEW = mt_rand( );
												$FILENAME_NEW = $PATH_NEW."/".$ATTACHMENT_ID_NEW.".".$ATTACHMENT_NAME_ARRAY[$I];
												if ( file_exists( $FILENAME_NEW ) )
												{
																$ATTACHMENT_ID_NEW = mt_rand( );
																$FILENAME_NEW = $PATH_NEW."/".$ATTACHMENT_ID_NEW.".".$ATTACHMENT_NAME_ARRAY[$I];
												}
												if ( is_office( $ATTACHMENT_NAME_ARRAY[$I] ) )
												{
																$ATTACHMENT_ID_STR .= $YM_NEW."_".$ATTACHMENT_ID_NEW.".".$SIGN_KEY.",";
												}
												else
												{
																$ATTACHMENT_ID_STR .= $YM_NEW."_".$ATTACHMENT_ID_NEW.",";
												}
												if ( file_exists( $FILENAME ) )
												{
																@copy( $FILENAME, $FILENAME_NEW );
												}
								}
				}
				return substr( $ATTACHMENT_ID_STR, 0, -1 );
}

function copy_attach_netdisk( $ATTACH_DIR, $ATTACH_NAME, $DISK_ID, $MODULE = "" )
{
				global $connection;
				global $ATTACH_PATH;
				global $ATTACH_PATH2;
				if ( stristr( $ATTACH_DIR, ".." ) || stristr( $ATTACH_NAME, "/" ) || stristr( $ATTACH_NAME, "\\" ) || stristr( $MODULE, "/" ) || stristr( $MODULE, "\\" ) )
				{
								message( "����", "�������зǷ��ַ���" );
								exit( );
				}
				if ( $MODULE == "" )
				{
								$MODULE = attach_sub_dir( );
				}
				$YM_NEW = date( "ym", time( ) );
				$PATH_NEW = $ATTACH_PATH2.$MODULE;
				if ( !file_exists( $PATH_NEW ) )
				{
								mkdir( $PATH_NEW, 448 );
				}
				$PATH_NEW = $PATH_NEW."/".$YM_NEW;
				if ( !file_exists( $PATH_NEW ) )
				{
								mkdir( $PATH_NEW, 448 );
				}
				$ATTACH_NAME_ARRAY = explode( "*", $ATTACH_NAME );
				$ATTACH_DIR_ARRAY = explode( "*", $ATTACH_DIR );
				$DISK_ID_ARRAY = explode( "*", $DISK_ID );
				$I = 0;
				for ( ;	$I < count( $ATTACH_NAME_ARRAY );	++$I	)
				{
								if ( !( $ATTACH_NAME_ARRAY[$I] == "" ) )
								{
												if ( $DISK_ID_ARRAY[$I] == "" )
												{
																break;
												}
								}
								else
								{
												continue;
								}
								$query = "SELECT DISK_PATH from NETDISK where DISK_ID='".$DISK_ID_ARRAY[$I]."'";
								$cursor = exequery( $connection, $query );
								if ( $ROW = mysql_fetch_array( $cursor ) )
								{
												$DISK_PATH = $ROW['DISK_PATH'];
												$FILENAME = $DISK_PATH."/".$ATTACH_DIR_ARRAY[$I]."/".$ATTACH_NAME_ARRAY[$I];
												$FILENAME = str_replace( "//", "/", $FILENAME );
												if ( !file_exists( $FILENAME ) )
												{
												}
												else
												{
																$ATTACHMENT_ID_NEW = mt_rand( );
																$FILENAME_NEW = $PATH_NEW."/".$ATTACHMENT_ID_NEW.".".$ATTACH_NAME_ARRAY[$I];
																if ( file_exists( $FILENAME_NEW ) )
																{
																				$ATTACHMENT_ID_NEW = mt_rand( );
																				$FILENAME_NEW = $PATH_NEW."/".$ATTACHMENT_ID_NEW.".".$ATTACH_NAME_ARRAY[$I];
																}
																$FILENAME = str_replace( "//", "/", $FILENAME );
																$SIGN_KEY = dechex( crc32( $FILENAME ) );
																if ( is_office( $ATTACH_NAME_ARRAY[$I] ) )
																{
																				$ATTACHMENT_ID_STR .= $YM_NEW."_".$ATTACHMENT_ID_NEW.".".$SIGN_KEY.",";
																}
																else
																{
																				$ATTACHMENT_ID_STR .= $YM_NEW."_".$ATTACHMENT_ID_NEW.",";
																}
																@copy( $FILENAME, $FILENAME_NEW );
												}
								}
				}
				return $ATTACHMENT_ID_STR;
}

function copy_sel_attach( $ATTACH_NAME, $ATTACH_DIR, $DISK_ID )
{
		
				if ( $ATTACH_NAME == "" )
				{
								return;
				}
				$ATTACH_NAME_ARRAY = explode( "*", $ATTACH_NAME );
				$ATTACH_DIR_ARRAY = explode( "*", $ATTACH_DIR );
				$DISK_ID_ARRAY = explode( "*", $DISK_ID );
				$I = 0;
				for ( ;	$I < count( $ATTACH_NAME_ARRAY );	++$I	)
				{
								if ( !( $ATTACH_NAME_ARRAY[$I] == "" ) )
								{
												if ( $DISK_ID_ARRAY[$I] == "" )
												{
																$ATTACHMENT_ID .= copy_attach( $ATTACH_DIR_ARRAY[$I], $ATTACH_NAME_ARRAY[$I], "file_folder" ).",";
												}
												else
												{
																$ATTACHMENT_ID .= copy_attach_netdisk( $ATTACH_DIR_ARRAY[$I], $ATTACH_NAME_ARRAY[$I], $DISK_ID_ARRAY[$I] );
												}
								}
				}
				return $ATTACHMENT_ID;
}

function office_attach( $NEW_TYPE, $NEW_NAME, $MODULE = "" )
{
				global $ATTACH_PATH2;
				global $ROOT_PATH;
				if ( stristr( $NEW_TYPE, "." ) || stristr( $NEW_TYPE, "/" ) || stristr( $NEW_TYPE, "\\" ) || stristr( $NEW_NAME, "/" ) || stristr( $NEW_NAME, "\\" ) || stristr( $MODULE, "/" ) || stristr( $MODULE, "\\" ) )
				{
								message( "����", "�������зǷ��ַ���" );
								exit( );
				}
				$EXT_NAME = strtolower( substr( $NEW_NAME, -4 ) );
				if ( stristr( $EXT_NAME, ".php" ) )
				{
								message( "����", "PHP�ļ�����ֹ�ϴ���" );
								button_back( );
								exit( );
				}
				if ( $MODULE == "" )
				{
								$MODULE = attach_sub_dir( );
				}
				$YM = date( "ym", time( ) );
				$PATH = $ATTACH_PATH2.$MODULE;
				if ( !file_exists( $PATH ) )
				{
								mkdir( $PATH, 448 );
				}
				$PATH = $PATH."/".$YM;
				if ( !file_exists( $PATH ) )
				{
								mkdir( $PATH, 448 );
				}
				$ATTACHMENT_ID = mt_rand( );
				$FILE_DES = $PATH."/".$ATTACHMENT_ID.".".$NEW_NAME.".".$NEW_TYPE;
				if ( file_exists( $FILE_DES ) )
				{
								$ATTACHMENT_ID = mt_rand( );
								$FILE_DES = $PATH."/".$ATTACHMENT_ID.".".$NEW_NAME.".".$NEW_TYPE;
				}
				$FILE_SRC = $ROOT_PATH."/module/OC/new.".$NEW_TYPE;
				@copy( $FILE_SRC, $FILE_DES );
				return $YM."_".$ATTACHMENT_ID;
}

function create_attach( $NAME, $CONTENT, $MODULE = "" )
{
				global $ATTACH_PATH2;
				global $ROOT_PATH;
				if ( $MODULE == "" )
				{
								$MODULE = attach_sub_dir( );
				}
				$YM = date( "ym", time( ) );
				$PATH = $ATTACH_PATH2.$MODULE;
				if ( !file_exists( $PATH ) )
				{
								mkdir( $PATH, 448 );
				}
				$PATH = $PATH."/".$YM;
				if ( !file_exists( $PATH ) )
				{
								mkdir( $PATH, 448 );
				}
				$ATTACHMENT_ID = mt_rand( );
				$FILE_DES = $PATH."/".$ATTACHMENT_ID.".".$NAME;
				if ( file_exists( $FILE_DES ) )
				{
								$ATTACHMENT_ID = mt_rand( );
								$FILE_DES = $PATH."/".$ATTACHMENT_ID.".".$NAME;
				}
				file_put_contents( $FILE_DES, $CONTENT );
				return $YM."_".$ATTACHMENT_ID;
}

function is_uploadable( $FILE_NAME )
{
				global $UPLOAD_LIMIT;
				global $UPLOAD_LIMIT_TYPE;
				$EXT_NAME = strtolower( substr( $FILE_NAME, strrpos( $FILE_NAME, "." ) + 1 ) );
				if ( $UPLOAD_LIMIT == 0 )
				{
								return TRUE;
				}
				if ( $UPLOAD_LIMIT == 1 )
				{
								return !find_id( $UPLOAD_LIMIT_TYPE, $EXT_NAME );
				}
				if ( $UPLOAD_LIMIT == 2 )
				{
								return find_id( $UPLOAD_LIMIT_TYPE, $EXT_NAME );
				}
				return FALSE;
}

function is_text( $FILE_NAME )
{
				$TEXT_TYPE = "txt,sql,php,jsp,java,asp,ini,cgi,pl,rb,js,css,inc,aspx,php3,php4,php5,phpt,py,c,cpp,h,pas,log,";
				$EXT_NAME = strtolower( substr( $FILE_NAME, strrpos( $FILE_NAME, "." ) + 1 ) );
				return find_id( $TEXT_TYPE, $EXT_NAME );
}

function is_editable( $FILE_NAME )
{
				global $EDIT_LIMIT_TYPE;
				$EXT_NAME = strtolower( substr( $FILE_NAME, strrpos( $FILE_NAME, "." ) + 1 ) );
				return !find_id( $EDIT_LIMIT_TYPE, $EXT_NAME );
}

function is_office( $FILE_NAME )
{
				$EXT_NAME = strtolower( substr( $FILE_NAME, strrpos( $FILE_NAME, "." ) ) );
				return $EXT_NAME == ".ppsx";
}

function is_ppt_xls( $FILE_NAME )
{
				$EXT_NAME = strtolower( substr( $FILE_NAME, strrpos( $FILE_NAME, "." ) ) );
				return $EXT_NAME == ".ppsx";
}

function is_image( $FILE_NAME )
{
				$IMG_TYPE_STR = "gif,jpg,jpeg,png,bmp,iff,jp2,jpx,jb2,jpc,xbm,wbmp,";
				return find_id( $IMG_TYPE_STR, strtolower( substr( $FILE_NAME, strrpos( $FILE_NAME, "." ) + 1 ) ) );
}

function is_thumbable( $FILE_NAME )
{
				return find_id( "jpg,jpeg,png,gif,", strtolower( substr( $FILE_NAME, strrpos( $FILE_NAME, "." ) + 1 ) ) );
}

function is_viewable( $FILE_NAME )
{
				$IMG_TYPE_STR = "gif,jpg,jpeg,png,tif,tiff,bmp,iff,jp2,jpx,jb2,jpc,xbm,wbmp,phtml,htm,html,pdf,";
				return find_id( $IMG_TYPE_STR, strtolower( substr( $FILE_NAME, strrpos( $FILE_NAME, "." ) + 1 ) ) );
}

function is_media( $FILE_NAME )
{
				$MEDIA_REAL_TYPE = "rm,rmvb,ram,ra,mpa,mpv,mps,m2v,m1v,mpe,mov,smi,";
				$MEDIA_MS_TYPE = "wmv,asf,mp3,mpg,mpeg,mp4,avi,wmv,wma,wav,dat,";
				$MEDIA_FLASH_TYPE = "flv,fla,";
				$DIRECT_VIEW_TYPE = "jpg,jpeg,bmp,gif,png,xml,xhtml,html,htm,mid,mht,pdf,swf,";
				$EXT_NAME = strtolower( substr( $FILE_NAME, strrpos( $FILE_NAME, "." ) + 1 ) );
				if ( find_id( $MEDIA_REAL_TYPE, $EXT_NAME ) )
				{
								return 1;
				}
				if ( find_id( $MEDIA_MS_TYPE, $EXT_NAME ) )
				{
								return 2;
				}
				if ( find_id( $MEDIA_FLASH_TYPE, $EXT_NAME ) )
				{
								return 4;
				}
				if ( find_id( $DIRECT_VIEW_TYPE, $EXT_NAME ) )
				{
								return 3;
				}
				return 0;
}

function image_mimetype( $fichier )
{
				$mimetype = array( "7z" => "7z.gif", "aac" => "avi.gif", "ace" => "zip.gif", "ai" => "ai.gif", "ain" => "ain.gif", "amr" => "mov.gif", "arj" => "zip.gif", "asf" => "avi.gif", "asp" => "asp.gif", "aspx" => "asp.gif", "av" => "avi.gif", "avi" => "avi.gif", "bat" => "com.gif", "bin" => "bin.gif", "bmp" => "bmp.gif", "cab" => "cab.gif", "cad" => "cad.gif", "cat" => "cat.gif", "chm" => "chm.gif", "com" => "com.gif", "css" => "css.gif", "csv" => "csv.gif", "cur" => "cdr.gif", "dat" => "dat.gif", "db" => "db.gif", "dll" => "dll.gif", "dmv" => "avi.gif", "doc" => "doc.gif", "docx" => "docx.gif", "dot" => "dot.gif", "dpt" => "dpt.gif", "dps" => "dps.gif", "dwg" => "dwg.gif", "dxf" => "dxf.gif", "emf" => "emf.gif", "eml" => "eml.gif", "eps" => "eps.gif", "esp" => "esp.gif", "et" => "et.gif", "ett" => "ett.gif", "exe" => "exe.gif", "fla" => "fla.gif", "gif" => "gif.gif", "gz" => "zip.gif", "hlp" => "help.gif", "html" => "html.gif", "htm" => "html.gif", "icl" => "icl.gif", "ico" => "ico.gif", "img" => "iso.gif", "inf" => "inf.gif", "ini" => "ini.gif", "iso" => "iso.gif", "jpg" => "jpg.gif", "jpeg" => "jpg.gif", "js" => "js.gif", "key" => "reg.gif", "m3u" => "m3u.gif", "max" => "max.gif", "mdb" => "mdb.gif", "mde" => "mde.gif", "mht" => "mht.gif", "mid" => "mid.gif", "mov" => "mov.gif", "mp3" => "mp3.gif", "mp4" => "avi.gif", "mpg" => "avi.gif", "mpeg" => "avi.gif", "msi" => "msi.gif", "nrg" => "iso.gif", "ocx" => "dll.gif", "ogg" => "avi.gif", "ogm" => "avi.gif", "pdf" => "pdf.gif", "php" => "php.gif", "phtml" => "php.gif", "pl" => "pl.gif", "png" => "png.gif", "pot" => "pot.gif", "ppt" => "ppt.gif", "pptx" => "pptx.gif", "psd" => "psd.gif", "pub" => "pub.gif", "qt" => "mov.gif", "rar" => "rar.gif", "ra" => "ram.gif", "ram" => "ram.gif", "reg" => "reg.gif", "rm" => "ram.gif", "rmvb" => "ram.gif", "rtf" => "rtf.gif", "sel" => "esp.gif", "sql" => "txt.gif", "flv" => "flash.gif", "fla" => "flash.gif", "swf" => "flash.gif", "tar" => "zip.gif", "tgz" => "zip.gif", "tif" => "tif.gif", "tiff" => "tif.gif", "torrent" => "torrent.gif", "txt" => "txt.gif", "url" => "html.gif", "vbs" => "vbs.gif", "vsd" => "vsd.gif", "vss" => "vss.gif", "vst" => "vst.gif", "wav" => "wav.gif", "wm" => "avi.gif", "wma" => "avi.gif", "wmd" => "avi.gif", "wmf" => "wmf.gif", "wmv" => "avi.gif", "wps" => "wps.gif", "wpt" => "wpt.gif", "xls" => "xls.gif", "xlsx" => "xlsx.gif", "xlt" => "xlt.gif", "xml" => "xml.gif", "z" => "zip.gif", "zip" => "zip.gif" );
				$ext_name = strtolower( substr( $fichier, strrpos( $fichier, "." ) + 1 ) );
				if ( $ext_name != "" && array_key_exists( $ext_name, $mimetype ) )
				{
								return $mimetype[$ext_name];
				}
				return "defaut.gif";
}

function file_type( $file_name )
{
				$mimetype = array( "7z" => "7z ѹ���ļ�", "aac" => "Aac ��Ƶ�ļ�", "ace" => "Ace ѹ���ļ�", "ai" => "Adobe Illustrator ͼ���ļ�", "ain" => "��̬���", "amr" => "", "arj" => "ARJ ѹ���ļ�", "asf" => "Windows Media ��Ƶ/��Ƶ�ļ�", "asp" => "ASP �ű��ļ�", "aspx" => "ASPX �ű��ļ�", "av" => "", "avi" => "Windows Media ��Ƶ/��Ƶ�ļ�", "bat" => "�������ļ�", "bin" => "�������ļ�", "bmp" => "BMP ͼ��", "cab" => "Microsoft ѹ���ļ�", "cad" => "CAD �ļ�", "cat" => "��ȫĿ¼", "chm" => "����� HTML �����ļ�", "com" => "�����ļ�������", "css" => "�����ʽ���ĵ�", "cur" => "Windows ����ļ�", "dat" => "DAT �ļ�", "db" => "Data Base �ļ�", "dll" => "��̬���ӿ�", "dmv" => "", "doc" => "Word 97-2003 �ĵ�", "docx" => "Word 2007 �ĵ�", "dot" => "Word�ĵ�ģ��", "dpt" => "", "dps" => "", "dwg" => "AutoCAD ����ͼ�ļ�", "dxf" => "", "emf" => "", "eml" => "�����ʼ��ĵ�", "eps" => "EPS ͼ��", "esp" => "NTKO ����ӡ���ļ�", "et" => "", "ett" => "", "exe" => "Ӧ�ó���", "fla" => "Flash ��Ƶ�ļ�", "flv" => "Flash ��Ƶ�ļ�", "gif" => "GIF ͼ��", "gz" => "GZIP ѹ���ļ�", "hlp" => "�����ļ�", "html" => "HTML ��ҳ�ļ�", "htm" => "HTML ��ҳ�ļ�", "icl" => "ͼ����ļ�", "ico" => "Windows ͼ���ļ�", "img" => "GEM ����ӳ���ļ�", "inf" => "��Ϣ�ļ�", "ini" => "��������", "iso" => "ISO ����ӳ���ļ�", "jpg" => "JPEG ͼ��", "jpeg" => "JPEG ͼ��", "js" => "JScript �ű��ļ�", "key" => "DataCAD ͼ�깤�����ļ�", "log" => "�ı��ļ�", "m3u" => "MPEGURL��MIME�����ļ���", "max" => "3DStudioMAX �ļ�", "mdb" => "Access 97-2003 ���ݿ�", "mde" => "Access MDE �ļ�", "mht" => "��һ��ʽ��ҳ�ļ�", "mid" => "MIDI ����", "mov" => "QuickTime ��Ƶ/��Ƶ�ļ�", "mp3" => "MPEG ��Ƶ�ļ�", "mp4" => "MPEG ��Ƶ/��Ƶ�ļ�", "mpg" => "MPEG ��Ƶ/��Ƶ�ļ�", "mpeg" => "MPEG ��Ƶ/��Ƶ�ļ�", "msi" => "Windows ��װ����", "nrg" => "Nero ����ӳ���ļ�", "ocx" => "ActiveX �ؼ�", "ogg" => "", "ogm" => "", "pdf" => "PDF �ĵ�", "php" => "PHP �ű��ļ�", "phtml" => "PHP �ű��ļ�", "pl" => "Perl ����", "png" => "PNG ͼ��", "pot" => "Powerpoint ģ��", "ppt" => "Powerpoint 97-2003 ��ʾ�ĸ�", "pptx" => "Powerpoint 2007 ��ʾ�ĸ�", "psd" => "Photoshop ͼ��", "pub" => "Microsoft Publisher �ĵ�", "qt" => "", "rar" => "RAR ѹ���ļ�", "ra" => "Real ��Ƶ/��Ƶ�ļ�", "ram" => "Real ��Ƶ/��Ƶ�ļ�", "reg" => "ע����ļ�", "rm" => "Real ��Ƶ/��Ƶ�ļ�", "rmvb" => "Real ��Ƶ/��Ƶ�ļ�", "rtf" => "RichText ��ʽ�ĵ�", "sel" => "����ӡ���ļ�", "sql" => "SQL �ű��ļ�", "swf" => "Flash �����ļ�", "tar" => "TAR ѹ���ļ�", "tgz" => "TGZ ѹ���ļ�", "tif" => "TIFF ͼ��", "tiff" => "TIFF ͼ��", "torrent" => "BitTorrent �ļ�", "txt" => "�ı��ļ�", "url" => "Internet ��ݷ�ʽ", "vbs" => "VB �ű��ļ�", "vsd" => "Visio 97-2003 �ļ�", "vss" => "Visio ģ���ļ�", "vst" => "Targaλͼ", "wav" => "Windows��������", "wm" => "Windows Media ��Ƶ/��Ƶ�ļ�", "wma" => "Windows Media ��Ƶ/��Ƶ�ļ�", "wmd" => "Windows Media ��Ƶ/��Ƶ�ļ�", "wmf" => "Windows Media ��Ƶ/��Ƶ�ļ�", "wmv" => "Windows Media ��Ƶ/��Ƶ�ļ�", "wps" => "��ɽWPS�ĵ�", "wpt" => "��ɽWPSģ��", "xls" => "Excel 97-2003 ������", "xlsx" => "Excel 2007 ������", "xlt" => "Excel ģ��", "xml" => "XML �ĵ�", "z" => "Z ѹ���ļ�", "zip" => "Zip ѹ���ļ�" );
				$ext_name = strtolower( substr( $file_name, strrpos( $file_name, "." ) + 1 ) );
				if ( $mimetype[$ext_name] != "" )
				{
								return $mimetype[$ext_name];
				}
				return "-";
}

function mime_type( $file_name )
{
				$mimetype = array( "cdf" => "application/cdf", "fif" => "application/fractals", "spl" => "application/futuresplash", "hta" => "application/hta", "hqx" => "application/mac-binhex40", "doc" => "application/msword", "p10" => "application/pkcs10", "p7m" => "application/pkcs7-mime", "p7s" => "application/pkcs7-signature", "cer" => "application/pkix-cert", "crl" => "application/pkix-crl", "ps" => "application/postscript", "xls" => "application/vnd.ms-excel", "mpf" => "application/vnd.ms-mediapackage", "sst" => "application/vnd.ms-pki.certstore", "pko" => "application/vnd.ms-pki.pko", "cat" => "application/vnd.ms-pki.seccat", "stl" => "application/vnd.ms-pki.stl", "ppt" => "application/vnd.ms-powerpoint", "wpl" => "application/vnd.ms-wpl", "cdf" => "application/x-cdf", "z" => "application/x-compress", "tgz" => "application/x-compressed", "gz" => "application/x-gzip", "ins" => "application/x-internet-signup", "iii" => "application/x-iphone", "nix" => "application/x-mix-transfer", "asx" => "application/x-mplayer2", "wmd" => "application/x-ms-wmd", "wmz" => "application/x-ms-wmz", "xls" => "application/x-msexcel", "ppt" => "application/x-mspowerpoint", "p12" => "application/x-pkcs12", "p7b" => "application/x-pkcs7-certificates", "p7r" => "application/x-pkcs7-certreqresp", "swf" => "application/x-shockwave-flash", "sit" => "application/x-stuffit", "tar" => "application/x-tar", "man" => "application/x-troff-man", "cer" => "application/x-x509-ca-cert", "zip" => "application/x-zip-compressed", "aiff" => "audio/aiff", "au" => "audio/basic", "mid" => "audio/mid", "midi" => "audio/midi", "m3u" => "audio/mpegurl", "wav" => "audio/wav", "aiff" => "audio/x-aiff", "wax" => "audio/x-ms-wax", "wma" => "audio/x-ms-wma", "bmp" => "image/bmp", "gif" => "image/gif", "jpg" => "image/jpeg", "jpeg" => "image/jpeg", "png" => "image/png", "tif" => "image/tiff", "tiff" => "image/tiff", "mdi" => "image/vnd.ms-modi", "ico" => "image/x-icon", "png" => "image/x-png", "xbm" => "image/x-xbitmap", "xbm" => "image/xbm", "css" => "text/css", "323" => "text/h323", "htm" => "text/html", "html" => "text/html", "uls" => "text/iuls", "txt" => "text/plain", "php" => "text/html", "php3" => "text/plain", "php4" => "text/plain", "inc" => "text/plain", "ini" => "text/plain", "asp" => "text/plain", "aspx" => "text/plain", "jsp" => "text/plain", "java" => "text/plain", "log" => "text/plain", "bat" => "text/plain", "sql" => "text/plain", "js" => "text/plain", "wsc" => "text/scriptlet", "htt" => "text/webviewhtml", "htc" => "text/x-component", "iqy" => "text/x-ms-iqy", "odc" => "text/x-ms-odc", "rqy" => "text/x-ms-rqy", "vcf" => "text/x-vcard", "xml" => "text/xml", "avi" => "video/avi", "mpeg" => "video/mpeg", "mpeg" => "video/mpg", "avi" => "video/msvideo", "mpeg" => "video/x-mpeg", "asx" => "video/x-ms-asf", "wm" => "video/x-ms-wm", "wmv" => "video/x-ms-wmv", "wmx" => "video/x-ms-wmx", "wvx" => "video/x-ms-wvx", "avi" => "video/x-msvideo" );
				$ext_name = strtolower( substr( $file_name, strrpos( $file_name, "." ) + 1 ) );
				if ( $ext_name != "" && array_key_exists( $ext_name, $mimetype ) )
				{
								return $mimetype[$ext_name];
				}
				return "application/octet-stream";
}

function trim_office_attach( $ATTACHMENT_ID, $ATTACHMENT_NAME )
{
				$ATTACH_ARRAY = array( "ATTACHMENT_ID" => "", "ATTACHMENT_NAME" => "" );
				$ATTACHMENT_ID_ARRAY = explode( ",", $ATTACHMENT_ID );
				$ATTACHMENT_NAME_ARRAY = explode( "*", $ATTACHMENT_NAME );
				$I = 0;
				for ( ;	$I < count( $ATTACHMENT_ID_ARRAY );	++$I	)
				{
								if ( !is_office( $ATTACHMENT_NAME_ARRAY[$I] ) )
								{
												$ATTACH_ARRAY['ATTACHMENT_ID'] .= $ATTACHMENT_ID_ARRAY[$I].",";
												$ATTACH_ARRAY['ATTACHMENT_NAME'] .= $ATTACHMENT_NAME_ARRAY[$I]."*";
								}
				}
				return $ATTACH_ARRAY;
}

function doc2txt( $path )
{
				//exec( ROOT_DIR.( "../../Framework/images/attach/maketxt.exe -q -s ".$path ), &$OUT_ARRAY );
				//$count = count( $OUT_ARRAY );
				//$i = 0;
				//for ( ;	$i < $count;	++$i	)
				//{
				//	$OUT .= $OUT_ARRAY[$i]."\n";
				//}
				//return $OUT;
				return '';
}

function dir_size( $dir )
{
				if ( file_exists( $dir ) )
				{
				}
				if ( !is_dir( $dir ) )
				{
								return FALSE;
				}
				$dh = @opendir( $dir );
				$size = 0;
				while ( $file = @readdir( $dh ) )
				{
								if ( !( $file == "." ) )
								{
												if ( $file == ".." )
												{
																break;
												}
								}
								else
								{
												continue;
								}
								$path = $dir."/".$file;
								if ( is_dir( $path ) )
								{
												$size += dir_size( $path );
								}
								else if ( is_file( $path ) )
								{
												$size += filesize( $path );
								}
				}
				@closedir( $dh );
				return $size;
}

function dir_file_nums( $dir )
{
				if ( file_exists( $dir ) )
				{
				}
				if ( !is_dir( $dir ) )
				{
								return FALSE;
				}
				$dh = @opendir( $dir );
				$nums = 0;
				while ( $file = @readdir( $dh ) )
				{
								if ( !( $file == "." ) || !( $file == ".." ) )
								{
												if ( $file == "tdoa_cache" )
												{
																break;
												}
								}
								else
								{
												continue;
								}
								$path = $dir."/".$file;
								if ( is_dir( $path ) )
								{
												$nums += dir_file_nums( $path );
								}
								else if ( is_file( $path ) )
								{
												$nums += 1;
								}
				}
				@closedir( $dh );
				return $nums;
}

function get_file_folder_path( $sort_id )
{
				if ( $sort_id == "0" )
				{
								return "��Ŀ¼";
				}
				global $connection;
				$path = "";
				$query = "select SORT_PARENT,SORT_NAME from FILE_SORT where SORT_ID='".$sort_id."'";
				$cursor = exequery( $connection, $query );
				if ( $ROW = mysql_fetch_array( $cursor ) )
				{
								$SORT_PARENT = $ROW['SORT_PARENT'];
								$SORT_NAME = $ROW['SORT_NAME'];
								if ( $SORT_PARENT != 0 )
								{
												$path = get_file_folder_path( $SORT_PARENT )."/".$SORT_NAME;
												return $path;
								}
								$path = $SORT_NAME.$path;
				}
				return $path;
}

function delete_dir( $DIR, $MYOA_IS_RECYCLE = 1, $ATTACH_PATH2 = "" )
{
				if ( substr( $DIR, -1 ) != "/" )
				{
								$DIR .= "/";
				}
				$DIR_ARRAY = scandir( $DIR );
				if ( $DIR_ARRAY === FALSE )
				{
								return;
				}
				if ( $MYOA_IS_RECYCLE == 1 )
				{
								$THIS_PATH = $ATTACH_PATH2."recycle";
								if ( !file_exists( $THIS_PATH ) )
								{
												mkdir( $THIS_PATH );
								}
								$THIS_PATH = $ATTACH_PATH2."recycle/netdisk";
								if ( !file_exists( $THIS_PATH ) )
								{
												mkdir( $THIS_PATH );
								}
				}
				$I = 0;
				for ( ;	$I < count( $DIR_ARRAY );	++$I	)
				{
								if ( !( $DIR_ARRAY[$I] == "." ) )
								{
												if ( $DIR_ARRAY[$I] == ".." )
												{
																break;
												}
								}
								else
								{
												continue;
								}
								$FILE_PATH = $DIR.$DIR_ARRAY[$I];
								if ( is_dir( $FILE_PATH ) )
								{
												delete_dir( $FILE_PATH );
								}
								else
								{
												if ( $MYOA_IS_RECYCLE == 1 )
												{
																$FILE_NAME = substr( $FILE_PATH, strrpos( $FILE_PATH, "/" ) );
																$RECYCLE_FILE_PATH = $THIS_PATH.$FILE_NAME;
																@copy( $FILE_PATH, $RECYCLE_FILE_PATH );
												}
												@unlink( $FILE_PATH );
								}
				}
				rmdir( $DIR );
}

function CreateThumb( $file, $maxwdt, $maxhgt, $dest, $quality = 1 )
{
				if ( !file_exists( $file ) )
				{
								return FALSE;
				}
				if ( setmemoryforimage( $file ) === FALSE )
				{
								return FALSE;
				}
				list( $owdt, $ohgt, $otype ) = getimagesize( $file );
				if ( $owdt < $maxwdt )
				{
								$maxwdt = $owdt;
				}
				if ( $ohgt < $maxhgt )
				{
								$maxhgt = $ohgt;
				}
				if ( $owdt <= $maxwdt && $ohgt <= $maxhgt )
				{
								@copy( $file, $dest );
								chmod( $dest, 420 );
								return TRUE;
				}
				switch ( $otype )
				{
				case 1 :
								$newimg = imagecreatefromgif( $file );
								break;
				case 2 :
								$newimg = imagecreatefromjpeg( $file );
								break;
				case 3 :
								$newimg = imagecreatefrompng( $file );
								break;
				case 6 :
				case 15 :
								$newimg = @imagecreatefromwbmp( $file );
								break;
								return FALSE;
				}
				if ( !$newimg )
				{
								return FALSE;
				}
				if ( 1500 < $owdt || 1200 < $ohgt )
				{
								list( $owdt, $ohgt ) = resample( $newimg, $owdt, $ohgt, 1024, 768, 0 );
				}
				resample( $newimg, $owdt, $ohgt, $maxwdt, $maxhgt, $quality );
				if ( !$dest )
				{
								return $newimg;
				}
				if ( !is_dir( dirname( $dest ) ) )
				{
								mkdir( dirname( $dest ) );
				}
				switch ( $otype )
				{
				case 1 :
								imagegif( $newimg, $dest );
								break;
				case 2 :
								imagejpeg( $newimg, $dest, 90 );
								break;
				case 3 :
								imagepng( $newimg, $dest );
								break;
				case 6 :
				case 15 :
								@imagewbmp( $newimg, $dest );
				}
				imagedestroy( $newimg );
				chmod( $dest, 420 );
				return TRUE;
}

function Resample( &$img, $owdt, $ohgt, $maxwdt, $maxhgt, $quality = 1 )
{
				if ( !$maxwdt )
				{
								$divwdt = 0;
				}
				else
				{
								$divwdt = max( 1, $owdt / $maxwdt );
				}
				if ( !$maxhgt )
				{
								$divhgt = 0;
				}
				else
				{
								$divhgt = max( 1, $ohgt / $maxhgt );
				}
				if ( $divhgt <= $divwdt )
				{
								$newwdt = $maxwdt;
								$newhgt = round( $ohgt / $divwdt );
				}
				else
				{
								$newhgt = $maxhgt;
								$newwdt = round( $owdt / $divhgt );
				}
				$tn = imagecreatetruecolor( $newwdt, $newhgt );
				if ( $quality )
				{
								imagecopyresampled( $tn, $img, 0, 0, 0, 0, $newwdt, $newhgt, $owdt, $ohgt );
				}
				else
				{
								imagecopyresized( $tn, $img, 0, 0, 0, 0, $newwdt, $newhgt, $owdt, $ohgt );
				}
				imagedestroy( $img );
				$img = $tn;
				return array(
								$newwdt,
								$newhgt
				);
}

function setMemoryForImage( $filename )
{
				if ( !file_exists( $filename ) )
				{
								return FALSE;
				}
				$imageInfo = getimagesize( $filename );
				if ( !is_array( $imageInfo ) )
				{
								return FALSE;
				}
				$MB = 1048576;
				$K64 = 65536;
				$TWEAKFACTOR = 2;
				$memoryNeeded = $imageInfo[0] * $imageInfo[1] * $imageInfo['bits'] / 8;
				if ( isset( $imageInfo['channels'] ) )
				{
								$memoryNeeded *= $imageInfo['channels'];
				}
				$memoryNeeded = round( ( $memoryNeeded + $K64 ) * $TWEAKFACTOR );
				$memoryLimitMB = intval( ini_get( "memory_limit" ) );
				$memoryLimit = $memoryLimitMB * $MB;
				if ( function_exists( "memory_get_usage" ) && $memoryLimit < memory_get_usage( ) + $memoryNeeded )
				{
								$newLimit = $memoryLimitMB + ceil( ( memory_get_usage( ) + $memoryNeeded - $memoryLimit ) / $MB );
								ini_set( "memory_limit", $newLimit."M" );
								return 1;
				}
				return 0;
}

function ReplaceImageSrc( $CONTENT, $ATTACHMENTS = array( ), $MODULE = "" )
{
				$REG_ARRAY = $TO_ARRAY = array( );
				if ( $MODULE == "" )
				{
								$MODULE = attach_sub_dir( );
				}
				$ID_ARRAY = explode( ",", $ATTACHMENTS['ID'] );
				$NAME_ARRAY = explode( "*", $ATTACHMENTS['NAME'] );
				$I = 0;
				for ( ;	$I < count( $ID_ARRAY );	++$I	)
				{
								if ( !( $ID_ARRAY[$I] == "" ) )
								{
												if ( $NAME_ARRAY[$I] == "" )
												{
																break;
												}
								}
								else
								{
												continue;
								}
								$ATTACHMENT_ID = $ID_ARRAY[$I];
								$YM = substr( $ATTACHMENT_ID, 0, strpos( $ATTACHMENT_ID, "_" ) );
								if ( $YM )
								{
												$ATTACHMENT_ID = substr( $ATTACHMENT_ID, strpos( $ATTACHMENT_ID, "_" ) + 1 );
								}
								$ATTACHMENT_ID_ENCODED = attach_id_encode( $ATTACHMENT_ID, $NAME_ARRAY[$I] );
								$REG_ARRAY[] = "/\\ssrc=\\\\\"file:\\/\\/?[^\"']+\\/".preg_quote( $NAME_ARRAY[$I] )."\\\\\"\\s/i";
								$TO_ARRAY[] = " src=\"../../Enginee/lib/attach.php?MODULE=".$MODULE."&amp;YM=".$YM."&amp;ATTACHMENT_ID=".$ATTACHMENT_ID_ENCODED."&amp;ATTACHMENT_NAME=".urlencode( $NAME_ARRAY[$I] )."\" ";
				}
				return preg_replace( $REG_ARRAY, $TO_ARRAY, $CONTENT );
}

function trim_inserted_image( $CONTENT, $ATTACHMENT_ID, $ATTACHMENT_NAME )
{
				$IMAGE_COUNT = 0;
				$ATTACHMENT_ID_ARRAY = explode( ",", $ATTACHMENT_ID );
				$ATTACHMENT_NAME_ARRAY = explode( "*", $ATTACHMENT_NAME );
				$I = 0;
				for ( ;	$I < count( $ATTACHMENT_ID_ARRAY );	++$I	)
				{
								if ( !( $ATTACHMENT_ID_ARRAY[$I] == "" ) )
								{
												if ( "ATTACHMENT_ID=".attach_id_encode( $ATTACHMENT_ID_ARRAY[$I], $ATTACHMENT_NAME_ARRAY[$I] ) )
												{
																break;
												}
								}
								else
								{
												continue;
								}
								if ( is_image( $ATTACHMENT_NAME_ARRAY[$I] ) )
								{
												++$IMAGE_COUNT;
								}
								$ATTACHMENT_ID_NEW .= $ATTACHMENT_ID_ARRAY[$I].",";
								$ATTACHMENT_NAME_NEW .= $ATTACHMENT_NAME_ARRAY[$I]."*";
				}
				return array(
								"IMAGE_COUNT" => $IMAGE_COUNT,
								"ID" => $ATTACHMENT_ID_NEW,
								"NAME" => $ATTACHMENT_NAME_NEW
				);
}

function backup_file( $FILE_SRC )
{
				global $ATTACH_PATH2;
				$FILE_PATH = $ATTACH_PATH2."/bak";
				if ( !file_exists( $FILE_PATH ) )
				{
								mkdir( $FILE_PATH, 448 );
				}
				$FILE_PATH = $FILE_PATH."/".date( "ym" );
				if ( !file_exists( $FILE_PATH ) )
				{
								mkdir( $FILE_PATH, 448 );
				}
				$FILE_NAME = substr( $FILE_SRC, strrpos( $FILE_SRC, "/" ) + 1 );
				$MICROTIME = microtime( TRUE );
				$MICROTIME = substr( $MICROTIME, strpos( $MICROTIME, "." ), 4 );
				$FILE_DES = $FILE_PATH."/".date( "d.His" ).$MICROTIME.".".$FILE_NAME;
				@copy( $FILE_SRC, $FILE_DES );
				return substr( $FILE_DES, strlen( $ATTACH_PATH2."/bak" ) + 1 );
}


if(!function_exists("message"))		{
	function message($message,$message2)		{
		print_infor($message2,$message,"location='?'");
		exit;
	}
}


function find_id( $STRING, $ID )
{
$STRING = ltrim( $STRING, "," );
if ( $ID == "" || $ID == "," )
{
return FALSE;
}
if ( substr( $STRING, -1 ) != "," )
{
$STRING .= ",";
}
if ( 0 < strpos( $STRING, ",".$ID."," ) )
{
return TRUE;
}
if ( strpos( $STRING, $ID."," ) === 0 )
{
return TRUE;
}
if ( !strstr( $ID, "," ) && $STRING == $ID )
{
return TRUE;
}
return FALSE;
}
?><?php
/*
	��Ȩ����:֣�ݵ���Ƽ�������޹�˾;
	��ϵ��ʽ:0371-69663266;
	��˾��ַ:����֣�ݾ��ü��������������־�����·ͨ�Ų�ҵ԰��¥����;
	��˾���:֣�ݵ���Ƽ�������޹�˾λ���й��в�����-֣��,������2007��1��,�����ڰѻ����Ƚ���Ϣ����������ͨ�ż���������ѹ�����ҵ��ʵ���ռ���������ҵ�ͻ��Ĺ�����ҵ���»�У�ȫ���ṩ��������֪ʶ��Ȩ�Ľ�����������������������������в�������ĸ�У���������������СѧУ��������ṩ�̡�Ŀǰ�Ѿ��ж�Ҹ�ְ����ְ��ԺУʹ��ͨ���в��з����Ŀ���������ͷ���;

	�������:����Ƽ�������������Լܹ�ƽ̨,�Լ��������֮����չ���κ��������Ʒ;
	����Э��:���ֻ�У԰��ƷΪ��ҵ���,�������ΪLICENSE��ʽ;����CRMϵͳ��SunshineCRMϵͳΪGPLV3Э�����,GPLV3Э����������뵽�ٶ�����;
	��������:�����ʹ�õ�ADODB��,PHPEXCEL��,SMTARY���ԭ��������,���´���������������;
	*/
?>