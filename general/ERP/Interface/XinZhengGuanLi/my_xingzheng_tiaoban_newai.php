<?php
	require_once('lib.inc.php');//

	$GLOBAL_SESSION=returnsession();
$SYSTEM_PRIV_STOP = 1;
require_once("systemprivateinc.php");
//CheckSystemPrivate("������Դ-��������-�ҵĿ���");
page_css('��������');
$��ǰѧ�� = returntablefield("edu_xueqiexec","��ǰѧ��",'1',"ѧ������");
if($_GET['ѧ��']=="") $_GET['ѧ��'] = $��ǰѧ��;
 $ѧ������ = $��ǰѧ��;

	$_GET['��Ա'] = $_SESSION['LOGIN_USER_NAME'];
	$_GET['��Ա�û���'] = $_SESSION['LOGIN_USER_ID'];
	//$_GET['����'] = returntablefield("department","DEPT_ID",$_SESSION['LOGIN_DEPT_ID'],"DEPT_NAME");


if($_GET['action']=='TiaoBanDelete')				{

	$��Ա = $_GET['��Ա'];
	$��� = $_GET['���'];
	$��Ա = $_SESSION['LOGIN_USER_NAME'];
	//������ݴ�����������ݱ༭����
	$query = "delete from edu_xingzheng_tiaoban where ���='$���' and ԭ���='$���' and ѧ��='$ѧ������' and ���״̬='0'";
	//print_R($_POST);
	//print $query;
	print "<BR><BR><div align=center><font color=green>��Ĳ����Ѿ�����!</font></div>";
	$db->Execute($query);
	//exequery($connection,$query);
	print  "<META HTTP-EQUIV=REFRESH CONTENT='0;URL=?action=add_default&RUN_ID=$RUN_ID'>\n";
	exit;
}
if($_GET['action2']=='TiaoBanDelete')				{

	$��Ա = $_GET['��Ա'];
	$��� = $_GET['���'];
	$��Ա = $_SESSION['LOGIN_USER_NAME'];
	//������ݴ�����������ݱ༭����
	$query = "delete from edu_xingzheng_tiaoban where ���='$���'  and ���״̬='0'";
	//print_R($_POST);
	//print $query;
	print "<BR><BR><div align=center><font color=green>��Ĳ����Ѿ�����!</font></div>";
	$db->Execute($query);
	//exequery($connection,$query);
	print  "<META HTTP-EQUIV=REFRESH CONTENT='0;URL=?RUN_ID=$RUN_ID'>\n";
	exit;
}


if($_GET['action']=='TiaoBanDataDeal')				{

	$��� = $_POST['���'];
	$ԭ�ϰ�ʱ�� = $_POST['ԭ�ϰ�ʱ��'];
	$ԭ�ϰ�ʱ��Array = explode(' ',$ԭ�ϰ�ʱ��);
	$ԭ�ϰ�ʱ�� = $ԭ�ϰ�ʱ��Array[0];
	$ԭ��� = $ԭ�ϰ�ʱ��Array[1];
	$���ϰ�ʱ�� = $_POST['���ϰ�ʱ��'];
	$���ϰ�ʱ��Array = explode(' ',$���ϰ�ʱ��);
	$���ϰ�ʱ�� = $���ϰ�ʱ��Array[0];
	$�°�� = $���ϰ�ʱ��Array[1];
	$��Ա = $_SESSION['LOGIN_USER_NAME'];
	//������ݴ�����������ݱ༭����

	$query = "select ��� from edu_xingzheng_tiaoban where ѧ��='$ѧ������' and ��Ա='$��Ա' and ԭ�ϰ�ʱ��='$ԭ�ϰ�ʱ��' and ԭ���='$ԭ���' and ������ID��='$RUN_ID'";
	$rs=$db->Execute($query);
	$ROW=$rs->GetArray();
	//$cursor = exequery($connection,$query);
	//$ROW = mysql_fetch_array($cursor);
    $���= $ROW[0]["���"];
	if($���!="")		{
		$query = "update edu_xingzheng_tiaoban set ���ϰ�ʱ��='$���ϰ�ʱ��',�°��='$�°��' where ���='$���'";
	}
	else	{
		$DEPT_ID = returntablefield("td_edu.user","USER_NAME",$��Ա,"DEPT_ID");
		$���� = returntablefield("td_edu.department","DEPT_ID",$DEPT_ID,"DEPT_NAME");
		$query = "insert into edu_xingzheng_tiaoban values('','$ѧ������','$����','$��Ա','$ԭ�ϰ�ʱ��','$ԭ���','$���ϰ�ʱ��','$�°��','0','$RUN_ID','$�����','$���ʱ��','".$_SESSION['LOGIN_USER_ID']."');";
	}
	//print_R($_POST);
	//print $query;exit;
	print "<BR><BR><div align=center><font color=green>��Ĳ����Ѿ�����!</font></div>";
	$db->Execute($query);
	//exequery($connection,$query);
	print  "<META HTTP-EQUIV=REFRESH CONTENT='0;URL=?action=add_default&RUN_ID=$RUN_ID'>\n";
	exit;
}



