<?php

function module_formalBill($params)
{
	global $db;
	//$db->debug=true;
	$result=array();
	$UID=$params['用户较验码']['0'];
	$UName=$params['用户较验码']['1'];
	$UType=$params['用户较验码']['2'];
	$UDeptid=$params['用户较验码']['3'];
	$action=$params['action'];
	if(empty($action))
	{

		$sql="select * from v_sellone_search where 1=1";

		$sql =getRoleByUser($sql,"user_id",$UDeptid,$UType,$UName);
		$createtime=$params['createtime'];
		if(empty($createtime) || $createtime=='今天')
			$starttime=date("Y-m-d");
		else if($createtime=='最近三天')
			$starttime=date("Y-m-d",mktime(0,0,1,date("m"),date("d")-3,date("Y")));
		else if($createtime=='最近一周')
			$starttime=date("Y-m-d",mktime(0,0,1,date("m"),date("d")-7,date("Y")));
		else if($createtime=='最近一月')
			$starttime=date("Y-m-d",mktime(0,0,1,date("m")-1,date("d"),date("Y")));
		else if($createtime=='最近半年')
			$starttime=date("Y-m-d",mktime(0,0,1,date("m")-6,date("d"),date("Y")));
		else if($createtime=='全部')
			$starttime='';

		if($starttime!='')
			$sql.=" and createtime>'".$starttime."'";
		$billid=$params['billid'];
		if($billid!='')
			$sql.=" and billid='".$billid."'";
		$customerName=$params['customerName'];
		if($customerName!='')
			$sql.=" and supplyid in (select rowid from customer where supplyname like '%$customerName%' or membercard='$customerName')";
		$user_id=$params['user_id'];
		if($user_id!='')
			$sql.=" and user_id=(select USER_ID from user where USER_NAME='$user_id')";
		$qianyueren=$params['qianyueren'];
		if($qianyueren!='')
			$sql.=" and qianyueren=(select USER_ID from user where USER_NAME='$qianyueren')";

		$sql.=" order by billid desc";
		//echo $sql;exit;
		$rs_a=$db->GetAll($sql);
		$result['标题显示']='正式单';
		$result['右上按钮']='过滤';
		$result['右上按钮URL']='?action=filter&search=bill&function=module_formalBill';
		$result['成绩数值']=array();
		$allmoney=0;
		$alloddment=0;
		$alltuihuo=0;
		$allzengpin=0;
		foreach((array)$rs_a as $item)
		{

			$billInfo=array();
			if($item['billid']=='')continue;
			$billInfo['编号']=$item['billid'];
			$customer=getCustomerInfo($item['supplyid']);
			$sql="select USER_NAME from user where USER_ID=?";
			$shopper=$db->GetOne($sql,array($item['qianyueren']));
			$sql="select USER_NAME from user where USER_ID=?";
			$creater=$db->GetOne($sql,array($item['user_id']));
			$billInfo['图标']=$customer['用户头像'];
			$billInfo['第一行']="[No.".$item['billid']."] ".$customer['姓名'];
			if($item['user_flag']=='1')
			{
				$billInfo['第二行左']='执行中';
				$billInfo['颜色']='blue';
			}
			else if($item['user_flag']=='2')
			{
				$billInfo['第二行左']='完成';
				$billInfo['颜色']='green';
			}
			//$sumMoney=getSellPlanMainDetailSum($item['billid'],'sellplanmain_detail');
			$billInfo['第三行']="总金额:".number_format($item['totalmoney'],2);
			if($item['tuihuojine']!=0)
				$billInfo['第三行'].=" 退货:".number_format($item['tuihuojine'],2);
			if($item['zengpinjine']!=0)
				$billInfo['第三行'].=" 赠品:".number_format($item['zengpinjine'],2);
			$allmoney+=doubleval($item['totalmoney']);
			$alloddment+=doubleval($item['oddment']);
			$alltuihuo+=doubleval($item['tuihuojine']);
			$allzengpin+=doubleval($item['zengpinjine']);
			$billInfo['第三行'].=" 时间:".substr($item['createtime'],0,16);
			$billInfo['第二行右']="制单:".$creater." 导购:".$shopper;
			$billInfo['内容项URL']="?ID=".$item['billid']."&function=module_formalBill&action=edit_detail";
			//$billInfo['颜色']="brown";
			//$billInfo['附加菜单']=array("删除"=>"?ID=".$item['billid']."&action=delete&function=module_formalBill");
			$billInfo['客户ID']=$item['supplyid'];
			$result['成绩数值'][]=$billInfo;
		}
		$result['汇总']='订单数:'.sizeof($rs_a)." 总金额:".number_format($allmoney,2)." 总去零:".number_format($alloddment,2)." 总退货:".number_format($alltuihuo,2)." 总赠品:".number_format($allzengpin,2);
	}
	else if($action=='edit_detail')
	{
		$billid=$params['ID'];
		$result=getBillDetailJson($billid,$params['function'],'sellplanmain_detail');
		$result['操作类型']='view';
	}
	
	return $result;
}
?>