<?php
require_once('lib.inc.php');//

$GLOBAL_SESSION=returnsession();
$SYSTEM_PRIV_STOP = 1;
require_once("systemprivateinc.php");
//CheckSystemPrivate("������Դ-��������-�ҵĿ���");
page_css('������');
$��ǰѧ�� = returntablefield("edu_xueqiexec","��ǰѧ��",'1',"ѧ������");
if($_GET['ѧ��']=="") $_GET['ѧ��'] = $��ǰѧ��;
$ѧ������ = $��ǰѧ��;


	$_GET['��Ա'] = $_SESSION['LOGIN_USER_NAME'];
	$_GET['��Ա�û���'] = $_SESSION['LOGIN_USER_ID'];
	//$_GET['����'] = returntablefield("department","DEPT_ID",$_SESSION['LOGIN_DEPT_ID'],"DEPT_NAME");


if($_GET['action']=='QingJiaDataDeal')				{
//print_R($_GET);exit;
	$���� = $_GET['����'];
	$��� = $_GET['���'];
	$���� = $_GET['����'];
	$�ܴ� = $_GET['�ܴ�'];
	$��Ա = $_SESSION['LOGIN_USER_NAME'];
	$���ϰ�ʱ��Array = explode(' ',$_POST['���ϰ�ʱ��']);
	$���ϰ�ʱ�� = $���ϰ�ʱ��Array[0];
	$�°�� = $���ϰ�ʱ��Array[1];
	$��� = $_POST['���'];
	$query = "insert into edu_xingzheng_qingjia values('','$ѧ������','$����','$��Ա','$����','$�ܴ�','$���','','0','$RUN_ID','$�����','$���ʱ��','".$_SESSION['LOGIN_USER_ID']."');";
	//print_R($_GET);
	//print $query;exit;
	print "<BR><BR><div align=center><font color=green>��Ĳ����Ѿ�����!</font></div>";
	//exequery($connection,$query);
	$db->Execute($query);
	print  "<META HTTP-EQUIV=REFRESH CONTENT='0;URL=?action=add_default&RUN_ID=$RUN_ID'>\n";
	exit;
}

if($_GET['action']=='QingJiaDelete')				{

	$���� = $_GET['����'];
	$��� = $_GET['���'];
	$��Ա = $_SESSION['LOGIN_USER_NAME'];
	//������ݴ�����������ݱ༭����
	//$query = "delete from edu_xingzheng_qingjia where ���='$���' and ���='$���' and ѧ��='$ѧ������' and �������״̬='0'";
	$��� = $_GET['���'];
	$query = "delete from edu_xingzheng_qingjia where ���='$���'  and ���״̬='0'";
	//print $query;
	print "<BR><BR><div align=center><font color=green>��Ĳ����Ѿ�����!</font></div>";
	//exequery($connection,$query);
	$db->Execute($query);
	print  "<META HTTP-EQUIV=REFRESH CONTENT='0;URL=?action=add_default&RUN_ID=$RUN_ID'>\n";
	exit;
}
if($_GET['action2']=='QingJiaDelete')				{

	$���� = $_GET['����'];
	$��� = $_GET['���'];
	$��Ա = $_SESSION['LOGIN_USER_NAME'];
	//������ݴ�����������ݱ༭����
	//$query = "delete from edu_xingzheng_qingjia where ���='$���' and ���='$���' and ѧ��='$ѧ������' and �������״̬='0'";
	$��� = $_GET['���'];
	$query = "delete from edu_xingzheng_qingjia where ���='$���'  and ���״̬='0'";
	//print $query;
	print "<BR><BR><div align=center><font color=green>��Ĳ����Ѿ�����!</font></div>";
	//exequery($connection,$query);
	$db->Execute($query);
	print  "<META HTTP-EQUIV=REFRESH CONTENT='0;URL=?RUN_ID=$RUN_ID'>\n";
	exit;
}

