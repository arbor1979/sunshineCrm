<?php
require_once('CaiWu.php');
require_once('Utility.php');
class Store
{
	var $db;
	var $char;
	var $utility;
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
	//新增发货单
	function insertFaHuo($chukubillid)
	{
		$stockinfo=$this->utility->returntablefield("stockoutmain", "billid", $chukubillid, "dingdanbillid,totalnum,totalmoney,outtype");
		$dingdanid=$stockinfo['dingdanbillid'];
		$totalnum=$stockinfo['totalnum'];
		$totalmoney=$stockinfo['totalmoney'];
		$outtype=$stockinfo['outtype'];
		if($outtype==$this->changeChar("销售出库"))
		{
			$sellinfo=$this->utility->returntablefield("sellplanmain", "billid", $dingdanid, "supplyid,linkman,address,mobile,fahuodan,fahuotype,fahuoyunfei,yunfeitype");
			$customerid=$sellinfo['supplyid'];
			$linkman=$sellinfo['linkman'];
			$address=$sellinfo['address'];
			$mobile=$sellinfo['mobile'];
			$fahuodan=$sellinfo['fahuodan'];
			$fahuotype=$sellinfo['fahuotype'];
			$fahuoyunfei=floatval($sellinfo['fahuoyunfei']);
			$yunfeitype=$sellinfo['yunfeitype'];
			$shouhuoren=$this->utility->returntablefield("linkman","ROWID" , $linkman, "linkmanname");
		}
		else if($outtype==$this->changeChar("返厂出库"))
		{
			$buyinfo=$this->utility->returntablefield("buyplanmain", "billid", $dingdanid, "supplyid,linkman");
			$supplyinfo=$this->utility->returntablefield("supply", "rowid", $buyinfo['supplyid'], "chargesection,phone");
			$linkmaninfo=$this->utility->returntablefield("supplylinkman", "ROWID", $buyinfo['linkman'], "supplyname,phone");
			$customerid=$buyinfo['supplyid'];
			$shouhuoren=$linkmaninfo['supplyname'];
			$address=$supplyinfo['chargesection'];
			$mobile=$supplyinfo['phone']." ".$linkmaninfo['phone'];
			
		}
		$sql = "select * from fahuodan where billid=".$chukubillid;
		$rs = $this->db->Execute($sql);
		$rs_a = $rs->GetArray();
		if(count($rs_a)!=0)
			throw  new Exception($this->changeChar("对应的发货单已存在"));
		$sql="insert into fahuodan (billid,customerid,dingdanbillid,shouhuoren,tel,address,state,totalnum,totalmoney,outtype) values("
		.$chukubillid.",".$customerid.",".$dingdanid.",'".$shouhuoren."','".$mobile."','".$address."','".$this->changeChar('未发货')."',$totalnum,$totalmoney,'$outtype')";
		$this->db->Execute($sql);
		$sql = "select * from stockoutmain_detail where mainrowid=".$chukubillid;
		$rs = $this->db->Execute($sql);
		$rs_detail = $rs->GetArray();

		for($i=0;$i<sizeof($rs_detail);$i++)
		{
			$sql = "select max(id) as maxid from fahuodan_detail";
			$rs = $this->db->Execute($sql);
			$rs_a = $rs->GetArray();
			$maxid=$rs_a[0]['maxid']+1;
			$sql="insert into fahuodan_detail (id,prodid,prodname,prodguige,prodxinghao,proddanwei,price,zhekou,num,beizhu,mainrowid,jine) values('"
			.$maxid."','".$rs_detail[$i]['prodid']."','".$rs_detail[$i]['prodname']."','".$rs_detail[$i]['prodguige']."','".$rs_detail[$i]['prodxinghao']."','"
			.$rs_detail[$i]['proddanwei']."',".$rs_detail[$i]['price'].",".$rs_detail[$i]['zhekou'].",".$rs_detail[$i]['num'].",'".$rs_detail[$i]['beizhu']."',".$chukubillid.",".$rs_detail[$i]['jine'].")";
			$this->db->Execute($sql);
		}
		if($outtype==$this->changeChar("销售出库"))
			$this->updatesellplanmainfahuo($dingdanid);

	}
	//确认发货单
	function confirmFaHuo($billid,$fahuodan,$shouhuoren,$address,$tel,$mailcode,$fahuotype,$package,$weight,$yunfei,$jiesuantype,$beizhu)
	{
		//更新发货单
		$sql="update fahuodan set fahuodan='".$fahuodan."',shouhuoren='".$shouhuoren."',address='".$address."',tel='".$tel."',mailcode='".$mailcode.
		"',fahuotype='".$fahuotype."',package=".$package.",weight=".$weight.",yunfei=".$yunfei.",jiesuantype=".$jiesuantype.",beizhu='".$beizhu.
		"',fahuoren='".$_SESSION['LOGIN_USER_ID']."',fahuodate='".date("Y-m-d H:i:s")."',state='".$this->changeChar('已发货')."' where billid=".$billid;
		$this->db->Execute($sql);
		//更新出库单状态
		$sql="update stockoutmain set state='".$this->changeChar('已发货')."' where billid=".$billid;
		$this->db->Execute($sql);
		
		//更新订单发货金额
		$outtype=$this->utility->returntablefield("fahuodan", "billid", $billid, "outtype");
		if($outtype==$this->changeChar("销售出库"))
		{
			$dingdanid=$this->utility->returntablefield("stockoutmain", "billid", $billid, "dingdanbillid");
			$jine=$this->utility->returntablefield("stockoutmain", "billid", $billid, "totalmoney");
			$sql="update sellplanmain set fahuojine=fahuojine+".$jine." where billid=".$dingdanid;
			$this->db->Execute($sql);
			$this->updatesellplanmainfahuo($dingdanid);
		}
		return $dingdanid;
	}
	//撤销发货单
	function cancelFaHuo($billid)
	{
		$outinfo=$this->utility->returntablefield("stockoutmain", "billid",$billid,"totalmoney,outtype");
		$jine=$outinfo['totalmoney'];
		$outtype=$outinfo['outtype'];
		//发货单
		$sql="update fahuodan set state='".$this->changeChar('未发货')."' where billid=".$billid;
		$this->db->Execute($sql);
		//更新出库单状态
		$sql="update stockoutmain set state='".$this->changeChar('已出库')."' where billid=".$billid;
		$this->db->Execute($sql);
		$dingdanid=$this->utility->returntablefield("stockoutmain", "billid", $billid, "dingdanbillid");
		//更新订单发货金额
		if($outtype==$this->changeChar('销售出库'))
		{
			$sql="update sellplanmain set fahuojine=round(fahuojine-".$jine.",2) where billid=".$dingdanid;
			$this->db->Execute($sql);
			$this->updatesellplanmainfahuo($dingdanid);
		}
	}
	//更新订单表的发货状态
	function updatesellplanmainfahuo($dingdanid)
	{
		$sellplaninfo=$this->utility->returntablefield("sellplanmain", "billid", $dingdanid, "fahuostate,totalmoney,ifpay,huikuanjine,oddment,fahuojine,kaipiaostate,kaipiaojine,user_flag,billtype");

		$fahuojine=$sellplaninfo['fahuojine'];
		$fahuostate=$sellplaninfo['fahuostate'];
		$totalmoney=$sellplaninfo['totalmoney'];
		$sql="select sum(jine) as tuihuojine from sellplanmain_detail where num<0 and mainrowid=$dingdanid";
		$rs = $this->db->Execute($sql);
		$rs_a = $rs->GetArray();
		if($rs_a[0]['tuihuojine']<0)
			$totalmoney=$totalmoney-$rs_a[0]['tuihuojine'];
		if($fahuostate>-1)
		{
			if($totalmoney==$fahuojine)
			{
				if($fahuojine!=0)
					$fahuostate=4;	//发货状态=全部
				else //退单不需要发货
				{
					if(($sellplaninfo['huikuanjine']+$sellplaninfo['oddment'])==$sellplaninfo['totalmoney'])
						$fahuostate=4;
					else 
					{
						$billid=$this->utility->returntablefield("stockinmain", "caigoubillid", $dingdanid, "billid");
						if($billid!='')
							$fahuostate=2;
						else
							$fahuostate=0;
					}
						
				}
					
			}
			else
			{
				$billid=$this->utility->returntablefield("stockoutmain", "dingdanbillid", $dingdanid, "billid","state",$this->changeChar("未出库"));
				if($billid!='')
					$fahuostate=1;//发货状态=待出库
				else 
				{
					$billid=$this->utility->returntablefield("fahuodan", "dingdanbillid", $dingdanid, "billid","state",$this->changeChar("未发货"));
					if($billid!='')
						$fahuostate=2;//发货状态=需发货
					else 
					{
						if($fahuojine!=0)
							$fahuostate=3;	//发货状态=部分
						else
							$fahuostate=0;
					}
				}
			}
		}
		
		$sql="update sellplanmain set fahuostate=$fahuostate where billid=$dingdanid";
		$this->db->Execute($sql);
		$CaiWu=new CaiWu($this->db,$this->char);
		$CaiWu->updatesellplanmainFlag($dingdanid,1);
	}
	
