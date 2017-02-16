<?php
/*****************************************************************\
 1����ϵͳΪ��ҵ������ܹ�������Ȩ���������κ��˲�����
 ԭ����δͬ��Ļ����Ͻ��п������������ҵ��;��
 2�����ΰ汾Ϊ�ǿ�Դ�棬�����ʹ�ã���ע���ȡ���֤��
 3����ϵͳ���߱���һ����ص�֪ʶ��Ȩ
 \*****************************************************************/

function gettablefield($tablename,$field_value,$field_name,$value)		{
	global $db;
	if($value=='') return '';
	$sql="select distinct $field_name from $tablename where $field_value='$value'";
	$rs=$db->CacheExecute(30,$sql);
	return trim($rs->fields[$field_name]);
}
//�õ�һ�ֶ�ֵ
function returntablefield($tablename,$what,$value,$return,$where1='',$value1='',$where2='',$value2='')		{
	global $db,$_SESSION;
	//���ж����ݿ��жϲ���

	switch(substr($tablename,0,5))					{
		case 'flow_':
			if($_SESSION['SYSTEM_IS_TD_OA']=='1')
			$tablename = "TD_OA.$tablename";
			break;
	}
	if($value=='') return '';
	$sql="select distinct $return from $tablename where $what='$value'";
	if($where1!=""&&$value1!="")			
		$sql.=" and $where1='$value1'";
	if($where2!=""&&$value2!="")			
		$sql.=" and $where2='$value2'";
	//print $sql."<BR>";
	$rs=$db->Execute($sql);

	//print_r($rs->fields)."<BR>";
	$returnArray = explode(',',$return);
	if(@$returnArray[1]!="")
	return $rs->fields;					//��������
	else
	return trim($rs->fields[$return]);	//����ĳһ�ֶε�ֵ
}
//����Ϣ
function newMessage($touser,$zhuti,$messagetitle,$url,$guanlianid,$nexttime='')
{
	global $db;
	$sql="select max(id) as maxid from message";
	$rs=$db->Execute($sql);
	$rs_a = $rs->GetArray();
	$maxid=$rs_a[0]['maxid']+1;
	$zhuti=htmlspecialchars($zhuti);
	if($nexttime!='')
		$sql="insert into message (id,userid,content,msgtype,url,guanlianid,createtime,attime) values('".$maxid."','".$touser."','".
	$zhuti."','$messagetitle','$url',".$guanlianid.",'".date("Y-m-d H:i:s")."','$nexttime')";
	else
		$sql="insert into message (id,userid,content,msgtype,url,guanlianid,createtime) values('".$maxid."','".$touser."','".
	$zhuti."','$messagetitle','$url',".$guanlianid.",'".date("Y-m-d H:i:s")."')";
	$db->Execute($sql);
}
//ɾ����Ϣ
function deleteMessage($messagetype,$guanlianid)
{
	global $db;
	$sql="delete from message where msgtype='$messagetype' and guanlianid=$guanlianid";
	$db->Execute($sql);
}
//��Ϊ�Ѷ�
function updateMessage($messagetype,$guanlianid,$flag)
{
	global $db;
	$sql="update message set flag='$flag' where msgtype='$messagetype' and guanlianid=$guanlianid";
	$db->Execute($sql);
}
//���ճ�
function newCalendar($userid,$CAL_TIME,$END_TIME,$CAL_TYPE,$CAL_LEVEL,$CONTENT,$url,$guanlianid)
{
	global $db;
	$sql="insert into calendar (USER_ID,CAL_TIME,END_TIME,CAL_TYPE,CAL_LEVEL,CONTENT,url,guanlianid) values('".$userid."','".$CAL_TIME."','".
	$END_TIME."','$CAL_TYPE','$CAL_LEVEL','$CONTENT','$url','$guanlianid')";
	$db->Execute($sql);
}
//ɾ���ճ�
function deleteCalendar($cal_type,$guanlianid)
{
	global $db;
	$sql="delete from calendar where cal_type='$cal_type' and guanlianid=$guanlianid";
	$db->Execute($sql);
}
//�ݹ�ȡ�������
function getSubprodtypeByParent($parent)
{
	global $db;
	$subprodlist="";
	$sql="select * from producttype where parentid=$parent";
	$rs=$db->Execute($sql);
	$rs_a=$rs->GetArray();
	for($i=0;$i<sizeof($rs_a);$i++)
	{
		if($subprodlist=='')
			$subprodlist="'".$rs_a[$i]["ROWID"]."'";
		else
			$subprodlist=$subprodlist.",'".$rs_a[$i]["ROWID"]."'";
		$subprod=getSubprodtypeByParent($rs_a[$i]["ROWID"]);
		if($subprod!='')
			$subprodlist.=",".$subprod;
	}
	return $subprodlist;
}
//�ݹ�ȡ���Ӳ���
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

