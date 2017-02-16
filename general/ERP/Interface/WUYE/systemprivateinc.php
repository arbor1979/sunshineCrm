<?php

//$SCHOOL_MODEL = parse_ini_file("SCHOOL_MODEL.ini");
//$SCHOOL_MODEL_TEXT = $SCHOOL_MODEL['SCHOOL_MODEL'];
/*
if($_SESSION['SYSTEM_IS_TD_OA']=="0")									{
	$PRIVATE_SYSTEM['我的个人事务']['我的办公用品'] = array("../officeproduct/officeproduct_my.php","我的办公用品");
	$PRIVATE_SYSTEM['我的个人事务']['我的固定资产'] = array("../fixedasset/my_fixedasset.php","我的固定资产");
	$PRIVATE_SYSTEM['我的个人事务']['我的行政考勤'] = array("../XinZhengGuanLi/my_xingzheng.php","我的行政考勤");
	$PRIVATE_SYSTEM['我的个人事务']['网上公物报修'] = array("../WuYeGuanLi/wygl_teacher.php","网上公物报修");
	$PRIVATE_SYSTEM['我的个人事务']['单点登录']		= array("other_system_userlogin_newai.php","单点登录");

	$PRIVATE_SYSTEM['我的部门事务']['固定资产部门级管理']		= array("../fixedasset/fixedasset_department_newai.php","固定资产部门级管理");
	$PRIVATE_SYSTEM['我的部门事务']['行政考勤部门级管理']		= array("../XinZhengGuanLi/my_bumen_xingzheng.php","行政考勤部门级管理");
}
*/

/*
//第一菜单部分
$PRIVATE_SYSTEM['我的教学']['我的面板'] = array("../Teacher/TeacherStaticInfor.php","我的面板");
$PRIVATE_SYSTEM['我的教学']['我的学生']['PARENT'] = array("../Teacher/edu_StudentAllInfor.php","我的学生:学生评语,学生作业,作业点评,学生考勤,学生留言,学生密码,学生登录说明");
$PRIVATE_SYSTEM['我的教学']['我的学生']['学生档案'] = array("../Teacher/studentFilesFrame.php","我的学生:学生评语,学生作业,作业点评,学生考勤,学生留言,学生密码,学生登录说明");
$PRIVATE_SYSTEM['我的教学']['我的学生']['学生评语'] = array("../Teacher/growFilesFrame.php","我的学生:学生评语,学生作业,作业点评,学生考勤,学生留言,学生密码,学生登录说明");
//$PRIVATE_SYSTEM['我的教学']['我的学生']['学生考勤'] = array("../Teacher/studentKaoqin.php","我的学生:学生评语,学生作业,作业点评,学生考勤,学生留言,学生密码,学生登录说明");
$PRIVATE_SYSTEM['我的教学']['我的学生']['学生密码'] = array("../Teacher/studentPasswordFrame.php","我的学生:学生评语,学生作业,作业点评,学生考勤,学生留言,学生密码,学生登录说明");
$PRIVATE_SYSTEM['我的教学']['我的学生']['学生登录说明'] = array("../Teacher/StudentHelp.php","我的学生:学生评语,学生作业,作业点评,学生考勤,学生留言,学生密码,学生登录说明");

$PRIVATE_SYSTEM['我的教学']['我的班级']['PARENT'] = array("../Teacher/edu_ClassAllInfor.php","我的班级:班级通知,班级评语,班级作业");
$PRIVATE_SYSTEM['我的教学']['我的班级']['班级通知'] = array("../Teacher/school_notify_newai.php","我的班级:班级通知,班级评语,班级作业");
$PRIVATE_SYSTEM['我的教学']['我的班级']['班级评语'] = array("../Teacher/PingYu_ALL.php","我的班级:班级通知,班级评语,班级作业");
$PRIVATE_SYSTEM['我的教学']['我的班级']['班级作业'] = array("../Teacher/school_homework_newai.php","我的班级:班级通知,班级评语,班级作业");
$PRIVATE_SYSTEM['我的教学']['我的班级']['家访录'] = array("../Teacher/edu_jiafang_newai.php","我的教学:我的教案,教学日记,家访录,课外辅导,我的课表");

$PRIVATE_SYSTEM['我的教学']['日常教学']['PARENT'] = array("../Teacher/edu_TeachingAllInfor.php","我的教学:我的教案,教学日记,家访录,课外辅导,我的课表");
$PRIVATE_SYSTEM['我的教学']['日常教学']['教学日记'] = array("../Teacher/edu_jiaoxueriji_view.php","我的教学:我的教案,教学日记,家访录,课外辅导,我的课表");
$PRIVATE_SYSTEM['我的教学']['日常教学']['课表'] = array("../Teacher/TeacherSchedule.php","我的教学:我的教案,教学日记,家访录,课外辅导,我的课表");
$PRIVATE_SYSTEM['我的教学']['日常教学']['教案'] = array("../Teacher/edu_jiaoan_newai.php","我的教学:我的教案,教学日记,家访录,课外辅导,我的课表");
$PRIVATE_SYSTEM['我的教学']['日常教学']['课件'] = array("../Teacher/school_download_newai.php","我的教学:我的教案,教学日记,家访录,课外辅导,我的课表");
$PRIVATE_SYSTEM['我的教学']['日常教学']['作业'] = array("../Teacher/homeworkFrame.php","我的学生:学生评语,学生作业,作业点评,学生考勤,学生留言,学生密码,学生登录说明");
$PRIVATE_SYSTEM['我的教学']['日常教学']['留言'] = array("../Teacher/school_gb_newai.php","我的学生:学生评语,学生作业,作业点评,学生考勤,学生留言,学生密码,学生登录说明");
$PRIVATE_SYSTEM['我的教学']['日常教学']['辅导'] = array("../Teacher/edu_kewaifudao_newai.php","我的教学:我的教案,教学日记,家访录,课外辅导,我的课表");
$PRIVATE_SYSTEM['我的教学']['日常教学']['打卡'] = array("../Teacher/edu_teacherkaoqin_newai.php","我的教学:我的教案,教学日记,家访录,课外辅导,我的课表");
$PRIVATE_SYSTEM['我的教学']['日常教学']['考勤'] = array("../Teacher/edu_teacherkaoqinmingxi_newai.php","我的教学:我的教案,教学日记,家访录,课外辅导,我的课表");
$PRIVATE_SYSTEM['我的教学']['日常教学']['校历']		= array("../Teacher/SchoolCalendar.php","我的教学:我的教案,教学日记,家访录,课外辅导,我的课表");
$PRIVATE_SYSTEM['我的教学']['日常教学']['进程']		= array("../Teacher/edu_schooljingcheng_newai.php","我的教学:我的教案,教学日记,家访录,课外辅导,我的课表");
$PRIVATE_SYSTEM['我的教学']['日常教学']['课时']		= array("../Teacher/edu_kechoutongji.php","我的教学:我的教案,教学日记,家访录,课外辅导,我的课表");


$PRIVATE_SYSTEM['我的教学']['教学听课']['PARENT'] = array("../Teacher/edu_TingKeAllInfor.php","");

$PRIVATE_SYSTEM['我的教学']['教学听课']['听课计划']		= array("../Teacher/edu_tingke_newai.php","听课计划");
$PRIVATE_SYSTEM['我的教学']['教学听课']['听课考勤']		= array("../Teacher/edu_tingke_kaoqin_newai.php","听课考勤");
$PRIVATE_SYSTEM['我的教学']['教学听课']['听课日记']		= array("../Teacher/edu_tingke_riji_newai.php","听课日记");
$PRIVATE_SYSTEM['我的教学']['教学听课']['听课测评']		= array("../Teacher/edu_tingke_ceping_newai.php","听课测评");


//$PRIVATE_SYSTEM['我的教学']['学生量化考核'] = array("../Teacher/edu_StudentPingJiaMain.php","量化考核:学生量化考核");
$PRIVATE_SYSTEM['我的教学']['学生成绩'] = array("../Teacher/Exam_class_change.php","学生成绩");
$PRIVATE_SYSTEM['我的教学']['学生交费'] = array("../Teacher/edu_jiaofei.php","学生交费查阅");


$PRIVATE_SYSTEM['我的教学']['诚信档案']['PARENT']		= array("../Teacher/edu_StudentChengXin.php","诚信档案");
$PRIVATE_SYSTEM['我的教学']['诚信档案']['教育经历'] = array("../Teacher/newedu_xuexichengji.php","学习成绩档案");
$PRIVATE_SYSTEM['我的教学']['诚信档案']['培训经历'] = array("../Teacher/newedu_xuexichengji.php","学习成绩档案");
$PRIVATE_SYSTEM['我的教学']['诚信档案']['体检记录'] = array("../Teacher/newedu_xuexichengji.php","学习成绩档案");
$PRIVATE_SYSTEM['我的教学']['诚信档案']['献血记录'] = array("../Teacher/newedu_xuexichengji.php","学习成绩档案");
$PRIVATE_SYSTEM['我的教学']['诚信档案']['校外奖惩'] = array("../Teacher/newedu_xuexichengji.php","学习成绩档案");
$PRIVATE_SYSTEM['我的教学']['诚信档案']['校外社团'] = array("../Teacher/newedu_xuexichengji.php","学习成绩档案");
$PRIVATE_SYSTEM['我的教学']['诚信档案']['科研项目'] = array("../Teacher/newedu_xuexichengji.php","学习成绩档案");
$PRIVATE_SYSTEM['我的教学']['诚信档案']['社会实践'] = array("../Teacher/newedu_xuexichengji.php","学习成绩档案");
$PRIVATE_SYSTEM['我的教学']['诚信档案']['公益活动'] = array("../Teacher/newedu_xuexichengji.php","学习成绩档案");
$PRIVATE_SYSTEM['我的教学']['诚信档案']['经济信用'] = array("../Teacher/newedu_xuexichengji.php","学习成绩档案");
$PRIVATE_SYSTEM['我的教学']['诚信档案']['证书管理'] = array("../Teacher/newedu_xuexichengji.php","学习成绩档案");


//第一菜单部分
//$PRIVATE_SYSTEM['我的班级']['日常管理']['PARENT'] = array("../Teacher/edu_ClassAllInfor.php","我的班级:班级通知,班级评语,班级作业");
//$PRIVATE_SYSTEM['我的班级']['日常管理']['班级通知'] = array("../Teacher/school_notify_newai.php","我的班级:班级通知,班级评语,班级作业");
$PRIVATE_SYSTEM['我的班级']['班级通知'] = array("../Teacher/school_notify_newai.php","我的班级:班级通知,班级评语,班级作业");
//$PRIVATE_SYSTEM['我的班级']['班级创百分'] = array("../Teacher/edu_banjichangbaifen.php","班级创百分");
//$PRIVATE_SYSTEM['我的班级']['个人积分'] = array("../Teacher/edu_gerenjifen.php","个人积分");
//$PRIVATE_SYSTEM['我的班级']['国家助学金'] = array("../Teacher/edu_guojiazhuxuejin.php","国家助学金");
$PRIVATE_SYSTEM['我的班级']['班级作业'] = array("../Teacher/school_homework_newai.php","班级作业");
$PRIVATE_SYSTEM['我的班级']['学生评语'] = array("../Teacher/growFilesFrame.php","学生评语");
$PRIVATE_SYSTEM['我的班级']['家访情况'] = array("../Teacher/edu_jiafang_newai.php","家访情况");
$PRIVATE_SYSTEM['我的班级']['学生交费'] = array("../Teacher/edu_jiaofei.php","学生交费");
$PRIVATE_SYSTEM['我的班级']['学生档案'] = array("../Teacher/studentFilesFrame.php","学生档案");
$PRIVATE_SYSTEM['我的班级']['班主任考核查询'] = array("../Teacher/edu_banzhurenkaohechaxun.php","班主任考核查询");

*/


//第二菜单部分
if($SCHOOL_MODEL_TEXT!="4")	$PRIVATE_SYSTEM['学校基本信息设置']['学校基础结构设置'] = array("xueyuan.php","学校基础结构设置");
if($SCHOOL_MODEL_TEXT=="4")	$PRIVATE_SYSTEM['学校基本信息设置']['办学点设置'] = array("edu_xiaoqu_newai.php","办学点设置");
$PRIVATE_SYSTEM['学校基本信息设置']['班级信息管理'] = array("edu_banji_newai.php","班级信息管理");
$PRIVATE_SYSTEM['学校基本信息设置']['学校基本信息一览表'] = array("InforSchool.php","学校基本信息一览表");
$PRIVATE_SYSTEM['学校基本信息设置']['班级学生统计调查'] = array("InforSchool1.php","班级学生统计调查");
if(is_file("../../Enginee/lib/version.php"))	@require_once("../../Enginee/lib/version.php");
if(is_file("../Enginee/lib/version.php"))		@require_once("../Enginee/lib/version.php");

if($SYSTEM_VERSION_CONTENT=="LIYE")		{
	$PRIVATE_SYSTEM['学校基本信息设置']['学生电子档案'] = array("StudentFileChengXin.php","学生电子档案");
}


if(is_file('../../Framework/license.ini'))			{
	$ini_file=@parse_ini_file('../../Framework/license.ini');
	$软件版本Array = explode('-',$ini_file['SOFTWARE_TYPE']);
	if(TRIM($软件版本Array[1])=="标准版")					{
		$软件标准版本 = 1;
	}
	//print_R($软件标准版本);
}