	//订单出库，状态为=未出库
	function insertDingDanChuKu($dingdanbillid,$storeid,$allnum,$allmoney)
	{
		$zhuti=$this->utility->returntablefield("sellplanmain", "billid", $dingdanbillid, "zhuti");
		$sql = "select * from sellplanmain_detail where chukunum<>num and num>0 and mainrowid=".$dingdanbillid;
		$rs = $this->db->Execute($sql);
		$rs_detail = $rs->GetArray();
		if(sizeof($rs_detail)>0)
		{
			//获取出库单号
			$billid = $this->utility->returnAutoIncrement("billid","stockoutmain");
			$stockaccess="销售出库";
			//插入新出库单
			$sql = "select sum(num) as allnum,sum(jine) as alljine from sellplanmain_detail where chukunum<>num and num>0 and mainrowid=".$dingdanbillid;
			$rs = $this->db->Execute($sql);
			$rs_sum = $rs->GetArray();
			$allnum=$rs_sum[0]['allnum'];
			$allmoney=$rs_sum[0]['alljine'];
			$sql = "insert into stockoutmain (billid,zhuti,storeid,createman,createtime,dingdanbillid,state,totalnum,totalmoney,outtype) values(".
			$billid.",'".$zhuti."',".$storeid.",'".$_SESSION['LOGIN_USER_ID']."','".date("Y-m-d H:i:s")."',"
			.$dingdanbillid.",'未出库',$allnum,$allmoney,'$stockaccess')";
			$this->db->Execute($sql);
			for($i=0;$i<sizeof($rs_detail);$i++)
			{
					
				$sql="select max(id) as maxid from stockoutmain_detail";
				$rs = $this->db->Execute($sql);
				$rs_a=$rs->GetArray();
				$maxid=$rs_a[0]['maxid']+1;
				$num=intval($rs_detail[$i]['num'])-intval($rs_detail[$i]['chukunum']);
				$sql = "insert into stockoutmain_detail (id,prodid,prodname,prodguige,prodxinghao,proddanwei,price,zhekou,num,mainrowid,jine,opertype) values('$maxid','".
				$rs_detail[$i]['prodid']."','".$rs_detail[$i]['prodname']."','".$rs_detail[$i]['prodguige']."','".$rs_detail[$i]['prodxinghao'].
		    	"','".$rs_detail[$i]['proddanwei']."',".$rs_detail[$i]['price'].",".$rs_detail[$i]['zhekou'].",".$num.",".$billid.",".round($num*$rs_detail[$i]['price']*$rs_detail[$i]['zhekou'],2).",".$rs_detail[$i]['opertype'].")";
				$this->db->Execute($sql);
				$sql = "select * from sellplanmain_detail_color where id=".$rs_detail[$i]['id'];
				$rs = $this->db->Execute($sql);
				$rs_detail_color = $rs->GetArray();
				foreach ($rs_detail_color as $row)
				{
					$sql = "select sum(num) as allnum from stockoutmain_detail_color where color=".$row['color']." and id in (select distinct id from stockoutmain_detail a inner join stockoutmain b on a.mainrowid=b.billid where b.dingdanbillid=$dingdanbillid)";
					$rs = $this->db->Execute($sql);
					$rs_b = $rs->GetArray();
				
					$sql = "insert into stockoutmain_detail_color values($maxid,".$row['color'].",".($row['num']-$rs_b[0]['allnum']).")";
					$this->db->Execute($sql);
				}
					
			}
		}
		//退货入库
		$sql = "select * from sellplanmain_detail where chukunum<>num and num<0 and mainrowid=".$dingdanbillid;
		$rs = $this->db->Execute($sql);
		$rs_detail = $rs->GetArray();
		if(sizeof($rs_detail)>0)
		{
			//获取入库单号
			$billid = $this->utility->returnAutoIncrement("billid","stockinmain");
			$stockaccess="退货入库";
			//插入新入库单
			$sql = "select sum(num) as allnum,sum(jine) as alljine from sellplanmain_detail where chukunum<>num and num<0 and mainrowid=".$dingdanbillid;
			$rs = $this->db->Execute($sql);
			$rs_sum = $rs->GetArray();
			$allnum=-$rs_sum[0]['allnum'];
			$allmoney=-$rs_sum[0]['alljine'];
			$sql = "insert into stockinmain (billid,zhuti,storeid,createman,createtime,caigoubillid,state,totalnum,totalmoney,intype) values(".
			$billid.",'".$zhuti."',".$storeid.",'".$_SESSION['LOGIN_USER_ID']."','".date("Y-m-d H:i:s")."',"
			.$dingdanbillid.",'未入库',$allnum,$allmoney,'$stockaccess')";
			$this->db->Execute($sql);
			for($i=0;$i<sizeof($rs_detail);$i++)
			{
					
				$sql="select max(id) as maxid from stockinmain_detail";
				$rs = $this->db->Execute($sql);
				$rs_a=$rs->GetArray();
				$maxid=$rs_a[0]['maxid']+1;
				$num=intval(-$rs_detail[$i]['num'])-intval(-$rs_detail[$i]['chukunum']);
				$sql = "insert into stockinmain_detail (id,prodid,prodname,prodguige,prodxinghao,proddanwei,price,zhekou,num,mainrowid,jine,opertype) values('$maxid','".
				$rs_detail[$i]['prodid']."','".$rs_detail[$i]['prodname']."','".$rs_detail[$i]['prodguige']."','".$rs_detail[$i]['prodxinghao'].
		    	"','".$rs_detail[$i]['proddanwei']."',".$rs_detail[$i]['price'].",".$rs_detail[$i]['zhekou'].",".$num.",".$billid.",".round($num*$rs_detail[$i]['price']*$rs_detail[$i]['zhekou'],2).",".$rs_detail[$i]['opertype'].")";
				$this->db->Execute($sql);
				$sql = "select * from sellplanmain_detail_color where id=".$rs_detail[$i]['id'];
				$rs = $this->db->Execute($sql);
				$rs_detail_color = $rs->GetArray();
				foreach ($rs_detail_color as $row)
				{
					$sql = "select sum(num) as allnum from stockinmain_detail_color where color=".$row['color']." and id in (select distinct id from stockinmain_detail a inner join stockinmain b on a.mainrowid=b.billid where b.caigoubillid=$dingdanbillid)";
					$rs = $this->db->Execute($sql);
					$rs_b = $rs->GetArray();
				
					$sql = "insert into stockinmain_detail_color values($maxid,".$row['color'].",".(-$row['num']-$rs_b[0]['allnum']).")";
					$this->db->Execute($sql);
				}
					
			}
		}
		$this->updatesellplanmainfahuo($dingdanbillid);
	}
	/*
	//调拨出库，状态为=未出库
	function insertDiaoboChuKu($diaoboBillid)
	{
		//获取入库单号
		$billid = $this->utility->returnAutoIncrement("billid","stockoutmain");
		$diaoboInfo=$this->utility->returntablefield("stockchangemain","billid", $diaoboBillid, "zhuti,outstoreid");
		$zhuti=$diaoboInfo['zhuti'];
		$sql = "select * from stockchangemain_detail where num>0 and mainrowid=".$dingdanbillid;
		$rs = $this->db->Execute($sql);
		$rs_detail = $rs->GetArray();
		$stockaccess="销售出库";
		if(sizeof($rs_detail)==0 && $allnum<0)
		{
			$stockaccess="销售退库";
		}
		//插入新入库单
		$sql = "insert into stockoutmain (billid,zhuti,storeid,createman,createtime,dingdanbillid,state,totalnum,totalmoney,outtype) values(".
		$billid.",'".$zhuti."',".$storeid.",'".$_SESSION['LOGIN_USER_ID']."','".date("Y-m-d H:i:s")."',"
		.$dingdanbillid.",'未出库',$allnum,$allmoney,'$stockaccess')";
		$this->db->Execute($sql);

		$sql = "select * from sellplanmain_detail where chukunum<>num and mainrowid=".$dingdanbillid;
		$rs = $this->db->Execute($sql);
		$rs_detail = $rs->GetArray();
		for($i=0;$i<sizeof($rs_detail);$i++)
		{
				
			if($rs_detail[$i]['num']==0)
			continue;
			$sql="select max(id) as maxid from stockoutmain_detail";
			$rs = $this->db->Execute($sql);
			$rs_a=$rs->GetArray();
			$maxid=$rs_a[0]['maxid']+1;
			$sql = "insert into stockoutmain_detail (id,prodid,prodname,prodguige,prodxinghao,proddanwei,price,zhekou,num,mainrowid,jine) values('$maxid','".
			$rs_detail[$i]['prodid']."','".$rs_detail[$i]['prodname']."','".$rs_detail[$i]['prodguige']."','".$rs_detail[$i]['prodxinghao'].
	    	"','".$rs_detail[$i]['proddanwei']."',".$rs_detail[$i]['price'].",".$rs_detail[$i]['zhekou'].",".$rs_detail[$i]['num'].",".$billid.",".$rs_detail[$i]['jine'].")";
			$this->db->Execute($sql);
				
		}
		$this->updatesellplanmainfahuo($dingdanbillid);
	}
	*/
	//采购单入库
	function insertCaiGouRuKu($rowid,$totalnum,$totalmoney,$storeid,$yundanhao,$huoyungongsi)
	{
		$sql = "select * from buyplanmain where billid=".$rowid;
		$rs = $this->db->Execute($sql);
		$rs_a = $rs->GetArray();

		if (count($rs_a) !=1)
			throw new Exception("单号不存在");

		$sql = "select * from buyplanmain_detail where num>0 and mainrowid=".$rowid;
		$rs = $this->db->Execute($sql);
		$rs_detail = $rs->GetArray();
		$billid='';
		for($i=0;$i<sizeof($rs_detail);$i++)
		{
			$num=$_POST["num_".$rs_detail[$i]['id']];
			//插入入库明细
			if($num!=0)
			{
				if($billid=='')
				{
					//获取入库单号
					$billid = $this->utility->returnAutoIncrement("billid","stockinmain");
					//插入新入库单
					$sql = "insert into stockinmain (billid,zhuti,storeid,createman,createtime,caigoubillid,state,totalnum,totalmoney,intype,yundanhao,huoyungongsi) values(".
					$billid.",'".$rs_a[0]['zhuti']."',".$storeid.",'".$_SESSION['LOGIN_USER_ID']."','".date("Y-m-d H:i:s")."',"
					.$rowid.",'未入库',$totalnum,$totalmoney,'采购入库','$yundanhao','$huoyungongsi')";
					$this->db->Execute($sql);
					$newbill=true;
				}
				$sql="select max(id) as maxid from stockinmain_detail";
				$rs = $this->db->Execute($sql);
				$rs_a=$rs->GetArray();
				$maxid=$rs_a[0]['maxid']+1;
				$sql = "insert into stockinmain_detail (id,prodid,prodname,prodguige,prodxinghao,proddanwei,price,zhekou,num,mainrowid,jine,opertype) values('$maxid','".
				$rs_detail[$i]['prodid']."','".$rs_detail[$i]['prodname']."','".$rs_detail[$i]['prodguige']."','".$rs_detail[$i]['prodxinghao'].
	    		"','".$rs_detail[$i]['proddanwei']."',".$rs_detail[$i]['price'].",".$rs_detail[$i]['zhekou'].",".$num.",".$billid.",".round($num*$rs_detail[$i]['price']*$rs_detail[$i]['zhekou'],2).",".$rs_detail[$i]['opertype'].")";
				$this->db->Execute($sql);
				//插入颜色表
				$sql = "select * from buyplanmain_tmp_color where id=".$rs_detail[$i]['id'];
				$rs = $this->db->Execute($sql);
				$rs_b = $rs->GetArray();
				for($j=0;$j<sizeof($rs_b);$j++)
				{
					$sql="insert into stockinmain_detail_color (id,color,num) values($maxid,".$rs_b[$j]['color'].",".$rs_b[$j]['num'].")";
					$this->db->Execute($sql);
					
				}
			}
		}
		//更新本次入库数和金额
		if($billid!='')
		{
			$sql="select sum(num) as allnum,sum(jine) as allmoney from stockinmain_detail where mainrowid=$billid";
			$rs = $this->db->Execute($sql);
			$rs_a=$rs->GetArray();
			$totalnum=$rs_a[0]['allnum'];
			$totalmoney=$rs_a[0]['allmoney'];
		
			$sql = "update stockinmain set totalnum=$totalnum,totalmoney=$totalmoney where billid=$billid";
			$this->db->Execute($sql);
		}
		$sql = "select * from buyplanmain_detail where num<0 and mainrowid=".$rowid;
		$rs = $this->db->Execute($sql);
		$rs_detail = $rs->GetArray();
		$billid='';
		for($i=0;$i<sizeof($rs_detail);$i++)
		{
			$num=$_POST["num_".$rs_detail[$i]['id']];
			//插入入库明细
			if($num!=0)
			{
				if($billid=='')
				{
					//获取出库单号
					$billid = $this->utility->returnAutoIncrement("billid","stockoutmain");
					//插入新出库单
					$sql = "insert into stockoutmain (billid,zhuti,storeid,createman,createtime,dingdanbillid,state,totalnum,totalmoney,outtype) values(".
					$billid.",'".$rs_a[0]['zhuti']."',".$storeid.",'".$_SESSION['LOGIN_USER_ID']."','".date("Y-m-d H:i:s")."',"
					.$rowid.",'未出库',$totalnum,$totalmoney,'返厂出库')";
					$this->db->Execute($sql);
					$newbill=true;
				}
				$sql="select max(id) as maxid from stockoutmain_detail";
				$rs = $this->db->Execute($sql);
				$rs_a=$rs->GetArray();
				$maxid=$rs_a[0]['maxid']+1;
				$sql = "insert into stockoutmain_detail (id,prodid,prodname,prodguige,prodxinghao,proddanwei,price,zhekou,num,mainrowid,jine,opertype) values('$maxid','".
				$rs_detail[$i]['prodid']."','".$rs_detail[$i]['prodname']."','".$rs_detail[$i]['prodguige']."','".$rs_detail[$i]['prodxinghao'].
	    		"','".$rs_detail[$i]['proddanwei']."',".$rs_detail[$i]['price'].",".$rs_detail[$i]['zhekou'].",".-$num.",".$billid.",".-round($num*$rs_detail[$i]['price']*$rs_detail[$i]['zhekou'],2).",".$rs_detail[$i]['opertype'].")";
				$this->db->Execute($sql);
				//插入颜色表
				$sql = "select * from buyplanmain_tmp_color where id=".$rs_detail[$i]['id'];
				$rs = $this->db->Execute($sql);
				$rs_b = $rs->GetArray();
				for($j=0;$j<sizeof($rs_b);$j++)
				{
					$sql="insert into stockoutmain_detail_color (id,color,num) values($maxid,".$rs_b[$j]['color'].",".-$rs_b[$j]['num'].")";
					$this->db->Execute($sql);
					
				}
			}
		}
		//更新本次出库数和金额
		if($billid!='')
		{
			$sql="select sum(num) as allnum,sum(jine) as allmoney from stockoutmain_detail where mainrowid=$billid";
			$rs = $this->db->Execute($sql);
			$rs_a=$rs->GetArray();
			$totalnum=$rs_a[0]['allnum'];
			$totalmoney=$rs_a[0]['allmoney'];
		
			$sql = "update stockoutmain set totalnum=$totalnum,totalmoney=$totalmoney where billid=$billid";
			$this->db->Execute($sql);
		}
		$sql = "delete from buyplanmain_tmp_color where id in (select id from buyplanmain_detail where mainrowid=".$rowid.")";
		$this->db->Execute($sql);
		//改变采购单状态
		$this->updatebuyplanmainfahuo($rowid);

	}
	function terminateCaiGou($rowid)
	{
		$sql = "select * from buyplanmain where billid=".$rowid;
		$rs = $this->db->Execute($sql);
		$rs_a = $rs->GetArray();
		$rukumoney=$rs_a[0]['rukumoney'];
		$paymoney=$rs_a[0]['paymoney'];
		$oddment=$rs_a[0]['oddment'];
		$supplyid=$rs_a[0]['supplyid'];
		if (count($rs_a) !=1)
			throw new Exception("单号不存在");

		//多付金额转为预付款
		if($paymoney+$oddment>$rukumoney)
		{
			$jine=$paymoney+$oddment-$rukumoney;
			$id = $this->utility->returnAutoIncrementUnitBillid("prepaybillid");
			$curchuzhi=floatvalue($this->utility->returntablefield("supply", "rowid", $supplyid, "yufukuan"));
			$sql="insert into accessprepay (id,supplyid,linkmanid,curchuzhi,jine,accountid,createman,createtime,opertype,beizhu)
			values(".$id.",".$supplyid.",'',".$curchuzhi.",".$jine.",'','".$_SESSION['LOGIN_USER_ID']."','".date("Y-m-d H:i:s")."','预付货款','采购单 $rowid 多付的金额转预付款')";
			$this->db->Execute($sql);
			$sql="update supply set yufukuan=yufukuan+($jine) where rowid=".$supplyid;
			$this->db->Execute($sql);
			$sql="update buyplanmain set totalmoney=rukumoney,paymoney=rukumoney-oddment where billid=$rowid";
			$this->db->Execute($sql);
		}
		else 
		{
			$sql="update buyplanmain set totalmoney=rukumoney where billid=$rowid";
			$this->db->Execute($sql);
		}
		$sql="update buyplanmain_detail set num=recnum,jine=recnum*zhekou*price where mainrowid=$rowid";
		$this->db->Execute($sql);
		
		//改变采购单状态
		$this->updatebuyplanmainfahuo($rowid);
		$CaiWu=new CaiWu($this->db);
		$CaiWu->updatebuyplanmainfukuan($rowid);

	}
	//更新采购表的入库状态
	function updatebuyplanmainfahuo($caigoudanid)
	{
		$buyplaninfo=$this->utility->returntablefield("buyplanmain", "billid", $caigoudanid, "state,totalmoney,ifpay,rukumoney,shoupiaostate,user_flag");
		$fahuostate=$buyplaninfo['state'];
		$ifpay=$buyplaninfo['ifpay'];
		$kaipiaostate=$buyplaninfo['shoupiaostate'];
		$rukumoney=$buyplaninfo['rukumoney'];
		$totalmoney=$buyplaninfo['totalmoney'];
		$user_flag=$buyplaninfo['user_flag'];
		if($totalmoney==$rukumoney)
		{
			if($totalmoney!=0)
				$fahuostate=5;	//入库状态=全部
			else 
			{
				$billid=$this->utility->returntablefield("stockinmain", "caigoubillid", $caigoudanid,"billid","state","已入库","intype","采购入库");
				$billid1=$this->utility->returntablefield("stockoutmain", "dingdanbillid", $caigoudanid,"billid","state","已出库","outtype","返厂出库");
				if($billid!='' && $billid1!='')
					$fahuostate=5;
				else
				{
					$id=$this->utility->returntablefield("buyplanmain_detail", "mainrowid", $caigoudanid,"id");
					if($id!='')
						$fahuostate=2;//已录明细
					else 
						$fahuostate=1;  //需要
				}
			}
		}
		else 
		{
			$billid=$this->utility->returntablefield("stockinmain", "caigoubillid", $caigoudanid,"billid","state","未入库","intype","采购入库");
			$billid1=$this->utility->returntablefield("stockoutmain", "dingdanbillid", $caigoudanid,"billid","state","未出库","outtype","返厂出库");
			
			if($rukumoney!=0 && $billid=='' && $billid1=='')
				$fahuostate=4;	//入库状态=部分
			else
			{
				
				if($billid!='' || $billid1!='')
					$fahuostate=3;//待入库
				else 
				{
					$id=$this->utility->returntablefield("buyplanmain_detail", "mainrowid", $caigoudanid,"id");
					if($id!='')
						$fahuostate=2;//已录明细
					else 
						$fahuostate=1;  //需要
				}
			}
				
		}

		$sql="update buyplanmain set state=$fahuostate where billid=$caigoudanid";
		$this->db->Execute($sql);
		$CaiWu=new CaiWu($this->db);
		$CaiWu->updatebuyplanmainFlag($caigoudanid);
	}