function ifHasRoleUser($userid)
{
	$deptid=returntablefield("user", "user_id", $userid , "dept_id");
	$subDept=getSubDeptListByParent($_SESSION['LOGIN_DEPT_ID']);
	$subDept=str_replace("'", "", $subDept);
	if($_SESSION['LOGIN_USER_PRIV']=='2')
	$subDept=$subDept.",".$_SESSION['LOGIN_DEPT_ID'];
	$subDeptArray=explode(",", $subDept);
	if($_SESSION['LOGIN_USER_PRIV']=='1' || $userid==$_SESSION['LOGIN_USER_ID'] || in_array($deptid, $subDeptArray))
	return true;
	else
	return false;
}
function ifHasRoleCust($customerid)
{
	$custInfo=returntablefield("customer", "rowid", $customerid , "sysuser,datascope");
	$userid=$custInfo['sysuser'];
	$datascope=$custInfo['datascope'];
	if(ifHasRoleUser($userid) || $datascope=='1')
	return true;
	else
	return false;

}
//Ȩ���ж�
function getCustomerRoleByUser($sql,$fieldname)		{
	$subdeptrole=getSubDeptListByParent($_SESSION['LOGIN_DEPT_ID']);
	if($subdeptrole!='')
	$deptrole="'".$_SESSION['LOGIN_DEPT_ID']."',".$subdeptrole;
	else
	$deptrole="'".$_SESSION['LOGIN_DEPT_ID']."'";
	if($subdeptrole=="")
	$subdeptrole="''";
	global $_SESSION;
	$user_priv=$_SESSION['LOGIN_USER_PRIV'];
	if($user_priv=='2')
	$sql = $sql." and ($fieldname in (select user_id from user where dept_id in (".$deptrole.")) or datascope='1')";
	else if($user_priv=='3')
	$sql = $sql." and ((($fieldname='".$_SESSION['LOGIN_USER_ID']."' or $fieldname in (select user_id from user where dept_id in (".$subdeptrole."))) and datascope>1) or datascope='1')";
	return $sql;
}
//Ȩ���ж�
function getCustomerRoleByCustID($sql,$fieldname)		{
	$subdeptrole=getSubDeptListByParent($_SESSION['LOGIN_DEPT_ID']);
	if($subdeptrole!='')
	$deptrole="'".$_SESSION['LOGIN_DEPT_ID']."',".$subdeptrole;
	else
	$deptrole="'".$_SESSION['LOGIN_DEPT_ID']."'";
	global $_SESSION;
	if($subdeptrole=="")
	$subdeptrole="''";
	if($_SESSION['LOGIN_USER_PRIV']=='2')
	$sql = $sql." and $fieldname in (select rowid from customer where sysuser in (select user_id from user where dept_id in (".$deptrole.")) or datascope='1') ";
	else if($_SESSION['LOGIN_USER_PRIV']=='3')
	$sql = $sql." and $fieldname in (select rowid from customer where ((sysuser='".$_SESSION['LOGIN_USER_ID']."' or sysuser in (select user_id from user where dept_id in (".$subdeptrole."))) and datascope>1) or datascope='1')";
	
	return $sql;
}
//Ȩ���ж�
function getRoleByUser($sql,$fieldname)		{
	global $db;
	$subdeptrole=getSubDeptListByParent($_SESSION['LOGIN_DEPT_ID']);
	if($subdeptrole!='')
	$deptrole="'".$_SESSION['LOGIN_DEPT_ID']."',".$subdeptrole;
	else
	$deptrole="'".$_SESSION['LOGIN_DEPT_ID']."'";
	if($subdeptrole=="")
	$subdeptrole="''";
	global $_SESSION;
	if($_SESSION['LOGIN_USER_PRIV']=='2')
	$sql = $sql." and ($fieldname in (select user_id from user where dept_id in (".$deptrole.")))";
	else if($_SESSION['LOGIN_USER_PRIV']=='3')
	$sql = $sql." and ($fieldname='".$_SESSION['LOGIN_USER_ID']."' or $fieldname in (select user_id from user where dept_id in (".$subdeptrole.")))";
	return $sql;
}
//�ɹ���Ȩ���ж�
function getSupplyRoleBySupplyID($userid)
{
	global $_SESSION;
	$oper_info = returntablefield( "user", "user_id", $userid, "dept_id,user_priv");
	$oper_info1 = returntablefield( "user", "user_id", $_SESSION['LOGIN_USER_ID'], "dept_id,user_priv");
	if($oper_info1['user_priv']==1 || ($oper_info1['dept_id']==$oper_info['dept_id'] && $oper_info1['user_priv']==2) || $userid==$_SESSION['LOGIN_USER_ID'])
	return true;
	else
	return false;
}

//����Ƿ�ɼ�
function getKucunByUserid($sql,$userid,$storeid="storeid")
{
	global $_SESSION;
	
	if($_SESSION['LOGIN_USER_PRIV']!='1')
	{
		$sql = $sql." and $storeid in (".$_SESSION["STORE_PRIV"].")";
	}
	return $sql;
}

//����Ƿ�ɲ���
function getKucunOperByUserid($sql,$userid,$storeid="storeid")
{
	$sql = $sql." and $storeid in (select rowid from stock where user_id like '%".$userid.",%')";
	return $sql;
}
//�趨һ�ֶ�ֵ
function updatetablefield($tablename,$what,$value,$return,$returnValue)		{
	global $db;
	$sql="update $tablename set $return = '$returnValue' where $what='$value'";
	$rs=$db->Execute($sql);
	return $rs->EOF;
}
//�趨һ�ֶ�ֵ
function settablefield($tablename,$what,$value,$return,$returnValue)		{
	return updatetablefield($tablename,$what,$value,$return,$returnValue);
}
function setColorByName($value)
{
	$returnColorArray = returnColorArrayTableFilter();
				
	$biaoti=hexdec((String)bin2hex($value));
	
	$jishu=0;
	$oushu=0;
	$biaoti=strval(number_format($biaoti,0));
	for($i=0;$i<intval(strlen($biaoti)/2);$i++)
	{
		$jishu=$jishu+intval($biaoti{$i*2});
		$oushu=$oushu+intval($biaoti{$i*2+1});
	}
	if(strlen($biaoti)%2==1)
		$jishu=$jishu+intval($biaoti{strlen($biaoti)-1});
	$jiaoyan=(($jishu+$oushu*3)%16);
	
	$colorIndex =$jiaoyan;
	
	$colorValue = $returnColorArray[$colorIndex];
	return $colorValue;
}

