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
CheckSystemPrivate("������Դ-��������-�ҵĿ���");
//######################�������-Ȩ�޽��鲿��##########################


$CurXueQi = returntablefield("edu_xueqiexec","��ǰѧ��",'1',"ѧ������");
$LOGIN_USER_NAME = $_SESSION['LOGIN_USER_NAME'];
$LOGIN_USER_ID = $_SESSION['LOGIN_USER_ID'];

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
	print "<tr class=TableData><td width=40%>&nbsp;��ʼ����ʼʱ��:</td><td>&nbsp;&nbsp;<INPUT class=SmallInput size=10  name=\"��ʼʱ��\" value=\"".date("Y-m-d",mktime(1,1,1,date('m'),date('d')-30,date('Y')))."\"  onclick=\"WdatePicker({dateFmt:'yyyy-MM-dd'})\" readonly></td></tr>";
	print "<tr class=TableData><td width=40%>&nbsp;��ʼ������ʱ��:</td><td>&nbsp;&nbsp;<INPUT class=SmallInput size=10  name=\"����ʱ��\" value=\"".date("Y-m-d",mktime(1,1,1,date('m'),date('d'),date('Y')))."\"  onclick=\"WdatePicker({dateFmt:'yyyy-MM-dd'})\" readonly></td></tr>";
	print "<TR><TD class=TableData noWrap>&nbsp;������Ա:</TD>
	<TD class=TableData noWrap colspan=\"$LOGIN_USER_NAME\">&nbsp;<input type=\"hidden\" name=\"������Ա_ID\" value=\"$LOGIN_USER_ID\">&nbsp;<input type=\"text\" name=\"������Ա\" value=\"$LOGIN_USER_NAME\" readonly class=\"SmallStatic\" size=\"20\">
	</TD></TR>";
	print_submit("�ύ");
	table_end();
	form_end();


	exit;
}






if($_GET['action']=="DataDeal"&&$_REQUEST['������Ա']!="")			{

page_css("��ʼ������");

require_once("lib.xingzheng.inc.php");
//XiaoLiArray();

//����ʱ�䰴ʱ���������ִ��

//
$��ʼʱ�� = $_REQUEST['��ʼʱ��'];
$����ʱ�� = $_REQUEST['����ʱ��'];
$��ʼʱ��Array = explode('-',$��ʼʱ��);
$����ʱ��Array = explode('-',$����ʱ��);
$����ʱ�� = date("Y-m-d",mktime(1,1,1,$����ʱ��Array[1],$����ʱ��Array[2],$����ʱ��Array[0]));
$������Ա = $_REQUEST['������Ա'];
$��Ա�û��� = $_REQUEST['������Ա_ID'];
//print_R($_REQUEST);

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
		$sql = "update `edu_xingzheng_kaoqinmingxi` set �ϰ�ʵ��ˢ��='�ϰ�ȱ��',�ϰ࿼��״̬  ='�ϰ�ȱ��' where �ϰ�ʵ��ˢ��='' and �ϰ࿼��״̬  ='' and ��Ա='".$������Ա."' and ����<'$����ʱ��'";
		$db->Execute($sql);
		$sql = "update `edu_xingzheng_kaoqinmingxi` set �°�ʵ��ˢ��='�°�ȱ��',�°࿼��״̬  ='�°�ȱ��' where �°�ʵ��ˢ��='' and �°࿼��״̬  ='' and ��Ա='".$������Ա."' and ����<'$����ʱ��'";
		$db->Execute($sql);
		//if($SHOWTEXT) print "<BR><font color=red>*******:$sql <BR></font>";


	}
}

����ٵ����˷���������();
$LOGIN_USER_NAME = $_SESSION['LOGIN_USER_NAME'];
$LOGIN_USER_ID = $_SESSION['LOGIN_USER_ID'];
print_infor("������ݲ����Ѿ��ɹ�,�뷵��<BR><a href='my_xingzheng_kaoqinmingxi_newai.php?XX=XX&action=init_default&��Ա�û���=$��Ա�û���&pageid=1'>���ֱ�Ӳ��ĸ���Ա�Ŀ�����ϸ</a>","location='?'","location='?'");;
exit;
}




?>