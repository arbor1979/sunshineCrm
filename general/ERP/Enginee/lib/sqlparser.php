<?php





function SQL语句解析函数($sql)				{
	global $db,$MetaTables;
	//判断自定义表是否存在,如果不存在直接返回

	//判断是否是联合全操作,是否有子查询,是否用left
	//如果有,则表示为手写SQL代码,不是系统生成,则直接返回,不进行过滤
	$sql		= trim($sql);
	$sqllower	= strtolower($sqllower);
	if(substr($sqllower,0,strlen("create table"))=="create table")		{
		return $sql;
	}
	if(substr($sqllower,0,strlen("drop table"))=="drop table")			{
		return $sql;
	}
	if(substr($sqllower,0,strlen("check table"))=="check table")		{
		return $sql;
	}
	if(substr($sqllower,0,strlen("optimize table"))=="optimize table")	{
		return $sql;
	}
	if(substr($sqllower,0,strlen("repair table"))=="repair table")		{
		return $sql;
	}
	if(substr($sqllower,0,strlen("analyze table"))=="analyze table")	{
		return $sql;
	}

	//进行关键字过滤
	$sql = eregi_replace(" From "," from ",$sql);
	$sql = eregi_replace(" FROM "," from ",$sql);

	$sql = eregi_replace(" Where "," where ",$sql);
	$sql = eregi_replace(" WHERE "," where ",$sql);

	$sql = eregi_replace(" Select "," select ",$sql);
	$sql = eregi_replace(" SELECT "," select ",$sql);

	$sql = eregi_replace(" Order By "," order by ",$sql);
	$sql = eregi_replace(" ORDER BY "," order by ",$sql);

	$sql = eregi_replace(" Update "," update ",$sql);
	$sql = eregi_replace(" UPDATE "," update ",$sql);

	$sql = eregi_replace(" Delete "," delete ",$sql);
	$sql = eregi_replace(" DELETE "," delete ",$sql);

	$sql = eregi_replace(" Limit "," limit ",$sql);
	$sql = eregi_replace(" LIMITE "," limit ",$sql);

	$sql = eregi_replace(" Left "," left ",$sql);
	$sql = eregi_replace(" LEFT "," left ",$sql);

	//处理SELECT
	if(substr($sql,0,strlen("select "))=="select ")		{
		$FromArray = explode(" from ",$sql);
		//分析旧的SQL
		if($FromArray[1]!="")					{
			$FromSelectArray		= explode("select ",$FromArray[0]);
			$SQLArray['SelectText'] = $FromSelectArray[1];
			$FromWhereArray			= explode(" where ",$FromArray[1]);
			$SQLArray['FromText']	= $FromWhereArray[0];
			//如果是两个表,直接返回,不做处理
			$FromTablesArray		= explode(",",$SQLArray['FromText']);
			if($FromTablesArray[1]!='')			{
				print "两个表";
				return $sql;
			}
			//拆分数据库和表
			$FromDBArray			= explode(".",$SQLArray['FromText']);
			if($FromDBArray[1]!="")					{
				$SQLArray['FromText']	= $FromDBArray[1];
				$SQLArray['DBText']		= $FromDBArray[0];
			}
			$SQLArray['WhereText']	= $FromWhereArray[1];
			$FromOrderByArray		= explode(" order by ",$SQLArray['WhereText']);
			if($FromOrderByArray[1]!="")					{
				$SQLArray['WhereText']	= $FromOrderByArray[0];
				$SQLArray['OrderByText']= $FromOrderByArray[1];
			}
		}
		//处理新的SQL,之前要进行判断表自定义表是否存在
		$TABLENAME = $SQLArray['FromText'];
		$TABLENAME2 = "view_".$TABLENAME;
		if(in_array($TABLENAME2,$MetaTables))					{
			//自定义表存在
			$MetaColumnNames	= $db->MetaColumnNames($TABLENAME);
			$MetaColumnNames	= array_keys($MetaColumnNames);
			$原表主键	= $MetaColumnNames[0];
			$MetaColumnNames2	= $db->MetaColumnNames($TABLENAME2);
			$MetaColumnNames2	= array_keys($MetaColumnNames2);
			$新表主键	= $MetaColumnNames2[0];
			array_shift($MetaColumnNames2);
			$自定义表字段列表 = join(',',$MetaColumnNames2);
			$SQLArray['SelectText'] .= ",".$自定义表字段列表;
			$SQLArray['FromText']	.= ",".$TABLENAME2;
			if($SQLArray['WhereText']!="")		{
				$SQLArray['WhereText'] .= " and ".$TABLENAME.".".$原表主键."=".$TABLENAME2.".".$新表主键."";
			}
			else	{
				$SQLArray['WhereText']  = " ".$TABLENAME.".".$原表主键."=".$TABLENAME2.".".$新表主键."";
			}
		}
		else	{
			//不存在,直接返回
			return $sql;
		}
		//形成新的SQL文件
		$NEWTEXTSQL = "select ".$SQLArray['SelectText']." from ".$SQLArray['FromText']."";
		if(TRIM($SQLArray['WhereText'])!="")		{
			$NEWTEXTSQL .=" where ".$SQLArray['WhereText'];
		}
		if(TRIM($SQLArray['OrderByText'])!="")		{
			$NEWTEXTSQL .=" order by ".$SQLArray['WhereText'];
		}
		//形成后返回
		return $NEWTEXTSQL;
		//SELECT  部分结束
	}

	//UPDATE

	//DELETE

	//INSERT INTO



	print_R($NEWTEXTSQL);
	print_R($SQLArray);


}


?>