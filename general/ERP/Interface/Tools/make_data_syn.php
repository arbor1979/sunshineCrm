<?
ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL);

// display warnings and errors
error_reporting(E_WARNING | E_ERROR);



require_once("lib.inc.php");

/*

$MetaTables = $db->MetaTables();
page_css("make_data_syn");
//print_R($MetaTables);
//$MetaTables[0] = "edu_student";
//sizeof($MetaTables) = 20;
for($I = 0; $I < sizeof($MetaTables); $I++) {
	$tablename = $MetaTables[$I];
	$sql = "SHOW FULL COLUMNS FROM $tablename";
	$rs = $db->Execute($sql);
	$rs_a= $rs->GetArray();
	//print_R($rs_a);
	for($IX = 0; $IX < sizeof($rs_a); $IX++)	{
		$������ = $rs_a[$IX]['Field'];
		$�������� = $rs_a[$IX]['Type'];
		$Ĭ��ֵ = $rs_a[$IX]['Default'];
		if($������=="�γ�����"||$������=="�γ�")			{
			$�γ��ı�[] = "update $tablename set $������='\$��ֵ' where $������='\$��ֵ'";
			//exit;
		}
		if($������=="��������"||$������=="����")			{
			$�����ı�[] = "update $tablename set $������='\$��ֵ' where $������='\$��ֵ'";
			//exit;
		}
		if($������=="�༶����"||$������=="�༶"||$������=="���")			{
			$�༶�ı�[] = "update $tablename set $������='\$��ֵ' where $������='\$��ֵ'";
			//exit;
		}
		if($������=="ѧ������"||$������=="ѧ��")			{
			$ѧ���ı�[] = "update $tablename set $������='\$��ֵ' where $������='\$��ֵ'";
			//exit;
		}
		if($������=="�̲�����"||$������=="�̲�")			{
			$�̲��ı�[] = "update $tablename set $������='\$��ֵ' where $������='\$��ֵ'";
			//exit;
		}
		if($������=="רҵ����"||$������=="רҵ")			{
			$רҵ�ı�[] = "update $tablename set $������='\$��ֵ' where $������='\$��ֵ'";
			//exit;
		}
		if($������=="ϵ����"||$������=="ϵ"||$������=="Ժϵ"||$������=="רҵ��")			{
			$ϵ�ı�[] = "update $tablename set $������='\$��ֵ' where $������='\$��ֵ'";
			//exit;
		}
		if($������=="ѧ��"||$������=="ѧ��ѧ��")			{
			$ѧ���ı�[] = "update $tablename set $������='\$��ֵ' where $������='\$��ֵ'";
			//exit;
		}
		if($������=="����"||$������=="ѧ������")			{
			$�����ı�[] = "update $tablename set $������='\$��ֵ' where $������='\$��ֵ'";
			//exit;
		}
	}
}


$INARRAY = array("�γ�","����","�༶","ѧ��","רҵ","ϵ","����","ѧ��","�̲�");

for($iX=0;$iX<sizeof($INARRAY);$iX++)				{
	$������ = $INARRAY[$iX];
	print "function �޸�ʱͬ��{$������}����(\$��ֵ,\$��ֵ)		{<BR>
	&nbsp;&nbsp;global \$_GET,\$_POST,\$db;<BR>
	&nbsp;&nbsp;if(\$��ֵ==\$��ֵ)		{<BR>&nbsp;&nbsp;&nbsp;&nbsp;return '';<BR>&nbsp;&nbsp;}<BR>";
	$����ֵ = $������."�ı�";
	$����ֵ2 = $$����ֵ;
	for($i=0;$i<sizeof($����ֵ2);$i++)				{
		print "&nbsp;&nbsp;\$sql = \"".$����ֵ2[$i]."\";<BR>
		&nbsp;&nbsp;\$db->Execute(\$sql);<BR>";
	}
	print "}<BR>";
}




exit;
*/

//##############################################################################
require_once("lib.inc.php");
//$MetaTables = $db->MetaTables();
//print_R($MetaTables);
//$MetaTables[0] = "edu_student";
$sql = "show table status";
$rs  = $db->Execute($sql);
$MetaTablesRSA = $rs->GetArray();
for($Ixx = 0; $Ixx < sizeof($MetaTablesRSA); $Ixx++) {
	$tablename = $MetaTablesRSA[$Ixx]['Name'];
	$Collation = $MetaTablesRSA[$Ixx]['Collation'];
	if($Collation!="gbk_chinese_ci")				{
		$sql = "ALTER TABLE `".$tablename."` DEFAULT CHARACTER SET gbk COLLATE gbk_chinese_ci;";
		print $sql."<BR>";
		$db->Execute($sql);
	}
	$sql = "SHOW FULL COLUMNS FROM $tablename";
	$rs = $db->Execute($sql);
	$rs_a= $rs->GetArray();
	//print_R($rs_a);
	//
	for($IX = 0; $IX < sizeof($rs_a); $IX++)					{
		if($rs_a[$IX]['Collation']=="gbk_bin")				{
			$sql = "ALTER TABLE `$tablename` CHANGE `".$rs_a[$IX]['Field']."` `".$rs_a[$IX]['Field']."` ".$rs_a[$IX]['Type']." CHARACTER SET gbk COLLATE gbk_chinese_ci NOT NULL DEFAULT '".$rs_a[$IX]['Default']."';";
			print $sql."<BR>";
			$db->Execute($sql);
		}
	}
	//exit;
}
?>