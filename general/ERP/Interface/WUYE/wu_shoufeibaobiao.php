<?php
    ini_set('display_errors', 1);
	ini_set('error_reporting', E_ALL);
	error_reporting(E_WARNING | E_ERROR);
	require_once('lib.inc.php');
	$GLOBAL_SESSION=returnsession();

   
	if($_GET['action'] == "fxp"){
        
	    //�ѽɷ��ô�ӡ
		//<div align=center></div> class=SmallButton
		

	   $��� = $_GET['���'];
	   
	   $sel_sql = "select * from wu_costsummary where ���='$���'";
	   $rs = $db->Execute($sel_sql);
	   $rs_a = $rs->GetArray();
	   //print_r($rs_a);
	   $��Ԫ���   = $rs_a[0]['��Ԫ���'];
	   $ҵ������   = $rs_a[0]['ҵ������'];
	   $��ϵ��ʽ   = $rs_a[0]['��ϵ��ʽ'];
	   $�������·� = $rs_a[0]['�������·�'];
	}
	if($��Ԫ���!="" and $�������·�!="" ){
	   $sql = "select * from wu_wpgfeesdetails where ��Ԫ���='$��Ԫ���' and �������·�='$�������·�'";
	   $rs1 = $db->Execute($sql);
	   $rs1_a = $rs1->GetArray();

	   //print_r($rs1_a);
	   for($i=0;$i<=sizeof($rs1_a);$i++){
		   //$��Ԫ��� = $rs1_a[$i]['��Ԫ���'];
	       $�������� = $rs1_a[$i]['��������'];
		   $����     = $rs1_a[$i]['����'];
		   $����     = $rs1_a[$i]['����'];

           $arr[$��������][] = $��������;
		   $arr[$��������][] = $����;
		   $arr[$��������][]= $����;

	   }	   
	}

	/*
	$sel_sql = "select ���������� from wu_xiaoqumingcheng";
	$result = $db->Execute($sel_sql);
	$result_a = $result->GetArray();
	$���������� = $result_a[0]['����������'];
	*/
	//print_r($arr);
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>��ҵ�շѱ���</title>
<style type="text/css">
<!--
.STYLE5 {
	font-size: large;
	color: #FF0000;
}
.STYLE7 {font-size: large}
.STYLE8 {font-size: x-large}
.STYLE9 {
	font-size: xx-large;
	font-weight: bold;
}
.STYLE10 {font-size: medium}
-->
</style></head>

