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
ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL);
error_reporting(E_WARNING | E_ERROR);
require_once('lib.inc.php');
$GLOBAL_SESSION=returnsession();
validateMenuPriv("销售单录入","销售单查询");
if($_GET['action']=="add_default")
{
	$ADDINIT=array("fahuostate"=>-1,"kaipiaostate"=>-1);
	
}
if($_GET['action']=="add_default_data")
{
	$_POST['billtype']=3;
	$billid = returnAutoIncrement("billid","sellplanmain");
	$_POST['zhuti']='店面销售单-'.$billid;
	
}
if($_GET['action']=="add_default_data" || $_GET['action']=="edit_default_data")
{
	if($_POST['fahuostate']=='')
		$_POST['fahuostate']='-1';
	if($_POST['kaipiaostate']=='')
		$_POST['kaipiaostate']='-1';
}
if($_GET['action']=="import_default_data")
{
	$_GET['foreignkey']='billtype';
	$_GET['foreignvalue']='3';
}
if($_GET['action']=="edit_detail")
{
	$user_flag=returntablefield("sellplanmain","billid",$_GET['billid'], "user_flag");
	if($user_flag!=0)
	{
		print "<script language=javascript>alert('错误：单据已不再是临时单，不能编辑');location='sellonemain_newai.php';</script>";
		exit;
	}
	/*
	$sql="select * from sellplanmain_detail where mainrowid=".$_GET['billid']." limit 1";
	$rs=$db->Execute($sql);
	$rs_a=$rs->GetArray();
	if(sizeof($rs_a)>0)
	{
		$db->StartTrans();
		$sql="delete from sellplanmain_detail_tmp where mainrowid=".$_GET['billid'];
		$db->Execute($sql);
		$sql="insert into sellplanmain_detail_tmp (prodid,prodname,prodguige,prodxinghao,proddanwei,price,zhekou,num,beizhu,mainrowid,jine,chukunum,lirun,oldprodid,opertype,orderid,inputtime,sellprice) (select prodid,prodname,prodguige,prodxinghao,proddanwei,price,zhekou,num,beizhu,mainrowid,jine,chukunum,lirun,oldprodid,opertype,orderid,inputtime,sellprice from sellplanmain_detail where mainrowid=".$_GET['billid'].")";
		$db->Execute($sql);
		$sql="select * from sellplanmain_detail_color where id in (select id from sellplanmain_detail where mainrowid=".$_GET['billid'].")";
		$rs=$db->Execute($sql);
		$rs_a=$rs->GetArray();
		foreach ($rs_a as $row)
		{
			$id=$row['id'];
			$sql="select * from sellplanmain_detail where id=$id";
			$rs=$db->Execute($sql);
			$rs_b=$rs->GetArray();
			$sql="select id from sellplanmain_detail_tmp where mainrowid=".$rs_b[0]['mainrowid']." and prodid='".$rs_b[0]['prodid']."' and opertype=".$rs_b[0]['opertype'];
			$rs=$db->Execute($sql);
			$rs_c=$rs->GetArray();
			$sql="insert into sellplanmain_detail_tmp_color (id,num,color) values(".$rs_c[0]['id'].",".$row['num'].",".$row['color'].")";
			$db->Execute($sql);
		}
		$sql="delete from sellplanmain_detail where mainrowid=".$_GET['billid'];
		$db->Execute($sql);
		$db->CompleteTrans();
	}
	*/
	print "<script>location='DataQuery/productFrame.php?tablename=v_sellonedetail&deelname=店面销售单明细&rowid=".$_GET['billid']."'</script>";
	exit;
}

