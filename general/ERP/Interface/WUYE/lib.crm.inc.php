<?php
function CRM系统过滤个人权限()				{
	global $db,$_SESSION,$SYSTEM_PRINT_SQL;
	$LOGIN_USER_ID = $_SESSION['LOGIN_USER_ID'];
	$_GET['创建人'] = $LOGIN_USER_ID;
	//$SYSTEM_PRINT_SQL = 1;
}

function CRM系统过滤部门权限()				{
	global $db,$_SESSION,$SYSTEM_PRINT_SQL;
	$LOGIN_USER_ID = $_SESSION['LOGIN_USER_ID'];
	//$SYSTEM_PRINT_SQL = 1;
	$sql = "select MODULE from systemprivateinc where FILE='crm_customer_newai.php' and USER_ID like '%".$LOGIN_USER_ID.",%'";
	//print $sql;
	$rs = $db->CacheExecute(150,$sql);
	$rs_a = $rs->GetArray();
	$部门名称 = array();
	for($i=0;$i<sizeof($rs_a);$i++)			{
		$部门名称[] = $rs_a[$i]['MODULE'];
	}
	$部门名称TEXT = "'".join("'",$部门名称)."'";
	$sql = "	select USER_ID from user,department
				where
				user.DEPT_ID=department.DEPT_ID
				and department.DEPT_NAME in ($部门名称TEXT)
				";
	//print $sql;
	$rs = $db->CacheExecute(150,$sql);
	$rs_a = $rs->GetArray();
	$USER_ID_ARRAY = array();
	for($i=0;$i<sizeof($rs_a);$i++)			{
		$USER_ID_ARRAY[] = $rs_a[$i]['USER_ID'];
	}
	$USER_ID_TEXT = join(',',$USER_ID_ARRAY);
	$_GET['创建人'] = $USER_ID_TEXT;
}


//消息处理引擎();

function 消息处理引擎()				{
	global $db,$_SESSION,$SYSTEM_PRINT_SQL;
	$LOGIN_USER_ID = $_SESSION['LOGIN_USER_ID'];
	$sql = "select * from crm_clendar_rule where 是否启用='是'";
	$rs = $db->Execute($sql);
	$rs_a = $rs->GetArray();
	//数据对象  数据字段  提醒周期  提醒对象  提醒内容模板
	for($i=0;$i<sizeof($rs_a);$i++)			{
		$规则编号 = $rs_a[$i]['编号'];
		$数据对象 = $rs_a[$i]['数据对象'];
		$数据字段 = $rs_a[$i]['数据字段'];
		$提醒周期 = $rs_a[$i]['提醒周期'];
		$提醒对象 = $rs_a[$i]['提醒对象'];
		$提醒内容模板 = $rs_a[$i]['提醒内容模板'];
		消息处理引擎之生成消息($数据对象,$数据字段,$提醒周期,$提醒对象,$提醒内容模板,$规则编号);
	}
	//$SYSTEM_PRINT_SQL = 1;
}


function 消息处理引擎之生成消息($数据对象,$数据字段,$提醒周期,$提醒对象,$提醒内容模板,$规则编号)				{
	global $db,$_SESSION,$SYSTEM_PRINT_SQL;
	$LOGIN_USER_ID = $_SESSION['LOGIN_USER_ID'];
	$提醒内容模板 = ereg_replace('{','{$',$提醒内容模板);
	$sql = "select * from $数据对象 where 编号 not in (
				select 记录编号 from crm_clendar
				where 数据对象='$数据对象'
				and 数据字段='$数据字段'
				and 数据字段='$数据字段'
				and 提醒周期='$提醒周期'
				and 提醒对象='$提醒对象'
				)
				and $数据字段!=''";
	//print $sql."<BR>";
	$rs = $db->Execute($sql);
	$rs_a = $rs->GetArray();
	//print $提醒内容模板."<BR>";
	for($i=0;$i<sizeof($rs_a);$i++)							{
		$Element = $rs_a[$i];
		//print_R($Element);
		$ElementKeys = array_keys($Element);
		for($ix=0;$ix<sizeof($ElementKeys);$ix++)			{
			$ElementName = $ElementKeys[$ix];
			$$ElementName = $Element[$ElementName];
			$提醒内容模板 = ereg_replace('\$'.$ElementName,$Element[$ElementName],$提醒内容模板);
			//print $ElementName.$$ElementName.$提醒内容模板."<BR>";
		}

		$提醒内容模板 = ereg_replace('{','',$提醒内容模板);
		$提醒内容模板 = ereg_replace('}','',$提醒内容模板);

		$用户名		= $$提醒对象;
		$用户信息	= returntablefield("user","USER_ID",$用户名,"USER_NAME,DEPT_ID");;
		$用户姓名	= $用户信息['USER_NAME'];
		$DEPT_NAME	= returntablefield("department","DEPT_ID",$用户信息['DEPT_ID'],"DEPT_NAME");;

		$数据字段_ARRAY = explode('-',$$数据字段);
		//print_R($数据字段_ARRAY);
		$提醒时间		= date("Y-m-d",mktime(1,1,1,$数据字段_ARRAY[1],$数据字段_ARRAY[2]-$提醒周期,$数据字段_ARRAY[0]));
		$INSERTINTO['用户名'] = $用户名;
		$INSERTINTO['用户姓名'] = $用户姓名;
		$INSERTINTO['部门'] = $DEPT_NAME;
		$INSERTINTO['规则'] = $规则编号;
		$INSERTINTO['类型'] = "时间提醒";
		$INSERTINTO['提醒时间'] = $提醒时间;
		$INSERTINTO['提醒内容'] = $提醒内容模板;
		$INSERTINTO['处理情况'] = '';
		$INSERTINTO['备注'] = '';
		$INSERTINTO['创建人'] = $用户名;
		$INSERTINTO['创建时间'] = date("Y-m-d H:i:s");
		$INSERTINTO['数据对象'] = $数据对象;
		$INSERTINTO['数据字段'] = $数据字段;
		$INSERTINTO['提醒周期'] = $提醒周期;
		$INSERTINTO['提醒对象'] = $提醒对象;
		$INSERTINTO['记录编号'] = $编号;

		$INSERTINTOKEYS		= array_keys($INSERTINTO);
		$INSERTINTOVALUES	= array_values($INSERTINTO);
		$INSERTINTOKEYSTEXT = join(',',$INSERTINTOKEYS);
		$INSERTINTOVALUESTEXT = "'".join("','",$INSERTINTOVALUES)."'";
		$sql = "insert into crm_clendar ($INSERTINTOKEYSTEXT) values($INSERTINTOVALUESTEXT) ";
		$db->Execute($sql);
		//print $sql."<BR>";

		//print $提醒内容模板."<BR>";
		//exit;
		//$SYSTEM_PRINT_SQL = 1;
	}
}


?>