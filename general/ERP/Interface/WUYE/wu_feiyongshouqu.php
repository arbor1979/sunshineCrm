<?php
	require_once('lib.inc.php');
	session_start();
/******************����*****************************************************************************************/
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
	header('Content-Disposition: attachment;filename=Ƿ��ͳ�Ʊ�.xls');
	header('Content-Length: ' . strlen($FILE_CONTENT));
	header('Pragma: no-cache');
	header('Expires: 0');
	echo $FILE_CONTENT;
	exit;
}
/******************����*****************************************************************************************/
ini_set('display_errors', 1);
	ini_set('error_reporting', E_ALL);
	error_reporting(E_WARNING | E_ERROR);
	page_css('Ƿ��ͳ��');

$page = isset($_GET['name'])?intval($_GET['name']):1;

//ÿҳ��ʾ��¼������
$each_sql = "select ÿҳ���� from wu_eachpage";
$num = $db -> Execute($each_sql);
$rs = $num -> GetArray();
//print_r($rs['0']);
$each_page = $rs['0']['ÿҳ����'];
//echo current($rs['0']);

if($_GET['name']=="dalou"){
			 global $��¥����;
			 global $�ɷ����·�;	
			 $��¥���� = $_GET['��¥����'];
			 $�ɷ����·� = $_GET['�ɷ����·�'];
             //echo $�ɷ����·�;
			 $sel_sql = "select * from wu_housingresources where ��¥����='$��¥����'";
			 $sel_rs  = $db->Execute($sel_sql);
			 $sel_rs_a = $sel_rs->GetArray();
			 for($i=0;$i<=sizeof($sel_rs_a);$i++){
			     $��Ԫ��� = $sel_rs_a[$i]['�������'];
				 $��Ԫ[]=$��Ԫ���;
			 }

             $queren = "true";

}else{
            //ϵͳĬ����ʾ�ļ�¼����һ����ʽ�õ���ǰ��ʱ��
			$�ɷ����·�	= date("Y-m",mktime(1,1,1,date("m")-1,date("d"),date("Y")));
			$row_sql = "select COUNT(*) AS sum from wu_costsummary where �������·�='".$�ɷ����·�."'";
			$row_rs = $db -> Execute($row_sql);
			$total1 = $row_rs -> fields['sum'];


			if($total1>0){		
				$total_page = ceil($total1/$each_page);        
				$page = ($page<1)?1:$page;
				$page = ($page>$total_page)?$total_page:$page;
				$offset = ($page-1)*$each_page;
				$sql = "select * from wu_costsummary where �������·�='".$�ɷ����·�."' order by ����Ӧ�� desc LIMIT $offset,$each_page";
				
				$rs = $db -> Execute($sql);
				$rs_aa = $rs -> GetArray();
				
				$queren = "true1";
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

<FORM METHOD="GET" ACTION="?action=submit">

<table class="TableBlock" width="100%" align="center">
     <tr align="left" class="TableHeader">
	         <td colspan="">&nbsp;�������ƣ�&nbsp;&nbsp;&nbsp;

			 <?php
			 
			    $�������� = $_GET['��������'];

			    //�ô����������б�
				$quyu_sql = "select �������� from wu_managementdistrict where 1=1 order by �������� asc";
				$quyu_rs = $db->Execute($quyu_sql);
				$quyu_rs_a = $quyu_rs->GetArray();
                
				for($i=0;$i<=sizeof($quyu_rs_a);$i++){
					$��������X = $quyu_rs_a[$i]['��������'];
					//if($i%5 == 0) print "<br>";
					if($��������X==$��������) $color="red"; else $color = "green";
						
                    print "&nbsp;<a href=\"?".base64_encode("��������=$��������X&check_year=$check_year")."\"><font color=$color>$��������X</font></a>\n";
				}
			 ?>

				<B>�ɷ����·ݣ�</B>
				<?php
				$��������=$_GET['��������'];
				$name=$_GET['name'];
				$�ɷ����·�array=array();
				for($i=-1;$i>=-6;$i--)				{
					$��ǰʱ������	= date("Y-m",mktime(0,0,0,date("m")+$i,1,date("Y")));
					$�ɷ����·�array[]=$��ǰʱ������;
					}	
					if($�ɷ����·�!=null){
					$�ɷ����·�=$_GET['�ɷ����·�'];
					}else{
					$�ɷ����·�=$�ɷ����·�array[0];
					}
					print "<Select name='�ɷ����·�'  onChange=\"var jmpURL='?flag=jump&��������=$��������&name=$name&�ɷ����·�=' + this.options[this.selectedIndex].value; if(jmpURL!='') {window.location=jmpURL;} else {this.selectedIndex=0;}\">";
					for($i=0;$i<sizeof($�ɷ����·�array);$i++)
						{
							if($�ɷ����·�== $�ɷ����·�array[$i])
								$Selected = "selected";
							else
								$Selected = "";
					print "<Option ".$Selected." value='".$�ɷ����·�array[$i]."'>".$�ɷ����·�array[$i]."</Option>";
						}
					print "</Select>";
		
				?>
				<!-- 
				<?php 
                   //$ʱ��array[]=array();
				   for($i=0;$i>=-6;$i--)				{
		              $��ǰʱ������	= date("Y-m",mktime(0,0,0,date("m")+$i,date("d"),date("Y")));
					  $ʱ��array[]=$��ǰʱ������;
                   }
                   // print_r($ʱ��array);
				   print "<Select name='check_year'>";
				    
				   $check_year=$_GET['check_year'];
				   for($i=0;$i<sizeof($ʱ��array);$i++){
						if($check_year== $ʱ��array[$i])
							$Selected = "selected";
						else
							$Selected = "";
				        print "<Option ".$Selected." value='".$ʱ��array[$i]."'>".$ʱ��array[$i]."</Option>";
			       }
	               print "</Select>";
				?>
				 -->
		 </td>
     </tr>
	 <tr align="left" class="TableContent">
	     <td>
		 <?php
		  //�õ����������¶�Ӧ�Ĵ�¥�����б�

			  $��¥���� = $_GET['��¥����'];

              $�������� = $_GET['��������'];
			  if($�������� == ""){
			     $dalou_sql  = "select * from wu_buildinginformation where ��������='סլA��'";
			  }else{
				 $dalou_sql  = "select * from wu_buildinginformation where ��������='$��������' ";
              }
				  $dalou_rs   = $db->Execute($dalou_sql);
				  $dalou_rs_a = $dalou_rs->GetArray();
				  for($i=0;$i<=sizeof($dalou_rs_a);$i++){

					  if($i!=0 and $i%10 == 0) print "<br>";
					  $��¥����X = $dalou_rs_a[$i]['��¥����'];

					  if($��¥����X==$��¥����) $color="red"; else $color="green";

					  print "&nbsp;&nbsp;<a href=\"?".base64_encode("name=dalou&��¥����=$��¥����X&�ɷ����·�=$�ɷ����·�&��������=$��������")."\"><font color=$color>$��¥����X</font></a>&nbsp;&nbsp;&nbsp;&nbsp;";
				  
				  }

		 ?>
		 </td>
	 </tr>
</table>
<table class="TableBlock" width="100%" align="center">
	   <tr align="left" class="TableHeader"><td colspan=10>Ƿ����Ϣͳ��(��λ����) [�ܼƣ�<?php echo $total1?>��]</td></tr>
	   <tr align="center" class="TableHeader">
				 <TD noWrap>���</TD>
				<!--<TD noWrap>�ɷѿ���</TD>-->
				 <TD noWrap>��Ԫ���</TD>
				 <TD noWrap>ҵ������</TD>
				 <TD noWrap>��ϵ��ʽ</TD>
				 <TD noWrap>�տʽ</TD>
				 <TD noWrap>�������·�</TD>
				 <TD noWrap>����Ӧ��</TD>
				 <TD noWrap>����ʵ��</TD>
				 <TD noWrap>����</TD>
	   </tr>
<?php
/**********
���ύ���������ݽ����жϣ�Ȼ��ѡ�������ʽ
***********/

if($queren = "true"){
		foreach((array)$��Ԫ as $val){
					$rows_sql = "select COUNT(*) AS sum from wu_costsummary where ��Ԫ���='$val' and �������·�='$�ɷ����·�'";
					$rows_rs = $db -> Execute($rows_sql);
					$total = $rows_rs -> fields['sum'];

					if($total>0){
						
						$sql = "select * from wu_costsummary where ��Ԫ���='$val' and �������·�='$�ɷ����·�'order by ��Ԫ��� desc";
						$rs = $db -> Execute($sql);
						$rs_a = $rs -> GetArray();
			
			
						for($i=0;$i<sizeof($rs_a);$i++){
							$���       = $rs_a[$i]['���'];
							//$�ɷѿ���	= $rs_a[$i]['�ɷѿ���'];
							$ҵ������	= $rs_a[$i]['ҵ������'];
							$ҵ������	= $rs_a[$i]['��Ԫ���'];
							$��ϵ��ʽ	= $rs_a[$i]['��ϵ��ʽ'];
							$�տʽ	= $rs_a[$i]['�տʽ'];
							$�������·� = $rs_a[$i]['�������·�'];
							$����Ӧ��	= $rs_a[$i]['����Ӧ��'];
							$����ʵ��	= $rs_a[$i]['����ʵ��'];

							//echo $����ʵ��."<br>";
							//$j = $i+1;

								if($����ʵ�� > 0.00){
					
									print "<tr align=\"center\" class=\"TableData\">
											 <TD noWrap>&nbsp;".$i++."</TD>
										
											 <TD noWrap>&nbsp;<font color=\"blue\">".$ҵ������."</font></TD>
											 <TD noWrap>&nbsp;".$ҵ������."</TD>
											 <TD noWrap>&nbsp;".$��ϵ��ʽ."</TD>
											 <TD noWrap>&nbsp;<font color=\"green\">".$�տʽ."</font></TD>
											 <TD noWrap>&nbsp;".$�������·�."</TD>
											 <TD noWrap>&nbsp;".$����Ӧ��."</TD>
											 <TD noWrap>&nbsp;".$����ʵ��."</TD>
											 <TD noWrap>&nbsp;<font color=red>�����ѽ�</font>&nbsp;<a class=OrgAdd href=\"wu_shoufeibaobiao.php?action=fxp&���=$���\">��ӡ��ϸ</a></TD>
										   </tr>";
								
								}else{

									print "<tr align=\"center\" class=\"TableData\">
											 <TD noWrap>&nbsp;".$i++."</TD>
											 
											 <TD noWrap>&nbsp;<font color=\"blue\">".$ҵ������."</font></TD>
											 <TD noWrap>&nbsp;".$ҵ������."</TD>
											 <TD noWrap>&nbsp;".$��ϵ��ʽ."</TD>
											 <TD noWrap>&nbsp;<font color=\"green\">".$�տʽ."</font></TD>
											 <TD noWrap>&nbsp;".$�������·�."</TD>
											 <TD noWrap>&nbsp;".$����Ӧ��."</TD>
											 <TD noWrap>&nbsp;<font color=\"red\">".$����ʵ��."</font></TD>
											 <TD noWrap>&nbsp;<a class=OrgAdd href=\"wu_costsummary_newai.php?".base64_encode("action=edit_default&���=$���&���_NAME=$���&���_disabled=disabled")."\">����ɷ�</a>&nbsp;&nbsp;<a class=OrgAdd href=\"wu_shoufeibaobiao.php?action=fxp&���=$���\">��ӡ��ϸ</a></TD>
										   </tr>";
								}
						}
				    }
		}

}
/**********************
����forѭ�������Ĭ������µ�����
***********************/
				for($i=0;$i<sizeof($rs_aa);$i++){
                    $���       = $rs_aa[$i]['���'];
//echo $���."<br>";

					//$�ɷѿ���	= $rs_aa[$i]['�ɷѿ���'];
					$ҵ������	= $rs_aa[$i]['ҵ������'];
					$ҵ������	= $rs_aa[$i]['��Ԫ���'];
					$��ϵ��ʽ	= $rs_aa[$i]['��ϵ��ʽ'];
					$�տʽ	= $rs_aa[$i]['�տʽ'];
					$�������·� = $rs_aa[$i]['�������·�'];
					$����Ӧ��	= $rs_aa[$i]['����Ӧ��'];
					$����ʵ��	= $rs_aa[$i]['����ʵ��'];
					$j = $i+1;

					if($����ʵ�� != 0.00){

						print "<tr align=\"center\" class=\"TableData\">
								 <TD noWrap>&nbsp;".$j."</TD>
								 
								 <TD noWrap>&nbsp;<font color=\"blue\">".$ҵ������."</font></TD>
								 <TD noWrap>&nbsp;".$ҵ������."</TD>
								 <TD noWrap>&nbsp;".$��ϵ��ʽ."</TD>
								 <TD noWrap>&nbsp;<font color=\"green\">".$�տʽ."</font></TD>
								 <TD noWrap>&nbsp;".$�������·�."</TD>
								 <TD noWrap>&nbsp;".$����Ӧ��."</TD>
								 <TD noWrap>&nbsp;".$����ʵ��."</TD>
								 <TD noWrap>&nbsp;<font color=red>�����ѽ�</font>&nbsp;&nbsp;&nbsp;<a class=OrgAdd href=\"wu_shoufeibaobiao.php?action=fxp&���=$���\">��ӡ��ϸ</a></TD>
							   </tr>";
					
					}else{
						print "<tr align=\"center\" class=\"TableData\">
								 <TD noWrap>&nbsp;".$j."</TD>
								 
								 <TD noWrap>&nbsp;<font color=\"blue\">".$ҵ������."</font></TD>
								 <TD noWrap>&nbsp;".$ҵ������."</TD>
								 <TD noWrap>&nbsp;".$��ϵ��ʽ."</TD>
								 <TD noWrap>&nbsp;<font color=\"green\">".$�տʽ."</font></TD>
								 <TD noWrap>&nbsp;".$�������·�."</TD>
								 <TD noWrap>&nbsp;".$����Ӧ��."</TD>
								 <TD noWrap>&nbsp;<font color=\"red\">".$����ʵ��."</font></TD>

                                 <TD noWrap>&nbsp;<a class=OrgAdd href=\"wu_costsummary_newai.php?".base64_encode("action=edit_default&xx=xx&���=$���&���_NAME=$���&���_disabled=disabled")."\">����ɷ�</a>&nbsp;<a class=OrgAdd href=\"wu_shoufeibaobiao.php?action=fxp&���=$���\">��ӡ��ϸ</a></TD>

						     
							   </tr>";
					}
				}
/******************
���´���ͨ���ж�xx==xx�����нɷѲ��������ɷѵ����б���ʵ�ո�Ϊ�����ķ���
******************/
/*
<TD noWrap>&nbsp;<a href=?xx=xx&����Ӧ��=$����Ӧ��&��Ԫ���=$ҵ������&�������·�=$�������·�>����ɷ�</a></TD>

if($_GET['xx'] == "xx"){
	   $����Ӧ��   = $_GET['����Ӧ��'];
	   $��Ԫ���   = $_GET['��Ԫ���'];
	   $�������·� = $_GET['�������·�'];
          
	   $upd_sql = "update wu_costsummary set ����ʵ��='$����Ӧ��' where ��Ԫ���='$��Ԫ���' and �������·�='$�������·�'";
       $db->Execute($upd_sql);


}
*/

?>  
<!-- 
���´����ǽ���ҳ�浼����ť����Ĭ�����ݽ��з�ҳ����
-->
    <tr align="center" class="tableContent">
	     <td colspan="10" >
		 <INPUT TYPE="button" VALUE="����" class="SmallButton"  align="left" ONCLICK="location='?pageAction=ExportDataToFile&check_until=<?php echo $_GET['check_until']?>&check_year=<?php echo $_GET['check_year']?>'">
		 <?php 
		 
		 if($total1>0){
		 echo sprintf("��%d����¼ %d/%dҳ",$total,$page,$total_page)."&nbsp;&nbsp;";
		 $n = $page+1;
		 $s = $page-1;
			
		
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
		<td noWrap colspan="10" align=left>
		<font color="green">˵����</font><br>
			&nbsp;&nbsp;&nbsp;&nbsp;1 Ĭ������ʱ���½ɷ�Ƿ������б�<font color="red">������ <?php if($_GET['name']=="dalou"){
			  echo $�ɷ����·�;
			}else{
			     $ʱ�� = date("Y-m",mktime(1,1,1,date("m")-1,date("d"),date("Y")));
				 echo $ʱ��;
			     }?> ������</font>.<br>
			&nbsp;&nbsp;&nbsp;&nbsp;2 ��ѯ��������ʵ����Ŀ����Ϊ��<font color="red">��</font>��ɫʱ��˵������Ƿ�ѣ�����ɷѵ���ɷѰ�ť���нɷ�,����û���Ҫ�ɷ��嵥�������ɷѰ�ť����,Ȼ���ӡ.<br>
			&nbsp;&nbsp;&nbsp;&nbsp;3 ����ѡ����Ҫ��ѯ���·ݣ�Ȼ�������ڵĵ�Ԫ¥���в�ѯ�������нɷѲ���.<br>
			&nbsp;&nbsp;&nbsp;&nbsp;4 ����ÿҳ��ʾ�������뵽��ҵϵͳ����->�����ֵ�->��ҳ����������������޸�.
		</td>
	</tr>
</table>
</body>
</html>