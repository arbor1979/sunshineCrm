<?php 
	ini_set('display_errors',1);
	ini_set('error_reporting',E_ALL);
	error_reporting(E_WARNING | E_ERROR);
	require_once( "../../../config.inc.php" );
	require_once( "../../../adodb/adodb.inc.php" );
	require_once( "../../../setting.inc.php" );
	require_once( "../../../adodb/session/adodb-cryptsession2.php" );
	header('Content-Type:text/html;charset=GB2312'); 
	function getProdTypeList($DEPT_PARENT)
	{
		global $db;
		$sql = "select rowid,name,parentid from producttype where parentid='$DEPT_PARENT' order by parentid asc ,id asc";
		$rs = $db->Execute($sql);
		$rs_a = $rs->GetArray();
		
		for($i=0;$i<sizeof($rs_a);$i++)			
		{
			$DEPT_ID = $rs_a[$i]['rowid'];
			$DEPT_NAME = $rs_a[$i]['name'];
			$DEPT_PARENT = $rs_a[$i]['parentid'];
			echo "{id:$DEPT_ID, pId:$DEPT_PARENT, name:'$DEPT_NAME', isParent:true}";
			if($i<sizeof($rs_a)-1)
				echo ",";
		}
		if(sizeof($rs_a)==0)
		{
			$sql = "select * from product where producttype='$DEPT_PARENT' order by productname,mode,standard";
			$rs = $db->Execute($sql);
			$rs_a = $rs->GetArray();
			for($i=0;$i<sizeof($rs_a);$i++)			
			{
				$productId=$rs_a[$i]['productid'];
				$productName=$rs_a[$i]['productname'];
				if($rs_a[$i]['mode']!="")
					$productName=$productName."/".$rs_a[$i]['mode'];
				if($rs_a[$i]['standard']!="")
					$productName=$productName."/".$rs_a[$i]['standard'];	
				echo "{id:'$productId', pId:$DEPT_PARENT, name:'$productName', isParent:false}";
				if($i<sizeof($rs_a)-1)
					echo ",";
				
			}
		}
	}
?>

[<?php
$pId = "0";
$pName = "";
if(array_key_exists( 'id',$_REQUEST)) {
	$pId=$_REQUEST['id'];
}
if(array_key_exists('name',$_REQUEST)) {
	$pName=$_REQUEST['name'];
}
if ($pId==null || $pId=="") $pId = "0";
if ($pName==null) $pName = "";
getProdTypeList($pId);

?>]
