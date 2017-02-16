<?php
ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL);

// display warnings and errors
error_reporting(E_WARNING | E_ERROR);

require_once('../../../adodb/adodb.inc.php');
require_once('../../../config.inc.php');
require_once('../../../setting.inc.php');
require_once('../../../adodb/session/adodb-session2.php');
$GLOBAL_SESSION=returnsession();

$DEPT_PARENT = $_GET['DEPT_ID'];
$DEPT_PARENT == "" ? $DEPT_PARENT =0 : "" ;
$PARA_URL1 = $_GET['PARA_URL1'];

print "<?phpxml version=\"1.0\" encoding=\"gb2312\"?>\r\n";
print "<TreeNode>\r\n";

if($PARA_URL1=="ts")
{
	//�õ���Ʒ�б�
	$sql = "select * from product where producttype='$DEPT_PARENT' order by productname,mode,standard";
	$rs = $db->Execute($sql);
	$rs_a = $rs->GetArray();
	for($i=0;$i<sizeof($rs_a);$i++)			
	{
		$productId=$rs_a[$i]['productid'];
		$productName=$rs_a[$i]['productname'];
		if($rs_a[$i]['mode']!="")
			$productName=$productName."/".$rs_a[$i]['mode'];
		if($rs_a[$i]['standard']!="")
			$productName=$productName."/".$rs_a[$i]['standard'];	
		print "<TreeNode id=\"$productId\"
		text=\"".$productName."\"
		href=\"javascript:addProduct('$productId','$productName');\"
		img_src=\"images/item.gif\" 
		 />\r\n";
	}
}
else 
{
//��˾����
if($DEPT_PARENT==0)				
{
	print "<TreeNode id=\"0\" text=\"��������\" Xml=\"\" img_src=\"images/endnode.gif\" >\r\n";
}
//��Ʒ���������û���
$sql = "select producttype,COUNT(*) AS NUM  from product group by producttype";
$rs = $db->Execute($sql);
$rs_a = $rs->GetArray();
for($i=0;$i<sizeof($rs_a);$i++)			
{
	$DEPT_ID	= $rs_a[$i]['producttype'];
	$NUM		= $rs_a[$i]['NUM'];
	$�û���������[$DEPT_ID] = "[".$NUM."��]";
}

//�õ��������Լ�û���з���Ĳ�����Ϣ
$sql = "select rowid,name,parentid from producttype where parentid='$DEPT_PARENT' order by parentid asc ,id asc";
$rs = $db->Execute($sql);
$rs_a = $rs->GetArray();
for($i=0;$i<sizeof($rs_a);$i++)			
{
	$DEPT_ID = $rs_a[$i]['rowid'];
	$DEPT_NAME = $rs_a[$i]['name'];
	$DEPT_PARENT = $rs_a[$i]['parentid'];
	$sql = "select rowid,name,parentid  from producttype where parentid='$DEPT_ID' order by parentid asc ,id asc";
	$rs2 = $db->Execute($sql);
	$rs2_a = $rs2->GetArray();
	if($rs2_a[0]['rowid']!='')				
	{//�������Ӳ���
		print "<TreeNode id=\"$DEPT_ID\"
		text=\"".$DEPT_NAME."".$�û���������[$DEPT_ID]."\"
		img_src=\"images/endnode.gif\"
		title=\"$DEPT_NAME\"
		Xml=\"./inc_prod_tree.php?DEPT_ID=$DEPT_ID\"
		 />\r\n";
	}
	else	
	{//����û���Ӳ���
		$sql = "select *  from product where producttype='$DEPT_ID'";
		$rs2 = $db->Execute($sql);
		$rs2_a = $rs2->GetArray();
		
		if(sizeof($rs2_a)>=1)				//�����в�Ʒ
		{
			print "<TreeNode id=\"$DEPT_ID\" text=\"".$DEPT_NAME."".$�û���������[$DEPT_ID]."\" img_src=\"images/ts.gif\" title=\"$DEPT_NAME\"
			Xml=\"./inc_prod_tree.php?DEPT_ID=$DEPT_ID&amp;PARA_URL1=ts\"
			/>\r\n";
		}
		else 
			print "<TreeNode id=\"$DEPT_ID\" text=\"".$DEPT_NAME."".$�û���������[$DEPT_ID]."\" img_src=\"images/endnode.gif\" title=\"$DEPT_NAME\"/>\r\n";
	}
}
if($DEPT_PARENT==0)				
	print "</TreeNode>\r\n";
}
print "</TreeNode>\r\n";


?>