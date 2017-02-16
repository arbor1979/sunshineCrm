<?php

ini_set('date.timezone','Asia/Shanghai');
function addShortCutByDate($datefield,$showText='',$defaultvalue='')					{
	//print_r($_GET);
	if($defaultvalue!='')
	{
		if($_GET['当前搜索方式']=='')
			$_GET['当前搜索方式']=$defaultvalue;

	}
	$_GET['时间字段']=$datefield;
	if($_GET['当前搜索方式']=='当天')
	{
		$_GET['开始时间ADD']=date("Y-m-d",mktime(0,0,1,date("m"),date("d"),date("Y")));
		$_GET['结束时间ADD']=date("Y-m-d",mktime(0,0,1,date("m"),date("d"),date("Y")));
	}
	else if ($_GET['当前搜索方式']=='最近三天')
	{
		$_GET['开始时间ADD']=date("Y-m-d",mktime(0,0,1,date("m"),date("d")-3,date("Y")));
		$_GET['结束时间ADD']=date("Y-m-d",mktime(0,0,1,date("m"),date("d"),date("Y")));
	}
	else if ($_GET['当前搜索方式']=='最近一周')
	{
		$_GET['开始时间ADD']=date("Y-m-d",mktime(0,0,1,date("m"),date("d")-7,date("Y")));
		$_GET['结束时间ADD']=date("Y-m-d",mktime(0,0,1,date("m"),date("d"),date("Y")));
	}
	else if ($_GET['当前搜索方式']=='最近半月')
	{
		$_GET['开始时间ADD']=date("Y-m-d",mktime(0,0,1,date("m"),date("d")-15,date("Y")));
		$_GET['结束时间ADD']=date("Y-m-d",mktime(0,0,1,date("m"),date("d"),date("Y")));
	}
	else if ($_GET['当前搜索方式']=='最近一月')
	{
		$_GET['开始时间ADD']=date("Y-m-d",mktime(0,0,1,date("m")-1,date("d"),date("Y")));
		$_GET['结束时间ADD']=date("Y-m-d",mktime(0,0,1,date("m"),date("d"),date("Y")));
	}
	else if ($_GET['当前搜索方式']=='最近两月')
	{
		$_GET['开始时间ADD']=date("Y-m-d",mktime(0,0,1,date("m")-2,date("d"),date("Y")));
		$_GET['结束时间ADD']=date("Y-m-d",mktime(0,0,1,date("m"),date("d"),date("Y")));
	}
	else if ($_GET['当前搜索方式']=='最近三月')
	{
		$_GET['开始时间ADD']=date("Y-m-d",mktime(0,0,1,date("m")-3,date("d"),date("Y")));
		$_GET['结束时间ADD']=date("Y-m-d",mktime(0,0,1,date("m"),date("d"),date("Y")));
	}
	else if ($_GET['当前搜索方式']=='最近六月')
	{
		$_GET['开始时间ADD']=date("Y-m-d",mktime(0,0,1,date("m")-6,date("d"),date("Y")));
		$_GET['结束时间ADD']=date("Y-m-d",mktime(0,0,1,date("m"),date("d"),date("Y")));
	}
	else if ($_GET['当前搜索方式']=='自定义')
	{
		$_GET['开始时间ADD']=urldecode($_GET['开始时间ADD']);
		$_GET['结束时间ADD']=urldecode($_GET['结束时间ADD']);
	}
	if($showText=='')
		$showText=$datefield;
	global $db,$SYSTEM_ADD_SQL,$SYSTEM_PRINT_SQL;
	global $增加对查询日期快捷方式的支持_是否启用;
	$增加对查询日期快捷方式的支持_是否启用 = 1;
	session_register("增加对查询日期快捷方式的支持");
	if($_SESSION['增加对查询日期快捷方式的支持']=='')					{
		$_SESSION['增加对查询日期快捷方式的支持'] = '设置为1';
	}
	if($_GET['增加对查询日期快捷方式的支持GET']=="设置为0")					{
		$_SESSION['增加对查询日期快捷方式的支持'] = '设置为0';
	}
	elseif($_GET['增加对查询日期快捷方式的支持GET']=="设置为1")					{
		$_SESSION['增加对查询日期快捷方式的支持'] = '设置为1';
	}
	//print $_SESSION['增加对查询日期快捷方式的支持'];

	if(($_GET['action']==""||$_GET['action']=="init_default"||$_GET['action']=="init_default_search")&&$_SESSION['增加对查询日期快捷方式的支持']=='设置为1')			{
		print "<SCRIPT src=\"".ROOT_DIR."general/ERP/Enginee/WdatePicker/WdatePicker.js\"></SCRIPT>";
		print "<form name=formadd><table class=TableBlock width=100% ><tr><td nowrap class=TableContent align=left>";
		//if($_GET['当前搜索方式']=="")		$_GET['当前搜索方式'] = "没有选择";
		print "<font color=green>".$showText.":";
		if($_GET['当前搜索方式']=='') $_GET['当前搜索方式']='全部';
		if($_GET['开始时间ADD']!='' && strlen($_GET['开始时间ADD'])<=10)
			$_GET['开始时间ADD']=$_GET['开始时间ADD']." 00:00:00";
		if($_GET['结束时间ADD']!='' && strlen($_GET['结束时间ADD'])<=10)
			$_GET['结束时间ADD']=$_GET['结束时间ADD']." 23:59:59";
		$redborder="border:1px red solid;padding:3px;";
		
		$FormPageAction = FormPageAction("当前搜索方式","当天");
		if($_GET['当前搜索方式']=='当天') $css=$redborder; else $css='';
		print "&nbsp;&nbsp;<a href='#' onclick=\"selectRed('dt1')\"><span id='dt1' style=\"$css\">当天</span></a>";

		$FormPageAction = FormPageAction("当前搜索方式","最近三天");
		if($_GET['当前搜索方式']=='最近三天') $css=$redborder; else $css='';
		print "&nbsp;&nbsp;<a href='#' onclick=\"selectRed('dt2')\"><span id='dt2' style=\"$css\">最近三天</span></a>";

		$FormPageAction = FormPageAction("当前搜索方式","最近一周");
		if($_GET['当前搜索方式']=='最近一周') $css=$redborder; else $css='';
		print "&nbsp;&nbsp;<a href=\"#\" onclick=\"selectRed('dt3')\"><span id='dt3' style=\"$css\">最近一周</span></a>";

		$FormPageAction = FormPageAction("当前搜索方式","最近半月");
		if($_GET['当前搜索方式']=='最近半月') $css=$redborder; else $css='';
		print "&nbsp;&nbsp;<a href=\"#\" onclick=\"selectRed('dt4')\"><span id='dt4' style=\"$css\">最近半月</span></a>";

		$FormPageAction = FormPageAction("当前搜索方式","最近一月");
		if($_GET['当前搜索方式']=='最近一月') $css=$redborder; else $css='';
		print "&nbsp;&nbsp;<a href=\"#\" onclick=\"selectRed('dt5')\"><span id='dt5' style=\"$css\">最近一月</span></a>";

		$FormPageAction = FormPageAction("当前搜索方式","最近两月");
		if($_GET['当前搜索方式']=='最近两月') $css=$redborder; else $css='';
		print "&nbsp;&nbsp;<a href=\"#\" onclick=\"selectRed('dt6')\"><span id='dt6' style=\"$css\">最近两月</span></a>";

		$FormPageAction = FormPageAction("当前搜索方式","最近三月");
		if($_GET['当前搜索方式']=='最近三月') $css=$redborder; else $css='';
		print "&nbsp;&nbsp;<a href=\"#\" onclick=\"selectRed('dt7')\"><span id='dt7' style=\"$css\">最近三月</span></a>";

		$FormPageAction = FormPageAction("当前搜索方式","最近六月");
		if($_GET['当前搜索方式']=='最近六月') $css=$redborder; else $css='';
		print "&nbsp;&nbsp;<a href=\"#\" onclick=\"selectRed('dt8')\"><span id='dt8' style=\"$css\">最近六月</span></a>";
		
		$FormPageAction = FormPageAction("当前搜索方式","");
		print "\r\n<script language='javascript'>
		function selectRed(id)
		{
		
			for(i=1;i<11;i++)
			{
				document.getElementById('dt'+i).style.border='0';
				
			}
			document.getElementById(id).style.border='1px red solid';
			document.getElementById(id).style.padding='3px';
			Form2.当前搜索方式.value=document.getElementById(id).innerHTML;
			
			Form2.开始时间ADD.value='';
			Form2.结束时间ADD.value='';
			if(id=='dt9')
			{
				Form2.开始时间ADD.value=document.getElementById('start_time').value;
				Form2.结束时间ADD.value=document.getElementById('end_time').value;
			}
			
		}
		function userDefineDate()
		{
			var url='$FormPageAction';
			url=url+'&当前搜索方式=自定义&开始时间ADD='+encodeURIComponent(document.getElementById('start_time').value)+'&结束时间ADD='+encodeURIComponent(document.getElementById('end_time').value);
			
			location.href='?'+url;
		}
		</script>";
		
		
		if($_GET['当前搜索方式']!='自定义') $display="display:none;"; else $display='';
		if($_GET['当前搜索方式']=='自定义') $css=$redborder; else $css='';
		print "&nbsp;<a href=\"#\" onclick=\"javascript:selectRed('dt9');$('#datesel').toggle();\"><span id='dt9' style=\"$css\">自定义</span></a>";
		print "&nbsp;&nbsp;<span style=\"$display\" id=\"datesel\"><input class=\"SmallInput\" size=\"18\"
							name=\"start_time\" id=\"start_time\" value=\"".$_GET['开始时间ADD']."\"
							onclick=\"WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss',readonly:false})\"
							onchange=\"selectRed('dt9');\"
							> — <input class=\"SmallInput\" size=\"18\"
							name=\"end_time\" id=\"end_time\" value=\"".$_GET['结束时间ADD']."\"
							onclick=\"WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss',readonly:false})\"
							onchange=\"selectRed('dt9');\"
							> </span>";
		//print "&nbsp;&nbsp;<a href='?".FormPageAction("增加对查询日期快捷方式的支持GET","设置为0")."'><font color=gray>关闭显示</font></a>";
		
		$FormPageAction = FormPageAction("开始时间ADD","","结束时间ADD","",'',"当前搜索方式","全部");
		
		if($_GET['当前搜索方式']=='全部') $css=$redborder; else $css='';
		print "<a href=\"#\" onclick=\"selectRed('dt10');\"><span id='dt10' style=\"$css\">全部</span></a>";
		print "&nbsp;(选择后点击查询按钮)</font></td></tr></table></form><div style='height:3px'></div>";
		
		if($_GET['开始时间ADD']!="")	
			$SYSTEM_ADD_SQL.= "and $datefield>='".$_GET['开始时间ADD']."'";
		if($_GET['结束时间ADD']!="")		
			$SYSTEM_ADD_SQL.= "and $datefield<='".$_GET['结束时间ADD']."'"; 
				


	}

	//$SYSTEM_PRINT_SQL = "1";

}

