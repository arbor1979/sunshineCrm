<?php

function postBaiduPushId($params)
{
	global $db;
	
	$result=array();
	$UID=$params['用户较验码']['0'];
	$UType=$params['用户较验码']['2'];

	$baidu_userid=$params['baidu_userid'];
	$baidu_channelid=$params['baidu_channelid'];
	$设备唯一码=$params['设备唯一码'];
	$设备名=$params['设备名'];
	$设备类型=$params['设备类型'];
	$本地模式=$params['本地模式'];
	$系统名=$params['系统名'];
	$系统版本=$params['系统版本'];
	$分辨率=$params['分辨率'];

	if(empty($baidu_userid))
		throw new Exception('百度推送ID不能为空');
	if(empty($baidu_channelid))
		throw new Exception('百度推送ID不能为空');
	$db->StartTrans();
	//$db->debug=true;
	$sql="select * from `baiduuserid` where uid='$UID' and utype='$UType' limit 1";
	$rs_a=$db->GetRow($sql);

	if(empty($rs_a))
		$sql="insert baiduuserid (uid,utype,baidu_userid,baidu_channelid,bindTime) values('$UID','$UType',?,?,now())";
	else
		$sql="update baiduuserid set baidu_userid=?,baidu_channelid=?,bindTime=now() where uid='$UID' and utype='$UType'";
	$db->Execute($sql,array($baidu_userid,$baidu_channelid));
	$sql="delete from baiduuserid where baidu_userid=? and baidu_channelid=? and (uid<>'$UID' or utype<>'$UType')";
	$db->Execute($sql,array($baidu_userid,$baidu_channelid));

	$sql="select * from userdevices where uid='$UID' and utype='$UType' and deviceid=?";
	$rs_a=$db->GetRow($sql,array($设备唯一码));
	if(empty($rs_a))
	{
		$sql="insert into userdevices (uid,utype,deviceid,devicename,devicetype,devicemode,systemname,systemversion,screensize,createtime) values('$UID','$UType',?,?,?,?,?,?,?,now())";
		$db->Execute($sql,array($设备唯一码,$设备名,$设备类型,$本地模式,$系统名,$系统版本,$分辨率));
	}
	else
	{
		$sql="update userdevices set createtime=now() where uid='$UID' and utype='$UType' and deviceid=?";
		$db->GetRow($sql,array($设备唯一码));
	}
	if ($db->HasFailedTrans()) 
			throw new Exception($db->ErrorMsg());
	$db->CompleteTrans();
	$result['result']='成功';	
	return $result;
}
?>