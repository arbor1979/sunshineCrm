<?php

ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL);
error_reporting(E_WARNING | E_ERROR);


$module_desc = "公告通知";

$user_id = $_SESSION['LOGIN_USER_ID'];
$dept_id= $_SESSION['LOGIN_DEPT_ID'];
$user_priv=$_SESSION['LOGIN_USER_PRIV'];

$max_count = "4";
$module_body = "";

$sql = "select * from message where flag='0' and userid='$user_id'";
$sql=$sql." and (attime is null or attime<now()) order by createtime desc limit 0 , $max_count";
$rs = $db->CacheExecute(150,$sql);
$rs_a = $rs->GetArray();
$count = $max_count-count($rs_a);
$module_body .= "<table border=\"0\"  width=\"100%\">";
if(count($rs_a)>0){
   for($i=0;$i<count($rs_a);$i++){
       
	   $id = $rs_a[$i]['id'];
	   $msgtype=$rs_a[$i]['msgtype'];
	   $content=$rs_a[$i]['content'];
	   $title=$content;
	   if(cutStr($content,20)!=$content)
	   		$content=cutStr($content,20)."..";
	   else 
	   		$title="";
	   $createtime=$rs_a[$i]['createtime'];
	   $url=$rs_a[$i]['url'];
	  
	   $module_body .= "<tr class=\"TableBlock\">
						<td nowrap><img src=\"../images/arrow_r.gif\" align=\"absmiddle\"><a href=../".$url." target=_blank ".(strlen($title)>0?"title=$title":"").">".$content."</td>
						<td nowrap valign=\"Middle\" align=\"right\">".$msgtype."</td>
						<td nowrap valign=\"Middle\" align=\"right\"><font color=red>未读</font></td>
						<td nowrap valign=\"Middle\" align=\"right\">".$createtime."</td>
					  </tr>";

       //$module_body .= "<li>".$boolen."&nbsp;".$rs_a[$i]['客户名称']."&nbsp;<font color=green><a href=crm_service_person_newai.php?action=view_default&编号=$编号; title=".$服务编号.">".$rs_a[$i]['服务概述']."</a></font>(<font color=green>[".$rs_a[$i]['服务阶段']."]</font>".$rs_a[$i]['创建时间'].")</li>";
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
					&nbsp;暂无消息通知!</font></td>";
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
	版权归属:郑州单点科技软件有限公司;
	联系方式:0371-69663266;
	公司地址:河南郑州经济技术开发区第五大街经北三路通信产业园四楼西南;
	公司简介:郑州单点科技软件有限公司位于中国中部城市-郑州,成立于2007年1月,致力于把基于先进信息技术（包括通信技术）的最佳管理与业务实践普及到教育行业客户的管理与业务创新活动中，全面提供具有自主知识产权的教育管理软件、服务与解决方案，是中部最优秀的高校教育管理软件及中小学校管理软件提供商。目前已经有多家高职和中职类院校使用通达中部研发中心开发的软件和服务;

	软件名称:单点科技软件开发基础性架构平台,以及在其基础之上扩展的任何性软件作品;
	发行协议:数字化校园产品为商业软件,发行许可为LICENSE方式;单点CRM系统即SunshineCRM系统为GPLV3协议许可,GPLV3协议许可内容请到百度搜索;
	特殊声明:软件所使用的ADODB库,PHPEXCEL库,SMTARY库归原作者所有,余下代码沿用上述声明;
	*/
?>
