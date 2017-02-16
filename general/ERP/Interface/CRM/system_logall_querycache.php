<?php
ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL);
error_reporting(E_WARNING | E_ERROR);
require_once('lib.inc.php');
$GLOBAL_SESSION=returnsession();
// content="text/plain; charset=utf-8"
require_once ('../../Enginee/jpgraph/jpgraph.php');
require_once ('../../Enginee/jpgraph/jpgraph_line.php');

if($_GET['ͳ��ʱ��']!='')	$ͳ��ʱ�� = $_GET['ͳ��ʱ��'];
else						$ͳ��ʱ�� = date("Y-m-d");

if($_GET['ͳ�Ƶ�λ']=="��")			{
	$sql = "select DATE_FORMAT(��ǰʱ��,'%H-%i') AS ʱ��X,
				avg(Qcache_free_blocks) AS Qcache_free_blocks,
				avg(Qcache_free_memory) AS Qcache_free_memory,
				avg(Qcache_hits) AS Qcache_hits,
				avg(Qcache_inserts) AS Qcache_inserts,
				avg(Qcache_not_cached) AS Qcache_not_cached,
				avg(Qcache_queries_in_cache) AS Qcache_queries_in_cache,
				avg(Qcache_total_blocks) AS Qcache_total_blocks,
				avg(Qcache_lowmem_prunes) AS Qcache_lowmem_prunes
		from system_logall
		where DATE_FORMAT(��ǰʱ��,'%Y-%m-%d')='$ͳ��ʱ��'
		group by DATE_FORMAT(��ǰʱ��,'%Y-%m-%d-%H-%i')
		";
}
else		{
	$sql = "select DATE_FORMAT(��ǰʱ��,'%H') AS ʱ��X,
				avg(Qcache_free_blocks) AS Qcache_free_blocks,
				avg(Qcache_free_memory) AS Qcache_free_memory,
				avg(Qcache_hits) AS Qcache_hits,
				avg(Qcache_inserts) AS Qcache_inserts,
				avg(Qcache_not_cached) AS Qcache_not_cached,
				avg(Qcache_queries_in_cache) AS Qcache_queries_in_cache,
				avg(Qcache_total_blocks) AS Qcache_total_blocks,
				avg(Qcache_lowmem_prunes) AS Qcache_lowmem_prunes
		from system_logall
		where DATE_FORMAT(��ǰʱ��,'%Y-%m-%d')='$ͳ��ʱ��'
		group by DATE_FORMAT(��ǰʱ��,'%Y-%m-%d-%H')
		";
}
$rs = $db->CacheExecute(150,$sql);
$rs_a = $rs->GetArray();
$���� = sizeof($rs_a);
$datax = array();
$datay = array();
if($����>100) $����-=10;
for($i=0;$i<$����;$i++)			{
	$rs_a[$i]['Qcache_free_blocks'] = $rs_a[$i]['Qcache_free_blocks']/10;
	$rs_a[$i]['Qcache_free_memory'] = $rs_a[$i]['Qcache_free_memory']/1000000;
	$rs_a[$i]['Qcache_hits']		= $rs_a[$i]['Qcache_hits']/1000000;
	$rs_a[$i]['Qcache_inserts']		= $rs_a[$i]['Qcache_inserts']/100000;

	$rs_a[$i]['Qcache_not_cached']		= $rs_a[$i]['Qcache_not_cached']/10000;
	$rs_a[$i]['Qcache_queries_in_cache']= $rs_a[$i]['Qcache_queries_in_cache']/100;
	$rs_a[$i]['Qcache_total_blocks']	= $rs_a[$i]['Qcache_total_blocks']/100;

	$Qcache_free_blocks[]	= $rs_a[$i]['Qcache_free_blocks'];
	$Qcache_free_memory[]	= $rs_a[$i]['Qcache_free_memory'];
	$Qcache_hits[]			= $rs_a[$i]['Qcache_hits'];
	$Qcache_inserts[]		= $rs_a[$i]['Qcache_inserts'];
	$Qcache_lowmem_prunes[]	= $rs_a[$i]['Qcache_lowmem_prunes'];
	$Qcache_not_cached[]	= $rs_a[$i]['Qcache_not_cached'];
	$Qcache_queries_in_cache[]	= $rs_a[$i]['Qcache_queries_in_cache'];
	$Qcache_total_blocks[]		= $rs_a[$i]['Qcache_total_blocks'];

	$Qcache_free_blocks_avg	+= $rs_a[$i]['Qcache_free_blocks'];
	$Qcache_free_memory_avg	+= $rs_a[$i]['Qcache_free_memory'];
	$Qcache_hits_avg		+= $rs_a[$i]['Qcache_hits'];
	$Qcache_inserts_avg		+= $rs_a[$i]['Qcache_inserts'];
	$Qcache_lowmem_prunes_avg	+= $rs_a[$i]['Qcache_lowmem_prunes'];
	$Qcache_not_cached_avg		+= $rs_a[$i]['Qcache_not_cached'];
	$Qcache_queries_in_cache_avg+= $rs_a[$i]['Qcache_queries_in_cache'];
	$Qcache_total_blocks_avg	+= $rs_a[$i]['Qcache_total_blocks'];

	$datax[] = $rs_a[$i]['ʱ��X'];
}



