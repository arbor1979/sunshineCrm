<?php
require_once('lib.inc.php');

$GLOBAL_SESSION=returnsession();

	require_once("systemprivateinc.php");

	CheckSystemPrivate("���ڹ���-�칫��Ʒ-����ͳ��");

?>

<script language="javascript" src="../LODOP60/LodopFuncs.js"></script>
<object  id="LODOP_OB" classid="clsid:2105C259-1E0C-4534-8141-A753534CB4CA" width=0 height=0>
	<embed id="LODOP_EM" type="application/x-print-lodop" width=0 height=0></embed>
</object>

<script language="javascript" type="text/javascript">
	var LODOP; //����Ϊȫ�ֱ���
	LODOP=getLodop(document.getElementById('LODOP_OB'),document.getElementById('LODOP_EM'));

    function PreviewFun(){
	    LODOP.PRINT_INIT("���ֻ�У԰��ӡ����");
		var strStyleCSS="<link href='<?php echo ROOT_DIR?>theme/3/style.css' type='text/css' rel='stylesheet'><style>input {display: none;}; label {display: none}</style>";
		LODOP.ADD_PRINT_TABLE(30,"4%","90%","90%",strStyleCSS+"<body>"+document.getElementById("MainData0").innerHTML+"</body>");
		LODOP.NewPageA();
	};

	function PreviewMytable(){
		
		PreviewFun();
		LODOP.PREVIEW();
	};

	function PrintMytable(){

		PreviewFun();
		if (LODOP.PRINTA())  
			alert("�ѷ���ʵ�ʴ�ӡ���");
	};
</script>
<?php

page_css("�칫��Ʒ��Ϣͳ��");
print "<link rel='stylesheet' type='text/css' href='".ROOT_DIR."theme/$LOGIN_THEME/style.css'>\n";
	print "<SCRIPT>\n";
	print "function td_calendar(fieldname) {\n";
	print "myleft=document.body.scrollLeft+event.clientX-event.offsetX-80;\n";
	print "mytop=document.body.scrollTop+event.clientY-event.offsetY+140;\n";
	print "window.showModalDialog(fieldname,self,\"edge:raised;scroll:0;status:0;help:0;resizable:1;dialogWidth:280px;dialogHeight:200px;dialogTop:\"+mytop+\"px;dialogLeft:\"+myleft+\"px\");\n";
	print "}\n";
	print "function SubmitForm() {
		var ��ʼʱ�� = document.form1.��ʼʱ��.value;
		var ����ʱ�� = document.form1.����ʱ��.value;
		URL = \"?action=Stat&��ʼʱ��=\"+��ʼʱ��+\"&����ʱ��=\"+����ʱ��+\"\";
		location = URL;

		}\n";
	print "</SCRIPT>\n";
print "<form name=form1><table border=0 cellspacing=0 class=small bordercolor=#000000 cellpadding=3 width=100% style=\"border-collapse:collapse\"><tr><td nowrap>
";

if($_GET['��ʼʱ��']=="") $_GET['��ʼʱ��'] = date("Y-m-d",mktime(date("H"),date("i"),date("s"),date("m")-1,date("d"),date("Y")));;
if($_GET['����ʱ��']=="") $_GET['����ʱ��'] = date("Y-m-d",mktime(date("H"),date("i"),date("s"),date("m"),date("d"),date("Y")));;

