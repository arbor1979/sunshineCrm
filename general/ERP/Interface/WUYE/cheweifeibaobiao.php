<?php
    ini_set('display_errors', 1);
	ini_set('error_reporting', E_ALL);
	error_reporting(E_WARNING | E_ERROR);
	require_once('lib.inc.php');
	$GLOBAL_SESSION=returnsession();

   
	if($_GET['action'] == "fxp"){
        
		

		
        
		//�õ����ݹ�������
		$��� = $_GET['���'];
        //ͨ�����ݲ�ѯ�õ�����

		$sql = "select * from wuye_wuyetingchechangguanli where ���='$���'";
		$rs = $db->Execute($sql);
        $rs_a = $rs->GetArray();
        
		//for($i=0;$i<sizeof($rs_a);$i++){
			$���       = $rs_a[0]['���'];
			$ͣ��λ	    = $rs_a[0]['ͣ��λ'];
			$�������	= $rs_a[0]['�������'];
			$ҵ��	    = $rs_a[0]['ҵ��'];
			$����       = $rs_a[0]['����'];
			$��λ״̬	= $rs_a[0]['��λ״̬'];
			$�ɷ��·�   = $rs_a[0]['���ɷ��·�'];
			$�ɷ�����   = $rs_a[0]['�ɷ�����'];
			$Ӧ�ɷ���   = $rs_a[0]['Ӧ�ɷ���'];
			$�Żݷ���   = $rs_a[0]['�Żݷ���'];
			$ʵ�ɷ���   = $rs_a[0]['ʵ�ɷ���'];

		//}


       
	}

	$sel_sql = "select ���������� from wu_xiaoqumingcheng";
	$result = $db->Execute($sel_sql);
	$result_a = $result->GetArray();
	$���������� = $result_a[0]['����������'];


?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>�ޱ����ĵ�</title>
<style type="text/css">
<!--
.STYLE1 {color: #FFFFFF}
.STYLE3 {
	font-size: large;
	font-weight: bold;
}
.STYLE4 {font-size: x-large}
.STYLE5 {font-size: x-large; font-weight: bold; }
.STYLE6 {font-size: xx-large}
.STYLE7 {font-size: medium}
-->

</style>
</head>
<body>
<?php
if($_GET['action'] == "fxp"){
//��ӡ ����
 print "<input type=button accesskey=p name=print value=\"��ӡ\" onClick=\"document.execCommand('Print');\" title=\"��ݼ�:ALT+p\">&nbsp;<input type=button accesskey=c name=cancel value=���� class=SmallButton onClick=\"history.go(-1);\" ><br>";
}else{
 print "<input type=button accesskey=p name=print value=\"��ӡ\" onClick=\"document.execCommand('Print');\" title=\"��ݼ�:ALT+p\"><br>";

}
?>
<table width="556" height="311" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
  <tr>
    <td height="37"  colspan="6"><div align="center" class="STYLE6"><b><u><?php echo  $����������;?>С��ר���վ�</u></b></div></td>
  </tr>
  <tr>
    <td height="15" colspan="6"><span class="STYLE7">ʱ�䣺<?php echo  date("Y-m-d H:i:s");?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;����(NO):
	<?php
	//����������һ�������
    //seed�û��Զ��庯����΢����Ϊ����
	function seed(){
	    list($msec,$sec) = explode(' ',microtime());
		return (float)$sec;
	}
	//������������������ӣ���srand��������seed�����ķ��ؽ��
	srand(seed());
	//����������������������ķ�ΧΪ10~10000
	echo rand(10,10000);
	?>
	</span></td>
  </tr>
  <tr>
    <td width="28" rowspan="3"><div align="center"><strong><span class="STYLE4">������</span></strong></div></td>
    <td width="96" height="23"><div align="center"><span class="STYLE4">ҵ������</span></div></td>
    <td width="131">&nbsp;<?php echo  $ҵ��;?></td>
    <td width="28" rowspan="3"><div align="center"><span class="STYLE5">���</span></div></td>
    <td width="108"><div align="center" class="STYLE4">���ƺ�</div></td>
    <td width="142">&nbsp;<?php echo  $����;?></td>
  </tr>
  <tr>
    <td width="96" height="24"><div align="center"><span class="STYLE4">��λ��</span></div></td>
    <td width="131">&nbsp;<?php echo  $ͣ��λ;?></td>
    <td width="108"><div align="center" class="STYLE4">��λ״̬</div></td>
    <td width="131">&nbsp;<?php echo  $��λ״̬;?></td>
  </tr>
  <tr>
    <td width="96" height="25"><div align="center"><span class="STYLE4">��Ԫ���</span></div></td>
    <td width="131" height="25">&nbsp;<?php echo  $�������;?></td>
    <td width="108"><div align="center" class="STYLE4">�����·�</div></td>
    <td width="142">&nbsp;<?php echo  $�ɷ��·�;?></td>
  </tr>
  <tr>
    <td height="19" colspan="6"><div align="justify" class="STYLE3"> �˵���ϸ�б�</div></td>
  </tr>
  <tr>
    <td height="29" colspan="2"><div align="center" class="STYLE4">�ɷ�����</div></td>
    <td><div align="center" class="STYLE4">Ӧ�ɷ���</div></td>
    <td colspan="2"><div align="center" class="STYLE4">�Żݷ���</div></td>
    <td><div align="center"><span class="STYLE4">ʵ�ɷ���</span></div></td>
  </tr>
  <?php
  //for($i=0;$i<=3;$i++){
  ?>
  <tr>
    <td height="23" colspan="2">&nbsp;<?php echo  $�ɷ�����;?></td>
    <td>&nbsp;<?php echo  $Ӧ�ɷ���;?></td>
    <td colspan="2">&nbsp;<?php echo  $�Żݷ���;?></td>
    <td>&nbsp;<?php echo  $ʵ�ɷ���;?></td>
  </tr>
  <?php
   //}	  
  ?>
  <tr>
    <td height="36" colspan="3"><span class="STYLE5">����ʵ�գ�<?php echo  $ʵ�ɷ���;?></span></td>
    <td colspan="3"><div align="left" class="STYLE5"><font color="red">��д��</font><?php echo  num2rmb($ʵ�ɷ���);?></div></td>
  </tr>
  <tr>
    <td height="49" colspan="6"><div align="left" class="STYLE6">�տ��ˣ�</div></td>
  </tr>
</table>
<span class="STYLE1"></span>
</body>
</html>
