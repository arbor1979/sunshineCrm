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

function accessbank_value( $fieldvalue, $fields, $i )
{
		$id=$fields['value'][$i]['编号'];
		$opertype = returntablefield( "accessbank", "id", $id, "opertype" );
		$parent = returntablefield( "accesstype", "name", $opertype, "parent" );
		$parentname = returntablefield( "accesstype", "id", $parent, "name" );
		$colorValue = setColorByName($fieldvalue);
		if($parentname=='货款')
		{
			if($opertype=='货款支付')
			{
				$billinfo = returntablefield( "buyplanmain", "billid", $fieldvalue, "zhuti,billid" );
				$fieldvalue="<a href='buyplanmain_newai.php?action=view_default&billid=".$billinfo['billid']."' target='_blank'><font color=$colorValue>".$billinfo['zhuti']."</font></a>";
			}
			else
			{
				$billinfo = returntablefield( "sellplanmain", "billid", $fieldvalue, "zhuti,billid" );
				$fieldvalue="<a href='sellplanmain_newai.php?action=view_default&billid=".$billinfo['billid']."' target='_blank'><font color=$colorValue>".$billinfo['zhuti']."</font></a>";
			}
		}
		else if($parentname=='预收预付')
		{
			if($opertype=='预收货款')
			{
				$fieldvalue="<a href='accesspreshou_newai.php?action=view_default&id=".$fieldvalue."' target='_blank'><font color=$colorValue>".$opertype."-".$fieldvalue."</font></a>";
			}
			else 
			{
				$fieldvalue="<a href='accessprepay_newai.php?action=view_default&id=".$fieldvalue."' target='_blank'><font color=$colorValue>".$opertype."-".$fieldvalue."</font></a>";
			}
			
		}
		else if($opertype=='其他收入')
		{
			$fieldvalue="<a href='v_shoururecord_newai.php?action=view_default&billid=".$fieldvalue."' target='_blank'><font color=$colorValue>".$opertype."-".$fieldvalue."</font></a>";
		}
		else if($opertype=='费用支出')
		{
			$fieldvalue="<a href='v_feiyongrecord_newai.php?action=view_default&billid=".$fieldvalue."' target='_blank'><font color=$colorValue>".$opertype."-".$fieldvalue."</font></a>";
		}
		else if($opertype=='资金注入' || $opertype=='资金抽取')
		{
			$fieldvalue="<a href='bankzhuru_newai.php?action=view_default&billid=".$fieldvalue."' target='_blank'><font color=$colorValue>".$opertype."-".$fieldvalue."</font></a>";
		}
		else if($opertype=='账户间转款')
		{
			$fieldvalue="<a href='banktobank_newai.php?action=view_default&id=".$fieldvalue."' target='_blank'><font color=$colorValue>".$opertype."-".$fieldvalue."</font></a>";
		}
		else
			$fieldvalue=$parentname."单-".$fieldvalue;
		return $fieldvalue;
}

function accessbank_value_PRIV( $fieldvalue, $fields, $i )
{
				
}

?>
