<?php
require_once('lib.inc.php');

$Text = file('temp.txt');
$sql = "delete from  officeproductgroup ;";
print $sql."<BR>";
for($i=0;$i<sizeof($Text);$i++)			{
	$Line = $Text[$i];
	if($i%2==0)		{
		$CC++;
		$Line = ereg_replace('、','',$Line);
		$一级目录 = trim($Line);
		$一级目录前缀 = substr($Line,0,1);
		$sql = "insert into officeproductgroup values('','$一级目录','$CC','');";
		print $sql."<BR>";
	}
	else			{
		$LineArray = explode('、',$Line);
		for($iX=0;$iX<sizeof($LineArray);$iX++)			{
			$CC++;
			$二级分类 = $LineArray[$iX]."(".$一级目录前缀."-".($iX+1).")";
			if(TRIM($LineArray[$iX])!="") {
				$sql = "insert into officeproductgroup values('','$二级分类','$CC','$一级目录');";
				print $sql."<BR>";
			}
		}
	}
}

?>