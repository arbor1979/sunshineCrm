<?php
ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL);
error_reporting(E_WARNING | E_ERROR);
require_once('lib.inc.php');

$GLOBAL_SESSION=returnsession();
validateMenuPriv("�����ձ�");
global $db;
if(empty($_GET['start_time'])) {
	$start_time = date("Y-m-d 00:00:00");
}else{
	$start_time = $_GET['start_time'];
}

if(empty($_GET['end_time'])) {
	$end_time = date("Y-m-d 23:59:59");
}else{
	$end_time = $_GET['end_time'];
}
$sql="select `b`.`createman`,count(0) AS `danshu`,0 AS `totalmoney`,sum(if((`b`.`opertype` = '������ȡ'  or  `b`.`opertype` = '��Ѻ��' or `b`.`opertype` = 'Ƿ����ȡ'),`b`.`jine`,0)) AS `yishou`,sum(if((`b`.`opertype` = '����֧��'),`b`.`jine`,0)) AS `huokuanzhifu`,sum(if((`b`.`opertype` = 'Ԥ�ջ���' or `b`.`opertype` = 'Ԥ������'),`b`.`jine`,0)) AS `yushouyufu`,sum(if((`b`.`opertype` = '��������' or `b`.`opertype` = '����֧��'),`b`.`jine`,0)) AS `qitashouzhi`,sum(if((`b`.`opertype` = '������ȡ'  or  `b`.`opertype` = '��Ѻ��'  or  `b`.`opertype` = 'Ƿ����ȡ'  or  `b`.`opertype` = '����֧��'  or  `b`.`opertype` = 'Ԥ�ջ���'  or  `b`.`opertype` = 'Ԥ������'  or  `b`.`opertype` = '��������'  or  `b`.`opertype` = '����֧��'),`b`.`jine`,0)) AS `heji`,c.USER_NAME,c.UID from (`accessbank` `b` inner join user c on( b.createman = c.USER_ID)) where b.createtime>='".$start_time."' and b.createtime<='".$end_time."' ";
//$sql=getRoleByUser($sql,"createman"); 
$sql.=" group by `b`.`createman`";
//exit($sql);
$rs=$db->Execute($sql);
$rs_a = $rs->GetArray();
$sql="select a.`user_id`,count(0) as danshu,sum(totalmoney) as totalmoney,b.USER_NAME,b.UID from `sellplanmain` a inner join user b on( a.user_id = b.USER_ID) where `createtime`>='".$start_time."' and `createtime`<='".$end_time."' and `user_flag`>0 ";
$sql=getRoleByUser($sql,"a.user_id"); 
$sql.=" group by `user_id`";
$rs=$db->Execute($sql);
$rs_b = $rs->GetArray();
foreach ($rs_b as $row)
{
	$flag=false;
	for ($j=0;$j<sizeof($rs_a);$j++)
	{
		if($rs_a[$j]['createman']==$row['user_id'])
		{
			$rs_a[$j]['danshu']=$row['danshu'];
			$rs_a[$j]['totalmoney']=$row['totalmoney'];
			$flag=true;
			break;
		}
	}
	if(!$flag)
	{
		array_push($rs_a, array("createman"=>$row['user_id'],"danshu"=>$row['danshu'],"totalmoney"=>$row['totalmoney'],"USER_NAME"=>$row['USER_NAME'],"UID"=>$row['UID'],"heji"=>"0"));
	}
	
}
$head=array("USER_NAME"=>"����Ա","danshu"=>"����","totalmoney"=>"���۶�","yishou"=>"������ȡ","huokuanzhifu"=>"����֧��","yushouyufu"=>"Ԥ��Ԥ��","qitashouzhi"=>"������֧","heji"=>"�ϼ�");
$headtype=array("USER_NAME"=>"string","danshu"=>"int","totalmoney"=>"float","yishou"=>"float","huokuanzhifu"=>"float","yushouyufu"=>"float","qitashouzhi"=>"float","heji"=>"float");
$title="�����ձ�";
$sumcol=array("danshu"=>"","totalmoney"=>"","yishou"=>"","huokuanzhifu"=>"","yushouyufu"=>"","qitashouzhi"=>"","heji"=>"");

if($_GET['out_excel'] == 'true'){
	export_XLS($head,$rs_a,$title,$sumcol);
	exit;
}
?>
<html>
<head>
<?php page_css($title); ?>