//第三菜单部分

if($SCHOOL_MODEL_TEXT!="4")	$PRIVATE_SYSTEM['招生就业管理']['录取管理']['PARENT'] = array("NewStudentLuQu.php","录取管理子系统");
if($SCHOOL_MODEL_TEXT!="4")	$PRIVATE_SYSTEM['招生就业管理']['录取管理']['录取信息管理'] = array("NewStudent_LuQu_newai.php","录取信息管理");
if($SCHOOL_MODEL_TEXT!="4")	$PRIVATE_SYSTEM['招生就业管理']['录取管理']['录取审核管理'] = array("NewStudent_luqushenhe_newai.php","录取审核管理");
if($SCHOOL_MODEL_TEXT!="4")	$PRIVATE_SYSTEM['招生就业管理']['录取管理']['录取通知书及EMS打印'] = array("NewStudent_luqutongzhishu_newai.php","录取通知书及EMS打印");
if($SCHOOL_MODEL_TEXT!="4")	$PRIVATE_SYSTEM['招生就业管理']['录取管理']['手机短信通知'] = array("NewStudent_luquduanxin_newai.php","手机短信通知");
if($SCHOOL_MODEL_TEXT!="4")	$PRIVATE_SYSTEM['招生就业管理']['录取管理']['短信发送日志'] = array("edu_smsnewstudentreply_newai.php","短信发送日志");
if($SCHOOL_MODEL_TEXT!="4")	$PRIVATE_SYSTEM['招生就业管理']['录取管理']['农村或城市设置'] = array("../DICT/dict_chengshi_newai.php","农村或城市设置");
if($SCHOOL_MODEL_TEXT!="4")	$PRIVATE_SYSTEM['招生就业管理']['录取管理']['国家行政代码维护'] = array("../DICT/dict_countrycode_newai.php","国家行政代码维护");
if($SCHOOL_MODEL_TEXT!="4")	$PRIVATE_SYSTEM['招生就业管理']['录取管理']['EMS寄件人信息维护'] = array("NewStudent_config_newai.php","EMS寄件人信息维护");
if($SCHOOL_MODEL_TEXT!="4")	$PRIVATE_SYSTEM['招生就业管理']['录取管理']['信封打印管理'] = array("edu_newstudentprint_newai.php","信封打印管理");
if($SCHOOL_MODEL_TEXT!="4")	$PRIVATE_SYSTEM['招生就业管理']['录取管理']['统计报表查看'] = array("NewStudent_luqutongji_newai.php","统计报表查看");

if($SCHOOL_MODEL_TEXT!="4")	$PRIVATE_SYSTEM['招生就业管理']['迎新管理']['PARENT'] = array("NewStudent.php","新生注册报到");
if($SCHOOL_MODEL_TEXT!="4")	$PRIVATE_SYSTEM['招生就业管理']['迎新管理']['新生信息管理'] = array("NewStudent_yingxin_newai.php","新生信息管理");
if($SCHOOL_MODEL_TEXT!="4")	$PRIVATE_SYSTEM['招生就业管理']['迎新管理']['新生自动分班级'] = array("NewStudent_fenban_newai.php","新生自动分班级");
if($SCHOOL_MODEL_TEXT!="4")	$PRIVATE_SYSTEM['招生就业管理']['迎新管理']['新生手动分班级'] = array("NewStudent_shoudongfenban_newai.php","新生手动分班级");
if($SCHOOL_MODEL_TEXT!="4")	$PRIVATE_SYSTEM['招生就业管理']['迎新管理']['报到及打印流程'] = array("NewStudent_baodao_newai.php","报到及打印流程");
if($SCHOOL_MODEL_TEXT!="4")	$PRIVATE_SYSTEM['招生就业管理']['迎新管理']['新生缴费设置'] = array("NewStudent_jiaofei_newai.php","新生缴费设置");
if($SCHOOL_MODEL_TEXT!="4")	$PRIVATE_SYSTEM['招生就业管理']['迎新管理']['新生领取校园卡'] = array("NewStudent_xiaoyuanka_newai.php","新生领取校园卡");
if($SCHOOL_MODEL_TEXT!="4")	$PRIVATE_SYSTEM['招生就业管理']['迎新管理']['新生手动分宿舍'] = array("NewStudent_shoudongfensushe_newai.php","新生手动分宿舍");
if($SCHOOL_MODEL_TEXT!="4")	$PRIVATE_SYSTEM['招生就业管理']['迎新管理']['删除未报到学生'] = array("NewStudent_notbaodao_newai.php","删除未报到学生");
if($SCHOOL_MODEL_TEXT!="4")	$PRIVATE_SYSTEM['招生就业管理']['迎新管理']['新生批量转移到学籍'] = array("NewStudent_fenbanjieshu_newai.php","新生批量转移到学籍");
if($SCHOOL_MODEL_TEXT!="4")	$PRIVATE_SYSTEM['招生就业管理']['迎新管理']['已转移新生学籍'] = array("NewStudent_baodaoandxueji_newai.php","已转移新生学籍");
if($SCHOOL_MODEL_TEXT!="4")	$PRIVATE_SYSTEM['招生就业管理']['迎新管理']['同步预缴费到财务模块'] = array("NewStudent_jiaofei2caiwu_newai.php","同步预缴费到财务模块");
if($SCHOOL_MODEL_TEXT!="4")	$PRIVATE_SYSTEM['招生就业管理']['迎新管理']['插入新生'] = array("edu_newstudent_charu_newai.php","手工插入新生");
if($SCHOOL_MODEL_TEXT!="4")	$PRIVATE_SYSTEM['招生就业管理']['迎新管理']['新生报到按'.$_SESSION['SUNSHINE_REGISTER_XI'].'统计'] = array("NewStudent_xibaodao_statics.php","新生报到按".$_SESSION['SUNSHINE_REGISTER_XI']."统计");
if($SCHOOL_MODEL_TEXT!="4")	$PRIVATE_SYSTEM['招生就业管理']['迎新管理']['新生报到按班级统计'] = array("NewStudent_banjibaodao_statics.php","新生报到按班级统计");
if($SCHOOL_MODEL_TEXT!="4")	$PRIVATE_SYSTEM['招生就业管理']['迎新管理']['新生报到按专业统计'] = array("NewStudent_zhuanyebaodao_statics.php","新生报到按专业统计");
if($SCHOOL_MODEL_TEXT!="4")	$PRIVATE_SYSTEM['招生就业管理']['迎新管理']['迎新流程设置'] = array("NewStudent_liucheng_config.php","迎新流程设置");
if($SCHOOL_MODEL_TEXT!="4")	$PRIVATE_SYSTEM['招生就业管理']['迎新管理']['迎新工作结束'] = array("NewStudent_jieshugongzuo_newai.php","迎新工作结束");
//if($SCHOOL_MODEL_TEXT!="4")	$PRIVATE_SYSTEM['招生就业管理']['迎新管理']['新生自动分宿舍'] = array("NewStudent_fensushe_newai.php","新生自动分宿舍");

if($SCHOOL_MODEL_TEXT!="4")	$PRIVATE_SYSTEM['招生就业管理']['新生复查']['PARENT'] = array("NewStudentCheck.php","新生复查");
if($SCHOOL_MODEL_TEXT!="4")	$PRIVATE_SYSTEM['招生就业管理']['新生复查']['按班级打印清单'] = array("NewStudentCheck_BanjiList.php","按班级打印清单");
if($SCHOOL_MODEL_TEXT!="4")	$PRIVATE_SYSTEM['招生就业管理']['新生复查']['按宿舍打印清单'] = array("../SuSheGuanLi/dorm_rooming_view.php?action2=按宿舍打印清单","按宿舍打印清单");
if($SCHOOL_MODEL_TEXT!="4")	$PRIVATE_SYSTEM['招生就业管理']['新生复查']['新生复查设置'] = array("edu_newstudent_check_setting.php","新生复查设置");

if($SCHOOL_MODEL_TEXT!="4")	$PRIVATE_SYSTEM['招生就业管理']['学生就业']['PARENT'] = array("../JIUYE/JiuYe.php","学生就业管理");
if($SCHOOL_MODEL_TEXT!="4")	$PRIVATE_SYSTEM['招生就业管理']['学生就业']['学生就业情况'] = array("../JIUYE/edu_studentjiuye_newai.php","学生就业情况");
if($SCHOOL_MODEL_TEXT!="4")	$PRIVATE_SYSTEM['招生就业管理']['学生就业']['企业招聘信息'] = array("../JIUYE/edu_zhaopin_newai.php","企业招聘信息");
if($SCHOOL_MODEL_TEXT!="4")	$PRIVATE_SYSTEM['招生就业管理']['学生就业']['招聘申请审核'] = array("../JIUYE/edu_zhaopinshenqin_newai.php","招聘申请审核");
if($SCHOOL_MODEL_TEXT!="4")	$PRIVATE_SYSTEM['招生就业管理']['学生就业']['推荐就业管理'] = array("../JIUYE/edu_tuijianjiuye_newai.php","推荐就业管理");

if($SCHOOL_MODEL_TEXT!="4")	$PRIVATE_SYSTEM['招生就业管理']['学生实习']['PARENT'] = array("../JIUYE/ShiXi.php","学生就业管理");
if($SCHOOL_MODEL_TEXT!="4")	$PRIVATE_SYSTEM['招生就业管理']['学生实习']['实习单位管理'] = array("../JIUYE/edu_shixi_newai.php","实习单位管理");
if($SCHOOL_MODEL_TEXT!="4")	$PRIVATE_SYSTEM['招生就业管理']['学生实习']['学生申请统计'] = array("../JIUYE/edu_shixishenqing_newai.php","学生申请统计");

if($SCHOOL_MODEL_TEXT!="4")	$PRIVATE_SYSTEM['招生就业管理']['顶岗实习']['PARENT'] = array("../JIUYE/DingGangShiXi.php","顶岗实习");
if($SCHOOL_MODEL_TEXT!="4")	$PRIVATE_SYSTEM['招生就业管理']['顶岗实习']['顶岗实习类型'] = array("../JIUYE/edu_dinggangshixitype_newai.php","顶岗实习类型");
if($SCHOOL_MODEL_TEXT!="4")	$PRIVATE_SYSTEM['招生就业管理']['顶岗实习']['顶岗实习项目'] = array("../JIUYE/edu_dinggangshixiname_newai.php","顶岗实习项目");
if($SCHOOL_MODEL_TEXT!="4")	$PRIVATE_SYSTEM['招生就业管理']['顶岗实习']['顶岗实习明细'] = array("../JIUYE/edu_dinggangshixidetail_newai.php","顶岗实习明细");
if($SCHOOL_MODEL_TEXT!="4")	$PRIVATE_SYSTEM['招生就业管理']['顶岗实习']['顶岗实习日记'] = array("../JIUYE/edu_dinggangshixiriji_newai.php","顶岗实习日记");
if($SCHOOL_MODEL_TEXT!="4")	$PRIVATE_SYSTEM['招生就业管理']['顶岗实习']['顶岗实习统计'] = array("../JIUYE/edu_dinggangshixidetail_static.php","顶岗实习统计");


if($SCHOOL_MODEL_TEXT!="4")	$PRIVATE_SYSTEM['招生就业管理']['校友']['PARENT'] = array("../JIUYE/XiaoYou.php","校友信息管理");
if($SCHOOL_MODEL_TEXT!="4")	$PRIVATE_SYSTEM['招生就业管理']['校友']['校友班级信息'] = array("../JIUYE/edu_xiaoyoubanji_newai.php","校友班级信息");
if($SCHOOL_MODEL_TEXT!="4")	$PRIVATE_SYSTEM['招生就业管理']['校友']['校友信息管理'] = array("../JIUYE/edu_xiaoyou_newai.php","校友信息管理");
if($SCHOOL_MODEL_TEXT!="4")	$PRIVATE_SYSTEM['招生就业管理']['校友']['校友纪念品管理'] = array("../JIUYE/edu_xiaoyoujinianpin_newai.php","纪念品管理");
if($SCHOOL_MODEL_TEXT!="4")	$PRIVATE_SYSTEM['招生就业管理']['校友']['校友会信息发布'] = array("../JIUYE/edu_xiaoyouxinxi_newai.php","校友会信息发布");


$PRIVATE_SYSTEM['教务管理']['日常教学管理']['PARENT'] = array("MAIN_RICHENGJIAOXUE.php","日常教学管理");
$PRIVATE_SYSTEM['教务管理']['日常教学管理']['教师考勤'] = array("edu_teacherKaoQin.php","教师考勤");
$PRIVATE_SYSTEM['教务管理']['日常教学管理']['教学日记'] = array("edu_teacherjiaoxueriji_static.php","教学日记");
$PRIVATE_SYSTEM['教务管理']['日常教学管理']['学生考勤数据审核']	= array("edu_studentkaoqin_newai.php","学生考勤数据审核");
//$PRIVATE_SYSTEM['教务管理']['日常教学管理']['教学内容'] = array("BanJiInfor.php","教学内容");
$PRIVATE_SYSTEM['教务管理']['日常教学管理']['工作量统计'] = array("kechou.php","工作量统计");
$PRIVATE_SYSTEM['教务管理']['日常教学管理']['课堂教学调查'] = array("../JiaXuePingJia/edu_teacherPingJia.php","课堂教学调查");
$PRIVATE_SYSTEM['教务管理']['日常教学管理']['教务通知'] = array("school_jiaowuke_notify_newai.php","教务通知");
$PRIVATE_SYSTEM['教务管理']['日常教学管理']['学生证书'] = array("edu_zhengshuguanli_newai.php","学生证书");
$PRIVATE_SYSTEM['教务管理']['日常教学管理']['教师调查问卷'] = array("edu_teacher_DiaoChaWenJuan.php","教师调查问卷");


