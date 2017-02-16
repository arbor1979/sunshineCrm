<?php
require_once("lib.inc.php");

$GLOBAL_SESSION=returnsession();
	require_once("systemprivateinc.php");

	CheckSystemPrivate("后勤管理-固定资产-操作明细");

/*
  编号 int(100)   否  auto_increment
  资产名称 varchar(200) gbk_chinese_ci  否
  资产编号 varchar(200) gbk_chinese_ci  否
  资产类别 varchar(200) gbk_chinese_ci  否
  采购标识 varchar(200) gbk_chinese_ci  否
  供应商 varchar(200) gbk_chinese_ci  否
  所属部门 varchar(200) gbk_chinese_ci  否
  使用人员 varchar(200) gbk_chinese_ci  否
  资产原值 varchar(200) gbk_chinese_ci  否
  启用日期 date   否
  型号规格 varchar(255) gbk_chinese_ci  否
  所属状态 varchar(20) gbk_chinese_ci  否 购置未分配
  备注 varchar(255) gbk_chinese_ci  否
  创建人 varchar(200) gbk_chinese_ci  否
  创建时间

*/

if($_GET['action']=="add_default_data")		{
	page_css('采购');
	$所属部门 = $_POST['所属部门'];
	$采购标识 = $_POST['采购标识'];
	$批准人 = $_POST['批准人'];
	$数量 = $_POST['数量'];
	$创建人 = $_POST['创建人'];
	$创建时间 = $_POST['创建时间'];
	if($批准人!=""&&$数量>0)	{
		//print_R($_POST);exit;
		for($i=1;$i<=$数量;$i++)			{

			//得到资产编号
			$sql = "select * from fixedasset where 资产名称='$采购标识' and 所属状态!='资产已报废' order by 编号 desc limit 1";
			$rs = $db->Execute($sql);
			$资产编号 = $rs->fields['资产编号'];
			//print $资产编号;
			if($资产编号!="")			{
				$资产编号前缀 = substr($资产编号,0,-3);
				$资产编号后缀 = substr($资产编号,-3);
				$资产编号后缀 = (int)$资产编号后缀;
				//$资产编号后缀  = $资产编号后缀+1;
				if($资产编号后缀>0)			{
					switch(strlen($资产编号后缀))		{
						case 3:
							$资产编号后缀  = $资产编号后缀+1;
							break;
						case 2:
							$资产编号后缀  = "0".$资产编号后缀;
							break;
						case 1:
							$资产编号后缀  = "00".$资产编号后缀;
							break;
					}

					$资产编号  = $资产编号前缀.$资产编号后缀;
				}
				else	{
					$资产编号  = $资产编号."001";
				}
				$资产名称 = $采购标识;
				//."".date("Ymd")
			}
			else	{
				$资产编号1 = substr($资产编号,0,10);
				//print $资产编号1."<HR>$资产编号";
				$资产编号2 = substr($资产编号,10,4);
				$资产编号2 = $资产编号2+10001;
				$资产编号2 = substr($资产编号2,1,strlen($资产编号2));
				$资产编号  = $资产编号1.$资产编号2;
				$资产名称 = $采购标识;
			}

			$单价 = returntablefield("fixedasset","资产名称",$资产名称,"单价");
			$金额 = $单价*$数量;
			//处理固定资产表的数据
			$sql = "insert into fixedasset
				(资产名称,资产编号,资产类别,采购标识,所属部门,所属状态,创建人,创建时间,单价,数量,金额,规格型号,单位,资产批次)
				values('$资产名称','$资产编号','".$rs->fields['资产类别']."','$采购标识','$所属部门','购置未分配','$创建人','$创建时间','$单价','1','$金额','".$rs->fields['规格型号']."','".$rs->fields['单位']."','".$rs->fields['资产批次']."');";

			//print $sql;exit;
			$db->Execute($sql);

			//处理固定资产采购表的数据
			$sql = "insert into fixedassetin
				(资产名称,资产编号,所属部门,批准人,备注,创建人,创建时间,单价,数量,金额)
				values('$资产名称','$资产编号','$所属部门','$批准人','$备注','$创建人','$创建时间','$单价','$数量','$金额');";
			$db->Execute($sql);
			//print $sql."<BR>";
		}
		//print_R($_POST);exit;
		print_infor("你的操作已经完成!",$infor='trip',$return="location='fixedasset_newai.php?'",$indexto='fixedasset_newai.php');


		//Array ( [采购标识] => 台式电脑 [数量] => 6 [所属部门] => 行政管理部 [批准人_ID] => admin [批准人] => 系统管理员 [备注] => [创建人] => admin [创建时间] => 2009-08-27 16:52:16 [submit] => 保存 )
	}

	else			{
		$SYSTEM_SECOND = 1;
		print_infor("批准人为空或数量小于1,您的操作没有执行成功!",$infor='该参数新版本没有被使用',$return="location='fixedasset_newai.php'",$indexto='fixedasset_newai.php');
	}

	exit;
}





$filetablename='fixedassetin';
require_once('include.inc.php');
?>