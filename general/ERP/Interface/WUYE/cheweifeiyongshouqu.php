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

	$hostname = "http://" . $_SERVER['SERVER_NAME'] . ":" . $_SERVER['SERVER_PORT'] . "" . $PHP_SELF . "/$FILE_NAME?��Ԫ���=" . $_GET['��Ԫ���'] . "&�������·�=" . $_GET['�������·�']. "&pageAction=write";
	//print_R($hostname);;exit;
	$file = file($hostname);
	$FILE_CONTENT = join('', $file);
	// $handle = fopen($filename, 'w');
	// fwrite($handle, $FILE_CONTENT);
	// fclose($handle);
	header('Content-Encoding: none');
	header('Content-Type: application/octetstream');
	header('Content-Disposition: attachment;filename=��λ��ͳ�Ʊ�.xls');
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
page_css('��λ�ɷ�');

$page = isset($_GET['name'])?intval($_GET['name']):1;

//ÿҳ��ʾ��¼������
$each_sql = "select ÿҳ���� from wu_eachpage";
$num = $db -> Execute($each_sql);
$rs = $num -> GetArray();
$each_page = $rs['0']['ÿҳ����'];

if($_GET['name']=="tingchechang"){
	         
			 //�õ��۳������ƺ����·ݣ�Ȼ�󽫶�Ӧͣ��λѭ�����浽������
			 global $ͣ��������;
			 global $�ɷ����·�;	
			 $ͣ�������� = $_GET['ͣ��������'];
			 $�ɷ����·� = $_GET['�ɷ����·�'];
             //echo $�ɷ����·�;
			 $sel_sql = "select * from wu_tingchewei where ͣ��������='$ͣ��������'";
			 $sel_rs  = $db->Execute($sel_sql);
			 $sel_rs_a = $sel_rs->GetArray();
			 for($i=0;$i<=sizeof($sel_rs_a);$i++){
			     $ͣ��λ���� = $sel_rs_a[$i]['ͣ��λ����'];
				 $ͣ��λ[]=$ͣ��λ����;
			 }
             $queren = "true";
}else{
            //ϵͳĬ����ʾ�ļ�¼����һ����ʽ�õ���ǰ��ʱ��
			$�ɷ����·�	= date("Y-m",mktime(1,1,1,date("m"),date("d"),date("Y")));
			$row_sql = "select COUNT(*) AS sum from wuye_wuyetingchechangguanli where ���ɷ��·�='".$�ɷ����·�."'";
			$row_rs = $db -> Execute($row_sql);
			$total1 = $row_rs -> fields['sum'];

			if($total1>0){		
				$total_page = ceil($total1/$each_page);        
				$page = ($page<1)?1:$page;
				$page = ($page>$total_page)?$total_page:$page;
				$offset = ($page-1)*$each_page;
				$sql = "select * from wuye_wuyetingchechangguanli where ���ɷ��·�='".$�ɷ����·�."' order by ���ɷ��·� desc LIMIT $offset,$each_page";
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
	         <td colspan="">&nbsp;ͣ�������ƣ�&nbsp;&nbsp;&nbsp;
			 <?php

			    //�õ�ͣ��������
				$tingche_sql = "select ͣ�������� from wu_tingchechang where 1=1 order by ͣ�������� asc";
				$tingche_rs = $db->Execute($tingche_sql);
				$tingche_rs_a = $tingche_rs->GetArray();
                
				for($i=0;$i<=sizeof($tingche_rs_a);$i++){
					$ͣ��������X = $tingche_rs_a[$i]['ͣ��������'];
					//if($i%5 == 0) print "<br>";
					if($ͣ��������X==$ͣ��������) $color="red"; else $color = "green";
						
                    print "&nbsp;<a href=\"?".base64_encode("name=tingchechang&ͣ��������=$ͣ��������X")."\"><font color=$color>$ͣ��������X</font></a>\n";
				}
			 ?>

				<B>�ɷ����·ݣ�</B>
				<?php
				//�õ����·�
				$ͣ��������=$_GET['ͣ��������'];
				$name=$_GET['name'];
				$�ɷ����·�array=array();
				for($i=0;$i>=-6;$i--)				{
					$��ǰʱ������	= date("Y-m",mktime(0,0,0,date("m")+$i,1,date("Y")));
					$�ɷ����·�array[]=$��ǰʱ������;
					}	
					if($�ɷ����·�!=null){
					$�ɷ����·�=$_GET['�ɷ����·�'];
					}else{
					$�ɷ����·�=$�ɷ����·�array[0];
					}
					print "<Select name='�ɷ����·�'  onChange=\"var jmpURL='?flag=jump&ͣ��������=$ͣ��������&name=$name&�ɷ����·�=' + this.options[this.selectedIndex].value; if(jmpURL!='') {window.location=jmpURL;} else {this.selectedIndex=0;}\">";
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
		 </td>
     </tr>
</table>
<table class="TableBlock" width="100%" align="center">
	   <tr align="left" class="TableHeader"><td colspan="12">�ɷ���Ϣͳ��(��λ����) [�ܼƣ�<?php echo  $total1?>��]</td></tr>
	   <tr align="center" class="TableHeader">
				 <TD noWrap>���</TD>
				 <TD noWrap>ͣ��λ</TD>
				 <TD noWrap>�������</TD>
				 <TD noWrap>ҵ��</TD>
				 <TD noWrap>��ϵ�绰</TD>
				 <TD noWrap>����</TD>
				 <TD noWrap>�������</TD>
				 <TD noWrap>��λ״̬</TD>
				 <TD noWrap>�ɷ��·�</TD>
				 <TD noWrap>�Ƿ�ɷ�</TD>
				 <TD noWrap>����</TD>
	   </tr>
<?php
/**********
���ύ���������ݽ����жϣ�Ȼ��ѡ�������ʽ
***********/
if($queren = "true"){
	    
		//���õ�������ѭ�����
		foreach((array)$ͣ��λ as $val){
					$rows_sql = "select COUNT(*) AS sum from wuye_wuyetingchechangguanli where ͣ��λ='$val' and ���ɷ��·�='$�ɷ����·�'";
					$rows_rs = $db -> Execute($rows_sql);
					$total = $rows_rs -> fields['sum'];

					if($total>0){						
						$sql = "select * from wuye_wuyetingchechangguanli where ͣ��λ='$val' and ���ɷ��·�='$�ɷ����·�' order by ���ɷ��·� desc";
						$rs = $db -> Execute($sql);
						$rs_a = $rs -> GetArray();			
						for($i=0;$i<sizeof($rs_a);$i++){
							$���       = $rs_a[$i]['���'];
							$ͣ��λ	    = $rs_a[$i]['ͣ��λ'];
							$�������	= $rs_a[$i]['�������'];
							$ҵ��	    = $rs_a[$i]['ҵ��'];
							$��ϵ�绰	= $rs_a[$i]['��ϵ�绰'];
							$����       = $rs_a[$i]['����'];
							$�������	= $rs_a[$i]['�������'];
							$��λ״̬	= $rs_a[$i]['��λ״̬'];
							$�ɷ��·�   = $rs_a[$i]['���ɷ��·�'];
							$�Ƿ�ɷ�   = $rs_a[$i]['�Ƿ�ɷ�'];
                            
							if($�Ƿ�ɷ�==0){
					          $�Ƿ�ɷ�="��";
							  $j = $i+1;
							  print "<tr align=\"center\" class=\"TableData\">
										 <TD noWrap>&nbsp;".$j."</TD>
										 <TD noWrap>&nbsp;<font color=\"blue\">".$ͣ��λ."</font></TD>
										 <TD noWrap>&nbsp;".$�������."</TD>
										 <TD noWrap>&nbsp;".$ҵ��."</TD>
										 <TD noWrap>&nbsp;<font color=\"green\">".$��ϵ�绰."</font></TD>
										 <TD noWrap>&nbsp;".$����."</TD>
										 <TD noWrap>&nbsp;".$�������."</TD>
										 <TD noWrap>&nbsp;<font color=\"green\">".$��λ״̬."</font></TD>
										 <TD noWrap>&nbsp;".$�ɷ��·�."</TD>
										 <TD noWrap>&nbsp;<font color=\"blue\">".$�Ƿ�ɷ�."</font></TD>
										 <TD noWrap>&nbsp;<a class=OrgAdd href=\"wuye1_wuyetingchechangguanli_newai.php?".base64_encode("action=edit_default&���=$���&���_NAME=$���&���_disabled=disabled")."\">����ɷ�</a>&nbsp;<a class=OrgAdd href=\"cheweifeibaobiao.php?action=fxp&���=$���\">��ӡ��ϸ</a></TD>
									  </tr>";
							}else if($�Ƿ�ɷ�==1){
					            $�Ƿ�ɷ�="��";
								$j = $i+1;
								print "<tr align=\"center\" class=\"TableData\">
										 <TD noWrap>&nbsp;".$j."</TD>
										 <TD noWrap>&nbsp;<font color=\"blue\">".$ͣ��λ."</font></TD>
										 <TD noWrap>&nbsp;".$�������."</TD>
										 <TD noWrap>&nbsp;".$ҵ��."</TD>
										 <TD noWrap>&nbsp;<font color=\"green\">".$��ϵ�绰."</font></TD>
										 <TD noWrap>&nbsp;".$����."</TD>
										 <TD noWrap>&nbsp;".$�������."</TD>
										 <TD noWrap>&nbsp;<font color=\"green\">".$��λ״̬."</font></TD>
										 <TD noWrap>&nbsp;".$�ɷ��·�."</TD>
										 <TD noWrap>&nbsp;<font color=\"red\">".$�Ƿ�ɷ�."</font></TD>
										 <TD noWrap>&nbsp;<a class=OrgAdd href=\"#\" onClick=\"return confirm('���·����ѽ�!')\">����ɷ�</a>&nbsp;<a class=OrgAdd href=\"cheweifeibaobiao.php?action=fxp&���=$���\">��ӡ��ϸ</a></TD>
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
					$ͣ��λ	    = $rs_aa[$i]['ͣ��λ'];
					$�������	= $rs_aa[$i]['�������'];
					$ҵ��	    = $rs_aa[$i]['ҵ��'];
					$��ϵ�绰	= $rs_aa[$i]['��ϵ�绰'];
					$����       = $rs_aa[$i]['����'];
					$�������	= $rs_aa[$i]['�������'];
					$��λ״̬	= $rs_aa[$i]['��λ״̬'];
					$�ɷ��·�   = $rs_aa[$i]['���ɷ��·�'];
					$�Ƿ�ɷ�   = $rs_aa[$i]['�Ƿ�ɷ�'];
                    if($�Ƿ�ɷ�==0){
					   $�Ƿ�ɷ�="��";
					   $j = $i+1;
					   print "<tr align=\"center\" class=\"TableData\">
								 <TD noWrap>&nbsp;".$j."</TD>
								 <TD noWrap>&nbsp;<font color=\"blue\">".$ͣ��λ."</font></TD>
								 <TD noWrap>&nbsp;".$�������."</TD>
								 <TD noWrap>&nbsp;".$ҵ��."</TD>
								 <TD noWrap>&nbsp;<font color=\"green\">".$��ϵ�绰."</font></TD>
								 <TD noWrap>&nbsp;".$����."</TD>
								 <TD noWrap>&nbsp;".$�������."</TD>
								 <TD noWrap>&nbsp;<font color=\"green\">".$��λ״̬."</font></TD>
								 <TD noWrap>&nbsp;".$�ɷ��·�."</TD>
								 <TD noWrap>&nbsp;<font color=\"blue\">".$�Ƿ�ɷ�."</font></TD>
                                 <TD noWrap>&nbsp;<a class=OrgAdd href=\"wuye1_wuyetingchechangguanli_newai.php?".base64_encode("action=edit_default&���=$���&���_NAME=$���&���_disabled=disabled")."\">����ɷ�</a>&nbsp;<a class=OrgAdd href=\"cheweifeibaobiao.php?action=fxp&���=$���\">��ӡ��ϸ</a></TD>
							   </tr>";
					}else if($�Ƿ�ɷ�==1){
					   $�Ƿ�ɷ�="��";
					   $j = $i+1;
					   print "<tr align=\"center\" class=\"TableData\">
								 <TD noWrap>&nbsp;".$j."</TD>
								 <TD noWrap>&nbsp;<font color=\"blue\">".$ͣ��λ."</font></TD>
								 <TD noWrap>&nbsp;".$�������."</TD>
								 <TD noWrap>&nbsp;".$ҵ��."</TD>
								 <TD noWrap>&nbsp;<font color=\"green\">".$��ϵ�绰."</font></TD>
								 <TD noWrap>&nbsp;".$����."</TD>
								 <TD noWrap>&nbsp;".$�������."</TD>
								 <TD noWrap>&nbsp;<font color=\"green\">".$��λ״̬."</font></TD>
								 <TD noWrap>&nbsp;".$�ɷ��·�."</TD>
								 <TD noWrap>&nbsp;<font color=\"red\">".$�Ƿ�ɷ�."</font></TD>
                                 
								 
                                 <TD noWrap>&nbsp;<a class=OrgAdd href=\"#\" onClick=\"return confirm('���·����ѽ�!')\">����ɷ�</a>&nbsp;<a class=OrgAdd href=\"cheweifeibaobiao.php?action=fxp&���=$���\">��ӡ��ϸ</a></TD>
							   </tr>";
				  }
		}

?>  
<!-- 
���´����ǽ���ҳ�浼����ť����Ĭ�����ݽ��з�ҳ����
-->
    <tr align="center" class="tableContent">
	     <td colspan="12" >
		 <INPUT TYPE="button" VALUE="����" class="SmallButton"  align="left" ONCLICK="location='?pageAction=ExportDataToFile&��Ԫ���=<?php echo $_GET['�������']?>&�������·�=<?php echo $_GET['�ɷ����·�']?>'">
		 <?php 
		 
		 if($total1>0){
		 echo sprintf("��%d����¼ %d/%dҳ",$total1,$page,$total_page)."&nbsp;&nbsp;";
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
		<td noWrap colspan="12" align=left>
		<font color="green">˵����</font><br>
			&nbsp;&nbsp;&nbsp;&nbsp;1 ��ҳ���ǲ�ѯ���ó�λ�ɷ�����б�<font color="red">������ <?php if($_GET['name']=="tingchechang"){
				echo $�ɷ����·�;
		    }else{
		        $ʱ�� = date("Y-m",mktime(1,1,1,date("m"),date("d"),date("Y")));
		        echo $ʱ��;
		    }?> ������</font>.<br>
			&nbsp;&nbsp;&nbsp;&nbsp;2 �����Ӧ�ĳ�λ���ڵ�ͣ�����ͽɷ�ʱ�䣬������Ӧ��ͣ��������ͣ��λ�Ľɷ�����б�.<br>
			&nbsp;&nbsp;&nbsp;&nbsp;3 �������Ĳ������ܹ����нɷѡ���ӡ�˵���.<br>
			&nbsp;&nbsp;&nbsp;&nbsp;4 ����ÿҳ��ʾ�������뵽��ҵϵͳ����->�����ֵ�->��ҳ����������������޸�.
		</td>
	</tr>
</table>
</body>
</html>