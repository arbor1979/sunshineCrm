<?php
require_once("lib.inc.php");

$GLOBAL_SESSION=returnsession();




$_GET['�黹��'] = $_SESSION['LOGIN_USER_NAME'];
$_GET['action']=checkreadaction('init_customer');
	//��У���鿴Ȩ�޽������ⶨ��
	if($_GET['ָ����Ա']!="")			{
		$ָ����Ա���� = returntablefield("user","USER_ID",$_GET['ָ����Ա'],"USER_NAME");
		$_GET['�黹��'] = $ָ����Ա����;
	}
	else	{
		$_GET['�黹��'] = $_SESSION['LOGIN_USER_NAME'];
	}

$filetablename='officeproducttui';
require_once('include.inc.php');

require_once('../Help/module_officeproduct.php');

?>