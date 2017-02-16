<?php 
require_once('Utility.php');
class CaiWu
{
	var $db;
	var $utility;
	var $char;
	function __construct($db,$char='') {
       $this->db=&$db;
	   $this->char=$char;
	   $this->utility=new Utility($db);
   }
	function changeChar($content)
	{
		if($this->char=='utf-8')
			return iconv('gb2312','utf-8',$content);
		else
			return $content;
	}
	//更新订单表的状态
	function updatesellplanmainhuikuan($dingdanid)
	{
		$sellplaninfo=$this->utility->returntablefield("sellplanmain", "billid", $dingdanid, "totalmoney,ifpay,huikuanjine,kaipiaojine,oddment,fahuostate,kaipiaostate,user_flag,billtype,jifenchongdimoney");
		$huikuanjine=$sellplaninfo['huikuanjine'];
		$kaipiaojine=$sellplaninfo['kaipiaojine'];
		$oddment=$sellplaninfo['oddment'];
		$totalmoney=$sellplaninfo['totalmoney'];
		$kaipiaostate=$sellplaninfo['kaipiaostate'];
		$jifenchongdimoney=$sellplaninfo['jifenchongdimoney'];
		if(round($totalmoney,2)==round($huikuanjine+$oddment+$jifenchongdimoney,2))
			$ifpay=2;
		else
		{
			if($huikuanjine!=0)
				$ifpay=1;
			else
				$ifpay=0;
		}
		if($totalmoney==$kaipiaojine)
			$kaipiaostate=4;
		else 
		{
			if($kaipiaojine!=0)
				$kaipiaostate=3;
			else
			{
				if($kaipiaostate!=-1)
					$kaipiaostate=0; 
			}
		}
		$sql="update sellplanmain set ifpay=$ifpay,kaipiaostate=$kaipiaostate where billid=$dingdanid";
		$this->db->Execute($sql);
		
		$this->updatesellplanmainFlag($dingdanid);
			
	}
	function updatesellplanmainFlag($dingdanid,$test='')
	{
		
		$sellplaninfo=$this->utility->returntablefield("sellplanmain", "billid", $dingdanid, "totalmoney,ifpay,huikuanjine,kaipiaojine,oddment,fahuostate,kaipiaostate,user_flag,billtype");
		
		$ifpay=$sellplaninfo['ifpay'];
		$fahuostate=$sellplaninfo['fahuostate'];
		$kaipiaostate=$sellplaninfo['kaipiaostate'];
		$user_flag=$sellplaninfo['user_flag'];
		$oldflag=$user_flag;
		if($user_flag!=-1)
		{
			if($sellplaninfo['billtype']==3)
			{
				
				if($fahuostate==-1)
				{
					
					$ifchuku=false;
					
					$billid=$this->utility->returntablefield("stockoutmain", "dingdanbillid", $dingdanid, "billid","state",$this->changeChar("已出库"),"outtype",$this->changeChar("销售出库"));
					if($billid!='')
					{
						$ifchuku=true;
					}
					
					$billid=$this->utility->returntablefield("stockinmain", "caigoubillid", $dingdanid, "billid","state",$this->changeChar("已入库"),"intype",$this->changeChar("退货入库"));
					if($billid!='')
						$ifchuku=true;
					if($ifpay==2 && $ifchuku)
					{
						$user_flag=2;
						
					}
					else if($ifpay==0 && !$ifchuku && $kaipiaostate<=0)
						$user_flag=0;
					else 
						$user_flag=1;
					
				}
				else 
				{
					if($ifpay==2 && $fahuostate==4)
						$user_flag=2;
					else if($fahuostate==0 && $ifpay==0 && $kaipiaostate<=0)
						$user_flag=0;
					else 
						$user_flag=1;
				}
			}
			else 
			{
				if($fahuostate==4 && $ifpay==2)
					$user_flag=2;
				else if($fahuostate==0 && $ifpay==0 && $kaipiaostate==0)
					$user_flag=0;
				else 
					$user_flag=1;
			}

		}
		
		$sql="update sellplanmain set user_flag=$user_flag where billid=$dingdanid";
		$this->db->Execute($sql);
		
		if($user_flag==0)//将销售单明细
		{
			$sql="select * from sellplanmain_detail where mainrowid=".$dingdanid." limit 1";
			$rs=$this->db->Execute($sql);
			$rs_a=$rs->GetArray();
			if(sizeof($rs_a)>0)
			{
				$sql="delete from sellplanmain_detail_tmp where mainrowid=".$dingdanid;
				$this->db->Execute($sql);
				$sql="insert into sellplanmain_detail_tmp (prodid,prodname,prodguige,prodxinghao,proddanwei,price,zhekou,num,beizhu,mainrowid,jine,chukunum,lirun,oldprodid,opertype,orderid,inputtime,sellprice) (select prodid,prodname,prodguige,prodxinghao,proddanwei,price,zhekou,num,beizhu,mainrowid,jine,chukunum,lirun,oldprodid,opertype,orderid,inputtime,sellprice from sellplanmain_detail where mainrowid=".$dingdanid.")";
				$this->db->Execute($sql);
				$sql="delete from sellplanmain_detail where mainrowid=".$dingdanid;
				$this->db->Execute($sql);
			}
		}
		
		if(($oldflag==0 && $user_flag>0) || ($oldflag>0 && $user_flag==0))
			$this->updatesellplanmainJifen($dingdanid,$user_flag);
	}
	//更新积分
	function updatesellplanmainJifen($dingdanid,$user_flag)
	{

		@$global_config_ini_file = @parse_ini_file(DOCUMENT_ROOT.'general/ERP/Interface/Framework/global_config.ini',true);
		$exchange=$global_config_ini_file['section']['integral'];
		$birthdayDoubleIntegral=$global_config_ini_file['section']['birthdayDoubleIntegral'];
		
		if($exchange != 0)
		{
			$sql = "select a.zhuti,a.integral,a.totalmoney,a.supplyid,a.linkman,a.jifenchongdi,a.jifenchongdimoney,b.supplyname,c.gongshi from sellplanmain a LEFT JOIN customer b ON a.supplyid = b.ROWID
LEFT JOIN customerlever c ON b.state = c.ROWID where a.billid='$dingdanid'";
			$rs = $this->db->Execute($sql);
			$rs_a = $rs->GetArray();
			if($user_flag > 0){
				$ifDirthday=false;
				if($rs_a[0]['linkman']!='')
				{
					$birthday=$this->utility->returntablefield('linkman','rowid',$rs_a[0]['linkman'],'birthday');
					if($birthday!='' && substr($birthday,5)==date('m-d'))
						$ifDirthday=true;
				}
				if($birthdayDoubleIntegral==1 && $ifDirthday)//双倍积分
				{
					$integral = intval(($rs_a[0]['totalmoney']-$rs_a[0]['jifenchongdimoney'])/$exchange)*2;
				}
				else
					$integral = intval(($rs_a[0]['totalmoney']-$rs_a[0]['jifenchongdimoney'])/$exchange*$rs_a[0]['gongshi']);

				if($integral!=0)
				{
					$sql="update sellplanmain set integral=$integral where billid=$dingdanid";
					$this->db->Execute($sql);
					$sql="update customer set integral=IFNULL(`customer`.`integral`,0)+$integral where ROWID=".$rs_a[0][supplyid];
					$this->db->Execute($sql);	
				}	
				
			}else
			{
				$integral = $rs_a[0]['integral'];
				if($integral!=0)
				{
					$sql="update sellplanmain set integral=0 where billid=$dingdanid";
					$this->db->Execute($sql);
					$sql="update customer set integral=IFNULL(`customer`.`integral`,0)-$integral where ROWID=".$rs_a[0][supplyid];
					$this->db->Execute($sql);	
				}	
				
			}
		}
	}
	//更新采购单表的回款状态
	function updatebuyplanmainfukuan($caigoubillid)
	{
		$sellplaninfo=$this->utility->returntablefield("buyplanmain", "billid", $caigoubillid, "totalmoney,ifpay,paymoney,shoupiaomoney,oddment,state,shoupiaostate,user_flag");
		$paymoney=$sellplaninfo['paymoney'];
		$oddment=$sellplaninfo['oddment'];
		$totalmoney=$sellplaninfo['totalmoney'];
		$shoupiaomoney=$sellplaninfo['shoupiaomoney'];
		$fahuostate=$sellplaninfo['state'];
		if($totalmoney==$paymoney+$oddment)
			$ifpay=2;
		else
		{
			if($paymoney+$oddment!=0)
				$ifpay=1;
			else
				$ifpay=0;
		}
		if($totalmoney==$shoupiaomoney)
			$shoupiaostate=4;
		else
		{
			if($shoupiaomoney!=0)
				$shoupiaostate=3;
			else 
				$shoupiaostate=0;
		}
		$sql="update buyplanmain set ifpay=$ifpay,shoupiaostate=$shoupiaostate where billid=$caigoubillid";
		$this->db->Execute($sql);
		$this->updatebuyplanmainFlag($caigoubillid);
	
	}
	function updatebuyplanmainFlag($caigoubillid)
	{
		$sellplaninfo=$this->utility->returntablefield("buyplanmain", "billid", $caigoubillid, "ifpay,state,shoupiaostate,user_flag");
		$ifpay=$sellplaninfo['ifpay'];
		$fahuostate=$sellplaninfo['state'];
		$shoupiaostate=$sellplaninfo['shoupiaostate'];
		$user_flag=$sellplaninfo['user_flag'];
		if($user_flag!=-1)
		{
			
			
				if($fahuostate==5 && $ifpay==2)
					$user_flag=2;
				else if(($fahuostate==1 || $fahuostate==2) && $ifpay==0 && $shoupiaostate==0)
					$user_flag=0;
				else 
					$user_flag=1;
			
		}
		$sql="update buyplanmain set user_flag=$user_flag where billid=$caigoubillid";
		$this->db->Execute($sql);
	
	}
	//新增回款记录
	function insertShoukuanReocord($customerid,$billid,$shoukuan,$accountid,$createman,$opertype,$oddment,$qici="1",$guanlianplanid="",$jifenchongdi=0,$jifenchongdimoney=0)
	{
		$sql="select totalmoney-huikuanjine-oddment-jifenchongdimoney as needshou from sellplanmain where billid=".$billid;
		$rs=$this->db->Execute($sql);
		$rs_a=$rs->GetArray();
		if($rs_a[0]['needshou']==0 && $shoukuan!=0)
			throw new Exception($this->changeChar("销售单".$billid."已收款，不能重复收款"));
		if($rs_a[0]['needshou']>0 && $shoukuan>$rs_a[0]['needshou'])
			throw new Exception($this->changeChar("销售单".$billid."本次收款金额不能大于".$rs_a[0]['needshou']));		
			
		$id=$this->utility->returnAutoIncrement("id", "huikuanrecord");
		$sql="insert into huikuanrecord (id,customerid,dingdanbillid,paydate,jine,accountid,createman,createtime,oddment,qici,guanlianplanid,jifenchongdi,jifenchongdimoney)
		values(".$id.",".$customerid.",".$billid.",'".date("Y-m-d H:i:s")."',".$shoukuan.",".$accountid.",'".$createman."','".date("Y-m-d H:i:s")."',$oddment,'$qici','$guanlianplanid','$jifenchongdi','$jifenchongdimoney')";
		$this->db->Execute($sql);
		if($shoukuan!=0)
		{
			if($accountid==0)
			{
				//扣减预收款
				$yuchuzhi=$this->utility->returntablefield("customer","rowid",$customerid,"yuchuzhi");
				if($yuchuzhi<$shoukuan)
					throw new Exception($this->changeChar("预储值金额不足"));
				$sql="update customer set yuchuzhi=yuchuzhi-$shoukuan where rowid=$customerid";
				$this->db->Execute($sql);
				$sql="insert into accesspreshou (customerid,curchuzhi,jine,opertype,guanlianbillid,createman,createtime) values(
				".$customerid.",".$yuchuzhi.",".-$shoukuan.",'$opertype',".$billid.",'".$createman."','".date("Y-m-d H:i:s")."')";
				$this->db->Execute($sql);
			}
			else 
			{
				//账户金额增加
				$oldjine=$this->utility->returntablefield("bank", "rowid", $accountid, "jine");
				$sql="update bank set jine=jine+(".$shoukuan.") where rowid=".$accountid;
				$this->db->Execute($sql);
				$sql="insert into accessbank (bankid,oldjine,jine,opertype,guanlianbillid,createman,createtime) values(
				".$accountid.",".$oldjine.",".$shoukuan.",'$opertype',".$billid.",'".$createman."','".date("Y-m-d H:i:s")."')";
				$this->db->Execute($sql);
			}	
			$sql="update sellplanmain set huikuanjine=huikuanjine+($shoukuan),jifenchongdi=jifenchongdi+($jifenchongdi),jifenchongdimoney=jifenchongdimoney+($jifenchongdimoney) where billid=".$billid;
			$this->db->Execute($sql);
		}
		
		$zhuti=$this->utility->returntablefield("sellplanmain", "billid", $billid, "zhuti");
		$supplyname=$this->utility->returntablefield("customer", "rowid", $customerid, "supplyname");
		if($oddment!=0)
		{
			$sql="update sellplanmain set oddment=oddment+($oddment) where billid=".$billid;
			$this->db->Execute($sql);
			$this->insertFeiYong(8,$oddment,$accountid,$_SESSION['LOGIN_USER_ID'],-1,$billid,"sellplanmain",$zhuti."(".$supplyname.")");
		}
		if($jifenchongdi!=0 && $jifenchongdimoney!=0)
		{
			$sql="update customer set integral=IFNULL(`customer`.`integral`,0)-($jifenchongdi) where ROWID=".$customerid;
			$this->db->Execute($sql);
			$sql="select `integral` from customer where ROWID=".$customerid;
			$remainjifen=$this->db->GetOne($sql);
			if($remainjifen<0)
				throw new Exception($this->changeChar("积分不足"));
			$sql="insert into exchange (customid,integral,exchangenum,createman,createtime,guanlianbillid,remainjifen) values($customerid,$jifenchongdi,$jifenchongdimoney,'".$_SESSION['LOGIN_USER_ID']."','".date('Y-m-d H:i:s')."',$billid,$remainjifen)";
			$this->db->Execute($sql);
			$this->insertFeiYong(32,$jifenchongdimoney,$accountid,$_SESSION['LOGIN_USER_ID'],-1,$billid,"sellplanmain",$zhuti."(".$supplyname.")");
		}
		
		$this->updatesellplanmainhuikuan($billid);
	}
	//新增付款记录
	function insertFukuanReocord($supplyid,$billid,$fukuan,$accountid,$createman,$opertype,$oddment,$qici,$beizhu,$guanlianplanid="")
	{
		$sql="Select totalmoney-oddment-paymoney as needpay from buyplanmain where billid=".$billid;
		$rs=$this->db->Execute($sql);
		$rs_a=$rs->GetArray();
		if($rs_a[0]['needpay']<$fukuan)
			throw new Exception("采购单".$billid."的本次付款金额不能超过".$rs_a[0]['needpay']);
		$id=$this->utility->returnAutoIncrement("id", "fukuanrecord");
		$sql="insert into fukuanrecord (id,supplyid,caigoubillid,paydate,jine,accountid,createman,createtime,oddment,qici,beizhu,guanlianplanid)
		values(".$id.",".$supplyid.",".$billid.",'".date("Y-m-d H:i:s")."',".$fukuan.",".$accountid.",'".$createman."','".date("Y-m-d H:i:s")."',$oddment,'$qici','$beizhu','$guanlianplanid')";
		$this->db->Execute($sql);
		
		//账户金额减少
		
		if($accountid==0)
		{
			//扣减预付款
			
			$yufukuan=$this->utility->returntablefield("supply","rowid",$supplyid,"yufukuan");
			if($yufukuan<$fukuan)
				throw new Exception("预付款金额不足");
			$sql="update supply set yufukuan=yufukuan-$fukuan where rowid=$supplyid";
			$this->db->Execute($sql);
			$sql="insert into accessprepay (supplyid,curchuzhi,jine,opertype,guanlianbillid,createman,createtime) values(
			".$supplyid.",".$yufukuan.",".-$fukuan.",'$opertype',".$billid.",'".$createman."','".date("Y-m-d H:i:s")."')";
			$this->db->Execute($sql);
		}
		else 
		{
			//从账户中支付
			$accountinfo=$this->utility->returntablefield("bank", "rowid", $accountid, "jine,syslock");
			$oldjine=$accountinfo['jine'];
			$sql="update bank set jine=jine-(".$fukuan.") where rowid=".$accountid;
			$this->db->Execute($sql);
			$sql="insert into accessbank (bankid,oldjine,jine,opertype,guanlianbillid,createman,createtime) values(
			".$accountid.",".$oldjine.",".-$fukuan.",'$opertype',".$billid.",'".$createman."','".date("Y-m-d H:i:s")."')";
			$this->db->Execute($sql);
		}
		
		$sql="update buyplanmain set paymoney=paymoney+($fukuan) where billid=".$billid;
		$this->db->Execute($sql);
		if($oddment!=0)
		{
			$zhuti=$this->utility->returntablefield("buyplanmain", "billid", $billid, "zhuti");
			$supplyname=$this->utility->returntablefield("supply", "rowid", $supplyid, "supplyname");
			$this->insertFeiYong(1,$oddment,$accountid,$_SESSION['LOGIN_USER_ID'],1,$billid,"buyplanmain",$zhuti."(".$supplyname.")");
		}
		$this->updatebuyplanmainfukuan($billid);
	}
	
	function deleteShoukuanReocord($id)
	{
		$shoukuaninfo=$this->utility->returntablefield("huikuanrecord", "id", $id, "customerid,dingdanbillid,accountid,jine,oddment,jifenchongdi,jifenchongdimoney");
		$dingdanbillid=$shoukuaninfo['dingdanbillid'];
		$accountid=$shoukuaninfo['accountid'];
		$shoukuan=$shoukuaninfo['jine'];
		$oddment=$shoukuaninfo['oddment'];
		$customerid=$shoukuaninfo['customerid'];
		$jifenchongdi=$shoukuaninfo['jifenchongdi'];
		$jifenchongdimoney=$shoukuaninfo['jifenchongdimoney'];
		$sql="delete from huikuanrecord  where id=$id";
		$this->db->Execute($sql);
		if($shoukuan!=0)
		{
			if($accountid=='0')
			{
				//返还预收款
				$yuchuzhi=$this->utility->returntablefield("customer","rowid",$customerid,"yuchuzhi");
				if($yuchuzhi+$shoukuan<0)
					throw new Exception("预储值金额不足");
				$sql="update customer set yuchuzhi=yuchuzhi+$shoukuan where rowid=$customerid";
				$this->db->Execute($sql);
				$sql="insert into accesspreshou (customerid,curchuzhi,jine,opertype,guanlianbillid,createman,createtime) values(
				".$customerid.",".$yuchuzhi.",".$shoukuan.",'货款收取',".$dingdanbillid.",'".$_SESSION['LOGIN_USER_ID']."','".date("Y-m-d H:i:s")."')";
				$this->db->Execute($sql);
			}
			else 
			{
				//账户金额增加
				$oldjine=$this->utility->returntablefield("bank", "rowid", $accountid, "jine");
				$sql="update bank set jine=jine-(".$shoukuan.") where rowid=".$accountid;
				$this->db->Execute($sql);
				
				$sql="insert into accessbank (bankid,oldjine,jine,opertype,guanlianbillid,createman,createtime) values(
				".$accountid.",".$oldjine.",".-$shoukuan.",'货款收取',".$dingdanbillid.",'".$_SESSION['LOGIN_USER_ID']."','".date("Y-m-d H:i:s")."')";
				$this->db->Execute($sql);
			}
			$sql="update sellplanmain set huikuanjine=huikuanjine-($shoukuan),jifenchongdi=jifenchongdi-($jifenchongdi),jifenchongdimoney=jifenchongdimoney-($jifenchongdimoney) where billid=".$dingdanbillid;
			$this->db->Execute($sql);
		}
		$zhuti=$this->utility->returntablefield("sellplanmain", "billid", $dingdanbillid, "zhuti");
		$supplyname=$this->utility->returntablefield("customer", "rowid", $customerid, "supplyname");
		if($oddment!=0)
		{
			$sql="update sellplanmain set oddment=oddment-($oddment) where billid=".$dingdanbillid;
			$this->db->Execute($sql);
			$this->insertFeiYong(8,-$oddment,$accountid,$_SESSION['LOGIN_USER_ID'],-1,$dingdanbillid,"sellplanmain",$zhuti."(".$supplyname.")");
		}
		if($jifenchongdi!=0 && $jifenchongdimoney!=0)
		{
			$sql="update customer set integral=IFNULL(`customer`.`integral`,0)+($jifenchongdi) where ROWID=".$customerid;
			$this->db->Execute($sql);	
			$sql="select `integral` from customer where ROWID=".$customerid;
			$remainjifen=$this->db->GetOne($sql);
			$sql="insert into exchange (customid,integral,exchangenum,createman,createtime,guanlianbillid,remainjifen) values($customerid,-$jifenchongdi,-$jifenchongdimoney,'".$_SESSION['LOGIN_USER_ID']."','".date('Y-m-d H:i:s')."',$dingdanbillid,$remainjifen)";
			$this->db->Execute($sql);
			$this->insertFeiYong(32,-$jifenchongdimoney,$accountid,$_SESSION['LOGIN_USER_ID'],-1,$dingdanbillid,"sellplanmain",$zhuti."(".$supplyname.")");
		}
		$this->updatesellplanmainhuikuan($dingdanbillid);
	}
	//删除付款记录
	function deleteFukuanReocord($id)
	{
		$fukuaninfo=$this->utility->returntablefield("fukuanrecord", "id", $id, "id,supplyid,caigoubillid,jine,oddment,accountid,guanlianplanid");	
		$caigoubillid=$fukuaninfo['caigoubillid'];
		$fukuan=$fukuaninfo['jine'];
		$oddment=$fukuaninfo['oddment'];
		$accountid=$fukuaninfo['accountid'];
		$supplyid=$fukuaninfo['supplyid'];
		
		$sql="delete from fukuanrecord  where id=$id";
		$this->db->Execute($sql);
		
		//账户金额增加
		
		if($accountid=='0')
		{
			//返还预付款
			
			$yufukuan=$this->utility->returntablefield("supply","rowid",$supplyid,"yufukuan");
			if($yufukuan+$fukuan<0)
				throw new Exception("预付款金额不足");
			$sql="update supply set yufukuan=yufukuan+$fukuan where supplyid=$supplyid";
			$this->db->Execute($sql);
			$sql="insert into accessprepay (supplyid,curchuzhi,jine,opertype,guanlianbillid,createman,createtime) values(
			".$supplyid.",".$yufukuan.",".$fukuan.",'货款支付',".$caigoubillid.",'".$_SESSION['LOGIN_USER_ID']."','".date("Y-m-d H:i:s")."')";
			$this->db->Execute($sql);
		}
		else 
		{
			$accountinfo=$this->utility->returntablefield("bank", "rowid", $accountid, "jine,syslock");
			$oldjine=$accountinfo['jine'];
			$sql="update bank set jine=jine+(".$fukuan.") where rowid=".$accountid;
			$this->db->Execute($sql);
			
			$sql="insert into accessbank (bankid,oldjine,jine,opertype,guanlianbillid,createman,createtime) values(
			".$accountid.",".$oldjine.",".$fukuan.",'货款支付',".$caigoubillid.",'".$_SESSION['LOGIN_USER_ID']."','".date("Y-m-d H:i:s")."')";
			$this->db->Execute($sql);
		}
		$sql="update buyplanmain set paymoney=paymoney-($fukuan) where billid=".$caigoubillid;
		$this->db->Execute($sql);
		
		if($oddment!=0)
		{
			$zhuti=$this->utility->returntablefield("buyplanmain", "billid", $caigoubillid, "zhuti");
			$supplyname=$this->utility->returntablefield("supply", "rowid", $supplyid, "supplyname");
			$this->insertFeiYong(1,-$oddment,$accountid,$_SESSION['LOGIN_USER_ID'],1,$caigoubillid,"buyplanmain",$zhuti."(".$supplyname.")");
		}
		$this->updatebuyplanmainfukuan($caigoubillid);
	}
	//新增费用
	function insertFeiYongAccount($feiyongtype,$jine,$accountid,$createman,$kind,$chanshengdate="",$beizhu="",$pingzheng="",$jingshouren="")
	{
		if($chanshengdate=="")
			$chanshengdate=date("Y-m-d");
		$feiyongbillid = $this->utility->returnAutoIncrement("billid","feiyongrecord");
		
		$sql="insert into feiyongrecord (billid,typeid,jine,accountid,chanshengdate,createman,createtime,kind,beizhu,pingzheng,jingshouren) values($feiyongbillid,$feiyongtype,$jine,$accountid,'".$chanshengdate."','".$createman."','".date("Y-m-d H:i:s")."',$kind,'$beizhu','$pingzheng','$jingshouren')";
		$this->db->Execute($sql);
		$oldjine=$this->utility->returntablefield("bank","rowid",$accountid,"jine");
	    $sql="update bank set jine=jine+(".$jine*$kind.") where rowid=$accountid";
	    $this->db->Execute($sql);
	    if($kind==1)
	    	$feiyongname='其他收入';
	    else 
	    	$feiyongname='费用支出';
	    $sql="insert into accessbank (bankid,oldjine,jine,opertype,guanlianbillid,createman,createtime) values ($accountid,$oldjine,".$jine*$kind.
	    ",'$feiyongname',$feiyongbillid,'".$_SESSION['LOGIN_USER_ID']."','".date("Y-m-d H:i:s")."')";
	    $this->db->Execute($sql);
	}
	//新增抹零费用
	function insertFeiYong($feiyongtype,$jine,$accountid,$createman,$kind,$billid,$table,$beizhu='')
	{
		
		$sql="insert into feiyongrecord (typeid,jine,accountid,chanshengdate,createman,createtime,kind,beizhu) values($feiyongtype,$jine,$accountid,'".date("Y-m-d")."','".$createman."','".date("Y-m-d H:i:s")."',$kind,'".$beizhu."')";
		$this->db->Execute($sql);
		
	}
	
	//删除费用单
	function deleteFeiYongAccount($selectid)
	{
		$feiyonginfo=$this->utility->returntablefield("feiyongrecord","billid",$selectid,"accountid,jine,typeid,kind");
		$accountid=$feiyonginfo['accountid'];
		$jine=$feiyonginfo['jine'];
		$kind=$feiyonginfo['kind'];
	    $sql="delete from feiyongrecord where billid=".$selectid;
	    $this->db->Execute($sql);
	    $oldjine=$this->utility->returntablefield("bank","rowid",$accountid,"jine");
	    $sql="update bank set jine=jine-(".$jine.") where rowid=".$accountid;
	    $this->db->Execute($sql);
	    if($kind==1)
	    	$feiyongname='其他收入';
	    else 
	    	$feiyongname='费用支出';
	    $sql="insert accessbank (bankid,oldjine,jine,opertype,guanlianbillid,createman,createtime) values (".$accountid.",$oldjine,".-$jine.
	    ",'$feiyongname',$selectid,'".$_SESSION['LOGIN_USER_ID']."','".date("Y-m-d H:i:s")."')";
	    $this->db->Execute($sql);
	}
	//新增开票记录
	function insertKaiPiao($customerid,$billid,$fapiaoneirong,$fapiaotype,$fapiaono,$jine,$createman,$kaipiaodate='')
	{
		if($kaipiaodate=='')
			$kaipiaodate=date("Y-m-d");
		$id=$this->utility->returnAutoIncrement("id", "kaipiaorecord");
		$sql="insert into kaipiaorecord (id,customerid,dingdanbillid,kaipiaoneirong,piaojutype,fapiaono,piaojujine,kaipiaodate,kaipiaoren,createtime)
		values (".$id.",".$customerid.",".$billid.",'".$fapiaoneirong."',".$fapiaotype.",'".$fapiaono."',".$jine.",'".$kaipiaodate."','".$createman."','".date("Y-m-d H:i:s")."')";
		$this->db->Execute($sql);
		$sql="update sellplanmain set kaipiaojine=kaipiaojine+($jine) where billid=".$billid;
		$this->db->Execute($sql);
		$this->updatesellplanmainhuikuan($billid);
	}
	//新增收票记录
	function insertShouPiao($supplyid,$billid,$fapiaoneirong,$fapiaotype,$fapiaono,$jine,$createman,$qici,$beizhu,$kaipiaodate='')
	{
		if($kaipiaodate=='')
			$kaipiaodate=date("Y-m-d");
		$id=$this->utility->returnAutoIncrement("id", "shoupiaorecord");
		$sql="insert into shoupiaorecord (id,supplyid,caigoubillid,kaipiaoneirong,piaojutype,fapiaono,piaojujine,kaipiaodate,kaipiaoren,createtime,qici,beizhu)
		values (".$id.",".$supplyid.",".$billid.",'".$fapiaoneirong."',".$fapiaotype.",'".$fapiaono."',".$jine.",'".$kaipiaodate."','".$createman."','".date("Y-m-d H:i:s")."','$qici','$beizhu')";
		$this->db->Execute($sql);
		$sql="update buyplanmain set shoupiaomoney=shoupiaomoney+($jine) where billid=".$billid;
		$this->db->Execute($sql);
		$this->updatebuyplanmainfukuan($billid);
	}
	//删除开票记录
	function deleteKaiPiao($id)
	{
		$dingdanbillid=$this->utility->returntablefield("kaipiaorecord", "id",$id,"dingdanbillid");
		$sql="delete from kaipiaorecord where id=$id";
		$this->db->Execute($sql);
		$sql="select sum(piaojujine) as allmoney from kaipiaorecord where dingdanbillid=$dingdanbillid";
		$rs=$this->db->Execute($sql);
		$allmoney=floatvalue($rs->fields[0]['allmoney']);
		$sql="update sellplanmain set kaipiaojine=$allmoney where billid=".$dingdanbillid;
		$this->db->Execute($sql);
		$this->updatesellplanmainhuikuan($dingdanbillid);
	}
	//删除收票记录
	function deleteShouPiao($id)
	{
		$caigoubillid=$this->utility->returntablefield("shoupiaorecord", "id",$id,"caigoubillid");
		$sql="delete from shoupiaorecord where id=$id";
		$this->db->Execute($sql);
		$sql="select sum(piaojujine) as allmoney from shoupiaorecord where caigoubillid=$caigoubillid";
		$rs=$this->db->Execute($sql);
		$allmoney=floatvalue($rs->fields[0]['allmoney']);
		$sql="update buyplanmain set shoupiaomoney=$allmoney where billid=".$caigoubillid;
		$this->db->Execute($sql);
		$this->updatebuyplanmainfukuan($caigoubillid);
	}
	
	//新增预付款记录
	function insertYuFukuanReocord($supplyid,$linkmanid,$jine,$accountid,$createman,$opertype,$beizhu)
	{
		$id = $this->utility->returnAutoIncrement("id","accessprepay");
		$curchuzhi=floatvalue($this->utility->returntablefield("supply", "rowid", $supplyid, "yufukuan"));
		if($linkmanid=='')
			$linkmanid='null';
		$sql="insert into accessprepay (id,supplyid,linkmanid,curchuzhi,jine,accountid,createman,createtime,opertype,beizhu)
		values(".$id.",".$supplyid.",".$linkmanid.",".$curchuzhi.",".$jine.",".$accountid.",'".$createman."','".date("Y-m-d H:i:s")."','$opertype','$beizhu')";
		$this->db->Execute($sql);
		//账户金额减少
		$oldjine=$this->utility->returntablefield("bank", "rowid", $accountid, "jine");
		$sql="update bank set jine=jine-(".$jine.") where rowid=".$accountid;
		$this->db->Execute($sql);
		$sql="insert into accessbank (bankid,oldjine,jine,opertype,guanlianbillid,createman,createtime) values(
		".$accountid.",".$oldjine.",".-$jine.",'$opertype',".$id.",'".$createman."','".date("Y-m-d H:i:s")."')";
		$this->db->Execute($sql);
		$sql="update supply set yufukuan=yufukuan+($jine) where rowid=".$supplyid;
		$this->db->Execute($sql);
	}
	//删除预付款记录
	function deleteYuFukuanReocord($id)
	{
		$fukuaninfo=$this->utility->returntablefield("accessprepay", "id", $id, "supplyid,accountid,jine,opertype");	
		$supplyid=$fukuaninfo['supplyid'];
		$accountid=$fukuaninfo['accountid'];
		$jine=$fukuaninfo['jine'];
		$opertype=$fukuaninfo['opertype'];
		
		$sql="delete from accessprepay where id=$id";
		$this->db->Execute($sql);
		
		//账户金额增加
		$oldjine=$this->utility->returntablefield("bank", "rowid", $accountid, "jine");
		if($accountid!='')
		{
			$sql="update bank set jine=jine+(".$jine.") where rowid=".$accountid;
			$this->db->Execute($sql);
			
			$sql="insert into accessbank (bankid,oldjine,jine,opertype,guanlianbillid,createman,createtime) values(
			".$accountid.",".$oldjine.",".$jine.",'$opertype',".$id.",'".$_SESSION['LOGIN_USER_ID']."','".date("Y-m-d H:i:s")."')";
			$this->db->Execute($sql);
		}
		$sql="update supply set yufukuan=yufukuan-($jine) where rowid=".$supplyid;
		$this->db->Execute($sql);
		
	}
	//新增预收款记录
	function insertYuShoukuanReocord($customerid,$linkmanid,$jine,$accountid,$createman,$opertype,$beizhu,$realjine)
	{
		
		$id=$this->utility->returnAutoIncrement("id", "accesspreshou");
		$curchuzhi=floatvalue($this->utility->returntablefield("customer", "ROWID", $customerid, "yuchuzhi"));
		$sql="insert into accesspreshou (id,customerid,linkman,curchuzhi,jine,accountid,createman,createtime,opertype,beizhu,realjine)
		values(".$id.",".$customerid.",'".$linkmanid."',".$curchuzhi.",".$jine.",".$accountid.",'".$createman."','".date("Y-m-d H:i:s")."','$opertype','$beizhu','$realjine')";
		
		$this->db->Execute($sql);
	

		//账户金额增加
		$oldjine=$this->utility->returntablefield("bank", "rowid", $accountid, "jine");
		$sql="update bank set jine=jine+(".$realjine.") where rowid=".$accountid;
		$this->db->Execute($sql);
		$sql="insert into accessbank (bankid,oldjine,jine,opertype,guanlianbillid,createman,createtime) values(
		".$accountid.",".$oldjine.",".$realjine.",'$opertype',".$id.",'".$createman."','".date("Y-m-d H:i:s")."')";
		$this->db->Execute($sql);
		$sql="update customer set yuchuzhi=yuchuzhi+($jine) where rowid=".$customerid;
		$this->db->Execute($sql);
		if(floatval($realjine)!=floatval($jine))
		{
			$zengsongjine=$jine-$realjine;
			$feiyongid=$this->utility->returntablefield("feiyongtype","typename","预储值赠送","id");
			$this->insertFeiYong($feiyongid,$zengsongjine,$accountid,$_SESSION['LOGIN_USER_ID'],-1,0,"","预收款单-".$id);
		}
	}
