<?php
require_once("lib.inc.php");
$GLOBAL_SESSION=returnsession();

page_css("报修信息统计");

$当前学期=returntablefield('edu_xueqiexec','当前学期',1,'学期名称');

$sql="select 学期名称 from edu_xueqiexec";
$rs=$db->Execute($sql);
$rs_a=$rs->GetArray();

if($_GET['学期名称']==""){
    $_GET['学期名称']=$当前学期;
}
print "<table class=TableBlock align=center width=720>";
print "<tr class=TableContent>";
print "<td>学期名称：</td>";
print "<td><select name=term onChange=\"var jmpURL='?flag=1&学期名称=' + this.options[this.selectedIndex].value; if(jmpURL!='') {window.location=jmpURL;} else {this.selectedIndex=0;}\">";
for($i=0;$i<sizeof($rs_a);$i++){
    $学期名称=$rs_a[$i]['学期名称'];
	if($学期名称==$_GET['学期名称']){
	   $selected='selected';
	}
	else{
	   $selected='';
	}
	print "<option value=".$学期名称." $selected>".$学期名称."</option>";
}
print "</select></td>";

$sql="select 名称 from wygl_biaoxiuxiangmu";
$rs=$db->Execute($sql);
$rs_a=$rs->GetArray();

print "<td>报修项目：</td>";
print "<td><select name=报修项目 onChange=\"var jmpURL='?flag=1&学期名称=".$_GET['学期名称']."&名称=' +this.options[this.selectedIndex].value;        if(jmpURL!=''){window.location=jmpURL;}              else this.selectedIndex=0;\">";
print "<option value=全部>全部</option>";
for($i=0;$i<sizeof($rs_a);$i++){
    $名称=$rs_a[$i]['名称'];
	if($名称==$_GET['名称']){
	   $selected='selected';
	}
	else{
	   $selected='';
	}
	print "<option value=".$名称." $selected>".$名称."</option>";
}
print "</select></td>";
print "</tr></table>";


if($_GET['名称']==''||$_GET['名称']=='全部'){
   $sql="select 报修项目,报修内容,用料登记,费用结算,报修人,报修时间 from wygl_baoxiuxinxi where 当前学期='".$_GET['学期名称']."' and 是否受理='是'";
}
else{
   $sql="select 报修项目,报修内容,用料登记,费用结算,报修人,报修时间 from wygl_baoxiuxinxi 
      where 当前学期='".$_GET['学期名称']."' and 是否受理='是' and 报修项目='".$_GET['名称']."'";
}
$rs=$db->Execute($sql);
$rs_a=$rs->GetArray();
//echo $sql;
//dump($rs_a);
print "<br><table class=TableBlock align=center width=720>";
print "<tr class=TableContent>
      <td align=center>编号</td>
      <td align=center>报修项目</td>
	  <td align=center>报修内容</td>
	  <td align=center>用料登记</td>
	  <td align=center>报修费用</td>
	  <td align=center>报修人</td>
	  <td align=center>报修时间</td>
	  </tr>";
$总费用=0;
for($i=0;$i<sizeof($rs_a);$i++){
   $报修项目 = $rs_a[$i]['报修项目'];
   $报修内容 = $rs_a[$i]['报修内容'];
   $用料登记 = $rs_a[$i]['用料登记'];
   $报修费用 = $rs_a[$i]['费用结算'];
   $报修人 = $rs_a[$i]['报修人'];
   $报修时间 = $rs_a[$i]['报修时间'];

   $总费用+=$报修费用;

   print "<tr class=TableData>
     <td align=center>".($i+1)."</td>
      <td align=center>$报修项目</td>
	  <td align=center>$报修内容</td>
	  <td align=center>$用料登记</td>
	  <td align=center>$报修费用</td>
	  <td align=center>$报修人</td>
	  <td align=center>$报修时间</td>
	  </tr>";
}
print "<tr class=TableContent>
      <td colspan=7>合计费用： ".$总费用."￥</td></tr>";
print "</table>";
?>