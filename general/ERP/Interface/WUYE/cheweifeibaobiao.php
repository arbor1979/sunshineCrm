<?php
    ini_set('display_errors', 1);
	ini_set('error_reporting', E_ALL);
	error_reporting(E_WARNING | E_ERROR);
	require_once('lib.inc.php');
	$GLOBAL_SESSION=returnsession();

   
	if($_GET['action'] == "fxp"){
        
		

		
        
		//得到传递过来参数
		$编号 = $_GET['编号'];
        //通过数据查询得到数据

		$sql = "select * from wuye_wuyetingchechangguanli where 编号='$编号'";
		$rs = $db->Execute($sql);
        $rs_a = $rs->GetArray();
        
		//for($i=0;$i<sizeof($rs_a);$i++){
			$编号       = $rs_a[0]['编号'];
			$停车位	    = $rs_a[0]['停车位'];
			$房间号码	= $rs_a[0]['房间号码'];
			$业主	    = $rs_a[0]['业主'];
			$车牌       = $rs_a[0]['车牌'];
			$车位状态	= $rs_a[0]['车位状态'];
			$缴费月份   = $rs_a[0]['所缴费月份'];
			$缴费类型   = $rs_a[0]['缴费类型'];
			$应缴费用   = $rs_a[0]['应缴费用'];
			$优惠费用   = $rs_a[0]['优惠费用'];
			$实缴费用   = $rs_a[0]['实缴费用'];

		//}


       
	}

	$sel_sql = "select 管理区名称 from wu_xiaoqumingcheng";
	$result = $db->Execute($sel_sql);
	$result_a = $result->GetArray();
	$管理区名称 = $result_a[0]['管理区名称'];


?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>无标题文档</title>
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
//打印 返回
 print "<input type=button accesskey=p name=print value=\"打印\" onClick=\"document.execCommand('Print');\" title=\"快捷键:ALT+p\">&nbsp;<input type=button accesskey=c name=cancel value=返回 class=SmallButton onClick=\"history.go(-1);\" ><br>";
}else{
 print "<input type=button accesskey=p name=print value=\"打印\" onClick=\"document.execCommand('Print');\" title=\"快捷键:ALT+p\"><br>";

}
?>
<table width="556" height="311" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
  <tr>
    <td height="37"  colspan="6"><div align="center" class="STYLE6"><b><u><?php echo  $管理区名称;?>小区专用收据</u></b></div></td>
  </tr>
  <tr>
    <td height="15" colspan="6"><span class="STYLE7">时间：<?php echo  date("Y-m-d H:i:s");?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;单号(NO):
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
	</span></td>
  </tr>
  <tr>
    <td width="28" rowspan="3"><div align="center"><strong><span class="STYLE4">付款人</span></strong></div></td>
    <td width="96" height="23"><div align="center"><span class="STYLE4">业主姓名</span></div></td>
    <td width="131">&nbsp;<?php echo  $业主;?></td>
    <td width="28" rowspan="3"><div align="center"><span class="STYLE5">规格</span></div></td>
    <td width="108"><div align="center" class="STYLE4">车牌号</div></td>
    <td width="142">&nbsp;<?php echo  $车牌;?></td>
  </tr>
  <tr>
    <td width="96" height="24"><div align="center"><span class="STYLE4">车位号</span></div></td>
    <td width="131">&nbsp;<?php echo  $停车位;?></td>
    <td width="108"><div align="center" class="STYLE4">车位状态</div></td>
    <td width="131">&nbsp;<?php echo  $车位状态;?></td>
  </tr>
  <tr>
    <td width="96" height="25"><div align="center"><span class="STYLE4">单元编号</span></div></td>
    <td width="131" height="25">&nbsp;<?php echo  $房间号码;?></td>
    <td width="108"><div align="center" class="STYLE4">费用月份</div></td>
    <td width="142">&nbsp;<?php echo  $缴费月份;?></td>
  </tr>
  <tr>
    <td height="19" colspan="6"><div align="justify" class="STYLE3"> 账单明细列表</div></td>
  </tr>
  <tr>
    <td height="29" colspan="2"><div align="center" class="STYLE4">缴费类型</div></td>
    <td><div align="center" class="STYLE4">应缴费用</div></td>
    <td colspan="2"><div align="center" class="STYLE4">优惠费用</div></td>
    <td><div align="center"><span class="STYLE4">实缴费用</span></div></td>
  </tr>
  <?php
  //for($i=0;$i<=3;$i++){
  ?>
  <tr>
    <td height="23" colspan="2">&nbsp;<?php echo  $缴费类型;?></td>
    <td>&nbsp;<?php echo  $应缴费用;?></td>
    <td colspan="2">&nbsp;<?php echo  $优惠费用;?></td>
    <td>&nbsp;<?php echo  $实缴费用;?></td>
  </tr>
  <?php
   //}	  
  ?>
  <tr>
    <td height="36" colspan="3"><span class="STYLE5">本次实收：<?php echo  $实缴费用;?></span></td>
    <td colspan="3"><div align="left" class="STYLE5"><font color="red">大写：</font><?php echo  num2rmb($实缴费用);?></div></td>
  </tr>
  <tr>
    <td height="49" colspan="6"><div align="left" class="STYLE6">收款人：</div></td>
  </tr>
</table>
<span class="STYLE1"></span>
</body>
</html>
