<?php
	ini_set('display_errors', 1);
	ini_set('error_reporting', E_ALL);
	error_reporting(E_WARNING | E_ERROR);
	require_once('lib.inc.php');
	$GLOBAL_SESSION=returnsession();

if($_GET['action']=="DataDealDelte")			{
	page_css("ɾ����Ϣ");
	$��ʼʱ�� = $_POST['��ʼʱ��']." 01:01:01";
	$����ʱ�� = $_POST['����ʱ��']." 23:59:59";
	$sql = "delete from system_logall where ��ǰʱ��>='$��ʼʱ��' and ��ǰʱ��<='$����ʱ��'";
	$db->Execute($sql);
	//print $sql;exit;
	�Ż����ݱ�("system_logall");
	print_infor("���Ĳ����Ѿ����,�뷵��...",'',"location='?'","?");
	exit;
}

	//���ݱ�ģ���ļ�,��ӦModelĿ¼�����system_logall_newai.ini�ļ�
	//�������Ҫ���ƴ�ģ��,����Ҫ�޸�$parse_filename������ֵ,Ȼ���Ӧ��ModelĿ¼ ���ļ���_newai.ini�ļ�
	$filetablename		=	'system_logall';
	$parse_filename		=	'system_logall';
	require_once('include.inc.php');



//print_R($_SESSION);
$�ܽ�ɫ���� = explode(',',$_SESSION['LOGIN_USER_PRIV'].",".$_SESSION['LOGIN_USER_PRIV_OTHER']);
if(			$_GET['action']=="init_default"
			&&in_array('1',$�ܽ�ɫ����)
			&&$_GET['actionadv']!="exportadv_default"
			)			{
	print "<SCRIPT>
	function td_calendar(fieldname) {
		myleft=document.body.scrollLeft+event.clientX-event.offsetX-80;
		mytop=document.body.scrollTop+event.clientY-event.offsetY+140;
		window.showModalDialog(fieldname,self,\"edge:raised;scroll:0;status:0;help:0;resizable:1;dialogWidth:280px;dialogHeight:200px;dialogTop:\"+mytop+\"px;dialogLeft:\"+myleft+\"px\");
		}
	</SCRIPT>";
	print "<FORM name=form1 action=\"?action=DataDealDelte&pageid=1\" method=post encType=multipart/form-data>";
	print "<table class=TableBlock width=100%>";
	print "<tr class=TableContent><td>
		&nbsp;<font color=green>������ʱ�����ɾ����¼
	��ʼʱ��: <INPUT class=SmallInput maxLength=20  name=��ʼʱ�� value=\"".date("Y-m-d",mktime(1,1,1,date('m')-1,date('d'),date('Y')))."\"  >
	<input type=\"button\"  title=''  value=\"ѡ��\" class=\"SmallButton\" onclick=\"td_calendar('../../Framework/sms_index/calendar_begin.php?datetime=��ʼʱ��');\" title=\"ѡ��\" name=\"button\">
	����ʱ��:<INPUT class=SmallInput maxLength=20  name=����ʱ�� value=\"".date("Y-m-d",mktime(1,1,1,date('m'),date('d'),date('Y')))."\"  >
	<input type=\"button\"  title=''  value=\"ѡ��\" class=\"SmallButton\" onclick=\"td_calendar('../../Framework/sms_index/calendar_begin.php?datetime=����ʱ��');\" title=\"ѡ��\" name=\"button\">
	<input type=submit class=SmallButton name='�ύ' value='�ύ'>
	</font>
		</td></tr>";
	print "</table>";
	print "</FORM>";
}

	?><?php
/*
	��Ȩ����:֣�ݵ���Ƽ�������޹�˾;
	��ϵ��ʽ:0371-69663266;
	��˾��ַ:����֣�ݾ��ü��������������־�����·ͨ�Ų�ҵ԰��¥����;
	��˾���:֣�ݵ���Ƽ�������޹�˾λ���й��в�����-֣��,������2007��1��,�����ڰѻ����Ƚ���Ϣ����������ͨ�ż���������ѹ�����ҵ��ʵ���ռ���������ҵ�ͻ��Ĺ�����ҵ���»�У�ȫ���ṩ��������֪ʶ��Ȩ�Ľ�����������������������������в�������ĸ�У���������������СѧУ��������ṩ�̡�Ŀǰ�Ѿ��ж�Ҹ�ְ����ְ��ԺУʹ��ͨ���в��з����Ŀ���������ͷ���;

	�������:����Ƽ�������������Լܹ�ƽ̨,�Լ��������֮����չ���κ��������Ʒ;
	����Э��:���ֻ�У԰��ƷΪ��ҵ���,�������ΪLICENSE��ʽ;����CRMϵͳ��SunshineCRMϵͳΪGPLV3Э�����,GPLV3Э����������뵽�ٶ�����;
	��������:�����ʹ�õ�ADODB��,PHPEXCEL��,SMTARY���ԭ��������,���´���������������;
	*/
?>