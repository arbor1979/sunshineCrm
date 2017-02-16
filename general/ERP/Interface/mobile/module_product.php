<?php

function module_product($params)
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

		$sql="select a.*,b.name as producttypename,c.name as colorname,d.supplyname from product a left join producttype b on a.producttype=b.rowid left join productcolor c on a.standard=c.id left join supply d on a.supplyid=d.rowid where 1=1";

		$productid=$params['productid'];
		if($productid!='')
			$sql.=" and (productid='".$productid."' or oldproductid like '%$productid%')";
		$producttype=$params['producttype'];
		if($producttype!='')
			$sql.=" and producttypename  like '%$producttype%'";
		$standard=$params['standard'];
		if($standard!='')
			$sql.=" and colorname='$standard'";
		$supplyid=$params['supplyid'];
		if($supplyid!='')
			$sql.=" and supplyname like '%$supplyid%'";
		$sql.=" order by sellprice desc";
		//echo $sql;exit;
		$rs_a=$db->GetAll($sql);
		$result['标题显示']='产品维护';
		$result['右上按钮']='过滤';
		$result['右上按钮URL']='?action=filter&search=product&function=module_product';
		$result['成绩数值']=array();
		
		foreach((array)$rs_a as $item)
		{

			$billInfo=array();
			if($item['productid']=='')continue;
			$billInfo['编号']=$item['productid'];
			if($item['fileaddress']=='')
				$item['fileaddress']=getCurPath()."/images/gift.png";
			$billInfo['图标']=htmlspecialchars_decode($item['fileaddress']);
			$billInfo['第一行']=$item['productid']." ".$item['productname'];
			$billInfo['第二行左']='零售价:'.number_format($item['sellprice'],2);
			$billInfo['第二行右']="原厂码:".$item['oldproductid'];
			$billInfo['第三行']="颜色:".$item['colorname']." 厂家:".$item['supplyname'];
			$billInfo['内容项URL']="?ID=".$item['productid']."&function=module_product&action=edit_detail";
			//$billInfo['颜色']="brown";
			$billInfo['附加菜单']=array("删除"=>"?ID=".$item['productid']."&action=delete&function=module_product");
			$billInfo['模板']='调查问卷';
			$result['成绩数值'][]=$billInfo;
		}
		$result['汇总']='产品数:'.sizeof($rs_a);
	}
	else if($action=='edit_detail')
	{
		$productid=$params['ID'];
		if(empty($productid))
			throw new Exception('产品编号不能为空');

		$productObj=getProductByprodid($productid);
		$result['标题显示']='编辑产品';
		$result['提交地址']='?function=module_product&action=save_detail&productid='.$productid;
		$result['调查问卷状态']='进行中';
		$result['自动关闭']='是';
		$result['调查问卷数值']=array();
		
		$item=array();
		$item['题目']='供应商';
		$item['类型']='单行文本输入框';
		$item['是否必填']='是';
		$item['行数']='1';
		$item['只读']='true';
		$item['用户答案']=$productObj['supplyname'];		
		$result['调查问卷数值'][]=$item;

		$item=array();
		$item['题目']='颜色';
		$item['类型']='单行文本输入框';
		$item['是否必填']='是';
		$item['行数']='1';
		$item['只读']='true';
		$item['用户答案']=$productObj['colorname'];		
		$result['调查问卷数值'][]=$item;

		$item=array();
		$item['题目']='商品名称';
		$item['类型']='单行文本输入框';
		$item['是否必填']='是';
		$item['行数']='1';
		$item['用户答案']=$productObj['productname'];		
		$result['调查问卷数值'][]=$item;

		$sql="select rowid,name from producttype";
		$shopperArray=$db->GetAll($sql);
		$item=array();
		$item['题目']='商品类别';
		$item['类型']='下拉';
		$item['是否必填']='是';
		$item['选项']=array();
		foreach((array)$shopperArray as $shopper)
		{
			$subItem=array();
			$subItem['key']=$shopper['rowid'];
			$subItem['value']=$shopper['name'];
			$item['选项'][]=$subItem;
		}
		$item['用户答案']=$productObj['producttype'];		
		$result['调查问卷数值'][]=$item;


		$item=array();
		$item['题目']='零售价';
		$item['类型']='单行文本输入框';
		$item['是否必填']='是';
		$item['行数']='1';
		$item['用户答案']=$productObj['sellprice'];		
		$result['调查问卷数值'][]=$item;

		$item=array();
		$item['题目']='VIP会员价';
		$item['类型']='单行文本输入框';
		$item['是否必填']='是';
		$item['行数']='1';
		$item['用户答案']=$productObj['sellprice2'];		
		$result['调查问卷数值'][]=$item;

		$item=array();
		$item['题目']='白金会员价';
		$item['类型']='单行文本输入框';
		$item['是否必填']='是';
		$item['行数']='1';
		$item['用户答案']=$productObj['sellprice3'];		
		$result['调查问卷数值'][]=$item;

		$item=array();
		$item['题目']='钻石会员价';
		$item['类型']='单行文本输入框';
		$item['是否必填']='是';
		$item['行数']='1';
		$item['用户答案']=$productObj['sellprice5'];		
		$result['调查问卷数值'][]=$item;

		$item=array();
		$item['题目']='规格';
		$item['类型']='单行文本输入框';
		$item['是否必填']='否';
		$item['行数']='1';
		$item['用户答案']=$productObj['mode'];		
		$result['调查问卷数值'][]=$item;

		$item=array();
		$item['题目']='原厂码';
		$item['类型']='单行文本输入框';
		$item['是否必填']='是';
		$item['行数']='1';
		$item['用户答案']=$productObj['oldproductid'];		
		$result['调查问卷数值'][]=$item;

		$item=array();
		$item['题目']='支持调换';
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
		$item['用户答案']=$productObj['iftiaohuan'];		
		$result['调查问卷数值'][]=$item;

		$item=array();
		$item['题目']='商品图片';
		$item['类型']='图片';
		$item['是否必填']='否';
		$item['行数']='1';
		$imageArray=array();
		$imageItem['文件地址']=htmlspecialchars_decode($productObj['fileaddress']);
		$imageArray[]=$imageItem;
		$item['用户答案']=$imageArray;
		$result['调查问卷数值'][]=$item;

	}
	else if($action=='save_detail')
	{
		$productid=$params['productid'];
		if(empty($productid))
			throw new Exception('产品编号不能为空');
		$productObj=getProductByprodid($productid);
		if(empty($productObj['productid']))
			throw new Exception('产品编号不存在');
		$params['选项记录集']=str_replace("\\", "", $params['选项记录集']);
		$submitArray=json_decode(urldecode($params['选项记录集']),true);
		
		if(empty($submitArray['商品名称']))
			throw new Exception('产品名称不能为空');
		if(empty($submitArray['商品类别']))
			throw new Exception('商品类别不能为空');
		if(!is_numeric($submitArray['零售价']) || floatval($submitArray['零售价'])<0)
			throw new Exception('零售价必须是大于0的数字');
		if(!is_numeric($submitArray['VIP会员价']) || floatval($submitArray['VIP会员价'])<0)
			throw new Exception('VIP会员价必须是大于0的数字');
		if(!is_numeric($submitArray['白金会员价']) || floatval($submitArray['白金会员价'])<0)
			throw new Exception('白金会员价必须是大于0的数字');
		if(!is_numeric($submitArray['钻石会员价']) || floatval($submitArray['钻石会员价'])<0)
			throw new Exception('钻石会员价必须是大于0的数字');
		if(!is_numeric($submitArray['钻石会员价']) || floatval($submitArray['钻石会员价'])<0)
			throw new Exception('钻石会员价必须是大于0的数字');
		if(!empty($submitArray['规格']))
		{
		 	if(!is_numeric($submitArray['规格']) || floatval($submitArray['规格'])<=0)
				throw new Exception('规格必须是大于0的数字');
		}
		$sql="select productid from product where productid<>? and supplyid=? and oldproductid=?";
		$otherProd=$db->GetOne($sql,array($productid,$productObj['supplyid'],$submitArray['原厂码']));
		if(!empty($otherProd))
			throw new Exception('此厂家已存在相同原厂码的产品');
		$sql="update product set productname=?,producttype=?,sellprice=?,sellprice2=?,sellprice3=?,sellprice5=?,mode=?,oldproductid=?,iftiaohuan=? where productid=? LIMIT 1";
		$rs=$db->Execute($sql,array($submitArray['商品名称'],$submitArray['商品类别'],$submitArray['零售价'],$submitArray['VIP会员价'],$submitArray['白金会员价'],$submitArray['钻石会员价'],$submitArray['规格'],$submitArray['原厂码'],$submitArray['支持调换'],$productid));
		if($rs)
		{
			$result['result']='成功';
			$result['rs']=$rs;
		}
		else
			throw new Exception('更新记录失败');
	}
	else if($action=='deleteImage')
	{
		$productid=$params['ID'];
		if(empty($productid))
			throw new Exception('产品编号不能为空');
		$result['downAddress']=getCurPath().'/products/'.$fileName;
		$sql="select fileaddress from product where productid=?";
		$oldAvatar=$db->GetOne($sql,array($productid));
		if(!empty($oldAvatar))//删除旧的图片
		{
			$realName='products/'.get_file_realName($oldAvatar);
			if(file_exists($realName))
				unlink($realName);
		}
		$sql="update product set fileaddress='' where productid=?";
		$db->Execute($sql,array($productid));
		$result['result']='成功';
		insert_log("删除产品图片",$params['用户较验码']['1'],$sql);
	}
	else if($action=='delete')
	{
		$productid=$params['ID'];
		if(empty($productid))
			throw new Exception('产品编号不能为空');
		$sql="select * from stockinmain_detail where prodid=? limit 1";
		$row=$db->GetRow($sql,array($productid));
		if(!empty($row))
			throw new Exception('存在入库记录，不能删除产品');
		$sql="select * from stockoutmain_detail where prodid=? limit 1";
		$row=$db->GetRow($sql,array($productid));
		if(!empty($row))
			throw new Exception('存在出库记录，不能删除产');
		$sql="delete from product where productid=? limit 1";
		$db->Execute($sql,array($productid));
		$result['result']='成功';
		$result['msg']='产品删除成功';
	}
	return $result;
}
?>