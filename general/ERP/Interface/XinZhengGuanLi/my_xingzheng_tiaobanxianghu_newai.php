<?php
	require_once('lib.inc.php');//

	$GLOBAL_SESSION=returnsession();
$SYSTEM_PRIV_STOP = 1;
require_once("systemprivateinc.php");
//CheckSystemPrivate("������Դ-��������-�ҵĿ���");
page_css('�໥��������');

$��ǰѧ�� = returntablefield("edu_xueqiexec","��ǰѧ��",'1',"ѧ������");
if($_GET['ѧ��']=="") $_GET['ѧ��'] = $��ǰѧ��;

 $ѧ������ = $��ǰѧ��;
	$_GET['ԭ��Ա'] = $_SESSION['LOGIN_USER_NAME'];
	$_GET['ԭ��Ա�û���'] = $_SESSION['LOGIN_USER_ID'];
	//$_GET['ԭ����'] = returntablefield("department","DEPT_ID",$_SESSION['LOGIN_DEPT_ID'],"DEPT_NAME");




if($_GET['action']=='TiaoKeDataDeal')				{
	//2009-10-19 1-2 ׯ���� ��ҳ��Ч
	$ԭ��� = $_POST['���'];
	$ԭ�ϰ�ʱ�� = $_POST['ԭ�ϰ�ʱ��'];
	$ԭ�ϰ�ʱ��Array = explode(' ',$ԭ�ϰ�ʱ��);
	$ԭ�ϰ�ʱ�� = $ԭ�ϰ�ʱ��Array[0];
	$ԭ��� = $ԭ�ϰ�ʱ��Array[1];
	$���ϰ�ʱ�� = $_POST['���ϰ�ʱ��'];
	$���ϰ�ʱ��Array = explode(' ',$���ϰ�ʱ��);
	$���ϰ�ʱ�� = $���ϰ�ʱ��Array[0];
	$�°�� = $���ϰ�ʱ��Array[1];
	$����Ա = $���ϰ�ʱ��Array[2];
	$����Ա�û��� = $���ϰ�ʱ��Array[3];
	$��Ա = $_SESSION['LOGIN_USER_NAME'];
	$ԭ��Ա = $_SESSION['LOGIN_USER_NAME'];
	//print_R($_POST);exit;
	//������ݴ�����������ݱ༭����
	$query = "select ��� from edu_xingzheng_tiaobanxianghu where ѧ��='$ѧ������'  and ԭ�ϰ�ʱ��='$ԭ�ϰ�ʱ��' and ԭ��Ա='$��Ա' and ԭ���='$ԭ���' and ������ID��='$RUN_ID'";
	$rs = $db->Execute($query);
	$ROW = $rs->GetArray();
    $���= $ROW[0]["���"];
	if($���!="")		{
		$query = "update edu_xingzheng_tiaobanxianghu set ���ϰ�ʱ��='$���ϰ�ʱ��',�°��='$�°��',����Ա='$����Ա',�°��='$�°��' where ���='$���'";
	}
	else	{
		$DEPT_ID = returntablefield("td_edu.user","USER_NAME",$ԭ��Ա,"DEPT_ID");
		$ԭ���� = returntablefield("td_edu.department","DEPT_ID",$DEPT_ID,"DEPT_NAME");
		$DEPT_ID = returntablefield("td_edu.user","USER_NAME",$����Ա,"DEPT_ID");
		$�²��� = returntablefield("td_edu.department","DEPT_ID",$DEPT_ID,"DEPT_NAME");
		$query = "insert into edu_xingzheng_tiaobanxianghu values('','$ѧ������','$ԭ����','$ԭ��Ա','$ԭ�ϰ�ʱ��','$ԭ���','$�²���','$����Ա','$���ϰ�ʱ��','$�°��','0','$RUN_ID','$�����','$���ʱ��','".$_SESSION['LOGIN_USER_ID']."','$����Ա�û���');";
	}
	//print_R($_POST);
	//print $query;exit;
	print "<BR><BR><div align=center><font color=green>��Ĳ����Ѿ�����!</font></div>";
	$db->Execute($query);
	//exequery($connection,$query);
	print  "<META HTTP-EQUIV=REFRESH CONTENT='0;URL=?action=add_default&RUN_ID=$RUN_ID'>\n";
	exit;
}