$PRIVATE_SYSTEM['教务管理']['教学基本信息']['PARENT'] = array("MAIN_JIAOXUEBASICINFOR.php","教学基本信息");
$PRIVATE_SYSTEM['教务管理']['教学基本信息']['学期'] = array("edu_xueqiexec_newai.php","学期设置");
$PRIVATE_SYSTEM['教务管理']['教学基本信息']['校历'] = array("edu_schoolcalendar_newai.php","校历设置");
$PRIVATE_SYSTEM['教务管理']['教学基本信息']['课程库']= array("edu_course.php","课程库");
$PRIVATE_SYSTEM['教务管理']['教学基本信息']['教室'] = array("edu_classroom.php","教室管理");
//$PRIVATE_SYSTEM['教务管理']['教学基本信息']['远程教学'] = array("edu_yuancheng.php","远程教育");
if($SCHOOL_MODEL_TEXT!="4")		$PRIVATE_SYSTEM['教务管理']['教学基本信息']['教学计划'] = array("edu_planexec.php","教学计划");
if($SCHOOL_MODEL_TEXT=="4")		$PRIVATE_SYSTEM['教务管理']['教学基本信息']['教学计划'] = array("edu_planexec_middleschool_newai.php","教学计划");
$PRIVATE_SYSTEM['教务管理']['教学基本信息']['教学进程'] = array("edu_jiaoxuejingcheng.php","教学进程");
$PRIVATE_SYSTEM['教务管理']['教学基本信息']['每周工作重点提示'] = array("edu_benzhouzhongdiantishi_newai.php","每周工作重点提示");


$PRIVATE_SYSTEM['教务管理']['学籍']['PARENT'] = array("StudentFile.php","学籍");
$PRIVATE_SYSTEM['教务管理']['学籍']['学生学籍管理'] = array("studentFilesFrame.php","学生档案管理(可以对学生的档案进行管理,包括档案异动信息)");
$PRIVATE_SYSTEM['教务管理']['学籍']['学籍异动管理'] = array("studentFlowFrame.php","学籍异动管理");
$PRIVATE_SYSTEM['教务管理']['学籍']['学籍异动查阅'] = array("student_changelist.php","学生异动信息查阅(可以对学生的转学/退学/休学/开除/转班等异动信息进行查阅和打印)");
$PRIVATE_SYSTEM['教务管理']['学籍']['一卡通卡号集成'] = array("studentEcardFrame.php","学生一卡通卡号集成(可以把食堂或是其它部分使用的一卡通的卡号与学号进行关联)");
if($SCHOOL_MODEL_TEXT=="4")		$PRIVATE_SYSTEM['教务管理']['学籍']['重新分班'] = array("studentBanjiReset.php","学校每年一度的重新分班工作,只针对于需要进行年初分班的中小学校使用");


$PRIVATE_SYSTEM['教务管理']['成绩']['PARENT']		= array("chengji.php","成绩");
$PRIVATE_SYSTEM['教务管理']['成绩']['考试信息管理'] = array("edu_examname_newai.php","考试信息管理");
$PRIVATE_SYSTEM['教务管理']['成绩']['班级成绩管理'] = array("Exam_class_change.php","班级成绩管理");
$PRIVATE_SYSTEM['教务管理']['成绩']['班级成绩查询'] = array("Exam_List.php","班级成绩查询");
$PRIVATE_SYSTEM['教务管理']['成绩']['补考成绩管理'] = array("Exam_class_change_bukao.php","补考成绩管理");
$PRIVATE_SYSTEM['教务管理']['成绩']['重修成绩管理'] = array("Exam_class_change_chongxiu.php","重修成绩管理");
$PRIVATE_SYSTEM['教务管理']['成绩']['补考强制转重修']	= array("Exam_class_bukao_to_chongxiu.php","补考强制转重修");
$PRIVATE_SYSTEM['教务管理']['成绩']['成绩报告单']	= array("edu_xueshengchengji.php","成绩报告单");
$PRIVATE_SYSTEM['教务管理']['成绩']['成绩明细管理'] = array("edu_exam_newai.php","成绩明细管理");
$PRIVATE_SYSTEM['教务管理']['成绩']['删除成绩(慎用)']	= array("edu_exam_trunk.php","删除成绩(慎用)");
$PRIVATE_SYSTEM['教务管理']['成绩']['未录成绩班级列表']	= array("edu_exam_noinputbanjilist.php","未录成绩班级列表");
$PRIVATE_SYSTEM['教务管理']['成绩']['未录成绩教师列表']	= array("edu_exam_noinputuserlist.php","未录成绩教师列表");



$PRIVATE_SYSTEM['教务管理']['课表']['PARENT']		= array("ScheduleMain.php","课表");
$PRIVATE_SYSTEM['教务管理']['课表']['教学计划设置'] = array("edu_planexec.php","教学计划设置");
$PRIVATE_SYSTEM['教务管理']['课表']['智能排课设置'] = array("edu_schedule_autoform_setting.php","智能排课设置");
$PRIVATE_SYSTEM['教务管理']['课表']['进行智能排课'] = array("../SunshineCT/AutoFormCourse.php","进行智能排课");
$PRIVATE_SYSTEM['教务管理']['课表']['教师不排课时间'] = array("edu_scheduleroles_newai.php","教师不排课时间");
$PRIVATE_SYSTEM['教务管理']['课表']['按班级手工调课'] = array("schedule_frame.php","按班级手工调课");
$PRIVATE_SYSTEM['教务管理']['课表']['教务科调课'] = array("edu_schedule_setting.php","教务科调课");
$PRIVATE_SYSTEM['教务管理']['课表']['节假日调课'] = array("edu_schedulejiejiari_newai.php","节假日调课");
$PRIVATE_SYSTEM['教务管理']['课表']['分段教学设置'] = array("edu_schedulefenduanjiaoxue_newai.php","分段教学设置");
$PRIVATE_SYSTEM['教务管理']['课表']['按老师查课表'] = array("schedule_teacher.php","按老师查课表");
$PRIVATE_SYSTEM['教务管理']['课表']['按班级查课表'] = array("schedule_class.php","按班级查课表");
$PRIVATE_SYSTEM['教务管理']['课表']['按教室查课表'] = array("schedule_classroom.php","按教室查课表");
$PRIVATE_SYSTEM['教务管理']['课表']['课表综合查询'] = array("schedule.php","课表综合查询");
$PRIVATE_SYSTEM['教务管理']['课表']['查询总课表'] = array("schedule_yuanxi.php","查询总课表");
$PRIVATE_SYSTEM['教务管理']['课表']['作息时间表设定'] = array("schedule_timesetting.php","作息时间表设定");
$PRIVATE_SYSTEM['教务管理']['课表']['教师周课时统计'] = array("schedule_teacherkeshishou.php","教师周课时统计");
$PRIVATE_SYSTEM['教务管理']['课表']['课表原始数据'] = array("edu_schedule_newai.php","课表原始数据");
$PRIVATE_SYSTEM['教务管理']['课表']['课表操作工具集'] = array("edu_schedule_tools.php","课表操作工具集");


$PRIVATE_SYSTEM['教务管理']['教材']['PARENT']		= array("MAIN_JIAOCAI.php","教材管理");
$PRIVATE_SYSTEM['教务管理']['教材']['教材管理']		= array("edu_jiaocai_newai.php","教材管理");
$PRIVATE_SYSTEM['教务管理']['教材']['教材计划']		= array("edu_jiaocaiplan_newai.php","教材计划");
$PRIVATE_SYSTEM['教务管理']['教材']['采购单']		= array("edu_jiaocaiplan_caigoudan.php","采购单");
$PRIVATE_SYSTEM['教务管理']['教材']['入库']			= array("edu_jiaocaiplan_ruku.php","入库");//edu_jiaocaiin_newai.php
$PRIVATE_SYSTEM['教务管理']['教材']['发放']			= array("edu_jiaocaiplan_fafang.php","发放");//edu_jiaocaiout_newai
$PRIVATE_SYSTEM['教务管理']['教材']['明细']			= array("edu_jiaocaistudent_newai.php","明细");//edu_jiaocaiout_newai
//$PRIVATE_SYSTEM['教务管理']['教材']['退换']			= array("edu_jiaocaitui_newai.php","退换");
$PRIVATE_SYSTEM['教务管理']['教材']['操作明细']		= array("edu_jiaocai_detail.php","操作明细");
$PRIVATE_SYSTEM['教务管理']['教材']['设置']			= array("edu_jiaocai_setting.php","仓库设置");
$PRIVATE_SYSTEM['教务管理']['教材']['教材统计']		= array("edu_jiaocaicangkutongji_newai.php","仓库设置");
$PRIVATE_SYSTEM['教务管理']['教材']['财务统计']		= array("edu_jiaocaitongji_newai.php","财务统计");
$PRIVATE_SYSTEM['教务管理']['教材']['评价统计']		= array("jiaocaipingjiatongji.php","评价统计");

$PRIVATE_SYSTEM['教务管理']['教学听课']['PARENT']   =array("MAIN_JIAOXUETINGKE.php","教学听课管理");
$PRIVATE_SYSTEM['教务管理']['教学听课']['听课计划'] = array("edu_tingke_newai.php","听课计划");
$PRIVATE_SYSTEM['教务管理']['教学听课']['听课考勤'] = array("edu_tingke_kaoqin_newai.php","听课考勤");
$PRIVATE_SYSTEM['教务管理']['教学听课']['听课考勤补登']		= array("edu_tingke_kaoqinbudeng_newai.php","听课考勤补登");
$PRIVATE_SYSTEM['教务管理']['教学听课']['听课日记']			= array("edu_tingke_riji_newai.php","听课日记");
$PRIVATE_SYSTEM['教务管理']['教学听课']['听课测评']			= array("edu_tingke_ceping_newai.php","听课测评");
$PRIVATE_SYSTEM['教务管理']['教学听课']['听课工作量']		= array("edu_tingke_gongzuoliang_newai.php","听课工作量");

$PRIVATE_SYSTEM['教务管理']['考试排考']				= array("paikao.php","考试排考");
$PRIVATE_SYSTEM['教务管理']['选课']					= array("../XUANKE/MAIN_XUANKE.php","选课");

$PRIVATE_SYSTEM['教务管理']['科研']['PARENT']		= array("MAIN_KEYAN.php","科研管理");
$PRIVATE_SYSTEM['教务管理']['科研']['科研项目']		= array("keyan_xiangmuguanli_newai.php","科研项目");
$PRIVATE_SYSTEM['教务管理']['科研']['立项申请']		= array("keyan_lixiangshenpi_newai.php","立项申请");
$PRIVATE_SYSTEM['教务管理']['科研']['计划指南']		= array("keyan_jihuazhinan_newai.php","计划指南");
$PRIVATE_SYSTEM['教务管理']['科研']['合同管理']		= array("keyan_hetongguanli_newai.php","合同管理");
$PRIVATE_SYSTEM['教务管理']['科研']['规划动态']		= array("keyan_guihuadongtai_newai.php","规划动态");
$PRIVATE_SYSTEM['教务管理']['科研']['合作办学']		= array("edu_guanmingbaoban_newai.php","合作办学");
$PRIVATE_SYSTEM['教务管理']['科研']['校企合作']		= array("edu_xiaoqihezuo_newai.php","校企合作");
$PRIVATE_SYSTEM['教务管理']['科研']['课题研究']		= array("keti_yanjiu_newai.php","课题研究");
$PRIVATE_SYSTEM['教务管理']['科研']['类别']			= array("keyan_leibie_newai.php","类别");
$PRIVATE_SYSTEM['教务管理']['科研']['类型']			= array("keyan_leixing_newai.php","类型");


//教师管理
$PRIVATE_SYSTEM['教师管理']['教师基本信息']['PARENT']			= array("../TeacherManage/MAIN_JIAOSHIXINXI.php","教师信息管理");
$PRIVATE_SYSTEM['教师管理']['教师基本信息']['教师信息列表']		= array("../TeacherManage/edu_teachermanage_newai.php","教师信息列表");
$PRIVATE_SYSTEM['教师管理']['教师基本信息']['教师任务一览表']	= array("../TeacherManage/schedule_teacher.php","教师任务一览表");
$PRIVATE_SYSTEM['教师管理']['教师基本信息']['教师工作考核登记表'] = array("../TeacherManage/edu_teacher_work_check_register_newai.php","教师工作考核登记表");
$PRIVATE_SYSTEM['教师管理']['教师基本信息']['教师年度考核量化表'] = array("../TeacherManage/edu_teacher_yearcheck_newai.php","教师年度考核量化表");
$PRIVATE_SYSTEM['教师管理']['教师基本信息']['教师管理权限设置'] = array("../TeacherManage/inc_teacher_priv.php","教师管理权限设置");
$PRIVATE_SYSTEM['教师管理']['教师基本信息']['级别设置']			= array("../TeacherManage/gb_jibie_newai.php","级别设置");