//�õ�һ�ֶ�ֵ-���ֵΪ��,�����ж�������ֵ,������TABLEFILTERCOLOR����
function returntablefieldColorFilterGray($tablename,$what,$value,$return,$groupfield='',$groupvalue='',$�ֶ�����='',$hascolor=false)		{

	/*
	 global $return_sql_line;
	 $where_sql = $return_sql_line['where_sql'];;
	 $where_sql_array = explode("where",$where_sql);
	 if(trim($where_sql_array[1])!=""&&$�ֶ�����!="")		{
		$ADD_SQL_WHERE_TEXT = " and $return in (select distinct $�ֶ����� $where_sql)";
		}
		else	{
		$ADD_SQL_WHERE_TEXT = "";
		}
		*/
	global $db;
	if($value=='')
		return;
	if($groupfield!=""&&$groupvalue!="")		{
		$sql = "select  $return,$what from $tablename where $what='$value' and $groupfield='$groupvalue' $ADD_SQL_WHERE_TEXT";
		$TEMP_TAR = 1;
	}
	else	{
		$sql = "select  $return,$what from $tablename where $what='$value' $ADD_SQL_WHERE_TEXT";
		$TEMP_TAR = 0;
	}
	
	
	$return2 = '';
	$rs=$db->CacheExecute(15,$sql);
	
	$rs_a = $rs->GetArray();
	
			if(sizeof($rs_a)==0 || $rs_a[0][$return]=="")			{	//�������ֵΪ��,���ô���ֵ���
				$return2 = "<font color=gray title='��".$tablename."�������Ϣ��,�Ҳ����뱾ֵ��Ӧ����Ϣ.'>$value</font>";
			}
			else
			{							//������ɫ����
				
				$cutvalue=cutStr($rs_a[0][$return],13);
				$tip='';
				if($rs_a[0][$return]!=$cutvalue)
				{
					$tip="title='".$rs_a[0][$return]."'";
					$rs_a[0][$return]=$cutvalue."..";
				}
				
				$colorValue = setColorByName($value);
				if($value=="��")
					$colorValue="green";
				else if($value=="��")
					$colorValue="red";
				//print "".strval($value)."";exit;
				//print_r($rs_a);exit;
				
				if($tablename == 'customer'){
					
					$id = $rs_a[0][$what];
					
					$return2 = "<a target='_blank' $tip href='../JXC/customer_newai.php?".base64_encode("action=view_default&ROWID=".$id)."'><font color=$colorValue>".$rs_a[0][$return]."</font></a>";
				}elseif($tablename == 'supply'){
					
					$id = $rs_a[0][$what];
					
					$return2 = "<a target='_blank' $tip href='../JXC/supply_newai.php?".base64_encode("action=view_default&ROWID=".$id)."'><font color=$colorValue>".$rs_a[0][$return]."</font></a>";
					
				}elseif($tablename == 'linkman'){
					//$id = isset($rs_a[0]['ROWID'])?$rs_a[0]['ROWID']:$value;
					
					if(isset($rs_a[0]['ROWID'])){
						$id = $rs_a[0]['ROWID'];
						$qq=returntablefield("linkman", "rowid", $id, "fax");
						
						$return2 = "<a target='_blank' $tip href='../JXC/linkman_newai.php?".base64_encode("action=view_default&ROWID=".$id)."'><font color=$colorValue>".$rs_a[0][$return]."</font></a>";
					}
					else 
						$return2=$rs_a[0][$return];
				}elseif($tablename == 'supplylinkman'){
					//$id = isset($rs_a[0]['ROWID'])?$rs_a[0]['ROWID']:$value;
					if(isset($rs_a[0]['ROWID'])){
						$id = $rs_a[0]['ROWID'];
					}else{
						$sql = "select ROWID from $tablename where supplyname='".$value."'";
						$rowid_rs=$db->CacheExecute(15,$sql);
						$rowid = $rowid_rs->GetArray();
						$id = $rowid[0]['ROWID'];
					}
					$return2 = "<a target='_blank' $tip href='../JXC/supplylinkman_newai.php?".base64_encode("action=view_default&ROWID=".$id)."'><font color=$colorValue>".$rs_a[0][$return]."</font></a>";
					
				}elseif($tablename == 'user'){
					if(isset($rs_a[0]['ROWID'])){
						$id = $rs_a[0]['ROWID'];
					}else{
						$sql = "select UID from $tablename where USER_ID='".$value."'";
						$rowid_rs=$db->CacheExecute(15,$sql);
						$rowid = $rowid_rs->GetArray();
						$id = $rowid[0]['UID'];
					}
					$return2 = "<a target='_blank' $tip href='../Framework/user_newai.php?".base64_encode("action=view_default&UID=".$id)."'><font color=$colorValue>".$rs_a[0][$return]."</font></a>";
					
				}elseif($tablename == 'crm_chance'){
					if(isset($rs_a[0]['���'])){
						$id = $rs_a[0]['���'];
					}else{
						$sql = "select ���  from $tablename where ��������='".$value."'";
						$rowid_rs=$db->CacheExecute(15,$sql);
						$rowid = $rowid_rs->GetArray();
						$id = $rowid[0]['���'];
					}
					$return2 = "<a target='_blank' $tip href='../JXC/crm_chance_newai.php?".base64_encode("action=view_default&���=".$id)."'><font color=$colorValue>".$rs_a[0][$return]."</font></a>";
					
				}
				elseif($tablename == 'product'){
					
					$return2 = "<a target='_blank' $tip href='../JXC/product_newai.php?".base64_encode("action=view_default&productid=".$value)."'><font color=$colorValue>".$rs_a[0][$return]."</font></a>";
					
				}
				elseif($tablename == 'sellplanmain'){
					
						$id = $rs_a[0]['billid'];
						
						$billtype=returntablefield($tablename, "billid", $id, "billtype");
						
						if($billtype==1)	
							$urlName="sellcontract";
						else if($billtype==2)
							$urlName="sellplanmain";
						else if($billtype==3)
							$urlName="v_sellone_search";
					$return2 = "<a target='_blank' $tip href='../JXC/".$urlName."_newai.php?".base64_encode("action=view_default&billid=".$id)."'><font color=$colorValue>".$rs_a[0][$return]."</font></a>";
					
				}
				elseif($tablename == 'buyplanmain'){
					
						$id = $rs_a[0]['billid'];
					
					$return2 = "<a target='_blank' $tip href='../JXC/buyplanmain_newai.php?".base64_encode("action=view_default&billid=".$id)."'><font color=$colorValue>".$rs_a[0][$return]."</font></a>";
					
				}
				elseif($tablename == 'stock'){
					
					$id = $rs_a[0]['ROWID'];
					$return2 = "<a target='_blank' $tip href='../JXC/store_product_newai.php?".base64_encode("action=init_default&storeid=".$id)."'><font color=$colorValue>".$rs_a[0][$return]."</font></a>";
					
				}
				elseif($tablename == 'bank'){
					
					$id = $rs_a[0][$what];
					$return2 = "<a target='_blank' $tip href='../JXC/v_accessbank_newai.php?".base64_encode("action=init_default&�����˻�=".$id)."'><font color=$colorValue>".$rs_a[0][$return]."</font></a>";
					
				}
				elseif($tablename == 'fahuotype'){
					
					$id = $rs_a[0]['id'];
					$return2 = "<a target='_blank' $tip href='../JXC/fahuodan_newai.php?".base64_encode("action=init_default&fahuotype=".$id)."'><font color=$colorValue>".$rs_a[0][$return]."</font></a>";
					
				}
				elseif($tablename == 'customerproduct'){
					
					$id = $rs_a[0]['ROWID'];
					$return2 = "<a target='_blank' $tip href='../JXC/customerproduct_newai.php?".base64_encode("action=view_default&ROWID=".$id)."'><font color=$colorValue>".$rs_a[0][$return]."</font></a>";
					
				}
				elseif($tablename == 'customer_xuqiu'){
					
					$id = $rs_a[0][$what];
					$return2 = "<a target='_blank' $tip href='../JXC/customer_xuqiu_newai.php?".base64_encode("action=view_default&$what=".$id)."'><font color=$colorValue>".$rs_a[0][$return]."</font></a>";
					
				}
				elseif($tablename == 'crm_shenqingbaobei'){
					
					$id = $rs_a[0][$what];
					$return2 = "<a target='_blank' $tip href='../JXC/crm_shenqingbaobei_newai.php?".base64_encode("action=view_default&$what=".$id)."'><font color=$colorValue>".$rs_a[0][$return]."</font></a>";
					
				}
				elseif($tablename == 'workplanmain'){
					
					$id = $rs_a[0][$what];
					$return2 = "<a target='_blank' $tip href='../CRM/workplanmain_newai.php?".base64_encode("action=view_default&$what=".$id)."'><font color=$colorValue>".$rs_a[0][$return]."</font></a>";
					
				}
				else{
					
					if($hascolor)
						$return2 = "<span $tip><font color=$colorValue>".$rs_a[0][$return]."</font></span>";
					else 
						$return2 ="<span $tip>".$rs_a[0][$return]."</span>";
				}
			}

	
	//print $return2;print $value;print "<BR>";
	//if($value=="50001")		exit;
	//print $return2;exit;
	//if($TEMP_TAR == 1)	print_R($return2);
	return $return2;
}
//�õ�һ�ֶ�ֵ-����ֵ��ɫ
function returntablefieldColor($tablename,$what,$value,$return,$groupfield='',$groupvalue='',$�ֶ�����='')		{
	/*
	 global $return_sql_line;
	 $where_sql = $return_sql_line['where_sql'];;
	 if($where_sql!=""&&$�ֶ�����!="")		{
		$ADD_SQL_WHERE_TEXT = " and $return in (select distinct $�ֶ����� $where_sql)";
		}
		else	{
		$ADD_SQL_WHERE_TEXT = "";
		}
		*/
	global $db;
	if($groupfield!=""&&$groupvalue!="")		{
		$sql = "select distinct $return,$what from $tablename where $groupfield='$groupvalue' $ADD_SQL_WHERE_TEXT";
		$TEMP_TAR = 1;
	}
	else	{
		$sql = "select distinct $return,$what from $tablename where 1=1 $ADD_SQL_WHERE_TEXT";
		$TEMP_TAR = 0;
	}
	$rs=$db->CacheExecute(15,$sql);
	$rs_a = $rs->GetArray();
	//print $sql."<BR>";
	$return2 = '';
	for($i=0;$i<sizeof($rs_a);$i++)			{
		$updateValue = $rs_a[$i][$what];
		if($updateValue==$value)		{
			$returnColorArray = returnColorArrayTableFilter();
			$colorIndex = $i%8;
			$colorValue = $returnColorArray[$colorIndex];

			$return2 = "<font color=$colorValue>".$rs_a[$i][$return]."</font>";
		}
		else	{
			//$return2 = "";
		}
	}
	//if($TEMP_TAR == 1)	print_R($return2);
	return $return2;
}
//�õ�һ�ֶ�ֵ-���ֶθ���
function returntablefieldGroup($tablename,$what,$value,$return,$groupfield='',$groupvalue='')		{
	$return2 = '';
	global $db;
	if($groupfield!=""&&$groupvalue!="")		{
		$sql = "select distinct $return,$what from $tablename where $groupfield='$groupvalue'";
		$TEMP_TAR = 1;
	}
	else{
		$sql = "select distinct $return,$what from $tablename";
		$TEMP_TAR = 0;
	}//print $sql;
	$rs=$db->CacheExecute(30,$sql);
	$rs_a = $rs->GetArray();
	for($i=0;$i<sizeof($rs_a);$i++)			{
		$updateValue = $rs_a[$i][$what];
		if($updateValue==$value)		{
			$returnColorArray = returnColorArrayTableFilter();
			$colorIndex = $i%8;
			$colorValue = $returnColorArray[$colorIndex];

			$return2 = "<font color=$colorValue>".$rs_a[$i][$return]."</font>";
		}
		else	{
			//$return2 = "";
		}
	}
	//if($TEMP_TAR == 1)	print_R($return2);
	return $return2;
}
/******************************************************************************
 *@ϵͳ��Ŀ��Sunshine Anywhere Application Platform(SAAP)1.2
 *@����˵��������TablefilterColor��ʾ����ÿ����õ�ɫ����Ϣ����
 *@�������ߣ�������
 *@�������ڣ�2006-4-20
 */
