<?php
require_once('lib.inc.php');

$Text = file('temp.txt');
$sql = "delete from  officeproductgroup ;";
print $sql."<BR>";
for($i=0;$i<sizeof($Text);$i++)			{
	$Line = $Text[$i];
	if($i%2==0)		{
		$CC++;
		$Line = ereg_replace('��','',$Line);
		$һ��Ŀ¼ = trim($Line);
		$һ��Ŀ¼ǰ׺ = substr($Line,0,1);
		$sql = "insert into officeproductgroup values('','$һ��Ŀ¼','$CC','');";
		print $sql."<BR>";
	}
	else			{
		$LineArray = explode('��',$Line);
		for($iX=0;$iX<sizeof($LineArray);$iX++)			{
			$CC++;
			$�������� = $LineArray[$iX]."(".$һ��Ŀ¼ǰ׺."-".($iX+1).")";
			if(TRIM($LineArray[$iX])!="") {
				$sql = "insert into officeproductgroup values('','$��������','$CC','$һ��Ŀ¼');";
				print $sql."<BR>";
			}
		}
	}
}

?>