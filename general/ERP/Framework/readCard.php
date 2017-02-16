<?php 
	ini_set('display_errors',1);
	ini_set('error_reporting',E_ALL);
	error_reporting(E_WARNING | E_ERROR);
	require_once("lib.inc.php");
	$action = $_REQUEST["action"];  
   
	header('Content-Type:text/xml;charset=GBK'); 
	$doc=new DOMDocument("1.0","GBK"); #声明文档类型
	$doc->formatOutput=true;               #设置可以输出操作
	#声明根节点，最好一个XML文件有个跟节点
	$root=$doc->createElement("root");    #创建节点对象实体 
	$root=$doc->appendChild($root);      #把节点添加进来
	if($action=='post')
	{
		
		try {
			$name=$_POST['name'];
			$idcard=$_POST['idcard'];
			$sex=$_POST['sex'];
			$minzu=$_POST['minzu'];
			$birthday=$_POST['birthday'];
			$address=$_POST['address'];
			$qianfa=$_POST['qianfa'];
			$xiaoqi=$_POST['xiaoqi'];
			$newaddress=$_POST['newaddress'];
			$deviceid=$_POST['deviceid'];
			$birthday=str_replace("年","-", $birthday);
			$birthday=str_replace("月","-", $birthday);
			$birthday=str_replace("日","", $birthday);
			$sql="select count(*) as allcount from baodao where idcard='$idcard'";
			$rs=$db->Execute($sql);
			$rs_a=$rs->getArray();
			if(intval($rs_a[0]['allcount'])>0)
				throw new Exception("此身份证已报到过");
			$sql="insert baodao (idcard,name,sex,minzu,birthday,address,qianfa,xiaoqi,newaddress,createtime,deviceid) values
			('$idcard','$name','$sex','$minzu','$birthday','$address','$qianfa','$xiaoqi','$newaddress',now(),'$deviceid')";
			$db->Execute($sql);
			$action='test';
		}
		catch (Exception $e)
		{
			$result=$doc->createElement("result"); 
        	$result=$root->appendChild($result);
        	$result->appendChild($doc->createTextNode(iconv("GBK","UTF-8",$e->getMessage())));
		}	
		
	}
	
	if($action=='test')
	{
		$dt=date("Y-m-d");
		$sql="select count(*) as allcount from baodao where createtime>'$dt'";
		$rs=$db->Execute($sql);
		$rs_a=$rs->getArray();
		$todayTotal=intval($rs_a[0]['allcount']);
		$dt=date("Y-1-1");
		$sql="select count(*) as allcount from baodao where createtime>'$dt'";
		$rs=$db->Execute($sql);
		$rs_a=$rs->getArray();
		$yearTotal=intval($rs_a[0]['allcount']);
		$result=$doc->createElement("result"); 
        $result=$root->appendChild($result);
        $result->appendChild($doc->createTextNode("ok"));		
        $todayNode=$doc->createElement("todayNode"); 
        $todayNode=$root->appendChild($todayNode);
        $todayNode->appendChild($doc->createTextNode($todayTotal));
        $yearNode=$doc->createElement("yearNode"); 
        $yearNode=$root->appendChild($yearNode);
        $yearNode->appendChild($doc->createTextNode($yearTotal));
	}
	
	if($action=='uploadbmp')
	{
		try {
		$name = $_GET['varname'];
		$type = $_FILES['filename']['type'];
		$tmp_name = $_FILES['filename']['tmp_name'];
		$error = $_FILES['filename']['error'];

		$dirpath = "photos";
		is_dir( $dirpath ) ? "" : mkdir( $dirpath );
		$filepath = $dirpath."/".$name;
		copy( $tmp_name, $filepath );
		$result=$doc->createElement("result"); 
        $result=$root->appendChild($result);
        $result->appendChild($doc->createTextNode("ok"));
		}
		catch (Exception $e)
		{
			$result=$doc->createElement("result"); 
        	$result=$root->appendChild($result);
        	$result->appendChild($doc->createTextNode(iconv("GBK","UTF-8",$e->getMessage())));
		}
	}
   
    echo $doc->saveXML();
        
?>