function returnColorArrayTableFilter()			{
	$ColorArray[0]="darksalmon";
	$ColorArray[1]="darkorchid";
	$ColorArray[2]="darkolivegreen";
	$ColorArray[3]="deeppink";
	$ColorArray[4]="darkgoldenrod";
	$ColorArray[5]="firebrick";
	$ColorArray[6]="coral";
	$ColorArray[7]="deepskyblue";
	$ColorArray[8]="BlueViolet";
	$ColorArray[9]="Brown";
	$ColorArray[10]="chocolate";
	$ColorArray[11]="steelblue";
	$ColorArray[12]="purple";
	$ColorArray[13]="orange";
	$ColorArray[14]="darkslateblue";
	$ColorArray[15]="dodgerblue";
	return $ColorArray;
}
//�õ�һ�ֶ�ֵ
function ajaxtablefield($tablename,$what,$value,$return,$Counter,$tablename2,$updateField,$primaryKey,$primarykeyValue)		{
	global $db;
	$field_name = $return;
	$field_value = $what;
	$sql="select distinct $field_value,$field_name from $tablename";
	$rs=$db->CacheExecute(30,$sql);
	$selectName = $field_name."_".$Counter;
	$filename = returnpath();
	$filename = $filename."Enginee/lib/XmlHttpServer_Ajax.php";
	$Text .= "<select class=\"SmallSelect\" name=$selectName onChange=GetResult(this.value)>\n";
	while(!$rs->EOF)			{
		if($value==trim($rs->fields[$field_value]))		$temp='selected';
		$Base64Code = $filename."?action=ajax&tablename=$tablename2&updateField=$updateField&newValue=".$rs->fields[$field_value]."&primaryKey=$primaryKey&primarykeyValue=$primarykeyValue";
		$Text .= "<option value=\"$Base64Code\" $temp>".$rs->fields[$field_name]."</option>\n";
		$temp='';
		$rs->MoveNext();
	}
	$Text .= "</select> &nbsp;\n";
	return $Text;
}




































































