<?php
//通过用户名获取用户信息
function getUserByUseridOrID($userid,$UID='')
{
	global $db;
	$result=array();
	if(!empty($userid))
	{
		$sql="select * from `user` where user_id=?";
		$rs_a=$db->GetAll($sql,array($userid));
	}
	else
	{
		$sql="select * from `user` where uid=?";
		$rs_a=$db->GetAll($sql,array($UID));
	}
	if(!empty($rs_a))
	{
		$result['编号']		=	$rs_a[0]['UID'];
		$result['用户名']	=	$rs_a[0]['USER_ID'];
		$result['部门ID']	=	$rs_a[0]['DEPT_ID'];
		$result['用户类型']=	$rs_a[0]['USER_PRIV'];
		$result['用户头像']	=	htmlspecialchars_decode($rs_a[0]['AVATAR']);
		$result['手机']	=	$rs_a[0]['MOBIL_NO'];
		$result['是否启用']	=	$rs_a[0]['DISABLED'];
		$result['姓名']=	$rs_a[0]['USER_NAME'];
		$result['出生日期']=	$rs_a[0]['BIRTHDAY'];
		$result['性别']=	$rs_a[0]['SEX'];
		$result['地址']=	$rs_a[0]['ADD_HOME'];
		$result['用户唯一码']=$result['用户类型']."_".$result['编号'];
		$result['登录时间']	= $rs_a[0]['LAST_PASS_TIME'];

		$DEPT_ID=$rs_a[0]['DEPT_ID'];
		$sql="select DEPT_NAME,bundleStore from department where DEPT_ID=?";
		$rs_d=$db->Execute($sql,array($DEPT_ID));
		$DEPT_NAME=$rs_d->fields['DEPT_NAME'];
		$STORE_PRIV=$rs_d->fields['bundleStore'];
		if($STORE_PRIV!='' && substr($STORE_PRIV,-1)==',')
			$STORE_PRIV=substr($STORE_PRIV,0,strlen($STORE_PRIV)-1);
		$USER_PRIV=$rs_a[0]['USER_PRIV'];
		$result['部门']	=	$DEPT_NAME;

		$sql="select PRIV_NAME from user_priv where USER_PRIV=?";
		$rs_u=$db->Execute($sql,array($USER_PRIV));
		$PRIV_NAME=$rs_u->fields['PRIV_NAME'];
		$result['角色名称']	=	$PRIV_NAME;

		$sql="select UNIT_NAME,shortname  from unit where id=1";
		$rs_u=$db->Execute($sql);
		$result['单位名称'] = $rs_u->fields['UNIT_NAME'];
		$result['单位']	= $rs_u->fields['shortname'];
		
		
	}
	return $result;
}
function getCustomerInfo($destUID)
{
	global $db;
	$result=array();
	$sql="select a.*,b.name as levelName from customer a inner join customerlever b on a.state=b.ROWID where a.ROWID=?";
	$customer=$db->GetRow($sql,array($destUID));
	if(!empty($customer))
	{
		$result['姓名']=$customer['supplyname'];
		$result['角色名称']=$customer['levelName'];
		$result['会员卡']=$customer['membercard'];
		$result['手机']=$customer['phone'];
		$result['地址']=$customer['contactaddress'];
		$result['电邮']=$customer['email'];
		
		$sql="select USER_NAME from user where USER_ID=?";
		$sysUser=$db->GetOne($sql,array($customer['sysuser']));
		
		$result['隶属人']=$sysUser;
		$result['预储值']=$customer['yuchuzhi'];
		$sql="select name from customerbelong where id=?";
		$datascope=$db->GetOne($sql,array($customer['datascope']));
		$result['查看权限']=$datascope;
		$result['积分']=$customer['integral'];
		if(empty($customer['avatar']))
		{
			$fileName='avatars/'.$customer['levelName'].'.png';
			$fileNameGbk=iconv('UTF-8','GB2312',$fileName);
			if(!file_exists($fileNameGbk))
			{
				require_once('utility/showChinaText.php');
				$showChinaText = new showChinaText();
				if($customer['levelName']=='钻石会员')
				{
					$color_R=144;
					$color_G=58;
					$color_B=199;
				}
				else if($customer['levelName']=='VIP会员')
				{
					$color_R=205;
					$color_G=60;
					$color_B=156;
				}
				else if($customer['levelName']=='白金会员')
				{
					$color_R=231;
					$color_G=126;
					$color_B=68;
				}
				else
				{
					$color_R=70;
					$color_G=200;
					$color_B=59;
				}
				$showChinaText->show_firstword($customer['levelName'],$fileName,$color_R,$color_G,$color_B);
			}
			$customer['avatar']=getCurPath()."/".$fileName;
		}
		$result['用户头像']=htmlspecialchars_decode($customer['avatar']);
		$result['退货率']=$customer['tuihuorate'];
		$result['最低折扣']=$customer['minzhekou'];
		$result['创建时间']=$customer['createdate'];
		$result['用户类型']=0;
		$result['编号']=$customer['ROWID'];
		$sql="select UNIT_NAME,shortname  from unit where id=1";
		$rs_u=$db->Execute($sql);
		$result['单位名称'] = $rs_u->fields['UNIT_NAME'];
		$result['单位']	= $rs_u->fields['shortname'];

		$sql="select * from sellplanmain where supplyid=? and user_flag>0 order by billid desc limit 1";
		$billInfo=$db->GetRow($sql,array($destUID));
		if(!empty($billInfo))
			$result['最近交易']=substr($billInfo['createtime'],0,10)." 金额:".number_format($billInfo['totalmoney'],2);
	}
	return $result;
}
function insert_log($LOGINACTION,$userid,$SQL)		{
	global $db;
	//print_R($_SERVER);
	//$LOGINACTION
	$DATETIME = date("Y-m-d H:i:s");
	$REMOTE_ADDR = $_SERVER['REMOTE_ADDR'];
	$HTTP_USER_AGENT = $_SERVER['HTTP_USER_AGENT'];
	$QUERY_STRING = $_SERVER['QUERY_STRING'];
	$tmparray=explode('password=',$QUERY_STRING);
	$QUERY_STRING=$tmparray[0];
	$SCRIPT_NAME = $_SERVER['SCRIPT_NAME'];
	if($_GET['USER_ID']!="")				{
			$LOGIN_USER_ID = $_GET['USER_ID'];
	}
	$SQL = ereg_replace("'","&#039;",$SQL);;
	$sql = "insert into system_log(loginaction,DATE,REMOTE_ADDR,HTTP_USER_AGENT,QUERY_STRING,SCRIPT_NAME,USERID,SQLTEXT)
			values('$LOGINACTION','$DATETIME','$REMOTE_ADDR','$HTTP_USER_AGENT','$QUERY_STRING','$SCRIPT_NAME','$userid','$SQL');";
	$db->Execute($sql);
	//print $sql;exit;


}
//对字符串进行加密解密
function encrypt($string,$operation,$key='')
{
	$key=md5($key);
	$key_length=strlen($key);
	$string=$operation=='D'?base64_decode($string):substr(md5($string.$key),0,8).$string;
	$string_length=strlen($string);
	$rndkey=$box=array();
	$result='';
	for($i=0;$i<=255;$i++)
	{
		$rndkey[$i]=ord($key[$i%$key_length]);
		$box[$i]=$i;
	}
	for($j=$i=0;$i<256;$i++)
	{
		$j=($j+$box[$i]+$rndkey[$i])%256;
		$tmp=$box[$i];
		$box[$i]=$box[$j];
		$box[$j]=$tmp;
	}
	for($a=$j=$i=0;$i<$string_length;$i++)
	{
		$a=($a+1)%256;
		$j=($j+$box[$a])%256;
		$tmp=$box[$a];
		$box[$a]=$box[$j];
		$box[$j]=$tmp;
		$result.=chr(ord($string[$i])^($box[($box[$a]+$box[$j])%256]));
	}
	if($operation=='D')
	{
		if(substr($result,0,8)==substr(md5(substr($result,8).$key),0,8))
		{
			return substr($result,8);
		}
		else
		{
			return'';
		}
	}
	else
	{
		return str_replace('=','',base64_encode($result));
	}
}
//得到文件扩展名
function get_file_extName($file)
{
	return substr(strrchr($file, '.'), 1);
}
//得到文件名
function get_file_realName($file)
{
	$tempArray=explode("/",$file);
	return $tempArray[sizeof($tempArray)-1];
}
function attach_id_encode( $ATTACHMENT_ID, $ATTACHMENT_NAME )
{
	if ( strstr( $ATTACHMENT_ID, "_" ) )
	{
					$ATTACHMENT_ID = substr( $ATTACHMENT_ID, strpos( $ATTACHMENT_ID, "_" ) + 1 );
	}
	if ( strstr( $ATTACHMENT_ID, "." ) )
	{
					$ATTACHMENT_ID = substr( $ATTACHMENT_ID, 0, strpos( $ATTACHMENT_ID, "." ) );
	}
	return $ATTACHMENT_ID ^ crc32( $ATTACHMENT_NAME );
}
function getRoleByUser($sql,$fieldname,$UDeptId,$UType,$UName)		{
	global $db;
	$subdeptrole=getSubDeptListByParent($UDeptId);
	if($subdeptrole!='')
	$deptrole="'".$UDeptId."',".$subdeptrole;
	else
	$deptrole="'".$UDeptId."'";
	if($subdeptrole=="")
		$subdeptrole="''";
	global $_SESSION;
	if($UType=='2')
		$sql = $sql." and ($fieldname in (select user_id from user where dept_id in (".$deptrole.")))";
	else if($UType=='3')
		$sql = $sql." and ($fieldname='".$UName."' or $fieldname in (select user_id from user where dept_id in (".$subdeptrole.")))";
	return $sql;
}
//递归取得子部门
function getSubDeptListByParent($parent)
{
	global $db;
	$subdeptlist="";
	$sql="select * from department where dept_parent=$parent";
	$rs=$db->Execute($sql);
	$rs_a=$rs->GetArray();
	for($i=0;$i<sizeof($rs_a);$i++)
	{
		if($subdeptlist=='')
			$subdeptlist="'".$rs_a[$i]["DEPT_ID"]."'";
		else
			$subdeptlist=$subdeptlist.",'".$rs_a[$i]["DEPT_ID"]."'";
		$subdept=getSubDeptListByParent($rs_a[$i]["DEPT_ID"]);
		if($subdept!='')
			$subdeptlist.=",".$subdept;
	}
	return $subdeptlist;
}
//获取用户可用仓库
function getStoreByUser($deptid,$UName)
{
	global $db;
	$storeArray=array();
	$sql="select bundleStore from department where DEPT_ID=?";
	$bundleStore=$db->GetOne($sql,array($deptid));
	if(!empty($bundleStore))
	{
		$sql="select rowid,name from stock where rowid in (?)";
		$rs_a=$db->GetAll($sql,array($bundleStore));
		if(!empty($rs_a))
			$storeArray=$rs_a;
	}
	$tempArray=explode(",",$bundleStore);

	$sql="select rowid,name from stock where find_in_set(?,user_id)";
	$rs_a=$db->GetAll($sql,array($UName));
	if(!empty($rs_a))
		$storeArray=array_merge($storeArray,$rs_a);
	$storeArray=array_unique($storeArray);
	return $storeArray;

}
//编辑销售单明细
function getBillDetail($billid,$tablename)
{
	global $db;
	/*
	$sql="select * from sellplanmain_detail where mainrowid=".$billid." limit 1";
	$rs=$db->Execute($sql);
	$rs_a=$rs->GetArray();
	if(sizeof($rs_a)>0)
	{
		$db->StartTrans();
		$sql="delete from sellplanmain_detail_tmp where mainrowid=".$billid;
		$db->Execute($sql);
		$sql="insert into sellplanmain_detail_tmp (prodid,prodname,prodguige,prodxinghao,proddanwei,price,zhekou,num,beizhu,mainrowid,jine,chukunum,lirun,oldprodid,opertype,orderid,inputtime,sellprice) (select prodid,prodname,prodguige,prodxinghao,proddanwei,price,zhekou,num,beizhu,mainrowid,jine,chukunum,lirun,oldprodid,opertype,orderid,inputtime,sellprice from sellplanmain_detail where mainrowid=".$billid.")";
		$db->Execute($sql);
		$sql="delete from sellplanmain_detail where mainrowid=".$billid;
		$db->Execute($sql);
		if ($db->HasFailedTrans()) 
			throw new Exception($db->ErrorMsg());
		$db->CompleteTrans();
	}
	*/
	$sql="select * from $tablename where mainrowid=".$billid;
	$rs_a=$db->GetAll($sql);
	return $rs_a;
}
function getkucunByprodid($prodid,$storeid)
{
	global $db;
	$sql="select * from store where prodid=? and storeid=?";
	$rs_a=$db->GetRow($sql,array($prodid,$storeid));
	return $rs_a;
}
function getProductByprodid($prodid)
{
	global $db;
	$sql="select a.*,b.name as producttypename,c.name as colorname,d.supplyname from product a left join producttype b on a.producttype=b.rowid left join productcolor c on a.standard=c.id left join supply d on a.supplyid=d.rowid where a.productid=?";
	$rs_a=$db->GetRow($sql,array($prodid));
	return $rs_a;
}
function getBillDetailJson($billid,$functionName,$tablename)
{
	$result['标题显示']='单据明细';
	$result['操作类型']='edit';
	$result['新增URL']='?function='.$functionName.'&action=newDetail&billid='.$billid;
	$sumMoney=getSellPlanMainDetailSum($billid,$tablename);
	$billObj=getSellPlanMain($billid);
	$tuihuorate=getCustomerTuihuoRate($billObj['supplyid']);

	$result['汇总1']="销售数:".intval($sumMoney['sellnum']);
	if(intval($sumMoney['tuihuonum'])>0)
		$result['汇总1'].=" 退货数:".$sumMoney['tuihuonum'];
	if(intval($sumMoney['zengpinnum'])>0)
		$result['汇总1'].=" 赠品数:".$sumMoney['zengpinnum'];
	if($tuihuorate>0 && $sumMoney['sellmoney']>0)
		$result['汇总1'].=" 退货限制:".round($sumMoney['sellmoney']*$tuihuorate/100,2);	
	$result['汇总2']="售￥:".number_format($sumMoney['sellmoney'],2);
	if(floatval($sumMoney['tuihuomoney'])>0)
		$result['汇总2'].=" 退￥:".number_format($sumMoney['tuihuomoney'],2);
	if(floatval($sumMoney['zengpinmoney'])>0)
		$result['汇总2'].=" 赠￥:".number_format($sumMoney['zengpinmoney'],2);
	$result['总金额']=number_format($sumMoney['allmoney'],2);

	$detailArray=getBillDetail($billid,$tablename);
	$result['单据明细']=array();
	
	
	for($i=0;$i<sizeof($detailArray);$i++) {
		$value=$detailArray[$i];
		$item=array();
		$item['id']=$value['id'];
		$item['prodid']=$value['prodid'];
		$item['title']=$value['prodid']." ".$value['prodname'];
		//$price=number_format(round($value['price']*$value['zhekou'],2),2);
		//$jine=number_format(round($value['price']*$value['zhekou']*$value['num'],2),2);
		if(doubleval($value['zhekou'])==0)
			$item['detail']=" ￥:".number_format(round($value['price']*$value['zengpinzhekou'],2),2);
		else
			$item['detail']=" ￥:".number_format(round($value['price']*$value['zhekou'],2),2);
		if($value['zhekou']!=1)
			$item['detail'].=' ('.$value['price'].' X '.round($value['zhekou']*100).'%)';
		$item['num']=$value['num'];
		if($value['opertype']==1)
			$item['opertype']='售';
		else if($value['opertype']==0)
			$item['opertype']='赠';
		else if($value['opertype']==-1)
			$item['opertype']='退';
		$prodInfo=getProductByprodid($value['prodid']);

		if(!empty($prodInfo['fileaddress']))
			$item['prodImage']=$value['prodImage'];
		else
			$item['prodImage']=getCurPath().'/images/gift.png';
		$item['hiddenBtn']=getCurPath().'/images/删除.png';
		$item['hiddenBtnUrl']='?function='.$functionName.'&action=deleteDetail&billid='.$billid.'&detailId='.$value['id'];
		
		$result['单据明细'][]=$item;
	}

	return $result;
}
function getCurPath()
{
	return dirname('http://'.$_SERVER['SERVER_NAME'].':'.$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"]);
}
function getSellPlanMain($billid)
{
	global $db;
	$sql="select * from sellplanmain where billid=?";
	$rs_a=$db->GetRow($sql,array($billid));
	return $rs_a;
}
function getSellPlanMainDetailSum($billid,$tablename)
{
	global $db;
	$sql="select sum(if(opertype=1,num,0)) as sellnum,sum(if(opertype=0,num,0)) as zengpinnum,sum(if(opertype=-1,-num,0)) as tuihuonum,sum(if(opertype=1,price*zhekou*num,0)) as sellmoney,sum(if(opertype=0,price*zengpinzhekou*num,0)) as zengpinmoney,sum(if(opertype=-1,-price*zhekou*num,0)) as tuihuomoney,sum(num) as allnum,sum(price*zhekou*num) as allmoney from $tablename where mainrowid=?";
	$sumMoney=$db->GetRow($sql,array($billid));
	return $sumMoney;
}
function getCustomerTuihuoRate($customerid)
{
	global $db;
	$sql="select a.tuihuorate,b.tuihuorate as tuihuorate1 from customer a inner join customerlever b on a.state=b.ROWID where a.ROWID=?";
	$row=$db->GetRow($sql,array($customerid));
	$tuihuorate=$row['tuihuorate'];
	if($tuihuorate=='')
		$tuihuorate=$row['tuihuorate1'];
	return intval($tuihuorate);
}

?>