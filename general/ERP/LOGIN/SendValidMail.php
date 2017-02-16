<?php
		
$dest=$_POST['dest'];
$destname=$_POST['destname'];
$zhuti=$_POST['zhuti'];
$content=$_POST['content'];

		require_once('phpmailer/class.phpmailer.php');

		$mail = new PHPMailer(true); // the true param means it will throw exceptions on errors, which we need to catch
		$mail->IsSMTP(); // telling the class to use SMTP
		$error="";
		try {
			
			$mail->Host       = "smtp.qq.com"; // SMTP server
  			//$mail->SMTPDebug  = 2;                     // enables SMTP debug information (for testing)
 			$mail->SMTPAuth   = true;                  // enable SMTP authentication
  			$mail->Port       = 25;                    // set the SMTP port for the GMAIL server
  			$mail->CharSet = "gb2312"; 
  			$mail->Username   = "admin@dandian.net"; // SMTP account username
  			$mail->Password   = "dandian408";        // SMTP account password
			$mail->AddReplyTo("admin@dandian.net", "管理员");
			if($dest=="")
			{
				print "发送目标不能为空";
				exit;
			}
			$mail->AddAddress($dest,$destname); 

			$mail->SetFrom("admin@dandian.net", "管理员");
			$mail->Subject = $zhuti;
			$mail->MsgHTML(preg_replace('/\\\\/','', $content));
			$mail->Send();
			

		  //$mail->AddAttachment('images/phpmailer_mini.gif'); // attachment
		 
		  
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
			
			print "邮件发送失败，原因：".$error;
		}
		print "验证邮件已发出，请查收";

?>
