<?php

//$SCHOOL_MODEL = parse_ini_file("SCHOOL_MODEL.ini");
//$SCHOOL_MODEL_TEXT = $SCHOOL_MODEL['SCHOOL_MODEL'];
/*
if($_SESSION['SYSTEM_IS_TD_OA']=="0")									{
	$PRIVATE_SYSTEM['�ҵĸ�������']['�ҵİ칫��Ʒ'] = array("../officeproduct/officeproduct_my.php","�ҵİ칫��Ʒ");
	$PRIVATE_SYSTEM['�ҵĸ�������']['�ҵĹ̶��ʲ�'] = array("../fixedasset/my_fixedasset.php","�ҵĹ̶��ʲ�");
	$PRIVATE_SYSTEM['�ҵĸ�������']['�ҵ���������'] = array("../XinZhengGuanLi/my_xingzheng.php","�ҵ���������");
	$PRIVATE_SYSTEM['�ҵĸ�������']['���Ϲ��ﱨ��'] = array("../WuYeGuanLi/wygl_teacher.php","���Ϲ��ﱨ��");
	$PRIVATE_SYSTEM['�ҵĸ�������']['�����¼']		= array("other_system_userlogin_newai.php","�����¼");

	$PRIVATE_SYSTEM['�ҵĲ�������']['�̶��ʲ����ż�����']		= array("../fixedasset/fixedasset_department_newai.php","�̶��ʲ����ż�����");
	$PRIVATE_SYSTEM['�ҵĲ�������']['�������ڲ��ż�����']		= array("../XinZhengGuanLi/my_bumen_xingzheng.php","�������ڲ��ż�����");
}
*/

/*
//��һ�˵�����
$PRIVATE_SYSTEM['�ҵĽ�ѧ']['�ҵ����'] = array("../Teacher/TeacherStaticInfor.php","�ҵ����");
$PRIVATE_SYSTEM['�ҵĽ�ѧ']['�ҵ�ѧ��']['PARENT'] = array("../Teacher/edu_StudentAllInfor.php","�ҵ�ѧ��:ѧ������,ѧ����ҵ,��ҵ����,ѧ������,ѧ������,ѧ������,ѧ����¼˵��");
$PRIVATE_SYSTEM['�ҵĽ�ѧ']['�ҵ�ѧ��']['ѧ������'] = array("../Teacher/studentFilesFrame.php","�ҵ�ѧ��:ѧ������,ѧ����ҵ,��ҵ����,ѧ������,ѧ������,ѧ������,ѧ����¼˵��");
$PRIVATE_SYSTEM['�ҵĽ�ѧ']['�ҵ�ѧ��']['ѧ������'] = array("../Teacher/growFilesFrame.php","�ҵ�ѧ��:ѧ������,ѧ����ҵ,��ҵ����,ѧ������,ѧ������,ѧ������,ѧ����¼˵��");
//$PRIVATE_SYSTEM['�ҵĽ�ѧ']['�ҵ�ѧ��']['ѧ������'] = array("../Teacher/studentKaoqin.php","�ҵ�ѧ��:ѧ������,ѧ����ҵ,��ҵ����,ѧ������,ѧ������,ѧ������,ѧ����¼˵��");
$PRIVATE_SYSTEM['�ҵĽ�ѧ']['�ҵ�ѧ��']['ѧ������'] = array("../Teacher/studentPasswordFrame.php","�ҵ�ѧ��:ѧ������,ѧ����ҵ,��ҵ����,ѧ������,ѧ������,ѧ������,ѧ����¼˵��");
$PRIVATE_SYSTEM['�ҵĽ�ѧ']['�ҵ�ѧ��']['ѧ����¼˵��'] = array("../Teacher/StudentHelp.php","�ҵ�ѧ��:ѧ������,ѧ����ҵ,��ҵ����,ѧ������,ѧ������,ѧ������,ѧ����¼˵��");

$PRIVATE_SYSTEM['�ҵĽ�ѧ']['�ҵİ༶']['PARENT'] = array("../Teacher/edu_ClassAllInfor.php","�ҵİ༶:�༶֪ͨ,�༶����,�༶��ҵ");
$PRIVATE_SYSTEM['�ҵĽ�ѧ']['�ҵİ༶']['�༶֪ͨ'] = array("../Teacher/school_notify_newai.php","�ҵİ༶:�༶֪ͨ,�༶����,�༶��ҵ");
$PRIVATE_SYSTEM['�ҵĽ�ѧ']['�ҵİ༶']['�༶����'] = array("../Teacher/PingYu_ALL.php","�ҵİ༶:�༶֪ͨ,�༶����,�༶��ҵ");
$PRIVATE_SYSTEM['�ҵĽ�ѧ']['�ҵİ༶']['�༶��ҵ'] = array("../Teacher/school_homework_newai.php","�ҵİ༶:�༶֪ͨ,�༶����,�༶��ҵ");
$PRIVATE_SYSTEM['�ҵĽ�ѧ']['�ҵİ༶']['�ҷ�¼'] = array("../Teacher/edu_jiafang_newai.php","�ҵĽ�ѧ:�ҵĽ̰�,��ѧ�ռ�,�ҷ�¼,���⸨��,�ҵĿα�");

$PRIVATE_SYSTEM['�ҵĽ�ѧ']['�ճ���ѧ']['PARENT'] = array("../Teacher/edu_TeachingAllInfor.php","�ҵĽ�ѧ:�ҵĽ̰�,��ѧ�ռ�,�ҷ�¼,���⸨��,�ҵĿα�");
$PRIVATE_SYSTEM['�ҵĽ�ѧ']['�ճ���ѧ']['��ѧ�ռ�'] = array("../Teacher/edu_jiaoxueriji_view.php","�ҵĽ�ѧ:�ҵĽ̰�,��ѧ�ռ�,�ҷ�¼,���⸨��,�ҵĿα�");
$PRIVATE_SYSTEM['�ҵĽ�ѧ']['�ճ���ѧ']['�α�'] = array("../Teacher/TeacherSchedule.php","�ҵĽ�ѧ:�ҵĽ̰�,��ѧ�ռ�,�ҷ�¼,���⸨��,�ҵĿα�");
$PRIVATE_SYSTEM['�ҵĽ�ѧ']['�ճ���ѧ']['�̰�'] = array("../Teacher/edu_jiaoan_newai.php","�ҵĽ�ѧ:�ҵĽ̰�,��ѧ�ռ�,�ҷ�¼,���⸨��,�ҵĿα�");
$PRIVATE_SYSTEM['�ҵĽ�ѧ']['�ճ���ѧ']['�μ�'] = array("../Teacher/school_download_newai.php","�ҵĽ�ѧ:�ҵĽ̰�,��ѧ�ռ�,�ҷ�¼,���⸨��,�ҵĿα�");
$PRIVATE_SYSTEM['�ҵĽ�ѧ']['�ճ���ѧ']['��ҵ'] = array("../Teacher/homeworkFrame.php","�ҵ�ѧ��:ѧ������,ѧ����ҵ,��ҵ����,ѧ������,ѧ������,ѧ������,ѧ����¼˵��");
$PRIVATE_SYSTEM['�ҵĽ�ѧ']['�ճ���ѧ']['����'] = array("../Teacher/school_gb_newai.php","�ҵ�ѧ��:ѧ������,ѧ����ҵ,��ҵ����,ѧ������,ѧ������,ѧ������,ѧ����¼˵��");
$PRIVATE_SYSTEM['�ҵĽ�ѧ']['�ճ���ѧ']['����'] = array("../Teacher/edu_kewaifudao_newai.php","�ҵĽ�ѧ:�ҵĽ̰�,��ѧ�ռ�,�ҷ�¼,���⸨��,�ҵĿα�");
$PRIVATE_SYSTEM['�ҵĽ�ѧ']['�ճ���ѧ']['��'] = array("../Teacher/edu_teacherkaoqin_newai.php","�ҵĽ�ѧ:�ҵĽ̰�,��ѧ�ռ�,�ҷ�¼,���⸨��,�ҵĿα�");
$PRIVATE_SYSTEM['�ҵĽ�ѧ']['�ճ���ѧ']['����'] = array("../Teacher/edu_teacherkaoqinmingxi_newai.php","�ҵĽ�ѧ:�ҵĽ̰�,��ѧ�ռ�,�ҷ�¼,���⸨��,�ҵĿα�");
$PRIVATE_SYSTEM['�ҵĽ�ѧ']['�ճ���ѧ']['У��']		= array("../Teacher/SchoolCalendar.php","�ҵĽ�ѧ:�ҵĽ̰�,��ѧ�ռ�,�ҷ�¼,���⸨��,�ҵĿα�");
$PRIVATE_SYSTEM['�ҵĽ�ѧ']['�ճ���ѧ']['����']		= array("../Teacher/edu_schooljingcheng_newai.php","�ҵĽ�ѧ:�ҵĽ̰�,��ѧ�ռ�,�ҷ�¼,���⸨��,�ҵĿα�");
$PRIVATE_SYSTEM['�ҵĽ�ѧ']['�ճ���ѧ']['��ʱ']		= array("../Teacher/edu_kechoutongji.php","�ҵĽ�ѧ:�ҵĽ̰�,��ѧ�ռ�,�ҷ�¼,���⸨��,�ҵĿα�");


$PRIVATE_SYSTEM['�ҵĽ�ѧ']['��ѧ����']['PARENT'] = array("../Teacher/edu_TingKeAllInfor.php","");

$PRIVATE_SYSTEM['�ҵĽ�ѧ']['��ѧ����']['���μƻ�']		= array("../Teacher/edu_tingke_newai.php","���μƻ�");
$PRIVATE_SYSTEM['�ҵĽ�ѧ']['��ѧ����']['���ο���']		= array("../Teacher/edu_tingke_kaoqin_newai.php","���ο���");
$PRIVATE_SYSTEM['�ҵĽ�ѧ']['��ѧ����']['�����ռ�']		= array("../Teacher/edu_tingke_riji_newai.php","�����ռ�");
$PRIVATE_SYSTEM['�ҵĽ�ѧ']['��ѧ����']['���β���']		= array("../Teacher/edu_tingke_ceping_newai.php","���β���");


//$PRIVATE_SYSTEM['�ҵĽ�ѧ']['ѧ����������'] = array("../Teacher/edu_StudentPingJiaMain.php","��������:ѧ����������");
$PRIVATE_SYSTEM['�ҵĽ�ѧ']['ѧ���ɼ�'] = array("../Teacher/Exam_class_change.php","ѧ���ɼ�");
$PRIVATE_SYSTEM['�ҵĽ�ѧ']['ѧ������'] = array("../Teacher/edu_jiaofei.php","ѧ�����Ѳ���");


$PRIVATE_SYSTEM['�ҵĽ�ѧ']['���ŵ���']['PARENT']		= array("../Teacher/edu_StudentChengXin.php","���ŵ���");
$PRIVATE_SYSTEM['�ҵĽ�ѧ']['���ŵ���']['��������'] = array("../Teacher/newedu_xuexichengji.php","ѧϰ�ɼ�����");
$PRIVATE_SYSTEM['�ҵĽ�ѧ']['���ŵ���']['��ѵ����'] = array("../Teacher/newedu_xuexichengji.php","ѧϰ�ɼ�����");
$PRIVATE_SYSTEM['�ҵĽ�ѧ']['���ŵ���']['����¼'] = array("../Teacher/newedu_xuexichengji.php","ѧϰ�ɼ�����");
$PRIVATE_SYSTEM['�ҵĽ�ѧ']['���ŵ���']['��Ѫ��¼'] = array("../Teacher/newedu_xuexichengji.php","ѧϰ�ɼ�����");
$PRIVATE_SYSTEM['�ҵĽ�ѧ']['���ŵ���']['У�⽱��'] = array("../Teacher/newedu_xuexichengji.php","ѧϰ�ɼ�����");
$PRIVATE_SYSTEM['�ҵĽ�ѧ']['���ŵ���']['У������'] = array("../Teacher/newedu_xuexichengji.php","ѧϰ�ɼ�����");
$PRIVATE_SYSTEM['�ҵĽ�ѧ']['���ŵ���']['������Ŀ'] = array("../Teacher/newedu_xuexichengji.php","ѧϰ�ɼ�����");
$PRIVATE_SYSTEM['�ҵĽ�ѧ']['���ŵ���']['���ʵ��'] = array("../Teacher/newedu_xuexichengji.php","ѧϰ�ɼ�����");
$PRIVATE_SYSTEM['�ҵĽ�ѧ']['���ŵ���']['����'] = array("../Teacher/newedu_xuexichengji.php","ѧϰ�ɼ�����");
$PRIVATE_SYSTEM['�ҵĽ�ѧ']['���ŵ���']['��������'] = array("../Teacher/newedu_xuexichengji.php","ѧϰ�ɼ�����");
$PRIVATE_SYSTEM['�ҵĽ�ѧ']['���ŵ���']['֤�����'] = array("../Teacher/newedu_xuexichengji.php","ѧϰ�ɼ�����");


//��һ�˵�����
//$PRIVATE_SYSTEM['�ҵİ༶']['�ճ�����']['PARENT'] = array("../Teacher/edu_ClassAllInfor.php","�ҵİ༶:�༶֪ͨ,�༶����,�༶��ҵ");
//$PRIVATE_SYSTEM['�ҵİ༶']['�ճ�����']['�༶֪ͨ'] = array("../Teacher/school_notify_newai.php","�ҵİ༶:�༶֪ͨ,�༶����,�༶��ҵ");
$PRIVATE_SYSTEM['�ҵİ༶']['�༶֪ͨ'] = array("../Teacher/school_notify_newai.php","�ҵİ༶:�༶֪ͨ,�༶����,�༶��ҵ");
//$PRIVATE_SYSTEM['�ҵİ༶']['�༶���ٷ�'] = array("../Teacher/edu_banjichangbaifen.php","�༶���ٷ�");
//$PRIVATE_SYSTEM['�ҵİ༶']['���˻���'] = array("../Teacher/edu_gerenjifen.php","���˻���");
//$PRIVATE_SYSTEM['�ҵİ༶']['������ѧ��'] = array("../Teacher/edu_guojiazhuxuejin.php","������ѧ��");
$PRIVATE_SYSTEM['�ҵİ༶']['�༶��ҵ'] = array("../Teacher/school_homework_newai.php","�༶��ҵ");
$PRIVATE_SYSTEM['�ҵİ༶']['ѧ������'] = array("../Teacher/growFilesFrame.php","ѧ������");
$PRIVATE_SYSTEM['�ҵİ༶']['�ҷ����'] = array("../Teacher/edu_jiafang_newai.php","�ҷ����");
$PRIVATE_SYSTEM['�ҵİ༶']['ѧ������'] = array("../Teacher/edu_jiaofei.php","ѧ������");
$PRIVATE_SYSTEM['�ҵİ༶']['ѧ������'] = array("../Teacher/studentFilesFrame.php","ѧ������");
$PRIVATE_SYSTEM['�ҵİ༶']['�����ο��˲�ѯ'] = array("../Teacher/edu_banzhurenkaohechaxun.php","�����ο��˲�ѯ");

*/


//�ڶ��˵�����
if($SCHOOL_MODEL_TEXT!="4")	$PRIVATE_SYSTEM['ѧУ������Ϣ����']['ѧУ�����ṹ����'] = array("xueyuan.php","ѧУ�����ṹ����");
if($SCHOOL_MODEL_TEXT=="4")	$PRIVATE_SYSTEM['ѧУ������Ϣ����']['��ѧ������'] = array("edu_xiaoqu_newai.php","��ѧ������");
$PRIVATE_SYSTEM['ѧУ������Ϣ����']['�༶��Ϣ����'] = array("edu_banji_newai.php","�༶��Ϣ����");
$PRIVATE_SYSTEM['ѧУ������Ϣ����']['ѧУ������Ϣһ����'] = array("InforSchool.php","ѧУ������Ϣһ����");
$PRIVATE_SYSTEM['ѧУ������Ϣ����']['�༶ѧ��ͳ�Ƶ���'] = array("InforSchool1.php","�༶ѧ��ͳ�Ƶ���");
if(is_file("../../Enginee/lib/version.php"))	@require_once("../../Enginee/lib/version.php");
if(is_file("../Enginee/lib/version.php"))		@require_once("../Enginee/lib/version.php");

