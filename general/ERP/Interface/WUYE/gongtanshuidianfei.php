<?php
    ini_set('display_errors', 1);
	ini_set('error_reporting', E_ALL);
	error_reporting(E_WARNING | E_ERROR);
	require_once('lib.inc.php');
	$GLOBAL_SESSION=returnsession();


//�������̯ˮ��ķ���

 function  gongtan_value($��¥����,$��Ԫ��,$����,$����,$���¶���,$���¶���){

		global $db;

		if($��¥���� != "" and $��Ԫ�� == ""){//��ʱ����¥��̯
		   
			   
			   //�õ���¥��Ϣ
			   $dalou_sql = "select COUNT(*) AS NUM from wu_housingresources where ��¥����='$��¥����' and ��Ԫ״̬='�Ѿ���ס'";//�˴�����������.............
			   $rs_lou = $db->Execute($dalou_sql);
			   $num = $rs_lou->fields['NUM'];//�õ����������ĵ�Ԫ��
			   $���� = $���¶���-$���¶���;

			   $ƽ����1 = $����/$num;//�����ÿ���Ĺ�̯��
			   $ƽ���� = round($ƽ����1,2);

			   $��̯����1 = ($����*$����*$����)/$num;
			   $��̯���� = round($��̯����1,2);//��̯���ý�����������

		}
		else if($��¥���� !="" and $��Ԫ�� !="")//��ʱ����Ԫ��̯
		{
			   
			   $danyuan_sql = "select COUNT(*) AS NUM from wu_housingresources where ��¥����='$��¥����' and ��Ԫ��='$��Ԫ��' and ��Ԫ״̬='�Ѿ���ס'";//�˴�����������.............
			   $rs_dan = $db->Execute($danyuan_sql);
			   $num = $rs_dan->fields['NUM'];//�õ����������ĵ�Ԫ��
			   $���� = $���¶���-$���¶���;

			   $ƽ����1 = $����/$num;//�����ÿ���Ĺ�̯��
			   $ƽ���� = round($ƽ����1,2);

			   $��̯����1 = ($����*$����*$����)/$num;
			   $��̯���� = round($��̯����1,2);//��̯���ý�����������
		} 
		else if($��¥���� == "" and $��Ԫ�� == "") //��ʱ������С����̯
		{
			  
			   $quyu_sql = "select COUNT(*) AS NUM from wu_housingresources where ��Ԫ״̬='�Ѿ���ס'";//�˴�����������.............
			   $rs_quyu = $db->Execute($quyu_sql);
			   $num = $rs_quyu->fields['NUM'];//�õ����������ĵ�Ԫ��
			   $���� = $���¶���-$���¶���;

			   $ƽ����1 = $����/$num;//�����ÿ���Ĺ�̯��
			   $ƽ���� = round($ƽ����1,2);

			   $��̯����1 = ($����*$����*$����)/$num;
			   $��̯���� = round($��̯����1,2);//��̯���ý�����������

		}
			   return $��̯����.",".$ƽ����;


  }



?>