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

function sellplanstate_value( $fieldvalue, $fields, $i )
{
		$Text = "";
		switch ( $fieldvalue )
		{
		case "-2" :
						$color = "blueviolet";
						break;
		case "-1" :
						$color = "red";
						break;
		case "0" :
						$color = "orange";
						break;
		case "1" :
						$color = "blue";
						break;
		case "2" :
						$color = "green";
						break;
						
		}
		$fieldvalue=returntablefield( "sellplanstate", "id", $fieldvalue, "name" );
		$Text="<font color=$color>$fieldvalue</font>";
		return $Text;
	
}
function sellplanstate_value_PRIV( $fieldvalue, $fields, $i )
{
				global $db;
				global $tablename;
				global $html_etc;
				global $common_html;
				$SYSTEM_STOP_ROW['shenhe_priv'] = 1;
				$SYSTEM_STOP_ROW['flow_priv'] = 1;
				$SYSTEM_STOP_ROW['delete_priv'] = 1;
				$SYSTEM_STOP_ROW['edit_priv'] = 1;
				$SYSTEM_STOP_ROW['next_priv'] = 1;
				$fieldvalue=$fields['value'][$i]['fahuostate'];
				$billtype=returntablefield("sellplanmain", "billid", $fields['value'][$i]['billid'], "billtype");
				
				if($fields['value'][$i]['user_flag']>-1)
				
				{
					switch ( $fieldvalue )
					{
					case "0" ://--
							$sql="select sum(jine) as alljine,sum(num) as allnum,count(*) as allcount from sellplanmain_detail where mainrowid=".$fields['value'][$i]['billid'];
							$rs=$db->Execute($sql);
							$rs_a=$rs->getArray();
							$tmp=$rs_a[0];	
													
							if(floatvalue(strip_tags($fields['value'][$i]['totalmoney']))==$tmp['alljine'] && intval(strip_tags($fields['value'][$i]['totalnum']))==$tmp['allnum'] && $tmp['allcount']>0)
							{
								if($fields['value'][$i]['user_flag']==1)
									$SYSTEM_STOP_ROW['flow_priv'] = 0;
								if($fields['value'][$i]['user_flag']==0)
									$SYSTEM_STOP_ROW['next_priv'] = 0;
							}
							
							if(floatvalue($fields['value'][$i]['kaipiaostate'])==0 && floatvalue($fields['value'][$i]['ifpay'])==0 && $fields['value'][$i]['user_flag']==0)
							{
								$SYSTEM_STOP_ROW['delete_priv'] = 0;
								$SYSTEM_STOP_ROW['edit_priv'] = 0;	
							}
							if($billtype==1)
								$SYSTEM_STOP_ROW['flow_priv'] = 0;	
							break;
					case "1" ://������
							//$SYSTEM_STOP_ROW['delete_priv'] = 0;
							break;
					case "2" ://�跢��
							$SYSTEM_STOP_ROW['shenhe_priv'] = 0;
							break;
					case "3" ://����
							
								$SYSTEM_STOP_ROW['flow_priv'] = 0;
							break;
					case "4" ://ȫ��
							
							break;
					}
				}
				
				return $SYSTEM_STOP_ROW;
}

?>
