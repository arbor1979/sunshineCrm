<?php
require_once('lib.inc.php');
page_css("SYSTEM","INIT");
print "��ʼ��:����\n<BR>";
$sql = "delete from stockinmain";$db->Execute($sql);
$sql = "delete from stockindetail";$db->Execute($sql);

print "��ʼ��:�����\n<BR>";
$sql = "delete from stockoutmain";$db->Execute($sql);
$sql = "delete from stockoutdetail";$db->Execute($sql);

print "��ʼ��:����\n<BR>";
$sql = "delete from storedetail";$db->Execute($sql);
$sql = "delete from stockindetail";$db->Execute($sql);

print "��ʼ��:�ɹ�����\n<BR>";
$sql = "delete from buyplanmain";$db->Execute($sql);
$sql = "delete from buyplandetail";$db->Execute($sql);

print "��ʼ��:���۶���\n<BR>";
$sql = "delete from sellplanmain";$db->Execute($sql);
$sql = "delete from sellplandetail";$db->Execute($sql);


print "��ʼ��:���ۺ�ͬ\n<BR>";
$sql = "delete from sellcontract";$db->Execute($sql);

print "��ʼ��:�ۺ����\n<BR>";
$sql = "delete from sellservice";$db->Execute($sql);



print "��ʼ��:Ӧ�տ�\n<BR>";
$sql = "delete from getmain";$db->Execute($sql);
$sql = "delete from getdetail";$db->Execute($sql);

print "��ʼ��:Ӧ����\n<BR>";
$sql = "delete from paymain";$db->Execute($sql);
$sql = "delete from paydetail";$db->Execute($sql);


print "��ʼ��:�ͻ���������ѡ��\n<BR>";
$sql = "delete from customerproduct";$db->Execute($sql);
$sql = "delete from businessinfo";$db->Execute($sql);
$sql = "delete from linkman";$db->Execute($sql);
$sql = "delete from commlog";$db->Execute($sql);
$sql = "delete from competeproduct";$db->Execute($sql);




$sql = "delete from buycontract";$db->Execute($sql);
$sql = "delete from buyplanamt";$db->Execute($sql);
$sql = "delete from sellplanamt";$db->Execute($sql);
$sql = "delete from certificate";$db->Execute($sql);
$sql = "delete from supplyproduct";$db->Execute($sql);
$sql = "delete from supplylinkman";$db->Execute($sql);
$sql = "delete from supply";$db->Execute($sql);




?>