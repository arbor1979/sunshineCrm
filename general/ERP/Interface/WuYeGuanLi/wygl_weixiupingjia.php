<?php
	ini_set('display_errors', 1);
	ini_set('error_reporting', E_ALL);

	// display warnings and errors
	error_reporting(E_WARNING | E_ERROR);

	require_once("lib.inc.php");
	$GLOBAL_SESSION=returnsession();
	page_css("物业管理_维修评价");


	//*****************获取教师信息*****************//
	$教师ID = $_SESSION['LOGIN_USER_ID'];
	$教师姓名 = $_SESSION['LOGIN_USER_NAME'];

	//*******************评价信息页面*******************//
	if($_GET['action'] == "see")
	{
		$报修编号 = $_GET['报修编号'];
		$sql = "select 当前学期,楼房属性,楼房名称,楼房地址,报修项目,报修内容,维修状态 from wygl_baoxiuxinxi where 维修状态 ='是' and 编号=".$报修编号;
		$rs = $db -> Execute($sql);
		$rs_a = $rs -> GetArray();
		$报修信息 = $rs_a;
		if(sizeof($报修信息)>0)
		{
			$报修学期 = $报修信息[0]['当前学期'];
			$楼房属性 = $报修信息[0]['楼房属性'];
			$楼房名称 = $报修信息[0]['楼房名称'];
			$楼房地址 = $报修信息[0]['楼房地址'];
			$报修项目 = $报修信息[0]['报修项目'];
			$报修内容 = $报修信息[0]['报修内容'];
			$维修状态 = $报修信息[0]['维修状态'];

			$报修信息_var = "<Tr class=TableData><Td width=30% align=center><font color='red'>当前年度</font></Td><Td width=70% align=center><font color='red'>".$报修学期."</font></Td></Tr>";
			$报修信息_var .= "<Tr class=TableData><Td width=30% align=center><font color='green'>楼房属性</Td><Td width=70% align=center><font color='green'>".$楼房属性."</font></Td></Tr>";
			$报修信息_var .= "<Tr class=TableData><Td width=30% align=center><font color='red'>楼房名称</Td><Td width=70% align=center><font color='red'>".$楼房名称."</font></Td></Tr>";
			$报修信息_var .= "<Tr class=TableData><Td width=30% align=center><font color='green'>楼房地址</Td><Td width=70% align=center><font color='green'>".$楼房地址."</font></Td></Tr>";
			$报修信息_var .= "<Tr class=TableData><Td width=30% align=center><font color='red'>报修项目</Td><Td width=70% align=center><font color='red'>".$报修项目."</font></Td></Tr>";
			$报修信息_var .= "<Tr class=TableData><Td width=30% align=center><font color='green'>报修内容</Td><Td width=70% align=center><font color='green'>".$报修内容."</font></Td></Tr>";
			$报修信息_var .= "<Tr class=TableData><Td width=30% align=center><font color='red'>维修状态</Td><Td width=70% align=center><font color='red'>".$维修状态."</font></Td></Tr>";

			$sql = "select 评价名称,评价等级 from wygl_weixiupingjia where 维修编号=".$报修编号;
			$rs = $db -> Execute($sql);
			$rs_a = $rs -> GetArray();
			$评价信息 = $rs_a;

			$评价信息_var = "";
			for($i=0;$i<sizeof($评价信息);$i++)
			{
				if($i%2 == 0)
					$Color = "red";
				else
					$Color = "green";
				$评价名称 = $评价信息[$i]['评价名称'];
				$评价等级 = $评价信息[$i]['评价等级'];
				$评价信息_var .= "<Tr class=TableData><Td width=30% align=center><font color='".$Color."'>".$评价名称."</font></Td><Td width=70% align=center><font color='".$Color."'>".$评价等级."</Td></font></Tr>";
			}

			print "<Center><Table class=TableBlock width=100%>";
			print "<Tr class=TableHeader><Td colspan=4>您的报修信息</Td></Tr>";
			print $报修信息_var;
			print "</Table><Br>";
			print "<Table class=TableBlock width=100%>";
			print "<Tr class=TableHeader><Td colspan=4>您的评价信息</Td></Tr>";
			print $评价信息_var;
			print "</Table><Br>";
			print "<Input type='button' class=SmallButton onClick='window.print();' value='打印'></Input>&nbsp;&nbsp;";
			print "<Input type='button' class=SmallButton onClick='history.back();' value='返回'></Input></Center>";
		}
	}
	//*******************评价操作页面*******************//
	if($_GET['action'] == "evaluate")
	{
		$报修编号 = $_GET['报修编号'];

		$sql = "select distinct 评价名称 from wygl_pingjialeixing";
		$rs = $db -> Execute($sql);
		$rs_a = $rs -> GetArray();
		if(!is_array($rs_a))
		$rs_a = array();
		$评价名称 = $rs_a;

		$sql = "select distinct 评价名称,评价等级 from wygl_pingjialeixing";
		$rs = $db -> Execute($sql);
		$rs_a = $rs -> GetArray();
		if(!is_array($rs_a))
		$rs_a = array();
		$评价等级 = $rs_a;

		for($i=0;$i<sizeof($评价名称);$i++)
		{
			if($i%2 == 0)
				$color = "red";
			else
				$color = "green";

			$评价名称_var = $评价名称[$i]['评价名称'];

			$评价等级_var = "";
			$Check = "";
			$Flag_var = 0;
			for($j=0;$j<sizeof($评价等级);$j++)
			{
				if($评价名称[$i]['评价名称'] == $评价等级[$j]['评价名称'])
				{
					if($Flag_var==0)
						$Check = "checked";
					else
						$Check = "";
					$评价等级_var .= "<Input Type='radio' name='".$评价名称_var."' value='".$评价等级[$j]['评价等级']."' ".$Check.">".$评价等级[$j]['评价等级']."</Input>";
					$Flag_var ++;
				}
				//print $评价等级_var."&nbsp;".$j."&nbsp;".$Check."<Br>";
			}

			$评价类型_tr_arr[$i] = "<Tr class=TableData>";
			$评价类型_tr_arr[$i] .= "<Td width=30% align=center><font color=".$color.">".$评价名称_var."</font></Td>";
			$评价类型_tr_arr[$i] .= "<Td width=70% align=center><font color=".$color.">".$评价等级_var."</font></Td>";
			$评价类型_tr_arr[$i] .= "</Tr>";
		}

		$提交_sub .= "<Input Type='submit' class=SmallButton value='提交评价'>";
		$重置_res .= "<Input Type='reset' class=SmallButton value='重置信息'>";

		print "<Center><Form Id='Form1' Name='Form1' method=post action='?action=submit' onSubmit=\"return chkmsg();\">
			   <Table class=TableBlock width=100%>";
		print "<Tr class=TableHeader><Td colspan=2>维修信息评价</Td></Tr>";
		print "<Tr class=TableData><Td align=center>评价名称</Td><Td align=center>评价等级</Td></Tr>";
		for($i=0;$i<sizeof($评价类型_tr_arr);$i++)
		{
			print $评价类型_tr_arr[$i];
		}
		print "</Table><Br>";
		print "<Input type='hidden' name='报修编号' value='".$报修编号."'></Input>";
		print $提交_sub."&nbsp;&nbsp;".$重置_res."</Form></Center>";
	}
		//***********执行插入***********//
	if($_GET['action'] == "submit")
	{
		$报修编号 = $_POST['报修编号'];
		$评价名称 = @array_keys($_POST);
		$评价等级 = @array_values($_POST);
		for($i=0;$i<sizeof($_POST)-1;$i++)
		{
			$评价人 = $教师ID;
			$备注 = "";
			$创建人 = $教师ID;
			$创建时间 = Date("Y-m-d H:i:s");
			$评价名称_var = $评价名称[$i];
			$评价等级_var = $评价等级[$i];
			$sql = "insert into wygl_weixiupingjia values('',".$报修编号.",'".$评价名称_var."','".$评价人."','".$评价等级_var."','".$备注."','".$创建人."','".$创建时间."')";
			$db -> Execute($sql);
		}
		$sql = "update wygl_baoxiuxinxi set 是否评价='是' where 编号=".$报修编号;
		$db -> Execute($sql);
		print_infor("评价成功!");
		print "<meta http-equiv=\"REFRESH\" content=\"0 URL=?\">";
	}

	//*******************报修信息页面*******************//
	//*****************获取报修信息*****************//
	if($_GET['action'] == "")
	{
		$sql = "select * from wygl_baoxiuxinxi where 报修人='".$教师ID."' order by 编号 desc";
		$rs = $db -> Execute($sql);
		$rs_a = $rs -> GetArray();
		if(!is_array($rs_a))
		$rs_a = array();
		$报修信息 = $rs_a;

		for($i=0;$i<sizeof($报修信息);$i++)
		{
			if($i%2 == 0)
				$color = "red";
			else
				$color = "green";
			$报修编号 = $报修信息[$i]['编号'];
			$报修学期 = $报修信息[$i]['当前学期'];
			$楼房属性 = $报修信息[$i]['楼房属性'];
			$楼房名称 = $报修信息[$i]['楼房名称'];
			$楼房地址 = $报修信息[$i]['楼房地址'];
			$报修项目 = $报修信息[$i]['报修项目'];
			$报修内容 = $报修信息[$i]['报修内容'];
			$是否受理 = $报修信息[$i]['是否受理'];
			$维修状态 = $报修信息[$i]['维修状态'];
			$报修人联系方式 = $报修信息[$i]['报修人联系方式'];
			$是否评价 = $报修信息[$i]['是否评价'];

			$报修信息_tr_arr[$i] = "<Tr class=TableData>";
			$报修信息_tr_arr[$i] .= "<Td align=center nowrap><font color=".$color.">".$报修编号."</font></Td>";
			$报修信息_tr_arr[$i] .= "<Td align=center nowrap><font color=".$color.">".$报修学期."</font></Td>";
			$报修信息_tr_arr[$i] .= "<Td align=center nowrap><font color=".$color.">".$楼房属性."</font></Td>";
			$报修信息_tr_arr[$i] .= "<Td align=center nowrap><font color=".$color.">".$楼房名称."</font></Td>";
			$报修信息_tr_arr[$i] .= "<Td align=center nowrap><font color=".$color.">".$楼房地址."</font></Td>";
			$报修信息_tr_arr[$i] .= "<Td align=center nowrap><font color=".$color.">".$报修项目."</font></Td>";
			$报修信息_tr_arr[$i] .= "<Td align=center nowrap><font color=".$color.">".$报修内容."</font></Td>";
			$报修信息_tr_arr[$i] .= "<Td align=center nowrap><font color=".$color.">".$报修人联系方式."</font></Td>";
			$报修信息_tr_arr[$i] .= "<Td align=center nowrap><font color=".$color.">".$是否受理."</font></Td>";
			$报修信息_tr_arr[$i] .= "<Td align=center nowrap><font color=".$color.">".$维修状态."</font></Td>";
			if($是否评价 == "是"&&$维修状态=="是")
			{
				$报修信息_tr_arr[$i] .= "<Td align=center nowrap><a href=\"?action=see&报修编号=".$报修编号."\"><font color=blue>查看评价</font></a></Td>";
			}
			else if($是否评价 == "否"&&$维修状态=="是")
			{
				$报修信息_tr_arr[$i] .= "<Td align=center nowrap><a href=\"?action=evaluate&报修编号=".$报修编号."\"><font color=orange>进行评价</font></a></Td>";
			}
			else		{
				$报修信息_tr_arr[$i] .= "<Td align=center nowrap>&nbsp;维修完时才能评价</a></Td>";
			}
			$报修信息_tr_arr[$i] .= "</Tr>";
		}

		//*****************显示报修信息*****************//
		print "<Center><Table class=TableBlock width=100%>";
		print "<Tr class=TableHeader><Td colspan=11>维修信息评价</Td></Tr>";
		print "<Tr class=TableData>
			   <Td align=center nowrap>报修编号</Td><Td align=center nowrap>当前年度</Td><Td align=center nowrap nowrap>楼房属性</Td>
			   <Td align=center nowrap>楼房名称</Td><Td nowrap align=center>楼房地址</Td><Td align=center nowrap>报修项目</Td>
			   <Td align=center nowrap>报修内容</Td><Td nowrap align=center>报修人联系方式</Td>
			   <Td align=center nowrap>是否受理</Td><Td nowrap align=center>维修状态</Td>
			   <Td align=center nowrap>评价操作</Td></Tr>";
		for($i=0;$i<sizeof($报修信息_tr_arr);$i++)
		{
			print $报修信息_tr_arr[$i];
		}
		print "</Table></br>";
		print "<input type=button class=SmallButton value=返回 onClick='history.back();'></Center>";
	}
?>