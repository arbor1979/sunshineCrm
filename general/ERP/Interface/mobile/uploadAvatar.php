<?php

function uploadAvatar($params)
{
	global $db;
	$result=array();
	$UID=intval($params['用户较验码']['0']);
	$UTYPE=intval($params['用户较验码']['2']);
	$action=$params['action'];
	if(empty($_FILES["filename"]))
		throw new Exception('上传文件不能为空');
	if($_FILES["filename"]["size"] > 2000000)
		throw new Exception('文件大小不能超过2M');
	if ($_FILES["filename"]["error"] > 0) 
		throw new Exception( $_FILES["filename"]["error"]);
	$extName=get_file_extName($_FILES["filename"]["name"]);
	if (!in_array(strtolower($extName),array("jpg","png","jpeg"))) 
		throw new Exception('文件格式必须是jpg或png');
	if($action=='user')
	{
		$fileName=$UTYPE."_".$UID."_".time().".".$extName;
		if(move_uploaded_file($_FILES["filename"]["tmp_name"], "avatars/" . $fileName))
		{
			$result['avatar']=getCurPath().'/avatars/'.$fileName;
			if($UTYPE>0)
			{
				$sql="select AVATAR from user where UID=?";
				$oldAvatar=$db->GetOne($sql,array($UID));
				if(!empty($oldAvatar))//删除旧的图片
				{
					$realName='avatars/'.get_file_realName($oldAvatar);
					if(file_exists($realName))
						unlink($realName);
				}
				$sql="update user set AVATAR=? where UID=?";
				$db->Execute($sql,array($result['avatar'],$UID));
				$result['result']='成功';
				insert_log("修改头像",$params['用户较验码']['1'],$sql);
			}
			else//处理客户上传
			{

			}
		}
		else
			throw new Exception("移动文件失败");
	}
	else if($action=='product')
	{
		$productid=$params['productid'];
		$fileName=$productid."_".time().".".$extName;
		if(move_uploaded_file($_FILES["filename"]["tmp_name"], "products/" . $fileName))
		{
			$result['文件地址']=getCurPath().'/products/'.$fileName;
			$sql="select fileaddress,supplyid,oldproductid from product where productid=?";
			$prodObj=$db->GetRow($sql,array($productid));
			$oldAvatar=$prodObj['fileaddress]'];
			$supplyid=$prodObj['supplyid'];
			$oldproductid=$prodObj['oldproductid'];
			if(!empty($oldAvatar))//删除旧的图片
			{
				$realName='products/'.get_file_realName($oldAvatar);
				if(file_exists($realName))
					unlink($realName);
			}

			$sql="update product set fileaddress=? where supplyid=? and oldproductid=?";
			$db->Execute($sql,array($result['文件地址'],$supplyid,$oldproductid));
			$result['result']='成功';
			insert_log("修改产品图片",$params['用户较验码']['1'],$sql);
		}
		else
			throw new Exception("移动文件失败");
	}
	return $result;
}
?>