if($SYSTEM_VERSION_CONTENT=="LIYE")		{
	$PRIVATE_SYSTEM['ѧУ������Ϣ����']['ѧ�����ӵ���'] = array("StudentFileChengXin.php","ѧ�����ӵ���");
}


if(is_file('../../Framework/license.ini'))			{
	$ini_file=@parse_ini_file('../../Framework/license.ini');
	$����汾Array = explode('-',$ini_file['SOFTWARE_TYPE']);
	if(TRIM($����汾Array[1])=="��׼��")					{
		$�����׼�汾 = 1;
	}
	//print_R($�����׼�汾);
}


//�����˵�����

if($SCHOOL_MODEL_TEXT!="4")	$PRIVATE_SYSTEM['������ҵ����']['¼ȡ����']['PARENT'] = array("NewStudentLuQu.php","¼ȡ������ϵͳ");
if($SCHOOL_MODEL_TEXT!="4")	$PRIVATE_SYSTEM['������ҵ����']['¼ȡ����']['¼ȡ��Ϣ����'] = array("NewStudent_LuQu_newai.php","¼ȡ��Ϣ����");
if($SCHOOL_MODEL_TEXT!="4")	$PRIVATE_SYSTEM['������ҵ����']['¼ȡ����']['¼ȡ��˹���'] = array("NewStudent_luqushenhe_newai.php","¼ȡ��˹���");
if($SCHOOL_MODEL_TEXT!="4")	$PRIVATE_SYSTEM['������ҵ����']['¼ȡ����']['¼ȡ֪ͨ�鼰EMS��ӡ'] = array("NewStudent_luqutongzhishu_newai.php","¼ȡ֪ͨ�鼰EMS��ӡ");
if($SCHOOL_MODEL_TEXT!="4")	$PRIVATE_SYSTEM['������ҵ����']['¼ȡ����']['�ֻ�����֪ͨ'] = array("NewStudent_luquduanxin_newai.php","�ֻ�����֪ͨ");
if($SCHOOL_MODEL_TEXT!="4")	$PRIVATE_SYSTEM['������ҵ����']['¼ȡ����']['���ŷ�����־'] = array("edu_smsnewstudentreply_newai.php","���ŷ�����־");
if($SCHOOL_MODEL_TEXT!="4")	$PRIVATE_SYSTEM['������ҵ����']['¼ȡ����']['ũ����������'] = array("../DICT/dict_chengshi_newai.php","ũ����������");
if($SCHOOL_MODEL_TEXT!="4")	$PRIVATE_SYSTEM['������ҵ����']['¼ȡ����']['������������ά��'] = array("../DICT/dict_countrycode_newai.php","������������ά��");
if($SCHOOL_MODEL_TEXT!="4")	$PRIVATE_SYSTEM['������ҵ����']['¼ȡ����']['EMS�ļ�����Ϣά��'] = array("NewStudent_config_newai.php","EMS�ļ�����Ϣά��");
if($SCHOOL_MODEL_TEXT!="4")	$PRIVATE_SYSTEM['������ҵ����']['¼ȡ����']['�ŷ��ӡ����'] = array("edu_newstudentprint_newai.php","�ŷ��ӡ����");
if($SCHOOL_MODEL_TEXT!="4")	$PRIVATE_SYSTEM['������ҵ����']['¼ȡ����']['ͳ�Ʊ���鿴'] = array("NewStudent_luqutongji_newai.php","ͳ�Ʊ���鿴");

if($SCHOOL_MODEL_TEXT!="4")	$PRIVATE_SYSTEM['������ҵ����']['ӭ�¹���']['PARENT'] = array("NewStudent.php","����ע�ᱨ��");
if($SCHOOL_MODEL_TEXT!="4")	$PRIVATE_SYSTEM['������ҵ����']['ӭ�¹���']['������Ϣ����'] = array("NewStudent_yingxin_newai.php","������Ϣ����");
if($SCHOOL_MODEL_TEXT!="4")	$PRIVATE_SYSTEM['������ҵ����']['ӭ�¹���']['�����Զ��ְ༶'] = array("NewStudent_fenban_newai.php","�����Զ��ְ༶");
if($SCHOOL_MODEL_TEXT!="4")	$PRIVATE_SYSTEM['������ҵ����']['ӭ�¹���']['�����ֶ��ְ༶'] = array("NewStudent_shoudongfenban_newai.php","�����ֶ��ְ༶");
if($SCHOOL_MODEL_TEXT!="4")	$PRIVATE_SYSTEM['������ҵ����']['ӭ�¹���']['��������ӡ����'] = array("NewStudent_baodao_newai.php","��������ӡ����");
if($SCHOOL_MODEL_TEXT!="4")	$PRIVATE_SYSTEM['������ҵ����']['ӭ�¹���']['�����ɷ�����'] = array("NewStudent_jiaofei_newai.php","�����ɷ�����");
if($SCHOOL_MODEL_TEXT!="4")	$PRIVATE_SYSTEM['������ҵ����']['ӭ�¹���']['������ȡУ԰��'] = array("NewStudent_xiaoyuanka_newai.php","������ȡУ԰��");
if($SCHOOL_MODEL_TEXT!="4")	$PRIVATE_SYSTEM['������ҵ����']['ӭ�¹���']['�����ֶ�������'] = array("NewStudent_shoudongfensushe_newai.php","�����ֶ�������");
if($SCHOOL_MODEL_TEXT!="4")	$PRIVATE_SYSTEM['������ҵ����']['ӭ�¹���']['ɾ��δ����ѧ��'] = array("NewStudent_notbaodao_newai.php","ɾ��δ����ѧ��");
if($SCHOOL_MODEL_TEXT!="4")	$PRIVATE_SYSTEM['������ҵ����']['ӭ�¹���']['��������ת�Ƶ�ѧ��'] = array("NewStudent_fenbanjieshu_newai.php","��������ת�Ƶ�ѧ��");
if($SCHOOL_MODEL_TEXT!="4")	$PRIVATE_SYSTEM['������ҵ����']['ӭ�¹���']['��ת������ѧ��'] = array("NewStudent_baodaoandxueji_newai.php","��ת������ѧ��");
if($SCHOOL_MODEL_TEXT!="4")	$PRIVATE_SYSTEM['������ҵ����']['ӭ�¹���']['ͬ��Ԥ�ɷѵ�����ģ��'] = array("NewStudent_jiaofei2caiwu_newai.php","ͬ��Ԥ�ɷѵ�����ģ��");
if($SCHOOL_MODEL_TEXT!="4")	$PRIVATE_SYSTEM['������ҵ����']['ӭ�¹���']['��������'] = array("edu_newstudent_charu_newai.php","�ֹ���������");
if($SCHOOL_MODEL_TEXT!="4")	$PRIVATE_SYSTEM['������ҵ����']['ӭ�¹���']['����������'.$_SESSION['SUNSHINE_REGISTER_XI'].'ͳ��'] = array("NewStudent_xibaodao_statics.php","����������".$_SESSION['SUNSHINE_REGISTER_XI']."ͳ��");
if($SCHOOL_MODEL_TEXT!="4")	$PRIVATE_SYSTEM['������ҵ����']['ӭ�¹���']['�����������༶ͳ��'] = array("NewStudent_banjibaodao_statics.php","�����������༶ͳ��");
if($SCHOOL_MODEL_TEXT!="4")	$PRIVATE_SYSTEM['������ҵ����']['ӭ�¹���']['����������רҵͳ��'] = array("NewStudent_zhuanyebaodao_statics.php","����������רҵͳ��");
if($SCHOOL_MODEL_TEXT!="4")	$PRIVATE_SYSTEM['������ҵ����']['ӭ�¹���']['ӭ����������'] = array("NewStudent_liucheng_config.php","ӭ����������");
if($SCHOOL_MODEL_TEXT!="4")	$PRIVATE_SYSTEM['������ҵ����']['ӭ�¹���']['ӭ�¹�������'] = array("NewStudent_jieshugongzuo_newai.php","ӭ�¹�������");
//if($SCHOOL_MODEL_TEXT!="4")	$PRIVATE_SYSTEM['������ҵ����']['ӭ�¹���']['�����Զ�������'] = array("NewStudent_fensushe_newai.php","�����Զ�������");

if($SCHOOL_MODEL_TEXT!="4")	$PRIVATE_SYSTEM['������ҵ����']['��������']['PARENT'] = array("NewStudentCheck.php","��������");
if($SCHOOL_MODEL_TEXT!="4")	$PRIVATE_SYSTEM['������ҵ����']['��������']['���༶��ӡ�嵥'] = array("NewStudentCheck_BanjiList.php","���༶��ӡ�嵥");
if($SCHOOL_MODEL_TEXT!="4")	$PRIVATE_SYSTEM['������ҵ����']['��������']['�������ӡ�嵥'] = array("../SuSheGuanLi/dorm_rooming_view.php?action2=�������ӡ�嵥","�������ӡ�嵥");
if($SCHOOL_MODEL_TEXT!="4")	$PRIVATE_SYSTEM['������ҵ����']['��������']['������������'] = array("edu_newstudent_check_setting.php","������������");

if($SCHOOL_MODEL_TEXT!="4")	$PRIVATE_SYSTEM['������ҵ����']['ѧ����ҵ']['PARENT'] = array("../JIUYE/JiuYe.php","ѧ����ҵ����");
if($SCHOOL_MODEL_TEXT!="4")	$PRIVATE_SYSTEM['������ҵ����']['ѧ����ҵ']['ѧ����ҵ���'] = array("../JIUYE/edu_studentjiuye_newai.php","ѧ����ҵ���");
if($SCHOOL_MODEL_TEXT!="4")	$PRIVATE_SYSTEM['������ҵ����']['ѧ����ҵ']['��ҵ��Ƹ��Ϣ'] = array("../JIUYE/edu_zhaopin_newai.php","��ҵ��Ƹ��Ϣ");
if($SCHOOL_MODEL_TEXT!="4")	$PRIVATE_SYSTEM['������ҵ����']['ѧ����ҵ']['��Ƹ�������'] = array("../JIUYE/edu_zhaopinshenqin_newai.php","��Ƹ�������");
if($SCHOOL_MODEL_TEXT!="4")	$PRIVATE_SYSTEM['������ҵ����']['ѧ����ҵ']['�Ƽ���ҵ����'] = array("../JIUYE/edu_tuijianjiuye_newai.php","�Ƽ���ҵ����");

if($SCHOOL_MODEL_TEXT!="4")	$PRIVATE_SYSTEM['������ҵ����']['ѧ��ʵϰ']['PARENT'] = array("../JIUYE/ShiXi.php","ѧ����ҵ����");
if($SCHOOL_MODEL_TEXT!="4")	$PRIVATE_SYSTEM['������ҵ����']['ѧ��ʵϰ']['ʵϰ��λ����'] = array("../JIUYE/edu_shixi_newai.php","ʵϰ��λ����");
if($SCHOOL_MODEL_TEXT!="4")	$PRIVATE_SYSTEM['������ҵ����']['ѧ��ʵϰ']['ѧ������ͳ��'] = array("../JIUYE/edu_shixishenqing_newai.php","ѧ������ͳ��");

if($SCHOOL_MODEL_TEXT!="4")	$PRIVATE_SYSTEM['������ҵ����']['����ʵϰ']['PARENT'] = array("../JIUYE/DingGangShiXi.php","����ʵϰ");
if($SCHOOL_MODEL_TEXT!="4")	$PRIVATE_SYSTEM['������ҵ����']['����ʵϰ']['����ʵϰ����'] = array("../JIUYE/edu_dinggangshixitype_newai.php","����ʵϰ����");
if($SCHOOL_MODEL_TEXT!="4")	$PRIVATE_SYSTEM['������ҵ����']['����ʵϰ']['����ʵϰ��Ŀ'] = array("../JIUYE/edu_dinggangshixiname_newai.php","����ʵϰ��Ŀ");
if($SCHOOL_MODEL_TEXT!="4")	$PRIVATE_SYSTEM['������ҵ����']['����ʵϰ']['����ʵϰ��ϸ'] = array("../JIUYE/edu_dinggangshixidetail_newai.php","����ʵϰ��ϸ");
if($SCHOOL_MODEL_TEXT!="4")	$PRIVATE_SYSTEM['������ҵ����']['����ʵϰ']['����ʵϰ�ռ�'] = array("../JIUYE/edu_dinggangshixiriji_newai.php","����ʵϰ�ռ�");
if($SCHOOL_MODEL_TEXT!="4")	$PRIVATE_SYSTEM['������ҵ����']['����ʵϰ']['����ʵϰͳ��'] = array("../JIUYE/edu_dinggangshixidetail_static.php","����ʵϰͳ��");


if($SCHOOL_MODEL_TEXT!="4")	$PRIVATE_SYSTEM['������ҵ����']['У��']['PARENT'] = array("../JIUYE/XiaoYou.php","У����Ϣ����");
if($SCHOOL_MODEL_TEXT!="4")	$PRIVATE_SYSTEM['������ҵ����']['У��']['У�Ѱ༶��Ϣ'] = array("../JIUYE/edu_xiaoyoubanji_newai.php","У�Ѱ༶��Ϣ");
if($SCHOOL_MODEL_TEXT!="4")	$PRIVATE_SYSTEM['������ҵ����']['У��']['У����Ϣ����'] = array("../JIUYE/edu_xiaoyou_newai.php","У����Ϣ����");
if($SCHOOL_MODEL_TEXT!="4")	$PRIVATE_SYSTEM['������ҵ����']['У��']['У�Ѽ���Ʒ����'] = array("../JIUYE/edu_xiaoyoujinianpin_newai.php","����Ʒ����");
if($SCHOOL_MODEL_TEXT!="4")	$PRIVATE_SYSTEM['������ҵ����']['У��']['У�ѻ���Ϣ����'] = array("../JIUYE/edu_xiaoyouxinxi_newai.php","У�ѻ���Ϣ����");


$PRIVATE_SYSTEM['�������']['�ճ���ѧ����']['PARENT'] = array("MAIN_RICHENGJIAOXUE.php","�ճ���ѧ����");
$PRIVATE_SYSTEM['�������']['�ճ���ѧ����']['��ʦ����'] = array("edu_teacherKaoQin.php","��ʦ����");
$PRIVATE_SYSTEM['�������']['�ճ���ѧ����']['��ѧ�ռ�'] = array("edu_teacherjiaoxueriji_static.php","��ѧ�ռ�");
$PRIVATE_SYSTEM['�������']['�ճ���ѧ����']['ѧ�������������']	= array("edu_studentkaoqin_newai.php","ѧ�������������");
//$PRIVATE_SYSTEM['�������']['�ճ���ѧ����']['��ѧ����'] = array("BanJiInfor.php","��ѧ����");
$PRIVATE_SYSTEM['�������']['�ճ���ѧ����']['������ͳ��'] = array("kechou.php","������ͳ��");
$PRIVATE_SYSTEM['�������']['�ճ���ѧ����']['���ý�ѧ����'] = array("../JiaXuePingJia/edu_teacherPingJia.php","���ý�ѧ����");
$PRIVATE_SYSTEM['�������']['�ճ���ѧ����']['����֪ͨ'] = array("school_jiaowuke_notify_newai.php","����֪ͨ");
$PRIVATE_SYSTEM['�������']['�ճ���ѧ����']['ѧ��֤��'] = array("edu_zhengshuguanli_newai.php","ѧ��֤��");
$PRIVATE_SYSTEM['�������']['�ճ���ѧ����']['��ʦ�����ʾ�'] = array("edu_teacher_DiaoChaWenJuan.php","��ʦ�����ʾ�");


