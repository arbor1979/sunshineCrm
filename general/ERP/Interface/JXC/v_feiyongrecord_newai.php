<?php
	ini_set('display_errors', 1);
	ini_set('error_reporting', E_ALL);
	error_reporting(E_WARNING | E_ERROR);
	require_once('lib.inc.php');
	$GLOBAL_SESSION=returnsession();
	validateMenuPriv("费用支出单");

	if($_GET['action']=="add_default_data")		{
		
		global $db;
		//开启事务
	    $db->StartTrans(); 

	    $CaiWu=new CaiWu($db);
	    $CaiWu->insertFeiYongAccount($_POST['typeid'],$_POST['jine'],$_POST['accountid'],$_SESSION['LOGIN_USER_ID'],$_POST['kind'],$_POST['chanshengdate'],$_POST['beizhu'],$_POST['pingzheng']);
	    
	    //是否事务出现错误
		if ($db->HasFailedTrans()) 
		 	print "<script language=javascript>alert('错误：".str_replace("'",  "\'", $db->ErrorMsg())."');window.history.back(-1);</script>";
		else 
		{ 
			page_css("费用支出单");
			$return=FormPageAction("action","init_default");
			print_infor("费用支出单增加成功",'trip',"location='?$return'","?$return",0);
			
		}
    	$db->CompleteTrans();
		exit;	
		
	}
	/*
	if($_GET['action']=="tongyi")
	{
		$feiyonginfo=returntablefield("v_feiyongrecord", "billid", $_GET['billid'], "jine,accountid");
		$jine=$feiyonginfo['jine'];
		$accountid=$feiyonginfo['accountid'];
		$oldjine=returntablefield("bank","rowid",$accountid,"jine");
		//开启事务
	    $db->StartTrans();
		$sql="update bank set jine=jine-".$jine." where rowid=$accountid";
	    $db->Execute($sql);
	     
	    $feiyongname='费用支出';
	    $sql="insert into accessbank (bankid,oldjine,jine,opertype,guanlianbillid,createman,createtime) values ($accountid,$oldjine,-$jine,'$feiyongname',".$_GET['billid'].",'".$_SESSION['LOGIN_USER_ID']."','".date("Y-m-d H:i:s")."')";
	    $db->Execute($sql);
	    $sql="update v_feiyongrecord set shenhestate='同意',shenheren='".$_SESSION['LOGIN_USER_ID']."',shenhetime='".date("Y-m-d H:i:s")."' where billid=".$_GET['billid'];
	    $db->Execute($sql);
	    //是否事务出现错误
		if ($db->HasFailedTrans()) 
		 	print "<script language=javascript>alert('错误：".str_replace("'",  "\'", $db->ErrorMsg())."');window.history.back(-1);</script>";
		else 
		{ 
			page_css("费用支出单");
			$return=FormPageAction("action","init_default");
			print_infor("费用支出单审核成功",'trip',"location='?$return'","?$return",0);
			
		}
    	$db->CompleteTrans();
		exit;
	}	
	if($_GET['action']=="foujue")
	{
		$sql="update v_feiyongrecord set shenhestate='否决',shenheren='".$_SESSION['LOGIN_USER_ID']."',shenhetime='".date("Y-m-d H:i:s")."' where billid=".$_GET['billid'];
	    $db->Execute($sql);
	    page_css("费用支出单");
		$return=FormPageAction("action","init_default");
		print_infor("费用支出单已否决",'trip',"location='?$return'","?$return",0);
		exit;
	}
	*/
	if($_GET['action']=="delete_array")			
	{
		$selectid=$_GET['selectid'];
		$selectid=explode(",", $selectid);
		//开启事务
	    $db->StartTrans(); 
		for($i=0;$i<sizeof($selectid);$i++)
		{
			if($selectid[$i]!="")
			{
				global $db;
				$feiyonginfo=returntablefield("feiyongrecord","billid",$selectid[$i],"accountid,jine,pingzheng");
				$accountid=$feiyonginfo['accountid'];
				$jine=$feiyonginfo['jine'];
				$pingju=$feiyonginfo['pingzheng'];
				if($pingju!='')
				{
					require_once('../../Enginee/lib/utility_file.php');
					delete_single_attach($pingju);
				}
			    $sql="delete from feiyongrecord where billid=".$selectid[$i];
			    $db->Execute($sql);
			    $oldjine=returntablefield("bank","rowid",$accountid,"jine");
			    $sql="update bank set jine=jine+(".$jine.") where rowid=".$accountid;
			    $db->Execute($sql);
			    $sql="insert accessbank (bankid,oldjine,jine,opertype,guanlianbillid,createman,createtime) values (".$accountid.",$oldjine,".$jine.
			    ",'费用支出',$selectid[$i],'".$_SESSION['LOGIN_USER_ID']."','".date("Y-m-d H:i:s")."')";
			    $db->Execute($sql);
	    
			}
		}
		//是否事务出现错误
		if ($db->HasFailedTrans()) 
		 	print "<script language=javascript>alert('错误：".str_replace("'",  "\'", $db->ErrorMsg())."');window.history.back(-1);</script>";
		else 
		{ 
			page_css("费用支出单");
			$return=FormPageAction("action","init_default");
			print_infor("费用支出单删除成功",'trip',"location='?$return'","?$return",0);
			
		}
    	$db->CompleteTrans();
		exit;
	}
	
	//数据表模型文件,对应Model目录下面的v_feiyongrecord_newai.ini文件
	//如果是需要复制此模块,则需要修改$parse_filename参数的值,然后对应到Model目录 新文件名_newai.ini文件
	addShortCutByDate("createtime","创建时间");
	$filetablename		=	'v_feiyongrecord';
	$parse_filename		=	'v_feiyongrecord';
	require_once('include.inc.php');
	?>