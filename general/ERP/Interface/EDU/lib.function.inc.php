<?php

ini_set('date.timezone','Asia/Shanghai');
function addShortCutByDate($datefield,$showText='',$defaultvalue='')					{
	//print_r($_GET);
	if($defaultvalue!='')
	{
		if($_GET['��ǰ������ʽ']=='')
			$_GET['��ǰ������ʽ']=$defaultvalue;

	}
	$_GET['ʱ���ֶ�']=$datefield;
	if($_GET['��ǰ������ʽ']=='����')
	{
		$_GET['��ʼʱ��ADD']=date("Y-m-d",mktime(0,0,1,date("m"),date("d"),date("Y")));
		$_GET['����ʱ��ADD']=date("Y-m-d",mktime(0,0,1,date("m"),date("d"),date("Y")));
	}
	else if ($_GET['��ǰ������ʽ']=='�������')
	{
		$_GET['��ʼʱ��ADD']=date("Y-m-d",mktime(0,0,1,date("m"),date("d")-3,date("Y")));
		$_GET['����ʱ��ADD']=date("Y-m-d",mktime(0,0,1,date("m"),date("d"),date("Y")));
	}
	else if ($_GET['��ǰ������ʽ']=='���һ��')
	{
		$_GET['��ʼʱ��ADD']=date("Y-m-d",mktime(0,0,1,date("m"),date("d")-7,date("Y")));
		$_GET['����ʱ��ADD']=date("Y-m-d",mktime(0,0,1,date("m"),date("d"),date("Y")));
	}
	else if ($_GET['��ǰ������ʽ']=='�������')
	{
		$_GET['��ʼʱ��ADD']=date("Y-m-d",mktime(0,0,1,date("m"),date("d")-15,date("Y")));
		$_GET['����ʱ��ADD']=date("Y-m-d",mktime(0,0,1,date("m"),date("d"),date("Y")));
	}
	else if ($_GET['��ǰ������ʽ']=='���һ��')
	{
		$_GET['��ʼʱ��ADD']=date("Y-m-d",mktime(0,0,1,date("m")-1,date("d"),date("Y")));
		$_GET['����ʱ��ADD']=date("Y-m-d",mktime(0,0,1,date("m"),date("d"),date("Y")));
	}
	else if ($_GET['��ǰ������ʽ']=='�������')
	{
		$_GET['��ʼʱ��ADD']=date("Y-m-d",mktime(0,0,1,date("m")-2,date("d"),date("Y")));
		$_GET['����ʱ��ADD']=date("Y-m-d",mktime(0,0,1,date("m"),date("d"),date("Y")));
	}
	else if ($_GET['��ǰ������ʽ']=='�������')
	{
		$_GET['��ʼʱ��ADD']=date("Y-m-d",mktime(0,0,1,date("m")-3,date("d"),date("Y")));
		$_GET['����ʱ��ADD']=date("Y-m-d",mktime(0,0,1,date("m"),date("d"),date("Y")));
	}
	else if ($_GET['��ǰ������ʽ']=='�������')
	{
		$_GET['��ʼʱ��ADD']=date("Y-m-d",mktime(0,0,1,date("m")-6,date("d"),date("Y")));
		$_GET['����ʱ��ADD']=date("Y-m-d",mktime(0,0,1,date("m"),date("d"),date("Y")));
	}
	else if ($_GET['��ǰ������ʽ']=='�Զ���')
	{
		$_GET['��ʼʱ��ADD']=urldecode($_GET['��ʼʱ��ADD']);
		$_GET['����ʱ��ADD']=urldecode($_GET['����ʱ��ADD']);
	}
	if($showText=='')
		$showText=$datefield;
	global $db,$SYSTEM_ADD_SQL,$SYSTEM_PRINT_SQL;
	global $���ӶԲ�ѯ���ڿ�ݷ�ʽ��֧��_�Ƿ�����;
	$���ӶԲ�ѯ���ڿ�ݷ�ʽ��֧��_�Ƿ����� = 1;
	session_register("���ӶԲ�ѯ���ڿ�ݷ�ʽ��֧��");
	if($_SESSION['���ӶԲ�ѯ���ڿ�ݷ�ʽ��֧��']=='')					{
		$_SESSION['���ӶԲ�ѯ���ڿ�ݷ�ʽ��֧��'] = '����Ϊ1';
	}
	if($_GET['���ӶԲ�ѯ���ڿ�ݷ�ʽ��֧��GET']=="����Ϊ0")					{
		$_SESSION['���ӶԲ�ѯ���ڿ�ݷ�ʽ��֧��'] = '����Ϊ0';
	}
	elseif($_GET['���ӶԲ�ѯ���ڿ�ݷ�ʽ��֧��GET']=="����Ϊ1")					{
		$_SESSION['���ӶԲ�ѯ���ڿ�ݷ�ʽ��֧��'] = '����Ϊ1';
	}
	//print $_SESSION['���ӶԲ�ѯ���ڿ�ݷ�ʽ��֧��'];

	if(($_GET['action']==""||$_GET['action']=="init_default"||$_GET['action']=="init_default_search")&&$_SESSION['���ӶԲ�ѯ���ڿ�ݷ�ʽ��֧��']=='����Ϊ1')			{
		print "<SCRIPT src=\"".ROOT_DIR."general/ERP/Enginee/WdatePicker/WdatePicker.js\"></SCRIPT>";
		print "<form name=formadd><table class=TableBlock width=100% ><tr><td nowrap class=TableContent align=left>";
		//if($_GET['��ǰ������ʽ']=="")		$_GET['��ǰ������ʽ'] = "û��ѡ��";
		print "<font color=green>".$showText.":";
		if($_GET['��ǰ������ʽ']=='') $_GET['��ǰ������ʽ']='ȫ��';
		if($_GET['��ʼʱ��ADD']!='' && strlen($_GET['��ʼʱ��ADD'])<=10)
			$_GET['��ʼʱ��ADD']=$_GET['��ʼʱ��ADD']." 00:00:00";
		if($_GET['����ʱ��ADD']!='' && strlen($_GET['����ʱ��ADD'])<=10)
			$_GET['����ʱ��ADD']=$_GET['����ʱ��ADD']." 23:59:59";
		$redborder="border:1px red solid;padding:3px;";
		
		$FormPageAction = FormPageAction("��ǰ������ʽ","����");
		if($_GET['��ǰ������ʽ']=='����') $css=$redborder; else $css='';
		print "&nbsp;&nbsp;<a href='#' onclick=\"selectRed('dt1')\"><span id='dt1' style=\"$css\">����</span></a>";

		$FormPageAction = FormPageAction("��ǰ������ʽ","�������");
		if($_GET['��ǰ������ʽ']=='�������') $css=$redborder; else $css='';
		print "&nbsp;&nbsp;<a href='#' onclick=\"selectRed('dt2')\"><span id='dt2' style=\"$css\">�������</span></a>";

		$FormPageAction = FormPageAction("��ǰ������ʽ","���һ��");
		if($_GET['��ǰ������ʽ']=='���һ��') $css=$redborder; else $css='';
		print "&nbsp;&nbsp;<a href=\"#\" onclick=\"selectRed('dt3')\"><span id='dt3' style=\"$css\">���һ��</span></a>";

		$FormPageAction = FormPageAction("��ǰ������ʽ","�������");
		if($_GET['��ǰ������ʽ']=='�������') $css=$redborder; else $css='';
		print "&nbsp;&nbsp;<a href=\"#\" onclick=\"selectRed('dt4')\"><span id='dt4' style=\"$css\">�������</span></a>";

		$FormPageAction = FormPageAction("��ǰ������ʽ","���һ��");
		if($_GET['��ǰ������ʽ']=='���һ��') $css=$redborder; else $css='';
		print "&nbsp;&nbsp;<a href=\"#\" onclick=\"selectRed('dt5')\"><span id='dt5' style=\"$css\">���һ��</span></a>";

		$FormPageAction = FormPageAction("��ǰ������ʽ","�������");
		if($_GET['��ǰ������ʽ']=='�������') $css=$redborder; else $css='';
		print "&nbsp;&nbsp;<a href=\"#\" onclick=\"selectRed('dt6')\"><span id='dt6' style=\"$css\">�������</span></a>";

		$FormPageAction = FormPageAction("��ǰ������ʽ","�������");
		if($_GET['��ǰ������ʽ']=='�������') $css=$redborder; else $css='';
		print "&nbsp;&nbsp;<a href=\"#\" onclick=\"selectRed('dt7')\"><span id='dt7' style=\"$css\">�������</span></a>";

		$FormPageAction = FormPageAction("��ǰ������ʽ","�������");
		if($_GET['��ǰ������ʽ']=='�������') $css=$redborder; else $css='';
		print "&nbsp;&nbsp;<a href=\"#\" onclick=\"selectRed('dt8')\"><span id='dt8' style=\"$css\">�������</span></a>";
		
		$FormPageAction = FormPageAction("��ǰ������ʽ","");
		print "\r\n<script language='javascript'>
		function selectRed(id)
		{
		
			for(i=1;i<11;i++)
			{
				document.getElementById('dt'+i).style.border='0';
				
			}
			document.getElementById(id).style.border='1px red solid';
			document.getElementById(id).style.padding='3px';
			Form2.��ǰ������ʽ.value=document.getElementById(id).innerHTML;
			
			Form2.��ʼʱ��ADD.value='';
			Form2.����ʱ��ADD.value='';
			if(id=='dt9')
			{
				Form2.��ʼʱ��ADD.value=document.getElementById('start_time').value;
				Form2.����ʱ��ADD.value=document.getElementById('end_time').value;
			}
			
		}
		function userDefineDate()
		{
			var url='$FormPageAction';
			url=url+'&��ǰ������ʽ=�Զ���&��ʼʱ��ADD='+encodeURIComponent(document.getElementById('start_time').value)+'&����ʱ��ADD='+encodeURIComponent(document.getElementById('end_time').value);
			
			location.href='?'+url;
		}
		</script>";
		
		
		if($_GET['��ǰ������ʽ']!='�Զ���') $display="display:none;"; else $display='';
		if($_GET['��ǰ������ʽ']=='�Զ���') $css=$redborder; else $css='';
		print "&nbsp;<a href=\"#\" onclick=\"javascript:selectRed('dt9');$('#datesel').toggle();\"><span id='dt9' style=\"$css\">�Զ���</span></a>";
		print "&nbsp;&nbsp;<span style=\"$display\" id=\"datesel\"><input class=\"SmallInput\" size=\"18\"
							name=\"start_time\" id=\"start_time\" value=\"".$_GET['��ʼʱ��ADD']."\"
							onclick=\"WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss',readonly:false})\"
							onchange=\"selectRed('dt9');\"
							> �� <input class=\"SmallInput\" size=\"18\"
							name=\"end_time\" id=\"end_time\" value=\"".$_GET['����ʱ��ADD']."\"
							onclick=\"WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss',readonly:false})\"
							onchange=\"selectRed('dt9');\"
							> </span>";
		//print "&nbsp;&nbsp;<a href='?".FormPageAction("���ӶԲ�ѯ���ڿ�ݷ�ʽ��֧��GET","����Ϊ0")."'><font color=gray>�ر���ʾ</font></a>";
		
		$FormPageAction = FormPageAction("��ʼʱ��ADD","","����ʱ��ADD","",'',"��ǰ������ʽ","ȫ��");
		
		if($_GET['��ǰ������ʽ']=='ȫ��') $css=$redborder; else $css='';
		print "<a href=\"#\" onclick=\"selectRed('dt10');\"><span id='dt10' style=\"$css\">ȫ��</span></a>";
		print "&nbsp;(ѡ�������ѯ��ť)</font></td></tr></table></form><div style='height:3px'></div>";
		
		if($_GET['��ʼʱ��ADD']!="")	
			$SYSTEM_ADD_SQL.= "and $datefield>='".$_GET['��ʼʱ��ADD']."'";
		if($_GET['����ʱ��ADD']!="")		
			$SYSTEM_ADD_SQL.= "and $datefield<='".$_GET['����ʱ��ADD']."'"; 
				


	}

	//$SYSTEM_PRINT_SQL = "1";

}

