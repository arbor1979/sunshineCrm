<?php
	ini_set('display_errors', 1);
	ini_set('error_reporting', E_ALL);
	error_reporting(E_WARNING | E_ERROR);
	require_once('lib.inc.php');
	$GLOBAL_SESSION=returnsession();
	validateMenuPriv("����֧����");

	if($_GET['action']=="add_default_data")		{
		
		global $db;
		//��������
	    $db->StartTrans(); 

	    $CaiWu=new CaiWu($db);
	    $CaiWu->insertFeiYongAccount($_POST['typeid'],$_POST['jine'],$_POST['accountid'],$_SESSION['LOGIN_USER_ID'],$_POST['kind'],$_POST['chanshengdate'],$_POST['beizhu'],$_POST['pingzheng']);
	    
	    //�Ƿ�������ִ���
		if ($db->HasFailedTrans()) 
		 	print "<script language=javascript>alert('����".str_replace("'",  "\'", $db->ErrorMsg())."');window.history.back(-1);</script>";
		else 
		{ 
			page_css("����֧����");
			$return=FormPageAction("action","init_default");
			print_infor("����֧�������ӳɹ�",'trip',"location='?$return'","?$return",0);
			
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
		//��������
	    $db->StartTrans();
		$sql="update bank set jine=jine-".$jine." where rowid=$accountid";
	    $db->Execute($sql);
	     
	    $feiyongname='����֧��';
	    $sql="insert into accessbank (bankid,oldjine,jine,opertype,guanlianbillid,createman,createtime) values ($accountid,$oldjine,-$jine,'$feiyongname',".$_GET['billid'].",'".$_SESSION['LOGIN_USER_ID']."','".date("Y-m-d H:i:s")."')";
	    $db->Execute($sql);
	    $sql="update v_feiyongrecord set shenhestate='ͬ��',shenheren='".$_SESSION['LOGIN_USER_ID']."',shenhetime='".date("Y-m-d H:i:s")."' where billid=".$_GET['billid'];
	    $db->Execute($sql);
	    //�Ƿ�������ִ���
		if ($db->HasFailedTrans()) 
		 	print "<script language=javascript>alert('����".str_replace("'",  "\'", $db->ErrorMsg())."');window.history.back(-1);</script>";
		else 
		{ 
			page_css("����֧����");
			$return=FormPageAction("action","init_default");
			print_infor("����֧������˳ɹ�",'trip',"location='?$return'","?$return",0);
			
		}
    	$db->CompleteTrans();
		exit;
	}	
	if($_GET['action']=="foujue")
	{
		$sql="update v_feiyongrecord set shenhestate='���',shenheren='".$_SESSION['LOGIN_USER_ID']."',shenhetime='".date("Y-m-d H:i:s")."' where billid=".$_GET['billid'];
	    $db->Execute($sql);
	    page_css("����֧����");
		$return=FormPageAction("action","init_default");
		print_infor("����֧�����ѷ��",'trip',"location='?$return'","?$return",0);
		exit;
	}
	*/
	if($_GET['action']=="delete_array")			
	{
		$selectid=$_GET['selectid'];
		$selectid=explode(",", $selectid);
		//��������
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
			    ",'����֧��',$selectid[$i],'".$_SESSION['LOGIN_USER_ID']."','".date("Y-m-d H:i:s")."')";
			    $db->Execute($sql);
	    
			}
		}
		//�Ƿ�������ִ���
		if ($db->HasFailedTrans()) 
		 	print "<script language=javascript>alert('����".str_replace("'",  "\'", $db->ErrorMsg())."');window.history.back(-1);</script>";
		else 
		{ 
			page_css("����֧����");
			$return=FormPageAction("action","init_default");
			print_infor("����֧����ɾ���ɹ�",'trip',"location='?$return'","?$return",0);
			
		}
    	$db->CompleteTrans();
		exit;
	}
	
	//���ݱ�ģ���ļ�,��ӦModelĿ¼�����v_feiyongrecord_newai.ini�ļ�
	//�������Ҫ���ƴ�ģ��,����Ҫ�޸�$parse_filename������ֵ,Ȼ���Ӧ��ModelĿ¼ ���ļ���_newai.ini�ļ�
	addShortCutByDate("createtime","����ʱ��");
	$filetablename		=	'v_feiyongrecord';
	$parse_filename		=	'v_feiyongrecord';
	require_once('include.inc.php');
	?>