if($_GET['action']=='TiaoBan')				{
	$��� = $_GET['���'];
	$���� = $_GET['����'];
	$��� = $_GET['���'];
	$���� = $_GET['����'];
	$��Ա�û��� = $_SESSION['LOGIN_USER_ID'];

	$����XNAME = array('��','һ','��','��','��','��','��');

	$NewText = "";
	$����Array = explode("-",$����);
	//$��ʼʱ�� = date("Y-m-d",mktime(1,1,1,$����Array[1],$����Array[2]-1,$����Array[0]));
	//$����ʱ�� = date("Y-m-d",mktime(1,1,1,$����Array[1],$����Array[2]+14,$����Array[0]));
	$��ʼʱ�� = date("Y-m-d",mktime(1,1,1,date('m'),date('d')-1,date('Y')));
	$����ʱ�� = date("Y-m-d",mktime(1,1,1,date('m'),date('d')+14,date('Y')));
	$sql = "select ������� from edu_xingzheng_banci";
	//$cursor = exequery($connection,$sql);
	//while($ROW = mysql_fetch_array($cursor))			{
	$rs = $db->CacheExecute(30,$sql);
	$ROW= $rs->GetArray();
	for($i=0;$i<sizeof($ROW);$i++)			{
		$�������[]= $ROW[$i]["�������"];
	}
	//��δ��ʮ����֮�ڿ���ʹ�õ�ʱ��ν���ͳ�ƺͷ���
	for($i=-1;$i<14;$i++)		{
		$����X = date("w",mktime(1,1,1,date('m'),date('d')+$i,date('Y')));
		$����X = date("Y-m-d",mktime(1,1,1,date('m'),date('d')+$i,date('Y')));
		$returnCurWeekIndex = returnCurWeekIndex($����X);
		$query = "select ������� AS ���,�Ű���Ա AS ��Ա from edu_xingzheng_paiban where (�Ű���Ա like '%,$��Ա�û���,%' or �Ű���Ա like '$��Ա�û���,%') and ѧ������='$ѧ������' and ��������='$����X'";
		//$cursor = exequery($connection,$query);
		$rs=$db->Execute($query);
		$ROW=$rs->GetArray();
		$���Array = array();
		for($n=0;$n<sizeof($ROW);$n++) {
			$���X= $ROW[$n]["���"];
			$��Ա= $ROW[$n]["��Ա"];
			$���Array[$���X] = $ROW[$n]["���"];
		}
		//print_R($���Array);
		for($X=0;$X<sizeof($�������);$X=$X+1)		{
			$���TEMP = $�������[$X];;
			if($���Array[$���TEMP]=="")		{
				$����ʱ���б�[] = $����X." ��".$����XNAME[$����X]." ".$���TEMP."";
				$����ʱ���б�X[] = $����X." ".$���TEMP."";
			}
		}
	}

	//print_R($�������);

	$NewText .= "<select name=���ϰ�ʱ�� class=SmallSelect>";
	for($i=0;$i<sizeof($����ʱ���б�);$i++)		{
		$Element = $����ʱ���б�[$i];
		$ElementX = $����ʱ���б�X[$i];
		$NewText .= "<option value='$ElementX'>$Element</option>";
	}
	$NewText .= "</select>";
	print "<form name=form1 action='?action=TiaoBanDataDeal&RUN_ID=$RUN_ID' method=post >
	<table class=\"TableBlock\" width=\"100%\">
      <tr class=\"TableHeader\"><td nowrap align=left colspan=2>��Ա�������(ϵͳ���Զ���ʾ������Ա��δ��ʮ�����ڿ��Ű�ʱ���)</td></tr>
	  <tr class=\"TableData\"><td nowrap align=center>��Ա:</td><td nowrap align=center>".$_GET['��Ա']."</td></tr>
      <tr class=\"TableData\"><td nowrap align=center>���:</td><td nowrap align=center>".$_GET['���']."</td></tr>
	  <tr class=\"TableData\"><td nowrap align=center>ԭ�ϰ�ʱ��:</td><td nowrap align=center>".$_GET['����']."&nbsp;&nbsp;".$_GET['���']."��</td></tr>
	  <tr class=\"TableData\"><td nowrap align=center>���ϰ�ʱ��:</td><td nowrap align=center>$NewText</td></tr>
	  <tr class=\"TableData\"><td nowrap align=center colspan=2><input type=submit class=SmallButton value='�ύ'/>&nbsp;<input type=\"button\" class=\"SmallButton\" onclick= \"location='?'\" value=\"����\"></td></tr>
	  <input type=hidden name=��Ա value='$��Ա'/>
	  <input type=hidden name=��� value='".$_GET['���']."'/>
	  <input type=hidden name=ԭ�ϰ�ʱ�� value='".$_GET['����']." ".$_GET['���']."'/>
	  <input type=hidden name=��Ա value='$��Ա'/>

    ";
	print "</table></form>";
	exit;
}