$PRIVATE_SYSTEM['�������']['��ѧ������Ϣ']['PARENT'] = array("MAIN_JIAOXUEBASICINFOR.php","��ѧ������Ϣ");
$PRIVATE_SYSTEM['�������']['��ѧ������Ϣ']['ѧ��'] = array("edu_xueqiexec_newai.php","ѧ������");
$PRIVATE_SYSTEM['�������']['��ѧ������Ϣ']['У��'] = array("edu_schoolcalendar_newai.php","У������");
$PRIVATE_SYSTEM['�������']['��ѧ������Ϣ']['�γ̿�']= array("edu_course.php","�γ̿�");
$PRIVATE_SYSTEM['�������']['��ѧ������Ϣ']['����'] = array("edu_classroom.php","���ҹ���");
//$PRIVATE_SYSTEM['�������']['��ѧ������Ϣ']['Զ�̽�ѧ'] = array("edu_yuancheng.php","Զ�̽���");
if($SCHOOL_MODEL_TEXT!="4")		$PRIVATE_SYSTEM['�������']['��ѧ������Ϣ']['��ѧ�ƻ�'] = array("edu_planexec.php","��ѧ�ƻ�");
if($SCHOOL_MODEL_TEXT=="4")		$PRIVATE_SYSTEM['�������']['��ѧ������Ϣ']['��ѧ�ƻ�'] = array("edu_planexec_middleschool_newai.php","��ѧ�ƻ�");
$PRIVATE_SYSTEM['�������']['��ѧ������Ϣ']['��ѧ����'] = array("edu_jiaoxuejingcheng.php","��ѧ����");
$PRIVATE_SYSTEM['�������']['��ѧ������Ϣ']['ÿ�ܹ����ص���ʾ'] = array("edu_benzhouzhongdiantishi_newai.php","ÿ�ܹ����ص���ʾ");


$PRIVATE_SYSTEM['�������']['ѧ��']['PARENT'] = array("StudentFile.php","ѧ��");
$PRIVATE_SYSTEM['�������']['ѧ��']['ѧ��ѧ������'] = array("studentFilesFrame.php","ѧ����������(���Զ�ѧ���ĵ������й���,���������춯��Ϣ)");
$PRIVATE_SYSTEM['�������']['ѧ��']['ѧ���춯����'] = array("studentFlowFrame.php","ѧ���춯����");
$PRIVATE_SYSTEM['�������']['ѧ��']['ѧ���춯����'] = array("student_changelist.php","ѧ���춯��Ϣ����(���Զ�ѧ����תѧ/��ѧ/��ѧ/����/ת����춯��Ϣ���в��ĺʹ�ӡ)");
$PRIVATE_SYSTEM['�������']['ѧ��']['һ��ͨ���ż���'] = array("studentEcardFrame.php","ѧ��һ��ͨ���ż���(���԰�ʳ�û�����������ʹ�õ�һ��ͨ�Ŀ�����ѧ�Ž��й���)");
if($SCHOOL_MODEL_TEXT=="4")		$PRIVATE_SYSTEM['�������']['ѧ��']['���·ְ�'] = array("studentBanjiReset.php","ѧУÿ��һ�ȵ����·ְ๤��,ֻ�������Ҫ��������ְ����СѧУʹ��");


$PRIVATE_SYSTEM['�������']['�ɼ�']['PARENT']		= array("chengji.php","�ɼ�");
$PRIVATE_SYSTEM['�������']['�ɼ�']['������Ϣ����'] = array("edu_examname_newai.php","������Ϣ����");
$PRIVATE_SYSTEM['�������']['�ɼ�']['�༶�ɼ�����'] = array("Exam_class_change.php","�༶�ɼ�����");
$PRIVATE_SYSTEM['�������']['�ɼ�']['�༶�ɼ���ѯ'] = array("Exam_List.php","�༶�ɼ���ѯ");
$PRIVATE_SYSTEM['�������']['�ɼ�']['�����ɼ�����'] = array("Exam_class_change_bukao.php","�����ɼ�����");
$PRIVATE_SYSTEM['�������']['�ɼ�']['���޳ɼ�����'] = array("Exam_class_change_chongxiu.php","���޳ɼ�����");
$PRIVATE_SYSTEM['�������']['�ɼ�']['����ǿ��ת����']	= array("Exam_class_bukao_to_chongxiu.php","����ǿ��ת����");
$PRIVATE_SYSTEM['�������']['�ɼ�']['�ɼ����浥']	= array("edu_xueshengchengji.php","�ɼ����浥");
$PRIVATE_SYSTEM['�������']['�ɼ�']['�ɼ���ϸ����'] = array("edu_exam_newai.php","�ɼ���ϸ����");
$PRIVATE_SYSTEM['�������']['�ɼ�']['ɾ���ɼ�(����)']	= array("edu_exam_trunk.php","ɾ���ɼ�(����)");
$PRIVATE_SYSTEM['�������']['�ɼ�']['δ¼�ɼ��༶�б�']	= array("edu_exam_noinputbanjilist.php","δ¼�ɼ��༶�б�");
$PRIVATE_SYSTEM['�������']['�ɼ�']['δ¼�ɼ���ʦ�б�']	= array("edu_exam_noinputuserlist.php","δ¼�ɼ���ʦ�б�");



$PRIVATE_SYSTEM['�������']['�α�']['PARENT']		= array("ScheduleMain.php","�α�");
$PRIVATE_SYSTEM['�������']['�α�']['��ѧ�ƻ�����'] = array("edu_planexec.php","��ѧ�ƻ�����");
$PRIVATE_SYSTEM['�������']['�α�']['�����ſ�����'] = array("edu_schedule_autoform_setting.php","�����ſ�����");
$PRIVATE_SYSTEM['�������']['�α�']['���������ſ�'] = array("../SunshineCT/AutoFormCourse.php","���������ſ�");
$PRIVATE_SYSTEM['�������']['�α�']['��ʦ���ſ�ʱ��'] = array("edu_scheduleroles_newai.php","��ʦ���ſ�ʱ��");
$PRIVATE_SYSTEM['�������']['�α�']['���༶�ֹ�����'] = array("schedule_frame.php","���༶�ֹ�����");
$PRIVATE_SYSTEM['�������']['�α�']['����Ƶ���'] = array("edu_schedule_setting.php","����Ƶ���");
$PRIVATE_SYSTEM['�������']['�α�']['�ڼ��յ���'] = array("edu_schedulejiejiari_newai.php","�ڼ��յ���");
$PRIVATE_SYSTEM['�������']['�α�']['�ֶν�ѧ����'] = array("edu_schedulefenduanjiaoxue_newai.php","�ֶν�ѧ����");
$PRIVATE_SYSTEM['�������']['�α�']['����ʦ��α�'] = array("schedule_teacher.php","����ʦ��α�");
$PRIVATE_SYSTEM['�������']['�α�']['���༶��α�'] = array("schedule_class.php","���༶��α�");
$PRIVATE_SYSTEM['�������']['�α�']['�����Ҳ�α�'] = array("schedule_classroom.php","�����Ҳ�α�");
$PRIVATE_SYSTEM['�������']['�α�']['�α��ۺϲ�ѯ'] = array("schedule.php","�α��ۺϲ�ѯ");
$PRIVATE_SYSTEM['�������']['�α�']['��ѯ�ܿα�'] = array("schedule_yuanxi.php","��ѯ�ܿα�");
$PRIVATE_SYSTEM['�������']['�α�']['��Ϣʱ����趨'] = array("schedule_timesetting.php","��Ϣʱ����趨");
$PRIVATE_SYSTEM['�������']['�α�']['��ʦ�ܿ�ʱͳ��'] = array("schedule_teacherkeshishou.php","��ʦ�ܿ�ʱͳ��");
$PRIVATE_SYSTEM['�������']['�α�']['�α�ԭʼ����'] = array("edu_schedule_newai.php","�α�ԭʼ����");
$PRIVATE_SYSTEM['�������']['�α�']['�α�������߼�'] = array("edu_schedule_tools.php","�α�������߼�");


$PRIVATE_SYSTEM['�������']['�̲�']['PARENT']		= array("MAIN_JIAOCAI.php","�̲Ĺ���");
$PRIVATE_SYSTEM['�������']['�̲�']['�̲Ĺ���']		= array("edu_jiaocai_newai.php","�̲Ĺ���");
$PRIVATE_SYSTEM['�������']['�̲�']['�̲ļƻ�']		= array("edu_jiaocaiplan_newai.php","�̲ļƻ�");
$PRIVATE_SYSTEM['�������']['�̲�']['�ɹ���']		= array("edu_jiaocaiplan_caigoudan.php","�ɹ���");
$PRIVATE_SYSTEM['�������']['�̲�']['���']			= array("edu_jiaocaiplan_ruku.php","���");//edu_jiaocaiin_newai.php
$PRIVATE_SYSTEM['�������']['�̲�']['����']			= array("edu_jiaocaiplan_fafang.php","����");//edu_jiaocaiout_newai
$PRIVATE_SYSTEM['�������']['�̲�']['��ϸ']			= array("edu_jiaocaistudent_newai.php","��ϸ");//edu_jiaocaiout_newai
//$PRIVATE_SYSTEM['�������']['�̲�']['�˻�']			= array("edu_jiaocaitui_newai.php","�˻�");
$PRIVATE_SYSTEM['�������']['�̲�']['������ϸ']		= array("edu_jiaocai_detail.php","������ϸ");
$PRIVATE_SYSTEM['�������']['�̲�']['����']			= array("edu_jiaocai_setting.php","�ֿ�����");
$PRIVATE_SYSTEM['�������']['�̲�']['�̲�ͳ��']		= array("edu_jiaocaicangkutongji_newai.php","�ֿ�����");
$PRIVATE_SYSTEM['�������']['�̲�']['����ͳ��']		= array("edu_jiaocaitongji_newai.php","����ͳ��");
$PRIVATE_SYSTEM['�������']['�̲�']['����ͳ��']		= array("jiaocaipingjiatongji.php","����ͳ��");

$PRIVATE_SYSTEM['�������']['��ѧ����']['PARENT']   =array("MAIN_JIAOXUETINGKE.php","��ѧ���ι���");
$PRIVATE_SYSTEM['�������']['��ѧ����']['���μƻ�'] = array("edu_tingke_newai.php","���μƻ�");
$PRIVATE_SYSTEM['�������']['��ѧ����']['���ο���'] = array("edu_tingke_kaoqin_newai.php","���ο���");
$PRIVATE_SYSTEM['�������']['��ѧ����']['���ο��ڲ���']		= array("edu_tingke_kaoqinbudeng_newai.php","���ο��ڲ���");
$PRIVATE_SYSTEM['�������']['��ѧ����']['�����ռ�']			= array("edu_tingke_riji_newai.php","�����ռ�");
$PRIVATE_SYSTEM['�������']['��ѧ����']['���β���']			= array("edu_tingke_ceping_newai.php","���β���");
$PRIVATE_SYSTEM['�������']['��ѧ����']['���ι�����']		= array("edu_tingke_gongzuoliang_newai.php","���ι�����");

$PRIVATE_SYSTEM['�������']['�����ſ�']				= array("paikao.php","�����ſ�");
$PRIVATE_SYSTEM['�������']['ѡ��']					= array("../XUANKE/MAIN_XUANKE.php","ѡ��");

$PRIVATE_SYSTEM['�������']['����']['PARENT']		= array("MAIN_KEYAN.php","���й���");
$PRIVATE_SYSTEM['�������']['����']['������Ŀ']		= array("keyan_xiangmuguanli_newai.php","������Ŀ");
$PRIVATE_SYSTEM['�������']['����']['��������']		= array("keyan_lixiangshenpi_newai.php","��������");
$PRIVATE_SYSTEM['�������']['����']['�ƻ�ָ��']		= array("keyan_jihuazhinan_newai.php","�ƻ�ָ��");
$PRIVATE_SYSTEM['�������']['����']['��ͬ����']		= array("keyan_hetongguanli_newai.php","��ͬ����");
$PRIVATE_SYSTEM['�������']['����']['�滮��̬']		= array("keyan_guihuadongtai_newai.php","�滮��̬");
$PRIVATE_SYSTEM['�������']['����']['������ѧ']		= array("edu_guanmingbaoban_newai.php","������ѧ");
$PRIVATE_SYSTEM['�������']['����']['У�����']		= array("edu_xiaoqihezuo_newai.php","У�����");
$PRIVATE_SYSTEM['�������']['����']['�����о�']		= array("keti_yanjiu_newai.php","�����о�");
$PRIVATE_SYSTEM['�������']['����']['���']			= array("keyan_leibie_newai.php","���");
$PRIVATE_SYSTEM['�������']['����']['����']			= array("keyan_leixing_newai.php","����");


//��ʦ����
$PRIVATE_SYSTEM['��ʦ����']['��ʦ������Ϣ']['PARENT']			= array("../TeacherManage/MAIN_JIAOSHIXINXI.php","��ʦ��Ϣ����");
$PRIVATE_SYSTEM['��ʦ����']['��ʦ������Ϣ']['��ʦ��Ϣ�б�']		= array("../TeacherManage/edu_teachermanage_newai.php","��ʦ��Ϣ�б�");
$PRIVATE_SYSTEM['��ʦ����']['��ʦ������Ϣ']['��ʦ����һ����']	= array("../TeacherManage/schedule_teacher.php","��ʦ����һ����");
$PRIVATE_SYSTEM['��ʦ����']['��ʦ������Ϣ']['��ʦ�������˵ǼǱ�'] = array("../TeacherManage/edu_teacher_work_check_register_newai.php","��ʦ�������˵ǼǱ�");
$PRIVATE_SYSTEM['��ʦ����']['��ʦ������Ϣ']['��ʦ��ȿ���������'] = array("../TeacherManage/edu_teacher_yearcheck_newai.php","��ʦ��ȿ���������");
$PRIVATE_SYSTEM['��ʦ����']['��ʦ������Ϣ']['��ʦ����Ȩ������'] = array("../TeacherManage/inc_teacher_priv.php","��ʦ����Ȩ������");
$PRIVATE_SYSTEM['��ʦ����']['��ʦ������Ϣ']['��������']			= array("../TeacherManage/gb_jibie_newai.php","��������");

$PRIVATE_SYSTEM['��ʦ����']['��ʦ��ϸ����']['PARENT']		= array("../TeacherManage/MAIN_JIAOSHIXINXICHAXUN.php","��ʦ��Ϣ��ѯ");
$PRIVATE_SYSTEM['��ʦ����']['��ʦ��ϸ����']['�������']		= array("../TeacherManage/edu_teacherrewards_newai.php","�������");
$PRIVATE_SYSTEM['��ʦ����']['��ʦ��ϸ����']['��ʦ��ְ��ְ'] = array("../TeacherManage/edu_teacheriswork_newai.php","��ʦ��ְ��ְ��¼");
$PRIVATE_SYSTEM['��ʦ����']['��ʦ��ϸ����']['���˼���']		= array("../TeacherManage/edu_teacherxuexijingli_newai.php","���˼���");
$PRIVATE_SYSTEM['��ʦ����']['��ʦ��ϸ����']['���ĵǼ�']		= array("../TeacherManage/edu_teacherlunwen_newai.php","���ĵǼ�");
$PRIVATE_SYSTEM['��ʦ����']['��ʦ��ϸ����']['����Ǽ�']		= array("../TeacherManage/edu_teacherketi_newai.php","����Ǽ�");
$PRIVATE_SYSTEM['��ʦ����']['��ʦ��ϸ����']['�����ɹ��Ǽ�'] = array("../TeacherManage/edu_teacherchengguo_newai.php","�����ɹ��Ǽ�");
$PRIVATE_SYSTEM['��ʦ����']['��ʦ��ϸ����']['��ѵ���']		= array("../TeacherManage/edu_teacherpeixun_newai.php","��ѵ���");


