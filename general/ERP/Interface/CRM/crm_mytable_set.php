<?php
	ini_set('display_errors', 1);
	ini_set('error_reporting', E_ALL);
	error_reporting(E_WARNING | E_ERROR);
	require_once('lib.inc.php');
	$GLOBAL_SESSION=returnsession();
    
	//��crm_mytable_cs.php���ݹ����Ĳ���д��crm_config_mytable.php�ļ���
	$goalfile = "crm_mytable/crm_config_mytable.php";
	
    if($_GET['check'] == "upd"){
		    page_css("�����������");
			$DataText = "<?php \$����ģ��λ�� = '".$_POST['mokuaiweizhi']."';\$ģ����ʾ���� = '".$_POST['xianshitiaoshu']."';\$������Ŀ��� = '".$_POST['lanmukuandu']."';\$���¹�����ʾ = '".$_POST['shangxiagundong']."';\$չ���۵�ģ�� = '".$_POST['zhankaizhedie']."';\$�����Ŀ��� = '".$_POST['left_width']."';\$��ģ����ʾ���� = '".$_POST['hanshu']."';\$�б����¹�����ʾ = '".$_POST['gongdun']."';\$����Ӧ�� = '".$_POST['hanshu_gundong_all']."';?>";	
			@!$handle = fopen($goalfile, 'w');
			fwrite($handle, $DataText);
	        fclose($handle);
			print "
			<div align=\"center\" title=\"�����������\">
			<table class=\"MessageBox\" align=\"center\" width=\"400\">
			<tr><td class=\"msg info\">
			<div class=\"content\" style=\"font-size:12pt\">&nbsp;&nbsp;���ò����Ѿ�����!</div>
			</td></tr>
			</table><br>
			<div align=center>
			";
			print "<input type=button  value=\"����\" class=\"SmallButton\" onClick=\"history.go(-1);\">
			</div>
			";
		   exit;		
		}
?>
<?php
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