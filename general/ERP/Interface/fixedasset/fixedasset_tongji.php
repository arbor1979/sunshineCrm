<?php
require_once('lib.inc.php');

$GLOBAL_SESSION=returnsession();
	require_once("systemprivateinc.php");

	CheckSystemPrivate("���ڹ���-�̶��ʲ�-������ϸͳ��");

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
		var strStyleCSS="<link href='<?php echo ROOT_DIR?>theme/3/style.css' type='text/css' rel='stylesheet'><style>input {display: none;};</style>";
		LODOP.ADD_PRINT_HTML(30,"3%","90%","90%",strStyleCSS+"<body>"+document.getElementById("MainData0").innerHTML+"</body>");
		LODOP.SET_PRINT_STYLEA(0,"ItemType",1);
		LODOP.SET_PRINT_STYLEA(0,"LinkedItem",1);
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

page_css("�̶��ʲ���Ϣ������ʱ����зֿ��ҷ����ͳ��");
print "<link rel='stylesheet' type='text/css' href='".ROOT_DIR."theme/$LOGIN_THEME/style.css'>\n";
	print "<SCRIPT>\n";
	print "function td_calendar(fieldname) {\n";
	print "myleft=document.body.scrollLeft+event.clientX-event.offsetX-80;\n";
	print "mytop=document.body.scrollTop+event.clientY-event.offsetY+140;\n";
	print "window.showModalDialog(fieldname,self,\"edge:raised;scroll:0;status:0;help:0;resizable:1;dialogWidth:280px;dialogHeight:220px;dialogTop:\"+mytop+\"px;dialogLeft:\"+myleft+\"px\");\n";
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

if($_GET['��ʼʱ��']=="") $_GET['��ʼʱ��'] = date("Y-m-d",mktime(date("H"),date("i"),date("s"),date("m")-12,date("d"),date("Y")));;
if($_GET['����ʱ��']=="") $_GET['����ʱ��'] = date("Y-m-d",mktime(date("H"),date("i"),date("s"),date("m"),date("d"),date("Y")));;

print "<INPUT class=SmallInput size=10  name=��ʼʱ�� value='".$_GET['��ʼʱ��']."' title='' onkeydown='if(event.keyCode==13)event.keyCode=9' >
<input type='button'  title=''  value='ѡ��' class='SmallButton' onclick=\"td_calendar('../../Framework/sms_index/calendar_begin.php?datetime=��ʼʱ��');\" title='ѡ��' name='button'>&nbsp;&nbsp;
<INPUT class=SmallInput size=10  name=����ʱ�� value='".$_GET['����ʱ��']."' title='' onkeydown='if(event.keyCode==13)event.keyCode=9' >
<input type='button'  title=''  value='ѡ��' class='SmallButton' onclick=\"td_calendar('../../Framework/sms_index/calendar_begin.php?datetime=����ʱ��');\" title='ѡ��' name='button'>&nbsp;&nbsp;&nbsp;<input type='button'  title=''  value='��ʼ��ѯ' class='SmallButton' onclick=\"SubmitForm()\" title='��ʼ��ѯ' name='button'>&nbsp;&nbsp;
";
//print "&nbsp;&nbsp;&nbsp;<a href=\"?".base64_encode("��ʼʱ��=".date("Y-m-d",mktime(0,0,1,date("m"),date("d")-3,date("Y")))."&����ʱ��=".date("Y-m-d",mktime(0,0,1,date("m"),date("d"),date("Y")))."")."\">�������</a>";
print "&nbsp;&nbsp;&nbsp;<a href=\"?".base64_encode("��ʼʱ��=".date("Y-m-d",mktime(0,0,1,date("m"),date("d")-30,date("Y")))."&����ʱ��=".date("Y-m-d",mktime(0,0,1,date("m"),date("d"),date("Y")))."")."\">���һ����</a>";
print "&nbsp;&nbsp;&nbsp;<a href=\"?".base64_encode("��ʼʱ��=".date("Y-m-d",mktime(0,0,1,date("m"),date("d")-90,date("Y")))."&����ʱ��=".date("Y-m-d",mktime(0,0,1,date("m"),date("d"),date("Y")))."")."\">���������</a>";
print "&nbsp;&nbsp;&nbsp;<a href=\"?".base64_encode("��ʼʱ��=".date("Y-m-d",mktime(0,0,1,date("m")-6,date("d"),date("Y")))."&����ʱ��=".date("Y-m-d",mktime(0,0,1,date("m"),date("d"),date("Y")))."")."\">���������</a>";
print "&nbsp;&nbsp;&nbsp;<a href=\"?".base64_encode("��ʼʱ��=".date("Y-m-d",mktime(0,0,1,date("m")-12,date("d"),date("Y")))."&����ʱ��=".date("Y-m-d",mktime(0,0,1,date("m"),date("d"),date("Y")))."")."\">���һ��</a>";
print "&nbsp;&nbsp;&nbsp;<a href=\"?".base64_encode("��ʼʱ��=".date("Y-m-d",mktime(0,0,1,date("m")-24,date("d"),date("Y")))."&����ʱ��=".date("Y-m-d",mktime(0,0,1,date("m"),date("d"),date("Y")))."")."\">�������</a>";
print "</td></tr></table></form>  ";


