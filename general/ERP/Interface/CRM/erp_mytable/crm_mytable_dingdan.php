<?php
ini_set('display_errors',1);
ini_set('error_reporting',E_ALL);
error_reporting(E_WARNING | E_ERROR);




$user_id = $_SESSION['LOGIN_USER_ID'];
$module_desc = "CRM���涩��";
$max_count = "4";
$module_body = "";

$sql = "select * from crm_order where ������='".$user_id."' order by ����ʱ�� desc limit 0 , $max_count";
$rs = $db->CacheExecute(150,$sql);
$rs_a = $rs->GetArray();
$count = $max_count-count($rs_a);
$module_body .= "<table border=0 class=TableBlock width=100% height=100%>";
$module_body .= "<tr align=\"left\" class=\"TableHeader\"><td colspan=10>&nbsp;<a href=\"../crm_order_person_newai.php\" title=\"CRM��������\">".$module_desc."</a></td></tr>";
if(count($rs_a)>0){
   for($i=0;$i<count($rs_a);$i++){
       if($rs_a[$i]['�Ƿ����'] == "��"){
	      $boolen = "<img src=\"../images/right.gif\" align=\"absmiddle\">";
	   }
	   if($rs_a[$i]['�Ƿ����'] == "��"){
	      $boolen = "<img src=\"../images/error.gif\" align=\"absmiddle\">";
	   }

	   $���     = $rs_a[$i]['���'];
	   $������� = '���ţ�'.$rs_a[$i]['�������'];
       $module_body .= "<tr class=TableBlock>
						<td valign=Middle align=left>
						<img src=\"../images/arrow_r.gif\" align=\"absmiddle\">&nbsp;
                        ".$boolen."&nbsp;".$rs_a[$i]['�ͻ�����']."</td>
						<td valign=Middle align=left><font color=green><font color=green><a href=../crm_order_person_newai.php?action=view_default&���=$���; title=".$�������.">".$rs_a[$i]['��Ʒ����']."</a></font></td>
						<td valign=Middle align=left><font color=green>[".$rs_a[$i]['���۲���']."]</font></td>
						<td valign=Middle align=right>".$rs_a[$i]['��������']."</td>
					  </tr>";
   }
   for($i=0;$i<$count;$i++){
	 $module_body .= "<tr class=TableBlock>
				<td valign=Middle align=left>&nbsp;
				</td>
				</tr>";
   }
}

if(count($rs_a)==0){
   $module_body .= "<tr class=TableBlock>
						<td valign=Middle align=left><font color=red>
						<img src=\"../images/arrow_r.gif\" align=\"absmiddle\">&nbsp;
                        ���޷����¼!</font></td>";
   for($i=0;$i<3;$i++){
	 $module_body .= "<tr class=TableBlock>
				<td valign=Middle align=left>&nbsp;
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