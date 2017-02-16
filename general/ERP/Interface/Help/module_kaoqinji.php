<?

if($_GET['action']==''||$_GET['action']=='init_default'||$_GET['action']=='init_customer')		{
	$PrintText  = "<BR><table  class=TableBlock align=center width=100%>";
	$PrintText .= "<TR class=TableContent><td ><font color=green >

打卡说明：<BR>
&nbsp;&nbsp;①打卡数据来自于指纹考勤机的打卡记录。<BR>
&nbsp;&nbsp;②关于集成考勤机的部分一般都需要进行二次开发工作，具体请联系通达中部研发中心。



</font></td></table>";
	print $PrintText;
}

?>