<?php





function SQL����������($sql)				{
	global $db,$MetaTables;
	//�ж��Զ�����Ƿ����,���������ֱ�ӷ���

	//�ж��Ƿ�������ȫ����,�Ƿ����Ӳ�ѯ,�Ƿ���left
	//�����,���ʾΪ��дSQL����,����ϵͳ����,��ֱ�ӷ���,�����й���
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

	//���йؼ��ֹ���
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

	//����SELECT
	if(substr($sql,0,strlen("select "))=="select ")		{
		$FromArray = explode(" from ",$sql);
		//�����ɵ�SQL
		if($FromArray[1]!="")					{
			$FromSelectArray		= explode("select ",$FromArray[0]);
			$SQLArray['SelectText'] = $FromSelectArray[1];
			$FromWhereArray			= explode(" where ",$FromArray[1]);
			$SQLArray['FromText']	= $FromWhereArray[0];
			//�����������,ֱ�ӷ���,��������
			$FromTablesArray		= explode(",",$SQLArray['FromText']);
			if($FromTablesArray[1]!='')			{
				print "������";
				return $sql;
			}
			//������ݿ�ͱ�
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
		//�����µ�SQL,֮ǰҪ�����жϱ��Զ�����Ƿ����
		$TABLENAME = $SQLArray['FromText'];
		$TABLENAME2 = "view_".$TABLENAME;
		if(in_array($TABLENAME2,$MetaTables))					{
			//�Զ�������
			$MetaColumnNames	= $db->MetaColumnNames($TABLENAME);
			$MetaColumnNames	= array_keys($MetaColumnNames);
			$ԭ������	= $MetaColumnNames[0];
			$MetaColumnNames2	= $db->MetaColumnNames($TABLENAME2);
			$MetaColumnNames2	= array_keys($MetaColumnNames2);
			$�±�����	= $MetaColumnNames2[0];
			array_shift($MetaColumnNames2);
			$�Զ�����ֶ��б� = join(',',$MetaColumnNames2);
			$SQLArray['SelectText'] .= ",".$�Զ�����ֶ��б�;
			$SQLArray['FromText']	.= ",".$TABLENAME2;
			if($SQLArray['WhereText']!="")		{
				$SQLArray['WhereText'] .= " and ".$TABLENAME.".".$ԭ������."=".$TABLENAME2.".".$�±�����."";
			}
			else	{
				$SQLArray['WhereText']  = " ".$TABLENAME.".".$ԭ������."=".$TABLENAME2.".".$�±�����."";
			}
		}
		else	{
			//������,ֱ�ӷ���
			return $sql;
		}
		//�γ��µ�SQL�ļ�
		$NEWTEXTSQL = "select ".$SQLArray['SelectText']." from ".$SQLArray['FromText']."";
		if(TRIM($SQLArray['WhereText'])!="")		{
			$NEWTEXTSQL .=" where ".$SQLArray['WhereText'];
		}
		if(TRIM($SQLArray['OrderByText'])!="")		{
			$NEWTEXTSQL .=" order by ".$SQLArray['WhereText'];
		}
		//�γɺ󷵻�
		return $NEWTEXTSQL;
		//SELECT  ���ֽ���
	}

	//UPDATE

	//DELETE

	//INSERT INTO



	print_R($NEWTEXTSQL);
	print_R($SQLArray);


}


?>