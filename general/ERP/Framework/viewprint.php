<?php
$filename=iconv('UTF-8','gb2312',$_GET['filename']);
header("Content-Type:text/html;charset=gb2312");

$msg=$_POST['userdefine'];
$msg=urldecode($msg);
$msg=uhtml($msg);
$msg=iconv('UTF-8','gb2312',$msg);
$msg=str_replace("class=TableBlock", "border=1", $msg);
$msg=str_replace("class=TableHeader", "bgcolor=#DDDDDD", $msg);
$msg=str_replace("class=TableContent", "bgcolor=#EEEEEE", $msg);
$msg=str_replace("class=TableData", "bgcolor=#FFFFFF", $msg);
$msg=str_replace("class=TableControl", "bgcolor=#FFFFFF", $msg);
$msg=str_replace("class=\"TableBlock\"", "border=1", $msg);
$msg=str_replace("class=\"TableHeader\"", "bgcolor=#DDDDDD", $msg);
$msg=str_replace("class=\"TableContent\"", "bgcolor=#EEEEEE", $msg);
$msg=str_replace("class=\"TableData\"", "bgcolor=#FFFFFF", $msg);
$msg=str_replace("noWrap", "", $msg);
$msg=str_replace("></TD>", ">&nbsp;</TD>", $msg);
$msg=str_replace("TABLE>&nbsp;</TD>", "TABLE></TD>", $msg);
$msg=str_replace("width=\"65%\"", "width=\"100%\"", $msg);
$msg=str_replace("width=\"80%\"", "width=\"100%\"", $msg);
$msg=str_replace("width=\"85%\"", "width=\"100%\"", $msg);
function uhtml($str)  
{  
    $farr = array(  
 
         //���� <script>�ȿ�������������ݻ����ı���ʾ���ֵĴ���,�������Ҫ����flash��,�����Լ���<object>�Ĺ���  
        "/<(\/?)(script|i?frame|style|html|body|title|link|meta|INPUT|A|img|DIV|FONT|SPAN|\?|\%)([^>]*?)>/isU", 
        "/(<[^>]*)on[a-zA-Z]+\s*=([^>]*>)/isU",//����javascript��on�¼�  
   );  
   $tarr = array(  
 
        "",//���Ҫֱ���������ȫ�ı�ǩ�������������  
        "",
   );  
  $str = preg_replace( $farr,$tarr,$str);  
   return $str;  
}
print "<style>body{font-size:9pt;}
input{display:none}
xmp{page-break-before: always}
.highlight {BACKGROUND:#d0ecfa;}
</style>";

print $msg;
//echo "PDF file is generated successfully!";
?>
<object id="LODOP" classid="clsid:2105C259-1E0C-4534-8141-A753534CB4CA" width=0 height=0> 
		<embed id="LODOP_EM" type="application/x-print-lodop" width=0 height=0></embed> 
	</object>
	<script language = 'JavaScript'>
	
	  var LODOP; //����Ϊȫ�ֱ��� 
	function print_control(){
         	
				LODOP=getLodop(document.getElementById('LODOP'),document.getElementById('LODOP_EM'));  			
				LODOP.PRINT_INIT("��ӡҳ����Ϣ");
				var strBodyStyle= "<LINK href='<?php echo ROOT_DIR?>theme/$LOGIN_THEME_TEXT/style.css' type=text/css rel=stylesheet><style>.TableControl{display:none;}</style>";
				var strFormHtml="<html><body>"+strBodyStyle+document.getElementById("form").innerHTML+"</body></html>";			
				LODOP.ADD_PRINT_HTM(10,10,700,900,strFormHtml);			
				//LODOP.SET_PRINT_MODE(\"PRINT_PAGE_PERCENT\",\"Auto-Width\");// ��������
				LODOP.PREVIEW();
				
	}
	</script>
	if($_GET['action']=="view_default")
{

	global $db;
	$sql = 'SELECT a.billid,a.zhuti,d.USER_NAME as user_id,e.`��������` as chanceid,a.paytype,a.huikuanjine,
a.fahuojine,a.kaipiaojine,a.plandate,a.zuiwanfahuodate,f.USER_NAME as qianyueren,a.user_flag,a.beizhu,a.fahuostate,
a.gaiyao,g.`name` as storeid,a.createtime,a.ifpay,a.kaipiaostate,a.fapiaoneirong,a.fahuotype,a.yunfeitype,a.oddment,a.integral,
a.sellplanno,b.supplyname as supplyid,a.totalmoney,c.linkmanname as linkman,a.mobile,a.address FROM sellplanmain a LEFT JOIN customer b on a.supplyid=b.ROWID LEFT JOIN linkman c on a.linkman=c.ROWID LEFT JOIN `user` d on a.user_id=d.USER_ID
LEFT JOIN crm_chance e on a.chanceid=e.`���` LEFT JOIN `user` f on a.qianyueren=f.USER_ID LEFT JOIN stock g on a.storeid=g.ROWID WHERE a.billid=
	'.$_GET['billid'];
	$rs=$db->Execute($sql);
	$order_info = $rs->GetArray();
	require_once('./userdefine/paystate.php');
	require_once('./userdefine/kaipiaostate.php');
	require_once('./userdefine/sellonePriv.php');
	require_once('./userdefine/fahuostate.php');
	require_once('./userdefine/sellplanstate.php');


	$order_info[0]['user_flag'] = sellplanstate_value($order_info[0]['user_flag'],'','');
	$order_info[0]['user_flag']= htmlspecialchars_decode($order_info[0]['user_flag']);
	$order_info[0]['user_flag']= preg_replace("/<(.*?)>/","",$order_info[0]['user_flag']);

	$order_info[0]['fahuostate'] = fahuostate_value($order_info[0]['fahuostate'],'','');
	$order_info[0]['fahuostate']= htmlspecialchars_decode($order_info[0]['fahuostate']);
	$order_info[0]['fahuostate']= preg_replace("/<(.*?)>/","",$order_info[0]['fahuostate']);

	$order_info[0]['ifpay'] = paystate_value($order_info[0]['ifpay'],'','');
	$order_info[0]['ifpay']= htmlspecialchars_decode($order_info[0]['ifpay']);
	$order_info[0]['ifpay']= preg_replace("/<(.*?)>/","",$order_info[0]['ifpay']);

	$order_info[0]['kaipiaostate'] = kaipiaostate_value($order_info[0]['kaipiaostate'],'','');
	$order_info[0]['kaipiaostate']= htmlspecialchars_decode($order_info[0]['kaipiaostate']);
	$order_info[0]['kaipiaostate']= preg_replace("/<(.*?)>/","",$order_info[0]['kaipiaostate']);


	@$ini_file = @parse_ini_file( "../Framework/sell_print_config.ini",true);
	$sell_order_field_config = $ini_file['sell_order_print_field'];
	$sell_order_detail_field_config = $ini_file['sell_order_detail_print_field'];
	asort($sell_order_field_config);
	asort($sell_order_detail_field_config);
	//$order_print_paper_width = $ini_file['section']['order_print_paper_width'];

	// ���۵���ӡ�ֶ�����
	$customer_columns=returntablecolumn('sellplanmain');
	@$customer_ini_file = @parse_ini_file('./Model/sellplanmain_newai.ini',true);
	$customer_showlistfieldlist = explode(',', $customer_ini_file['view_default']['showlistfieldlist']);
	// �ų�view_default�в����ڻ�������ʾ���ֶ�
	foreach ($customer_showlistfieldlist as $row){
		if(isset($customer_columns[$row])){
			$printfieldlist[$customer_columns[$row]] = $row;
		}
	}

	
	// ��ȡ���۵���ӡ�ֶ�������
	$sql = "select fieldname,chinese from systemlang where tablename='sellplanmain'";
	$rs=$db->Execute($sql);
	$rs_a = $rs->GetArray();
	foreach ($rs_a as $row){
		if(isset($printfieldlist[$row['fieldname']])){
			$printfieldlist[$row['fieldname']] = $row['chinese'];
		}
	}


	// �ų���ӡ�ֶ��������ڵ�ǰ ���ݼ��в����ڵ��ֶ�
	foreach ($sell_order_field_config as $key=>$val){
		if(!isset($printfieldlist[$key])){
			unset($sell_order_field_config[$key]);
		}
	}

	$w1= 120;
	$w2= 220;
	$l1= 15;
	$l2= $l1+$w1;
	$l3= $l2+$w2;
	$l4= $l3+$w1;
	$h = 35;
	$top = 95;
	$i = 1;
	$style_number = 2;
	$js_code = '';
	//print_r($sell_order_field_config);exit;
	foreach ($sell_order_field_config as $key=>$val){
		if(isset($order_info[0][$key])){
			if($i%2){
				$js_code .= 'LODOP.ADD_PRINT_TEXT('.$top.','.$l1.','.$w1.','.$h.',"'.$printfieldlist[$key].':");';
				$js_code .= 'LODOP.ADD_PRINT_TEXT('.$top.','.$l2.','.$w2.','.$h.',"'.$order_info[0][$key].'");';
			}else{
				$js_code .= 'LODOP.ADD_PRINT_TEXT('.$top.','.$l3.','.$w1.','.$h.',"'.$printfieldlist[$key].':");';
				$js_code .= 'LODOP.ADD_PRINT_TEXT('.$top.','.$l4.','.$w2.','.$h.',"'.$order_info[0][$key].'");';
				$top += $h;
			}
			// ��ʽ
			$js_code .= 'LODOP.SET_PRINT_STYLEA('.($style_number).',"FontSize",10);';
			$js_code .= 'LODOP.SET_PRINT_STYLEA('.($style_number++).',"Bold",1);';

			$js_code .= 'LODOP.SET_PRINT_STYLEA('.($style_number).',"FontSize",10);';
			$js_code .= 'LODOP.SET_PRINT_STYLEA('.($style_number++).',"Bold",1);';

			$i++;

		}
	}



	$sql = 'SELECT * FROM sellplanmain_detail a  WHERE a.mainrowid='.$_GET['billid'];
	$rs=$db->Execute($sql);
	$detail = $rs->GetArray();


	// ���۵���ϸ��ӡ�ֶ�����
	$customer_columns=returntablecolumn('sellplanmain_detail');
	@$customer_ini_file = @parse_ini_file('./Model/sellplanmain_detail_newai.ini',true);
	$customer_showlistfieldlist = explode(',', $customer_ini_file['view_default']['showlistfieldlist']);
	// �ų�view_default�в����ڻ�������ʾ���ֶ�
	$printfieldlist = array();
	foreach ($customer_showlistfieldlist as $row){
		if(isset($customer_columns[$row])){
			$printfieldlist[$customer_columns[$row]] = $row;
		}
	}



	// ��ȡ�������۵���ӡ�ֶ�������
	$sql = "select fieldname,chinese from systemlang where tablename='sellplanmain_detail'";
	$rs=$db->Execute($sql);
	$rs_a = $rs->GetArray();
	foreach ($rs_a as $row){
		if(isset($printfieldlist[$row['fieldname']])){
			$printfieldlist[$row['fieldname']] = $row['chinese'];
		}
	}

	// �ų���ӡ�ֶ��������ڵ�ǰ ���ݼ��в����ڵ��ֶ�
	foreach ($sell_order_detail_field_config as $key=>$val){
		if(!isset($printfieldlist[$key])){
			unset($sell_order_detail_field_config[$key]);
		}
	}

	// ��ӡ��ϸ������
	$top += 40;
	$l_w = 85;
	$left = 15;
	$i = 0;
	foreach ($sell_order_detail_field_config  as $key=>$val){
		$js_code .= 'LODOP.ADD_PRINT_TEXT('.$top.','.($l_w*$i+$left).','.$l_w.','.$h.',"'.$printfieldlist[$key].'");';
		// ��ʽ
		$js_code .= 'LODOP.SET_PRINT_STYLEA('.($style_number).',"FontSize",10);';
		$js_code .= 'LODOP.SET_PRINT_STYLEA('.($style_number++).',"Bold",1);';
		$i++;
	}
	// ��
	$style_number++;
	$top += ($h/2)+5;
	$js_code .= 'LODOP.ADD_PRINT_LINE('.$top.',15,'.$top.',780,0,1);';


	// ��ӡ��ϸ��¼
	$top += 10;
	foreach ($detail as $key=>$val){
		$i = 0;
		foreach ($sell_order_detail_field_config  as $key=>$r){
			$js_code .= 'LODOP.ADD_PRINT_TEXT('.$top.','.($l_w*$i+$left).','.$l_w.','.$h.',"'.$val[$key].'");';
			$i++;
			$style_number++;
		}
		$top += $h;
	}
	//$top -= $h;
	$style_number++;
	$js_code .= 'LODOP.ADD_PRINT_LINE('.$top.',15,'.$top.',780,0,1);';
	$top += 5;
	$style_number++;
	$js_code .= 'LODOP.ADD_PRINT_TEXT('.$top.','.$left.',200,'.$h.',"�ܽ�'.number_format($order_info[0]['totalmoney'],2,'.',',').' Ԫ");';
	
	$top += $h;
	$str = $ini_file['fujia']['con'];
	$str = str_replace("^^","\\r\\n",$str);
	$js_code .= 'LODOP.ADD_PRINT_TEXT('.$top.','.$left.',750,'.($h+300).',"'.$str.'");';	
	$js_code .= 'LODOP.SET_PRINT_STYLEA('.($style_number++).',"FontSize",11);';
	//$js_code .= 'LODOP.SET_PRINT_STYLEA('.($style_number++).',"Bold",1);';

	
	//���ô�ӡֽ�ߴ�
	@$paper_size = @parse_ini_file( ROOT_DIR.'/Interface/Framework/global_config.ini',true);
	$paper_width = $paper_size['paper_size']['width'];
	$paper_height = $paper_size['paper_size']['height'];
	if($paper_height > 0 && $paper_size >0){
		$js_code .= 'LODOP.SET_PRINT_PAGESIZE(0,'.($paper_width*10).','.($paper_height*10).',"A4");'; 
	}
	?>
<script type="text/javascript">
function user_func(){

	LODOP=getLodop(document.getElementById('LODOP'),document.getElementById('LODOP_EM'));  
	LODOP.PRINT_INIT("��ӡ���۵�");
	
	LODOP.ADD_PRINT_TEXT(35,300,120,30,"�� �� �� ��");
	LODOP.SET_PRINT_STYLEA(1,"FontSize",13);
	LODOP.SET_PRINT_STYLEA(1,"Bold",1);

	<?php echo $js_code;?>
	LODOP.SET_PRINT_MODE("PRINT_PAGE_PERCENT","Auto-Width");
	LODOP.PREVIEW();	
}

	
</script>


	<?php


if($_GET['action']=="view_default")
{

	global $db;
	$sql = 'SELECT a.billid,a.zhuti,d.USER_NAME as user_id,e.`��������` as chanceid,a.paytype,a.huikuanjine,
a.fahuojine,a.kaipiaojine,a.plandate,a.zuiwanfahuodate,f.USER_NAME as qianyueren,a.user_flag,a.beizhu,a.fahuostate,
a.gaiyao,g.`name` as storeid,a.createtime,a.ifpay,a.kaipiaostate,a.fapiaoneirong,a.fahuotype,a.yunfeitype,a.oddment,a.integral,
a.sellplanno,b.supplyname as supplyid,a.totalmoney,c.linkmanname as linkman,a.mobile,a.address FROM sellplanmain a LEFT JOIN customer b on a.supplyid=b.ROWID LEFT JOIN linkman c on a.linkman=c.ROWID LEFT JOIN `user` d on a.user_id=d.USER_ID
LEFT JOIN crm_chance e on a.chanceid=e.`���` LEFT JOIN `user` f on a.qianyueren=f.USER_ID LEFT JOIN stock g on a.storeid=g.ROWID WHERE a.billid=
	'.$_GET['billid'];
	$rs=$db->Execute($sql);
	$order_info = $rs->GetArray();
	$user_flag=$order_info[0]['user_flag'];
	require_once('./userdefine/paystate.php');
	require_once('./userdefine/kaipiaostate.php');
	require_once('./userdefine/sellonePriv.php');
	require_once('./userdefine/fahuostate.php');
	require_once('./userdefine/sellplanstate.php');


	$order_info[0]['user_flag'] = sellplanstate_value($order_info[0]['user_flag'],'','');
	$order_info[0]['user_flag']= htmlspecialchars_decode($order_info[0]['user_flag']);
	$order_info[0]['user_flag']= preg_replace("/<(.*?)>/","",$order_info[0]['user_flag']);

	$order_info[0]['fahuostate'] = fahuostate_value($order_info[0]['fahuostate'],'','');
	$order_info[0]['fahuostate']= htmlspecialchars_decode($order_info[0]['fahuostate']);
	$order_info[0]['fahuostate']= preg_replace("/<(.*?)>/","",$order_info[0]['fahuostate']);

	$order_info[0]['ifpay'] = paystate_value($order_info[0]['ifpay'],'','');
	$order_info[0]['ifpay']= htmlspecialchars_decode($order_info[0]['ifpay']);
	$order_info[0]['ifpay']= preg_replace("/<(.*?)>/","",$order_info[0]['ifpay']);

	$order_info[0]['kaipiaostate'] = kaipiaostate_value($order_info[0]['kaipiaostate'],'','');
	$order_info[0]['kaipiaostate']= htmlspecialchars_decode($order_info[0]['kaipiaostate']);
	$order_info[0]['kaipiaostate']= preg_replace("/<(.*?)>/","",$order_info[0]['kaipiaostate']);


	@$ini_file = @parse_ini_file( "../Framework/sellone_print_config.ini",true);
	$sell_order_field_config = $ini_file['sell_order_print_field'];
	$sell_order_detail_field_config = $ini_file['sell_order_detail_print_field'];
	asort($sell_order_field_config);
	asort($sell_order_detail_field_config);
	//$order_print_paper_width = $ini_file['section']['order_print_paper_width'];

	// ���۵���ӡ�ֶ�����
	$customer_columns=returntablecolumn('v_sellone');
	@$customer_ini_file = @parse_ini_file('./Model/sellone_newai.ini',true);
	$customer_showlistfieldlist = explode(',', $customer_ini_file['view_default']['showlistfieldlist']);
	// �ų�view_default�в����ڻ�������ʾ���ֶ�
	foreach ($customer_showlistfieldlist as $row){
		if(isset($customer_columns[$row])){
			$printfieldlist[$customer_columns[$row]] = $row;
		}
	}



	// ��ȡ���۵���ӡ�ֶ�������
	$sql = "select fieldname,chinese from systemlang where tablename='v_sellone'";
	$rs=$db->Execute($sql);
	$rs_a = $rs->GetArray();
	foreach ($rs_a as $row){
		if(isset($printfieldlist[$row['fieldname']])){
			$printfieldlist[$row['fieldname']] = $row['chinese'];
		}
	}



	// �ų���ӡ�ֶ��������ڵ�ǰ ���ݼ��в����ڵ��ֶ�
	foreach ($sell_order_field_config as $key=>$val){
		if(!isset($printfieldlist[$key])){
			unset($sell_order_field_config[$key]);
		}
	}

	$w1= 120;
	$w2= 220;
	$l1= 15;
	$l2= $l1+$w1;
	$l3= $l2+$w2;
	$l4= $l3+$w1;
	$h = 35;
	$top = 95;
	$i = 1;
	$style_number = 2;
	$js_code = '';
	if($user_flag<=0)
	{
		$js_code= "alert('��ʱ���ͳ����ĵ��ݲ������ӡ');return false;";
	}
	//print_r($sell_order_field_config);exit;
	foreach ($sell_order_field_config as $key=>$val){
		if(isset($order_info[0][$key])){
			if($i%2){
				$js_code .= 'LODOP.ADD_PRINT_TEXT('.$top.','.$l1.','.$w1.','.$h.',"'.$printfieldlist[$key].':");';
				$js_code .= 'LODOP.ADD_PRINT_TEXT('.$top.','.$l2.','.$w2.','.$h.',"'.$order_info[0][$key].'");';
			}else{
				$js_code .= 'LODOP.ADD_PRINT_TEXT('.$top.','.$l3.','.$w1.','.$h.',"'.$printfieldlist[$key].':");';
				$js_code .= 'LODOP.ADD_PRINT_TEXT('.$top.','.$l4.','.$w2.','.$h.',"'.$order_info[0][$key].'");';
				$top += $h;
			}
			// ��ʽ
			$js_code .= 'LODOP.SET_PRINT_STYLEA('.($style_number).',"FontSize",10);';
			$js_code .= 'LODOP.SET_PRINT_STYLEA('.($style_number++).',"Bold",1);';

			$js_code .= 'LODOP.SET_PRINT_STYLEA('.($style_number).',"FontSize",10);';
			$js_code .= 'LODOP.SET_PRINT_STYLEA('.($style_number++).',"Bold",1);';

			$i++;

		}
	}



	$sql = 'SELECT * FROM sellplanmain_detail a  WHERE a.mainrowid='.$_GET['billid'];
	$rs=$db->Execute($sql);
	$detail = $rs->GetArray();


	// ���۵���ϸ��ӡ�ֶ�����
	$customer_columns=returntablecolumn('sellplanmain_detail');
	@$customer_ini_file = @parse_ini_file('./Model/sellplanmain_detail_newai.ini',true);
	$customer_showlistfieldlist = explode(',', $customer_ini_file['view_default']['showlistfieldlist']);
	// �ų�view_default�в����ڻ�������ʾ���ֶ�
	$printfieldlist = array();
	foreach ($customer_showlistfieldlist as $row){
		if(isset($customer_columns[$row])){
			$printfieldlist[$customer_columns[$row]] = $row;
		}
	}



	// ��ȡ���۵���ϸ��ӡ�ֶ�������
	$sql = "select fieldname,chinese from systemlang where tablename='sellplanmain_detail'";
	$rs=$db->Execute($sql);
	$rs_a = $rs->GetArray();
	foreach ($rs_a as $row){
		if(isset($printfieldlist[$row['fieldname']])){
			$printfieldlist[$row['fieldname']] = $row['chinese'];
		}
	}

	// �ų���ӡ�ֶ��������ڵ�ǰ ���ݼ��в����ڵ��ֶ�
	foreach ($sell_order_detail_field_config as $key=>$val){
		if(!isset($printfieldlist[$key])){
			unset($sell_order_detail_field_config[$key]);
		}
	}

	// ��ӡ��ϸ������
	$top += 40;
	$l_w = 85;
	$left = 15;
	$i = 0;
	foreach ($sell_order_detail_field_config  as $key=>$val){
		$js_code .= 'LODOP.ADD_PRINT_TEXT('.$top.','.($l_w*$i+$left).','.$l_w.','.$h.',"'.$printfieldlist[$key].'");';
		// ��ʽ
		$js_code .= 'LODOP.SET_PRINT_STYLEA('.($style_number).',"FontSize",10);';
		$js_code .= 'LODOP.SET_PRINT_STYLEA('.($style_number++).',"Bold",1);';
		$i++;
	}
	
	$style_number++;
	$top += ($h/2)+5;
	$js_code .= 'LODOP.ADD_PRINT_LINE('.$top.',15,'.$top.',780,0,1);';


	// ��ӡ��ϸ��¼
	$top += 10;
	foreach ($detail as $key=>$val){
		$i = 0;
		foreach ($sell_order_detail_field_config  as $key=>$r){
			$js_code .= 'LODOP.ADD_PRINT_TEXT('.$top.','.($l_w*$i+$left).','.$l_w.','.$h.',"'.$val[$key].'");';
			$i++;
			$style_number++;
		}
		$top += $h;
	}
	//$top -= $h;
	$style_number++;
	$js_code .= 'LODOP.ADD_PRINT_LINE('.$top.',15,'.$top.',780,0,1);';
	$top += 5;
	$style_number++;
	$js_code .= 'LODOP.ADD_PRINT_TEXT('.$top.','.$left.',200,'.$h.',"�ܽ�'.number_format($order_info[0]['totalmoney'],2,'.',',').' Ԫ");';

	$top += $h;
	$str = $ini_file['fujia']['con'];
	$str = str_replace("^^","\\r\\n",$str);
	$js_code .= 'LODOP.ADD_PRINT_TEXT('.$top.','.$left.',750,'.($h+300).',"'.$str.'");';	
	$js_code .= 'LODOP.SET_PRINT_STYLEA('.($style_number++).',"FontSize",11);';

	
	//���ô�ӡֽ�ߴ�
	@$paper_size = @parse_ini_file( ROOT_DIR.'/Interface/Framework/global_config.ini',true);
	$paper_width = $paper_size['paper_size']['width'];
	$paper_height = $paper_size['paper_size']['height'];
	
	if($paper_height > 0 && $paper_size >0){
		$js_code .= 'LODOP.SET_PRINT_PAGESIZE(0,'.($paper_width*10).','.($paper_height*10).',"A4");'; 
	}
	
	?>
<script type="text/javascript">
function user_func(){

	LODOP=getLodop(document.getElementById('LODOP'),document.getElementById('LODOP_EM'));  
	LODOP.PRINT_INIT("��ӡ���۵�");
	
	LODOP.ADD_PRINT_TEXT(35,300,200,30,"�� �� �� ��  ��");
	LODOP.SET_PRINT_STYLEA(1,"FontSize",13);
	LODOP.SET_PRINT_STYLEA(1,"Bold",1);

	<?php echo $js_code;?>
	LODOP.SET_PRINT_MODE("PRINT_PAGE_PERCENT","Auto-Width");
	LODOP.PREVIEW();	
}

	
</script>


	<?php
}