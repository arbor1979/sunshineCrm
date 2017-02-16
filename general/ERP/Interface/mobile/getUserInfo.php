<?php

function getUserInfo($params)
{
	global $db,$MYSQL_DB;
	
	$result=array();
	$UID=intval($params['用户较验码']['0']);
	$UTYPE=intval($params['用户较验码']['2']);
	$destUID=$params['uid'];
	$userType=$params['userType'];

	if(empty($destUID))
		throw new Exception('用户ID不能为空');
	if($userType>0)//获得员工资料
	{
		$result=getUserByUseridOrID('',$destUID);
		$result['字段顺序']="性别,单位,部门,手机,登录时间";
	}
	else if($userType==0)//获得客户资料
	{
		$result=getCustomerInfo($destUID);
		$result['字段顺序']="会员卡,手机,地址,预储值,积分,隶属人,创建时间,最近交易";
		if($UTYPE>0)
			$result['字段顺序'].=",查看权限,退货率,最低折扣";
	}
	else if($userType==-1)//获得产品资料
	{
		$productObj=getProductByprodid($destUID);
		$result['姓名']=$productObj['productid'];
		$result['角色名称']=$productObj['productname'];
		$result['单位']=$productObj['measureid'];
		$result['颜色']=$productObj['colorname'];
		$result['规格']=$productObj['mode'];
		$result['商品类型']=$productObj['producttypename'];
		$result['零售价']=number_format($productObj['sellprice'],2);
		$result['VIP会员价']=number_format($productObj['sellprice2'],2);
		$result['白金会员价']=number_format($productObj['sellprice3'],2);
		if($productObj['fileaddress']=='')
			$productObj['fileaddress']=getCurPath()."/images/gift.png";
		$result['用户头像']=$productObj['fileaddress'];
		$result['原厂码']=$productObj['oldproductid'];
		$result['供应商']=$productObj['supplyname'];
		$result['钻石会员价']=number_format($productObj['sellprice5'],2);
		$result['字段顺序']="单位,颜色,规格,商品类型,零售价,VIP会员价,白金会员价,钻石会员价";
		if($UTYPE>0)
		{
			$sql="select sum(num) from store where prodid=?";
			$kucun=$db->GetOne($sql,array($destUID));
			$result['库存']=$kucun;
			$result['字段顺序'].=",原厂码,供应商,库存";
		}
	}
	
	return $result;
}
?>