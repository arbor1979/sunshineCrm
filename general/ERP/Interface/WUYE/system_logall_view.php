<?php
	ini_set('display_errors', 1);
	ini_set('error_reporting', E_ALL);
	error_reporting(E_WARNING | E_ERROR);
	require_once('lib.inc.php');
	$GLOBAL_SESSION=returnsession();

	page_css("MYSQL 性能监控");


	//自动清除七天以前的历史记录
	$sql = "delete from system_logall where datediff(now(),当前时间)>=7";
	$db->Execute($sql);


	$sql = "select DATE_FORMAT(当前时间,'%Y-%m-%d') AS 当前时间
		from system_logall
		group by DATE_FORMAT(当前时间,'%Y-%m-%d')
		order by 当前时间 desc
		";
	$rs = $db->CacheExecute(5,$sql);
	$rs_a = $rs->GetArray();
	for($i=0;$i<sizeof($rs_a);$i++)			{
		$当前时间TEXT .= "<a href='?".base64_encode("XX=XX&&当前时间=".$rs_a[$i]['当前时间']."&&XX=XX")."'>".$rs_a[$i]['当前时间']."</a> ";
	}

	if($_GET['当前时间']!='')	$统计时间 = $_GET['当前时间'];
	else						$统计时间 = $rs_a[0]['当前时间'];



	table_begin("100%");
	print "<tr class=TableData ><td>MYSQL 运行情况监控 时间:".$统计时间." $当前时间TEXT
	<input type=\"button\" class=\"SmallButton\" value=\"返回\" onclick=\"location='database_setting.php'\">
	<input type=\"button\" class=\"SmallButton\" value=\"明细\" onclick=\"location='system_logall_newai.php'\">
	</td></tr>";
	table_end();
	print "<BR>";


	table_begin("780");
	print_title("MYSQL 线程运行情况监控[以小时为单位统计] <a href=\"system_logall_mysqlthreads.php?".base64_encode("XX=XX&&统计时间=".$统计时间."&统计单位=秒&XX=XX")."\" target=_blank>查看以秒为单位的统计图</a>");
	print "<tr class=TableData ><td><img src='system_logall_mysqlthreads.php?".base64_encode("XX=XX&&统计时间=".$统计时间."&&XX=XX")."' width=100% border=0></td></tr>";
	print_title("MYSQL 查询缓存运行情况监控[以小时为单位统计] <a href=\"system_logall_querycache.php?".base64_encode("XX=XX&&统计时间=".$统计时间."&统计单位=秒&XX=XX")."\" target=_blank>查看以秒为单位的统计图</a>");
	print "<tr class=TableData ><td><img src='system_logall_querycache.php?".base64_encode("XX=XX&&统计时间=".$统计时间."&&XX=XX")."' width=100% border=0></td></tr>";
	table_end();

?>