	//确认入库
	function confirmRuKu($rowid)
	{
		$stockinfo = $this->utility->returntablefield("stockinmain","billid",$rowid,"storeid,intype,totalmoney,state");
		if($stockinfo['state']=='已入库')
			throw new Exception("此单已入库，不能重复入库");
		$storeid=$stockinfo['storeid'];
		$intype=$stockinfo['intype'];
		$totalmoney=$stockinfo['totalmoney'];
		$sql = "select * from stockinmain_detail where mainrowid=".$rowid;
		$rs = $this->db->Execute($sql);
		$rs_detail = $rs->GetArray();
		$nokucunjine=0;
		for($i=0;$i<sizeof($rs_detail);$i++)
		{
			$ifkucun=$this->utility->returntablefield("product","productid",$rs_detail[$i]['prodid'],"ifkucun");
			if($ifkucun=="否")
			{
				$nokucunjine=$nokucunjine+($rs_detail[$i]['price']*$rs_detail[$i]['zhekou']*$rs_detail[$i]['num']);
				continue;
			}
			$sql = "select * from store where storeid=".$storeid." and prodid='".$rs_detail[$i]['prodid']."'";
			$rs = $this->db->Execute($sql);
			$rs_store = $rs->GetArray();
			$kucun=0;
			if(sizeof($rs_store)>0)
				$kucun=$rs_store[0]['num'];
			//if($kucun+$rs_detail[$i]['num']<0)
			//	throw new Exception("编号为：".$rs_detail[$i]['prodid']." 的产品库存不足");
			$maxid=0;	
			if(sizeof($rs_store)==0)
			{
				$maxid = $this->utility->returnAutoIncrement("id","store");
				$sql = "insert into store (id,prodid,storeid,num,price) values($maxid,'".
				$rs_detail[$i]['prodid']."',".$storeid.",".$rs_detail[$i]['num'].",".$rs_detail[$i]['price']*$rs_detail[$i]['zhekou'].")";
				$this->db->Execute($sql);
				
			}
			else
			{
				$maxid=$rs_store[0]['id'];
				if($rs_store[0]['num']+$rs_detail[$i]['num']!=0)
					$junjia=round(($rs_store[0]['price']*$rs_store[0]['num']+$rs_detail[$i]['price']*$rs_detail[$i]['zhekou']*$rs_detail[$i]['num'])/($rs_store[0]['num']+$rs_detail[$i]['num']),3);
				else
				{
					if(round(floatval($rs_store[0]['price']*$rs_store[0]['num'])+floatval($rs_detail[$i]['price']*$rs_detail[$i]['zhekou']*$rs_detail[$i]['num']),0)==0)
					$junjia=0;
					else
					throw new Exception("编号为：".$rs_detail[$i]['prodid']." 的产品入库后库存数量为零，但金额不为零，无法计算加权平均价");
				}
				if($junjia<0)
					throw new Exception("编号为：".$rs_detail[$i]['prodid']." 的产品加权平均价不能为负值，请先做报溢单");
				$sql = "update store set num=num+(".$rs_detail[$i]['num']."),price=".$junjia." where id=$maxid";
				$this->db->Execute($sql);
			}
			//颜色处理
			$sql = "select * from stockinmain_detail_color where id=".$rs_detail[$i]['id'];
			$rs = $this->db->Execute($sql);
			$rs_b = $rs->GetArray();
			for($j=0;$j<sizeof($rs_b);$j++)
			{
				$sql = "select * from store_color where id=$maxid and color=".$rs_b[$j]['color'];
				$rs = $this->db->Execute($sql);
				$rs_c = $rs->GetArray();
				if(sizeof($rs_c)==0)
					$sql="insert into store_color (id,color,num) values($maxid,".$rs_b[$j]['color'].",".$rs_b[$j]['num'].")";
				else 
					$sql="update store_color set num=num+(".$rs_b[$j]['num'].") where id=$maxid and color=".$rs_b[$j]['color'];
				$this->db->Execute($sql);
				
			}
			//print $sql;exit;
				
		}
		//$sql="delete from store where num=0";
		//$this->db->Execute($sql);

		//更新入库单状态
		$sql = "update stockinmain set state='已入库',indate='".date("Y-m-d H:i:s")."',instoreshenhe='".$_SESSION['LOGIN_USER_ID']."' where billid=".$rowid;
		$this->db->Execute($sql);

		
		//更新采购单状态
		$caigoubillid=$this->utility->returntablefield("stockinmain","billid",$rowid,"caigoubillid");
		if($intype=='采购入库')
			$this->UpdateCaigouState($caigoubillid);
		else if($intype=='退货入库')
			$this->updatesellplanmainfahuo($caigoubillid);
		else if($intype=='盘点入库')
		{
			$kind=1;
			$feiyongname='盘点收益';
			$jine=$totalmoney;
			$feiyongtype=$this->utility->returntablefield("feiyongtype", "typename", $feiyongname, "id");
			$sql="insert into feiyongrecord (typeid,jine,accountid,chanshengdate,createman,createtime,kind) values($feiyongtype,$jine,'','".date("Y-m-d")."','".$_SESSION['LOGIN_USER_ID']."','".date("Y-m-d H:i:s")."',$kind)";
			$this->db->Execute($sql);
			
			$state=$this->utility->returntablefield("stockoutmain","dingdanbillid", $caigoubillid,"state","outtype","盘点出库");
			if($state=="" || $state=="已出库")
			{
				$sql="update storecheck set state='盘点结束' where billid=$caigoubillid";
				$this->db->Execute($sql);
			}
		}
		else if($intype=='调拨入库')
		{
			$sql="update stockchangemain set state='4',instoreshenhe='".$_SESSION['LOGIN_USER_ID']."',inshenhetime='".date("Y-m-d H:i:s")."' where billid=$caigoubillid";
			$this->db->Execute($sql);
		}
		else if($intype=='组装入库')
		{
			$sql="update productzuzhuang set state='3',instoreshenhe='".$_SESSION['LOGIN_USER_ID']."',inshenhetime='".date("Y-m-d H:i:s")."' where billid=$caigoubillid";
			$this->db->Execute($sql);
		}
		//不计库存产品生成费用单
		if($nokucunjine!=0)
		{
			$feiyongtype=$this->utility->returntablefield("feiyongtype", "typename", "不计库存产品采购费", "id");
			$sql="insert into feiyongrecord (typeid,jine,accountid,chanshengdate,createman,createtime,kind,beizhu) values($feiyongtype,$nokucunjine,1,'".date("Y-m-d")."','".$_SESSION['LOGIN_USER_ID']."','".date("Y-m-d H:i:s")."',-1,'".$intype."单:".$caigoubillid."')";
			$this->db->Execute($sql);
		}
		
	}