if($_GET['action']=='TiaoKeDelete')				{

	$���� = $_GET['����'];
	$��� = $_GET['���'];
	$��Ա = $_SESSION['LOGIN_USER_NAME'];
	//������ݴ�����������ݱ༭����
	$query = "delete from edu_xingzheng_tiaobanxianghu where ���='$���' and ԭ���='$���' and ѧ��='$ѧ������' and ���״̬='0'";
	//print_R($_POST);
	//print $query;
	print "<BR><BR><div align=center><font color=green>��Ĳ����Ѿ�����!</font></div>";
	$db->Execute($query);
	//exequery($connection,$query);
	print  "<META HTTP-EQUIV=REFRESH CONTENT='0;URL=?action=add_default&RUN_ID=$RUN_ID'>\n";
	exit;
}
if($_GET['action2']=='TiaoKeDelete')				{

	$���� = $_GET['����'];
	$��� = $_GET['���'];
	$��Ա = $_SESSION['LOGIN_USER_NAME'];
	//������ݴ�����������ݱ༭����
	$query = "delete from edu_xingzheng_tiaobanxianghu where ���='$���'  and ���״̬='0'";
	//print_R($_POST);
	//print $query;
	print "<BR><BR><div align=center><font color=green>��Ĳ����Ѿ�����!</font></div>";
	$db->Execute($query);
	//exequery($connection,$query);
	print  "<META HTTP-EQUIV=REFRESH CONTENT='0;URL=?RUN_ID=$RUN_ID'>\n";
	exit;
}



