<?php

	ini_set('display_errors', 1);
	ini_set('error_reporting', E_ALL);
	error_reporting(E_WARNING | E_ERROR);
	require_once('lib.inc.php');
	$GLOBAL_SESSION=returnsession();
	$SYSTEM_PRIV_STOP = "1";

	validateMenuPriv("�����ʼ�");
	//print_r($_GET);exit;
	if($_SESSION[SMTPServerIP] == ''){
		print "<script language=javascript>alert('����û�������ʼ������˻��������ڲ˵����ҵİ칫���������˲������á��н�������');</script>";
	}
	if($_GET['action']=="add_default")
	{
			
		print "<script type=\"text/javascript\" language=\"javascript\" src=\"".ROOT_DIR."general/ERP/Enginee/jquery/jquery.js\"></script>";
		$sendlist=$_GET['sendlist'];
		//print_r($sendlist);exit;
		$sendlistarray=explode(",", $sendlist);
		
		$textareaInitValue="";
		for($i=0;$i<count($sendlistarray);$i++)
		{
			if($sendlistarray[$i]=='')
				continue;
			
			else if($_GET['fromsrc']=='supply')
			{
				$linkman=returntablefield("supplylinkman", "rowid", $sendlistarray[$i], "email,supplyname");
				if($linkman['email']!='')
				{
				if($textareaInitValue=='')
					$textareaInitValue=$linkman['email'].',';
				else
					$textareaInitValue=$textareaInitValue.$linkman['email'].',';
				}
			}
			else if($_GET['fromsrc']=='customer')
			{
				$linkman=returntablefield("linkman", "rowid", $sendlistarray[$i], "email,linkmanname");
				if($linkman['email']!='')
				{
				if($textareaInitValue=='')
					$textareaInitValue=$linkman['email'].',';
				else
					$textareaInitValue=$textareaInitValue.$linkman['email'].',';	
				}			
				
			}
			
			
		}
		if($_GET['fromsrc']=='supply')
			print "<script type='text/javascript'>
			$(document).ready(function(){
			document.form1.supplys.value='".$sendlist."';
  			document.form1.supplys_ID.value='".$textareaInitValue."';
			});
			</script>";
		else if($_GET['fromsrc']=='customer')
			print "<script type='text/javascript'>
			$(document).ready(function(){
			document.form1.customers.value='".$sendlist."';
  			document.form1.customers_ID.value='".$textareaInitValue."';
			});
			</script>";
		else 
		{
				print "<script type='text/javascript'>
			$(document).ready(function(){
			document.form1.others.value='".$sendlist."';
			});
			</script>";	
		}	
	

	}	
	if($_GET['action']=="add_default_data")		{
		
		require_once('../../Framework/phpmailer/class.phpmailer.php');
		//print $_SESSION['SMTPServerIP'];exit;
		$mail = new PHPMailer(true); // the true param means it will throw exceptions on errors, which we need to catch
		$mail->IsSMTP(); // telling the class to use SMTP
		$error="";
		try {
			
			$mail->Host       = $_SESSION['SMTPServerIP']; // SMTP server
  			//$mail->SMTPDebug  = 2;                     // enables SMTP debug information (for testing)
 			$mail->SMTPAuth   = true;                  // enable SMTP authentication
  			$mail->Port       = 25;                    // set the SMTP port for the GMAIL server
  			$mail->CharSet = "gb2312"; 
  			$mail->Username   = $_SESSION['EmailAddress']; // SMTP account username
  			$mail->Password   = $_SESSION['EmailPassword'];        // SMTP account password
			$mail->AddReplyTo($_SESSION['EmailAddress'], $_SESSION['LOGIN_USER_NAME']);
			 
			$customerArray=explode(",",$_POST['customers']);
		  $j=0;
		  for($i=0;$i<count($customerArray);$i++)
		  {
		  	
		  	$customerInfo=returntablefield("linkman", "rowid", $customerArray[$i], "customerid,linkmanname,email");
		  	if($customerInfo['email']!='')
		  	{
		  		$mail->AddAddress($customerInfo['email'], $customerInfo['supplyname']);
		  		$j=$j+1;
		  	}
		  	if($customerArray[$i]!='')
		  	{
		  		$sql="insert into crm_contact (customerid,linkmanid,user_id,createman,contact,stage,describes,createtime,contacttime) values("
		  		.$customerInfo['customerid'].",".$customerArray[$i].",'".$_SESSION['LOGIN_USER_ID']."','".$_SESSION['LOGIN_USER_ID']."',6,1,'"
		  		.preg_replace('/\\\\/','', strip_tags($_POST['CONTENT']))."','".date('Y-m-d H:i:s')."','".date('Y-m-d H:i:s')."')";
		  		$db->Execute($sql);
		  	}	
		  }
		  
		  $supplyArray=explode(",",$_POST['supplys']);
		  for($i=0;$i<count($supplyArray);$i++)
		  {
		  	$supplyInfo=returntablefield("supplylinkman", "rowid", $supplyArray[$i], "supplyname,email");
		  	if($supplyInfo['email']!='')
		  	{
		  		$mail->AddAddress($supplyInfo['email'], $supplyInfo['supplyname']);
		  		$j=$j+1;
		  	}
		  }
		  $otherArray=explode(",",$_POST['others']);
		  for($i=0;$i<count($otherArray);$i++)
		  {
		  	if($otherArray[$i]!='')
		  	{
		  		$mail->AddAddress($otherArray[$i],$otherArray[$i]);
		  		$j=$j+1;
		  	}
		  }
			if($j==0)
			{
				print "<script language=javascript>alert('����Ŀ�겻��Ϊ��');history.back(-1);</script>";
				exit;
			}
			$mail->SetFrom($_SESSION['EmailAddress'], $_SESSION['LOGIN_USER_NAME']);
			$mail->Subject = $_POST['SUBJECT'];
			$mail->MsgHTML(preg_replace('/\\\\/','', $_POST['CONTENT']));
			
			$YM = date( "ym", time( ) );
			$PATH=DOCUMENT_ROOT."attach/ERP/attachment/";
	
			$PATH = $PATH.$YM;
											
			if ( !file_exists( $PATH ) )
			{
				mkdir( $PATH, 448 );
			}
			$FILENAMEArray=array();
			foreach ( $GLOBALS['_FILES'] as $KEY => $ATTACHMENT )
			{
					if ( $ATTACHMENT['error'] == 0)
					{
						$ATTACH_NAME = $ATTACHMENT['name'];
						$ATTACH_SIZE = $ATTACHMENT['size'];
						$ATTACH_FILE = $ATTACHMENT['tmp_name'];
						$FILENAME=$PATH."/".$ATTACH_NAME;
						@copy( $ATTACH_FILE, $FILENAME );
						$mail->AddAttachment($FILENAME);
						array_push($FILENAMEArray,$FILENAME);
					}
					
			}

		  //$mail->AddAttachment('images/phpmailer_mini.gif'); // attachment
		  $mail->Send();
		  $_POST['SEND_FLAG']=1;
		  while (list($key,$value) = each($FILENAMEArray)) 
		  { 
		  	@unlink($value);
		  } 
		  
		} catch (phpmailerException $e) 
		{
		  $error=$e->errorMessage(); //Pretty error messages from PHPMailer
		} catch (Exception $e) {
		  $error=$e->getMessage(); //Boring error messages from anything else!
		}
		if($error!='')
		{
			$error = str_replace("\n",'',$error);
			$error = str_replace("\r",'',$error);
			$error =preg_replace('/<[^>]+>/iU','',$error);
			
			print "<script language=javascript>alert('�ʼ�����ʧ�ܣ�ԭ��".$error."');history.back(-1);</script>";
    		exit;
		}

	}
	addShortCutByDate("SEND_TIME","����ʱ��");
$SYSTEM_ADD_SQL =$SYSTEM_ADD_SQL =getRoleByUser($SYSTEM_ADD_SQL,"FROM_ID");
	//���ݱ�ģ���ļ�,��ӦModelĿ¼�����email_newai.ini�ļ�
	//�������Ҫ���ƴ�ģ��,����Ҫ�޸�$parse_filename������ֵ,Ȼ���Ӧ��ModelĿ¼ ���ļ���_newai.ini�ļ�
	$filetablename		=	'email';
	$parse_filename		=	'email';
	require_once('../JXC/include.inc.php');
	?>