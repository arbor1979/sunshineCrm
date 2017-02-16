<?php
	ini_set('display_errors', 1);
	ini_set('error_reporting', E_ALL);
	error_reporting(E_WARNING | E_ERROR);
	require_once('lib.inc.php');
	$GLOBAL_SESSION=returnsession();
	validateMenuPriv("库存清单");
	
	function getIds($parentid)
	{
		global $db;
		global $ids;
		$sql = "select rowid from producttype where parentid='".$parentid."'";
		$rs = $db->Execute($sql);
		$rs_a = $rs->GetArray();
	
		if(sizeof($rs_a)==0)
			return;
		else 
		{
			for($i=0;$i<sizeof($rs_a);$i++)	
			{
				$ids=$ids.",".$rs_a[$i]['rowid'];
				getIds($rs_a[$i]['rowid']);
			}
		}
	}
	if($_GET['action']=='init_default' || $_GET['action']=='' || $_GET['action']=='init_default_search')
	{
		print "<script type=\"text/javascript\" language=\"javascript\" src=\"".ROOT_DIR."general/ERP/Enginee/popup/js/popup.js\"></script>";
		print "<script type=\"text/javascript\" language=\"javascript\" src=\"".ROOT_DIR."general/ERP/Enginee/popup/js/popupclass.js\"></script>";
	
	
	}
	if($_GET['action']=='colorinput')
    {
    	global $db;
    	$id=$_GET['rowid'];
    	$colorarray=$_GET['colorarray'];
    	$colorarray=explode(",", $colorarray);
    	$sql="delete from store_color where id=$id";
		$db->Execute($sql);
    	$sql="select * from productcolor";
		$rs = $db->Execute($sql);
		$rs_a = $rs->GetArray(); 
		for($i=0;$i<sizeof($rs_a);$i++)
		{
			if(intval($colorarray[$i])==0)
				continue;
			$sql="insert into store_color values($id,".$rs_a[$i]['id'].",".$colorarray[$i].")";
			$db->Execute($sql);
		}
		print "ok";
		exit;
    }
    
	//数据表模型文件,对应Model目录下面的store_product_newai.ini文件
	//如果是需要复制此模块,则需要修改$parse_filename参数的值,然后对应到Model目录 新文件名_newai.ini文件
	$SYSTEM_ADD_SQL=getKucunByUserid($SYSTEM_ADD_SQL,$_SESSION['LOGIN_USER_ID']);
	
	$filetablename		=	'store_product';
	$parse_filename		=	'store_product';
	require_once('include.inc.php');
	?>