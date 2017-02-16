<?php
ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL);

// display warnings and errors
error_reporting(E_WARNING | E_ERROR);
require_once('lib.inc.php');//

$GLOBAL_SESSION=returnsession();
$SYSTEM_PRIV_STOP = 1;
//echo 'hello';
$部门=$_GET['bumen'];$姓名=$_GET['name'];$年份=$_GET['y'];$月份=$_GET['m'];
//echo $部门.$姓名.$年份.$月份;
page_css("薪酬统计");
$信息=InFo($姓名,$年份,$月份);
//print_r($信息);
echo '<table class="TableBlock" align="center">';echo '<tr class="TableHeader">';
echo '<td>类别</td>';echo '<td>金额</td>';echo '</tr>';

for($i=0;$i<sizeof($信息);$i++){
  echo '<tr class="TableData" align="center">';
  echo '<td>'.$信息[$i]['费用名称'].'</td>';
   echo '<td>'.$信息[$i]['金额'].'</td>';
  echo '</tr>';
}
echo '</table>';
?>

<?php
function InFo($name,$y,$m){
 global $db;
 $sql="select 费用名称,金额 from hrms_salary_detail where 费用人员='".$name."' and 年份='".$y."' and 月份='".$m."'";
 $rs=$db->Execute($sql);
$rs_a = $rs -> GetArray();
		if(!is_array($rs_a))
		$rs_a = array();
		$信息 = $rs_a;
		return $信息;

}

?>