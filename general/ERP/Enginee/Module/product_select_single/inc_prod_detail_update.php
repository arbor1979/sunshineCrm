<?php 
	ini_set('display_errors',1);
	ini_set('error_reporting',E_ALL);
	error_reporting(E_WARNING | E_ERROR);
	require_once('../../../adodb/adodb.inc.php');
require_once('../../../config.inc.php');
require_once('../../../setting.inc.php');
require_once('../../../adodb/session/adodb-session2.php');
header('Content-Type:text/xml;charset=GB2312'); 
	$GLOBAL_SESSION=returnsession();
    $action = $_GET["action"];     //��ȡ����
    if ($action=="search") {
    	$keyword=$_GET["keyword"];
        SearchProduct($keyword);                           //������Ʒ
    }
    function SearchProduct($keyword)
    {
    	global $db;
    	$sql = "select * from product where (productname like '%$keyword%' or mode like '%$keyword%' or standard like '%$keyword%' or productcn like '%$keyword%')";
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
        		print ($i+1)."��<a href=\"javascript:addProduct('$productId','$productName');\">$productName</a><br>";
        	}
    	}
    	else 
    		print "<font color=red>û�з��������Ĳ�Ʒ</font><a href='#'></a>";
    	exit;
    }
    
?>

