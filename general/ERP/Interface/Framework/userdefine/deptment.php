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

function deptment_value( $fieldvalue, $fields, $i )
{
				global $db;
				global $tablename;
				global $html_etc;
				global $common_html;
				global $SYSTEM_PRIV_ROW;
				
				return $fieldvalue;
}

function deptment_value_PRIV( $fieldvalue, $fields, $i )
{
				global $db;
				global $tablename;
				global $html_etc;
				global $common_html;
				//print_R($fields['value'][$i]);
				$FieldValue = $fields['value'][$i]['DEPT_ID'];
				$tableNo = returntablefield( "department", "DEPT_PARENT", $FieldValue, "DEPT_PARENT" );
        		if($tableNo != '')
        			$flag=1;
        		$tableNo = returntablefield( "user", "DEPT_ID", $FieldValue, "DEPT_ID" );
        		if($tableNo!= '')
        			$flag=1;
				//$tablecode = $fields['value'][$i]['tablecode'];
				//$tableNo = returntablefield( "stockoutmain", "tablecode", $tablecode, "tableNo" );
				
				if ( $flag==1 )
					$SYSTEM_STOP_ROW['delete_priv'] = 1;
				
				else 
					$SYSTEM_STOP_ROW['delete_priv'] = 0;
					
				$SYSTEM_STOP_ROW['edit_priv'] = 0;
				return $SYSTEM_STOP_ROW;
}

?>