$Qcache_free_blocks_avg	= (int)($Qcache_free_blocks_avg/$����);
$Qcache_free_memory_avg	= (int)($Qcache_free_memory_avg/$����);
$Qcache_hits_avg		= (int)($Qcache_hits_avg/$����);
$Qcache_inserts_avg		= (int)($Qcache_inserts_avg/$����);
$Qcache_lowmem_prunes_avg	= (int)($Qcache_lowmem_prunes_avg/$����);
$Qcache_not_cached_avg		= (int)($Qcache_not_cached_avg/$����);
$Qcache_queries_in_cache_avg= (int)($Qcache_queries_in_cache_avg/$����);
$Qcache_total_blocks_avg	= (int)($Qcache_total_blocks_avg/$����);



// A nice graph with anti-aliasing
if($_GET['ͳ�Ƶ�λ']=="��")			{
	$graph = new Graph(2200,600);
}
else	{
	$graph = new Graph(780,400);
}

$graph->img->SetMargin(45,120,45,45);
//$graph->SetBackgroundImage("tiger_bkg.png",BGIMG_FILLPLOT);

$graph->img->SetAntiAliasing("white");
$graph->SetScale("textlin");
$graph->SetShadow();
$graph->title->Set("Mysql Query Cache Monitor ".$ͳ��ʱ��."");

// Use built in font
$graph->title->SetFont(FF_FONT1,FS_BOLD);

// Slightly adjust the legend from it's default position in the
// top right corner.
$graph->legend->Pos(0.01,0.5,"right","center");


$graph->xaxis->SetTickLabels($datax);
$graph->xaxis->SetFont(FF_VERDANA,FS_NORMAL,10);
$graph->xaxis->SetLabelAngle(30);


//$Qcache_free_blocks[] = $rs_a[$i]['Qcache_free_blocks'];
//$Qcache_free_memory[] = $rs_a[$i]['Qcache_free_memory'];
//$Qcache_hits[] = $rs_a[$i]['Qcache_hits'];
//$Qcache_inserts[] = $rs_a[$i]['Qcache_inserts'];

//Qcache_free_blocks
$p1 = new LinePlot($Qcache_free_blocks);
$p1->SetColor("blue");
$p1->SetCenter();
$p1->SetLegend("FreeBlock AVG:$Qcache_free_blocks_avg [10]");
$graph->Add($p1);

//Qcache_free_memory
$p2 = new LinePlot($Qcache_free_memory);
$p2->SetColor("red");
$p2->SetCenter();
$p2->SetLegend("FreeMemory AVG:$Qcache_free_memory_avg [1000000]");
$graph->Add($p2);

//Qcache_free_memory
$p3 = new LinePlot($Qcache_hits);
$p3->SetColor("orange");
$p3->SetCenter();
$p3->SetLegend("Hits AVG:$Qcache_hits_avg [1000000]");
$graph->Add($p3);

//Qcache_free_memory
$p4 = new LinePlot($Qcache_inserts);
$p4->SetColor("green");
$p4->SetCenter();
$p4->SetLegend("Inserts AVG:$Qcache_inserts_avg [10]");
$graph->Add($p4);


//Qcache_free_memory
$p5 = new LinePlot($Qcache_not_cached);
$p5->SetColor("#CC3399");
$p5->SetCenter();
$p5->SetLegend("NotCached AVG:$Qcache_not_cached_avg [10000]");
$graph->Add($p5);


//Qcache_free_memory
$p6 = new LinePlot($Qcache_inserts);
$p6->SetColor("#6699CC");
$p6->SetCenter();
$p6->SetLegend("inserts AVG:$Qcache_inserts_avg [100000]");
$graph->Add($p6);


//Qcache_free_memory
$p7 = new LinePlot($Qcache_queries_in_cache);
$p7->SetColor("gray");
$p7->SetCenter();
$p7->SetLegend("QueryInCache AVG:$Qcache_queries_in_cache_avg [100]");
$graph->Add($p7);


//Qcache_free_memory
$p4 = new LinePlot($Qcache_total_blocks);
$p4->SetColor("black");
$p4->SetCenter();
$p4->SetLegend("TotalBlocks AVG:$Qcache_total_blocks_avg [100]");
$graph->Add($p4);


// Output line
$graph->Stroke();

?><?php
/*
	��Ȩ����:֣�ݵ���Ƽ�������޹�˾;
	��ϵ��ʽ:0371-69663266;
	��˾��ַ:����֣�ݾ��ü��������������־�����·ͨ�Ų�ҵ԰��¥����;
	��˾���:֣�ݵ���Ƽ�������޹�˾λ���й��в�����-֣��,������2007��1��,�����ڰѻ����Ƚ���Ϣ����������ͨ�ż���������ѹ�����ҵ��ʵ���ռ���������ҵ�ͻ��Ĺ�����ҵ���»�У�ȫ���ṩ��������֪ʶ��Ȩ�Ľ�����������������������������в�������ĸ�У���������������СѧУ��������ṩ�̡�Ŀǰ�Ѿ��ж�Ҹ�ְ����ְ��ԺУʹ��ͨ���в��з����Ŀ���������ͷ���;

	�������:����Ƽ�������������Լܹ�ƽ̨,�Լ��������֮����չ���κ��������Ʒ;
	����Э��:���ֻ�У԰��ƷΪ��ҵ���,�������ΪLICENSE��ʽ;����CRMϵͳ��SunshineCRMϵͳΪGPLV3Э�����,GPLV3Э����������뵽�ٶ�����;
	��������:�����ʹ�õ�ADODB��,PHPEXCEL��,SMTARY���ԭ��������,���´���������������;
	*/
?>