//�˺�����ͨ�õ�SELECTMENU��������Ҫ��������ƾ��ڴ˺���������ơ�
function print_select($showtext,$showfield,$value,$tablename2,$field_value,$field_name,$colspan=1,$setfieldname='',$setfieldvalue='',$setfieldboolean='',$initvalue='')		{
	global $db,$_GET;
	global $_SESSION;
	global $FORM_SELECT_DISABLED;
	global $html_etc,$tablename;
	global $SYSTEM_SELECT_MENU_SHOW_KEY;
	//print $SYSTEM_SELECT_MENU_SHOW_KEY;

	//�û�������������##########################��ʼ
	global $fields;
	//print_R($fields['USER_PRIVATE'][$showfield]);
	if($fields['USER_PRIVATE'][$showfield]!="")	{
		$readonly = $fields['USER_PRIVATE'][$showfield];
		$class = "SmallStatic";
	}
	else	{
		$readonly = "";
		$class = "SmallSelect";
	}

	if($_GET["".$showfield."_disabled"]=="disabled")		{
		$readonly = "disabled";
		$class = "SmallStatic";
		


		$showFieldName = returntablefield($tablename2,$field_value,$_GET[$showfield],$field_name);
	
		print "<TR>";
		print "<TD class=TableData noWrap>".$showtext."</TD>\n";
		print "<TD class=TableData noWrap colspan=\"$colspan\">\n";
		print "<input type=hidden name=\"$showfield\" value=\"".$_GET[$showfield]."\"/>\n";
		if($SYSTEM_SELECT_MENU_SHOW_KEY==1)			{
			print "<font color=green>".$showFieldName."[".$_GET[$showfield]."]</font>\n";
		}
		else	{
			print "<font color=green>$showFieldName</font>\n";
		}
		print "</TD></TR>\n";
		return;
	}
	//print_R($_GET);
	//�û�������������##########################����
	global $fields;
	global $columns;
	//print_R($columns);
	//print_R($initvalue);exit;

	$sql="select distinct $field_value,$field_name from $tablename2";
	print $initvalue;
	if($initvalue!="")			{
		$columnschild=returntablecolumn($tablename2);
		$������ = $columnschild[$initvalue];
		if($_GET[$������]!="")		{
			//print_R($_GET);
			$sql = $sql." where $������ = ".$_GET[$������]."";
		}
	}


	//$����ֶ�
	//print $sql;
	$rs=$db->CacheExecute(30,$sql);

	//ʵʱ���½�������˵��
	$showtext = FilterFieldName($showtext,$showfield);

	print "<TR>";
	print "<TD class=TableData noWrap>".$showtext."</TD>\n";
	print "<TD class=TableData noWrap colspan=\"$colspan\">\n";
	//#########################################################
	//����ָ�������ֶο��ù���ģ��
	if($setfieldname!=""&&$setfieldvalue!=""&&$setfieldboolean!="")	{
		//��ʱ�趨δʹ�ã�����Ϊ���һ��ʱ����Ϊ����ʹ��״̬
		if($setfieldvalue != $value)
		$FORM_SELECT_DISABLED[$setfieldname] = 'disabled' ;
		print "
		<script>
		function changeselect".$setfieldname."(locationid)
		{
			if(locationid == '".$setfieldvalue."')		{
				document.form1.".$setfieldname.".disabled = false;
			}
			else	{
				document.form1.".$setfieldname.".disabled = true;
			}
		}
		</script>
	";
	}
	//#########################################################
	print "<input type=hidden name='".$showfield."_ԭʼֵ' value='$value'>\n";
	print "<select class=\"$class\" name=\"$showfield\" title='".$fields['USER_PRIVATE_TEXT'][$showfield]."' ";
	//�޸Ĺ��ܣ���ָ����Ϊδʹ�ù���
	if($setfieldname!=""&&$setfieldvalue!=""&&$setfieldboolean!="")	{
		print " onChange=\"changeselect".$setfieldname."(this.value)\" ";
	}
	//ϵͳ��ʼ��ʱ���Ƿ�ʹ��;
	print $FORM_SELECT_DISABLED[$showfield];
	//��س�ΪTab Key����
	print " onkeydown=\"if(event.keyCode==13)event.keyCode=9\" $readonly>\n";

	//����������==00
	if($tablename2 == 'department')		{
		print "<option value=''>======[��λ]</option>\n";
	}
	//����������
	while(!$rs->EOF)			{
		if($value==$rs->fields[$field_value]||$_GET[$showfield]==$rs->fields[$field_value])		$temp='selected';
		//�Բ�����Ϣ�����ر���
		if($tablename2 == 'department'&&$value=="")		{
			$SUNSHINE_USER_DEPT = $_SESSION['SUNSHINE_USER_DEPT'];
			if($rs->fields[$field_value] == $SUNSHINE_USER_DEPT)		{
				$temp = 'selected';
			}
		}
		//���û���Ϣ�����ر���
		if($tablename2 == 'user'&&$value=="")		{
			$SUNSHINE_USER_NAME = $_SESSION['SUNSHINE_USER_NAME'];
			if($rs->fields[$field_value] == $SUNSHINE_USER_NAME)		{
				$temp = 'selected';
			}
		}
		//�������

		//���������˵�ʱ,�Ƿ���ʾKEY�ֶ�
		if($SYSTEM_SELECT_MENU_SHOW_KEY==1)			{
			print "<option value=\"".$rs->fields[$field_value]."\" $temp>".$rs->fields[$field_name]."[".$rs->fields[$field_value]."]</option>\n";
		}
		else		{
			print "<option value=\"".$rs->fields[$field_value]."\" $temp>".$rs->fields[$field_name]."</option>\n";
		}
		$temp='';
		$rs->MoveNext();
	}
	print "</select>\n";
	print $addtext = FilterFieldAddText($addtext,$showfield);
	//print_R($_SESSION);
	//���Ա�����
	//print_R($FORM_SELECT_DISABLED);print $FORM_SELECT_DISABLED[$showfield];
	print "</TD></TR>\n";
}