if($_GET['action']=='TiaoKe')				{
	$��Ա = $_GET['��Ա'];
	$��� = $_GET['���'];
	$���� = $_GET['����'];
	$��� = $_GET['���'];
	$���� = $_GET['����'];

	$����XNAME = array('��','һ','��','��','��','��','��');

	$NewText = "";
	$����Array = explode("-",$����);
	//$��ʼʱ�� = date("Y-m-d",mktime(1,1,1,$����Array[1],$����Array[2]-1,$����Array[0]));
	//$����ʱ�� = date("Y-m-d",mktime(1,1,1,$����Array[1],$����Array[2]+14,$����Array[0]));
	$��ʼʱ�� = date("Y-m-d",mktime(1,1,1,date('m'),date('d')-1,date('Y')));
	$����ʱ�� = date("Y-m-d",mktime(1,1,1,date('m'),date('d')+14,date('Y')));

      $��Ա = $_SESSION['LOGIN_USER_NAME'];
	  $��ʼʱ�� = date("Y-m-d",mktime(1,1,1,date('m'),date('d')-1,date('Y')));
	  $����ʱ�� = date("Y-m-d",mktime(1,1,1,date('m'),date('d')+14,date('Y')));

	  $query = "select ����,���,����,��Ա,����,��Ա�û��� from  edu_xingzheng_kaoqinmingxi  where ��Ա�û���!='$��Ա�û���' and ����>='$��ʼʱ��' and ����<='$����ʱ��' order by ����,���,��Ա�û���";
	  $rs = $db->Execute($query);
	  $ROW = $rs->GetArray();
	  //�м�����
	  $LINE_COUNTER = 0;
	  for($i=0;$i<sizeof($ROW);$i++) {
		$���X2= $ROW[$i]["���"];
		$����= $ROW[$i]["����"];
		$���= $ROW[$i]["���"];
		$����= $ROW[$i]["����"];
		$���= $ROW[$i]["���"];
		$��Ա= $ROW[$i]["��Ա"];
		$��Ա�û���= $ROW[$i]["��Ա�û���"];
		$����= $ROW[$i]["����"];
		$����ʱ���б�[] = $����." ��".$����." ".$���." ".$��Ա." ".$���;
		$����ʱ���б�X[] = $����." ".$���." ".$��Ա." ".$��Ա�û���;

	  }
	  //print_R($query);

	$QUERY_STRING = $_SERVER['QUERY_STRING'];
	$QUERY_STRING_array = explode('XXX=XXX',$QUERY_STRING);
	$QUERY_STRING = $QUERY_STRING_array[0];
	$������Ա�б� = @array_keys($��Ա�б�);
	@sort($������Ա�б�);
	//onChange=\"var jmpURL='?$QUERY_STRING&XXX=XXX&����Ա=' + this.options[this.selectedIndex].value ; if(jmpURL!='') {window.location=jmpURL;} else {this.selectedIndex=0 ;}\"

	$NewText .= "<select name=���ϰ�ʱ�� class=SmallSelect>\n";
	for($i=0;$i<sizeof($����ʱ���б�);$i++)		{
		$Element = $����ʱ���б�[$i];
		$ElementX = $����ʱ���б�X[$i];
		$NewText .= "<option value='$ElementX'>$Element</option>\n";
	}
	$NewText .= "</select>\n";
	print "<form name=form1 action='?action=TiaoKeDataDeal&RUN_ID=$RUN_ID' method=post>
	<table class=\"TableBlock\" width=\"100%\">
      <tr class=\"TableHeader\"><td nowrap align=left colspan=2>��Ա�����໥����(ϵͳ���Զ���ʾ��ǰ������δ��ʮ�����ڿ��Ű�ʱ���)</td></tr>
	  <tr class=\"TableData\"><td nowrap align=center>����:</td><td nowrap align=center>".$_GET['����']."</td></tr>
      <tr class=\"TableData\"><td nowrap align=center>��Ա:</td><td nowrap align=center>".$��Ա."</td></tr>
	  <tr class=\"TableData\"><td nowrap align=center>ԭ�ϰ�ʱ��:</td><td nowrap align=center>".$_GET['����']."&nbsp;&nbsp;".$_GET['���']."��</td></tr>
	  <tr class=\"TableData\"><td nowrap align=center>�໥������Ϣ:</td><td nowrap align=center>$NewText</td></tr>
	  <tr class=\"TableData\"><td nowrap align=center colspan=2><input type=submit class=SmallButton value='�ύ'/> <input type=button class=SmallButton onclick=location='?action=add_default' value='����'/></td></tr>
	  <input type=hidden name=���� value='".$_GET['����']."'/>
	  <input type=hidden name=��� value='".$_GET['���']."'/>
	  <input type=hidden name=ԭ�ϰ�ʱ�� value='".$_GET['����']." ".$_GET['���']." $��Ա'/>
	  <input type=hidden name=��Ա value='$��Ա'/>

    ";
	print "</table></form>";
	exit;
}






	if($_GET['action']=="add_default")
	{
	 //print_R($_GET);
	 ?>



<form name=form1>
<table class="TableList" width="100%" style="border:0px">
    <tr class="TableData" align="right">
     <td nowrap colspan=7 align=center>
	  <input type="button" class="SmallButton" onclick=location='?'  value="����">
	</td>
    </tr>
</table>
<table class="TableList" width="100%">
    <tr class="TableHeader">
      <td nowrap align="center">ԭ��Ա</td>
	  <td nowrap align="center">ԭ�ϰ�ʱ��</td>
      <td nowrap align="center">ԭ���</td>
	  <td nowrap align="center">����Ա</td>
	  <td nowrap align="center">���ϰ�ʱ��</td>
	  <td nowrap align="center">�°��</td>
      <td nowrap align="center">����</td>
    </tr>
<?php
  $��Ա = $_SESSION['LOGIN_USER_NAME'];
  $��Ա�û��� = $_SESSION['LOGIN_USER_ID'];

  $��ʼʱ�� = date("Y-m-d",mktime(1,1,1,date('m'),date('d')-1,date('Y')));
  $����ʱ�� = date("Y-m-d",mktime(1,1,1,date('m'),date('d')+14,date('Y')));

  $query = "select ����,���,����,���,����,��� from  edu_xingzheng_kaoqinmingxi  where ��Ա�û���='$��Ա�û���' and ����>='$��ʼʱ��' and ����<='$����ʱ��' order by ����,���,����";

   // $cursor = exequery($connection,$query);
  //�м�����
  //$LINE_COUNTER = 0;
  //while($ROW = mysql_fetch_array($cursor)) {
  $rs = $db->CacheExecute(30,$query);
  $ROW=$rs->GetArray();
  //�м�����
  $LINE_COUNTER = 0;
  //print_R(sizeof($ROW));
  for($i=0;$i<sizeof($ROW);$i++) {
	//  print $i;
    $���X= $ROW[$i]["���"];
	$����= $ROW[$i]["����"];
	$���= $ROW[$i]["���"];
	$����= $ROW[$i]["����"];
	$���= $ROW[$i]["���"];
	$����= $ROW[$i]["����"];


	//������ݴ�����������ݱ༭����
	$query = "select * from edu_xingzheng_tiaobanxianghu where ѧ��='$ѧ������' and ԭ��Ա�û���='$��Ա�û���' and ԭ�ϰ�ʱ��='$����' and ԭ���='$���'  and ���״̬='0'  and ������ID��='$RUN_ID'";
	$rs=$db->Execute($query);
	$ROWX=$rs->GetArray();
	//cursorX = exequery($connection,$query);
	//$ROWX	 = mysql_fetch_array($cursorX);
	//print_R($query);
    $���ϰ�ʱ��	= $ROWX[0]["���ϰ�ʱ��"];
	$����Ա		= $ROWX[0]["����Ա"];
	$����Ա�û���		= $ROWX[0]["����Ա�û���"];
	$�°��		= $ROWX[0]["�°��"];
	$ԭ�ϰ�ʱ��	= $ROWX[0]["ԭ�ϰ�ʱ��"];
	$ԭ��Ա		= $ROWX[0]["ԭ��Ա"];
	$ԭ��Ա�û���		= $ROWX[0]["ԭ��Ա�û���"];
	$ԭ���		= $ROWX[0]["ԭ���"];
	$���		= $ROWX[0]["���"];

	//�õ��滻����Ա���ڵ�IDֵ
	if($����Ա!="")			{
		$query = "select ��� from  edu_xingzheng_kaoqinmingxi  where ѧ��='$ѧ������' and ��Ա�û���='$����Ա�û���' and ����='$���ϰ�ʱ��' and ���='$�°��' and ���='$�°��'";
		$cursorXX = $db->Execute($query);
		$ROWXX	 = $rs->GetArray();
		$���X2	= $ROWXX[0]["���"];
		//print $���X2;
		//print $query;//exit;
	}else	{
		$���X2 = "";
	}
	$value = 0;
	//print_R($INITDATA_List);
	print "
	 <tr class=\"TableData\">
   <td nowrap align=\"center\">$��Ա</td>
   <td nowrap align=\"center\">$����</td>
   <td nowrap align=\"center\">$���</td>
   <td nowrap align=\"center\"><font color=red>$����Ա</font></td>
   <td nowrap align=\"center\"><font color=red>$���ϰ�ʱ��</font></td>
   <td nowrap align=\"center\"><font color=red>$�°��</font></td>
   <td nowrap align=\"center\">";
   print "<input size=6 type=hidden class=SmallInput name='NAME_".$LINE_COUNTER."_VALUE' value='1'/>";
   print "<a href=\"?action=TiaoKe&RUN_ID=$RUN_ID&���=$���&����=$����&���=$���&����=$����&����=$����\" >�����໥����</a>";


   if($���ϰ�ʱ��!="")		print "&nbsp;<a href=\"?action=TiaoKeDelete&RUN_ID=$RUN_ID&���=$���&����=$����&���=$���&����=$����&���=$���\" >ɾ��</a>";
   print "
   <input size=6  type=hidden class=SmallInput name='NAME_".$LINE_COUNTER."_ID' value='$���'/>
   <input size=6  type=hidden class=SmallInput name='NAME_".$LINE_COUNTER."_BANJI' value='$����'/>
   <input size=6  type=hidden class=SmallInput name='NAME_".$LINE_COUNTER."_KECHENG' value='$���'/>
   <input size=6  type=hidden class=SmallInput name='NAME_".$LINE_COUNTER."_OLDTEACHER' value='$ԭ��Ա'/>
   <input size=6  type=hidden class=SmallInput name='NAME_".$LINE_COUNTER."_OLDCOURSE' value='$ԭ���'/>
   <input size=6  type=hidden class=SmallInput name='NAME_".$LINE_COUNTER."_NEWTEACHER' value='$����Ա'/>
   <input size=6  type=hidden class=SmallInput name='NAME_".$LINE_COUNTER."_NEWCOURSE' value='$�°��'/>
   <input size=6  type=hidden class=SmallInput name='NAME_".$LINE_COUNTER."_OLDDATE' value='$����'/>
   <input size=6  type=hidden class=SmallInput name='NAME_".$LINE_COUNTER."_OLDJIECI' value='$���'/>
   <input size=6  type=hidden class=SmallInput name='NAME_".$LINE_COUNTER."_NEWDATE' value='$���ϰ�ʱ��'/>
   <input size=6  type=hidden class=SmallInput name='NAME_".$LINE_COUNTER."_NEWJIECI' value='$�°��'/>
   <input size=6  type=hidden class=SmallInput name='NAME_".$LINE_COUNTER."_KQOQINID' value='$���X'/>
   <input size=6  type=hidden class=SmallInput name='NAME_".$LINE_COUNTER."_KQOQINID2' value='$���X2'/>
   </td>
	</tr>
	";
	$LINE_COUNTER++;
  }

?>

    <tr class="TableData" align="right">
      <td nowrap colspan=7 align=center>
	  <input type="button" class="SmallButton" onclick=location='?'  value="����">
	</td>
    </tr>

</table>
<div id=HTMLSHOW></div>
</form>


	 <?php
	 exit;
	}

	$filetablename='edu_xingzheng_tiaobanxianghu';
	$parse_filename = 'my_xingzheng_tiaobanxianghu';

	require_once('include.inc.php');
	require_once('../Help/module_xingzhengworkflow.php');

?>