print "<INPUT class=SmallInput size=10  name=��ʼʱ�� value='".$_GET['��ʼʱ��']."' title='' onkeydown='if(event.keyCode==13)event.keyCode=9' >
<input type='button'  title=''  value='ѡ��' class='SmallButton' onclick=\"td_calendar('../../Framework/sms_index/calendar_begin.php?datetime=��ʼʱ��');\" title='ѡ��' name='button'>&nbsp;&nbsp;
<INPUT class=SmallInput size=10  name=����ʱ�� value='".$_GET['����ʱ��']."' title='' onkeydown='if(event.keyCode==13)event.keyCode=9' >
<input type='button'  title=''  value='ѡ��' class='SmallButton' onclick=\"td_calendar('../../Framework/sms_index/calendar_begin.php?datetime=����ʱ��');\" title='ѡ��' name='button'>&nbsp;&nbsp;&nbsp;<input type='button'  title=''  value='��ʼ��ѯ' class='SmallButton' onclick=\"SubmitForm()\" title='��ʼ��ѯ' name='button'>&nbsp;&nbsp;
";
print "&nbsp;&nbsp;&nbsp;<a href=\"?".base64_encode("��ʼʱ��=".date("Y-m-d",mktime(0,0,1,date("m"),date("d")-3,date("Y")))."&����ʱ��=".date("Y-m-d",mktime(0,0,1,date("m"),date("d"),date("Y")))."")."\">�������</a>";
print "&nbsp;&nbsp;&nbsp;<a href=\"?".base64_encode("��ʼʱ��=".date("Y-m-d",mktime(0,0,1,date("m"),date("d")-7,date("Y")))."&����ʱ��=".date("Y-m-d",mktime(0,0,1,date("m"),date("d"),date("Y")))."")."\">���һ��</a>";
print "&nbsp;&nbsp;&nbsp;<a href=\"?".base64_encode("��ʼʱ��=".date("Y-m-d",mktime(0,0,1,date("m"),date("d")-15,date("Y")))."&����ʱ��=".date("Y-m-d",mktime(0,0,1,date("m"),date("d"),date("Y")))."")."\">�������</a>";
print "&nbsp;&nbsp;&nbsp;<a href=\"?".base64_encode("��ʼʱ��=".date("Y-m-d",mktime(0,0,1,date("m"),date("d")-30,date("Y")))."&����ʱ��=".date("Y-m-d",mktime(0,0,1,date("m"),date("d"),date("Y")))."")."\">���һ����</a>";
print "&nbsp;&nbsp;&nbsp;<a href=\"?".base64_encode("��ʼʱ��=".date("Y-m-d",mktime(0,0,1,date("m"),date("d")-60,date("Y")))."&����ʱ��=".date("Y-m-d",mktime(0,0,1,date("m"),date("d"),date("Y")))."")."\">���������</a>";
print "&nbsp;&nbsp;&nbsp;<a href=\"?".base64_encode("��ʼʱ��=".date("Y-m-d",mktime(0,0,1,date("m"),date("d")-90,date("Y")))."&����ʱ��=".date("Y-m-d",mktime(0,0,1,date("m"),date("d"),date("Y")))."")."\">���������</a>";
print "&nbsp;&nbsp;&nbsp;<a href=\"?".base64_encode("��ʼʱ��=".date("Y-m-d",mktime(0,0,1,date("m")-6,date("d"),date("Y")))."&����ʱ��=".date("Y-m-d",mktime(0,0,1,date("m"),date("d"),date("Y")))."")."\">���������</a>";
print "</td></tr></table></form>  ";


//��ʼ�����շ�(�跽)���˷�(����)���ֽ��ռ��˱�


print "<div id=MainData0><table  class=TableBlock align=center width=100%><thead>
<TR><TD class=TableHeader align=left colSpan=8>&nbsp;�칫��Ʒ��Ϣͳ��</TD></TR>
";


$��ʼʱ�� = $_GET['��ʼʱ��'];
$����ʱ�� = $_GET['����ʱ��'];
$��ʼʱ��ARRAY  = explode('-',$��ʼʱ��);
$����ʱ��ARRAY  = explode('-',$����ʱ��);
$��ʼʱ�� = date("Y-m-d H:i:s",mktime(0,0,1,$��ʼʱ��ARRAY[1],$��ʼʱ��ARRAY[2],$��ʼʱ��ARRAY[0]));
$����ʱ�� = date("Y-m-d H:i:s",mktime(0,0,1,$����ʱ��ARRAY[1],$����ʱ��ARRAY[2]+1,$����ʱ��ARRAY[0]));

$NewArray = array();
$SortArray = array();
//������������
$sql = "select �칫��Ʒ���,�칫��Ʒ����,SUM(��������) AS �������� from officeproductout where ����ʱ��>='$��ʼʱ��' and ����ʱ��<='$����ʱ��' group by �칫��Ʒ���";
$rs = $db->Execute($sql);
$rs_a = $rs->GetArray();
for($i=0;$i<sizeof($rs_a);$i++)				{
	$Element = $rs_a[$i];
	$�칫��Ʒ��� = $Element['�칫��Ʒ���'];
	$�칫��Ʒ���� = $Element['�칫��Ʒ����'];
	$�������� = $Element['��������'];
	$���������[$�칫��Ʒ���]['�칫��Ʒ����'] = $�칫��Ʒ����;
	$���������[$�칫��Ʒ���]['��������'] = $��������;
}

//������������
$sql = "select �칫��Ʒ���,�칫��Ʒ����,SUM(�������) AS ������� from officeproductin where ����ʱ��>='$��ʼʱ��' and ����ʱ��<='$����ʱ��' group by �칫��Ʒ���";
$rs = $db->Execute($sql);
$rs_a = $rs->GetArray();
for($i=0;$i<sizeof($rs_a);$i++)				{
	$Element = $rs_a[$i];
	$�칫��Ʒ��� = $Element['�칫��Ʒ���'];
	$�칫��Ʒ���� = $Element['�칫��Ʒ����'];
	$������� = $Element['�������'];
	$��������[$�칫��Ʒ���]['�칫��Ʒ����'] = $�칫��Ʒ����;
	$��������[$�칫��Ʒ���]['�������'] = $�������;
}

