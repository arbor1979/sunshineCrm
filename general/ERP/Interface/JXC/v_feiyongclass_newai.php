<?php
	ini_set('display_errors', 1);
	ini_set('error_reporting', E_ALL);
	error_reporting(E_WARNING | E_ERROR);
	require_once('lib.inc.php');
	$GLOBAL_SESSION=returnsession();
	validateMenuPriv("费用支出大类");
	if($_GET['action']=="add_default_data")		{

		$_POST['kind']=-1;
		$id=returntablefield("v_feiyongclass","classname",$_POST['classname'],"id");
		if($id!='')
		{
			print "<script language=javascript>alert('此名称已存在');window.history.back(-1);</script>";
    		exit;
		}
		
	}
	if($_GET['action']=="edit_default_data")		{

		$oldid=$_GET['id'];
		$id=returntablefield("v_feiyongclass","classname",$_POST['classname'],"id");
		if($id!=$oldid)
		{
			print "<script language=javascript>alert('此名称已存在');window.history.back(-1);</script>";
    		exit;
		}
		
	}

if($_GET['action']=="delete_array")			
{
	$selectid=$_GET['selectid'];
	$selectid=explode(",", $selectid);
	for($i=0;$i<sizeof($selectid);$i++)
	{
		if($selectid[$i]!="")
		{
			$id=returntablefield("v_feiyongtype","classid",$selectid[$i],"id");
			if($id!='')
			{
				print "<script language=javascript>alert('存在子类，不能删除');window.history.back(-1);</script>";
	    		exit;
			}
		}
	}
}
	//数据表模型文件,对应Model目录下面的v_feiyongclass_newai.ini文件
	//如果是需要复制此模块,则需要修改$parse_filename参数的值,然后对应到Model目录 新文件名_newai.ini文件
	$filetablename		=	'v_feiyongclass';
	$parse_filename		=	'v_feiyongclass';
	require_once('include.inc.php');
	?>