//删除预收款记录
	function deleteYuShoukuanReocord($id)
	{
		$fukuaninfo=$this->utility->returntablefield("accesspreshou", "id", $id, "customerid,accountid,jine,opertype,realjine");	
		$customerid=$fukuaninfo['customerid'];
		$accountid=$fukuaninfo['accountid'];
		$jine=$fukuaninfo['jine'];
		$opertype=$fukuaninfo['opertype'];
		$realjine=$fukuaninfo['realjine'];

		$sql="delete from accesspreshou where id=$id";
		$this->db->Execute($sql);
		
		//账户金额减少
		$oldjine=$this->utility->returntablefield("bank", "rowid", $accountid, "jine");
		$sql="update bank set jine=jine-(".$realjine.") where rowid=".$accountid;
		$this->db->Execute($sql);
		
		$sql="insert into accessbank (bankid,oldjine,jine,opertype,guanlianbillid,createman,createtime) values(
		".$accountid.",".$oldjine.",".-$realjine.",'$opertype',".$id.",'".$_SESSION['LOGIN_USER_ID']."','".date("Y-m-d H:i:s")."')";
		$this->db->Execute($sql);
		
		$sql="update customer set yuchuzhi=yuchuzhi-($jine) where rowid=".$customerid;
		$this->db->Execute($sql);

		if(floatval($realjine)!=floatval($jine))
		{
			$zengsongjine=$jine-$realjine;
			$feiyongid=$this->utility->returntablefield("feiyongtype","typename","预储值赠送","id");
			$this->insertFeiYong($feiyongid,-$zengsongjine,$accountid,$_SESSION['LOGIN_USER_ID'],-1,0,"","预收款单-".$id);
		}
		
	}
