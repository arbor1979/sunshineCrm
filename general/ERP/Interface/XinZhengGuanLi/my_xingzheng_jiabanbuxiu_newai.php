<?php
	require_once('lib.inc.php');//

	$GLOBAL_SESSION=returnsession();
$SYSTEM_PRIV_STOP = 1;
require_once("systemprivateinc.php");
//CheckSystemPrivate("������Դ-��������-�ҵĿ���");
page_css('�Ӱಹ��');

$��ǰѧ�� = returntablefield("edu_xueqiexec","��ǰѧ��",'1',"ѧ������");
if($_GET['ѧ��']=="") $_GET['ѧ��'] = $��ǰѧ��;
$ѧ������ = $��ǰѧ��;
$��Ա�û��� = $_SESSION['LOGIN_USER_ID'];


	$_GET['��Ա'] = $_SESSION['LOGIN_USER_NAME'];
	$_GET['��Ա�û���'] = $_SESSION['LOGIN_USER_ID'];
	//$_GET['����'] = returntablefield("department","DEPT_ID",$_SESSION['LOGIN_DEPT_ID'],"DEPT_NAME");
	$filetablename='edu_xingzheng_jiabanbuxiu';
	$parse_filename = 'my_xingzheng_jiabanbuxiu';


//======================================����=================================================

if($_GET['action']=='BuXiuDelete')				{

	$���� = $_GET['����'];
	$��� = $_GET['���'];
	$��Ա = $_SESSION['LOGIN_USER_NAME'];
	//������ݴ�����������ݱ༭����
	//$query = "delete from edu_xingzheng_jiabanbuxiu where ���='$���' and ���='$���' and ѧ��='$ѧ������' and �Ӱ����״̬='0'";
	$��� = $_GET['���'];
	$query = "update edu_xingzheng_jiabanbuxiu set ����ʱ��='0000-00-00' where ���='$���'";
	//print_R($_POST);
	//print $query;
	print "<BR><BR><div align=center><font color=green>��Ĳ����Ѿ�����!</font></div>";
	$db->Execute($query);
	//exequery($connection,$query);
	print  "<META HTTP-EQUIV=REFRESH CONTENT='0;URL=?action=buxiuaction&RUN_ID=$RUN_ID'>\n";
	exit;
}

if($_GET['action']=='BuXiu')				{
  $����XNAME = array('��','һ','��','��','��','��','��');
  $��ʼʱ�� = date("Y-m-d",mktime(1,1,1,date('m'),date('d')-1,date('Y')));
  $����ʱ�� = date("Y-m-d",mktime(1,1,1,date('m'),date('d')+14,date('Y')));
  $���= $_GET["���"];
  // and ���='$���'
  $query = "select ����,���,����,���,����,��Ա,��� from  edu_xingzheng_kaoqinmingxi  where ��Ա�û���='$��Ա�û���' and ����>='$��ʼʱ��' and ����<='$����ʱ��' order by ����,���,����";
  //print_R($query);
  	$rs=$db->CaCheExeCute(30,$query);
	$ROW=$rs->GetArray();

  //$cursor = exequery($connection,$query);
  //�м�����
  $LINE_COUNTER = 0;
 for($i=0;$i<sizeof($ROW);$i++) {
	   //while($ROW = mysql_fetch_array($cursor)) {
	$����= $ROW[$i]["����"];
	$���= $ROW[$i]["���"];
	$����= $ROW[$i]["����"];
	$���= $ROW[$i]["���"];
	$��Ա= $ROW[$i]["��Ա"];
	$����= $ROW[$i]["����"];
	$����ʱ���б�[] = $����." ��".$����XNAME[$����]." ".$���."";
	$����ʱ���б�X[] = $����." ".$���."";
	$LINE_COUNTER++;
  }

	$NewText .= "<select name=����ʱ�� class=SmallSelect>";
	for($i=0;$i<sizeof($����ʱ���б�);$i++)		{
		$Element = $����ʱ���б�[$i];
		$ElementX = $����ʱ���б�X[$i];
		$NewText .= "<option value='$ElementX'>$Element</option>";
	}
	$NewText .= "</select>";
	print "<form name=form1 action='?action=BuXiuDataDeal&RUN_ID=$RUN_ID' method=post>
	<table class=\"TableBlock\" width=\"100%\">
      <tr class=\"TableHeader\"><td nowrap align=left colspan=2>��Ա���벹��(ϵͳ���Զ���ʾ���ò�����δ��ʮ�����ڿ��Ű�ʱ���)</td></tr>
	  <tr class=\"TableData\"><td nowrap align=center>����:</td><td nowrap align=center>".$_GET['����']."</td></tr>
      <tr class=\"TableData\"><td nowrap align=center>��Ա:</td><td nowrap align=center>".$_GET['��Ա']."</td></tr>
	  <tr class=\"TableData\"><td nowrap align=center>�Ӱ�ʱ��:</td><td nowrap align=center>".$_GET['����']."&nbsp;&nbsp;".$_GET['���']."</td></tr>
	  <tr class=\"TableData\"><td nowrap align=center>����ʱ��:</td><td nowrap align=center>$NewText</td></tr>
	  <tr class=\"TableData\"><td nowrap align=center colspan=2><input type=submit class=SmallButton value='�ύ'/></td></tr>
	  <input type=hidden name=���� value='$����'/>
	  <input type=hidden name=��� value='".$_GET['���']."'/>
	  <input type=hidden name=��� value='".$_GET['���']."'/>
	  <input type=hidden name=�Ӱ�ʱ�� value='".$_GET['����']." ".$_GET['���']."'/>
	  <input type=hidden name=��Ա value='$��Ա'/>

    ";
	print "</table></form>";
	exit;
}

