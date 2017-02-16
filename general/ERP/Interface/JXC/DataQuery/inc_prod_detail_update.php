<?php 
	ini_set('display_errors',1);
	ini_set('error_reporting',E_ALL);
	error_reporting(E_WARNING | E_ERROR);
	require_once("lib.inc.php");
	$GLOBAL_SESSION=returnsession();
	header('Content-Type:text/xml;charset=GB2312'); 
    $action = $_GET["action"];     //��ȡ����
    $productId = $_GET["productId"];           //��ȡ��Ʒ���
    $rowid= $_GET["rowid"];		//����ID
    $tablename=$_GET["tablename"];//����
    //ȡ�òֿ�
    $storeid=$_GET['storeid'];
    $priceReadonly=0;
	$zhekouReadonly=0;
	$tablename1=$tablename;
	if($tablename=='v_sellonedetail')
   		$tablename="sellplanmain_detail_tmp";

    
    if($tablename=="stockchangemain_detail")
    {
    	
    	$priceReadonly=1;
    	$zhekouReadonly=1;
    }
    else if($tablename=="storecheck_detail")
    {
    	
    	$priceReadonly=1;
    	$zhekouReadonly=1;
    }
     else if($tablename=="productzuzhuang_detail")
    {
    	
    	$priceReadonly=1;
    	$zhekouReadonly=1;
    }
    else if($tablename=="sellplanmain_detail_tmp"  || $tablename=="sellplanmain_detail")
    {
   		if(!$_SESSION['ModifyPrice'])
    		$priceReadonly=1;
    }
	$id=$_GET["id"];//��ǰ��¼ID
    if ($action=="add") {
    	$im=$_GET["im"];	//���뷽ʽ 1=������2=���룬3=ѡ��
		$addnum=$_GET["addnum"]; //��������ʱ�����ӵ�����
		$opertype=$_GET["opertype"];
        addProduct($productId,$im,$addnum,$opertype);                           //�����²�Ʒ  
    }else if ($action=="empty") {
        clearProduct($rowid);                            //����б�
    } else if ($action=="del") {
        delProduct($id);                           //ɾ����Ʒ
    } else if ($action=="updatePrice") {
    	$price=$_GET["price"];
        updateProductPrice($id,$price);                           //���²�Ʒ�۸�
    }
    else if ($action=="updateAmount") {
    	$amount=$_GET["amount"];
        updateProductAmount($id,$amount);                           //���²�Ʒ����
    }
    else if ($action=="updateZhekou") {
    	$zhekou=$_GET["zhekou"];
        updateProductZhekou($id,$zhekou);                           //���²�Ʒ����
    }
    else if ($action=="updateZhekouAll") {
    	$zhekou=$_GET["zhekou"];
    	$billid=$_GET["billid"];
        updateProductZhekouAll($billid,$zhekou);                           //���²�Ʒ����
    }
    else if ($action=="updateMoney") {
    	$jine=$_GET["jine"];
        updateProductJine($id,$jine);                           //���²�Ʒ����
    }
    else if ($action=="updateMemo") {
    	$beizhu=$_GET["beizhu"];
        updateProductBeizhu($id,$beizhu);                           //���²�Ʒ����
    }
    else if ($action=="Save") {
        SaveAll();                           //���沢����
    }
    else if ($action=="search") {
    	$keyword=$_GET["keyword"];
        SearchProduct($keyword);                           //������Ʒ
    }
    
    function SearchProduct($keyword)
    {
    	global $db;
    	$sql = "select * from product where (productid like '%$keyword%' or productname like '%$keyword%' or oldproductid like '%$keyword%' or productcn like '%$keyword%') limit 20";
		$rs = $db->Execute($sql);
		$rs_a = $rs->GetArray();
    	if (count($rs_a) != 0) 
    	{
        	for($i=0;$i<count($rs_a);$i++)
        	{
        		$productId=$rs_a[$i]['productid'];
        		$productName=$rs_a[$i]['productname'];
        		if($rs_a[$i]['mode']!="")
					$productName=$productName."/".$rs_a[$i]['mode'];
				if($rs_a[$i]['standard']!="")
					$productName=$productName."/".$rs_a[$i]['standard'];
				/*
				$sql="select sum(num) as allnum from store where prodid='$productId'";
				$rs = $db->Execute($sql);
				$rs_b = $rs->GetArray();
				if($rs_b[0]['allnum']!=0)
					$productName.=" (".$rs_b[0]['allnum'].")";
				*/
        		print ($i+1)."��<a href=\"javascript:addProduct('$productId','add',1,1);\">$productName</a><br>";
        	}
    	}
    	else 
    		print "<font color=red>û�з��������Ĳ�Ʒ</font><a href='#'></a>";
    	exit;
    }
    function SaveAll()
    {
    	global $db;
    	global $rowid;
    	global $tablename;
		$sql="select count(*) as allcount,sum(round(price*zhekou,2)*num) as allmoney,sum(num) as allnum,sum(if(num<0,num*price*zhekou,0)) as tuihuo,sum(if(zhekou=0,num*price*zengpinzhekou,0)) as zengpin from ".$tablename." where mainrowid=".$rowid;
    	$rs = $db->Execute($sql);
    	$rs_a = $rs->GetArray();
    	$allcount=$rs_a[0]['allcount'];
    	$allmoney=round($rs_a[0]['allmoney'],2);
    	$allnum=intval($rs_a[0]['allnum']);
    	$tuihuo=doubleval($rs_a[0]['tuihuo']);
    	$zengpin=doubleval($rs_a[0]['zengpin']);
    	if($tablename=="customerproduct_detail")
    	{
    		$sql="update customerproduct set ���=".$allmoney.",������=".$allnum." where ROWID=".$rowid;
    		$db->Execute($sql);
    		$sql="update customerproduct_detail set jine=round(price*zhekou*num,2) where mainrowid=".$rowid;
    		$db->Execute($sql);
    	}
 
    	else if($tablename=="sellplanmain_detail_tmp")
    	{
    		
    		$sql="update sellplanmain set totalmoney=".$allmoney.",totalnum=".$allnum.",tuihuojine=".$tuihuo.",zengpinjine=".$zengpin." where user_flag='0' and billid=".$rowid;
    		$db->Execute($sql);
    		$sql="update sellplanmain_detail_tmp set jine=round(price*zhekou,2)*num,sellprice=round(price*zhekou,2) where mainrowid=".$rowid;
    		$db->Execute($sql);
    	}
    	else if($tablename=="sellplanmain_detail")
    	{
    		$sql="update sellplanmain set totalmoney=".$allmoney.",totalnum=".$allnum.",tuihuojine=".$tuihuo.",zengpinjine=".$zengpin." where user_flag='0' and billid=".$rowid;
    		$db->Execute($sql);
    		$sql="update sellplanmain_detail set jine=round(price*zhekou,2)*num,sellprice=round(price*zhekou,2) where mainrowid=".$rowid;
    		$db->Execute($sql);
    	}
    	else if($tablename=="buyplanmain_detail")
    	{
	    	$sql="select count(*) as allcount,sum(num) as allnum,sum(num*price*zhekou) as allmoney from $tablename where mainrowid=".$rowid;
	    	$rs = $db->Execute($sql);
	    	$rs_a = $rs->GetArray();
	    	$allcount=$rs_a[0]['allcount'];
	    	$allnum=$rs_a[0]['allnum'];
	    	$allmoney=round($rs_a[0]['allmoney'],2);
    		
    		$state=1;
    		if($allcount>0)
    			$state=2;	
    		$sql="update buyplanmain set totalmoney=".$allmoney.",state=$state,totalnum=".$allnum." where billid='".$rowid."'";
    		$db->Execute($sql);
    		$sql="update buyplanmain_detail set jine=round(price*zhekou*num,2) where mainrowid=".$rowid;
    		$db->Execute($sql);

    	}
    	else if($tablename=="stockchangemain_detail")
    	{
    		$sql="update stockchangemain set totalmoney=".$allmoney.",state=2,totalnum=".$allnum." where billid=".$rowid;
    		$db->Execute($sql);
    		$sql="update stockchangemain_detail set jine=round(price*zhekou*num,2) where mainrowid=".$rowid;
    		$db->Execute($sql);
    	}
    	else if($tablename=="storecheck_detail")
    	{
    		$sql="update storecheck set totalmoney=".$allmoney.",state='��¼��ϸ',totalnum=".$allnum." where billid=".$rowid;
			$db->Execute($sql);
			$sql="update storecheck_detail set jine=round(price*zhekou*num,2) where mainrowid=".$rowid;
			$db->Execute($sql);
			
    		
    	}
    	else if($tablename=="productzuzhuang_detail")
    	{
    		//��������
    		try {
	    	$db->StartTrans();
			
			$sql="update productzuzhuang set totalmoney=".$allmoney.",totalnum=".$allnum." where billid=".$rowid;
    		$db->Execute($sql);
    		$sql="update productzuzhuang_detail set jine=round(price*zhekou*num,2) where mainrowid=".$rowid;
    		$db->Execute($sql);
    		
    		$Store=new Store($db);
	   		$Store->newZuZhuangChuKu($rowid);
			
	    	$db->CompleteTrans();
    	}
	    catch (Exception $e)
	    {
	    	print $e->getMessage();
	    	exit;
	    }
			
    		
    	}
    	else if($tablename=="productzuzhuang2_detail")
    	{
    		$totalmoney= returntablefield("productzuzhuang", "billid", $_GET['rowid'], "totalmoney");
    		if($totalmoney!=$allmoney)
    		{
    			print "�����ϼƱ���Ϊ��".$totalmoney;
    			exit;
    		}
    		//��������
    		try {
	    	$db->StartTrans();  
    		$sql="update productzuzhuang2_detail set jine=round(price*zhekou*num,2) where mainrowid=".$rowid;
    		$db->Execute($sql);
    		
    		$Store=new Store($db);
	   		$Store->newZuZhuangRuKu($rowid);
			
			
	    	$db->CompleteTrans();
    		}
    		catch (Exception $e)
	    	{
	    		print $e->getMessage();
	    		exit;
	    	}
    		
    	}
    	print "Save";
    	exit;
    } 
    function updateProductBeizhu($id,$beizhu)
    {
    	global $db;
    	global $tablename;
    	$sql="update ".$tablename." set beizhu='".$beizhu."' where id=".$id;
    	$rs = $db->Execute($sql);
    	print "updateMemo";
    	exit;
    } 
    function ifWarningPrice($price,$prodid)
    {
    	global $db;
    	global $tablename;
    	global $db;
    	global $storeid;
    	$sql = "select sum(num) as allnum,sum(num*price) as allmoney from store where prodid='".$prodid."'";
        if($storeid!="")
           	$sql.=" and storeid=".$storeid;
        $rs = $db->Execute($sql);
        $rs_kucun = $rs->GetArray();
    	if($rs_kucun[0]['allnum']>0)
    	{
    		
    			return round($rs_kucun[0]['allmoney']/$rs_kucun[0]['allnum']-$price,2);
    		
    	}
    	else 
    		return 0;
    	
    }
    function updateProductJine($id,$jine)
    {
    	global $db;
    	global $tablename;
    	$sql="select * from ".$tablename." where id=".$id;
    	$rs = $db->Execute($sql);
    	$rs_a = $rs->GetArray();
    	if(count($rs_a)==0)
    	{
    		print "�˼�¼�Ѳ�����";
    		exit;
    	}
    	$prodid=$rs_a[0]['prodid'];
    	$rowid=$rs_a[0]['mainrowid'];
    	$price=$rs_a[0]['price'];
    	$num=$rs_a[0]['num'];
    	if($price*$num==0)
    	{
    		print "�۸����������Ϊ0";
    		exit;
    	}
    	$zhekou=round($jine/($price*$num),4);
    	$jine=round($price*$zhekou,2)*$num;
    	if($zhekou<=0)
    	{
    		print "�ۿ۱������0";
    		exit;
    	}
    	$sql="update ".$tablename." set zhekou=".$zhekou." where id=".$id;
    	$rs = $db->Execute($sql);
    	if($zhekou==0)
    	{
    		$sql="update ".$tablename." set opertype=0 where id=".$id;
    		$rs = $db->Execute($sql);
    	}
		$sql="select sum(num) as allnum,sum(round(price*zhekou,2)*num) as allmoney,sum(if(num>0,round(price*zhekou,2)*num,0)) as sellmoney,sum(if(num<0,round(price*zhekou,2)*num,0)) as backmoney,sum(if(zhekou=0,num*price*zengpinzhekou,0)) as zengmoney,sum(if(opertype=1,num,0)) as sellnum,sum(if(opertype=-1,-num,0)) as backnum,sum(if(opertype=0,num,0)) as zengnum from ".$tablename." where mainrowid=".$rowid;
    	$rs = $db->Execute($sql);
    	$rs_a = $rs->GetArray();
    	$allnum=$rs_a[0]['allnum'];
    	$allmoney=round($rs_a[0]['allmoney'],2);
    	$sellmoney=round($rs_a[0]['sellmoney'],2);
    	$backmoney=round($rs_a[0]['backmoney'],2);
    	$zengmoney=round($rs_a[0]['zengmoney'],2);
    	$sellnum=$rs_a[0]['sellnum'];
    	$backnum=$rs_a[0]['backnum'];
    	$zengnum=$rs_a[0]['zengnum'];
    	$warnflag=ifWarningPrice($price*$zhekou,$prodid);
    	print "updateMoney|$id|$num|$price|$zhekou|$allnum|$allmoney|$warnflag|$sellmoney|$backmoney|$zengmoney|$sellnum|$backnum|$zengnum";
    	exit;
    } 
    function updateProductZhekou($id,$zhekou)
    {
    	global $db;
    	global $tablename;
    	$sql="select * from ".$tablename." where id=".$id;
    	$rs = $db->Execute($sql);
    	$rs_a = $rs->GetArray();
    	if(count($rs_a)==0)
    	{
    		print "�˼�¼�Ѳ�����";
    		exit;
    	}
    	$zhekou=$zhekou/100;
    	if($zhekou<=0)
    	{
    		print "�ۿ۱������0";
    		exit;
    	}
    	$prodid=$rs_a[0]['prodid'];
    	$rowid=$rs_a[0]['mainrowid'];
    	$price=$rs_a[0]['price'];
    	$num=$rs_a[0]['num'];
    	$jine=round($price*$num*$zhekou,2);
    	    	
    	$sql="update ".$tablename." set zhekou=".$zhekou." where id=".$id;
    	$rs = $db->Execute($sql);
    	
		$sql="select sum(num) as allnum,sum(round(price*zhekou,2)*num) as allmoney,sum(if(num>0,round(price*zhekou,2)*num,0)) as sellmoney,sum(if(num<0,round(price*zhekou,2)*num,0)) as backmoney,sum(if(zhekou=0,num*price*zengpinzhekou,0)) as zengmoney,sum(if(opertype=1,num,0)) as sellnum,sum(if(opertype=-1,-num,0)) as backnum,sum(if(opertype=0,num,0)) as zengnum from ".$tablename." where mainrowid=".$rowid;
    	$rs = $db->Execute($sql);
    	$rs_a = $rs->GetArray();
    	$allnum=$rs_a[0]['allnum'];
    	$allmoney=round($rs_a[0]['allmoney'],2);
    	$sellmoney=round($rs_a[0]['sellmoney'],2);
    	$backmoney=round($rs_a[0]['backmoney'],2);
    	$zengmoney=round($rs_a[0]['zengmoney'],2);
    	$sellnum=$rs_a[0]['sellnum'];
    	$backnum=$rs_a[0]['backnum'];
    	$zengnum=$rs_a[0]['zengnum'];
    	$warnflag=ifWarningPrice($price*$zhekou,$prodid);
    	print "updateZhekou|$id|$num|$price|$zhekou|$allnum|$allmoney|$warnflag|$sellmoney|$backmoney|$zengmoney|$sellnum|$backnum|$zengnum";
    	exit;
    }
    function updateProductZhekouAll($billid,$zhekou)
    {
    	global $db;
    	global $tablename;
    	
    	$zhekou=$zhekou/100;
    	if($zhekou<=0)
    	{
    		print "�ۿ۱������0";
    		exit;
    	}
    	    	
    	$sql="update ".$tablename." set zhekou=".$zhekou." where mainrowid=".$billid." and opertype<>0";
    	$rs = $db->Execute($sql);
    	
    } 
   function updateProductAmount($id,$amount)
    {
    	global $db;
    	global $tablename;
    	if($amount==0)
    	{
    		print "��������Ϊ0��";
    		exit;
    	}
    	
    	if($amount<0 && $tablename!='sellplanmain_detail_tmp' && $tablename!='sellplanmain_detail' && $tablename!='buyplanmain_detail' && $tablename!='storecheck_detail')
    	{
    		print "�����������0";
    		exit;
    	}
    	$sql="select * from ".$tablename." where id=".$id;
    	$rs = $db->Execute($sql);
    	$rs_a = $rs->GetArray();
    	
    	if(count($rs_a)==0)
    	{
    		print "�˼�¼�Ѳ�����";
    		exit;
    	}
    	$addsql='';
    	if($rs_a[0]['opertype']==1 && $amount<0)
    	{
    		print "�����������0";
    		exit;
    		
    	}
    	if($rs_a[0]['opertype']==-1 && $amount>0)
    	{
    		print "��������С��0";
    		exit;
    		
    	}
    	$rowid=$rs_a[0]['mainrowid'];
    	$price=$rs_a[0]['price'];
    	$zhekou=$rs_a[0]['zhekou'];
    	$jine=round($price*$amount*$zhekou,2);

    	$sql="update ".$tablename." set num=".$amount." where id=".$id;
    	$rs = $db->Execute($sql);
		$sql="select sum(num) as allnum,sum(round(price*zhekou,2)*num) as allmoney,sum(if(num>0,round(price*zhekou,2)*num,0)) as sellmoney,sum(if(num<0,round(price*zhekou,2)*num,0)) as backmoney,sum(if(zhekou=0,num*price*zengpinzhekou,0)) as zengmoney,sum(if(opertype=1,num,0)) as sellnum,sum(if(opertype=-1,-num,0)) as backnum,sum(if(opertype=0,num,0)) as zengnum from ".$tablename." where mainrowid=".$rowid;
    	$rs = $db->Execute($sql);
    	$rs_a = $rs->GetArray();
    	$allnum=$rs_a[0]['allnum'];
    	$allmoney=round($rs_a[0]['allmoney'],2);
    	$sellmoney=round($rs_a[0]['sellmoney'],2);
    	$backmoney=round($rs_a[0]['backmoney'],2);
    	$zengmoney=round($rs_a[0]['zengmoney'],2);
    	$sellnum=$rs_a[0]['sellnum'];
    	$backnum=$rs_a[0]['backnum'];
    	$zengnum=$rs_a[0]['zengnum'];
    	print "updateAmount|$id|$amount|$price|$zhekou|$allnum|$allmoney||$sellmoney|$backmoney|$zengmoney|$sellnum|$backnum|$zengnum";
    	exit;
    } 
    function updateProductPrice($id,$price)
    {
    	global $db;
    	global $tablename;
    	if($price<=0)
    	{
    		print "���۱������0";
    		exit;
    	}
    	$sql="select * from ".$tablename." where id=".$id;
    	$rs = $db->Execute($sql);
    	$rs_a = $rs->GetArray();
    	if(count($rs_a)==0)
    	{
    		print "�˼�¼�Ѳ�����";
    		exit;
    	}
    	$rowid=$rs_a[0]['mainrowid'];
    	$prodid=$rs_a[0]['prodid'];
    	$num=$rs_a[0]['num'];
    	$zhekou=$rs_a[0]['zhekou'];
    	$jine=round($price*$num*$zhekou,2);
    	$sql="update ".$tablename." set price=".$price." where id=".$id;
    	$rs = $db->Execute($sql);
		$sql="select sum(num) as allnum,sum(round(price*zhekou,2)*num) as allmoney,sum(if(num>0,round(price*zhekou,2)*num,0)) as sellmoney,sum(if(num<0,round(price*zhekou,2)*num,0)) as backmoney,sum(if(zhekou=0,num*price*zengpinzhekou,0)) as zengmoney,sum(if(opertype=1,num,0)) as sellnum,sum(if(opertype=-1,-num,0)) as backnum,sum(if(opertype=0,num,0)) as zengnum from ".$tablename." where mainrowid=".$rowid;
    	$rs = $db->Execute($sql);
    	$rs_a = $rs->GetArray();
    	
    	$allnum=$rs_a[0]['allnum'];
    	$allmoney=round($rs_a[0]['allmoney'],2);
    	$sellmoney=round($rs_a[0]['sellmoney'],2);
    	$backmoney=round($rs_a[0]['backmoney'],2);
    	$zengmoney=round($rs_a[0]['zengmoney'],2);
    	$sellnum=$rs_a[0]['sellnum'];
    	$backnum=$rs_a[0]['backnum'];
    	$zengnum=$rs_a[0]['zengnum'];
    	$warnflag=ifWarningPrice($price*$zhekou,$prodid);
    	print "updatePrice|$id|$num|$price|$zhekou|$allnum|$allmoney|$warnflag|$sellmoney|$backmoney|$zengmoney|$sellnum|$backnum|$zengnum";
    	exit;
    } 
    
     function clearProduct($rowid)
    {
    	global $db;
    	global $tablename;
    	$sql="delete from ".$tablename." where  mainrowid='$rowid'";
    	$rs = $db->Execute($sql);
    } 
    $custState='';
    function addProduct($productId,$im,$addnum,$opertype)
    {
    	global $custState;
    	global $db;
    	global $rowid;
    	global $tablename;
    	global $storeid;
    	$addnum=intval($addnum);
    	if($addnum<=0)
    	{
    		print "�����������0";
    		exit;
    	}
    	$sql = "select a.*,b.name as colorname from product a left join productcolor b on a.standard=b.id where productid='".$productId."'";
    	$rs = $db->Execute($sql);
		$rs_a = $rs->GetArray();
		if(count($rs_a)==0)
		{
			print "�����ڱ��Ϊ  $productId �Ĳ�Ʒ";
			exit;
		}
		if($rs_a[0]['user_flag']=="��")
		{
			print "��Ʒ���д˲�Ʒ�ѽ�ֹʹ��";
			exit;
		}
	
		$pname=$rs_a[0]['productname'];
		$oldproduct=$rs_a[0]['oldproductid'];
		$guige=$rs_a[0]['colorname'];
		$xinghao=$rs_a[0]['mode'];
		$danwei=$rs_a[0]['measureid'];
		$price=$rs_a[0]['sellprice'];
		$realprice=$rs_a[0]['sellprice'];
		$tiaohuan=$rs_a[0]['iftiaohuan'];
		if($tiaohuan=='��')
			$tiaohuan='��';
		else
			$tiaohuan='';
		if(strval(intval($xinghao))==$xinghao && intval($xinghao)>0)
			$addnum=$addnum*$xinghao;
		$zhekou=1;
		/*
		//ȡ�����һ����¼���ۿ�
		$sql="select zhekou from $tablename where mainrowid=$rowid and zhekou>0 order by orderid desc limit 0,1";
		$rs = $db->Execute($sql);
		$rs_b = $rs->GetArray();
		if(sizeof($rs_b)==1)
			$zhekou=round($rs_b[0]['zhekou'],4);
		*/
		if($opertype==0)
			$zhekou=0;
		$beizhu="";
    	//���۵���ȡ�ͻ��۸�
		if($tablename=="customerproduct_detail")
		{
			/*
			if($_SESSION['custPrice']=="")
			{
				print "���������û��ѹ��ڣ������µ�¼";
				exit;
			}
			
			$customerid=returntablefield("customerproduct", "rowid", $rowid, "�ͻ�");
			$custState=returntablefield("customer", "rowid",$customerid,"state");
			$custprice=returntablefield("customerlever", "rowid",$custState,"relatePrice");
			*/
			$custprice=$_GET['custprice'];
			if($custprice=='')
				$custprice='sellprice';
			$realprice=$rs_a[0][$custprice];
			if($realprice=='')
				$realprice=0;
			
		}
		//���۶�����ȡ�ͻ��۸�
		else if($tablename=="sellplanmain_detail_tmp" || $tablename=="sellplanmain_detail")
		{
			/*
			if($_SESSION['custPrice']=="")
			{
				print "���������û��ѹ��ڣ������µ�¼";
				exit;
			}
			
			$customerid=returntablefield("sellplanmain", "billid", $rowid, "supplyid");
			$custState=returntablefield("customer", "rowid",$customerid,"state");
			$custprice=returntablefield("customerlever", "rowid",$custState,"relatePrice");
			*/
			$custprice=$_GET['custprice'];
			if($custprice=='')
				$custprice='sellprice';
			$realprice=$rs_a[0][$custprice];
			if($realprice=='')
				$realprice=0;
			$minzhekou=$_GET['minzhekou'];
			if($realprice>0 && $minzhekou!='' && $price>0)
			{
				if($minzhekou>($realprice/$price*100))
					$realprice=round($price*$minzhekou/100,2);
			}
		}
		//��һ�βɹ��ļ۸�
		else if($tablename=="buyplanmain_detail")
		{
			$sql="select price*zhekou as price from ".$tablename." where prodid='$productId' and mainrowid<>'$rowid' order by id desc";
			
    		$rs = $db->Execute($sql);
			$rs_a = $rs->GetArray();
			if(count($rs_a)>0)
			{
				$realprice=$rs_a[0]['price'];
			}
		}
    	//���ɱ���
		else if($tablename=="stockchangemain_detail" || $tablename=="storecheck_detail" || $tablename=="productzuzhuang_detail")
		{
			$ifkucun=returntablefield("product","productid",$productId,"ifkucun");
			if($ifkucun=="��")
			{
				print "���Ϊ $productId �Ĳ�Ʒ�������棬���ܽ��п�����";
				exit;
			}
			$sql="select * from store where prodid='$productId' and storeid=".$storeid;
    		$rs = $db->Execute($sql);
			$rs_a = $rs->GetArray();
			if(count($rs_a)>0)
			{
				$realprice=$rs_a[0]['price'];
			}
		}
		$sql="select max(orderid) as orderid from ".$tablename." where mainrowid='$rowid'";
		$rs = $db->Execute($sql);
		$rs_a = $rs->GetArray();
		$orderid=intval($rs_a[0]['orderid'])+1;
		//�Ƿ��Ѵ���
    	$sql="select * from ".$tablename." where prodid='$productId' and mainrowid='$rowid' and opertype=$opertype";
    	$rs = $db->Execute($sql);
		$rs_a = $rs->GetArray();
		if($im==1 || $im==3)
			$addnum=1;
		if($opertype==-1)
    		$addnum=-$addnum;
		if(count($rs_a)>0)
		{
			$sql="update ".$tablename." set num=num+$addnum,orderid=$orderid where id=".$rs_a[0]['id'];
			$rs = $db->Execute($sql);
			
		}
   		else 
   		{
   			
   			if($zhekou!=0 && $price!=0)
   				$zhekou=round($realprice/$price,6);
			
			
			$zengpinzhekou=1;
			if($price!=0)
				$zengpinzhekou=round($realprice/$price,6);
			$sql="insert into ".$tablename." (prodid,prodname,prodguige,prodxinghao,proddanwei,price,zhekou,num,beizhu,mainrowid,oldprodid,opertype,orderid,inputtime,zengpinzhekou)
			values ('$productId','".$pname.$tiaohuan."','$guige','$xinghao','$danwei',$price,$zhekou,$addnum,'$beizhu',$rowid,'$oldproduct','$opertype','$orderid',Now(),$zengpinzhekou)";
			
			$rs = $db->Execute($sql);
			//�Ƿ�������ִ���
			if ($db->HasFailedTrans()) 
		 		print "<script language=javascript>alert('����".str_replace("'",  "\'", $db->ErrorMsg())."');window.history.back(-1);</script>";
			$db->CompleteTrans();
   		}
    } 
   
    function delProduct($id)
    {
    	global $db;
    	global $tablename;
    	$sql="delete from ".$tablename." where id=".$id;
		$rs = $db->Execute($sql);
    }
    $imgurl=ROOT_DIR."general/ERP/Framework/images/sepan.gif";
    $imgurlgray=ROOT_DIR."general/ERP/Framework/images/sepangray.gif";