$PRIVATE_SYSTEM['��ʦ����']['��ʦ������ѯ']						= array("../TeacherManage/EDU_teacherserch.php","��ʦ������ѯ");

$PRIVATE_SYSTEM['��ʦ����']['���ż������']['PARENT']			= array("../TeacherManage/MAIN_JIAOSHIBUMENGUANLI.php","��ʦ���Ź���");
$PRIVATE_SYSTEM['��ʦ����']['���ż������']['��������']			= array("../TeacherManage/my_edu_teachermanage_newai.php","��������");
$PRIVATE_SYSTEM['��ʦ����']['���ż������']['���ĵǼ�']			= array("../TeacherManage/my_edu_teacherlunwen_newai.php","���ĵǼ�");
$PRIVATE_SYSTEM['��ʦ����']['���ż������']['����Ǽ�']			= array("../TeacherManage/my_edu_teacherketi_newai.php","����Ǽ�");
$PRIVATE_SYSTEM['��ʦ����']['���ż������']['�����ɹ��Ǽ�']		= array("../TeacherManage/my_edu_teacherchengguo_newai.php","�����ɹ��Ǽ�");
$PRIVATE_SYSTEM['��ʦ����']['���ż������']['��ѵ���']			= array("../TeacherManage/my_edu_teacherpeixun_newai.php","��ѵ���");
$PRIVATE_SYSTEM['��ʦ����']['���ż������']['�������']			= array("../TeacherManage/my_edu_teacherrewards_newai.php","�������");
$PRIVATE_SYSTEM['��ʦ����']['���ż������']['��������']			= array("../TeacherManage/my_edu_teacher_work_check_register_newai.php","��������");
$PRIVATE_SYSTEM['��ʦ����']['���ż������']['�������']			= array("../TeacherManage/my_edu_teacher_yearcheck_newai.php","�������");
$PRIVATE_SYSTEM['��ʦ����']['���ż������']['���˼���']			= array("../TeacherManage/my_edu_teacherxuexijingli_newai.php","���˼���");
$PRIVATE_SYSTEM['��ʦ����']['���ż������']['�οα�']			= array("../TeacherManage/my_schedule_teacher.php","�οα�");



//����˵�����
$PRIVATE_SYSTEM['ѧ������']['������']['PARENT']			= array("MAIN_BANZHUREN.php","�����ι���");
$PRIVATE_SYSTEM['ѧ������']['������']['��������Ϣ����'] = array("edu_banzhuren_setting.php","��������Ϣ����");
$PRIVATE_SYSTEM['ѧ������']['������']['ÿ�ܹ����ص�'] = array("edu_meizhoubeiwang_newai.php","ÿ�ܹ����ص�");
$PRIVATE_SYSTEM['ѧ������']['������']['�༶�ܼ�'] = array("edu_banjizhouji_newai.php","�༶�ܼ�");
$PRIVATE_SYSTEM['ѧ������']['������']['�ֻ��������'] = array("edu_banzhurenxinxi_newai.php","�ֻ��������");



$PRIVATE_SYSTEM['ѧ������']['�༶���ٷ�']['PARENT']			= array("../BanJiGuanLi/MAIN_BANJIGUANLI.php","�༶����");
$PRIVATE_SYSTEM['ѧ������']['�༶���ٷ�']['���ٷ�����']	= array("../BanJiGuanLi/edu_banjichuangbaifen.php","���ٷ�����");
$PRIVATE_SYSTEM['ѧ������']['�༶���ٷ�']['���ٷ�ָ����ʦ']	= array("../BanJiGuanLi/edu_banjichuangbaifen_zhidaolaoshi.php","���ٷ�ָ����ʦ����");
$PRIVATE_SYSTEM['ѧ������']['�༶���ٷ�']['���ٷ��ܸ�����ʦ']	= array("../BanJiGuanLi/edu_evaluateclass.php","���ٷ��ܹ���ʦ");
$PRIVATE_SYSTEM['ѧ������']['�༶���ٷ�']['���˻��ֹ���'] = array("../BanJiGuanLi/edu_gebanjifenqingkuang.php","������˻������");
$PRIVATE_SYSTEM['ѧ������']['�༶���ٷ�']['���ֱ�׼'] = array("../BanJiGuanLi/edu_pingbixiangmu_newai.php","���˻������ֱ�׼");
$PRIVATE_SYSTEM['ѧ������']['�༶���ٷ�']['���ַ���'] = array("../BanJiGuanLi/edu_evaluatepersonalgroup_newai.php","���˻��ַ�������");
$PRIVATE_SYSTEM['ѧ������']['�༶���ٷ�']['���ü��ɰ��༶ͳ��'] = array("../BanJiGuanLi/edu_ketangjilvbanjitongji_newai.php","���ü��ɰ��༶ͳ��");


$PRIVATE_SYSTEM['ѧ������']['ѧ������']['PARENT']		= array("../SuSheGuanLi/Dorm.php","ѧ���������");
$PRIVATE_SYSTEM['ѧ������']['ѧ������']['������Ϣ����'] = array("../SuSheGuanLi/Dorm_BasicInfor.php","������Ϣ����");
$PRIVATE_SYSTEM['ѧ������']['ѧ������']['����������'] = array("../SuSheGuanLi/Dorm_Jiancha.php","����������");
$PRIVATE_SYSTEM['ѧ������']['ѧ������']['������������'] = array("../SuSheGuanLi/Dorm_WenMing.php","������������");
$PRIVATE_SYSTEM['ѧ������']['ѧ������']['�ճ��������'] = array("../SuSheGuanLi/Dorm_RiChangShiWu.php","�ճ��������:���ܽ�ʦ���ò˵�");

/*
$PRIVATE_SYSTEM['ѧ������']['��Ա']['PARENT'] = array("../DangWuGuanLi/MAIN_DANGWU.php","��Ա����");
$PRIVATE_SYSTEM['ѧ������']['��Ա']['��Ա����'] = array("../DangWuGuanLi/xingzheng_partymember_newai.php","��Ա����");
$PRIVATE_SYSTEM['ѧ������']['��Ա']['���ѽ���'] = array("../DangWuGuanLi/xingzheng_partyfeein_newai.php","���ѽ���");
$PRIVATE_SYSTEM['ѧ������']['��Ա']['����ͳ��'] = array("../DangWuGuanLi/xingzheng_partyfeein.static.php","����ͳ��");
$PRIVATE_SYSTEM['ѧ������']['��Ա']['Ԥ����Ա'] = array("../DangWuGuanLi/xingzheng_partymember2_newai.php","Ԥ����Ա");
$PRIVATE_SYSTEM['ѧ������']['��Ա']['����֯�'] = array("../DangWuGuanLi/xingzheng_partyactive_newai.php","����֯�");
$PRIVATE_SYSTEM['ѧ������']['��Ա']['��֧������'] = array("../DangWuGuanLi/xingzheng_partyunit_newai.php","��֧������");
$PRIVATE_SYSTEM['ѧ������']['��Ա']['��Ա״̬'] = array("../DangWuGuanLi/xingzheng_partystatus_newai.php","��Ա״̬");

$PRIVATE_SYSTEM['ѧ������']['��Ա']['PARENT'] = array("../TuanWuGuanLi/MAIN_TUANWU.php","��Ա����");
$PRIVATE_SYSTEM['ѧ������']['��Ա']['��Ա����'] = array("../TuanWuGuanLi/xingzheng_leaguemember_newai.php","��Ա����");
$PRIVATE_SYSTEM['ѧ������']['��Ա']['�ŷѽ���'] = array("../TuanWuGuanLi/xingzheng_leaguefeein_newai.php","�ŷѽ���");
$PRIVATE_SYSTEM['ѧ������']['��Ա']['����ͳ��'] = array("../TuanWuGuanLi/xingzheng_leaguefeein.static.php","����ͳ��");
$PRIVATE_SYSTEM['ѧ������']['��Ա']['�ŷ�֧��'] = array("../TuanWuGuanLi/xingzheng_leaguefeeout_newai.php","�ŷ�֧��");
$PRIVATE_SYSTEM['ѧ������']['��Ա']['֧��ͳ��'] = array("../TuanWuGuanLi/xingzheng_leaguefeeout.static.php","֧��ͳ��");
$PRIVATE_SYSTEM['ѧ������']['��Ա']['����֯�'] = array("../TuanWuGuanLi/xingzheng_leagueactive_newai.php","����֯�");
$PRIVATE_SYSTEM['ѧ������']['��Ա']['��֧������'] = array("../TuanWuGuanLi/xingzheng_leagueunit_newai.php","��֧������");

$PRIVATE_SYSTEM['ѧ������']['����']['PARENT'] = array("../SheTuanGuanLi/MAIN_SHETUAN.php","���Ź���");
$PRIVATE_SYSTEM['ѧ������']['����']['���Ź���'] = array("../SheTuanGuanLi/xingzheng_association_newai.php","���Ź���");
$PRIVATE_SYSTEM['ѧ������']['����']['���ų�Ա'] = array("../SheTuanGuanLi/xingzheng_associationmember_newai.php","���ų�Ա");
$PRIVATE_SYSTEM['ѧ������']['����']['���Ż'] = array("../SheTuanGuanLi/xingzheng_associationactive_newai.php","���Ż");
$PRIVATE_SYSTEM['ѧ������']['����']['��������'] = array("../SheTuanGuanLi/xingzheng_associationjudge_newai.php","��������");
$PRIVATE_SYSTEM['ѧ������']['����']['��Աְ��'] = array("../SheTuanGuanLi/xingzheng_associationmembertype_newai.php","��Աְ��");
$PRIVATE_SYSTEM['ѧ������']['����']['��������'] = array("../SheTuanGuanLi/xingzheng_associationtype_newai.php","��������");
*/

//$PRIVATE_SYSTEM['ѧ������']['������']['PARENT']			= array("edu_xueshengqingjia.php","ѧ��������");
//$PRIVATE_SYSTEM['ѧ������']['������']['ѧ������������']	= array("edu_xueshengqingjia2_newai.php","ѧ������������");
//$PRIVATE_SYSTEM['ѧ������']['������']['ѧ��������ͳ��']	= array("xueshengqingjiawaichu.php","ѧ��������ͳ��");

$PRIVATE_SYSTEM['ѧ������']['�ۺ�����']['PARENT']		= array("../XueShengGuanLi/MAIN_XUESHENG_ZONGHESHIWU.php","�ۺ�����");
$PRIVATE_SYSTEM['ѧ������']['�ۺ�����']['������']		= array("../XueShengGuanLi/edu_xueshengqingjia.php","������");
$PRIVATE_SYSTEM['ѧ������']['�ۺ�����']['�ʾ����']		= array("../XueShengGuanLi/DIAOCHAWENJUAN.php","�ʾ����");
$PRIVATE_SYSTEM['ѧ������']['�ۺ�����']['�ڶ�����']		= array("../BanJiGuanLi/MAIN_DIERKETANG.php","�ڶ�����");
$PRIVATE_SYSTEM['ѧ������']['�ۺ�����']['��Ա']			= array("../DangWuGuanLi/MAIN_DANGWU.php","��Ա");
$PRIVATE_SYSTEM['ѧ������']['�ۺ�����']['��Ա']			= array("../TuanWuGuanLi/MAIN_TUANWU.php","��Ա");
$PRIVATE_SYSTEM['ѧ������']['�ۺ�����']['����']			= array("../SheTuanGuanLi/MAIN_SHETUAN.php","����");


$PRIVATE_SYSTEM['ѧ������']['���Ͳ���']['PARENT']			= array("../XueShengGuanLi/MAIN_XUESHENG_JIANGCHENGBUZHU.php","���Ͳ���");
$PRIVATE_SYSTEM['ѧ������']['���Ͳ���']['ѧ������']			= array("../XueShengGuanLi/edu_studentjiangcheng_newai.php","ѧ������");
$PRIVATE_SYSTEM['ѧ������']['���Ͳ���']['ѧ��Υ��']			= array("../XueShengGuanLi/edu_weijihuizong_main.php","ѧ��Υ��");
$PRIVATE_SYSTEM['ѧ������']['���Ͳ���']['����ѧ��']			= array("../XueShengGuanLi/MAIN_JIANGZHUXUEJIN.php","����ѧ��");
$PRIVATE_SYSTEM['ѧ������']['���Ͳ���']['����ѧ��']			= array("../XueShengGuanLi/MAIN_JIANGZHUXUEJIN.php","����ѧ��");
$PRIVATE_SYSTEM['ѧ������']['���Ͳ���']['�����']			= array("../XueShengGuanLi/MAIN_SHENGHUOBUZHU.php","�����");
$PRIVATE_SYSTEM['ѧ������']['���Ͳ���']['�ڹ���ѧ']			= array("../XueShengGuanLi/MAIN_QINGONGJIANXUE.php","�����");



//$PRIVATE_SYSTEM['ѧ������']['�ʾ����']['PARENT']			= array("DIAOCHAWENJUAN.php","�ʾ����");
//$PRIVATE_SYSTEM['ѧ������']['�ʾ����']['�������ƹ���']		= array("edu_diaochamingcheng_newai.php","�������ƹ���");
//$PRIVATE_SYSTEM['ѧ������']['�ʾ����']['�������ݹ���']		= array("edu_diaochaneirong_newai.php","�������ݹ���");
//$PRIVATE_SYSTEM['ѧ������']['�ʾ����']['������ϸ']			= array("edu_diaochamingxi_newai.php","������ϸ");
//$PRIVATE_SYSTEM['ѧ������']['�ʾ����']['����ͳ��']			= array("diaochatongji.php","����ͳ��");

//$PRIVATE_SYSTEM['ѧ������']['����ѧ��']['PARENT'] = array("MAIN_JIANGZHUXUEJIN.php","����ѧ�����");
//$PRIVATE_SYSTEM['ѧ������']['����ѧ��']['����ѧ�����'] = array("edu_jiangxuejin_newai.php","����ѧ�����");
//$PRIVATE_SYSTEM['ѧ������']['����ѧ��']['����ѧ������'] = array("edu_jiangxuejintype_newai.php","����ѧ������");
//$PRIVATE_SYSTEM['ѧ������']['����ѧ��']['����ѧ��ͳ��'] = array("edu_jiangzhuxuejinsearch.php","����ѧ��ͳ��");
//$PRIVATE_SYSTEM['ѧ������']['����ѧ��']['����ѧ�����'] = array("edu_jiangxuejingroup_newai.php","����ѧ�����");

//���������˵�
//$PRIVATE_SYSTEM['ѧ������']['�����']['PARENT'] = array("../XueShengGuanLi/MAIN_SHENGHUOBUZHU.php","���������");
//$PRIVATE_SYSTEM['ѧ������']['�����']['���������'] = array("../XueShengGuanLi/edu_shenghuobuzhufenlei_newai.php","���������");
//$PRIVATE_SYSTEM['ѧ������']['�����']['���������'] = array("../XueShengGuanLi/edu_shenghuobuzhutype_newai.php","���������");
//$PRIVATE_SYSTEM['ѧ������']['�����']['���������'] = array("../XueShengGuanLi/edu_shenghuobuzhu_newai.php","���������");
//$PRIVATE_SYSTEM['ѧ������']['�����']['�����ͳ��'] = array("../XueShengGuanLi/edu_buzhusearch.php","�����ͳ��");

//$PRIVATE_SYSTEM['ѧ������']['�ڹ���ѧ']['PARENT'] = array("../XueShengGuanLi/MAIN_QINGONGJIANXUE.php","�ڹ���ѧ����");
//$PRIVATE_SYSTEM['ѧ������']['�ڹ���ѧ']['�ڹ���ѧ����'] = array("../XueShengGuanLi/edu_qingongjianxue_newai.php","�ڹ���ѧ����");
//$PRIVATE_SYSTEM['ѧ������']['�ڹ���ѧ']['ְλ����'] = array("../XueShengGuanLi/edu_qingongjianxuetype_newai.php","����ѧ������");
//$PRIVATE_SYSTEM['ѧ������']['�ڹ���ѧ']['�ڹ���ѧͳ��'] = array("../XueShengGuanLi/edu_qingongjianxuesee.php","�ڹ���ѧͳ��");

