<?php
	ini_set('display_errors', 1);
	ini_set('error_reporting', E_ALL);
	error_reporting(E_WARNING | E_ERROR);
	require_once('lib.inc.php');
	$GLOBAL_SESSION=returnsession();

  if($_GET['go']=="submit"){
    
	$�������·� = $_POST['check_year_month'];
	//echo $�������·�."<br>";
    

	// and �Ƿ�ɷ�='0'
    $select_sql = "select * from wu_wpgfeesdetails where �������·�='$�������·�'";
	$rs = $db -> Execute($select_sql);
	$rs_a = $rs -> GetArray();
	//print_r($rs_a);
	$����arr=array();

    for($i=0;$i<sizeof($rs_a);$i++)				{
		   $��Ԫ��� = $rs_a[$i]['��Ԫ���'];
		   $�������� = $rs_a[$i]['��������'];
           $����arr[$��Ԫ���]['��Ԫ���'] = $rs_a[$i]['��Ԫ���'];
		   $����arr[$��Ԫ���]['ҵ������'] = $rs_a[$i]['ҵ������'];
		   $����arr[$��Ԫ���]['��ϵ��ʽ'] = $rs_a[$i]['��ϵ��ʽ'];
		   $����arr[$��Ԫ���]['�������·�'] = $rs_a[$i]['�������·�'];
		   //$����arr[$��Ԫ���]['�������'] = $rs_a[$i]['�������'];
		   $����arr[$��Ԫ���][$��������]  = $rs_a[$i]['Ӧ�ɽ��'];
		   $����arr2[$��Ԫ���][$��������] = "$��������='".$rs_a[$i]['Ӧ�ɽ��']."'";
	}


	$����key=array_keys($����arr);
	//print_r($����key);
	for($n=0;$n<sizeof($����key);$n++)	{
			$��Ԫ���	= $����key[$n];
			$��Ԫarray	= $����arr[$��Ԫ���];
			$��Ԫ2array	= $����arr2[$��Ԫ���];


			$KEYS_INDEX = array_keys($��Ԫarray);
			$VALUES_INDEX = array_values($��Ԫarray);
			$KEYS_TEXT = join(",",$KEYS_INDEX);
			$VALUES_TEXT = "'".join("','",$VALUES_INDEX)."'";
			$sql = "select COUNT(*) AS NUM from wu_costsummary where ��Ԫ���='$��Ԫ���' and �������·�='".$�������·�."'";
			$rs = $db->Execute($sql);
			if($rs->fields['NUM']==0)		{
				$sql = "insert into wu_costsummary ($KEYS_TEXT) values($VALUES_TEXT)";
			}
			else	{
				$VALUES_INDEX = array_values($��Ԫ2array);//�������������е�ֵ
				$UPDATE_TEXT = join(",",$VALUES_INDEX);
				$sql = "update wu_costsummary set $UPDATE_TEXT where ��Ԫ���='$��Ԫ���' and �������·�='".$�������·�."'";

			}

			$db->Execute($sql);
	  }

	  for($m=0;$m<sizeof($����key);$m++){
	        $��Ԫ���   = $����key[$m];
			$sql = "select ˮ��,���,����,��̯ˮ��,��̯���,��ҵ�����,������,���ݹ����,��λ��,װ��Ѻ��,��ʱ����,�������� from wu_costsummary where ��Ԫ���='$��Ԫ���' and �������·�='".$�������·�."'";
			$rs = $db -> Execute($sql);
			$rs_a = $rs -> GetArray();
			for($s=0;$s<sizeof($rs_a);$s++){
			    $ˮ�� = $rs_a[$s]['ˮ��'];
				$��� = $rs_a[$s]['���'];
				$���� = $rs_a[$s]['����'];
				$��̯ˮ�� = $rs_a[$s]['��̯ˮ��'];
				$��̯��� = $rs_a[$s]['��̯���'];
				$��ҵ����� = $rs_a[$s]['��ҵ�����'];
				$������ = $rs_a[$s]['������'];
				$���ݹ���� = $rs_a[$s]['���ݹ����'];
				$��λ�� = $rs_a[$s]['��λ��'];
				$װ��Ѻ�� = $rs_a[$s]['װ��Ѻ��'];
				$��ʱ���� = $rs_a[$s]['��ʱ����'];
				$�������� = $rs_a[$s]['��������'];
				$����Ӧ�� = $ˮ��+$���+$����+$��̯ˮ��+$��̯���+$��ҵ�����+$������+$���ݹ����+$��λ��+$װ��Ѻ��+$��ʱ����+$��������;

				//echo $����Ӧ��;
				$update_sql = "update wu_costsummary set ����Ӧ��='$����Ӧ��' where ��Ԫ���='".$��Ԫ���."' and �������·�='".$�������·�."'";

				$db -> Execute($update_sql);
			}
	  }

    }

	if($_GET['action']=="edit_default"){
	   
	   //print_r($_GET);

	   if($_GET['xx'] == "xx"){
	      
		  $��� = $_GET['���'];
		  $sel_sql = "select * from wu_costsummary where ���='$���'";
		  $rs = $db->Execute($sel_sql);
		  $rs_a = $rs->GetArray();
		      $��Ԫ���   = $rs_a[0]['��Ԫ���'];
			  $ҵ������   = $rs_a[0]['ҵ������'];
			  $��ϵ��ʽ   = $rs_a[0]['��ϵ��ʽ'];
			  $�������·� = $rs_a[0]['�������·�'];
			  $ˮ��       = $rs_a[0]['ˮ��'];
			  $���       = $rs_a[0]['���'];
			  $����       = $rs_a[0]['����'];
			  $��̯���   = $rs_a[0]['��̯���'];
			  $��̯ˮ��   = $rs_a[0]['��̯ˮ��'];
			  $��ҵ����� = $rs_a[0]['��ҵ�����'];
			  $������     = $rs_a[0]['������'];
			  $���ݹ���� = $rs_a[0]['���ݹ����'];
			  $��λ��     = $rs_a[0]['��λ��'];
			  $װ��Ѻ��   = $rs_a[0]['װ��Ѻ��'];
			  $��ʱ����   = $rs_a[0]['��ʱ����'];
			  $��������   = $rs_a[0]['��������'];	  
         
		 
		//����һ����������
			$���� = array('ˮ��','���','����','��̯���','��̯ˮ��','������','���ݹ����','��λ��','װ��Ѻ��','��ʱ����','��������');
			 foreach($���� as $val){
			     $sql = "select COUNT(*) AS NUM from wu_wpgfeesdetails where ��Ԫ���='".$��Ԫ���."' and �������·�='".$�������·�."' and ��������='$val'";
				 $rs1 = $db->Execute($sql);
                 $num = $rs1->fields['NUM'];
				 if($num != 0){
				   $upd = "update wu_wpgfeesdetails set �Ƿ�ɷ�='1' where ��Ԫ���='$��Ԫ���' and �������·�='$�������·�' and ��������='$val'";
				   $db->Execute($upd);
				 }

			 }
	   }
   }
	$filetablename		=	'wu_costsummary';
	$parse_filename		=	'wu_costsummary';
	require_once('include.inc.php');
?>