//��ʼ�����շ�(�跽)���˷�(����)���ֽ��ռ��˱�

$��ʼʱ�� = $_GET['��ʼʱ��'];
$����ʱ�� = $_GET['����ʱ��'];
$��ʼʱ��ARRAY  = explode('-',$��ʼʱ��);
$����ʱ��ARRAY  = explode('-',$����ʱ��);
$��ʼʱ�� = date("Y-m-d H:i:s",mktime(0,0,1,$��ʼʱ��ARRAY[1],$��ʼʱ��ARRAY[2],$��ʼʱ��ARRAY[0]));
$����ʱ�� = date("Y-m-d H:i:s",mktime(0,0,1,$����ʱ��ARRAY[1],$����ʱ��ARRAY[2]+1,$����ʱ��ARRAY[0]));

$NewArray = array();
$SortArray = array();
//�������������
$sql = "select �ʲ����,�ʲ�����,SUM(����) AS �ʲ�����,SUM(����*����) AS �ʲ��ܽ��,��������,�ʲ�����,�ʲ���� from fixedasset where ��������>='$��ʼʱ��' and ��������<='$����ʱ��' and �ʲ�����!='' and ����״̬!='�ʲ��ѱ���' group by ��������,�ʲ�����";
$rs = $db->Execute($sql);
$rs_a = $rs->GetArray();
for($i=0;$i<sizeof($rs_a);$i++)				{
	$Element = $rs_a[$i];
	$�������� = $Element['��������'];
	$�ʲ����� = $Element['�ʲ�����'];
	$�ʲ����� = $Element['�ʲ�����'];
	$�ʲ���� = $Element['�ʲ����'];
	$���������б�[$��������] += $�ʲ�����;
	$�ʲ���Ϣ��Ż���[$�ʲ�����] = $Element['�ʲ����'];
	$�ʲ���Ϣ����[$�ʲ�����]['�ʲ��ܽ��'][$��������] += $Element['�ʲ��ܽ��'];
	$�ʲ���Ϣ����[$�ʲ�����]['�ʲ�����'][$��������] += $Element['�ʲ�����'];

	$�ʲ���Ϣ����DEPT['�ʲ��ܽ��'][$��������] += $Element['�ʲ��ܽ��'];
	$�ʲ���Ϣ����DEPT['�ʲ�����'][$��������] += $Element['�ʲ�����'];

	$���� += $�ʲ�����;
}

$�ʲ��ܽ�� = @array_sum($�ʲ���Ϣ����DEPT['�ʲ��ܽ��']);

$�����б� = @array_keys($���������б�);

print "<div id=MainData0><table  class=TableBlock align=center width=100%>
<TR><TD class=TableHeader align=left colSpan='".(4+sizeof($�����б�))."'>&nbsp;�̶��ʲ���Ϣ������ʱ����зֿ��ҷ����ͳ�� <a href='fixedasset_tongjijianjie.php?��ʼʱ��=".$_GET['��ʼʱ��']."&����ʱ��=".$_GET['����ʱ��']."'>���ͳ��</a></TD></TR>
";

//�������ս��������

print "<tr class=TableHeader>
<td>���</td>
<td>�ʲ����</td>
<td>�ʲ�����</td>
<td>�ϼ�</td>
";

for($i=0;$i<sizeof($�����б�);$i++)		{
	print "<td>{$�����б�[$i]}</td>";
}
print "</tr>";

$�ʲ���Ϣ����Array = @array_keys($�ʲ���Ϣ����);
for($IX=0;$IX<sizeof($�ʲ���Ϣ����Array);$IX++)		{
	$�ʲ����� = $�ʲ���Ϣ����Array[$IX];
	$�ʲ���� = $�ʲ���Ϣ��Ż���[$�ʲ�����];
	print "<tr class=TableData>
	<td>&nbsp;".($IX+1)."</td>
	<td>&nbsp;$�ʲ����</td>
	<td>&nbsp;$�ʲ�����</td>
	";
	$�����ʲ������ϼ� = array_sum($�ʲ���Ϣ����[$�ʲ�����]['�ʲ�����']);
	$�����ʲ��ϼ�ALL += $�����ʲ������ϼ�;
	if($�����ʲ������ϼ�>0)			{
		$�����ʲ��ܽ�� = @array_sum($�ʲ���Ϣ����[$�ʲ�����]['�ʲ��ܽ��']);
		$�����ʲ��ϼ�Text = "����:$�����ʲ������ϼ� ���:$�����ʲ��ܽ��";
	}
	else	$�����ʲ��ϼ�Text = "";
	print "<td>&nbsp;$�����ʲ��ϼ�Text</td>";
	$�����б� = @array_keys($���������б�);
	for($i=0;$i<sizeof($�����б�);$i++)		{
		$�������� = $�����б�[$i];
		if($�ʲ���Ϣ����[$�ʲ�����]['�ʲ�����'][$��������]>0) {
			$ShowText = "����:".$�ʲ���Ϣ����[$�ʲ�����]['�ʲ�����'][$��������]." ���:".$�ʲ���Ϣ����[$�ʲ�����]['�ʲ��ܽ��'][$��������]."";
		}else	{
			$ShowText = "";
		}
		print "<td>&nbsp;$ShowText</td>";
	}
	print "</tr>";

}