//$PRIVATE_SYSTEM['ѧ������']['�ڶ�����']['PARENT'] = array("../BanJiGuanLi/MAIN_DIERKETANG.php","�ڶ����ù���");
//$PRIVATE_SYSTEM['ѧ������']['�ڶ�����']['��Ϣ�ɼ��˹���'] = array("../BanJiGuanLi/edu_dierketangcaijiren.php","��Ϣ�ɼ��˹���");
//$PRIVATE_SYSTEM['ѧ������']['�ڶ�����']['��ܽ���д'] = array("../BanJiGuanLi/edu_dierketangzongjie.php","��ܽ���д");
//$PRIVATE_SYSTEM['ѧ������']['�ڶ�����']['�ڶ����û����'] = array("../BanJiGuanLi/edu_dierketang_newai.php","�ڶ����û����");
//$PRIVATE_SYSTEM['ѧ������']['�ڶ�����']['�ڶ����ü������'] = array("../BanJiGuanLi/edu_dierketangjibie_newai.php","�ڶ����ü������");

$PRIVATE_SYSTEM['ѧ������']['��ҵ��']['PARENT'] = array("MAIN_BIYESHENG.php","��ҵ������");
$PRIVATE_SYSTEM['ѧ������']['��ҵ��']['��ҵ����Ϣ����'] = array("BiyeStudentFilesFrame.php","��ҵ����Ϣ����");
$PRIVATE_SYSTEM['ѧ������']['��ҵ��']['�����ҵ���ɼ�'] = array("edu_youxiubiyesheng_newai.php","�����ҵ���ɼ�");
$PRIVATE_SYSTEM['ѧ������']['��ҵ��']['��ҵ֤����'] = array("edu_biyezheng_newai.php","��ҵ֤����");
$PRIVATE_SYSTEM['ѧ������']['��ҵ��']['��ҵ֤����ͳ��'] = array("edu_biyezheng_tongji.php","��ҵ֤����ͳ��");
$PRIVATE_SYSTEM['ѧ������']['��ҵ��']['�����ҵ֤'] = array("BiyezhengStudentFilesFrame.php","�����ҵ֤");
$PRIVATE_SYSTEM['ѧ������']['��ҵ��']['δ���ҵ֤'] = array("Weiling_BiyezhengStudentFilesFrame.php","δ���ҵ֤");



//���¹�����
if($�����׼�汾!=1)	$PRIVATE_SYSTEM['������Դ']['���¹���']['PARENT'] = array("../XinZhengGuanLi/MAIN_RENSHI.php","���¹���");
if($�����׼�汾!=1)	$PRIVATE_SYSTEM['������Դ']['���¹���']['���µ���'] = array("../XinZhengGuanLi/hrms_file_newai.php","���µ���");
if($�����׼�汾!=1)	$PRIVATE_SYSTEM['������Դ']['���¹���']['����'] = array("../XinZhengGuanLi/hrms_reward_punishment_newai.php","���͹���");
if($�����׼�汾!=1)	$PRIVATE_SYSTEM['������Դ']['���¹���']['����'] = array("../XinZhengGuanLi/hrms_transfer_newai.php","���µ���");
if($�����׼�汾!=1)	$PRIVATE_SYSTEM['������Դ']['���¹���']['��ְ'] = array("../XinZhengGuanLi/hrms_file_lizhi_newai.php","��ְ����");
if($�����׼�汾!=1)	$PRIVATE_SYSTEM['������Դ']['���¹���']['��ְ'] = array("../XinZhengGuanLi/hrms_file_fuzhi_newai.php","��ְ����");
if($�����׼�汾!=1)	$PRIVATE_SYSTEM['������Դ']['���¹���']['ְ��'] = array("../XinZhengGuanLi/hrms_worker_zhicheng_newai.php","ְ������");
if($�����׼�汾!=1)	$PRIVATE_SYSTEM['������Դ']['���¹���']['֤��'] = array("../XinZhengGuanLi/hrms_worker_zhengzhao_newai.php","֤�չ���");
if($�����׼�汾!=1)	$PRIVATE_SYSTEM['������Դ']['���¹���']['��ͬ'] = array("../XinZhengGuanLi/hrms_worker_hetong_newai.php","��ͬ����");
if($�����׼�汾!=1)	$PRIVATE_SYSTEM['������Դ']['���¹���']['ѧϰ����'] = array("../XinZhengGuanLi/hrms_educationalexperience_newai.php","ѧϰ����");
if($�����׼�汾!=1)	$PRIVATE_SYSTEM['������Դ']['���¹���']['��������'] = array("../XinZhengGuanLi/hrms_workexperience_newai.php","��������");
if($�����׼�汾!=1)	$PRIVATE_SYSTEM['������Դ']['���¹���']['�Ͷ�����'] = array("../XinZhengGuanLi/hrms_laboringskill_newai.php","�Ͷ�����");
if($�����׼�汾!=1)	$PRIVATE_SYSTEM['������Դ']['���¹���']['����ϵ'] = array("../XinZhengGuanLi/hrms_socialrelation_newai.php","����ϵ");


if($�����׼�汾!=1)	$PRIVATE_SYSTEM['������Դ']['��������']['PARENT'] = array("../XinZhengGuanLi/MAIN_XINGZHENGKAOQIN.php","��������");
if($�����׼�汾!=1)	$PRIVATE_SYSTEM['������Դ']['��������']['���'] = array("../XinZhengGuanLi/edu_xingzheng_group_newai.php","�����������");
if($�����׼�汾!=1)	$PRIVATE_SYSTEM['������Դ']['��������']['���'] = array("../XinZhengGuanLi/edu_xingzheng_banci_newai.php","�����������");
if($�����׼�汾!=1)	$PRIVATE_SYSTEM['������Դ']['��������']['�Ű�'] = array("../XinZhengGuanLi/edu_xingzheng_paiban.php","�����Ű�����");
if($�����׼�汾!=1)	$PRIVATE_SYSTEM['������Դ']['��������']['ԭʼ��'] = array("../XinZhengGuanLi/edu_xingzheng_kaoqin_newai.php","ԭʼ������");
if($�����׼�汾!=1)	$PRIVATE_SYSTEM['������Դ']['��������']['��������'] = array("../XinZhengGuanLi/edu_xingzheng_kaoqinmingxi_newai.php","����������ϸ");
if($�����׼�汾!=1)	$PRIVATE_SYSTEM['������Դ']['��������']['����ͳ��'] = array("../XinZhengGuanLi/edu_xingzheng_kaoqin_static.php","��������ͳ��");
if($�����׼�汾!=1)	$PRIVATE_SYSTEM['������Դ']['��������']['������ϸ'] = array("../XinZhengGuanLi/edu_xingzheng_workflow.php","��������ͳ��");
if($�����׼�汾!=1)	$PRIVATE_SYSTEM['������Դ']['��������']['���ż�����'] = array("../XinZhengGuanLi/my_bumen_xingzheng.php","���ڹ����ż�");
if($�����׼�汾!=1)	$PRIVATE_SYSTEM['������Դ']['��������']['��ʼ��'] = array("../XinZhengGuanLi/edu_xingzheng_kaoqinmingxi_administrator_change.php","���ڳ�ʼ��");
if($�����׼�汾!=1)	$PRIVATE_SYSTEM['������Դ']['��������']['�ҵĿ���'] = array("../XinZhengGuanLi/my_xingzheng.php","�ҵ���������");
if($�����׼�汾!=1)	$PRIVATE_SYSTEM['������Դ']['��������']['���ڻ�'] = array("../Help/XingzhengKaoQin.php","���ڻ�ʹ��˵��");
if($�����׼�汾!=1)	$PRIVATE_SYSTEM['������Դ']['��������']['�Զ���ȡ'] = array("../XinZhengGuanLi/edu_xingzheng_kaoqinmingxi_automake.php","�Զ���ȡ���ڻ�����");

if($�����׼�汾!=1)	$PRIVATE_SYSTEM['������Դ']['��Ա����']['PARENT'] = array("../DangWuGuanLi/MAIN_RENYUANKAOHE.php","��Ա����");
if($�����׼�汾!=1)	$PRIVATE_SYSTEM['������Դ']['��Ա����']['������Ա�������˵ǼǱ�'] = array("../DangWuGuanLi/edu_xingzheng_work_check_register_newai.php","������Ա�������˵ǼǱ�");
if($�����׼�汾!=1)	$PRIVATE_SYSTEM['������Դ']['��Ա����']['������Ա��ȿ���������'] = array("../DangWuGuanLi/edu_xingzheng_yearcheck_newai.php","������Ա��ȿ���������");


if($�����׼�汾!=1)	$PRIVATE_SYSTEM['������Դ']['��Ա����']['PARENT'] = array("../DangWuGuanLi/RLZY_MAIN_DANGWU.php","��Ա����");
if($�����׼�汾!=1)	$PRIVATE_SYSTEM['������Դ']['��Ա����']['��Ա����'] =array("../DangWuGuanLi/edu_teacher_partymember_newai.php","��Ա����");
if($�����׼�汾!=1)	$PRIVATE_SYSTEM['������Դ']['��Ա����']['���ѽ���'] = array("../DangWuGuanLi/edu_teacher_partyfee_newai.php","���ѽ���");
if($�����׼�汾!=1)	$PRIVATE_SYSTEM['������Դ']['��Ա����']['����ͳ��'] = array("../DangWuGuanLi/teacher_partyfeein.static.php","����ͳ��");
if($�����׼�汾!=1)	$PRIVATE_SYSTEM['������Դ']['��Ա����']['Ԥ����Ա'] = array("../DangWuGuanLi/edu_teacher_partymember2_newai.php","Ԥ����Ա");
if($�����׼�汾!=1)	$PRIVATE_SYSTEM['������Դ']['��Ա����']['����֯�'] = array("../DangWuGuanLi/xingzheng_partyactive_newai.php","����֯�");
if($�����׼�汾!=1)	$PRIVATE_SYSTEM['������Դ']['��Ա����']['��֧������'] = array("../DangWuGuanLi/xingzheng_partyunit_newai.php","��֧������");
if($�����׼�汾!=1)	$PRIVATE_SYSTEM['������Դ']['��Ա����']['��Ա״̬'] = array("../DangWuGuanLi/xingzheng_partystatus_newai.php","��Ա״̬");
if($�����׼�汾!=1)	$PRIVATE_SYSTEM['������Դ']['��Ա����']['��Ա�����������']=array("../DangWuGuanLi/edu_dangyuan_yearcheck_newai.php","��Ա�����������");
if($�����׼�汾!=1)	$PRIVATE_SYSTEM['������Դ']['��Ա����']['�������鵳Ա�ǼǱ�']=array("../DangWuGuanLi/edu_dangyuan_work_check_register_newai.php","�������鵳Ա�ǼǱ�");



if($�����׼�汾!=1)	$PRIVATE_SYSTEM['������Դ']['�ɲ�����']['PARENT'] = array("../XinZhengGuanLi/MAIN_GANBUCEPING.php","��������");
if($�����׼�汾!=1)	$PRIVATE_SYSTEM['������Դ']['�ɲ�����']['������Ŀ����'] = array("../zhongcengpingce/edu_zhongcengceping_newai.php","������Ŀ����");
if($�����׼�汾!=1)	$PRIVATE_SYSTEM['������Դ']['�ɲ�����']['���²�������'] = array("../zhongcengpingce/edu_zhongcenggangweishezhi_newai.php","���²�������");
if($�����׼�汾!=1)	$PRIVATE_SYSTEM['������Դ']['�ɲ�����']['�����ҵ�����'] = array("../zhongcengpingce/edu_zhongcengmyziping_newai.php","�����ҵ�����");
if($�����׼�汾!=1)	$PRIVATE_SYSTEM['������Դ']['�ɲ�����']['����ɲ�����'] = array("../zhongcengpingce/edu_zhongcengcanyupingce_newai.php","����ɲ�����");
if($�����׼�汾!=1)	$PRIVATE_SYSTEM['������Դ']['�ɲ�����']['�鿴�ҵĲ���'] = array("../zhongcengpingce/edu_zhongcengviewceping_newai.php","�鿴�ҵĲ���");
if($�����׼�汾!=1)	$PRIVATE_SYSTEM['������Դ']['�ɲ�����']['�ɲ�����ͳ��'] = array("../zhongcengpingce/edu_zhongcengtognji_newai.php","�ɲ�����ͳ��");
if($�����׼�汾!=1)	$PRIVATE_SYSTEM['������Դ']['�ɲ�����']['����������ϸ'] = array("../zhongcengpingce/edu_zhongcengmingxi_newai.php","����������ϸ");
if($�����׼�汾!=1)	$PRIVATE_SYSTEM['������Դ']['�ɲ�����']['������Ŀ����'] = array("../zhongcengpingce/edu_zhongcengxingmu_newai.php","������Ŀ����");

if($�����׼�汾!=1)	$PRIVATE_SYSTEM['������Դ']['��Ƹ����']['PARENT'] = array("../XinZhengGuanLi/MAIN_ZHAOPIN.php","��Ƹ����");
if($�����׼�汾!=1)	$PRIVATE_SYSTEM['������Դ']['��Ƹ����']['��Ƹ�ƻ�'] = array("../XinZhengGuanLi/hrms_zpjihua_newai.php","��Ƹ�ƻ�");
if($�����׼�汾!=1)	$PRIVATE_SYSTEM['������Դ']['��Ƹ����']['��Ƹ�ƻ�����'] = array("../XinZhengGuanLi/hrms_zpjihua_shenpi_newai.php","��Ƹ�ƻ�����");
if($�����׼�汾!=1)	$PRIVATE_SYSTEM['������Դ']['��Ƹ����']['��Ƹ�˲ſ�'] = array("../XinZhengGuanLi/hrms_zprencaiku_newai.php","��Ƹ�˲ſ�");
if($�����׼�汾!=1)	$PRIVATE_SYSTEM['������Դ']['��Ƹ����']['��Ƹ¼��'] = array("../XinZhengGuanLi/hrms_file_luyong_newai.php","��Ƹ¼��");

if($�����׼�汾!=1)	$PRIVATE_SYSTEM['������Դ']['н�����']['PARENT'] = array("../XinZhengGuanLi/MAIN_XINCHOU.php","н�����");
if($�����׼�汾!=1)	$PRIVATE_SYSTEM['������Դ']['н�����']['�ҵĹ��ʸ���'] = array("../XinZhengGuanLi/hrms_salary_detail_newai.php","�ҵĹ��ʸ���");
if($�����׼�汾!=1)	$PRIVATE_SYSTEM['������Դ']['н�����']['���ʸ�������'] = array("../XinZhengGuanLi/hrms_salary_type.php","���ʸ�������");
if($�����׼�汾!=1)	$PRIVATE_SYSTEM['������Դ']['н�����']['н���������'] = array("../XinZhengGuanLi/hrms_salary_group_newai.php","н���������");
if($�����׼�汾!=1)	$PRIVATE_SYSTEM['������Դ']['н�����']['н������'] = array("../XinZhengGuanLi/hrms_salary_newai.php","н������");
if($�����׼�汾!=1)	$PRIVATE_SYSTEM['������Դ']['н�����']['н��ͳ��'] = array("../XinZhengGuanLi/hrms_salary_tongji_newai.php","н��ͳ��");

