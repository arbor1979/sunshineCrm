<?php

# Example of using the WriteExcel module to create worksheet panes.
#
# reverse('?), May 2001, John McNamara, jmcnamara@cpan.org

# PHP port by Johann Hanne, 2005-11-01

@set_time_limit(100);
//ini_set();

require_once "class.writeexcel_workbook.inc.php";
require_once "class.writeexcel_worksheet.inc.php";

$fname = tempnam("/tmp", "panes.xls");
$workbook = &new writeexcel_workbook($fname);
$worksheet1 =& $workbook->addworksheet('Sheet1');

# Frozen panes
$worksheet1->freeze_panes(1, 0); # 1 row



#######################################################################
#
# Set up some formatting and text to highlight the panes
#

$header =& $workbook->addformat();
$header->set_color('white');
$header->set_align('center');
$header->set_align('vcenter');
$header->set_pattern();
$header->set_fg_color('#003399');

$center =& $workbook->addformat();
$center->set_align('center');


#######################################################################
#
# Sheet 1
#

$LitterArray = explode(',','A,B,C,D,E,F,G,H,I,J,K,L,M,N,O,P,Q,R,S,T,U,V,W,X,Y,Z');
$LeftArray = array();
$LitterSize = sizeof($LitterArray);
for($i=0;$i<10;$i++)					{	
	if($i==0)	$Little = '';
	else		$Little = $LitterArray[$i-1];

	for($ii=0;$ii<$LitterSize;$ii++)				{
		$PartLitte = $LitterArray[$ii];
		$Left = $Little.$PartLitte;
		array_push($LeftArray,$Left);
	}
}

$worksheet1->set_column('A:I', 16);
$worksheet1->set_row('0', 20);
$worksheet1->set_selection('C3');

for ($i=0;$i<=8;$i++) {
    $worksheet1->write(0, $i, 'Scroll downScroll down', $header);
}

for ($i=1;$i<=100;$i++) {
    for ($j=0;$j<=8;$j++) {
        $worksheet1->write($i, $j, $i+1, $center);
    }
}

$workbook->close();

header("Content-Type: application/x-msexcel; name=\"example-panes.xls\"");
header("Content-Disposition: inline; filename=\"example-panes.xls\"");
$fh=fopen($fname, "rb");
fpassthru($fh);
unlink($fname);

?>
