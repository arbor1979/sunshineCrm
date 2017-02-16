<?php
	require_once('lib.inc.php');
	session_start();
/******************导出*****************************************************************************************/
//&pageid=" . $_GET['pageid'] . "

if($_GET['pageAction']!="write")
{

	$GLOBAL_SESSION=returnsession();
}
else{
	session_start();
}

if ($_GET['pageAction'] == "ExportDataToFile")
{
	$PHP_SELF = $_SERVER['PHP_SELF'];
	$PHP_SELF_ARRAY = explode('/', $_SERVER['PHP_SELF']);
	$FILE_NAME = array_pop($PHP_SELF_ARRAY);
	$PHP_SELF = @join('/', $PHP_SELF_ARRAY);
	$filename = "FileCache/" . $FILE_NAME . "_" . date("Y-m-d-H") . ".xls";

	$hostname = "http://" . $_SERVER['SERVER_NAME'] . ":" . $_SERVER['SERVER_PORT'] . "" . $PHP_SELF . "/$FILE_NAME?check_until=" . $_GET['check_until'] . "&check_year=" . $_GET['check_year']. "&pageAction=write";
	//print_R($hostname);;exit;
	$file = file($hostname);
	$FILE_CONTENT = join('', $file);
	// $handle = fopen($filename, 'w');
	// fwrite($handle, $FILE_CONTENT);
	// fclose($handle);
	header('Content-Encoding: none');
	header('Content-Type: application/octetstream');
	header('Content-Disposition: attachment;filename=欠费统计表.xls');
	header('Content-Length: ' . strlen($FILE_CONTENT));
	header('Pragma: no-cache');
	header('Expires: 0');
	echo $FILE_CONTENT;
	exit;
}
/******************导出*****************************************************************************************/
ini_set('display_errors', 1);
	ini_set('error_reporting', E_ALL);
	error_reporting(E_WARNING | E_ERROR);
	page_css('欠费统计');

$page = isset($_GET['name'])?intval($_GET['name']):1;

//每页显示记录的条数
$each_sql = "select 每页条数 from wu_eachpage";
$num = $db -> Execute($each_sql);
$rs = $num -> GetArray();
//print_r($rs['0']);
$each_page = $rs['0']['每页条数'];
//echo current($rs['0']);

if($_GET['name']=="dalou"){
			 global $大楼名称;
			 global $缴费年月份;	
			 $大楼名称 = $_GET['大楼名称'];
			 $缴费年月份 = $_GET['缴费年月份'];
             //echo $缴费年月份;
			 $sel_sql = "select * from wu_housingresources where 大楼名称='$大楼名称'";
			 $sel_rs  = $db->Execute($sel_sql);
			 $sel_rs_a = $sel_rs->GetArray();
			 for($i=0;$i<=sizeof($sel_rs_a);$i++){
			     $单元编号 = $sel_rs_a[$i]['房间号码'];
				 $单元[]=$单元编号;
			 }

             $queren = "true";

}else{
            //系统默认显示的记录，以一定格式得到当前的时间
			$缴费年月份	= date("Y-m",mktime(1,1,1,date("m")-1,date("d"),date("Y")));
			$row_sql = "select COUNT(*) AS sum from wu_costsummary where 费用年月份='".$缴费年月份."'";
			$row_rs = $db -> Execute($row_sql);
			$total1 = $row_rs -> fields['sum'];


			if($total1>0){		
				$total_page = ceil($total1/$each_page);        
				$page = ($page<1)?1:$page;
				$page = ($page>$total_page)?$total_page:$page;
				$offset = ($page-1)*$each_page;
				$sql = "select * from wu_costsummary where 费用年月份='".$缴费年月份."' order by 本次应收 desc LIMIT $offset,$each_page";
				
				$rs = $db -> Execute($sql);
				$rs_aa = $rs -> GetArray();
				
				$queren = "true1";
			}else{

				print "<table  width=\"100%\" align=\"center\">
							<tr class=\"TableDate\" align=\"center\">
								 <td noWrap>
									<font size=\"3\" color=\"red\">对不起，此年月份没有数据！</font>
								 </td>
							</tr>
					   </table>";

			}
}		
		
?>

<FORM METHOD="GET" ACTION="?action=submit">