//新增资金注入单
	function insertBankZhuruAccount($jine,$accountid,$memo,$inouttype)
	{
		
		$billid = $this->utility->returnAutoIncrement("billid","bankzhuru");
		if($inouttype==23)
			$jine=-$jine;
		$sql="insert into bankzhuru (billid,jine,accountid,memo,userid,opertime,inouttype) values($billid,$jine,$accountid,'$memo','".$_SESSION['LOGIN_USER_ID']."','".date("Y-m-d H:i:s")."','$inouttype')";
		$this->db->Execute($sql);
		$oldjine=$this->utility->returntablefield("bank","rowid",$accountid,"jine");
	    $sql="update bank set jine=jine+(".$jine.") where rowid=$accountid";
	    $this->db->Execute($sql);
	    $accesstype=$this->utility->returntablefield("accesstype","id",$inouttype,"name");
	    $sql="insert into accessbank (bankid,oldjine,jine,opertype,guanlianbillid,createman,createtime) values ($accountid,$oldjine,".$jine.
	    ",'$accesstype','$billid,','".$_SESSION['LOGIN_USER_ID']."','".date("Y-m-d H:i:s")."')";
	    $this->db->Execute($sql);
	}
//删除资金注入单
	function deleteBankZhuruAccount($billid)
	{
		$sql="select * from bankzhuru where billid=$billid";
		$rs=$this->db->Execute($sql);
		$rs_a=$rs->GetArray();
		$accountid=$rs_a[0]['accountid'];
		$jine=$rs_a[0]['jine'];
		$inouttype=$rs_a[0]['inouttype'];
		
		$sql="delete from  bankzhuru where billid=$billid";
		$this->db->Execute($sql);
		$oldjine=$this->utility->returntablefield("bank","rowid",$accountid,"jine");
	    $sql="update bank set jine=jine-(".$jine.") where rowid=$accountid";
	    $this->db->Execute($sql);
	    $accesstype=$this->utility->returntablefield("accesstype","id",$inouttype,"name");
	    $sql="insert into accessbank (bankid,oldjine,jine,opertype,guanlianbillid,createman,createtime) values ($accountid,$oldjine,".-$jine.
	    ",'$accesstype','$billid,','".$_SESSION['LOGIN_USER_ID']."','".date("Y-m-d H:i:s")."')";
	    $this->db->Execute($sql);
	}
	//扣减账户
	function operateAccount($accountid,$totalmoney,$accesstype,$billid)
	{
		$yue=$this->utility->returntablefield("bank", "ROWID", $accountid, "jine");
		if($yue<$totalmoney)
		    	throw new Exception("账户余额不足以支付 $totalmoney");
		$sql="update bank set jine=jine-$totalmoney where rowid=$accountid";
		$this->db->Execute($sql);
		$sql="insert into accessbank (bankid,oldjine,jine,opertype,guanlianbillid,createman,createtime) values ($accountid,$yue,".-$totalmoney.
	    ",'$accesstype','$billid,','".$_SESSION['LOGIN_USER_ID']."','".date("Y-m-d H:i:s")."')";
	    $this->db->Execute($sql);
		
	}
	//扣减预付款
	function operatePrepay($supplyid,$totalmoney,$opertype,$billid)
	{
		$yue=$this->utility->returntablefield("supply", "ROWID", $supplyid, "yufukuan");
		if($yue<$totalmoney)
		    	throw new Exception("预付款余额不足以支付 $totalmoney");
		$sql="update supply set yufukuan=yufukuan-$totalmoney where rowid=$supplyid";
		$this->db->Execute($sql);
		
		$sql="insert into accessprepay (supplyid,curchuzhi,jine,opertype,guanlianbillid,createman,createtime) values(
		".$supplyid.",".$yue.",".-$totalmoney.",'$opertype',".$billid.",'".$_SESSION['LOGIN_USER_ID']."','".date("Y-m-d H:i:s")."')";
		$this->db->Execute($sql);
		
	}
	//通过订单号删除回款记录
	function deleteShoukuanReocordByBillid($billid)
	{
		$sql="select id from huikuanrecord where dingdanbillid=$billid";
		$rs=$this->db->Execute($sql);
		$rs_a=$rs->GetArray();
		for($i=0;$i<sizeof($rs_a);$i++)
		{
			$this->deleteShoukuanReocord($rs_a[$i]['id']);
		}
	}
	//通过采购单号删除付款记录
	function deleteFukuanReocordByBillid($billid)
	{
		$sql="select id from fukuanrecord where caigoubillid=$billid";
		$rs=$this->db->Execute($sql);
		$rs_a=$rs->GetArray();
		for($i=0;$i<sizeof($rs_a);$i++)
		{
			$this->deleteFukuanReocord($rs_a[$i]['id']);
		}
	}
	//通过订单号删除开票记录
	function deletekaipiaoByBillid($billid)
	{
		$sql="select id from kaipiaorecord where dingdanbillid=$billid";
		$rs=$this->db->Execute($sql);
		$rs_a=$rs->GetArray();
		for($i=0;$i<sizeof($rs_a);$i++)
		{
			$this->deleteKaiPiao($rs_a[$i]['id']);
		}
	}
	//通过采购单号删除收票记录
	function deleteshoupiaoByBillid($billid)
	{
		$sql="select id from shoupiaorecord where caigoubillid=$billid";
		$rs=$this->db->Execute($sql);
		$rs_a=$rs->GetArray();
		for($i=0;$i<sizeof($rs_a);$i++)
		{
			$this->deleteShouPiao($rs_a[$i]['id']);
		}
	}
	//财务审核订单
	function dingdanshenhe($billid)
	{
		$sql="update sellplanmain set user_flag=1 where billid=$billid and user_flag=-2";
		$rs=$this->db->Execute($sql);
		if($rs)
			$this->updatesellplanmainJifen($billid,"1");
	}
	function exchangeJifen($_POST)
	{
		$sql = "select max(rowid) as max from exchange";
		$rs = $this->db->Execute($sql);
		$rs_a = $rs->GetArray();
		$id = $rs_a[0]['max']+1;
		$sql = "insert into exchange(rowid,customid,integral,createtime,createman,exchangenum,beizhu) value($id,'".$_POST[customid]."','".$_POST[integral]."','".date("Y-m-d H:i:s")."','".$_SESSION[LOGIN_USER_ID]."','".intval($_POST[exchangenum])."','".$_POST[beizhu]."')";
		$this->db->Execute($sql);
		
		$custinfo=$this->utility->returntablefield('customer','rowid',$_POST[customid],'supplyname,yuchuzhi');
		$supplyname=$custinfo['supplyname'];
		$curchuzhi=$custinfo['yuchuzhi'];
		// 更新积分
		$sql = "update customer set integral=integral-".intval($_POST[integral]).",yuchuzhi=yuchuzhi+".intval($_POST[exchangenum])." where ROWID=".$_POST[customid];
		$this->db->Execute($sql);
		$sql="insert into accesspreshou (customerid,curchuzhi,jine,opertype,guanlianbillid,createman,createtime) values(
				".$_POST[customid].",".$curchuzhi.",".intval($_POST[exchangenum]).",'积分兑换',".$id.",'".$_SESSION['LOGIN_USER_ID']."','".date("Y-m-d H:i:s")."')";
		$this->db->Execute($sql);
		
		//$this->insertFeiYongAccount(32,intval($_POST[exchangenum]),1,$_SESSION['LOGIN_USER_ID'],-1,'','积分兑换：'.$id."(".$supplyname.")");
		$this->insertFeiYong(32,intval($_POST[exchangenum]),1,$_SESSION['LOGIN_USER_ID'],-1,$id,"exchange",$beizhu='');
	}	
	function cancelExchangeJifen($id)
	{
		$sql = "select * from exchange a where a.ROWID=".intval($id);
		$rs = $this->db->Execute($sql);
		$exchang_row = $rs->GetArray();
		if(!empty($exchang_row)){
			// 删除兑换记录
			$sql = "DELETE a FROM exchange AS  a WHERE a.ROWID=".$exchang_row[0]['ROWID'];
			$this->db->Execute($sql);
			$custinfo=$this->utility->returntablefield('customer','rowid',$exchang_row[0][customid],'supplyname,yuchuzhi');
			$supplyname=$custinfo['supplyname'];
			$curchuzhi=$custinfo['yuchuzhi'];
			// 更新积分
			$sql = "update customer set integral=integral+".intval($exchang_row[0][integral]).",yuchuzhi=yuchuzhi-".intval($exchang_row[0][exchangenum])." where ROWID=".$exchang_row[0][customid];
			$this->db->Execute($sql);
			$sql="insert into accesspreshou (customerid,curchuzhi,jine,opertype,guanlianbillid,createman,createtime) values(
				".$exchang_row[0][customid].",".$curchuzhi.",".-intval($exchang_row[0][exchangenum]).",'积分兑换',".$exchang_row[0]['ROWID'].",'".$_SESSION['LOGIN_USER_ID']."','".date("Y-m-d H:i:s")."')";
			$this->db->Execute($sql);
			
			$this->insertFeiYongAccount(32,-intval($exchang_row[0][exchangenum]),1,$_SESSION['LOGIN_USER_ID'],-1,'','撤销积分兑换：'.$exchang_row[0]['ROWID']."(".$supplyname.")");
			
		}
		
		
		
	}	
}
?>