$���п��ALL = (int)$���п��ALL;
$�ʲ��ܽ�� = number_format($�ʲ��ܽ��,2,'.','');
print "<tr class=TableContent>
<td colspan=4>�� ".$_GET['��ʼʱ��']." �� ".$_GET['����ʱ��']." �����ϼ�:".$����."�� ���ϼ�:".$�ʲ��ܽ��."Ԫ</td>
";
for($xi=0;$xi<sizeof($�����б�);$xi++)		{
	$�������� = $�����б�[$xi];
	$Index = $���������б�[$��������];
	print "<td>&nbsp;����:".$�ʲ���Ϣ����DEPT['�ʲ�����'][$��������]." ���:".$�ʲ���Ϣ����DEPT['�ʲ��ܽ��'][$��������]."</td>";
	$���п��ALL += $Index;
}
print "</tr>";
print "</table>";


//#######################################################################################

print "<BR><table  class=TableBlock align=center width=100%>
<TR><TD class=TableHeader align=left colSpan=4>&nbsp;�̶��ʲ���Ϣ������ʱ���״̬����ͳ��</TD></TR>
";
$NewArray = array();
$SortArray = array();
$���� = 0;
$�ʲ���Ϣ����DEPT = array();
//�������������  and ����״̬!='�ʲ��ѱ���'
$sql = "select SUM(����) AS �ʲ�����,SUM(����*����) AS �ʲ��ܽ��,����״̬ from fixedasset where ��������>='$��ʼʱ��' and ��������<='$����ʱ��' and �ʲ�����!='' group by ����״̬";
$rs = $db->Execute($sql);
$rs_a = $rs->GetArray();
for($i=0;$i<sizeof($rs_a);$i++)				{
	$Element = $rs_a[$i];
	$����״̬ = $Element['����״̬'];
	$�ʲ����� = $Element['�ʲ�����'];
	$����״̬�б�[$����״̬] = $�ʲ�����;

	$�ʲ���Ϣ����DEPT['�ʲ��ܽ��'][$����״̬] += $Element['�ʲ��ܽ��'];
	$�ʲ���Ϣ����DEPT['�ʲ�����'][$����״̬] += $Element['�ʲ�����'];
	$���� += $�ʲ�����;
}
$�ʲ��ܽ�� = @array_sum($�ʲ���Ϣ����DEPT['�ʲ��ܽ��']);
//�������ս��������
print "<tr class=TableHeader>
<td>���</td>
<td>��������</td>
<td>�ʲ�����(�����ʲ������ĺ�)</td>
<td>�ʲ����</td>
</tr>
";
$����״̬�б�Array = @array_keys($����״̬�б�);
for($IX=0;$IX<sizeof($����״̬�б�Array);$IX++)		{
	$����״̬ = $����״̬�б�Array[$IX];
	$�ʲ����� = $�ʲ���Ϣ����DEPT['�ʲ�����'][$����״̬];
	$�ʲ���� = $�ʲ���Ϣ����DEPT['�ʲ��ܽ��'][$����״̬];
	print "<tr class=TableData>
	<td>&nbsp;".($IX+1)."</td>
	<td>&nbsp;$����״̬</td>
	<td>&nbsp;<a href=\"fixedasset_view.php?".base64_encode("����״̬=$����״̬")."\" target=_blank>$�ʲ�����</a></td>
	<td>&nbsp;$�ʲ����</td>
	";
}
$���п��ALL = (int)$���п��ALL;
$�ʲ��ܽ�� = number_format($�ʲ��ܽ��,2,'.','');
$�ʲ��ܽ���д = num2rmb($�ʲ��ܽ��);
print "<tr class=TableContent>
<td colspan=4>�� ".$_GET['��ʼʱ��']." �� ".$_GET['����ʱ��']." �����ϼ�:".$����."�� ���ϼ�:".$�ʲ��ܽ��."Ԫ $�ʲ��ܽ���д</td>
";
print "</tr>";
print "</table></div>";

print "<p align=center><input type=button class=SmallButton onClick=\"PreviewMytable();\" value='Ԥ��'>&nbsp;&nbsp;
<input type=button accesskey=p name=print value=\"��ӡ\" class=SmallButton onClick=\"PrintMytable();\" title=\"��ݼ�:ALT+p\"></p>";
exit;

?>