<?php

ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL);
error_reporting(E_WARNING | E_ERROR);


$module_desc = "������";

$user_id = $_SESSION['LOGIN_USER_ID'];
$dept_id= $_SESSION['LOGIN_DEPT_ID'];
$user_priv=$_SESSION['LOGIN_USER_PRIV'];

$max_count = "4";
$module_body = "";

$sql = "select * from workplanmain where state<>'2' and zhixingren like '%".$user_id.",%' and not EXISTS (select * from workplanmain_detail where workplanmain_detail.mainrowid=workplanmain.id and createman='$user_id' and result=1)";
$sql=$sql." order by createtime desc limit 0 , $max_count";
$rs = $db->CacheExecute(150,$sql);
$rs_a = $rs->GetArray();
$count = $max_count-count($rs_a);
$module_body .= "<table border=\"0\"  width=\"100%\">";
if(count($rs_a)>0){
   for($i=0;$i<count($rs_a);$i++){
       
	   $id = $rs_a[$i]['id'];
	   $createman=$rs_a[$i]['createman'];
	   $zhuti=$rs_a[$i]['zhuti'];
	   $createtime=$rs_a[$i]['createtime'];
	   $userinfo=returntablefield("user", "user_id", $createman, "uid,user_name");
	   $UID=$userinfo['uid'];
	   $username=$userinfo['user_name'];
	   if(cutStr($zhuti,12)!=$zhuti)
	   {
	   	 $title=$zhuti;
	   	 $zhuti=cutStr($zhuti,12)."..";
	   }
	   $module_body .= "<tr class=\"TableBlock\">
						<td nowrap><img src=\"../images/arrow_r.gif\" align=\"absmiddle\"><a target='_blank' href='../../Framework/user_newai.php?".base64_encode("action=view_default&UID=".$UID)."' >".$username."</a></td>
						<td nowrap valign=\"Middle\" align=\"left\"><a target='_blank' href='../../CRM/workplanmain_newai.php?".base64_encode("action=view_default&id=".$id)."' title='$title'>".$zhuti."</a></td>
						<td nowrap valign=\"Middle\" align=\"right\">".$createtime."</td>
						<td nowrap valign=\"Middle\" align=\"right\"><a href='../../CRM/workplanmain_detail_newai.php?action=add_default&mainrowid=".$id."' target='_blank'>ִ��</a></td>
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
					&nbsp;����������!</font></td>";
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