$PRIVATE_SYSTEM['教师管理']['教师明细管理']['PARENT']		= array("../TeacherManage/MAIN_JIAOSHIXINXICHAXUN.php","教师信息查询");
$PRIVATE_SYSTEM['教师管理']['教师明细管理']['奖惩情况']		= array("../TeacherManage/edu_teacherrewards_newai.php","奖惩情况");
$PRIVATE_SYSTEM['教师管理']['教师明细管理']['教师离职复职'] = array("../TeacherManage/edu_teacheriswork_newai.php","教师离职复职记录");
$PRIVATE_SYSTEM['教师管理']['教师明细管理']['个人简历']		= array("../TeacherManage/edu_teacherxuexijingli_newai.php","个人简历");
$PRIVATE_SYSTEM['教师管理']['教师明细管理']['论文登记']		= array("../TeacherManage/edu_teacherlunwen_newai.php","论文登记");
$PRIVATE_SYSTEM['教师管理']['教师明细管理']['课题登记']		= array("../TeacherManage/edu_teacherketi_newai.php","课题登记");
$PRIVATE_SYSTEM['教师管理']['教师明细管理']['其他成果登记'] = array("../TeacherManage/edu_teacherchengguo_newai.php","其他成果登记");
$PRIVATE_SYSTEM['教师管理']['教师明细管理']['培训情况']		= array("../TeacherManage/edu_teacherpeixun_newai.php","培训情况");


$PRIVATE_SYSTEM['教师管理']['教师档案查询']						= array("../TeacherManage/EDU_teacherserch.php","教师档案查询");

$PRIVATE_SYSTEM['教师管理']['部门级别管理']['PARENT']			= array("../TeacherManage/MAIN_JIAOSHIBUMENGUANLI.php","教师部门管理");
$PRIVATE_SYSTEM['教师管理']['部门级别管理']['档案管理']			= array("../TeacherManage/my_edu_teachermanage_newai.php","档案管理");
$PRIVATE_SYSTEM['教师管理']['部门级别管理']['论文登记']			= array("../TeacherManage/my_edu_teacherlunwen_newai.php","论文登记");
$PRIVATE_SYSTEM['教师管理']['部门级别管理']['课题登记']			= array("../TeacherManage/my_edu_teacherketi_newai.php","课题登记");
$PRIVATE_SYSTEM['教师管理']['部门级别管理']['其他成果登记']		= array("../TeacherManage/my_edu_teacherchengguo_newai.php","其他成果登记");
$PRIVATE_SYSTEM['教师管理']['部门级别管理']['培训情况']			= array("../TeacherManage/my_edu_teacherpeixun_newai.php","培训情况");
$PRIVATE_SYSTEM['教师管理']['部门级别管理']['奖惩情况']			= array("../TeacherManage/my_edu_teacherrewards_newai.php","奖惩情况");
$PRIVATE_SYSTEM['教师管理']['部门级别管理']['工作考核']			= array("../TeacherManage/my_edu_teacher_work_check_register_newai.php","工作考核");
$PRIVATE_SYSTEM['教师管理']['部门级别管理']['年度量化']			= array("../TeacherManage/my_edu_teacher_yearcheck_newai.php","年度量化");
$PRIVATE_SYSTEM['教师管理']['部门级别管理']['个人简历']			= array("../TeacherManage/my_edu_teacherxuexijingli_newai.php","个人简历");
$PRIVATE_SYSTEM['教师管理']['部门级别管理']['任课表']			= array("../TeacherManage/my_schedule_teacher.php","任课表");



//第五菜单部分
$PRIVATE_SYSTEM['学生管理']['班主任']['PARENT']			= array("MAIN_BANZHUREN.php","班主任管理");
$PRIVATE_SYSTEM['学生管理']['班主任']['班主任信息设置'] = array("edu_banzhuren_setting.php","班主任信息设置");
$PRIVATE_SYSTEM['学生管理']['班主任']['每周工作重点'] = array("edu_meizhoubeiwang_newai.php","每周工作重点");
$PRIVATE_SYSTEM['学生管理']['班主任']['班级周记'] = array("edu_banjizhouji_newai.php","班级周记");
$PRIVATE_SYSTEM['学生管理']['班主任']['手机短信配额'] = array("edu_banzhurenxinxi_newai.php","手机短信配额");



$PRIVATE_SYSTEM['学生管理']['班级创百分']['PARENT']			= array("../BanJiGuanLi/MAIN_BANJIGUANLI.php","班级管理");
$PRIVATE_SYSTEM['学生管理']['班级创百分']['创百分设置']	= array("../BanJiGuanLi/edu_banjichuangbaifen.php","创百分设置");
$PRIVATE_SYSTEM['学生管理']['班级创百分']['创百分指导老师']	= array("../BanJiGuanLi/edu_banjichuangbaifen_zhidaolaoshi.php","创百分指导老师管理");
$PRIVATE_SYSTEM['学生管理']['班级创百分']['创百分总负责老师']	= array("../BanJiGuanLi/edu_evaluateclass.php","创百分总管老师");
$PRIVATE_SYSTEM['学生管理']['班级创百分']['个人积分管理'] = array("../BanJiGuanLi/edu_gebanjifenqingkuang.php","各班个人积分情况");
$PRIVATE_SYSTEM['学生管理']['班级创百分']['评分标准'] = array("../BanJiGuanLi/edu_pingbixiangmu_newai.php","个人积分评分标准");
$PRIVATE_SYSTEM['学生管理']['班级创百分']['积分分组'] = array("../BanJiGuanLi/edu_evaluatepersonalgroup_newai.php","个人积分分组设置");
$PRIVATE_SYSTEM['学生管理']['班级创百分']['课堂纪律按班级统计'] = array("../BanJiGuanLi/edu_ketangjilvbanjitongji_newai.php","课堂纪律按班级统计");


$PRIVATE_SYSTEM['学生管理']['学生宿舍']['PARENT']		= array("../SuSheGuanLi/Dorm.php","学生宿舍管理");
$PRIVATE_SYSTEM['学生管理']['学生宿舍']['基本信息管理'] = array("../SuSheGuanLi/Dorm_BasicInfor.php","基本信息管理");
$PRIVATE_SYSTEM['学生管理']['学生宿舍']['宿舍检查评比'] = array("../SuSheGuanLi/Dorm_Jiancha.php","宿舍检查评比");
$PRIVATE_SYSTEM['学生管理']['学生宿舍']['文明宿舍评比'] = array("../SuSheGuanLi/Dorm_WenMing.php","文明宿舍评比");
$PRIVATE_SYSTEM['学生管理']['学生宿舍']['日常事务管理'] = array("../SuSheGuanLi/Dorm_RiChangShiWu.php","日常事务管理:生管教师常用菜单");

/*
$PRIVATE_SYSTEM['学生管理']['党员']['PARENT'] = array("../DangWuGuanLi/MAIN_DANGWU.php","党员管理");
$PRIVATE_SYSTEM['学生管理']['党员']['党员管理'] = array("../DangWuGuanLi/xingzheng_partymember_newai.php","党员管理");
$PRIVATE_SYSTEM['学生管理']['党员']['党费缴纳'] = array("../DangWuGuanLi/xingzheng_partyfeein_newai.php","党费缴纳");
$PRIVATE_SYSTEM['学生管理']['党员']['缴纳统计'] = array("../DangWuGuanLi/xingzheng_partyfeein.static.php","缴纳统计");
$PRIVATE_SYSTEM['学生管理']['党员']['预备党员'] = array("../DangWuGuanLi/xingzheng_partymember2_newai.php","预备党员");
$PRIVATE_SYSTEM['学生管理']['党员']['党组织活动'] = array("../DangWuGuanLi/xingzheng_partyactive_newai.php","党组织活动");
$PRIVATE_SYSTEM['学生管理']['党员']['党支部管理'] = array("../DangWuGuanLi/xingzheng_partyunit_newai.php","党支部管理");
$PRIVATE_SYSTEM['学生管理']['党员']['党员状态'] = array("../DangWuGuanLi/xingzheng_partystatus_newai.php","党员状态");

$PRIVATE_SYSTEM['学生管理']['团员']['PARENT'] = array("../TuanWuGuanLi/MAIN_TUANWU.php","团员管理");
$PRIVATE_SYSTEM['学生管理']['团员']['团员管理'] = array("../TuanWuGuanLi/xingzheng_leaguemember_newai.php","团员管理");
$PRIVATE_SYSTEM['学生管理']['团员']['团费缴纳'] = array("../TuanWuGuanLi/xingzheng_leaguefeein_newai.php","团费缴纳");
$PRIVATE_SYSTEM['学生管理']['团员']['缴纳统计'] = array("../TuanWuGuanLi/xingzheng_leaguefeein.static.php","缴纳统计");
$PRIVATE_SYSTEM['学生管理']['团员']['团费支出'] = array("../TuanWuGuanLi/xingzheng_leaguefeeout_newai.php","团费支出");
$PRIVATE_SYSTEM['学生管理']['团员']['支出统计'] = array("../TuanWuGuanLi/xingzheng_leaguefeeout.static.php","支出统计");
$PRIVATE_SYSTEM['学生管理']['团员']['团组织活动'] = array("../TuanWuGuanLi/xingzheng_leagueactive_newai.php","团组织活动");
$PRIVATE_SYSTEM['学生管理']['团员']['团支部管理'] = array("../TuanWuGuanLi/xingzheng_leagueunit_newai.php","团支部管理");

$PRIVATE_SYSTEM['学生管理']['社团']['PARENT'] = array("../SheTuanGuanLi/MAIN_SHETUAN.php","社团管理");
$PRIVATE_SYSTEM['学生管理']['社团']['社团管理'] = array("../SheTuanGuanLi/xingzheng_association_newai.php","社团管理");
$PRIVATE_SYSTEM['学生管理']['社团']['社团成员'] = array("../SheTuanGuanLi/xingzheng_associationmember_newai.php","社团成员");
$PRIVATE_SYSTEM['学生管理']['社团']['社团活动'] = array("../SheTuanGuanLi/xingzheng_associationactive_newai.php","社团活动");
$PRIVATE_SYSTEM['学生管理']['社团']['社团评定'] = array("../SheTuanGuanLi/xingzheng_associationjudge_newai.php","社团评定");
$PRIVATE_SYSTEM['学生管理']['社团']['人员职务'] = array("../SheTuanGuanLi/xingzheng_associationmembertype_newai.php","人员职务");
$PRIVATE_SYSTEM['学生管理']['社团']['社团类型'] = array("../SheTuanGuanLi/xingzheng_associationtype_newai.php","社团类型");
*/

//$PRIVATE_SYSTEM['学生管理']['请假外出']['PARENT']			= array("edu_xueshengqingjia.php","学生请假外出");
//$PRIVATE_SYSTEM['学生管理']['请假外出']['学生请假外出管理']	= array("edu_xueshengqingjia2_newai.php","学生请假外出管理");
//$PRIVATE_SYSTEM['学生管理']['请假外出']['学生请假外出统计']	= array("xueshengqingjiawaichu.php","学生请假外出统计");

$PRIVATE_SYSTEM['学生管理']['综合事务']['PARENT']		= array("../XueShengGuanLi/MAIN_XUESHENG_ZONGHESHIWU.php","综合事务");
$PRIVATE_SYSTEM['学生管理']['综合事务']['请假外出']		= array("../XueShengGuanLi/edu_xueshengqingjia.php","请假外出");
$PRIVATE_SYSTEM['学生管理']['综合事务']['问卷调查']		= array("../XueShengGuanLi/DIAOCHAWENJUAN.php","问卷调查");
$PRIVATE_SYSTEM['学生管理']['综合事务']['第二课堂']		= array("../BanJiGuanLi/MAIN_DIERKETANG.php","第二课堂");
$PRIVATE_SYSTEM['学生管理']['综合事务']['党员']			= array("../DangWuGuanLi/MAIN_DANGWU.php","党员");
$PRIVATE_SYSTEM['学生管理']['综合事务']['团员']			= array("../TuanWuGuanLi/MAIN_TUANWU.php","团员");
$PRIVATE_SYSTEM['学生管理']['综合事务']['社团']			= array("../SheTuanGuanLi/MAIN_SHETUAN.php","社团");


$PRIVATE_SYSTEM['学生管理']['奖惩补助']['PARENT']			= array("../XueShengGuanLi/MAIN_XUESHENG_JIANGCHENGBUZHU.php","奖惩补助");
$PRIVATE_SYSTEM['学生管理']['奖惩补助']['学生奖惩']			= array("../XueShengGuanLi/edu_studentjiangcheng_newai.php","学生奖惩");
$PRIVATE_SYSTEM['学生管理']['奖惩补助']['学生违纪']			= array("../XueShengGuanLi/edu_weijihuizong_main.php","学生违纪");
$PRIVATE_SYSTEM['学生管理']['奖惩补助']['奖助学金']			= array("../XueShengGuanLi/MAIN_JIANGZHUXUEJIN.php","奖助学金");
$PRIVATE_SYSTEM['学生管理']['奖惩补助']['奖助学金']			= array("../XueShengGuanLi/MAIN_JIANGZHUXUEJIN.php","奖助学金");
$PRIVATE_SYSTEM['学生管理']['奖惩补助']['生活补助']			= array("../XueShengGuanLi/MAIN_SHENGHUOBUZHU.php","生活补助");
$PRIVATE_SYSTEM['学生管理']['奖惩补助']['勤工俭学']			= array("../XueShengGuanLi/MAIN_QINGONGJIANXUE.php","生活补助");



