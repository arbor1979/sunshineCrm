<?php

function module_tempBill($params)
{
	global $db;
	
	$result=array();
	$UID=$params['用户较验码']['0'];
	$UName=$params['用户较验码']['1'];
	$UType=$params['用户较验码']['2'];
	$UDeptid=$params['用户较验码']['3'];
	$action=$params['action'];
	if(empty($action))
	{
		$sql="select * from v_sellone where 1=1";
		$sql =getRoleByUser($sql,"user_id",$UDeptid,$UType,$UName);
		$sql.=" order by billid desc";
		
		$rs_a=$db->GetAll($sql);
		$result['标题显示']='临时单';
		$result['右上按钮']='新增';
		$result['右上按钮URL']='?action=new&search=customer&function=module_tempBill';
		$result['成绩数值']=array();
		$result['弹出菜单']='删除';
		foreach((array)$rs_a as $item)
		{

			$billInfo=array();
			$billInfo['编号']=$item['billid'];

			$customer=getCustomerInfo($item['supplyid']);
			
			$sql="select USER_NAME from user where USER_ID=?";
			$shopper=$db->GetOne($sql,array($item['qianyueren']));
			$sql="select USER_NAME from user where USER_ID=?";
			$creater=$db->GetOne($sql,array($item['user_id']));
			$billInfo['图标']=$customer['用户头像'];
			$billInfo['第一行']="[No.".$item['billid']."] ".$customer['姓名'];
			$billInfo['第二行左']="制单:".$creater." 导购:".$shopper;
			$sumMoney=getSellPlanMainDetailSum($item['billid'],'sellplanmain_detail_tmp');
			$billInfo['第三行']="销售:".number_format($sumMoney['sellmoney'],2);
			if($sumMoney['tuihuomoney']!=0)
				$billInfo['第三行'].=" 退货:".number_format($sumMoney['tuihuomoney'],2);
			if($sumMoney['zengpinmoney']!=0)
				$billInfo['第三行'].=" 赠品:".number_format($sumMoney['zengpinmoney'],2);
			$billInfo['第二行右']="时间:".substr($item['createtime'],0,16);
			$billInfo['内容项URL']="?ID=".$item['billid']."&function=module_tempBill&action=edit_detail";
			//$billInfo['颜色']="brown";
			$billInfo['附加菜单']=array("删除"=>"?ID=".$item['billid']."&action=delete&function=module_tempBill");
			$billInfo['客户ID']=$item['supplyid'];
			$result['成绩数值'][]=$billInfo;
		}
	}
	else if($action=='new')
	{
		$supplyid=$params['extParam'];
		if(empty($supplyid))
			throw new Exception('客户不能为空');

		$result['标题显示']='新增临时单';
		$result['提交地址']='?function=module_tempBill&action=save&supplyid='.$supplyid;
		$result['调查问卷状态']='进行中';
		$result['自动关闭']='是';
		$result['调查问卷数值']=array();
		$customer=getCustomerInfo($supplyid);
		if(empty($customer))
			throw new Exception('客户不能为空');
		$item=array();
		$item['题目']='客户名称';
		$item['类型']='单行文本输入框';
		$item['是否必填']='是';
		$item['行数']='1';
		$item['只读']=true;
		$item['用户答案']=$customer['姓名']."[".$customer['会员卡']."] ".$customer['角色名称'];		
		$result['调查问卷数值'][]=$item;

		$sql="select user_id,user_name from user where DISABLED=1 order by user_name";
		$shopperArray=$db->GetAll($sql);
		$item=array();
		$item['题目']='导购姓名';
		$item['类型']='下拉';
		$item['是否必填']='是';
		$item['选项']=array();
		foreach((array)$shopperArray as $shopper)
		{
			$subItem=array();
			$subItem['key']=$shopper['user_id'];
			$subItem['value']=$shopper['user_name'];
			$item['选项'][]=$subItem;
		}
		$item['用户答案']=$UName;		
		$result['调查问卷数值'][]=$item;

		$stockArray=getStoreByUser($UDeptid,$UName);
		$item=array();
		$item['题目']='仓库';
		$item['类型']='下拉';
		$item['是否必填']='是';
		$item['选项']=array();
		$firstStock="";
		foreach((array)$stockArray as $stock)
		{
			$subItem=array();
			$subItem['key']=$stock['rowid'];
			$subItem['value']=$stock['name'];
			$item['选项'][]=$subItem;
			if(empty($firstStock))
				$firstStock=$stock['rowid'];
		}
		$item['用户答案']=$UName;		
		$result['调查问卷数值'][]=$item;

		$item=array();
		$item['题目']='是否发货';
		$item['类型']='单选';
		$item['是否必填']='是';
		$item['选项']=array();
		$subItem=array();
		$subItem['key']='否';
		$subItem['value']='否';
		$item['选项'][]=$subItem;
		$subItem=array();
		$subItem['key']='是';
		$subItem['value']='是';
		$item['选项'][]=$subItem;
		$item['用户答案']='否';		
		$result['调查问卷数值'][]=$item;

		$item=array();
		$item['题目']='发货地址';
		$item['类型']='单行文本输入框';
		$item['是否必填']='否';
		$item['行数']='1';
		$item['用户答案']=$customer['地址'];		
		$result['调查问卷数值'][]=$item;
		
		$item=array();
		$item['题目']='联系电话';
		$item['类型']='单行文本输入框';
		$item['是否必填']='否';
		$item['行数']='1';
		$item['用户答案']=$customer['手机'];		
		$result['调查问卷数值'][]=$item;

		$item=array();
		$item['题目']='备注';
		$item['类型']='单行文本输入框';
		$item['是否必填']='否';
		$item['用户答案']='';		
		$result['调查问卷数值'][]=$item;

	}
	else if($action=='save')
	{
		$supplyid=$params['supplyid'];
		$params['选项记录集']=str_replace("\\", "", $params['选项记录集']);
		$submitArray=json_decode(urldecode($params['选项记录集']),true);
		
		$db->StartTrans();
		$sql="select max(billid) as newBillId from sellplanmain"; 
		$newBillId=$db->GetOne($sql);
		$newBillId=intval($newBillId)+1;
		$fahuostate=-1;
		if($submitArra['是否发货']=='是')
			$fahuostate=0;
		$kaipiaostate=-1;
		
		$zhuti='店面销售单-'.$newBillId;
		$sql="insert into sellplanmain (billid,zhuti,user_id,supplyid,qianyueren,user_flag,beizhu,fahuostate,storeid,address,mobile,createtime,billtype,kaipiaostate) values(?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
		$ret=$db->Execute($sql,array($newBillId,$zhuti,$UName,$supplyid,$submitArray['导购姓名'],'0',$submitArray['备注'],$fahuostate,$submitArray['仓库'],$submitArray['发货地址'],$submitArray['联系电话'],date('Y-m-d H:i:s'),3,$kaipiaostate));
		//print_r($db->HasFailedTrans());exit;
		if ($db->HasFailedTrans()) 
			throw new Exception($db->ErrorMsg());
		$db->CompleteTrans();
		$result['result']='成功';
		
	}
	else if($action=='delete')
	{
		$billid=$params['ID'];
		$billObj=getSellPlanMain($billid);
		if($billObj['user_flag']!=0)
			throw new Exception('单据状态已改变，不能删除');
		$sql="update sellplanmain set user_flag=-1 where billid=$billid and user_flag=0";
		$rs=$db->Execute($sql);
		if ($rs === false)
			throw new Exception("不存在此记录");	
		$sql="insert into sellplanmain_detail_delete (select * from sellplanmain_detail_tmp where mainrowid=$billid)";
		$db->Execute($sql);
		$sql="delete from sellplanmain_detail_tmp where mainrowid=$billid";
		$db->Execute($sql);
		$result['result']='成功';
		$result['msg']='单据删除成功';
	}
	else if($action=='edit_detail')
	{
		$billid=$params['ID'];
		$billObj=getSellPlanMain($billid);
		if($billObj['user_flag']!=0)
			throw new Exception('单据状态已改变，不能再编辑');
		$result=getBillDetailJson($billid,$params['function'],'sellplanmain_detail_tmp');

	}
	else if($action=='newDetail')
	{
		$searchValue=$params['searchValue'];
		$opertype=$params['opertype'];
		if($opertype=='')
			$opertype=1;
		$billid=$params['billid'];

		$billObj=getSellPlanMain($billid);
		if($billObj['user_flag']!=0)
			throw new Exception('单据状态已改变，不能再编辑');

		$prodInfo=getProductByprodid($searchValue);

		if(empty($prodInfo))
			throw new Exception("没有此商品");
		if($prodInfo['user_flag']=="否")
			throw new Exception("此商品禁止销售");
		$sql="select supplyid from sellplanmain where billid=?";
		$supplyid=$db->GetOne($sql,array($billid));

		$sql="select a.minzhekou,b.relatePrice as priceName from customer a inner join customerlever b on a.state=b.ROWID where a.ROWID=?";
		$customer=$db->GetRow($sql,array($supplyid));
		$minzhekou=$customer['minzhekou'];
		$priceName=$customer['priceName'];
		$price=$prodInfo['sellprice'];
		$realprice=doubleval($prodInfo[$priceName]);
		$zhekou=1;
		if($price!=0)
			$zhekou=round($realprice/$price,6);
		if(!empty($minzhekou) && $minzhekou/100>$zhekou)
		{
			$zhekou=$minzhekou/100;
			$realprice=round($price*$zhekou,2);
		}

		$tiaohuan=$prodInfo['iftiaohuan'];
		if($tiaohuan=='否')
			$tiaohuan='●';
		else
			$tiaohuan='';
		$xinghao=$prodInfo['mode'];
		$addnum=1;
		if($opertype==-1)
			$addnum=$addnum*$opertype;
		if(strval(intval($xinghao))==$xinghao && intval($xinghao)>0)
			$addnum=$addnum*$xinghao;
		
		$sql="select max(orderid) from sellplanmain_detail_tmp where mainrowid='$billid'";
		$orderid = $db->GetOne($sql);
		$orderid=intval($orderid)+1;
		$sql="select * from sellplanmain_detail_tmp where prodid='$searchValue' and mainrowid='$billid' and opertype=$opertype";
    	$rs_a = $db->GetRow($sql);
    	
		if(empty($rs_a))
		{
			if($opertype==0)
				$zhekou=0;
			$zengpinzhekou=1;
			if($price!=0)
				$zengpinzhekou=round($realprice/$price,6);
			$sql="insert into sellplanmain_detail_tmp (prodid,prodname,prodguige,prodxinghao,proddanwei,price,zhekou,num,beizhu,mainrowid,oldprodid,opertype,orderid,inputtime,zengpinzhekou)
				values (?,?,?,?,?,$price,$zhekou,$addnum,'',$billid,?,'$opertype','$orderid',Now(),$zengpinzhekou)";
			$db->Execute($sql,array($searchValue,$prodInfo['productname'].$tiaohuan,$prodInfo['colorname'],$prodInfo['mode'],$prodInfo['measureid'],$prodInfo['oldproductid']));
		}
		else
		{
			$sql="update sellplanmain_detail_tmp set num=num+($addnum),orderid=$orderid where id=".$rs_a['id'];
			$db->Execute($sql);
		}
		$result['result']='成功';
		$result['toBottom']=1;
		$result['detailList']=getBillDetailJson($billid,$params['function'],'sellplanmain_detail_tmp');

	}
	else if($action=='updateAmount')
	{
		$id=$params['detailId'];
		$num=$params['num'];
		$billid=$params['ID'];

		$billObj=getSellPlanMain($billid);
		if($billObj['user_flag']!=0)
			throw new Exception('单据状态已改变，不能再编辑');

		$sql="select opertype from sellplanmain_detail_tmp where id=?";
		$opertype = $db->GetOne($sql,array($id));

		if($opertype>=0 && intval($num)<=0)
			throw new Exception("数量必须大于0");
		if($opertype==-1 && intval($num)>=0)
			throw new Exception("数量必须小于0");
		$sql="update sellplanmain_detail_tmp set num=? where id=?";
		$db->Execute($sql,array(intval($num),$id));
		$result['result']='成功';
		$result['toBottom']=0;
		$result['detailList']=getBillDetailJson($billid,$params['function'],'sellplanmain_detail_tmp');
	}
	else if($action=='deleteDetail')
	{
		$id=$params['detailId'];
		$billid=$params['billid'];
		$billObj=getSellPlanMain($billid);
		if($billObj['user_flag']!=0)
			throw new Exception('单据状态已改变，不能再编辑');

		$sql='delete from sellplanmain_detail_tmp where id=? and mainrowid=?';
		$db->Execute($sql,array($id,$billid));
		$result['result']='成功';
		$result['detailList']=getBillDetailJson($billid,$params['function'],'sellplanmain_detail_tmp');
	}
	else if($action=='billPayInfo')
	{
		$billid=$params['ID'];
		$billObj=getSellPlanMain($billid);
		if($billObj['user_flag']!=0)
			throw new Exception('单据状态已改变，不能付款');
		$tuihuorate=getCustomerTuihuoRate($billObj['supplyid']);
		$sumMoney=getSellPlanMainDetailSum($billid,'sellplanmain_detail_tmp');
		if($tuihuorate>0 && $sumMoney['sellmoney']*$tuihuorate/100<$sumMoney['tuihuomoney'])
			throw new Exception('退货金额超过限制');
		$sql="update sellplanmain set totalmoney=".round($sumMoney['allmoney'],2).",totalnum=".$sumMoney['allnum'].",tuihuojine=".round($sumMoney['tuihuomoney'],2).",zengpinjine=".round($sumMoney['zengpinmoney'],2)." where user_flag='0' and billid=".$billid;
		$db->Execute($sql);
		$sql="update sellplanmain_detail_tmp set jine=round(price*zhekou,2)*num,sellprice=round(price*zhekou,2) where mainrowid=".$billid;
		$db->Execute($sql);
		$customerObj=getCustomerInfo($billObj['supplyid']);
		$result['单号']=$billid;
		$result['客户资料']=$customerObj;
		$result['应收款']=number_format($sumMoney['allmoney'],2);
		$result['totalmoney']=doubleval(round($sumMoney['allmoney'],2));
		$sql="select rowid as id,bankname as name from bank";
		$bankList=$db->GetAll($sql);
		$addItem=array();
		$addItem['id']=0;
		$addItem['name']='预收款支付';
		$bankList[]=$addItem;
		$result['收款账户']=$bankList;

	}
	else if($action=='saveDetail')
	{
		$billid=$params['ID'];
		$totalmoney=$params['totalmoney'];
		$oddment=$params['quling'];
		$shoukuan=$params['shoukuan'];
		$ifpay=$params['ifpay'];
		$accountid=$params['accountid'];
		$billObj=getSellPlanMain($billid);
		if($billObj['user_flag']!=0)
			throw new Exception('单据状态已改变，不能付款');
		
		require_once('../JXC/DAO/Store.php');
		require_once('../JXC/DAO/CaiWu.php');
		//$db->debug=true;
		$db->StartTrans();
		$CaiWu =new CaiWu($db,'utf-8');
		$Store =new Store($db,'utf-8');
		//付款
		$opertype='';
		if($ifpay==1)
		{
			//付全款
			$opertype='货款收取';
			$shoukuan=$totalmoney-$oddment;
		}
		else
		{
			//付押金
			$opertype='收押金';
		}
		$customerid=$billObj['supplyid'];
		$_SESSION['LOGIN_USER_ID']=$UName;
		//插入新回款记录
		if($shoukuan!=0 || $oddment!=0)
		{
			$CaiWu->insertShoukuanReocord($customerid,$billid,$shoukuan,$accountid,$UName,$opertype,$oddment,'1','',0,0);
		}

		//出库
		$chukubillid=$Store->insertSellOneChuKu($billid,$billObj['zhuti'],$billObj['storeid']);
		//发货
		if($billObj['fahuostate']==0 && $chukubillid>0)
		{
			$sql="select linkmanname from linkman where rowid=?";
			$shouhuoren=$db->GetOne($sql,array($billObj['linkman']));
			$Store->insertFaHuo($chukubillid,$customerid,$billid,$shouhuoren,$billObj['mobile'],$billObj['address']);
		}	
			
		//是否事务出现错误
		if ($db->HasFailedTrans())
			throw  new Exception($db->ErrorMsg());
		$db->CompleteTrans();
		$result['result']='成功';
		
	}
	return $result;
}
?>