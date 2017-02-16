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

?>