function ��ʱִ�к���($��������='ͬ����ѧ�ƻ�ѧ����Ϣ���ɼ����ݱ�֮��',$���ʱ��='30')			{
	//���д������ݿ���ͬ������
	$�������� = "��ʱִ�к���_".$��������;
	//session_unregister($��������);//����ʹ�õ��д���
	if(!isset($_SESSION[$��������]))		{
	
		$_SESSION[$��������] = time();
	}
	$����ʱ���� = time();
	$ʱ��� = $����ʱ���� - $_SESSION[$��������];
	$ʱ���CEIL = ceil($ʱ���/60);
	//print_R($ʱ���);
	//print $��������.":".$ʱ���." ".date("H:i",$_SESSION[$��������])."<BR>";
	//print $PHP_SELF_BEGIN."<BR>";
	//��ʱ�䳬��ĳһֵ,����ͷһ�η��ʵ�ʱ��,��Ҫִ�д˹���
	if($ʱ���CEIL>=$���ʱ��||$ʱ���==0)							{
		//ִ�в������ݹ����Ĳ���
		$��������();
		//���±��ʱ��
		$_SESSION[$��������] = time();
	}//exit;
}



//���������������Ϣ
function returnArrayMingCi($Result='')				{
	//������Ϣ
	$ArrayValues = @array_values($Result);
	$NewSortArrayValues = array();
	for($i=0;$i<sizeof($ArrayValues);$i++)		{
		$Values = $ArrayValues[$i];
		if(!in_array($Values,$NewSortArrayValues))	{
			$NewSortArray[$Values] = $i+1;
			array_push($NewSortArrayValues,$Values);
		}
	}
	//print_R($NewSortArray);
	return $NewSortArray;
}