	//更新采购单已入库金额
	function UpdateCaigouState($caigoubillid)
	{
		$sql= "select sum(totalmoney) as allmoney from stockinmain where state='已入库' and intype='采购入库' and caigoubillid=".$caigoubillid;
		$rs=$this->db->Execute($sql);
		$rs_a = $rs->GetArray();
		$ruku=$rs_a[0]['allmoney'];
		$sql= "select sum(totalmoney) as allmoney from stockoutmain where state='已出库' and outtype='返厂出库' and dingdanbillid=".$caigoubillid;
		$rs=$this->db->Execute($sql);
		$rs_a = $rs->GetArray();
		$chuku=$rs_a[0]['allmoney'];
		
		
		$sql = "update buyplanmain set rukumoney=".floatvalue($ruku-$chuku)." where billid=".$caigoubillid;
		$this->db->Execute($sql);
		//更新采购单明细
		$sql="select * from buyplanmain_detail where mainrowid=$caigoubillid";
		$rs = $this->db->Execute($sql);
		$rs_detail = $rs->GetArray();
		for($i=0;$i<sizeof($rs_detail);$i++)
		{
			if($rs_detail[$i]['num']>0)
			{
				$sql= "select sum(a.num) as allnum from stockinmain_detail a inner join stockinmain b on a.mainrowid=b.billid where b.state='已入库' and b.intype='采购入库' and b.caigoubillid=$caigoubillid and a.prodid='".$rs_detail[$i]['prodid']."' and opertype=".$rs_detail[$i]['opertype'];
				$rs = $this->db->Execute($sql);
				$rs_sum = $rs->GetArray();
				$recnum=$rs_sum[0]['allnum'];
			}
			else 
			{
				$sql= "select sum(a.num) as allnum from stockoutmain_detail a inner join stockoutmain b on a.mainrowid=b.billid where b.state='已出库' and b.outtype='返厂出库' and b.dingdanbillid=$caigoubillid and a.prodid='".$rs_detail[$i]['prodid']."' and opertype=".$rs_detail[$i]['opertype'];
				$rs = $this->db->Execute($sql);
				$rs_sum = $rs->GetArray();
				$recnum=-$rs_sum[0]['allnum'];
			}
			$sql= "update buyplanmain_detail set recnum=".floatvalue($recnum)." where prodid='".$rs_detail[$i]['prodid']."' and mainrowid=$caigoubillid and opertype=".$rs_detail[$i]['opertype'];
			$this->db->Execute($sql);
		}
		$sql="select * from buyplanmain_detail where ((recnum>num and num>0) or (recnum<num and num<0)) and mainrowid=$caigoubillid";
		$rs = $this->db->Execute($sql);
		$rs_a = $rs->GetArray();
		if(sizeof($rs_a)>0)
		{
			throw new Exception($rs_a[0]['prodid']."的入库数超过了采购数，请检查是否重复入库");
		}
		$this->updatebuyplanmainfahuo($caigoubillid);

	}
	
	function deleteRuKu($rukubillid)
	{
		$stockinInfo = $this->utility->returntablefield("stockinmain","billid",$rukubillid,"storeid,caigoubillid,totalmoney");
		$storeid=$stockinInfo['storeid'];
		$caigoubillid=$stockinInfo['caigoubillid'];
		$totalmoney=$stockinInfo['totalmoney'];
		$sql = "select * from stockinmain where billid=".$rukubillid;
		$rs = $this->db->Execute($sql);
		$rs_detail = $rs->GetArray();
		$intype=$rs_detail[0]['intype'];
		if($rs_detail[0]['state']=='已入库')
		{
			//撤销库存
			$sql = "select * from stockinmain_detail where mainrowid=".$rukubillid;
			$rs = $this->db->Execute($sql);
			$rs_detail = $rs->GetArray();
			$nokucunjine=0;
			
			for($j=0;$j<sizeof($rs_detail);$j++)
			{
				
				$ifkucun=$this->utility->returntablefield("product","productid",$rs_detail[$j]['prodid'],"ifkucun");
				if($ifkucun=="否")
				{
					$nokucunjine=$nokucunjine+($rs_detail[$j]['price']*$rs_detail[$j]['zhekou']*$rs_detail[$j]['num']);
					continue;
				}
					
				$sql = "select * from store where storeid=".$storeid." and prodid='".$rs_detail[$j]['prodid']."'";
				$rs = $this->db->Execute($sql);
				$rs_store = $rs->GetArray();
				$kucun=0;
				$maxid=0;
				
				if(sizeof($rs_store)>0)
				{
					$kucun=$rs_store[0]['num'];
					$maxid=$rs_store[0]['id'];
				}
				//if($kucun-$rs_detail[$j]['num']<0)
				//	throw new Exception("编号为：".$rs_detail[$j]['prodid']." 的产品库存".$kucun."不足");
				
				if($kucun-$rs_detail[$j]['num']!=0)
					$junjia=round(($rs_store[0]['price']*$kucun-$rs_detail[$j]['price']*$rs_detail[$j]['zhekou']*$rs_detail[$j]['num'])/($kucun-$rs_detail[$j]['num']),2);
				else
				{
					$zonge1=floatval(round($rs_store[0]['price']*$kucun,2));
					$zonge2=floatval(round($rs_detail[$j]['price']*$rs_detail[$j]['zhekou']*$rs_detail[$j]['num'],2));
					if(round($zonge1-$zonge2,0)==0)
						$junjia=0;
					else
						throw new Exception("编号为：".$rs_detail[$j]['prodid']." 的产品撤销后库存数量为零，但金额不为零，无法计算加权平均价".$zonge1."-".$zonge2);
				}
				if($junjia<0)
						throw new Exception("编号为：".$rs_detail[$j]['prodid']." 的产品加权平均价为负值，请先做报溢单");
				$sql = "update store set num=num-(".$rs_detail[$j]['num']."),price=".$junjia." where storeid=".$storeid." and prodid='".$rs_detail[$j]['prodid']."'";
				$this->db->Execute($sql);
				//颜色处理
				$sql = "select * from stockinmain_detail_color where id=".$rs_detail[$j]['id'];
				$rs = $this->db->Execute($sql);
				$rs_b = $rs->GetArray();
				for($m=0;$m<sizeof($rs_b);$m++)
				{
					$sql = "select * from store_color where id=$maxid and color=".$rs_b[$m]['color'];
					$rs = $this->db->Execute($sql);
					$rs_c = $rs->GetArray();
					$sql="update store_color set num=num-(".$rs_b[$m]['num'].") where id=$maxid and color=".$rs_b[$m]['color'];
					$this->db->Execute($sql);
				}
				

			}
			//$sql="delete from store where num=0";
			//$this->db->Execute($sql);
				
			//不及库存产品生成费用单
			if($nokucunjine!=0)
			{
				
				$feiyongtype=$this->utility->returntablefield("feiyongtype", "typename", "不计库存产品采购费", "id");
				$sql="insert into feiyongrecord (typeid,jine,accountid,chanshengdate,createman,createtime,kind) values($feiyongtype,-$nokucunjine,1,'".date("Y-m-d")."','".$_SESSION['LOGIN_USER_ID']."','".date("Y-m-d H:i:s")."',-1)";
				$this->db->Execute($sql);
			}
		}
		
		$sql = "delete from stockinmain where billid=".$rukubillid;
		$this->db->Execute($sql);
		
		
		if($caigoubillid==0)
		{
			$sql="delete from store_init where storeid=$storeid and flag=1";
			$this->db->Execute($sql);
		}
		else 
		{
		
			if($intype=='采购入库')
				$this->UpdateCaigouState($caigoubillid);
			else if($intype=='退货入库')
				$this->updatesellplanmainfahuo($caigoubillid);
			else if($intype=='盘点入库')
			{
				$kind=1;
				$feiyongname='盘点收益';
				$jine=-$totalmoney;
				$feiyongtype=$this->utility->returntablefield("feiyongtype", "typename", $feiyongname, "id");
				$sql="insert into feiyongrecord (typeid,jine,accountid,chanshengdate,createman,createtime,kind) values($feiyongtype,$jine,'','".date("Y-m-d")."','".$_SESSION['LOGIN_USER_ID']."','".date("Y-m-d H:i:s")."',$kind)";
				$this->db->Execute($sql);
				
				$state=$this->utility->returntablefield("stockoutmain","dingdanbillid", $caigoubillid,"state","outtype","盘点出库");
				$newState="等待出入库确认";
				if($state=="" || $state=="等待出入库确认")
					$newState="已录明细";
				$sql="update storecheck set state='$newState' where billid=$caigoubillid";
				$this->db->Execute($sql);
			}
			else if($intype=='调拨入库')
			{	
	
				$sql="update stockchangemain set instoreshenhe='',inshenhetime='' where billid=$caigoubillid";
				$this->db->Execute($sql);
				$sql="update stockchangemain set state='3'  where instoreshenhe='' and outstoreshenhe<>'' and  billid=$caigoubillid";
				$this->db->Execute($sql);
				$sql="update stockchangemain set state='2'  where instoreshenhe='' and outstoreshenhe='' and  billid=$caigoubillid";
				$this->db->Execute($sql);
			}
			else if($intype=='组装入库')
			{
				$sql="update productzuzhuang set instoreshenhe='',inshenhetime='' where billid=$caigoubillid";
				$this->db->Execute($sql);
				
				$sql="update productzuzhuang set state='1'  where instoreshenhe='' and outstoreshenhe='' and  billid=$caigoubillid";
				$this->db->Execute($sql);
			}
		}
		
	}
	
