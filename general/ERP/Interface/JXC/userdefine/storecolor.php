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

function storecolor_value( $fieldvalue, $fields, $i )
{
	$storeinfo=returntablefield("store", "id", $fields['value'][$i]['id'], "prodid,storeid");
	$prodid=$storeinfo['prodid'];
	$storeid=$storeinfo['storeid'];
	
		$ifcolor=returntablefield("product", "productid",$prodid, "hascolor");
	
		if($ifcolor=="是")
		{
			$imgurl=ROOT_DIR."general/ERP/Framework/images/sepan.gif";
			$imggrayurl=ROOT_DIR."general/ERP/Framework/images/sepangray.gif";
			global $db;
			$sql="select sum(num) as allnum from store_color where id in (select id from store where prodid='$prodid' and storeid=$storeid)";
			$rs=$db->Execute($sql);
			$rs_a=$rs->GetArray();
			if(intval($rs_a[0]['allnum'])!=intval($fieldvalue))
				$imgurl=$imggrayurl;
        	$fieldvalue.= "<a href=\"javascript:ShowIframe('颜色分配','colorinput.php?tablename=store_color&id=".$fields['value'][$i]['id']."',600,200);\" title='颜色分配'><img src=$imgurl></a>";
		
		}
		return $fieldvalue;
}

?>
