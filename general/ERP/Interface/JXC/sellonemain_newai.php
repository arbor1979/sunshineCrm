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
ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL);
error_reporting(E_WARNING | E_ERROR);
require_once('lib.inc.php');
$GLOBAL_SESSION=returnsession();
validateMenuPriv("���۵�¼��","���۵���ѯ");
if($_GET['action']=="add_default")
{
	$ADDINIT=array("fahuostate"=>-1,"kaipiaostate"=>-1);
	
}
if($_GET['action']=="add_default_data")
{
	$_POST['billtype']=3;
	$billid = returnAutoIncrement("billid","sellplanmain");
	$_POST['zhuti']='�������۵�-'.$billid;
	
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
		print "<script language=javascript>alert('���󣺵����Ѳ�������ʱ�������ܱ༭');location='sellonemain_newai.php';</script>";
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
	print "<script>location='DataQuery/productFrame.php?tablename=v_sellonedetail&deelname=�������۵���ϸ&rowid=".$_GET['billid']."'</script>";
	exit;
}

if($_GET['action']=="edit_finish")
{
	$user_flag=returntablefield("sellplanmain","billid",$_GET['billid'], "user_flag");
	if($user_flag!=0)
	{
		print "<script language=javascript>alert('���󣺵����Ѳ�������ʱ�����������տ�');location='sellonemain_newai.php';</script>";
		exit;
	}	
	$sql="select sum(round(price*zhekou,2)*num) as jine,count(*) as linenum from sellplanmain_detail_tmp where mainrowid=".$_GET['billid'];
	$rs=$db->Execute($sql);
	$rs_a=$rs->GetArray();
	$allmoney=round($rs_a[0]['jine'],2);
	$allcount=$rs_a[0]['linenum'];
	if($allcount==0)
	{
		print "<script language=javascript>alert('��������¼����ϸ');window.history.back(-1);</script>";
		exit;
	}
	$totalmoney=returntablefield("sellplanmain", "billid", $_GET['billid'], "totalmoney");
	if($allmoney!=$totalmoney)
	{
		print "<script language=javascript>alert('���󣺵��ݽ��".$totalmoney."����ϸ�ϼ�".$allmoney."��һ�£������±�����ϸ');window.history.back(-1);</script>";
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
	$jifenBaseNum=intval($ini_file[section][minNum]);//���ֻ���
	$jifenToMoneyRate=doubleval($ini_file[section][changeMoney]);//���ֶһ���
	
	try {

		if($user_flag>0)
			throw  new Exception("�˵���ִ�й��������ظ�ִ��");
		$chongdi=0;
		if(!empty($jifenBaseNum) && !empty($usejifen) && !empty($jifenToMoneyRate))
		{
			if($usejifen%$jifenBaseNum!=0)
				throw  new Exception("ʹ�û�����������".$jifenBaseNum."��������");
			$chongdi=$usejifen*$jifenToMoneyRate;
			if($chongdi>$totalmoney-$oddment)
				throw  new Exception("���ֳ�ֽ��ܴ���".($totalmoney-$oddment));
		}
		
		//if($shoukuan+$oddment>$totalmoney)
		//	$shoukuan=$totalmoney-$oddment;
		//��������
		global $db;
		//$db->debug=1;
		$db->StartTrans();
		$CaiWu =new CaiWu($db);
		$Store =new Store($db);

		//����
		$opertype='';
		if($_POST['ifpay']==1)
		{
			//��ȫ��
			$opertype='������ȡ';
			$shoukuan=$totalmoney-$oddment-$chongdi;
		}
		else
		{
			//��Ѻ��
			$opertype='��Ѻ��';
		}

		//�����»ؿ��¼
		if($shoukuan!=0 || $oddment!=0 || $chongdi!=0)
		{
			$CaiWu->insertShoukuanReocord($customerid,$billid,$shoukuan,$accountid,$_SESSION['LOGIN_USER_ID'],$opertype,$oddment,'1','',$usejifen,$chongdi);
		}
		//����
		$chukubillid=$Store->insertSellOneChuKu($billid,$zhuti,$storeid);
		//����
		if($billinfo['fahuostate']==0 && $chukubillid>0)
		{
			$Store->insertFaHuo($chukubillid,$customerid,$billid,$shouhuoren,$mobile,$address);
		}
		//��Ʊ
		if($billinfo['kaipiaostate']==0 && $shoukuan+$oddment!=0)
		{
			$CaiWu->insertKaiPiao($customerid,$billid,$fapiaoneirong,$fapiaotype,$fapiaono,$shoukuan+$oddment,$_SESSION['LOGIN_USER_ID']);
		}
			
		//�Ƿ�������ִ���
		if ($db->HasFailedTrans())
			throw  new Exception($db->ErrorMsg());
		$db->CompleteTrans();

		page_css("�������۵�");
		$return=FormPageAction("action","init_default");
		
		
		print "<iframe id='printFrame' border=0 width=0 height=0></iframe>
			<script>document.getElementById('printFrame').src='sellonemain_newai.php?action=printXiaoPiao&billid=".$billid."';
			</script>";	
		print_infor("�������۵�ִ�����",'trip',"location='?$return'","?$return",1);
		
	}
	catch (Exception $e)
	{
		print "<script language=javascript>alert('����".$e->getMessage()."');window.history.back(-1);</script>";
	}
	exit;
}
//�����������۵�
if($_GET['action']=="delete_array")			
{
	$selectid=$_GET['selectid'];
	$selectid=explode(",", $selectid);
	try 
	{
		//��������
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
					throw new Exception("�����ڴ˼�¼");	
				$sql="insert into sellplanmain_detail_delete (select * from sellplanmain_detail_tmp where mainrowid=$billid)";
				$db->Execute($sql);
				$sql="delete from sellplanmain_detail_tmp where mainrowid=$billid";
				$db->Execute($sql);

			}

		}
		$db->CompleteTrans();
		//�Ƿ�������ִ���
		page_css("");
		if ($db->HasFailedTrans()) 
			throw new Exception($db->ErrorMsg());
		else 
		{ 
			$return=FormPageAction("action","init_default");
			print_infor("�������۵��ѳ���",'trip',"location='?$return'","?$return",0);
		}
    	
	}
	catch(Exception $e)
	{
		print "<script language=javascript>alert('����".$e->getMessage()."');window.history.back(-1);</script>";
	}
	exit;	
}
if($_GET['action']=="printXiaoPiao")
{
	
	//ȥ����ӡ���ò���
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
	
	$page_foot_fields=array();//ҳ����ʾ�ֶ�
	$page_head_fields=array();//ҳͷ��ʾ�ֶ�
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
	

	// ��ȡ���۵���ӡ�ֶ�������
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
	//ȡ��ֵ
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
		$page_foot_fields['own']['name']="��Ƿ";
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
		$page_foot_fields['yuchuzhi']['name']="Ԥ��ֵ";
		$page_foot_fields['yuchuzhi']['value']=number_format($custInfo['yuchuzhi'],2);
	}
	
	$sql="select sum(`a`.`totalmoney` - `a`.`huikuanjine` - `a`.`oddment`) AS `pay_own` from `sellplanmain` `a` where ((`a`.`ifpay` < 2) and (`a`.`user_flag` = 1)) and `a`.`supplyid` ='".$page_head_fields['supplyid']['value']."'";
	$sql.=" and a.fahuostate=-1";
	$rs=$db->Execute($sql);
	$rs_a = $rs->GetArray();
	if($rs_a[0]['pay_own']!=0)
	{
		$page_foot_fields['pay_own']['name']="�ۼ�Ƿ��";
		$page_foot_fields['pay_own']['value']=number_format($rs_a[0]['pay_own'],2);
	}

	//ȡ�ù�����
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
	//���˺��ֵ
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
	
	//�����ͷ
	echo "<div id='head'><table border=0 style='width:".($print_paper_width-9)."mm;margin:0;padding:0;font-size:12px;'>
	<tr><td colspan=2 align=center style='height:50px'><table border=0><tr><td><H3>".htmlspecialchars_decode($_SESSION['shortname'])."</h3></td><td><h3>���۵�-".$page_head_fields['billid']['value']."</H3></td></tr></table></td></tr>";
	foreach ($page_head_fields as $key=>$val)
	{
		if($key=="billid") continue;
		echo "<tr><td nowrap valign=top width=20%>".$val['name'].":</td><td valign=top>".$val['value']."</td></tr>";

	}
	echo "</table></div>";
	
	//������ϸ��ͷ
	$page_main_fields=array();
	foreach ($sell_order_detail_field_config as $key=>$val)
	{
		array_push($page_main_fields, $key);
	}
	
	//������ϸ����
	$sql = "SELECT * FROM sellplanmain_detail WHERE mainrowid=".$_GET['billid']." order by prodname";
	$rs=$db->Execute($sql);
	$detail = $rs->GetArray();
	
	$sell_data=array();//����
	$back_data=array();//�˻�
	$gift_data=array();//��Ʒ
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
	// ��ȡ���۵���ϸ��ӡ�ֶ�������
	
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
	//�������
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
	echo "<tr><td colspan=$cols><b>С��</b>��������$sell_num ��<b>".number_format($sell_jine,2)."</b><br>&nbsp;</td></tr>";
	if(sizeof($back_data)>0)
	{
		echo "<tr><td colspan=$cols><b>�˻���</b></td></tr>";
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
		echo "<tr><td colspan=$cols><b>С��</b>��������$sell_num ��<b>".number_format($sell_jine,2)."</b><br>&nbsp;</td></tr>";
	}
	if(sizeof($gift_data)>0)
	{
		echo "<tr><td colspan=$cols><b>��Ʒ��</b></td></tr>";
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
		echo "<tr><td colspan=$cols><b>С��</b>��������$sell_num ��<b>".number_format($sell_jine,2)."</b><br></td></tr>";
	}
	echo "</table></div>";
	//�����β
	echo "<div id='foot'><table border=0 style='width:".($print_paper_width-9)."mm;margin:0;padding:0;font-size:12px;'>
	<tr><td colspan=$cols align=center><hr color='#000000' width=100%></td></tr><tr>";
	foreach ($page_foot_fields as $key=>$val)
	{
		echo "<tr><td nowrap valign=top width=20%>".$val['name'].":</td><td><b>".$val['value']."</b></td></tr>";

	}
	echo "<tr><td colspan=$cols>$fujia</td></tr>";
	echo "</table></div>";
	//echo "<input type=button id='printbt' value='��ӡ' onclick='print_control()'>";
	echo "</body>";
	?>
	
	<script type="text/javascript">
