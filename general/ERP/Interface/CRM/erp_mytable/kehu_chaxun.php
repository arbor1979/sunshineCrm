<?php

ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL);
error_reporting(E_WARNING | E_ERROR);


$module_desc = "CRM�ͻ���ѯ";
$module_body = "";
page_css("CRM�ͻ���ѯ");

$module_body .= "<table border=0 width=100% height=100%>";

				$module_body .= "<form action=\"../../JXC/customer_person_newai.php\" name=\"form1\" method=\"get\">";
				$module_body .= "<tr class=TableBlock>
						<td valign=Middle align=left>&nbsp;�ͻ����ƣ�<input type=\"text\" name=\"searchvalue\" class=\"SmallInput\" size=\"26.5\" maxlength=\"25\">
						<input type=hidden name='action' value='init_default_search'>
							<input type=hidden name='searchfield' value='supplyname'>
							</td></tr>";
				$module_body .= "<tr class=TableBlock>
						        <td valign=Middle align=left>&nbsp;&nbsp;<input type=\"submit\" value=\"��ѯ\" class=\"SmallButton\" title=\"ģ����ѯ\" name=\"button\">&nbsp;<input type=\"reset\" value=\"���\" class=\"SmallButton\" title=\"�������\" name=\"button1\">
						        </td></tr>";
			    $module_body .= "<tr class=TableBlock><td valign=Middle align=left>&nbsp;</td></tr>";
				$module_body .= "</form>";

$module_body .= "</table>";

echo $module_body;

?>

<?php
/*
	��Ȩ����:֣�ݵ���Ƽ�������޹�˾;
	��ϵ��ʽ:0371-69663266;
	��˾��ַ:����֣�ݾ��ü��������������־�����·ͨ�Ų�ҵ԰��¥����;
	��˾���:֣�ݵ���Ƽ�������޹�˾λ���й��в�����-֣��,������2007��1��,�����ڰѻ����Ƚ���Ϣ����������ͨ�ż���������ѹ�����ҵ��ʵ���ռ���������ҵ�ͻ��Ĺ�����ҵ���»�У�ȫ���ṩ��������֪ʶ��Ȩ�Ľ�����������������������������в�������ĸ�У���������������СѧУ��������ṩ�̡�Ŀǰ�Ѿ��ж�Ҹ�ְ����ְ��ԺУʹ��ͨ���в��з����Ŀ���������ͷ���;

	�������:����Ƽ�������������Լܹ�ƽ̨,�Լ��������֮����չ���κ��������Ʒ;
	����Э��:���ֻ�У԰��ƷΪ��ҵ���,�������ΪLICENSE��ʽ;����CRMϵͳ��SunshineCRMϵͳΪGPLV3Э�����,GPLV3Э����������뵽�ٶ�����;
	��������:�����ʹ�õ�ADODB��,PHPEXCEL��,SMTARY���ԭ��������,���´���������������;
	*/
?>