if($_GET['action']=='BuXiuDataDeal')				{

	$����ʱ��Array = explode(' ',$_POST['����ʱ��']);
	$����ʱ�� = $����ʱ��Array[0];
	$���ݰ�� = $����ʱ��Array[1];
	$��� = $_POST['���'];

	$query = "update edu_xingzheng_jiabanbuxiu set ����ʱ��='$����ʱ��',���ݰ��='$���ݰ��',���ݹ�����ID��='$RUN_ID' where ���='$���'";
	//print_R($_POST);
	//print $query;exit;
	print "<BR><BR><div align=center><font color=green>��Ĳ����Ѿ�����!</font></div>";
	$db->Execute($query);
	//exequery($connection,$query);
	print  "<META HTTP-EQUIV=REFRESH CONTENT='0;URL=?RUN_ID=$RUN_ID'>\n";
	exit;
}


if($_GET['action']=='buxiuaction')
{
	?>


<form name=form1>
<table class="TableList" width="100%" style="border:0px">
    <tr class="TableData">
			<td nowrap align=center colspan=8>

			<input type=button accesskey='c' name='cancel' value=' ���� ' class=SmallButton onClick="location='?'">
			</td>
		</tr>
</table>
<table class="TableList" width="100%">
    <tr class="TableHeader">
      <td nowrap align="center">����</td>
      <td nowrap align="center">��Ա</td>
	  <td nowrap align="center">�Ӱ�ʱ��</td>
      <td nowrap align="center">�Ӱ���</td>
	  <td nowrap align="center">����ʱ��</td>
      <td nowrap align="center">���ݰ��</td>
      <td nowrap align="center">����</td>
    </tr>
<?php
  $��Ա = $_SESSION['LOGIN_USER_NAME'];

  //print_R($_SESSION);
  $��ʼʱ�� = date("Y-m-d",mktime(1,1,1,date('m'),date('d')-1,date('Y')));
  $����ʱ�� = date("Y-m-d",mktime(1,1,1,date('m'),date('d')+14,date('Y')));

  //$query = "select ����,���,����,���,����,��Ա from  edu_xingzheng_kaoqinmingxi  where ��Ա='$��Ա' and ����>='$��ʼʱ��' and ����<='$����ʱ��' order by ����,���,����";
  //$cursor = exequery($connection,$query);
  //$��Ա = $_GET['��Ա'];
  //������ݴ�����������ݱ༭����
  $query = "select * from edu_xingzheng_jiabanbuxiu where ѧ��='$ѧ������' and ��Ա='$��Ա' and �Ӱ����״̬='1' and �������״̬='0'";
  //print $query;
  //$cursor = exequery($connection,$query);
	$rs=$db->ExeCute($query);
	//$rs=$db->CaCheExeCute(30,$query);
	$ROW=$rs->GetArray();
  //�м�����
  $LINE_COUNTER = 0;
  for($i=0;$i<sizeof($ROW);$i++) {
	  //while($ROW = mysql_fetch_array($cursor)) {
    $���= $ROW[$i]["���"];
	$����= $ROW[$i]["����"];
	$����= $ROW[$i]["����"];
	$��Ա= $ROW[$i]["��Ա"];
	$�Ӱ�ʱ��= $ROW[$i]["�Ӱ�ʱ��"];
	$�Ӱ���= $ROW[$i]["�Ӱ���"];

	$����ʱ��= $ROW[$i]["����ʱ��"]; if($����ʱ��=='0000-00-00') $����ʱ��='';
	$���ݰ��= $ROW[$i]["���ݰ��"];

	$���� = $�Ӱ�ʱ��;
	$value = 0;
	//print_R($INITDATA_List);
	print "
	 <tr class=\"TableData\">
   <td nowrap align=\"center\">$����</td>
   <td nowrap align=\"center\">$��Ա</td>
   <td nowrap align=\"center\">$�Ӱ�ʱ��</td>
   <td nowrap align=\"center\">$�Ӱ���</td>
   <td nowrap align=\"center\">$����ʱ��</td>
   <td nowrap align=\"center\">$���ݰ��</td>
   <td nowrap align=\"center\">";
   print "<input size=6 type=hidden class=SmallInput name='NAME_".$LINE_COUNTER."_VALUE' value='1'/>";
   if($����ʱ��!="")	{
	   print "&nbsp;������ <a href=\"?action=BuXiuDelete&RUN_ID=$RUN_ID&��Ա=$��Ա&����=$����&����=$����&���=$�Ӱ���&����=$�Ӱ�ʱ��&���=$���\" >ɾ��</a>";
	   //$����ʱ�� = $����;
   }
   else		{
	   print "<a href=\"?action=BuXiu&RUN_ID=$RUN_ID&��Ա=$��Ա&����=$����&����=$����&���=$�Ӱ���&����=$�Ӱ�ʱ��&���=$���\" >���벹��</a>";
	   $����ʱ�� = '';
   }

   print "
   <input size=6  type=hidden class=SmallInput name='NAME_".$LINE_COUNTER."_ID' value='$���'/>
   <input size=6  type=hidden class=SmallInput name='NAME_".$LINE_COUNTER."_BANJI' value='$����'/>
   <input size=6  type=hidden class=SmallInput name='NAME_".$LINE_COUNTER."_KECHENG' value='$��Ա'/>
   <input size=6  type=hidden class=SmallInput name='NAME_".$LINE_COUNTER."_OLDDATE' value='$�Ӱ�ʱ��'/>
   <input size=6  type=hidden class=SmallInput name='NAME_".$LINE_COUNTER."_OLDJIECI' value='$�Ӱ���'/>
   <input size=6  type=hidden class=SmallInput name='NAME_".$LINE_COUNTER."_NEWDATE' value='$����ʱ��'/>
   <input size=6  type=hidden class=SmallInput name='NAME_".$LINE_COUNTER."_NEWJIECI' value='$���ݰ��'/>
   </td>
	</tr>
	";
	$LINE_COUNTER++;
  }



?>

    <tr class="TableData">
			<td nowrap align=center colspan=8>

			<input type=button accesskey='c' name='cancel' value=' ���� ' class=SmallButton onClick="location='?'">
			</td>
		</tr>

</table>
<div id=HTMLSHOW></div>
</form>
	<?php
	exit;
}












