<?php
	ini_set('display_errors', 1);
	ini_set('error_reporting', E_ALL);
	error_reporting(E_WARNING | E_ERROR);
	require_once('lib.inc.php');
	$GLOBAL_SESSION=returnsession();
	page_css('��Ϣ��ѯ');

	$page = isset($_GET['name'])?intval($_GET['name']):1;
    
	//����ÿҳ��ʾ��������¼
	$each_sql = "select ÿҳ���� from wu_eachpage";
	$num = $db -> Execute($each_sql);
	$res = $num -> GetArray();
	$each_page = current($res['0']);

	
if($_GET['action']=="submit"){
     
			//global $�ɷѿ���;
			global $��Ԫ���;
			global $ҵ������;
			global $�ɷ����·�;

	if($_GET['xx']=="xx"){
		    
		    //$�ɷѿ��� = $_GET['check_card'];
			$��Ԫ��� = $_GET['check_until'];
			$ҵ������ = $_GET['check_name'];
			$�ɷ����·� = $_GET['check_year']; 
			//echo "dd<br>";
		
	}else{
			//$�ɷѿ��� = $_POST['check_card'];
			$��Ԫ��� = $_POST['check_until'];
			$ҵ������ = $_POST['check_name'];
			$�ɷ����·� = $_POST['check_year'];
    }

    if($��Ԫ��� == "" && $�ɷѿ��� == "" && $ҵ������ == "" && $�ɷ����·� !=""){

		//echo "eee<br>";
		$total_sql = "select COUNT(*) AS sum from wu_costsummary where �������·�='".$�ɷ����·�."'";
		$rs = $db -> Execute($total_sql);
		$total = $rs -> fields['sum'];
		if($total>0){
			$total_page = ceil($total/$each_page);
			$page = ($page<=1)?1:$page;
			$page = ($page>=$total_page)?$total_page:$page;
			$offset = ($page-1)*$each_page;
			$sql = "select * from wu_costsummary where �������·�='".$�ɷ����·�."' order by ����ʵ�� desc LIMIT $offset,$each_page";
            
			$rs = $db -> Execute($sql);
			$rs_a = $rs -> GetArray();
		}else{
		      print "<table  width=\"100%\" align=\"center\">
			            <tr class=\"TableDate\" align=\"center\">
						     <td noWrap>
							    <font size=\"3\" color=\"red\">�Բ���û�в�ѯ������Ҫ�����ݣ�</font>
							 </td>
						</tr>
			       </table>";
		}
	}else if($�ɷѿ��� == "" && $ҵ������ == "" && $�ɷ����·� == "" && $��Ԫ��� != ""){
		$total_sql = "select COUNT(*) AS sum from wu_costsummary where ��Ԫ���='".$��Ԫ���."'";
		$rs = $db -> Execute($total_sql);
		$total = $rs -> fields['sum'];
        if($total>0){
			$total_page = ceil($total/$each_page);
			$page = ($page<=1)?1:$page;
			$page = ($page>=$total_page)?$total_page:$page;
			$offset = ($page-1)*$each_page;
			$sql = "select * from wu_costsummary where ��Ԫ���='".$��Ԫ���."' order by ����ʵ�� desc LIMIT $offset,$each_page";
		
		    $rs = $db -> Execute($sql);
			$rs_a = $rs -> GetArray();
		}else{
			  print "<table  width=\"100%\" align=\"center\">
			            <tr class=\"TableDate\" align=\"center\">
						     <td noWrap>
							    <font size=\"3\" color=\"red\">�Բ���û�в�ѯ������Ҫ�����ݣ�</font>
							 </td>
						</tr>
			       </table>";
		}
	}else if($�ɷѿ��� == "" && $ҵ������ == "" && $�ɷ����·� != "" && $��Ԫ��� != ""){
        $total_sql = "select COUNT(*) AS sum from wu_costsummary where ��Ԫ���='".$��Ԫ���."' and �������·�='".$�ɷ����·�."'";
		$rs = $db -> Execute($total_sql);
		$total = $rs -> fields['sum'];
        if($total>0){
			$total_page = ceil($total/$each_page);
			$page = ($page<=1)?1:$page;
			$page = ($page>=$total_page)?$total_page:$page;
			$offset = ($page-1)*$each_page;
			$sql = "select * from wu_costsummary where ��Ԫ���='".$��Ԫ���."' and �������·�='".$�ɷ����·�."' order by ����ʵ�� desc LIMIT $offset,$each_page";
             
			$rs = $db -> Execute($sql);
			$rs_a = $rs -> GetArray();
		}else{
			  print "<table  width=\"100%\" align=\"center\">
			            <tr class=\"TableDate\" align=\"center\">
						     <td noWrap>
							    <font size=\"3\" color=\"red\">�Բ���û�в�ѯ������Ҫ�����ݣ�</font>
							 </td>
						</tr>
			       </table>";
		}

	}else if($��Ԫ��� == "" && $�ɷѿ��� == "" && $ҵ������ != "" && $�ɷ��·� == "" && $�ɷ���� == ""){
		$total_sql = "select COUNT(*) AS sum from wu_costsummary where ҵ������='".$ҵ������."'";
		$rs = $db -> Execute($total_sql);
		$total = $rs -> fields['sum'];
        if($total>0){
			$total_page = ceil($total/$each_page);
			$page = ($page<=1)?1:$page;
			$page = ($page>=$total_page)?$total_page:$page;
			$offset = ($page-1)*$each_page;
			$sql = "select * from wu_costsummary where ҵ������='".$ҵ������."' order by ����ʵ�� desc LIMIT $offset,$each_page";
        
			$rs = $db -> Execute($sql);
			$rs_a = $rs -> GetArray();
        }else{
		      print "<table  width=\"100%\" align=\"center\">
			            <tr class=\"TableDate\" align=\"center\">
						     <td noWrap>
							    <font size=\"3\" color=\"red\">�Բ���û�в�ѯ������Ҫ�����ݣ�</font>
							 </td>
						</tr>
			       </table>";
	    }

	}else if($��Ԫ��� =="" && $�ɷѿ��� == "" && $�ɷ��·� == "" && $ҵ������ != "" && $�ɷ����·� != ""){
		$total_sql = "select COUNT(*) AS sum from wu_costsummary where ҵ������='".$ҵ������."' and �������·�='".$�ɷ����·�."'";
		$rs = $db -> Execute($total_sql);
		$total = $rs -> fields['sum'];
        if($total>0){
			$total_page = ceil($total/$each_page);
			$page = ($page<=1)?1:$page;
			$page = ($page>=$total_page)?$total_page:$page;
			$offset = ($page-1)*$each_page;
			$sql = "select * from wu_costsummary where ҵ������='".$ҵ������."' and �������·�='".$�ɷ����·�."' order by ����ʵ�� desc LIMIT $offset,$each_page";
            
            $rs = $db -> Execute($sql);
			$rs_a = $rs -> GetArray();
		}else{
			  print "<table  width=\"100%\" align=\"center\">
			            <tr class=\"TableDate\" align=\"center\">
						     <td noWrap>
							    <font size=\"3\" color=\"red\">�Բ���û�в�ѯ������Ҫ�����ݣ�</font>
							 </td>
						</tr>
			       </table>";
	    }

	}else if($�ɷѿ��� != ""){
        $total_sql = "select COUNT(*) AS sum from wu_costsummary where �ɷѿ���='".$�ɷѿ���."'";
		$rs = $db -> Execute($total_sql);
		$total = $rs -> fields['sum'];
		if($total>0){
			$total_page = ceil($total/$each_page);
			$page = ($page<=1)?1:$page;
			$page = ($page>=$total_page)?$total_page:$page;
			$offset = ($page-1)*$each_page;
			$sql = "select * from wu_costsummary where �ɷѿ���='".$�ɷѿ���."' order by ����ʵ�� desc LIMIT $offset,$each_page";

			$rs = $db -> Execute($sql);
			$rs_a = $rs -> GetArray();
		}else{
			 print "<table  width=\"100%\" align=\"center\">
			            <tr class=\"TableDate\" align=\"center\">
						     <td noWrap>
							    <font size=\"3\" color=\"red\">�Բ���û�в�ѯ������Ҫ�����ݣ�</font>
							 </td>
						</tr>
			       </table>";
		}

	}else if($��Ԫ��� == "" && $�ɷѿ��� == "" && $ҵ������ == "" && $�ɷ���� =="" && $�ɷ��·� == ""){
		 echo "<center><h2>�������ѯ����</h2></center>";
		 print "<center><h1><a href = \"wu_costReport.php\" name=\"name\">����</a></h1></center>";
		 return;
	}

    $queren = "true";

}else{
        //ϵͳĬ����ʾ�ļ�¼����һ����ʽ�õ���ǰ��ʱ��
        $��ǰ����	= date("Y-m",mktime(1,1,1,date("m")-1,1,date("Y")));

		$total_sql = "select COUNT(*) AS sum from wu_costsummary where �������·�='".$��ǰ����."'";
		$rs = $db -> Execute($total_sql);
		$total = $rs -> fields['sum'];
        if($total>0){
			$total_page = ceil($total/$each_page);
			$page = ($page<=1)?1:$page;
			$page = ($page>=$total_page)?$total_page:$page;
			$offset = ($page-1)*$each_page;
			$sql = "select * from wu_costsummary where �������·�='".$��ǰ����."' order by ����ʵ�� desc LIMIT $offset,$each_page";

			$rs = $db -> Execute($sql);
			$rs_a = $rs -> GetArray();
		}else{
		    print "<table  width=\"100%\" align=\"center\">
			            <tr class=\"TableDate\" align=\"center\">
						     <td noWrap>
							    <font size=\"3\" color=\"red\">�Բ��𣬴����·�û�����ݣ�</font>
							 </td>
						</tr>
			       </table>";
		}
}
        
   
?>
<html>
<head>
<title>������ȡ����</title>
</head>
<body>
<FORM METHOD="POST" ACTION="?action=submit"><!--Ҳ��дwu_costReport.php?Name='check'-->