//�˺�����SELECT_PRIV���
function print_selectpriv($showtext,$showfield,$value)		{
	global $db,$_GET;
	global $_SESSION,$common_html;

	$USER_PRIV_ID = $_SESSION['LOGIN_USER_PRIV'];



	$sql="select * from user_priv";
	if($USER_PRIV_ID!="1")
		$sql.=" where USER_PRIV>=$USER_PRIV_ID";
	$rs=$db->CacheExecute(30,$sql);
	print "<TR>";
	print "<TD class=TableData noWrap>".$showtext."</TD>\n";
	print "<TD class=TableData noWrap colspan=\"2\">\n";
	//#########################################################
	print "<select class=\"SmallSelect\" name=\"$showfield\" onkeydown=\"if(event.keyCode==13)event.keyCode=9\" >\n";
	//����������
	while(!$rs->EOF)			{
		if($value==$rs->fields['USER_PRIV'])
				$temp='selected';
		
		//�������
		print "<option value=\"".$rs->fields['USER_PRIV']."\" $temp>".$rs->fields['PRIV_NAME']."</option>\n";
		$temp='';
		$rs->MoveNext();
	}
	print "</select>\n";
	
	print "</TD></TR>\n";
}
//ֻ�г���Ȩ�޲鿴�Ĳֿ�
function print_select_Stock($showtext,$showfield,$value)		{
	global $db,$_GET;
	global $_SESSION,$common_html;

	$USER_PRIV_ID = $_SESSION['STORE_PRIV'];

	$sql="select * from stock where 1=1";
	if($_SESSION['LOGIN_USER_PRIV']!='1')
		$sql.=" and ROWID in (".$USER_PRIV_ID.")";
	
	$rs=$db->CacheExecute(30,$sql);
	print "<TR>";
	print "<TD class=TableData noWrap>".$showtext."</TD>\n";
	print "<TD class=TableData noWrap colspan=\"2\">\n";
	//#########################################################
	print "<select class=\"SmallSelect\" name=\"$showfield\" onkeydown=\"if(event.keyCode==13)event.keyCode=9\" >\n";
	//����������
	while(!$rs->EOF)			{
		if($value==$rs->fields['ROWID'])
				$temp='selected';
		
		//�������
		print "<option value=\"".$rs->fields['ROWID']."\" $temp>".$rs->fields['name']."</option>\n";
		$temp='';
		$rs->MoveNext();
	}
	print "</select>\n";
	if($rs->RecordCount()==0)
	{
		if($USER_PRIV_ID=='0' || $USER_PRIV_ID=='')
			print "<span style='color:red'>��ǰ�û�û�вֿ����Ȩ�ޣ����ڻ�������-�ֿ���������</span>";
		else
			print "<span style='color:red'>û�вֿ⣬���ȴ����ֿ⣬���ڻ�������-�ֿ���������</span>";
	}
	print "</TD></TR>\n";
}
function print_select2($showtext,$showfield,$showfieldValue,$value,$tablename,$field_value,$field_name,$colspan=1)		{
	global $db,$_GET;

	//�û�������������##########################��ʼ
	global $fields;
	//print_R($fields['USER_PRIVATE'][$showfield]);
	if($fields['USER_PRIVATE'][$showfield]!="")	{
		$readonly = $fields['USER_PRIVATE'][$showfield];
		$class = "SmallStatic";
	}
	else	{
		$readonly = "";
		$class = "SmallSelect";
	}
	//�û�������������##########################����

	//ʵʱ���½�������˵��
	$showtext = FilterFieldName($showtext,$showfield);

	$sql="select distinct $field_value,$field_name from $tablename";

	$rs=$db->CacheExecute(30,$sql);
	print "<TR>";
	print "<TD class=TableData noWrap>".$showtext."</TD>\n";
	print "<TD class=TableData noWrap colspan=\"$colspan\">\n";
	print "<select class=\"$class\" name=\"$showfield\" $readonly  title='".$fields['USER_PRIVATE_TEXT'][$showfield]."' onkeydown=\"if(event.keyCode==13)event.keyCode=9\" >\n";
	print "<option value=\"\" $temp>=======</option>\n";
	while(!$rs->EOF)			{
		if($value==$rs->fields[$field_value]||$_GET[$showfield]==$rs->fields[$field_value])		$temp='selected';
		print "<option value=\"".$rs->fields[$field_value]."\" $temp>".$rs->fields[$field_name]."</option>\n";
		$temp='';
		$rs->MoveNext();
	}
	print "</select>\n";
	$showfieldValueName = returntablefield($tablename,$field_value,$value,$field_name);
	print "<input type=hidden name=$showfieldValue value=\"$showfieldValueName\">\n";
	print $addtext = FilterFieldAddText($addtext,$showfield);
	print "</TD></TR>\n";
}

//�˺������ڷ��ص�����SELECT��MENU��HTMLֵ��
function print_select_single_select($showfield,$value,$tablename,$field_value,$field_name,$colspan=1)		{
	global $db,$_GET;
	$sql="select `$field_value`,`$field_name` from `$tablename`";
	
	$rs=$db->CacheExecute(30,$sql);//print_R($rs->GetArray());
	print "<select class=\"SmallSelect\" name=\"$showfield\" onkeydown=\"if(event.keyCode==13)event.keyCode=9\" >\n";
	print "<option value=\"\">-ȫ��-</option>\n";
	while(!$rs->EOF)			{
		if($value==$rs->fields[$field_value])		$temp='selected';
		print "<option value=\"".$rs->fields[$field_value]."\" $temp>".$rs->fields[$field_name]."</option>\n";
		$temp='';
		$rs->MoveNext();
	}
	print "</select>\n";
}

