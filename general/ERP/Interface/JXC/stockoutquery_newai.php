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
$filetablename = "stockoutquery";
//$NEWAIINIT_VALUE_SYSTEM = "select supply.supplyid,supply.supplyname,sum(stockoutmain.amt) amt1,sum(stockoutmain.amt) amt2 ,sum(stockoutmain.factpayamt) factpayamt ,sum(stockoutmain.payamt) payamt ,sum(stockoutmain.factpayamt)-sum(stockoutmain.payamt) subamt,supply.phone,supply.contactaddress from stockoutmain,supply where stockoutmain.supplyid=supply.supplyid group by supply.supplyid ";
//$NEWAIINIT_VALUE_SYSTEM_NUM = "select  count(stockoutmain.tabledate) as numfrom stockoutmain,supply where stockoutmain.supplyid=supply.supplyid group by supply.supplyid ";
require_once( "include.inc.php" );
echo "û���ҵ����ʵ�SQL��䡣";
//create view stockoutquery AS  select supply.supplyid,supply.supplyname,sum(stockoutmain.amt) amt1,sum(stockoutmain.amt) amt2 ,sum(stockoutmain.factpayamt) factpayamt ,sum(stockoutmain.payamt) payamt ,sum(stockoutmain.factpayamt)-sum(stockoutmain.payamt) subamt,supply.phone,supply.contactaddress from stockoutmain,supply where stockoutmain.supplyid=supply.supplyid group by supply.supplyid

?>