<SCRIPT src="../../Enginee/WdatePicker/WdatePicker.js"></SCRIPT>

</head>
<body class=bodycolor topMargin=5>
<div id='con'>
<table class=TableBlock align=center width=100%>
	<thead>
		<tr>
			<td nowrap='' colspan="13">
			<form action='' method="get" name="form1">
			<table width="100%" class="Small" border="0">
				<thead>
					<tr>
						<td class='nowrap'>ʱ��Σ� <input class="SmallInput" size="19"
							name="start_time" value="<?php echo $start_time; ?>"
							onclick="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss'})"
							readonly=""> �� <input class="SmallInput" size="19"
							name="end_time" value="<?php echo $end_time; ?>"
							onclick="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss'})"
							readonly=""> <input class="SmallButtonA" type="submit"
							accesskey="f" value="��ѯ" name="button" id="searchbtn"></td>
					</tr>
				</thead>
			</table>
			</form>
			</td>
		</tr>
		<tr>
			<td colspan="10" class="TableHeader">&nbsp;<?php echo $title?></td>
		</tr>
	</thead>

		<tr class=TableHeader>
		<?php 
	foreach ($head as $key=>$val)
	{
?>
		<td nowrap align=center><?php echo $val?></td>
<?php 
	}
?></tr>
	<?php
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
			switch($val){
				case "����Ա":
					print "<a target='_blank' href='../Framework/user_newai.php?action=view_default&UID=".$row['UID']."'>".$row[$key]."</a>";
					break;

				case "���۶�":		
					echo number_format($row[$key],2,".",",");	
					break;
				case "������ȡ":
					print "<a  target='_blank' href='xiaoshoubaobiao_mingxi.php?username=".$row['USER_NAME']."&createman=".$row['createman']."&start_time=".$start_time."&end_time=".$end_time."&where=yishou' title='�鿴��ϸ'>".number_format($row['yishou'],2,'.',',')."</a>";
					break;
				case "����֧��":
					print "<a  target='_blank' href='xiaoshoubaobiao_mingxi.php?username=".$row['USER_NAME']."&createman=".$row['createman']."&start_time=".$start_time."&end_time=".$end_time."&where=huokuanzhifu' title='�鿴��ϸ'>".number_format($row['huokuanzhifu'],2,'.',',')."</a>";
					break;
				case "Ԥ��Ԥ��":
					print "<a  target='_blank' href='xiaoshoubaobiao_mingxi.php?username=".$row['USER_NAME']."&createman=".$row['createman']."&start_time=".$start_time."&end_time=".$end_time."&where=yushouyufu' title='�鿴��ϸ'>".number_format($row['yushouyufu'],2,'.',',')."</a>";
					break;
				case "������֧":
					print "<a  target='_blank' href='xiaoshoubaobiao_mingxi.php?username=".$row['USER_NAME']."&createman=".$row['createman']."&start_time=".$start_time."&end_time=".$end_time."&where=qitashouzhi' title='�鿴��ϸ'>".number_format($row['qitashouzhi'],2,'.',',')."</a>";
					break;
				case "�ϼ�":
					print "<a  target='_blank' href='xiaoshoubaobiao_mingxi.php?username=".$row['USER_NAME']."&createman=".$row['createman']."&start_time=".$start_time."&end_time=".$end_time."&where=allmoney' title='�鿴��ϸ'>".number_format($row[$key],2,'.',',')."</a>";
					break;
				default: 
					echo $row[$key];
				
			}
			
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
	onclick="location='xiaoshoubaobiao.php?supplyid=<?php echo $_GET[supplyid];?>&out_excel=true&start_time=<?php echo $_GET[start_time];?>&end_time=<?php echo $_GET[end_time];?>';">
</p>
</form>

</body>
<script language="javascript" src="../LODOP60/LodopFuncs.js"></script>
<object  id="LODOP_OB" classid="clsid:2105C259-1E0C-4534-8141-A753534CB4CA"
	width=0 height=0> <embed id="LODOP_EM" type="application/x-print-lodop"
		width=0 height=0></embed> </object>
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
		document.getElementById("searchbtn").style.display="none";
		LODOP.ADD_PRINT_TABLE("10%","10%","80%","100%",document.documentElement.innerHTML);
		document.getElementById("searchbtn").style.display="";
		LODOP.SET_PRINT_MODE("PRINT_PAGE_PERCENT","Auto-Width");
		
	};              
	

</script>

</html>