<table class="TableBlock" width="100%" align="center">
     <tr align="left" class="TableHeader">
	         <td colspan="">&nbsp;区域名称：&nbsp;&nbsp;&nbsp;

			 <?php
			 
			    $区域名称 = $_GET['区域名称'];

			    //得带区域名称列表
				$quyu_sql = "select 区域名称 from wu_managementdistrict where 1=1 order by 区域名称 asc";
				$quyu_rs = $db->Execute($quyu_sql);
				$quyu_rs_a = $quyu_rs->GetArray();
                
				for($i=0;$i<=sizeof($quyu_rs_a);$i++){
					$区域名称X = $quyu_rs_a[$i]['区域名称'];
					//if($i%5 == 0) print "<br>";
					if($区域名称X==$区域名称) $color="red"; else $color = "green";
						
                    print "&nbsp;<a href=\"?".base64_encode("区域名称=$区域名称X&check_year=$check_year")."\"><font color=$color>$区域名称X</font></a>\n";
				}
			 ?>

				<B>缴费年月份：</B>
				<?php
				$区域名称=$_GET['区域名称'];
				$name=$_GET['name'];
				$缴费年月份array=array();
				for($i=-1;$i>=-6;$i--)				{
					$当前时间年月	= date("Y-m",mktime(0,0,0,date("m")+$i,1,date("Y")));
					$缴费年月份array[]=$当前时间年月;
					}	
					if($缴费年月份!=null){
					$缴费年月份=$_GET['缴费年月份'];
					}else{
					$缴费年月份=$缴费年月份array[0];
					}
					print "<Select name='缴费年月份'  onChange=\"var jmpURL='?flag=jump&区域名称=$区域名称&name=$name&缴费年月份=' + this.options[this.selectedIndex].value; if(jmpURL!='') {window.location=jmpURL;} else {this.selectedIndex=0;}\">";
					for($i=0;$i<sizeof($缴费年月份array);$i++)
						{
							if($缴费年月份== $缴费年月份array[$i])
								$Selected = "selected";
							else
								$Selected = "";
					print "<Option ".$Selected." value='".$缴费年月份array[$i]."'>".$缴费年月份array[$i]."</Option>";
						}
					print "</Select>";
		
				?>
				<!-- 
				<?php 
                   //$时间array[]=array();
				   for($i=0;$i>=-6;$i--)				{
		              $当前时间年月	= date("Y-m",mktime(0,0,0,date("m")+$i,date("d"),date("Y")));
					  $时间array[]=$当前时间年月;
                   }
                   // print_r($时间array);
				   print "<Select name='check_year'>";
				    
				   $check_year=$_GET['check_year'];
				   for($i=0;$i<sizeof($时间array);$i++){
						if($check_year== $时间array[$i])
							$Selected = "selected";
						else
							$Selected = "";
				        print "<Option ".$Selected." value='".$时间array[$i]."'>".$时间array[$i]."</Option>";
			       }
	               print "</Select>";
				?>
				 -->
		 </td>
     </tr>
	 <tr align="left" class="TableContent">
	     <td>
		 <?php
		  //得到区域名称下对应的大楼名称列表

			  $大楼名称 = $_GET['大楼名称'];

              $区域名称 = $_GET['区域名称'];
			  if($区域名称 == ""){
			     $dalou_sql  = "select * from wu_buildinginformation where 区域名称='住宅A区'";
			  }else{
				 $dalou_sql  = "select * from wu_buildinginformation where 区域名称='$区域名称' ";
              }
				  $dalou_rs   = $db->Execute($dalou_sql);
				  $dalou_rs_a = $dalou_rs->GetArray();
				  for($i=0;$i<=sizeof($dalou_rs_a);$i++){

					  if($i!=0 and $i%10 == 0) print "<br>";
					  $大楼名称X = $dalou_rs_a[$i]['大楼名称'];

					  if($大楼名称X==$大楼名称) $color="red"; else $color="green";

					  print "&nbsp;&nbsp;<a href=\"?".base64_encode("name=dalou&大楼名称=$大楼名称X&缴费年月份=$缴费年月份&区域名称=$区域名称")."\"><font color=$color>$大楼名称X</font></a>&nbsp;&nbsp;&nbsp;&nbsp;";
				  
				  }

		 ?>
		 </td>
	 </tr>
</table>
<table class="TableBlock" width="100%" align="center">
	   <tr align="left" class="TableHeader"><td colspan=10>欠费信息统计(单位：月) [总计：<?php echo $total1?>条]</td></tr>
	   <tr align="center" class="TableHeader">
				 <TD noWrap>序号</TD>
				<!--<TD noWrap>缴费卡号</TD>-->
				 <TD noWrap>单元编号</TD>
				 <TD noWrap>业主姓名</TD>
				 <TD noWrap>联系方式</TD>
				 <TD noWrap>收款方式</TD>
				 <TD noWrap>费用年月份</TD>
				 <TD noWrap>本次应收</TD>
				 <TD noWrap>本次实收</TD>
				 <TD noWrap>操作</TD>
	   </tr>
<?php
/**********
对提交过来的数据进行判断，然后选择输出方式
***********/

