<?php

function searchForValue($params)
{
	global $db;
	
	$result=array();
	$UID=intval($params['用户较验码']['0']);
	$UTYPE=intval($params['用户较验码']['2']);
	$destUID=$params['uid'];
	$userType=$params['userType'];
	$searchType=$params['searchType'];
	$searchValue=$params['searchValue'];
	if(empty($searchType) || empty($searchValue))
		throw new Exception('查询参数不能为空');

	if($searchType=='customer')
	{
		$sql="select * from customer where membercard = '".$searchValue."' or supplyname like '%".$searchValue."%'";
		$rs_a=$db->GetAll($sql);
		$count=sizeof($rs_a);
		if($count>5)
			throw new Exception('请缩小查找范围');
		else if($count==0)
			throw new Exception('没有找到匹配的记录');
		else if($count==1)
		{
			$result['count']=1;
			$result['value']=$rs_a[0]['ROWID'];
		}
		else
		{
			$result['count']=$count;
			$result['value']=array();
			foreach((array)$rs_a as $item)
			{
				$value=array();
				$value['key']=$item['ROWID'];
				$value['value']=$item['supplyname']."[".$item['membercard']."]";
				$result['value'][]=$value;
			}
		}
	}
	else if($searchType=='product')
	{
		$sql="select * from product where productid like '%".$searchValue."%' or oldproductid like '%".$searchValue."%'";
		$rs_a=$db->GetAll($sql);
		$count=sizeof($rs_a);
		if($count>5)
			throw new Exception('请缩小查找范围');
		else if($count==0)
			throw new Exception('没有找到匹配的记录');
		else if($count==1)
		{
			$result['count']=1;
			$result['value']=$rs_a[0]['productid'];
		}
		else
		{
			$result['count']=$count;
			$result['value']=array();
			foreach((array)$rs_a as $item)
			{
				$value=array();
				$value['key']=$item['productid'];
				$value['value']=$item['productid']."[".$item['oldproductid']."]￥".$item['sellprice'];
				$result['value'][]=$value;
			}
		}
	}
	return $result;
}
?>