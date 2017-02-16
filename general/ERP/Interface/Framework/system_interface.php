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

require_once( "lib.inc.php" );
$GLOBAL_SESSION = returnsession( );
$common_html = returnsystemlang( "common_html" );
page_css( "System Setting" );
$goalfile = "system_config.ini";
if ( $_GET['action'] == "" || $_GET['action'] == "init" )
{
				@$ini_file = @parse_ini_file( $goalfile );
				form_begin( "form1", "action=updatedata" );
				table_begin( );
				print_title( $common_html['common_html']['systemconfiginformation'] );
				print_tr( "横幅栏显示:", "CompanyName", $ini_file[CompanyName], 50, 1, "SmallInput", "" );
				print_tr( "状态栏显示:", "status_bar", $ini_file[status_bar], 50, 1, "SmallInput", "" );
				print_tr( "IE标题栏:", "IETitle", $ini_file[IETitle], 50, 1, "SmallInput", "" );
				print_tr( "登录界面标题栏:", "LoginTitle", $ini_file[LoginTitle], 50, 1, "SmallInput", "" );
				print_submit( $common_html['common_html']['submit'],2,'all','#');
				table_end( );
				form_end( );
}
if ( $_GET['action'] == "updatedata" )
{
				if ( is_file( $goalfile ) )
				{
								unlink( $goalfile );
				}
				$goalfile = $goalfile;
				$_POST['status_bar']=str_replace("(", "（", $_POST['status_bar']);
				$_POST['status_bar']=str_replace(")", "）", $_POST['status_bar']);
				$_POST['CompanyName']=str_replace("(", "（", $_POST['CompanyName']);
				$_POST['CompanyName']=str_replace(")", "）", $_POST['CompanyName']);
				$_POST['IETitle']=str_replace("(", "（", $_POST['IETitle']);
				$_POST['IETitle']=str_replace(")", "）", $_POST['IETitle']);
				$_POST['LoginTitle']=str_replace("(", "（", $_POST['LoginTitle']);
				$_POST['LoginTitle']=str_replace(")", "）", $_POST['LoginTitle']);
				$string = "[section]\nstatus_bar={$_POST['status_bar']}\n";
				$string .= "CompanyName={$_POST['CompanyName']}\n";
				$string .= "IETitle={$_POST['IETitle']}\n";
				$string .= "LoginTitle={$_POST['LoginTitle']}\n";
				$string .= "provinces={$_POST['provinces']}\n";
				!( $handle = @fopen( $goalfile, "w" ) );
				if ( !fwrite( $handle, $string ) )
				{
								exit( );
				}
				fclose( $handle );
				page_css( "Configure" );
				$showtext = "配置完成!";
				print_infor( $showtext, "trip", "?","system_interface.php",1);
}
?>