var LODOP; //����Ϊȫ�ֱ��� 
function print_control(){
	LODOP=getLodop(document.getElementById('LODOP_OB'),document.getElementById('LODOP_EM'));  
	//����3��ʾ�����ӡ��ֽ�ߡ������ݵĸ߶ȡ���ֽ��80mm��45��ʾҳ�׿հ�4.5mm
	if ((LODOP!=null)&&(typeof(LODOP.VERSION)!="undefined"))
	{
		LODOP.PRINT_INIT("<?php echo $page_head_fields['billid']['value']?>");
		LODOP.SET_PRINT_PAGESIZE(3,<?php echo $print_paper_width*10?>,60,"");
		LODOP.ADD_PRINT_HTM('3%','0%','100%','100%',"<body leftmargin=0>"+document.getElementById('all').innerHTML+"</body>");
		LODOP.SET_PRINT_STYLEA(0,"Horient",3);
		LODOP.SET_SHOW_MODE("HIDE_PAPER_BOARD",1);
		LODOP.SET_PREVIEW_WINDOW(1,1,1,800,600,"<?php echo $page_head_fields['billid']['value']?>.��ʼ��ӡ");//��ӡǰ����ѡ���ӡ���ĶԻ���	
		LODOP.SET_PRINT_MODE("AUTO_CLOSE_PREWINDOW",1);//��ӡ���Զ��ر�Ԥ������
		//LODOP.SET_PRINT_MODE("PRINT_PAGE_PERCENT","Auto-Width");// ��������
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
systemhelpcontent( "���۵�¼��", "100%" );
print "<iframe name='hideframe' width=0 height=0 border=0 src=''/>";
?>