<?php
	ini_set('display_errors', 1);
	ini_set('error_reporting', E_ALL);
	error_reporting(E_WARNING | E_ERROR);
	require_once('lib.inc.php');
	$GLOBAL_SESSION=returnsession();

	include("erp_mytable/crm_config_mytable.php");
?>

<link rel="stylesheet" type="text/css" href="<?php echo ROOT_DIR?>theme/3/style.css">
<html>
<head>
<title>ģ�����</title>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<link rel="stylesheet" type="text/css" href="<?php echo ROOT_DIR?>theme/3/dialog.css" />

<script type="text/javascript" src="<?php echo ROOT_DIR?>inc/js/utility.js"></script>
<script type="text/javascript" src="<?php echo ROOT_DIR?>inc/js/module.js"></script>
<script src="<?php echo ROOT_DIR?>inc/js/dialog.js"></script>

<script Language="JavaScript">
function delete_url(MODULE_ID)
{
 msg='ȷ��Ҫ��ͣ��ģ����';
 if(window.confirm(msg))
 {
  URL="delete.php?MODULE_ID=" + MODULE_ID;
  window.location=URL;
 }
}

//��ʾ�����ҵ����ø��������û������� by dq 090613
function set_mine_to_others()
{
   ShowDialog("optionBlock");
}

function set_others_submit() {
   var statc_str = document.getElementById("statc_str").value;

   mytop=(screen.availHeight-430) / 2;
   myleft=(screen.availWidth-600) / 2;
   window.open("/module/feedback/?FEED_BACK_CONTENT=" + statc_str,"","height=430,width=600,status=0,toolbar=no,menubar=no,location=no,scrollbars=yes,top="+mytop+",left="+myleft+", resizable=yes");
}

function set_success()
{
   alert("���³ɹ���");
   HideDialog('optionBlock');
}

function CheckForm()
{
   if(document.form2.COPY_TO_ID.value=="")
   {
   	 alert("��ָ��Ҫ���µ���Ա��");
     return (false);
   }

   return (true);
}

</script>
</head>

<body class="bodycolor" topmargin="5">
<table border="0" width="100%" cellspacing="0" cellpadding="3" class="small">
  <tr>
    <td class="Big"><span class="big3">&nbsp;CRM�����������</span>
    </td>
  </tr>
</table>
<table class="TableBlock" width="500" align="center">
  <form action="crm_mytable_set.php?check=upd"  method="post" name="form1">
   <tr class="TableHeader">
    <td colspan="2">CRM����ȫ������</td>
   </tr>
   <tr class="TableData">
    <td>CRM�������ã�</td>
    <td>
      <input type="checkbox" name="mokuaiweizhi" id="mokuaiweizhi" checked/><label for="mokuaiweizhi">�����û�����������ģ��λ��</label><br>
	  <input type="checkbox" name="xianshitiaoshu" id="xianshitiaoshu" checked/><label for="xianshitiaoshu">�����û�����������ģ����ʾ����</label><br>
      <input type="checkbox" name="lanmukuandu" id="lanmukuandu" <?phpif($������Ŀ��� == 'on'){ echo "checked";}?>/><label for="lanmukuandu">�����û�����������Ŀ���</label><br>
      <input type="checkbox" name="shangxiagundong" id="shangxiagundong" <?phpif($���¹�����ʾ == 'on'){ echo "checked";}?>/><label for="shangxiagundong">�����û������б����¹�����ʾ</label><br>
      <input type="checkbox" name="zhankaizhedie" id="zhankaizhedie" <?phpif($չ���۵�ģ�� == 'on'){ echo "checked";}?>/><label for="zhankaizhedie">�����û�չ��/�۵�����ģ��</label><br>
    </td>
   </tr>
   <tr class="TableData">
    <td>�����Ŀ��ȣ�</td>
    <td><input type="text" name="left_width" class="BigInput" size="5" <?phpif($�����Ŀ��� != ''){ echo "value='".$�����Ŀ���."'";}else{echo "value=60";}?>>%</td>
   </tr>
   <tr class="TableData">
    <td>��ģ����ʾ������</td>
    <td><input type="text" name="hanshu" class="BigInput" size="5" <?phpif($��ģ����ʾ���� != ''){ echo "value='".$��ģ����ʾ����."'";}else{echo "value=5";}?>>�� ע����Ҫ>4</td>
   </tr>
   <tr class="TableData">
    <td width="130">����ģ��Ĭ��ֵ<br>��������</td>
    <td>
      <input type="checkbox" name="gongdun" id="gongdun" <?phpif($�б����¹�����ʾ == 'on'){ echo "checked";}?>/><label for="gongdun">�б����¹�����ʾ</label><br>
      <input type="checkbox" name="hanshu_gundong_all" id="hanshu_gundong_all" <?phpif($����Ӧ�� == 'on'){ echo "checked";}?>/><label for="hanshu_gundong_all">ȷ�ϰ�ÿģ����ʾ������������ʾ��������Ӧ�õ�����ģ��</label><br>
    </td>
   </tr>
   <tr>
    <td nowrap  class="TableControl" colspan="2" align="center">
       <input type="submit" value="ȷ��" class="BigButton">&nbsp;&nbsp;
       <input type="reset" value="����" class="BigButton">
                  <!-- <a href="javascript:;" onClick="set_mine_to_others();">���ҵ����ø��������û�(���ҵ�ǰ���濴����һ��)</a> -->
    </td>
   </tr>
  </form>


<!-- ����֡�����ҵ����ø��������û�ʱʹ�� by dq 090617
<iframe name="hiddenFrame" id="hiddenFrame" width=0 height=0 frameborder=0 scrolling=no></iframe>
-->

</body>
</html>

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