if($_GET['action']=="edit_finish")
{
	$user_flag=returntablefield("sellplanmain","billid",$_GET['billid'], "user_flag");
	if($user_flag!=0)
	{
		print "<script language=javascript>alert('错误：单据已不再是临时单，不能做收款');location='sellonemain_newai.php';</script>";
		exit;
	}	
	$sql="select sum(round(price*zhekou,2)*num) as jine,count(*) as linenum from sellplanmain_detail_tmp where mainrowid=".$_GET['billid'];
	$rs=$db->Execute($sql);
	$rs_a=$rs->GetArray();
	$allmoney=round($rs_a[0]['jine'],2);
	$allcount=$rs_a[0]['linenum'];
	if($allcount==0)
	{
		print "<script language=javascript>alert('错误：请先录入明细');window.history.back(-1);</script>";
		exit;
	}
	$totalmoney=returntablefield("sellplanmain", "billid", $_GET['billid'], "totalmoney");
	if($allmoney!=$totalmoney)
	{
		print "<script language=javascript>alert('错误：单据金额".$totalmoney."与明细合计".$allmoney."不一致，请重新保存明细');window.history.back(-1);</script>";
		exit;
	}
	print "<script>location='sellonemain_zhixing.php?rowid=".$_GET['billid']."'</script>";
	exit;
}
if($_GET['action']=="finish")
{
	$billid=$_GET['billid'];
	$billinfo=returntablefield("sellplanmain", "billid", $billid, "totalmoney,user_flag,zhuti,fahuostate,kaipiaostate,storeid,supplyid,linkman,address,mobile,fapiaoneirong,fapiaotype,fapiaono");
	$user_flag=$billinfo['user_flag'];
	$zhuti=$billinfo['zhuti'];
	$storeid=$billinfo['storeid'];
	$customerid=$billinfo['supplyid'];
	$supplyname=returntablefield('customer','rowid',$customerid,'supplyname');
	$shouhuoren=returntablefield("linkman","rowid",$billinfo['linkman'],"linkmanname");
	$address=$billinfo['address'];
	$mobile=$billinfo['mobile'];
	
	$fapiaoneirong=$billinfo['fapiaoneirong'];
	$fapiaotype=$billinfo['fapiaotype'];
	$fapiaono=$billinfo['fapiaono'];
	$totalmoney=$billinfo['totalmoney'];
	
	$accountid=$_POST['accountid'];
	$oddment=floatval($_POST['quling']);
	$shoukuan=floatval($_POST['shoukuan']);
	$usejifen=intval($_POST['usejifen']);

	$goalfile = "../Framework/global_config.ini";
	$ini_file = @parse_ini_file( $goalfile,true);
	$jifenBaseNum=intval($ini_file[section][minNum]);//积分基数
	$jifenToMoneyRate=doubleval($ini_file[section][changeMoney]);//积分兑换率
	
	try {

		if($user_flag>0)
			throw  new Exception("此单已执行过，不能重复执行");
		$chongdi=0;
		if(!empty($jifenBaseNum) && !empty($usejifen) && !empty($jifenToMoneyRate))
		{
			if($usejifen%$jifenBaseNum!=0)
				throw  new Exception("使用积分数必须是".$jifenBaseNum."的整数倍");
			$chongdi=$usejifen*$jifenToMoneyRate;
			if($chongdi>$totalmoney-$oddment)
				throw  new Exception("积分冲抵金额不能大于".($totalmoney-$oddment));
		}
		
		//if($shoukuan+$oddment>$totalmoney)
		//	$shoukuan=$totalmoney-$oddment;
		//开启事务
		global $db;
		//$db->debug=1;
		$db->StartTrans();
		$CaiWu =new CaiWu($db);
		$Store =new Store($db);

		//付款
		$opertype='';
		if($_POST['ifpay']==1)
		{
			//付全款
			$opertype='货款收取';
			$shoukuan=$totalmoney-$oddment-$chongdi;
		}
		else
		{
			//付押金
			$opertype='收押金';
		}

		//插入新回款记录
		if($shoukuan!=0 || $oddment!=0 || $chongdi!=0)
		{
			$CaiWu->insertShoukuanReocord($customerid,$billid,$shoukuan,$accountid,$_SESSION['LOGIN_USER_ID'],$opertype,$oddment,'1','',$usejifen,$chongdi);
		}
		//出库
		$chukubillid=$Store->insertSellOneChuKu($billid,$zhuti,$storeid);
		//发货
		if($billinfo['fahuostate']==0 && $chukubillid>0)
		{
			$Store->insertFaHuo($chukubillid,$customerid,$billid,$shouhuoren,$mobile,$address);
		}
		//开票
		if($billinfo['kaipiaostate']==0 && $shoukuan+$oddment!=0)
		{
			$CaiWu->insertKaiPiao($customerid,$billid,$fapiaoneirong,$fapiaotype,$fapiaono,$shoukuan+$oddment,$_SESSION['LOGIN_USER_ID']);
		}
			
		//是否事务出现错误
		if ($db->HasFailedTrans())
			throw  new Exception($db->ErrorMsg());
		$db->CompleteTrans();

		page_css("店面销售单");
		$return=FormPageAction("action","init_default");
		
		
		print "<iframe id='printFrame' border=0 width=0 height=0></iframe>
			<script>document.getElementById('printFrame').src='sellonemain_newai.php?action=printXiaoPiao&billid=".$billid."';
			</script>";	
		print_infor("店面销售单执行完成",'trip',"location='?$return'","?$return",1);
		
	}
	catch (Exception $e)
	{
		print "<script language=javascript>alert('错误：".$e->getMessage()."');window.history.back(-1);</script>";
	}
	exit;
}
//撤销店面销售单
if($_GET['action']=="delete_array")			
{
	$selectid=$_GET['selectid'];
	$selectid=explode(",", $selectid);
	try 
	{
		//开启事务
		$CaiWu=new CaiWu($db);
	    $db->StartTrans();  
		for($i=0;$i<sizeof($selectid);$i++)
		{
			if($selectid[$i]!="")
			{
					
				$billid=$selectid[$i];
				$sql="update sellplanmain set user_flag=-1 where billid=$billid and user_flag=0";
				$rs=$db->Execute($sql);
				if ($rs === false)
					throw new Exception("不存在此记录");	
				$sql="insert into sellplanmain_detail_delete (select * from sellplanmain_detail_tmp where mainrowid=$billid)";
				$db->Execute($sql);
				$sql="delete from sellplanmain_detail_tmp where mainrowid=$billid";
				$db->Execute($sql);

			}

		}
		$db->CompleteTrans();
		//是否事务出现错误
		page_css("");
		if ($db->HasFailedTrans()) 
			throw new Exception($db->ErrorMsg());
		else 
		{ 
			$return=FormPageAction("action","init_default");
			print_infor("店面销售单已撤销",'trip',"location='?$return'","?$return",0);
		}
    	
	}
	catch(Exception $e)
	{
		print "<script language=javascript>alert('错误：".$e->getMessage()."');window.history.back(-1);</script>";
	}
	exit;	
}
if($_GET['action']=="printXiaoPiao")
{
	
	//去除打印设置参数
	@$ini_file = @parse_ini_file( "../Framework/sellone_print_config.ini",true);
	$sell_order_field_config = $ini_file['sell_order_print_field'];
	$sell_order_detail_field_config = $ini_file['sell_order_detail_print_field'];
	$fujia = $ini_file['fujia']['con'];
	$fujia = str_replace("^^","<br>",$fujia);
	asort($sell_order_field_config);
	asort($sell_order_detail_field_config);
	@$ini_file = @parse_ini_file( "../Framework/global_config.ini",true);
	$print_paper_width = $ini_file['paper_size']['width'];
	$print_paper_height = $ini_file['paper_size']['height'];
	
	$page_foot_fields=array();//页脚显示字段
	$page_head_fields=array();//页头显示字段
	$tablename="v_sellone_search";
	foreach ($sell_order_field_config as $key=>$val)
	{
		if($val<0)
			array_push($page_foot_fields, $key);
		else 
			array_push($page_head_fields, $key);
	}
	$page_foot_fields=array_reverse($page_foot_fields);
	$mainfieldsarray=array_merge($page_head_fields,$page_foot_fields);
	$mainfields=implode(",", $mainfieldsarray);
	$page_foot_fields=array_flip($page_foot_fields);
	$page_head_fields=array_flip($page_head_fields);
	

	// 获取销售单打印字段中文名
	$sql = "select fieldname,chinese from systemlang where tablename='$tablename'";
	$rs=$db->Execute($sql);
	$rs_a = $rs->GetArray();
	foreach ($rs_a as $row){
		if(isset($page_foot_fields[$row['fieldname']])){
			$page_foot_fields[$row['fieldname']]=array();
			$page_foot_fields[$row['fieldname']]['name'] = $row['chinese'];
			
		}
		if(isset($page_head_fields[$row['fieldname']])){
			$page_head_fields[$row['fieldname']]=array();
			$page_head_fields[$row['fieldname']]['name'] = $row['chinese'];
			
		}
	}
	//取得值
	$sql = "select $mainfields from $tablename where billid='".$_GET['billid']."'";
	$rs=$db->Execute($sql);
	$rs_a = $rs->GetArray();
	
	foreach ($page_foot_fields as $key=>$val){
		if(isset($rs_a[0][$key])){
			$page_foot_fields[$key]['value']=$rs_a[0][$key];
		}
	}
	/*
	if(intval($page_foot_fields['ifpay']['value'])<2)
	{
		$page_foot_fields['own']['name']="尚欠";
		$page_foot_fields['own']['value']=$page_foot_fields['totalmoney']['value']-$page_foot_fields['oddment']['value']-$page_foot_fields['huikuanjine']['value'];
	}
	*/

	foreach ($page_head_fields as $key=>$val){
		if(isset($rs_a[0][$key])){
			$page_head_fields[$key]['value']=$rs_a[0][$key];
		}
	}
	$custInfo=returntablefield("customer", "ROWID", $page_head_fields['supplyid']['value'], "yuchuzhi,contactaddress");
	if(floatval($custInfo['yuchuzhi'])>0)
	{
		$page_foot_fields['yuchuzhi']['name']="预储值";
		$page_foot_fields['yuchuzhi']['value']=number_format($custInfo['yuchuzhi'],2);
	}
	
	$sql="select sum(`a`.`totalmoney` - `a`.`huikuanjine` - `a`.`oddment`) AS `pay_own` from `sellplanmain` `a` where ((`a`.`ifpay` < 2) and (`a`.`user_flag` = 1)) and `a`.`supplyid` ='".$page_head_fields['supplyid']['value']."'";
	$sql.=" and a.fahuostate=-1";
	$rs=$db->Execute($sql);
	$rs_a = $rs->GetArray();
	if($rs_a[0]['pay_own']!=0)
	{
		$page_foot_fields['pay_own']['name']="累计欠款";
		$page_foot_fields['pay_own']['value']=number_format($rs_a[0]['pay_own'],2);
	}

	//取得过滤器
	$sellone_columns=returntablecolumn($tablename);
	@$sellplanmain_ini_file = @parse_ini_file('../JXC/Model/'.$tablename.'_newai.ini',true);
	$showlistfieldlist = explode(',', $sellplanmain_ini_file['view_default']['showlistfieldlist']);
	$showlistfieldfilter = explode(',', $sellplanmain_ini_file['view_default']['showlistfieldfilter']);
	foreach ($showlistfieldlist as $key=>$val){
		if(isset($sellone_columns[$val]) && isset($page_head_fields[$sellone_columns[$val]])){
			$page_head_fields[$sellone_columns[$val]]['filter'] =  $showlistfieldfilter[$key];
		}
		if(isset($sellone_columns[$val]) && isset($page_foot_fields[$sellone_columns[$val]])){
			$page_foot_fields[$sellone_columns[$val]]['filter'] =  $showlistfieldfilter[$key];
		}
	}
	//过滤后的值
	foreach ($page_foot_fields as $key=>$val){
		$filterArray=explode(":",$val['filter']);
		if($filterArray[0]=="tablefilter" || $filterArray[0]=="tablefiltercolor")
		{
			$relationTable_columns=returntablecolumn($filterArray[1]);
			$page_foot_fields[$key]['value']=returntablefield($filterArray[1], $relationTable_columns[$filterArray[2]], $page_foot_fields[$key]['value'], $relationTable_columns[$filterArray[3]]);
		}
	}
	foreach ($page_head_fields as $key=>$val){
	$filterArray=explode(":",$val['filter']);
		if($filterArray[0]=="tablefilter" || $filterArray[0]=="tablefiltercolor")
		{
			$relationTable_columns=returntablecolumn($filterArray[1]);
			$page_head_fields[$key]['value']=returntablefield($filterArray[1], $relationTable_columns[$filterArray[2]], $page_head_fields[$key]['value'], $relationTable_columns[$filterArray[3]]);
		}
	}
	$page_head_fields['supplyid']['value']=$custInfo['contactaddress'].' '.$page_head_fields['supplyid']['value'];
	?>
	<TITLE></TITLE>
	<META http-equiv=Content-Type content="text/html; charset=gb2312">
	<meta http-equiv="x-ua-compatible" content="IE=6">
		<script language="javascript" src="../LODOP60/LodopFuncs.js"></script>
<object id="LODOP_OB" classid="clsid:2105C259-1E0C-4534-8141-A753534CB4CA" width=0 height=0 > 
		<embed id="LODOP_EM" type="application/x-print-lodop" width=0 height=0></embed> 
	</object>
	
<STYLE>
	@media print {
	input{display:none}
	}
	xmp{page-break-before: always}
	.highlight {BACKGROUND:#d0ecfa;}
	</STYLE>
<body id="all">
<?php 
	
	//输出表头
	echo "<div id='head'><table border=0 style='width:".($print_paper_width-9)."mm;margin:0;padding:0;font-size:12px;'>
	<tr><td colspan=2 align=center style='height:50px'><table border=0><tr><td><H3>".htmlspecialchars_decode($_SESSION['shortname'])."</h3></td><td><h3>销售单-".$page_head_fields['billid']['value']."</H3></td></tr></table></td></tr>";
	foreach ($page_head_fields as $key=>$val)
	{
		if($key=="billid") continue;
		echo "<tr><td nowrap valign=top width=20%>".$val['name'].":</td><td valign=top>".$val['value']."</td></tr>";

	}
	echo "</table></div>";
	
	//单据明细表头
	$page_main_fields=array();
	foreach ($sell_order_detail_field_config as $key=>$val)
	{
		array_push($page_main_fields, $key);
	}
	
	//单据明细数据
	$sql = "SELECT * FROM sellplanmain_detail WHERE mainrowid=".$_GET['billid']." order by prodname";
	$rs=$db->Execute($sql);
	$detail = $rs->GetArray();
	
	$sell_data=array();//销售
	$back_data=array();//退货
	$gift_data=array();//赠品
	foreach ($detail as $key=>$val)
	{
		if($val['opertype']==0)
			array_push($gift_data, $val);
		else 
		{
			if($val['num']<0)
				array_push($back_data, $val);
			else 
				array_push($sell_data, $val);
		}
	}
	// 获取销售单明细打印字段中文名
	
	$page_main_fields=array_flip($page_main_fields);
	
	$sql = "select fieldname,chinese from systemlang where tablename='sellplanmain_detail'";
	$rs=$db->Execute($sql);
	$rs_a = $rs->GetArray();
	foreach ($rs_a as $row){
		if(isset($page_main_fields[$row['fieldname']])){
			$page_main_fields[$row['fieldname']] = $row['chinese'];
		}
	}
	
	$cols=sizeof($page_main_fields);
	//输出内容
	echo "<div id='maindata'><table border=0 style='width:".($print_paper_width-9)."mm;margin:0;padding:0;font-size:12px;'>
	<tr><td colspan=$cols align=center><hr color='#000000' width=100%></td></tr><tr>";
	foreach ($page_main_fields as $key=>$val)
	{
		echo "<td><b>".$val."</b></td>";

	}
	echo "</tr>";
	$sell_num=0;
	$sell_jine=0;
	foreach ($sell_data as $key=>$val)
	{
		echo "<tr>";
		foreach ($page_main_fields as $itemkey=>$itemval)
		{
			if($itemkey=='prodid')
			{
				echo "<td>";
				if(strlen($val[$itemkey])>5)
				{
					echo substr($val[$itemkey],0,strlen($val[$itemkey])-5);
					echo " ";
					echo "<u>".substr($val[$itemkey],-5)."</u>";
				}
				else
					echo $val[$itemkey];
				echo "</td>";
			}
			else
				echo "<td>".$val[$itemkey]."</td>";
		}
		echo "</tr>";
		$sell_num=$sell_num+$val['num'];
		$sell_jine=$sell_jine+$val['jine'];
	}
	echo "<tr><td colspan=$cols><b>小计</b>：数量：$sell_num 金额：<b>".number_format($sell_jine,2)."</b><br>&nbsp;</td></tr>";
	if(sizeof($back_data)>0)
	{
		echo "<tr><td colspan=$cols><b>退货：</b></td></tr>";
		$sell_num=0;
		$sell_jine=0;
		foreach ($back_data as $key=>$val)
		{
			echo "<tr>";
			foreach ($page_main_fields as $itemkey=>$itemval)
			{
				echo "<td>".$val[$itemkey]."</td>";
			}
			echo "</tr>";
			$sell_num=$sell_num+$val['num'];
			$sell_jine=$sell_jine+$val['jine'];
		}
		echo "</tr>";
		echo "<tr><td colspan=$cols><b>小计</b>：数量：$sell_num 金额：<b>".number_format($sell_jine,2)."</b><br>&nbsp;</td></tr>";
	}
	if(sizeof($gift_data)>0)
	{
		echo "<tr><td colspan=$cols><b>赠品：</b></td></tr>";
		$sell_num=0;
		$sell_jine=0;
		foreach ($gift_data as $key=>$val)
		{
			echo "<tr>";
			foreach ($page_main_fields as $itemkey=>$itemval)
			{
				if($itemkey=='prodid')
				{
					echo "<td>";
					if(strlen($val[$itemkey])>5)
					{
						echo substr($val[$itemkey],0,strlen($val[$itemkey])-5);
						echo " ";
						echo "<u>".substr($val[$itemkey],-5)."</u>";
					}
					else
						echo $val[$itemkey];
					echo "</td>";
				}
				else if($itemkey=='sellprice')
					echo "<td>".round($val['price']*$val['zengpinzhekou'],2)."</td>";
				else if($itemkey=='jine')
					echo "<td>".round($val['price']*$val['zengpinzhekou']*$val['num'],2)."</td>";
				else
					echo "<td>".$val[$itemkey]."</td>";
			}
			echo "</tr>";
			$sell_num=$sell_num+$val['num'];
			$sell_jine=$sell_jine+$val['price']*$val['num']*$val['zengpinzhekou'];
		}
		echo "</tr>";
		echo "<tr><td colspan=$cols><b>小计</b>：数量：$sell_num 金额：<b>".number_format($sell_jine,2)."</b><br></td></tr>";
	}
	echo "</table></div>";
	//输出表尾
	echo "<div id='foot'><table border=0 style='width:".($print_paper_width-9)."mm;margin:0;padding:0;font-size:12px;'>
	<tr><td colspan=$cols align=center><hr color='#000000' width=100%></td></tr><tr>";
	foreach ($page_foot_fields as $key=>$val)
	{
		echo "<tr><td nowrap valign=top width=20%>".$val['name'].":</td><td><b>".$val['value']."</b></td></tr>";

	}
	echo "<tr><td colspan=$cols>$fujia</td></tr>";
	echo "</table></div>";
	//echo "<input type=button id='printbt' value='打印' onclick='print_control()'>";
	echo "</body>";
	?>
	
	<script type="text/javascript">
var LODOP; //声明为全局变量 
function print_control(){
	LODOP=getLodop(document.getElementById('LODOP_OB'),document.getElementById('LODOP_EM'));  
	//这里3表示纵向打印且纸高“按内容的高度”；纸宽80mm；45表示页底空白4.5mm
	if ((LODOP!=null)&&(typeof(LODOP.VERSION)!="undefined"))
	{
		LODOP.PRINT_INIT("<?php echo $page_head_fields['billid']['value']?>");
		LODOP.SET_PRINT_PAGESIZE(3,<?php echo $print_paper_width*10?>,60,"");
		LODOP.ADD_PRINT_HTM('3%','0%','100%','100%',"<body leftmargin=0>"+document.getElementById('all').innerHTML+"</body>");
		LODOP.SET_PRINT_STYLEA(0,"Horient",3);
		LODOP.SET_SHOW_MODE("HIDE_PAPER_BOARD",1);
		LODOP.SET_PREVIEW_WINDOW(1,1,1,800,600,"<?php echo $page_head_fields['billid']['value']?>.开始打印");//打印前弹出选择打印机的对话框	
		LODOP.SET_PRINT_MODE("AUTO_CLOSE_PREWINDOW",1);//打印后自动关闭预览窗口
		//LODOP.SET_PRINT_MODE("PRINT_PAGE_PERCENT","Auto-Width");// 整宽不变形
		LODOP.PREVIEW();
	}
	else
	{
		//window.open('<?php echo "http://".$_SERVER['SERVER_NAME'].':'.$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];?>');
	}

}
window.onload=function()
{
	print_control();
}
</script>
	
	<?php 
 	exit;
}
$realtablename="sellplanmain";
$SYSTEM_ADD_SQL =getRoleByUser($SYSTEM_ADD_SQL,"user_id");
$limitEditDelUser='user_id';
$filetablename = "v_sellone";
$parse_filename	="sellone";
require_once( "include.inc.php" );
systemhelpcontent( "销售单录入", "100%" );
print "<iframe name='hideframe' width=0 height=0 border=0 src=''/>";
?>