<?php
	$billid=$_GET["billid"];
	ini_set('display_errors', 1);
	ini_set('error_reporting', E_ALL);
	error_reporting(E_WARNING | E_ERROR);
	require_once('lib.inc.php');
	$GLOBAL_SESSION=returnsession();
	
	
?>
<script language = "JavaScript"> 

</script>
</head>
<body topMargin=5>
<div id='maintable'>
<table border=0 style='width:95%;margin:0;padding:0;font-size:12px;'><tr><Th  colSpan=3 align=center>&nbsp;ȡ����-<?php echo $billid?><br></Th></TR>
<?php 
	global $db;
	$sql="select * from stockoutmain_detail a inner join product b on a.prodid=b.productid where mainrowid=$billid order by b.supplyid";
	$rs=$db->Execute($sql);
	$rs_detail = $rs->GetArray();
?>
<tr>
<th >����</th><th >ԭ����</th><th>����</th></tr>
<?php 
	$oldsupplyid='-1';
	for($i=0;$i<count($rs_detail);$i++)
	{
		$allnum=$allnum+$rs_detail[$i]['num'];
		$supplyid=$rs_detail[$i]['supplyid'];
		$supplyname='δ֪����';
		if($supplyid!='')
			$supplyname=returntablefield("supply", "rowid", $supplyid, "supplyname");
		if($oldsupplyid!=$supplyid)
			echo "<tr><td colSpan=3><b>$supplyname</b></td></tr>"
		?>
		<tr class=TableData>
		<td ><?php echo $rs_detail[$i]['prodname']?></td>
		<td ><?php echo $rs_detail[$i]['oldproductid']?></td>
		<td align=right><?php echo $rs_detail[$i]['num']?></td>
		</tr>
		<?php 
		$sql="select * from stockoutmain_detail_color a inner join productcolor b on a.color=b.id where a.id=".$rs_detail[$i]['id'];
		$rs=$db->Execute($sql);
		$rs_a = $rs->GetArray();
		for($j=0;$j<count($rs_a);$j++)
		{
		?>
		<tr class=TableData>
		<td ></td>
		<td ><?php echo $rs_a[$j]['name']?></td>
		<td align=right><?php echo $rs_a[$j]['num']?></td>
		</tr>
		<?php 
		}
		$oldsupplyid=$supplyid;
	}
?>
<tr class=TableData><td ><b>�ϼ�</b><td></td>
<td align=right><?php echo $allnum?></tr>
</table></div>
	<script language="javascript" src="../LODOP60/LodopFuncs.js"></script>
<object  id="LODOP_OB" classid="clsid:2105C259-1E0C-4534-8141-A753534CB4CA" width=0 height=0> 
		<embed id="LODOP_EM" type="application/x-print-lodop" width=0 height=0></embed> 
	</object>
<script type="text/javascript">
var LODOP; //����Ϊȫ�ֱ��� 
	LODOP=getLodop(document.getElementById('LODOP_OB'),document.getElementById('LODOP_EM'));  
	//����3��ʾ�����ӡ��ֽ�ߡ������ݵĸ߶ȡ���ֽ��80mm��45��ʾҳ�׿հ�4.5mm
	
	LODOP.PRINT_INIT("ȡ����-<?php echo billid?>");
	LODOP.SET_PRINT_PAGESIZE(1,800,1270,"");
	LODOP.ADD_PRINT_HTM('0%','0%','100%','100%',"<body leftmargin=0>"+document.getElementById('maintable').innerHTML+"</body>");
	LODOP.SET_PRINT_STYLEA(0,"Horient",3);
	LODOP.SET_SHOW_MODE("HIDE_PAPER_BOARD",1);
	LODOP.SET_PREVIEW_WINDOW(1,1,1,800,600,"<?php echo $page_head_fields['billid']['value']?>.��ʼ��ӡ");//��ӡǰ����ѡ���ӡ���ĶԻ���	
	LODOP.SET_PRINT_MODE("AUTO_CLOSE_PREWINDOW",1);//��ӡ���Զ��ر�Ԥ������
	LODOP.PREVIEW();
</script>
</body>
</html>