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
validateMenuPriv("系统参数设置");
$goalfile = "global_config.ini";
	
//print_r($_POST);exit;
if ( $_GET['action'] == "" || $_GET['action'] == "init" )
{
	@$ini_file = @parse_ini_file( $goalfile,true);
	
	form_begin( "form1", "action=updatedata" );
	table_begin("80%");
	print_title("短信接口设置");
	print_tr( "短信服务器IP:", "SmsServerIP", $ini_file[section][SmsServerIP], 25, 1, "SmallInput", "" );
	print_tr( "发送账号：", "SmsLoginID", $ini_file[section][SmsLoginID], 25, 1, "SmallInput", "" );
	print_tr( "密码:", "SmsLoginPWD", $ini_file[section][SmsLoginPWD], 25, 1, "SmallInput", "","password" );

	print_title("积分设置");
	print_tr( "1个积分对应金额(元):", "integral", $ini_file[section][integral], 25, 1, "SmallInput", "(多少金额可增加1积分)","",'','','Number' );
	print('<tr>
				<td class="TableData" nowrap="" width="20%">生日当天双倍积分：</td>
				<td class="TableData" nowrap="" colspan="1">
					<input name="birthdayDoubleIntegral" type="checkbox" value="1"'.($ini_file[section][birthdayDoubleIntegral]==1?checked:"").'>
				</td>
			</tr>');
	print_tr( "积分使用基数(个):", "minNum", $ini_file[section][minNum], 25, 1, "SmallInput", "(积分使用必须是此数的整数倍)","",'','','Number' );
	print_tr( "1积分可冲抵金额(元):", "changeMoney", $ini_file[section][changeMoney], 25, 1, "SmallInput", "元(此数不能大于1)","",'','','Number' );
	print_title("销售单设置");
	print_boolean( "是否允许在销售单录入时修改产品单价:", "ModifyPrice", $ini_file[section][ModifyPrice]);
	print_tr( "最大去零金额:", "maxOdd", $ini_file[section][maxOdd], 25, 1, "SmallInput", "元","",'','','Number' );
	print_title("打印设置");
	print('<tr>
				<td class="TableData" nowrap="" width="20%">单据打印格式设置：</td>
				<td class="TableData" nowrap="" colspan="1">
				
					<input type="button" value="店面小票" class="SmallButtonB" onclick="location=\'sellone_print_config_interface.php\';">&nbsp;&nbsp;
				</td>
			</tr>');
	
	print_tr( "纸张宽度(mm):", "width", $ini_file[paper_size][width], 25, 1, "SmallInput", "","",'','','Number' );
	print_tr( "纸张高度(mm):", "height", $ini_file[paper_size][height], 25, 1, "SmallInput", "","",'','','Number' );
	
	print_title("客户资料保护设置");
	$select1='';
	$select2='';
	if($ini_file[kehuprotect][limitEditDel]=='0')
		$select2="checked";
	else 
		$select1="checked";
	print('<tr>
				<td class="TableData" nowrap="" colspan="2">
					<label><input type="radio" value="1" name="limitEditDel" '.$select1.'>允许上级编辑删除客户资料</label>&nbsp;
					<label><input type="radio" value="0" name="limitEditDel" '.$select2.'>只有客户所有者才能编辑删除客户资料</label>
				</td>
			</tr>');
	print_submit( $common_html['common_html']['submit'] );
	table_end( );
	form_end( );
}
if ( $_GET['action'] == "updatedata" )
{
	$_POST['minNum']=intval($_POST['minNum']);
	if($_POST['minNum']<=0)
		$_POST['minNum']='';
	$_POST['changeMoney']=doubleval($_POST['changeMoney']);
	if($_POST['changeMoney']>1 || $_POST['changeMoney']<=0)
		$_POST['changeMoney']='';
	if ( is_file( $goalfile ) )
	{
		unlink( $goalfile );
	}
	$goalfile = $goalfile;
	$string = "[section]\nSmsServerIP={$_POST['SmsServerIP']}\n";
	$string .= "SmsLoginID={$_POST['SmsLoginID']}\n";
	$string .= "SmsLoginPWD={$_POST['SmsLoginPWD']}\n";
	$string .= "integral={$_POST['integral']}\n";
	$string .= "birthdayDoubleIntegral={$_POST['birthdayDoubleIntegral']}\n";
	$string .= "minNum={$_POST['minNum']}\n";
	$string .= "changeMoney={$_POST['changeMoney']}\n";
	$string .= "TuiHuoRate={$_POST['TuiHuoRate']}\n";
	$string .= "ModifyPrice={$_POST['ModifyPrice']}\n";
	$string .= "maxOdd={$_POST['maxOdd']}\n";
	$string .= "[paper_size]\n";
	$string .= "width=".intval($_POST['width'])."\n";
	$string .= "height=".intval($_POST['height'])."\n";
	
	$string .= "[kehuprotect]\n";
	$string .= "limitEditDel=".intval($_POST['limitEditDel'])."\n";
	
	!( $handle = @fopen( $goalfile, "w" ) );
	if ( !fwrite( $handle, $string ) )
	{
		exit();
	}
	fclose( $handle );
	page_css( "Configure" );
	$showtext = "配置完成!";
	$_SESSION['SmsServerIP']=$_POST['SmsServerIP'];
	$_SESSION['SmsLoginID']=$_POST['SmsLoginID'];
	$_SESSION['SmsLoginPWD']=$_POST['SmsLoginPWD'];
	$_SESSION['integral']=$_POST['integral'];
	$_SESSION['limitEditDel']=$_POST['limitEditDel'];
	$_SESSION['ModifyPrice']=$_POST['ModifyPrice'];
	//				$_SESSION['EmailAddress']=$_POST['EmailAddress'];
	//				$_SESSION['EmailPassword']=$_POST['EmailPassword'];
	print_infor( $showtext, "trip", "location='smsconfig_interface.php'","smsconfig_interface.php",1 );
}
?>
