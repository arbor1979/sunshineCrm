<?php
ini_set('display_errors',1);
ini_set('error_reporting',E_ALL);
error_reporting(E_WARNING | E_ERROR);


$user_id = $_SESSION['LOGIN_USER_ID'];
$dept_id= $_SESSION['LOGIN_DEPT_ID'];
$user_priv=$_SESSION['LOGIN_USER_PRIV'];
$module_desc = "�ͻ�����";
$max_count = "4";
$module_body = "";

$sql = "select * from crm_service where (���س̶�='2' or ���س̶�='3') ";
$sql=getRoleByUser($sql,"������");
$sql=$sql." order by ����ʱ�� desc limit 0 , $max_count";
$rs = $db->CacheExecute(150,$sql);
$rs_a = $rs->GetArray();
$count = $max_count-count($rs_a);
$module_body .= "<table border=\"0\"  width=\"100%\">";
if(count($rs_a)>0){
   for($i=0;$i<count($rs_a);$i++){
       

	   $���     = $rs_a[$i]['���'];
	   $������ = '���ţ�'.$rs_a[$i]['������'];
	   $customerName=returntablefield("customer", "rowid",$rs_a[$i]['�ͻ�����'] , "supplyname");
	   $servicetype=returntablefield("crm_dict_servicetypes", "���",$rs_a[$i]['������'] , "����");
	   $servicestate=returntablefield("crm_dict_servicestatus", "���",$rs_a[$i]['���س̶�'] , "����");
	   if($rs_a[$i]['���س̶�']==2)
	   		$servicestate="<font color=red>".$servicestate."</font>";
	   if($rs_a[$i]['���س̶�']==3)
	   		$servicestate="<font color=blue>".$servicestate."</font>";	
	   $userinfo=returntablefield("user", "USER_ID",$rs_a[$i]['������'] , "USER_NAME,UID");
	   if(cutStr($customerName,6)!=$customerName)
	   {
	   	$title=$customerName;
	   	 $customerName=cutStr($customerName,6)."..";
	   }
	   $module_body .= "<tr class=\"TableBlock\">
						<td nowrap><img src=\"../images/arrow_r.gif\" align=\"absmiddle\"><a href=../../JXC/customer_newai.php?".base64_encode("action=view_default&ROWID=".$rs_a[$i]['�ͻ�����'])." target=_blank title='$title'>".$customerName."</td>
						<td nowrap valign=\"Middle\" align=\"right\">".$servicetype."</td>
						<td nowrap valign=\"Middle\" align=\"right\"><a href=../../JXC/crm_service_newai.php?".base64_encode("action=init_default_search&searchfield=���&searchvalue=".$���)." target=_blank>".$servicestate."</a></td>
						<td nowrap valign=Middle align=right>[<a href=../../Framework/user_newai.php?".base64_encode("action=view_default&UID=".$userinfo['UID'])." target=_blank>".$userinfo['USER_NAME']."</a>]</td>
						<td nowrap valign=\"Middle\" align=\"right\">".$rs_a[$i]['����ʱ��']."</td>
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
					&nbsp;���޷����¼!</font></td>";
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