//$PRIVATE_SYSTEM['学生管理']['问卷调查']['PARENT']			= array("DIAOCHAWENJUAN.php","问卷调查");
//$PRIVATE_SYSTEM['学生管理']['问卷调查']['调查名称管理']		= array("edu_diaochamingcheng_newai.php","调查名称管理");
//$PRIVATE_SYSTEM['学生管理']['问卷调查']['调查内容管理']		= array("edu_diaochaneirong_newai.php","调查内容管理");
//$PRIVATE_SYSTEM['学生管理']['问卷调查']['调查明细']			= array("edu_diaochamingxi_newai.php","调查明细");
//$PRIVATE_SYSTEM['学生管理']['问卷调查']['调查统计']			= array("diaochatongji.php","调查统计");

//$PRIVATE_SYSTEM['学生管理']['奖助学金']['PARENT'] = array("MAIN_JIANGZHUXUEJIN.php","奖助学金管理");
//$PRIVATE_SYSTEM['学生管理']['奖助学金']['奖助学金管理'] = array("edu_jiangxuejin_newai.php","奖助学金管理");
//$PRIVATE_SYSTEM['学生管理']['奖助学金']['奖助学金类型'] = array("edu_jiangxuejintype_newai.php","奖助学金类型");
//$PRIVATE_SYSTEM['学生管理']['奖助学金']['奖助学金统计'] = array("edu_jiangzhuxuejinsearch.php","奖助学金统计");
//$PRIVATE_SYSTEM['学生管理']['奖助学金']['奖助学金分类'] = array("edu_jiangxuejingroup_newai.php","奖助学金分类");

//添加生活补助菜单
//$PRIVATE_SYSTEM['学生管理']['生活补助']['PARENT'] = array("../XueShengGuanLi/MAIN_SHENGHUOBUZHU.php","生活补助管理");
//$PRIVATE_SYSTEM['学生管理']['生活补助']['生活补助类型'] = array("../XueShengGuanLi/edu_shenghuobuzhufenlei_newai.php","生活补助类型");
//$PRIVATE_SYSTEM['学生管理']['生活补助']['生活补助名称'] = array("../XueShengGuanLi/edu_shenghuobuzhutype_newai.php","生活补助名称");
//$PRIVATE_SYSTEM['学生管理']['生活补助']['生活补助管理'] = array("../XueShengGuanLi/edu_shenghuobuzhu_newai.php","生活补助管理");
//$PRIVATE_SYSTEM['学生管理']['生活补助']['生活补助统计'] = array("../XueShengGuanLi/edu_buzhusearch.php","生活补助统计");

//$PRIVATE_SYSTEM['学生管理']['勤工俭学']['PARENT'] = array("../XueShengGuanLi/MAIN_QINGONGJIANXUE.php","勤工俭学管理");
//$PRIVATE_SYSTEM['学生管理']['勤工俭学']['勤工俭学管理'] = array("../XueShengGuanLi/edu_qingongjianxue_newai.php","勤工俭学管理");
//$PRIVATE_SYSTEM['学生管理']['勤工俭学']['职位管理'] = array("../XueShengGuanLi/edu_qingongjianxuetype_newai.php","奖助学金类型");
//$PRIVATE_SYSTEM['学生管理']['勤工俭学']['勤工俭学统计'] = array("../XueShengGuanLi/edu_qingongjianxuesee.php","勤工俭学统计");

//$PRIVATE_SYSTEM['学生管理']['第二课堂']['PARENT'] = array("../BanJiGuanLi/MAIN_DIERKETANG.php","第二课堂管理");
//$PRIVATE_SYSTEM['学生管理']['第二课堂']['信息采集人管理'] = array("../BanJiGuanLi/edu_dierketangcaijiren.php","信息采集人管理");
//$PRIVATE_SYSTEM['学生管理']['第二课堂']['活动总结填写'] = array("../BanJiGuanLi/edu_dierketangzongjie.php","活动总结填写");
//$PRIVATE_SYSTEM['学生管理']['第二课堂']['第二课堂活动管理'] = array("../BanJiGuanLi/edu_dierketang_newai.php","第二课堂活动管理");
//$PRIVATE_SYSTEM['学生管理']['第二课堂']['第二课堂级别管理'] = array("../BanJiGuanLi/edu_dierketangjibie_newai.php","第二课堂级别管理");

$PRIVATE_SYSTEM['学生管理']['毕业生']['PARENT'] = array("MAIN_BIYESHENG.php","毕业生管理");
$PRIVATE_SYSTEM['学生管理']['毕业生']['毕业生信息管理'] = array("BiyeStudentFilesFrame.php","毕业生信息管理");
$PRIVATE_SYSTEM['学生管理']['毕业生']['优秀毕业生采集'] = array("edu_youxiubiyesheng_newai.php","优秀毕业生采集");
$PRIVATE_SYSTEM['学生管理']['毕业生']['毕业证管理'] = array("edu_biyezheng_newai.php","毕业证管理");
$PRIVATE_SYSTEM['学生管理']['毕业生']['毕业证发放统计'] = array("edu_biyezheng_tongji.php","毕业证发放统计");
$PRIVATE_SYSTEM['学生管理']['毕业生']['已领毕业证'] = array("BiyezhengStudentFilesFrame.php","已领毕业证");
$PRIVATE_SYSTEM['学生管理']['毕业生']['未领毕业证'] = array("Weiling_BiyezhengStudentFilesFrame.php","未领毕业证");



//人事管理部分
if($软件标准版本!=1)	$PRIVATE_SYSTEM['人力资源']['人事管理']['PARENT'] = array("../XinZhengGuanLi/MAIN_RENSHI.php","人事管理");
if($软件标准版本!=1)	$PRIVATE_SYSTEM['人力资源']['人事管理']['人事档案'] = array("../XinZhengGuanLi/hrms_file_newai.php","人事档案");
if($软件标准版本!=1)	$PRIVATE_SYSTEM['人力资源']['人事管理']['奖惩'] = array("../XinZhengGuanLi/hrms_reward_punishment_newai.php","奖惩管理");
if($软件标准版本!=1)	$PRIVATE_SYSTEM['人力资源']['人事管理']['调动'] = array("../XinZhengGuanLi/hrms_transfer_newai.php","人事调动");
if($软件标准版本!=1)	$PRIVATE_SYSTEM['人力资源']['人事管理']['离职'] = array("../XinZhengGuanLi/hrms_file_lizhi_newai.php","离职管理");
if($软件标准版本!=1)	$PRIVATE_SYSTEM['人力资源']['人事管理']['复职'] = array("../XinZhengGuanLi/hrms_file_fuzhi_newai.php","复职管理");
if($软件标准版本!=1)	$PRIVATE_SYSTEM['人力资源']['人事管理']['职称'] = array("../XinZhengGuanLi/hrms_worker_zhicheng_newai.php","职称评定");
if($软件标准版本!=1)	$PRIVATE_SYSTEM['人力资源']['人事管理']['证照'] = array("../XinZhengGuanLi/hrms_worker_zhengzhao_newai.php","证照管理");
if($软件标准版本!=1)	$PRIVATE_SYSTEM['人力资源']['人事管理']['合同'] = array("../XinZhengGuanLi/hrms_worker_hetong_newai.php","合同管理");
if($软件标准版本!=1)	$PRIVATE_SYSTEM['人力资源']['人事管理']['学习经历'] = array("../XinZhengGuanLi/hrms_educationalexperience_newai.php","学习经历");
if($软件标准版本!=1)	$PRIVATE_SYSTEM['人力资源']['人事管理']['工作经历'] = array("../XinZhengGuanLi/hrms_workexperience_newai.php","工作经历");
if($软件标准版本!=1)	$PRIVATE_SYSTEM['人力资源']['人事管理']['劳动技能'] = array("../XinZhengGuanLi/hrms_laboringskill_newai.php","劳动技能");
if($软件标准版本!=1)	$PRIVATE_SYSTEM['人力资源']['人事管理']['社会关系'] = array("../XinZhengGuanLi/hrms_socialrelation_newai.php","社会关系");


if($软件标准版本!=1)	$PRIVATE_SYSTEM['人力资源']['行政考勤']['PARENT'] = array("../XinZhengGuanLi/MAIN_XINGZHENGKAOQIN.php","行政考勤");
if($软件标准版本!=1)	$PRIVATE_SYSTEM['人力资源']['行政考勤']['组别'] = array("../XinZhengGuanLi/edu_xingzheng_group_newai.php","行政组别设置");
if($软件标准版本!=1)	$PRIVATE_SYSTEM['人力资源']['行政考勤']['班次'] = array("../XinZhengGuanLi/edu_xingzheng_banci_newai.php","行政班次设置");
if($软件标准版本!=1)	$PRIVATE_SYSTEM['人力资源']['行政考勤']['排班'] = array("../XinZhengGuanLi/edu_xingzheng_paiban.php","行政排班设置");
if($软件标准版本!=1)	$PRIVATE_SYSTEM['人力资源']['行政考勤']['原始打卡'] = array("../XinZhengGuanLi/edu_xingzheng_kaoqin_newai.php","原始打卡数据");
if($软件标准版本!=1)	$PRIVATE_SYSTEM['人力资源']['行政考勤']['考勤数据'] = array("../XinZhengGuanLi/edu_xingzheng_kaoqinmingxi_newai.php","考勤数据明细");
if($软件标准版本!=1)	$PRIVATE_SYSTEM['人力资源']['行政考勤']['考勤统计'] = array("../XinZhengGuanLi/edu_xingzheng_kaoqin_static.php","考勤数据统计");
if($软件标准版本!=1)	$PRIVATE_SYSTEM['人力资源']['行政考勤']['流程明细'] = array("../XinZhengGuanLi/edu_xingzheng_workflow.php","考勤数据统计");
if($软件标准版本!=1)	$PRIVATE_SYSTEM['人力资源']['行政考勤']['部门级管理'] = array("../XinZhengGuanLi/my_bumen_xingzheng.php","考勤管理部门级");
if($软件标准版本!=1)	$PRIVATE_SYSTEM['人力资源']['行政考勤']['初始化'] = array("../XinZhengGuanLi/edu_xingzheng_kaoqinmingxi_administrator_change.php","考勤初始化");
if($软件标准版本!=1)	$PRIVATE_SYSTEM['人力资源']['行政考勤']['我的考勤'] = array("../XinZhengGuanLi/my_xingzheng.php","我的行政考勤");
if($软件标准版本!=1)	$PRIVATE_SYSTEM['人力资源']['行政考勤']['考勤机'] = array("../Help/XingzhengKaoQin.php","考勤机使用说明");
if($软件标准版本!=1)	$PRIVATE_SYSTEM['人力资源']['行政考勤']['自动获取'] = array("../XinZhengGuanLi/edu_xingzheng_kaoqinmingxi_automake.php","自动获取考勤机数据");

if($软件标准版本!=1)	$PRIVATE_SYSTEM['人力资源']['人员考核']['PARENT'] = array("../DangWuGuanLi/MAIN_RENYUANKAOHE.php","人员考勤");
if($软件标准版本!=1)	$PRIVATE_SYSTEM['人力资源']['人员考核']['行政人员工作考核登记表'] = array("../DangWuGuanLi/edu_xingzheng_work_check_register_newai.php","行政人员工作考核登记表");
if($软件标准版本!=1)	$PRIVATE_SYSTEM['人力资源']['人员考核']['行政人员年度考核量化表'] = array("../DangWuGuanLi/edu_xingzheng_yearcheck_newai.php","行政人员年度考核量化表");


if($软件标准版本!=1)	$PRIVATE_SYSTEM['人力资源']['党员管理']['PARENT'] = array("../DangWuGuanLi/RLZY_MAIN_DANGWU.php","党员管理");
if($软件标准版本!=1)	$PRIVATE_SYSTEM['人力资源']['党员管理']['党员管理'] =array("../DangWuGuanLi/edu_teacher_partymember_newai.php","党员管理");
if($软件标准版本!=1)	$PRIVATE_SYSTEM['人力资源']['党员管理']['党费缴纳'] = array("../DangWuGuanLi/edu_teacher_partyfee_newai.php","党费缴纳");
if($软件标准版本!=1)	$PRIVATE_SYSTEM['人力资源']['党员管理']['缴纳统计'] = array("../DangWuGuanLi/teacher_partyfeein.static.php","缴纳统计");
if($软件标准版本!=1)	$PRIVATE_SYSTEM['人力资源']['党员管理']['预备党员'] = array("../DangWuGuanLi/edu_teacher_partymember2_newai.php","预备党员");
if($软件标准版本!=1)	$PRIVATE_SYSTEM['人力资源']['党员管理']['党组织活动'] = array("../DangWuGuanLi/xingzheng_partyactive_newai.php","党组织活动");
if($软件标准版本!=1)	$PRIVATE_SYSTEM['人力资源']['党员管理']['党支部管理'] = array("../DangWuGuanLi/xingzheng_partyunit_newai.php","党支部管理");
if($软件标准版本!=1)	$PRIVATE_SYSTEM['人力资源']['党员管理']['党员状态'] = array("../DangWuGuanLi/xingzheng_partystatus_newai.php","党员状态");
if($软件标准版本!=1)	$PRIVATE_SYSTEM['人力资源']['党员管理']['党员年度量化考核']=array("../DangWuGuanLi/edu_dangyuan_yearcheck_newai.php","党员年度量化考核");
if($软件标准版本!=1)	$PRIVATE_SYSTEM['人力资源']['党员管理']['民主评议党员登记表']=array("../DangWuGuanLi/edu_dangyuan_work_check_register_newai.php","民主评议党员登记表");



