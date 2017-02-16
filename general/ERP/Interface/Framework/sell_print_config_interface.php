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
$goalfile = "sell_print_config.ini";
	
//print_r($_POST);exit;
if ( $_GET['action'] == "" || $_GET['action'] == "init" )
{
	@$ini_file = @parse_ini_file( $goalfile,true);

	// 销售单打印字段配置
	$sellplanmain_columns=returntablecolumn('sellplanmain');
	@$sellplanmain_ini_file = @parse_ini_file('../JXC/Model/sellplanmain_newai.ini',true);
	$sellplanmain_showlistfieldlist = explode(',', $sellplanmain_ini_file['view_default']['showlistfieldlist']);
	$printfieldlist = array();
	foreach ($sellplanmain_showlistfieldlist as $row){
		if(isset($sellplanmain_columns[$row])){
			$printfieldlist[$row] =  $sellplanmain_columns[$row];
		}
	}
	$printfieldlist = array_flip($printfieldlist);
	global $db;
	$sql = "select fieldname,chinese from systemlang where tablename='sellplanmain'";
	$rs=$db->Execute($sql);
	$rs_a = $rs->GetArray();
	foreach ($rs_a as $row){
		if(isset($printfieldlist[$row['fieldname']])){
			$printfieldlist[$row['fieldname']] = $row['chinese'];
		}
	}
	
	$product_columns=returntablecolumn('sellplanmain_detail');
	@$sellplanmain_ini_file = @parse_ini_file('../JXC/Model/sellplanmain_detail_newai.ini',true);
	$product_showlistfieldlist = explode(',', $sellplanmain_ini_file['view_default']['showlistfieldlist']);
	$pro_printfieldlist = array();
	foreach ($product_showlistfieldlist as $row){
		if(isset($product_columns[$row])){
			$pro_printfieldlist[$row] =  $product_columns[$row];
		}
	}
	$pro_printfieldlist = array_flip($pro_printfieldlist);
	global $db;
	$sql = "select fieldname,chinese from systemlang where tablename='sellplanmain_detail'";
	$rs=$db->Execute($sql);
	$rs_a = $rs->GetArray();
	foreach ($rs_a as $row){
		if(isset($pro_printfieldlist[$row['fieldname']])){
			$pro_printfieldlist[$row['fieldname']] = $row['chinese'];
		}
	}
	$sell_order_print_field = $ini_file['sell_order_print_field'];
	$sell_order_detail_print_field = $ini_file['sell_order_detail_print_field'];

	
	
	form_begin( "form1", "action=updatedata" );
	table_begin( );

	//print_title("销售单打印纸张宽度");
	//print_tr( "纸张宽度(mm):", "order_print_paper_width", $ini_file[section][order_print_paper_width], 25, 1, "SmallInput", "" );
	
	print_title("销售单打印字段配置");
	foreach ($printfieldlist as $key=>$val){
		$checked = (isset($sell_order_print_field[$key]))?'checked':'';
		print('<tr>
				<td class="TableData" nowrap="" width="20%">'.$val.'</td>
				<td class="TableData" nowrap="" colspan="1">
					<input type="checkbox" title=""  maxlength="200"  name="sellfiled['.$key.']" value="" '.$checked.'>&nbsp;
					<input type="text" title="顺序"  maxlength="200" size="5" name="sellfiledorder['.$key.']" value="'.$sell_order_print_field[$key].'" '.$checked.'>
				</td>
			</tr>');
	}
	

	print_title("销售单明细打印字段配置");
	foreach ($pro_printfieldlist as $key=>$val){
		$checked = (isset($sell_order_detail_print_field[$key]))?'checked':'';
		print('<tr>
				<td class="TableData" nowrap="" width="20%">'.$val.'</td>
				<td class="TableData" nowrap="" colspan="1">
					<input type="checkbox" title=""   maxlength="200"  name="selldetailfiled['.$key.']" value="" '.$checked.'>&nbsp;
					<input type="text" title="顺序"  maxlength="200" size="5" name="selldetailfiledorder['.$key.']" value="'.$sell_order_detail_print_field[$key].'" '.$checked.'>
				</td>
			</tr>');
	}
	
	print_title("销售单附加附加条款");
	$str = $ini_file['fujia']['con'];
	$str = str_replace("^^","\r\n",$str);
		print('<tr>
				<td class="TableData" nowrap="" colspan="3">
					<textarea class="BigInput" name="fujia" title="销售单打印附加内容" wrap="yes" rows="10" cols="60">'.$str.'</textarea>				
				</td>
			</tr>');
	print_submit( $common_html['common_html']['submit'] );
	table_end( );
	form_end( );
}
if ( $_GET['action'] == "updatedata" )
{
	if ( is_file( $goalfile ) )
	{
		//unlink( $goalfile );
	}
	//$goalfile = $goalfile;
	//$string .= "order_print_paper_width={$_POST['order_print_paper_width']}\n";
	

	$string .= "[sell_order_print_field]\n";
	if(!empty($_POST['sellfiled'])){
		foreach ($_POST['sellfiled'] as $key=>$val){
			$value = intval($_POST['sellfiledorder'][$key]);
			$string .= "$key={$value}\n";
		}
	}

	$string .= "[sell_order_detail_print_field]\n";
	if(!empty($_POST['selldetailfiled'])){
		foreach ($_POST['selldetailfiled'] as $key=>$val){
			$value = intval($_POST['selldetailfiledorder'][$key]);
			$string .= "$key={$value}\n";
		}
	}
	
	$string .= "[fujia]\n";
	$str = $_POST['fujia'];
	$str = strip_tags($str,"");
	$str = ereg_replace("\r\n","^^",$str);
	$string .= "con={$str}\n";

	!( $handle = @fopen( $goalfile, "w" ) );
	if ( !fwrite( $handle, $string ) )
	{
		exit();
	}
	fclose( $handle );
	page_css( "Configure" );
	$showtext = "配置完成!";
	print_infor( $showtext, "trip", "location='smsconfig_interface.php'" );
}
?>