if($�����׼�汾!=1)	$PRIVATE_SYSTEM['������Դ']['�ճ�����']['PARENT'] = array("../XinZhengGuanLi/MAIN_FEIYONG.php","�ճ�����");
if($�����׼�汾!=1)	$PRIVATE_SYSTEM['������Դ']['�ճ�����']['������ϸ'] = array("../XinZhengGuanLi/hrms_expense_newai.php","������ϸ");
if($�����׼�汾!=1)	$PRIVATE_SYSTEM['������Դ']['�ճ�����']['��������'] = array("../XinZhengGuanLi/hrms_expense_type_newai.php","��������");

if($�����׼�汾!=1)	$PRIVATE_SYSTEM['������Դ']['�ڼ���ֵ��'] = array("../XinZhengGuanLi/edu_zhiban_newai.php","�ڼ���ֵ��");



$PRIVATE_SYSTEM['���ڹ���']['�칫��Ʒ']['PARENT']		= array("../officeproduct/MAIN_OFFICEPRODUCT.php","�칫��Ʒ");
$PRIVATE_SYSTEM['���ڹ���']['�칫��Ʒ']['�칫��Ʒ����'] = array("../officeproduct/officeproduct_view.php","�칫��Ʒ����");
$PRIVATE_SYSTEM['���ڹ���']['�칫��Ʒ']['�칫��Ʒ����'] = array("../officeproduct/officeproduct_newai.php","�칫��Ʒ����");
$PRIVATE_SYSTEM['���ڹ���']['�칫��Ʒ']['������ϸ']		= array("../officeproduct/officeproduct_admin.php","�칫��Ʒ������ϸ");
$PRIVATE_SYSTEM['���ڹ���']['�칫��Ʒ']['�ֿ�����']		= array("../officeproduct/officeproductcangku_newai.php","�칫��Ʒ�ֿ�����");
$PRIVATE_SYSTEM['���ڹ���']['�칫��Ʒ']['�ֿ�ͳ��']		= array("../officeproduct/officeproduct_tongji.php","�칫��Ʒ�ֿ�ͳ��");
$PRIVATE_SYSTEM['���ڹ���']['�칫��Ʒ']['����ͳ��']		= array("../officeproduct/officeproduct_fenxiang.php","�칫��Ʒ����ͳ��");
$PRIVATE_SYSTEM['���ڹ���']['�칫��Ʒ']['��������']		= array("../officeproduct/officeproductgroup_newai.php","�칫��Ʒ��������");

$PRIVATE_SYSTEM['���ڹ���']['�̶��ʲ�']['PARENT']		= array("MAIN_FIXEDASSET.php","�̶��ʲ�");
$PRIVATE_SYSTEM['���ڹ���']['�̶��ʲ�']['ȫȨ�޹���']	= array("fixedasset_newai.php","�̶��ʲ�ȫȨ�޹���");
$PRIVATE_SYSTEM['���ڹ���']['�̶��ʲ�']['�ʲ�����Ա'] = array("fixedasset_admin_newai.php","�̶��ʲ�����Ա");
$PRIVATE_SYSTEM['���ڹ���']['�̶��ʲ�']['���ż�����']	= array("fixedasset_department_newai.php","�̶��ʲ����ż�����");
$PRIVATE_SYSTEM['���ڹ���']['�̶��ʲ�']['������ϸ']		= array("admin_fixedasset.php","�̶��ʲ�������ϸ");
$PRIVATE_SYSTEM['���ڹ���']['�̶��ʲ�']['��������ͳ��'] = array("fixedasset_tongjijianjie.php","�̶��ʲ���������ͳ��");
$PRIVATE_SYSTEM['���ڹ���']['�̶��ʲ�']['������ϸͳ��'] = array("fixedasset_tongji.php","�̶��ʲ�������ϸͳ��");
$PRIVATE_SYSTEM['���ڹ���']['�̶��ʲ�']['������ͳ��']	= array("fixedasset_pici.php","�̶��ʲ�������ͳ��");
$PRIVATE_SYSTEM['���ڹ���']['�̶��ʲ�']['�������ʲ�']	= array("fixedasset_baofei.php","�̶��ʲ��������ʲ�");
$PRIVATE_SYSTEM['���ڹ���']['�̶��ʲ�']['��������']		= array("fixedassetgroup_newai.php","�̶��ʲ���������");
$PRIVATE_SYSTEM['���ڹ���']['�̶��ʲ�']['����Ȩ�޹���'] = array("inc_fixedasset_priv.php","�̶��ʲ�����Ȩ�޹���");

$PRIVATE_SYSTEM['���ڹ���']['����ά��']['PARENT']	= array("../WuYeGuanLi/MAIN_WYGL.php","����ά��");
$PRIVATE_SYSTEM['���ڹ���']['����ά��']['������Ϣ'] = array("../WuYeGuanLi/wygl_baoxiuxinxi1_newai.php","������Ϣ");
$PRIVATE_SYSTEM['���ڹ���']['����ά��']['��������'] = array("../WuYeGuanLi/wygl_baoxiuxinxi2_newai.php","��������");
$PRIVATE_SYSTEM['���ڹ���']['����ά��']['ȷ��ά��'] = array("../WuYeGuanLi/wygl_baoxiuxinxi3_newai.php","ȷ��ά��");
$PRIVATE_SYSTEM['���ڹ���']['����ά��']['���ϵǼ�'] = array("../WuYeGuanLi/wygl_baoxiuxinxi4_newai.php","���ϵǼ�");
$PRIVATE_SYSTEM['���ڹ���']['����ά��']['���ý���'] = array("../WuYeGuanLi/wygl_baoxiuxinxi5_newai.php","���ý���");
$PRIVATE_SYSTEM['���ڹ���']['����ά��']['��������'] = array("../WuYeGuanLi/wygl_weixiupingjia_newai.php","��������");
$PRIVATE_SYSTEM['���ڹ���']['����ά��']['��������'] = array("../WuYeGuanLi/MAIN_SETTING.php","��������");
$PRIVATE_SYSTEM['���ڹ���']['����ά��']['¥������'] = array("../WuYeGuanLi/MAIN_BUILDING.php","¥������");


//�������
/*�¼ӵ�*/
if($�����׼�汾!=1)	$PRIVATE_SYSTEM['��ѧ������ϵ']['������ѧԺ']['PARENT'] = array("MENU_zhuanjia_xueyuan.php","������ѧԺ");
if($�����׼�汾!=1)	$PRIVATE_SYSTEM['��ѧ������ϵ']['������ѧԺ']['�������۶���ѧԺ'] = array("../CEPING/zhuanjia_xueyuan.php","�������۶���ѧԺ");
if($�����׼�汾!=1)	$PRIVATE_SYSTEM['��ѧ������ϵ']['������ѧԺ']['�½���������'] = array("../CEPING/ceping_zhuanjia_xueyuan_mingcheng_newai.php","�½���������");
if($�����׼�汾!=1)	$PRIVATE_SYSTEM['��ѧ������ϵ']['������ѧԺ']['����ṹ���'] = array("../CEPING/ceping_zhuanjia_xueyuan_jiegou_newai.php","����ṹ���");
if($�����׼�汾!=1)	$PRIVATE_SYSTEM['��ѧ������ϵ']['������ѧԺ']['����ͳ�Ʋ�ѯ'] = array("../CEPING/dudao_xueyuan_zong_serch.php","����ͳ�Ʋ�ѯ");
if($�����׼�汾!=1)	$PRIVATE_SYSTEM['��ѧ������ϵ']['������ѧԺ']['�ṹ��ϸ��ѯ'] = array("../CEPING/dudao_xueyuan_jiegou_serch.php","�ṹ��ϸ��ѯ");
if($�����׼�汾!=1)	$PRIVATE_SYSTEM['��ѧ������ϵ']['������ѧԺ']['δ������Ա��ѯ'] = array("../CEPING/dudao_xueyuan_no_serch.php","δ������Ա��ѯ");
//if($�����׼�汾!=1)	$PRIVATE_SYSTEM['��ѧ������ϵ']['������ѧԺ']['δ����ѧ����ѯ'] = array("../CEPING/search_mingxi_xuesheng.php","δ����ѧ����ѯ");



if($�����׼�汾!=1)	$PRIVATE_SYSTEM['��ѧ������ϵ']['������������']['PARENT'] = array("MENU_zhuanjia_jiaoyanshi.php","������������");
if($�����׼�汾!=1)	$PRIVATE_SYSTEM['��ѧ������ϵ']['������������']['�������۽�����'] = array("../CEPING/zhuanjia_jiaoyanshi.php","�������۽�����");
if($�����׼�汾!=1)	$PRIVATE_SYSTEM['��ѧ������ϵ']['������������']['�½���������'] = array("../CEPING/ceping_zhuanjia_jiaoyanshi_mingcheng_newai.php","�½���������");
if($�����׼�汾!=1)	$PRIVATE_SYSTEM['��ѧ������ϵ']['������������']['����ṹ���'] = array("../CEPING/ceping_zhuanjia_jiaoyanshi_jiegou_newai.php","����ṹ���");
if($�����׼�汾!=1)	$PRIVATE_SYSTEM['��ѧ������ϵ']['������������']['����ͳ�Ʋ�ѯ'] = array("../CEPING/dudao_jiaoyanshi_zong_serch.php","����ͳ�Ʋ�ѯ");
if($�����׼�汾!=1)	$PRIVATE_SYSTEM['��ѧ������ϵ']['������������']['�ṹ��ϸ��ѯ'] = array("../CEPING/dudao_jiaoyanshi_jiegou_serch.php","�ṹ��ϸ��ѯ");
if($�����׼�汾!=1)	$PRIVATE_SYSTEM['��ѧ������ϵ']['������������']['δ������Ա��ѯ'] = array("../CEPING/dudao_jiaoyanshi_no_serch.php","δ������Ա��ѯ");


if($�����׼�汾!=1)	$PRIVATE_SYSTEM['��ѧ������ϵ']['��������ʦ']['PARENT'] = array("MENU_zhuanjia_jiaoshi.php","��������ʦ");
if($�����׼�汾!=1)	$PRIVATE_SYSTEM['��ѧ������ϵ']['��������ʦ']['�������۽�ʦ'] = array("../CEPING/zhuanjia_jiaoshi.php","�������۽�ʦ");
if($�����׼�汾!=1)	$PRIVATE_SYSTEM['��ѧ������ϵ']['��������ʦ']['�½���������'] = array("../CEPING/ceping_zhuanjia_jiaoshi_mingcheng_newai.php","�½���������");
if($�����׼�汾!=1)	$PRIVATE_SYSTEM['��ѧ������ϵ']['��������ʦ']['����ṹ���'] = array("../CEPING/ceping_zhuanjia_jiaoshi_jiegou_newai.php","����ṹ���");
if($�����׼�汾!=1)	$PRIVATE_SYSTEM['��ѧ������ϵ']['��������ʦ']['����ͳ�Ʋ�ѯ'] = array("../CEPING/dudao_jiaoshi_zong_serch.php","����ͳ�Ʋ�ѯ");
if($�����׼�汾!=1)	$PRIVATE_SYSTEM['��ѧ������ϵ']['��������ʦ']['�ṹ��ϸ��ѯ'] = array("../CEPING/dudao_jiaoshi_jiegou_serch.php","�ṹ��ϸ��ѯ");
if($�����׼�汾!=1)	$PRIVATE_SYSTEM['��ѧ������ϵ']['��������ʦ']['δ������Ա��ѯ'] = array("../CEPING/dudao_jiaoshi_no_serch.php","δ������Ա��ѯ");


if($�����׼�汾!=1)	$PRIVATE_SYSTEM['��ѧ������ϵ']['�쵼��ѧԺ']['PARENT'] = array("MENU_lingdao_xueyuan.php","�쵼��ѧԺ");
if($�����׼�汾!=1)	$PRIVATE_SYSTEM['��ѧ������ϵ']['�쵼��ѧԺ']['�쵼���۶���ѧԺ'] = array("../CEPING/lingdao_erjixueyuan.php","�쵼���۶���ѧԺ");
if($�����׼�汾!=1)	$PRIVATE_SYSTEM['��ѧ������ϵ']['�쵼��ѧԺ']['�½���������'] = array("../CEPING/ceping_lingdao_xueyuan_mingcheng_newai.php","�½���������");
if($�����׼�汾!=1)	$PRIVATE_SYSTEM['��ѧ������ϵ']['�쵼��ѧԺ']['����ṹ���'] = array("../CEPING/ceping_lingdao_xueyuan_jiegou_newai.php","����ṹ���");
if($�����׼�汾!=1)	$PRIVATE_SYSTEM['��ѧ������ϵ']['�쵼��ѧԺ']['����ͳ�Ʋ�ѯ'] = array("../CEPING/lingdao_xueyuan_zong_serch.php","����ͳ�Ʋ�ѯ");
if($�����׼�汾!=1)	$PRIVATE_SYSTEM['��ѧ������ϵ']['�쵼��ѧԺ']['�ṹ��ϸ��ѯ'] = array("../CEPING/lingdao_xueyuan_jiegou_serch.php","�ṹ��ϸ��ѯ");
if($�����׼�汾!=1)	$PRIVATE_SYSTEM['��ѧ������ϵ']['�쵼��ѧԺ']['δ������Ա��ѯ'] = array("../CEPING/lingdao_xueyuan_no_serch.php","δ������Ա��ѯ");


if($�����׼�汾!=1)	$PRIVATE_SYSTEM['��ѧ������ϵ']['�쵼��������']['PARENT'] = array("MENU_lingdao_jiaoyanshi.php","�쵼��������");
if($�����׼�汾!=1)	$PRIVATE_SYSTEM['��ѧ������ϵ']['�쵼��������']['�쵼���۽�����'] = array("../CEPING/lingdao_jiaoyanshi.php","�쵼���۽�����");
if($�����׼�汾!=1)	$PRIVATE_SYSTEM['��ѧ������ϵ']['�쵼��������']['�½���������'] = array("../CEPING/ceping_lingdao_jiaoyanshi_mingcheng_newai.php","�½���������");
if($�����׼�汾!=1)	$PRIVATE_SYSTEM['��ѧ������ϵ']['�쵼��������']['����ṹ���'] = array("../CEPING/ceping_lingdao_jiaoyanshi_jiegou_newai.php","����ṹ���");
if($�����׼�汾!=1)	$PRIVATE_SYSTEM['��ѧ������ϵ']['�쵼��������']['����ͳ�Ʋ�ѯ'] = array("../CEPING/lingdao_jiaoyanshi_zong_serch.php","����ͳ�Ʋ�ѯ");
if($�����׼�汾!=1)	$PRIVATE_SYSTEM['��ѧ������ϵ']['�쵼��������']['�ṹ��ϸ��ѯ'] = array("../CEPING/lingdao_jiaoyanshi_jiegou_serch.php","�ṹ��ϸ��ѯ");
if($�����׼�汾!=1)	$PRIVATE_SYSTEM['��ѧ������ϵ']['�쵼��������']['δ������Ա��ѯ'] = array("../CEPING/lingdao_jiaoyanshi_no_serch.php","δ������Ա��ѯ");



if($�����׼�汾!=1)	$PRIVATE_SYSTEM['��ѧ������ϵ']['�쵼����ʦ']['PARENT'] = array("MENU_lingdao_jiaoshi.php","�쵼����ʦ");
if($�����׼�汾!=1)	$PRIVATE_SYSTEM['��ѧ������ϵ']['�쵼����ʦ']['�쵼���۽�ʦ'] = array("../CEPING/lingdao_jiaoshi.php","�쵼���۽�ʦ");
if($�����׼�汾!=1)	$PRIVATE_SYSTEM['��ѧ������ϵ']['�쵼����ʦ']['�½���������'] = array("../CEPING/ceping_lingdao_jiaoshi_mingcheng_newai.php","�½���������");
if($�����׼�汾!=1)	$PRIVATE_SYSTEM['��ѧ������ϵ']['�쵼����ʦ']['����ṹ���'] = array("../CEPING/ceping_lingdao_jiaoshi_jiegou_newai.php","����ṹ���");
if($�����׼�汾!=1)	$PRIVATE_SYSTEM['��ѧ������ϵ']['�쵼����ʦ']['����ͳ�Ʋ�ѯ'] = array("../CEPING/lingdao_jiaoshi_zong_serch.php","����ͳ�Ʋ�ѯ");
if($�����׼�汾!=1)	$PRIVATE_SYSTEM['��ѧ������ϵ']['�쵼����ʦ']['�ṹ��ϸ��ѯ'] = array("../CEPING/lingdao_jiaoshi_jiegou_serch.php","�ṹ��ϸ��ѯ");
if($�����׼�汾!=1)	$PRIVATE_SYSTEM['��ѧ������ϵ']['�쵼����ʦ']['δ������Ա��ѯ'] = array("../CEPING/lingdao_jiaoshi_no_serch.php","δ������Ա��ѯ");