if($软件标准版本!=1)	$PRIVATE_SYSTEM['人力资源']['干部测评']['PARENT'] = array("../XinZhengGuanLi/MAIN_GANBUCEPING.php","行政考勤");
if($软件标准版本!=1)	$PRIVATE_SYSTEM['人力资源']['干部测评']['测评项目管理'] = array("../zhongcengpingce/edu_zhongcengceping_newai.php","测评项目管理");
if($软件标准版本!=1)	$PRIVATE_SYSTEM['人力资源']['干部测评']['人事部门设置'] = array("../zhongcengpingce/edu_zhongcenggangweishezhi_newai.php","人事部门设置");
if($软件标准版本!=1)	$PRIVATE_SYSTEM['人力资源']['干部测评']['设置我的自评'] = array("../zhongcengpingce/edu_zhongcengmyziping_newai.php","设置我的自评");
if($软件标准版本!=1)	$PRIVATE_SYSTEM['人力资源']['干部测评']['参与干部测评'] = array("../zhongcengpingce/edu_zhongcengcanyupingce_newai.php","参与干部测评");
if($软件标准版本!=1)	$PRIVATE_SYSTEM['人力资源']['干部测评']['查看我的测评'] = array("../zhongcengpingce/edu_zhongcengviewceping_newai.php","查看我的测评");
if($软件标准版本!=1)	$PRIVATE_SYSTEM['人力资源']['干部测评']['干部测评统计'] = array("../zhongcengpingce/edu_zhongcengtognji_newai.php","干部测评统计");
if($软件标准版本!=1)	$PRIVATE_SYSTEM['人力资源']['干部测评']['测评内容明细'] = array("../zhongcengpingce/edu_zhongcengmingxi_newai.php","测评内容明细");
if($软件标准版本!=1)	$PRIVATE_SYSTEM['人力资源']['干部测评']['测评项目设置'] = array("../zhongcengpingce/edu_zhongcengxingmu_newai.php","测评项目设置");

if($软件标准版本!=1)	$PRIVATE_SYSTEM['人力资源']['招聘管理']['PARENT'] = array("../XinZhengGuanLi/MAIN_ZHAOPIN.php","招聘管理");
if($软件标准版本!=1)	$PRIVATE_SYSTEM['人力资源']['招聘管理']['招聘计划'] = array("../XinZhengGuanLi/hrms_zpjihua_newai.php","招聘计划");
if($软件标准版本!=1)	$PRIVATE_SYSTEM['人力资源']['招聘管理']['招聘计划审批'] = array("../XinZhengGuanLi/hrms_zpjihua_shenpi_newai.php","招聘计划审批");
if($软件标准版本!=1)	$PRIVATE_SYSTEM['人力资源']['招聘管理']['招聘人才库'] = array("../XinZhengGuanLi/hrms_zprencaiku_newai.php","招聘人才库");
if($软件标准版本!=1)	$PRIVATE_SYSTEM['人力资源']['招聘管理']['招聘录用'] = array("../XinZhengGuanLi/hrms_file_luyong_newai.php","招聘录用");

if($软件标准版本!=1)	$PRIVATE_SYSTEM['人力资源']['薪酬管理']['PARENT'] = array("../XinZhengGuanLi/MAIN_XINCHOU.php","薪酬管理");
if($软件标准版本!=1)	$PRIVATE_SYSTEM['人力资源']['薪酬管理']['我的工资福利'] = array("../XinZhengGuanLi/hrms_salary_detail_newai.php","我的工资福利");
if($软件标准版本!=1)	$PRIVATE_SYSTEM['人力资源']['薪酬管理']['工资福利设置'] = array("../XinZhengGuanLi/hrms_salary_type.php","工资福利设置");
if($软件标准版本!=1)	$PRIVATE_SYSTEM['人力资源']['薪酬管理']['薪酬分组设置'] = array("../XinZhengGuanLi/hrms_salary_group_newai.php","薪酬分组设置");
if($软件标准版本!=1)	$PRIVATE_SYSTEM['人力资源']['薪酬管理']['薪酬设置'] = array("../XinZhengGuanLi/hrms_salary_newai.php","薪酬设置");
if($软件标准版本!=1)	$PRIVATE_SYSTEM['人力资源']['薪酬管理']['薪酬统计'] = array("../XinZhengGuanLi/hrms_salary_tongji_newai.php","薪酬统计");

if($软件标准版本!=1)	$PRIVATE_SYSTEM['人力资源']['日常费用']['PARENT'] = array("../XinZhengGuanLi/MAIN_FEIYONG.php","日常费用");
if($软件标准版本!=1)	$PRIVATE_SYSTEM['人力资源']['日常费用']['费用明细'] = array("../XinZhengGuanLi/hrms_expense_newai.php","费用明细");
if($软件标准版本!=1)	$PRIVATE_SYSTEM['人力资源']['日常费用']['费用类型'] = array("../XinZhengGuanLi/hrms_expense_type_newai.php","费用类型");

if($软件标准版本!=1)	$PRIVATE_SYSTEM['人力资源']['节假日值班'] = array("../XinZhengGuanLi/edu_zhiban_newai.php","节假日值班");



$PRIVATE_SYSTEM['后勤管理']['办公用品']['PARENT']		= array("../officeproduct/MAIN_OFFICEPRODUCT.php","办公用品");
$PRIVATE_SYSTEM['后勤管理']['办公用品']['办公用品查阅'] = array("../officeproduct/officeproduct_view.php","办公用品查阅");
$PRIVATE_SYSTEM['后勤管理']['办公用品']['办公用品管理'] = array("../officeproduct/officeproduct_newai.php","办公用品管理");
$PRIVATE_SYSTEM['后勤管理']['办公用品']['操作明细']		= array("../officeproduct/officeproduct_admin.php","办公用品操作明细");
$PRIVATE_SYSTEM['后勤管理']['办公用品']['仓库设置']		= array("../officeproduct/officeproductcangku_newai.php","办公用品仓库设置");
$PRIVATE_SYSTEM['后勤管理']['办公用品']['仓库统计']		= array("../officeproduct/officeproduct_tongji.php","办公用品仓库统计");
$PRIVATE_SYSTEM['后勤管理']['办公用品']['分项统计']		= array("../officeproduct/officeproduct_fenxiang.php","办公用品分项统计");
$PRIVATE_SYSTEM['后勤管理']['办公用品']['分类设置']		= array("../officeproduct/officeproductgroup_newai.php","办公用品分类设置");

$PRIVATE_SYSTEM['后勤管理']['固定资产']['PARENT']		= array("MAIN_FIXEDASSET.php","固定资产");
$PRIVATE_SYSTEM['后勤管理']['固定资产']['全权限管理']	= array("fixedasset_newai.php","固定资产全权限管理");
$PRIVATE_SYSTEM['后勤管理']['固定资产']['资产管理员'] = array("fixedasset_admin_newai.php","固定资产管理员");
$PRIVATE_SYSTEM['后勤管理']['固定资产']['部门级管理']	= array("fixedasset_department_newai.php","固定资产部门级管理");
$PRIVATE_SYSTEM['后勤管理']['固定资产']['操作明细']		= array("admin_fixedasset.php","固定资产操作明细");
$PRIVATE_SYSTEM['后勤管理']['固定资产']['部门总括统计'] = array("fixedasset_tongjijianjie.php","固定资产部门总括统计");
$PRIVATE_SYSTEM['后勤管理']['固定资产']['部门明细统计'] = array("fixedasset_tongji.php","固定资产部门明细统计");
$PRIVATE_SYSTEM['后勤管理']['固定资产']['按批次统计']	= array("fixedasset_pici.php","固定资产按批次统计");
$PRIVATE_SYSTEM['后勤管理']['固定资产']['己报废资产']	= array("fixedasset_baofei.php","固定资产己报废资产");
$PRIVATE_SYSTEM['后勤管理']['固定资产']['分类设置']		= array("fixedassetgroup_newai.php","固定资产分类设置");
$PRIVATE_SYSTEM['后勤管理']['固定资产']['部门权限管理'] = array("inc_fixedasset_priv.php","固定资产部门权限管理");

$PRIVATE_SYSTEM['后勤管理']['公物维修']['PARENT']	= array("../WuYeGuanLi/MAIN_WYGL.php","公物维修");
$PRIVATE_SYSTEM['后勤管理']['公物维修']['报修信息'] = array("../WuYeGuanLi/wygl_baoxiuxinxi1_newai.php","报修信息");
$PRIVATE_SYSTEM['后勤管理']['公物维修']['报修受理'] = array("../WuYeGuanLi/wygl_baoxiuxinxi2_newai.php","报修受理");
$PRIVATE_SYSTEM['后勤管理']['公物维修']['确认维修'] = array("../WuYeGuanLi/wygl_baoxiuxinxi3_newai.php","确认维修");
$PRIVATE_SYSTEM['后勤管理']['公物维修']['用料登记'] = array("../WuYeGuanLi/wygl_baoxiuxinxi4_newai.php","用料登记");
$PRIVATE_SYSTEM['后勤管理']['公物维修']['费用结算'] = array("../WuYeGuanLi/wygl_baoxiuxinxi5_newai.php","费用结算");
$PRIVATE_SYSTEM['后勤管理']['公物维修']['服务评价'] = array("../WuYeGuanLi/wygl_weixiupingjia_newai.php","服务评价");
$PRIVATE_SYSTEM['后勤管理']['公物维修']['类型设置'] = array("../WuYeGuanLi/MAIN_SETTING.php","类型设置");
$PRIVATE_SYSTEM['后勤管理']['公物维修']['楼房设置'] = array("../WuYeGuanLi/MAIN_BUILDING.php","楼房设置");


//评测管理
/*新加的*/
if($软件标准版本!=1)	$PRIVATE_SYSTEM['教学测评体系']['督导评学院']['PARENT'] = array("MENU_zhuanjia_xueyuan.php","督导评学院");
if($软件标准版本!=1)	$PRIVATE_SYSTEM['教学测评体系']['督导评学院']['督导评价二级学院'] = array("../CEPING/zhuanjia_xueyuan.php","督导评价二级学院");
if($软件标准版本!=1)	$PRIVATE_SYSTEM['教学测评体系']['督导评学院']['新建评测名称'] = array("../CEPING/ceping_zhuanjia_xueyuan_mingcheng_newai.php","新建评测名称");
if($软件标准版本!=1)	$PRIVATE_SYSTEM['教学测评体系']['督导评学院']['评测结构设计'] = array("../CEPING/ceping_zhuanjia_xueyuan_jiegou_newai.php","评测结构设计");
if($软件标准版本!=1)	$PRIVATE_SYSTEM['教学测评体系']['督导评学院']['汇总统计查询'] = array("../CEPING/dudao_xueyuan_zong_serch.php","汇总统计查询");
if($软件标准版本!=1)	$PRIVATE_SYSTEM['教学测评体系']['督导评学院']['结构明细查询'] = array("../CEPING/dudao_xueyuan_jiegou_serch.php","结构明细查询");
if($软件标准版本!=1)	$PRIVATE_SYSTEM['教学测评体系']['督导评学院']['未评测人员查询'] = array("../CEPING/dudao_xueyuan_no_serch.php","未评测人员查询");
//if($软件标准版本!=1)	$PRIVATE_SYSTEM['教学测评体系']['督导评学院']['未评测学生查询'] = array("../CEPING/search_mingxi_xuesheng.php","未评测学生查询");



if($软件标准版本!=1)	$PRIVATE_SYSTEM['教学测评体系']['督导评教研室']['PARENT'] = array("MENU_zhuanjia_jiaoyanshi.php","督导评教研室");
if($软件标准版本!=1)	$PRIVATE_SYSTEM['教学测评体系']['督导评教研室']['督导评价教研室'] = array("../CEPING/zhuanjia_jiaoyanshi.php","督导评价教研室");
if($软件标准版本!=1)	$PRIVATE_SYSTEM['教学测评体系']['督导评教研室']['新建评测名称'] = array("../CEPING/ceping_zhuanjia_jiaoyanshi_mingcheng_newai.php","新建评测名称");
if($软件标准版本!=1)	$PRIVATE_SYSTEM['教学测评体系']['督导评教研室']['评测结构设计'] = array("../CEPING/ceping_zhuanjia_jiaoyanshi_jiegou_newai.php","评测结构设计");
if($软件标准版本!=1)	$PRIVATE_SYSTEM['教学测评体系']['督导评教研室']['汇总统计查询'] = array("../CEPING/dudao_jiaoyanshi_zong_serch.php","汇总统计查询");
if($软件标准版本!=1)	$PRIVATE_SYSTEM['教学测评体系']['督导评教研室']['结构明细查询'] = array("../CEPING/dudao_jiaoyanshi_jiegou_serch.php","结构明细查询");
if($软件标准版本!=1)	$PRIVATE_SYSTEM['教学测评体系']['督导评教研室']['未评测人员查询'] = array("../CEPING/dudao_jiaoyanshi_no_serch.php","未评测人员查询");