//======================================�Ӱ�===================================================

if($_GET['action']=='JiaBanDataDeal')				{
	//print_R($_GET);
	$���� = $_GET['����'];
	$��� = $_GET['���'];
	$�Ӱ�ʱ�� = $_GET['����'];
	$�Ӱ��� = $_GET['���'];
	$��Ա = $_GET['��Ա'];
	$���ݰ�� = $�Ӱ���;
	//$query = "select ��� from edu_xingzheng_jiabanbuxiu where ѧ��='$ѧ������' and ��Ա='$��Ա' and �Ӱ�ʱ��='$�Ӱ�ʱ��' and �Ӱ���='$�Ӱ���' and �Ӱ๤����ID��='$RUN_ID'";
	//$cursor = exequery($connection,$query);
	//$ROW = mysql_fetch_array($cursor);
    //$���= $ROW["���"];
	$DEPT_ID = returntablefield("td_edu.user","USER_NAME",$��Ա,"DEPT_ID");
	$���� = returntablefield("td_edu.department","DEPT_ID",$DEPT_ID,"DEPT_NAME");
	$query = "insert into edu_xingzheng_jiabanbuxiu values('','$ѧ������','$����','$��Ա','$�Ӱ�ʱ��','$�Ӱ���','$����ʱ��','$���ݰ��','0','$RUN_ID','$�����','$���ʱ��','0','','','','".$_SESSION['LOGIN_USER_ID']."');";
	//print_R($_POST);
	//print $query;exit;
	print "<BR><BR><div align=center><font color=green>��Ĳ����Ѿ�����!</font></div>";
	//exequery($connection,$query);
	$db->Execute($query);
	print  "<META HTTP-EQUIV=REFRESH CONTENT='0;URL=?action=add_default&RUN_ID=$RUN_ID'>\n";
	exit;
}

