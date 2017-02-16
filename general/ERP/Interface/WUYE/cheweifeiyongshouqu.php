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

	$hostname = "http://" . $_SERVER['SERVER_NAME'] . ":" . $_SERVER['SERVER_PORT'] . "" . $PHP_SELF . "/$FILE_NAME?单元编号=" . $_GET['单元编号'] . "&费用年月份=" . $_GET['费用年月份']. "&pageAction=write";
	//print_R($hostname);;exit;
	$file = file($hostname);
	$FILE_CONTENT = join('', $file);
	// $handle = fopen($filename, 'w');
	// fwrite($handle, $FILE_CONTENT);
	// fclose($handle);
	header('Content-Encoding: none');
	header('Content-Type: application/octetstream');
	header('Content-Disposition: attachment;filename=车位费统计表.xls');
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
page_css('车位缴费');

$page = isset($_GET['name'])?intval($_GET['name']):1;

//每页显示记录的条数
$each_sql = "select 每页条数 from wu_eachpage";
$num = $db -> Execute($each_sql);
$rs = $num -> GetArray();
$each_page = $rs['0']['每页条数'];

if($_GET['name']=="tingchechang"){
	         
			 //得到疼车场名称和年月份，然后将对应停车位循环保存到数组中
			 global $停车场名称;
			 global $缴费年月份;	
			 $停车场名称 = $_GET['停车场名称'];
			 $缴费年月份 = $_GET['缴费年月份'];
             //echo $缴费年月份;
			 $sel_sql = "select * from wu_tingchewei where 停车场名称='$停车场名称'";
			 $sel_rs  = $db->Execute($sel_sql);
			 $sel_rs_a = $sel_rs->GetArray();
			 for($i=0;$i<=sizeof($sel_rs_a);$i++){
			     $停车位名称 = $sel_rs_a[$i]['停车位名称'];
				 $停车位[]=$停车位名称;
			 }
             $queren = "true";
}else{
            //系统默认显示的记录，以一定格式得到当前的时间
			$缴费年月份	= date("Y-m",mktime(1,1,1,date("m"),date("d"),date("Y")));
			$row_sql = "select COUNT(*) AS sum from wuye_wuyetingchechangguanli where 所缴费月份='".$缴费年月份."'";
			$row_rs = $db -> Execute($row_sql);
			$total1 = $row_rs -> fields['sum'];

			if($total1>0){		
				$total_page = ceil($total1/$each_page);        
				$page = ($page<1)?1:$page;
				$page = ($page>$total_page)?$total_page:$page;
				$offset = ($page-1)*$each_page;
				$sql = "select * from wuye_wuyetingchechangguanli where 所缴费月份='".$缴费年月份."' order by 所缴费月份 desc LIMIT $offset,$each_page";
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
	         <td colspan="">&nbsp;停车场名称：&nbsp;&nbsp;&nbsp;
			 <?php

			    //得到停车场名称
				$tingche_sql = "select 停车场名称 from wu_tingchechang where 1=1 order by 停车场名称 asc";
				$tingche_rs = $db->Execute($tingche_sql);
				$tingche_rs_a = $tingche_rs->GetArray();
                
				for($i=0;$i<=sizeof($tingche_rs_a);$i++){
					$停车场名称X = $tingche_rs_a[$i]['停车场名称'];
					//if($i%5 == 0) print "<br>";
					if($停车场名称X==$停车场名称) $color="red"; else $color = "green";
						
                    print "&nbsp;<a href=\"?".base64_encode("name=tingchechang&停车场名称=$停车场名称X")."\"><font color=$color>$停车场名称X</font></a>\n";
				}
			 ?>

				<B>缴费年月份：</B>
				<?php
				//得到年月份
				$停车场名称=$_GET['停车场名称'];
				$name=$_GET['name'];
				$缴费年月份array=array();
				for($i=0;$i>=-6;$i--)				{
					$当前时间年月	= date("Y-m",mktime(0,0,0,date("m")+$i,1,date("Y")));
					$缴费年月份array[]=$当前时间年月;
					}	
					if($缴费年月份!=null){
					$缴费年月份=$_GET['缴费年月份'];
					}else{
					$缴费年月份=$缴费年月份array[0];
					}
					print "<Select name='缴费年月份'  onChange=\"var jmpURL='?flag=jump&停车场名称=$停车场名称&name=$name&缴费年月份=' + this.options[this.selectedIndex].value; if(jmpURL!='') {window.location=jmpURL;} else {this.selectedIndex=0;}\">";
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
		 </td>
     </tr>
</table>
<table class="TableBlock" width="100%" align="center">
	   <tr align="left" class="TableHeader"><td colspan="12">缴费信息统计(单位：月) [总计：<?php echo  $total1?>条]</td></tr>
	   <tr align="center" class="TableHeader">
				 <TD noWrap>序号</TD>
				 <TD noWrap>停车位</TD>
				 <TD noWrap>房间号码</TD>
				 <TD noWrap>业主</TD>
				 <TD noWrap>联系电话</TD>
				 <TD noWrap>车牌</TD>
				 <TD noWrap>车辆类别</TD>
				 <TD noWrap>车位状态</TD>
				 <TD noWrap>缴费月份</TD>
				 <TD noWrap>是否缴费</TD>
				 <TD noWrap>操作</TD>
	   </tr>
<?php
/**********
对提交过来的数据进行判断，然后选择输出方式
***********/
if($queren = "true"){
	    
		//将得到的数据循环输出
		foreach((array)$停车位 as $val){
					$rows_sql = "select COUNT(*) AS sum from wuye_wuyetingchechangguanli where 停车位='$val' and 所缴费月份='$缴费年月份'";
					$rows_rs = $db -> Execute($rows_sql);
					$total = $rows_rs -> fields['sum'];

					if($total>0){						
						$sql = "select * from wuye_wuyetingchechangguanli where 停车位='$val' and 所缴费月份='$缴费年月份' order by 所缴费月份 desc";
						$rs = $db -> Execute($sql);
						$rs_a = $rs -> GetArray();			
						for($i=0;$i<sizeof($rs_a);$i++){
							$编号       = $rs_a[$i]['编号'];
							$停车位	    = $rs_a[$i]['停车位'];
							$房间号码	= $rs_a[$i]['房间号码'];
							$业主	    = $rs_a[$i]['业主'];
							$联系电话	= $rs_a[$i]['联系电话'];
							$车牌       = $rs_a[$i]['车牌'];
							$车辆类别	= $rs_a[$i]['车辆类别'];
							$车位状态	= $rs_a[$i]['车位状态'];
							$缴费月份   = $rs_a[$i]['所缴费月份'];
							$是否缴费   = $rs_a[$i]['是否缴费'];
                            
							if($是否缴费==0){
					          $是否缴费="否";
							  $j = $i+1;
							  print "<tr align=\"center\" class=\"TableData\">
										 <TD noWrap>&nbsp;".$j."</TD>
										 <TD noWrap>&nbsp;<font color=\"blue\">".$停车位."</font></TD>
										 <TD noWrap>&nbsp;".$房间号码."</TD>
										 <TD noWrap>&nbsp;".$业主."</TD>
										 <TD noWrap>&nbsp;<font color=\"green\">".$联系电话."</font></TD>
										 <TD noWrap>&nbsp;".$车牌."</TD>
										 <TD noWrap>&nbsp;".$车辆类别."</TD>
										 <TD noWrap>&nbsp;<font color=\"green\">".$车位状态."</font></TD>
										 <TD noWrap>&nbsp;".$缴费月份."</TD>
										 <TD noWrap>&nbsp;<font color=\"blue\">".$是否缴费."</font></TD>
										 <TD noWrap>&nbsp;<a class=OrgAdd href=\"wuye1_wuyetingchechangguanli_newai.php?".base64_encode("action=edit_default&编号=$编号&编号_NAME=$编号&编号_disabled=disabled")."\">点击缴费</a>&nbsp;<a class=OrgAdd href=\"cheweifeibaobiao.php?action=fxp&编号=$编号\">打印明细</a></TD>
									  </tr>";
							}else if($是否缴费==1){
					            $是否缴费="是";
								$j = $i+1;
								print "<tr align=\"center\" class=\"TableData\">
										 <TD noWrap>&nbsp;".$j."</TD>
										 <TD noWrap>&nbsp;<font color=\"blue\">".$停车位."</font></TD>
										 <TD noWrap>&nbsp;".$房间号码."</TD>
										 <TD noWrap>&nbsp;".$业主."</TD>
										 <TD noWrap>&nbsp;<font color=\"green\">".$联系电话."</font></TD>
										 <TD noWrap>&nbsp;".$车牌."</TD>
										 <TD noWrap>&nbsp;".$车辆类别."</TD>
										 <TD noWrap>&nbsp;<font color=\"green\">".$车位状态."</font></TD>
										 <TD noWrap>&nbsp;".$缴费月份."</TD>
										 <TD noWrap>&nbsp;<font color=\"red\">".$是否缴费."</font></TD>
										 <TD noWrap>&nbsp;<a class=OrgAdd href=\"#\" onClick=\"return confirm('本月费用已缴!')\">点击缴费</a>&nbsp;<a class=OrgAdd href=\"cheweifeibaobiao.php?action=fxp&编号=$编号\">打印明细</a></TD>
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
					$停车位	    = $rs_aa[$i]['停车位'];
					$房间号码	= $rs_aa[$i]['房间号码'];
					$业主	    = $rs_aa[$i]['业主'];
					$联系电话	= $rs_aa[$i]['联系电话'];
					$车牌       = $rs_aa[$i]['车牌'];
					$车辆类别	= $rs_aa[$i]['车辆类别'];
					$车位状态	= $rs_aa[$i]['车位状态'];
					$缴费月份   = $rs_aa[$i]['所缴费月份'];
					$是否缴费   = $rs_aa[$i]['是否缴费'];
                    if($是否缴费==0){
					   $是否缴费="否";
					   $j = $i+1;
					   print "<tr align=\"center\" class=\"TableData\">
								 <TD noWrap>&nbsp;".$j."</TD>
								 <TD noWrap>&nbsp;<font color=\"blue\">".$停车位."</font></TD>
								 <TD noWrap>&nbsp;".$房间号码."</TD>
								 <TD noWrap>&nbsp;".$业主."</TD>
								 <TD noWrap>&nbsp;<font color=\"green\">".$联系电话."</font></TD>
								 <TD noWrap>&nbsp;".$车牌."</TD>
								 <TD noWrap>&nbsp;".$车辆类别."</TD>
								 <TD noWrap>&nbsp;<font color=\"green\">".$车位状态."</font></TD>
								 <TD noWrap>&nbsp;".$缴费月份."</TD>
								 <TD noWrap>&nbsp;<font color=\"blue\">".$是否缴费."</font></TD>
                                 <TD noWrap>&nbsp;<a class=OrgAdd href=\"wuye1_wuyetingchechangguanli_newai.php?".base64_encode("action=edit_default&编号=$编号&编号_NAME=$编号&编号_disabled=disabled")."\">点击缴费</a>&nbsp;<a class=OrgAdd href=\"cheweifeibaobiao.php?action=fxp&编号=$编号\">打印明细</a></TD>
							   </tr>";
					}else if($是否缴费==1){
					   $是否缴费="是";
					   $j = $i+1;
					   print "<tr align=\"center\" class=\"TableData\">
								 <TD noWrap>&nbsp;".$j."</TD>
								 <TD noWrap>&nbsp;<font color=\"blue\">".$停车位."</font></TD>
								 <TD noWrap>&nbsp;".$房间号码."</TD>
								 <TD noWrap>&nbsp;".$业主."</TD>
								 <TD noWrap>&nbsp;<font color=\"green\">".$联系电话."</font></TD>
								 <TD noWrap>&nbsp;".$车牌."</TD>
								 <TD noWrap>&nbsp;".$车辆类别."</TD>
								 <TD noWrap>&nbsp;<font color=\"green\">".$车位状态."</font></TD>
								 <TD noWrap>&nbsp;".$缴费月份."</TD>
								 <TD noWrap>&nbsp;<font color=\"red\">".$是否缴费."</font></TD>
                                 
								 
                                 <TD noWrap>&nbsp;<a class=OrgAdd href=\"#\" onClick=\"return confirm('本月费用已缴!')\">点击缴费</a>&nbsp;<a class=OrgAdd href=\"cheweifeibaobiao.php?action=fxp&编号=$编号\">打印明细</a></TD>
							   </tr>";
				  }
		}

?>  
<!-- 
以下代码是将此页面导出按钮，对默认数据进行分页处理
-->
    <tr align="center" class="tableContent">
	     <td colspan="12" >
		 <INPUT TYPE="button" VALUE="导出" class="SmallButton"  align="left" ONCLICK="location='?pageAction=ExportDataToFile&单元编号=<?php echo $_GET['房间号码']?>&费用年月份=<?php echo $_GET['缴费年月份']?>'">
		 <?php 
		 
		 if($total1>0){
		 echo sprintf("共%d条记录 %d/%d页",$total1,$page,$total_page)."&nbsp;&nbsp;";
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
		<td noWrap colspan="12" align=left>
		<font color="green">说明：</font><br>
			&nbsp;&nbsp;&nbsp;&nbsp;1 本页面是查询租用车位缴费情况列表，<font color="red">数据是 <?php if($_GET['name']=="tingchechang"){
				echo $缴费年月份;
		    }else{
		        $时间 = date("Y-m",mktime(1,1,1,date("m"),date("d"),date("Y")));
		        echo $时间;
		    }?> 月数据</font>.<br>
			&nbsp;&nbsp;&nbsp;&nbsp;2 点击对应的车位所在的停车场和缴费时间，将所对应的停车场里面停车位的缴费情况列表.<br>
			&nbsp;&nbsp;&nbsp;&nbsp;3 点击后面的操作，能够进行缴费、打印账单等.<br>
			&nbsp;&nbsp;&nbsp;&nbsp;4 设置每页显示的条数请到物业系统管理->数据字典->分页条数设置里面进行修改.
		</td>
	</tr>
</table>
</body>
</html>