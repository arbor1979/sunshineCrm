<?php

require_once('lib.inc.php');



if($_GET['pageAction']!="write")				{

	$GLOBAL_SESSION=returnsession();
$SYSTEM_PRIV_STOP = 1;
	require_once("systemprivateinc.php");
	CheckSystemPrivate("������Դ-�ɲ�����-�ɲ�����ͳ��");
}


	$������Ա = $_SESSION['LOGIN_USER_NAME'];
	//print_R($_GET);
	if($_GET['��������']=="")		{
		$�������� = returntablefield("edu_zhongcengceping","�Ƿ���Ч",1,"��������");
	}
	else	{
		$�������� = $_GET['��������'];
	}

	$����������Ա = returntablefield("edu_zhongcengceping","��������",$��������,"����������Ա");
	$����������ԱArray = explode(',',$����������Ա);





if($LOGIN_THEME!="") $LOGIN_THEME_TEXT = $LOGIN_THEME;
else	 $LOGIN_THEME_TEXT = 3;

print "<TITLE>�в����</TITLE>
<META http-equiv=Content-Type content=\"text/html; charset=gb2312\">
<LINK href=\"http://".$_SERVER['SERVER_NAME'].":".$_SERVER['SERVER_PORT']."/theme/$LOGIN_THEME_TEXT/style.css\" type=text/css rel=stylesheet>
<script type=\"text/javascript\" language=\"javascript\" src=\"http://".$_SERVER['SERVER_NAME'].":".$_SERVER['SERVER_PORT']."/general/EDU/Enginee/lib/common.js\"></script><STYLE>@media print{input{display:none}}</STYLE>
<BODY class=bodycolor topMargin=5 >";

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
		var strStyleCSS="<link href='/theme/3/style.css' type='text/css' rel='stylesheet'>";
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
	
	function SaveAsFile(){ 
	   LODOP.PRINT_INIT("���ֻ�У԰��������");
	   var strStyleCSS="<link href='/theme/3/style.css' type='text/css' rel='stylesheet'>";
	   LODOP.ADD_PRINT_TABLE(100,20,500,80,strStyleCSS+"<body>"+document.getElementById("MainData0").innerHTML+"</body>");
	   //LODOP.SET_SAVE_MODE("QUICK_SAVE",true);//�������ɣ��ޱ����ʽ,�������ϴ�ʱ�����õ���
	   LODOP.SAVE_TO_FILE("�в�����.xls");
	};
	//js��������
	function JsSaveAsFile(){
		c1 = document.getElementById("MainData0").innerHTML;
		ExportExcelFile(c1);
	};
</script>