<table class="TableBlock" width="100%" align="center">
	<tr align="left" class="TableHeader"><td colspan=5>&nbsp;�������ѯ����</td></tr>
	<tr align="center" class="TableData">
	<!--
		<td noWrap>
			<B>�ɷѿ��ţ�</B>
			<INPUT TYPE="text" size="15" class="SmallInput" NAME="check_card">
		</td>
     -->
		<td noWrap>
			<B>ҵ��������</B>
			<INPUT TYPE="text" size="15" class="SmallInput" NAME="check_name">
		</td>
		<td noWrap>
			<B>��Ԫ��ţ�</B>
			<INPUT TYPE="text" size="15" class="SmallInput" NAME="check_until">
		</td>
		<td noWrap>
			<B>�ɷ����·ݣ�</B>
		    <select name="check_year" size="1"  class="SmallSelect">
				<?php
	            for($i=-6;$i<0;$i++)				{
		              $��ǰʱ������	= date("Y-m",mktime(0,0,0,date("m")+$i,1,date("Y")));
                      print "<option value=\"$��ǰʱ������\">".$��ǰʱ������."</option>";
                }	
		        ?> 
				</select>
			</td>
	</tr>

    <tr align="center"  class="TableContent" >
		<td noWrap  colspan=5>
		    <INPUT TYPE="hidden" name="fxp" value="fxp">
			<INPUT TYPE="submit" class="SmallButton" value="��ѯ">
			<INPUT TYPE="reset" class="SmallButton"  value="������д">
		</td>
	</tr>

