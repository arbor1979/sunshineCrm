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
	
	$count = $valueVVVVVVV['显示行数']-count($ROW);
	
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
					&nbsp;暂无纪念日提醒!</font></td>";
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
	版权归属:郑州单点科技软件有限公司;
	联系方式:0371-69663266;
	公司地址:河南郑州经济技术开发区第五大街经北三路通信产业园四楼西南;
	公司简介:郑州单点科技软件有限公司位于中国中部城市-郑州,成立于2007年1月,致力于把基于先进信息技术（包括通信技术）的最佳管理与业务实践普及到教育行业客户的管理与业务创新活动中，全面提供具有自主知识产权的教育管理软件、服务与解决方案，是中部最优秀的高校教育管理软件及中小学校管理软件提供商。目前已经有多家高职和中职类院校使用通达中部研发中心开发的软件和服务;

	软件名称:单点科技软件开发基础性架构平台,以及在其基础之上扩展的任何性软件作品;
	发行协议:数字化校园产品为商业软件,发行许可为LICENSE方式;单点CRM系统即SunshineCRM系统为GPLV3协议许可,GPLV3协议许可内容请到百度搜索;
	特殊声明:软件所使用的ADODB库,PHPEXCEL库,SMTARY库归原作者所有,余下代码沿用上述声明;
	*/
?>
