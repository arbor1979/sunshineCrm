<?php
ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL);
error_reporting(E_WARNING | E_ERROR);

//######################�������-Ȩ�޽��鲿��##########################
require_once("lib.inc.php");
$GLOBAL_SESSION=returnsession();
$SYSTEM_PRIV_STOP = 1;
require_once("../EDU/systemprivateinc.php");
CheckSystemPrivate("���ֻ�У԰ϵͳ����-�����ֵ�");
//######################�������-Ȩ�޽��鲿��##########################


	//���ݱ�ģ���ļ�,��ӦModelĿ¼�����dict_xingzheng_qingjia_newai.ini�ļ�
	//�������Ҫ���ƴ�ģ��,����Ҫ�޸�$parse_filename������ֵ,Ȼ���Ӧ��ModelĿ¼ ���ļ���_newai.ini�ļ�
	$filetablename		=	'dict_xingzheng_qingjia';
	$parse_filename		=	'dict_xingzheng_qingjia';
	require_once('include.inc.php');
	?>