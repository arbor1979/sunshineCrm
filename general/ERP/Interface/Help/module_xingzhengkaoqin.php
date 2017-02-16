<?

if($_GET['action']==''||$_GET['action']=='init_default')		{
	$PrintText  = "<BR><table  class=TableBlock align=center width=100%>";
	$PrintText .= "<TR class=TableContent><td ><font color=green >
组别：<BR>
&nbsp;&nbsp;①就是行政考勤中有相同上班时间的人员一个集合，一般指某一个领域内人员的分组，如学生管理组（学校中管理学生的岗位如辅导员），行政人员组（如网络中心，电教科等技术岗位），领导组（如一些主任们的分组）。<BR>
&nbsp;&nbsp;②一个分组对应一个班次信息，即在某一时间段内拥有相同的上下班时间。<BR>
&nbsp;&nbsp;③一个分组可以拥有多个人员，一个人员可以加入多个分组。
</font></td></table>";
	print $PrintText;
}

?>