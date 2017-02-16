<?php
	ini_set('display_errors', 1);
	ini_set('error_reporting', E_ALL);
	error_reporting(E_WARNING | E_ERROR);
	require_once('lib.inc.php');
	$GLOBAL_SESSION=returnsession();
	$SYSTEM_PRIV_STOP = "1";
	validateMenuPriv("公告通知");
	global $db;
	
	if($_GET['action']=="add_default_data" || $_GET['action']=="edit_default_data")		
	{
		//新增消息通知
		$touser=explode(",",$_POST["to_user"]);
		$messagetitle="公告通知";
		$guanlianid=$_POST["id"];
		if($_GET['action']=="edit_default_data")
		{
			$guanlianid=$_GET["id"];
			deleteMessage($messagetitle,$guanlianid);
		}
		$db->StartTrans();
		for($i=0;$i<sizeof($touser);$i++)
		{
			if($touser[$i]!="")
			{
				newMessage($touser[$i],$_POST['title'],$messagetitle,'../CRM/notify_newai.php?'.base64_encode('action=view_default&id='.$guanlianid),$guanlianid);
				$userInfo=returntablefield("user", "user_id", $touser[$i], "user_name,email,MOBIL_NO");
				$destlist[$i]['email']=$userInfo['email'];
				$destlist[$i]['mobile']=$userInfo['MOBIL_NO'];
				$destlist[$i]['name']=$userInfo['user_name'];
			}	

		}
    	$db->CompleteTrans();
	
    	//新增邮件通知
		if($_POST['ifemail']=='1')		
		{
			sendEmail($destlist,$_POST['title'],$_POST['content']);
		}
		//新增短信通知
		if($_POST['ifsms']=='1')		
		{
			$mobiles='';
			for($i=0;$i<sizeof($destlist);$i++)
			{
				if($destlist[$i]['mobile']!='')
					$mobiles.=$destlist[$i]['mobile'].",";
			}
			print "\n<script type=\"text/javascript\" language=\"javascript\" src=\"".ROOT_DIR."general/ERP/Enginee/jquery/jquery.js\"></script>\n";
			print "<script type=\"text/javascript\" language=\"javascript\">
			$.post('../Framework/sms_getContents.php?action=send', {
			    mobiles:'".$mobiles."',
			    msg:'".cutStr("【".$messagetitle."】".$_POST['title'],70)."'
			}, function(data) {	
			});
		</script>";	
		}
		
		
	}

		
	if($_POST['action']=="getmessage")		
	{
		
		$sql="select count(*) as allcount from message where userid='".$_SESSION['LOGIN_USER_ID']."' and flag=0 and (attime is null or now()>attime)";
		$rs=$db->Execute($sql);
		echo $rs->fields('allcount');
		exit;
	}
	if($_POST['action']=="getmessageshow")		
	{
		header('Content-Type:text/html;charset=GB2312'); 
		$sql="select * from message where userid='".$_SESSION['LOGIN_USER_ID']."' and flag=0 and (attime is null or now()>attime)";
		if($_SESSION['popedlist']!='')
			$sql=$sql." and id not in (".$_SESSION['popedlist'].")";
		$sql=$sql." order by createtime limit 1";
		$rs=$db->Execute($sql);
		$rs_a=$rs->GetArray();
		if(sizeof($rs_a)==1)
		{
			$createtime=$rs_a[0]['createtime'];
			if($rs_a[0]['attime']!='')
				$createtime=$rs_a[0]['attime'];
			$url=$rs_a[0]['url'];
			$url="../Interface".substr($url, 2);
			echo "<b>".$rs_a[0]['msgtype'].":</b><a href='".$url."' target='_blank'>".$rs_a[0]['content']."</a><br><br><span style='float:left'>".$createtime."</span><span style='float:right'><a href='javascript:setReaded(".$rs_a[0]['id'].")'>标志为已读</a></span>";
			if($_SESSION['popedlist']!='')
				$_SESSION['popedlist'].=",";
			$_SESSION['popedlist'].=$rs_a[0]['id'];
		}
		exit;
	}
	if($_GET['action']=="delete_array")			
	{
		$selectid=$_GET['selectid'];
		$selectid=explode(",", $selectid);
	
		for($i=0;$i<sizeof($selectid);$i++)
		{
			if($selectid[$i]!="")
			{
				$sql="delete from message where msgtype='公告通知' and guanlianid=".$selectid[$i];
				$db->Execute($sql);			
			}
		}
	}
	if($_GET['action']=="view_default")	
	{
		/*
		$id=$_GET['id'];
		$sql="select * from message where userid='".$_SESSION['LOGIN_USER_ID']."' and guanlianid=$id";
		$rs=$db->Execute($sql);
		$rs_a=$rs->GetArray();
		$messageid=0;
		if(sizeof($rs_a)==1)
			$messageid=$rs_a[0]['id'];
		if($messageid>0)
		{
			$sql="update message set flag=1 where id=$messageid";
			$db->Execute($sql);
		}
		*/
	}
	addShortCutByDate("createtime","发布时间");
	//$SYSTEM_ADD_SQL =getRoleByUser($SYSTEM_ADD_SQL,"from_user");
	$SYSTEM_ADD_SQL=$SYSTEM_ADD_SQL." and (from_user='".$_SESSION['LOGIN_USER_ID']."' or to_user like '%".$_SESSION['LOGIN_USER_ID'].",%')";

	$filetablename		=	'notify';
	$parse_filename		=	'notify';
	require_once('include.inc.php');
	?>