<?php

function changePwd($params)
{
	global $db;
	
	$result=array();
	$UID=$params['用户较验码']['0'];
	$newPassword=$params['密码'];
	$oldPassword=$params['旧密码'];

	if(empty($oldPassword))
		$oldPassword='';
	if(empty($newPassword))
		throw new Exception('新密码不能为空');
	$sql="select * from `user` where uid=?";
	$rs_a=$db->GetAll($sql,array($UID));

	if(empty($rs_a))
		throw new Exception('不存在此用户');
	else
	{
		$PasswordText=$rs_a[0]['PASSWORD'];
		if(crypt($oldPassword,$PasswordText) == $PasswordText)	
		{
			$newPasswordText=crypt($newPassword);
			$sql="update user set password=? where UID=?";
			$db->Execute($sql,array($newPasswordText,$UID));
			$result['result']='成功';
			$result['新密码']=$newPassword;
			insert_log("修改密码",$params['用户较验码']['1'],$sql);
		}
		else
			throw new Exception('旧密码不正确');
	}
	
	return $result;
}
?>