	//店面销售单出库
	function insertSellOneChuKu($billid,$zhuti,$storeid)
	{
		$createman=$_SESSION['LOGIN_USER_ID'];
		//插入销售明细表
		$sql="insert into sellplanmain_detail (prodid,prodname,prodguige,prodxinghao,proddanwei,price,zhekou,num,beizhu,mainrowid,jine,chukunum,lirun,oldprodid,opertype,orderid,inputtime,sellprice,zengpinzhekou) (select prodid,prodname,prodguige,prodxinghao,proddanwei,price,zhekou,num,beizhu,mainrowid,jine,chukunum,lirun,oldprodid,opertype,orderid,inputtime,sellprice,zengpinzhekou from sellplanmain_detail_tmp where mainrowid=$billid)";
		$this->db->Execute($sql);
		$sql="select * from sellplanmain_detail_tmp_color where id in (select id from sellplanmain_detail_tmp where mainrowid=$billid)";
		$rs=$this->db->Execute($sql);
		$rs_a=$rs->GetArray();
		foreach ($rs_a as $row)
		{
			$id=$row['id'];
			$sql="select * from sellplanmain_detail_tmp where id=$id";
			$rs=$this->db->Execute($sql);
			$rs_b=$rs->GetArray();
			$sql="select id from sellplanmain_detail where mainrowid=".$rs_b[0]['mainrowid']." and prodid='".$rs_b[0]['prodid']."' and opertype=".$rs_b[0]['opertype'];
			$rs=$this->db->Execute($sql);
			$rs_c=$rs->GetArray();
			$sql="insert into sellplanmain_detail_color (id,num,color) values(".$rs_c[0]['id'].",".$row['num'].",".$row['color'].")";
			$this->db->Execute($sql);
		}
		
		$sql="delete from sellplanmain_detail_tmp where mainrowid=$billid";
		$this->db->Execute($sql);
		
		//出库
		$chukubillid=0;
		$sql="select sum(num) as num,sum(jine) as jine from sellplanmain_detail where num>0 and mainrowid=$billid";
		$rs=$this->db->Execute($sql);
		$rs_a=$rs->GetArray();
		$allnum=$rs_a[0]['num'];
		$allmoney=$rs_a[0]['jine'];
		if($allnum>0)
		{
			$chukubillid = $this->utility->returnAutoIncrement("billid","stockoutmain");
			//插入新出库单
			
			$sql = "insert into stockoutmain (billid,zhuti,storeid,createman,createtime,dingdanbillid,state,totalnum,totalmoney,outtype,outdate,outstoreshenhe) values(".
			$chukubillid.",'$zhuti',".$storeid.",'".$createman."','".date("Y-m-d H:i:s")."',"
			.$billid.",'".$this->changeChar("已出库")."',$allnum,$allmoney,'".$this->changeChar("销售出库")."','".date("Y-m-d H:i:s")."','$createman')";
			$this->db->Execute($sql);
			
			$sql = "select * from sellplanmain_detail where num>0 and mainrowid=".$billid;
			$rs = $this->db->Execute($sql);
			$rs_detail = $rs->GetArray();

			for($i=0;$i<sizeof($rs_detail);$i++)
			{
				$sql="select * from stockoutmain_detail where mainrowid=".$chukubillid." and prodid='".$rs_detail[$i]['prodid']."'";
				$rs = $this->db->Execute($sql);
				$rs_a = $rs->GetArray();
				if(sizeof($rs_a)>0)
				{
					$maxid=$rs_a[0]['id'];
					$sql="update stockoutmain_detail set num=num+".$rs_detail[$i]['num']." where mainrowid=".$chukubillid." and prodid='".$rs_detail[$i]['prodid']."'";
				}
				else 
				{
					$maxid = $this->utility->returnAutoIncrement("id","stockoutmain_detail");
					$sql = "insert into stockoutmain_detail (id,prodid,prodname,prodguige,prodxinghao,proddanwei,price,zhekou,num,mainrowid,jine,opertype) values('$maxid','".
					$rs_detail[$i]['prodid']."','".$rs_detail[$i]['prodname']."','".$rs_detail[$i]['prodguige']."','".$rs_detail[$i]['prodxinghao'].
		    		"','".$rs_detail[$i]['proddanwei']."',".$rs_detail[$i]['price'].",".$rs_detail[$i]['zhekou'].",".$rs_detail[$i]['num'].",".$chukubillid.",".$rs_detail[$i]['jine'].",".$rs_detail[$i]['opertype'].")";
				}
				$this->db->Execute($sql);
	
				//扣减库存
				$storearray=$this->utility->returntablefield("product","productid",$rs_detail[$i]['prodid'],"ifkucun,hascolor");
				$ifkucun=$storearray['ifkucun'];
				$hascolor=$storearray['hascolor'];
				$chengben=0;
				
				if($ifkucun==$this->changeChar("是"))
				{
					$sql = "select * from store where storeid=".$storeid." and prodid='".$rs_detail[$i]['prodid']."'";
					$rs = $this->db->Execute($sql);
					$rs_store = $rs->GetArray();
					
					if(count($rs_store)==0)
					{
						//throw new Exception("库存中不存在 ".$rs_detail[$i]['prodid']." 的商品");
						$chengben=round($rs_detail[$i]['price']*$rs_detail[$i]['zhekou'],2);
						$storemaxid=$this->utility->returnAutoIncrement("id", "store");
						$sql="insert into store (id,prodid,num,price,storeid) values ($storemaxid,'".$rs_detail[$i]['prodid']."',-".$rs_detail[$i]['num'].",$chengben,$storeid)";
						$this->db->Execute($sql);
					}
					else
					{
						
						//if($rs_store[0]['num']-$rs_detail[$i]['num']<0)
						//	throw new Exception($rs_detail[$i]['prodid']." 库存不足！");
						$chengben=$rs_store[0]['price'];
						$storemaxid=$rs_store[0]['id'];
						$sql = "update store set num=num-(".$rs_detail[$i]['num'].") where storeid=".$storeid." and prodid='".$rs_detail[$i]['prodid']."'";
						$this->db->Execute($sql);
						
					}
					if($hascolor==$this->changeChar("是"))
					{
						$sql="select * from sellplanmain_detail_color where id=".$rs_detail[$i]['id'];
						$rs = $this->db->Execute($sql);
						$rs_color = $rs->GetArray();
						foreach ($rs_color as $row)
						{
							$kucun=$this->utility->returntablefield("store_color", "id", $storemaxid, "num","color",$row['color']);
							if($kucun=='')
								$sql ="insert store_color values(".$storemaxid.",".$row['color'].",-".$row['num'].")";
							else	
								$sql = "update store_color set num=num-(".$row['num'].") where id=".$storemaxid." and color='".$row['color']."'";
							$this->db->Execute($sql);
							$sql="insert into stockoutmain_detail_color values($maxid,".$row['color'].",".$row['num'].")";
							$this->db->Execute($sql);
						}
					}
					
					
				}
				//更新出库明细
				$sql = "update stockoutmain_detail set avgprice=$chengben,lirun=round((price*zhekou-$chengben)*num,2) where id=".$maxid;
				$this->db->Execute($sql);
	
				$sql="update sellplanmain_detail set chukunum=num,lirun=round((price*zhekou-$chengben)*num,2) where mainrowid=".$billid." and prodid='".$rs_detail[$i]['prodid']."' and opertype=".$rs_detail[$i]['opertype'];
				$this->db->Execute($sql);
				
			}
		}
		//入库
		$sql="select sum(num) as num,sum(jine) as jine from sellplanmain_detail where num<0 and mainrowid=$billid";
		$rs=$this->db->Execute($sql);
		$rs_a=$rs->GetArray();
		$allnum=$rs_a[0]['num'];
		$allmoney=$rs_a[0]['jine'];
		if($allnum<0)
		{
			$rukubillid = $this->utility->returnAutoIncrement("billid","stockinmain");
			//插入新入库单
			
			$sql = "insert into stockinmain(billid,zhuti,storeid,createman,createtime,caigoubillid,state,totalnum,totalmoney,indate,intype,instoreshenhe) values(".
			$rukubillid.",'$zhuti',".$storeid.",'".$createman."','".date("Y-m-d H:i:s")."',"
			.$billid.",'".$this->changeChar("已入库")."',-$allnum,-$allmoney,'".date("Y-m-d H:i:s")."','".$this->changeChar("退货入库")."','".$createman."')";
			$this->db->Execute($sql);
	
			$sql = "select * from sellplanmain_detail where num<0 and mainrowid=".$billid;
			$rs = $this->db->Execute($sql);
			$rs_detail = $rs->GetArray();
			for($i=0;$i<sizeof($rs_detail);$i++)
			{
				
				$rs_detail[$i]['num']=-$rs_detail[$i]['num'];
				$rs_detail[$i]['jine']=-$rs_detail[$i]['jine'];
				$sql="select * from stockinmain_detail where mainrowid=".$rukubillid." and prodid='".$rs_detail[$i]['prodid']."'";
				$rs = $this->db->Execute($sql);
				$rs_a = $rs->GetArray();
				if(sizeof($rs_a)>0)
				{
					$maxid=$rs_a[0]['id'];
					$sql="update stockinmain_detail set num=num+".$rs_detail[$i]['num']." where mainrowid=".$rukubillid." and prodid='".$rs_detail[$i]['prodid']."'";
				}
				else
				{
					$maxid = $this->utility->returnAutoIncrement("id","stockinmain_detail");
					$sql = "insert into stockinmain_detail (id,prodid,prodname,prodguige,prodxinghao,proddanwei,price,zhekou,num,mainrowid,jine,opertype) values('$maxid','".
					$rs_detail[$i]['prodid']."','".$rs_detail[$i]['prodname']."','".$rs_detail[$i]['prodguige']."','".$rs_detail[$i]['prodxinghao'].
		    		"','".$rs_detail[$i]['proddanwei']."',".$rs_detail[$i]['price'].",".$rs_detail[$i]['zhekou'].",".$rs_detail[$i]['num'].",".$rukubillid.",".$rs_detail[$i]['jine'].",".$rs_detail[$i]['opertype'].")";
				}
				$this->db->Execute($sql);
	
				//增加库存
				$storearray=$this->utility->returntablefield("product","productid",$rs_detail[$i]['prodid'],"ifkucun,hascolor");
				$ifkucun=$storearray['ifkucun'];
				$hascolor=$storearray['hascolor'];
				$chengben=0;
				if($ifkucun==$this->changeChar("是"))
				{
					$sql = "select * from store where storeid=".$storeid." and prodid='".$rs_detail[$i]['prodid']."'";
					$rs = $this->db->Execute($sql);
					$rs_store = $rs->GetArray();
					$storemaxid=0;
					if(count($rs_store)==0)
					{
							
							$chengben=$rs_detail[$i]['price']*$rs_detail[$i]['zhekou'];
							$storemaxid=$this->utility->returnAutoIncrement("id", "store");
							$sql="insert into store (id,prodid,num,price,storeid) values($storemaxid,'".$rs_detail[$i]['prodid']."',".$rs_detail[$i]['num'].",".$chengben.",".$storeid.")";
							$this->db->Execute($sql);
								
					}
					else
					{
						$storemaxid=$rs_store[0]['id'];
						if($rs_store[0]['num']+$rs_detail[$i]['num']!=0)
						  $chengben=round(($rs_store[0]['price']*$rs_store[0]['num']+$rs_detail[$i]['num']*$rs_detail[$i]['zhekou']*$rs_detail[$i]['price'])/($rs_store[0]['num']+$rs_detail[$i]['num']),2);
						else 
						  $chengben=$rs_store[0]['price'];
						if($chengben<0)
						{
							throw new Exception($this->changeChar("产品 ".$rs_detail[$i]['prodid']." 的加权平均价不能为负值，请先做报溢单"));	
						}
						$sql = "update store set num=num+(".$rs_detail[$i]['num']."),price=$chengben where storeid=".$storeid." and prodid='".$rs_detail[$i]['prodid']."'";
						$this->db->Execute($sql);
					}
					if($hascolor==$this->changeChar("是"))
					{
						$sql="select * from sellplanmain_detail_color where id=".$rs_detail[$i]['id'];
						$rs = $this->db->Execute($sql);
						$rs_color = $rs->GetArray();
						foreach ($rs_color as $row)
						{
							$row['num']=-$row['num'];
							$kucun=$this->utility->returntablefield("store_color", "id", $storemaxid, "num","color",$row['color']);
							if($kucun=='')
								$sql ="insert store_color values(".$storemaxid.",".$row['color'].",".$row['num'].")";
							else
								$sql = "update store_color set num=num+(".$row['num'].") where id=".$storemaxid." and color='".$row['color']."'";
							$this->db->Execute($sql);
							$sql="insert into stockinmain_detail_color values($maxid,".$row['color'].",".$row['num'].")";
							$this->db->Execute($sql);
						}
					}
					
				}
	
				$sql="update sellplanmain_detail set chukunum=num where mainrowid=".$billid." and prodid='".$rs_detail[$i]['prodid']."' and opertype=".$rs_detail[$i]['opertype'];
				$this->db->Execute($sql);
				
			}
		}
		
		$this->updatesellplanmainfahuo($billid);
		return $chukubillid;

	}
	//撤销出库
	function deleteChuKu($chukubillid)
	{
		$stockoutinfo=$this->utility->returntablefield("stockoutmain","billid",$chukubillid,"dingdanbillid,storeid,state,outtype,totalmoney");
		$dingdanbillid=$stockoutinfo['dingdanbillid'];
		$storeid=$stockoutinfo['storeid'];
		$state=$stockoutinfo['state'];
		$outtype=$stockoutinfo['outtype'];
		$totalmoney=$stockoutinfo['totalmoney'];
		
		if($state=='已出库')
		{
			//删除发货单
			$sql = "select * from fahuodan where billid=".$chukubillid;
			$rs = $this->db->Execute($sql);
			$rs_a = $rs->GetArray();
			if(count($rs_a)>0)
			{
				if($rs_a[0]['state']=='已发货')
					throw new Exception("出库单：".$chukubillid." 已发货，请先撤销发货单！");
				$sql = "delete from fahuodan where billid=".$chukubillid;
				$this->db->Execute($sql);
			}
			//撤销出库
			$sql = "select * from stockoutmain_detail where mainrowid=".$chukubillid;
			$rs = $this->db->Execute($sql);
			$rs_detail = $rs->GetArray();
			for($j=0;$j<sizeof($rs_detail);$j++)
			{

				$tmpArray=$this->utility->returntablefield("product","productid",$rs_detail[$j]['prodid'],"ifkucun,hascolor");
				$ifkucun=$tmpArray['ifkucun'];
				$hascolor=$tmpArray['hascolor'];
				if($ifkucun=="是")
				{
					$sql = "select * from store where storeid=".$storeid." and prodid='".$rs_detail[$j]['prodid']."'";
					$rs = $this->db->Execute($sql);
					$rs_store = $rs->GetArray();
					$kucun=0;
					if(sizeof($rs_store)>0)
					{
						$kucun=$rs_store[0]['num'];
						//if($kucun+$rs_detail[$j]['num']<0)
						//	throw new Exception($rs_detail[$j]['prodid']." 库存不足！");
						if($kucun+$rs_detail[$j]['num']!=0)
							$junjia=round(($rs_store[0]['price']*$kucun+$rs_detail[$j]['avgprice']*$rs_detail[$j]['num'])/($kucun+$rs_detail[$j]['num']),2);
						else
						{
							if(round($rs_store[0]['price']*$kucun+$rs_detail[$j]['avgprice']*$rs_detail[$j]['num'],0)==0)
								$junjia=0;
							else
								throw new Exception("编号为：".$rs_detail[$j]['prodid']." 的产品撤销后库存数量为零，但金额不为零，无法计算加权平均价");
						}
						if($junjia<0)
									throw new Exception("编号为：".$rs_detail[$j]['prodid']." 的产品加权平均价不能为负值，请先做报溢单");
						$sql = "update store set num=num+(".$rs_detail[$j]['num']."),price=".$junjia." where storeid=".$storeid." and prodid='".$rs_detail[$j]['prodid']."'";
						$this->db->Execute($sql);
					}	
					else 
					{
						
						$chengben=$rs_detail[$j]['avgprice'];
						$maxid=$this->utility->returnAutoIncrement("id", "store");
						$sql="insert into store (id,prodid,num,price,storeid) values($maxid,'".$rs_detail[$j]['prodid']."',".$rs_detail[$j]['num'].",".$chengben.",".$storeid.")";
						$this->db->Execute($sql);
						$rs_store[0]['id']=$maxid;
					}
					if($hascolor=="是")
					{
						$sql="select * from stockoutmain_detail_color where id=".$rs_detail[$j]['id'];
						$rs = $this->db->Execute($sql);
						$rs_color = $rs->GetArray();
						foreach ($rs_color as $row)
						{
							
							$sql="select num from store_color where id=".$rs_store[0]['id']." and color=".$row['color'];
							$rs = $this->db->Execute($sql);
							$rs_store_color = $rs->GetArray();
							if(sizeof($rs_store_color)==0)
							{
								$sql="insert store_color (id,color,num) values(".$rs_store[0]['id'].",".$row['color'].",".$row['num'].")";
							}
							else 
							{
								$sql = "update store_color set num=num+(".$row['num'].") where id=".$rs_store[0]['id']." and color='".$row['color']."'";
							}
							$this->db->Execute($sql);
						}
					}
					
				}
				if($outtype=='销售出库')
				{
					//更新订单明细
					$sql="update sellplanmain_detail set chukunum=chukunum-(".$rs_detail[$j]['num']."),lirun=lirun-(".$rs_detail[$j]['lirun'].") where mainrowid=$dingdanbillid and prodid='".$rs_detail[$j]['prodid']."' and opertype=".$rs_detail[$j]['opertype'];
					$this->db->Execute($sql);
				}
			}
			//$sql="delete from store where num=0";
			//$this->db->Execute($sql);
			
		}
		$sql = "delete from stockoutmain where billid=".$chukubillid;
		$this->db->Execute($sql);
		if($outtype=='销售出库')
			$this->updatesellplanmainfahuo($dingdanbillid);
		else if($outtype=='返厂出库')
			$this->UpdateCaigouState($dingdanbillid);
		else if($outtype=='盘点出库')
		{
			$kind=-1;
			$feiyongname='盘点亏损';
			$jine=-$totalmoney;
			$feiyongtype=$this->utility->returntablefield("feiyongtype", "typename", $feiyongname, "id");
			$sql="insert into feiyongrecord (typeid,jine,accountid,chanshengdate,createman,createtime,kind,beizhu) values($feiyongtype,$jine,'','".date("Y-m-d")."','".$_SESSION['LOGIN_USER_ID']."','".date("Y-m-d H:i:s")."',$kind,'盘点单-$dingdanbillid')";
			$this->db->Execute($sql);
			
			$state=$this->utility->returntablefield("stockinmain","caigoubillid", $dingdanbillid,"state","intype","盘点入库");
			$newState="等待出入库确认";
			if($state=="" || $state=="等待出入库确认")
				$newState="已录明细";
			
			$sql="update storecheck set state='$newState' where billid=$dingdanbillid";
			$this->db->Execute($sql);	
			
		}
		else if($outtype=='调拨出库')
		{	

			$sql="update stockchangemain set outstoreshenhe='',outshenhetime='' where billid=$dingdanbillid";
			$this->db->Execute($sql);
			$sql="update stockchangemain set state='3'  where instoreshenhe='' and outstoreshenhe<>'' and  billid=$dingdanbillid";
				$this->db->Execute($sql);
				$sql="update stockchangemain set state='2'  where instoreshenhe='' and outstoreshenhe='' and  billid=$dingdanbillid";
				$this->db->Execute($sql);
		}
		else if($outtype=='组装出库')
		{
			$sql="update productzuzhuang set outstoreshenhe='',outshenhetime='' where billid=$dingdanbillid";
			$this->db->Execute($sql);
			
				$sql="update productzuzhuang set state='1'  where instoreshenhe='' and outstoreshenhe='' and  billid=$dingdanbillid";
				$this->db->Execute($sql);
		}
	}
	//确认出库
	function confirmChuKu($chukubillid)
	{
		$stockoutinfo=$this->utility->returntablefield("stockoutmain","billid",$chukubillid,"dingdanbillid,storeid,state,outtype");
		$dingdanbillid=$stockoutinfo['dingdanbillid'];
		$storeid=$stockoutinfo['storeid'];
		$outtype=$stockoutinfo['outtype'];
		$sql = "select * from stockoutmain_detail where mainrowid=".$chukubillid;
		$rs = $this->db->Execute($sql);
		$rs_detail = $rs->GetArray();
		for($i=0;$i<sizeof($rs_detail);$i++)
		{
			if($outtype=='销售出库')
				$num=$_POST["recnum_".$rs_detail[$i]['id']];
			else 
				$num=$rs_detail[$i]['num'];
			
			if( $num>$rs_detail[$i]['num'])
				throw  new Exception("产品【".$rs_detail[$i]['prodid']."】的出库数不能大于".$rs_detail[$i]['num']);
			
			
			//扣减库存
			$tmpArray=$this->utility->returntablefield("product","productid",$rs_detail[$i]['prodid'],"ifkucun,hascolor");
			$ifkucun=$tmpArray['ifkucun'];
			$hascolor=$tmpArray['hascolor'];
			if($ifkucun=="是" && $num!=0)
			{
				$sql = "select * from store where storeid=".$storeid." and prodid='".$rs_detail[$i]['prodid']."'";
				$rs = $this->db->Execute($sql);
				$rs_store = $rs->GetArray();
				
				if(sizeof($rs_store)==0)
				{
					$maxid=$this->utility->returnAutoIncrement("id", "store");
					$sql = "insert into store (id,prodid,storeid,num,price) values($maxid,'".
					$rs_detail[$i]['prodid']."',".$storeid.",-".$rs_detail[$i]['num'].",".$rs_detail[$i]['price'].")";
					$rs_store[0]['id']=$maxid;
					$chengben=$rs_detail[$i]['price'];
				}
				else
				{
					$chengben=$rs_store[0]['price'];
					$sql = "update store set num=num-(".$num.") where storeid=".$storeid." and prodid='".$rs_detail[$i]['prodid']."'";
	
				}
				$this->db->Execute($sql);

				
				if($hascolor=="是")
				{
					$sql="select * from stockoutmain_detail_color where id=".$rs_detail[$i]['id'];
					$rs = $this->db->Execute($sql);
					$rs_color = $rs->GetArray();
					foreach ($rs_color as $row)
					{
						$kucun=$this->utility->returntablefield("store_color", "id", $rs_store[0]['id'], "num","color",$row['color']);
					
						if($kucun=='')
							$sql="insert into store_color values(".$rs_store[0]['id'].",".$row['color'].",-".$row['num'].")";
						else 
							$sql = "update store_color set num=num-(".$row['num'].") where id=".$rs_store[0]['id']." and color='".$row['color']."'";
						$this->db->Execute($sql);
	
					}
				}
			}
			else
				$chengben=0;
			//更新出库明细
			if($num!=0)
				$sql = "update stockoutmain_detail set num=$num,avgprice=$chengben,lirun=round((price*zhekou-$chengben)*$num,2),jine=round((price*zhekou)*$num,2) where id=".$rs_detail[$i]['id'];
			else
				$sql = "delete from stockoutmain_detail where id=".$rs_detail[$i]['id'];
			$this->db->Execute($sql);
			
			if($outtype=='销售出库')
			{
				//取得利润
				$sql="select lirun from stockoutmain_detail where id=".$rs_detail[$i]['id'];
				$rs = $this->db->Execute($sql);
				$rs_store = $rs->GetArray();
				$lirun=0;
				if(sizeof($rs_store)>0)
					$lirun=$rs_store[0]['lirun'];
				//更新订单明细
				$sql="update sellplanmain_detail set chukunum=chukunum+$num,lirun=lirun+$lirun where mainrowid=$dingdanbillid and prodid='".$rs_detail[$i]['prodid']."' and opertype=".$rs_detail[$i]['opertype'];
				$this->db->Execute($sql);
			}
				
		}
		//$sql="delete from store where num=0";
		//$this->db->Execute($sql);

		$sql = "select sum(num) as allnum,sum(price*zhekou*num) as allmoney from stockoutmain_detail where mainrowid=".$chukubillid;
		$rs = $this->db->Execute($sql);
		$rs_all = $rs->GetArray();
		$allnum=intval($rs_all[0]['allnum']);
		$allmoney=round(floatval($rs_all[0]['allmoney']),2);
		//改变出库单状态
		$sql = "update stockoutmain set state='已出库',totalnum=$allnum,totalmoney=$allmoney,outstoreshenhe='".$_SESSION['LOGIN_USER_ID']."',outdate='".date("Y-m-d H:i:s")."' where billid=".$chukubillid;
		$this->db->Execute($sql);
		
		if($outtype=='返厂出库')
		{
			$this->UpdateCaigouState($dingdanbillid);
		}
		else if($outtype=="销售出库")
		{
			$this->updatesellplanmainfahuo($dingdanbillid);
		}
		else if($outtype=='盘点出库')
		{
			$kind=-1;
			$feiyongname='盘点亏损';
			$jine=$allmoney;
			$feiyongtype=$this->utility->returntablefield("feiyongtype", "typename", $feiyongname, "id");
			$sql="insert into feiyongrecord (typeid,jine,accountid,chanshengdate,createman,createtime,kind,beizhu) values($feiyongtype,$jine,'','".date("Y-m-d")."','".$_SESSION['LOGIN_USER_ID']."','".date("Y-m-d H:i:s")."',$kind,'盘点单-$dingdanbillid')";
			$this->db->Execute($sql);
			
			$state=$this->utility->returntablefield("stockinmain","caigoubillid", $dingdanbillid,"state","intype","盘点入库");
			if($state=="" || $state=="已入库")
			{
				$sql="update storecheck set state='盘点结束' where billid=$dingdanbillid";
				$this->db->Execute($sql);
			}
			
		}
		else if($outtype=='调拨出库')
		{
			$sql="update stockchangemain set state='3',outstoreshenhe='".$_SESSION['LOGIN_USER_ID']."',outshenhetime='".date("Y-m-d H:i:s")."' where billid=$dingdanbillid";
			$this->db->Execute($sql);
		}
		else if($outtype=='组装出库')
		{
			$sql="update productzuzhuang set state='2',outstoreshenhe='".$_SESSION['LOGIN_USER_ID']."',outshenhetime='".date("Y-m-d H:i:s")."' where billid=$dingdanbillid";
			$this->db->Execute($sql);
		}
	}
	
