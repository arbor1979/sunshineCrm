<?php
	ini_set('display_errors', 1);
	ini_set('error_reporting', E_ALL);

	// display warnings and errors
	error_reporting(E_WARNING | E_ERROR);

	require_once("lib.inc.php");
	$GLOBAL_SESSION=returnsession();
	page_css("物业管理_网上报修");

?>
<script>
	function chkmsg()
	{
		if(document.getElementById('address').value=="")
		{
			alert('请填写具体的楼房房间地址');
			return false;
		}
		else if(document.getElementById('content').value=="")
		{
			alert('请填写报修内容');
			return false;
		}
		else return true;
	}
</script>
<?php
	//*****************获取教师信息*****************//
	$教师ID = $_SESSION['LOGIN_USER_ID'];
	$教师姓名 = $_SESSION['LOGIN_USER_NAME'];

	//*****************当前学期信息*****************//
	$sql = "select 学期名称 from edu_xueqiexec where 当前学期='1'";
	$rs = $db -> Execute($sql);
	$当前学期 = $rs -> fields['学期名称'];

	//***********获取GET传递URL的参数信息***********//
	$楼房属性_get = $_GET['楼房属性'];

	if($_GET['楼房属性']=="")
	{
		$_GET['楼房属性'] = "宿舍";
		$楼房属性_get = $_GET['楼房属性'];
	}

	//*******************信息提交*******************//
	if($_GET['action'] == "submit")
	{
		$报修人 = $教师ID;
		$创建人 = $教师ID;
				//********报修日期********//
		$报修时间 = Date("Y-m-d");

				//********报修时间********//
		$创建时间 = Date("Y-m-d H:i:s");

			    //**POST传递URL的参数信息*//
		$楼房属性_post = $_POST['楼房属性'];
		$楼房名称_post = $_POST['楼房名称'];
		$楼房地址_post = $_POST['楼房地址'];
		$报修项目_post = $_POST['报修项目'];
		$报修内容_post = $_POST['报修内容'];
		$报修人联系方式 = $_POST['报修人联系方式'];

				//********执行插入********//
		$sql = "insert into wygl_baoxiuxinxi(当前学期,楼房属性,楼房名称,楼房地址,报修项目,报修内容,报修人,
			    报修时间,是否受理,维修状态,是否评价,备注,创建人,创建时间,报修人联系方式) values('".$当前学期."','".$楼房属性_post."','".$楼房名称_post."','".$楼房地址_post."','".$报修项目_post."','".$报修内容_post."','".$报修人."',
				'".$报修时间."','否','否','否','','".$创建人."','".$创建时间."','$报修人联系方式')";
		$db -> Execute($sql);

		$_GET = array();
		$_POST = array();
		print_infor("发布维修信息成功");
		print "<meta http-equiv=\"REFRESH\" content=\"0 URL=?\">";
	}

	//*****************操作选择提示*****************//
	else if($_GET['action']=="")
	{
				//********楼房属性********//
		$楼房属性 = array();
		$楼房属性[0]['楼房属性'] = "宿舍";
		$楼房属性[1]['楼房属性'] = "教学办公";

		$楼房属性_sel = "<Select name='楼房属性' class=SmallSelect  onChange=\"var jmpURL='?flag=jump&楼房属性=' + this.options[this.selectedIndex].value; if(jmpURL!='') {window.location=jmpURL;} else {this.selectedIndex=0;}\">";
		for($i=0;$i<sizeof($楼房属性);$i++)
		{
			if($楼房属性_get == $楼房属性[$i]['楼房属性'])
				$Selected = "selected";
			else
				$Selected = "";
			$楼房属性_sel .= "<Option ".$Selected." value='".$楼房属性[$i]['楼房属性']."'>".$楼房属性[$i]['楼房属性']."</Option>";
		}
		$楼房属性_sel .= "</Select>";

					//********楼房名称********//
		if($楼房属性_get == "宿舍")
		$sql = "select 宿舍楼名称 as 楼房名称 from dorm_building";
		else if($楼房属性_get == "教学办公")
		$sql = "select 教学楼名称 as 楼房名称 from edu_building";
		$rs = $db -> Execute($sql);
		$rs_a = $rs -> GetArray();
		if(!is_array($rs_a))
		$rs_a = array();
		$楼房名称 = $rs_a;
		$楼房名称_sel = "<Select class=SmallSelect name='楼房名称' >";
		for($i=0;$i<sizeof($楼房名称);$i++)
		{
			$楼房名称_sel .= "<Option value='".$楼房名称[$i]['楼房名称']."'>".$楼房名称[$i]['楼房名称']."</Option>";
		}
		$楼房名称_sel .= "</Select>";

					//********楼房地址********//
		$楼房地址_inp = "<Input class=SmallInput id='address' name='楼房地址' ></Input>";

					//********报修项目********//
		$报修项目 = array();
		//$报修项目[0]['报修项目'] = "水";
		//$报修项目[1]['报修项目'] = "电";
		//$报修项目[2]['报修项目'] = "设备";
		//$报修项目[3]['报修项目'] = "其他";
		$sql = "select 名称 AS 报修项目 from wygl_biaoxiuxiangmu";
		$rs = $db -> Execute($sql);
		$报修项目 = $rs -> GetArray();
		$报修项目_sel = "<Select name='报修项目' class=SmallSelect >";
		for($i=0;$i<sizeof($报修项目);$i++)
		{
			$报修项目_sel .= "<Option value='".$报修项目[$i]['报修项目']."'>".$报修项目[$i]['报修项目']."</Option>";
		}
		$报修项目_sel .= "</Select>";

					//********报修内容********//
		$报修内容_tex .= "<TextArea id='content' Name='报修内容' Rows=5 Cols=45 style='width:84%;'></Textarea>";

					//******提交返回按钮******//
		$提交_sub .= "<Input Type='submit' class=SmallButton value='提交报修'>";
		$重置_res .= "<Input Type='reset' class=SmallButton value='重置信息'>";
		$返回_but .="<input type='button' class='SmallButton' value='返回' onclick='history.back()'>";
		$报修人联系方式 = returntablefield("user","USER_ID",$教师ID,"MOBIL_NO");
		//*******************填写表单*******************//
		print "<Center>
			  <Form Id='Form1' Name='Form1' method=post action='?action=submit' onSubmit=\"return chkmsg();\">
			  <Table class=TableBlock width=80%>";
		print "<Tr class=TableHeader><Td colspan=4>网上报修信息填写</Td></Tr>";
		print "<Tr class=TableData><Td width=25% align=left>楼房属性:</Td><Td width=25% align=left>".$楼房属性_sel."</Td><Td width=25% align=left>楼房名称:</Td><Td width=25% align=left>".$楼房名称_sel."</Td></Tr>";
		print "<Tr class=TableData><Td width=25% align=left>楼房地址:</Td><Td width=25% align=left>".$楼房地址_inp."</Td><Td width=25% align=left>报修项目:</Td><Td width=25% align=left>".$报修项目_sel."</Td></Tr>";
		print "<Tr class=TableData><Td width=25% align=left>报修人联系方式:</Td><Td  colspan=3 align=left><input size=25 type=input class=SmallInput name=报修人联系方式 value='$报修人联系方式'>(默认为用户的手机号)</Td></Tr>";
		print "<Tr class=TableData><Td align=left>报修内容</Td><Td colspan=3 align=left>".$报修内容_tex."</Td></Tr>";
		print "</Table><Br>";
		print $提交_sub."&nbsp;&nbsp;".$重置_res."&nbsp;&nbsp;".$返回_but."</Form></Center>";
	}



if($_GET['action']==''||$_GET['action']=='init_default'||$_GET['action']=='init_customer')		{
	$PrintText .= "<BR><table  class=TableBlock align=left width=100%>";
	$PrintText .= "<TR class=TableContent><td ><font color=green >

使用说明：<BR>
&nbsp;&nbsp;①此部分填写报修信息,报修信息的接收处理模块是在后勤管理->公物维修->报修信息中进行管理。<BR>
&nbsp;&nbsp;②完成维修之后,你可以对维修的信息进行评价。



</font></td></table>";
	print $PrintText;
}

?>