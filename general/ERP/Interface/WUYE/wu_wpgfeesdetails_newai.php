<?php
    require_once('lib.inc.php');
    $GLOBAL_SESSION=returnsession();
	ini_set('display_errors', 1);
	ini_set('error_reporting', E_ALL);
	error_reporting(E_WARNING | E_ERROR);
	
	


    //����gongtan_value��������
	require_once('gongtanshuidianfei.php');

	
	if($_GET['action']=="add_default_data")		{
            //print_r($_POST);

			//echo "<br>";

		  $��Ԫ���   = $_POST['��Ԫ���'];
		//�õ�������ĵ�Ԫ��
		  $sql_danyuan = "select * from wu_housingresources where �������='$��Ԫ���'";
		  $rs_qy = $db->Execute($sql_danyuan);
		  $rs_a_qy = $rs_qy->GetArray();
		  $��Ԫ�� = $rs_a_qy[0]['��Ԫ��'];
		//�õ���¥����
		  $arr = explode('-',$��Ԫ���);
		  $��¥���� = $arr[0];


		  $�������·� = $_POST['�������·�'];
		  $��������   = $_POST['��������'];
		  $���¶���   = $_POST['���¶���'];
		  $��̯��ʽ   = $_POST['��̯��ʽ'];

//echo $��̯��ʽ."<br>";

      //�õ��ϴνɷѵ��·�
		  $arr = explode('-',$�������·�);
		  $��� = $arr[0];
		  $�·� = $arr[1];
		  $��ֹ�·� = $�·�-1;
		  $��ֹʱ�� = $���."-0".$��ֹ�·�; 
      
	  //ȡ���շ�����������ַ��õĵ��۱�׼
		  $sel_sql = "select * from wu_wpgsetmanagement where ������='$��������'";
		  $rs = $db->Execute($sel_sql);
		  $rs_a = $rs->GetArray();

//echo "aaaaaaaaaaaaaaaaaaaaaaaaaa<br>";
		  $���� = $rs_a[0]['����'];
		  $���� = $rs_a[0]['����'];
	  //$��̯����� = $rs_a[0]['��̯�����'];
	  //$��̯��ʽ = $rs_a[0]['��̯��ʽ'];

//echo $����."<br>";

	  //�õ���Ӧ��Ԫ�����¶�������ʼʱ��
		  $d_sql = "select * from wu_wpgfeesdetails where ��Ԫ���='$��Ԫ���' and �������·�='$��ֹʱ��' and ��������='$��������'";
		  $result = $db->Execute($d_sql);
		  $rs_a1 = $result->GetArray();

		  $���¶��� = $rs_a1[0]['���¶���'];

//echo $���¶���."<br>";

	      $��ʼʱ�� = $rs_a1[0]['��ֹʱ��'];
			  //����ʼʱ����д����õ����µ���ֹʱ��
		  $arr = explode('-',$��ʼʱ��);
	   	  $��� = $arr[0];
	   	  $�·� = $arr[1];
	      $���� = $arr[2];
	      $��ֹ�·� = $�·�+1;
		  $��ֹʱ�� = $���."-".$��ֹ�·�."-".$����; 

      

//�ж��Ƿ��Ѿ��ɹ�����
		  $pan_sql = "select COUNT(*) AS NUM from wu_wpgfeesdetails where ��Ԫ���='$��Ԫ���' and �������·�='$�������·�' and ��������='$��������'";
		  $pan_rs = $db->Execute($pan_sql);
		  $pan_rs_a = $pan_rs->fields['NUM'];

      if($pan_rs_a == 0){


		  //�жϽɷ���Ŀ
		  if($�������� == "ˮ��"){
				  //����ʹ��ˮ��
				  
				  $����ˮ��1 = $���¶���-$���¶���;
				  $����ˮ��  = $����ˮ��1."(��)";
				  $Ӧ�ɽ�� = $����ˮ��1*$����*$����;


			//echo $����ˮ��."<br>";
			//echo $Ӧ�ɽ��."<br>";

				  $_POST['���¶���'] = $���¶���;
			//$_POST['��ʼʱ��'] = $��ʼʱ��;

			//$_POST['��ֹʱ��'] = $��ֹʱ��;
				  
				  $_POST['����']     = $����."(Ԫ)";
				  $_POST['����']     = $����ˮ��;
				  $_POST['Ӧ�ɽ��'] = $Ӧ�ɽ��;
		  }
		  else if($�������� == "���")
		  {
				  //����ʹ�õ���

				  $���µ���1 = $���¶���-$���¶���;
				  $���µ���  = $���µ���1."(��)";
				  $Ӧ�ɽ�� = $���µ���*$����*$����;

				  $_POST['���¶���'] = $���¶���;
			//$_POST['��ʼʱ��'] = $��ʼʱ��;

			//$_POST['��ֹʱ��'] = $��ֹʱ��;
				  
				  $_POST['����']     = $����;
				  $_POST['����']     = $���µ���;
				  $_POST['Ӧ�ɽ��'] = $Ӧ�ɽ��;

				  
		  }
		  else if($�������� == "����")
		  {
				  //����ʹ�����ķ���
				  $��������1 = $���¶���-$���¶���;
				  $��������  = $��������1."(������)";
				  $Ӧ�ɽ�� = $��������*$����*$����;

				  $_POST['���¶���'] = $���¶���;
			//$_POST['��ʼʱ��'] = $��ʼʱ��;

			//$_POST['��ֹʱ��'] = $��ֹʱ��;
				  
				  $_POST['����']     = $����;
				  $_POST['����']     = $��������;
				  $_POST['Ӧ�ɽ��'] = $Ӧ�ɽ��;
		  
		  }
		  else if($�������� == "��̯���")
		  {
				 
				 if($��̯��ʽ == "��Ԫ��̯"){
					$���� = $���¶���-$���¶���;
					$��� = gongtan_value($��¥����,$��Ԫ��,$����,$����,$���¶���,$���¶���);

					 
					$arr = explode(',',$���);
					$��̯���� = $arr[0];
					$��Ԫ��̯�� = $arr[1];
					
					$_POST['����']     = $����."(Ԫ)";
					$_POST['����']     = $��Ԫ��̯��."(��)";
					$_POST['Ӧ�ɽ��'] = $��̯����;
				 
				 }else if($��̯��ʽ == "��¥��̯"){
					$���� = $���¶���-$���¶���;
					$��� = gongtan_value($��¥����,"",$����,$����,$���¶���,$���¶���);

					$arr = explode(',',$���);
					$��̯���� = $arr[0];
					$��Ԫ��̯�� = $arr[1];
					
					$_POST['����']     = $����."(Ԫ)";
					$_POST['����']     = $��Ԫ��̯��."(��)";
					$_POST['Ӧ�ɽ��'] = $��̯����;
				 
				 }else if($��̯��ʽ == "����̯"){
					$���� = $���¶���-$���¶���;
					$��� = gongtan_value("","",$����,$����,$���¶���,$���¶���);

					$arr = explode(',',$���);
					$��̯���� = $arr[0];
					$��Ԫ��̯�� = $arr[1];
					
					$_POST['����']     = $����."(Ԫ)";
					$_POST['����']     = $��Ԫ��̯��."(��)";
					$_POST['Ӧ�ɽ��'] = $��̯����;
				 }
		  
		  
		  }
		  else if($�������� == "��̯ˮ��")
		  {



				  if($��̯��ʽ == "��Ԫ��̯"){


					$���� = $���¶���-$���¶���;
					$��� = gongtan_value($��¥����,$��Ԫ��,$����,$����,$���¶���,$���¶���);
					
					$arr = explode(',',$���);
					$��̯���� = $arr[0];
					$��Ԫ��̯�� = $arr[1];

					
					$_POST['����']     = $����."(Ԫ)";
					$_POST['����']     = $��Ԫ��̯��."(��)";
					$_POST['Ӧ�ɽ��'] = $��̯����;
				 
				 }else if($��̯��ʽ == "��¥��̯"){
					$���� = $���¶���-$���¶���;
					$��� = gongtan_value($��¥����,"",$����,$����,$���¶���,$���¶���);

					
					$arr = explode(',',$���);
					$��̯���� = $arr[0];
					$��Ԫ��̯�� = $arr[1];
					
					$_POST['����']     = $����."(Ԫ)";
					$_POST['����']     = $��Ԫ��̯��."(��)";
					$_POST['Ӧ�ɽ��'] = $��̯����;
				 
				 }else if($��̯��ʽ == "����̯"){
					$���� = $���¶���-$���¶���;
					$��� = gongtan_value("","",$����,$����,$���¶���,$���¶���);

					
					$arr = explode(',',$���);
					$��̯���� = $arr[0];
					$��Ԫ��̯�� = $arr[1];
					
					$_POST['����']     = $����."(Ԫ)";
					$_POST['����']     = $��Ԫ��̯��."(��)";
					$_POST['Ӧ�ɽ��'] = $��̯����;
				 }
		  
		  
		  }


		}else{

			$PrintText .= "<BR><table  class=TableBlock align=center width=100%>";
			$PrintText .= "<TR class=TableContent><td ><font color=green >
			&nbsp;˵����<BR>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;�˷��䱾�´˷����Ѿ��ɹ�! <BR>       
			<center><p><font color=\"red\" size=4><a href=wu_housingresources_newai.php>�������</a></font></p></center>
			</font></td></table>";
			print $PrintText; 
			exit;
	
	   }

    }
	$_GET['��������'] = "ˮ��,���,����,��̯ˮ��,��̯���";
	$filetablename		=	'wu_wpgfeesdetails';
	$parse_filename		=	'wu_wpgfeesdetails';
	require_once('include.inc.php');

		if($_GET['action']==''||$_GET['action']=='init_default'||$_GET['action']=='init_customer')		{
			$PrintText .= "<BR><table  class=TableBlock align=center width=100%>";
			$PrintText .= "<TR class=TableContent><td ><font color=green >
			˵����<BR>
			&nbsp;&nbsp;&nbsp;&nbsp;1 ��ҳ����ʾˮ�ѡ���ѡ����ѡ���̯��ѡ���̯ˮ�ѵ��շ���ϸ��<BR>
			&nbsp;&nbsp;&nbsp;&nbsp;2 ����ϸ���ݲ����ظ�����������Ψһ�ĵ�Ԫ��š����������Լ��������·ݽ������á�<BR>
			&nbsp;&nbsp;&nbsp;&nbsp;3 ��Ҫ�Ķ��������ڶ�Ӧ���е���޸ģ����иĶ���<BR>
			&nbsp;&nbsp;&nbsp;&nbsp;4 ��̯��ˮ����ø��ݹ�̯ˮ��ѵĵ��۽��е�Ԫ��̯����¥��̯������̯���м��㹫̯��<BR>
			&nbsp;&nbsp;&nbsp;&nbsp;5 ..............................................................................��<BR>
			</font></td></table>";
			print $PrintText;
		}
	
   ?>