if($_GET['action']=='KaoQinBudeng')				{
//print_R($_POST);
//print_R($_GET);
	$��Ա = $_SESSION['LOGIN_USER_NAME'];
//Array ( [0qingjialeixing] => [CHECK_1_0_VALUE] => on [NAME_0_VALUE] => 1 [NAME_0_ID] => [NAME_0_BANJI] => ϵͳ����Ա [NAME_0_KECHENG] => ���� [NAME_0_OLDDATE] => 2011-04-27 [NAME_0_OLDJIECI] => ���� [NAME_0_NEWDATE] => [1qingjialeixing] => [CHECK_1_1_VALUE] => on [NAME_1_VALUE] => 1 [NAME_1_ID] => [NAME_1_BANJI] => ϵͳ����Ա [NAME_1_KECHENG] => ���� [NAME_1_OLDDATE] => 2011-04-28 [NAME_1_OLDJIECI] => ���� [NAME_1_NEWDATE] => )  insert into edu_xingzheng_qingjia values('','2010-2011-�ڶ�ѧ��','','ϵͳ����Ա','','','','','0','','','','admin');

		$������array=$_POST;
		$��=$_POST['COUNT'];
		//$�ռǲ���=array();
		for($i=0;$i<10;$i++)
		{


			 //$����key=$i."_JIAOSHI";
			 $����key=$i."_BANJI";
			 $���key=$i."_KECHENG";
			 $����key=$i."_OLDDATE";
			 //$��Աkey=$i."_OLDTEACHER";
			 $�������key=$i."qingjialeixing";
			 $���״̬key="CHECK_1_".$i."_VALUE";



			   $���� = $������array[$����key];
			   $��� = $������array[$���key];
			   $���� = $������array[$����key];
			   $�ܴ�= date('w',strtotime($�ϰ�ʱ��));
			   $���״̬ = $������array[$���״̬key];
			   $������� = $������array[$�������key];

			//print   $��Ա = $������array[$��Աkey];

				if($���״̬=='on')
				{


					$query = "insert into edu_xingzheng_qingjia values('','$ѧ������','$����','$��Ա','$����','$�ܴ�','$���','$�������','0','$RUN_ID','$�����','$���ʱ��','".$_SESSION['LOGIN_USER_ID']."');";
					  $db->Execute($query);
					// print $sql;exit;

				}

		}

//exit;
	//$���� = $_POST['����'];
	//$��� = $_POST['���'];
	//$���� = $_POST['����'];
	//$�ܴ� = $_POST['�ܴ�'];
/*
	$���ϰ�ʱ��Array = explode(' ',$_POST['���ϰ�ʱ��']);
	$���ϰ�ʱ�� = $���ϰ�ʱ��Array[0];
	$�°�� = $���ϰ�ʱ��Array[1];
	$��� = $_POST['���'];
	$query = "insert into edu_xingzheng_qingjia values('','$ѧ������','$����','$��Ա','$����','$�ܴ�','$���','','0','$RUN_ID','$�����','$���ʱ��','".$_SESSION['LOGIN_USER_ID']."');";
	//print_R($_GET);
	print $query;exit;
	*/
	print "<BR><BR><div align=center><font color=green>��Ĳ����Ѿ�����!</font></div>";
	//exequery($connection,$query);
	//$db->Execute($query);
	print  "<META HTTP-EQUIV=REFRESH CONTENT='0;URL=?action=add_default&RUN_ID=$RUN_ID'>\n";
	exit;
}



