<?php

function module_notice($params)
{
	global $db;
	
	$result=array();
	$UID=$params['用户较验码']['0'];
	$UName=$params['用户较验码']['1'];
	$action=$params['action'];
	$LASTID=intval($params['LASTID']);
	$result['适用模板']="通知";
	$result['标题显示']="公告通知";
	$notifyArray=array();
	
	if($UID>0)
	{
		if(empty($action))
		{
			$sql="select * from notify where FIND_IN_SET(?,to_user) and id>?";
			$rs_a=$db->GetAll($sql,array($UName,$LASTID));
			foreach((array)$rs_a as $item)
			{
				$notify['编号']=$item['id'];
				$notify['第一行主题']=$item['title'];
				$notify['第一行右边']=$item['createtime'];
				$notify['通知内容']=strip_tags(htmlspecialchars_decode($item['content']));
				$notify['最下边一行文本']="阅读全文";
				$notify['最下边一行URL']="?ID=".$item['id']."&action=pageview";
				$readedArray=explode(',',$item['ifread']);
				if(in_array($UName,$readedArray))
					$notify['已阅']='1';
				else
					$notify['已阅']='0';
				
				//http://119.29.6.239:92/general/ERP/Enginee/lib/attach.php?MODULE=ERP&YM=1701&ATTACHMENT_ID=1371025453&ATTACHMENT_NAME=Screenshot_1484122074.png
				//Screenshot_1484122074.png*Screenshot_1484122061.png*Screenshot_1484122056.png*Screenshot_1484122025.png*||1701_2037037012,1701_247314205,1701_791134648,1701_1530299245,
				
				$notify['第二行图片区URL']=getFirstImageUrl($item);
				$notifyArray[]=$notify;
			}
			$result['通知项']=$notifyArray;
		}
		else if($action=='pageview')
		{
			
			$sql="select * from notify where id=?";
			$item=$db->GetRow($sql,array($params['ID']));
			$result['标题']=$item['title'];
			$sql="select USER_NAME from user where USER_ID=?";
			$user_name=$db->GetOne($sql,array($item['from_user']));
			$result['第二行']="发布时间:".$item['createtime']."\n 发布人:".$user_name;
			$result['第二行图片区URL']=getFirstImageUrl($item);
			$result['通知内容']=htmlspecialchars_decode($item['content']);
			$result['附件']=getFuJianArray($item);
			$result['图片数组']=getImageArray($item);
		}
		else if($action=='ifread')
		{
			$sql="select * from notify where id=?";
			$item=$db->GetRow($sql,array($params['ID']));
			$readStr=$item['ifread'];
			if(empty($readStr))
				$readStr=$UName.",";
			else
			{
				$tempArray=explode(',',$readStr);
				if(!in_array($UName,$tempArray))
					$readStr.=$UName.",";
			}
			$sql="update notify set ifread=? where id=?";
			$db->Execute($sql,array($readStr,$params['ID']));
			$result['result']="成功";
		}
	}
	
	return $result;
}
function getFirstImageUrl($item)
{
	$imageUrl="";
	if(!empty($item['ATTACHMENT']))
	{
		$url='http://'.$_SERVER['SERVER_NAME'].':'.$_SERVER["SERVER_PORT"]."/general/ERP/Enginee/lib/attach.php";
		$tempArray=explode("||",$item['ATTACHMENT']);
		$imageNameArray=explode("*",$tempArray[0]);
		$imageIdArray=explode(",",$tempArray[1]);
		for($i=0;$i<sizeof($imageNameArray);$i++)
		{
			$imageName=$imageNameArray[$i];
			$idArray=explode("_",$imageIdArray[$i]);
			$YM=$idArray[0];
			$imageId=$idArray[1];
			$extName=get_file_extName($imageName);
			$imageId=attach_id_encode($imageId,$imageName);
			if (in_array(strtolower($extName),array("jpg","png","jpeg"))) 
			{
				$imageUrl=$url."?MODULE=ERP&YM=".$YM."&ATTACHMENT_ID=".$imageId."&ATTACHMENT_NAME=".$imageName;
				break;
			}
		}
	}
	return $imageUrl;
}
function getFuJianArray($item)
{
	$fujianArray=array();
	if(!empty($item['ATTACHMENT']))
	{
		$url='http://'.$_SERVER['SERVER_NAME'].':'.$_SERVER["SERVER_PORT"]."/general/ERP/Enginee/lib/attach.php";
		$tempArray=explode("||",$item['ATTACHMENT']);
		$imageNameArray=explode("*",$tempArray[0]);
		$imageIdArray=explode(",",$tempArray[1]);
		for($i=0;$i<sizeof($imageNameArray);$i++)
		{
			$imageName=$imageNameArray[$i];
			$idArray=explode("_",$imageIdArray[$i]);
			$YM=$idArray[0];
			$imageId=$idArray[1];
			$extName=get_file_extName($imageName);
			$imageId=attach_id_encode($imageId,$imageName);
			$fujian=array();
			$fujian['url']=$url."?MODULE=ERP&YM=".$YM."&ATTACHMENT_ID=".$imageId."&ATTACHMENT_NAME=".$imageName;
			$fujian['name']=$imageName;
			$fujianArray[]=$fujian;
		}
	}
	return $fujianArray;
}
function getImageArray($item)
{
	$fujianArray=array();
	if(!empty($item['ATTACHMENT']))
	{
		$url='http://'.$_SERVER['SERVER_NAME'].':'.$_SERVER["SERVER_PORT"]."/general/ERP/Enginee/lib/attach.php";
		$tempArray=explode("||",$item['ATTACHMENT']);
		$imageNameArray=explode("*",$tempArray[0]);
		$imageIdArray=explode(",",$tempArray[1]);
		for($i=0;$i<sizeof($imageNameArray);$i++)
		{
			$imageName=$imageNameArray[$i];
			$idArray=explode("_",$imageIdArray[$i]);
			$YM=$idArray[0];
			$imageId=$idArray[1];
			$extName=get_file_extName($imageName);
			$imageId=attach_id_encode($imageId,$imageName);
			$fujian=array();
			if (in_array(strtolower($extName),array("jpg","png","jpeg"))) 
			{
				$fujianArray[]=$url."?MODULE=ERP&YM=".$YM."&ATTACHMENT_ID=".$imageId."&ATTACHMENT_NAME=".$imageName;
			}
		}
	}
	return $fujianArray;
}
?>