<body>
<?php
//��ӡ ����
if($_GET['action'] == "fxp"){
    print "<input type=button accesskey=p name=print value=\"��ӡ\" onClick=\"document.execCommand('Print');\" title=\"��ݼ�:ALT+p\">&nbsp;<input type=button accesskey=c name=cancel value=���� class=SmallButton onClick=\"history.go(-1);\" ><br>";
}else{
    print "<input type=button accesskey=p name=print value=\"��ӡ\" onClick=\"document.execCommand('Print');\" title=\"��ݼ�:ALT+p\"><br>";
}
?>
<table width="658" height="502" border="1" cellspacing="0" bordercolor="#000000" bgcolor="#F4F4F4">
  <tr>
    <td height="35" colspan="5"><div align="center" class="STYLE9">      <u><?php echo  $����������;?>С����Ԫ�շ���ϸ����</u>
    </div></td>
  </tr>
  <tr>
    <td colspan="5">�Ʊ�ʱ�䣺<?php echo  date("Y-m-d H:i:s");?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;NO:
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
	</td>
  </tr>
  <tr>
    <td width="154" height="23"><span class="STYLE7">���ţ�</span><?php echo  rand(10,10000);?></td>
    <td colspan="3"><span class="STYLE7"><span class="STYLE10">��Ԫ���</span>��</font><font color="green"></span><?php echo  $rs_a[0]['��Ԫ���']?></td>
    <td><span class="STYLE7">ҵ��������<font color="green">&nbsp;</font></span><?php echo  $rs_a[0]['ҵ������']?></td>
  </tr>
  <tr>
    <td height="23" colspan="4"><span class="STYLE7">�ɷ����·ݣ�<font color="green">&nbsp;<?php echo  $rs_a[0]['�������·�']?></font></span></td>
    <td width="231" height="23"><span class="STYLE7">��ϵ��ʽ��</span><?php echo  $rs_a[0]['��ϵ��ʽ']?></td>
  </tr>
  <tr>
    <td height="23" colspan="5"><span class="STYLE5">������ϸ�б�</span></td>
  </tr>
  <tr>
    <td><div align="center"><strong>��������</strong></div></td>
    <td width="126"><div align="center"><strong>��λ��׼</strong></div></td>
    <td><div align="center"><strong>����</strong></div></td>
    <td colspan="2"><div align="center"><strong>���</strong></div></td>
  </tr>
  <tr>
    <td height="22"><div align="center">ˮ��:</div></td>
    <td>&nbsp;<?php echo $arr['ˮ��'][1];?></td>
    <td width="128">&nbsp;<?php echo  $arr['ˮ��'][2];?></td>
    <td colspan="2">&nbsp;<?php echo  $rs_a[0]['ˮ��']?></td>
  </tr>
  <tr>
    <td height="23"><div align="center">��ѣ�</div></td>
    <td>&nbsp;<?php echo $arr['���'][1];?></td>
    <td>&nbsp;<?php echo $arr['���'][2];?></td>
    <td colspan="2">&nbsp;<?php echo  $rs_a[0]['���'];?></td>
  </tr>
  <tr>
    <td height="24"><div align="center">���ѣ�</div></td>
    <td>&nbsp;<?php echo $arr['����'][1];?></td>
    <td>&nbsp;<?php echo $arr['����'][2];?></td>
    <td colspan="2">&nbsp;<?php echo  $rs_a[0]['����']?></td>
  </tr>
  <tr>
    <td height="23"><div align="center">��̯ˮ�ѣ�</div></td>
    <td>&nbsp;<?php echo $arr['��̯ˮ��'][1];?></td>
    <td>&nbsp;<?php echo $arr['��̯ˮ��'][2];?></td>
    <td colspan="2">&nbsp;<?php echo  $rs_a[0]['��̯ˮ��']?></td>
  </tr>
  <tr>
    <td height="23"><div align="center">��̯��ѣ�</div></td>
    <td>&nbsp;<?php echo $arr['��̯���'][1];?></td>
    <td>&nbsp;<?php echo $arr['��̯���'][2];?></td>
    <td colspan="2">&nbsp;<?php echo  $rs_a[0]['��̯���']?></td>
  </tr>
  <tr>
    <td height="24"><div align="center">��ҵ����ѣ�</div></td>
    <td>&nbsp;<?php echo $arr['��ҵ�����'][1];?></td>
    <td>&nbsp;<?php echo $arr['��ҵ�����'][2];?></td>
    <td colspan="2">&nbsp;<?php echo  $rs_a[0]['��ҵ�����']?></td>
  </tr>
  <tr>
    <td height="22"><div align="center">�����ѣ�</div></td>
    <td>&nbsp;<?php echo $arr['������'][1];?></td>
    <td>&nbsp;<?php echo $arr['������'][2];?></td>
    <td colspan="2">&nbsp;<?php echo  $rs_a[0]['������']?></td>
  </tr>
  <tr>
    <td height="25"><div align="center">���ݹ���ѣ�</div></td>
    <td>&nbsp;<?php echo $arr['���ݹ����'][1];?></td>
    <td>&nbsp;<?php echo $arr['���ݹ����'][2];?></td>
    <td colspan="2">&nbsp;<?php echo  $rs_a[0]['���ݹ����']?></td>
  </tr>
  <tr>
    <td height="24"><div align="center">�������ã�</div></td>
    <td>&nbsp;<?php echo $arr['��������'][1];?></td>
    <td>&nbsp;<?php echo $arr['��������'][2];?></td>
    <td colspan="2">&nbsp;<?php echo  $rs_a[0]['��������']?></td>
  </tr>
  <tr>
    <td><div align="center">װ��Ѻ��</div></td>
    <td>&nbsp;<?php echo $arr['װ��Ѻ��'][1];?></td>
    <td height="22">&nbsp;<?php echo $arr['װ��Ѻ��'][2];?></td>
    <td colspan="2">&nbsp;<?php echo  $rs_a[0]['װ��Ѻ��']?></td>
  </tr>
  <tr>
    <td><div align="center">�������ã�</div></td>
    <td>&nbsp;<?php echo $arr['װ��Ѻ��'][1];?></td>
    <td height="22">&nbsp;<?php echo $arr['װ��Ѻ��'][2];?></td>
    <td colspan="2">&nbsp;<?php echo  $rs_a[0]['��������']?></td>
  </tr>
  <tr>
    <td height="24" colspan="5"><span class="STYLE8">����Ӧ�գ�<font color="green">&nbsp;</font></span><?php echo  $rs_a[0]['����Ӧ��']?></td>
  </tr>
  <tr>
    <td height="26" colspan="4"><span class="STYLE8">����ʵ�գ�Сд����&nbsp;</span><?php echo  $rs_a[0]['����ʵ��']?></td>
    <td height="26"><span class="STYLE5">��д��
	<?php
	/*****************************************
	//�����д���ֵ�����
	$num = array(
	       0    => '��',
		   1    => 'Ҽ',
		   2    => '��',
		   3    => '��',
		   4    => '��',
		   5    => '��',
		   6    => '½',
		   7    => '��',
		   8    => '��',
		   9    => '��',
		   '��' => '��',
		   '��' => '��',
		   'ʮ' => 'ʰ',
		   '��' => '��',
		   'ǧ' => 'Ǫ',
		   '��' => '��',
	       );

    //����õ�������
    $����ʵ�� = $rs_a[0]['����ʵ��'];
	//�����ַ���
	$a = $����ʵ��;
	$���� = explode(".",$a);

	$a1 = $����[0];
	$a2 = $����[1];
	if($a2 == ""){
		$���� = strlen($a);
		for($i=0;$i<$����;$i++){
           $new_num =  substr($a,$i,1);
		   foreach($num as $key => $val){
		         if($new_num == $key){
				    $arr_new[] = $val; 
				 }		   
		   }
		}
	    if($���� == 5){
		  $��д = $arr_new[0]."��".$arr_new[1]."Ǫ".$arr_new[2]."��".$arr_new[3]."ʮ".$arr_new[4]."Ԫ��";
		}else if($���� == 4){
		  $��д = $arr_new[0]."Ǫ".$arr_new[1]."��".$arr_new[2]."ʮ".$arr_new[3]."Ԫ��";
		}else if($���� == 3){
		  $��д = $arr_new[0]."��".$arr_new[1]."ʮ".$arr_new[2]."Ԫ��";
		}else if($���� == 2){
		  $��д = $arr_new[0]."ʮ".$arr_new[1]."Ԫ��";
		}else if($���� == 1){
		  $��д = $arr_new[0]."Ԫ��";
		}

		echo $��д;

	}else{
       $����1 = strlen($a1);
       $����2 = strlen($a2);
		for($i=0;$i<$����1;$i++){
           $new_num =  substr($a1,$i,1);
		   foreach($num as $key => $val){
		         if($new_num == $key){
				    $arr_new1[] = $val; 
				 }		   
		   }
		}	
		for($i=0;$i<$����2;$i++){
           $new_num =  substr($a2,$i,1);
		   foreach($num as $key1 => $val1){
		         if($new_num == $key1){
				    $arr_new2[] = $val1; 
				 }		   
		   }
		}

	    if($����1 == 5){
		  $��д = $arr_new1[0]."��".$arr_new1[1]."Ǫ".$arr_new1[2]."��".$arr_new1[3]."ʮ".$arr_new1[4]."Ԫ".$arr_new2[0]."��".$arr_new2[1]."����";
		}else if($����1 == 4){
		  $��д = $arr_new1[0]."Ǫ".$arr_new1[1]."��".$arr_new1[2]."ʮ".$arr_new1[3]."Ԫ".$arr_new2[0]."��".$arr_new2[1]."����";
		}else if($����1 == 3){
		  $��д = $arr_new1[0]."��".$arr_new1[1]."ʮ".$arr_new1[2]."Ԫ".$arr_new2[0]."��".$arr_new2[1]."����";
		}else if($����1 == 2){
		  $��д = $arr_new1[0]."ʮ".$arr_new1[1]."Ԫ".$arr_new2[0]."��".$arr_new2[1]."����";
		}else if($����1 == 1){
		  $��д = $arr_new1[0]."Ԫ".$arr_new2[0]."��".$arr_new2[1]."����";
		}

		echo $��д;
	}

******************************************
������������Ҫ�����޸�
********************************************/
    $����ʵ�� = $rs_a[0]['����ʵ��'];
    echo num2rmb($����ʵ��);
	?>
	</span></td>
  </tr>
  <tr>
    <td height="53" colspan="5"><span class="STYLE8">�տ���(ǩ��)�� </span></td>
  </tr>
</table>
</body>
</html>