</table>



<table class="TableBlock" width="100%" align="center">
	   <tr align="left" class="TableHeader"><td colspan=8>�ɷ�����Ϣ(��λ����)���ܼƣ�<?php echo  $total;?>����</td>
	   </tr>	 
	   <tr align="center" class="TableHeader">
				 <TD noWrap>���</TD>
				 <!--<TD noWrap>�ɷѿ���</TD>-->
				 <TD noWrap>��Ԫ���</TD>
				 <TD noWrap>ҵ������</TD>
				 <TD noWrap>��ϵ��ʽ</TD>
				 <TD noWrap>�տʽ</TD>
				 <TD noWrap>�������·�</TD>
	   </tr>
<?php				
for($i=0;$i<sizeof($rs_a);$i++){
   //$�ɷѿ���a = $rs_a[$i]['�ɷѿ���'];
   $ҵ������a = $rs_a[$i]['ҵ������'];
   $ҵ������a = $rs_a[$i]['��Ԫ���'];
   $��ϵ��ʽ = $rs_a[$i]['��ϵ��ʽ'];
   $�տʽ = $rs_a[$i]['�տʽ'];
   $�ɷ����·�a = $rs_a[$i]['�������·�'];
   $j = $i + 1;

   print "<tr align=\"center\" class=\"TableData\">
				 <TD noWrap>".$j."</TD>
				 
				 <TD noWrap><font color=\"blue\">".$ҵ������a."</font></TD>
				 <TD noWrap>".$ҵ������a."</TD>			 
				 <TD noWrap>".$��ϵ��ʽ."</TD>
				 <TD noWrap><font color=\"green\">".$�տʽ."</font></TD>
				 <TD noWrap>".$�ɷ����·�a."</TD>
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
	                 <td colspan=14> ������Ϣ����(��λ����)���ܼƣ�<?php echo  $total;?>����</td>
	</tr>
	<tr align="center" class="TableHeader">
				 <TD noWrap>���</TD>
				 <TD noWrap>ˮ��</TD>
				 <TD noWrap>���</TD>
				 <TD noWrap>����</TD>
				 <TD noWrap>��̯���</TD>
				 <TD noWrap>��̯ˮ��</TD>
				 <TD noWrap>��ҵ�����</TD>
                 <TD noWrap>������</TD>
                 <TD noWrap>���ݹ����</TD>
                 <TD noWrap>��λ��</TD>
                 <TD noWrap>װ��Ѻ��</TD>
                 <TD noWrap>��������</TD>
				 <TD noWrap>����Ӧ��</TD>
				 <TD noWrap>����ʵ��</TD>

				 <!-- 
				 <TD noWrap>�ϴν���</TD>
				 <TD noWrap>���ν���</TD>
				 <TD noWrap>�˻����</TD>
				  -->
    </tr>

<?php
for($i=0;$i<sizeof($rs_a);$i++){
   $ˮ�� = $rs_a[$i]['ˮ��'];
   $��� = $rs_a[$i]['���'];
   $���� = $rs_a[$i]['����'];
   $��̯ˮ�� = $rs_a[$i]['��̯ˮ��'];
   $��̯��� = $rs_a[$i]['��̯���'];
   $��ҵ����� = $rs_a[$i]['��ҵ�����'];
   $������ = $rs_a[$i]['������'];
   $���ݹ���� = $rs_a[$i]['���ݹ����'];
   $��λ�� = $rs_a[$i]['��λ��'];
   $װ��Ѻ�� = $rs_a[$i]['װ��Ѻ��'];
   $��ʱ���� = $rs_a[$i]['��ʱ����'];
   $�������� = $rs_a[$i]['��������'];
   $����Ӧ�� = $ˮ��+$���+$����+$��̯ˮ��+$��̯���+$��ҵ�����+$������+$���ݹ����+$��λ��+$װ��Ѻ��+$��������+$��ʱ����;
   $����ʵ�� = $rs_a[$i]['����ʵ��'];
   $j = $i + 1;

   if($����ʵ�� == 0.00){
      print "<tr align=\"center\" class=\"TableData\">
		         <TD noWrap>".$j."</TD>
				 <TD noWrap>".$ˮ��."</TD>
				 <TD noWrap>".$���."</TD>
				 <TD noWrap>".$����."</TD>
				 <TD noWrap>".$��̯���."</TD>
				 <TD noWrap>".$��̯ˮ��."</TD>
				 <TD noWrap>".$��ҵ�����."</TD>
                 <TD noWrap>".$������."</TD>
                 <TD noWrap>".$���ݹ����."</TD>
                 <TD noWrap>".$��λ��."</TD>
                 <TD noWrap>".$װ��Ѻ��."</TD>
                 <TD noWrap>".$��������."</TD>
				 <TD noWrap>".$����Ӧ��."</TD>
				 <TD noWrap><font color=\"red\">".$����ʵ��."</font></TD>	
          </tr>";
   }else{
     print "<tr align=\"center\" class=\"TableData\">
		         <TD noWrap>".$j."</TD>
				 <TD noWrap>".$ˮ��."</TD>
				 <TD noWrap>".$���."</TD>
				 <TD noWrap>".$����."</TD>
				 <TD noWrap>".$��̯���."</TD>
				 <TD noWrap>".$��̯ˮ��."</TD>
				 <TD noWrap>".$��ҵ�����."</TD>
                 <TD noWrap>".$������."</TD>
                 <TD noWrap>".$���ݹ����."</TD>
                 <TD noWrap>".$��λ��."</TD>
                 <TD noWrap>".$װ��Ѻ��."</TD>
                 <TD noWrap>".$��������."</TD>
				 <TD noWrap>".$����Ӧ��."</TD>
				 <TD noWrap>".$����ʵ��."</TD>	
          </tr>"; 
   }
   
   
            /*
            $�ϴν��� = $rs_a[$i]['�ϴν���'];
            $���ν��� = $����ʵ��-$����Ӧ��;
            $�˻���� = $�ϴν���+$���ν���;
		    <TD noWrap>".$�ϴν���."</TD>
		    <TD noWrap>".$���ν���."</TD>
	        <TD noWrap>".$�˻����."</TD>
			*/
}
?>
      <tr align="center" class="tableContent">
	     <td colspan="14" algn="center">
		 <?php 
		 echo sprintf("��%d����¼ %d/%dҳ",$total,$page,$total_page)."&nbsp;&nbsp;";
		 $n = $page+1;
		 $s = $page-1;
		 $until_name = $��Ԫ���;
		 //$card_name  = $�ɷѿ���;
		 $yezhu_name = $ҵ������;
         $year_name  = $�ɷ����·�;

		 //echo $year_name."bb<br>";
		 
			
		 if($_POST['fxp']=="fxp" or $queren=="true"){
			 if($page<=1){
				echo "<input type=\"button\" value=\"��һҳ\" class=\"SmallButton\" onClick=\"location.href='?name=$n&action=submit&xx=xx&check_name=$yezhu_name&check_until=$until_name&check_year=$year_name'\">";

				//echo "aa<br>";
			 }else if($page>=$total_page){
				echo "<input type=\"button\" value=\"��һҳ\" class=\"SmallButton\" onClick=\"location.href='?name=$s&action=submit&xx=xx&check_name=$yezhu_name&check_until=$until_name&check_year=$year_name'\">";

				//echo "cc<br>";
			 }else {		   
				echo "<input type=\"button\" value=\"��һҳ\" class=\"SmallButton\" onClick=\"location.href='?name=$s&action=submit&xx=xx&check_name=$yezhu_name&check_until=$until_name&check_year=$year_name'\">&nbsp;";
				echo "<input type=\"button\" value=\"��һҳ\" class=\"SmallButton\" onClick=\"location.href='?name=$n&action=submit&xx=xx&check_name=$yezhu_name&check_until=$until_name&check_year=$year_name'\">";
			} 
		 }else{
			if($page<=1){
				echo "<input type=\"button\" value=\"��һҳ\" class=\"SmallButton\" onClick=\"location.href='?name=$n'\">";
			}else if($page>=$total_page){
				echo "<input type=\"button\" value=\"��һҳ\" class=\"SmallButton\" onClick=\"location.href='?name=$s'\">";
			}else {		   
				echo "<input type=\"button\" value=\"��һҳ\" class=\"SmallButton\" onClick=\"location.href='?name=$s'\">&nbsp;";
				echo "<input type=\"button\" value=\"��һҳ\" class=\"SmallButton\" onClick=\"location.href='?name=$n'\">";
			}
		 }
		 ?>
		 </td>
	</tr>

     <tr align="center" class="tableContent">
		<td noWrap colspan="14" align="left">
		<font color="green">˵����</font><br>
			&nbsp;&nbsp;&nbsp;&nbsp;1 ����ҵ����������Ԫ��š��ɷѿ��š��ɷ����·���������ܹ�ʵ��ģ����ѯ.<br>
			&nbsp;&nbsp;&nbsp;&nbsp;2 ���뵥Ԫ��š��ɷ����·�ʵ�־�ȷ��ѯ.<br>
			&nbsp;&nbsp;&nbsp;&nbsp;3 ��ѯ��������ʵ����Ŀ����Ϊ��<font color="red">��</font>��ɫʱ��˵������Ƿ��.<br>
			&nbsp;&nbsp;&nbsp;&nbsp;<font size="2" color="red">4 Ĭ�������� <?php echo  $��ǰʱ������;?> ������.</font><br>
			&nbsp;&nbsp;&nbsp;&nbsp;5 ����ÿҳ��ʾ�������뵽��ҵϵͳ����->�����ֵ�->��ҳ����������������޸�.
		</td>
	</tr>
</table>
</FORM>
</body>
</html>
