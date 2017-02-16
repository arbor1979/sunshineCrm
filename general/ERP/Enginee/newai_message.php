<?php



function SQL语句解析函数_应用于消息中心($sql,$操作记录编号)				{
	global $db,$MetaTables;
	//判断自定义表是否存在,如果不存在直接返回

	//判断是否是联合全操作,是否有子查询,是否用left
	//如果有,则表示为手写SQL代码,不是系统生成,则直接返回,不进行过滤
	$sql		= trim($sql);
	//转成小写
	$sqllower	= strtolower($sqllower);
	//缩进空格
	$sql = eregi_replace("  "," ",$sql);
	$sql = eregi_replace("  "," ",$sql);
	if(substr($sqllower,0,strlen("insert into"))=="insert into")		{
		$sqlArray = explode('insert into',$sql);
		$sqlArray = explode('values',$sqlArray[1]);
		$sqlArray = explode('(',$sqlArray[0]);
		$Tablename = ($sqlArray[0]);
		开始处理消息中心('INSERT',$Tablename,$数据字段,$操作记录编号);
	}
	if(substr($sqllower,0,strlen("update"))=="update")			{
		$sqlArray = explode('update',$sql);
		$sqlArray = explode('set',$sqlArray[1]);
		$Tablename = TRIM($sqlArray[0]);
	}
	if(substr($sqllower,0,strlen("delete from"))=="delete from")		{
		$sqlArray = explode('delete from',$sql);
		$sqlArray = explode(' ',$sqlArray[1]);
		$Tablename = TRIM($sqlArray[0]);
		开始处理消息中心('DELETE',$Tablename,$数据字段,$操作记录编号);
	}


}



function 开始处理消息中心($类型,$数据对象,$数据字段,$操作记录编号)				{
	global $db;

	if($类型=="UPDATE")					{
		$sql	= "select * from crm_clendar_rule where 类型='$类型' and 数据对象='$数据对象' and 数据字段='$数据字段'";
	}
	elseif($类型=="INSERT")					{
		$sql	= "select * from crm_clendar_rule where 类型='$类型' and 数据对象='$数据对象'";
	}
	elseif($类型=="DELETE")					{
		$sql	= "select * from crm_clendar_rule where 类型='$类型' and 数据对象='$数据对象'";
	}
	else	{
		return '';
	}

	//得到表结构信息
	$MetaColumnNames	= $db->MetaColumnNames($表名);
	$MetaColumnNames	= array_keys($MetaColumnNames);
	$主键				= $MetaColumnNames[0];

	$rs		= $db->CacheExecute(360,$sql);
	$rs_a	= $rs->GetArray();
	for($i=0;$i<sizeof($rs_a);$i++)				{
		$数据字段	= $rs_a[0]['数据字段'];
		$提醒周期	= $rs_a[0]['提醒周期'];
		$提醒对象	= $rs_a[0]['提醒对象'];
		$提醒人员	= $rs_a[0]['提醒人员'];
		$提醒内容模板 = $rs_a[0]['提醒内容模板'];
		$是否启用	= $rs_a[0]['是否启用'];
		$判断条件	= $rs_a[0]['判断条件'];
		$判断值		= $rs_a[0]['判断值'];
		$跳转路径	= $rs_a[0]['跳转路径'];

		//求得目标提醒人员
		$sql	= "select * from $数据对象 where $主键='$操作记录编号'";
		$rs2	= $db->CacheExecute(15,$sql);
		$rs2_a	= $rs2->GetArray();
		//判断提醒对象是否是本表字段
		if(in_array($提醒对象,$MetaColumnNames))		{
			//判断提醒对象是否存在于用户表内
			$USER_NAME = returntablefield("user","USER_ID",$rs2_a[0][$提醒对象],"USER_NAME");;
			if($USER_NAME!="")				{
				$求得目标提醒人员 = $rs2_a[0][$提醒对象];
			}
		}

		//对模板进行替换操作
		for($ix=0;$ix<sizeof($MetaColumnNames);$ix++)				{
			$FIELD_NAME		= $MetaColumnNames[$ix];
			$提醒内容模板	= ereg_replace("{$FIELD_NAME}",$rs_a[0][$FIELD_NAME],$提醒内容模板);
		}


		if($提醒人员!="")					{
			$求得目标提醒人员 = $提醒人员.",".$求得目标提醒人员;
		}

		发送消息_TDOASMS('admin',$求得目标提醒人员,$SMS_TYPE=0,$提醒内容模板,$跳转路径);
	}
}

//发送消息_TDOASMS('admin','admin,admin,人员',0,'你好,测试内容','EDU/Interface/URLID=?');

function 发送消息_TDOASMS($FROM_ID,$TO_ID,$SMS_TYPE,$CONTENT,$REMIND_URL)			{
	global $db;
	$SEND_TIME = date("Y-m-d H:i:s");
	$sql = "insert into TD_OA.sms_body values('','$FROM_ID','$SMS_TYPE','$CONTENT','$SEND_TIME','$REMIND_URL');";
	print $sql."<BR>";
	$rs  = $db->Execute($sql);
	$BODY_ID = $db->Insert_ID();
	//SMS_ID  TO_ID  REMIND_FLAG  DELETE_FLAG  BODY_ID  REMIND_TIME
	$TO_ID_ARRAY = explode(',',$TO_ID);
	for($i=0;$i<sizeof($TO_ID_ARRAY);$i++)				{
		$TD_ID_NAME = $TO_ID_ARRAY[$i];
		if($TD_ID_NAME!="")				{
			$REMIND_TIME = time();
			$sql = "insert into TD_OA.sms values('','$TD_ID_NAME','0','0','$BODY_ID','$REMIND_TIME')";
			print $sql."<BR>";
			$db->Execute($sql);
		}
	}

}




?>