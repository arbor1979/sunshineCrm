<?php
	ini_set('display_errors', 1);
	ini_set('error_reporting', E_ALL);
	error_reporting(E_WARNING | E_ERROR);

	require_once('lib.inc.php');

	$GLOBAL_SESSION=returnsession();
$SYSTEM_PRIV_STOP = 1;
	require_once("systemprivateinc.php");
	CheckSystemPrivate("������Դ-н�����-н��ͳ��");
	//print_r ($_GET);
	/*
	if($_GET['action']=="add_default_data")		{
		//print_R($_GET);print_R($_POST);//exit;
		global $db;
		$������� = (int)$_POST['�������'];$�̲ı�� = $_POST['�̲ı��'];
		$sql = "update edu_jiaocai set ���п��=���п��+$������� where �̲ı��='".$�̲ı��."'";
		$rs = $db->Execute($sql);//print $sql;exit;
		$_POST['������'] = returntablefield("edu_jiaocai","�̲ı��",$�̲ı��,"������");
		$_POST['������'] = returntablefield("edu_jiaocai","�̲ı��",$�̲ı��,"������");
		//print  "<META HTTP-EQUIV=REFRESH CONTENT='0;URL=?'>";
	}
	*/

	//���ݱ�ģ���ļ�,��ӦModelĿ¼�����hrms_salary_tongji_newai.ini�ļ�
	//�������Ҫ���ƴ�ģ��,����Ҫ�޸�$parse_filename������ֵ,Ȼ���Ӧ��ModelĿ¼ ���ļ���_newai.ini�ļ�
	$filetablename		=	'hrms_salary_tongji';
	$parse_filename		=	'hrms_salary_tongji';
	require_once('include.inc.php');


	$������Ŀ=item();
	$g=sizeof($������Ŀ);
	$g+=2;
	echo '<div id=MainData0>';
	echo '<table width="100%" class="TableBlock" align="center"><thead>';

	echo '<tr class="TableHeader" align="center"><td colspan='.$g.'>'.date('Y').'��'.date('m').'��н��ͳ��&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td></tr>';
	//<a href="send_salary_email_result.php">���͹�����</a>

	echo '<tr class="TableHeader" align="center">';
	echo '<td>����</td>';
	echo '<td>����</td>';

	//print_r($������Ŀ);
	for($i=0;$i<sizeof($������Ŀ);$i++){
		echo '<td>';
		echo $������Ŀ[$i]['��������'];
		echo '</td>';

	}
	echo '</tr></thead>';
	$name=person();
	for($x=0;$x<sizeof($name);$x++)				{
		echo '<tr class="TableData" align="center">';
		$bm=depart($name[$x]['USER_NAME']);
		echo '<td>'.$bm.'</td><td>'.$name[$x]['USER_NAME'].'</td>';
		for($y=0;$y<sizeof($������Ŀ);$y++)		{
           $salary_item=person_salary_item($name[$x]['USER_NAME'],$������Ŀ[$y]['��������']);
		   echo '<td>'.$salary_item.'</td>';
		}
		echo '</tr>';
	}

//���ݽ���
echo '<tr class="TableHeader" align="center" >';
echo '<td colspan="2">�ϼ�</td>';
$hhh=Array();
for($i=0;$i<sizeof($������Ŀ);$i++){
		echo '<td>';
        $summ=item_sum($������Ŀ[$i]['��������']);
		$hhh[$i]=$summ;
		echo $summ;
		echo '</td>';
	}
echo '</tr>';
//�ϼƽ���
echo '<tr class="TableHeader" align="center" >';
echo '<td colspan="2">�ܼ�</td>';
for($z=0;$z<sizeof($hhh);$z++){
   static $mmm;
    $mmm=$mmm+$hhh[$z];
}
if($mmm!="") echo '<td colspan='.sizeof($hhh).'>'.$mmm.'</td>';
echo '</tr>';
//�ܼƽ���

echo '</table></div>';
//	print_r($hhh);


	function item(){
		global $db;
		$sql="select �������� from hrms_salary_type order by �������� desc";
		$rs=$db->Execute($sql);
		$rs_a=$rs->GetArray();
		if(!is_array($rs_a))
			$rs_a=Array();
		$������Ŀ=$rs_a;
		return $������Ŀ;

	}
	function person_salary_item($name,$type){
		global $db;
		$h1=date("Y");
		$h2=date("m");
		//$h2=$h2-1;

		$sql="select ��� from hrms_salary_detail where ������Ա='".$name."' and ��������='".$type."' and ���='".$h1."' and �·�='".$h2."'";
		$rs=$db->Execute($sql);
		$rs_aa=$rs->fields['���'];
		//if(!is_array($rs_aa)) $rs_aa=Array();
		return $rs_aa;

	}
    function person(){
	  global $db;
	  $sql="select USER_NAME from user";
	  $rs=$db->Execute($sql);
	  $rs_name=$rs->GetArray();
      if(!is_array($rs_name)) $rs_name=Array();
	  return $rs_name;
	}
	function depart($name){
		 global $db;
		 $bmsql="select department.DEPT_NAME AS DEPT_NAME from department,user where user.DEPT_ID=department.DEPT_ID and user.USER_NAME='".$name."'";
		 $rs=$db->Execute($bmsql);
		 $rs_dp=$rs->fields['DEPT_NAME'];
		 return $rs_dp;

	}
	function item_sum($item){
        global $db;
		$h1=date("Y");
		$h2=date("m");
		//$h2=$h2-1;
	   $sql="select sum(���) AS �ܺ� from hrms_salary_detail where ��������='".$item."' and ���='".$h1."' and �·�='".$h2."'";
	   $rs=$db->Execute($sql);
	   $sum=$rs->fields['�ܺ�'];
	   return $sum;

	}

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
</script>

<p align=center>
		<input type=button class=SmallButton onClick="PreviewMytable();" value='Ԥ��'>&nbsp;&nbsp;
		<input type=button class=SmallButton onClick="PrintMytable();" value='��ӡ'  title="��ݼ�:ALT+p">&nbsp;&nbsp;
</P>
