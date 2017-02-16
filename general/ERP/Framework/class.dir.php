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

class php_dir
{

				var $mask = "";

				function php_dir( )
				{
				}

				function set_mask( $mask = "" )
				{
								$this->mask = $mask;
				}

				function list_files( $dir = "/", $mask = "" )
				{
								$return = array( );
								if ( !$mask )
								{
												$mask = $this->mask;
								}
								if ( !file_exists( $dir ) )
								{
												echo "PHP_Dir: Directory does not exist {$dir} <BR>";
												return $return;
								}
								if ( !( $d = opendir( $dir ) ) )
								{
												exit( "PHP_Dir: Failure opening directory" );
								}
								$counter = 0;
								while ( $file = readdir( $d ) )
								{
												if ( is_file( $dir.$file ) )
												{
																$return['filename'][$counter] = $file;
																$file_array = explode( ".", $file );
																$return[$counter]['filesize'] = filesize( $dir.$file );
																$return[$counter]['filetype'] = $file_array[sizeof( $file_array ) - 1];
																$return[$counter]['filectime'] = filectime( $dir.$file );
																++$counter;
												}
								}
								if ( 1 <= sizeof( $return['filename'] ) )
								{
												sort( $return['filename'] );
								}
								return $return;
				}

				function list_dirs( $dir, $mask = "" )
				{
								$return = array( );
								if ( !$mask )
								{
												$mask = $this->mask;
								}
								if ( !file_exists( $dir ) )
								{
												echo "PHP_Dir: Directory does not exist";
												return $return;
								}
								if ( !( $d = opendir( $dir ) ) )
								{
												exit( "PHP_Dir: Failure opening directory" );
								}
								$counter = 0;
								while ( $file = readdir( $d ) )
								{
												if ( is_dir( $dir.$file ) )
												{
																$return['dirname'][$counter] = $file;
																$return[$counter]['dirsize'] = "-";
																$return[$counter]['dirtype'] = "DIR";
																$return[$counter]['dirctime'] = filectime( $dir );
																++$counter;
												}
								}
								if ( 1 <= sizeof( $return['dirname'] ) )
								{
												sort( $return['dirname'] );
								}
								return $return;
				}

				function matches_mask( $file, $mask )
				{
								$mask = str_replace( ".", "\\.", $mask );
								$mask = str_replace( "*", "(.*)", $mask );
								if ( eregi( "^{$mask}", $file, $blah ) )
								{
												return true;
								}
				}

}

?>
