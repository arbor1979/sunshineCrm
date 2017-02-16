<?php
	ini_set('display_errors', 1);
	ini_set('error_reporting', E_ALL);
	error_reporting(E_WARNING | E_ERROR);
	require_once('lib.inc.php');
	$GLOBAL_SESSION=returnsession();
	$SYSTEM_PRIV_STOP = "1";
	validateMenuPriv("任务执行");
	function updateWorkplanmain($id)
	{
		global $db;
		
		$state=0;
		$sql="select * from workplanmain_detail where mainrowid=$id";
		$rs=$db->Execute($sql);
		$rs_a = $rs->GetArray();
		if(sizeof($rs_a)>0)
			$state=1;
		$sql="select * from workplanmain where id=$id";
		$rs=$db->Execute($sql);
		$rs_a = $rs->GetArray();
		if(sizeof($rs_a)==1)
		{
			$flag=true;
			$zhixingren=$rs_a[0]['zhixingren'];
			$zhixingrenArray=explode(",",$zhixingren);
			for($i=0;$i<sizeof($zhixingrenArray);$i++)
			{
				if($zhixingrenArray[$i]!='')
				{
					$sql="select * from workplanmain_detail where createman='".$zhixingrenArray[$i]."' and mainrowid=$id and result=1";
					$rs=$db->Execute($sql);
					$rs_b = $rs->GetArray();
					if(sizeof($rs_b)==0)
						$flag=false;
				}
			}
			$sql="select max(createtime) as maxtime from workplanmain_detail where  mainrowid=$id";
			$rs=$db->Execute($sql);
			$rs_b = $rs->GetArray();
			$maxtime='';
			if(!empty($rs_b[0][maxtime]))
				$maxtime=$rs_b[0][maxtime];
			if($flag)	
				$state=2;
			if($state==2)
			{
				newMessage($rs_a[0]['createman'],$rs_a[0]['zhuti'],'工作任务完结','../CRM/workplanmain_newai.php?'.base64_encode('action=view_default&id='.$id),$id);
				$sql="update workplanmain set state=$state,finishtime=now(),lastzhixingtime='$maxtime' where id=$id";
			}
			else	 
				$sql="update workplanmain set state=$state,finishtime=null,lastzhixingtime='$maxtime' where id=$id";
			$db->Execute($sql);
		}
	}
	
	$mainrowid=$_GET['mainrowid'];
	if($mainrowid!='' && $_GET['action']=='add_default')
	{
		$ADDINIT=array("mainrowid"=>$mainrowid);
	}
	
	
	$action = $_GET["action"];  
	if(stripos($action,"workplandetail")!==false)
    {
    	header ("content-type: text/xml");
		$doc=new DOMDocument("1.0","GBK"); #声明文档类型
		$doc->formatOutput=true;               #设置可以输出操作
		#声明根节点，最好一个XML文件有个跟节点
		$root=$doc->createElement("root");    #创建节点对象实体 
		$root=$doc->appendChild($root);      #把节点添加进来
		
    	$billid = $_GET["id"];  
    	$sql = "select * from workplanmain_detail where mainrowid=$billid and createman='".$_SESSION[LOGIN_USER_ID]."' order by begintime desc";
		$rs = $db->Execute($sql);
		$rs_a = $rs->GetArray();
		
    	if (count($rs_a) != 0) 
    	{
        	for($i=0;$i<count($rs_a);$i++)
        	{
				$billnode=$doc->createElement("workplanmaindetail"); 
        		$billnode=$root->appendChild($billnode);
        		$begintime=$doc->createElement("begintime"); 
		        $begintimenode=$billnode->appendChild($begintime);
		        $endtime=$doc->createElement("endtime"); 
		        $endtimenode=$billnode->appendChild($endtime);
		        $content=$doc->createElement("content"); 
		        $contentnode=$billnode->appendChild($content);
		        $result=$doc->createElement("result"); 
		        $resultnode=$billnode->appendChild($result);
        		
		        $begintimenode->appendChild($doc->createTextNode(substr($rs_a[$i]['begintime'],0,16)));
				$endtimenode->appendChild($doc->createTextNode(substr($rs_a[$i]['endtime'],0,16)));
				$contentnode->appendChild($doc->createTextNode(iconv("GBK","UTF-8",cutStr($rs_a[$i]['content'],10))));
				$resultnode->appendChild($doc->createTextNode($rs_a[$i]['result']));
		
        	}
    	}
    	echo $doc->saveXML();
    	exit;
    }
    if($_GET['action']=="add_default_data")
	{
		require_once("../Framework/uploadFile.php");
		uploadFile();
		$nextcontent=$_POST["nextcontent"];
		$nexttime=$_POST["nexttime"];
		$zhuti=$_POST['mainrowid_ID'];
		$db->StartTrans();  
		$maxid=returnAutoIncrement("id", "workplanmain_detail");
		
		$sql="insert into workplanmain_detail values($maxid,".$_POST['mainrowid'].",'".$_SESSION['LOGIN_USER_ID']."','".date("Y-m-d H:i:s").
		"','".$_POST['begintime']."','".$_POST['endtime']."','".htmlspecialchars($_POST['content'])."','".$_POST['result']."',";
		if($nexttime=='')
			$sql.="null,'";
		else 
			$sql.="'".$nexttime."','";
		$sql.=htmlspecialchars($nextcontent)."','".$_POST['fujian']."')";
		$db->Execute($sql);
		updateWorkplanmain($_POST['mainrowid']);
		if($nextcontent!="" && $_POST["nexttime"]!='')
		{
			$url='../CRM/workplanmain_newai.php?'.base64_encode('action=view_default&id='.$_POST['mainrowid']);
			newMessage($_SESSION['LOGIN_USER_ID'],$zhuti."-".$nextcontent,'工作任务',$url,$_POST['mainrowid'],$_POST['nexttime']);
	
			$EndTime=strtotime("$nexttime +1 hour");
			$EndTime=date("Y-m-d H:i:s",$EndTime);
			$url="../".$url;
			
			newCalendar($_SESSION['LOGIN_USER_ID'],$_POST['nexttime'],$EndTime,'工作任务','1',$zhuti."-".$nextcontent,$url,$_POST['mainrowid']);
			
		}	
		$db->CompleteTrans();
	
		//是否事务出现错误
		if ($db->HasFailedTrans()) 
		{
		 	print "<script language=javascript>alert('错误：".str_replace("'",  "\'", $db->ErrorMsg())."');window.history.back(-1);</script>";
		}
		else 
		{ 
			
			page_css("任务执行记录");
			$return=FormPageAction("action","init_default");
			print_infor("新增任务执行记录成功",'trip',"location='?$return'","?$return",0);
		}
    	exit;
	}
    if($_GET['action']=="delete_array")
	{
		$selectid=$_GET['selectid'];
		
		$selectid=explode(",", $selectid);
		
		$db->StartTrans();  
		require_once("../Framework/uploadFile.php");
		for($i=0;$i<sizeof($selectid);$i++)
		{
			
			if($selectid[$i]!="")
			{
				deleteFile("workplanmain_detail","id",$selectid[$i],"fujian");
				$mainrowid=returntablefield("workplanmain_detail", "id", $selectid[$i], "mainrowid");
				$sql="delete from workplanmain_detail where id=".$selectid[$i];
				$db->Execute($sql);
				updateWorkplanmain($mainrowid);
				
			}
		}
		//是否事务出现错误
		if ($db->HasFailedTrans()) 
		{
		 	print "<script language=javascript>alert('错误：".str_replace("'",  "\'", $db->ErrorMsg())."');window.history.back(-1);</script>";
		}
		else 
		{ 
			page_css("任务执行记录");
			$return=FormPageAction("action","init_default");
			print_infor("任务执行记录已删除",'trip',"location='?$return'","?$return",0);
		}
    	$db->CompleteTrans();
		exit;	
	}
	addShortCutByDate("begintime","开始时间");
	$SYSTEM_ADD_SQL=getRoleByUser($SYSTEM_ADD_SQL,"createman");
	//$SYSTEM_PRINT_SQL=1;
	$filetablename		=	'workplanmain_detail';
	$parse_filename		=	'workplanmain_detail';
	require_once('include.inc.php');
	
	
	
	
	?>