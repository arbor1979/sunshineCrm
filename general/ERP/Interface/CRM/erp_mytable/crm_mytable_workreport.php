<?php
ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL);
error_reporting(E_WARNING | E_ERROR);




$user_id = $_SESSION['LOGIN_USER_ID'];
$dept_id= $_SESSION['LOGIN_DEPT_ID'];
$user_priv=$_SESSION['LOGIN_USER_PRIV'];
//$user_name = $_SESSION['LOGIN_USER_NAME'];
//$user_name = returntablefield(user,);
$module_desc = "����˹�������";
$max_count = "4";
$module_body = "";

$sql = "select a.*,b.USER_NAME,b.UID from workreport a inner join user b on a.createman=b.user_id where ($user_priv='1' and state='δ���') or (b.dept_id=$dept_id and $user_priv<b.user_priv and state='δ���') order by createtime desc limit 0,$max_count";

$rs = $db->CacheExecute(150,$sql);
$rs_a = $rs->GetArray();
$count = $max_count-count($rs_a);
if(count($rs_a)>0){


  for($i=0;$i<count($rs_a);$i++){
	
	 $id = $rs_a[$i]['id'];


	 $module_body .= "<tr class=TableBlock>
						<td nowrap valign=Middle align=left>
						<img src=\"../images/arrow_r.gif\" align=\"absmiddle\">[<a href=../../Framework/user_newai.php?".base64_encode("action=view_default&UID=". $rs_a[$i]['UID'])." target=_blank>". $rs_a[$i]['USER_NAME']."</a>]</td>
						<td nowrap valign=Middle align=left><a href=../../CRM/workreport_newai.php?".base64_encode("action=view_default&id=$id")." target=_blank>".$rs_a[$i]['workdate']."</a></td>
						<td nowrap valign=Middle align=right>".$rs_a[$i]['createtime']."</td>
						<td nowrap valign=Middle align=right><a href=../../CRM/workreport_newai.php?".base64_encode("action=shenhe&id=$id")." target=_blank>���</a></td>
						
					  </tr>";

     //$module_body .= "<li>".$boolen."&nbsp;".$rs_a[$i]['�ͻ�����']."&nbsp;<font color=green><a href=crm_expense_person_newai.php?action=view_default&���=$���; title=".$���õ���.">".$rs_a[$i]['���ù�ͨ����']."</a></font>(".$rs_a[$i]['����ʱ��'].")</li>";
  }

	for($i=0;$i<$count;$i++){
		$module_body .= "<tr class=TableBlock>
					<td valign=Middle align=left>&nbsp;
					</td>
					</tr>";
	}
}
$module_body = "<table border=\"0\"  width=\"100%\"  height=\"100%\" cellpadding=0 cellspacing=0>".$module_body;
if(count($rs_a)==0){
   $module_body .= "<tr class=\"TableBlock\">
					<td valign=\"Middle\" align=\"left\"><font color=\"red\">
					&nbsp;���޴���˹�������!</font></td>";
   	for($i=0;$i<$count-1;$i++){
		$module_body .= "<tr class=\"TableBlock\">
					<td valign=\"Middle\" align=\"left\">&nbsp;
					</td>
					</tr>";
	}
}
 $module_body .= "</table>";
/*
$module_body .= "<ul>
				<script>
					function plan_detail(���)
					{
						URL='crm_expense_person_newai.php?action=view_default&���='+���;
						myleft=(screen.availWidth-500)/2; window.open(URL,'read_work_plan','height=500,width=600,status=1,toolbar=no,menubar=no,location=no,scrollbars=yes,top=120,left='+myleft+',resizable=yes');
					}
				</script>";
*/
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