if($_GET['action']=='add_default')
{
// print_R($_GET);exit;
 ?>


<form    name=form1 action='?action=KaoQinBudeng' method=post >
<table class="TableList" width="100%">
    <tr class="TableHeader">
      <td nowrap align="center">����</td>
      <td nowrap align="center">���</td>
	  <td nowrap align="center">�ϰ�ʱ��</td>
      <td nowrap align="center">���</td>
      <td nowrap align="center">�������</td>

	  <td nowrap align="center">������</td>
    </tr>
<?php
  $��Ա = $_SESSION['LOGIN_USER_NAME'];

  $��ʼʱ�� = date("Y-m-d",mktime(1,1,1,date('m'),date('d')-1,date('Y')));
  $����ʱ�� = date("Y-m-d",mktime(1,1,1,date('m'),date('d')+14,date('Y')));

  $��ʼʱ�� = date("Y-m-d",mktime(1,1,1,date('m'),date('d')-1,date('Y')));
  $����ʱ�� = date("Y-m-d",mktime(1,1,1,date('m'),date('d')+14,date('Y')));

  $query = "select ����,���,��Ա,���,����,����,���,�ܴ� from  edu_xingzheng_kaoqinmingxi  where ��Ա='$��Ա' and ����>='$��ʼʱ��' and ����<='$����ʱ��' and �°࿼��״̬!='������' order by ����,���,��Ա";
  //print $query;
 // $cursor = exequery($connection,$query);
	$rs=$db->CaCheExecute(30,$query);
	$ROW=$rs->GetArray();
  // print_R($_GET);exit;
  //�м�����
  $LINE_COUNTER = 0;
  for($i=0;$i<sizeof($ROW);$i++) {
	 // while($ROW = mysql_fetch_array($cursor)) {
    $���= $ROW[$i]["���"];
	$��Ա= $ROW[$i]["��Ա"];
	$�ܴ�= $ROW[$i]["�ܴ�"];
	$����= $ROW[$i]["����"];
	$���= $ROW[$i]["���"];
	$����= $ROW[$i]["����"];
	$����= $ROW[$i]["����"];


	//������ݴ�����������ݱ༭����
	$query = "select ��� from edu_xingzheng_qingjia where ѧ��='$ѧ������' and ��Ա='$��Ա' and ʱ��='$����' and ���='$���' and  ������ID��='$RUN_ID'";
	//$cursorX = exequery($connection,$query);
	//$ROWX	 = mysql_fetch_array($cursorX);
	$rs=$db->Execute($query);
	$ROWX=$rs->GetArray();
	$��ٱ��		= $ROWX[0]["���"];

	$query = "select ��� from edu_xingzheng_qingjia where ѧ��='$ѧ������' and ��Ա='$��Ա' and ʱ��='$����' and ���='$���' and  ������ID��='$RUN_ID' and  ���״̬=1";
	$rs=$db->Execute($query);
	$ROWXX=$rs->GetArray();
	$ͨ�����		= $ROWXX[0]["���"];

$������ = "<input type=checkbox name='CHECK_1_".$LINE_COUNTER."_VALUE' checked />������";
$������ = "<input type=checkbox name='CHECK_2_".$LINE_COUNTER."_VALUE' disabled />������";

	print "
		 <tr class=\"TableData\">
	   <td nowrap align=\"center\">$����</td>
	   <td nowrap align=\"center\">$���</td>
	   <td nowrap align=\"center\">$����</td>
	   <td nowrap align=\"center\">$���</td>
	   <td nowrap align=\"center\" width='100'%>
	   <input class=SmallInput  name= ".$LINE_COUNTER."qingjialeixing  value=''></td>

";
   print "<input size=6 type=hidden class=SmallInput name='NAME_".$LINE_COUNTER."_VALUE' value='1'/>";

   if($ͨ�����!="")	{
	   print " <a><font color=red>������ͨ��</font></a>";
	   //$���ϰ�ʱ�� = $����;
   }
   else
	{
	   if($��ٱ��!="")	{
		   print "<td nowrap align=\"center\">
		   <a href=\"?action=QingJiaDelete&RUN_ID=$RUN_ID&��Ա=$��Ա&���=$���&����=$����&���=$���&����=$����&���=$��ٱ��&����=$����&�ܴ�=$�ܴ�\">
		   ȡ��</a>
		   $������</td>";
		   //$���ϰ�ʱ�� = $����;
	   }
	   else		{
		   print "<td nowrap align=\"center\">$������</td>";
		   $���ϰ�ʱ�� = '';
	   }

   }

   print "
   <input size=6  type=hidden class=SmallInput name='".$LINE_COUNTER."_ID' value='$��ٱ��'/>

   <input size=6  type=hidden class=SmallInput name='".$LINE_COUNTER."_BANJI' value='$����'/>
   <input size=6  type=hidden class=SmallInput name='".$LINE_COUNTER."_KECHENG' value='$���'/>
   <input size=6  type=hidden class=SmallInput name='".$LINE_COUNTER."_OLDDATE' value='$����'/>
   <input size=6  type=hidden class=SmallInput name='".$LINE_COUNTER."_OLDJIECI' value='$���'/>
   <input size=6  type=hidden class=SmallInput name='".$LINE_COUNTER."_NEWDATE' value='$��ٱ��'/>
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
		  <td nowrap colspan=11 align=center>
		  <input type=submit class=SmallButton value='�ύ'/>
		    <input type=button accesskey='c' name='cancel' value=' ���� ' class=SmallButton onClick="location='?'" title='��ݼ�:ALT+c'>
		</td>
		</tr>

</table>
<div id=HTMLSHOW></div>
</form>

 <?php
	 exit;
}



	$filetablename='edu_xingzheng_qingjia';
	$parse_filename = 'my_xingzheng_qingjia';

	require_once('include.inc.php');
		require_once('../Help/module_xingzhengworkflow.php');

?>