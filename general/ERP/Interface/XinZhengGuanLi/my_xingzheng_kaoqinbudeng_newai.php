<?php
	require_once('lib.inc.php');//

	$GLOBAL_SESSION=returnsession();
$SYSTEM_PRIV_STOP = 1;


$��ǰѧ�� = returntablefield("edu_xueqiexec","��ǰѧ��",'1',"ѧ������");
if($_GET['ѧ��']=="") $_GET['ѧ��'] = $��ǰѧ��;

$ѧ������ = $��ǰѧ��;
page_css('���ڲ���');

	$_GET['��Ա'] = $_SESSION['LOGIN_USER_NAME'];
	$_GET['��Ա�û���'] = $_SESSION['LOGIN_USER_ID'];
	$��Ա�û��� = $_SESSION['LOGIN_USER_ID'];
	//$_GET['����'] = returntablefield("department","DEPT_ID",$_SESSION['LOGIN_DEPT_ID'],"DEPT_NAME");



if($_GET['action']=='KaoQinBudeng')
{
	//print_R($_POST);exit;
 // [CHECK_2_0_VALUE] => on [0_VALUE] => 1 [0_ID] => 14 [0_BANJI] => ��Ϣ���� [0_KECHENG] => ���� [0_OLDDATE] => 2011-02-21 [0_OLDJIECI] => ���� [0_OLDTEACHER] => ϵͳ����Ա [CHECK_2_1_VALUE] => on 
		$���ڲ�����ϸ=$_POST;
		 $��=$_POST['COUNT'];
		$�ռǲ���=array();
		for($i=0;$i<$��;$i++)
		{

			 $����key=$i."_JIAOSHI";
			 $����key=$i."_BANJI";
			 $���key=$i."_KECHENG";			 
			 $�ϰ�ʱ��key=$i."_OLDDATE";
			 $��Աkey=$i."_OLDTEACHER";
			 $�ϰಹ��״̬key="CHECK_1_".$i."_VALUE";
			 $�°ಹ��״̬key="CHECK_2_".$i."_VALUE";
			
			  $���� = $���ڲ�����ϸ[$����key];
			  $��� = $���ڲ�����ϸ[$���key];
			  $�ϰ�ʱ�� = $���ڲ�����ϸ[$�ϰ�ʱ��key];
			  $����= date('w',strtotime($�ϰ�ʱ��));
			  //print strtotime($�ϰ�ʱ��);

//exit;

			  $��Ա = $���ڲ�����ϸ[$��Աkey];
			  $�ϰಹ��״̬ = $���ڲ�����ϸ[$�ϰಹ��״̬key];
			  $�°ಹ��״̬ = $���ڲ�����ϸ[$�°ಹ��״̬key];
 //exit;
			  // ���  ѧ��  ����  ��Ա  ʱ��  ����  ���  ������Ŀ  ���״̬  ������ID��  �����  ���ʱ��  ��Ա�û��� 
				if($�ϰಹ��״̬=='on')
				{
					$sql = "INSERT INTO edu_xingzheng_kaoqinbudeng ( `���` , `ѧ��` , `����` , `��Ա` , `ʱ��` , `����` , `���` , `������Ŀ` , `���״̬`, `������ID��` , `�����`, `���ʱ��` , `��Ա�û���`   )VALUES ( '', '$ѧ������', '$����', '$��Ա', '$�ϰ�ʱ��', '$����', '$���',  '�ϰ࿼�ڲ���', '0', '', '', '', '$��Ա�û���')" ;

					 $rs = $db->Execute($sql);
					 //print $sql;exit;
					 
				}
				 if($�°ಹ��״̬=='on')
				{
				 $sql = "INSERT INTO edu_xingzheng_kaoqinbudeng ( `���` , `ѧ��` , `����` , `��Ա` , `ʱ��` , `����` , `���` , `������Ŀ` , `���״̬`, `������ID��` , `�����`, `���ʱ��` , `��Ա�û���`   )VALUES ( '', '$ѧ������', '$����', '$��Ա', '$�ϰ�ʱ��', '$����', '$���',  '�°࿼�ڲ���', '0', '', '', '', '$��Ա�û���')" ;
				  $rs = $db->Execute($sql);
				}
			
		}
		print_infor("�ύ�ɹ�,�뷵��...");
		print "<meta http-equiv=\"REFRESH\" content=\"0 URL=?\">";
		exit;
}



if($_GET['action']=='DataDeal')
	{
	$query = "delete from edu_xingzheng_kaoqinbudeng where ���='$���'  and ���״̬=0 ";
	//print_R($_POST);
	//print $query;exit;
	print "<BR><BR><div align=center><font color=green>��Ĳ����Ѿ�����!</font></div>";
	$db->Execute($query);
	//dandian_sql_log($connection,$query);
	print  "<META HTTP-EQUIV=REFRESH CONTENT='0;URL=?'>\n";
	exit;
	}


if($_GET['action2']=='DataDeal')
	{
	$query = "delete from edu_xingzheng_kaoqinbudeng where ���='$���'  and ���״̬=0 ";
	//print_R($_POST);
	//print $query;exit;
	print "<BR><BR><div align=center><font color=green>��Ĳ����Ѿ�����!</font></div>";
	$db->Execute($query);
	//dandian_sql_log($connection,$query);
	print  "<META HTTP-EQUIV=REFRESH CONTENT='0;URL=?'>\n";
	exit;
	}





