<?php
require_once("lib.inc.php");
$GLOBAL_SESSION=returnsession();

page_css("������Ϣͳ��");

$��ǰѧ��=returntablefield('edu_xueqiexec','��ǰѧ��',1,'ѧ������');

$sql="select ѧ������ from edu_xueqiexec";
$rs=$db->Execute($sql);
$rs_a=$rs->GetArray();

if($_GET['ѧ������']==""){
    $_GET['ѧ������']=$��ǰѧ��;
}
print "<table class=TableBlock align=center width=720>";
print "<tr class=TableContent>";
print "<td>ѧ�����ƣ�</td>";
print "<td><select name=term onChange=\"var jmpURL='?flag=1&ѧ������=' + this.options[this.selectedIndex].value; if(jmpURL!='') {window.location=jmpURL;} else {this.selectedIndex=0;}\">";
for($i=0;$i<sizeof($rs_a);$i++){
    $ѧ������=$rs_a[$i]['ѧ������'];
	if($ѧ������==$_GET['ѧ������']){
	   $selected='selected';
	}
	else{
	   $selected='';
	}
	print "<option value=".$ѧ������." $selected>".$ѧ������."</option>";
}
print "</select></td>";

$sql="select ���� from wygl_biaoxiuxiangmu";
$rs=$db->Execute($sql);
$rs_a=$rs->GetArray();

print "<td>������Ŀ��</td>";
print "<td><select name=������Ŀ onChange=\"var jmpURL='?flag=1&ѧ������=".$_GET['ѧ������']."&����=' +this.options[this.selectedIndex].value;        if(jmpURL!=''){window.location=jmpURL;}              else this.selectedIndex=0;\">";
print "<option value=ȫ��>ȫ��</option>";
for($i=0;$i<sizeof($rs_a);$i++){
    $����=$rs_a[$i]['����'];
	if($����==$_GET['����']){
	   $selected='selected';
	}
	else{
	   $selected='';
	}
	print "<option value=".$����." $selected>".$����."</option>";
}
print "</select></td>";
print "</tr></table>";


if($_GET['����']==''||$_GET['����']=='ȫ��'){
   $sql="select ������Ŀ,��������,���ϵǼ�,���ý���,������,����ʱ�� from wygl_baoxiuxinxi where ��ǰѧ��='".$_GET['ѧ������']."' and �Ƿ�����='��'";
}
else{
   $sql="select ������Ŀ,��������,���ϵǼ�,���ý���,������,����ʱ�� from wygl_baoxiuxinxi 
      where ��ǰѧ��='".$_GET['ѧ������']."' and �Ƿ�����='��' and ������Ŀ='".$_GET['����']."'";
}
$rs=$db->Execute($sql);
$rs_a=$rs->GetArray();
//echo $sql;
//dump($rs_a);
print "<br><table class=TableBlock align=center width=720>";
print "<tr class=TableContent>
      <td align=center>���</td>
      <td align=center>������Ŀ</td>
	  <td align=center>��������</td>
	  <td align=center>���ϵǼ�</td>
	  <td align=center>���޷���</td>
	  <td align=center>������</td>
	  <td align=center>����ʱ��</td>
	  </tr>";
$�ܷ���=0;
for($i=0;$i<sizeof($rs_a);$i++){
   $������Ŀ = $rs_a[$i]['������Ŀ'];
   $�������� = $rs_a[$i]['��������'];
   $���ϵǼ� = $rs_a[$i]['���ϵǼ�'];
   $���޷��� = $rs_a[$i]['���ý���'];
   $������ = $rs_a[$i]['������'];
   $����ʱ�� = $rs_a[$i]['����ʱ��'];

   $�ܷ���+=$���޷���;

   print "<tr class=TableData>
     <td align=center>".($i+1)."</td>
      <td align=center>$������Ŀ</td>
	  <td align=center>$��������</td>
	  <td align=center>$���ϵǼ�</td>
	  <td align=center>$���޷���</td>
	  <td align=center>$������</td>
	  <td align=center>$����ʱ��</td>
	  </tr>";
}
print "<tr class=TableContent>
      <td colspan=7>�ϼƷ��ã� ".$�ܷ���."��</td></tr>";
print "</table>";
?>