if($软件标准版本!=1)	$PRIVATE_SYSTEM['教学测评体系']['督导评教师']['PARENT'] = array("MENU_zhuanjia_jiaoshi.php","督导评教师");
if($软件标准版本!=1)	$PRIVATE_SYSTEM['教学测评体系']['督导评教师']['督导评价教师'] = array("../CEPING/zhuanjia_jiaoshi.php","督导评价教师");
if($软件标准版本!=1)	$PRIVATE_SYSTEM['教学测评体系']['督导评教师']['新建评测名称'] = array("../CEPING/ceping_zhuanjia_jiaoshi_mingcheng_newai.php","新建评测名称");
if($软件标准版本!=1)	$PRIVATE_SYSTEM['教学测评体系']['督导评教师']['评测结构设计'] = array("../CEPING/ceping_zhuanjia_jiaoshi_jiegou_newai.php","评测结构设计");
if($软件标准版本!=1)	$PRIVATE_SYSTEM['教学测评体系']['督导评教师']['汇总统计查询'] = array("../CEPING/dudao_jiaoshi_zong_serch.php","汇总统计查询");
if($软件标准版本!=1)	$PRIVATE_SYSTEM['教学测评体系']['督导评教师']['结构明细查询'] = array("../CEPING/dudao_jiaoshi_jiegou_serch.php","结构明细查询");
if($软件标准版本!=1)	$PRIVATE_SYSTEM['教学测评体系']['督导评教师']['未评测人员查询'] = array("../CEPING/dudao_jiaoshi_no_serch.php","未评测人员查询");


if($软件标准版本!=1)	$PRIVATE_SYSTEM['教学测评体系']['领导评学院']['PARENT'] = array("MENU_lingdao_xueyuan.php","领导评学院");
if($软件标准版本!=1)	$PRIVATE_SYSTEM['教学测评体系']['领导评学院']['领导评价二级学院'] = array("../CEPING/lingdao_erjixueyuan.php","领导评价二级学院");
if($软件标准版本!=1)	$PRIVATE_SYSTEM['教学测评体系']['领导评学院']['新建评测名称'] = array("../CEPING/ceping_lingdao_xueyuan_mingcheng_newai.php","新建评测名称");
if($软件标准版本!=1)	$PRIVATE_SYSTEM['教学测评体系']['领导评学院']['评测结构设计'] = array("../CEPING/ceping_lingdao_xueyuan_jiegou_newai.php","评测结构设计");
if($软件标准版本!=1)	$PRIVATE_SYSTEM['教学测评体系']['领导评学院']['汇总统计查询'] = array("../CEPING/lingdao_xueyuan_zong_serch.php","汇总统计查询");
if($软件标准版本!=1)	$PRIVATE_SYSTEM['教学测评体系']['领导评学院']['结构明细查询'] = array("../CEPING/lingdao_xueyuan_jiegou_serch.php","结构明细查询");
if($软件标准版本!=1)	$PRIVATE_SYSTEM['教学测评体系']['领导评学院']['未评测人员查询'] = array("../CEPING/lingdao_xueyuan_no_serch.php","未评测人员查询");


if($软件标准版本!=1)	$PRIVATE_SYSTEM['教学测评体系']['领导评教研室']['PARENT'] = array("MENU_lingdao_jiaoyanshi.php","领导评教研室");
if($软件标准版本!=1)	$PRIVATE_SYSTEM['教学测评体系']['领导评教研室']['领导评价教研室'] = array("../CEPING/lingdao_jiaoyanshi.php","领导评价教研室");
if($软件标准版本!=1)	$PRIVATE_SYSTEM['教学测评体系']['领导评教研室']['新建评测名称'] = array("../CEPING/ceping_lingdao_jiaoyanshi_mingcheng_newai.php","新建评测名称");
if($软件标准版本!=1)	$PRIVATE_SYSTEM['教学测评体系']['领导评教研室']['评测结构设计'] = array("../CEPING/ceping_lingdao_jiaoyanshi_jiegou_newai.php","评测结构设计");
if($软件标准版本!=1)	$PRIVATE_SYSTEM['教学测评体系']['领导评教研室']['汇总统计查询'] = array("../CEPING/lingdao_jiaoyanshi_zong_serch.php","汇总统计查询");
if($软件标准版本!=1)	$PRIVATE_SYSTEM['教学测评体系']['领导评教研室']['结构明细查询'] = array("../CEPING/lingdao_jiaoyanshi_jiegou_serch.php","结构明细查询");
if($软件标准版本!=1)	$PRIVATE_SYSTEM['教学测评体系']['领导评教研室']['未评测人员查询'] = array("../CEPING/lingdao_jiaoyanshi_no_serch.php","未评测人员查询");



if($软件标准版本!=1)	$PRIVATE_SYSTEM['教学测评体系']['领导评教师']['PARENT'] = array("MENU_lingdao_jiaoshi.php","领导评教师");
if($软件标准版本!=1)	$PRIVATE_SYSTEM['教学测评体系']['领导评教师']['领导评价教师'] = array("../CEPING/lingdao_jiaoshi.php","领导评价教师");
if($软件标准版本!=1)	$PRIVATE_SYSTEM['教学测评体系']['领导评教师']['新建评测名称'] = array("../CEPING/ceping_lingdao_jiaoshi_mingcheng_newai.php","新建评测名称");
if($软件标准版本!=1)	$PRIVATE_SYSTEM['教学测评体系']['领导评教师']['评测结构设计'] = array("../CEPING/ceping_lingdao_jiaoshi_jiegou_newai.php","评测结构设计");
if($软件标准版本!=1)	$PRIVATE_SYSTEM['教学测评体系']['领导评教师']['汇总统计查询'] = array("../CEPING/lingdao_jiaoshi_zong_serch.php","汇总统计查询");
if($软件标准版本!=1)	$PRIVATE_SYSTEM['教学测评体系']['领导评教师']['结构明细查询'] = array("../CEPING/lingdao_jiaoshi_jiegou_serch.php","结构明细查询");
if($软件标准版本!=1)	$PRIVATE_SYSTEM['教学测评体系']['领导评教师']['未评测人员查询'] = array("../CEPING/lingdao_jiaoshi_no_serch.php","未评测人员查询");



if($软件标准版本!=1)	$PRIVATE_SYSTEM['教学测评体系']['教师评同行']['PARENT'] = array("MENU_jiaoshi_tonghang.php","教师评同行");
if($软件标准版本!=1)	$PRIVATE_SYSTEM['教学测评体系']['教师评同行']['教师评价同行'] = array("../CEPING/jiaoshi_tonghang.php","教师评价同行");
if($软件标准版本!=1)	$PRIVATE_SYSTEM['教学测评体系']['教师评同行']['新建评测名称'] = array("../CEPING/ceping_jiaoshi_tonghang_mingcheng_newai.php","新建评测名称");
if($软件标准版本!=1)	$PRIVATE_SYSTEM['教学测评体系']['教师评同行']['评测结构设计'] = array("../CEPING/ceping_jiaoshi_tonghang_jiegou_newai.php","评测结构设计");
if($软件标准版本!=1)	$PRIVATE_SYSTEM['教学测评体系']['教师评同行']['汇总统计查询'] = array("../CEPING/jiaoshi_tonghang_zong_serch.php","汇总统计查询");
if($软件标准版本!=1)	$PRIVATE_SYSTEM['教学测评体系']['教师评同行']['结构明细查询'] = array("../CEPING/jiaoshi_tonghang_jiegou_serch.php","结构明细查询");
if($软件标准版本!=1)	$PRIVATE_SYSTEM['教学测评体系']['教师评同行']['未评测人员查询'] = array("../CEPING/jiaoshi_tonghang_no_serch.php","未评测人员查询");


if($软件标准版本!=1)	$PRIVATE_SYSTEM['教学测评体系']['教师自评']['PARENT']        = array("MENU_jiaoshi_ziping.php","教师自评");
if($软件标准版本!=1)	$PRIVATE_SYSTEM['教学测评体系']['教师自评']['教师自评']      = array("../CEPING/jiaoshi_jiaoshi.php","教师自评");
if($软件标准版本!=1)	$PRIVATE_SYSTEM['教学测评体系']['教师自评']['新建评测名称']  = array("../CEPING/ceping_jiaoshi_ziping_mingcheng_newai.php","新建评测名称");
if($软件标准版本!=1)	$PRIVATE_SYSTEM['教学测评体系']['教师自评']['评测结构设计']  = array("../CEPING/ceping_jiaoshi_ziping_jiegou_newai.php","评测结构设计");
if($软件标准版本!=1)	$PRIVATE_SYSTEM['教学测评体系']['教师自评']['汇总统计查询']  = array("../CEPING/jiaoshi_ziping_zong_serch.php","汇总统计查询");
if($软件标准版本!=1)	$PRIVATE_SYSTEM['教学测评体系']['教师自评']['结构明细查询'] = array("../CEPING/jiaoshi_ziping_jiegou_serch.php","结构明细查询");
//if($软件标准版本!=1)	$PRIVATE_SYSTEM['教学测评体系']['教师自评']['未评测人员查询']   = array("../CEPING/jiaoshi_ziping_no_serch.php","未评测人员查询");


if($软件标准版本!=1)	$PRIVATE_SYSTEM['教学测评体系']['教师评班级']['PARENT']  = array("MENU_jiaoshi_banji.php","教师评班级");
if($软件标准版本!=1)	$PRIVATE_SYSTEM['教学测评体系']['教师评班级']['教师评价班级']  = array("../CEPING/jiaoshi_banji.php","教师评价班级");
if($软件标准版本!=1)	$PRIVATE_SYSTEM['教学测评体系']['教师评班级']['新建评测名称'] = array("../CEPING/ceping_jiaoshi_banji_mingcheng_newai.php","新建评测名称");
if($软件标准版本!=1)	$PRIVATE_SYSTEM['教学测评体系']['教师评班级']['评测结构设计'] = array("../CEPING/ceping_jiaoshi_banji_jiegou_newai.php","评测结构设计");
if($软件标准版本!=1)	$PRIVATE_SYSTEM['教学测评体系']['教师评班级']['汇总统计查询'] = array("../CEPING/jiaoshi_banji_zong_serch.php","汇总统计查询");
if($软件标准版本!=1)	$PRIVATE_SYSTEM['教学测评体系']['教师评班级']['结构明细查询'] = array("../CEPING/jiaoshi_banji_jiegou_serch.php","结构明细查询");
if($软件标准版本!=1)	$PRIVATE_SYSTEM['教学测评体系']['教师评班级']['未评测人员查询']   = array("../CEPING/jiaoshi_banji_no_serch.php","未评测人员查询");


if($软件标准版本!=1)	$PRIVATE_SYSTEM['教学测评体系']['学生评老师']['PARENT']  = array("MENU_xuesheng_jiaoshi.php","学生评老师");
if($软件标准版本!=1)	$PRIVATE_SYSTEM['教学测评体系']['学生评老师']['新建评测名称'] = array("../CEPING/ceping_xuesheng_jiaoshi_mingcheng_newai.php","新建评测名称");
if($软件标准版本!=1)	$PRIVATE_SYSTEM['教学测评体系']['学生评老师']['评测结构设计'] = array("../CEPING/ceping_xuesheng_jiaoshi_jiegou_newai.php","评测结构设计");
if($软件标准版本!=1)	$PRIVATE_SYSTEM['教学测评体系']['学生评老师']['汇总统计查询'] = array("../CEPING/xuesheng_jiaoshi_zong_serch.php","汇总统计查询");
if($软件标准版本!=1)	$PRIVATE_SYSTEM['教学测评体系']['学生评老师']['结构明细查询'] = array("../CEPING/xuesheng_jiaoshi_jiegou_serch.php","结构明细查询");
if($软件标准版本!=1)	$PRIVATE_SYSTEM['教学测评体系']['学生评老师']['未评测人员查询']   = array("../CEPING/xuesheng_jiaoshi_no_serch.php","未评测人员查询");


