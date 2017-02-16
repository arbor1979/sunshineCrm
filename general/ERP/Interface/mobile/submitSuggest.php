<?php

function submitSuggest($params)
{
	global $db;
	
	$result=array();
	$UID=$params['用户较验码']['0'];
	$content=$params['CONTENT'];

	if(empty($content))
		throw new Exception('内容不能为空');

	$sql="select * from `user` where uid=1 or USER_ID='admin'";
	$rs_a=$db->GetAll($sql,array($UID));

	if(empty($rs_a))
		throw new Exception('不存在admin用户,无法发送建议给他');
	else
	{
		$toUserId=$rs_a[0]['UID'];
		$toUserType=$rs_a[0]['USER_PRIV'];
		$db->StartTrans();
		$sql="insert into mobile_message_main (fromUserId,fromUserType,content,contentType,sendTime,destCount) values(?,?,?,1,'".date('Y-m-d H:i:s')."',1)";
		$db->Execute($sql,array($toUserId,$toUserType,$content));
		$mainId=$db->Insert_ID();
		$sql="insert into mobile_message_detail (mainId,toUserId,toUserType) values(?,?,?)";
		$db->Execute($sql,array($mainId,$toUserId,$toUserType));
		$db->CompleteTrans();
		if ($db->HasFailedTrans()) 
			throw new Exception($db->ErrorMsg());
		$result['result']='成功';
		
	}
	
	return $result;
}
?>