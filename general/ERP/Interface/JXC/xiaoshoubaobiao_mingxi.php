<?php
ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL);
error_reporting(E_WARNING | E_ERROR);
require_once('lib.inc.php');
$GLOBAL_SESSION=returnsession();
validateMenuPriv("�����ձ�");
global $db;
if(!empty($_GET['start_time'])) {
	$start_time = $_GET['start_time'];
}else{
	exit('ȱ�ٲ���');
}

if(!empty($_GET['end_time'])) {
	$end_time = $_GET['end_time'];
}else{
	exit('ȱ�ٲ���');
}

if(!empty($_GET['createman'])) {
	$createman = $_GET['createman'];
}else{
	exit('ȱ�ٲ���');
}
$where='';

$data = array();
if($_GET['where'] == 'yishou') {

	$head=array("id"=>"����","supplyname"=>"�ͻ�����","USER_NAME"=>"����Ա","opertype"=>"����","bankname"=>"�ʻ�","jine"=>"����","createtime"=>"����ʱ��");
	$headtype=array("id"=>"char","supplyname"=>"string","USER_NAME"=>"char","opertype"=>"char","bankname"=>"char","jine"=>"float","createtime"=>"string");
	$title="������ȡ��ϸ";
	$sumcol=array("jine"=>"");
	$sql= "SELECT e.billid as id,d.bankname,a.oldjine,`a`.`jine`,a.opertype,b.USER_NAME,a.createtime,f.supplyname FROM accessbank a LEFT JOIN user b ON a.createman = b.USER_ID left JOIN bank d ON a.bankid=d.ROWID left JOIN sellplanmain e ON a.guanlianbillid=e.billid left JOIN customer f ON e.supplyid=f.ROWID where (`a`.`opertype`='������ȡ' or `a`.`opertype`='��Ѻ��' or `a`.`opertype`='Ƿ����ȡ') and a.createman='".$createman."' AND a.createtime>='".$start_time."' AND a.createtime<='".$end_time."'";

}elseif($_GET['where'] == 'yushouyufu'){

	$head=array("id"=>"����","supplyname"=>"�ͻ�����","USER_NAME"=>"����Ա","opertype"=>"����","bankname"=>"�ʻ�","shouru"=>"����","zhichu"=>"֧��","createtime"=>"����ʱ��");
	$headtype=array("id"=>"char","supplyname"=>"string","USER_NAME"=>"char","opertype"=>"char","bankname"=>"char","shouru"=>"float","zhichu"=>"float","createtime"=>"string");
	$title="Ԥ��Ԥ����ϸ";
	$sumcol=array("shouru"=>"","zhichu"=>"");
	$sql = "SELECT a.guanlianbillid as id,d.bankname,a.oldjine,if(a.opertype='Ԥ�ջ���',`a`.`jine`,0) as shouru,if(a.opertype='Ԥ������',-`a`.`jine`,0) as zhichu,a.opertype,b.USER_NAME,a.createtime FROM accessbank a LEFT JOIN user b ON a.createman = b.USER_ID left JOIN bank d ON a.bankid=d.ROWID  where (`a`.`opertype`='Ԥ�ջ���' or `a`.`opertype`='Ԥ������') and a.createman='".$createman."' AND a.createtime>='".$start_time."' AND a.createtime<='".$end_time."'";

	
}elseif($_GET['where'] == 'huokuanzhifu'){

	$head=array("id"=>"����","supplyname"=>"��Ӧ������","USER_NAME"=>"����Ա","opertype"=>"����","bankname"=>"�ʻ�","jine"=>"֧��","createtime"=>"����ʱ��");
	$headtype=array("id"=>"char","supplyname"=>"string","USER_NAME"=>"char","opertype"=>"char","bankname"=>"char","jine"=>"float","createtime"=>"string");
	$title="����֧����ϸ";
	$sumcol=array("jine"=>"");
	$sql = "SELECT e.billid as id,d.bankname,a.oldjine,-`a`.`jine` as jine,a.opertype,b.USER_NAME,a.createtime,f.supplyname FROM accessbank a LEFT JOIN user b ON a.createman = b.USER_ID left JOIN bank d ON a.bankid=d.ROWID left JOIN sellplanmain e ON a.guanlianbillid=e.billid left JOIN customer f ON e.supplyid=f.ROWID where `a`.`opertype`='����֧��' and a.createman='".$createman."' AND a.createtime>='".$start_time."' AND a.createtime<='".$end_time."'";

}elseif($_GET['where'] == 'qitashouzhi'){

	$head=array("id"=>"����","USER_NAME"=>"����Ա","opertype"=>"����","bankname"=>"�ʻ�","shouru"=>"����","zhichu"=>"֧��","createtime"=>"����ʱ��");
	$headtype=array("id"=>"char","USER_NAME"=>"char","opertype"=>"char","bankname"=>"char","shouru"=>"float","zhichu"=>"float","createtime"=>"string");
	$title="��������֧����ϸ";
	$sumcol=array("shouru"=>"","zhichu"=>"");
	$sql = "SELECT a.billid as id,d.typename as opertype,g.bankname,if(a.opertype='��������',`a`.`jine`,0) as shouru,if(a.opertype='����֧��',`a`.`jine`,0) as zhichu,b.USER_NAME,a.createtime FROM accessbank a left join feiyongrecord a on a.guanlianbillid=a.billid LEFT JOIN user b ON a.createman = b.USER_ID left JOIN feiyongtype d ON a.typeid=d.id left JOIN bank g ON a.accountid=g.ROWID where (`a`.`opertype`='��������' or `a`.`opertype`='����֧��')  and a.createman='".$createman."' AND a.createtime>='".$start_time."' AND a.createtime<='".$end_time."'";

}elseif($_GET['where'] == 'allmoney'){

	$head=array("bankname"=>"�˻�����","alljine"=>"��֧���");
	$headtype=array("bankname"=>"char","alljine"=>"float");
	$title="���˻�����";
	$sumcol=array("shouru"=>"","zhichu"=>"");
	$sql = "SELECT a.bankid,g.bankname,sum(a.jine) as alljine FROM accessbank a left JOIN bank g ON a.bankid=g.ROWID where a.createman='".$createman."' AND a.createtime>='".$start_time."' AND a.createtime<='".$end_time."' group by a.bankid,g.bankname";

}

