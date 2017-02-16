<?php
function doLogin($params)
{
	global $db;
	$result=array();
	$username=$params['username'];
	$password=$params['password'];
	if(empty($username))
		throw new Exception('用户名不能为空');
	$sql="select * from `user` where user_id=?";
	$rs_a=$db->GetAll($sql,array($username));

	if(empty($rs_a))
		throw new Exception('不存在此用户');
	else
	{
		$PasswordText=$rs_a[0]['PASSWORD'];
		if(crypt($password,$PasswordText) == $PasswordText)	
		{
			
			$DISABLED=$rs_a[0]['DISABLED'];
			if($DISABLED==0)
				throw new Exception('用户被禁用');
			else
			{
				$result=getUserByUseridOrID($username);
				
				$goalfile = "../Interface/Framework/global_config.ini";
				@$ini_file = @parse_ini_file( $goalfile );
				$result['limitEditDel']=(empty($ini_file[limitEditDel])?0:1);
				//$result['ModifyPrice']=(empty($ini_file[ModifyPrice])?0:1);
				$result['TuiHuoRate']=(empty($ini_file[TuiHuoRate])?'':$ini_file[TuiHuoRate]);
				$token=$result['编号']."||||".$result['用户名']."||||".$result['用户类型']."||||".$result['部门ID']."||||".date('Y-m-d H:i:s');
				$result['用户较验码']= encrypt($token,'E','queen');
				//获得站点主题
				$sql="select * from unit where id=1";
				$rs_a=$db->GetAll($sql);
				$result['logo']=htmlspecialchars_decode($rs_a[0]['logo']);
				$result['color']['backgroundColor']=$rs_a[0]['backgroundColor'];
				$result['color']['tabbarColor']=$rs_a[0]['tabbarColor'];
				$result['color']['navibarColor']=$rs_a[0]['navibarColor'];
				$result['color']['menuColor']=$rs_a[0]['menuColor'];
				$result['color']['listColor']=$rs_a[0]['listColor'];

				$result['登录时间']=date('Y-m-d H:i:s');
				$sql="update `user` set LAST_PASS_TIME='".date('Y-m-d H:i:s')."',MY_STATUS=? where user_id=?";
				$db->Execute($sql,array($result['用户较验码'],$username));
				insert_log("登录成功",$username,$username);
			}
		}
		else
			throw new Exception('密码不正确');
	}

	return $result;
}

?>