if($queren = "true"){
		foreach((array)$单元 as $val){
					$rows_sql = "select COUNT(*) AS sum from wu_costsummary where 单元编号='$val' and 费用年月份='$缴费年月份'";
					$rows_rs = $db -> Execute($rows_sql);
					$total = $rows_rs -> fields['sum'];

					if($total>0){
						
						$sql = "select * from wu_costsummary where 单元编号='$val' and 费用年月份='$缴费年月份'order by 单元编号 desc";
						$rs = $db -> Execute($sql);
						$rs_a = $rs -> GetArray();
			
			
						for($i=0;$i<sizeof($rs_a);$i++){
							$编号       = $rs_a[$i]['编号'];
							//$缴费卡号	= $rs_a[$i]['缴费卡号'];
							$业主姓名	= $rs_a[$i]['业主姓名'];
							$业主房号	= $rs_a[$i]['单元编号'];
							$联系方式	= $rs_a[$i]['联系方式'];
							$收款方式	= $rs_a[$i]['收款方式'];
							$费用年月份 = $rs_a[$i]['费用年月份'];
							$本次应缴	= $rs_a[$i]['本次应收'];
							$本次实收	= $rs_a[$i]['本次实收'];

							//echo $本次实收."<br>";
							//$j = $i+1;

								if($本次实收 > 0.00){
					
									print "<tr align=\"center\" class=\"TableData\">
											 <TD noWrap>&nbsp;".$i++."</TD>
										
											 <TD noWrap>&nbsp;<font color=\"blue\">".$业主房号."</font></TD>
											 <TD noWrap>&nbsp;".$业主姓名."</TD>
											 <TD noWrap>&nbsp;".$联系方式."</TD>
											 <TD noWrap>&nbsp;<font color=\"green\">".$收款方式."</font></TD>
											 <TD noWrap>&nbsp;".$费用年月份."</TD>
											 <TD noWrap>&nbsp;".$本次应缴."</TD>
											 <TD noWrap>&nbsp;".$本次实收."</TD>
											 <TD noWrap>&nbsp;<font color=red>费用已缴</font>&nbsp;<a class=OrgAdd href=\"wu_shoufeibaobiao.php?action=fxp&编号=$编号\">打印明细</a></TD>
										   </tr>";
								
								}else{

									print "<tr align=\"center\" class=\"TableData\">
											 <TD noWrap>&nbsp;".$i++."</TD>
											 
											 <TD noWrap>&nbsp;<font color=\"blue\">".$业主房号."</font></TD>
											 <TD noWrap>&nbsp;".$业主姓名."</TD>
											 <TD noWrap>&nbsp;".$联系方式."</TD>
											 <TD noWrap>&nbsp;<font color=\"green\">".$收款方式."</font></TD>
											 <TD noWrap>&nbsp;".$费用年月份."</TD>
											 <TD noWrap>&nbsp;".$本次应缴."</TD>
											 <TD noWrap>&nbsp;<font color=\"red\">".$本次实收."</font></TD>
											 <TD noWrap>&nbsp;<a class=OrgAdd href=\"wu_costsummary_newai.php?".base64_encode("action=edit_default&编号=$编号&编号_NAME=$编号&编号_disabled=disabled")."\">点击缴费</a>&nbsp;&nbsp;<a class=OrgAdd href=\"wu_shoufeibaobiao.php?action=fxp&编号=$编号\">打印明细</a></TD>
										   </tr>";
								}
						}
				    }
		}

}
/**********************
以下for循环是输出默认情况下的数据
***********************/
				for($i=0;$i<sizeof($rs_aa);$i++){
                    $编号       = $rs_aa[$i]['编号'];
//echo $编号."<br>";

					//$缴费卡号	= $rs_aa[$i]['缴费卡号'];
					$业主姓名	= $rs_aa[$i]['业主姓名'];
					$业主房号	= $rs_aa[$i]['单元编号'];
					$联系方式	= $rs_aa[$i]['联系方式'];
					$收款方式	= $rs_aa[$i]['收款方式'];
					$费用年月份 = $rs_aa[$i]['费用年月份'];
					$本次应缴	= $rs_aa[$i]['本次应收'];
					$本次实收	= $rs_aa[$i]['本次实收'];
					$j = $i+1;

					if($本次实收 != 0.00){

						print "<tr align=\"center\" class=\"TableData\">
								 <TD noWrap>&nbsp;".$j."</TD>
								 
								 <TD noWrap>&nbsp;<font color=\"blue\">".$业主房号."</font></TD>
								 <TD noWrap>&nbsp;".$业主姓名."</TD>
								 <TD noWrap>&nbsp;".$联系方式."</TD>
								 <TD noWrap>&nbsp;<font color=\"green\">".$收款方式."</font></TD>
								 <TD noWrap>&nbsp;".$费用年月份."</TD>
								 <TD noWrap>&nbsp;".$本次应缴."</TD>
								 <TD noWrap>&nbsp;".$本次实收."</TD>
								 <TD noWrap>&nbsp;<font color=red>费用已缴</font>&nbsp;&nbsp;&nbsp;<a class=OrgAdd href=\"wu_shoufeibaobiao.php?action=fxp&编号=$编号\">打印明细</a></TD>
							   </tr>";
					
					}else{
						print "<tr align=\"center\" class=\"TableData\">
								 <TD noWrap>&nbsp;".$j."</TD>
								 
								 <TD noWrap>&nbsp;<font color=\"blue\">".$业主房号."</font></TD>
								 <TD noWrap>&nbsp;".$业主姓名."</TD>
								 <TD noWrap>&nbsp;".$联系方式."</TD>
								 <TD noWrap>&nbsp;<font color=\"green\">".$收款方式."</font></TD>
								 <TD noWrap>&nbsp;".$费用年月份."</TD>
								 <TD noWrap>&nbsp;".$本次应缴."</TD>
								 <TD noWrap>&nbsp;<font color=\"red\">".$本次实收."</font></TD>

                                 <TD noWrap>&nbsp;<a class=OrgAdd href=\"wu_costsummary_newai.php?".base64_encode("action=edit_default&xx=xx&编号=$编号&编号_NAME=$编号&编号_disabled=disabled")."\">点击缴费</a>&nbsp;<a class=OrgAdd href=\"wu_shoufeibaobiao.php?action=fxp&编号=$编号\">打印明细</a></TD>

						     
							   </tr>";
					}
				}