//�����˿������
$sql = "select �칫��Ʒ���,�칫��Ʒ����,SUM(�˿�����) AS �˿����� from officeproducttui where ����ʱ��>='$��ʼʱ��' and ����ʱ��<='$����ʱ��' group by �칫��Ʒ���";
$rs = $db->Execute($sql);
$rs_a = $rs->GetArray();
for($i=0;$i<sizeof($rs_a);$i++)				{
	$Element = $rs_a[$i];
	$�칫��Ʒ��� = $Element['�칫��Ʒ���'];
	$�칫��Ʒ���� = $Element['�칫��Ʒ����'];
	$�˿����� = $Element['�˿�����'];
	$�˿������[$�칫��Ʒ���]['�칫��Ʒ����'] = $�칫��Ʒ����;
	$�˿������[$�칫��Ʒ���]['�˿�����'] = $�˿�����;
}



//�����ϱ�����
$sql = "select �칫��Ʒ���,�칫��Ʒ����,SUM(��������) AS ��������,�����ֿ� AS ���ϲֿ� from officeproductbaofei where ����ʱ��>='$��ʼʱ��' and ����ʱ��<='$����ʱ��' group by �칫��Ʒ���,���ϲֿ�";
$rs = $db->Execute($sql);
$rs_a = $rs->GetArray();
for($i=0;$i<sizeof($rs_a);$i++)				{
	$Element = $rs_a[$i];
	$�칫��Ʒ��� = $Element['�칫��Ʒ���'];
	$�칫��Ʒ���� = $Element['�칫��Ʒ����'];
	$�������� = $Element['��������'];
	$���ϲֿ� = $Element['���ϲֿ�'];
	$�ֿ����б�[$���ϲֿ�] = $���ϲֿ�;
	$���ϱ�����[$�칫��Ʒ���]['�칫��Ʒ����'] = $�칫��Ʒ����;
	$���ϱ�����[$�칫��Ʒ���]['��������'] = $��������;
}

//����ϲ�����
//print_R($���������);

$sql = "select * from officeproduct";
$rs = $db->Execute($sql);
$rs_a = $rs->GetArray();


//�������ս��������
print "<tr class=TableHeader>
<td nowrap>���</td>
<td nowrap>�칫��Ʒ���</td>
<td nowrap>�칫��Ʒ����</td>
<td nowrap>���п��</td>
<td nowrap>�ɹ�����</td>
<td nowrap>��������</td>
<td nowrap>�黹����</td>
<td nowrap>��������</td>

</tr></thead>";
for($i=0;$i<sizeof($rs_a);$i++)				{
	$Key = $rs_a[$i];
	$�칫��Ʒ��� = $Key['�칫��Ʒ���'];
	$�칫��Ʒ���� = $Key['�칫��Ʒ����'];
	$������� = $��������[$�칫��Ʒ���]['�������'];
	$�������� = $���������[$�칫��Ʒ���]['��������'];
	$�˿����� = $�˿������[$�칫��Ʒ���]['�˿�����'];
	$�������� = $���ϱ�����[$�칫��Ʒ���]['��������'];
	$���п�� = $��������[$�칫��Ʒ���]['�������'] + $�˿������[$�칫��Ʒ���]['�˿�����']-$���������[$�칫��Ʒ���]['��������'] - $���ϱ�����[$�칫��Ʒ���]['��������'];

print "<tr class=TableData>
<td nowrap><font color=black>".($i+1)."</font></td>
<td nowrap>$�칫��Ʒ���</td>
<td nowrap>$�칫��Ʒ����</td>
<td nowrap>$���п��</td>
<td nowrap>$�������</td>
<td nowrap>$��������</td>
<td nowrap>$�˿�����</td>
<td nowrap>$��������</td>

</tr>
";
$���п��ALL += $���п��;
$�������ALL += $�������;
$��������ALL += $��������;
$�˿�����ALL += $�˿�����;
$��������ALL += $��������;

}

print "<tr class=TableContent>
<td nowrap colspan=3>�� ".$_GET['��ʼʱ��']." �� ".$_GET['����ʱ��']." �ϼ�:</td>
<td nowrap>$���п��ALL</td>
<td nowrap>$�������ALL</td>
<td nowrap>$��������ALL</td>
<td nowrap>$�˿�����ALL</td>
<td nowrap>$��������ALL</td>

</tr>
";
print "</table></div>";

print "<p align=center><input type=button class=SmallButton onClick=\"PreviewMytable();\" value='Ԥ��'>&nbsp;&nbsp;
       <input type=button accesskey=p name=print value=\"��ӡ\" class=SmallButton onClick=\"PrintMytable();\" title=\"��ݼ�:ALT+p\"></p>";
exit;
?>