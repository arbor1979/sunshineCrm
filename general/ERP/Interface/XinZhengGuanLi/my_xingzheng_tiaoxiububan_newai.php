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

if($_GET['action']=='BuBanDataDeal')				{

	//$���� = $_GET['����'];
	//$��� = $_GET['���'];
	//$����ʱ�� = $_GET['����'];
	//$���ݰ�� = $_GET['���'];
	//$��Ա = $_SESSION['LOGIN_USER_NAME'];
	$����ʱ��Array = explode(' ',$_POST['����ʱ��']);
	$����ʱ�� = $����ʱ��Array[0];
	$������ = $����ʱ��Array[1];
	$��� = $_POST['���'];

	$query = "update edu_xingzheng_tiaoxiububan set ����ʱ��='$����ʱ��',������='$������' where ���='$���'";
	//print_R($_POST);
	//print $query;exit;
	print "<BR><BR><div align=center><font color=green>��Ĳ����Ѿ�����!</font></div>";
	$db->Execute($query);
	//exequery($connection,$query);
	print  "<META HTTP-EQUIV=REFRESH CONTENT='0;URL=?RUN_ID=$RUN_ID'>\n";
	exit;
}

if($_GET['action']=='BuBanDelete')				{

	$���� = $_GET['����'];
	$��� = $_GET['���'];
	$��Ա = $_SESSION['LOGIN_USER_NAME'];
	//������ݴ�����������ݱ༭����
	//$query = "delete from edu_xingzheng_tiaoxiububan where ���='$���' and ���='$���' and ѧ��='$ѧ������' and �������״̬='0'";
	$��� = $_GET['���'];
	$query = "update edu_xingzheng_tiaoxiububan set ����ʱ��='0000-00-00',������='' where ���='$���'";
	//print_R($_POST);
	//print $query;
	print "<BR><BR><div align=center><font color=green>��Ĳ����Ѿ�����!</font></div>";
	$db->Execute($query);
	//exequery($connection,$query);
	print  "<META HTTP-EQUIV=REFRESH CONTENT='0;URL=?RUN_ID=$RUN_ID'>\n";
	exit;
}