if($_GET['action']=='add_default')
{

?>
<form   name=form1 action='?action=KaoQinBudeng&RUN_ID=$RUN_ID' method=post >
<table class="TableList" width="100%" style="border:0px">
    <tr class="TableData" align="right">
      <td nowrap colspan=7 align=center>
	  <input type=submit class=SmallButton value='�ύ'/>
	<input type="button" class="SmallButton" onclick=location='?'  value="����">
	</td>
    </tr>
</table>
<table class="TableList" width="100%">
    <tr class="TableHeader">
      <td nowrap align="center">����</td>
      <td nowrap align="center">���</td>
	  <td nowrap align="center">�ϰ�ʱ��</td>
      <td nowrap align="center">���</td>
	  <td nowrap align="center">��Ա</td>
	  <td nowrap align="center">�ϰ࿼��״̬</td>
      <td nowrap align="center">�°࿼��״̬</td>
    </tr>
<?php
  $��Ա = $_SESSION['LOGIN_USER_NAME'];
  $��Ա�û��� = $_SESSION['LOGIN_USER_ID'];

  $��ʼʱ�� = date("Y-m-d",mktime(1,1,1,date('m'),date('d')-1,date('Y')));
  $����ʱ�� = date("Y-m-d",mktime(1,1,1,date('m'),date('d')+14,date('Y')));

  $query = "select ���,����,���,����,���,����,��Ա,��Ա�û���,�ϰ࿼��״̬,�°࿼��״̬ from  edu_xingzheng_kaoqinmingxi  where ѧ��='$ѧ������' and ��Ա�û���='$��Ա�û���' and ����<='$��ʼʱ��' and (�ϰ࿼��״̬='�ϰ�ȱ��' or �°࿼��״̬='�°�ȱ��') order by ����,���,����";
  $rs=$db->CacheExecute(30,$query);
  $ROW=$rs->GetArray();
  $COUNT=sizeof($ROW);
  //$cursor = exequery($connection,$query);
  //print $query;
  //�м�����
  $LINE_COUNTER = 0;
  for($i=0;$i<sizeof($ROW);$i++) {
    $���= $ROW[$i]["���"];
	$����= $ROW[$i]["����"];
	$���= $ROW[$i]["���"];
	$����= $ROW[$i]["����"];
	$���= $ROW[$i]["���"];
	$��Ա= $ROW[$i]["��Ա"];
	$��Ա�û���= $ROW[$i]["��Ա�û���"];
	$�ϰ࿼��״̬= $ROW[$i]["�ϰ࿼��״̬"];
	$�°࿼��״̬= $ROW[$i]["�°࿼��״̬"];
	$����= $ROW[$i]["����"];

	//������ݴ�����������ݱ༭����
	//$query		= "select ����Ա,��� from edu_xingzheng_paibandaike where ѧ��='$ѧ������' and ԭ��Ա='$��Ա' and �ϰ�ʱ��='$����' and ���='$���'  and ������ID��='$RUN_ID'";
	//$cursorX	= exequery($connection,$query);
	//$ROWX		= mysql_fetch_array($cursorX);
    //$����Ա		= $ROWX["����Ա"];
	//$���		= $ROWX["���"];

	$value = 0;
	//print_R($INITDATA_List);
	if($�ϰ࿼��״̬=="�ϰ�ȱ��")	$�ϰಹ�� = "<input type=checkbox name='CHECK_1_".$LINE_COUNTER."_VALUE' checked />���벹��";
	else	$�ϰಹ�� = "<input type=checkbox name='CHECK_1_".$LINE_COUNTER."_VALUE' disabled /><font color=gray>���벹��</font>";;
	if($�°࿼��״̬=="�°�ȱ��")	$�°ಹ�� = "<input type=checkbox name='CHECK_2_".$LINE_COUNTER."_VALUE' checked />���벹��";
	else	$�°ಹ�� = "<input type=checkbox name='CHECK_2_".$LINE_COUNTER."_VALUE' disabled />���벹��";
	print "
	 <tr class=\"TableData\">
   <td nowrap align=\"center\">$����</td>
   <td nowrap align=\"center\">$���</td>
   <td nowrap align=\"center\">$����</td>
   <td nowrap align=\"center\">$���</td>
   <td nowrap align=\"center\">$��Ա</td>
   <td nowrap align=\"center\">$�ϰಹ��</td>
   <td nowrap align=\"center\">$�°ಹ��";

   print "<input size=6 type=hidden class=SmallInput name='".$LINE_COUNTER."_VALUE' value='1'/>";


   print "
   <input size=6  type=hidden class=SmallInput name='".$LINE_COUNTER."_ID' value='$���'/>
   <input size=6  type=hidden class=SmallInput name='".$LINE_COUNTER."_BANJI' value='$����'/>
   <input size=6  type=hidden class=SmallInput name='".$LINE_COUNTER."_KECHENG' value='$���'/>
   <input size=6  type=hidden class=SmallInput name='".$LINE_COUNTER."_OLDDATE' value='$����'/>
   <input  type=hidden   name='COUNT' value='$COUNT'/>
   <input size=6  type=hidden class=SmallInput name='".$LINE_COUNTER."_OLDTEACHER' value='$��Ա'/>
   </td>
	</tr>
	";
	$LINE_COUNTER++;
  }

if($LINE_COUNTER==0)	{
	$Disabled = " Disabled ";
	$Values = "�ύ";
}
else	{
	$Disabled = "";
	$Values = "�ύ";
}
?>

    <tr class="TableData" align="right">
      <td nowrap colspan=7 align=center>
	  <input type=submit class=SmallButton value='�ύ'/>
	<input type="button" class="SmallButton" onclick=location='?'  value="����">
	</td>
    </tr>

</table>
<div id=HTMLSHOW></div>
</form>

<?php

exit;
}





	$filetablename='edu_xingzheng_kaoqinbudeng';
	$parse_filename = 'my_xingzheng_kaoqinbudeng';

	require_once('include.inc.php');
	require_once('../Help/module_xingzhengworkflow.php');

?>