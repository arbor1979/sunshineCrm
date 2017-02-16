<?

if($_GET['action']==''||$_GET['action']=='init_default'||$_GET['action']=='init_customer')		{
	$PrintText  = "<BR><table  class=TableBlock align=center width=100%>";
	$PrintText .= "<TR class=TableContent><td ><font color=green >

流程明细：<BR>
&nbsp;&nbsp;①就是行政考勤里面涉及到工作流，并由工作流产生数据部分的明细。<BR>
&nbsp;&nbsp;②主要操作由考勤补登，请假外出，加班补休，调休补班，调班记录，相互调班等。



</font></td></table>";
	print $PrintText;
}


?>