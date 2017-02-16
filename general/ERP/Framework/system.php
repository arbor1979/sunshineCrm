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

require_once( "include.inc.php" );
if ( $_GET['action'] == "" || $_GET['action'] == "init" )
{
				form_begin( "form1" );
				table_begin( );
				print_title( "VOD网站信息设定（此部分参数用来设定页面具体参数值）" );
				print_tr( "网站地址 ：", "index", $vod_config[index], 25, 1, "BigInput", "" );
				print_tr( "影片图片根地址", "basepic", $vod_config[basepic], 25, 1, "BigInput", "" );
				print_tr( "影片文件根地址 ：", "baseurl", $vod_config[baseurl], 25, 1, "BigInput", "" );
				$showtext6 = "<font color=red>*首页底部信息*</font>";
				$showtext7 = "<font color=red>*首页底部信息*</font>";
				$showtext8 = "<font color=red>*对整个系统是否收费进行设定*</font>";
				print_tr( "版权信息 ：", "copyright", $vod_config[copyright], 15, 1, "BigInput", $showtext6 );
				print_tr( "版权组织 ：", "issue", $vod_config[issue], 15, 1, "BigInput", $showtext7 );
				print_tr( "首页电邮 ：", "email", $vod_config[email], 25, 1, "BigInput", "" );
				print_tr( "欢迎信息 ：", "welcome", $vod_config[welcome], 25, 1, "BigInput", "" );
				print_submit( );
				table_end( );
				form_end( );
}
if ( $_GET['action'] == "updatedata" )
{
				if ( is_file( $goalfile ) )
				{
								unlink( $goalfile );
				}
				$string = "<?php\n\$vod_config[index]=\"{$index}\";\n\$vod_config[basepic]=\"{$basepic}\";\n\$vod_config[baseurl]=\"{$baseurl}\";\n\$vod_config[copyright]=\"{$copyright}\";\n\$vod_config[issue]=\"{$issue}\";\n\$vod_config[email]=\"{$email}\";\n\$vod_config[welcome]=\"{$welcome}\";\n\n\$vod_config[isvip]=\"{$isvip}\";\n\$vod_config[vipmethod]=\"{$vipmethod}\";\n\$vod_config[onevodprice]=\"{$onevodprice}\";\n\$vod_config[pagenum]=\"{$pagenum}\";\n\$vod_config[pagenumlist]=\"{$pagenumlist}\";\n\n\$vod_config[isregister]=\"{$isregister}\";\n\$vod_config[initpoint]=\"{$initpoint}\";\n\n\$vod_config[adminusername]=\"{$adminusername}\";\n\$vod_config[adminpassword]=\"{$adminpassword}\";\n";
				string_towrite_file( $string, $goalfile );
				print_error( "你的配置己经完成" );
				pageindexto( "init" );
}
?>
