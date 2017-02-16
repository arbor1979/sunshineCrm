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
