<?

if($_GET['action']==''||$_GET['action']=='init_default')		{
	$PrintText  = "<BR><table  class=TableBlock align=center width=100%>";
	$PrintText .= "<TR class=TableContent><td ><font color=green >

部门级管理：<BR>
&nbsp;&nbsp;①指的就是特定一班次信息，如上午班，指定由某一人员进行管理，并且只能管理已授权的班次信息。<BR>
&nbsp;&nbsp;②设置是在班次模块中的班次管理一和班次管理二两个字段，分配菜单就是在部门级管理部分。<BR>
&nbsp;&nbsp;③可以管理的内容有：考勤数据，行政排班（排属于自己管理的班次）和其它流程性信息如考勤补登，请假外出，加班补休，调休补班，调班记录，相互调班等。


</font></td></table>";
	print $PrintText;
}


?>