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

function outflowstate_add( $fields, $i )
{
				global $db;
				global $tablename;
				global $html_etc;
				global $common_html;
				global $SYSTEM_PRIV_ROW;
				$Text = "";
				$fieldname = $fields['name'][$i];
				$fieldvalue = $fields['value'][$fieldname];
				switch ( $fieldvalue )
				{
				case "-1" :
								$color = "green";
								$Text = "<TR><TD class=TableData noWrap><font color={$color}>״̬��ת����</font></TD>\r\n\t\t\t<TD class=TableData colspan=\"1\"><p>\r\n\t\t\t<label>\r\n\t\t\t<input type=\"radio\" name=\"flowState\" title='' value=\"1\" checked ><font color={$color}>��������(����ⵥ����ת����������״̬���������)</font></label></p></TD></TR>\r\n\t\t\t";
								break;
				case "1" :
								$color = "red";
								$Text = "<TR><TD class=TableData noWrap><font color={$color}>״̬��ת��:</font></TD>\r\n\t\t\t<TD class=TableData colspan=\"1\"><p>\r\n\t\t\t<label>\r\n\t\t\t<input type=\"radio\" name=\"flowState\" title='' value=\"-1\" checked ><font color={$color}>�Ƶ�(����ⵥ����ת���Ƶ�״̬���������)</font></label></p></TD></TR>\r\n\t\t\t";
				}
				return $Text;
}

?>