if($_GET['action']=='JiaBanDelete')				{

	$���� = $_GET['����'];
	$��� = $_GET['���'];
	$��Ա = $_SESSION['LOGIN_USER_NAME'];
	//������ݴ�����������ݱ༭����
	$query = "delete from edu_xingzheng_jiabanbuxiu where ���='$���' and �Ӱ���='$���' and ѧ��='$ѧ������' and ��Ա='$��Ա' and �Ӱ����״̬='0' and �Ӱ๤����ID��='$RUN_ID' ";
	//print_R($_POST);
	//print $query;
	print "<BR><BR><div align=center><font color=green>��Ĳ����Ѿ�����!</font></div>";
	$db->Execute($query);
	//exequery($connection,$query);
	print  "<META HTTP-EQUIV=REFRESH CONTENT='0;URL=?action=add_default&RUN_ID=$RUN_ID'>\n";
	exit;
}
if($_GET['action2']=='JiaBanDelete')				{

	$���� = $_GET['����'];
	$��� = $_GET['���'];
	$��Ա = $_SESSION['LOGIN_USER_NAME'];
	//������ݴ�����������ݱ༭����
	$query = "delete from edu_xingzheng_jiabanbuxiu where ���='$���'  ";
	//print_R($_POST);
	//print $query;exit;
	print "<BR><BR><div align=center><font color=green>��Ĳ����Ѿ�����!</font></div>";
	$db->Execute($query);
	//exequery($connection,$query);
	print  "<META HTTP-EQUIV=REFRESH CONTENT='0;URL=?RUN_ID=$RUN_ID'>\n";
	exit;
}