?>
<form name="form2">
<table align=center class=TableBlock width=100% border=0 id="table1">
<tr >
	<?php 
	if($tablename=="buyplanmain_detail" || $tablename=="sellplanmain_detail_tmp" || $tablename=="sellplanmain_detail" || $tablename=="storecheck_detail")
		echo "<td class=TableHeader></td>";?>
	<td align=center class=TableHeader nowrap>��Ʒ���</td>
    <td align=center class=TableHeader nowrap>��Ʒ����</td>
    <td align=center class=TableHeader nowrap>��ɫ</td>
    <td align=center class=TableHeader nowrap>���</td>
    <td align=center class=TableHeader nowrap>��λ</td>
    <td align=center class=TableHeader nowrap>�۸�</td>
    <td align=center class=TableHeader nowrap>�ۿ�</td>
    <td align=center class=TableHeader nowrap>����</td>
    <td align=center class=TableHeader nowrap>��ǰ���</td>
    <td align=center class=TableHeader nowrap>���</td>
    <td align=center class=TableHeader nowrap>��ע</td>
    <td align=center class=TableHeader nowrap>ɾ��</td>
</tr>

<?php 
	$sql = "select a.*,b.fileaddress from ".$tablename." a left join product b on a.prodid=b.productid where a.mainrowid=".$rowid." order by a.orderid";
	$rs = $db->Execute($sql);
	$rs_a = $rs->GetArray();
    if (count($rs_a) != 0) 
    {
    	
    	$allnum=0;
    	$allnum1=0;
    	$allnum2=0;
    	$allnum3=0;
    	$allmoney=0;
    	$allmoney1=0;
    	$allmoney2=0;
    	$allmoney3=0;
    	$class="";
        for($i=0;$i<count($rs_a);$i++)
        {
        	$allnum=$allnum+$rs_a[$i]['num'];
        	$allmoney=$allmoney+round($rs_a[$i]['price']*$rs_a[$i]['zhekou'],2)*$rs_a[$i]['num'];
        	
        	if($rs_a[$i]['opertype']==1)
        	{
        		$allnum1=$allnum1+$rs_a[$i]['num'];
        		$allmoney1=$allmoney1+round($rs_a[$i]['price']*$rs_a[$i]['zhekou'],2)*$rs_a[$i]['num'];
        	}
        	else if($rs_a[$i]['opertype']==-1)
        	{
        		$allnum2=$allnum2+$rs_a[$i]['num'];
        		$allmoney2=$allmoney2+round($rs_a[$i]['price']*$rs_a[$i]['zhekou'],2)*$rs_a[$i]['num'];
        	}
        	else
        	{
        		$allnum3=$allnum3+$rs_a[$i]['num'];
				if($rs_a[$i]['zengpinzhekou']!='')
					$allmoney3=$allmoney3+round($rs_a[$i]['num']*$rs_a[$i]['price']*$rs_a[$i]['zengpinzhekou'],2);
				else
        			$allmoney3=$allmoney3+round($rs_a[$i]['num']*$rs_a[$i]['price'],2);
        	}
        	if($i%2==1)
        		$class="TableLine1";
        	else
        		$class="TableLine2";
        	$jine=round($rs_a[$i]['price']*$rs_a[$i]['zhekou'],2)*$rs_a[$i]['num'];
    
        	
?>
            <tr class=<?php echo $class?>>
            	
            	<?php 
            	if($tablename=="buyplanmain_detail") 
            	{	
            		echo "<td align=center >";
            		if($rs_a[$i]['opertype']==1) echo "<font color=green>��</font>";
            		else if($rs_a[$i]['opertype']==-1) echo "<font color=red>��</font>";
            		else if($rs_a[$i]['opertype']==0) echo "<font color=blue>��</font>";
            		echo "</td>";
            	}
            	else if($tablename=="sellplanmain_detail_tmp" || $tablename=="sellplanmain_detail") 
            	{
            		echo "<td align=center >";
            		if($rs_a[$i]['opertype']==1) echo "<font color=green>��</font>";
            		else if($rs_a[$i]['opertype']==-1) echo "<font color=red>��</font>";
            		else if($rs_a[$i]['opertype']==0) echo "<font color=blue>��</font>";
            		echo "</td>";
            	}
            	else if($tablename=="storecheck_detail") 
            	{
            		echo "<td align=center >";
            		if($rs_a[$i]['opertype']==1) echo "<font color=green>ӯ</font>";
            		else if($rs_a[$i]['opertype']==-1) echo "<font color=red>��</font>";
            		echo "</td>";
            	}
            	?>
            	<td align=center nowrap>
            	<a href="../product_newai.php?<?php echo base64_encode("action=view_default&productid=".$rs_a[$i]['prodid'])?>" target="_blank"><?php echo $rs_a[$i]['prodid']?></a>
				<?php 
				if($rs_a[$i]['fileaddress']!=null)
					echo "<a class='popBigImage' href='".$rs_a[$i]['fileaddress']."'><img  src='".$rs_a[$i]['fileaddress']."' width=32></a>";
				?>
				</td>
                <td align=center nowrap><?php echo $rs_a[$i]['prodname']; if($rs_a[$i]['iftiaohuan']=='��') echo "<span title='��֧�ֵ���'>��</span>"; ?></td>
                <td align="center" nowrap><?php echo $rs_a[$i]['prodguige']?></td>
                <td align="center" nowrap><?php echo $rs_a[$i]['prodxinghao']?></td>
                <td align="center" nowrap><?php echo $rs_a[$i]['proddanwei']?></td>
             
                <td align="center" nowrap><input  
                <?php if($tablename=="buyplanmain_detail") 
                     	echo "title='Ĭ���ϴμ۸�'";
                     if($priceReadonly) 
                     	echo "readonly class=SmallStatic";else echo "class=SmallInput"?> style="width:60px" id="price_<?php echo $rs_a[$i]['id']?>" onkeydown="focusNext(event)" onKeyPress="return inputFloat(event)" value="<?php echo $rs_a[$i]['price']?>" onchange="updatePrice(<?php echo $rs_a[$i]['id']?>,this.value)"></td>
         		<?php 
         		$disablezheku=false;//�������Ʒ���������༭�ۿ�
         		if($rs_a[$i]['opertype']==0)
         			$disablezheku=true;
         		?>
                <td align="center" nowrap>
                <input <?php if($zhekouReadonly || $disablezheku) echo "readonly class=SmallStatic";else echo "class=SmallInput"?>  style="width:60px" id="zhekou_<?php echo $rs_a[$i]['id']?>" onkeydown="focusNext(event)" onKeyPress="return inputFloat(event)" value="<?php echo $rs_a[$i]['zhekou']*100?>" onchange="updateZhekou(<?php echo $rs_a[$i]['id']?>,this.value)">%</td>
           	    <td align="center" nowrap>
				<?php 
           	    $colorset='';
           	    $readonly="class='SmallInput'";
           	    
           	    if($tablename!="customerproduct_detail" && $tablename!="buyplanmain_detail")
    			{
	           	    $hascolor=returntablefield("product","productid", $rs_a[$i]['prodid'], "hascolor");
	                if($hascolor=='��')
	                {
	                	$colortable='';
	                	$colortable=$tablename."_color";
	                	$sql="select sum(num) as allnum from $colortable where id=".$rs_a[$i]['id'];
	                	$rs=$db->Execute($sql);
						$rs_c = $rs->GetArray();
						$readonly="class='SmallStatic' readonly";
						
						if($rs_c[0]['allnum']==floatval($rs_a[$i]['num'])-floatval($rs_a[$i]['recnum']))
							$colorset= "<a href='javascript:PopColorInput(".$rs_a[$i]['id'].",\"$colortable\");' title='������ɫ����'><img id='img_".$rs_a[$i]['id']."' src=$imgurl></a>";
						else
	                		$colorset= "<a href='javascript:PopColorInput(".$rs_a[$i]['id'].",\"$colortable\");' title='��δ������ɫ����'><img id='img_".$rs_a[$i]['id']."' src=$imgurlgray></a>";
	                }
    			}
                ?>
                <input <?php echo $readonly?> style="width:60px" id="num_<?php echo $rs_a[$i]['id']?>" onkeydown="focusNext(event)" onKeyPress="return <?php if($_SESSION['numzero']==0)print "inputInteger(event)";else print "inputFloat(event)";?>" value="<?php echo $rs_a[$i]['num']?>" onchange="updateAmount(<?php echo $rs_a[$i]['id']?>,this.value)"><?php echo $colorset?></td>
                <?php 
          
                $sql = "select sum(num) as allnum,sum(num*price) as allmoney from store where prodid='".$rs_a[$i]['prodid']."'";
                if($storeid!="")
                	$sql.=" and storeid=".$storeid;
                $rs = $db->Execute($sql);
				//print $sql."<br>";
                $rs_kucun = $rs->GetArray();
                $color="green";	
                if($rs_a[$i]['num']>$rs_kucun[0]['allnum'])
                	$color="red";
                $warning="";
                if($rs_kucun[0]['allnum']!=0 && !$disablezheku)
                {
	                $chae=round($rs_kucun[0]['allmoney']/$rs_kucun[0]['allnum']-$rs_a[$i]['price']*$rs_a[$i]['zhekou'],2);
	                if($tablename=="sellplanmain_detail_tmp" || $tablename=="sellplanmain_detail")
	                {
	                	
	                	if($rs_kucun[0]['allnum']>0 && $chae>0)
	                		$warning="<img src='../../../Framework/images/warning.gif' title='�ۺ�۱ȳɱ��۵�$chaeԪ'>";
	                }
	                if($tablename=="buyplanmain_detail")
	                {
	                	if($rs_kucun[0]['allnum']>0 && $chae<0)
	                		$warning="<img src='../../../Framework/images/warning.gif' title='�ۺ�۱ȳɱ��۸�".-$chae."Ԫ'>";
	                }
                }
                ?>
                <td align="center" nowrap><font  color=<?php echo $color?>><?php echo $rs_kucun[0]['allnum']?></font></td>
                <td align="center" nowrap><span id="warning_<?php echo $rs_a[$i]['id']?>"><?php echo $warning?></span><input <?php if(($priceReadonly && $zhekouReadonly) || $disablezheku) echo "readonly class=SmallStatic";else echo "class=SmallInput"?> style="width:60px" id="jine_<?php echo $rs_a[$i]['id']?>" onkeydown="focusNext(event)" onKeyPress="return inputFloat(event)" value="<?php echo $jine?>" onchange="updateMoney(<?php echo $rs_a[$i]['id']?>,this.value)"> Ԫ</td>
                <td align="center" nowrap><input class="SmallInput" size=12 id="beizhu_<?php echo $rs_a[$i]['id']?>" value="<?php echo $rs_a[$i]['beizhu']?>" onchange="updateMemo(<?php echo $rs_a[$i]['id']?>,this.value)"></td>
                <td align="center" nowrap><input type="button"  onclick="delProduct('<?php echo $rs_a[$i]['id']?>')" value="ɾ��"></td>
            </tr>
            <?php 
        }
     
        ?>
        <tr class=TableHeader >
        
        <?php 
        if($tablename=="buyplanmain_detail" || $tablename=="sellplanmain_detail_tmp" || $tablename=="sellplanmain_detail" || $tablename=="storecheck_detail")
		echo "<td class=TableHeader></td>";?>
             <td align=center>�ܼ�</td>
             <td colspan=5>�����ʾ���ɵ���<?php if($tablename=="sellplanmain_detail_tmp" || $tablename=="sellplanmain_detail") echo "������Ϊ����ʾ�˻����ۿ�Ϊ0��ʾ��Ʒ";?>��</td>
             <td align="center"><input <?php if($zhekouReadonly || $disablezheku) echo "readonly class=SmallStatic";else echo "class=SmallInput"?>  style="width:60px" id="zhekou_all" onKeyPress="return inputFloat(event)" value="" onchange="updateZhekouAll(<?php echo $rowid?>,this.value)">%</td>
             <td align="center"><div id="allamount" style="font-size:24px"><?php echo $allnum?></div></td><td></td>
             <td align="center"><div id="allmoney" style="font-size:24px"><?php echo number_format($allmoney,2)?></div></td>
             <td></td><td></td>
        <?php
    	if($tablename=="sellplanmain_detail_tmp" || $tablename=="sellplanmain_detail")
       {
       		
       	echo "<tr><td colspan=13>��������<span id='sellnum' style='font-size:24px'>".$allnum1."</span>
        	 �˻�����<span id='backnum' style='font-size:24px'>".-$allnum2."</span>
        	 ��Ʒ����<span id='zengnum' style='font-size:24px'>".$allnum3."</span>";
        	
        	echo " ���۽�<b><span id='sellmoney'>".$allmoney1."</span></b>
        	�˻���<b><span id='backmoney'>".-$allmoney2."</span></b>";
			
        	if(intval($_GET['tuihuorate'])>=0)
        	{
        		$tuihuorate=intval($_GET['tuihuorate']);
        		$tuihuolim=round($allmoney1*$tuihuorate/100,2);
        		echo " �˻����ƣ�<b><span id='tuihuolim'>".$tuihuolim."</span></b>";
        	    echo " <font color=red><span id='tuihuowarn'>";
        		if(abs($allmoney2)>$tuihuolim)
        			echo "�˻�����".-($allmoney2+$tuihuolim)."Ԫ";
        		echo "</span></font>";
        	}
        	echo " ��Ʒ��<b><span id='zengmoney'>".$allmoney3."</span></b></td></tr>";
       }
    } else {
        ?>
        <tr>
            <td colspan="11" style="height:50px" align="center">����û��ѡ���κβ�Ʒ</td>
        </tr>
        <?php
    }
?>

</table>
</form>