if($_GET['action']=='add_default')
{
	?>

<form name=form1>
<table class="TableList" width="100%" style="border:0px">
<tr class="TableData" align="right">
      <td nowrap colspan=7 align=center>
	  	  <input type="button" class="SmallButton" onclick= "location='?'" value="����">
	</td>
    </tr>
</table>
<table class="TableList" width="100%">
    <tr class="TableHeader">
      <td nowrap align="center">��Ա</td>
      <td nowrap align="center">���</td>
	  <td nowrap align="center">ԭ�ϰ�ʱ��</td>
      <td nowrap align="center">ԭ���</td>
	  <td nowrap align="center">���ϰ�ʱ��</td>
	  <td nowrap align="center">�°��</td>
      <td nowrap align="center">����</td>
    </tr>
<?php
  $��Ա = $_SESSION['LOGIN_USER_NAME'];

  $��ʼʱ�� = date("Y-m-d",mktime(1,1,1,date('m'),date('d')-1,date('Y')));
  $����ʱ�� = date("Y-m-d",mktime(1,1,1,date('m'),date('d')+14,date('Y')));

  $query = "select ����,���,��Ա,���,���� from  edu_xingzheng_kaoqinmingxi  where ��Ա='$��Ա' and ����>='$��ʼʱ��' and ����<='$����ʱ��' order by ����,���,��Ա";
    //$cursor = exequery($connection,$query);
 // while($ROW = mysql_fetch_array($cursor)) {
  $rs = $db->CaCheExecute(30,$query);
  $ROW=$rs->GetArray();
  //�м�����
  $LINE_COUNTER = 0;
  for($i=0;$i<sizeof($ROW);$i++) {
    $���= $ROW[$i]["���"];
	$��Ա= $ROW[$i]["��Ա"];
	$���= $ROW[$i]["���"];
	$����= $ROW[$i]["����"];
	$���= $ROW[$i]["���"];
	$����= $ROW[$i]["����"];


	//������ݴ�����������ݱ༭����
	$query = "select ���ϰ�ʱ��,�°��,��� from edu_xingzheng_tiaoban where ѧ��='$ѧ������' and ��Ա='$��Ա' and ԭ�ϰ�ʱ��='$����' and ԭ���='$���'  and ������ID��='$RUN_ID'";
	$rs = $db->Execute($query);
	$ROWX = $rs->GetArray();
	//	$cursorX = exequery($connection,$query);
	//$ROWX	 = mysql_fetch_array($cursorX);
    $���ϰ�ʱ��	= $ROWX[0]["���ϰ�ʱ��"];
	$�°��		= $ROWX[0]["�°��"];
	$���		= $ROWX[0]["���"];

	$value = 0;
	//print_R($INITDATA_List);
	print "
	 <tr class=\"TableData\">
   <td nowrap align=\"center\">$��Ա</td>
   <td nowrap align=\"center\">$���</td>
   <td nowrap align=\"center\">$����</td>
   <td nowrap align=\"center\">$���</td>
   <td nowrap align=\"center\"><font color=red>$���ϰ�ʱ��</font></td>
   <td nowrap align=\"center\"><font color=red>$�°��</font></td>
   <td nowrap align=\"center\">";
   print "<input size=6 type=hidden class=SmallInput name='NAME_".$LINE_COUNTER."_VALUE' value='1'/>";
   print "<a href=\"?action=TiaoBan&RUN_ID=$RUN_ID&��Ա=$��Ա&����=$����&���=$���&����=$����\" >���е���</a>";

   if($���ϰ�ʱ��!="")		print "&nbsp;<a href=\"?action=TiaoBanDelete&RUN_ID=$RUN_ID&��Ա=$��Ա&����=$����&���=$���&����=$����&���=$���\" >ɾ��</a>";
   print "
   <input size=6  type=hidden class=SmallInput name='NAME_".$LINE_COUNTER."_ID' value='$���'/>
   <input size=6  type=hidden class=SmallInput name='NAME_".$LINE_COUNTER."_BANJI' value='$��Ա'/>
   <input size=6  type=hidden class=SmallInput name='NAME_".$LINE_COUNTER."_KECHENG' value='$���'/>
   <input size=6  type=hidden class=SmallInput name='NAME_".$LINE_COUNTER."_OLDDATE' value='$����'/>
   <input size=6  type=hidden class=SmallInput name='NAME_".$LINE_COUNTER."_OLDJIECI' value='$���'/>
   <input size=6  type=hidden class=SmallInput name='NAME_".$LINE_COUNTER."_NEWDATE' value='$���ϰ�ʱ��'/>
   <input size=6  type=hidden class=SmallInput name='NAME_".$LINE_COUNTER."_NEWJIECI' value='$�°��'/>
   </td>
	</tr>
	";
	$LINE_COUNTER++;
  }


if($LINE_COUNTER==0)	{
	$Disabled = " Disabled ";
}
else	{
	$Disabled = "";
}
?>

    <tr class="TableData" align="right">
      <td nowrap colspan=7 align=center>
	  	  <input type="button" class="SmallButton" onclick= "location='?'" value="����">
	</td>
    </tr>

</table>
<div id=HTMLSHOW></div>
</form>

	<?php
exit;
}








	$filetablename='edu_xingzheng_tiaoban';
	$parse_filename = 'my_xingzheng_tiaoban';

	require_once('include.inc.php');
	require_once('../Help/module_xingzhengworkflow.php');

?>