if($_GET['bankid']>0 && $_GET['where'] != 'allmoney')
{
	$sql.=" and a.bankid='".$_GET['bankid']."'";
}
//$sql="SELECT a.id,d.bankname,a.oldjine,if((`a`.`jine` > 0),`a`.`jine`,_utf8'') AS `shouru`,if((`a`.`jine` < 0),-(`a`.`jine`),_utf8'') AS `zhichu`,a.opertype,b.USER_NAME,a.createtime,f.supplyname FROM accessbank a LEFT JOIN user b ON a.createman = b.USER_ID left JOIN bank d ON a.bankid=d.bankid left JOIN ".$tablename1." e ON a.guanlianbillid=e.billid left JOIN ".$tablename2." f ON e.supplyid=f.ROWID where ".$where." a.createman='".$createman."' AND a.createtime>='".$start_time."' AND a.createtime<='".$end_time."'";
//exit($sql);

	$rs=$db->Execute($sql);
	$rs_a = $rs->GetArray();	
	//print_r($data);exit;
	if($_GET['where'] == 'yushouyufu'){
		
		$i=0;
		foreach ($rs_a as $row=>$val)
		{
			
			if($val['opertype']=="Ԥ�ջ���")
			{
				$supplyid=returntablefield("accesspreshou", "id", $val['id'], "customerid");
				$rs_a[$i]['supplyname']=returntablefield("customer","rowid",$supplyid,"supplyname");
			}
			else if($val['opertype']=="Ԥ������")
			{
				
				$supplyid=returntablefield("accessprepay", "id", $val['id'], "supplyid");
				$rs_a[$i]['supplyname']=returntablefield("supply","rowid",$supplyid,"supplyname");
			}
			$i++;
		}
	}
if($_GET['out_excel'] == 'true'){
	export_XLS($head,$rs_a,$title,$sumcol);
	exit;
}
$createmanname=returntablefield("user", "user_id", $createman, "user_name");
?>
<html>
<head>
<?php page_css('�����ձ�  '.$data[0][rs_a][0][USER_NAME].' '.$data[0][title].$start_time.'��'.$end_time); ?>
<script language="javascript" src="../LODOP60/LodopFuncs.js"></script>
<SCRIPT src="../../Enginee/WdatePicker/WdatePicker.js"></SCRIPT>
<object  id="LODOP_OB" classid="clsid:2105C259-1E0C-4534-8141-A753534CB4CA"
	width=0 height=0> <embed id="LODOP_EM" type="application/x-print-lodop"
		width=0 height=0></embed> </object>
