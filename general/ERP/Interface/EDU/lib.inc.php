<?php
ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL);

// display warnings and errors
error_reporting(E_WARNING | E_ERROR);

//$SYSTEM_MODE = 1 ;

//other dir file
require_once('../../Framework/cache.inc.php');
require_once('../../adodb/adodb.inc.php');
require_once('../../config.inc.php');
if($_GET['userdb']!='')
	$userdb = $_GET['userdb'];
require_once('../../setting.inc.php');
require_once('../../adodb/session/adodb-session2.php');


require_once('../../Enginee/lib/init.php');
require_once('../../Enginee/lib/html_element.php');
require_once('../../Enginee/lib/function_system.php');
require_once('../../Enginee/lib/select_menu.php');
require_once('../../Enginee/lib/select_menu_two.php');
require_once('../../Enginee/lib/select_menu_six.php');
require_once('../../Enginee/lib/select_menu_select_input.php');
require_once('../../Enginee/lib/getpagedata.php');
require_once('../../Enginee/lib/getpagedata_new.php');
require_once('../../Enginee/lib/other.php');
require_once('../../Enginee/lib/fzhu.php');
require_once('../../Enginee/lib/version.php');
require_once('../../Enginee/lib/select_menu_countryCode.php');
require_once('../../Enginee/lib/sqlparser.php');
//root file
require_once('./cache.inc.php');
require_once('lib.function.inc.php');



//$SYSTEM_MODEL = 1;


?><?php
/*
	��Ȩ����:֣�ݵ���Ƽ�������޹�˾;
	��ϵ��ʽ:0371-69663266;
	��˾��ַ:����֣�ݾ��ü��������������־�����·ͨ�Ų�ҵ԰��¥����;
	��˾���:֣�ݵ���Ƽ�������޹�˾λ���й��в�����-֣��,������2007��1��,�����ڰѻ����Ƚ���Ϣ����������ͨ�ż���������ѹ�����ҵ��ʵ���ռ���������ҵ�ͻ��Ĺ�����ҵ���»�У�ȫ���ṩ��������֪ʶ��Ȩ�Ľ�����������������������������в�������ĸ�У���������������СѧУ��������ṩ�̡�Ŀǰ�����ж�Ҹ�ְ����ְ��ԺУʹ��ͨ���в��з����Ŀ���������ͷ���;

	�������:����Ƽ�������������Լܹ�ƽ̨,�Լ��������֮����չ���κ��������Ʒ;
	����Э��:���ֻ�У԰��ƷΪ��ҵ���,�������ΪLICENSE��ʽ;����CRMϵͳ��SunshineCRMϵͳΪGPLV3Э�����,GPLV3Э����������뵽�ٶ�����;
	��������:�����ʹ�õ�ADODB��,PHPEXCEL��,SMTARY���ԭ��������,���´���������������;
	*/
?>