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

function accessbank_value( $fieldvalue, $fields, $i )
{
		$id=$fields['value'][$i]['���'];
		$opertype = returntablefield( "accessbank", "id", $id, "opertype" );
		$parent = returntablefield( "accesstype", "name", $opertype, "parent" );
		$parentname = returntablefield( "accesstype", "id", $parent, "name" );
		$colorValue = setColorByName($fieldvalue);
		if($parentname=='����')
		{
			if($opertype=='����֧��')
			{
				$billinfo = returntablefield( "buyplanmain", "billid", $fieldvalue, "zhuti,billid" );
				$fieldvalue="<a href='buyplanmain_newai.php?action=view_default&billid=".$billinfo['billid']."' target='_blank'><font color=$colorValue>".$billinfo['zhuti']."</font></a>";
			}
			else
			{
				$billinfo = returntablefield( "sellplanmain", "billid", $fieldvalue, "zhuti,billid" );
				$fieldvalue="<a href='sellplanmain_newai.php?action=view_default&billid=".$billinfo['billid']."' target='_blank'><font color=$colorValue>".$billinfo['zhuti']."</font></a>";
			}
		}
		else if($parentname=='Ԥ��Ԥ��')
		{
			if($opertype=='Ԥ�ջ���')
			{
				$fieldvalue="<a href='accesspreshou_newai.php?action=view_default&id=".$fieldvalue."' target='_blank'><font color=$colorValue>".$opertype."-".$fieldvalue."</font></a>";
			}
			else 
			{
				$fieldvalue="<a href='accessprepay_newai.php?action=view_default&id=".$fieldvalue."' target='_blank'><font color=$colorValue>".$opertype."-".$fieldvalue."</font></a>";
			}
			
		}
		else if($opertype=='��������')
		{
			$fieldvalue="<a href='v_shoururecord_newai.php?action=view_default&billid=".$fieldvalue."' target='_blank'><font color=$colorValue>".$opertype."-".$fieldvalue."</font></a>";
		}
		else if($opertype=='����֧��')
		{
			$fieldvalue="<a href='v_feiyongrecord_newai.php?action=view_default&billid=".$fieldvalue."' target='_blank'><font color=$colorValue>".$opertype."-".$fieldvalue."</font></a>";
		}
		else if($opertype=='�ʽ�ע��' || $opertype=='�ʽ��ȡ')
		{
			$fieldvalue="<a href='bankzhuru_newai.php?action=view_default&billid=".$fieldvalue."' target='_blank'><font color=$colorValue>".$opertype."-".$fieldvalue."</font></a>";
		}
		else if($opertype=='�˻���ת��')
		{
			$fieldvalue="<a href='banktobank_newai.php?action=view_default&id=".$fieldvalue."' target='_blank'><font color=$colorValue>".$opertype."-".$fieldvalue."</font></a>";
		}
		else
			$fieldvalue=$parentname."��-".$fieldvalue;
		return $fieldvalue;
}

function accessbank_value_PRIV( $fieldvalue, $fields, $i )
{
				
}

?>
