<?php
header("Content-type:text/html;charset=utf-8");

require_once('../../config.inc.php');
require_once('../../Framework/cache.inc.php');
require_once('../../adodb/adodb.inc.php');
require_once('../../setting.inc.php');
require_once('utility/common.php');
//$db->debug=true;
ini_set('display_errors', 1);
ini_set('error_reporting', E_ERROR | E_WARNING | E_PARSE);
$db->Execute("set names utf8;");
$function=$_REQUEST['function'];
$result=array();
try
{
	if(empty($function))
		throw new Exception('参数不能为空');
	if(!in_array($function,array('doLogin')))
	{
		if(empty($_REQUEST['用户较验码']))
			$_REQUEST['用户较验码']=$_REQUEST['token'];
		$token=$_REQUEST['用户较验码'];
		if(empty($token))
			throw new Exception('用户令牌不能为空');
		$desToken=encrypt($token,'D','queen');
		$tempArray=explode('||||',$desToken);
		$tokenDate=$tempArray[4];
		if(empty($tokenDate))
			throw new Exception('用户令牌格式不正确');
		if(time()-strtotime($tokenDate)>3600*24)
			throw new Exception('用户令牌过期，请重新登录');
		/*
		$sql="select MY_STATUS from user where UID=?";
		$oldToken=$db->getOne($sql,$tempArray[0]);
		if($token!==$oldToken)
			throw new Exception('用户令牌失效，请重新登录');
		*/
		$_REQUEST['用户较验码']=$tempArray;
	}
	
	if(file_exists($function.'.php'))
	{
		
		require_once($function.'.php');
		
		if(function_exists($function))
		{
			$result=$function($_REQUEST);
		}
		else
			throw new Exception('函数未定义');
	}
	else
		throw new Exception('文件不存在');
	echo json_encode($result);
}
catch(Exception $e)
{
	$result =array
		(
			'result'=>'失败',
			'errorMsg'=>$e->getMessage()
		);
	echo json_encode($result);
	//print_r($result);
	
}
?>