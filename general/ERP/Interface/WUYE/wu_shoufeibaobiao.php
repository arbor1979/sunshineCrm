<?php
    ini_set('display_errors', 1);
	ini_set('error_reporting', E_ALL);
	error_reporting(E_WARNING | E_ERROR);
	require_once('lib.inc.php');
	$GLOBAL_SESSION=returnsession();

   
	if($_GET['action'] == "fxp"){
        
	    //已缴费用打印
		//<div align=center></div> class=SmallButton
		

	   $编号 = $_GET['编号'];
	   
	   $sel_sql = "select * from wu_costsummary where 编号='$编号'";
	   $rs = $db->Execute($sel_sql);
	   $rs_a = $rs->GetArray();
	   //print_r($rs_a);
	   $单元编号   = $rs_a[0]['单元编号'];
	   $业主姓名   = $rs_a[0]['业主姓名'];
	   $联系方式   = $rs_a[0]['联系方式'];
	   $费用年月份 = $rs_a[0]['费用年月份'];
	}
	if($单元编号!="" and $费用年月份!="" ){
	   $sql = "select * from wu_wpgfeesdetails where 单元编号='$单元编号' and 费用年月份='$费用年月份'";
	   $rs1 = $db->Execute($sql);
	   $rs1_a = $rs1->GetArray();

	   //print_r($rs1_a);
	   for($i=0;$i<=sizeof($rs1_a);$i++){
		   //$单元编号 = $rs1_a[$i]['单元编号'];
	       $费用名称 = $rs1_a[$i]['费用名称'];
		   $单价     = $rs1_a[$i]['单价'];
		   $数量     = $rs1_a[$i]['数量'];

           $arr[$费用名称][] = $费用名称;
		   $arr[$费用名称][] = $单价;
		   $arr[$费用名称][]= $数量;

	   }	   
	}

	/*
	$sel_sql = "select 管理区名称 from wu_xiaoqumingcheng";
	$result = $db->Execute($sel_sql);
	$result_a = $result->GetArray();
	$管理区名称 = $result_a[0]['管理区名称'];
	*/
	//print_r($arr);
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>物业收费报表</title>
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
//打印 返回
if($_GET['action'] == "fxp"){
    print "<input type=button accesskey=p name=print value=\"打印\" onClick=\"document.execCommand('Print');\" title=\"快捷键:ALT+p\">&nbsp;<input type=button accesskey=c name=cancel value=返回 class=SmallButton onClick=\"history.go(-1);\" ><br>";
}else{
    print "<input type=button accesskey=p name=print value=\"打印\" onClick=\"document.execCommand('Print');\" title=\"快捷键:ALT+p\"><br>";
}
?>
<table width="658" height="502" border="1" cellspacing="0" bordercolor="#000000" bgcolor="#F4F4F4">
  <tr>
    <td height="35" colspan="5"><div align="center" class="STYLE9">      <u><?php echo  $管理区名称;?>小区单元收费明细报表</u>
    </div></td>
  </tr>
  <tr>
    <td colspan="5">制表时间：<?php echo  date("Y-m-d H:i:s");?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;NO:
	<?php
	//给报表生成一个随机数
    //seed用户自定义函数以微秒作为种子
	function seed(){
	    list($msec,$sec) = explode(' ',microtime());
		return (float)$sec;
	}
	//播下随机数发生器种子，用srand函数调用seed函数的返回结果
	srand(seed());
	//输出产生的随机数，随机数的范围为10~10000
	echo rand(10,10000);
	?>
	</td>
  </tr>
  <tr>
    <td width="154" height="23"><span class="STYLE7">单号：</span><?php echo  rand(10,10000);?></td>
    <td colspan="3"><span class="STYLE7"><span class="STYLE10">单元编号</span>：</font><font color="green"></span><?php echo  $rs_a[0]['单元编号']?></td>
    <td><span class="STYLE7">业主姓名：<font color="green">&nbsp;</font></span><?php echo  $rs_a[0]['业主姓名']?></td>
  </tr>
  <tr>
    <td height="23" colspan="4"><span class="STYLE7">缴费年月份：<font color="green">&nbsp;<?php echo  $rs_a[0]['费用年月份']?></font></span></td>
    <td width="231" height="23"><span class="STYLE7">联系方式：</span><?php echo  $rs_a[0]['联系方式']?></td>
  </tr>
  <tr>
    <td height="23" colspan="5"><span class="STYLE5">费用明细列表</span></td>
  </tr>
  <tr>
    <td><div align="center"><strong>费用名称</strong></div></td>
    <td width="126"><div align="center"><strong>单位标准</strong></div></td>
    <td><div align="center"><strong>数量</strong></div></td>
    <td colspan="2"><div align="center"><strong>金额</strong></div></td>
  </tr>
  <tr>
    <td height="22"><div align="center">水费:</div></td>
    <td>&nbsp;<?php echo $arr['水费'][1];?></td>
    <td width="128">&nbsp;<?php echo  $arr['水费'][2];?></td>
    <td colspan="2">&nbsp;<?php echo  $rs_a[0]['水费']?></td>
  </tr>
  <tr>
    <td height="23"><div align="center">电费：</div></td>
    <td>&nbsp;<?php echo $arr['电费'][1];?></td>
    <td>&nbsp;<?php echo $arr['电费'][2];?></td>
    <td colspan="2">&nbsp;<?php echo  $rs_a[0]['电费'];?></td>
  </tr>
  <tr>
    <td height="24"><div align="center">气费：</div></td>
    <td>&nbsp;<?php echo $arr['气费'][1];?></td>
    <td>&nbsp;<?php echo $arr['气费'][2];?></td>
    <td colspan="2">&nbsp;<?php echo  $rs_a[0]['气费']?></td>
  </tr>
  <tr>
    <td height="23"><div align="center">公摊水费：</div></td>
    <td>&nbsp;<?php echo $arr['公摊水费'][1];?></td>
    <td>&nbsp;<?php echo $arr['公摊水费'][2];?></td>
    <td colspan="2">&nbsp;<?php echo  $rs_a[0]['公摊水费']?></td>
  </tr>
  <tr>
    <td height="23"><div align="center">公摊电费：</div></td>
    <td>&nbsp;<?php echo $arr['公摊电费'][1];?></td>
    <td>&nbsp;<?php echo $arr['公摊电费'][2];?></td>
    <td colspan="2">&nbsp;<?php echo  $rs_a[0]['公摊电费']?></td>
  </tr>
  <tr>
    <td height="24"><div align="center">物业管理费：</div></td>
    <td>&nbsp;<?php echo $arr['物业管理费'][1];?></td>
    <td>&nbsp;<?php echo $arr['物业管理费'][2];?></td>
    <td colspan="2">&nbsp;<?php echo  $rs_a[0]['物业管理费']?></td>
  </tr>
  <tr>
    <td height="22"><div align="center">卫生费：</div></td>
    <td>&nbsp;<?php echo $arr['卫生费'][1];?></td>
    <td>&nbsp;<?php echo $arr['卫生费'][2];?></td>
    <td colspan="2">&nbsp;<?php echo  $rs_a[0]['卫生费']?></td>
  </tr>
  <tr>
    <td height="25"><div align="center">电梯管理费：</div></td>
    <td>&nbsp;<?php echo $arr['电梯管理费'][1];?></td>
    <td>&nbsp;<?php echo $arr['电梯管理费'][2];?></td>
    <td colspan="2">&nbsp;<?php echo  $rs_a[0]['电梯管理费']?></td>
  </tr>
  <tr>
    <td height="24"><div align="center">其他费用：</div></td>
    <td>&nbsp;<?php echo $arr['其他费用'][1];?></td>
    <td>&nbsp;<?php echo $arr['其他费用'][2];?></td>
    <td colspan="2">&nbsp;<?php echo  $rs_a[0]['其他费用']?></td>
  </tr>
  <tr>
    <td><div align="center">装修押金：</div></td>
    <td>&nbsp;<?php echo $arr['装修押金'][1];?></td>
    <td height="22">&nbsp;<?php echo $arr['装修押金'][2];?></td>
    <td colspan="2">&nbsp;<?php echo  $rs_a[0]['装修押金']?></td>
  </tr>
  <tr>
    <td><div align="center">其他费用：</div></td>
    <td>&nbsp;<?php echo $arr['装修押金'][1];?></td>
    <td height="22">&nbsp;<?php echo $arr['装修押金'][2];?></td>
    <td colspan="2">&nbsp;<?php echo  $rs_a[0]['其他费用']?></td>
  </tr>
  <tr>
    <td height="24" colspan="5"><span class="STYLE8">本次应收：<font color="green">&nbsp;</font></span><?php echo  $rs_a[0]['本次应收']?></td>
  </tr>
  <tr>
    <td height="26" colspan="4"><span class="STYLE8">本次实收（小写）：&nbsp;</span><?php echo  $rs_a[0]['本次实收']?></td>
    <td height="26"><span class="STYLE5">大写：
	<?php
	/*****************************************
	//定义大写数字的数组
	$num = array(
	       0    => '零',
		   1    => '壹',
		   2    => '贰',
		   3    => '叁',
		   4    => '肆',
		   5    => '伍',
		   6    => '陆',
		   7    => '柒',
		   8    => '捌',
		   9    => '玖',
		   '角' => '角',
		   '分' => '分',
		   '十' => '拾',
		   '百' => '佰',
		   '千' => '仟',
		   '万' => '万',
	       );

    //处理得到的数字
    $本次实收 = $rs_a[0]['本次实收'];
	//处理字符串
	$a = $本次实收;
	$数字 = explode(".",$a);

	$a1 = $数字[0];
	$a2 = $数字[1];
	if($a2 == ""){
		$长度 = strlen($a);
		for($i=0;$i<$长度;$i++){
           $new_num =  substr($a,$i,1);
		   foreach($num as $key => $val){
		         if($new_num == $key){
				    $arr_new[] = $val; 
				 }		   
		   }
		}
	    if($长度 == 5){
		  $大写 = $arr_new[0]."万".$arr_new[1]."仟".$arr_new[2]."佰".$arr_new[3]."十".$arr_new[4]."元整";
		}else if($长度 == 4){
		  $大写 = $arr_new[0]."仟".$arr_new[1]."佰".$arr_new[2]."十".$arr_new[3]."元整";
		}else if($长度 == 3){
		  $大写 = $arr_new[0]."佰".$arr_new[1]."十".$arr_new[2]."元整";
		}else if($长度 == 2){
		  $大写 = $arr_new[0]."十".$arr_new[1]."元整";
		}else if($长度 == 1){
		  $大写 = $arr_new[0]."元整";
		}

		echo $大写;

	}else{
       $长度1 = strlen($a1);
       $长度2 = strlen($a2);
		for($i=0;$i<$长度1;$i++){
           $new_num =  substr($a1,$i,1);
		   foreach($num as $key => $val){
		         if($new_num == $key){
				    $arr_new1[] = $val; 
				 }		   
		   }
		}	
		for($i=0;$i<$长度2;$i++){
           $new_num =  substr($a2,$i,1);
		   foreach($num as $key1 => $val1){
		         if($new_num == $key1){
				    $arr_new2[] = $val1; 
				 }		   
		   }
		}

	    if($长度1 == 5){
		  $大写 = $arr_new1[0]."万".$arr_new1[1]."仟".$arr_new1[2]."佰".$arr_new1[3]."十".$arr_new1[4]."元".$arr_new2[0]."角".$arr_new2[1]."分整";
		}else if($长度1 == 4){
		  $大写 = $arr_new1[0]."仟".$arr_new1[1]."佰".$arr_new1[2]."十".$arr_new1[3]."元".$arr_new2[0]."角".$arr_new2[1]."分整";
		}else if($长度1 == 3){
		  $大写 = $arr_new1[0]."佰".$arr_new1[1]."十".$arr_new1[2]."元".$arr_new2[0]."角".$arr_new2[1]."分整";
		}else if($长度1 == 2){
		  $大写 = $arr_new1[0]."十".$arr_new1[1]."元".$arr_new2[0]."角".$arr_new2[1]."分整";
		}else if($长度1 == 1){
		  $大写 = $arr_new1[0]."元".$arr_new2[0]."角".$arr_new2[1]."分整";
		}

		echo $大写;
	}

******************************************
程序不完整，需要继续修改
********************************************/
    $本次实收 = $rs_a[0]['本次实收'];
    echo num2rmb($本次实收);
	?>
	</span></td>
  </tr>
  <tr>
    <td height="53" colspan="5"><span class="STYLE8">收款人(签字)： </span></td>
  </tr>
</table>
</body>
</html>