if($_GET['action']=='bubanaction')				{
	$��� = $_GET['���'];
	$sql = "select * from edu_xingzheng_tiaoxiububan where ��� = '$���'";
	$rs = $db->Execute($sql);
	$ROW = $rs->GetArray();
	$��Ա = $ROW[0]['��Ա'];
	$��Ա�û��� = $ROW[0]['��Ա�û���'];
	$���� = $ROW[0]['����'];
	$��� = $ROW[0]['���ݰ��'];
	$����ʱ�� = $ROW[0]['����ʱ��'];
	$���� = $ROW[0]['����'];
	//print_R($ROW);
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
	$ROW = $rs->GetArray();
	for($i=0;$i<sizeof($ROW);$i++)			{
		$�������[]= $ROW[$i]["�������"];
	}
	//��δ��ʮ����֮�ڿ���ʹ�õ�ʱ��ν���ͳ�ƺͷ���
	for($i=-1;$i<14;$i++)		{
		$����X = date("w",mktime(1,1,1,date('m'),date('d')+$i,date('Y')));
		$����X = date("Y-m-d",mktime(1,1,1,date('m'),date('d')+$i,date('Y')));
		$returnCurWeekIndex = returnCurWeekIndex($����X);
		$query = "select ������� AS ���,�Ű���Ա AS ��Ա from edu_xingzheng_paiban where (�Ű���Ա like '%,$��Ա�û���,%' or �Ű���Ա like '$��Ա�û���,%') and ѧ������='$ѧ������' and ��������='$����X'";
		$rs = $db->Execute($query);
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

	$NewText .= "<select name=����ʱ�� class=SmallSelect>";
	for($i=0;$i<sizeof($����ʱ���б�);$i++)		{
		$Element = $����ʱ���б�[$i];
		$ElementX = $����ʱ���б�X[$i];
		$NewText .= "<option value='$ElementX'>$Element</option>";
	}
	$NewText .= "</select>";
	print "<form name=form1 action='?action=BuBanDataDeal&RUN_ID=$RUN_ID' method=post >
	<table class=\"TableBlock\" width=\"100%\">
      <tr class=\"TableHeader\"><td nowrap align=left colspan=2>��Ա���벹��(ϵͳ���Զ���ʾ���ò�����δ��ʮ�����ڿ��Ű�ʱ���)</td></tr>
	  <tr class=\"TableData\"><td nowrap align=center>����:</td><td nowrap align=center>".$����."</td></tr>
      <tr class=\"TableData\"><td nowrap align=center>��Ա:</td><td nowrap align=center>".$��Ա."</td></tr>
	  <tr class=\"TableData\"><td nowrap align=center>����ʱ��:</td><td nowrap align=center>".$����ʱ��."&nbsp;&nbsp;".$���."</td></tr>
	  <tr class=\"TableData\"><td nowrap align=center>����ʱ��:</td><td nowrap align=center>$NewText</td></tr>
	  <tr class=\"TableData\"><td nowrap align=center colspan=2><input type=submit class=SmallButton value='�ύ'/>
	  <input type=button class=SmallButton onclick=location='?' value='����'/></td></tr>
	  <input type=hidden name=���� value='$����'/>
	  <input type=hidden name=��� value='$���'/>
	  <input type=hidden name=��� value='".$���."'/>
	  <input type=hidden name=����ʱ�� value='".$����ʱ��." ".$���."'/>
	  <input type=hidden name=��Ա value='$��Ա'/>

    ";
	print "</table></form>";
	exit;
}


//==================================����==================================================

if($_GET['action']=='TiaoXiuDataDeal')				{
	//print_R($_GET);
	$���� = $_GET['����'];
	$��� = $_GET['���'];
	$����ʱ�� = $_GET['����'];
	$���ݰ�� = $_GET['���'];
	$��Ա = $_GET['��Ա'];
	$������ = $���ݰ��;
	//$����� = $_SESSION['LOGIN_USER_NAME'];
	//������ݴ�����������ݱ༭����
	$query = "select ��� from edu_xingzheng_tiaoxiububan where ѧ��='$ѧ������' and ��Ա='$��Ա' and ����ʱ��='$����ʱ��' and ���ݰ��='$���ݰ��' and ���ݹ�����ID��='$RUN_ID'";
	$rs=$db->Execute($query);
	$ROW=$rs->GetArray();
	//$cursor = exequery($connection,$query);
	//$ROW = mysql_fetch_array($cursor);
    $���= $ROW[0]["���"];
	$query = "insert into edu_xingzheng_tiaoxiububan values('','$ѧ������','$����','$��Ա','$����ʱ��','$���ݰ��','$����ʱ��','$������','0','$RUN_ID','$�����','$���ʱ��','0','','','','".$_SESSION['LOGIN_USER_ID']."');";
	//print_R($_POST);
	//print $query;exit;
	print "<BR><BR><div align=center><font color=green>��Ĳ����Ѿ�����!</font></div>";
	$db->Execute($query);
	//exequery($connection,$query);
	print  "<META HTTP-EQUIV=REFRESH CONTENT='0;URL=?action=add_default&RUN_ID=$RUN_ID'>\n";
	exit;
}

if($_GET['action']=='TiaoXiuDelete')				{

	$���� = $_GET['����'];
	$��� = $_GET['���'];
	$��Ա = $_SESSION['LOGIN_USER_NAME'];
	//������ݴ�����������ݱ༭����
	$query = "delete from edu_xingzheng_tiaoxiububan where ���='$���' and ���ݰ��='$���' and ѧ��='$ѧ������' and ��Ա='$��Ա' and �������״̬='0' and ���ݹ�����ID��='$RUN_ID' ";
	//print_R($_POST);
	//print $query;
	print "<BR><BR><div align=center><font color=green>��Ĳ����Ѿ�����!</font></div>";
	$db->Execute($query);
	//exequery($connection,$query);
	print  "<META HTTP-EQUIV=REFRESH CONTENT='0;URL=?action=add_default&RUN_ID=$RUN_ID'>\n";
	exit;
}





if($_GET['action']=='add_default')
{
	?>
<form name=form1>
<table class="TableList" width="100%" style="border:0px">
    <tr class="TableData" align="right">
      <td nowrap colspan=5 align=center>
	  <input type="button" class="SmallButton" onclick=location='?' <?php echo $Disabled?> value="����">
	</td>
    </tr>
</table>
<table class="TableList" width="100%">
    <tr class="TableHeader">
      <td nowrap align="center">����</td>
      <td nowrap align="center">���</td>
	  <td nowrap align="center">����ʱ��</td>
      <td nowrap align="center">���ݰ��</td>
      <td nowrap align="center">����</td>
    </tr>
<?php
  $��Ա = $_SESSION['LOGIN_USER_NAME'];
  $��Ա = $_SESSION['LOGIN_USER_NAME'];

  $��ʼʱ�� = date("Y-m-d",mktime(1,1,1,date('m'),date('d')-1,date('Y')));
  $����ʱ�� = date("Y-m-d",mktime(1,1,1,date('m'),date('d')+14,date('Y')));

  $query = "select ����,���,����,���,����,��Ա from  edu_xingzheng_kaoqinmingxi  where ��Ա='$��Ա' and ����>='$��ʼʱ��' and ����<='$����ʱ��' order by ����,���,����";
  //$cursor = exequery($connection,$query);
  $rs=$db->CacheExecute(30,$query);
  $ROW=$rs->GetArray();
  //�м�����
  $LINE_COUNTER = 0;
  for($i=0;$i<sizeof($ROW);$i++) {
	  // while($ROW = mysql_fetch_array($cursor)) {
    $���= $ROW[$i]["���"];
	$����= $ROW[$i]["����"];
	$���= $ROW[$i]["���"];
	$����= $ROW[$i]["����"];
	$���= $ROW[$i]["���"];
	$��Ա= $ROW[$i]["��Ա"];
	$����= $ROW[$i]["����"];


	//������ݴ�����������ݱ༭����
	$query = "select ����ʱ��,������,��� from edu_xingzheng_tiaoxiububan where ѧ��='$ѧ������' and ��Ա='$��Ա' and ����ʱ��='$����' and ���ݰ��='$���'  and ���ݹ�����ID��='$RUN_ID'";
	 $rs=$db->Execute($query);
	 $ROWX=$rs->GetArray();
	//$cursorX = exequery($connection,$query);
	//$ROWX	 = mysql_fetch_array($cursorX);
	$���		= $ROWX[0]["���"];

	$value = 0;
	//print_R($INITDATA_List);
	print "
	 <tr class=\"TableData\">
   <td nowrap align=\"center\">$����</td>
   <td nowrap align=\"center\">$���</td>
   <td nowrap align=\"center\">$����</td>
   <td nowrap align=\"center\">$���</td>
   <td nowrap align=\"center\">";
   print "<input size=6 type=hidden class=SmallInput name='NAME_".$LINE_COUNTER."_VALUE' value='1'/>";
   if($���!="")	{
	   print "&nbsp;������ <a href=\"?action=TiaoXiuDelete&RUN_ID=$RUN_ID&��Ա=$��Ա&���=$���&����=$����&����=$����&����=$����&���=$���\" >ɾ��</a>";
	   $����ʱ�� = $����;
   }
   else		{
	   print "<a href=\"?action=TiaoXiuDataDeal&RUN_ID=$RUN_ID&��Ա=$��Ա&���=$���&����=$����&����=$����&����=$����\" >�������</a>";
	   $����ʱ�� = '';
   }

   print "
   <input size=6  type=hidden class=SmallInput name='NAME_".$LINE_COUNTER."_ID' value='$���'/>
   <input size=6  type=hidden class=SmallInput name='NAME_".$LINE_COUNTER."_BANJI' value='$����'/>
   <input size=6  type=hidden class=SmallInput name='NAME_".$LINE_COUNTER."_KECHENG' value='$��Ա'/>
   <input size=6  type=hidden class=SmallInput name='NAME_".$LINE_COUNTER."_OLDDATE' value='$����'/>
   <input size=6  type=hidden class=SmallInput name='NAME_".$LINE_COUNTER."_OLDJIECI' value='$���'/>
   <input size=6  type=hidden class=SmallInput name='NAME_".$LINE_COUNTER."_NEWDATE' value='$����ʱ��'/>
   <input size=6  type=hidden class=SmallInput name='NAME_".$LINE_COUNTER."_NEWJIECI' value='$������'/>
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
      <td nowrap colspan=5 align=center>

	  <input type="button" class="SmallButton" onclick=location='?' <?php echo $Disabled?> value="����">
	</td>
    </tr>

</table>
<div id=HTMLSHOW></div>
</form>

	<?php
exit;
}




	$filetablename='edu_xingzheng_tiaoxiububan';
	$parse_filename = 'my_xingzheng_tiaoxiububan';

	require_once('include.inc.php');
	require_once('../Help/module_xingzhengworkflow.php');

?>