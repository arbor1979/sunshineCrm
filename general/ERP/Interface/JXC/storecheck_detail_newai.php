<?php
	ini_set('display_errors', 1);
	ini_set('error_reporting', E_ALL);
	error_reporting(E_WARNING | E_ERROR);
	require_once('lib.inc.php');
	$GLOBAL_SESSION=returnsession();
	
	/*
	if($_GET['action']=="add_default_data")		{
		//print_R($_GET);print_R($_POST);//exit;
		global $db;
		$������� = (int)$_POST['�������'];$�̲ı�� = $_POST['�̲ı��'];
		$sql = "update edu_jiaocai set ���п��=���п��+$������� where �̲ı��='".$�̲ı��."'";
		$rs = $db->Execute($sql);//print $sql;exit;
		$_POST['������'] = returntablefield("edu_jiaocai","�̲ı��",$�̲ı��,"������");
		$_POST['������'] = returntablefield("edu_jiaocai","�̲ı��",$�̲ı��,"������");
		//print  "<META HTTP-EQUIV=REFRESH CONTENT='0;URL=?'>";
	}
	*/
	function recallfunc($db)
	{
	    $storeid=returntablefield("storecheck","billid",$_GET['foreignvalue'],"storeid");
	    $sql="select * from storecheck_detail where mainrowid='".$_GET['foreignvalue']."'";
	    $rs=$db->Execute($sql);
	    $rs_a=$rs->GetArray();
	    for($i=0;$i<sizeof($rs_a);$i++)
	    {
	        $prodid=$rs_a[$i]['prodid'];
	        if($rs_a[$i]['num']==0)
	        {
	            $sql="delete from storecheck_detail where id='".$rs_a[$i]['id']."'";
	            $db->Execute($sql);
	            continue;
	        }
	        $prodinfo=returntablefield("product", "productid", $prodid, "productname,measureid,mode,standard,sellprice,oldproductid");
	        $avgprice=returntablefield("store", "prodid", $prodid, "price");
	        if($prodinfo['sellprice']>0)
	           $zhekou=round($avgprice/$prodinfo['sellprice'],4);
	        $opertype=1;
	        if($rs_a[$i]['num']<0)
	            $opertype=-1;
	        $sql="update storecheck_detail set prodname='".$prodinfo['productname']."',prodguige='".$prodinfo['standard'].
	        "',prodxinghao='".$prodinfo['mode']."',proddanwei='".$prodinfo['measureid']."',price=".$prodinfo['sellprice'].
	        ",zhekou=$zhekou,jine=round($avgprice*num,2),oldprodid='".$prodinfo['oldproductid']."',opertype=$opertype,orderid=$i,inputtime=now() where id='".$rs_a[$i]['id']."'";
	        $db->Execute($sql);
	    }
	       
	        echo "�������ݳɹ�";
	        exit;
	    
	}
	
	//���ݱ�ģ���ļ�,��ӦModelĿ¼�����storecheck_detail_newai.ini�ļ�
	//�������Ҫ���ƴ�ģ��,����Ҫ�޸�$parse_filename������ֵ,Ȼ���Ӧ��ModelĿ¼ ���ļ���_newai.ini�ļ�
	$filetablename		=	'storecheck_detail';
	$parse_filename		=	'storecheck_detail';
	require_once('include.inc.php');
	
	
	?>