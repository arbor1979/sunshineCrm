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

require_once( "lib.inc.php" );
$GLOBAL_SESSION = returnsession( );
$common_html = returnsystemlang( "common_html" );
page_css( "System Setting" );
validateMenuPriv("ϵͳ��������");
$goalfile = "sell_print_config.ini";
	
//print_r($_POST);exit;
if ( $_GET['action'] == "" || $_GET['action'] == "init" )
{
	@$ini_file = @parse_ini_file( $goalfile,true);

	// ���۵���ӡ�ֶ�����
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

	//print_title("���۵���ӡֽ�ſ��");
	//print_tr( "ֽ�ſ��(mm):", "order_print_paper_width", $ini_file[section][order_print_paper_width], 25, 1, "SmallInput", "" );
	
	print_title("���۵���ӡ�ֶ�����");
	foreach ($printfieldlist as $key=>$val){
		$checked = (isset($sell_order_print_field[$key]))?'checked':'';
		print('<tr>
				<td class="TableData" nowrap="" width="20%">'.$val.'</td>
				<td class="TableData" nowrap="" colspan="1">
					<input type="checkbox" title=""  maxlength="200"  name="sellfiled['.$key.']" value="" '.$checked.'>&nbsp;
					<input type="text" title="˳��"  maxlength="200" size="5" name="sellfiledorder['.$key.']" value="'.$sell_order_print_field[$key].'" '.$checked.'>
				</td>
			</tr>');
	}
	

	print_title("���۵���ϸ��ӡ�ֶ�����");
	foreach ($pro_printfieldlist as $key=>$val){
		$checked = (isset($sell_order_detail_print_field[$key]))?'checked':'';
		print('<tr>
				<td class="TableData" nowrap="" width="20%">'.$val.'</td>
				<td class="TableData" nowrap="" colspan="1">
					<input type="checkbox" title=""   maxlength="200"  name="selldetailfiled['.$key.']" value="" '.$checked.'>&nbsp;
					<input type="text" title="˳��"  maxlength="200" size="5" name="selldetailfiledorder['.$key.']" value="'.$sell_order_detail_print_field[$key].'" '.$checked.'>
				</td>
			</tr>');
	}
	
	print_title("���۵����Ӹ�������");
	$str = $ini_file['fujia']['con'];
	$str = str_replace("^^","\r\n",$str);
		print('<tr>
				<td class="TableData" nowrap="" colspan="3">
					<textarea class="BigInput" name="fujia" title="���۵���ӡ��������" wrap="yes" rows="10" cols="60">'.$str.'</textarea>				
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
	$showtext = "�������!";
	print_infor( $showtext, "trip", "location='smsconfig_interface.php'" );
}
?>
