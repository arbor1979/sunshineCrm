<?php

function changeUserInfo($params)
{
	global $db,$MYSQL_DB;
	
	$result=array();
	$UID=intval($params['用户较验码']['0']);
	$UTYPE=intval($params['用户较验码']['2']);
	$fieldName=$params['fieldName'];
	$newValue=$params['newValue'];
	
	if(empty($fieldName))
		throw new Exception('字段名不能为空');
	if(empty($newValue))
		$newValue='';
	if($UTYPE>0)//员工修改密码
	{
		$sql="SELECT * FROM information_schema.COLUMNS WHERE TABLE_SCHEMA='$MYSQL_DB' AND TABLE_NAME='user' AND COLUMN_NAME=?";
		$rs_a=$db->GetAll($sql,array($fieldName));
		if(sizeof($rs_a)==0)
			throw new Exception('字段名不存在');
		$sql="update user set $fieldName=? where UID=?";
		$db->Execute($sql,array($newValue,$UID));
		$result['result']='成功';
		$result['newValue']=$newValue;
		insert_log("修改手机号",$params['用户较验码']['1'],$sql);
	}
	else//处理客户修改密码
	{

	}
	return $result;
}
?>