/******************
以下代码通过判断xx==xx来进行缴费操作，将缴费的项中本次实收改为所交的费用
******************/
/*
<TD noWrap>&nbsp;<a href=?xx=xx&本次应缴=$本次应缴&单元编号=$业主房号&费用年月份=$费用年月份>点击缴费</a></TD>

if($_GET['xx'] == "xx"){
	   $本次应缴   = $_GET['本次应缴'];
	   $单元编号   = $_GET['单元编号'];
	   $费用年月份 = $_GET['费用年月份'];
          
	   $upd_sql = "update wu_costsummary set 本次实收='$本次应缴' where 单元编号='$单元编号' and 费用年月份='$费用年月份'";
       $db->Execute($upd_sql);


}
*/

?>  
<!-- 
以下代码是将此页面导出按钮，对默认数据进行分页处理
-->
    <tr align="center" class="tableContent">
	     <td colspan="10" >
		 <INPUT TYPE="button" VALUE="导出" class="SmallButton"  align="left" ONCLICK="location='?pageAction=ExportDataToFile&check_until=<?php echo $_GET['check_until']?>&check_year=<?php echo $_GET['check_year']?>'">
		 <?php 
		 
		 if($total1>0){
		 echo sprintf("共%d条记录 %d/%d页",$total,$page,$total_page)."&nbsp;&nbsp;";
		 $n = $page+1;
		 $s = $page-1;
			
		
				if($page<=1){
					echo "<input type=\"button\" value=\"下一页\" class=\"SmallButton\" onClick=\"location.href='?name=$n'\">";
				}else if($page>=$total_page){
					echo "<input type=\"button\" value=\"上一页\" class=\"SmallButton\" onClick=\"location.href='?name=$s'\">";
				}else {		   
					echo "<input type=\"button\" value=\"上一页\" class=\"SmallButton\" onClick=\"location.href='?name=$s'\">&nbsp;";
					echo "<input type=\"button\" value=\"下一页\" class=\"SmallButton\" onClick=\"location.href='?name=$n'\">";
				}
         }
		 ?>
		 </td>
	</tr>
    <tr align="center" class="tableContent">
		<td noWrap colspan="10" align=left>
		<font color="green">说明：</font><br>
			&nbsp;&nbsp;&nbsp;&nbsp;1 默认数据时本月缴费欠费情况列表，<font color="red">数据是 <?php if($_GET['name']=="dalou"){
			  echo $缴费年月份;
			}else{
			     $时间 = date("Y-m",mktime(1,1,1,date("m")-1,date("d"),date("Y")));
				 echo $时间;
			     }?> 月数据</font>.<br>
			&nbsp;&nbsp;&nbsp;&nbsp;2 查询出来本次实收项目数据为“<font color="red">红</font>”色时，说明此项欠费，如果缴费点击缴费按钮进行缴费,如果用户需要缴费清单，请点击缴费按钮进入,然后打印.<br>
			&nbsp;&nbsp;&nbsp;&nbsp;3 首先选中需要查询的月份，然后点击所在的单元楼进行查询，并进行缴费操作.<br>
			&nbsp;&nbsp;&nbsp;&nbsp;4 设置每页显示的条数请到物业系统管理->数据字典->分页条数设置里面进行修改.
		</td>
	</tr>
</table>
</body>
</html>