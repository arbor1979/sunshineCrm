<?php

ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL);
error_reporting(E_WARNING | E_ERROR);


$module_desc = "CRM�����";

$user_id = $_SESSION['LOGIN_USER_ID'];
$dept_id= $_SESSION['LOGIN_DEPT_ID'];
$user_priv=$_SESSION['LOGIN_USER_PRIV'];

$max_count = "4";
$module_body = "";

$sql = "select * from stockinmain where state='δ���'";
$sql=getKucunOperByUserid($sql,$_SESSION['LOGIN_USER_ID']);
$sql=$sql." order by billid limit 0 , $max_count";
$rs = $db->CacheExecute(150,$sql);
$rs_a = $rs->GetArray();

$count = $max_count-count($rs_a);
$module_body .= "<table border=\"0\"  width=\"100%\">";
if(count($rs_a)>0){
   for($i=0;$i<count($rs_a);$i++){
       
       $billid     = $rs_a[$i]['billid']; 
	   $state=$rs_a[$i]['state'];
	   $createtime=$rs_a[$i]['createtime'];
   	   $outtype=$rs_a[$i]['intype'];	
 
	   $custUrl='';
   		if($outtype=="�˻����")	
   		{
   			
			$sellinfo =returntablefield("sellplanmain","billid",$rs_a[$i]['caigoubillid'],"supplyid,zhuti,billtype");
			$supplyid=$sellinfo['supplyid'];
		    $zhuti=$sellinfo['zhuti'];
		    $billtype=$sellinfo['billtype'];
		    $url="sellplanmain_newai.php";
		    if($billtype==3)
		   	  $url="v_sellone_search_newai.php";
			$customerName=returntablefield("customer", "rowid", $supplyid, "supplyname");
			$custUrl="../../JXC/customer_newai.php?".base64_encode("action=view_default&ROWID=".$supplyid);
		
   		}
		else if($outtype=='�ɹ����')
		{
			
			$sellinfo=returntablefield("buyplanmain", "billid", $rs_a[$i]['caigoubillid'], "supplyid,zhuti");
			$supplyid=$sellinfo['supplyid'];
		    $zhuti=$sellinfo['zhuti'];
			$customerName=returntablefield("supply", "rowid", $supplyid, "supplyname");
			$custUrl="../../JXC/supply_newai.php?".base64_encode("action=view_default&ROWID=".$supplyid);
			$url="buyplanmain_newai.php";
		   
		
		}
		if(cutStr($customerName,6)!=$customerName)
		{
			$title=$customerName;
	   	 	$customerName=cutStr($customerName,6)."..";
		}
	   $module_body .= "<tr class=\"TableBlock\">
						<td nowrap><img src=\"../images/arrow_r.gif\" align=\"absmiddle\"><a href='$custUrl' target=_blank title='$title'>".$customerName."</td>
						<td nowrap valign=\"Middle\" align=\"right\"><a href=../../JXC/$url?".base64_encode("action=view_default&billid=".$rs_a[$i]['caigoubillid'])." target=_blank>".$zhuti."</a></td>
						<td nowrap valign=\"Middle\" align=\"right\"><a href=../../JXC/stockinmain_newai.php?action=init_default_search&searchfield=billid&searchvalue=".$billid." target=_blank>".$state."</a></td>
						<td nowrap valign=\"Middle\" align=\"right\">".$createtime."</td>
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
					&nbsp;���޴�����¼!</font></td>";
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