if($软件标准版本!=1)	$PRIVATE_SYSTEM['教学测评体系']['开始测评']['PARENT']			= array("MAIN_CEPING_PINGJIA.php","教师评班级");
if($软件标准版本!=1)	$PRIVATE_SYSTEM['教学测评体系']['开始测评']['督导评价二级学院'] = array("../CEPING/zhuanjia_xueyuan.php","督导评价二级学院");
if($软件标准版本!=1)	$PRIVATE_SYSTEM['教学测评体系']['开始测评']['督导评价教研室']	= array("../CEPING/zhuanjia_jiaoyanshi.php","督导评价教研室");
if($软件标准版本!=1)	$PRIVATE_SYSTEM['教学测评体系']['开始测评']['督导评价教师']		= array("../CEPING/zhuanjia_jiaoshi.php","督导评价教师");
if($软件标准版本!=1)	$PRIVATE_SYSTEM['教学测评体系']['开始测评']['领导评价二级学院'] = array("../CEPING/lingdao_erjixueyuan.php","领导评价二级学院");
if($软件标准版本!=1)	$PRIVATE_SYSTEM['教学测评体系']['开始测评']['领导评价教研室']	= array("../CEPING/lingdao_jiaoyanshi.php","领导评价教研室");
if($软件标准版本!=1)	$PRIVATE_SYSTEM['教学测评体系']['开始测评']['领导评价教师']		= array("../CEPING/lingdao_jiaoshi.php","领导评价教师");
if($软件标准版本!=1)	$PRIVATE_SYSTEM['教学测评体系']['开始测评']['教师评价同行']		= array("../CEPING/jiaoshi_tonghang.php","教师评价同行");
if($软件标准版本!=1)	$PRIVATE_SYSTEM['教学测评体系']['开始测评']['教师自评']			= array("../CEPING/jiaoshi_jiaoshi.php","教师自评");
if($软件标准版本!=1)	$PRIVATE_SYSTEM['教学测评体系']['开始测评']['教师评价班级']		= array("../CEPING/jiaoshi_banji.php","教师评价班级");
if($软件标准版本!=1)	$PRIVATE_SYSTEM['教学测评体系']['开始测评']['评测结果统计']		= array("../Teacher/edu_PingceAllInfor.php","评测结果统计");



if($软件标准版本!=1)	$PRIVATE_SYSTEM['教学测评体系']['评测设定']['PARENT'] = array("NewPINGCE_SHEZHI.php","评测设定");
if($软件标准版本!=1)	$PRIVATE_SYSTEM['教学测评体系']['评测设定']['评测分组'] = array("../CEPING/ceping_renyuan_grop_newai.php","评测分组");
if($软件标准版本!=1)	$PRIVATE_SYSTEM['教学测评体系']['评测设定']['评测结构'] = array("../CEPING/ceping_jiegou_newai.php","评测结构");
if($软件标准版本!=1)	$PRIVATE_SYSTEM['教学测评体系']['评测设定']['评测种类'] = array("../CEPING/ceping_zhonglei_newai.php","评测种类");
if($软件标准版本!=1)	$PRIVATE_SYSTEM['教学测评体系']['评测设定']['评测名称'] = array("../CEPING/ceping_mingcheng_newai.php","评测名称");
if($软件标准版本!=1)	$PRIVATE_SYSTEM['教学测评体系']['评测设定']['测评分数设定'] = array("../CEPING/ceping_fenshu_newai.php","测评分数设定");
//if($软件标准版本!=1)	$PRIVATE_SYSTEM['教学测评体系']['评测设定']['评价对象'] = array("../CEPING/ceping_pingjiaduixiang_newai.php","评价对象");
//if($软件标准版本!=1)	$PRIVATE_SYSTEM['教学测评体系']['评测设定']['评价查询'] = array("../CEPING/search.php","评价查询");


//在线报名考试
$PRIVATE_SYSTEM['在线报名考试']['在线报名']['PARENT']			= array("../ZAIXIANKAOSHI/MAIN_ZAIXIANBAOMING.php","在线报名");
$PRIVATE_SYSTEM['在线报名考试']['在线报名']['在线报名类型管理'] = array("../ZAIXIANKAOSHI/edu_baomingtype_newai.php","在线报名类型管理");
$PRIVATE_SYSTEM['在线报名考试']['在线报名']['在线报名项目管理'] = array("../ZAIXIANKAOSHI/edu_baomingname_newai.php","在线报名项目管理");
$PRIVATE_SYSTEM['在线报名考试']['在线报名']['学生报名明细记录'] = array("../ZAIXIANKAOSHI/edu_baomingdetail_newai.php","学生报名明细记录");
$PRIVATE_SYSTEM['在线报名考试']['在线报名']['在线报名统计管理'] = array("../ZAIXIANKAOSHI/edu_baomingdetail_static.php","在线报名统计管理");

$PRIVATE_SYSTEM['在线报名考试']['题库卷库']['PARENT']	= array("../ZAIXIANKAOSHI/MAIN_TIKUJUANKU.php","题库卷库");
$PRIVATE_SYSTEM['在线报名考试']['题库卷库']['所属课程信息']	= array("../ZAIXIANKAOSHI/tiku_kecheng_newai.php","所属课程信息");
$PRIVATE_SYSTEM['在线报名考试']['题库卷库']['试题信息管理'] = array("../ZAIXIANKAOSHI/tiku_shiti_newai.php","试题信息管理");
$PRIVATE_SYSTEM['在线报名考试']['题库卷库']['试卷信息管理'] = array("../ZAIXIANKAOSHI/tiku_shijuan_newai.php","试卷信息管理");
$PRIVATE_SYSTEM['在线报名考试']['题库卷库']['试卷考题生成'] = array("../ZAIXIANKAOSHI/tiku_shiti_makeexec.php","试卷考题生成");
$PRIVATE_SYSTEM['在线报名考试']['题库卷库']['试卷考题明细'] = array("../ZAIXIANKAOSHI/tiku_shijuanku_newai.php","试卷考题明细");
$PRIVATE_SYSTEM['在线报名考试']['题库卷库']['考试信息管理'] = array("../ZAIXIANKAOSHI/tiku_kaoshi_newai.php","考试信息管理");
$PRIVATE_SYSTEM['在线报名考试']['题库卷库']['试题难易程度'] = array("../ZAIXIANKAOSHI/tiku_shitinanyi_newai.php","试题难易程度");
$PRIVATE_SYSTEM['在线报名考试']['题库卷库']['试题题目类型'] = array("../ZAIXIANKAOSHI/tiku_shititype_newai.php","试题题目类型");

$PRIVATE_SYSTEM['在线报名考试']['在线考试']['PARENT']	= array("../ZAIXIANKAOSHI/MAIN_KAOSHI.php","在线考试");
$PRIVATE_SYSTEM['在线报名考试']['在线考试']['考试信息管理']	= array("../ZAIXIANKAOSHI/tiku_kaoshi_newai.php","考试信息管理");
$PRIVATE_SYSTEM['在线报名考试']['在线考试']['学生考试明细'] = array("../ZAIXIANKAOSHI/tiku_examdata_newai.php","学生考试明细");
$PRIVATE_SYSTEM['在线报名考试']['在线考试']['学生考试成绩'] = array("../ZAIXIANKAOSHI/tiku_examdata_static.php","学生考试成绩");

//第十三菜单部分
$PRIVATE_SYSTEM['财务收费管理']['学生收费'] = array("ShouFei.php","学生收费");
$PRIVATE_SYSTEM['财务收费管理']['收费标准设置'] = array("edu_zhuanyeshoufei.php","收费标准设置");
$PRIVATE_SYSTEM['财务收费管理']['收据打印'] = array("edu_shoufeidanprint_newai.php","收据打印");
$PRIVATE_SYSTEM['财务收费管理']['收据删除'] = array("edu_shoufeidanprintdelete_newai.php","收据打印");
//$PRIVATE_SYSTEM['财务收费管理']['收退费明细'] = array("edu_caiwuxianjin.php","收退费明细");
//$PRIVATE_SYSTEM['财务收费管理']['账户日记账'] = array("StudentFeeCashFlow.php","账户日记账");
//$PRIVATE_SYSTEM['财务收费管理']['费用支出明细'] = array("edu_qitazhichu_newai.php","费用支出明细");
//$PRIVATE_SYSTEM['财务收费管理']['款项收入明细'] = array("edu_qitashouru_newai.php","款项收入明细");
//$PRIVATE_SYSTEM['财务收费管理']['费用支出类型'] = array("dict_zhichuleibie_newai.php","费用支出类型");
//$PRIVATE_SYSTEM['财务收费管理']['款项收入类型'] = array("dict_shouruleibie_newai.php","款项收入类型");

$PRIVATE_SYSTEM['财务收费管理']['交费明细'] = array("Caiwu.php","交费明细");
$PRIVATE_SYSTEM['财务收费管理']['欠费统计'] = array("StudentFeehistory_Main.php","欠费统计");
$PRIVATE_SYSTEM['财务收费管理']['收费设定'] = array("edu_caiwusetting.php","收费设定");
$PRIVATE_SYSTEM['财务收费管理']['调整学生收费标准'] = array("edu_student_shoufeibiaozhun.php","调整学生收费标准");
//$PRIVATE_SYSTEM['财务收费管理']['发票领用'] = array("edu_fapiao.php","发票领用");



//第十三菜单部分
$PRIVATE_SYSTEM['综合信息查询']['学生信息查询'] = array("../InforSearch/StudentInfor.php","学生信息查询");
$PRIVATE_SYSTEM['综合信息查询']['班级信息查询'] = array("../InforSearch/BanJiInfor.php","班级信息查询");
$PRIVATE_SYSTEM['综合信息查询']['教师信息查询'] = array("../InforSearch/TeacherInfor.php","教师信息查询");
$PRIVATE_SYSTEM['综合信息查询']['学校基本信息'] = array("../EDU/InforSchool.php","学校基本信息查询");
$PRIVATE_SYSTEM['综合信息查询']['班级学生统计'] = array("../EDU/InforSchool1.php","班级学生统计查询");

$PRIVATE_SYSTEM['综合信息查询']['后勤管理查询']['PARENT']	= array("../InforSearch/MAIN_HOUQIN.php","后勤管理");
$PRIVATE_SYSTEM['综合信息查询']['后勤管理查询']['办公用品'] = array("../InforSearch/my_officeproduct.php","办公用品");
$PRIVATE_SYSTEM['综合信息查询']['后勤管理查询']['固定资产'] = array("../InforSearch/my_fixedasset.php","固定资产");
$PRIVATE_SYSTEM['综合信息查询']['后勤管理查询']['物业管理'] = array("../InforSearch/my_wuyeguanli.php","物业管理");


//第七菜单部分
if($_SESSION['SYSTEM_IS_TD_OA']=="0")									{
	$PRIVATE_SYSTEM['数字化校园系统设置']['组织机构设置'] = array("../Framework/MAIN_UNIT.php","组织机构设置");
}
$PRIVATE_SYSTEM['数字化校园系统设置']['数据库管理']		= array("database_setting.php","数据库管理");
$PRIVATE_SYSTEM['数字化校园系统设置']['数字化校园权限'] = array("systemprivateview.php","权限");
$PRIVATE_SYSTEM['数字化校园系统设置']['学生菜单权限']	= array("student_systemprivateview.php","学生菜单权限");
$PRIVATE_SYSTEM['数字化校园系统设置']['数字化校园授权'] = array("../../Framework/system_infor.php","授权信息");
$PRIVATE_SYSTEM['数字化校园系统设置']['在线升级系统']	= array("../../databackup/update.php","数字化校园在线升级");
//$PRIVATE_SYSTEM['数字化校园系统设置']['界面'] = array("../../Framework/systemlang_newai.php","界面语言");
$PRIVATE_SYSTEM['数字化校园系统设置']['时效性模块'] = array("edu_banzhuren_manager.php","时效性模块设置");
$PRIVATE_SYSTEM['数字化校园系统设置']['数据字典']	= array("StudentFileSetting.php","数据字典设置");
$PRIVATE_SYSTEM['数字化校园系统设置']['单点登录']	= array("other_system_config_newai.php","单点登录");
$PRIVATE_SYSTEM['数字化校园系统设置']['消息中心']	= array("../DICT/crm_clendar.php","消息中心");



//从现在权限信息中过滤出实际的权限,用于菜单部分限制
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
	//判断是否具有子菜单,然后判断是否具有对应权限-开始
	$DEFAULT_MENU = 1;
	$MENU_TOP_ARRAY2 = @array_keys($TARGET_ARRAY[$MENU_TOP_NAME]);
	//判断是否具有子菜单
	//print_R($MENU_TOP_ARRAY2);
	//具有子菜单
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
	//判断是否具有子菜单,然后判断是否具有对应权限-结束
	if($MENU_TOP_NAME!="PARENT"&&$MENU_TOP_NAME!=""&&$DEFAULT_MENU==1)	{
		//判断是否有此权限,从系统权限中过滤权限信息
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

//较验页面的合法性,用于菜单部分限制
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
	//权限合法
	//print $MODULE_NAME."-1-".$MODULE_NAME2;
}
else if(in_array($MODULE_NAME2,$SUNSHINE_USER_PRIV_TEXT_ARRAY)&&$MODULE_NAME2!="")		{
	//权限合法
	//print $MODULE_NAME."-2-".$MODULE_NAME2;
}
else if(in_array($MODULE_NAME3,$SUNSHINE_USER_PRIV_TEXT_ARRAY)&&$MODULE_NAME3!="")		{
	//权限合法
	//print $MODULE_NAME."-2-".$MODULE_NAME2;
}
else	{
	//权限不合法,中断显示

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
<body class='bodycolor'><title>目录访问限制</title><body bgcolor='#264989'><table class="MessageBox" align="center" width="500">
  <tr>
    <td class="msg warning">
      <h4 class="title">警告:{$MODULE_NAME}</h4>
      <div class="content" style="font-size:12pt">无该模块使用权限！如需使用该模块，请联系管理员重新设置本角色权限！</div>
	  {$MODE_SHOW_TEXT}
    </td>
  </tr>
</table>
EOF;


exit;
}

}

?>