if($�����׼�汾!=1)	$PRIVATE_SYSTEM['��ѧ������ϵ']['��ʦ��ͬ��']['PARENT'] = array("MENU_jiaoshi_tonghang.php","��ʦ��ͬ��");
if($�����׼�汾!=1)	$PRIVATE_SYSTEM['��ѧ������ϵ']['��ʦ��ͬ��']['��ʦ����ͬ��'] = array("../CEPING/jiaoshi_tonghang.php","��ʦ����ͬ��");
if($�����׼�汾!=1)	$PRIVATE_SYSTEM['��ѧ������ϵ']['��ʦ��ͬ��']['�½���������'] = array("../CEPING/ceping_jiaoshi_tonghang_mingcheng_newai.php","�½���������");
if($�����׼�汾!=1)	$PRIVATE_SYSTEM['��ѧ������ϵ']['��ʦ��ͬ��']['����ṹ���'] = array("../CEPING/ceping_jiaoshi_tonghang_jiegou_newai.php","����ṹ���");
if($�����׼�汾!=1)	$PRIVATE_SYSTEM['��ѧ������ϵ']['��ʦ��ͬ��']['����ͳ�Ʋ�ѯ'] = array("../CEPING/jiaoshi_tonghang_zong_serch.php","����ͳ�Ʋ�ѯ");
if($�����׼�汾!=1)	$PRIVATE_SYSTEM['��ѧ������ϵ']['��ʦ��ͬ��']['�ṹ��ϸ��ѯ'] = array("../CEPING/jiaoshi_tonghang_jiegou_serch.php","�ṹ��ϸ��ѯ");
if($�����׼�汾!=1)	$PRIVATE_SYSTEM['��ѧ������ϵ']['��ʦ��ͬ��']['δ������Ա��ѯ'] = array("../CEPING/jiaoshi_tonghang_no_serch.php","δ������Ա��ѯ");


if($�����׼�汾!=1)	$PRIVATE_SYSTEM['��ѧ������ϵ']['��ʦ����']['PARENT']        = array("MENU_jiaoshi_ziping.php","��ʦ����");
if($�����׼�汾!=1)	$PRIVATE_SYSTEM['��ѧ������ϵ']['��ʦ����']['��ʦ����']      = array("../CEPING/jiaoshi_jiaoshi.php","��ʦ����");
if($�����׼�汾!=1)	$PRIVATE_SYSTEM['��ѧ������ϵ']['��ʦ����']['�½���������']  = array("../CEPING/ceping_jiaoshi_ziping_mingcheng_newai.php","�½���������");
if($�����׼�汾!=1)	$PRIVATE_SYSTEM['��ѧ������ϵ']['��ʦ����']['����ṹ���']  = array("../CEPING/ceping_jiaoshi_ziping_jiegou_newai.php","����ṹ���");
if($�����׼�汾!=1)	$PRIVATE_SYSTEM['��ѧ������ϵ']['��ʦ����']['����ͳ�Ʋ�ѯ']  = array("../CEPING/jiaoshi_ziping_zong_serch.php","����ͳ�Ʋ�ѯ");
if($�����׼�汾!=1)	$PRIVATE_SYSTEM['��ѧ������ϵ']['��ʦ����']['�ṹ��ϸ��ѯ'] = array("../CEPING/jiaoshi_ziping_jiegou_serch.php","�ṹ��ϸ��ѯ");
//if($�����׼�汾!=1)	$PRIVATE_SYSTEM['��ѧ������ϵ']['��ʦ����']['δ������Ա��ѯ']   = array("../CEPING/jiaoshi_ziping_no_serch.php","δ������Ա��ѯ");


if($�����׼�汾!=1)	$PRIVATE_SYSTEM['��ѧ������ϵ']['��ʦ���༶']['PARENT']  = array("MENU_jiaoshi_banji.php","��ʦ���༶");
if($�����׼�汾!=1)	$PRIVATE_SYSTEM['��ѧ������ϵ']['��ʦ���༶']['��ʦ���۰༶']  = array("../CEPING/jiaoshi_banji.php","��ʦ���۰༶");
if($�����׼�汾!=1)	$PRIVATE_SYSTEM['��ѧ������ϵ']['��ʦ���༶']['�½���������'] = array("../CEPING/ceping_jiaoshi_banji_mingcheng_newai.php","�½���������");
if($�����׼�汾!=1)	$PRIVATE_SYSTEM['��ѧ������ϵ']['��ʦ���༶']['����ṹ���'] = array("../CEPING/ceping_jiaoshi_banji_jiegou_newai.php","����ṹ���");
if($�����׼�汾!=1)	$PRIVATE_SYSTEM['��ѧ������ϵ']['��ʦ���༶']['����ͳ�Ʋ�ѯ'] = array("../CEPING/jiaoshi_banji_zong_serch.php","����ͳ�Ʋ�ѯ");
if($�����׼�汾!=1)	$PRIVATE_SYSTEM['��ѧ������ϵ']['��ʦ���༶']['�ṹ��ϸ��ѯ'] = array("../CEPING/jiaoshi_banji_jiegou_serch.php","�ṹ��ϸ��ѯ");
if($�����׼�汾!=1)	$PRIVATE_SYSTEM['��ѧ������ϵ']['��ʦ���༶']['δ������Ա��ѯ']   = array("../CEPING/jiaoshi_banji_no_serch.php","δ������Ա��ѯ");


if($�����׼�汾!=1)	$PRIVATE_SYSTEM['��ѧ������ϵ']['ѧ������ʦ']['PARENT']  = array("MENU_xuesheng_jiaoshi.php","ѧ������ʦ");
if($�����׼�汾!=1)	$PRIVATE_SYSTEM['��ѧ������ϵ']['ѧ������ʦ']['�½���������'] = array("../CEPING/ceping_xuesheng_jiaoshi_mingcheng_newai.php","�½���������");
if($�����׼�汾!=1)	$PRIVATE_SYSTEM['��ѧ������ϵ']['ѧ������ʦ']['����ṹ���'] = array("../CEPING/ceping_xuesheng_jiaoshi_jiegou_newai.php","����ṹ���");
if($�����׼�汾!=1)	$PRIVATE_SYSTEM['��ѧ������ϵ']['ѧ������ʦ']['����ͳ�Ʋ�ѯ'] = array("../CEPING/xuesheng_jiaoshi_zong_serch.php","����ͳ�Ʋ�ѯ");
if($�����׼�汾!=1)	$PRIVATE_SYSTEM['��ѧ������ϵ']['ѧ������ʦ']['�ṹ��ϸ��ѯ'] = array("../CEPING/xuesheng_jiaoshi_jiegou_serch.php","�ṹ��ϸ��ѯ");
if($�����׼�汾!=1)	$PRIVATE_SYSTEM['��ѧ������ϵ']['ѧ������ʦ']['δ������Ա��ѯ']   = array("../CEPING/xuesheng_jiaoshi_no_serch.php","δ������Ա��ѯ");


if($�����׼�汾!=1)	$PRIVATE_SYSTEM['��ѧ������ϵ']['��ʼ����']['PARENT']			= array("MAIN_CEPING_PINGJIA.php","��ʦ���༶");
if($�����׼�汾!=1)	$PRIVATE_SYSTEM['��ѧ������ϵ']['��ʼ����']['�������۶���ѧԺ'] = array("../CEPING/zhuanjia_xueyuan.php","�������۶���ѧԺ");
if($�����׼�汾!=1)	$PRIVATE_SYSTEM['��ѧ������ϵ']['��ʼ����']['�������۽�����']	= array("../CEPING/zhuanjia_jiaoyanshi.php","�������۽�����");
if($�����׼�汾!=1)	$PRIVATE_SYSTEM['��ѧ������ϵ']['��ʼ����']['�������۽�ʦ']		= array("../CEPING/zhuanjia_jiaoshi.php","�������۽�ʦ");
if($�����׼�汾!=1)	$PRIVATE_SYSTEM['��ѧ������ϵ']['��ʼ����']['�쵼���۶���ѧԺ'] = array("../CEPING/lingdao_erjixueyuan.php","�쵼���۶���ѧԺ");
if($�����׼�汾!=1)	$PRIVATE_SYSTEM['��ѧ������ϵ']['��ʼ����']['�쵼���۽�����']	= array("../CEPING/lingdao_jiaoyanshi.php","�쵼���۽�����");
if($�����׼�汾!=1)	$PRIVATE_SYSTEM['��ѧ������ϵ']['��ʼ����']['�쵼���۽�ʦ']		= array("../CEPING/lingdao_jiaoshi.php","�쵼���۽�ʦ");
if($�����׼�汾!=1)	$PRIVATE_SYSTEM['��ѧ������ϵ']['��ʼ����']['��ʦ����ͬ��']		= array("../CEPING/jiaoshi_tonghang.php","��ʦ����ͬ��");
if($�����׼�汾!=1)	$PRIVATE_SYSTEM['��ѧ������ϵ']['��ʼ����']['��ʦ����']			= array("../CEPING/jiaoshi_jiaoshi.php","��ʦ����");
if($�����׼�汾!=1)	$PRIVATE_SYSTEM['��ѧ������ϵ']['��ʼ����']['��ʦ���۰༶']		= array("../CEPING/jiaoshi_banji.php","��ʦ���۰༶");
if($�����׼�汾!=1)	$PRIVATE_SYSTEM['��ѧ������ϵ']['��ʼ����']['������ͳ��']		= array("../Teacher/edu_PingceAllInfor.php","������ͳ��");



if($�����׼�汾!=1)	$PRIVATE_SYSTEM['��ѧ������ϵ']['�����趨']['PARENT'] = array("NewPINGCE_SHEZHI.php","�����趨");
if($�����׼�汾!=1)	$PRIVATE_SYSTEM['��ѧ������ϵ']['�����趨']['�������'] = array("../CEPING/ceping_renyuan_grop_newai.php","�������");
if($�����׼�汾!=1)	$PRIVATE_SYSTEM['��ѧ������ϵ']['�����趨']['����ṹ'] = array("../CEPING/ceping_jiegou_newai.php","����ṹ");
if($�����׼�汾!=1)	$PRIVATE_SYSTEM['��ѧ������ϵ']['�����趨']['��������'] = array("../CEPING/ceping_zhonglei_newai.php","��������");
if($�����׼�汾!=1)	$PRIVATE_SYSTEM['��ѧ������ϵ']['�����趨']['��������'] = array("../CEPING/ceping_mingcheng_newai.php","��������");
if($�����׼�汾!=1)	$PRIVATE_SYSTEM['��ѧ������ϵ']['�����趨']['���������趨'] = array("../CEPING/ceping_fenshu_newai.php","���������趨");
//if($�����׼�汾!=1)	$PRIVATE_SYSTEM['��ѧ������ϵ']['�����趨']['���۶���'] = array("../CEPING/ceping_pingjiaduixiang_newai.php","���۶���");
//if($�����׼�汾!=1)	$PRIVATE_SYSTEM['��ѧ������ϵ']['�����趨']['���۲�ѯ'] = array("../CEPING/search.php","���۲�ѯ");


//���߱�������
$PRIVATE_SYSTEM['���߱�������']['���߱���']['PARENT']			= array("../ZAIXIANKAOSHI/MAIN_ZAIXIANBAOMING.php","���߱���");
$PRIVATE_SYSTEM['���߱�������']['���߱���']['���߱������͹���'] = array("../ZAIXIANKAOSHI/edu_baomingtype_newai.php","���߱������͹���");
$PRIVATE_SYSTEM['���߱�������']['���߱���']['���߱�����Ŀ����'] = array("../ZAIXIANKAOSHI/edu_baomingname_newai.php","���߱�����Ŀ����");
$PRIVATE_SYSTEM['���߱�������']['���߱���']['ѧ��������ϸ��¼'] = array("../ZAIXIANKAOSHI/edu_baomingdetail_newai.php","ѧ��������ϸ��¼");
$PRIVATE_SYSTEM['���߱�������']['���߱���']['���߱���ͳ�ƹ���'] = array("../ZAIXIANKAOSHI/edu_baomingdetail_static.php","���߱���ͳ�ƹ���");

$PRIVATE_SYSTEM['���߱�������']['�����']['PARENT']	= array("../ZAIXIANKAOSHI/MAIN_TIKUJUANKU.php","�����");
$PRIVATE_SYSTEM['���߱�������']['�����']['�����γ���Ϣ']	= array("../ZAIXIANKAOSHI/tiku_kecheng_newai.php","�����γ���Ϣ");
$PRIVATE_SYSTEM['���߱�������']['�����']['������Ϣ����'] = array("../ZAIXIANKAOSHI/tiku_shiti_newai.php","������Ϣ����");
$PRIVATE_SYSTEM['���߱�������']['�����']['�Ծ���Ϣ����'] = array("../ZAIXIANKAOSHI/tiku_shijuan_newai.php","�Ծ���Ϣ����");
$PRIVATE_SYSTEM['���߱�������']['�����']['�Ծ�������'] = array("../ZAIXIANKAOSHI/tiku_shiti_makeexec.php","�Ծ�������");
$PRIVATE_SYSTEM['���߱�������']['�����']['�Ծ�����ϸ'] = array("../ZAIXIANKAOSHI/tiku_shijuanku_newai.php","�Ծ�����ϸ");
$PRIVATE_SYSTEM['���߱�������']['�����']['������Ϣ����'] = array("../ZAIXIANKAOSHI/tiku_kaoshi_newai.php","������Ϣ����");
$PRIVATE_SYSTEM['���߱�������']['�����']['�������׳̶�'] = array("../ZAIXIANKAOSHI/tiku_shitinanyi_newai.php","�������׳̶�");
$PRIVATE_SYSTEM['���߱�������']['�����']['������Ŀ����'] = array("../ZAIXIANKAOSHI/tiku_shititype_newai.php","������Ŀ����");

$PRIVATE_SYSTEM['���߱�������']['���߿���']['PARENT']	= array("../ZAIXIANKAOSHI/MAIN_KAOSHI.php","���߿���");
$PRIVATE_SYSTEM['���߱�������']['���߿���']['������Ϣ����']	= array("../ZAIXIANKAOSHI/tiku_kaoshi_newai.php","������Ϣ����");
$PRIVATE_SYSTEM['���߱�������']['���߿���']['ѧ��������ϸ'] = array("../ZAIXIANKAOSHI/tiku_examdata_newai.php","ѧ��������ϸ");
$PRIVATE_SYSTEM['���߱�������']['���߿���']['ѧ�����Գɼ�'] = array("../ZAIXIANKAOSHI/tiku_examdata_static.php","ѧ�����Գɼ�");