	//合同交付
	function HeTongJiaoFu($customerid,$hetongid,$productid,$id,$num,$price,$jieshouren,$jiaofudate,$beizhu,$jine)
	{
		$sql="select num-chukunum as maxnum from sellplanmain_detail where id=$id";
		$rs=$this->db->Execute($sql);
		$rs_a=$rs->GetArray();
		if($num>$rs_a[0]['maxnum'])
			throw new Exception("本次交付数不能大于".$rs_a[0]['maxnum']);
		$sql="select max(id) as maxid from sellcontract_jiaofu";
		$rs=$this->db->Execute($sql);
		$rs_a=$rs->GetArray();
		$maxid=$rs_a[0]['maxid']+1;
		$sql="insert into sellcontract_jiaofu (id,customerid,hetongid,productid,planid,num,price,jieshouren,jiaofudate,beizhu,createman,createtime,jine)
		values($maxid,$customerid,$hetongid,'$productid',$id,$num,$price,'$jieshouren','$jiaofudate','$beizhu','".$_SESSION['LOGIN_USER_ID']."','".date('Y-m-d H:i:s')."',$jine)";
		$rs=$this->db->Execute($sql);
		$sql="update sellplanmain_detail set chukunum=chukunum+$num where id=$id";
		$rs=$this->db->Execute($sql);

		$this->updatehetongfahuo($hetongid);
	}
	//删除合同交付
	function deleteHeTongJiaoFu($selectid)
	{
		$planid=$this->utility->returntablefield("sellcontract_jiaofu", "id", $selectid, "planid");
		$sql="delete from sellcontract_jiaofu where id=$selectid";
		$rs=$this->db->Execute($sql);
		$sql="select sum(num) as allnum from sellcontract_jiaofu where planid=$planid";
		$rs=$this->db->Execute($sql);
		$rs_a = $rs->GetArray();
		$num=$rs_a[0]['allnum'];
		$sql="update sellplanmain_detail set chukunum='$num' where id=$planid";
		$rs=$this->db->Execute($sql);
		$hetongid=$this->utility->returntablefield("sellplanmain_detail", "id", $planid, "mainrowid");

		$this->updatehetongfahuo($hetongid);
	}
	//更新合同的交付状态
	function updatehetongfahuo($dingdanid)
	{
		$sql="select sum(jine) as jine from sellcontract_jiaofu where hetongid=$dingdanid";
		$rs=$this->db->Execute($sql);
		$rs_a = $rs->GetArray();
		$jine=floatvalue($rs_a[0]['jine']);
		$sql="update sellplanmain set fahuojine=$jine where billid=$dingdanid";
		$rs=$this->db->Execute($sql);

		$sellplaninfo=$this->utility->returntablefield("sellplanmain", "billid", $dingdanid, "fahuostate,totalmoney,ifpay,fahuojine,kaipiaostate,user_flag");
		$fahuostate=$sellplaninfo['fahuostate'];
		$ifpay=$sellplaninfo['ifpay'];
		$kaipiaostate=$sellplaninfo['kaipiaostate'];
		$fahuojine=$sellplaninfo['fahuojine'];
		$totalmoney=$sellplaninfo['totalmoney'];
		$user_flag=$sellplaninfo['user_flag'];
		if($totalmoney==$fahuojine)
		$fahuostate=4;	//发货状态=全部
		else if($totalmoney>$fahuojine)
		{
			if($fahuojine>0)
			$fahuostate=3;	//发货状态=部分
			else
			$fahuostate=0;  //发货状态=需发货
				
		}
		if($ifpay==2 && $fahuostate==4) //订单状态=完成
		$user_flag=2;
		else if($ifpay==0 && $fahuostate==0 && $kaipiaostate<=2) //订单状态=临时单
		$user_flag=0;
		else								//订单状态=执行中
		$user_flag=1;
		$sql="update sellplanmain set fahuostate=$fahuostate,user_flag=$user_flag where billid=$dingdanid";
		$this->db->Execute($sql);

	}
//生成组装出库单
	function newZuZhuangChuKu($rowid)
	{
		$outstoreid = $this->utility->returntablefield("stockchangemain","billid",$rowid,"outstoreid");
		
		$sql = "select * from productzuzhuang_detail where mainrowid=".$rowid;
		$rs = $this->db->Execute($sql);
		$rs_detail = $rs->GetArray();
		
		$chukuBillId=0;
		
		$createman=$_SESSION['LOGIN_USER_ID'];
		for($i=0;$i<sizeof($rs_detail);$i++)
		{
				
				if($chukuBillId==0)//新建调拨出库单
				{
					$chukuBillId = $this->utility->returnAutoIncrement("billid","stockoutmain");
					$sql = "insert into stockoutmain (billid,zhuti,storeid,createman,createtime,dingdanbillid,state,outtype) values(".
					$chukuBillId.",'组装单-$rowid',".$outstoreid.",'".$createman."','".date("Y-m-d H:i:s")."',"
					.$rowid.",'未出库','组装出库')";
					$this->db->Execute($sql);
				}
			
				$maxid2 = $this->utility->returnAutoIncrement("id","stockoutmain_detail");
				$sql = "insert into stockoutmain_detail (id,prodid,prodname,prodguige,prodxinghao,proddanwei,price,zhekou,num,mainrowid,jine,opertype) values('$maxid2','".
					$rs_detail[$i]['prodid']."','".$rs_detail[$i]['prodname']."','".$rs_detail[$i]['prodguige']."','".$rs_detail[$i]['prodxinghao'].
		    		"','".$rs_detail[$i]['proddanwei']."',".$rs_detail[$i]['price'].",".$rs_detail[$i]['zhekou'].",".$rs_detail[$i]['num'].",".$chukuBillId.",".$rs_detail[$i]['jine'].",1)";
				$this->db->Execute($sql);
			
			$hascolor=$this->utility->returntablefield("product","productid", $rs_detail[$i]['prodid'], "hascolor");
			if($hascolor=="是")
			{
				$sql="select * from productzuzhuang_detail_color where id=".$rs_detail[$i]['id'];
				$rs = $this->db->Execute($sql);
				$rs_color = $rs->GetArray();
				foreach ($rs_color as $row)
				{

						$sql="insert into stockoutmain_detail_color values($maxid2,".$row['color'].",".$row['num'].")";
						$this->db->Execute($sql);
					
				}
			}

		}
				
		$sql="update productzuzhuang set state='4' where billid=".$rowid;
		$this->db->Execute($sql);
		
		if($chukuBillId)
		{
			$sql="select sum(num) as allnum,sum(price*zhekou*num) as allmoney from stockoutmain_detail where mainrowid=$chukuBillId";
			$rs=$this->db->Execute($sql);
			$rs_a=$rs->GetArray();
			$allnum=$rs_a[0]['allnum'];
			$allmoney=$rs_a[0]['allmoney'];
			$sql="update stockoutmain set totalnum=$allnum,totalmoney=$allmoney where billid=$chukuBillId";
			$this->db->Execute($sql);
		}
	}
//生成组装入库单
	function newZuZhuangRuKu($rowid)
	{
		$instoreid = $this->utility->returntablefield("productzuzhuang","billid",$rowid,"instoreid");
		
		$sql = "select * from productzuzhuang2_detail where mainrowid=".$rowid;
		$rs = $this->db->Execute($sql);
		$rs_detail = $rs->GetArray();
		$rukuBillId=0;
		
		$createman=$_SESSION['LOGIN_USER_ID'];
		for($i=0;$i<sizeof($rs_detail);$i++)
		{
			
				if($rukuBillId==0)//新建调拨入库单
				{
					$rukuBillId = $this->utility->returnAutoIncrement("billid","stockinmain");
					$sql = "insert into stockinmain(billid,zhuti,storeid,createman,createtime,caigoubillid,state,intype) values(".
					$rukuBillId.",'组装单-$rowid',".$instoreid.",'".$createman."','".date("Y-m-d H:i:s")."',"
					.$rowid.",'未入库','组装入库')";
					$this->db->Execute($sql);
				}
				
				$maxid1 = $this->utility->returnAutoIncrement("id","stockinmain_detail");
				$sql = "insert into stockinmain_detail (id,prodid,prodname,prodguige,prodxinghao,proddanwei,price,zhekou,num,mainrowid,jine) values('$maxid1','".
					$rs_detail[$i]['prodid']."','".$rs_detail[$i]['prodname']."','".$rs_detail[$i]['prodguige']."','".$rs_detail[$i]['prodxinghao'].
		    		"','".$rs_detail[$i]['proddanwei']."',".$rs_detail[$i]['price'].",".$rs_detail[$i]['zhekou'].",".$rs_detail[$i]['num'].",".$rukuBillId.",".$rs_detail[$i]['jine'].")";
				$this->db->Execute($sql);
			
			
			$hascolor=$this->utility->returntablefield("product","productid", $rs_detail[$i]['prodid'], "hascolor");
			if($hascolor=="是")
			{
				$sql="select * from productzuzhuang2_detail_color where id=".$rs_detail[$i]['id'];
				$rs = $this->db->Execute($sql);
				$rs_color = $rs->GetArray();
				foreach ($rs_color as $row)
				{
					
						$sql="insert into stockinmain_detail_color values($maxid1,".$row['color'].",".$row['num'].")";
						$this->db->Execute($sql);
					
				}
			}

		}
				
		$sql="update productzuzhuang set state='5' where billid=".$rowid;
		$this->db->Execute($sql);
		if($rukuBillId)
		{
			$sql="select sum(num) as allnum,sum(price*zhekou*num) as allmoney from stockinmain_detail where mainrowid=$rukuBillId";
			$rs=$this->db->Execute($sql);
			$rs_a=$rs->GetArray();
			$allnum=$rs_a[0]['allnum'];
			$allmoney=$rs_a[0]['allmoney'];
			$sql="update stockinmain set totalnum=$allnum,totalmoney=$allmoney where billid=$rukuBillId";
			$this->db->Execute($sql);
		}
		
	}
//生成调拨入库单
	function newDiaoBoRuKu($rowid)
	{
		$outstoreid = $this->utility->returntablefield("stockchangemain","billid",$rowid,"outstoreid");
		$instoreid = $this->utility->returntablefield("stockchangemain","billid",$rowid,"instoreid");
		
		$sql = "select * from stockchangemain_detail where mainrowid=".$rowid;
		$rs = $this->db->Execute($sql);
		$rs_detail = $rs->GetArray();
		$rukuBillId=0;
		$chukuBillId=0;
		
		$createman=$_SESSION['LOGIN_USER_ID'];
		for($i=0;$i<sizeof($rs_detail);$i++)
		{
			
				if($rukuBillId==0)//新建调拨入库单
				{
					$rukuBillId = $this->utility->returnAutoIncrement("billid","stockinmain");
					$sql = "insert into stockinmain(billid,zhuti,storeid,createman,createtime,caigoubillid,state,intype) values(".
					$rukuBillId.",'调拨单-$rowid',".$instoreid.",'".$createman."','".date("Y-m-d H:i:s")."',"
					.$rowid.",'未入库','调拨入库')";
					$this->db->Execute($sql);
				}
				
				$maxid1 = $this->utility->returnAutoIncrement("id","stockinmain_detail");
				$sql = "insert into stockinmain_detail (id,prodid,prodname,prodguige,prodxinghao,proddanwei,price,zhekou,num,mainrowid,jine) values('$maxid1','".
					$rs_detail[$i]['prodid']."','".$rs_detail[$i]['prodname']."','".$rs_detail[$i]['prodguige']."','".$rs_detail[$i]['prodxinghao'].
		    		"','".$rs_detail[$i]['proddanwei']."',".$rs_detail[$i]['price'].",".$rs_detail[$i]['zhekou'].",".$rs_detail[$i]['num'].",".$rukuBillId.",".$rs_detail[$i]['jine'].")";
				$this->db->Execute($sql);
			
			
				if($chukuBillId==0)//新建调拨出库单
				{
					$chukuBillId = $this->utility->returnAutoIncrement("billid","stockoutmain");
					$sql = "insert into stockoutmain (billid,zhuti,storeid,createman,createtime,dingdanbillid,state,outtype) values(".
					$chukuBillId.",'调拨单-$rowid',".$outstoreid.",'".$createman."','".date("Y-m-d H:i:s")."',"
					.$rowid.",'未出库','调拨出库')";
					$this->db->Execute($sql);
				}
			
				$maxid2 = $this->utility->returnAutoIncrement("id","stockoutmain_detail");
				$sql = "insert into stockoutmain_detail (id,prodid,prodname,prodguige,prodxinghao,proddanwei,price,zhekou,num,mainrowid,jine,opertype) values('$maxid2','".
					$rs_detail[$i]['prodid']."','".$rs_detail[$i]['prodname']."','".$rs_detail[$i]['prodguige']."','".$rs_detail[$i]['prodxinghao'].
		    		"','".$rs_detail[$i]['proddanwei']."',".$rs_detail[$i]['price'].",".$rs_detail[$i]['zhekou'].",".$rs_detail[$i]['num'].",".$chukuBillId.",".$rs_detail[$i]['jine'].",1)";
				$this->db->Execute($sql);
			
			
			$hascolor=$this->utility->returntablefield("product","productid", $rs_detail[$i]['prodid'], "hascolor");
			if($hascolor=="是")
			{
				$sql="select * from stockchangemain_detail_color where id=".$rs_detail[$i]['id'];
				$rs = $this->db->Execute($sql);
				$rs_color = $rs->GetArray();
				foreach ($rs_color as $row)
				{
					
					
						$sql="insert into stockinmain_detail_color values($maxid1,".$row['color'].",".$row['num'].")";
						$this->db->Execute($sql);
					
						$sql="insert into stockoutmain_detail_color values($maxid2,".$row['color'].",".$row['num'].")";
						$this->db->Execute($sql);
					
				}
			}

		}
				
		$sql="update stockchangemain set state='5' where billid=".$rowid;
		$this->db->Execute($sql);
		if($rukuBillId)
		{
			$sql="select sum(num) as allnum,sum(price*zhekou*num) as allmoney from stockinmain_detail where mainrowid=$rukuBillId";
			$rs=$this->db->Execute($sql);
			$rs_a=$rs->GetArray();
			$allnum=$rs_a[0]['allnum'];
			$allmoney=$rs_a[0]['allmoney'];
			$sql="update stockinmain set totalnum=$allnum,totalmoney=$allmoney where billid=$rukuBillId";
			$this->db->Execute($sql);
		}
		if($chukuBillId)
		{
			$sql="select sum(num) as allnum,sum(price*zhekou*num) as allmoney from stockoutmain_detail where mainrowid=$chukuBillId";
			$rs=$this->db->Execute($sql);
			$rs_a=$rs->GetArray();
			$allnum=$rs_a[0]['allnum'];
			$allmoney=$rs_a[0]['allmoney'];
			$sql="update stockoutmain set totalnum=$allnum,totalmoney=$allmoney where billid=$chukuBillId";
			$this->db->Execute($sql);
		}
	}
	//删除调拨单
	function deleteDiaoBo($selectid)
	{

		$sql = "delete from stockinmain where intype='调拨入库' and caigoubillid=".$selectid;
		$this->db->Execute($sql);
		$sql = "delete from stockoutmain where outtype='调拨出库' and dingdanbillid=".$selectid;
		$this->db->Execute($sql);
		$sql = "delete from stockchangemain where billid=".$selectid;
		$this->db->Execute($sql);
	}
	//新增盘点单
	function insertStoreCheck($rowid)
	{
		$storeid = $this->utility->returntablefield("storecheck","billid",$rowid,"storeid");
		$sql = "select * from storecheck_detail where mainrowid=".$rowid;
		$rs = $this->db->Execute($sql);
		$rs_detail = $rs->GetArray();
		$rukuBillId=0;
		$chukuBillId=0;
		
		$createman=$_SESSION['LOGIN_USER_ID'];
		for($i=0;$i<sizeof($rs_detail);$i++)
		{
			if($rs_detail[$i]['num']>0)
			{
				if($rukuBillId==0)//新建盘点入库单
				{
					$rukuBillId = $this->utility->returnAutoIncrement("billid","stockinmain");
					$sql = "insert into stockinmain(billid,zhuti,storeid,createman,createtime,caigoubillid,state,intype) values(".
					$rukuBillId.",'盘盈单-$rowid',".$storeid.",'".$createman."','".date("Y-m-d H:i:s")."',"
					.$rowid.",'未入库','盘点入库')";
					$this->db->Execute($sql);
				}
				
				$maxid = $this->utility->returnAutoIncrement("id","stockinmain_detail");
				$sql = "insert into stockinmain_detail (id,prodid,prodname,prodguige,prodxinghao,proddanwei,price,zhekou,num,mainrowid,jine) values('$maxid','".
					$rs_detail[$i]['prodid']."','".$rs_detail[$i]['prodname']."','".$rs_detail[$i]['prodguige']."','".$rs_detail[$i]['prodxinghao'].
		    		"','".$rs_detail[$i]['proddanwei']."',".$rs_detail[$i]['price'].",".$rs_detail[$i]['zhekou'].",".$rs_detail[$i]['num'].",".$rukuBillId.",".$rs_detail[$i]['jine'].")";
				$this->db->Execute($sql);
			}
			else if($rs_detail[$i]['num']<0)
			{
				if($chukuBillId==0)//新建盘点出库单
				{
					$chukuBillId = $this->utility->returnAutoIncrement("billid","stockoutmain");
					$sql = "insert into stockoutmain (billid,zhuti,storeid,createman,createtime,dingdanbillid,state,outtype) values(".
					$chukuBillId.",'盘亏单-$rowid',".$storeid.",'".$createman."','".date("Y-m-d H:i:s")."',"
					.$rowid.",'未出库','盘点出库')";
					$this->db->Execute($sql);
				}
			
				$maxid = $this->utility->returnAutoIncrement("id","stockoutmain_detail");
				$sql = "insert into stockoutmain_detail (id,prodid,prodname,prodguige,prodxinghao,proddanwei,price,zhekou,num,mainrowid,jine,opertype) values('$maxid','".
					$rs_detail[$i]['prodid']."','".$rs_detail[$i]['prodname']."','".$rs_detail[$i]['prodguige']."','".$rs_detail[$i]['prodxinghao'].
		    		"','".$rs_detail[$i]['proddanwei']."',".$rs_detail[$i]['price'].",".$rs_detail[$i]['zhekou'].",".-$rs_detail[$i]['num'].",".$chukuBillId.",".-$rs_detail[$i]['jine'].",1)";
				$this->db->Execute($sql);
			}
			
			$hascolor=$this->utility->returntablefield("product","productid", $rs_detail[$i]['prodid'], "hascolor");
			if($hascolor=="是")
			{
				$sql="select * from storecheck_detail_color where id=".$rs_detail[$i]['id'];
				$rs = $this->db->Execute($sql);
				$rs_color = $rs->GetArray();
				foreach ($rs_color as $row)
				{
					
					if($row[num]>0)//采购入库明细颜色
					{
						$sql="insert into stockinmain_detail_color values($maxid,".$row['color'].",".$row['num'].")";
							$this->db->Execute($sql);
					}
					else 
					{
						$sql="insert into stockoutmain_detail_color values($maxid,".$row['color'].",".-$row['num'].")";
							$this->db->Execute($sql);
					}
				}
			}

		}
				
		$sql="update storecheck set state='等待出入库确认' where billid=".$rowid;
		$this->db->Execute($sql);
		if($rukuBillId)
		{
			$sql="select sum(num) as allnum,sum(price*zhekou*num) as allmoney from stockinmain_detail where mainrowid=$rukuBillId";
			$rs=$this->db->Execute($sql);
			$rs_a=$rs->GetArray();
			$allnum=$rs_a[0]['allnum'];
			$allmoney=$rs_a[0]['allmoney'];
			$sql="update stockinmain set totalnum=$allnum,totalmoney=$allmoney where billid=$rukuBillId";
			$this->db->Execute($sql);
		}
		if($chukuBillId)
		{
			$sql="select sum(num) as allnum,sum(price*zhekou*num) as allmoney from stockoutmain_detail where mainrowid=$chukuBillId";
			$rs=$this->db->Execute($sql);
			$rs_a=$rs->GetArray();
			$allnum=$rs_a[0]['allnum'];
			$allmoney=$rs_a[0]['allmoney'];
			$sql="update stockoutmain set totalnum=$allnum,totalmoney=$allmoney where billid=$chukuBillId";
			$this->db->Execute($sql);
		}
	}
	//删除盘点单
	function deleteStoreCheck($selectid)
	{
		$storeid = $this->utility->returntablefield("storecheck","billid",$selectid,"storeid");
		$state=$this->utility->returntablefield("storecheck","billid",$selectid,"state");

		if($state=='盘点结束')
		{
			//撤销库存
			$sql = "select * from storecheck_detail where mainrowid=".$selectid;
			$rs = $this->db->Execute($sql);
			$rs_detail = $rs->GetArray();
			for($j=0;$j<sizeof($rs_detail);$j++)
			{

				$sql = "select * from store where storeid=".$storeid." and prodid='".$rs_detail[$j]['prodid']."'";
				$rs = $this->db->Execute($sql);
				$rs_store = $rs->GetArray();
				$kucun=0;
				$maxid=0;
				if(sizeof($rs_store)>0)
				{
					$kucun=$rs_store[0]['num'];
					$maxid=$rs_store[0]['id'];
				}
				if($kucun-$rs_detail[$j]['num']<0)
				throw new Exception("编号为：".$rs_detail[$j]['prodid']." 的产品库存不足");


				if($kucun-$rs_detail[$j]['num']!=0)
				$junjia=round(($rs_store[0]['price']*$kucun-$rs_detail[$j]['price']*$rs_detail[$j]['num'])/($kucun-$rs_detail[$j]['num']),2);
				else
				{
					if(round($rs_store[0]['price']*$kucun-$rs_detail[$j]['price']*$rs_detail[$j]['num'],0)==0)
					$junjia=0;
					else
					throw new Exception("编号为：".$rs_detail[$j]['prodid']." 的产品撤销后库存数量为零，但金额不为零，无法计算加权平均价");
				}
					
				$sql = "update store set num=num-(".$rs_detail[$j]['num']."),price=".$junjia." where storeid=".$storeid." and prodid='".$rs_detail[$j]['prodid']."'";
				$this->db->Execute($sql);
				//颜色处理
				$sql = "select * from storecheck_detail_color where id=".$rs_detail[$j]['id'];
				$rs = $this->db->Execute($sql);
				$rs_b = $rs->GetArray();
				for($m=0;$m<sizeof($rs_b);$m++)
				{
					$sql = "select * from store_color where id=$maxid and color=".$rs_b[$m]['color'];
					$rs = $this->db->Execute($sql);
					$rs_c = $rs->GetArray();
					if(sizeof($rs_c)>0)
						$sql="update store_color set num=num-(".$rs_b[$m]['num'].") where id=$maxid and color=".$rs_b[$m]['color'];
					else 
						$sql="insert store_color values($maxid,".$rs_b[$m]['color'].",-".$rs_b[$m]['num'].")";
					$this->db->Execute($sql);
				}
				//print $sql;exit;

			}
			//$sql="delete from store where num=0";
			//$this->db->Execute($sql);
		}
		//删除盘点单
		$sql = "delete from stockinmain where intype='盘点入库' and caigoubillid=".$selectid;
		$this->db->Execute($sql);
		$sql = "delete from stockoutmain where outtype='盘点出库' and dingdanbillid=".$selectid;
		$this->db->Execute($sql);
		$sql = "delete from storecheck where billid=".$selectid;
		$this->db->Execute($sql);
	}
	//更新出库数量
	function updateStockoutAmount($id,$recnum)
	{
		$sql="update stockoutmain_detail set num=$recnum where id=$id";
		$this->db->Execute($sql);
	}
	
}

?>