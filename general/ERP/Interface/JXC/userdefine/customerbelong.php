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

function customerbelong_add($fields, $i )
{
	$userid=returntablefield("customer", "ROWID", $fields['value']['ROWID'], "sysuser");
	
	if(ifHasRoleUser($userid) || $userid=="")
	{
		global $db;
		print "<TR><TD class=TableData noWrap>�鿴Ȩ��:</TD><TD class=TableData noWrap>\n";
		$sql="select * from customerbelong";
		if($_SESSION['LOGIN_USER_PRIV']=='3' || $fields['value']['datascope']=='')
			$sql.=" where id>0";
		$rs=$db->Execute($sql);
		$rs_a=$rs->GetArray();
	
		$check='';
		if($fields['value']['datascope']=='')
			$fields['value']['datascope']=1;
		
		for($j=0;$j<sizeof($rs_a);$j++)
		{
			if($rs_a[$j]['id']==$fields['value']['datascope'])
				$check='checked';
			else
				$check='';
	
				print "<input type='radio' name='datascope' id='datascope' value='".$rs_a[$j]['id']."' ".$check." ".$readonly.">".$rs_a[$j]['name'];
			
		}
		print "</td></tr>";
	}
	else 
		print "<input type='hidden' name='datascope' id='datascope' value='".$fields['value']['datascope']."'>";
}


?>
