<?php

ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL);
error_reporting(E_WARNING | E_ERROR);


$module_desc = "Ӧ�տ�";

$user_id = $_SESSION['LOGIN_USER_ID'];
$dept_id= $_SESSION['LOGIN_DEPT_ID'];
$user_priv=$_SESSION['LOGIN_USER_PRIV'];

$max_count = "4";
$module_body = "";

$sql = "select * from v_yingshoukuanhuizong where 1=1 ";
$sql=getCustomerRoleByCustID($sql,"rowid");
$sql=$sql." order by pay_own desc limit 0 ,$max_count";
$rs = $db->Execute($sql);
$rs_a = $rs->GetArray();
$count = $max_count-count($rs_a);
$module_body .= "<table border=\"0\"  width=\"100%\">";
if(count($rs_a)>0){
   for($i=0;$i<count($rs_a);$i++){
       
	   $rowid = $rs_a[$i]['rowid'];
	   $num = $rs_a[$i]['num'];
	   $supplyname=$rs_a[$i]['supplyname'];
	   $own=number_format($rs_a[$i]['own'],2);
	   $huikuan=number_format($rs_a[$i]['huikuanjine'],2);
	   $pay_own=number_format($rs_a[$i]['pay_own'],2);
	   if(cutStr($supplyname,6)!=$supplyname)
	   {
	   	 $title=$supplyname;
	   
	   	 $supplyname=cutStr($supplyname,6)."..";
	   }
	   $module_body .= "<tr class=\"TableBlock\">
	   					<td nowrap><img src=\"../images/arrow_r.gif\" align=\"absmiddle\"><a href=../../JXC/customer_newai.php?".base64_encode("action=view_default&ROWID=".$rs_a[$i]['rowid'])." target=_blank title='$title'>".$supplyname."</td>
						<td nowrap><a href='../../JXC/v_yingshoukuanhuizong_mingxi.php?".base64_encode("supplyid=$rowid")."' target='_blank'>����:".$num."</a></td>
						<td nowrap valign=\"Middle\" align=\"left\">���:".$own."</td>
						<td nowrap valign=\"Middle\" align=\"left\">�ؿ�:".$huikuan."</td>
						<td nowrap valign=\"Middle\" align=\"left\">��Ƿ:".$pay_own."</td>
					  </tr>";

       //$module_body .= "<li>".$boolen."&nbsp;".$rs_a[$i]['�ͻ�����']."&nbsp;<font color=green><a href=crm_service_person_newai.php?action=view_default&���=$���; title=".$������.">".$rs_a[$i]['�������']."</a></font>(<font color=green>[".$rs_a[$i]['����׶�']."]</font>".$rs_a[$i]['����ʱ��'].")</li>";
   }

	for($i=0;$i<$count;$i++){
		$module_body .= "<tr class=\"TableBlock\">
					<td valign=\"Middle\" align=\"left\">&nbsp;
					</td>
					</tr>";
	}
}

if(count($rs_a)==0){
   $module_body .= "<tr class=\"TableBlock\">
					<td valign=\"Middle\" align=\"left\"><font color=\"red\">
					&nbsp;����Ӧ�տ�!</font></td>";
   	for($i=0;$i<$count-1;$i++){
		$module_body .= "<tr class=\"TableBlock\">
					<td valign=\"Middle\" align=\"left\">&nbsp;
					</td>
					</tr>";
	}
}
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
