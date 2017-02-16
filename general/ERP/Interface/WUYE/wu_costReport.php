<?php
	ini_set('display_errors', 1);
	ini_set('error_reporting', E_ALL);
	error_reporting(E_WARNING | E_ERROR);
	require_once('lib.inc.php');
	$GLOBAL_SESSION=returnsession();
	page_css('信息查询');

	$page = isset($_GET['name'])?intval($_GET['name']):1;
    
	//设置每页显示多少条记录
	$each_sql = "select 每页条数 from wu_eachpage";
	$num = $db -> Execute($each_sql);
	$res = $num -> GetArray();
	$each_page = current($res['0']);

	
if($_GET['action']=="submit"){
     
			//global $缴费卡号;
			global $单元编号;
			global $业主姓名;
			global $缴费年月份;

	if($_GET['xx']=="xx"){
		    
		    //$缴费卡号 = $_GET['check_card'];
			$单元编号 = $_GET['check_until'];
			$业主姓名 = $_GET['check_name'];
			$缴费年月份 = $_GET['check_year']; 
			//echo "dd<br>";
		
	}else{
			//$缴费卡号 = $_POST['check_card'];
			$单元编号 = $_POST['check_until'];
			$业主姓名 = $_POST['check_name'];
			$缴费年月份 = $_POST['check_year'];
    }

    if($单元编号 == "" && $缴费卡号 == "" && $业主姓名 == "" && $缴费年月份 !=""){

		//echo "eee<br>";
		$total_sql = "select COUNT(*) AS sum from wu_costsummary where 费用年月份='".$缴费年月份."'";
		$rs = $db -> Execute($total_sql);
		$total = $rs -> fields['sum'];
		if($total>0){
			$total_page = ceil($total/$each_page);
			$page = ($page<=1)?1:$page;
			$page = ($page>=$total_page)?$total_page:$page;
			$offset = ($page-1)*$each_page;
			$sql = "select * from wu_costsummary where 费用年月份='".$缴费年月份."' order by 本次实收 desc LIMIT $offset,$each_page";
            
			$rs = $db -> Execute($sql);
			$rs_a = $rs -> GetArray();
		}else{
		      print "<table  width=\"100%\" align=\"center\">
			            <tr class=\"TableDate\" align=\"center\">
						     <td noWrap>
							    <font size=\"3\" color=\"red\">对不起，没有查询到您需要的数据！</font>
							 </td>
						</tr>
			       </table>";
		}
	}else if($缴费卡号 == "" && $业主姓名 == "" && $缴费年月份 == "" && $单元编号 != ""){
		$total_sql = "select COUNT(*) AS sum from wu_costsummary where 单元编号='".$单元编号."'";
		$rs = $db -> Execute($total_sql);
		$total = $rs -> fields['sum'];
        if($total>0){
			$total_page = ceil($total/$each_page);
			$page = ($page<=1)?1:$page;
			$page = ($page>=$total_page)?$total_page:$page;
			$offset = ($page-1)*$each_page;
			$sql = "select * from wu_costsummary where 单元编号='".$单元编号."' order by 本次实收 desc LIMIT $offset,$each_page";
		
		    $rs = $db -> Execute($sql);
			$rs_a = $rs -> GetArray();
		}else{
			  print "<table  width=\"100%\" align=\"center\">
			            <tr class=\"TableDate\" align=\"center\">
						     <td noWrap>
							    <font size=\"3\" color=\"red\">对不起，没有查询到您需要的数据！</font>
							 </td>
						</tr>
			       </table>";
		}
	}else if($缴费卡号 == "" && $业主姓名 == "" && $缴费年月份 != "" && $单元编号 != ""){
        $total_sql = "select COUNT(*) AS sum from wu_costsummary where 单元编号='".$单元编号."' and 费用年月份='".$缴费年月份."'";
		$rs = $db -> Execute($total_sql);
		$total = $rs -> fields['sum'];
        if($total>0){
			$total_page = ceil($total/$each_page);
			$page = ($page<=1)?1:$page;
			$page = ($page>=$total_page)?$total_page:$page;
			$offset = ($page-1)*$each_page;
			$sql = "select * from wu_costsummary where 单元编号='".$单元编号."' and 费用年月份='".$缴费年月份."' order by 本次实收 desc LIMIT $offset,$each_page";
             
			$rs = $db -> Execute($sql);
			$rs_a = $rs -> GetArray();
		}else{
			  print "<table  width=\"100%\" align=\"center\">
			            <tr class=\"TableDate\" align=\"center\">
						     <td noWrap>
							    <font size=\"3\" color=\"red\">对不起，没有查询到您需要的数据！</font>
							 </td>
						</tr>
			       </table>";
		}

	}else if($单元编号 == "" && $缴费卡号 == "" && $业主姓名 != "" && $缴费月份 == "" && $缴费年份 == ""){
		$total_sql = "select COUNT(*) AS sum from wu_costsummary where 业主姓名='".$业主姓名."'";
		$rs = $db -> Execute($total_sql);
		$total = $rs -> fields['sum'];
        if($total>0){
			$total_page = ceil($total/$each_page);
			$page = ($page<=1)?1:$page;
			$page = ($page>=$total_page)?$total_page:$page;
			$offset = ($page-1)*$each_page;
			$sql = "select * from wu_costsummary where 业主姓名='".$业主姓名."' order by 本次实收 desc LIMIT $offset,$each_page";
        
			$rs = $db -> Execute($sql);
			$rs_a = $rs -> GetArray();
        }else{
		      print "<table  width=\"100%\" align=\"center\">
			            <tr class=\"TableDate\" align=\"center\">
						     <td noWrap>
							    <font size=\"3\" color=\"red\">对不起，没有查询到您需要的数据！</font>
							 </td>
						</tr>
			       </table>";
	    }

	}else if($单元编号 =="" && $缴费卡号 == "" && $缴费月份 == "" && $业主姓名 != "" && $缴费年月份 != ""){
		$total_sql = "select COUNT(*) AS sum from wu_costsummary where 业主姓名='".$业主姓名."' and 费用年月份='".$缴费年月份."'";
		$rs = $db -> Execute($total_sql);
		$total = $rs -> fields['sum'];
        if($total>0){
			$total_page = ceil($total/$each_page);
			$page = ($page<=1)?1:$page;
			$page = ($page>=$total_page)?$total_page:$page;
			$offset = ($page-1)*$each_page;
			$sql = "select * from wu_costsummary where 业主姓名='".$业主姓名."' and 费用年月份='".$缴费年月份."' order by 本次实收 desc LIMIT $offset,$each_page";
            
            $rs = $db -> Execute($sql);
			$rs_a = $rs -> GetArray();
		}else{
			  print "<table  width=\"100%\" align=\"center\">
			            <tr class=\"TableDate\" align=\"center\">
						     <td noWrap>
							    <font size=\"3\" color=\"red\">对不起，没有查询到您需要的数据！</font>
							 </td>
						</tr>
			       </table>";
	    }

	}else if($缴费卡号 != ""){
        $total_sql = "select COUNT(*) AS sum from wu_costsummary where 缴费卡号='".$缴费卡号."'";
		$rs = $db -> Execute($total_sql);
		$total = $rs -> fields['sum'];
		if($total>0){
			$total_page = ceil($total/$each_page);
			$page = ($page<=1)?1:$page;
			$page = ($page>=$total_page)?$total_page:$page;
			$offset = ($page-1)*$each_page;
			$sql = "select * from wu_costsummary where 缴费卡号='".$缴费卡号."' order by 本次实收 desc LIMIT $offset,$each_page";

			$rs = $db -> Execute($sql);
			$rs_a = $rs -> GetArray();
		}else{
			 print "<table  width=\"100%\" align=\"center\">
			            <tr class=\"TableDate\" align=\"center\">
						     <td noWrap>
							    <font size=\"3\" color=\"red\">对不起，没有查询到您需要的数据！</font>
							 </td>
						</tr>
			       </table>";
		}

	}else if($单元编号 == "" && $缴费卡号 == "" && $业主姓名 == "" && $缴费年份 =="" && $缴费月份 == ""){
		 echo "<center><h2>请输入查询数据</h2></center>";
		 print "<center><h1><a href = \"wu_costReport.php\" name=\"name\">返回</a></h1></center>";
		 return;
	}

    $queren = "true";

}else{
        //系统默认显示的记录，以一定格式得到当前的时间
        $当前年月	= date("Y-m",mktime(1,1,1,date("m")-1,1,date("Y")));

		$total_sql = "select COUNT(*) AS sum from wu_costsummary where 费用年月份='".$当前年月."'";
		$rs = $db -> Execute($total_sql);
		$total = $rs -> fields['sum'];
        if($total>0){
			$total_page = ceil($total/$each_page);
			$page = ($page<=1)?1:$page;
			$page = ($page>=$total_page)?$total_page:$page;
			$offset = ($page-1)*$each_page;
			$sql = "select * from wu_costsummary where 费用年月份='".$当前年月."' order by 本次实收 desc LIMIT $offset,$each_page";

			$rs = $db -> Execute($sql);
			$rs_a = $rs -> GetArray();
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
<html>
<head>
<title>费用收取报表</title>
</head>
<body>
<FORM METHOD="POST" ACTION="?action=submit"><!--也可写wu_costReport.php?Name='check'-->

<table class="TableBlock" width="100%" align="center">
	<tr align="left" class="TableHeader"><td colspan=5>&nbsp;请输入查询内容</td></tr>
	<tr align="center" class="TableData">
	<!--
		<td noWrap>
			<B>缴费卡号：</B>
			<INPUT TYPE="text" size="15" class="SmallInput" NAME="check_card">
		</td>
     -->
		<td noWrap>
			<B>业主姓名：</B>
			<INPUT TYPE="text" size="15" class="SmallInput" NAME="check_name">
		</td>
		<td noWrap>
			<B>单元编号：</B>
			<INPUT TYPE="text" size="15" class="SmallInput" NAME="check_until">
		</td>
		<td noWrap>
			<B>缴费年月份：</B>
		    <select name="check_year" size="1"  class="SmallSelect">
				<?php
	            for($i=-6;$i<0;$i++)				{
		              $当前时间年月	= date("Y-m",mktime(0,0,0,date("m")+$i,1,date("Y")));
                      print "<option value=\"$当前时间年月\">".$当前时间年月."</option>";
                }	
		        ?> 
				</select>
			</td>
	</tr>

    <tr align="center"  class="TableContent" >
		<td noWrap  colspan=5>
		    <INPUT TYPE="hidden" name="fxp" value="fxp">
			<INPUT TYPE="submit" class="SmallButton" value="查询">
			<INPUT TYPE="reset" class="SmallButton"  value="重新填写">
		</td>
	</tr>

</table>



<table class="TableBlock" width="100%" align="center">
	   <tr align="left" class="TableHeader"><td colspan=8>缴费人信息(单位：月)【总计：<?php echo  $total;?>条】</td>
	   </tr>	 
	   <tr align="center" class="TableHeader">
				 <TD noWrap>序号</TD>
				 <!--<TD noWrap>缴费卡号</TD>-->
				 <TD noWrap>单元编号</TD>
				 <TD noWrap>业主姓名</TD>
				 <TD noWrap>联系方式</TD>
				 <TD noWrap>收款方式</TD>
				 <TD noWrap>费用年月份</TD>
	   </tr>
<?php				
for($i=0;$i<sizeof($rs_a);$i++){
   //$缴费卡号a = $rs_a[$i]['缴费卡号'];
   $业主姓名a = $rs_a[$i]['业主姓名'];
   $业主房号a = $rs_a[$i]['单元编号'];
   $联系方式 = $rs_a[$i]['联系方式'];
   $收款方式 = $rs_a[$i]['收款方式'];
   $缴费年月份a = $rs_a[$i]['费用年月份'];
   $j = $i + 1;

   print "<tr align=\"center\" class=\"TableData\">
				 <TD noWrap>".$j."</TD>
				 
				 <TD noWrap><font color=\"blue\">".$业主房号a."</font></TD>
				 <TD noWrap>".$业主姓名a."</TD>			 
				 <TD noWrap>".$联系方式."</TD>
				 <TD noWrap><font color=\"green\">".$收款方式."</font></TD>
				 <TD noWrap>".$缴费年月份a."</TD>
		 </tr>";

}
?>
</table><br>
<?php
for($i=0;$i<sizeof($rs_a);$i++){
//print "<br>";		
}	
?>

<table class="TableBlock" width="100%" align="center">
	
	<tr align="left" class="TableHeader">
	                 <td colspan=14> 费用信息汇总(单位：月)【总计：<?php echo  $total;?>条】</td>
	</tr>
	<tr align="center" class="TableHeader">
				 <TD noWrap>序号</TD>
				 <TD noWrap>水费</TD>
				 <TD noWrap>电费</TD>
				 <TD noWrap>气费</TD>
				 <TD noWrap>公摊电费</TD>
				 <TD noWrap>公摊水费</TD>
				 <TD noWrap>物业管理费</TD>
                 <TD noWrap>卫生费</TD>
                 <TD noWrap>电梯管理费</TD>
                 <TD noWrap>车位费</TD>
                 <TD noWrap>装修押金</TD>
                 <TD noWrap>其他费用</TD>
				 <TD noWrap>本次应收</TD>
				 <TD noWrap>本次实收</TD>

				 <!-- 
				 <TD noWrap>上次结余</TD>
				 <TD noWrap>本次结余</TD>
				 <TD noWrap>账户余额</TD>
				  -->
    </tr>

<?php
for($i=0;$i<sizeof($rs_a);$i++){
   $水费 = $rs_a[$i]['水费'];
   $电费 = $rs_a[$i]['电费'];
   $气费 = $rs_a[$i]['气费'];
   $公摊水费 = $rs_a[$i]['公摊水费'];
   $公摊电费 = $rs_a[$i]['公摊电费'];
   $物业管理费 = $rs_a[$i]['物业管理费'];
   $卫生费 = $rs_a[$i]['卫生费'];
   $电梯管理费 = $rs_a[$i]['电梯管理费'];
   $车位费 = $rs_a[$i]['车位费'];
   $装修押金 = $rs_a[$i]['装修押金'];
   $临时费用 = $rs_a[$i]['临时费用'];
   $其他费用 = $rs_a[$i]['其他费用'];
   $本次应缴 = $水费+$电费+$气费+$公摊水费+$公摊电费+$物业管理费+$卫生费+$电梯管理费+$车位费+$装修押金+$其他费用+$临时费用;
   $本次实收 = $rs_a[$i]['本次实收'];
   $j = $i + 1;

   if($本次实收 == 0.00){
      print "<tr align=\"center\" class=\"TableData\">
		         <TD noWrap>".$j."</TD>
				 <TD noWrap>".$水费."</TD>
				 <TD noWrap>".$电费."</TD>
				 <TD noWrap>".$气费."</TD>
				 <TD noWrap>".$公摊电费."</TD>
				 <TD noWrap>".$公摊水费."</TD>
				 <TD noWrap>".$物业管理费."</TD>
                 <TD noWrap>".$卫生费."</TD>
                 <TD noWrap>".$电梯管理费."</TD>
                 <TD noWrap>".$车位费."</TD>
                 <TD noWrap>".$装修押金."</TD>
                 <TD noWrap>".$其他费用."</TD>
				 <TD noWrap>".$本次应缴."</TD>
				 <TD noWrap><font color=\"red\">".$本次实收."</font></TD>	
          </tr>";
   }else{
     print "<tr align=\"center\" class=\"TableData\">
		         <TD noWrap>".$j."</TD>
				 <TD noWrap>".$水费."</TD>
				 <TD noWrap>".$电费."</TD>
				 <TD noWrap>".$气费."</TD>
				 <TD noWrap>".$公摊电费."</TD>
				 <TD noWrap>".$公摊水费."</TD>
				 <TD noWrap>".$物业管理费."</TD>
                 <TD noWrap>".$卫生费."</TD>
                 <TD noWrap>".$电梯管理费."</TD>
                 <TD noWrap>".$车位费."</TD>
                 <TD noWrap>".$装修押金."</TD>
                 <TD noWrap>".$其他费用."</TD>
				 <TD noWrap>".$本次应缴."</TD>
				 <TD noWrap>".$本次实收."</TD>	
          </tr>"; 
   }
   
   
            /*
            $上次结余 = $rs_a[$i]['上次结余'];
            $本次结余 = $本次实收-$本次应缴;
            $账户余额 = $上次结余+$本次结余;
		    <TD noWrap>".$上次结余."</TD>
		    <TD noWrap>".$本次结余."</TD>
	        <TD noWrap>".$账户余额."</TD>
			*/
}
?>
      <tr align="center" class="tableContent">
	     <td colspan="14" algn="center">
		 <?php 
		 echo sprintf("共%d条记录 %d/%d页",$total,$page,$total_page)."&nbsp;&nbsp;";
		 $n = $page+1;
		 $s = $page-1;
		 $until_name = $单元编号;
		 //$card_name  = $缴费卡号;
		 $yezhu_name = $业主姓名;
         $year_name  = $缴费年月份;

		 //echo $year_name."bb<br>";
		 
			
		 if($_POST['fxp']=="fxp" or $queren=="true"){
			 if($page<=1){
				echo "<input type=\"button\" value=\"下一页\" class=\"SmallButton\" onClick=\"location.href='?name=$n&action=submit&xx=xx&check_name=$yezhu_name&check_until=$until_name&check_year=$year_name'\">";

				//echo "aa<br>";
			 }else if($page>=$total_page){
				echo "<input type=\"button\" value=\"上一页\" class=\"SmallButton\" onClick=\"location.href='?name=$s&action=submit&xx=xx&check_name=$yezhu_name&check_until=$until_name&check_year=$year_name'\">";

				//echo "cc<br>";
			 }else {		   
				echo "<input type=\"button\" value=\"上一页\" class=\"SmallButton\" onClick=\"location.href='?name=$s&action=submit&xx=xx&check_name=$yezhu_name&check_until=$until_name&check_year=$year_name'\">&nbsp;";
				echo "<input type=\"button\" value=\"下一页\" class=\"SmallButton\" onClick=\"location.href='?name=$n&action=submit&xx=xx&check_name=$yezhu_name&check_until=$until_name&check_year=$year_name'\">";
			} 
		 }else{
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
		<td noWrap colspan="14" align="left">
		<font color="green">说明：</font><br>
			&nbsp;&nbsp;&nbsp;&nbsp;1 输入业主姓名、单元编号、缴费卡号、缴费年月份任意组合能够实现模糊查询.<br>
			&nbsp;&nbsp;&nbsp;&nbsp;2 输入单元编号、缴费年月份实现精确查询.<br>
			&nbsp;&nbsp;&nbsp;&nbsp;3 查询出来本次实收项目数据为“<font color="red">红</font>”色时，说明此项欠费.<br>
			&nbsp;&nbsp;&nbsp;&nbsp;<font size="2" color="red">4 默认数据是 <?php echo  $当前时间年月;?> 月数据.</font><br>
			&nbsp;&nbsp;&nbsp;&nbsp;5 设置每页显示的条数请到物业系统管理->数据字典->分页条数设置里面进行修改.
		</td>
	</tr>
</table>
</FORM>
</body>
</html>
