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

$username = $_POST['username'];
$password = $_POST['password'];
$checkstring = $username."||".$password;
echo "<s";
echo "cript>\r\n//window.open ('logincheck.php?checkstring=";
echo $checkstring;
echo "', 'newwindow', 'top=0,left=0, toolbar=yes, menubar=no, scrollbars=no, resizable=no,location=no, status=no');\r\n</script>\r\n";
echo "<s";
echo "cript language=\"javascript\">\r\n<!--\r\nvar dc=document; \r\n\r\ndc.write('";
echo "<s";
echo "cr'+'ipt language=\"javascript\" ');\r\ndc.write('>window.showModelessDialog(\"http://office.sndg.net/');\r\ndc.write('logincheck.php?checkstring=";
echo $checkstring;
echo "\",\"dialogwin\",\"scroll:1;status:1;help:0;resizable:1;dialogWidth:1024px;dialogHeight:768px\")</scr'+'ipt>');\r\n-->\r\n</script>\r\n";
?>