if($_GET['action']=='add_default')
{
?>

<form name=form1>
<table class="TableList" width="100%" style="border:0px">
		<tr class="TableData">
			<td nowrap align=center colspan=8>

			<input type=button accesskey='c' name='cancel' value=' ���� ' class=SmallButton onClick="location='?'">
			</td>
		</tr>
</table>
<table class="TableList" width="100%">
    <tr class="TableHeader">
      <td nowrap align="center">��Ա</td>
	  <td nowrap align="center">�Ӱ�ʱ��</td>
      <td nowrap align="center">�Ӱ���</td>
      <td nowrap align="center">����</td>
    </tr>
<?php
  $��Ա = $_SESSION['LOGIN_USER_NAME'];
  $��Ա�û��� = $_SESSION['LOGIN_USER_ID'];

  $��ʼʱ�� = date("Y-m-d",mktime(1,1,1,date('m'),date('d')-1,date('Y')));
  $����ʱ�� = date("Y-m-d",mktime(1,1,1,date('m'),date('d')+14,date('Y')));


  $��ʼʱ�� = date("Y-m-d",mktime(1,1,1,date('m'),date('d')-1,date('Y')));
	$����ʱ�� = date("Y-m-d",mktime(1,1,1,date('m'),date('d')+14,date('Y')));
	$sql = "select ������� from edu_xingzheng_banci";
	//$cursor = exequery($connection,$sql);
	$rs=$db->CaCheExecute(30,$sql);
    $ROW=$rs->GetArray();
    $COUNT=sizeof($ROW);

	  for($i=0;$i<sizeof($ROW);$i++) {
		//while($ROW = mysql_fetch_array($cursor))			{
		$�������[]= $ROW[$i]["�������"];
	}

	//��δ��ʮ����֮�ڿ���ʹ�õ�ʱ��ν���ͳ�ƺͷ���
	for($i=-1;$i<14;$i++)		{
		$����X = date("w",mktime(1,1,1,date('m'),date('d')+$i,date('Y')));
		$����X = date("Y-m-d",mktime(1,1,1,date('m'),date('d')+$i,date('Y')));
		$query = "select ������� AS ���,�Ű���Ա AS ��Ա from edu_xingzheng_paiban where (�Ű���Ա like '%,$��Ա�û���,%' or �Ű���Ա like '$��Ա�û���,%') and ѧ������='$ѧ������' and ��������='$����X'";
		//$cursor = exequery($connection,$query);
		$rs=$db->CaCheExecute(30,$query);
		$ROW=$rs->GetArray();

		$���Array = array();
		for($n=0;$n<sizeof($ROW);$n++) {
			//while($ROW = mysql_fetch_array($cursor)) {
			$���X= $ROW[$n]["���"];
			$���Array[$���X] = $ROW[$n]["���"];
		}

		//print_R($���Array);
		for($X=0;$X<sizeof($�������);$X=$X+1)		{
			$���TEMP = $�������[$X];;
			if($���Array[$���TEMP]=="")		{
				//print_R($���Array);
				$����ʱ���б�[] = $����X." ��".$����XNAME[$����X]." ".$���TEMP."";
				$����ʱ���б�X[] = $����X." ".$���TEMP." ".$����X;
				//print $����X." ".$���TEMP." ".$��Ա." {$���Array[$���TEMP]}<BR>";;
			}
		}
	}
	//print_R($_SESSION);
	for($i=0;$i<sizeof($����ʱ���б�);$i++)		{
			$LINE_COUNTER = $i;
			$Element = $����ʱ���б�[$i];
			$ElementX = $����ʱ���б�X[$i];
			$ElementXArray = explode(' ',$ElementX);
			$��Ա = $_SESSION['LOGIN_USER_NAME'];
			$���� = $ElementXArray[2];
			$��� = $ElementXArray[1];
			$���� = $ElementXArray[0];
			print "
				 <tr class=\"TableData\">
			   <td nowrap align=\"center\">$��Ա</td>
			   <td nowrap align=\"center\">$����</td>
			   <td nowrap align=\"center\">$���</td>
			   <td nowrap align=\"center\">";
			   print "<input size=6 type=hidden class=SmallInput name='NAME_".$LINE_COUNTER."_VALUE' value='1'/>";
			   $query = "select ��� from edu_xingzheng_jiabanbuxiu where ѧ��='$ѧ������' and ��Ա='$��Ա' and �Ӱ�ʱ��='$����' and �Ӱ���='$���'  and �Ӱ๤����ID��='$RUN_ID'";
				//$cursor = exequery($connection,$query);
				//$ROW = mysql_fetch_array($cursor);
				$rs=$db->Execute($query);
				$ROW=$rs->GetArray();
				$���= $ROW[0]["���"];


			   $query = "select ��� from edu_xingzheng_jiabanbuxiu where ѧ��='$ѧ������' and ��Ա='$��Ա' and �Ӱ�ʱ��='$����' and �Ӱ���='$���'  and �Ӱ๤����ID��='$RUN_ID' and �Ӱ����״̬ = 1";
				//$cursor = exequery($connection,$query);
				//$ROW = mysql_fetch_array($cursor);
				$rs=$db->Execute($query);
				$ROW=$rs->GetArray();
				$ͨ�����= $ROW[0]["���"];


			   if($ͨ�����!="")	{
				   print "<a><font color=red>������ͨ��<font></a>";
				   $����ʱ�� = $����;
			   }
			   else
			   {
			   	   if($���!="")	{
					   print "&nbsp;������ <a href=\"?action=JiaBanDelete&RUN_ID=$RUN_ID&��Ա=$��Ա&���=$���&����=$����&����=$����&����=$����&���=$���\" >ɾ��</a>";
					   $����ʱ�� = $����;
				   }
				   else		{
					   print "<a href=\"?action=JiaBanDataDeal&RUN_ID=$RUN_ID&��Ա=$��Ա&���=$���&����=$����&����=$����&����=$����\" >����Ӱ�</a>";
					   $����ʱ�� = '';
				   }
				}
			   print "
			   <input size=6  type=hidden class=SmallInput name='NAME_".$LINE_COUNTER."_ID' value='$���'/>
			   <input size=6  type=hidden class=SmallInput name='NAME_".$LINE_COUNTER."_BANJI' value='$����'/>
			   <input size=6  type=hidden class=SmallInput name='NAME_".$LINE_COUNTER."_KECHENG' value='$��Ա'/>
			   <input size=6  type=hidden class=SmallInput name='NAME_".$LINE_COUNTER."_OLDDATE' value='$����'/>
			   <input size=6  type=hidden class=SmallInput name='NAME_".$LINE_COUNTER."_OLDJIECI' value='$���'/>
			   <input size=6  type=hidden class=SmallInput name='NAME_".$LINE_COUNTER."_NEWDATE' value='$����ʱ��'/>
			   <input size=6  type=hidden class=SmallInput name='NAME_".$LINE_COUNTER."_NEWJIECI' value='$���ݰ��'/>
			   </td>
				</tr>
				";
	}



?>

		<tr class="TableData">
			<td nowrap align=center colspan=8>

			<input type=button accesskey='c' name='cancel' value=' ���� ' class=SmallButton onClick="location='?'">
			</td>
		</tr>

</table>
<div id=HTMLSHOW></div>
</form>

<?php
exit;
}

	require_once('include.inc.php');
	require_once('../Help/module_xingzhengworkflow.php');

?>