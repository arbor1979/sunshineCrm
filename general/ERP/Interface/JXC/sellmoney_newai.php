<?php
/*
��Ȩ����:֣�ݵ���Ƽ�������޹�˾;
��ϵ��ʽ:0371-69663266;
��˾��ַ:����֣�ݾ��ü��������������־�����·ͨ�Ų�ҵ԰��¥����;
��˾���:֣�ݵ���Ƽ�������޹�˾λ���й��в�����-֣��,������2007��1��,�����ڰѻ����Ƚ���Ϣ����������ͨ�ż���������ѹ�����ҵ��ʵ���ռ���������ҵ�ͻ��Ĺ�����ҵ���»�У�ȫ���ṩ��������֪ʶ��Ȩ�Ľ�����������������������������в�������ĸ�У���������������СѧУ��������ṩ�̡�Ŀǰ�����ж�Ҹ�ְ����ְ��ԺУʹ��ͨ���в��з����Ŀ���������ͷ���;

�������:����Ƽ�������������Լܹ�ƽ̨,�Լ��������֮����չ���κ��������Ʒ;
����Э��:���ֻ�У԰��ƷΪ��ҵ���,�������ΪLICENSE��ʽ;����CRMϵͳ��SunshineCRMϵͳΪGPLV3Э�����,GPLV3Э����������뵽�ٶ�����;
��������:�����ʹ�õ�ADODB��,PHPEXCEL��,SMTARY���ԭ��������,���´���������������;
*/

require_once( "lib.inc.php" );
$sessionkey = returnsesskey( );
$GLOBAL_SESSION = returnsession( );
$SUNSHINE_USER_NAME = $_SESSION['SUNSHINE_USER_NAME'];
$SUNSHINE_USER_NAME = "admin";
$filetablename = "sellmoneyanalysis";
//$NEWAIINIT_VALUE_SYSTEM = "select customer.supplyname supplyname, stockoutmain.tabledate, sum( stockoutmain.amt ) allpaymoney from stockoutmain, customer where stockoutmain.supplyid = customer.supplyid GROUP BY customer.supplyid, stockoutmain.tabledate";
//$NEWAIINIT_VALUE_SYSTEM_NUM = "select  count(stockoutmain.tabledate) as numfrom stockoutmain, customerwhere stockoutmain.supplyid = customer.supplyidGROUP BY customer.supplyid, stockoutmain.tabledate";
require_once( "include.inc.php" );
//create view sellmoneyanalysis AS  select customer.supplyname supplyname, stockoutmain.tabledate, sum( stockoutmain.amt ) allpaymoney from stockoutmain, customer where stockoutmain.supplyid = customer.supplyid GROUP BY customer.supplyid, stockoutmain.tabledate

?>
