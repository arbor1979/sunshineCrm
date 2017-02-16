<?php

function versionDetect($params)
{
	global $db;
	
	$result=array();
	$UID=$params['用户较验码']['0'];
	$curVersion=$params['当前版本号'];

	if(empty($curVersion))
		throw new Exception('当前版本不能为空');
	
	$goalfile = "version/update.ini";
	$ini_file = @parse_ini_file( $goalfile );
	$versionCode=floatval($ini_file['versionCode']);
	$updateContent=$ini_file['updateContent'];
	$updateTime=$ini_file['updateTime'];
	$fileName=$ini_file['fileName'];
	
	if($versionCode>$curVersion)
	{
		$result['下载地址']=getCurPath().'/version/'.$fileName;
		$updateContent=str_replace("\\n", "\n", $updateContent);
		$result['功能更新']=$updateContent."\n发布时间:".$updateTime;
		$result['最新版本号']=$versionCode;
	}
	else
	{
		$result['下载地址']='';
		$result['功能更新']='';
		$result['最新版本号']='';
	}
	
	return $result;
}
?>