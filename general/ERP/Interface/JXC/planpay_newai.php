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
$filetablename = "planpay";
//$NEWAIINIT_VALUE_SYSTEM = "select supply.supplyid,supply.supplyname,stockinmain.tabledate ,stockinmain.factpayamt-stockinmain.payamt subamt ,stockinmain.factpayamt expsamt ,stockinmain.payamt factpayamt,stockinmain.tablecode,stockinmain.buyman,stockinmain.ROWID from stockinmain,supply where stockinmain.supplyid=supply.supplyid";
//$NEWAIINIT_VALUE_SYSTEM_NUM = "select  count(supply.supplyid) as numfrom stockinmain,supply where stockinmain.supplyid=supply.supplyid ";
require_once( "include.inc.php" );
//create view planpay AS select supply.supplyid,supply.supplyname,stockinmain.tabledate ,stockinmain.factpayamt-stockinmain.payamt subamt ,stockinmain.factpayamt expsamt ,stockinmain.payamt factpayamt,stockinmain.tablecode,stockinmain.buyman,stockinmain.ROWID from stockinmain,supply where stockinmain.supplyid=supply.supplyid

?>