//��ʮ���˵�����
$PRIVATE_SYSTEM['�����շѹ���']['ѧ���շ�'] = array("ShouFei.php","ѧ���շ�");
$PRIVATE_SYSTEM['�����շѹ���']['�շѱ�׼����'] = array("edu_zhuanyeshoufei.php","�շѱ�׼����");
$PRIVATE_SYSTEM['�����շѹ���']['�վݴ�ӡ'] = array("edu_shoufeidanprint_newai.php","�վݴ�ӡ");
$PRIVATE_SYSTEM['�����շѹ���']['�վ�ɾ��'] = array("edu_shoufeidanprintdelete_newai.php","�վݴ�ӡ");
//$PRIVATE_SYSTEM['�����շѹ���']['���˷���ϸ'] = array("edu_caiwuxianjin.php","���˷���ϸ");
//$PRIVATE_SYSTEM['�����շѹ���']['�˻��ռ���'] = array("StudentFeeCashFlow.php","�˻��ռ���");
//$PRIVATE_SYSTEM['�����շѹ���']['����֧����ϸ'] = array("edu_qitazhichu_newai.php","����֧����ϸ");
//$PRIVATE_SYSTEM['�����շѹ���']['����������ϸ'] = array("edu_qitashouru_newai.php","����������ϸ");
//$PRIVATE_SYSTEM['�����շѹ���']['����֧������'] = array("dict_zhichuleibie_newai.php","����֧������");
//$PRIVATE_SYSTEM['�����շѹ���']['������������'] = array("dict_shouruleibie_newai.php","������������");

$PRIVATE_SYSTEM['�����շѹ���']['������ϸ'] = array("Caiwu.php","������ϸ");
$PRIVATE_SYSTEM['�����շѹ���']['Ƿ��ͳ��'] = array("StudentFeehistory_Main.php","Ƿ��ͳ��");
$PRIVATE_SYSTEM['�����շѹ���']['�շ��趨'] = array("edu_caiwusetting.php","�շ��趨");
$PRIVATE_SYSTEM['�����շѹ���']['����ѧ���շѱ�׼'] = array("edu_student_shoufeibiaozhun.php","����ѧ���շѱ�׼");
//$PRIVATE_SYSTEM['�����շѹ���']['��Ʊ����'] = array("edu_fapiao.php","��Ʊ����");



//��ʮ���˵�����
$PRIVATE_SYSTEM['�ۺ���Ϣ��ѯ']['ѧ����Ϣ��ѯ'] = array("../InforSearch/StudentInfor.php","ѧ����Ϣ��ѯ");
$PRIVATE_SYSTEM['�ۺ���Ϣ��ѯ']['�༶��Ϣ��ѯ'] = array("../InforSearch/BanJiInfor.php","�༶��Ϣ��ѯ");
$PRIVATE_SYSTEM['�ۺ���Ϣ��ѯ']['��ʦ��Ϣ��ѯ'] = array("../InforSearch/TeacherInfor.php","��ʦ��Ϣ��ѯ");
$PRIVATE_SYSTEM['�ۺ���Ϣ��ѯ']['ѧУ������Ϣ'] = array("../EDU/InforSchool.php","ѧУ������Ϣ��ѯ");
$PRIVATE_SYSTEM['�ۺ���Ϣ��ѯ']['�༶ѧ��ͳ��'] = array("../EDU/InforSchool1.php","�༶ѧ��ͳ�Ʋ�ѯ");

$PRIVATE_SYSTEM['�ۺ���Ϣ��ѯ']['���ڹ����ѯ']['PARENT']	= array("../InforSearch/MAIN_HOUQIN.php","���ڹ���");
$PRIVATE_SYSTEM['�ۺ���Ϣ��ѯ']['���ڹ����ѯ']['�칫��Ʒ'] = array("../InforSearch/my_officeproduct.php","�칫��Ʒ");
$PRIVATE_SYSTEM['�ۺ���Ϣ��ѯ']['���ڹ����ѯ']['�̶��ʲ�'] = array("../InforSearch/my_fixedasset.php","�̶��ʲ�");
$PRIVATE_SYSTEM['�ۺ���Ϣ��ѯ']['���ڹ����ѯ']['��ҵ����'] = array("../InforSearch/my_wuyeguanli.php","��ҵ����");


//���߲˵�����
if($_SESSION['SYSTEM_IS_TD_OA']=="0")									{
	$PRIVATE_SYSTEM['���ֻ�У԰ϵͳ����']['��֯��������'] = array("../Framework/MAIN_UNIT.php","��֯��������");
}
$PRIVATE_SYSTEM['���ֻ�У԰ϵͳ����']['���ݿ����']		= array("database_setting.php","���ݿ����");
$PRIVATE_SYSTEM['���ֻ�У԰ϵͳ����']['���ֻ�У԰Ȩ��'] = array("systemprivateview.php","Ȩ��");
$PRIVATE_SYSTEM['���ֻ�У԰ϵͳ����']['ѧ���˵�Ȩ��']	= array("student_systemprivateview.php","ѧ���˵�Ȩ��");
$PRIVATE_SYSTEM['���ֻ�У԰ϵͳ����']['���ֻ�У԰��Ȩ'] = array("../../Framework/system_infor.php","��Ȩ��Ϣ");
$PRIVATE_SYSTEM['���ֻ�У԰ϵͳ����']['��������ϵͳ']	= array("../../databackup/update.php","���ֻ�У԰��������");
//$PRIVATE_SYSTEM['���ֻ�У԰ϵͳ����']['����'] = array("../../Framework/systemlang_newai.php","��������");
$PRIVATE_SYSTEM['���ֻ�У԰ϵͳ����']['ʱЧ��ģ��'] = array("edu_banzhuren_manager.php","ʱЧ��ģ������");
$PRIVATE_SYSTEM['���ֻ�У԰ϵͳ����']['�����ֵ�']	= array("StudentFileSetting.php","�����ֵ�����");
$PRIVATE_SYSTEM['���ֻ�У԰ϵͳ����']['�����¼']	= array("other_system_config_newai.php","�����¼");
$PRIVATE_SYSTEM['���ֻ�У԰ϵͳ����']['��Ϣ����']	= array("../DICT/crm_clendar.php","��Ϣ����");



//������Ȩ����Ϣ�й��˳�ʵ�ʵ�Ȩ��,���ڲ˵���������
function SystemPrivateInc($TARGET_ARRAY,$TARGET_TITLE)	{

global $db,$_SESSION;		//USER_PRIV_OTHER
$LOGIN_USER_PRIV_OTHER	= $_SESSION['LOGIN_USER_PRIV_OTHER'];
$SUNSHINE_USER_PRIV		= $_SESSION['LOGIN_USER_PRIV'];

$SUNSHINE_USER_PRIV_STR_ARRAY = explode(',',$SUNSHINE_USER_PRIV.",".$LOGIN_USER_PRIV_OTHER);
$SUNSHINE_USER_PRIV_STR_ARRAY = array_values($SUNSHINE_USER_PRIV_STR_ARRAY);
for($i=0;$i<sizeof($SUNSHINE_USER_PRIV_STR_ARRAY);$i++)		{

	$SUNSHINE_USER_PRIV_TEXT_TEMP		= returntablefield("user_priv","USER_PRIV",TRIM($SUNSHINE_USER_PRIV_STR_ARRAY[$i]),"PRIV_NAME");
	$SUNSHINE_USER_PRIV_TEXT_ARRAY[]	= returntablefield("systemprivate","ID",TRIM($SUNSHINE_USER_PRIV_STR_ARRAY[$i]),"CONTENT");
	//print "<font color=red>".$SUNSHINE_USER_PRIV_TEXT_TEMP.TRIM($SUNSHINE_USER_PRIV_STR_ARRAY[$i])."</font>||";
}
//print_R($SUNSHINE_USER_PRIV_STR_ARRAY);exit;
//print_R($SUNSHINE_USER_PRIV_TEXT_ARRAY);exit;
$SUNSHINE_USER_PRIV_TEXT_ARRAY_TEXT = join(',',$SUNSHINE_USER_PRIV_TEXT_ARRAY);
$SUNSHINE_USER_PRIV_TEXT_ARRAY = explode(',',$SUNSHINE_USER_PRIV_TEXT_ARRAY_TEXT);
$SUNSHINE_USER_PRIV_TEXT_ARRAY = @array_flip($SUNSHINE_USER_PRIV_TEXT_ARRAY);
$SUNSHINE_USER_PRIV_TEXT_ARRAY = @array_flip($SUNSHINE_USER_PRIV_TEXT_ARRAY);
$SUNSHINE_USER_PRIV_TEXT_ARRAY = @array_values($SUNSHINE_USER_PRIV_TEXT_ARRAY);

$MENU_TOP_ARRAY = @array_keys($TARGET_ARRAY);

//print_R($SUNSHINE_USER_PRIV_TEXT_ARRAY);

for($ii=0;$ii<count($MENU_TOP_ARRAY);$ii++)			{
	$MENU_TOP_NAME = $MENU_TOP_ARRAY[$ii];
	$MENU_TOP_NAME_ARRAY = $TARGET_ARRAY[$MENU_TOP_NAME];
	//print_R($MENU_TOP_NAME_ARRAY);
	if(count($MENU_TOP_NAME_ARRAY)==2)	{
		$MENU_TOP_NAME_TEXT = $MENU_TOP_NAME_ARRAY[1];
		$MENU_TOP_NAME_URL = $MENU_TOP_NAME_ARRAY[0];
	}
	else	{
		$MENU_TOP_NAME_ARRAY = $MENU_TOP_NAME_ARRAY['PARENT'];
		$MENU_TOP_NAME_TEXT = $MENU_TOP_NAME_ARRAY[1];
		$MENU_TOP_NAME_URL = $MENU_TOP_NAME_ARRAY[0];
	}
	//�ж��Ƿ�����Ӳ˵�,Ȼ���ж��Ƿ���ж�ӦȨ��-��ʼ
	$DEFAULT_MENU = 1;
	$MENU_TOP_ARRAY2 = @array_keys($TARGET_ARRAY[$MENU_TOP_NAME]);
	//�ж��Ƿ�����Ӳ˵�
	//print_R($MENU_TOP_ARRAY2);
	//�����Ӳ˵�
	if($MENU_TOP_ARRAY2[0]!="0")							{
		$MenuArray_child = array();
		for($x=0;$x<count($MENU_TOP_ARRAY2);$x++)				{
			$MENU_TOP_ARRAY2_NAME = $MENU_TOP_ARRAY2[$x];
			$TARGET_TITLE_NAME2 = $TARGET_TITLE."-".$MENU_TOP_NAME."-".$MENU_TOP_ARRAY2_NAME;
			//print $TARGET_TITLE_NAME2."&nbsp;&nbsp;";
			if(in_array($TARGET_TITLE_NAME2,$SUNSHINE_USER_PRIV_TEXT_ARRAY))	{
				$MenuArray_child[] = array($TARGET_TITLE_NAME2);
			}
		}
		if(count($MenuArray_child)==0)		{
			$DEFAULT_MENU = 0;
		}
	}
	//print_R($SUNSHINE_USER_PRIV_TEXT_ARRAY);
	//�ж��Ƿ�����Ӳ˵�,Ȼ���ж��Ƿ���ж�ӦȨ��-����
	if($MENU_TOP_NAME!="PARENT"&&$MENU_TOP_NAME!=""&&$DEFAULT_MENU==1)	{
		//�ж��Ƿ��д�Ȩ��,��ϵͳȨ���й���Ȩ����Ϣ
		$TARGET_TITLE_NAME = $TARGET_TITLE."-".$MENU_TOP_NAME;
		if(in_array($TARGET_TITLE_NAME,$SUNSHINE_USER_PRIV_TEXT_ARRAY))	{
			$MenuArray[] = array($MENU_TOP_NAME_URL,$MENU_TOP_NAME,$MENU_TOP_NAME_TEXT);
		}
	}
	//print_R($SUNSHINE_USER_PRIV_TEXT_ARRAY);
}
//print_R($SUNSHINE_USER_PRIV_TEXT_ARRAY);
return $MenuArray;

}

//����ҳ��ĺϷ���,���ڲ˵���������
function CheckSystemPrivate($MODULE_NAME,$MODULE_NAME2='',$MODULE_NAME3='')	{

global $db,$_SESSION;		//USER_PRIV_OTHER
$LOGIN_USER_PRIV_OTHER = $_SESSION['LOGIN_USER_PRIV_OTHER'];
$SUNSHINE_USER_PRIV = $_SESSION['SUNSHINE_USER_PRIV'];
//print_R($_SESSION);//exit;
$SUNSHINE_USER_PRIV_STR_ARRAY = explode(',',$SUNSHINE_USER_PRIV.",".$LOGIN_USER_PRIV_OTHER);
for($i=0;$i<sizeof($SUNSHINE_USER_PRIV_STR_ARRAY);$i++)		{
	//$SUNSHINE_USER_PRIV_TEXT_TEMP = returntablefield("user_priv","USER_PRIV",$SUNSHINE_USER_PRIV_STR_ARRAY[$i],"PRIV_NAME");
	$SUNSHINE_USER_PRIV_TEXT_ARRAY[] = returntablefield("systemprivate","ID",$SUNSHINE_USER_PRIV_STR_ARRAY[$i],"CONTENT");
	//print_R($SUNSHINE_USER_PRIV_TEXT_ARRAY);
}

$SUNSHINE_USER_PRIV_TEXT_ARRAY_TEXT = join(',',$SUNSHINE_USER_PRIV_TEXT_ARRAY);
$SUNSHINE_USER_PRIV_TEXT_ARRAY = explode(',',$SUNSHINE_USER_PRIV_TEXT_ARRAY_TEXT);
$SUNSHINE_USER_PRIV_TEXT_ARRAY = @array_flip($SUNSHINE_USER_PRIV_TEXT_ARRAY);
$SUNSHINE_USER_PRIV_TEXT_ARRAY = @array_flip($SUNSHINE_USER_PRIV_TEXT_ARRAY);
$SUNSHINE_USER_PRIV_TEXT_ARRAY = @array_values($SUNSHINE_USER_PRIV_TEXT_ARRAY);

//print_R($SUNSHINE_USER_PRIV_TEXT_ARRAY);
if(in_array($MODULE_NAME,$SUNSHINE_USER_PRIV_TEXT_ARRAY)&&$MODULE_NAME!="")		{
	//Ȩ�޺Ϸ�
	//print $MODULE_NAME."-1-".$MODULE_NAME2;
}
else if(in_array($MODULE_NAME2,$SUNSHINE_USER_PRIV_TEXT_ARRAY)&&$MODULE_NAME2!="")		{
	//Ȩ�޺Ϸ�
	//print $MODULE_NAME."-2-".$MODULE_NAME2;
}
else if(in_array($MODULE_NAME3,$SUNSHINE_USER_PRIV_TEXT_ARRAY)&&$MODULE_NAME3!="")		{
	//Ȩ�޺Ϸ�
	//print $MODULE_NAME."-2-".$MODULE_NAME2;
}
else	{
	//Ȩ�޲��Ϸ�,�ж���ʾ

require_once('cache.inc.php');
if($SYSTEM_MODE)   {
	$SCRIPT_FILENAME = ereg_replace('/','\\',$_SERVER['SCRIPT_FILENAME']);
	$MODE_SHOW_TEXT = "<input type=text readonly class=SmallInput value='$SCRIPT_FILENAME' size=95/>";
}
//print_R($_SESSION);
if($_SESSION['LOGIN_THEME']=='')	$SHOW_THEME = 3;
else $SHOW_THEME = $_SESSION['LOGIN_THEME'];
print <<<EOF
<link rel="stylesheet" type="text/css" href="".ROOT_DIR."theme/$SHOW_THEME/style.css">
<body class='bodycolor'><title>Ŀ¼��������</title><body bgcolor='#264989'><table class="MessageBox" align="center" width="500">
  <tr>
    <td class="msg warning">
      <h4 class="title">����:{$MODULE_NAME}</h4>
      <div class="content" style="font-size:12pt">�޸�ģ��ʹ��Ȩ�ޣ�����ʹ�ø�ģ�飬����ϵ����Ա�������ñ���ɫȨ�ޣ�</div>
	  {$MODE_SHOW_TEXT}
    </td>
  </tr>
</table>
EOF;


exit;
}

}

?>