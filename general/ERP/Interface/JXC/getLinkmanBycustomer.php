<?php 
	ini_set('display_errors',1);
	ini_set('error_reporting',E_ALL);
	error_reporting(E_WARNING | E_ERROR);
	require_once("lib.inc.php");
	$GLOBAL_SESSION=returnsession();
	$action = $_GET["action"];  
    $customerid = $_GET["customerid"];    
    
   
	header('Content-Type:text/xml;charset=GBK'); 
	$doc=new DOMDocument("1.0","GBK"); #�����ĵ�����
	$doc->formatOutput=true;               #���ÿ����������
	#�������ڵ㣬���һ��XML�ļ��и����ڵ�
	$root=$doc->createElement("root");    #�����ڵ����ʵ�� 
	$root=$doc->appendChild($root);      #�ѽڵ���ӽ���
	if($action=='fukuan' || $action=='shoupiao' || $action=='supply')
		$chuzhi=returntablefield("supply", "rowid", $customerid, "yufukuan");
	else
	{
		if($customerid!="")
		{	
			$custInfo=returntablefield("customer", "rowid", $customerid, "yuchuzhi,membercard");
			$chuzhi=$custInfo['yuchuzhi'];
			$membercard=$custInfo['membercard'];
			$membercardnode=$doc->createElement("membercard"); 
			$membercardnode=$root->appendChild($membercardnode);
			$membercardnode->appendChild($doc->createTextNode($membercard));
			
			$sql="select count(*) as ownnum,sum(totalmoney-oddment-huikuanjine) as ownmoney from sellplanmain where supplyid=".$customerid." and ifpay<2 and user_flag>0 and fahuostate=-1";
			$rs=$db->Execute($sql);
			$rs_b=$rs->GetArray();
			$ownnum=intval($rs_b[0]['ownnum']);
			$ownmoney=round($rs_b[0]['ownmoney'],2);
			if($ownnum>0)
			{
				$ownnumnode=$doc->createElement("ownnum"); 
				$ownnumnode=$root->appendChild($ownnumnode);
				$ownnumnode->appendChild($doc->createTextNode($ownnum));
				$ownmoneynode=$doc->createElement("ownmoney"); 
				$ownmoneynode=$root->appendChild($ownmoneynode);
				$ownmoneynode->appendChild($doc->createTextNode($ownmoney));
			}
		}
	}
	$chuzhinode=$doc->createElement("chuzhi"); 
	$chuzhinode=$root->appendChild($chuzhinode);
	$chuzhinode->appendChild($doc->createTextNode($chuzhi));
    
    global $db;
    
    if($action=="customer")
    {
    	$membercard = $_GET["membercard"];   
    	$sql = "select * from customer where membercard='$membercard'";
    	$sql =getCustomerRoleByCustID($sql,"ROWID");
    	$rs = $db->Execute($sql);
		$rs_a = $rs->GetArray();
		$ROWIDNode=$doc->createElement("ROWID"); 
        $ROWIDNode=$root->appendChild($ROWIDNode);
        $ROWIDNode->appendChild($doc->createTextNode($rs_a[0]['ROWID']));		
        $supplynameNode=$doc->createElement("supplyname"); 
        $supplynameNode=$root->appendChild($supplynameNode);
        $supplynameNode->appendChild($doc->createTextNode(iconv("GBK","UTF-8",$rs_a[0]['supplyname'])));	 
		      
    }
    
    if(stripos($action,"linkman")!==false)
    {
    	$sql = "select * from linkman where customerid='$customerid'";
    	$sql =getCustomerRoleByCustID($sql,"customerid");
		$rs = $db->Execute($sql);
		$rs_a = $rs->GetArray();
    	if (count($rs_a) != 0) 
    	{
        	for($i=0;$i<count($rs_a);$i++)
        	{
				$linkman=$doc->createElement("linkman"); 
        		$linkman=$root->appendChild($linkman);
        		 
		        $rowid=$doc->createElement("ROWID");
        		$rowid=$linkman->appendChild($rowid);    

        		$name=$doc->createElement("linkmanname");
        		$name=$linkman->appendChild($name); 
        		
        		$mobile=$doc->createElement("mobile"); 
        		$mobile=$linkman->appendChild($mobile); 
        
        		$address=$doc->createElement("address"); 
        		$address=$linkman->appendChild($address); 
        		
				$birthday=$doc->createElement("birthday"); 
        		$birthday=$linkman->appendChild($birthday); 

        		$rowid->appendChild($doc->createTextNode($rs_a[$i]['ROWID']));
        		$name->appendChild($doc->createTextNode(iconv("GBK","UTF-8",$rs_a[$i]['linkmanname'])));#ע��Ҫת��������ģ���ΪXMLĬ��ΪUTF-8��ʽ
        		$mobile->appendChild($doc->createTextNode($rs_a[$i]['mobile'])); 
        		$addressvalue=$rs_a[$i]['address'];
        		if(trim($addressvalue)=='')
        		{
        			$addressvalue=returntablefield("customer", "rowid", $rs_a[$i]['customerid'], "contactaddress");
        		}
        		$address->appendChild($doc->createTextNode(iconv("GBK","UTF-8",$addressvalue)));
				if($rs_a[$i]['birthday']!='' && substr($rs_a[$i]['birthday'],5)==date("m-d"))
					$rs_a[$i]['birthday'].=iconv("GBK","UTF-8",' �������գ�');
        		$birthday->appendChild($doc->createTextNode($rs_a[$i]['birthday'])); 
        	}
    	}
    }
    
    if(stripos($action,"chance")!==false)
    {
    	//��Ӧ����
    	$sql = "select * from crm_chance where �ͻ�����='$customerid' and ״̬='1'";
		$rs = $db->Execute($sql);
		$rs_a = $rs->GetArray();
		
		if (count($rs_a) != 0) 
    	{
    		
        	for($i=0;$i<count($rs_a);$i++)
        	{
        		
				$chance=$doc->createElement("chance"); 
        		$chance=$root->appendChild($chance);
        		 
		        $rowid=$doc->createElement("id");
        		$rowid=$chance->appendChild($rowid);    

        		$zhuti=$doc->createElement("zhuti");
        		$zhuti=$chance->appendChild($zhuti); 
        		
        		$rowid->appendChild($doc->createTextNode($rs_a[$i]['���']));
        		$zhuti->appendChild($doc->createTextNode(iconv("GBK","UTF-8",$rs_a[$i]['��������'])));#ע��Ҫת��������ģ���ΪXMLĬ��ΪUTF-8��ʽ
        		
        	}
    	}
    }
    if(stripos($action,"supply")!==false)
    {
    	
    	//��Ӧ����ϵ��
    	$sql = "select * from supplylinkman where supplyid='$customerid'";
    	
		$rs = $db->Execute($sql);
		$rs_a = $rs->GetArray();
		
		if (count($rs_a) != 0) 
    	{
    		
        	for($i=0;$i<count($rs_a);$i++)
        	{
        		
				$chance=$doc->createElement("supply"); 
        		$chance=$root->appendChild($chance);
        		 
		        $rowid=$doc->createElement("rowid");
        		$rowid=$chance->appendChild($rowid);    

        		$zhuti=$doc->createElement("supplyname");
        		$zhuti=$chance->appendChild($zhuti); 
        		
        		$rowid->appendChild($doc->createTextNode($rs_a[$i]['ROWID']));
        		$zhuti->appendChild($doc->createTextNode(iconv("GBK","UTF-8",$rs_a[$i]['supplyname'])));#ע��Ҫת��������ģ���ΪXMLĬ��ΪUTF-8��ʽ
        		
        	}
    	}
    }
    if(stripos($action,"kaipiao")!==false)
    {
    	//��������
    	$sql = "select * from sellplanmain where supplyid='$customerid' and (kaipiaojine<>totalmoney) and (kaipiaostate>-1)";
		//print $sql;
    	$rs = $db->Execute($sql);
		$rs_a = $rs->GetArray();
		if (count($rs_a) != 0) 
    	{
        	for($i=0;$i<count($rs_a);$i++)
        	{
				$chance=$doc->createElement("sellbuy"); 
        		$chance=$root->appendChild($chance);
        		 
		        $rowid=$doc->createElement("rowid");
        		$rowid=$chance->appendChild($rowid);    

        		$zhuti=$doc->createElement("zhuti");
        		$zhuti=$chance->appendChild($zhuti); 
        		
        		$rowid->appendChild($doc->createTextNode($rs_a[$i]['billid']));
        		$zhuti->appendChild($doc->createTextNode(iconv("GBK","UTF-8",$rs_a[$i]['zhuti'])));#ע��Ҫת��������ģ���ΪXMLĬ��ΪUTF-8��ʽ

        	}
    	}
    }
    
    if(stripos($action,"huikuan")!==false)
    {
    	
    	//��������
    	$sql = "select * from sellplanmain where supplyid='$customerid' and user_flag>'-1' and  (ifpay!='2')";
		$rs = $db->Execute($sql);
		$rs_a = $rs->GetArray();
		if (count($rs_a) != 0) 
    	{
        	for($i=0;$i<count($rs_a);$i++)
        	{
				$chance=$doc->createElement("sellbuy"); 
        		$chance=$root->appendChild($chance);
        		 
		        $rowid=$doc->createElement("rowid");
        		$rowid=$chance->appendChild($rowid);    

        		$zhuti=$doc->createElement("zhuti");
        		$zhuti=$chance->appendChild($zhuti); 
        		
        		$rowid->appendChild($doc->createTextNode($rs_a[$i]['billid']));
        		$zhuti->appendChild($doc->createTextNode(iconv("GBK","UTF-8",$rs_a[$i]['zhuti'])));#ע��Ҫת��������ģ���ΪXMLĬ��ΪUTF-8��ʽ

        	}
    	}
    }
    if(stripos($action,"fukuan")!==false)
    {
    	
    	//��������
    	$sql = "select * from buyplanmain where supplyid='$customerid' and user_flag>'-1' and (paymoney+oddment<>totalmoney)";
		$rs = $db->Execute($sql);
		$rs_a = $rs->GetArray();
		if (count($rs_a) != 0) 
    	{
        	for($i=0;$i<count($rs_a);$i++)
        	{
				$chance=$doc->createElement("sellbuy"); 
        		$chance=$root->appendChild($chance);
        		 
		        $rowid=$doc->createElement("rowid");
        		$rowid=$chance->appendChild($rowid);    

        		$zhuti=$doc->createElement("zhuti");
        		$zhuti=$chance->appendChild($zhuti); 
        		
        		$rowid->appendChild($doc->createTextNode($rs_a[$i]['billid']));
        		$zhuti->appendChild($doc->createTextNode(iconv("GBK","UTF-8",$rs_a[$i]['zhuti'])));#ע��Ҫת��������ģ���ΪXMLĬ��ΪUTF-8��ʽ

        	}
    	}
    }
    if(stripos($action,"shoupiao")!==false)
    {
    	//�����ɹ���
    	$sql = "select * from buyplanmain where supplyid='$customerid' and user_flag>'-1' and (shoupiaomoney<>totalmoney)";
		//print $sql;
    	$rs = $db->Execute($sql);
		$rs_a = $rs->GetArray();
		if (count($rs_a) != 0) 
    	{
        	for($i=0;$i<count($rs_a);$i++)
        	{
				$chance=$doc->createElement("sellbuy"); 
        		$chance=$root->appendChild($chance);
        		 
		        $rowid=$doc->createElement("rowid");
        		$rowid=$chance->appendChild($rowid);    

        		$zhuti=$doc->createElement("zhuti");
        		$zhuti=$chance->appendChild($zhuti); 
        		
        		$rowid->appendChild($doc->createTextNode($rs_a[$i]['billid']));
        		$zhuti->appendChild($doc->createTextNode(iconv("GBK","UTF-8",$rs_a[$i]['zhuti'])));#ע��Ҫת��������ģ���ΪXMLĬ��ΪUTF-8��ʽ

        	}
    	}
    }
    if(stripos($action,"hetong")!==false)
    {
    	//������ͬ
    	$sql = "select * from sellplanmain where billtype=1 and user_flag>'-1' and fahuostate<4 and supplyid='$customerid'";
		$rs = $db->Execute($sql);
		$rs_a = $rs->GetArray();
		if (count($rs_a) != 0) 
    	{
        	for($i=0;$i<count($rs_a);$i++)
        	{
				$chance=$doc->createElement("hetong"); 
        		$chance=$root->appendChild($chance);
        		 
		        $rowid=$doc->createElement("rowid");
        		$rowid=$chance->appendChild($rowid);    

        		$zhuti=$doc->createElement("zhuti");
        		$zhuti=$chance->appendChild($zhuti); 
        		
        		$rowid->appendChild($doc->createTextNode($rs_a[$i]['billid']));
        		$zhuti->appendChild($doc->createTextNode(iconv("GBK","UTF-8",$rs_a[$i]['zhuti'])));#ע��Ҫת��������ģ���ΪXMLĬ��ΪUTF-8��ʽ

        	}
    	}
    }
    if(stripos($action,"dingdan")!==false)
    {
    	//��������
    	$sql = "select * from sellplanmain where billtype=2 and user_flag>'-1' and fahuojine<>totalmoney and supplyid='$customerid'";
		$rs = $db->Execute($sql);
		$rs_a = $rs->GetArray();
		if (count($rs_a) != 0) 
    	{
        	for($i=0;$i<count($rs_a);$i++)
        	{
				$chance=$doc->createElement("dingdan"); 
        		$chance=$root->appendChild($chance);
        		 
		        $rowid=$doc->createElement("rowid");
        		$rowid=$chance->appendChild($rowid);    

        		$zhuti=$doc->createElement("zhuti");
        		$zhuti=$chance->appendChild($zhuti); 
        		
        		$rowid->appendChild($doc->createTextNode($rs_a[$i]['billid']));
        		$zhuti->appendChild($doc->createTextNode(iconv("GBK","UTF-8",$rs_a[$i]['zhuti'])));#ע��Ҫת��������ģ���ΪXMLĬ��ΪUTF-8��ʽ

        	}
    	}
    }
    if(stripos($action,"xiaoshoudan")!==false)
    {
    	//�������۵�
    	$sql = "select * from sellplanmain where user_flag>'-1' and supplyid='$customerid' order by createtime desc limit 0,10";
		$rs = $db->Execute($sql);
		$rs_a = $rs->GetArray();
		if (count($rs_a) != 0) 
    	{
        	for($i=0;$i<count($rs_a);$i++)
        	{
				$chance=$doc->createElement("xiaoshoudan"); 
        		$chance=$root->appendChild($chance);
        		 
		        $rowid=$doc->createElement("billid");
        		$rowid=$chance->appendChild($rowid);    

        		$zhuti=$doc->createElement("zhuti");
        		$zhuti=$chance->appendChild($zhuti); 
        		
        		$rowid->appendChild($doc->createTextNode($rs_a[$i]['billid']));
        		$zhuti->appendChild($doc->createTextNode(iconv("GBK","UTF-8",$rs_a[$i]['zhuti'])));#ע��Ҫת��������ģ���ΪXMLĬ��ΪUTF-8��ʽ

        	}
    	}
    }
    if(stripos($action,"billinfo")!==false)
    {
    	$billid = $_GET["billid"];  
    	$billinfo=returntablefield("sellplanmain", "billid", $billid, "totalmoney,huikuanjine,kaipiaojine,oddment");
    	
    	
    	
    	$billnode=$doc->createElement("billinfo"); 
        $billnode=$root->appendChild($billnode);
    	
        $totalmoneynode=$doc->createElement("totalmoney"); 
        $totalmoneynode=$billnode->appendChild($totalmoneynode);
        $huikuanjinenode=$doc->createElement("huikuanjine"); 
        $huikuanjinenode=$billnode->appendChild($huikuanjinenode);
        $kaipiaojinenode=$doc->createElement("kaipiaojine"); 
        $kaipiaojinenode=$billnode->appendChild($kaipiaojinenode);
        $qulingnode=$doc->createElement("quling"); 
        $qulingnode=$billnode->appendChild($qulingnode);
		
		$totalmoneynode->appendChild($doc->createTextNode(number_format($billinfo['totalmoney'],2)));
		$huikuanjinenode->appendChild($doc->createTextNode(number_format($billinfo['huikuanjine'],2)));
		$kaipiaojinenode->appendChild($doc->createTextNode(number_format($billinfo['kaipiaojine'],2)));
		$qulingnode->appendChild($doc->createTextNode(number_format($billinfo['oddment'],2)));
		
    }
    if(stripos($action,"caigouinfo")!==false)
    {
    	$billid = $_GET["billid"];  
    	$billinfo=returntablefield("buyplanmain", "billid", $billid, "totalmoney,paymoney,shoupiaomoney,oddment");
    	
    	
    	
    	$billnode=$doc->createElement("caigouinfo"); 
        $billnode=$root->appendChild($billnode);
    	
        $totalmoneynode=$doc->createElement("totalmoney"); 
        $totalmoneynode=$billnode->appendChild($totalmoneynode);
        $huikuanjinenode=$doc->createElement("paymoney"); 
        $huikuanjinenode=$billnode->appendChild($huikuanjinenode);
        $kaipiaojinenode=$doc->createElement("shoupiaomoney"); 
        $kaipiaojinenode=$billnode->appendChild($kaipiaojinenode);
        $qulingnode=$doc->createElement("oddment"); 
        $qulingnode=$billnode->appendChild($qulingnode);
		
		$totalmoneynode->appendChild($doc->createTextNode(number_format($billinfo['totalmoney'],2)));
		$huikuanjinenode->appendChild($doc->createTextNode(number_format($billinfo['paymoney'],2)));
		$kaipiaojinenode->appendChild($doc->createTextNode(number_format($billinfo['shoupiaomoney'],2)));
		$qulingnode->appendChild($doc->createTextNode(number_format($billinfo['oddment'],2)));
		
    }
    if(stripos($action,"callchuli")!==false)
    {
    	$mobile = $_GET["mobile"];  
    	$calltype='����';
    	$callid='';
    	$callmanid='';
    	$rowid=returntablefield("linkman", "mobile", $mobile, "rowid");
    	if($rowid=='')
    		$rowid=returntablefield("linkman", "phone", $mobile, "rowid");
    	if($rowid=='')
    		$customerid=returntablefield("customer", "phone", $mobile, "rowid");
    	else 
    	{
    		$linkmanname=returntablefield("linkman", "rowid", $rowid, "linkmanname");
    		$customerid=returntablefield("linkman", "rowid", $rowid, "customerid");
    		$customername=returntablefield("customer", "rowid", $customerid, "supplyname");
    		$calltype='�ͻ�';
    		$callid=$customerid;
    		$callmanid=$rowid;
    	}
    	if($customerid=='')
    		$supplylinkmanid=returntablefield("supplylinkman", "phone", $mobile, "rowid");
    	else 
    	{
    		$customername=returntablefield("customer", "rowid", $customerid, "supplyname");
    		$calltype='�ͻ�';
    		$callid=$customerid;
    	}
    	if($supplylinkmanid=='')
    		$supplyid=returntablefield("supply", "phone", $mobile, "rowid");
    	else
    	{
    		$linkmanname=returntablefield("supplylinkman", "rowid", $supplylinkmanid, "supplyname");
    		$customerid=returntablefield("supplylinkman", "rowid", $supplylinkmanid, "supplyid");
    		$customername=returntablefield("supply", "rowid", $customerid, "supplyname");
    		$calltype='��Ӧ��';
    		$callid=$customerid;
    		$callmanid=$supplylinkmanid;
    	}
    	if($supplyid!='')
    	{
    		$customername=returntablefield("supply", "rowid", $supplyid, "supplyname");
    		$calltype='��Ӧ��';
    		$callid=$supplyid;
    	}
    	$billnode=$doc->createElement("callchuli"); 
        $billnode=$root->appendChild($billnode);
    	
        $customernamenode=$doc->createElement("customername"); 
        $customernamenode=$billnode->appendChild($customernamenode);
        $linkmannamenode=$doc->createElement("linkmanname"); 
        $linkmannamenode=$billnode->appendChild($linkmannamenode);
        $calltypenode=$doc->createElement("calltype"); 
        $calltypenode=$billnode->appendChild($calltypenode);
        $callidnode=$doc->createElement("callid"); 
        $callidnode=$billnode->appendChild($callidnode);
		$callmanidnode=$doc->createElement("callmanid"); 
        $callmanidnode=$billnode->appendChild($callmanidnode);
        
		$customernamenode->appendChild($doc->createTextNode(iconv("GBK","UTF-8",$customername)));
		$linkmannamenode->appendChild($doc->createTextNode(iconv("GBK","UTF-8",$linkmanname)));
		$calltypenode->appendChild($doc->createTextNode(iconv("GBK","UTF-8",$calltype)));
		$callidnode->appendChild($doc->createTextNode(iconv("GBK","UTF-8",$callid)));
		$callmanidnode->appendChild($doc->createTextNode(iconv("GBK","UTF-8",$callmanid)));
    }
  	if(stripos($action,"feiyongtype")!==false)
    {
    	//��������
    	$classid=$_GET['classid'];
    	$sql = "select * from feiyongtype where classid=$classid and iflock=0";
		$rs = $db->Execute($sql);
		$rs_a = $rs->GetArray();
		if (count($rs_a) != 0) 
    	{
        	for($i=0;$i<count($rs_a);$i++)
        	{
				$chance=$doc->createElement("feiyongtype"); 
        		$chance=$root->appendChild($chance);
        		 
		        $id=$doc->createElement("id");
        		$id=$chance->appendChild($id);    

        		$typename=$doc->createElement("typename");
        		$typename=$chance->appendChild($typename); 
        		
        		$id->appendChild($doc->createTextNode($rs_a[$i]['id']));
        		$typename->appendChild($doc->createTextNode(iconv("GBK","UTF-8",$rs_a[$i]['typename'])));#ע��Ҫת��������ģ���ΪXMLĬ��ΪUTF-8��ʽ

        	}
    	}
    }
    
    echo $doc->saveXML();
        
?>
