
<?php
function yewucaozuo_Value($fieldvalue,$fields,$i)		{
    //
    global $db;
	global $tablename,$html_etc,$common_html;
	$楼房地址 = strip_tags($fields['value'][$i]['房间号码']);
	$业主姓名 = strip_tags($fields['value'][$i]['业主姓名']);
    $联系方式 = strip_tags($fields['value'][$i]['业主电话']);
	$建筑面积 = strip_tags($fields['value'][$i]['建筑面积']);
	$使用面积 = strip_tags($fields['value'][$i]['套内面积']);
	$公摊面积 = strip_tags($fields['value'][$i]['公摊面积']);
	$单元用途 = strip_tags($fields['value'][$i]['单元用途']);
	$单元人口 = strip_tags($fields['value'][$i]['人数']);

	$当前年月份 = date("Y-m",mktime(1,1,1,date("m")-1,date("d"),date("Y")));
    //$前一个月   = date("Y-m",mktime(1,1,1,date("m")-2,date("d"),date("Y")));

	//echo $当前年月份;
    
	$Text = "";
	$Text .= "<font size=\"2\" color=\"red\"><</font>";
	$Text .= "<a class=OrgAdd href=\" wu_wpgfeesdetails_newai.php?".base64_encode("action=add_default&单元编号=$楼房地址&单元编号_NAME=$楼房地址&单元编号_disabled=disabled&业主姓名=$业主姓名&业主姓名_NAME=$业主姓名&业主姓名_disabled=disabled&联系方式=$联系方式&联系方式_NAME=$联系方式&联系方式_disabled=disabled&费用年月份=$当前年月份&费用年月份_NAME=$当前年月份&费用年月份_disabled=disabled&建筑面积=$建筑面积&建筑面积_NAME=$建筑面积&建筑面积_disabled=disabled&使用面积=$使用面积&使用面积_NAME=$使用面积&使用面积_disabled=disabled&单元用途=$单元用途&单元用途_NAME=$单元用途&单元用途_disabled=disabled&单元人口=$单元人口&单元人口_NAME=$单元人口&单元人口_disabled=disabled")."\">水电气费管理</a> ";


	$Text .= "<a class=OrgAdd href=\" wu1_wpgfeesdetails_newai.php?".base64_encode("action=add_default&单元编号=$楼房地址&单元编号_NAME=$楼房地址&单元编号_disabled=disabled&业主姓名=$业主姓名&业主姓名_NAME=$业主姓名&业主姓名_disabled=disabled&联系方式=$联系方式&联系方式_NAME=$联系方式&联系方式_disabled=disabled&费用年月份=$当前年月份&费用年月份_NAME=$当前年月份&费用年月份_disabled=disabled&建筑面积=$建筑面积&建筑面积_NAME=$建筑面积&建筑面积_disabled=disabled&使用面积=$使用面积&使用面积_NAME=$使用面积&使用面积_disabled=disabled&公摊面积=$公摊面积&公摊面积_NAME=$公摊面积&公摊面积_disabled=disabled&单元用途=$单元用途&单元用途_NAME=$单元用途&单元用途_disabled=disabled&单元人口=$单元人口&单元人口_NAME=$单元人口&单元人口_disabled=disabled")."\">物业费管理</a> ";


	$Text .= "<a class=OrgAdd href=\"my1_wu_maintenancemanagement_newai.php?".base64_encode("action=add_default&楼房地址=$楼房地址&楼房地址_NAME=$楼房地址&楼房地址_disabled=disabled&业主姓名=$业主姓名&业主姓名_NAME=$业主姓名&业主姓名_disabled=disabled&联系方式=$联系方式&联系方式_NAME=$联系方式&联系方式_disabled=disabled")."\">报修管理</a> ";

    $Text .= "<a class=OrgAdd href=\"wu_usercomplaints_newai.php?".base64_encode("action=add_default&单元编号=$楼房地址&单元编号_NAME=$楼房地址&单元编号_disabled=disabled&投诉人=$业主姓名&投诉人_NAME=$业主姓名&投诉人_disabled=disabled&投诉人电话=$联系方式&投诉人电话_NAME=$联系方式&投诉人电话_disabled=disabled")."\">投诉管理</a> ";

    
    $sql = "select * from wuye_wuyetingchechangguanli where 房间号码='$楼房地址' and 业主='$业主姓名'";
	$result = $db->Execute($sql);
	$rs_a = $result->GetArray();
	$编号     = $rs_a[0]['编号'];
	$使用状态 = $rs_a[0]['车位状态'];

	$停车场   = $rs_a[0]['停车场'];
	$停车位   = $rs_a[0]['停车位'];
	$车辆编码 = $rs_a[0]['车辆编码'];
	$车牌     = $rs_a[0]['车牌'];
	$车辆类别 = $rs_a[0]['车辆类别'];
	$车辆颜色 = $rs_a[0]['车辆颜色'];
	$车型     = $rs_a[0]['车型'];
	$是否缴费 = $rs_a[0]['是否缴费'];
	$备注 = "本条数据只作为初始化使用!";

	if($使用状态 == "已售出"){
          
         
         if($是否缴费 == 0){
		 $Text .= "<a class=OrgAdd href=\"wuye_wuyetingchechangguanli_newai.php?".base64_encode("action=edit_default&编号=$编号&编号_NAME=$编号&编号_disabled=disabled")."\">点击缴费</a> ";
		 }else{
		 $Text .= "<a class=OrgAdd href=\"#\" onClick=\"return confirm('此业主车位是已购买!')\">车位已售</a> ";
         }
	}else if($使用状态 == "已租出"){
         
		 if($是否缴费 == 0){

		 $当前年月份 = date("Y-m",mktime(1,1,1,date("m"),date("d"),date("Y")));
		 $Text .= "<a class=OrgAdd href=\"wuye1_wuyetingchechangguanli_newai.php?".base64_encode("action=add_default&所缴费月份=$当前年月份&所缴费月份_NAME=$当前年月份&所缴费月份_disabled=disabled&停车场=$停车场&停车场_NAME=$停车场&停车场_disabled=disabled&停车位=$停车位&停车位_NAME=$停车位&停车位_disabled=disabled&车辆编码=$车辆编码&车辆编码_NAME=$车辆编码&车辆编码_disabled=disabled&车牌=$车牌&车牌_NAME=$车牌&车牌_disabled=disabled&车辆类别=$车辆类别&车辆类别_NAME=$车辆类别&车辆类别_disabled=disabled&车辆颜色=$车辆颜色&车辆颜色_NAME=$车辆颜色&车辆颜色_disabled=disabled&车型=$车型&车型_NAME=$车型&车型_disabled=disabled&房间号码=$楼房地址&房间号码_NAME=$楼房地址&房间号码_disabled=disabled&业主=$业主姓名&业主_NAME=$业主姓名&业主_disabled=disabled&联系电话=$联系方式&联系电话_NAME=$联系方式&联系电话_disabled=disabled")."\">点击缴费</a>";
         }else{
		 $Text .= "<a class=OrgAdd href=\"#\" onClick=\"return confirm('此租用车位本月费用已经缴过!')\">车位已租</a> ";
		 }
	
	}else if($使用状态 == ""){
        
		
		$Text .= "<a class=OrgAdd href=\"wuye2_wuyetingchechangguanli_newai.php?".base64_encode("action=add_default&房间号码=$楼房地址&房间号码_NAME=$楼房地址&房间号码_disabled=disabled&业主=$业主姓名&业主_NAME=$业主姓名&业主_disabled=disabled&联系电话=$联系方式&联系电话_NAME=$联系方式&联系电话_disabled=disabled&备注=$备注&备注_NAME=$备注&备注_disabled=disabled")."\">车位管理</a> ";
    }
	$Text .= "<font size=\"2\" color=\"red\">></font>";
	return $Text;

}
?>