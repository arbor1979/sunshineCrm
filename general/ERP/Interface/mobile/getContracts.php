<?php

function getContracts($params)
{
	global $db;
	$result=array();
	$UID=intval($params['用户较验码']['0']);
	$UName=$params['用户较验码']['1'];
	$UTYPE=intval($params['用户较验码']['2']);
	$UDeptid=$params['用户较验码']['3'];
	$action=$params['action'];
	if(empty($action))
	{
		$sql="select rowid,name from customerlever";
		$result['groupName']=$db->GetAll($sql);
		if(empty($result['groupName']))
			$result['groupName']=array();
		$sql="select rowid,supplyname,membercard,phone,avatar,state,lasttracetime from customer where 1=1";
		/*
		if($UTYPE==2)
			$sql=getRoleByUser($sql,'sysuser',$UDeptid,$UTYPE,$UName);
		else if($UTYPE==3)
			$sql.=" and (sysuser='$UName' or rowid in (select distinct supplyid from sellplanmain where qianyueren='$UName'))";
		*/
		if($UTYPE>1)
			$sql.=" and (datascope='1' or (datascope='2'".getRoleByUser('','sysuser',$UDeptid,$UTYPE,$UName)."))";
		$sql.=" order by supplyname";
		$rs=$db->GetAll($sql);
		
		foreach((array)$result['groupName'] as $item)
		{
			$groupName=$item['name'];
			$result[$groupName]=array();
		}
		for($i=0;$i<sizeof($rs);$i++)
		{
			foreach((array)$result['groupName'] as $item)
			{
				
				if($rs[$i]['state']==$item['rowid'])
				{
					$custObj=array();
					$custObj['编号']=$rs[$i]['rowid'];
					$custObj['姓名']=$rs[$i]['supplyname'];
					$custObj['学号']=$rs[$i]['membercard'];
					$custObj['学生电话']=$rs[$i]['phone'];
					$custObj['用户类型']="0";
					if(empty($custObj['学生电话']) && strlen($rs[$i]['membercard'])==11)
						$custObj['学生电话']=$rs[$i]['membercard'];
					$custObj['用户头像']=htmlspecialchars_decode($rs[$i]['avatar']);
					if(empty($custObj['用户头像']))
					{
						$fileName='avatars/'.$item['name'].'.png';
						$fileNameGbk=iconv('UTF-8','GB2312',$fileName);
						if(file_exists($fileNameGbk))
						{
							$custObj['用户头像']=getCurPath()."/".$fileName;
						}
					}

					$custObj['用户唯一码']="0_".$rs[$i]['rowid'];
					if(!empty($rs[$i]['lasttracetime']))
					{
						$sql="select b.user_name from crm_contact a inner join user b on a.user_id=b.user_id where a.customerid=? order by a.id desc limit 1";
						
						$user_name=$db->GetOne($sql,array($rs[$i]['rowid']));
						$custObj['座号']=substr($rs[$i]['lasttracetime'],0,16)." ".$user_name;
					}
					else
						$custObj['座号']='';
					$custObj['附加菜单']=array("编辑"=>"?ID=".$custObj['编号']."&action=edit&function=getContracts","删除"=>"?ID=".$custObj['编号']."&action=delete&function=getContracts");
					$groupName=$item['name'];
					$result[$groupName][]=$custObj;
				}	
			}
		}
	}
	else if($action=='updateLastestContact')
	{
		$supplyid=$params['memberId'];
		$sql="insert into crm_contact (customerid,linkmanid,user_id,createman,contact,chance,stage,describes,createtime,contacttime) values (?,'',?,?,'1','',1,'拨打电话',now(),now())";
		$db->Execute($sql,array($supplyid,$UName,$UName));
		$sql="update customer set lasttracetime=now() where rowid=?";
		$db->Execute($sql,array($supplyid));
		$sql="select user_name from user where uid=?";
		$user_name=$db->GetOne($sql,$UID);
		$result['result']='成功';
		$result['customerid']=$supplyid;
		$result['contacttime']=substr(date('Y-m-d H:i:s'),0,16)." ".$user_name;
		
	}
	else if($action=='add')
	{

		$result['标题显示']='新增客户';
		$result['提交地址']='?function=getContracts&action=save';
		$result['调查问卷状态']='进行中';
		$result['自动关闭']='是';
		$result['调查问卷数值']=array();
		
		$item=array();
		$item['题目']='客户名称';
		$item['类型']='单行文本输入框';
		$item['是否必填']='是';
		$item['行数']='1';
		$item['用户答案']='';		
		$result['调查问卷数值'][]=$item;

		$item=array();
		$item['题目']='联系地址';
		$item['类型']='单行文本输入框';
		$item['是否必填']='是';
		$item['行数']='1';
		$item['用户答案']='';		
		$result['调查问卷数值'][]=$item;

		$item=array();
		$item['题目']='会员卡';
		$item['类型']='单行文本输入框';
		$item['是否必填']='是';
		$item['行数']='1';
		$item['用户答案']='';		
		$result['调查问卷数值'][]=$item;

		$item=array();
		$item['题目']='手机号';
		$item['类型']='单行文本输入框';
		$item['是否必填']='是';
		$item['行数']='1';
		$item['用户答案']='';		
		$result['调查问卷数值'][]=$item;

		$sql="select rowid,name from customerlever";
		$shopperArray=$db->GetAll($sql);
		$item=array();
		$item['题目']='客户等级';
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
		$item['用户答案']='';		
		$result['调查问卷数值'][]=$item;

		$item=array();
		$item['题目']='查看权限';
		$item['类型']='单选';
		$item['是否必填']='是';
		$item['选项']=array();
		$subItem=array();
		$subItem['key']='1';
		$subItem['value']='公共';
		$item['选项'][]=$subItem;
		$subItem=array();
		$subItem['key']='2';
		$subItem['value']='私有';
		$item['选项'][]=$subItem;
		$item['用户答案']='1';		
		$result['调查问卷数值'][]=$item;

		$item=array();
		$item['题目']='退货率';
		$item['类型']='单行文本输入框';
		$item['是否必填']='否';
		$item['行数']='1';
		$item['用户答案']='';		
		$result['调查问卷数值'][]=$item;

		$item=array();
		$item['题目']='最低折扣';
		$item['类型']='单行文本输入框';
		$item['是否必填']='否';
		$item['行数']='1';
		$item['用户答案']='';		
		$result['调查问卷数值'][]=$item;

	}
	else if($action=='save')
	{
		$params['选项记录集']=str_replace("\\", "", $params['选项记录集']);
		$submitArray=json_decode(urldecode($params['选项记录集']),true);
		$customerName=$submitArray['客户名称'];
		if(empty($customerName))
			throw new Exception("客户名称不能为空");
		require_once('utility/pinyin.php');
		$pinyin=PinYin::汉字转拼音首字母($customerName);
		$memberCard=$submitArray['会员卡'];
		if(empty($memberCard))
			throw new Exception("会员卡不能为空");
		$mobile=$submitArray['手机号'];
		if(empty($mobile))
			throw new Exception("手机号不能为空");
		$sql="select * from customer where memberCard=? limit 1";
		$row=$db->GetRow($sql,array($memberCard));
		if(!empty($row))
			throw new Exception("此会员卡已存在");
		$tuihuolv=$submitArray['退货率'];
		if(!empty($tuihuolv) && (!is_numeric($tuihuolv) || intval($tuihuolv)<0 || intval($tuihuolv)>100))
			throw new Exception("退货率必须是0-100");
		$minzhekou=$submitArray['最低折扣'];
		if(!empty($minzhekou) && (!is_numeric($tuihuolv) || intval($minzhekou)<0 || intval($minzhekou)>100))
			throw new Exception("最低折扣必须是0-100");
		$sql="select max(rowid) from customer";
		$maxid=$db->GetOne($sql);
		if(empty($maxid))
			$maxid=1;
		else
			$maxid++;
		$sql="insert into customer (supplyname,state,membercard,phone,contactaddress,sysuser,datascope,createdate,tuihuorate,minzhekou,calling,user_id,rowid) values(?,?,?,?,?,?,?,?,?,?,?,?,?)";
		$rs=$db->Execute($sql,array($customerName,$submitArray['客户等级'],$memberCard,$submitArray['手机号'],$submitArray['联系地址'],$UName,$submitArray['查看权限'],date('Y-m-d H:i:s'),$tuihuolv,$minzhekou,$pinyin,$UName,$maxid));
		if(empty($rs))
			throw new Exception("插入数据失败");
		$result['result']='成功';
	}
	else if($action=='edit')
	{
		$customerid=$params['ID'];
		$sql="select * from customer where rowid=?";
		$custObj=$db->GetRow($sql,array($customerid));
		if(empty($custObj))
			throw new Exception("客户不存在");
			
		$result['标题显示']='编辑客户';
		$result['提交地址']='?function=getContracts&action=saveEdit&ID='.$customerid;
		$result['调查问卷状态']='进行中';
		$result['自动关闭']='是';
		$result['调查问卷数值']=array();
		
		$item=array();
		$item['题目']='客户名称';
		$item['类型']='单行文本输入框';
		$item['是否必填']='是';
		$item['行数']='1';
		$item['用户答案']=$custObj['supplyname'];		
		$result['调查问卷数值'][]=$item;

		$item=array();
		$item['题目']='联系地址';
		$item['类型']='单行文本输入框';
		$item['是否必填']='是';
		$item['行数']='1';
		$item['用户答案']=$custObj['contactaddress'];		
		$result['调查问卷数值'][]=$item;

		$item=array();
		$item['题目']='会员卡';
		$item['类型']='单行文本输入框';
		$item['是否必填']='是';
		$item['行数']='1';
		$item['用户答案']=$custObj['membercard'];		
		$result['调查问卷数值'][]=$item;

		$item=array();
		$item['题目']='手机号';
		$item['类型']='单行文本输入框';
		$item['是否必填']='是';
		$item['行数']='1';
		$item['用户答案']=$custObj['phone'];		
		$result['调查问卷数值'][]=$item;

		$sql="select rowid,name from customerlever";
		$shopperArray=$db->GetAll($sql);
		$item=array();
		$item['题目']='客户等级';
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
		$item['用户答案']=$custObj['state'];		
		$result['调查问卷数值'][]=$item;

		$item=array();
		$item['题目']='查看权限';
		$item['类型']='单选';
		$item['是否必填']='是';
		$item['选项']=array();
		$subItem=array();
		$subItem['key']='1';
		$subItem['value']='公共';
		$item['选项'][]=$subItem;
		$subItem=array();
		$subItem['key']='2';
		$subItem['value']='私有';
		$item['选项'][]=$subItem;
		$item['用户答案']=$custObj['datascope'];		
		$result['调查问卷数值'][]=$item;

		$item=array();
		$item['题目']='退货率';
		$item['类型']='单行文本输入框';
		$item['是否必填']='否';
		$item['行数']='1';
		$item['用户答案']=$custObj['tuihuorate'];		
		$result['调查问卷数值'][]=$item;

		$item=array();
		$item['题目']='最低折扣';
		$item['类型']='单行文本输入框';
		$item['是否必填']='否';
		$item['行数']='1';
		$item['用户答案']=$custObj['minzhekou'];		
		$result['调查问卷数值'][]=$item;
	}
	else if($action=='saveEdit')
	{
		$customerid=$params['ID'];
		$sql="select * from customer where rowid=?";
		$custObj=$db->GetRow($sql,array($customerid));
		if(empty($custObj))
			throw new Exception("客户不存在");
		$params['选项记录集']=str_replace("\\", "", $params['选项记录集']);
		$submitArray=json_decode(urldecode($params['选项记录集']),true);
		$customerName=$submitArray['客户名称'];
		if(empty($customerName))
			throw new Exception("客户名称不能为空");
		require_once('utility/pinyin.php');
		$pinyin=PinYin::汉字转拼音首字母($customerName);
		$memberCard=$submitArray['会员卡'];
		if(empty($memberCard))
			throw new Exception("会员卡不能为空");
		$mobile=$submitArray['手机号'];
		if(empty($mobile))
			throw new Exception("手机号不能为空");
		$sql="select * from customer where memberCard=? and rowid<>? limit 1";
		$row=$db->GetRow($sql,array($memberCard,$customerid));
		if(!empty($row))
			throw new Exception("此会员卡已存在");
		$tuihuolv=$submitArray['退货率'];
		if(!empty($tuihuolv) && (!is_numeric($tuihuolv) || intval($tuihuolv)<0 || intval($tuihuolv)>100))
			throw new Exception("退货率必须是0-100");
		$minzhekou=$submitArray['最低折扣'];
		if(!empty($minzhekou) && (!is_numeric($tuihuolv) || intval($minzhekou)<0 || intval($minzhekou)>100))
			throw new Exception("最低折扣必须是0-100");
		$sql="update customer set supplyname=?,contactaddress=?,membercard=?,phone=?,state=?,datascope=?,tuihuorate=?,minzhekou=? where rowid=?";
		$db->Execute($sql,array($customerName,$submitArray['联系地址'],$memberCard,$mobile,$submitArray['客户等级'],$submitArray['查看权限'],$tuihuolv,$minzhekou,$customerid));
		$result['result']='成功';

	}
	else if($action=='delete')
	{
		$customerid=$params['ID'];
		$sql="select * from customer where rowid=?";
		$custObj=$db->GetRow($sql,array($customerid));
		if(empty($custObj))
			throw new Exception("客户不存在");
		$sql="select * from sellplanmain where supplyid=? limit 1";
		$row=$db->GetRow($sql,$customerid);
		if(!empty($row))
			throw new Exception("存在销售记录，不能删除");
		$sql="delete from customer where rowid=?";
		$db->Execute($sql,$customerid);
		$result['result']='成功';
		$result['id']=$customerid;
		$result['msg']='客户已删除';
	}
	return $result;
}
?>