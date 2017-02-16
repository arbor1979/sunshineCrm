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
	//����������
	function insertFaHuo($chukubillid)
	{
		$stockinfo=$this->utility->returntablefield("stockoutmain", "billid", $chukubillid, "dingdanbillid,totalnum,totalmoney,outtype");
		$dingdanid=$stockinfo['dingdanbillid'];
		$totalnum=$stockinfo['totalnum'];
		$totalmoney=$stockinfo['totalmoney'];
		$outtype=$stockinfo['outtype'];
		if($outtype==$this->changeChar("���۳���"))
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
		else if($outtype==$this->changeChar("��������"))
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
			throw  new Exception($this->changeChar("��Ӧ�ķ������Ѵ���"));
		$sql="insert into fahuodan (billid,customerid,dingdanbillid,shouhuoren,tel,address,state,totalnum,totalmoney,outtype) values("
		.$chukubillid.",".$customerid.",".$dingdanid.",'".$shouhuoren."','".$mobile."','".$address."','".$this->changeChar('δ����')."',$totalnum,$totalmoney,'$outtype')";
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
		if($outtype==$this->changeChar("���۳���"))
			$this->updatesellplanmainfahuo($dingdanid);

	}
	//ȷ�Ϸ�����
	function confirmFaHuo($billid,$fahuodan,$shouhuoren,$address,$tel,$mailcode,$fahuotype,$package,$weight,$yunfei,$jiesuantype,$beizhu)
	{
		//���·�����
		$sql="update fahuodan set fahuodan='".$fahuodan."',shouhuoren='".$shouhuoren."',address='".$address."',tel='".$tel."',mailcode='".$mailcode.
		"',fahuotype='".$fahuotype."',package=".$package.",weight=".$weight.",yunfei=".$yunfei.",jiesuantype=".$jiesuantype.",beizhu='".$beizhu.
		"',fahuoren='".$_SESSION['LOGIN_USER_ID']."',fahuodate='".date("Y-m-d H:i:s")."',state='".$this->changeChar('�ѷ���')."' where billid=".$billid;
		$this->db->Execute($sql);
		//���³��ⵥ״̬
		$sql="update stockoutmain set state='".$this->changeChar('�ѷ���')."' where billid=".$billid;
		$this->db->Execute($sql);
		
		//���¶����������
		$outtype=$this->utility->returntablefield("fahuodan", "billid", $billid, "outtype");
		if($outtype==$this->changeChar("���۳���"))
		{
			$dingdanid=$this->utility->returntablefield("stockoutmain", "billid", $billid, "dingdanbillid");
			$jine=$this->utility->returntablefield("stockoutmain", "billid", $billid, "totalmoney");
			$sql="update sellplanmain set fahuojine=fahuojine+".$jine." where billid=".$dingdanid;
			$this->db->Execute($sql);
			$this->updatesellplanmainfahuo($dingdanid);
		}
		return $dingdanid;
	}
	//����������
	function cancelFaHuo($billid)
	{
		$outinfo=$this->utility->returntablefield("stockoutmain", "billid",$billid,"totalmoney,outtype");
		$jine=$outinfo['totalmoney'];
		$outtype=$outinfo['outtype'];
		//������
		$sql="update fahuodan set state='".$this->changeChar('δ����')."' where billid=".$billid;
		$this->db->Execute($sql);
		//���³��ⵥ״̬
		$sql="update stockoutmain set state='".$this->changeChar('�ѳ���')."' where billid=".$billid;
		$this->db->Execute($sql);
		$dingdanid=$this->utility->returntablefield("stockoutmain", "billid", $billid, "dingdanbillid");
		//���¶����������
		if($outtype==$this->changeChar('���۳���'))
		{
			$sql="update sellplanmain set fahuojine=round(fahuojine-".$jine.",2) where billid=".$dingdanid;
			$this->db->Execute($sql);
			$this->updatesellplanmainfahuo($dingdanid);
		}
	}
	//���¶�����ķ���״̬
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
					$fahuostate=4;	//����״̬=ȫ��
				else //�˵�����Ҫ����
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
				$billid=$this->utility->returntablefield("stockoutmain", "dingdanbillid", $dingdanid, "billid","state",$this->changeChar("δ����"));
				if($billid!='')
					$fahuostate=1;//����״̬=������
				else 
				{
					$billid=$this->utility->returntablefield("fahuodan", "dingdanbillid", $dingdanid, "billid","state",$this->changeChar("δ����"));
					if($billid!='')
						$fahuostate=2;//����״̬=�跢��
					else 
					{
						if($fahuojine!=0)
							$fahuostate=3;	//����״̬=����
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
	
	//�������⣬״̬Ϊ=δ����
	function insertDingDanChuKu($dingdanbillid,$storeid,$allnum,$allmoney)
	{
		$zhuti=$this->utility->returntablefield("sellplanmain", "billid", $dingdanbillid, "zhuti");
		$sql = "select * from sellplanmain_detail where chukunum<>num and num>0 and mainrowid=".$dingdanbillid;
		$rs = $this->db->Execute($sql);
		$rs_detail = $rs->GetArray();
		if(sizeof($rs_detail)>0)
		{
			//��ȡ���ⵥ��
			$billid = $this->utility->returnAutoIncrement("billid","stockoutmain");
			$stockaccess="���۳���";
			//�����³��ⵥ
			$sql = "select sum(num) as allnum,sum(jine) as alljine from sellplanmain_detail where chukunum<>num and num>0 and mainrowid=".$dingdanbillid;
			$rs = $this->db->Execute($sql);
			$rs_sum = $rs->GetArray();
			$allnum=$rs_sum[0]['allnum'];
			$allmoney=$rs_sum[0]['alljine'];
			$sql = "insert into stockoutmain (billid,zhuti,storeid,createman,createtime,dingdanbillid,state,totalnum,totalmoney,outtype) values(".
			$billid.",'".$zhuti."',".$storeid.",'".$_SESSION['LOGIN_USER_ID']."','".date("Y-m-d H:i:s")."',"
			.$dingdanbillid.",'δ����',$allnum,$allmoney,'$stockaccess')";
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
		//�˻����
		$sql = "select * from sellplanmain_detail where chukunum<>num and num<0 and mainrowid=".$dingdanbillid;
		$rs = $this->db->Execute($sql);
		$rs_detail = $rs->GetArray();
		if(sizeof($rs_detail)>0)
		{
			//��ȡ��ⵥ��
			$billid = $this->utility->returnAutoIncrement("billid","stockinmain");
			$stockaccess="�˻����";
			//��������ⵥ
			$sql = "select sum(num) as allnum,sum(jine) as alljine from sellplanmain_detail where chukunum<>num and num<0 and mainrowid=".$dingdanbillid;
			$rs = $this->db->Execute($sql);
			$rs_sum = $rs->GetArray();
			$allnum=-$rs_sum[0]['allnum'];
			$allmoney=-$rs_sum[0]['alljine'];
			$sql = "insert into stockinmain (billid,zhuti,storeid,createman,createtime,caigoubillid,state,totalnum,totalmoney,intype) values(".
			$billid.",'".$zhuti."',".$storeid.",'".$_SESSION['LOGIN_USER_ID']."','".date("Y-m-d H:i:s")."',"
			.$dingdanbillid.",'δ���',$allnum,$allmoney,'$stockaccess')";
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
	//�������⣬״̬Ϊ=δ����
	function insertDiaoboChuKu($diaoboBillid)
	{
		//��ȡ��ⵥ��
		$billid = $this->utility->returnAutoIncrement("billid","stockoutmain");
		$diaoboInfo=$this->utility->returntablefield("stockchangemain","billid", $diaoboBillid, "zhuti,outstoreid");
		$zhuti=$diaoboInfo['zhuti'];
		$sql = "select * from stockchangemain_detail where num>0 and mainrowid=".$dingdanbillid;
		$rs = $this->db->Execute($sql);
		$rs_detail = $rs->GetArray();
		$stockaccess="���۳���";
		if(sizeof($rs_detail)==0 && $allnum<0)
		{
			$stockaccess="�����˿�";
		}
		//��������ⵥ
		$sql = "insert into stockoutmain (billid,zhuti,storeid,createman,createtime,dingdanbillid,state,totalnum,totalmoney,outtype) values(".
		$billid.",'".$zhuti."',".$storeid.",'".$_SESSION['LOGIN_USER_ID']."','".date("Y-m-d H:i:s")."',"
		.$dingdanbillid.",'δ����',$allnum,$allmoney,'$stockaccess')";
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
	//�ɹ������
	function insertCaiGouRuKu($rowid,$totalnum,$totalmoney,$storeid,$yundanhao,$huoyungongsi)
	{
		$sql = "select * from buyplanmain where billid=".$rowid;
		$rs = $this->db->Execute($sql);
		$rs_a = $rs->GetArray();

		if (count($rs_a) !=1)
			throw new Exception("���Ų�����");

		$sql = "select * from buyplanmain_detail where num>0 and mainrowid=".$rowid;
		$rs = $this->db->Execute($sql);
		$rs_detail = $rs->GetArray();
		$billid='';
		for($i=0;$i<sizeof($rs_detail);$i++)
		{
			$num=$_POST["num_".$rs_detail[$i]['id']];
			//���������ϸ
			if($num!=0)
			{
				if($billid=='')
				{
					//��ȡ��ⵥ��
					$billid = $this->utility->returnAutoIncrement("billid","stockinmain");
					//��������ⵥ
					$sql = "insert into stockinmain (billid,zhuti,storeid,createman,createtime,caigoubillid,state,totalnum,totalmoney,intype,yundanhao,huoyungongsi) values(".
					$billid.",'".$rs_a[0]['zhuti']."',".$storeid.",'".$_SESSION['LOGIN_USER_ID']."','".date("Y-m-d H:i:s")."',"
					.$rowid.",'δ���',$totalnum,$totalmoney,'�ɹ����','$yundanhao','$huoyungongsi')";
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
				//������ɫ��
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
		//���±���������ͽ��
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
			//���������ϸ
			if($num!=0)
			{
				if($billid=='')
				{
					//��ȡ���ⵥ��
					$billid = $this->utility->returnAutoIncrement("billid","stockoutmain");
					//�����³��ⵥ
					$sql = "insert into stockoutmain (billid,zhuti,storeid,createman,createtime,dingdanbillid,state,totalnum,totalmoney,outtype) values(".
					$billid.",'".$rs_a[0]['zhuti']."',".$storeid.",'".$_SESSION['LOGIN_USER_ID']."','".date("Y-m-d H:i:s")."',"
					.$rowid.",'δ����',$totalnum,$totalmoney,'��������')";
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
				//������ɫ��
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
		//���±��γ������ͽ��
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
		//�ı�ɹ���״̬
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
			throw new Exception("���Ų�����");

		//�ึ���תΪԤ����
		if($paymoney+$oddment>$rukumoney)
		{
			$jine=$paymoney+$oddment-$rukumoney;
			$id = $this->utility->returnAutoIncrementUnitBillid("prepaybillid");
			$curchuzhi=floatvalue($this->utility->returntablefield("supply", "rowid", $supplyid, "yufukuan"));
			$sql="insert into accessprepay (id,supplyid,linkmanid,curchuzhi,jine,accountid,createman,createtime,opertype,beizhu)
			values(".$id.",".$supplyid.",'',".$curchuzhi.",".$jine.",'','".$_SESSION['LOGIN_USER_ID']."','".date("Y-m-d H:i:s")."','Ԥ������','�ɹ��� $rowid �ึ�Ľ��תԤ����')";
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
		
		//�ı�ɹ���״̬
		$this->updatebuyplanmainfahuo($rowid);
		$CaiWu=new CaiWu($this->db);
		$CaiWu->updatebuyplanmainfukuan($rowid);

	}
	//���²ɹ�������״̬
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
				$fahuostate=5;	//���״̬=ȫ��
			else 
			{
				$billid=$this->utility->returntablefield("stockinmain", "caigoubillid", $caigoudanid,"billid","state","�����","intype","�ɹ����");
				$billid1=$this->utility->returntablefield("stockoutmain", "dingdanbillid", $caigoudanid,"billid","state","�ѳ���","outtype","��������");
				if($billid!='' && $billid1!='')
					$fahuostate=5;
				else
				{
					$id=$this->utility->returntablefield("buyplanmain_detail", "mainrowid", $caigoudanid,"id");
					if($id!='')
						$fahuostate=2;//��¼��ϸ
					else 
						$fahuostate=1;  //��Ҫ
				}
			}
		}
		else 
		{
			$billid=$this->utility->returntablefield("stockinmain", "caigoubillid", $caigoudanid,"billid","state","δ���","intype","�ɹ����");
			$billid1=$this->utility->returntablefield("stockoutmain", "dingdanbillid", $caigoudanid,"billid","state","δ����","outtype","��������");
			
			if($rukumoney!=0 && $billid=='' && $billid1=='')
				$fahuostate=4;	//���״̬=����
			else
			{
				
				if($billid!='' || $billid1!='')
					$fahuostate=3;//�����
				else 
				{
					$id=$this->utility->returntablefield("buyplanmain_detail", "mainrowid", $caigoudanid,"id");
					if($id!='')
						$fahuostate=2;//��¼��ϸ
					else 
						$fahuostate=1;  //��Ҫ
				}
			}
				
		}

		$sql="update buyplanmain set state=$fahuostate where billid=$caigoudanid";
		$this->db->Execute($sql);
		$CaiWu=new CaiWu($this->db);
		$CaiWu->updatebuyplanmainFlag($caigoudanid);
	}

	//ȷ�����
	function confirmRuKu($rowid)
	{
		$stockinfo = $this->utility->returntablefield("stockinmain","billid",$rowid,"storeid,intype,totalmoney,state");
		if($stockinfo['state']=='�����')
			throw new Exception("�˵�����⣬�����ظ����");
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
			if($ifkucun=="��")
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
			//	throw new Exception("���Ϊ��".$rs_detail[$i]['prodid']." �Ĳ�Ʒ��治��");
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
					throw new Exception("���Ϊ��".$rs_detail[$i]['prodid']." �Ĳ�Ʒ����������Ϊ�㣬����Ϊ�㣬�޷������Ȩƽ����");
				}
				if($junjia<0)
					throw new Exception("���Ϊ��".$rs_detail[$i]['prodid']." �Ĳ�Ʒ��Ȩƽ���۲���Ϊ��ֵ�����������絥");
				$sql = "update store set num=num+(".$rs_detail[$i]['num']."),price=".$junjia." where id=$maxid";
				$this->db->Execute($sql);
			}
			//��ɫ����
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

		//������ⵥ״̬
		$sql = "update stockinmain set state='�����',indate='".date("Y-m-d H:i:s")."',instoreshenhe='".$_SESSION['LOGIN_USER_ID']."' where billid=".$rowid;
		$this->db->Execute($sql);

		
		//���²ɹ���״̬
		$caigoubillid=$this->utility->returntablefield("stockinmain","billid",$rowid,"caigoubillid");
		if($intype=='�ɹ����')
			$this->UpdateCaigouState($caigoubillid);
		else if($intype=='�˻����')
			$this->updatesellplanmainfahuo($caigoubillid);
		else if($intype=='�̵����')
		{
			$kind=1;
			$feiyongname='�̵�����';
			$jine=$totalmoney;
			$feiyongtype=$this->utility->returntablefield("feiyongtype", "typename", $feiyongname, "id");
			$sql="insert into feiyongrecord (typeid,jine,accountid,chanshengdate,createman,createtime,kind) values($feiyongtype,$jine,'','".date("Y-m-d")."','".$_SESSION['LOGIN_USER_ID']."','".date("Y-m-d H:i:s")."',$kind)";
			$this->db->Execute($sql);
			
			$state=$this->utility->returntablefield("stockoutmain","dingdanbillid", $caigoubillid,"state","outtype","�̵����");
			if($state=="" || $state=="�ѳ���")
			{
				$sql="update storecheck set state='�̵����' where billid=$caigoubillid";
				$this->db->Execute($sql);
			}
		}
		else if($intype=='�������')
		{
			$sql="update stockchangemain set state='4',instoreshenhe='".$_SESSION['LOGIN_USER_ID']."',inshenhetime='".date("Y-m-d H:i:s")."' where billid=$caigoubillid";
			$this->db->Execute($sql);
		}
		else if($intype=='��װ���')
		{
			$sql="update productzuzhuang set state='3',instoreshenhe='".$_SESSION['LOGIN_USER_ID']."',inshenhetime='".date("Y-m-d H:i:s")."' where billid=$caigoubillid";
			$this->db->Execute($sql);
		}
		//���ƿ���Ʒ���ɷ��õ�
		if($nokucunjine!=0)
		{
			$feiyongtype=$this->utility->returntablefield("feiyongtype", "typename", "���ƿ���Ʒ�ɹ���", "id");
			$sql="insert into feiyongrecord (typeid,jine,accountid,chanshengdate,createman,createtime,kind,beizhu) values($feiyongtype,$nokucunjine,1,'".date("Y-m-d")."','".$_SESSION['LOGIN_USER_ID']."','".date("Y-m-d H:i:s")."',-1,'".$intype."��:".$caigoubillid."')";
			$this->db->Execute($sql);
		}
		
	}

	//���²ɹ����������
	function UpdateCaigouState($caigoubillid)
	{
		$sql= "select sum(totalmoney) as allmoney from stockinmain where state='�����' and intype='�ɹ����' and caigoubillid=".$caigoubillid;
		$rs=$this->db->Execute($sql);
		$rs_a = $rs->GetArray();
		$ruku=$rs_a[0]['allmoney'];
		$sql= "select sum(totalmoney) as allmoney from stockoutmain where state='�ѳ���' and outtype='��������' and dingdanbillid=".$caigoubillid;
		$rs=$this->db->Execute($sql);
		$rs_a = $rs->GetArray();
		$chuku=$rs_a[0]['allmoney'];
		
		
		$sql = "update buyplanmain set rukumoney=".floatvalue($ruku-$chuku)." where billid=".$caigoubillid;
		$this->db->Execute($sql);
		//���²ɹ�����ϸ
		$sql="select * from buyplanmain_detail where mainrowid=$caigoubillid";
		$rs = $this->db->Execute($sql);
		$rs_detail = $rs->GetArray();
		for($i=0;$i<sizeof($rs_detail);$i++)
		{
			if($rs_detail[$i]['num']>0)
			{
				$sql= "select sum(a.num) as allnum from stockinmain_detail a inner join stockinmain b on a.mainrowid=b.billid where b.state='�����' and b.intype='�ɹ����' and b.caigoubillid=$caigoubillid and a.prodid='".$rs_detail[$i]['prodid']."' and opertype=".$rs_detail[$i]['opertype'];
				$rs = $this->db->Execute($sql);
				$rs_sum = $rs->GetArray();
				$recnum=$rs_sum[0]['allnum'];
			}
			else 
			{
				$sql= "select sum(a.num) as allnum from stockoutmain_detail a inner join stockoutmain b on a.mainrowid=b.billid where b.state='�ѳ���' and b.outtype='��������' and b.dingdanbillid=$caigoubillid and a.prodid='".$rs_detail[$i]['prodid']."' and opertype=".$rs_detail[$i]['opertype'];
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
			throw new Exception($rs_a[0]['prodid']."������������˲ɹ����������Ƿ��ظ����");
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
		if($rs_detail[0]['state']=='�����')
		{
			//�������
			$sql = "select * from stockinmain_detail where mainrowid=".$rukubillid;
			$rs = $this->db->Execute($sql);
			$rs_detail = $rs->GetArray();
			$nokucunjine=0;
			
			for($j=0;$j<sizeof($rs_detail);$j++)
			{
				
				$ifkucun=$this->utility->returntablefield("product","productid",$rs_detail[$j]['prodid'],"ifkucun");
				if($ifkucun=="��")
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
				//	throw new Exception("���Ϊ��".$rs_detail[$j]['prodid']." �Ĳ�Ʒ���".$kucun."����");
				
				if($kucun-$rs_detail[$j]['num']!=0)
					$junjia=round(($rs_store[0]['price']*$kucun-$rs_detail[$j]['price']*$rs_detail[$j]['zhekou']*$rs_detail[$j]['num'])/($kucun-$rs_detail[$j]['num']),2);
				else
				{
					$zonge1=floatval(round($rs_store[0]['price']*$kucun,2));
					$zonge2=floatval(round($rs_detail[$j]['price']*$rs_detail[$j]['zhekou']*$rs_detail[$j]['num'],2));
					if(round($zonge1-$zonge2,0)==0)
						$junjia=0;
					else
						throw new Exception("���Ϊ��".$rs_detail[$j]['prodid']." �Ĳ�Ʒ������������Ϊ�㣬����Ϊ�㣬�޷������Ȩƽ����".$zonge1."-".$zonge2);
				}
				if($junjia<0)
						throw new Exception("���Ϊ��".$rs_detail[$j]['prodid']." �Ĳ�Ʒ��Ȩƽ����Ϊ��ֵ�����������絥");
				$sql = "update store set num=num-(".$rs_detail[$j]['num']."),price=".$junjia." where storeid=".$storeid." and prodid='".$rs_detail[$j]['prodid']."'";
				$this->db->Execute($sql);
				//��ɫ����
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
				
			//��������Ʒ���ɷ��õ�
			if($nokucunjine!=0)
			{
				
				$feiyongtype=$this->utility->returntablefield("feiyongtype", "typename", "���ƿ���Ʒ�ɹ���", "id");
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
		
			if($intype=='�ɹ����')
				$this->UpdateCaigouState($caigoubillid);
			else if($intype=='�˻����')
				$this->updatesellplanmainfahuo($caigoubillid);
			else if($intype=='�̵����')
			{
				$kind=1;
				$feiyongname='�̵�����';
				$jine=-$totalmoney;
				$feiyongtype=$this->utility->returntablefield("feiyongtype", "typename", $feiyongname, "id");
				$sql="insert into feiyongrecord (typeid,jine,accountid,chanshengdate,createman,createtime,kind) values($feiyongtype,$jine,'','".date("Y-m-d")."','".$_SESSION['LOGIN_USER_ID']."','".date("Y-m-d H:i:s")."',$kind)";
				$this->db->Execute($sql);
				
				$state=$this->utility->returntablefield("stockoutmain","dingdanbillid", $caigoubillid,"state","outtype","�̵����");
				$newState="�ȴ������ȷ��";
				if($state=="" || $state=="�ȴ������ȷ��")
					$newState="��¼��ϸ";
				$sql="update storecheck set state='$newState' where billid=$caigoubillid";
				$this->db->Execute($sql);
			}
			else if($intype=='�������')
			{	
	
				$sql="update stockchangemain set instoreshenhe='',inshenhetime='' where billid=$caigoubillid";
				$this->db->Execute($sql);
				$sql="update stockchangemain set state='3'  where instoreshenhe='' and outstoreshenhe<>'' and  billid=$caigoubillid";
				$this->db->Execute($sql);
				$sql="update stockchangemain set state='2'  where instoreshenhe='' and outstoreshenhe='' and  billid=$caigoubillid";
				$this->db->Execute($sql);
			}
			else if($intype=='��װ���')
			{
				$sql="update productzuzhuang set instoreshenhe='',inshenhetime='' where billid=$caigoubillid";
				$this->db->Execute($sql);
				
				$sql="update productzuzhuang set state='1'  where instoreshenhe='' and outstoreshenhe='' and  billid=$caigoubillid";
				$this->db->Execute($sql);
			}
		}
		
	}
	
	//�������۵�����
	function insertSellOneChuKu($billid,$zhuti,$storeid)
	{
		$createman=$_SESSION['LOGIN_USER_ID'];
		//����������ϸ��
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
		
		//����
		$chukubillid=0;
		$sql="select sum(num) as num,sum(jine) as jine from sellplanmain_detail where num>0 and mainrowid=$billid";
		$rs=$this->db->Execute($sql);
		$rs_a=$rs->GetArray();
		$allnum=$rs_a[0]['num'];
		$allmoney=$rs_a[0]['jine'];
		if($allnum>0)
		{
			$chukubillid = $this->utility->returnAutoIncrement("billid","stockoutmain");
			//�����³��ⵥ
			
			$sql = "insert into stockoutmain (billid,zhuti,storeid,createman,createtime,dingdanbillid,state,totalnum,totalmoney,outtype,outdate,outstoreshenhe) values(".
			$chukubillid.",'$zhuti',".$storeid.",'".$createman."','".date("Y-m-d H:i:s")."',"
			.$billid.",'".$this->changeChar("�ѳ���")."',$allnum,$allmoney,'".$this->changeChar("���۳���")."','".date("Y-m-d H:i:s")."','$createman')";
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
	
				//�ۼ����
				$storearray=$this->utility->returntablefield("product","productid",$rs_detail[$i]['prodid'],"ifkucun,hascolor");
				$ifkucun=$storearray['ifkucun'];
				$hascolor=$storearray['hascolor'];
				$chengben=0;
				
				if($ifkucun==$this->changeChar("��"))
				{
					$sql = "select * from store where storeid=".$storeid." and prodid='".$rs_detail[$i]['prodid']."'";
					$rs = $this->db->Execute($sql);
					$rs_store = $rs->GetArray();
					
					if(count($rs_store)==0)
					{
						//throw new Exception("����в����� ".$rs_detail[$i]['prodid']." ����Ʒ");
						$chengben=round($rs_detail[$i]['price']*$rs_detail[$i]['zhekou'],2);
						$storemaxid=$this->utility->returnAutoIncrement("id", "store");
						$sql="insert into store (id,prodid,num,price,storeid) values ($storemaxid,'".$rs_detail[$i]['prodid']."',-".$rs_detail[$i]['num'].",$chengben,$storeid)";
						$this->db->Execute($sql);
					}
					else
					{
						
						//if($rs_store[0]['num']-$rs_detail[$i]['num']<0)
						//	throw new Exception($rs_detail[$i]['prodid']." ��治�㣡");
						$chengben=$rs_store[0]['price'];
						$storemaxid=$rs_store[0]['id'];
						$sql = "update store set num=num-(".$rs_detail[$i]['num'].") where storeid=".$storeid." and prodid='".$rs_detail[$i]['prodid']."'";
						$this->db->Execute($sql);
						
					}
					if($hascolor==$this->changeChar("��"))
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
				//���³�����ϸ
				$sql = "update stockoutmain_detail set avgprice=$chengben,lirun=round((price*zhekou-$chengben)*num,2) where id=".$maxid;
				$this->db->Execute($sql);
	
				$sql="update sellplanmain_detail set chukunum=num,lirun=round((price*zhekou-$chengben)*num,2) where mainrowid=".$billid." and prodid='".$rs_detail[$i]['prodid']."' and opertype=".$rs_detail[$i]['opertype'];
				$this->db->Execute($sql);
				
			}
		}
		//���
		$sql="select sum(num) as num,sum(jine) as jine from sellplanmain_detail where num<0 and mainrowid=$billid";
		$rs=$this->db->Execute($sql);
		$rs_a=$rs->GetArray();
		$allnum=$rs_a[0]['num'];
		$allmoney=$rs_a[0]['jine'];
		if($allnum<0)
		{
			$rukubillid = $this->utility->returnAutoIncrement("billid","stockinmain");
			//��������ⵥ
			
			$sql = "insert into stockinmain(billid,zhuti,storeid,createman,createtime,caigoubillid,state,totalnum,totalmoney,indate,intype,instoreshenhe) values(".
			$rukubillid.",'$zhuti',".$storeid.",'".$createman."','".date("Y-m-d H:i:s")."',"
			.$billid.",'".$this->changeChar("�����")."',-$allnum,-$allmoney,'".date("Y-m-d H:i:s")."','".$this->changeChar("�˻����")."','".$createman."')";
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
	
				//���ӿ��
				$storearray=$this->utility->returntablefield("product","productid",$rs_detail[$i]['prodid'],"ifkucun,hascolor");
				$ifkucun=$storearray['ifkucun'];
				$hascolor=$storearray['hascolor'];
				$chengben=0;
				if($ifkucun==$this->changeChar("��"))
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
							throw new Exception($this->changeChar("��Ʒ ".$rs_detail[$i]['prodid']." �ļ�Ȩƽ���۲���Ϊ��ֵ�����������絥"));	
						}
						$sql = "update store set num=num+(".$rs_detail[$i]['num']."),price=$chengben where storeid=".$storeid." and prodid='".$rs_detail[$i]['prodid']."'";
						$this->db->Execute($sql);
					}
					if($hascolor==$this->changeChar("��"))
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
	//��������
	function deleteChuKu($chukubillid)
	{
		$stockoutinfo=$this->utility->returntablefield("stockoutmain","billid",$chukubillid,"dingdanbillid,storeid,state,outtype,totalmoney");
		$dingdanbillid=$stockoutinfo['dingdanbillid'];
		$storeid=$stockoutinfo['storeid'];
		$state=$stockoutinfo['state'];
		$outtype=$stockoutinfo['outtype'];
		$totalmoney=$stockoutinfo['totalmoney'];
		
		if($state=='�ѳ���')
		{
			//ɾ��������
			$sql = "select * from fahuodan where billid=".$chukubillid;
			$rs = $this->db->Execute($sql);
			$rs_a = $rs->GetArray();
			if(count($rs_a)>0)
			{
				if($rs_a[0]['state']=='�ѷ���')
					throw new Exception("���ⵥ��".$chukubillid." �ѷ��������ȳ�����������");
				$sql = "delete from fahuodan where billid=".$chukubillid;
				$this->db->Execute($sql);
			}
			//��������
			$sql = "select * from stockoutmain_detail where mainrowid=".$chukubillid;
			$rs = $this->db->Execute($sql);
			$rs_detail = $rs->GetArray();
			for($j=0;$j<sizeof($rs_detail);$j++)
			{

				$tmpArray=$this->utility->returntablefield("product","productid",$rs_detail[$j]['prodid'],"ifkucun,hascolor");
				$ifkucun=$tmpArray['ifkucun'];
				$hascolor=$tmpArray['hascolor'];
				if($ifkucun=="��")
				{
					$sql = "select * from store where storeid=".$storeid." and prodid='".$rs_detail[$j]['prodid']."'";
					$rs = $this->db->Execute($sql);
					$rs_store = $rs->GetArray();
					$kucun=0;
					if(sizeof($rs_store)>0)
					{
						$kucun=$rs_store[0]['num'];
						//if($kucun+$rs_detail[$j]['num']<0)
						//	throw new Exception($rs_detail[$j]['prodid']." ��治�㣡");
						if($kucun+$rs_detail[$j]['num']!=0)
							$junjia=round(($rs_store[0]['price']*$kucun+$rs_detail[$j]['avgprice']*$rs_detail[$j]['num'])/($kucun+$rs_detail[$j]['num']),2);
						else
						{
							if(round($rs_store[0]['price']*$kucun+$rs_detail[$j]['avgprice']*$rs_detail[$j]['num'],0)==0)
								$junjia=0;
							else
								throw new Exception("���Ϊ��".$rs_detail[$j]['prodid']." �Ĳ�Ʒ������������Ϊ�㣬����Ϊ�㣬�޷������Ȩƽ����");
						}
						if($junjia<0)
									throw new Exception("���Ϊ��".$rs_detail[$j]['prodid']." �Ĳ�Ʒ��Ȩƽ���۲���Ϊ��ֵ�����������絥");
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
					if($hascolor=="��")
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
				if($outtype=='���۳���')
				{
					//���¶�����ϸ
					$sql="update sellplanmain_detail set chukunum=chukunum-(".$rs_detail[$j]['num']."),lirun=lirun-(".$rs_detail[$j]['lirun'].") where mainrowid=$dingdanbillid and prodid='".$rs_detail[$j]['prodid']."' and opertype=".$rs_detail[$j]['opertype'];
					$this->db->Execute($sql);
				}
			}
			//$sql="delete from store where num=0";
			//$this->db->Execute($sql);
			
		}
		$sql = "delete from stockoutmain where billid=".$chukubillid;
		$this->db->Execute($sql);
		if($outtype=='���۳���')
			$this->updatesellplanmainfahuo($dingdanbillid);
		else if($outtype=='��������')
			$this->UpdateCaigouState($dingdanbillid);
		else if($outtype=='�̵����')
		{
			$kind=-1;
			$feiyongname='�̵����';
			$jine=-$totalmoney;
			$feiyongtype=$this->utility->returntablefield("feiyongtype", "typename", $feiyongname, "id");
			$sql="insert into feiyongrecord (typeid,jine,accountid,chanshengdate,createman,createtime,kind,beizhu) values($feiyongtype,$jine,'','".date("Y-m-d")."','".$_SESSION['LOGIN_USER_ID']."','".date("Y-m-d H:i:s")."',$kind,'�̵㵥-$dingdanbillid')";
			$this->db->Execute($sql);
			
			$state=$this->utility->returntablefield("stockinmain","caigoubillid", $dingdanbillid,"state","intype","�̵����");
			$newState="�ȴ������ȷ��";
			if($state=="" || $state=="�ȴ������ȷ��")
				$newState="��¼��ϸ";
			
			$sql="update storecheck set state='$newState' where billid=$dingdanbillid";
			$this->db->Execute($sql);	
			
		}
		else if($outtype=='��������')
		{	

			$sql="update stockchangemain set outstoreshenhe='',outshenhetime='' where billid=$dingdanbillid";
			$this->db->Execute($sql);
			$sql="update stockchangemain set state='3'  where instoreshenhe='' and outstoreshenhe<>'' and  billid=$dingdanbillid";
				$this->db->Execute($sql);
				$sql="update stockchangemain set state='2'  where instoreshenhe='' and outstoreshenhe='' and  billid=$dingdanbillid";
				$this->db->Execute($sql);
		}
		else if($outtype=='��װ����')
		{
			$sql="update productzuzhuang set outstoreshenhe='',outshenhetime='' where billid=$dingdanbillid";
			$this->db->Execute($sql);
			
				$sql="update productzuzhuang set state='1'  where instoreshenhe='' and outstoreshenhe='' and  billid=$dingdanbillid";
				$this->db->Execute($sql);
		}
	}
	//ȷ�ϳ���
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
			if($outtype=='���۳���')
				$num=$_POST["recnum_".$rs_detail[$i]['id']];
			else 
				$num=$rs_detail[$i]['num'];
			
			if( $num>$rs_detail[$i]['num'])
				throw  new Exception("��Ʒ��".$rs_detail[$i]['prodid']."���ĳ��������ܴ���".$rs_detail[$i]['num']);
			
			
			//�ۼ����
			$tmpArray=$this->utility->returntablefield("product","productid",$rs_detail[$i]['prodid'],"ifkucun,hascolor");
			$ifkucun=$tmpArray['ifkucun'];
			$hascolor=$tmpArray['hascolor'];
			if($ifkucun=="��" && $num!=0)
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

				
				if($hascolor=="��")
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
			//���³�����ϸ
			if($num!=0)
				$sql = "update stockoutmain_detail set num=$num,avgprice=$chengben,lirun=round((price*zhekou-$chengben)*$num,2),jine=round((price*zhekou)*$num,2) where id=".$rs_detail[$i]['id'];
			else
				$sql = "delete from stockoutmain_detail where id=".$rs_detail[$i]['id'];
			$this->db->Execute($sql);
			
			if($outtype=='���۳���')
			{
				//ȡ������
				$sql="select lirun from stockoutmain_detail where id=".$rs_detail[$i]['id'];
				$rs = $this->db->Execute($sql);
				$rs_store = $rs->GetArray();
				$lirun=0;
				if(sizeof($rs_store)>0)
					$lirun=$rs_store[0]['lirun'];
				//���¶�����ϸ
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
		//�ı���ⵥ״̬
		$sql = "update stockoutmain set state='�ѳ���',totalnum=$allnum,totalmoney=$allmoney,outstoreshenhe='".$_SESSION['LOGIN_USER_ID']."',outdate='".date("Y-m-d H:i:s")."' where billid=".$chukubillid;
		$this->db->Execute($sql);
		
		if($outtype=='��������')
		{
			$this->UpdateCaigouState($dingdanbillid);
		}
		else if($outtype=="���۳���")
		{
			$this->updatesellplanmainfahuo($dingdanbillid);
		}
		else if($outtype=='�̵����')
		{
			$kind=-1;
			$feiyongname='�̵����';
			$jine=$allmoney;
			$feiyongtype=$this->utility->returntablefield("feiyongtype", "typename", $feiyongname, "id");
			$sql="insert into feiyongrecord (typeid,jine,accountid,chanshengdate,createman,createtime,kind,beizhu) values($feiyongtype,$jine,'','".date("Y-m-d")."','".$_SESSION['LOGIN_USER_ID']."','".date("Y-m-d H:i:s")."',$kind,'�̵㵥-$dingdanbillid')";
			$this->db->Execute($sql);
			
			$state=$this->utility->returntablefield("stockinmain","caigoubillid", $dingdanbillid,"state","intype","�̵����");
			if($state=="" || $state=="�����")
			{
				$sql="update storecheck set state='�̵����' where billid=$dingdanbillid";
				$this->db->Execute($sql);
			}
			
		}
		else if($outtype=='��������')
		{
			$sql="update stockchangemain set state='3',outstoreshenhe='".$_SESSION['LOGIN_USER_ID']."',outshenhetime='".date("Y-m-d H:i:s")."' where billid=$dingdanbillid";
			$this->db->Execute($sql);
		}
		else if($outtype=='��װ����')
		{
			$sql="update productzuzhuang set state='2',outstoreshenhe='".$_SESSION['LOGIN_USER_ID']."',outshenhetime='".date("Y-m-d H:i:s")."' where billid=$dingdanbillid";
			$this->db->Execute($sql);
		}
	}
	
	//��ͬ����
	function HeTongJiaoFu($customerid,$hetongid,$productid,$id,$num,$price,$jieshouren,$jiaofudate,$beizhu,$jine)
	{
		$sql="select num-chukunum as maxnum from sellplanmain_detail where id=$id";
		$rs=$this->db->Execute($sql);
		$rs_a=$rs->GetArray();
		if($num>$rs_a[0]['maxnum'])
			throw new Exception("���ν��������ܴ���".$rs_a[0]['maxnum']);
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
	//ɾ����ͬ����
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
	//���º�ͬ�Ľ���״̬
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
		$fahuostate=4;	//����״̬=ȫ��
		else if($totalmoney>$fahuojine)
		{
			if($fahuojine>0)
			$fahuostate=3;	//����״̬=����
			else
			$fahuostate=0;  //����״̬=�跢��
				
		}
		if($ifpay==2 && $fahuostate==4) //����״̬=���
		$user_flag=2;
		else if($ifpay==0 && $fahuostate==0 && $kaipiaostate<=2) //����״̬=��ʱ��
		$user_flag=0;
		else								//����״̬=ִ����
		$user_flag=1;
		$sql="update sellplanmain set fahuostate=$fahuostate,user_flag=$user_flag where billid=$dingdanid";
		$this->db->Execute($sql);

	}
//������װ���ⵥ
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
				
				if($chukuBillId==0)//�½��������ⵥ
				{
					$chukuBillId = $this->utility->returnAutoIncrement("billid","stockoutmain");
					$sql = "insert into stockoutmain (billid,zhuti,storeid,createman,createtime,dingdanbillid,state,outtype) values(".
					$chukuBillId.",'��װ��-$rowid',".$outstoreid.",'".$createman."','".date("Y-m-d H:i:s")."',"
					.$rowid.",'δ����','��װ����')";
					$this->db->Execute($sql);
				}
			
				$maxid2 = $this->utility->returnAutoIncrement("id","stockoutmain_detail");
				$sql = "insert into stockoutmain_detail (id,prodid,prodname,prodguige,prodxinghao,proddanwei,price,zhekou,num,mainrowid,jine,opertype) values('$maxid2','".
					$rs_detail[$i]['prodid']."','".$rs_detail[$i]['prodname']."','".$rs_detail[$i]['prodguige']."','".$rs_detail[$i]['prodxinghao'].
		    		"','".$rs_detail[$i]['proddanwei']."',".$rs_detail[$i]['price'].",".$rs_detail[$i]['zhekou'].",".$rs_detail[$i]['num'].",".$chukuBillId.",".$rs_detail[$i]['jine'].",1)";
				$this->db->Execute($sql);
			
			$hascolor=$this->utility->returntablefield("product","productid", $rs_detail[$i]['prodid'], "hascolor");
			if($hascolor=="��")
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
//������װ��ⵥ
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
			
				if($rukuBillId==0)//�½�������ⵥ
				{
					$rukuBillId = $this->utility->returnAutoIncrement("billid","stockinmain");
					$sql = "insert into stockinmain(billid,zhuti,storeid,createman,createtime,caigoubillid,state,intype) values(".
					$rukuBillId.",'��װ��-$rowid',".$instoreid.",'".$createman."','".date("Y-m-d H:i:s")."',"
					.$rowid.",'δ���','��װ���')";
					$this->db->Execute($sql);
				}
				
				$maxid1 = $this->utility->returnAutoIncrement("id","stockinmain_detail");
				$sql = "insert into stockinmain_detail (id,prodid,prodname,prodguige,prodxinghao,proddanwei,price,zhekou,num,mainrowid,jine) values('$maxid1','".
					$rs_detail[$i]['prodid']."','".$rs_detail[$i]['prodname']."','".$rs_detail[$i]['prodguige']."','".$rs_detail[$i]['prodxinghao'].
		    		"','".$rs_detail[$i]['proddanwei']."',".$rs_detail[$i]['price'].",".$rs_detail[$i]['zhekou'].",".$rs_detail[$i]['num'].",".$rukuBillId.",".$rs_detail[$i]['jine'].")";
				$this->db->Execute($sql);
			
			
			$hascolor=$this->utility->returntablefield("product","productid", $rs_detail[$i]['prodid'], "hascolor");
			if($hascolor=="��")
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
//���ɵ�����ⵥ
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
			
				if($rukuBillId==0)//�½�������ⵥ
				{
					$rukuBillId = $this->utility->returnAutoIncrement("billid","stockinmain");
					$sql = "insert into stockinmain(billid,zhuti,storeid,createman,createtime,caigoubillid,state,intype) values(".
					$rukuBillId.",'������-$rowid',".$instoreid.",'".$createman."','".date("Y-m-d H:i:s")."',"
					.$rowid.",'δ���','�������')";
					$this->db->Execute($sql);
				}
				
				$maxid1 = $this->utility->returnAutoIncrement("id","stockinmain_detail");
				$sql = "insert into stockinmain_detail (id,prodid,prodname,prodguige,prodxinghao,proddanwei,price,zhekou,num,mainrowid,jine) values('$maxid1','".
					$rs_detail[$i]['prodid']."','".$rs_detail[$i]['prodname']."','".$rs_detail[$i]['prodguige']."','".$rs_detail[$i]['prodxinghao'].
		    		"','".$rs_detail[$i]['proddanwei']."',".$rs_detail[$i]['price'].",".$rs_detail[$i]['zhekou'].",".$rs_detail[$i]['num'].",".$rukuBillId.",".$rs_detail[$i]['jine'].")";
				$this->db->Execute($sql);
			
			
				if($chukuBillId==0)//�½��������ⵥ
				{
					$chukuBillId = $this->utility->returnAutoIncrement("billid","stockoutmain");
					$sql = "insert into stockoutmain (billid,zhuti,storeid,createman,createtime,dingdanbillid,state,outtype) values(".
					$chukuBillId.",'������-$rowid',".$outstoreid.",'".$createman."','".date("Y-m-d H:i:s")."',"
					.$rowid.",'δ����','��������')";
					$this->db->Execute($sql);
				}
			
				$maxid2 = $this->utility->returnAutoIncrement("id","stockoutmain_detail");
				$sql = "insert into stockoutmain_detail (id,prodid,prodname,prodguige,prodxinghao,proddanwei,price,zhekou,num,mainrowid,jine,opertype) values('$maxid2','".
					$rs_detail[$i]['prodid']."','".$rs_detail[$i]['prodname']."','".$rs_detail[$i]['prodguige']."','".$rs_detail[$i]['prodxinghao'].
		    		"','".$rs_detail[$i]['proddanwei']."',".$rs_detail[$i]['price'].",".$rs_detail[$i]['zhekou'].",".$rs_detail[$i]['num'].",".$chukuBillId.",".$rs_detail[$i]['jine'].",1)";
				$this->db->Execute($sql);
			
			
			$hascolor=$this->utility->returntablefield("product","productid", $rs_detail[$i]['prodid'], "hascolor");
			if($hascolor=="��")
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
	//ɾ��������
	function deleteDiaoBo($selectid)
	{

		$sql = "delete from stockinmain where intype='�������' and caigoubillid=".$selectid;
		$this->db->Execute($sql);
		$sql = "delete from stockoutmain where outtype='��������' and dingdanbillid=".$selectid;
		$this->db->Execute($sql);
		$sql = "delete from stockchangemain where billid=".$selectid;
		$this->db->Execute($sql);
	}
	//�����̵㵥
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
				if($rukuBillId==0)//�½��̵���ⵥ
				{
					$rukuBillId = $this->utility->returnAutoIncrement("billid","stockinmain");
					$sql = "insert into stockinmain(billid,zhuti,storeid,createman,createtime,caigoubillid,state,intype) values(".
					$rukuBillId.",'��ӯ��-$rowid',".$storeid.",'".$createman."','".date("Y-m-d H:i:s")."',"
					.$rowid.",'δ���','�̵����')";
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
				if($chukuBillId==0)//�½��̵���ⵥ
				{
					$chukuBillId = $this->utility->returnAutoIncrement("billid","stockoutmain");
					$sql = "insert into stockoutmain (billid,zhuti,storeid,createman,createtime,dingdanbillid,state,outtype) values(".
					$chukuBillId.",'�̿���-$rowid',".$storeid.",'".$createman."','".date("Y-m-d H:i:s")."',"
					.$rowid.",'δ����','�̵����')";
					$this->db->Execute($sql);
				}
			
				$maxid = $this->utility->returnAutoIncrement("id","stockoutmain_detail");
				$sql = "insert into stockoutmain_detail (id,prodid,prodname,prodguige,prodxinghao,proddanwei,price,zhekou,num,mainrowid,jine,opertype) values('$maxid','".
					$rs_detail[$i]['prodid']."','".$rs_detail[$i]['prodname']."','".$rs_detail[$i]['prodguige']."','".$rs_detail[$i]['prodxinghao'].
		    		"','".$rs_detail[$i]['proddanwei']."',".$rs_detail[$i]['price'].",".$rs_detail[$i]['zhekou'].",".-$rs_detail[$i]['num'].",".$chukuBillId.",".-$rs_detail[$i]['jine'].",1)";
				$this->db->Execute($sql);
			}
			
			$hascolor=$this->utility->returntablefield("product","productid", $rs_detail[$i]['prodid'], "hascolor");
			if($hascolor=="��")
			{
				$sql="select * from storecheck_detail_color where id=".$rs_detail[$i]['id'];
				$rs = $this->db->Execute($sql);
				$rs_color = $rs->GetArray();
				foreach ($rs_color as $row)
				{
					
					if($row[num]>0)//�ɹ������ϸ��ɫ
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
				
		$sql="update storecheck set state='�ȴ������ȷ��' where billid=".$rowid;
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
	//ɾ���̵㵥
	function deleteStoreCheck($selectid)
	{
		$storeid = $this->utility->returntablefield("storecheck","billid",$selectid,"storeid");
		$state=$this->utility->returntablefield("storecheck","billid",$selectid,"state");

		if($state=='�̵����')
		{
			//�������
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
				throw new Exception("���Ϊ��".$rs_detail[$j]['prodid']." �Ĳ�Ʒ��治��");


				if($kucun-$rs_detail[$j]['num']!=0)
				$junjia=round(($rs_store[0]['price']*$kucun-$rs_detail[$j]['price']*$rs_detail[$j]['num'])/($kucun-$rs_detail[$j]['num']),2);
				else
				{
					if(round($rs_store[0]['price']*$kucun-$rs_detail[$j]['price']*$rs_detail[$j]['num'],0)==0)
					$junjia=0;
					else
					throw new Exception("���Ϊ��".$rs_detail[$j]['prodid']." �Ĳ�Ʒ������������Ϊ�㣬����Ϊ�㣬�޷������Ȩƽ����");
				}
					
				$sql = "update store set num=num-(".$rs_detail[$j]['num']."),price=".$junjia." where storeid=".$storeid." and prodid='".$rs_detail[$j]['prodid']."'";
				$this->db->Execute($sql);
				//��ɫ����
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
		//ɾ���̵㵥
		$sql = "delete from stockinmain where intype='�̵����' and caigoubillid=".$selectid;
		$this->db->Execute($sql);
		$sql = "delete from stockoutmain where outtype='�̵����' and dingdanbillid=".$selectid;
		$this->db->Execute($sql);
		$sql = "delete from storecheck where billid=".$selectid;
		$this->db->Execute($sql);
	}
	//���³�������
	function updateStockoutAmount($id,$recnum)
	{
		$sql="update stockoutmain_detail set num=$recnum where id=$id";
		$this->db->Execute($sql);
	}
	
}

?>