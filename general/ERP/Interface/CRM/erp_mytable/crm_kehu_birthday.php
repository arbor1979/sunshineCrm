<?php
ini_set('date.timezone','Asia/Shanghai');
	global $valueVVVVVVV;
	global $db;
	$MODULE_BODY = "";
	
	$CUR_DATE = date( "m-d", mktime(1,1,1,date('m'),date('d')-1,date('Y')));
	$END_DATE = date( "m-d", mktime(1,1,1,date('m'),date('d')+7,date('Y')));
		
	$COUNT1 = 0;
	$COUNT2 = 0;
	$BIRTHDAY_ARRAY1 = $BIRTHDAY_ARRAY2 = array( );
	$query = "	SELECT *,b.linkmanname,b.customerid from crm_remember a inner join linkman b on a.linkmanid=b.rowid where  DATE_FORMAT(mem_date,'%m-%d')>='$CUR_DATE'
				and DATE_FORMAT(mem_date,'%m-%d')<='$END_DATE'";
				$addquery =getCustomerRoleByCustID($addquery,"b.customerid");
				$query=$query.$addquery;

				//echo $query;exit;
	$rs = $db->CacheExecute(150,$query);
	$ROW = $rs->GetArray();
	
	$count = $valueVVVVVVV['��ʾ����']-count($ROW);
	
	for($i=0;$i<count($ROW);$i++)
	{
					            $linkmanid = $ROW[$i]['linkmanid'];
					            $linkmanname=$ROW[$i]['linkmanname'];
					            $mem_type=$ROW[$i]['mem_type'];
					            $customerName=returntablefield("customer","rowid",$ROW[$i]['customerid'],"supplyname");
								$BIRTHDAY  = $ROW[$i]['mem_date'];
								//echo $BIRTHDAY;
			if(cutStr($customerName,12)!=$customerName)
			 {
			 	$title=$customerName;
			   	 $customerName=cutStr($customerName,12)."..";
			 }
								++$COUNT2;
								$PERSON_STR2 .= "<tr class=TableBlock>
								<td nowrap><img src=\"../images/arrow_r.gif\" align=\"absmiddle\"><a href=../../JXC/customer_newai.php?action=view_default&ROWID=".$ROW[$i]['customerid']." target=_blank title='$title'>".$customerName."</td>
								<td nowrap><a href=../../JXC/linkman_newai.php?action=view_default&ROWID=".$ROW[$i]['linkmanid']." target=_blank>".$linkmanname."</td>
								<td nowrap>".$mem_type."(".date( "m-d", strtotime($BIRTHDAY) ).")</td>
								<td nowrap valign=Middle align=left><a href='../../JXC/sms_sendlist_newai.php?action=add_default&sendlist=".$ROW[$i]['linkmanid']."' target='_blank'><img src='../../../Framework/images/menu/010401.gif' align=absmiddle></a></td></tr>";
				}
				
for($i=0;$i<$count;$i++){
		$PERSON_STR2 .= "<tr class=\"TableBlock\">
					<td valign=\"Middle\" align=\"left\">&nbsp;
					</td>
					</tr>";
	}


				$MODULE_BODY .= "<table border=\"0\"  width=\"100%\"  height=\"100%\">";

				if ( 0 < $COUNT2 )
				{
								$MODULE_BODY .= $PERSON_STR2;
				}
				else
				{
				
   					$MODULE_BODY .= "<tr class=\"TableBlock\">
					<td valign=\"Middle\" align=\"left\"><font color=\"red\">
					&nbsp;���޼���������!</font></td>";
   					for($i=0;$i<$count-1;$i++){
					$MODULE_BODY .= "<tr class=\"TableBlock\">
					<td valign=\"Middle\" align=\"left\">&nbsp;
					</td>
					</tr>";
					}
				}
				
                $MODULE_BODY .= "</table>";
echo $MODULE_BODY;
//}
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