//�˺������ڷ��ص�����SELECT��MENU��HTMLֵ��
function print_select_single_select2($showfield,$initvalue,$tablename,$field_value,$field_name,$value='',$groupfield='',$groupvalue='')		{
	global $db,$_GET;
	if($groupfield!=""&&$groupvalue!="")		{
		$sql="select `$field_value`,`$field_name` from `$tablename` where $groupfield='$groupvalue'";
	}
	else	{
		$sql="select `$field_value`,`$field_name` from `$tablename`";
	}
	//print $sql;

	$rs=$db->CacheExecute(30,$sql);//print_R($rs->GetArray());
	print "<select class=\"SmallSelect\" name=\"$showfield\" id=\"$showfield\" onkeydown=\"if(event.keyCode==13)event.keyCode=9\" >\n";
	while(!$rs->EOF)			{
		if($initvalue==$rs->fields[$field_value])		$temp='selected';
		if($value==$rs->fields[$field_value])		$temp='selected';
		print "<option value=\"".$rs->fields[$field_value]."\" $temp>".$rs->fields[$field_name]."</option>\n";
		$temp='';
		$rs->MoveNext();
	}
	print "</select>\n";
}


function return_select_filter($mode,$value)	{
	$array=return_select_array($mode);
	return $array[$value];
}
function return_select_array($mode)			{
	global $common_html;
	switch($mode)	{
		case 'select_sms':
			$array=array($common_html['common_html']['sms0'],$common_html['common_html']['sms1'],$common_html['common_html']['sms2'],$common_html['common_html']['sms3'],$common_html['common_html']['sms4'],$common_html['common_html']['sms5'],$common_html['common_html']['sms6'],$common_html['common_html']['sms7'],$common_html['common_html']['sms8']);
			break;
		case 'sms_self_status':
			$index0="<img src=\"images/avatar/1.gif\" alt=\"".$common_html['common_html']['sms_type0']."\">";
			$index1="<img src=\"images/sms_type1.gif\" alt=\"".$common_html['common_html']['sms_type1']."\">";
			$index2="<img src=\"images/sms_type2.gif\" alt=\"".$common_html['common_html']['sms_type2']."\">";
			$index3="<img src=\"images/sms_type3.gif\" alt=\"".$common_html['common_html']['sms_type3']."\">";
			$index4="<img src=\"images/sms_type4.gif\" alt=\"".$common_html['common_html']['sms_type4']."\">";
			$index5="<img src=\"images/sms_type5.gif\" alt=\"".$common_html['common_html']['sms_type5']."\">";
			$index6="<img src=\"images/sms_type6.gif\" alt=\"".$common_html['common_html']['sms_type6']."\">";
			$index7="<img src=\"images/sms_type7.gif\" alt=\"".$common_html['common_html']['sms_type7']."\">";
			$array=array($index0,$index1,$index2,$index3,$index4,$index5,$index6,$index7);
			break;
		case 'sms_self_status_text':
			$index0="<img src=\"images/avatar/1.gif\" alt=\"".$common_html['common_html']['sms_type0']."\">".$common_html['common_html']['sms_type0'];
			$index1="<img src=\"images/sms_type1.gif\" alt=\"".$common_html['common_html']['sms_type1']."\">".$common_html['common_html']['sms_type1'];
			$index2="<img src=\"images/sms_type2.gif\" alt=\"".$common_html['common_html']['sms_type2']."\">".$common_html['common_html']['sms_type2'];
			$index3="<img src=\"images/sms_type3.gif\" alt=\"".$common_html['common_html']['sms_type3']."\">".$common_html['common_html']['sms_type3'];
			$index4="<img src=\"images/sms_type4.gif\" alt=\"".$common_html['common_html']['sms_type4']."\">".$common_html['common_html']['sms_type4'];
			$index5="<img src=\"images/sms_type5.gif\" alt=\"".$common_html['common_html']['sms_type5']."\">".$common_html['common_html']['sms_type5'];
			$index6="<img src=\"images/sms_type6.gif\" alt=\"".$common_html['common_html']['sms_type6']."\">".$common_html['common_html']['sms_type6'];
			$index7="<img src=\"images/sms_type7.gif\" alt=\"".$common_html['common_html']['sms_type7']."\">".$common_html['common_html']['sms_type7'];
			$array=array($index0,$index1,$index2,$index3,$index4,$index5,$index6,$index7);
			break;
		case 'sms_delete_status':
			$index0="<img src=\"images/email.gif\" alt=\"".$common_html['common_html']['normal']."\">";
			$index1="<img src=\"images/email_delete.gif\" alt=\"".$common_html['common_html']['addresseedelete']."\">";
			$index2="<img src=\"images/email_delete.gif\" alt=\"".$common_html['common_html']['addresserdelete']."\">";
			$index3="<img src=\"images/email_delete.gif\" alt=\"".$common_html['common_html']['addresserdelete']."\">";
			$index4="<img src=\"images/email_delete.gif\" alt=\"".$common_html['common_html']['addresserdelete']."\">";
			$array=array($index0,$index1,$index2,$index3,$index4);
			break;
		case 'select_education':
			$array=array($common_html['common_html']['education0'],$common_html['common_html']['education1'],$common_html['common_html']['education2'],$common_html['common_html']['education3'],$common_html['common_html']['education4'],$common_html['common_html']['education5'],$common_html['common_html']['education6'],$common_html['common_html']['education7'],$common_html['common_html']['education8']);
			break;
		case 'select_politics':
			$array=array($common_html['common_html']['politics0'],$common_html['common_html']['politics1'],$common_html['common_html']['politics2'],$common_html['common_html']['politics3']);
			break;
		case 'select_marriage':
			$array=array($common_html['common_html']['marriage0'],$common_html['common_html']['marriage1']);
			break;
		case 'select_worklog':
			$array=array($common_html['common_html']['worklog'],$common_html['common_html']['personallog']);
			break;
		case 'email_read_status_outbox':
			$index0="<img src=\"images/email_close.gif\" alt=\"".$common_html['common_html']['addresseenew']."\">";
			$index1="<img src=\"images/email_open.gif\" alt=\"".$common_html['common_html']['addresseeread']."\">";
			$array=array($index0,$index1);
			break;
		case 'email_read_status_inbox':
			$index0="<img src=\"images/email_new.gif\" alt=\"".$common_html['common_html']['newmail']."\">";
			$index1="<img src=\"images/email_open.gif\" alt=\"".$common_html['common_html']['readmail']."\">";
			$array=array($index0,$index1);
			break;
		case 'email_delete_status_outbox':
			$index0="<img src=\"images/email.gif\" alt=\"".$common_html['common_html']['normal']."\">";
			$index1="<img src=\"images/email_delete.gif\" alt=\"".$common_html['common_html']['addresseedelete']."\">";
			$index2="<img src=\"images/email_delete.gif\" alt=\"".$common_html['common_html']['addresserdelete']."\">";
			$array=array($index0,$index1,$index2);
			break;
		case 'notify_read_status':
			$index0="<img src=\"images/new.gif\" alt=\"".$common_html['common_html']['newmail']."\">";
			$index1="<img src=\"images/notify.gif\" alt=\"".$common_html['common_html']['readmail']."\">";
			$array=array($index0,$index1);
			break;
		case 'userlang':
			$index0=$common_html['common_html']['zh'];
			$index1=$common_html['common_html']['en'];
			$array=array('zh'=>$index0,'en'=>$index1);
			break;

			//default :
			//$array=array($common_html['common_html']['sms0'],$common_html['common_html']['sms1']);
	}
	return $array;
}
function print_select_single($showtext,$var,$var_value="",$mode='select_sms',$addtext='',$colspan=1)	{
	global $common_html;
	//ʵʱ���½�������˵��
	$showtext = FilterFieldName($showtext,$showfield);

	//�û�������������##########################��ʼ
	global $fields;
	//print_R($fields['USER_PRIVATE'][$var]);
	if($fields['USER_PRIVATE'][$var]!="")	{
		$readonly = $fields['USER_PRIVATE'][$var];
		$class = "SmallStatic";
	}
	else	{
		$readonly = "";
		$class = "SmallSelect";
	}
	//�û�������������##########################����

	$array=return_select_array($mode);
	print "<TR>";
	print "<TD class=TableData noWrap>".$showtext."</TD>\n";
	print "<TD class=TableData noWrap colspan=\"$colspan\">\n";
	$array_keys=array_keys($array);//print_R($var_value);
	print "<select class=\"$class\" name=\"$var\" $readonly  onkeydown=\"if(event.keyCode==13)event.keyCode=9\">\n";
	for($i=0;$i<sizeof($array);$i++)		{
		if($var_value==$array_keys[$i])		$temp='selected';
		print "<option value=\"".$array_keys[$i]."\" $temp>".$array[(string)$array_keys[$i]]."</option>\n";
		$temp='';
	}
	print "</select>\n";
	print $addtext = FilterFieldAddText($addtext,$showfield);
	print "</TD></TR>\n";
}
function print_select_text($showtext,$value,$showfield,$tablename,$field_value,$field_name,$groupfield='',$groupvalue='',$colspan='2',$fieldfilter='select')		{
	global $db;
	 global $colflag;
	 if($colflag==0)
	 	$colspan=5;
	 if($colflag==1 || $colflag==0)
	 	print "<tr>\n";
	
	print "<TD class=TableContent noWrap>".$showtext."</TD>\n";
	print "<TD class=TableData noWrap colspan=\"$colspan\">\n";
	$hascolor=false;
	if(stristr($fieldfilter,'color'))
		$hascolor='true';
	
	$returnname=returntablefieldColorFilterGray($tablename,$field_value,$value,$field_name,'','',$hascolor);
	print $returnname;
	print "</TD>\n";
	if($colflag==2 || $colflag==0)
		print "</TR>\n";
}
function print_radio_sex($counter,$init)	{
	global $choose_lang,$html_etc,$array_sex;

	//�û�������������##########################��ʼ
	global $fields;
	//print_R($fields['USER_PRIVATE'][$var]);
	if($fields['USER_PRIVATE'][$var]!="")	{
		$readonly = $fields['USER_PRIVATE'][$var];
	}
	else	{
		$readonly = "";
	}
	//�û�������������##########################����

	$sizeof=sizeof($array_sex[$choose_lang]);
	for($i=0;$i<$sizeof;$i++)	{
		if($init==$i)	{
			print "<label><input type=\"radio\" $readonly  title='".$fields['USER_PRIVATE_TEXT'][$showfield]."' checked name=\"".$counter."_sex\" value=\"$i\"/>".$array_sex[$choose_lang][$i]."</label>";
		}
		else	{
			print "<label><input type=\"radio\" $readonly  title='".$fields['USER_PRIVATE_TEXT'][$showfield]."' name=\"".$counter."_sex\" value=\"$i\"/>".$array_sex[$choose_lang][$i]."</label>";
		}
	}
}
//$array=array("Сѧ","����","����","��ר","ר��","��","˶ʿ","��ʿ","��ʿ��");
function print_select_sms($init)		{
	global $choose_lang,$html_etc;
	$showtext[en]="SMS Sound";
	$showtext[zn]="����Ϣ����";
	print "<TR>";
	print "<TD class=TableData noWrap>".$showtext[$choose_lang]."�� </TD>\n";
	print "<TD class=TableData noWrap colspan=\"$colspan\">\n";
	print "<select class=\"SmallSelect\" name=\"sms\" onkeydown=\"if(event.keyCode==13)event.keyCode=9\">\n";
	$array[zh]=array("��","����1","����2","����","ˮ��","�ֻ�","�绰","����","OICQ");
	$array[en]=array("None","Sound1","Sound2","Compact","Water","Mobile","Telephone","chicken","OICQ");
	$sizeof=sizeof($array[$choose_lang]);
	if($init=="")		{	$init=1;	}
	for($i=0;$i<$sizeof;$i++)	{
		if($init==$i)	{
			print "<option value=\"$i\" selected>".$array[$choose_lang][$i]."</option>\n";
		}
		else	{
			print "<option value=\"$i\">".$array[$choose_lang][$i]."</option>\n";
		}
	}
	print "</select>\n";
	print "</TD></TR>\n";
}
//��ά��������
function array_sort($arr,$keys,$type='asc'){ 
	$keysvalue = $new_array = array();
	foreach ($arr as $k=>$v){
		$keysvalue[$k] = str_replace("%","", $v[$keys]);
	}
	if($type == 'asc'){
		asort($keysvalue);
	}else{
		arsort($keysvalue);
	}
	reset($keysvalue);
	foreach ($keysvalue as $k=>$v){
		$new_array[$k] = $arr[$k];
	}
	return $new_array; 
} 


?>