<?php
ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL);

// display warnings and errors
error_reporting(E_WARNING | E_ERROR);

//header("Content-Type:text/html;charset=gbk");
//######################�������-Ȩ�޽��鲿��##########################
require_once("lib.inc.php");

$GLOBAL_SESSION=returnsession();
$SYSTEM_PRIV_STOP = 1;
require_once("systemprivateinc.php");
CheckSystemPrivate("������Դ-��������-��ʼ��");
//######################�������-Ȩ�޽��鲿��##########################

//require_once("lib.xiaoli.inc.php");
require_once("lib.xingzheng.inc.php");
$CurXueQi = returntablefield("edu_xueqiexec","��ǰѧ��",'1',"ѧ������");


//����ת���������USER_NAMEΪUSER_ID();
//�������ӽ�ʦ�û��������Ŀ��ֶ���ϢX();
//����ת���Ű�����USER_NAMEΪUSER_ID();


if($_GET['������Ա']!="")	$SHOWTEXT = "1";
else		$SHOWTEXT = "0";

//$SHOWTEXT = "1";

if($_GET['action']=="")			{
	page_css("��ʼ������");
	print "<SCRIPT>
	function FormCheck()
	{
		if (document.form1.������Ա.value == \"\") {
		alert(\"��ʦ��Ϣû����д\");
		return false;}
	}
	function td_calendar(fieldname) {
		myleft=document.body.scrollLeft+event.clientX-event.offsetX-80;
		mytop=document.body.scrollTop+event.clientY-event.offsetY+140;
		window.showModalDialog(fieldname,self,\"edge:raised;scroll:0;status:0;help:0;resizable:1;dialogWidth:280px;dialogHeight:200px;dialogTop:\"+mytop+\"px;dialogLeft:\"+myleft+\"px\");
		}
	</SCRIPT>";
	
	
	
	print "<FORM name=form1 onsubmit=\"return FormCheck();\"  action=\"?action=DataDeal&pageid=1\" method=post encType=multipart/form-data>";
	table_begin("80%");
	print "<tr class=TableHeader><td colspan=2>&nbsp;��ʼ������[�账���������,��������Ե�]</td></tr>";
	print "<tr class=TableData><td width=40%>&nbsp;��ʼ����ʼʱ��:</td><td>&nbsp;&nbsp;&nbsp;<INPUT class=SmallInput size=10  name=\"��ʼʱ��\" value=\"".date("Y-m-d",mktime(1,1,1,date('m'),date('d')-27,date('Y')))."\"  onclick=\"WdatePicker({dateFmt:'yyyy-MM-dd'})\" readonly></td></tr>";
	print "<tr class=TableData><td width=40%>&nbsp;��ʼ������ʱ��</td><td>&nbsp;&nbsp;&nbsp;<INPUT class=SmallInput size=10  name=\"����ʱ��\" value=\"".date("Y-m-d",mktime(1,1,1,date('m'),date('d')+3,date('Y')))."\"  onclick=\"WdatePicker({dateFmt:'yyyy-MM-dd'})\" readonly></td></tr>";
	print "<TR><TD class=TableData noWrap>&nbsp;������Ա:</TD>
	<TD class=TableData noWrap colspan=\"\">&nbsp;
	<input type=\"hidden\" name=\"������Ա_ID\" value=\"\">
	<input type=\"text\" name=\"������Ա\" value=\"\" readonly class=\"SmallStatic\" size=\"20\">
	<a href=\"javascript:;\" class=\"orgAdd\" onClick=\"SelectTeacherSingle('','������Ա_ID', '������Ա')\">ѡ��</a>
	</TD></TR>";
	print_submit("�ύ");
	table_end();
	form_end();

	print "<BR><BR>";
	print "<FORM name=form2 action=\"?action=DataDealALL&pageid=1\" method=post encType=multipart/form-data>";
	table_begin("80%");
	print "<tr class=TableHeader><td colspan=2>&nbsp;��ʼ������[ȫ����Ա]</td></tr>";
	print "<tr class=TableData><td width=40%>&nbsp;��ʼ��ʱ��:</td><td>&nbsp;&nbsp;&nbsp;<INPUT class=SmallInput size=10  name=��ʼʱ�� value=\"".date("Y-m-d",mktime(1,1,1,date('m'),date('d'),date('Y')))."\"  onclick=\"WdatePicker({dateFmt:'yyyy-MM-dd'})\" readonly>
	</td></tr>";
	//<input type=\"button\"  title=''  value=\"ѡ��\" class=\"SmallButton\" onclick=\"td_calendar('../../Framework/sms_index/calendar_begin.php?datetime=��ʼʱ��');\" title=\"ѡ��\" name=\"button\">
	print_submit("�ύ");
	table_end();
	form_end();


	if($_GET['action']==''||$_GET['action']=='init_default')		{
		$PrintText .= "<BR><table  class=TableBlock align=center width=80%>";
		$PrintText .= "<TR class=TableContent><td ><font color=green >
	��ʼ����<BR>
&nbsp;&nbsp;������Ű���֮��û�з��ֶ�Ӧ��Ҫ���ڵ����ݣ����Ƿ����Լ��Ŀ����������󣬿����ڴ�ģ�����³�ʼ���Լ��Ŀ������ݡ�<BR>
&nbsp;&nbsp;�ڷ�Ϊ��ʼ��ĳһ����ĳһ��ʱ����ڵĿ�����Ϣ�ͳ�ʼ��ȫ����Աĳһ��Ŀ�����Ϣ����ģʽ��
	</font></td></table>";
		print $PrintText;
	}


	exit;
}






if($_GET['action']=="DataDeal"&&$_REQUEST['������Ա']!="")			{

page_css("��ʼ������");

require_once("lib.xingzheng.inc.php");
//XiaoLiArray();



//print_R($_REQUEST);
$��ʼʱ�� = $_REQUEST['��ʼʱ��'];
$����ʱ�� = $_REQUEST['����ʱ��'];
$��ʼʱ��Array = explode('-',$��ʼʱ��);
$����ʱ��Array = explode('-',$����ʱ��);
$����ʱ�� = date("Y-m-d",mktime(1,1,1,$����ʱ��Array[1],$����ʱ��Array[2],$����ʱ��Array[0]));
$������Ա = $_REQUEST['������Ա'];
$��Ա�û��� = $_REQUEST['������Ա_ID'];

//Ĭ��180��,��ʼ��,�������,���������
for($i=0;$i<180;$i++)		{

	$Datetime	= date("Y-m-d",mktime(1,1,1,$��ʼʱ��Array[1],$��ʼʱ��Array[2] + $i,$��ʼʱ��Array[0]));
	$�����дʱ�� = date("Y-m-d",mktime(1,1,1,$��ʼʱ��Array[1],$��ʼʱ��Array[2] + $i + 10,$��ʼʱ��Array[0]));
	$����ʱ�� = date("Y-m-d");

	if($Datetime>$����ʱ��)		{
		break;
	}
	else	{


		//print "<BR>��ʼ����ǰ��ʦ����:###############<BR>";
		ִ�в���ĳ��ĳ�쿼����Ϣ($CurXueQi,$������Ա,$��Ա�û���,$Datetime);
		ͬ��ĳ��ĳ�쿼�ڻ����ݵ�������ϸ��($������Ա,$��Ա�û���,$Datetime);
		//print "<font color=green>����".$_REQUEST['������Ա']."��ʦ����:".$Datetime."</font><BR>";
		//��ʼ����ѧ�ռ�
		//$sql = "update edu_xingzheng_kaoqinmingxi set �����дʱ�� = '$�����дʱ��' where ��Ա='".$������Ա."' and ��������='$Datetime'";
		//$db->Execute($sql);
		$sql = "update `edu_xingzheng_kaoqinmingxi` set �ϰ�ʵ��ˢ��='�ϰ�ȱ��',�ϰ࿼��״̬  ='�ϰ�ȱ��' where �ϰ�ʵ��ˢ��='' and �ϰ࿼��״̬  ='' and ��Ա�û���='".$��Ա�û���."' and ����<'$����ʱ��'";
		$db->Execute($sql);
		$sql = "update `edu_xingzheng_kaoqinmingxi` set �°�ʵ��ˢ��='�°�ȱ��',�°࿼��״̬  ='�°�ȱ��' where �°�ʵ��ˢ��='' and �°࿼��״̬  ='' and ��Ա�û���='".$��Ա�û���."' and ����<'$����ʱ��'";
		$db->Execute($sql);
		//if($SHOWTEXT) print "<BR><font color=red>*******:$sql <BR></font>";


	}
}

����ٵ����˷���������();
print_infor("������ݲ����Ѿ��ɹ�,�뷵��<BR><a href='edu_xingzheng_kaoqinmingxi_newai.php?XX=XX&action=init_default&��Ա�û���=$��Ա�û���&pageid=1'>���ֱ�Ӳ���".$������Ա."��Ա�Ŀ�����ϸ</a>","location='?'","location='?'");;
exit;
}



function �Ű���ԱList($��������)			{
	global $db;
	//$��ʼʱ�� = date("Y-m-d",mktime(1,1,1,date('m'),date('d')-1,date('Y')));
	//$����ʱ�� = date("Y-m-d",mktime(1,1,1,date('m'),date('d')+14,date('Y')));
	$sql = "select �Ű���Ա from edu_xingzheng_paiban where ��������='$��������'";
	$rs = $db -> Execute($sql);
	$rs_a = $rs -> GetArray();
	$�Ű���Ա���� = array();
	for($i=0;$i<sizeof($rs_a);$i++)		{
		$�Ű���Ա = $rs_a[$i]['�Ű���Ա'];
		$�Ű���ԱArray = explode(',',$�Ű���Ա);
		for($iX=0;$iX<sizeof($�Ű���ԱArray);$iX++)		{
			$�Ű���ԱX = $�Ű���ԱArray[$iX];
			$�Ű���Ա����[$�Ű���ԱX] = $�Ű���ԱX;
		}
	}
	$�Ű���Ա����K = @array_keys($�Ű���Ա����);
	//$�Ű���Ա = join(',',$�Ű���Ա����K);
	return $�Ű���Ա����K;
}



if($_GET['action']=="DataDealALL")			{

page_css("��ʼ������");

require_once("lib.xingzheng.inc.php");
//XiaoLiArray();



//print_R($_REQUEST);
$��ʼʱ�� = $_REQUEST['��ʼʱ��'];
$����ʱ�� = $_REQUEST['����ʱ��'];
$��ʼʱ��Array = explode('-',$��ʼʱ��);


$Datetime	= date("Y-m-d",mktime(1,1,1,$��ʼʱ��Array[1],$��ʼʱ��Array[2],$��ʼʱ��Array[0]));
//print "<BR>��ʼ����ǰ��ʦ����:###############<BR>";
$�Ű���Ա����K = �Ű���ԱList($Datetime);
for($iX=0;$iX<sizeof($�Ű���Ա����K);$iX++)		{
	$��Ա�û��� = $�Ű���Ա����K[$iX];
	$������Ա = returntablefield("user","USER_ID",$��Ա�û���,"USER_NAME");
	ִ�в���ĳ��ĳ�쿼����Ϣ($CurXueQi,$������Ա,$��Ա�û���,$Datetime);
	ͬ��ĳ��ĳ�쿼�ڻ����ݵ�������ϸ��($������Ա,$��Ա�û���,$Datetime);
}
global $SHOWTEXT; if($SHOWTEXT)		print "<BR><BR><font color=red><B>����".$������Ա."��ʦ����:".$Datetime."</B></font><BR>";


����ٵ����˷���������();
$LOGIN_USER_NAME = $_SESSION['LOGIN_USER_NAME'];
print_infor("������ݲ����Ѿ��ɹ�,�뷵��","location='?'","location='?'");;
exit;
}
?>