function 定时执行函数($函数名称='同步教学计划学分信息到成绩数据表之中',$间隔时间='30')			{
	//进行从主数据库中同步数据
	$变量名称 = "定时执行函数_".$函数名称;
	//session_unregister($变量名称);//测试使用的行代码
	if(!isset($_SESSION[$变量名称]))		{
	
		$_SESSION[$变量名称] = time();
	}
	$现在时间线 = time();
	$时间差 = $现在时间线 - $_SESSION[$变量名称];
	$时间差CEIL = ceil($时间差/60);
	//print_R($时间差);
	//print $变量名称.":".$时间差." ".date("H:i",$_SESSION[$变量名称])."<BR>";
	//print $PHP_SELF_BEGIN."<BR>";
	//当时间超过某一值,或是头一次访问的时候,需要执行此过程
	if($时间差CEIL>=$间隔时间||$时间差==0)							{
		//执行参数传递过来的参数
		$函数名称();
		//更新标记时间
		$_SESSION[$变量名称] = time();
	}//exit;
}



//返回数组的名次信息
function returnArrayMingCi($Result='')				{
	//排名信息
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


//子菜单权限管理部分,同时在FRAMEWORK和EDU下面进行定义
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
	//三个都为空时的情况判断
	if($DEPT_NAME==""&&$USER_NAME==""&&$ROLE_NAME=="")		{
		$return = 1;
	}
	//全体部门
	if($DEPT_NAME=="ALL_DEPT")			{
		$return = 1.5;
	}
	//用户判断
	$LOGIN_USER_ID = $_SESSION['LOGIN_USER_ID'];
	$LOGIN_USER_ID_ARRAY = explode(',',$USER_NAME);
	if(in_array($LOGIN_USER_ID,$LOGIN_USER_ID_ARRAY))		{
		$return = 2;
	}
	//部门判断
	$LOGIN_DEPT_ID = $_SESSION['LOGIN_DEPT_ID'];
	$LOGIN_DEPT_ID_ARRAY = explode(',',$DEPT_NAME);
	if(in_array($LOGIN_DEPT_ID,$LOGIN_DEPT_ID_ARRAY))		{
		$return = 3;
	}
	//角色判断
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