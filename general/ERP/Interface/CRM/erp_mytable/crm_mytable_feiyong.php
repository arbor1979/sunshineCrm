<?php
ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL);
error_reporting(E_WARNING | E_ERROR);




$user_id = $_SESSION['LOGIN_USER_ID'];
$dept_id= $_SESSION['LOGIN_DEPT_ID'];
$user_priv=$_SESSION['LOGIN_USER_PRIV'];
//$user_name = $_SESSION['LOGIN_USER_NAME'];
//$user_name = returntablefield(user,);
$module_desc = "费用支出";
$max_count = "4";
$module_body = "";

$sql = "select a.*,b.dept_id,b.user_priv from crm_feiyong_sq a inner join user b on a.录单员=b.user_id where (录单员='$user_id' and 是否审核<>'4') or ($user_priv='1' and 是否审核='1') or (b.dept_id=$dept_id and $user_priv<b.user_priv and 是否审核='1') order by 创建时间 desc limit 0,$max_count";

$rs = $db->CacheExecute(150,$sql);
$rs_a = $rs->GetArray();
$count = $max_count-count($rs_a);
if(count($rs_a)>0){


  for($i=0;$i<count($rs_a);$i++){
	
	 $单号 = $rs_a[$i]['单号'];
	 $feiyongname=returntablefield("feiyongtype","id", $rs_a[$i]['费用类型'], "typename");
	 $shenhe='未审核';
	 if($user_priv=='1' || $dept_id==$rs_a[$i]['dept_id'] && $user_priv<$rs_a[$i]['user_priv'])
	 	$shenhe="<a href=../crm_feiyong_sq_newai.php?".base64_encode("action=init_default_search&searchfield=单号&searchvalue=$单号")." target=_blank>未审核</a>";
	 if($rs_a[$i]['是否审核']==2)
	 	$shenhe='<font color=green>同意</font>';
	 else if($rs_a[$i]['是否审核']==3)
	 	$shenhe='<font color=red>否决</font>';
	 $customerName=returntablefield("customer", "rowid",$rs_a[$i]['客户名称'] , "supplyname");
	 if(cutStr($customerName,6)!=$customerName)
	 {
	 	$title=$customerName;
	   	 $customerName=cutStr($customerName,6)."..";
	 }
	 $module_body .= "<tr class=TableBlock>
						<td nowrap valign=Middle align=left>
						<img src=\"../images/arrow_r.gif\" align=\"absmiddle\"><a href=../../JXC/customer_newai.php?".base64_encode("action=view_default&ROWID=".$rs_a[$i]['客户名称'])." target=_blank title='$title'>".$customerName."</td>
						<td nowrap valign=Middle align=left><a href=../crm_feiyong_sq_newai.php?".base64_encode("action=view_default&单号=$单号")." target=_blank>金额:".$rs_a[$i]['金额']."</a></td>
						<td nowrap valign=Middle align=right>$shenhe</td>
						<td nowrap valign=Middle align=right>".$feiyongname."</td>
						<td nowrap valign=Middle align=right>".$rs_a[$i]['创建时间']."</td>
					  </tr>";

     //$module_body .= "<li>".$boolen."&nbsp;".$rs_a[$i]['客户名称']."&nbsp;<font color=green><a href=crm_expense_person_newai.php?action=view_default&编号=$编号; title=".$费用单号.">".$rs_a[$i]['费用沟通概述']."</a></font>(".$rs_a[$i]['创建时间'].")</li>";
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
					&nbsp;暂无费用!</font></td>";
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
					function plan_detail(编号)
					{
						URL='crm_expense_person_newai.php?action=view_default&编号='+编号;
						myleft=(screen.availWidth-500)/2; window.open(URL,'read_work_plan','height=500,width=600,status=1,toolbar=no,menubar=no,location=no,scrollbars=yes,top=120,left='+myleft+',resizable=yes');
					}
				</script>";
*/
echo $module_body;
?>

<?php
/*
	版权归属:郑州单点科技软件有限公司;
	联系方式:0371-69663266;
	公司地址:河南郑州经济技术开发区第五大街经北三路通信产业园四楼西南;
	公司简介:郑州单点科技软件有限公司位于中国中部城市-郑州,成立于2007年1月,致力于把基于先进信息技术（包括通信技术）的最佳管理与业务实践普及到教育行业客户的管理与业务创新活动中，全面提供具有自主知识产权的教育管理软件、服务与解决方案，是中部最优秀的高校教育管理软件及中小学校管理软件提供商。目前已经有多家高职和中职类院校使用通达中部研发中心开发的软件和服务;

	软件名称:单点科技软件开发基础性架构平台,以及在其基础之上扩展的任何性软件作品;
	发行协议:数字化校园产品为商业软件,发行许可为LICENSE方式;单点CRM系统即SunshineCRM系统为GPLV3协议许可,GPLV3协议许可内容请到百度搜索;
	特殊声明:软件所使用的ADODB库,PHPEXCEL库,SMTARY库归原作者所有,余下代码沿用上述声明;
	*/
?>