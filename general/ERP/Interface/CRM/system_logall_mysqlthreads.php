<?php
ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL);
error_reporting(E_WARNING | E_ERROR);
require_once('lib.inc.php');
//$GLOBAL_SESSION=returnsession();
// content="text/plain; charset=utf-8"
require_once ('../../Enginee/jpgraph/jpgraph.php');
require_once ('../../Enginee/jpgraph/jpgraph_line.php');


if($_GET['统计时间']!='')	$统计时间 = $_GET['统计时间'];
else						$统计时间 = date("Y-m-d");

//select avg(Threads_cached) AS Threads_cached,DATE_FORMAT(当前时间,'%Y-%m-%d-%H') from system_logall where 当前时间 like '2010-10-01%'
if($_GET['统计单位']=="秒")			{
	$sql = "select DATE_FORMAT(当前时间,'%H-%i') AS 时间X,
				avg(Threads_cached) AS Threads_cached,
				avg(Threads_connected) AS Threads_connected,
				avg(Threads_created) AS Threads_created,
				avg(Threads_running) AS Threads_running
		from system_logall
		where DATE_FORMAT(当前时间,'%Y-%m-%d')='$统计时间'
		group by DATE_FORMAT(当前时间,'%Y-%m-%d-%H-%i')
		";
}
else		{
	$sql = "select DATE_FORMAT(当前时间,'%H') AS 时间X,
				avg(Threads_cached) AS Threads_cached,
				avg(Threads_connected) AS Threads_connected,
				avg(Threads_created) AS Threads_created,
				avg(Threads_running) AS Threads_running
		from system_logall
		where DATE_FORMAT(当前时间,'%Y-%m-%d')='$统计时间'
		group by DATE_FORMAT(当前时间,'%Y-%m-%d-%H')
		";
}
$rs = $db->CacheExecute(150,$sql);
$rs_a = $rs->GetArray();
$数量 = sizeof($rs_a);
if($数量>100) $数量-=10;
for($i=0;$i<$数量;$i++)			{
	//$rs_a[$i]['Threads_cached']	= $rs_a[$i]['Threads_cached'] - 50;

	$Threads_cached[]		= $rs_a[$i]['Threads_cached'];
	$Threads_connected[]	= $rs_a[$i]['Threads_connected'];
	$Threads_created[]		= $rs_a[$i]['Threads_created'];
	$Threads_running[]		= $rs_a[$i]['Threads_running'];

	$Threads_cached_avg		+= $rs_a[$i]['Threads_cached'];
	$Threads_connected_avg	+= $rs_a[$i]['Threads_connected'];
	$Threads_created_avg	+= $rs_a[$i]['Threads_created'];
	$Threads_running_avg	+= $rs_a[$i]['Threads_running'];

	$datax[] = $rs_a[$i]['时间X'];
}

$Threads_cached_avg		= (int)($Threads_cached_avg/$数量);
$Threads_connected_avg	= (int)($Threads_connected_avg/$数量);
$Threads_created_avg	= (int)($Threads_created_avg/$数量);
$Threads_running_avg	= (int)($Threads_running_avg/$数量);



// A nice graph with anti-aliasing
if($_GET['统计单位']=="秒")			{
	$graph = new Graph(2200,600);
}
else	{
	$graph = new Graph(780,400);
}

$graph->img->SetMargin(45,120,45,45);
//$graph->SetBackgroundImage("tiger_bkg.png",BGIMG_FILLPLOT);
//$graph->img->SetImgFormat('png');
$graph->img->SetAntiAliasing("white");
$graph->SetScale("textlin");
$graph->SetShadow();
$graph->title->Set("Mysql Threads Monitor ".$统计时间."");

// Use built in font
$graph->title->SetFont(FF_FONT1,FS_BOLD);

// Slightly adjust the legend from it's default position in the
// top right corner.
$graph->legend->Pos(0.01,0.5,"right","center");

$graph->xaxis->SetTickLabels($datax);
$graph->xaxis->SetFont(FF_VERDANA,FS_NORMAL,10);
$graph->xaxis->SetLabelAngle(60);

//$Threads_cached[] = $rs_a[$i]['Threads_cached'];
//$Threads_connected[] = $rs_a[$i]['Threads_connected'];
//$Threads_created[] = $rs_a[$i]['Threads_created'];
//$Threads_running[] = $rs_a[$i]['Threads_running'];

//Threads_cached
$p1 = new LinePlot($Threads_cached);
$p1->SetColor("blue");
$p1->SetCenter();
$p1->SetLegend("Cached AVG:$Threads_cached_avg");
$graph->Add($p1);

//Threads_connected
$p2 = new LinePlot($Threads_connected);
$p2->SetColor("red");
$p2->SetCenter();
$p2->SetLegend("Connected AVG:$Threads_connected_avg");
$graph->Add($p2);

//Threads_connected
//$p3 = new LinePlot($Threads_created);
//$p3->SetColor("orange");
//$p3->SetCenter();
//$p3->SetLegend("Threads_created AVG:$Threads_created_avg");
//$graph->Add($p3);

//Threads_connected
$p4 = new LinePlot($Threads_running);
$p4->SetColor("green");
$p4->SetCenter();
$p4->SetLegend("Running AVG:$Threads_running_avg");
$graph->Add($p4);
// Output line



$graph->Stroke();

?><?php
/*
	版权归属:郑州单点科技软件有限公司;
	联系方式:0371-69663266;
	公司地址:河南郑州经济技术开发区第五大街经北三路通信产业园四楼西南;
	公司简介:郑州单点科技软件有限公司位于中国中部城市-郑州,成立于2007年1月,致力于把基于先进信息技术（包括通信技术）的最佳管理与业务实践普及到教育行业客户的管理与业务创新活动中，全面提供具有自主知识产权的教育管理软件、服务与解决方案，是中部最优秀的高校教育管理软件及中小学校管理软件提供商。目前已经有多家高职和中职类院校使用通达中部研发中心开发的软件和服务;

	软件名称:单点科技软件开发基础性架构平台,以及在其基础之上扩展的任何性软件作品;
	发行协议:数字化校园产品为商业软件,发行许可为LICENSE方式;单点CRM系统即SunshineCRM系统为GPLV3协议许可,GPLV3协议许可内容请到百度搜索;
	特殊声明:软件所使用的ADODB库,PHPEXCEL库,SMTARY库归原作者所有,余下代码沿用上述声明;
	*/
?>