</head>
<body class=bodycolor topMargin=5>
<div id='con'>
<h2 align=center><?php echo $createmanname."-".$title?></h2>
<form method=get>
<input type="hidden" name='createman' value="<?php echo $createman?>">
<input type="hidden" name='where' value="<?php echo $_GET['where']?>">
ʱ��Σ� <input class="SmallInput" size="19"
							name="start_time" value="<?php echo $start_time?>"
							onclick="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss'})"
							readonly=""> �� <input class="SmallInput" size="19"
							name="end_time" value="<?php echo $end_time?>"
							onclick="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss'})"
							readonly="">
<?php 
if($_GET['where'] != 'allmoney')
{
echo "&nbsp;&nbsp;�˻���<select name='bankid'><option value=0>-ȫ��-</option>";
$sql="select distinct a.bankid,b.bankname from accessbank a inner join bank b on a.bankid=b.ROWID where a.createman='".$createman."' AND a.createtime>='".$start_time."' AND a.createtime<='".$end_time."'";
$rs=$db->Execute($sql);
$rs_bank=$rs->GetArray();
foreach ($rs_bank as $row)
{
	if($row['bankid']==$_GET['bankid'])
		$check='selected';
	else 
		$check='';
	echo "<option value=".$row['bankid']." $check>".$row['bankname']."</option>";
}
echo "</select>";
}
?>
&nbsp;<input type="submit" class="SmallButton" value="��ѯ">
</form>
<table class=TableBlock align=center width=100%>
</tr>
		<tr class=TableHeader>
		<?php 
	foreach ($head as $key=>$val)
	{
?>
		<td nowrap align=center><?php echo $val?></td>
<?php 
	}

	foreach($rs_a as $row)
	{
		echo "<tr class=TableData>";
		foreach ($head as $key=>$val)
		{
			if($headtype[$key]=="int" || $headtype[$key]=="float")
				$align="right";
			else if($headtype[$key]=="char")
				$align="center";
			else
				$align="left";
			echo "<td nowrap align='".$align."'>";
			if($headtype[$key]=="float")
			{
				if($row[$key]!=0)
					echo number_format($row[$key],2,".",",");	
			}
			else
				echo $row[$key];
			echo "</td>";
			foreach ($sumcol as $sumkey=>$sumval)
			{
				if($sumkey==$key)
					$sumcol[$sumkey]+=$row[$key];
			}
		}
		echo "</tr>";
	}
	?>
		<tr class="TableHeader">
<?php 
	$i=0;
	foreach ($head as $key=>$val)
	{
		if($i==0)
			print "<td>�ϼ� <b>".sizeof($rs_a)."</b> ����¼</td>";
		else
		{
			print "<td align=right><b>";
			foreach ($sumcol as $sumkey=>$sumval)
			{
				if($sumkey==$key)
				{
					if(is_float($sumval))
						echo number_format($sumval,2,".",",");
					else 
						echo $sumval;
				}
			}
			print "</b></td>";
		}
		$i++;
	}
?>	</tr>
</table>
</div>
<form>
<p align="center"><input type="button" class="SmallButton" value=" ��ӡ "
	onclick="javascript:prn_print();"> <input type="button"
	class="SmallButton" value="����"
	onclick="location='xiaoshoubaobiao_mingxi.php?createman=<?php echo $_GET['createman'];?>&out_excel=true&start_time=<?php echo $_GET[start_time];?>&end_time=<?php echo $_GET[end_time];?>&where=<?php echo $_GET[where];?>';">
	<input type="button" class="SmallButton" value=" �ر� "
	onclick="javascript:window.close();">
</p>
</form>

</body>
<script language="javascript" type="text/javascript">   
    var LODOP; //����Ϊȫ�ֱ��� 
	function prn_print() {		
		CreateOneFormPage();
		LODOP.PREVIEW();
		//LODOP.PRINT();	
	};

	function CreateOneFormPage(){
	
		LODOP=getLodop(document.getElementById('LODOP_OB'),document.getElementById('LODOP_EM'));  

		LODOP.PRINT_INIT("<?php echo $title?>");
		LODOP.SET_PRINT_PAGESIZE(2,0,0,"");
		LODOP.ADD_PRINT_TABLE("5%","5%","100%","100%",document.getElementById("con").innerHTML);
		LODOP.SET_PRINT_MODE("PRINT_PAGE_PERCENT","Auto-Width");
	};              
	

</script>

</html>
