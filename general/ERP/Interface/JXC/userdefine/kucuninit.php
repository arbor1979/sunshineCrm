<?php
/*
版权归属:郑州单点科技软件有限公司;
联系方式:0371-69663266;
公司地址:河南郑州经济技术开发区第五大街经北三路通信产业园四楼西南;
公司简介:郑州单点科技软件有限公司位于中国中部城市-郑州,成立于2007年1月,致力于把基于先进信息技术（包括通信技术）的最佳管理与业务实践普及到教育行业客户的管理与业务创新活动中，全面提供具有自主知识产权的教育管理软件、服务与解决方案，是中部最优秀的高校教育管理软件及中小学校管理软件提供商。目前己经有多家高职和中职类院校使用通达中部研发中心开发的软件和服务;

软件名称:单点科技软件开发基础性架构平台,以及在其基础之上扩展的任何性软件作品;
发行协议:数字化校园产品为商业软件,发行许可为LICENSE方式;单点CRM系统即SunshineCRM系统为GPLV3协议许可,GPLV3协议许可内容请到百度搜索;
特殊声明:软件所使用的ADODB库,PHPEXCEL库,SMTARY库归原作者所有,余下代码沿用上述声明;
*/

function kucuninit_value( $fieldvalue, $fields, $i )
{
				global $db;
				global $tablename;
				global $html_etc;
				global $common_html;
				global $SYSTEM_PRIV_ROW;
				$Text = "";
				$storeid=$fields['value'][$i]['ROWID'];
				$sql="select count(distinct prodid) as c,sum(num) as n from store where storeid=$storeid";
				$rs=$db->Execute($sql);
				$rs_a = $rs->GetArray();
				if($rs_a[0]['c']==0)
					$Text="无产品";
				else
					$Text=$rs_a[0]['c']."种产品，共".$rs_a[0]['n']."件";
				return $Text;
}

function kucuninit_value_PRIV( $fieldvalue, $fields, $i )
{
				global $db;
				global $tablename;
				global $html_etc;
				global $common_html;
				$SYSTEM_STOP_ROW['shenhe_priv'] = 1;
				$SYSTEM_STOP_ROW['flow_priv'] = 1;
				$SYSTEM_STOP_ROW['delete_priv'] = 1;
				$SYSTEM_STOP_ROW['edit_priv'] = 1;
				$storeid=$fields['value'][$i]['ROWID'];
				$sql="select * from store_init where storeid=$storeid and flag=1";
				$rs=$db->Execute($sql);
				$rs_a = $rs->GetArray();
				$sql="select * from store where storeid=$storeid and num<>0";
				$rs=$db->Execute($sql);
				$rs_b = $rs->GetArray();
				$userid = returntablefield( "stock", "rowid", $storeid, "user_id" );
				$useridArray=explode(",", $userid);
				if(sizeof($rs_a)==0 && sizeof($rs_b)==0 && in_array($_SESSION['LOGIN_USER_ID'], $useridArray))
				{
					$SYSTEM_STOP_ROW['shenhe_priv'] = 0;
					
				}	
				if(sizeof($rs_a)>0)
				{
					$SYSTEM_STOP_ROW['flow_priv'] = 0;
				}
				
				return $SYSTEM_STOP_ROW;
}

?>