function aksort(&$array,$valrev=false,$keyrev=false) {
  if ($valrev) { arsort($array); } else { asort($array); }
    $vals = array_count_values($array);
    $i = 0;
    foreach ($vals AS $val=>$num) {
        $first = array_splice($array,0,$i);
        $tmp = array_splice($array,0,$num);
        if ($keyrev) { krsort($tmp); } else { ksort($tmp); }
        $array = array_merge($first,$tmp,$array);
        unset($tmp);
        $i = $num;
    }
}


//�Ӳ˵�Ȩ�޹�����,ͬʱ��FRAMEWORK��EDU������ж���
function returnPrivMenu($ModuleName)		{
	global $db,$_SERVER,$_SESSION;
	$PHP_SELF_ARRAY = explode('/',$_SERVER['PHP_SELF']);
	$PHP_SELF = array_pop($PHP_SELF_ARRAY);
	$sql = "select * from systemprivateinc where `FILE`='$PHP_SELF' and `MODULE`='$ModuleName'";
	$rs = $db->Execute($sql);
	$rs_a = $rs->GetArray(); //print_R($rs_a);
	$DEPT_NAME = $rs_a[0]['DEPT_ID'];
	$USER_NAME = $rs_a[0]['USER_ID'];
	$ROLE_NAME = $rs_a[0]['ROLE_ID'];
	$return = 0;
	//������Ϊ��ʱ������ж�
	if($DEPT_NAME==""&&$USER_NAME==""&&$ROLE_NAME=="")		{
		$return = 1;
	}
	//ȫ�岿��
	if($DEPT_NAME=="ALL_DEPT")			{
		$return = 1.5;
	}
	//�û��ж�
	$LOGIN_USER_ID = $_SESSION['LOGIN_USER_ID'];
	$LOGIN_USER_ID_ARRAY = explode(',',$USER_NAME);
	if(in_array($LOGIN_USER_ID,$LOGIN_USER_ID_ARRAY))		{
		$return = 2;
	}
	//�����ж�
	$LOGIN_DEPT_ID = $_SESSION['LOGIN_DEPT_ID'];
	$LOGIN_DEPT_ID_ARRAY = explode(',',$DEPT_NAME);
	if(in_array($LOGIN_DEPT_ID,$LOGIN_DEPT_ID_ARRAY))		{
		$return = 3;
	}
	//��ɫ�ж�
	$LOGIN_USER_PRIV = $_SESSION['LOGIN_USER_PRIV'];
	$LOGIN_USER_PRIV_ARRAY = explode(',',$ROLE_NAME);
	if(in_array($LOGIN_USER_PRIV,$LOGIN_USER_PRIV_ARRAY))		{
		$return = 4;
	}
	//print_R($_SESSION);
	return $return;
}

function base64_encode2($value)		{
	return $value;
}
?>