<?php


	table_begin("100%");
	$sql="select �������� from edu_zhongcengceping";
	$rs = $db->Execute($sql);
	$rs_a = $rs->GetArray();
	print "<tr class=TableData ><td colspan=6 align=left>";
	print "&nbsp;����ѡ������Ҫͳ�ƵĲ�����Ŀ: <select class=\"SmallSelect\" name=\"��������\" onChange=\"var jmpURL='?action=ViewProject&��������=' + this.options[this.selectedIndex].value ; if(jmpURL!='') {window.location=jmpURL;} else {this.selectedIndex=0 ;}\">";
	for($i=0;$i<sizeof($rs_a);$i++)		{
		$��������X = $rs_a[$i]['��������'];
		if($��������==$��������X) $temp = "selected";else $temp = "";
		print "<option value=\"".$��������X."\" $temp>".$��������X."</option>\n";
	}
	print "</select>\n";
	print "</td></tr>";
	table_end();
	print "<BR>";


    print "<div id=MainData0>";
	table_begin("100%");
	print "<thead><tr class=TableHeader ><td colspan=6 align=left>�в�ɲ�����ͳ��[$��������]";
	print "</td></tr>";

	print "<tr class=TableHeader >
				<td  align=center>�ɲ�����</td>
				<td  align=center>��λ</td>
				<td  align=center>ְ��</td>
				<td  align=center>��������</td>
				<td  align=center>�ۺϽ��</td>
				<td  align=center>����</td>
				</tr></thead>";
	$sql = "select ������Ա,��λ,ְ��,SUM(Ʒ������)+SUM(��������)+SUM(�ڷ�����)+SUM(��Ч����)+SUM(��������) AS ����,������ from edu_zhongcengmingxi where ��������='$��������' group by ������Ա,������ order by ������Ա";
	$rs = $db->Execute($sql);
	$rs_a = $rs->GetArray();
	for($i=0;$i<sizeof($rs_a);$i++)		{
		$��� = $rs_a[$i]['���'];
		$������Ա = $rs_a[$i]['������Ա'];
		$������ = $rs_a[$i]['������'];
		$Infor[$������Ա]['��λ'] = $rs_a[$i]['��λ'];
		$Infor[$������Ա]['ְ��'] = $rs_a[$i]['ְ��'];
		$Infor[$������Ա]['����'] = $rs_a[$i]['����'];
		$NewArray[$������Ա][$������] = $rs_a[$i]['����'];

	}

	//print_R($NewArray);

	$������Ա���� = @array_keys($NewArray);
	for($i=0;$i<sizeof($������Ա����);$i++)		{
		$������Ա = $������Ա����[$i];
		$���������� = array();
		$���������� = $NewArray[$������Ա];
		$���������� = sizeof($����������);

		$ResultNum[$������Ա] = $����������;


		$����������Values = array_values($����������);
		@sort($����������Values);
		//print_R($����������Values);
		//����������������ʱ
		if($����������>2)						{
			$P10 = ceil($����������*0.1);
			if($P10==0) $P10 = 1;				//����ȥ��һ����߷ֺ�һ����ͷ�
			//print $P10;
			for($iX=0;$iX<$P10;$iX++)				{
				$�۳���ͷ�[$������Ա] .= array_shift($����������Values)." ";
				//print_R($����������Values);
				$�۳���߷�[$������Ա] .= array_pop($����������Values)." ";
				//print_R($����������Values);
				//exit;
			}
		}
		else		{
			//һ����������ʱֱ�Ӽ���ƽ��ֵ
			$�۳���߷�[$������Ա] = '';
			$�۳���ͷ�[$������Ա] = '';
		}


		$���������� = count($����������Values);
		$������������ = array_sum($����������Values);
		//print_R($P10);
		if($����������>0)	$ƽ��ֵ = number_format($������������/($����������*5),2,'.','');
		else	$ƽ��ֵ = 0;

		$Result[$������Ա] = $ƽ��ֵ;
		$����������������Ա[$������Ա] = $����������;
		$������������������Ա[$������Ա] = $������������;

	}


	@arsort($Result);

	$������Ա���� = @array_keys($Result);
	$������Ա��ֵ = @array_values($Result);
	//$������Ա��ֵ[2] = '8.80';
	//print_R($������Ա��ֵ);
	//$Result['��Ա'] = '8.80';

	//������Ϣ
	$ArrayValues = @array_values($Result);
	$NewSortArrayValues = array();
	for($i=0;$i<sizeof($ArrayValues);$i++)		{
		$Values = $ArrayValues[$i];
		if(!in_array($Values,$NewSortArrayValues))	{
			$NewSortArray[$Values] = $i+1;
			array_push($NewSortArrayValues,$Values);
		}
	}
	//print_R($NewSortArray);


	for($i=0;$i<sizeof($������Ա����);$i++)		{
		$������Ա = $������Ա����[$i];
		$���� = $ResultNum[$������Ա];
		$�ۺϽ�� = $������Ա��ֵ[$i];
		$SHOWTEXT = "�۳���߷�:".$�۳���߷�[$������Ա]." �۳���ͷ�:".$�۳���ͷ�[$������Ա]." ʵ������������:".$����������������Ա[$������Ա]." ʵ���������ܷ�:".$������������������Ա[$������Ա]."";
		print "<tr class=TableData >
				<td  align=left title='$SHOWTEXT'>&nbsp;$������Ա</td>
				<td  align=left title='$SHOWTEXT'>&nbsp;".$Infor[$������Ա]['��λ']."</td>
				<td  align=left title='$SHOWTEXT'>&nbsp;".$Infor[$������Ա]['ְ��']."</td>
				<td  align=left title='$SHOWTEXT'>&nbsp;".$����."</td>
				<td  align=left title='$SHOWTEXT'>&nbsp;$�ۺϽ��</td>
				<td  align=left title='$SHOWTEXT'>&nbsp;".$NewSortArray[$�ۺϽ��]."</td>
				</tr>";
	}

print "</table></div><BR>";
?>
<p align=center>
		<input type='button' class='SmallButton' onClick="PreviewMytable();" value='Ԥ��'>&nbsp;&nbsp;
		<input type='button' class='SmallButton' onClick="PrintMytable();" value='��ӡ'  title="��ݼ�:ALT+p">&nbsp;&nbsp;
		<input type="button" value="����" class='SmallButton' ONCLICK="JsSaveAsFile();">
</P>